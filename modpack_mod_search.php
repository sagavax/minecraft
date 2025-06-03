<?php include "includes/dbconnect.php";


$mod = mysqli_real_escape_string($link, $_GET['mod']); //$_GET['mod'];

$get_mods = "SELECT * from mods where cat_name LIKE'%$mod%'";
$result=mysqli_query($link, $get_mods);
                while ($row = mysqli_fetch_array($result)) {  
                    $id = $row['cat_id'];
                    $cat_name = $row['cat_name'];
                    echo "<button class='button blue_button' data-id=$id onclic='add_mod_to_modpack($id)'>$cat_name</button>";
                } 
               
 ?>