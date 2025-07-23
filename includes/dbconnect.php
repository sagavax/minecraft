<?php
  date_default_timezone_set('Europe/Bratislava');


 //$link = mysqli_connect("mariadb105.r6.websupport.sk", "minecraft_db", "Us6^*qb1H-", "minecraft_db", 3315);
 //$link = mysqli_connect("awseb-e-rcedpsxaiv-stack-awsebrdsdatabase-h8ievr4b7tgk.cg18u1i45gny.eu-central-1.rds.amazonaws.com", "admin", "hOq2PaXqP3lhZ6T", "minecraft_db", 3306);
 // $link = mysqli_connect("mariadb105.r6.websupport.sk", "minecraft_db", "Us6^*qb1H-", "minecraft_db", 3315); 

 $link = mysqli_connect("localhost", "root", "root",  "minecraft_db", 3306); 

  if (!$link) {
      echo "Error: Unable to connect to MySQL." . PHP_EOL;
      echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    exit;
  } 

//
// Setup the UTF-8 parameters:
// * http://www.phpforum.de/forum/showthread.php?t=217877#PHP
//
// header('Content-type: text/html; charset=utf-8');
/* mysqli_query($link,'set character set utf8;');
mysqli_query($link,"SET NAMES `utf8`"); */
?>
