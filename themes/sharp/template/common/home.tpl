<?php echo $header; ?>
<?php echo $menu; ?>
<style>
    .home-banner div {
    height: 100%;
}
.home-banner div .h-banner-text {
    height: auto;
}
</style>
<div id="smooth-wrapper">
<div id="smooth-content">
<div class="main-container">
<?php if (isset($homeSlider)): ?>
  <section>
        <div class="home-banner owl-carousel">
           <?php foreach ($homeSlider as $slider): ?>
            <div class="h-banner-inn">
                <?php if ($slider['content_type'] === 'video' && !empty($slider['video_url'])): ?>
                    <div class="h-banner-video">
                        <div class="h-b-video-inn">
                             <video autoplay loop muted>
                                <source src="<?php echo $slider['video_url']; ?>" type="video/mp4">
                            </video>
                        </div>
                    </div>
                    <?php else: ?>
                        <img src="<?php echo !empty($slider['image']) ? BASE_URL . 'uploads/image/sliders/' . $slider['image'] : BASE_URL . 'uploads/default_banner.jpg'; ?>" loading="lazy" alt="<?php echo $slider['title']; ?>">
                    <?php endif; ?>
                    <div class="h-banner-text">
                        <div class="container">
                            <div class="h-b-text-inn">
                                <h1 class="h-b-title">
                                    <span><?php echo $slider['title']; ?></span>
                                    <span class="redline"></span>
                                    <span><?php echo $slider['second_title']; ?></span>
                                </h1>
                                 <?php echo html_entity_decode($slider['short_description']); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>
    <!-- <div class="home-slider">
        <div class="home-slider-inn owl-carousel">
            <div class="home-slider-item">
                <div class="hm-slider-item-inn">
                    <img src="/themes/sharp/assets/imgs/download-banner.png" alt="">
                </div>
            </div>
            <div class="home-slider-item">
                <div class="hm-slider-item-inn">
                    <img src="/themes/sharp/assets/imgs/user-menual-banner.png" alt="">
                </div>
            </div>
            <div class="home-slider-item">
                <div class="hm-slider-item-inn">
                    <img src="/themes/sharp/assets/imgs/ne-d-banner.png" alt="">
                </div>
            </div>
        </div>
    </div> -->
        <section>
            <div class="feature-products">
                <div class="container">
                    <div class="f-products-inn">
                        <div class="f-pro-tabs">
                            <div class="row">
                                <div class="col-lg-5 col-md-12">
                                    <div class="f-pro-title">
                                        <h2><?php echo $text_featured_products; ?></h2>
                                    </div>
                                </div>
                                <div class="tab-cont-listing">
                                    <?php if (!empty($products)): ?>
                                        <div class="tab-cont-inn owl-carousel">
                                            <?php foreach ($products as $product): ?>
                                                <?php if (!empty($product['name'])): ?>
                                                    <div class="t-list-item">
                                                        <a href="<?= HTTPS_HOST . 'product/' . $product['seo_url']; ?>" class="t-list-item-link" style="text-decoration: none;">
                                                            <div class="t-list-item-inn">
                                                                <div class="t-list-item-img img-animate">
                                                                 <?php if(isset($product['is_new']) && $product['is_new'] == '1'): ?>
                                                                    <div class="ribbon ribbon-top-left"><span><?php echo $text_text_new; ?></span></div>
                                                                  <?php endif; ?>
                                                                   <img src="<?= !empty($product['featured_image']) ? BASE_URL . 'uploads/image/product/' . $product['featured_image'] : BASE_URL . 'uploads/defualt-profile.png'; ?>" loading="lazy" alt="<?= htmlspecialchars($product['name']); ?>">
                                                                </div>
                                                                <div class="t-list-item-cont">
                                                                    <h4><?= $product['name']; ?></h4>
                                                                    <?= !empty($product['model']) ? '<p>' . htmlspecialchars($product['model']) . '</p>' : '' ?>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="no-products-message">
                                         <p>   <?php echo $text_no_featured_products_found; ?> </p>
                                            <!-- <p>No featured products available.</p> -->
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
       <section>
            <div class="services-sec">
                <div class="container">
                    <div class="services-sec-inn">
                        <div class="services-listing">
                            <?php if (!empty($consumer_electronics_block) && !empty($consumer_electronics_image)): ?>
                            <div class="service-item" style="background: url(<?php echo !empty($consumer_electronics_image['image']) ? BASE_URL . 'uploads/image/blockimages/' . $consumer_electronics_image['image'] : BASE_URL . 'uploads/default_banner.jpg'; ?>);">
                                <div class="service-item-inn">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="service-item-text">
                                                <h3><?php echo $consumer_electronics_block['title']; ?></h3>
                                                <?php echo $consumer_electronics_block['content']; ?>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="service-item-link">
                                                <a href="<?php echo HTTPS_HOST . 'appliances'; ?>"><?php echo $text_learn_more; ?> <span><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           <?php endif; ?>
                          <?php if (!empty($block_businesssolutions) && !empty($block_image_business_solutions)): ?>
                           <div class="service-item" style="background-image: url('<?php echo !empty($block_image_business_solutions['image']) ? BASE_URL . 'uploads/image/blockimages/' . $block_image_business_solutions['image'] . '?v=' . time() : BASE_URL . 'uploads/default_banner.jpg'; ?>');">
                               <div class="service-item-inn">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="service-item-text">
                                                <h3><?php echo $block_businesssolutions['title']; ?></h3>
                                                <?php echo $block_businesssolutions['content']; ?>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="service-item-link">
                                                <a href="<?php echo HTTPS_HOST . 'business-solutions'; ?>"><?php echo $text_learn_more; ?> <span><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="popular-category">
                <div class="container">
                    <div class="popular-cate-inner">
                        <div class="popular-cate-title">
                            <p class="subheading"><?php echo $text_popular; ?></p>
                            <h2><?php echo $text_categories; ?></h2>
                        </div>
                        <div class="popular-cat-listing">
                            <div class="popular-cat-list-inn">
                                <div class="p-category-listing">
                                     <?php if (!empty($categories)): ?>
                                      <?php foreach ($categories as $category): ?>
                                          <?php if (!empty($category['image'])): ?>
                                             <?php
                                                    $full_url = '';
                                                    if (!empty($category['parent_seo_url'])) {
                                                        $full_url .= $category['parent_seo_url'] . '/';
                                                    }
                                                    $full_url .= ltrim($category['seo_url'], '/');
                                                ?>
                                              <a href="<?php echo $full_url; ?>" class="p-cat-list-item">
                                              <div class="">
                                                  <div class="p-list-item-inn">
                                                     <img src="<?php echo !empty($category['feature_image']) ? BASE_URL . 'uploads/image/categories/' . $category['feature_image'] : (!empty($category['image']) ? BASE_URL . 'uploads/image/categories/' . $category['image'] : BASE_URL . 'uploads/defualt-profile.png'); ?>" loading="lazy" alt="<?php echo $category['title']; ?>">
                                                      <!-- <img src="<?php echo BASE_URL ?>uploads/image/categories/<?php echo $category['image']; ?>" alt="<?php echo $category['title']; ?>"> -->
                                                  </div>
                                              </div>
                                              <?php if (!empty($category['title'])): ?>
                                              <div class="pop-cat-title">
                                                    <h3><?php echo $category['title']; ?></h3>
                                              </div>
                                              <?php endif; ?>
                                              </a>
                                          <?php endif; ?>
                                      <?php endforeach; ?>
                                  <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
       <section>
          <div class="our-news">
              <div class="container">
                  <div class="our-news-inn">
                      <div class="our-news-title">
                          <div class="row">
                              <div class="col-md-8">
                                  <div class="our-news-header">
                                      <h2><?php echo $text_our_news; ?></h2>
                                         <?php echo $news_desc; ?>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="our-news-link">
                                      <a href="<?php echo BASE_URL; ?>news-events"><?php echo $text_learn_more; ?> <span><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span></a>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="our-news-listing">
                          <div class="our-news-list-inn">
                              <ul class="nav nav-tabs" id="myTab" role="tablist">
                                  <?php if (!empty($news_categories)): ?>
                                      <?php foreach ($news_categories as $index => $news_category): ?>
                                          <li class="nav-item" role="presentation">
                                              <button
                                                  class="nav-link<?php echo $index === 0 ? ' active' : ''; ?>"
                                                  id="news-cat-tab-<?php echo htmlspecialchars($news_category['category_id']); ?>"
                                                  data-bs-toggle="tab"
                                                  data-bs-target="#news-cat-<?php echo htmlspecialchars($news_category['category_id']); ?>"
                                                  type="button"
                                                  role="tab"
                                                  aria-controls="news-cat-<?php echo htmlspecialchars($news_category['category_id']); ?>"
                                                  aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>">
                                                  <?php echo htmlspecialchars($news_category['title']); ?>
                                              </button>
                                          </li>
                                      <?php endforeach; ?>
                                  <?php endif; ?>
                              </ul>
                              <div class="tab-content" id="myTabContent">
                                  <?php if (!empty($news_categories)): ?>
                                      <?php foreach ($news_categories as $index => $news_category): ?>
                                          <?php
                                            $catId = $news_category['category_id'] ?? null;
                                            $categoryNews = [];
                                            foreach ($news as $newsGroup) {
                                                if (($newsGroup['category_id'] ?? null) == $catId) {
                                                    $categoryNews = $newsGroup['news'] ?? [];
                                                    break;
                                                }
                                            }
                                            ?>
                                          <div class="tab-pane fade<?= $index === 0 ? ' show active' : '' ?>"
                                              id="news-cat-<?= htmlspecialchars($catId) ?>"
                                              role="tabpanel"
                                              aria-labelledby="news-cat-tab-<?= htmlspecialchars($catId) ?>">
                                              <div class="tab-news-list">
                                                  <div class="tab-news-list-inn">
                                                      <?php if (!empty($categoryNews)): ?>
                                                          <?php foreach ($categoryNews as $newsItem): ?>
                                                              <div class="news-list-item">
                                                                  <div class="news-item-inn">
                                                                      <div class="news-item-img">
                                                                          <img src="<?= !empty($newsItem['image']) ? '../uploads/image/newsevents/' . $newsItem['image'] : BASE_URL . 'themes/sharp/assets/imgs/n1.png'; ?>" loading="lazy" alt="<?= $newsItem['title'] ?? 'News Image' ?>">
                                                                      </div>
                                                                      <div class="news-item-text">
                                                                          <h4><?= $newsItem['title'] ?? '' ?></h4>
                                                                          <div class="news-date">
                                                                              <span><?= !empty($newsItem['publish_date']) ? date('d M, Y', strtotime($newsItem['publish_date'])) : '' ?></span>
                                                                          </div>
                                                                          <div class="news-detail-link">
                                                                              <a href="<?= $newsItem['seo_url'] ?? '#' ?>"><?php echo $text_learn_more; ?> <span><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span></a>
                                                                          </div>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                          <?php endforeach; ?>
                                                      <?php else: ?>
                                                              <div class="col-12"> <div class="alert alert-warning text-center no-record"><?php echo $text_no_record; ?></div></div>
                                                      <?php endif; ?>
                                                  </div>
                                              </div>
                                          </div>
                                      <?php endforeach; ?>
                                  <?php endif; ?>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </section>
        <section>
            <div class="support-services">
                <div class="container">
                    <div class="support-services-inn">
                        <?php if (!empty($support_service_block)):?>
                        <div class="support-title-sec">
                            <h2><?php echo $support_service_block['title']; ?></h2>
                             <?php echo $support_service_block['content']; ?>
                        </div>
                        <?php endif; ?>
                        <div class="support-listing">
                            <div class="support-list-inn">
                                <?php if (!empty($product_support_block)):?>
                                <div class="support-item">
                                    <div class="support-item-inn">
                                        <div class="support-item-icon">
                                            <div class="s-item-icon-inn">
                                                <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/ps.png" alt="">
                                            </div>
                                        </div>
                                        <div class="support-item-text">
                                            <h4><?php echo $product_support_block['title']; ?></h4>
                                            <?php echo $product_support_block['content']; ?>
                                        </div>
                                        <div class="support-item-link">
                                            <a href="<?php echo HTTPS_HOST . 'contact-us'; ?>"><?php echo $text_learn_more; ?> <span><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span></a>
                                        </div>
                                    </div>
                                </div>
                                 <?php endif; ?>
                                 <?php if (!empty($need_help_chat_block)): ?>
                                <!-- <div class="support-item">
                                    <div class="support-item-inn">
                                        <div class="support-item-icon">
                                            <div class="s-item-icon-inn">
                                                <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/chat-dots.png" alt="">
                                            </div>                                            
                                        </div>
                                        <div class="support-item-text">
                                            <h4><?php echo $need_help_chat_block['title']; ?></h4>
                                             <?php echo $need_help_chat_block['content']; ?>
                                        </div>
                                        <div class="support-item-link">
                                            <a href="#"><?php echo $text_learn_more; ?> <span><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span></a>
                                        </div>
                                    </div>
                                </div> -->
                                <?php endif; ?>
                                <?php if (!empty($customer_service_center_block)):?>
                                <div class="support-item">
                                    <div class="support-item-inn">
                                        <div class="support-item-icon">
                                            <div class="s-item-icon-inn">
                                                <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/c_s.png" alt="">
                                            </div>                                            
                                        </div>
                                        <div class="support-item-text">
                                            <h4><?php echo $customer_service_center_block['title']; ?></h4>
                                             <?php echo $customer_service_center_block['content']; ?>
                                        </div>
                                        <div class="support-item-link">
                                            <a href="<?php echo HTTPS_HOST . 'service-centers'; ?>"><?php echo $text_learn_more; ?> <span><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span></a>
                                        </div>
                                    </div>
                                </div>
                               <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="join-us">
                <div class="container">
                    <div class="join-us-inn">
                        <div class="join-us-list">
                            <?php if (!empty($careers_image) && !empty($blocks_careers_block)): ?>
                            <div class="join-us-item" style="background: url(<?php echo BASE_URL . 'uploads/image/blockimages/' . $careers_image['image']; ?>);">
                                <div class="j-item-inn">
                                    <div class="j-item-txt">
                                        <h3><?php echo $blocks_careers_block['title']; ?></h3>
                                       <?php echo $blocks_careers_block['content']; ?>
                                    </div>
                                    <div class="j-item-link">
                                        <a href="/careers"><span class="dw-btn"><?php echo $text_learn_more; ?></span> <span><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span></a>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($joinus_career_images) && !empty($join_our_team_block)): ?>
                            <div class="join-us-item" style="background: url(<?php echo BASE_URL . 'uploads/image/blockimages/' . $joinus_career_images['image']; ?>);">
                                <div class="j-item-inn">
                                    <div class="j-item-txt">
                                        <h3><?php echo $join_our_team_block['title']; ?></h3>
                                        <?php echo $join_our_team_block['content']; ?>
                                    </div>
                                    <div class="j-item-link">
                                        <a href="#"><span class="dw-btn"><?php echo $text_learn_more; ?></span> <span><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span></a>
                                    </div>
                                </div>
                            </div>
                           <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php echo $footer;?>