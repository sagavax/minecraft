<?php include "includes/dbconnect.php";
      include "includes/functions.php";
     
      if(isset($_POST['delete_picture'])){
        $picture_id=intval($_POST['picture_id']);
        
        //zistime si z dataazy o aky subor ide
        $base_dir="uploads/";
        $sql="SELECT picture_name from pictures where picture_id=$picture_id";
        $result=mysqli_query($link, $sql) or die(mysqli_error($link));
        $row = mysqli_fetch_array($result);
        $picture_name=$base_dir."/".$row['picture_name'];

        //vymazeme subor z file systemu
        unlink($picture_name);

        //a vymazeme obrazok z databazy
        $sql="DELETE from pictures where picture_id=$picture_id";
        $result=mysqli_query($link, $sql) or die(mysqli_error($link));

        //zapiseme do wallu 
        //$link1 = mysqli_connect(null, "brick_wall", "h3jSXv3gLf", "brick_wall", null, "/tmp/mariadb55.sock"); //databaza na hostingu
        $link1=mysqli_connect("localhost", "root", "", "brick_wall");//mistna databaza

        $curr_date=date('Y-m-d H:i:s');
        //
        $diary_text="Minecraft IS: Bol vymazany obrazok <strong>$picture_name</strong>";
        $sql="INSERT INTO diary (diary_text, date_added,location,isMobile,is_read) VALUES ('$diary_text','$curr_date','',0,0)";
        $result = mysqli_query($link1, $sql) or die("MySQLi ERROR: ".mysqli_error($link1));
        mysqli_close($link1);
      
        //zobrazime alter
        echo "<script>alert('Obrazok id $picture_id' bol vymazany');
        window.location.href='pics.php';
        </script>";
      }


      if(isset($_POST['add_new_pic'])){
          global $link;

          $file = $_FILES['picture']['tmp_name'];  //docasne meno, cela cesta
          $image_name = addslashes($_FILES['picture']['name']); // meno suboru
          $path = $_FILES['picture']['name'];
          $ext = pathinfo($path, PATHINFO_EXTENSION); //zisti tomu priponu

          if (!isset($file)){ //kontrola ci je to obrazok
            echo "<script>alert('Please select a pic');
            window.location.href='pics.php';
            </script>";
           }

           
          
           //resize of the image 
           $picture_title=mysqli_real_escape_string($link, $_POST['picture_title']); //popis obrazku
           $picture_size = filesize($_FILES['picture']['tmp_name']); //velkost suboru
          
           //rozmery
           
           list($width, $height, $type, $attr) = getimagesize($path); 
           if(($height>=690)||($width>=690)){
             //
          }
           /*$width = imagesx($path);
           $height = imagesy($path);

           if($width>890){ //ak je rozmer vacsi ako rozmer obalu, tak zmensi obrazok na potrebny rozmer so zachovanim potrebneho skalovania
           $scalingFactor = 890 / $width;
           $newImageHeight = $height * $scalingFactor;
           
           $newImage = imagecreatetruecolor($newImageWidth, $newImageHeight);
           imagecopyresampled($newImage, $path, 0, 0, 0, 0, $newImageWidth, $newImageHeight, $width, $height); 
           
          }
          */

           $base_dir="uploads/";
          //$target_file = $target_dir . basename($_FILES["picture"]["name"]); 

           //rezize of picture - ak je obrazok dlhsi ako 890px



          //upload uboru
          move_uploaded_file($file, "$base_dir/$image_name");

          //kontrola ci je zadany mod
          if(isset($_POST['category'])){
          
            $mod_id=$_POST['category'];
          } else{
              $mod_id=0;
          }   
          
          //kontrola ci je zadany modpack
          if(isset($_POST['modpack_id'])){
            $modpack=$_POST['modpack_id'];
           }  else {
               $modpack=0;
           }

          //kontrola ci obrazok je z EISu 
          if(isset($_POST['eis_pic_id'])){
              $eis_pic_id=$_POST['eis_pic_id'];
          }else{
            $eis_pic_id=0;
          }

          //vlozim do databazy
          $date=date('Y-m-d');
          $picture_title=mysqli_real_escape_string($link,$_POST['picture_title']);
          $sql="INSERT INTO pictures (picture_title,picture_name,picture_path,picture_ext, picture_size, eis_pic_id,cat_id ,modpack_id,added_date) VALUES ('$picture_title','$image_name','$path','$ext',$picture_size,$eis_pic_id,$mod_id,$modpack,'$date')";
          //echo $sql;
          $result=mysqli_query($link, $sql) or die(mysqli_error($link));
         
        //vlozim do wallu 
        //$link1 = mysqli_connect(null, "brick_wall", "h3jSXv3gLf", "brick_wall", null, "/tmp/mariadb55.sock");
        $link1=mysqli_connect("localhost", "root", "", "brick_wall");
        $curr_date=date('Y-m-d H:i:s');
        $diary_text="Minecraft IS: Bol pridany novy obrazok s nazvom <strong>$image_name</strong>";
        $sql="INSERT INTO diary (diary_text, date_added,location,isMobile,is_read) VALUES ('$diary_text','$curr_date','',0,0)";
        $result = mysqli_query($link1, $sql) or die("MySQLi ERROR: ".mysqli_error($link1));
        mysqli_close($link1);


        //header('location:pics.php',301, true);

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
          <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="notes.php">Notes</a></li>
            <li><a href="tasks.php">Tasks</a></li>
            <li><a href="categories.php">Categories</a></li>
            <li><a href="modpacks.php">Modpacks</a></li>
            <li><a href="videos.php">Videos</a><ul class="submenu"><li><a href="videos.php?view=see_later_videos">See later</a></li><li><a href="videos.php?view=favorite_videos">Favorite</a></li></ul></li>
            <li><a href="pics.php">Pics</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
    </div>
       
    <div class="content">
        <div class='list'>
            <div id="new_video">
                 <form action="" enctype="multipart/form-data" method="post">    
                <input type=hidden name="modpack_id" value=<?php if(isset($_GET['modpack_id'])){echo $_GET['modpack_id'];}else{echo 0;} ?>>
                <input type="text" name="picture_title" placeholder='picture title' autocomplete=off>
                <input type="file" name="picture"  placeholder="Picture">
                <div class="action"><button type="submit" name="add_new_pic" class="button pull-right"><i class="fa fa-plus"></i></button></div>
               </form> 
            </div>

            <div id="picture_list">
              <?php
                     $sql="SELECT a.picture_id, a.picture_name,a.picture_title, a.eis_pic_id, a.picture_path, a.cat_id, a.modpack_id from pictures a ORDER BY a.picture_id DESC";
                     $result=mysqli_query($link, $sql);
                     while ($row = mysqli_fetch_array($result)) {
                       $picture_id=$row['picture_id'];
                       $picture_title=$row['picture_title'];
                       $picture_name=$row['picture_name'];
                       $picture_path=$row['picture_path'];
                       $mod_id=$row['cat_id'];
                       $modpack_id=$row['modpack_id'];
                   
                        //echo $_SERVER['HTTP_HOST'];
                        //echo $_SERVER['DOCUMENT_ROOT'];
                        
                       echo "<div class='picture'>";
                                    echo "<div class='picture_name'><strong>$picture_title</strong></div>";
                                    echo "<div class='pic'><img src='/minecraft/uploads/$picture_name' class='fit_picture'></div>";
                                                                       
                                    $category_name=GetModName($mod_id);
                                    $modpack_name=GetModpackName($modpack_id);

                                    if($category_name<>""){
                                      $category_name="<span class='span_mod'>".$category_name."</span>";
                                    }
                                    if ($modpack_name<>""){
                                       $modpack_name="<span class='span_modpack'>".$modpack_name."</span>";
                                    }
                                    
                                    echo "<div class='mod_modpack'>".$category_name." ".$modpack_name."</div>";


                                    echo "<div class='picture_action'><form action='' method='post'><input type='hidden' name='picture_id' value=$picture_id><button name='delete_picture' class='button small_button pull-right'>x</button></form></div>";
                                    //echo "<div class='mod'>$mod_name</div>";
                                    echo "<div style='clear:both'></div>";             
                          echo "</div>";//div picture


                 }    
              ?>
            </div><!-- picture list -->
            
        </div><!--list-->    
    </div><!-- content -->  