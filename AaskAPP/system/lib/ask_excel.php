<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ask_sms
 *
 * @author asksoft
 */
require_once getcwd() . '/AaskAPP/system/_configuration.php';
require('PHPExcel-1.8.1/Classes/PHPExcel/IOFactory.php');
error_reporting(0);

class ask_excel extends _configuration {

    public function __construct() {
        parent::__construct();
        return;
    }

    public function importExcel($_FILES) {
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $highestRow = $worksheet->getHighestRow();
            for ($row = 2; $row <= $highestRow; $row++) {
                echo "<br>";
                print_r($row);
            }
        }
    }

    //put your code here
}
