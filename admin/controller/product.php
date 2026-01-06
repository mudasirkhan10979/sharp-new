<?php
class ControllerProduct extends Controller
{
	private $error = array();
	public function index()
	{
		$data = $this->language->getAll();
		$this->document->setTitle('Admin - Products');
		$this->load_model('product');
		$this->getList();
	}
	public function add()
	{
		$this->document->setTitle('Admin - Products');
		$this->load_model('product');
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
		// if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_product->addProduct($this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have added a new Product!');
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
			$this->response->redirect($this->link('product', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}
	public function edit()
	{
		$this->document->setTitle('Admin - Products');
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
		// if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->load_model('product');
			$this->model_product->editProduct($this->request->get['product_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have modified Product!');
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
			$this->response->redirect($this->link('product', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}
	public function delete()
	{
		$this->load_model('product');
		$this->model_product->deleteProduct($this->request->post['product_id']);
		$this->getList();
	}
	protected function getForm()
	{
		$data = $this->language->getAll();
		$data['text_form'] = !isset($this->request->get['product_id']) ? 'Add New Product' : 'Edit Product';
		$data['img_feild_required'] = !isset($this->request->get['product_id']) ? "required" : "";
		$data['is_edit'] = !isset($this->request->get['product_id']) ? "no" : "yes";
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		// if (isset($this->error['thumbnail'])) {
		// 	$data['error_thumbnail'] = $this->error['thumbnail'];
		// } else {
		// 	$data['error_thumbnail'] = '';
		// }
		if (isset($this->error['image'])) {
			$data['error_image'] = $this->error['image'];
		} else {
			$data['error_image'] = '';
		}
		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}
		if (isset($this->error['short_description'])) {
			$data['error_s_description'] = $this->error['short_description'];
		} else {
			$data['error_s_description'] = '';
		}
		if (isset($this->error['product_images'])) {
			$data['error_product_images'] = $this->error['product_images'];
		} else {
			$data['error_product_images'] = '';
		}
		// if (isset($this->error['slider_images'])) {
		// 	$data['error_slider_images'] = $this->error['slider_images'];
		// } else {
		// 	$data['error_slider_images'] = '';
		// }
	    //  if (isset($this->error['product_attribute'])) {
		//  	$data['error_product_attribute'] = $this->error['product_attribute'];
		//  } else {
		//  	$data['error_product_attribute'] = '';
		//  }
		if (isset($this->error['product_icons'])) {
			$data['error_product_icons'] = $this->error['product_icons'];
		} else {
			$data['error_product_icons'] = '';
		}
		if (isset($this->error['full_description'])) {
			$data['error_f_description'] = $this->error['full_description'];
		} else {
			$data['error_f_description'] = '';
		}
		// if (isset($this->error['sku'])) {
		// 	$data['error_sku'] = $this->error['sku'];
		// } else {
		// 	$data['error_sku'] = '';
		// }
		// if (isset($this->error['video_url'])) {
		// 	$data['error_video_url'] = $this->error['video_url'];
		// } else {
		// 	$data['error_video_url'] = '';
		// }
		if (isset($this->error['category_id'])) {
			$data['error_category_id'] = $this->error['category_id'];
		} else {
			$data['error_category_id'] = '';
		}
		// if (isset($this->error['country_id'])) {
		// 	$data['error_country_id'] = $this->error['country_id'];
		// } else {
		// 	$data['error_country_id'] = '';
		// }
		// if (isset($this->error['screensize_id'])) {
		// 	$data['error_screensize_id'] = $this->error['screensize_id'];
		// } else {
		// 	$data['error_screensize_id'] = '';
		// }
		// if (isset($this->error['resolution_id'])) {
		// 	$data['error_resolution_id'] = $this->error['resolution_id'];
		// } else {
		// 	$data['error_resolution_id'] = '';
		// }
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
		$url = '';
		if (!isset($this->request->get['product_id'])) {
			$data['action'] = $this->link('product/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->link('product/edit', 'token=' . $this->session->data['token'] . '&product_id=' . $this->request->get['product_id'] . $url, 'SSL');
		}
		$data['cancel'] = $this->link('product', 'token=' . $this->session->data['token'] . $url, 'SSL');
		if (isset($this->request->get['product_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$this->load_model('product');
			$product_info = $this->model_product->getProduct($this->request->get['product_id']);
		}
		$data['product'] = $product_info;
		$db_filter = [
			'order' => 'DESC'
		];
		$this->load_model('language');
		$data['languages'] = $this->model_language->getLanguages($db_filter);
		if (isset($this->request->post['product_description'])) {
			$data['product_description'] = $this->request->post['product_description'];
		} elseif (isset($this->request->get['product_id'])) {
			$data['product_description'] = $this->model_product->getProductDescription($this->request->get['product_id']);
		} else {
			$data['product_description'] = array();
		}
		if (isset($this->request->post['product_id'])) {
			$data['product_id'] = $this->request->post['product_id'];
		} elseif (!empty($product_info)) {
			$data['product_id'] = $product_info['product_id'];
		} else {
			$data['product_id'] = '';
		}
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($product_info)) {
			$data['sort_order'] = $product_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
		if (isset($this->request->post['video_url'])) {
			$data['video_url'] = $this->request->post['video_url'];
		} elseif (!empty($product_info)) {
			$data['video_url'] = $product_info['video_url'];
		} else {
			$data['video_url'] = '';
		}
		if (isset($this->request->post['sku'])) {
			$data['sku'] = $this->request->post['sku'];
		} elseif (!empty($product_info)) {
			$data['sku'] = $product_info['sku'];
		} else {
			$data['sku'] = '';
		}
		if (isset($this->request->post['is_new'])) {
			$data['is_new'] = $this->request->post['is_new'];
		} elseif (!empty($product_info)) {
			$data['is_new'] = $product_info['is_new'];
		} else {
			$data['is_new'] = '';
		}
		if (isset($this->request->post['product_serial_number'])) {
			$data['product_serial_number'] = $this->request->post['product_serial_number'];
		} elseif (!empty($product_info)) {
			$data['product_serial_number'] = $product_info['product_serial_number'];
		} else {
			$data['product_serial_number'] = '';
		}
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($product_info)) {
			$data['status'] = $product_info['publish'];
		} else {
			$data['status'] = true;
		}
		if (isset($this->request->post['featured'])) {
			$data['featured'] = $this->request->post['featured'];
		} elseif (!empty($product_info)) {
			$data['featured'] = $product_info['featured'];
		} else {
			$data['featured'] = false;
		}
		if (isset($this->request->post['thumbnail'])) {
			$data['thumbnail'] = $this->request->post['thumbnail'];
		} elseif (!empty($product_info)) {
			$data['thumbnail'] = $product_info['thumbnail'];
		} else {
			$data['thumbnail'] = '';
		}
		if (isset($this->request->post['benefits_image'])) {
			$data['benefits_image'] = $this->request->post['benefits_image'];
		} elseif (!empty($product_info)) {
			$data['benefits_image'] = $product_info['benefits_image'];
		} else {
			$data['benefits_image'] = '';
		}
		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($product_info)) {
			$data['image'] = $product_info['image'];
		} else {
			$data['image'] = '';
		}
		if (isset($this->request->post['featured_image'])) {
			$data['featured_image'] = $this->request->post['featured_image'];
		} elseif (!empty($product_info)) {
			$data['featured_image'] = $product_info['featured_image'];
		} else {
			$data['featured_image'] = '';
		}
		if (isset($this->request->post['publish_date'])) {
			$data['publish_date'] = $this->request->post['publish_date'];
		} elseif (!empty($product_info)) {
			$data['publish_date'] = date('Y-m-d', strtotime($product_info['publish_date']));
		} else {
			$data['publish_date'] = '';
		}
		// if (isset($this->request->post['featured'])) {
		// 	$data['featured'] = $this->request->post['featured'];
		// } elseif (!empty($product_info)) {
		// 	$data['featured'] = $product_info['mark_feature'];
		// } else {
		// 	$data['featured'] = false;
		// }
		// In product form data load
		if (isset($this->request->post['product_tags'])) {
			$data['product_tags'] = implode(',', $this->request->post['product_tags']); // convert array to string
		} elseif (!empty($product_info)) {
			$data['product_tags'] = $product_info['product_tags'];
		} else {
			$data['product_tags'] = '';
		}

		if (isset($this->request->post['category_id'])) {
			$data['category_id'] = $this->request->post['category_id'];
		} elseif (!empty($product_info)) {
			$data['category_id'] = $product_info['category_id'];
		} else {
			$data['category_id'] = '';
		}
		// if (isset($this->request->post['country_id'])) {
		// 	$data['country_id'] = $this->request->post['country_id'];
		// } elseif (!empty($product_info)) {
		// 	$data['country_id'] = $product_info['country_id'];
		// } else {
		// 	$data['country_id'] = '';
		// }
		if (isset($this->request->post['screensize_id'])) {
			$data['screensize_id'] = $this->request->post['screensize_id'];
		} elseif (!empty($product_info)) {
			$data['screensize_id'] = $product_info['screensize_id'];
		} else {
			$data['screensize_id'] = '';
		}
		if (isset($this->request->post['resolution_id'])) {
			$data['resolution_id'] = $this->request->post['resolution_id'];
		} elseif (!empty($product_info)) {
			$data['resolution_id'] = $product_info['resolution_id'];
		} else {
			$data['resolution_id'] = '';
		}
		if (isset($this->request->post['seo_url'])) {
			$data['seo_url'] = $this->request->post['seo_url'];
		} elseif (!empty($product_info)) {
			$data['seo_url'] = $product_info['seo_url'];
		} else {
			$data['seo_url'] = false;
		}

		$this->load_model('product');
		// Load product attributes if editing
		if (isset($this->request->get['product_id'])) {
			$data['product_attributes'] = $this->model_product->getProductAttributes($this->request->get['product_id']);
		} else {
			$data['product_attributes'] = array();
		}
		$data['categories'] = $this->model_product->getCategories();
		$data['screensizes'] = $this->model_product->getScreenSize();
		$data['resolutions'] = $this->model_product->getResolution();

		$this->load_model('attribute');
		$this->load_model('attributevalue');
		$data['attributes'] = $this->model_attribute->getAttributes();
		$data['attribute_values'] = $this->model_attributevalue->getAttributeValues();

		// $data['countries'] = $this->model_product->getCountries();
		if (isset($this->request->post['product_images'])) {
			$product_images = $this->request->post['product_images'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_images = $this->model_product->getProductImages($this->request->get['product_id']);
		} else {
			$product_images = array();
		}

		$data['product_images'] = array();
		foreach ($product_images as $product_image) {
			if (is_file(DIR_IMAGE . 'product/' . $product_image['image'])) {
				$image = $product_image['image'];
				$thumb = '../uploads/image/product/' . $product_image['image'];
			} else {
				$image = '';
				$thumb = '../uploads/image/product/no_image.png';
			}
			$data['product_images'][] = array(
				'image'      => $image,
				'thumb'      => $thumb,
				'sort_order' => $product_image['sort_order'],
				'description' => $product_image['description']
			);
		}

		// echo '<pre>'; print_r($this->request->post['slider_images']); echo '</pre>'; exit;
		// in controller when preparing form data:
		if (isset($this->request->post['slider_images'])) {
			$slider_images = $this->request->post['slider_images'];
		} elseif (isset($this->request->get['product_id'])) {
			$this->load_model('product');
			$slider_images = $this->model_product->getProductSliders($this->request->get['product_id']);
		} else {
			$slider_images = array();
		}

		$data['slider_images'] = array();

		foreach ($slider_images as $slider_image) {
			// if slider_image was from POST, it may be an array with keys; normalize
			$image = '';
			$thumb = '../uploads/image/product/no_image.png';
			$color = '';
			$sort_order = 0;
			if (is_array($slider_image)) {
				$image = isset($slider_image['image']) ? $slider_image['image'] : (isset($slider_image['image']) ? $slider_image['image'] : '');
				$color = isset($slider_image['color']) ? $slider_image['color'] : '';
				$sort_order = isset($slider_image['sort_order']) ? $slider_image['sort_order'] : 0;
			} else {
				// if slider_image is a string (old format), treat as filename
				$image = $slider_image;
			}

			if ($image && is_file(DIR_IMAGE . 'product/' . $image)) {
				$thumb = '../uploads/image/product/' . $image;
			} elseif ($image) {
				// if you store full URL in db:
				$thumb = $image;
			}

			$data['slider_images'][] = array(
				'color' => $color,
				'image' => $image,
				'thumb' => $thumb,
				'sort_order' => $sort_order
			);
		}

		if (isset($this->request->post['product_icons'])) {
			$product_icons = $this->request->post['product_icons'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_icons = $this->model_product->getProductIcons($this->request->get['product_id']);
		} else {
			$product_icons = array();
		}
		$data['product_icons'] = array();
		foreach ($product_icons as $product_icon) {
			if (is_file(DIR_IMAGE . 'product/' . $product_icon['image'])) {
				$image = $product_icon['image'];
				$thumb = '../uploads/image/product/' . $product_icon['image'];
			} else {
				$image = '';
				$thumb = '../uploads/image/product/no_image.png';
			}
			$data['product_icons'][] = array(
				'image'      => $image,
				'thumb'      => $thumb,
				'sort_order' => $product_icon['sort_order'],
				'description' => $product_icon['description']
			);
		}
		$data['token'] = $this->session->data['token'];
		$data['uploadImages'] = $this->link('product/uploadImages', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['deleteImage'] = $this->link('product/deleteImage', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data = $data;
		$this->template = 'modules/product/form.tpl';
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
		if ((utf8_strlen(trim($data['category_id'])) < 1)) {
			$this->error['category_id'] = "Category field is missing";
		}
		// if ((utf8_strlen(trim($data['country_id'])) < 1)) {
		// 	$this->error['country_id'] = "Country field is missing";
		// }
		// if ((utf8_strlen(trim($data['screensize_id'])) < 1)) {
		// 	$this->error['screensize_id'] = "Screen Size field is missing";
		// }
		//    if ((utf8_strlen(trim($data['resolution_id'])) < 1)) {
		// 		$this->error['resolution_id'] = "Resolution field is missing";
		// 	}
		// if (trim($this->request->post['sku']) == '') {
		// 	$this->error['sku'] =  'SKU field is missing';
		// }
		// if (trim($this->request->post['video_url']) == '') {
		// 	$this->error['video_url'] =  'Video URL field is missing';
		// }
		if ((utf8_strlen(trim($data['publish_date'])) < 1)) {
			$this->error['publish_date'] = "Publish Date field is missing";
		}
		foreach ($data['product_description'] as $language_id => $value) {
			if ((utf8_strlen(trim($value['name'])) < 1)) {
				$this->error['name'][$language_id] = "Title field is missing";
			}
			if ((utf8_strlen(trim($value['short_description'])) < 1)) {
				$this->error['short_description'][$language_id] = "Short description field is missing";
			}
			if ((utf8_strlen(trim($value['full_description'])) < 1)) {
				$this->error['full_description'][$language_id] = "Description field is missing";
			}
		}

		if (isset($this->request->post['product_images']) && !empty($this->request->post['product_images'])) {
			foreach ($this->request->post['product_images'] as $option_value_id1 => $option_value1) {
				// if ((utf8_strlen($option_value1['image']) < 1)) {
				// 	$this->error['product_images'][$option_value_id1]['image'] = "Image is missing.";
				// }
				// foreach ($option_value1['description'] as $language_id1 => $option_value_description1) {
				// 	if ((utf8_strlen($option_value_description1['title']) < 1)) {
				// 		$this->error['product_images'][$option_value_id1]['title'][$language_id1] = "Title is missing.";
				// 	}
				// 	if ((utf8_strlen($option_value_description1['content']) < 1)) {
				// 		$this->error['product_images'][$option_value_id1]['content'][$language_id1] = "Content is missing.";
				// 	}
				// }
			}
		}

		// Add this in the validateForm() method - optional validation for attributes
			// if (isset($this->request->post['product_attribute']) && !empty($this->request->post['product_attribute'])) {
			// 	foreach ($this->request->post['product_attribute'] as $attribute_row => $attribute_data) {
			// 		if (empty($attribute_data['attribute_id'])) {
			// 			$this->error['product_attribute'][$attribute_row]['attribute_id'] = "Attribute is required";
			// 		}
			// 		if (empty($attribute_data['attribute_value_id'])) {
			// 			$this->error['product_attribute'][$attribute_row]['attribute_value_id'] = "Attribute Value is required";
			// 		}
			// 	}
			// }

		if (isset($this->request->post['slider_images']) && !empty($this->request->post['slider_images'])) {
			foreach ($this->request->post['slider_images'] as $option_value_id3 => $option_value3) {
				// if ((utf8_strlen($option_value3['image']) < 1)) {
				// 	$this->error['slider_images'][$option_value_id3]['image'] = "Image is missing.";
				// }
				// foreach ($option_value3['description'] as $language_id1 => $option_slider_description1) {
				// 	if ((utf8_strlen($option_slider_description1['title']) < 1)) {
				// 		$this->error['slider_images'][$option_value_id3]['title'][$language_id1] = "Title is missing.";
				// 	}
				// 	if ((utf8_strlen($option_slider_description1['content']) < 1)) {
				// 		$this->error['slider_images'][$option_value_id3]['content'][$language_id1] = "Content is missing.";
				// 	}
				// }
				//  echo '<pre>'; print_r($this->error); exit;
			}
		}

		if (isset($this->request->post['product_icons']) && !empty($this->request->post['product_icons'])) {
			foreach ($this->request->post['product_icons'] as $option_value_id2 => $option_value2) {
				// if ((utf8_strlen($option_value2['image']) < 1)) {
				// 	$this->error['product_icons'][$option_value_id2]['image'] = "Image is missing.";
				// }
				// foreach ($option_value2['description'] as $language_id2 => $option_value_description2) {
				// 	if ((utf8_strlen($option_value_description2['title']) < 1)) {
				// 		$this->error['product_icons'][$option_value_id2]['title'][$language_id2] = "Title is missing.";
				// 	}
				// 	if ((utf8_strlen($option_value_description2['content']) < 1)) {
				// 		$this->error['product_icons'][$option_value_id2]['content'][$language_id2] = "Content is missing.";
				// 	}
				// }
			}
		}

		// if (!$this->request->get['product_id']) {
		// 	if ($_FILES["thumbnail"]["name"] == "") {
		// 		$this->error['thumbnail'] = 'Please upload thumbnail';
		// 	}
		// } else {
		// 	if ($data["thumbnail"] == "" && $_FILES["thumbnail"]["name"] == "") {
		// 		$this->error['thumbnail'] = 'Please upload thumbnail';
		// 	}
		// }


		if (!$this->request->get['product_id']) {
			if ($_FILES["image"]["name"] == "") {
				$this->error['image'] = 'Please upload image';
			}
		} else {
			if ($data["image"] == "" && $_FILES["image"]["name"] == "") {
				$this->error['image'] = 'Please upload image';
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = ' Warning: Please check the form carefully for errors!';
		}

		$this->load_model('seourl');
		if ($data['seo_url'] != "") {
			$keyword = $this->model_seourl->seoUrl($data['seo_url']);
		}
		if ($keyword != '') {
			$this->load_model('seourl');
			$seo_urls = $this->model_seourl->getSeoUrlsByKeyword($keyword);
			foreach ($seo_urls as $seo_url) {
				if (($this->request->get['product_id'] != $seo_url['slog_id'] || ($seo_url['slog'] != 'product/detail'))) {
					$this->error['seo_url'] = "This url is already been used";
					break;
				}
			}
		}
		//   echo '<pre>'; print_r($this->error); exit;
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
		$data['add'] = $this->link('product/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->link('product/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['products'] = array();
		$filter_data = array(
			'order' => $order,
		);
		$results = $this->model_product->getProducts($filter_data);
		foreach ($results as $result) {
			$data['products'][] = array(
				'product_id'     => $result['product_id'],
				'name'		 	=> $result['name'],
				'category_name'	=> $result['category_name'],
				'status' 		=> $result['publish'],
				'featured' 		=> $result['featured'],
				'sort_order'    => $result['sort_order'],
				'edit'       	=> $this->link('product/edit', 'token=' . $this->session->data['token'] . '&product_id=' . $result['product_id'] . $url, 'SSL'),
				'delete'       	=> $this->link('product/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
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
		$data['ajaxProductstatus'] = $this->link('product/ajaxProductstatus', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['ajaxProductfeatured'] = $this->link('product/ajaxProductfeatured', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['token'] = $this->session->data['token'];
		$this->data = $data;
		$this->template = 'modules/product/list.tpl';
		$this->zones = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}
	public function uploadImages()
	{
		if (!empty($_FILES["image"]["name"])) {
			$targetDirectory = DIR_IMAGE . "product/";
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

	public function ajaxProductstatus()
	{
		$json = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->load_model('product');
			$product_id = $this->request->post['product_id'];
			$status = $this->request->post['status'];
			$stat = $this->model_product->updateProductStatus($product_id, $status);
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


public function ajaxProductfeatured()
{
    $json = array();
    if ($this->request->server['REQUEST_METHOD'] == 'POST') {
        $this->load_model('product');
        $product_id = $this->request->post['product_id'];
        $featured = $this->request->post['featured'];
        $result = $this->model_product->updateProductFeatured($product_id, $featured);
        if ($result) {
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
    $this->load_model('product');

    $product_id = (int)$this->request->get['product_id'];
    $type = isset($this->request->get['type']) ? $this->request->get['type'] : 'main'; // default: main

    $json = [];

    if ($product_id) {
        $result = $this->model_product->deleteProductImage($product_id, $type);

        if (!empty($result['success'])) {
            $json = ['success' => true];
        } else {
            $json = ['error' => $result['error'] ?? 'Error deleting image'];
        }
    } else {
        $json = ['error' => 'Invalid product ID'];
    }

    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
}



// Add this method to handle AJAX requests for attribute values
public function getAttributeValues() {
    $json = array();
    
    if (isset($this->request->get['attribute_id'])) {
        $attribute_id = (int)$this->request->get['attribute_id'];
        $this->load_model('attributevalue');
        $json['attribute_values'] = $this->model_attributevalue->getAttributeValuesByAttribute($attribute_id);
    }
    
    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
}


}
