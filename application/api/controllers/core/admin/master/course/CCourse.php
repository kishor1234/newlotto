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

class CCourse extends CAaskController {

    //put your code here
    public $data = array();

    public function __construct() {
        parent::__construct();
    }

    public function create() {
        parent::create();
        if (!isset($_SESSION["id"])) {
            // redirect(HOSTURL . "?r=" . $this->encript->encdata("main"));
        }
        return;
    }

    public function initialize() {
        parent::initialize();

        return;
    }

    public function execute() {
        parent::execute();
        switch ($_POST["action"]) {
            case "loadTable";
                $this->loadTable();
                break;
            case "save":
                $this->save();
                break;
            case "update":
                $this->update();
                break;
            case "select":
                $this->select();
                break;
            case "delete":
                $this->delete();
                break;
            case "excel":
                $this->excelImport();
                break;
            case "loadMain":
                $this->loadMain();
                break;
            case "loadMainSelect":
                $this->loadMainSelect();
                break;
            default :
                echo json_encode(array("toast" => array("danger", "Course", "Invalid course selected "), "status" => 0, "message" => "Invalid course selected"));
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

    public function loadTable() {
        try {
            $request = $_REQUEST;
            $col = array(
                0 => 'id',
                1 => 'Course Name',
                2 => 'parentid',
                3 => 'externalid',
                4 => 'type'
            );
            $sql = $this->ask_mysqli->select("course", $_SESSION["db_1"]);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            $totalFilter = $totalData;
            $sql .=$this->ask_mysqli->whereSingle(array("1" => "1"));
            /* Search */
            if (!empty($request['search']['value'])) {
                $sql.=" AND (name Like '%" . $request['search']['value'] . "%'";
                $sql.=" OR externalid Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR type Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR parentid Like '%" . $request['search']['value'] . "%' )";
            }
            /* Order */
            $sql.=$this->ask_mysqli->orderBy($request['order'][0]['dir'], $col[$request['order'][0]['column']]) . $this->ask_mysqli->limitWithOffset($request['start'], $request['length']);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            while ($row = $query->fetch_assoc()) {
                $subdata = array();
                $subdata[] = $row['id'];
                $subdata[] = $row['name'];
                $subdata[] = $row['parentid'];
                $subdata[] = $row['externalid'];
                $subdata[] = $row['type'];
                $active = '<button onclick="deletebusiness(' . $row["id"] . ',0)" class="btn btn-danger btn-xs"> <i class="fa fa-trash-o"></i></button>';
                $subdata[] = $active . ' <button onclick="editbusiness(' . $row["id"] . ')" data-toggle="modal" data-target="#myModal" class="btn btn-warning btn-xs"> <i class="fa fa-edit"></i></button>';
                $data[] = $subdata;
            }
            $json_data = array(
                "draw" => intval($request['draw']),
                "recordsTotal" => intval($totalData),
                "recordsFiltered" => intval($totalFilter),
                "data" => $data,
            );
            echo json_encode($json_data);
        } catch (Exception $ex) {
            error_log($ex, 3, "error.log");
        }
    }

    function save() {
        $data = $_POST;
        unset($data["action"]);
        unset($data["id"]);

        $sql = $this->ask_mysqli->insert("course", $data);
        $this->adminDB[$_SESSION["db_1"]]->autocommit(false);
        $error = array();
        $this->adminDB[$_SESSION["db_1"]]->query($sql) == true ? true : array_push($error, "inset Error " . $this->adminDB[$_SESSION["db_1"]]->error);
        if (empty($error)) {
            echo json_encode(array("toast" => array("success", "Course", " Added Successfully"), "status" => 1, "message" => "Insert Successfully.."));
            $this->adminDB[$_SESSION["db_1"]]->commit();
        } else {
            echo json_encode(array("toast" => array("danger", "Course", " Failed to add " . $error[0]), "status" => 0, "message" => "Insert failed " . $error[0]));
            $this->adminDB[$_SESSION["db_1"]]->rollback();
        }
    }

    function update() {
        $data = array("name" => $_POST["name"], "code" => $_POST["code"]);
        $where = array("id" => $_POST["id"]);
        $sql = $this->ask_mysqli->update($data, "course") . $this->ask_mysqli->whereSingle($where);
        $this->adminDB[$_SESSION["db_1"]]->autocommit(false);
        $error = array();
        $this->adminDB[$_SESSION["db_1"]]->query($sql) == true ? true : array_push($error, "inset Error");
        if (empty($error)) {
            echo json_encode(array("toast" => array("success", "Course", " Update Successfully"), "status" => 1, "message" => "Update Successfully.."));
            $this->adminDB[$_SESSION["db_1"]]->commit();
        } else {
            echo json_encode(array("toast" => array("danger", "Course", " Failed to Update "), "status" => 0, "message" => "Update failed"));
            $this->adminDB[$_SESSION["db_1"]]->rollback();
        }
    }

    function select() {
        $where = array("id" => $_POST["id"]);
        $sql = $this->ask_mysqli->select("course", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle($where);
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        if ($row = $result->fetch_assoc()) {
            echo json_encode(array("row" => $row, "toast" => array("success", "Course", "course selected "), "status" => 1, "message" => " course selected"));
            //echo json_encode($row);
        } else {
            echo json_encode(array("toast" => array("danger", "Course", "Invalid course selected "), "status" => 0, "message" => "Invalid course selected"));
        }
    }

    function delete() {
        $where = array("id" => $_POST["id"]);
        $sql = $this->ask_mysqli->delete("course") . $this->ask_mysqli->whereSingle($where);
        if ($this->adminDB[$_SESSION["db_1"]]->query($sql)) {
            echo json_encode(array("toast" => array("success", "Course", "Delete Success "), "status" => 0, "message" => "Delete Success"));
        } else {
            echo json_encode(array("toast" => array("danger", "Course", "Invalid course selected "), "status" => 0, "message" => "Invalid course selected"));
        }
    }

    function excelImport() {
        try {
            //print_r($_FILES);die;
            if (isset($_FILES["file"]) && $_FILES["file"]["error"] == UPLOAD_ERR_OK) {
                $uploadDir = "assets/upload/temp";
                $tmpFile = $_FILES['file']['tmp_name'];
                $name = time() . '-' . $_FILES['file']['name'];
                $filename = $uploadDir . '/' . $name;
                $path = getcwd() . "/" . $filename;
                move_uploaded_file($tmpFile, $path);
                $objPHPExcel = $this->getExcelFileObject($path);
                $sheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                $this->insertData($sheet);
            }
        } catch (Exception $ex) {
            
        }
    }

    function insertData($sheetdata) {
        $error = array();
        $flag = true;
        $this->adminDB[$_SESSION["db_1"]]->autocommit(false);
        foreach ($sheetdata as $val) {
            if ($flag) {
                $flag = false;
            } else {
                $data = array("name" => $val["B"], "code" => $val["C"]);
                $sql = $this->ask_mysqli->insert("course", $data);
                $this->adminDB[$_SESSION["db_1"]]->query($sql) == true ? true : array_push($error, "inset Error " . $this->adminDB[$_SESSION["db_1"]]->error);
            }
        }
        if (empty($error) && !$flag) {
            echo json_encode(array("toast" => array("success", "Course", " Added Successfully"), "status" => 1, "message" => "Insert Successfully.."));
            $this->adminDB[$_SESSION["db_1"]]->commit();
        } else {
            echo json_encode(array("toast" => array("danger", "Course", " Failed to add " . $error[0]), "status" => 0, "message" => "Insert failed " . $error[0]));
            $this->adminDB[$_SESSION["db_1"]]->rollback();
        }
    }

    function loadMain() {
        $data = array();
        $sql = $this->ask_mysqli->select("course", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("type" => "Main"));
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
        echo json_encode(array("data" => $data, "toast" => array("success", "Main", " Select Successfully"), "status" => 1, "message" => "Select Successfully.."));
    }

    function loadMainSelect() {
        
        $dp=$_POST;
        unset($dp["action"]);
        $data = array();
         $sql = $this->ask_mysqli->select("course", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle($dp);
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
        echo json_encode(array("data" => $data, "toast" => array("success", "Main", " Select Successfully"), "status" => 1, "message" => "Select Successfully.."));
    }

}
