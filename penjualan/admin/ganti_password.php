<?php
session_start();
include '../koneksi.php';

$pesan = "";


$data_user = mysqli_query($koneksi, "SELECT user_id, username, user_nama FROM user ORDER BY user_nama ASC");


if (isset($_POST['ubah'])) {
    $user_id        = $_POST['user_id'];
    $password_baru  = $_POST['password_baru'];
    $konfirmasi     = $_POST['konfirmasi'];

    if (empty($user_id)) {
        $pesan = "<div class='alert alert-danger'>User belum dipilih</div>";
    } elseif ($password_baru != $konfirmasi) {
        $pesan = "<div class='alert alert-danger'>Konfirmasi password tidak sama</div>";
    } else {
        $hash = md5($password_baru);

        $update = mysqli_query(
            $koneksi,
            "UPDATE user SET password='$hash' WHERE user_id='$user_id'"
        );

        if ($update) {
            $pesan = "<div class='alert alert-success'>Password berhasil diubah</div>";
        } else {
            $pesan = "<div class='alert alert-danger'>Gagal mengubah password</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ganti Password</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body { padding-left: 250px; background-color: #f4f6f9; }
        .sidebar {
            width: 250px;
            height: 100vh;
            top: 0;
            left: 0;
        }
        .card-custom { border: 2px solid #000; }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar bg-dark text-white position-fixed">
    <div class="p-3">
        <h4 class="text-center mb-4">Admin</h4>
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a href="index.php" class="nav-link text-white">
                    <i class="bi bi-speedometer2 me-2"></i> Beranda
                </a>
            </li>
            <li class="nav-item">
                <a href="user.php" class="nav-link text-white">
                    <i class="bi bi-people me-2"></i> User
                </a>
            </li>
            <li class="nav-item">
                <a href="barang.php" class="nav-link text-white">
                    <i class="bi bi-box-seam me-2"></i> Barang
                </a>
            </li>
            <li class="nav-item">
                <a href="penjualan.php" class="nav-link text-white">
                    <i class="bi bi-cart-check me-2"></i> Penjualan
                </a>
            </li>
            <li class="nav-item">
                <a href="ganti_password.php" class="nav-link active">
                    <i class="bi bi-lock me-2"></i> Ganti Password
                </a>
            </li>
            <li class="nav-item mt-3">
                <a href="../logout.php" class="nav-link text-danger">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
            </li>
        </ul>
    </div>
</div>
<body>
    <main class="col-md-9 col-lg-10 px-4 py-4">

<h2 class="mb-4"><i class="bi bi-lock me-2"></i>Ganti Password</h2>

<div class="content">
            <?= $pesan; ?>
    <div class="card shadow-sm">
       <div class="card card-custom">
<div class="card-body">
            <form method="post">

    <div class="mb-3">
        <label>Pilih User</label>
        <select name="user_id" class="form-select" required>
            <option value="">-- Pilih User --</option>
            <?php while($u = mysqli_fetch_assoc($data_user)) : ?>
                <option value="<?= $u['user_id']; ?>">
                    <?= $u['user_nama']; ?> (<?= $u['username']; ?>)
                </option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Password Baru</label>
        <input type="password" name="password_baru" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Konfirmasi Password Baru</label>
        <input type="password" name="konfirmasi" class="form-control" required>
    </div>

    <button type="submit" name="ubah" class="btn btn-dark">
        <i class="bi bi-check-circle"></i> Simpan
    </button>

</form>

        </div>
    </div>
</div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
