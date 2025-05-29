<?php
header('Content-Type: application/json');
<<<<<<< HEAD
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'weathernews_db';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
  echo json_encode(['error' => "Connection failed: " . $conn->connect_error]);
  exit;
}

$sql = "SELECT name, capital, latlng FROM saved_countries ORDER BY name ASC";
$result = $conn->query($sql);

if (!$result) {
  echo json_encode(['error' => "Query failed: " . $conn->error]);
  $conn->close();
  exit;
}

$saved = [];
while ($row = $result->fetch_assoc()) {
  $saved[] = $row;
}

echo json_encode($saved);
$conn->close();
=======

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
>>>>>>> 7dc55a37406ce8f843c04974124e2003c3528d85
