<style>
    /* Add this CSS to your stylesheet */
    .nav-item:hover .nav-link {
        transform: scale(1.7);
        /* You can adjust the scale factor */
        transition: transform 0.3s ease;
        /* You can adjust the transition duration and timing function */
    }
    /* Add this CSS to your stylesheet */
    .nav-item:not(.active) .menuright {
        /*    display: none;*/
    }
    a.navbar-brand.brand-logo img {
        width: 100%;
    }
</style>
<script src="https://unpkg.com/feather-icons"></script>
<li style="padding: 0 20px;"><a class="navbar-brand brand-logo" href="<?php echo $home; ?>" title="Sharp">
        <img src="/themes/admin/images/cmsloginlogo.png" alt="Sharp"/> <?php echo $viewer; ?></a></li>
    <li class="nav-item">
        <div class="nav-link">
            <a href="<?php echo $home; ?>">
                <span class="icon-bg_drop">
                    <i class="fa fa-th-large menuIcon" aria-hidden="true"></i>
                    Dashboard
                </span>
            </a>
        </div>
    </li>
 <li class="nav-item">
    <div class="nav-link" title="CMS">
        <span class="icon-bg">CMS</span>
        <i class="fa fa-cube menuIcon" aria-hidden="true"></i>
    </div>
    <div class="menuright">
        <ul>
            <?php if ($user->hasPermission('access', 'sliders')) : ?>
                <li title="Home Slider">
                    <a href="<?php echo $home_slider; ?>">
                        <i class="fa fa-home" aria-hidden="true"></i>
                        Home Slider
                    </a>
                </li>
            <?php endif; ?>
          <?php if ($user->hasPermission('access', 'pages')) : ?>
                <li title="CMS Pages">
                    <a href="<?php echo $pages; ?>">
                        <i class="fa fa-cube"></i>CMS Pages
                    </a>
                </li>
            <?php endif; ?>
             <?php if ($user->hasPermission('access', 'frontmenu')) : ?>
                <li title="Front Menu">
                    <a href="<?php echo $frontmenu; ?>">
                        <i class="fa fa-bars"></i> Front Menu
                    </a>
                </li>
            <?php endif; ?>
            
            <?php if ($user->hasPermission('access', 'blocks')) : ?>
                <li title="HTML Blocks">
                    <a href="<?php echo $blocks; ?>">
                        <i class="fa fa-bold"></i>HTML Blocks
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($user->hasPermission('access', 'blockimages')) : ?>
                <li title="Block images">
                    <a href="<?php echo $blockimages; ?>">
                        <i class="fa fa-bold"></i>Block images
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($user->hasPermission('access', 'banner')) : ?>
                 <li title="Banner">
				<a href="<?php echo $banner; ?>">
					<i class="fa fa-picture-o"></i>Banners
				</a>
			</li> 
            <?php endif; ?>
        </ul>
    </div>
</li> 

<?php if ($user->hasPermission('access', 'sustainablepartner')) : ?>
    <li class="nav-item">
        <div class="nav-link" title="Sustainable Partners">
            <a href="<?php echo $sustainablepartner; ?>">
                <span class="icon-bg_drop">Sustainable Partners</span>
                <i class="fa fa-users menuIcon" aria-hidden="true"></i>
            </a>
        </div>
    </li>
<?php endif; ?>

<?php if ($user->hasPermission('access', 'faqs')) : ?>
    <li class="nav-item">
        <div class="nav-link" title="FAQs">
            <a href="<?php echo $faqs; ?>">
                <span class="icon-bg_drop">FAQs</span>
                <i class="fa fa-question-circle menuIcon" aria-hidden="true"></i>
            </a>
        </div>
    </li>
<?php endif; ?>
<?php if ($user->hasPermission('access', 'newsletters')) : ?>
  <li class="nav-item">
        <div class="nav-link" title="Newsletters">
            <a href="<?php echo $newsletters; ?>">
                <span class="icon-bg nodropdown">Newsletters</span>
                <i class="fa fa-newspaper-o menuIcon" aria-hidden="true"></i>
            </a>
        </div>
    </li>
<?php endif; ?>

<?php if ($user->hasPermission('access', 'certificatesandresearch')) : ?>
  <li class="nav-item"> 
        <div class="nav-link" title="Certificates & Research">
            <a href="<?php echo $certificatesandresearch; ?>">
                <span class="icon-bg nodropdown">Certificates & Research</span>
                <i class="fa fa-certificate menuIcon" aria-hidden="true"></i>
            </a>
        </div>
    </li>
<?php endif; ?>

<?php if ($user->hasPermission('access', 'ourteams')) : ?>
    <li class="nav-item">
        <div class="nav-link" title="Our Teams">
            <a href="<?php echo $ourteams; ?>">
                <span class="icon-bg_drop">Our Teams</span>
                <i class="fa fa-users menuIcon" aria-hidden="true"></i>
            </a>
        </div>
    </li>
<?php endif; ?>

<?php if ($user->hasPermission('access', 'awards')) : ?>
    <li class="nav-item">
        <div class="nav-link" title="Awards">
            <a href="<?php echo $awards; ?>">
                <span class="icon-bg_drop">Awards</span>
                <i class="fa fa-bold menuIcon" aria-hidden="true"></i>
            </a>
        </div>
    </li>
<?php endif; ?>

<?php if ($user->hasPermission('access', 'ourhistories')) : ?>
    <li class="nav-item">
        <div class="nav-link" title="History">
            <a href="<?php echo $ourhistories; ?>">
                <span class="icon-bg_drop">History</span>
                <i class="fa fa-history menuIcon" aria-hidden="true"></i>
            </a>
        </div>
    </li>
<?php endif; ?>

<?php if ($user->hasPermission('access', 'casestudy')) : ?>
    <li class="nav-item">
        <div class="nav-link" title="Case Study">
            <a href="<?php echo $casestudy; ?>">
                <span class="icon-bg_drop">Case Study</span>
                <i class="fa fa-briefcase menuIcon" aria-hidden="true"></i>
            </a>
        </div>
    </li>
<?php endif; ?>


<?php if ($user->hasPermission('access', 'productlifecycleanalysis')) : ?>
    <li class="nav-item">
        <div class="nav-link" title="Product Lifecycle Analysis">
            <a href="<?php echo $productlifecycleanalysis; ?>">
                <span class="icon-bg_drop">Product Lifecycle Analysis</span>
                <i class="fa fa-product-hunt menuIcon" aria-hidden="true"></i>
            </a>
        </div>
    </li>
<?php endif; ?>

<?php if ($user->hasPermission('access', 'lcareport')) : ?>
    <li class="nav-item">
        <div class="nav-link" title="LCA Report">
            <a href="<?php echo $lcareport; ?>">
                <span class="icon-bg_drop">LCA Report</span>
                <i class="fa fa-bug menuIcon" aria-hidden="true"></i>
            </a>
        </div>
    </li>
<?php endif; ?>
<!-- <li class="nav-item">
	<div class="nav-link">
		<span class="icon-bg">Case Study</span>
		<i class="fa fa-briefcase menuIcon" aria-hidden="true"></i>
	</div>
	<div class="menuright">
		<ul>
			<li>
				<a href="<?php echo $casestudy; ?>">
					<i class="fa fa-briefcase"></i>Case Study
				</a>
			</li>
			<li>
				<a href="<?php echo $casestudycategory; ?>">
					<i class="fa fa-briefcase"></i>Case Study Categories
				</a>
			</li>
		</ul>
	</div>
</li> -->

 <!-- <?php if ($user->hasPermission('access', 'sectors')) : ?>
    <li class="nav-item">
        <div class="nav-link" title="Sectors">
            <a href="<?php echo $sectors; ?>">
                <span class="icon-bg_drop">Sectors</span>
                <i class="fa fa-university menuIcon" aria-hidden="true"></i>
            </a>
        </div>
    </li>
<?php endif; ?> 

<?php if ($user->hasPermission('access', 'business')) : ?>
    <li class="nav-item">
        <div class="nav-link" title="Businesses">
            <a href="<?php echo $business; ?>">
                <span class="icon-bg_drop">Businesses</span>
                <i class="fa fa-building menuIcon" aria-hidden="true"></i>
            </a>
        </div>
    </li>
<?php endif; ?>  -->

<?php if ($user->hasPermission('access', 'brands')) : ?>
    <li class="nav-item">
        <div class="nav-link">
            <span class="icon-bg">
                <i class="fa fa-shopping-bag menuIcon" aria-hidden="true"></i>
                Brands
            </span>
        </div>
        <div class="menuright">
            <ul>
                <?php if ($user->hasPermission('access', 'brands')) : ?>
                    <li>
                        <a href="<?php echo $brands; ?>">
                            <i class="fa fa-shopping-bag"></i>
                            Brands
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ($user->hasPermission('access', 'locations')) : ?>
                    <li>
                        <a href="<?php echo $locations; ?>">
                        <i class="fa fa-map-marker"></i>
                            Locations
                        </a>
                    </li>
                <?php endif; ?> 
            </ul>
        </div>
    </li>
<?php endif; ?>

<?php if ($user->hasPermission('access', 'mediacenter')) : ?>
<li class="nav-item">
	<div class="nav-link">
		<span class="icon-bg">
			<i class="fa fa-cubes menuIcon" aria-hidden="true"></i>
			Media Center
		</span>
	</div>

	<div class="menuright">
		<ul>
        <?php if ($user->hasPermission('access', 'mediacenter')) : ?>
			<li>
				<a href="<?php echo $mediacenter; ?>">
					<i class="fa fa-play"></i>
					Media Center
				</a>
			</li>
            <?php endif; ?>
            <?php if ($user->hasPermission('access', 'mediacentercategories')) : ?>
			<li>
				<a href="<?php echo $mediacentercategories; ?>">
					<i class="fa fa-play"></i>
					Media Center Categories
				</a>
			</li>
            <?php endif; ?>
		</ul>
	</div>
</li> 
<?php endif; ?>
<?php if ($user->hasPermission('access', 'careers')) : ?>
 <li class="nav-item">
    <div class="nav-link" title="Careers">
        <span class="icon-bg">Careers</span>
        <i class="fa fa-graduation-cap menuIcon" aria-hidden="true"></i>
    </div>
    <div class="menuright">
        <ul>
   
                <li title="Careers">
                    <a href="<?php echo $careers; ?>">
                        <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                        Careers
                    </a>
                </li>

           <?php if ($user->hasPermission('access', 'locations')) : ?>
                <li title="Locations" >
                    <a href="<?php echo $locations; ?>">
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                        Locations
                    </a>
                </li>
            <?php endif; ?>
        <?php if ($user->hasPermission('access', 'jobtype')) : ?>
                <li title="Job types">
                    <a href="<?php echo $jobtype; ?>">
                        <i class="fa fa-university" aria-hidden="true"></i>
                        Job types
                    </a>
                </li>
            <?php endif; ?>  

           <?php if ($user->hasPermission('access', 'careerenquiries')) : ?>
                <li title="Career Enquiries" >
                    <a href="<?php echo $careerenquiries; ?>">
                        <i class="fa fa-question" aria-hidden="true"></i>
                        Career Enquiries
                    </a>
                </li>
            <?php endif; ?> 
        </ul>
    </div>
</li> 
<?php endif; ?>
<?php if ($user->hasPermission('access', 'enquiries')) : ?>
    <li class="nav-item">
        <div class="nav-link" title="Enquiries">
            <a href="<?php echo $enquiries; ?>">
                <span class="icon-bg_drop">Enquiries</span>
                <i class="fa fa-search menuIcon" aria-hidden="true"></i>
            </a>
        </div>
    </li>
<?php endif; ?> 

<?php if ($user->hasPermission('access', 'adminuser')) : ?>
    <li class="nav-item">
        <div class="nav-link" title="Admin Users">
            <a href="<?php echo $adminuser; ?>">
                <span class="icon-bg_drop">Admin Users</span>
                <i class="fa fa-user menuIcon" aria-hidden="true"></i>
            </a>
        </div>
    </li>
<?php endif; ?> 

<?php if ($user->hasPermission('access', 'setting')) : ?>
    <li class="nav-item">
        <div class="nav-link" title="Settings">
            <a href="<?php echo $setting; ?>">
                <span class="icon-bg_drop">Settings</span>
                <i class="fa fa-cog menuIcon" aria-hidden="true"></i>
            </a>
        </div>
    </li>
<?php endif; ?> 

<?php if ($user->hasPermission('access', 'roles')) : ?>
                <!-- <li>
				<a href="<?php echo $roles; ?>">
					<svg xmlns="http://www.w3.org/2000/svg" width="13.333" height="12" viewBox="0 0 13.333 12">
						<path id="_Icon_settings" data-name="settings"
							d="M8.666,12A.667.667,0,0,1,8,11.333a3.333,3.333,0,1,0-6.667,0,.667.667,0,1,1-1.333,0,4.664,4.664,0,0,1,7.96-3.3,3.333,3.333,0,0,1,5.373,2.636.667.667,0,0,1-1.333,0A2,2,0,0,0,8.762,9.1a4.669,4.669,0,0,1,.571,2.234A.668.668,0,0,1,8.666,12ZM10,6.667a2,2,0,1,1,2-2A2,2,0,0,1,10,6.667ZM10,4a.667.667,0,1,0,.667.667A.667.667,0,0,0,10,4ZM4.667,5.333A2.667,2.667,0,1,1,7.333,2.666,2.67,2.67,0,0,1,4.667,5.333Zm0-4A1.334,1.334,0,1,0,6,2.666,1.335,1.335,0,0,0,4.667,1.333Z"
							fill="#c5cee0" />
					</svg>
					Roles & Permissions
				</a>
			</li> -->
<?php endif; ?>
<script>
    // $(document).ready(function () {
    //     $(document).on("click", function (event) {
    //         if (!$(event.target).closest('.nav-item').length) {
    //             $('.nav-item').removeClass('active'); 
    //             $('.menuright').removeClass('side_menu_open'); 
    //         }
    //     });
    //     $('.nav-link').on("click", function () {
    //         $(this).closest('.nav-item').toggleClass('active');
    //     });
    // });
</script>