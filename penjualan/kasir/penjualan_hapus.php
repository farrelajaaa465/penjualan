<?php
session_start();
include '../koneksi.php';

$id = $_GET['id'];

mysqli_query($koneksi, "DELETE FROM penjualan WHERE id_jual='$id'");

echo "<script>alert('Penjualan berhasil dihapus!');window.location='form_penjualan.php';</script>";
?>
