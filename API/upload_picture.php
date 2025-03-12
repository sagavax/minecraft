<?php
// Zahrneme súbor pre pripojenie k databáze
include('includes/dbconnect.php');

// Nastavenie hlavičiek pre JSON odpoveď
header('Content-Type: application/json');

// Overenie, či bola požiadavka POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Získanie údajov zo žiadosti (predpokladáme, že údaje sú poslané cez JSON)
    $inputData = json_decode(file_get_contents("php://input"), true);

    // Overenie, či sú všetky potrebné údaje prítomné
    if (isset($inputData['picture_url']) && isset($inputData['picture_title']) && isset($inputData['picture_description']) && isset($inputData['cat_id'])) {
        $picture_url = $inputData['picture_url'];
        $picture_title = $inputData['picture_title'];
        $picture_description = $inputData['picture_description'];
        $cat_id = $inputData['cat_id'];
        $modpack_id = isset($inputData['modpack_id']) ? $inputData['modpack_id'] : 0;  // Ak modpack_id nie je poslaný, nastavíme ho na 0
        $added_date = date('Y-m-d H:i:s');  // Získame aktuálny čas

        // Príprava SQL dotazu na vloženie údajov do tabuľky
        $sql = "INSERT INTO pictures (picture_url, picture_title, picture_description, cat_id, modpack_id, added_date)
                VALUES (:picture_url, :picture_title, :picture_description, :cat_id, :modpack_id, :added_date)";

        try {
            // Vykonanie dotazu s príslušnými hodnotami
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':picture_url', $picture_url, PDO::PARAM_STR);
            $stmt->bindParam(':picture_title', $picture_title, PDO::PARAM_STR);
            $stmt->bindParam(':picture_description', $picture_description, PDO::PARAM_STR);
            $stmt->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
            $stmt->bindParam(':modpack_id', $modpack_id, PDO::PARAM_INT);
            $stmt->bindParam(':added_date', $added_date, PDO::PARAM_STR);

            // Vykonáme príkaz
            if ($stmt->execute()) {
                // Vrátime úspešnú odpoveď
                echo json_encode(["success" => true, "message" => "Obrázok bol úspešne uložený."]);
            } else {
                // Ak sa niečo pokazí
                echo json_encode(["success" => false, "message" => "Nastala chyba pri ukladaní údajov."]);
            }
        } catch (PDOException $e) {
            // Ak sa vyskytne chyba pri databáze
            echo json_encode(["success" => false, "message" => "Chyba databázy: " . $e->getMessage()]);
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
