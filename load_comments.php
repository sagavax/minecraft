<?php 

include "includes/dbconnect.php";
      include "includes/functions.php";

                    $video_id = $_GET['video_id'];
                    echo "<ul>";
                    $video_comments="SELECT * from video_comments where video_id=$video_id";
                             $result_comments=mysqli_query($link, $video_comments);
                             while($row_comments = mysqli_fetch_array($result_comments)){
                                $comm_id= $row_comments['comm_id'];
                                $comment_text = $row_comments['video_comment'];
                                $comment_date = $row_comments['comment_date'];
                                //echo "<li><div class='comment_wrap'><div class='comment'>$comment_text</div><div class='date_ago'>$comment_date</div></div></li>";
                                echo "<li><div class='comment'>$comment_text</div></div></li>";
                             }     

                             //echo "<li><div class='comment_wrap'><form action='' id='comment_form'><div class='new_comment'><input type='hidden' name='video_id' value=$video_id><input type='text' name='video_comment' autocomplete='off'><button name='add_comment' type='button' onclick='Add_comment(); return false;'><i class='fa fa-plus'></i></button></form></div></li>";
                             echo "</ul>";