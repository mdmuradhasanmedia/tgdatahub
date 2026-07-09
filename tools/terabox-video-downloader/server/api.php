<?php
// Simple TeraSnap Proxy API (100% working version)

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$link = $_POST['link'] ?? null;
$cookie = $_POST['cookie'] ?? null;
$use_proxy = isset($_POST['use_proxy']) && $_POST['use_proxy'] == '1';

if (!$link || !$cookie) {
    echo json_encode(['error' => 'Missing link or cookie']);
    exit;
}

if (!filter_var($link, FILTER_VALIDATE_URL)) {
    echo json_encode(['error' => 'Invalid link']);
    exit;
}

$apiUrl = 'https://terasnap.netlify.app/api/download';

$payload = json_encode([
    'link' => $link,
    'cookies' => $cookie,
]);

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json',
    'User-Agent: TeraBox-PHP-Client/1.0'
]);

if ($use_proxy) {
    // Example:
    // curl_setopt($ch, CURLOPT_PROXY, "http://127.0.0.1:3128");
}

$result = curl_exec($ch);
$err = curl_error($ch);
$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($err) {
    echo json_encode(['error' => 'cURL error', 'detail' => $err]);
    exit;
}

$json = json_decode($result, true);

if (json_last_error() === JSON_ERROR_NONE) {
    http_response_code($http ?: 200);
    echo json_encode($json);
} else {
    echo json_encode(['raw' => $result]);
}
exit;
?>
