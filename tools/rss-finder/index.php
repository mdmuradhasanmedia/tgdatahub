<?php
// /tools/rss-finder/index.php


function fetchSiteHTML($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "TGDataHub RSS Finder Bot/1.0");
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $output = curl_exec($ch);
    $err    = curl_error($ch);
    curl_close($ch);

    if ($err) {
        return false;
    }
    return $output;
}


// ==== Dynamic Variables ====
$tool_name     = "RSS Finder"; 
$tool_details  = "Easily find and extract RSS feed URLs from any website. Perfect for bloggers, developers, and readers who want to automate content updates.";
$why_use_text  = "Many websites publish RSS feeds, but they don’t always make them visible. 
With RSS Finder, you can quickly discover hidden RSS and Atom feeds just by entering a website URL. \n\n
This tool helps bloggers, content creators, and developers stay updated automatically without manually checking sites. 
It’s especially useful for building news aggregators, automation scripts, or personal dashboards.";

// ==== How to use ====
$how_to_use    = [
  "Step 1 - Enter the website URL you want to check for RSS feeds.",
  "Step 2 - Click on the 'Find RSS' button to scan the site.",
  "Step 3 - The tool will display available RSS/Atom feed links.",
  "Step 4 - Copy the feed link and use it in your reader, app, or integration."
];

// ==== FAQ ====
$faqs = [
  [
    "What is an RSS Feed and why is it important?", 
    "RSS (Really Simple Syndication) is a way for websites to share content updates automatically. 
    Instead of manually visiting each website, you can subscribe to its RSS feed and get new posts delivered to your RSS reader or app instantly."
  ],
  [
    "Can this tool find hidden or custom feeds?", 
    "Yes. RSS Finder scans the HTML source of the given site and looks for standard RSS and Atom feed tags. 
    Even if the site doesn’t display a feed link publicly, the tool can detect feeds embedded in meta tags or headers."
  ],
  [
    "How can I use the feed links I find?", 
    "Once you copy the RSS link, you can add it to any RSS reader (like Feedly, Inoreader, or Thunderbird). 
    Developers can also use these links in custom applications, bots, or websites to fetch and display live content."
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
      <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-slate-800">
        <?= htmlspecialchars($tool_name) ?>
      </h1>
      <p class="mt-2 text-slate-600"><?= $tool_details ?></p>
    </header>

 <!-- Tool Start -->
<div class="mt-6 mb-8">
  <form method="post" class="flex flex-col md:flex-row gap-3">
    <input type="url" name="site_url" placeholder="Enter website URL (e.g., https://example.com)" required 
      class="flex-1 border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-indigo-600">
    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2 rounded-lg">
      Find RSS
    </button>
  </form>

  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['site_url'])) {
      $url = filter_var($_POST['site_url'], FILTER_SANITIZE_URL);
      $html = fetchSiteHTML($url);

      if ($html) {
          preg_match_all('/<link[^>]+rel=["\'](?:alternate)["\'][^>]*>/i', $html, $matches);
          $feeds = [];

          foreach ($matches[0] as $tag) {
              if (preg_match('/type=["\'](application\/(?:rss|atom)\+xml)["\']/', $tag)) {
                  if (preg_match('/href=["\']([^"\']+)["\']/', $tag, $href)) {
                      $feeds[] = htmlspecialchars($href[1]);
                  }
              }
          }

          if ($feeds) {
              echo "<div class='mt-6 p-4 border border-slate-200 rounded-lg bg-indigo-50'>";
              echo "<h3 class='font-bold text-slate-800 mb-2'>Feeds Found:</h3><ul class='space-y-2'>";
              foreach ($feeds as $feed) {
                  echo "<li class='flex items-center justify-between bg-white border border-slate-200 rounded-lg px-3 py-2'>";
                  echo "<a href='$feed' target='_blank' class='text-blue-600 hover:underline truncate flex-1 mr-3'>$feed</a>";
                  echo "<button onclick=\"copyToClipboard('$feed')\" class='flex items-center gap-1 bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-3 py-1 rounded-lg transition'>";
                  echo "<svg xmlns='http://www.w3.org/2000/svg' class='h-4 w-4' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M8 16h8M8 12h8m-8-4h8m2 8V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8l4-4z'/></svg>";
                  echo "Copy</button>";
                  echo "</li>";
              }
              echo "</ul></div>";
          } else {
              echo "<p class='mt-4 text-red-600 font-medium'>No RSS feeds found for this site.</p>";
          }
      } else {
          echo "<p class='mt-4 text-red-600 font-medium'>Unable to fetch the website. Please try again.</p>";
      }
  }
  ?>
</div>
<!-- Tool End -->

<script>
function copyToClipboard(text) {
  navigator.clipboard.writeText(text).then(() => {
    alert("Copied: " + text);
  }).catch(err => {
    console.error("Clipboard error:", err);
    alert("Failed to copy");
  });
}
</script>


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
            <summary class="cursor-pointer font-semibold flex items-center justify-between">
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
