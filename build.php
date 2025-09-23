<?php
error_reporting(E_ALL & ~E_DEPRECATED);
require __DIR__ . '/lib/Parsedown.php';
require __DIR__ . '/lib/Spyc.php';

$site = require __DIR__ . '/config/site.php';
$contentDir = __DIR__ . '/content';
$outputDir = __DIR__ . '/dist';
$templateDir = __DIR__ . '/templates';

if (!is_dir($outputDir)) {
    mkdir($outputDir, 0777, true);
}

cleanDirectory($outputDir);
$documents = loadDocuments($contentDir, $site['base_url'] ?? '');
$navTree = buildNavigation($documents, $site['base_url'] ?? '');

$context = [
    'site' => $site,
    'nav' => $navTree,
    'documents' => $documents,
];

foreach ($documents as $doc) {
    renderDocument($doc, $context, $templateDir, $outputDir);
}

copyAssets(__DIR__ . '/assets', $outputDir . '/assets');

printf("已生成 %d 个页面到 %s\n", count($documents), $outputDir);

// ----------------------

function cleanDirectory(string $dir): void
{
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );

    foreach ($iterator as $item) {
        if ($item->isDir()) {
            rmdir($item->getPathname());
        } else {
            unlink($item->getPathname());
        }
    }
}

function loadDocuments(string $contentDir, string $baseUrl): array
{
    $documents = [];
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($contentDir, FilesystemIterator::SKIP_DOTS)
    );

    foreach ($iterator as $file) {
        if ($file->getExtension() !== 'md') {
            continue;
        }
        $documents[] = parseDocument($file->getPathname(), $contentDir, $baseUrl);
    }

    usort($documents, static function (array $a, array $b) {
        return ($a['meta']['nav']['order'] ?? 0) <=> ($b['meta']['nav']['order'] ?? 0);
    });

    return $documents;
}

function parseDocument(string $path, string $contentDir, string $baseUrl): array
{
    $raw = file_get_contents($path);
    if ($raw === false) {
        throw new RuntimeException("无法读取文件: {$path}");
    }

    $meta = [];
    $body = $raw;

    if (preg_match('/^---\n(.*?)\n---\n(.*)$/s', $raw, $matches)) {
        $meta = Spyc::YAMLLoadString($matches[1]) ?? [];
        $body = $matches[2];
    }

    $parsedown = new Parsedown();
    $html = $parsedown->text(trim($body));

    $slug = trim(str_replace($contentDir, '', $path), DIRECTORY_SEPARATOR);
    $slug = preg_replace('/\.md$/', '', $slug);

    $permalink = $meta['permalink'] ?? ($slug . '.html');
    $permalink = trim($permalink);
    if ($permalink === '' || $permalink === '/') {
        $permalink = 'index.html';
    }
    $permalink = ltrim($permalink, '/');

    $outputPath = $permalink;
    $url = rtrim($baseUrl, '/') . '/' . ($permalink === 'index.html' ? '' : $permalink);
    if ($url === '') {
        $url = '/';
    }

    $excerpt = $meta['summary'] ?? createExcerpt($html);

    return [
        'source' => $path,
        'slug' => $slug,
        'meta' => $meta,
        'body' => $body,
        'html' => $html,
        'permalink' => $permalink,
        'output' => $outputPath,
        'url' => $url === '/' ? '/' : preg_replace('#//+#', '/', $url),
        'excerpt' => $excerpt,
    ];
}

function createExcerpt(string $html, int $length = 160): string
{
    $text = trim(strip_tags($html));
    if (mb_strlen($text, 'UTF-8') <= $length) {
        return $text;
    }
    return mb_substr($text, 0, $length, 'UTF-8') . '…';
}

function buildNavigation(array $documents, string $baseUrl): array
{
    $navItems = [];
    foreach ($documents as $doc) {
        if (!isset($doc['meta']['nav'])) {
            continue;
        }
        $nav = $doc['meta']['nav'];
        $key = $nav['key'] ?? $doc['slug'];
        $navItems[$key] = [
            'key' => $key,
            'label' => $nav['label'] ?? ($doc['meta']['title'] ?? $key),
            'order' => $nav['order'] ?? 0,
            'parent' => $nav['parent'] ?? null,
            'show_in_header' => $nav['show_in_header'] ?? true,
            'url' => $doc['url'],
        ];
    }

    uasort($navItems, static function ($a, $b) {
        return $a['order'] <=> $b['order'];
    });

    $tree = [];
    foreach ($navItems as $key => $item) {
        if ($item['parent']) {
            continue;
        }
        $tree[$key] = $item + ['children' => []];
    }

    foreach ($navItems as $item) {
        if (!$item['parent']) {
            continue;
        }
        if (!isset($tree[$item['parent']])) {
            // 如果父节点不存在，则作为顶级节点处理
            $tree[$item['key']] = $item + ['children' => []];
            continue;
        }
        $tree[$item['parent']]['children'][] = $item + ['children' => []];
    }

    foreach ($tree as &$node) {
        if (empty($node['children'])) {
            continue;
        }
        usort($node['children'], static function ($a, $b) {
            return $a['order'] <=> $b['order'];
        });
    }
    unset($node);

    return $tree;
}

function renderDocument(array $doc, array $context, string $templateDir, string $outputDir): void
{
    $layout = $doc['meta']['layout'] ?? 'page';
    $templatePath = $templateDir . '/' . $layout . '.php';
    if (!file_exists($templatePath)) {
        $templatePath = $templateDir . '/page.php';
    }

    $pageContext = $context;
    $pageContext['page'] = $doc;
    $pageContext['content'] = $doc['html'];
    $pageContext['nav'] = markActiveNavigation($context['nav'], $doc['url']);
    $pageContext['products'] = filterDocumentsByLayout($context['documents'], 'product');
    $pageContext['news'] = filterDocumentsByLayout($context['documents'], 'news');

    $rendered = renderTemplate($templatePath, $pageContext);

    $outputPath = $outputDir . '/' . $doc['output'];
    $outputDirname = dirname($outputPath);
    if (!is_dir($outputDirname)) {
        mkdir($outputDirname, 0777, true);
    }

    file_put_contents($outputPath, $rendered);
}

function filterDocumentsByLayout(array $documents, string $layout): array
{
    $filtered = array_filter($documents, static function ($doc) use ($layout) {
        return ($doc['meta']['layout'] ?? 'page') === $layout;
    });

    usort($filtered, static function ($a, $b) {
        return ($a['meta']['nav']['order'] ?? 0) <=> ($b['meta']['nav']['order'] ?? 0);
    });

    return array_values($filtered);
}

function markActiveNavigation(array $navTree, string $currentUrl): array
{
    foreach ($navTree as &$item) {
        $item['active'] = rtrim($item['url'], '/') === rtrim($currentUrl, '/');
        if (!empty($item['children'])) {
            $item['children'] = markActiveNavigation($item['children'], $currentUrl);
            foreach ($item['children'] as $child) {
                if (!empty($child['active'])) {
                    $item['active'] = true;
                    break;
                }
            }
        }
    }
    unset($item);

    return $navTree;
}

function renderTemplate(string $templatePath, array $data): string
{
    extract($data, EXTR_SKIP);
    ob_start();
    include $templatePath;
    return ob_get_clean();
}

function copyAssets(string $source, string $destination): void
{
    if (!is_dir($source)) {
        return;
    }
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($source, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($iterator as $item) {
        $targetPath = $destination . substr($item->getPathname(), strlen($source));
        if ($item->isDir()) {
            if (!is_dir($targetPath)) {
                mkdir($targetPath, 0777, true);
            }
        } else {
            $dir = dirname($targetPath);
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            copy($item->getPathname(), $targetPath);
        }
    }
}
