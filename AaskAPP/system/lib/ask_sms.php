<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ask_sms
 *
 * @author asksoft
 */
require_once getcwd() . '/AaskAPP/system/_configuration.php';
error_reporting(0);

class ask_sms extends _configuration {

    public function __construct() {
        parent::__construct();
        return;
    }

    public function getfast2smsBalance() {
        $curl = curl_init();
        curl_setopt_array($curl, array(CURLOPT_URL => "https://www.fast2sms.com/dev/wallet",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array("authorization: " . $this->_fast2sms["api-key"]),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        } else {
            return $response;
        }
    }

    public function sendPostSMS($number, $msg, $route) {
        try {
            $fields = array(
                "sender_id" => $this->_fast2sms["senderid"],
                "message" => $msg,
                "language" => "english",
                "route" => $route,
                "numbers" => $number//,
                //"variables" => "{#AA#}|{#CC#}",
                //"variables_values" => "12345|asdaswdx"
            );
            //print_r($fields);die;
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://www.fast2sms.com/dev/bulk",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($fields),
                CURLOPT_HTTPHEADER => array(
                    "authorization: " . $this->_fast2sms["api-key"],
                    "accept: */*",
                    "cache-control: no-cache",
                    "content-type: application/json"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                throw new Exception("cURL Error #:" . $err);
            } else {
                return $response;
            }
        } catch (Exception $ex) {
            echo "Error Messaage : " . $ex->getMessage();
        }
    }

    //put your code here
}
