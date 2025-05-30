<?php
header('Content-Type: application/json');

$host = 'localhost';
$dbname = 'weathernews_db';
$user = 'root'; // change if needed
$pass = '';     // change if needed

try {
    // Connect to MySQL without selecting a DB first
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create DB if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE $dbname");

    // Create table if it doesn't exist
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS saved_countries (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            capital VARCHAR(100),
            latlng VARCHAR(100),
            saved_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    // Now fetch data
    $stmt = $pdo->query("SELECT name, capital, latlng FROM saved_countries ORDER BY saved_at DESC");
    $countries = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($countries);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
