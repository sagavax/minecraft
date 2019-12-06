<?php

include "includes/dbconnect.php";
include "includes/functions.php";

$modpack_id=$_GET['modpack_id'];
$ModPack_name=GetModPackName($modpack_id);

$sql="SELECT * from notes where modpack_id=$modpack_id";
$row = mysqli_fetch_array($result);
       