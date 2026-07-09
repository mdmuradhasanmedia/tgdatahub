<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$parts = array_values(array_filter(explode('/', $uri)));
// Expected: ['', 'tool', '<slug>'] or ['tool','<slug>']
$slug = $parts[count($parts)-1] ?? '';

$tool_file = __DIR__ . '/tools/' . basename($slug) . '.php';

$page_title = ucwords(str_replace('-', ' ', basename($slug)));

require __DIR__ . '/partials/header.php';

if (is_file($tool_file)) {
  include $tool_file;
} else {
  http_response_code(404);
  echo "<h1>Tool Lists</h1>";
}

require __DIR__ . '/partials/footer.php';
