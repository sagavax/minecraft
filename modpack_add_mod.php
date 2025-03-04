<?php

include "includes/dbconnect.php";
include "includes/functions.php";
         
$modpack_id = $_POST['modpack_id'];
$mod_id = $_POST['mod_id'];

$add_mod_to_modapck = "INSERT into modpack_mods (modpack_id, mod_id, added_date) VALUES ($modpack_id,$mod_id,now())";
$result=mysqli_query($link, $add_mod_to_modapck);

 $diary_text="Minecraft IS: the mod <strong>".GetModName($mod_id)."</strong> bol pridany do modpacku".GetModpackName($modpack_id);
 $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
 $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));