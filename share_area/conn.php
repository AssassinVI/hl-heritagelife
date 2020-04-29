<?php
 require 'sys/core/inc/config.php';
 require 'sys/core/inc/function.php';
 require 'sys/core/inc/pdo_fun_calss.php';

 OneDayChart();

 $pdo=new PDO_fun;
 
 $company=$pdo->select("SELECT * FROM company_base LIMIT 0,1", 'no', 'one');

?>