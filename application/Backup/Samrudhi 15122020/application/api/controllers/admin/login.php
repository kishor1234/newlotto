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

class login extends CAaskController {

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
            $request = json_decode($postdata, "\0");
            
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

             $sql = $this->ask_mysqli->select("admin", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("email" => $postData["userName"]));
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            if ($row = $result->fetch_assoc()) {
                if (password_verify($postData["password"], $row["password"])) {
                    $data = array("message" => "success", "_id" => $row["id"], "email" => $row["email"]);
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

}
