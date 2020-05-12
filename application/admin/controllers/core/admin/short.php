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

class short extends CAaskController {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function create() {
        parent::create();

        return;
    }

    public function initialize() {
        parent::initialize();
        try {
            //echo $postdata = file_get_contents("php://input");
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => api_url.'/?r=GetLink',
                CURLOPT_USERAGENT => 'Codular Sample cURL Request',
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => [
                    id => $this->encript->decTxt($_REQUEST["p"])
                ]
            ]);
// Send the request & save response to $resp
            $resp = curl_exec($curl);
// Close request to clear up some resources date("Y-m-d H:i:s")
            curl_close($curl);

            $json = json_decode($resp, true);
            if ($json["isactive"] == 0 && $this->timeDifference($json["onCreate"], date("Y-m-d H:i:s")) <= $json["valid_time"]) {
                redirect($json["link"]);
            } else {
                $this->isLoadView(array("header" => null, "main" => "page404", "footer" => null, "error" => "page_404"), false, array("er_msg"=>"Request link is expaired now, please create new link."));
            }
            //$this->isLoadView(array("header" => null, "main" => "main", "footer" => null, "error" => "page_404"), false, array());
        } catch (Exception $ex) {
            echo $ex->getMessage();
            error_log($ex, 3, "error.log");
        }
        return;
    }

    public function execute() {
        parent::execute();
        return;
    }

    public function finalize() {
        parent::finalize();
        return;
    }

    public function reader() {
        parent::reader();
        return;
    }

    public function distory() {
        parent::distory();
        return;
    }

    function timeDifference($date1, $date2) {
        return (strtotime($date2) - strtotime($date1)) / 60;
    }

}
