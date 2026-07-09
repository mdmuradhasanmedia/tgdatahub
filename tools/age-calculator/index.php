<?php
// /tools/age-calculator/index.php

// ==== Dynamic Variables (edit these per tool) ====
$tool_name     = "Age Calculator"; 
$tool_details  = "Quickly calculate your exact age in years, months, and days with this free online Age Calculator tool. Perfect for forms, documents, or curiosity.";
$why_use_text  = "The Age Calculator is a simple but powerful tool that tells you exactly how old you are in years, months, and days. Instead of manually counting or using a calendar, this calculator gives instant and accurate results with just one click.  

This tool is useful for filling official forms, job applications, school admissions, passport details, or even for fun when you want to know your age in days or months. It removes the chance of human error and makes age calculation effortless.";  

$how_to_use    = [
  "Step 1 - Enter your **date of birth** in the input field.",
  "Step 2 - (Optional) Enter the date until which you want to calculate your age. By default, it uses today's date.",
  "Step 3 - Click on the **Calculate Age** button.",
  "Step 4 - Instantly get your exact age in years, months, and days."
];

// ==== FAQ Section (SEO-friendly, detailed answers) ====
$faqs = [
  [
    "What is an Age Calculator and how does it work?", 
    "An Age Calculator is an online tool that calculates the difference between your date of birth and today’s date. It provides your exact age in years, months, and days. This is done using real calendar dates, considering leap years and month lengths, so the result is precise."
  ],
  [
    "Why should I use an online Age Calculator instead of calculating manually?", 
    "Manual age calculation can be confusing because of varying month lengths and leap years. An online Age Calculator gives instant and error-free results in just a second. It is especially helpful when filling official documents, school admission forms, job applications, or medical records."
  ],
  [
    "Can I use this Age Calculator for official purposes?", 
    "Yes. Many people use it to find their exact age when required in forms like passports, government ID, job applications, visa forms, or insurance documents. As long as you enter your correct date of birth, the result will be valid and accurate."
  ],
  [
    "Does this Age Calculator also show months and days?", 
    "Absolutely. Unlike basic calculators that only show years, this tool provides a detailed breakdown of your age in years, months, and days. This makes it more useful in situations where exact age information is required."
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
    <form id="ageForm" class="grid gap-4 md:grid-cols-2">
      <div>
        <label for="dob" class="block font-medium mb-1">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required class="w-full border rounded-lg px-3 py-2">
      </div>
      <div>
        <label for="today" class="block font-medium mb-1">Calculate Until:</label>
        <input type="date" id="today" name="today" class="w-full border rounded-lg px-3 py-2">
      </div>
      <div class="md:col-span-2">
        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-3 rounded-lg transition">Calculate Age</button>
      </div>
    </form>
    <div id="result" class="mt-6 text-center font-bold text-lg text-slate-700"></div>
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

<?php require dirname(__DIR__, 2).'/partials/footer.php'; ?>

<script>
document.getElementById("ageForm").addEventListener("submit", function(e) {
  e.preventDefault();
  const dob = new Date(document.getElementById("dob").value);
  const todayInput = document.getElementById("today").value;
  const today = todayInput ? new Date(todayInput) : new Date();

  if(!dob) return;

  let years = today.getFullYear() - dob.getFullYear();
  let months = today.getMonth() - dob.getMonth();
  let days = today.getDate() - dob.getDate();

  if (days < 0) {
    months--;
    days += new Date(today.getFullYear(), today.getMonth(), 0).getDate();
  }
  if (months < 0) {
    years--;
    months += 12;
  }

  document.getElementById("result").innerText = 
    `Your Age: ${years} Years, ${months} Months, and ${days} Days`;
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
