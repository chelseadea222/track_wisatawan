<?php
// Untuk Vercel Production
$host     = getenv('TIDB_HOST') ?: 'gateway01.ap-southeast-1.prod.aws.tidbcloud.com';
$port     = getenv('TIDB_PORT') ?: 4000;
$db_name  = getenv('TIDB_DATABASE') ?: 'Tiket_Harian';
$username = getenv('TIDB_USER') ?: 'your_tidb_username';
$password = getenv('TIDB_PASSWORD') ?: 'your_tidb_password';

// Mencari lokasi sertifikat SSL
$ca_path = '/etc/ssl/certs/ca-certificates.crt'; 
if (!file_exists($ca_path)) {
    $ca_path = '/etc/pki/tls/certs/ca-bundle.crt'; 
}

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$db_name;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_SSL_CA => $ca_path,
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false
    ]);
} catch (PDOException $e) {
    die("<b style='color:red'>Koneksi database gagal:</b> " . $e->getMessage());
}
?>