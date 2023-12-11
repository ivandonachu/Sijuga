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
if ($jabatan_valid == 'Admin PSO') {
} else {
    header("Location: logout.php");
    exit;
}


$kode_kendaraan = htmlspecialchars($_POST['kode_kendaraan']);

		$query = mysqli_query($koneksi,"DELETE FROM list_kendaraan WHERE kode_kendaraan = '$kode_kendaraan'");
		echo "<script>alert('Data Kendaraan Berhasil Di Hapus'); window.location='../view/VListKendaraan';</script>";exit;
	