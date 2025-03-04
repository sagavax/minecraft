<?php 
include("includes/dbconnect.php");

// Check if the database connection is successful
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT a.video_title, a.edition, a.video_url FROM videos a,video_tags b, tags_list c WHERE a.video_id = b.video_id AND b.tag_id = c.tag_id AND c.tag_name LIKE '%-farm%' GROUP BY video_title";
$result = mysqli_query($link, $sql);

// Check if the query was successful
if (!$result) {
    die("Error in SQL query: " . mysqli_error($link));
}

// Open a file handle for writing
$filename = 'export_farms_' . time() . '.csv';
$file = fopen('exports/' . $filename, 'w');

// Check if file handle is opened successfully
if (!$file) {
    die("Error opening file: exports/$filename");
}

// Write headers
$headers = array('video_title', 'video_description', 'video_url'); // Replace with actual column names
fputcsv($file, $headers);

// Write data rows
while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($file, $row);
}

// Close the file handle
fclose($file);

// Check if file was written successfully
if ($file) {
    echo "Data exported successfully.";
} else {
    echo "Error exporting data.";
}

// Close the database connection
mysqli_close($link);
?>
