<?php echo $header; ?>
<?php echo $menuinner; ?>
<div id="smooth-wrapper">
    <div id="smooth-content">
        <div class="main-container">
            <?php if (!empty($banner)): ?>
            <section>
                <div class="main-category-banner" style="background: url('<?php echo $banner['image']; ?>');">
                    <div class="container">
                        <div class="cat-banner-inn">
                            <div class="cat-banner-title ab-plasma-title">
                                <h1>
                                    <span><?php echo $banner['title']; ?> </span>
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php endif; ?>
            <section>
                <div class="pages-tab-menu product-warrt">
                    <div class="container">
                        <div class="p-tab-menu-inn">
                            <ul>
                                <li><a
                                        href="<?php echo HTTP_HOST; ?>download-center"><?php echo $text_download_center; ?></a>
                                </li>
                                <li><a
                                        href="<?php echo HTTP_HOST; ?>source-code-download"><?php echo $text_source_code; ?></a>
                                </li>
                                <li class="active"><a
                                        href="<?php echo HTTP_HOST; ?>product-warranty-registration"><?php echo $text_product_warranty; ?></a>
                                </li>
                                <li><a href="<?php echo HTTP_HOST; ?>user-manuals"><?php echo $text_user_manual; ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            <section>
                <div class="download-center-listing">
                    <div class="container">
                        <div class="d-center-listing-inn pro-war-register">
                            <div class="container">
                                <div class="pro-warrenty">
                                    <div class="pro-warrenty-inn">
                                        <div class="pro-warrenty-title">
                                            <h2><?php echo $blockproductwarranty['title']; ?></h2>
                                            <?php echo $blockproductwarranty['content']; ?>
                                        </div>

                                        <div class="pro-warrenty-conts">
                                            <?php if (!empty($blockwarrantyregistrationleft['image'])): ?>
                                            <div class="pro-warrenty-img">
                                                <img src="<?php echo BASE_URL . 'uploads/image/blockimages/' . $blockwarrantyregistrationleft['image']; ?>"
                                                    alt="">
                                            </div>
                                            <?php endif; ?>
                                            <div class="pro-warrenty-txt">
                                                <?php if (!empty($blockwarrantyregistrationright['image'])): ?>
                                                <div class="pro-warrenty-img-sec">
                                                    <img src="<?php echo BASE_URL . 'uploads/image/blockimages/' . $blockwarrantyregistrationright['image']; ?>"
                                                        alt="">
                                                </div>
                                                <?php endif; ?>
                                                <div class="pro-warrenty-txt-cont">
                                                    <?php echo $blockproductwarrantysecond['content']; ?>
                                                </div>
                                                <div class="pro-warrenty-link">
                                                    <a href="#" class="btn-default"><span
                                                            class="dw-btn"><?php echo $text_learn_more; ?></span>
                                                        <span><img
                                                                src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg"
                                                                alt=""></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php echo $footer; ?>