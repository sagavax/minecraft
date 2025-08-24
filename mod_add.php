<?php include "includes/dbconnect.php";
      include "includes/functions.php";

      
        $cat_name=trim(mysqli_real_escape_string($link, $_POST['mod']));
        
        //check duplicate
        $chec_duplicate="SELECT * from mods where cat_name='$cat_name'";    
        $result = mysqli_query($link, $chec_duplicate) or die("MySQLi ERROR: ".mysqli_error($link));
        $num_now=mysqli_num_rows($result);
        if($num_now>0){
            echo "<script>alert('Duplikat !!!');</script>";
            return;
        }
        else {
        $add_new_mod="INSERT INTO mods (cat_name, cat_modified) VALUES ('$cat_name',now())";
        $result=mysqli_query($link, $add_new_mod) or die("MySQLi ERROR: ".mysqli_error($link));;

      
        //add to log    
        $diary_text="Bol pridany novy mod s nazvom <b>$cat_name</b>";
        $create_record="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
        $result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));
      }
?>      