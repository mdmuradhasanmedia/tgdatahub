<?php
// /tools/app-downloader/index.php

// ==== Dynamic Variables ====
$tool_name     = "App Downloader (Multi-Source)"; 
$tool_details  = "Free online tool to download Android apps directly from multiple sources like APKPure, APKCombo, and Evozi. Always get a working download link, with app details, screenshots, and icon preview.";
$why_use_text  = "Many users face issues when trying to download APK files directly from the Google Play Store because Google does not provide direct download links. 
Our App Downloader (Multi-Source) solves this problem by combining multiple sources into one tool.\n\n
With this tool, you can get app details such as the app icon, description, and screenshots. You will also get multiple download options (APKPure, APKCombo, Evozi) to ensure that you always have a working APK link.\n\n
This tool is perfect for Android users, developers, and testers who want a reliable way to fetch APKs without depending on a single source.";
$how_to_use    = [
  "Step 1 - Enter the Play Store App ID (example: com.whatsapp) OR paste the full Play Store link.",
  "Step 2 - Click the 'Fetch Details' button to generate app information from multiple sources.",
  "Step 3 - The tool will show you the app icon, name, developer, rating, installs, and screenshots.",
  "Step 4 - Choose a download button from APKPure, APKCombo, or Evozi to download the APK directly."
];

// ==== FAQ Section ====
$faqs = [
  [
    "How does the App Downloader (Multi-Source) work?", 
    "This tool collects app information and download links from multiple APK sources like APKPure, APKCombo, and Evozi. By combining these, it ensures that users always have a valid working download link. It also provides app details like the icon, name, and screenshots for a better experience."
  ],
  [
    "Is it safe to download APK files using this tool?", 
    "Yes, the tool itself only generates download links from trusted external sources. However, APK files are provided by third-party mirrors. We recommend downloading apps only from official developers and ensuring your device security settings are enabled."
  ],
  [
    "Why should I use multiple sources instead of one?", 
    "Sometimes a single APK source may be down, slow, or outdated. By using multiple fallback sources (APKPure, APKCombo, Evozi), this tool guarantees that you always have a working link for downloading the app you want."
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
$meta_desc  = $tool_details . " Use this free tool to get APK files quickly and securely.";
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
    <div class="mt-6">
      <form id="appForm" class="flex gap-2">
        <input type="text" id="appId" placeholder="Enter App ID or Play Store Link" required
               class="flex-1 px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600">
        <button type="submit" class="px-5 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-semibold">
          Fetch Details
        </button>
      </form>

      <div id="result" class="mt-6 hidden">
        <div class="flex gap-4 items-start">
          <img id="appIcon" src="" alt="App Icon" class="w-20 h-20 rounded-lg border border-slate-200">
          <div>
            <h2 id="appTitle" class="text-xl font-bold text-slate-800"></h2>
            <p class="text-slate-600 mt-1">
              <span id="appDeveloper"></span>
            </p>
            <div class="flex items-center gap-4 text-slate-600 mt-1 text-sm">
              <span id="appRating"></span>
              <span id="appInstalls"></span>
            </div>
          </div>
        </div>

        <!-- Screenshot Swiper -->
        <div class="mt-6 relative overflow-hidden">
          <div id="screenshotWrapper" class="flex gap-3 overflow-x-auto snap-x snap-mandatory scrollbar-hide">
            <!-- JS will inject screenshots -->
          </div>
        </div>

        <!-- Download Buttons -->
        <div class="mt-6 flex gap-3 flex-wrap">
          <a id="apkPureBtn" href="#" target="_blank" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">Download (APKPure)</a>
          <a id="apkComboBtn" href="#" target="_blank" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">Download (APKCombo)</a>
          <a id="evoziBtn" href="#" target="_blank" class="px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white rounded-lg">Download (Evozi)</a>
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
            <summary class="cursor-pointer font-semibold flex items-center justify-between">
              <?= htmlspecialchars($q) ?>
              <span class="text-slate-400 group-open:rotate-45 transition">+</span>
            </summary>
            <div class="mt-2 text-slate-600 leading-relaxed"><?= nl2br(htmlspecialchars_decode($a)) ?></div>
          </details>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Bottom CTA -->
    <?php require dirname(__DIR__, 2).'/partials/back-to-tools.php'; ?>
  </section>
</main>

<?php require dirname(__DIR__, 2).'/partials/footer.php'; ?>

<script>
// Hide scrollbar
const style = document.createElement('style');
style.innerHTML = `.scrollbar-hide::-webkit-scrollbar { display: none; } .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }`;
document.head.appendChild(style);

document.getElementById('appForm').addEventListener('submit', async function(e) {
  e.preventDefault();
  let inputVal = document.getElementById('appId').value.trim();
  let appId = inputVal;

  // Extract ID if user pasted full Play Store link
  if (appId.includes("play.google.com")) {
    let match = appId.match(/id=([a-zA-Z0-9._-]+)/);
    if (match) appId = match[1];
  }

  let resBox = document.getElementById('result');
  resBox.classList.add('hidden');

  let res = await fetch("app-downloader/server/api.php?id=" + encodeURIComponent(appId));
  let data = await res.json();

  if (data.success) {
    document.getElementById('appIcon').src = data.icon;
    document.getElementById('appTitle').innerText = data.title;
    document.getElementById('appDeveloper').innerText = data.developer ? "By " + data.developer : "";
    document.getElementById('appRating').innerText = data.rating ? "⭐ " + data.rating : "";
    document.getElementById('appInstalls').innerText = data.installs ? data.installs + " installs" : "";

    let screenshotWrapper = document.getElementById('screenshotWrapper');
    screenshotWrapper.innerHTML = data.screenshots.map(s => `
      <img src="${s}" class="rounded-lg border snap-center w-60 h-auto flex-shrink-0">
    `).join('');

    document.getElementById('apkPureBtn').href = data.links.apkpure;
    document.getElementById('apkComboBtn').href = data.links.apkcombo;
    document.getElementById('evoziBtn').href = data.links.evozi;

    resBox.classList.remove('hidden');
  } else {
    alert(data.message || "Failed to fetch app details");
  }
});
</script>
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
