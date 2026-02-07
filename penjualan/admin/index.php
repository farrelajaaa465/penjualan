<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['username'])) {
    $_SESSION['login_required'] = "Silakan login terlebih dahulu";
    header("Location: ../index.php");
    exit;
}

$query = "
SELECT p.id_jual, b.nama_barang, p.jumlah, p.total_harga, u.user_nama AS nama_kasir
FROM penjualan p
JOIN barang b ON p.id_barang = b.id_barang
JOIN user u ON p.user_id = u.user_id
WHERE u.user_status = 2
ORDER BY p.id_jual DESC
";
$data_penjualan = mysqli_query($koneksi, $query);


$q_total_transaksi = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total_transaksi FROM penjualan"
);
$total_transaksi = mysqli_fetch_assoc($q_total_transaksi);


$q_stok_barang = mysqli_query(
    $koneksi,
    "SELECT nama_barang, stok FROM barang ORDER BY nama_barang ASC"
);
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Penjualan</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
        }
        .sidebar {
            width: 250px;
            min-height: 100vh;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar bg-dark text-white position-fixed">
    <div class="p-3">
        <h4 class="text-center mb-4">Admin</h4>
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a href="dashboard.php" class="nav-link active">
                    <i class="bi bi-speedometer2 me-2"></i> Beranda
                </a>
            </li>
            <li class="nav-item">
                <a href="user.php" class="nav-link text-white">
                    <i class="bi bi-people me-2"></i> User
                </a>
            </li>
            <li class="nav-item">
                <a href="barang.php" class="nav-link text-white">
                    <i class="bi bi-box-seam me-2"></i> Barang
                </a>
            </li>
            <li class="nav-item">
                <a href="penjualan.php" class="nav-link text-white">
                    <i class="bi bi-cart-check me-2"></i> Penjualan
                </a>
            </li>
            <li class="nav-item">
                <a href="ganti_password.php" class="nav-link text-white">
                    <i class="bi bi-lock me-2"></i> Ganti Password
                </a>
            </li>
            <li class="nav-item mt-3">
                <a href="../logout.php" class="nav-link text-danger">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- CONTENT -->
<div class="content">
    <div class="row mb-4">
    <!-- CARD TOTAL TRANSAKSI -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <i class="bi bi-receipt fs-1 text-primary"></i>
                <h6 class="mt-2">Total Transaksi</h6>
                <h3 class="fw-bold">
                    <?= $total_transaksi['total_transaksi']; ?>
                </h3>
            </div>
        </div>
    </div>

    <!-- CARD STOK BARANG -->
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="mb-3">
                    <i class="bi bi-box-seam me-2"></i>Stok Barang
                </h6>

                <table class="table table-sm table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Barang</th>
                            <th width="30%">Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($b = mysqli_fetch_assoc($q_stok_barang)) : ?>
                        <tr>
                            <td><?= $b['nama_barang']; ?></td>
                            <td><?= $b['stok']; ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

    <h3 class="mb-4">Data Penjualan</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">No</th>
                        <th>ID Penjualan</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Nama Kasir</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no = 1; while($p = mysqli_fetch_assoc($data_penjualan)) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $p['id_jual'] ?></td>
                        <td><?= $p['nama_barang'] ?></td>
                        <td><?= $p['jumlah'] ?></td>
                        <td>Rp <?= number_format($p['total_harga'], 0, ',', '.') ?></td>
                        <td><?= $p['nama_kasir'] ?></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
