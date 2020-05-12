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

class cancelTicket extends CAaskController {

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
        $sql = $this->ask_mysqli->select("entry", $_SESSION["db_1"]) . $this->ask_mysqli->where($request, "AND");
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        $i = 1;
        $error = array();
        $this->adminDB[$_SESSION["db_1"]]->autocommit(false);
        $resultArray = array();
        if ($row = $result->fetch_assoc()) {
            $balance = $row["amount"] - $row["comissionAMT"];
            $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->updateINC(array("balance" =>  $balance), "enduser") . $this->ask_mysqli->whereSingle(array("userid" => $request["own"]))) != 1 ? array_push($error, "Update Balance Error ".$this->adminDB[$_SESSION["db_1"]]->error) : true;
            $point = json_decode($row["point"], true);
            foreach ($point as $key => $val) {
                foreach ($val as $index => $value) {
                    $inValue = ($index % 100);
                    $inTable = $index - $inValue;

                    $qq = $this->ask_mysqli->updateDNC(array("`" . $request["gametimeid"] . "`" => $value), "`{$inTable}`") . $this->ask_mysqli->whereSingle(array("number" => sprintf("%02d", $inValue)));
                    $this->adminDB[$_SESSION["db_1"]]->query($qq);
                }
            }
            $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->delete("entry") . $this->ask_mysqli->whereSingle(array("game" => $request["game"]))) != 1 ? array_push($error, "Unable to delte") : true;
            $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->delete("usertranscation") . $this->ask_mysqli->whereSingle(array("invoiceno" => $request["game"]))) != 1 ? array_push($error, "Unable to delte") : true;

            if (empty($error)) {
                echo json_encode(array("status" => "1", "message" => "Ticket Successfully"));
                $this->adminDB[$_SESSION["db_1"]]->commit();
            } else {
                //echo $this->printMessage("Invalid Entry ", "danger");
                $this->adminDB[$_SESSION["db_1"]]->rollback();
                echo json_encode(array("status" => "0", "message" => "Ticket cannot be canceled, Please contact to Admin","error"=>$error));
            }
        } else {
            echo json_encode(array("status" => "0", "message" => "Ticket cannot be canceled"));
        }
        //echo json_encode($resultArray);
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
