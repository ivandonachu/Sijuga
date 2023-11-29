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
$no_laporan = htmlspecialchars($_POST['no_laporan']);
$no_penjualan = htmlspecialchars($_POST['no_penjualan']);
$status_penjualan = 'Piutang';
	
        mysqli_query($koneksi,"UPDATE penjualan SET status_penjualan = '$status_penjualan' WHERE no_penjualan =  '$no_penjualan'");
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_piutang WHERE no_laporan = '$no_laporan'");



	
		echo "<script>alert('Data Riwayat Piutang Berhasil di Hapus'); window.location='../view/VRiwayatPiutang?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
	