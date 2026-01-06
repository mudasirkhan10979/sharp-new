<?php echo $header; ?>
<?php echo $menuinner; ?>

<div id="smooth-wrapper">
    <div id="smooth-content">
        <div class="main-container">
            <div class="career-detail">
                <div class="container">
                    <div class="service-center-list">
                        <div class="service-center-list-inn">

                            <!-- Banner -->
                            <?php if (!empty($banner)): ?>
                                <div class="s-center-list-title">
                                    <h2><?php echo $banner['title']; ?></h2>
                                    <p><?php echo $banner['short_description']; ?></p>
                                </div>
                            <?php endif; ?>

                            <!-- Filter Form -->
                            <div class="s-center-list-filter">
                                <div class="downlaod-center-filter-inn">
                                    <form id="serviceCenterFilter">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <input type="search" name="keyword" id="keyword" class="form-control" placeholder="<?php echo $text_keyword; ?>" value="<?php echo isset($keyword) ? $keyword : ''; ?>">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="submit" class="dc-filter-btn btn-default"><?php echo $text_search; ?>
                                                    <span><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Service Centers Table -->
                            <div class="s-center-table-list">
                                <div class="s-center-table-list-inn">
                                    <div class="s-center-table">
                                        <div id="serviceCenterResults">
                                            <?php if (!empty($servicecenters)): ?>
                                                <table class="table table-borderless">
                                                    <thead>
                                                        <tr>
                                                            <td>SR</td>
                                                            <td><?php echo $text_country; ?></td>
                                                            <td><?php echo $text_departments; ?></td>
                                                            <td><?php echo $text_service_center_name; ?></td>
                                                            <td><?php echo $text_landline; ?></td>
                                                            <td><?php echo $text_addresss; ?></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($servicecenters as $service): ?>
                                                            <tr>
                                                                <td><?php echo ($service['sr'] < 10 ? '0' . $service['sr'] : $service['sr']); ?></td>
                                                                <td><?php echo $service['country_name']; ?></td>
                                                                <td><?php echo $service['department']; ?></td>
                                                                <td><?php echo $service['service_center_name']; ?></td>
                                                                <td><?php echo $service['landline']; ?></td>
                                                                <td><?php echo html_entity_decode($service['address']); ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                                <?php echo $pagination; ?>
                                            <?php else: ?>
                                                <div class="col-12">
                                                    <div class="alert alert-warning text-center no-record"><?php echo $text_no_record; ?></div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Table -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
           <?php echo $footer; ?>
    </div>

 

    <!-- AJAX Search + Pagination Script -->
    <script>
        $(document).ready(function() {
            // Handle search form submit
            $('#serviceCenterFilter').on('submit', function(e) {
                e.preventDefault();
                loadServiceCenters(1); // always start from page 1
            });

            // Handle pagination click
            $(document).on('click', '.pagination-default a', function(e) {
                e.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                loadServiceCenters(page);
            });

            function loadServiceCenters(page) {
                var data = $('#serviceCenterFilter').serialize();
                data += '&page=' + page;
                $.ajax({
                    url: "<?php echo HTTP_HOST; ?>servicecenters/filter",
                    type: "POST",
                    data: data,
                    success: function(response) {
                        $('#serviceCenterResults').html(response);
                        $('html, body').animate({ scrollTop: $("#serviceCenterResults").offset().top - 100 }, 'slow');
                    }
                });
            }
        });
    </script>

    <!-- Pagination Styles -->
    <style>
        .pagination-default {
            margin: 20px 0;
            text-align: center;
        }

        .pagination-default a,
        .pagination-default span {
            display: inline-block;
            padding: 6px 12px;
            margin: 0 3px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: #333;
            font-size: 14px;
        }

        .pagination-default a:hover {
            background: #f5f5f5;
        }

        .pagination-default .current {
            background: #007bff;
            color: #fff;
            border-color: #007bff;
            font-weight: bold;
            cursor: default;
        }

        .pagination-default .disabled {
            color: #999;
            border-color: #ddd;
            pointer-events: none;
            cursor: not-allowed;
        }
    </style>
