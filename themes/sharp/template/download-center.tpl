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
    border-top: 8px solid #394d37;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.alert {
    padding: 1rem;
    margin: 1rem 0;
    border: 1px solid transparent;
    border-radius: 0.25rem;
}

.alert-warning {
    color: #856404;
    background-color: #fff3cd;
    border-color: #ffeaa7;
}

.alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
}

.no-results {
    text-align: center;
    padding: 2rem;
    font-style: italic;
    color: #666;
}

.spinner-border {
    width: 3rem;
    height: 3rem;
}

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

<div id="smooth-wrapper">
    <div id="smooth-content">
        <div class="main-container">
            <?php if (!empty($banner)): ?>
            <section>
                <div class="main-category-banner" style="background: url('<?php echo $banner['image']; ?>');">
                    <div class="container">
                        <div class="cat-banner-inn">
                            <div class="cat-banner-title ab-plasma-title">
                                <h1><span><?php echo $banner['title']; ?></span></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php endif; ?>

            <section>
                <div class="pages-tab-menu">
                    <div class="container">
                        <div class="p-tab-menu-inn">
                            <ul>
                                <li class="active"><a href="<?php echo HTTP_HOST; ?>download-center"><?php echo $text_download_center; ?></a></li>
                                <li><a href="<?php echo HTTP_HOST; ?>source-code-download"><?php echo $text_user_manual; ?></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="download-center-listing">
                    <div class="container">
                        <div class="d-center-listing-inn">
                            <div class="container">
                                <div class="download-center-filter">
                                    <div class="downlaod-center-filter-inn">
                                        <form id="search-form">
                                            <div class="row">
                                                <div class="col-md-5 dc-filter-select">
                                                    <select class="form-select" name="category_id" id="category-filter">
                                                        <option value=""><?php echo $text_select_category; ?></option>
                                                        <?php foreach ($categories as $category): ?>
                                                        <option value="<?php echo $category['category_id']; ?>" <?php echo (!empty($selected_category) && $selected_category == $category['category_id'] ? 'selected' : ''); ?>>
                                                            <?php echo $category['title']; ?>
                                                        </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="search" name="keyword" id="keyword-search" class="form-control" placeholder="<?php echo $text_keyword; ?>" value="<?php echo isset($keyword) ? $keyword : ''; ?>">
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

                                <div class="d-center-listing">
                                    <div class="download-center-list-inn" id="downloads-container">
                                        <?php if (!empty($downloads)) { ?>
                                        <?php foreach ($downloads as $download): ?>
                                        <div class="download-center-item">
                                            <div class="download-center-item-inn">
                                                <h3><?php echo $download['title']; ?></h3>
                                                <div><?php echo html_entity_decode($download['description']); ?></div>
                                                <div class="dc-item-link">
                                                    <a href="<?php echo BASE_URL . 'uploads/image/download_files/' . $download['file']; ?>" target="_blank">
                                                        <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/dc-icon.svg" alt="Download">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                        <?php } else { ?>
                                        <div class="col-12">
                                            <div class="alert alert-warning text-center no-record"><?php echo $text_no_record; ?></div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div id="pagination-container">
                                    <?php if (!empty($pagination)) { ?>
                                    <div class="pagination-default">
                                        <?php echo $pagination; ?>
                                    </div>
                                    <?php } ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- SINGLE OVERLAY LOADER -->
            <div id="loader" class="loader-overlay" style="display: none;">
                <div class="loader"></div>
            </div>

            <script>
            $(document).ready(function() {
                var isLoading = false;
                var currentPage = 1;

                function showLoader() { $('#loader').show(); }
                function hideLoader() { $('#loader').hide(); }

                $('#search-form').on('submit', function(e) {
                    e.preventDefault();
                    currentPage = 1;
                    performSearch();
                });

                $('#category-filter').on('change', function() {
                    currentPage = 1;
                    performSearch();
                });

                $(document).on('click', '#pagination-container a', function(e) {
                    e.preventDefault();
                    var href = $(this).attr('href');
                    var pageMatch = href.match(/page=(\d+)/);
                    if (pageMatch) {
                        currentPage = parseInt(pageMatch[1]);
                        performSearch();
                    }
                });

                function performSearch() {
                    if (isLoading) return;
                    isLoading = true;
                    showLoader();
                    $('#pagination-container').html(''); // clear old pagination

                    var formData = {
                        category_id: $('#category-filter').val(),
                        keyword: $('#keyword-search').val(),
                        page: currentPage
                    };

                    $.ajax({
                        url: '<?php echo HTTPS_HOST; ?>downloadcenter/search',
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            $('#downloads-container').html(response.html);

                            if (response.pagination) {
                                $('#pagination-container').html('<div class="pagination-default">' + response.pagination + '</div>');
                            } else {
                                $('#pagination-container').html('');
                            }

                            var params = new URLSearchParams();
                            if (formData.category_id) params.set('category_id', formData.category_id);
                            if (formData.keyword) params.set('keyword', formData.keyword);
                            if (currentPage > 1) params.set('page', currentPage);

                            var newUrl = '<?php echo HTTP_HOST; ?>download-center' + (params.toString() ? '?' + params.toString() : '');
                            window.history.replaceState({}, '', newUrl);

                            isLoading = false;
                            hideLoader();
                        },
                        error: function() {
                            $('#downloads-container').html('<div class="alert alert-danger">Error loading results. Please try again.</div>');
                            isLoading = false;
                            hideLoader();
                        }
                    });
                }

                <?php if (isset($this->request->get['category_id']) || isset($this->request->get['keyword']) || isset($this->request->get['page'])): ?>
                $(window).on('load', function() { performSearch(); });
                <?php endif; ?>
            });
            </script>

            <?php echo $footer; ?>
