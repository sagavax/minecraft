<?php
    include('includes/dbconnect.php');
    include('includes/functions.php');

    $letter = mysqli_real_escape_string($link, $_POST['letter']);
    
    $get_tags = "SELECT * from tags_list b where tag_name like '$letter%'";
    //echo $get_tags;
      
         //echo $get_tags;
      $result=mysqli_query($link, $get_tags) or die();

      while ($row = mysqli_fetch_array($result)) {
             $tag_id= $row['tag_id'];
             $tag_name= $row['tag_name'];
             echo  "<button tag-id=$tag_id class='button small_button' name='add_new_tag'>$tag_name <i class='fa fa-times' title='Close'></i></button>";

            }

?>