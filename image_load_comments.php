<?php 

include "includes/dbconnect.php";
      include "includes/functions.php";

                    $picture_id = $_GET['image_id'];
                    echo "<ul>";
                    $picture_comments="SELECT * from picture_comments where pic_id=$picture_id";
                    //echo $picture_comments;
                             $result_comments=mysqli_query($link, $picture_comments);
                             while($row_comments = mysqli_fetch_array($result_comments)){
                                $comm_id= $row_comments['comm_id'];
                                $comment_text = $row_comments['comment'];
                                $comment_date = $row_comments['comment_date'];
                                //echo "<li><div class='comment_wrap'><div class='comment'>$comment_text</div><div class='date_ago'>$comment_date</div></div></li>";
                                echo "<li><div class='comment' data-id=$comm_id>";
                                echo "<div class='comment_text'>$comment_text</div>";
                                echo "<div class='comment_footer'><buton class='button small_button'><i class='fa fa-times'></i></div></div>";
                                echo "</div></li>";
                             }     

                             //echo "<li><div class='comment_wrap'><form action='' id='comment_form'><div class='new_comment'><input type='hidden' name='video_id' value=$video_id><input type='text' name='video_comment' autocomplete='off'><button name='add_comment' type='button' onclick='Add_comment(); return false;'><i class='fa fa-plus'></i></button></form></div></li>";
                             echo "</ul>";