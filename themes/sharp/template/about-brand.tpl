<?= $header ?>
<?= $menuinner ?>
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
                                        <span><?php echo $banner['title']; ?> </span>
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
            <?php if (!empty($blockbrandaboutus) && !empty($blockimageaboutus)): ?>
                <section>
                    <div class="about-brand">
                        <div class="container">
                            <div class="about-brand-inn">
                                <div class="about-brand-contant">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="about-brand-img">
                                                <img src="<?php echo BASE_URL . 'uploads/image/blockimages/' . $blockimageaboutus['image']; ?>" alt="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="about-brand-txt">
                                                <h2><?php echo $blockbrandaboutus['title']; ?></h2>
                                                <div class="a-b-text">
                                                    <?php echo $blockbrandaboutus['content']; ?>
                                                </div>
                                                <div class="a-b-link">
                                                    <a href="<?php echo HTTPS_HOST; ?>about-sharp" class="btn-default"><?php echo $text_learn_more; ?> <span><img src="<?= BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span></a>
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
            <?php if (!empty($blocksustainabilityaboutbrandpage) && !empty($blockimagesustainability)): ?>
                <section>
                    <div class="brand-sustainability">
                        <div class="container">
                            <div class="brand-sustain-inner" style="background: url('<?= BASE_URL; ?>themes/sharp/assets/imgs/2640.png');">
                                <div class="brand-sustain-title">
                                    <div class="b-sustain-title-inn">
                                        <h2><?php echo $blocksustainabilityaboutbrandpage['title']; ?></h2>
                                        <?php echo $blocksustainabilityaboutbrandpage['content']; ?>
                                    </div>
                                </div>
                                <div class="brand-sustain-img">
                                    <div class="b-sustain-img-inn">
                                        <img src="<?php echo BASE_URL . 'uploads/image/blockimages/' . $blockimagesustainability['image']; ?>" alt="">
                                    </div>
                                </div>
                                <div class="b-sustain-link-wrapper">
                                    <div class="b-sustain-link">
                                        <a href="https://global.sharp/corporate/eco/" target="_blank" class="btn-default">
                                            <?php echo $text_discover_sustainability; ?>
                                            <span><img src="<?= BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span>
                                        </a>
                                    </div>
                                    <div class="b-sustain-link">
                                        <a href="https://global.sharp/corporate/eco/report/" target="_blank" class="btn-default">
                                            <?php echo $text_read_sustainability_reports; ?> 
                                            <span><img src="<?= BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
            <section>
                <div class="csr-compliance">
                    <div class="container">
                        <div class="csr-comliance-inner">
                            <div class="csr-compliance-content">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="csr-cmp-title-sec">
                                            <div class="csr-cmp-title">
                                                <h2><?php echo $text_csr_compliance; ?></h2>
                                            </div>
                                            <div class="csr-cmp-img">
                                                <div class="csr-cmp-img-inn">
                                                    <img src="<?= BASE_URL; ?>uploads/image/blockimages/<?= $blockimageenviromentalaboutbrand['image']; ?>" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="csr-cmp-accordian">
                                            <div class="csr-cmp-accordian-inn">
                                                <div class="accordion" id="accordionExample">
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingOne">
                                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                                <?php echo $blockenvironmentalpolicy['title']; ?>
                                                            </button>
                                                        </h2>
                                                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <?php echo $blockenvironmentalpolicy['content']; ?>
                                                                <a class="btn-default"
                                        href="https://global.sharp/corporate/eco/environment/vision/" target="_blank"><?php echo $text_read_more; ?>
                                        <span><img src="<?php echo BASE_URL; ?>themes/sharp/assets/images/btn-icon.svg"
                                                alt=""></span></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingTwo">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                                <?php echo $blockcsrenvironmentalinitiatives['title']; ?>
                                                            </button>
                                                        </h2>
                                                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <?php echo $blockcsrenvironmentalinitiatives['content']; ?>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <!-- <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingThree">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                                <?php echo $blockcertificationbrandpage['title']; ?>
                                                            </button>
                                                        </h2>
                                                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <?php echo $blockcertificationbrandpage['content']; ?>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <!-- <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingFour">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                                <?php echo $blockeventscalendar['title']; ?>
                                                            </button>
                                                        </h2>
                                                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <?php echo $blockeventscalendar['content']; ?>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>
            <section>
                <div class="container">
                    <div class="a-brand-news">
                        <div class="our-news">
                            <div class="container">
                                <div class="our-news-inn">
                                    <div class="our-news-title">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="our-news-header">
                                                    <h2><?php echo $text_our_news; ?></h2>
                                                    <?php echo $news_desc;?>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="our-news-link">
                                                    <a href="<?php echo HTTPS_HOST; ?>news-events"><?php echo $text_learn_more; ?> <span><img src="<?= BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="our-news-listing">
                                        <div class="our-news-list-inn">
                                            <?php if (!empty($categories)) { ?>
                                                <ul class="nav nav-tabs" id="newsEventsTab" role="tablist">
                                                    <?php foreach ($categories as $index => $category) { ?>
                                                        <li class="nav-item" role="presentation">
                                                            <button class="nav-link <?php echo $index === 0 ? 'active' : ''; ?>"
                                                                id="category-<?php echo $category['ne_category_id']; ?>-tab"
                                                                data-bs-toggle="tab"
                                                                data-bs-target="#category-<?php echo $category['ne_category_id']; ?>"
                                                                type="button"
                                                                role="tab"
                                                                aria-controls="category-<?php echo $category['ne_category_id']; ?>"
                                                                aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>">
                                                                <?php echo $category['title']; ?>
                                                            </button>
                                                        </li>
                                                    <?php } ?>
                                                </ul>

                                                <div class="tab-content" id="newsEventsTabContent">
                                                    <?php foreach ($categories as $index => $category) { ?>
                                                        <div class="tab-pane fade <?php echo $index === 0 ? 'show active' : ''; ?>"
                                                            id="category-<?php echo $category['ne_category_id']; ?>"
                                                            role="tabpanel"
                                                            aria-labelledby="category-<?php echo $category['ne_category_id']; ?>-tab">
                                                            <div class="tab-news-list">
                                                                <div class="tab-news-list-inn">
                                                                    <?php if (!empty($category_items[$category['ne_category_id']])) { ?>
                                                                        <?php foreach ($category_items[$category['ne_category_id']] as $item) { ?>
                                                                            <div class="news-list-item">
                                                                                <div class="news-item-inn">
                                                                                    <div class="news-item-img">
                                                                                        <img src="<?= BASE_URL; ?>uploads/image/newsevents/<?= $item['thumbnail']; ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                                                                                    </div>
                                                                                    <div class="news-item-text">
                                                                                        <h4><?php echo $item['title']; ?></h4>
                                                                                        <div class="news-date">
                                                                                            <span><?php echo date('d M, Y', strtotime($item['publish_date'])); ?></span>
                                                                                        </div>
                                                                                        <div class="news-detail-link">
                                                                                            <a href="<?php echo HTTPS_HOST; ?>news-events/<?php echo $item['seo_url']; ?>"><?php echo $text_learn_more; ?> <span><img src="<?= BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span></a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    <?php } else { ?>
                                                                        <div class="col-12 text-center py-5">
                                                                            <p><?php echo $text_no_items; ?></p>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            <?php } else { ?>
                                                <div class="col-12">
                                                    <div class="alert alert-warning text-center no-record"><?php echo $text_no_record; ?></div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php if (!empty($blockcareersbrandpage) && !empty($blockimagecareersaboutbrand)): ?>
                <section>
                    <div class="brand-career">
                        <div class="container">
                            <div class="about-brand-inn">
                                <div class="about-brand-contant">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="about-brand-txt">
                                                <h2><?php echo $blockcareersbrandpage['title']; ?></h2>
                                                <div class="a-b-text">
                                                    <?php echo $blockcareersbrandpage['content']; ?>
                                                </div>
                                                <div class="a-b-link">
                                                    <a href="<?php echo HTTPS_HOST; ?>careers" class="btn-default"> <?php echo $text_apply_now; ?>  <span><img src="<?= BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="about-brand-img">
                                                <img src="<?= BASE_URL; ?>uploads/image/blockimages/<?= $blockimagecareersaboutbrand['image']; ?>" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
            <?= $footer ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var tabEl = document.querySelectorAll('button[data-bs-toggle="tab"]');
                    tabEl.forEach(function(tab) {
                        tab.addEventListener('shown.bs.tab', function(event) {
                            var target = event.target.getAttribute('data-bs-target');
                            window.location.hash = target;
                        });
                    });
                    if (window.location.hash) {
                        var hash = window.location.hash;
                        var triggerEl = document.querySelector('[data-bs-target="' + hash + '"]');
                        if (triggerEl) {
                            var bsTab = new bootstrap.Tab(triggerEl);
                            bsTab.show();
                        }
                    }
                });
            </script>


