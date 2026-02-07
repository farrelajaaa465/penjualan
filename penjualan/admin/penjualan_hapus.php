<?php
session_start();
include '../koneksi.php';

if(!isset($_GET['id'])){
    echo "<script>alert('ID penjualan tidak ditemukan'); window.location='penjualan.php';</script>";
    exit;
}

$id = $_GET['id'];

// Ambil data penjualan
$penjualan = mysqli_query($koneksi, "SELECT * FROM penjualan WHERE id_jual='$id'");
$data = mysqli_fetch_assoc($penjualan);

if(!$data){
    echo "<script>alert('Data penjualan tidak ditemukan'); window.location='penjualan.php';</script>";
    exit;
}

// Kembalikan stok barang
$id_barang = $data['id_barang'];
$jumlah = $data['jumlah'];

// Ambil stok barang saat ini
$barang = mysqli_query($koneksi, "SELECT * FROM barang WHERE id_barang='$id_barang'");
$b = mysqli_fetch_assoc($barang);
$stok_baru = $b['stok'] + $jumlah;

// Update stok barang
mysqli_query($koneksi, "UPDATE barang SET stok='$stok_baru' WHERE id_barang='$id_barang'");

// Hapus penjualan
mysqli_query($koneksi, "DELETE FROM penjualan WHERE id_jual='$id'");

echo "<script>alert('Penjualan berhasil dihapus'); window.location='penjualan.php';</script>";
exit;
?>
