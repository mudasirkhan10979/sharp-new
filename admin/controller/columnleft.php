<?php
class ControllerColumnLeft extends Controller {
	public function index() {
		//if (isset($this->request->get['token']) && isset($this->session->data['token']) && ($this->request->get['token'] == $this->session->data['token'])) {
			// $data['profile'] = $this->load->controller('common/profile');
			// $data['menu'] = $this->load->controller('common/menu');
			// $data['stats'] = $this->load->controller('common/stats');
			//$data['profile'] = $this->load_controller('profile');
			$data['menu'] = $this->load_controller('menu');
			//$data['stats'] = $this->load_controller('stats');
//			echo '<pre>'; print_r($data);exit;
			$this->id = 'columnleft';
			$this->template = 'common/column_left.tpl';
			$this->data = $data;
			$this->zones = array();
			$this->response->setOutput($this->render()); 
			//return $this->response->view('common/column_left.tpl', $data);
			//return $this->load->view('common/column_left.tpl', $data);
		//}
	}
}