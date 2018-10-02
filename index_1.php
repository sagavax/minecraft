<?php include "includes/dbconnect.php";
      include "includes/functions.php";

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minecraft tools</title>
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
          <ul>
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="notes.php">Notes</a></li>
            <li><a href="tasks.php">Tasks</a></li>
            <li><a href="categories.php">Categories</a></li>
            <li><a href="modpacks.php">Modpacks</a></li>
            <li><a href="videos.php">Videos</a></li>
            <li><a href="pics.php">Pics</a></li>
          </ul>
        </div>
        <div class="content">
            <div class="list">
              <?php 
                  
                      $sql="
                        select note_header as header, note_text as text, added_date, 'notes' as application from notes
                        UNION
                        select NULL as header , task_text, added_date as text, 'tasks' as application from to_do
                        ORDER BY added_date DESC
                      ";
                        $result=mysqli_query($link, $sql) ;
                        while ($row = mysqli_fetch_array($result)) {
                          $header=$row['header'];
                          $text=$row['text'];
                          $added_date=$row['added_date'];
                          $app=$row['application'];
                         
                         
                         $app_note="<i class='fa fa-pencil'></i>";
                         $app_task="<i class='fa fa-tasks'></i>";
                          
                          echo "<div class='list_wrap'>
                                  <div class='list_body'>
                          ";        
                                  if($app=='notes'){
                                    
                                    $app_icon=$app_note;
                                    
                                  } elseif($app=='tasks') {
                                    
                                    $app_icon=$app_task;  
                                    
                                  }
                                  
                            echo "      
                                  <div class='list_app_icon'>$app_icon</div>";
                                  
                                  if($header<>NULL or $header<>""){
                                    $text="<b>".$header."</b>. ".$text;
                                    $text=preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\">\\0</a>", $text);

                                  }
                                  
                                  echo "<div class='list_app_text'>$text</div>
                                  <div class='list_date'>$added_date</div>
                                  <div class='list_app'><span class='app_badge'>$app</span></div>
                                </div>
                              </div>";
                        }  
                       echo "<div style='clear:both'></div>";
                  echo "</div>";
               
              ?>
            
        </div>
      </div>
  </body> 
