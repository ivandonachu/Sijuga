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
if ($jabatan_valid == 'Super Admin') {
} else {
    header("Location: logout.php");
    exit;
}
$tanggal_awal = htmlspecialchars($_POST['tanggal1']);
$tanggal_akhir = htmlspecialchars($_POST['tanggal2']);
$no_pembelian = htmlspecialchars($_POST['no_pembelian']);

	

		$query = mysqli_query($koneksi,"DELETE FROM pembelian_pso WHERE no_pembelian = '$no_pembelian'");



	
		echo "<script>alert('Data Pembelian Berhasil di Hapus'); window.location='../view/VPembelian?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
	