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
$no_polisi = htmlspecialchars($_POST['no_polisi']);
$status_kendaraan = htmlspecialchars($_POST['status_kendaraan']);



           mysqli_query($koneksi,"UPDATE list_kendaraan SET no_polisi = '$no_polisi' , status_kendaraan = '$status_kendaraan'  WHERE kode_kendaraan =  '$kode_kendaraan'");
           echo "<script>alert('Data Kendaraan Berhasil di Edit'); window.location='../view/VListKendaraan';</script>";exit;
    
      
	
