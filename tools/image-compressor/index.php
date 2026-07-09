<?php
// /tools/image-compressor/index.php

// ==== Dynamic Variables (edit these per tool) ====
$tool_name     = "Image Compressor"; 
$tool_details  = "Compress images online and reduce file size instantly without losing much quality. Supports JPG, PNG, and WEBP formats.";
$why_use_text  = "Our Image Compressor reduces file size while keeping images clear.  
Large images slow down websites, take extra storage, and are harder to share. By compressing them, you save bandwidth and improve loading speed.  

This tool works 100% in your browser, so your images are never uploaded to a server. It is fast, secure, and free.";  

$how_to_use    = [
  "Step 1 - Upload or drag & drop your image file (JPG, PNG, WEBP supported).",
  "Step 2 - The tool will automatically compress the image inside your browser.",
  "Step 3 - Compare the original and compressed images side-by-side with file sizes.",
  "Step 4 - Click the **Download** button to save the optimized image."
];

// ==== FAQ ====
$faqs = [
  [
    "How does the Image Compressor work?", 
    "This tool works directly in your browser using JavaScript and HTML5 Canvas.  
    It resizes and compresses images locally, so your files never leave your device."
  ],
  [
    "Will the image lose quality?", 
    "The compressor balances quality and size. Most of the time, you won’t notice visible changes, but file size can be reduced by 50-80%."
  ],
  [
    "Is this tool free and safe?", 
    "Yes! It’s 100% free and unlimited. Since compression happens in your browser, no images are uploaded to any server, keeping your data secure."
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
    <div class="border-2 border-dashed border-slate-300 rounded-xl p-6 text-center">
      <input type="file" id="imageInput" accept="image/*" class="hidden">
      <label for="imageInput" class="cursor-pointer inline-flex items-center gap-2 px-5 py-3 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition">
        <!-- Upload SVG -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 16V4m0 12l-4-4m4 4l4-4m-9 8h14a2 2 0 002-2V6a2 2 0 00-2-2H7l-5 5v9a2 2 0 002 2h2"/>
        </svg>
        <span>Upload Image</span>
      </label>
    </div>

    <div id="output" class="mt-8 hidden">
  <div class="grid md:grid-cols-2 gap-6">
    
    <!-- Original -->
    <div class="bg-white border rounded-xl p-4 text-center">
      <img id="originalPreview" class="mx-auto max-w-full h-auto rounded-lg border" alt="Original Image Preview">
      <p class="mt-2 text-slate-700">
        <strong>Original Size:</strong> <span id="originalSize">-</span>
      </p>
    </div>
    
    <!-- Compressed -->
    <div class="bg-white border rounded-xl p-4 text-center">
      <canvas id="canvas" class="mx-auto max-w-full h-auto rounded-lg border"></canvas>
      <p class="mt-2 text-slate-700">
        <strong>Compressed Size:</strong> <span id="compressedSize">-</span>
      </p>
      <p class="text-green-600 font-medium"><span id="savedPercent">-</span> smaller</p>
      <a id="downloadBtn" download="compressed-image.jpg" class="mt-3 inline-flex items-center gap-2 px-5 py-3 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition">
        <!-- Download SVG -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4"/>
        </svg>
        <span>Download</span>
      </a>
    </div>

  </div>
</div>

    <!-- Tool End -->

    <!-- Why use -->
    <div class="mt-10">
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
const input = document.getElementById('imageInput');
const output = document.getElementById('output');
const canvas = document.getElementById('canvas');
const ctx = canvas.getContext('2d');
const originalPreview = document.getElementById('originalPreview');
const downloadBtn = document.getElementById('downloadBtn');

const originalSizeEl = document.getElementById('originalSize');
const compressedSizeEl = document.getElementById('compressedSize');
const savedPercentEl = document.getElementById('savedPercent');

function formatBytes(bytes) {
  if (bytes < 1024) return bytes + " B";
  if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(2) + " KB";
  return (bytes / (1024 * 1024)).toFixed(2) + " MB";
}

input.addEventListener('change', (e) => {
  const file = e.target.files[0];
  if (!file) return;

  originalSizeEl.textContent = formatBytes(file.size);
  originalPreview.src = URL.createObjectURL(file);

  const reader = new FileReader();
  reader.onload = (event) => {
    const img = new Image();
    img.onload = () => {
      const maxW = 800; // limit width
      const scale = Math.min(maxW / img.width, 1);
      canvas.width = img.width * scale;
      canvas.height = img.height * scale;
      ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

      canvas.toBlob((blob) => {
        if (!blob) return;
        compressedSizeEl.textContent = formatBytes(blob.size);
        const saved = ((1 - blob.size / file.size) * 100).toFixed(1);
        savedPercentEl.textContent = saved + "%";

        const url = URL.createObjectURL(blob);
        downloadBtn.href = url;
        downloadBtn.download = "compressed-" + file.name;
      }, "image/jpeg", 0.7);

      output.classList.remove('hidden');
    };
    img.src = event.target.result;
  };
  reader.readAsDataURL(file);
});
</script>
