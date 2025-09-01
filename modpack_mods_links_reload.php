<?php
        include("includes/dbconnect.php");
        include("includes/functions.php");

        $modpack_id = $_GET['modpack_id'];


        $get_links = "SELECT * from modpack_mods_links where modpack_id=$modpack_id";
        $result = mysqli_query($link, $get_links) or die("MySQLi ERROR: ".mysqli_error($link));

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