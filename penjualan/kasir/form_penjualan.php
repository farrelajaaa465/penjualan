<?php
include '../koneksi.php';
$query = "
SELECT p.id_jual, b.nama_barang, p.tgl_jual, p.total_harga, u.user_nama AS nama_kasir
FROM penjualan p
JOIN barang b ON p.id_barang = b.id_barang
JOIN user u ON p.user_id = u.user_id
WHERE u.user_status = 2
ORDER BY p.id_jual DESC
";

$data_riwayat = mysqli_query($koneksi, $query);
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
<div class="card card-custom">
<div class="card-body">
<h5 class="mb-3">Riwayat Transaksi</h5>
 <a href="penjualan_tambah.php" class="btn btn-dark mb-3"><i class="bi bi-plus-circle"></i> Tambah Penjualan</a>

<div class="table-responsive">
<table class="table table-bordered align-middle">
    <thead class="table-dark">
                    <tr>
                        <th width="5%">No</th>
                        <th>ID Penjualan</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Nama Kasir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no = 1; while($p = mysqli_fetch_assoc($data_riwayat)) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $p['id_jual'] ?></td>
                        <td><?= $p['nama_barang'] ?></td>
                        <td><?= $p['tgl_jual'] ?></td>
                        <td>Rp <?= number_format($p['total_harga'], 0, ',', '.') ?></td>
                        <td><?= $p['nama_kasir'] ?></td>
                         <td>
                        <a href="penjualan_edit.php?id=<?= $p['id_jual'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                        <a href="penjualan_hapus.php?id=<?= $p['id_jual'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus penjualan ini?')"><i class="bi bi-trash"></i></a>
                    </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
</table>
</div>

</div>
</div>

</main>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
