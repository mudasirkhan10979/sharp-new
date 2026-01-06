<?php
class ControllerLogout extends Controller {
	public function index() {
		$this->user->logout();

		unset($this->session->data['token']);
		$this->response->redirect(HTTP_HOST);
		//$this->response->redirect($this->url->link('common/login', '', 'SSL'));
	}
}