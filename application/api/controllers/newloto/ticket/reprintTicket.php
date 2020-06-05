<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of reprintTicket
 *
 * @author asksoft
 */
defined('BASEPATH') OR exit('No direct script access allowed');

//require_once getcwd() . '/' . APPLICATION . "/controllers/Crout.php";
require_once controller;

//header('Content-Type: application/json');

class reprintTicket extends CAaskController {

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
        $sql = $this->ask_mysqli->select("subentry", $_SESSION["db_1"]) . $this->ask_mysqli->whereSingle(array("game" => $_REQUEST["game"]));
        $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
        $content = "";
        while ($row = $result->fetch_assoc()) {
            ob_start();
            $this->isLoadView(array("header" => "webheader", "main" => "ticketPrint", "footer" => "webfooter", "error" => "page_404"), false, array("row" => $row));
            $content .= ob_get_contents();
            ob_end_clean();
            //echo $content;
        }
        echo json_encode(array("ticket" => $content));
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

}
