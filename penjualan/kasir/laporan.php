<?php
include '../koneksi.php';
$tgl_jual = $_GET['tgl_jual'] ?? '';

$where = "";
if ($tgl_jual) {
    $where = "WHERE DATE(p.tgl_jual) = '$tgl_jual'";
}

// ambil data laporan
$q = mysqli_query($koneksi, "
    SELECT 
        p.id_jual,
        p.jumlah AS qty,
        p.total_harga,
        b.nama_barang,
        b.harga_jual,
        u.user_nama AS kasir,
        p.tgl_jual
    FROM penjualan p
    JOIN barang b ON p.id_barang = b.id_barang
    JOIN user u ON p.user_id = u.user_id
    $where
    ORDER BY p.tgl_jual DESC
");

// total
$qt = mysqli_query($koneksi, "
    SELECT SUM(total_harga) AS grand_total
    FROM penjualan p
    $where
");
$total = mysqli_fetch_assoc($qt)['grand_total'] ?? 0;
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Kasir</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body { background-color: #f5f5f5; }
        .sidebar { min-height: 100vh; background-color: #000; }
        .sidebar a { color: #fff; text-decoration: none; }
        .sidebar a:hover { background-color: #fff; color: #000; }
        .card-custom { border: 2px solid #000; }
        thead { background-color: #000; color: #fff; }
    </style>
</head>
<body>

<div class="container-fluid">
<div class="row">

<!-- SIDEBAR -->
<nav class="col-md-3 col-lg-2 sidebar p-3">
    <h4 class="text-center border-bottom pb-2 mb-3 text-white">KASIR</h4>
    <ul class="nav flex-column gap-1">
        <li class="nav-item"><a class="nav-link text-white" href="index.php"><i class="bi bi-house-door me-2"></i>Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="form_penjualan.php"><i class="bi bi-cart-check me-2"></i>Transaksi</a></li>
        <li class="nav-item"><a class="nav-link" href="laporan.php"><i class="bi bi-file-earmark-bar-graph me-2"></i>Laporan</a></li>
        <li class="nav-item"><a class="nav-link text-danger" href="../logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
    </ul>
</nav>

<!-- MAIN -->
<main class="col-md-9 col-lg-10 px-4 py-4">

<h2 class="mb-4">Dashboard Kasir</h2>

<!-- SUMMARY -->


<!-- TABLE RIWAYAT -->
<div class="content">
    <div class="card card-custom">
<div class="card-body">
    <h4 class="mb-3">Laporan Penjualan</h4>

    <!-- FILTER TANGGAL -->
    <form method="get" class="mb-3">
        <label class="me-2">Tanggal Jual</label>
        <input type="date" name="tgl_jual" class="form-control d-inline-block w-auto" value="<?= htmlspecialchars($tgl_jual) ?>" required>
        <button class="btn btn-dark ms-2"><i class="bi bi-search"></i> Cari</button>
        <a href="laporan.php" class="btn btn-secondary ms-2"> <i class="bi bi-arrow-clockwise"></i> Reset</a>
    </form>

    <!-- TABEL -->
    <div class="table-responsive">
    <table class="table table-bordered table-striped bg-white">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Tanggal Jual</th>
                <th>Barang</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Total</th>
                <th>Kasir</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; if(mysqli_num_rows($q)>0): while($r=mysqli_fetch_assoc($q)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $r['tgl_jual'] ?></td>
                <td><?= $r['nama_barang'] ?></td>
                <td><?= $r['qty'] ?></td>
                <td>Rp <?= number_format($r['harga_jual'],0,',','.') ?></td>
                <td>Rp <?= number_format($r['total_harga'],0,',','.') ?></td>
                <td><?= $r['kasir'] ?></td>
                <td>
                    <a href="invoice.php?id=<?= $r['id_jual'] ?>" class="btn btn-sm btn-dark"> <i class="bi bi-file-earmark-text"></i> Invoice</a>
                </td>
            </tr>
        <?php endwhile; else: ?>
            <tr>
                <td colspan="8" class="text-center">Data tidak ada</td>
            </tr>
        <?php endif; ?>
        </tbody>
        <tfoot>
            <tr class="fw-bold">
                <td colspan="5" class="text-end">TOTAL</td>
                <td colspan="3">Rp <?= number_format($total,0,',','.') ?></td>
            </tr>
        </tfoot>
    </table>
    </div>
</div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
