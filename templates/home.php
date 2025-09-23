<?php
$hero = $page['meta']['hero'] ?? [];
$highlights = $page['meta']['highlights'] ?? [];
$servicesMeta = $page['meta']['services'] ?? [];
$solutionsMeta = $page['meta']['solutions'] ?? [];
$casesMeta = $page['meta']['cases'] ?? [];
$newsMeta = $page['meta']['news'] ?? [];
$partners = $page['meta']['partners']['items'] ?? [];
$contactBlock = $page['meta']['contact'] ?? [];

$newsItems = $newsMeta['items'] ?? [];
if (empty($newsItems) && !empty($news)) {
    $newsItems = array_map(static function ($item) {
        return [
            'title' => $item['meta']['title'] ?? '',
            'date' => $item['meta']['date'] ?? '',
            'summary' => $item['meta']['summary'] ?? $item['excerpt'] ?? '',
            'url' => $item['url'],
        ];
    }, array_slice($news, 0, $newsMeta['limit'] ?? 3));
}

ob_start();
?>
<section class="hero" id="hero">
    <div class="container hero-inner">
        <div class="hero-text">
            <?php if (!empty($hero['kicker'])): ?>
                <p class="hero-kicker"><?= htmlspecialchars($hero['kicker']) ?></p>
            <?php endif; ?>
            <h1><?= htmlspecialchars($hero['title'] ?? ($page['meta']['title'] ?? '')) ?></h1>
            <?php if (!empty($hero['subtitle'])): ?>
                <p class="hero-subtitle"><?= htmlspecialchars($hero['subtitle']) ?></p>
            <?php endif; ?>
            <div class="hero-actions">
                <?php if (!empty($hero['primary_button'])): ?>
                    <a class="btn primary" href="<?= htmlspecialchars($hero['primary_button']['url'] ?? '#') ?>"><?= htmlspecialchars($hero['primary_button']['text'] ?? '了解更多') ?></a>
                <?php endif; ?>
                <?php if (!empty($hero['secondary_button'])): ?>
                    <a class="btn secondary" href="<?= htmlspecialchars($hero['secondary_button']['url'] ?? '#') ?>"><?= htmlspecialchars($hero['secondary_button']['text'] ?? '联系我们') ?></a>
                <?php endif; ?>
            </div>
        </div>
        <?php if (!empty($highlights)): ?>
            <div class="hero-highlights" role="region" aria-label="公司能力概览">
                <?php foreach ($highlights as $highlight): ?>
                    <div class="highlight-card">
                        <strong><?= htmlspecialchars($highlight['number'] ?? '') ?></strong>
                        <span><?= htmlspecialchars($highlight['label'] ?? '') ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="section section-alt" id="services">
    <div class="container">
        <h2><?= htmlspecialchars($servicesMeta['title'] ?? '主营业务') ?></h2>
        <?php if (!empty($servicesMeta['intro'])): ?>
            <p class="section-intro"><?= htmlspecialchars($servicesMeta['intro']) ?></p>
        <?php endif; ?>
        <div class="grid grid-3">
            <?php foreach ($servicesMeta['items'] ?? [] as $service): ?>
                <article class="card">
                    <h3><?= htmlspecialchars($service['title'] ?? '') ?></h3>
                    <p><?= htmlspecialchars($service['description'] ?? '') ?></p>
                    <?php if (!empty($service['bullets'])): ?>
                        <ul>
                            <?php foreach ($service['bullets'] as $bullet): ?>
                                <li><?= htmlspecialchars($bullet) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section" id="solutions">
    <div class="container">
        <h2><?= htmlspecialchars($solutionsMeta['title'] ?? '行业解决方案') ?></h2>
        <div class="grid grid-2">
            <?php foreach ($solutionsMeta['items'] ?? [] as $solution): ?>
                <article class="solution">
                    <h3><?= htmlspecialchars($solution['title'] ?? '') ?></h3>
                    <p><?= htmlspecialchars($solution['description'] ?? '') ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section section-alt" id="cases">
    <div class="container">
        <h2><?= htmlspecialchars($casesMeta['title'] ?? '成功案例') ?></h2>
        <div class="timeline">
            <?php foreach ($casesMeta['items'] ?? [] as $case): ?>
                <div class="timeline-item">
                    <div class="timeline-year"><?= htmlspecialchars($case['year'] ?? '') ?></div>
                    <div class="timeline-content">
                        <h3><?= htmlspecialchars($case['title'] ?? '') ?></h3>
                        <p><?= htmlspecialchars($case['description'] ?? '') ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section" id="news">
    <div class="container">
        <h2><?= htmlspecialchars($newsMeta['title'] ?? '新闻动态') ?></h2>
        <div class="news-list">
            <?php foreach ($newsItems as $item): ?>
                <article class="news-item">
                    <?php if (!empty($item['date'])): ?>
                        <time datetime="<?= htmlspecialchars($item['date']) ?>"><?= htmlspecialchars($item['date']) ?></time>
                    <?php endif; ?>
                    <h3><a href="<?= htmlspecialchars($item['url'] ?? '#') ?>"><?= htmlspecialchars($item['title'] ?? '') ?></a></h3>
                    <p><?= htmlspecialchars($item['summary'] ?? '') ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section partners section-alt" id="partners">
    <div class="container">
        <h2><?= htmlspecialchars($page['meta']['partners']['title'] ?? '核心合作伙伴') ?></h2>
        <ul class="partner-list">
            <?php foreach ($partners as $partner): ?>
                <li><?= htmlspecialchars($partner) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>

<section class="section contact" id="contact">
    <div class="container contact-grid">
        <div>
            <h2><?= htmlspecialchars($contactBlock['title'] ?? '联系我们') ?></h2>
            <?php if (!empty($contactBlock['intro'])): ?>
                <p><?= htmlspecialchars($contactBlock['intro']) ?></p>
            <?php endif; ?>
            <ul class="contact-info">
                <li><strong>地址：</strong><?= htmlspecialchars($contactBlock['address'] ?? ($site['contact']['address'] ?? '')) ?></li>
                <li><strong>销售热线：</strong><a href="tel:<?= htmlspecialchars($contactBlock['sales_phone'] ?? $site['contact']['sales_phone'] ?? '') ?>"><?= htmlspecialchars($contactBlock['sales_phone'] ?? $site['contact']['sales_phone'] ?? '') ?></a></li>
                <li><strong>服务热线：</strong><?= htmlspecialchars($contactBlock['service_hotline'] ?? $site['contact']['service_hotline'] ?? '') ?></li>
                <li><strong>商务合作：</strong><a href="mailto:<?= htmlspecialchars($contactBlock['business_email'] ?? $site['contact']['email'] ?? '') ?>"><?= htmlspecialchars($contactBlock['business_email'] ?? $site['contact']['email'] ?? '') ?></a></li>
            </ul>
        </div>
        <div>
            <form class="contact-form" action="<?= htmlspecialchars($contactBlock['form_action'] ?? ('mailto:' . ($site['contact']['email'] ?? ''))) ?>" method="post" enctype="text/plain">
                <div class="form-group">
                    <label for="name">姓名</label>
                    <input id="name" name="name" type="text" required placeholder="请输入您的姓名">
                </div>
                <div class="form-group">
                    <label for="company">单位</label>
                    <input id="company" name="company" type="text" placeholder="请输入您的公司或机构">
                </div>
                <div class="form-group">
                    <label for="phone">联系电话</label>
                    <input id="phone" name="phone" type="tel" required placeholder="方便联系的手机或座机">
                </div>
                <div class="form-group">
                    <label for="message">需求描述</label>
                    <textarea id="message" name="message" rows="4" required placeholder="请简要说明项目背景、需求或预算"></textarea>
                </div>
                <button type="submit" class="btn primary">发送需求</button>
                <?php if (!empty($contactBlock['note'])): ?>
                    <p class="form-tip"><?= htmlspecialchars($contactBlock['note']) ?></p>
                <?php else: ?>
                    <p class="form-tip">提交后将通过默认邮件客户端发送，我们会妥善保护您的信息。</p>
                <?php endif; ?>
            </form>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
