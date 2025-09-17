 
<?php include "includes/dbconnect.php";
      include "includes/functions.php";

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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <!-- <link rel="stylesheet" type="text/css" href="http://www.tinymce.com/css/codepen.min.css"> -->
    <script defer type="text/javascript" src="js/notes.js"></script>
    <!-- <script defer type="text/javascript" src="js/app_event_tracker.js"></script> -->
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  </head>
  
  <body>
  <?php
         include("includes/header.php") ?>
      <div class="main_wrap">
      <div class="tab_menu">
          <?php include("includes/menu.php"); ?>
        </div>
        
        <div class="content">
           
          <div class="list">
            
            <div class="search_wrap">
                <input type="text" name="search" id="search_string" autocomplete="off" placeholder="search notes here"><button type="button" name="clear_search" title="clear search" class="button small_button tooltip>"><i class="fa fa-times"></i></button>
              </div><!-- Search wrap-->
         
            <div id="new_note">
              <div class="new_note_header">
                <button class="button small_button"><i class="fa fa-times"></i></button>
            </div><!--new note header -->
            
            <form action="note_add.php" method="POST" accept-charset="utf-8">
                    <input type="text" name="note_title" placeholder="title" value="" autocomplete="off">
                    <textarea name="note_text" placeholder="new text here..."></textarea>
                     <select name="modpack">
                        <?php 
                        //echo "modpack:".$modpack_id;
                        
                        echo "<option value=0> -- Select modpack -- </option>";
                        $sql="SELECT * from modpacks ORDER BY modpack_id ASC";
                        $result=mysqli_query($link, $sql) or die(mysql_error());
                        while ($row = mysqli_fetch_array($result)) {
                            $modpack_id=$row['modpack_id'];
                            $modpack_name=$row['modpack_name'];
                        echo "<option value=$modpack_id>$modpack_name</option>";
                        }	
                     ?>
                    </select> 
                
                  <div class="note_action">
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


                    $get_notes="SELECT  a.note_id, a.note_header,  a.note_text, a.added_date, b.modpack_id FROM notes AS a
INNER JOIN notes_modpacks AS b ON a.note_id = b.note_id ORDER BY a.note_id DESC LIMIT $itemsPerPage OFFSET $offset";

                      echo $get_notes;
                    $result=mysqli_query($link, $get_notes) or die("MySQLi ERROR: ".mysqli_error($link));
                        while ($row = mysqli_fetch_array($result)) {  
                          if(empty($row['note_header'])){
                            $note_header="";
                          } else {
                            $note_header="<b>".$row['note_header']."</b>. ";
                          }
                          $note_id=$row['note_id'];
                          $note_header=$row['note_header'];
                          $note_text=$row['note_text'];
                          $note_modpack=$row['modpack_id'];
                          $note_text=preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\">\\0</a>", $note_text);
                          if(!isset($cat_id)){
                            $note_mod=0;
                          } else {
                            $note_mod=$cat_id;
                          }
                          
                          

                          echo "<div class='note' note-id='$note_id'>";
                            echo "<div class='note_header'><strong>".htmlspecialchars($note_header)."</strong></div>";
                            echo "<div class='note_text'>".convertLinks(html_entity_decode($note_text))."</div>";
                            
                            if($note_mod!=0){
                              $category_name=GetModName($note_mod);
                              $category_name="<button class='span_mod'>".$category_name."</button>";
                            } else {
                               $category_name= "<button class='span_mod' type='button' name='change_mods' title='add mod'><i class='fa fa-plus'></i></button>";
                            }
                            
                            
                           
                            if($note_modpack==0){
                              $modpack_name= "<button class='span_mod' type='button' name='change_modpack' title='add modpack'><i class='fa fa-plus'></i></button>";
                            } else {
                              $modpack_name=GetModpackName($note_modpack);
                               $modpack_name="<button class='span_modpack' type='button' name='change_modpack' modpack-id=$note_modpack>".$modpack_name."</button>";
                            }


                            //echo "<div class='mod_modpack'>".$category_name." ".$modpack_name."</div>";
                            echo "<div class='note_footer'>";
                               echo "<div class='note_coord'>".GetNotesCoordinates($note_id)."</div>";
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
                                  
                                  //notes actions
                                  echo "<div class='notes_action'>".$category_name." ".$modpack_name."<form method='post' action='notes_attach_file.php' enctype='multipart/form-data'><input type='hidden' name=note_id value=$note_id><input type='file' name='image' id='file-attach-$note_id' accept='image/*' style='display:none'></form><button name='attach_image' type='button' class='button small_button'><i class='material-icons'>attach_file</i></button><button name='edit_note' type='submit' class='button small_button'><i class='material-icons'>edit</i></button><button name='delete_note' type='submit' class='button small_button'><i class='material-icons'>delete</i></button></div>";
                         echo "</div>";//note footer
                         //echo "<div class='note_coord'><input type ='text' name='coord_x' placeholder='X' autocomplete='off'><input type ='text' name='coord_y' placeholder='Y' autocomplete='off'><input type ='text' name='coord_z' placeholder='Z' autocomplete='off'></div>";
                         
                  
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

        <dialog class="dialog_modpacks">
          <div class="inner_modpacks_layer">
                  <?php 
                    echo GetListModpacks();

                  ?>
              </div>
        </dialog>

    <dialog class="dialog_mods">
       <div id="letter_list">
          <?php
             foreach (range('A', 'Z') as $char) {
                echo "<button class='button small_button blue_button rounded_button' name='char'>$char</button>";
                 }                            
           ?>        
        </div>
        <intput type="text" name="search" placeholder="Search mods...." autocomplete="off"> 
        <div class="notes_mods_list">
         <?php
            $get_mods = "SELECT * FROM mods WHERE cat_name like 'A%'";
            $result = mysqli_query($link, $get_mods);
            while ($row = mysqli_fetch_array($result)) {
                $mod_name = $row['cat_name'];
                $mod_id = $row['cat_id'];
                echo "<button mod-id=$mod_id class='button small_button blue_button rounded_button' name='add_mod'>$mod_name</button>";
            }
            //echo GetAllUnassignedNotesMods();
          ?>
        </div>
    </dialog>

    <dialog class="modal_add_coordinates">
      <div class="inner_layer">
        <div class="inner_layer_flex_row">
        <!-- <button type="button" class="close_inner_modal"><i class="fa fa-times"></i></button> -->
        <input type="text" name="coord_x" placeholder="X" autocomplete="off">
        <input type="text" name="coord_y" placeholder="Y" autocomplete="off">
        <input type="text" name="coord_z" placeholder="Z" autocomplete="off">
        <button type="button" name="set_coordinates" class="button small_button"><i class="fa fa-plus"></i></button>
        </div>
      </div>
    </dialog>          

    </body>
</html>    