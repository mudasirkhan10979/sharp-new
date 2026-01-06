<?php
class ControllerCategories extends Controller
{
	private $error = array();
	public function index()
	{
		$data = $this->language->getAll();
		$this->document->setTitle('Admin - Categories');
		$this->load_model('categories');
		$this->getList();
	}
	public function add()
	{
		$this->document->setTitle('Admin - Categories');
		$this->load_model('categories');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_categories->addCategory($this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have added a new category!');
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
			$this->response->redirect($this->link('categories', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}
	public function edit()
	{
		$this->document->setTitle('Admin - Categories');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->load_model('categories');
			$this->model_categories->editCategory($this->request->get['category_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have modified category!');
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
			$this->response->redirect($this->link('categories', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}
	public function delete()
	{

		$this->load_model('categories');
		if($this->request->post['category_id'] && $this->validateDelete()) {
			$this->model_categories->deleteCategory($this->request->post['category_id']);
			$this->session->data['success'] = $this->language->get('Success: You have deleted Category!');
			$this->response->redirect($this->link('categories', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getList();
	}
	protected function getForm()
	{
		$data = $this->language->getAll();
		$data['text_form'] = !isset($this->request->get['category_id']) ? 'Add New Category' : 'Edit Category';
		$data['is_edit'] = !isset($this->request->get['category_id']) ? "no" : "yes";
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
		// if (isset($this->error['type'])) {
		// 	$data['error_type'] = $this->error['type'];
		// } else {
		// 	$data['error_type'] = '';
		// }
		if (isset($this->error['parent'])) {
			$data['error_parent'] = $this->error['parent'];
		} else {
			$data['error_parent'] = '';
		}
		$url = '';
		if (!isset($this->request->get['category_id'])) {
			$data['action'] = $this->link('categories/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->link('categories/edit', 'token=' . $this->session->data['token'] . '&category_id=' . $this->request->get['category_id'] . $url, 'SSL');
		}
		$data['cancel'] = $this->link('categories', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['category_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$this->load_model('categories');
			$categories_info = $this->model_categories->getSCCategory($this->request->get['category_id']);
		}
		$db_filter = [
			'order' => 'DESC'
		];
		$this->load_model('language');
		$data['languages'] = $this->model_language->getLanguages($db_filter);
		if (isset($this->request->post['sc_categories_description'])) {
			$data['sc_categories_description'] = $this->request->post['sc_categories_description'];
		} elseif (isset($this->request->get['category_id'])) {
			$data['sc_categories_description'] = $this->model_categories->getCategoryDescriptions($this->request->get['category_id']);
		} else {
			$data['sc_categories_description'] = array();
		}
		if (isset($this->request->post['category_id'])) {
            $data['category_id'] = $this->request->post['category_id'];
        } elseif (!empty($categories_info)) {
            $data['category_id'] = $categories_info['category_id'];
        } else {
            $data['category_id'] = '';
        }
		if (isset($this->request->post['path'])) {
            $data['path'] = $this->request->post['path'];
        } elseif (!empty($categories_info)) {
            $data['path'] = $categories_info['path'];
        } else {
            $data['path'] = '';
        }
		if (isset($this->request->post['parent_id'])) {
            $data['parent_id'] = (int)$this->request->post['parent_id'];
        } elseif (!empty($categories_info)) {
            $data['parent_id'] = $categories_info['parent_id'];
        } else {
            $data['parent_id'] = 0;
        }
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($categories_info)) {
			$data['sort_order'] = $categories_info['sort_order'];
	
		} else {
			$data['sort_order'] = '';
		}
		// if (isset($this->request->post['home_status'])) {
		// 	$data['home_status'] = $this->request->post['home_status'];
		// } elseif (!empty($categories_info)) {
		// 	$data['home_status'] = $categories_info['home_status'];
		// } else {
		// 	$data['home_status'] = '';
		// }
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($categories_info)) {
			$data['status'] = $categories_info['status'];

		} else {
			$data['status'] = true;
		}
		if (isset($this->request->post['featured'])) {
			$data['featured'] = $this->request->post['featured'];
		} elseif (!empty($categories_info)) {
			$data['featured'] = $categories_info['featured'];
		} else {
			$data['featured'] = false;
		}
		// if (isset($this->request->post['type'])) {
		// 	$data['type'] = $this->request->post['type'];
		// } elseif (!empty($categories_info)) {
		// 	$data['type'] = $categories_info['type'];
		// } else {
		// 	$data['type'] = false;
		// }
		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($categories_info)) {
			$data['image'] = $categories_info['image'];
		} else {
			$data['image'] = '';
		}
		if (isset($this->request->post['feature_image'])) {
			$data['feature_image'] = $this->request->post['feature_image'];
		} elseif (!empty($categories_info)) {
			$data['feature_image'] = $categories_info['feature_image'];
		} else {
			$data['feature_image'] = '';
		}
		if (isset($this->request->post['seo_url'])) {
			$data['seo_url'] = $this->request->post['seo_url'];
		} elseif (!empty($categories_info)) {
			$data['seo_url'] = $categories_info['seo_url'];

		} else {
			$data['seo_url'] = false;
		}
	    if (isset($this->request->post['show_on_home'])) {
			$data['show_on_home'] = $this->request->post['show_on_home'];
		} elseif (!empty($categories_info)) {
			$data['show_on_home'] = $categories_info['show_on_home'];
		} else {
			$data['show_on_home'] = '';
		}
		if (isset($this->request->post['show_on_footer'])) {
			$data['show_on_footer'] = $this->request->post['show_on_footer'];
		} elseif (!empty($categories_info)) {
			$data['show_on_footer'] = $categories_info['show_on_footer'];
		} else {
			$data['show_on_footer'] = '';
		}
		if (isset($this->request->post['show_on_header'])) {
			$data['show_on_header'] = $this->request->post['show_on_header'];
		} elseif (!empty($categories_info)) {
			$data['show_on_header'] = $categories_info['show_on_header'];
		} else {
			$data['show_on_header'] = '';
		}
		$data['token'] = $this->session->data['token'];
		$data['deleteImage'] = $this->link('categories/deleteImage', 'token=' . $this->session->data['token'], 'SSL');
		$this->data = $data;
		$this->template = 'modules/categories/form.tpl';
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
		$this->load_model('categories');
		foreach ($data['sc_categories_description'] as $language_id => $value) {
			if ((utf8_strlen(trim($value['title'])) < 1)) {
				$this->error['title'][$language_id] = "Title field is missing";
			}
		}
        if (isset($this->request->get['category_id']) && $this->request->post['parent_id']) {
            $results = $this->model_categories->getPath($this->request->post['parent_id']);

            foreach ($results as $result) {
                if ($result['path_id'] == $this->request->get['category_id']) {
                    $this->error['parent'] = 'The parent category you have chosen is a child of the current one!';
                    break;
                }
            }
        }

		//opencart framework flow start
		$this->load_model('seourl');
		if ($data['seo_url'] != "") {

			$keyword = $this->model_seourl->seoUrl($data['seo_url']);
		}

		 if ($keyword != '') {
			
			$this->load_model('seourl');
			$seo_urls = $this->model_seourl->getSeoUrlsByKeyword($keyword);
			
			foreach ($seo_urls as $seo_url) {

				if ($seo_url['slog'] == 'category_id=' . $this->request->get['category_id']) {
					continue; // This is our own record, skip it
				}
				
				if (isset($this->request->get['category_id']) && strpos($seo_url['slog'], 'category_id=') !== false) {
					$this->error['seo_url'] = "This URL is already in use";
					break;
				}
				
				if (!isset($this->request->get['category_id']) && strpos($seo_url['slog'], 'category_id=') !== false) {
					$this->error['seo_url'] = "This URL is already in use";
					break;
				}
				
				// For any other query that's not category-related
				if (strpos($seo_url['slog'], 'category_id=') === false) {
					$this->error['seo_url'] = "This URL is already in use";
					break;
				}
			}
		}

		//end

		// $this->load_model('seourl');
		// if ($data['seo_url'] != "") {
		// 	$keyword = $this->model_seourl->seoUrl($data['seo_url']);
		// }
		// if ($keyword != '') {
		// 	$this->load_model('seourl');
		// 	$seo_urls = $this->model_seourl->getSeoUrlsByKeyword($keyword);
		// 	foreach ($seo_urls as $seo_url) {
		// 		if (($this->request->get['category_id'] != $seo_url['slog_id'] || ($seo_url['slog'] != 'categories/detail'))) {
		// 			$this->error['seo_url'] = "This url is already been used";
		// 			break;
		// 		}
		// 	}
		// }

		// if ((utf8_strlen(trim($this->request->post['type'])) < 1)) {
		// 	$this->error['type'] = "Please select any type of category";
		// }
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
		$this->load_model('categories');
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
		$data['add'] = $this->link('categories/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['sc_categories'] = array();
		$filter_data = array(
			'order' => $order,
		);
		$results = $this->model_categories->getCategories($filter_data);
	    // echo '<pre>'; print_r($results); echo '</pre>'; exit;
		foreach ($results as $result) {
			$data['sc_categories'][] = array(
				'category_id'=> $result['category_id'],
				'title'		 	=> $result['title'],
				'sort_order'	=> $result['sort_order'],
				'status' 		=> $result['status'],
				'featured' 		=> $result['featured'],
				'edit'       	=> $this->link('categories/edit', 'token=' . $this->session->data['token'] . '&category_id=' . $result['category_id'] . $url, 'SSL'),
				'delete'       	=> $this->link('categories/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
			);
		}
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		if (isset($this->error['seo_url'])) {
			$data['error_seo_url'] = $this->error['seo_url'];
		} else {
			$data['error_seo_url'] = '';
		}
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		$data['ajaxupdatecategorystatus'] = $this->link('categories/ajaxupdatecategorystatus', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['token'] = $this->session->data['token'];
		$this->data = $data;
		$this->template = 'modules/categories/list.tpl';
		$this->zones = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}

	protected function validateDelete()
	{

		if (!$this->user->hasPermission('modify', 'categories')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		return !$this->error;
	}

	public function ajaxupdatecategorystatus()
	{
		$json = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->load_model('categories');
			$category_id = $this->request->post['category_id'];
			$status = $this->request->post['status'];
			$stat = $this->model_categories->updateCategoryStatus($category_id, $status);
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


	public function autocomplete() {
        $json = [];

        if (isset($this->request->get['filter_title'])) {
            // Categories
			$this->load_model('categories');

            $filter_data = [
                'filter_title' => $this->request->get['filter_title'],
                // 'type'         => $this->request->get['type'],
                'sort'         => 'title',
                'order'        => 'ASC',
                'start'        => 0,
                'limit'        => 800
            ];
            $results = $this->model_categories->getCategories($filter_data);
            foreach ($results as $result) {
                $json[] = [
                    'category_id' => $result['category_id'],
                    'title'        => $result['title']
                ];
            }
        }
        $sort_order = [];
        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['title'];
        }
        array_multisort($sort_order, SORT_ASC, $json);
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

public function deleteImage() {
    $this->load_model('categories');
    
    // Use POST data
    $category_id = isset($this->request->post['category_id']) ? (int)$this->request->post['category_id'] : 0;
    $type = isset($this->request->post['type']) ? $this->request->post['type'] : 'main';
    $json = [];
    if ($category_id) {
        $result = $this->model_categories->deleteCategoryImage($category_id, $type);
        if (!empty($result['success'])) {
            $json = ['success' => true];
        } else {
            $json = ['error' => $result['error'] ?? 'Error deleting image'];
        }
    } else {
        $json = ['error' => 'Invalid Category ID.'];
    }

    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
}

}
