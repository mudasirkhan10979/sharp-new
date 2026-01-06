<?php echo $header; ?>
<?php echo $menuinner; ?>
<div id="smooth-wrapper">
    <div id="smooth-content">
        <div class="main-container">
            <div class="news-event-detail">
                <div class="container">
                    <div class="back-to-listing">
                        <div class="container">
                            <div class="back-to-listing-inn">
                                <a class="default-back" href="<?php echo HTTPS_HOST; ?>news-events"><img
                                        src="<?php echo BASE_URL; ?>themes/sharp/assets/images/arrow-link.svg"
                                        alt=""><?php echo $back_label; ?></a>
                            </div>
                        </div>
                    </div>
                    <section>
                        <div class="news-event-detail-title">
                            <div class="container">
                                <div class="n-e-detail-title-inn">
                                    <?php if (!empty($newseventDetails['publish_date'])):?>
                                    <span class="n-e-d-date"><?php echo $newseventDetails['publish_date']; ?></span>
                                    <?php endif; ?>
                                    <div class="n-e-detail-title-sec">
                                        <?php if (!empty($newseventDetails['banner_title'])): ?>
                                        <div class="n-detail-title">
                                            <h2><?php echo $newseventDetails['banner_title']; ?></h2>
                                        </div>
                                        <?PHP endif; ?>
                                        <?PHP if (!empty($newseventDetails['short_description'])): ?>
                                        <div class="n-detail-shrt-txt">
                                            <p><?php echo $newseventDetails['short_description']; ?> </p>
                                        </div>
                                        <?PHP endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section>
                        <div class="news-event-detail-banner">
                            <div class="container">
                                <div class="n-e-detail-banner-inn">
                                    <?php if (!empty($newseventDetails['banner'])):?>
                                    <div class="n-e-d-banner-img">
                                        <img src="<?php echo $newseventDetails['banner']; ?>" alt="">
                                    </div>
                                    <?php endif; ?>
                                    <?PHP if (!empty($newseventDetails['description'])): ?>
                                    <div class="n-e-d-banner-text">
                                        <?php echo $newseventDetails['description']; ?>
                                    </div>
                                    <?PHP endif; ?>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section>
                        <div class="n-e-detail-middle-sec">
                            <div class="container">
                                <div class="n-e-d-middle-inner">
                                    <div class="ned-middle-cont">
                                        <div class="ned-middle-txt">
                                            <?php if (!empty($newseventDetails['middle_title'])):?>
                                            <h3><?php echo $newseventDetails['middle_title']; ?></h3>
                                            <?php endif; ?>
                                            <?php if (!empty($newseventDetails['middle_description'])):?>
                                            <?php echo $newseventDetails['middle_description']; ?>
                                            <?php endif; ?>
                                        </div>
                                        <?php if (!empty($newseventDetails['middle_image'])):?>
                                        <div class="ned-middle-img">
                                            <div class="ned-middle-img-inn">
                                                <img src="<?php echo $newseventDetails['middle_image']; ?>" alt="">
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- <section>
                        <div class="n-e-detail-end-sec">
                            <div class="container">
                                <div class="n-e-deatil-end-inn">
                                    <div class="ned-end-cont">
                                        <?php if (!empty($newseventDetails['second_middle_description'])):?>
                                        <?php echo $newseventDetails['second_middle_description']; ?>
                                        <?php endif; ?>
                                        <div class="ned-imgs">
                                            <?php if (!empty($newseventDetails['left_image'])):?>
                                            <img src="<?php echo $newseventDetails['left_image']; ?>" alt="">
                                            <?php endif; ?>
                                            <?php if (!empty($newseventDetails['right_image'])):?>
                                            <img src="<?php echo $newseventDetails['right_image']; ?>" alt="">
                                            <?php endif; ?>
                                        </div>
                                        <?php if (!empty($newseventDetails['last_description'])):?>
                                        <?php echo $newseventDetails['last_description']; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section> -->

                    <?php if (!empty($share_links)) { ?>
                    <section>
                        <div class="news-event-detail-socialshare">
                            <div class="container">
                                <div class="n-e-detail-sociashare-inn">
                                    <div class="ned-share">
                                        <span>
                                            <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/share-icon.svg"
                                                alt="">
                                            <?php echo $text_share; ?>
                                        </span>
                                    </div>
                                    <div class="ned-share-icon">
                                        <ul>
                                            <?php if (!empty($share_links['facebook'])) {?>
                                            <li><a href="<?php echo $share_links['facebook']; ?>" target="_blank"><img
                                                        src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/fb.svg"
                                                        alt=""></a></li>
                                            <?php } ?>
                                            <?php if (!empty($share_links['twitter'])) {?>
                                            <li><a href="<?php echo $share_links['twitter']; ?>" target="_blank"><img
                                                        src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/s_x.svg"
                                                        alt=""></a></li>
                                            <?php } ?>
                                            <?php if (!empty($share_links['linkedin'])) {?>
                                            <li><a href="<?php echo $share_links['linkedin']; ?>" target="_blank"><img
                                                        src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/s_insta.svg"
                                                        alt=""></a></li>
                                            <?php } ?>
                                            <?php if (!empty($share_links['youtube'])) {?>
                                            <li><a href="<?php echo $share_links['youtube']; ?>" target="_blank"><img
                                                        src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/yt.svg"
                                                        alt=""></a></li>
                                            <?php } ?>
                                            <?php if (!empty($share_links['whatsapp'])) {?>
                                            <li><a href="<?php echo $share_links['whatsapp']; ?>" target="_blank"><img
                                                        src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/whatsapp.svg"
                                                        alt=""></a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <?php } ?>
                </div>
            </div>
            <?php if(!empty ($relatednewevents)):?>
            <section>
                <div class="related-news-event-sec">
                    <div class="container">
                        <div class="related-news-event-inn">
                            <div class="container">
                                <div class="related-n-e-title-sec">
                                    <div class="related-ne-title">
                                        <h2><?php echo $text_related_news_events; ?></h2>
                                    </div>
                                    <div class="related-ne-link">
                                        <a href="<?php echo HTTPS_HOST; ?>news-events" class="btn-default"><span
                                                class="dw-btn"><?php echo $text_view_all; ?></span> <span><img
                                                    src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg"
                                                    alt=""></span></a>
                                    </div>
                                </div>
                                <div class="related-n-e-listing">
                                    <div class="related-news-list-inn">
                                        <?php foreach ($relatednewevents as $related_new):?>
                                        <div class="news-list-related-item">
                                            <div class="nl-related-item-inn">
                                                <div class="nl-related-item-img">
                                                    <img src="<?php echo $related_new['image'];?>"
                                                        alt="<?php echo $related_new['title']; ?>">
                                                </div>
                                                <div class="nl-related-item-cnt">
                                                    <span
                                                        class="nl-item-date"><?php echo $related_new['publish_date'];?></span>
                                                    <h3 class="nl-title"><?php echo $related_new['title'];?></h3>
                                                    <div class="pp-n-link">
                                                        <a href="<?php echo $related_new['href'];?>"
                                                            class="btn-default"><span
                                                                class="dw-btn"><?php echo $text_learn_more; ?></span>
                                                            <span><img
                                                                    src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg"
                                                                    alt=""></span></a>
                                                    </div>
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
            </section>
            <?php endif;?>
            <?php echo $footer; ?>