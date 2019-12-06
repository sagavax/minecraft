<?php include "includes/dbconnect.php";
      include "includes/functions.php";

     $search_string=$_GET['search'];
      $sql="SELECT * from notes where note_text LIKE'%".$search_string."%'";

      $result=mysqli_query($link, $sql);
	  while ($row = mysqli_fetch_array($result)) {
      if(empty($row['note_header'])){
         $note_header="";
       } else {
         $note_header="<b>".$row['note_header']."</b>. ";
       }
       $note_id=$row['note_id'];
       $eis_note_id=$row['eis_note_id'];
       $note_header=$row['note_header'];
       $note_text=$row['note_text'];
       $note_mod=$row['cat_id'];
       $note_modpack=$row['modpack_id'];
       $note_text=preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\">\\0</a>", $note_text);

       echo "<div class='note'>";
         echo "<div class='note_header'><strong>".htmlspecialchars($note_header)."</strong></div>";
         echo "<div class='note_text'>$note_text</div>";
         
         $category_name=GetModName($note_mod);
         $modpack_name=GetModpackName($note_modpack);
          
         if($category_name<>""){
           $category_name="<span class='span_mod'>".$category_name."</span>";
         }
         if ($modpack_name<>""){
            $modpack_name="<span class='span_modpack'>".$modpack_name."</span>";
         }
         
         //echo "<div class='mod_modpack'>".$category_name." ".$modpack_name."</div>";
         echo "<div class='note_footer'>";
           echo "<div class='mod_modpack'>".$category_name." ".$modpack_name."</div><div class='notes_action'><form method='post' action='' enctype='multipart/form-data'><input type='hidden' name=eis_note_id value=$eis_note_id><input type='hidden' name=note_id value=$note_id><button name='attach_pic' type='button' class='button app_badge id='attach_image'><i class='material-icons'>attach_file</i><input type='file' name='image' id='file-name' accept='image/*' style='display:none' id='flie-upload'></button><button name='edit_note' type='submit' class='button app_badge'><i class='material-icons'>edit</i></button><button name='delete_note' type='submit' class='button app_badge'><i class='material-icons'>delete</i></button></form></div>";
         echo "</div>";//notes footer
       echo "</div>";
      }   