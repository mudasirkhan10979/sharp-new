<?php
class ControllerSliders extends Controller
{
	private $error = array();
	public function index()
	{
		$data = $this->language->getAll();
		$this->document->setTitle('Admin - Home Slider');
		$this->load_model('sliders');
		$this->getList();
	}
	protected function getList()
	{
		$data = $this->language->getAll();
		$url = '';
		$data['breadcrumbs'][] = array(
			'text' => 'Home Banner',
			'href' => $this->link('sliders', 'token=' . $this->session->data['token'] . $url, 'SSL')
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
		$data['add']    = $this->link('sliders/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->link('sliders/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['users'] = array();
		$filter_data = array(
			'order' => $order,
		);
		$results = $this->model_sliders->getSliders($filter_data);
		foreach ($results as $result) {
			$data['sliders'][] = array(
				'slider_id'   => $result['id'],
				'sort_order'  => $result['sort_order'],
				'title'   	  => $result['title'],
				'image'       => $result['image'],
				'status'     => $result['status'],
				'edit'        => $this->link('sliders/edit', 'token=' . $this->session->data['token'] . '&slider_id=' . $result['id'] . $url, 'SSL'),
				'delete'      => $this->link('sliders/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
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
		$url = '';
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$data['sort_status'] = $this->link('sliders', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		$data['sort_date_added'] = $this->link('sliders', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, 'SSL');
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
		$data['ajaxsliderstatus'] = $this->link('sliders/ajaxsliderstatus', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$sliderTotal        = $this->model_sliders->getTotalSliders();
		$pagination         = new Pagination();
		$pagination->total  = $sliderTotal;
		$pagination->page   = $page;
		$pagination->limit  = $this->config->get('config_limit_admin');
		$pagination->url    = HTTP_HOST . '?controller=sliders/&token=' . $this->session->data['token'] . $url . '&page={page}';
		$data['pagination'] = $pagination->render();
		$data['results']    = sprintf($this->language->get('text_pagination'), ($sliderTotal) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($sliderTotal - $this->config->get('config_limit_admin'))) ? $sliderTotal : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $sliderTotal, ceil($sliderTotal / $this->config->get('config_limit_admin')));
		$data['ajaxUrl']    = HTTP_HOST . '?controller=sliders';
		$data['token']      = $this->session->data['token'];
		$this->data         = $data;
		$this->template     = 'modules/sliders/list.tpl';
		$this->zones        = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}
	public function add()
	{
		$this->document->setTitle('Admin - Home Slider');

		$this->load_model('sliders');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_sliders->addSlider($this->request->post);

			$this->session->data['success'] = $this->language->get('Success: You have added a new Home Slider!');

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
			$this->response->redirect($this->link('sliders', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}
	protected function validateForm()
	{
		if (!$this->user->hasPermission('modify', 'sliders')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		$error_video_url = 'Video URL field is missing';
		$error_content_type = 'Please select content type';
		$data = $this->request->post;
		$url_pattern = "/\b((http[s]?:\/\/)?[^\s(['\"<,>]*\.[^\s[\",><]*[^\s`!()\[\]{};:'\".,<>?«»“”‘’])\b/";
		foreach ($data['slider_description'] as $language_id => $value) {
			if ((utf8_strlen(trim($value['title'])) < 1)) {
				$this->error['title'][$language_id] = "Title field is missing";
			}
			if ((utf8_strlen(trim($value['second_title'])) < 1)) {
				$this->error['second_title'][$language_id] = "Second Title field is missing";
			}
			if ((utf8_strlen(trim($value['short_description'])) < 1)) {
				$this->error['short_description'][$language_id] = "Description field is missing";
			}
		}

         if ($this->request->post['content_type'] == 'image') {
			if (!$this->request->get['slider_id']) {
				if ($_FILES["image"]["name"] == "") {
					$this->error['image'] = 'Please upload Slider Image';
				}
			} else {
				if ($data["image"] == "" && $_FILES["image"]["name"] == "") {
					$this->error['image'] = 'Please upload Slider Image';
				}
			}
		}
		if ($this->request->post['content_type'] == 'video') {
			// if ($this->request->post['video_url'] == '') {
			// 	$this->error['video_url'] =  $error_video_url;
			// } 
			if ($this->request->post['video_url'] == '') {
				$this->error['video_url'] =  $error_video_url;
			} elseif (!preg_match($url_pattern, $this->request->post['video_url'])) {
				$this->error['video_url'] = $url_error;
			}
		}
		if ($this->request->post['content_type'] == '') {
			$this->error['content_type'] =  $error_content_type;
		} 

		if (trim($this->request->post['url']) == '') {
			$this->error['url'] = 'URL field is missing';
		} 
		//  elseif (!filter_var($this->request->post['url'], FILTER_VALIDATE_URL)) {
		// 	$this->error['url'] = 'Please enter a valid URL';
		// }

		if (isset($this->request->post['url']) && $this->request->post['url'] != '') {
			if (!preg_match($url_pattern, $this->request->post['url'])) {
				$this->error['url'] = $url_error;
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = ' Warning: Please check the form carefully for errors!';
		}
		// echo '<pre>'; print_r($this->error); exit;
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	public function edit()
	{
		$this->document->setTitle('Admin - Home Slider');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->load_model('sliders');
			$this->model_sliders->editBanner($this->request->get['slider_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have modified Home Slider!');
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
			$this->response->redirect($this->link('sliders', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}
	public function delete()
	{
		$this->load_model('sliders');
		if ($this->request->post['slider_id'] && $this->validateDelete()) {
			$this->model_sliders->deleteSlider($this->request->post['slider_id']);
			$this->session->data['success'] = $this->language->get('Success: You have deleted Home Slider!');
			$this->response->redirect($this->link('sliders', 'token=' . $this->session->data['token'], 'SSL'));
		}
		$this->getList();
	}
	protected function getForm()
	{
		$data = $this->language->getAll();
		$data['text_form'] = !isset($this->request->get['slider_id']) ? 'Add New Home Slider' : 'Edit Home Slider';
		$data['img_feild_required'] = !isset($this->request->get['slider_id']) ? "required" : "";
		$data['is_edit'] = !isset($this->request->get['slider_id']) ? "no" : "yes";
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		if (isset($this->error['title'])) {
			$data['error_title'] = $this->error['title'];
		} else {
			$data['error_title'] = '';
		}
		if (isset($this->error['short_description'])) {
			$data['error_short_description'] = $this->error['short_description'];
		} else {
			$data['error_short_description'] = '';
		}
		if (isset($this->error['second_title'])) {
			$data['error_second_title'] = $this->error['second_title'];
		} else {
			$data['error_second_title'] = '';
		}
		if (isset($this->error['url'])) {
			$data['error_url'] = $this->error['url'];
		} else {
			$data['error_url'] = '';
		}
		if (isset($this->error['image'])) {
			$data['error_image'] = $this->error['image'];
		} else {
			$data['error_image'] = '';
		}
		if (isset($this->error['video_url'])) {
			$data['error_video_url'] = $this->error['video_url'];
		} else {
			$data['error_video_url'] = '';
		}
		if (isset($this->error['content_type'])) {
			$data['error_content_type'] = $this->error['content_type'];
		} else {
			$data['error_content_type'] = '';
		}
		$url = '';
		if (!isset($this->request->get['slider_id'])) {
			$data['action'] = $this->link('sliders/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->link('sliders/edit', 'token=' . $this->session->data['token'] . '&slider_id=' . $this->request->get['slider_id'] . $url, 'SSL');
		}
		$data['cancel'] = $this->link('sliders', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['slider_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$this->load_model('sliders');
			$slider_info = $this->model_sliders->getSlider($this->request->get['slider_id']);
		}
		$data['single_slider'] = $slider_info;
		$db_filter = [
			'order' => 'DESC'
		];
		$this->load_model('language');
		$data['languages'] = $this->model_language->getLanguages($db_filter);
		if (isset($this->request->post['slider_id'])) {
			$data['slider_id'] = $this->request->post['slider_id'];
		} elseif (!empty($slider_info)) {
			$data['slider_id'] = $slider_info['id'];
		} else {
			$data['slider_id'] = '';
		}
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($slider_info)) {
			$data['sort_order'] = $slider_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($slider_info)) {
			$data['status'] = $slider_info['status'];
		} else {
			$data['status'] = true;
		}
		if (isset($this->request->post['url'])) {
			$data['url'] = $this->request->post['url'];
		} elseif (!empty($slider_info)) {
			$data['url'] = $slider_info['url'];
		} else {
			$data['url'] = '';
		}
		if (isset($this->request->post['video_url'])) {
			$data['video_url'] = $this->request->post['video_url'];
		} elseif (!empty($slider_info)) {
			$data['video_url'] = $slider_info['video_url'];
		} else {
			$data['video_url'] = '';
		}
		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($slider_info)) {
			$data['image'] = $slider_info['image'];
		} else {
			$data['image'] = '';
		}
		if (isset($this->request->post['content_type'])) {
			$data['content_type'] = $this->request->post['content_type'];
		} elseif (!empty($slider_info)) {
			$data['content_type'] = $slider_info['content_type'];
		} else {
			$data['content_type'] = '';
		}
		if (isset($this->request->post['slider_description'])) {
			$data['slider_description'] = $this->request->post['slider_description'];
		} elseif (isset($this->request->get['slider_id'])) {
			$data['slider_description'] = $this->model_sliders->getSliderDescription($this->request->get['slider_id']);
		} else {
			$data['slider_description'] = array();
		}
        $data['deleteImage'] = $this->link('sliders/deleteImage', 'token=' . $this->session->data['token'], 'SSL');
		$this->data = $data;
		$this->template = 'modules/sliders/form.tpl';
		$this->zones    = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}
	public function ajaxsliderstatus()
	{
		$json = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->load_model('sliders');
			$slider_id = $this->request->post['slider_id'];
			$status = $this->request->post['status'];
			$stat = $this->model_sliders->updateSliderStatus($slider_id, $status);
			if ($stat) {
				$json['success'] = true;
				$this->response->addHeader('Content-Type: application/json');
				$this->response->setOutput(json_encode($json));
			} else {
				$json['success'] = false;
				$this->response->addHeader('Content-Type: application/json');
				$this->response->setOutput(json_encode($json));
			}
		} else {
			$json['success'] = false;
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
		}
	}
	protected function validateDelete()
	{

		if (!$this->user->hasPermission('modify', 'sliders')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}

		return !$this->error;
	}
	private function isFileSizeValid($file)
	{
		$uploadMaxSize = ini_get('upload_max_filesize');
		$postMaxSize = ini_get('post_max_size');
		$uploadMaxSizeBytes = $this->convertToBytes($uploadMaxSize);
		$postMaxSizeBytes = $this->convertToBytes($postMaxSize);

		// Check if there was no upload error and file size is valid
		if ($file['error'] === UPLOAD_ERR_OK) {
			$fileSize = $file['size'];

			if ($fileSize <= $uploadMaxSizeBytes && $fileSize <= $postMaxSizeBytes) {
				return true;
			}
		}
		return false;
	}
	private function convertToBytes($size)
	{
		$size = trim($size);
		$lastChar = strtolower($size[strlen($size) - 1]);
		$size = (int) $size;

		switch ($lastChar) {
			case 'g':
				$size *= 1024 * 1024 * 1024;
				break;
			case 'm':
				$size *= 1024 * 1024;
				break;
			case 'k':
				$size *= 1024;
				break;
		}
		return $size;
	}

public function deleteImage()
    {
        $this->load_model('sliders');
        $slider_id = (int)$this->request->get['slider_id'];

        if ($slider_id) {
            $result = $this->model_sliders->deleteSliderImage($slider_id);
            if (isset($result['success'])) {
                $json = ['success' => true];
            } else {
                $json = ['error' => $result['error']];
            }
        } else {
            $json = ['error' => 'Invalid slider ID.'];
        }

        header('Content-Type: application/json');
        echo json_encode($json);
        exit;
    }

}



