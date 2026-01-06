<?php  echo $header; ?>
<?php  echo $menuinner; ?>
<style>
.search-results-list {
  display: flex;
  flex-wrap: wrap;
  gap: 40px;
}
.search-results-list .search-item {
  flex: 0 0 31%;
  max-width: 31%;
}
.seach-item-img img {
    width: 100%;
}
.search-results-list .search-item .seach-item-img {
    background: #E8EEF4;
    border-radius: 20px;
    margin-bottom: 20px;
    height: 360px;
    padding: 20px 30px;
}
.seach-item-img img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}
.search-results-list .search-item h3 a {
    font-size: 24px;
    color: #000;
    text-decoration: none;
}
.search-result-sec {
    padding-top: 80px;
    padding-bottom: 80px;
}
.search-result-sec .pagination {
    justify-content: center;
    margin: 30px 0;
}
.search-result-sec .pagination span.page-info {
    margin-left: 15px;
    margin-right: 15px;
}
.search-result-sec .pagination a {
    color: #ed1a3b;
    text-decoration: none;
}
</style>
<div id="smooth-wrapper">
<div id="smooth-content">
<div class="main-container">
<!-- <?php //if (!empty($banner)):?>
<section>
    <div class="main-category-banner" style="background: url('<?php //echo $banner['image'];?>');">
        <div class="container">
            <div class="cat-banner-inn">
                <div class="cat-banner-title ab-plasma-title">
                    <h1>
                        <span><?php //echo $banner['title'];?> </span>
                    </h1>
                </div>
            </div>
        </div>
    </div>
</section>
<?php //endif; ?> -->
<div class="search-result-sec">
<?php if (!empty($keyword)): ?>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <!-- Breadcrumbs -->
        <?php if (!empty($breadcrumbs)): ?>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <?php foreach ($breadcrumbs as $breadcrumb): ?>
                <?php if (!empty($breadcrumb['href'])): ?>
                  <li class="breadcrumb-item"><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php else: ?>
                  <li class="breadcrumb-item active" aria-current="page"><?php echo $breadcrumb['text']; ?></li>
                <?php endif; ?>
              <?php endforeach; ?>
            </ol>
          </nav>
        <?php endif; ?>
        <h1>Search results for "<?php echo htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8'); ?>"</h1>
        <?php if (!empty($products)): ?>
          <div class="search-results-list">
            <?php foreach ($products as $product): ?>
              <div class="search-item">
                <div class="seach-item-img">
                  <img src="<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?>" loading="lazy">
                </div>
                <div class="search-item-info">
                    <h3>
                      <a href="<?php echo $product['url']; ?>">
                        <?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?>
                      </a>
                    </h3>
                  <!-- <p class="price"><?php echo $product['price']; ?></p> -->
                </div>
              </div>
            <?php endforeach; ?>
          </div>
          <!-- Pagination -->
        <?php if (!empty($pagination['pages']) && $pagination['pages'] > 1): ?>
          <div class="pagination-default">
            <!-- Prev button -->
            <?php if ($page > 1): ?>
              <a class="prev page-numbers" href="<?php echo HTTPS_HOST; ?>search?keywords=<?php echo urlencode($keyword); ?>&page=<?php echo ($page - 1); ?>"><?php echo $text_prev; ?></a>
            <?php else: ?>
              <span class="prev page-numbers disabled"><?php echo $text_prev; ?></span>
            <?php endif; ?>
            <!-- Page numbers -->
            <?php for ($i = 1; $i <= $pagination['pages']; $i++): ?>
              <?php if ($i == $page): ?>
                <a class="page-numbers current"><?php echo $i; ?></a>
              <?php else: ?>
                <a class="page-numbers" href="<?php echo HTTPS_HOST; ?>search?keywords=<?php echo urlencode($keyword); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
              <?php endif; ?>
            <?php endfor; ?>
            <!-- Next button -->
            <?php if ($page < $pagination['pages']): ?>
              <a class="next page-numbers" href="<?php echo HTTPS_HOST; ?>search?keywords=<?php echo urlencode($keyword); ?>&page=<?php echo ($page + 1); ?>">next</a>
            <?php else: ?>
              <span class="next page-numbers disabled"><?php echo $text_next; ?></span>
            <?php endif; ?>
          </div>
        <?php endif; ?>
        <?php else: ?>
          <div class="no-results">
            <p><?php echo $text_no_products_found; ?> "<?php echo htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8'); ?>".</p>
            <p><?php echo $text_try_different_keywords; ?></p>
          </div>
        <?php endif; ?>
        
      </div>
    </div>
  </div>
  <?php else: ?>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <p><?php echo $text_enter_search_term; ?></p>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>

<?php echo $footer; ?>
