<?php
	include("includes/dbconnect.php");
	include("includes/functions.php");


  $modpack_id = $_GET['modpack_id'];    
 
 //list of links with mods and their description
 
 echo "<div class='modpack_mods_urls'>";

        $get_list_of_links = "SELECT * from mods_links where modpack_id = $modpack_id";
        $result = mysqli_query($link, $get_list_of_links) or die("MySQLi ERROR: ".mysqli_error($link));
        if (mysqli_num_rows($result) === 0) {
            echo "<div class='no_links'>No links. Whoud u like to add some? <button type='button' name='add_link' class='button small_button' title='Add to gallery'><i class='fa fa-plus'></i></button></div>";
        } else {
            while($row = mysqli_fetch_array($result)){ 
                $link_id = $row['link_id'];
                $link_name = $row['link_name'];
                $link_url = $row['modpack_mods_url'];

                echo "<div class='modpack_mods_url' data-id='$link_id'><a href='$link_url' target='_blank'>$link_name</a></div>";
            }
        }

 echo "</div>";

 
 echo "<div class='modpack_mod_list'>";
 
  //echo "<div class='modlist_mods_title'><h3>List of mod for the modpack ".GetModPackName($modpack_id)."</h3></div>";
       $sql="SELECT a.mod_id, a.modpack_id, b.cat_name from modpack_mods a, mods b where a.mod_id = b.cat_id and a.modpack_id=$modpack_id and a.mod_id order by cat_name ASC";
          $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
          while($row = mysqli_fetch_array($result)){ 
          $mod_id = $row['mod_id'];
          $mod_name = $row['cat_name'];
            echo "<button type='button' class='button blue_button' data-id=$mod_id name='remove_mod_from_modpack'>$mod_name</buton>";
         
       } 

         echo "<button type='button' title='Add new mod into modpack' onclick='toggle_popup_mods()' class='button small_button blue_button'><i class='fa fa-plus'></i></button>";
         echo "<button class='button blue_button' title='Reload mod list' onclick='reload_mods()''><i class='fas fa-sync-alt'></i></button>";                
 ?>
