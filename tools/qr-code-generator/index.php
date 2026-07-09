<?php
// /tools/qr-code-generator/index.php

// ==== Dynamic Variables ====
$tool_name     = "QR Code Generator"; 
$tool_details  = "Generate QR codes instantly from text, links, or any information with our free online QR Code Generator. Download in SVG or PNG format.";
$why_use_text  = "QR Codes make it easy to share information quickly by just scanning with a phone camera.  
You can use them for links, Wi-Fi passwords, contact information, business cards, or event promotions.  

Our QR Code Generator is simple, secure, and works directly in your browser. No data is stored — everything is generated instantly and privately on your device.";  

$how_to_use    = [
  "Step 1 - Enter the text, link, or information you want to convert into a QR code.",
  "Step 2 - Click **Generate QR Code**.",
  "Step 3 - Instantly see your QR code preview below.",
  "Step 4 - Download the QR code as **SVG** (best for print) or **PNG** (best for web)."
];

$faqs = [
  [
    "What is a QR Code?", 
    "A QR Code (Quick Response Code) is a type of barcode that can store information like text, URLs, or other data. It can be scanned with any smartphone camera."
  ],
  [
    "Can I download QR codes in different formats?", 
    "Yes! You can download your QR code in **SVG** format for high-quality printing or **PNG** format for websites, social media, and presentations."
  ],
  [
    "Is my data safe when generating QR codes?", 
    "Absolutely. The QR codes are generated locally in your browser. Your text or links are never uploaded to a server, making it completely private and secure."
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

// ==== SEO Meta ====
$meta_title = $tool_name . " | TG Data Hub Tools";
$meta_desc  = $tool_details . " Use this free tool to simplify your work online. Easy to use, fast and secure.";
$canonical  = $protocol . $domain . "/tools/" . $tool_slug;

require dirname(__DIR__, 2).'/partials/header.php';
?>

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
    <div class="space-y-4 text-center">
      <textarea 
        id="qrText" 
        rows="3" 
        class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" 
        placeholder="Enter text or URL here..."
      ></textarea>

      <button 
        onclick="generateQRCode()" 
        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-3 rounded-lg transition">
        Generate QR Code
      </button>

      <div id="qrResult" class="mt-6 hidden">
       <div id="qrContainer" class="flex justify-center">
  <div id="qrWrapper" class="w-full max-w-[180px] sm:max-w-[220px]"></div>
</div>

        <div class="mt-4 flex flex-col md:flex-row justify-center gap-3">
  <a id="downloadSvgBtn" download="qrcode.svg" 
     class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-blue-500 hover:bg-blue-600 text-white font-semibold transition">
    <!-- SVG Icon -->
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4"/>
    </svg>
    <span>Download SVG</span>
  </a>

  <a id="downloadPngBtn" download="qrcode.png" 
     class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-semibold transition">
    <!-- SVG Icon -->
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4"/>
    </svg>
    <span>Download PNG</span>
  </a>
</div>

      </div>
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

<script src="https://cdn.jsdelivr.net/npm/qrcode-svg@1.1.0/dist/qrcode.min.js"></script>
<script>
function generateQRCode() {
  const text = document.getElementById("qrText").value.trim();
  if (!text) {
    alert("Please enter some text or a URL first!");
    return;
  }

  const qr = new QRCode({
    content: text,
    container: "svg-viewbox",
    join: true,
    width: 220,
    height: 220,
    ecl: "H"
  });

  const svgMarkup = qr.svg();
const qrWrapper = document.getElementById("qrWrapper");
qrWrapper.innerHTML = svgMarkup;

// make svg responsive
const svg = qrWrapper.querySelector("svg");
svg.setAttribute("class", "w-full h-auto");
svg.removeAttribute("width");
svg.removeAttribute("height");


  // Prepare SVG download
  const svgBlob = new Blob([svgMarkup], { type: "image/svg+xml" });
  const svgUrl = URL.createObjectURL(svgBlob);
  document.getElementById("downloadSvgBtn").href = svgUrl;

  // Prepare PNG download
  const img = new Image();
  const svg64 = btoa(svgMarkup);
  const image64 = 'data:image/svg+xml;base64,' + svg64;
  img.onload = function() {
    const canvas = document.createElement("canvas");
    canvas.width = 220;
    canvas.height = 220;
    const ctx = canvas.getContext("2d");
    ctx.drawImage(img, 0, 0);
    canvas.toBlob((blob) => {
      const url = URL.createObjectURL(blob);
      document.getElementById("downloadPngBtn").href = url;
    });
  };
  img.src = image64;

  document.getElementById("qrResult").classList.remove("hidden");
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
