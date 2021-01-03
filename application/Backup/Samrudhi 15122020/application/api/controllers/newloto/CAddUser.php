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

class CAddUser extends CAaskController {

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
            case "addUser":
                $this->addUser();
                break;
            case "delete":
                $this->deleteUser();
                break;
            case "putPoint":
                $this->putPoint();
                break;
            case "getPoint":
                $this->getPoint();
                break;
            case "suspend":
                $this->suspend();
                break;
            case "adminBalance":
                $this->adminBalance();
                break;
            case "update":
                $this->update();
                break;
            case "loadMessageTable":
                $this->loadMessageTable();
                break;
            case "message":
                $this->message();
                break;
            case "changePassword":
                break;
            case "updateper":
                $this->updateper();
                break;
            case "allUser":
                $this->allUser();
                break;
            case "uploadGame":
                $this->upoadGame();
                break;
            case "loadGame":
                $this->loadGame();
                break;
            case "deleteGame":
                $this->deleteGame();
                break;
            case "blockno":
                $this->blockno();
                break;
            case "getBlockno":
                $this->getBlockno();
                break;
            default :
                $postdata = file_get_contents("php://input");
                $request = json_decode($postdata, true);
                print_r($request);
                //echo json_encode(array("toast" => array("danger", "Series", "Invalid Sereis selected "), "status" => 0, "message" => "Invalid Series selected"));
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

    function upoadGame() {
        $uploadDir = "assets/upload/hostGame";
        $fileData = $this->uploadFiletoFileSystem('file', $uploadDir);
        $fileData["game"] = $_POST["game"];
        $sql = $this->ask_mysqli->insert("hostgame", $fileData);

        if ($this->adminDB[$_SESSION["db_1"]]->query($sql)) {
            echo json_encode(array("toast" => array("success", "Game", " Added Successfully"), "status" => 1, "message" => "Add Successfully.."));
        } else {
            unlink($fileData["path"]);
            echo json_encode(array($fileData, "toast" => array("danger", "Game", " Added Failed " . $this->adminDB[$_SESSION["db_1"]]->error), "status" => 0, "message" => "Insert Failed.."));
        }
    }

    function loadGame() {
        try {
            $request = $_REQUEST;
            $col = array(
                0 => 'id',
                1 => 'game',
                2 => 'name',
                3 => 'extension',
                4 => 'url',
                5 => 'path',
                6 => 'isUser',
                7 => 'onCreate'
            );
            $sql = $this->ask_mysqli->select("hostgame", $_SESSION["db_1"]);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            $totalFilter = $totalData;
            $sql .=$this->ask_mysqli->whereSingle(array("1" => "1"));
            /* Search */
            if (!empty($request['search']['value'])) {
                $sql.=" AND (name Like '%" . $request['search']['value'] . "%'";
                $sql.=" OR  mobileno Like '%" . $request['search']['value'] . "%')";
            }
            /* Order */
            $sql.=$this->ask_mysqli->orderBy($request['order'][0]['dir'], $col[$request['order'][0]['column']]) . $this->ask_mysqli->limitWithOffset($request['start'], $request['length']);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            while ($row = $query->fetch_assoc()) {
                $subdata = array();
                $subdata[] = $row['id'];
                $subdata[] = $row['game'];
                $subdata[] = '<a target="_blank" href="'.$row["url"].'" class="btn btn-success btn-xs"> <i class="fa fa-download"></i></a>';
                $subdata[] = $row['onCreate'];
                $subdata[] = '<button onclick="deleteGame(' . $row["id"] . ',0)" class="btn btn-danger btn-xs"> <i class="fa fa-trash-o"></i></button>';
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

    function deleteGame() {
        $sql = $this->ask_mysqli->select("hostgame", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => $_POST["id"]));
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        if ($row = $result->fetch_assoc()) {
            unlink($row["path"]);
            $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->delete("hostgame") . $this->ask_mysqli->whereSingle(array("id" => $_POST["id"])));
            echo json_encode(array("toast" => array("success", "Game", " Delete Successfully"), "status" => 1, "message" => "Game Delete Successfully.."));
        } else {
            echo json_encode(array("toast" => array("danger", "Game", " Delete Failed..Try again"), "status" => 0, "message" => "Delete Failed..Try again"));
        }
    }

    function blockno() {
        $id=$_POST["id"];
        unset($_POST["action"]);
        $blockno=  json_encode($_POST);
        $sql=$this->ask_mysqli->update(array("blockno"=>$blockno),"admin").$this->ask_mysqli->whereSingle(array("id"=>$id));
        if($this->adminDB[$_SESSION["db_1"]]->query($sql)){
         echo json_encode(array("toast" => array("success", "Game", " Block no set  Successfully"), "status" => 1, "message" => "Block no set Successfully.."));
        } else {
            echo json_encode(array("toast" => array("danger", "Game", " Bloc No set Failed..Try again"), "status" => 0, "message" => "Block no set Try again"));
        }
        
    }
    
    function getBlockno(){
        $resutl =$this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->select("admin",$_SESSION["db_1"]).$this->ask_mysqli->whereSingle(array("id"=>$_POST["id"])));
        $row=$resutl->fetch_assoc();
        echo $row["blockno"];
    }

    function loadTable() {
        try {
            $request = $_REQUEST;
            $col = array(
                0 => 'id',
                1 => 'userid',
                2 => 'passowrd',
                3 => 'name',
                4 => 'mobileno',
                5 => 'balance',
                6 => 'device',
                7 => 'ip',
                8 => 'is_active',
                9 => 'create_on',
                10 => 'isdate'
            );
            $sql = $this->ask_mysqli->select("enduser", $_SESSION["db_1"]);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            $totalFilter = $totalData;
            $sql .=$this->ask_mysqli->whereSingle(array("1" => "1"));
            /* Search */
            if (!empty($request['search']['value'])) {
                $sql.=" AND (name Like '%" . $request['search']['value'] . "%'";
                $sql.=" OR  mobileno Like '%" . $request['search']['value'] . "%')";
            }
            /* Order */
            $sql.=$this->ask_mysqli->orderBy($request['order'][0]['dir'], $col[$request['order'][0]['column']]) . $this->ask_mysqli->limitWithOffset($request['start'], $request['length']);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            while ($row = $query->fetch_assoc()) {
                $subdata = array();
                $subdata[] = $row['id'];
                $subdata[] = $row['userid'];
                $subdata[] = $row['password'];
                $subdata[] = $row['name'];
                $subdata[] = $row['mobileno'];
                $subdata[] = $row['balance'];
                $subdata[] = $row['device'];
                $subdata[] = $row['ip'];
                if ($row["is_active"] === "1") {
                    $subdata[] = "<span class='text-success'>Active</a>";
                } else {
                    $subdata[] = "<span class='text-danger'>In-Active</a>";
                }
                $subdata[] = $row['create_on'];
                $subdata[] = $row['isdate'];
                $active = '<button onclick="deleteFullAccount(' . $row["id"] . ',0)" class="btn btn-danger btn-xs"> <i class="fa fa-trash-o"></i></button>';
                $active.= ' <button onclick="editAccount(' . $row["id"] . ',\'' . $row["name"] . '\',\'' . $row["mobileno"] . '\',\'' . $row["comission"] . '\',\'' . $row["device"] . '\')" data-toggle="modal" data-target="#myModal" class="btn btn-warning btn-xs"> <i class="fa fa-edit"></i> Edit</button>';
                $active.= ' <button onclick="putPoint(' . $row["userid"] . ',\'' . $row["name"] . '\',\'' . $row["balance"] . '\')" data-toggle="modal" data-target="#myModal" class="btn btn-warning btn-xs"> <i class="fa fa-edit"></i>Add Point</button>';
                $active.= ' <button onclick="getPoint(' . $row["userid"] . ',\'' . $row["name"] . '\',\'' . $row["balance"] . '\')" data-toggle="modal" data-target="#myModal" class="btn btn-warning btn-xs"> <i class="fa fa-edit"></i>Remove Point</button>';
                $b = array(1 => "danger", 0 => "success");
                $b2 = array(1 => "Suspend", 0 => "Active");
                $ac = array(0 => 1, 1 => 0);
                $subdata[] = $active . ' <button onclick="suspendAccount(' . $row["id"] . ',' . $ac[$row["is_active"]] . ')" data-toggle="modal" data-target="#myModal" class="btn btn-' . $b[$row['is_active']] . ' btn-xs"> <i class="fa fa-scissors"></i>' . $b2[$row['is_active']] . '</button>';

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

    function loadMessageTable() {
        try {
            $request = $_REQUEST;
            $col = array(
                0 => 'id',
                1 => 'message'
            );
            $sql = $this->ask_mysqli->select("message", $_SESSION["db_1"]);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            $totalFilter = $totalData;
            $sql .=$this->ask_mysqli->whereSingle(array("1" => "1"));
            /* Search */
            if (!empty($request['search']['value'])) {
                $sql.=" AND (name Like '%" . $request['search']['value'] . "%'";
                $sql.=" OR  mobileno Like '%" . $request['search']['value'] . "%')";
            }
            /* Order */
            $sql.=$this->ask_mysqli->orderBy($request['order'][0]['dir'], $col[$request['order'][0]['column']]) . $this->ask_mysqli->limitWithOffset($request['start'], $request['length']);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            while ($row = $query->fetch_assoc()) {
                $subdata = array();
                $subdata[] = $row['id'];
                $subdata[] = $row['message'];
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

    function addUser() {
        $data = $_POST;
        unset($data["id"]);
        unset($data["action"]);
        $data["ip"] = $_SERVER["REMOTE_ADDR"];
        $data["is_active"] = 1;
        $data["create_on"] = date("Y-m-d");
        $this->adminDB[$_SESSION["db_1"]]->autocommit(false);
        $sql = $this->ask_mysqli->insert("enduser", $data);
        $error = array();
        $this->adminDB[$_SESSION["db_1"]]->query($sql) != true ? array_push($error, $this->adminDB[$_SESSION["db_1"]]->error) : true;
        if (empty($error)) {
            $last_id = $this->adminDB[$_SESSION["db_1"]]->insert_id;
            if ($last_id > 25) {
                array_push($error, "You Enter Only 25 id, try update limit...!");
            }
            $userid = date("Y") . date("m") . date("d") + $last_id;
            $sql = $this->ask_mysqli->update(array("userid" => $userid), "enduser") . $this->ask_mysqli->whereSingle(array("id" => $last_id));
            $this->adminDB[$_SESSION["db_1"]]->query($sql) != true ? array_push($error, $this->adminDB[$_SESSION["db_1"]]->error) : true;
            if (empty($error)) {
                $this->adminDB[$_SESSION["db_1"]]->commit();
                echo json_encode(array("toast" => array("success", "User", " Added Successfully"), "status" => 1, "message" => "Insert Successfully.."));
            } else {
                $json_error = json_encode($error);
                $this->adminDB[$_SESSION["db_1"]]->rollback();
                echo json_encode(array("toast" => array("danger", "User", " Added failed {$json_error}"), "status" => 0, "message" => "Insert Failed.. {$json_error}"));
            }
        } else {
            $json_error = json_encode($error);
            $this->adminDB[$_SESSION["db_1"]]->rollback();
            echo json_encode(array("toast" => array("danger", "User", " Added failed {$json_error}"), "status" => 0, "message" => "Insert Failed.. {$json_error}"));
        }
    }

    function deleteUser() {
        $data = $_POST;
        //print_r($data);die;
        $where = $this->ask_mysqli->whereSingle(array("id" => $data["id"]));
        $result = $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->select("enduser", $_SESSION["db_1"]) . $where);
        if ($row = $result->fetch_assoc()) {
            //print_r($row);die;
            $erroe = array();
            $this->adminDB[$_SESSION["db_1"]]->autocommit(false);
            $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->_updateINC(array("balance" => "balance-" . $row["balance"]), "enduser") . $this->ask_mysqli->whereSingle(array("userid" => $row["userid"]))) != 1 ? array_push($erroe, "Erro(001) Unable to Update Balance.. enduser") : true;
            $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->_updateINC(array("balance" => "balance+" . $row["balance"]), "admin") . $this->ask_mysqli->whereSingle(array("id" => 1))) != 1 ? array_push($erroe, "Erro(001) Unable to Update Balance.. user") : true;
            $s = $this->ask_mysqli->insert("transaction", array("userid" => $row["userid"], "debit" => $row["balance"], "remark" => "Admin Get Back Balance from user and Delete Account", "ip" => $_SERVER["REMOTE_ADDR"], "balance" => $this->getData($this->ask_mysqli->select("enduser", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $row["userid"])), "balance")));
            $this->adminDB[$_SESSION["db_1"]]->query($s) != true ? array_push($erroe, "Error on Transcation Table Error Code 02 enduser transaction") : true;
            $s1 = $this->ask_mysqli->insert("transaction", array("userid" => 1, "credit" => $row["balance"], "remark" => "Self Credit form admin to transfer balance from user {$row["userid"]} and delete it account", "ip" => $_SERVER["REMOTE_ADDR"], "balance" => $this->getData($this->ask_mysqli->select("admin", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => 1)), "balance")));
            $this->adminDB[$_SESSION["db_1"]]->query($s1) != true ? array_push($erroe, "Error on Transcation Table Error Code 02 ") : true;
            $sql = $this->ask_mysqli->delete("enduser") . $where;
            $this->adminDB[$_SESSION["db_1"]]->query($sql) != true ? array_push($error, $this->adminDB[$_SESSION["db_1"]]->error) : true;

            if (empty($erroe)) {
                $this->adminDB[$_SESSION["db_1"]]->commit();
                echo json_encode(array("toast" => array("success", "User", " Delete User Success.."), "status" => 1, "message" => "Delete User Success... "));
            } else {
                $this->adminDB[$_SESSION["db_1"]]->rollback();
                $json_error = json_encode($erroe);
                echo json_encode(array("toast" => array("danger", "User", " Delete User  failed {$json_error}"), "status" => 0, "message" => "Delete User  Failed.. {$json_error}"));
            }
        } else {
            $this->adminDB[$_SESSION["db_1"]]->rollback();
            $json_error = json_encode($erroe);
            echo json_encode(array("toast" => array("danger", "User", " Delete User Invalid or failed {$json_error}"), "status" => 0, "message" => "Delete User Invalid or Failed.. {$json_error}"));
        }
    }

    function getData($sql, $col) {
        try {

            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            $row = $result->fetch_assoc();
            return $row[$col];
        } catch (Exception $ex) {
            
        }
    }

    function update() {
        try {
            $data = $_POST;
            unset($data['action']);
            $where = $this->ask_mysqli->whereSingle(array("id" => $data["id"]));
            unset($data[["id"]]);
            $error = array();
            $this->adminDB[$_SESSION["db_1"]]->autocommit(false);
            $sql = $this->ask_mysqli->update($data, "enduser") . $where;
            $this->adminDB[$_SESSION["db_1"]]->query($sql) != true ? array_push($error, $this->adminDB[$_SESSION["db_1"]]->error) : true;
            if (empty($error)) {
                $this->adminDB[$_SESSION["db_1"]]->commit();
                $json_error = json_encode($error);
                echo json_encode(array("toast" => array("success", "User", "Information Update Succesfully.."), "status" => 1, "message" => "User Information Update Successfully.."));
            } else {
                $this->adminDB[$_SESSION["db_1"]]->rollback();
                $json_error = json_encode($error);
                echo json_encode(array("toast" => array("danger", "User", "Information Update Failed... {$json_error}"), "status" => 0, "message" => "User Information Update Failed.. {$json_error}"));
            }
        } catch (Exception $ex) {
            
        }
    }

    function putPoint() {
        try {
            $data = $_POST;
            unset($data["action"]);
            //print_r($data);die;
            $this->adminDB[$_SESSION['db_1']]->autocommit(FALSE);
            $sql = $this->ask_mysqli->select("admin", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => 1));
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            $row = $result->fetch_assoc();
            if ((int) $row["balance"] > (int) $data["point"]) {
                $error = array();
                $sql = $this->ask_mysqli->_updateINC(array("balance" => "balance+" . $data["point"]), "enduser") . $this->ask_mysqli->whereSingle(array("userid" => $data["userid"]));
                $this->adminDB[$_SESSION["db_1"]]->query($sql) != true ? array_push($error, $this->adminDB["db_1"]->error) : true;
                $sql = $this->ask_mysqli->_updateINC(array("balance" => "balance-" . $data["point"]), "admin") . $this->ask_mysqli->whereSingle(array("id" => 1));
                $this->adminDB[$_SESSION["db_1"]]->query($sql) != true ? array_push($error, $this->adminDB["db_1"]->error) : true;
                $sql = $this->ask_mysqli->insert("transaction", array("userid" => $data["userid"], "credit" => $data["point"], "remark" => "Admin Send Balance to user", "ip" => $_SERVER["REMOTE_ADDR"], "balance" => $this->getData($this->ask_mysqli->select("enduser", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $data["userid"])), "balance")));
                $this->adminDB[$_SESSION["db_1"]]->query($sql) != true ? array_push($error, $this->adminDB["db_1"]->error) : true;
                $sql = $this->ask_mysqli->insert("transaction", array("userid" => 1, "debit" => $data["point"], "remark" => "Self Debit form admin to transfer balance", "ip" => $_SERVER["REMOTE_ADDR"], "balance" => $this->getData($this->ask_mysqli->select("admin", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => 1)), "balance")));
                $this->adminDB[$_SESSION["db_1"]]->query($sql) != 1 ? array_push($error, $this->adminDB["db_1"]->error) : true;
                if (empty($error)) {
                    $this->adminDB[$_SESSION["db_1"]]->commit();
                    echo json_encode(array("toast" => array("success", "User", "Information Update Success... "), "status" => 1, "message" => "User Information Update Success.. "));
                } else {
                    $this->adminDB[$_SESSION["db_1"]]->rollback();
                    $json_error = json_encode($error);
                    echo json_encode(array("toast" => array("danger", "User", "Information Update Failed... {$json_error}"), "status" => 0, "message" => "User Information Update Failed.. {$json_error}"));
                }
            } else {

                echo json_encode(array("toast" => array("danger", "User", "Admin Insuficent account point"), "status" => 0, "message" => "Admin Insuficent account point"));
            }
        } catch (Exception $ex) {
            
        }
    }

    function getPoint() {
        try {
            $data = $_POST;
            unset($data["action"]);
            //print_r($data);die;
            $this->adminDB[$_SESSION['db_1']]->autocommit(FALSE);
            $sql = $this->ask_mysqli->select("enduser", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $data["userid"]));
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            $row = $result->fetch_assoc();
            if ((int) $row["balance"] >= (int) $data["point"]) {
                $error = array();
                $sql = $this->ask_mysqli->_updateINC(array("balance" => "balance-" . $data["point"]), "enduser") . $this->ask_mysqli->whereSingle(array("userid" => $data["userid"]));
                $this->adminDB[$_SESSION["db_1"]]->query($sql) != true ? array_push($error, $this->adminDB["db_1"]->error) : true;
                $sql = $this->ask_mysqli->_updateINC(array("balance" => "balance+" . $data["point"]), "admin") . $this->ask_mysqli->whereSingle(array("id" => 1));
                $this->adminDB[$_SESSION["db_1"]]->query($sql) != true ? array_push($error, $this->adminDB["db_1"]->error) : true;
                $sql = $this->ask_mysqli->insert("transaction", array("userid" => $data["userid"], "debit" => $data["point"], "remark" => "Admin get Back Balance From user", "ip" => $_SERVER["REMOTE_ADDR"], "balance" => $this->getData($this->ask_mysqli->select("enduser", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("userid" => $data["userid"])), "balance")));
                $this->adminDB[$_SESSION["db_1"]]->query($sql) != true ? array_push($error, $this->adminDB["db_1"]->error) : true;
                $sql = $this->ask_mysqli->insert("transaction", array("userid" => 1, "credit" => $data["point"], "remark" => "Self Debit form User to Admin transfer balance", "ip" => $_SERVER["REMOTE_ADDR"], "balance" => $this->getData($this->ask_mysqli->select("admin", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => 1)), "balance")));
                $this->adminDB[$_SESSION["db_1"]]->query($sql) != 1 ? array_push($error, $this->adminDB["db_1"]->error) : true;
                if (empty($error)) {
                    $this->adminDB[$_SESSION["db_1"]]->commit();
                    echo json_encode(array("toast" => array("success", "User", "Information Update Success... "), "status" => 1, "message" => "User Information Update Success.. "));
                } else {
                    $this->adminDB[$_SESSION["db_1"]]->rollback();
                    $json_error = json_encode($error);
                    echo json_encode(array("toast" => array("danger", "User", "Information Update Failed... {$json_error}"), "status" => 0, "message" => "User Information Update Failed.. {$json_error}"));
                }
            } else {

                echo json_encode(array("toast" => array("danger", "User", "User Insuficent account point"), "status" => 0, "message" => "User Insuficent account point"));
            }
        } catch (Exception $ex) {
            
        }
    }

    function suspend() {
        try {
            $data = $_POST;
            unset($data["action"]);
            $where = $this->ask_mysqli->whereSingle(array("id" => $data["id"]));
            unset($data["id"]);
            $this->adminDB[$_SESSION["db_1"]]->autocommit(false);
            $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->update($data, "enduser") . $where) != true ? array_push($error, $this->adminDB[$_SESSION["db_1"]]->error) : true;
            if (empty($error)) {
                $this->adminDB[$_SESSION["db_1"]]->commit();
                echo json_encode(array("toast" => array("success", "User", "Information Update Success... "), "status" => 1, "message" => "User Information Update Success.. "));
            } else {
                $this->adminDB[$_SESSION["db_1"]]->rollback();
                $json_error = json_encode($error);
                echo json_encode(array("toast" => array("danger", "User", "Information Update Failed... {$json_error}"), "status" => 0, "message" => "User Information Update Failed.. {$json_error}"));
            }
        } catch (Exception $ex) {
            
        }
    }

    function updateper() {
        try {
            $sql = $this->ask_mysqli->update(array("resultper" => $_POST["resultper"],"min" => $_POST["min"]), "admin") . $this->ask_mysqli->whereSingle(array("id" => $_POST["id"]));
            if ($this->adminDB[$_SESSION["db_1"]]->query($sql)) {
                echo json_encode(array("toast" => array("success", "Admin", "Information Update Success... "), "status" => 1, "message" => "User Information Update Success.. "));
            } else {
                echo json_encode(array("toast" => array("danger", "Admin", "Information Update Failed... "), "status" => 0, "message" => "User Information Update Failed.. {$json_error}"));
            }
        } catch (Exception $ex) {
            
        }
    }

    function adminBalance() {

        $data = array();
        $sql = $this->ask_mysqli->select("admin", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("id" => 1));
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        $row = $result->fetch_assoc();
        $data["3"] = $row["balance"];
        $data["4"] = $row["resultper"];
        $data["5"] = $row["min"];

        $sql = $this->ask_mysqli->selectCount("enduser", "id");
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        $row = $result->fetch_assoc();
        $data["1"] = $row["count(id)"];
        $data["2"] = 1;
        $sql = $this->ask_mysqli->selectCount("gameseries", "id");
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        $row = $result->fetch_assoc();
        $data["0"] = $row["count(id)"];
        echo json_encode($data);
    }

    function message() {
        unset($_POST["action"]);
        $this->adminDB[$_SESSION["db_1"]]->autocommit(false);
        $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->update($_POST, "message") . $this->ask_mysqli->whereSingle(array("id" => 1))) != true ? array_push($error, $this->adminDB[$_SESSION["db_1"]]->error) : true;
        if (empty($error)) {
            $this->adminDB[$_SESSION["db_1"]]->commit();
            echo json_encode(array("toast" => array("success", "Messaage", "User Message Information Update Success... "), "status" => 1, "message" => "User Message Information Update Success.. "));
        } else {
            $this->adminDB[$_SESSION["db_1"]]->rollback();
            $json_error = json_encode($error);
            echo json_encode(array("toast" => array("danger", "Message", "User Message Information Update Failed... {$json_error}"), "status" => 0, "message" => "User Message Information Update Failed.. {$json_error}"));
        }
    }

    function allUser() {
        try {
            $sql = $this->ask_mysqli->select("enduser", $_SESSION["db_1"]);
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            $array = array();
            while ($row = $result->fetch_assoc()) {
                unset($row["password"]);
                array_push($array, $row);
            }
            echo json_encode($array);
        } catch (Exception $ex) {
            
        }
    }

}
