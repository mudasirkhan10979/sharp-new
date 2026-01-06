<?php echo $header; ?>
<?php echo $menuinner; ?>
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
            <?php if (!empty($popular_news)): ?>
            <section>
                <div class="popular-news">
                    <div class="container">
                        <div class="popular-news-inn">
                            <div class="popular-news-title">
                                <h2><?php echo $text_popular; ?></h2>
                            </div>
                            <div class="popular-news-listing">
                                <div class="popular-news-list-inn">
                                    <?php foreach ($popular_news as $news): ?>
                                    <div class="pp-news-list-item">
                                        <div class="pp-news-item-inn">
                                            <div class="pp-news-item-img">
                                                <div class="pp-news-img-inn">
                                                    <img src="<?php echo $news['image']; ?>"
                                                        alt="<?php echo $news['title']; ?>">
                                                </div>
                                            </div>
                                            <div class="pp-news-item-cont">
                                                <div class="pp-news-item-cont-inn">
                                                    <span class="pp-n-date"><?php echo $news['publish_date']; ?></span>
                                                    <h3><?php echo $news['title']; ?></h3>
                                                    <?php if (!empty($news['short_description'])): ?>
                                                    <div class="pp-n-txt">
                                                        <p><?php echo $news['short_description']; ?></p>
                                                    </div>
                                                    <?php endif; ?>
                                                    <div class="pp-n-link">
                                                        <a href="<?php echo $news['href']; ?>" class="btn-default">
                                                            <span class="dw-btn"><?php echo $text_learn_more; ?></span>
                                                            <span><img
                                                                    src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg"
                                                                    alt=""></span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php endif; ?>
            <section>
                <div class="tabs-news-listing">
                    <div class="container">
                        <div class="tabs-news-list-inn">
                            <div class="contauiner">
                                <div class="news-listing-tabs">
                                    <div class="news-list-tabs-inn">
                                        <ul class="nav nav-tabs" id="newsTabs" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="all-tab" data-bs-toggle="tab"
                                                    data-bs-target="#all" type="button" role="tab" aria-controls="all"
                                                    aria-selected="true" data-type="all">
                                                    <?php echo $text_all; ?>
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="news-tab" data-bs-toggle="tab"
                                                    data-bs-target="#news" type="button" role="tab" aria-controls="news"
                                                    aria-selected="false" data-type="news">
                                                    <?php echo $text_news; ?>
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="events-tab" data-bs-toggle="tab"
                                                    data-bs-target="#events" type="button" role="tab"
                                                    aria-controls="events" aria-selected="false" data-type="events">
                                                    <?php echo $text_events; ?>
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="blogs-tab" data-bs-toggle="tab"
                                                    data-bs-target="#blogs" type="button" role="tab"
                                                    aria-controls="blogs" aria-selected="false" data-type="blogs">
                                                    <?php echo $text_blogs; ?>
                                                </button>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="newsTabContent">
                                            <div class="tab-pane fade show active" id="all" role="tabpanel"
                                                aria-labelledby="all-tab">
                                                <?php if (!empty($all_news)): ?>
                                                <div class="news-list-tabs">
                                                    <div class="news-list-tabs-inn">
                                                        <?php foreach ($all_news as $news): ?>
                                                        <div class="news-list-tab-item">
                                                            <div class="nl-tab-item-inn">
                                                                <div class="nl-tab-item-img">
                                                                    <img src="<?php echo $news['image']; ?>"
                                                                        alt="<?php echo $news['title']; ?>">
                                                                </div>
                                                                <div class="nl-tab-item-cnt">
                                                                    <span
                                                                        class="nl-item-date"><?php echo $news['publish_date']; ?></span>
                                                                    <h3 class="nl-title"><?php echo $news['title']; ?>
                                                                    </h3>
                                                                    <div class="pp-n-link">
                                                                        <a href="<?php echo $news['href']; ?>"
                                                                            class="btn-default">
                                                                            <span
                                                                                class="dw-btn"><?php echo $text_learn_more; ?>
                                                                            </span>
                                                                            <span><img
                                                                                    src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg"
                                                                                    alt=""></span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                                <?php if (!empty($pagination)): ?>
                                                <div class="pagination-default">
                                                    <?php echo $pagination; ?>
                                                </div>
                                                <?php endif; ?>
                                                <?php else: ?>
                                                <div class="no-results">
                                                    <p><?php echo $text_no_record; ?></p>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="tab-pane fade" id="news" role="tabpanel"
                                                aria-labelledby="news-tab">
                                                <div class="tab-content-loading">
                                                    <div class="loading-spinner">
                                                        <p><?php echo $text_loading; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="events" role="tabpanel"
                                                aria-labelledby="events-tab">
                                                <div class="tab-content-loading">
                                                    <div class="loading-spinner">
                                                        <p><?php echo $text_loading; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="blogs" role="tabpanel"
                                                aria-labelledby="blogs-tab">
                                                <div class="tab-content-loading">
                                                    <div class="loading-spinner">
                                                        <p><?php echo $text_loading; ?></p>
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
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                const tabs = document.querySelectorAll('.nav-tabs .nav-link');
                const ajaxUrl = '<?php echo HTTPS_HOST; ?>newsevent/filter';
                let currentPage = 1;
                let currentType = 'all';
                const allTabContent = document.getElementById('all').innerHTML;
                tabs.forEach(tab => {
                    tab.addEventListener('click', function(e) {
                        e.preventDefault();
                        tabs.forEach(t => t.classList.remove('active'));
                        this.classList.add('active');
                        const target = this.getAttribute('data-bs-target');
                        const type = this.getAttribute('data-type');
                        document.querySelectorAll('.tab-pane').forEach(pane => {
                            pane.classList.remove('show', 'active');
                        });
                        const targetPane = document.querySelector(target);
                        targetPane.classList.add('show', 'active');
                        currentPage = 1;
                        currentType = type;
                        if (type === 'all') {
                            loadFilteredContent('all', currentPage);
                        } else {
                            targetPane.innerHTML = `
                <div class="tab-content-loading">
                    <div class="loading-spinner">
                        <p><?php echo $text_loading; ?></p>
                    </div>
                </div>
            `;
                            loadFilteredContent(type, currentPage);
                        }
                    });
                });

                function loadFilteredContent(type, page) {
                    fetch(`${ajaxUrl}?type=${type}&page=${page}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                updateTabContent(type, data.news_events, data.pagination);
                            } else {
                                console.error('Error loading content:', data.error);
                                document.querySelector(`#${type}`).innerHTML = `
                        <div class="error-message">
                            <p>Error loading content. Please try again.</p>
                        </div>
                    `;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            document.querySelector(`#${type}`).innerHTML = `
                    <div class="error-message">
                        <p>Error loading content. Please try again.</p>
                    </div>
                `;
                        });
                }

                function updateTabContent(type, newsEvents, pagination) {
                    const tabContent = document.getElementById(type);
                    if (newsEvents.length === 0) {
                        tabContent.innerHTML = `
                <div class="no-results">
                    <p><?php echo $text_no_record; ?></p>
                </div>
            `;
                        return;
                    }
                    let html = `
            <div class="news-list-tabs">
                <div class="news-list-tabs-inn">
        `;
                    newsEvents.forEach(news => {
                        html += `
                <div class="news-list-tab-item">
                    <div class="nl-tab-item-inn">
                        <div class="nl-tab-item-img">
                            <img src="${news.image}" alt="${news.title}">
                        </div>
                        <div class="nl-tab-item-cnt">
                            <span class="nl-item-date">${news.publish_date}</span>
                            <h3 class="nl-title">${news.title}</h3>
                            <div class="pp-n-link">
                                <a href="${news.href}" class="btn-default">
                                    <span class="dw-btn"><?php echo $text_learn_more; ?></span> 
                                    <span><img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrow.svg" alt=""></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            `;
                    });
                    html += `
                </div>
            </div>
        `;
                    if (pagination) {
                        html += `
                <div class="pagination-default">
                    ${pagination}
                </div>
            `;
                    }
                    tabContent.innerHTML = html;
                    attachPaginationListeners(type);
                }

                function attachPaginationListeners(type) {
                    const paginationLinks = document.querySelectorAll(`#${type} .pagination-default a`);
                    paginationLinks.forEach(link => {
                        link.addEventListener('click', function(e) {
                            e.preventDefault();

                            const url = new URL(this.href);
                            const page = url.searchParams.get('page');

                            if (page) {
                                currentPage = parseInt(page);
                                loadFilteredContent(type, currentPage);
                            }
                        });
                    });
                }
                const initialTab = document.querySelector('.nav-link.active');
                if (initialTab && initialTab.getAttribute('data-type') !== 'all') {
                    const type = initialTab.getAttribute('data-type');
                    loadFilteredContent(type, currentPage);
                }
            });
            </script>
            <style>
            .tab-content-loading {
                text-align: center;
                padding: 40px 0;
            }

            .loading-spinner {
                color: #666;
                font-style: italic;
            }

            .loading-spinner:before {
                content: '';
                display: inline-block;
                width: 20px;
                height: 20px;
                border: 2px solid #f3f3f3;
                border-top: 2px solid #3498db;
                border-radius: 50%;
                animation: spin 1s linear infinite;
                margin-right: 10px;
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }

            .error-message {
                text-align: center;
                padding: 40px 0;
                color: #e74c3c;
            }

            .no-results {
                text-align: center;
                padding: 40px 0;
                color: #666;
            }
            </style>
            <?php echo $footer; ?>
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