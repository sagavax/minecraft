<?php 
      include("includes/dbconnect.php");
      include ("includes/functions.php");

 if(isset($_POST['update_base'])){
    $zakladna_id = $_POST['zakladna_id']; 
    //var_dump($_POST);
    $base_name=mysqli_real_escape_string($link, $_POST['base_name']);
    $base_description =mysqli_real_escape_string($link, $_POST['description']);
    $x=intval($_POST['coord_x']);
    $y=intval($_POST['coord_y']);
    $z=intval($_POST['coord_z']);
    $nether_x=intval($_POST['nether_x']);
    $nether_y=intval($_POST['nether_y']);
    $nether_z=intval($_POST['nether_z']);
    
    $sql="UPDATE vanila_suradnice SET zakladna_meno='$base_name',zakladna_popis='$base_description',x=$x,y=$y,z=$z, nether_x = $nether_x, nether_y = $nether_y, nether_z =$nether_z WHERE zakladna_id=$zakladna_id";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
    echo "<script>alert('Information updated');</script>";
    
 }

?>