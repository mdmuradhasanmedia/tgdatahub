<?php
// /tools/app-downloader/server/api.php

header('Content-Type: application/json; charset=UTF-8');

$app_id = $_GET['id'] ?? '';
if (!$app_id) {
    echo json_encode(["success" => false, "message" => "Please provide App ID"]);
    exit;
}

// RapidAPI Request
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => "https://google-play-store-scraper-api.p.rapidapi.com/app-details",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode([
        'language' => 'en',
        'country'  => 'us',
        'appID'    => $app_id
    ]),
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "x-rapidapi-host: google-play-store-scraper-api.p.rapidapi.com",
        "x-rapidapi-key: 2b6589168bmshca3252b21ab76a6p1bdf05jsn1b5c592f55bf" // 🔑 Replace with your key
    ],
]);
$response = curl_exec($ch);
$error    = curl_error($ch);
curl_close($ch);

if ($error) {
    echo json_encode(["success" => false, "message" => "cURL Error: $error"]);
    exit;
}

$data = json_decode($response, true);
if (!$data || empty($data['data'])) {
    echo json_encode(["success" => false, "message" => "Invalid response from API"]);
    exit;
}

$app = $data['data'];

// Multi-source links
$links = [
    "apkpure" => "https://d.apkpure.com/b/APK/{$app_id}?version=latest",
];

// Final output
echo json_encode([
    "success" => true,
    "app_id" => $app_id,
    "title"  => $app['title'] ?? $app_id,
    "icon"   => $app['icon'] ?? "https://via.placeholder.com/100?text=APK",
    "desc"   => $app['summary'] ?? "No description available.",
    "screenshots" => $app['screenshots'] ?? [],
    "developer"   => $app['developer'] ?? "",
    "installs"    => $app['installs'] ?? "",
    "rating"      => $app['scoreText'] ?? "",
    "links"       => $links
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
