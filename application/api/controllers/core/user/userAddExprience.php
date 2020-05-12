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

class userAddExprience extends CAaskController {

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

        $where = array("email" => $this->encript->decTxt($_POST["email"]), "id" => $this->encript->decTxt($_POST["id"]));
        $data = $_POST;
        $data["userid"] = $this->encript->decTxt($_POST["id"]);
        $data["ip"] = $_SERVER["REMOTE_ADDR"];
        unset($data["email"]);
        unset($data["action"]);
        unset($data["id"]);
        $error = array();
        switch ($_POST["action"]) {
            case "add":
                $this->adminDB[$_SESSION["db_1"]]->autocommit(false);
                $i = $_POST["hiddenidexp"];
                for ($j = 1; $j < $i; $j++) {
                    $dt = array(
                        "userid" => $data["userid"],
                        "ip" => $data["ip"],
                        "company" => $_POST["companyname_{$j}"],
                        "designation" => $_POST["designation_{$j}"],
                        "location" => $_POST["location_{$j}"],
                        "endmonth" => $_POST["endmonth_{$j}"],
                        "endyear" => $_POST["endyear_{$j}"],
                        "startmonth" => $_POST["startmonth_{$j}"],
                        "startyear" => $_POST["startyear_{$j}"],
                    );
                    $sql = $this->ask_mysqli->insert("userexperience", $dt);
                    $this->adminDB[$_SESSION["db_1"]]->query($sql) == true ? true : array_push($error, "Insert Error on user exprience");
                }
                $sql = $this->ask_mysqli->update(array("employ" => 1), "user") . $this->ask_mysqli->where($where, "AND");
                $this->adminDB[$_SESSION["db_1"]]->query($sql) == true ? true : array_push($error, "update Error on user personal");

                if (empty($error)) {
                    $this->adminDB[$_SESSION["db_1"]]->commit();
                    echo json_encode(array("toast" => array("success", "Work Experience", "Add Success "),"status" => 1, "message" => "Personal information add successfully"));
                } else {
                    $this->adminDB[$_SESSION["db_1"]]->rollback();
                    echo json_encode(array("toast" => array("danger", "Work Experience", "Add Failed "),"status" => 0, "message" => "Personal information add Failded"));
                }
                break;
            case "update":
                break;
            case "delete":
                break;
            default :
                break;
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
