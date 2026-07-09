<?php
// /tools/password-generator/index.php

// ==== Dynamic Variables (edit these per tool) ====
$tool_name     = "Password Generator"; 
$tool_details  = "Generate strong, secure, and random passwords instantly with our free online Password Generator. Perfect for protecting your online accounts.";
$why_use_text  = "A strong password is the first step towards securing your online accounts. Weak or reused passwords make your accounts vulnerable to hacking.  

Our Password Generator creates unique, complex passwords instantly. You can choose the length, include symbols, numbers, and uppercase letters.  
It’s simple, fast, and secure — no data is stored, and the password is generated locally in your browser.";  

$how_to_use    = [
  "Step 1 - Choose the password length (default 12 characters).",
  "Step 2 - Select options: include uppercase letters, numbers, and special symbols.",
  "Step 3 - Click **Generate Password** to create a new strong password.",
  "Step 4 - Copy the password and use it in your accounts or password manager."
];

// ==== FAQ ====
$faqs = [
  [
    "Why should I use a Password Generator?", 
    "Manually creating secure passwords can be difficult and time-consuming. A password generator creates random, complex passwords instantly, making them much harder to guess or crack."
  ],
  [
    "Are the generated passwords stored anywhere?", 
    "No. The passwords are generated locally in your browser using JavaScript. Nothing is uploaded or saved on our servers, ensuring complete privacy."
  ],
  [
    "What makes a strong password?", 
    "A strong password is long (12+ characters), includes uppercase and lowercase letters, numbers, and special symbols. This combination makes it resistant to brute-force attacks."
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
    <div class="space-y-4">
      <!-- Result -->
      <div class="flex items-center gap-3">
        <input 
          id="result" 
          readonly 
          class="flex-1 border border-slate-300 rounded-lg px-3 py-3 font-mono text-lg bg-slate-50" 
          placeholder="Generate a new password"
        />
        <button 
          onclick="copyPassword()" 
          class="px-4 py-3 rounded-lg bg-blue-500 hover:bg-blue-600 text-white font-semibold transition">
          Copy
        </button>
      </div>

      <!-- Options -->
      <div class="grid md:grid-cols-2 gap-4">
        <div>
          <label class="block mb-1 font-medium">Length:</label>
          <input type="number" id="length" value="12" min="4" max="50" class="w-full border rounded-lg px-3 py-2">
        </div>
        <div class="flex items-center gap-2">
          <input type="checkbox" id="uppercase" checked>
          <label for="uppercase">Include Uppercase</label>
        </div>
        <div class="flex items-center gap-2">
          <input type="checkbox" id="numbers" checked>
          <label for="numbers">Include Numbers</label>
        </div>
        <div class="flex items-center gap-2">
          <input type="checkbox" id="symbols" checked>
          <label for="symbols">Include Symbols</label>
        </div>
      </div>

      <!-- Generate Button -->
      <button 
        onclick="generatePassword()" 
        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-3 rounded-lg transition">
        Generate Password
      </button>
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
function generatePassword() {
  const length = document.getElementById("length").value;
  const includeUppercase = document.getElementById("uppercase").checked;
  const includeNumbers = document.getElementById("numbers").checked;
  const includeSymbols = document.getElementById("symbols").checked;

  let chars = "abcdefghijklmnopqrstuvwxyz";
  if (includeUppercase) chars += "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  if (includeNumbers) chars += "0123456789";
  if (includeSymbols) chars += "!@#$%^&*()_+[]{}|;:,.<>?";

  let password = "";
  for (let i = 0; i < length; i++) {
    password += chars.charAt(Math.floor(Math.random() * chars.length));
  }
  document.getElementById("result").value = password;
}

function copyPassword() {
  const result = document.getElementById("result");
  result.select();
  document.execCommand("copy");
  alert("Password copied to clipboard!");
}
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
