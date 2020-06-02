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

class CGetExamforuser extends CAaskController {

    //put your code here
    public $data = array();
    private $id;
    private $email;
    private $start;
    private $end;

    public function __construct() {
        parent::__construct();
    }

    public function create() {
        parent::create();
        
        return;
    }

    public function initialize() {
        parent::initialize();
        
        $this->id = $this->encript->decTxt($_POST["id"]);
        $this->email = $this->encript->decTxt($_POST["email"]);
        $this->start = $_POST["start"];
        $this->end = $_POST["end"];
        $selectedexam = array();

        //SELECT * FROM `exam_criteria` WHERE main=5 AND sub=7 AND branch=19 and passingyear>=2015 and percentage<=66.20
        //SELECT DISTINCT examid FROM `examselectsubject` WHERE subject='OS' OR subject='Java'
        $userEducationQuery = $this->ask_mysqli->select("usereducation", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $this->id));
        $userEducationResult = $this->adminDB[$_SESSION["db_1"]]->query($userEducationQuery);
        while ($userEducationRow = $userEducationResult->fetch_assoc()) {
            $sql = $this->ask_mysqli->select("exam_criteria", $_SESSION["db_1"]) . "WHERE main='{$userEducationRow["education"]}' AND sub='{$userEducationRow["class"]}' AND branch='{$userEducationRow["course"]}' and passingyear>='{$userEducationRow["passingyear"]}' and percentage<='{$userEducationRow["percentage"]}'" . $this->ask_mysqli->limitWithOffset($this->start, $this->end);
            $resutl = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            while ($row = $resutl->fetch_assoc()) {
                if ($row["examid"] != 0) {
                    array_push($selectedexam, $row["examid"]);
                }
            }
        }

        //$selectedexam = $this->array_multi_unique($selectedexam);
        $data=array();
        $datas = array_unique($selectedexam);
        foreach ($datas as $key => $val) {
            $sql = $this->ask_mysqli->select("exam", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => $val)); // . $this->ask_mysqli->limitWithOffset($this->start, $this->end);
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            while ($row = $result->fetch_assoc()) {
                $row["logo"] = $this->getLogo($row["companyid"]);
                array_push($data, $row);
            }
        }
//        $sql = $this->ask_mysqli->select("userskill", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $this->id));
//        $resutl = $this->adminDB[$_SESSION["db_1"]]->query($sql);
//        $sillData = array();
//        while ($row = $resutl->fetch_assoc()) {
//            array_push($sillData, $row["skill"]);
//        }
//        $data = $this->getExamidforuser($sillData);0-2,2-4,4-6
        $start = $this->start + $_POST["offset"];
        $end = $this->end + $_POST["offset"];
        if (!empty($data)) {

            $final = array(
                "status" => array("status" => 1, "message" => "recoard fetch success", "start" => $start, "end" => $end),
                "data" => $data
            );
            echo json_encode($final);
        } else {
            $final = array(
                "status" => array("status" => 0, "message" => "recoard fetch failed", "start" => $start, "end" => $end),
                "data" => $data
            );
            echo json_encode($final);
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

    function array_multi_unique($multiArray) {

        $uniqueArray = array();

        foreach ($multiArray as $subArray) {

            if (!in_array($subArray, $uniqueArray)) {
                $uniqueArray[] = $subArray;
            }
        }
        return $uniqueArray;
    }

    function sendMailtoUser($name, $email, $password) {
        $link = examurl;
        ob_start();                      // start capturing output
        include('email/examRegistration.php');   // execute the file
        $content = ob_get_contents();    // get the contents from the buffer
        $data = array(
            "status" => 1,
            "message" => " exam account Register success, please check your email.",
            "mail" => $this->mailObject->sendmailWithoutAttachment($email, "info@aasksoft.co.in", "aasksoft", $content, "exam account create successfully", "")
        );
        //echo json_encode(array("toast" => array("success", "Course", " Added Successfully"), "status" => 1, "message" => "Insert Successfully..", "data" => $data));
        ob_end_clean();
    }

    function getExamidforuser($skill) {
        $data = array();
        $sql = $this->ask_mysqli->selectDistinct("examselectsubject", "examid") . $this->ask_mysqli->whereSingleIndex($skill, "subject", "OR");
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        while ($row = $result->fetch_assoc()) {
            $exaquery = $this->ask_mysqli->select("exam", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => $row["examid"]));
            $examResult = $this->adminDB[$_SESSION["db_1"]]->query($exaquery);
            if ($r = $examResult->fetch_assoc()) {
                array_push($data, $r);
            }
        }
        return $data;
    }

    function getLogo($companyid) {
        $logo = "data:image/png;base64,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";
        try {
            $sql = $this->ask_mysqli->select("company", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => $companyid));
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            if ($row = $result->fetch_assoc()) {
                $logo = $row["logo"];
            }
        } catch (Exception $ex) {
            
        }
        return $logo;
    }

}
