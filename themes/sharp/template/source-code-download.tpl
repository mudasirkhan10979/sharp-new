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
                <div class="pages-tab-menu">
                    <div class="container">
                        <div class="p-tab-menu-inn">
                            <ul>
                                <li><a
                                        href="<?php echo HTTP_HOST; ?>download-center"><?php echo $text_download_center; ?></a>
                                </li>
                                <!-- <li class="active"><a
                                        href="<?php echo HTTP_HOST; ?>source-code-download"><?php echo $text_source_code; ?></a>
                                </li>
                                <li><a
                                        href="<?php echo HTTP_HOST; ?>product-warranty-registration"><?php echo $text_product_warranty; ?></a>
                                </li> -->
                                <li class="active"><a href="<?php echo HTTP_HOST; ?>source-code-download"><?php echo $text_user_manual; ?></a>
                                </li>
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
                                                        <option value="<?php echo $category['category_id']; ?>"
                                                            <?php echo (!empty($selected_category) && $selected_category == $category['category_id'] ? 'selected' : ''); ?>>
                                                            <?php echo $category['title']; ?>
                                                        </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="search" name="keyword" id="keyword-search"
                                                        class="form-control" placeholder="<?php echo $text_keyword; ?>"
                                                        value="<?php echo isset($keyword) ? $keyword : ''; ?>">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="submit"
                                                        class="dc-filter-btn btn-default"><?php echo $text_search; ?>
                                                        <span><img
                                                                src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg"
                                                                alt=""></span></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="d-center-listing">
                                    <div class="soure-code-list-inn" id="sourcecodes-container">
                                        <?php if (!empty($sourcecodes)): ?>
                                        <?php foreach ($sourcecodes as $sourcecode): ?>
                                            <div class="soure-code-item">
                                                <div class="soure-code-item-inn">
                                                    <!-- Display product name + original title -->
                                                    <p>
                                                        <?php 
                                                            // Use product_name if available, otherwise fallback to file name
                                                            $productName = isset($sourcecode['product_name']) ? $sourcecode['product_name'] : pathinfo($sourcecode['file'], PATHINFO_FILENAME);
                                                            echo $productName . ' - ' . $sourcecode['title']; 
                                                        ?>
                                                    </p>
                                                    <!-- Download link with file name -->
                                                  <div class="dc-item-link">
                                                    <a href="<?php echo BASE_URL . 'uploads/image/source_code_files/' . $sourcecode['file']; ?>"
                                                        target="_blank">
                                                        <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/sc-icon.svg"
                                                            alt="Download">
                                                    </a>
                                                </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>

                                        <?php else: ?>
                                        <div class="col-12">
                                            <div class="alert alert-warning text-center"><?php echo $text_no_record; ?>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <div id="pagination-container">
                                        <?php if (!empty($pagination)): ?>
                                        <div class="pagination-default">
                                            <?php echo $pagination; ?>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div id="loader" class="loader-overlay" style="display: none;">
                <div class="loader"></div>
            </div>
            <?php echo $footer; ?>
            <script>
            $(document).ready(function() {
                var isLoading = false;
                var currentPage = 1;

                function showLoader() {
                    $('#loader').show();
                }

                function hideLoader() {
                    $('#loader').hide();
                }

                function formatPagination(paginationHtml) {
                    if (!paginationHtml || paginationHtml.trim() === '') {
                        return '';
                    }
                    var $tempDiv = $('<div>').html(paginationHtml);
                    var $links = $tempDiv.find('a, span');
                    var pages = [];
                    $links.each(function() {
                        var $el = $(this);
                        var text = $el.text().trim();
                        var href = $el.attr('href') || '';
                        var isCurrent = $el.hasClass('current');
                        var isDisabled = $el.hasClass('disabled');
                        var html = $el.prop('outerHTML');
                        var pageNum = null;
                        if (!isNaN(parseInt(text))) {
                            pageNum = parseInt(text);
                            pages.push({
                                element: html,
                                pageNum: pageNum,
                                text: text,
                                isCurrent: isCurrent,
                                isDisabled: isDisabled,
                                isNumeric: true
                            });
                        } else if (text === '&gt;' || text === '&lt;' || text === '>' || text === '<' ||
                            text === '«' || text === '»' || text === '&laquo;' || text === '&raquo;') {
                            pages.push({
                                element: html,
                                pageNum: null,
                                text: text,
                                isCurrent: false,
                                isDisabled: isDisabled,
                                isNumeric: false,
                                isNav: true
                            });
                        }
                    });
                    var numericPages = pages.filter(p => p.isNumeric);
                    if (numericPages.length <= 7) {
                        return paginationHtml;
                    }
                    var currentPageObj = numericPages.find(p => p.isCurrent);
                    if (!currentPageObj) {
                        var urlParams = new URLSearchParams(window.location.search);
                        var urlPage = parseInt(urlParams.get('page')) || 1;
                        currentPageObj = numericPages.find(p => p.pageNum === urlPage) || numericPages[0];
                    }
                    if (!currentPageObj) return paginationHtml;
                    var currentPageNum = currentPageObj.pageNum;
                    var totalPages = numericPages.length;
                    var formattedPages = [];
                    formattedPages.push(numericPages[0].element);
                    var showDotsAfterFirst = currentPageNum > 3;
                    var showDotsBeforeLast = currentPageNum < totalPages - 2;
                    if (showDotsAfterFirst) {
                        formattedPages.push('<span class="dots">...</span>');
                    }
                    var startPage = Math.max(2, currentPageNum - 1);
                    var endPage = Math.min(totalPages - 1, currentPageNum + 1);
                    if (currentPageNum <= 2) {
                        startPage = 2;
                        endPage = Math.min(4, totalPages - 1);
                    } else if (currentPageNum >= totalPages - 1) {
                        startPage = Math.max(2, totalPages - 3);
                        endPage = totalPages - 1;
                    }
                    for (var i = startPage; i <= endPage; i++) {
                        var pageIndex = numericPages.findIndex(p => p.pageNum === i);
                        if (pageIndex !== -1) {
                            formattedPages.push(numericPages[pageIndex].element);
                        }
                    }
                    if (showDotsBeforeLast) {
                        formattedPages.push('<span class="dots">...</span>');
                    }
                    formattedPages.push(numericPages[numericPages.length - 1].element);
                    var navButtons = pages.filter(p => p.isNav);
                    var finalPagination = [];
                    var prevButton = navButtons.find(p =>
                        p.text === '&lt;' || p.text === '<' || p.text === '«' || p.text === '&laquo;'
                    );
                    if (prevButton) {
                        finalPagination.push(prevButton.element);
                    }
                    finalPagination = finalPagination.concat(formattedPages);
                    var nextButton = navButtons.find(p =>
                        p.text === '&gt;' || p.text === '>' || p.text === '»' || p.text === '&raquo;'
                    );
                    if (nextButton) {
                        finalPagination.push(nextButton.element);
                    }

                    return '<div class="pagination-default">' + finalPagination.join('') + '</div>';
                }

                function applyInitialPaginationFormatting() {
                    var initialPagination = $('#pagination-container .pagination-default').html();
                    if (initialPagination) {
                        var formattedPagination = formatPagination(initialPagination);
                        if (formattedPagination !== initialPagination) {
                            $('#pagination-container').html(formattedPagination);
                        }
                    }
                }
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
                    $('#sourcecodes-container').html(
                        '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div></div>'
                        );
                    $('#pagination-container').html('');
                    var formData = {
                        category_id: $('#category-filter').val(),
                        keyword: $('#keyword-search').val(),
                        page: currentPage
                    };
                    $.ajax({
                        url: '<?php echo HTTPS_HOST; ?>sourcecodedownload/search',
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            $('#sourcecodes-container').html(response.html);
                            if (response.pagination) {
                                var formattedPagination = formatPagination(response.pagination);
                                $('#pagination-container').html(formattedPagination);
                            }
                            var params = new URLSearchParams();
                            if (formData.category_id) params.set('category_id', formData
                                .category_id);
                            if (formData.keyword) params.set('keyword', formData.keyword);
                            if (currentPage > 1) params.set('page', currentPage);
                            var newUrl = '<?php echo HTTP_HOST; ?>source-code-download' + (params
                                .toString() ? '?' + params.toString() : '');
                            window.history.replaceState({}, '', newUrl);
                            isLoading = false;
                            hideLoader();
                        },
                        error: function() {
                            $('#sourcecodes-container').html(
                                '<div class="alert alert-danger">Error loading results</div>');
                            isLoading = false;
                            hideLoader();
                        }
                    });
                }
                $(window).on('load', function() {
                    applyInitialPaginationFormatting();

                    <?php if (isset($this->request->get['category_id']) || isset($this->request->get['keyword']) || isset($this->request->get['page'])): ?>
                    performSearch();
                    <?php endif; ?>
                });
            });
            </script>
            <style>
            .pagination-default {
                margin: 20px 0;
                text-align: center;
                display: flex;
                justify-content: center;
                align-items: center;
                flex-wrap: wrap;
                gap: 4px;
            }

            .pagination-default a,
            .pagination-default span {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-width: 40px;
                height: 40px;
                padding: 6px 8px;
                border: 1px solid #e0e0e0;
                border-radius: 6px;
                text-decoration: none;
                color: #333;
                font-size: 14px;
                font-weight: 500;
                transition: all 0.2s ease;
            }

            .pagination-default a:hover {
                background: #f8f9fa;
                border-color: #394d37;
                color: #394d37;
            }

            .pagination-default .current {
                background: #394d37;
                color: #fff;
                border-color: #394d37;
                font-weight: 600;
            }

            .pagination-default .disabled {
                color: #6c757d;
                border-color: #dee2e6;
                background: #f8f9fa;
                cursor: not-allowed;
            }

            .pagination-default .dots {
                color: #6c757d;
                border: none;
                background: none;
                min-width: auto;
                padding: 6px 2px;
                font-weight: bold;
                cursor: default;
            }

            .pagination-default .pagination-prev,
            .pagination-default .pagination-next {
                font-weight: 600;
                background: #f8f9fa;
            }

            .pagination-default .pagination-prev:hover,
            .pagination-default .pagination-next:hover {
                background: #394d37;
                color: #fff;
            }
            </style>