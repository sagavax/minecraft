<?php
      include("includes/dbconnect.php");
      include ("includes/functions.php");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minecraft IS</title>
    <!--<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>-->
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">

    <body>
         <?php include("includes/header.php") ?>
         <div class="main_wrap">
             <div class="tab_menu">
                <?php include("includes/vanila_menu.php") ?>
          </div>
          <div class="content">
             <div class="list">
                <div class="base_images_list">
                    <!-- get list of images -->
                    <?php
                        $get_base_images = "SELECT * from vanila_base_images";
                        $result = mysqli_query($link, $get_base_images) or die("MySQLi ERROR: ".mysqli_error($link));
                        while($row = mysqli_fetch_array($result)){
                            $img_id = $row['img_id'];
                            $base_id = $row['base_id'];
                            $image_name = $row['image_name'];
                            //echo $image_name;
                            echo "<div class='base_image'>"; //base_image
                                $root = "gallery/";

                                echo "<img src='".$root."base_".$base_id."/".$image_name."'>";
                                echo "<div class='image_footer'>";
                                echo "<div class='image_action'>";
                                echo "<button name='add_tag' type='button' class='button small_button' title='Add tagg'><i class='fas fa-tag'></i></button><button name='add_comment' type='button' class='button small_button' title='Add new comment'><i class='fa fa-comment'></i></button><button name='view_image' type='button'class='button small_button' title='View image'><i class='fa fa-eye'></i></button>";
                                echo "</div>";
                               echo "</div>"; 
                            echo "</div>"; //base image
                        }    
                     ?>   
             </div><!--base omage list -->        
         </div><!-- list -->
        </div><!-- content --> 
        
    </body>