<?php
session_start();
include("include/dbconnect.php");
$login = mysqli_real_escape_string($con,$_POST["username"]);
$heslo = mysqli_real_escape_string($con,$_POST["password"]);
$md5heslo = md5($heslo);/* funkce md5() heslo zahashujeme */

global $con;

$sql="select * from uzivatele where login = '$login' and heslo = '$md5heslo'";
//echo "$sql";
$result = mysqli_query($con,$sql);
$overeni = mysqli_num_rows($result);
//echo "Pocet riadkov:".$overeni;
$row = mysqli_fetch_array($con,$result);
if($overeni == 1) {
    $_SESSION['login'] = stripslashes($login);
    $_SESSION['id'] = $row["id"];
 
    //header("Location:".$_SERVER['HTTP_REFERER']);
   
} else {
   echo "<div class='message error'>ZLE UZIVATELSKE MENO ALEBO HESLO !!!!</div>";
}
?>
</div>
