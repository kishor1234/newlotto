<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ask_mailer
 *
 * @author asksoft
 */
require_once getcwd() . '/AaskAPP/system/_configuration.php';
require_once 'class.phpmailer.php';
error_reporting(0);

class ask_mailer extends _configuration {

    //put your code here
    public $mail;

    public function __construct() {
        parent::__construct();
        $this->mail = new PHPMailer();

        return;
    }

    function _confiMail() {
        $this->mail->IsSMTP();
        $this->mail->SMTPDebug = 0;
        $this->mail->SMTPAuth = TRUE;
        $this->mail->SMTPSecure = "tls";
        $this->mail->Port = $this->_mailConfiguration["post"];
        $this->mail->Username = $this->_mailConfiguration["email"];
        $this->mail->Password = $this->_mailConfiguration["password"];
        $this->mail->Host = $this->_mailConfiguration["host"];
        $this->mail->Mailer = $this->_mailConfiguration["protocol"];
        return $this->mail;
    }

    public function sendmailWithoutAttachment($reciver, $sender, $sendername, $msg, $subject, $file) {
        $this->mail = $this->_confiMail();
        $this->mail->SetFrom($sender, $sendername);
        $this->mail->AddReplyTo($sender, $sendername);
        $this->mail->AddAddress($reciver);
        $this->mail->Subject = $subject;
        $this->mail->WordWrap = 80;
        $this->mail->MsgHTML($msg);
        $this->mail->IsHTML(true);
        if (!empty($file)) {
            $this->mail->addAttachment($file["path"], $file["name"], $file["encoding"], $file["type"]);
        }if (!$this->mail->Send()) {
            //echo "<p class='error'>Problem in Sending Mail.</p>";
            error_log("Problem in sending mail.. ".$reciver."  Status=:Failed  Time:".date("Y-m-d h:i:sa")."\n", 3, "mail_error.log"); 
            return false;
        } else {
            //echo "<p class='success'>Contact Mail Sent.</p>";
            error_log("Success sending mail.. ".$reciver."  Status=:Success  Time:".date("Y-m-d h:i:sa")."\n", 3, "mail_success.log"); 
            return true;
        }
    }
    public function sendmailWithAttachment($reciver, $sender, $sendername, $msg, $subject, $file) {
        $this->mail = $this->_confiMail();
        $this->mail->SetFrom($sender, $sendername);
        $this->mail->AddReplyTo($sender, $sendername);
        $this->mail->AddAddress($reciver);
        $this->mail->Subject = $subject;
        $this->mail->WordWrap = 80;
        $this->mail->MsgHTML($msg);
        $this->mail->IsHTML(true);
        if (!empty($file)) {
             $this->mail->AddStringAttachment($file["path"], $file["name"], $file["encoding"], $file["type"],"attachment");
        }if (!$this->mail->Send()) {
            //echo "<p class='error'>Problem in Sending Mail.</p>";
            error_log("Problem in sending mail.. ".$reciver."  Status=:Failed  Time:".date("Y-m-d h:i:sa")."\n", 3, "mail_error.log"); 
            return false;
        } else {
            //echo "<p class='success'>Contact Mail Sent.</p>";
            error_log("Success sending mail.. ".$reciver."  Status=:Success  Time:".date("Y-m-d h:i:sa")."\n", 3, "mail_success.log"); 
            return true;
        }
    }

}
