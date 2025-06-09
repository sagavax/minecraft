<?php 

function GetModPackName($modpack_id) {
    global $link;

    $modpack_id = intval($modpack_id); // zabezpeč proti injection
    $query = "SELECT name FROM modpacks WHERE modpack_id = $modpack_id";
    $result = mysqli_query($link, $query);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        return $row['name'];
    } else {
        return "Neznámy modpack"; // alebo prázdny string podľa preferencie
    }
}

?>


