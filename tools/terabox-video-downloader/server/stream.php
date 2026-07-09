<?php
// Final Terabox Streaming Proxy
set_time_limit(0);

// Ensure inputs exist
if (!isset($_GET['url']) || !isset($_GET['cookie'])) {
    die("Missing parameters");
}

$url = $_GET['url'];
$cookie = $_GET['cookie'];

// --- FIX 1: Ensure NDUS is raw and valid ---
$cookie = trim(urldecode($cookie));   // Remove URL encoding (%3D → =)
if (!str_ends_with($cookie, ";")) {
    $cookie .= ";"; // Required for Terabox parsing
}

// --- FIX 2: Build request headers ---
$headers = [
    "User-Agent: Mozilla/5.0",
    "Cookie: $cookie"
];

// Pass video seeking requests
if (isset($_SERVER['HTTP_RANGE'])) {
    $headers[] = "Range: " . $_SERVER['HTTP_RANGE'];
}

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
curl_setopt($ch, CURLOPT_TIMEOUT, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);

// --- FIX 3: Preserve video headers, remove download forcing ---
curl_setopt($ch, CURLOPT_HEADERFUNCTION, function ($curl, $header) {
    $h = strtolower($header);

    // Correct content type from Terabox
    if (str_contains($h, "content-type")) {
        header("Content-Type: video/mp4"); // Force playable type
        return strlen($header);
    }

    // Required for buffering & seeking
    if (
        str_contains($h, "content-length") ||
        str_contains($h, "accept-ranges") ||
        str_contains($h, "content-range")
    ) {
        header($header);
        return strlen($header);
    }

    // REMOVE forced download
    if (str_contains($h, "content-disposition")) {
        header("Content-Disposition: inline");
        return strlen($header);
    }

    return strlen($header);
});

// --- FIX 4: Stream chunks directly ---
curl_setopt($ch, CURLOPT_WRITEFUNCTION, function ($curl, $data) {
    echo $data;
    flush();
    return strlen($data);
});

curl_exec($ch);

// --- Error catching (optional) ---
if ($err = curl_error($ch)) {
    error_log("Terabox stream error: $err");
}

curl_close($ch);
exit;
?>
