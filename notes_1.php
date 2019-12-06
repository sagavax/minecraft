<?php include "includes/dbconnect.php";
      include "includes/functions.php";

      if(isset($_POST['note_add'])) {
        global $link;
        $note_header=mysqli_real_escape_string($link, $_POST['note_header']);
        $note_text=mysqli_real_escape_string($link, $_POST['note_text']);
        $added_date=date('Y-m-d');
        $sql="INSERT into notes (note_header, note_text, added_date) VALUES ('$note_header', '$note_text', '$added_date')";
        mysqli_query($link,$sql);

        //ziskat id posledne vytvorenej poznamky
        $sql="SELECT LAST_INSERT_ID() as last_id from diary";
        $result=mysqli_query($link, $sql);
        while ($row = mysqli_fetch_array($result)) {          
          $last_note=$row['last_id'];
        } 

        //vlozit do wallu 
        $link1 = mysqli_connect(null, "brick_wall", "h3jSXv3gLf", "brick_wall", null, "/tmp/mariadb55.sock");
        //$link1=mysqli_connect("localhost", "root", "", "brick_wall");
        if($note_header==""){
          $diary_text="Minecraft IS: Bola vytvorena nova poznamka s id: <strong>$last_note</strong>";  
        } else {
          $diary_text="Minecraft IS: Bola vytvorena nova poznamka s nazvom <strong>$video_name</strong>";
        }
        
        $curr_date=date('Y-m-d H:i:s');
        $sql="INSERT INTO diary (diary_text, date_added,location,isMobile,is_read) VALUES ('$diary_text','$curr_date','',0,0)";
        $result = mysqli_query($link1, $sql) or die("MySQLi ERROR: ".mysqli_error($link1));
        mysqli_close($link1);
 


        header('location:notes.php');
    
      }

      if(isset($_POST['remove_note'])){
        global $link;
        $note_id=intval($_POST['note_id']);
        $query="DELETE from notes where note_id=$note_id";
        mysqli_query($link, $query);
        header('location:notes.php');
    
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
                <div id="new_note">
                    <form action="" method="POST">
                        <input type="text" name="note_header">
                        <textarea name="note_text"></textarea>
                        <div class="action"><button name='note_add' type='submit' class='button pull-right'>Add</button></div>
                    </form>    
                </div><!--new note form -->
               
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
                          $note_header=$row['note_header'];
                          $note_text=$row['note_text'];
                          $note_text=preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\">\\0</a>", $note_text);

                          echo "<div class='note'>";
                            echo "<div class='note_header'></div>";
                            echo "<div class='note_text'><strong>$note_header</strong>.$note_text</div>";
                          echo "</div>";

                        }     
                ?>     
               </div><!-- note list--> 
            </div><!--list -->
        </div><!-- content -->   