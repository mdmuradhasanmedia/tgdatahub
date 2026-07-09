<?php
// /tools/yt-tags-generator/index.php

// ==== Dynamic Variables ====
$tool_name     = "YT Tags Generator"; 
$tool_details  = "Generate SEO-friendly YouTube tags instantly. Boost your video rankings and discover the best keyword tags for YouTube optimization.";
$why_use_text  = "Tags help YouTube understand what your video is about, making it easier for people to discover your content.  
By using optimized tags, you can improve search rankings, appear in suggested videos, and reach more viewers.  

Our YT Tags Generator uses smart keyword extraction to give you ready-to-use, SEO-friendly tags for your videos. This saves time and helps maximize your video’s reach.";
$how_to_use    = [
  "Step 1 - Enter your video title, topic, or keywords in the input box.",
  "Step 2 - Click **Generate Tags** to instantly get a list of suggested YouTube tags.",
  "Step 3 - Copy the tags and add them to your YouTube video settings.",
  "Step 4 - Optimize your video description and title along with the tags for best SEO results."
];

// ==== FAQ Section ====
$faqs = [
  [
    "Why are YouTube tags important?", 
    "YouTube tags help the algorithm understand the context of your video. They increase the chances of your video showing up in search results and recommended feeds. While not the only ranking factor, tags can still improve discoverability."
  ],
  [
    "Can I use unlimited tags on YouTube?", 
    "YouTube allows up to 500 characters for tags. It’s best to use a mix of broad and specific tags that truly represent your content. Avoid spammy or irrelevant tags, as they can reduce trust and hurt rankings."
  ],
  [
    "Is this YouTube Tags Generator free?", 
    "Yes, our tool is completely free to use. You can generate unlimited tags without login or restrictions, making it ideal for creators of all levels."
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
      <label for="ytInput" class="block font-medium text-slate-700 mb-2">Enter Video Title or Keywords</label>
      <div class="flex flex-col sm:flex-row gap-2">
        <input 
          type="text" 
          id="ytInput" 
          placeholder="e.g., How to grow a YouTube channel" 
          class="flex-1 border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-600"
        />
        <button 
          onclick="generateTags()" 
          class="px-4 py-2 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition flex items-center justify-center gap-2"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
          </svg>
          Generate Tags
        </button>
      </div>
    </div>

    <!-- Results -->
    <div id="tagsResult" class="hidden mt-6">
      <div class="flex items-center justify-between mb-3">
        <h3 class="text-lg font-bold text-slate-800">Suggested Tags</h3>
        <button 
          onclick="copyTags()" 
          class="px-3 py-1 rounded-md bg-blue-500 text-white text-sm font-medium hover:bg-blue-600 transition flex items-center gap-1"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
            <path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/>
          </svg>
          Copy All
        </button>
      </div>
      <div id="tagsList" class="flex flex-wrap gap-2"></div>
    </div>

    <!-- Toast -->
    <div id="toast" class="fixed bottom-6 right-6 hidden bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg text-sm font-medium transition transform">
      ✅ Tags copied!
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
function generateTags() {
  const input = document.getElementById("ytInput").value.trim();
  if (!input) {
    alert("Please enter a video title or keywords.");
    return;
  }

  const words = input.split(/\s+/).map(w => w.toLowerCase().replace(/[^a-z0-9]/g, "")).filter(Boolean);

  // Dynamic variations
  const variations = [
    "how to", "best", "easy", "simple", "review", "tutorial", 
    "tips", "tricks", "explained", "guide", "for beginners", "2025"
  ];

  let tags = [];
  words.forEach(word => {
    tags.push(word);
    variations.forEach(v => {
      tags.push(`${v} ${word}`);
      tags.push(`${word} ${v}`);
    });
  });

  // Remove duplicates + limit to 20 tags
  tags = [...new Set(tags)].slice(0, 20);

  const tagsList = document.getElementById("tagsList");
  tagsList.innerHTML = "";
  tags.forEach(tag => {
    tagsList.innerHTML += `<span class="px-3 py-1 bg-indigo-50 text-indigo-700 rounded-full text-sm font-medium border border-indigo-200">${tag}</span>`;
  });

  document.getElementById("tagsResult").classList.remove("hidden");
}

function copyTags() {
  const tags = [...document.querySelectorAll("#tagsList span")].map(el => el.textContent).join(", ");
  if (!tags) return;

  navigator.clipboard.writeText(tags).then(() => {
    const toast = document.getElementById("toast");
    toast.classList.remove("hidden");
    setTimeout(() => {
      toast.classList.add("hidden");
    }, 2000);
  });
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
