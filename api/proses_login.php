<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'koneksi.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$email || !$password) {
        $error = 'Email dan password wajib diisi!';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            // Pengecekan password
            if ($user && password_verify($password, $user['password'])) {
                // Normalize role
                $role = strtolower($user['role']);
                
                // Validasi role harus admin atau user
                if ($role !== 'admin' && $role !== 'user') {
                    $error = 'Role pengguna tidak valid. Hubungi administrator.';
                } else {
                    // Set session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['nama'] = $user['nama'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $role;

                    // Tentukan target URL berdasarkan role
                    $target_url = ($role === 'admin') ? 'tiket_harian.php' : 'tiket.php';
                    
                    if (!headers_sent()) {
                        header("Location: " . $target_url);
                        exit;
                    } else {
                        echo "<script>window.location.href='" . $target_url . "';</script>";
                        exit;
                    }
                }
            } else {
                $error = 'Email atau password salah!';
            }
        } catch (PDOException $e) {
            $error = 'Terjadi kesalahan sistem. Silakan coba lagi.';
            // Untuk debugging, bisa di-uncomment baris berikut:
            // $error = $e->getMessage();
        }
    }
}
?>