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

class CCompany extends CAaskController {

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
            default :
                echo json_encode(array("toast" => array("danger", "Company", "Invalid Company selected "), "status" => 0, "message" => "Invalid subject selected"));
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
                1 => 'Company Name',
                2 => 'Address',
                3 => 'cin',
                4 => 'mobile',
                5 => 'email',
                6 => 'Active',
                7 => 'onCreate',
                8 => 'Action'
            );
            $sql = $this->ask_mysqli->select("company", $_SESSION["db_1"]);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            $totalFilter = $totalData;
            $sql .=$this->ask_mysqli->whereSingle(array("1" => "1"));
            /* Search */
            if (!empty($request['search']['value'])) {
                $sql.=" AND (company Like '%" . $request['search']['value'] . "%'";
                $sql.=" OR address Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR state Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR dist Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR city Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR pin Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR cin Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR mobile Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR email Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR isActive Like '%" . $request['search']['value'] . "%' )";
            }
            /* Order */
            $sql.=$this->ask_mysqli->orderBy($request['order'][0]['dir'], $col[$request['order'][0]['column']]) . $this->ask_mysqli->limitWithOffset($request['start'], $request['length']);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            while ($row = $query->fetch_assoc()) {
                $subdata = array();
                $subdata[] = $row['id'];
                $subdata[] = $row['company'];
                $subdata[] = $row['address'] . " Dist: " . $row['dist'] . ", Tal: " . $row['tal'] . "<br>" . $row['state'] . "(" . $row['pin'] . ")";
                $subdata[] = $row['cin'];
                $subdata[] = $row['mobile'];
                $subdata[] = $row['email'];
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
        $fileData = array('url' => "");
        $data = $_POST;
        unset($data["action"]);
        unset($data["id"]);
        if (isset($_FILES)) {
            $fileData = $this->uploadFile();
        }
        $data["logo"] = $fileData["url"];
        //$data["about"] = "";
        $password = $this->randomPassword();
        $data["pwd"] = password_hash($password, PASSWORD_DEFAULT);
        $sql = $this->ask_mysqli->insert("company", $data);
        $this->adminDB[$_SESSION["db_1"]]->autocommit(false);
        $error = array();
        $this->adminDB[$_SESSION["db_1"]]->query($sql) == true ? true : array_push($error, "inset Error " . $this->adminDB[$_SESSION["db_1"]]->error);
        $id = $this->adminDB[$_SESSION["db_1"]]->insert_id;
        if (empty($error)) {
            $this->adminDB[$_SESSION["db_1"]]->commit();
            $passwordResetLink = companyurl . "?r=companyactive&e=" . $this->encript->encTxt($_POST["email"]) . "&i=" . $this->encript->encTxt($id);
            ob_start();
            $this->sendMailtoUser($_POST["company"], $_POST["email"], $password, $passwordResetLink);
            ob_end_clean();
            echo json_encode(array("toast" => array("success", "Company", " Added Successfully"), "status" => 1, "message" => "Insert Successfully..Check Email and ge password for login" , "data" => $data));
            $this->adminDB[$_SESSION["db_1"]]->commit();
        } else {
            // $this->sendMailtoUser($_POST["company"], $_POST["email"], $password);
            echo json_encode(array("toast" => array("danger", "Company", " Failed to add " . json_encode($error)), "status" => 0, "message" => "Insert failed " . $error[0]));
            $this->adminDB[$_SESSION["db_1"]]->rollback();
        }
    }

    function update() {
        $data = $_POST;
        unset($data["action"]);
        unset($data["id"]);
        $where = array("id" => $_POST["id"]);
        $sql = $this->ask_mysqli->update($data, "company") . $this->ask_mysqli->whereSingle($where);
        $this->adminDB[$_SESSION["db_1"]]->autocommit(false);
        $error = array();
        $this->adminDB[$_SESSION["db_1"]]->query($sql) == true ? true : array_push($error, "inset Error " . $this->adminDB[$_SESSION["db_1"]]->error);
        if (empty($error)) {
            echo json_encode(array("toast" => array("success", "Company", " Update Successfully"), "status" => 1, "message" => "Update Successfully.."));
            $this->adminDB[$_SESSION["db_1"]]->commit();
        } else {
            echo json_encode(array("toast" => array("danger", "Company", " Failed to Update " . $error[0]), "status" => 0, "message" => "Update failed " . $error[0]));
            $this->adminDB[$_SESSION["db_1"]]->rollback();
        }
    }

    function select() {
        $where = array("id" => $_POST["id"]);
        $sql = $this->ask_mysqli->select("company", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle($where);
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        if ($row = $result->fetch_assoc()) {
            echo json_encode(array("row" => $row, "toast" => array("success", "Company", "Company selected "), "status" => 1, "message" => " Company selected"));
            //echo json_encode($row);
        } else {
            echo json_encode(array("toast" => array("danger", "Company", "Invalid Compnay selected "), "status" => 0, "message" => "Invalid Company selected"));
        }
    }

    function delete() {
        $where = array("id" => $_POST["id"]);
        $sql = $this->ask_mysqli->delete("company") . $this->ask_mysqli->whereSingle($where);
        if ($this->adminDB[$_SESSION["db_1"]]->query($sql)) {
            echo json_encode(array("toast" => array("success", "Company", "Delete Success "), "status" => 0, "message" => "Delete Success"));
        } else {
            echo json_encode(array("toast" => array("danger", "Company", "Invalid company selected " . $this->adminDB[$_SESSION["db_1"]]->error), "status" => 0, "message" => "Invalid company selected " . $this->adminDB[$_SESSION["db_1"]]->error));
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

    function sendMailtoUser($name, $email, $password, $passwordResetLink) {
        $shortLink = $this->createLink(companyurl, $passwordResetLink);
        ob_start();                      // start capturing output
        include('email/companyRegistration.php');   // execute the file
        $content = ob_get_contents();    // get the contents from the buffer
        $data = array(
            "status" => 1,
            "message" => " Company account Register success, please check your email.",
            "mail" => $this->mailObject->sendmailWithoutAttachment($email, noreplayid, company, $content, "Compnay account create successfully", "")
        );
        error_log(json_encode($data));
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
                $data = array("company" => $val["B"], "address" => $val["C"], "state" => $val["D"], "dist" => $val["E"], "city" => $val["F"], "pin" => $val["G"], "cin" => $val["H"], "mobile" => $val["I"], "email" => $val["J"], "pwd" => $pwd);
                $sql = $this->ask_mysqli->insert("company", $data);
                $this->adminDB[$_SESSION["db_1"]]->query($sql) == true ? true : array_push($error, "inset Error " . $this->adminDB[$_SESSION["db_1"]]->error);
                array_push($sdata, array("name" => $data["company"], "email" => $data["email"], "password" => $password));
            }
        }
        if (empty($error) && !$flag) {
            echo json_encode(array("toast" => array("success", "Company", " Added Successfully"), "status" => 1, "message" => "Insert Successfully.. Check Email and get Password"));
            $this->adminDB[$_SESSION["db_1"]]->commit();
            foreach ($sdata as $key => $val) {
                $this->sendMailtoUser($val["name"], $val["email"], $val["password"]);
            }
        } else {
            echo json_encode(array("toast" => array("danger", "Company", " Failed to add " . json_encode($error)), "status" => 0, "message" => "Insert failed " . json_encode($error)));
            $this->adminDB[$_SESSION["db_1"]]->rollback();
        }
    }

    function createLink($url, $passLink) {
        $sql = $this->ask_mysqli->insert("shortLink", array("link" => $passLink, "valid_time" => 20));
        $this->adminDB[$_SESSION["db_1"]]->query($sql);
        $id = $this->adminDB[$_SESSION["db_1"]]->insert_id;
        $this->adminDB[$_SESSION["db_1"]]->commit();
        return $url . "?r=short&p=" . $this->encript->encTxt($id);
    }

    function uploadFile() {
        $uploadDir = "assets/upload/profile";
        //chmod($uploadDir,0777);
        $tmpFile = $_FILES['logo']['tmp_name'];
        $name = time() . '-' . $_FILES['logo']['name'];
        $filename = $uploadDir . '/' . $name;
        $path = getcwd() . "/" . $filename;
        move_uploaded_file($tmpFile, $path);
        return array("url" => $filename, "path" => $path, "extension" => $_FILES['logo']["type"], "name" => $name);
    }

}
