<?php
session_start();
include 'koneksi.php';

if (isset($_POST['username']) && isset($_POST['password'])) {

    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5($_POST['password']);

    $query = mysqli_query($koneksi, 
        "SELECT * FROM user 
         WHERE username='$username' 
         AND password='$password'"
    );

    $data = mysqli_fetch_assoc($query);

    if ($data) {
        $_SESSION['username'] = $data['username'];
        $_SESSION['status']   = "login";
        $_SESSION['role']     = $data['user_status'];

        if ($data['user_status'] == "1") {
            header("Location: admin/index.php");
        } elseif ($data['user_status'] == "2") {
            header("Location: kasir/index.php");
        } else {
            header("Location: index.php?pesan=role_tidak_dikenali");
        }
        exit;

    } else {
         $_SESSION['error'] = "Username atau password salah";
        header("Location: index.php");
        
        exit;
    }

} else {
   header("Location: index.php?pesan=gagal");
   exit;
}
