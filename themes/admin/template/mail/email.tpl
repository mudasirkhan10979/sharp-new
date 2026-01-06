<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Status</title>
  <style>
    /* Reset some default styles for email clients */
    body,
    p,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    td {
      margin: 0;
      padding: 0;
    }

    body {
      font-family: Arial, sans-serif;
      line-height: 1.6;
    }

    table {
      border-collapse: collapse;
      mso-table-lspace: 0pt;
      mso-table-rspace: 0pt;
    }

    td {
      vertical-align: top;
    }

    /* Responsive styles */
    @media screen and (max-width: 600px) {
      table[class="container"] {
        width: 100% !important;
        max-width: 100% !important;
      }

      div[class="email-container"] {
        max-width: 540px !important;
      }

      ul[class="navigation"] {
        padding: 0px;
      }

    }

    @media screen and (max-width: 480px) {
      a[class="btn-11"] {
        margin-bottom: 20px !important;
      }

      div[class="logo-div"] {
        width: 30% !important;
      }

      div[class="logo-div"] img {
        width: 100% !important;
      }

      ul[class="navigation"] {
        width: 70% !important;
        top: 0px !important;
      }

      div[class="table-wrapper"] {
        padding: 0px 20px 50px !important;
      }

      table[class="top-sec-tem"] td {
        padding: 50px 10px 30px !important;
      }

      table[class="footer-tem-table"] tr {
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
      }

      table[class="footer-tem-table"] td {
        padding: 0px 20px 20px !important;
      }

      h1[class="welcome"] {
        margin-bottom: 20px !important;
        font-size: 26px !important;
      }

      td[class="login-tem"] {
        padding-bottom: 50px !important;
      }

      table[class="footer-tem-table"] td {
        justify-content: center;
        display: flex;
        width: 100%;
      }

      table[class="tbl-main-book"] td {
        padding: 30px !important;
      }

      table hr[class="hr"] {
        margin: 0px 30px !important;
      }

      div[class="div-col"] {
        width: 100% !important;
        float: left !important;
      }

      div[class="div-col"] p {
        text-align: left !important;
      }
    }

    @media only screen and (max-width: 468px) {
      table[class="top-sec-img"] {
        margin-bottom: 0px;
      }
    }

    /* media queries */
    @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
      table[class="email-container"] {
        min-width: 320px !important;
      }
    }

    @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
      table[class="email-container"] {
        min-width: 375px !important;
      }
    }

    @media only screen and (min-device-width: 414px) {
      table[class="email-container"] {
        min-width: 414px !important;
      }
    }


    @media only screen and (max-width: 320px) {
      td[class="social-logo"] li {
        margin: 0px !important;
      }

      ul[class="navigation"] li {
        margin-left: 2px !important;
      }
    }
  </style>
</head>

<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #E7F3F4;" class="welcome-email">
  <center style="width: 100%; background-color: #E7F3F4;">

    <div style="max-width: 600px; margin: 0 auto 80px;" class="email-container">
      <table class="container" align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="max-width: 100%;">
        <tr>
          <td>
            <!-- Header Section -->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="top-sec-tem">
              <tr>
                <td class="logo" style="text-align: left; padding: 70px 0px 40px; vertical-align: middle;">
                  <div class="logo-div" style="display: inline-block; width: 41%; float: left;">
                    <a href="<?php echo 'https://' . $_SERVER['HTTP_HOST']; ?>"><img src="<?php echo 'https://' . $_SERVER['HTTP_HOST']; ?>/uploads/image/setting/1692358007.png" alt="" style="max-width: 300px; height: auto; margin: 0; max-width: 100%;"></a>
                  </div>
                  <ul class="navigation" style="margin: 0; display: inline-block; width: 59%; float: right; position: relative; padding-left: 0px; text-align: right;">
                    <li style="list-style: none; display: inline-block; margin-left: 10px;"><a href="<?php echo $this->config->get('config_twitterlink'); ?>"><img src="<?php echo 'https://' . $_SERVER['HTTP_HOST']; ?>/uploads/image/mail/twitter-icon.png" style="width: 32px; height: 32px; display: block;" alt="twitter" /></a></li>
                    <li style="list-style: none; display: inline-block; margin-left: 10px;"><a href="<?php echo $this->config->get('config_facebooklink'); ?>"><img src="<?php echo 'https://' . $_SERVER['HTTP_HOST']; ?>/uploads/image/mail/facebook-icon.png" style="width: 32px; height: 32px; display: block;" alt="facebook" /></a></li>
                    <li style="list-style: none; display: inline-block; margin-left: 10px;"><a href="<?php echo $this->config->get('config_instalink'); ?>"><img src="<?php echo 'https://' . $_SERVER['HTTP_HOST']; ?>/uploads/image/mail/instagram-icon.png" style="width: 32px; height: 32px; display: block;" alt="instagram" /></a></li>

                  </ul>
                </td>

              </tr>
            </table>
            <!-- Section 2: Content -->
            <!-- top-sec -->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; margin: 0 auto;" class="book-confirm-top">
              <tr>
                <td align="left" valign="bottom" style="padding: 50px 50px 40px 50px; background-color: #fff; vertical-align: middle;" width="100%">
                  <div class="div-col" style="display:inline-block; float: left; width: 50%;">
                    <p class="td-left" style="color: #144C60; font-family: Arial, sans-serif; font-size: 24px; font-style: normal; font-weight: 700;" float="left">Profile Status Changed</p>
                  </div>
                </td>

              </tr>
            </table>
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
              <tr>
                <td style="padding: 30px 50px 30px; background-color: #fff;">
                  <h1 class="welcome" style="font-size: 24px; color: #144C60; font-family: Arial, sans-serif; font-weight: 700; margin-bottom: 16px;">Dear Member,</h1>
                  <p class="middle-para" style="color: #144C60; font-family: Arial, sans-serif; font-size: 16px; line-height: 25px;"><?php if ($message) { echo $message; } ?> </p>
                </td>
              </tr>
            </table>
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; margin: 0 auto;">
              <tr class="border" style="padding-bottom: 20px;">
                <td style="background-color: #fff;">
                  <hr style="border-top: 1px solid #E2E8F0; margin: 0px 50px;" class="hr">
                </td>
              </tr>
            </table>
            
            </div>
            <!-- Section 4: Footer -->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="footer-tem-table">
              <tr style="background-color:#F9F9F9;">
                <td style="padding: 20px 20px 20px 40px; " width="50%">
                  <a class="footer-email" href="mailto:<?php echo $this->config->get('config_email'); ?>" style="text-align: left; text-decoration: none; display: inline-block; align-items: center; "><img style="margin-right: 6px; width:18px; height: auto; display: inline-block; position: relative; top: 4px;" src="<?php echo 'https://' . $_SERVER['HTTP_HOST']; ?>/uploads/image/mail/mail-icon.png" alt="email">
                    <p style="color: rgba(20, 76, 96, 0.7); font-size: 14px; line-height: 25px;  font-family: Arial, sans-serif; display: inline-block;"><?php echo $this->config->get('config_email'); ?></p>
                  </a>
                </td>
                <td style="padding: 20px 40px 20px 20px;" width="50%">
                  <p class="footer-para" style="text-align: right; color: rgba(20, 76, 96, 0.7); font-size: 13px; line-height: 25px;  font-family: Arial, sans-serif; display: inline-block;"><a style="color: rgba(20, 76, 96, 0.7); font-size: 13px; line-height: 25px;  font-family: Arial, sans-serif;" href="mailto:<?php echo $this->config->get('config_email'); ?>" target="_blank" rel="noopener noreferrer">Copyright PTC, All rights reserved.</p>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
</body>

</html>