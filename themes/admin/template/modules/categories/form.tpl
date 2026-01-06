<?php echo $header; ?>
<style>
    /* Input field styling */
    .multi-select {
        border: 1px solid #ced4da;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 8px 12px;
        font-size: 14px;
        width: 100%;
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
<style>
   /* Remove default checkbox styling completely */
#input-show-on-home,
#input-show-on-footer,
#input-show-on-header {
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
#input-show-on-home:checked,
#input-show-on-footer:checked,
#input-show-on-header:checked {
    border-color: blue;
    background-color: blue;
}

/* Add single custom check icon */
#input-show-on-home:checked::after,
#input-show-on-footer:checked::after,
#input-show-on-header:checked::after {
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
                                    <li><a href="#language<?php echo $lang['language_id'] ?>" data-toggle="tab"><img src="/vars/lang/be/<?php echo $lang['code']; ?>-<?php echo $lang['image']; ?>" /> <?php echo $lang['name'] ?></a></li>
                                <?php } ?>
                            </ul>
                            <div class="tab-content">
                                <?php foreach ($languages as $lang) { ?>
                                    <div class="tab-pane" id="language<?php echo $lang['language_id'] ?>">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group required">
                                                <label class="control-label" for="input-title<?php echo $lang['language_id'] ?>">
                                                    TItle
                                                </label>
                                                <input type="text" name="sc_categories_description[<?php echo $lang['language_id'] ?>][title]" value="<?php echo isset($sc_categories_description[$lang['language_id']]) ? $sc_categories_description[$lang['language_id']]['title'] : ''; ?>" placeholder="Title" id="input-title<?php echo $lang['language_id'] ?>" class="form-control" />
                                                <?php if (isset($error_title[$lang['language_id']])) { ?>
                                                    <div class="text-danger">
                                                        <?php echo $error_title[$lang['language_id']]; ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="input-short_description<?php echo $lang['language_id'] ?>">
                                                    Short Description
                                                </label>
                                                <textarea name="sc_categories_description[<?php echo $lang['language_id'] ?>][short_description]" rows="5" placeholder="Short Description" id="input-short_description<?php echo $lang['language_id'] ?>" class="form-control"><?php echo isset($sc_categories_description[$lang['language_id']]) ? $sc_categories_description[$lang['language_id']]['short_description'] : ''; ?> </textarea>

                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="input-meta_title<?php echo $lang['language_id'] ?>">
                                                    Meta Title
                                                </label>
                                                <input type="text" name="sc_categories_description[<?php echo $lang['language_id'] ?>][meta_title]" value="<?php echo isset($sc_categories_description[$lang['language_id']]) ? $sc_categories_description[$lang['language_id']]['meta_title'] : ''; ?>" placeholder="Meta Title" id="input-meta_title<?php echo $lang['language_id'] ?>" class="form-control" />

                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="input-meta_keyword<?php echo $lang['language_id'] ?>">
                                                    Meta Keyword
                                                </label>
                                                <input type="text" name="sc_categories_description[<?php echo $lang['language_id'] ?>][meta_keyword]" value="<?php echo isset($sc_categories_description[$lang['language_id']]) ? $sc_categories_description[$lang['language_id']]['meta_keyword'] : ''; ?>" placeholder="Meta Keyword" id="input-meta_keyword<?php echo $lang['language_id'] ?>" class="form-control" />

                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="input-meta_description<?php echo $lang['language_id'] ?>">
                                                    Meta Description
                                                </label>
                                                <textarea name="sc_categories_description[<?php echo $lang['language_id'] ?>][meta_description]" rows="5" placeholder="Meta Description" id="input-meta_description<?php echo $lang['language_id'] ?>" class="form-control"><?php echo isset($sc_categories_description[$lang['language_id']]) ? $sc_categories_description[$lang['language_id']]['meta_description'] : ''; ?> </textarea>

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
                                        <input type="hidden" name="show_on_home" value="0">
                                        <input type="checkbox" name="show_on_home" id="input-show-on-home" value="1" class="form-check-input"
                                            <?php echo isset($show_on_home) && $show_on_home == '1' ? 'checked' : ''; ?> />
                                        <label class="form-check-label" for="input-show-on-home">
                                            Show on Home Page Popular Category
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="hidden" name="show_on_footer" value="0">
                                        <input type="checkbox" name="show_on_footer" id="input-show-on-footer" value="1" class="form-check-input"
                                            <?php echo isset($show_on_footer) && $show_on_footer == '1' ? 'checked' : ''; ?> />
                                        <label class="form-check-label" for="input-show-on-footer">
                                            Show on Footer Menu
                                             <span style="margin-left:8px; font-size:13px; font-weight:500; color:#555;">
                                                (You can show only the 2nd-step category in the footer from here)
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                             <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="hidden" name="show_on_header" value="0">
                                        <input type="checkbox" name="show_on_header" id="input-show-on-header" value="1" class="form-check-input"
                                            <?php echo isset($show_on_header) && $show_on_header == '1' ? 'checked' : ''; ?> />
                                        <label class="form-check-label" for="input-show-on-header">
                                            Show on Header Menu
                                             <span style="margin-left:8px; font-size:13px; font-weight:500; color:#555;">
                                                (You can show only the 3nd-step category in the header from here)
                                            </span>
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
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-parent">Parent category</label>
                                <div class="col-sm-6" >
                                    <input type="text" name="path" value="<?php echo $path; ?>" placeholder="Parent category" id="input-parent" class="form-control" />
                                    <input type="hidden" name="parent_id" value="<?php echo $parent_id; ?>" />
                                    <?php if ($error_parent) { ?>
                                        <div class="text-danger"><?php echo $error_parent; ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <!-- <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-home_status">
                                        Show On Mobile Home
                                    </label>
                                    <select name="home_status" id="input-home_status" class="form-control">
                                        <?php if ($home_status) { ?>
                                            <option value="1" selected="selected">Yes</option>
                                            <option value="0">No</option>
                                        <?php } else { ?>
                                            <option value="1">Yes</option>
                                            <option value="0" selected="selected">No</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div> -->

                            <!-- <div class="col-lg-6 col-md-6">
                                <div class="form-group required">
                                    <label class="control-label" for="input-type">
                                        Type
                                    </label>
                                    <select name="type" id="input-type" class="form-control">
                                        <?php if ($type) { ?>
                                            <option value="0">Service</option>
                                            <option value="1" selected="selected">Team</option>
                                        <?php } else { ?>
                                            <option value="0" selected="selected">Service</option>
                                            <option value="1">Team</option>
                                        <?php } ?>
                                    </select>
                                    <?php if ($error_type) { ?>
                                        <div class="text-danger"><?php echo $error_type; ?></div>
                                    <?php } ?>
                                </div>
                            </div> -->
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
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-sort_order">
                                        Sort Order
                                    </label>
                                    <input type="number" name="sort_order" value="<?php echo $sort_order; ?>" class="form-control" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="input-image">Image</label>
                                        <input onchange="loadFile(event)" type="file" name="image" id="image" accept=".png,.jpg,.jpeg" style="display: block;">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 ">
                                    <?php if ($image) { ?>
                                        <button type="button" class="btn btn-danger btn-sm delete-image-btn"
                                            style="position:absolute; top:0; right:0;"
                                            onclick="deleteCategoryImage('<?= $category_id ?>', 'main')">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                        <img id="scimage" src="../uploads/image/categories/<?= $image ?>" style="width: 100%; height: 89px;margin-top: 12px;">
                                    <?php } else { ?>
                                        <img id="scimage" src="../uploads/image/no-image.png" style="width: 100%; height: 89px;margin-top: 12px;">
                                    <?php } ?>
                                    <input type="hidden" id="hidden_image" name="hidden_image"  value="<?= $image ?>">
                                </div>
                            </div>
                             <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="input-feature_image">Feature Image</label>
                                        <input onchange="loadFile2(event)" type="file" name="feature_image" id="feature_image" accept=".png,.jpg,.jpeg" style="display: block;">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 ">
                                    <?php if ($feature_image) { ?>
                                            <button type="button" class="btn btn-danger btn-sm delete-feature_image-btn"
                                                style="position:absolute; top:0; right:0;"
                                                onclick="deleteCategoryImage('<?= $category_id ?>', 'feature_image')">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                        <img id="scfeature_image" src="../uploads/image/categories/<?= $feature_image ?>" style="width: 100%; height: 89px;margin-top: 12px;">
                                    <?php } else { ?>
                                        <img id="scfeature_image" src="../uploads/image/no-image.png" style="width: 100%; height: 89px;margin-top: 12px;">
                                    <?php } ?>
                                    <input type="hidden" id="hidden_feature_image" name="hidden_feature_image"  value="<?= $feature_image ?>">
                                </div>
                            </div>

                        </div>
                    </div>
                    <br>
                    <div class="col-lg-6 col-md-6 bottom-inline-btns">
                    <?php if (!$viewer) { ?>
                        <button type="submit" form="form-customer" data-toggle="tooltip" title="Save" class="btn btn-success"> <i class="fa fa-save"></i> Submit</button>
                        <?php } ?>
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
<script src="/themes/admin/javascript/common.js" type="text/javascript"></script>
<script>
    var loadFile = function(event) {
        var file = event.target.files[0];
        var output = document.getElementById('scimage');
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
    var loadFile2 = function(event) {
        var file = event.target.files[0];
        var output = document.getElementById('scfeature_image');
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
<script type="text/javascript">
    $('input[name=\'path\']').autocomplete({
        'source': function(request, response) {
            $.ajax({
                url: '/admin/?controller=categories/autocomplete&token=<?php echo $token; ?>&filter_title=' + encodeURIComponent(request),
                dataType: 'json',
                success: function(json) {
                    json.unshift({
                        category_id: 0,
                        title: 'None'
                    });

                    response($.map(json, function(item) {
                        return {
                            label: item['title'],
                            value: item['category_id']
                        }
                    }));
                }
            });
        },
        'select': function(item) {
            $('input[name=\'path\']').val(item['label']);
            $('input[name=\'parent_id\']').val(item['value']);
        }
    });
</script>
<script>
function deleteCategoryImage(category_id, type = 'main') {
    if (confirm('Are you sure you want to delete this image?')) {
        const formData = new FormData();
        formData.append('category_id', category_id);
        formData.append('type', type);
        fetch('<?php echo $deleteImage; ?>', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                if (type === 'main') {
                    const img = document.getElementById('scimage');
                    img.src = '../uploads/image/no-image.png?' + new Date().getTime();
                    document.getElementById('hidden_image').value = '';
                    const btn = document.querySelector('.delete-image-btn');
                    if (btn) btn.style.display = 'none';
                } else if (type === 'feature_image') {
                    const img = document.getElementById('scfeature_image');
                    img.src = '../uploads/image/no-image.png?' + new Date().getTime();
                    document.getElementById('hidden_feature_image').value = '';
                    const btn = document.querySelector('.delete-feature_image-btn');
                    if (btn) btn.style.display = 'none';
                }
            } else {
                alert(data.error || 'Error deleting image.');
            }
        })
        .catch(err => {
            console.error('Error deleting Category image:', err);
            alert('Something went wrong while deleting the image.');
        });
    }
}
</script>

