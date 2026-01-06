<?php

class ControllerIntelligentPrint extends Controller
{
    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->registry->set('pcUrls', 'intelligent-print');
    }
    public function index()
    {
        $data = array();
        $this->load_model('page');
        $page_id =  $this->registry->get('slug_data')['slog_id'];
        $data['action'] = HTTPS_HOST . $this->registry->get('slug_data')['url'];
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
        $data['err_invalid_email'] = $this->language->get('err_invalid_email');
        $data['err_email'] = $this->language->get('err_email');
        $data['err_name'] = $this->language->get('err_name');
        $data['err_phone'] = $this->language->get('err_phone');
        $this->template = 'sharp/template/intelligent-print.tpl';
        $this->data = $data;
        $this->zones = array(
            'header',
            'menuinner',
            'footer'
        );
        $this->response->setOutput($this->render());
    }

     public function IntelligentPrintFormAjax() {
        $this->load_model('intelligentprint');
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
        if (!$this->validateForm()) {
            $json = array('error' => $this->error);
            $this->response->setOutput(json_encode($json));
            return;
        }
        $query = $this->model_intelligentprint->addIntelligentEnquiry($this->request->post);
        // $toEmail = $this->config->get('config_email_careers');
        $toEmail = 'mudasir@mailinator.com';
        $subject = 'Application from ' . $this->request->post['name'];
        $emaildata = array(
            'name' => $this->request->post['name'],
            'email' => $this->request->post['email'],
            'phone' => $this->request->post['phone'],
            'subject' => $this->request->post['subject'],
            'message' => $this->request->post['message'],
            'enquiry_from' => $this->request->post['enquiry_from']
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
        $this->template = 'sharp/template/mail/admin-intelligent-print.tpl';
        $this->data = $data;
        $mail->setHtml($this->render());
        $mail->send();
        $json['success'] = 'Your application has been sent!';
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
    return !$this->error;
  }
}
