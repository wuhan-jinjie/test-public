# 武汉市劲捷电子信息有限公司静态网站

本仓库提供武汉市劲捷电子信息有限公司（www.027.net）的静态官网源码。内容以 Markdown 维护，使用 PHP 构建脚本自动转换为可部署的 HTML 页面，便于非技术人员更新公司简介、产品方案与新闻动态。

## 功能特性

- **Markdown 内容维护**：`content/` 目录下的 `about-us.md`、`products.md`、`product-1.md`、`news-1.md` 等文件即可直接编辑。
- **PHP 静态化构建**：执行 `php build.php` 自动解析 Markdown、渲染模板并输出到 `dist/` 目录。
- **模块化模板**：`templates/` 目录提供首页、产品详情、新闻列表等模板，统一站点风格。
- **原有样式复用**：保留 `assets/` 下的 CSS/JS，生成页面仍具备响应式展示效果。

## 使用步骤

1. 安装 PHP（版本 ≥ 7.4）。
2. 在项目根目录执行构建：
   ```bash
   php build.php
   ```
3. 在 `dist/` 目录查看生成的静态页面，可直接部署到任意 Web 服务器或对象存储。

## 内容结构

```text
content/
├── index.md              # 首页模块（英雄区、服务、案例、合作伙伴等）
├── about-us.md           # 公司介绍
├── products.md           # 产品/解决方案列表
├── product-1.md          # 产品详情：智慧城市运行中心平台
├── product-2.md          # 产品详情：综合弱电智能化解决方案
├── news.md               # 新闻列表页
├── news-1.md             # 新闻稿：智慧城市重点建设合作伙伴
├── news-2.md             # 新闻稿：运维指挥中心上线
└── contact.md            # 联系我们
```

每个 Markdown 文件开头包含 YAML Front Matter，用于定义页面标题、导航顺序、摘要、列表数据等元信息；正文部分可按 Markdown 语法撰写。

## 模板结构

```text
templates/
├── layout.php        # 全站基础布局（头部、导航、底部）
├── home.php          # 首页模板
├── page.php          # 通用内容页
├── products.php      # 产品列表页
├── product.php       # 产品详情页
├── news-list.php     # 新闻列表页
├── news.php          # 新闻详情页
└── contact.php       # 联系页面
```

模板中可使用 `$page`、`$site`、`$products`、`$news` 等变量，实现内容与布局分离。

## 内置依赖

- [Parsedown](https://github.com/erusev/parsedown)（MIT License）：Markdown 转 HTML。
- [Spyc](https://github.com/mustangostang/spyc)（MIT License）：YAML Front Matter 解析。

## 发布

执行 `php build.php` 后，将 `dist/` 目录与 `assets/` 目录一并上传至服务器即可完成部署。如需自定义域名、SEO 信息或导航结构，可编辑 `config/site.php` 及对应的 Markdown 文件。

欢迎根据业务需求扩展更多页面、组件或数据源。
