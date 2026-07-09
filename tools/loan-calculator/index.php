<?php
// /tools/loan-calculator/index.php

// ==== Dynamic Variables (edit these per tool) ====
$tool_name     = "Loan Calculator"; 
$tool_details  = "Easily calculate monthly loan payments, total payments, and interest with our free online Loan Calculator. Perfect for personal, car, or home loans.";
$why_use_text  = "A Loan Calculator helps you understand how much you’ll need to pay every month when you borrow money.  
By entering the loan amount, interest rate, and repayment period, you can instantly see your monthly payment, total repayment, and total interest.  

This makes it easy to compare different loan offers, plan your budget, and avoid surprises before committing to a loan.  
Our Loan Calculator is 100% free, works online in your browser, and gives instant results.";  

$how_to_use    = [
  "Step 1 - Enter the loan amount you plan to borrow.",
  "Step 2 - Enter the annual interest rate in percentage (e.g. 8.5).",
  "Step 3 - Enter the loan term in years.",
  "Step 4 - Click the **Calculate** button to view monthly payment, total payment, and total interest."
];

// ==== FAQ Placeholder (SEO-friendly) ====
$faqs = [
  [
    "How does the Loan Calculator calculate monthly payments?", 
    "The Loan Calculator uses the standard amortization formula. It takes into account the loan principal, interest rate, and loan term to calculate fixed monthly payments.  
    The formula ensures that the loan is paid off completely over the entered time period."
  ],
  [
    "Why should I use a Loan Calculator before taking a loan?", 
    "Using a Loan Calculator helps you make informed financial decisions.  
    You can quickly compare different loan amounts, interest rates, or terms to find the most affordable option.  
    It also prevents surprises by showing you the total cost of the loan, including interest."
  ],
  [
    "Can I use this calculator for different types of loans?", 
    "Yes! You can use this tool for personal loans, car loans, education loans, or home loans.  
    As long as you know the loan amount, interest rate, and repayment period, this calculator will give accurate results."
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
    <form id="loanForm" class="grid gap-4 md:grid-cols-2">
      <div>
        <label class="block font-medium mb-1">Loan Amount:</label>
        <input type="number" id="amount" required class="w-full border rounded-lg px-3 py-2" placeholder="Enter amount">
      </div>
      <div>
        <label class="block font-medium mb-1">Interest Rate (% per year):</label>
        <input type="number" id="rate" required step="0.01" class="w-full border rounded-lg px-3 py-2" placeholder="e.g. 8.5">
      </div>
      <div>
        <label class="block font-medium mb-1">Loan Term (Years):</label>
        <input type="number" id="years" required class="w-full border rounded-lg px-3 py-2" placeholder="e.g. 5">
      </div>
      <div class="md:col-span-2">
        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-3 rounded-lg transition">
          Calculate
        </button>
      </div>
    </form>

    <div id="result" class="mt-6 hidden text-center bg-slate-50 border rounded-xl p-6">
      <p class="text-lg font-semibold text-slate-700">Monthly Payment: <span id="monthly" class="font-bold text-indigo-600"></span></p>
      <p class="mt-2">Total Payment: <span id="total" class="font-medium"></span></p>
      <p class="mt-1">Total Interest: <span id="interest" class="font-medium"></span></p>
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

<?php require dirname(__DIR__, 2).'/partials/footer.php'; ?>

<script>
document.getElementById("loanForm").addEventListener("submit", function(e) {
  e.preventDefault();

  const amount = parseFloat(document.getElementById("amount").value);
  const rate = parseFloat(document.getElementById("rate").value) / 100 / 12; // monthly rate
  const years = parseFloat(document.getElementById("years").value) * 12; // months

  if (!amount || !rate || !years) return;

  const x = Math.pow(1 + rate, years);
  const monthly = (amount * rate * x) / (x - 1);

  if (!isFinite(monthly)) return;

  const total = monthly * years;
  const interest = total - amount;

  document.getElementById("monthly").innerText = "$" + monthly.toFixed(2);
  document.getElementById("total").innerText = "$" + total.toFixed(2);
  document.getElementById("interest").innerText = "$" + interest.toFixed(2);

  document.getElementById("result").classList.remove("hidden");
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
