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

class CompanyData extends CAaskController {

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
            switch ($_POST['action']) {
                case "getCompanyProfile":
                    $this->getCompanyProfile();
                    break;
                case "companyUploadProfilePhoto":
                    $this->companyUploadProfilePhoto();
                    break;
            }
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

    //change profile photo using function companyUploadProfilePhoto 
    //pass form data image, email and id 
    //id and email form where close in query
    function companyUploadProfilePhoto() {
        $this->adminDB[$_SESSION["db_1"]]->autocommit(FALSE);
        $error = array();
        $uploadDir = "assets/upload/profile";
        $fileData = $this->uploadFiletoFileSystem('image', $uploadDir);
        $data = array("logo" => $fileData["url"]);
//        $sql = $this->ask_mysqli->update($data,"company").$this->ask_mysqli->where(array(),"AND");
//        $this->adminDB[$_SESSION["db_1"]]->query($sql) == true ? true : array_push($error, "fileSystem query error");
//        $imageid = $this->adminDB[$_SESSION["db_1"]]->insert_id;
        $where = array("email" => $this->encript->decTxt($_POST["email"]), "id" => $this->encript->decTxt($_POST["id"]));
        $sql = $this->ask_mysqli->update($data, "company") . $this->ask_mysqli->where($where, "AND");
        $this->adminDB[$_SESSION["db_1"]]->query($sql) == true ? true : array_push($error, "update Error on user profile");

        if (empty($error)) {
            $this->adminDB[$_SESSION["db_1"]]->commit();
            echo json_encode(array("status" => 1, "message" => "profile information add successfully"));
        } else {
            $this->adminDB[$_SESSION["db_1"]]->rollback();
            echo json_encode(array("status" => 0, "message" => "profile information add Failded"));
        }
    }

    //get compnay full data form compnay table using id
    function getCompanyProfile() {
        $data = array();
        $sql = $this->ask_mysqli->select("company", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => $_POST['id']));
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
        echo json_encode($data);
    }

}
