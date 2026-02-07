<?php
session_start();
include '../koneksi.php';

$data_user = mysqli_query($koneksi, "SELECT * FROM user");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data User</title>

    <!-- Bootstrap 5 CSS -->
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
                <a href="index.php" class="nav-link text-white">
                    <i class="bi bi-speedometer2 me-2"></i> Beranda
                </a>
            </li>
            <li class="nav-item">
                <a href="user.php" class="nav-link active">
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
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Data User</h3>
        <a href="user_tambah.php" class="btn btn-dark">
            <i class="bi bi-plus-circle"></i> Tambah User
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">No</th>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>Status</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no = 1; while($u = mysqli_fetch_assoc($data_user)) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $u['username'] ?></td>
                        <td><?= $u['user_nama'] ?></td>
                        <td>
                            <?php if ($u['user_status'] == 1) : ?>
                                <span class="badge bg-danger">
                                    <i class="bi bi-shield-lock"></i> Admin
                                </span>
                            <?php elseif ($u['user_status'] == 2) : ?>
                                <span class="badge bg-success">
                                    <i class="bi bi-person-badge"></i> Kasir
                                </span>
                            <?php else : ?>
                                <span class="badge bg-secondary">Tidak Diketahui</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="user_edit.php?id=<?= $u['user_id'] ?>" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="user_hapus.php?id=<?= $u['user_id'] ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Yakin ingin menghapus user ini?')">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
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
