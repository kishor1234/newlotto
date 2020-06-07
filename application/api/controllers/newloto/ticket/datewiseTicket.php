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

class datewiseTicket extends CAaskController {

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
        $sql = $this->ask_mysqli->select("usertranscation", $_SESSION["db_1"]) . $this->ask_mysqli->where($request, "AND").$this->ask_mysqli->orderBy("DESC","id");//.$this->ask_mysqli->limitWithOutOffset(4);
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        $i = 1;
        $resultArray = array();
        while ($row = $result->fetch_assoc()) {
            array_push($resultArray, array("srno" => $i, "utrno" => $row["trno"],"userid" => $row["userid"], "amount" => $row["netamt"], "date" => $row["on_create"],"active"=>$row["active"]));
            $i++;
        }
        echo json_encode($resultArray);
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
