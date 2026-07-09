<?php
// /tools/lorem-ipsum-generator/index.php

// ==== Dynamic Variables (edit these per tool) ====
$tool_name     = "Lorem Ipsum Generator"; 
$tool_details  = "Generate random placeholder text (Lorem Ipsum) for your design, website, or project instantly.";
$why_use_text  = "Lorem Ipsum Generator is a must-have tool for designers, developers, and content creators who need quick placeholder text. 
It helps you fill layouts, templates, or prototypes with dummy content that looks like real text, so you can focus on design and structure rather than writing.  

Instead of copying the same few lines repeatedly, this tool lets you generate as much text as you need — paragraphs, sentences, or even words.  
It is fast, free, and accessible directly in your browser, making it an essential tool for web development and graphic design.";  

$how_to_use    = [
  "Step 1 - Enter the number of paragraphs, sentences, or words you want to generate.",
  "Step 2 - Click on the **Generate** button.",
  "Step 3 - Instantly see the Lorem Ipsum text appear in the box below.",
  "Step 4 - Copy the text with one click and paste it into your project or design software."
];

// ==== FAQ Placeholder (Template Guideline) ====
$faqs = [
  [
    "What is a Lorem Ipsum Generator?", 
    "A Lorem Ipsum Generator is an online tool that creates dummy placeholder text that looks like natural language. Designers and developers use it to fill layouts, wireframes, and templates so they can focus on structure and appearance instead of content writing. <br><br> It prevents distractions and helps test typography, spacing, and design before the final text is ready."
  ],
  [
    "Why should I use Lorem Ipsum text in design?", 
    "Using Lorem Ipsum text helps you visualize the final look of a project without needing real content. This way, clients and team members can focus on layout, typography, and design instead of getting distracted by the actual words. <br><br> It is also a time-saver, as you can generate multiple paragraphs instantly instead of typing random filler manually."
  ],
  [
    "Can I copy and paste the Lorem Ipsum text?", 
    "Yes! The generated text is fully editable and can be copied with just one click. You can paste it into your website, app, design mockup, or any text editor. <br><br> Many developers use it directly in HTML/CSS code during front-end development to check responsiveness and formatting."
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
    <div class="mb-6">
      <form class="flex flex-col md:flex-row gap-4 items-center justify-center">
        <input type="number" min="1" max="20" value="3" class="w-32 border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-600" id="lorem-count">
        <select id="lorem-type" class="border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-600">
          <option value="paragraphs">Paragraphs</option>
          <option value="sentences">Sentences</option>
          <option value="words">Words</option>
        </select>
        <button type="button" id="generate-btn" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2 rounded-lg shadow">
          Generate
        </button>
      </form>
      <textarea id="lorem-output" class="w-full h-48 mt-4 border border-slate-300 rounded-lg p-3 text-slate-700" readonly></textarea>
      <button id="copy-btn" class="mt-3 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">Copy Text</button>
    </div>
    <script>
      const output = document.getElementById("lorem-output");
      const copyBtn = document.getElementById("copy-btn");
      const genBtn = document.getElementById("generate-btn");

      function generateLorem(count, type) {
        const base = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.";
        let text = "";
        if(type === "paragraphs") {
          for(let i=0; i<count; i++) text += base + "\n\n";
        } else if(type === "sentences") {
          for(let i=0; i<count; i++) text += " " + base.split(".")[0] + ".";
        } else {
          const words = base.split(" ");
          for(let i=0; i<count; i++) text += words[i % words.length] + " ";
        }
        return text.trim();
      }

      genBtn.addEventListener("click", () => {
        const count = document.getElementById("lorem-count").value;
        const type = document.getElementById("lorem-type").value;
        output.value = generateLorem(count, type);
      });

      copyBtn.addEventListener("click", () => {
        output.select();
        document.execCommand("copy");
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
