<?php include "includes/dbconnect.php";
      include "includes/functions.php";

      if(isset($_POST['video_edit'])){
          //var_dump($_POST);
          $video_id=$_POST['video_id'];
          $video_name=mysqli_real_escape_string($link, $_POST['video_title']);
          $video_url=mysqli_real_escape_string($link, $_POST['video_url']);
          $video_category=$_POST['category'];
          $video_modpack=$_POST['modpack'];

          $sql="UPDATE videos SET cat_id=$video_category, modpack_id=$video_modpack, video_title='$video_name', video_url='$video_url' where video_id=$video_id";
          $result=mysqli_query($link, $sql);

           //$link1 = mysqli_connect(null, "brick_wall", "h3jSXv3gLf", "brick_wall", null, "/tmp/mariadb55.sock");
        $link1=mysqli_connect("localhost", "root", "", "brick_wall");
        $curr_date=date('Y-m-d H:i:s');
        $diary_text="Minecraft IS: Video s <strong>$video_title</strong> bolo upravene";
        $sql="INSERT INTO diary (diary_text, date_added,location,isMobile,is_read) VALUES ('$diary_text','$curr_date','',0,0)";
        $result = mysqli_query($link1, $sql) or die("MySQLi ERROR: ".mysqli_error($link1));
        mysqli_close($link1);
        
          
          echo "<script>
          alert('Video s id $video_id bolo upravene');
          window.location.href='videos.php';
          </script>";
          
          
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
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="notes.php">Notes</a></li>
            <li><a href="tasks.php">Tasks</a></li>
            <li><a href="categories.php">Categories</a></li>
            <li><a href="modpacks.php">Modpacks</a></li>
            <li><a href="videos.php">Videos</a><ul class="submenu"><li><a href="videos.php?view=see_later_videos">See later</a></li><li><a href="videos.php?view=favorite_videos">Favorite</a></li></ul></li>
            <li><a href="pics.php">Pics</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </div>
        <div class="content">
            <div class='list'>
                <?php
                    global $link; 
                    $video_id=$_GET['video_id'];
                    $sql="SELECT video_id, video_title, eis_video_id, video_url, cat_id, modpack_id from videos where video_id=$video_id";
               
                    $result=mysqli_query($link, $sql);
                    while($row = mysqli_fetch_array($result)){
                        $cat_id=$row['cat_id'];
                        $modpack_id=$row['modpack_id'];
                        $cat_name=GetModName($cat_id);
                        $modpack_name=GetModPackName($modpack_id);
                        $video_name=$row['video_title'];
                        $video_url=$row['video_url'];
                        $eis_video_id=$row['eis_video_id'];
                  
                    
                    ?>
                 <div id=task_edit>
                     <form action="" method="post">
                         <input type="hidden" name="video_id" value=<?php echo $video_id ?>>
                         <input type="text" name="video_title" value="<?php echo $video_name; ?>">
                         <input type="text" name="video_url" value="<?php echo $video_url;?>">
                         <div class='new_task_category'><select name='category'>
                         <?php if($cat_id==0){
                             echo "<option value=0> -- Select category -- </option>";
                         } else {  
                        
						 echo "<option value=$cat_id selected='selected'>$cat_name</option>";
                         }   
                        $sql="SELECT * from category ORDER BY cat_name ASC";
                      
                        $result=mysqli_query($link, $sql);
                          while ($row = mysqli_fetch_array($result)) {
                            $cat_id=$row['cat_id'];
                            $cat_name=$row['cat_name'];
                        echo "<option value=$cat_id >$cat_name</option>";
                        }	
                        ?>  
                        </select></div>
                        
                        <div class="new_task_modpack">
                                               
                        <select name="modpack">
                           <?php 
                           //echo "modpack:".$modpack_id;
                            if($modpack_id==0){
                                echo "<option value=0>-- Select modpack -- </option>";
                            } else {
                       
                        echo "<option value=$modpack_id selected='selected' >$modpack_name</option>";
                        }

                        $sql="SELECT * from modpacks ORDER BY modpack_id ASC";
                        $result=mysqli_query($link, $sql);
                          while ($row = mysqli_fetch_array($result)) {
                            $modpack_id=$row['modpack_id'];
                            $modpack_name=$row['modpack_name'];
                        echo "<option value=$modpack_id>$modpack_name</option>";
                        }	
                      ?>
                   </select> 
                   <?php
                    }
                   ?>
                </div>
                    <div class="videos_action"><button name="video_edit" type="submit" class="button middle_button pull-right"><i class="fa fa-pencil"></i></button></div>    
                    </form>    
                 </div><!--task edit -->   
            </div>    
        </div>  
</body>        