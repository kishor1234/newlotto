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

class reset extends CAaskController {

    //put your code here
    //request e=email and i=id
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
                CURLOPT_URL => api_url . '/?r=CGetUserData',
                CURLOPT_USERAGENT => 'Codular Sample cURL Request',
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => [
                    id => $this->encript->decTxt($_REQUEST["i"]),
                    email => $this->encript->decTxt($_REQUEST["e"])
                ]
            ]);
// Send the request & save response to $resp
            $resp = curl_exec($curl);
// Close request to clear up some resources date("Y-m-d H:i:s")
            curl_close($curl);

            $json = json_decode($resp, true);

            $this->isLoadView(array("header" => "webheader", "main" => "VRestPasswrod", "footer" => "webfooter", "error" => "page_404"), true, $json);
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
