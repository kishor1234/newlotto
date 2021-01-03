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

class gamelogin extends CAaskController {

    //put your code here
    public $data = array();

    public function __construct() {
        parent::__construct();
    }

    public function create() {
        parent::create();
        if (!isset($_SESSION["id"])) {
            // redirect(HOSTURL . "?r=" . $this->encript->encdata("main"));
        }
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
        $data["is_active"]="1";
        unset($data["device"]);
        $sql = $this->ask_mysqli->select("enduser", $_SESSION["db_1"]) . $this->ask_mysqli->where($data, "AND");
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql); //!=true?array_push($error, $this->adminDB[$_SESSION["db_1"]]->error):true;
        if ($row = $result->fetch_assoc()) {
            if (empty($row["device"])) {
                //insert device
                $sql=$this->ask_mysqli->update(array("device"=>$request["device"]),"enduser").$this->ask_mysqli->whereSingle(array("id"=>$row["id"]));
                $this->adminDB[$_SESSION["db_1"]]->query($sql);
                echo json_encode(array("status" => "1", "message" => "login Success..{$sql}", "id" => $row["id"], "userid" => $row["userid"],"name" => $row["name"],"cdate"=>date("d-m-Y")));
            } else if ($row["device"] === $request["device"]) {
                echo json_encode(array("status" => "1", "message" => "login Success..", "id" => $row["id"], "userid" => $row["userid"],"name" => $row["name"],"cdate"=>date("d-m-Y")));
            } else {
                echo json_encode(array("status" => "0", "message" => "Invalid Device"));
            }
        } else {
            echo json_encode(array("status" => "0", "message" => "Invalid userid or password!"));
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
