<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once controller;

class checkWinnerBot extends CAaskController {

    //put your code here
    public $amount = 0;
    public $sad;
    public $happy;
    public $fw;
    public $tpoint = 0;
    public $wnumber = 0;
    public $no;

    public function __construct() {
        parent::__construct();
    }

    public function create() {
        parent::create();

        return;
    }

    public function initialize() {
        parent::initialize();
        //$this->sad = "<img src='https://i0.wp.com/www.aktricks.in/wp-content/uploads/2018/03/3ae816da-3a55-4bac-a613-b5dd5c1dfac5.jpg' style='height:100px;'>";
        $this->sad = "<center><h1 style='color:red;'>No Wining Point!</h1></center>";
        $this->happy = "<img src='/assets/img/happyr.gif' style='height:100px;'>";
        $this->fw = "<img src='/assets/img/fw.gif' style='height:100px;'>";
        return;
    }

    public function execute() {
        parent::execute();
        try {
            $postdata = file_get_contents("php://input");
            $_POST = json_decode($postdata, true);
            $final = array();
            $sql = $this->ask_mysqli->select("entry", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("botStatus" => 0));
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            while ($row = $result->fetch_assoc()) {
                //print_r($row);
                $game = $row["game"];
                $game_id = $row["gametimeid"];
                $claimStatis = $row["claimstatus"];
                $date = $row["enterydate"];
                $ResultArray = array();
                $sql = $this->ask_mysqli->select("winnumber", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("gameid" => $game_id, "gdate" => $date), "AND");
                $drawResult = $this->adminDB[$_SESSION["db_1"]]->query($sql);
                while ($drawRow = $drawResult->fetch_assoc()) {
                    $subSeries = explode("-", $drawRow["series"]);

                    $k = 0;
                    $tempArray = array();
                    for ($i = $subSeries[0]; $i <= $subSeries[1]; $i = $i + 100) {
                        $ipl = $i + $drawRow[$k];
                        //echo "<br>";
                        $tempArray[$ipl] = $k;
                        $k++;
                    }
                    array_push($ResultArray, $tempArray);
                    //  die;
                }
                //print_r($ResultArray);

                $sum = 0;
                $winArray = array();
                $p = json_decode($row["point"], true);
                foreach ($p as $k => $v) {
                    foreach ($v as $k1 => $v1) {
                        foreach ($ResultArray as $key => $val) {
                            if (array_key_exists($k1, $val)) {
                                $sum = $sum + (int) $v1;
                                $winArray[$k1] = $v1;
                            }
                        }
                    }
                }
                //print_r($winArray);
                //echo $sql=$this->ask_mysqli->update(array("winamt" => $this->amount,  "botStatus" => 1), "entry") . $this->ask_mysqli->whereSingle(array("game" => $game));

                $this->amount = $sum * 2;
                $sql = $this->ask_mysqli->update(array("winamt" => $this->amount, "botStatus" => 1), "entry") . $this->ask_mysqli->whereSingle(array("game" => $game));
                $er = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            }
            echo json_encode($final);
        } catch (Exception $ex) {
            $this->adminDB[$_SESSION["db_1"]]->rollback();
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
