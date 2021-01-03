
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of grandSel
 *
 * @author asksoft
 */
//die(APPLICATION);
//require_once getcwd() . '/' . APPLICATION . "/controllers/Crout.php";
require_once controller;

class alluserreport extends CAaskController {

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
            $request = $_POST;//json_decode($postdata, true);
            
            $sl = $this->ask_mysqli->select("enduser", $_SESSION["db_1"]); // . $this->ask_mysqli->whereBetweenDates('on_create', $request["dateform"], $request["dateto"]) . " AND active='1'";
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sl);
            
            $farray = array();
            while ($row = $result->fetch_assoc()) {
                $array = array();
                $array["uid"] = $row["userid"];
                $a = $this->getData($this->ask_mysqli->selectSum("usertranscation", "netamt") . $this->ask_mysqli->whereBetweenDates('on_create', $request["dateform"], $request["dateto"]) . " AND userid='{$row["userid"]}'", "sum(netamt)");
                $a == null ? $array["a"] = 0 : $array["a"] = $a; // . $this->ask_mysqli->whereSingle(array("utrno" => $row["invoiceno"]));
                $f = $this->getData($this->ask_mysqli->selectSum("usertranscation", "discountamt") . $this->ask_mysqli->whereBetweenDates('on_create', $request["dateform"], $request["dateto"]) . " AND userid='{$row["userid"]}'", "sum(discountamt)"); // . $this->ask_mysqli->whereSingle(array("utrno" => $row["invoiceno"]));
                $f == null ? $array["f"] = 0 : $array["f"] = $f;
                $b = $this->getData($this->ask_mysqli->selectSum("usertranscation", "discountamt") . $this->ask_mysqli->whereBetweenDates('on_create', $request["dateform"], $request["dateto"]) . " AND userid='{$row["userid"]}' AND active='0'", "sum(discountamt)"); // . $this->ask_mysqli->whereSingle(array("utrno" => $row["invoiceno"]));
                $b == null ? $array["b"] = 0 : $array["b"] = $b;
                $c = $array["a"] - $array["b"];
                $c == null ? $array["c"] = 0 : $array["c"] = $c;
                $d = $this->getData($this->ask_mysqli->selectSum("entry", "winamt") . $this->ask_mysqli->whereBetweenDates('isDate', $request["dateform"], $request["dateto"]) . " AND own='{$row["userid"]}'", "sum(winamt)");
                $d == null ? $array["d"] = 0 : $array["d"] = $d;
                $array["e"] = $array["c"] - $array["d"];
                $e == null ? $array["e"] = 0 : $array["e"] = $e;
                $array["g"] = "0";
                $h = $array["e"] - $array["f"] - $array["g"];
                $h == null ? $array["h"] = 0 : $array["h"] = $h;
                array_push($farray, $array);
            }
            echo json_encode($farray);
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
