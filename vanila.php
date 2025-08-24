<?php include "includes/dbconnect.php";
      include "includes/functions.php";
      
 if(isset($_POST['new_note'])){
     $note_text=mysqli_real_escape_string($link, $_POST['note_text']);   
     $base_id+$_POST['base_id'];
     $added_date=date('Y-m-d');
     $sql="INSERT INTO vanila_base_info_note (base_id, note_text, added_date) VALUES ($base_id,'$note_tex','$added_date')";
     $result=mysqli_query($link, $sql);
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <script defer src="js/app_event_tracker.js?<?php echo time() ?>"></script>
  </head>


  <body>
  <?php 
   echo "<script>sessionStorage.setItem('current_module','vanilla')</script>";
   include("includes/header.php") ?>
   <div class="main_wrap">
        <div class="tab_menu">
            <?php include("includes/menu.php"); ?>
        </div>
        <div class="content">
            <div class="list">
                <table id="vanila_minecraft">
                    <tr>
                        <th>meno zakladne</th><th>Zakladna popis</th><th>x</th><th>y</th><th>z</th><th></th><th></th>
                    </tr>
                    <?php 
                        $sql="SELECT * from vanila_bases";
                        $result=mysqli_query($link, $sql);
                        while ($row = mysqli_fetch_array($result)) {
                        $base_id=$row['base_id'];
                        $base_name=$row['base_name'];
                        $zakladna_popis=$row['zakladna_popis'];
                        $x=$row['X'];
                        $y=$row['Y'];
                        $z=$row['Z'];        
                        
                            echo "<tr><td>$base_name</td><td  class='zakladna_popis'><div contenteditable='true' id='base-".$base_id."' onkeyup='update_info(".$base_id.");'>$zakladna_popis</div></td><td class='x'>$x</td><td class='y'>$y</td><td class='z'>$z</td><td>".get_nr_base_notes($base_id)."</td><td><ul class='base_action'><li><button class='button small_button' type='button' title='Pridat ulohu' onclick='add_new_task();'><i class='fas fa-plus'></i></button></li><li><button class='button small_button' type='button' title='Pridat poznamku' onclick='add_new_note();'><i class='fas fa-plus'></i></button></li><li><button class='button small_button' type='submit' title='Upravit'><i class='fas fa-edit'></i></button></li></td></tr>";
                        }   
                    ?>
                </table>
            </div>
        </div>
   </div>
   <div id="new_note_wrap">
        <form action="" method="post">
                <input type="hidden" name="base_id" value="<?php echo $base_id?>">
                <!-- <div id="new_note_text"> -->
                <textarea name="note_text"></textarea>
            <!-- </div> -->
            <div id="new_note_action">
                            <button class="button small_button" type="submit" name="new_note">+ new note </button>
                            <span><a href="#" onclick="hide_new_note()">X</a></span>
                    </div>
            </form>
            </div>
   <script>
       function add_new_note() {
        var element = document.getElementById("new_note_wrap");
        element.style.display="flex";
       }

       function hide_new_note(){
        var element = document.getElementById("new_note_wrap");
        element.style.display="none";
       }

       function update_info(base_id){

        var obj_id = "base-"+base_id;
        var element = document.getElementById(obj_id);
        var content = element.innerText;
        var url= "update_base_descr.php?base_id="+encodeURIComponent(base_id)+"&note_text="+encodeURIComponent(content);
        //var url= "update_base_descr.php?base_id="+encodeURIComponent(base_id);
        var xhttp = new XMLHttpRequest();
                xhttp.open("POST", url, true);
                xhttp.send();

        //ajax update content
       }
   </script>
  </body>