<?php echo $header; ?>
<?php echo $menuinner; ?>
<style>
    .sitemap-content {
        padding-top: 75px;
        padding-bottom: 75px;
    }
    .sitemap-cont-inn ul a {
        text-decoration: none;
        color: #000;
    }
    .product-catrgoey>ul.ul-main {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        list-style: none;
        padding: 0;
        gap: 50px;
    }
    .product-catrgoey>ul.ul-main>li>a {
        font-size: 22px;
    }
</style>
<div id="smooth-wrapper">
    <div id="smooth-content">
        <div class="main-container">
            <?php if (!empty($banner)): ?>
                <section>
                    <div class="main-category-banner" style="background: url('<?php echo $banner['image']; ?>');">
                        <div class="container">
                            <div class="cat-banner-inn">
                                <div class="cat-banner-title ab-plasma-title">
                                    <h1><span><?php echo $banner['title']; ?></span></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
            <section>
                <div class="sitemap-content">
                    <div class="container">
                        <div class="sitemap-cont-inn">
                            <div class="web-pages">
                                <?php if (!empty($cmspages)): ?>
                                    <h3><?php echo $text_page; ?></h3>
                                    <ul class="ul-main">
                                        <?php foreach ($cmspages as $page): ?>
                                            <li>
                                                <a href="<?php echo HTTPS_HOST . $page['seo_url']; ?>">
                                                    <?php echo $page['title']; ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                            <div class="product-catrgoey">
                                <?php if (!empty($categories)): ?>
                                    <h3><?=$text_product_categories ?> </h3>
                                    <ul class="ul-main">
                                        <?php
                                        function renderSitemap($categories)
                                        {
                                            foreach ($categories as $cat) {
                                                echo '<li>';
                                                echo '<a href="' . HTTPS_HOST . $cat['seo_url'] . '">' . $cat['title'] . '</a>';

                                                if (!empty($cat['children'])) {
                                                    echo '<ul class="ul-child">';
                                                    renderSitemap($cat['children']);
                                                    echo '</ul>';
                                                }
                                                echo '</li>';
                                            }
                                        }
                                        renderSitemap($categories);
                                        ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php echo $footer; ?>