<style>
  .select-all,
  .unselect-all {
    color: #007bff;
    /* A pleasant shade of blue */
    text-decoration: none;
    /* Removes underline */
    font-weight: bold;
    /* Makes text bold */
    padding: 8px 12px;
    /* Adds some padding around the text */
    border-radius: 5px;
    /* Rounds the corners */
    transition: color 0.3s;
    /* Smooth color transition for hover effect */
  }

  .select-all:hover,
  .unselect-all:hover {
    color: #0056b3;
    cursor: pointer;
  }

  .select-all,
  .unselect-all {
    background-color: #f8f9fa;
    margin: 5px;
  }

  .select-all:hover,
  .unselect-all:hover {
    background-color: #e2e6ea;
  }

  .panel.panel-default {
    background: #1ab4fd2b !important;
  }
</style>
<?php echo $header; ?>
<div class="main-panel">
  <div class="sec-head">
    <div class="sec-head-title">
      <h3><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
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
          <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
          </div>
        <?php } ?>
      </div>

    </div>

    <div class="panel panel-default">
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-user-group" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $aur_entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $aur_entry_name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
                <div class="text-danger"><?php echo $error_name; ?></div>
              <?php  } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $aur_entry_access; ?></label>
            <div class="col-sm-10">
              <div class="well well-sm" style="height: 150px; overflow: auto;">
                <?php foreach ($permissions as $permission) { ?>
                  <div class="checkbox">
                    <label>
                      <?php if (in_array($permission, $access)) { ?>
                        <input type="checkbox" name="permission[access][]" value="<?php echo $permission; ?>" checked="checked" />
                        <?php echo $permission; ?>
                      <?php } else { ?>
                        <input type="checkbox" name="permission[access][]" value="<?php echo $permission; ?>" />
                        <?php echo $permission; ?>
                      <?php } ?>
                    </label>
                  </div>
                <?php } ?>
              </div>
              <br>
              <br>
              <br>

              <a class="select-all" onclick="$(this).parent().find(':checkbox').prop('checked', true);">
                <i class="fa fa-check-square"></i> <?php echo $text_select_all; ?>
              </a> /
              <a class="unselect-all" onclick="$(this).parent().find(':checkbox').prop('checked', false);">
                <i class="fa fa-square"></i> <?php echo $text_unselect_all; ?>
              </a>
            </div>

          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $aur_entry_modify; ?></label>
            <div class="col-sm-10">
              <div class="well well-sm" style="height: 150px; overflow: auto;">
                <?php foreach ($permissions as $permission) { ?>
                  <div class="checkbox">
                    <label>
                      <?php if (in_array($permission, $modify)) { ?>
                        <input type="checkbox" name="permission[modify][]" value="<?php echo $permission; ?>" checked="checked" />
                        <?php echo $permission; ?>
                      <?php } else { ?>
                        <input type="checkbox" name="permission[modify][]" value="<?php echo $permission; ?>" />
                        <?php echo $permission; ?>
                      <?php } ?>
                    </label>
                  </div>
                <?php } ?>
              </div>
              <br>
              <br>
              <br>
              <a class="select-all" onclick="$(this).parent().find(':checkbox').prop('checked', true);">
                <i class="fa fa-check-square"></i> <?php echo $text_select_all; ?>
              </a> /
              <a class="unselect-all" onclick="$(this).parent().find(':checkbox').prop('checked', false);">
                <i class="fa fa-square"></i> <?php echo $text_unselect_all; ?>
              </a>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>



<?php echo $footer; ?>