<?php echo $header; ?>
<?php echo $menuinner; ?>
<div id="smooth-wrapper">
    <div id="smooth-content">
        <div class="main-container">
            <section class="pro-list-slider">
                <div class="pro-slider-top">
                    <div class="container">
                        <a class="default-back listing-back"
                            href="<?php echo !empty($parentCategory['url']) ? HTTPS_HOST . $parentCategory['url'] : '/'; ?>">
                            <img src="<?php echo BASE_URL; ?>themes/sharp/assets/images/arrow-link.svg"
                                alt="" /><?php echo $text_back;?>
                        </a>
                        <h1><?php echo $banner['title']; ?></h1>
                    </div>
                </div>
                <?php if (!empty($categories_top)) : ?>
                <div class="container-fluid">
                    <div class="row">
                        <div class="listing-slider-wrap bottom-space">
                            <div class="owl-carousel owl-theme" id="pro-listing-slider">
                                <?php foreach ($categories_top as $category) { ?>
                                <div class="pro-slider-img-wrap">
                                    <div class="pro-slider-img img-animate">
                                        <img src="<?php echo !empty($category['image']) ? BASE_URL . 'uploads/image/categories/' . $category['image'] : BASE_URL . 'uploads/defualt-profile.png'; ?>"
                                            alt="<?php echo $category['title']; ?>">
                                    </div>
                                    <div class="pro-slider-desc">
                                        <h2><a
                                                href="<?php echo HTTPS_HOST . $category['parent_seo_url'] . '/' . $category['seo_url']; ?>"><?php echo $category['title']; ?></a>
                                        </h2>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </section>
         <?php if (!empty($filters['grouped_attributes'])): ?>
            <section class="filter-sec">
                <div class="container">

                        <h2><?php echo $heading_filter; ?></h2>
                   <?php endif; ?>
                    <form id="filter-form" method="GET" action="<?php echo HTTP_HOST . $slugData['url']; ?>">
                        <div class="filter-wrap">
                            <?php
                            if (!empty($filters['grouped_attributes'])) {
                                usort($filters['grouped_attributes'], function ($a, $b) {
                                    if (isset($a['sort_order']) && isset($b['sort_order'])) {
                                        return $a['sort_order'] <=> $b['sort_order'];
                                    }
                                    return strcmp($a['attribute_title'], $b['attribute_title']);
                                });
                                foreach ($filters['grouped_attributes'] as $attribute) { ?>
                            <select name="attribute[<?php echo $attribute['attribute_id']; ?>]"
                                id="attribute_<?php echo $attribute['attribute_id']; ?>" class="filter-select">
                                <option value="">
                                    <?php echo $attribute['attribute_title']; ?>
                                </option>
                                <?php if (!empty($attribute['values'])) { ?>
                                <?php foreach ($attribute['values'] as $value) { ?>
                                <option value="<?php echo $value['value_id']; ?>"
                                    <?php echo (!empty($filter_data['attribute'][$attribute['attribute_id']]) && $filter_data['attribute'][$attribute['attribute_id']] == $value['value_id']) ? 'selected' : ''; ?>>
                                    <?php echo $value['value_title']; ?>
                                </option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                            <?php }
                            } ?>
                        </div>

                        <input type="hidden" name="sort"
                            value="<?php echo !empty($filter_data['sort']) ? $filter_data['sort'] : 'newest'; ?>">
                    </form>
                </div>
            </section>
            <section class="listing-sec">
                <div class="container">
                    <div class="listing-top">
                        <label class="results"><?php echo $product_total; ?> <?php echo $text_results; ?></label>
                        <div class="sort-wrap">
                            <label><?php echo $text_sort_by;?>: </label>
                            <select name="sort" id="filter-sort">
                                <option value="newest"
                                    <?php echo (!empty($filter_data['sort']) && $filter_data['sort'] == 'newest') ? 'selected' : ''; ?>>
                                    <?php echo $text_new; ?></option>
                                <option value="oldest"
                                    <?php echo (!empty($filter_data['sort']) && $filter_data['sort'] == 'oldest') ? 'selected' : ''; ?>>
                                    <?php echo $text_old; ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="listing-item-sec">
                        <div class="row">
                            <?php if (!empty($products)) { ?>
                            <?php foreach ($products as $product) { ?>
                            <div class="col-md-4">
                                <div class="list-item-wrap">
                                    <div class="list-item-img img-animate">
                                        <?php if(isset($product['is_new']) && $product['is_new'] == '1'): ?>
                                            <div class="ribbon ribbon-top-left"><span><?php echo $text_text_new; ?></span></div>
                                        <?php endif; ?>
                                        <!-- <img src="<?php echo !empty($product['image']) ? BASE_URL . 'uploads/image/product/' . $product['image'] : BASE_URL . 'uploads/defualt-profile.png'; ?>"
                                            alt="<?php echo $product['name']; ?>" /> -->
                                            <a href="<?php echo HTTPS_HOST . 'product/' . $product['seo_url']; ?>">
                                            <img src="<?php echo !empty($product['image']) ? BASE_URL . 'uploads/image/product/' . $product['image'] : BASE_URL . 'uploads/defualt-profile.png'; ?>"
                                                alt="<?php echo $product['name']; ?>" />
                                        </a>
                                    </div>
                                    <div class="list-item-desc">
                                        <h2><a href="<?php echo HTTPS_HOST . 'product/' . $product['seo_url']; ?>"><?php echo $product['name']; ?></a></h2>
                                        <div class="list-desc-wrap">
                                            <?php echo html_entity_decode($product['short_description']); ?>
                                        </div>
                                        <a class="btn-default"
                                            href="<?php echo HTTPS_HOST . 'product/' . $product['seo_url']; ?>">
                                            <?php echo $text_learn_more; ?> <span><img
                                                    src="<?php echo BASE_URL; ?>themes/sharp/assets/images/btn-icon.svg"
                                                    alt=""></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <?php } else { ?>
                            <div class="col-12">
                                <div class="alert alert-warning text-center no-record">
                                    <?php echo $text_no_more_products; ?>
                                </div>
                            </div>
                            <?php } ?>
                        </div>

                        <?php if ($pagination) { ?>
                        <div class="pagination-default">
                            <?php echo $pagination; ?>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </section>
            <?php echo $footer; ?>
            <script>
            $(document).ready(function() {
                $('select').change(function() {
                    if ($(this).attr('id') === 'filter-sort') {
                        $('input[name="sort"]').val($(this).val());
                    }
                    $('#filter-form').submit();
                });
                $('.pagination-default a').on('click', function(e) {
                    e.preventDefault();
                    const url = $(this).attr('href');
                    const pageMatch = url.match(/page=(\d+)/);
                    const page = pageMatch ? pageMatch[1] : 1;
                    $('#filter-form input[name="page"]').remove();
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'page',
                        value: page
                    }).appendTo('#filter-form');

                    $('#filter-form').submit();
                });
            });
            </script>