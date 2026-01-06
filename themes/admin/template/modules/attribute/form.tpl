<?php echo $header; ?>
<style>
        .select2-selection__choice {
        font-family: Arial, Helvetica, sans-serif !important;
        font-size: 13px !important;
    }
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

<div class="main-panel">
    <div class="sec-head">
        <div class="sec-head-title">
            <h3><?php echo $text_form; ?></h3>
        </div>
        <div class="sec-head-btns">
            <button type="submit" form="form-attribute" data-toggle="tooltip" title="<?php echo $button_save; ?>"
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
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-attribute"
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
                                                Attribute Title
                                            </label>
                                            <input type="text"
                                                name="attribute_description[<?php echo $lang['language_id'] ?>][title]"
                                                value="<?php echo isset($attribute_description[$lang['language_id']]) ? $attribute_description[$lang['language_id']]['title'] : ''; ?>"
                                                placeholder="Attribute Title"
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
                                <div class="form-group">
                                <label class="control-label" for="category-id">Choose Categories</label>
                                    <select name="category_id[]" id="category-id" class="js-select6 select-large form-control" multiple="multiple">
                                         <?php foreach ($categories as $category) { ?>
                                            <option value="<?php echo $category['category_id']; ?>" <?php if (in_array($category['category_id'], $category_id)) { ?> selected <?php } ?>>
                                        <?php echo $category['title']; ?>
                                    </option>
                                        <?php } ?>
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
                                    <label class="control-label" for="input-category-id">
                                        Category
                                    </label>
                                    <select name="category_id" id="input-category-id" class="form-control">
                                        <option value="">Choose Category</option>
                                        <?php foreach ($categories as $category) { ?>
                                        <option value="<?php echo $category['category_id']; ?>"
                                            <?php echo ($category['category_id'] == $category_id) ? "selected" : ""; ?>>
                                            <?php echo $category['title']; ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                    <?php if (isset($error_category_id)) { ?>
                                    <div class="text-danger">
                                        <?php echo $error_category_id; ?>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div> -->

                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-sort_order">
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
                            <button type="submit" form="form-attribute" data-toggle="tooltip" title="Save"
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
</script>
<?php echo $footer; ?>

<script>
        $(".js-select6").select2({
        closeOnSelect: false,
        allowHtml: false,
        allowClear: false,
        placeholder: "Please select any service",
        tags: true,
        createTag: function() {
            return null;
        }
    });
</script>