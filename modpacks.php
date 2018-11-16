<?php include "includes/dbconnect.php";
      include "includes/functions.php";

      if(isset($_POST['add_new_modpack'])){
          global $link;
          $modpack_name=mysqli_real_escape_string($link, $_POST['modpack_name']);
          $modpack_description=mysqli_real_escape_string($link, $_POST['modpack_description']);
          $modpack_url=mysqli_real_escape_string($link, $_POST['modpack_url']);
          //$modpack_pic=mysqli_real_escape_string($link, $_POST['modpack_pic']);
            
          $modpack_pic="";

          $sql="INSERT INTO modpacks (modpack_name,  modpack_pic, modpack_description, modpack_url) VALUES ('$modpack_name','$modpack_pic','$modpack_description','$modpack_url')";
          //echo $sql;
          $result=mysqli_query($link, $sql);

          $link1 = mysqli_connect(null, "brick_wall", "h3jSXv3gLf", "brick_wall", null, "/tmp/mariadb55.sock");
          //$link1=mysqli_connect("localhost", "root", "", "brick_wall");
          $curr_date=date('Y-m-d H:i:s');
          $diary_text="Minecraft IS: Bol pridany novy modpack s nazvom <strong>$modpack_name</strong>";
          $sql="INSERT INTO diary (diary_text, date_added,location,isMobile,is_read) VALUES ('$diary_text','$curr_date','',0,0)";
          $result = mysqli_query($link1, $sql) or die("MySQLi ERROR: ".mysqli_error($link1));
          mysqli_close($link1);

        header('location:modpacks.php',301, true);

      }

      if(isset($_POST['new_task'])){
          header('location:task_add.php?modpack_id='.$_POST['modpack_id']);
      }

      if(isset($_POST['new_note'])){
        header('location:note_add.php?modpack_id='.$_POST['modpack_id']);
    }

    if(isset($_POST['new_video'])){
        header('location:videos.php?modpack_id='.$_POST['modpack_id']);
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
          <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="notes.php">Notes</a></li>
            <li><a href="tasks.php">Tasks</a></li>
            <li><a href="categories.php">Categories</a></li>
            <li><a href="modpacks.php">Modpacks</a></li>
            <li><a href="videos.php">Videos</a><ul class="submenu"><li><a href="videos.php?view=see_later_videos">See later</a></li><li><a href="videos.php?view=favorite_videos">Favorite</a></li></ul></li>
            <li><a href="pics.php">Pics</a></li>
            <li><a href="logout.php">Logout</a></li>
         </ul>
        </div>
        </div>
        <div class="content">
          <div class='list'>
            <div id="new_modpack">
             <form action="" enctype="multipart/form-data" method="post">    
                <input type="text" name="modpack_name" placeholder="Modpack's name">
                <textarea name="modpack_description" placeholder="Modpack's description"></textarea>
                <input type="text" name="modpack_url"  placeholder="Modpack's url">
                <input type="file" name="modpack_pic"  placeholder="Modpack's picture">
                <div class="action"><button type="submit" name="add_new_modpack" class="button pull-right"><i class="fa fa-plus"></i></button></div>
               </form> 
            </div>
            <div id="modpack_list">
                <?php
                    $sql="SELECT * from modpacks";
                    $result=mysqli_query($link, $sql);
                        while ($row = mysqli_fetch_array($result)) {
                            $modpack_id=$row['modpack_id'];
                            $modpack_name=$row['modpack_name'];
                            $modpack_description=$row['modpack_description'];
                            $modpack_url=$row['modpack_url'];
                            $modpack_pic=$row['modpack_pic'];

                            $modpack_url=preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\">\\0</a>", $modpack_url);

                            echo "<div class='modpack'>";
                               echo "<div class='modpack_details_wrap'>";
                                echo "<div class='modpack_pic'><img src='./pics/noimage.jpg'></div>";
                                echo "<div class='modpack_details'>";
                                    echo "<div class='modpack_name'>$modpack_name</div>";
                                    echo "<div class='modpack_description'>$modpack_description</div>";
                                    echo "<div class='modpack_url'><span>$modpack_url</span></div>";
                                echo "</div>"; 
                              echo "</div>";   
                                
                               

                               
                                echo "<div class='mod_list'>". GetModList($modpack_id)."</div>";
                                echo "<div class='modpack_action'><form action='' method='post'><input type='hidden' name='modpack_id' value=$modpack_id><div class='buttons'><button name='new_note' title='add new note' class='button small_button'><i class='fa fa-plus'></i></button><button name='new_video' title='add new video'  class='button small_button'><i class='fa fa-plus'></i></button><button name='new_task' title='add new task' class='button small_button'><i class='fa fa-plus'></i></button></div></form></div>'";
                            echo "</div>";
                        }        
                ?>
            </div>
            <div style="clear:both"></div>          

          </div>    
        </div>  