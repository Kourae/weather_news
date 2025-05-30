<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$user = 'root';        // Update if different
$pass = '';            // Update if different
$dbname = 'weathernews_db';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    echo json_encode(['message' => 'Database connection failed']);
    exit;
}

// Get JSON input
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

// Check if country already saved using prepared statement
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

// Insert new country using prepared statement
$stmt_insert = $conn->prepare("INSERT INTO saved_countries (name, capital, latlng) VALUES (?, ?, ?)");
$stmt_insert->bind_param('sss', $name, $capital, $latlng);

if ($stmt_insert->execute()) {
    echo json_encode(['message' => 'Country saved successfully!']);
} else {
    echo json_encode(['message' => 'Failed to save country']);
}

$stmt_insert->close();
$conn->close();
