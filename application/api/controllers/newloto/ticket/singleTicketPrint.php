<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of singleTicketPrint
 *
 * @author asksoft
 */
defined('BASEPATH') OR exit('No direct script access allowed');

//require_once getcwd() . '/' . APPLICATION . "/controllers/Crout.php";
require_once controller;

//header('Content-Type: application/json');

class singleTicketPrint extends CAaskController {

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
        //$_REQUEST["game"] = "ask5ed8bdb0d27d4";
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $sql = $this->ask_mysqli->select("entry", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("game" => $request["game"],"own"=>$request["own"]),"AND");
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        $v = 0;
        $i = 1;
        $temp = array();
        if ($row = $result->fetch_assoc()) {
            $myPoint = json_decode($row["point"], true);
            foreach ($myPoint as $Key => $Array) {
                foreach ($Array as $_1key => $_1array) {//1000-1900
                    foreach ($_1array as $_2key => $_2array) {//1800
                        //echo $_2key;
                        foreach ($_2array as $in => $valArray) {//1800
                            foreach ($valArray as $index => $value) {//point
                                $indV = $_2key + $index;
                                $v = $v + $value;
                                array_push($temp, array("srno" => $i, "drDate" => $row["enterydate"], "drTime" => $row["gametimeid"], "name" => "RajLaxmi", "mrp" => ($value * 2), "digit" => $indV, "qty" => $value));
                                $i++;
                            }
                        }
                    }
                }
            }
            echo json_encode(array("status" => "1", "msg" => "This is to certify that,the Cash Memo/Invoice (T. No.{$row["trno"]} of Rs. {$row["amount"]}) colud not be printed,\n I hereby to be required reprinting the same. I indentify for any misuse of duplicate Cash Memo/Invoice.", "point" => $temp));
        } else {
            echo json_encode(array("status" => "0", "msg" => "Invalid Tickets"));
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
