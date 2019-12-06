<?php include "includes/dbconnect.php";
      include "includes/functions.php";

      if(isset($_POST['note_add'])) {
        global $link;
    
                $note_header=mysqli_real_escape_string($link, $_POST['note_header']);
                $note_text=mysqli_real_escape_string($link, $_POST['note_text']);
                $modpack_id=mysqli_real_escape_string($link, $_POST['modpack_id']);
           
                if(($note_header=="") && ($note_text=="")){
                    echo "<script>alert('Nieco by si tam mal zadat');
                    window.location.href='note_add.php';
                    </script>";
                } else {
        
        
        if(isset($_POST['category'])){
            $cat_id=$_POST['category'];
            $category_name=GetModName($cat_id);
        } else {
            $cat_id=0;
        }
        
        $added_date=date('Y-m-d');
        $sql="INSERT into notes (note_header,note_text,cat_id, modpack_id, added_date) VALUES ('$note_header', '$note_text',$cat_id,$modpack_id,'$added_date')";
         mysqli_query($link,$sql);
        //ziskat id posledne vytvorenej poznamky
        $sql="SELECT LAST_INSERT_ID() as last_id from notes";
        $result=mysqli_query($link, $sql);
        while ($row = mysqli_fetch_array($result)) {          
          $last_note=$row['last_id'];
        } 

        //vlozit do wallu 
        $link1 = mysqli_connect(null, "brick_wall", "h3jSXv3gLf", "brick_wall", null, "/tmp/mariadb55.sock");
        //var_dump($_POST);
        //$link1=mysqli_connect("localhost", "root", "", "brick_wall");
        mysqli_query($link1,'set character set utf8;');
        mysqli_query($link1,"SET NAMES `utf8`");
        
        if(isset($_POST['publish_to_wall'])){//chcem zverejnit text poznamky do wallu, nielen informaciu ze sprava bola vytvorena
            //echo "<script>alert('To Waaaaaaaaaal !!!')</script>";
            //$diary_text="<strong>$note_header</strong> $note_text";
            $diary_text="$note_header $note_text";
            //$diary_text=mb_convert_encoding($diary_text,"utf-8");
          // $diary_text=iconv(mb_detect_encoding($diary_text, mb_detect_order(), true), "UTF-8", $diary_text);

         } else { //ak poznamka nieje urcena na zverejnenie tak sa zobrazi len informacia o tom,ze sa nejaka poznamka vytvorila
        
        
        if($note_header==""){
          $diary_text="Minecraft IS: Bola vytvorena nova poznamka s id: <strong>$last_note</strong>";  
        } else {
          $diary_text="Minecraft IS: Bola vytvorena nova poznamka s nazvom <strong>$note_header</strong>";
            }
        }
        
        $curr_date=date('Y-m-d H:i:s');
        $sql="INSERT INTO diary (diary_text, date_added,location,isMobile,is_read) VALUES ('$diary_text','$curr_date','',0,0)";
        //echo $sql;
        $result = mysqli_query($link1, $sql) or die("MySQLi ERROR: ".mysqli_error($link1));
        mysqli_close($link1);
        header('location:notes.php');
        }  
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
                    <form action="" method="POST" accept-charset="utf-8">
                        <input type="hidden" name="modpack_id" value=
                        
                        <?php 
                           if(isset($_GET['modpack_id'])){
                               echo $_GET['modpack_id'];
                           } else {
                               echo 0;
                           }
                                               
                        ?> >
                        <input type="text" name="note_header">
                        <textarea name="note_text"></textarea>
                        <div class='new_note_category'>
                            <select name='category'>
                                <option value=0>-- Select category -- </option>
                        <?php    
                        $sql="SELECT * from category ORDER BY cat_name ASC";
                      
                        $result=mysqli_query($link, $sql);
                          while ($row = mysqli_fetch_array($result)) {
                            $cat_id=$row['cat_id'];
                            $cat_name=$row['cat_name'];
                        echo "<option value=$cat_id>$cat_name</option>";
                        }	
                        ?>  
                        </select><input type="checkbox" name="publish_to_wall" id="publish_to_wall" checked="checked"><label for="publish_to_wall">Publikovat na wall</label></div>
                        <div class="action"><button name='note_add' type='submit' class='button pull-right'>Add</button></div>
                    </form>    
                </div><!--new note form -->
            </div><!-- class list-->
        </div><!-- class content -->
        <script>
            var textarea = document.querySelector('textarea');

            textarea.addEventListener('keydown', autosize);
             
            function autosize(){
            var el = this;
                setTimeout(function(){
                el.style.cssText = 'height:auto; padding:0';
                    // for box-sizing other than "content-box" use:
                    // el.style.cssText = '-moz-box-sizing:content-box';
                    el.style.cssText = 'height:' + el.scrollHeight + 'px';
                },0);
               }
        </script>       