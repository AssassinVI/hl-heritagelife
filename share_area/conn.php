<?php
 require 'sys/core/inc/config.php';
 require 'sys/core/inc/function.php';
 require 'sys/core/inc/pdo_fun_calss.php';

if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == 'off'){
    Header("HTTP/1.1 301 Moved Permanently");
    header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
}

 OneDayChart();

 $pdo=new PDO_fun;
 
 $company=$pdo->select("SELECT * FROM company_base LIMIT 0,1", 'no', 'one');

?>