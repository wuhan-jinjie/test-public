<?php
ob_start();
?>
<section class="section page-content">
    <div class="container">
        <article class="news-article">
            <header class="section-header">
                <p class="section-kicker">公司新闻</p>
                <h1><?= htmlspecialchars($page['meta']['title'] ?? '') ?></h1>
                <?php if (!empty($page['meta']['date'])): ?>
                    <p class="news-date">发布日期：<?= htmlspecialchars($page['meta']['date']) ?></p>
                <?php endif; ?>
            </header>
            <div class="page-body">
                <?= $content ?>
            </div>
        </article>
        <aside class="news-sidebar">
            <h2>更多新闻</h2>
            <ul>
                <?php foreach (array_slice($news, 0, 5) as $item): ?>
                    <?php if ($item['url'] === $page['url']) { continue; } ?>
                    <li><a href="<?= htmlspecialchars($item['url']) ?>"><?= htmlspecialchars($item['meta']['title'] ?? '') ?></a></li>
                <?php endforeach; ?>
            </ul>
        </aside>
    </div>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
