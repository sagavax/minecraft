<?php
       include "includes/dbconnect.php";
       include "includes/functions.php";
       
       $mod_id = $_POST['mod_id'];

       $show_info_mod = "SELECT * from mods WHERE cat_id=$mod_id";
       $result=mysqli_query($link, $update_description) or die(mysqli_error(($link)));

       while($row = myssqli_fetch_array()){
              $cat_name = $row['$cat_name'];       
              $cat_name = $row['$cat_description'];       
              $cat_url = $row['cat_url'];
       }
       