<?php
header("Content-Type: application/xml; charset=utf-8");

// আপনার domain
$base_url = "https://tgdatahub.site/";

// যেসব ফোল্ডার বাদ যাবে
$excludeDirs = ['assets'];

// Function: সব tools/index.php খুঁজে বের করা
function listTools($dir) {
    global $excludeDirs;
    $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    $files = [];
    foreach ($rii as $file) {
        if ($file->isDir()) continue;
        if (basename($file) !== "index.php") continue;

        $path = str_replace(__DIR__ . "/", "", $file->getPathname());
        $parts = explode("/", $path);

        // exclude dir চেক
        if (in_array($parts[0], $excludeDirs)) continue;

        $files[] = $path;
    }
    return $files;
}

$tools = listTools(__DIR__ . "/tools");

// XML শুরু
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

<!-- Home -->
<url>
  <loc><?= $base_url ?></loc>
  <priority>1.0</priority>
  <changefreq>daily</changefreq>
  <lastmod><?= date("Y-m-d") ?></lastmod>
</url>

<!-- Static Pages (optional future) -->
<url>
  <loc><?= $base_url ?>privacy.php</loc>
  <priority>0.5</priority>
  <changefreq>yearly</changefreq>
  <lastmod><?= date("Y-m-d") ?></lastmod>
</url>
<url>
  <loc><?= $base_url ?>terms.php</loc>
  <priority>0.5</priority>
  <changefreq>yearly</changefreq>
  <lastmod><?= date("Y-m-d") ?></lastmod>
</url>

<!-- Tools -->
<?php foreach ($tools as $tool): 
    $url = $base_url . str_replace("index.php", "", $tool); ?>
<url>
  <loc><?= htmlspecialchars($url) ?></loc>
  <priority>0.8</priority>
  <changefreq>weekly</changefreq>
  <lastmod><?= date("Y-m-d", filemtime($tool)) ?></lastmod>
</url>
<?php endforeach; ?>

</urlset>
