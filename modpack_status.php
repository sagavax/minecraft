<?php

 include("includes/dbconnect.php");


 $mmodpack_id=$_GET['modpack_id'];
 $modpack_status = $_GET['status'];
 
 if($_GET['status']=="active"){
    $modpack_status = 1;
 } elseif ($_GET['status']=="inactive"){
       $modpack_status = 0;
 }
 
 
 $sql="UPDATE modpacks SET is_active=$modpack_status WHERE modpack_id=$mmodpack_id";
 //echo $sql;
 $result=mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
