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

class link extends CAaskController {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function create() {
        parent::create();
        if (!isset($_SESSION["email"])) {
            redirect(ASETS . "?r=" . $this->encript->encdata("main"));
        }
        return;
    }

    public function initialize() {
        parent::initialize();
        try {
            //echo $postdata = file_get_contents("php://input");
            
            if (isset($_POST["condition"])) {
                
                $this->isLoadView(array("header" => "header", "main" => $_REQUEST["v"], "footer" => "footer", "error" => "page_404"), false, array("title" => $_REQUEST["v"], "link" => array($_REQUEST["v"] => "#")));
            } else {
                
                $this->isLoadView(array("header" => "header", "main" => $_REQUEST["v"], "footer" => "footer", "error" => "page_404"), true, array("title" => $_REQUEST["v"], "link" => array($_REQUEST["v"] => "#")));
            }
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

}
