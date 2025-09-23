<?php
$hero = $page['meta']['hero'] ?? [];
$features = $page['meta']['features'] ?? [];
$scenarios = $page['meta']['scenarios'] ?? [];
$outcomes = $page['meta']['outcomes'] ?? [];
$cta = $page['meta']['cta'] ?? [];

ob_start();
?>
<section class="section product-hero">
    <div class="container">
        <p class="section-kicker"><?= htmlspecialchars($hero['kicker'] ?? '行业解决方案') ?></p>
        <h1><?= htmlspecialchars($page['meta']['title'] ?? '') ?></h1>
        <?php if (!empty($page['meta']['summary'])): ?>
            <p class="section-intro"><?= htmlspecialchars($page['meta']['summary']) ?></p>
        <?php endif; ?>
        <?php if (!empty($cta)): ?>
            <a class="btn primary" href="<?= htmlspecialchars($cta['url'] ?? '/contact.html') ?>"><?= htmlspecialchars($cta['text'] ?? '预约咨询') ?></a>
        <?php endif; ?>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="grid grid-2">
            <div>
                <h2>核心功能</h2>
                <ul class="feature-list">
                    <?php foreach ($features as $feature): ?>
                        <li><?= htmlspecialchars($feature) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div>
                <h2>适用场景</h2>
                <ul class="feature-list">
                    <?php foreach ($scenarios as $scenario): ?>
                        <li><?= htmlspecialchars($scenario) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="section section-alt">
    <div class="container">
        <h2>交付价值</h2>
        <ul class="benefit-list">
            <?php foreach ($outcomes as $outcome): ?>
                <li><?= htmlspecialchars($outcome) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>

<section class="section">
    <div class="container page-body">
        <?= $content ?>
    </div>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
