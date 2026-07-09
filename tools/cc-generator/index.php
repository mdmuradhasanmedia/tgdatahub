<?php
// /tools/cc-generator/index.php

// ==== Dynamic Variables (edit these per tool) ====
$tool_name     = "CC Generator"; 
$tool_details  = "Generate Credit Card Number with Date and CVV.";
$why_use_text  = "This tool can be useful for developers, students, or testers who need card-like number data while building apps or practicing form validation.\n\nThe generated numbers are completely fake and safe to use for demo projects.\n\nThis helps to avoid misuse of sensitive real-world data while learning or testing.";
$how_to_use    = [
  "Step 1 - Enter a BIN or prefix pattern (optional).",
  "Step 2 - Choose how many fake cards you want to generate.",
  "Step 3 - Click on the Generate button.",
  "Step 4 - Copy the generated numbers for your safe testing or educational purpose."
];

// ==== FAQ ====
$faqs = [
  ["Does this tool generate real credit cards?", "No. It only generates random fake card-like numbers for education and testing. They are not real and cannot be used for payments."],
  ["Why should I use fake card numbers?", "Fake card numbers are safe for testing payment forms, demos, and educational coding exercises without exposing sensitive data."],
  ["Can I use the generated numbers online?", "No. These numbers will never work on real payment systems. They are only for safe local or demo use."]
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
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Input Form -->
      <div class="space-y-4">

        <!-- BIN -->
        <label for="bin" class="block font-semibold text-slate-700">BIN</label>
        <div class="flex items-center border rounded px-3 py-2 bg-white">
          <svg class="w-5 h-5 text-indigo-600 mr-2" fill="none" stroke="currentColor" stroke-width="2"
               viewBox="0 0 24 24"><path d="M2 7h20M2 11h20M2 15h20M2 19h20"/></svg>
          <input id="bin" type="text" placeholder="e.g. 4556xxxxxxxxxxxx" class="flex-1 outline-none">
        </div>

        <!-- Date -->
        <label class="block font-semibold text-slate-700">Date</label>
        <div class="flex gap-3">
          <!-- Month -->
          <div class="flex items-center border rounded px-3 py-2 bg-white w-1/2">
            <svg class="w-5 h-5 text-indigo-600 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24"><path d="M8 7V3M16 7V3M3 11h18M5 21h14a2 2 0 002-2V7H3v12a2 2 0 002 2z"/></svg>
            <select id="month" class="flex-1 outline-none bg-transparent">
              <option value="">Random</option>
              <?php for ($m=1;$m<=12;$m++): ?>
                <option value="<?= str_pad($m,2,"0",STR_PAD_LEFT) ?>"><?= str_pad($m,2,"0",STR_PAD_LEFT) ?></option>
              <?php endfor; ?>
            </select>
          </div>

          <!-- Year -->
          <div class="flex items-center border rounded px-3 py-2 bg-white w-1/2">
            <svg class="w-5 h-5 text-indigo-600 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24"><path d="M8 7V3M16 7V3M3 11h18M5 21h14a2 2 0 002-2V7H3v12a2 2 0 002 2z"/></svg>
            <select id="year" class="flex-1 outline-none bg-transparent">
              <option value="">Random</option>
              <?php 
                $currentYear = date("Y");
                for ($y=$currentYear; $y<=$currentYear+30; $y++): ?>
                  <option value="<?= $y ?>"><?= $y ?></option>
              <?php endfor; ?>
            </select>
          </div>
        </div>

        <!-- CVV -->
        <label for="cvv" class="block font-semibold text-slate-700">CVV</label>
        <div class="flex items-center border rounded px-3 py-2 bg-white">
          <svg class="w-5 h-5 text-indigo-600 mr-2" fill="none" stroke="currentColor" stroke-width="2"
               viewBox="0 0 24 24"><path d="M12 11c.53 0 1.04.21 1.41.59.38.37.59.88.59 1.41s-.21 1.04-.59 1.41c-.37.38-.88.59-1.41.59s-1.04-.21-1.41-.59c-.38-.37-.59-.88-.59-1.41s.21-1.04.59-1.41c.37-.38.88-.59 1.41-.59z"/></svg>
          <input id="cvv" type="text" placeholder="Leave blank to randomize" class="flex-1 outline-none">
        </div>

        <!-- Quantity -->
        <label for="count" class="block font-semibold text-slate-700">Quantity</label>
        <div class="flex items-center border rounded px-3 py-2 bg-white">
          <svg class="w-5 h-5 text-indigo-600 mr-2" fill="none" stroke="currentColor" stroke-width="2"
               viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
          <input id="count" type="number" value="10" min="1" max="50" class="flex-1 outline-none">
        </div>

        <!-- Button -->
        <button id="generateBtn" 
                class="mt-4 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg w-full">
          Generate Cards
        </button>
      </div>

      <!-- Result Box -->
      <div>
        <label for="result" class="block font-semibold text-slate-700">Result</label>
        <textarea id="result" readonly class="w-full h-80 border rounded px-3 py-2"></textarea>
        <button onclick="copyResult()" class="mt-3 px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded">
          Copy to Clipboard
        </button>
      </div>
    </div>

    <script>
    function randNum(len) {
      let out = "";
      for (let i=0; i<len; i++) out += Math.floor(Math.random()*10);
      return out;
    }

    function luhnCheck(num) {
      let arr = (num + '').split('').reverse().map(x => parseInt(x));
      let sum = arr.reduce((acc, val, i) => acc + (i % 2 ? (val*2>9?val*2-9:val*2):val), 0);
      return sum % 10 === 0;
    }

    document.getElementById("generateBtn").addEventListener("click", function() {
      let rawBin = document.getElementById("bin").value;
      let bin = rawBin.replace(/\D/g,""); // keep only numbers
      if (!bin) bin = "";

      let month = document.getElementById("month").value;
      let year  = document.getElementById("year").value;
      let cvv   = document.getElementById("cvv").value;
      let count = parseInt(document.getElementById("count").value) || 10;
      let result = "";

      for (let i=0; i<count; i++) {
        let card = bin;
        while (card.length < 15) card += Math.floor(Math.random()*10);
        for (let d=0; d<10; d++) {
          if (luhnCheck(card+d)) { card += d; break; }
        }
        let mm = month || String(Math.floor(Math.random()*12)+1).padStart(2,"0");
        let yy = year || (new Date().getFullYear() + Math.floor(Math.random()*5)+1);
        let shortYear = yy.toString().substring(2,4); // output only last 2 digits
        let cvc = cvv || randNum(3);
        result += `${card}|${mm}|${shortYear}|${cvc}\n`;
      }

      document.getElementById("result").value = result.trim();
    });

    function copyResult() {
      let txt = document.getElementById("result");
      txt.select();
      document.execCommand("copy");
      alert("Copied to clipboard!");
    }
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
