<?php include "includes/dbconnect.php";
      include "includes/functions.php";
      
     var_dump($_POST);


      if(isset($_POST['delete_picture'])){
        $picture_id=intval($_POST['picture_id']);
        
        //zistime si z dataazy o aky subor ide
        $base_dir="gallery";
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
       
        echo "<script>ert('Obrazok id $picture_id' bol vymazany');
        window.location.href='pics.php';</script>";
        
      }


      if(isset($_POST['add_new_pic'])){
          global $link;

          $file = $_FILES['picture']['tmp_name'];  //docasne meno, cela cesta
          $image_name = addslashes($_FILES['picture']['name']); // meno suboru

          //skontrolujem ci je uz v databazy

          $sql="SELECT count(*) as nr_pictures from pictures where picture_name='".$image_name."'";
          //echo $sql;
          $result=mysqli_query($link, $sql) or die(mysqli_error($link));     
          $row = mysqli_fetch_array($result);
          $nr_pics=$row['nr_pictures'];
          
          if($nr_pics==1){
            echo $nr_pics;
            //echo "<script>alert($nr_pics);</script>";
             echo "<script>alert('Tento obrazok je uz v galerii');
             window.location.href='pics.php';
            </script>";
          } else {


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
          
        
           $base_dir="gallery/";
        
          //upload suboru
          move_uploaded_file($file, "$base_dir/$image_name");

          //kontrola ci je zadany mod
          
          if(isset($_POST['category'])){
          
          
          $mod_id=0;

          //kontrola ci je zadany modpack
          if(isset($_POST['modpack_id'])){
            $modpack=$_POST['modpack_id'];
           }  else {
               $modpack=0;
           }

            $eis_pic_id=0;
          
          //vlozim do databazy
          $date=date('Y-m-d H:i:s');
          $picture_title=mysqli_real_escape_string($link,$_POST['picture_title']);
          $picture_description=mysqli_real_escape_string($link, $_POST['picture_description']);

          //echo $picture_description;

          $sql="INSERT INTO pictures (picture_title,picture_description,picture_name,picture_path,picture_ext, picture_size, eis_pic_id,cat_id ,modpack_id,added_date) VALUES ('$picture_title','$picture_description','$image_name','$path','$ext',$picture_size,$eis_pic_id,$mod_id,$modpack,'$date')";
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

        echo "<script>alert('Novy obrazok bol pridany!!!');
        window.location.href='pics.php'
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
                <input type=hidden name="modpack_id" value=<?php if(isset($_GET['modpack_id'])){echo $_GET['modpack_id'];}else{echo 0;} ?>>
                <input type="hidden" name="<?php echo ini_get('session.upload_progress.name'); ?>" value="test" />
                <input type="text" name="picture_title" placeholder='picture title' autocomplete=off>
                <textarea name="picture_description"></textarea>
                <input type="file" name="picture"  placeholder="Picture">
                <div class="action"><button type="submit" name="add_new_pic" class="button pull-right"><i class="fa fa-plus"></i></button></div>
              </form> 
              <div class="progress_bar_wrap">
                <div class="progress_bar" style="width:0%"></div>
              </div>
            </div>

            <div id="picture_list">
              <?php
                    //check list of the files and compare it with the databases
                    $dir="gallery/";
                    if ($handle = opendir($dir)) {

                      while (false !== ($entry = readdir($handle))) {
                  
                          if ($entry != "." && $entry != "..") {
                  
                              //echo "$entry<br>";
                              $sql="SELECT count(*) as nr_pics from pictures where picture_name='$entry'";
                              $result=mysqli_query($link, $sql);
                              $row = mysqli_fetch_array($result);
                              $nr_pics=$row['nr_pics'];
                              if($nr_pics==0) {//subor nie je v databaze 
                                //vloz to do databazy
                                
                                $date=date('Y-m-d H:i:s');
                                $picture_title="";
                                $picture_size=filesize($dir."/".$entry);
                                $ext = pathinfo($entry, PATHINFO_EXTENSION);
                                $mod_id=0;
                                $modpack_id=0;
                                $eis_pic_id=0;
                                

                                $sql="INSERT INTO pictures (picture_title,picture_name,picture_path,picture_ext, picture_size, eis_pic_id,cat_id ,modpack_id,added_date) VALUES ('$picture_title','$entry','$entry','$ext',$picture_size,$eis_pic_id,$mod_id,$modpack_id,'$date')";
                                $result=mysqli_query($link, $sql) or die(mysqli_error($link));
                                //
                              }
                          }
                      }
                  
                      closedir($handle);
                  
                    $sql="SELECT a.picture_id, a.picture_name,a.picture_title, picture_description, a.eis_pic_id, a.picture_path, a.cat_id, a.modpack_id from pictures a ORDER BY a.picture_id DESC";
                     $result=mysqli_query($link, $sql);
                     while ($row = mysqli_fetch_array($result)) {
                       $picture_id=$row['picture_id'];
                       $picture_title=$row['picture_title'];
                      $picture_description=$row['picture_description']; 
                      

                       $picture_name=$row['picture_name'];
                       $picture_path=$row['picture_path'];
                       $mod_id=$row['cat_id'];
                       $modpack_id=$row['modpack_id'];
                   
                        //echo $_SERVER['HTTP_HOST'];
                        //echo $_SERVER['DOCUMENT_ROOT'];
                        
                       echo "<div class='picture'>";
                                    echo "<div class='picture_name'><strong>$picture_title</strong></div>";

                                    if($picture_title==""){
                                      $picture_title=$picture_name;
                                    }

                                    echo "<div class='pic'><img src='gallery/$picture_name' title='$picture_title'></div>";
                                                                       
                                    $category_name=GetModName($mod_id);
                                    $modpack_name=GetModpackName($modpack_id);

                                    if($category_name<>""){
                                      $category_name="<span class='span_mod'>".$category_name."</span>";
                                    }
                                    if ($modpack_name<>""){
                                       $modpack_name="<span class='span_modpack'>".$modpack_name."</span>";
                                    }
                                    echo "<div class='picture_footer'>"; 
                                    
                                    if($picture_description<>""){
                                      echo "<div class='picture_description'>$picture_description</div>";
                                    }
                                    
                                    echo "<div class='mod_modpack'>".$modpack_name."</div>";


                                      echo "<div class='picture_action'><form action='' method='post'><input type='hidden' name='picture_id' value=$picture_id><button type='submit' name='edit_info' class='button small_button pull-right' title='Edit info '><i class='fa fa-pencil'></i></button><button name='delete_picture' type='submit' class='button small_button pull-right' title='Delete picture'><i class='fa fa-times'></i></button></form></div>";
                                    echo "</div>";
                                    //echo "<div class='mod'>$mod_name</div>";
                                    echo "<div style='clear:both'></div>";             
                          echo "</div>";//div picture

                    }                
                 }    
              ?>
            </div><!-- picture list -->
            
        </div><!--list-->    
    </div><!-- content -->  