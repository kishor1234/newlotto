<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of resetGameLoad
 *
 * @author asksoft
 */
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once controller;

class cronjoblist extends CAaskController {

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

            $sql = $this->ask_mysqli->select("gametime", $_SESSION["db_1"]);
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            while ($row = $result->fetch_assoc()) {
                $time = explode(":", $row["etime"]);
                if ($time[1] === "00") {
                    $time[1] = 60;
                    $time[0] = $time[0] - 1;
                }
                $min = $time[1] - 1;
                echo "{$min} {$time[0]} * * * sleep 50; wget " . api_url . "/?r=calculateResult";
                echo "<br>";
            }
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

    public function distory() {
        parent::distory();
        return;
    }

    function reset($series, $count) {
        $data = array();
        for ($i = 1; $i <= $count; $i++) {
            $data[$i] = 0;
        }
        return $this->ask_mysqli->update($data, "`{$series}`");
    }

    function porcessSeries($series, $count) {
        for ($i = $series[0]; $i <= $series[1]; $i = $i + 100) {
            $sql = $this->reset($i, $count);
            $this->adminDB[$_SESSION["db_1"]]->query($sql);
        }
    }

}
