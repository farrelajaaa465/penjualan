<?php
session_start();
include '../koneksi.php';

// Ambil data user berdasarkan ID
$id = $_GET['id'];
$user = mysqli_query($koneksi, "SELECT * FROM user WHERE user_id = '$id'");
$data = mysqli_fetch_assoc($user);

if(!$data){
    echo "<script>alert('User tidak ditemukan'); window.location='user.php';</script>";
    exit;
}

// Proses form submit
if(isset($_POST['simpan'])){
    $username = $_POST['username'];
    $nama_lengkap = $_POST['user_nama'];
    $status = $_POST['user_status'];

    // Password diupdate hanya jika diisi
   $update = mysqli_query(
    $koneksi,
    "UPDATE user 
     SET username='$username',
         user_nama='$nama_lengkap',
         user_status='$status'
     WHERE user_id='$id'"
);


    if($update){
        echo "<script>alert('User berhasil diupdate'); window.location='user.php';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate user');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
        }
        .content {
            margin: 0 auto;
            padding: 100px;
        }
    </style>
</head>
<body>


<!-- CONTENT -->
<div class="content">
    <h3 class="mb-4">Edit User</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" value="<?= $data['username'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="user_nama" class="form-control" value="<?= $data['user_nama'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="user_status" class="form-select" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="1" <?= $data['user_status']==1?'selected':'' ?>>Admin</option>
                        <option value="2" <?= $data['user_status']==2?'selected':'' ?>>Kasir</option>
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
