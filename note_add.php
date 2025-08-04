  <?php
     include "includes/dbconnect.php";
     include "includes/functions.php";
     
      if(isset($_POST['note_add'])) {
        
        $note_header=mysqli_real_escape_string($link, $_POST['note_title']);
        $note_text=htmlentities(mysqli_real_escape_string($link, $_POST['note_text']));
        $modpack_id=$_POST['modpack'];
        var_dump($_POST);
     
       $cat_id=0;
       
        $create_note="INSERT into notes (note_header,note_text,cat_id, modpack_id, added_date) VALUES ('$note_header', '$note_text',$cat_id,$modpack_id,now())";
        $result=mysqli_query($link,$create_note) or  die("MySQLi ERROR: ".mysqli_error($link));

        $getlatestnote="SELECT LAST_INSERT_ID() as last_id from notes";
        $result=mysqli_query($link, $getlatestnote) or die("MySQLi ERROR: ".mysqli_error($link));
        while ($row = mysqli_fetch_array($result)) {          
          $last_note=$row['last_id'];
        } 


        //notes modpacks 
        $insert_into_modpacks="INSERT INTO notes_modpacks (note_id, modpack_id) VALUES ($last_note, $modpack_id)";
        $result = mysqli_query($link, $insert_into_modpacks) or die("MySQLi ERROR: ".mysqli_error($link));
        
        //insert into mods
        $insert_into_mods="INSERT INTO notes_mods (note_id, cat_id) VALUES ($last_note, $cat_id)";
        $result = mysqli_query($link, $insert_into_mods) or die("MySQLi ERROR: ".mysqli_error($link));



        //ziskat id posledne vytvorenej poznamky
        
    
        $modpack_name = GetModPackName($modpack_id);
        
        if($note_header==""){
          $diary_text="Bola vytvorena nova poznamka s id: <strong>$last_note</strong>";  
        } else {
          $diary_text="Bola vytvorena nova poznamka s nazvom <strong>$note_header</strong>";
            }
        
        $addtolog="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
        $result = mysqli_query($link, $addtolog) or die("MySQLi ERROR: ".mysqli_error($link));
         
        
        header("Location: notes.php");
        exit();

      }