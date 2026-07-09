<?php
// ==== Dynamic Variables ====
$tool_name     = "Bangladesh Number Lookup";
$tool_details  = "Check possible owner name by Bangladeshi mobile number instantly. Fast lookup with clean output and search history.";
$why_use_text  = "The Bangladesh Number Lookup helps you identify possible owner names from Bangladeshi mobile numbers quickly. It is useful for verification before calling, saving contacts, or checking unknown numbers.

Instead of guessing who called, this tool gives a quick lookup result in seconds. It saves time, reduces confusion, and keeps your checks simple.";
$how_to_use    = [
  "Enter a Bangladeshi mobile number (01XXXXXXXXX format).",
  "Click on the Lookup Number button.",
  "Wait a moment for the lookup response.",
  "View the possible owner name and use it as needed."
];

// ==== FAQ ====
$faqs = [
  [
    "What is Bangladesh Number Lookup?",
    "Bangladesh Number Lookup lets you check possible owner names from Bangladeshi mobile numbers. It helps with quick caller identification and contact verification."
  ],
  [
    "Which number format is supported?",
    "You can use Bangladeshi mobile numbers in formats like 01XXXXXXXXX, 1XXXXXXXXX, or 8801XXXXXXXXX. The tool normalizes them automatically."
  ],
  [
    "Is this tool free to use?",
    "Yes, this tool is free to use. You can perform lookups as needed."
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



function normalizePhone(string $input): string
{
    $digits = preg_replace('/\D+/', '', $input) ?? '';

    if (preg_match('/^01\d{9}$/', $digits) === 1) {
        return $digits;
    }

    if (preg_match('/^1\d{9}$/', $digits) === 1) {
        return '0' . $digits;
    }

    if (preg_match('/^8801\d{9}$/', $digits) === 1) {
        return substr($digits, 2);
    }

    return '';
}

function extractFirstName(array $payload): ?string
{
    $paths = [
        ['possible_owners'],
        ['possibleOwners'],
        ['owner_name'],
        ['ownerName'],
        ['name'],
        ['data', 'possible_owners'],
        ['data', 'possibleOwners'],
        ['data', 'owner_name'],
        ['data', 'ownerName'],
        ['data', 'name'],
    ];

    foreach ($paths as $path) {
        $value = $payload;
        $ok = true;

        foreach ($path as $key) {
            if (!is_array($value) || !array_key_exists($key, $value)) {
                $ok = false;
                break;
            }
            $value = $value[$key];
        }

        if (!$ok) {
            continue;
        }

        if (is_array($value)) {
            $first = trim((string) ($value[0] ?? ''));
            if ($first !== '') {
                return $first;
            }
        }

        $text = trim((string) $value);
        if ($text !== '' && strcasecmp($text, 'not found') !== 0) {
            $parts = array_values(array_filter(array_map('trim', explode(',', $text))));
            return $parts[0] ?? $text;
        }
    }

    return null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (($_POST['action'] ?? '') === 'lookup')) {
    header('Content-Type: application/json; charset=utf-8');

    $phone = normalizePhone((string) ($_POST['phone'] ?? ''));
    if ($phone === '') {
        http_response_code(422);
        echo json_encode([
            'ok' => false,
            'message' => 'Please enter a valid Bangladeshi mobile number.',
        ], JSON_UNESCAPED_SLASHES);
        exit;
    }

    if (!function_exists('curl_init')) {
        http_response_code(500);
        echo json_encode([
            'ok' => false,
            'message' => 'cURL is not available on server.',
        ], JSON_UNESCAPED_SLASHES);
        exit;
    }

    $endpoint = 'https://ivceekepvezxrewkixrc.supabase.co/functions/v1/lookup-number';
    $apiKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Iml2Y2Vla2VwdmV6eHJld2tpeHJjIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzU0NTY2NDksImV4cCI6MjA5MTAzMjY0OX0.8jEYLCSJ5O7jL4e2MM5r4utKrogfVvyWvq4JmI-KO00';
    $number = '+88' . $phone;
    $ts = (int) round(microtime(true) * 1000);
    $sig = hash('sha256', 'sc-v1-k9x2m:' . $number . ':' . $ts);

    $body = json_encode([
      'number' => $number,
      '_ts' => $ts,
      '_sig' => $sig,
    ], JSON_UNESCAPED_SLASHES);

    $ch = curl_init($endpoint);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 20,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_HTTPHEADER => [
            'Accept: application/json',
            'Content-Type: application/json',
            'apikey: ' . $apiKey,
            'Authorization: Bearer ' . $apiKey,
        ],
        CURLOPT_POSTFIELDS => $body,
    ]);

    $raw = curl_exec($ch);
    $curlErr = curl_error($ch);
    $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($raw === false) {
        http_response_code(502);
        echo json_encode([
            'ok' => false,
            'message' => 'Lookup request failed: ' . ($curlErr !== '' ? $curlErr : 'Unknown cURL error'),
        ], JSON_UNESCAPED_SLASHES);
        exit;
    }

    $decoded = json_decode($raw, true);
    if (!is_array($decoded)) {
        http_response_code(502);
        echo json_encode([
            'ok' => false,
            'message' => 'Upstream did not return valid JSON.',
            'http_code' => $httpCode,
        ], JSON_UNESCAPED_SLASHES);
        exit;
    }

    $failed = ($httpCode >= 400)
        || (($decoded['ok'] ?? true) === false)
        || (($decoded['success'] ?? true) === false);

    if ($failed) {
      $upstreamMessage = trim((string) ($decoded['message'] ?? $decoded['error'] ?? 'Upstream request failed'));
      $lowerMessage = strtolower($upstreamMessage);
      $friendlyMessage = $upstreamMessage;

      if ($lowerMessage === 'invalid request' || str_contains($lowerMessage, 'invalid request')) {
        $friendlyMessage = 'Lookup provider rejected the request. Please verify the number and try again.';
      } elseif (str_contains($lowerMessage, 'expired') || str_contains($lowerMessage, 'tampered')) {
        $friendlyMessage = 'Secure lookup token expired. Please try again.';
      }

        http_response_code(502);
        echo json_encode([
            'ok' => false,
        'message' => $friendlyMessage,
            'http_code' => $httpCode,
        ], JSON_UNESCAPED_SLASHES);
        exit;
    }

    $name = extractFirstName($decoded);

    echo json_encode([
        'ok' => true,
        'name' => $name,
      'message' => $name === null ? 'Name not found in response.' : 'Success',
    ], JSON_UNESCAPED_SLASHES);
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

    <!-- ==== TOOL START ==== -->
    <div class="max-w-xl mx-auto">
      <input id="phoneInput" type="text" placeholder="Enter number, e.g. 01xxxxxxxxx" class="w-full border border-slate-200 rounded-lg px-4 py-3 mb-3 focus:outline-none focus:ring-2 focus:ring-indigo-600">

      <button id="lookupBtn" onclick="lookupNumber()" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg transition">
        Lookup Number
      </button>

      <div id="result" class="mt-4 bg-slate-50 border border-slate-200 rounded-lg p-4 text-slate-800 min-h-[60px]">
        Result will appear here...
      </div>

      <div class="mt-4 bg-slate-50 border border-slate-200 rounded-lg p-4">
        <div class="flex items-center justify-between mb-2">
          <h3 class="text-sm font-semibold text-slate-800">Last 10 viewed numbers</h3>
          <button id="clearHistoryBtn" type="button" class="text-xs text-indigo-700 hover:text-indigo-900 font-medium">Clear</button>
        </div>
        <ul id="historyList" class="space-y-2 text-sm text-slate-700">
          <li class="text-slate-500">No search history yet.</li>
        </ul>
      </div>
    </div>

    </div>
    <!-- ==== TOOL END ==== -->

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

    <?php require dirname(__DIR__, 2).'/partials/back-to-tools.php'; ?>

  </section>
</main>

<?php require dirname(__DIR__, 2).'/partials/footer.php'; ?>

<!-- SCRIPT -->

<script>
const HISTORY_KEY = 'number_lookup_history_v1';
const HISTORY_LIMIT = 10;

function getHistory() {
  try {
    const raw = localStorage.getItem(HISTORY_KEY);
    const parsed = JSON.parse(raw || '[]');
    return Array.isArray(parsed) ? parsed : [];
  } catch (_err) {
    return [];
  }
}

function setHistory(history) {
  localStorage.setItem(HISTORY_KEY, JSON.stringify(history.slice(0, HISTORY_LIMIT)));
}

function pushHistory(phone, resultText) {
  const history = getHistory().filter((item) => item.phone !== phone);
  history.unshift({
    phone,
    result: resultText,
    searchedAt: new Date().toISOString()
  });
  setHistory(history);
  renderHistory();
}

function formatDate(isoDate) {
  const date = new Date(isoDate);
  if (Number.isNaN(date.getTime())) {
    return '';
  }
  return date.toLocaleString();
}

function escapeHtml(value) {
  return String(value)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');
}

function renderHistory() {
  const listEl = document.getElementById('historyList');
  if (!listEl) {
    return;
  }

  const history = getHistory();
  if (!history.length) {
    listEl.innerHTML = '<li class="text-slate-500">No search history yet.</li>';
    return;
  }

  listEl.innerHTML = history
    .map((item) => {
      const safePhone = escapeHtml(String(item.phone || ''));
      const safeResult = escapeHtml(String(item.result || ''));
      const safeTime = escapeHtml(formatDate(String(item.searchedAt || '')));
      return '<li class="border border-slate-200 rounded-md p-2 bg-white">'
        + '<div class="font-medium">' + safePhone + '</div>'
        + '<div class="text-slate-600">' + safeResult + '</div>'
        + '<div class="text-xs text-slate-500 mt-1">' + safeTime + '</div>'
        + '</li>';
    })
    .join('');
}

async function lookupNumber() {
  const phone = (document.getElementById('phoneInput').value || '').trim();
  const resultEl = document.getElementById('result');
  const btn = document.getElementById('lookupBtn');

  if (!phone) {
    resultEl.textContent = 'Please enter a number.';
    return;
  }

  btn.disabled = true;
  btn.textContent = 'Looking up...';
  resultEl.textContent = 'Fetching data...';

  try {
    const body = new URLSearchParams({ action: 'lookup', phone });
    const response = await fetch(window.location.pathname, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: body.toString()
    });

    const raw = await response.text();
    let data;

    try {
      data = JSON.parse(raw);
    } catch (_err) {
      throw new Error('Server did not return JSON response.');
    }

    if (!response.ok || data.ok === false) {
      throw new Error(data.message || 'Request failed');
    }

    const message = data.name ? ('Owner Name: ' + data.name) : (data.message || 'Name not found');
    resultEl.textContent = message;
    pushHistory(phone, message);
  } catch (error) {
    const message = error.message || 'Lookup failed';
    resultEl.textContent = message;
  } finally {
    btn.disabled = false;
    btn.textContent = 'Lookup Number';
  }
}

document.addEventListener('DOMContentLoaded', function () {
  renderHistory();

  const clearBtn = document.getElementById('clearHistoryBtn');
  if (clearBtn) {
    clearBtn.addEventListener('click', function () {
      localStorage.removeItem(HISTORY_KEY);
      renderHistory();
    });
  }

  const input = document.getElementById('phoneInput');
  if (input) {
    input.addEventListener('keydown', function (event) {
      if (event.key === 'Enter') {
        lookupNumber();
      }
    });
  }
});
</script>


<script type="application/ld+json">
<?= json_encode([
  '@context' => 'https://schema.org',
  '@type' => 'FAQPage',
  'mainEntity' => array_map(static function ($faq) {
      return [
        '@type' => 'Question',
        'name' => $faq[0],
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => $faq[1],
        ],
      ];
  }, $faqs),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>
</script>

<script type="application/ld+json">
<?= json_encode([
  '@context' => 'https://schema.org',
  '@type' => 'WebPage',
  'name' => $meta_title,
  'description' => $meta_desc,
  'url' => $canonical,
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>
</script>
</body>
</html>