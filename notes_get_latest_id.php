<?php
include "includes/dbconnect.php";
include "includes/functions.php";

$getlatestnote = "SELECT MAX(id) as last_id FROM notes";
$result = mysqli_query($link, $getlatestnote) or die("MySQLi ERROR: " . mysqli_error($link));

$last_note = null;
if ($row = mysqli_fetch_assoc($result)) {
    $last_note = $row['last_id'];
}

// Vráti hodnotu jako JSON, aby mohol JS správne načítať
header('Content-Type: application/json');
echo json_encode(['noteId' => $last_note]);
?>