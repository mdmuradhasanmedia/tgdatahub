<?php
// /tools/yt-thumbnail-viewer/index.php

// ==== Dynamic Variables ====
$tool_name     = "YT Thumbnail Viewer"; 
$tool_details  = "Preview YouTube video thumbnails in HD quality. Enter any YouTube video link and instantly view available thumbnail sizes.";
$why_use_text  = "YouTube only shows small thumbnails by default, but sometimes you may need to preview the original HD version for design reference, presentations, or social media mockups.  
With our YT Thumbnail Viewer, you can get instant access to the highest resolution preview available.  

It’s fast, free, and works on any device. Just paste the link and view the image in your browser without installing extensions.";
$how_to_use    = [
  "Step 1 - Copy the link of the YouTube video you want the thumbnail from.",
  "Step 2 - Paste the video URL into the input box of the YT Thumbnail Viewer.",
  "Step 3 - Click **Get Thumbnail** to instantly fetch available sizes.",
  "Step 4 - Preview the thumbnail and open it in a new tab for closer viewing."
];

// ==== FAQ Section ====
$faqs = [
  [
    "Can I save YouTube thumbnails from this tool?", 
    "This tool is designed only for previewing thumbnails in your browser. If you need to keep a copy, you can open the image in a new tab and use standard browser options like 'Save As'. Please note that the rights to thumbnails belong to YouTube and the original video creators."
  ],
  [
    "Is using this tool legal?", 
    "Yes. The tool simply displays publicly available thumbnails that YouTube already serves. However, usage of those images for commercial purposes may be subject to copyright rules. Always respect YouTube’s terms of service and creator rights."
  ],
  [
    "Does this tool work on mobile devices?", 
    "Absolutely! The tool is mobile-friendly and works on Android, iPhone, tablets, and desktops. Just paste the video link and preview the thumbnail instantly."
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
    <div class="mb-6">
      <label for="ytLink" class="block font-medium text-slate-700 mb-2">Enter YouTube Video Link</label>
      <div class="flex flex-col sm:flex-row gap-2">
        <input 
          type="url" 
          id="ytLink" 
          placeholder="https://www.youtube.com/watch?v=XXXXXX" 
          class="flex-1 border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-600"
        />
        <button 
          onclick="getThumbnail()" 
          class="px-4 py-2 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition flex items-center justify-center gap-2"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="8" />
            <line x1="21" y1="21" x2="16.65" y2="16.65" />
          </svg>
          Get Thumbnail
        </button>
      </div>
    </div>

    <!-- Preview -->
    <div id="thumbnailResult" class="mt-6 hidden">
      <h3 class="text-lg font-bold text-slate-800 mb-3">Thumbnail Preview</h3>
      <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3" id="thumbs"></div>
    </div>
    <!-- Tool End -->

    <!-- Disclaimer -->
    <div class="mt-6 p-3 rounded-lg bg-slate-50 border border-slate-200 text-sm text-slate-600">
      <strong>Disclaimer:</strong> This tool only previews publicly available thumbnails served by YouTube.  
      All rights belong to YouTube and the respective video creators.  
      Use of thumbnails should comply with YouTube’s Terms of Service.
    </div>

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

<script>
function getThumbnail() {
  const url = document.getElementById('ytLink').value;
  const match = url.match(/(?:v=|\.be\/)([a-zA-Z0-9_-]{11})/);
  if (!match) {
    alert("Please enter a valid YouTube link.");
    return;
  }
  const videoId = match[1];
  const sizes = {
    "Max Resolution (HD)": `https://img.youtube.com/vi/${videoId}/maxresdefault.jpg`,
    "High Quality": `https://img.youtube.com/vi/${videoId}/hqdefault.jpg`,
    "Medium Quality": `https://img.youtube.com/vi/${videoId}/mqdefault.jpg`,
    "Standard Quality": `https://img.youtube.com/vi/${videoId}/sddefault.jpg`
  };
  const thumbsDiv = document.getElementById('thumbs');
  thumbsDiv.innerHTML = "";
  for (const [label, src] of Object.entries(sizes)) {
    thumbsDiv.innerHTML += `
      <div class="border border-slate-200 rounded-lg overflow-hidden shadow-sm">
        <img src="${src}" alt="${label}" class="w-full">
        <div class="p-2 flex justify-between items-center bg-slate-50 border-t border-slate-200">
          <span class="text-sm font-medium text-slate-700">${label}</span>
          <a href="${src}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 px-3 py-1 rounded-md bg-indigo-600 text-white text-sm hover:bg-indigo-700 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3h7v7m0 0L10 21l-7-7L14 3z"/>
            </svg>
            Open
          </a>
        </div>
      </div>`;
  }
  document.getElementById('thumbnailResult').classList.remove('hidden');
}
</script>

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
