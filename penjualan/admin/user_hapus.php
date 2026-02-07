<?php
session_start();
include '../koneksi.php';

// Ambil ID user dari URL
$id = $_GET['id'];

// Ambil data user untuk memastikan ada
$user = mysqli_query($koneksi, "SELECT * FROM user WHERE user_id = '$id'");
$data = mysqli_fetch_assoc($user);

if(!$data){
    echo "<script>alert('User tidak ditemukan'); window.location='user.php';</script>";
    exit;
}

// Hapus user
$hapus = mysqli_query($koneksi, "DELETE FROM user WHERE user_id = '$id'");

if($hapus){
    echo "<script>alert('User berhasil dihapus'); window.location='user.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus user'); window.location='user.php';</script>";
}
