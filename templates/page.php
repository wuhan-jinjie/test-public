<?php
ob_start();
?>
<section class="section page-content">
    <div class="container">
        <header class="section-header">
            <?php if (!empty($page['meta']['kicker'])): ?>
                <p class="section-kicker"><?= htmlspecialchars($page['meta']['kicker']) ?></p>
            <?php endif; ?>
            <h1><?= htmlspecialchars($page['meta']['title'] ?? '') ?></h1>
            <?php if (!empty($page['meta']['description'])): ?>
                <p class="section-intro"><?= htmlspecialchars($page['meta']['description']) ?></p>
            <?php endif; ?>
        </header>
        <div class="page-body">
            <?= $content ?>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
