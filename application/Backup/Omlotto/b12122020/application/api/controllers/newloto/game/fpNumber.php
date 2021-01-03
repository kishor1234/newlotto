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

class fpNumber extends CAaskController {

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
        $no = $request["num"];
        $mega = array(array('1'=>'10', '2'=>'15', '3'=>'60', '4'=>'65', '5'=>'1', '6'=>'6', '7'=>'51', '8'=>'56'),
            array('1'=>'12', '2'=>'17', '3'=>'62', '4'=>'67', '5'=>'21', '6'=>'26', '7'=>'71', '8'=>'76'),
            array('1'=>'13', '2'=>'18', '3'=>'63', '4'=>'68', '5'=>'31', '6'=>'36', '7'=>'81', '8'=>'86'),
            array('1'=>'14', '2'=>'19', '3'=>'64', '4'=>'69', '5'=>'41', '6'=>'46', '7'=>'91', '8'=>'96'),
            array('1'=>'20', '2'=>'25', '3'=>'70', '4'=>'75', '5'=>'2', '6'=>'7', '7'=>'52', '8'=>'57'),
            array('1'=>'23', '2'=>'28', '3'=>'73', '4'=>'78', '5'=>'32', '6'=>'37', '7'=>'82', '8'=>'87'),
            array('1'=>'24', '2'=>'29', '3'=>'74', '4'=>'79', '5'=>'42', '6'=>'47', '7'=>'92', '8'=>'97'),
            array('1'=>'30', '2'=>'35', '3'=>'80', '4'=>'85', '5'=>'3', '6'=>'8', '7'=>'53', '8'=>'58'),
            array('1'=>'34', '2'=>'39', '3'=>'84', '4'=>'89', '5'=>'43', '6'=>'48', '7'=>'93', '8'=>'98'),
            array('1'=>'40', '2'=>'45', '3'=>'90', '4'=>'95', '5'=>'4', '6'=>'9', '7'=>'54', '8'=>'59'),
            array('1'=>'11', '2'=>'66', '3'=>'16', '4'=>'61'),
            array('1'=>'22', '2'=>'27', '3'=>'72', '4'=>'77'),
            array('1'=>'33', '2'=>'38', '3'=>'83', '4'=>'88'),
            array('1'=>'44', '2'=>'49', '3'=>'94', '4'=>'99'),
            array('1'=>'55', '2'=>'50', '3'=>'0', '4'=>'5'));
        $error = array();

        foreach ($mega as $k => $maval) {
            if (in_array($no, $maval)) {
                $str = json_encode($maval);
                $str = str_replace("[", "{", $str);
                $str = str_replace("]", "}", $str);
                echo $str;
                break;
            }
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
