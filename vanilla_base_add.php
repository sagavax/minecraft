<?php include("includes/dbconnect.php");
      include ("includes/functions.php");
      header("Access-Control-Allow-Origin: *");

if(isset($_POST['return_to_vanilla'])){
    header('location:vanilla.php');
}

 if(isset($_POST['add_base'])){
     //var_dump($_POST);
    $base_name=mysqli_real_escape_string($link,$_POST['base_name']);
    $x=$_POST['over_x'];
    $y=$_POST['over_y'];
    $z=$_POST['over_z'];
    
    /* $nether_x=$_POST['nether_x'];
    $nether_y=$_POST['nether_y'];
    $nether_z=$_POST['nether_z']; */
    
    $base_description = mysqli_real_escape_string($link, $_POST['description']);
    $create_new_base="INSERT INTO vanila_suradnice (base_name, base_description, x,y,z) VALUES ('$base_name','$base_description',$x,$y,$z)";
     $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
    
    echo "<script>alert('Nova zakladna ".$base_name." bola pridana');
    window.location.href='vanilla.php';
    </script>";
    
 }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vannila MC - add new base</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
</head>
<body>
<?php include("includes/header.php") ?> 
    <div class="main_wrap">
         <div class="tab_menu">
             <?php include("includes/menu.php"); ?>
         </div>
         
         <div class="content">
            <div class="list">
                <div id="new_base">
                  
                    <form action="" method="post">
                        <input name="base_name" type="text" placeholder="name your base..." value=" Zakladna <?php echo GetMaxBaseId() + 1 ?>" required>
                        <textarea name="description" placeholder="Describe your base somehow..."></textarea>
                        <div class="base_location">
                            <div id="base_location_outworld"><h4>Outworld:</h4>
                                <div class="base_coord"><span>X:</span><input type="text" placeholder="X" name="over_x" required></div>
                                <div class="base_coord"><span>Y:</span><input type="text" placeholder="Y" name="over_y" required></div>
                                <div class="base_coord"><span>Z:</span><input type="text" placeholder="Z" name="over_z" required></div>
                            </div><!-- base location outworld -->
                        </div>   
                         <!--    <div id="base_location_nether"><h4>Nether location:</h4>
                                <div class="base_coord"><span>X:</span><input type="text" placeholder="X" name="nether_x"></div>
                                <div class="base_coord"><span>Y:</span><input type="text" placeholder="Y" value="80" name="nether_y"></div>
                                <div class="base_coord"><span>Z:</span><input type="text" placeholder="Z" name="nether_z"></div>
                            </div> -->
                        
                        <div id="add_base_action">
                            <button type="submit" class="button small_button" name="return_to_vanilla">Back</button>
                            <button type="submit" class="button small_button" name="add_base">Add base</button>
                        </div>
                    </form>
                 </div><!-- add new base -->
                </div><!-- list -->  
             </div><!-- content -->
       </div><!-- main_wrap -->    
</body>
</html>