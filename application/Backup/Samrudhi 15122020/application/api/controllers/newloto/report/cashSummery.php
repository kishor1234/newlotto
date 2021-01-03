
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cashSummery
 *
 * @author asksoft
 */
//die(APPLICATION);
//require_once getcwd() . '/' . APPLICATION . "/controllers/Crout.php";
require_once controller;

class cashSummery extends CAaskController {

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
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);
            $sl = $this->ask_mysqli->select("usertranscation", $_SESSION["db_1"]) . $this->ask_mysqli->whereBetweenDatesID('on_create', $request["dateform"], $request["dateto"], "userid", $request["own"]) . " AND active='1'";
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sl);
            $ntotal = 0;
            $ftotal = 0;
            $fnpay = 0;
            $wamt = 0;
            $commisionAMT = 0;
            $pa = 0;
            $discount=0;
            while ($row = $result->fetch_assoc()) {
//                $sql = $this->ask_mysqli->select("entry", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("game" => $row["invoiceno"]));//, "winamt");
//                $rop=$this->adminDB[$_SESSION["db_1"]]->query($sql);
//                $r=$rop->fetch_assoc();
                $tc = $this->getData($this->ask_mysqli->selectSum("entry", "winamt") . $this->ask_mysqli->whereSingle(array("utrno" => $row["invoiceno"])), "sum(winamt)");
                $discount+=$row["discountamt"];
                $nc = $row["netamt"] - $row["discountamt"] - $tc;
                $commisionAMT = (float) $commisionAMT + (float) $row["discountamt"];
                $pa+=$row["total"];
                $ntotal = (float) $ntotal + (float) $row["netamt"];
                $ftotal = (float) $ftotal + (float) $row["total"];
                $fnpay = (float) $fnpay + (float) $nc;
                $wamt = (float) $wamt + (float) $tc;
            }
            $sl = $this->ask_mysqli->selectSum("entry", "winamt") . $this->ask_mysqli->whereBetweenDatesID('ClaimTime', $request["dateform"] . " 00:00:00", $request["dateto"] . " 23:59:59", "own", $request["own"]) . "AND claimstatus='1'";
            $wamt = $this->getData($sl, "sum(winamt)");
            $fnpay = $ntotal - $discount - $wamt;
            echo json_encode(array("userid" => $request["own"], "cdate" => "Form " . $request["dateform"] . " To " . $request["dateto"], "sale" => number_format($ntotal, 2), "ta" => number_format($ntotal, 2), "pa" => number_format($pa, 2), "claim" => number_format($wamt, 2), "np" => number_format($fnpay, 2), "cm" => number_format($commisionAMT, 2)));
        } catch (Exception $ex) {
            
        }
        return;
    }

    public function execute() {
        parent::execute();

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
