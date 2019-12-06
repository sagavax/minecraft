<?php include "includes/dbconnect.php";

$id=$_GET['id'];
$sql="DELETE from category where cat_id=$id";
$result=mysqli_query($link, $sql);

echo "<script>alert('Mod s id $id bol zmazany!');
      window.location.href='categories.php'
</script>";