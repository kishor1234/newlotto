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
        echo $postdata = file_get_contents("php://input");
        $_POST = json_decode($postdata, true);

//         data.put("enterydate", dtf.format(now));
//        data.put("own", own);
//        data.put("utrno", utrno);
        $this->adminDB[$_SESSION["db_1"]]->autocommit(false);
        echo $sql = $this->ask_mysqli->select("usertranscation", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("trno" => $_POST["utrno"]));
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        $row = $result->fetch_assoc();
        $balance = $row["total"];
        $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->updateINC(array("balance" => $balance), "enduser") . $this->ask_mysqli->whereSingle(array("userid" => $row["userid"]))) != 1 ? array_push($error, "Update Balance Error " . $this->adminDB[$_SESSION["db_1"]]->error) : true;
//after balance update
        //1=active 0=deactive
        $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->update(array("active" => 0), "usertranscation") . $this->ask_mysqli->whereSingle(array("trno" => $_POST["utrno"]))) != 1 ? array_push($error, "Transaction Error " . $this->adminDB[$_SESSION["db_1"]]->error) : true;
        //transaction deactive complete
        $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->updateDNC(array("climit" => 1), "enduser") . $this->ask_mysqli->whereSingle(array("userid" => $row["userid"]))) != 1 ? array_push($error, "Limit decress Error " . $this->adminDB[$_SESSION["db_1"]]->error) : true;


        $sql = $this->ask_mysqli->select("entry", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("utrno" => $_POST["utrno"]), "AND");
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        $i = 1;
        $error = array();

        $resultArray = array();
        while ($row = $result->fetch_assoc()) {

            $loadQuery = $this->ask_mysqli->select("subentry", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("trno" => $row["trno"]), "AND");
            $result2 = $this->adminDB[$_SESSION["db_1"]]->query($loadQuery);
            while ($row2 = $result2->fetch_assoc()) {
                $point = json_decode($row2["point"], true);
                foreach ($point as $key => $val) {
                    foreach ($val as $index => $value) {
                        $inValue = ($index % 100);
                        $inTable = $index - $inValue;

                        $qq = $this->ask_mysqli->updateDNC(array("`" . $row2["gametimeid"] . "`" => $value), "`{$inTable}`") . $this->ask_mysqli->whereSingle(array("number" => sprintf("%02d", $inValue)));
                        
                        $this->adminDB[$_SESSION["db_1"]]->query($qq) != 1 ? array_push($error, "Unable to Reove load " . $this->adminDB[$_SESSION["db_1"]]->error) : true;
                    }
                }
                $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->delete("subentry") . $this->ask_mysqli->whereSingle(array("id" => $row2["id"]))) != 1 ? array_push($error, "Unable to delte") : true;
            }
//end
            $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->delete("entry") . $this->ask_mysqli->whereSingle(array("id" => $row["id"]))) != 1 ? array_push($error, "Unable to delte") : true;

            //$this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->delete("usertranscation") . $this->ask_mysqli->whereSingle(array("invoiceno" => $_POST["game"]))) != 1 ? array_push($error, "Unable to delte") : true;
        }
        if (empty($error)) {
            echo json_encode(array("status" => "1", "message" => "Ticket Successfully", "Err" => $error));
            $this->adminDB[$_SESSION["db_1"]]->commit();
        } else {
            //echo $this->printMessage("Invalid Entry ", "danger");
            $this->adminDB[$_SESSION["db_1"]]->rollback();
            echo json_encode(array("status" => "0", "message" => "Ticket cannot be canceled, Please contact to Admin", "error" => $error));
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
