<?php
// Disable time limits for large streaming
set_time_limit(0);

if (!isset($_GET['url']) || !isset($_GET['cookie'])) {
    die("Missing parameters");
}

$url = $_GET['url'];
$cookie = $_GET['cookie'];

// Initialize cURL (streaming)
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Cookie: $cookie",
    "User-Agent: Mozilla/5.0"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
curl_setopt($ch, CURLOPT_BUFFERSIZE, 8192);

// Pass headers directly to the client
curl_setopt($ch, CURLOPT_HEADERFUNCTION, function ($curl, $header) {
    if (stripos($header, "Content-Type:") === 0) {
        header($header);
    }
    if (stripos($header, "Content-Length:") === 0) {
        header($header);
    }
    if (preg_match('/filename="(.+)"/', $header, $m)) {
        header('Content-Disposition: attachment; filename="' . $m[1] . '"');
    }
    return strlen($header);
});

// Stream the file chunk by chunk
curl_setopt($ch, CURLOPT_WRITEFUNCTION, function ($curl, $data) {
    echo $data;
    flush(); // push data to user instantly
    return strlen($data);
});

curl_exec($ch);

if (curl_errno($ch)) {
    echo "Proxy error: " . curl_error($ch);
}

curl_close($ch);
exit;
