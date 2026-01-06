<?php

class ControllerContact extends Controller
{
	private $error = array();
	public function __construct($registry)
	{
		parent::__construct($registry);
		$this->registry->set('pcUrls', 'contact-us');
	}
	public function index()
	{
		$data = array();
		$data['action'] = HTTPS_HOST . $this->registry->get('pcUrls');
		$this->load_model('contact');
		$this->load_model('home');
		$this->load_model('page');
		$page_id =  $this->registry->get('slug_data')['slog_id'];
		$page = $this->model_page->getPage($page_id);
		if (empty($page)) {
			$this->redirect(HTTPS_HOST . 'error404');
			exit;
		}
		$short_description =  strip_tags(html_entity_decode($page['short_description'], ENT_QUOTES, 'UTF-8'));
		if ($page['banner_image']) {
			$image = BASE_URL . "uploads/image/pages/" . $page['banner_image'];
		} else {
			$image =  BASE_URL . "uploads/default_banner.jpg";
		}
		$data['banner'] = array(
			'title'              => $page['name'],
			'short_description' => $short_description,
			'image'             => $image
		);
		if ($page['meta_description']) {
			$cleaned_descrition =  strip_tags(html_entity_decode($page['meta_description'], ENT_QUOTES, 'UTF-8'));
			$metaDescription = substr($cleaned_descrition, 0, 160);
			$this->document->setDescription($metaDescription);
		} elseif ($page['short_description']) {
			$cleaned_descrition =  strip_tags(html_entity_decode($page['short_description'], ENT_QUOTES, 'UTF-8'));
			$metaDescription = substr($cleaned_descrition, 0, 160);
			$this->document->setDescription($metaDescription);
		}
		if ($page['meta_keyword']) {
			$this->document->setKeywords($page['meta_keyword']);
		} elseif ($page['title']) {
			$this->document->setKeywords($page['title']);
		}
		if ($page['meta_title']) {
			$this->document->setTitle($page['meta_title']);
		} elseif ($page['title']) {
			$this->document->setTitle($page['title']);
		}
		$customerFeedback = $this->model_contact->getCustomerFeedback();
		$data['customerFeedback'] = $customerFeedback;
		$data['name'] = $this->request->post['name'] ?? '';
		$data['phone'] = $this->request->post['phone'] ?? '';
		$data['email'] = $this->request->post['email'] ?? '';
		$data['subject'] = $this->request->post['subject'] ?? '';
		$data['message'] = $this->request->post['message'] ?? '';
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		}
		$data['public_key'] = $this->config->get('config_google_captcha_public');
		$bgetIntouch = $this->model_home->getHtmlBlock('get-in-touch');
		if (!empty($bgetIntouch['content'])) {
			$bgetIntouch['content'] = str_replace('&nbsp;', ' ', html_entity_decode($bgetIntouch['content'], ENT_QUOTES, 'UTF-8'));
		}
		$data['bgetIntouch'] = $bgetIntouch;

		$blockcontactdetails = $this->model_home->getHtmlBlock('block-contact-details');
		if (!empty($blockcontactdetails['content'])) {
			$blockcontactdetails['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockcontactdetails['content'], ENT_QUOTES, 'UTF-8'));
		}
		$data['blockcontactdetails'] = $blockcontactdetails;

		$aboutsharpgetyourhighly = $this->model_home->getHtmlBlock('about-sharp-get-your-highly');
		if (!empty($aboutsharpgetyourhighly['content'])) {
			$aboutsharpgetyourhighly['content'] = str_replace('&nbsp;', ' ', html_entity_decode($aboutsharpgetyourhighly['content'], ENT_QUOTES, 'UTF-8'));
		}
		$data['aboutsharpgetyourhighly'] = $aboutsharpgetyourhighly;
		$sharpimagegetyour = $this->model_home->getHtmlBlockImages('sharp-image-get-your');
		$data['sharpimagegetyour'] = $sharpimagegetyour;
		$data['telephone'] = $this->config->get('config_telephone');
		$data['config_email'] = $this->config->get('config_email');
		$data['facebook'] = $this->config->get('config_bs_facebook');
		$data['youtube'] = $this->config->get('config_bs_youtube');
		$data['instagram'] = $this->config->get('config_ce_instagram');
		$data['twitter'] = $this->config->get('config_bs_twitter');
		$data['config_address'] = $this->config->get('config_address' . $this->config->get('config_language_id'));
		$data['text_btn_submit'] = $this->language->get('text_btn_submit');
		$data['text_subject'] = $this->language->get('text_subject');
		$data['err_name'] = $this->language->get('err_name');
		$data['err_subject'] = $this->language->get('err_subject');
		$data['err_email'] = $this->language->get('err_email');
		$data['err_invalid_email'] = $this->language->get('err_invalid_email');
		$data['err_message'] = $this->language->get('err_message');
		$data['err_captcha'] = $this->language->get('err_captcha');
		$data['err_phone'] = $this->language->get('err_phone');
		$data['err_invalid_phone'] = $this->language->get('err_invalid_phone');
		$data['text_name'] = $this->language->get('text_name');
		$data['entry_phone_contact'] = $this->language->get('entry_phone_contact');
		$data['entry_email_address'] = $this->language->get('entry_email_address');
		$data['text_location'] = $this->language->get('text_location');
		$data['entry_message'] = $this->language->get('entry_message');
		$data['entry_follow_us'] = $this->language->get('entry_follow_us');
		$data['text_learn_more'] = $this->language->get('text_learn_more');
		$data['text_customer_feedback'] = $this->language->get('text_customer_feedback');
		$data['text_service_center_contacts'] = $this->language->get('text_service_center_contacts');
		$data['siteKey'] = $this->config->get('config_google_captcha_public');
		$servicecenters = $this->model_contact->GetServiceCenters();
		$data['servicecenters'] = $servicecenters;
		// echo '<pre>'; print_r($data['servicecenters']); echo '</pre>'; exit; 
		$this->template = 'sharp/template/contact.tpl';
		$this->data = $data;
		$this->zones = ['header', 'menuinner', 'footer'];
		$this->response->setOutput($this->render());
	}

	public function contactUsForm()
	{
		$this->load_model('contact');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (!$this->validateForm()) {
				$json = array('error' => $this->error);
				$this->response->setOutput(json_encode($json));
				return;
			}
			$this->model_contact->addContact($this->request->post);
			$toEmail = $this->config->get('config_email');
			$message = $this->request->post['message'];
			if ($this->config->get('config_language_id') != 1) {
				$subject = 'طلب استفسار من ' . $this->request->post['name'];
				$subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
			} else {
				$subject = 'Enquiry from ' . $this->request->post['name'];
			}
			$emaildata = [
				'name' => $this->request->post['name'],
				'email' => $this->request->post['email'],
				'phone' => $this->request->post['phone'],
				'subject' => $this->request->post['subject'],
				'message' => $this->request->post['message'],
				'enquiry_from' => $this->request->post['enquiry_from']
			];
			$data = ['message' => $message, 'emailData' => $emaildata];
			$mail = new Mail();
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = "ssl";
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->username = $this->config->get('config_mail_smtp_username');
			$mail->password = $this->config->get('config_mail_smtp_password');
			$mail->port = $this->config->get('config_mail_smtp_port');
			$mail->setTo($toEmail);
			$mail->setFrom($toEmail);
			$mail->setReplyTo($toEmail);
			$mail->setSender('Sharp');
			$mail->setSubject($subject);
			if ($this->config->get('config_language_id') != 1) {
				$this->template = 'sharp/template/mail/admin-notification-ar.tpl';
			} else {
				$this->template = 'sharp/template/mail/admin-notification.tpl';
			}
			$this->data = $data;
			$mail->setHtml($this->render());
			$mail->send();
			$json['success'] = $this->language->get('text_new_success_message');
			$this->response->setOutput(json_encode($json));
		}
	}

	protected function validateForm()
	{
		$err_name = $this->language->get('err_name');
		$err_subject = $this->language->get('err_subject');
		$err_phone = $this->language->get('err_phone');
		$err_email = $this->language->get('err_email');
		$err_invalid_email = $this->language->get('err_invalid_email');
		$err_message = $this->language->get('err_message');
		$err_captcha = $this->language->get('err_captcha');
		if ((utf8_strlen($this->request->post['name']) < 1)) {
			$this->error['name'] = $err_name;
		}
		if ((utf8_strlen(trim($this->request->post['email'])) < 1)) {
			$this->error['email'] = $err_email;
		} elseif (!filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
			$this->error['email'] = $err_invalid_email;
		}

		if ((utf8_strlen($this->request->post['subject']) < 1)) {
			$this->error['subject'] = $err_subject;
		}

		if ((utf8_strlen($this->request->post['message']) < 1)) {
			$this->error['message'] = $err_message;
		}

		if ((utf8_strlen(trim($this->request->post['phone'])) < 1)) {
			$this->error['phone'] = $err_phone;
		}
		$token = $this->request->post['recaptcha_token'] ?? '';
		$recaptcha_verified = $this->verifyRecaptcha($token);
		if (!$recaptcha_verified) {
			$this->error['recaptcha'] = $err_captcha;
		}

		return !$this->error;
	}

	private function verifyRecaptcha($token)
	{
		$secret_key = $this->config->get('config_google_captcha_secret');

		if (empty($token)) {
			return false;
		}
		$url = 'https://www.google.com/recaptcha/api/siteverify';
		$data = [
			'secret' => $secret_key,
			'response' => $token
		];
		$options = [
			'http' => [
				'header' => "Content-type: application/x-www-form-urlencoded\r\n",
				'method' => 'POST',
				'content' => http_build_query($data)
			]
		];
		$context = stream_context_create($options);
		$response = file_get_contents($url, false, $context);
		$result = json_decode($response, true);
		return $result['success'] && $result['score'] >= 0.5;
	}
}
