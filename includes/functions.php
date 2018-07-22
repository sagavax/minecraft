<?php 
include("includes/dbconnect.php");

function SubtasksQty($task_id){
	global $link;
	$query="SELECT * from to_do where parent_task=$task_id";
	$result=mysqli_query($link, $query);
	$nr_subtasks=mysqli_num_rows($result);
	return $nr_subtasks;
}


function GetSubtasks($task_id){
	global $link;
	$query="SELECT * from to_do WHERE parent_task=$task_id and is_completed=0 ORDER BY task_id DESC";
	//echo $query;
	$result=mysqli_query($link, $query);
	while ($row = mysqli_fetch_array($result)) {
	  		$task_text=$row['task_text'];
	  		$parent_task=$task_id;
	  		$subtask_id=$row['task_id'];
	   		$task_text=preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\">\\0</a>", $task_text);		
	   		$subtasks="<div class='subtask'><div class='subtask_text'>$task_text</div><form action='' method='post'><input type='hidden' name='subtask_id' value='$subtask_id'><button type='submit' name='close_subtask' class='button small_button small_font pull-right'><i class='fa fa-check'></i></buton></form></div>";
	   		//$subtasks.= "<div class='subtask_action'><form action='' method='post'><input type='text' name='subtask_text' value=''><button type='' name='add_subtask' class='button small_button pull_right'>+</buton></form></div>";
	   		echo $subtasks;
	   	}	
	}

function CheckOpenSubtasks($task_id) {
	global $link;
  	$query="SELECT count(*) as nr_opened_subtasks from to_do where is_completed=0 and parent_task=$task_id";
  	$result=mysqli_query($link, $query);
  	 $row = mysqli_fetch_array($result);
  	 $nr_opened_subtasks=$row['nr_opened_subtasks'];

	if($nr_opened_subtasks>0) {
		$has_opened_subtasks=1;
	} else {
		$has_opened_subtasks=0;
	}
	
 	return $has_opened_subtasks;
		
}
