<?php

function time_diff($start,$end = false) { 
    /* 
    * For this function, i have used the native functions of PHP. It calculates the difference between two timestamp. 
    * 
    * Author: Toine 
    * 
    * I provide more details and more function on my website 
    */ 

    // Checks $start and $end format (timestamp only for more simplicity and portability) 
	;
    if(!$end) { $end = time(); } 
    //if(!is_numeric($start) || !is_numeric($end)) { return false; }
//print_r($start);die	;
    // Convert $start and $end into EN format (ISO 8601) 
    $start  = date('Y-m-d H:i:s',strtotime($start)); 
    $end    = date('Y-m-d H:i:s',strtotime($end)); 
    $d_start    = new DateTime($start); 
    $d_end      = new DateTime($end); 
    $diff = $d_start->diff($d_end); 
    // return all data 

    $year    = $diff->format('%y'); 
    $month    = $diff->format('%m'); 
    $day      = $diff->format('%d'); 
    $hour     = $diff->format('%h'); 
    $min      = $diff->format('%i'); 
    $sec      = $diff->format('%s'); 
	$diff_time = $year.'-'.$month.'-'.$day.' '.$hour.':'.$min.':'.$sec;
    return $diff_time; 
} 


?>