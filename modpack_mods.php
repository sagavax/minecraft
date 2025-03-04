<?php
	include("includes/dbconnect.php");
	include("includes/functions.php");


  $modpack_id = $_GET['modpack_id'];    
 
 //echo "<div class='modlist_mods_title'><h3>List of mod for the modpack ".GetModPackName($modpack_id)."</h3></div>";
 echo "<div class='modpack_mod_list'>";
 

  //echo "<div class='modlist_mods_title'><h3>List of mod for the modpack ".GetModPackName($modpack_id)."</h3></div>";
       $sql="SELECT a.mod_id, a.modpack_id, b.cat_name from modpack_mods a, mods b where a.mod_id = b.cat_id and a.modpack_id=$modpack_id and a.mod_id order by cat_name ASC";
          $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
          while($row = mysqli_fetch_array($result)){ 
          $mod_id = $row['mod_id'];
          $mod_name = $row['cat_name'];
                                  echo "<button type='button' class='button blue_button' mod-id=$mod_id>$mod_name</buton>";
         
       } 

         echo "<button type='button' title='Add new mod into modpack' onclick='toggle_popup_mods()' class='button small_button blue_button'><i class='fa fa-plus'></i></button>";
         echo "<button class='button blue_button' title='Reload mod list' onclick='reload_mods()''><i class='fas fa-sync-alt'></i></button>";                
 ?>