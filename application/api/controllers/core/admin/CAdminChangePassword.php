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

class CAdminChangePassword extends CAaskController {

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
        $postdata = $_POST; // file_get_contents("php://input");
        //$postdata=  json_encode(array("userName"=>"info@gmail.com","password"=>"sonali"));
        if (isset($postdata) && !empty($postdata)) {
            $request = $_POST; //on_decode($postdata, true);
            $data = $this->changePassword($request);
            if ($data != null) {
                header("HTTP/1.1 200 OK");
                echo json_encode($data);
            } else {
                header("HTTP/1.1 401 Invalid username or password");
                echo json_encode(array("message" => "Password not match", "status" => 0, "mail" => false));
            }
        } else {
            //http_response_code(400);
            header("HTTP/1.1 400 Invalid username");
            echo json_encode(array("message" => "Invalid Row", "status" => 0, "mail" => false));
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

    function changePassword($postData) {
        $data = null;
        try {
            $sql = $this->ask_mysqli->select("admin", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("email" => $this->encript->decTxt($postData["etoken"]), "id" => $this->encript->decTxt($postData["token"])), "AND");
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            if ($row = $result->fetch_assoc()) {
                if (strcmp($row["email"], $this->encript->decTxt($postData["etoken"])) == 0) {
                    $sql = $this->ask_mysqli->update(array("password" => password_hash($postData["pass"], PASSWORD_DEFAULT)), "admin") . $this->ask_mysqli->where(array("email" => $this->encript->decTxt($postData["etoken"]), "id" => $this->encript->decTxt($postData["token"])), "AND");
                    if ($this->adminDB[$_SESSION["db_1"]]->query($sql)) {
                        $name = $row["user"];
                        $email = $row["email"];
                        $ua = $this->getBrowser();
                        $yourbrowser = "Browser: " . $ua['name'] . " " . $ua['version'] . " on " . $ua['platform'] . " reports: <br >" . $ua['userAgent'];
                        $ip = $_SERVER["REMOTE_ADDR"];
                        $time = date("Y-M-d H:i:s ");
                        ob_start();                      // start capturing output
                        include('email_resetpwd.php');   // execute the file
                        $content = ob_get_contents();    // get the contents from the buffer
                        ob_end_clean();
                        ob_start();

                        $data = array("message" => "password change successfully login to continue.", "status" => 1, "email" => $row["email"], "mail" => $this->mailObject->sendmailWithoutAttachment($email, noreplayid, company, $content, "Security alert for changing your password.", ""));
                        ob_end_clean();
                    } else {
                        $data = null;
                    }
                } else {
                    $data = null;
                }
            }
        } catch (Exception $ex) {
            $data = null;
        }
        return $data;
    }

}
