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
                            <div class="cat-banner-title">
                                <h1>
                                    <span><?php echo $banner['title']; ?></span>
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php endif; ?>
            <section class="download-center top-space bottom-space default-sec">
                <div class="container">
                    <?php if (!empty($blockdownloadcenter)): ?>
                    <div class="download-cdesc">
                        <h2><?php echo $blockdownloadcenter['title']; ?></h2>
                        <div class="download-ctxt">
                            <?php echo $blockdownloadcenter['content']; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="download-inner">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="download-ctabs">
                                    <div class="supp-accordian-wrap csr-cmp-accordian-inn">
                                        <div class="accordion" id="suppaccordion">
                                            <?php if (!empty($blocksourcecodedownload)): ?>
                                            <!-- <div class="accordion-item">
                                                <h2 class="accordion-header" id="suppheadingOne">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                        aria-expanded="true" aria-controls="collapseOne">
                                                        <?php echo $blocksourcecodedownload['title']; ?>
                                                    </button>
                                                </h2>
                                                <div id="collapseOne" class="accordion-collapse collapse show"
                                                    aria-labelledby="suppheadingOne" data-bs-parent="#suppaccordion">
                                                    <div class="accordion-body">
                                                        <?php echo $blocksourcecodedownload['content']; ?>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <!-- <?php endif; ?>
                                            <?php if (!empty($blockproductwarranty)): ?> -->
                                            <!-- <div class="accordion-item">
                                                <h2 class="accordion-header" id="suppheadingTwo">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                        aria-expanded="false" aria-controls="collapseTwo">
                                                        <?php echo $blockproductwarranty['title']; ?>
                                                    </button>
                                                </h2>
                                                <div id="collapseTwo" class="accordion-collapse collapse"
                                                    aria-labelledby="suppheadingTwo" data-bs-parent="#suppaccordion">
                                                    <div class="accordion-body">
                                                        <?php echo $blockproductwarranty['content']; ?>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <?php endif; ?>
                                            <!-- <?php if (!empty($blockusermanuals)): ?>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="suppheadingThree">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                        aria-expanded="false" aria-controls="collapseThree">
                                                        <?php echo $blockusermanuals['title']; ?>
                                                    </button>
                                                </h2>
                                                <div id="collapseThree" class="accordion-collapse collapse"
                                                    aria-labelledby="suppheadingThree" data-bs-parent="#suppaccordion">
                                                    <div class="accordion-body">
                                                        <?php echo $blockusermanuals['content']; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endif; ?> -->
                                            <!--  new changes start -->
                                            <div class="sp-assist-txt">
                                                <div class="sp-assist-txt-inn">
                                                    <h2><?php echo $blockusermanuals['title']; ?></h2>
                                                    <?php echo $blockusermanuals['content']; ?>
                                                    <div class="supp-faq-txt-link">
                                                        <a href="<?php echo HTTP_HOST; ?>user-manuals"
                                                            class="btn-default"><?php echo $text_explore; ?> <span><img
                                                                    src="<?php echo $BASE_URL; ?>/themes/sharp/assets/imgs/arrow.svg"
                                                                    alt=""></span></a>
                                                    </div>
                                                </div>
                                            </div>
                                          <!--  new changes end -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if (!empty($blockimagedownloadcenter)): ?>
                            <div class="col-md-6">
                                <div class="download-cimg">
                                    <img src="<?php echo BASE_URL . 'uploads/image/blockimages/' . $blockimagedownloadcenter['image']; ?>"
                                        alt="" />
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
            <section class="map-contact-sec default-sec">
                <div class="container">
                    <div class="map-contact-bg-sec">
                        <div class="container">
                            <div class="map-contact-inner padding-top padding-bottom">

                                <div class="map-contact-wrap">
                                    <div class="map-contact-wrap-inn">
                                        <iframe
                                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d462560.682833583!2d54.89781208970431!3d25.076280444810326!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5f43496ad9c645%3A0xbde66e5084295162!2sDubai%20-%20United%20Arab%20Emirates!5e0!3m2!1sen!2s!4v1754545125695!5m2!1sen!2s"
                                            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                                    </div>
                                </div>
                                <div class="map-contact-info">
                                    <div class="contact-detail-inn">
                                        <?php if (!empty($blocksseddoeiusmod)): ?>
                                        <div class="contact-detail-title">
                                            <h2><?php echo $blocksseddoeiusmod['title']; ?></h2>
                                            <?php echo $blocksseddoeiusmod['content']; ?>
                                        </div>
                                        <?php endif; ?>
                                        <div class="o-l-cant-info-inn">
                                            <?php if (!empty($config_address)): ?>
                                            <div class="loct-item-inn">
                                                <span class="l-item-icon">
                                                    <img src="<?php echo $BASE_URL; ?>/themes/sharp/assets/imgs/loaction.svg"
                                                        alt="">
                                                </span>
                                                <span class="label"><?php echo $text_location;?>:</span>
                                                <span class="value">
                                                    <a href="https://www.google.com/maps/search/<?php echo urlencode($config_address); ?>"
                                                        target="_blank">
                                                        <?php echo $config_address; ?>
                                                    </a></span>
                                            </div>
                                            <?php endif; ?>
                                            <?php if (!empty($telephone)): ?>
                                            <div class="loct-item-inn">
                                                <span class="l-item-icon">
                                                    <img src="<?php echo $BASE_URL; ?>/themes/sharp/assets/imgs/phone.svg"
                                                        alt="">
                                                </span>
                                                <span class="label"><?php echo $phone_lab; ?>:</span>
                                                <span class="value">
                                                    <a href="tel:<?php echo preg_replace('/\s+/', '', $telephone); ?>">
                                                        <?php echo $telephone; ?>
                                                    </a></span>
                                            </div>
                                            <?php endif; ?>
                                            <?php if (!empty($config_email)): ?>
                                            <div class="loct-item-inn">
                                                <span class="l-item-icon">
                                                    <img src="<?php echo $BASE_URL; ?>/themes/sharp/assets/imgs/envelope.svg"
                                                        alt="">
                                                </span>
                                                <span class="label"><?php echo $email_lab;?>:</span>
                                                <span class="value">
                                                    <a href="mailto:<?php echo $config_email; ?>">
                                                        <?php echo $config_email; ?>
                                                    </a></span>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="map-contact-info-link">
                                            <a href="<?php echo HTTP_HOST . 'service-centers'; ?>"
                                                class="btn-default"><span
                                                    class="dw-btn"><?php echo $text_explore; ?></span> <span><img
                                                        src="<?php echo $BASE_URL; ?>/themes/sharp/assets/imgs/arrow.svg"
                                                        alt=""></span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php if (!empty($faqs)) { ?>
            <section>
                <div class="support-faq">
                    <div class="container">
                        <div class="support-faq-inn">
                            <?php if (!empty($blockfaqsonsupport)): ?>
                            <div class="support-faq-txt">
                                <div class="support-faq-txt-inn">
                                    <h2><?php echo $blockfaqsonsupport['title']; ?></h2>
                                    <?php echo $blockfaqsonsupport['content']; ?>
                                    <div class="supp-faq-txt-link">
                                        <a href="<?php echo HTTP_HOST; ?>faqs"
                                            class="btn-default"><?php echo $text_explore; ?> <span><img
                                                    src="<?php echo $BASE_URL; ?>/themes/sharp/assets/imgs/arrow.svg"
                                                    alt=""></span></a>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="support-faq-qa">
                                <div class="support-faq-qa-inn">
                                    <div class="faqs-list-inn">
                                        <div class="accordion" id="accordionExample">
                                            <?php foreach ($faqs as $index => $faq): ?>
                                            <?php
                                                    $headingId  = "heading{$index}";
                                                    $collapseId = "collapse{$index}";
                                                    $isFirst    = ($index === 0);
                                                    ?>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="<?php echo $headingId; ?>">
                                                    <button
                                                        class="accordion-button <?php echo !$isFirst ? 'collapsed' : ''; ?>"
                                                        type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#<?php echo $collapseId; ?>"
                                                        aria-expanded="<?php echo $isFirst ? 'true' : 'false'; ?>"
                                                        aria-controls="<?php echo $collapseId; ?>">
                                                        <?php echo $faq['question']; ?>
                                                    </button>
                                                </h2>
                                                <div id="<?php echo $collapseId; ?>"
                                                    class="accordion-collapse collapse <?php echo $isFirst ? 'show' : ''; ?>"
                                                    aria-labelledby="<?php echo $headingId; ?>"
                                                    data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <?php echo html_entity_decode($faq['answer']); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php } ?>
            <?php if (!empty($blockimagewearehere) && !empty($blockwearehereto)): ?>
            <section>
                <div class="support-assist-sec">
                    <div class="container">
                        <div class="support-assist-inner">
                            <div class="container">
                                <div class="sp-assist-content">
                                    <div class="sp-assist-img">
                                        <div class="sp-assist-img-inn">
                                            <img src="<?php echo BASE_URL . 'uploads/image/blockimages/' . $blockimagewearehere['image']; ?>"
                                                alt="">
                                        </div>
                                    </div>
                                    <div class="sp-assist-txt">
                                        <div class="sp-assist-txt-inn">
                                            <h2><?php echo $blockwearehereto['title']; ?></h2>
                                            <?php echo $blockwearehereto['content']; ?>
                                            <div class="supp-faq-txt-link">
                                                <a href="<?php echo HTTP_HOST; ?>contact-us"
                                                    class="btn-default"><?php echo $heading_title_contact; ?> <span><img
                                                            src="<?php echo $BASE_URL; ?>/themes/sharp/assets/imgs/arrow.svg"
                                                            alt=""></span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php endif; ?>
            <?php echo $footer; ?>