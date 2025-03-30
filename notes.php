<?php 
     header("Access-Control-Allow-Origin: *");
     header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
     header("Access-Control-Allow-Headers: Content-Type, Authorization");
     
     if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
         http_response_code(200);
         exit();
     }
     
     include "includes/dbconnect.php";
     include "includes/functions.php";
     
      if(isset($_POST['note_add'])) {
        global $link;
    
                $note_header=mysqli_real_escape_string($link, $_POST['note_header']);
                $note_text=htmlentities(mysqli_real_escape_string($link, $_POST['note_text']));
                $modpack_id=$_POST['modpack'];
            
           
                echo $modpack_id;

                if(($note_header=="") && ($note_text=="")){
                    echo "<script>alert('Nieco by si tam mal zadat');
                    window.location.href='note_add.php';
                    </script>";
                } else {
        
       $cat_id=0;
       
        $sql="INSERT into notes (note_header,note_text,cat_id, modpack_id, added_date) VALUES ('$note_header', '$note_text',$cat_id,$modpack_id,now())";
        //echo $sql;
        mysqli_query($link,$sql) or die(mysqli_error($link));
        //ziskat id posledne vytvorenej poznamky
        $sql="SELECT LAST_INSERT_ID() as last_id from notes";
        $result=mysqli_query($link, $sql);
        while ($row = mysqli_fetch_array($result)) {          
          $last_note=$row['last_id'];
        } 

        //vlozit do wallu 
        if(isset($_POST['publish_to_wall'])){//chcem zverejnit text poznamky do wallu, nielen informaciu ze sprava bola vytvorena
          
            $modpack_name = GetModPackName($modpack_id);
            $diary_text="Minecraft: <strong>".$modpack_name."</strong> ".$note_header." ".$note_text;
          
         } else { //ak poznamka nieje urcena na zverejnenie tak sa zobrazi len informacia o tom,ze sa nejaka poznamka vytvorila
        
        
        if($note_header==""){
          $diary_text="Minecraft IS: Bola vytvorena nova poznamka s id: <strong>$last_note</strong>";  
        } else {
          $diary_text="Minecraft IS: Bola vytvorena nova poznamka s nazvom <strong>$note_header</strong>";
            }
        }
        
        
        $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
        //echo $sql;
        $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
        
       echo "<script>alert('Nova poznamka s id $last_note bola vytvorena');
        window.location.href='notes.php';
        </script>";
        }  
      }

  ?>
 
 
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minecraft IS</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <!-- <link rel="stylesheet" type="text/css" href="http://www.tinymce.com/css/codepen.min.css"> -->
    <script defer type="text/javascript" src="js/notes.js"></script>
    <!-- <script defer type="text/javascript" src="js/app_event_tracker.js"></script> -->
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  </head>
  
  <body>
  <?php
     echo "<script>sessionStorage.setItem('current_module','notes')</script>";
     include("includes/header.php") ?>
      <div class="main_wrap">
      <div class="tab_menu">
          <?php include("includes/menu.php"); ?>
        </div>
        
        <div class="content">
           
          <div class="list">
            
            <div class="search_wrap">
                <input type="text" name="search" onkeyup="search_note(this.value);" id="search_string" autocomplete="off" placeholder="search notes here"><button type="button" title="clear search" class="button small_button tooltip>"><i class="fa fa-times"></i></button>
              </div><!-- Search wrap-->
         
            <div id="new_note">
              <div class="new_note_header">
                <button class="button small_button"><i class="fa fa-times"></i></button>
            </div><!--new note header -->
            
            <form action="" method="POST" accept-charset="utf-8">
                          <div id="note_title">
                              <input type="text" name="note_header" placeholder="title" value="<?php 
                                  if(isset($_GET['curr_date'])){
                                      $date=$_GET['curr_date'];{
                                          if($date=="now"){
                                              echo "Update status :".date('Y-m-d H:i:s');
                                          } else {
                                              echo "";
                                          }
                                      }
                                  }
                              ?>">
                          </div><!-- note title -->
                          <div id="note_text">    
                              <textarea name="note_text" placeholder="new text here..."></textarea>
                          </div><!--- note text --->    
                          <div id="new_note_footer">
                              <div id="note_options">
                                      <select name="modpack">
                                  <?php 
                                  //echo "modpack:".$modpack_id;
                                  
                                  echo "<option value=0> -- Select modpack -- </option>";
                                  $sql="SELECT * from modpacks ORDER BY modpack_id ASC";
                                  $result=mysqli_query($link, $sql);
                                  while ($row = mysqli_fetch_array($result)) {
                                      $modpack_id=$row['modpack_id'];
                                      $modpack_name=$row['modpack_name'];
                                  echo "<option value=$modpack_id>$modpack_name</option>";
                                  }	
                              ?>
                          </select> 
                          
                          
                              <input type="checkbox" name="publish_to_wall" id="publish_to_wall" checked="checked"><label for="publish_to_wall">Publikovat na wall</label>
                              
                          </div><!--- note options  --->
                          </div><!--- new note footer  ---> 
                          <div id="note_action">
                              <button name='note_add' type='submit' class='button small_button'>Add</button>
                          </div><!--- note action --->
                        </form>    

            </div><!-- new note -->

            <div class="button_wrap"> 
                <div class="sort_notes">
                  <button type="button" name="vanilla" class="button small_button">Vanilla</button>
                  <button type="button" name="modded" class="button small_button">Modded</button>
                  <button type="button" name="all" class="button small_button">All</button>
                 </div>
                 <div class="add_notes"> 
                    <button name="add_note" type="button" class="button small_button tooltip" title="New note"><i class="fa fa-plus"></i></button>              
                 </div>   
              </div>  

              <div id="notes_list">
                <?php    
                    $itemsPerPage = 10;

                    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $offset = ($current_page - 1) * $itemsPerPage;  


                    $sql="SELECT * from notes ORDER BY note_id DESC LIMIT $itemsPerPage OFFSET $offset";
                    
                    $result=mysqli_query($link, $sql);
                        while ($row = mysqli_fetch_array($result)) {  
                          if(empty($row['note_header'])){
                            $note_header="";
                          } else {
                            $note_header="<b>".$row['note_header']."</b>. ";
                          }
                          $note_id=$row['note_id'];
                          $note_header=$row['note_header'];
                          $note_text=$row['note_text'];
                          $note_mod=$row['cat_id'];
                          $note_modpack=$row['modpack_id'];
                          //$note_text=preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\">\\0</a>", $note_text);

                          echo "<div class='note' note-id='$note_id'>";
                            echo "<div class='note_header'><strong>".htmlspecialchars($note_header)."</strong></div>";
                            echo "<div class='note_text'>".convertLinks(html_entity_decode($note_text))."</div>";
                            
                            $category_name=GetModName($note_mod);
                            $modpack_name=GetModpackName($note_modpack);
                             
                            if($category_name<>""){
                              $category_name="<div class='span_mod'>".$category_name."</div>";
                            }
                            if ($modpack_name<>""){
                               $modpack_name="<div class='span_modpack'>".$modpack_name."</div>";
                            }
                            
                            //echo "<div class='mod_modpack'>".$category_name." ".$modpack_name."</div>";
                            echo "<div class='note_footer'>";
                                  echo $category_name." ".$modpack_name."<div class='notes_action'><form method='post' action='notes_attach_file.php' enctype='multipart/form-data'><input type='hidden' name=note_id value=$note_id><input type='file' name='image' id='file-attach-$note_id' accept='image/*' style='display:none'></form><button name='attach_image' type='button' class='button small_button'><i class='material-icons'>attach_file</i></button><button name='edit_note' type='submit' class='button small_button'><i class='material-icons'>edit</i></button><button name='delete_note' type='submit' class='button small_button'><i class='material-icons'>delete</i></button></div>";

                                  echo "<div class='note_attached_files'>";
                                  $get_files = "SELECT * from notes_file_attachements WHERE note_id=$note_id";
                                    //echo $get_files;
                                    $result_files = mysqli_query($link,$get_files) or (mysqli_error($link));
                                    
                                    while($row_files = mysqli_fetch_array($result_files)) {
                                      $file_name = htmlspecialchars($row_files['file_name']);
                                      $file_id = (int)$row_files['file_id'];
                                      $folderPath = "gallery/notes_attach_" . $note_id;
                                      
                                      echo "<i class='fas fa-file-image' 
                                               data-open-modal 
                                               data-file-name='$file_name'
                                               data-file-id='$file_id' 
                                               title='$file_name'
                                               data-name='attached_image'
                                               ></i>";
                                  }
                                  echo "</div>";//attached images       
                         echo "</div>";//note footer
                      echo "</div>"; //note       
                        }    
                ?>     
                 
               </div><!-- note list-->
                 <?php
                // Calculate the total number of pages
                $count_tasks = "SELECT COUNT(*) as total FROM notes";
                $result=mysqli_query($link, $count_tasks);
                $row = mysqli_fetch_array($result);
                $totalItems = $row['total'];
                $totalPages = ceil($totalItems / $itemsPerPage);

                // Display pagination links
                echo '<div class="pagination">';
                for ($i = 1; $i <= $totalPages; $i++) {
                  echo '<a href="?page=' . $i . '" class="button app_badge">' . $i . '</a>';
                }
                echo '</div>';
                ?> 
            </div><!--list -->
        </div><!-- content -->   
        </div><!-- main wrao -->
        <dialog data-modal class="modal_image">
          <div class="modal_image_action"><button type='button'><i class='fa fa-times'></i></button></div>
          <div class="image_content"></div>
        </dialog>
    </body>
</html>    