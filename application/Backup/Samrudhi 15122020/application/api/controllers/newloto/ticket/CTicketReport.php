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
class CTicketReport extends CAaskController {

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
                1 => 'game',
                2 => 'own',
                3 => 'amount',
                4 => 'enertydate',
                5 => 'totalpoint',
                6 => 'winstatus',
                7 => 'claimstatus',
                8 => 'botStatus',
                9 => 'isDate',
                10 => 'gametime',
                11 => 'gameendtime',
                12 => 'gametimeid',
                13 => 'ip'
            );
            $sql = $this->ask_mysqli->select("entry", $_SESSION["db_1"]);
            $sql .=$this->ask_mysqli->whereBetweenDatesID("enterydate", $request["dateform"], $request["dateto"], "own", $request["own"]);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);
            $totalData = $query->num_rows;
            $totalFilter = $totalData;
            /* Search */
            if (!empty($request['search']['value'])) {
                $sql.=" AND (name Like '%" . $request['search']['value'] . "%'";
                $sql.=" OR  mobileno Like '%" . $request['search']['value'] . "%')";
            }
            /* Order */
            $request = $_REQUEST;
            $sql.=$this->ask_mysqli->orderBy($request['order'][0]['dir'], $col[$request['order'][0]['column']]) . $this->ask_mysqli->limitWithOffset($request['start'], $request['length']);
            $query = $this->executeQuery($_SESSION["db_1"], $sql);

            $totalData = $query->num_rows;
            while ($row = $query->fetch_assoc()) {
                $subdata = array();
                $subdata[] = $row['id'];
                $subdata[] = "<span class='text-danger'>{$row['amount']}</span>";
                $subdata[] = $row['totalpoint'];
                $subdata[] = $row['comission'];
                $subdata[] = "<span class='text-danger'>{$row['comission']}</span>";
                $subdata[] = "<span class='text-danger'>90</span>";
                if ($row["isStatus"]) {
                    $subdata[] = "<i class='fa fa-check-circle text-success'></i>";
                } else {
                    $subdata[] = "<i class='fa fa-times-circle text-danger'></i>";
                }
                //$subdata[] = $row['isStatus'];
                if ($row["claimstatus"]) {
                    $subdata[] = "<i class='fa fa-check-circle text-success'></i>";
                } else {
                    $subdata[] = "<i class='fa fa-times-circle text-danger'></i>";
                }
                // $subdata[] = $row['claimstatus'];
                $subdata[] = $row['gameendtime'];
                $subdata[] = $row['isDate'];
                $subdata[] = 1;
                $subdata[] = "<a href='javascript:void(0)' onclick=\"return loadTicket('{$row["game"]}')\" data-toggle='modal' data-target='#myModal' title='View Ticket'><i class='fa fa-ticket text-danger'></i></a>";

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
