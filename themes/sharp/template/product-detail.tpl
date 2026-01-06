<?php echo $header; ?>
<?php echo $menuinner; ?>
<style>
.detail-shopslider {
    padding: 0 !important;
}

.detail-shopslider .slick-slide {
    height: 100% !important;
}

.detail-shopslider .slick-list,
.detail-shopslider .slick-track {
    height: 100% !important;
}

.detail-banner-img img {
    width: 100% !important;
    height: 100% !important;
}

.detail-banner-img {
    text-align: center !important;
}
</style>
<style>
.detail-shopslider {
    padding: 0;
}

.detail-shopslider .slick-slide {
    height: 100%;
}

.detail-shopslider .slick-list,
.detail-shopslider .slick-track {
    height: 100%;
}

.single-detail-top {
    justify-content: space-between;
}

.modal.show#videoModal .modal-dialog {
    transform: translate(0, 0px);
    max-width: 80%;
    height: 80%;
}

#videoModal .modal-content,
#videoModal .inquire-now-form,
#videoModal .row,
#videoModal .col-md-12,
#videoModal iframe {
    height: 100%;
    width: 100%;
    background: transparent;
    padding: 0;
}

#videoModal button.btn-close {
    position: absolute;
    top: -12px !important;
    right: -35px !important;
    filter: brightness(0) saturate(100%) invert(100%) sepia(96%) saturate(12%) hue-rotate(211deg) brightness(104%) contrast(100%);
    opacity: 1;

}

#videoModal .modal-content .modal-body {
    padding: 0;
}

section.detail-banner {
    position: relative;
}

section.detail-banner .play-btn {
    position: absolute;
    top: 50%;
    left: 50%;
    z-index: 22;
    transform: translate(-50%, -50%);
}
</style>

<div id="smooth-wrapper">
    <div id="smooth-content">
        <div class="main-container">
            <section class="detail-shop-slider default-sec">
                <div class="container">
                    <div class="detail-hyper">
                        <a class="default-back detail-back"
                            href="<?php echo HTTPS_HOST . $productDetails['category_url']; ?>"><?php echo $productDetails['category_name']; ?></a>
                        <span class="default-back detail-back"><?php echo $productDetails['product_name']; ?></span>

                    </div>
                    <div class="row">
                        <?php if (!empty($images_by_color)): ?>
                        <div class="col-md-6">
                            <div class="detail-slider-wrap">
                                <div class="detail-shopslider">
                                    <div class="detail-main-image">
                                        <?php
                                            $first_color = $available_colors[0];
                                            $first_image = !empty($images_by_color[$first_color][0]['image'])
                                                ? $images_by_color[$first_color][0]['image']
                                                : '';
                                            ?>
                                        <img id="mainProductImage"
                                            src="<?php echo BASE_URL . 'uploads/image/product/' . $first_image; ?>"
                                            data-color="<?php echo htmlspecialchars($first_color); ?>"
                                            alt="Main Product Image">
                                    </div>
                                </div>
                                <div class="detail-shopslider-thumbnails">
                                    <?php foreach ($images_by_color as $color => $images): ?>
                                    <?php
                                            $safe_color = !empty($color) ? htmlspecialchars($color) : 'no_color';
                                            ?>
                                    <?php foreach ($images as $index => $img): ?>
                                    <div class="shop-thumbitem" data-color="<?php echo $safe_color; ?>">
                                        <img loading="lazy"
                                            src="<?php echo BASE_URL . 'uploads/image/product/' . $img['image']; ?>"
                                            alt="Thumbnail <?php echo $index + 1; ?><?php echo $color ? ' - ' . ucfirst($color) : ''; ?>">
                                    </div>
                                    <?php endforeach; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="col-md-6">
                            <div class="single-detail-sec">
                                <div class="single-detail-top">
                                    <?php if (!empty($productDetails['product_serial_number'])): ?>
                                    <span
                                        class="product-no"><?php echo $productDetails['product_serial_number']; ?></span>
                                    <?php endif; ?>
                                    <?php if (!empty($productDetails['product_tags'])): ?>
                                    <label class="detail-cat">
                                        <?php echo str_replace(',', ', ', $productDetails['product_tags']); ?>
                                    </label>
                                    <?php endif; ?>
                                </div>
                                <h1><?php echo $productDetails['product_name']; ?></h1>
                                <?php if (!empty($available_colors) && !empty($images_by_color)): ?>
                                <div class="pro-select-color">
                                    <div class="pro-slt-clr-inn">
                                        <?php if (count($available_colors) > 0): ?>
                                        <ul>
                                            <?php foreach ($available_colors as $index => $color): ?>
                                            <?php if (!empty($color)): ?>
                                            <li>
                                                <input type="radio" name="color"
                                                    value="<?php echo htmlspecialchars($color); ?>"
                                                    <?php echo $index === 0 ? 'checked' : ''; ?>>
                                                <span class="p-item-color"
                                                    style="background-color: <?php echo htmlspecialchars($color); ?>; border: 1px solid #000;">
                                                </span>
                                            </li>
                                            <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <div class="details-multiselect">
                                    <div class="">
                                        <?php echo $productDetails['full_description']; ?>
                                    </div>
                                </div>
                                <a class="btn-default" data-bs-toggle="modal"
                                    data-bs-target="#inquireModal"><?php echo $text_inquire; ?>
                                    <span><img src="<?php echo BASE_URL; ?>themes/sharp/assets/images/btn-icon.svg"
                                            alt=""></span></a>
                                <div class="social-share"><img
                                        src="<?php echo BASE_URL; ?>themes/sharp/assets/images/share-icon.svg"
                                        alt="Share"><label><?php echo $text_only_share; ?></label>
                                    <?php if (!empty($share_links['facebook'])): ?>
                                    <a class="share-button" data-share-url="" data-share-network="facebook"
                                        data-share-text="" data-share-title="Facebook Share" data-share-via=""
                                        data-share-tags="" data-share-media=""
                                        href="<?php echo $share_links['facebook']; ?>" target="_blank"><i
                                            class="fa fa-facebook"></i></a>
                                    <?php endif; ?>
                                    <?php if (!empty($share_links['twitter'])): ?>
                                    <a class="share-button" data-share-url="" data-share-network="twitter"
                                        data-share-text="" data-share-title="Twitter Share" data-share-via=""
                                        data-share-tags="" data-share-media=""
                                        href="<?php echo $share_links['twitter']; ?>" target="_blank"><i
                                            class="fa fa-twitter"></i></a>
                                    <?php endif; ?>
                                    <?php if (!empty($share_links['instagram'])): ?>
                                    <a class="share-button" data-share-url="" data-share-network="instagram"
                                        data-share-text="" data-share-title="Instagram Share" data-share-via=""
                                        data-share-tags="" data-share-media=""
                                        href="<?php echo $share_links['instagram']; ?>" target="_blank"><i
                                            class="fa fa-instagram"></i></a>
                                    <?php endif; ?>
                                    <?php if (!empty($share_links['youtube'])): ?>
                                    <a class="share-button" data-share-url="" data-share-network="youtube"
                                        data-share-text="" data-share-title="Youtube Share" data-share-via=""
                                        data-share-tags="" data-share-media=""
                                        href="<?php echo $share_links['youtube']; ?>" target="_blank"><i
                                            class="fa fa-youtube-play"></i></a>
                                    <?php endif; ?>
                                    <?php if (!empty($share_links['whatsapp'])): ?>
                                    <a class="share-button" data-share-url="" data-share-network="whatsapp"
                                        data-share-text="" data-share-title="Whatsapp Share" data-share-via=""
                                        data-share-tags="" data-share-media=""
                                        href="<?php echo $share_links['whatsapp']; ?>" target="_blank"><i
                                            class="fa fa-whatsapp"></i></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </section>
        <?php if (!empty($product_features)): ?>
        <section class="detail-features-sec top-space default-sec">
            <div class="container">
                <div class="detail-fea-wrap">
                    <h2><?php echo $text_features; ?></h2>
                    <div class="detail-fea-inner owl-carousel">
                        <?php foreach ($product_features as $feature) { ?>
                        <div class="detail-fea-item">
                            <div class="detail-fea-img">
                             <?php if(isset($product['is_new']) && $product['is_new'] == '1'): ?>
                                <div class="ribbon ribbon-top-left"><span><?php echo $text_text_new; ?></span></div>
                                <?php endif; ?>
                                <img src="<?php echo BASE_URL . 'uploads/image/product/' . $feature['image']; ?>"
                                    alt="<?php echo !empty($feature['title']) ? $feature['title'] : 'Feature'; ?>" />
                            </div>
                            <div class="detail-fea-content">
                                <h4><?php echo $feature['title']; ?></h4>
                                <div class="detail-desc">
                                    <?php echo $feature['content']; ?>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>
        <?php if ($productDetails['thumbnail_image'] != ''): ?>
        <section class="detail-banner top-space default-sec">
            <div class="container">
                <div class="detail-banner-img img-animate">
                    <img src="<?php echo $productDetails['thumbnail_image']; ?>" alt="detail banner" />
                </div>
                <?php if (!empty($productDetails['video_url'])): ?>
                <?php
                        preg_match('/(?:v=|\.be\/)([a-zA-Z0-9_-]+)/', $productDetails['video_url'], $matches);
                        $video_id = $matches[1] ?? '';
                        $embed_url = 'https://www.youtube.com/embed/' . $video_id . '?showinfo=0&playlist=' . $video_id . '&loop=0&autoplay=1&controls=1&mute=1';
                        ?>
                <div class="play-btn">
                    <a href="#" class="btn-default" data-bs-toggle="modal" data-bs-target="#videoModal">
                        <?php echo $text_play;?> <span><img
                                src="https://sharp.nexatestwp.com/themes/sharp/assets/imgs/arrow.svg" alt=""></span>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </section>
        <?php endif; ?>

        <?php if (!empty($product_benefits)): ?>
        <section class="benefits-sec top-space default-sec">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="benefit-content">
                            <h2><?php echo $text_benefits; ?></h2>
                            <?php if (!empty($benefits_description)): ?>
                            <div class="benefit-desc">
                                <?php echo $benefits_description; ?>
                            </div>
                            <?php endif; ?>
                            <?php
                                $benefits_chunks = array_chunk($product_benefits, 2);
                                ?>
                            <?php if (count($benefits_chunks) > 1): ?>
                            <div class="benefit-item-list">
                                <?php foreach ($benefits_chunks as $chunk): ?>
                                <div class="benefit-item-wrap">
                                    <div class="row">
                                        <?php foreach ($chunk as $benefit): ?>
                                        <div class="col-md-6">
                                            <div class="benefit-item">
                                                <?php if (!empty($benefit['image'])): ?>
                                                <div class="benefit-icon">
                                                    <img src="<?php echo BASE_URL . 'uploads/image/product/' . $benefit['image']; ?>"
                                                        alt="<?php echo htmlspecialchars($benefit['title']); ?>" />
                                                </div>
                                                <?php endif; ?>

                                                <div class="benefit-item-desc">
                                                    <h6><?php echo $benefit['title']; ?></h6>
                                                    <p><?php echo $benefit['content']; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <?php else: ?>
                            <div class="benefit-item-wrap">
                                <div class="row">
                                    <?php foreach ($product_benefits as $benefit): ?>
                                    <div class="col-md-6">
                                        <div class="benefit-item">
                                            <?php if (!empty($benefit['image'])): ?>
                                            <div class="benefit-icon">
                                                <img src="<?php echo BASE_URL . 'uploads/image/product/' . $benefit['image']; ?>"
                                                    alt="<?php echo htmlspecialchars($benefit['title']); ?>" />
                                            </div>
                                            <?php endif; ?>
                                            <h6><?php echo $benefit['title']; ?></h6>
                                            <div class="benefit-item-desc">
                                                <?php echo $benefit['content']; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>
        <?php if (!empty($source_codes)): ?>
        <section class="download-res-sec top-space default-sec">
            <div class="container">
                <div class="download-res-inner">
                    <div class="download-res-top">
                        <h2><?php echo $text_download_resources; ?></h2>
                        <!-- <a class="btn-default" href="<?php echo HTTPS_HOST . 'user-manuals'; ?>"><span
                                class="dw-btn"><?php echo $text_explore; ?></span> <span><img
                                    src="<?php echo BASE_URL; ?>themes/sharp/assets/images/btn-icon.svg"
                                    alt=""></span></a> -->
                    </div>
                    <div class="download-res-wrap">
                        <div class="row">
                            <?php foreach ($source_codes as $source_code): ?>
                            <div class="col-md-4">
                                <div class="download-res-item">
                                    <div class="download-img">
                                        <img src="<?php echo BASE_URL; ?>themes/sharp/assets/images/pdf-icon.svg"
                                            alt="download" />
                                    </div>
                                    <div class="download-desc">
                                        <h4><?php echo $source_code['title']; ?></h4>
                                        <!-- <label><?php echo date('Y-m-d', strtotime($source_code['added_date'])); ?></label> -->
                                    </div>
                                    <?php if (!empty($source_code['file'])): ?>
                                    <div class="download-btn">
                                        <a class="btn-default"
                                            href="<?php echo BASE_URL . 'uploads/image/source_code_files/' . $source_code['file']; ?>"
                                            target="_blank">
                                            <span class="dw-btn"><?php echo $text_download; ?></span>
                                            <span><img
                                                    src="<?php echo BASE_URL; ?>themes/sharp/assets/images/btn-icon.svg"
                                                    alt=""></span>
                                        </a>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>
        <?php if (!empty($relatedproducts)): ?>
        <section class="similar-pro-sec top-space default-sec">
            <div class="container">
                <h2><?php echo $text_similar_products; ?></h2>
                <div class="similar-pro-wrap">
                    <div class="owl-carousel owl-theme" id="similar-pro-slider">
                        <?php foreach ($relatedproducts as $related): ?>
                        <div class="list-item-wrap">
                            <div class="list-item-img img-animate">
                             <?php if(isset($product['is_new']) && $product['is_new'] == '1'): ?>
                                <div class="ribbon ribbon-top-left"><span><?php echo $text_text_new; ?></span></div>
                              <?php endif; ?>
                                <img src="<?php echo $related['image']; ?>" alt="" />
                            </div>
                            <div class="list-item-desc">
                                <h3><?php echo $related['name']; ?></h3>
                                <div class="list-desc-wrap">
                                    <?php echo $related['short_description']; ?>
                                </div>
                                <a class="btn-default"
                                    href="<?php echo $related['href']; ?>"><?php echo $text_learn_more; ?> <span><img
                                            src="<?php echo BASE_URL; ?>themes/sharp/assets/images/btn-icon.svg"
                                            alt=""></span></a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>
        <section class="support-sec top-space bottom-space default-sec">
            <div class="container">
                <?php if (!empty($blocksupportservice)): ?>
                <div class="support-top">
                    <h2><?php echo $blocksupportservice['title']; ?></h2>
                    <div class="sup-top-desc">
                        <?php echo $blocksupportservice['content']; ?>
                    </div>
                </div>
                <?php endif; ?>
                <div class="row">
                    <?php if (!empty($block1productsupport)): ?>
                    <div class="col-md-6">
                        <div class="support-item">
                            <div class="sup-item-img">
                                <img src="<?php echo BASE_URL; ?>themes/sharp/assets/images/product-support.svg"
                                    alt="" />
                            </div>
                            <div class="sup-item-desc">
                                <h4><?php echo $block1productsupport['title']; ?></h4>
                                <div class="sup-item-txt">
                                    <?php echo $block1productsupport['content']; ?>
                                </div>
                            </div>
                            <a class="btn-default" href="#"><span class="dw-btn"><?php echo $text_learn_more; ?></span>
                                <span><img src="<?php echo BASE_URL; ?>themes/sharp/assets/images/btn-icon.svg"
                                        alt=""></span></a>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($block2needhelp)): ?>
                    <div class="col-md-6">
                        <div class="support-item">
                            <div class="sup-item-img">
                                <img src="<?php echo BASE_URL; ?>themes/sharp/assets/images/chat-icon.svg" alt="" />
                            </div>
                            <div class="sup-item-desc">
                                <h4><?php echo $block2needhelp['title']; ?></h4>
                                <div class="sup-item-txt">
                                    <?php echo $block2needhelp['content']; ?>
                                </div>
                            </div>
                            <a class="btn-default" href="#"><span class="dw-btn"><?php echo $text_learn_more; ?></span>
                                <span><img src="<?php echo BASE_URL; ?>themes/sharp/assets/images/btn-icon.svg"
                                        alt=""></span></a>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($block3customerservicecenter)): ?>
                    <div class="col-md-6">
                        <div class="support-item">
                            <div class="sup-item-img">
                                <img src="<?php echo BASE_URL; ?>themes/sharp/assets/images/cus-service.svg" alt="" />
                            </div>
                            <div class="sup-item-desc">
                                <h4><?php echo $block3customerservicecenter['title']; ?></h4>
                                <div class="sup-item-txt">
                                    <?php echo $block3customerservicecenter['content']; ?>
                                </div>
                            </div>
                            <a class="btn-default" href="<?php echo HTTPS_HOST . 'service-centers'; ?>"><span
                                    class="dw-btn"><?php echo $text_learn_more; ?></span> <span><img
                                        src="<?php echo BASE_URL; ?>themes/sharp/assets/images/btn-icon.svg"
                                        alt=""></span></a>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php echo $footer; ?>
        <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <button type="button" class="btn-close position-absolute top-0 end-0 m-2"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="ratio ratio-16x9">
                            <iframe src="<?php echo $embed_url; ?>" title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="inquireModal" tabindex="-1" aria-labelledby="inquireModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <h2><?php echo $text_inquire; ?></h2>
                        <form id="inquireForm">
                            <div class="inquire-now-form">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="inq_name" value="" name="name"
                                            placeholder="<?php echo $text_your_name;?>*">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="email" class="form-control" id="inq_email" value="" name="email"
                                            placeholder="<?php echo $text_your_email;?>*">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="tel" class="form-control" id="inq_phone" value="" name="phone"
                                            placeholder="<?php echo $text_contact_number;?>*" maxlength="15">
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-select" id="inq_country" name="country"
                                            aria-label="Select Country">
                                            <option value=""><?php echo $text_select_country; ?>*</option>
                                                <!-- Primary Countries -->
                                            <option value="<?php echo $text_united_arab_emirates; ?>"><?php echo $text_united_arab_emirates; ?></option>
                                            <option value="<?php echo $text_kingdom_of_saudi_arabia; ?>"><?php echo $text_kingdom_of_saudi_arabia; ?></option>
                                            <option value="<?php echo $text_qatar; ?>"><?php echo $text_qatar; ?></option>
                                            <option value="<?php echo $text_kuwait; ?>"><?php echo $text_kuwait; ?></option>
                                            <option value="<?php echo $text_bahrain; ?>"><?php echo $text_bahrain; ?></option>
                                            <option value="<?php echo $text_oman; ?>"><?php echo $text_oman; ?></option>
                                            <option value="<?php echo $text_algeria; ?>"><?php echo $text_algeria; ?></option>
                                            <option value="<?php echo $text_morocco; ?>"><?php echo $text_morocco; ?></option>
                                            <option value="<?php echo $text_south_africa; ?>"><?php echo $text_south_africa; ?></option>
                                            <!-- Secondary Countries -->
                                            <option value="<?php echo $text_united_states; ?>"><?php echo $text_united_states; ?></option>
                                            <option value="<?php echo $text_united_kingdom; ?>"><?php echo $text_united_kingdom; ?></option>
                                            <option value="<?php echo $text_canada; ?>"><?php echo $text_canada; ?></option>
                                            <option value="<?php echo $text_australia; ?>"><?php echo $text_australia; ?></option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="inq_city" value="" name="city"
                                            placeholder="<?php echo $text_city;?>*">
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-select" id="inq_subject" name="subject"
                                            aria-label="Select Subject">
                                            <option value=""><?php echo $text_select_subject;?>*</option>
                                            <option value="General Inquiry"><?php echo $text_general_inquiry; ?>
                                            </option>
                                            <option value="Product Information"><?php echo $text_product_information; ?>
                                            </option>
                                            <option value="Technical Support"><?php echo $text_technical_support; ?>
                                            </option>
                                            <option value="Partnership"><?php echo $text_partnership; ?></option>
                                        </select>
                                    </div>
                                    <div class="col-md-12" id="messagesuccess">
                                        <textarea class="form-control" id="inq_message" name="message"
                                            placeholder="<?php echo $text_message;?>"></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <input type="hidden" name="enquiry_from" value="<?php echo $action; ?>">
                                        <button type="submit" class="btn-default inq_submit">
                                            <span class="dw-btn"><?php echo $text_btn_submit; ?></span> <span><img
                                                    src="<?php echo BASE_URL; ?>themes/sharp/assets/images/btn-icon.svg"
                                                    alt="arrow icon"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        $(document).ready(function() {
            function setActiveThumb(selectedColor) {
                selectedColor = (selectedColor || 'no_color').toLowerCase().trim();
                $('.shop-thumbitem')
                    .removeClass('slick-current active-thumb')
                    .addClass('slick-active');
                let $target = $('.shop-thumbitem').filter(function() {
                    return ($(this).data('color') || '').toLowerCase().trim() === selectedColor;
                }).first();
                if ($target.length) {
                    $target.addClass('slick-current active-thumb');
                    let imgSrc = $target.find('img').attr('src');
                    if (imgSrc) {
                        $('#mainProductImage').attr('src', imgSrc).attr('data-color', selectedColor);
                    }
                    let slickIndex = $target.data('slick-index');
                    if (typeof slickIndex !== 'undefined' && $('.detail-shopslider-thumbnails').hasClass(
                            'slick-initialized')) {
                        $('.detail-shopslider-thumbnails').slick('slickGoTo', slickIndex);
                    }
                }
            }
            $('input[name="color"]').on('change', function() {
                let selectedColor = $(this).val() || 'no_color';
                setActiveThumb(selectedColor);
            });
            $(document).on('click', '.shop-thumbitem', function() {
                let selectedColor = $(this).data('color') || 'no_color';
                let imgSrc = $(this).find('img').attr('src');
                $('#mainProductImage').attr('src', imgSrc).attr('data-color', selectedColor);
                $('.shop-thumbitem').removeClass('slick-current active-thumb').addClass('slick-active');
                $(this).addClass('slick-current active-thumb');
                let slickIndex = $(this).data('slick-index');
                if (typeof slickIndex !== 'undefined' && $('.detail-shopslider-thumbnails').hasClass(
                        'slick-initialized')) {
                    $('.detail-shopslider-thumbnails').slick('slickGoTo', slickIndex);
                }
                $('input[name="color"]').prop('checked', false);
                $('input[name="color"][value="' + selectedColor + '"]').prop('checked', true);
            });
            let defaultColor = $('input[name="color"]:checked').val() || 'no_color';
            setActiveThumb(defaultColor);
        });
        </script>
        <style>
        .shop-thumbitem {
            display: inline-block;
            margin: 4px;
            border: 2px solid transparent;
            cursor: pointer;
            transition: 0.3s;
        }

        .shop-thumbitem.active-thumb {
            border-color: #E6000D;
        }

        .detail-main-image img {
            width: 100%;
            object-fit: contain;
        }

        .detail-shopslider-thumbnails img {
            width: 70px;
            height: 70px;
            object-fit: cover;
        }
        </style>
        <script>
        $(document).ready(function() {
            $(document).on('submit', '#inquireForm', function(e) {
                e.preventDefault();
                let valid = true;
                $('#inquireForm .text-danger').remove();
                const name = $('#inq_name').val().trim();
                const email = $('#inq_email').val().trim();
                const phone = $('#inq_phone').val().trim();
                const country = $('#inq_country').val().trim();
                const city = $('#inq_city').val().trim();
                const subject = $('#inq_subject').val().trim();
                const message = $('#inq_message').val().trim();
                if (name === '') {
                    valid = false;
                    $('#inq_name').after('<div class="text-danger"><?php echo $err_name; ?></div>');
                }
                if (email === '') {
                    valid = false;
                    $('#inq_email').after('<div class="text-danger"><?php echo $err_email; ?></div>');
                } else if (!validateEmail(email)) {
                    valid = false;
                    $('#inq_email').after(
                        '<div class="text-danger"><?php echo $err_invalid_email; ?></div>');
                }
                if (phone === '') {
                    valid = false;
                    $('#inq_phone').after('<div class="text-danger"><?php echo $err_phone; ?></div>');
                }
                if (country === '') {
                    valid = false;
                    $('#inq_country').after(
                        '<div class="text-danger"><?php echo $text_select_country; ?></div>');
                }
                if (city === '') {
                    valid = false;
                    $('#inq_city').after('<div class="text-danger"><?php echo $err_city;?></div>');
                }
                if (subject === '') {
                    valid = false;
                    $('#inq_subject').after(
                    '<div class="text-danger"><?php echo $err_subject;?></div>');
                }
                if (message === '') {
                    valid = false;
                    $('#inq_message').after(
                        '<div class="text-danger"><?php echo $err_message; ?></div>');
                }
                if (valid) {
                    $('.inq_submit').prop('disabled', true);
                    $.ajax({
                        url: '<?php echo HTTPS_HOST; ?>product/inquireNowForm',
                        type: 'POST',
                        data: $(this).serialize(),
                        dataType: 'json',
                        success: function(response) {
                            if (response.error) {
                                $.each(response.error, function(field, errorMsg) {
                                    $('#inq_' + field).after(
                                        '<div class="text-danger">' + errorMsg +
                                        '</div>');
                                });
                                $('.inq_submit').prop('disabled', false);
                            } else if (response.success) {
                                $('#inq_message').closest('#messagesuccess').after(
                                '<div class="alert alert-success alert-dismissible fade show mt-2" role="alert">' +
                                response.success +
                                '</div>'
                                );
                                $('#inquireForm')[0].reset();
                                $('.inq_submit').prop('disabled', false);
                             setTimeout(function() {
                                $('.alert-success').fadeOut(500, function() {
                                    $(this).remove();
                                    $('.inq_submit').prop('disabled', false);
                                });
                            }, 15000);
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Submission Error',
                                text: 'Please try again later.'
                            });
                            $('.inq_submit').prop('disabled', false);
                        }
                    });
                }
            });

            function validateEmail(email) {
                var re = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
                return re.test(email);
            }
        });
        document.addEventListener("DOMContentLoaded", function() {
            var videoModal = document.getElementById('videoModal');
            if (!videoModal) return;
            videoModal.addEventListener('show.bs.modal', function() {
                var iframe = videoModal.querySelector('iframe');
                if (!iframe) return;
                if (!iframe.dataset.originalSrc) {
                    iframe.dataset.originalSrc = iframe.getAttribute('src');
                }
                iframe.setAttribute('src', iframe.dataset.originalSrc);
            });
            videoModal.addEventListener('hidden.bs.modal', function() {
                var iframe = videoModal.querySelector('iframe');
                if (!iframe) return;
                iframe.setAttribute('src', '');
            });
        });
        $('#videoModal button.btn-close').on('click', function() {
            var $iframe = $('#videoModal iframe');
            var src = $iframe.attr('src');
            $iframe.attr('src', '');
            $iframe.attr('src', src);
        });
        </script>