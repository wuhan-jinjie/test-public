<?php
ob_start();
?>
<section class="section page-content">
    <div class="container">
        <header class="section-header">
            <h1><?= htmlspecialchars($page['meta']['title'] ?? '新闻动态') ?></h1>
            <?php if (!empty($page['meta']['intro'])): ?>
                <p class="section-intro"><?= htmlspecialchars($page['meta']['intro']) ?></p>
            <?php endif; ?>
        </header>
        <div class="news-list full">
            <?php foreach ($news as $item): ?>
                <article class="news-item">
                    <?php if (!empty($item['meta']['date'])): ?>
                        <time datetime="<?= htmlspecialchars($item['meta']['date']) ?>"><?= htmlspecialchars($item['meta']['date']) ?></time>
                    <?php endif; ?>
                    <h2><a href="<?= htmlspecialchars($item['url']) ?>"><?= htmlspecialchars($item['meta']['title'] ?? '') ?></a></h2>
                    <p><?= htmlspecialchars($item['meta']['summary'] ?? $item['excerpt'] ?? '') ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
