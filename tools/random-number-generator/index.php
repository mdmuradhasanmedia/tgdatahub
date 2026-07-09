<?php
// /tools/random-number-generator/index.php

// ==== Dynamic Variables (edit these per tool) ====
$tool_name     = "Random Number Generator"; 
$tool_details  = "Generate truly random numbers online within a range of your choice. Simple, fast, and secure.";
$why_use_text  = "A random number generator is a quick and reliable way to create unbiased results. 
Whether you’re running a giveaway, choosing a winner, or just testing something, randomness ensures fairness.  

With our Random Number Generator, you don’t need to install any software. Everything runs directly in your browser, instantly and securely.  

It’s especially useful for teachers, developers, students, and anyone needing random results for experiments, math practice, or decision-making.";

$how_to_use    = [
  "Step 1 - Enter the minimum and maximum values for the range you want.",
  "Step 2 - Click on the **Generate Number** button.",
  "Step 3 - Instantly get a random number displayed on the screen.",
  "Step 4 - Repeat the process as many times as you need with a single click."
];

// ==== FAQ Placeholder ====
$faqs = [
  [
    "What is a Random Number Generator?", 
    "A Random Number Generator (RNG) is a tool that produces numbers without any pattern, meaning each result is completely unpredictable. It is commonly used for fair draws, gaming, experiments, and decision-making."
  ],
  [
    "Is this Random Number Generator truly random?", 
    "Yes. The tool uses browser-based algorithms to generate unpredictable results instantly. While it’s pseudo-random (computer-generated), for most real-life uses like giveaways, lottery picks, and quick choices, this randomness is more than sufficient."
  ],
  [
    "Can I use this Random Number Generator for professional or academic purposes?", 
    "Absolutely. Developers, researchers, and students often use RNGs for testing, sampling, probability experiments, and simulations. Since it works entirely in your browser, no data is stored or tracked, ensuring privacy."
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
    <div class="text-center mb-6">
      <label class="block mb-2 text-slate-700 font-semibold">Enter Range:</label>
      <div class="flex justify-center gap-2 mb-4">
        <input type="number" id="min" value="1" class="w-24 border border-slate-300 rounded-lg p-2 text-center">
        <span class="text-slate-600">to</span>
        <input type="number" id="max" value="100" class="w-24 border border-slate-300 rounded-lg p-2 text-center">
      </div>
      <button id="generate" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold">Generate Number</button>
      <div id="result" class="mt-4 text-3xl font-bold text-blue-600"></div>
    </div>

    <script>
      document.getElementById('generate').addEventListener('click', function() {
        const min = parseInt(document.getElementById('min').value);
        const max = parseInt(document.getElementById('max').value);
        if (!isNaN(min) && !isNaN(max) && min <= max) {
          const random = Math.floor(Math.random() * (max - min + 1)) + min;
          document.getElementById('result').textContent = random;
        } else {
          document.getElementById('result').textContent = "Invalid range";
        }
      });
    </script>
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
            <summary class="cursor-pointer font-semibold flex items-center justify-between" aria-expanded="false">
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
