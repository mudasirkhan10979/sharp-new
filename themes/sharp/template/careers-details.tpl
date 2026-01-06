<?php echo $header; ?>
<?php echo $menuinner ?>
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
<div id="smooth-wrapper">
    <div id="smooth-content">
        <div class="main-container">
            <div class="career-detail">
                <div class="container">
                    <div class="back-to-listing">
                        <div class="container">
                            <div class="back-to-listing-inn">
                                <a class="default-back" href="<?php echo BASE_URL; ?>careers"><img
                                        src="<?php echo BASE_URL; ?>themes/sharp/assets/images/arrow-link.svg"
                                        alt=""><?php echo $text_back; ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="career-detail-content">
                        <div class="career-detail-meta">
                            <div class="c-d-meta-inn">
                                <?php if (!empty($careerDetail['location_title'])): ?>
                                <div class="c-d-meta-loct">
                                    <span class="j-locat"><img
                                            src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/location-pin1.svg"
                                            alt=""> <?php echo $careerDetail['location_title']; ?></span>
                                </div>
                                <?php endif; ?>
                                <div class="c-d-meta-data">
                                    <div class="job-meta">
                                        <?php if (!empty($careerDetail['publish_date'])): ?>
                                        <span class="j-date"><img
                                                src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/calendar.svg"
                                                alt="">
                                            <?php echo date('d M Y', strtotime($careerDetail['publish_date'])); ?></span>
                                        <?php endif; ?>
                                        <?php if (!empty($careerDetail['jobtype_name'])): ?>
                                        <span class="j-time"><img
                                                src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/bookmark.svg"
                                                alt=""><?php echo $careerDetail['jobtype_name']; ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if (!empty($careerDetail['title'])): ?>
                        <div class="career-detail-title">
                            <h2><?php echo $careerDetail['title']; ?></h2>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($careerDetail['job_description'])): ?>
                        <div class="cd-job-summery">
                            <?php echo $careerDetail['job_description']; ?>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($careerDetail['key_description'])): ?>
                        <div class="cd-key-point">
                            <?php echo $careerDetail['key_description']; ?>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($careerDetail['requirements_description'])): ?>
                        <div class="cd-key-point">
                            <?php echo $careerDetail['requirements_description']; ?>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($careerDetail['skills_description'])): ?>
                        <div class="cd-key-point">
                            <?php echo $careerDetail['skills_description']; ?>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($careerDetail['benefits_description'])): ?>
                        <div class="cd-key-point">
                            <?php echo $careerDetail['benefits_description']; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <section>
                        <div class="news-event-detail-socialshare">
                            <div class="container">
                                <div class="n-e-detail-sociashare-inn">
                                    <div class="ned-share">
                                        <span>
                                            <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/share-icon.svg"
                                                alt="">
                                            <?php echo $text_only_share; ?>
                                        </span>
                                    </div>
                                    <div class="ned-share-icon">
                                        <ul>
                                            <?php if (!empty($share_links['facebook'])): ?>
                                            <li><a href="<?php echo $share_links['facebook']; ?>" target="_blank"><img
                                                        src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/fb.svg"
                                                        alt="Facebook"></a></li>
                                            <?php endif; ?>
                                            <?php if (!empty($share_links['twitter'])): ?>
                                            <li><a href="<?php echo $share_links['twitter']; ?>" target="_blank"><img
                                                        src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/s_x.svg"
                                                        alt="Twitter"></a></li>
                                            <?php endif; ?>
                                            <?php if (!empty($share_links['instagram'])): ?>
                                            <li><a href="<?php echo $share_links['instagram']; ?>" target="_blank"><img
                                                        src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/s_insta.svg"
                                                        alt="Instagram"></a></li>
                                            <?php endif; ?>
                                            <?php if (!empty($share_links['youtube'])): ?>
                                            <li><a href="<?php echo $share_links['youtube']; ?>" target="_blank"><img
                                                        src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/yt.svg"
                                                        alt="YouTube"></a></li>
                                            <?php endif; ?>
                                            <?php if (!empty($share_links['whatsapp'])): ?>
                                            <li><a href="<?php echo $share_links['whatsapp']; ?>" target="_blank"><img
                                                        src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/whatsapp.svg"
                                                        alt="WhatsApp"></a></li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section>
                        <div class="apply-now">
                            <div class="apply-now-inn">
                                <div class="apply-now-title">
                                    <h2><?php echo $text_apply_now; ?></h2>
                                </div>
                                <div class="apply-now-form">
                                    <form id="careerApplyForm" enctype="multipart/form-data">
                                        <input type="hidden" name="career_id" value="<?php echo $career_id; ?>">
                                        <input type="hidden" name="enquiry_from" value="<?php echo $action; ?>">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" id="name" name="name" class="form-control"
                                                    placeholder="<?php echo $text_full_name; ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="tel" id="phone" name="phone" class="form-control"
                                                    placeholder="<?php echo $text_phone; ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="email" id="email" name="email" class="form-control"
                                                    placeholder="<?php echo $text_contact_email; ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" id="subject" name="subject" class="form-control"
                                                    placeholder="<?php echo $subject_lab;?>*">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 message">
                                                <input id="message" name="message" class="form-control"
                                                    placeholder="<?php echo $message_lab; ?>*">
                                            </div>
                                            <div class="col-md-12" id="ap-file-upload">
                                                <div class="ap-file-upload">
                                                    <h4><?php echo $text_submit_y_resume; ?></h4>
                                                    <p><?php echo $text_lorem_ipsum; ?></p>
                                                    <div class="ap-file-upload-inn">
                                                        <div class="ap-file-upld uploadFile">
                                                            <input type="file" id="cv_file" name="cv_file"
                                                                class="form-control" accept=".doc,.docx,.pdf">
                                                            <div class="upload">
                                                                <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/upload.svg"
                                                                    alt="">
                                                                <span
                                                                    class="tag-line"><?php echo $text_drag_your_resume; ?></span>
                                                                <span><?php echo $text_acceptable_file; ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="recaptcha_token" value="<?php echo $siteKey; ?>"
                                                id="recaptcha_token">
                                            <div class="apply-now-btn">
                                                <button type="submit" class="cv_submit btn-default">
                                                    <span class="dw-btn"><?php echo $text_btn_submit; ?></span>
                                                    <span><img
                                                            src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg"
                                                            alt=""></span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <?php echo $footer; ?>
            <div id="loader" class="loader-overlay" style="display: none;">
                <div class="loader"></div>
            </div>
            <script>
            $(document).ready(function() {
                $(document).on('change', '#cv_file', function() {
                    $('.file-preview').remove();
                    const file = this.files[0];
                    if (file) {
                        $('#cv_file').after('<div class="file-preview">' + file.name + '</div>');
                    }
                });
                $(document).on('submit', '#careerApplyForm', function(e) {
                    e.preventDefault();
                    let valid = true;
                    $('.text-danger').remove();
                    const name = $('#name').val().trim();
                    const email = $('#email').val().trim();
                    const phone = $('#phone').val().trim();
                    const subject = $('#subject').val().trim();
                    const message = $('#message').val().trim();
                    const file = $('#cv_file')[0].files[0];
                    const token = $('#recaptcha_token').val();
                    // Error messages
                    const nameError = '<?php echo $err_name; ?>';
                    const emailError = '<?php echo $err_email; ?>';
                    const emailInvalidError = '<?php echo $err_invalid_email; ?>';
                    const phoneError = '<?php echo $err_phone; ?>';
                    const subjectError = '<?php echo $text_message_error?>';
                    const messageError = '<?php echo $text_subject_error; ?>';
                    const cvError = '<?php echo $err_cv; ?>';
                    const cvInvalidError = '<?php echo $err_invalid_cv; ?>';
                    const recaptchaError = '<?php echo $err_captcha; ?>';
                    // Validation
                    if (name === '') {
                        valid = false;
                        $('#name').after('<div class="text-danger">' + nameError + '</div>');
                    }
                    if (email === '') {
                        valid = false;
                        $('#email').after('<div class="text-danger">' + emailError + '</div>');
                    } else if (!validateEmail(email)) {
                        valid = false;
                        $('#email').after('<div class="text-danger">' + emailInvalidError + '</div>');
                    }
                    if (phone === '') {
                        valid = false;
                        $('#phone').after('<div class="text-danger">' + phoneError + '</div>');
                    }
                    if (subject === '') {
                        valid = false;
                        $('#subject').after('<div class="text-danger">' + subjectError + '</div>');
                    }
                    if (message === '') {
                        valid = false;
                        $('#message').after('<div class="text-danger">' + messageError + '</div>');
                    }
                    if (!file) {
                        valid = false;
                        $('.uploadFile').after('<div class="text-danger">' + cvError + '</div>');
                    } else {
                        const allowed = ['pdf', 'doc', 'docx'];
                        const ext = file.name.split('.').pop().toLowerCase();
                        const maxSize = 5 * 1024 * 1024;
                        if ($.inArray(ext, allowed) === -1) {
                            valid = false;
                            $('.uploadFile').after('<div class="text-danger">' + cvInvalidError +
                                '</div>');
                        } else if (file.size > maxSize) {
                            valid = false;
                            $('.uploadFile').after(
                                '<div class="text-danger"><?php echo $text_file_error; ?></div>');
                        }
                    }

                    if (!valid) return;

                    $('#loader').show();
                    $('.cv_submit').prop('disabled', true);

                    try {
                        grecaptcha.ready(function() {
                            grecaptcha.execute('<?php echo $siteKey; ?>', {
                                action: 'career_apply'
                            }).then(function(token) {
                                if (!token) {
                                    $('#loader').hide();
                                    $('#recaptcha_token').after(
                                        '<div class="text-danger">' +
                                        recaptchaError + '</div>');
                                    $('.cv_submit').prop('disabled', false);
                                    return;
                                }

                                $('#recaptcha_token').val(token);
                                const formData = new FormData($('#careerApplyForm')[0]);

                                $.ajax({
                                    url: '<?php echo HTTPS_HOST; ?>careers/careersContactUsForm',
                                    type: 'POST',
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    dataType: 'json',
                                    success: function(response) {
                                        $('#loader').hide();
                                        if (response.error) {
                                            $.each(response.error, function(
                                                field, errorMsg) {
                                                $('#' + field)
                                                    .after(
                                                        '<div class="text-danger">' +
                                                        errorMsg +
                                                        '</div>');
                                            });
                                            $('.cv_submit').prop('disabled',
                                                false);
                                        } else if (response.success) {
                                            $('#ap-file-upload').after(
                                                '<div class="alert alert-success alert-dismissible fade show mt-2" role="alert">' +
                                                response.success +
                                                '</div>'
                                            );
                                            $('#careerApplyForm')[0]
                                        .reset();
                                            $('.file-preview').remove();
                                            $('.cv_submit').prop('disabled',
                                                false);
                                        }
                                    },
                                    error: function() {
                                        $('#loader').hide();
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Submission Error',
                                            text: 'There was an error submitting your application. Please try again later.'
                                        });
                                        $('.cv_submit').prop('disabled',
                                            false);
                                    }
                                });
                            }).catch(function() {
                                $('#loader').hide();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Verification Error',
                                    text: 'reCAPTCHA verification failed. Please try again.'
                                });
                                $('.cv_submit').prop('disabled', false);
                            });
                        });
                    } catch (err) {
                        $('#loader').hide();
                        $('#recaptcha_token').after('<div class="text-danger">' + recaptchaError +
                            '</div>');
                        $('.cv_submit').prop('disabled', false);
                    }
                });

                function validateEmail(email) {
                    var re = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
                    return re.test(email);
                }
            });
            </script>