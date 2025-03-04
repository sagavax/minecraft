<?php

date_default_timezone_set('Europe/Bratislava');

$backupDirectory = 'Backups';
$files = scandir($backupDirectory);

foreach ($files as $file) {
    // Skip . and ..
    if ($file == '.' || $file == '..') {
        continue;
    }

    
    // Get file modification time
    $filePath = "$backupDirectory/$file";
    $fileTime = filemtime($filePath);
    $fileModifiedDate = date("Y-m-d H:i:s", $fileTime);

    // Process each file
    echo "<div class='file-item'><div class='file_name'><i class='fas fa-file-alt'></i> ". $file . "</div><div class='file_date'>$fileModifiedDate</div><button class='button small_button' file-name=$file title='restore database'><i class='fa fa-recycle'></i></button> <button class='button small_button' title='remove the backup' file-name=$file><i class='fa fa-times'></i></button></div>";


}