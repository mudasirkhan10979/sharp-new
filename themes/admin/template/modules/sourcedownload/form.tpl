<?php echo $header; ?>
<div class="main-panel">
    <div class="sec-head">
        <div class="sec-head-title">
            <h3><?php echo $text_form; ?></h3>
        </div>
        <div class="sec-head-btns">
            <button type="submit" form="form-customer" data-toggle="tooltip" title="<?php echo $button_save; ?>"
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
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-user"
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
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group required">
                                            <label class="control-label"
                                                for="input-title<?php echo $lang['language_id'] ?>">
                                                Title
                                            </label>
                                            <input type="text"
                                                name="source_description[<?php echo $lang['language_id'] ?>][title]"
                                                value="<?php echo isset($source_description[$lang['language_id']]) ? $source_description[$lang['language_id']]['title'] : ''; ?>"
                                                placeholder="Title"
                                                id="input-meta_title<?php echo $lang['language_id'] ?>"
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
        <label class="control-label" for="input-product-id">Product</label>
        <select name="product_id" id="input-product-id" class="form-control">
            <option value="">Choose Product</option>
            <?php foreach ($products as $product) { ?>
                <option value="<?php echo $product['product_id']; ?>"
                    <?php echo ($product['product_id'] == $product_id) ? "selected" : ""; ?>>
                    <?php echo $product['name']; ?>
                </option>
            <?php } ?>
        </select>

        <?php if (isset($error_product_id[$lang['language_id']])) { ?>
            <div class="text-danger">
                <?php echo $error_product_id[$lang['language_id']]; ?>
            </div>
        <?php } ?>
    </div>
</div>

                        <!-- PDF Upload Section -->
                        <div class="row" style="padding-right: 9px;padding-left: 9px;">
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group required">
                                    <label class="control-label" for="input-pdf">PDF File</label>
                                    <input type="file" name="file" id="input-pdf" class="form-control" accept=".pdf,application/pdf" onchange="validatePdfSize(this)" />
                                    <?php if (isset($error_file)) { ?>
                                        <div class="text-danger"><?php echo $error_file; ?></div>
                                    <?php } ?>
                                    <span class="help-block">Upload PDF file (max size: 13MB)</span>
                                </div>
                                <div class="col-lg-2 col-md-2 ">
                                    <?php if (!empty($file)) { ?>
                                        <a href="../uploads/image/source_code_files/<?= $file ?>" target="_blank">
                                            <img src="../uploads/defult-pdf.png" alt="PDF Thumbnail" style="max-width: 100px; max-height: 150px; border: 1px solid #ddd;">
                                        </a>
                                        <input type="hidden" name="existing_file" value="<?php echo $file; ?>" />
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
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
                        <div class="col-lg-6 col-md-6 bottom-inline-btns">
                            <button type="submit" form="form-customer" data-toggle="tooltip" title="Save"
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
function validatePdfSize(input) {
     var maxSize = 13 * 1024 * 1024; // 13MB
    //  var maxSize = 50 * 1024; // 50KB (50 * 1024 = 51,200 bytes)
    var file = input.files[0];
    
    if (file) {
        // Check if it's a PDF
        if (file.type !== 'application/pdf' && !file.name.toLowerCase().endsWith('.pdf')) {
            alert('Please select a valid PDF file.');
            input.value = '';
            return false;
        }
        
        // Check file size
        if (file.size > maxSize) {
            var fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
            alert('PDF file size must be less than 13MB. Your file is ' + fileSizeMB + ' MB.');
            input.value = '';
            return false;
        }
    }
    return true;
}
</script>

<script>
$(document).ready(function() {
    $('#input-product-id').select2({
        placeholder: "Choose Product",
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

