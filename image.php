<?php include "includes/dbconnect.php";
      include "includes/functions.php";

?>
<!DOCTYPE html>
<html>
<head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Minecraft - image</title>
      <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
      <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
      <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
      <script type="text/javascript" defer src="js/image.js?<?php echo time(); ?>"></script>
</head>
<body>
       <?php include("includes/header.php") ?>
      <div class="main_wrap">
      <div class="tab_menu">
          <?php include("includes/menu.php"); ?>
    </div>
       
    <div class="content">
        <div class='list'>
            <?php
                   $picture_id = $_GET['image_id'];     

                    $sql="SELECT picture_id, picture_name,picture_title, picture_description, picture_path from pictures where picture_id=$picture_id";
                    //echo $sql;

                    $result=mysqli_query($link, $sql);
                     while ($row = mysqli_fetch_array($result)) {
                       $picture_id=$row['picture_id'];
                       $picture_title=$row['picture_title'];
                      $picture_description=$row['picture_description']; 
                      
                       $picture_id = $row['picture_id'];
                       $picture_name=$row['picture_name'];
                       $picture_path=$row['picture_path'];
                       
                     
                       echo "<div class='picture' image-id=$picture_id>";
                            echo "<div class='picture_name'>$picture_title</div>";
                              if($picture_title==""){
                                $picture_title=$picture_name;
                              }

                            echo "<div class='full_pic'>";
                              if(!empty(parse_url($picture_path, PHP_URL_SCHEME))){
                              
                                echo "<img src='$picture_path' title='$picture_title'></div>";  
                              } else {
                                echo "<img src='gallery/$picture_path' title='$picture_title'></div>";
                              }
                            
                              echo "<div class='picture_detail_footer'>"; 
                              
                              //echo "<div class='mod_modpack'>".$modpack_name."</div>";

                              echo "<div class='picture_info'>";
                                  echo "<div class='picture_modpacks'>".GetImageModpack($picture_id)."</div>";
                                  echo "<div class='image_description' data-placeholder='image descriptpion. click / tap here to put some wideo description here ...' title='Image description'>$picture_description<button name='save_description' type='button' class='button small_button'><i class='fa fa-save'></i></button></div>";  
                                  echo "<div class='images_tags' tag-list='".GetImageTagListArray($picture_id)."'>".GetImageTagList($picture_id)."</div>";  
                               
                              echo "</div>"; //picture_info                                            

                           
                             echo "<div class='comments_wrapper'>"; 

                             echo "<div class='picture_comm_info'><span><span id='nr_of_comments'>" . GetNrOfImageComments($picture_id) . "</span> comment(s)</span></div>";  
                            echo "<div class='picture_comments' id='comments'>";
                            
                            $picture_comments = "SELECT * from picture_comments where pic_id=$picture_id";
                            $result_comments = mysqli_query($link, $picture_comments);
                            while ($row_comments = mysqli_fetch_array($result_comments)) {
                                $comm_id = $row_comments['comm_id'];
                                $comment_text = $row_comments['comment'];
                                $comment_date = $row_comments['comment_date'];

                                $comment_text = preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~", "<a target='_blank' href=\"\\0\">\\0</a>", $comment_text);

                              echo "<div class='comment' data-id=$comm_id>";
                                   echo "<div class='comment_text'>$comment_text</div>";
                                   echo "<div class='comment_footer'><button class='button small_button'><i class='fa fa-times'></i></button></div>";
                              echo "</div>";//comment 
                              }
                                  //echo "</ul>";
                            echo "</div>"; //video comments

                                  echo "<div class='new_comment'><input type='text' name='picture_comment' id='picture_comment' autocomplete='off'><button name='add_comment' type='button' onclick='add_comment(); return false;'><i class='fa fa-plus'></i></button></div>";

                            echo "<div class='action_back'><button type='button''><i class='fas fa-sync'></i> Reload</button> <a href='images.php'><i class='fas fa-angle-left'></i> Back</a></div>";
                            echo "</div>"; //div comments_wrapper
                            echo "</div>"; //div footer                 
                          echo "</div>";//div picture
                         } 
                      
            ?>
        </div><!-- list -->
     </div><!-- content -->  
     <dialog class="modal_new_tags">
          <div class="inner_layer">
              <button type="button" class="close_inner_modal"><i class="fa fa-times"></i></button>  
              <input type="text" name="tag_name" placeholder="tag name ...." autocomplete="off">
              <div class="video_tags_alphabet">
                <?php 
                        foreach (range('A', 'Z') as $char) {
                          echo "<button type='button' class='button small_button' name='letter'>$char</button>";

                        }
                     ?>  
              </div>
              <div class="tags_list"><?php echo GetAllUnassignedVideosTags()?></div>
              <!-- <div class="loading" style="display: none;">Loading...</div> -->
          </div>
        </dialog>     

        <dialog class="modal_change_modpack">
             <div class='inner_change_modpack_layer'>
                <button type="button" class='close_inner_modal'><i class='fa fa-times'></i></button>  
                <div class='change_modpack_list'>
                <?php
                   $get_modpacks = "SELECT * from modpacks ORDER BY modpack_name ASC";
                    $result=mysqli_query($link, $get_modpacks);

                    echo "<button modpack-id=999 class='button small_button'>Unspecified</button>";
                    while ($row = mysqli_fetch_array($result)) {                   
                        $modpack_name = $row['modpack_name'];
                        $modpack_id = $row['modpack_id']; 
                        echo "<button modpack-id=$modpack_id class='button small_button'>$modpack_name</button>";

                    }
                ?>
              </div>
         </dialog>
</body>
</html>