<?php include "includes/dbconnect.php";
      include "includes/functions.php";

      if(isset($_POST['note_edit'])){
          $note_id=$_POST['note_id'];
          $note_text=mysqli_real_escape_string($link, $_POST['note_text']);
          $note_title=mysqli_real_escape_string($link, $_POST['note_title']);
          $note_category=$_POST['category'];
          $note_modpack=$_POST['modpack'];

          $sql="UPDATE notes SET note_id=$note_id, cat_id=$note_category, modpack_id=$note_modpack, note_text='$note_text',note_header='$note_title' where note_id=$note_id";
         //echo $sql;
          $result=mysqli_query($link, $sql);

          //vlozit do wallu 
        $diary_text="Poznamka s id <strong>$note_id</strong> a nazvom <strong>$note_title</strong> bola upravena ";  
        $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
        $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
        
   
          echo "<script>alert('Poznamka s id $note_id bola upravena');
          window.location.href='notes.php'; 
          </script>";
          //header('location:notes.php');
      }

      if(isset($_POST['note_back'])){
        header("location:notes.php");
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
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=quvey2mtmgzj0p05fw869pufquv1pymgyyp1qrn7z3tewiaa"></script>
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
  </head>
  
  <body>
  <?php include("includes/header.php") ?>
      <div class="main_wrap">
      <div class="tab_menu">
          <div class="tab_menu">
          <?php include("includes/menu.php"); ?>
        </div>
        </div>
        <div class="content">
            <div class='list'>
                <?php
                    global $link; 
                    $note_id=$_GET['note_id'];
                    $sql="SELECT note_id, note_text,note_header, modpack_id,cat_id from notes where note_id=$note_id";
                    //echo $sql;
                    $result=mysqli_query($link, $sql);
                    while($row = mysqli_fetch_array($result)){
                        $cat_id=$row['cat_id'];
                        $modpack_id=$row['modpack_id'];
                        $cat_name=GetModName($row['cat_id']);
                        $modpack_name=GetModPackName($row['modpack_id']);
                        $note_text=$row['note_text'];
                        $note_title=$row['note_header'];
                        }              
                         
                    ?>
                 <div class="note_edit">
                    <form action="" method="post">
                         <input type="hidden" name="note_id" value=<?php echo $note_id ?> />
                         <input name="note_title" value="<?php echo $note_title ?>">
                         <textarea name="note_text"><?php echo $note_text ?></textarea>
                         <select name='category'>
                             <?php 

                                 if($cat_id==0){
                                     echo "<option value=0>-- Select category -- </option>";
                                 } else {    
                                 echo "<option value=$cat_id selected='selected' >$cat_name</option>";
                                 }   
                                $sql="SELECT * from mods ORDER BY cat_name ASC";
                              
                                $result=mysqli_query($link, $sql);
                                  while ($row = mysqli_fetch_array($result)) {
                                    $cat_id=$row['cat_id'];
                                    $cat_name=$row['cat_name'];
                                echo "<option value=$cat_id>$cat_name</option>";
                                }   
                            ?>  
                        </select>
                        <select name="modpack">
                           <?php 
                           //echo "modpack:".$modpack_id;
                            if($modpack_id==0){
                                echo "<option value=0> -- Select modpack -- </option>";
                            } else {
                        
                            echo "<option value=$modpack_id selected='selected' >$modpack_name</option>";
                            }

                            $sql="SELECT * from modpacks ORDER BY modpack_id ASC";
                            $result=mysqli_query($link, $sql);
                              while ($row = mysqli_fetch_array($result)) {
                                $modpack_id=$row['modpack_id'];
                                $modpack_name=$row['modpack_name'];
                            echo "<option value=$modpack_id>$modpack_name</option>";
                            }   
                          ?>
                        </select> 
                        <div class="edit_note_action">
                            <button name="note_edit" type="submit" class="button middle_button pull-right"><i class="fa fa-pencil"></i></button>
                            <button name="note_back" type="submit" class="button middle_button pull-right">Back</button>
                        </div><!-- note edit actio -->
                    </form>
                 </div><!-- note edit-->   
            </div>    
        </div> 
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
</body>        