<?php
// A JSON fájl elérési útja
$filePath = 'C:\\xampp_\\htdocs\\kkzrt\\gfts_data.json';

// Ellenőrizzük, hogy létezik-e a fájl
if (file_exists($filePath)) {
    // A GTFS adat fájl tartalmának betöltése
    $data = file_get_contents($filePath);
    
    // A válasz MIME típusának beállítása JSON-ra
    header('Content-Type: application/json');
    
    // A JSON adat visszaadása
    echo $data;
} else {
    // Hibaüzenet, ha a fájl nem található
    header('HTTP/1.1 404 Not Found');
    echo json_encode(['error' => 'Fájl nem található']);
}
?>
