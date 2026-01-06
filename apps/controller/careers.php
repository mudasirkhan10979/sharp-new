<?php
class ControllerCareers extends Controller
{
    private $error = array();
    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->registry->set('pcUrls', 'careers');
    }
    public function index()
    {
        $this->load_model('careers');
        $this->load_model('home');
        $this->load_model('page');
        $page_id =  $this->registry->get('slug_data')['slog_id'];
        $data['action'] = HTTPS_HOST . 'careers';
        $page = $this->model_page->getPage($page_id);
        if (empty($page)) {
            $this->redirect(HTTPS_HOST . 'error404');
            exit;
        }
        $short_description =  strip_tags(html_entity_decode($page['short_description'], ENT_QUOTES, 'UTF-8'));
        if ($page['banner_image']) {
            $image = BASE_URL . "uploads/image/pages/" . $page['banner_image'];
        } else {
            $image = BASE_URL . "uploads/default_banner.jpg";
        }
        $data['banner'] = array(
            'title'              => $page['name'],
            'short_description' => $short_description,
            'image'             => $image
        );

        $blockemployeebenefits = $this->model_home->getHtmlBlock('block-employee-benefits');
        if (!empty($blockemployeebenefits['content'])) {
            $blockemployeebenefits['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockemployeebenefits['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockemployeebenefits'] = $blockemployeebenefits;

        $blockloremipsumdolor1 = $this->model_home->getHtmlBlock('block-lorem-ipsum-dolor1');
        if (!empty($blockloremipsumdolor1['content'])) {
            $blockloremipsumdolor1['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockloremipsumdolor1['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockloremipsumdolor1'] = $blockloremipsumdolor1;

        $blockloremipsumdolor2 = $this->model_home->getHtmlBlock('block-lorem-ipsum-dolor2');
        if (!empty($blockloremipsumdolor2['content'])) {
            $blockloremipsumdolor2['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockloremipsumdolor2['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockloremipsumdolor2'] = $blockloremipsumdolor2;

        $blockloremipsumdolor3 = $this->model_home->getHtmlBlock('block-lorem-ipsum-dolor3');
        if (!empty($blockloremipsumdolor3['content'])) {
            $blockloremipsumdolor3['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockloremipsumdolor3['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockloremipsumdolor3'] = $blockloremipsumdolor3;

        $blockloremipsumdolor4 = $this->model_home->getHtmlBlock('block-lorem-ipsum-dolor4');
        if (!empty($blockloremipsumdolor4['content'])) {
            $blockloremipsumdolor4['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockloremipsumdolor4['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockloremipsumdolor4'] = $blockloremipsumdolor4;

        $blockcompanyculture = $this->model_home->getHtmlBlock('block-company-culture');
        if (!empty($blockcompanyculture['content'])) {
            $blockcompanyculture['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockcompanyculture['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockcompanyculture'] = $blockcompanyculture;

        $blockimagecompanyculture = $this->model_home->getHtmlBlockImages('block-image-company-culture');
        $data['blockimagecompanyculture'] = $blockimagecompanyculture;

        $data['careers'] = array();
        $limit = 6;

        if (isset($this->request->get['page'])) {
            $page_num = (int)$this->request->get['page'];
        } else {
            $page_num = 1;
        }

        $filter_title = isset($this->request->get['filter_title']) ? $this->db->escape($this->request->get['filter_title']) : '';
        $filter_location = isset($this->request->get['filter_location']) ? $this->db->escape($this->request->get['filter_location']) : '';
        $filter_jobtype = isset($this->request->get['filter_jobtype']) ? (int)$this->request->get['filter_jobtype'] : 0;

        $filterData = array(
            'start' => ($page_num - 1) * $limit,
            'limit' => $limit,
            'filter_title' => $filter_title,
            'filter_location' => $filter_location,
            'filter_jobtype' => $filter_jobtype
        );

        $careers = $this->model_careers->getCareers($filterData);

        foreach ($careers as $career) {
            $data['careers'][] = [
                'career_id' => $career['id'],
                'title' => $career['title'],
                'short_description' => $career['short_description'],
                'jobtype_name' => $career['jobtype_name'],
                'location_title' => $career['location_title'],
                'publish_date' =>  $career['publish_date'],
                'url' => HTTPS_HOST . 'careers/' . $career['seo_url']
            ];
        }

        $data["clearBtnStatus"] = (
            (count(array_filter($this->request->get, 'strlen')) === 0)) ? false : true;

        $data['text_load_more'] =  $this->language->get('text_load_more');
        $data['text_no_record'] =  $this->language->get('text_no_record');

        $total = $this->model_careers->getTotalCareers($filterData);

        $pagination = new Pagination();
        $pagination->total = $total;
        $pagination->page = $page_num;
        $pagination->limit = $limit;

        $url_params = [];
        if (!empty($filter_title)) $url_params['filter_title'] = $filter_title;
        if (!empty($filter_location)) $url_params['filter_location'] = $filter_location;
        if (!empty($filter_jobtype)) $url_params['filter_jobtype'] = $filter_jobtype;

        $url_suffix = !empty($url_params) ? '&' . http_build_query($url_params) : '';
        $pagination->url = HTTPS_HOST . 'careers' . '?page={page}' . $url_suffix;

        $pagination->text_first = '';
        $pagination->text_last = '';

        if ($total > $limit) {
            $data['pagination'] = $pagination->render();
        } else {
            $data['pagination'] = '';
        }

        $data['jobtypes'] = $this->model_careers->getjobtypes();
        $data['locations'] = $this->model_careers->getLocations();
        $data['text_recusandae'] =  $this->language->get('text_recusandae');
        $data['text_check_vacancies'] =  $this->language->get('text_check_vacancies');
        $data['heading_title'] =  $this->language->get('heading_title');
        $data['current_filters'] = [
            'title' => $filter_title,
            'location' => $filter_location,
            'jobtype' => $filter_jobtype
        ];
        $data['text_recusandae'] =  $this->language->get('text_recusandae');
        $data['text_check_vacancies'] =  $this->language->get('text_check_vacancies');
        $data['heading_title'] =  $this->language->get('heading_title');
        if (isset($this->session->data['career_success'])) {
            $data['career_success'] = $this->session->data['career_success'];
            unset($this->session->data['career_success']);
        }
        $data['siteKey'] = $this->config->get('config_google_captcha_public');
        $data['err_captcha'] = $this->language->get('err_captcha');
        $data['text_back'] =  $this->language->get('text_back');
        $data['text_full_name'] =  $this->language->get('text_full_name');
        $data['text_phone'] =  $this->language->get('text_phone');
        $data['text_contact_email'] =  $this->language->get('text_contact_email');
        $data['text_details'] =  $this->language->get('text_details');
        $data['text_apply_now'] =  $this->language->get('text_apply_now');
        $data['text_no_record'] =  $this->language->get('text_no_record');
        $data['text_job_type'] =  $this->language->get('text_job_type');
        $data['text_btn_submit'] =  $this->language->get('text_btn_submit');
        $data['text_submit_y_resume'] =  $this->language->get('text_submit_y_resume');
        $data['text_lorem_ipsum'] =  $this->language->get('text_lorem_ipsum');
        $data['err_name'] = $this->language->get('err_name');
        $data['err_email'] = $this->language->get('err_email');
        $data['err_invalid_email'] = $this->language->get('err_invalid_email');
        $data['err_phone'] = $this->language->get('err_phone');
        $data['err_cv'] = $this->language->get('err_cv');
        $data['err_invalid_cv'] = $this->language->get('err_invalid_cv');
        $data['err_invalid_phone'] =  $this->language->get('err_invalid_phone');
        $data['text_job_type'] = $this->language->get('text_job_type');
        $data['text_filter'] = $this->language->get('text_filter');
        $data['text_search'] = $this->language->get('text_search');
        $data['view_details'] = $this->language->get('view_details');
        $data['text_search_job'] = $this->language->get('text_search_job');
        $data['text_search_location'] = $this->language->get('text_search_location');
        $data['text_load_more'] = $this->language->get('text_load_more');
        $data['text_did_not_find'] = $this->language->get('text_did_not_find');
        $data['text_send_your_cv'] = $this->language->get('text_send_your_cv');
        $data['subject_lab'] = $this->language->get('subject_lab');
        $data['message_lab'] = $this->language->get('message_lab');
        $data['text_drag_your_resume'] = $this->language->get('text_drag_your_resume');
        $data['text_acceptable_file'] = $this->language->get('text_acceptable_file');
        $data['text_subject_error'] = $this->language->get('text_subject_error');
        $data['text_message_error'] = $this->language->get('text_message_error');
        $data['text_file_error'] = $this->language->get('text_file_error');
        $this->template = 'sharp/template/careers.tpl';
        $this->data = $data;
        $this->zones = array(
            'header',
            'footer',
            'menuinner'
        );
        $this->response->setOutput($this->render());
    }
    public function ajaxCareers()
    {
        $this->load_model('careers');
        $page = isset($this->request->post['page']) ? (int)$this->request->post['page'] : 1;
        $limit = 6;
        $filter_title = isset($this->request->post['filter_title']) ? $this->db->escape($this->request->post['filter_title']) : '';
        $filter_location = isset($this->request->post['filter_location']) ? $this->db->escape($this->request->post['filter_location']) : '';
        $filter_jobtype = isset($this->request->post['filter_jobtype']) ? (int)$this->request->post['filter_jobtype'] : 0;
        $filterData = array(
            'start' => ($page - 1) * $limit,
            'limit' => $limit,
            'filter_title' => $filter_title,
            'filter_location' => $filter_location,
            'filter_jobtype' => $filter_jobtype
        );
        $careers = $this->model_careers->getCareers($filterData);
        $formatted_careers = [];
        foreach ($careers as $career) {
            $formatted_careers[] = [
                'career_id' => $career['id'],
                'title' => $career['title'],
                'short_description' => $career['short_description'],
                'jobtype_name' => $career['jobtype_name'],
                'location_title' => $career['location_title'],
                'publish_date' => date('d M Y', strtotime($career['publish_date'])),
                'url' => HTTPS_HOST . 'careers/' . $career['seo_url']
            ];
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode([
            'success' => true,
            'careers' => $formatted_careers,
            'total'   => $this->model_careers->getTotalCareers($filterData),
            'has_more' => ($page * $limit) < $this->model_careers->getTotalCareers($filterData)
        ]));
    }
    public function detail()
    {

        $data['careerDetail'] = array();
        $data['action'] = HTTPS_HOST . $this->registry->get('slug_data')['url'];
        $data['siteKey'] = $this->config->get('config_google_captcha_public');
        $data['err_captcha'] = $this->language->get('err_captcha');
        $this->load_model('careers');
        $this->load_model('home');
        $career_id =  $this->registry->get('slug_data')['slog_id'];
        $careerDetail = $this->model_careers->getCareerDetails($career_id);
        if (!$career_id || !array_filter($careerDetail) || (isset($careerDetail['publish']) && $careerDetail['publish'] == 0)) {
            $this->redirect(HTTPS_HOST . 'error404');
            exit;
        }
        $data['career_id'] = $career_id;
        if ($careerDetail) {
            $banner_image = BASE_URL . "uploads/default_banner.jpg";
            $job_description =  str_replace('&nbsp;', ' ', html_entity_decode($careerDetail['job_description'], ENT_QUOTES, 'UTF-8'));
            $key_description =  str_replace('&nbsp;', ' ', html_entity_decode($careerDetail['key_description'], ENT_QUOTES, 'UTF-8'));
            $requirements_description =  str_replace('&nbsp;', ' ', html_entity_decode($careerDetail['requirements_description'], ENT_QUOTES, 'UTF-8'));
            $skills_description =  str_replace('&nbsp;', ' ', html_entity_decode($careerDetail['skills_description'], ENT_QUOTES, 'UTF-8'));
            $benefits_description =  str_replace('&nbsp;', ' ', html_entity_decode($careerDetail['benefits_description'], ENT_QUOTES, 'UTF-8'));
            $data['careerDetail'] = array(
                'banner_image'          => $banner_image,
                'title'                 => $careerDetail['title'],
                'publish_date'            => $careerDetail['publish_date'],
                'location_title'        => $careerDetail['location_title'],
                'jobtype_name'           => $careerDetail['jobtype_name'],
                'job_description'                => $job_description,
                'key_description'                => $key_description,
                'requirements_description'           => $requirements_description,
                'skills_description'                 => $skills_description,
                'benefits_description'                => $benefits_description

            );
        }
        $data['action'] = HTTP_HOST . $this->registry->get('slug_data')['url'];
        $cleaned_description = strip_tags(html_entity_decode($careerDetail['description'], ENT_QUOTES, 'UTF-8'));
        $trimmed_description = substr($cleaned_description, 0, 250);
        $this->document->addFBMeta('og:image', $banner_image);
        $this->document->addFBMeta('og:title', $careerDetail['title']);
        $this->document->addFBMeta('og:url', $data['action']);
        $this->document->addFBMeta('og:description', $trimmed_description);
        $this->document->addFBMeta('og:width', '400');
        $this->document->addFBMeta('og:height', '300');
        $this->document->addTWMeta('twitter:image', $banner_image . "?" . time());
        $this->document->addTWMeta('twitter:title', $careerDetail['name']);
        $this->document->addTWMeta('twitter:description', $trimmed_description);
        $this->document->addTWMeta('twitter:card', 'summary_large_image');
        $this->document->addTWMeta('twitter:site', 'Noir Cinema');
        if ($careerDetail['meta_description']) {
            $cleaned_descrition =  strip_tags(html_entity_decode($careerDetail['meta_description'], ENT_QUOTES, 'UTF-8'));
            $metaDescription = substr($cleaned_descrition, 0, 160);

            $this->document->setDescription($metaDescription);
        } elseif ($careerDetail['description']) {
            $cleaned_descrition =  strip_tags(html_entity_decode($careerDetail['description'], ENT_QUOTES, 'UTF-8'));
            $metaDescription = substr($cleaned_descrition, 0, 160);
            $this->document->setDescription($metaDescription);
        }
        if ($careerDetail['meta_keyword']) {
            $this->document->setKeywords($careerDetail['meta_keyword']);
        } elseif ($careerDetail['title']) {
            $this->document->setKeywords($careerDetail['title']);
        }
        if ($careerDetail['meta_title']) {
            $this->document->setTitle($careerDetail['meta_title']);
        } elseif ($careerDetail['title']) {
            $this->document->setTitle($careerDetail['title']);
        }
        $data['share_links'] = array(
            'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($data['action']),
            'twitter'  => 'https://twitter.com/intent/tweet?text=' . urlencode($trimmed_description) . '&url=' . urlencode($data['action']),
            // Instagram - only link to your profile (sharing not supported)
            'instagram' => 'https://www.instagram.com/yourprofile/',
            // YouTube - only link to your channel (sharing not supported)
            'youtube'   => 'https://www.youtube.com/@yourchannel',
            // WhatsApp - allows sharing with a message
            'whatsapp'  => 'https://api.whatsapp.com/send?text=' . urlencode($careerDetail['title'] . ' - ' . $data['action'])
        );
        if (isset($this->session->data['career_success'])) {
            $data['career_success'] = $this->session->data['career_success'];
            unset($this->session->data['career_success']);
        }
        $data['text_back'] =  $this->language->get('text_back');
        $data['text_upload_resume'] =  $this->language->get('text_upload_resume');
        $data['text_upload_y_resume'] =  $this->language->get('text_upload_y_resume');
        $data['text_full_name'] =  $this->language->get('text_full_name');
        $data['text_phone'] =  $this->language->get('text_phone');
        $data['text_contact_email'] =  $this->language->get('text_contact_email');
        $data['text_contact_address'] =  $this->language->get('text_contact_address');
        $data['text_job_nationality'] =  $this->language->get('text_job_nationality');
        $data['text_job_position'] =  $this->language->get('text_job_position');
        $data['text_salary'] =  $this->language->get('text_salary');
        $data['text_salary_per_month'] =  $this->language->get('text_salary_per_month');
        $data['text_details'] =  $this->language->get('text_details');
        $data['text_apply_now'] =  $this->language->get('text_apply_now');
        $data['text_read_more'] =  $this->language->get('text_read_more');
        $data['text_no_record'] =  $this->language->get('text_no_record');
        $data['text_share'] =  $this->language->get('text_share');
        $data['text_job_function'] =  $this->language->get('text_job_function');
        $data['text_industry'] =  $this->language->get('text_industry');
        $data['text_job_type'] =  $this->language->get('text_job_type');
        $data['text_full_time'] =  $this->language->get('text_full_time');
        $data['text_half_time'] =  $this->language->get('text_half_time');
        $data['text_btn_submit'] =  $this->language->get('text_btn_submit');
        $data['text_submit_y_resume'] =  $this->language->get('text_submit_y_resume');
        $data['text_lorem_ipsum'] =  $this->language->get('text_lorem_ipsum');
        $bapplynow = $this->model_home->getHtmlBlock('apply-now');
        if (!empty($bapplynow['content'])) {
            $bapplynow['content'] = str_replace('&nbsp;', ' ', html_entity_decode($bapplynow['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['bapplynow'] = $bapplynow;
        $career_location = $this->model_careers->getlocations();
        $data['career_location'] = $career_location;
        $data['err_name'] = $this->language->get('err_name');
        $data['err_email'] = $this->language->get('err_email');
        $data['err_invalid_email'] = $this->language->get('err_invalid_email');
        $data['err_phone'] = $this->language->get('err_phone');
        $data['err_cv'] = $this->language->get('err_cv');
        $data['err_invalid_cv'] = $this->language->get('err_invalid_cv');
        $data['err_invalid_phone'] =  $this->language->get('err_invalid_phone');
        $data['err_nationality'] = $this->language->get('err_nationality');
        $data['text_back'] = $this->language->get('text_back');
        $data['text_only_share'] = $this->language->get('text_only_share');
        $data['subject_lab'] = $this->language->get('subject_lab');
        $data['message_lab'] = $this->language->get('message_lab');
        $data['text_drag_your_resume'] = $this->language->get('text_drag_your_resume');
        $data['text_acceptable_file'] = $this->language->get('text_acceptable_file');
        $data['text_message_error'] = $this->language->get('text_message_error');
        $data['text_subject_error'] = $this->language->get('text_subject_error');
        $data['text_file_error'] = $this->language->get('text_file_error');
        $this->template = 'sharp/template/careers-details.tpl';
        $this->data = $data;
        $this->zones = ['header', 'footer', 'menuinner'];
        $this->response->setOutput($this->render());
    }

    public function careersContactUsForm()
    {
        $this->load_model('careers');

        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            if (!$this->validateForm()) {
                $json = array('error' => $this->error);
                $this->response->setOutput(json_encode($json));
                return;
            }
            $query = $this->model_careers->addCareerEnquiry($this->request->post);
            $toEmail = $this->config->get('config_email_careers');
            $subject = 'Application from ' . $this->request->post['name'];
            $emaildata = array(
                'name' => $this->request->post['name'],
                'email' => $this->request->post['email'],
                'phone' => $this->request->post['phone'],
                'subject' => $this->request->post['subject'],
                'message' => $this->request->post['message'],
                'cv_file' => BASE_URL . 'uploads/image/careers/cvs/' . $query
            );
            $data = [
                'emailData' => $emaildata
            ];
            $mail = new Mail();
            $mail->protocol = $this->config->get('config_mail_protocol');
            $mail->hostname = $this->config->get('config_mail_smtp_hostname');
            $mail->username = $this->config->get('config_mail_smtp_username');
            $mail->password = $this->config->get('config_mail_smtp_password');
            $mail->port = $this->config->get('config_mail_smtp_port');
            $mail->setTo($toEmail);
            $mail->setFrom($toEmail);
            $mail->setSender('Sharp');
            $mail->setSubject($subject);
            $this->template = 'sharp/template/mail/admin-notification-careers.tpl';
            $this->data = $data;
            $mail->setHtml($this->render());
            $mail->send();
            $json['success'] = $this->language->get('text_success_newsletter');
            $this->response->setOutput(json_encode($json));
            return;
        }
    }

    protected function validateForm()
    {
        $err_name = $this->language->get('err_name');
        $err_email = $this->language->get('err_email');
        $err_invalid_email = $this->language->get('err_invalid_email');
        $err_phone = $this->language->get('err_phone');
        $err_cv = $this->language->get('err_cv');
        $err_invalid_cv = $this->language->get('err_invalid_cv');
        $err_captcha = $this->language->get('err_captcha');
        if ((utf8_strlen($this->request->post['name']) < 1)) {
            $this->error['name'] = $err_name;
        }
        if ((utf8_strlen(trim($this->request->post['email'])) < 1)) {
            $this->error['email'] = $err_email;
        } elseif (!filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
            $this->error['email'] = $err_invalid_email;
        }
        if ((utf8_strlen(trim($this->request->post['phone'])) < 1)) {
            $this->error['phone'] = $err_phone;
        } elseif (!preg_match('/^\+?[0-9]{7,15}$/', $this->request->post['phone'])) {
            $this->error['phone'] = 'Phone number must not exceed 15 digits';
        }
        if ((utf8_strlen($this->request->post['subject']) < 1)) {
            $this->error['subject'] = 'Please provide your subject';
        }
        if ((utf8_strlen($this->request->post['message']) < 1)) {
            $this->error['message'] = 'Please provide your message';
        }
        if ($_FILES["cv_file"]["name"] == "") {
            $this->error['cv_file'] = $err_cv;
        } else {
            $file_extension = strtolower(pathinfo($_FILES["cv_file"]["name"], PATHINFO_EXTENSION));
            $allowed_extensions = array('pdf', 'doc', 'docx');
            $maxFileSize = 5 * 1024 * 1024;
            if (!in_array($file_extension, $allowed_extensions)) {
                $this->error['cv_file'] = $err_invalid_cv;
            } elseif ($_FILES["cv_file"]["size"] > $maxFileSize) {
                $this->error['cv_file'] = 'File size must not exceed 5MB.';
            }
        }
        $token = $this->request->post['recaptcha_token'] ?? '';
        $recaptcha_verified = $this->verifyRecaptcha($token);
        if (!$recaptcha_verified) {
            $this->error['recaptcha'] = $err_captcha;
        }
        return !$this->error;
    }
    private function verifyRecaptcha($token)
    {
        $secret_key = $this->config->get('config_google_captcha_secret');
        if (empty($token)) {
            return false;
        }
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret' => $secret_key,
            'response' => $token
        ];
        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            ]
        ];
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $result = json_decode($response, true);
        return $result['success'] && $result['score'] >= 0.5;
    }
}
