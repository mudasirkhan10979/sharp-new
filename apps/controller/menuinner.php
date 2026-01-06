<?php
class ControllerMenuInner extends Controller
{
	public function __construct($registry)
	{
		$this->registry = $registry;
	}
	public function index()
	{
		$this->load_model('footer');
		$data['headerMenus'] = array();
		$data['headerMenus'] = $this->model_footer->getFooterMenu('Top');
		$data['categories'] = array();
        $data['categories'] = $this->model_footer->getCategoriesRecursive();
		$data['plasmamenu'] = array();
		$data['plasmamenu'] = $this->model_footer->getFooterMenu('Plasmacluster Technology');
		$data['documentMenus'] = array();
		$data['documentMenus'] = $this->model_footer->getFooterMenu('Document &amp; Printing Solutions');
		$slugData = $this->registry->get('slug_data');
		$category_id = (int)$slugData['slog_id'];
		$this->load_model('maincategory');
		$parentCategory = $this->model_maincategory->getParentCategory($category_id);
		$data['parentCategory'] = $parentCategory;
		$data['hlogo'] = BASE_URL . "uploads/image/setting/" . $this->config->get('config_hlogo');
		$data['lang'] = $this->session->data['lang'];
		$data['text_placeholder'] = $this->language->get('text_placeholder');
		$this->id = 'menuinner';
		$this->template = 'sharp/template/common/menu-inner.tpl';
		$this->data = $data;
		$this->response->setOutput($this->render());
	}
}
