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


$kode_saldo = htmlspecialchars($_POST['kode_saldo']);
$nama_saldo = htmlspecialchars($_POST['nama_saldo']);
$jumlah_saldo = htmlspecialchars($_POST['jumlah_saldo']);



           mysqli_query($koneksi,"UPDATE list_saldo SET nama_saldo = '$nama_saldo' , jumlah_saldo = '$jumlah_saldo'  WHERE kode_saldo =  '$kode_saldo'");
           echo "<script>alert('Data Saldo Berhasil di Edit'); window.location='../view/VListSaldo';</script>";exit;
    
      
	
