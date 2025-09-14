<?php
       include "includes/dbconnect.php";
       include "includes/functions.php";

       $modpack_id=$_GET['modpack_id'];
       $modpack_name=GetModPackName($modpack_id);

       $sql="SELECT modpack_name, modpack_description from modpacks where modpack_id=$modpack_id";
       $result=mysqli_query($link, $sql);
       $row = mysqli_fetch_array($result);
       $modpack_description=$row['modpack_description'];

       //echo "<div id='modpack_title'>$modpack_name</div>";
       echo "<div id='modpack_description'>$modpack_description</div>";