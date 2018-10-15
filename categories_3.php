<?php include "includes/dbconnect.php";
      include "includes/functions.php";

      if(isset($_POST['add_new_cat'])){
        $cat_name=mysqli_real_escape_string($link, $_POST['new_cat_name']);
        
        if($cat_name==""){
            echo "<script>alert('Nic si nevlozil !!!');
            window.location.href='categories.php';
            </script>";
        } else {
        
        $sql="SELECT * from category where cat_name='$cat_name'";    
        $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
        $num_now=mysqli_num_rows($result);
        if($num_now>0){
            echo "<script>alert('Pozor duplikat !!!');
            window.location.href='categories.php';
            </script>";
            
        }
        else {


        $sql="INSERT INTO category (cat_name) VALUES ('".$cat_name."')";
       // echo $sql;
        $result=mysqli_query($link, $sql);

        //$link1 = mysqli_connect(null, "brick_wall", "h3jSXv3gLf", "brick_wall", null, "/tmp/mariadb55.sock");
        //$link1 = mysqli_connect(null, "brick_wall", "h3jSXv3gLf", "brick_wall", null, "/tmp/mariadb55.sock");
      /*  $curr_date=date('Y-m-d H:i:s');
        $diary_text="Do zoznamu bol pridany novy mod s nazvom <strong>$cat_name</strong>";
        $sql="INSERT INTO diary (diary_text, date_added,location,isMobile,is_read) VALUES ('$diary_text','$curr_date','',0,0)";
        $result = mysqli_query($link1, $sql) or die("MySQLi ERROR: ".mysqli_error($link1));
        mysqli_close($link1);*/
        echo "<script>
            alert('Novy mod $cat_name bol pridany');
            window.location.href='categories.php';
        </script>";
        
        }
      }
     
    }
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
          <div class='list'>
              <div id="new_cat">
                  <h4>Add new category (mode):</h4>
                  <form action='' method='post'>
                      <input type='text' name='new_cat_name' autocomplete="off">
                      <div class='action'><button type='submit' name='add_new_cat' class='button pull-right'><i class='fa fa-plus'></i> Add new</button></div>
                  </form>   
               </div>   
               
               <div id="letter_list"><!--letter list -->
                
                     <ul>
                     <?php 
                        foreach (range('A', 'Z') as $char) {
                          echo "<li><a href='categories.php?alphabet=$char' class='button small_button'>$char</a></li>";

                        }
                          echo "<li><a href='categories.php?char=all' class='button small_button'>All</a></li>";
                          ?>  
                        </ul>
                        
                </div><!--letter list --> 
                
                <div id='categories_list'>
                      <ul>
                      <?php
                        $sql="SELECT * from category ORDER BY cat_name ASC";
                        $result=mysqli_query($link, $sql);
                        while ($row = mysqli_fetch_array($result)) {
                            $cat_id=$row['cat_id'];
                            $cat_name=$row['cat_name'];
                        
                            echo "<li><div class='cat_name'>$cat_name</div><div class='cat_delete'><a href='category_delete.php?id=$cat_id'>x</a></div></li>";
                            
                        }    
                      ?>
                      </ul>
                  </div>
                  <div style="clear:both"></div>          
              </div>
              <!--<div style="clear:both"></div>-->
          </div><!--list -->
        </div><!--content -->      