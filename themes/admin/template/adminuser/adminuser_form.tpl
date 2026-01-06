<?php echo $header;
?>
<script>
  $('.heading').html('<? echo $breadcrumbs[0]["text"]; ?>');
</script>
<div class="main-panel">
  <div class="sec-head">
    <div class="sec-head-title">
      <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
    </div>
    <div class="sec-head-btns">
      <?php if (!$viewer) { ?>
        <button type="submit" form="form-customer" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
      <?php } ?>
      <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-primary"><i class="fa fa-reply"></i></a>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-11">
      <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
      <?php } ?>

    </div>
  </div>

  <div class="main-employee-box">

    <div class="row">
      <div class="col-lg-12 col-md-12">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-user" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-username"><?php echo $au_entry_username; ?></label>
            <div class="col-sm-10">
              <input autocomplete="off" type="text" name="username" value="<?php echo $username; ?>" placeholder="<?php echo $au_entry_username; ?>" id="input-username" class="form-control" />
              <?php if ($error_username) { ?>
                <div class="text-danger"><?php echo $error_username; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-user-group">Role</label>
            <div class="col-sm-10">
              <select name="user_group_id" id="input-user-group" class="form-control">
                <?php foreach ($user_groups as $user_group) { ?>
                  <?php if ($user_group['user_group_id'] == $user_group_id) { ?>
                    <option value="<?php echo $user_group['user_group_id']; ?>" selected="selected"><?php echo $user_group['name']; ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $user_group['user_group_id']; ?>"><?php echo $user_group['name']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-fullname"><?php echo $au_entry_fullname; ?></label>
            <div class="col-sm-10">
              <input autocomplete="off" type="text" name="fullname" value="<?php echo $fullname; ?>" placeholder="<?php echo $au_entry_fullname; ?>" id="input-fullname" class="form-control" />
              <?php if ($error_fullname) { ?>
                <div class="text-danger"><?php echo $error_fullname; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-email"><?php echo $au_entry_email; ?></label>
            <div class="col-sm-10">
              <input autocomplete="off" type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $au_entry_email; ?>" id="input-email" class="form-control" />
              <?php if ($error_email) { ?>
                <div class="text-danger"><?php echo $error_email; ?></div>
              <?php  } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-password"><?php echo $au_entry_password; ?></label>
            <div class="col-sm-10">
              <input autocomplete="off" type="password" name="password" value="<?php echo $password; ?>" placeholder="<?php echo $au_entry_password; ?>" id="input-password" class="form-control" autocomplete="off" />
              <?php if ($error_password) { ?>
                <div class="text-danger"><?php echo $error_password; ?></div>
              <?php  } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-confirm"><?php echo $au_entry_confirm; ?></label>
            <div class="col-sm-10">
              <input autocomplete="off" type="password" name="confirm" value="<?php echo $confirm; ?>" placeholder="<?php echo $au_entry_confirm; ?>" id="input-confirm" class="form-control" />
              <?php if ($error_confirm) { ?>
                <div class="text-danger"><?php echo $error_confirm; ?></div>
              <?php  } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $au_entry_status; ?></label>
            <div class="col-sm-10">
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
<?php echo $footer; ?>