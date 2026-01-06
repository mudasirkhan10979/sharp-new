<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?php echo $title; ?></title>
	<base href="<?php echo $base; ?>" />
	<?php if ($description) { ?>
		<meta name="description" content="<?php echo $description; ?>" />
	<?php } ?>
	<?php if ($keywords) { ?>
		<meta name="keywords" content="<?php echo $keywords; ?>" />
	<?php } ?>
	<meta name="google-site-verification" content="EsOwRCqjZ01W339HUO8exeSTwyqaLVXENG_61cOuLlU" />
	<link rel="stylesheet" href="/themes/admin/vendors/fontawesome/css/all.min.css">
	<link href="/themes/admin/javascript/bootstrap/opencart/opencart.css" type="text/css" rel="stylesheet" />
	<!-- plugins:css -->
	<link rel="stylesheet" href="/themes/admin/vendors/mdi/css/materialdesignicons.min.css">
	<link rel="stylesheet" href="/themes/admin/vendors/flag-icon-css/css/flag-icon.min.css">
	<link rel="stylesheet" href="/themes/admin/vendors/css/vendor.bundle.base.css">
	<!-- endinject -->
	<!-- Plugin css for this page -->
	<link rel="stylesheet" href="/themes/admin/vendors/font-awesome/css/font-awesome.min.css" />
	<link rel="stylesheet" href="/themes/admin/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
	<!-- End plugin css for this page -->
	<!-- inject:css -->
	<!-- endinject -->
	<!-- Layout styles -->
	<link rel="stylesheet" href="/themes/admin/css/style.css">
	<link rel="stylesheet" href="/themes/admin/css/custome.css">
	<!-- End layout styles -->
	<link rel="shortcut icon" href="/uploads/image/setting/<?php echo $this->config->get('config_favicon'); ?>" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icons8/1.0.0/icons8.min.css">
	<link href="/themes/admin/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
	</style>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css" integrity="undefined" crossorigin="anonymous">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAdpbECdjmT1Bacw3Rxa81whyIHF4h_PUg"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<script src="/themes/admin/javascript/jquery/datetimepicker/moment.js" type="text/javascript"></script>
	<script src="/themes/admin/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
	<link rel="stylesheet" href="/themes/admin/stylesheet/select2.min.css">
	<script src="/themes/admin/stylesheet/select2.min.js"></script>
	<link type="text/css" href="/themes/admin/stylesheet/stylesheet.css" rel="stylesheet" media="screen" />
	<script src="/themes/admin/javascript/common.js" type="text/javascript"></script>
	<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
	<script src="/themes/admin/js/ckeditor/ckeditor.js"></script>

		<!-- shahid demand -->
		<link rel="stylesheet" href="/themes/admin/css/wp_style.css">
	<!-- shahid demand -->
</head>
<body class="<?php echo ($logged == 1 ? 'logged-in' : 'logged-out'); ?>">
	<?php
	// Get the current request URI
	$requestUri = $_SERVER['REQUEST_URI'];
	// Parse the URL to get the query string
	$urlComponents = parse_url($requestUri);
	// Parse the query string to get the controller parameter
	parse_str($urlComponents['query'], $queryParams);
	// Get the controller name, default to 'home' if not set 
	$controller = isset($queryParams['controller']) ? $queryParams['controller'] : 'home';
	?>
	<div class="container-scroller <?php echo $controller; ?>">
		<div class="<? echo ($logged == 1 ? 'dashboardmain' : ''); ?>">
			<?php
			if ($logged) {
				echo $columnleft;
			}
			?>
			<div class="rightcontent">
				<!-- partial:partials/_navbar.html -->
				<?php if ($logged) { ?>
					<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 d-flex flex-row">
						<div class="navbar-menu-wrapper d-flex align-items-stretch dashboardheadermenu">
							<ul class="navbar-nav navbar-nav-right">
								<!-- <li class="nav-item dropdown">
									<a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="<?php echo $programEnquiries; ?> ">
										<img src="/themes/admin/images/icons-mail.png" alt="email icon"><span class="count-symbol bg-success"></span>
									</a>
								</li>
								<li class="nav-item dropdown">
									<a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="<?php echo $enquiries; ?> ">
										<img src="/themes/admin/images/01)-icons-filled-arrow-circle-down-fill-copy@2x.png" alt="bell icon">
										<span class="count-symbol bg-success"></span>
									</a>
								</li> -->
								<li class="nav-item">
									<a class="nav-link" href="<?php echo $logout; ?>"><span class="hidden-xs hidden-sm hidden-md" style="color: #fff;"> <?php echo $text_logout; ?></span> &nbsp <i class="fa fa-sign-out fa-lg" style="color: #fff;"></i></a>
								</li>
							</ul>
							<button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
								<span class="mdi mdi-menu"></span>
							</button>
						</div>
					</nav>
				<?php } ?>