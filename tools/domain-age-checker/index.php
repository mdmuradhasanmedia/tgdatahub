<?php
// /tools/domain-age-checker/index.php

// ==== Dynamic Variables ====
$tool_name     = "Domain Age Checker"; 
$tool_details  = "Check the exact age of any domain instantly with our free Domain Age Checker tool.";
$why_use_text  = "Domain age is an important factor in SEO and website credibility. Older domains usually carry more trust and authority.\n\nOur Domain Age Checker tool securely fetches domain's registration date, expiry date, and exact age in years, months, and days.\n\nThis is especially useful for SEO professionals, domain investors, and marketers who want to evaluate the reliability of a site.";
$how_to_use    = [
  "Step 1 - Enter a domain name (e.g., example.com) into the input box.",
  "Step 2 - Click the 'Check Domain Age' button or press Enter.",
  "Step 3 - The tool will query our secure API (server-side RDAP).",
  "Step 4 - Instantly view the creation date, expiry date, and domain age in a neat card format."
];

// ==== FAQ ====
$faqs = [
  ["How does the Domain Age Checker work?", "This tool connects to our backend API, which queries official RDAP servers for domain data. It fetches the registration and expiry dates, then calculates the exact age of the domain."],
  ["Why is domain age important?", "Domain age is often seen as a trust factor by both search engines and users. An older domain typically means reliability and authority. SEO experts and domain investors prefer domains with a longer history."],
  ["Does this tool support all TLDs?", "Yes, our API auto-detects the correct RDAP server for any TLD using IANA bootstrap data. It supports popular extensions like .com, .net, .org, as well as new ones like .xyz, .io, and more."]
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

// ==== Dynamic Meta if query param ?domain= ====
$current_domain = isset($_GET['domain']) ? htmlspecialchars($_GET['domain']) : null;
if ($current_domain) {
    $meta_title = "Domain Age of $current_domain | TG Data Hub Tools";
    $meta_desc  = "Find out the exact age, registration and expiry date of $current_domain using our free Domain Age Checker tool.";
} else {
    $meta_title = $tool_name . " | TG Data Hub Tools";
    $meta_desc  = $tool_details . " Use this free tool to analyze domain registration, expiry, and age.";
}

$canonical  = $protocol . $domain . "/tools/" . $tool_slug;

require dirname(__DIR__, 2).'/partials/header.php';
?>

<!-- ==== SEO HEAD Extra ==== -->
<meta name="description" content="<?= htmlspecialchars($meta_desc) ?>">
<link rel="canonical" href="<?= $canonical ?>">
<meta property="og:title" content="<?= htmlspecialchars($meta_title) ?>">
<meta property="og:description" content="<?= htmlspecialchars($meta_desc) ?>">
<meta property="og:type" content="website">
<meta property="og:url" content="<?= $canonical ?>">
<meta property="og:image" content="<?= $protocol . $domain . $tool_image ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= htmlspecialchars($meta_title) ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($meta_desc) ?>">
<meta name="twitter:image" content="<?= $protocol . $domain . $tool_image ?>">

<main class="max-w-5xl mx-auto px-4 py-8">
  <!-- Breadcrumbs -->
  <nav aria-label="Breadcrumb" class="mb-4 text-sm text-slate-500">
    <ol class="flex space-x-2">
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
    <div class="text-center">
      <input type="text" id="domainInput" placeholder="Enter domain (e.g., example.com)" 
        class="border border-slate-300 rounded-lg px-4 py-2 w-full md:w-2/3 mb-3"
        value="<?= $current_domain ?? '' ?>">
      <button id="checkBtn" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg font-semibold">
        Check Domain Age
      </button>
      <div id="loading" class="hidden mt-4 text-indigo-600 font-medium">
        <svg class="animate-spin inline-block w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
        </svg>
        Checking domain age...
      </div>

      <!-- Result Cards -->
      <div id="result" class="hidden mt-6 grid grid-cols-1 md:grid-cols-2 gap-4"></div>

      <!-- Social Share -->
      <div id="share" class="hidden mt-6 text-center">
        <p class="text-slate-600 mb-2">Share this result:</p>
        <div class="flex gap-4 justify-center">
          <a id="shareTwitter" target="_blank" class="text-blue-500 hover:text-blue-600">Twitter</a>
          <a id="shareFacebook" target="_blank" class="text-blue-700 hover:text-blue-800">Facebook</a>
          <a id="shareLinkedIn" target="_blank" class="text-sky-600 hover:text-sky-700">LinkedIn</a>
        </div>
      </div>
    </div>

    <script>
      const btn = document.getElementById("checkBtn");
      const input = document.getElementById("domainInput");
      const loading = document.getElementById("loading");
      const resultBox = document.getElementById("result");
      const shareBox = document.getElementById("share");

      async function checkDomain(domain) {
        try {
          if (domain.startsWith("http://") || domain.startsWith("https://")) {
            domain = new URL(domain).hostname;
          }
        } catch(e){}

        if (!domain) {
          resultBox.classList.add("hidden");
          shareBox.classList.add("hidden");
          return;
        }

        loading.classList.remove("hidden");
        resultBox.classList.add("hidden");
        shareBox.classList.add("hidden");

        try {
          const res = await fetch("/tools/domain-age-checker/server/api.php?domain=" + encodeURIComponent(domain));
          const data = await res.json();
          loading.classList.add("hidden");

          if (data.error) {
            resultBox.classList.remove("hidden");
            resultBox.innerHTML = `<div class="p-4 bg-red-50 border border-red-200 rounded-lg text-red-600">${data.error}</div>`;
          } else {
            resultBox.classList.remove("hidden");
            resultBox.innerHTML = `
              <div class="p-4 rounded-lg bg-indigo-50"><strong>Domain:</strong> ${data.domain}</div>
              <div class="p-4 rounded-lg bg-indigo-50"><strong>Created:</strong> ${data.created}</div>
              <div class="p-4 rounded-lg bg-indigo-50"><strong>Expires:</strong> ${data.expires}</div>
              <div class="p-4 rounded-lg bg-indigo-50"><strong>Domain Age:</strong> ${data.age}</div>
            `;
            shareBox.classList.remove("hidden");
            const shareUrl = encodeURIComponent(window.location.origin + "/tools/domain-age-checker/?domain=" + domain);
            const shareText = encodeURIComponent(`Domain Age of ${domain} is ${data.age}`);
            document.getElementById("shareTwitter").href = `https://twitter.com/intent/tweet?url=${shareUrl}&text=${shareText}`;
            document.getElementById("shareFacebook").href = `https://www.facebook.com/sharer/sharer.php?u=${shareUrl}`;
            document.getElementById("shareLinkedIn").href = `https://www.linkedin.com/shareArticle?mini=true&url=${shareUrl}&title=${shareText}`;
          }
        } catch (e) {
          loading.classList.add("hidden");
          resultBox.classList.remove("hidden");
          resultBox.innerHTML = `<div class="p-4 bg-red-50 border border-red-200 rounded-lg text-red-600">Server error. Please try again.</div>`;
        }
      }

      btn.addEventListener("click", () => checkDomain(input.value.trim()));
      input.addEventListener("keypress", e => { if (e.key === "Enter") checkDomain(input.value.trim()); });

      const urlParams = new URLSearchParams(window.location.search);
      const domainParam = urlParams.get("domain");
      if (domainParam) {
        input.value = domainParam;
        checkDomain(domainParam);
      }
    </script>
    <!-- Tool End -->

    <!-- Why use -->
    <div class="mt-8">
      <h2 class="text-xl font-bold text-slate-800 mb-2">Why use <?= htmlspecialchars($tool_name) ?>?</h2>
      <?php foreach (explode("\n\n", $why_use_text) as $paragraph): ?>
        <p class="text-slate-600 mb-3"><?= nl2br(htmlspecialchars(trim($paragraph))) ?></p>
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
            <summary class="cursor-pointer font-semibold flex justify-between"><?= htmlspecialchars($q) ?><span class="text-slate-400 group-open:rotate-45 transition">+</span></summary>
            <div class="mt-2 text-slate-600"><?= nl2br(htmlspecialchars_decode($a)) ?></div>
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
        "acceptedAnswer" => ["@type" => "Answer","text" => $faq[1]]
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
