<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//require_once getcwd()."/poolApp/CpoolControl.class.php";
require_once getcwd() . '/AaskAPP/CAaskController.php';

class Crout extends CAaskController {

    public function __construct() {
        parent::__construct();
    }

    public function create() {
        parent::create();
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
        return;
    }

    public function distory() {
        return;
    }

    public function index() {
        $this->create();
       
        if (isset($_REQUEST['r'])) {
            $moduleName = $this->encript->decdata($_REQUEST["r"]);
            //die($moduleName);
            if (array_key_exists($moduleName, $this->controllerAppConfig) == FALSE) {
                $strFullDetail = $this->removePhpExtenstion($this->controllerAppConfig["Cpage_404"]);
            } else {
                $strFullDetail = $this->removePhpExtenstion($this->controllerAppConfig[$moduleName]);
            }
        } else {
            
            $strFullDetail = $this->removePhpExtenstion($this->controllerAppConfig["main"]);
            
        }
        require_once $strFullDetail["fullPath"];
        $controlObject = new $strFullDetail["class"];
        $controlObject->create();
        $controlObject->initialize();
        $controlObject->execute();
        $controlObject->finalize();
        $controlObject->reader();
        $controlObject->distory();
    }

    public function getPostArray() {
        $array = array();
        if ($_POST) {
            foreach ($_POST as $key => $value) {
                $array[$key] = $value;
            }
        }

        return $array;
    }

    public function removePhpExtenstion($filePath) {
        $strArrayfullDetail;
        $strControlfullPath = dirname(__FILE__) . "/" . $filePath;
        $strArray = explode("/", $strControlfullPath);
        $strClassName = explode(".", $strArray[count($strArray) - 1]);
        
        if (false != file_exists($strControlfullPath)) {

            if (class_exists($strControlfullPath, FALSE) == FALSE) {
                //require_once($strControlfullPath . "");

                $strArrayfullDetail["fullPath"] = $strControlfullPath;
                $strArrayfullDetail["class"] = $strClassName[0];
            }
        } else {
            die("file not found");
        }
        return $strArrayfullDetail;
    }


}
