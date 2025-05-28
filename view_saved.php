<?php
header('Content-Type: application/json');
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
