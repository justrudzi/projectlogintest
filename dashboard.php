<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - POLGAN MART</title>
</head>
<body>
    <h2>-- POLGAN MART --</h2>
    <p>Selamat datang, <?php echo $_SESSION['username']; ?>!</p>
    <a href="logout.php">Logout</a>
    <hr>

    <?php
    // Data produk
    $kode_barang = array("BRG001", "BRG002", "BRG003", "BRG004", "BRG005");
    $nama_barang = array("Sabun", "Shampoo", "Pasta Gigi", "Sikat Gigi", "Tisu");
    $harga_barang = array(3000, 12000, 8000, 5000, 10000);
    ?>

    <h3>Daftar Produk</h3>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Harga</th>
        </tr>

        <?php
        for ($i = 0; $i < count($kode_barang); $i++) {
            echo "<tr>";
            echo "<td>" . $kode_barang[$i] . "</td>";
            echo "<td>" . $nama_barang[$i] . "</td>";
            echo "<td>Rp " . number_format($harga_barang[$i], 0, ',', '.') . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
