<?php
class ControllerHeader extends Controller
{
	public function __construct($registry)
	{
		$this->registry = $registry;
	}
	public function index()
	{
		$data = array();
		$data = $this->language->getAll();
		$currentUrl = $_SERVER['REQUEST_URI'];  
        $data['currentUrl'] = $currentUrl;
		$data['captchaStatus'] = $this->config->get('config_google_captcha_status');
		$data['siteKey'] = $this->config->get('config_google_captcha_public'); 
		$data['hlogo'] = BASE_URL . "uploads/image/setting/" . $this->config->get('config_hlogo');
	    $data['lang'] = $this->config->get('config_language');
		$data['flogo'] = BASE_URL . "uploads/image/setting/" . $this->config->get('config_favicon');
		$data['config_name'] = $this->config->get('config_name' . $this->config->get('config_language_id'));
		$classurl = $_SERVER['REQUEST_URI'];
		$classurl = trim($classurl, '/');
		if (!empty($classurl) && $classurl !== "ar") {
			$class = preg_replace(['/\?[^?]*$/', '/\//'], ['', '-'], $classurl);
			$data['body_class'] = trim($class, '-');
		} else {
			$data['body_class'] = 'home';
		}
		$data['meta_title'] = $this->document->getTitle();
		$data['meta_description'] = $this->document->getDescription();
		$data['meta_keywords'] = $this->document->getKeywords();
		$data['langauges'] = $this->load_controller('language');
		$data['lang'] = $this->session->data['lang'];
		$this->id = 'header';
		$this->template = 'sharp/template/common/header.tpl';
		$this->data = $data;
		$this->response->setOutput($this->render());
	}
}
