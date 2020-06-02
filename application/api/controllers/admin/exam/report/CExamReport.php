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

class CExamReport extends CAaskController {

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
            case "examlist";
                $this->examlist();
                break;
            case "viewReport":
                $this->viewReport();
                break;
            case "Report":
                $this->Report();
                break;
            case "examLinks":
                $this->examLinks();
                break;
            case "student":
                $this->student();
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

    function student() {
        try {
            $request = $_REQUEST;
            $col = array(
                0 => 'id',
                1 => 'name',
                2 => 'email',
                3 => 'mobile',
                4 => 'locaiton'
            );
            $sql = $this->ask_mysqli->select("user", $_SESSION["db_1"]);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            $totalFilter = $totalData;
            $sql .=$this->ask_mysqli->whereSingle(array("1" => "1"));
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
                $subdata[] = $row['email'];
                $subdata[] = $row['mobile'];
                $subdata[] = $row['location'];
                $subdata[] = $row['ip'];
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

    function examLinks() {
        try {
            $data = array();
            array_push($data, array("Task", "No of Link"));
            unset($_POST["action"]);
            $_POST["isActive"] = 1;
            $sql = $this->ask_mysqli->selectCount("exam", "id") . $this->ask_mysqli->where($_POST, "AND");
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            $row = $result->fetch_assoc();
            array_push($data, array("Active", $row["count(id)"]));
            $_POST["isActive"] = 0;
            $sql = $this->ask_mysqli->selectCount("exam", "id") . $this->ask_mysqli->where($_POST, "AND");
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            $row = $result->fetch_assoc();
            array_push($data, array("De-Active", $row["count(id)"]));
            //array_push($data, $row["count(id)"]);
            echo json_encode($data);
        } catch (Exception $ex) {
            
        }
    }

    function Report() {
        try {
            $data = array();
            //total college
            $sql = $this->ask_mysqli->selectCount("college", "id");
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            $row = $result->fetch_assoc();
            array_push($data, $row["count(id)"]);
            //total company
            $sql = $this->ask_mysqli->selectCount("company", "id");
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            $row = $result->fetch_assoc();
            array_push($data, $row["count(id)"]);
            //total user
            $sql = $this->ask_mysqli->selectCount("user", "id");
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            $row = $result->fetch_assoc();
            array_push($data, $row["count(id)"]);
            //total exam
            $sql = $this->ask_mysqli->selectCount("exam", "id");
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            $row = $result->fetch_assoc();
            array_push($data, $row["count(id)"]);
            echo json_encode($data);
        } catch (Exception $ex) {
            
        }
    }

    function examlist() {
        try {
            $data = array();
            unset($_POST["action"]);
            $sql = $this->ask_mysqli->select("exam", $_SESSION["db_1"]) . $this->ask_mysqli->where($_POST, "AND");
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            while ($row = $result->fetch_assoc()) {
                array_push($data, array("id" => $row["id"], "title" => $row["title"]));
            }
            echo json_encode($data);
        } catch (Exception $ex) {
            
        }
    }

    function viewReport() {
        
        unset($_POST["action"]);
        unset($_POST["exam"]);
        //echo $sql = $this->ask_mysqli->select("userexam", $_SESSION["db_1"]) . $this->ask_mysqli->where($_POST, "AND");die;
        $sql = "";
        if ($_POST["result"] === "ALL") {
            unset($_POST["result"]);
            $sql = $this->ask_mysqli->select("userexam", $_SESSION["db_1"]) . $this->ask_mysqli->where($_POST, "AND");
        } else {
            $sql = $this->ask_mysqli->select("userexam", $_SESSION["db_1"]) . $this->ask_mysqli->where($_POST, "AND");
        }
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $sql = $this->ask_mysqli->select("user", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => $row["userid"]));
            $rsp = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            if ($rp = $rsp->fetch_assoc()) {
                $row["userid"] = $rp;
            }
            array_push($data, $row);
        }
        echo json_encode(array("status" => 1, "message" => "Data Featch Success", "data" => $data));
    }

}
