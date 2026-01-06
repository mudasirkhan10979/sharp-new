<?php
class ControllerMenu extends Controller
{
	public function __construct($registry)
	{
		$this->registry = $registry;
	}
	public function index()
	{	
		$this->load_model('footer');
		$this->load_model('maincategory');
		$data['headerMenus'] = array();
		$data['headerMenus'] = $this->model_footer->getFooterMenu('Top');
		
        $data['plasmamenu'] = array();
		$data['plasmamenu'] = $this->model_footer->getFooterMenu('Plasmacluster Technology');
		$data['categories'] = array();
		$data['categories'] = $this->model_footer->getCategoriesRecursive('Categories');
		// echo '<pre>'; print_r($data['plasmamenu']); exit;

		$data['documentMenus'] = array();
		$data['documentMenus'] = $this->model_footer->getFooterMenu('Document &amp; Printing Solutions');
		$data['hlogo'] = BASE_URL . "uploads/image/setting/" . $this->config->get('config_hlogo');
		$data['lang'] = $this->session->data['lang'];
		$data['text_placeholder'] = $this->language->get('text_placeholder');
		$this->id = 'menu';
		$this->template = 'sharp/template/common/menu.tpl';
		$this->data = $data;
		$this->response->setOutput($this->render());
	}
}
