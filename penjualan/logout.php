<?php
session_start();
session_destroy();

session_start();
$_SESSION['logout'] = "Anda berhasil logout";
header("Location: index.php");
exit;
