<?php include "includes/dbconnect.php";
      include "includes/functions.php";

     $search_string=$_GET['search'];
      $sql="SELECT * from modpacks where modpack_description LIKE'%".$search_string."%' or modpack_name LIKE '%".$search_string."%'";

      $result=mysqli_query($link, $sql);
	  while ($row = mysqli_fetch_array($result)) {
        $modpack_id=$row['modpack_id'];
        $modpack_name=$row['modpack_name'];
        $modpack_description=$row['modpack_description'];
        $modpack_url=$row['modpack_url'];
        $modpack_pic=$row['modpack_pic'];

        $modpack_url=preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\">\\0</a>", $modpack_url);

        echo "<div class='modpack'>";
           //echo "<div class='modpack_details_wrap'>";
        echo "<div class='modpack_pic'><img src='./pics/noimage.jpg'></div>";
        echo "<div class='modpack_details'>";
        echo "<div class='modpack_name'>$modpack_name</div>";
        echo "<div class='modpack_description'>$modpack_description</div>";
        echo "<div class='modpack_url'><span>$modpack_url</span></div>";
        //echo "</div>"; 
        echo "</div>";   
                                
                               

                               
        echo "<div class='mod_list'>". GetModList($modpack_id)."</div>";
        echo "<div class='modpack_action'><form action='' method='post'><input type='hidden' name='modpack_id' value=$modpack_id><div class='buttons'><button name='new_note' title='add new note' class='button small_button'><i class='fa fa-plus'></i></button><button name='new_video' title='add new video'  class='button small_button'><i class='fa fa-plus'></i></button><button name='new_task' title='add new task' class='button small_button'><i class='fa fa-plus'></i></button></div></form></div>'";
        echo "</div>";
      }   