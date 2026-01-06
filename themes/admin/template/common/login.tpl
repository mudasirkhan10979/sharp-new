<?php
echo $header; ?>
<style>
  .panel {
    background-color: rgba(0, 0, 0, 0.8) !important;
    /* Semi-transparent dark background */
    border: none !important;
    border-radius: 10px !important;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
  }

  .panel-heading {
    background-color: transparent !important;
    border-bottom: none !important;
    padding: 20px !important;
  }

  .panel-title {
    font-size: 1.5em !important;
    margin-top: 10px !important;
    color: #ecf0f1 !important;
  }

  .logo {
    width: 80px !important;
    height: auto !important;
    margin-bottom: 10px !important;
  }

  .input-group-addon {
    background-color: rgba(255, 255, 255, 0.2) !important;
    border: none !important;
    color: #ecf0f1 !important;
  }

  .form-control {
    background-color: rgba(255, 255, 255, 0.1) !important;
    border: none !important;
    color: #ecf0f1 !important;
  }

  .form-control:focus {
    background-color: rgba(255, 255, 255, 0.1) !important;
    color: #ecf0f1 !important;
    box-shadow: none !important;
  }

  .btn-primary {
    background-color: #e74c3c !important;
    border: none !important;
  }

  .btn-primary:hover {
    background-color: #c0392b !important;
  }

  .alert-success {
    background-color: #27ae60;
    border: none;
    color: #ecf0f1;
  }

  .alert-danger {
    background-color: #e74c3c;
    border: none;
    color: #ecf0f1;
  }

  .alert .close {
    color: #ecf0f1;
  }

  .rightcontent {
    background-color: transparent !important;
  }

  .container-scroller.home {
    /* background: url(/themes/admin/images/login-background.webp) no-repeat fixed center; */
    background-color: #25262C;
  }
</style>

<div id="content" class="contentLogin">
  <div class="container-fluid"><br /><br />
    <div class="row">
      <div class="col-sm-offset-4 col-sm-4">
        <!-- <div class="panel panel-default" style="background-color:#394d37  !important"> -->
         <div class="panel panel-default" style="background-color:#000000  !important">
          <div class="panel-heading text-center">
            <img src="/themes/admin/images/cmsloginlogo.png" alt="Al othaim investment" class="logo">
            <h1 class="panel-title"><i class="fa fa-lock"></i> <?php echo $text_login; ?></h1>
          </div>
          <div class="panel-body">
            <?php if ($success) { ?>
              <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
              </div>
            <?php } ?>
            <?php if ($error_warning) { ?>
              <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
              </div>
            <?php } ?>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label for="input-username"><?php echo $entry_username; ?></label>
                <div class="input-group"><span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="text" name="username" value="<?php echo $username; ?>" placeholder="<?php echo $entry_username; ?>" id="input-username" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label for="input-password"><?php echo $entry_password; ?></label>
                <div class="input-group"><span class="input-group-addon"><i class="fa fa-lock"></i></span>
                  <input type="password" name="password" value="<?php echo $password; ?>" placeholder="<?php echo $entry_password; ?>" id="input-password" class="form-control" />
                </div>
                <?php if ($forgotten) { ?>
                  <span class="help-block"><a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a></span>
                <?php } ?>
              </div>
              <div class="text-right">
                <button type="submit" class="btn btn-primary"><i class="fa fa-key"></i> <?php echo $button_login; ?></button>
              </div>
              <?php if ($redirect) { ?>
                <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
              <?php } ?>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>