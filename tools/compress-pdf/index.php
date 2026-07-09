<?php
// /tools/compress-pdf/index.php

// ==== Dynamic Variables (edit these per tool) ====
$tool_name     = "Compress PDF"; 
$tool_details  = "Reduce the size of your PDF files online without losing quality. Fast, secure, and free."; 

$why_use_text  = "Large PDF files can be difficult to share via email or upload to websites. Compressing them makes it easier to handle.\n\nThis tool reduces file size while maintaining good readability, so you don’t need to worry about quality loss.\n\nIt’s 100% browser-based, so your files are never stored on any server, ensuring full privacy and security.";

$how_to_use    = [
  "Step 1 - Drag & drop your PDF files or click to upload from your device.",
  "Step 2 - Choose your preferred compression quality using the slider (lower quality = smaller file).",
  "Step 3 - The tool will process each page and rebuild a compressed version in your browser.",
  "Step 4 - Download the compressed PDF files instantly."
];

// ==== FAQ Placeholder ====
$faqs = [
  [
    "Is this PDF compressor safe to use?", 
    "Yes, the compression runs directly in your browser using secure JavaScript libraries. No files are uploaded to any server, so your documents remain private."
  ],
  [
    "Will the quality of my PDF be affected?", 
    "You can control the quality with a slider. Text remains sharp, and images are re-encoded to reduce size. Setting lower quality makes files much smaller but may reduce image clarity."
  ],
  [
    "Can I compress multiple PDF files?", 
    "Yes, you can drag and drop multiple files at once. Each file will be compressed separately, and you can download them individually."
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

<!-- ==== Libraries ==== -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.14.305/pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>

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

    <!-- ==== Tool Start ==== -->
    <div id="dropZone" class="border-2 border-dashed border-indigo-300 rounded-xl p-6 md:p-10 text-center cursor-pointer">
      <p class="text-slate-600">Drag & Drop your PDFs here or <span class="text-indigo-600 font-semibold">Click to Upload</span></p>
      <input type="file" id="pdfInput" accept="application/pdf" multiple class="hidden">
    </div>

    <div class="mt-4">
      <label class="font-semibold text-slate-700">Compression Quality:</label>
      <input id="quality" type="range" min="0.2" max="0.9" step="0.1" value="0.6" class="w-full">
      <p class="text-slate-600 text-sm">Lower quality = smaller size (default 0.6)</p>
    </div>

    <div id="progress" class="hidden mt-4 text-slate-600">Processing...</div>

    <div id="results" class="hidden mt-6">
      <h3 class="text-lg font-semibold text-slate-700 mb-2">Results</h3>
      <div id="fileList" class="space-y-4"></div>
    </div>
    <!-- ==== Tool End ==== -->

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

<!-- ==== JS Logic ==== -->
<script>
const dropZone = document.getElementById("dropZone");
const input = document.getElementById("pdfInput");
const progress = document.getElementById("progress");
const results = document.getElementById("results");
const fileList = document.getElementById("fileList");
const qualityInput = document.getElementById("quality");

dropZone.addEventListener("click", () => input.click());
["dragover","dragenter"].forEach(evt => {
  dropZone.addEventListener(evt, e => {
    e.preventDefault(); dropZone.classList.add("bg-indigo-50");
  });
});
["dragleave","drop"].forEach(evt => {
  dropZone.addEventListener(evt, e => {
    e.preventDefault(); dropZone.classList.remove("bg-indigo-50");
  });
});
dropZone.addEventListener("drop", e => handleFiles(e.dataTransfer.files));
input.addEventListener("change", e => handleFiles(e.target.files));

async function handleFiles(files) {
  if (!files.length) return;

  progress.classList.remove("hidden");
  results.classList.add("hidden");
  fileList.innerHTML = "";

  for (let file of files) {
    const row = document.createElement("div");
    row.className = "border rounded-lg p-3 bg-slate-50";
    row.innerHTML = `<p class="font-semibold text-slate-700">${file.name}</p>
      <p class="text-slate-600">Original: ${(file.size/1024/1024).toFixed(2)} MB</p>
      <p class="text-slate-600">Compressing...</p>`;
    fileList.appendChild(row);

    try {
      const compressedBlob = await compressPDF(file, parseFloat(qualityInput.value));
      const url = URL.createObjectURL(compressedBlob);

      row.innerHTML = `<p class="font-semibold text-slate-700">${file.name}</p>
        <p class="text-slate-600">Original: ${(file.size/1024/1024).toFixed(2)} MB</p>
        <p class="text-slate-600">Compressed: ${(compressedBlob.size/1024/1024).toFixed(2)} MB</p>
        <a href="${url}" download="compressed-${file.name}" class="mt-2 inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">Download</a>`;
    } catch (err) {
      row.innerHTML += `<p class="text-red-600">Failed: ${err.message}</p>`;
    }
  }

  progress.classList.add("hidden");
  results.classList.remove("hidden");
}

async function compressPDF(file, quality=0.6) {
  const arrayBuffer = await file.arrayBuffer();
  const pdf = await pdfjsLib.getDocument({data: arrayBuffer}).promise;
  const pdfDoc = await PDFLib.PDFDocument.create();

  for (let i=1; i<=pdf.numPages; i++) {
    const page = await pdf.getPage(i);
    const viewport = page.getViewport({scale: 1});

    const canvas = document.createElement("canvas");
    const ctx = canvas.getContext("2d");
    canvas.width = viewport.width;
    canvas.height = viewport.height;

    await page.render({canvasContext: ctx, viewport}).promise;

    const imgData = canvas.toDataURL("image/jpeg", quality);
    const jpgImage = await pdfDoc.embedJpg(imgData);

    const newPage = pdfDoc.addPage([viewport.width, viewport.height]);
    newPage.drawImage(jpgImage, {
      x: 0, y: 0, width: viewport.width, height: viewport.height
    });
  }

  const pdfBytes = await pdfDoc.save();
  return new Blob([pdfBytes], {type: "application/pdf"});
}
</script>
