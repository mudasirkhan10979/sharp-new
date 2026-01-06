<?php echo $header; ?>
<?php echo $menuinner; ?>
<div id="smooth-wrapper">
    <div id="smooth-content">
        <div class="main-container">
            <section>
                <div class="main-category-banner" style="background: url('<?php echo $banner['image']; ?>');">
                    <div class="container">
                        <div class="cat-banner-inn">
                            <div class="cat-banner-title">
                                <h1>
                                    <span><?php echo $banner['title']; ?></span>
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section>
                <div class="category-slider">
                    <div class="container">
                        <div class="cate-slider-title">
                            <h2><?php echo $text_categories; ?></h2>
                        </div>
                    </div>
                    <div class="cate-slider-listing">
                        <div class="cate-slider-list-inn">
                            <?php
                            function renderCategoryItems($categories, $current_parent_id = 0)
                            {
                                foreach ($categories as $category) {
                            ?>
                                    <div class="c-slider-item" data-category-id="<?php echo $category['category_id']; ?>">
                                        <div class="c-slider-item-inn">
                                            <div class="c-slider-img">
                                                  <a href="<?php echo $category['full_url']; ?>"><img src="<?php echo !empty($category['feature_image']) ? BASE_URL . 'uploads/image/categories/' . $category['feature_image'] : (!empty($category['image']) ? BASE_URL . 'uploads/image/categories/' . $category['image'] : BASE_URL . 'uploads/defualt-profile.png'); ?>" alt="<?php echo $category['title']; ?>"></a>
                                            </div>
                                            <div class="c-slider-txt">
                                                <a href="<?php echo $category['full_url']; ?>">
                                                    <?php echo $category['title']; ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                            <?php }
                            }
                            ?>
                            <?php renderCategoryItems($categories, $current_parent_id); ?>
                        </div>
                    </div>
                </div>
            </section>
            <section>
                <div class="feature-category-list">
                    <div class="container">
                        <div class="feature-category-list-inn" id="featured-products-container">
                            <?php if (!empty($featured_products)) { ?>
                                <?php foreach ($featured_products as $product) {
                                    $imageName = !empty($product['image']) ? rawurlencode($product['image']) : '';
                                    $imagePath = !empty($product['image'])
                                        ? BASE_URL . 'uploads/image/product/' . $imageName
                                        : BASE_URL . 'uploads/default_banner.jpg'; ?>
                                    <div class="feature-cate-item" style="background: url(<?php echo $imagePath; ?>);">
                                        <div class="feature-cate-item-inn">
                                            <div class="feature-c-item-text">
                                                <span class="m-p-label"><?php echo $text_featured_products; ?></span>
                                                <h3><?php echo $product['name']; ?></h3>
                                                <!-- <p><?php echo $product['model']; ?></p> -->
                                                <div class="m-p-link">
                                                    <a href="<?php echo $product['url']; ?>">
                                                        <span class="dw-btn"><?php echo $text_learn_more; ?></span>
                                                        <span><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <div class="col-12 text-center">
                                    <p><?php echo $text_no_record; ?></p>
                                </div>
                            <?php } ?>
                        </div>
                        <?php if ($load_more_has_more) { ?>
                            <div class="load-more-section text-center mt-4 mb-5">
                                <button type="button" id="load-more-btn" class="btn-default"
                                    data-category-id="<?php echo $load_more_category_id; ?>"
                                    data-offset="<?php echo $load_more_offset; ?>"
                                    data-total="<?php echo $load_more_total; ?>">
                                    <span class="dw-btn"> <?php echo $text_load_more; ?></span> <span><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span>
                                </button>
                                <div id="load-more-loading" class="mt-2" style="display: none;">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only"><?php echo $text_loading; ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php } else if (!empty($featured_products)) { ?>
                            <div class="text-center mt-4">
                                <p class="text-muted"><?php echo $text_no_more_products; ?></p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </section>
            <script>
                $(document).ready(function() {
                    function loadMoreHandler() {
                        var $btn = $(this);
                        var categoryId = $btn.data('category-id');
                        var offset = $btn.data('offset');
                        $btn.hide();
                        $('#load-more-loading').show();
                        $.ajax({
                            url: '<?php echo HTTPS_HOST; ?>maincategory/getCategoryProducts',
                            type: 'get',
                            data: {
                                category_id: categoryId,
                                offset: offset
                            },
                            dataType: 'json',
                            success: function(json) {
                                if (json.success && json.products && json.products.length > 0) {
                                    var html = '';
                                    json.products.forEach(function(product) {
                                        html += `
                                    <div class="feature-cate-item" style="background: url(${product.image});">
                                        <div class="feature-cate-item-inn">
                                            <div class="feature-c-item-text">
                                                <span class="m-p-label"><?php echo $text_featured_products; ?></span>
                                                <h3>${product.name}</h3>
                                                <div class="m-p-link">
                                                    <a href="${product.url}">
                                                        <span class="dw-btn"><?php echo $text_learn_more; ?></span>
                                                        <span><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;
                                    });
                                    $('#featured-products-container').append(html);
                                    $btn.data('offset', json.offset);
                                    if (json.has_more) {
                                        $btn.show();
                                    } else {
                                        $btn.remove();
                                        $('#load-more-loading').after('<div class="text-center mt-4"><p class="text-muted"><?php echo $text_no_more_products; ?></p></div>');
                                    }
                                } else {
                                    $btn.remove();
                                    $('#load-more-loading').after('<div class="text-center mt-4"><p class="text-muted"><?php echo $text_no_more_products; ?></p></div>');
                                }

                                $('#load-more-loading').hide();
                            },
                            error: function(xhr, status, error) {
                                $('#load-more-loading').hide();
                                $btn.show();
                                console.error('Load More Error:', error);
                                alert('Error loading more products. Please try again.');
                            }
                        });
                    }
                    function getCategoryProducts(category_id) {
                        $('#featured-products-container').html('<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>');
                        $('.load-more-section').remove();
                        $('.text-center.mt-4').remove();
                        $.ajax({
                            url: '<?php echo HTTPS_HOST; ?>maincategory/getCategoryProducts',
                            type: 'get',
                            data: {
                                category_id: category_id,
                                offset: 0
                            },
                            dataType: 'json',
                            success: function(json) {
                                if (json.success && json.products && json.products.length > 0) {
                                    let html = '';
                                    json.products.forEach(function(product) {
                                        html += `
                                    <div class="feature-cate-item" style="background: url(${product.image});">
                                        <div class="feature-cate-item-inn">
                                            <div class="feature-c-item-text">
                                                <span class="m-p-label"><?php echo $text_featured_products; ?></span>
                                                <h3>${product.name}</h3>
                                                <div class="m-p-link">
                                                    <a href="${product.url}">
                                                        <span class="dw-btn"><?php echo $text_learn_more; ?></span>
                                                        <span><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;
                                    });
                                    $('#featured-products-container').html(html);
                                    if (json.has_more) {
                                        const loadMoreHtml = `
                                    <div class="load-more-section text-center mt-4">
                                        <button type="button" id="load-more-btn" class="btn-default" 
                                                data-category-id="${category_id}"
                                                data-offset="${json.offset}"
                                                data-total="${json.total}">
                                            <span class="dw-btn"><?php echo $text_load_more; ?></span>
                                            <span><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span>
                                        </button>
                                        <div id="load-more-loading" class="mt-2" style="display: none;">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="sr-only"><?php echo $text_loading; ?></span>
                                            </div>
                                        </div>
                                    </div>`;
                                        $('#featured-products-container').after(loadMoreHtml);
                                        $('#load-more-btn').on('click', loadMoreHandler);
                                    } else {
                                        if (json.loaded_count < 3) {
                                            $('#featured-products-container').after('<div class="text-center mt-4"><p class="text-muted"><?php echo $text_no_more_products; ?></p></div>');
                                        }
                                    }
                                } else {
                                    $('#featured-products-container').html('<div class="col-12 text-center"><p><?php echo $text_no_featured_products; ?></p></div>');
                                }
                            },
                            error: function(xhr, status, error) {
                                $('#featured-products-container').html('<div class="col-12 text-center"><p>Error loading products. Please try again.</p></div>');
                                console.error('Category Products Error:', error);
                            }
                        });
                    }
                    $(document).on('click', '#load-more-btn', loadMoreHandler);
                    $('.c-slider-item').on('click', function() {
                        const categoryId = $(this).data('category-id');
                        getCategoryProducts(categoryId);
                    });
                });
            </script>
            <?php echo $footer; ?>