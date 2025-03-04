<?php 
      session_start();
      include "includes/dbconnect.php";
      include "includes/functions.php";

      if(isset($_POST['note_add'])) {
        global $link;
    
                $note_header=mysqli_real_escape_string($link, $_POST['note_header']);
                $note_text=htmlentities(mysqli_real_escape_string($link, $_POST['note_text']));
                $modpack_id=$_POST['modpack'];
            
           
                echo $modpack_id;

                if(($note_header=="") && ($note_text=="")){
                    echo "<script>alert('Nieco by si tam mal zadat');
                    window.location.href='note_add.php';
                    </script>";
                } else {
        
       $cat_id=0;
       
        $added_date=date('Y-m-d');
        $sql="INSERT into notes (note_header,note_text,cat_id, modpack_id, added_date) VALUES ('$note_header', '$note_text',$cat_id,$modpack_id,'$added_date')";
        //echo $sql;
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
          
            $modpack_name = GetModPackName($modpack_id);
            $diary_text="Minecraft: <strong>".$modpack_name."</strong> ".$note_header." ".$note_text;
          
         } else { //ak poznamka nieje urcena na zverejnenie tak sa zobrazi len informacia o tom,ze sa nejaka poznamka vytvorila
        
        
        if($note_header==""){
          $diary_text="Minecraft IS: Bola vytvorena nova poznamka s id: <strong>$last_note</strong>";  
        } else {
          $diary_text="Minecraft IS: Bola vytvorena nova poznamka s nazvom <strong>$note_header</strong>";
            }
        }
        
        
        $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
        //echo $sql;
        $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
        
       echo "<script>alert('Nova poznamka s id $last_note bola vytvorena');
        window.location.href='notes.php';
        </script>";
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
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=quvey2mtmgzj0p05fw869pufquv1pymgyyp1qrn7z3tewiaa"></script>
    <!--<script>tinymce.init({ selector:'textarea' });</script>-->
    <script>tinymce.init({
        selector: 'textarea',
        height: 500,
        menubar: false,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor textcolor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table contextmenu paste code help wordcount'
        ],
        toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tinymce.com/css/codepen.min.css']
        });</script>
   <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  </head>
  
  <body>
      <div class="header">
          <a href="."><div class="app_picture"><img src="pics/logo.svg" alt="Minecraft logo"></div></a>
      </div>
      <div class="main_wrap">
      <div class="tab_menu">
          <?php include("includes/menu.php"); ?>
        </div>
        
        <div class="content">
            <div class="list">
                <div id="new_note">
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
                        </div>
                        <div id="note_text">    
                            <textarea name="note_text" placeholder="new text here..."></textarea>
                        </div>    
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
                            
                        </div>
                        <div id="note_action">
                            <button name='note_add' type='submit' class='button small_button'>Add</button>
                        </div>
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