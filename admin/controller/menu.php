<?php
class ControllerMenu extends Controller
{
	public function index()
	{
		// if (!$this->user->isLogged()) {
		//     $this->response->redirect($this->link('home', '', true));
		// }
		$data = $this->language->getAll();
		// var_dump($this->user->hasPermission('view', 'dashboard'));exit;
		$data['home'] = $this->link('dashboard', 'token=' . $this->session->data['token'], 'SSL');
		$data['setting'] = $this->link('setting', 'token=' . $this->session->data['token'], 'SSL');
		$data['adminuser'] = $this->link('adminuser', 'token=' . $this->session->data['token'], 'SSL');
		$data['roles'] = $this->link('roles', 'token=' . $this->session->data['token'], 'SSL');
		$data['frontmenu'] = $this->link('frontmenu', 'token=' . $this->session->data['token'], 'SSL');
		$data['pages'] = $this->link('pages', 'token=' . $this->session->data['token'], 'SSL');
		$data['blocks'] = $this->link('blocks', 'token=' . $this->session->data['token'], 'SSL');
		$data['home_slider'] = $this->link('sliders', 'token=' . $this->session->data['token'], 'SSL');
		$data['faqs'] = $this->link('faqs', 'token=' . $this->session->data['token'], 'SSL');
		$data['blogs'] = $this->link('blogs', 'token=' . $this->session->data['token'], 'SSL');
		$data['careers'] = $this->link('careers', 'token=' . $this->session->data['token'], 'SSL');
		$data['locations'] = $this->link('locations', 'token=' . $this->session->data['token'], 'SSL');
		$data['jobtype'] = $this->link('jobtype', 'token=' . $this->session->data['token'], 'SSL');
		$data['enquiries'] = $this->link('enquiries', 'token=' . $this->session->data['token'], 'SSL');
		$data['careerenquiries'] = $this->link('careerenquiries', 'token=' . $this->session->data['token'], 'SSL');
		$data['banner'] = $this->link('banner', 'token=' . $this->session->data['token'], 'SSL');
		$data['newseventscategories'] = $this->link('newseventscategories', 'token=' . $this->session->data['token'], 'SSL');
		$data['newsevents'] = $this->link('newsevents', 'token=' . $this->session->data['token'], 'SSL');
		$data['business'] = $this->link('business', 'token=' . $this->session->data['token'], 'SSL');
		$data['sectors'] = $this->link('sectors', 'token=' . $this->session->data['token'], 'SSL');
		$data['brands'] = $this->link('brands', 'token=' . $this->session->data['token'], 'SSL');
		$data['ourteams'] = $this->link('ourteams', 'token=' . $this->session->data['token'], 'SSL');
		$data['ourhistories'] = $this->link('ourhistories', 'token=' . $this->session->data['token'], 'SSL');
		$data['awards'] = $this->link('awards', 'token=' . $this->session->data['token'], 'SSL');
		$data['blockimages'] = $this->link('blockimages', 'token=' . $this->session->data['token'], 'SSL');
		$data['newsletters'] = $this->link('newsletters', 'token=' . $this->session->data['token'], 'SSL');
		$data['certificatesandresearch'] = $this->link('certificatesandresearch', 'token=' . $this->session->data['token'], 'SSL');
		$data['casestudy'] = $this->link('casestudy', 'token=' . $this->session->data['token'], 'SSL');
		$data['productlifecycleanalysis'] = $this->link('productlifecycleanalysis', 'token=' . $this->session->data['token'], 'SSL');
	    $data['lcareport'] = $this->link('lcareport', 'token=' . $this->session->data['token'], 'SSL');
	    $data['downloadcenter'] = $this->link('downloadcenter', 'token=' . $this->session->data['token'], 'SSL');
		$data['sourcedownload'] = $this->link('sourcedownload', 'token=' . $this->session->data['token'], 'SSL');
		$data['usermanuals'] = $this->link('usermanuals', 'token=' . $this->session->data['token'], 'SSL');
		$data['ourlocations'] = $this->link('ourlocations', 'token=' . $this->session->data['token'], 'SSL');
	    $data['sustainablepartner'] = $this->link('sustainablepartner', 'token=' . $this->session->data['token'], 'SSL');
		$data['customerfeedback'] = $this->link('customerfeedback', 'token=' . $this->session->data['token'], 'SSL');
        $data['service_centers'] = $this->link('service_centers', 'token=' . $this->session->data['token'], 'SSL');
		$data['product'] = $this->link('product', 'token=' . $this->session->data['token'], 'SSL');
        $data['screensize'] = $this->link('screensize', 'token=' . $this->session->data['token'], 'SSL');
        $data['resolution'] = $this->link('resolution', 'token=' . $this->session->data['token'], 'SSL');
        $data['productenquiry'] = $this->link('productenquiry', 'token=' . $this->session->data['token'], 'SSL');
		$data['categories'] = $this->link('categories', 'token=' . $this->session->data['token'], 'SSL');
		$data['attribute'] = $this->link('attribute', 'token=' . $this->session->data['token'], 'SSL');
		$data['attributevalue'] = $this->link('attributevalue', 'token=' . $this->session->data['token'], 'SSL');
		if ($this->user->getGroupId() != '1') {
			$data['viewer'] = true;
		} else {
			$data['viewer'] = false;
		}
		$data['user'] = $this->user;
		return $this->response->view('common/menu.tpl', $data);
	}
}
