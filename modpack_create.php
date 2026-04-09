<?php include "includes/dbconnect.php";
      include "includes/functions.php";

          
          $modpack_name=mysqli_real_escape_string($link, $_POST['modpack_name']);

        //check if modpack with the same name already exists
        $sql="SELECT * FROM modpacks WHERE modpack_name='$modpack_name'";
        $result=mysqli_query($link, $sql);
        if(mysqli_num_rows($result)>0){
            echo "<script>alert('Modpack with the same name already exists.');</script>";
            exit();
        }

          if(isset($_POST['modpack_version'])){
            $modpack_version=mysqli_real_escape_string($link,$_POST['modpack_version']);
          } else {
            $modpack_version="";
          }
          
          if(isset($_POST['modpack_author'])){
            $modpack_author=mysqli_real_escape_string($link,$_POST['modpack_author']);
          } else {
            $modpack_author="";
          }

          if(isset($_POST['modpack_image'])){
            $modpack_image=mysqli_real_escape_string($link, $_POST['modpack_image']);
          } else {
            $modpack_image="";
          }

          if(isset($_POST['modpack_description'])){
            $modpack_description=mysqli_real_escape_string($link, $_POST['modpack_description']);
          } else {
            $modpack_description="";
          }
          if(isset($_POST['modpack_url'])){
            $modpack_url=mysqli_real_escape_string($link, $_POST['modpack_url']);
          } else {
            $modpack_url="";
          }
          
          //ziskam poslednu najvyssiu hodnotu pre load order 
          $sql="SELECT MAX(load_order) as max_load_order from modpacks";
          $result=mysqli_query($link, $sql);
           $row = mysqli_fetch_array($result);
           $max_load_order=intval($row['max_load_order']);
            
          $max_load_order=$max_load_order += 1;    
          $sql="INSERT INTO modpacks (modpack_name,  modpack_version, modpack_author,modpack_image, modpack_description, modpack_url, load_order,is_active) VALUES ('$modpack_name','$modpack_version','$modpack_author','$modpack_image','$modpack_description','$modpack_url',$max_load_order,1)";
          //echo $sql;
          $result=mysqli_query($link, $sql) or die(mysqli_error(($link)));
   
          $diary_text="Minecraft IS: Bol pridany novy modpack s nazvom <strong>$modpack_name</strong>";
          $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
          $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
          

       // header('location:modpacks.php',301, true);


?>     