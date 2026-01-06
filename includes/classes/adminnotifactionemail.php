<?php 
class AdminNotificationEmail {
    private $config;
    private $data;
    private $template;
    protected $output;

    public function __construct($config) {
        $this->config = $config;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function setTemplate($template) {
        $this->template = $template;
    }

    public function sendNotification($toEmail, $subject) {
        $mail = new Mail();
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = "ssl";
        $mail->protocol = $this->config->get('config_mail_protocol');
        $mail->hostname = $this->config->get('config_mail_smtp_hostname');
        $mail->username = $this->config->get('config_mail_smtp_username');
        $mail->password = $this->config->get('config_mail_smtp_password');
        $mail->port = $this->config->get('config_mail_smtp_port');

        $emailTemp = $this->renderTemplate();

        $mail->setTo($toEmail);
        $mail->setFrom($toEmail);
        $mail->setReplyTo($toEmail);
        $mail->setSender($subject);
        $mail->setSubject($subject);
        $mail->setHtml($emailTemp);
        $mail->send();
    }

    private function renderTemplate() {
        if (file_exists(DIR_TEMPLATE . $this->template)) {
            extract($this->data);
            ob_start();
            require(DIR_TEMPLATE . $this->template);
            $this->output = ob_get_contents();
            ob_end_clean();
            return $this->output;
        }

    }
}
