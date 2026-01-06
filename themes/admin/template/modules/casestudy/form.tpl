<?php echo $header; ?>
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
</style>



<div class="main-panel">
    <div class="sec-head">
        <div class="sec-head-title">
            <h3><?php echo $text_form; ?></h3>
        </div>
        <div class="sec-head-btns">
            <button type="submit" form="form-customer" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
                                    <li><a href="#language<?php echo $lang['language_id'] ?>" data-toggle="tab"><img src="/vars/lang/be/<?php echo $lang['code']; ?>-<?php echo $lang['image']; ?>" /> <?php echo $lang['name'] ?></a></li>
                                <?php } ?>
                            </ul>
                            <div class="tab-content">
                                <?php foreach ($languages as $lang) { ?>
                                    <div class="tab-pane" id="language<?php echo $lang['language_id'] ?>">

                                 <!-- Title -->
        <div class="col-lg-6 col-md-6">
            <div class="form-group required">
                <label class="control-label" for="input-title<?php echo $lang['language_id'] ?>">
                    Title
                </label>
                <input type="text" name="case_study_description[<?php echo $lang['language_id'] ?>][title]" 
                       value="<?php echo isset($case_study_description[$lang['language_id']]['title']) ? $case_study_description[$lang['language_id']]['title'] : ''; ?>" 
                       placeholder="Title" id="input-title<?php echo $lang['language_id'] ?>" class="form-control" />
                <?php if (isset($error_title[$lang['language_id']])) { ?>
                    <div class="text-danger"><?php echo $error_title[$lang['language_id']]; ?></div>
                <?php } ?>
            </div>
        </div>

                <div class="col-lg-6 col-md-6">
                        <div class="form-group required">
                            <label class="control-label" for="input-tag<?php echo $lang['language_id'] ?>">
                                Tag
                            </label>
                            <input type="text" name="case_study_description[<?php echo $lang['language_id'] ?>][tag]" value="<?php echo isset($case_study_description[$lang['language_id']]) ? $case_study_description[$lang['language_id']]['tag'] : ''; ?>" placeholder="Tag" id="input-tag<?php echo $lang['language_id'] ?>" class="form-control" />
                            <?php if (isset($error_tag[$lang['language_id']])) { ?>
                                <div class="text-danger">
                                    <?php echo $error_tag[$lang['language_id']]; ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group required">
                            <label class="control-label" for="input-short_description<?php echo $lang['language_id'] ?>">
                                Short Description
                            </label>
                            <textarea name="case_study_description[<?php echo $lang['language_id'] ?>][short_description]" rows="5" placeholder="Short Description" id="input-short_description<?php echo $lang['language_id'] ?>" class="form-control"><?php echo isset($case_study_description[$lang['language_id']]) ? $case_study_description[$lang['language_id']]['short_description'] : ''; ?></textarea>
                                <?php if (isset($error_short_description[$lang['language_id']])) { ?>
                                <div class="text-danger">
                                    <?php echo $error_short_description[$lang['language_id']]; ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                        <!-- Second Title -->
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="input-second_title<?php echo $lang['language_id'] ?>">
                                    Second Title
                                </label>
                                <input type="text" name="case_study_description[<?php echo $lang['language_id'] ?>][second_title]" 
                                    value="<?php echo isset($case_study_description[$lang['language_id']]['second_title']) ? $case_study_description[$lang['language_id']]['second_title'] : ''; ?>" 
                                    placeholder="Second Title" id="input-second_title<?php echo $lang['language_id'] ?>" class="form-control" />
                            </div>
                        </div>

                        <!-- Second Description -->
                       <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="input-second_description<?php echo $lang['language_id'] ?>">
                                    Second Description
                                </label>
                                <textarea name="case_study_description[<?php echo $lang['language_id'] ?>][second_description]" 
                                        rows="5" placeholder="Second Description" 
                                        id="input-second_description<?php echo $lang['language_id'] ?>" 
                                        class="form-control"><?php echo isset($case_study_description[$lang['language_id']]['second_description']) ? $case_study_description[$lang['language_id']]['second_description'] : ''; ?></textarea>
                            </div>
                        </div>

                        <!-- Middle Title -->
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="input-middle_title<?php echo $lang['language_id'] ?>">
                                    Middle Title
                                </label>
                                <input type="text" name="case_study_description[<?php echo $lang['language_id'] ?>][middle_title]" 
                                    value="<?php echo isset($case_study_description[$lang['language_id']]['middle_title']) ? $case_study_description[$lang['language_id']]['middle_title'] : ''; ?>" 
                                    placeholder="Middle Title" id="input-middle_title<?php echo $lang['language_id'] ?>" class="form-control" />
                            </div>
                        </div>

                        <!-- First Middle Description -->
                       <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="input-first_middle_description<?php echo $lang['language_id'] ?>">
                                    First Middle Description
                                </label>
                                <textarea name="case_study_description[<?php echo $lang['language_id'] ?>][first_middle_description]" 
                                        rows="5" placeholder="First Middle Description" 
                                        id="input-first_middle_description<?php echo $lang['language_id'] ?>" 
                                        class="form-control"><?php echo isset($case_study_description[$lang['language_id']]['first_middle_description']) ? $case_study_description[$lang['language_id']]['first_middle_description'] : ''; ?></textarea>
                            </div>
                        </div>

                        <!-- Second Middle Description -->
                  <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="input-second_middle_description<?php echo $lang['language_id'] ?>">
                                    Second Middle Description
                                </label>
                                <textarea name="case_study_description[<?php echo $lang['language_id'] ?>][second_middle_description]" 
                                        rows="5" placeholder="Second Middle Description" 
                                        id="input-second_middle_description<?php echo $lang['language_id'] ?>" 
                                        class="form-control"><?php echo isset($case_study_description[$lang['language_id']]['second_middle_description']) ? $case_study_description[$lang['language_id']]['second_middle_description'] : ''; ?></textarea>
                            </div>
                        </div>

                            <!-- Third Middle Description -->
                           <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-third_middle_description<?php echo $lang['language_id'] ?>">
                                        Third Middle Description
                                    </label>
                                    <textarea name="case_study_description[<?php echo $lang['language_id'] ?>][third_middle_description]" 
                                            rows="5" placeholder="Third Middle Description" 
                                            id="input-third_middle_description<?php echo $lang['language_id'] ?>" 
                                            class="form-control"><?php echo isset($case_study_description[$lang['language_id']]['third_middle_description']) ? $case_study_description[$lang['language_id']]['third_middle_description'] : ''; ?></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-meta_title<?php echo $lang['language_id'] ?>">
                                        Meta Title
                                    </label>
                                    <input type="text" name="case_study_description[<?php echo $lang['language_id'] ?>][meta_title]" value="<?php echo isset($case_study_description[$lang['language_id']]) ? $case_study_description[$lang['language_id']]['meta_title'] : ''; ?>" placeholder="Meta Title" id="input-meta_title<?php echo $lang['language_id'] ?>" class="form-control" />

                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-meta_keyword<?php echo $lang['language_id'] ?>">
                                        Meta Keyword
                                    </label>
                                    <input type="text" name="case_study_description[<?php echo $lang['language_id'] ?>][meta_keyword]" value="<?php echo isset($case_study_description[$lang['language_id']]) ? $case_study_description[$lang['language_id']]['meta_keyword'] : ''; ?>" placeholder="Meta Keyword" id="input-meta_keyword<?php echo $lang['language_id'] ?>" class="form-control" />

                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-meta_description<?php echo $lang['language_id'] ?>">
                                        Meta Description
                                    </label>
                                    <textarea name="case_study_description[<?php echo $lang['language_id'] ?>][meta_description]" placeholder="Meta Description" rows="5" id="input-meta_description<?php echo $lang['language_id'] ?>" class="form-control"><?php echo isset($case_study_description[$lang['language_id']]) ? $case_study_description[$lang['language_id']]['meta_description'] : ''; ?></textarea>

                                </div>
                            </div>
                        </div>
                    <?php } ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-data">
                            <!-- <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-category"><span data-toggle="tooltip" title="categories">Categories</span></label>

                                    <input type="text" name="category" value="" placeholder="" id="input-category multi-select" class="form-control" />
                                    <div id="case-study-category" class="well well-sm multi-select-well" style="height: 150px; overflow: auto;">
                                        <?php foreach ($categories as $categ) { ?>
                                            <div id="case-study-category<?php echo $categ['category_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $categ['title']; ?>
                                                <input type="hidden" name="categories[]" value="<?php echo $categ['category_id']; ?>" />
                                            </div>

                                        <?php } ?>
                                    </div>

                                </div>
                            </div> -->
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-seo_url">
                                        Seo Url
                                    </label>
                                    <input type="text" name="seo_url" value="<?php echo $seo_url; ?>" class="form-control" />
                                </div>
                                <?php if (isset($error_seo_url)) { ?>
                                    <div class="text-danger">
                                        <?php echo $error_seo_url; ?>
                                    </div>
                                <?php } ?>
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
                                    <label class="control-label" for="input-status">
                                        Status
                                    </label>
                                    <select name="status" id="input-status" class="form-control">
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
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-featured">
                                        Featured
                                    </label>
                                    <select name="featured" id="input-featured" class="form-control">
                                        <?php if ($featured) { ?>
                                            <option value="1" selected="selected">Yes</option>
                                            <option value="0">No</option>
                                        <?php } else { ?>
                                            <option value="1">Yes</option>
                                            <option value="0" selected="selected">No</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <label class="control-label" for="input-thumbnail">Thumbnail</label>
                                        <input onchange="loadFile(event,'bimage')" type="file" name="thumbnail" id="thumbnail" accept=".png,.jpg,.jpeg" style="display: block;">
                                    </div>
                                    <?php if ($error_thumbnail) { ?>
                                        <div class="text-danger">
                                            <?php echo $error_thumbnail; ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-2 col-md-2 ">
                                    <?php if ($thumbnail) { ?>
                                      <button type="button" class="btn btn-danger btn-sm delete-image-btn"
                                        style="position:absolute; top:0; right:0;"
                                        onclick="deleteCaseStudyImage('main', '<?= $case_study_id ?>')">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                        <img id="bimage" src="../uploads/image/case_study/<?= $thumbnail ?>" style="width: 100%; height: 89px;margin-top: 12px;">
                                    <?php } else { ?>
                                        <img id="bimage" src="../uploads/image/no-image.png" style="width: 100%; height: 89px;margin-top: 12px;">
                                    <?php } ?>
                                    <input type="hidden" id="hidden_image" name='thumbnail' value="<?= $thumbnail ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <label class="control-label" for="input-banner_image">Middle Image</label>
                                        <input onchange="loadFile2(event,'banner_img')" type="file" name="banner_image" id="banner_image" accept=".png,.jpg,.jpeg" style="display: block;">
                                    </div>
                                    <?php if ($error_banner_image) { ?>
                                        <div class="text-danger">
                                            <?php echo $error_banner_image; ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-2 col-md-2 ">
                                    <?php if ($banner_image) { ?>
                                      <button type="button" class="btn btn-danger btn-sm delete-image-btn"
                                        style="position:absolute; top:0; right:0;"
                                        onclick="deleteCaseStudyImage('bannerimage', '<?= $case_study_id ?>')">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                        <img id="banner_img" src="../uploads/image/case_study/<?= $banner_image ?>" style="width: 100%; height: 89px;margin-top: 12px;">
                                    <?php } else { ?>
                                        <img id="banner_img" src="../uploads/image/no-image.png" style="width: 100%; height: 89px;margin-top: 12px;">
                                    <?php } ?>
                                    <input type="hidden" name='banner_image' value="<?= $banner_image ?>">
                                </div>
                            </div>
                            </br>
                            </br>
                            </br>
                            <div class="row">
                                <div class="table-responsive">
                                    <table id="images" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <td class="text-left">Gallery</td>
                                                <td class="text-right">Sort Order</td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php $image_row = 0;
                                            foreach ($case_study_images as $case_study_image) {
                                            ?>
                                                <tr id="image-row<?php echo $image_row; ?>">
                                                    <td class="text-left">
                                                        <a href="" id="thumb-image<?php echo $image_row; ?>" class="image-picker">
                                                            <img src="<?php echo $case_study_image['thumb']; ?>" alt="" title="" data-placeholder="" class="image-preview" style="width: 100px; height: 100px;" />
                                                        </a>
                                                        <input type="hidden" name="case_study_image[<?php echo $image_row; ?>][image]" value="<?php echo $case_study_image['image']; ?>" id="input-image<?php echo $image_row; ?>" />
                                                  <?php if ($error_case_study_image[$image_row]['image']) : ?>
                                                      <div class="text-danger"><?php echo $error_case_study_image[$image_row]['image']; ?></div>
                                                  <?php endif; ?>
                                                    </td>
                                                    <td class="text-right">
                                                        <input type="text" name="case_study_image[<?php echo $image_row; ?>][sort_order]" value="<?php echo $case_study_image['sort_order']; ?>" placeholder="sort order" class="form-control" />
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
                                                <td colspan="2"></td>
                                                <td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="add" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                        </div>


                    </div>
                    <br>
                    <div class="col-lg-6 col-md-6 bottom-inline-btns">
                        <button type="submit" form="form-customer" data-toggle="tooltip" title="Save" class="btn btn-success"> <i class="fa fa-save"></i> Submit</button>
                        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="Cancel" class="btn btn-danger"><i class="fa fa-reply"></i> Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#language a:first').tab('show');
</script>

<?php echo $footer; ?>
<script>
    var loadFile = function(event, outputElementId) {
        var output = document.getElementById(outputElementId);
        var file = event.target.files[0];
        var validExtensions = ['png', 'jpeg', 'jpg'];
        var maxSize = 5 * 1024 * 1024;
        if (file) {
            var extension = file.name.split('.').pop().toLowerCase();
            if (validExtensions.indexOf(extension) === -1 || file.size > maxSize) {
                event.target.value = '';
                alert('Please select a valid file (PNG, JPEG, JPG) less than 5 MB.');
                return false;
            } else {
                output.src = URL.createObjectURL(file);
                output.onload = function() {
                    URL.revokeObjectURL(output.src);
                };
            }
        }
    };
</script>
<script>
    var loadFile2 = function(event, outputElementId) {
        var output = document.getElementById(outputElementId);
        var file = event.target.files[0];
        var validExtensions = ['png', 'jpeg', 'jpg'];
        var maxSize = 5 * 1024 * 1024;
        if (file) {
            var extension = file.name.split('.').pop().toLowerCase();
            if (validExtensions.indexOf(extension) === -1 || file.size > maxSize) {
                event.target.value = '';
                alert('Please select a valid file (PNG, JPEG, JPG) less than 5 MB.');
                return false;
            } else {
                output.src = URL.createObjectURL(file);
                output.onload = function() {
                    URL.revokeObjectURL(output.src);
                };
            }
        }
    };
</script>
<script src="/themes/admin/javascript/common.js" type="text/javascript"></script>
<!-- <script>
    $(document).ready(function() {

        $('input[name=\'category\']').autocomplete({
            'source': function(request, response) {
                $.ajax({
                    url: '/admin/?controller=casestudycategories/autocomplete&token=<?php echo $token; ?>&filter_title=' + encodeURIComponent(request),
                    dataType: 'json',
                    success: function(json) {
                        response($.map(json, function(item) {
                            return {
                                label: item['title'],
                                value: item['cs_category_id']
                            }
                        }));
                    }
                });
            },
            'select': function(item) {
                $('input[name=\'category\']').val('');

                $('#case-study-category' + item['value']).remove();

                $('#case-study-category').append('<div id="case-study-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="categories[]" value="' + item['value'] + '" /></div>');
            }
        });

        $('#case-study-category').delegate('.fa-minus-circle', 'click', function() {
            $(this).parent().remove();
        });
    });
</script> -->
<script language="javascript" type="text/javascript">
    var image_row = <?php echo  $image_row; ?>;

    function addImage() {
        var html = '<tr id="image-row' + image_row + '">';
        html += '  <td class="text-left">';
        html += '    <a href="#" id="thumb-image' + image_row + '" class="image-picker">';
        html += '      <img src="../uploads/image/no-image.png" alt="" title="" data-placeholder="" class="image-preview" style="width: 100px; height: 100px;"/>';
        html += '    </a>';
        html += '    <input type="hidden" name="case_study_image[' + image_row + '][image]" value="" id="input-image' + image_row + '" />';
        html += '  </td>';
        html += '  <td class="text-right">';
        html += '    <input type="text" name="case_study_image[' + image_row + '][sort_order]" value="" placeholder="sort order" class="form-control" />';
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
    $(document).ready(function() {
        $('body').on('click', '.image-picker', function(e) {
            e.preventDefault();
            var imageRowId = $(this).attr('id');
            var maxSize = 5 * 1024 * 1024;
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

                    if (file.size > maxSize) {
                        alert('The file is too large. Please select a file smaller than '+maxSize+' MB.');
                        return;
                    }

                    var reader = new FileReader();
                    reader.readAsDataURL(file);
                    var fd = new FormData();
                    fd.append('image', file);
                    $.ajax({
                        url: '/admin/?controller=casestudy/uploadImages&token=<?php echo $token; ?>',
                        type: 'post',
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response['filename']) {
                                $('#' + imageRowId + ' .image-preview').attr('src', '../uploads/image/case_study/' + response['filename']);
                                var imageName = file.name;
                                $('#input-image' + imageRowId.replace('thumb-image', '')).val(response['filename']);
                            }
                        },
                    });
                }

            });
        });
    });
</script>
<!-- <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script> -->

<script type="text/javascript">
    <?php foreach ($languages as $lang) { ?>
        var lang = 'input-first_middle_description<?php echo $lang['language_id'] ?>';
        var code = '<?php echo $lang["code"] ?>';
        var textarea = document.getElementById(lang);
        CKEDITOR.replace(textarea, {
            language: code,
            basicEntities: false
        });
    <?php } ?>
</script>


<script type="text/javascript">
    <?php foreach ($languages as $lang) { ?>
        var lang = 'input-second_middle_description<?php echo $lang['language_id'] ?>';
        var code = '<?php echo $lang["code"] ?>';
        var textarea = document.getElementById(lang);
        CKEDITOR.replace(textarea, {
            language: code,
            basicEntities: false
        });
    <?php } ?>
</script>


<script type="text/javascript">
    <?php foreach ($languages as $lang) { ?>
        var lang = 'input-third_middle_description<?php echo $lang['language_id'] ?>';
        var code = '<?php echo $lang["code"] ?>';
        var textarea = document.getElementById(lang);
        CKEDITOR.replace(textarea, {
            language: code,
            basicEntities: false
        });
    <?php } ?>
</script>


<script type="text/javascript">
    <?php foreach ($languages as $lang) { ?>
        var lang = 'input-second_description<?php echo $lang['language_id'] ?>';
        var code = '<?php echo $lang["code"] ?>';
        var textarea = document.getElementById(lang);
        CKEDITOR.replace(textarea, {
            language: code,
            basicEntities: false
        });
    <?php } ?>
</script>

<!-- DELETE IMAGE SCRIPTS -->
<script>
function deleteCaseStudyImage(type, case_study_id) {
    if (confirm('Are you sure you want to delete this image?')) {
        fetch('<?php echo $deleteImage; ?>&type=' + type + '&case_study_id=' + case_study_id, {
            method: 'GET'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {

                // Map element IDs for each type
                let imgId = '';
                let hiddenId = '';

                if (type === 'main') {
                    imgId = 'bimage';
                    hiddenId = 'hidden_image';
                } else if (type === 'bannerimage') {
                    imgId = 'banner_img';
                    hiddenId = 'banner_image';
                } 
                // Reset image preview and hidden input
                document.getElementById(imgId).src = '../uploads/image/no_image.png';
                document.getElementById(hiddenId).value = '';
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
</script>
