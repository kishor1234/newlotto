<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of reprintTicket
 *
 * @author asksoft
 */
defined('BASEPATH') OR exit('No direct script access allowed');

//require_once getcwd() . '/' . APPLICATION . "/controllers/Crout.php";
require_once controller;

//header('Content-Type: application/json');

class reprintDesktopPrint extends CAaskController {

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
        $sql = $this->ask_mysqli->select("entry", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle($request);
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        $finalArray=array();
        if ($row = $result->fetch_assoc()) {
            $final = array(
                "own" => $row["own"],
                "totalpoint" => $row["totalpoint"],
                "amount" => $row["amount"],
                "enterydate" => $row["enterydate"],
                "winstatus" => $row["winstatus"],
                "winamt" => $row["winamt"],
                "claimstatus" => $row["claimstatus"],
                "ip" => $row["ip"],
                "gametime" => $row["gametime"],
                "gameendtime" => $row["gameendtime"],
                "gametimeid" => $row["gametimeid"],
                "game" => $row["game"],
                "point" => json_decode($row["point"],true)
            );
            array_push($finalArray, $final);
            echo json_encode(array("status" => "1", "msg" => "Success", "print" => $finalArray));
            
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

}
