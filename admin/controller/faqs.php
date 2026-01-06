<?php
class ControllerFaqs extends Controller
{
	private $error = array();
	public function index()
	{
		$data = $this->language->getAll();
		$this->document->setTitle('Admin - Faqs');
		$this->load_model('faqs');
		$this->getList();
	}
	protected function getList()
	{
		$data                  = $this->language->getAll();
		$url                   = '';
		$data['breadcrumbs'][] = array(
			'text' => 'Home Banner',
			'href' => $this->link('faqs', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		if (isset($this->request->get['page'])) {
			$page = (int) $this->request->get['page'];
		} else {
			$page = 1;
		}
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		$data['add']    = $this->link('faqs/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->link('faqs/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['users'] = array();
		$filter_data   = array(
			'order' => $order,
		);
		$results       = $this->model_faqs->getFaqs($filter_data);
		foreach ($results as $result) {
			$data['faqs'][] = array(
				'faq_id'     => $result['id'],
				'sort_order' => $result['sort_order'],
				'question'   => $result['question'],
				'answer'     => $result['answer'],
				'publish'    => $result['publish'],
				'edit'       => $this->link('faqs/edit', 'token=' . $this->session->data['token'] . '&faq_id=' . $result['id'] . $url, 'SSL'),
				'delete'     => $this->link('faqs/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
			);
		}
		$data['main_slider'] = $results;
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
		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array) $this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}
		$data['groupby'] = 1;
		$url             = '';
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$data['sort_status']     = $this->link('faqs', 'token=' . $this->session->data['token'] . '&sort=publish' . $url, 'SSL');
		$data['sort_date_added'] = $this->link('faqs', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, 'SSL');
		$url                     = '';
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		$data['ajaxupdatefaqsstatus'] = $this->link('faqs/ajaxupdatefaqsstatus', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$bannerTotal        = $this->model_faqs->getTotalBanners();
		$pagination         = new Pagination();
		$pagination->total  = $bannerTotal;
		$pagination->page   = $page;
		$pagination->limit  = $this->config->get('config_limit_admin');
		$pagination->url    = HTTP_HOST . '?controller=faqs/&token=' . $this->session->data['token'] . $url . '&page={page}';
		$data['pagination'] = $pagination->render();
		$data['results']    = sprintf($this->language->get('text_pagination'), ($bannerTotal) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($bannerTotal - $this->config->get('config_limit_admin'))) ? $bannerTotal : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $bannerTotal, ceil($bannerTotal / $this->config->get('config_limit_admin')));
		$data['ajaxUrl']    = HTTP_HOST . '?controller=faqs';
		$data['token']      = $this->session->data['token'];
		$this->data         = $data;
		$this->template     = 'modules/faqs/list.tpl';
		$this->zones        = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}
	public function add()
	{
		$this->document->setTitle('Admin - Faqs');

		$this->load_model('faqs');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_faqs->addBanner($this->request->post);

			$this->session->data['success'] = $this->language->get('Success: You have added a new FAQ!');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->link('faqs', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		// die;
		$this->getForm();
	}
	protected function validateForm()
	{
		if (!$this->user->hasPermission('modify', 'faqs')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		$data = $this->request->post;
		foreach ($data['faqs_description'] as $language_id => $value) {
			if ((utf8_strlen(trim($value['question'])) < 1)) {
				$this->error['faqquestion'][$language_id] = "Question field is missing";
			}
			if ((utf8_strlen(trim($value['answer'])) < 1)) {
				$this->error['faqanswer'][$language_id] = "Answer field is missing";
			}
		}
		if ($this->error && ! isset($this->error['warning'])) {
			$this->error['warning'] = ' Warning: Please check the form carefully for errors!';
		}
		if (! $this->error) {
			return true;
		} else {
			return false;
		}
	}
	public function edit()
	{
		$this->document->setTitle('Admin - Faqs');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->load_model('faqs');
			$this->model_faqs->editBanner($this->request->get['faq_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have modified FAQ!');
			$url                            = '';
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->link('faqs', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		// echo "No";
		// die;
		$this->getForm();
	}
	public function delete()
	{
		$this->load_model('faqs');
		if($this->validateDelete() && isset($this->request->post['faq_id'])) {
			$this->model_faqs->deleteBanner($this->request->post['faq_id']);
			$this->session->data['success'] = $this->language->get('Success: You have deleted a FAQ!');

			$this->response->redirect($this->link('faqs', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->getList();
	}
	protected function getForm()
	{
		$data                       = $this->language->getAll();
		$data['text_form']          = ! isset($this->request->get['faq_id']) ? 'Add New FAQ' : 'Edit FAQ';
		$data['img_feild_required'] = ! isset($this->request->get['faq_id']) ? "required" : "";
		$data['is_edit']            = ! isset($this->request->get['faq_id']) ? "no" : "yes";
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		if (isset($this->error['faqquestion'])) {
			$data['error_faqquestion'] = $this->error['faqquestion'];
		} else {
			$data['error_faqquestion'] = '';
		}
		if (isset($this->error['faqanswer'])) {
			$data['error_faqanswer'] = $this->error['faqanswer'];
		} else {
			$data['error_faqanswer'] = '';
		}
		$url = '';

		if (! isset($this->request->get['faq_id'])) {
			$data['action'] = $this->link('faqs/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->link('faqs/edit', 'token=' . $this->session->data['token'] . '&faq_id=' . $this->request->get['faq_id'] . $url, 'SSL');
		}
		$data['cancel'] = $this->link('faqs', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['faq_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$this->load_model('faqs');
			$faq_info = $this->model_faqs->getBanner($this->request->get['faq_id']);
		}
		$data['single_slider'] = $faq_info;
		$db_filter             = [
			'order' => 'DESC'
		];
		$this->load_model('language');
		$data['languages'] = $this->model_language->getLanguages($db_filter);
		if (isset($this->request->post['faqs_description'])) {
			$data['faqs_description'] = $this->request->post['faqs_description'];
		} elseif (isset($this->request->get['faq_id'])) {
			$data['faqs_description'] = $this->model_faqs->getSliderDescriptions($this->request->get['faq_id']);
		} else {
			$data['faqs_description'] = array();
		}
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (! empty($faq_info)) {
			$data['sort_order'] = $faq_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
		if (isset($this->request->post['publish'])) {
			$data['publish'] = $this->request->post['publish'];
		} elseif (! empty($faq_info)) {
			$data['publish'] = $faq_info['publish'];
		} else {
			$data['publish'] = true;
		}
		if (isset($this->request->post['show_in_footer'])) {
			$data['show_in_footer'] = $this->request->post['show_in_footer'];
		} elseif (!empty($faq_info)) {
			$data['show_in_footer'] = $faq_info['show_in_footer'];
		} else {
			$data['show_in_footer'] = '';
		}
		if (isset($this->request->post['faq_category_id'])) {
			$data['faq_category_id'] = $this->request->post['faq_category_id'];
		} elseif (! empty($faq_info)) {
			$data['faq_category_id'] = $faq_info['faq_category_id'];
		} else {
			$data['faq_category_id'] = '';
		}

		$this->data     = $data;
		$this->template = 'modules/faqs/form.tpl';
		$this->zones    = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}

	public function ajaxupdatefaqsstatus()
	{
		$json = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
		$this->load_model('faqs');
		$faq_id = $this->request->post['faq_id'];
		$status = $this->request->post['status'];
		$this->model_faqs->updateFaqsStatus($faq_id, $status);
		$json['success'] = true;
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
		}
	}
	protected function validateDelete()
	{

		if (!$this->user->hasPermission('modify', 'faqs')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		

		return !$this->error;
	}
}
