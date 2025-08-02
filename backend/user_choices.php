<?php
// Koneksi database
$host = 'localhost';
$db   = 'pesanterakhir';
$user = 'pesanterakhir';
$pass = 'Totoro123!';
$dsn  = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Ambil semua data dari tabel user_choices
$stmt = $pdo->query("SELECT * FROM user_choices ORDER BY timestamp DESC");
$choices = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pilihan Pengguna</title>
    <style>
        body {
            background-color: #1F1F1F;
            color: #f5f5f5;
            font-family: Arial, sans-serif;
            padding: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #2C2C2C;
        }
        th, td {
            padding: 12px;
            border: 1px solid #444;
            text-align: left;
        }
        th {
            background-color: #8B4513;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #333;
        }
    </style>
</head>
<body>
    <h1>Data Pilihan Pengguna</h1>
    <?php if (count($choices) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Session ID</th>
                    <th>Key</th>
                    <th>Value</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($choices as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['session_id']) ?></td>
                        <td><?= htmlspecialchars($row['choice_key']) ?></td>
                        <td><?= htmlspecialchars($row['choice_value']) ?></td>
                        <td>
                            <?php
                                $dt = new DateTime($row['timestamp'], new DateTimeZone('UTC'));
                                $dt->setTimezone(new DateTimeZone('Asia/Jakarta'));
                                echo $dt->format('Y-m-d H:i:s') . ' WIB';
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tidak ada data pilihan pengguna.</p>
    <?php endif; ?>
</body>
</html>
