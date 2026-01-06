<?php echo $header; ?>
<?php echo $menuinner; ?>
<div id="smooth-wrapper">
<div id="smooth-content">
<div class="main-container">
<section>
<div class="faqs">
<div class="container">
<div class="faqs-inner">
<div class="faq-title">
<div class="faq-title-inn">
<h2><?php echo $banner['title']; ?></h2>
</div>
</div>
<?php if (!empty($faqs)) { ?>
<div class="faqs-listing">
<div class="faqs-list-inn">
<div class="accordion" id="accordionExample">
<?php foreach ($faqs as $index => $faq): ?>
    <?php
    $headingId  = "heading{$index}";
    $collapseId = "collapse{$index}";
    $isFirst    = ($index === 0);
    ?>
    <div class="accordion-item">
        <h2 class="accordion-header" id="<?php echo $headingId; ?>">
            <button class="accordion-button <?php echo !$isFirst ? 'collapsed' : ''; ?>"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#<?php echo $collapseId; ?>"
                aria-expanded="<?php echo $isFirst ? 'true' : 'false'; ?>"
                aria-controls="<?php echo $collapseId; ?>">
                <?php echo $faq['question']; ?>
            </button>
        </h2>
        <div id="<?php echo $collapseId; ?>"
            class="accordion-collapse collapse <?php echo $isFirst ? 'show' : ''; ?>"
            aria-labelledby="<?php echo $headingId; ?>"
            data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <?php echo $faq['answer']; ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>
</div>
</div>
<?php if (!empty($pagination)) { ?>
    <div class="pagination-default">
        <?php echo $pagination; ?>
    </div>
<?php } ?>
<?php } else { ?>
<div class="col-12">
    <div class="alert alert-warning text-center no-record"><?php echo $text_no_record; ?></div>
</div>
<?php } ?>
</div>
</div>
</div>
</section>
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