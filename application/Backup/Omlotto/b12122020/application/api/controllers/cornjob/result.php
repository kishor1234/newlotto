<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of login
 *
 * @author asksoft
 */
//die(APPLICATION);
//require_once getcwd() . '/' . APPLICATION . "/controllers/Crout.php";
require_once controller;

class result extends CAaskController {

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
        try {
            $postdata = file_get_contents("php://input");
            $_POST = json_decode($postdata, true);//." AND gameetime< '".date("H:i;s")

            $sql = $this->ask_mysqli->select("winnumber", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("series" => $_POST["series"], "gdate" => $_POST["gdate"]), "AND").$this->ask_mysqli->orderBy("ASC","gameid");
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            $myResutl = array();
            while ($row = $result->fetch_assoc()) {
                $temp = array(
                    "gameid" => $row["gameid"],
                    "series" => $row["series"],
                    "gameetime" => $row["gameetime"],
                    "0" => $row["0"],
                    "1" => $row["1"],
                    "2" => $row["2"],
                    "3" => $row["3"],
                    "4" => $row["4"],
                    "5" => $row["5"],
                    "6" => $row["6"],
                    "7" => $row["7"],
                    "8" => $row["8"],
                    "9" => $row["9"]
                );
                array_push($myResutl, $temp);
            }
            echo json_encode($myResutl);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
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
