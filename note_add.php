  <?php
     header("Access-Control-Allow-Origin: *");
     header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
     header("Access-Control-Allow-Headers: Content-Type, Authorization");
     
     if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
         http_response_code(200);
         exit();
     }
     
     include "includes/dbconnect.php";
     include "includes/functions.php";
     
      if(isset($_POST['note_add'])) {
        
        $note_header=mysqli_real_escape_string($link, $_POST['note_header']);
        $note_text=htmlentities(mysqli_real_escape_string($link, $_POST['note_text']));
        $modpack_id=$_POST['modpack'];
     
       $cat_id=0;
       
        $sql="INSERT into notes (note_header,note_text,cat_id, modpack_id, added_date) VALUES ('$note_header', '$note_text',$cat_id,$modpack_id,now())";
        //echo $sql;
        mysqli_query($link,$sql) or die(mysqli_error($link));


        //ziskat id posledne vytvorenej poznamky
        $getlatestnote="SELECT LAST_INSERT_ID() as last_id from notes";
        $result=mysqli_query($link, $getlatestnote) or die("MySQLi ERROR: ".mysqli_error($link));
        while ($row = mysqli_fetch_array($result)) {          
          $last_note=$row['last_id'];
        } 

        //vlozit do wallu 
        
          
            $modpack_name = GetModPackName($modpack_id);
        
        if($note_header==""){
          $diary_text="Minecraft IS: Bola vytvorena nova poznamka s id: <strong>$last_note</strong>";  
        } else {
          $diary_text="Minecraft IS: Bola vytvorena nova poznamka s nazvom <strong>$note_header</strong>";
            }
        
        $addtolog="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
        //echo $sql;
        $result = mysqli_query($link, $addtolog) or die("MySQLi ERROR: ".mysqli_error($link));
        
       echo "<script>alert('Nova poznamka s id $last_note bola vytvorena');
        window.location.href='notes.php';
        </script>";
        }  
      }