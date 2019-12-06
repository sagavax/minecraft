<?php 
session_start();
include "includes/dbconnect.php";
include "includes/functions.php";

if(isset($_POST['add_note'])){
  header('location:note_add.php');
}

if(isset($_POST['add_daily_note'])){
  header('location:note_add.php?curr_date=now');
}

?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minecraft IS</title>
    <!--<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>-->
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="js/modpack.js"></script>

  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <script>
        function show_welcome_message(){
          setTimeout(function(){
            document.getElementsByClassName('')[0].style.visibility = 'hidden';
            //alert('hello world!');
          }, 3000);
        }
    </script>
  </head>
  
  <body>
  
    <div class="header">
          <a href="."><div class="app_picture"><img src="pics/logo.svg" alt="Minecraft logo"></div></a>
    </div>
     
    <div class="main_wrap">
        <div class="tab_menu">
            <?php include("menu.php"); ?>
        </div>
        
        <div class="content">
            <div id="modpack_details_wrap">
                <!-- <div id="modpack_menu"><ul><li><a href="#">Description</a></li><li><a href="#">Tasks</a></li><li><a href="#">Notes</a></li><li><a href="#">Videos</a></li><li><a href="#">Pictures</a></li></ul></div>-->
                <div id="modpack_menu"><ul><li><a href="modpack.php?view=description">Description</a></li><li><a href="modpack.php?view=tasks">Tasks</a></li><li><a href="modpack.php?view=notes">Notes</a></li><li><a href="modpack.php?view=videos">Videos</a></li><li><a href="modpack.php?view=pictures">Pictures</a></li></ul></div>
                <div id="modpack_content">
                    <?php
                      
                      if(isset($_GET['modpack_id'])){
                        $modpack_id=$_GET['modpack_id'];
                        $_SESSION['modpack_id']=$modpack_id;
                        
                      } else {
                        $modpack_id=$_SESSION['modpack_id']; 
                      }
           
                     echo "<script>alert('".$modpack_id."')</script>";   

                      if(isset($_GET['view'])){
                        $action=$_GET['view'];

                      if($action=="description"){
                        
                        $modpack_name=GetModPackName($modpack_id);

                        $sql="SELECT modpack_name, modpack_description from modpacks where modpack_id=".$_SESSION['modpack_id'];
                        $result=mysqli_query($link, $sql);
                        $row = mysqli_fetch_array($result);
                        $modpack_description=$row['modpack_description'];
                 

                        echo "<div id='modpack_title'>$modpack_name</div>";
                        echo "<div id='modpack_description'>$modpack_description</div>";
                      } elseif($action=="tasks"){
                  ?>
                        <div class='list'>

          <div class="search_wrap">
              <form action="" method="GET">
                <input type="text" name="search" onkeyup="search_the_string(this.value);" id="search_string"><!--<button type="submit" class="button small_button"><i class="fa fa-search"></i></button>-->
              </form>
            </div> 

            <div class="tasks_view">
              <form action=""><input type='radio' name='status' id="active" value="active"><label for="active">Active</label><input type='radio' name='status' id="completed" value="completed"><label for="completed" name="status" value="completed">Completed</label><input type='radio' name='status' value="all" id="all"><label for="all">All</label><button type='submit' class='button small_button pull-right'>OK</button></form>
            </div> 
            <div class="action_add_task">
              <form action="" method="post"><button name="add_task" type="submit" class="button small_button pull-right"><i class="fas fa-plus"></i></button></form>
            </div>
            <div class="tasks" id="tasks">

              <?php
                  if(!isset($_GET['status'])){
                    $sql="SELECT * from to_do where parent_task=0  and modpack_id=".$_SESSION['modpack_id']." ORDER BY  task_id  DESC"; 
                  }  elseif($_GET['status']){
                    $status=$_GET['status'];
                    if($status=='completed'){
                      $sql="SELECT * from to_do where modpack_id=".$_SESSION['modpack_id']." and is_completed=1 ORDER BY task_id DESC";
                    } elseif ($status=='active'){
                      $sql="SELECT * from to_do where modpack_id=".$_SESSION['modpack_id']." and is_completed=0 ORDER BY task_id DESC";
                    } elseif($status=="all"){
                        $sql="SELECT * from to_do where modpack_id=".$_SESSION['modpack_id']." and parent_task=0 ORDER BY  task_id  DESC";
                      }
                    }   
                
                  $result=mysqli_query($link, $sql);
                          
                  while ($row = mysqli_fetch_array($result)) {
                    $task_text=$row['task_text'];
                    $task_id=$row['task_id'];
                    $task_category_id=$row['cat_id'];
                    $task_modpack_id=$row['modpack_id'];
                    $is_completed=$row['is_completed'];
                    
                    $task_text=preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\">\\0</a>", $task_text);    
                            
                    
                    


                    echo "<div class='task' id='$task_id'>"; //task 
                      //echo "<div class='task_header'><span>Task id: ".$task_id."</span></div>";
                      echo "<div class='task_header'><span></span></div>";
                      echo "<div class='task_body'>$task_text</div>";
                      echo "<div class='task_footer'>";
                          
                          /*echo "<div class='task_id'>Task id: $task_id</div>"; 
                          echo "<div class='task_text'>$task_text</div>";*/
                          
                          $category_name=GetModName($task_category_id);
                          $modpack_name=GetModpackName($task_modpack_id);
                          
                          if($category_name<>""){
                            $category_name="<span class='span_mod'>".$category_name."</span>";
                          }
                          if ($modpack_name<>""){
                            $modpack_name="<span class='span_modpack'>".$modpack_name."</span>";
                          }
                          
                          //$mod_modpack.="".$category_name." ".$modpack_name."</div>";
                          
                          
                          if($is_completed==1){
                            
                            $task_completed="<span class='span_task_completed'>Complete</span>";
                            //$mod_modpack="<div class='mod_modpack'>".$mod_modpack." ".$task_completed."</div>";
                          // echo $mod_modpack;
                            $button_edit="";
                            $button_task_complete="";
                            
        
                          } elseif($is_completed==0){

                            $task_completed="";
                          
                            //
                            $button_edit="<button type='submit' name='edit_task' class='button small_button pull-right'><i class='fas fa-edit'></i></button>";
                            $button_task_complete="<button type='submit' name='complete_task' class='button small_button pull-right'><i class='fa fa-check'></i></button>";
                    
                            //echo $mod_modpack;
                            //echo "<div class='task_action'><form action='' method='post'><input type='hidden' name='task_id'  value='$task_id'>".$button_edit." ".$button_task_complete."</form></div>";
                          }
                          $mod_modpack="<div class='mod_modpack'>".$category_name." ".$modpack_name." ".$task_completed."</div>";
                          echo $mod_modpack;
                          echo "<div class='task_action'><form action='' method='post'><input type='hidden' name='task_id'  value='$task_id'>".$button_edit." ".$button_task_complete."</form></div>";
                    echo "</div>";//task_footer_wrap;  
                    echo "</div>";//task
                  }
                
                ?>       
             <div style="clear:both"></div>    
            </div><!--tasks -->
        </div><!--list -->
                  <?php


                      } elseif ($action=="notes"){
                        //echo "<script>alert('".$modpack_id."')</script>";   
                        echo "<script>alert('Notes')</script>";   
                       ?>
                        <div class="list">
            
                        <div class="search_wrap">
                          <form action="" method="GET">
                            <input type="text" name="search" placeholder="search string" autocomplete="off"><!--<button type="submit" class="button small_button"><i class="fa fa-search"></i></button>-->
                          </form>
                        </div>
                        
                        <div class="button_wrap"> 
                         <form action="" method="post">
                            <button name="add_note" type="submit" class="button small_button pull-right" title="New note"><i class="material-icons">note_add</i></button>
                            <button name="add_daily_note" type="submit" class="button small_button pull-right" title="Update_note"><i class="fa fa-plus"></i></button>
                          </form>
                         </div>  
            
                          <div id="note_list">
            
                           <?php    
                                if(isset($_GET['search'])){
                                  $search_string=$_GET['search'];
                                  $sql="SELECT * from notes where modpack_id=".$_SESSION['modpack_id']." and note_header like'%".$search_string."%' or  note_text like'%".$search_string."%' ORDER BY note_id DESC";
                                } else {
                                  $sql="SELECT * from notes where modpack_id=".$_SESSION['modpack_id']." ORDER BY note_id DESC";
                                }
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
                                      //$note_text=preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\">\\0</a>", $note_text);
            
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
                                          echo "<div class='mod_modpack'>".$category_name." ".$modpack_name."</div><div class='notes_action'><form method='post' action='' id='form' enctype='multipart/form-data'><input type='hidden' name=eis_note_id value=$eis_note_id><input type='hidden' name=note_id value=$note_id><button name='attach_pic' type='button' class='button app_badge' id='attach_image' onclick='open_dialog();'><i class='material-icons'>attach_file</i></button><input id='file_input' name='name' type='file' style='display:none' onchange='upload_file();'><button name='edit_note' type='submit' class='button app_badge'><i class='material-icons'>edit</i></button><button name='delete_note' type='submit' class='button app_badge'><i class='material-icons'>delete</i></button></form></div>";
                                        echo "</div>";//notes footer
                                      echo "</div>";
            
                                    }     
                            ?>     
                           </div><!-- note list--> 
                        </div><!--list -->
                       <?php
                      } else {

                      }
                    } else {

                      $modpack_name=GetModPackName($modpack_id);

                      $sql="SELECT modpack_name, modpack_description from modpacks where modpack_id=".$_SESSION['modpack_id'];
                      $result=mysqli_query($link, $sql);
                      $row = mysqli_fetch_array($result);
                      $modpack_description=$row['modpack_description'];
               
                      echo "<div id='modpack_title'>$modpack_name</div>";
                      echo "<div id='modpack_description'>$modpack_description</div>";                        

                    }

                    ?>
                </div>
                <script type="text/javascript">
                       modpack_info("dscription", 4)
                </script>
                <script>
                
                
                </script>
            </div>
            

            </div><!--content-->
        </div>    
    </div>  