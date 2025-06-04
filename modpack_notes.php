<?php include("includes/dbconnect.php");
      include("includes/functions.php");
  session_start();
 ?>
              <div class='modlist_mods_title'><h3><?php echo "Notes for the modpack ".GetModPackName($_GET['modpack_id']); ?></h3></div>
              
               <div class="search_wrap">
                <input type="text" name="search" onkeyup="search_note(this.value);" id="search_string" autocomplete="off" placeholder="search notes here"><button type="button" title="clear search" class="button small_button tooltip>"><i class="fa fa-times"></i></button>
              </div><!-- Search wrap-->
         
            <div id="new_note">
              <div class="new_note_header">
                <button class="button small_button" name="clear_input" type="button">New note</button><i class="fa fa-times"></i></button>
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
                                  echo "<div class='notes_action'>".$category_name." ".$modpack_name."<form method='post' action='notes_attach_file.php' enctype='multipart/form-data'><input type='hidden' name=note_id value=$note_id><input type='file' name='image' id='file-attach-$note_id' accept='image/*' style='display:none'></form><button name='attach_image' type='button' class='button small_button'><i class='material-icons'>attach_file</i></button><button name='edit_note' type='submit' class='button small_button'><i class='material-icons'>edit</i></button><button name='delete_note' type='submit' class='button small_button'><i class='material-icons'>delete</i></button></div>";

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