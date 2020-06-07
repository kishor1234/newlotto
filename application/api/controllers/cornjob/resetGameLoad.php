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

class resetGameLoad extends CAaskController {

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
            $count = $this->getData($this->ask_mysqli->selectCount("gametime", "id"), "count(id)");
            $sql = $this->ask_mysqli->select("gameseries", $_SESSION["db_1"]);
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            while ($row = $result->fetch_assoc()) {
                $series = explode("-", $row["series"]);
                $this->porcessSeries($series,$count);
                $this->adminDB[$_SESSION["db_1"]]->query("UPDATE `gametime` SET `status` = '0'");
                 $this->adminDB[$_SESSION["db_1"]]->query("UPDATE `enduser` SET `climit` = '5'");
            }
            //UPDATE `enduser` SET `climit` = '5'
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

    function porcessSeries($series,$count) {
        for ($i = $series[0]; $i <= $series[1]; $i = $i + 100) {
            $sql = $this->reset($i, $count);
            $this->adminDB[$_SESSION["db_1"]]->query($sql);
        }
    }

}
