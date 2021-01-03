<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CTicketReport
 *
 * @author asksoft
 */
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

//header('Content-Type: application/json');
class transaction extends CAaskController {

    //put your code here
    public $data = array();

    public function __construct() {
        parent::__construct();
    }

    public function create() {
        parent::create();

        return;
    }

    public function initialize() {
        parent::initialize();

        return;
    }

    public function execute() {
        parent::execute();
        //$postdata = file_get_contents("php://input");
        $request1 = implode(" ", $_POST);
        $request2 = str_replace(" ", "", $request1);
        $request3 = str_replace("1ArrayArray010Array", "", $request2);
        $request = $_REQUEST; //json_decode($request3, true);
//        $_REQUEST["sql"] = $this->ask_mysqli->select("entry", $_SESSION["db_1"]).$this->ask_mysqli->whereBetweenDatesID("enterydate", $request["dateform"], $request["dateto"], "own", $request["own"]);
//       echo json_encode($_REQUEST);die;
        switch ($request["action"]) {
            case "searchTicket":
                //$_REQUEST=$request;
                $this->searchTicket($request);
                break;
            default :
                echo json_encode(array("status" => "0", "message" => "Invalid Request", "request" => $request));
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

//custome code start below
    function searchTicket($request) {
//        try {
//            //$sql = $this->ask_mysqli->select("entry", $_SESSION["db_1"]) . $this->ask_mysqli->whereBetweenDatesID("enterydate", $request["dateform"], $request["dateto"], "own", $request["own"]);
//        } catch (Exception $ex) {
//            
//        }
        try {
            //$request = $_REQUEST;
            $col = array(
                0 => 'id',
                1 => 'userid',
                2 => 'debit',
                3 => 'credit',
                4 => 'remark',
                5 => 'balance',
                6 => 'ip',
                7 => 'create_on',
                8 => 'botStatus'
            );
            $sql = $this->ask_mysqli->select("transaction", $_SESSION["db_1"]);
            $sql .= $this->ask_mysqli->whereBetweenDatesID("create_on", $request["dateform"] . " 00:00:00", $request["dateto"] . " 23:59:59", "userid", $request["own"]);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            $totalFilter = $totalData;
            /* Search */
            if (!empty($request['search']['value'])) {
                $sql .= " AND (name Like '%" . $request['search']['value'] . "%'";
                $sql .= " OR  mobileno Like '%" . $request['search']['value'] . "%')";
            }
            /* Order */
            $request = $_REQUEST;
            //$sql .= $this->ask_mysqli->orderBy($request['order'][0]['dir'], $col[$request['order'][0]['column']]) . $this->ask_mysqli->limitWithOffset($request['start'], $request['length']);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            //echo $sql;
            $totalData = $query->num_rows;
            $i=0;
            while ($row = $query->fetch_assoc()) {
                switch ($row['remark']) {
                    case "Admin get Back Balance From user":
                        $data[] = $this->setData($row);$i++;
                        break;
                    case "Admin Send Balance to user":
                        $data[] = $this->setData($row);$i++;
                        break;
                    default :
                        //$data[] = $this->setData($row);
                        break;
                }
            }
            $json_data = array(
                "draw" => intval($request['draw']),
                "recordsTotal" => intval($i),
                "recordsFiltered" => intval($i),
                "data" => $data,
            );
            //print_r($json_data);die;
            echo json_encode($json_data);
        } catch (Exception $ex) {
            error_log($ex, 3, "error.log");
        }
    }

    function setData($row) {
        $subdata = array();
        $subdata[] = $row['id'];
        $subdata[] = $row['userid'];
        $subdata[] = $row['create_on'];
        $subdata[] = $row['remark'];
        if (!empty($row["credit"])) {
            $subdata[] = "<span class='text-success'>+ {$row['credit']}</span>";
        } else {
            $subdata[] = "<span class='text-danger'>- {$row['debit']}</span>";
        }
        $subdata[] = "<span class='text-default'>{$row['balance']}</span>";

        return $subdata;
    }

}
