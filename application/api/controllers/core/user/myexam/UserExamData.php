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

class UserExamData extends CAaskController {

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
            switch ($_POST["action"]) {
                case "loadTable":
                    $this->loadTable();
                    break;
                case "myanswersheet":
                    $this->myanswersheet();
                    break;
                case "myprofile":
                    $array = $this->myprofile();
                    $array["personal"] = $this->mypersonal();
                    $array["education"] = $this->myeducation();
                    $array["employ"] = $this->myexprience();
                    $array["skill"] = $this->myskill();
                    $array["profile"] = $this->myprofilepic($array["profile"]);
                    $array["resumurl"] = $this->myprofilepic($array["resume"]);
                    echo json_encode($array);
                    break;
                case "myeducation":
                    $this->loadTableEducation();
                    break;
                case "loadEducationTable":
                    $this->loadTableEducation();
                    break;
                case "loadTableExprience":
                    $this->loadTableExprience();
                    break;
                case "loadTableSkill":
                    $this->loadTableSkill();
                    break;
                case "deleteEducation":
                    $this->deleteEducation();
                    break;
                case "deleteExperience":
                    $this->deleteExperience();
                    break;
                case "deleteSkill":
                    $this->deleteSkill();
                    break;
                case "updatePersonal":
                    $this->updatePersonal();
                    break;

                default :
                    //$this->loadTable();
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

    function updatePersonal() {
        $where = array("id" => $_POST["id"]);
        unset($_POST["id"]);
        unset($_POST["action"]);
        $sql = $this->ask_mysqli->update($_POST,"userpersonal") . $this->ask_mysqli->whereSingle($where);
        if ($this->adminDB[$_SESSION["db_1"]]->query($sql)) {
            echo json_encode(array("toast" => array("success", "Personal Information ", "Update Success....."), "status" => 1, "message" => "Update Success"));
        } else {
            echo json_encode(array("toast" => array("danger", "Personal Information", "Update Failed..... " . $this->adminDB[$_SESSION["db_1"]]->error), "status" => 0, "message" => "Invalid college selected " . $this->adminDB[$_SESSION["db_1"]]->error));
        }
    }

    function deleteSkill() {
        $where = array("id" => $_POST["id"]);
        $sql = $this->ask_mysqli->delete("userskill") . $this->ask_mysqli->whereSingle($where);
        if ($this->adminDB[$_SESSION["db_1"]]->query($sql)) {
            echo json_encode(array("toast" => array("success", "Skill", "Delete Success "), "status" => 0, "message" => "Delete Success"));
        } else {
            echo json_encode(array("toast" => array("danger", "Skill", "Invalid college selected " . $this->adminDB[$_SESSION["db_1"]]->error), "status" => 0, "message" => "Invalid college selected " . $this->adminDB[$_SESSION["db_1"]]->error));
        }
    }

    function deleteExperience() {
        $where = array("id" => $_POST["id"]);
        $sql = $this->ask_mysqli->delete("userexperience") . $this->ask_mysqli->whereSingle($where);
        if ($this->adminDB[$_SESSION["db_1"]]->query($sql)) {
            echo json_encode(array("toast" => array("success", "Experience", "Delete Success "), "status" => 0, "message" => "Delete Success"));
        } else {
            echo json_encode(array("toast" => array("danger", "Experience", "Invalid college selected " . $this->adminDB[$_SESSION["db_1"]]->error), "status" => 0, "message" => "Invalid college selected " . $this->adminDB[$_SESSION["db_1"]]->error));
        }
    }

    function deleteEducation() {
        $where = array("id" => $_POST["id"]);
        $sql = $this->ask_mysqli->delete("usereducation") . $this->ask_mysqli->whereSingle($where);
        if ($this->adminDB[$_SESSION["db_1"]]->query($sql)) {
            echo json_encode(array("toast" => array("success", "Education", "Delete Success "), "status" => 0, "message" => "Delete Success"));
        } else {
            echo json_encode(array("toast" => array("danger", "Education", "Invalid college selected " . $this->adminDB[$_SESSION["db_1"]]->error), "status" => 0, "message" => "Invalid college selected " . $this->adminDB[$_SESSION["db_1"]]->error));
        }
    }

    function myprofilepic($pid) {
        try {
            $data = array();
            $sql = $this->ask_mysqli->select("filesystem", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => $pid));
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            if ($row = $result->fetch_assoc()) {
                $data = $row;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $data;
    }

    function myprofile() {
        try {
            $data = array();
            $sql = $this->ask_mysqli->select("user", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => $_POST["id"]));
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            if ($row = $result->fetch_assoc()) {
                $data = $row;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $data;
    }

    function mypersonal() {
        try {
            $data = array();
            $sql = $this->ask_mysqli->select("userpersonal", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $_POST["id"]));
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            if ($row = $result->fetch_assoc()) {
                $data = $row;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $data;
    }

    function myeducation() {
        try {
            $cours = array();
            $result = $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->select("course", $_SESSION["db_1"]));
            while ($course = $result->fetch_assoc()) {
                $cours[$course["id"]] = $course["name"];
            }
            $data = array();
            $temp = array();
            $sql = $this->ask_mysqli->select("usereducation", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $_POST["id"]));
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            while ($row = $result->fetch_assoc()) {
                $row["education"] = $cours[$row["education"]];
                $row["course"] = $cours[$row["course"]];
                $row["class"] = $cours[$row["class"]];
                array_push($temp, $row);
            }
            $data = $temp;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $data;
    }

    function myexprience() {
        try {
            $data = array();
            $temp = array();
            $sql = $this->ask_mysqli->select("userexperience", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $_POST["id"]));
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            while ($row = $result->fetch_assoc()) {
                array_push($temp, $row);
            }
            $data = $temp;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $data;
    }

    function myskill() {
        try {
            $data = array();
            $temp = array();
            $sql = $this->ask_mysqli->select("userskill", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $_POST["id"]));
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            while ($row = $result->fetch_assoc()) {
                array_push($temp, $row);
            }
            $data = $temp;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $data;
    }

    function myanswersheet() {
        try {
            $temp = array();

            $sql = $this->ask_mysqli->select("exampaper", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("paperid" => $_POST["id"]));
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            $temp2 = array();
            $examid = "";
            while ($row = $result->fetch_assoc()) {
                $examid = $row["examid"];
                $sql = $this->ask_mysqli->select("userexam", $_SESSION["db_1"]) . $this->ask_mysqli->where(array("userid" => $_POST["userid"], "examid" => $examid), "AND");
                $results = $this->adminDB[$_SESSION["db_1"]]->query($sql);
                $rows = $results->fetch_assoc();

                //print_r($temp);
                $sql = $this->ask_mysqli->select("questionbank", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => $row["question"]));
                $resutl1 = $this->adminDB[$_SESSION["db_1"]]->query($sql);


                while ($row1 = $resutl1->fetch_assoc()) {
                    $temp = array();
                    if ($row1["answer"] == $row["selectoption"]) {
                        $row1["useranswer"] = $row["selectoption"];
                        $row1["status"] = "true";
                    } else {
                        $row1["useranswer"] = $row["selectoption"];
                        $row1["status"] = "false";
                    }
                    $row1["qstatus"]=$row["status"];
                    array_push($temp2, $row1);
                }
            }
            array_push($temp, $rows);
            $sql2 = $this->ask_mysqli->select("exam", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => $examid));
            $resutl2 = $this->adminDB[$_SESSION["db_1"]]->query($sql2);
            while ($row2 = $resutl2->fetch_assoc()) {
                array_push($temp, $row2);
            }
            array_push($temp, $temp2);
            echo json_encode($temp);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    function loadTable() {
        try {
            $request = $_REQUEST;
            $col = array(
                0 => 'id',
                1 => 'title',
                2 => 'obtainmarks',
                3 => 'postive',
                4 => 'negative',
                5 => 'result',
                6 => 'onCreate',
                7 => 'action'
            );
            $sql = $this->ask_mysqli->select("userexam", $_SESSION["db_1"]); //. $this->ask_mysqli->whereSingle(array("userid" => $_SESSION["id"]));
            $sql .=$this->ask_mysqli->whereSingle(array("userid" => $_POST["id"]));
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            $totalFilter = $totalData;
            
            /* Search */
            if (!empty($request['search']['value'])) {
                $sql.=" AND (result Like '%" . $request['search']['value'] . "%'";
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
                $result = $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->select("exam", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => $row["examid"])));
                if ($r = $result->fetch_assoc()) {
                    $subdata[] = $r['title'];
                } else {
                    $subdata[] = $row['examid'];
                }
                $subdata[] = $row['obtainmarks'];
                //$subdata[] = $row['companyid']; //. " Dist: " . $row['dist'] . ", Tal: " . $row['tal'] . "<br>" . $row['state'] . "(" . $row['pin'] . ")";
                $subdata[] = $row['positive'];
                $subdata[] = $row['negative'];
                //$subdata[] = $row['negativemarkofeach'];
                switch ($row["result"]) {
                    case "Pass":
                        $subdata[] = "<span id='color-green'>" . $row['result'] . "</span>";
                        break;
                    default :
                        $subdata[] = "<span id='color-red'>" . $row['result'] . "</span>";
                        break;
                }

                $subdata[] = $row['onCreate'];

                $subdata[] = ' <button onclick="clickOnLink(\'/?r=dashboard&v=myanswersheet&id=' . $row["id"] . '\', \'#app-container\', false)"  class="btn btn-primary btn-xs"> <i class="fa fa-eye"></i> Answer Sheet</button>';
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

    function loadTableSkill() {
        try {
            $request = $_REQUEST;
            $col = array(
                0 => 'id',
                1 => 'userid',
                2 => 'skill',
                3 => 'other'
            );
            $sql = $this->ask_mysqli->select("userskill", $_SESSION["db_1"]); //. $this->ask_mysqli->whereSingle(array("userid" => $_SESSION["id"]));
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            $totalFilter = $totalData;
            $sql .=$this->ask_mysqli->whereSingle(array("userid" => $_POST["id"]));
            /* Search */
            if (!empty($request['search']['value'])) {
                $sql.=" AND (skill Like '%" . $request['search']['value'] . "%'";
                //$sql.=" OR other Like '%" . $request['search']['value'] . "%'";
                $sql.=" OR other Like '%" . $request['search']['value'] . "%' )";
            }
            /* Order */
            $sql.=$this->ask_mysqli->orderBy($request['order'][0]['dir'], $col[$request['order'][0]['column']]) . $this->ask_mysqli->limitWithOffset($request['start'], $request['length']);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            while ($row = $query->fetch_assoc()) {
                $subdata = array();
                $subdata[] = $row['id'];
                //$subdata[] = $sql;
                $subdata[] = $row['userid'];
                $subdata[] = $row['skill'];
                $subdata[] = $row['other'];

                $subdata[] = '<button onclick="deletebusiness(' . $row["id"] . ',0)" class="btn btn-danger btn-xs"> <i class="fa fa-trash-o"></i></button>';

                //$subdata[] = ' <button onclick="clickOnLink(\'/?r=dashboard&v=myanswersheet&id=' . $row["id"] . '\', \'#app-container\', false)"  class="btn btn-primary btn-xs"> <i class="fa fa-eye"></i> Answer Sheet</button>';
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

    function loadTableExprience() {
        try {
            $request = $_REQUEST;
            $col = array(
                0 => 'id',
                1 => 'company',
                2 => 'designation',
                3 => 'location',
                4 => 'startmonth',
                5 => 'startyear',
                6 => 'endmonth',
                7 => 'endyear'
            );
            $sql = $this->ask_mysqli->select("userexperience", $_SESSION["db_1"]); //. $this->ask_mysqli->whereSingle(array("userid" => $_SESSION["id"]));
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            $totalFilter = $totalData;
            $sql .=$this->ask_mysqli->whereSingle(array("userid" => $_POST["id"]));
            /* Search */
            if (!empty($request['search']['value'])) {
                $sql.=" AND (comapny Like '%" . $request['search']['value'] . "%'";
                $sql.=" OR designation Like '%" . $request['search']['value'] . "%'";
                $sql.=" OR location Like '%" . $request['search']['value'] . "%' )";
            }
            /* Order */
            $sql.=$this->ask_mysqli->orderBy($request['order'][0]['dir'], $col[$request['order'][0]['column']]) . $this->ask_mysqli->limitWithOffset($request['start'], $request['length']);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            while ($row = $query->fetch_assoc()) {
                $subdata = array();
                $subdata[] = $row['id'];
                //$subdata[] = $sql;
                $subdata[] = $row['company'];
                $subdata[] = $row['designation'];
                $subdata[] = $row['location'];
                $subdata[] = $row['startmonth'] . "/" . $row["startyear"];
                $subdata[] = $row['endmonth'] . "/" . $row["endyear"];
                $date1 = date_create($row["startyear"] . "-" . $row["startmonth"] . "-01");
                $date2 = date_create($row["endyear"] . "-" . $row["endmonth"] . "-01");
                $diff = date_diff($date1, $date2);
                $subdata[] = $diff->format("%a days");
                //$subdata[] = $row['passingyear'];
                //$subdata[] = $row['negativemarkofeach'];

                $subdata[] = $row['onCreate'];
                $subdata[] = '<button onclick="deletebusiness(' . $row["id"] . ',0)" class="btn btn-danger btn-xs"> <i class="fa fa-trash-o"></i></button>';

                //$subdata[] = ' <button onclick="clickOnLink(\'/?r=dashboard&v=myanswersheet&id=' . $row["id"] . '\', \'#app-container\', false)"  class="btn btn-primary btn-xs"> <i class="fa fa-eye"></i> Answer Sheet</button>';
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

    function loadTableEducation() {
        try {
            $request = $_REQUEST;
            $col = array(
                0 => 'id',
                1 => 'education',
                2 => 'course',
                3 => 'university',
                4 => 'class',
                5 => 'percentage',
                6 => 'passingyear',
                7 => 'action'
            );
            $sql = $this->ask_mysqli->select("usereducation", $_SESSION["db_1"]); //. $this->ask_mysqli->whereSingle(array("userid" => $_SESSION["id"]));
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            $totalFilter = $totalData;
            $sql .=$this->ask_mysqli->whereSingle(array("userid" => $_POST["id"]));
            /* Search */
            if (!empty($request['search']['value'])) {
                $sql.=" AND (university Like '%" . $request['search']['value'] . "%'";

                $sql.=" OR percentage Like '%" . $request['search']['value'] . "%' )";
            }
            /* Order */
            $sql.=$this->ask_mysqli->orderBy($request['order'][0]['dir'], $col[$request['order'][0]['column']]) . $this->ask_mysqli->limitWithOffset($request['start'], $request['length']);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            while ($row = $query->fetch_assoc()) {
                $subdata = array();
                $subdata[] = $row['id'];
                //$subdata[] = $sql;
                $subdata[] = $this->getCourseName($row['education']);
                $subdata[] = $this->getCourseName($row['course']);
                $subdata[] = $this->getCourseName($row['class']);
                $subdata[] = $row['university'];
                $subdata[] = $row['percentage'];
                $subdata[] = $row['passingyear'];
                //$subdata[] = $row['negativemarkofeach'];

                $subdata[] = $row['onCreate'];
                $subdata[] = '<button onclick="deletebusiness(' . $row["id"] . ',0)" class="btn btn-danger btn-xs"> <i class="fa fa-trash-o"></i></button>';

                //$subdata[] = ' <button onclick="clickOnLink(\'/?r=dashboard&v=myanswersheet&id=' . $row["id"] . '\', \'#app-container\', false)"  class="btn btn-primary btn-xs"> <i class="fa fa-eye"></i> Answer Sheet</button>';
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

    function getCourseName($id) {
        $result = $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->select("course", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => $id)));
        if ($row = $result->fetch_assoc()) {
            return $row["name"];
        }
        return "";
    }

}
