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


$kode_customer = htmlspecialchars($_POST['kode_customer']);
$agen = htmlspecialchars($_POST['agen']);
$nama_customer = htmlspecialchars($_POST['nama_customer']);
$jenis_pembayaran = htmlspecialchars($_POST['jenis_pembayaran']);
$region_2 = htmlspecialchars($_POST['region_2']);
$provinsi = htmlspecialchars($_POST['provinsi']);
$kabupaten = htmlspecialchars($_POST['kabupaten']);
$harga_3kg = htmlspecialchars($_POST['harga_3kg']);
$harga_55kg = htmlspecialchars($_POST['harga_55kg']);
$harga_12kg = htmlspecialchars($_POST['harga_12kg']);
$harga_50kg = htmlspecialchars($_POST['harga_50kg']);
$status_customer = htmlspecialchars($_POST['harga_50kg']);



           mysqli_query($koneksi,"UPDATE customer SET agen = '$agen' , nama_customer = '$nama_customer' , jenis_pembayaran = '$jenis_pembayaran', region_2 = '$region_2' , provinsi = '$provinsi' , kabupaten = '$kabupaten' , 
                                                       harga_3kg = '$harga_3kg' , harga_55kg = '$harga_55kg' , harga_12kg = '$harga_12kg' , harga_50kg = '$harga_50kg' WHERE kode_customer =  '$kode_customer'");
           echo "<script>alert('Data Customer Berhasil di Edit'); window.location='../view/VListCustomer';</script>";exit;
    
      
	
