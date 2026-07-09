<?php
// /tools/word-counter/index.php

// ==== Dynamic Variables ====
$tool_name     = "Word Counter"; 
$tool_details  = "Count words, characters, sentences, and paragraphs instantly with our free Word Counter tool. Perfect for students, writers, and professionals.";
$why_use_text  = "A Word Counter is useful when writing essays, articles, reports, or social media posts. Many platforms such as Twitter, LinkedIn, or academic institutions have specific word or character limits.  

Our Word Counter helps you stay within limits by showing word count, character count (with/without spaces), sentence count, and paragraph count in real time.  

It’s free, fast, and works directly in your browser without requiring any downloads or logins.";
$how_to_use    = [
  "Step 1 - Type or paste your text into the input box.",
  "Step 2 - The tool will instantly calculate word count, character count, sentence count, and paragraph count.",
  "Step 3 - Adjust your text as needed to meet requirements such as essays, social posts, or SEO content.",
  "Step 4 - Use the results to refine and optimize your writing."
];

// ==== FAQ Section ====
$faqs = [
  [
    "How accurate is this Word Counter tool?", 
    "Our Word Counter uses advanced text parsing logic to count words, characters, sentences, and paragraphs accurately. It works for most common writing formats and ignores extra spaces or line breaks."
  ],
  [
    "Who can use this Word Counter?", 
    "Anyone! Students can check essay lengths, writers can monitor drafts, marketers can optimize content for SEO, and social media users can stay within character limits. It’s designed for everyone who writes online or offline."
  ],
  [
    "Does this Word Counter work on mobile devices?", 
    "Yes. The tool is fully responsive, so you can paste or type text on any smartphone, tablet, or desktop device and instantly see results."
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
      <label for="textInput" class="block font-medium text-slate-700 mb-2">Enter Text</label>
      <textarea 
        id="textInput" 
        oninput="countWords()" 
        placeholder="Type or paste your text here..." 
        class="w-full h-40 border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-600"></textarea>
    </div>

    <!-- Results -->
    <div id="results" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
      <div class="p-4 border border-slate-200 rounded-lg bg-slate-50 text-center">
        <h3 class="text-sm font-semibold text-slate-500">Words</h3>
        <p id="wordCount" class="text-xl font-bold text-slate-800">0</p>
      </div>
      <div class="p-4 border border-slate-200 rounded-lg bg-slate-50 text-center">
        <h3 class="text-sm font-semibold text-slate-500">Characters</h3>
        <p id="charCount" class="text-xl font-bold text-slate-800">0</p>
      </div>
      <div class="p-4 border border-slate-200 rounded-lg bg-slate-50 text-center">
        <h3 class="text-sm font-semibold text-slate-500">Sentences</h3>
        <p id="sentenceCount" class="text-xl font-bold text-slate-800">0</p>
      </div>
      <div class="p-4 border border-slate-200 rounded-lg bg-slate-50 text-center">
        <h3 class="text-sm font-semibold text-slate-500">Paragraphs</h3>
        <p id="paraCount" class="text-xl font-bold text-slate-800">0</p>
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
function countWords() {
  const text = document.getElementById("textInput").value.trim();

  // Word count
  const words = text.length > 0 ? text.split(/\s+/).filter(Boolean).length : 0;

  // Character count
  const chars = text.length;

  // Sentence count (basic split by ., !, ?)
  const sentences = text.length > 0 ? (text.match(/[.!?]+/g) || []).length : 0;

  // Paragraph count (split by line breaks)
  const paras = text.length > 0 ? text.split(/\n+/).filter(p => p.trim().length > 0).length : 0;

  document.getElementById("wordCount").textContent = words;
  document.getElementById("charCount").textContent = chars;
  document.getElementById("sentenceCount").textContent = sentences;
  document.getElementById("paraCount").textContent = paras;
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
