<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of getCancelLimit
 *
 * @author asksoft
 */
defined('BASEPATH') OR exit('No direct script access allowed');

//require_once getcwd() . '/' . APPLICATION . "/controllers/Crout.php";
require_once controller;

//header('Content-Type: application/json');

class getCancelLimit extends CAaskController {

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
        $re = json_decode($postdata, true);
        $_POST = $re["main"];
        $sql = $this->ask_mysqli->select("enduser", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $_POST["userid"]));
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        $row = $result->fetch_assoc();
        $fnl = array();
        if ($row["climit"] > 0) {
            $remian_limit = $row["climit"];
            $sql = $this->ask_mysqli->select("usertranscation", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $_POST["userid"])) . $this->ask_mysqli->orderBy("DESC", "id") . $this->ask_mysqli->limitWithoutOffset(1);
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            $row = $result->fetch_assoc();
            $drid = $row["drawid"];
            if ($row["active"] != 0) {
                $trno = $row["trno"];

                $sql = $this->ask_mysqli->select("entry", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("utrno" => $row["trno"])) . $this->ask_mysqli->orderBy("DESC", "id") . $this->ask_mysqli->limitWithoutOffset(1);
                $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
                $row = $result->fetch_assoc();

                if ($row["gametimeid"] == $_POST["drawid"]) {
                    $fnl = array(
                        "status" => "1",
                        "message" => "Success",
                        "limit" => $remian_limit,
                        "utrno" => $trno
                    );
                } else if (empty($drid)) {
                    $fnl = array(
                        "status" => "1",
                        "message" => "Success Advacne Draw",
                        "limit" => $remian_limit,
                        "utrno" => $trno
                    );
                } else {
                    $fnl = array(
                        "status" => "0",
                        "message" => "Last Ticket/Invoice Draw was over, so this transaction Invoice/Ticket not cancel.."
                    );
                }
            } else {
                $fnl = array(
                    "status" => "0",
                    "message" => "Last Ticket/Invoice Already canceled..!"
                );
            }
        } else {
            $fnl = array(
                "status" => "0",
                "message" => "Ticke/Invoice Cancel limit over!"
            );
        }
        echo json_encode($fnl);
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
