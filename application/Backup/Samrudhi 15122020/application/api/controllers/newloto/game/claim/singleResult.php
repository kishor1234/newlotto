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

//header('Content-Type: application/json');

class singleResult extends CAaskController {

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
        switch ($data["series"]) {
            case "ALL":
                $this->AllResult($data);
                break;
            default :
                $this->defaultResult($data);
                break;
        }


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

    public function AllResult($data) {

        $gid = 0;

        if ($data["drawid"] == 0) {
            echo json_encode(array("status" => "0", "message" => "Draw avaliable after 10:15"));
            die;
        } elseif ($data["drawid"] == 49 && strtotime("22:15:00") < strtotime(date("H:i:s"))) {
            $gid = $data["drawid"];
        } else {
            $gid = $data["drawid"] - 1;
        }
        if ($gid == 0) {
            echo json_encode(array("status" => "0", "message" => "Draw avaliable after 10:15"));
            die;
        }
        $gid;
        $result = $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->selectSpacific(array("gameetime", "series", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9"), "winnumber") . $this->ask_mysqli->where(array("gdate" => date("Y-m-d"), "gameid" => $gid), "AND") . $this->ask_mysqli->orderBy("ASC", "series"));//. $this->ask_mysqli->limitWithOutOffset(3)
        $data2 = array();
        while ($row = $result->fetch_assoc()) {
            //unset($row["loadarray"]);
            array_push($data2, $row);
        }
        if (!empty($data2)) {
            echo json_encode(array("status" => "1", "message" => "Success", "data" => $data2));
        } else {
            echo json_encode(array("status" => "0", "message" => "Faield"));
        }
    }

    public function defaultResult($data) {
        $sql = $this->ask_mysqli->selectSpacific(array("gameetime", "series", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9"), "winnumber") . $this->ask_mysqli->where(array("gdate" => date("Y-m-d"), "series" => $data["series"]), "AND") . $this->ask_mysqli->orderBy("DESC", "gameid") . $this->ask_mysqli->limitWithOutOffset(1);
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        $data2 = array();
        while ($row = $result->fetch_assoc()) {
            //unset($row["loadarray"]);
            array_push($data2, $row);
        }
        if (!empty($data2)) {
            echo json_encode(array("status" => "1", "message" => "Success", "data" => $data2));
        } else {
            echo json_encode(array("status" => "0", "message" => "Faield"));
        }
    }

}
