<?php

include "includes/dbconnect.php";
include "includes/functions.php";

$modpack_id = $_GET['modpack_id'];
$status = mysqli_real_escape_string($link,$_GET['status']);

if($status == "active"){
    $get_tasks="SELECT * from to_do where modpack_id=$modpack_id and is_completed=0";	
} elseif ($status=="completed") {
    $get_tasks="SELECT * from to_do where modpack_id=$modpack_id and is_completed=1";
} elseif($status == "all"){
    $get_tasks="SELECT * from to_do where modpack_id=$modpack_id ORDER BY task_id DESC";
}


$result = mysqli_query($link, $get_tasks) or die("MySQLi ERROR: ".mysqli_error($link));

if (mysqli_num_rows($result) === 0) {
    echo "<div class='no_tasks'>No tasks</div>";
} else {
 while ($row = mysqli_fetch_array($result)) {
    $task_text=$row['task_text'];
    $task_id=$row['task_id'];
    $task_category_id=$row['cat_id'];
    $task_modpack_id=$row['modpack_id'];
    $is_completed=$row['is_completed'];
    
    $task_text=preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\">\\0</a>", $task_text);    
            
    echo "<div class='task' id='$task_id'>"; //task 
        echo "<div class='task_body'>$task_text</div>";
        echo "<div class='task_footer'>";
            
        $category_name=GetModName($task_category_id);
            $modpack_name=GetModpackName($task_modpack_id);
            
            if($category_name<>""){
            $category_name="<span class='span_mod'>".$category_name."</span>";
            }
            /* if ($modpack_name<>""){
            $modpack_name="<span class='span_modpack'>".$modpack_name."</span>";
            } */
            
            //$mod_modpack.="".$category_name." ".$modpack_name."</div>";
            

            $button_edit="<button type='submit' name='edit_task' class='button small_button pull-right' task-id=$task_id><i class='fas fa-edit'></i></button>";
            $button_task_complete="<button type='submit' name='complete_task' class='button small_button pull-right'  task-id=$task_id><i class='fa fa-check'></i></button>";

            $mod_modpack="<div class='task_modpacks'>".$category_name." ".$modpack_name."</div>";
            
            if($is_completed==1){
            
            echo $mod_modpack;
            $task_completed="<div class='task_completed'>Complete</div>";
            echo $task_completed;
            //$mod_modpack="<div class='mod_modpack'>".$mod_modpack." ".$task_completed."</div>";
            //echo $mod_modpack;
            

            } elseif($is_completed==0){

            echo $mod_modpack;
            echo "<div class='task_action'>".$button_edit." ".$button_task_complete."</div>";
            }
            
    echo "</div>";//task_footer_wrap;  
    echo "</div>";//task   
}

 
    }
                