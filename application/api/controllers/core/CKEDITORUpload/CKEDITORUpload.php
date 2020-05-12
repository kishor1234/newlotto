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

class CKEDITORUpload extends CAaskController {

//put your code here

    public function __construct() {
        parent::__construct();
    }

    public function create() {
        parent::create();
//if(isset($_SESSION["loginEmail"])){redirect(ASETS."?r=".$this->encript->encdata("C_Dashboard"));}
        return;
    }

    public function initialize() {
        parent::initialize();

        return;
    }

    public function execute() {
        parent::execute();

        $allowed_extension = array("jpg", "gif", "png");
        if (in_array(end($_FILES['upload']['name']), $allowed_extension)) {
            $uploadDir = "assets/upload/CKEDITOR";
            chmod('CKEDITOR', 0777);
            $tmpFile = $_FILES['upload']['tmp_name'];
            $name = time() . '-' . $_FILES['upload']['name'];
            $filename = $uploadDir . '/' . $name;
            $path = getcwd() . "/" . $filename;
            move_uploaded_file($tmpFile, $path);
            $function_number = $_GET['CKEditorFuncNum'];
            $url = $filename;
            $message = '';
            echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($function_number, '$url', '$message');</script>";
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
