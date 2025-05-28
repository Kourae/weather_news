<?php
header('Content-Type: application/json');
require 'includes/db.php';

// Expect POST JSON data
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

$name = $data['name'] ?? '';
$capital = $data['capital'] ?? '';
$region = $data['region'] ?? '';
$population = $data['population'] ?? '';
$weather = $data['weather'] ?? '';

if (!$name || !$capital || !$region || !$population || !$weather) {
    echo json_encode(['success' => false, 'message' => 'Missing required data']);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO saved_countries (name, capital, region, population, weather) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $capital, $region, $population, $weather]);
    echo json_encode(['success' => true, 'message' => 'Country saved successfully']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'DB Error: ' . $e->getMessage()]);
}
