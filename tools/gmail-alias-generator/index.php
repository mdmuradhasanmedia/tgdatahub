<?php
// =====================================================
// Gmail Alias Generator
// Category: Email Tools
// =====================================================

// ==== Dynamic Variables ====
$tool_name = "Gmail Alias Generator";

$tool_details = "Generate unlimited Gmail aliases using plus addressing and Gmail-compatible variations. Create unique email aliases for testing, registrations, filtering, privacy, and inbox organization while keeping all emails delivered to your primary Gmail account.";

$why_use_text = "Gmail Alias Generator helps users create multiple Gmail-compatible email aliases from a single Gmail account. These aliases can be used for website registrations, app testing, email organization, marketing campaigns, and privacy protection without creating additional Gmail accounts.

Gmail supports plus addressing, allowing users to add custom text after a plus sign (+). Emails sent to these aliases are automatically delivered to the original Gmail inbox, making them ideal for organizing subscriptions and identifying email sources.

Developers, marketers, QA testers, and regular Gmail users frequently use aliases to separate communications, test signup forms, track email sources, and improve inbox management. Instead of creating multiple email accounts, one Gmail account can generate virtually unlimited aliases.

This tool instantly creates random and unique Gmail aliases that are easy to copy and use. It saves time and allows users to take advantage of Gmail's built-in alias functionality without requiring any technical knowledge.";

$how_to_use = [
    "Enter your Gmail username without the @gmail.com part.",
    "Choose how many aliases you want to generate.",
    "Click the Generate button to create Gmail aliases instantly.",
    "Copy any generated alias and use it for registrations, testing, filtering, or email organization."
];

$faqs = [
    [
        "What is a Gmail alias?",
        "A Gmail alias is an alternative version of your Gmail address that still delivers messages to your primary inbox. Gmail supports plus addressing, which allows users to append custom text after a plus sign. For example, username+shopping@gmail.com and username+newsletters@gmail.com both deliver emails to username@gmail.com."
    ],
    [
        "Do generated aliases receive emails?",
        "Yes. Emails sent to supported Gmail aliases are automatically delivered to the inbox of the original Gmail account. No additional setup or forwarding configuration is required."
    ],
    [
        "Why should I use Gmail aliases?",
        "Gmail aliases help organize emails, improve privacy, identify email sources, separate subscriptions, and simplify testing. They are commonly used by developers, marketers, businesses, and regular Gmail users."
    ],
    [
        "Can I create unlimited Gmail aliases?",
        "Gmail's plus addressing system allows users to create virtually unlimited aliases by changing the text after the plus sign. This makes aliases useful for long-term email management and testing."
    ],
    [
        "Is this Gmail Alias Generator free?",
        "Yes. This tool is completely free and requires no registration. Simply enter your Gmail username and generate aliases instantly."
    ]
];

$page_title = $tool_name;

// ==== Auto Fetch Domain ====
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$domain = $_SERVER['HTTP_HOST'];

// ==== Image Fallback ====
$tool_slug = strtolower(str_replace(' ', '-', $tool_name));
$tool_image = "/assets/images/{$tool_slug}.png";

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $tool_image)) {
    $tool_image = "/assets/images/default.png";
}

// ==== SEO Meta Tags ====
$meta_title = $tool_name . " | TG Data Hub Tools";
$meta_desc = $tool_details;
$canonical = $protocol . $domain . "/tools/" . $tool_slug;

// ==== Generator Logic ====
$aliases = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $count = (int)($_POST['count'] ?? 5);

    $count = max(1, min($count, 100));

    if ($username !== '') {

        for ($i = 0; $i < $count; $i++) {

            $random = substr(
                str_shuffle(
                    'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'
                ),
                0,
                rand(6, 10)
            );

            $aliases[] = $username . '+' . $random . '@gmail.com';
        }
    }
}

require dirname(__DIR__, 2) . '/partials/header.php';
?>

<meta name="description" content="<?= htmlspecialchars($meta_desc) ?>">
<link rel="canonical" href="<?= $canonical ?>">

<meta property="og:title" content="<?= htmlspecialchars($meta_title) ?>">
<meta property="og:description" content="<?= htmlspecialchars($meta_desc) ?>">
<meta property="og:type" content="website">
<meta property="og:url" content="<?= $canonical ?>">
<meta property="og:image" content="<?= $protocol . $domain . $tool_image ?>">

<main class="max-w-5xl mx-auto px-4 py-8">

    <!-- Breadcrumb -->
    <nav aria-label="Breadcrumb" class="mb-4 text-sm text-slate-500">
        <ol class="flex space-x-2">
            <li><a href="/" class="hover:text-indigo-600">Home</a></li>
            <li>/</li>
            <li><a href="/tools" class="hover:text-indigo-600">Tools</a></li>
            <li>/</li>
            <li class="text-slate-700"><?= htmlspecialchars($tool_name) ?></li>
        </ol>
    </nav>

    <section class="bg-white border border-slate-200 rounded-2xl shadow-lg p-6 md:p-8">

        <header class="text-center mb-8">

            <div class="w-16 h-16 mx-auto mb-4 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-8 h-8"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="1.8"
                          d="M4 6h16v12H4V6zm0 0l8 6 8-6M12 12v6m0-6l-2 2m2-2l2 2"/>
                </svg>

            </div>

            <h1 class="text-3xl font-extrabold text-slate-800">
                <?= htmlspecialchars($tool_name) ?>
            </h1>

            <p class="mt-2 text-slate-600">
                <?= htmlspecialchars($tool_details) ?>
            </p>

        </header>

        <!-- Tool UI -->

        <form method="post" class="space-y-4">

            <div>
                <label class="block mb-2 font-medium text-slate-700">
                    Gmail Username
                </label>

                <input
                    type="text"
                    name="username"
                    required
                    placeholder="mdmuradhasanmedia"
                    value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                    class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block mb-2 font-medium text-slate-700">
                    Number of Aliases
                </label>

                <select
                    name="count"
                    class="w-full border border-slate-200 rounded-xl px-4 py-3">

                    <?php for($i=5;$i<=100;$i+=5): ?>
                        <option value="<?= $i ?>">
                            <?= $i ?>
                        </option>
                    <?php endfor; ?>

                </select>
            </div>

            <button
                type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl transition">

                Generate Aliases

            </button>

        </form>

        <?php if(!empty($aliases)): ?>

            <div class="mt-6">

                <h2 class="font-bold text-slate-800 mb-3">
                    Generated Aliases
                </h2>

                <div class="space-y-2">

                    <?php foreach($aliases as $alias): ?>

                        <input
                            readonly
                            value="<?= htmlspecialchars($alias) ?>"
                            onclick="this.select();navigator.clipboard.writeText(this.value)"
                            class="w-full border border-slate-200 rounded-lg px-4 py-3 bg-slate-50 cursor-pointer">

                    <?php endforeach; ?>

                </div>

            </div>

        <?php endif; ?>

        <!-- Why Use -->

        <div class="mt-10">

            <h2 class="text-xl font-bold text-slate-800 mb-3">
                Why Use Gmail Alias Generator?
            </h2>

            <?php foreach(explode("\n\n",$why_use_text) as $paragraph): ?>

                <p class="text-slate-600 leading-relaxed mb-4">
                    <?= nl2br(htmlspecialchars(trim($paragraph))) ?>
                </p>

            <?php endforeach; ?>

        </div>

        <!-- How To Use -->

        <div class="mt-8">

            <h2 class="text-xl font-bold text-slate-800 mb-3">
                How To Use
            </h2>

            <ol class="list-decimal pl-5 space-y-2 text-slate-600">

                <?php foreach($how_to_use as $step): ?>
                    <li><?= htmlspecialchars($step) ?></li>
                <?php endforeach; ?>

            </ol>

        </div>

        <!-- FAQ -->

        <div class="mt-8 border-t border-slate-200 pt-6">

            <h2 class="text-xl font-bold text-slate-800 mb-4">
                Frequently Asked Questions
            </h2>

            <div class="space-y-3">

                <?php foreach($faqs as [$q,$a]): ?>

                    <details class="border border-slate-200 rounded-xl p-4">

                        <summary class="font-semibold cursor-pointer text-slate-800">
                            <?= htmlspecialchars($q) ?>
                        </summary>

                        <div class="mt-3 text-slate-600 leading-relaxed">
                            <?= htmlspecialchars_decode($a) ?>
                        </div>

                    </details>

                <?php endforeach; ?>

            </div>

        </div>

        <?php require dirname(__DIR__, 2).'/partials/back-to-tools.php'; ?>

    </section>

</main>

<?php require dirname(__DIR__, 2).'/partials/footer.php'; ?>

<script type="application/ld+json">
<?= json_encode([
    "@context"=>"https://schema.org",
    "@type"=>"FAQPage",
    "mainEntity"=>array_map(function($faq){
        return [
            "@type"=>"Question",
            "name"=>$faq[0],
            "acceptedAnswer"=>[
                "@type"=>"Answer",
                "text"=>$faq[1]
            ]
        ];
    },$faqs)
], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT); ?>
</script>

