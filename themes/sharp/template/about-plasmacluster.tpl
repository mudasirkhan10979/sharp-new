<?= $header ?>
<?= $menuinner ?>
<?php if (!empty($banner)): ?>
    <div id="smooth-wrapper">
        <div id="smooth-content">
            <div class="main-container">
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
            <?php if (!empty($blockaboutulamcorperplasmacluster)): ?>
                <section>
                    <div class="plasma-overview">
                        <div class="container">
                            <div class="plasma-overview-inn">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="plasma-overview-title">
                                            <h2>
                                                <!-- <span><?php echo $text_overview; ?></span> -->
                                                <span><?php echo $text_lpsracid; ?></span>
                                            </h2>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="plasma-overview-text">
                                            <h4><?php echo $blockaboutulamcorperplasmacluster['title']; ?></h4>
                                            <div class="plasma-ovr-txt-cont">
                                                <?php echo $blockaboutulamcorperplasmacluster['content']; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
            <?php if (!empty($blockplasmaclusterpage)): ?>
                <section>
                    <div class="abt-plasma-play">
                        <div class="container">
                            <div class="abt-plasma-play-inn">
                                <div class="abt-play-img">
                                    <img src="<?= BASE_URL; ?>uploads/image/blockimages/<?= $blockplasmaclusterpage['image']; ?>" alt="">
                                    <div class="abt-play-btn">
                                        <a href="https://sharp.nexatestwp.com/html_pages/assets/videos/Sharp-Banner-Video.mp4" target="_blank" class="btn-default"><?php echo $text_play; ?> <span><img src="<?= BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
            <section class="benefits-sec top-space default-sec abt-plasma-benefit">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="benefit-content">
                                <h2><?php echo $blockbenefitsaboutplasmacluster['title']; ?></h2>
                                <div class="benefit-desc">
                                    <?php echo $blockbenefitsaboutplasmacluster['content']; ?>
                                </div>
                                <div class="benefit-item-list">
                                    <div class="benefit-item-wrap">
                                        <div class="row">
                                            <?php if (!empty($blocklorem1plasmacluster)): ?>
                                                <div class="col-md-6">
                                                    <div class="benefit-item">
                                                        <div class="benefit-icon">
                                                            <img src="<?= BASE_URL; ?>themes/sharp/assets/images/star.svg" alt="" />
                                                        </div>

                                                        <div class="benefit-item-desc">
                                                            <h6><?php echo $blocklorem1plasmacluster['title']; ?></h6>
                                                            <p> <?php echo $blocklorem1plasmacluster['content']; ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <?php if (!empty($blocklorem2plasmacluster)): ?>
                                                <div class="col-md-6">
                                                    <div class="benefit-item">
                                                        <div class="benefit-icon">
                                                            <img src="<?= BASE_URL; ?>themes/sharp/assets/images/chart-pie.svg" alt="" />
                                                        </div>

                                                        <div class="benefit-item-desc">
                                                            <h6><?php echo $blocklorem2plasmacluster['title']; ?></h6>
                                                            <p> <?php echo $blocklorem2plasmacluster['content']; ?>
                                                            <p>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="benefit-item-wrap">
                                        <div class="row">
                                            <?php if (!empty($blocklorem3plasmacluster)): ?>
                                                <div class="col-md-6">
                                                    <div class="benefit-item">
                                                        <div class="benefit-icon">
                                                            <img src="<?= BASE_URL; ?>themes/sharp/assets/images/shopping-basket.svg" alt="" />
                                                        </div>

                                                        <div class="benefit-item-desc">
                                                            <h6><?php echo $blocklorem3plasmacluster['title']; ?></h6>
                                                            <p><?php echo $blocklorem3plasmacluster['content']; ?> </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <?php if (!empty($blocklorem4plasmacluster)): ?>
                                                <div class="col-md-6">
                                                    <div class="benefit-item">
                                                        <div class="benefit-icon">
                                                            <img src="<?= BASE_URL; ?>themes/sharp/assets/images/poll-vertical-circle.svg" alt="" />
                                                        </div>

                                                        <div class="benefit-item-desc">
                                                            <h6><?php echo $blocklorem4plasmacluster['title']; ?></h6>
                                                            <p> <?php echo $blocklorem4plasmacluster['content']; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php if (!empty($air_purifiers_products)): ?>
                <section>
                    <div class="ab-pl-product-slider">
                        <div class="container">
                            <div class="cate-slider-title">
                                <h2><?php echo $text_our_products; ?> </h2>
                            </div>
                            <div class="cate-slider-listing">
                                <div class="cate-slider-list-inn">
                                    <?php foreach ($air_purifiers_products as $product): ?>
                                        <div class="t-list-item">
                                            <div class="t-list-item-inn">
                                                <div class="t-list-item-img img-animate">
                                                   <?php if(isset($product['is_new']) && $product['is_new'] == '1'): ?>
                                                        <div class="ribbon ribbon-top-left"><span><?php echo $text_text_new; ?></span></div>
                                                    <?php endif; ?>
                                                    <a href="<?= BASE_URL . 'product/' . $product['seo_url']; ?>"><img src="<?php echo BASE_URL . 'uploads/image/product/' . $product['image']; ?>" alt="<?= $product['name']; ?>">
                                                    </a>
                                                </div>
                                                <div class="t-list-item-cont">
                                                    <h4><a href="<?= BASE_URL . 'product/' . $product['seo_url']; ?>"><?= $product['name']; ?></a></h4>
                                                    <p><?= $product['model']; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

             <?php if (!empty($aboutsharpimage1) && !empty($aboutsharpblack1)): ?>
                <section id="about-brand">
                    <div class="about-brand">
                        <div class="container">
                            <div class="about-brand-inn">
                                <div class="about-brand-contant">
                                    <div class="row">
                                        <?php if (!empty($aboutsharpimage1['image'])): ?>
                                            <div class="col-md-6">
                                                <div class="about-brand-img">
                                                    <img src="<?php echo BASE_URL . 'uploads/image/blockimages/' . $aboutsharpimage1['image']; ?>" alt="">
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="col-md-6">
                                            <div class="about-brand-txt">
                                                <h2><?php echo $aboutsharpblack1['title']; ?></h2>
                                                <div class="a-b-text">
                                                    <?php echo $aboutsharpblack1['content']; ?>
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
              <div class="container">
          <div class="service-center-list">
            <div class="service-center-list-inn">
                <div class="s-center-list-title">
                    <h2><?php echo $plasmaclusterairblock['title']; ?></h2>
                   <?php echo $plasmaclusterairblock['content']; ?>
                </div>
              <div class="s-center-table-list">
                    <div class="s-center-table-list-inn">
                        <div class="s-center-table">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <td>Feature</td>
                                        <td>Plasmacluster</td>
                                        <td>HEPA Filters</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Actively Neutralizes Germs</td>
                                        <td>Yes</td>
                                        <td>No</td>
                                    </tr>
                                    <tr>
                                        <td>Reduces Odors</td>
                                        <td>Yes</td>
                                        <td>Limited</td>
                                    </tr>
                                    <tr>
                                        <td>Eliminates Allergens</td>
                                        <td>Yes</td>
                                        <td>Yes</td>
                                    </tr>
                                    <tr>
                                        <td>No Harmful Byproducts</td>
                                        <td>Yes</td>
                                        <td>Yes</td>
                                    </tr>
                                    <tr>
                                        <td>Reduces Static Electricity</td>
                                        <td>Yes</td>
                                        <td>No</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <p>Paired with HEPA and carbon filters in Sharp air purifiers, Plasmacluster delivers one of the world’s finest air - cleaning results.</p>
             </div>
          </div>
        </div>
            <?php if (!empty($plasmacluster)): ?>
                <section  id="certificates-section">
                    <div class="certificate-research">
                        <div class="certificate-research-inn">
                            <div class="container">
                                <div class="certif-rch-title">
                                    <h2><?php echo $text_certificates; ?></h2>
                                    <p><?php echo  $description_certificates; ?></p>
                                </div>
                            </div>
                            <div class="certif-rch-slider">
                                <div class="certif-rch-slider-inn">
                                    <?php foreach ($plasmacluster as $plasma) : ?>
                                        <div class="certif-slide-item">
                                            <div class="certif-slide-item-inn">
                                                <div class="certif-slide-img">
                                                    <img src="<?= BASE_URL; ?>uploads/image/certificatesandresearch/<?= $plasma['image']; ?>" alt="">
                                                </div>
                                                <div class="certif-slide-text">
                                                    <h3><?php echo date("Y", strtotime($plasma['date'])); ?></h3>
                                                    <p><?php echo $plasma['title']; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif;  ?>
            <?php echo $footer; ?>