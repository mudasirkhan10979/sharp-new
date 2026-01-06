<?php echo $header; ?>
<?php echo $menuinner; ?>
<div id="smooth-wrapper">
    <div id="smooth-content">
        <div class="main-container">
            <section class="casestudy-gallery">
                <div class="container">
                    <a class="default-back" href="<?php echo $breadcrumbs['href']; ?>"><img
                            src="<?php echo BASE_URL; ?>themes/sharp/assets/images/arrow-link.svg"
                            alt=""><?php echo $breadcrumbs['text']; ?></a>
                    <h1><?php echo $casestudiesDetails['title']; ?></h1>
                    <div class="case-category"><?php echo $casestudiesDetails['tag']; ?></div>
                    <?php if (!empty($casesliders)): ?>
                    <div class="case-gallery-inner">
                        <div class="row">
                            <?php foreach ($casesliders as $caseslider): ?>
                            <div class="col-md-3">
                                <div class="case-gallery-item">
                                    <a href="" data-lightbox="lightbox">
                                        <img src="<?php echo BASE_URL . 'uploads/image/case_study/' . $caseslider['image']; ?>"
                                            alt="" />
                                    </a>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </section>
            <section class="gal-bottom-desc top-space bottom-space default-sec">
                <div class="container">
                    <div class="gal-bottom-inner">
                        <div class="row">
                            <div class="col-md-5">
                                <h2><?php echo $casestudiesDetails['second_title']; ?></h2>
                            </div>
                            <div class="col-md-7">
                                <div class="gal-botton-txt">
                                    <?php echo $casestudiesDetails['second_description']; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="case-desc-sec">
                <div class="container">
                    <div class="case-desc-inner padding-top padding-bottom default-sec">
                        <div class="case-dt-wrap">
                            <div class="casedesc-top">
                                <h2><?php echo $casestudiesDetails['middle_title']; ?> </h2>
                                <div class="case-high-txt">
                                    <h4><?php echo $casestudiesDetails['first_middle_description']; ?></h4>
                                </div>
                                <div class="casedesc-txt">
                                    <?php echo $casestudiesDetails['second_middle_description']; ?>
                                </div>
                            </div>
                            <div class="casedesc-wrap">
                                <div class="row align-items-center">
                                    <div class="col-md-3">
                                        <div class="casedt-img">
                                            <img src="<?php echo $casestudiesDetails['middle_image']; ?>" alt="" />
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="casedt-detail">
                                            <?php echo $casestudiesDetails['third_middle_description']; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="related-case-sec case-slider-sec top-space bottom-space default-sec">
                <div class="container">
                    <h2><?php echo $text_related_case_studies; ?></h2>
                </div>
                <div class="caseslider-wrap">
                    <div class="owl-carousel owl-theme" id="caseslider">
                        <?php foreach ($relatedcasestudy as $rcasestudy): ?>
                        <div class="caseslider-item">
                            <div class="caseslider-top">
                                <div class="caseslider-img">
                                    <img src="<?php echo $rcasestudy['image']; ?>" alt="" />
                                </div>
                                <label class="caseslider-tag"><?php echo $rcasestudy['tag']; ?></label>
                            </div>
                            <div class="caseslider-desc">
                                <h3><?php echo $rcasestudy['title']; ?></h3>
                                <div class="caseslider-txt">
                                    <?php echo $rcasestudy['short_description']; ?>
                                </div>
                                <a class="btn-default"
                                    href="<?php echo $rcasestudy['url']; ?>"><?php echo $text_learn_more; ?> <span><img
                                            src="<?php echo BASE_URL; ?>themes/sharp/assets/images/btn-icon.svg"
                                            alt=""></span></a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
        </div>
        </section>
        <?php echo $footer; ?>