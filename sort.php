<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$age = array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43");

function Ascending($a, $b) {   
    if ($a == $b) {        
        return 0;
    }   
        return ($a < $b) ? -1 : 1; 
}  

function Descending($a, $b) {   
    if ($a == $b) {        
        return 0;
    }   
        return ($a > $b) ? -1 : 1; 
}  


echo "Ascending order" ;
uasort($age,"Ascending");
print_r($age);


echo "</br>Descending order" ;
uasort($age,"Descending");
print_r($age);