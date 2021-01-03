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

class CQuestions extends CAaskController {

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
            case "userloadTable";
                $this->userloadTable();
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
            case "slist":
                $this->slist();
                break;
            default :
                echo json_encode(array("toast" => array("danger", "college", "Invalid college selected "), "status" => 0, "message" => "Invalid subject selected"));
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
                1 => 'college Name',
                2 => 'address',
                3 => 'university',
                4 => 'mobile',
                5 => 'email',
                6 => 'active',
                7 => 'onCreate',
                8 => 'action'
            );
            $sql = $this->ask_mysqli->select("questionbank", $_SESSION["db_1"]);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            $totalFilter = $totalData;
            $sql .=$this->ask_mysqli->whereSingle(array("1" => "1"));
            /* Search */
            if (!empty($request['search']['value'])) {
                $sql.=" AND (question Like '%" . $request['search']['value'] . "%'";
                $sql.=" OR a Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR b Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR c Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR d Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR e Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR f Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR g Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR h Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR i Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR j Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR answer Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR subject Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR isActive Like '%" . $request['search']['value'] . "%' )";
            }
            /* Order */
            $sql.=$this->ask_mysqli->orderBy($request['order'][0]['dir'], $col[$request['order'][0]['column']]) . $this->ask_mysqli->limitWithOffset($request['start'], $request['length']);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            while ($row = $query->fetch_assoc()) {
                $subdata = array();
                $subdata[] = $row['id'];
                $subdata[] = $row['question'];
                $subdata[] = $row['a']; //. " Dist: " . $row['dist'] . ", Tal: " . $row['tal'] . "<br>" . $row['state'] . "(" . $row['pin'] . ")";
                $subdata[] = $row['b'];
                $subdata[] = $row['c'];
                $subdata[] = $row['d'];
                $subdata[] = $row['e']; //. " Dist: " . $row['dist'] . ", Tal: " . $row['tal'] . "<br>" . $row['state'] . "(" . $row['pin'] . ")";
                $subdata[] = $row['f'];
                $subdata[] = $row['g'];
                $subdata[] = $row['h'];
                $subdata[] = $row['i'];
                $subdata[] = $row['j'];
                $subdata[] = $row['answer'];
                $subdata[] = $row['subject'];
                switch ($row["isActive"]) {
                    case 0:
                        $subdata[] = "<span class='text-danger'>Deactive</span>";
                        break;
                    case 1:
                        $subdata[] = "<span class='text-success'>Active</span>";
                        break;
                    default :
                        $subdata[] = "<span class='text-waring'>Invalid</span>";
                        break;
                }
                $subdata[] = $row['onCreate'];
                $active = '<button onclick="deletebusiness(' . $row["id"] . ',0)" class="btn btn-danger btn-xs"> <i class="fa fa-trash-o"></i></button>';
                $subdata[] = $active . ' <button onclick="editbusiness(' . $row["id"] . ')" data-toggle="modal" data-target="#myQuestion" class="btn btn-warning btn-xs"> <i class="fa fa-edit"></i></button>';
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

    public function userloadTable() {
        try {
            $request = $_REQUEST;
            $col = array(
                0 => 'id',
                1 => 'college Name',
                2 => 'address',
                3 => 'university',
                4 => 'mobile',
                5 => 'email',
                6 => 'active',
                7 => 'onCreate',
                8 => 'action'
            );
            $sql = $this->ask_mysqli->select("questionbank", $_SESSION["db_1"]);
            $sql .=$this->ask_mysqli->where(array("createby" => $_POST["id"],"postby"=>$_POST["postby"]),"AND");
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            $totalFilter = $totalData;
            
            /* Search */
            if (!empty($request['search']['value'])) {
                $sql.=" AND (question Like '%" . $request['search']['value'] . "%'";
                $sql.=" OR a Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR b Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR c Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR d Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR e Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR f Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR g Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR h Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR i Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR j Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR answer Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR subject Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR isActive Like '%" . $request['search']['value'] . "%' )";
            }
            /* Order */
            $sql.=$this->ask_mysqli->orderBy($request['order'][0]['dir'], $col[$request['order'][0]['column']]) . $this->ask_mysqli->limitWithOffset($request['start'], $request['length']);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            while ($row = $query->fetch_assoc()) {
                $subdata = array();
                $subdata[] = $row['id'];
                $subdata[] = $row['question'];
                $subdata[] = $row['a']; //. " Dist: " . $row['dist'] . ", Tal: " . $row['tal'] . "<br>" . $row['state'] . "(" . $row['pin'] . ")";
                $subdata[] = $row['b'];
                $subdata[] = $row['c'];
                $subdata[] = $row['d'];
                $subdata[] = $row['e']; //. " Dist: " . $row['dist'] . ", Tal: " . $row['tal'] . "<br>" . $row['state'] . "(" . $row['pin'] . ")";
                $subdata[] = $row['f'];
                $subdata[] = $row['g'];
                $subdata[] = $row['h'];
                $subdata[] = $row['i'];
                $subdata[] = $row['j'];
                $subdata[] = $row['answer'];
                $subdata[] = $row['subject'];
                switch ($row["isActive"]) {
                    case 0:
                        $subdata[] = "<span class='text-danger'>Deactive</span>";
                        break;
                    case 1:
                        $subdata[] = "<span class='text-success'>Active</span>";
                        break;
                    default :
                        $subdata[] = "<span class='text-waring'>Invalid</span>";
                        break;
                }
                $subdata[] = $row['onCreate'];
                $active = '<button onclick="deletebusiness(' . $row["id"] . ',0)" class="btn btn-danger btn-xs"> <i class="fa fa-trash-o"></i></button>';
                $subdata[] = $active . ' <button onclick="editbusiness(' . $row["id"] . ')" data-toggle="modal" data-target="#myQuestion" class="btn btn-warning btn-xs"> <i class="fa fa-edit"></i></button>';
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

        $sql = $this->ask_mysqli->insert("questionbank", $data);
        $this->adminDB[$_SESSION["db_1"]]->autocommit(false);
        $error = array();
        $this->adminDB[$_SESSION["db_1"]]->query($sql) == true ? true : array_push($error, "inset Error " . $this->adminDB[$_SESSION["db_1"]]->error);
        if (empty($error)) {
            $this->adminDB[$_SESSION["db_1"]]->commit();
            //$this->sendMailtoUser($_POST["college"], $_POST["email"], $password);
            echo json_encode(array("toast" => array("success", "college", " Added Successfully"), "status" => 1, "message" => "Insert Successfully..", "data" => $data));
        } else {
            // $this->sendMailtoUser($_POST["college"], $_POST["email"], $password);
            echo json_encode(array("toast" => array("danger", "college", " Failed to add " . $error[0]), "status" => 0, "message" => "Insert failed " . $error[0]));
            $this->adminDB[$_SESSION["db_1"]]->rollback();
        }
    }

    function update() {
        $data = $_POST;
        unset($data["action"]);
        unset($data["id"]);
        $where = array("id" => $_POST["id"]);
        $sql = $this->ask_mysqli->update($data, "questionbank") . $this->ask_mysqli->whereSingle($where);
        $this->adminDB[$_SESSION["db_1"]]->autocommit(false);
        $error = array();
        $this->adminDB[$_SESSION["db_1"]]->query($sql) == true ? true : array_push($error, "inset Error " . $this->adminDB[$_SESSION["db_1"]]->error);
        if (empty($error)) {
            echo json_encode(array("toast" => array("success", "college", " Update Successfully"), "status" => 1, "message" => "Update Successfully.."));
            $this->adminDB[$_SESSION["db_1"]]->commit();
        } else {
            echo json_encode(array("toast" => array("danger", "college", " Failed to Update " . $error[0]), "status" => 0, "message" => "Update failed " . $error[0]));
            $this->adminDB[$_SESSION["db_1"]]->rollback();
        }
    }

    function select() {
        $where = array("id" => $_POST["id"]);
        $sql = $this->ask_mysqli->select("questionbank", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle($where);
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        if ($row = $result->fetch_assoc()) {
            echo json_encode(array("row" => $row, "toast" => array("success", "college", "college selected "), "status" => 1, "message" => " college selected"));
            //echo json_encode($row);
        } else {
            echo json_encode(array("toast" => array("danger", "college", "Invalid Compnay selected "), "status" => 0, "message" => "Invalid college selected"));
        }
    }

    function delete() {
        $where = array("id" => $_POST["id"]);
        $sql = $this->ask_mysqli->delete("questionbank") . $this->ask_mysqli->whereSingle($where);
        if ($this->adminDB[$_SESSION["db_1"]]->query($sql)) {
            echo json_encode(array("toast" => array("success", "college", "Delete Success "), "status" => 0, "message" => "Delete Success"));
        } else {
            echo json_encode(array("toast" => array("danger", "college", "Invalid college selected " . $this->adminDB[$_SESSION["db_1"]]->error), "status" => 0, "message" => "Invalid college selected " . $this->adminDB[$_SESSION["db_1"]]->error));
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

    function randomPassword() {
        $alphabet = '!@#$%^&*(){}abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    function sendMailtoUser($name, $email, $password) {
        $link = collegeurl;
        ob_start();                      // start capturing output
        include('email/collegeRegistration.php');   // execute the file
        $content = ob_get_contents();    // get the contents from the buffer
        $data = array(
            "status" => 1,
            "message" => " college account Register success, please check your email.",
            "mail" => $this->mailObject->sendmailWithoutAttachment($email, "info@aasksoft.co.in", "aasksoft", $content, "College account create successfully", "")
        );
        //echo json_encode(array("toast" => array("success", "Course", " Added Successfully"), "status" => 1, "message" => "Insert Successfully..", "data" => $data));
        ob_end_clean();
    }

    function insertData($sheetdata) {
        $error = array();
        $flag = true;
        $password = $this->randomPassword();
        $pwd = password_hash($password, PASSWORD_DEFAULT);
        $sdata = array();
        $this->adminDB[$_SESSION["db_1"]]->autocommit(false);
        foreach ($sheetdata as $val) {
            if ($flag) {
                $flag = false;
            } else {
                $data = array("college" => $val["B"], "address" => $val["C"], "state" => $val["D"], "dist" => $val["E"], "city" => $val["F"], "pin" => $val["G"], "uni" => $val["H"], "mobile" => $val["I"], "email" => $val["J"], "pwd" => $pwd);
                $sql = $this->ask_mysqli->insert("college", $data);
                $this->adminDB[$_SESSION["db_1"]]->query($sql) == true ? true : array_push($error, "inset Error " . $this->adminDB[$_SESSION["db_1"]]->error);
                array_push($sdata, array("name" => $data["college"], "email" => $data["email"], "password" => $password));
            }
        }
        if (empty($error) && !$flag) {
            echo json_encode(array("toast" => array("success", "college", " Added Successfully"), "status" => 1, "message" => "Insert Successfully.."));
            $this->adminDB[$_SESSION["db_1"]]->commit();
            foreach ($sdata as $key => $val) {
                $this->sendMailtoUser($val["name"], $val["email"], $val["password"]);
            }
        } else {
            echo json_encode(array("toast" => array("danger", "college", " Failed to add " . json_encode($error)), "status" => 0, "message" => "Insert failed " . json_encode($error)));
            $this->adminDB[$_SESSION["db_1"]]->rollback();
        }
    }

    function slist() {
        try {
            $data = array();
            $restult = $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->select("subject", $_SESSION["db_1"]));
            while ($row = $restult->fetch_assoc()) {
                array_push($data, $row);
            }
            echo json_encode($data);
        } catch (Exception $ex) {
            
        }
    }

}
