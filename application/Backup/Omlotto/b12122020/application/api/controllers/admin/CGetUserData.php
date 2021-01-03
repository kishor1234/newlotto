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

class CGetUserData extends CAaskController {

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
            
            $result = $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->select("admin", $_SESSION["db_1"]) . $this->ask_mysqli->where($_POST,"AND"));
            if ($row = $result->fetch_assoc()) {
                unset($row["password"]);
                echo json_encode($row);
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
