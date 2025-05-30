<?php
header('Content-Type: application/json');
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'weathernews_db';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
  echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
  exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$id = isset($data['id']) ? intval($data['id']) : 0;

if ($id <= 0) {
  echo json_encode(['success' => false, 'message' => 'Invalid ID']);
  exit;
}

$stmt = $conn->prepare("DELETE FROM saved_countries WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
  echo json_encode(['success' => true, 'message' => 'Country deleted']);
} else {
  echo json_encode(['success' => false, 'message' => 'Delete failed: ' . $conn->error]);
}

$stmt->close();
$conn->close();
?>
