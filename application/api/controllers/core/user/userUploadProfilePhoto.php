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

class userUploadProfilePhoto extends CAaskController {

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
        $this->adminDB[$_SESSION["db_1"]]->autocommit(FALSE);
        $error = array();
        $uploadDir = "assets/upload/profile";
        $fileData = $this->uploadFiletoFileSystem('image',$uploadDir);
        $sql = $this->ask_mysqli->insert("filesystem", $fileData);
        $this->adminDB[$_SESSION["db_1"]]->query($sql) == true ? true : array_push($error, "fileSystem query error");
        $imageid = $this->adminDB[$_SESSION["db_1"]]->insert_id;
        $where = array("email" => $this->encript->decTxt($_POST["email"]), "id" => $this->encript->decTxt($_POST["id"]));
        $sql = $this->ask_mysqli->update(array("profile" => $imageid), "user") . $this->ask_mysqli->where($where, "AND");
        $this->adminDB[$_SESSION["db_1"]]->query($sql) == true ? true : array_push($error, "update Error on user profile");

        if (empty($error)) {
            $this->adminDB[$_SESSION["db_1"]]->commit();
            echo json_encode(array("status" => 1, "message" => "profile information add successfully"));
        } else {
            $this->adminDB[$_SESSION["db_1"]]->rollback();
            echo json_encode(array("status" => 0, "message" => "profile information add Failded"));
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
