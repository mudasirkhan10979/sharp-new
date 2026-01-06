<?php echo $header; ?>
<div class="main-panel">
    <div class="sec-head">
        <div class="sec-head-title">
            <h3><?php echo $text_form; ?></h3>
        </div>
        <div class="sec-head-btns">
            <button type="submit" form="form-attribute-value" data-toggle="tooltip" title="<?php echo $button_save; ?>"
                class="btn btn-primary"><i class="fa fa-save"></i></button>
            <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>"
                class="btn btn-primary"><i class="fa fa-reply"></i></a>
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
                <?php } ?>
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-attribute-value"
                    class="form-horizontal">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
                        <li><a href="#tab-data" data-toggle="tab">Data</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-general">
                            <ul class="nav nav-tabs" id="language">
                                <?php foreach ($languages as $lang) { ?>
                                <li><a href="#language<?php echo $lang['language_id'] ?>" data-toggle="tab"><img
                                            src="/vars/lang/be/<?php echo $lang['code']; ?>-<?php echo $lang['image']; ?>" />
                                        <?php echo $lang['name'] ?></a></li>
                                <?php } ?>
                            </ul>
                            <div class="tab-content">
                                <?php foreach ($languages as $lang) { ?>
                                <div class="tab-pane" id="language<?php echo $lang['language_id'] ?>">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group required">
                                            <label class="control-label"
                                                for="input-title<?php echo $lang['language_id'] ?>">
                                                Value Title
                                            </label>
                                            <input type="text"
                                                name="attribute_value_description[<?php echo $lang['language_id'] ?>][title]"
                                                value="<?php echo isset($attribute_value_description[$lang['language_id']]) ? $attribute_value_description[$lang['language_id']]['title'] : ''; ?>"
                                                placeholder="Value Title"
                                                id="input-title<?php echo $lang['language_id'] ?>"
                                                class="form-control" />
                                            <?php if (isset($error_title[$lang['language_id']])) { ?>
                                            <div class="text-danger">
                                                <?php echo $error_title[$lang['language_id']]; ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-data">
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group required">
                                    <label class="control-label" for="input-attribute-id">
                                        Attribute
                                    </label>
                                    <select name="attribute_id" id="input-attribute-id" class="form-control">
                                        <option value="">Choose Attribute</option>
                                        <?php foreach ($attributes as $attribute) { ?>
                                        <option value="<?php echo $attribute['id']; ?>"
                                            <?php echo ($attribute['id'] == $attribute_id) ? "selected" : ""; ?>>
                                            <?php echo $attribute['title']; ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                    <?php if (isset($error_attribute_id)) { ?>
                                    <div class="text-danger">
                                        <?php echo $error_attribute_id; ?>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group required">
                                    <label class="control-label" for="input-attribute-key">
                                        Attribute Key
                                    </label>
                                    <input type="text" name="attribute_key" value="<?php echo $attribute_key; ?>"
                                        placeholder="Attribute Key (e.g., color_red, size_large)"
                                        id="input-attribute-key" class="form-control" />
                                    <?php if (isset($error_attribute_key)) { ?>
                                    <div class="text-danger">
                                        <?php echo $error_attribute_key; ?>
                                    </div>
                                    <?php } ?>
                                    <span class="help-block">Unique identifier for this attribute value</span>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-sort-order">
                                        Sort Order
                                    </label>
                                    <input type="number" name="sort_order" value="<?php echo $sort_order; ?>"
                                        class="form-control" />
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
                        </div>
                        <div class="col-lg-12 col-md-12 bottom-inline-btns">
                            <button type="submit" form="form-attribute-value" data-toggle="tooltip" title="Save"
                                class="btn btn-success"> <i class="fa fa-save"></i> Submit</button>
                            <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="Cancel"
                                class="btn btn-danger"><i class="fa fa-reply"></i> Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$('#language a:first').tab('show');

// Generate attribute key from title
$(document).ready(function() {
    $('#input-title1').on('blur', function() {
        var title = $(this).val();
        if (title && !$('#input-attribute-key').val()) {
            var key = title.toLowerCase().replace(/[^a-z0-9]+/g, '_').replace(/^-|-$/g, '');
            $('#input-attribute-key').val(key);
        }
    });
});
</script>
<?php echo $footer; ?>