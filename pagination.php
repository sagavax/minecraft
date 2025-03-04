<?php
// Assuming you have a database connection
$servername = "your_servername";
$username = "your_username";
$password = "your_password";
$dbname = "your_dbname";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define the number of items per page
$itemsPerPage = 10;

// Get the current page number from the URL, default to 1 if not set
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the offset for the SQL query based on the current page
$offset = ($current_page - 1) * $itemsPerPage;

// Fetch data from the database using LIMIT and OFFSET
$sql = "SELECT * FROM your_table LIMIT $itemsPerPage OFFSET $offset";
$result = $conn->query($sql);

// Display the fetched data
while ($row = $result->fetch_assoc()) {
    echo $row['column1'] . ' - ' . $row['column2'] . '<br>';
}

// Calculate the total number of pages
$sql = "SELECT COUNT(*) as total FROM your_table";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$totalItems = $row['total'];
$totalPages = ceil($totalItems / $itemsPerPage);

// Display pagination links
echo '<div class="pagination">';
for ($i = 1; $i <= $totalPages; $i++) {
    echo '<a href="?page=' . $i . '">' . $i . '</a>';
}
echo '</div>';

// Close the database connection
$conn->close();
?>
