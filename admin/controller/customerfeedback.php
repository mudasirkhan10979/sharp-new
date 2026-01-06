<?php
class ControllerCustomerFeedback extends Controller
{
    private $error = array();
    public function index()
	{
		$data = $this->language->getAll();
		$this->document->setTitle('Admin - Customer Feedbacks');
		$this->load_model('customerfeedback');
		$this->getList();
	}

    protected function getList()
	{
        $data = $this->language->getAll();
		$data['heading_title'] = 'Customer Feedback';
        $url = '';
		$data['breadcrumbs'][] = array(
			'text' => 'Customer Feedback',
			'href' => $this->link('customerfeedback', 'token=' . $this->session->data['token'] . $url, 'SSL')
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
        $data['add']    = $this->link('customerfeedback/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->link('customerfeedback/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['feedbacks'] = array();
		$filter_data   = array(
			'order' => $order,
		);
		$results       = $this->model_customerfeedback->getCustomerFeedbacks($this->config->get('config_language_id'), $filter_data);
        foreach ($results as $result) {
			$data['feedbacks'][] = array(
				'feedback_id' => $result['id'],
				'title'    => $result['title'],
				'status'    => $result['status'],
				'edit'       => $this->link('customerfeedback/edit', 'token=' . $this->session->data['token'] . '&feedback_id=' . $result['id'] . $url, 'SSL'),
				'delete'     => $this->link('customerfeedback/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
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
		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array) $this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}
        // $data['main_slider'] = $results;
		$data['groupby'] = 1;
		$url             = '';
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$data['sort_status']     = $this->link('customerfeedback', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		$data['sort_date_added'] = $this->link('customerfeedback', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, 'SSL');
        $data['sort_title']   = $this->link('customerfeedback', 'token=' . $this->session->data['token'] . '&sort=title' . $url, 'SSL');
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
		$data['ajaxupdatefeedbackstatus'] = $this->link('customerfeedback/ajaxupdatefeedbackstatus', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$bannerTotal        = $this->model_customerfeedback->getTotalCustomerFeedbacks();
		$pagination         = new Pagination();
		$pagination->total  = $bannerTotal;
		$pagination->page   = $page;
		$pagination->limit  = $this->config->get('config_limit_admin');
		$pagination->url    = HTTP_HOST . '?controller=customerfeedback&token=' . $this->session->data['token'] . $url . '&page={page}';
		$data['pagination'] = $pagination->render();
		$data['results']    = sprintf($this->language->get('text_pagination'), ($bannerTotal) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($bannerTotal - $this->config->get('config_limit_admin'))) ? $bannerTotal : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $bannerTotal, ceil($bannerTotal / $this->config->get('config_limit_admin')));
		$data['ajaxUrl']    = HTTP_HOST . '?controller=customerfeedback&token=' . $this->session->data['token'] . '&action=ajaxupdatefeedbackstatus';
		$data['token']      = $this->session->data['token'];
		$this->data         = $data;
		$this->template     = 'modules/customerfeedback/list.tpl';
		$this->zones        = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
    }

    public function add()
	{
        $this->document->setTitle('Admin - Add Customer Feedbacks');

		$this->load_model('customerfeedback');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_customerfeedback->addCustomerFeedback($this->request->post);

			$this->session->data['success'] = $this->language->get('Success: You have added a new customer feedback!');

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
			$this->response->redirect($this->link('customerfeedback', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
    }

    protected function validateForm()
	{
		if (!$this->user->hasPermission('modify', 'customerfeedback')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		$data = $this->request->post;
        foreach ($data['feedback_description'] as $language_id => $value) {
            if ((utf8_strlen(trim($value['title'])) < 1)) {
                $this->error['title'][$language_id] = "Title field is missing";
            }
            if ((utf8_strlen(trim($value['description'])) < 1)) {
                $this->error['description'][$language_id] = "Description field is missing";
            }
            if ((utf8_strlen(trim($value['designation'])) < 1)) {
                $this->error['designation'][$language_id] = "Designation field is missing";
            }
        }

		if (!$this->request->get['feedback_id']) {
				if ($_FILES["icon"]["name"] == "") {
					$this->error['icon'] = 'Please upload Slider Icon';
				}
			} else {
				if ($data["icon"] == "" && $_FILES["icon"]["name"] == "") {
					$this->error['icon'] = 'Please upload Icon';
				}
			}

		if ($this->error && ! isset($this->error['warning'])) {
			$this->error['warning'] = ' Warning: Please check the form carefully for errors!';
		}
        // echo "<pre>";
        // print_r($this->error);  
        // echo "</pre>";
        // exit;
		if (! $this->error) {
			return true;
		} else {
			return false;
		}
	}

	public function edit()
	{
		$this->document->setTitle('Admin - Edit Customer Feedbacks');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->load_model('customerfeedback');
			$this->model_customerfeedback->editCustomerFeedback($this->request->get['feedback_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have modified customer feedback!');
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
			$this->response->redirect($this->link('customerfeedback', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}

	public function delete()
	{
		$this->load_model('customerfeedback');
		if($this->validateDelete() && isset($this->request->post['feedback_id'])) {
			$this->model_customerfeedback->deleteCustomerFeedback($this->request->post['feedback_id']);
			$this->session->data['success'] = $this->language->get('Success: You have deleted a customer feedback!');

			$this->response->redirect($this->link('customerfeedback', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->getList();
	}

	protected function getForm()
	{
		$data                       = $this->language->getAll();
		$data['text_form']          = ! isset($this->request->get['feedback_id']) ? 'Add New Customer Feedback' : 'Edit Customer Feedback';
		$data['img_feild_required'] = ! isset($this->request->get['feedback_id']) ? "required" : "";
		$data['is_edit']            = ! isset($this->request->get['feedback_id']) ? "no" : "yes";
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
		if (isset($this->error['description'])) {
			$data['error_description'] = $this->error['description'];
		} else {
			$data['error_description'] = '';
		}
        if (isset($this->error['designation'])) {
            $data['error_designation'] = $this->error['designation'];
        } else {
            $data['error_designation'] = '';
        }
        if (isset($this->error['icon'])) {
            $data['error_icon'] = $this->error['icon'];
        } else {
            $data['error_icon'] = '';
        }
		$url = '';

		if (! isset($this->request->get['feedback_id'])) {
			$data['action'] = $this->link('customerfeedback/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->link('customerfeedback/edit', 'token=' . $this->session->data['token'] . '&feedback_id=' . $this->request->get['feedback_id'] . $url, 'SSL');
		}
		$data['cancel'] = $this->link('customerfeedback', 'token=' . $this->session->data['token'] . $url, 'SSL');
		if (isset($this->request->get['feedback_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$this->load_model('customerfeedback');
			$feedback_info = $this->model_customerfeedback->getCustomerFeedback($this->request->get['feedback_id']);
		}
		$data['feedback_info'] = $feedback_info;
		$db_filter             = [
			'order' => 'DESC'
		];
		$this->load_model('language');
		$data['languages'] = $this->model_language->getLanguages($db_filter);
		if (isset($this->request->post['feedback_description'])) {
			$data['feedback_description'] = $this->request->post['feedback_description'];
		} elseif (isset($this->request->get['feedback_id'])) {
			$data['feedback_description'] = $this->model_customerfeedback->getCustomerFeedbackDescriptions($this->request->get['feedback_id']);
		} else {
			$data['feedback_description'] = array();
		}
		if (isset($this->request->post['feedback_id'])) {
			$data['feedback_id'] = $this->request->post['feedback_id'];
		} elseif (!empty($feedback_info)) {
			$data['feedback_id'] = $feedback_info['id'];
		} else {
			$data['feedback_id'] = '';
		}
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (! empty($feedback_info)) {
			$data['sort_order'] = $feedback_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (! empty($feedback_info)) {
			$data['status'] = $feedback_info['status'];
		} else {
			$data['status'] = true;
		}
		if (isset($this->request->post['number_of_stars'])) {
			$data['number_of_stars'] = $this->request->post['number_of_stars'];
		} elseif (! empty($feedback_info)) {
			$data['number_of_stars'] = $feedback_info['number_of_stars'];
		} else {
			$data['number_of_stars'] = '';
		}
        if (isset($this->request->post['icon'])) {
            $data['icon'] = $this->request->post['icon'];
        } elseif (! empty($feedback_info)) {
            $data['icon'] = $feedback_info['icon'];
        } else {
            $data['icon'] = '';
        }
        $data['deleteImage'] = $this->link('customerfeedback/deleteImage', 'token=' . $this->session->data['token'], 'SSL');
		$this->data     = $data;
		$this->template = 'modules/customerfeedback/form.tpl';
		$this->zones    = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
    }

	public function ajaxupdatefeedbackstatus()
	{
		$json = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->load_model('customerfeedback');
			$feedback_id = $this->request->post['feedback_id'];
			$status = $this->request->post['status'];
			$this->model_customerfeedback->updateFeedbackStatus($feedback_id, $status);
			$json['success'] = true;
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
		}
	}
	protected function validateDelete()
	{

		if (!$this->user->hasPermission('modify', 'customerfeedback')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		

		return !$this->error;
	}

	public function deleteImage()
    {
        $this->load_model('customerfeedback');
        $feedback_id = (int)$this->request->get['feedback_id'];

        if ($feedback_id) {
            $result = $this->model_customerfeedback->deleteCustomerFeedbackImage($feedback_id);
            if (isset($result['success'])) {
                $json = ['success' => true];
            } else {
                $json = ['error' => $result['error']];
            }
        } else {
            $json = ['error' => 'Invalid feedback ID.'];
        }

        header('Content-Type: application/json');
        echo json_encode($json);
        exit;
    }
}