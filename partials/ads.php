
<?php
// ==== Global Adsense Config ====

$adsense_client = "ca-pub-xxxxxxxxxxxxxxx";

/**
 * Helper function for showing ads
 *
 * @param string $slot Optional ad-slot (if you want fixed ad slot)
 * @param string $format Default auto (responsive ads)
 * @param string $style CSS style (default display:block)
 */
function showAd($slot = '', $format = 'auto', $style = 'display:block') {
    global $adsense_client;
    ?>
    <ins class="adsbygoogle"
         style="<?= htmlspecialchars($style) ?>"
         data-ad-client="<?= htmlspecialchars($adsense_client) ?>"
         <?php if($slot !== ''): ?>
           data-ad-slot="<?= htmlspecialchars($slot) ?>"
         <?php endif; ?>
         data-ad-format="<?= htmlspecialchars($format) ?>"
         data-full-width-responsive="true"></ins>
    <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
    <?php
}
