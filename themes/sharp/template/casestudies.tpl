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
            <?php if (!empty($casestudies)) : ?>
            <!-- <section class="case-slider-sec top-space default-sec">
                <div class="container">
                    <h2><?php echo $text_about_us; ?></h2>
                </div>
                <div class="caseslider-wrap">
                    <div class="owl-carousel owl-theme" id="caseslider">
                        <?php foreach ($casestudies as $casestudy): ?>
                        <div class="caseslider-item">
                            <div class="caseslider-top">
                                <div class="caseslider-img">
                                    <img src="<?php echo $casestudy['image']; ?>" alt="" />
                                </div>
                                <label class="caseslider-tag"><?php echo $casestudy['tag']; ?></label>
                            </div>
                            <div class="caseslider-desc">
                                <h3><?php echo $casestudy['title']; ?></h3>
                                <div class="caseslider-txt">
                                    <?php echo $casestudy['short_description']; ?>
                                </div>
                                <a class="btn-default"
                                    href="<?php echo $casestudy['url']; ?>"><?php echo $text_learn_more; ?> <span><img
                                            src="<?php echo BASE_URL; ?>themes/sharp/assets/images/btn-icon.svg"
                                            alt=""></span></a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section> -->
            <?php endif; ?>
            <?php if (!empty($blockcsrofcasestudies) && !empty($blockimagecsrreports) && !empty($blockrightimagecsrreports)) : ?>
            <section class="csr-report-sec top-space default-sec">
                <div class="container">
                    <div class="csr-report-inner padding-top padding-bottom">
                        <h2><?php echo $text_esg_csr; ?></h2>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="csr-detail-wrap">
                                    <h3><?php echo $blockcsrofcasestudies['title']; ?> </h3>
                                    <div class="csr-txt-wrap">
                                        <?php echo $blockcsrofcasestudies['content']; ?>
                                    </div>
                                    <div class="csr-detail-img">
                                        <img src="<?php echo BASE_URL . 'uploads/image/blockimages/' . $blockimagecsrreports['image']; ?>"
                                            alt="" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="csr-report-img">
                                    <img src="<?php echo BASE_URL . 'uploads/image/blockimages/' . $blockrightimagecsrreports['image']; ?>"
                                        alt="" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php endif; ?>
            <?php if (!empty($productlifecycleanalysis)) : ?>
            <!-- <section class="pro-lifecycle-sec top-space default-sec">
                <?php if (!empty($blockcasestudiesproductlifecycle)) : ?>
                <div class="container">
                    <div class="pro-lifecycle-top">
                        <h2><?php echo $blockcasestudiesproductlifecycle['title']; ?></h2>
                        <div class="esg-desc">
                            <?php echo $blockcasestudiesproductlifecycle['content']; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <div class="pro-lifecycle-wrap">
                    <div class="owl-carousel owl-theme" id="lifecycleslider">
                        <?php foreach ($productlifecycleanalysis as $lifecycle) : ?>
                        <div class="lifeslider-item">
                            <div class="lifeslider-img">
                                <img src="<?php echo BASE_URL; ?>uploads/image/productlifecycleanalysis/<?php echo $lifecycle['image']; ?>"
                                    alt="" />
                            </div>
                            <div class="lifeslider-desc">
                                <h3><?php echo $lifecycle['title']; ?></h3>
                                <div class="lifeslider-txt">
                                    <?php echo html_entity_decode($lifecycle['short_description'], ENT_QUOTES, 'UTF-8'); ?>
                                </div>
                                <a class="lifeslider-icon" href=""><img
                                        src="<?php echo BASE_URL; ?>themes/sharp/assets/images/white-arrow-icon.svg"
                                        alt=""></a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section> -->
            <?php endif; ?>
            <?php if (!empty($lcareports)): ?>
            <section class="lca-reports-sec top-space default-sec" style="display: none;">
                <div class="container">
                    <div class="lca-reports-inner padding-top padding-bottom">
                        <h2><?php echo $text_lca_reports; ?></h2>
                        <div class="row">
                            <div class="download-res-wrap">
                                <div class="owl-carousel owl-theme" id="lcareportslider">
                                    <?php foreach ($lcareports as $report) : ?>
                                    <div class="download-res-item">
                                        <div class="download-img">
                                            <img src="<?php echo BASE_URL . 'uploads/image/lcareport/' . $report['image']; ?>"
                                                alt="<?php echo $report['title']; ?>" />
                                        </div>
                                        <div class="download-desc">
                                            <h4><?php echo $report['title']; ?></h4>
                                            <div class="lca-desc">
                                                <?php echo str_replace('&nbsp;', ' ', html_entity_decode($blockcsrofcasestudies['content'], ENT_QUOTES, 'UTF-8')); ?>
                                            </div>
                                        </div>
                                        <div class="download-btn"><a class="btn-default"
                                                href="<?php echo BASE_URL . 'uploads/image/lcareport_pdfs/' . $report['pdf']; ?>"
                                                target="_blank"><span
                                                    class="dw-btn"><?php echo $text_download; ?></span> <span><img
                                                        src="<?php echo BASE_URL; ?>themes/sharp/assets/images/btn-icon.svg"
                                                        alt=""></span></a>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php endif; ?>
            
            <?php if (!empty($blockcasestudiesreports)) : ?>
            <section class="sustain-reports-sec default-sec">
                <div class="container">
                    <div class="sustain-reports-inner padding-top padding-bottom">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="sustain-reports-desc">
                                    <h2><?php echo $blockcasestudiesreports['title']; ?></h2>
                                    <div class="sustain-reports-txt">
                                        <?php echo $blockcasestudiesreports['content']; ?>
                                    </div>
                                    <a class="btn-default" href="https://global.sharp/corporate/eco/report/" target="_blank">
                                              <span class="dw-btn"><?php echo $text_learn_more; ?></span>  
                                      <span><img src="<?php echo BASE_URL; ?>themes/sharp/assets/images/btn-icon.svg" alt=""></span>
                                     </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="sustain-reports-img">
                                    <img src="<?php echo BASE_URL . 'uploads/image/blockimages/' . $blockimagecasestudiesreports['image']; ?>"
                                        alt="" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php endif; ?>
            <section class="partner-logos-sec top-space bottom-space default-sec" style="display: none;">
                <?php if (!empty($blockcasestudiespartners)) : ?>
                <div class="container">
                    <div class="partner-logos-top">
                        <h2><?php echo $blockcasestudiespartners['title']; ?></h2>
                        <div class="partner-desc"><?php echo $blockcasestudiespartners['content']; ?></div>
                    </div>
                </div>
                <?php endif; ?>
                <?php if (!empty($sustainablePartners)) : ?>
                <div class="partner-logos-wrap">
                    <div class="owl-carousel owl-theme" id="partnerlogoslider">
                        <?php foreach ($sustainablePartners as $sustainablePartner) : ?>
                        <div class="partner-logo-item">
                            <img src="<?php echo BASE_URL . 'uploads/image/sustainablepartner/' . $sustainablePartner['logo']; ?>"
                                alt="<?php echo $sustainablePartner['title']; ?>" />
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
            <?php endif; ?>
            <?php if (!empty($faqs)) : ?>
            <!-- <section class="faqs-sec top-space bottom-space default-sec">
                <div class="container">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="faq-detail-sec">
                                <h2><?php echo $blockfaqsonsupport['title']; ?></h2>
                                <div class="faq-desc">
                                    <?php echo $blockfaqsonsupport['content']; ?>
                                </div>
                                <a class="btn-default" href="<?php echo HTTP_HOST; ?>faqs"><?php echo $text_explore;?>
                                    <span><img src="<?php echo BASE_URL; ?>themes/sharp/assets/images/btn-icon.svg"
                                            alt=""></span></a>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="faq-accordian-wrap csr-cmp-accordian-inn">
                                <div class="accordion" id="faqaccordion">
                                    <?php foreach ($faqs as $index => $faq): ?>
                                    <?php
											$headingId  = "heading{$index}";
											$collapseId = "collapse{$index}";
											$isFirst    = ($index === 0);
											?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="<?php echo $headingId; ?>">
                                            <button class="accordion-button <?php echo !$isFirst ? 'collapsed' : ''; ?>"
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
                                                <?php echo $faq['answer']; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section> -->
            <?php endif; ?>
            <?php echo $footer; ?>