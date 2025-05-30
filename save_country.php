<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$user = 'root';    
$pass = '';        
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
 }

$name = $conn->real_escape_string($data['name']);
$capital = $conn->real_escape_string($data['capital']);
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
}

$conn->close();
