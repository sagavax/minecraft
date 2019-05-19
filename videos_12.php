<?php include "includes/dbconnect.php";
      include "includes/functions.php";

      if(isset($_POST['add_new_video'])){
          global $link;
          $video_name=mysqli_real_escape_string($link, $_POST['video_title']);
          $video_url=mysqli_real_escape_string($link, $_POST['video_url']);
          $mod_id=mysqli_real_escape_string($link, $_POST['category']);
          $modpack=mysqli_real_escape_string($link, $_POST['modpack_id']);
          $eis_video_id=0;
          $date=date('Y-m-d');
          $sql="INSERT INTO videos (video_title,video_url,eis_video_id,cat_id ,modpack_id,added_date) VALUES ('$video_name','$video_url',$eis_video_id,$mod_id,$modpack,'$date')";
          //echo $sql;
          $result=mysqli_query($link, $sql);

        $link1 = mysqli_connect(null, "brick_wall", "h3jSXv3gLf", "brick_wall", null, "/tmp/mariadb55.sock");
        //$link1=mysqli_connect("localhost", "root", "", "brick_wall");
        $curr_date=date('Y-m-d H:i:s');
        $diary_text="Minecraft IS: Bolo pridane nove video s nazvom <strong>$video_name</strong>";
        $sql="INSERT INTO diary (diary_text, date_added,location,isMobile,is_read) VALUES ('$diary_text','$curr_date','',0,0)";
        $result = mysqli_query($link1, $sql) or die("MySQLi ERROR: ".mysqli_error($link1));
        mysqli_close($link1);

        echo "<script>alert('Video s nazvom $video_name bolo pridane');
        window.location.href='videos.php';
        </script>";

      }

         if(isset($_POST['edit_video'])){
          $video_id=$_POST['video_id'];
          header('location:video_edit.php?video_id='.$video_id);
        }  

        if(isset($_POST['delete_video'])){
          $video_id=$_POST['video_id'];
          $sql="DELETE from videos where video_id=$video_id";
          $result=mysqli_query($link, $sql);

        
          //pridane do wallu;
          $link1 = mysqli_connect(null, "brick_wall", "h3jSXv3gLf", "brick_wall", null, "/tmp/mariadb55.sock");
          //$link1=mysqli_connect("localhost", "root", "", "brick_wall");
          $curr_date=date('Y-m-d H:i:s');
          $diary_text="Minecraft IS: Bolo pridane nove video s nazvom $video_name";
          $sql="INSERT INTO diary (diary_text, date_added,location,isMobile,is_read) VALUES ('$diary_text','$curr_date','',0,0)";
          $result = mysqli_query($link1, $sql) or die("MySQLi ERROR: ".mysqli_error($link1));
          mysqli_close($link1);

          echo "<script>alert('Video s id $video_id bolo zmazane');
          window.location.href='videos.php';
          </script>";
  
        }

        if(isset($_POST['add_to_favorites'])){
          $video_id=intval($_POST['video_id']);
          $video_name=mysqli_real_escape_string($link, $_POST['video_name']);
          $sql="UPDATE videos set is_favorite=1 where video_id=$video_id";
          $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

          //wall
          $link1 = mysqli_connect(null, "brick_wall", "h3jSXv3gLf", "brick_wall", null, "/tmp/mariadb55.sock");
          //$link1=mysqli_connect("localhost", "root", "", "brick_wall");
          $curr_date=date('Y-m-d H:i:s');
          $diary_text="Minecraft IS: video s nazvom $video_name bolo pridane medzi oblubene videa";
          $sql="INSERT INTO diary (diary_text, date_added,location,isMobile,is_read) VALUES ('$diary_text','$curr_date','',0,0)";
          $result = mysqli_query($link1, $sql) or die("MySQLi ERROR: ".mysqli_error($link1));
          mysqli_close($link1);

          echo "<script>alert('Video bolo pridane do oblubenych videi');
          window.location.href='videos.php';
          </script>";

        }

        if(isset($_POST['remove_from_favorites'])){
          $video_id=intval($_POST['video_id']);
          $video_name=mysqli_real_escape_string($link, $_POST['video_name']);

          $sql="UPDATE videos set is_favorite=0 where video_id=$video_id";
          $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

          //wall
          $link1 = mysqli_connect(null, "brick_wall", "h3jSXv3gLf", "brick_wall", null, "/tmp/mariadb55.sock");
          //$link1=mysqli_connect("localhost", "root", "", "brick_wall");
          $curr_date=date('Y-m-d H:i:s');
          $diary_text="Minecraft IS: video s nazvom $video_name vyaradene z oblubenych videi";
          $sql="INSERT INTO diary (diary_text, date_added,location,isMobile,is_read) VALUES ('$diary_text','$curr_date','',0,0)";
          $result = mysqli_query($link1, $sql) or die("MySQLi ERROR: ".mysqli_error($link1));
          mysqli_close($link1);

          echo "<script>alert('Video bolo vyradene z oblubenych videi');
          window.location.href='videos.php';
          </script>";
          
        }

        if(isset($_POST['add_see_later'])){
          $video_id=intval($_POST['video_id']);
          $video_name=mysqli_real_escape_string($link, $_POST['video_name']);
          $sql="UPDATE videos set see_later=1 where video_id=$video_id";
          $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

          //wall
          $link1 = mysqli_connect(null, "brick_wall", "h3jSXv3gLf", "brick_wall", null, "/tmp/mariadb55.sock");
          //$link1=mysqli_connect("localhost", "root", "", "brick_wall");
          $curr_date=date('Y-m-d H:i:s');
          $diary_text="Minecraft IS: video s nazvom $video_name bolo zaradene medzi Pozriem neskor videa";
          $sql="INSERT INTO diary (diary_text, date_added,location,isMobile,is_read) VALUES ('$diary_text','$curr_date','',0,0)";
          $result = mysqli_query($link1, $sql) or die("MySQLi ERROR: ".mysqli_error($link1));
          mysqli_close($link1);

          echo "<script>alert('Video bolo pridane medzi Pozriet neskor videa');
          window.location.href='videos.php';
          </script>";
          
        }
        
        if(isset($_POST['remove_from_see_later'])){
          $video_id=intval($_POST['video_id']);
          $video_name=mysqli_real_escape_string($link, $_POST['video_name']);
          $sql="UPDATE videos set see_later=0 where video_id=$video_id";
          $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

          //wall
          $link1 = mysqli_connect(null, "brick_wall", "h3jSXv3gLf", "brick_wall", null, "/tmp/mariadb55.sock");
          //$link1=mysqli_connect("localhost", "root", "", "brick_wall");
          $curr_date=date('Y-m-d H:i:s');
          $diary_text="Minecraft IS: video s nazvom $video_namebolo vyradene z Pozriem neskor videa";
          $sql="INSERT INTO diary (diary_text, date_added,location,isMobile,is_read) VALUES ('$diary_text','$curr_date','',0,0)";
          $result = mysqli_query($link1, $sql) or die("MySQLi ERROR: ".mysqli_error($link1));
          mysqli_close($link1);

          echo "<script>alert('Video bolo odobrane z Pozriet neskor videa');
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
        <div class="content">
          <div class='list'>
            <div id="new_video">
             <form action="" enctype="multipart/form-data" method="post">    
                <input type=hidden name="modpack_id" value=<?php if(isset($_GET['modpack_id'])){echo $_GET['modpack_id'];}else{echo 0;} ?>>
                <input type="text" name="video_title" placeholder='Video title' autocomplete=off>
                <input type="text" name="video_url" placeholder='Video url'  autocomplete=off>
                 <div class="new_video_select_action_wrap">
                  <div class="new_video_selects_wrap">
                  <select name='category'>
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
                      </select>

                      <select name="modpack">
                        <option value=0>-- Select mod pack -- </option>     
                          <?php
                              if(isset($_GET['modpack_id'])){
                                $modpack_id=$_GET['modpack_id'];
                                $modpack_name=GetModPackName($modpack_id);
                                echo "<option value=$modpack_id selected='selected'>$modpack_name</option>";
                              } else{  ?> 
                                <option value=0>-- Select mod pack -- </option>   
                              <?php   
                                  $sql="SELECT * from modpacks ORDER BY modpack_id ASC";
                              $result=mysqli_query($link, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                  $modpack_id=$row['modpack_id'];
                                  $modpack_name=$row['modpack_name'];
                              echo "<option value=$modpack_id>$modpack_name</option>";
                              }	
                            } 
                      ?>
                    </select>   
                  </div>
                  <div class="new_video_submit_wrap"><button type="submit" name="add_new_video" class="button pull-right"><i class="fa fa-plus"></i></button></div>
                </div>

                
               </form> 

            </div>
            
            <div class="search_wrap">
              <form action="" method="GET">
                <input type="text" name="search"><button type="submit" class="button small_button"><i class="fa fa-search"></i></button>
              </form>
            </div>     

            <div class="videos">
                  
              <div class="mod_list">
                <?php
                    $sql="SELECT DISTINCT(a.cat_id) as modlist, b.cat_name from videos a, category b where a.cat_id=b.cat_id ORDER BY b.cat_name ASC" ;
                    $result=mysqli_query($link, $sql);
                    while ($row = mysqli_fetch_array($result)) {
                      $mods_id=$row['modlist'];
                      if($mods_id==0){
                        $mod_name="unsorted";
                      } else {
                      $mod_name=GetModName($mods_id);
                    }
                      echo "<span class='span_mod'><a href='videos.php?mod_id=$mods_id'>$mod_name</a></span>";
                    }  
                  ?>
                </div>     

                <?php
                    if(isset($_GET['view'])){
                      $view=$_GET['view'];
                      if($view=='see_later_videos'){
                        //echo "<script>alert('See laster videos')</script>";
                        $sql="SELECT * from videos where see_later=1";
                      } elseif ($view=="favorite_videos") {
                        //echo "<script>alert('favorite videos')</script>";
                        $sql="SELECT * from videos where is_favorite=1";
                      } else{
                        $sql="SELECT * from videos ORDER BY video_id DESC";    
                      }
                    } elseif(isset($_GET['mod_id'])){
                      $mod_id=$_GET['mod_id'];
                         $sql="SELECT * from videos where cat_id=$mod_id ORDER by video_id DESC";
                      } elseif (isset($_GET['search'])){
                      $search=$_GET['search'];
                      $sql="SELECT * from videos where video_title like '%".$search."%'";
                    } else {
                    $sql="SELECT * from videos ORDER BY video_id DESC";
                    }
                     $result=mysqli_query($link, $sql);
                        while ($row = mysqli_fetch_array($result)) {
                          $video_id=$row['video_id'];
                          $eis_video_id=$row['eis_video_id'];
                          $video_name=$row['video_title'];
                          $video_url=$row['video_url'];
                          $mod_id=$row['cat_id'];
                          $modpack_id=$row['modpack_id'];
                          $is_favorite=$row['is_favorite'];
                          $see_later=$row['see_later'];
                          
                            echo "<div class='video'>";
                                    echo "<div class='video_name'><strong>$video_name</strong></div>"; 
                                    echo "<div class='video_url' ><a href='$video_url'>$video_url</a></div>";
                                    echo "<div class='video_preview'></div>";
                                   
                                    $category_name=GetModName($mod_id);
                                    $modpack_name=GetModpackName($modpack_id);

                                    if($category_name<>""){
                                      $category_name="<span class='span_mod'>".$category_name."</span>";
                                    }
                                    if ($modpack_name<>""){
                                       $modpack_name="<span class='span_modpack'>".$modpack_name."</span>";
                                    }
                                    
                                    echo "<div class='mod_modpack'>".$category_name." ".$modpack_name."</div>";

                                    echo "<div class='videos_action'><form method='post' action=''><input type='hidden' name=eis_video_id value=$eis_video_id><input type='hidden' name='video_name' value='$video_name'><input type='hidden' name=video_id value=$video_id>";
                                    
                                    if($see_later==0) {
                                      echo "<button name='add_see_later' title=''Add to Watch later' class='button app_badge'><i class='far fa-clock'></i></button>";
                                    } else {
                                      echo "<button name='remove_from_see_later' title='Remove from Watch later' class='button app_badge'><i class='fas fa-clock'></i></button>";
                                    }

                                    if($is_favorite==0) {
                                      echo "<button name='add_to_favorites' titie='add to favorites' class='button app_badge'><i class='far fa-star'></i></button>";
                                    } else {
                                      echo "<button name='remove_from_favorites' title='remove from favorites' class='button app_badge'><i class='fas fa-star'></i></button>";
                                    }

                                    echo "<button name='edit_video' type='submit' class='button app_badge'>Edit</button><button name='delete_video' type='submit' class='button app_badge'>Delete</button></form></div>";
                                    //echo "<div class='video_action'><span><a href='video_delete.php?id=$video_id'>x</a></span></div>";
                                    //echo "<div class='mod'>$mod_name</div>";
                                    echo "<div style='clear:both'></div>";             
                          echo "</div>";
                          
                        }        
                ?>
                
            </div>
            <div style="clear:both"></div> 
          </div>    
        </div>