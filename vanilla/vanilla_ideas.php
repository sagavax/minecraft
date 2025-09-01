<?php
      include(include "../includes/dbconnect.php");
      include ("includes/functions.php");


      if(isset($_POST['save_base_idea'])){
        $base_id = $_POST['base'];
        $title = mysqli_real_escape_string($link, $_POST['idea_title']);
        $text = mysqli_real_escape_string($link,$_POST['idea_text']);

        $save_idea="INSERT into vanila_base_ideas (base_id, idea_title, idea_text,added_date) VALUES ($base_id, '$title','$text',now())";
        $result=mysqli_query($link, $save_idea);

        echo "<script>alert('new idea has been added');
            window.location.href='vanilla_ideas.php';
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
    <!--<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>-->
    <link rel="stylesheet" href="../css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/../css/all.css">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script type="text/javascript" src="../js/vanilla_ideas.js" defer></script>
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">

    <body>
         <?php include("../includes/header.php") ?>
         <div class="tab_menu">
             <?php include("../includes/vanila_menu.php") ?>
         </div>
         
         <div class="main_wrap">
            <div class="content">
            <div class="list">
            <div class="new_base_idea">
             <form action="" method="post">
                 <input type="text" name="idea_title" autocomplete="off" placeholder="idea title here...">
                 <textarea id="new_note" placeholder="Add new idea here ...." name="idea_text"></textarea>
                 <select name="base">
                     <!--<option value="0">------ Chose the base -------</option>-->
                     <option value="1">hlavna zakladna</option>

                     <?php 
                        $get_bases = "SELECT * from vanila_bases";
                        $result_bases = mysqli_query($link, $get_bases) or die("MySQLi ERROR: ".mysqli_error($link));
                        while($row_bases = mysqli_fetch_array($result_bases)){
                            $base_id = $row_bases['base_id'];
                            $base_name =$row_bases['base_name'];
                            echo "<option value=$base_id>$base_name</option>";
                         }   
                     ?>
                 </select>
                 <button type="submit" class="button small_button" name="save_base_idea"><i class="fa fa-plus"></i></button>
             </form>   
           </div> 

           <div class="sort_bases">
                <?php 
                        $get_bases = "SELECT * from vanila_bases";
                        $result_bases = mysqli_query($link, $get_bases) or die("MySQLi ERROR: ".mysqli_error($link));
                        while($row_bases = mysqli_fetch_array($result_bases)){
                            $base_id = $row_bases['base_id'];
                            $base_name =$row_bases['base_name'];
                            echo "<button type='button' class='button small_button' btn-id=$base_id>$base_name</button>";
                         }   
                     ?>  
           </div>

           <div class="base_ideas_list">
                <?php
                    $sql="SELECT * from vanila_base_ideas ORDER BY idea_id DESC";

                    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
                    while($row = mysqli_fetch_array($result)){
                        $idea_id = $row['idea_id'];
                        $idea_text = $row['idea_text'];
                        $base_id = $row['base_id'];

                        $idea_text=preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\">\\0</a>", $idea_text);
                        
                        echo "<div class='idea vanilla_idea' idea-id=$idea_id>"; //idea
                        echo "<div class='idea_body'>$idea_text</div>";
                        echo "<div class='idea_footer'>";
                             echo "<div class='vanila_note_act'>";
                               
                               $base_name =  GetBanseNameByID($base_id);

                          echo "<div class='span_modpack'>$base_name</div><button name='remove_idea' class='button small_button'><i class='fa fa-times' title='Delete idea'></i></button></div>";
                          echo "</div>"; //footer
                    echo "</div>";// idea
                }   
               ?> 
            </div><!-- base ideas list -->    
         </div>
     </div>
     </div>
    </body>