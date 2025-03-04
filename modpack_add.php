<?php include "includes/dbconnect.php";
      include "includes/functions.php";

     
      if(isset($_POST['add_new_modpack'])){
        //var_dump($_POST);  
        global $link;
          $modpack_name=mysqli_real_escape_string($link, $_POST['modpack_name']);
          $modpack_version=mysqli_real_escape_string($link,$_POST['modpack_version']);
          $modpack_author=mysqli_real_escape_string($link,$_POST['modpack_author']);
          $modpack_image=mysqli_real_escape_string($link, $_POST['modpack_image']);
          $modpack_description=mysqli_real_escape_string($link, $_POST['modpack_description']);
          $modpack_url=mysqli_real_escape_string($link, $_POST['modpack_url']);

          
          //ziskam poslednu najvyssiu hodnotu pre load order 
          $sql="SELECT MAX(load_order) as max_load_order from modpacks";
          $result=mysqli_query($link, $sql);
           $row = mysqli_fetch_array($result);
           $max_load_order=intval($row['max_load_order']);
            
          $max_load_order=$max_load_order += 1;    
          $sql="INSERT INTO modpacks (modpack_name,  modpack_version, modpack_author,modpack_image, modpack_description, modpack_url, load_order) VALUES ('$modpack_name','$modpack_version','$modpack_author','$modpack_image','$modpack_description','$modpack_url',$max_load_order)";
          echo $sql;
          $result=mysqli_query($link, $sql) or die(mysqli_error(($link)));


          
        
          
          $diary_text="Minecraft IS: Bol pridany novy modpack s nazvom <strong>$modpack_name</strong>";
          $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
          $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
          

       // header('location:modpacks.php',301, true);

      }

      if(isset($_POST['move_back'])){
        echo "<script>alert('Back')</script>";
        header("location:modpacks.php");
      }

?>      
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minecraft IS</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  </head>

  <body>
      <div class="header">
          <a href="."><div class="app_picture"><img src="pics/logo.svg" alt="Minecraft logo"></div></a>
      </div>
      <div class="main_wrap">
      <div class="tab_menu">
          <?php include("includes/menu.php"); ?>
        </div>
        </div>
        <div class="content">
          <div class='list'>
            <div id="new_modpack">
              <h3>Add new modpack:<h3>
             <form action="" enctype="multipart/form-data" method="post">    
                <input type="text" name="modpack_name" placeholder="Modpack's name" autocomplete="off"> 
                <input type="text" name="modpack_version" placeholder="Modpack's version" autocomplete="off">
                <input type="text" name="modpack_author" placeholder="Modpack's author" autocomplete="off" >
                <textarea name="modpack_description" placeholder="Modpack's description"></textarea>
                <input type="text" name="modpack_url"  placeholder="Modpack's url" autocomplete="off">
                <input type="text" name="modpack_image" placeholder="Modpack's image" autocomplete="off">
                <!-- input type="file" name="modpack_pic"  placeholder="Modpack's picture"> -->
                <div class="action">
                   <button type="submit" name="add_new_modpack" class="button pull-right"><i class="fa fa-plus"></i></button>
                   <button type="submit" name="move_back" class="button pull-right"><i class="fa fa-arrow-left"></i></button>
                </div>
               </form> 
            </div>
           <!-- modpack_list-->
          </div>    
        </div>  