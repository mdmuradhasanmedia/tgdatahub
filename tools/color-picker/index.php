<?php
// /tools/color-picker/index.php

// ==== Dynamic Variables (edit these per tool) ====
$tool_name     = "Color Picker + Color Converter (HEX ↔ RGB ↔ HSL)"; 
$tool_details  = "Pick a color easily and convert between HEX, RGB, and HSL formats using our free online color picker and converter.";
$why_use_text  = "Colors are a vital part of design and development, but converting between formats manually can be confusing. Our Color Picker and Converter tool makes it super simple to select any color and get its values in HEX, RGB, or HSL instantly.  

You can use this tool for web design, graphic design, UI/UX development, or even quick reference for CSS and digital projects.  

The tool is lightweight, fast, and works directly in your browser. No extra software needed — just pick your color and copy the values.";
$how_to_use    = [
  "Step 1 - Use the color input field to pick your desired color.",
  "Step 2 - Instantly view the color values in HEX, RGB, and HSL formats.",
  "Step 3 - Copy the values with a single click to use in your code or design project.",
  "Step 4 - Try different colors until you find the perfect match."
];

// ==== FAQ Placeholder (Template Guideline) ====
$faqs = [
  [
    "What is a Color Picker + Color Converter tool?", 
    "A color picker tool allows you to visually select a color and instantly see its code in different formats like HEX, RGB, and HSL. This is useful for web developers, designers, and digital creators who often need to copy accurate color codes for projects. It saves time compared to manual conversion and reduces mistakes."
  ],
  [
    "Why should I use this Color Picker instead of built-in design software?", 
    "While design software like Photoshop or Figma has color tools, sometimes you just need a quick, lightweight solution. Our tool works directly in your browser, loads instantly, and lets you copy color codes without opening heavy apps. It is especially useful when working on coding projects or writing CSS styles quickly."
  ],
  [
    "What formats does this Color Converter support?", 
    "This tool supports HEX (e.g., #4f46e5), RGB (e.g., rgb(79, 70, 229)), and HSL (e.g., hsl(243, 75%, 59%)). These are the most common formats used in web and graphic design. You can easily copy-paste them into your CSS, HTML, or design software."
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
    <div class="text-center">
      <input type="color" id="colorInput" value="#4f46e5" class="w-32 h-16 cursor-pointer border border-slate-300 rounded-md shadow-sm">
      <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4 text-slate-700">
        <div class="border border-slate-200 rounded-lg p-3">
          <h3 class="font-semibold flex items-center gap-2">
            <!-- HEX SVG -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 01-8 0M12 7v10m0 0H9m3 0h3"/>
            </svg>
            HEX
          </h3>
          <p id="hexValue" class="mt-2 font-mono text-indigo-700">#4f46e5</p>
        </div>
        <div class="border border-slate-200 rounded-lg p-3">
          <h3 class="font-semibold flex items-center gap-2">
            <!-- RGB SVG -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <circle cx="12" cy="12" r="9" stroke-width="2" />
            </svg>
            RGB
          </h3>
          <p id="rgbValue" class="mt-2 font-mono text-blue-600">rgb(79, 70, 229)</p>
        </div>
        <div class="border border-slate-200 rounded-lg p-3">
          <h3 class="font-semibold flex items-center gap-2">
            <!-- HSL SVG -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path d="M12 3v18M3 12h18" stroke-width="2" stroke-linecap="round"/>
            </svg>
            HSL
          </h3>
          <p id="hslValue" class="mt-2 font-mono text-sky-600">hsl(243, 75%, 59%)</p>
        </div>
      </div>
    </div>
    <script>
      const colorInput = document.getElementById("colorInput");
      const hexValue = document.getElementById("hexValue");
      const rgbValue = document.getElementById("rgbValue");
      const hslValue = document.getElementById("hslValue");

      function hexToRgb(hex) {
        let r = 0, g = 0, b = 0;
        if (hex.length == 4) {
          r = "0x" + hex[1] + hex[1];
          g = "0x" + hex[2] + hex[2];
          b = "0x" + hex[3] + hex[3];
        } else if (hex.length == 7) {
          r = "0x" + hex[1] + hex[2];
          g = "0x" + hex[3] + hex[4];
          b = "0x" + hex[5] + hex[6];
        }
        return [+r, +g, +b];
      }

      function rgbToHsl(r, g, b) {
        r /= 255; g /= 255; b /= 255;
        let max = Math.max(r,g,b), min = Math.min(r,g,b);
        let h, s, l = (max + min) / 2;
        if(max == min){
          h = s = 0;
        } else {
          let d = max - min;
          s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
          switch(max){
            case r: h = (g - b) / d + (g < b ? 6 : 0); break;
            case g: h = (b - r) / d + 2; break;
            case b: h = (r - g) / d + 4; break;
          }
          h /= 6;
        }
        return [Math.round(h*360), Math.round(s*100), Math.round(l*100)];
      }

      colorInput.addEventListener("input", () => {
        let hex = colorInput.value;
        hexValue.textContent = hex;
        let [r, g, b] = hexToRgb(hex);
        rgbValue.textContent = `rgb(${r}, ${g}, ${b})`;
        let [h, s, l] = rgbToHsl(r, g, b);
        hslValue.textContent = `hsl(${h}, ${s}%, ${l}%)`;
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
