<?php
// /tools/terabox-video-downloader/index.php

$tool_name     = "Terabox Video Downloader"; 
$tool_details  = "Free Terabox Video Downloader online – instantly download Terabox videos in HD, Full HD, and Original Quality without limits.";

$why_use_text  = "Terabox Video Downloader helps users save their favorite Terabox videos directly to their device without installing any extra software. It provides a fast, secure and clean download experience.\n\nThis tool is fully browser-based and works on mobile, desktop and tablet. It supports all public and private Terabox videos using your NDUS cookie.";

$how_to_use    = [
  "Copy any Terabox share link from the official website or app.",
  "Paste the link into the input box of this Terabox Video Downloader tool.",
  "Enter your NDUS cookie for private or restricted videos.",
  "Click the Download button to fetch metadata and download links."
];

$faqs = [
  [
    "How does the Terabox Video Downloader work?",
    "The downloader securely forwards your request to the public Terasnap API. It returns file metadata and direct download links. No data is stored on our servers and no authentication is required."
  ],
  [
    "Is this downloader free?",
    "Yes. This tool is completely free and supports unlimited downloads without login, signup, or installation."
  ],
  [
    "Do you store NDUS cookie?",
    "No. Your NDUS cookie is never saved. It is only forwarded once to retrieve your file details securely."
  ]
];

$page_title = $tool_name;

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$domain   = $_SERVER['HTTP_HOST'];

$tool_slug  = "terabox-video-downloader";
$tool_image = "/assets/images/{$tool_slug}.png";
if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $tool_image)) {
    $tool_image = "/assets/images/default.png";
}

$meta_title = $tool_name . " | TG Data Hub Tools";
$meta_desc  = $tool_details;
$canonical  = $protocol . $domain . "/tools/" . $tool_slug;

require dirname(__DIR__, 2) . '/partials/header.php';
?>

<!-- ==== SEO ==== -->
<meta name="description" content="<?= htmlspecialchars($meta_desc) ?>">
<link rel="canonical" href="<?= $canonical ?>">
<link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
<script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>


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
      <h1 class="text-2xl md:text-3xl font-extrabold text-slate-800"><?= htmlspecialchars($tool_name) ?></h1>
      <p class="mt-2 text-slate-600"><?= $tool_details ?></p>
    </header>

    <!-- Tool UI -->
    <div class="mt-6 mb-10 p-6 bg-indigo-50 border border-slate-200 rounded-xl">

      <form id="tbDownloaderForm" class="space-y-4">

        <label class="block text-slate-700 font-medium">Terabox Video Link</label>
        <input type="url" name="link" required placeholder="https://1024terabox.com/s/xxxx"
               class="w-full p-3 border border-slate-300 rounded-lg focus:border-indigo-600">

        <label class="block text-slate-700 font-medium">NDUS Cookie</label>
        <input type="text" name="cookie" required placeholder="ndus=xxxxxxxx"
               class="w-full p-3 border border-slate-300 rounded-lg focus:border-indigo-600">

        <label class="flex items-center space-x-2">
          <input type="checkbox" name="use_proxy" value="1">
          <span class="text-slate-700">Use proxy (optional)</span>
        </label>

        <button type="submit"
          class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold">
          Download
        </button>
      </form>

      <div id="loader" class="hidden mt-4 text-indigo-700 font-semibold">Processing...</div>

      <div id="tbResult" class="mt-6"></div>

    </div>

    <!-- Why Use -->
    <div class="mt-8">
      <h2 class="text-xl font-bold text-slate-800 mb-2">Why use <?= htmlspecialchars($tool_name) ?>?</h2>
      <?php foreach (explode("\n\n", $why_use_text) as $p): ?>
        <p class="text-slate-600 leading-relaxed mb-3"><?= nl2br(trim($p)) ?></p>
      <?php endforeach; ?>
    </div>

    <!-- How To Use -->
    <div class="mt-6">
      <h2 class="text-xl font-bold text-slate-800 mb-2">How to use <?= htmlspecialchars($tool_name) ?></h2>
      <ol class="list-decimal pl-5 space-y-2 text-slate-600">
        <?php foreach ($how_to_use as $step): ?>
          <li><?= htmlspecialchars($step) ?></li>
        <?php endforeach; ?>
      </ol>
    </div>

    <!-- FAQ -->
    <div class="mt-6 border-t border-slate-200 pt-4">
      <h2 class="text-xl font-bold text-slate-800 mb-3"><?= $tool_name ?> – FAQ</h2>

      <div class="space-y-3">
        <?php foreach ($faqs as [$q, $a]): ?>
        <details class="group border border-slate-200 rounded-lg p-3">
          <summary class="cursor-pointer font-semibold flex justify-between">
            <?= htmlspecialchars($q) ?>
            <svg width="16" height="16" stroke="currentColor" fill="none" class="text-slate-500 group-open:rotate-45 transition">
              <path stroke-width="2" d="M8 3v10M3 8h10"/>
            </svg>
          </summary>
          <div class="mt-2 text-slate-600"><?= nl2br(htmlspecialchars_decode($a)) ?></div>
        </details>
        <?php endforeach; ?>
      </div>
    </div>

    <?php require dirname(__DIR__, 2).'/partials/back-to-tools.php'; ?>

  </section>
</main>

<script>
function playVideo(url, cookie) {
    const container = document.getElementById("videoPlayer");

    container.innerHTML = `
        <video id="player" controls autoplay playsinline class="w-full rounded-xl shadow-lg">
            <source src="/tools/terabox-video-downloader/server/stream.php?url=${encodeURIComponent(url)}&cookie=${cookie}" type="video/mp4">
        </video>
    `;

    new Plyr('#player', {
        autoplay: true,
        controls: [
            'play-large',
            'play',
            'progress',
            'current-time',
            'mute',
            'volume',
            'settings',
            'fullscreen',
        ],
        settings: ['speed'],
        speed: { selected: 1, options: [0.5, 1, 1.25, 1.5, 2] },
    });
}



// Handle form
document.getElementById("tbDownloaderForm").addEventListener("submit", async function (e) {
    e.preventDefault();

    const fd = new FormData(this);
    const result = document.getElementById("tbResult");
    const loader = document.getElementById("loader");

    result.innerHTML = "";
    loader.classList.remove("hidden");

    const resp = await fetch("/tools/terabox-video-downloader/server/api.php", {
        method: "POST",
        body: fd
    });

    const json = await resp.json();
    loader.classList.add("hidden");

    if (json.error) {
        result.innerHTML = `
            <div class="p-4 bg-red-50 border border-red-300 text-red-700 rounded-lg">
                <strong>Error:</strong> ${json.error}
            </div>`;
        return;
    }

    let sizeHTML = "";
    if (json.size && json.size > 0) {
        sizeHTML = `<p class="text-slate-600 text-sm mb-2">Size: ${formatSize(json.size)}</p>`;
    }

    const thumb = json.thumbnail
        ? `<img src="${json.thumbnail}" class="rounded-xl w-full max-w-xs border shadow-sm mb-4">`
        : `<div class="w-40 h-28 bg-slate-200 rounded-md mb-4"></div>`;

    result.innerHTML = `
      <div class="p-6 bg-white border border-slate-200 rounded-xl shadow-md">
        <div class="flex flex-col items-center text-center">
          ${thumb}
          <h3 class="text-xl font-bold text-slate-800">${json.file_name}</h3>
          ${sizeHTML}
<div class="mt-3 flex gap-3">

    <button onclick="playVideo('${json.download_link}', '${fd.get('cookie')}')"
            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold">
        Play Video
    </button>

    <a href="/tools/terabox-video-downloader/server/proxy.php?url=${encodeURIComponent(json.download_link)}&cookie=${fd.get('cookie')}"
       class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold">
       Download File
    </a>

    <button onclick="copyDownload('${json.download_link}')"
        class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold">
        Copy Link
    </button>

</div>

<div id="videoPlayer" class="w-full mt-6"></div>



        </div>
      </div>
    `;
});

function formatSize(bytes) {
    const sizes = ["B","KB","MB","GB","TB"];
    const i = Math.floor(Math.log(bytes) / Math.log(1024));
    return (bytes / Math.pow(1024, i)).toFixed(2) + " " + sizes[i];
}

function copyDownload(url) {
    navigator.clipboard.writeText(url);
    alert("Link copied");
}
</script>

<?php require dirname(__DIR__, 2).'/partials/footer.php'; ?>
