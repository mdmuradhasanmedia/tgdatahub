<?php
$url = $_GET['url'] ?? '';
$cookie = $_GET['cookie'] ?? '';

if (!$url || !$cookie) {
    die("Missing URL or cookie");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Modern Video Player</title>

<!-- Plyr CSS -->
<link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />

<style>
body {
    margin: 0;
    padding: 0;
    background: #0f0f0f;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.player-wrapper {
    width: 90%;
    max-width: 1200px;
}
.plyr__control--overlaid {
    background: rgba(255,255,255,0.25);
    backdrop-filter: blur(4px);
}
</style>

</head>
<body>

<div class="player-wrapper">
    <video id="player" controls autoplay playsinline>
        <!-- DO NOT URLENCODE COOKIE -->
        <source src="stream.php?url=<?= urlencode($url) ?>&cookie=<?= $cookie ?>" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>
</div>

<!-- Plyr JS -->
<script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>

<script>
const player = new Plyr('#player', {
    autoplay: true,
    controls: [
        'play-large',
        'play',
        'progress',
        'current-time',
        'mute',
        'volume',
        'captions',
        'settings',
        'fullscreen',
    ],
    settings: ['speed'],
    speed: { selected: 1, options: [0.5, 1, 1.25, 1.5, 2] },
});
</script>

</body>
</html>
