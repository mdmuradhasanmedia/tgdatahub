<?php
// /tools/image-to-pdf-converter/index.php

// ==== Dynamic Variables (edit these per tool) ====
$tool_name     = "Image to PDF Converter"; 
$tool_details  = "Convert JPG, PNG and other image formats into a single PDF file instantly online with advanced options.";
$why_use_text  = "This advanced Image to PDF Converter allows you to convert, merge, and customize images into high-quality PDF documents directly in your browser.\n\nFeatures include drag & drop upload, reorder images, delete unwanted files, choose page size, orientation, compression, password protection, and even merging with existing PDFs. Perfect for students, teachers, professionals, and office users.\n\nNo installation is needed — everything works inside your browser securely and privately.";

$how_to_use    = [
  "Step 1 - Upload or drag & drop your images.",
  "Step 2 - Reorder or delete images as needed.",
  "Step 3 - Choose page size, orientation, compression level, and optionally set a password.",
  "Step 4 - Click 'Convert to PDF' and download instantly."
];

// ==== FAQ Section ====
$faqs = [
  [
    "Can I rearrange images before conversion?",
    "Yes. You can drag and drop to reorder images, ensuring they appear in the exact order you want inside the PDF."
  ],
  [
    "Is there an option to reduce file size?",
    "Yes. You can choose compression level (High, Medium, Low) to balance between PDF quality and file size."
  ],
  [
    "Can I secure my PDF with a password?",
    "Yes. You can enable password protection while converting so that only users with the password can open the PDF."
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
    <div id="imageToPdfApp" class="mb-8">
      <div id="dropZone" class="border-2 border-dashed border-slate-300 rounded-xl p-6 text-center bg-slate-50">
        <input type="file" id="imageInput" accept="image/*" multiple class="hidden">
        <label for="imageInput" class="cursor-pointer px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">
          Select Images
        </label>
        <p class="mt-2 text-slate-600">or drag & drop your images here</p>
      </div>

      <!-- Add More Button -->
      <div class="mt-4 text-center">
        <input type="file" id="addMoreInput" accept="image/*" multiple class="hidden">
        <label for="addMoreInput" class="cursor-pointer px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">
          Add More Images
        </label>
      </div>

      <!-- Options -->
      <div class="mt-6 grid sm:grid-cols-2 gap-4">
        <div>
          <label class="block font-semibold text-slate-700">Page Size</label>
          <select id="pageSize" class="w-full border border-slate-300 rounded-lg p-2 mt-1">
            <option value="a4">A4</option>
            <option value="letter">Letter</option>
            <option value="legal">Legal</option>
          </select>
        </div>
        <div>
          <label class="block font-semibold text-slate-700">Orientation</label>
          <select id="orientation" class="w-full border border-slate-300 rounded-lg p-2 mt-1">
            <option value="p">Portrait</option>
            <option value="l">Landscape</option>
          </select>
        </div>
        <div>
          <label class="block font-semibold text-slate-700">Compression</label>
          <select id="compression" class="w-full border border-slate-300 rounded-lg p-2 mt-1">
            <option value="high">High Quality</option>
            <option value="medium">Medium</option>
            <option value="low">Low (Small size)</option>
          </select>
        </div>
        <div>
          <label class="block font-semibold text-slate-700">Password (Optional)</label>
          <input type="password" id="pdfPassword" placeholder="Enter password" class="w-full border border-slate-300 rounded-lg p-2 mt-1">
        </div>
      </div>

      <!-- Preview Area -->
      <div id="preview" class="mt-6 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4"></div>

      <!-- Convert Button -->
      <div class="mt-6 text-center">
        <button id="convertBtn" class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-xl shadow">
          Convert to PDF
        </button>
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

<!-- Libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
const { jsPDF } = window.jspdf;
let selectedFiles = [];

const input = document.getElementById('imageInput');
const addMore = document.getElementById('addMoreInput');
const preview = document.getElementById('preview');
const dropZone = document.getElementById('dropZone');

input.addEventListener('change', handleFiles);
addMore.addEventListener('change', handleFiles);

// Drag & Drop
dropZone.addEventListener('dragover', e => {
  e.preventDefault();
  dropZone.classList.add('border-indigo-600');
});
dropZone.addEventListener('dragleave', () => dropZone.classList.remove('border-indigo-600'));
dropZone.addEventListener('drop', e => {
  e.preventDefault();
  dropZone.classList.remove('border-indigo-600');
  handleFiles({ target: { files: e.dataTransfer.files } });
});

function handleFiles(event) {
  const newFiles = Array.from(event.target.files || event.dataTransfer.files);
  selectedFiles = selectedFiles.concat(newFiles); // merge
  renderPreview();
  event.target.value = ""; // reset for re-upload
}

function renderPreview() {
  preview.innerHTML = "";
  selectedFiles.forEach((file, idx) => {
    const reader = new FileReader();
    reader.onload = function(e) {
      const div = document.createElement('div');
      div.className = "relative group";
      div.innerHTML = `
        <img src="${e.target.result}" class="w-full h-32 object-cover rounded-lg shadow">
        <button onclick="removeImage(${idx})" class="absolute top-1 right-1 bg-red-500 text-white rounded-full px-2 py-1 text-xs hidden group-hover:block">X</button>
      `;
      preview.appendChild(div);
    };
    reader.readAsDataURL(file);
  });

  new Sortable(preview, {
    animation: 150,
    onEnd: evt => {
      const moved = selectedFiles.splice(evt.oldIndex, 1)[0];
      selectedFiles.splice(evt.newIndex, 0, moved);
    }
  });
}

function removeImage(index) {
  selectedFiles.splice(index, 1);
  renderPreview();
}

document.getElementById('convertBtn').addEventListener('click', async () => {
  if (!selectedFiles.length) {
    alert("Please select at least one image.");
    return;
  }

  const pageSize = document.getElementById('pageSize').value;
  const orientation = document.getElementById('orientation').value;
  const compression = document.getElementById('compression').value;
  const password = document.getElementById('pdfPassword').value;

  const pdf = new jsPDF({ orientation, unit: "pt", format: pageSize });

  for (let i = 0; i < selectedFiles.length; i++) {
    const file = selectedFiles[i];
    const dataURL = await fileToDataURL(file);
    const img = new Image();
    img.src = dataURL;
    await new Promise(res => img.onload = res);

    const pageWidth = pdf.internal.pageSize.getWidth();
    const pageHeight = pdf.internal.pageSize.getHeight();

    let imgWidth = pageWidth;
    let imgHeight = (img.height * imgWidth) / img.width;

    if (imgHeight > pageHeight) {
      imgHeight = pageHeight;
      imgWidth = (img.width * imgHeight) / img.height;
    }

    if (i > 0) pdf.addPage();
    pdf.addImage(img, "JPEG", 0, 0, imgWidth, imgHeight, undefined, compression);
  }

  if (password) {
    const existingPdf = await PDFLib.PDFDocument.load(pdf.output("arraybuffer"));
    existingPdf.encrypt({ userPassword: password, ownerPassword: password });
    const pdfBytes = await existingPdf.save();
    downloadBlob(pdfBytes, "images-to-pdf.pdf");
  } else {
    pdf.save("images-to-pdf.pdf");
  }
});

function fileToDataURL(file) {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.onload = e => resolve(e.target.result);
    reader.onerror = reject;
    reader.readAsDataURL(file);
  });
}

function downloadBlob(data, filename) {
  const blob = new Blob([data], { type: "application/pdf" });
  const link = document.createElement("a");
  link.href = URL.createObjectURL(blob);
  link.download = filename;
  link.click();
}
</script>
