<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of getResult
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
class getResult extends CAaskController {

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
        
        $data = array();
        $result = $this->adminDB[$_SESSION["db_1"]]->query($this->ask_mysqli->select("winnumber", $_SESSION["db_1"]).$this->ask_mysqli->where($_POST,"AND")).$this->ask_mysqli->orderBy("ASC", "gameid");
        
        while ($row = $result->fetch_assoc()) {
            
            array_push($data, $row);
        }
        echo json_encode($data);

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
