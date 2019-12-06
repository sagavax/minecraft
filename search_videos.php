<?php include "includes/dbconnect.php";
      include "includes/functions.php";

     $search_string=$_GET['search'];
      $sql="SELECT * from videos where video_title LIKE '%".$search_string."%'";
     
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