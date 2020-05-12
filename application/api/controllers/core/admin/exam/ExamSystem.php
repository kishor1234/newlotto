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

class ExamSystem extends CAaskController {

    //put your code here

    public function __construct() {
        parent::__construct();
    }

    public function create() {
        parent::create();
        //if(isset($_SESSION["loginEmail"])){redirect(ASETS."?r=".$this->encript->encdata("C_Dashboard"));}
        return;
    }

    public function initialize() {
        parent::initialize();
        switch ($_POST["action"]) {
            case "loadQuestionData":
                $sql = $this->ask_mysqli->selectSpacific(array("id"), "userexam") . $this->ask_mysqli->where(array("userid" => $_POST["id"], "examid" => $_POST["examid"]), "AND");
                $sqldist = $this->ask_mysqli->selectDistinct("exampaper", "subject") . $this->ask_mysqli->whereWithoutQout(array("examid" => $_POST["examid"], "paperid" => $this->ask_mysqli->whereOnlyQuery(array($sql))), "and");
                $result = $this->adminDB[$_SESSION["db_1"]]->query($sqldist);
                $subject = array();
                while ($row = $result->fetch_assoc()) {
                    array_push($subject, $row["subject"]);
                }
                $data = array();
                foreach ($subject as $key => $val) {
                    $sqld = $this->ask_mysqli->select("exampaper", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("examid" => $_POST["examid"], "subject" => $val), "and") . " AND " . "paperid=" . $this->ask_mysqli->whereOnlyQuery(array($sql));
                    $result = $this->adminDB[$_SESSION["db_1"]]->query($sqld);
                    $data[$val] = array();
                    while ($row = $result->fetch_assoc()) {
                        array_push($data[$val], array($row["id"], $row["status"]));
                    }
                }
                echo json_encode(array("status" => 1, "data" => $data));
                break;
            case "getQuestion":
                $question = array();
                $sql = $this->ask_mysqli->select("exampaper", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => $_POST["question"]));
                $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
                if ($row = $result->fetch_assoc()) {
                    $exiting = $row;
                    $sql = $this->ask_mysqli->select("questionbank", $_SESSION['db_1']) . $this->ask_mysqli->whereSingle(array("id" => $row["question"]));
                    $results = $this->adminDB[$_SESSION["db_1"]]->query($sql);
                    if ($rowrs = $results->fetch_assoc()) {
                        array_push($question, $rowrs);
                    }
                    echo json_encode(array("status" => 1, "exiting" => $exiting, "data" => $row, "question" => $question));
                } else {
                    echo json_encode(array("status" => 0, "data" => null));
                }
                break;
            case "submit":
                $this->submitQuestion();
                break;
            case "getExam":
                $sql = $this->ask_mysqli->select("exam", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => $_POST["id"]));
                $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
                $data = array();
                while ($row = $result->fetch_assoc()) {
                    array_push($data, $row);
                }
                echo json_encode($data);
                break;
            case "submitexam":
                $post = $_POST;
                unset($post["action"]);
                $sql = $this->ask_mysqli->update(array("exmstatus" => 1), "userexam") . $this->ask_mysqli->where($post, "AND");
                if ($this->adminDB[$_SESSION["db_1"]]->query($sql)) {
                    echo json_encode(array("query"=>$sql,"status" => 1, "msg" => "Exam end success...!"));
                } else {
                    echo json_encode(array("query"=>$sql,"status" => 0, "msg" => "Technical Error Call admin"));
                }
                break;
            default :
                print_r($_POST);
                break;
        }
        return;
    }

    public function execute() {
        parent::execute();
        $this->cors();

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

    function submitQuestion() {
        //print_r($_POST);
        $post = $_POST;
        unset($post["action"]);
        unset($post["id"]);
        $error = array();
        $sql = $this->ask_mysqli->select("exampaper", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => $_POST["id"]));
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        if ($row = $result->fetch_assoc()) {
            $sql = $this->ask_mysqli->select("questionbank", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => $row["question"]));
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            if ($row = $result->fetch_assoc()) {
                $post["answer"] = $row[$post["selectoption"]];
                $post["status"] = 1;
                $sql = $this->ask_mysqli->update($post, "exampaper") . $this->ask_mysqli->whereSingle(array("id" => $_POST["id"]));
                $this->adminDB[$_SESSION["db_1"]]->query($sql) ? true : array_push($error, $this->adminDB[$_SESSION["db_1"]]->error);
            } else {
                array_push($error, "question not found...!");
            }
        } else {
            array_push($error, "paper question not found...!");
        }
        $er = json_encode($error);
        if (empty($error)) {
            $this->adminDB[$_SESSION["db_1"]]->commit();
            echo json_encode(array("toast" => array("success", "Question", " Successfully"), "status" => 1, "message" => "Success"));
        } else {
            $this->adminDB[$_SESSION["db_1"]]->rollback();
            echo json_encode(array("toast" => array("success", "Question", "Error " + $er), "status" => 0, "message" => "Failed"));
        }
    }

}
