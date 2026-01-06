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
            <?php if (!empty($aboutsharpimage1) && !empty($aboutsharpblack1)): ?>
                <section>
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
            <?php if (!empty($ourhistory)) {  ?>
                <section>
                    <div class="sharp-history">
                        <div class="container">
                            <div class="sharp-history-inner">
                                <div class="sharp-history-title">
                                    <h2><?php echo $aboutsharphistory['title']; ?></h2>
                                    <?php echo $aboutsharphistory['content']; ?>
                                </div>
                                <div class="sharp-history-slider">
                                    <div class="sharp-history-slider-inn">
                                        <div class="sharp-hst-slider-list">
                                            <?php
                                            $count = 1;
                                            foreach ($ourhistory as $history) { ?>
                                                <div class="s-hst-slider-item">
                                                    <div class="s-hst-sl-item-inn">
                                                        <div class="hst-item-text">
                                                            <div class="hst-item-title">
                                                                <h4><?php echo $history['title']; ?></h4>
                                                            </div>
                                                            <div class="hst-item-inner-cont">
                                                                <div class="hst-item-numbr">
                                                                    <span><?php echo str_pad($count, 2, '0', STR_PAD_LEFT); ?></span>
                                                                </div>
                                                                <div class="hst-item-txt-cnt">
                                                                    <?php echo html_entity_decode($history['short_description'], ENT_QUOTES, 'UTF-8'); ?>
                                                                    <span class="hst-year"><?php echo date("Y", strtotime($history['date'])); ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="hst-item-img">
                                                            <div class="hst-item-img-icon">
                                                                <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/line-chart.svg" alt="">
                                                            </div>
                                                            <div class="hst-item-img-inn">
                                                                <img src="<?php echo BASE_URL; ?>uploads/image/ourhistories/<?php echo $history['image']; ?>" alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                                $count++;
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php } ?>
            <!-- <section>
                <div class="smef-profile">
                    <div class="container">
                        <div class="smef-profile-inner">
                            <div class="smef-profile-content">
                                <div class="smef-prof-text">
                                    <?php if (!empty($aboutsharploremipsameter)): ?>
                                        <div class="smef-prf-sub">
                                            <p><?php echo $aboutsharploremipsameter['title']; ?></p>
                                        </div>
                                        <?php echo $aboutsharploremipsameter['content']; ?>
                                    <?php endif; ?>
                                    <div class="smef-txt-inn">
                                        <?php if (!empty($aboutsharpmiddleleftimage['image'])): ?>
                                            <div class="smef-txt-img">
                                                <img src="<?php echo BASE_URL . 'uploads/image/blockimages/' . $aboutsharpmiddleleftimage['image']; ?>" alt="">
                                            </div>
                                        <?php endif; ?>
                                        <div class="smef-txt-cnt">
                                            <?php echo $aboutsharpsmefcorporateprofile['content']; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="smef-prof-title">
                                    <h2><?php echo $aboutsharpsmefcorporateprofile['title']; ?></h2>
                                    <?php if (!empty($aboutsharpmiddlerightimage['image'])): ?>
                                        <div class="smef-prof-tlt-img">
                                            <img src="<?php echo BASE_URL . 'uploads/image/blockimages/' . $aboutsharpmiddlerightimage['image']; ?>" alt="">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section> -->
            <?php if (!empty($aboutsharpphilosophy) && !empty($aboutsharpmiddle2ndrightimage) && !empty($aboutsharpmiddle2ndleftimage)): ?>
                <section>
                    <div class="philosophy-sec">
                        <div class="container">
                            <div class="philosophy-sec-inn">
                                <div class="philosophy-title">
                                    <h2><?php echo $aboutsharpphilosophy['title']; ?> </h2>
                                </div>
                                <div class="philosophy-content">
                                    <div class="philosophy-content-inn">
                                        <div class="philosophy-text">
                                            <div class="philosophy-txt-inn">
                                                <?php echo $aboutsharpphilosophy['content']; ?>
                                                <?php if (!empty($aboutsharpmiddle2ndleftimage['image'])): ?>
                                                    <!-- <div class="philosophy-txt-img">
                                                        <img src="<?php echo BASE_URL . 'uploads/image/blockimages/' . $aboutsharpmiddle2ndleftimage['image']; ?>" alt="">
                                                    </div> -->
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <?php if (!empty($aboutsharpmiddle2ndrightimage['image'])): ?>
                                            <div class="philosophy-img">
                                                <div class="philosophy-img-inn">
                                                    <img src="<?php echo BASE_URL; ?>uploads/image/blockimages/img02.png" alt="">
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
            <?php if (!empty($aboutsharpmanagingdirector)): ?>
                <section>
                    <div class="managing-director-sec">
                        <div class="container">
                            <div class="managing-director-inn">
                                <div class="m-director-content">
                                    <div class="row">
                                        <?php if (!empty($aboutsharpmanagingdirector['image'])): ?>
                                            <div class="col-md-6">
                                                <div class="m-director-img">
                                                    <img src="<?php echo BASE_URL . 'uploads/image/blockimages/' . $aboutsharpmanagingdirector['image']; ?>" alt="">
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="col-md-6">
                                            <div class="m-director-txt">
                                                <p class="m-director-sub-title">
                                                    <?php echo $aboutsharpmessagefrom['title']; ?>
                                                </p>
                                                <?php echo $aboutsharpmessagefrom['content']; ?>
                                                <div class="m-d-text">
                                                    <?php echo $aboutsharpmanagingdirector2['content']; ?>
                                                </div>
                                                <div class="m-d-name">
                                                    <p><?php echo $aboutsharpsotasaito['title']; ?></p>
                                                    <span class="designation"><?php echo $aboutsharpsotasaito['content']; ?></span>
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