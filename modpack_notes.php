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

          if (isset($_POST['note_add'])) {
              global $link;

              $note_header = mysqli_real_escape_string($link, $_POST['note_header']);
              $note_text = htmlentities(mysqli_real_escape_string($link, $_POST['note_text']));
              $modpack_id = $_POST['modpack'];

              if (empty($note_header) && empty($note_text)) {
                  echo "<script>alert('Nieco by si tam mal zadat'); window.location.href='note_add.php';</script>";
              } else {
                  $sql = "INSERT INTO notes (note_header, note_text, cat_id, modpack_id, added_date)
                          VALUES ('$note_header', '$note_text', $cat_id, $modpack_id, NOW())";

                  mysqli_query($link, $sql) or die(mysqli_error($link));

                  $sql = "SELECT LAST_INSERT_ID() as last_id FROM notes";
                  $result = mysqli_query($link, $sql);

                  while ($row = mysqli_fetch_array($result)) {
                      $last_note = $row['last_id'];
                  }

                  $modpack_name = GetModPackName($modpack_id);
                  $diary_text = empty($note_header)
                      ? "Bola vytvorena nova poznamka s id: <strong>$last_note</strong>"
                      : "Bola vytvorena nova poznamka s nazvom <strong>$note_header</strong>";

                  $sql = "INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', NOW())";
                  mysqli_query($link, $sql) or die("MySQLi ERROR: " . mysqli_error($link));

                  echo "<script>alert('Nova poznamka s id $last_note bola vytvorena'); window.location.href='notes.php';</script>";
              }
          }


          ?>
              <!-- <div class='modlist_mods_title'><h3><?php echo "Notes for the modpack ".GetModPackName($_GET['modpack_id']); ?></h3></div> -->
              
            <div id="new_note">
              <form action="" method="POST" accept-charset="utf-8">
                <input type="hidden" name="modpack_id" value="<?php echo $_GET['modpack_id'];?>"> 
                    <input type="text" name="note_header" placeholder="title" value="" autocomplete="off">
                    <textarea name="note_text" placeholder="new text here..."></textarea>
                
                <div class="note_action">
                    <button name='note_add' type='submit' class='button small_button'>Add</button>
                </div><!--- note action --->
               </form>    

            </div><!-- new note -->

              <!-- <div class="add_notes"> 
                    <button name="add_note" type="button" class="button small_button tooltip" title="New note"><i class="fa fa-plus"></i></button>              
                 </div>   
              </div>   -->
          
           
              <div class="search_wrap">
                <input type="text" name="search" onkeyup="search_note(this.value);" id="search_string" autocomplete="off" placeholder="search notes here"><button type="button" title="clear search" class="button small_button tooltip>"><i class="fa fa-times"></i></button>
              </div><!-- Search wrap-->
           
              <div id="notes_list">
                <?php    
                   
                   $get_notes="SELECT * from notes where modpack_id=".$_GET['modpack_id']." ORDER BY note_id DESC";
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
                          $note_mod=$row['cat_id'];
                          $note_modpack=$row['modpack_id'];
                          //$note_text=preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\">\\0</a>", $note_text);

                          echo "<div class='note' note-id='$note_id'>";
                            echo "<div class='note_header'><strong>".htmlspecialchars($note_header)."</strong></div>";
                            echo "<div class='note_text'>".convertLinks(html_entity_decode($note_text))."</div>";
                            
                            if($note_mod!=0){
                              $category_name=GetModName($note_mod);
                              $category_name="<button class='span_mod'>".$category_name."</button>";
                            } else {
                               $category_name= "<button class='span_mod' type='button' name='add_mod' title='add mod'><i class='fa fa-plus'></i></button>";
                            }
                            
                            
                           
                            if($note_modpack==0){
                              $modpack_name= "<button class='span_mod' type='button' name='add_modpack'><i class='fa fa-plus'></i></button>";
                            } else {
                              $modpack_name=GetModpackName($note_modpack);
                               $modpack_name="<button class='span_modpack' type='button' name='change_modpack' modpack-id=$note_modpack>".$modpack_name."</button>";
                            }


                            //echo "<div class='mod_modpack'>".$category_name." ".$modpack_name."</div>";
                            echo "<div class='note_footer'>";
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
                      echo "</div>"; //note       
                        }    
                  ?>     
                 
               </div><!-- note list-->