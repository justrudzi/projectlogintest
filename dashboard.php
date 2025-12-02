<?php
session_start();

// Cek login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

// Fungsi hapus format rupiah
function cleanRupiah($angka) {
    return intval(str_replace(["Rp", ".", " "], "", $angka));
}

// Data Barang
$barangList = [
    "BRG001" => ["nama" => "Sabun Mandi", "harga" => 15000],
    "BRG002" => ["nama" => "Sikat Gigi", "harga" => 8000],
    "BRG003" => ["nama" => "Pasta Gigi", "harga" => 12000],
    "BRG004" => ["nama" => "Shampoo", "harga" => 17000],
    "BRG005" => ["nama" => "Handuk", "harga" => 25000]
];

// Tambah barang
if (isset($_POST['tambah'])) {
    $kode   = $_POST['kode'];
    $nama   = $_POST['nama'];
    $harga  = intval($_POST['harga']);
    $jumlah = intval($_POST['jumlah']);
    $total  = $harga * $jumlah;

    $_SESSION['cart'][] = [
        "kode"   => $kode,
        "nama"   => $nama,
        "harga"  => $harga,
        "jumlah" => $jumlah,
        "total"  => $total
    ];
}

// Reset keranjang
if (isset($_POST['reset'])) {
    unset($_SESSION['cart']);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>POLGAN MART - Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
body {
    font-family: Poppins, sans-serif;
    background: #f3f5f9;
    margin: 0;
}

header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 35px;
    background: white;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}

.logo-box {
    display: flex;
    align-items: center;
    gap: 12px;
}

.logo {
    width: 48px;
    height: 48px;
    background: #3b82f6;
    color: white;
    font-weight: 600;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 12px;
    font-size: 18px;
}

.container {
    max-width: 950px;
    margin: 35px auto;
    background: white;
    padding: 25px;
    border-radius: 14px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

input, select {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    margin-bottom: 12px;
    font-size: 15px;
}

.btn {
    padding: 10px 16px;
    border: none;
    cursor: pointer;
    border-radius: 8px;
    font-size: 15px;
}

.btn-primary {
    background: #3b82f6;
    color: white;
}

.btn-secondary {
    background: #e5e7eb;
    color: #374151;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 25px;
}

th, td {
    padding: 12px;
    border-bottom: 1px solid #e5e7eb;
}

.result-box {
    margin-top: 25px;
    padding: 18px;
    font-size: 18px;
    background: #f8fafc;
    border-radius: 10px;
    display: flex;
    justify-content: space-between;
}
</style>

<script>
// Data barang dari PHP → JS
let dataBarang = <?php echo json_encode($barangList); ?>;

// Auto isi nama & harga
function isiBarang() {
    let kode = document.getElementById("kodeBarang").value;

    if (kode && dataBarang[kode]) {
        document.getElementById("namaBarang").value = dataBarang[kode].nama;
        document.getElementById("hargaBarang").value = dataBarang[kode].harga;
    } else {
        document.getElementById("namaBarang").value = "";
        document.getElementById("hargaBarang").value = "";
    }
}
</script>

</head>
<body>

<header>
    <div class="logo-box">
        <div class="logo">PM</div>
        <div>
            <b>--POLGAN MART--</b><br>
            <span style="font-size:13px; color:#6b7280;">Sistem Penjualan Sederhana</span>
        </div>
    </div>

    <div>
        Selamat datang, <b><?= $_SESSION['username']; ?></b><br>
        <small style="color:#6b7280;">Role: Admin</small>

        <form method="post" action="logout.php">
            <button class="logout-btn">Logout</button>
        </form>
    </div>
</header>

<div class="container">

    <h3>Input Barang</h3>
    <form method="post">

        <label>Kode Barang</label>
        <select name="kode" id="kodeBarang" onchange="isiBarang()" required>
            <option value="">Pilih Kode Barang</option>
            <?php foreach ($barangList as $kode => $b): ?>
                <option value="<?= $kode ?>"><?= $kode ?> - <?= $b['nama'] ?></option>
            <?php endforeach; ?>
        </select>

        <label>Nama Barang</label>
        <input type="text" id="namaBarang" name="nama" readonly>

        <label>Harga</label>
        <input type="text" id="hargaBarang" name="harga" readonly>

        <label>Jumlah</label>
        <input type="number" name="jumlah" required>

        <button class="btn btn-primary" name="tambah">Tambahkan</button>
        <button type="reset" class="btn btn-secondary">Batal</button>
    </form>

    <h3 style="margin-top:35px;">Daftar Pembelian</h3>

    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $grand = 0;
            if (!empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $b) {
                    echo "<tr>
                        <td>{$b['kode']}</td>
                        <td>{$b['nama']}</td>
                        <td>Rp " . number_format($b['harga'], 0, ',', '.') . "</td>
                        <td>{$b['jumlah']}</td>
                        <td>Rp " . number_format($b['total'], 0, ',', '.') . "</td>
                    </tr>";
                    $grand += $b['total'];
                }
            }
            ?>
        </tbody>
    </table>

    <?php
    if ($grand < 50000) $disc = 5;
    elseif ($grand <= 100000) $disc = 10;
    else $disc = 15;

    $potongan = ($grand * $disc) / 100;
    $final = $grand - $potongan;
    ?>

    <div class="result-box">
        <span>Total Belanja</span>
        <b>Rp <?= number_format($grand,0,',','.'); ?></b>
    </div>

    <div class="result-box">
        <span>Diskon (<?= $disc ?>%)</span>
        <b>Rp <?= number_format($potongan,0,',','.'); ?></b>
    </div>

    <div class="result-box">
        <span>Total Bayar</span>
        <b>Rp <?= number_format($final,0,',','.'); ?></b>
    </div>

    <form method="post">
        <button name="reset" class="btn btn-secondary" style="margin-top:15px;">Kosongkan Keranjang</button>
    </form>

</div>

</body>
</html>
