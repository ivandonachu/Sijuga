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
$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$tanggal = htmlspecialchars($_POST['tanggal']);
$nama_akun = htmlspecialchars($_POST['nama_akun']);
$kode_customer = htmlspecialchars($_POST['kode_customer']);
$pembayaran = htmlspecialchars($_POST['pembayaran']);
$qty_55kg = htmlspecialchars($_POST['qty_55kg']);
$qty_12kg = htmlspecialchars($_POST['qty_12kg']);
$qty_50kg = htmlspecialchars($_POST['qty_50kg']);
$harga_55kg = htmlspecialchars($_POST['harga_55kg']);
$harga_12kg = htmlspecialchars($_POST['harga_12kg']);
$harga_50kg = htmlspecialchars($_POST['harga_50kg']);
$jumlah_55kg = htmlspecialchars($_POST['jumlah_55kg']);
$jumlah_12kg = htmlspecialchars($_POST['jumlah_12kg']);
$jumlah_50kg = htmlspecialchars($_POST['jumlah_50kg']);
$jumlah = htmlspecialchars($_POST['jumlah']);
$status_penjualan = htmlspecialchars($_POST['status_penjualan']);
$keterangan = htmlspecialchars($_POST['keterangan']);

$nama_file = $_FILES['file']['name'];

if ($nama_file == "") {
    $file = "";
} else if ($nama_file != "") {

    function upload(){
		$nama_file = $_FILES['file']['name'];
		$ukuran_file = $_FILES['file']['size'];
		$error = $_FILES['file']['error'];
		$tmp_name = $_FILES['file']['tmp_name'];

		$ekstensi_valid = ['jpg','jpeg','pdf','doc','docs','xls','xlsx','docx','txt','png'];
		$ekstensi_file = explode(".", $nama_file);
		$ekstensi_file = strtolower(end($ekstensi_file));


		$nama_file_baru = uniqid();
		$nama_file_baru .= ".";
		$nama_file_baru .= $ekstensi_file;

		move_uploaded_file($tmp_name, '../file_admin_non_pso/' . $nama_file_baru   );

		return $nama_file_baru; 
    }

    $file = upload();
    if (!$file) {
        return false;
    }
}




mysqli_query($koneksi, "INSERT INTO penjualan VALUES('','$tanggal','$kode_customer','$nama_akun','$pembayaran','$qty_55kg','$harga_55kg','$jumlah_55kg','$qty_12kg','$harga_12kg','$jumlah_12kg','$qty_50kg','$harga_50kg','$jumlah_50kg','$jumlah','$status_penjualan','$keterangan','$file')");

echo "<script>alert('Data Penjualan Berhasil di Input'); window.location='../view/VPenjualan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";
exit;
