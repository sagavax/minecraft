  <?php
     include "includes/dbconnect.php";
     include "includes/functions.php";
        
        $note_header=mysqli_real_escape_string($link, $_POST['note_title']);
        $note_text=(mysqli_real_escape_string($link, $_POST['note_text']));
        $modpack_id=$_POST['modpack'];
     
              
    $create_note = "INSERT INTO notes (note_header, note_text, added_date)  VALUES ('$note_header', '$note_text', now())";
    $result = mysqli_query($link, $create_note) or die("MySQLi ERROR: ".mysqli_error($link));


    $get_last_id = "SELECT LAST_INSERT_ID() as last_id FROM notes";
    $result = mysqli_query($link, $get_last_id) or die("MySQLi ERROR: ".mysqli_error($link));
    $row = mysqli_fetch_array($result);
    $last_id = $row['last_id'];


    $add_to_modpack = "INSERT INTO notes_modpacks (note_id, modpack_id,added_date) VALUES ($last_id, $modpack_id, now())";
    echo $add_to_modpack;
    mysqli_query($link, $add_to_modpack) or die("MySQLi ERROR: ".mysqli_error($link));

    $diary_text="Bol vytvorena nova poznamka s nazvom <strong>$note_header</strong>";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

    header("Location: notes.php");
    exit();
    ?>