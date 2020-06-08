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

class lastTransaction extends CAaskController {

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
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $sql=$this->ask_mysqli->select("usertranscation",$_SESSION["db_1"]).$this->ask_mysqli->whereSingle(array("userid"=>$request["userid"])).$this->ask_mysqli->orderBy("DESC","id");
        $result=$this->adminDB[$_SESSION["db_1"]]->query($sql);
        if($row=$result->fetch_assoc())
        {
            echo json_encode(array("last"=>$row["trno"],"lastamt"=>$row["netamt"]));
        }else{
            echo json_encode(array("last"=>"null","lastamt"=>"null"));
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

}
