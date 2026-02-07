<?php
session_start();
include '../koneksi.php';

// Ambil ID barang
$id = $_GET['id'];
$barang = mysqli_query($koneksi, "SELECT * FROM barang WHERE id_barang='$id'");
$data = mysqli_fetch_assoc($barang);

if(!$data){
    echo "<script>alert('Barang tidak ditemukan'); window.location='barang.php';</script>";
    exit;
}

// Proses form submit
if(isset($_POST['simpan'])){
    $nama_barang = $_POST['nama_barang'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];
    $stok = $_POST['stok'];

    $update = mysqli_query($koneksi, "UPDATE barang SET 
        nama_barang='$nama_barang', 
        harga_beli='$harga_beli', 
        harga_jual='$harga_jual', 
        stok='$stok' 
        WHERE id_barang='$id'");

    if($update){
        echo "<script>alert('Barang berhasil diupdate'); window.location='barang.php';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate barang');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; }
        
        .content { padding: 20px; }
    </style>
</head>
<body>

<div class="content">
    <h3 class="mb-4">Edit Barang</h3>
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" value="<?= $data['nama_barang'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Harga Beli</label>
                    <input type="number" name="harga_beli" class="form-control" value="<?= $data['harga_beli'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Harga Jual</label>
                    <input type="number" name="harga_jual" class="form-control" value="<?= $data['harga_jual'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control" value="<?= $data['stok'] ?>" required>
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
