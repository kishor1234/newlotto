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

class gameChangePassword extends CAaskController {

    //put your code here
    public $data = array();

    public function __construct() {
        parent::__construct();
    }

    public function create() {
        parent::create();

        return;
    }

    public function initialize() {
        parent::initialize();

        return;
    }

    public function execute() {
        parent::execute();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $data = $request;

        $sql = $this->ask_mysqli->select("enduser", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("userid" => $data["userid"], "password" => $data["old"]), "AND");
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql); //!=true?array_push($error, $this->adminDB[$_SESSION["db_1"]]->error):true;
        if ($row = $result->fetch_assoc()) {
            $sql=$this->ask_mysqli->update(array("password"=>$data["new"]),"enduser").$this->ask_mysqli->whereSingle(array("userid"=>$data["userid"]));
            if ($this->adminDB[$_SESSION["db_1"]]->query($sql)) {
                //insert device
                echo json_encode(array("status" => "1", "message" => "Success"));
            } else {
                echo json_encode(array("status" => "0", "message" => "Error on Password change!"));
            }
        } else {
            echo json_encode(array("status" => "0", "message" => "Old Password Not Match!"));
        }
//        switch ($_POST["action"]) {
//            case "loadTable";
//                $this->loadTable();
//                break;
//
//            default :
//                echo json_encode(array("toast" => array("danger", "Series", "Invalid Sereis selected "), "status" => 0, "message" => "Invalid Series selected"));
//                break;
//        }
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
