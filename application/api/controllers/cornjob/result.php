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
        if (!isset($_SESSION["id"])) {
            // redirect(HOSTURL . "?r=" . $this->encript->encdata("main"));
        }
        return;
    }

    public function initialize() {
        parent::initialize();

        return;
    }

    public function execute() {
        parent::execute();
        try {
            $sql = $this->ask_mysqli->select("userexam", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("exmstatus" => 1)) . $this->ask_mysqli->limitWithOutOffset(10);
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            while ($row = $result->fetch_assoc()) {
                $exam = $this->getExamDetails($row["examid"]);
                if (!empty($res = $this->calculateMarks($exam, $row))) {
                    $pass = $this->getPassStatus($res["obtainmarks"], $exam);
                    $res["result"]=$pass;
                    $res["exmstatus"]=2;
                    $sql=$this->ask_mysqli->update($res,"userexam").$this->ask_mysqli->whereSingle(array("id"=>$row["id"]));
                    $this->adminDB[$_SESSION["db_1"]]->query($sql);
                }
            }
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

    function getPassStatus($mark, $exam) {
        if ($mark < $exam["passingmark"]) {
            return "Fail";
        } else {
            return "Pass";
        }
    }

    function getExamDetails($examid) {
        $data = array();
        $sql = $this->ask_mysqli->select("exam", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => $examid));
        $resutl = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        while ($row = $resutl->fetch_assoc()) {
            $data = $row;
        }
        return $data;
    }

    function calculateMarks($exam, $row, $positive = 0, $nagative = 0) {
        $data = null;
        try {
            $sql = $this->ask_mysqli->select("exampaper", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("paperid" => $row["id"], "examid" => $row["examid"]), "AND");
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            while ($rows = $result->fetch_assoc()) {
                $sql = $this->ask_mysqli->select("questionbank", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("id" => $rows["question"], "answer" => $rows["selectoption"]), "AND");
                $questionResult = $this->adminDB[$_SESSION["db_1"]]->query($sql);
                if ($r = $questionResult->fetch_assoc()) {
                    $positive = $positive + $exam["markofeach"];
                } else {
                    $nagative = $nagative + $exam["negativemarkofeach"];
                }
            }
            $data = array("obtainmarks" => $total = $positive - $nagative, "positive" => $positive, "negative" => $nagative);
        } catch (Exception $ex) {
            
        }
        return $data;
    }

}
