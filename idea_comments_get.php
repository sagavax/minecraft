<?php
    include("includes/dbconnect.php");

    $idea_id  =  $_POST['idea_id'];

    $get_comment = "SELECT * from idea_comments WHERE id idea_id=$idea_id";
    $result = mysqli_query($link, $get_comment) or die(mysqli_error($link));

    while ($row = mysqli_fetch_array($result)){

        $comment_id = $row['comm_id'];
        $comm_title = $row_comment['idea_comm_header'];
        $comm_text = $row_comment['idea_comment'];
        $comm_date = $row_comment['comment_date'];

        echo "<div class='idea_comment' data-comment-id=$comm_id>";
        echo "<div class='connector-line'></div>";
        echo "<div class='idea_top_banner'></div>";
        
        if($comm_title!=""){
            echo "<div class='idea_comm_title'>$comm_title</div>";    
        }
        echo "<div class='idea_comm_text'>$comm_text</div>";
        echo "<div class='idea_comm_action'>";

        if ($is_applied == 1) {
                  // If $is_disabled is 1, add the disabled attribute to the button
                  echo "<button type='button' name='delete_comment' class='button small_button' disabled><i class='fa fa-times'></i></button>";
              } else {
                  // If $is_disabled is not 1, do not add the disabled attribute
                  echo "<button type='button' name='delete_comment' class='button small_button'><i class='fa fa-times'></i></button>";
              }
              echo "</div>";
    echo "</div>";
    }
