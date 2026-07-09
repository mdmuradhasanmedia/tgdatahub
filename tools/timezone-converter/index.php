<?php
// /tools/timezone-converter/index.php

// ==== Dynamic Variables ====
$tool_name     = "Timezone Converter"; 
$tool_details  = "Easily convert time between different time zones instantly. Perfect for meetings, travel, and global work scheduling.";
$why_use_text  = "Time zones can be confusing, especially when scheduling meetings, managing remote teams, or planning international travel.  
Our Timezone Converter helps you quickly check what time it is in another city, country, or region.  

You’ll never miss a meeting again — just select your time zone, the target time zone, and instantly see the converted time.";
$how_to_use    = [
  "Step 1 - Enter the date and time you want to convert.",
  "Step 2 - Select your current timezone from the dropdown list.",
  "Step 3 - Select the target timezone you want to convert to.",
  "Step 4 - Instantly view the converted time and adjust your schedule accordingly."
];

// ==== FAQ Section ====
$faqs = [
  [
    "How does the Timezone Converter work?", 
    "The Timezone Converter uses the latest timezone database (IANA TZ Database) to accurately calculate time differences worldwide. It automatically accounts for Daylight Saving Time (DST) changes where applicable."
  ],
  [
    "Why should I use a Timezone Converter?", 
    "If you work with international clients, attend global online events, or travel frequently, knowing the correct time in another zone is crucial. This tool saves you from manual calculation errors and ensures punctuality."
  ],
  [
    "Does the Timezone Converter work on mobile devices?", 
    "Yes, the tool is fully mobile-friendly. You can convert time zones on your smartphone, tablet, or computer with the same accuracy and ease."
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
<div class="mb-6 grid gap-4 md:grid-cols-2">
  <div class="md:col-span-2">
    <label for="inputTime" class="block font-medium text-slate-700 mb-1">Select Date & Time</label>
    <input 
      type="datetime-local" 
      id="inputTime" 
      class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-600"
    >
  </div>

  <div>
    <label for="fromZone" class="block font-medium text-slate-700 mb-1">From Timezone</label>
    <select 
      id="fromZone" 
      class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-600">
    </select>
  </div>

  <div>
    <label for="toZone" class="block font-medium text-slate-700 mb-1">To Timezone</label>
    <select 
      id="toZone" 
      class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-600">
    </select>
  </div>

  <div class="md:col-span-2">
    <button 
      onclick="convertTime()" 
      class="w-full md:w-auto px-5 py-2 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition flex items-center justify-center gap-2"
    >
      <!-- Working Heroicons svg -->
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2h6v2m3-10h2a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V9a2 2 0 012-2h2l2-3h4l2 3z"/>
      </svg>
      Convert Time
    </button>
  </div>
</div>

<div id="result" class="mt-4 hidden p-3 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 font-medium"></div>
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
// Populate timezone dropdowns
const timezones = Intl.supportedValuesOf("timeZone");
const fromZone = document.getElementById("fromZone");
const toZone = document.getElementById("toZone");

timezones.forEach(tz => {
  let opt1 = new Option(tz, tz);
  let opt2 = new Option(tz, tz);
  fromZone.add(opt1);
  toZone.add(opt2);
});
fromZone.value = Intl.DateTimeFormat().resolvedOptions().timeZone;
toZone.value = "UTC";

function convertTime() {
  const input = document.getElementById("inputTime").value;
  if (!input) {
    alert("Please select a date and time.");
    return;
  }
  const from = fromZone.value;
  const to = toZone.value;
  const date = new Date(input);

  try {
    const options = { timeZone: to, hour12: false, year:"numeric", month:"short", day:"numeric", hour:"2-digit", minute:"2-digit" };
    const converted = new Intl.DateTimeFormat("en-US", options).format(date);
    const result = document.getElementById("result");
    result.textContent = `Converted Time (${to}): ${converted}`;
    result.classList.remove("hidden");
  } catch (e) {
    alert("Error converting timezone. Please try again.");
  }
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
