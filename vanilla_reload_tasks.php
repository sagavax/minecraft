<?php include "includes/dbconnect.php";
      include "includes/functions.php";

      $base_id = $_GET['base_id'];

      $sql="SELECT * from vanila_base_tasks where base_id = $base_id ORDER BY task_id DESC";
      $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
      while($row = mysqli_fetch_array($result)){
          $task_id = $row['task_id'];
          $is_completed = $row['is_completed'];
          $task_text = $row['task_text'];
          $task_text=preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\">\\0</a>", $task_text);
          echo "<div class='task vanilla_task' task-id=$task_id>"; //task
          echo "<div class='task_body'>$task_text</div>";
          echo "<div class='task_footer'>";
                echo "<div class='task_action'>";
                  if ($is_completed ==1){
                       echo "<span class='span_task_completed'>finished</span>";
                  } else {
                      echo "<button type='button' name='complete_task' onclick='complete_task($task_id) 'class='button small_button pull-right'><i class='fa fa-check'></i></button>";
                  }
                echo "</div>";  
          echo "</div>"; //footer
      echo "</div>";// task
      }   
                
?>