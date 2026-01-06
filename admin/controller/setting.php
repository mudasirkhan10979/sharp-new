<?php
class ControllerSetting extends Controller
{
	private $error = array();
	public function index()
	{
		
		
		$this->document->setTitle('Admin - Settings');
		$this->load_model('setting');
		if (!empty($_FILES['config_favicon']["name"])) {

			$defaultImageFileName = "no_image-100x100.png";
			$uploadedImageFileName = $defaultImageFileName;
			$targetDirectory = DIR_IMAGE . "setting/";
			$filename = time();
			$path = $_FILES['config_favicon']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			$targetFile = $targetDirectory . $filename . '.' . $ext;
			if (move_uploaded_file($_FILES["config_favicon"]["tmp_name"], $targetFile)) {
				$uploadedImageFileName = $filename . '.' . $ext;
			}
			$this->request->post['config_favicon'] = $uploadedImageFileName;
		} else {
			$this->request->post['config_favicon'] = $this->config->get('config_favicon');
		}
		
		if (!empty($_FILES['config_hlogo']["name"])) {

			$defaultImageFileName = "no_image-100x100.png";
			$uploadedImageFileName = $defaultImageFileName;
			$targetDirectory = DIR_IMAGE . "setting/";
			$filename = time();
			$path = $_FILES['config_hlogo']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			$targetFile = $targetDirectory . $filename . '.' . $ext;
			if (move_uploaded_file($_FILES["config_hlogo"]["tmp_name"], $targetFile)) {
				$uploadedImageFileName = $filename . '.' . $ext;
			}
			$this->request->post['config_hlogo'] = $uploadedImageFileName;
		} else {
			$this->request->post['config_hlogo'] = $this->config->get('config_hlogo');
		}
		if (!empty($_FILES['config_flogo']["name"])) {

			$defaultImageFileName = "no_image-100x100.png";
			$uploadedImageFileName = $defaultImageFileName;
			$targetDirectory = DIR_IMAGE . "setting/";
			$filename = time();
			$path = $_FILES['config_flogo']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			$targetFile = $targetDirectory . $filename . '.' . $ext;
			if (move_uploaded_file($_FILES["config_flogo"]["tmp_name"], $targetFile)) {
				$uploadedImageFileName = $filename . '.' . $ext;
			}
			$this->request->post['config_flogo'] = $uploadedImageFileName;
		} else {
			$this->request->post['config_flogo'] = $this->config->get('config_flogo');
		}

		if (!empty($_FILES['config_mapimage']["name"])) {

			$defaultImageFileName = "no_image-100x100.png";
			$uploadedImageFileName = $defaultImageFileName;
			$targetDirectory = DIR_IMAGE . "setting/";
			$filename = time();
			$path = $_FILES['config_mapimage']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			$targetFile = $targetDirectory . $filename . '.' . $ext;
			if (move_uploaded_file($_FILES["config_mapimage"]["tmp_name"], $targetFile)) {
				$uploadedImageFileName = $filename . '.' . $ext;
			}
			$this->request->post['config_mapimage'] = $uploadedImageFileName;
		} else {
			$this->request->post['config_mapimage'] = $this->config->get('config_mapimage');
		}
		

		if (!empty($_FILES['config_email_logo']["name"])) {
			$config_email_logo = '';
			$targetDirectory = DIR_IMAGE . "setting/";
			$filename = time();
			$path = $_FILES['config_email_logo']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			$targetFile = $targetDirectory . $filename . '.' . $ext;
			if (move_uploaded_file($_FILES["config_email_logo"]["tmp_name"], $targetFile)) {
				$config_email_logo = $filename . '.' . $ext;
			}
			$this->request->post['config_email_logo'] = $config_email_logo;
		} else {
			$this->request->post['config_email_logo'] = $this->config->get('config_email_logo');
		}
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$this->model_setting->editSetting('config', $this->request->post);
			if ($this->config->get('config_currency_auto')) {
				$this->load_model('currency');
				$this->model_currency->refresh();
			}
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect(HTTP_HOST . '?controller=setting&token=' . $this->session->data['token']);
			//$this->response->redirect($this->url->link('setting/setting', 'token=' . $this->session->data['token'], 'SSL'));
		}


		$data['heading_title'] = 'Settings';
		$data['text_edit'] = 'Edit Settings';
		$data['text_enabled'] = 'Enabled';
		$data['text_disabled'] = 'Disabled';
		$data['text_select'] = $this->language->get('text_select');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_product'] = $this->language->get('text_product');

		$data['text_mail'] = $this->language->get('text_mail');
		$data['text_smtp'] = $this->language->get('text_smtp');
		$data['text_google_analytics'] = $this->language->get('text_google_analytics');
		$data['text_google_captcha'] = $this->language->get('text_google_captcha');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_owner'] = $this->language->get('entry_owner');
		$data['entry_address'] = $this->language->get('entry_address');
		$data['entry_footer_description'] = $this->language->get('entry_footer_description');
		$data['entry_geocode'] = $this->language->get('entry_geocode');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_facebook'] = $this->language->get('entry_facebook');
		$data['entry_address_location'] = $this->language->get('entry_address_location');
		$data['entry_whatsapp'] = $this->language->get('entry_whatsapp');
		$data['entry_twitter'] = $this->language->get('entry_twitter');
		$data['entry_linkedin'] = $this->language->get('entry_linkedin');
		$data['entry_instagram'] = $this->language->get('entry_instagram');
		$data['entry_youtube'] = $this->language->get('entry_youtube');
		$data['entry_map'] = $this->language->get('entry_map');
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_meta_title'] = $this->language->get('entry_meta_title');
		$data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$data['entry_layout'] = $this->language->get('entry_layout');
		$data['entry_template'] = $this->language->get('entry_template');
		$data['entry_country'] = $this->language->get('entry_country');
		$data['entry_zone'] = $this->language->get('entry_zone');
		$data['entry_language'] = $this->language->get('entry_language');
		$data['entry_admin_language'] = $this->language->get('entry_admin_language');
		$data['entry_currency'] = $this->language->get('entry_currency');
		$data['entry_currency_auto'] = $this->language->get('entry_currency_auto');
		$data['entry_tax'] = $this->language->get('entry_tax');
		$data['entry_tax_default'] = $this->language->get('entry_tax_default');
		$data['entry_tax_customer'] = $this->language->get('entry_tax_customer');
		$data['entry_customer_online'] = $this->language->get('entry_customer_online');
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_customer_group_display'] = $this->language->get('entry_customer_group_display');
		$data['entry_customer_price'] = $this->language->get('entry_customer_price');
		$data['entry_login_attempts'] = $this->language->get('entry_login_attempts');
		$data['entry_account'] = $this->language->get('entry_account');
		$data['entry_account_mail'] = $this->language->get('entry_account_mail');
		$data['entry_ftp_hostname'] = $this->language->get('entry_ftp_hostname');
		$data['entry_ftp_port'] = $this->language->get('entry_ftp_port');
		$data['entry_ftp_username'] = $this->language->get('entry_ftp_username');
		$data['entry_ftp_password'] = $this->language->get('entry_ftp_password');
		$data['entry_ftp_root'] = $this->language->get('entry_ftp_root');
		$data['entry_ftp_status'] = $this->language->get('entry_ftp_status');
		$data['entry_mail_protocol'] = $this->language->get('entry_mail_protocol');
		$data['entry_mail_parameter'] = $this->language->get('entry_mail_parameter');
		$data['entry_mail_smtp_hostname'] = $this->language->get('entry_mail_smtp_hostname');
		$data['entry_mail_smtp_username'] = $this->language->get('entry_mail_smtp_username');
		$data['entry_mail_smtp_password'] = $this->language->get('entry_mail_smtp_password');
		$data['entry_mail_smtp_port'] = $this->language->get('entry_mail_smtp_port');
		$data['entry_mail_smtp_timeout'] = $this->language->get('entry_mail_smtp_timeout');
		$data['entry_mail_alert'] = $this->language->get('entry_mail_alert');

		$data['entry_fraud_status'] = $this->language->get('entry_fraud_status');
		$data['entry_secure'] = $this->language->get('entry_secure');
		$data['entry_shared'] = $this->language->get('entry_shared');
		$data['entry_robots'] = $this->language->get('entry_robots');
		$data['entry_file_max_size'] = $this->language->get('entry_file_max_size');
		$data['entry_file_ext_allowed'] = $this->language->get('entry_file_ext_allowed');
		$data['entry_file_mime_allowed'] = $this->language->get('entry_file_mime_allowed');
		$data['entry_maintenance'] = $this->language->get('entry_maintenance');
		$data['entry_password'] = $this->language->get('entry_password');
		$data['entry_encryption'] = $this->language->get('entry_encryption');
		$data['entry_seo_url'] = $this->language->get('entry_seo_url');
		$data['entry_compression'] = $this->language->get('entry_compression');
		$data['entry_error_display'] = $this->language->get('entry_error_display');
		$data['entry_error_log'] = $this->language->get('entry_error_log');
		$data['entry_error_filename'] = $this->language->get('entry_error_filename');
		$data['entry_google_analytics'] = $this->language->get('entry_google_analytics');
		$data['entry_google_captcha_public'] = $this->language->get('entry_google_captcha_public');
		$data['entry_google_captcha_secret'] = $this->language->get('entry_google_captcha_secret');
		$data['entry_sociallinks'] = $this->language->get('entry_sociallinks');
		$data['entry_footerlinks'] = $this->language->get('entry_footerlinks');

		$data['entry_shippingmessage'] = $this->language->get('entry_shippingmessage');

		$data['entry_csociallinks'] = $this->language->get('entry_csociallinks');
		$data['entry_cdescription'] = $this->language->get('entry_cdescription');
		$data['entry_typeofenquiry'] = $this->language->get('entry_typeofenquiry');
		$data['entry_typeofevent'] = $this->language->get('entry_typeofevent');
		$data['entry_hearaboutus'] = $this->language->get('entry_hearaboutus');
		$data['entry_aboutdes'] = $this->language->get('entry_aboutdes');
		$data['entry_subscribe_image'] = $this->language->get('entry_subscribe_image');

		$data['entry_status'] = $this->language->get('entry_status');

		$data['help_geocode'] = $this->language->get('help_geocode');
		$data['help_open'] = $this->language->get('help_open');
		$data['help_comment'] = $this->language->get('help_comment');
		$data['help_location'] = $this->language->get('help_location');
		$data['help_currency'] = $this->language->get('help_currency');
		$data['help_currency_auto'] = $this->language->get('help_currency_auto');
		$data['help_product_limit'] = $this->language->get('help_product_limit');
		$data['help_product_description_length'] = $this->language->get('help_product_description_length');
		$data['help_limit_admin'] = $this->language->get('help_limit_admin');
		$data['help_product_count'] = $this->language->get('help_product_count');
		$data['help_review'] = $this->language->get('help_review');
		$data['help_review_guest'] = $this->language->get('help_review_guest');
		$data['help_review_mail'] = $this->language->get('help_review_mail');
		$data['help_voucher_min'] = $this->language->get('help_voucher_min');
		$data['help_voucher_max'] = $this->language->get('help_voucher_max');
		$data['help_tax_default'] = $this->language->get('help_tax_default');
		$data['help_tax_customer'] = $this->language->get('help_tax_customer');
		$data['help_customer_online'] = $this->language->get('help_customer_online');
		$data['help_customer_group'] = $this->language->get('help_customer_group');
		$data['help_customer_group_display'] = $this->language->get('help_customer_group_display');
		$data['help_customer_price'] = $this->language->get('help_customer_price');
		$data['help_login_attempts'] = $this->language->get('help_login_attempts');
		$data['help_account'] = $this->language->get('help_account');
		$data['help_account_mail'] = $this->language->get('help_account_mail');
		$data['help_api'] = $this->language->get('help_api');
		$data['help_cart_weight'] = $this->language->get('help_cart_weight');
		$data['help_checkout_guest'] = $this->language->get('help_checkout_guest');
		$data['help_checkout'] = $this->language->get('help_checkout');
		$data['help_invoice_prefix'] = $this->language->get('help_invoice_prefix');
		$data['help_order_status'] = $this->language->get('help_order_status');
		$data['help_processing_status'] = $this->language->get('help_processing_status');
		$data['help_complete_status'] = $this->language->get('help_complete_status');
		$data['help_order_mail'] = $this->language->get('help_order_mail');
		$data['help_stock_display'] = $this->language->get('help_stock_display');
		$data['help_stock_warning'] = $this->language->get('help_stock_warning');
		$data['help_stock_checkout'] = $this->language->get('help_stock_checkout');
		$data['help_affiliate_approval'] = $this->language->get('help_affiliate_approval');
		$data['help_affiliate_auto'] = $this->language->get('help_affiliate_auto');
		$data['help_affiliate_commission'] = $this->language->get('help_affiliate_commission');
		$data['help_affiliate'] = $this->language->get('help_affiliate');
		$data['help_affiliate_mail'] = $this->language->get('help_affiliate_mail');
		$data['help_commission'] = $this->language->get('help_commission');
		$data['help_return'] = $this->language->get('help_return');
		$data['help_return_status'] = $this->language->get('help_return_status');
		$data['help_icon'] = $this->language->get('help_icon');
		$data['help_ftp_root'] = $this->language->get('help_ftp_root');
		$data['help_mail_protocol'] = $this->language->get('help_mail_protocol');
		$data['help_mail_parameter'] = $this->language->get('help_mail_parameter');
		$data['help_mail_smtp_hostname'] = $this->language->get('help_mail_smtp_hostname');
		$data['help_mail_alert'] = $this->language->get('help_mail_alert');
		$data['help_fraud_detection'] = $this->language->get('help_fraud_detection');
		$data['help_fraud_score'] = $this->language->get('help_fraud_score');
		$data['help_fraud_status'] = $this->language->get('help_fraud_status');
		$data['help_secure'] = $this->language->get('help_secure');
		$data['help_shared'] = $this->language->get('help_shared');
		$data['help_robots'] = $this->language->get('help_robots');
		$data['help_seo_url'] = $this->language->get('help_seo_url');
		$data['help_file_max_size'] = $this->language->get('help_file_max_size');
		$data['help_file_ext_allowed'] = $this->language->get('help_file_ext_allowed');
		$data['help_file_mime_allowed'] = $this->language->get('help_file_mime_allowed');
		$data['help_maintenance'] = $this->language->get('help_maintenance');
		$data['help_password'] = $this->language->get('help_password');
		$data['help_encryption'] = $this->language->get('help_encryption');
		$data['help_compression'] = $this->language->get('help_compression');
		$data['help_google_analytics'] = $this->language->get('help_google_analytics');
		$data['help_google_captcha'] = $this->language->get('help_google_captcha');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_meta'] = $this->language->get('tab_meta');
		$data['tab_mail'] = $this->language->get('tab_mail');
		$data['tab_server'] = $this->language->get('tab_server');
		$data['tab_google'] = $this->language->get('tab_google');
		$data['tab_misc'] = $this->language->get('tab_misc');

		
		if ($this->user->getGroupId() != '1') {
			$data['viewer'] = true;
			$data['button_edit_icon'] = 'fa fa-eye';
		} else {
			$data['viewer'] = false;
			$data['button_edit_icon'] = 'fa fa-pencil';
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}
		if (isset($this->error['address_location'])) {
			$data['error_address_location'] = $this->error['address_location'];
		} else {
			$data['error_address_location'] = '';
		}
		if (isset($this->error['whatsapp'])) {
			$data['error_whatsapp'] = $this->error['whatsapp'];
		} else {
			$data['error_whatsapp'] = '';
		}

			// Consumer Electronics Errors
		$ce_fields = ['facebook', 'twitter', 'linkedin', 'instagram', 'youtube'];
		foreach ($ce_fields as $field) {
			$data['error_ce_' . $field] = isset($this->error['ce_' . $field]) ? $this->error['ce_' . $field] : '';
		}

		// Business Solutions Errors
		$bs_fields = ['facebook', 'twitter', 'linkedin', 'youtube'];
		foreach ($bs_fields as $field) {
			$data['error_bs_' . $field] = isset($this->error['bs_' . $field]) ? $this->error['bs_' . $field] : '';
		}

		// if (isset($this->error['map'])) {
		// 	$data['error_map'] = $this->error['map'];
		// } else {
		// 	$data['error_map'] = '';
		// }

		if (isset($this->error['locmap'])) {
			$data['error_locmap'] = $this->error['locmap'];
		} else {
			$data['error_locmap'] = '';
		}

		if (isset($this->error['address'])) {
			$data['error_address'] = $this->error['address'];
		} else {
			$data['error_address'] = '';
		}
		if (isset($this->error['f_description'])) {
			$data['error_f_description'] = $this->error['f_description'];
		} else {
			$data['error_f_description'] = '';
		}

		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}

		if (isset($this->error['careers_email'])) {
			$data['error_careers_email'] = $this->error['careers_email'];
		} else {
			$data['error_careers_email'] = '';
		}

		if (isset($this->error['telephone'])) {
			$data['error_telephone'] = $this->error['telephone'];
		} else {
			$data['error_telephone'] = '';
		}

		if (isset($this->error['meta_title'])) {
			$data['error_meta_title'] = $this->error['meta_title'];
		} else {
			$data['error_meta_title'] = '';
		}

		if (isset($this->error['country'])) {
			$data['error_country'] = $this->error['country'];
		} else {
			$data['error_country'] = '';
		}

		if (isset($this->error['zone'])) {
			$data['error_zone'] = $this->error['zone'];
		} else {
			$data['error_zone'] = '';
		}

		if (isset($this->error['customer_group_display'])) {
			$data['error_customer_group_display'] = $this->error['customer_group_display'];
		} else {
			$data['error_customer_group_display'] = '';
		}

		if (isset($this->error['login_attempts'])) {
			$data['error_login_attempts'] = $this->error['login_attempts'];
		} else {
			$data['error_login_attempts'] = '';
		}

		if (isset($this->error['voucher_min'])) {
			$data['error_voucher_min'] = $this->error['voucher_min'];
		} else {
			$data['error_voucher_min'] = '';
		}

		if (isset($this->error['voucher_max'])) {
			$data['error_voucher_max'] = $this->error['voucher_max'];
		} else {
			$data['error_voucher_max'] = '';
		}

		if (isset($this->error['processing_status'])) {
			$data['error_processing_status'] = $this->error['processing_status'];
		} else {
			$data['error_processing_status'] = '';
		}

		if (isset($this->error['complete_status'])) {
			$data['error_complete_status'] = $this->error['complete_status'];
		} else {
			$data['error_complete_status'] = '';
		}

		if (isset($this->error['ftp_hostname'])) {
			$data['error_ftp_hostname'] = $this->error['ftp_hostname'];
		} else {
			$data['error_ftp_hostname'] = '';
		}

		if (isset($this->error['ftp_port'])) {
			$data['error_ftp_port'] = $this->error['ftp_port'];
		} else {
			$data['error_ftp_port'] = '';
		}

		if (isset($this->error['ftp_username'])) {
			$data['error_ftp_username'] = $this->error['ftp_username'];
		} else {
			$data['error_ftp_username'] = '';
		}

		if (isset($this->error['ftp_password'])) {
			$data['error_ftp_password'] = $this->error['ftp_password'];
		} else {
			$data['error_ftp_password'] = '';
		}

		if (isset($this->error['image_category'])) {
			$data['error_image_category'] = $this->error['image_category'];
		} else {
			$data['error_image_category'] = '';
		}

		if (isset($this->error['image_thumb'])) {
			$data['error_image_thumb'] = $this->error['image_thumb'];
		} else {
			$data['error_image_thumb'] = '';
		}

		if (isset($this->error['image_popup'])) {
			$data['error_image_popup'] = $this->error['image_popup'];
		} else {
			$data['error_image_popup'] = '';
		}

		if (isset($this->error['image_product'])) {
			$data['error_image_product'] = $this->error['image_product'];
		} else {
			$data['error_image_product'] = '';
		}

		if (isset($this->error['image_additional'])) {
			$data['error_image_additional'] = $this->error['image_additional'];
		} else {
			$data['error_image_additional'] = '';
		}

		if (isset($this->error['image_related'])) {
			$data['error_image_related'] = $this->error['image_related'];
		} else {
			$data['error_image_related'] = '';
		}

		if (isset($this->error['image_compare'])) {
			$data['error_image_compare'] = $this->error['image_compare'];
		} else {
			$data['error_image_compare'] = '';
		}

		if (isset($this->error['image_wishlist'])) {
			$data['error_image_wishlist'] = $this->error['image_wishlist'];
		} else {
			$data['error_image_wishlist'] = '';
		}

		if (isset($this->error['image_cart'])) {
			$data['error_image_cart'] = $this->error['image_cart'];
		} else {
			$data['error_image_cart'] = '';
		}

		if (isset($this->error['image_location'])) {
			$data['error_image_location'] = $this->error['image_location'];
		} else {
			$data['error_image_location'] = '';
		}

		if (isset($this->error['error_filename'])) {
			$data['error_error_filename'] = $this->error['error_filename'];
		} else {
			$data['error_error_filename'] = '';
		}

		if (isset($this->error['product_limit'])) {
			$data['error_product_limit'] = $this->error['product_limit'];
		} else {
			$data['error_product_limit'] = '';
		}

		if (isset($this->error['product_description_length'])) {
			$data['error_product_description_length'] = $this->error['product_description_length'];
		} else {
			$data['error_product_description_length'] = '';
		}

		if (isset($this->error['limit_admin'])) {
			$data['error_limit_admin'] = $this->error['limit_admin'];
		} else {
			$data['error_limit_admin'] = '';
		}

		if (isset($this->error['encryption'])) {
			$data['error_encryption'] = $this->error['encryption'];
		} else {
			$data['error_encryption'] = '';
		}
		
		if (isset($this->error['blog_banner_title'])) {
			$data['error_blog_banner_title'] = $this->error['blog_banner_title'];
		} else {
			$data['error_blog_banner_title'] = '';
		}

		if (isset($this->error['program_banner_title'])) {
			$data['error_program_banner_title'] = $this->error['program_banner_title'];
		} else {
			$data['error_program_banner_title'] = '';
		}

		if (isset($this->error['payment_stripe_test_public_key'])) {
			$data['error_payment_stripe_test_public_key'] = $this->error['payment_stripe_test_public_key'];
		} else {
			$data['error_payment_stripe_test_public_key'] = '';
		}

		if (isset($this->error['payment_stripe_test_secret_key'])) {
			$data['error_payment_stripe_test_secret_key'] = $this->error['payment_stripe_test_secret_key'];
		} else {
			$data['error_payment_stripe_test_secret_key'] = '';
		}
		
		if (isset($this->error['payment_stripe_live_public_key'])) {
			$data['error_payment_stripe_live_public_key'] = $this->error['payment_stripe_live_public_key'];
		} else {
			$data['error_payment_stripe_live_public_key'] = '';
		}

		if (isset($this->error['payment_stripe_live_secret_key'])) {
			$data['error_payment_stripe_live_secret_key'] = $this->error['payment_stripe_live_secret_key'];
		} else {
			$data['error_payment_stripe_live_secret_key'] = '';
		}
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title_set'),
			//'href' => $this->url->link('setting/setting', 'token=' . $this->session->data['token'], 'SSL')
			'href' => HTTP_HOST . '?controller=setting&token=' . $this->session->data['token']
		);

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		//$data['action'] = $this->url->link('setting/setting', 'token=' . $this->session->data['token'], 'SSL');
		//$data['cancel'] = $this->url->link('setting/store', 'token=' . $this->session->data['token'], 'SSL');
		$data['action'] = HTTP_HOST . '?controller=setting&token=' . $this->session->data['token'];
		$data['cancel'] = HTTP_HOST . '?controller=dashboard&token=' . $this->session->data['token'];

		$data['token'] = $this->session->data['token'];
		if (isset($this->request->post['config_favicon'])) {
			$data['config_favicon'] = $this->request->post['config_favicon'];
		} else {
			$data['config_favicon'] = $this->config->get('config_favicon');
		}
		if (isset($this->request->post['config_flogo'])) {
			$data['config_flogo'] = $this->request->post['config_flogo'];
		} else {
			$data['config_flogo'] = $this->config->get('config_flogo');
		}
		if (isset($this->request->post['config_hlogo'])) {
			$data['config_hlogo'] = $this->request->post['config_hlogo'];
		} else {
			$data['config_hlogo'] = $this->config->get('config_hlogo');
		}
		if (isset($this->request->post['config_mapimage'])) {
			$data['config_mapimage'] = $this->request->post['config_mapimage'];
		} else {
			$data['config_mapimage'] = $this->config->get('config_mapimage');
		}
		if (isset($this->request->post['config_hwblogo'])) {
			$data['config_hwblogo'] = $this->request->post['config_hwblogo'];
		} else {
			$data['config_hwblogo'] = $this->config->get('config_hwblogo');
		}
		if (isset($this->request->post['config_banner_program'])) {
			$data['config_banner_program'] = $this->request->post['config_banner_program'];
		} else {
			$data['config_banner_program'] = $this->config->get('config_banner_program');
		}
		if (isset($this->request->post['config_email_logo'])) {
			$data['config_email_logo'] = $this->request->post['config_email_logo'];
		} else {
			$data['config_email_logo'] = $this->config->get('config_email_logo');
		}
		if (isset($this->request->post['config_name'])) {
			$data['config_name'] = $this->request->post['config_name'];
		} else {
			$data['config_name'] = $this->config->get('config_name');
		}
		if (isset($this->request->post['config_address'])) {
			$data['config_address'] = $this->request->post['config_address'];
		} else {
			$data['config_address'] = $this->config->get('config_address');
		}
		if (isset($this->request->post['config_f_description'])) {
			$data['config_f_description'] = $this->request->post['config_f_description'];
		} else {
			$data['config_f_description'] = $this->config->get('config_f_description');
		}
		if (isset($this->request->post['config_email'])) {
			$data['config_email'] = $this->request->post['config_email'];
		} else {
			$data['config_email'] = $this->config->get('config_email');
		}
		if (isset($this->request->post['config_email_careers'])) {
			$data['config_email_careers'] = $this->request->post['config_email_careers'];
		} else {
			$data['config_email_careers'] = $this->config->get('config_email_careers');
		}
		// Consumer Electronics Fields
		$ce_fields = ['facebook', 'twitter', 'linkedin', 'instagram', 'youtube'];
		foreach ($ce_fields as $field) {
			if (isset($this->request->post['config_ce_' . $field])) {
				$data['config_ce_' . $field] = $this->request->post['config_ce_' . $field];
			} else {
				$data['config_ce_' . $field] = $this->config->get('config_ce_' . $field);
			}
		}

		// Business Solutions Fields
		$bs_fields = ['facebook', 'twitter', 'linkedin', 'instagram', 'youtube'];
		foreach ($bs_fields as $field) {
			if (isset($this->request->post['config_bs_' . $field])) {
				$data['config_bs_' . $field] = $this->request->post['config_bs_' . $field];
			} else {
				$data['config_bs_' . $field] = $this->config->get('config_bs_' . $field);
			}
		}
		if (isset($this->request->post['config_address_location'])) {
			$data['config_address_location'] = $this->request->post['config_address_location'];
		} else {
			$data['config_address_location'] = $this->config->get('config_address_location');
		}
		if (isset($this->request->post['config_whatsapp'])) {
			$data['config_whatsapp'] = $this->request->post['config_whatsapp'];
		} else {
			$data['config_whatsapp'] = $this->config->get('config_whatsapp');
		}
		// if (isset($this->request->post['config_map'])) {
		// 	$data['config_map'] = $this->request->post['config_map'];
		// } else {
		// 	$data['config_map'] = $this->config->get('config_map');
		// }
		if (isset($this->request->post['config_telephone'])) {
			$data['config_telephone'] = $this->request->post['config_telephone'];
		} else {
			$data['config_telephone'] = $this->config->get('config_telephone');
		}

		if (isset($this->request->post['config_meta_title'])) {
			$data['config_meta_title'] = $this->request->post['config_meta_title'];
		} else {
			$data['config_meta_title'] = $this->config->get('config_meta_title');
		}

		if (isset($this->request->post['config_meta_description'])) {
			$data['config_meta_description'] = $this->request->post['config_meta_description'];
		} else {
			$data['config_meta_description'] = $this->config->get('config_meta_description');
		}

		if (isset($this->request->post['config_meta_keyword'])) {
			$data['config_meta_keyword'] = $this->request->post['config_meta_keyword'];
		} else {
			$data['config_meta_keyword'] = $this->config->get('config_meta_keyword');
		}

		if (isset($this->request->post['config_ftp_hostname'])) {
			$data['config_ftp_hostname'] = $this->request->post['config_ftp_hostname'];
		} else {
			$data['config_ftp_hostname'] = $this->config->get('config_ftp_hostname');
		}
		if (isset($this->request->post['config_footer_services'])) {
			$data['config_footer_services'] = $this->request->post['config_footer_services'];
		} else {
			$data['config_footer_services'] = $this->config->get('config_footer_services');
		}
		if (isset($this->request->post['config_ftp_port'])) {
			$data['config_ftp_port'] = $this->request->post['config_ftp_port'];
		} else {
			$data['config_ftp_port'] = $this->config->get('config_ftp_port');
		}

		if (isset($this->request->post['config_mail_protocol'])) {
			$data['config_mail_protocol'] = $this->request->post['config_mail_protocol'];
		} else {
			$data['config_mail_protocol'] = $this->config->get('config_mail_protocol');
		}

		if (isset($this->request->post['config_mail_parameter'])) {
			$data['config_mail_parameter'] = $this->request->post['config_mail_parameter'];
		} else {
			$data['config_mail_parameter'] = $this->config->get('config_mail_parameter');
		}

		if (isset($this->request->post['config_mail_smtp_hostname'])) {
			$data['config_mail_smtp_hostname'] = $this->request->post['config_mail_smtp_hostname'];
		} else {
			$data['config_mail_smtp_hostname'] = $this->config->get('config_mail_smtp_hostname');
		}

		if (isset($this->request->post['config_ftp_username'])) {
			$data['config_ftp_username'] = $this->request->post['config_ftp_username'];
		} else {
			$data['config_ftp_username'] = $this->config->get('config_ftp_username');
		}

		if (isset($this->request->post['config_mail_smtp_username'])) {
			$data['config_mail_smtp_username'] = $this->request->post['config_mail_smtp_username'];
		} else {
			$data['config_mail_smtp_username'] = $this->config->get('config_mail_smtp_username');
		}

		if (isset($this->request->post['config_mail_smtp_password'])) {
			$data['config_mail_smtp_password'] = $this->request->post['config_mail_smtp_password'];
		} else {
			$data['config_mail_smtp_password'] = $this->config->get('config_mail_smtp_password');
		}

		if (isset($this->request->post['config_mail_smtp_port'])) {
			$data['config_mail_smtp_port'] = $this->request->post['config_mail_smtp_port'];
		} else {
			$data['config_mail_smtp_port'] = $this->config->get('config_mail_smtp_port');
		}

		if (isset($this->request->post['config_mail_smtp_timeout'])) {
			$data['config_mail_smtp_timeout'] = $this->request->post['config_mail_smtp_timeout'];
		} else {
			$data['config_mail_smtp_timeout'] = $this->config->get('config_mail_smtp_timeout');
		}

		if (isset($this->request->post['config_mail_alert'])) {
			$data['config_mail_alert'] = $this->request->post['config_mail_alert'];
		} else {
			$data['config_mail_alert'] = $this->config->get('config_mail_alert');
		}

		if (isset($this->request->post['config_file_max_size'])) {
			$data['config_file_max_size'] = $this->request->post['config_file_max_size'];
		} else {
			$data['config_file_max_size'] = $this->config->get('config_file_max_size');
		}

		if (isset($this->request->post['config_file_mime_allowed'])) {
			$data['config_file_mime_allowed'] = $this->request->post['config_file_mime_allowed'];
		} else {
			$data['config_file_mime_allowed'] = $this->config->get('config_file_mime_allowed');
		}

		if (isset($this->request->post['config_maintenance'])) {
			$data['config_maintenance'] = $this->request->post['config_maintenance'];
		} else {
			$data['config_maintenance'] = $this->config->get('config_maintenance');
		}

		if (isset($this->request->post['config_encryption'])) {
			$data['config_encryption'] = $this->request->post['config_encryption'];
		} else {
			$data['config_encryption'] = $this->config->get('config_encryption');
		}

		if (isset($this->request->post['config_google_analytics'])) {
			$data['config_google_analytics'] = $this->request->post['config_google_analytics'];
		} else {
			$data['config_google_analytics'] = $this->config->get('config_google_analytics');
		}

		if (isset($this->request->post['config_google_analytics_status'])) {
			$data['config_google_analytics_status'] = $this->request->post['config_google_analytics_status'];
		} else {
			$data['config_google_analytics_status'] = $this->config->get('config_google_analytics_status');
		}

		if (isset($this->request->post['config_google_captcha_public'])) {
			$data['config_google_captcha_public'] = $this->request->post['config_google_captcha_public'];
		} else {
			$data['config_google_captcha_public'] = $this->config->get('config_google_captcha_public');
		}

		if (isset($this->request->post['config_google_captcha_secret'])) {
			$data['config_google_captcha_secret'] = $this->request->post['config_google_captcha_secret'];
		} else {
			$data['config_google_captcha_secret'] = $this->config->get('config_google_captcha_secret');
		}

		if (isset($this->request->post['config_instagram_url'])) {
			$data['config_instagram_url'] = $this->request->post['config_instagram_url'];
		} else {
			$data['config_instagram_url'] = $this->config->get('config_instagram_url');
		}

		if (isset($this->request->post['config_instagram_token'])) {
			$data['config_instagram_token'] = $this->request->post['config_instagram_token'];
		} else {
			$data['config_instagram_token'] = $this->config->get('config_instagram_token');
		}

		if (isset($this->request->post['config_instagram_handler_name'])) {
			$data['config_instagram_handler_name'] = $this->request->post['config_instagram_handler_name'];
		} else {
			$data['config_instagram_handler_name'] = $this->config->get('config_instagram_handler_name');
		}

		if (isset($this->request->post['config_google_captcha_status'])) {
			$data['config_google_captcha_status'] = $this->request->post['config_google_captcha_status'];
		} else {
			$data['config_google_captcha_status'] = $this->config->get('config_google_captcha_status');
		}
		if (isset($this->request->post['config_google_map_api_key'])) {
			$data['config_google_map_api_key'] = $this->request->post['config_google_map_api_key'];
		} else {
			$data['config_google_map_api_key'] = $this->config->get('config_google_map_api_key');
		}

		if (isset($this->request->post['config_priceunit'])) {
			$data['config_priceunit'] = $this->request->post['config_priceunit'];
		} else {
			$data['config_priceunit'] = $this->config->get('config_priceunit');
		}
		if (isset($this->request->post['config_currency'])) {
			$data['config_currency'] = $this->request->post['config_currency'];
		} else {
			$data['config_currency'] = $this->config->get('config_currency');
		}

		if (isset($this->request->post['config_limit_admin'])) {
			$data['config_limit_admin'] = $this->request->post['config_limit_admin'];
		} else {
			$data['config_limit_admin'] = $this->config->get('config_limit_admin');
		}


		if (isset($this->request->post['config_limit_admin'])) {
			$data['config_limit_admin'] = $this->request->post['config_limit_admin'];
		} else {
			$data['config_limit_admin'] = $this->config->get('config_limit_admin');
		}

		// payment parameters

		if (isset($this->request->post['config_payment_stripe_environment'])) {
			$data['config_payment_stripe_environment'] = $this->request->post['config_payment_stripe_environment'];
		} else {
			$data['config_payment_stripe_environment'] = $this->config->get('config_payment_stripe_environment');
		}
		if (isset($this->request->post['config_payment_stripe_test_public_key'])) {
			$data['config_payment_stripe_test_public_key'] = $this->request->post['config_payment_stripe_test_public_key'];
		} else {
			$data['config_payment_stripe_test_public_key'] = $this->config->get('config_payment_stripe_test_public_key');
		}
		if (isset($this->request->post['config_payment_stripe_test_secret_key'])) {
			$data['config_payment_stripe_test_secret_key'] = $this->request->post['config_payment_stripe_test_secret_key'];
		} else {
			$data['config_payment_stripe_test_secret_key'] = $this->config->get('config_payment_stripe_test_secret_key');
		}
		if (isset($this->request->post['config_payment_stripe_live_public_key'])) {
			$data['config_payment_stripe_live_public_key'] = $this->request->post['config_payment_stripe_live_public_key'];
		} else {
			$data['config_payment_stripe_live_public_key'] = $this->config->get('config_payment_stripe_live_public_key');
		}
		if (isset($this->request->post['config_payment_stripe_live_secret_key'])) {
			$data['config_payment_stripe_live_secret_key'] = $this->request->post['config_payment_stripe_live_secret_key'];
		} else {
			$data['config_payment_stripe_live_secret_key'] = $this->config->get('config_payment_stripe_live_secret_key');
		}
		if (isset($this->request->post['config_payment_stripe_status'])) {
			$data['config_payment_stripe_status'] = $this->request->post['config_payment_stripe_status'];
		} else {
			$data['config_payment_stripe_status'] = $this->config->get('config_payment_stripe_status');
		}

		$this->load_model('image');

		if (isset($this->request->post['config_subscribe_image']) && is_file(DIR_IMAGE . $this->request->post['config_subscribe_image'])) {
			$data['subscribe_thumb'] = $this->model_image->resize($this->request->post['config_subscribe_image'], 100, 100);
		} elseif ($this->config->get('config_subscribe_image') && is_file(DIR_IMAGE . $this->config->get('config_subscribe_image'))) {
			$data['subscribe_thumb'] = $this->model_image->resize($this->config->get('config_subscribe_image'), 100, 100);
		} else {
			$data['subscribe_thumb'] = $this->model_image->resize('no_image.png', 100, 100);
		}

		$db_filter = [
			'order' => 'DESC'
		];
		$this->load_model('language');
		$data['languages'] = $this->model_language->getLanguages($db_filter);
		// echo '<pre>'; print_r($data['languages']); exit;
		foreach ($data['languages'] as $language) {

			if (isset($this->request->post['config_name' . $language['language_id']])) {
				$data['config_name'][$language['language_id']] = $this->request->post['config_name' . $language['language_id']];
			} else {
				$data['config_name'][$language['language_id']] = $this->config->get('config_name' . $language['language_id']);
			}
			if (isset($this->request->post['config_address' . $language['language_id']])) {
				$data['config_address'][$language['language_id']] = $this->request->post['config_address' . $language['language_id']];
			} else {
				$data['config_address'][$language['language_id']] = $this->config->get('config_address' . $language['language_id']);
			}
			if (isset($this->request->post['config_f_description' . $language['language_id']])) {
				$data['config_f_description'][$language['language_id']] = $this->request->post['config_f_description' . $language['language_id']];
			} else {
				$data['config_f_description'][$language['language_id']] = $this->config->get('config_f_description' . $language['language_id']);
			}

			if (isset($this->request->post['config_meta_title' . $language['language_id']])) {
				$data['config_meta_title'][$language['language_id']] = $this->request->post['config_meta_title' . $language['language_id']];
			} else {
				$data['config_meta_title'][$language['language_id']] = $this->config->get('config_meta_title' . $language['language_id']);
			}

			if (isset($this->request->post['config_meta_description' . $language['language_id']])) {
				$data['config_meta_description'][$language['language_id']] = $this->request->post['config_meta_description' . $language['language_id']];
			} else {
				$data['config_meta_description'][$language['language_id']] = $this->config->get('config_meta_description' . $language['language_id']);
			}

			if (isset($this->request->post['config_meta_keyword' . $language['language_id']])) {
				$data['config_meta_keyword'][$language['language_id']] = $this->request->post['config_meta_keyword' . $language['language_id']];
			} else {
				$data['config_meta_keyword'][$language['language_id']] = $this->config->get('config_meta_keyword' . $language['language_id']);
			}
		}

		$data['placeholder'] = $this->model_image->resize('no_image.png', 100, 100);
		$data['settingUrl'] = HTTP_HOST . '?controller=setting';
		//echo '<pre>'; print_r($data);exit;
		$this->data = $data;
		$this->template = 'setting/setting.tpl';
		$this->zones = array(
			'header',
			'footer'
		);
		$this->response->setOutput($this->render());

		// $data['header'] = $this->load->controller('common/header');
		// $data['column_left'] = $this->load->controller('common/column_left');
		// $data['footer'] = $this->load->controller('common/footer');

		// $this->response->setOutput($this->load->view('setting/setting.tpl', $data));
	}

	protected function validate()
	{
		if (!$this->user->hasPermission('modify', 'setting')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		} 

		$db_filter = [
			'order' => 'DESC'
		];
		$this->load_model('language');
		$languages = $this->model_language->getLanguages($db_filter);
		// echo '<pre>'; print_r($languages); exit;
		foreach ($languages as $language) {
			$nameField = 'config_name' . $language['language_id'];
			$addressField = 'config_address' . $language['language_id'];
			$fDescriptionField = 'config_f_description' . $language['language_id'];
			$metaTitleField = 'config_meta_title' . $language['language_id'];

			if (!$this->request->post[$nameField]) {
				$this->error['name'][$language['language_id']] = $this->language->get('error_name');
			}

			if ((utf8_strlen($this->request->post[$addressField]) < 3) || (utf8_strlen($this->request->post[$addressField]) > 256)) {
				$this->error['address'][$language['language_id']] = $this->language->get('error_address');
			}

			if ((utf8_strlen($this->request->post[$fDescriptionField]) < 1) || (utf8_strlen($this->request->post[$fDescriptionField]) > 256)) {
				$this->error['f_description'][$language['language_id']] = $this->language->get('error_f_description');
			}

			if (!$this->request->post[$metaTitleField]) {
				$this->error['meta_title'][$language['language_id']] = $this->language->get('error_meta_title');
			}
		}

		if (!$this->request->post['config_address_location']) {
			$this->error['address_location'] = $this->language->get('error_address_location');
		}
		if (!$this->request->post['config_whatsapp']) {
			$this->error['whatsapp'] = $this->language->get('error_whatsapp');
		}
		// Consumer Electronics Fields
		$ce_fields = ['facebook', 'twitter', 'linkedin', 'instagram', 'youtube'];
		foreach ($ce_fields as $field) {
			if (empty($this->request->post['config_ce_' . $field])) {
				$this->error['ce_' . $field] = $this->language->get('error_' . $field);
			}

			if (isset($this->error['ce_' . $field])) {
				$data['error_ce_' . $field] = $this->error['ce_' . $field];
			} else {
				$data['error_ce_' . $field] = '';
			}
		}

		// Business Solutions Fields
		$bs_fields = ['facebook', 'twitter', 'linkedin', 'youtube'];
		foreach ($bs_fields as $field) {
			if (empty($this->request->post['config_bs_' . $field])) {
				$this->error['bs_' . $field] = $this->language->get('error_' . $field);
			}

			if (isset($this->error['bs_' . $field])) {
				$data['error_bs_' . $field] = $this->error['bs_' . $field];
			} else {
				$data['error_bs_' . $field] = '';
			}
		}

		// if (!$this->request->post['config_map']) {
		// 	$this->error['map'] = $this->language->get('error_map');
		// }

		if (!$this->request->post['config_mapimage']) {
			$this->error['locmap'] = $this->language->get('error_locmap');
		}

		if ((utf8_strlen($this->request->post['config_email']) > 96) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['config_email'])) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if ((utf8_strlen($this->request->post['config_email_careers']) > 96) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['config_email_careers'])) {
			$this->error['careers_email'] = $this->language->get('error_careers_email');
		}

		if ((utf8_strlen($this->request->post['config_telephone']) < 3) || (utf8_strlen($this->request->post['config_telephone']) > 32)) {
			$this->error['telephone'] = $this->language->get('error_telephone');
		}


		if ($this->request->post['config_ftp_status']) {
			if (!$this->request->post['config_ftp_hostname']) {
				$this->error['ftp_hostname'] = $this->language->get('error_ftp_hostname');
			}

			if (!$this->request->post['config_ftp_port']) {
				$this->error['ftp_port'] = $this->language->get('error_ftp_port');
			}

			if (!$this->request->post['config_ftp_username']) {
				$this->error['ftp_username'] = $this->language->get('error_ftp_username');
			}

			if (!$this->request->post['config_ftp_password']) {
				$this->error['ftp_password'] = $this->language->get('error_ftp_password');
			}
		}
		if ($this->request->post['config_payment_stripe_environment'] == 'live') {
			if ((utf8_strlen($this->request->post['config_payment_stripe_live_secret_key']) < 3)) {
				$this->error['payment_stripe_live_secret_key'] = 'Stripe live secret key is missing';
			}
			if ((utf8_strlen($this->request->post['config_payment_stripe_live_public_key']) < 3)) {
				$this->error['payment_stripe_live_public_key'] = 'Stripe live public key is missing';
			}
		} else {
			if ((utf8_strlen($this->request->post['config_payment_stripe_test_secret_key']) < 3)) {
				$this->error['payment_stripe_test_secret_key'] = 'Stripe test secret key is missing';
			}
			if ((utf8_strlen($this->request->post['config_payment_stripe_test_public_key']) < 3)) {
				$this->error['payment_stripe_test_public_key'] = 'Stripe test public key is missing';
			}
		}







		if ((utf8_strlen($this->request->post['config_encryption']) < 3) || (utf8_strlen($this->request->post['config_encryption']) > 32)) {
			$this->error['encryption'] = $this->language->get('error_encryption');
		}
		//echo '<pre>'; print_r($this->error);exit;
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	public function template()
	{
		if ($this->request->server['HTTPS']) {
			$server = HTTPS_CATALOG . 'uploads/';
		} else {
			$server = HTTP_CATALOG . 'uploads/';
		}

		if (is_file(DIR_IMAGE . 'templates/' . basename($this->request->get['template']) . '.png')) {
			$this->response->setOutput($server . 'image/templates/' . basename($this->request->get['template']) . '.png');
		} else {
			$this->response->setOutput($server . 'image/no_image.png');
		}
	}

	public function country()
	{
		$json = array();

		$this->load_model('country');

		$country_info = $this->model_country->getCountry($this->request->get['country_id']);

		if ($country_info) {
			$this->load_model('zone');

			$json = array(
				'country_id'        => $country_info['country_id'],
				'name'              => $country_info['name'],
				'iso_code_2'        => $country_info['iso_code_2'],
				'iso_code_3'        => $country_info['iso_code_3'],
				'address_format'    => $country_info['address_format'],
				'postcode_required' => $country_info['postcode_required'],
				'zone'              => $this->model_zone->getZonesByCountryId($this->request->get['country_id']),
				'status'            => $country_info['status']
			);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
