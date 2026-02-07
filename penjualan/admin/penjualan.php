<?php
session_start();
include '../koneksi.php';

// Ambil semua penjualan beserta nama barang & kasir
$data = mysqli_query($koneksi, "
    SELECT p.id_jual, b.nama_barang, p.jumlah, p.tgl_jual, p.total_harga, u.user_nama 
    FROM penjualan p 
    JOIN barang b ON p.id_barang=b.id_barang 
    JOIN user u ON p.user_id=u.user_id 
    ORDER BY p.id_jual DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Penjualan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<style>
body { background-color: #f4f6f9; }
.sidebar { width: 250px; min-height: 100vh; }
.content { margin-left: 250px; padding: 20px; }
</style>
</head>
<body>
<div class="sidebar bg-dark text-white position-fixed">
    <div class="p-3">
        <h4 class="text-center mb-4">Admin</h4>
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a href="index.php" class="nav-link text-white">
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
                <a href="penjualan.php" class="nav-link active">
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

<div class="content">
        <div class="d-flex justify-content-between align-items-center mb-3">
<h3>Data  Penjualan</h3>
<a href="penjualan_tambah.php" class="btn btn-dark">
            <i class="bi bi-plus-circle"></i> Tambah Penjualan
        </a>
        </div><div class="card shadow-sm">
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Tanggal Jual</th>
                    <th>Total Harga</th>
                    <th>Kasir</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php $no=1; while($d=mysqli_fetch_assoc($data)): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $d['nama_barang'] ?></td>
                    <td><?= $d['jumlah'] ?></td>
                    <td><?= $d['tgl_jual'] ?></td>
                    <td>Rp <?= number_format($d['total_harga'],0,',','.') ?></td>
                    <td><?= $d['user_nama'] ?></td>
                    <td>
                        <a href="penjualan_edit.php?id=<?= $d['id_jual'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                        <a href="penjualan_hapus.php?id=<?= $d['id_jual'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus penjualan ini?')"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
