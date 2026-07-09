<?php // header.php ?>
<?php
// Ensure protocol & domain are always available
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$domain   = $_SERVER['HTTP_HOST'];
$current_url = $protocol . $domain . $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Basic Meta -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= htmlspecialchars($meta_title ?? $page_title ?? "Tools Hub") ?></title>
  <meta name="description" content="<?= htmlspecialchars($meta_desc ?? 'Use free online tools at TG Data Hub. Image Compressor, Loan Calculator, Password Generator and more.') ?>">
  <meta name="keywords" content="<?= htmlspecialchars($meta_keywords ?? 'online tools, free tools, loan calculator, image compressor, password generator, qr code, TG Data Hub') ?>">
  <meta name="robots" content="index, follow">
  <meta name="author" content="TG Data Hub">
  <meta name="theme-color" content="#4f46e5"> <!-- Indigo accent for browsers -->
  <meta name="google-adsense-account" content="ca-pub-xxxxxxxxx">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-xxxxxxxxxxx"
     crossorigin="anonymous"></script>
  <!-- Canonical -->
  <link rel="canonical" href="<?= htmlspecialchars($canonical ?? $current_url) ?>" />

  <!-- Open Graph -->
  <meta property="og:title" content="<?= htmlspecialchars($meta_title ?? $page_title ?? 'Tools Hub') ?>">
  <meta property="og:description" content="<?= htmlspecialchars($meta_desc ?? 'Try free and secure online tools.') ?>">
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?= htmlspecialchars($canonical ?? $current_url) ?>">
  <meta property="og:image" content="<?= htmlspecialchars($og_image ?? $protocol . $domain . '/assets/images/preview.png') ?>">

  <!-- Twitter -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?= htmlspecialchars($meta_title ?? $page_title ?? 'Tools Hub') ?>">
  <meta name="twitter:description" content="<?= htmlspecialchars($meta_desc ?? 'Explore TG Data Hub free tools.') ?>">
  <meta name="twitter:image" content="<?= htmlspecialchars($og_image ?? $protocol . $domain . '/assets/images/preview.png') ?>">

  <!-- TailwindCSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Hover Effect -->
  <style>
    .lift {transition:transform .2s, box-shadow .2s}
    @media (hover:hover) and (pointer:fine){
      .lift:hover {transform:translateY(-4px); box-shadow:0 12px 26px rgba(0,0,0,.12)}
    }
  </style>
</head>


<body class="min-h-screen flex flex-col bg-white text-slate-800 text-base md:text-lg">

<!-- ===== Header (lighter glass effect) ===== -->
<header class="sticky top-0 z-50 bg-white/50 backdrop-blur-sm backdrop-saturate-150 border-b border-slate-100 shadow-sm">
  <div class="max-w-7xl mx-auto px-4">
    <div class="h-16 md:h-20 flex items-center justify-between">
      <!-- Brand -->
      <a href="/" class="font-extrabold text-2xl md:text-3xl text-blue-500 tracking-tight">
        TG Data Hub Tools
      </a>

      <!-- Desktop nav -->
      <nav class="hidden sm:flex items-center gap-6 text-sm md:text-base text-slate-600">
        <a href="/" class="hover:text-indigo-600">Home</a>
        <a href="/about.php" class="hover:text-indigo-600">About</a>
        <a href="/contact.php" class="hover:text-indigo-600">Contact</a>
        <a href="/privacy-policy.php" class="hover:text-indigo-600">Privacy</a>
      </nav>

      <!-- Mobile menu button -->
      <button id="mnavBtn"
        class="sm:hidden inline-flex items-center justify-center p-2.5 rounded border border-slate-100 bg-white/40 backdrop-blur-sm"
        aria-label="Open menu" aria-controls="mnavPanel" aria-expanded="false">
        <svg class="w-6 h-6 text-slate-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
          <path stroke-linecap="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16"/>
        </svg>
      </button>
    </div>
  </div>

  <!-- Mobile overlay + panel -->
  <div class="sm:hidden" id="mnavWrap">
    <div id="mnavOverlay" 
        class="hidden fixed inset-0 top-16 md:top-20 bg-black/30 transition-opacity duration-200"></div>

    <div id="mnavPanel"
        class="hidden absolute inset-x-0 top-16 md:top-20 origin-top bg-white border-b border-slate-200
              shadow-sm transition transform duration-200 scale-y-95 opacity-0">
      <nav class="px-4 py-4 flex flex-col gap-2 text-base">
        <a href="/" class="py-2 px-2 rounded hover:bg-slate-50">Home</a>
        <a href="/about.php" class="py-2 px-2 rounded hover:bg-slate-50">About</a>
        <a href="/contact.php" class="py-2 px-2 rounded hover:bg-slate-50">Contact</a>
        <a href="/privacy-policy.php" class="py-2 px-2 rounded hover:bg-slate-50">Privacy</a>
      </nav>
    </div>
  </div>
</header>

<main class="flex-1">
