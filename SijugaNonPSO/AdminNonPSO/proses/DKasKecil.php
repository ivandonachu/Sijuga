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
$tanggal_awal = htmlspecialchars($_POST['tanggal1']);
$tanggal_akhir = htmlspecialchars($_POST['tanggal2']);
$no_laporan = htmlspecialchars($_POST['no_laporan']);

	
//saldo
$sql_saldo = mysqli_query($koneksi, "SELECT * FROM list_saldo WHERE nama_saldo = 'Saldo Non PSO'");
$data_saldo = mysqli_fetch_array($sql_saldo);
$jumlah_saldo = $data_saldo['jumlah_saldo'];

//kas kecil
$sql_kas = mysqli_query($koneksi, "SELECT jumlah, akun_kas FROM kas_kecil WHERE no_laporan = '$no_laporan'");
$data_kas = mysqli_fetch_array($sql_kas);
$jumlah_kas = $data_kas['jumlah'];
$akun_kas = $data_kas['akun_kas'];

if ($akun_kas == 'PENAMBAHAN SALDO') {
	$jumlah_saldo_baru = $jumlah_saldo - $jumlah_kas;
} else {
	$jumlah_saldo_baru = $jumlah_saldo + $jumlah_kas;
}
//update saldo
mysqli_query($koneksi, "UPDATE list_saldo SET jumlah_saldo = '$jumlah_saldo_baru' WHERE nama_saldo =  'Saldo Non PSO'");

		$query = mysqli_query($koneksi,"DELETE FROM kas_kecil WHERE no_laporan = '$no_laporan'");



	
		echo "<script>alert('Data Pengeluaran Kas Berhasil di Hapus'); window.location='../view/VKasKecil?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
	