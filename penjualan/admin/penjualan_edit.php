<?php
session_start();
include '../koneksi.php';

$id = $_GET['id'];

// Ambil data penjualan
$penjualan = mysqli_query($koneksi, "SELECT * FROM penjualan WHERE id_jual='$id'");
$data = mysqli_fetch_assoc($penjualan);
if(!$data){
    echo "<script>alert('Data penjualan tidak ditemukan'); window.location='penjualan.php';</script>";
    exit;
}

// Ambil daftar barang
$barang = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY nama_barang ASC");

// Ambil daftar kasir (status = 2)
$kasir = mysqli_query($koneksi, "SELECT * FROM user WHERE user_status=2 ORDER BY user_nama ASC");

if(isset($_POST['simpan'])){
    $id_barang = $_POST['id_barang'];
    $jumlah = $_POST['jumlah'];
    $tgl_jual = $_POST['tgl_jual'];
    $user_id = $_POST['user_id'];

    // Ambil data barang baru
    $data_barang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM barang WHERE id_barang='$id_barang'"));
    $harga_jual = $data_barang['harga_jual'];

    // Ambil stok barang baru + kembalikan stok lama penjualan
    if($id_barang == $data['id_barang']){
        // Barang sama → stok = stok saat ini + jumlah lama
        $stok = $data_barang['stok'] + $data['jumlah'];
    } else {
        // Barang berbeda → kembalikan stok barang lama
        $barang_lama = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM barang WHERE id_barang='".$data['id_barang']."'"));
        $stok_lama = $barang_lama['stok'] + $data['jumlah'];
        mysqli_query($koneksi, "UPDATE barang SET stok='$stok_lama' WHERE id_barang='".$data['id_barang']."'");
        $stok = $data_barang['stok'];
    }

    if($jumlah > $stok){
        echo "<script>alert('Stok tidak cukup');</script>";
    } else {
        $total_harga = $jumlah * $harga_jual;

        // Update stok barang
        $stok_baru = $stok - $jumlah;
        mysqli_query($koneksi, "UPDATE barang SET stok='$stok_baru' WHERE id_barang='$id_barang'");

        // Update penjualan
        mysqli_query($koneksi, "UPDATE penjualan SET id_barang='$id_barang', jumlah='$jumlah', tgl_jual='$tgl_jual', total_harga='$total_harga', user_id='$user_id' WHERE id_jual='$id'");

        echo "<script>alert('Data berhasil diupdate'); window.location='penjualan.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Penjualan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<style>
body { background-color: #f4f6f9; }
.sidebar { width: 250px; min-height: 100vh; }
.content { padding: 100px; }
</style>
</head>
<body>


<div class="content">
<h3 class="mb-4">Edit Penjualan</h3>
<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST">
            <!-- Pilih Barang -->
            <div class="mb-3">
                <label class="form-label">Pilih Barang</label>
                <select name="id_barang" id="id_barang" class="form-select" required>
                    <?php while($b = mysqli_fetch_assoc($barang)) : ?>
                        <option value="<?= $b['id_barang'] ?>" data-harga="<?= $b['harga_jual'] ?>" data-stok="<?= $b['stok'] ?>"
                        <?= ($b['id_barang']==$data['id_barang']) ? 'selected' : '' ?>>
                            <?= $b['nama_barang'] ?> (Stok: <?= $b['stok'] ?>)
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Jumlah -->
            <div class="mb-3">
                <label class="form-label">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" value="<?= $data['jumlah'] ?>" required>
            </div>

            <!-- Tanggal Jual -->
            <div class="mb-3">
                <label class="form-label">Tanggal Jual</label>
                <input type="date" name="tgl_jual" class="form-control" value="<?= $data['tgl_jual'] ?>" required>
            </div>

            <!-- Pilih Kasir -->
            <div class="mb-3">
                <label class="form-label">Kasir</label>
                <select name="user_id" class="form-select" required>
                    <?php while($k = mysqli_fetch_assoc($kasir)) : ?>
                        <option value="<?= $k['user_id'] ?>" <?= ($k['user_id']==$data['user_id']) ? 'selected' : '' ?>>
                            <?= $k['user_nama'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Total Harga -->
            <div class="mb-3">
                <label class="form-label">Total Harga</label>
                <input type="text" id="total_harga" class="form-control" readonly>
            </div>

            <button type="submit" name="simpan" class="btn btn-success"><i class="bi bi-check-circle"></i> Update</button>
            <a href="penjualan.php" class="btn btn-secondary"><i class="bi bi-arrow-left-circle"></i> Kembali</a>
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

// Set total harga saat halaman load
updateTotal();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
