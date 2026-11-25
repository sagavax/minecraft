<?php

include "includes/dbconnect.php";

header('Content-Type: application/json');

$gallery_name = trim($_POST['gallery_name'] ?? '');

if ($gallery_name === '') {
    echo json_encode(['exists' => false]);
    exit;
}

$stmt = mysqli_prepare($link, "SELECT 1 FROM picture_galleries WHERE gallery_name = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "s", $gallery_name);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
$exists = mysqli_stmt_num_rows($stmt) > 0;
mysqli_stmt_close($stmt);

echo json_encode(['exists' => $exists]);
