<?php echo $header; ?>
<div class="main-panel">
    <div class="sec-head">
        <div class="sec-head-title">
            <h3><?php echo $text_form; ?></h3>
        </div>
        <div class="sec-head-btns">
            <button type="submit" form="form-service-center" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-service-center" class="form-horizontal">
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
                                                <label class="control-label" for="input-service-center-name<?php echo $lang['language_id'] ?>">
                                                    Service Center Name
                                                </label>
                                                <input type="text" name="service_center_description[<?php echo $lang['language_id'] ?>][service_center_name]" value="<?php echo isset($service_center_description[$lang['language_id']]) ? $service_center_description[$lang['language_id']]['service_center_name'] : ''; ?>" placeholder="Service Center Name" id="input-service-center-name<?php echo $lang['language_id'] ?>" class="form-control" />
                                                <?php if (isset($error_service_center_name[$lang['language_id']])) { ?>
                                                    <div class="text-danger">
                                                        <?php echo $error_service_center_name[$lang['language_id']]; ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group required">
                                                <label class="control-label" for="input-address<?php echo $lang['language_id'] ?>">
                                                    Address
                                                </label>
                                                <textarea name="service_center_description[<?php echo $lang['language_id'] ?>][address]" rows="5" placeholder="Address" id="input-address<?php echo $lang['language_id'] ?>" class="form-control"><?php echo isset($service_center_description[$lang['language_id']]) ? $service_center_description[$lang['language_id']]['address'] : ''; ?></textarea>
                                                <?php if (isset($error_address[$lang['language_id']])) { ?>
                                                    <div class="text-danger">
                                                        <?php echo $error_address[$lang['language_id']]; ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-data">
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group required">
                                    <label class="control-label" for="input-sr">
                                        SR Number
                                    </label>
                                    <input type="number" name="sr" value="<?php echo $sr; ?>" class="form-control" />
                                    <?php if (isset($error_sr)) { ?>
                                        <div class="text-danger"><?php echo $error_sr; ?></div>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4">
                                <div class="form-group required">
                                    <label class="control-label" for="input-phone">
                                        Phone
                                    </label>
                                    <input type="text" name="phone" value="<?php echo $phone; ?>" placeholder="Phone" class="form-control" />
                                    <?php if (isset($error_phone)) { ?>
                                        <div class="text-danger"><?php echo $error_phone; ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group required">
                                    <label class="control-label" for="input-email">
                                        Email
                                    </label>
                                    <input type="text" name="email" value="<?php echo $email; ?>" placeholder="Email" class="form-control" />
                                    <?php if (isset($error_email)) { ?>
                                        <div class="text-danger"><?php echo $error_email; ?></div>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4">
                                <div class="form-group required">
                                    <label class="control-label" for="input-country">
                                        Country
                                    </label>
                                    <select name="country_id" id="input-country" class="form-control">
                                        <option value="">Select Country</option>
                                        <?php foreach ($countries as $country) { ?>
                                            <option value="<?php echo $country['country_id']; ?>" <?php echo ($country_id == $country['country_id']) ? 'selected' : ''; ?>>
                                                <?php echo $country['name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <?php if (isset($error_country_id)) { ?>
                                        <div class="text-danger"><?php echo $error_country_id; ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group required">
                                    <label class="control-label" for="input-department">
                                        Department
                                    </label>
                                    <select name="department" id="input-department" class="form-control">
                                        <option value="">Select Department</option>
                                        <option value="Consumer Electronics" <?php echo ($department == 'Consumer Electronics') ? 'selected' : ''; ?>>Consumer Electronics</option>
                                        <option value="Business Solutions" <?php echo ($department == 'Business Solutions') ? 'selected' : ''; ?>>Business Solutions</option>
                                    </select>
                                    <?php if (isset($error_department)) { ?>
                                        <div class="text-danger"><?php echo $error_department; ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group required">
                                    <label class="control-label" for="input-landline">
                                        Contact Number
                                    </label>
                                    <input type="text" name="landline" value="<?php echo $landline; ?>" placeholder="Landline" class="form-control" />
                                    <?php if (isset($error_landline)) { ?>
                                        <div class="text-danger"><?php echo $error_landline; ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="input-sort-order">
                                        Sort Order
                                    </label>
                                    <input type="number" name="sort_order" value="<?php echo $sort_order; ?>" class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
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
                            <button type="submit" form="form-service-center" data-toggle="tooltip" title="Save" class="btn btn-success"> <i class="fa fa-save"></i> Submit</button>
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
            var lang = 'input-address<?php echo $lang['language_id'] ?>';
            var code = '<?php echo $lang["code"] ?>';
            var textarea = document.getElementById(lang);
            CKEDITOR.replace(textarea, {
                language: code,
                basicEntities: false
            });
        <?php } ?>
    });
</script>


