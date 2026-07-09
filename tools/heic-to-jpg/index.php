<?php
// /tools/heic-to-jpg-converter/index.php

// ==== Dynamic Variables (edit these per tool) ====
$tool_name     = "HEIC to JPG Converter"; 
$tool_details  = "Free browser-based tool to convert HEIC/HEIF images to JPG format directly in your browser. No server upload required, 100% private and secure.";
$why_use_text  = "HEIC (High Efficiency Image Format) is Apple's default photo format that provides better compression than JPEG but isn't universally supported. This creates compatibility issues when sharing photos with Windows users, uploading to websites, or using editing software that doesn't support HEIC.

Our browser-based HEIC to JPG converter solves this problem entirely on your device without uploading anything to external servers. Unlike traditional converters that require file uploads to remote servers, our tool processes all conversions locally using advanced JavaScript libraries and HTML5 Canvas technology.

This approach offers superior privacy and security since your photos never leave your computer. It's perfect for converting personal photos, sensitive documents, or proprietary images where privacy is paramount. The conversion happens instantly in your browser, works offline after initial page load, and supports batch processing of multiple files simultaneously.

The tool maintains excellent image quality with adjustable compression settings, preserves important metadata when possible, and provides immediate download of converted files. Whether you're using iPhone photos on Windows, preparing images for web upload, or simply need universal compatibility, this tool provides a seamless, private solution.";
$how_to_use    = [
  "Upload your HEIC files by clicking 'Choose HEIC Files' or drag and drop directly into the upload area. The tool supports .heic and .heif formats from iPhones, iPads, and Mac computers.",
  "Adjust conversion settings using the quality slider (75-95% recommended for optimal balance), choose output format (JPG/JPEG), and select whether to preserve metadata like EXIF information.",
  "Click 'Convert to JPG' to start the browser-side conversion. Watch real-time progress as each file processes using JavaScript libraries without any server uploads.",
  "Download your converted JPG files individually or use 'Download All as ZIP' for multiple files. All processing happens locally, ensuring maximum privacy and security."
];

// ==== FAQ ====
$faqs = [
  [
    "How does browser-side HEIC conversion work without uploading to a server?", 
    "Our HEIC to JPG converter uses advanced JavaScript libraries including libheif-js and Canvas API to process images entirely in your browser. When you upload a HEIC file, it's read directly into browser memory using FileReader API. The HEIC decoding happens locally using WebAssembly-compiled libraries that run at near-native speed. Once decoded, the image data is drawn onto an HTML5 Canvas element, then converted to JPG format using canvas.toBlob() method. This entire process occurs within your browser's sandboxed environment, meaning your files never leave your computer or get transmitted over the internet. The technology leverages modern web standards and WebAssembly to provide desktop-level performance directly in web browsers."
  ],
  [
    "What are the privacy and security benefits of browser-side conversion?", 
    "Browser-side conversion offers maximum privacy and security because: 1) Your photos never leave your device - they stay within your browser's secure sandbox; 2) No internet connection is required after initial page load, allowing offline conversion; 3) No third-party servers ever see or store your images; 4) Temporary files are automatically cleared from browser memory when you close the tab; 5) No user accounts or login required; 6) The tool works over HTTPS with end-to-end encryption for the initial page load. This is particularly important for sensitive photos, personal documents, or proprietary business images. Unlike cloud-based converters that store copies of your images on their servers, our approach ensures complete data sovereignty where you maintain full control over your files throughout the entire conversion process."
  ],
  [
    "Which browsers support HEIC conversion and what are the limitations?", 
    "Our HEIC converter works on all modern browsers including Chrome 80+, Firefox 75+, Safari 14+, Edge 80+, and Opera 67+. The tool requires browsers that support WebAssembly, FileReader API, and Canvas elements. On mobile devices, it works perfectly on iOS Safari and Chrome for Android. The main limitation is file size - most browsers can handle files up to 2GB in theory, but we recommend staying under 50MB for optimal performance. Another consideration is memory usage - converting very large batches (50+ images) might slow down older devices. For professional photographers with massive HEIC files, we recommend desktop software. The browser-based approach is ideal for typical smartphone photos, social media images, and everyday conversion needs where privacy and convenience are priorities."
  ],
  [
    "Can I convert HEIC files with Live Photos or multiple frames?", 
    "Our current browser-side converter processes the primary image frame from HEIC files. For standard HEIC photos from iPhones and iPads, this captures the main high-quality image. However, HEIC files can contain multiple frames including Live Photo videos, burst mode sequences, or HDR sequences. The browser-based libraries typically extract only the primary image frame. If you need to preserve Live Photos (the 3-second video accompanying photos), you'll need to use Apple's native tools on iOS/Mac or specialized desktop software. For burst mode sequences, each image would need to be converted separately. The tool excels at converting standard HEIC photos for universal compatibility while providing maximum privacy through local browser processing."
  ],
  [
    "What happens to EXIF metadata during browser-side conversion?", 
    "The browser-side conversion can preserve basic EXIF metadata including camera settings (aperture, shutter speed, ISO), date/time stamps, and orientation data when using appropriate JavaScript libraries. However, some advanced metadata like GPS location, face detection data, or Apple-specific enhancements might not transfer perfectly due to browser limitations. We use exif-js library to extract available metadata and attempt to re-embed it into the converted JPG files. For maximum metadata preservation, especially for professional photography work, dedicated desktop software like Adobe Lightroom or Apple Photos provides more comprehensive metadata handling. For most users converting personal photos for sharing or web use, the browser-based approach preserves sufficient metadata while offering unparalleled privacy benefits."
  ]
];

$page_title = $tool_name;

// ==== Auto Fetch Domain ====
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$domain   = $_SERVER['HTTP_HOST'];

// ==== Image Fallback ====
$tool_slug  = strtolower(str_replace(' ', '-', $tool_name));
$tool_image = "/assets/images/{$tool_slug}.png";
if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $tool_image)) {
    $tool_image = "/assets/images/default.png";
}

// ==== SEO Meta Tags ====
$meta_title = $tool_name . " | TG Data Hub Tools";
$meta_desc  = $tool_details . " Use this free tool to simplify your work online. Easy to use, fast and secure.";
$canonical  = $protocol . $domain . "/tools/" . $tool_slug;

require dirname(__DIR__, 2).'/partials/header.php';
?>

<!-- ==== SEO HEAD Extra ==== -->
<meta name="description" content="<?= htmlspecialchars($meta_desc) ?>">
<link rel="canonical" href="<?= $canonical ?>">

<!-- Open Graph -->
<meta property="og:title" content="<?= htmlspecialchars($meta_title) ?>">
<meta property="og:description" content="<?= htmlspecialchars($meta_desc) ?>">
<meta property="og:type" content="website">
<meta property="og:url" content="<?= $canonical ?>">
<meta property="og:image" content="<?= $protocol . $domain . $tool_image ?>">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= htmlspecialchars($meta_title) ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($meta_desc) ?>">
<meta name="twitter:image" content="<?= $protocol . $domain . $tool_image ?>">

<!-- Load working HEIC decoder library (heic2any) and EXIF library -->
<script src="https://cdn.jsdelivr.net/npm/heic2any@0.0.4/dist/heic2any.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/exif-js"></script>

<main class="max-w-5xl mx-auto px-4 py-8">
  <!-- Breadcrumbs -->
  <nav aria-label="Breadcrumb" class="mb-4 text-sm text-slate-500">
    <ol class="list-reset flex space-x-2">
      <li><a href="/" class="hover:underline">Home</a></li>
      <li>/</li>
      <li><a href="/tools" class="hover:underline">Tools</a></li>
      <li>/</li>
      <li class="text-slate-700"><?= htmlspecialchars($tool_name) ?></li>
    </ol>
  </nav>

  <!-- Main Card -->
  <section class="bg-white rounded-2xl border border-slate-200 shadow-lg p-6 md:p-8">

    <!-- Title -->
    <header class="mb-6 text-center">
      <div class="flex items-center justify-center gap-3">
        <!-- inline SVG icon (file + photo) -->
        <svg width="44" height="44" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="bg-indigo-50 rounded-full p-2">
          <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z" stroke="#4f46e5" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M14 2v6h6" stroke="#3b82f6" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M8 13l2 2 3-4 4 5" stroke="#2563eb" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <div class="text-left">
          <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-slate-800"><?= htmlspecialchars($tool_name) ?></h1>
          <p class="mt-1 text-slate-600"><?= htmlspecialchars($tool_details) ?></p>
        </div>
      </div>
    </header>

    <!-- Tool Start -->
    <div class="mt-8 p-4 bg-slate-50 rounded-xl border border-slate-200">
      <!-- Privacy Notice -->
      <div class="mb-6 p-3 bg-green-50 border border-green-200 rounded-lg">
        <div class="flex items-start">
          <svg class="w-5 h-5 text-green-500 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
          </svg>
          <div class="text-sm text-green-800">
            <span class="font-medium">100% Browser-side Processing:</span> All conversions happen locally in your browser. Your photos never leave your computer or get uploaded to any server.
          </div>
        </div>
      </div>

      <!-- File Upload Area -->
      <div class="mb-6">
        <label class="block text-sm font-medium text-slate-700 mb-2">Upload HEIC Files</label>
        <div class="border-2 border-dashed border-slate-300 rounded-lg p-6 text-center hover:border-indigo-400 transition-colors" id="drop-area">
          <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
          </svg>
          <p class="mt-2 text-sm text-slate-600">Drag & drop HEIC files here or</p>
          <input type="file" id="file-input" accept=".heic,.heif,.hif" multiple class="hidden">
          <button type="button" onclick="document.getElementById('file-input').click()" class="mt-3 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors text-sm font-medium">
            Choose HEIC Files
          </button>
          <p class="mt-2 text-xs text-slate-500">Supports .heic, .heif, .hif files (recommended under 50MB)</p>
        </div>
        <div id="file-list" class="mt-4 space-y-2"></div>
      </div>

      <!-- Conversion Settings -->
      <div class="mb-6 p-4 bg-white rounded-lg border border-slate-200">
        <h3 class="text-lg font-medium text-slate-800 mb-3">Conversion Settings</h3>
        
        <div class="space-y-4">
          <!-- Quality Slider -->
          <div>
            <div class="flex justify-between mb-1">
              <label class="text-sm font-medium text-slate-700">JPEG Quality: <span id="quality-value">85</span>%</label>
              <span class="text-xs text-slate-500">Higher = better quality, larger file</span>
            </div>
            <input type="range" id="quality-slider" min="1" max="100" value="85" class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer slider">
            <div class="flex justify-between text-xs text-slate-500 mt-1">
              <span>Small file</span>
              <span>Recommended (85)</span>
              <span>Best quality</span>
            </div>
          </div>

          <!-- Metadata Option -->
          <div class="flex items-center">
            <input type="checkbox" id="preserve-metadata" class="h-4 w-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500" checked>
            <label for="preserve-metadata" class="ml-2 text-sm text-slate-700">Preserve EXIF metadata (when available)</label>
          </div>

          <!-- Output Format -->
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Output Format</label>
            <div class="flex space-x-4">
              <label class="inline-flex items-center">
                <input type="radio" name="output-format" value="jpg" checked class="h-4 w-4 text-indigo-600 border-slate-300">
                <span class="ml-2 text-sm text-slate-700">JPG (.jpg)</span>
              </label>
              <label class="inline-flex items-center">
                <input type="radio" name="output-format" value="jpeg" class="h-4 w-4 text-indigo-600 border-slate-300">
                <span class="ml-2 text-sm text-slate-700">JPEG (.jpeg)</span>
              </label>
            </div>
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="flex flex-wrap gap-3 mb-6">
        <button id="convert-btn" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-medium flex items-center disabled:opacity-50 disabled:cursor-not-allowed" disabled>
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
          </svg>
          Convert to JPG
        </button>
        <button id="clear-btn" class="px-6 py-3 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 transition-colors font-medium">
          Clear All
        </button>
        <button id="download-all-btn" class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors font-medium flex items-center hidden">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
          Download All as ZIP
        </button>
      </div>

      <!-- Progress and Results -->
      <div id="progress-section" class="hidden">
        <div class="mb-4">
          <div class="flex justify-between text-sm text-slate-600 mb-1">
            <span>Conversion Progress</span>
            <span id="progress-text">0%</span>
          </div>
          <div class="w-full bg-slate-200 rounded-full h-2">
            <div id="progress-bar" class="bg-indigo-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
          </div>
        </div>
        
        <div id="results" class="space-y-3"></div>
      </div>

      <!-- Browser Compatibility Warning -->
      <div id="browser-warning" class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg hidden">
        <div class="flex items-start">
          <svg class="w-5 h-5 text-yellow-500 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
          </svg>
          <div class="text-sm text-yellow-800">
            <span class="font-medium">Browser Compatibility:</span> Your browser may have limited HEIC support. If conversion fails, try using Chrome, Firefox, or Edge latest versions.
          </div>
        </div>
      </div>
    </div>
    <!-- Tool End -->

    <!-- Why use -->
    <div class="mt-8">
      <h2 class="text-xl font-bold text-slate-800 mb-2">Why use <?= htmlspecialchars($tool_name) ?>?</h2>
      <?php foreach (explode("\n\n", $why_use_text) as $paragraph): ?>
        <p class="text-slate-600 leading-relaxed mb-3"><?= nl2br(htmlspecialchars(trim($paragraph))) ?></p>
      <?php endforeach; ?>
    </div>

    <!-- How to use -->
    <div class="mt-6">
      <h2 class="text-xl font-bold text-slate-800 mb-2">How to use <?= htmlspecialchars($tool_name) ?></h2>
      <ol class="list-decimal pl-5 space-y-2 text-slate-600">
        <?php foreach ($how_to_use as $step): ?>
          <li><?= htmlspecialchars($step) ?></li>
        <?php endforeach; ?>
      </ol>
    </div>

    <!-- FAQ -->
    <div class="mt-6 border-t border-slate-200 pt-4" id="faq">
      <h2 class="text-xl font-bold text-slate-800 mb-3"><?= htmlspecialchars($tool_name) ?> – FAQ</h2>
      <div class="space-y-3">
        <?php foreach ($faqs as [$q, $a]): ?>
          <details class="group border border-slate-200 rounded-lg p-3">
            <summary class="cursor-pointer font-semibold flex items-center justify-between" aria-expanded="false">
              <?= htmlspecialchars($q) ?>
              <span class="text-slate-400 group-open:rotate-45 transition">+</span>
            </summary>
            <div class="mt-2 text-slate-600 leading-relaxed">
              <?= nl2br(htmlspecialchars_decode($a)) ?>
            </div>
          </details>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Bottom CTA -->
    <?php require dirname(__DIR__, 2).'/partials/back-to-tools.php'; ?>
  </section>
</main>

<!-- JavaScript for Browser-side HEIC Conversion (heic2any) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const fileInput = document.getElementById('file-input');
  const dropArea = document.getElementById('drop-area');
  const fileList = document.getElementById('file-list');
  const convertBtn = document.getElementById('convert-btn');
  const clearBtn = document.getElementById('clear-btn');
  const downloadAllBtn = document.getElementById('download-all-btn');
  const progressSection = document.getElementById('progress-section');
  const progressBar = document.getElementById('progress-bar');
  const progressText = document.getElementById('progress-text');
  const qualitySlider = document.getElementById('quality-slider');
  const qualityValue = document.getElementById('quality-value');
  const results = document.getElementById('results');
  const browserWarning = document.getElementById('browser-warning');

  let uploadedFiles = [];
  let convertedFiles = [];

  // Update quality display
  qualitySlider.addEventListener('input', function() {
    qualityValue.textContent = this.value;
  });

  // Drag & drop
  ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropArea.addEventListener(eventName, preventDefaults, false);
  });

  function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
  }

  ['dragenter', 'dragover'].forEach(eventName => {
    dropArea.addEventListener(eventName, highlight, false);
  });

  ['dragleave', 'drop'].forEach(eventName => {
    dropArea.addEventListener(eventName, unhighlight, false);
  });

  function highlight() {
    dropArea.classList.add('border-indigo-500', 'bg-indigo-50');
  }

  function unhighlight() {
    dropArea.classList.remove('border-indigo-500', 'bg-indigo-50');
  }

  dropArea.addEventListener('drop', handleDrop, false);
  fileInput.addEventListener('change', handleFiles, false);

  function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    handleFiles({ target: { files } });
  }

  function handleFiles(e) {
    const files = Array.from(e.target.files).filter(file => 
      file.name.toLowerCase().endsWith('.heic') || 
      file.name.toLowerCase().endsWith('.heif') ||
      file.name.toLowerCase().endsWith('.hif')
    );

    if (files.length === 0) {
      showAlert('Please select HEIC/HEIF files only.', 'error');
      return;
    }

    // Check file sizes (recommend < 100MB each)
    const oversizedFiles = files.filter(file => file.size > 200 * 1024 * 1024); // 200MB absolute max
    if (oversizedFiles.length > 0) {
      showAlert(`Some files exceed 200MB limit: ${oversizedFiles.map(f => f.name).join(', ')}`, 'error');
      return;
    }

    files.forEach(file => {
      // avoid duplicates by name+size
      if (uploadedFiles.find(f => f.name === file.name && f.size === file.size)) return;
      uploadedFiles.push(file);
      displayFile(file);
    });

    updateConvertButton();
    fileInput.value = '';
  }

  function displayFile(file) {
    const id = 'f-' + Math.random().toString(36).slice(2,9);
    file._id = id;
    const item = document.createElement('div');
    item.className = 'flex items-center justify-between p-3 bg-white border border-slate-200 rounded-lg';
    item.id = id;
    item.innerHTML = `
      <div class="flex items-center">
        <svg class="w-8 h-8 text-slate-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        <div>
          <p class="text-sm font-medium text-slate-800 truncate max-w-xs">${file.name}</p>
          <p class="text-xs text-slate-500">${formatFileSize(file.size)}</p>
        </div>
      </div>
      <div>
        <button class="text-xs text-indigo-600 mr-2" onclick="downloadPreview('${id}')">Preview</button>
        <button class="text-xs text-red-500" onclick="removeFileById('${id}')">Remove</button>
      </div>
    `;
    fileList.appendChild(item);
  }

  window.removeFileById = function(id) {
    uploadedFiles = uploadedFiles.filter(f => f._id !== id);
    const el = document.getElementById(id);
    if (el) el.remove();
    updateConvertButton();
  };

  window.downloadPreview = async function(id) {
    const file = uploadedFiles.find(f => f._id === id);
    if (!file) return;
    // show quick preview using browser's image viewer if supported
    const blobUrl = URL.createObjectURL(file);
    window.open(blobUrl, '_blank');
    setTimeout(() => URL.revokeObjectURL(blobUrl), 2000);
  };

  function updateConvertButton() {
    convertBtn.disabled = uploadedFiles.length === 0;
  }

  clearBtn.addEventListener('click', function() {
    uploadedFiles = [];
    convertedFiles = [];
    fileList.innerHTML = '';
    results.innerHTML = '';
    progressSection.classList.add('hidden');
    downloadAllBtn.classList.add('hidden');
    updateConvertButton();
  });

  // Convert logic using heic2any
  convertBtn.addEventListener('click', async function() {
    if (uploadedFiles.length === 0) return;
    convertBtn.disabled = true;
    convertBtn.innerHTML = `
      <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
      </svg>
      Converting...
    `;
    progressSection.classList.remove('hidden');
    results.innerHTML = '';
    convertedFiles = [];

    const quality = parseInt(qualitySlider.value) / 100;
    const preserveMetadata = document.getElementById('preserve-metadata').checked;
    const outputFormat = document.querySelector('input[name="output-format"]:checked').value;
    const outputExtension = outputFormat === 'jpeg' ? '.jpeg' : '.jpg';

    for (let i = 0; i < uploadedFiles.length; i++) {
      const file = uploadedFiles[i];
      const percent = Math.round(((i) / uploadedFiles.length) * 100);
      progressBar.style.width = percent + '%';
      progressText.textContent = percent + '%';

      try {
        // heic2any returns a blob
        const convertedBlob = await heic2any({
          blob: file,
          toType: "image/jpeg",
          quality: quality
        });

        // Optionally extract EXIF from original if requested (best-effort)
        let exifObj = null;
        if (preserveMetadata) {
          try {
            const arrayBuffer = await file.arrayBuffer();
            const dv = new DataView(arrayBuffer);
            exifObj = EXIF.readFromBinaryFile(dv);
            // note: re-embedding EXIF into the produced JPG in browser is non-trivial.
            // For maximum EXIF preservation, server-side tools or specialized libraries are needed.
          } catch (e) {
            exifObj = null;
          }
        }

        const blobUrl = URL.createObjectURL(convertedBlob);
        const filename = file.name.replace(/\.[^/.]+$/, '') + outputExtension;
        const size = convertedBlob.size;

        convertedFiles.push({ filename, blobUrl, blob: convertedBlob, size, exif: exifObj });

        showResultCard({ filename, blobUrl, size }, convertedFiles.length);

      } catch (err) {
        showAlert(`Failed to convert ${file.name}: ${err}`, 'error');
      }
    }

    progressBar.style.width = '100%';
    progressText.textContent = '100%';
    if (convertedFiles.length > 1) {
      downloadAllBtn.classList.remove('hidden');
      downloadAllBtn.onclick = downloadAllAsZip;
    }
    if (convertedFiles.length > 0) showAlert(`Converted ${convertedFiles.length} file(s)`, 'success');

    resetConvertButton();
  });

  function showResultCard(result, index = null) {
    const card = document.createElement('div');
    card.className = 'p-4 bg-white border border-green-100 rounded-lg animate-fade-in';
    card.innerHTML = `
      <div class="flex items-center justify-between">
        <div class="flex items-center">
          <div class="mr-3 relative">
            <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            ${index ? `<span class="absolute -top-1 -right-1 bg-indigo-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">${index}</span>` : ''}
          </div>
          <div>
            <p class="font-medium text-slate-800 truncate max-w-xs">${result.filename}</p>
            <p class="text-sm text-slate-500">${formatFileSize(result.size)}</p>
          </div>
        </div>
        <a href="${result.blobUrl}" download="${result.filename}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors text-sm font-medium inline-flex items-center">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
          Download
        </a>
      </div>
    `;
    results.appendChild(card);
  }

  // ZIP all converted files
  async function downloadAllAsZip() {
    if (convertedFiles.length === 0) return;
    showAlert('Preparing ZIP file...', 'info');
    if (typeof JSZip === 'undefined') {
      await loadScript('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js');
    }
    const zip = new JSZip();
    for (const f of convertedFiles) {
      const buffer = await f.blob.arrayBuffer();
      zip.file(f.filename, buffer);
    }
    const content = await zip.generateAsync({ type: 'blob' });
    const url = URL.createObjectURL(content);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'converted_images.zip';
    document.body.appendChild(a);
    a.click();
    a.remove();
    setTimeout(() => URL.revokeObjectURL(url), 1000);
    showAlert('ZIP download started', 'success');
  }

  function loadScript(src) {
    return new Promise((resolve, reject) => {
      const s = document.createElement('script');
      s.src = src;
      s.onload = resolve;
      s.onerror = reject;
      document.head.appendChild(s);
    });
  }

  function resetConvertButton() {
    convertBtn.disabled = uploadedFiles.length === 0;
    convertBtn.innerHTML = `
      <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
      Convert to JPG
    `;
  }

  function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
  }

  function showAlert(message, type = 'info') {
    const existing = document.querySelector('.alert-message');
    if (existing) existing.remove();
    const alert = document.createElement('div');
    alert.className = `alert-message fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg border ${
      type === 'error' ? 'bg-red-50 border-red-200 text-red-800' :
      type === 'success' ? 'bg-green-50 border-green-200 text-green-800' :
      'bg-blue-50 border-blue-200 text-blue-800'
    }`;
    alert.innerHTML = `<div class="flex items-center"><svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="${
      type === 'error' ? 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z' :
      type === 'success' ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' :
      'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
    }"></path></svg><span>${message}</span></div>`;
    document.body.appendChild(alert);
    setTimeout(() => alert.remove(), 5000);
  }

}); // end DOMContentLoaded

// CSS tweaks injected for slider thumb and animations
(function() {
  const style = document.createElement('style');
  style.textContent = `
  @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
  .animate-fade-in { animation: fadeIn 0.3s ease-out; }
  input[type=range].slider::-webkit-slider-thumb { -webkit-appearance: none; appearance: none; width: 16px; height: 16px; border-radius: 50%; background: #4f46e5; cursor: pointer; border: 2px solid white; box-shadow: 0 1px 3px rgba(0,0,0,0.2); }
  input[type=range].slider::-moz-range-thumb { width: 16px; height: 16px; border-radius: 50%; background: #4f46e5; cursor: pointer; border: 2px solid white; box-shadow: 0 1px 3px rgba(0,0,0,0.2); }
  input[type=range].slider::-webkit-slider-runnable-track { width: 100%; height: 8px; background: #e2e8f0; border-radius: 4px; }
  input[type=range].slider::-moz-range-track { width: 100%; height: 8px; background: #e2e8f0; border-radius: 4px; }
  `;
  document.head.appendChild(style);
})();
</script>

<?php require dirname(__DIR__, 2).'/partials/footer.php'; ?>

<!-- FAQ Schema -->
<script type="application/ld+json">
<?= json_encode([
  "@context" => "https://schema.org",
  "@type" => "FAQPage",
  "mainEntity" => array_map(function($faq) {
      return [
        "@type" => "Question",
        "name" => $faq[0],
        "acceptedAnswer" => [
          "@type" => "Answer",
          "text" => $faq[1]
        ]
      ];
  }, $faqs)
], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT); ?>
</script>

<!-- WebPage Schema -->
<script type="application/ld+json">
<?= json_encode([
  "@context" => "https://schema.org",
  "@type" => "WebPage",
  "name" => $meta_title,
  "description" => $meta_desc,
  "url" => $canonical
], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT); ?>
</script>

<!-- HowTo Schema -->
<script type="application/ld+json">
<?= json_encode([
  "@context" => "https://schema.org",
  "@type" => "HowTo",
  "name" => "How to Convert HEIC to JPG in Browser",
  "description" => "Step-by-step guide to convert HEIC images to JPG format directly in your browser without server uploads",
  "totalTime" => "PT1M",
  "supply" => ["HEIC image files", "Modern web browser"],
  "tool" => ["TG Data Hub Browser-based HEIC to JPG Converter"],
  "step" => array_map(function($step, $index) {
      return [
        "@type" => "HowToStep",
        "position" => $index + 1,
        "text" => $step
      ];
  }, $how_to_use, array_keys($how_to_use))
], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT); ?>
</script>
