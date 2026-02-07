<?php
session_start();
include '../koneksi.php';


$barang = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY nama_barang ASC");


$kasir = mysqli_query($koneksi, "SELECT * FROM user WHERE user_status=2 ORDER BY user_nama ASC");

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

        echo "<script>alert('Penjualan berhasil'); window.location='penjualan.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Penjualan</title>
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
<h3 class="mb-4">Tambah Penjualan</h3>
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

            <button type="submit" name="simpan" class="btn btn-primary"><i class="bi bi-check-circle"></i> Simpan</button>
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
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
