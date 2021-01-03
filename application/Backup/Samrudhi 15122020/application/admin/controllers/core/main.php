<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of login
 *
 * @author asksoft
 */
//die(APPLICATION);
//require_once getcwd() . '/' . APPLICATION . "/controllers/Crout.php";
require_once controller;

class main extends CAaskController {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function create() {
        parent::create();
        if (isset($_SESSION["email"])) {
            redirect(ASETS . "?r=" . $this->encript->encdata("dashboard") . "&v=dashboard");
        }
        return;
    }

    public function initialize() {
        parent::initialize();
        try {

//            $sql = $this->ask_mysqli->select("hostuser", $_SESSION["db_1"]);
//            $result = $this->executeQuery($_SESSION["db_1"], $sql);
//            while ($row = $result->ftech_assoc()) {
//                print_r($row);
//                echo "<br>";
//            }
//            $file=array(
//                "path"=>"/var/www/html/askfw/contributing.md",
//                "name"=>"contributing.md",
//                "encoding"=>"base64",
//                "type"=>"application/text"
//            );
            //$this->mailObject->sendmailWithoutAttachment("kishor4shinde@gmail.com", "info@aasksoft.com", "@askSoft", "Test Mail", "TestMal",array());
            //$json_array=  json_decode($this->ask_sms->getfast2smsBalance(),true);
            // echo $data=$this->ask_sms->sendPostSMS("7030396972","Drear Shona ILU","p");
            // $json_array=  json_decode($data,true);
//            if($json_array["return"])
//           {
//               echo "Balance : ". $json_array["wallet"];
//           }
            //print_r($yourbrowser);
            //die;
            
            $this->isLoadView(array("header" => "webheader", "main" => "main", "footer" => "webfooter", "error" => "page_404"), true, array());
        } catch (Exception $ex) {
            echo $ex->getMessage();
            error_log($ex, 3, "error.log");
        }
        return;
    }

    public function execute() {
        //parent::execute();
        return;
    }

    public function finalize() {
        //parent::finalize();
        return;
    }

    public function reader() {
        //parent::reader();
        return;
    }

    public function distory() {
        //parent::distory();
        return;
    }

}
