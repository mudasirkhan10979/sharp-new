<?php echo $header; ?>
<style>
    /* .cards:hover {
    background-color: #1281b6;
    opacity: 0.5;
} */
    .cards:hover img {
        transform: scale(1.5);
        transition: transform 0.3s ease;
    }
</style>
<script>
    $('.heading').html('<? echo $breadcrumbs[0]["text"]; ?>');
</script>
<div class="main-panel main-area">
    <div class="my-box "> </div>
    <div class="content-wrapper dashboardwraper01">
        <div class="row" id="proBanner">
            <div class="col-12">
                <span class="d-flex align-items-center purchase-popup">
                    <i class="mdi mdi-close" id="bannerClose"></i>
                </span>
            </div>
        </div>
        <div class="d-xl-flex justify-content-between align-items-start">
            <h2 class="mb-2" style="color: #ffff;"> Welcome
                <? echo $full_name; ?>!
            </h2>
        </div>
      <div class="row cards-section"> 

                <?php if (!$viewer) : ?>
                <div class="col-xl-2 col-lg-6 col-sm-6 ">
                    <div class="cards">
                        <div class="card-body text-center">
                            <a href="<?php echo $product; ?>">
                             <img src="/themes/admin/images/file-icons/media.svg" alt="image">
                                <p class=" feature-heading">Product</p>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?> 

            <?php if (!$viewer) : ?>
                <div class="col-xl-2 col-lg-6 col-sm-6 ">
                    <div class="cards">
                        <div class="card-body text-center">
                            <a href="<?php echo $service_centers; ?>">
                             <img src="/themes/admin/images/file-icons/reports.png" alt="image">
                                <p class=" feature-heading">Service Centers</p>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?> 
             
             <?php if (!$viewer) : ?>
                <div class="col-xl-2 col-lg-6 col-sm-6 ">
                <div class="cards">
                    <div class="card-body text-center">
                        <a href="<?php echo $casestudy; ?>">
                            <img src="/themes/admin/images/file-icons/business.svg" alt="image">
                            <p class=" feature-heading">Case Study</p>
                        </a>
                    </div>
                </div>
            </div> 
               <div class="col-xl-2 col-lg-6 col-sm-6 ">
                    <div class="cards">
                        <div class="card-body text-center">
                            <a href="<?php echo $careers; ?>">
                                <img src="/themes/admin/images/file-icons/career-image.png" alt="image">
                                <p class=" feature-heading">Careers</p>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-6 col-sm-6 ">
                    <div class="cards">
                        <div class="card-body text-center">
                            <a href="<?php echo $enquiries; ?>">
                                <img src="/themes/admin/images/file-icons/career.svg" alt="image">
                                <p class=" feature-heading">Enquiries</p>
                            </a>
                        </div>
                    </div>
                </div> 

                <div class="col-xl-2 col-lg-6 col-sm-6 ">
                    <div class="cards">
                        <div class="card-body text-center">
                            <a href="<?php echo $setting; ?>">
                                <img src="/themes/admin/images/file-icons/settings.svg" alt="image">
                                <p class=" feature-heading">Settings</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div> 
      <?php endif; ?>
    <footer class="footer mt-5">
        <div class="footer-inner-wraper">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                <p class="text-muted d-block text-center text-sm-left d-sm-inline-block" style="color: #ffff !important;"> Copyright <?php echo date('Y'); ?> <span class="c890222"> </span></p>
            </div>
        </div>
    </footer>
    </div>
</div>
<?php echo $footer; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.0/chart.min.js"></script>
<script src="/themes/admin/vendors/chart.js/Chart.min.js"></script>
<script src="/themes/admin/vendors/jquery-circle-progress/js/circle-progress.min.js"></script>