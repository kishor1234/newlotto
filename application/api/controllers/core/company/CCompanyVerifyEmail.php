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

class CCompanyVerifyEmail extends CAaskController {

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

            $result = $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->update(array("isActive" => 1), "company") . $this->ask_mysqli->where($_POST, "AND"));
            if ($result) {
                echo json_encode(array("status" => "success", "message" => "Your email is verify successfully, login to continue.."));
            } else {
                echo json_encode(array("status" => "danger", "message" => "Your email is verify Faild, Try Again.."));
            }
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
