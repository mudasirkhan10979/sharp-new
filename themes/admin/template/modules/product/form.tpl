<?php echo $header; ?>
<style>
    .select2-selection__choice {
        font-family: Arial, Helvetica, sans-serif !important;
        font-size: 13px !important;
    }
</style>
<style>
    /* Input field styling */
    .multi-select {
        border: 1px solid #ced4da;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 8px 12px;
        font-size: 14px;
        width: 100%;
        /* Ensures it takes the full width of the parent column */
    }
    /* Dropdown menu styling */
    .dropdown-menu {
        width: 100%;
        /* Aligns with the width of the input field */
        border: 1px solid #ced4da;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .dropdown-menu li a {
        padding: 8px 12px;
        display: block;
    }
    .dropdown-menu li a:hover {
        background-color: #f8f9fa;
    }
    /* Scrollable area styling */
    .multi-select-well {
        border: 1px solid #ced4da;
        background-color: #f8f9fa;
        padding: 8px;
        overflow-y: auto;
        width: 100%;
        /* Matches the width of the column */
    }
    /* Responsive adjustments for smaller devices */
    @media (max-width: 768px) {
        .multi-select,
        .dropdown-menu,
        .multi-select-well {
            font-size: 16px;
        }
    }
    .table-responsive .input-group {
        height: auto;
    }
</style>
<style>
   /* Remove default checkbox styling completely */
#input-is-new {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    width: 20px;
    height: 20px;
    border: 2px solid #ccc;
    border-radius: 4px;
    cursor: pointer;
    position: relative;
    background-color: #fff;
}

/* Checked state */
#input-is-new:checked {
    border-color: blue;
    background-color: blue;
}

/* Add single custom check icon */
#input-is-new:checked::after {
    /* content: "✔"; */
    color: white;
    font-size: 14px;
    position: absolute;
    top: 1px;
    left: 3px;
}
/* Label styling */
#tab-data .form-check-label {
    line-height: 25px;
    margin-left: 10px;
}
</style>
<div class="main-panel">
    <div class="sec-head">
        <div class="sec-head-title">
            <h3><?php echo $text_form; ?></h3>
        </div>
        <div class="sec-head-btns">
        <?php if (!$viewer) { ?>
            <button type="submit" form="form-customer" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
           <?php } ?>
            <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-primary"><i class="fa fa-reply"></i></a>
        </div>
    </div>
    <div class="main-employee-box">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <?php if ($error_warning) { ?>
                    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>
                        <?php echo $error_warning; ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                <?php $_SESSION['error_warning'] = null;
                } ?>
                <?php if ($this->session->data['success']) { ?>
                    <div class="alert alert-success"><i class="fa fa-check-circle"></i>
                        <?php echo $this->session->data['success']; ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                <?php $this->session->data['success'] = null;
                }  ?>
                <?php $css = 'style="border-color: red;"'; ?>
                <?php $css1 = 'style="outline: 1px solid rgb(255 0 0 / 100%);"'; ?>
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-user" class="form-horizontal">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
                        <li><a href="#tab-data" data-toggle="tab">Data</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-general">
                            <ul class="nav nav-tabs" id="language">
                                <?php foreach ($languages as $lang) { ?>
                                    <li><a href="#language<?php echo $lang['language_id'] ?>" data-toggle="tab"><img src="/vars/lang/be/<?php echo $lang['code']; ?>-<?php echo $lang['image']; ?>" />
                                            <?php echo $lang['name'] ?></a></li>
                                <?php } ?>
                            </ul>
                            <div class="tab-content">
                                <?php foreach ($languages as $lang) { ?>
                                    <div class="tab-pane" id="language<?php echo $lang['language_id'] ?>">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group required">
                                                <label class="control-label" for="input-name<?php echo $lang['language_id'] ?>">
                                                    Title
                                                </label>
                                                <input type="text" name="product_description[<?php echo $lang['language_id'] ?>][name]" value="<?php echo isset($product_description[$lang['language_id']]) ? $product_description[$lang['language_id']]['name'] : ''; ?>" placeholder="Title" id="input-name<?php echo $lang['language_id'] ?>" class="form-control" />
                                                <?php if (isset($error_name[$lang['language_id']])) { ?>
                                                    <div class="text-danger">
                                                        <?php echo $error_name[$lang['language_id']]; ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group required">
                                                <label class="control-label" for="input-short_description<?php echo $lang['language_id'] ?>">
                                                    Short Description
                                                </label>
                                                <textarea name="product_description[<?php echo $lang['language_id'] ?>][short_description]" rows="5" placeholder="Short Description" id="input-short-description<?php echo $lang['language_id'] ?>" class="form-control"><?php echo isset($product_description[$lang['language_id']]) ? $product_description[$lang['language_id']]['short_description'] : ''; ?></textarea>
                                                <?php if (isset($error_s_description[$lang['language_id']])) { ?>
                                                    <div class="text-danger">
                                                        <?php echo $error_s_description[$lang['language_id']]; ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                         <div class="col-lg-6 col-md-6">
                                            <div class="form-group required">
                                                <label class="control-label" for="input-product_description<?php echo $lang['language_id'] ?>">
                                                    Description
                                                </label>
                                                <textarea name="product_description[<?php echo $lang['language_id'] ?>][full_description]" placeholder="Description" id="input-description<?php echo $lang['language_id'] ?>" class="form-control"> <?php echo isset($product_description[$lang['language_id']]) ? $product_description[$lang['language_id']]['full_description'] : ''; ?></textarea>
                                                <?php if (isset($error_f_description[$lang['language_id']])) { ?>
                                                    <div class="text-danger">
                                                        <?php echo $error_f_description[$lang['language_id']]; ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="input-meta_title<?php echo $lang['language_id'] ?>">
                                                    Meta Title
                                                </label>
                                                <input type="text" name="product_description[<?php echo $lang['language_id'] ?>][meta_title]" value="<?php echo isset($product_description[$lang['language_id']]) ? $product_description[$lang['language_id']]['meta_title'] : ''; ?>" placeholder="Meta Title" id="input-meta_title<?php echo $lang['language_id'] ?>" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="input-meta_keyword<?php echo $lang['language_id'] ?>">
                                                    Meta Keyword
                                                </label>
                                                <input type="text" name="product_description[<?php echo $lang['language_id'] ?>][meta_keyword]" value="<?php echo isset($product_description[$lang['language_id']]) ? $product_description[$lang['language_id']]['meta_keyword'] : ''; ?>" placeholder="Meta Keyword" id="input-meta_keyword<?php echo $lang['language_id'] ?>" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="input-meta_description<?php echo $lang['language_id'] ?>">
                                                    Meta Description
                                                </label>
                                                <textarea rows="5" name="product_description[<?php echo $lang['language_id'] ?>][meta_description]" placeholder="Meta Description" id="input-meta_description<?php echo $lang['language_id'] ?>" class="form-control"><?php echo isset($product_description[$lang['language_id']]) ? $product_description[$lang['language_id']]['meta_description'] : ''; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <div class="tab-pane" id="tab-data">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <div class="form-check">
                                    <input type="hidden" name="is_new" value="0">
                                    <input type="checkbox" name="is_new" id="input-is-new" value="1" class="form-check-input"
                                        <?php echo isset($is_new) && $is_new == '1' ? 'checked' : ''; ?> />
                                    <label class="form-check-label" for="input-is-new">
                                        Mark as New Product
                                    </label>
                                </div>
                            </div>
                        </div>
                       <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-seo_url">
                                        Seo Url
                                    </label>
                                    <input type="text" name="seo_url" value="<?php echo $seo_url; ?>"
                                        class="form-control" />
                                    <?php if (isset($error_seo_url)) { ?>
                                    <div class="text-danger">
                                        <?php echo $error_seo_url; ?>
                                    </div>
                                    <?php } ?>
                                </div>
                             </div>

                             <div class="col-lg-6 col-md-6">
            
                                 <div class="form-group">
                                    <label class="control-label" for="input-tags">
                                        Product Tags
                                    </label>
                                    <select name="product_tags[]" id="product_tags" class="js-select6 select-large form-control" multiple="multiple">
                                        <?php 
                                        if (!empty($product_tags)) {
                                            $tags = explode(',', $product_tags);
                                            foreach ($tags as $tag) { ?>
                                                <option value="<?php echo trim($tag); ?>" selected="selected"><?php echo trim($tag); ?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                                <!-- <?php if (isset($error_product_tags)) { ?>
                                    <div class="text-danger">
                                        <?php echo $error_product_tags; ?>
                                    </div>
                                <?php } ?> -->
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group required">
                                    <label class="control-label" for="input-category-id">
                                     Categories
                                    </label>
                                    <select name="category_id" id="input-category-id" class="form-control">
                                        <option value="">Choose Category</option>
                                        <?php 
                                        foreach ($categories as $category) { ?>
                                        <option value="<?php echo $category['category_id']; ?>"
                                            <?php echo ($category['category_id'] == $category_id) ? "selected" : ""; ?>>
                                            <?php echo $category['title']; ?>
                                        </option>
                                        <?php  } ?>
                                    </select>
                                    <?php if ($error_category_id) { ?>
                                        <div class="text-danger">
                                            <?php echo $error_category_id; ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div> 
                             <!-- <div class="col-lg-6 col-md-6">
                                <div class="form-group required">
                                    <label class="control-label" for="input-country-id">
                                     Countries
                                    </label>
                                    <select name="country_id" id="input-country-id" class="form-control">
                                        <option value="">Choose Category</option>
                                        <?php 
                                        foreach ($countries as $country) { ?>
                                        <option value="<?php echo $country['country_id']; ?>"
                                            <?php echo ($country['country_id'] == $country_id) ? "selected" : ""; ?>>
                                            <?php echo $country['name']; ?>
                                        </option>
                                        <?php  } ?>
                                    </select>
                                    <?php if ($error_country_id) { ?>
                                        <div class="text-danger">
                                            <?php echo $error_country_id; ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>  -->
                           <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-screensize-id">
                                     Screen Size
                                    </label>
                                    <select name="screensize_id" id="input-screensize-id" class="form-control">
                                        <option value="">Choose Screen Size</option>
                                        <?php 
                                        foreach ($screensizes as $screensize) { ?>
                                        <option value="<?php echo $screensize['id']; ?>"
                                            <?php echo ($screensize['id'] == $screensize_id) ? "selected" : ""; ?>>
                                            <?php echo $screensize['title']; ?>
                                        </option>
                                        <?php  } ?>
                                    </select>
                                    <!-- <?php if ($error_screensize_id) { ?>
                                        <div class="text-danger">
                                            <?php echo $error_screensize_id; ?>
                                        </div>
                                    <?php } ?> -->
                                </div>
                            </div> 
                             <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-resolution-id">
                                     Resolution
                                    </label>
                                    <select name="resolution_id" id="input-resolution-id" class="form-control">
                                        <option value="">Choose Resolution</option>
                                        <?php 
                                        foreach ($resolutions as $resolution) { ?>
                                        <option value="<?php echo $resolution['id']; ?>"
                                            <?php echo ($resolution['id'] == $resolution_id) ? "selected" : ""; ?>>
                                            <?php echo $resolution['title']; ?>
                                        </option>
                                        <?php  } ?>
                                    </select>
                                    <!-- <?php if ($error_resolution_id) { ?>
                                        <div class="text-danger">
                                            <?php echo $error_resolution_id; ?>
                                        </div>
                                    <?php } ?> -->
                                </div>
                            </div> 
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-sku">
                                        SKU
                                    </label>
                                    <input type="text" name="sku" value="<?php echo $sku; ?>" class="form-control" />
                                </div>
                                <!-- <?php if (isset($error_sku)) { ?>
                                    <div class="text-danger">
                                        <?php echo $error_sku; ?>
                                    </div>
                                <?php } ?> -->
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-product_serial_number">
                                        Product Serial Number
                                    </label>
                                    <input type="text" name="product_serial_number" value="<?php echo $product_serial_number; ?>" class="form-control" />
                                </div>
                            </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="input-video-url">
                                    Video (Youtube or Vimeo)
                                </label>
                                <input type="text" name="video_url" value="<?php echo $video_url; ?>" placeholder="https://youtube.com/example or https://vimeo.com/example" class="form-control" />
                            </div>
                            <!-- <?php if (isset($error_video_url)) { ?>
                                <div class="text-danger">
                                    <?php echo $error_video_url; ?>
                                </div>
                            <?php } ?> -->
                        </div>
                             <div class="col-lg-6 col-md-6">
                                <div class="form-group required">
                                    <label class="control-label" for="input-publish_date">
                                        Publish Date
                                    </label>
                                    <input type="date" name="publish_date" value="<?php echo $publish_date; ?>" class="form-control" />
                                </div>
                                <?php if (isset($error_publish_date)) { ?>
                                    <div class="text-danger">
                                        <?php echo $error_publish_date; ?>
                                    </div>
                                <?php } ?>
                            </div>
                         <!-- IMAGE FIELDS -->
                        <div class="row">
                            <!-- Main Image -->
                            <div class="col-md-6">
                                <div class="form-group required">
                                    <label class="control-label" for="input-image">Image</label>
                                    <input onchange="load2File(event)" type="file" name="image" id="image" accept=".png,.jpg,.jpeg">
                                </div>
                                <?php if ($error_image) { ?>
                                    <div class="text-danger"><?php echo $error_image; ?></div>
                                <?php } ?>
                            </div>

                            <div class="col-lg-2 col-md-2 position-relative">
                                <img id="cimage" src="../uploads/image/product/<?= $image ?: 'no_image.png' ?>" style="width:100%; height:89px; margin-top:12px;">
                                <button type="button" class="btn btn-danger btn-sm delete-image-btn"
                                    style="position:absolute; top:0; right:0; <?= $image ? '' : 'display:none;' ?>"
                                    onclick="handleDeleteImage('main', '<?= $product_id ?>')">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                                <input type="hidden" id="hidden_image" name="image" value="<?= $image ?>">
                            </div>
                        </div>
                        <!-- Featured Image -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-featured-image">Featured Image</label>
                                    <input onchange="load5File(event)" type="file" name="featured_image" id="featured_image" accept=".png,.jpg,.jpeg">
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 position-relative">
                                <img id="cfeaturedimage" src="../uploads/image/product/<?= $featured_image ?: 'no_image.png' ?>" style="width:100%; height:89px; margin-top:12px;">
                                <button type="button" class="btn btn-danger btn-sm delete-image-btn"
                                    style="position:absolute; top:0; right:0; <?= $featured_image ? '' : 'display:none;' ?>"
                                    onclick="handleDeleteImage('featured_image', '<?= $product_id ?>')">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                                <input type="hidden" id="hidden_featured_image" name="featured_image" value="<?= $featured_image ?>">
                            </div>
                        </div>



                        <!-- Thumbnail -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-thumbnail">Middle image</label>
                                    <input onchange="load3File(event)" type="file" name="thumbnail" id="thumbnail" accept=".png,.jpg,.jpeg">
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 position-relative">
                                <img id="cthumbnail" src="../uploads/image/product/<?= $thumbnail ?: 'no_image.png' ?>" style="width:100%; height:89px; margin-top:12px;">
                                <button type="button" class="btn btn-danger btn-sm delete-image-btn"
                                    style="position:absolute; top:0; right:0; <?= $thumbnail ? '' : 'display:none;' ?>"
                                    onclick="handleDeleteImage('thumbnail', '<?= $product_id ?>')">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                                <input type="hidden" id="hidden_thumbnail" name="thumbnail" value="<?= $thumbnail ?>">
                            </div>
                        </div>

                        <!-- Benefits Image -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-benefits_image">Benefits image</label>
                                    <input onchange="load4File(event)" type="file" name="benefits_image" id="benefits_image" accept=".png,.jpg,.jpeg">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 position-relative">
                                <img id="cbenefits_image" src="../uploads/image/product/<?= $benefits_image ?: 'no_image.png' ?>" style="width:100%; height:89px; margin-top:12px;">
                                <button type="button" class="btn btn-danger btn-sm delete-image-btn"
                                    style="position:absolute; top:0; right:0; <?= $benefits_image ? '' : 'display:none;' ?>"
                                    onclick="handleDeleteImage('benefits', '<?= $product_id ?>')">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                                <input type="hidden" id="hidden_benefits_image" name="benefits_image" value="<?= $benefits_image ?>">
                            </div>
                          </div>

                            </br>
                            </br>
                            </br>
                           <div class="row">
                                <div class="table-responsive">
                                    <table id="slider_images" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <td class="text-left">Slider Images</td>
                                                 <td class="text-left">Color</td>
                                                <td class="text-right">Sort Order</td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $slider_row = 0;
                                            foreach ($slider_images as $slider_image) {
                                            ?>
                                                <tr id="slider-row<?php echo $slider_row; ?>">
                                                    <td class="text-left">
                                                        <a href="" id="thumb-slider<?php echo $slider_row; ?>" data-type="slider" data-row="<?php echo $slider_row; ?>" class="image-picker">
                                                            <img src="<?php echo $slider_image['thumb']; ?>" alt="" class="image-preview" style="width: 100px; height: 100px;" />
                                                        </a>
                                                        <input type="hidden" name="slider_images[<?php echo $slider_row; ?>][image]" value="<?php echo $slider_image['image']; ?>" id="input-slider<?php echo $slider_row; ?>" />
                                                    </td>

                                                    <td class="text-left d-flex align-items-center gap-2">
                                                        <?php 
                                                            $color_value = !empty($slider_image['color']) ? $slider_image['color'] : '';
                                                        ?>
                                                        
                                                        <input type="color"
                                                            id="color-picker-<?php echo $slider_row; ?>"
                                                            value="<?php echo $color_value ?: '#000000'; ?>" 
                                                            onchange="document.getElementById('color-input-<?php echo $slider_row; ?>').value = this.value;"
                                                            style="width: 40px; height: 38px; border: none; background: none;"
                                                            onfocus="if(this.value==''){this.value='';}" />

                                                        <input type="text"
                                                            id="color-input-<?php echo $slider_row; ?>"
                                                            name="slider_images[<?php echo $slider_row; ?>][color]"
                                                            value="<?php echo $color_value; ?>"
                                                            class="form-control"
                                                            placeholder=""
                                                            oninput="document.getElementById('color-picker-<?php echo $slider_row; ?>').value = this.value || '#000000';" />
                                                    </td>





                                                    <td class="text-right">
                                                        <input type="text" name="slider_images[<?php echo $slider_row; ?>][sort_order]" value="<?php echo $slider_image['sort_order']; ?>" placeholder="sort order" class="form-control" />
                                                    </td>
                                                    <td class="text-left">
                                                        <button type="button" onclick="$('#slider-row<?php echo $slider_row; ?>').remove();" class="btn btn-danger">
                                                            <i class="fa fa-minus-circle"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php $slider_row++; ?>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3"></td>
                                                <td class="text-left">
                                                    <button type="button" onclick="addImageSlider();" class="btn btn-primary">
                                                        <i class="fa fa-plus-circle"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <br/>
                            <br/>
                            <br/>

                            <div class="row">
                                <div class="table-responsive">
                                    <table id="images" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <td class="text-left">Features Images</td>
                                                <td class="text-center required">Title</td>
                                                <td class="text-center required">Description</td>
                                                <td class="text-right">Sort Order</td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $image_row = 0;
                                            foreach ($product_images as $product_image) {
                                            ?>
                                                <tr id="image-row<?php echo $image_row; ?>">
                                                    <td class="text-left">
                                                        <a href="" id="thumb-image<?php echo $image_row; ?>" data-type="feature" data-row="<?php echo $image_row; ?>" class="image-picker">
                                                            <img src="<?php echo $product_image['thumb']; ?>" alt="" title="" data-placeholder="" class="image-preview" style="width: 100px; height: 100px;" />
                                                        </a>
                                                        <input type="hidden" name="product_images[<?php echo $image_row; ?>][image]" value="<?php echo $product_image['image']; ?>" id="input-image<?php echo $image_row; ?>" />
                                                    </td>
                                                    <td class="text-left">
                                                        <?php foreach ($languages as $language) : ?>
                                                            <div class="input-group">
                                                                <span class="input-group-text">
                                                                    <img src="/vars/lang/be/<?php echo $language['code']; ?>-<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                                                                </span>
                                                                <input type="text" name="product_images[<?php echo $image_row; ?>][description][<?php echo $language['language_id']; ?>][title]" placeholder="Title" class="form-control" value="<?php echo isset($product_image['description'][$language['language_id']]['title']) ? $product_image['description'][$language['language_id']]['title'] : ''; ?>" />
                                                            </div>
                                                            <?php if (isset($error_product_images[$image_row]['title'][$language['language_id']])) : ?>
                                                                <div class="text-danger"><?php echo $error_product_images[$image_row]['title'][$language['language_id']]; ?></div>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </td>
                                                    <td class="text-left">
                                                        <?php foreach ($languages as $language) : ?>
                                                            <div class="col-md-12">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">
                                                                            <img src="/vars/lang/be/<?php echo $language['code']; ?>-<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                                                                        </span>
                                                                        <textarea id="input-product-images-description-<?php echo $language['language_id']; ?>-<?php echo $image_row; ?>" name="product_images[<?php echo $image_row; ?>][description][<?php echo $language['language_id']; ?>][content]" placeholder="Image Content" class="form-control"><?php echo isset($product_image['description'][$language['language_id']]['content']) ? $product_image['description'][$language['language_id']]['content'] : ''; ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <?php if (isset($error_product_images[$image_row]['content'][$language['language_id']])) : ?>
                                                                    <div class="text-danger"><?php echo $error_product_images[$image_row]['content'][$language['language_id']]; ?></div>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </td>
                                                    <td class="text-right">
                                                        <input type="text" name="product_images[<?php echo $image_row; ?>][sort_order]" value="<?php echo $product_image['sort_order']; ?>" placeholder="sort order" class="form-control" />
                                                    </td>
                                                    <td class="text-left">
                                                        <button type="button" onclick="$('#image-row<?php echo $image_row; ?>').remove();" data-toggle="tooltip" title="remove" class="btn btn-danger">
                                                            <i class="fa fa-minus-circle"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php $image_row = $image_row + 1; ?>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4"></td>
                                                <td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="add" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <br/>
                            <br/>
                            <br/>
                            <div class="row">
                                <div class="table-responsive">
                                    <table id="icons" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <td class="text-left">Benefits Icon</td>
                                                <td class="text-center required">Title</td>
                                                <td class="text-center required">Description</td>
                                                <td class="text-right">Sort Order</td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $image_row_icons = 0;
                                            foreach ($product_icons as $product_icon) {
                                            ?>
                                                <tr id="image-row-icons<?php echo $image_row_icons; ?>">
                                                    <td class="text-left">
                                                        <a href="" id="thumb-icon<?php echo $image_row_icons; ?>" data-type="icon" data-row="<?php echo $image_row_icons; ?>" class="image-picker">
                                                            <img src="<?php echo $product_icon['thumb']; ?>" alt="" title="" data-placeholder="" class="image-preview" style="width: 100px; height: 100px;" />
                                                        </a>
                                                        <input type="hidden" name="product_icons[<?php echo $image_row_icons; ?>][image]" value="<?php echo $product_icon['image']; ?>" id="input-icon<?php echo $image_row_icons; ?>" />
                                                    </td>
                                                    <td class="text-left">
                                                        <?php foreach ($languages as $language) : ?>
                                                            <div class="input-group">
                                                                <span class="input-group-text">
                                                                    <img src="/vars/lang/be/<?php echo $language['code']; ?>-<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                                                                </span>
                                                                <input type="text" name="product_icons[<?php echo $image_row_icons; ?>][description][<?php echo $language['language_id']; ?>][title]" placeholder="Title" class="form-control" value="<?php echo isset($product_icon['description'][$language['language_id']]['title']) ? $product_icon['description'][$language['language_id']]['title'] : ''; ?>" />
                                                            </div>
                                                            <?php if (isset($error_product_icons[$image_row_icons]['title'][$language['language_id']])) : ?>
                                                                <div class="text-danger"><?php echo $error_product_icons[$image_row_icons]['title'][$language['language_id']]; ?></div>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </td>
                                                    <td class="text-left">
                                                        <?php foreach ($languages as $language) : ?>
                                                            <div class="col-md-12">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">
                                                                            <img src="/vars/lang/be/<?php echo $language['code']; ?>-<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                                                                        </span>
                                                                        <textarea id="input-product-icons-description-<?php echo $language['language_id']; ?>-<?php echo $image_row_icons; ?>" name="product_icons[<?php echo $image_row_icons; ?>][description][<?php echo $language['language_id']; ?>][content]" placeholder="Description" class="form-control"><?php echo isset($product_icon['description'][$language['language_id']]['content']) ? $product_icon['description'][$language['language_id']]['content'] : ''; ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <?php if (isset($error_product_icons[$image_row_icons]['content'][$language['language_id']])) : ?>
                                                                    <div class="text-danger"><?php echo $error_product_icons[$image_row_icons]['content'][$language['language_id']]; ?></div>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </td>
                                                    <td class="text-right">
                                                        <input type="text" name="product_icons[<?php echo $image_row_icons; ?>][sort_order]" value="<?php echo $product_icon['sort_order']; ?>" placeholder="sort order" class="form-control" />
                                                    </td>
                                                    <td class="text-left">
                                                        <button type="button" onclick="$('#image-row-icons<?php echo $image_row_icons; ?>').remove();" data-toggle="tooltip" title="remove" class="btn btn-danger">
                                                            <i class="fa fa-minus-circle"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php $image_row_icons = $image_row_icons + 1; ?>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4"></td>
                                                <td class="text-left"><button type="button" onclick="addImageIcons();" data-toggle="tooltip" title="add" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <br/>
                            <br/>
                            <br/>
                            <!-- Add this in the tab-data section after existing fields -->
            <div class="row">
               <div class="col-lg-12 col-md-12">
                 <div class="table-responsive">
                   <table id="attributes" class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                            <td class="text-left">Attribute</td>
                            <td class="text-left">Attribute Value</td>
                            <td class="text-right">Sort Order</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $attribute_row = 0; ?>
                    <?php foreach ($product_attributes as $product_attribute) { ?>
                        <tr id="attribute-row<?php echo $attribute_row; ?>">
                            <td class="text-left">
                                <select name="product_attribute[<?php echo $attribute_row; ?>][attribute_id]" class="form-control attribute-select">
                                    <option value="">Select Attribute</option>
                                    <?php foreach ($attributes as $attribute) { ?>
                                        <option value="<?php echo $attribute['id']; ?>" 
                                            <?php echo ($attribute['id'] == $product_attribute['attribute_id']) ? 'selected="selected"' : ''; ?>>
                                            <?php echo $attribute['title']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <?php if (isset($error_product_attribute[$attribute_row]['attribute_id'])) { ?>
                                    <div class="text-danger"><?php echo $error_product_attribute[$attribute_row]['attribute_id']; ?></div>
                                <?php } ?>
                            </td>
                            <td class="text-left">
                                <select name="product_attribute[<?php echo $attribute_row; ?>][attribute_value_id]" 
                                        class="form-control attribute-value-select" 
                                        id="attribute-value-<?php echo $attribute_row; ?>"
                                        data-selected-value="<?php echo $product_attribute['attribute_value_id']; ?>">
                                    <option value="">Select Value</option>
                                    <!-- Values will be loaded via AJAX -->
                                </select>
                                <?php if (isset($error_product_attribute[$attribute_row]['attribute_value_id'])) { ?>
                                    <div class="text-danger"><?php echo $error_product_attribute[$attribute_row]['attribute_value_id']; ?></div>
                                <?php } ?>
                            </td>
                            <td class="text-right">
                                <input type="text" name="product_attribute[<?php echo $attribute_row; ?>][sort_order]" value="<?php echo $product_attribute['sort_order']; ?>" placeholder="Sort Order" class="form-control" />
                            </td>
                            <td class="text-left">
                                <button type="button" class="btn btn-danger remove-attribute-btn">
                                    <i class="fa fa-minus-circle"></i>
                                </button>
                            </td>
                        </tr>
                        <?php $attribute_row++; ?>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"></td>
                        <td class="text-left">
                            <!-- CHANGED: Removed onclick and added ID -->
                            <button type="button" id="add-attribute-main-btn" data-toggle="tooltip" title="Add Attribute" class="btn btn-primary">
                                <i class="fa fa-plus-circle"></i>
                            </button>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>


                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-sort_order">
                                        Sort Order
                                    </label>
                                    <input type="number" name="sort_order" value="<?php echo $sort_order; ?>" class="form-control" />
                                </div>
                            </div>
                             <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-featured">
                                        Featured
                                    </label>
                                    <select name="featured" id="input-featured" class="form-control">
                                        <?php if ($featured) { ?>
                                            <option value="1" selected="selected">Featured</option>
                                            <option value="0">Unfeatured</option>
                                        <?php } else { ?>
                                            <option value="1">Featured</option>
                                            <option value="0" selected="selected">Unfeatured</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-status">
                                        Status
                                    </label>
                                    <select name="publish" id="input-status" class="form-control">
                                        <?php if ($status) { ?>
                                            <option value="1" selected="selected">Active</option>
                                            <option value="0">Inactive</option>
                                        <?php } else { ?>
                                            <option value="1">Active</option>
                                            <option value="0" selected="selected">Inactive</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 bottom-inline-btns">
                        <?php if (!$viewer) { ?>
                            <button type="submit" form="form-customer" data-toggle="tooltip" title="Save" class="btn btn-success"> <i class="fa fa-save"></i> Submit</button>
                           <?php } ?>
                            <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="Cancel" class="btn btn-danger"><i class="fa fa-reply"></i> Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script> -->
<?php echo $footer; ?>
<script type="text/javascript">
    var image_row = <?php echo  $image_row; ?>;
    var image_row_icons = <?php echo  $image_row_icons; ?>;
    var slider_row = <?php echo $slider_row; ?>;
    function addImage() {
        var html = '<tr id="image-row' + image_row + '">';
        html += '  <td class="text-left">';
        html += '    <a href="#" id="thumb-image' + image_row + '" data-type="feature" data-row="' + image_row + '" class="image-picker">';
        html += '      <img src="../uploads/image/no_image.png" alt="" title="" data-placeholder="" class="image-preview" style="width: 100px; height: 100px;"/>';
        html += '    </a>';
        html += '    <input type="hidden" name="product_images[' + image_row + '][image]" value="" id="input-image' + image_row + '" />';
        html += '  </td>';
        html += '  <td class="text-left">';
        <?php foreach ($languages as $language) { ?>
            html += '    <div class="input-group">';
            html += '      <span class="input-group-text">';
            html += '<img src="/vars/lang/be/<?php echo $language['code']; ?>-<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/>';
            html += '      </span>';
            html += '      <input name="product_images[' + image_row + '][description][<?php echo $language['language_id']; ?>][title]" value="" placeholder="Title" class="form-control"/>';
            html += '    </div>';
        <?php } ?>
        html += '  </td>';
        html += '  <td class="text-left">';
            <?php foreach ($languages as $language) { ?>
            var textareaId = 'input-product-images-description-<?php echo $language['language_id']; ?>-' + image_row;
            html += '<div class="col-md-12">';
            html += '<div class="input-group mb-3">';
            html += '    <div class="input-group">';
            html += '      <span class="input-group-text">';
            html += '        <img src="/vars/lang/be/<?php echo $language['code']; ?>-<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/>';
            html += '      </span>';
            html += '<textarea id="' + textareaId + '" name="product_images[' + image_row + '][description][<?php echo $language['language_id']; ?>][content]" placeholder="Description" class="form-control"></textarea>';
            html += '    </div>';
            html += '  </div>';
            html += '</div>';
        <?php } ?>
        html += '  </td>';
        html += '  <td class="text-right">';
        html += '    <input type="text" name="product_images[' + image_row + '][sort_order]" value="" placeholder="sort order" class="form-control" />';
        html += '  </td>';
        html += '  <td class="text-left">';
        html += '    <button type="button" onclick="$(\'#image-row' + image_row + '\').remove();" data-toggle="tooltip" title="remove" class="btn btn-danger">';
        html += '      <i class="fa fa-minus-circle"></i>';
        html += '    </button>';
        html += '  </td>';
        html += '</tr>';
        $('#images tbody').append(html);
        image_row++;
    }
function addImageSlider() {
    var html = '<tr id="slider-row' + slider_row + '">';
    html += '  <td class="text-left">';
    html += '    <a href="#" id="thumb-slider' + slider_row + '" data-type="slider" data-row="' + slider_row + '" class="image-picker">';
    html += '      <img src="../uploads/image/no_image.png" alt="" title="" data-placeholder="" class="image-preview" style="width: 100px; height: 100px;"/>';
    html += '    </a>';
    html += '    <input type="hidden" name="slider_images[' + slider_row + '][image]" value="" id="input-slider' + slider_row + '" />';
    html += '  </td>';

    // ✅ Color Picker (shows blank until color chosen)
    html += '  <td class="text-left">';
    html += '    <input type="color" id="color-' + slider_row + '" class="form-control color-picker" />';
    html += '    <input type="hidden" name="slider_images[' + slider_row + '][color]" id="color-value-' + slider_row + '" value="" />';
    html += '  </td>';

    html += '  <td class="text-right">';
    html += '    <input type="text" name="slider_images[' + slider_row + '][sort_order]" value="" placeholder="sort order" class="form-control" />';
    html += '  </td>';

    html += '  <td class="text-left">';
    html += '    <button type="button" onclick="$(\'#slider-row' + slider_row + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger">';
    html += '      <i class="fa fa-minus-circle"></i>';
    html += '    </button>';
    html += '  </td>';
    html += '</tr>';

    $('#slider_images tbody').append(html);

    // ⚙️ Make color appear blank initially
    const colorInput = document.getElementById('color-' + slider_row);
    const hiddenInput = document.getElementById('color-value-' + slider_row);

    // visually hide color (neutral background)
    colorInput.style.background = '#f8f9fa';
    colorInput.value = '#ffffff'; // required for browser, but we'll override appearance
    colorInput.dataset.empty = 'true';

    // change behavior
    colorInput.addEventListener('input', function () {
        hiddenInput.value = this.value;
        this.style.background = this.value;
        this.dataset.empty = 'false';
    });

    colorInput.addEventListener('click', function () {
        // if blank, show color picker starting at white
        if (this.dataset.empty === 'true') this.value = '#ffffff';
    });

    slider_row++;
}



    function addImageIcons() {
        var html = '<tr id="image-row-icons' + image_row_icons + '">';
        html += '  <td class="text-left">';
        html += '    <a href="#" id="thumb-icon' + image_row_icons + '" data-type="icon" data-row="' + image_row_icons + '" class="image-picker">';
        html += '      <img src="../uploads/image/no_image.png" alt="" title="" data-placeholder="" class="image-preview" style="width: 100px; height: 100px;"/>';
        html += '    </a>';
        html += '    <input type="hidden" name="product_icons[' + image_row_icons + '][image]" value="" id="input-icon' + image_row_icons + '" />';
        html += '  </td>';
        html += '  <td class="text-left">';
        <?php foreach ($languages as $language) { ?>
            html += '    <div class="input-group">';
            html += '      <span class="input-group-text">';
            html += '<img src="/vars/lang/be/<?php echo $language['code']; ?>-<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/>';
            html += '      </span>';
            html += '      <input name="product_icons[' + image_row_icons + '][description][<?php echo $language['language_id']; ?>][title]" value="" placeholder="title" class="form-control"/>';
            html += '    </div>';
        <?php } ?>
        html += '  </td>';
        html += '  <td class="text-left">';
        <?php foreach ($languages as $language) { ?>
            var textareaId = 'input-product-icons-description-<?php echo $language['language_id']; ?>-' + image_row_icons;
            html += '<div class="col-md-12">';
            html += '<div class="input-group mb-3">';
            html += '    <div class="input-group">';
            html += '      <span class="input-group-text">';
            html += '        <img src="/vars/lang/be/<?php echo $language['code']; ?>-<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/>';
            html += '      </span>';
            html += '<textarea id="' + textareaId + '" name="product_icons[' + image_row_icons + '][description][<?php echo $language['language_id']; ?>][content]" placeholder="Image Content" class="form-control"></textarea>';
            html += '    </div>';
            html += '  </div>';
            html += '</div>';
        <?php } ?>
        html += '  </td>';
        html += '  <td class="text-right">';
        html += '    <input type="text" name="product_icons[' + image_row_icons + '][sort_order]" value="" placeholder="sort order" class="form-control" />';
        html += '  </td>';
        html += '  <td class="text-left">';
        html += '    <button type="button" onclick="$(\'#image-row-icons' + image_row_icons + '\').remove();" data-toggle="tooltip" title="remove" class="btn btn-danger">';
        html += '      <i class="fa fa-minus-circle"></i>';
        html += '    </button>';
        html += '  </td>';
        html += '</tr>';
        $('#icons tbody').append(html);
        image_row_icons++;
    }

    // Unified image picker handler
    $(document).ready(function() {
        $('body').on('click', '.image-picker', function(e) {
            e.preventDefault();
            var element = $(this);
            var type = element.data('type');
            var row = element.data('row');
            var fileInput = $('<input type="file" style="display: none;" accept="image/*">');
            $('body').append(fileInput);
            fileInput.click();
            fileInput.on('change', function() {
                var file = this.files[0];
                if (file) {
                    if (!file.type.match('image.*')) {
                        alert('Please select an image file.');
                        return;
                    }
                    if (file.size > 2097152) {
                        alert('The file is too large. Please select a file smaller than 2 MB.');
                        return;
                    }
                    
                    var fd = new FormData();
                    fd.append('image', file);
                    
                    $.ajax({
                        url: '/admin/?controller=product/uploadImages&token=<?php echo $token; ?>',
                        type: 'post',
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response['filename']) {
                                // Update the preview image
                                element.find('.image-preview').attr('src', '../uploads/image/product/' + response['filename']);
                                
                                // Update the corresponding hidden input field
                                if (type === 'slider') {
                                    $('#input-slider' + row).val(response['filename']);
                                } else if (type === 'feature') {
                                    $('#input-image' + row).val(response['filename']);
                                } else if (type === 'icon') {
                                    $('#input-icon' + row).val(response['filename']);
                                }
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('Error uploading image: ' + error);
                        }
                    });
                }
            });
        });
    });
    $('#language a:first').tab('show');
</script>

<script src="/themes/admin/javascript/common.js" type="text/javascript"></script>
<script type="text/javascript">
    <?php foreach ($languages as $lang) { ?>
        var lang = 'input-description<?php echo $lang['language_id'] ?>';
        var code = '<?php echo $lang["code"] ?>';
        var textarea = document.getElementById(lang);
        CKEDITOR.replace(textarea, {
            language: code,
            basicEntities: false
        });
    <?php } ?>

        <?php foreach ($languages as $lang) { ?>
        var lang = 'input-short-description<?php echo $lang['language_id'] ?>';
        var code = '<?php echo $lang["code"] ?>';
        var textarea = document.getElementById(lang);
        CKEDITOR.replace(textarea, {
            language: code,
            basicEntities: false
        });
    <?php } ?>

   $(".js-select6").select2({
    closeOnSelect: false,
    allowHtml: false,
    allowClear: false,
    placeholder: "Enter product tags",
    tags: true,
    tokenSeparators: [','], // only comma will separate tags
    createTag: function (params) {
        var term = $.trim(params.term);
        if (term === '') {
            return null;
        }
        return {
            id: term,
            text: term,
            newTag: true
        };
    }
});
</script>

<script type="text/javascript">
// Product Attributes Management - Fixed Version
var attribute_row = <?php echo $attribute_row; ?>;

// Initialize on document ready
$(document).ready(function() {
    console.log('Product Attributes initialized, starting row:', attribute_row);
    
    // Load attribute values for existing rows and set selected values
    $('.attribute-select').each(function() {
        var row_id = $(this).closest('tr').attr('id').replace('attribute-row', '');
        var attribute_id = $(this).val();
        var selected_value_id = $(this).closest('tr').find('.attribute-value-select').data('selected-value');
        
        console.log('Row:', row_id, 'Attribute ID:', attribute_id, 'Selected Value ID:', selected_value_id);
        
        if (attribute_id) {
            loadAttributeValues(attribute_id, row_id, selected_value_id);
        }
    });
    
    // Handle attribute selection change
    $(document).on('change', '.attribute-select', function() {
        var row_id = $(this).closest('tr').attr('id').replace('attribute-row', '');
        var attribute_id = $(this).val();
        loadAttributeValues(attribute_id, row_id);
    });
    
    // Handle add attribute button click
    $('#add-attribute-main-btn').on('click', function() {
        addAttributeRow();
    });
    
    // Handle remove attribute row
    $(document).on('click', '.remove-attribute-btn', function() {
        $(this).closest('tr').remove();
    });
});

// Function to add new attribute row
function addAttributeRow() {
    console.log('Adding new attribute row:', attribute_row);
    
    var html = '<tr id="attribute-row' + attribute_row + '">';
    html += '  <td class="text-left">';
    html += '    <select name="product_attribute[' + attribute_row + '][attribute_id]" class="form-control attribute-select">';
    html += '      <option value="">Select Attribute</option>';
    <?php foreach ($attributes as $attribute) { ?>
        html += '      <option value="<?php echo $attribute['id']; ?>"><?php echo addslashes($attribute['title']); ?></option>';
    <?php } ?>
    html += '    </select>';
    html += '  </td>';
    html += '  <td class="text-left">';
    html += '    <select name="product_attribute[' + attribute_row + '][attribute_value_id]" class="form-control attribute-value-select" id="attribute-value-' + attribute_row + '">';
    html += '      <option value="">Select Value</option>';
    html += '    </select>';
    html += '  </td>';
    html += '  <td class="text-right">';
    html += '    <input type="text" name="product_attribute[' + attribute_row + '][sort_order]" value="0" placeholder="Sort Order" class="form-control" />';
    html += '  </td>';
    html += '  <td class="text-left">';
    html += '    <button type="button" class="btn btn-danger remove-attribute-btn">';
    html += '      <i class="fa fa-minus-circle"></i>';
    html += '    </button>';
    html += '  </td>';
    html += '</tr>';
    
    $('#attributes tbody').append(html);
    console.log('Attribute row added successfully');
    attribute_row++;
}

// Function to load attribute values via AJAX
function loadAttributeValues(attribute_id, row_id, selected_value_id = null) {
    console.log('Loading values for attribute:', attribute_id, 'row:', row_id, 'selected value:', selected_value_id);
    
    var valueSelect = $('#attribute-value-' + row_id);
    
    if (!attribute_id) {
        valueSelect.html('<option value="">Select Value</option>');
        return;
    }
    
    // Show loading
    valueSelect.html('<option value="">Loading...</option>');
    
    $.ajax({
        url: '/admin/?controller=product/getAttributeValues&token=<?php echo $token; ?>',
        type: 'GET',
        data: { 
            attribute_id: attribute_id 
        },
        dataType: 'json',
        success: function(response) {
            console.log('AJAX success:', response);
            
            var options = '<option value="">Select Value</option>';
            
            if (response.attribute_values && response.attribute_values.length > 0) {
                $.each(response.attribute_values, function(index, value) {
                    var selected = (selected_value_id && value.id == selected_value_id) ? 'selected="selected"' : '';
                    options += '<option value="' + value.id + '" ' + selected + '>' + value.title + ' (' + value.attribute_key + ')</option>';
                });
            } else {
                options += '<option value="">No values found</option>';
            }
            
            valueSelect.html(options);
            
            // If we have a selected value, set it after loading options
            if (selected_value_id) {
                setTimeout(function() {
                    $('#attribute-value-' + row_id).val(selected_value_id);
                    console.log('Set selected value for row ' + row_id + ': ' + selected_value_id);
                }, 100);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
            valueSelect.html('<option value="">Error loading values</option>');
        }
    });
}

// Make function globally available as fallback
window.addAttribute = addAttributeRow;
</script>



<script>
/* 🔹 Common Preview Delete Function (JS-only, no AJAX) New  Added*/
function previewDelete(imgId, inputId, hiddenId, btn) {
    document.getElementById(imgId).src = '../uploads/image/product/no_image.png';
    document.getElementById(inputId).value = '';
    document.getElementById(hiddenId).value = '';
    btn.style.display = 'none';
}

/* 🔹 Load Preview for Main Image */
function load2File(event) {
    var output = document.getElementById('cimage');
    var btn = output.parentElement.querySelector('.delete-image-btn');
    var file = event.target.files[0];
    var validExtensions = ['png', 'jpeg', 'jpg'];
    var maxSize = 2 * 1024 * 1024;

    if (file) {
        var extension = file.name.split('.').pop().toLowerCase();
        if (validExtensions.indexOf(extension) === -1 || file.size > maxSize) {
            event.target.value = '';
            alert('Please select a valid file (PNG, JPEG, JPG) less than 2 MB.');
            return false;
        } else {
            output.src = URL.createObjectURL(file);
            btn.style.display = 'block';
            btn.onclick = function() {
                previewDelete('cimage', 'image', 'hidden_image', btn);
            };
            output.onload = function() {
                URL.revokeObjectURL(output.src);
            };
        }
    }
}

/* 🔹 Load Preview for Main Image */
function load5File(event) {
    var output = document.getElementById('cfeaturedimage');
    var btn = output.parentElement.querySelector('.delete-image-btn');
    var file = event.target.files[0];
    var validExtensions = ['png', 'jpeg', 'jpg'];
    var maxSize = 2 * 1024 * 1024;

    if (file) {
        var extension = file.name.split('.').pop().toLowerCase();
        if (validExtensions.indexOf(extension) === -1 || file.size > maxSize) {
            event.target.value = '';
            alert('Please select a valid file (PNG, JPEG, JPG) less than 2 MB.');
            return false;
        } else {
            output.src = URL.createObjectURL(file);
            btn.style.display = 'block';
            btn.onclick = function() {
                previewDelete('cfeaturedimage', 'featured_image', 'hidden_featured_image', btn);
            };
            output.onload = function() {
                URL.revokeObjectURL(output.src);
            };
        }
    }
}

/* 🔹 Load Preview for Thumbnail */
function load3File(event) {
    var output = document.getElementById('cthumbnail');
    var btn = output.parentElement.querySelector('.delete-image-btn');
    var file = event.target.files[0];
    var validExtensions = ['png', 'jpeg', 'jpg'];
    var maxSize = 2 * 1024 * 1024;

    if (file) {
        var extension = file.name.split('.').pop().toLowerCase();
        if (validExtensions.indexOf(extension) === -1 || file.size > maxSize) {
            event.target.value = '';
            alert('Please select a valid file (PNG, JPEG, JPG) less than 2 MB.');
            return false;
        } else {
            output.src = URL.createObjectURL(file);
            btn.style.display = 'block';
            btn.onclick = function() {
                previewDelete('cthumbnail', 'thumbnail', 'hidden_thumbnail', btn);
            };
            output.onload = function() {
                URL.revokeObjectURL(output.src);
            };
        }
    }
}

/* 🔹 Load Preview for Benefits Image */
function load4File(event) {
    var output = document.getElementById('cbenefits_image');
    var btn = output.parentElement.querySelector('.delete-image-btn');
    var file = event.target.files[0];
    var validExtensions = ['png', 'jpeg', 'jpg'];
    var maxSize = 2 * 1024 * 1024;

    if (file) {
        var extension = file.name.split('.').pop().toLowerCase();
        if (validExtensions.indexOf(extension) === -1 || file.size > maxSize) {
            event.target.value = '';
            alert('Please select a valid file (PNG, JPEG, JPG) less than 2 MB.');
            return false;
        } else {
            output.src = URL.createObjectURL(file);
            btn.style.display = 'block';
            btn.onclick = function() {
                previewDelete('cbenefits_image', 'benefits_image', 'hidden_benefits_image', btn);
            };
            output.onload = function() {
                URL.revokeObjectURL(output.src);
            };
        }
    }
}

/* 🔹 Existing delete function (keep as is) */
function deleteProductImage(type, product_id) {
    if (confirm('Are you sure you want to delete this image?')) {
        fetch('<?php echo $deleteImage; ?>&type=' + type + '&product_id=' + product_id)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let imgId = '', hiddenId = '';
                if (type === 'main') { imgId = 'cimage'; hiddenId = 'hidden_image'; }
                else if (type === 'thumbnail') { imgId = 'cthumbnail'; hiddenId = 'hidden_thumbnail'; }
                else if (type === 'benefits') { imgId = 'cbenefits_image'; hiddenId = 'hidden_benefits_image'; }
                else if (type === 'featured_image') { imgId = 'cfeaturedimage'; hiddenId = 'hidden_featured_image'; }

                document.getElementById(imgId).src = '../uploads/image/product/no_image.png';
                document.getElementById(hiddenId).value = '';
                const btn = document.querySelector(`#${imgId}`).parentElement.querySelector('.delete-image-btn');
                if (btn) btn.style.display = 'none';
                // alert('Image deleted successfully.');
            } else {
                alert(data.error || 'Error deleting image.');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Something went wrong while deleting the image.');
        });
    }
}

/* 🔹 Handle dynamic delete (decides whether to use preview or backend delete) */
function handleDeleteImage(type, product_id) {
    let imgEl, inputEl, hiddenEl;
    if (type === 'main') {
        imgEl = document.getElementById('cimage');
        inputEl = document.getElementById('image');
        hiddenEl = document.getElementById('hidden_image');
    } else if (type === 'thumbnail') {
        imgEl = document.getElementById('cthumbnail');
        inputEl = document.getElementById('thumbnail');
        hiddenEl = document.getElementById('hidden_thumbnail');
    } else if (type === 'benefits') {
        imgEl = document.getElementById('cbenefits_image');
        inputEl = document.getElementById('benefits_image');
        hiddenEl = document.getElementById('hidden_benefits_image');
    } else if (type === 'featured_image') {
        imgEl = document.getElementById('cfeaturedimage');
        inputEl = document.getElementById('featured_image');
        hiddenEl = document.getElementById('hidden_featured_image');   
    }

    // If a new file is selected (preview mode)
    if (inputEl.files.length > 0) {
        previewDelete(imgEl.id, inputEl.id, hiddenEl.id, imgEl.parentElement.querySelector('.delete-image-btn'));
    } else {
        deleteProductImage(type, product_id); // Use backend delete
    }
}
</script>

<script>
$(document).ready(function() {
    $('#input-category-id').select2({
        placeholder: "Choose a category",
        allowClear: true,
        width: '100%' // ensures full width in Bootstrap form
    });
});
</script>
<!-- Custom CSS -->
<style>
.select2-container--default .select2-selection--single {
    height: 38px;
    border: 1px solid #ced4da;
    border-radius: 4px;
    padding: 4px 8px;
    display: flex;
    align-items: center;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #495057;
    line-height: 28px;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 36px;
    right: 10px;
}
.select2-container--default .select2-selection--single:focus,
.select2-container--default.select2-container--focus .select2-selection--single {
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}
.select2-container {
    width: 100% !important;
    font-size: 14px;
}
/* Hide cross icon just in case */
.select2-selection__clear {
    display: none !important;
}
</style>