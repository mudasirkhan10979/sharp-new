<?php
class ControllerCaseStudy extends Controller
{
	private $error = array();

	public function index()
	{
		$data = $this->language->getAll();
		$this->document->setTitle('Admin - Case Study');
		$this->load_model('casestudy');
		$this->getList();
	}
	public function add()
	{

		$this->document->setTitle('Admin - Case Study');
		$this->load_model('casestudy');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_casestudy->addCaseStudy($this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have added a new Case Study!');
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
			$this->response->redirect($this->link('casestudy', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function edit()
	{

		$this->document->setTitle('Admin - Case Study');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->load_model('casestudy');
			$this->model_casestudy->editCaseStudy($this->request->get['case_study_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have modified Case Study!');
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
			$this->response->redirect($this->link('casestudy', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete()
	{

		$this->load_model('casestudy');
		$this->model_casestudy->deleteCaseStudy($this->request->post['case_study_id']);
		$this->getList();
	}
	protected function getForm()
	{
		$data = $this->language->getAll();
		$data['text_form'] = !isset($this->request->get['case_study_id']) ? 'Add New Case Study' : 'Edit Case Study';

		$data['is_edit'] = !isset($this->request->get['case_study_id']) ? "no" : "yes";

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

		if (isset($this->error['tag'])) {
			$data['error_tag'] = $this->error['tag'];
		} else {
			$data['error_tag'] = '';
		}
		if (isset($this->error['short_description'])) {
			$data['error_short_description'] = $this->error['short_description'];
		} else {
			$data['error_short_description'] = '';
		}
		// if (isset($this->error['description'])) {
		// 	$data['error_description'] = $this->error['description'];
		// } else {
		// 	$data['error_description'] = '';
		// }

		if (isset($this->error['seo_url'])) {
			$data['error_seo_url'] = $this->error['seo_url'];
		} else {
			$data['error_seo_url'] = '';
		}
		if (isset($this->error['thumbnail'])) {
			$data['error_thumbnail'] = $this->error['thumbnail'];
		} else {
			$data['error_thumbnail'] = '';
		}
		if (isset($this->error['banner_image'])) {
			$data['error_banner_image'] = $this->error['banner_image'];
		} else {
			$data['error_banner_image'] = '';
		}
		if (isset($this->error['case_study_image'])) {
			$data['error_case_study_image'] = $this->error['case_study_image'];
		} else {
			$data['error_case_study_image'] = '';
		}
        // echo '<pre>'; print_r($data['error_case_study_image']); echo '</pre>'; exit;
		$url = '';

		if (!isset($this->request->get['case_study_id'])) {
			$data['action'] = $this->link('casestudy/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->link('casestudy/edit', 'token=' . $this->session->data['token'] . '&case_study_id=' . $this->request->get['case_study_id'] . $url, 'SSL');
		}
		$data['cancel'] = $this->link('casestudy', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['case_study_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$this->load_model('casestudy');
			$case_study_info = $this->model_casestudy->getCaseStudy($this->request->get['case_study_id']);
		}
		$data['case_studies'] = $case_study_info;

		$db_filter = [
			'order' => 'DESC'
		];

		$this->load_model('language');
		$data['languages'] = $this->model_language->getLanguages($db_filter);


		if (isset($this->request->post['case_study_description'])) {
			$data['case_study_description'] = $this->request->post['case_study_description'];
		} elseif (isset($this->request->get['case_study_id'])) {
			$data['case_study_description'] = $this->model_casestudy->getCaseStudyDescriptions($this->request->get['case_study_id']);
		} else {
			$data['case_study_description'] = array();
		}

		if (isset($this->request->post['case_study_id'])) {
			$data['case_study_id'] = $this->request->post['case_study_id'];
		} elseif (!empty($case_study_info)) {
			$data['case_study_id'] = $case_study_info['case_study_id'];
		} else {
			$data['case_study_id'] = '';
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($case_study_info)) {
			$data['sort_order'] = $case_study_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($case_study_info)) {
			$data['status'] = $case_study_info['publish'];
		} else {
			$data['status'] = true;
		}
		if (isset($this->request->post['thumbnail'])) {
			$data['thumbnail'] = $this->request->post['thumbnail'];
		} elseif (!empty($case_study_info)) {
			$data['thumbnail'] = $case_study_info['thumbnail'];
		} else {
			$data['thumbnail'] = '';
		}
		if (isset($this->request->post['banner_image'])) {
			$data['banner_image'] = $this->request->post['banner_image'];
		} elseif (!empty($case_study_info)) {
			$data['banner_image'] = $case_study_info['banner_image'];
		} else {
			$data['banner_image'] = '';
		}
		if (isset($this->request->post['featured'])) {
			$data['featured'] = $this->request->post['featured'];
		} elseif (!empty($case_study_info)) {
			$data['featured'] = $case_study_info['mark_feature'];
		} else {
			$data['featured'] = false;
		}
		if (isset($this->request->post['seo_url'])) {
			$data['seo_url'] = $this->request->post['seo_url'];
		} elseif (!empty($case_study_info)) {

			$data['seo_url'] = $case_study_info['seo_url'];
		} else {
			$data['seo_url'] = '';
		}
		// if (isset($this->request->post['categories'])) {
		// 	$categories = $this->request->post['categories'];
		// } elseif (isset($this->request->get['case_study_id'])) {
		// 	$this->load_model('casestudy');
		// 	$categories = $this->model_casestudy->getCaseStudyCategories($this->request->get['case_study_id']);
		// } else {
		// 	$categories = array();
		// }
		// $data['categories'] = array();
		// if (!empty($categories)) {

		// 	foreach ($categories as $category_id) {
		// 		$this->load_model('casestudycategories');
		// 		$categories_info2 = $this->model_casestudycategories->getCSCategory($category_id);
		// 		if ($categories_info2) {
		// 			$data['categories'][] = array(
		// 				'category_id' => $categories_info2['cs_category_id'],
		// 				'title'      =>  $categories_info2['path'] . ' &gt; ' . $categories_info2['title']
		// 			);
		// 		}
		// 	}
		// }

		if (isset($this->request->post['case_study_image'])) {
			$case_study_images = $this->request->post['case_study_image'];
		} elseif (isset($this->request->get['case_study_id'])) {
			$case_study_images = $this->model_casestudy->getCaseStudyImages($this->request->get['case_study_id']);
		} else {
			$case_study_images = array();
		}

		$data['case_study_images'] = array();

		foreach ($case_study_images as $case_study_image) {
			if (is_file(DIR_IMAGE . 'case_study/' . $case_study_image['image'])) {
				$image = $case_study_image['image'];
				$thumb = '../uploads/image/case_study/' . $case_study_image['image'];
			} else {
				$image = '';
				$thumb = '../uploads/image/no-image.png';
			}

			$data['case_study_images'][] = array(
				'image'      => $image,
				'thumb'      => $thumb,
				'sort_order' => $case_study_image['sort_order']
			);
		}

		$data['token'] = $this->session->data['token'];
		$data['deleteImage'] = $this->link('casestudy/deleteImage', 'token=' . $this->session->data['token'] . $url, 'SSL');
		// $data['token'] = $this->session->data['token'];
		$this->data = $data;
		$this->template = 'modules/casestudy/form.tpl';
		$this->zones = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}

	protected function validateForm()
	{
		$data = $this->request->post;

		foreach ($data['case_study_description'] as $language_id => $value) {
			if ((utf8_strlen(trim($value['title'])) < 1)) {
				$this->error['title'][$language_id] = "Title field is missing";
			}
			if ((utf8_strlen(trim($value['tag'])) < 1)) {
				$this->error['tag'][$language_id] = "Tag field is missing";
			}
			if ((utf8_strlen(trim($value['short_description'])) < 1)) {
				$this->error['short_description'][$language_id] = "Short Description field is missing";
			}
			// if ((utf8_strlen(trim($value['description'])) < 1)) {
			// 	$this->error['description'][$language_id] = "Description field is missing";
			// }
		}

		if (isset($this->request->post['case_study_image']) && !empty($this->request->post['case_study_image'])) {
			foreach ($this->request->post['case_study_image'] as $option_value_id1 => $option_value1) {
				if ((utf8_strlen($option_value1['image']) < 1)) {
					$this->error['case_study_image'][$option_value_id1]['image'] = "Image is missing.";
				}
			}
		}
		//  else {
		// 	$this->error['gallery_images_main'] = "Please add at least one image.";
		// }

		$this->load_model('seourl');
		if ($data['seo_url'] != "") {
			$keyword = $this->model_seourl->seoUrl($data['seo_url']);
		}
		if ($keyword != '') {
			$this->load_model('seourl');
			$seo_urls = $this->model_seourl->getSeoUrlsByKeyword($keyword);

			foreach ($seo_urls as $seo_url) {

				if (($this->request->get['case_study_id'] != $seo_url['slog_id'] || ($seo_url['slog'] != 'casestudies/detail'))) {
					$this->error['seo_url'] = "This url is already been used";
					break;
				}
			}
		}



           if (!$this->request->get['case_study_id']) {
				if ($_FILES["banner_image"]["name"] == "") {
					$this->error['banner_image'] = 'Please upload middle image';
				}
			} else {
				if ($data["banner_image"] == "" && $_FILES["banner_image"]["name"] == "") {
					$this->error['banner_image'] = 'Please upload middle image';
				}
			}
        

            if (!$this->request->get['case_study_id']) {
				if ($_FILES["thumbnail"]["name"] == "") {
					$this->error['thumbnail'] = 'Please upload thumbnail';
				}
			} else {
				if ($data["thumbnail"] == "" && $_FILES["thumbnail"]["name"] == "") {
					$this->error['thumbnail'] = 'Please upload thumbnail';
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


	protected function getList()
	{

		$data = $this->language->getAll();

		$url = '';

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
		$data['add'] = $this->link('casestudy/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->link('casestudy/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['case_studies'] = array();
		$filter_data = array(
			'order' => $order,
		);
		$results = $this->model_casestudy->getCaseStudies($filter_data);

		foreach ($results as $result) {
			$data['case_studies'][] = array(
				'case_study_id'     => $result['case_study_id'],
				'title'		 	=> $result['title'],
				'sort_order'    => $result['sort_order'],
				'status' 		=> $result['publish'],
				'edit'       	=> $this->link('casestudy/edit', 'token=' . $this->session->data['token'] . '&case_study_id=' . $result['case_study_id'] . $url, 'SSL'),
				'delete'       	=> $this->link('casestudy/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
			);
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



		$data['ajaxcasestudystatus'] = $this->link('casestudy/ajaxcasestudystatus', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['token'] = $this->session->data['token'];

		$this->data = $data;

		$this->template = 'modules/casestudy/list.tpl';

		$this->zones = array(
			'header',
			'columnleft',
			'footer'
		);

		$this->response->setOutput($this->render());
	}

	public function ajaxcasestudystatus()
	{
		$json = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->load_model('casestudy');
			$case_study_id = $this->request->post['case_study_id'];
			$status = $this->request->post['status'];
			$stat = $this->model_casestudy->updateCaseStudyStatus($case_study_id, $status);
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


	public function uploadImages()
	{
		if (!empty($_FILES["image"]["name"])) {
			$targetDirectory = DIR_IMAGE . "case_study/";
			$filename = time();
			$path = $_FILES['image']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			$filename = time();

			$targetFile = $targetDirectory . $filename . '.' . $ext;
			if (!is_dir($targetDirectory)) {
				mkdir($targetDirectory, 0755);
			}
			if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
				$json['success'] = true;
				$json['filename'] = $filename . '.' . $ext;
			} else {
				$json['success'] = false;
			}
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}


	  public function deleteImage() {
      $json = [];

    if (isset($this->request->get['type']) && isset($this->request->get['case_study_id'])) {
        $type = $this->request->get['type'];
        $case_study_id = (int)$this->request->get['case_study_id'];
        $this->load_model('casestudy');
        $result = $this->model_casestudy->deleteCaseStudyImage($case_study_id, $type);
        if (isset($result['success'])) {
            $json['success'] = true;
        } else {
            $json['error'] = $result['error'] ?? 'Unknown error occurred.';
        }
    } else {
        $json['error'] = 'Invalid request parameters.';
    }

    // Return JSON response
    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
}

}
