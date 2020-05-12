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

class logout extends CAaskController {

    //put your code here
    public function __construct() {
        parent::__construct();
        session_destroy();
    }

    public function create() {
        parent::create();
        redirect(ASETS . "?r=" . $this->encript->encdata("main"));
        return;
    }

    public function initialize() {
        parent::initialize();

        return;
    }

    public function execute() {
        parent::execute();
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

    function timeDifference($date1, $date2) {
        return (strtotime($date2) - strtotime($date1)) / 60;
    }

}
