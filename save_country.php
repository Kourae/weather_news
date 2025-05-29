<?php
header('Content-Type: application/json');
<<<<<<< HEAD
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$user = 'root';    // Update if different
$pass = '';        // Update if different
$dbname = 'weathernews_db';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
  echo json_encode(['message' => 'Database connection failed']);
  exit;
}

$data = json_decode(file_get_contents('php://input'), true);
if (!$data || !isset($data['name']) || !isset($data['capital'])) {
  echo json_encode(['message' => 'Invalid data']);
  exit;
=======

$host = 'localhost';
$user = 'root'; // change this if needed
$pass = '';     // change this if needed
$dbname = 'weathernews_db';

// Connect to MySQL server (no DB selected yet)
$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed']));
}

// Create database if it doesn't exist
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

// Select the database
$conn->select_db($dbname);

// Create table if not exists
$conn->query("
    CREATE TABLE IF NOT EXISTS saved_countries (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        capital VARCHAR(100),
        latlng VARCHAR(100),
        saved_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");

// Read JSON input
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['name']) || !isset($data['capital']) || !isset($data['latlng'])) {
    echo json_encode(['error' => 'Invalid input']);
    exit;
>>>>>>> 7dc55a37406ce8f843c04974124e2003c3528d85
}

$name = $conn->real_escape_string($data['name']);
$capital = $conn->real_escape_string($data['capital']);
<<<<<<< HEAD
$latlng = isset($data['latlng']) ? $conn->real_escape_string($data['latlng']) : '';

$sql_check = "SELECT id FROM saved_countries WHERE name='$name'";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows > 0) {
  echo json_encode(['message' => 'Country already saved']);
  $conn->close();
  exit;
}

$sql = "INSERT INTO saved_countries (name, capital, latlng) VALUES ('$name', '$capital', '$latlng')";
if ($conn->query($sql) === TRUE) {
  echo json_encode(['message' => 'Country saved successfully!']);
} else {
  echo json_encode(['message' => 'Failed to save country']);
=======
$latlng = $conn->real_escape_string($data['latlng']);

$sql = "INSERT INTO saved_countries (name, capital, latlng) VALUES ('$name', '$capital', '$latlng')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['message' => 'Country saved successfully']);
} else {
    echo json_encode(['error' => 'Failed to save country']);
>>>>>>> 7dc55a37406ce8f843c04974124e2003c3528d85
}

$conn->close();
