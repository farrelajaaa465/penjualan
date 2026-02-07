<?php
session_start();
include '../koneksi.php';

// Proses form submit
if(isset($_POST['simpan'])){
    $nama_barang = $_POST['nama_barang'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];
    $stok = $_POST['stok'];

    $insert = mysqli_query($koneksi, "INSERT INTO barang (nama_barang, harga_beli, harga_jual, stok) VALUES ('$nama_barang', '$harga_beli', '$harga_jual', '$stok')");

    if($insert){
        echo "<script>alert('Barang berhasil ditambahkan'); window.location='barang.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan barang');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Barang</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body { background-color: #f4f6f9; }
        .content { padding: 100px; }
    </style>
</head>
<body>


<!-- CONTENT -->
<div class="content">
    <h3 class="mb-4">Tambah Barang</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Harga Beli</label>
                    <input type="number" name="harga_beli" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Harga Jual</label>
                    <input type="number" name="harga_jual" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control" required>
                </div>

                <button type="submit" name="simpan" class="btn btn-primary"><i class="bi bi-check-circle"></i> Simpan</button>
                <a href="barang.php" class="btn btn-secondary"><i class="bi bi-arrow-left-circle"></i> Kembali</a>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
