<?php
// /tools/facebook-video-downloader/server/api.php

ini_set('display_errors', 0);
error_reporting(0);
header('Content-Type: application/json; charset=UTF-8');

$msg = [];

try {
    $url = $_REQUEST['url'] ?? '';
    if (empty($url)) throw new Exception('Please provide the URL', 1);

    $headers = [
        'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
        'accept: text/html,application/xhtml+xml',
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $data = curl_exec($ch);
    if ($data === false) throw new Exception("cURL error: " . curl_error($ch));
    curl_close($ch);

    $msg['success']   = true;
    $msg['id']        = generateId($url);
    $msg['title']     = getTitle($data);
    $msg['thumbnail'] = getThumbnail($data);   // ⬅️ thumbnail যোগ করা হলো
    $msg['links']     = [];

    if ($sdLink = getSDLink($data)) $msg['links']['Download SD'] = $sdLink . '&dl=1';
    if ($hdLink = getHDLink($data)) $msg['links']['Download HD'] = $hdLink . '&dl=1';

} catch (Exception $e) {
    $msg['success'] = false;
    $msg['message'] = $e->getMessage();
}

echo json_encode($msg, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
exit;


// --- helpers (repo style) ---
function generateId($url){
    if (preg_match('#(\d+)/?$#', $url, $m)) return $m[1];
    return '';
}

function cleanStr($str){
    // JSON trick দিয়ে \" \/ \n এগুলো unescape করা
    $tmpStr = "{\"text\": \"{$str}\"}";
    $decoded = json_decode($tmpStr);
    return isset($decoded->text) ? $decoded->text : $str;
}

function getSDLink($html){
    if (preg_match('/browser_native_sd_url":"([^"]+)"/', $html, $m)) return cleanStr($m[1]);
    if (preg_match('/sd_src_no_ratelimit":"([^"]+)"/', $html, $m))     return cleanStr($m[1]); // fallback
    return false;
}

function getHDLink($html){
    if (preg_match('/browser_native_hd_url":"([^"]+)"/', $html, $m)) return cleanStr($m[1]);
    if (preg_match('/hd_src_no_ratelimit":"([^"]+)"/', $html, $m))     return cleanStr($m[1]); // fallback
    return false;
}

function getTitle($html){
    // 1. JSON style field: "title":"Some Title"
    if (preg_match('/"title"\s*:\s*"([^"]+)"/', $html, $m)) {
        return cleanStr($m[1]);
    }

    // 2. Preferred caption/title inside JSON
    if (preg_match('/"message"\s*:\s*\{"text":"([^"]+)"/', $html, $m)) {
        return cleanStr($m[1]);
    }

    // 3. Open Graph <meta property="og:title">
    if (preg_match('/<meta[^>]+property=["\']og:title["\'][^>]+content=["\']([^"\']+)["\']/i', $html, $m)) {
        return cleanStr($m[1]);
    }

    // 4. Twitter <meta name="twitter:title">
    if (preg_match('/<meta[^>]+name=["\']twitter:title["\'][^>]+content=["\']([^"\']+)["\']/i', $html, $m)) {
        return cleanStr($m[1]);
    }

    // 5. Fallback: <title> tag
    if (preg_match('/<title>(.*?)<\/title>/i', $html, $m)) {
        return cleanStr($m[1]);
    }

    return null;
}


/**
 * Thumbnail extractors (multiple fallbacks):
 * 1) "thumbnailUrl":"https://..."
 * 2) preferred_thumbnail":{"image":{"uri":"https://..."}}
 * 3) generic "image":{"uri":"https://..."}
 * 4) <meta property="og:image" content="https://...">
 * 5) <meta name="twitter:image" content="https://...">
 */
function getThumbnail($html){
    // JSON-style fields
    if (preg_match('/thumbnailUrl":"([^"]+)"/', $html, $m)) {
        return cleanStr($m[1]);
    }
    if (preg_match('/preferred_thumbnail"\s*:\s*\{\s*"image"\s*:\s*\{\s*"uri"\s*:\s*"([^"]+)"/', $html, $m)) {
        return cleanStr($m[1]);
    }
    if (preg_match('/"image"\s*:\s*\{\s*"uri"\s*:\s*"([^"]+)"/', $html, $m)) {
        return cleanStr($m[1]);
    }

    // Meta tag fallbacks
    if (preg_match('/<meta[^>]+property=["\']og:image["\'][^>]+content=["\']([^"\']+)["\']/i', $html, $m)) {
        return $m[1];
    }
    if (preg_match('/<meta[^>]+name=["\']twitter:image["\'][^>]+content=["\']([^"\']+)["\']/i', $html, $m)) {
        return $m[1];
    }

    return null;
}
