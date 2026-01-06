<?php echo $header; ?>
<div id="content" class="main-panel">
    <div class="sec-head">
        <div class="sec-head-title">
            <h3><?php echo $text_edit; ?></h3>
        </div>
        <div class="sec-head-btns">
            <?php if (!$viewer) { ?>
            <button type="submit" form="form-customer" data-toggle="tooltip" title="<?php echo $button_save; ?>"
                class="btn btn-primary"><i class="fa fa-save"></i></button>
            <?php } ?>
            <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>"
                class="btn btn-primary"><i class="fa fa-reply"></i></a>
        </div>
    </div>

    <div class="main-employee-box">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <?php if ($success) { ?>
        <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="panel-body">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-setting"
                class="form-horizontal">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
                    <!--  <li><a href="#tab-drycleaning" data-toggle="tab">Dry Cleaning</a></li> -->
                    <li><a href="#tab-meta" data-toggle="tab"><?php echo $tab_meta; ?></a></li>
                    <li><a href="#tab-mail" data-toggle="tab"><?php echo $tab_mail; ?></a></li>
                    <li><a href="#tab-server" data-toggle="tab"><?php echo $tab_server; ?></a></li>
                    <li><a href="#tab-google" data-toggle="tab"><?php echo $tab_google; ?></a></li>
                    <li><a href="#tab-misc" data-toggle="tab"><?php echo $tab_misc; ?></a></li>
                    <li><a href="#tab-payment" style="display: none;" data-toggle="tab">Payment</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-general">

                    <?php foreach ($languages as $language) { ?>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-config_name<?php echo $language['language_id']; ?>">
                                    <img src="/vars/lang/be/<?php echo $language['code']; ?>-<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                                    <span data-toggle="tooltip" data-container="#tab-general" title="<?php echo $entry_owner; ?>"><?php echo $entry_owner; ?></span>
                                </label>
                                <div class="col-sm-10">
                                    <input name="config_name<?php echo $language['language_id']; ?>" placeholder="<?php echo $entry_owner; ?>" id="input-config_name<?php echo $language['language_id'] ?>" class="form-control" value="<?php if (isset($config_name[$language['language_id']])) { echo $config_name[$language['language_id']];                                                                                                                                                                                                          } ?>">
                                </div>
                                <?php if ($error_name[$language['language_id']]) { ?>
                                    <div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
                                <?php } ?>
                            </div>
                        <?php }
                        foreach ($languages as $language) {
                        ?>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-address<?php echo $language['language_id']; ?>">
                                    <img src="/vars/lang/be/<?php echo $language['code']; ?>-<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                                    <span data-toggle="tooltip" data-container="#tab-general" title="<?php echo $entry_address; ?>"><?php echo $entry_address; ?></span>
                                </label>
                                <div class="col-sm-10">
                                    <textarea name="config_address<?php echo $language['language_id']; ?>" placeholder="<?php echo $entry_address; ?>" rows="5" id="input-address<?php echo $language['language_id']; ?>" class="form-control"><?php if (isset($config_address[$language['language_id']])) {
                                                                                                                                                                                                                                                    echo $config_address[$language['language_id']];
                                                                                                                                                                                                                                                } ?></textarea>
                                    <?php if ($error_address[$language['language_id']]) { ?>
                                        <div class="text-danger"><?php echo $error_address[$language['language_id']]; ?></div>
                                    <?php } ?>
                                </div>
                            </div>

                            <?php }
                        foreach ($languages as $language) {
                        ?>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="config-f-description<?php echo $language['language_id']; ?>">
                                    <img src="/vars/lang/be/<?php echo $language['code']; ?>-<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                                    <span data-toggle="tooltip" data-container="#tab-general" title="<?php echo $entry_footer_description; ?>"><?php echo $entry_footer_description; ?></span>
                                </label>
                                <div class="col-sm-10">
                                    <textarea name="config_f_description<?php echo $language['language_id']; ?>" placeholder="<?php echo $entry_footer_description; ?>" rows="5" id="config-f-description<?php echo $language['language_id']; ?>" class="form-control"><?php if (isset($config_f_description[$language['language_id']])) {
                                                                                                                                                                                                                                                    echo $config_f_description[$language['language_id']];
                                                                                                                                                                                                                               } ?></textarea>
                                    <?php if ($error_f_description[$language['language_id']]) { ?>
                                        <div class="text-danger"><?php echo $error_f_description[$language['language_id']]; ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="form-group required">
                            <label class="col-sm-2 control-label"
                                for="input-address-location"><?php echo $entry_address_location; ?></label>
                            <div class="col-sm-10">
                                <input type="text" name="config_address_location" value="<?php echo $config_address_location; ?>"
                                    placeholder="<?php echo $entry_address_location; ?>" id="input-address-location"
                                    class="form-control" />
                                    <?php if ($error_address_location) { ?>
                                <div class="text-danger"><?php echo $error_address_location; ?></div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-sm-2 control-label"
                                for="input-whatsapp"><?php echo $entry_whatsapp; ?></label>
                            <div class="col-sm-10">
                                <input type="text" name="config_whatsapp" value="<?php echo $config_whatsapp; ?>"
                                    placeholder="<?php echo $entry_whatsapp; ?>" id="input-whatsapp"
                                    class="form-control" />
                                    <?php if ($error_whatsapp) { ?>
                                <div class="text-danger"><?php echo $error_whatsapp; ?></div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-sm-2 control-label"
                                for="input-telephone"><?php echo $entry_telephone; ?></label>
                            <div class="col-sm-10">
                                <input type="text" name="config_telephone" value="<?php echo $config_telephone; ?>"
                                    placeholder="<?php echo $entry_telephone; ?>" id="input-telephone"
                                    class="form-control" />
                                <?php if ($error_telephone) { ?>
                                <div class="text-danger"><?php echo $error_telephone; ?></div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
                            <div class="col-sm-10">
                                <input type="text" name="config_email" value="<?php echo $config_email; ?>"
                                    placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
                                <?php if ($error_email) { ?>
                                <div class="text-danger"><?php echo $error_email; ?></div>
                                <?php } ?>
                            </div>
                        </div>
                      <div class="form-group required" bis_skin_checked="1">
                        <label class="col-sm-2 control-label" for="input-email-careers">Career Enquiry Email</label>
                        <div class="col-sm-10" bis_skin_checked="1">
                            <input type="text" name="config_email_careers" value="<?php echo $config_email_careers; ?>" placeholder="Enter email for careers enquiries" id="input-email-careers" class="form-control">
                            <?php if ($error_careers_email) { ?>
                                <div class="text-danger"><?php echo $error_careers_email; ?></div>
                           <?php } ?>
                        </div>
                      </div>
                       <h3>Consumer Electronics</h3>

                        <?php
                        $ce_fields = ['facebook', 'twitter', 'linkedin', 'instagram', 'youtube'];
                        foreach ($ce_fields as $field) {
                            $config_var = "config_ce_" . $field;
                            $error_var = "error_ce_" . $field;
                            $input_id = "input-ce-" . $field;
                            echo '<div class="form-group required">
                                    <label class="col-sm-2 control-label" for="' . $input_id . '">' . ${"entry_" . $field} . '</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="' . $config_var . '" value="' . ${$config_var} . '" placeholder="' . ${"entry_" . $field} . '" id="' . $input_id . '" class="form-control" />
                                        ' . (!empty(${$error_var}) ? '<div class="text-danger">' . ${$error_var} . '</div>' : '') . '
                                    </div>
                                </div>';
                        }
                        ?>
                        <h3>Business Solutions</h3>

                        <?php
                        $bs_fields = ['facebook', 'twitter', 'linkedin', 'youtube'];
                        foreach ($bs_fields as $field) {
                            $config_var = "config_bs_" . $field;
                            $error_var = "error_bs_" . $field;
                            $input_id = "input-bs-" . $field;
                            echo '<div class="form-group required">
                                    <label class="col-sm-2 control-label" for="' . $input_id . '">' . ${"entry_" . $field} . '</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="' . $config_var . '" value="' . ${$config_var} . '" placeholder="' . ${"entry_" . $field} . '" id="' . $input_id . '" class="form-control" />
                                        ' . (!empty(${$error_var}) ? '<div class="text-danger">' . ${$error_var} . '</div>' : '') . '
                                    </div>
                                </div>';
                        }
                        ?>

                        <!-- <div class="form-group required">
                            <label class="col-sm-2 control-label" for="input-map"><?php echo $entry_map; ?></label>
                            <div class="col-sm-10">
                                <textarea name="config_map" placeholder="<?php echo $entry_map; ?>" rows="5"
                                    id="input-map" class="form-control"><?php echo $config_map; ?></textarea>
                                    <?php if ($error_map) { ?>
                                <div class="text-danger"><?php echo $error_map; ?></div>
                                <?php } ?>
                            </div>
                        </div> -->

                        <div class="form-group">
                            <label class="col-sm-6 control-label"
                                for="input-config-limit"><?php echo $help_limit_admin; ?></label>
                            <div class="col-sm-10">
                                <input type="text" name="config_limit_admin" value="<?php echo $config_limit_admin; ?>"
                                    placeholder="<?php echo $help_limit_admin; ?>" id="input-config-limit"
                                    class="form-control" />
                            </div>
                        </div>
      
                        <div class="row">
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="config_mapimage">Location Image (639×744px)</label>
                                <div class="col-md-6">
                                    <input onchange="loadFile(event,'flogo')" type="file" name="config_mapimage"
                                        id="config_mapimage" accept=".png,.jpg,.jpeg,.svg">
                                        <?php if ($error_locmap) { ?>
                                <div class="text-danger"><?php echo $error_locmap; ?></div>
                                <?php } ?>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 ">
                                <?php if ($config_mapimage) { ?>
                                <img id="flogo" src="../uploads/image/setting/<?= $config_mapimage ?>"
                                    style="width: 100%; height: 89px;margin-top: 12px;">
                                <?php } ?>
                            </div>
                        </div>


                    </div>
                    <div class="tab-pane" id="tab-meta">

                    <?php foreach ($languages as $language) { ?>
                        <div class="form-group required">
                            <label class="col-sm-2 control-label" for="input-meta-title<?php echo $language['language_id']; ?>">
                                <img src="/vars/lang/be/<?php echo $language['code']; ?>-<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                                <span data-toggle="tooltip" title="<?php echo $entry_meta_title; ?>"><?php echo $entry_meta_title; ?></span>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" name="config_meta_title<?php echo $language['language_id']; ?>" value="<?php if (isset($config_meta_title[$language['language_id']])) {
                                                                                                                                echo $config_meta_title[$language['language_id']];
                                                                                                                            } ?>" placeholder="<?php echo $entry_meta_title; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
                                <?php if ($error_meta_title[$language['language_id']]) { ?>
                                    <div class="text-danger"><?php echo $error_meta_title[$language['language_id']]; ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php }
                    foreach ($languages as $language) {
                    ?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="input-meta-description<?php echo $language['language_id']; ?>">
                                <img src="/vars/lang/be/<?php echo $language['code']; ?>-<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                                <span data-toggle="tooltip" title="<?php echo $entry_meta_description; ?>"><?php echo $entry_meta_description; ?></span>
                            </label>
                            <div class="col-sm-10">
                                <textarea name="config_meta_description<?php echo $language['language_id']; ?>" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php if (isset($config_meta_description[$language['language_id']])) {
                                                                                                                                                                                                                                                                            echo $config_meta_description[$language['language_id']];
                                                                                                                                                                                                                                                                        } ?></textarea>
                            </div>
                        </div>
                    <?php }
                    foreach ($languages as $language) {
                    ?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="input-meta-keyword<?php echo $language['language_id']; ?>">
                                <img src="/vars/lang/be/<?php echo $language['code']; ?>-<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                                <span data-toggle="tooltip" title="<?php echo $entry_meta_keyword; ?>"><?php echo $entry_meta_keyword; ?></span>
                            </label>
                            <div class="col-sm-10">
                                <textarea name="config_meta_keyword<?php echo $language['language_id']; ?>" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php if (isset($config_meta_keyword[$language['language_id']])) {
                                                                                                                                                                                                                                                                echo $config_meta_keyword[$language['language_id']];
                                                                                                                                                                                                                                                            } ?></textarea>
                            </div>
                        </div>


                    <?php } ?>
                    </div>
                    <div class="tab-pane" id="tab-ftp">
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                for="input-ftp-host"><?php echo $entry_ftp_hostname; ?></label>
                            <div class="col-sm-10">
                                <input type="text" name="config_ftp_hostname"
                                    value="<?php echo $config_ftp_hostname; ?>"
                                    placeholder="<?php echo $entry_ftp_hostname; ?>" id="input-ftp-host"
                                    class="form-control" />
                                <?php if ($error_ftp_hostname) { ?>
                                <div class="text-danger"><?php echo $error_ftp_hostname; ?></div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                for="input-ftp-port"><?php echo $entry_ftp_port; ?></label>
                            <div class="col-sm-10">
                                <input type="text" name="config_ftp_port" value="<?php echo $config_ftp_port; ?>"
                                    placeholder="<?php echo $entry_ftp_port; ?>" id="input-ftp-port"
                                    class="form-control" />
                                <?php if ($error_ftp_port) { ?>
                                <div class="text-danger"><?php echo $error_ftp_port; ?></div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                for="input-ftp-username"><?php echo $entry_ftp_username; ?></label>
                            <div class="col-sm-10">
                                <input type="text" name="config_ftp_username"
                                    value="<?php echo $config_ftp_username; ?>"
                                    placeholder="<?php echo $entry_ftp_username; ?>" id="input-ftp-username"
                                    class="form-control" />
                                <?php if ($error_ftp_username) { ?>
                                <div class="text-danger"><?php echo $error_ftp_username; ?></div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                for="input-ftp-password"><?php echo $entry_ftp_password; ?></label>
                            <div class="col-sm-10">
                                <input type="text" name="config_ftp_password"
                                    value="<?php echo $config_ftp_password; ?>"
                                    placeholder="<?php echo $entry_ftp_password; ?>" id="input-ftp-password"
                                    class="form-control" />
                                <?php if ($error_ftp_password) { ?>
                                <div class="text-danger"><?php echo $error_ftp_password; ?></div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="input-ftp-root"><span data-toggle="tooltip"
                                    data-html="true"
                                    title="<?php echo htmlspecialchars($help_ftp_root); ?>"><?php echo $entry_ftp_root; ?></span></label>
                            <div class="col-sm-10">
                                <input type="text" name="config_ftp_root" value="<?php echo $config_ftp_root; ?>"
                                    placeholder="<?php echo $entry_ftp_root; ?>" id="input-ftp-root"
                                    class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><?php echo $entry_ftp_status; ?></label>
                            <div class="col-sm-10">
                                <label class="radio-inline">
                                    <?php if ($config_ftp_status) { ?>
                                    <input type="radio" name="config_ftp_status" value="1" checked="checked" />
                                    <?php echo $text_yes; ?>
                                    <?php } else { ?>
                                    <input type="radio" name="config_ftp_status" value="1" />
                                    <?php echo $text_yes; ?>
                                    <?php } ?>
                                </label>
                                <label class="radio-inline">
                                    <?php if (!$config_ftp_status) { ?>
                                    <input type="radio" name="config_ftp_status" value="0" checked="checked" />
                                    <?php echo $text_no; ?>
                                    <?php } else { ?>
                                    <input type="radio" name="config_ftp_status" value="0" />
                                    <?php echo $text_no; ?>
                                    <?php } ?>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab-mail">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="input-mail-protocol"><span data-toggle="tooltip"
                                    title="<?php echo $help_mail_protocol; ?>"><?php echo $entry_mail_protocol; ?></span></label>
                            <div class="col-sm-10">
                                <select name="config_mail_protocol" id="input-mail-protocol" class="form-control">
                                    <?php if ($config_mail_protocol == 'mail') { ?>
                                    <option value="mail" selected="selected"><?php echo $text_mail; ?></option>
                                    <?php } else { ?>
                                    <option value="mail"><?php echo $text_mail; ?></option>
                                    <?php } ?>
                                    <?php if ($config_mail_protocol == 'smtp') { ?>
                                    <option value="smtp" selected="selected"><?php echo $text_smtp; ?></option>
                                    <?php } else { ?>
                                    <option value="smtp"><?php echo $text_smtp; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="input-mail-parameter"><span data-toggle="tooltip"
                                    title="<?php echo $help_mail_parameter; ?>"><?php echo $entry_mail_parameter; ?></span></label>
                            <div class="col-sm-10">
                                <input type="text" name="config_mail_parameter"
                                    value="<?php echo $config_mail_parameter; ?>"
                                    placeholder="<?php echo $entry_mail_parameter; ?>" id="input-mail-parameter"
                                    class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="input-mail-smtp-hostname"><span
                                    data-toggle="tooltip"
                                    title="<?php echo $help_mail_smtp_hostname; ?>"><?php echo $entry_mail_smtp_hostname; ?></span></label>
                            <div class="col-sm-10">
                                <input type="text" name="config_mail_smtp_hostname"
                                    value="<?php echo $config_mail_smtp_hostname; ?>"
                                    placeholder="<?php echo $entry_mail_smtp_hostname; ?>" id="input-mail-smtp-hostname"
                                    class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                for="input-mail-smtp-username"><?php echo $entry_mail_smtp_username; ?></label>
                            <div class="col-sm-10">
                                <input type="text" name="config_mail_smtp_username"
                                    value="<?php echo $config_mail_smtp_username; ?>"
                                    placeholder="<?php echo $entry_mail_smtp_username; ?>" id="input-mail-smtp-username"
                                    class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                for="input-mail-smtp-password"><?php echo $entry_mail_smtp_password; ?></label>
                            <div class="col-sm-10">
                                <input type="text" name="config_mail_smtp_password"
                                    value="<?php echo $config_mail_smtp_password; ?>"
                                    placeholder="<?php echo $entry_mail_smtp_password; ?>" id="input-mail-smtp-password"
                                    class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                for="input-mail-smtp-port"><?php echo $entry_mail_smtp_port; ?></label>
                            <div class="col-sm-10">
                                <input type="text" name="config_mail_smtp_port"
                                    value="<?php echo $config_mail_smtp_port; ?>"
                                    placeholder="<?php echo $entry_mail_smtp_port; ?>" id="input-mail-smtp-port"
                                    class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                for="input-mail-smtp-timeout"><?php echo $entry_mail_smtp_timeout; ?></label>
                            <div class="col-sm-10">
                                <input type="text" name="config_mail_smtp_timeout"
                                    value="<?php echo $config_mail_smtp_timeout; ?>"
                                    placeholder="<?php echo $entry_mail_smtp_timeout; ?>" id="input-mail-smtp-timeout"
                                    class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="input-alert-email"><span data-toggle="tooltip"
                                    title="<?php echo $help_mail_alert; ?>"><?php echo $entry_mail_alert; ?></span></label>
                            <div class="col-sm-10">
                                <textarea name="config_mail_alert" rows="5"
                                    placeholder="<?php echo $entry_mail_alert; ?>" id="input-alert-email"
                                    class="form-control"><?php echo $config_mail_alert; ?></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label>Mail Logo</label>
                                <div class="form-group">
                                    <input onchange="loadFile(event,'maillogo')" type="file" name="config_email_logo"
                                        id="config_email_logo" accept=".png,.jpg,.jpeg">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 ">
                                <?php if ($config_email_logo) { ?>
                                <img id="maillogo" src="../uploads/image/setting/<?= $config_email_logo ?>"
                                    style="width: 100%; height: 89px;margin-top: 12px;">
                                <?php } else { ?>
                                <img id="maillogo" src="" style="height: 89px;margin-top: 12px;">
                                <?php } ?>
                            </div>
                        </div>


                    </div>
                    <div class="tab-pane" id="tab-server">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="input-file-max-size"><span data-toggle="tooltip"
                                    title="<?php echo $help_file_max_size; ?>"><?php echo $entry_file_max_size; ?></span></label>
                            <div class="col-sm-10">
                                <input type="text" name="config_file_max_size"
                                    value="<?php echo $config_file_max_size; ?>"
                                    placeholder="<?php echo $entry_file_max_size; ?>" id="input-file-max-size"
                                    class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="input-file-ext-allowed"><span
                                    data-toggle="tooltip"
                                    title="<?php echo $help_file_ext_allowed; ?>"><?php echo $entry_file_ext_allowed; ?></span></label>
                            <div class="col-sm-10">
                                <textarea name="config_file_ext_allowed" rows="5"
                                    placeholder="<?php echo $entry_file_ext_allowed; ?>" id="input-file-ext-allowed"
                                    class="form-control"><?php echo $config_file_ext_allowed; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="input-file-mime-allowed"><span
                                    data-toggle="tooltip"
                                    title="<?php echo $help_file_mime_allowed; ?>"><?php echo $entry_file_mime_allowed; ?></span></label>
                            <div class="col-sm-10">
                                <textarea name="config_file_mime_allowed" cols="60" rows="5"
                                    placeholder="<?php echo $entry_file_mime_allowed; ?>" id="input-file-mime-allowed"
                                    class="form-control"><?php echo $config_file_mime_allowed; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><span data-toggle="tooltip"
                                    title="<?php echo $help_maintenance; ?>"><?php echo $entry_maintenance; ?></span></label>
                            <div class="col-sm-10">
                                <label class="radio-inline">
                                    <?php if ($config_maintenance) { ?>
                                    <input type="radio" name="config_maintenance" value="1" checked="checked" />
                                    <?php echo $text_yes; ?>
                                    <?php } else { ?>
                                    <input type="radio" name="config_maintenance" value="1" />
                                    <?php echo $text_yes; ?>
                                    <?php } ?>
                                </label>
                                <label class="radio-inline">
                                    <?php if (!$config_maintenance) { ?>
                                    <input type="radio" name="config_maintenance" value="0" checked="checked" />
                                    <?php echo $text_no; ?>
                                    <?php } else { ?>
                                    <input type="radio" name="config_maintenance" value="0" />
                                    <?php echo $text_no; ?>
                                    <?php } ?>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="input-encryption"><span data-toggle="tooltip"
                                    title="<?php echo $help_encryption; ?>"><?php echo $entry_encryption; ?></span></label>
                            <div class="col-sm-10">
                                <input type="text" name="config_encryption" value="<?php echo $config_encryption; ?>"
                                    placeholder="<?php echo $entry_encryption; ?>" id="input-encryption"
                                    class="form-control" />
                                <?php if ($error_encryption) { ?>
                                <div class="text-danger"><?php echo $error_encryption; ?></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab-google">
                        <fieldset>
                            <legend><?php echo $text_google_analytics; ?></legend>
                            <div class="alert alert-info"><?php echo $help_google_analytics; ?></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"
                                    for="input-google-analytics"><?php echo $entry_google_analytics; ?></label>
                                <div class="col-sm-10">
                                    <textarea name="config_google_analytics" rows="5"
                                        placeholder="<?php echo $entry_google_analytics; ?>" id="input-google-analytics"
                                        class="form-control"><?php echo $config_google_analytics; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"
                                    for="input-google-analytics-status"><?php echo $entry_status; ?></label>
                                <div class="col-sm-10">
                                    <select name="config_google_analytics_status" id="input-google-analytics-status"
                                        class="form-control">
                                        <?php if ($config_google_analytics_status) { ?>
                                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                        <option value="0"><?php echo $text_disabled; ?></option>
                                        <?php } else { ?>
                                        <option value="1"><?php echo $text_enabled; ?></option>
                                        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend><?php echo $text_google_captcha; ?></legend>
                            <div class="alert alert-info"><?php echo $help_google_captcha; ?></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"
                                    for="input-google-captcha-public"><?php echo $entry_google_captcha_public; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="config_google_captcha_public"
                                        value="<?php echo $config_google_captcha_public; ?>"
                                        placeholder="<?php echo $entry_google_captcha_public; ?>"
                                        id="input-google-captcha-public" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"
                                    for="input-google-captcha-secret"><?php echo $entry_google_captcha_secret; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="config_google_captcha_secret"
                                        value="<?php echo $config_google_captcha_secret; ?>"
                                        placeholder="<?php echo $entry_google_captcha_secret; ?>"
                                        id="input-google-captcha-secret" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"
                                    for="input-google-captcha-status"><?php echo $entry_status; ?></label>
                                <div class="col-sm-10">
                                    <select name="config_google_captcha_status" id="input-google-captcha-status"
                                        class="form-control">
                                        <?php if ($config_google_captcha_status) { ?>
                                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                        <option value="0"><?php echo $text_disabled; ?></option>
                                        <?php } else { ?>
                                        <option value="1"><?php echo $text_enabled; ?></option>
                                        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </fieldset>


                    <!-- <fieldset>
                        <legend>Instagram </legend>
                            <div class="alert alert-info">Go to Instagram page Go to Instagram page <a href="https://www.instagram.com">www.instagram.com</a></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"
                                    for="input-config-instagram-url">Instagram URL</label>
                                <div class="col-sm-10">
                                    <input type="text" name="config_instagram_url"
                                        value="<?php echo $config_instagram_url; ?>"
                                        placeholder="Instagram URL"
                                        id="input-config-instagram-url" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"
                                    for="input-instagram-token">Instagram token</label>
                                <div class="col-sm-10">
                                    <input type="text" name="config_instagram_token"
                                        value="<?php echo $config_instagram_token; ?>"
                                        placeholder="Instagram token"
                                        id="input-instagram-token" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"
                                    for="input-instagram-handler-name">Instagram handler name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="config_instagram_handler_name"
                                        value="<?php echo $config_instagram_handler_name; ?>"
                                        placeholder="Instagram handler name"
                                        id="input-instagram-handler-name" class="form-control" />
                                </div>
                            </div>
                 
                        </fieldset> -->


                        

                        <fieldset>
                            <legend><?php echo "Google Map"; ?></legend>
                            <div class="alert alert-info">
                                <?php echo 'Access your Google Maps API by logging into your <a href="https://console.developers.google.com/" target="_blank">Google Developer Console</a>, then, after creating your project, simply copy and paste the provided API key into the designated field to enable map functionality on your website.'; ?>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"
                                    for="input-google-map"><?php echo 'Api Key'; ?></label>
                                <div class="col-sm-10">
                                    <input name="config_google_map_api_key"
                                        value="<?php echo $config_google_map_api_key; ?>"
                                        placeholder="<?php echo "Api Key"; ?>" id="input-google-map"
                                        class="form-control">
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="tab-pane" id="tab-misc">
                        <div class="row">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="config_favicon">Fav Icon (32 x 32px)</label>
                                <div class="col-md-6">
                                    <input onchange="loadFile(event,'favicon')" type="file" name="config_favicon"
                                        id="config_favicon" accept=".png,.jpg,.jpeg,.gif,.svg">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 ">
                                <?php if ($config_favicon) { ?>
                                <img id="favicon" src="../uploads/image/setting/<?= $config_favicon ?>"
                                    style="width: 100%; height: 89px;margin-top: 12px;">
                                <?php }  ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="config_hlogo">Header Logo (165 x 45px)</label>
                                <div class="col-md-6">
                                    <input onchange="loadFile(event,'hlogo')" type="file" name="config_hlogo"
                                        id="config_hlogo" accept=".png,.jpg,.jpeg,.svg">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 ">
                                <?php if ($config_hlogo) { ?>
                                <img id="hlogo" src="../uploads/image/setting/<?= $config_hlogo ?>"
                                    style="width: 100%; height: 89px;margin-top: 12px;">
                                <?php } ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="config_flogo">Footer Logo (165 x 45px)</label>
                                <div class="col-md-6">
                                    <input onchange="loadFile(event,'flogo')" type="file" name="config_flogo"
                                        id="config_flogo" accept=".png,.jpg,.jpeg,.svg">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 ">
                                <?php if ($config_flogo) { ?>
                                <img id="flogo" src="../uploads/image/setting/<?= $config_flogo ?>"
                                    style="width: 100%; height: 89px;margin-top: 12px;">
                                <?php } ?>
                            </div>
                        </div>
                        
                        <!-- <fieldset>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-priceunit">Price Unit</label>
                                <div class="col-sm-10">
                                    <input name="config_priceunit" id="input-config_priceunit" placeholder="Price Unit"
                                        class="form-control" value="<?php echo $config_priceunit; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-currency">Currency</label>
                                <div class="col-sm-10">
                                    <input name="config_currency" id="input-config_currency" placeholder="Currency"
                                        class="form-control" value="<?php echo $config_currency; ?>">
                                </div>
                            </div>
                        </fieldset> -->
                    </div>
                    <div class="tab-pane" id="tab-payment">

                        <legend>Stripe Settings</legend>
                        <hr />
                        <br>
                        <div class="form-group required">
                            <label class="col-sm-2 control-label" for="input-config_payment_stripe_environment"><span
                                    data-toggle="tooltip" title=""
                                    data-bs-original-title="Please choose an environment. Test for Testing (Sandbox) account and Live for Production account">Environment</span></label>
                            <div class="col-sm-10">
                                <select name="config_payment_stripe_environment" class="form-control"
                                    id="config_payment_stripe_environment">
                                    <option value="test" <?php if ($config_payment_stripe_environment == 'test') { ?>
                                        selected="selected" <?php  } ?>>Test (Sandbox)</option>
                                    <option value="live" <?php if ($config_payment_stripe_environment == 'live') { ?>
                                        selected="selected" <?php  } ?>>Live (Production)</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group required">
                            <label class="col-sm-2 control-label" for="input-config_payment_stripe_test_public_key">
                                <span data-toggle="tooltip" title=""
                                    data-bs-original-title="Public Key for Sandbox Accuont">Test Public
                                    Key</span></label>
                            <div class="col-sm-10">
                                <input type="text" name="config_payment_stripe_test_public_key"
                                    id="config_payment_stripe_test_public_key"
                                    value="<?php echo $config_payment_stripe_test_public_key; ?>"
                                    class="form-control" />
                            </div>
                            <?php if ($error_payment_stripe_test_public_key) { ?>
                            <div class="text-danger"><?php echo $error_payment_stripe_test_public_key; ?></div>
                            <?php } ?>
                        </div>

                        <div class="form-group required">
                            <label class="col-sm-2 control-label" for="config_payment_stripe_test_secret_key">
                                <span data-toggle="tooltip" title=""
                                    data-original-title="Secret Key for Sandbox Accuont">Test Secret Key</span>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" name="config_payment_stripe_test_secret_key"
                                    id="config_payment_stripe_test_secret_key"
                                    value="<?php echo $config_payment_stripe_test_secret_key; ?>"
                                    class="form-control" />
                            </div>
                            <?php if ($error_payment_stripe_test_secret_key) { ?>
                            <div class="text-danger"><?php echo $error_payment_stripe_test_secret_key; ?></div>
                            <?php } ?>
                        </div>

                        <div class="form-group required">
                            <label class="col-sm-2 control-label" for="config_payment_stripe_live_public_key">
                                <span data-toggle="tooltip" title=""
                                    data-original-title="Public Key for Production Accuont">Live Public Key</span>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" name="config_payment_stripe_live_public_key"
                                    id="config_payment_stripe_live_public_key"
                                    value="<?php echo $config_payment_stripe_live_public_key; ?>"
                                    class="form-control" />
                            </div>
                            <?php if ($error_payment_stripe_live_public_key) { ?>
                            <div class="text-danger"><?php echo $error_payment_stripe_live_public_key; ?></div>
                            <?php } ?>
                        </div>

                        <div class="form-group required">
                            <label class="control-label col-sm-2" for="config_payment_stripe_live_secret_key">
                                <span data-toggle="tooltip" title=""
                                    data-original-title="Secret Key for Production Accuont">Live Secret Key</span>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" name="config_payment_stripe_live_secret_key"
                                    id="config_payment_stripe_live_secret_key"
                                    value="<?php echo $config_payment_stripe_live_secret_key; ?>"
                                    class="form-control" />

                            </div>
                            <?php if ($error_payment_stripe_live_secret_key) { ?>
                            <div class="text-danger"><?php echo $error_payment_stripe_live_secret_key; ?></div>
                            <?php } ?>
                        </div>

                        <div class="form-group required">
                            <label class="control-label col-sm-2" for="config_payment_stripe_status">
                                <span data-toggle="tooltip" title=""
                                    data-original-title="Enable this to accept payment using Stripe">Status</span>
                            </label>
                            <div class="col-sm-10">
                                <select name="config_payment_stripe_status" class="form-control"
                                    id="config_payment_stripe_status">
                                    <option value="1" <?php if ($config_payment_stripe_status == '1') { ?>
                                        selected="selected" <?php  } ?>>Enabled</option>
                                    <option value="0" <?php if ($config_payment_stripe_status == '0') { ?>
                                        selected="selected" <?php  } ?>>Disabled</option>
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

<script type="text/javascript">
$('select[name=\'config_template\']').on('change', function() {
    $.ajax({
        url: '<?php echo $settingUrl; ?>/template&token=<?php echo $token; ?>&template=' +
            encodeURIComponent(this.value),
        dataType: 'html',
        beforeSend: function() {
            $('select[name=\'country_id\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
        },
        complete: function() {
            $('.fa-spin').remove();
        },
        success: function(html) {
            $('#template').attr('src', html);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});

$('select[name=\'config_template\']').trigger('change');
//
</script>
<script type="text/javascript">
$('select[name=\'config_country_id\']').on('change', function() {
    $.ajax({
        url: '<?php echo $settingUrl; ?>/country&token=<?php echo $token; ?>&country_id=' + this.value,
        dataType: 'json',
        beforeSend: function() {
            $('select[name=\'config_country_id\']').after(
                ' <i class="fa fa-circle-o-notch fa-spin"></i>');
        },
        complete: function() {
            $('.fa-spin').remove();
        },
        success: function(json) {
            html = '<option value=""><?php echo $text_select; ?></option>';

            if (json['zone'] && json['zone'] != '') {
                for (i = 0; i < json['zone'].length; i++) {
                    html += '<option value="' + json['zone'][i]['zone_id'] + '"';

                    if (json['zone'][i]['zone_id'] == '<?php echo $config_zone_id; ?>') {
                        html += ' selected="selected"';
                    }

                    html += '>' + json['zone'][i]['name'] + '</option>';
                }
            } else {
                html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
            }

            $('select[name=\'config_zone_id\']').html(html);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});

$('select[name=\'config_country_id\']').trigger('change');
//
</script>
</div>
<?php echo $footer; ?>

<script type="text/javascript">
var loadFile = function(event, id) {
    var output = document.getElementById(id);
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
        URL.revokeObjectURL(output.src); // free memory
    };
};
</script>