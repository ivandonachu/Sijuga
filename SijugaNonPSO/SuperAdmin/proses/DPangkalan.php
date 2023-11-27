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


$no_registrasi = htmlspecialchars($_POST['no_registrasi']);

		$query = mysqli_query($koneksi,"DELETE FROM pangkalan WHERE no_registrasi = '$no_registrasi'");
		echo "<script>alert('Data Pangkalan Berhasil Di Hapus'); window.location='../view/VListPangkalan';</script>";exit;
	