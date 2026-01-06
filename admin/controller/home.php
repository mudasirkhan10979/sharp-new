<?php

class ControllerHome extends Controller {
	private $error = array();

	public function index() {
		
		$this->document->setTitle('Sharp - Administration');
		if ($this->user->isLogged() && isset($this->request->get['token']) && ($this->request->get['token'] == $this->session->data['token'])) {
			//$this->response->redirect($this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'));
			$this->redirect(HTTP_HOST . '?controller=dashboard&token='. $this->session->data['token']);
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			
			$this->session->data['token'] = md5(mt_rand());

			if (isset($this->request->post['redirect']) && (strpos($this->request->post['redirect'], HTTP_SERVER) === 0 || strpos($this->request->post['redirect'], HTTPS_SERVER) === 0 )) {
				
				//$this->response->redirect($this->request->post['redirect'] . '&token=' . $this->session->data['token']);
				$this->redirect(HTTP_HOST . '?controller='.$this->request->post['redirect'].'&token='. $this->session->data['token']);
			} else {
				
				//$this->response->redirect($this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'));
				$this->redirect(HTTP_HOST . '?controller=dashboard&token='. $this->session->data['token']);
			}
		}

		$data['heading_title'] = 'Administration';

		$data['text_login'] = 'Please enter your login details';
		$data['text_forgotten'] = 'Forgotten Password';

		$data['entry_username'] = 'Username';
		$data['entry_password'] = 'Password';

		$data['button_login'] = 'Login';

		if ((isset($this->session->data['token']) && !isset($this->request->get['token'])) || ((isset($this->request->get['token']) && (isset($this->session->data['token']) && ($this->request->get['token'] != $this->session->data['token']))))) {
			$this->error['warning'] = $this->language->get('error_token_login');
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		//$data['action'] = $this->url->link('common/login', '', 'SSL');
		$data['action'] = HTTP_HOST.'?controller=home';

		if (isset($this->request->post['username'])) {
			$data['username'] = $this->request->post['username'];
		} else {
			$data['username'] = '';
		}

		if (isset($this->request->post['password'])) {
			$data['password'] = $this->request->post['password'];
		} else {
			$data['password'] = '';
		}

		if (isset($this->request->get['route'])) {
			$route = $this->request->get['route'];

			unset($this->request->get['route']);
			unset($this->request->get['token']);

			$url = '';

			if ($this->request->get) {
				$url .= http_build_query($this->request->get);
			}

			$data['redirect'] = $this->url->link($route, $url, 'SSL');
		} else {
			$data['redirect'] = '';
		}

		if ($this->config->get('config_password')) {
			//$data['forgotten'] = $this->url->link('common/forgotten', '', 'SSL');
			$data['forgotten'] = HTTP_HOST.'?controller=forgotten';
		} else {
			$data['forgotten'] = '';
		}
		$this->data = $data;
		//echo '<pre>'; print_r($this->data);exit;
		$this->template = 'common/login.tpl';
		$this->zones = array(
			'header',
			'footer'
		);
		$this->response->setOutput($this->render());

		//$data['header'] = $this->load->controller('common/header');
		//$data['footer'] = $this->load->controller('common/footer');

		//$this->response->setOutput($this->load->view('common/login.tpl', $data));
	}

	protected function validate() {

		if (!isset($this->request->post['username']) || !isset($this->request->post['password']) || !$this->user->login($this->request->post['username'], $this->request->post['password'])) {
			$this->error['warning'] = 'No match for Username and/or Password.';
		}

		return !$this->error;
	}

	public function check() {
		$route = '';

		if (isset($this->request->get['route'])) {
			$part = explode('/', $this->request->get['route']);

			if (isset($part[0])) {
				$route .= $part[0];
			}

			if (isset($part[1])) {
				$route .= '/' . $part[1];
			}
		}

		$ignore = array(
			'common/login',
			'common/forgotten',
			'common/reset'
		);

		if (!$this->user->isLogged() && !in_array($route, $ignore)) {
			return new Action('common/login');
		}

		if (isset($this->request->get['route'])) {
			$ignore = array(
				'common/login',
				'common/logout',
				'common/forgotten',
				'common/reset',
				'error/not_found',
				'error/permission'
			);

			if (!in_array($route, $ignore) && (!isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token']))) {
				return new Action('common/login');
			}
		} else {
			if (!isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token'])) {
				return new Action('common/login');
			}
		}
	}
}