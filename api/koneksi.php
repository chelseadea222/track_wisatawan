<?php
// koneksi.php - PDO Connection
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'bromo_tracking';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}

// Set timezone jika perlu
date_default_timezone_set('Asia/Jakarta');
?>