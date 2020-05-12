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

class CStudentExprience extends CAaskController {

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
                default :
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

    function loadTable() {
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
            $sql = $this->ask_mysqli->select("college", $_SESSION["db_1"]);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            $totalFilter = $totalData;
            $sql .=$this->ask_mysqli->whereSingle(array("1" => "1"));
            /* Search */
            if (!empty($request['search']['value'])) {
                $sql.=" AND (college Like '%" . $request['search']['value'] . "%'";
                $sql.=" OR address Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR state Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR dist Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR city Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR pin Like '%" . $request['search']['value'] . "%' ";
                $sql.=" OR uni Like '%" . $request['search']['value'] . "%' ";
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
                $subdata[] = $row['college'];
                $subdata[] = $row['address'] . " Dist: " . $row['dist'] . ", Tal: " . $row['tal'] . "<br>" . $row['state'] . "(" . $row['pin'] . ")";
                $subdata[] = $row['uni'];
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

}
