<?php include "includes/dbconnect.php";
      include "includes/functions.php";

     
      if(isset($_POST['add_note'])){
        header('location:note_add.php');
      }

      if(isset($_POST['add_daily_note'])){
        header('location:note_add.php?curr_date=now');
      }

      if(isset($_POST['edit_note'])){
        if($_POST['eis_note_id']<>0){
          $eis_note_id=$_POST['eis_note_id'];
          header('location:https://eis.tmisura.sk/notepad/note_edit.php?note_id=$eis_note_id');
        } else {
          $note_id=$_POST['note_id'];
          header('location:note_edit.php?note_id='.$note_id);
        }
      }

      if(isset($_POST['delete_note'])){
        if(isset($_POST['eis_note_id'])){ // ak je definovane eis id tak to treba vymazat aj v EIS
          $eis_note_id=$_POST['eis_note_id'];
          //connect to other database eis database
          $link1 = mysqli_connect(null, "m91kz3te", "j3ZKwdShm2A", "eis", null, "/tmp/mariadb55.sock");  
          //delete note from the database in eis IS
         $sql="DELETE from tblcustomer_notes where note_id=$eis_note_id";
         mysqli_query($link1, $sql);  
         mysqli_close($link1);
        } 

        //a zmazeme v Minecraft IS
        $note_id=$_POST['note_id'];
        $sql="DELETE from notes where note_id=$note_id";   
        mysqli_query($link, $sql);  

        //zapiseme do wallu 
        $link1 = mysqli_connect(null, "brick_wall", "h3jSXv3gLf", "brick_wall", null, "/tmp/mariadb55.sock");
        $curr_date=date('Y-m-d H:i:s');
        //
        if($eis_note_id==0){
          $diary_text="Minecraft IS: Bol vymazana poznamka s id <strong>$note_id</strong> v Minecraft IS #minecraft_is";  
        } else {
         $diary_text="Minecraft IS: Bol vymazana poznamka s id <strong>$note_id</strong> v Minecraft IS a poznamka s id $eis_note_id v E.I.S #minecraft_id #eis";
        }
        $sql="INSERT INTO diary (diary_text, date_added,location,isMobile,is_read) VALUES ('$diary_text','$curr_date','',0,0)";
        $result = mysqli_query($link1, $sql) or die("MySQLi ERROR: ".mysqli_error($link1));
        mysqli_close($link1);
      
        echo "<script>alert('You have deleted note with id: $note_id');
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
  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
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
           
          <div class="list">
            
            <div class="search_wrap">
              <form action="" method="GET">
                <input type="text" name="search" onkeyup="search_the_string(this.value);" id="search_string" placeholder="search string" autocomplete="off"><!--<button type="submit" class="button small_button"><i class="fa fa-search"></i></button>-->
              </form>
            </div>
            
            <div class="button_wrap"> 
             <form action="" method="post">
                <button name="add_note" type="submit" class="button small_button pull-right" title="New note"><i class="material-icons">note_add</i></button>
                <button name="add_daily_note" type="submit" class="button small_button pull-right" title="Daily update note"><i class="material-icons">note_add</i></button>
              </form>
             </div>  

              <div id="notes_list">
                <?php    
                    if(isset($_GET['search'])){
                      $search_string=$_GET['search'];
                      $sql="SELECT * from notes where note_header like'%".$search_string."%' or  note_text like'%".$search_string."%' ORDER BY note_id DESC";
                    } else {
                      $sql="SELECT * from notes ORDER BY note_id DESC";
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
                              echo "<div class='mod_modpack'>".$category_name." ".$modpack_name."</div><div class='notes_action'><form method='post' action='' enctype='multipart/form-data'><input type='hidden' name=eis_note_id value=$eis_note_id><input type='hidden' name=note_id value=$note_id><button name='attach_pic' type='button' class='button app_badge id='attach_image'><i class='material-icons'>attach_file</i><input type='file' name='image' id='file-name' accept='image/*' style='display:none' id='flie-upload'></button><button name='edit_note' type='submit' class='button app_badge'><i class='material-icons'>edit</i></button><button name='delete_note' type='submit' class='button app_badge'><i class='material-icons'>delete</i></button></form></div>";
                            echo "</div>";//notes footer
                          echo "</div>";

                        }     
                ?>     
               </div><!-- note list-->
               <div style="clear:both"></div> 
            </div><!--list -->
        </div><!-- content -->   
        <script>
             function search_the_string(){
             var xhttp = new XMLHttpRequest();
             var search_text=document.getElementById("search_string").value;
             xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                document.getElementById("note_list").innerHTML =
                    this.responseText;
                       }
                    };
                xhttp.open("GET", "search_notes.php?search="+search_text, true);
                xhttp.send();
                           
            }
        </script>