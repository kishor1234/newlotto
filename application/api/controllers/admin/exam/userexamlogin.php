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

class userexamlogin extends CAaskController {

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

        return;
    }

    public function execute() {
        parent::execute();
        $this->cors();
        $postdata = file_get_contents("php://input");
        //$postdata=  json_encode(array("userName"=>"info@gmail.com","password"=>"sonali"));
        if (isset($postdata) && !empty($postdata)) {
            $request = json_decode($postdata, true);
            $data = $this->checkLoginUser($request);
            if ($data != null) {
                header("HTTP/1.1 200 OK");
                echo json_encode($data);
            } else {
                header("HTTP/1.1 401 Invalid username or password");
                echo json_encode(array("message" => "Invalid username or password"));
            }
        } else {
            //http_response_code(400);
            header("HTTP/1.1 400 Invalid username or password");
            echo json_encode(array("message" => "Invalid Row"));
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

    function checkLoginUser($postData) {
        $data = null;
        try {
            $sql = $this->ask_mysqli->select("user", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("email" => $postData["userName"]));
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            if ($row = $result->fetch_assoc()) {
                if (password_verify($postData["password"], $row["pwd"])) {
                    //$this->checkUserExamValidation($row);
                    $data = array("examvalid"=>$this->checkUserExamValidation($row,$postData),"message" => "success", "_id" => $row["id"], "email" => $row["email"]);
                } else {
                    $data = null;
                }
            } else {
                $data = null;
            }
        } catch (Exception $ex) {
            $data = null;
        }
        return $data;
    }

    function checkUserExamValidation($row,$postData) {
        $data=$this->examsetforme($row["id"]);
        //echo json_encode(array("myid"=>$postData,"data"=>$data,"valie"=>in_array($postData["examid"],$data)));die;
        $valid= in_array($postData["examid"],$data);
        return $valid;
    }

    function examsetforme($id) {
        $selectedexam=array();
        $userEducationQuery = $this->ask_mysqli->select("usereducation", $_SESSION["db_1"]).$this->ask_mysqli->whereSingle(array("userid"=>$id));
        $userEducationResult = $this->adminDB[$_SESSION["db_1"]]->query($userEducationQuery);
        while ($userEducationRow = $userEducationResult->fetch_assoc()) {
            $sql = $this->ask_mysqli->select("exam_criteria", $_SESSION["db_1"]) . "WHERE main='{$userEducationRow["education"]}' AND sub='{$userEducationRow["class"]}' AND branch='{$userEducationRow["course"]}' and passingyear>='{$userEducationRow["passingyear"]}' and percentage<='{$userEducationRow["percentage"]}'"; // . $this->ask_mysqli->limitWithOffset($this->start, $this->end);
            $resutl = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            while ($row = $resutl->fetch_assoc()) {
                array_push($selectedexam, $row["examid"]);
            }
        }

        $data = array();
        foreach ($selectedexam as $key => $val) {
            $sql = $this->ask_mysqli->select("exam", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => $val)); // . $this->ask_mysqli->limitWithOffset($this->start, $this->end);
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            while ($row = $result->fetch_assoc()) {
               
                array_push($data, $row["id"]);
            }
        }
        
        return $data;
    }

}
