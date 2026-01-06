<?php echo $header; ?>
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
                                    <li><a href="#language<?php echo $lang['language_id'] ?>" data-toggle="tab"><img src="/vars/lang/be/<?php echo $lang['code']; ?>-<?php echo $lang['image']; ?>" />
                                            <?php echo $lang['name'] ?></a></li>
                                <?php } ?>
                            </ul>
                            <div class="tab-content">
                                <?php foreach ($languages as $lang) { ?>
                                    <div class="tab-pane" id="language<?php echo $lang['language_id'] ?>">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group required">
                                                <label class="control-label" for="input-title<?php echo $lang['language_id'] ?>">
                                                    Title
                                                </label>

                                                <input type="text" name="location_description[<?php echo $lang['language_id'] ?>][title]" value="<?php echo isset($location_description[$lang['language_id']]) ? $location_description[$lang['language_id']]['title'] : ''; ?>" placeholder="Title" id="input-meta_title<?php echo $lang['language_id'] ?>" class="form-control" />
                                                <?php if (isset($error_title[$lang['language_id']])) { ?>
                                                    <div class="text-danger">
                                                        <?php echo $error_title[$lang['language_id']]; ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group required">
                                                <label class="control-label" for="input-description<?php echo $lang['language_id'] ?>">
                                                    Description
                                                </label>
                                                <textarea name="location_description[<?php echo $lang['language_id'] ?>][description]" rows="5" placeholder="Description" id="input-description<?php echo $lang['language_id'] ?>" class="form-control"><?php echo isset($location_description[$lang['language_id']]) ? $location_description[$lang['language_id']]['description'] : ''; ?></textarea>
                                                <?php if (isset($error_description[$lang['language_id']])) { ?>
                                                    <div class="text-danger">
                                                        <?php echo $error_description[$lang['language_id']]; ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <!-- <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label class="control-label"
                                                for="input-meta_title<?php echo $lang['language_id'] ?>">
                                                Meta Title
                                            </label>
                                            <input type="text" name="location_description[<?php echo $lang['language_id'] ?>][meta_title]" value="<?php echo isset($location_description[$lang['language_id']]) ? $location_description[$lang['language_id']]['meta_title'] : ''; ?>" placeholder="Meta Title" id="input-meta_title<?php echo $lang['language_id'] ?>" class="form-control" />
                                            <?php if (isset($errors_meta_title[$lang['language_id']])) { ?>
                                                <div class="text-danger">
                                                    <?php echo $errors_meta_title[$lang['language_id']]; ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>  -->
                                        <!-- <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label class="control-label"
                                                for="input-meta_description<?php echo $lang['language_id'] ?>">
                                                Meta Description
                                            </label>
                                            <textarea
                                                name="location_description[<?php echo $lang['language_id'] ?>][meta_description]"
                                                rows="5" placeholder="Meta Description"
                                                id="input-meta_description<?php echo $lang['language_id'] ?>"
                                                class="form-control"><?php echo isset($location_description[$lang['language_id']]) ? $location_description[$lang['language_id']]['meta_description'] : ''; ?></textarea>
                                            <?php if (isset($error_meta_description[$lang['language_id']])) { ?>
                                            <div class="text-danger">
                                                <?php echo $error_meta_description[$lang['language_id']]; ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div> -->
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-data">
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
                                    <label class="control-label" for="input-publish">
                                        Status
                                    </label>
                                    <select name="publish" id="input-publish" class="form-control">
                                        <?php if ($publish) { ?>
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
                            <button type="submit" form="form-customer" data-toggle="tooltip" title="Save" class="btn btn-success"> <i class="fa fa-save"></i> Submit</button>
                            <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="Cancel" class="btn btn-danger"><i class="fa fa-reply"></i> Cancel</a>
                        </div>
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

<script type="text/javascript">
    $(document).ready(function() {
        <?php foreach ($languages as $lang) { ?>
            var lang = 'input-description<?php echo $lang['language_id'] ?>';
            var code = '<?php echo $lang["code"] ?>';
            var textarea = document.getElementById(lang);
            CKEDITOR.replace(textarea, {
                language: code,
                basicEntities: false
            });
        <?php } ?>
    });
</script>
<script>
    var loadFile = function(event) {
        var output = document.getElementById('image');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
        }
    };
</script>