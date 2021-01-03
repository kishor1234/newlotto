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

class report extends CAaskController {

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
        $_POST = json_decode($postdata, true);
        $sl = $this->ask_mysqli->select("usertranscation", $_SESSION["db_1"]) . $this->ask_mysqli->whereBetweenDatesID('enterydate', $_POST["fdate"], $_POST["tdate"], "userid", $_POST["userid"]) . "AND active='1'";
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sl);
        $i = 1;
        $data = array();
        while ($row = $result->fetch_assoc()) {
            //$tc = $this->getData($this->ask_mysqli->select("entry", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("utrno" => $row["trno"]), "AND"), "winamt");
            $sl = $this->ask_mysqli->select("entry", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("utrno" => $row["trno"]));

            $result2 = $this->adminDB[$_SESSION["db_1"]]->query($sl);
            $game = "";
            $drid = "";
            $tc = 0;
            while ($row2 = $result2->fetch_assoc()) {
                $game = $row2["game"];
                $drid = $row2["gametimeid"];
                $tc = $tc + $row2["winamt"];
            }
            $nc = $row["netamt"] - $row["discountamt"] - $tc;
            $temp = array(
                "id" => (string) $i,
                "userid" => (string) $row["userid"],
                "game" => "RajLaxmi",
                "ticket" => (string) $game,
                "drawid" => (string) $drid,
                "netPoint" => (string) $row["netamt"], //selll
                "discountPer" => (string) $row["discount"], //per
                "discountPoint" => (string) $row["discountamt"], //profit
                "finalPoint" => (string) $row["total"], //after profit move
                "winAmount" => (string) $tc,
                "netPayble" => (string) $nc,
                "date" => (string) $row["on_create"]
            );
            array_push($data, $temp);
            $ntotal = $ntotal + (float) $row["netamt"];
            $ftotal = $ftotal + (float) $row["discountamt"];
            $fnpay = $fnpay + (float) $nc;
            $wamt = $wamt + (float) $tc;
            $i++;
        }
        $fnl = array(
            "totalNetPoint" => number_format($ntotal, 2),
            "totalPoint" => number_format($ftotal, 2),
            "wintPoint" => number_format($wamt, 2),
            "netPayble" => number_format($fnpay, 2),
            "data" => $data
        );
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
