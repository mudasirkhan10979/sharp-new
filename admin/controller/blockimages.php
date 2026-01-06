<?php
class ControllerBlockImages extends Controller
{
	private $error = array();
	public function index()
	{
		$data = $this->language->getAll();
		$this->document->setTitle('Admin - Block Images');
		$this->load_model('blockimages');
		$this->getList();
	}
	public function add()
	{
		// exit('here');
		$this->document->setTitle('Admin - Block Images');
		$this->load_model('blockimages');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_blockimages->addBlockImage($this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have added a new Block Image!');
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
			$this->response->redirect($this->link('blockimages', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		  }
		$this->getForm();
	}
	public function edit()
	{
		$this->document->setTitle('Admin - Block Images');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->load_model('blockimages');
			$this->model_blockimages->editBlockImage($this->request->get['block_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have modified Block Image!');
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
			$this->response->redirect($this->link('blockimages', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}
	public function delete()
	{
		$this->load_model('blockimages');
		if($this->validateDelete() && $this->request->post['block_id']){
			$this->model_blockimages->deleteBlockImage($this->request->post['block_id']);
			$this->session->data['success'] = $this->language->get('Success: You have deleted Block Image!');
			$this->response->redirect($this->link('blockimages', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->getList();
	}
	protected function getForm()
	{
		$data = $this->language->getAll();
		$data['text_form'] = !isset($this->request->get['block_id']) ? 'Add New Block Image' : 'Edit Block Image';

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		if (isset($this->error['title'])) {
			$data['error_blocktitle'] = $this->error['title'];
		} else {
			$data['error_blocktitle'] = '';
		}
		if (isset($this->error['on_page'])) {
			$data['error_pagename'] = $this->error['on_page'];
		} else {
			$data['error_pagename'] = '';
		}
		if (isset($this->error['unique_text'])) {
			$data['error_blockspecificname'] = $this->error['unique_text'];
		} else {
			$data['error_blockspecificname'] = '';
		}
		if (isset($this->error['image'])) {
            $data['error_image'] = $this->error['image'];
        } else {
            $data['error_image'] = '';
        }
		$url = '';
		$data['breadcrumbs'][] = array(
			'text' => "Home Banner",
			'href' => $this->link('blockimages', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		if (!isset($this->request->get['block_id'])) {
			$data['action'] = $this->link('blockimages/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->link('blockimages/edit', 'token=' . $this->session->data['token'] . '&block_id=' . $this->request->get['block_id'] . $url, 'SSL');
		}
		$data['cancel'] = $this->link('blockimages', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['block_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$this->load_model('blockimages');
			$block_info = $this->model_blockimages->getBlocks($this->request->get['block_id']);
		}
		$data['single_slider'] = $block_info;
		$db_filter = [
			'order' => 'DESC'
		];
		$this->load_model('language');
		$data['languages'] = $this->model_language->getLanguages($db_filter);
		if (isset($this->request->post['block_images_description'])) {
			$data['block_images_description'] = $this->request->post['block_images_description'];
	
		} elseif (isset($this->request->get['block_id'])) {
			$data['block_images_description'] = $this->model_blockimages->getBlockImageDescriptions($this->request->get['block_id']);
		} else {
			$data['block_images_description'] = array();
		}
	    if (isset($this->request->post['block_id'])) {
			$data['block_id'] = $this->request->post['block_id'];
		} elseif (!empty($block_info)) {
			$data['block_id'] = $block_info['id'];
		} else {
			$data['block_id'] = '';
		}
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($block_info)) {
			$data['sort_order'] = $block_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
         if (isset($this->request->post['image'])) {
            $data['image'] = $this->request->post['image'];
        } elseif (!empty($block_info)) {
            $data['image'] = $block_info['image'];
        } else {
            $data['image'] = '';
        }

		if (isset($this->request->post['publish'])) {
			$data['publish'] = $this->request->post['publish'];
		} elseif (!empty($block_info)) {
			$data['publish'] = $block_info['publish'];
		} else {
			$data['publish'] = true;
		}
        $data['deleteImage'] = $this->link('blockimages/deleteImage', 'token=' . $this->session->data['token'], 'SSL');
		$this->data = $data;
		$this->template = 'modules/blockimages/form.tpl';
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
		foreach ($data['block_images_description'] as $language_id => $value) {
			if ((utf8_strlen(trim($value['title'])) < 1)) {
				$this->error['title'][$language_id] = "Title field is missing";
			}
			if ((utf8_strlen(trim($value['unique_text'])) < 1)) {
				$this->error['unique_text'][$language_id] = "Page name where display is missing";
			}
			if ((utf8_strlen(trim($value['on_page'])) < 1)) {
				$this->error['on_page'][$language_id] = "Block specific name is missing";
			}
		}


		if (!$this->request->get['block_id']) {
			if ($_FILES["image"]["name"] == "") {
				$this->error['image'] = 'Please upload Block Image';
			}
		} else {
			$existingImage = isset($this->request->post['hidden_image']) ? $this->request->post['hidden_image'] : '';
			if (empty($existingImage) && $_FILES["image"]["name"] == "") {
				$this->error['image'] = 'Please upload Block Image';
			}
		}
          
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = ' Warning: Please check the form carefully for errors!';
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
			'href' => $this->link('blockimages', 'token=' . $this->session->data['token'] . $url, 'SSL')
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
		$data['add'] = $this->link('blockimages/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->link('blockimages/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['users'] = array();
		$filter_data = array(
			'order' => $order,
		);
		$results = $this->model_blockimages->getBlockImages($filter_data);
		foreach ($results as $result) {
			$data['blockimages'][] = array(
				'block_id'     => $result['id'],
				'image'   	 	=> $result['image'],
				'publish'   	=> $result['publish'],
				'title'		 	=> $result['title'],
				'on_page'       => $result['on_page'],
				'unique_text'   => $result['unique_text'],
				'edit'       	=> $this->link('blockimages/edit', 'token=' . $this->session->data['token'] . '&block_id=' . $result['id'] . $url, 'SSL'),
				'delete'       	=> $this->link('blockimages/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
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
		$data['sort_status'] = $this->link('blockimages', 'token=' . $this->session->data['token'] . '&sort=publish' . $url, 'SSL');
		$data['sort_date_added'] = $this->link('blockimages', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, 'SSL');
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
		$data['ajaxBlockImagesStatusUpdate'] = $this->link('blockimages/ajaxBlockImagesStatusUpdate', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$bannerTotal = $this->model_blockimages->getTotalBlockImages();
		$pagination = new Pagination();
		$pagination->total = $bannerTotal;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = HTTP_HOST.'?controller=blockimages/&token='.$this->session->data['token']. $url . '&page={page}';
		$data['pagination'] = $pagination->render();
		$data['results'] = sprintf($this->language->get('text_pagination'), ($bannerTotal) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($bannerTotal - $this->config->get('config_limit_admin'))) ? $bannerTotal : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $bannerTotal, ceil($bannerTotal / $this->config->get('config_limit_admin')));
		$data['ajaxUrl'] = HTTP_HOST . '?controller=blockimages';
		$data['token'] = $this->session->data['token'];
		$this->data = $data;
		$this->template = 'modules/blockimages/list.tpl';
		$this->zones = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}

	public function ajaxBlockImagesStatusUpdate()
	{
		$json = array();
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$blockId = intval($this->request->post['id']);
			$newStatus = intval($this->request->post['status']);
			$this->load_model('blockimages');
			$this->model_blockimages->updateBlockImagesStatusUpdate($blockId, $newStatus);
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

		if (!$this->user->hasPermission('modify', 'blockimages')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		

		return !$this->error;
	}

	public function deleteImage()
    {
        $this->load_model('blockimages');
        $block_id = (int)$this->request->get['block_id'];

        if ($block_id) {
            $result = $this->model_blockimages->deleteBlocksImage($block_id);
            if (isset($result['success'])) {
                $json = ['success' => true];
            } else {
                $json = ['error' => $result['error']];
            }
        } else {
            $json = ['error' => 'Invalid Block ID.'];
        }

        header('Content-Type: application/json');
        echo json_encode($json);
        exit;
    }
}