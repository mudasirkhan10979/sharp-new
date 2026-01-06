<?php
class ControllerError404 extends Controller {

	public function index() {
		$data['text_page_not_found'] = $this->language->get('text_page_not_found');
		$data['text_not_found'] = $this->language->get('text_not_found');
		$data['text_go_to_home'] = $this->language->get('text_go_to_home');
		$this->template = 'sharp/template/common/error404.tpl';
		$this->data = $data;
		$this->zones = array(
			'header',
			'menuinner',
			'footer'
		);
		$this->response->setOutput($this->render());

	}
}