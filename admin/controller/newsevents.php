<?php
class ControllerNewsEvents extends Controller
{
    private $error = array();

    public function index()
    {
        $data = $this->language->getAll();
        $this->document->setTitle('Admin - News & Events');
        $this->load_model('newsevents');
        $this->getList();
    }

    public function add()
    {
        $this->document->setTitle('Admin - News & Events');
        $this->load_model('newsevents');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_newsevents->addNewsEvents($this->request->post);
            $this->session->data['success'] = "Success: You have added a new News & Event!";
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
            $this->response->redirect($this->link('newsevents', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getForm();
    }

    public function edit()
    {
        $this->document->setTitle('Admin - News & Events');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->load_model('newsevents');
            $this->model_newsevents->editNewsEvents($this->request->get['news_event_id'], $this->request->post);
            $this->session->data['success'] = "Success: You have modified News & Event!";
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
            $this->response->redirect($this->link('newsevents', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getForm();
    }

    public function delete()
    {
        $this->load_model('newsevents');
        if ($this->request->post['news_event_id'] && $this->validateDelete()) {
            $this->model_newsevents->deleteNewsEvents($this->request->post['news_event_id']);
            $this->session->data['success'] = $this->language->get('Success: You have deleted News & Event!');
            $this->response->redirect($this->link('newsevents', 'token=' . $this->session->data['token'], 'SSL'));
        }
        $this->getList();
    }

    protected function getForm()
    {
        $data = $this->language->getAll();
        $data['text_form'] = !isset($this->request->get['news_event_id']) ? 'Add New News & Event' : 'Edit News & Event';
        $data['is_edit'] = !isset($this->request->get['news_event_id']) ? "no" : "yes";
        
        // Error messages
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

       if (isset($this->error['ne_category_id'])) {
            $data['error_ne_category_id'] = $this->error['ne_category_id'];
        } else {
            $data['error_ne_category_id'] = '';
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
       if (isset($this->error['publish_date'])) {
            $data['error_publish_date'] = $this->error['publish_date'];
        } else {
            $data['error_publish_date'] = '';
        }
        if (isset($this->error['seo_url'])) {
            $data['error_seo_url'] = $this->error['seo_url'];
        } else {
            $data['error_seo_url'] = '';
        }

        if (isset($this->error['description'])) {
			$data['error_description'] = $this->error['description'];
		} else {
			$data['error_description'] = '';
		}

        if (isset($this->error['short_description'])) {
            $data['error_short_description'] = $this->error['short_description'];
        } else {
            $data['error_short_description'] = '';
        }
        
        if (isset($this->error['title'])) {
			$data['error_title'] = $this->error['title'];
		} else {
			$data['error_title'] = '';
		}
        // Add all other error checks (title, description, etc.)
        // Changed from media_center to news_events
        
        $url = '';
        if (!isset($this->request->get['news_event_id'])) {
            $data['action'] = $this->link('newsevents/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->link('newsevents/edit', 'token=' . $this->session->data['token'] . '&news_event_id=' . $this->request->get['news_event_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = $this->link('newsevents', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        if (isset($this->request->get['news_event_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $this->load_model('newsevents');
            $news_event_info = $this->model_newsevents->getNewsEvents($this->request->get['news_event_id']);
            // echo '<pre>'; print_r($news_event_info); exit;
        }
        
        $db_filter = ['order' => 'DESC'];
        $this->load_model('language');
        $data['languages'] = $this->model_language->getLanguages($db_filter);
        
        if (isset($this->request->post['news_events_description'])) {
            $data['news_events_description'] = $this->request->post['news_events_description'];
        } elseif (isset($this->request->get['news_event_id'])) {
            $data['news_events_description'] = $this->model_newsevents->getNewsEventsDescriptions($this->request->get['news_event_id']);
        } else {
            $data['news_events_description'] = array();
        }
        
        if (isset($this->request->post['news_event_id'])) {
            $data['news_event_id'] = $this->request->post['news_event_id'];
        } elseif (!empty($news_event_info)) {
            $data['news_event_id'] = $news_event_info['news_event_id'];
        } else {
            $data['news_event_id'] = '';
        }
        // Form fields data
        if (isset($this->request->post['sort_order'])) {
            $data['sort_order'] = $this->request->post['sort_order'];
        } elseif (!empty($news_event_info)) {
            $data['sort_order'] = $news_event_info['sort_order'];
        } else {
            $data['sort_order'] = '';
        }

        if (isset($this->request->post['ne_category_id'])) {
			$data['ne_category_id'] = $this->request->post['ne_category_id'];
		} elseif (!empty($news_event_info)) {
			$data['ne_category_id'] = $news_event_info['ne_category_id'];
		} else {
			$data['ne_category_id'] = '';
		}

         if (isset($this->request->post['thumbnail'])) {
            $data['thumbnail'] = $this->request->post['thumbnail'];
        } elseif (!empty($news_event_info)) {
            $data['thumbnail'] = $news_event_info['thumbnail'];
        } else {
            $data['thumbnail'] = '';
        }
         if (isset($this->request->post['banner_image'])) {
            $data['banner_image'] = $this->request->post['banner_image'];
        } elseif (!empty($news_event_info)) {
            $data['banner_image'] = $news_event_info['banner_image'];
        } else {
            $data['banner_image'] = '';
        }
        if (isset($this->request->post['middle_image'])) {
            $data['middle_image'] = $this->request->post['middle_image'];
        } elseif (!empty($news_event_info)) {
            $data['middle_image'] = $news_event_info['middle_image'];
        } else {
            $data['middle_image'] = '';
        }
        if (isset($this->request->post['left_image'])) {
            $data['left_image'] = $this->request->post['left_image'];
        } elseif (!empty($news_event_info)) {
            $data['left_image'] = $news_event_info['left_image'];
        } else {
            $data['left_image'] = '';
        }
        if (isset($this->request->post['right_image'])) {
            $data['right_image'] = $this->request->post['right_image'];
        } elseif (!empty($news_event_info)) {
            $data['right_image'] = $news_event_info['right_image'];
        } else {
            $data['right_image'] = '';
        }
		if (isset($this->request->post['publish_date'])) {
			$data['publish_date'] = $this->request->post['publish_date'];
		} elseif (!empty($news_event_info)) {
			$data['publish_date'] = date('Y-m-d', strtotime($news_event_info['publish_date']));
		} else {
			$data['publish_date'] = '';
		}
        if (isset($this->request->post['publish'])) {
			$data['publish'] = $this->request->post['publish'];
		} elseif (!empty($news_event_info)) {
			$data['publish'] = $news_event_info['publish'];
		} else {
			$data['publish'] = true;
		}
       if (isset($this->request->post['seo_url'])) {
            $data['seo_url'] = $this->request->post['seo_url'];
        } elseif (!empty($news_event_info)) {
            $data['seo_url'] = $news_event_info['seo_url'];
        } else {
            $data['seo_url'] = '';
        }
        if (isset($this->request->post['show_on_home'])) {
			$data['show_on_home'] = $this->request->post['show_on_home'];
		} elseif (!empty($news_event_info)) {
			$data['show_on_home'] = $news_event_info['show_on_home'];
		} else {
			$data['show_on_home'] = '';
		}
        // Add all other form field assignments
        // Changed from media_center to news_events
        
        $this->load_model('newsevents');
        $data['news_categories'] = $this->model_newsevents->getNewsEventsCategories();
        // echo '<pre>'; print_r($data['news_categories']); exit; 

        $data['deleteImage'] = $this->link('newsevents/deleteImage', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['token'] = $this->session->data['token'];
        $this->data = $data;
        $this->template = 'modules/newsevents/form.tpl';
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

        foreach ($data['news_events_description'] as $language_id => $value) {
            if ((utf8_strlen(trim($value['title'])) < 1)) {
                $this->error['title'][$language_id] = "Title field is missing";
            }

            if ((utf8_strlen(trim($value['short_description'])) < 1)) {
                $this->error['short_description'][$language_id] = "Short Description field is missing";
            }

            if ((utf8_strlen(trim($value['description'])) < 1)) {
                $this->error['description'][$language_id] = "Description field is missing";
            }
        }
        
        if ((utf8_strlen(trim($data['publish_date'])) < 1)) {
            $this->error['publish_date'] = "Publish Date field is missing";
        }
        
        if ((utf8_strlen(trim($data['ne_category_id'])) < 1)) {
            $this->error['ne_category_id'][$language_id] = "Category field is missing";
        }


           if (!$this->request->get['news_event_id']) {
				if ($_FILES["banner_image"]["name"] == "") {
					$this->error['banner_image'] = 'Please upload banner image';
				}
			} else {
				if ($data["banner_image"] == "" && $_FILES["banner_image"]["name"] == "") {
					$this->error['banner_image'] = 'Please upload thumb image';
				}
			}
        
            if (!$this->request->get['news_event_id']) {
				if ($_FILES["thumbnail"]["name"] == "") {
					$this->error['thumbnail'] = 'Please upload thumb image';
				}
			} else {
				if ($data["thumbnail"] == "" && $_FILES["thumbnail"]["name"] == "") {
					$this->error['thumbnail'] = 'Please upload banner image';
				}
			}

        // SEO URL validation
        $this->load_model('seourl');
        if ($data['seo_url'] != "") {
            $keyword = $this->model_seourl->seoUrl($data['seo_url']);
        }
        
        if ($keyword != '') {
            $this->load_model('seourl');
            $seo_urls = $this->model_seourl->getSeoUrlsByKeyword($keyword);
            
            foreach ($seo_urls as $seo_url) {
                if (($this->request->get['news_event_id'] != $seo_url['slog_id'] || ($seo_url['slog'] != 'newsevent/detail'))) {
                    $this->error['seo_url'] = "This url is already been used";
                    break;
                }
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
        
        $data['add'] = $this->link('newsevents/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->link('newsevents/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['news_events'] = array();
        
        $filter_data = array('order' => $order);
        $results = $this->model_newsevents->getNewsEventsList($filter_data);

        foreach ($results as $result) {
            $data['news_events'][] = array(
                'news_event_id' => $result['news_event_id'],
                'title'         => $result['title'],
                'sort_order'    => $result['sort_order'],
                'publish'        => $result['publish'],
                'edit'          => $this->link('newsevents/edit', 'token=' . $this->session->data['token'] . '&news_event_id=' . $result['news_event_id'] . $url, 'SSL'),
                'delete'        => $this->link('newsevents/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
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
        
        $data['ajaxnewseventsstatus'] = $this->link('newsevents/ajaxnewseventsstatus', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['token'] = $this->session->data['token'];
        
        $this->data = $data;
        $this->template = 'modules/newsevents/list.tpl';
        $this->zones = array(
            'header',
            'columnleft',
            'footer'
        );

        $this->response->setOutput($this->render());
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'newsevents')) {
            $this->error['warning'] = 'Warning: You do not have permission for modification!';
        }
        return !$this->error;
    }
    
    public function ajaxnewseventsstatus()
    {
        $json = array();
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $this->load_model('newsevents');
            $news_event_id = $this->request->post['news_event_id'];
            $publish = $this->request->post['publish'];
            $stat = $this->model_newsevents->updateNewsEventsStatus($news_event_id, $publish);
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


    public function deleteImage() {
    $json = [];

    if (isset($this->request->get['type']) && isset($this->request->get['news_event_id'])) {
        $type = $this->request->get['type'];
        $news_event_id = (int)$this->request->get['news_event_id'];

        $this->load_model('newsevents');

        $result = $this->model_newsevents->deleteNewsEventsImage($news_event_id, $type);

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