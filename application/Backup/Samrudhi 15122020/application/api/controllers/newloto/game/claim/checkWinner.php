<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once controller;

class checkWinner extends CAaskController {

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
            //$_POST['id'] = 'ask5ed87e5c59b6d';
            //$_POST['userid'] = '20200431';
           // $sql = $this->ask_mysqli->select("entry", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("game" => $_POST["id"], "trno" => $_POST["id"]), "OR") . " AND own='{$_POST["userid"]}'";
            $sql = $this->ask_mysqli->select("entry", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("game" => $_POST["id"], "own" => $_POST["userid"]), "AND");// . " AND own='{$_POST["userid"]}'";
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            $ra = 180;
            if ($row = $result->fetch_assoc()) {
                
                if (strtotime(date("H:i:s")) < strtotime($row["gameendtime"]) && strtotime(date("Y-m-d")) == strtotime($row["enterydate"])) {
                    $final = array(
                        "status" => "0",
                        "message" => "Draw is not over yet!"
                    );
                    echo json_encode($final);
                    die;
                }
                $claimStatis = $row["claimstatus"];
                $ClaimTime = $row["ClaimTime"];
                $drid = $row["gametimeid"];
                $sql = $this->ask_mysqli->select("subentry", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("game" => $row["game"], "own" => $_POST["userid"]), "AND");
                $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
                $sum = 0;
                $winArray = array();
                while ($row1 = $result->fetch_assoc()) {
                    //print_r($row);
                    $game_id = $row1["gametimeid"];
                    //$claimStatis = $row["claimstatus"];
                    $date = $row1["enterydate"];
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



                    $p = json_decode($row1["point"], true);
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
                }
                //echo $sum;die;
                if ($claimStatis === "1") {
                    $pri = $sum * $ra;
                    $final = array(
                        "status" => "0",
                        "message" => "Ticket already claimed \nPoint win:{$pri} \nClaim date : {$ClaimTime}",
                        "amount" => (string) ($sum * $ra),
                        "own" => $_POST["userid"],
                        "drawid" => $game_id,
                        "winPoint" => $winArray
                    );
                } else if (empty($winArray)) {

                    $final = array(
                        "status" => "0",
                        "message" => "No winning ticket",
                        "amount" => (string) ($sum * $ra),
                        "own" => $_POST["userid"],
                        "drawid" => $game_id,
                        "winPoint" => $winArray
                    );
                    $er = $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->update(array("winamt" => $this->amount, "winstatus" => 0, "claimstatus" => 1), "entry") . $this->ask_mysqli->whereSingle(array("game" => $_POST["id"])));
                    // $er == false ? array_push($error, "Update win and claim status  table error " . $this->adminDB[$_SESSION["db_1"]]->error) : true;
                } else {
                    $this->adminDB[$_SESSION["db_1"]]->autocommit(false);
                    $this->amount = $sum * $ra;
                    $error = array();
                    $sql = $this->ask_mysqli->insert("claim", array("enteryid" => $_POST["userid"],'utrno'=>$row["utrno"], "winnumber" => json_encode($winArray), "gameid" => $row["gametimeid"], "gametime" => $row["gametime"], "gameetime" => $row["gameendtime"], "cdate" => $row["enterydate"]));
                    $er = $this->adminDB[$_SESSION["db_1"]]->query($sql);
                    $er == false ? array_push($error, "Insert on claim table error " . $this->adminDB[$_SESSION["db_1"]]->error) : true;
                    $max = $this->adminDB[$_SESSION["db_1"]]->insert_id; // $this->getData($this->select("claim", $_SESSION["db_1"]) . $this->whereSingle(array("id" => $this->filterPost("id"))), "id");
                    $er = $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->update(array("winamt" => $this->amount, "winstatus" => 1, "claimstatus" => 1), "entry") . $this->ask_mysqli->whereSingle(array("game" => $_POST["id"])));
                    $er == false ? array_push($error, "Update win and claim status  table error " . $this->adminDB[$_SESSION["db_1"]]->error) : true;
                    //echo $this->ask_mysqli->updateINC(array("balance"=>"".$this->amount), "enduser").$this->ask_mysqli->whereSingle(array("userid"=>$_POST["userid"]));
                    $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->updateINC(array("balance" => $this->amount), "enduser") . $this->ask_mysqli->whereSingle(array("userid" => $_POST["userid"]))) != 1 ? array_push($error, "Error on Update Wining Points Update " . $this->adminDB[$_SESSION["db_1"]]->error) : true;
                    //echo($this->insert("transaction", $_SESSION["db_1"], array("userid" => $_SESSION["userid"], "debit" => $this->amount, "remark" => "Winner Point's transfer " . $this->amount . " Invoic ID#" . $this->filterPost("id"), "ip" => $_SERVER["REMOTE_ADDR"], "balance" => $this->getData($this->select("enduser", $_SESSION["db_1"]) . $this->whereSingle(array("userid" => $_SESSION["userid"])), "balance"))));// != 1 ? array_push($error, "Error on Transcation Table Error Code 02 ") : true;
                    //$this->adminDB[$_SESSION["db_1"]]->query($this->update(array("winamt"=>$this->amount), "entry").$this->whereSingle(array("id"=>$s[1])))!=1?array_push($error, "Unable to update Net Payable "):true;
                    $sql = $this->ask_mysqli->insert("transaction", array("userid" => $_POST["userid"], "debit" => $this->amount, "remark" => "Winner Point\'s transfer " . $this->amount . " Invoic ID#" . $_POST["id"], "ip" => $_SERVER["REMOTE_ADDR"], "balance" => $this->getData($this->ask_mysqli->select("enduser", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $_POST["userid"])), "balance")));
                    $this->adminDB[$_SESSION["db_1"]]->query($sql) != 1 ? array_push($error, "Error on Transcation Table Error Code 02 " . $this->adminDB[$_SESSION["db_1"]]->error) : true;

                    if (!empty($error)) {
                        $this->adminDB[$_SESSION["db_1"]]->rollback();
                        $final = array(
                            "status" => "0",
                            "message" => "error on Update! " . json_encode($error),
                            "amount" => (string) ($sum * $ra),
                            "own" => $_POST["userid"],
                            "drawid" => $game_id,
                            "winPoint" => $winArray
                        );
                    } else {
                        $this->adminDB[$_SESSION["db_1"]]->commit();
                        $final = array(
                            "status" => "1",
                            "message" => "You won! " . ($sum * $ra) . "\nDr ID. : {$drid} \nClaim date : {$ClaimTime}",
                            "amount" => (string) ($sum * $ra),
                            "own" => $_POST["userid"],
                            "drawid" => $game_id,
                            "id" => $_POST["id"],
                            "data" => $date,
                            "winPoint" => $winArray
                        );
                    }
                }
            } else {
                $final = array(
                    "status" => "0",
                    "message" => "Invalid Barcode"
                );
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
