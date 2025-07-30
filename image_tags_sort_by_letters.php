<?php
include("includes/dbconnect.php");
include("includes/functions.php");

$letter = mysqli_real_escape_string($link, $_POST['letter']); //$_POST['char'];

$tags = GetImageTagListByLetter($letter);
echo $tags;
?>