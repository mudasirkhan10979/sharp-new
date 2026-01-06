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
                <div class="employ-benefits">
                    <div class="default-sec">
                        <div class="container">
                            <div class="row">
                                <?php if (!empty($blockemployeebenefits)): ?>
                                    <div class="col-md-12">
                                        <div class="benefit-content e-b-left">
                                            <h2><?php echo $blockemployeebenefits['title']; ?></h2>
                                            <div class="benefit-desc">
                                                <?php echo $blockemployeebenefits['content']; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="col-md-12">
                                    <div class="benefit-content e-b-right benefit-item-list">
                                        <div class="benefit-item-wrap">
                                            <div class="row">
                                                <?php if (!empty($blockloremipsumdolor1)): ?>
                                                    <div class="col-md-6">
                                                        <div class="benefit-item">
                                                            <div class="benefit-icon">
                                                                <img src="<?php echo BASE_URL; ?>themes/sharp/assets/images/star.svg" alt="" />
                                                            </div>

                                                            <div class="benefit-item-desc">
                                                                <h6><?php echo $blockloremipsumdolor1['title']; ?></h6>
                                                                <p> <?php echo $blockloremipsumdolor1['content']; ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (!empty($blockloremipsumdolor2)): ?>
                                                    <div class="col-md-6">
                                                        <div class="benefit-item">
                                                            <div class="benefit-icon">
                                                                <img src="<?php echo BASE_URL; ?>themes/sharp/assets/images/chart-pie.svg" alt="" />
                                                            </div>
                                                            <div class="benefit-item-desc">
                                                                <h6><?php echo $blockloremipsumdolor2['title']; ?></h6>
                                                                <p><?php echo $blockloremipsumdolor2['content']; ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="benefit-item-wrap">
                                            <div class="row">
                                                <?php if (!empty($blockloremipsumdolor3)): ?>
                                                    <div class="col-md-6">
                                                        <div class="benefit-item">
                                                            <div class="benefit-icon">
                                                                <img src="<?php echo BASE_URL; ?>themes/sharp/assets/images/shopping-basket.svg" alt="" />
                                                            </div>
                                                            <div class="benefit-item-desc">
                                                                <h6><?php echo $blockloremipsumdolor3['title']; ?></h6>
                                                                <p><?php echo $blockloremipsumdolor3['content']; ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (!empty($blockloremipsumdolor4)): ?>
                                                    <div class="col-md-6">
                                                        <div class="benefit-item">
                                                            <div class="benefit-icon">
                                                                <img src="<?php echo BASE_URL; ?>themes/sharp/assets/images/poll-vertical-circle.svg" alt="" />
                                                            </div>
                                                            <div class="benefit-item-desc">
                                                                <h6><?php echo $blockloremipsumdolor4['title']; ?></h6>
                                                                <p><?php echo $blockloremipsumdolor4['content']; ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php if (!empty($blockcompanyculture) && !empty($blockimagecompanyculture)): ?>
                <section>
                    <div class="company-culture">
                        <div class="container">
                            <div class="company-culture-inn">
                                <div class="container">
                                    <div class="comp-culture-title">
                                        <h2><?php echo $blockcompanyculture['title']; ?></h2>
                                    </div>
                                    <div class="comp-culture-content">
                                        <div class="comp-culture-cont-inn">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="cmp-culture-cnt-txt">
                                                        <?php echo $blockcompanyculture['content']; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="cmp-culture-cnt-img">
                                                        <img src="<?php echo BASE_URL; ?>uploads/image/blockimages/<?php echo $blockimagecompanyculture['image']; ?>" alt="">
                                                    </div>
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
            <section>
                <div class="job-post-listing">
                    <div class="container">
                        <div class="job-post-list-inn">
                            <div class="container">
                                <div class="job-post-filer">
                                    <div class="job-post-filter-inn">
                                        <div class="j-post-form-filter">
                                            <form id="careerSearchForm" class="row g-3">
                                                <div class="col-auto j-search-box">
                                                    <input type="search" name="filter_title" class="form-control" placeholder="<?php echo $text_search_job; ?>" value="<?php echo isset($current_filters['title']) ? $current_filters['title'] : ''; ?>">
                                                </div>
                                                <div class="col-auto l-search-box">
                                                    <input type="text" name="filter_location" class="form-control" placeholder="<?php echo $text_search_location;?>" value="<?php echo isset($current_filters['location']) ? $current_filters['location'] : ''; ?>">
                                                </div>
                                                <div class="col-auto">
                                                    <button type="submit" class="btn-search btn-default"><?php echo $text_search;?>
                                                        <span><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="j-post-dropdown-filter">
                                            <form id="careerFilterForm" class="row g-3">
                                                <div class="col-auto">
                                                    <label class=""><?php echo $text_filter; ?></label>
                                                </div>
                                                <div class="col-auto">
                                                    <select name="filter_jobtype" class="form-select">
                                                        <option value=""><?php echo $text_job_type; ?></option>
                                                        <?php foreach ($jobtypes as $jt) { ?>
                                                            <option value="<?php echo $jt['jobtype_id']; ?>" <?php echo (isset($current_filters['jobtype']) && $current_filters['jobtype'] == $jt['jobtype_id']) ? 'selected' : ''; ?>>
                                                                <?php echo $jt['title']; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="job-listing">
                                    <div id="careerList" class="job-list-inn">
                                        <?php if (!empty($careers)) { ?>
                                            <?php foreach ($careers as $career) { ?>
                                                <div class="job-post-item">
                                                    <div class="job-post-item-inn">
                                                        <span class="j-locat">
                                                            <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/location-pin1.svg" alt="">
                                                            <?php echo $career['location_title']; ?>
                                                        </span>
                                                        <h3><?php echo $career['title']; ?></h3>
                                                        <p class="sht-descp"><?php echo $career['short_description']; ?></p>
                                                        <div class="job-meta">
                                                            <span class="j-date">
                                                                <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/calendar.svg" alt="">
                                                                <?php echo date('d M Y', strtotime($career['publish_date'])); ?>
                                                            </span>
                                                            <span class="j-time">
                                                                <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/bookmark.svg" alt="">
                                                                <?php echo $career['jobtype_name']; ?>
                                                            </span>
                                                        </div>
                                                        <div class="job-d-link">
                                                            <a href="<?php echo $career['url']; ?>" class="btn-default"><?php echo $view_details; ?>
                                                                <span><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <div class="col-12">
                                                <div class="alert alert-warning text-center no-record"><?php echo $text_no_record; ?></div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="loadmore-btn text-center" id="loadMoreContainer" style="<?php echo (count($careers) < 6) ? 'display: none;' : ''; ?>">
                                        <a href="javascript:void(0)" id="loadMoreBtn" class="btn-default"><span class="dw-btn"><?php echo $text_load_more;?></span>
                                            <span><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section>
                <div class="career-frm-sec">
                    <div class="container">
                        <div class="career-frm-inn">
                            <div class="career-frm-title">
                                <p><?php echo $text_did_not_find; ?></p>
                                <h2><?php echo $text_send_your_cv; ?></h2>
                            </div>
                            <div class="career-frm-conts">
                                <div class="career-frm-img">
                                    <div class="career-frm-img-inn img-animate">
                                        <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/about-shp.png" alt="">
                                    </div>
                                </div>
                                <div class="career-frm-side">
                                    <div class="apply-now-form">
                                        <form id="careerApplyForm1" enctype="multipart/form-data">
                                            <input type="hidden" name="enquiry_from" value="<?php echo $action; ?>">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text" id="name" name="name" class="form-control" placeholder="<?php echo $text_full_name; ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="tel" id="phone" name="phone" class="form-control" placeholder="<?php echo $text_phone; ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="email" id="email" name="email" class="form-control" placeholder="<?php echo $text_contact_email; ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" id="subject" name="subject" class="form-control" placeholder="<?php echo $subject_lab;?>*">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 message">
                                                    <input id="message" name="message" class="form-control" placeholder="<?php echo $message_lab;?>">
                                                </div>
                                                <div class="col-md-12" id="ap-file-upload">
                                                    <div class="ap-file-upload">
                                                        <h4><?php echo $text_submit_y_resume; ?></h4>
                                                        <p><?php echo $text_lorem_ipsum; ?></p>
                                                        <div class="ap-file-upload-inn uploadFiles">
                                                            <div class="ap-file-upld uploadFile">
                                                                <input type="file" id="cv_file" name="cv_file" class="form-control" accept=".doc,.docx,.pdf">
                                                                <div class="upload">
                                                                    <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/upload.svg" alt="">
                                                                    <span class="tag-line"><?php echo $text_drag_your_resume; ?></span>
                                                                    <span><?php echo $text_acceptable_file; ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="recaptcha_token" value="<?php echo $siteKey; ?>" id="recaptcha_token">
                                                <div class="apply-now-btn">
                                                    <button type="submit" class="cv_submit btn-default">
                                                        <span class="dw-btn"><?php echo $text_btn_submit; ?></span>
                                                        <span><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php echo $footer; ?>
            <div id="loader" class="loader-overlay" style="display: none;">
                <div class="loader"></div>
            </div>
            <script>
                $(document).ready(function() {
                    let page = 1;
                    let isLoading = false;
                    let hasMore = true;
                    const limit = 6;
                    function loadCareers(reset = false) {
                        if (isLoading) return;
                        isLoading = true;
                        $('#loadMoreBtn').html('<span class="dw-btn">Loading...</span> <span><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span>');
                        let formData = {
                            page: page,
                            limit: limit,
                            filter_title: $("input[name='filter_title']").val(),
                            filter_location: $("input[name='filter_location']").val(),
                            filter_jobtype: $("select[name='filter_jobtype']").val()
                        };
                        $.ajax({
                            url: "<?php echo HTTPS_HOST; ?>careers/ajaxCareers",
                            type: "POST",
                            data: formData,
                            dataType: "json",
                            success: function(res) {
                                isLoading = false;
                                $('#loadMoreBtn').html('<span class="dw-btn">Load More</span> <span><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span>');
                                if (res.success) {
                                    if (reset) {
                                        $("#careerList").html("");
                                    }
                                    if (res.careers.length > 0) {
                                        $.each(res.careers, function(i, career) {
                                            $("#careerList").append(`
                                            <div class="job-post-item">
                                                <div class="job-post-item-inn">
                                                    <span class="j-locat"><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/location-pin1.svg"> ${career.location_title}</span>
                                                    <h3>${career.title}</h3>
                                                    <p class="sht-descp">${career.short_description}</p>
                                                    <div class="job-meta">
                                                        <span class="j-date"><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/calendar.svg"> ${career.publish_date}</span>
                                                        <span class="j-time"><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/bookmark.svg"> ${career.jobtype_name}</span>
                                                    </div>
                                                    <div class="job-d-link">
                                                        <a href="${career.url}">View Details <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg"></a>
                                                    </div>
                                                </div>
                                            </div>
                                        `);
                                        });
                                        hasMore = res.has_more;
                                        if (hasMore) {
                                            $("#loadMoreContainer").show();
                                        } else {
                                            $("#loadMoreContainer").hide();
                                        }
                                    } else {
                                        if (reset) {
                                            $("#careerList").html('<div class="col-12"> <div class="alert alert-warning text-center no-record"><?php echo $text_no_record; ?></div></div>');
                                        }
                                        $("#loadMoreContainer").hide();
                                    }
                                } else {
                                    console.error('Error loading careers');
                                }
                            },
                            error: function() {
                                isLoading = false;
                                $('#loadMoreBtn').html('<span class="dw-btn">Load More</span> <span><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span>');
                                console.error('AJAX request failed');
                            }
                        });
                    }
                    $("#careerSearchForm, #careerFilterForm").on("submit change", function(e) {
                        e.preventDefault();
                        page = 1;
                        hasMore = true;
                        loadCareers(true);
                    });
                    $("#loadMoreBtn").on("click", function() {
                        if (hasMore && !isLoading) {
                            page++;
                            loadCareers(false);
                        }
                    });
                });
            </script>
            <script>
                $(document).ready(function() {
                    $(document).on('change', '#cv_file', function() {
                        $('.file-preview').remove();
                        const file = this.files[0];
                        if (file) {
                            $('#cv_file').after('<div class="file-preview">' + file.name + '</div>');
                        }
                    });
                    $(document).on('submit', '#careerApplyForm1', function(e) {
                        e.preventDefault();
                        let valid = true;
                        $('.text-danger').remove();
                        const name = $('#name').val().trim();
                        const email = $('#email').val().trim();
                        const phone = $('#phone').val().trim();
                        const subject = $('#subject').val().trim();
                        const message = $('#message').val().trim();
                        const token = $('#recaptcha_token').val();
                        const file = $('#cv_file')[0].files[0];
                        const nameError = '<?php echo $err_name; ?>';
                        const emailError = '<?php echo $err_email; ?>';
                        const emailErrorInvalid = '<?php echo $err_invalid_email; ?>';
                        const phoneError = '<?php echo $err_phone; ?>';
                        const subjectError = '<?php echo $text_subject_error;?>';
                        const messageError = '<?php echo $text_message_error; ?>';
                        const cvError = '<?php echo $err_cv; ?>';
                        const cvErrorInvalid = '<?php echo $err_invalid_cv; ?>';
                        const recaptchaError = '<?php echo $err_captcha; ?>';
                        if (name === '') {
                            valid = false;
                            $('#name').after('<div class="text-danger">' + nameError + '</div>');
                        }
                        if (email === '') {
                            valid = false;
                            $('#email').after('<div class="text-danger">' + emailError + '</div>');
                        } else if (!validateEmail(email)) {
                            valid = false;
                            $('#email').after('<div class="text-danger">' + emailErrorInvalid + '</div>');
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
                            $('.uploadFiles').after('<div class="text-danger">' + cvError + '</div>');
                        } else {
                            const allowedExtensions = ['pdf', 'doc', 'docx'];
                            const fileExtension = file.name.split('.').pop().toLowerCase();
                            const maxFileSize = 5 * 1024 * 1024;
                            if ($.inArray(fileExtension, allowedExtensions) === -1) {
                                valid = false;
                                $('.uploadFiles').after('<div class="text-danger">' + cvErrorInvalid + '</div>');
                            } else if (file.size > maxFileSize) {
                                valid = false;
                                $('.uploadFiles').after('<div class="text-danger"><?php echo $text_file_error; ?></div>');
                            }
                        }
                        if (token === '') {
                            valid = false;
                            $('#recaptcha_token').after('<div class="text-danger">' + recaptchaError + '</div>');
                        }
                        let url = '<?php echo HTTPS_HOST; ?>careers/careersContactUsForm';
                        let formData = new FormData($(this)[0]);
                     if (valid) {
                        $('#loader').show();
                        $('.cv_submit').prop('disabled', true);
                        try {
                            grecaptcha.ready(function() {
                                grecaptcha.execute('<?php echo $siteKey; ?>', {action: 'contact'}).then(function(token) {
                                    if (!token) {
                                        $('#loader').hide();
                                        $('#recaptcha_token').after('<div class="text-danger"><?php echo $err_captcha; ?></div>');
                                        $('.cv_submit').prop('disabled', false);
                                        return;
                                    }
                                    $('#recaptcha_token').val(token);
                                    $.ajax({
                                        url: url,
                                        type: 'POST',
                                        data: formData,
                                        contentType: false,
                                        processData: false,
                                        dataType: 'json',
                                        success: function(response) {
                                            $('#loader').hide();
                                            $('.cv_submit').prop('disabled', false);
                                            if (response.error) {
                                                $.each(response.error, function(field, errorMsg) {
                                                    $('#' + field).after('<div class="text-danger">' + errorMsg + '</div>');
                                                });
                                            } else if (response.success) {
                                                $('#ap-file-upload').after(
                                                    '<div class="alert alert-success alert-dismissible fade show mt-2" role="alert">' +
                                                    response.success +
                                                    '</div>'
                                                );
                                                $('#careerApplyForm1')[0].reset();
                                                $('.file-preview').remove();
                                            }
                                        },
                                        error: function() {
                                            $('#loader').hide();
                                            $('.cv_submit').prop('disabled', false);
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Submission Error',
                                                text: 'There was an error submitting your application. Please try again later.'
                                            });
                                        }
                                    });
                                }).catch(function() {
                                    $('#loader').hide();
                                    $('.cv_submit').prop('disabled', false);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Verification Error',
                                        text: 'reCAPTCHA verification failed. Please try again.',
                                        showConfirmButton: true
                                    });
                                });
                            });
                        } catch (e) {
                            $('#loader').hide();
                            $('#recaptcha_token').after('<div class="text-danger"><?php echo $err_captcha; ?></div>');
                            $('.cv_submit').prop('disabled', false);
                        }
                    }
                    });
                    function validateEmail(email) {
                        var re = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
                        return re.test(email);
                    }
                });
            </script>