<?php include "includes/dbconnect.php";
      include "includes/functions.php";

     
      if(isset($_POST['remove_note'])){
        global $link;
        $note_id=intval($_POST['note_id']);
        $query="DELETE from notes where note_id=$note_id";
        mysqli_query($link, $query);
        header('location:notes.php');
    
      }

      if(isset($_POST['add_note'])){
        header('location:note_add.php');
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
                          $note_header=$row['note_header'];
                          $note_text=$row['note_text'];
                          $note_mod=$row['cat_id'];
                          $note_modpack=$row['modpack_id'];
                          $note_text=preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\">\\0</a>", $note_text);

                          echo "<div class='note'>";
                            echo "<div class='note_header'><strong>".htmlspecialchars($note_header)."</strong></div>";
                            echo "<div class='note_text'>".nl2br(htmlspecialchars($note_text))."</div>";
                            
                            $category_name=GetModName($note_mod);
                            $modpack_name=GetModpackName($note_modpack);
                             
                            if($category_name<>""){
                              $category_name="<span class='span_mod'>".$category_name."</span>";
                            }
                            if ($modpack_name<>""){
                               $modpack_name="<span class='span_modpack'>".$modpack_name."</span>";
                            }
                            
                            echo "<div class='mod_modpack'>".$category_name." ".$modpack_name."</div>";
                        
                          
                          echo "</div>";

                        }     
                ?>     
               </div><!-- note list--> 
            </div><!--list -->
        </div><!-- content -->   