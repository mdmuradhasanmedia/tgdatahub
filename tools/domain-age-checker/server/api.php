<?php
header("Content-Type: application/json");

if (!isset($_GET['domain'])) {
    echo json_encode(["error" => "No domain provided"]);
    exit;
}

$domain = strtolower(trim($_GET['domain']));

function get_rdap_server($domain) {
    $parts = explode('.', $domain);
    $tld = strtolower(end($parts));

    // fallback servers (common TLDs)
    $fallback = [
        "com" => "https://rdap.verisign.com/com/v1/",
        "net" => "https://rdap.verisign.com/net/v1/",
        "org" => "https://rdap.publicinterestregistry.net/rdap/",
        "io"  => "https://rdap.nic.io/",
        "xyz" => "https://rdap.centralnic.com/xyz/",
        "info"=> "https://rdap.afilias.net/rdap/info/",
        "biz" => "https://rdap.neustar.biz/"
    ];

    // Try IANA with cURL
    $iana_url = "https://data.iana.org/rdap/dns.json";
    $ch = curl_init($iana_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "TGDataHub/1.0");
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $json = curl_exec($ch);
    curl_close($ch);

    if ($json) {
        $data = json_decode($json, true);
        foreach ($data["services"] as $service) {
            if (in_array($tld, $service[0])) {
                return $service[1][0];
            }
        }
    }

    // fallback if IANA fails
    return $fallback[$tld] ?? null;
}

function fetch_rdap($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "TGDataHub/1.0");
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $out = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);
    if (!$out) return ["error" => "RDAP request failed: $err"];
    return $out;
}

function get_info($domain) {
    $server = get_rdap_server($domain);
    if (!$server) {
        return ["error" => "No RDAP server available for this TLD"];
    }

    $url = rtrim($server,"/")."/domain/".$domain;
    $json = fetch_rdap($url);
    if (is_array($json) && isset($json["error"])) return $json;

    $data = json_decode($json, true);
    if (!$data) return ["error" => "Invalid RDAP response from $url"];

    $created=$expires="N/A";
    foreach ($data["events"]??[] as $e) {
        if ($e["eventAction"]=="registration") $created=$e["eventDate"];
        if ($e["eventAction"]=="expiration") $expires=$e["eventDate"];
    }

    $age="N/A";
    if ($created!="N/A") {
        $diff=time()-strtotime($created);
        $y=floor($diff/(365*86400));
        $m=floor(($diff%(365*86400))/(30*86400));
        $d=floor(($diff%(30*86400))/(86400));
        $age="$y years, $m months, $d days";
    }

    return [
        "domain"=>$domain,
        "created"=>$created,
        "expires"=>$expires,
        "age"=>$age
    ];
}

echo json_encode(get_info($domain), JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
