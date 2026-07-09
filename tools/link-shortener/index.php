<?php
// /tools/link-shortener/index.php

// ==== Dynamic Variables ====
$tool_name     = "Link Shortener"; 
$tool_details  = "Free online link shortener tool to convert long URLs into short and simple links. Fast, secure, and reliable.";
$why_use_text  = "A Link Shortener is an essential tool for anyone who wants to share long and complicated URLs in a clean, professional way. 
By shortening links, you make them easier to remember, share, and embed in social media posts, messages, or even printed materials.\n\n
Shortened links are not just about looks – they also improve user experience by making links more clickable. 
They are ideal for marketers, bloggers, developers, or anyone who wants to improve engagement and tracking of links.\n\n
With our free Link Shortener tool, you can generate a unique, permanent short link in just one click. 
It saves time, reduces complexity, and ensures your links stay neat and user-friendly.";
$how_to_use    = [
  "Step 1 - Copy the long URL that you want to shorten.",
  "Step 2 - Paste the URL into the input box of the Link Shortener tool.",
  "Step 3 - Click the 'Shorten' button to generate a short link instantly.",
  "Step 4 - Copy the new short link and use it anywhere – websites, emails, or social media."
];

// ==== FAQ ====
$faqs = [
  [
    "What is a Link Shortener and why do I need it?", 
    "A link shortener is a tool that converts long, complicated URLs into shorter, simpler links. 
    Shortened links are easier to share on social media, in messages, or in print. 
    They make your links look professional and more user-friendly."
  ],
  [
    "Are shortened links safe to use?", 
    "Yes, our Link Shortener generates secure and permanent links. 
    All shortened links redirect to the original URL without altering the content. 
    For additional trust, you can preview the short link before sharing."
  ],
  [
    "Can I track clicks on my shortened links?", 
    "Currently, this tool is designed for quick and reliable link shortening. 
    Advanced features like analytics and tracking may be added later. 
    For now, you can use the generated short links freely anywhere."
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
    <div class="max-w-lg mx-auto">
      <form id="shortenForm" class="space-y-4">
        <div class="flex rounded-lg border border-slate-300 overflow-hidden">
          <input type="url" id="linkInput" name="my-link" class="flex-grow px-3 py-2 outline-none text-slate-700" placeholder="Enter your long URL here..." required>
          <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5">Shorten</button>
        </div>
      </form>

      <div id="resultBox" class="hidden mt-4">
        <label class="block text-slate-700 font-medium mb-1">Your Short Link:</label>
        <div class="flex rounded-lg border border-slate-300 overflow-hidden">
          <input type="text" id="shortLink" class="flex-grow px-3 py-2 text-slate-700 font-semibold" readonly>
          <button id="copyBtn" type="button" class="bg-blue-500 hover:bg-blue-600 text-white px-5">Copy</button>
        </div>
      </div>

      <p id="errorBox" class="text-red-600 mt-3 hidden"></p>
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
document.getElementById("shortenForm").addEventListener("submit", async function(e) {
    e.preventDefault();

    const link = document.getElementById("linkInput").value.trim();
    if (!link) {
        document.getElementById("errorBox").innerText = "Please enter a valid link.";
        document.getElementById("errorBox").classList.remove("hidden");
        return;
    }

    const formData = new FormData();
    formData.append("my-link", link);

    try {
        let response = await fetch("/tools/link-shortener/server/proxy.php", {
            method: "POST",
            body: formData
        });

        if (!response.ok) throw new Error("Server returned " + response.status);

        let data = await response.json();

        if (data.success) {
            document.getElementById("resultBox").classList.remove("hidden");
            document.getElementById("shortLink").value = data.short_link;
            document.getElementById("errorBox").classList.add("hidden");
        } else {
            document.getElementById("errorBox").innerText = data.message || "Failed to shorten the link.";
            document.getElementById("errorBox").classList.remove("hidden");
        }
    } catch (err) {
        document.getElementById("errorBox").innerText = err.message;
        document.getElementById("errorBox").classList.remove("hidden");
    }
});

document.getElementById("copyBtn").addEventListener("click", function() {
    const shortLink = document.getElementById("shortLink");
    shortLink.select();
    shortLink.setSelectionRange(0, 99999);
    document.execCommand("copy");
    this.innerText = "Copied";
    setTimeout(() => this.innerText = "Copy", 2000);
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
