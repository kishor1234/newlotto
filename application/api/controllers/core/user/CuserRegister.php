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

class CuserRegister extends CAaskController {

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
        switch ($_POST["action"]) {
            case "excel":
                $this->excelImport();
                break;
            case "loadusettable":
                $this->loadusettable();
                break;
            case "formAdd":
                $this->formAdd();
                break;
            case "addUser" :
                $this->adduser();
                break;
            default :
                echo json_encode(array("status" => 0, "message" => "Invalid request"));
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

    function formAdd() {
        if (isset($_POST)) {
            $data = $_POST;
            $data["pwd"] = password_hash("Pass123!@#", PASSWORD_DEFAULT);
            $data["ip"] = $_SERVER["REMOTE_ADDR"];
            unset($data["action"]);
            $this->adminDB[$_SESSION["db_1"]]->autocommit(FALSE);
            $error = array();
            $fileData = $this->uploadFile();
            $sql = $this->ask_mysqli->insert("filesystem", $fileData);
            $this->adminDB[$_SESSION["db_1"]]->query($sql) == true ? true : array_push($error, "fileSystem query error");
            $data["resume"] = $this->adminDB[$_SESSION["db_1"]]->insert_id;
            $userSql = $this->ask_mysqli->insert("user", $data);
            $this->adminDB[$_SESSION["db_1"]]->query($userSql) == true ? true : array_push($error, "user query error " . $userSql);
            $data["id"] = $this->adminDB[$_SESSION["db_1"]]->insert_id;
            $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->update(array("isUsed" => 1), "filesystem") . $this->ask_mysqli->whereSingle(array("id" => $data["resume"]))) == true ? true : array_push($error, "resume assign to user query error");
            if (empty($error)) {

                $mail = $this->sendMail($data);
                //$sms=$this->sendSMS($data);
                $this->adminDB[$_SESSION["db_1"]]->commit();
                //header("HTTP/1.1 200 Invalid username or password");
                echo json_encode(array("status" => 1, "message" => "Registration Success...", "mail" => $mail, "sms" => $sms));
            } else {
                $this->adminDB[$_SESSION["db_1"]]->rollback();
                $this->deleteFile($fileData);
                // header("HTTP/1.1 400 Invalid username or password");
                echo json_encode(array("status" => 0, "message" => "Error" . json_encode($error)));
            }
        } else {
            // header("HTTP/1.1 400 Invalid username or password");
            echo json_encode(array("status" => 0, "message" => "Invalid Row"));
        }
    }

    function loadusettable() {
        try {
            $request = $_REQUEST;
            $col = array(
                0 => 'id',
                1 => 'name',
                2 => 'email',
                3 => 'mobile'
            );
            $sql = $this->ask_mysqli->select("user", $_SESSION["db_1"]);
            $sql .=$this->ask_mysqli->whereSingle(array("addbyid" => $_POST["id"]));
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            $totalFilter = $totalData;

            /* Search */
            if (!empty($request['search']['value'])) {
                $sql.=" AND (name Like '%" . $request['search']['value'] . "%'";
                $sql.=" OR email Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR mobile Like '%" . $request['search']['value'] . "%' ";

                $sql.=" OR location Like '%" . $request['search']['value'] . "%' )";
            }
            /* Order */
            $sql.=$this->ask_mysqli->orderBy($request['order'][0]['dir'], $col[$request['order'][0]['column']]) . $this->ask_mysqli->limitWithOffset($request['start'], $request['length']);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            while ($row = $query->fetch_assoc()) {
                $subdata = array();
                $subdata[] = $row['id'];
                $subdata[] = $row['name'];
                $subdata[] = $row['email']; //. " Dist: " . $row['dist'] . ", Tal: " . $row['tal'] . "<br>" . $row['state'] . "(" . $row['pin'] . ")";
                $subdata[] = $row['mobile'];
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

    function excelImport() {
        try {
            ///print_r($_FILES);die;
            if (isset($_FILES["file"]) && $_FILES["file"]["error"] == UPLOAD_ERR_OK) {
                $uploadDir = "assets/upload/temp";
                $tmpFile = $_FILES['file']['tmp_name'];
                $name = time() . '-' . $_FILES['file']['name'];
                $filename = $uploadDir . '/' . $name;
                $path = getcwd() . "/" . $filename;
                move_uploaded_file($tmpFile, $path);
                $objPHPExcel = $this->getExcelFileObject($path);
                $sheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                //print_r($sheet);die;
                $this->insertData($sheet);
            }
        } catch (Exception $ex) {
            
        }
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
                $data = array("name" => $val["B"], "email" => $val["C"], "mobile" => $val["D"], "location" => $val["E"], "tc" => $val["F"], "type" => $val["G"], "pwd" => $pwd, "ip" => $_SERVER["REMOTE_ADDR"], "addby" => $_POST["addby"], "addbyid" => $_POST["addbyid"]);
                $sql = $this->ask_mysqli->insert("user", $data);
                $this->adminDB[$_SESSION["db_1"]]->query($sql) == true ? true : array_push($error, "inset Error " . $this->adminDB[$_SESSION["db_1"]]->error);
                array_push($sdata, array("name" => $data["name"], "email" => $data["email"], "password" => $password));
            }
        }
        if (empty($error) && !$flag) {
            echo json_encode(array("toast" => array("success", "Student", " Added Successfully"), "status" => 1, "message" => "Insert Successfully.."));
            $this->adminDB[$_SESSION["db_1"]]->commit();
            foreach ($sdata as $key => $val) {
                $mail = $this->sendMail($val);
            }
        } else {
            echo json_encode(array("toast" => array("danger", "Student", " Failed to add " . json_encode($error)), "status" => 0, "message" => "Insert failed " . json_encode($error)));
            $this->adminDB[$_SESSION["db_1"]]->rollback();
        }
    }

    function adduser() {
        if (isset($_POST)) {
            $data = $_POST;
            $data["pwd"] = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
            $data["ip"] = $_SERVER["REMOTE_ADDR"];
            unset($data["action"]);
            $this->adminDB[$_SESSION["db_1"]]->autocommit(FALSE);
            $error = array();
            $fileData = $this->uploadFile();
            $sql = $this->ask_mysqli->insert("filesystem", $fileData);
            $this->adminDB[$_SESSION["db_1"]]->query($sql) == true ? true : array_push($error, "fileSystem query error " . $this->adminDB[$_SESSION["db_1"]]->error);
            $data["resume"] = $this->adminDB[$_SESSION["db_1"]]->insert_id;
            if($data["type"]==="0")
            {
                $data["employ"]=1;
            }
            $userSql = $this->ask_mysqli->insert("user", $data);
            $this->adminDB[$_SESSION["db_1"]]->query($userSql) == true ? true : array_push($error, "user query error " . $this->adminDB[$_SESSION["db_1"]]->error);
            $data["id"] = $this->adminDB[$_SESSION["db_1"]]->insert_id;
            $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->update(array("isUsed" => 1), "filesystem") . $this->ask_mysqli->whereSingle(array("id" => $data["resume"]))) == true ? true : array_push($error, "resume assign to user query error " . $this->adminDB[$_SESSION["db_1"]]->error);
            if (empty($error)) {
                $this->adminDB[$_SESSION["db_1"]]->commit();
                $mail = $this->sendMail($data);
                $this->adminDB[$_SESSION["db_1"]]->commit();
                //$sms=$this->sendSMS($data);
                //header("HTTP/1.1 200 Invalid username or password");
                echo json_encode(array("status" => 1, "message" => "Registration Success...", "mail" => $mail, "sms" => $sms));
            } else {
                $this->adminDB[$_SESSION["db_1"]]->rollback();
                $this->deleteFile($fileData);
                // header("HTTP/1.1 400 Invalid username or password");
                echo json_encode(array("status" => 0, "message" => "Error" . json_encode($error)));
            }
        } else {
            // header("HTTP/1.1 400 Invalid username or password");
            echo json_encode(array("status" => 0, "message" => "Invalid Row"));
        }
    }

    function deleteFile($fileData) {
        unlink($fileData["path"]);
        return $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->delete("filesyste") . $this->ask_mysqli->whereSingle(array("id" => $fileData["id"])));
    }

    function uploadFile() {
        $uploadDir = "assets/upload/resume";
        $tmpFile = $_FILES['myresume']['tmp_name'];
        $name = time() . '-' . $_FILES['myresume']['name'];
        $filename = $uploadDir . '/' . $name;
        $path = getcwd() . "/" . $filename;
        move_uploaded_file($tmpFile, $path);
        return array("url" => $filename, "path" => $path, "extension" => $_FILES["myresume"]["type"], "name" => $name);
    }

    function sendMail($data) {
        $name = $data["name"];
        $email = $data["email"];
        $passwordResetLink = userurl . "?r=active&e=" . $this->encript->encTxt($email) . "&i=" . $this->encript->encTxt($data["id"]);
        $shortLink = $this->createLink($passwordResetLink);
        ob_start();                      // start capturing output
        include('email/userRegisterVerificationMail.php');   // execute the file
        $content = ob_get_contents();    // get the contents from the buffer

        $mail = $this->mailObject->sendmailWithoutAttachment($email, noreplayid, company, $content, "Account verification of poolcampus.co.in ", "");
        ob_end_clean();
        return $mail;
    }

    function createLink($passLink) {
        $sql = $this->ask_mysqli->insert("shortLink", array("link" => $passLink, "valid_time" => 20));
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        $id = $this->adminDB[$_SESSION["db_1"]]->insert_id;
        return userurl . "?r=short&p=" . $this->encript->encTxt($id);
    }

    function sendSMS($data) {
        $msg = "Dear " . $data["name"];
        $msg.="\n You Succefully creat account on http://poolcampus.co.in/";
        return $this->ask_sms->sendPostSMS($data["mobile"], $msg, "p");
    }

}
