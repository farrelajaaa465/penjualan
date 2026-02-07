<?php
session_start();
include '../koneksi.php';

$id = $_GET['id'];

// Pastikan barang ada
$barang = mysqli_query($koneksi, "SELECT * FROM barang WHERE id_barang='$id'");
$data = mysqli_fetch_assoc($barang);

if(!$data){
    echo "<script>alert('Barang tidak ditemukan'); window.location='barang.php';</script>";
    exit;
}

// Hapus barang
$hapus = mysqli_query($koneksi, "DELETE FROM barang WHERE id_barang='$id'");

if($hapus){
    echo "<script>alert('Barang berhasil dihapus'); window.location='barang.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus barang'); window.location='barang.php';</script>";
}
