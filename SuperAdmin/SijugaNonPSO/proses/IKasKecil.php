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
$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$tanggal = htmlspecialchars($_POST['tanggal']);
$akun_kas = $_POST['akun_kas'];
$jumlah = htmlspecialchars($_POST['jumlah']);

if (!isset($_POST['no_polisi'])) {
	$no_polisi = "";
} else {

	$no_polisi = $_POST['no_polisi'];
}
$keterangan = htmlspecialchars($_POST['keterangan']);
$nama_file = $_FILES['file']['name'];

if ($nama_file == "") {
	$file = "";
} else if ($nama_file != "") {

	function upload()
	{
		$nama_file = $_FILES['file']['name'];
		$ukuran_file = $_FILES['file']['size'];
		$error = $_FILES['file']['error'];
		$tmp_name = $_FILES['file']['tmp_name'];

		$ekstensi_valid = ['jpg', 'jpeg', 'pdf', 'doc', 'docs', 'xls', 'xlsx', 'docx', 'txt', 'png'];
		$ekstensi_file = explode(".", $nama_file);
		$ekstensi_file = strtolower(end($ekstensi_file));


		$nama_file_baru = uniqid();
		$nama_file_baru .= ".";
		$nama_file_baru .= $ekstensi_file;

		move_uploaded_file($tmp_name, '../file_admin_non_pso/' . $nama_file_baru);

		return $nama_file_baru;
	}

	$file = upload();
	if (!$file) {
		return false;
	}
}
//saldo
$sql_saldo = mysqli_query($koneksi, "SELECT * FROM list_saldo WHERE nama_saldo = 'Saldo Non PSO'");
$data_saldo = mysqli_fetch_array($sql_saldo);
$jumlah_saldo = $data_saldo['jumlah_saldo'];


if ($akun_kas == 'PENAMBAHAN SALDO') {
	$status_saldo = 'Masuk';
	$jumlah_saldo_baru = $jumlah_saldo + $jumlah;
} else {
	$status_saldo = 'Keluar';
	$jumlah_saldo_baru = $jumlah_saldo - $jumlah;
}

if($jumlah_saldo_baru < 0 ){
	echo "<script>alert('Saldo Kas Habis, Tidak Berhasil di Input'); window.location='../view/VKasKecil?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";
exit;
}
//update saldo
mysqli_query($koneksi, "UPDATE list_saldo SET jumlah_saldo = '$jumlah_saldo_baru' WHERE nama_saldo =  'Saldo Non PSO'");

mysqli_query($koneksi, "INSERT INTO kas_kecil VALUES('','$tanggal','$akun_kas','$no_polisi','$jumlah','$status_saldo','$keterangan','$file')");

echo "<script>alert('Data Pengeluaran Kas Berhasil di Input'); window.location='../view/VKasKecil?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";
exit;
