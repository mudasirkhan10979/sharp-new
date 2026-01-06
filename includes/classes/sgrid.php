<?php 
class Sgrid { 
    protected $to;
    protected $config;
    protected $from;
    protected $return;
    protected $sender;
    protected $reply;
    protected $subject;
    protected $text;
    protected $html;
    protected $attachments = array();
    protected $headers = array();

    public $sg_apikey; 

    public $newline = "\n";
    public $crlf = "\r\n";
    public $verp = false;
    public $parameter = '';

    public function __construct($registry) { 
        $this->config = $registry->get('config');
        $this->sg_apikey=$this->config->get('config_sg_apikey');
    }

    public function tests()
    {
        echo 786;
    }

    public function setTo($to) {
        $this->to = $to;
    }

    public function setReplyTo($reply) {
        $this->reply = $reply;
    }

    public function setReturn($return) {
        $this->return = $return;
    }

    public function setFrom($from) {
        $this->from = $from;
    }

    public function setSender($sender) {
        $this->sender = $sender;
    }

    public function setSubject($subject) {
        $this->subject = $subject;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function setHtml($html) {
        $this->html = $html;
    }

    public function addAttachment($filename) {
        $this->attachments[] = $filename;
    }

    public function send() { 
        $to = array(); 
        if (is_array($this->to)) {
            $this_to = $this->to;
        } else {
            $this_to = explode(",",$this->to);      
        } 
        foreach ($this_to as $mail_to){
            $to[] = array('email' => trim($mail_to));
        }    
        $textorder = array("\r\n", "\n", "\r", PHP_EOL); 
        $mailtext = str_replace($textorder, "<br/>", $this->text); 
        $message = isset($this->html) ? $this->html : $mailtext; 
        if (!$this->reply_to) {
            $reply_to = $this->from;
        } else {
            $reply_to = $this->reply_to;
        }
        $personalizations = Array(
            "personalizations" => Array(
                0 => Array(
                    "to" => $to,
                    "subject" => $this->subject),
            ),
            "from" => Array(
                "email" => $this->from,
                "name" => $this->sender
            ),
            "reply_to" => Array(
                "email" => $reply_to
            ),
            "subject" => $this->subject,
            "content" => Array(
                0 => Array(
                    "type" => "text/html",
                    "value" => $message
                ))
        );
        
        if (is_array($this->attachments) && count($this->attachments) > 0){
            $personalizations['attachments'] = array();
            foreach ($this->attachments as $attachment) {
                if (file_exists($attachment)) { 
                    $attach_me = array(); 
                    $handle = fopen($attachment, 'r'); 
                    $content = fread($handle, filesize($attachment)); 
                    fclose($handle); 
                    $attach_me['content'] = base64_encode($content);
                    $attach_me['filename'] = basename($attachment); 
                    $personalizations['attachments'][] = $attach_me; 
                }
            }
        } 
        //For debug
        //echo json_encode($personalizations, JSON_PRETTY_PRINT); 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.sendgrid.com/v3/mail/send");
        curl_setopt($ch, CURLOPT_POST, true );
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($personalizations));
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true); 
        //If problems with the site's CA (like in a dev environment) you can uncomment this: Fixes curl SSL error.
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("authorization: Bearer ". $this->sg_apikey,"content-type: application/json"));
        
        $postResponse = curl_exec($ch);
        $err = curl_error($ch); 
        curl_close($ch); 
        if ($err) {
            echo "cURL Error #: " . $err;
        } else {
            echo $postResponse;
        }
    } 


    public function TestSendEmails($toemail='',$subject='',$message='')
    {
        // $message = htmlentities($message);
        // $from_rep = '"="';
        // $to_rep = "-";
        
        // echo $replaced = str_replace($from_rep, $to_rep, $message);
        // exit; 
        /*
            $to = array(); 
            if (is_array($this->to)) {
                $this_to = $this->to;
            } else {
                $this_to = explode(",",$this->to);      
            } 
            foreach ($this_to as $mail_to){
                $to[] = array('email' => trim($mail_to));
            }    
            $textorder = array("\r\n", "\n", "\r", PHP_EOL); 
            $mailtext = str_replace($textorder, "<br/>", $this->text); 
            $message = isset($this->html) ? $this->html : $mailtext; 
            if (!$this->reply_to) {
                $reply_to = $this->from;
            } else {
                $reply_to = $this->reply_to;
            }
        */
         // echo $message = '"'.  $message .'"';
         // echo $message;
         // exit;

        // echo $message;exit;

        $verified_snder = $this->config->get('config_sg_verify_sender_mail');
        $personalizations = '{
          "personalizations": [
            {
              "to": [
                { "email": "'. $toemail .'" },
              ]
            }
          ],
          "from": { "name": "Kelly", "email": "'.$verified_snder.'" },
          "subject": "'. $subject .'",
          "content": [
            {
              "value": "'. $message .'",
              "type": "text/html"
            }
           ]
        }';

        // echo $personalizations . '<hr>';exit;
        
        //For debug
        // echo json_encode($personalizations, JSON_PRETTY_PRINT); exit;
        $sg_apikey = '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';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.sendgrid.com/v3/mail/send");
        curl_setopt($ch, CURLOPT_POST, true );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $personalizations);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true); 
        //If problems with the site's CA (like in a dev environment) you can uncomment this: Fixes curl SSL error.
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_TIMEOUT, 300);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $sg_apikey,
        "cache-control: no-cache","Content-Type: application/json"));
        
        $postResponse = curl_exec($ch);
        $err = curl_error($ch); 
        curl_close($ch); 
        if ($err) {
            echo "cURL Error #: " . $err;
        } else {
            echo $postResponse;
        }
        echo  '<hr>' . $personalizations ;
    } 
}