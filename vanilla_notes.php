<?php include("includes/dbconnect.php");
      include ("includes/functions.php");



      if(isset($_POST['save_base_note'])){
        $base_id = $_POST['base'];
        $title = mysqli_real_escape_string($link, $_POST['note_title']);
        $text = mysqli_real_escape_string($link,$_POST['note_text']);
        
        $save_note="INSERT into vanila_base_notes (zakladna_id, note_title, note_text,added_date) VALUES ($base_id, '$title','$text',now())";
        $result=mysqli_query($link, $save_note);

         $diary_text="Minecraft IS: Poznamka pre base <b>$base_id</n> bola vytvorene";
        $create_record="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
        $result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));

        echo "<script>alert('new note has been added');
            window.location.href='vanilla_notes.php';
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
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css"
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script type="text/javascript" src="js/vanilla_notes.js" defer></script>
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">

    <body>
      <?php include("includes/header.php") ?>
      <div class="tab_menu">
             <?php include("includes/vanila_menu.php") ?>
      </div>
      <div class="main_wrap">
        <div class="content">
          <div class="list">
           <div class="new_base_note">
             <form action="" method="post">
                 <input type="text" name="note_title" autocomplete="off" placeholder="note title here...">
                 <textarea id="new_note" placeholder="Add new note here ...." name="note_text"></textarea>
                 <select name="base">
                      <option value="1">hlavna zakladna</option>
                     <?php 
                        $get_bases = "SELECT * from vanila_suradnice";
                        $result_bases = mysqli_query($link, $get_bases) or die("MySQLi ERROR: ".mysqli_error($link));
                        while($row_bases = mysqli_fetch_array($result_bases)){
                            $base_id = $row_bases['zakladna_id'];
                            $base_name =$row_bases['zakladna_meno'];
                            echo "<option value=$base_id>$base_name</option>";
                         }   
                     ?>
                 </select> 
                 <button type="submit" class="button small_button" name="save_base_note"><i class="fa fa-plus"></i></button>
             </form>
            </div> 
           

             <div class="sort_bases">
                <?php 
                    $get_bases = "SELECT * from vanila_bases";
                    $result_bases = mysqli_query($link, $get_bases) or die("MySQLi ERROR: ".mysqli_error($link));
                    while($row_bases = mysqli_fetch_array($result_bases)){
                        $base_id = $row_bases['zakladna_id'];
                        $base_name =$row_bases['zakladna_meno'];
                        echo "<button type='button' class='button small_button' btn-id=$base_id>$base_name</button>";
                     }   
                ?>  
           </div>

           <div class="base_notes_list">
                <?php 
                    $sql="SELECT * from vanila_base_notes order by note_id DESC";
                    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
                    while($row = mysqli_fetch_array($result)){
                        $id = $row['note_id'];
                        $note_text = $row['note_text'];
                        $note_title = $row['note_title'];
                        $added_date = $row['added_date'];
                        $base_id = $row['zakladna_id'];

                        $zakladna = GetBanseNameByID($base_id);

                        echo "<div class='base_note' note-id='$id'>";
                            echo "<div class='vanila_note_title'>".$note_title."</div>";
                            echo "<div class='vanila_note_text'>".$note_text."</div>";
                            echo "<div class='vanila_note_act'><span class='span_modpack'>$zakladna</span><button class='button small_button' btn-id=$id);'><i class='fa fa-times' title='Delete note'></i></button></div>";
                        echo "</div>";
                    };    
                ?>
            </div><!--base notes list-->    
           </div>         
        </div>
      </div>
        
    </body>