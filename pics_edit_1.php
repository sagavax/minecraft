<?php include "includes/dbconnect.php";
      include "includes/functions.php";
     
      if(isset($_POST['save_changes'])){
        $picture_id=intval($_POST['picture_id']);
        $picture_title=mysq1i_real_escape_string($link, $_POST['picture_title']);
        //zistime si z dataazy o aky subor ide
        
        $sql="UPDATE pictures SET picture_title='$picture_title' where picture_id=$picture_id";
        $result=mysqli_query($link, $sql) or die(mysqli_error($link));
        $row = mysqli_fetch_array($result);
        
        //zapiseme do wallu 
        //$link1 = mysqli_connect(null, "brick_wall", "h3jSXv3gLf", "brick_wall", null, "/tmp/mariadb55.sock"); //databaza na hostingu
        $link1=mysqli_connect("localhost", "root", "", "brick_wall");//mistna databaza

        $curr_date=date('Y-m-d H:i:s');
        //
        $diary_text="Minecraft IS: Bol upraveny nazov obrazka obrazok s id: <strong>$picture_id</strong>";
        $sql="INSERT INTO diary (diary_text, date_added,location,isMobile,is_read) VALUES ('$diary_text','$curr_date','',0,0)";
        $result = mysqli_query($link1, $sql) or die("MySQLi ERROR: ".mysqli_error($link1));
        mysqli_close($link1);
      
        //zobrazime alter
        echo "<script>alert('Obrazok id $picture_id' bol upraveny');
        window.location.href='pics.php';
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
          <?php include("menu.php"); ?>
    </div>
       
    <div class="content">
        <div class='list'>
            <div id="new_video">
                 <form action="" enctype="multipart/form-data" method="post">    
                 <input type="hidden" name="picture_id" value="<?php echo $_POST['picture_id']?>">
                 <input type="text" name="picture_title" placeholder='picture title' autocomplete=off>
                
               </form> 
            </div>
        </div><!--list-->    
    </div><!-- content -->  