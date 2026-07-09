<?php
// /tools/facebook-video-downloader/index.php

// ==== Dynamic Variables ====
$tool_name     = "Facebook Video Downloader"; 
$tool_details  = "Download Facebook videos in HD and SD quality for free. Paste any Facebook video link and get instant download options.";
$why_use_text  = "Facebook videos are often not easy to download directly, especially when you want to save them offline. Our Facebook Video Downloader provides a simple, secure, and fast way to fetch download links.\n\nUnlike unreliable third-party apps or shady extensions, this tool works directly from your browser without requiring login or additional software. It's free, lightweight, and designed for smooth performance.\n\nWhether you want to save a lecture, a live event, a recipe video, or personal content, this downloader gives you multiple formats and quality options instantly.";
$how_to_use    = [
  "Step 1 - Copy the URL of the Facebook video you want to download from your browser or Facebook app.",
  "Step 2 - Paste the copied link into the input box on this page.",
  "Step 3 - Click the 'Fetch' button to process the video link.",
  "Step 4 - Choose your preferred video quality (HD or SD) and click the download button to save it."
];

// ==== FAQ ====
$faqs = [
  [
    "How can I download a Facebook video using this tool?", 
    "Simply copy the video link from Facebook, paste it into the input box above, and click the 'Fetch' button. The tool will generate available download links in HD or SD quality, and you can save the video directly."
  ],
  [
    "Is this Facebook Video Downloader free to use?", 
    "Yes, this tool is completely free. You don’t need to install apps, register, or pay any fees. Just paste your Facebook video link and download instantly."
  ],
  [
    "Can I download private or restricted Facebook videos?", 
    "No. This tool only works for publicly accessible Facebook videos. If a video is private, inside a group, or has restricted privacy settings, the downloader cannot access it for security and privacy reasons."
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

    <!-- ==== Tool UI ==== -->
    <form id="fbForm" class="space-y-3">
      <label for="video_url" class="block font-semibold text-slate-700">Facebook video URL</label>
      <div class="flex flex-col md:flex-row gap-3">
        <input type="url" id="video_url" required class="flex-1 border border-slate-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="https://www.facebook.com/watch?v=1234567890" />
        <div class="flex gap-2">
          <button id="fetchBtn" type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg px-4 py-2">Fetch</button>
          <button id="clearBtn" type="button" class="bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold rounded-lg px-4 py-2">Clear</button>
        </div>
      </div>
    </form>

    <div id="result" class="mt-6"></div>
    <!-- ==== Tool UI End ==== -->

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

<script>
(function(){
  const form = document.getElementById("fbForm");
  const urlInput = document.getElementById("video_url");
  const resBox = document.getElementById("result");
  const fetchBtn = document.getElementById("fetchBtn");
  const clearBtn = document.getElementById("clearBtn");

  clearBtn.addEventListener("click", () => {
    urlInput.value = "";
    resBox.innerHTML = "";
    urlInput.focus();
  });

  form.addEventListener("submit", async function(e){
    e.preventDefault();
    const url = urlInput.value.trim();
    if(!url) return;

    fetchBtn.disabled = true;
    const oldLabel = fetchBtn.textContent;
    fetchBtn.textContent = "Fetching…";
    resBox.innerHTML = "<div class='text-slate-600'>Processing…</div>";

    try {
      const res = await fetch("/tools/facebook-video-downloader/server/api.php?url=" + encodeURIComponent(url));
      const text = await res.text();

      let data;
      try { data = JSON.parse(text); }
      catch(parseErr) {
        resBox.innerHTML = `<div class="bg-slate-50 border border-slate-200 rounded-lg p-4"><div class="text-slate-600">Server returned non-JSON:</div><pre class="whitespace-pre-wrap break-words text-sm text-slate-700 mt-2">${text.replace(/[<>&]/g, s => ({'<':'&lt;','>':'&gt;','&':'&amp;'}[s]))}</pre></div>`;
        return;
      }

      if(!data.success){
        resBox.innerHTML = `<div class="bg-slate-50 border border-slate-200 rounded-lg p-4"><div class="text-slate-600">Error: ${data.message || "Failed"}</div></div>`;
        return;
      }

      let html = `<div class="bg-slate-50 border border-slate-200 rounded-lg p-4"><div class="grid md:grid-cols-2 gap-4">`;

      // Thumbnail
      html += `<div>`;
      if (data.thumbnail) {
        html += `<img src="${data.thumbnail}" alt="thumbnail" class="w-full h-auto rounded-lg object-cover">`;
      } else {
        html += `<div class="w-full h-48 flex items-center justify-center bg-slate-100 rounded-lg text-slate-400">No thumbnail</div>`;
      }
      html += `</div>`;

      // Title & Links
      html += `<div>`;
      if (data.title) {
        html += `<h3 class="font-bold text-slate-800 mb-2">${data.title}</h3>`;
      }
      if (data.links && Object.keys(data.links).length) {
        html += `<div class="flex flex-wrap gap-2">`;
        for (const label in data.links) {
          const href = data.links[label];
          if (!href) continue;
          html += `<a href="${href}" target="_blank" rel="noopener noreferrer" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-lg font-semibold">${label}</a>`;
        }
        html += `</div>`;
      } else {
        html += `<p class="text-slate-600">No download links found.</p>`;
      }
      html += `</div></div></div>`;

      resBox.innerHTML = html;

    } catch(err){
      resBox.innerHTML = `<div class="bg-slate-50 border border-slate-200 rounded-lg p-4"><div class="text-slate-600">Error: ${String(err)}</div></div>`;
    } finally {
      fetchBtn.disabled = false;
      fetchBtn.textContent = oldLabel;
    }
  });
})();
</script>
<script>
(function(){
  const form = document.getElementById("fbForm");
  const urlInput = document.getElementById("video_url");
  const resBox = document.getElementById("result");
  const fetchBtn = document.getElementById("fetchBtn");
  const clearBtn = document.getElementById("clearBtn");

  /* ===============================
     AUTO FETCH FROM ?video= LINK
     =============================== */
  function autoFetchFromQuery() {
    const params = new URLSearchParams(window.location.search);
    const videoLink = params.get("video");

    if (videoLink) {
      try {
        const decoded = decodeURIComponent(videoLink);
        urlInput.value = decoded;

        // Small delay to ensure DOM ready
        setTimeout(() => {
          fetchBtn.click();
        }, 300);

      } catch (e) {
        console.error("Invalid video parameter");
      }
    }
  }

  // Call auto fetch on page load
  autoFetchFromQuery();
  /* =============================== */

  clearBtn.addEventListener("click", () => {
    urlInput.value = "";
    resBox.innerHTML = "";
    urlInput.focus();
  });

  form.addEventListener("submit", async function(e){
    e.preventDefault();
    const url = urlInput.value.trim();
    if(!url) return;

    fetchBtn.disabled = true;
    const oldLabel = fetchBtn.textContent;
    fetchBtn.textContent = "Fetching…";
    resBox.innerHTML = "<div class='text-slate-600'>Processing…</div>";

    try {
      const res = await fetch("/tools/facebook-video-downloader/server/api.php?url=" + encodeURIComponent(url));
      const text = await res.text();

      let data;
      try { data = JSON.parse(text); }
      catch {
        resBox.innerHTML = `<pre>${text}</pre>`;
        return;
      }

      if(!data.success){
        resBox.innerHTML = `<div>Error: ${data.message || "Failed"}</div>`;
        return;
      }

      let html = `<div class="p-4 border rounded-lg">`;

      if (data.thumbnail) {
        html += `<img src="${data.thumbnail}" class="rounded mb-3">`;
      }

      if (data.title) {
        html += `<h3 class="font-bold mb-2">${data.title}</h3>`;
      }

      if (data.links) {
        for (const label in data.links) {
          html += `<a href="${data.links[label]}" target="_blank"
            class="inline-block bg-indigo-600 text-white px-3 py-2 rounded mr-2 mb-2">${label}</a>`;
        }
      }

      html += `</div>`;
      resBox.innerHTML = html;

    } catch(err){
      resBox.innerHTML = `<div>Error: ${err}</div>`;
    } finally {
      fetchBtn.disabled = false;
      fetchBtn.textContent = oldLabel;
    }
  });
})();
</script>
