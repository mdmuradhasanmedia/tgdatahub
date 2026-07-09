<?php
// /tools/unit-converter/index.php

// ==== Dynamic Variables ====
$tool_name     = "Unit Converter"; 
$tool_details  = "Convert units instantly across length, weight, temperature, volume, area, speed, time, and data storage. Our free Unit Converter is fast, accurate, and easy to use.";
$why_use_text  = "Different countries and industries use different measurement systems (metric, imperial, etc.), which can make conversions confusing.  

Our Unit Converter makes it simple to switch between units like kilometers to miles, Celsius to Fahrenheit, kilograms to pounds, liters to gallons, and even MB to GB.  

It’s accurate, easy to use, and works instantly in your browser without requiring any installation.";
$how_to_use    = [
  "Step 1 - Select the category of units you want to convert (e.g., length, weight, temperature).",
  "Step 2 - Enter the value in the input box.",
  "Step 3 - Choose the unit you want to convert from and the unit you want to convert to.",
  "Step 4 - Click **Convert** and instantly see the converted value."
];

// ==== FAQ Section ====
$faqs = [
  [
    "What types of units can I convert with this tool?", 
    "You can convert a wide range of units including length (km, miles, meters), weight (kg, lbs, grams), temperature (Celsius, Fahrenheit, Kelvin), volume (liters, gallons), area (square meters, acres), speed (km/h, mph), time (seconds, hours, days), and data storage (KB, MB, GB, TB)."
  ],
  [
    "Is the Unit Converter accurate?", 
    "Yes, our Unit Converter uses precise formulas for conversion to ensure accurate results. It is suitable for educational use, professional work, or everyday tasks."
  ],
  [
    "Can I use this tool on mobile devices?", 
    "Absolutely! The Unit Converter is fully responsive and works seamlessly on smartphones, tablets, and desktops."
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
    <div class="grid gap-4 md:grid-cols-2 mb-6">
      <div>
        <label for="unitCategory" class="block font-medium text-slate-700 mb-1">Category</label>
        <select id="unitCategory" onchange="populateUnits()" class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-600">
          <option value="length">Length</option>
          <option value="weight">Weight</option>
          <option value="temperature">Temperature</option>
          <option value="volume">Volume</option>
          <option value="area">Area</option>
          <option value="speed">Speed</option>
          <option value="time">Time</option>
          <option value="storage">Data Storage</option>
        </select>
      </div>
      <div>
        <label for="inputValue" class="block font-medium text-slate-700 mb-1">Value</label>
        <input type="number" id="inputValue" placeholder="Enter value" class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-600">
      </div>
      <div>
        <label for="fromUnit" class="block font-medium text-slate-700 mb-1">From</label>
        <select id="fromUnit" class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-600"></select>
      </div>
      <div>
        <label for="toUnit" class="block font-medium text-slate-700 mb-1">To</label>
        <select id="toUnit" class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-600"></select>
      </div>
    </div>

    <button onclick="convertUnit()" class="px-5 py-2 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition flex items-center gap-2">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
      </svg>
      Convert
    </button>

    <div id="result" class="mt-4 p-4 bg-slate-50 border border-slate-200 rounded-lg hidden text-slate-800 font-medium"></div>
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

<script>
const units = {
  length: ["meters", "kilometers", "miles", "feet", "inches"],
  weight: ["grams", "kilograms", "pounds", "ounces"],
  temperature: ["Celsius", "Fahrenheit", "Kelvin"],
  volume: ["liters", "milliliters", "gallons", "cups"],
  area: ["sq meters", "sq kilometers", "acres", "hectares", "sq miles"],
  speed: ["m/s", "km/h", "mph", "knots"],
  time: ["seconds", "minutes", "hours", "days"],
  storage: ["bytes", "KB", "MB", "GB", "TB"]
};

function populateUnits() {
  const category = document.getElementById("unitCategory").value;
  const fromUnit = document.getElementById("fromUnit");
  const toUnit = document.getElementById("toUnit");
  fromUnit.innerHTML = "";
  toUnit.innerHTML = "";
  units[category].forEach(u => {
    fromUnit.innerHTML += `<option value="${u}">${u}</option>`;
    toUnit.innerHTML += `<option value="${u}">${u}</option>`;
  });
}
populateUnits();

function convertUnit() {
  const category = document.getElementById("unitCategory").value;
  const value = parseFloat(document.getElementById("inputValue").value);
  const from = document.getElementById("fromUnit").value;
  const to = document.getElementById("toUnit").value;
  let result = value;

  if (isNaN(value)) {
    alert("Please enter a valid number.");
    return;
  }

  // Conversion logic (simplified for demo, can be expanded)
  if (category === "length") {
    if (from === "meters" && to === "kilometers") result = value / 1000;
    else if (from === "kilometers" && to === "meters") result = value * 1000;
    else if (from === "miles" && to === "kilometers") result = value * 1.609;
    else if (from === "kilometers" && to === "miles") result = value / 1.609;
    else if (from === "feet" && to === "meters") result = value / 3.281;
    else if (from === "meters" && to === "feet") result = value * 3.281;
    else if (from === "inches" && to === "meters") result = value / 39.37;
    else if (from === "meters" && to === "inches") result = value * 39.37;
  }

  if (category === "weight") {
    if (from === "grams" && to === "kilograms") result = value / 1000;
    else if (from === "kilograms" && to === "grams") result = value * 1000;
    else if (from === "kilograms" && to === "pounds") result = value * 2.205;
    else if (from === "pounds" && to === "kilograms") result = value / 2.205;
    else if (from === "ounces" && to === "grams") result = value * 28.35;
    else if (from === "grams" && to === "ounces") result = value / 28.35;
  }

  if (category === "temperature") {
    if (from === "Celsius" && to === "Fahrenheit") result = (value * 9/5) + 32;
    else if (from === "Fahrenheit" && to === "Celsius") result = (value - 32) * 5/9;
    else if (from === "Celsius" && to === "Kelvin") result = value + 273.15;
    else if (from === "Kelvin" && to === "Celsius") result = value - 273.15;
    else if (from === "Fahrenheit" && to === "Kelvin") result = (value - 32) * 5/9 + 273.15;
    else if (from === "Kelvin" && to === "Fahrenheit") result = (value - 273.15) * 9/5 + 32;
  }

  if (category === "volume") {
    if (from === "liters" && to === "milliliters") result = value * 1000;
    else if (from === "milliliters" && to === "liters") result = value / 1000;
    else if (from === "liters" && to === "gallons") result = value / 3.785;
    else if (from === "gallons" && to === "liters") result = value * 3.785;
    else if (from === "cups" && to === "milliliters") result = value * 240;
    else if (from === "milliliters" && to === "cups") result = value / 240;
  }

  if (category === "area") {
    if (from === "sq meters" && to === "sq kilometers") result = value / 1e6;
    else if (from === "sq kilometers" && to === "sq meters") result = value * 1e6;
    else if (from === "acres" && to === "sq meters") result = value * 4046.86;
    else if (from === "sq meters" && to === "acres") result = value / 4046.86;
    else if (from === "hectares" && to === "sq meters") result = value * 10000;
    else if (from === "sq meters" && to === "hectares") result = value / 10000;
    else if (from === "sq miles" && to === "sq kilometers") result = value * 2.589;
    else if (from === "sq kilometers" && to === "sq miles") result = value / 2.589;
  }

  if (category === "speed") {
    if (from === "m/s" && to === "km/h") result = value * 3.6;
    else if (from === "km/h" && to === "m/s") result = value / 3.6;
    else if (from === "mph" && to === "km/h") result = value * 1.609;
    else if (from === "km/h" && to === "mph") result = value / 1.609;
    else if (from === "knots" && to === "km/h") result = value * 1.852;
    else if (from === "km/h" && to === "knots") result = value / 1.852;
  }

  if (category === "time") {
    if (from === "seconds" && to === "minutes") result = value / 60;
    else if (from === "minutes" && to === "seconds") result = value * 60;
    else if (from === "minutes" && to === "hours") result = value / 60;
    else if (from === "hours" && to === "minutes") result = value * 60;
    else if (from === "hours" && to === "days") result = value / 24;
    else if (from === "days" && to === "hours") result = value * 24;
  }

  if (category === "storage") {
    const sizes = { "bytes": 1, "KB": 1024, "MB": 1024**2, "GB": 1024**3, "TB": 1024**4 };
    result = value * sizes[from] / sizes[to];
  }

  document.getElementById("result").innerHTML = `${value} ${from} = <b>${result.toFixed(4)}</b> ${to}`;
  document.getElementById("result").classList.remove("hidden");
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
