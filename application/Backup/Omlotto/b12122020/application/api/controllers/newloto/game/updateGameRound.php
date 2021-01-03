<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once controller;

class updateGameRound extends CAaskController {

    //put your code here
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
        try {
            $sql = $this->ask_mysqli->select("gametime", $_SESSION["db_1"]) . $this->ask_mysqli->whereSinglelessthanequal(array("stime" => date("H:i:s"))) . $this->ask_mysqli->orderBy("DESC", "id") . $this->ask_mysqli->limitWithOutOffset(1);
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            if ($row = $result->fetch_assoc()) {
                $_SESSION["gameid"] = $row["id"];
                $_SESSION["stime"] = $row["stime"];
                $_SESSION["etime"] = $row["etime"];
                $t = (int) strtotime($row["etime"]) - (int) strtotime(date("H:i:s"));
                $row["time"]="".$t;
                echo json_encode($row);
            }
        } catch (Exception $ex) {
            
        }
        //echo '{ "time": "120" }';
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
