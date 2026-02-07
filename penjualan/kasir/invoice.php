<?php
include '../koneksi.php';

$id = $_GET['id'] ?? '';

$q = mysqli_query($koneksi, "
    SELECT 
        p.id_jual,
        p.jumlah AS qty,
        p.total_harga,
        p.tgl_jual,
        b.nama_barang,
        b.harga_jual,
        u.user_nama AS kasir
    FROM penjualan p
    JOIN barang b ON p.id_barang = b.id_barang
    JOIN user u ON p.user_id = u.user_id
    WHERE p.id_jual = '$id'
");

$data = mysqli_fetch_assoc($q);

if (!$data) {
    echo "<script>alert('Data invoice tidak ditemukan'); window.close();</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice #<?= $data['id_jual'] ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body { background:#f5f5f5; }
        .invoice-box {
            max-width: 700px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border: 2px solid #000;
        }
        .table th {
            background: #000;
            color: #fff;
        }
        @media print {
            .no-print { display: none; }
            body { background: #fff; }
        }
    </style>
</head>
<body>

<div class="invoice-box mt-4">

    <!-- HEADER -->
    <div class="text-center mb-4">
        <h3 class="fw-bold">INVOICE PENJUALAN</h3>
        <hr>
    </div>

    <!-- INFO -->
    <div class="row mb-3">
        <div class="col">
            <p><strong>No Invoice:</strong> <?= $data['id_jual'] ?></p>
            <p><strong>Tanggal:</strong> <?= $data['tgl_jual'] ?></p>
        </div>
        <div class="col text-end">
            <p><strong>Kasir:</strong> <?= $data['kasir'] ?></p>
        </div>
    </div>

    <!-- TABEL BARANG -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th class="text-center">Qty</th>
                <th class="text-end">Harga</th>
                <th class="text-end">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= $data['nama_barang'] ?></td>
                <td class="text-center"><?= $data['qty'] ?></td>
                <td class="text-end">Rp <?= number_format($data['harga_jual'],0,',','.') ?></td>
                <td class="text-end">Rp <?= number_format($data['total_harga'],0,',','.') ?></td>
            </tr>
        </tbody>
        <tfoot>
            <tr class="fw-bold">
                <td colspan="3" class="text-end">TOTAL</td>
                <td class="text-end">Rp <?= number_format($data['total_harga'],0,',','.') ?></td>
            </tr>
        </tfoot>
    </table>

    <!-- FOOTER -->
    <div class="text-center mt-4">
        <p>Terima kasih telah berbelanja</p>
    </div>

    <!-- BUTTON -->
    <div class="text-center no-print">
        <button onclick="window.print()" class="btn btn-dark"> <i class="bi bi-printer"></i> Cetak Invoice</button>
        <a href="laporan.php" class="btn btn-secondary"> <i class="bi bi-arrow-left"></i> Kembali</a>
    </div>

</div>

</body>
</html>
