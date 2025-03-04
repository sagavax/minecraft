<?php include "includes/dbconnect.php";
include "includes/functions.php";

$search_string=$_GET['search'];
$sql="SELECT * from vanila_base_tasks where task_text LIKE'%".$search_string."%'";

$result=mysqli_query($link, $sql);

while ($row = mysqli_fetch_array($result)) {
  $task_text=$row['task_text'];
  $base_id=$row['zakladna_id'];
  $task_id=$row['task_id'];
  $is_completed=$row['is_completed'];

  $task_text=preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\">\\0</a>", $task_text);    

   echo "<div class='task' id='$task_id'>"; //task 
   echo "<div class='task_body'>$task_text</div>";
   echo "<div class='task_footer'>";
   echo "<div class='span_modpack'>".GetBanseNameByID($base_id)."</div>";
   $button_edit="<button type='submit' name='edit_task' class='button small_button pull-right'  task-id=$task_id><i class='fas fa-edit'></i></button>";
   $button_task_complete="<button type='submit' name='complete_task' class='button small_button pull-right'  task-id=$task_id><i class='fa fa-check'></i></button>";
   if($is_completed==1){
    $task_completed="<span class='span_task_completed'>Complete</span>";
    echo $task_completed;

  } elseif($is_completed==0){
    echo "<div class='task_action'>".$button_edit." ".$button_task_complete."</div>";
  }
  echo "</div>";//task_footer_wrap;  
echo "</div>";//task
}