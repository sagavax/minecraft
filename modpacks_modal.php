<?php include "includes/dbconnect.php";
      include "includes/functions.php";


    $get_modpacks = "SELECT * FROM modpacks ORDER BY modpack_name ASC";
    $result=mysqli_query($link, $get_modpacks) or die("MySQLi ERROR: ".mysqli_error($link));
     while ($row_modpacks = mysqli_fetch_array($result)) {
        $modpack_id = $row_modpacks['modpack_id'];
        $modpack_name = $row_modpacks['modpack_name'];
        echo "<button class='button blue_button' name='modpack' modpack-id=$modpack_id>$modpack_name</butt>";
     }