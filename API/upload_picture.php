<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Zahrneme súbor pre pripojenie k databáze (predpokladám, že používate mysqli)
include('../includes/dbconnect.php');

// Nastavenie hlavičiek pre JSON odpoveď
header('Content-Type: application/json');

// Overenie, či bola požiadavka POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Získanie údajov zo žiadosti (predpokladáme, že údaje sú poslané cez JSON)
    $inputData = json_decode(file_get_contents("php://input"), true);

    // Overenie, či sú všetky potrebné údaje prítomné
    if (isset($inputData['picture_url']) && isset($inputData['picture_title']) && isset($inputData['picture_description']) && isset($inputData['picture_name']) && isset($inputData['picture_path']) && isset($inputData['cat_id'])) {
        $picture_url = $inputData['picture_url'];
        $picture_path = $inputData['picture_path'];
        $picture_name = $inputData['picture_name'];
        $picture_title = $inputData['picture_title'];
        $picture_description = $inputData['picture_description'];
        $cat_id = $inputData['cat_id'];
        $added_date = date('Y-m-d H:i:s');  // Získame aktuálny čas

        // Príprava SQL dotazu na vloženie údajov do tabuľky
        $sql = "INSERT INTO pictures (picture_url, picture_title, picture_description, picture_name, picture_path, cat_id, added_date)
                VALUES ('$picture_url', '$picture_title', '$picture_description', '$picture_name', '$picture_path', '$cat_id', '$added_date')";

        // Vykonanie dotazu
        if (mysqli_query($conn, $sql)) {
            // Vrátime úspešnú odpoveď
            echo json_encode(["success" => true, "message" => "Obrázok bol úspešne uložený."]);
        } else {
            // Ak sa niečo pokazí
            echo json_encode(["success" => false, "message" => "Nastala chyba pri ukladaní údajov."]);
        }
    } else {
        // Ak chýbajú povinné údaje
        echo json_encode(["success" => false, "message" => "Chýbajú požiadavky na obrázok."]);
    }
} else {
    // Ak požiadavka nie je POST
    echo json_encode(["success" => false, "message" => "Neplatná požiadavka."]);
}
?>
