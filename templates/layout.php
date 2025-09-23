<?php
/** @var array $site */
/** @var array $page */
/** @var array $nav */
/** @var string $content */
/** @var array $products */
/** @var array $news */

$baseUrl = rtrim($site['base_url'] ?? '', '/');
$asset = static function (string $path) use ($baseUrl): string {
    return ($baseUrl === '' ? '' : $baseUrl) . '/' . ltrim($path, '/');
};

$headerNav = array_filter($nav, static function ($item) {
    return $item['show_in_header'] ?? true;
});
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($site['lang'] ?? 'zh-CN') ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars(($page['meta']['title'] ?? '页面') . ' | ' . ($site['title'] ?? '网站')) ?></title>
    <meta name="description" content="<?= htmlspecialchars($page['meta']['description'] ?? $site['description'] ?? '') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= htmlspecialchars($asset('assets/css/style.css')) ?>">
</head>
<body>
<header class="site-header">
    <div class="container header-inner">
        <a class="logo" href="<?= htmlspecialchars($baseUrl === '' ? '/' : $baseUrl . '/') ?>" aria-label="<?= htmlspecialchars($site['title'] ?? '') ?>">
            <span class="logo-mark" aria-hidden="true">JJ</span>
            <span class="logo-text">
                <strong><?= htmlspecialchars($site['title'] ?? '') ?></strong>
                <small><?= htmlspecialchars($site['slogan'] ?? '') ?></small>
            </span>
        </a>
        <nav class="site-nav" aria-label="主导航">
            <button class="nav-toggle" aria-expanded="false" aria-controls="primary-menu">菜单</button>
            <ul id="primary-menu" aria-expanded="false">
                <?php foreach ($headerNav as $item): ?>
                    <?php $children = array_filter($item['children'] ?? [], static function ($child) {
                        return $child['show_in_header'] ?? true;
                    }); ?>
                    <?php $hasChildren = !empty($children); ?>
                    <li class="<?= ($item['active'] ?? false) ? 'active' : '' ?><?= $hasChildren ? ' has-children' : '' ?>">
                        <a href="<?= htmlspecialchars($item['url']) ?>"><?= htmlspecialchars($item['label']) ?></a>
                        <?php if ($hasChildren): ?>
                            <ul class="sub-menu">
                                <?php foreach ($children as $child): ?>
                                    <li class="<?= ($child['active'] ?? false) ? 'active' : '' ?>">
                                        <a href="<?= htmlspecialchars($child['url']) ?>"><?= htmlspecialchars($child['label']) ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </div>
</header>
<main>
    <?= $content ?>
</main>
<footer class="site-footer">
    <div class="container footer-inner">
        <div>
            <h3><?= htmlspecialchars($site['title'] ?? '') ?></h3>
            <p>地址：<?= htmlspecialchars($site['contact']['address'] ?? '') ?></p>
            <p>电话：<?= htmlspecialchars($site['contact']['sales_phone'] ?? '') ?>（周一至周五 09:00-18:00）</p>
            <p>邮箱：<a href="mailto:<?= htmlspecialchars($site['contact']['email'] ?? '') ?>"><?= htmlspecialchars($site['contact']['email'] ?? '') ?></a></p>
        </div>
        <div>
            <h4>快速链接</h4>
            <ul class="footer-links">
                <?php foreach ($headerNav as $item): ?>
                    <li><a href="<?= htmlspecialchars($item['url']) ?>"><?= htmlspecialchars($item['label']) ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div>
            <h4>关注我们</h4>
            <p>微信公众号：<?= htmlspecialchars($site['contact']['wechat'] ?? '') ?></p>
            <p>服务热线：<?= htmlspecialchars($site['contact']['service_hotline'] ?? '') ?></p>
        </div>
    </div>
    <div class="container footer-bottom">
        <p>© <?= date('Y') ?> <?= htmlspecialchars($site['title'] ?? '') ?> 版权所有. 鄂ICP备 备00000000号-1</p>
    </div>
</footer>
<script src="<?= htmlspecialchars($asset('assets/js/main.js')) ?>" defer></script>
</body>
</html>
