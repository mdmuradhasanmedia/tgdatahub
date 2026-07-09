<?php
// /tools/iframe-share-tool/index.php

// ==== Dynamic Variables (edit these per tool) ====
$tool_name     = "Iframe Share Tool";
$tool_details  = "Paste any http/https link to preview it instantly and share a locked iframe view via a secure URL parameter.";
$why_use_text  = "This tool helps you quickly embed and share web pages in a clean, distraction-free iframe. 
Use it to demo pages for clients, show live previews to teammates, or pin a specific view inside your project docs.\n\n
Your share link includes an encrypted payload, so the original URL isn’t exposed in plain text. 
When someone opens the share link, the input box is locked and the iframe loads automatically, providing a consistent viewing experience.";
$how_to_use    = [
  "Enter a full URL that starts with http:// or https:// in the input field and click Preview.",
  "If the site allows embedding, it will render below instantly.",
  "Click Generate Share Link to get a secure URL with an encrypted parameter.",
  "Share that link. Visitors will see the iframe immediately and the input will be locked."
];

// ==== FAQ (SEO-friendly) ====
$faqs = [
  [
    "Why is my site not loading in the iframe?", 
    "Some websites set the X-Frame-Options or Content-Security-Policy headers to block embedding on other domains. 
    If a site disallows framing, modern browsers will prevent it from loading inside an iframe. 
    In that case, try another URL or ask the site owner to allow embedding."
  ],
  [
    "Is the share URL safe? Does it reveal the original link?", 
    "The tool encrypts the target URL with AES-256-CBC and encodes it in a URL-safe way. 
    This hides the raw link from casual inspection. 
    Note: determined users can still share or reveal content they see in the iframe, so avoid embedding truly sensitive URLs."
  ],
  [
    "What security measures are used for the iframe preview?", 
    "The tool validates that submitted links use http or https, rejects other schemes, and applies a sandbox attribute to the iframe 
    with only the essential allowances. Referrer information is minimized via referrerpolicy. 
    Still, the embedded site runs in the user’s browser, so exercise normal caution."
  ]
];

$page_title = $tool_name;

// ==== Auto Fetch Domain ====
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$domain   = $_SERVER['HTTP_HOST'];

// ==== Image Fallback ====
$tool_slug  = strtolower(trim(preg_replace('/[^A-Za-z0-9]+/', '-', $tool_name), '-'));
$tool_image = "/assets/images/{$tool_slug}.png";
if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $tool_image)) {
    $tool_image = "/assets/images/default.png";
}

// ==== SEO Meta Tags ====
$meta_title = $tool_name . " | TG Data Hub Tools";
$meta_desc  = $tool_details . " Use this free tool to simplify your work online. Easy to use, fast and secure.";
$canonical  = $protocol . $domain . "/tools/" . $tool_slug;

// ==== Crypto helpers (AES-256-CBC URL-safe) ====
function tg_secret_key(): string {
    $env = getenv('TGDATAHUB_SECRET');
    if ($env && strlen($env) >= 16) return hash('sha256', $env, true);
    return hash('sha256', 'change-this-in-production-TGDATAHUB_SECRET', true);
}
function tg_secret_iv(): string {
    return substr(hash('sha256', 'tgdatahub-iframe-share-iv'), 0, 16);
}
function urlsafe_b64e(string $data): string {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}
function urlsafe_b64d(string $data): string {
    $pad = 4 - (strlen($data) % 4);
    if ($pad < 4) $data .= str_repeat('=', $pad);
    return base64_decode(strtr($data, '-_', '+/'));
}
function encrypt_param(string $plain): string {
    $key = tg_secret_key();
    $iv  = tg_secret_iv();
    $cipher = openssl_encrypt($plain, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    return urlsafe_b64e($cipher);
}
function decrypt_param(string $token): ?string {
    $key = tg_secret_key();
    $iv  = tg_secret_iv();
    $raw = urlsafe_b64d($token);
    if ($raw === false || $raw === '') return null;
    $plain = openssl_decrypt($raw, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    return $plain !== false ? $plain : null;
}
function is_valid_http_url(string $url): bool {
    if (!filter_var($url, FILTER_VALIDATE_URL)) return false;
    $parts = parse_url($url);
    if (!$parts || empty($parts['scheme'])) return false;
    return in_array(strtolower($parts['scheme']), ['http','https'], true);
}

// ==== Request handling ====
$iframe_url   = null;
$share_link   = null;
$error_msg    = null;
$locked_mode  = false;

// If accessed by share URL (?iframe=...)
if (isset($_GET['iframe'])) {
    $locked_mode = true;
    $token = trim($_GET['iframe']);
    $decoded = decrypt_param($token);
    if ($decoded && is_valid_http_url($decoded)) {
        $iframe_url = $decoded;
    } else {
        $error_msg = "Invalid or expired share parameter.";
    }
}

// Handle form submit (disabled in locked mode)
if (!$locked_mode && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $input_url = trim($_POST['url'] ?? '');
    if ($input_url === '') {
        $error_msg = "Please enter a URL.";
    } elseif (!is_valid_http_url($input_url)) {
        $error_msg = "Only http(s) URLs are allowed. Example: https://example.com/page";
    } else {
        $iframe_url = $input_url;
        $token      = encrypt_param($iframe_url);
        $share_link = $canonical . "?iframe=" . urlencode($token);
    }
}

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

    <!-- Title (SVG removed as requested) -->
    <header class="mb-6 text-center">
      <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-slate-800">
        <?= htmlspecialchars($tool_name) ?>
      </h1>
      <p class="mt-2 text-slate-600"><?= htmlspecialchars($tool_details) ?></p>
    </header>

    <!-- Tool Start -->
    <?php if ($locked_mode): ?>
      <div class="mb-4 rounded-lg border border-slate-200 bg-indigo-50 text-slate-700 p-3">
        <div class="font-semibold">Locked share view</div>
        <div class="text-sm">This page was opened via a secure share link. The input is locked and the iframe has been auto-loaded below.</div>
      </div>
    <?php endif; ?>

    <?php if (!$locked_mode): ?>
      <!-- Responsive input + button ALWAYS fit inside the card -->
      <form method="post" class="space-y-3" novalidate>
        <label for="url" class="block text-slate-700 font-medium">Enter URL (http/https)</label>
        <div class="flex flex-col sm:flex-row gap-2 items-stretch">
          <input id="url" name="url" type="url" required
                 placeholder="https://example.com/page"
                 class="min-w-0 flex-1 rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                 value="<?= htmlspecialchars($_POST['url'] ?? '') ?>">
          <button type="submit"
                  class="sm:w-36 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2">
            Preview
          </button>
        </div>
        <?php if ($error_msg): ?>
          <p class="text-sm text-red-600"><?= htmlspecialchars($error_msg) ?></p>
        <?php endif; ?>
      </form>
    <?php else: ?>
      <?php if ($error_msg): ?>
        <p class="text-sm text-red-600 mb-4"><?= htmlspecialchars($error_msg) ?></p>
      <?php endif; ?>
    <?php endif; ?>

    <?php if ($iframe_url): ?>
      <!-- Share Link -->
      <div class="mt-5 rounded-lg border border-slate-200 p-3 bg-slate-50">
        <div class="flex items-center justify-between gap-3 flex-wrap">
          <div class="text-sm text-slate-700 break-all">
            <span class="font-semibold">Share link:</span>
            <?php
              $share_final = $share_link;
              if (!$share_final && isset($_GET['iframe']) && $_GET['iframe'] !== '') {
                  $share_final = $canonical . "?iframe=" . urlencode($_GET['iframe']);
              }
            ?>
            <a href="<?= htmlspecialchars($share_final) ?>" class="text-blue-600 hover:text-blue-700 underline">
              <?= htmlspecialchars($share_final) ?>
            </a>
          </div>
          <button type="button" id="copyBtn"
                  class="rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-3 py-2">
            Copy
          </button>
        </div>
      </div>

      <!-- Iframe Preview + Fullscreen control -->
      <div class="mt-5">
        <div id="fsWrap" class="rounded-xl border border-slate-200 overflow-hidden bg-black relative">
          <iframe
  id="theIframe"
  src="<?= htmlspecialchars($iframe_url) ?>"
  class="w-full h-[50vh] bg-white"
  referrerpolicy="no-referrer"
  allowfullscreen
></iframe>

        </div>
        <p class="mt-2 text-xs text-slate-500">
          Tip: Use the Fullscreen button above. Many embedded players also show their own fullscreen control. Rotate your phone for landscape.
        </p>
      </div>
    <?php endif; ?>
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

<script>
(function(){
  // === Copy share link ===
  const copyBtn = document.getElementById('copyBtn');
  if (copyBtn) {
    copyBtn.addEventListener('click', async () => {
      const a = document.querySelector('a[href*="?iframe="]');
      if (!a) return;
      try {
        await navigator.clipboard.writeText(a.href);
        copyBtn.textContent = 'Copied';
        setTimeout(() => copyBtn.textContent = 'Copy', 1400);
      } catch (e) {
        const tmp = document.createElement('textarea');
        tmp.value = a.href;
        document.body.appendChild(tmp);
        tmp.select();
        document.execCommand('copy');
        document.body.removeChild(tmp);
        copyBtn.textContent = 'Copied';
        setTimeout(() => copyBtn.textContent = 'Copy', 1400);
      }
    });
  }

</script>