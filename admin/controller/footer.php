<?php
class ControllerFooter extends Controller {
	public function index() {
		//$this->load->language('common/footer');

		$data['text_footer'] = $this->language->get('text_footer');

		if ($this->user->isLogged() && isset($this->request->get['token']) && ($this->request->get['token'] == $this->session->data['token'])) {
			$data['text_version'] = sprintf($this->language->get('text_version'), VERSION);
		} else {
			$data['text_version'] = '';
		}

		// if ($this->request->server['HTTPS']) {
		// 	$data['base'] = HTTPS_SERVER;
		// } else {
		// 	$data['base'] = HTTP_SERVER;
		// }
		if ($this->user->getGroupId() != '1') {
			$data['viewer'] = true;
			$data['button_edit_icon'] = 'fa fa-eye';
			
		} else {
			$data['viewer'] = false;
			$data['button_edit_icon'] = 'fa fa-pencil';
		}
		$this->id = 'footer';
		$this->template = 'common/footer.tpl';
		$this->data = $data;
		//echo '<pre>'; print_r($this->data);exit;
		$this->zones = array();
		//$this->render();
		$this->response->setOutput($this->render());
		//return $this->load->view('common/footer.tpl', $data);
	}
}