<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'weathernews_db';

// Step 1: Connect to MySQL server without selecting database
$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) {
    echo json_encode(['message' => 'Database connection failed']);
    exit;
}

// Step 2: Create database if not exists
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");

// Step 3: Select the database
$conn->select_db($dbname);

// Step 4: Create table if not exists
$createTableSQL = "CREATE TABLE IF NOT EXISTS saved_countries (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  capital VARCHAR(100),
  latlng VARCHAR(100)
)";
$conn->query($createTableSQL);

// Step 5: Get JSON input
$data = json_decode(file_get_contents('php://input'), true);

if (
    !$data ||
    empty($data['name']) ||
    empty($data['capital'])
) {
    echo json_encode(['message' => 'Invalid data']);
    $conn->close();
    exit;
}

$name = $data['name'];
$capital = $data['capital'];
$latlng = isset($data['latlng']) ? $data['latlng'] : '';

// Step 6: Check for duplicates
$stmt_check = $conn->prepare("SELECT id FROM saved_countries WHERE name = ?");
$stmt_check->bind_param('s', $name);
$stmt_check->execute();
$stmt_check->store_result();

if ($stmt_check->num_rows > 0) {
    echo json_encode(['message' => 'Country already saved']);
    $stmt_check->close();
    $conn->close();
    exit;
}
$stmt_check->close();

// Step 7: Insert new record
$stmt_insert = $conn->prepare("INSERT INTO saved_countries (name, capital, latlng) VALUES (?, ?, ?)");
$stmt_insert->bind_param('sss', $name, $capital, $latlng);

if ($stmt_insert->execute()) {
    echo json_encode(['message' => 'Country saved successfully!']);
} else {
    echo json_encode(['message' => 'Failed to save country']);
}

$stmt_insert->close();
$conn->close();
