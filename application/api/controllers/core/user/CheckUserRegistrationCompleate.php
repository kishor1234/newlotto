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

class CheckUserRegistrationCompleate extends CAaskController {

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
            $sql = $this->ask_mysqli->select("user", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => $this->encript->decTxt($_POST["id"])));
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            if ($row = $result->fetch_assoc()) {
                $sql=$this->ask_mysqli->select("filesystem",$_SESSION["db_1"]).$this->ask_mysqli->whereSingle(array("id"=>$row["profile"]));
                $profileResult = $this->adminDB[$_SESSION["db_1"]]->query($sql);
                $profile = $profileResult->fetch_assoc();
                unset($row["pwd"]);
                if ($row["personal"] == 0) {
                    echo json_encode(array("profile"=>$profile,"data" => $row, "email" => $this->encript->encTxt($row["email"]), "id" => $this->encript->encTxt($row["id"]), "r" => "Check", "v" => "VPersonal", "title" => "Personal"));
                } else if ($row["employ"] == 0) {
                    echo json_encode(array("profile"=>$profile,"data" => $row, "email" => $this->encript->encTxt($row["email"]), "id" => $this->encript->encTxt($row["id"]), "r" => "Check", "v" => "VEmployee", "title" => "Employee"));
                } else if ($row["education"] == 0) {
                    echo json_encode(array("profile"=>$profile,"data" => $row, "email" => $this->encript->encTxt($row["email"]), "id" => $this->encript->encTxt($row["id"]), "r" => "Check", "v" => "VEducation", "title" => "Education"));
                } else if ($row["skill"] == 0) {
                    echo json_encode(array("profile"=>$profile,"data" => $row, "email" => $this->encript->encTxt($row["email"]), "id" => $this->encript->encTxt($row["id"]), "r" => "Check", "v" => "VSkill", "title" => "Skill"));
                } else if ($row["profile"] == 0) {
                    echo json_encode(array("profile"=>$profile,"data" => $row, "email" => $this->encript->encTxt($row["email"]), "id" => $this->encript->encTxt($row["id"]), "r" => "Check", "v" => "VProfile", "title" => "Profile"));
                } else {
                    echo json_encode(array("profile"=>$profile,"data" => $row, "email" => $this->encript->encTxt($row["email"]), "id" => $this->encript->encTxt($row["id"]), "r" => "Check", "v" => "VComplete", "title" => "Complete"));
                }
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

}
