<?php include("../includes/dbconnect.php");
      include ("../includes/functions.php");


/*  if(isset($_POST['new_note'])){
    
 }


 if(isset($_POST['new_task'])){
   
 }

  if(isset($_POST['new_idea'])){
     $note_text=mysqli_real_escape_string($link, $_POST['note_text']);   
     $base_id+$_POST['base_id'];
     $idea_title = $_POST['idea_title'];
     $idea_text = $_POST['idea_text'];
     
     $add_idea="INSERT INTO vanila_base_ideas (base_id, idea_title, idea_text, added_date) VALUES ($base_id,'$idea_title',$idea_text',now())";
     $result=mysqli_query($link, $add_idea);
 } */


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css?<?php echo time(); ?>">
    
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1//css/all.css">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="../js/vanila_base.js" defer></script>
    <link rel="icon" type="image/png" sizes="32x32" href="../favicon-32x32.png">
</head>
<body>

<?php include("../includes/header.php") ?> 
    <div class="main_wrap">
         <div class="tab_menu">
             <?php include("../includes/menu.php"); ?>
         </div>

         <div class="content">
            <div class="list">
                <div class="base">
                    <?php 
                        $base_id = $_GET['base_id'];
                        $sql="SELECT * from vanila_bases where base_id=$base_id";
                        $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
                        $row = mysqli_fetch_array($result);    
                    ?>
                        <div id="basic_base_info">
                            <!--<input type="hidden" name="base_id" value="<?php echo $row['base_id']; ?>">-->
                            <input name="base_name" type="text" placeholder="name your base..." value="<?php echo $row['base_name']; ?>">
                            <title>Vanila base - <?php echo $row['base_name']; ?> </title>
                            <textarea name="description" placeholder="Describe your base somehow..."><?php echo $row['base_description']?></textarea>
                        </div>    
                        <div id="base_location">
                            <div id="base_outworld_location"><h4>Base location:</h4>
                                <div class="base_coord_wrap">
                                    <div class="base_coord" ><span>X:</span><input type="number" placeholder="X" value="<?php echo $row['X']; ?>" name="outworld_z" autocomplete="off"></div>
                                    <div class="base_coord"><span>Y:</span><input type="number" placeholder="Y" value="<?php echo $row['Y']; ?>" name="outworld_z" autocompletee="off"></div>
                                    <div class="base_coord"><span>Z:</span><input type="number" placeholder="Z" value="<?php echo $row['Z']; ?>" name="outworld_z" autocomplete="off"></div>
                                </div>
                            </div><!-- base outworld location -->
                            <div id="base_nether_location"><h4>Base nether location:</h4>
                            <div class="base_coord_wrap">    
                                <div class="base_coord"><span>X:</span><input type="number" placeholder="X" value="<?php echo $row['nether_X']; ?>" name="nether_x" name="nether_x" autocomplete="off"></div>
                                <div class="base_coord"><span>Y:</span><input type="number" placeholder="Y" value="<?php echo $row['nether_Y']; ?>" name="nether_y" name="nether_y" autocomplete="off"></div>
                                <div class="base_coord"><span>Z:</span><input type="number" placeholder="Z" value="<?php echo $row['nether_Z']; ?>"  name="nether_z" name="nether_z" autocomplete="off"></div>
                                </div>  
                            </div><!-- base netherlocation -->
                        </div><!-- base location-->    
                        <div class="base_action"><a class="button" href="vanilla_bases.php">Back</a></div>
                    </form>
                 </div><!-- add new base -->
                 <div class="base_wall">
                     <div class="base_wall_tabs">
                         <button data-tab="Notes" class="button small_button">Notes</button>
                        <button data-tab="Tasks" class="button small_button">Tasks</button>
                        <button data-tab="Ideas" class="button small_button">Ideas</button>
                        <button data-tab="Images" class="button small_button">Images</button>  
                     
                    </div><!-- add new note wrap-->
                    
                     <div id="notes">
                        <div class="new_base_note">
                            <input name="" type="text" id="base_note_title" value="" autocomplete="off" spellcheck="false" placeholder="note title...">
                            <textarea name="" id="base_note_text" placeholder="note text..."></textarea>
                            <button class="button rounded_button" name="new_base_note">New note</button>
                        </div>
                        <div class="base_notes_list">
                            <?php 
                                $sql="SELECT * from vanila_base_notes WHERE base_id = $base_id ORDER BY note_id  DESC";
                                $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

                                 if(mysqli_num_rows($result)==0){
                                    echo "<div class='info_message'>No notes available....</div>";
                                } else {
                                while($row = mysqli_fetch_array($result)){
                                    $id = $row['note_id'];
                                    $note_text = $row['note_text'];
                                    $note_title = $row['note_title'];
                                    $added_date = $row['added_date'];

                                    echo "<div class='base_note' note-id=$id>";
                                        echo "<div class='vanila_note_title'>".$note_title."</div>";
                                        echo "<div class='vanila_note_text'>".$note_text."</div>";
                                        echo "<div class='vanila_note_act'><button class='button small_button' name='delete_note'><i class='fa fa-times' title='Delete note'></i></button></div>";
                                    echo "</div>";
                                };    
                               } 
                            ?>
                        </div><!--base notes list-->    
                     </div><!-- notes --> 

                     <div id="tasks">
                        <div class="new_base_task">
                            <input name="" type="text" id="base_task_title" value="" autocomplete="off" spellcheck="false" placeholder="task title...">
                            <textarea name="" id="base_task_text" placeholder="task text..."></textarea>
                            <button class="button rounded_button" name="new_base_task">New task</button>
                        </div>
                        <div class="base_tasks_list">    
                            <?php
                                $sql="SELECT * from vanila_base_tasks where base_id = $base_id and is_completed=0 ORDER BY task_id DESC";
                                $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
                                if(mysqli_num_rows($result)==0){
                                    echo "<div class='info_message'>No tasks available....</div>";
                                } else {
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
                                                echo "<button type='button' name='complete_task' class='button small_button pull-right'><i class='fa fa-check'></i></button>";
                                            }
                                          echo "</div>";  
                                    echo "</div>"; //footer
                                echo "</div>";// task
                            }   
                        }
                         ?>
                        </div><!--base tasks list-->            
                    </div><!-- tasks -->

                    <div id="ideas"><!-- ideas -->
                        <div class="new_base_idea">
                            <input type="text" name="base_idea_title" value="" autocomplete="off" spellcheck="false" placeholder="idea title...">
                            <textarea name="" placeholder="idea text..." name="base_idea_text"></textarea>
                            <button class="button rounded_button" name="new_base_idea">New idea</button>
                        </div>
                        <div class="base_ideas_list">
                            <?php
                                $sql="SELECT * from vanila_base_ideas where base_id = $base_id ORDER BY idea_id DESC";

                                $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
                                 if(mysqli_num_rows($result)==0){
                                    echo "<div class='info_message'>No ideas available....</div>";
                                } else {
                                while($row = mysqli_fetch_array($result)){
                                    $idea_id = $row['idea_id'];
                                    $idea_title = $row['idea_title'];
                                    $idea_text = $row['idea_text'];
                                    $idea_text=preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\">\\0</a>", $idea_text);
                                    echo "<div class='idea vanilla_idea' idea-id=$idea_id>"; //task
                                    echo "<div class='base_idea_title'>$idea_title</div>";
                                    echo "<div class='base_idea_body'>$idea_text</div>";
                                    echo "<div class='base_idea_footer'>";
                                         echo "<div class='vanila_note_act'><button class='button small_button' name='delete_idea';'><i class='fa fa-times' title='Delete idea'></i></button></div>";
                                    echo "</div>"; //footer
                                echo "</div>";// idea
                             }   
                           }
                           ?> 
                        </div><!-- base ideas list -->       
                    </div><!-- ideas -->

                    <div id="images"><!--images -->
                      <div class="new_base_image"> 
                        <form action="base_image_upload.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="base_id" value=<?php echo $base_id ?>>
                            <input type="file" name="file">
                            <button type="submit" name="submit" class="button">Upload</button>
                        </form>
                       </div>      
                       
                       <div class="base_images_list">
                            <!-- get list of images -->
                            <?php
                                $get_base_images = "SELECT * from vanila_base_images WHERE base_id=$base_id";
                                $result = mysqli_query($link, $get_base_images) or die("MySQLi ERROR: ".mysqli_error($link));
                                while($row = mysqli_fetch_array($result)){
                                    $img_id = $row['img_id'];
                                    $image_name = $row['image_name'];
                                    //echo $image_name;
                                    echo "<div class='base_image'image-id=$img_id >"; //base_image
                                        echo "<img src='gallery/base_".$base_id."/".$image_name."'>";
                                         echo "<div class='image_action'>";
                                            echo "<button name='add_tag' type='button' class='button small_button' title='Add tagg'><i class='fas fa-tag'></i></button><button name='add_comment' type='button' class='button small_button' title='Add new comment'><i class='fa fa-comment'></i></button><button name='view_image' type='button'class='button small_button' title='View image'><i class='fa fa-eye'></i></button><button name='delete_image' type='button' class='button small_button' title='Delete picture'><i class='fa fa-times'></i></button>";
                                        echo "</div>";//image action
                                    echo "</div>"; //base image
                                }    
                             ?>   
                        </div><!-- image list -->
                    </div><!-- images -->
                   
                 </div><!-- base wall -->
                 
                </div><!-- list --> 
                
             </div><!-- content -->
       </div><!-- main_wrap -->    
       <dialog class="base_image_comment">
            <input type="text" placeholder="type comment here ...">
        </dialog>
        
        <dialog class="base_image_tag">
            <button type="button"><i class='fa fa-plus'></i></button>
        </dialog>

        <dialog class="base_image_full_view">
             <div class="modal-content">
                <div class="image-container">
                    <img src="">
                 </div>    
                <div class="comments-container">
                    <div class="input-container">
                        <input type="text" placeholder="write comment_here"><button type='button' class="button small_button"><i class='fa fa-plus'></i></button>
                    </div>
                    <div class="image_comment"></div>
                </div>
             </div>   
        </dialog>
     </body>
</html>