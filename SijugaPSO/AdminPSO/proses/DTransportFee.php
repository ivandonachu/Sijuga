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
$tanggal_awal = htmlspecialchars($_POST['tanggal1']);
$tanggal_akhir = htmlspecialchars($_POST['tanggal2']);
$no_laporan = htmlspecialchars($_POST['no_laporan']);

	

		$query = mysqli_query($koneksi,"DELETE FROM transport_fee WHERE no_laporan = '$no_laporan'");



	
		echo "<script>alert('Data Transport Fee Berhasil di Hapus'); window.location='../view/VTransportFee?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
	