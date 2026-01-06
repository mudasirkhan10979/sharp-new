<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>استفسار</title>
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

<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #000000b8;"
    class="welcome-email">
    <center style="width: 100%; background-color: #fff">

        <div style="max-width: 650px; margin: 0 auto" class="email-container">
            <table class="container" align="center" border="0" cellpadding="0" cellspacing="0" width="650"
                style="max-width: 100%;">
                <tr>
                    <td>
                        <!-- Header Section -->
                        <!-- Section 2: Content -->
                        <!-- top-sec -->
                        <table border="0" cellpadding="0" cellspacing="0" width="100%"
                            style="max-width: 650px; margin: 0 auto;" class="book-confirm-top">
                            <tr>
                                <td align="left" valign="bottom"
                                    style="padding: 20px 50px 20px; background-color: #fff; vertical-align: middle;"
                                    width="100%">
                                    <div class="div-col" style="display:inline-block; float: right; width: 50%;">
                                        <div class="logo-div" style="display: inline-block; width: 50%; float: right;">
                                            <a href="<?php echo 'https://' . $_SERVER['HTTP_HOST']; ?>/ar/">
                                                <?php if ($this->config->get('config_email_logo')) {  ?>
                                                <img src="<?php echo 'https://' . $_SERVER['HTTP_HOST']; ?>/uploads/image/setting/<?php echo $this->config->get('config_email_logo'); ?>"
                                                    alt=""
                                                    style="max-width: 300px; height: auto; margin: 0; max-width: 100%;">
                                                <?php } else { ?>
                                                <img src="<?php echo 'https://' . $_SERVER['HTTP_HOST']; ?>/uploads/image/setting/1692358007.png"
                                                    alt=""
                                                    style="max-width: 300px; height: auto; margin: 0; max-width: 100%;">
                                                <?php } ?>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%"
                            style="max-width: 650px; margin: 0 auto;">
                            <tr class="border" style="padding-bottom: 20px;">
                                <td style="background-color: #fff;">
                                    <hr style="border-top: 1px solid #E2E8F0; margin: 0px 50px;" class="hr">
                                </td>
                            </tr>
                        </table>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="padding: 20px 50px 20px; background-color: #ffff;">
                                    <h1 class="welcome"
                                        style="font-size: 24px; color: #2e2d6f; font-family: Arial, sans-serif; font-weight: 700; margin-bottom: 16px; float: right;">
                                        عزيزي المسؤول،
                                    </h1>
                                    <div class="clear" style="clear:both;"></div>
                                    <p class="middle-para"
                                        style="color: #000; font-family: Arial, sans-serif; font-size: 16px; line-height: 25px; float: right;">
                                        لقد تلقيت استفسارًا
                                    </p>
                                </td>
                            </tr>
                        </table>

                        <table border="0" cellpadding="0" cellspacing="0" width="100%"
                            style="max-width: 650px; margin: 0 auto;">
                            <tr class="border" style="padding-bottom: 20px;">
                                <td style="background-color: #fff;">
                                    <hr style="border-top: 1px solid #E2E8F0; margin: 0px 50px;" class="hr">
                                </td>
                            </tr>
                        </table>

                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="padding: 30px 50px 20px; background-color: #ffff;">
                                    <h1 class="welcome"
                                        style="font-size: 20px; color: #2e2d6f; font-family: Arial, sans-serif; font-weight: 700; margin-bottom: 16px; float: right;">
                                        تفاصيل الاستفسار
                                    </h1>
                                    <div class="clear" style="clear:both;"></div>
                                    <p class="middle-para"
                                        style="color: #000; font-family: Arial, sans-serif; font-size: 16px; line-height: 25px; float: right;">
                                        يرجى الاطلاع على تفاصيل الاستفسار أدناه
                                    </p>
                                </td>
                            </tr>
                        </table>

                        <div class="table-wrapper" style="padding: 0px 50px 60px; background-color: #ffff;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                style="max-width: 650px; margin: 0 auto;" class="tbl-res">

                                <tr>
                                    <td class="td-right" align="right" valign="top"
                                        style="padding: 30px 10px 0px 30px; background-color: #D3D3D3;">
                                        <p
                                            style="color: #000; text-align: right; font-variant-numeric: lining-nums proportional-nums; font-family: Arial, sans-serif; font-size: 14px; font-style: normal; font-weight: 400; line-height: normal;">
                                            <?= $emailData['name'] ?></p>
                                    </td>
                                    <td class="td-left" align="left" valign="top"
                                        style="padding: 30px 30px 0px 10px; background-color: #D3D3D3;">
                                        <p
                                            style="color: #2e2d6f; font-family: Arial, sans-serif; font-size: 14px; font-weight: 700;    text-align: right;">
                                            اسم
                                        </p>
                                    </td>

                                </tr>
                                <tr class="border" style="padding-bottom: 20px;">
                                    <td style="background-color: #d3d3d3;" colspan="2">
                                        <hr style="border-top: 1px solid #fff;margin: 10px 30px;" class="hr">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td-right" align="right" valign="top"
                                        style="padding: 0px 10px 0px 30px; background-color: #D3D3D3;">
                                        <p
                                            style="color: #000; text-align: right; font-variant-numeric: lining-nums proportional-nums; font-family: Arial, sans-serif; font-size: 14px; font-style: normal; font-weight: 400; line-height: normal;">
                                            <?= $emailData['email'] ?></p>
                                    </td>
                                    <td class="td-left" align="left" valign="top"
                                        style="padding: 0px 30px 0px 10px; background-color: #D3D3D3;">
                                        <p
                                            style="color: #2e2d6f; font-family: Arial, sans-serif; font-size: 14px; font-weight: 700;    text-align: right;">
                                            البريد الإلكتروني
                                        </p>
                                    </td>

                                </tr>

                                <tr class="border" style="padding-bottom: 20px;">
                                    <td style="background-color: #d3d3d3;" colspan="2">
                                        <hr style="border-top: 1px solid #fff;margin: 10px 30px;" class="hr">
                                    </td>
                                </tr>

                                <tr>
                                    <td class="td-right" align="right" valign="top"
                                        style="padding: 0px 10px 0px 30px; background-color: #D3D3D3;">
                                        <p
                                            style="color: #000; text-align: right; font-variant-numeric: lining-nums proportional-nums; font-family: Arial, sans-serif; font-size: 14px; font-style: normal; font-weight: 400; line-height: normal; ">
                                            <?= $emailData['phone'] ?></p>
                                    </td>
                                    <td class="td-left" align="left" valign="top"
                                        style="padding: 0px 30px 0px 10px; background-color: #D3D3D3;">
                                        <p
                                            style="color: #2e2d6f; font-family: Arial, sans-serif; font-size: 14px; font-weight: 700;    text-align: right;">
                                            الهاتف
                                        </p>
                                    </td>

                                </tr>

                                <tr class="border" style="padding-bottom: 20px;">
                                    <td style="background-color: #d3d3d3;" colspan="2">
                                        <hr style="border-top: 1px solid #fff;margin: 10px 30px;" class="hr">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td-right" align="right" valign="top"
                                        style="padding: 0px 10px 0px 30px; background-color: #D3D3D3;">
                                        <p
                                            style="color: #000; text-align: right; font-variant-numeric: lining-nums proportional-nums; font-family: Arial, sans-serif; font-size: 14px; font-style: normal; font-weight: 400; line-height: normal;">
                                            <?= $emailData['subject'] ?></p>
                                    </td>
                                    <td class="td-left" align="left" valign="top"
                                        style="padding: 0px 30px 0px 10px; background-color: #D3D3D3;">
                                        <p
                                            style="color: #2e2d6f; font-family: Arial, sans-serif; font-size: 14px; font-weight: 700;    text-align: right;">
                                             موضوع
                                        </p>
                                    </td>

                                </tr>
                                <tr class="border" style="padding-bottom: 20px;">
                                    <td style="background-color: #d3d3d3;" colspan="2">
                                        <hr style="border-top: 1px solid #fff;margin: 10px 30px;" class="hr">
                                    </td>
                                </tr>

                                <tr>
                                    <td class="td-right" align="right" valign="top"
                                        style="padding: 0px 10px 40px 30px; background-color: #D3D3D3;">
                                        <p
                                            style="color: #000; text-align: right; font-variant-numeric: lining-nums proportional-nums; font-family: Arial, sans-serif; font-size: 14px; font-style: normal; font-weight: 400; line-height: normal; ">
                                            <?= $emailData['message'] ?></p>
                                    </td>
                                    <td class="td-left" align="left" valign="top"
                                        style="padding: 0px 30px 40px 10px; background-color: #D3D3D3;">
                                        <p
                                            style="color: #2e2d6f; font-family: Arial, sans-serif; font-size: 14px; font-weight: 700;     text-align: right;">
                                            الرسالة
                                        </p>
                                    </td>

                                </tr>

                            </table>
                        </div>
                    </td>
                </tr>
            </table>
</body>

</html>