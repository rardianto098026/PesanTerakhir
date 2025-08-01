<?php

$host = 'localhost';
$db   = 'pesanterakhir';
$user = 'pesanterakhir';
$pass = 'Totoro123!';
$dsn  = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed', 'details' => $e->getMessage()]);
    exit;
}

// Get passcode from POST data
$input = json_decode(file_get_contents('php://input'), true);
$code = isset($input['code']) ? trim($input['code']) : '';

if ($code === '') {
    http_response_code(400);
    echo json_encode(['error' => 'No passcode provided']);
    exit;
}

// Prepare SQL to check passcode
$stmt = $pdo->prepare("SELECT * FROM user WHERE passcode = ? LIMIT 1");
$stmt->execute([$code]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    echo json_encode(['status' => 'success', 'message' => $result['message'] ?? '']);
} else {
    echo json_encode(['status' => 'fail', 'error' => 'Incorrect passcode']);
}
