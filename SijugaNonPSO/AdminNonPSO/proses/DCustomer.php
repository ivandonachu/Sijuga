<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION["login"])) {
    header("Location: logout.php");
    exit;
}
$username = $_COOKIE['username'];
$result1 = mysqli_query($koneksi, "SELECT * FROM account WHERE username = '$username'");
$data1 = mysqli_fetch_array($result1);
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'Admin Non PSO') {
} else {
    header("Location: logout.php");
    exit;
}


$kode_customer = htmlspecialchars($_POST['kode_customer']);

		$query = mysqli_query($koneksi,"DELETE FROM customer WHERE kode_customer = '$kode_customer'");
		echo "<script>alert('Data Customer Berhasil Di Hapus'); window.location='../view/VListCustomer';</script>";exit;
	