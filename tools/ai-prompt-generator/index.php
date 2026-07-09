<?php
// /tools/ai-prompt-generator/index.php

// ==== Dynamic Variables (edit these per tool) ====
$tool_name     = "AI Prompt Generator"; 
$tool_details  = "Create high-quality AI prompts instantly for ChatGPT, MidJourney, and other AI tools. Free, fast, and easy to use.";
$why_use_text  = "An AI Prompt Generator helps you save time and get better results from AI models. Instead of struggling to think of the right input, you can instantly generate effective prompts that work.\n\nBy using this tool, you can focus on creativity and productivity while letting the generator handle the structure and clarity of your prompts. Whether you are a student, professional, or creator, prompt generators can guide you with ready-to-use templates.\n\nThis ensures that your AI conversations, content creation, or art generation become smoother and more professional, helping you achieve better outcomes without wasting time.";
$how_to_use    = [
  "Step 1 - Enter your topic or idea (e.g., blog post, essay, art idea, marketing copy).",
  "Step 2 - Select the type of prompt you want (creative writing, business, technical, etc.).",
  "Step 3 - Click 'Generate Prompt' to instantly get a polished AI-ready prompt.",
  "Step 4 - Copy the generated prompt and paste it into ChatGPT, MidJourney, or your AI tool."
];

// ==== FAQ Placeholder (Template Guideline) ====
$faqs = [
  [
    "What is an AI Prompt Generator?", 
    "An AI Prompt Generator is a tool that helps you create structured and effective inputs for AI systems like ChatGPT, MidJourney, or Bard. It takes your raw idea and turns it into a well-formatted prompt, saving you time and improving results."
  ],
  [
    "Why should I use an AI Prompt Generator?", 
    "Writing effective prompts is not always easy. This tool helps you quickly design prompts that are clear, specific, and useful, ensuring that AI models respond better. It’s especially helpful for beginners, marketers, students, and content creators."
  ],
  [
    "Is this AI Prompt Generator free to use?", 
    "Yes. This AI Prompt Generator is completely free to use on TG Data Hub. You can generate unlimited prompts without any restrictions. It is designed to be simple, fast, and accessible to everyone."
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
<div class="mt-8 space-y-5">

  <!-- Topic Input -->
  <div>
    <label for="topic" class="block text-slate-700 font-medium mb-2">Enter your topic or idea</label>
    <textarea id="topic" rows="3" 
      class="w-full border border-slate-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
      placeholder="e.g., A marketing campaign for eco-friendly bottles..."></textarea>
  </div>

  <!-- Category -->
  <div>
    <label for="category" class="block text-slate-700 font-medium mb-2">Select Category</label>
    <select id="category" 
      class="w-full border border-slate-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
      <option value="creative">Creative Writing</option>
      <option value="business">Business / Marketing</option>
      <option value="technical">Technical / Coding</option>
      <option value="art">Art & Image Generation</option>
    </select>
  </div>

  <!-- Tone -->
  <div>
    <label for="tone" class="block text-slate-700 font-medium mb-2">Select Tone</label>
    <select id="tone" 
      class="w-full border border-slate-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
      <option value="professional">Professional</option>
      <option value="casual">Casual</option>
      <option value="persuasive">Persuasive</option>
      <option value="storytelling">Storytelling</option>
    </select>
  </div>

  <!-- Button -->
  <button id="generateBtn"
    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg shadow">
    Generate Prompt
  </button>

  <!-- Output -->
  <div id="output" class="hidden bg-slate-50 border border-slate-200 rounded-xl p-5 mt-5">
    <div class="flex justify-between items-center mb-3">
      <h3 class="font-bold text-slate-800">Generated Prompt:</h3>
      <button id="copyBtn" 
        class="text-sm bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
        Copy
      </button>
    </div>
    <p id="promptText" class="text-slate-700 whitespace-pre-line"></p>
  </div>
</div>

<script>
document.getElementById("generateBtn").addEventListener("click", function() {
  let topic = document.getElementById("topic").value.trim();
  let category = document.getElementById("category").value;
  let tone = document.getElementById("tone").value;
  let prompt = "";

  if (!topic) {
    alert("Please enter a topic first.");
    return;
  }

  // Base prompt by category
  switch(category) {
    case "creative":
      prompt = `Write a ${tone} creative story about "${topic}". 
Use vivid descriptions, emotions, and imagination.`;
      break;

    case "business":
      prompt = `Write a ${tone} marketing copy for "${topic}". 
Highlight key benefits, use persuasive language, and end with a strong call-to-action.`;
      break;

    case "technical":
      prompt = `Explain "${topic}" in a ${tone} and clear manner. 
Include step-by-step instructions, examples, and structured formatting (like code or bullet points).`;
      break;

    case "art":
      prompt = `Generate an AI art prompt about "${topic}" in a ${tone} way. 
Describe style, colors, lighting, and mood. Example: "A futuristic city skyline, neon glow, cyberpunk mood".`;
      break;

    default:
      prompt = `Write about "${topic}" in a ${tone} style.`;
  }

  document.getElementById("promptText").innerText = prompt;
  document.getElementById("output").classList.remove("hidden");
});

// Copy to Clipboard
document.getElementById("copyBtn").addEventListener("click", function() {
  let text = document.getElementById("promptText").innerText;
  navigator.clipboard.writeText(text).then(() => {
    alert("Prompt copied to clipboard!");
  });
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
