<?php
class ControllerBlocks extends Controller
{
	private $error = array();
	public function index()
	{
		$data = $this->language->getAll();
		$this->document->setTitle('Admin - HTML Blocks');
		$this->load_model('block');
		$this->getList();
	}
	public function add()
	{
		$this->document->setTitle('Admin - HTML Blocks');
		$this->load_model('block');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			// echo '<pre>';  print_r($_POST); exit;
			$this->model_block->addBanner($this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have added a new HTML Block!');
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
			$this->response->redirect($this->link('blocks', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		// die;
		$this->getForm();
	}

	public function edit()
	{
		$this->document->setTitle('Admin - HTML Blocks');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->load_model('block');
			$this->model_block->editBanner($this->request->get['block_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have modified HTML Block!');
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
			$this->response->redirect($this->link('blocks', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		// echo "No";
		// die;
		$this->getForm();
	}
	public function delete()
	{
		$this->load_model('block');
		if($this->validateDelete() && $this->request->post['block_id']){
			$this->model_block->deleteBanner($this->request->post['block_id']);
			$this->session->data['success'] = $this->language->get('Success: You have deleted HTML Block!');
			$this->response->redirect($this->link('blocks', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->getList();
	}
	protected function getForm()
	{
		$data = $this->language->getAll();
		$data['text_form'] = !isset($this->request->get['block_id']) ? 'Add New HTML Block' : 'Edit HTML Block';

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		if (isset($this->error['sliderimg'])) {
			$data['error_blockimg'] = $this->error['sliderimg'];
		} else {
			$data['error_blockimg'] = '';
		}
		if (isset($this->error['blacktitle'])) {
			$data['error_blocktitle'] = $this->error['blacktitle'];
		} else {
			$data['error_blocktitle'] = '';
		}
		if (isset($this->error['blocktext'])) {
			$data['error_pagename'] = $this->error['blocktext'];
		} else {
			$data['error_pagename'] = '';
		}
		if (isset($this->error['blockspecificname'])) {
			$data['error_blockspecificname'] = $this->error['blockspecificname'];
		} else {
			$data['error_blockspecificname'] = '';
		}
		if (isset($this->error['content'])) {
			$data['error_content'] = $this->error['content'];
		} else {
			$data['error_content'] = '';
		}
		$url = '';
		$data['breadcrumbs'][] = array(
			'text' => "Home Banner",
			'href' => $this->link('blocks', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		if (!isset($this->request->get['block_id'])) {
			$data['action'] = $this->link('blocks/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->link('blocks/edit', 'token=' . $this->session->data['token'] . '&block_id=' . $this->request->get['block_id'] . $url, 'SSL');
		}
		$data['cancel'] = $this->link('blocks', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['block_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$this->load_model('block');
			$block_info = $this->model_block->getBanner($this->request->get['block_id']);
			
		}
		$data['single_slider'] = $block_info;
		$db_filter = [
			'order' => 'DESC'
		];
		$this->load_model('language');
		$data['languages'] = $this->model_language->getLanguages($db_filter);
		if (isset($this->request->post['block_description'])) {
			$data['block_description'] = $this->request->post['block_description'];
		} elseif (isset($this->request->get['block_id'])) {
			$data['block_description'] = $this->model_block->getSliderDescriptions($this->request->get['block_id']);
		} else {
			$data['block_description'] = array();
		}
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($block_info)) {
			$data['sort_order'] = $block_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
		if (isset($this->request->post['on_page'])) {
			$data['on_page'] = $this->request->post['on_page'];
		} elseif (!empty($block_info)) {
			$data['on_page'] = $block_info['on_page'];
		} else {
			$data['on_page'] = '';
		}
		if (isset($this->request->post['unique_text'])) {
			$data['unique_text'] = $this->request->post['unique_text'];
		} elseif (!empty($block_info)) {
			$data['unique_text'] = $block_info['unique_text'];
		} else {
			$data['unique_text'] = '';
		}
		if (isset($this->request->post['publish'])) {
			$data['publish'] = $this->request->post['publish'];
		} elseif (!empty($block_info)) {
			$data['publish'] = $block_info['publish'];
		} else {
			$data['publish'] = true;
		}

		$this->data = $data;
		$this->template = 'modules/blocks/form.tpl';
		$this->zones = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}
	protected function validateForm()
	{
		if (!$this->user->hasPermission('modify', 'blocks')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		$data = $this->request->post;
		foreach ($data['block_description'] as $language_id => $value) {
			if ((utf8_strlen(trim($value['title'])) < 1)) {
				$this->error['blacktitle'][$language_id] = "Title field is missing";
			}
			if ((utf8_strlen(trim($value['on_page'])) < 1)) {
				$this->error['blocktext'][$language_id] = "Page name where display is missing";
			}
			if ((utf8_strlen(trim($value['unique_text'])) < 1)) {
				$this->error['blockspecificname'][$language_id] = "Block specific name is missing";
			}
			if ((utf8_strlen(trim($value['content'])) < 1)) {
				$this->error['content'][$language_id] = "Description is missing";
			}
		}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = 'Warning: Please check the form carefully for errors!';
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	protected function getList()
	{

		$data = $this->language->getAll();
		$url = '';
		$data['breadcrumbs'][] = array(
			'text' => 'Home Banner',
			'href' => $this->link('blocks', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		$data['add'] = $this->link('blocks/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->link('blocks/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['users'] = array();
		$filter_data = array(
			'order' => $order,
		);
		$results = $this->model_block->getSliders($filter_data);
		foreach ($results as $result) {
			$data['blocks'][] = array(
				'block_id'     => $result['id'],
				'image'   	 	=> $result['image'],
				'title'		 	=> $result['title'],
				'content'		 	=> $result['content'],
				'on_page'   => $result['on_page'],
				'unique_text'   => $result['unique_text'],
				'publish' 		=> $result['publish'],
				'edit'       	=> $this->link('blocks/edit', 'token=' . $this->session->data['token'] . '&block_id=' . $result['id'] . $url, 'SSL'),
				'delete'       	=> $this->link('blocks/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
			);
		}
		$data['main_block'] = $results;
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
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}
		$data['groupby'] = 1;
		$url = '';
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$data['sort_status'] = $this->link('blocks', 'token=' . $this->session->data['token'] . '&sort=publish' . $url, 'SSL');
		$data['sort_date_added'] = $this->link('blocks', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, 'SSL');
		$url = '';
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
		$data['ajaxBlockStatusUpdate'] = $this->link('blocks/ajaxBlockStatusUpdate', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$bannerTotal = $this->model_block->getTotalBanners();
		$pagination = new Pagination();
		$pagination->total = $bannerTotal;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = HTTP_HOST.'?controller=blocks/&token='.$this->session->data['token']. $url . '&page={page}';
		$data['pagination'] = $pagination->render();
		$data['results'] = sprintf($this->language->get('text_pagination'), ($bannerTotal) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($bannerTotal - $this->config->get('config_limit_admin'))) ? $bannerTotal : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $bannerTotal, ceil($bannerTotal / $this->config->get('config_limit_admin')));
		$data['ajaxUrl'] = HTTP_HOST . '?controller=blocks';
		$data['token'] = $this->session->data['token'];
		$this->data = $data;
		$this->template = 'modules/blocks/list.tpl';
		$this->zones = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}

	public function ajaxBlockStatusUpdate()
	{
		$json = array();
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$blockId = intval($this->request->post['id']);
			$newStatus = intval($this->request->post['status']);
			$this->load_model('block');
			$this->model_block->updateBlockStatusUpdate($blockId, $newStatus);
			$json = array('success' => true);
			$this->response->addHeader('Content-Type: application/json');

			$this->response->setOutput(json_encode($json));
		} else {
			$json = array('success' => false);
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
		}
	}
	protected function validateDelete()
	{

		if (!$this->user->hasPermission('modify', 'blocks')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		

		return !$this->error;
	}
}