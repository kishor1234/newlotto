<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of _configuration
 *
 * @author asksoft
 */
error_reporting(0);

//require 'lib/ask_mysqli.php';

class _configuration {

    //put your code here
    //Database Configuration
    public $controllerConfig = array();
    public $fileStack = array();
    public $libConfig = array();
    public $_configurationClass = array(
        "ask_mysqli", // ask_mysqli for mysqli
        "ask_mailer"//ask_mailer for Mail
    );
    public $_mysqliConfiguration = array(
        "host" => "localhost",
        "port" => "3306",
        "username" => "root",
        "password" => "aaskSoft@123",
        "database" => "newloto",
        "socket" => "",
        "single" => true, //if you user multiple database then use singel=>false and pass master db configuration
        "master_table" => "master_db"
    );
    private static $instance;
    public $_mailConfiguration = array(
        "email" => "test@test.com",
        "password" => "tEx{wDSaldflkZUTs0",
        "host" => "mail.test.com",
        "protocol" => "smtp",
        "port" => "587"
    );
//    public $_mailConfiguration = array(
//        "email" => "support@poolcampus.co.in",
//        "password" => "yp1jW7oStb",
//        "host" => "mail.poolcampus.co.in",
//        "protocol" => "smtp",
//        "port" => "587"
//    );
    public $_fast2sms = array(
        "api-key" => "YOURKEY",
        "senderid" => "Send id"
    );

    public function __construct() {
        self::$instance = & $this;
        //$this->create();
        //$this->importClasses();
        return;
    }

    function importClasses() {
        foreach ($this->_configurationClass as $key => $val) {
            if (array_key_exists($val, $this->_configurationClass)) {
                $strFullDetail = $this->removePhpExtenstion($this->controllerAppConfig[$val]);
                require_once $strFullDetail["fullPath"];
            }
        }
    }

    function create() {
        $libConfig = array();

        if (true) {
            $libConfig = $this->listFolderFiles(getcwd() . "/AaskAPP/system"); //array fo view files
            $my_file = 'AaskAPP/systemFile.php';
            $handle = fopen($my_file, 'w') or die('Cannot open file:  ' . $my_file);
            $data = '<?php ';
            $data .= "\$libConfig=array(";
            $i = 0;
            foreach ($libConfig as $key => $val) {
                if ($i < count($libConfig) - 1) {
                    $data .= "'" . $key . "'" . "=>" . "'" . $val . "',";
                } else {
                    $data .= "'" . $key . "'" . "=>" . "'" . $val . "'";
                }
                $i++;
            }
            $data .= "); ";

            fwrite($handle, $data);
            include getcwd() . "/AaskAPP/systemFile.php";
            $this->libConfig = $libConfig; //array fo view files
        } else {
            include getcwd() . "/AaskAPP/system.php";

            $this->libConfig = $libConfig; //array fo view files
        }

        return;
    }

    function listFolderFiles($dir) {

        $ffs = scandir($dir);
        foreach ($ffs as $ff) {
            if ($ff != '.' && $ff != '..') {
                if (is_dir($dir . '/' . $ff)) {
                    array_push($this->fileStack, $ff);
                    $this->listFolderFiles($dir . '/' . $ff);
                } else {
                    $ext = explode(".", $ff);
                    if (isset($ext[1])) {
                        if (strcmp($ext[1], "php") == 0) {
                            $filePath = "";
                            foreach ($this->fileStack as $stackDir) {
                                $filePath.=$stackDir . "/";
                            }
                            $this->controllerConfig[$ext[0]] = $filePath . $ff;
                        }
                    }
                }
            }
        }array_pop($this->fileStack);
        return $this->controllerConfig;
    }

    public static function &get_instance() {
        return self::$instance;
    }

}
