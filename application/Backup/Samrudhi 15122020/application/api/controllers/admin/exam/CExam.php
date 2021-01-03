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

class CExam extends CAaskController {

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
//                print_r($_POST);
//                die;
                $this->save();
                break;
            case "update":
                $this->update();
                break;
            case "select":
                $this->select();
                break;
            case "selectExam":
                $this->selectExam();
                break;
            case "delete":
                $this->delete();
                break;
            case "excel":
                $this->excelImport();
                break;
            case "clist":
                $this->clist();
                break;
            case "sublist":
                $this->sublist();
                break;
            case "loadSubjectTable":
                $this->loadSubjectTable();
                break;
            case "rlist":
                $this->rlist();
                break;
            case "clgrlist":
                $this->clgrlist();
                break;
            case "clglist":
                $this->clglist();
                break;
            case "rectable":
                $this->rectable();
                break;
            case "deleteCriteria":
                $this->deleteCriteria();
                break;
            case "deleteSubject":
                $this->deleteSubject();
                break;
            case "Result":
                $this->Result();
                break;
            case "getExamTitle":
                $sql = $this->ask_mysqli->select("exam", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => $_POST["id"]));
                $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
                if ($row = $result->fetch_assoc()) {
                    echo json_encode($row);
                } else {
                    echo json_encode(array("title" => "Invalid Request"));
                }
                break;

            default :
                echo json_encode(array("toast" => array("danger", "exam", "Invalid exam selected "), "status" => 0, "message" => "Invalid subject selected"));
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

    public function deleteCriteria() {
        try {
            $this->adminDB[$_SESSION["db_1"]]->autocommit(false);
            $error = array();
            $sql = $this->ask_mysqli->delete("exam_criteria") . $this->ask_mysqli->whereSingle(array("id" => $_POST["id"]));
            $this->adminDB[$_SESSION["db_1"]]->query($sql) == true ? true : array_push($error, "Erro on Delete Exam Criteria..!");
            if (empty($error)) {
                $this->adminDB[$_SESSION["db_1"]]->commit();
                echo json_encode(array("toast" => array("success", "exam", " Delete Successfully"), "status" => 1));
            } else {
                $this->adminDB[$_SESSION["db_1"]]->rollback();
                echo json_encode(array("toast" => array("success", "exam", " Delete Failed"), "status" => 0));
            }
        } catch (Exception $ex) {
            
        }
    }

    public function deleteSubject() {
        try {
            $sql = $this->ask_mysqli->select("examselectsubject", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => $_POST["id"]));
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            $examid = "";
            $question = "";
            if ($row = $result->fetch_assoc()) {
                $examid = $row["examid"];
                $question = $row["squestion"];
            }
            $result = $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->select("exam", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => $examid)));
            $noofquestion = "";
            if ($row = $result->fetch_assoc()) {
                $noofquestion = $row["noofquestion"];
            }
            $noofquestion = $noofquestion - $question;
            $this->adminDB[$_SESSION["db_1"]]->autocommit(false);
            $error = array();
            $sql = $this->ask_mysqli->delete("examselectsubject") . $this->ask_mysqli->whereSingle(array("id" => $_POST["id"]));
            $this->adminDB[$_SESSION["db_1"]]->query($sql) == true ? true : array_push($error, "Erro on Delete Exam Criteria..!");
            $sql = $this->ask_mysqli->updateDNC(array("noofquestion" => $question), "exam") . $this->ask_mysqli->whereSingle(array("id" => $examid));
            $this->adminDB[$_SESSION["db_1"]]->query($sql) == true ? true : array_push($error, "erro on update exam");
            if (empty($error)) {
                $this->adminDB[$_SESSION["db_1"]]->commit();

                echo json_encode(array("toast" => array("success", "exam", " Delete Successfully"), "status" => 1, "noofquestion" => $noofquestion));
            } else {
                $this->adminDB[$_SESSION["db_1"]]->rollback();
                echo json_encode(array("toast" => array("success", "exam", " Delete Failed"), "status" => 0));
            }
        } catch (Exception $ex) {
            
        }
    }

    function Result() {
        try {
            $request = $_REQUEST;
            $col = array(
                0 => 'id',
                1 => 'title',
                2 => 'companyid',
                3 => 'noofquestion',
                4 => 'markofeach',
                5 => 'negativemarkofeach',
                6 => 'passingmark',
                7 => 'startdate',
                8 => 'closedate',
                9 => 'isActive',
                10 => 'onCreate',
                11 => 'action'
            );
            $sql = $this->ask_mysqli->select("userexam", $_SESSION["db_1"]);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            $totalFilter = $totalData;
            $sql .=$this->ask_mysqli->whereSingle(array("examid" => $_POST["id"]));
            /* Search */
            if (!empty($request['search']['value'])) {
                $sql.=" AND (obtainmarks Like '%" . $request['search']['value'] . "%'";
                $sql.=" OR positive Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR negative Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR result Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR exmstatus Like '%" . $request['search']['value'] . "%' )";
            }
            /* Order */
            $sql.=$this->ask_mysqli->orderBy($request['order'][0]['dir'], $col[$request['order'][0]['column']]) . $this->ask_mysqli->limitWithOffset($request['start'], $request['length']);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            while ($row = $query->fetch_assoc()) {
                $subdata = array();
                $subdata[] = $row['id'];
                $subdata[] = $row['userid'];
                $result = $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->select("userpersonal", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $row["userid"])));
                $r = $result->fetch_assoc();
                $subdata[] = $r["firstname"] . " " . $r["middlename"] . " " . $r["lastname"];
                $result2 = $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->select("user", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => $row["userid"])));
                $r2 = $result2->fetch_assoc();
                $subdata[] = $r2["mobile"];
                $subdata[] = $r2["email"];
                $subdata[] = $r["gender"];
                $subdata[] = $r["address"] . " Dist: " . $r["dist"] . ", Tal: " . $r["city"] . ", " . $r["state"];

                //$subdata[] = $row['companyid']; //. " Dist: " . $row['dist'] . ", Tal: " . $row['tal'] . "<br>" . $row['state'] . "(" . $row['pin'] . ")";
                $subdata[] = $row['obtainmarks'];
                $subdata[] = $row['positive'];
                $subdata[] = $row['negative'];
                $subdata[] = $row['result'];

                $subdata[] = $row['onUpdate'];
                $subdata[] = ' <button onclick="clickOnLink(\'/?r=dashboard&v=userprofile&id=' . $row["userid"] . '\', \'#app-container\', false)" data-toggle"modal" data-target="#mydesc" class="btn btn-primary btn-xs"> <i class="fa fa-edit"></i> View User profile</button>';

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

    public function rectable() {
        try {
            $request = $_REQUEST;
            $col = array(
                0 => 'id',
                1 => 'title',
                2 => 'companyid',
                3 => 'noofquestion',
                4 => 'markofeach',
                5 => 'negativemarkofeach',
                6 => 'passingmark',
                7 => 'startdate',
                8 => 'closedate',
                9 => 'isActive',
                10 => 'onCreate',
                11 => 'action'
            );
            $sql = $this->ask_mysqli->select("exam", $_SESSION["db_1"]);
            $sql .=$this->ask_mysqli->where(array("companyid" => $_POST["id"], "postby" => $_POST["postby"]), "AND");

            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            $totalFilter = $totalData;

            /* Search */
            if (!empty($request['search']['value'])) {
                $sql.=" AND (title Like '%" . $request['search']['value'] . "%'";
                $sql.=" OR companyid Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR noofquestion Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR markofeach Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR negativemarkofeach Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR passingmark Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR startdate Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR closedate Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR isActive Like '%" . $request['search']['value'] . "%' )";
            }
            /* Order */
            $sql.=$this->ask_mysqli->orderBy($request['order'][0]['dir'], $col[$request['order'][0]['column']]) . $this->ask_mysqli->limitWithOffset($request['start'], $request['length']);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            while ($row = $query->fetch_assoc()) {
                $subdata = array();
                $subdata[] = $row['id'];
                $subdata[] = $row['title'];
                $result = $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->select("company", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => $row["companyid"])));
                if ($r = $result->fetch_assoc()) {
                    $subdata[] = $r['company'];
                } else {
                    $subdata[] = $row['companyid'];
                }
                //$subdata[] = $row['companyid']; //. " Dist: " . $row['dist'] . ", Tal: " . $row['tal'] . "<br>" . $row['state'] . "(" . $row['pin'] . ")";
                $subdata[] = $row['noofquestion'];
                $subdata[] = $row['markofeach'];
                $subdata[] = $row['negativemarkofeach'];
                $subdata[] = $row['passingmark'];
                $subdata[] = $row['startdate'];
                $subdata[] = $row['closedate'];
                $subdata[] = $row['examtime'];
                $subdata[] = '<a href="#" onclick="editbusiness(' . $row["id"] . ')" data-toggle"modal" data-target="#myQuestion" class="btn btn-warning btn-xs">Subject</a>';
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
                $active .= ' &nbsp;<button onclick="getResult(' . $row["id"] . ')" class="btn btn-warning btn-xs"> <i class="fa fa-edit"></i> View Result</button>';
                $subdata[] = $active . ' <button onclick="clickOnLink(\'/?r=dashboard&v=view' . $row["postby"] . 'exam&id=' . $row["id"] . '\', \'#app-container\', false)" data-toggle"modal" data-target="#mydesc" class="btn btn-primary btn-xs"> <i class="fa fa-edit"></i> Edit</button>';

                //$subdata[] = $active . ' <button onclick="description(' . $row["id"] . ')" data-toggle"modal" data-target="#mydesc" class="btn btn-primary btn-xs"> <i class="fa fa-edit"></i> Description</button>';
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

    public function loadSubjectTable() {
        try {
            $request = $_REQUEST;
            $col = array(
                0 => 'id',
                1 => 'Examid',
                2 => 'Subject',
                3 => 'Questions',
                4 => 'onCreate'
            );
            $sql = $this->ask_mysqli->select("examselectsubject", $_SESSION["db_1"]);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            $totalFilter = $totalData;
            $sql .=$this->ask_mysqli->whereSingle(array("examid" => $_POST["examid"]));
            /* Search $this->ask_mysqli->whereSingle(array("examid" => $_POST["examid"]) */
            if (!empty($request['search']['value'])) {
                $sql.=" AND (examid Like '%" . $request['search']['value'] . "%'";
                $sql.=" OR subject Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR squestion Like '%" . $request['search']['value'] . "%' )";
            }
            /* Order */
            $sql.=$this->ask_mysqli->orderBy($request['order'][0]['dir'], $col[$request['order'][0]['column']]) . $this->ask_mysqli->limitWithOffset($request['start'], $request['length']);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            while ($row = $query->fetch_assoc()) {
                $subdata = array();
                $subdata[] = $row['id'];
                $subdata[] = $row['examid'];
                $subdata[] = $row['subject'];
                $subdata[] = $row['squestion'];
                $subdata[] = $row['onCreate'];
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

    public function loadTable() {
        try {
            $request = $_REQUEST;
            $col = array(
                0 => 'id',
                1 => 'title',
                2 => 'companyid',
                3 => 'noofquestion',
                4 => 'markofeach',
                5 => 'negativemarkofeach',
                6 => 'passingmark',
                7 => 'startdate',
                8 => 'closedate',
                9 => 'isActive',
                10 => 'onCreate',
                11 => 'action',
                12 => 'postby'
            );
            $sql = $this->ask_mysqli->select("exam", $_SESSION["db_1"]);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            $totalFilter = $totalData;
            $sql .=$this->ask_mysqli->whereSingle(array("1" => "1"));
            /* Search */
            if (!empty($request['search']['value'])) {
                $sql.=" AND (title Like '%" . $request['search']['value'] . "%'";
                $sql.=" OR companyid Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR postby Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR noofquestion Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR markofeach Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR negativemarkofeach Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR passingmark Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR startdate Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR closedate Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR isActive Like '%" . $request['search']['value'] . "%' )";
            }
            /* Order */
            $sql.=$this->ask_mysqli->orderBy($request['order'][0]['dir'], $col[$request['order'][0]['column']]) . $this->ask_mysqli->limitWithOffset($request['start'], $request['length']);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            while ($row = $query->fetch_assoc()) {
                $subdata = array();
                $subdata[] = $row['id'];
                $subdata[] = $row['title'];
                $result = $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->select($row['postby'], $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => $row["companyid"])));
                if ($r = $result->fetch_assoc()) {
                    $subdata[] = $r[$row['postby']];
                } else {
                    $subdata[] = $row['companyid'];
                }
                $subdata[] = $row['postby'];
                //$subdata[] = $row['companyid']; //. " Dist: " . $row['dist'] . ", Tal: " . $row['tal'] . "<br>" . $row['state'] . "(" . $row['pin'] . ")";
                $subdata[] = $row['noofquestion'];
                $subdata[] = $row['markofeach'];
                $subdata[] = $row['negativemarkofeach'];
                $subdata[] = $row['passingmark'];
                $subdata[] = $row['startdate'];
                $subdata[] = $row['closedate'];
                $subdata[] = $row['examtime'];
                $subdata[] = '<a href="#" onclick="editbusiness(' . $row["id"] . ')" data-toggle"modal" data-target="#myQuestion" class="btn btn-warning btn-xs">Subject</a>';
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
                //$active .= '<a onclick="editExam(' . $row["id"] . ',0)" class="btn btn-warning btn-xs"> <i class="fa fa-edit"></i> Edit</button>';
                $active .= ' &nbsp;<button onclick="getResult(' . $row["id"] . ')" class="btn btn-warning btn-xs"> <i class="fa fa-edit"></i> View Result</button>';
                
                $subdata[] = $active . ' <button onclick="clickOnLink(\'/?r=dashboard&v=view' . $row["postby"] . 'exam&id=' . $row["id"] . '\', \'#app-container\', false)" data-toggle"modal" data-target="#mydesc" class="btn btn-primary btn-xs"> <i class="fa fa-edit"></i> Description</button>';
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
        $subject = $data["subject"];
        $squestion = $data["squestion"];
        $main = $data["main"];
        $sub = $data["sub"];
        $branch = $data["branch"];
        $passingyear = $data["passingyear"];
        $percentage = $data["percentage"];
        $eid = $data["edi"];
        $sid = $data["sid"];
        unset($data["subject"]);
        unset($data["squestion"]);
        unset($data["main"]);
        unset($data["sub"]);
        unset($data["branch"]);
        unset($data["passingyear"]);
        unset($data["percentage"]);
        unset($data["eid"]);
        unset($data["sid"]);
        $filename = "";
        if (isset($_FILES["banner"]) && $_FILES["banner"]["error"] == UPLOAD_ERR_OK) {
            $uploadDir = "assets/upload/banner";
            $tmpFile = $_FILES['banner']['tmp_name'];
            $name = time() . '-' . $_FILES['banner']['name'];
            $filename = $uploadDir . '/' . $name;
            $path = getcwd() . "/" . $filename;
            move_uploaded_file($tmpFile, $path);
        }
        $data["banner"] = $filename;
        $error = array();
        $this->adminDB[$_SESSION["db_1"]]->autocommit(false);
        $sql = $this->ask_mysqli->insert("exam", $data);
        $this->adminDB[$_SESSION["db_1"]]->query($sql) == true ? true : array_push($error, "inset Error " . $this->adminDB[$_SESSION["db_1"]]->error);
        $id = $this->adminDB[$_SESSION["db_1"]]->insert_id;
        for ($s = 0; $s < count($subject); $s++) {
            $subjectquery = $this->ask_mysqli->insert("examselectsubject", array("examid" => $id, "subject" => $subject[$s], "squestion" => $squestion[$s]));
            $this->adminDB[$_SESSION["db_1"]]->query($subjectquery) == true ? true : array_push($error, "Erro on insert Subject " . $this->adminDB[$_SESSION['db_1']]->error);
        }
        for ($s = 0; $s < count($main); $s++) {
            $subjectquery = $this->ask_mysqli->insert("exam_criteria", array("examid" => $id, "main" => $main[$s], "sub" => $sub[$s], "branch" => $branch[$s], "passingyear" => $passingyear[$s], "percentage" => $percentage[$s]));
            $this->adminDB[$_SESSION["db_1"]]->query($subjectquery) == true ? true : array_push($error, "Erro on insert Subject " . $this->adminDB[$_SESSION['db_1']]->error);
        }

        if (empty($error)) {
            $this->adminDB[$_SESSION["db_1"]]->commit();
            //$this->sendMailtoUser($_POST["exam"], $_POST["email"], $password);
            echo json_encode(array("toast" => array("success", "exam", " Added Successfully"), "status" => 1, "message" => "Insert Successfully..", "data" => $data));
        } else {
            // $this->sendMailtoUser($_POST["exam"], $_POST["email"], $password);
            echo json_encode(array("toast" => array("danger", "exam", " Failed to add " . $error[0]), "status" => 0, "message" => "Insert failed " . $error[0]));
            $this->adminDB[$_SESSION["db_1"]]->rollback();
        }
    }

    function update() {

        $data = $_POST;
        unset($data["action"]);
        unset($data["id"]);
        $subject = $data["subject"];
        $squestion = $data["squestion"];
        $main = $data["main"];
        $sub = $data["sub"];
        $branch = $data["branch"];
        $passingyear = $data["passingyear"];
        $percentage = $data["percentage"];
        $eid = $data["eid"];
        $sid = $data["sid"];
        unset($data["subject"]);
        unset($data["squestion"]);
        unset($data["main"]);
        unset($data["sub"]);
        unset($data["branch"]);
        unset($data["passingyear"]);
        unset($data["percentage"]);
        unset($data["eid"]);
        unset($data["sid"]);
        $filename = "";

        if (isset($_FILES["banner"]) && $_FILES["banner"]["error"] == UPLOAD_ERR_OK) {
            $uploadDir = "assets/upload/banner";
            $tmpFile = $_FILES['banner']['tmp_name'];
            $name = time() . '-' . $_FILES['banner']['name'];
            $filename = $uploadDir . '/' . $name;
            $path = getcwd() . "/" . $filename;
            move_uploaded_file($tmpFile, $path);
            $data["banner"] = $filename;
        }


        $error = array();
        $this->adminDB[$_SESSION["db_1"]]->autocommit(false);
        $sql = $this->ask_mysqli->update($data, "exam") . $this->ask_mysqli->whereSingle(array("id" => $_POST["id"]));
        $this->adminDB[$_SESSION["db_1"]]->query($sql) == true ? true : array_push($error, "inset Error " . $this->adminDB[$_SESSION["db_1"]]->error);
        $this->adminDB[$_SESSION["db_1"]]->query($sql) == true ? true : array_push($error, "inset Error " . $this->adminDB[$_SESSION["db_1"]]->error);
        $id = $_POST["id"];
        for ($s = 0; $s < count($subject); $s++) {
            if ($sid[$s] != 0) {
                $subjectquery = $this->ask_mysqli->update(array("examid" => $id, "subject" => $subject[$s], "squestion" => $squestion[$s]), "examselectsubject") . $this->ask_mysqli->whereSingle(array("id" => $sid[$s]));
                $this->adminDB[$_SESSION["db_1"]]->query($subjectquery) == true ? true : array_push($error, "Erro on insert Subject " . $this->adminDB[$_SESSION['db_1']]->error);
            } else {
                $subjectquery = $this->ask_mysqli->insert("examselectsubject", array("examid" => $id, "subject" => $subject[$s], "squestion" => $squestion[$s]));
                $this->adminDB[$_SESSION["db_1"]]->query($subjectquery) == true ? true : array_push($error, "Erro on insert Subject " . $this->adminDB[$_SESSION['db_1']]->error);
            }
        }

        for ($s = 0; $s < count($main); $s++) {
            if ($eid[$s] != 0) {
                $subjectquery = $this->ask_mysqli->update(array("examid" => $id, "main" => $main[$s], "sub" => $sub[$s], "branch" => $branch[$s], "passingyear" => $passingyear[$s], "percentage" => $percentage[$s]), "exam_criteria") . $this->ask_mysqli->whereSingle(array("id" => $eid[$s]));
                $this->adminDB[$_SESSION["db_1"]]->query($subjectquery) == true ? true : array_push($error, "Erro on insert Subject " . $this->adminDB[$_SESSION['db_1']]->error);
            } else {
                $subjectquery = $this->ask_mysqli->insert("exam_criteria", array("examid" => $id, "main" => $main[$s], "sub" => $sub[$s], "branch" => $branch[$s], "passingyear" => $passingyear[$s], "percentage" => $percentage[$s]));
                $this->adminDB[$_SESSION["db_1"]]->query($subjectquery) == true ? true : array_push($error, "Erro on insert Subject " . $this->adminDB[$_SESSION['db_1']]->error);
            }
        }

        if (empty($error)) {
            $this->adminDB[$_SESSION["db_1"]]->commit();
            //$this->sendMailtoUser($_POST["exam"], $_POST["email"], $password);
            echo json_encode(array("toast" => array("success", "exam", " Update Successfully"), "status" => 1, "message" => "Insert Successfully..", "data" => $data));
        } else {
            // $this->sendMailtoUser($_POST["exam"], $_POST["email"], $password);
            $str = json_encode($error);
            echo json_encode(array("toast" => array("danger", "exam", " Failed to add " . $str), "status" => 0, "message" => "Insert failed " . $error[0]));
            $this->adminDB[$_SESSION["db_1"]]->rollback();
        }
    }

    function selectExam() {
        $where = array("id" => $_POST["id"]);
        $sql = $this->ask_mysqli->select("exam", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle($where);
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        if ($row = $result->fetch_assoc()) {

            $examSubjectQuery = $this->ask_mysqli->select("examselectsubject", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("examid" => $row['id']));
            $examSubjectResult = $this->adminDB[$_SESSION["db_1"]]->query($examSubjectQuery);
            $examSubjectData = array();
            while ($examSubjectRow = $examSubjectResult->fetch_assoc()) {
                array_push($examSubjectData, $examSubjectRow);
            }
            $examCriteriaQuery = $this->ask_mysqli->select("exam_criteria", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("examid" => $row['id']));
            $examCriteriaResult = $this->adminDB[$_SESSION["db_1"]]->query($examCriteriaQuery);
            $examCriteriaData = array();
            while ($examCriteriaRow = $examCriteriaResult->fetch_assoc()) {
                array_push($examCriteriaData, $examCriteriaRow);
            }
            echo json_encode(array("rows" => $row, "subject" => $examSubjectData, "criteria" => $examCriteriaData, "toast" => array("success", "exam", "exam selected "), "status" => 1, "message" => " exam selected"));
            //echo json_encode($row);
        } else {
            echo json_encode(array("toast" => array("danger", "exam", "Invalid Exam selected "), "status" => 0, "message" => "Invalid exam selected"));
        }
    }

    function select() {
        $where = array("id" => $_POST["id"]);
        $sql = $this->ask_mysqli->select("exam", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle($where);
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        if ($row = $result->fetch_assoc()) {
            echo json_encode(array("row" => $row, "toast" => array("success", "exam", "exam selected "), "status" => 1, "message" => " exam selected"));
            //echo json_encode($row);
        } else {
            echo json_encode(array("toast" => array("danger", "exam", "Invalid Exam selected "), "status" => 0, "message" => "Invalid exam selected"));
        }
    }

    function delete() {

        $sql = $this->ask_mysqli->delete("exam") . $this->ask_mysqli->whereSingle(array("id" => $_POST["id"]));
        $sql2 = $this->ask_mysqli->delete("examselectsubject") . $this->ask_mysqli->whereSingle(array("examid" => $_POST["id"]));
        if ($this->adminDB[$_SESSION["db_1"]]->query($sql) && $this->adminDB[$_SESSION["db_1"]]->query($sql2)) {
            echo json_encode(array("toast" => array("success", "exam", "Delete Success "), "status" => 0, "message" => "Delete Success"));
        } else {
            echo json_encode(array("toast" => array("danger", "exam", "Invalid exam selected " . $this->adminDB[$_SESSION["db_1"]]->error), "status" => 0, "message" => "Invalid exam selected " . $this->adminDB[$_SESSION["db_1"]]->error));
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
        $link = examurl;
        ob_start();                      // start capturing output
        include('email/examRegistration.php');   // execute the file
        $content = ob_get_contents();    // get the contents from the buffer
        $data = array(
            "status" => 1,
            "message" => " exam account Register success, please check your email.",
            "mail" => $this->mailObject->sendmailWithoutAttachment($email, "info@aasksoft.co.in", "aasksoft", $content, "exam account create successfully", "")
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
                $data = array("exam" => $val["B"], "address" => $val["C"], "state" => $val["D"], "dist" => $val["E"], "city" => $val["F"], "pin" => $val["G"], "uni" => $val["H"], "mobile" => $val["I"], "email" => $val["J"], "pwd" => $pwd);
                $sql = $this->ask_mysqli->insert("exam", $data);
                $this->adminDB[$_SESSION["db_1"]]->query($sql) == true ? true : array_push($error, "inset Error " . $this->adminDB[$_SESSION["db_1"]]->error);
                array_push($sdata, array("name" => $data["exam"], "email" => $data["email"], "password" => $password));
            }
        }
        if (empty($error) && !$flag) {
            echo json_encode(array("toast" => array("success", "exam", " Added Successfully"), "status" => 1, "message" => "Insert Successfully.."));
            $this->adminDB[$_SESSION["db_1"]]->commit();
            foreach ($sdata as $key => $val) {
                $this->sendMailtoUser($val["name"], $val["email"], $val["password"]);
            }
        } else {
            echo json_encode(array("toast" => array("danger", "exam", " Failed to add " . json_encode($error)), "status" => 0, "message" => "Insert failed " . json_encode($error)));
            $this->adminDB[$_SESSION["db_1"]]->rollback();
        }
    }

    function rlist() {
        try {
            $data = array();
            $restult = $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->select("company", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => $_POST["id"])));
            while ($row = $restult->fetch_assoc()) {
                array_push($data, $row);
            }
            echo json_encode($data);
        } catch (Exception $ex) {
            
        }
    }

    function clgrlist() {
        try {
            $data = array();
            $restult = $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->select("college", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => $_POST["id"])));
            while ($row = $restult->fetch_assoc()) {
                array_push($data, $row);
            }
            echo json_encode($data);
        } catch (Exception $ex) {
            
        }
    }

    function clglist() {
        try {
            $data = array();
            $restult = $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->select("college", $_SESSION["db_1"]));
            while ($row = $restult->fetch_assoc()) {
                array_push($data, $row);
            }
            echo json_encode($data);
        } catch (Exception $ex) {
            
        }
    }

    function clist() {
        try {
            $data = array();
            $restult = $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->select("company", $_SESSION["db_1"]));
            while ($row = $restult->fetch_assoc()) {
                array_push($data, $row);
            }
            echo json_encode($data);
        } catch (Exception $ex) {
            
        }
    }

    function sublist() {
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
