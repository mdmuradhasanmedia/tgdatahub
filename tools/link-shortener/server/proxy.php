<?php
// /tools/link-shortener/server/proxy.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = "https://short.tgdatahub.site/shortener.php";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo json_encode([
            "success" => false,
            "message" => "Proxy Error: " . curl_error($ch)
        ]);
    } else {
        echo $response;
    }

    curl_close($ch);
    exit;
}

header("HTTP/1.1 405 Method Not Allowed");
echo json_encode(["success"=>false,"message"=>"Only POST allowed"]);
