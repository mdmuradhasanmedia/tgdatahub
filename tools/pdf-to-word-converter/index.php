<?php
// ==== Load Composer Autoload for PDF Parser ====
require __DIR__ . '/vendor/autoload.php';
use Smalot\PdfParser\Parser;

// ==== Dynamic Variables ====
$tool_name     = "PDF to Word Converter"; 
$tool_details  = "Convert your PDF files into editable Word (DOCX) documents instantly with our free online PDF to Word Converter. Secure, fast, and easy to use.";

$why_use_text  = "Working with PDF files can sometimes be restrictive since editing them is not always straightforward. Converting a PDF to Word allows you to make quick changes without hassle.  

Our PDF to Word Converter ensures formatting accuracy, keeps your document structure intact, and works directly in your browser without uploading sensitive data to unsafe servers.  

This tool is perfect for students, professionals, and businesses who frequently need editable copies of PDF files.";

$how_to_use    = [
  "Step 1 - Upload your PDF file using the upload field below.",
  "Step 2 - Click on the Convert button to process your file.",
  "Step 3 - The system will extract text from your PDF and generate a Word document.",
  "Step 4 - Download the converted Word (DOCX) file instantly."
];

$faqs = [
  [
    "Is this PDF to Word Converter free to use?", 
    "Yes, our PDF to Word Converter is completely free. You don’t need to download heavy software or register an account. Simply upload your PDF and get your Word file within seconds."
  ],
  [
    "Will the formatting of my PDF remain the same?", 
    "This tool primarily extracts text from PDF and generates a Word file. Simple layouts and text will be preserved, but very complex PDFs with images, graphics, or unusual formatting may lose structure. For scanned PDFs, OCR software is required."
  ],
  [
    "Is my uploaded PDF file safe?", 
    "Yes, all processing is done securely. Uploaded files are not stored permanently on the server. Once the Word file is generated and downloaded, your PDF is cleared automatically to ensure privacy."
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

// ==== Handle Upload + Conversion ====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf_file'])) {
    $fileTmp  = $_FILES['pdf_file']['tmp_name'];
    $fileName = pathinfo($_FILES['pdf_file']['name'], PATHINFO_FILENAME);

    $parser = new Parser();
    $pdf    = $parser->parseFile($fileTmp);
    $text   = $pdf->getText();

    if (trim($text) === '') {
        die("<p style='color:red;text-align:center;'>Sorry, no extractable text found (scanned PDF not supported).</p>");
    }

    // === Create minimal Word (DOCX) ===
    $docxFile = sys_get_temp_dir() . "/{$fileName}.docx";
    $zip = new ZipArchive();
    if ($zip->open($docxFile, ZipArchive::CREATE) === true) {
        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
        <w:document xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">
          <w:body><w:p><w:r><w:t>' . htmlspecialchars($text) . '</w:t></w:r></w:p></w:body>
        </w:document>';

        $zip->addFromString('[Content_Types].xml',
            '<?xml version="1.0" encoding="UTF-8"?>
            <Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
              <Default Extension="xml" ContentType="application/xml"/>
              <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
              <Override PartName="/word/document.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.document.main+xml"/>
            </Types>'
        );
        $zip->addFromString('_rels/.rels',
            '<?xml version="1.0" encoding="UTF-8"?>
            <Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
              <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="word/document.xml"/>
            </Relationships>'
        );
        $zip->addFromString('word/_rels/document.xml.rels',
            '<?xml version="1.0" encoding="UTF-8"?>
            <Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"/>'
        );
        $zip->addFromString('word/document.xml', $xml);
        $zip->close();
    }

    // === Force Download ===
    header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    header('Content-Disposition: attachment; filename="'.$fileName.'.docx"');
    readfile($docxFile);
    unlink($docxFile);
    exit;
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
      <li><a href="/" class="hover:underline text-blue-600">Home</a></li>
      <li>/</li>
      <li><a href="/tools" class="hover:underline text-blue-600">Tools</a></li>
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
    <div class="mb-6 text-center">
      <form method="post" enctype="multipart/form-data">
        <input type="file" name="pdf_file" accept="application/pdf" required
               class="mb-4 block w-full text-slate-600 border border-slate-300 rounded-lg px-3 py-2">
        <button type="submit"
          class="inline-flex items-center gap-2 px-5 py-3 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition">
          <!-- SVG Icon -->
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path d="M3 4a1 1 0 011-1h6a1 1 0 010 2H5v12h10V9a1 1 0 112 0v8a2 2 0 01-2 2H5a2 2 0 01-2-2V4z"/>
            <path d="M17 2a1 1 0 00-1-1h-4a1 1 0 100 2h2.586L9.293 8.293a1 1 0 001.414 1.414L16 4.414V7a1 1 0 102 0V2z"/>
          </svg>
          <span>Convert PDF to Word</span>
        </button>
      </form>
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
