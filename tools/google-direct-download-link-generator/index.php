<?php
// /tools/google-direct-download-link-generator/index.php

$tool_name     = "Google Direct Download Link Generator"; 
$tool_details  = "Easily generate direct download links for Google Drive files.";
$why_use_text  = "If you've ever shared a Google Drive link, you know the default link leads to a preview page, which forces users to click another download button. This can be inconvenient, especially for users who expect a direct download experience.\n\nOur Google Direct Download Link Generator solves that issue by converting a standard Google Drive share link into a direct download URL. This is ideal for embedding in websites, sharing via email, or automating downloads.\n\nIt ensures a seamless experience for your users, while also saving you time and making file sharing more professional.";

$how_to_use    = [
  "Step 1 - Copy the shareable link of your Google Drive file. Make sure the file is set to 'Anyone with the link can view'.",
  "Step 2 - Paste the copied link into the input field on this tool.",
  "Step 3 - Click on the 'Generate' button to convert it into a direct download link.",
  "Step 4 - Copy the generated link and use it wherever you want — website, email, or direct download automation."
];

$faqs = [
  [
    "What is a Google Direct Download Link?", 
    "A Google Direct Download Link is a special URL that prompts an immediate download of a file hosted on Google Drive, instead of opening the file preview. This is useful for creating cleaner workflows or embedding direct links in websites or documents. It avoids the need for users to click 'Download' again on the Google Drive preview page."
  ],
  [
    "Why should I use this generator instead of sharing the default Google Drive link?", 
    "The default Google Drive shareable link takes users to a preview page, which can be confusing or disruptive, especially for non-technical users. By using this tool, you simplify the process by giving a one-click download experience. It also makes file sharing more user-friendly and professional."
  ],
  [
    "Does the direct download link work for all types of files?", 
    "Yes, it works for most common file types such as PDFs, images, ZIP files, documents, and videos. However, it only works if the file is publicly shared (or shared with anyone who has the link) and does not require sign-in. For private or restricted files, direct download won't work unless appropriate permissions are granted."
  ]
];

$page_title = $tool_name;

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$domain   = $_SERVER['HTTP_HOST'];

$tool_slug  = strtolower(str_replace(' ', '-', $tool_name));
$tool_image = "/assets/images/{$tool_slug}.png";
if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $tool_image)) {
    $tool_image = "/assets/images/default.png";
}

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
    <header class="mb-6 text-center">
      <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-slate-800">
        <?= htmlspecialchars($tool_name) ?>
      </h1>
      <p class="mt-2 text-slate-600"><?= $tool_details ?></p>
    </header>

    <!-- === Tool UI === -->
    <div class="mb-6">
      <label for="drive-link" class="block font-medium text-slate-700 mb-2">Paste your Google Drive Shareable Link:</label>
      <input type="text" id="drive-link" placeholder="https://drive.google.com/file/d/FILE_ID/view?usp=sharing"
        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600">
      
      <button onclick="generateLink()"
        class="mt-4 px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition">
        Generate Direct Download Link
      </button>

      <div id="result-box" class="mt-6 hidden">
        <label class="block font-medium text-slate-700 mb-2">Direct Download Link:</label>
        <input type="text" id="direct-link" class="w-full px-4 py-3 border border-slate-300 rounded-lg text-slate-800 bg-slate-50" readonly>
        <button onclick="copyToClipboard()"
          class="mt-2 px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded hover:bg-blue-600 transition">
          Copy to Clipboard
        </button>
      </div>
    </div>
    <!-- === End Tool UI === -->

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

    <?php require dirname(__DIR__, 2).'/partials/back-to-tools.php'; ?>
  </section>
</main>

<script>
function generateLink() {
  const input = document.getElementById("drive-link").value.trim();
  const match = input.match(/\/file\/d\/([a-zA-Z0-9_-]+)/);
  if (match && match[1]) {
    const fileId = match[1];
    const directLink = `https://drive.google.com/uc?export=download&id=${fileId}`;
    document.getElementById("direct-link").value = directLink;
    document.getElementById("result-box").classList.remove("hidden");
  } else {
    alert("Invalid Google Drive link. Please ensure it follows the format: https://drive.google.com/file/d/FILE_ID/view");
  }
}

function copyToClipboard() {
  const copyText = document.getElementById("direct-link");
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  document.execCommand("copy");
}
</script>

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
