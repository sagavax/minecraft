<?php
require_once("includes/dbconnect.php");
session_start();// Zapneme session
session_destroy();// Smažeme všechna session
//clean captured events
mysqli_query($link,"truncate application_events");
header("location: index.php"); // Přsesmeruje na přihlašovací stránku
?>
