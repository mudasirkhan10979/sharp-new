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
                                                name="award_description[<?php echo $lang['language_id'] ?>][title]"
                                                value="<?php echo isset($award_description[$lang['language_id']]) ? $award_description[$lang['language_id']]['title'] : ''; ?>"
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
                                     <div class="col-lg-6 col-md-6">
                                        <div class="form-group required">
                                            <label class="control-label"
                                                for="input-short-description<?php echo $lang['language_id'] ?>">
                                                Description
                                            </label>
                                            <textarea
                                                name="award_description[<?php echo $lang['language_id'] ?>][short_description]"
                                                rows="5" placeholder="Description"
                                                id="input-short-description<?php echo $lang['language_id'] ?>"
                                                class="form-control"><?php echo isset($award_description[$lang['language_id']]) ? $award_description[$lang['language_id']]['short_description'] : ''; ?></textarea>
                                            <?php if (isset($error_short_description[$lang['language_id']])) { ?>
                                            <div class="text-danger">
                                                <?php echo $error_short_description[$lang['language_id']]; ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div> 
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-data"> 
                            <div class="row col-md-12">                    
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group required">
                                        <label class="control-label" for="input-image">Award Image (185 × 172px)</label>
                                        <input onchange="loadFile(event)" type="file" name="image" id="image" accept=".png,.jpg,.jpeg" style="display: block;">
                                    </div>
                                    <?php if ($error_image) { ?>
                                        <div class="text-danger">
                                            <?php echo $error_image; ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-2 col-md-2 ">
                                    <?php if ($image) { ?>
                                        <img id="bimage" src="../uploads/image/awards/<?= $image ?>" style="width: 100%; height: 89px;margin-top: 12px;">
                                    <?php } else { ?>
                                        <img id="bimage" src="../uploads/image/no-image.png" style="width: 100%; height: 89px;margin-top: 12px;">
                                    <?php } ?>
                                    <input type="hidden" name='image' value="<?= $image ?>">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                            <div class="form-group required">
                                <label class="control-label" for="releasedate">Date</label>
                                <input type="date" name="publish_date" id="releasedate" class="form-control" value="<?php echo isset($publish_date) && $publish_date != '1970-01-01' ? $publish_date : ''; ?>" placeholder="dd/mm/yyyy">
                                <?php if ($error_publish_date) { ?>
                                    <div class="text-danger"><?php echo $error_publish_date; ?></div>
                                <?php } ?>
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
var loadFile = function(event) {
    var output = document.getElementById('bimage');
    var file = event.target.files[0];
    var validExtensions = ['png', 'jpeg', 'jpg', 'svg'];
    var maxSize = 2 * 1024 * 1024;
    if (file) {
        var extension = file.name.split('.').pop().toLowerCase();
        if (validExtensions.indexOf(extension) === -1 || file.size > maxSize) {
            event.target.value = '';
            alert('Please select a valid file (PNG, JPEG, JPG, SVG) less than 2 MB.');
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
    <?php foreach ($languages as $lang) { ?>
        var lang = 'input-short-description<?php echo $lang['language_id'] ?>';
        var code = '<?php echo $lang["code"] ?>';
        var textarea = document.getElementById(lang);
        CKEDITOR.replace(textarea, {
            language: code,
            basicEntities: false
        });
    <?php } ?>
</script>