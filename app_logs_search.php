<?php include("includes/dbconnect.php");


$text = $_GET['search'];


$get_result ="SELECT * FROM app_log WHERE diary_text LIKE '%".$text."%'";
                      //echo $sql;   
                      $result=mysqli_query($link, $get_result);
                      while ($row = mysqli_fetch_array($result)) {
                        $id=$row['id'];
                        $text= $row['diary_text'];
                        
                        echo "<div class='log_record'><div class='log_text'>$text</div><div class='cat_delete' data-id=$id><i class='fas fa-times-circle'></i></div></div>";

                      }    