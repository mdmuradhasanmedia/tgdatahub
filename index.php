<?php
$page_title = "Tools & Guides Data Hub";

// === Tools by Category (VALIDATED STRUCTURE) ===
$categories = [
  "Document & File Tools" => [
    "image-compressor" => [
      "Image Compressor",
      "Compress images to reduce file size.",
      "M8 6h8M4 10h12M6 14h10"
    ],
    "pdf-to-word-converter" => [
      "PDF to Word Converter",
      "Convert PDF files into editable Word (DOCX) documents instantly.",
      "M4 4h12v12H4z M8 12l2 2 4-4"
    ],
    "image-to-pdf-converter" => [
      "Image to PDF Converter",
      "Convert JPG, PNG images into PDF with reorder, compression, and password options.",
      "M4 4h16v16H4z M8 7h8v2H8z M8 11h8v2H8z M8 15h5v2H8z"
    ],
    "compress-pdf" => [
      "Compress PDF",
      "Reduce PDF file size quickly without losing quality.",
      "M6 4h12v16H6z M10 8h4M10 12h4M10 16h4"
    ],
    "heic-to-jpg" => [
  "HEIC to JPG Converter",
  "Convert HEIC / HEIF images to high-quality JPG.",
  "M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z|M14 2v6h6|M8 13l2 2 3-4 4 5"
],
  ],

  "Daily Use / Math Tools" => [
    "age-calculator" => [
      "Age Calculator",
      "Calculate age from date of birth.",
      "M8 7h8M6 11h12M4 15h16"
    ],
    "loan-calculator" => [
      "Loan (EMI) Calculator",
      "Compute loan EMI and total interest.",
      "M4 12h16M12 4v16"
    ],
    "timezone-converter" => [
      "Time Zone Converter",
      "Convert time across time zones.",
      "M12 6v6l4 2"
    ],
    "word-counter" => [
      "Word Counter",
      "Count words and characters.",
      "M4 8h16M4 12h10M4 16h14"
    ],
    "unit-converter" => [
      "Unit Converter",
      "Convert length, weight, temperature, and more.",
      "M6 18L18 6M6 6h12v12"
    ],
  ],

  "YouTube Tools" => [
    "yt-tags-generator" => [
      "YouTube Tags Generator",
      "Get suggested tags for videos.",
      "M6 12l4 4 8-8"
    ],
    "yt-thumbnail-viewer" => [
      "YouTube Thumbnail Viewer",
      "View thumbnails from YouTube videos.",
      "M4 6h16M4 12h16M4 18h16"
    ],
  ],
  
    "Email Tools" => [
	"gmail-alias-generator" => [
	"Gmail Alias Generator",
	"Generate unlimited Gmail aliases using plus addressing and Gmail-compatible variations for privacy, testing, registrations, filtering, and inbox organization.",
	"M4 6h16v12H4V6zm0 0l8 6 8-6M12 12v6m0-6l-2 2m2-2l2 2"
	],
  ],

  "Download Tools" => [
    "facebook-video-downloader" => [
      "Facebook Video Downloader",
      "Download Facebook videos in HD and SD quality instantly.",
      "M12 3v12m0 0l-4-4m4 4l4-4M4 17h16v4H4v-4z"
    ],
   "app-downloader" => [
  "APK Downloader",
  "Easily download Android APK files directly to your device.",
  "M2 22V2h10l6 6v5.225h-1.5V9H11V3.5H3.5v17h11.5v1.5H2Zm3 -3c0.06665 -0.81665 0.31665 -1.56665 0.75 -2.25 0.43335 -0.68335 1 -1.225 1.7 -1.625l-0.95 -1.7c0 -0.01665 0.03335 -0.14165 0.1 -0.375 0.08335 -0.03335 0.1625 -0.05 0.2375 -0.05 0.075 0 0.12915 0.04165 0.1625 0.125l0.975 1.75c0.33335 -0.13335 0.66665 -0.2375 1 -0.3125 0.33335 -0.075 0.675 -0.1125 1.025 -0.1125 0.35 0 0.69165 0.0375 1.025 0.1125 0.33335 0.075 0.66665 0.17915 1 0.3125l0.975 -1.75 0.375 -0.1c0.08335 0.03335 0.13335 0.09165 0.15 0.175 0.01665 0.08335 0.00835 0.15835 -0.025 0.225l-0.95 1.7c0.7 0.4 1.26665 0.94165 1.7 1.625 0.43335 0.68335 0.68335 1.43335 0.75 2.25H5Zm2.75 -1.5c0.13335 0 0.25 -0.05 0.35 -0.15 0.1 -0.1 0.15 -0.21665 0.15 -0.35 0 -0.13335 -0.05 -0.25 -0.15 -0.35 -0.1 -0.1 -0.21665 -0.15 -0.35 -0.15 -0.13335 0 -0.25 0.05 -0.35 0.15 -0.1 0.1 -0.15 0.21665 -0.15 0.35 0 0.13335 0.05 0.25 0.15 0.35 0.1 0.1 0.21665 0.15 0.35 0.15Zm4.5 0c0.13335 0 0.25 -0.05 0.35 -0.15 0.1 -0.1 0.15 -0.21665 0.15 -0.35 0 -0.13335 -0.05 -0.25 -0.15 -0.35 -0.1 -0.1 -0.21665 -0.15 -0.35 -0.15 -0.13335 0 -0.25 0.05 -0.35 0.15 -0.1 0.1 -0.15 0.21665 -0.15 0.35 0 0.13335 0.05 0.25 0.15 0.35 0.1 0.1 0.21665 0.15 0.35 0.15Zm7.5 4.5 -3.65 -3.65 1.05 -1.075 1.85 1.85V14.6h1.5v4.525l1.85 -1.85 1.05 1.075 -3.65 3.65Z"
],

"terabox-video-downloader" => [
    "Terabox Video Downloader",
    "Download Terabox videos instantly using NDUS cookie support.",
    "M12 2 L6 8 L12 14" 
],



   "google-direct-download-link-generator" => [
  "Google Direct Download Link Generator",
  "Generate a direct download URL from any Google Drive shareable link.",
  "M4 4v5h16V4M4 9v11h16V9M12 13v4m0 0l-2-2m2 2l2-2"
],


  ],

  "Developer Tools" => [
    "color-picker" => [
      "Color Picker + Color Converter",
      "Pick any color and convert between HEX, RGB, and HSL instantly.",
      "M12 2a10 10 0 100 20 10 10 0 000-20z M15 9h.01M9 9h.01M9 15h.01M15 15h.01"
    ],
    "password-generator" => [
      "Password Generator",
      "Generate strong, random passwords.",
      "M5 12h14M12 5v14"
    ],
    "ai-prompt-generator" => [
      "AI Prompt Generator",
      "Create high-quality AI prompts instantly for ChatGPT, MidJourney, and other AI tools.",
      "M4 18h2l1-4h6l1 4h2l-5-14h-2l-5 14zm4-6l2-6l2 6h-4zm10-8h2v14h-2zm3 0h2v14h-2z"
    ],
    
    "cc-generator" => [
      "CC Generator",
      "Generate Credit Card Number with Date and CVV.",
      "M2 7h20M2 11h20M2 15h20M2 19h20"
    ],
    
    "link-shortener" => [
      "Link Shortener",
      "Free online tool to convert long URLs into short and simple links.",
      "M10.59 13.41a1.5 1.5 0 0 1 0-2.12l2.83-2.83a1.5 1.5 0 0 1 2.12 2.12l-2.83 2.83a1.5 1.5 0 0 1-2.12 0zm-4.24 4.24a4.5 4.5 0 0 0 6.36 0l1.41-1.41-2.12-2.12-1.41 1.41a1.5 1.5 0 0 1-2.12-2.12l1.41-1.41-2.12-2.12-1.41 1.41a4.5 4.5 0 0 0 0 6.36zm12.73-12.73a4.5 4.5 0 0 0-6.36 0l-1.41 1.41 2.12 2.12 1.41-1.41a1.5 1.5 0 0 1 2.12 2.12l-1.41 1.41 2.12 2.12 1.41-1.41a4.5 4.5 0 0 0 0-6.36z"
    ],
    
   "iframe-share-tool" => [
    "Iframe Share Tool",
    "Turn any link into a shareable, locked iframe view.",
    "M4 3h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zm0 13h16v2H4v-2z"
    ],
    
    "rss-finder" => [
    "RSS Finder",
    "Easily find and extract RSS feed URLs from any website. Perfect for bloggers, developers, and readers.",
    "M4.5 3A1.5 1.5 0 0 0 3 4.5v2a1.5 1.5 0 0 0 1.5 1.5c7.456 0 13.5 6.044 13.5 13.5a1.5 1.5 0 0 0 1.5 1.5h2a1.5 1.5 0 0 0 1.5-1.5C23 11.075 12.925 1 4.5 1zM4 11a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1c3.309 0 6 2.691 6 6a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1c0-5.523-4.477-10-10-10zm1 7a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"
    ],
    
    "m3u8-runner" => [
    "M3U8 Runner",
    "Run and test M3U8 live stream links directly in your browser",
    "M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14m-6 0l-4.553 2.276A1 1 0 013 15.382V8.618a1 1 0 011.447-.894L9 10m6 4V10M9 14V10"
    ],
    
    "bangladesh-number-lookup" => [
    "Bangladesh Number Lookup",
    "Check possible owner name by Bangladeshi mobile number instantly. Fast lookup with clean output and search history.",
    "M4 5.5C4 4.12 5.12 3 6.5 3h11C18.88 3 20 4.12 20 5.5v13c0 1.38-1.12 2.5-2.5 2.5h-11A2.5 2.5 0 0 1 4 18.5v-13Z M8 9h8 M8 12h8 M8 15h5"
    ]
  ],

  "Domain Tools" => [
    "domain-age-checker" => [
      "Domain Age Checker",
      "Check the exact age of any domain instantly.",
      "M12 2a10 10 0 100 20 10 10 0 000-20zm0 0c2.5 3 4 7 4 10s-1.5 7-4 10m0-20c-2.5 3-4 7-4 10s1.5 7 4 10m-8-10h16"
    ],
  ],
  
    "Web Development Tools" => [
        "html-table-generator" => [
            "HTML Table Generator",
            "Create responsive HTML tables with custom styling, colors and borders instantly",
            "M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"
        ],
    ],  
  
  "Fun / Random Tools" => [
    "random-number-generator" => [
      "Random Number Generator",
      "Generate truly random numbers online within your chosen range.",
      "M5 12h14M12 5v14"
    ],
    "lorem-ipsum-generator" => [
      "Lorem Ipsum Generator",
      "Generate random placeholder text instantly for design and development.",
      "M4 6h16M4 12h16M4 18h16"
    ],
  ],
];

// === Sort each category alphabetically by tool title ===
foreach ($categories as $catName => &$tools) {
  uasort($tools, function ($a, $b) {
    return strcasecmp($a[0], $b[0]);
  });
}
unset($tools);

require __DIR__ . '/partials/header.php';
?>

<!-- Hero -->
<section class="bg-indigo-50 text-center">
  <div class="max-w-5xl mx-auto px-4 py-14 md:py-20">
    <h1 class="text-4xl md:text-5xl font-extrabold text-slate-800 tracking-tight">
      Tools &amp; Guides Data Hub
    </h1>
    <p class="mt-3 md:mt-4 text-lg md:text-xl text-slate-600">
      A curated set of handy online tools to make your daily tasks and projects easier and faster.
    </p>
    <div class="mt-6 md:mt-8 max-w-lg mx-auto">
      <input id="q" type="search" placeholder="Search tools…"
             class="w-full rounded-xl border border-slate-200 bg-white shadow-sm
                    px-5 py-3 md:py-4 text-slate-700
                    focus:outline-none focus:ring-4 focus:ring-indigo-200 text-base md:text-lg"
             oninput="filterCards()" />
    </div>
  </div>
</section>

<!-- Tools by Category -->
<div class="max-w-7xl mx-auto px-4 pb-16 mt-8">
  <?php foreach($categories as $catName => $tools): ?>
    <h2 class="text-2xl font-bold text-slate-800 mb-6"><?= htmlspecialchars($catName) ?></h2>

    <div class="category-grid grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mb-12">
      <?php foreach($tools as $slug => [$title,$desc,$iconPath]): ?>
        <a href="/tools/<?= htmlspecialchars($slug) ?>"
           class="tool-card bg-white border border-slate-200 rounded-2xl shadow-sm
                  p-5 md:p-6 flex flex-col justify-between
                  transition duration-200 ease-out
                  hover:-translate-y-1 hover:shadow-md hover:border-indigo-300
                  focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2">

          <!-- Top: icon + title + desc -->
          <div>
            <div class="mb-4 w-14 h-14 md:w-16 md:h-16 rounded-xl bg-indigo-50 flex items-center justify-center">
              <svg class="w-7 h-7 text-indigo-600"
                   viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="<?= $iconPath ?>"/>
              </svg>
            </div>

            <h3 class="text-lg md:text-xl font-bold text-slate-800">
              <?= htmlspecialchars($title) ?>
            </h3>

            <p class="mt-2 text-slate-600 text-sm md:text-base leading-relaxed">
              <?= htmlspecialchars($desc) ?>
            </p>
          </div>

          <!-- Bottom: CTA -->
          <span class="mt-5 inline-flex items-center gap-2 font-medium text-indigo-600">
            Use Tool <span aria-hidden="true">→</span>
          </span>
        </a>
      <?php endforeach; ?>
    </div>
  <?php endforeach; ?>
</div>

<script>
  // === Search filter ===
  function filterCards(){
    const q = (document.getElementById('q')?.value || '').toLowerCase();
    document.querySelectorAll('.tool-card').forEach(card => {
      const text = card.textContent.toLowerCase();
      card.style.display = text.includes(q) ? '' : 'none';
    });
    // Hide empty categories
    document.querySelectorAll('.category-grid').forEach(grid => {
      const visible = [...grid.querySelectorAll('.tool-card')].some(card => card.style.display !== 'none');
      grid.previousElementSibling.style.display = visible ? '' : 'none';
      grid.style.display = visible ? 'grid' : 'none';
    });
  }
</script>

<?php require __DIR__.'/partials/footer.php'; ?>
