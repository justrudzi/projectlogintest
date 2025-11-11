<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>

    <?php
    echo "<h2>Selamat datang, " . $_SESSION['username'] . "!</h2>";
    ?>

    <p>Role: <?php echo $_SESSION['role']; ?></p>
    <a href="logout.php">Logout</a>

</body>
</html>
