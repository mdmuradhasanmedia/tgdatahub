<?php
// error handling disable for cleaner JSON
error_reporting(0);
ini_set('display_errors', 0);

// জিপ এবং জিডি এক্সটেনশন চেক
if (!extension_loaded('zip')) {
    die(json_encode(['success' => false, 'error' => 'PHP zip extension required']));
}
if (!extension_loaded('gd')) {
    die(json_encode(['success' => false, 'error' => 'PHP gd extension required']));
}

class PPTXGammaRemover {
    private $tempDir;
    private $referenceImageHash = null;
    private $removedCount = 0;
    
    public function __construct() {
        $this->tempDir = __DIR__ . '/temp_' . uniqid();
        if (!file_exists($this->tempDir)) {
            mkdir($this->tempDir, 0777, true);
        }
    }
    
    // ইমেজ হ্যাশ জেনারেট (perceptual hash)
    public function getImageHash($imagePath) {
        try {
            $imageData = file_get_contents($imagePath);
            if (!$imageData) return null;
            
            $img = imagecreatefromstring($imageData);
            if (!$img) return null;
            
            // 32x32 তে রিসাইজ
            $resized = imagecreatetruecolor(32, 32);
            imagecopyresampled($resized, $img, 0, 0, 0, 0, 32, 32, imagesx($img), imagesy($img));
            
            // গ্রেস্কেল + হ্যাশ জেনারেট
            $hash = '';
            for ($y = 0; $y < 32; $y++) {
                for ($x = 0; $x < 32; $x++) {
                    $rgb = imagecolorat($resized, $x, $y);
                    $r = ($rgb >> 16) & 0xFF;
                    $g = ($rgb >> 8) & 0xFF;
                    $b = $rgb & 0xFF;
                    $brightness = ($r + $g + $b) / 3;
                    $hash .= ($brightness > 128) ? '1' : '0';
                }
            }
            
            imagedestroy($img);
            imagedestroy($resized);
            return $hash;
        } catch (Exception $e) {
            return null;
        }
    }
    
    // দুইটা হ্যাশ তুলনা
    private function compareHashes($hash1, $hash2, $tolerance = 100) {
        if (!$hash1 || !$hash2) return false;
        $diff = 0;
        $len = min(strlen($hash1), strlen($hash2));
        for ($i = 0; $i < $len; $i++) {
            if ($hash1[$i] !== $hash2[$i]) $diff++;
        }
        return $diff <= $tolerance;
    }
    
    // রেফারেন্স ইমেজ সেট করুন
    public function setReferenceImage($source, $isUrl = false) {
        try {
            if ($isUrl) {
                $ch = curl_init($source);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                $imageData = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                
                if ($httpCode !== 200 || !$imageData) return false;
                
                $ext = 'png';
                $tempPath = $this->tempDir . '/ref_image.' . $ext;
                file_put_contents($tempPath, $imageData);
            } else {
                $tempPath = $source;
            }
            
            $this->referenceImageHash = $this->getImageHash($tempPath);
            return $this->referenceImageHash !== null;
        } catch (Exception $e) {
            return false;
        }
    }
    
    // PPTX থেকে ইমেজ বের করে চেক করা
    private function processSlideXML($xmlPath) {
        $xmlContent = file_get_contents($xmlPath);
        if (!$xmlContent) return false;
        
        $dom = new DOMDocument();
        $dom->loadXML($xmlContent);
        
        $xpath = new DOMXPath($dom);
        $xpath->registerNamespace('p', 'http://schemas.openxmlformats.org/presentationml/2006/main');
        $xpath->registerNamespace('a', 'http://schemas.openxmlformats.org/drawingml/2006/main');
        $xpath->registerNamespace('r', 'http://schemas.openxmlformats.org/officeDocument/2006/relationships');
        
        // সব পিকচার শেপ খোঁজা
        $pictures = $xpath->query('//p:pic');
        $modified = false;
        
        foreach ($pictures as $picture) {
            $blip = $xpath->query('.//a:blip', $picture)->item(0);
            if ($blip && $blip->hasAttribute('r:embed')) {
                $imageId = $blip->getAttribute('r:embed');
                
                // media ফাইল খোঁজা
                $mediaDir = $this->tempDir . "/ppt/media/";
                if (is_dir($mediaDir)) {
                    $mediaFiles = glob($mediaDir . "*");
                    foreach ($mediaFiles as $mediaPath) {
                        if (is_file($mediaPath)) {
                            $imageHash = $this->getImageHash($mediaPath);
                            if ($this->compareHashes($imageHash, $this->referenceImageHash, 80)) {
                                $picture->parentNode->removeChild($picture);
                                $modified = true;
                                $this->removedCount++;
                                break;
                            }
                        }
                    }
                }
            }
        }
        
        if ($modified) {
            $dom->formatOutput = true;
            file_put_contents($xmlPath, $dom->saveXML());
        }
        
        return $modified;
    }
    
    // মেইন ফাংশন - PPTX প্রসেস করা
    public function processPPTX($inputFile, $outputFile) {
        try {
            // PPTX ফাইল আনজিপ
            $zip = new ZipArchive();
            if ($zip->open($inputFile) !== true) {
                throw new Exception("PPTX খোলা যায়নি");
            }
            $zip->extractTo($this->tempDir);
            $zip->close();
            
            // সব স্লাইড XML ফাইল খোঁজা
            $slideFiles = glob($this->tempDir . "/ppt/slides/*.xml");
            $layoutFiles = glob($this->tempDir . "/ppt/slideLayouts/*.xml");
            $masterFiles = glob($this->tempDir . "/ppt/slideMasters/*.xml");
            
            $allXmlFiles = array_merge($slideFiles, $layoutFiles, $masterFiles);
            
            foreach ($allXmlFiles as $xmlFile) {
                if (is_file($xmlFile)) {
                    $this->processSlideXML($xmlFile);
                }
            }
            
            // নতুন PPTX তৈরি
            $newZip = new ZipArchive();
            if ($newZip->open($outputFile, ZipArchive::CREATE) !== true) {
                throw new Exception("আউটপুট ফাইল তৈরি করতে পারেনি");
            }
            
            // সব ফাইল আবার জিপে যোগ
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($this->tempDir),
                RecursiveIteratorIterator::LEAVES_ONLY
            );
            
            foreach ($files as $name => $file) {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($this->tempDir) + 1);
                    $newZip->addFile($filePath, $relativePath);
                }
            }
            
            $newZip->close();
            
            return $this->removedCount;
            
        } catch (Exception $e) {
            throw $e;
        }
    }
    
    public function cleanup() {
        if (file_exists($this->tempDir)) {
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($this->tempDir, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::CHILD_FIRST
            );
            foreach ($files as $fileinfo) {
                $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
                $todo($fileinfo->getRealPath());
            }
            rmdir($this->tempDir);
        }
    }
    
    public function getRemovedCount() {
        return $this->removedCount;
    }
}

// API এন্ডপয়েন্ট হ্যান্ডলার - শুধু POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    
    try {
        // চেক করুন PPTX ফাইল আছে কিনা
        if (!isset($_FILES['pptx']) || $_FILES['pptx']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("PPTX ফাইল আপলোড করুন");
        }
        
        $remover = new PPTXGammaRemover();
        
        // রেফারেন্স ইমেজ সেট করা (URL থেকে)
        $imageUrl = isset($_POST['image_url']) ? trim($_POST['image_url']) : '';
        $success = false;
        
        if (!empty($imageUrl)) {
            $success = $remover->setReferenceImage($imageUrl, true);
            if (!$success) {
                throw new Exception("URL থেকে ইমেজ লোড করতে পারেনি: " . $imageUrl);
            }
        } else {
            throw new Exception("Gamma লোগোর ইমেজ URL দিন");
        }
        
        // PPTX প্রসেস করা
        $inputFile = $_FILES['pptx']['tmp_name'];
        $outputFile = __DIR__ . '/cleaned_' . uniqid() . '.pptx';
        
        $removedCount = $remover->processPPTX($inputFile, $outputFile);
        
        // ফাইল সাইজ চেক
        if (!file_exists($outputFile) || filesize($outputFile) == 0) {
            throw new Exception("প্রসেসিং failed - আউটপুট ফাইল তৈরি হয়নি");
        }
        
        $downloadToken = base64_encode($outputFile);
        
        echo json_encode([
            'success' => true,
            'removed_count' => $removedCount,
            'download_token' => $downloadToken,
            'message' => "{$removedCount}টি Gamma ইমেজ রিমুভ হয়েছে"
        ]);
        
        $remover->cleanup();
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
    exit;
}

// ডাউনলোড হ্যান্ডলার
if (isset($_GET['download']) && isset($_GET['token'])) {
    $file = base64_decode($_GET['token']);
    if (file_exists($file) && strpos($file, __DIR__) === 0) {
        header('Content-Type: application/vnd.openxmlformats-officedocument.presentationml.presentation');
        header('Content-Disposition: attachment; filename="cleaned_' . date('Y-m-d') . '.pptx"');
        header('Content-Length: ' . filesize($file));
        header('Cache-Control: private, max-age=0, must-revalidate');
        readfile($file);
        
        // ডাউনলোডের পর ডিলিট করার জন্য queue
        register_shutdown_function(function() use ($file) {
            @unlink($file);
        });
        exit;
    } else {
        die("File not found");
    }
}
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP PPTX Gamma Remover</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        h1 {
            color: #333;
            margin-bottom: 8px;
        }
        .subtitle {
            color: #666;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 24px;
        }
        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }
        input[type="text"], input[type="file"] {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s;
        }
        input[type="text"]:focus, input[type="file"]:focus {
            outline: none;
            border-color: #667eea;
        }
        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: transform 0.2s;
        }
        .btn:hover:not(:disabled) {
            transform: translateY(-2px);
        }
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        .status {
            padding: 15px 20px;
            border-radius: 12px;
            margin-top: 20px;
            display: none;
            font-size: 14px;
        }
        .status.success {
            display: block;
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .status.error {
            display: block;
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .status.info {
            display: block;
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        .loader {
            display: none;
            text-align: center;
            margin-top: 20px;
            padding: 20px;
        }
        .loader.show {
            display: block;
        }
        .spinner {
            width: 40px;
            height: 40px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 10px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .info-box {
            background: #f0f0ff;
            padding: 15px;
            border-radius: 12px;
            margin-top: 20px;
            font-size: 13px;
            color: #555;
        }
        .info-box strong {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🗑️ PPTX Gamma Remover</h1>
        <div class="subtitle">PHP ব্যাকএন্ড দিয়ে Gamma লোগো রিমুভ করুন</div>
        
        <form id="uploadForm" enctype="multipart/form-data">
            <div class="form-group">
                <label>🔗 Gamma লোগোর ইমেজ URL</label>
                <input type="text" id="imageUrl" placeholder="https://example.com/gamma-logo.png" required>
                <small style="color: #666; display: block; margin-top: 5px;">আপনার "Made with GAMMA" ইমেজের URL দিন</small>
            </div>
            
            <div class="form-group">
                <label>📁 PPTX ফাইল</label>
                <input type="file" id="pptx" accept=".pptx" required>
            </div>
            
            <button type="submit" class="btn" id="submitBtn">Gamma রিমুভ করুন</button>
        </form>
        
        <div class="loader" id="loader">
            <div class="spinner"></div>
            <div>প্রসেসিং হচ্ছে, দয়া করে অপেক্ষা করুন...</div>
        </div>
        
        <div class="status" id="status"></div>
        
        <div class="info-box">
            <strong>ℹ️ কিভাবে কাজ করে:</strong><br>
            1. আপনার Gamma লোগোর ইমেজ URL দিন<br>
            2. PPTX ফাইল আপলোড করুন<br>
            3. PHP ইমেজ হ্যাশ ম্যাচিং করে সব স্লাইড থেকে লোগো রিমুভ করবে
        </div>
    </div>
    
    <script>
        const form = document.getElementById('uploadForm');
        const loader = document.getElementById('loader');
        const statusDiv = document.getElementById('status');
        const submitBtn = document.getElementById('submitBtn');
        
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const pptxFile = document.getElementById('pptx').files[0];
            if (!pptxFile) {
                showStatus('❌ PPTX ফাইল সিলেক্ট করুন', 'error');
                return;
            }
            
            const imageUrl = document.getElementById('imageUrl').value.trim();
            if (!imageUrl) {
                showStatus('❌ Gamma লোগোর ইমেজ URL দিন', 'error');
                return;
            }
            
            const formData = new FormData();
            formData.append('pptx', pptxFile);
            formData.append('image_url', imageUrl);
            
            loader.classList.add('show');
            submitBtn.disabled = true;
            showStatus('⏳ প্রসেসিং শুরু হচ্ছে...', 'info');
            
            try {
                const response = await fetch(window.location.href, {
                    method: 'POST',
                    body: formData
                });
                
                const text = await response.text();
                
                // চেক করুন response টা valid JSON কিনা
                let data;
                try {
                    data = JSON.parse(text);
                } catch(e) {
                    console.error('Invalid JSON:', text);
                    throw new Error('সার্ভার থেকে ভুল রেসপন্স এসেছে। PHP সঠিকভাবে কাজ করছে না।');
                }
                
                if (data.success) {
                    showStatus(`✅ ${data.message}`, 'success');
                    
                    // ডাউনলোড লিংক তৈরি
                    if (data.download_token) {
                        const downloadUrl = window.location.href + '?download=1&token=' + encodeURIComponent(data.download_token);
                        const link = document.createElement('a');
                        link.href = downloadUrl;
                        link.download = 'cleaned.pptx';
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    }
                } else {
                    showStatus(`❌ ${data.error}`, 'error');
                }
            } catch (error) {
                showStatus(`❌ ${error.message}`, 'error');
                console.error(error);
            } finally {
                loader.classList.remove('show');
                submitBtn.disabled = false;
            }
        });
        
        function showStatus(msg, type) {
            statusDiv.textContent = msg;
            statusDiv.className = `status ${type}`;
        }
    </script>
</body>
</html>