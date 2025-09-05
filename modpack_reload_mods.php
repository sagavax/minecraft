<?php 
include "includes/dbconnect.php";
include "includes/functions.php";

$modpack_id = $_GET['modpack_id'];

$get_mods="SELECT a.mod_id, a.modpack_id, b.cat_name from modpack_mods a, mods b where a.mod_id = b.cat_id and a.modpack_id=$modpack_id and a.mod_id order by cat_name ASC";

$result = mysqli_query($link, $get_mods) or die("MySQLi ERROR: ".mysqli_error($link));

while ($row = mysqli_fetch_array($result)) {
                 $result = mysqli_query($link, $get_mods) or die("MySQLi ERROR: ".mysqli_error($link));
            while($row = mysqli_fetch_array($result)){ 
            $mod_id = $row['mod_id'];
            $mod_name = $row['cat_name'];
              echo "<button type='button' class='button blue_button' data-id=$mod_id name='modification'>$mod_name</buton>";
        } 
            
}
?>
