<?php echo $header; ?>
<?php echo $menuinner; ?>
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

.ned-share-icon ul li {
    display: inline-block;       /* Make list items inline */
    margin-right: 5px;           /* Space between icons */
}

.ned-share-icon ul li a {
    display: inline-block;
    padding: 8px;                /* Adjust as needed */
    border-radius: 4px;          /* Optional: rounded corners */
    background-color: #fff !important;    /* Default white background */
    transition: all 0.3s ease;   /* Smooth hover effect */
}

.ned-share-icon ul li a img {
    transition: all 0.3s ease;   /* Smooth icon transition */
}

.ned-share-icon ul li a:hover {
    background-color: #e6000d  !important;    /* Red background on hover */
}

.ned-share-icon ul li a:hover img {
    filter: brightness(0) invert(1); /* Icon turns white on hover */
}
</style>
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
            <section>
                <div class="contact-us-sec">
                    <div class="container">
                        <div class="contact-us-inn">
                            <div class="get-in-touch">
                                <div class="get-in-touch-inn">
                                    <?php if (!empty($bgetIntouch)): ?>
                                        <div class="get-in-touch-title">
                                            <h2><?php echo $bgetIntouch['title']; ?></h2>
                                            <?php echo $bgetIntouch['content']; ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="get-in-touch-form">
                                        <form id="contactForm" method="post" action="<?php echo $action; ?>">
                                            <div class="">
                                                <input type="text" id="name" name="name" class="form-control" placeholder="<?php echo $text_name; ?>">
                                            </div>
                                            <div class="">
                                                <input type="email" id="email" name="email" class="form-control" placeholder="<?php echo $entry_email_address; ?>">
                                            </div>
                                            <div class="">
                                                <input type="tel" id="phone" name="phone" class="form-control" placeholder="<?php echo $entry_phone_contact; ?>">
                                            </div>
                                            <div class="">
                                                <input type="text" id="subject" name="subject" class="form-control" placeholder="<?php echo $text_subject; ?>">
                                            </div>
                                            <div class="" id="messagesuccess">
                                                <input id="message" name="message" class="form-control" placeholder="<?php echo $entry_message; ?>">
                                            </div>
                                            <input type="hidden" name="enquiry_from" value="<?php echo $action; ?>">
                                            <input type="hidden" name="recaptcha_token" value="<?php echo $siteKey; ?>" id="recaptcha_token">
                                            <button type="submit" class="get-btn btn btn-primary git_submit btn-default"><?php echo $text_btn_submit; ?> <span><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="contact-detail">
                                <div class="contact-detail-inn">
                                    <?php if (!empty($blockcontactdetails)): ?>
                                        <div class="contact-detail-title">
                                            <h2><?php echo $blockcontactdetails['title']; ?></h2>
                                            <p><?php echo $blockcontactdetails['content']; ?></p>
                                        </div>
                                    <?php endif; ?>
                                    <div class="o-l-cant-info-inn">
                                        <?php if (isset($config_address)): ?>
                                            <div class="loct-item-inn">
                                                <span class="l-item-icon">
                                                    <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/loaction.svg" alt="">
                                                </span>
                                                <span class="label"><?php echo $text_location; ?>:</span>
                                                <span class="value">
                                                    <a href="https://www.google.com/maps/search/<?php echo urlencode($config_address); ?>" target="_blank">
                                                        <?php echo $config_address; ?>
                                                    </a>
                                                </span>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (isset($telephone)): ?>
                                            <div class="loct-item-inn">
                                                <span class="l-item-icon">
                                                    <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/phone.svg" alt="">
                                                </span>
                                                <span class="label"><?php echo $entry_phone_contact; ?>:</span>
                                                <span class="value">
                                                    <a href="tel:<?php echo preg_replace('/\s+/', '', $telephone); ?>">
                                                        <?php echo $telephone; ?>
                                                    </a>
                                                </span>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (isset($config_email)): ?>
                                            <div class="loct-item-inn">
                                                <span class="l-item-icon">
                                                    <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/envelope.svg" alt="">
                                                </span>
                                                <span class="label"><?php echo $entry_email_address; ?>:</span>
                                                <span class="value">
                                                    <a href="mailto:<?php echo $config_email; ?>">
                                                        <?php echo $config_email; ?>
                                                    </a>
                                                </span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="contact-dtl-follow-us">
                                        <div class="n-e-detail-sociashare-inn">
                                            <div class="ned-share">
                                                <span>
                                                    <?php echo $entry_follow_us; ?>
                                                </span>
                                            </div>
                                            <div class="ned-share-icon">
                                                <ul>
                                                    <?php if (!empty($facebook)): ?>
                                                        <li><a href="<?php echo $facebook; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/fb-filled.svg" alt=""></a></li>
                                                    <?php endif; ?>
                                                    <?php if (!empty($twitter)): ?>
                                                        <li><a href="<?php echo $twitter; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/s_x.svg" alt=""></a></li>
                                                    <?php endif; ?>
                                                    <?php if (!empty($instagram)): ?>
                                                        <li><a href="<?php echo $instagram; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/s_insta.svg" alt=""></a></li>
                                                    <?php endif; ?>
                                                    <?php if (!empty($youtube)): ?>
                                                        <li><a href="<?php echo $youtube; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/yt-play-filled.svg" alt=""></a></li>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php //if (!empty($aboutsharpgetyourhighly) && !empty($sharpimagegetyour)): ?>
                <!-- <section>
                    <div class="virtual-assistant">
                        <div class="container">
                            <div class="virtual-assistant-inn">
                                <div class="container">
                                    <div class="vr-assistant-content">
                                        <div class="vr-assistant-txt">
                                            <h2><?php //echo $aboutsharpgetyourhighly['title']; ?></h2>
                                            <?php //echo $aboutsharpgetyourhighly['content']; ?>
                                            <div class="vr-ast-link">
                                                <a href="#" class="btn-default"><span class="dw-btn"><?php //echo $text_learn_more; ?></span> <span><img src="<?php //echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span></a>
                                            </div>
                                        </div>
                                        <div class="vr-assistant-img">
                                            <div class="vr-asst-img-inn">
                                                <img src="<?php //echo BASE_URL; ?>uploads/image/blockimages/<?php //echo $sharpimagegetyour['image']; ?>" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section> -->
            <?php //endif; ?>
            <?php if (!empty($servicecenters)): ?>
                <section>
                    <div class="service-center-contact">
                        <div class="sc-contact-inn">
                            <div class="container">
                                <div class="sc-contact-title">
                                    <h2><?php echo $text_service_center_contacts; ?></h2>
                                </div>
                            </div>

                            <div class="sc-contact-listing">
                                <div class="sc-contact-list-inn owl-carousel">
                                    <?php foreach ($servicecenters as $servicecenter): ?>
                                        <div class="sc-contact-item">
                                            <div class="sc-contact-item-inn">
                                                <div class="o-l-cant-info-inn">
                                                    <?php if (!empty($servicecenter['country_name'])): ?>
                                                        <span class="j-locat"><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/location-pin1.svg" alt=""><?php echo $servicecenter['country_name']; ?></span>
                                                    <?php endif; ?>
                                                    <?php if (!empty($servicecenter['address'])): ?>
                                                        <div class="loct-item-inn sc-cnt-location">
                                                            <span class="l-item-icon">
                                                                <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/loaction.svg" alt="">
                                                            </span>
                                                            <span class="label"><?php echo $text_location; ?>:</span>
                                                        <span class="value">
                                                            <a href="https://www.google.com/maps/search/<?php echo urlencode(strip_tags($servicecenter['address'])); ?>" target="_blank">
                                                                <?php echo html_entity_decode($servicecenter['address']); ?>
                                                            </a>
                                                        </span>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if (!empty($servicecenter['phone'])): ?>
                                                        <div class="loct-item-inn">
                                                            <span class="l-item-icon">
                                                                <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/phone.svg" alt="">
                                                            </span>
                                                            <span class="label"><?php echo $entry_phone_contact; ?>:</span>
                                                            <span class="value">
                                                                <a href="tel:<?php echo $servicecenter['phone']; ?>">
                                                                    <?php echo $telephone; ?>
                                                                </a>
                                                            </span>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if (!empty($servicecenter['email'])): ?>
                                                        <div class="loct-item-inn">
                                                            <span class="l-item-icon">
                                                                <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/envelope.svg" alt="">
                                                            </span>
                                                            <span class="label"><?php echo $entry_email_address; ?>:</span>
                                                            <span class="value">
                                                                <a href="mailto:<?php echo $servicecenter['email']; ?>">
                                                                    <?php echo $servicecenter['email']; ?>
                                                                </a>
                                                            </span>
                                                        </div>
                                                    <?php endif; ?>
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
            <?php if (!empty($customerFeedback)): ?>
                <section style="display: none;">
                    <div class="customer-feedbacks">
                        <div class="container">
                            <div class="customer-feedbacks-inn">
                                <div class="container">
                                    <div class="cust-feedbacks-title">
                                        <h2><?php echo $text_customer_feedback; ?></h2>
                                    </div>
                                </div>
                                <div class="cust-feedbacks-listing">
                                    <div class="cust-feedbacks-list-inn owl-carousel">
                                        <?php foreach ($customerFeedback as $feedback) { ?>
                                            <div class="cust-feedbacks-item">
                                                <div class="cust-feedbacks-item-inn">
                                                    <span class="star-ratting">
                                                        <?php for ($i = 0; $i < $feedback['number_of_stars']; $i++) { ?>
                                                            <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/one-star.svg" alt="star">
                                                        <?php } ?>
                                                    </span>
                                                    <div class="customer-comment">
                                                        <?php echo html_entity_decode($feedback['description']); ?>
                                                    </div>
                                                    <div class="customer-data">
                                                        <?php if (!empty($feedback['icon'])): ?>
                                                            <span class="cust-pic">
                                                                <img src="<?php echo BASE_URL; ?>uploads/image/customer_feedback/<?php echo $feedback['icon']; ?>" alt="">
                                                            </span>
                                                        <?php endif; ?>
                                                        <span class="cust-data-inn">
                                                            <span class="name"><?php echo $feedback['title']; ?></span>
                                                            <span class="designation"><?php echo $feedback['designation']; ?></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
            <?php echo $footer; ?>
            <div id="loader" class="loader-overlay" style="display: none;">
                <div class="loader"></div>
            </div>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                $(document).ready(function() {
                    $(document).on('submit', '#contactForm', function(e) {
                        e.preventDefault();
                        let valid = true;
                        $('.text-danger').remove();
                        $('.alert-success').remove();
                        const name = $('#name').val().trim();
                        const phone = $('#phone').val().trim();
                        const email = $('#email').val().trim();
                        const subject = $('#subject').val().trim();
                        const message = $('#message').val().trim();
                        const token = $('#recaptcha_token').val();
                        const nameError = '<?php echo $err_name; ?>';
                        const phoneError = '<?php echo $err_phone; ?>';
                        const phoneInvalidError = '<?php echo $err_invalid_phone; ?>';
                        const emailError = '<?php echo $err_email; ?>';
                        const emailErrorInvalid = '<?php echo $err_invalid_email; ?>';
                        const subjectError = '<?php echo $err_subject; ?>';
                        const messageError = '<?php echo $err_message; ?>';
                        const recaptchaError = '<?php echo $err_captcha; ?>';
                        if (name === '') {
                            valid = false;
                            $('#name').after('<div class="text-danger">' + nameError + '</div>');
                        }
                        if (phone === '') {
                            valid = false;
                            $('#phone').after('<div class="text-danger">' + phoneError + '</div>');
                        } else if (!validatePhone(phone)) {
                            valid = false;
                            $('#phone').after('<div class="text-danger">' + phoneInvalidError + '</div>');
                        }
                        if (email === '') {
                            valid = false;
                            $('#email').after('<div class="text-danger">' + emailError + '</div>');
                        } else if (!validateEmail(email)) {
                            valid = false;
                            $('#email').after('<div class="text-danger">' + emailErrorInvalid + '</div>');
                        }
                        if (subject === '') {
                            valid = false;
                            $('#subject').after('<div class="text-danger">' + subjectError + '</div>');
                        }
                        if (message === '') {
                            valid = false;
                            $('#message').after('<div class="text-danger">' + messageError + '</div>');
                        }

                        if (token === '') {
                            valid = false;
                            $('#recaptcha_token').after('<div class="text-danger">' + recaptchaError + '</div>');
                        }
                        if (valid) {
                            $('#loader').show();
                            $('.git_submit').prop('disabled', true);
                            try {
                                grecaptcha.ready(function() {
                                    grecaptcha.execute('<?php echo $siteKey; ?>', {
                                        action: 'contact'
                                    }).then(function(token) {
                                        if (!token) {
                                            $('#loader').hide();
                                            $('#recaptcha_token').after('<div class="text-danger"><?php echo $err_captcha; ?></div>');
                                            $('.git_submit').prop('disabled', false);
                                            return;
                                        }
                                        $('#recaptcha_token').val(token);
                                        $.ajax({
                                            url: '<?php echo HTTPS_HOST; ?>contact/contactUsForm',
                                            type: 'POST',
                                            data: $('#contactForm').serialize(),
                                            dataType: 'json',
                                            success: function(response) {
                                                $('#loader').hide();
                                                if (response.error) {
                                                    $.each(response.error, function(field, errorMsg) {
                                                        $('#' + field).after('<div class="text-danger">' + errorMsg + '</div>');
                                                    });
                                                    $('.git_submit').prop('disabled', false);
                                                } else if (response.success) {
                                                    $('#message').closest('#messagesuccess').after(
                                                        '<div class="alert alert-success alert-dismissible fade show mt-2" role="alert">' +
                                                        response.success +
                                                        '</div>'
                                                    );
                                                    $('#contactForm')[0].reset();
                                                    $('.git_submit').prop('disabled', false);
                                                    setTimeout(function() {
                                                        $('.alert-success').fadeOut(500, function() {
                                                            $(this).remove();
                                                            $('.git_submit').prop('disabled', false);
                                                        });
                                                    }, 15000);
                                                }
                                            },
                                            error: function() {
                                                $('#loader').hide();
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Submission Error',
                                                    text: 'There was an error submitting your message. Please try again later.',
                                                    showConfirmButton: true
                                                });
                                                $('.git_submit').prop('disabled', false);
                                            }
                                        });
                                    }).catch(function() {
                                        $('#loader').hide();
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Verification Error',
                                            text: 'reCAPTCHA verification failed. Please try again.',
                                            showConfirmButton: true
                                        });
                                        $('.git_submit').prop('disabled', false);
                                    });
                                });
                            } catch (e) {
                                $('#loader').hide();
                                $('#recaptcha_token').after('<div class="text-danger"><?php echo $err_captcha; ?></div>');
                                $('.git_submit').prop('disabled', false);
                            }
                        }
                    });
                    function validateEmail(email) {
                        var re = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
                        return re.test(email);
                    }
                    function validatePhone(phone) {
                        var re = /^\+?[0-9]{7,15}$/;
                        return re.test(phone);
                    }
                });
            </script>