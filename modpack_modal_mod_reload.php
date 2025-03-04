<?php include "includes/dbconnect.php";


$modpack_id = $_GET['modpack_id'];

if(isset($_GET['mod'])){ //mod is not empty
    $mod = $_GET['mod'];
    $get_mods = "SELECT * from mods where cat_name LIKE'%$mod%'";
} else {
 $get_mods = "select * from mods where cat_id not in (SELECT mod_id from modpack_mods where modpack_id=$modpack_id) order by cat_name ASC LIMIT 20";
}

//$get_mods = "SELECT * from mods where cat_name='%$mod%'";
$result=mysqli_query($link, $get_mods);
                while ($row = mysqli_fetch_array($result)) {  
                    $id = $row['cat_id'];
                    $cat_name = $row['cat_name'];
                    echo "<button class='button blue_button' data-id=$id onclic='add_mod_to_modpack($id)'>$cat_name</button>";
                } 
               
 ?>