<?php
session_start();
include '../koneksi.php';

// Proses form submit
if(isset($_POST['simpan'])) {
    $username = $_POST['username'];
    $nama_lengkap = $_POST['user_nama'];
    $password = md5($_POST['password']);
    $status = $_POST['user_status'];

    $insert = mysqli_query($koneksi, "INSERT INTO user (username, user_nama, password, user_status) VALUES ('$username', '$nama_lengkap', '$password', '$status')");

    if($insert) {
        echo "<script>alert('User berhasil ditambahkan'); window.location='user.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan user');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah User</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
        }
        .content {
            margin: center;
            padding: 100px;
        }
    </style>
</head>
<body>



<!-- CONTENT -->
<div class="content">
    <h3 class="mb-4">Tambah User</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="user_nama" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="user_status" class="form-select" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="1">Admin</option>
                        <option value="2">Kasir</option>
                    </select>
                </div>

                <button type="submit" name="simpan" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Simpan
                </button>
                <a href="user.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle"></i> Kembali
                </a>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
