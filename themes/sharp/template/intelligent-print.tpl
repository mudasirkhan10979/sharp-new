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
</style>
<style>
    .main-category-banner.intl-banner::before {
        content: unset;
    }

    .main-cont-sec {
        padding-top: 70px;
    }

    .detail-fea-item .detail-fea-img img {
        width: 90px !important;
    }

    .detail-fea-inner .owl-nav {
        position: absolute;
        top: -120px;
        right: 0;
        display: flex;
        gap: 20px;
    }

    .modal.show#videoModal .modal-dialog {
        transform: translate(0, 0px);
        max-width: 90%;
        height: 90%;
    }

    #videoModal .modal-content,
    #videoModal .inquire-now-form,
    #videoModal .row,
    #videoModal .col-md-12,
    #videoModal iframe {
        height: 100%;
        width: 100%;
        background: transparent;
        padding: 0;
    }

    #videoModal button.btn-close {
        position: absolute;
        top: -22px;
        right: 15px;
        filter: brightness(0) saturate(100%) invert(100%) sepia(96%) saturate(12%) hue-rotate(211deg) brightness(104%) contrast(100%);
        opacity: 1;
    }

    #videoModal .modal-content .modal-body {
        padding: 0;
    }

    .career-frm-side {
        flex: 0 0 52%;
    }

    .apply-now-form textarea {
        font-size: 16px;
        color: #00000099;
        padding: 0 0 15px;
        background: transparent;
        border: 0;
        border-bottom: 1px solid #6161614d;
        border-radius: 0;
        width: 100%;
    }

    .apply-now-form textarea:focus-visible {
        outline: unset;
    }

    .career-frm-title {
        text-align: left;
    }

    .intl-inquire-form {
        padding-top: 70px;
    }

    .main-cont-txt {
        font-size: 20px;
        color: #000000;
    }

    .benefit-desc {
        width: 850px;
        font-size: 20px;
        margin: 0 auto;
        text-align: center;
    }

    .benefit-item-wrap .col-md-6:nth-child(4n+1) .benefit-item::before,
    .benefit-item-wrap .row .col-md-6:nth-child(4n+3) .benefit-item::before {
        height: 87%;
    }
    .intl-inquire-form .career-frm-inn {
        padding: 70px 50px;
    }
    .benefit-sec-title {
        text-align: center;
    }
    @media (min-width: 1200px) {
        .intl-inquire-form .container {
            max-width: 100%;
            padding-left: 50px;
            padding-right: 50px;
        }
    }

    @media (min-width: 1500px) {
        .intl-inquire-form .career-frm-inn {
            padding: 122px 50px;
        }
    }

    .intl-inquire-form .career-frm-inn {
        background: #F1F1F1;
        border-radius: 20px;
    }

    @media (max-width: 480px) {
        .detail-fea-inner .owl-nav {
            top: unset;
            bottom: -34px;
        }

        .benefit-desc {
            width: auto;
        }

        .benefit-item-desc ul {
            padding: 0;
        }

        .career-frm-conts {
            display: block;
            padding: 30px;
        }

        .career-frm-title h2 {
            font-size: 35px;
        }

        .career-frm-side {
            padding-top: 35px;
        }

        .career-frm-title p {
            font-size: 20px;
        }

        .career-frm-side .apply-now-form .row .col-md-6 {
            width: 100%;
            margin-bottom: 35px;
        }

        .career-frm-side .apply-now-form .row .col-md-6 input.form-control {
            margin: 0;
        }

        .career-frm-side .apply-now-form .row {
            margin-bottom: 0;
            column-gap: 0;
        }

        .apply-now-form .row .col-md-12.message {
            margin-bottom: 0;
        }
    }
</style>
<div id="smooth-wrapper">
    <div id="smooth-content">
        <div class="main-container">
         <?php if (!empty($banner)): ?> 
            <section>
                <div class="main-category-banner intl-banner" style="background: url('<?php echo $banner['image']; ?>');">
                    <div class="container">
                        <div class="cat-banner-inn">
                            <div class="cat-banner-title ab-plasma-title">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
          <?php endif; ?>
            <section>
                <div class="main-cont-sec">
                    <div class="container">
                        <div class="main-cont-inn">
                            <div class="main-cont-txt">
                                <p><strong>Sharp Intelligent Print Services (IPS)</strong> is a comprehensive, holistic approach to optimizing and managing all aspects of an organization's document output and print environment. It involves outsourcing the management of a company's printing devices—such as printers, scanners, copiers, and multifunction devices (MFDs)—to a specialized Sharp provider under a contractual agreement.</p>

                                <p>The core function of IPS <i>is to gain control, visibility, and efficiency over a business's entire print infrastructure.</i></p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="detail-features-sec top-space default-sec">
                <div class="container">
                    <div class="detail-fea-wrap">
                        <h2>Features</h2>
                        <div class="detail-fea-inner owl-carousel">
                            
                            <div class="detail-fea-item">
                                <div class="detail-fea-img">
                                    <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/assessment-icon.png" alt="" />
                                </div>
                                <div class="detail-fea-content">
                                    <h4>Assessment and Optimization</h4>
                                    <div class="detail-desc">
                                        A thorough analysis of the current print environment to identify inefficiencies, right-size the fleet (reducing redundant devices), and recommend the optimal placement of equipment.
                                    </div>
                                </div>
                            </div>
                            <div class="detail-fea-item">
                                <div class="detail-fea-img">
                                    <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/proactive-icon.png" alt="" />
                                </div>
                                <div class="detail-fea-content">
                                    <h4>Proactive Management and Maintenance</h4>
                                    <div class="detail-desc">
                                        Continuous remote monitoring of all devices to predict and prevent issues, ensuring maximum uptime. This includes automated maintenance, diagnostics, and repairs.
                                    </div>
                                </div>
                            </div>
                            <div class="detail-fea-item">
                                <div class="detail-fea-img">
                                    <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/software-icon.png" alt="" />
                                </div>
                                <div class="detail-fea-content">
                                    <h4>Software and Security</h4>
                                    <div class="detail-desc">
                                        Implementation of print management software for tracking usage, setting print policies, and deploying robust security features like secure print release (requiring user authentication) and data encryption.
                                    </div>
                                </div>
                            </div>
                            <div class="detail-fea-item">
                                <div class="detail-fea-img">
                                    <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/automated-icon.png" alt="" />
                                </div>
                                <div class="detail-fea-content">
                                    <h4>Automated Supply Replenishment</h4>
                                    <div class="detail-desc">
                                        Monitoring of toner and ink levels with automatic, just-in-time delivery of supplies to prevent running out, eliminating the need for manual ordering and stock-piling.
                                    </div>
                                </div>
                            </div>
                            <div class="detail-fea-item">
                                <div class="detail-fea-img">
                                    <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/consolidated-icon.png" alt="" />
                                </div>
                                <div class="detail-fea-content">
                                    <h4>Consolidated Billing and Support</h4>
                                    <div class="detail-desc">
                                        Providing a single point of contact and a predictable, consolidated monthly invoice that covers all hardware, service, and supplies.
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
            <section class="detail-banner top-space default-sec">
                <div class="container">
                    <div class="detail-banner-img img-animate">
                        <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/intl-vd-thumbnail.jpg" alt="detail banner" />
                    </div>
                    <div class="play-btn">
                        <a href="#" class="btn-default" data-bs-toggle="modal" data-bs-target="#videoModal">Play <span><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span></a>
                    </div>
                </div>
            </section>
            <section class="benefits-sec top-space default-sec">
                <div class="container">
                    <div class="benefit-sec-title">
                        <h2>Benefits of Sharp Intelligent Print Services for Businesses</h2>
                        <div class="benefit-desc">
                            Intelligent Print Services offer substantial benefits to businesses by transforming a traditionally chaotic and expensive function into a strategic, controlled, and efficient operation.
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="benefit-content">
                                <div class="benefit-item-list">
                                    <div class="benefit-item-wrap">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="benefit-item">
                                                    <div class="benefit-icon">
                                                        <img src="<?php echo BASE_URL; ?>themes/sharp/assets/images/star.svg" alt="" />
                                                    </div>

                                                    <div class="benefit-item-desc">
                                                        <h6>Significant Cost Reduction and Control</h6>
                                                        <ul>
                                                            <li><strong>Lower Total Cost of Ownership (TCO):</strong> IPS providers optimize the entire print environment, leading to a reduction in printing costs, often by <strong>20% to 40%</strong> or more.</li>
                                                            <li><strong>Predictable Budgeting:</strong> Costs are moved from unpredictable capital expenditure (CapEx) for hardware and emergency repairs to a fixed, per-page, or all-inclusive monthly operational expenditure (OpEx), making budgeting clear and easy.</li>
                                                            <li><strong>Right-Sizing the Fleet:</strong> The assessment phase removes underutilized or inefficient legacy devices, reducing maintenance and energy costs.</li>
                                                            <li><strong>Waste Elimination:</strong> Detailed print reporting and automated supply management prevent over-ordering and waste of consumables.</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="benefit-item">
                                                    <div class="benefit-icon">
                                                        <img src="<?php echo BASE_URL; ?>themes/sharp/assets/images/chart-pie.svg" alt="" />
                                                    </div>

                                                    <div class="benefit-item-desc">
                                                        <h6>Improved Productivity and Efficiency</h6>
                                                        <ul>
                                                            <li><strong>Minimize Downtime:</strong> Proactive and predictive maintenance, remote monitoring, and automated supplies ordering ensure devices are always running, eliminating staff time wasted on troubleshooting, ordering toner, and fixing paper jams.</li>
                                                            <li><strong>Free Up IT Staff:</strong> IPS offloads the entire burden of managing, maintaining, and supporting the print fleet from internal IT teams, allowing them to focus on more critical, business-centric projects.</li>
                                                            <li><strong>Streamlined Workflows:</strong> Advanced MFDs and software enhance document workflows, such as automated scanning to digital repositories, mobile printing, and "follow-me" secure print release.</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="benefit-item-wrap">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="benefit-item">
                                                    <div class="benefit-icon">
                                                        <img src="<?php echo BASE_URL; ?>themes/sharp/assets/images/shopping-basket.svg" alt="" />
                                                    </div>

                                                    <div class="benefit-item-desc">
                                                        <h6>Enhanced Security and Compliance</h6>
                                                        <ul>
                                                            <li><strong>Secure Documents:</strong> IPS implements critical security features like user authentication (PIN, badge swipe) for document release, ensuring confidential documents are not left unsecured at the printer.</li>
                                                            <li><strong>Device and Data Protection:</strong> Providers ensure firmware is updated, implement secure protocols, and can provide features like hard drive wiping for old devices, minimizing the printer as an entry point for cyber threats.</li>
                                                            <li><strong>Regulatory Compliance:</strong> IPS helps organizations meet industry-specific regulations (like HIPAA or GDPR) by securing document workflows and audit trails.</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="benefit-item">
                                                    <div class="benefit-icon">
                                                        <img src="<?php echo BASE_URL; ?>themes/sharp/assets/images/poll-vertical-circle.svg" alt="" />
                                                    </div>

                                                    <div class="benefit-item-desc">
                                                        <h6>Environmental Sustainability</h6>
                                                        <ul>
                                                            <li><strong>Reduced Carbon Footprint:</strong> Providers implement policies like defaulting to duplex (double-sided) and black-and-white printing, and deploying energy-efficient devices.</li>
                                                            <li><strong>Waste Reduction:</strong> Monitoring usage and optimizing the fleet reduces unnecessary paper consumption and waste from improperly ordered or stored toner cartridges.</li>
                                                            <li><strong>Managed Recycling:</strong> IPS often includes programs for the proper and responsible recycling of toner cartridges and old equipment.
                                                            </li>
                                                        </ul>
                                                    </div>
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
            <section>
                <div class="career-frm-sec intl-inquire-form">
                    <div class="container">
                        <div class="career-frm-inn">
                            <div class="career-frm-conts">
                                <div class="career-frm-img">
                                    <div class="career-frm-img-inn img-animate">
                                        <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/about-shp.png" alt="">
                                    </div>
                                </div>
                                <div class="career-frm-side">
                                    <div class="apply-now-form">
                                        <div class="career-frm-title">
                                            <p>Who want to Inquire?</p>
                                            <h2>Send us a message</h2>
                                        </div>
                                        <form action="" id="intelligentPrintForm" enctype="multipart/form-data">
                                            <input type="hidden" name="enquiry_from" value="<?php echo $action; ?>">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text" id="name" name="name" class="form-control" placeholder="Full Name*">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="tel" id="phone" name="phone" class="form-control" placeholder="Contact Number*">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="email" id="email" name="email" class="form-control" placeholder="Email*">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" id="subject" name="subject" class="form-control" placeholder="Subject*">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 message messagesuccess">
                                                    <textarea id="message" name="message" placeholder="Message*"></textarea>
                                                </div>
                                                <div class="apply-now-btn">
                                                    <button type="submit" class="cv_submit btn-default"><span class="dw-btn">Submit</span> <span><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span></button>
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
            <!-- youtube video -->
            <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            <div class="inquire-now-form">
                                <div class="row">
                                    <div class="col-md-12">
                                        <iframe
                                            src="https://www.youtube.com/embed/2ogWyvezD4g?showinfo=0&playlist=2ogWyvezD4g&loop=0&autoplay=1&controls=1&mute=1"
                                            title="YouTube video player"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen>
                                        </iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function() {
                    $(document).on('submit', '#intelligentPrintForm', function(e) {
                        e.preventDefault();
                        let valid = true;
                        $('.text-danger').remove();
                        $('.alert-success').remove();
                        const name = $('#name').val().trim();
                        const email = $('#email').val().trim();
                        const phone = $('#phone').val().trim();
                        const subject = $('#subject').val().trim();
                        const message = $('#message').val().trim();
                        const nameError = '<?php echo $err_name; ?>';
                        const emailError = '<?php echo $err_email; ?>';
                        const emailErrorInvalid = '<?php echo $err_invalid_email; ?>';
                        const phoneError = '<?php echo $err_phone; ?>';
                        const subjectError = 'Please provide your subject';
                        const messageError = 'Please provide your message';
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
                        let url = '<?php echo HTTPS_HOST; ?>intelligentprint/IntelligentPrintFormAjax';
                        let formData = new FormData($(this)[0]);
                        if (valid) {
                            $('#loader').show();
                            $('.cv_submit').prop('disabled', true);
                            $.ajax({
                                url: url,
                                type: 'POST',
                                data: formData,
                                contentType: false,
                                processData: false,
                                dataType: 'json',
                                success: function(response) {
                                    $('#loader').hide();
                                    if (response.error) {
                                        $.each(response.error, function(field, errorMsg) {
                                            $('#' + field).after('<div class="text-danger">' + errorMsg + '</div>');
                                        });
                                        $('.cv_submit').prop('disabled', false);
                                    } else if (response.success) {
                                         $('#message').closest('.messagesuccess').after(
                                            '<div class="alert alert-success alert-dismissible fade show mt-2" role="alert">' +
                                            response.success +
                                            '</div>'
                                        );
                                        $('#intelligentPrintForm')[0].reset();
                                        $('.cv_submit').prop('disabled', false);
                                      setTimeout(function() {
                                            $('.alert-success').fadeOut(500, function() {
                                                $(this).remove();
                                                $('.cv_submit').prop('disabled', false);
                                            });
                                        }, 15000);
                                    }
                                },
                                error: function() {
                                    $('#loader').hide();
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Submission Error',
                                        text: 'There was an error submitting your application. Please try again later.'
                                    });
                                }
                            });
                        }
                    });

                    function validateEmail(email) {
                        var re = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
                        return re.test(email);
                    }
                });
            </script>