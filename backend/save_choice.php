<?php
// Koneksi database
$host = 'localhost';
$db   = 'pesanterakhir';
$user = 'pesanterakhir';
$pass = 'totoro123';
$dsn  = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed', 'details' => $e->getMessage()]);
    exit;
}

// Ambil data dari JS
$data = json_decode(file_get_contents('php://input'), true);

$session_id = session_id();
$choice_key = $data['key'] ?? null;
$choice_value = $data['value'] ?? null;

if ($choice_key && $choice_value) {
    $stmt = $pdo->prepare("INSERT INTO user_choices (session_id, choice_key, choice_value) VALUES (?, ?, ?)");
    $stmt->execute([$session_id, $choice_key, $choice_value]);
    echo json_encode(['status' => 'success']);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid data']);
}
?>
