<?php echo $header; ?>
<style>
    .select2-selection__choice {
        font-family: Arial, Helvetica, sans-serif !important;
        font-size: 13px !important;
    }

    /* Remove default browser checkbox styling */
    #input-show-in-footer {
        -webkit-appearance: none; 
        -moz-appearance: none; 
        appearance: none; 
        width: 20px;
        height: 20px;
        border: 2px solid #ccc;
        border-radius: 4px;
        cursor: pointer;
        position: relative;
    }
    #input-show-in-footer:checked {
        border-color: blue;
        background-color: blue;
    }
    #input-show-in-footer:checked::after {
        color: white;
        font-size: 16px;
        position: absolute;
        top: 2px;
        left: 3px;
    }
    #tab-data .form-check-label{
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
                                                for="input-description<?php echo $lang['language_id'] ?>">
                                                Question
                                            </label>
                                            <textarea
                                                name="faqs_description[<?php echo $lang['language_id'] ?>][question]"
                                                rows="5" placeholder="Question"
                                                id="input-description<?php echo $lang['language_id'] ?>"
                                                class="form-control"><?php echo isset($faqs_description[$lang['language_id']]) ? $faqs_description[$lang['language_id']]['question'] : ''; ?></textarea>
                                            <?php if (isset($error_faqquestion[$lang['language_id']])) { ?>
                                            <div class="text-danger">
                                                <?php echo $error_faqquestion[$lang['language_id']]; ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group required">
                                            <label class="control-label"
                                                for="input-description<?php echo $lang['language_id'] ?>">
                                                Answer
                                            </label>
                                            <textarea
                                                name="faqs_description[<?php echo $lang['language_id'] ?>][answer]"
                                                placeholder="Answer"
                                                id="input-ans-description<?php echo $lang['language_id'] ?>"
                                                class="form-control"><?php echo isset($faqs_description[$lang['language_id']]) ? $faqs_description[$lang['language_id']]['answer'] : ''; ?></textarea>
                                            <?php if (isset($error_faqanswer[$lang['language_id']])) { ?>
                                            <div class="text-danger">
                                                <?php echo $error_faqanswer[$lang['language_id']]; ?>
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
                                <div class="form-check">
                                    <input 
                                        type="checkbox" 
                                        name="show_in_footer" 
                                        id="input-show-in-footer" 
                                        value="<?php echo $show_in_footer; ?>" 
                                        class="form-check-input"
                                        <?php echo isset($show_in_footer) && $show_in_footer == '1' ? 'checked' : ''; ?> />
                                    <label class="form-check-label" for="input-show-in-footer" >
                                        Show on Sustainability
                                    </label>
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
                                    <label class="control-label" for="input-publish">
                                        Publish
                                    </label>
                                    <select name="publish" id="input-publish" class="form-control">
                                        <?php if ($publish) { ?>
                                        <option value="1" selected="selected">Yes</option>
                                        <option value="0">No</option>
                                        <?php } else { ?>
                                        <option value="1">Yes</option>
                                        <option value="0" selected="selected">No</option>
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
var loadFile = function(event) {
    var output = document.getElementById('bimage');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
        URL.revokeObjectURL(output.src) // free memory
    }
};
</script>
<script>
     <?php foreach ($languages as $lang) { ?>
        var lang = 'input-ans-description<?php echo $lang['language_id'] ?>';
        var code = '<?php echo $lang["code"] ?>';
        var textarea = document.getElementById(lang);
        CKEDITOR.replace(textarea, {
            language: code,
            basicEntities: false
        });
    <?php } ?>
</script>
<script>
    // JavaScript/jQuery for dynamic behavior
    document.getElementById('input-show-in-footer').addEventListener('change', function () {
        // Change value to 1 when checked, 0 when unchecked
        this.value = this.checked ? '1' : '0';

        // Apply custom styles for checked state
        if (this.checked) {
            this.style.accentColor = "blue"; // Works in modern browsers
        } else {
            this.style.accentColor = ""; // Reset to default
        }
    });
</script>