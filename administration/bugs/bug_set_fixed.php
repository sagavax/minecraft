      <?php 
      
           include "../../includes/dbconnect.php";
            include "../../includes/functions.php";
     
     
      
      $bug_id = $_POST['bug_id'];   

      $bug_to_fix = "UPDATE bugs SET is_fixed=1 WHERE bug_id=$bug_id";
      $result=mysqli_query($link, $bug_to_fix) or die("MySQLi ERROR: ".mysqli_error($link));

      $bug_change_status = "UPDATE bugs SET status='fixed' WHERE bug_id=$bug_id";
      $result=mysqli_query($link, $bug_change_status) or die("MySQLi ERROR: ".mysqli_error($link));

          
      $diary_text="Bug s id $bug_id bol fixnuty";
      $create_record="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
      $result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));
            
      