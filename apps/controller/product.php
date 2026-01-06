<?php
class ControllerProduct extends Controller
{
    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->registry->set('pcUrls', 'product');
        $this->load_model('product');
        $this->load_model('page');
    }

    public function index()
    {
        $page_id = $this->registry->get('slug_data')['slog_id'];
        $page = $this->model_page->getPage($page_id);
        if (empty($page)) {
            $this->redirect(HTTPS_HOST . 'error404');
            exit;
        }
        $short_description = strip_tags(html_entity_decode($page['short_description'], ENT_QUOTES, 'UTF-8'));
        $image = $page['banner_image'] ? BASE_URL . "uploads/image/pages/" . $page['banner_image'] : BASE_URL . "uploads/default_banner.jpg";
        $data['banner'] = array(
            'title' => $page['name'],
            'short_description' => $short_description,
            'image' => $image
        );
        $this->template = 'sharp/template/product-listing.tpl';
        $this->data = $data;
        $this->zones = array('header', 'footer', 'menuinner');
        $this->response->setOutput($this->render());
    }

    public function Detail()
    {
        $this->load_model('product');
        $this->load_model('home');
        $product_id =  $this->registry->get('slug_data')['slog_id'];
        $productDetails = $this->model_product->getProductsDetails($product_id);
        if (!$product_id || !$productDetails['publish']) {
            $this->redirect(HTTPS_HOST . 'error404');
            exit;
        }
        $data['productDetails'] = array();
        if ($productDetails) {
            $imgURL = BASE_URL . "uploads/image/product/";
            if (isset($productDetails['thumbnail']) && !empty($productDetails['thumbnail'])) {
                $thumbnail_image = $imgURL . $productDetails['thumbnail'];
            } else {
                $thumbnail_image = '';
            }
            if (isset($productDetails['benefits_image']) && !empty($productDetails['benefits_image'])) {
                $benefits_image = $imgURL . $productDetails['benefits_image'];
            } else {
                $benefits_image = '';
            }
            $full_description = str_replace('&nbsp;', ' ', html_entity_decode($productDetails['full_description'], ENT_QUOTES, 'UTF-8'));
            $data['productDetails'] = array(
                'thumbnail_image' => $thumbnail_image,
                'benefits_image' => $benefits_image,
                'product_name' => $productDetails['name'],
                'seo_url' => $productDetails['seo_url'],
                'category_url' => $productDetails['category_url'],
                'video_url' => $productDetails['video_url'],
                'category_name' => $productDetails['category_name'],
                'product_serial_number' => $productDetails['product_serial_number'],
                'sku' => $productDetails['sku'],
                'is_new' => $productDetails['is_new'],
                'product_tags' => $productDetails['product_tags'],
                'publish_date' => date('d M Y', strtotime($productDetails['publish_date'])),
                'short_description' => $short_description,
                'full_description' => $full_description
            );
        }
        $data['action'] = HTTP_HOST . $this->registry->get('slug_data')['url'];
        $cleaned_description = strip_tags(html_entity_decode($productDetails['description'], ENT_QUOTES, 'UTF-8'));
        $trimmed_description = substr($cleaned_description, 0, 250);
        $this->document->addFBMeta('og:image', $thumbnail_image);
        $this->document->addFBMeta('og:title', $productDetails['product_name']);
        $this->document->addFBMeta('og:url', $data['action']);
        $this->document->addFBMeta('og:description', $trimmed_description);
        $this->document->addFBMeta('og:width', '400');
        $this->document->addFBMeta('og:height', '300');
        $this->document->addTWMeta('twitter:image', $thumbnail_image . "?" . time());
        $this->document->addTWMeta('twitter:title', $productDetails['product_name']);
        $this->document->addTWMeta('twitter:description', $trimmed_description);
        $this->document->addTWMeta('twitter:card', 'summary_large_image');
        $this->document->addTWMeta('twitter:site', 'Sharp');
        $data['share_links'] = array(
            'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($data['action']),
            'twitter'  => 'https://twitter.com/intent/tweet?text=' . urlencode($trimmed_description) . '&url=' . urlencode($data['action']),
            // Instagram - only link to your profile (sharing not supported)
            'instagram' => 'https://www.instagram.com/yourprofile/',
            // YouTube - only link to your channel (sharing not supported)
            'youtube'   => 'https://www.youtube.com/',
            // WhatsApp - allows sharing with a message
            'whatsapp'  => 'https://api.whatsapp.com/send?text=' . urlencode($productDetails['title'] . ' - ' . $data['action'])
        );
        if ($productDetails['meta_description']) {
            $cleaned_descrition =  strip_tags(html_entity_decode($productDetails['meta_description'], ENT_QUOTES, 'UTF-8'));
            $metaDescription = substr($cleaned_descrition, 0, 160);
            $this->document->setDescription($metaDescription);
        } elseif ($productDetails['description']) {
            $cleaned_descrition =  strip_tags(html_entity_decode($productDetails['description'], ENT_QUOTES, 'UTF-8'));
            $metaDescription = substr($cleaned_descrition, 0, 160);
            $this->document->setDescription($metaDescription);
        }
        if ($productDetails['meta_keyword']) {
            $this->document->setKeywords($productDetails['meta_keyword']);
        } elseif ($productDetails['title']) {
            $this->document->setKeywords($productDetails['title']);
        }
        if ($productDetails['meta_title']) {
            $this->document->setTitle($productDetails['meta_title']);
        } elseif ($productDetails['title']) {
            $this->document->setTitle($productDetails['title']);
        }
        $data['breadcrumbs'] = [
            'text' => $this->language->get('text_back'),
            'href' => HTTP_HOST . "product"
        ];
        $data['text_btn_read_more'] = $this->language->get('text_btn_read_more');
        $data['relatedproducts'] = array();
        $relatedproducts = $this->model_product->getRelatedProducts($product_id);
        foreach ($relatedproducts as $event) {
            $image = BASE_URL . "uploads/image/product/" . $event['image'];
            $short_description = str_replace('&nbsp;', ' ', html_entity_decode($event['short_description'], ENT_QUOTES, 'UTF-8'));
            $data['relatedproducts'][] = array(
                'product_id'   => $event['product_id'],
                'name'             => $event['name'],
                'is_new'             => $event['is_new'],
                'publish_date'      =>  date('d M Y', strtotime($event['publish_date'])),
                'short_description' => $short_description,
                'image'             => $image,
                'href'              =>  HTTPS_HOST . "product/" . $event['seo_url']
            );
        }
        $blocksupportservice = $this->model_home->getHtmlBlock('block-support-service');
        if (!empty($blocksupportservice['content'])) {
            $blocksupportservice['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blocksupportservice['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blocksupportservice'] = $blocksupportservice;
        $block1productsupport = $this->model_home->getHtmlBlock('block1-product-support');
        if (!empty($block1productsupport['content'])) {
            $block1productsupport['content'] = str_replace('&nbsp;', ' ', html_entity_decode($block1productsupport['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['block1productsupport'] = $block1productsupport;
        $block2needhelp = $this->model_home->getHtmlBlock('block2-need-help');
        if (!empty($block2needhelp['content'])) {
            $block2needhelp['content'] = str_replace('&nbsp;', ' ', html_entity_decode($block2needhelp['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['block2needhelp'] = $block2needhelp;
        $block3customerservicecenter = $this->model_home->getHtmlBlock('block3-customer-service-center');
        if (!empty($block3customerservicecenter['content'])) {
            $block3customerservicecenter['content'] = str_replace('&nbsp;', ' ', html_entity_decode($block3customerservicecenter['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['block3customerservicecenter'] = $block3customerservicecenter;
        $data['product_images'] = $this->model_product->getProductImages($product_id);
        $images_by_color = [];
        $available_colors = [];
        if (!empty($data['product_images'])) {
            foreach ($data['product_images'] as $img) {
                $color = trim($img['color']);
                if (!isset($images_by_color[$color])) {
                    $images_by_color[$color] = [];
                    $available_colors[] = $color;
                }
                $images_by_color[$color][] = $img;
            }
        }
        $data['images_by_color'] = $images_by_color;
        $data['available_colors'] = $available_colors;
        $data['product_features'] = $this->model_product->getProductProductFeatures($product_id);
        $data['product_benefits'] = $this->model_product->getProductProductBenefits($product_id);
        $data['source_codes'] = $this->model_product->getSourceCodes($product_id);
        $data['text_learn_more'] = $this->language->get('text_learn_more');
        $data['text_features'] = $this->language->get('text_features');
        $data['text_user_manual'] = $this->language->get('text_user_manual');
        $data['text_download_resources'] = $this->language->get('text_download_resources');
        $data['text_explore'] = $this->language->get('text_explore');
        $data['text_download'] = $this->language->get('text_download');
        $data['text_similar_products'] = $this->language->get('text_similar_products');
        $data['text_play']  = $this->language->get('text_play');
        $data['text_select_country']  = $this->language->get('text_select_country');
        $data['text_united_states']  = $this->language->get('text_united_states');
        $data['text_united_kingdom']  = $this->language->get('text_united_kingdom');
        $data['text_canada']  = $this->language->get('text_canada');
        $data['text_australia']  = $this->language->get('text_australia');
        // Primary Countries
        $data['text_united_arab_emirates']  = $this->language->get('text_united_arab_emirates');
        $data['text_kingdom_of_saudi_arabia']  = $this->language->get('text_kingdom_of_saudi_arabia');
        $data['text_qatar']  = $this->language->get('text_qatar');
        $data['text_kuwait']  = $this->language->get('text_kuwait');
        $data['text_bahrain']  = $this->language->get('text_bahrain');        
        $data['text_oman']  = $this->language->get('text_oman');
        $data['text_algeria']  = $this->language->get('text_algeria');
        $data['text_morocco']  = $this->language->get('text_morocco');
        $data['text_south_africa']  = $this->language->get('text_south_africa');
        $data['text_select_subject']  = $this->language->get('text_select_subject');
        $data['text_general_inquiry']  = $this->language->get('text_general_inquiry');
        $data['text_product_information']  = $this->language->get('text_product_information');
        $data['text_technical_support']  = $this->language->get('text_technical_support');
        $data['text_partnership']  = $this->language->get('text_partnership');
        $data['text_your_name']  = $this->language->get('text_your_name');
        $data['text_your_email']  = $this->language->get('text_your_email');
        $data['text_message']  = $this->language->get('text_message');
        $data['text_contact_number']  = $this->language->get('text_contact_number');
        $data['text_city']  = $this->language->get('text_city');
        $data['text_btn_submit']  = $this->language->get('text_btn_submit');
        $data['text_inquire']  = $this->language->get('text_inquire');
        $data['err_name']  = $this->language->get('err_name');
        $data['err_email']  = $this->language->get('err_email');
        $data['err_invalid_email']  = $this->language->get('err_invalid_email');
        $data['err_phone']  = $this->language->get('err_phone');
        $data['err_city']  = $this->language->get('err_city');
        $data['err_subject']  = $this->language->get('err_subject');
        $data['err_message']  = $this->language->get('err_message');
        $data['text_only_share']  = $this->language->get('text_only_share');
        $data['text_text_new'] = $this->language->get('text_text_new');
        $this->template = 'sharp/template/product-detail.tpl';
        $this->data = $data;
        $this->zones = array(
            'header',
            'menuinner',
            'footer'
        );
        $this->response->setOutput($this->render());
    }


    public function inquireNowForm()
    {
        $this->load_model('product'); 
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            if (!$this->validateForm()) {
                $json = ['error' => $this->error];
                $this->response->setOutput(json_encode($json));
                return;
            }

            $this->model_product->addEnquiry($this->request->post);

            $toEmail = $this->config->get('config_email');
            $subject = 'Enquiry from ' . $this->request->post['name'];
            $message = $this->request->post['message'];
            $emaildata = [
                'name' => $this->request->post['name'],
                'email' => $this->request->post['email'],
                'phone' => $this->request->post['phone'],
                'country' => $this->request->post['country'],
                'city' => $this->request->post['city'],
                'subject' => $this->request->post['subject'],
                'message' => $this->request->post['message'],
                'enquiry_from' => $this->request->post['enquiry_from']
            ];
            $mail = new Mail();
            $mail->protocol = $this->config->get('config_mail_protocol');
            $mail->hostname = $this->config->get('config_mail_smtp_hostname');
            $mail->username = $this->config->get('config_mail_smtp_username');
            $mail->password = $this->config->get('config_mail_smtp_password');
            $mail->port     = $this->config->get('config_mail_smtp_port');
            $mail->setTo($toEmail);
            $mail->setFrom($toEmail);
            $mail->setSender('Sharp');
            $mail->setSubject($subject);
            $this->template = 'sharp/template/mail/admin-notification.tpl';
            $this->data = ['message' => $message, 'emailData' => $emaildata];
            $mail->setHtml($this->render());
            $mail->send();
            $json['success'] = $this->language->get('text_new_success_message');
            $this->response->setOutput(json_encode($json));
        }
    }

    protected function validateForm()
    {
        $err_name = $this->language->get('err_name');
        $err_subject = $this->language->get('err_subject');
        $err_phone = $this->language->get('err_phone');
        $err_email = $this->language->get('err_email');
        $err_invalid_email = $this->language->get('err_invalid_email');
        $err_message = $this->language->get('err_message');
        if (utf8_strlen($this->request->post['name']) < 1) {
            $this->error['name'] = $err_name;
        }
        if (utf8_strlen(trim($this->request->post['email'])) < 1) {
            $this->error['email'] = $err_email;
        } elseif (!filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
            $this->error['email'] = $err_invalid_email;
        }
        if (utf8_strlen($this->request->post['subject']) < 1) {
            $this->error['subject'] = $err_subject;
        }
        if (utf8_strlen($this->request->post['message']) < 1) {
            $this->error['message'] = $err_message;
        }
        if (utf8_strlen(trim($this->request->post['phone'])) < 1) {
            $this->error['phone'] = $err_phone;
        }
        return !$this->error;
    }
}
