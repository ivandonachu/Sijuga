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
$tanggal = htmlspecialchars($_POST['tanggal']);
$akun_kas = $_POST['akun_kas'];
if (!isset($_POST['no_polisi'])) {
	$no_polisi = "";
} else {

	$no_polisi = $_POST['no_polisi'];
}
if ($akun_kas == 'PENAMBAHAN SALDO') {
	$status_saldo = 'Masuk';
} else {
	$status_saldo = 'Keluar';
}
$jumlah = htmlspecialchars($_POST['jumlah']);
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

//kas kecil
$sql_kas = mysqli_query($koneksi, "SELECT jumlah, akun_kas FROM kas_kecil WHERE no_laporan = '$no_laporan'");
$data_kas = mysqli_fetch_array($sql_kas);
$jumlah_kas = $data_kas['jumlah'];
$akun_kasx = $data_kas['akun_kas'];

if ($akun_kasx == 'PENAMBAHAN SALDO') {
	$status_saldo = 'Masuk';
	if ($akun_kas == 'PENAMBAHAN SALDO') {
		$jumlah_saldo_baru = ($jumlah_saldo - $jumlah_kas) + $jumlah;
	} else {
		$jumlah_saldo_baru = ($jumlah_saldo - $jumlah_kas) - $jumlah;
	
	}
} else {
	$status_saldo = 'Keluar';
	if ($akun_kas == 'PENAMBAHAN SALDO') {
		$jumlah_saldo_baru = ($jumlah_saldo + $jumlah_kas) + $jumlah;
	} else {
		$jumlah_saldo_baru = ($jumlah_saldo + $jumlah_kas) - $jumlah;
	}
	
}


//update saldo
mysqli_query($koneksi, "UPDATE list_saldo SET jumlah_saldo = '$jumlah_saldo_baru' WHERE nama_saldo =  'Saldo Non PSO'");

if ($file == '') {
	mysqli_query($koneksi, "UPDATE kas_kecil SET tanggal = '$tanggal' , akun_kas = '$akun_kas', no_polisi = '$no_polisi' , jumlah = '$jumlah', status_saldo = '$status_saldo' , keterangan = '$keterangan' WHERE no_laporan =  '$no_laporan'");
} else {
	mysqli_query($koneksi, "UPDATE kas_kecil SET tanggal = '$tanggal' , akun_kas = '$akun_kas' , no_polisi = '$no_polisi', jumlah = '$jumlah', status_saldo = '$status_saldo' , keterangan = '$keterangan', file_bukti = '$file' WHERE no_laporan =  '$no_laporan'");
}

echo "<script>alert('Data Pengeluaran Kas Berhasil di Edit'); window.location='../view/VKasKecil?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";
exit;
