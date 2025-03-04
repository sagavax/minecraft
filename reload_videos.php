<?php include "includes/dbconnect.php";
      include "includes/functions.php";

     $sql="SELECT * from videos ORDER BY video_id DESC";
     
      $result=mysqli_query($link, $sql);
	  while ($row = mysqli_fetch_array($result)) {
        $video_id=$row['video_id'];
        $video_name=$row['video_title'];
        $video_url=$row['video_url'];
        $mod_id=$row['cat_id'];
        $modpack_id=$row['modpack_id'];
        $is_favorite=$row['is_favorite'];
        $watch_later=$row['watch_later'];
        
        echo "<div class='video'>";

        echo "<div class='video_body'>
           <div class='video_name'><span>$video_name</span></div>
           <div class='video_action'>
           
           <form method='post' action=''><input type='hidden' name='video_name' value='$video_name'><input type='hidden' name=video_id value=$video_id>";
           echo "<button name='add_note' class='button app_badge' title='Add note'><i class='fa fa-plus'></i></button><button name='watch_video' class='button app_badge' title='watch video'><i class='fa fa-play'></i></button>";
           if($watch_later==0) {
             echo "<button name='add_see_later' title='Add to Watch later' class='button app_badge'><i class='far fa-clock'></i></button>";
           } else {
             echo "<button name='remove_from_see_later' title='Remove from Watch later' class='button app_badge'><i class='fas fa-clock'></i></button>";
           }

           if($is_favorite==0) {
             echo "<button name='add_to_favorites' title='add to favorites' class='button app_badge'><i class='far fa-star'></i></button>";
           } else {
             echo "<button name='remove_from_favorites' title='remove from favorites' class='button app_badge'><i class='fas fa-star'></i></button>";
           }

           echo "<button name='edit_video' type='submit' class='button app_badge'>Edit</button><button name='delete_video' type='submit' class='button app_badge'>Delete</button></form>
           
           
           </div>
        </div>";
       echo "<div class='video_banner_list'></div>";
        echo "<div class='video_action_play'>";
         echo "<div class='video_play_list'><div><a href='video.php?video_id=$video_id'><i class='fas fa-play'></i></a></div></div>";
        echo "</div>";
                                        
echo "</div>";
        
      }    