<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CAaskController
 *
 * @author asksoft
 */
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

error_reporting(E_ALL);

require_once getcwd() . "/AaskAPP/CStringEncDec.php";
//require('phpmailer/class.phpmailer.php');

require_once getcwd() . "/AaskAPP/system/lib/ask_mysqli.php";
require_once getcwd() . "/AaskAPP/system/lib/phpmailer/ask_mailer.php";
require_once getcwd() . "/AaskAPP/system/lib/ask_sms.php";
//require_once getcwd() . '/vendor/phpoffice/PhpSpreadsheet/src/PhpSpreadsheet/IOFactory.php';
define("MSG_Error", "error");

class CAaskControllerdd extends CI_Controller {

    public $controllerConfig;
    public $viewConfig;
    public $fileStack;
    public $controllerAppConfig;
    public $encript;
    public $adminDB;
    public $ask_mysqli;
    public $ask_sms;
    public $mailObject;
    public $excel;

    //public $mongoObject;
    //put your code here

    public function __construct() {
        parent::__construct();
        $this->encript = new CStringEncDec();
        $this->controllerxAppConfig = array();
        $this->controllerConfig = array();
        $this->fileStack = array();
        $this->viewConfig = array();
        $this->requestArray = array();
        $this->config = new _configuration();
        $this->ask_mysqli = new ask_mysqli();
        $this->adminDB = $this->ask_mysqli->_dbConnection();
        $this->mailObject = new ask_mailer(); //Mailer Object to send Mail
        $this->ask_sms = new ask_sms();
        $this->cors();

        //$this->mongoObject= new CMongoDB();
        return;
        //$this->create();
    }

    function removeArray() {
        foreach ($this->controllerConfig as $a) {
            array_pop($this->controllerConfig);
        }
        foreach ($this->fileStack as $a) {
            array_pop($this->fileStack);
        }
    }

    /* aasksoft life cycle */

    public function create() {
        $viewConfig = array();
        $controllerAppConfig = array();
        if (true) {
            $viewConfig = $this->listFolderFiles(getcwd() . "/" . APPLICATION . "/views"); //array fo view files
            $controllerAppConfig = $this->listFolderFiles(getcwd() . "/" . APPLICATION . "/controllers/"); //array of controllers
            $my_file = 'AaskAPP/' . SUB . '.php';
            $handle = fopen($my_file, 'w') or die('Cannot open file:  ' . $my_file);
            $data = '<?php ';
            $data .= "\$viewConfig=array(";
            $i = 0;
            foreach ($viewConfig as $key => $val) {
                if ($i < count($viewConfig) - 1) {
                    $data .= "'" . $key . "'" . "=>" . "'" . $val . "',";
                } else {
                    $data .= "'" . $key . "'" . "=>" . "'" . $val . "'";
                }
                $i++;
            }
            $data .= "); ";
            $data .= "\$controllerAppConfig=array(";
            $i = 0;
            foreach ($controllerAppConfig as $key => $val) {
                if ($i < count($controllerAppConfig) - 1) {
                    $data .= "'" . $key . "'" . "=>" . "'" . $val . "',";
                } else {
                    $data .= "'" . $key . "'" . "=>" . "'" . $val . "'";
                }
                $i++;
            }
            $data .= ");  ";
            fwrite($handle, $data);
            include getcwd() . "/AaskAPP/" . SUB . ".php";
            $this->viewConfig = $viewConfig; //array fo view files
            $this->controllerAppConfig = $controllerAppConfig; //array of controllers
        } else {
            include getcwd() . "/AaskAPP/" . SUB . ".php";

            $this->viewConfig = $viewConfig; //array fo view files
            $this->controllerAppConfig = $controllerAppConfig; //array of controllers
        }

        return;
    }

    public function initialize() {
        return;
    }

    public function execute() {

        return;
    }

    public function finalize() {

        return;
    }

    public function reader() {
        return;
    }

    public function distory() {
        $this->removeArray();
        unset($this->adminDB);
        unset($this->encript);
        return;
    }

    /* end aasksoft life cycle */

    function executeQuery($db, $sql) {
        if ($this->adminDB == 1) {
            throw new Exception("Unable to connect database..!");
        } else {
            return $this->adminDB[$db]->query($sql);
        }
    }

    public function isLoadView($viewName, $flag, $data) {
        $data["obj"] = $this->encript;
        $data["main"] = $this;
        if ($flag == true) {
            $this->load->view($this->viewConfig[$viewName["header"]], $data);
            if (array_key_exists($viewName["main"], $this->viewConfig)) {
                $this->load->view($this->viewConfig[$viewName["main"]], $data);
            } else {
                $this->load->view($this->viewConfig[$viewName["error"]], $data);
            }
            $this->load->view($this->viewConfig[$viewName["footer"]], $data);
        } else {

            if (array_key_exists($viewName["main"], $this->viewConfig)) {
                $this->load->view($this->viewConfig[$viewName["main"]], $data);
            } else {
                $this->load->view($this->viewConfig[$viewName["error"]], $data);
            }
        }
    }

    function listFolderFiles($dir) {
        $ffs = scandir($dir);
        foreach ($ffs as $ff) {//$tempDir = $ff;
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

    public function filterPost($variable_name) {
        return filter_input(INPUT_POST, $variable_name);
    }

    public function filterGet($variable_name) {
        return filter_input(INPUT_GET, $variable_name);
    }

    public function filterRequest($variable_name) {
        return filter_input(INPUT_REQUEST, $variable_name);
    }

    public function getRandomPassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789!@#$%^&*";

        $count = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $count);

            $pass[$i] = $alphabet[$n];
        }

        return implode($pass);
    }

    function isValidMobile($mobile) {
        if (!empty($mobile)) { // phone number is not empty
            if (preg_match('/^\d{10}$/', $mobile)) { // phone number is valid
                return true;
                // your other code here
            } else { // phone number is not valid
                return false;
            }
        } else { // phone number is empty
            return false;
        }
    }

    function isPasswordValid($password) {
        $passwordErr = "";
        if (!empty($password)) {

            if (strlen($password) <= '8') {
                $passwordErr = "Your Password Must Contain At Least 8 Characters!";
            } elseif (!preg_match("#[0-9]+#", $password)) {
                $passwordErr = "Your Password Must Contain At Least 1 Number!";
            } elseif (!preg_match("#[A-Z]+#", $password)) {
                $passwordErr = "Your Password Must Contain At Least 1 Capital Letter!";
            } elseif (!preg_match("#[a-z]+#", $password)) {
                $passwordErr = "Your Password Must Contain At Least 1 Lowercase Letter!";
            }
            return $passwordErr;
        }
    }

    public function dayCount($from, $to) {
        $first_date = strtotime($from);
        $second_date = strtotime($to);
        $offset = $second_date - $first_date;
        return floor($offset / 60 / 60 / 24);
    }

    public function session_set($data) {
        foreach ($data as $key => $value) {
            $_SESSION[$key] = $value;
        }
    }

    public function session_get($key) {
        return $_SESSION[$key];
    }

    public function session_destrory() {
        session_destroy();
    }

    public function printMessage($msg, $type) {

        $mssg = '<div class="alert alert-dismissible alert-' . $type . '">';
        $mssg.='<button type="button" class="close" data-dismiss="alert">&times;</button>';
        $mssg.=$msg;
        $mssg.='</div>';
        return $mssg;
    }

    public function getIndianCurrency($number) {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(0 => '', 1 => 'one', 2 => 'two',
            3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
            7 => 'seven', 8 => 'eight', 9 => 'nine',
            10 => 'ten', 11 => 'eleven', 12 => 'twelve',
            13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
            16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
            19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
            40 => 'forty', 50 => 'fifty', 60 => 'sixty',
            70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_length) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
            } else
                $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        $paise = ($decimal) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
        return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
    }

    public function getAge($dob) {
        $date1 = new DateTime($dob);
        $date2 = new DateTime(date("Y-m-d"));
        $diff = $date1->diff($date2);

        return $diff->y . " Y, " . $diff->m . "M, " . $diff->d . "D";
    }

    public function getAgeinMonth($dob) {
        $date1 = new DateTime($dob);
        $date2 = new DateTime(date("Y-m-d"));
        $diff = $date1->diff($date2);
        $month = (((int) $diff->y) * 12) + $diff->m;
        return $month . "." . $diff->d;
    }

    public function getDaysinMonth($i, $year) {
        $number = 0;
        switch ($i) {
            case 1:
                $number = 31;
                break;
            case 2:
                if ($year % 4 == 0) {
                    $number = 29;
                } else {
                    $number = 28;
                }
                break;
            case 3:
                $number = 31;
                break;
            case 4:
                $number = 30;
                break;
            case 5:
                $number = 31;
                break;
            case 6:
                $number = 30;
                break;
            case 7:
                $number = 31;
                break;
            case 8:
                $number = 31;
                break;
            case 9:
                $number = 30;
                break;
            case 10:
                $number = 31;
                break;
            case 11:
                $number = 30;
                break;
            case 12:
                $number = 31;
                break;
            default :
                break;
        }
        return $number;
    }

    public function cors() {

        // Allow from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
            // you want to allow, and if so:
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }

        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

            exit(0);
        }

        //echo "You have CORS!";
    }

    public function getBrowser() {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version = "";

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Next get the name of the useragent yes seperately and for good reason
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        } elseif (preg_match('/OPR/i', $u_agent)) {
            $bname = 'Opera';
            $ub = "Opera";
        } elseif (preg_match('/Chrome/i', $u_agent) && !preg_match('/Edge/i', $u_agent)) {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $u_agent) && !preg_match('/Edge/i', $u_agent)) {
            $bname = 'Apple Safari';
            $ub = "Safari";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $bname = 'Netscape';
            $ub = "Netscape";
        } elseif (preg_match('/Edge/i', $u_agent)) {
            $bname = 'Edge';
            $ub = "Edge";
        } elseif (preg_match('/Trident/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        }

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
                ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }
        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                $version = $matches['version'][0];
            } else {
                $version = $matches['version'][1];
            }
        } else {
            $version = $matches['version'][0];
        }

        // check if we have a number
        if ($version == null || $version == "") {
            $version = "?";
        }

        return array(
            'userAgent' => $u_agent,
            'name' => $bname,
            'version' => $version,
            'platform' => $platform,
            'pattern' => $pattern
        );
    }

//excel programing
//    public function loadExcel($excel, $inputFileName) {
//        try {
//            $excel->log('Loading file ' . pathinfo($inputFileName, PATHINFO_BASENAME) . ' using IOFactory to identify the format');
//            $spreadsheet = IOFactory::load($inputFileName);
//            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
//            echo "data</br>";
//            var_dump($sheetData);
//        } catch (Exception $ex) {
//            
//        }
//    }
//end excel
    public function getExcelFileObject($file) {
        //$helper = new Sample();
        //$helper->log('Loading file ' . pathinfo($file, PATHINFO_BASENAME) . ' using IOFactory to identify the format');
        return IOFactory::load($file);
    }

    //end hrer
//Mail Configuration 

    /* public function createMongoDB() {
      $config = array(
      'username' => 'kishor',
      'password' => 'kishor',
      'dbname' => 'photo',
      'connection_string' => sprintf('mongodb://%s:%d/%s', '127.0.0.1', '27017', 'admin')
      );
      try {
      if (!class_exists('Mongo')) {
      echo ("The MongoDB PECL extension has not been installed or enabled");
      return false;
      }

      $connection = new \MongoClient($config['connection_string'], array('username' => $config['username'], 'password' => $config['password']));
      return $this->mongoObject = $connection->selectDB($config['dbname']);
      } catch (Exception $e) {
      return false;
      }
      } */
    public function writeExample() {
        phpinfo();
        die;
        $spreadsheet = new Spreadsheet();
        $helper = new Sample();
        $spreadsheet->getProperties()
                ->setCreator('PHPOffice')
                ->setLastModifiedBy('PHPOffice')
                ->setTitle('PhpSpreadsheet Test Document')
                ->setSubject('PhpSpreadsheet Test Document')
                ->setDescription('Test document for PhpSpreadsheet, generated using PHP classes.')
                ->setKeywords('Office PhpSpreadsheet php')
                ->setCategory('Test result file');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
        $writer->save("05featuredemo.xlsx");
    }

    public function jsonRespon($url, $data) {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => 'Codular Sample cURL Request',
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $data
        ]);
        $resp = curl_exec($curl);
        curl_close($curl);
        return $resp;
    }

public function postJsonRespon($url, $data) {
        $data_string = json_encode($data);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        $resp = curl_exec($curl);
        curl_close($curl);
        return $resp;
    }
    //upload any file to filsystem table usind funtion uploadFiletoFileSystem
    //with two parameter $image is post or request file parameter name
    //and $uploadDir is that directory path to save your file  ex.$uploadDir = "assets/upload/profile";
    function uploadFiletoFileSystem($image, $uploadDir) {
        if (isset($_FILES[$image]) && $_FILES[$image]["error"] == UPLOAD_ERR_OK) {
            $tmpFile = $_FILES[$image]["tmp_name"];
            $name = time() . '-' . $_FILES[$image]['name'];
            $filename = $uploadDir . '/' . $name;
            $path = getcwd() . "/" . $filename;
            move_uploaded_file($tmpFile, $path);
            return array(
                "name" => $name,
                "extension" => $_FILES[$image]['type'],
                "url" => $filename,
                "path" => $path,
                "isUsed" => 1
            );
        }
    }

    function randomPassword() {
        $alphabet = '!@#$%^&*(){}abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function getData($sql, $col) {
        try {
            $result = $this->adminDB[$_SESSION["db_1"]]->query($sql);
            $row = $result->fetch_assoc();
            return $row[$col];
        } catch (Exception $ex) {
            
        }
    }

}
