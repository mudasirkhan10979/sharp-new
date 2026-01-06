 <style>
     #subscription-success {
         padding: 10px 15px;
         background-color: #d4edda;
         border: 1px solid #c3e6cb;
         border-radius: 4px;
         color: #155724;
         margin-top: 10px;
     }
 </style>
 <style>
    .loader-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    .loader {
        border: 8px solid #f3f3f3;
        border-top: 8px solid #7a2a90;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
 <footer>
     <div class="container">
         <div class="footer-main-inn">
             <div class="footer-top">
                 <div class="footer-col-list">
                     <div class="about-list">
                         <h3><?php echo $text_about_footer; ?></h3>
                         <ul>
                             <?php if (!empty($footerMenus)) : ?>
                                 <?php foreach ($footerMenus as $menu) : ?>
                                     <li><a href="<?php echo HTTPS_HOST . htmlspecialchars($menu['url']); ?>"><?php echo ucfirst($menu['title']); ?></a></li>
                                 <?php endforeach; ?>
                             <?php endif; ?>
                         </ul>
                     </div>
                     <!-- <div class="category-list">
                            <h3>Tv/Audio</h3>
                            <ul>
                                <?php if (!empty($categories)) : ?>
                                    <?php foreach ($categories as $parent) : ?>
                                        <?php if ($parent['category_id'] == '9') : ?>
                                            <?php if (!empty($parent['children'])) : ?>
                                                <?php foreach ($parent['children'] as $child) : ?>
                                                     <?php
                                                        // Parent + child url
                                                        $child_url = HTTPS_HOST . $parent['seo_url'] . '/' . $child['seo_url'];
                                                        ?>
                                                    <li>
                                                        <a href="<?php echo $child_url; ?>">
                                                            <?php echo $child['title']; ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div> -->
                     <div class="appliance-list">
                         <h3><?php echo $text_consumer; ?></h3>
                         <ul>
                             <?php if (!empty($categories)) : ?>
                                 <?php foreach ($categories as $parent) : ?>
                                     <?php if ($parent['category_id'] == '35') : ?>
                                         <?php if (!empty($parent['children'])) : ?>
                                             <?php foreach ($parent['children'] as $child) : ?>
                                                 <?php
                                                    // Parent + child url
                                                    $child_url = HTTPS_HOST . $parent['seo_url'] . '/' . $child['seo_url'];
                                                    ?>
                                                 <li>
                                                     <a href="<?php echo $child_url; ?>">
                                                         <?php echo $child['title']; ?>
                                                     </a>
                                                 </li>
                                             <?php endforeach; ?>
                                         <?php endif; ?>
                                     <?php endif; ?>
                                 <?php endforeach; ?>
                             <?php endif; ?>
                         </ul>
                     </div>
                     <div class="solution-list">
                         <h3><?php echo $text_solution; ?></h3>
                         <ul>
                             <?php if (!empty($categories)) : ?>
                                 <?php foreach ($categories as $parent) : ?>
                                     <?php if ($parent['category_id'] == '34') : ?>
                                         <?php if (!empty($parent['children'])) : ?>
                                             <?php foreach ($parent['children'] as $child) : ?>
                                                 <?php
                                                    // Parent + child url
                                                    $child_url = HTTPS_HOST . $parent['seo_url'] . '/' . $child['seo_url'];
                                                    ?>
                                                 <li>
                                                     <a href="<?php echo $child_url; ?>">
                                                         <?php echo $child['title']; ?>
                                                     </a>
                                                 </li>
                                             <?php endforeach; ?>
                                         <?php endif; ?>
                                     <?php endif; ?>
                                 <?php endforeach; ?>
                             <?php endif; ?>
                         </ul>
                     </div>
                     <div class="tech-list">
                         <h3><?php echo $text_plasmacuster_technology; ?> </h3>
                         <ul>
                             <!-- <li><a href="#about-plasmacluster"><?php echo $text_plasmacuster; ?></a></li> -->
                              <li><a href="<?php echo HTTPS_HOST; ?>about-plasmacluster#about-brand"><?php echo $text_plasmacuster; ?></a></li>
                             <li><a href="<?php echo HTTPS_HOST . 'about-plasmacluster'; ?>"><?php echo $text_about_plasmacuster; ?></a></li>
                             <!-- <li><a href="#"><?php echo $text_awards; ?></a></li> -->
                             <li><a href="<?php echo HTTPS_HOST; ?>about-plasmacluster#certificates-section"><?php echo $text_awards; ?></a></li>
                         </ul>
                     </div>
                     <div class="support-list">
                         <h3><?php echo $text_support; ?></h3>
                         <ul>
                             <?php if (!empty($SupportMenus)) : ?>
                                 <?php foreach ($SupportMenus as $menu) : ?>
                                     <li><a href="<?php echo HTTPS_HOST . htmlspecialchars($menu['url']); ?>"><?php echo htmlspecialchars(ucfirst($menu['title'])); ?></a></li>
                                 <?php endforeach; ?>
                             <?php endif; ?>
                         </ul>
                     </div>
                 </div>
             </div>
             <div class="footer-middle">
                 <div class="row">
                     <div class="col-md-6">
                       <div class="footer-social">

                    <!-- Consumer Electronics -->
                    <div class="footer-social-cunsumer">
                        <h4><?php echo $text_consumer; ?></h4>
                        <ul>
                            <?php if (!empty($ce_facebook)): ?>
                                <li><a href="<?php echo $ce_facebook; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/facebook.svg" alt=""></a></li>
                            <?php endif; ?>
                            <?php if (!empty($ce_twitter)): ?>
                                <li><a href="<?php echo $ce_twitter; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/x.svg" alt=""></a></li>
                            <?php endif; ?>
                            <?php if (!empty($ce_linkedin)): ?>
                                <li><a href="<?php echo $ce_linkedin; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/linkedin.svg" alt=""></a></li>
                            <?php endif; ?>
                            <?php if (!empty($ce_instagram)): ?>
                                <li><a href="<?php echo $ce_instagram; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/insta.svg" alt=""></a></li>
                            <?php endif; ?>
                            <?php if (!empty($ce_youtube)): ?>
                                <li><a href="<?php echo $ce_youtube; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/y-tube.svg" alt=""></a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <!-- Business Solutions -->
                    <div class="footer-social-b-solution">
                    <h4><?php echo $text_solution; ?></h4>
                       <ul>
                        <?php if (!empty($bs_facebook)): ?>
                            <li><a href="<?php echo $bs_facebook; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/facebook.svg" alt=""></a></li>
                        <?php endif; ?>
                        <?php if (!empty($bs_twitter)): ?>
                            <li><a href="<?php echo $bs_twitter; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/x.svg" alt=""></a></li>
                        <?php endif; ?>
                        <?php if (!empty($bs_linkedin)): ?>
                            <li><a href="<?php echo $bs_linkedin; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/linkedin.svg" alt=""></a></li>
                        <?php endif; ?>
                        <!-- <?php if (!empty($bs_instagram)): ?>
                            <li><a href="<?php echo $bs_instagram; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/insta.svg" alt=""></a></li>
                        <?php endif; ?> -->
                        <?php if (!empty($bs_youtube)): ?>
                            <li><a href="<?php echo $bs_youtube; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/y-tube.svg" alt=""></a></li>
                        <?php endif; ?>
                    </ul>
                    </div>
                </div>

                     </div>
                     <div class="col-md-6">
                         <div class="footer-subscribe">
                             <div class="f-sub-form">
                                 <h4><?php echo $text_subscribe_now; ?></h4>
                                 <form class="row g-3" id="subscription-form">
                                     <div class="col-auto">
                                         <input type="text" name="name" class="form-control" placeholder="<?php echo $text_your_name; ?>">
                                         <div class="text-danger" id="error-name"></div>
                                     </div>
                                     <div class="col-auto">
                                         <input type="email" name="email" class="form-control" placeholder="<?php echo $text_your_email; ?>">
                                         <div class="text-danger" id="error-email"></div>
                                     </div>
                                     <div class="col-auto">
                                         <button type="submit" class="subscrib-btn btn-default"><?php echo $text_subscribe; ?> <span><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span></button>
                                         <div class="col-12 mt-3">
                                             <div id="subscription-success" class="text-success" style="display: none;"></div>
                                         </div>
                                     </div>
                                 </form>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="footer-copyright">
                 <div class="f-copyright-inn">
                     <div class="footer-logo">
                         <a href="#"><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/header_logo.svg" alt=""></a>
                     </div>
                     <div class="footer-quicklinks">
                         <ul>
                             <?php if (!empty($footerLegalsMenus)) : ?>
                                 <?php foreach ($footerLegalsMenus as $menu) : ?>
                                     <?php
                                        $url = HTTPS_HOST . htmlspecialchars($menu['url']);
                                        $title = ucfirst($menu['title']);
                                        $target = (strtolower(trim($menu['title'])) === 'terms and conditions') ? ' target="_blank"' : '';
                                        ?>
                                     <li><a href="<?php echo $url; ?>" <?php echo $target; ?>><?php echo $title; ?></a></li>
                                 <?php endforeach; ?>
                             <?php endif; ?>
                         </ul>
                     </div>
                     <div class="f-copyright-text">
                         <p><?php echo $text_copyrights; ?></p>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </footer>
 </div>
 </div>
 </div>
 <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
 <script src="<?php echo BASE_URL; ?>themes/sharp/bootstrap/js/bootstrap.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 <script src='https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js'></script>
 <script src='https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js'></script>
 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
 <script src="<?php echo BASE_URL; ?>themes/sharp/assets/js/jquery.simpleSocialShare.min.js"></script>
 <script src="<?php echo BASE_URL; ?>themes/sharp/assets/js/custom.js"></script>
 <!-- <script src="<?php echo BASE_URL; ?>themes/sharp/assets/js/jquery.js"></script> -->
 <script>
$(document).ready(function() {
    $('#subscription-form').on('submit', function(e) {
        e.preventDefault();
        $('#subscription-success').hide().empty();
        $('#error-name, #error-email').empty();
        $('#loader').fadeIn(200);
        $.ajax({
            url: '<?php echo HTTPS_HOST; ?>footer/subscribe',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(json) {
                $('#loader').fadeOut(200);
                if (json.error) {
                    if (json.error.name) {
                        $('#error-name').html(json.error.name);
                    }
                    if (json.error.email) {
                        $('#error-email').html(json.error.email);
                    }
                }
                if (json.success) {
                    $('#subscription-success')
                        .html(json.success)
                        .fadeIn(300)
                        .delay(4000)
                        .fadeOut(500);
                    $('#subscription-form')[0].reset();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $('#loader').fadeOut(200);
                $('#subscription-success')
                    .html('An unexpected error occurred. Please try again.')
                    .fadeIn()
                    .delay(4000)
                    .fadeOut();
                console.error(thrownError + "\n" + xhr.statusText + "\n" + xhr.responseText);
            }
        });
    });
});
</script>
 </body>
 </html>
 <div id="loader" class="loader-overlay" style="display:none;">
   <div class="loader"></div>
</div>