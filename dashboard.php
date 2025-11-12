<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - POLGAN MART</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto+Mono&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        header {
            background: #0d6efd;
            color: white;
            padding: 20px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        header h2 {
            margin: 0;
            letter-spacing: 1px;
        }

        .logout-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
        }

        .logout-btn:hover {
            background: #bb2d3b;
        }

        .container {
            max-width: 1000px;
            background: white;
            margin: 40px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        h3 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 10px;
        }

        table thead {
            background: #0d6efd;
            color: white;
        }

        table th, table td {
            padding: 12px 16px;
        }

        table th {
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 0.5px;
        }

        table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }

        table tbody tr:hover {
            background: #e9f3ff;
            transition: 0.3s;
        }

        .price {
            text-align: right;
            font-weight: 600;
            color: #0d6efd;
            white-space: nowrap;
        }

        .currency {
            display: inline-block;
            width: 40px;
            text-align: right;
            color: #0d6efd;
        }

        .amount {
            display: inline-block;
            width: 80px;
            text-align: right;
            font-family: 'Roboto Mono', monospace;
            color: #0d6efd;
        }

        .total-section {
            margin-top: 30px;
            padding: 25px;
            border-radius: 12px;
            background: linear-gradient(135deg, #0d6efd, #007bff);
            color: white;
            text-align: center;
            font-size: 22px;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        .total-section span {
            font-family: 'Roboto Mono', monospace;
            font-size: 24px;
        }

        .discount-box {
            background: #e9f9ef;
            border: 2px solid #198754;
            border-radius: 10px;
            padding: 20px;
            margin-top: 25px;
            text-align: center;
            color: #155724;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }

        .discount-box h4 {
            margin: 0;
            font-size: 18px;
            color: #0d6efd;
        }

        .discount-box p {
            font-size: 17px;
            margin-top: 10px;
        }

        footer {
            text-align: center;
            padding: 15px;
            color: #777;
            font-size: 14px;
            margin-top: 40px;
        }

        .welcome {
            text-align: center;
            margin-top: 10px;
            color: #555;
            font-weight: 500;
        }
    </style>
</head>
<body>

<header>
    <h2>-- POLGAN MART --</h2>
    <form action="logout.php" method="post">
        <button type="submit" class="logout-btn">Logout</button>
    </form>
</header>

<div class="container">
    <p class="welcome">Selamat datang, <strong><?php echo $_SESSION['username']; ?></strong> 👋</p>
    <h3>Detail Penjualan Hari Ini</h3>

    <?php
    // ===== Data produk =====
    $kode_barang = array("BRG001", "BRG002", "BRG003", "BRG004", "BRG005");
    $nama_barang = array("Sabun", "Shampoo", "Pasta Gigi", "Sikat Gigi", "Tisu");
    $harga_barang = array(3000, 12000, 8000, 5000, 10000);

    // ===== Logika penjualan acak =====
    $beli = array();
    $jumlah = array();
    $total = array();
    $grandtotal = 0;

    for ($i = 0; $i < 5; $i++) {
        $index = rand(0, count($kode_barang) - 1);
        $jml = rand(1, 5);

        $beli[] = $nama_barang[$index];
        $jumlah[] = $jml;
        $total[] = $harga_barang[$index] * $jml;
    }
    ?>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th style="text-align:right;">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($beli as $key => $nama) {
                echo "<tr>";
                echo "<td>{$no}</td>";
                echo "<td>{$nama}</td>";
                echo "<td>{$jumlah[$key]} pcs</td>";
                echo "<td class='price'><span class='currency'>Rp.</span><span class='amount'>" . number_format($total[$key], 0, ',', '.') . "</span></td>";
                echo "</tr>";

                $grandtotal += $total[$key];
                $no++;
            }
            ?>
        </tbody>
    </table>

    <div class="total-section">
        💰 TOTAL BELANJA:
        <span>Rp <?php echo number_format($grandtotal, 0, ',', '.'); ?></span>
    </div>

    <?php
    // ===== Perhitungan Diskon =====
    if ($grandtotal < 50000) {
        $diskon_persen = 5;
    } elseif ($grandtotal >= 50000 && $grandtotal <= 100000) {
        $diskon_persen = 10;
    } else {
        $diskon_persen = 15;
    }

    $diskon = ($diskon_persen / 100) * $grandtotal;
    $total_bayar = $grandtotal - $diskon;
    ?>

    <div class="discount-box">
        <h4>🎁 Diskon Belanja <?php echo $diskon_persen; ?>%</h4>
        <p>Potongan Harga: <strong>Rp <?php echo number_format($diskon, 0, ',', '.'); ?></strong></p>
        <p><b>Total Bayar Akhir:</b> Rp <?php echo number_format($total_bayar, 0, ',', '.'); ?></p>
    </div>

</div>

<footer>
    &copy; <?php echo date("Y"); ?> POLGAN MART. All Rights Reserved.
</footer>

</body>
</html>
