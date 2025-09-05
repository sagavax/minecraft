<?php
	include("includes/dbconnect.php");
	include("includes/functions.php");


  $modpack_id = $_GET['modpack_id'];    
  $modpack_name=GetModPackName($modpack_id);
 
echo "<div class='modlist_mods_title'><h3>Mods for the modpack ".GetModPackName($_GET['modpack_id'])."</h3></div>";

 //list of links with mods and their description
  echo "<div class='modpack_mods_links_wrap'>";
      echo "<div class='modpack_mods_url_add'><h4>Add new link</h4><div class='link_button_wrap'><button type='button' name='add_link' class='button small_button' title='Add new link'><i class='fa fa-plus'></i></button><button class='button small_button' name='reload_links' title='Reload links'><i class='fas fa-sync-alt'></i></button></div></div>";   
      
      echo "<div class='modpack_mods_links'>";

        $get_list_of_links = "SELECT link_id, link_name, modpack_mods_url from modpack_mods_links where modpack_id=$modpack_id";
        $result = mysqli_query($link, $get_list_of_links) or die("MySQLi ERROR: ".mysqli_error($link));  

          if (mysqli_num_rows($result) === 0) {
        echo "<div class='no_links'>No links. Whoud u like to add some?</div>";
          } else {

            while($row = mysqli_fetch_array($result)){ 
            $link_id = $row['link_id'];
            $link_name = $row['link_name'];
            $link_url = $row['modpack_mods_url'];

            echo "<div class='modpack_mods_link' link-id='$link_id'><a href='$link_url' target='_blank'>$link_url</a>";
            if(!empty($link_name)){
              echo "<div class='link_name'>$link_name</div>";
            } else {
              echo "<div class='link_name'><button class='button small_button' name='add_link_name' type='button'><i class='fas fa-plus'></i></button></div>";
            }
            echo "<div class='link_action'><button class='button blue_button' name='remove_link' type='button'><i class='fas fa-times'></i></button></div></div>";  
          }
      } 

     echo "</div>";//modpack_mods_links 

  echo "</div>";//modpack_mods_links_wrap


  echo "<input type='text' name='search_mods' placeholder='Search mods by name....' autocomplete='off'>";

  echo "<div class='toggle_regime'><button class='button blue_button' name='toggle_view_remove_regime' title='Change regime'>View</button></div>";    

  echo "<div class='modpack_mod_list'>";
  
        $get_mods="SELECT a.mod_id, a.modpack_id, b.cat_name from modpack_mods a, mods b where a.mod_id = b.cat_id and a.modpack_id=$modpack_id and a.mod_id order by cat_name ASC";
            $result = mysqli_query($link, $get_mods) or die("MySQLi ERROR: ".mysqli_error($link));
            while($row = mysqli_fetch_array($result)){ 
            $mod_id = $row['mod_id'];
            $mod_name = $row['cat_name'];
              echo "<button type='button' class='button blue_button' data-id=$mod_id name='modification'>$mod_name</buton>";
          
        } 

          echo "<button type='button' title='Add new mod into modpack' name='add_mods' class='button small_button blue_button'><i class='fa fa-plus'></i></button>";
          echo "<button class='button blue_button' name='reload_mods' title='Reload mod list'><i class='fas fa-sync-alt'></i></button>";                
  echo "</div>";   


?>
