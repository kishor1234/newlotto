<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once controller;

class calculateResult extends CAaskController {

    //put your code here
    public $visState = false;
    public $l = array();
    public $per = 80;
    public $min = "0";
    public $blockno;

    public function __construct() {
        parent::__construct();
        //die;
    }

    public function create() {
        parent::create();
        //status=0  to all draw active

        $sql = "select * from gametime where etime>='" . date("H:i:s") . "'";
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        if ($row = $result->fetch_assoc()) {
            $_POST["gameid"] = $row["id"];
            $_POST["stime"] = $row["stime"];
            $_POST["etime"] = $row["etime"];
        }

        $t = 1; //test for manual
        if ($t === 0) {
            $_POST["gameid"] = "32";
            $_POST["stime"] = "17:45:00";
            $_POST["etime"] = "18:00:00";
        }

        return;
    }

    public function initialize() {
        parent::initialize();
        return;
    }

    function getIndex($val2) {
        $i = 0;
        while ($i < 100) {
            $n = rand(0, count($val2) - 1);
            if ($this->checkKeypreset($val2[$n])) {

                return $n;
            }
            $i++;
        }
        return null;
    }

    function checkKeypreset($n) {
        $flag = true;

        foreach ($this->l as $key => $val) {
            if ($n == $val) {
                $flag = false;
            }
        }
        return $flag;
    }

    public function execute() {
        parent::execute();
        try {

            $sum = 0;

            $result = $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->select("admin", $_SESSION["db_1"]));

            if ($row = $result->fetch_assoc()) {
                $this->per = $row["resultper"];
                $this->min = $row["min"];
                $this->blockno = json_decode($row["blockno"], true);
                if ($row["cron"] == 0) {
                    echo "Admin Stop Result";
                    die;
                }
            }

            $resultSeries = $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->select("gameseries", $_SESSION["db_1"]));
            while ($rowSereis = $resultSeries->fetch_assoc()) {
                //select series Array ( [sid] => 1 [id] => 1 [series] => 1000-1900 )
                $series = $rowSereis["series"];
                $subSereis = explode("-", $series);
                $sum = 0;
                for ($i = $subSereis[0]; $i <= $subSereis[1]; $i = $i + 100) {
                    $s = $this->ask_mysqli->selectSum("`" . $i . "`", "`" . $_POST["gameid"] . "`") . "\n";
                    $sum+= $this->getData($s, "sum(`" . $_POST["gameid"] . "`)");
                }
                //echo $sum . " Load<br>";die;
                $load = array();
                //sub series array
                for ($i = $subSereis[0]; $i <= $subSereis[1]; $i = $i + 100) {
                    $load[$i] = "";
                }

                for ($i = $subSereis[0]; $i <= $subSereis[1]; $i = $i + 100) {
                    $resutl = $this->adminDB[$_SESSION['db_1']]->query("SELECT `" . $_POST["gameid"] . "` FROM `" . $i . "` ORDER BY `number` ASC");
                    $totalLoad = array();
                    while ($row = $resutl->fetch_assoc()) {
                        array_push($totalLoad, $row[$_POST["gameid"]]);
                    }
                    $load[$i] = $totalLoad;
                }
                //print_r($load);
                $load["lottoweight"] = $sum; //$totalLoad;
                $_POST["loadarray"] = json_encode($load);
                //$sum = (float) $this->getData($this->ask_mysqli->selectSum("lottoweight", "`" . $_POST["gameid"] . "`"), "sum(`" . $_POST["gameid"] . "`)");
                $point = (float) $sum;
                $_POST["dload"] = $point;
                echo "Total Points: " . $point . "<br>";
                $per = ((float) ($point * $this->per) / 100);
                echo "Per " . $this->per . "% " . $per . "<br>";
                $_POST["80per"] = $per;
                $pointPerPlat = round($per / 10);
                echo "<br> Perplat Point : " . $pointPerPlat . "</br>";
                $wamt = (round($per) * 2);
                echo "Excepted Wingin amt  " . $wamt . PHP_EOL;
                //die;
                $perPlatload = array();
                for ($i = $subSereis[0]; $i <= $subSereis[1]; $i = $i + 100) {
                    $sum = $this->getData($this->ask_mysqli->selectSum("`" . $i . "`", "`" . $_POST["gameid"] . "`"), "sum(`" . $_POST["gameid"] . "`)");
                    array_push($perPlatload, $sum);
                }
                //die;
                if ($point >= 0) {

                    $markResult = array();
                    $sonaResult = array();
                    $lottery = array();
                    $sks = 0;
                    while ($sks < 10) {
                        $zeroload = array();
                        $nonzeroload = array();
                        foreach ($perPlatload as $key => $val) {
                            if ($val == 0) {
                                array_push($zeroload, $key);
                            } else {
                                array_push($nonzeroload, $key);
                            }
                        }
                        $countofzeroload = count($zeroload); //."<br>";0
                        $countofnonzeroload = count($nonzeroload); //."<br>";10
                        unset($this->blockno["id"]);
                        foreach ($this->blockno as $k => $v) {
                            if (empty($v)) {
                                unset($this->blockno[$k]);
                            }
                        }
                        $lottery = array();
                        $tempLoad = 0;
                        for ($i = $subSereis[0]; $i <= $subSereis[1]; $i = $i + 100) {
                            $perL = $pointPerPlat;
                            $tpLoad = $tempLoad + $perL;
                            $tempLoad = $tpLoad;
                            $templuckyArray = array();
                            foreach ($load[$i] as $ky => $vl) {

                                if (!in_array($ky, $this->blockno)) {

                                    if (!in_array($ky, $lottery)) {

                                        if ($vl <= $tempLoad) {
                                            $templuckyArray[$ky] = $vl;
                                            $tempLoad-=$vl;
                                        }
                                    }
                                }
                            }


                            $random_key = array_rand($templuckyArray);

                            array_push($lottery, $random_key);
                        }


                        $entir_sum = 0;
                        for ($i = $subSereis[0]; $i <= $subSereis[1]; $i = $i + 100) {


                            foreach ($lottery as $keys => $values) {
                                $entir_sum+=$load[$i][$values];
                            }
                        }
                        $sonaResult[$sks] = $entir_sum;
                        $markResult[$sks] = $lottery;
                        $sks++;
                    }

                    if (strcmp($this->min,"1") == 0) {
                        $index = array_search(max($sonaResult), $sonaResult);
                        $lottery = $markResult[$index];
                        echo "Max Result";
                    } else {
                        $index = array_search(min($sonaResult), $sonaResult);
                        $lottery = $markResult[$index];
                        echo "Min Result";
                    }
                    //echo "<br>Final array " . $index * 180 . "</br>";
                    // print_r($lottery);
//                    die;
                }
//               
                echo "<br>Final array " . $index * 180 . "</br>";
                //die;
                $loadData = $_POST["loadarray"];
                $data = array("gameid" => $_POST["gameid"], "gamestime" => $_POST["stime"], "gameetime" => $_POST["etime"], "gdate" => date("Y-m-d"), "dload" => $_POST["dload"], "80per" => $this->per, "loadarray" => $loadData, "series" => $series);
                $d = array_merge($data, $lottery);
                $query = $this->ask_mysqli->select("winnumber", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("gameid" => $_POST["gameid"], "gamestime" => $_POST["stime"], "gameetime" => $_POST["etime"], "gdate" => date("Y-m-d"), "series" => $series), "AND");
                $rp = $this->adminDB[$_SESSION["db_1"]]->query($query);
                if ($r = $rp->fetch_assoc()) {
                    echo "already Result Disply"; //$this->ResetDrawLoad();
                    //$this->ResetDrawLoad($subSereis);
                } else {
                    $sql = $this->ask_mysqli->insertSpecialChar("winnumber", $d);
                    //echo "<br>";
                    $this->adminDB[$_SESSION["db_1"]]->query($sql);
                    $this->ResetDrawLoad($subSereis);
                }
            }
            $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->update(array("status" => "1"), "gametime") . $this->ask_mysqli->whereSingle(array("id" => $_POST["gameid"])));

            //die;
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

    function ResetDrawLoad($subSeries) {
        for ($i = $subSeries[0]; $i <= $subSeries[1]; $i = $i + 100) {
            $sql = $this->ask_mysqli->update(array("" . $_POST["gameid"] . "" => 0), "`" . $i . "`");
            $this->adminDB[$_SESSION["db_1"]]->query($sql);
        }
//        $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->update(array("`" . $_POST["gameid"] . "`" => 0), "lottoweight"));
//        for ($i = 1000; $i < 2000; $i = $i + 100) {
//            $this->adminDB[$_SESSION["db_1"]]->query($this->update(array("`" . $_POST["gameid"] . "`" => 0), "`" . $i . "`"));
//        }
    }

    public function distory() {
        parent::distory();
        return;
    }

    function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
        $numbers = range($min, $max);
        shuffle($numbers);
        return array_slice($numbers, 0, $quantity);
    }

    function discard($unicarray, $arr) {
        foreach ($unicarray as $key => $val) {
            
        }
    }

    function paddZeor($val, $s) {
        $s = $s * 1000;
        for ($i = 0; $i < 100; $i++) {
            if ((int) $val[$i] == 0) {
                $val[$i] = $s;
            }
        }
        return $val;
    }

    function getArray($val) {
        $load = array();
        $notload = array();
        foreach ($val as $key => $v) {
            foreach ($v as $k => $vv) {
                if ($vv > 0) {
                    array_push($load, $k);
                } else {
                    array_push($notload, $k);
                }
            }
        }
        shuffle($load);
        shuffle($notload);
        $arr = array_merge($load, $notload);
        return $arr;
    }

}
