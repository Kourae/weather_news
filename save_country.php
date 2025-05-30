<?php
header('Content-Type: application/json');

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
}

$name = $conn->real_escape_string($data['name']);
$capital = $conn->real_escape_string($data['capital']);
$latlng = $conn->real_escape_string($data['latlng']);

$sql = "INSERT INTO saved_countries (name, capital, latlng) VALUES ('$name', '$capital', '$latlng')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['message' => 'Country saved successfully']);
} else {
    echo json_encode(['error' => 'Failed to save country']);
}

$conn->close();
