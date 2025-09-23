<?php
ob_start();
?>
<section class="section page-content">
    <div class="container">
        <header class="section-header">
            <h1><?= htmlspecialchars($page['meta']['title'] ?? '主营业务') ?></h1>
            <?php if (!empty($page['meta']['intro'])): ?>
                <p class="section-intro"><?= htmlspecialchars($page['meta']['intro']) ?></p>
            <?php endif; ?>
        </header>
        <div class="grid grid-3">
            <?php foreach ($products as $product): ?>
                <article class="card">
                    <h2><a href="<?= htmlspecialchars($product['url']) ?>"><?= htmlspecialchars($product['meta']['title'] ?? '') ?></a></h2>
                    <p><?= htmlspecialchars($product['meta']['summary'] ?? $product['excerpt'] ?? '') ?></p>
                    <?php if (!empty($product['meta']['features'])): ?>
                        <ul>
                            <?php foreach (array_slice($product['meta']['features'], 0, 3) as $feature): ?>
                                <li><?= htmlspecialchars($feature) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <a class="btn link" href="<?= htmlspecialchars($product['url']) ?>">查看详情</a>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
