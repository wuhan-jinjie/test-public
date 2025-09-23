<?php
$contactInfo = array_merge($site['contact'] ?? [], $page['meta']['contact'] ?? []);
ob_start();
?>
<section class="section contact">
    <div class="container contact-grid">
        <div>
            <h1><?= htmlspecialchars($page['meta']['title'] ?? '联系我们') ?></h1>
            <?php if (!empty($page['meta']['intro'])): ?>
                <p class="section-intro"><?= htmlspecialchars($page['meta']['intro']) ?></p>
            <?php endif; ?>
            <ul class="contact-info">
                <li><strong>地址：</strong><?= htmlspecialchars($contactInfo['address'] ?? '') ?></li>
                <li><strong>销售热线：</strong><a href="tel:<?= htmlspecialchars($contactInfo['sales_phone'] ?? '') ?>"><?= htmlspecialchars($contactInfo['sales_phone'] ?? '') ?></a></li>
                <li><strong>服务热线：</strong><?= htmlspecialchars($contactInfo['service_hotline'] ?? '') ?></li>
                <li><strong>商务邮箱：</strong><a href="mailto:<?= htmlspecialchars($contactInfo['email'] ?? '') ?>"><?= htmlspecialchars($contactInfo['email'] ?? '') ?></a></li>
            </ul>
        </div>
        <div>
            <form class="contact-form" action="<?= htmlspecialchars($contactInfo['form_action'] ?? ('mailto:' . ($contactInfo['email'] ?? ''))) ?>" method="post" enctype="text/plain">
                <div class="form-group">
                    <label for="contact-name">姓名</label>
                    <input id="contact-name" name="name" type="text" required placeholder="请输入您的姓名">
                </div>
                <div class="form-group">
                    <label for="contact-company">单位</label>
                    <input id="contact-company" name="company" type="text" placeholder="请输入您的公司或机构">
                </div>
                <div class="form-group">
                    <label for="contact-phone">联系电话</label>
                    <input id="contact-phone" name="phone" type="tel" required placeholder="方便联系的手机或座机">
                </div>
                <div class="form-group">
                    <label for="contact-message">需求描述</label>
                    <textarea id="contact-message" name="message" rows="4" required placeholder="请简要说明项目背景、需求或预算"></textarea>
                </div>
                <button type="submit" class="btn primary">发送需求</button>
                <p class="form-tip">提交后将通过默认邮件客户端发送，我们会妥善保护您的信息。</p>
            </form>
        </div>
    </div>
</section>
<section class="section section-alt">
    <div class="container page-body">
        <?= $content ?>
    </div>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
