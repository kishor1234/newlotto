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

class Cadminforgotpasswrod extends CAaskController {

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
        try {
            $this->cors();
            $request = $_POST;//file_get_contents("php://input");
            if (isset($request) && !empty($request)) {
                $postdata = $request;//json_decode($request, true);
                $sql = $this->ask_mysqli->select("admin", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("email" => $postdata["userName"]));
                $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
                echo json_encode($this->checkUser($result));
            } else {
                $data = array(
                    "status" => 0,
                    "message" => "Invalid Request",
                    "data" => $postdata
                );
                echo json_encode($data);
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

    function checkUser($result) {
        $data = array("status" => 0, "message" => "Email id not found in our system, please register to create new account");
        try {
            if ($result->num_rows > 0) {
                if ($row = $result->fetch_assoc()) {
                    $name = $row["user"];
                    $email = $row["email"];
                    $passwordResetLink = ADMINURL . "?r=reset&e=" . $this->encript->encTxt($email) . "&i=" . $this->encript->encTxt($row["id"]);
                    $shortLink = $this->createLink($passwordResetLink);
                    ob_start();                      // start capturing output
                    include('forgorpasswordTemp.php');   // execute the file
                    $content = ob_get_contents();    // get the contents from the buffer
                    ob_end_clean();
                    ob_start();
                    
                    //echo "test";// stop buffering and discard contents
                    $data = array(
                        "status" => 1,
                        "message" => " Recovery mail has been send, please check your email.",
                        "mail" => $this->mailObject->sendmailWithoutAttachment($email, noreplayid, company, $content, "Recovery password", "")
                    );
                    ob_end_clean();
                }
            }
        } catch (Exception $ex) {
            
        }
        return $data;
    }

    function createLink($passLink) {
        $sql = $this->ask_mysqli->insert("shortLink", array("link" => $passLink, "valid_time" => 2));
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        $id = $this->adminDB[$_SESSION["db_1"]]->insert_id;
        return ADMINURL . "?r=short&p=". $this->encript->encTxt($id);
    }

}
