<?php include "includes/dbconnect.php";
      include "includes/functions.php";

      if(isset($_POST['add_new_video'])){
          global $link;
          $video_name=mysqli_real_escape_string($link, $_POST['video_title']);
          $video_url=mysqli_real_escape_string($link, $_POST['video_url']);
          $mod_id=mysqli_real_escape_string($link, $_POST['category']);
          $modpack=mysqli_real_escape_string($link, $_POST['modpack']);
          $eis_video_id=0;
          $sql="INSERT INTO videos (video_title, eis_video_id, video_url,modpack_id,added_date) VALUES ('$video_name',$eis_video_id,'$mod_id','$modpack_id')";
          $result=mysqli_query($link, $sql);

        $link1 = mysqli_connect(null, "brick_wall", "h3jSXv3gLf", "brick_wall", null, "/tmp/mariadb55.sock");
        //$link1=mysqli_connect("localhost", "root", "", "brick_wall");
        $curr_date=date('Y-m-d H:i:s');
        $diary_text="Minecraft IS: Bolo pridane nove video s nazvom <strong>$video_name</strong>";
        $sql="INSERT INTO diary (diary_text, date_added,location,isMobile,is_read) VALUES ('$diary_text','$curr_date','',0,0)";
        $result = mysqli_query($link1, $sql) or die("MySQLi ERROR: ".mysqli_error($link1));
        mysqli_close($link1);


        header('location:videos.php',301, true);

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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
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
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="notes.php">Notes</a></li>
            <li><a href="tasks.php">Tasks</a></li>
            <li><a href="categories.php">Categories</a></li>
            <li><a href="modpacks.php">Modpacks</a></li>
            <li><a href="videos.php">Videos</a><ul class="submenu"><li><a href="videos.php?view=see_later_videos">See later</a></li><li><a href="videos.php?view=favorite_videos">Favorite</a></li></ul></li>
            <li><a href="pics.php">Pics</a></li>
          </ul>
        </div>
        <div class="content">
          <div class='list'>
            <div id="new_video">
             <form action="" enctype="multipart/form-data" method="post">    
                <input type="text" name="video_title">
                <input type="text" name="video_url">
                <div class='new_video_category'><select name='category'>
						        <option value=0>-- Select category -- </option>
                      <?php
                        $sql="SELECT * from category ORDER BY cat_name ASC";
                        $result=mysqli_query($link, $sql);
                          while ($row = mysqli_fetch_array($result)) {
                            $cat_id=$row['cat_id'];
                            $cat_name=$row['cat_name'];
                        echo "<option value=$cat_id>$cat_name</option>";
                        }	
                      ?>  
                </select></div>
                <div class="new_video_modpack"><select name="modpack">
                <option value=0>-- Select mod pack -- </option>     
                <?php
                        $sql="SELECT * from modpacks ORDER BY modpack_id ASC";
                        $result=mysqli_query($link, $sql);
                          while ($row = mysqli_fetch_array($result)) {
                            $modpack_id=$row['modpack_id'];
                            $modpack_name=$row['modpack_name'];
                        echo "<option value=$modpack_id>$modpack_name</option>";
                        }	
                      ?>
                   </select>   
                </div>
                <div class="action"><button type="submit" name="add_new_video" class="button pull-right"><i class="fa fa-plus"></i></button></div>
               </form> 
            </div>

            <div id="video_list">
                <?php
                    //$sql="SELECT a.video_id, a.video_title, a.eis_video_id,a.mod_id, a.modpack_id, b.modpack_id, b.modpack_name from videos a, modpacks b, category c where a.modpack_id=b.modpack_id ORDER BY a.video_id DESC";
                    $sql="SELECT a.video_id, a.video_title, a.eis_video_id, a.video_url, a.mod_id, a.modpack_id from videos a ORDER BY a.video_id DESC";
                    $result=mysqli_query($link, $sql);
                        while ($row = mysqli_fetch_array($result)) {
                          $video_id=$row['video_id'];
                          $video_name=$row['video_title'];
                          $video_url=$row['video_url'];
                          $mod_id=$row['mod_id'];
                          $modpack_id=$row['modpack_id'];
                          
                          
                            echo "<div class='video'>";
                                    echo "<div class='video_name'><strong>$video_name</strong></div>";
                                    echo "<div class='video_url'><a href='$video_url'>$video_url</a></div>";
                                    echo "<div class='video_preview'></div>";
                                    echo "<div class='video_mods_wrap'><span class='span_mod'>".GetModName($mod_id)."</span><span class='span_modpack'>".GetModPackName($modpack_id)."</span></div>";
                                    echo "<div class='video_action'><span><a href='video_delete.php?id=$video_id'>x</a></span></div>";
                                    //echo "<div class='mod'>$mod_name</div>";
                                    echo "<div style='clear:both'></div>";             
                          echo "</div>";
                          
                        }        
                ?>
                
            </div>
            <div style="clear:both"></div> 
          </div>    
        </div>  