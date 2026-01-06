<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <title><?php echo $config_name; ?></title>
    <?php if ($meta_description) { ?>
        <meta name="description" content="<?php echo ($meta_description) ? $meta_description : ''; ?>">
    <?php } ?>
    <?php if ($meta_keywords) { ?>
        <meta name="keywords" content="<?php echo ($meta_keywords) ? $meta_keywords : ""; ?>">
    <?php } ?>
    <meta charset="utf-8" name="viewport" content="width=device-width,  initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <?php if (!empty($flogo)) : ?>
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $flogo; ?>">
    <?php endif; ?>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>themes/sharp/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css'>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css'>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.css' />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>themes/sharp/assets/css/custom.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>themes/sharp/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>themes/sharp/assets/css/style-ar.css">
    <script src="<?php echo BASE_URL; ?>themes/sharp/assets/js/gsap.min.js"></script>
    <script src="https://unpkg.com/splitting/dist/splitting.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/splitting/dist/splitting.css">
    <script src="<?php echo BASE_URL; ?>themes/sharp/assets/js/ScrollSmoother.min.js"></script>
    <script src="<?php echo BASE_URL; ?>themes/sharp/assets/js/ScrollTrigger.min.js"></script>
    <script src="<?php echo BASE_URL; ?>themes/sharp/assets/js/SplitText.min.js"></script>
    <script src="<?php echo BASE_URL; ?>themes/sharp/assets/js/jquery.js"></script>
    <?php if ($captchaStatus) { ?>
        <script src="https://www.google.com/recaptcha/api.js?render=<?php echo $siteKey; ?>"></script>
    <?php } ?>
</head>
<body class="<?php echo $body_class; ?>-page<?php echo $this->session->data['lang']; ?>" dir="<?php if ($this->session->data['lang'] == 'ar') { echo "rtl";  } else { echo "ltr"; } ?>">