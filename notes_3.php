<?php include "includes/dbconnect.php";
      include "includes/functions.php";

     
      if(isset($_POST['add_note'])){
        header('location:note_add.php');
      }

      if(isset($_POST['add_daily_note'])){
        header('location:note_add.php?curr_date=now');
      }

      if(isset($_POST['edit_note'])){
          $note_id=$_POST['note_id'];
          header('location:note_edit.php?note_id='.$note_id);
      }
      

      if(isset($_POST['delete_note'])){
        $note_id = $_POST['note_id'];
         $sql="DELETE from notes where note_id=$note_id";
         mysqli_query($link, $sql) or die(mysqli_error($link));  
        
    
        //zapiseme do wallu 
        
         $diary_text="Minecraft IS: Bol vymazana poznamka s id <strong>$note_id</strong> v Minecraft IS";
        
        $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
        $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
        
      
        echo "<script>alert('Note with id: $note_id' has been deleted);
          window.location.href='notes.php';
        </script>";
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
    <script defer type="text/javascript" src="js/notes.js"></script>
    <script defer type="text/javascript" src="js/app_event_tracker.js"></script>
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
         


            <div class="button_wrap"> 
                <div class="sort_notes">
                  <button type="button" name="vanilla" class="button small_button">Vanilla</button>
                  <button type="button" name="modded" class="button small_button">Modded</button>
                  <button type="button" name="all" class="button small_button">All</button>
                 </div>
                 <div class="add_notes"> 
                    <button name="add_note" type="button" class="button small_button tooltip" title="New note"><i class="material-icons">note_add</i></button>
                    <button name="add_daily_note" type="button" class="button small_button tooltip" title="Daily update note"><i class="material-icons">note_add</i></button>
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
                              echo $category_name." ".$modpack_name."<div class='notes_action'><form method='post' action='notes_attach_file.php' enctype='multipart/form-data'><input type='hidden' name=note_id value=$note_id><button name='attach_image' type='button' class='button app_badge'><i class='material-icons'>attach_file</i><input type='file' name='image' id='file-attach-$note_id' accept='image/*' style='display:none'></button><button name='edit_note' type='submit' class='button app_badge'><i class='material-icons'>edit</i></button><button name='delete_note' type='submit' class='button app_badge'><i class='material-icons'>delete</i></button></form></div>";
                                echo "</div>";//notes footer
                                
                                    $get_files = "SELECT * from notes_file_attachements WHERE note_id=$note_id";
                                      //echo $get_files;
                                      $result_files = mysqli_query($link,$get_files) or (mysqli_error($link));
                                      if(mysqli_num_rows($result_files)>0){
                                          echo "<div class='note_attached_files'>";
                                          while($row_files = mysqli_fetch_array($result_files)){
                                          $file_name = $row_files['file_name'];
                                          $folderPath = "gallery/notes_attach_".$note_id;
                                          $file_id = $row_files['file_id'];
                                         echo "<i class='fas fa-file-image' data-open-modal title='$file_name' name='attached_image' file-name='$file_name'></i>";
                                          }
                                       echo "</div>";    
                                      }
                              echo "</div>";

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