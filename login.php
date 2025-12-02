<?php
session_start();

// Jika sudah login, langsung ke dashboard
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Login sederhana
    if ($username === 'admin' && $password === '777') {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = 'Dosen';
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login - Polgan Mart</title>

<style>
    body {
        margin: 0;
        padding: 0;
        font-family: "Segoe UI", sans-serif;
        background: #f0f2f5;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .card {
        background: white;
        width: 370px;
        padding: 35px;
        border-radius: 16px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        text-align: center;
    }

    .logo {
        width: 70px;
        height: 70px;
        background: #3b82f6;
        border-radius: 14px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 26px;
        color: white;
        font-weight: bold;
        margin: 0 auto 20px;
    }

    h2 {
        margin-top: 0;
        font-weight: 600;
    }

    .subtitle {
        font-size: 14px;
        color: #555;
        margin-bottom: 25px;
    }

    input {
        width: 100%;
        padding: 12px;
        border-radius: 10px;
        border: 1px solid #d1d5db;
        margin-bottom: 15px;
        font-size: 15px;
    }
    input:focus {
        border-color: #3b82f6;
        outline: none;
    }

    .btn {
        width: 100%;
        padding: 12px;
        background: #3b82f6;
        border: none;
        color: white;
        border-radius: 10px;
        font-size: 16px;
        cursor: pointer;
        margin-bottom: 10px;
    }
    .btn:hover {
        background: #2563eb;
    }

    .btn-secondary {
        background: #e5e7eb;
        color: #111827;
    }
    .btn-secondary:hover {
        background: #d1d5db;
    }

    .error {
        color: #dc2626;
        margin-bottom: 15px;
        font-size: 14px;
    }

</style>
</head>
<body>

<div class="card">
    <div class="logo">PM</div>
    <h2>Login Admin</h2>
    <div class="subtitle">Sistem Penjualan Polgan Mart</div>

    <?php if (isset($error)) : ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="username" placeholder="Username" required>

        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" class="btn">Login</button>
        <button type="reset" class="btn btn-secondary">Batal</button>
    </form>
</div>

</body>
</html>
