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

class instruction extends CAaskController {

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
        try {

//            print_r($_POST);
//            die;
            //create user exam
            $data = array();
            $_SESSION["id"] = $_POST["id"];
            $_SESSION["myexam"] = $_POST["examid"];
            $sql = $this->ask_mysqli->select("userexam", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("userid" => $_SESSION["id"], "examid" => $_SESSION["myexam"]), "AND");
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            if ($row = $result->fetch_assoc()) {
                switch ($row["exmstatus"]) {
                    case "0":
                        //echo "re";
                        $data = $this->createExam($row["id"]);
                        $data["examstatus"] = $row["exmstatus"];
                        echo json_encode($data);
                        //delete old exampaper regenerate 
                        break;
                    case "1":
                        $data = array("toast" => array("warning", "Exam", " Your exam is completed please wait for result.."), "status" => 0, "message" => "Your exam is completed please wait for result..");
                        $data["examstatus"] = $row["exmstatus"];
                        echo json_encode($data);
                        //exam complete
                        break;
                    case "2":
                        $data = array("toast" => array("warning", "Exam", "Result Generated"), "status" => 0, "message" => "Result Generated...!");
                        $data["examstatus"] = $row["exmstatus"];
                        echo json_encode($data);
                        //Result Generated
                        break;
                    default:
                        $data = array("toast" => array("danger", "Exam", " Contact to system admin"), "status" => 0, "message" => "Contact to system admin");
                        $data["examstatus"] = $row["exmstatus"];
                        //default
                        break;
                }
                //echo "You already attend exam, wait for result";
            } else {
                //insert userexam
                $error = array();
                $this->adminDB[$_SESSION["db_1"]]->autocommit(false);
                $sql = $this->ask_mysqli->insert("userexam", array("userid" => $_SESSION["id"], "examid" => $_SESSION["myexam"], "ip" => $_SERVER["REMOTE_ADDR"]));
                $this->adminDB[$_SESSION["db_1"]]->query($sql) == true ? true : array_push($error, "Erro on insert " . $this->adminDB[$_SESSION["db_1"]]->error);
                if (empty($error)) {

                    $id = $this->adminDB[$_SESSION["db_1"]]->insert_id;
                    $data = $this->createExam($id);
                    //$data["examstatus"] = $row["exmstatus"];
                    echo json_encode($data);
                    $this->adminDB[$_SESSION["db_1"]]->commit();
                } else {
                    $this->adminDB[$_SESSION["db_1"]]->rollback();
                    $data = array("toast" => array("danger", "Exam", "Failed to create exam paper..!"), "status" => 0, "message" => "Failed to create exam paper..!");
                    echo json_encode($data);
                }
            }

            //die;
            //print_r($response);
            //$this->isLoadView(array("header" => null, "main" => "instruction", "footer" => null, "error" => "page_404"), false, array("data" => $response["data"]));
        } catch (Exception $ex) {
            echo $ex->getMessage();
            error_log($ex, 3, "error.log");
        }
        return;
    }

    public function execute() {
        //parent::execute();
        return;
    }

    public function finalize() {
        //parent::finalize();
        return;
    }

    public function reader() {
        //parent::reader();
        return;
    }

    public function distory() {
        //parent::distory();
        return;
    }

    function createExam($examid) {
        $data = array("toast" => array("danger", "Exam", "Failed to create exam paper..!"), "status" => 0, "message" => "Failed to create exam paper..!");
        $sql = $this->ask_mysqli->select("exampaper", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("paperid" => $examid, "examid" => $_SESSION["myexam"]), "AND");
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        if ($result->num_rows == 0) {
            $subject = array();
            $examSubjectQuery = $this->ask_mysqli->select("examselectsubject", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("examid" => $_SESSION["myexam"]));
            $examSelectSubject = $this->adminDB[$_SESSION["db_1"]]->query($examSubjectQuery);
            while ($examSubjects = $examSelectSubject->fetch_assoc()) {
                array_push($subject, array("subject" => $examSubjects["subject"], "question" => $examSubjects["squestion"]));
            }
            $question = array();
            foreach ($subject as $key => $val) {
                $sql = $this->ask_mysqli->select("questionbank", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("subject" => $val["subject"]));
                $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
                $tempqid = array();
                while ($row = $result->fetch_assoc()) {
                    array_push($tempqid, $row["id"]);
                }
                shuffle($tempqid);
                $uniquestion = array_slice($tempqid, 0, $val["question"]);
                $question[$val["subject"]] = $uniquestion;
            }
            $this->adminDB[$_SESSION["db_1"]]->autocommit(false);
            $error = array();
            foreach ($question as $key => $val) {
                foreach ($val as $question) {
                    $sql = $this->ask_mysqli->insert("exampaper", array("paperid" => $examid, "subject" => $key, "examid" => $_SESSION["myexam"], "question" => $question, "ip" => $_SERVER["REMOTE_ADDR"]));
                    $this->adminDB[$_SESSION["db_1"]]->query($sql) == true ? true : array_push($error, "Quesry Error  " . $this->adminDB[$_SESSION["db_1"]]->error);
                }
            }
            if (empty($error)) {
                $data = array("toast" => array("success", "Exam", "Exam paper create successfully ..!"), "status" => 1, "message" => "exam paper set succesfully","examstatus"=>0);
                $this->adminDB[$_SESSION["db_1"]]->commit();
            } else {
                $data = array("toast" => array("danger", "Exam", "Failed to create exam paper..!"), "status" => 0, "message" => "Failed to create exam paper..!", "error" => $error);

                $this->adminDB[$_SESSION["db_1"]]->rollback();
            }
        } else {
            $data = array("toast" => array("warning", "Exam", " exam paper already created..!"), "status" => 0, "message" => "exam paper already created..!");
        }
        return $data;
    }

}
