<?php
session_start();
include '../koneksi.php';

// Ambil daftar barang
$barang = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY nama_barang ASC");

// Ambil daftar kasir
$kasir = mysqli_query($koneksi, "SELECT * FROM user WHERE user_status=2 ORDER BY user_nama ASC");

// Proses simpan
if(isset($_POST['simpan'])){
    $id_barang = $_POST['id_barang'];
    $jumlah = $_POST['jumlah'];
    $tgl_jual = $_POST['tgl_jual'];
    $user_id = $_POST['user_id']; 

    $data_barang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM barang WHERE id_barang='$id_barang'"));
    $harga_jual = $data_barang['harga_jual'];
    $stok = $data_barang['stok'];

    if($jumlah > $stok){
        echo "<script>alert('Stok tidak cukup');</script>";
    } else {
        $total_harga = $jumlah * $harga_jual;

        mysqli_query($koneksi, "INSERT INTO penjualan (id_barang, jumlah, tgl_jual, total_harga, user_id) 
        VALUES ('$id_barang','$jumlah','$tgl_jual','$total_harga','$user_id')");

        $stok_baru = $stok - $jumlah;
        mysqli_query($koneksi, "UPDATE barang SET stok='$stok_baru' WHERE id_barang='$id_barang'");

        echo "<script>alert('Penjualan berhasil'); window.location='form_penjualan.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Penjualan</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
body { margin:0; font-family:'Segoe UI',sans-serif; background-color:#f4f6f9; }

/* Sidebar */
.sidebar {
    position: fixed;
    top:0;
    left:0;
    width:250px;
    height:100vh;
    background-color:#000;
    color:#fff;
    padding:20px 15px;
}
.sidebar h4 { text-align:center; margin-bottom:30px; font-weight:600; }
.sidebar .nav-link { color:#fff; padding:8px 12px; display:block; border-radius:5px; }
.sidebar .nav-link:hover { background-color:#1a1a1a; }

/* Content */
.content { margin-left:250px; padding:30px; }

/* Form */
.card-custom { border:none; }
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4>Tambah</h4>
    <ul class="nav flex-column">
        <li class="nav-item"><a href="form_penjualan.php" class="nav-link"> <i class="bi bi-arrow-left"></i> Kembali</a></li>
    </ul>
</div>

<!-- Content -->
<div class="content">
<h2 class="mb-4">Tambah Penjualan</h2>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST">
            <!-- Pilih Barang -->
            <div class="mb-3">
                <label class="form-label">Pilih Barang</label>
                <select name="id_barang" id="id_barang" class="form-select" required>
                    <option value="">-- Pilih Barang --</option>
                    <?php while($b = mysqli_fetch_assoc($barang)) : ?>
                        <option value="<?= $b['id_barang'] ?>" data-harga="<?= $b['harga_jual'] ?>" data-stok="<?= $b['stok'] ?>">
                            <?= $b['nama_barang'] ?> (Stok: <?= $b['stok'] ?>)
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Jumlah -->
            <div class="mb-3">
                <label class="form-label">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" required>
            </div>

            <!-- Tanggal Jual -->
            <div class="mb-3">
                <label class="form-label">Tanggal Jual</label>
                <input type="date" name="tgl_jual" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>

            <!-- Pilih Kasir -->
            <div class="mb-3">
                <label class="form-label">Kasir</label>
                <select name="user_id" class="form-select" required>
                    <option value="">-- Pilih Kasir --</option>
                    <?php while($k = mysqli_fetch_assoc($kasir)) : ?>
                        <option value="<?= $k['user_id'] ?>"><?= $k['user_nama'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Total Harga -->
            <div class="mb-3">
                <label class="form-label">Total Harga</label>
                <input type="text" id="total_harga" class="form-control" readonly>
            </div>

            <button type="submit" name="simpan" class="btn btn-dark">Simpan</button>
          
        </form>
    </div>
</div>
</div>

<script>
const barangSelect = document.getElementById('id_barang');
const jumlahInput = document.getElementById('jumlah');
const totalHargaInput = document.getElementById('total_harga');

function updateTotal(){
    const selectedOption = barangSelect.options[barangSelect.selectedIndex];
    const harga = parseInt(selectedOption.dataset.harga || 0);
    const stok = parseInt(selectedOption.dataset.stok || 0);
    let jumlah = parseInt(jumlahInput.value || 0);

    if(jumlah > stok){
        alert('Jumlah melebihi stok!');
        jumlahInput.value = stok;
        jumlah = stok;
    }

    const total = jumlah * harga;
    totalHargaInput.value = 'Rp ' + total.toLocaleString('id-ID');
}

barangSelect.addEventListener('change', updateTotal);
jumlahInput.addEventListener('input', updateTotal);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
