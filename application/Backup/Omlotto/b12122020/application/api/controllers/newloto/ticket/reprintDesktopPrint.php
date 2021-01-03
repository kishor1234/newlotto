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
        try {
            $sql = $this->ask_mysqli->select("entry", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("game" => $request["game"],"own"=>$request["own"]),"AND");
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            if ($row = $result->fetch_assoc()) {
                $myPoint = json_decode($row["point"], true);
                $finalArray = array();
                $temp = array();
                foreach ($myPoint as $Key => $Array) {
                    foreach ($Array as $_1key => $_1array) {//1000-1900
                        foreach ($_1array as $_2key => $_2array) {//1800
                            //echo $_2key;
                            foreach ($_2array as $in => $valArray) {//1800
                                foreach ($valArray as $index => $value) {//point
                                    //print_r($value);echo "\n";
                                    $t = $t + $value;
                                    if ($limit == 56) {
                                        $final = array(
                                            "own" => $row["own"],
                                            "totalpoint" => (string) $row["totalpoint"],
                                            "amount" => (string) $row["amount"],
                                            "enterydate" => (string) $row["enterydate"],
                                            "winstatus" => (string) 0,
                                            "winamt" => (string) 0,
                                            "claimstatus" => (string) 0,
                                            "ip" => $row["ip"],
                                            "gametime" => $row["gametime"],
                                            "gameendtime" => $row["gameendtime"],
                                            "gametimeid" => $row["gametimeid"],
                                            "game" => $row["game"],
                                            "point" => $temp
                                        );
                                        array_push($finalArray, $final);
                                        $limit = 1;
                                        $qty = 0;
                                        $temp = array();
                                        $indV = $_2key + $index;
                                        array_push($temp, array($indV => $value));
                                        $qty = $qty + $value;
                                        //$sql = $this->ask_mysqli->updateINC(array("`" . $row["gametimeid"] . "`" => $value), "`" . $_2key . "`") . $this->ask_mysqli->whereSingle(array("number" => sprintf("%02d", $index))) . "\n";
                                        //$this->adminDB[$_SESSION["db_1"]]->query($sql) != true ? array_push($error, $this->adminDB[$_SESSION["db_1"]]->error) : true;
                                    } else {
                                        $indV = $_2key + $index;
                                        array_push($temp, array($indV => $value));
                                        $qty = $qty + $value;
                                        //update query
                                        //    $sql = $this->ask_mysqli->updateINC(array("`" . $row["gametimeid"] . "`" => $value), "`" . $_2key . "`") . $this->ask_mysqli->whereSingle(array("number" => sprintf("%02d", $index))) . "\n";
                                        //   $this->adminDB[$_SESSION["db_1"]]->query($sql) != true ? array_push($error, $this->adminDB[$_SESSION["db_1"]]->error) : true;
                                        //echo $indV . "=" . $value . "\n";
                                        $limit++;
                                    }
                                }
                            }
                            //print_r($valArray);
                        }
                    }
                }
                //die;
                $final = array(
                    "own" => $row["own"],
                    "totalpoint" => (string) $row["totalpoint"],
                    "amount" => (string) $row["amount"],
                    "enterydate" => (string) $row["enterydate"],
                    "winstatus" => (string) 0,
                    "winamt" => (string) 0,
                    "claimstatus" => (string) 0,
                    "ip" => $row["ip"],
                    "gametime" => $row["gametime"],
                    "gameendtime" => $row["gameendtime"],
                    "gametimeid" => $row["gametimeid"],
                    "game" => $row["game"],
                    "point" => $temp
                );
                array_push($finalArray, $final);
                if (empty($error)) {

                    foreach ($finalArray as $key => $valArray) {
                        $valArray["point"] = json_encode($valArray["point"]);
                        $valArray["comission"] = $row["comission"];
                        $amt = $valArray["amount"];
                        $dmt = (float) ($amt * $row["comission"]);
                        $valArray["comissionAMT"] = $dmt;
                        //$sql = $this->ask_mysqli->insert("subentry", $valArray);
                        //$this->adminDB[$_SESSION["db_1"]]->query($sql) != true ? array_push($error, $this->adminDB[$_SESSION["db_1"]]->error) : true;
                    }
                }

                echo json_encode(array("status" => "1", "msg" => "Success", "print" => $finalArray));
            } else {
                echo json_encode(array("status" => "0", "msg" => "Timeout Error on insert", "print" => $error));
            }
        } catch (Exception $ex) {
            
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
