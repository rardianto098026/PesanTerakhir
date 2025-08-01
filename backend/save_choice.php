<?php
// session_start(); // Uncomment if you need to use session_id()

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
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

try {
    // Get JSON data from JS
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid or missing JSON input']);
        exit;
    }

    $choice_key = $data['key'] ?? null;
    $choice_value = $data['value'] ?? null;

    if ($choice_key && $choice_value) {
        $stmt = $pdo->prepare("INSERT INTO user_choices (session_id, choice_key, choice_value) VALUES (?, ?, ?)");
        $stmt->execute(["session", $choice_key, $choice_value]); // Replace "session" with session_id() if needed
        echo json_encode(['status' => 'success']);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Missing key or value']);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Query failed', 'details' => $e->getMessage()]);
}
