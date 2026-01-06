<?php
class ControllerFooter extends Controller
{
	private $error = array();
	public function index()
	{
		$this->load_model('footer');
		$data['footerMenus'] = array();
		$data['footerMenus'] = $this->model_footer->getFooterMenu('Bottom');
		$data['SupportMenus'] = array();
		$data['SupportMenus'] = $this->model_footer->getFooterMenu('Support');
		$data['footerLegalsMenus'] = array();
		$data['footerLegalsMenus'] = $this->model_footer->getFooterMenu('Legals');
		// Consumer Electronics
		$data['ce_facebook']  = $this->config->get('config_ce_facebook');
		$data['ce_twitter']   = $this->config->get('config_ce_twitter');
		$data['ce_linkedin']  = $this->config->get('config_ce_linkedin');
		$data['ce_instagram'] = $this->config->get('config_ce_instagram');
		$data['ce_youtube']   = $this->config->get('config_ce_youtube');

		// Business Solutions
		$data['bs_facebook']  = $this->config->get('config_bs_facebook');
		$data['bs_twitter']   = $this->config->get('config_bs_twitter');
		$data['bs_linkedin']  = $this->config->get('config_bs_linkedin');
		$data['bs_instagram'] = $this->config->get('config_bs_instagram');
		$data['bs_youtube']   = $this->config->get('config_bs_youtube');

		$data['text_about_footer'] = $this->language->get('text_about_footer');
		$data['text_consumer'] = $this->language->get('text_consumer');
		$data['text_solution'] = $this->language->get('text_solution');
		$data['text_plasmacuster_technology'] = $this->language->get('text_plasmacuster_technology');
		$data['text_plasmacuster'] = $this->language->get('text_plasmacuster');
		$data['text_about_plasmacuster'] = $this->language->get('text_about_plasmacuster');
		$data['text_awards'] = $this->language->get('text_awards');
		$data['text_support'] = $this->language->get('text_support');
		$data['text_subscribe_now'] = $this->language->get('text_subscribe_now');
		$data['text_subscribe'] = $this->language->get('text_subscribe');
		$data['text_copyrights'] = $this->language->get('text_copyrights');
		$data['text_your_name'] = $this->language->get('text_your_name');
		$data['text_your_email'] = $this->language->get('text_your_email');
		$data['categories'] = array();
		$data['categories'] = $this->model_footer->getCategoriesFooterMenu();
		$this->id = 'footer';
		$this->template = 'sharp/template/common/footer.tpl';
		$this->data = $data;
		$this->response->setOutput($this->render());
	}

	public function subscribe()
{
    $json = array();
    if ($this->request->server['REQUEST_METHOD'] == 'POST') {
        $this->load_model('home');
        if (!$this->validateForm()) {
            $json = array('error' => $this->error);
            $this->response->setOutput(json_encode($json));
            return;
        }
        if ($this->model_home->checkEmailExists($this->request->post['email'])) {
            $json['error']['email'] = $this->language->get('error_email_exists');
        }
        if (empty($json['error'])) {
            $this->model_home->addSubscription($this->request->post);
            $json['success'] = $this->language->get('text_success');
        }
    }
    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
}

protected function validateForm()
{
    $err_name = $this->language->get('err_name');
    $err_email = $this->language->get('err_email');
    $err_invalid_email = $this->language->get('err_invalid_email');
    if (empty(trim($this->request->post['name']))) {
        $this->error['name'] = $err_name;
    }
    $email = trim($this->request->post['email']);
    if (empty($email)) {
        $this->error['email'] = $err_email;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $this->error['email'] = $err_invalid_email;
    }
    return empty($this->error);
}

}
