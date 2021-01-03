<?php

//use CAaskController;

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
    public $wrate = 90;
    public $min = "0";
    public $blockno;
    public $load = array();
    public $zeroload = array();
    public $nonzeroload = array();

    public function __construct() {
        parent::__construct();
        //die;
    }

    public function create() {
        parent::create();
        //status=0  to all draw active

        $sql = "select * from gametime where etime>='" . date("H:i:s") . "'";
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        $row = $result->fetch_assoc();
        $_POST["gameid"] = $row["id"];
        $_POST["stime"] = $row["stime"];
        $_POST["etime"] = $row["etime"];

        $t = 1; //test for manual
        if ($t === 0) {
            echo "Manual Resul<br>";
            $_POST["gameid"] = "1";
            $_POST["stime"] = "10:00:00";
            $_POST["etime"] = "10:15:00";
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

        foreach ($this->l as $val) {
            if ($n == $val) {
                $flag = false;
            }
        }
        return $flag;
    }

    function getGlobal() {
        $result = $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->select("admin", $_SESSION["db_1"]));
        $row = $result->fetch_assoc();
        $this->per = $row["resultper"];
        $this->wrate = $row["winrate"];
        $this->min = $row["min"];
        $this->blockno = json_decode($row["blockno"], true);
        if ($row["cron"] == 0) {
            echo "Admin Stop Result";
            die;
        }
    }

    function getSum($subSereis) {
        $sum = 0;
        for ($i = $subSereis[0]; $i <= $subSereis[1]; $i = $i + 100) {
            $s = $this->ask_mysqli->selectSum("`" . $i . "`", "`" . $_POST["gameid"] . "`") . "\n";
            $sum += $this->getData($s, "sum(`" . $_POST["gameid"] . "`)");
        }
        return $sum;
    }

    function getEmptyLoad($subSereis) {
        $load = array();
        //sub series array
        for ($i = $subSereis[0]; $i <= $subSereis[1]; $i = $i + 100) {
            $load[$i] = "";
        }
        return $load;
    }

    function getLoad($subSereis) {
        $this->zeroload = array();
        $this->nonzeroload = array();
        $this->load = array();
        for ($i = $subSereis[0]; $i <= $subSereis[1]; $i = $i + 100) {
            $resutl = $this->adminDB[$_SESSION['db_1']]->query("SELECT `" . $_POST["gameid"] . "` FROM `" . $i . "` ORDER BY `number` ASC");
            $totalLoad = array();
            $zero = array();
            $nonzero = array();
            $k = 0;
            while ($row = $resutl->fetch_assoc()) {
                array_push($totalLoad, $row[$_POST["gameid"]]);
                if ($row[$_POST["gameid"]] == 0) {
                    array_push($zero, $k);
                } else {
                    array_push($nonzero, $k);
                }
                $k++;
            }
            $this->zeroload[$i] = $zero;
            $this->nonzeroload[$i] = $nonzero;
            $this->load[$i] = $totalLoad;
        }
    }

    function emptZeroLoad() {
        $return = false;
        foreach ($this->zeroload as $sr => $point) {
            if (empty($point)) {
                $return = true;
            } else {
                $return = false;
                break;
            }
        }
        return $return;
    }

    public function execute() {
        parent::execute();
        try {
            $sum = 0;
            $this->getGlobal();
            $resultSeries = $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->select("gameseries", $_SESSION["db_1"]));
            while ($rowSereis = $resultSeries->fetch_assoc()) {
                //select series Array ( [sid] => 1 [id] => 1 [series] => 1000-1900 )
                $series = $rowSereis["series"];
                $subSereis = explode("-", $rowSereis["series"]);
                $sum = $this->getSum($subSereis);
                $this->load = $this->getEmptyLoad($subSereis);
                $this->getLoad($subSereis);
                $this->load["lottoweight"] = $sum; //$totalLoad;
                $_POST["loadarray"] = json_encode($this->load);
                //$point contain total load of sereis
                $point = (float) $sum;
                $_POST["dload"] = $point;
                echo "Total Points: " . $point . "<br>";
                echo "Total Amount: " . $point * 2 . "<br>";
                $per = ((float) ($point * $this->per) / 100);
                echo "Per " . $this->per . "% " . $per . "<br>";
                $_POST["80per"] = $per;
                echo "<br>winrate {$this->wrate}<br>";
                $cpoint = 0;
                if ($this->emptZeroLoad()) {
                    $cpoint = round($per / $this->wrate) + 1;
                } else {
                    $cpoint = round($per / $this->wrate);
                }
                echo "<br> zero point level {$cpoint}";
                $pointPerPlat = $cpoint / 10;
                echo "<br> Perplat Point : " . $pointPerPlat . "</br>";
                $wamt = (round($per) * 2);
                echo "Excepted Wingin amt  " . $wamt . PHP_EOL;
                // die;
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
                    unset($this->blockno["id"]);
                    foreach ($this->blockno as $k => $v) {
                        if (empty($v)) {
                            unset($this->blockno[$k]);
                        }
                    }
                    while ($sks < 100) {

                        $lottery = array();
                        $perPl = $pointPerPlat;
                        $keyarray = array();
                        foreach ($this->nonzeroload as $key => $nonezero) {
                            array_push($keyarray, $key);
                        }
                        $orginKey = $keyarray;
                        shuffle($keyarray);
                        shuffle($keyarray);
                        shuffle($keyarray);
                        echo "<br>Key array<Br>";
                        print_r($keyarray);
                        foreach ($keyarray as $ink => $key) {
                            $nonezero = $this->nonzeroload[$key];

//                            echo $key;
//                        }
//                        foreach ($this->nonzeroload as $key => $nonezero) {

                            shuffle($nonezero);
                            shuffle($nonezero);
                            shuffle($nonezero);
                            shuffle($nonezero);

                            echo "<br>{$key}<br>";
                            $i = 0;

                            if (!empty($nonezero)) {
                                $flag = false;
                                foreach ($nonezero as $nkey => $nono) {
                                    if (!in_array($nono, $this->blockno)) {
                                        if (!in_array($nono, $lottery)) {
                                            if (strcmp($this->min, "1") == 0) {
                                                if ($this->load[$key][$nono] >= $perPl) {
                                                    $perPl = $pointPerPlat;
                                                    echo $nono . " non Z<br>";
                                                    $tkey = array_search($key, $orginKey);
                                                    //array_push($lottery, $nono);
                                                    $lottery[$tkey] = $nono;
                                                    $flag = true;
                                                    break;
                                                }
                                            } else {
                                                if ($this->load[$key][$nono] <= $perPl) {
                                                    $perPl = $pointPerPlat;
                                                    echo $nono . " non Z<br>";
                                                    $tkey = array_search($key, $orginKey);
                                                    //array_push($lottery, $nono);
                                                    $lottery[$tkey] = $nono;
                                                    $flag = true;
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                }
                                if (!$flag) {
                                    $zdata = $this->zeroload[$key];
                                    shuffle($zdata);
                                    foreach ($zdata as $nkey => $nono) {
                                        if (!in_array($nono, $this->blockno)) {
                                            if (!in_array($nono, $lottery)) {
                                                if ($this->load[$key][$nono] <= $perPl) {
                                                    echo $nono . " Zero <br>";
                                                    $perPl += $pointPerPlat;
                                                    $tkey = array_search($key, $orginKey);
                                                    //array_push($lottery, $nono);
                                                    $lottery[$tkey] = $nono;
                                                    $flag = true;
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                }
                                if (!$flag) {
                                    for ($i = 0; $i <= 99; $i++) {
                                        $nono = rand(0, 99);
                                        if (!in_array($nono, $this->blockno)) {
                                            if (!in_array($nono, $lottery)) {
                                                //if ($this->load[$key][$nono] <= $perPl) {
                                                echo $nono . " Randome<br>";
                                                $perPl += $pointPerPlat;
                                                $tkey = array_search($key, $orginKey);
                                                //array_push($lottery, $nono);
                                                $lottery[$tkey] = $nono;
                                                $flag = true;
                                                break;
                                                // }
                                            }
                                        }
                                    }
                                }
                                if ($flag) {
                                    echo "true";
                                } else {
                                    echo "false";
                                }

//                                foreach ($nonezero as $nkey => $nono) {
//                                    if (!in_array($nono, $this->blockno)) {
//                                        if (!in_array($nono, $lottery)) {
//                                            if ($this->load[$key][$nono] <= $perPl) {
//                                                $perPl = $pointPerPlat;
//                                                echo $nono . " non Z<br>";
//                                                array_push($lottery, $nono);
//                                                break;
//                                            } else if ($i == 99 || $perPl < 1) {
//                                                $zdata = $this->zeroload[$key];
//                                                shuffle($zdata);
//                                                foreach ($zdata as $nkey => $no) {
//                                                    if (!in_array($no, $this->blockno)) {
//                                                        if (!in_array($no, $lottery)) {
//                                                            if ($this->load[$key][$no] <= $perPl) {
//                                                                echo $no . " Z <br>";
//                                                                $perPl += $pointPerPlat;
//                                                                array_push($lottery, $no);
//                                                                break;
//                                                            }
//                                                        }
//                                                    }
//
//                                                    $i++;
//                                                }
//                                                break;
//                                            }
//                                        }
//                                    }
//
//                                    $i++;
//                                }
                            } else {
                                $zdata = $this->zeroload[$key];
                                shuffle($zdata);
                                foreach ($zdata as $nkey => $nono) {
                                    if (!in_array($nono, $this->blockno)) {
                                        if (!in_array($nono, $lottery)) {
                                            if ($this->load[$key][$nono] <= $perPl) {
                                                echo $nono . " Else Zero <br>";
                                                $perPl = $pointPerPlat;
                                                $tkey = array_search($key, $orginKey);
                                                //array_push($lottery, $nono);
                                                $lottery[$tkey] = $nono;
                                                $flag = true;
                                                break;
                                            }
                                        }
                                    }
                                }
                            }
//                            else {
//                                $zdata = $this->zeroload[$key];
//                                shuffle($zdata);
//                                foreach ($zdata as $nkey => $nono) {
//                                    if (!in_array($nono, $this->blockno)) {
//                                        if (!in_array($nono, $lottery)) {
//                                            if ($this->load[$key][$nono] <= $perPl) {
//                                                //echo $nono . "<br>";
//                                                $perPl = $pointPerPlat;
//                                                array_push($lottery, $nono);
//                                                break;
//                                            }
//                                            if ($i == 10) {
//                                                $k = array_rand($this->zeroload[$key]);
//                                                $np = $this->zeroload[$key][$k];
//                                                array_push($lottery, $np);
//                                                //echo $perPl . "<br>";
//                                                $perPl = $perPl + $pointPerPlat;
//                                                break;
//                                            }
//                                        }
//                                    }
//
//                                    $i++;
//                                }
//                            }
                        }

                        $entir_sum = 0;
                        if (count($lottery) == 10) {
                            $p = 0;
                            for ($i = $subSereis[0]; $i <= $subSereis[1]; $i = $i + 100) {
                                //echo $this->load[$i][$lottery[$p]] . "<br>";
                                $entir_sum += $this->load[$i][$lottery[$p]];
                                $p++;
                            }

                            $sonaResult[$sks] = $entir_sum;
                            $markResult[$sks] = $lottery;
                            $sks++;
                        }

                        ksort($lottery);
//                        print_r($lottery);
//                        die;
                    }
                    $fcount = 0;
                    if (strcmp($this->min, "1") == 0) {
                        $index = array_search(max($sonaResult), $sonaResult);
                        $fcount = $sonaResult[$index];
                        $lottery = $markResult[$index];
                        echo "Max Result";
                    } else {
                        $index = array_search(min($sonaResult), $sonaResult);
                        $fcount = $sonaResult[$index];
                        $lottery = $markResult[$index];
                        echo "Min Result";
                    }
                }

                print_r($lottery);
//                print_r($sonaResult);
                echo "<br>Final array " . $fcount * ($this->wrate * 2) . "</br>";
                   //          die;
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
