<?php
// /tools/m3u8-runner/index.php

$tool_name    = "M3U8 Runner";
$tool_details = "Run and test M3U8 live stream links directly in your browser with a fast and secure online player.";

$why_use_text = "M3U8 Runner allows you to instantly preview and test HTTP Live Streaming links without installing any software.

This tool is ideal for IPTV testers, developers, broadcasters, and content managers who want a quick and reliable way to verify live streams across modern browsers.";

$how_to_use = [
  "Paste a valid .m3u8 stream URL into the input field.",
  "Click the Run Stream button to initialize the player.",
  "Wait a few seconds for the stream to load.",
  "Use the video controls to play, pause, or monitor the live stream."
];

$faqs = [
  [
    "What is an M3U8 file?",
    "An M3U8 file is a playlist format used by HTTP Live Streaming (HLS). It contains references to media segments that allow adaptive bitrate streaming for live TV, IPTV services, and on-demand video."
  ],
  [
    "Why is my M3U8 link not playing?",
    "Some M3U8 links are protected by CORS restrictions or require authentication tokens. Browser-based players can only play publicly accessible streams that allow cross-origin requests."
  ],
  [
    "Which browsers are supported?",
    "M3U8 Runner works on all modern browsers including Chrome, Firefox, Edge, and Safari. Safari supports HLS natively, while other browsers use HLS.js automatically."
  ]
];

$page_title = $tool_name;

// Auto domain
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$domain   = $_SERVER['HTTP_HOST'];

$tool_slug  = "m3u8-runner";
$tool_image = "/assets/images/m3u8-runner.png";
if (!file_exists($_SERVER['DOCUMENT_ROOT'].$tool_image)) {
  $tool_image = "/assets/images/default.png";
}

$meta_title = $tool_name." | TG Data Hub Tools";
$meta_desc  = $tool_details." Free, browser-based and easy to use.";
$canonical  = $protocol.$domain."/tools/".$tool_slug;

require dirname(__DIR__,2).'/partials/header.php';
?>

<meta name="description" content="<?= htmlspecialchars($meta_desc) ?>">
<link rel="canonical" href="<?= $canonical ?>">

<main class="max-w-5xl mx-auto px-4 py-8">

<nav aria-label="Breadcrumb" class="mb-4 text-sm text-slate-500">
  <ol class="flex space-x-2">
    <li><a href="/" class="hover:underline">Home</a></li>
    <li>/</li>
    <li><a href="/tools" class="hover:underline">Tools</a></li>
    <li>/</li>
    <li class="text-slate-700"><?= htmlspecialchars($tool_name) ?></li>
  </ol>
</nav>

<section class="bg-white rounded-2xl border border-slate-200 shadow-lg p-6 md:p-8">

<header class="mb-6 text-center">
  <div class="mx-auto w-14 h-14 rounded-xl bg-indigo-50 flex items-center justify-center mb-3">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14m-6 0l-4.553 2.276A1 1 0 013 15.382V8.618a1 1 0 011.447-.894L9 10m6 4V10M9 14V10" />
    </svg>
  </div>

  <h1 class="text-2xl md:text-3xl font-extrabold text-slate-800"><?= htmlspecialchars($tool_name) ?></h1>
  <p class="mt-2 text-slate-600"><?= $tool_details ?></p>
</header>

<!-- Tool UI -->
<div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
  <input id="m3u8" type="url" placeholder="Enter .m3u8 stream URL"
    class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-600 outline-none text-slate-700">

  <button onclick="runStream()"
    class="mt-3 w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg transition">
    Run Stream
  </button>

  <video id="player" controls class="w-full mt-4 rounded-lg bg-black"></video>
</div>

<div class="mt-8">
  <h2 class="text-xl font-bold text-slate-800 mb-2">Why use <?= htmlspecialchars($tool_name) ?>?</h2>
  <?php foreach (explode("\n\n",$why_use_text) as $p): ?>
    <p class="text-slate-600 leading-relaxed mb-3"><?= htmlspecialchars($p) ?></p>
  <?php endforeach; ?>
</div>

<div class="mt-6">
  <h2 class="text-xl font-bold text-slate-800 mb-2">How to use <?= htmlspecialchars($tool_name) ?></h2>
  <ol class="list-decimal pl-5 space-y-2 text-slate-600">
    <?php foreach ($how_to_use as $step): ?>
      <li><?= htmlspecialchars($step) ?></li>
    <?php endforeach; ?>
  </ol>
</div>

<div class="mt-6 border-t border-slate-200 pt-4" id="faq">
  <h2 class="text-xl font-bold text-slate-800 mb-3"><?= htmlspecialchars($tool_name) ?> – FAQ</h2>
  <?php foreach ($faqs as [$q,$a]): ?>
    <details class="border border-slate-200 rounded-lg p-3 mb-2">
      <summary class="font-semibold cursor-pointer"><?= htmlspecialchars($q) ?></summary>
      <p class="mt-2 text-slate-600 leading-relaxed"><?= htmlspecialchars($a) ?></p>
    </details>
  <?php endforeach; ?>
</div>

<?php require dirname(__DIR__,2).'/partials/back-to-tools.php'; ?>
</section>
</main>

<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script>
let hlsInstance = null;

function runStream(){
  const input = document.getElementById('m3u8');
  const url   = input.value.trim();
  const video = document.getElementById('player');

  if(!url){
    alert("Please enter a valid M3U8 URL");
    return;
  }

  // destroy previous instance
  if (hlsInstance) {
    hlsInstance.destroy();
    hlsInstance = null;
  }

  if (Hls.isSupported()) {
    hlsInstance = new Hls();
    hlsInstance.loadSource(url);
    hlsInstance.attachMedia(video);
    hlsInstance.on(Hls.Events.MANIFEST_PARSED, () => {
      video.play();
    });
  } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
    video.src = url;
    video.play();
  } else {
    alert("Your browser does not support HLS playback.");
  }
}
</script>



<?php require dirname(__DIR__,2).'/partials/footer.php'; ?>

<!-- FAQ Schema -->
<script type="application/ld+json">
<?= json_encode([
  "@context"=>"https://schema.org",
  "@type"=>"FAQPage",
  "mainEntity"=>array_map(function($f){
    return [
      "@type"=>"Question",
      "name"=>$f[0],
      "acceptedAnswer"=>["@type"=>"Answer","text"=>$f[1]]
    ];
  },$faqs)
],JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT); ?>
</script>

<!-- WebPage Schema -->
<script type="application/ld+json">
<?= json_encode([
  "@context"=>"https://schema.org",
  "@type"=>"WebPage",
  "name"=>$meta_title,
  "description"=>$meta_desc,
  "url"=>$canonical
],JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT); ?>
</script>

<!-- SoftwareApplication Schema -->
<script type="application/ld+json">
<?= json_encode([
  "@context"=>"https://schema.org",
  "@type"=>"SoftwareApplication",
  "name"=>$tool_name,
  "operatingSystem"=>"Web",
  "applicationCategory"=>"MultimediaApplication",
  "description"=>$tool_details,
  "url"=>$canonical,
  "offers"=>["@type"=>"Offer","price"=>"0","priceCurrency"=>"USD"],
  "publisher"=>["@type"=>"Organization","name"=>"TG Data Hub","url"=>$protocol.$domain]
],JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT); ?>
</script>

<!-- Breadcrumb Schema -->
<script type="application/ld+json">
<?= json_encode([
  "@context"=>"https://schema.org",
  "@type"=>"BreadcrumbList",
  "itemListElement"=>[
    ["@type"=>"ListItem","position"=>1,"name"=>"Home","item"=>$protocol.$domain],
    ["@type"=>"ListItem","position"=>2,"name"=>"Tools","item"=>$protocol.$domain."/tools"],
    ["@type"=>"ListItem","position"=>3,"name"=>$tool_name,"item"=>$canonical]
  ]
],JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT); ?>
</script>
