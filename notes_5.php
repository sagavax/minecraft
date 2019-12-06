<?php include "includes/dbconnect.php";
      include "includes/functions.php";

     
      if(isset($_POST['add_note'])){
        header('location:note_add.php');
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
      
        echo "<scritp>alert('You have deleted note with id: $note_id');
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
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
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
              <form action="" method="post"><button name="add_note" type="submit" class="button">+</button></form>
              <div id="note_list">
                <?php    
                    $sql="SELECT * from notes ORDER BY note_id DESC";
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
                          $note_text=preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\">\\0</a>", $note_text);

                          echo "<div class='note'>";
                            echo "<div class='note_header'><strong>".htmlspecialchars($note_header)."</strong></div>";
                            echo "<div class='note_text'>".nl2br(htmlspecialchars_decode(htmlspecialchars($note_text)))."</div>";
                            
                            $category_name=GetModName($note_mod);
                            $modpack_name=GetModpackName($note_modpack);
                             
                            if($category_name<>""){
                              $category_name="<span class='span_mod'>".$category_name."</span>";
                            }
                            if ($modpack_name<>""){
                               $modpack_name="<span class='span_modpack'>".$modpack_name."</span>";
                            }
                            
                            //echo "<div class='mod_modpack'>".$category_name." ".$modpack_name."</div>";
                        
                            echo "<div class='mod_modpack'>".$category_name." ".$modpack_name."</div><div class='notes_action'><form method='post' action=''><input type='hidden' name=eis_note_id value=$eis_note_id><input type='hidden' name=note_id value=$note_id><button name='edit_note' type='submit' class='button app_badge'>Edit</button><button name='delete_note' type='submit' class='button app_badge'>Delete</button></form></div>";
                          echo "</div>";

                        }     
                ?>     
               </div><!-- note list--> 
            </div><!--list -->
        </div><!-- content -->   