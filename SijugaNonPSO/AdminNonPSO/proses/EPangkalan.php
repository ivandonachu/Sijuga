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
if ($jabatan_valid == 'Admin') {
} else {
    header("Location: logout.php");
    exit;
}


$no_registrasi = htmlspecialchars($_POST['no_registrasi']);
$nama_pangkalan = htmlspecialchars($_POST['nama_pangkalan']);
$type = htmlspecialchars($_POST['type']);
$pemilik = htmlspecialchars($_POST['pemilik']);
$no_hp_pemilik = htmlspecialchars($_POST['no_hp_pemilik']);
$no_ktp = htmlspecialchars($_POST['no_ktp']);
$alamat = htmlspecialchars($_POST['alamat']);
$no_kantor = htmlspecialchars($_POST['no_kantor']);
$sp_agen = htmlspecialchars($_POST['sp_agen']);
$se_lpg = htmlspecialchars($_POST['se_lpg']);
$qty_kontrak = htmlspecialchars($_POST['qty_kontrak']);
$kode_pos = htmlspecialchars($_POST['kode_pos']);
$latitude = htmlspecialchars($_POST['latitude']);
$longtitude = htmlspecialchars($_POST['longtitude']);
$status = htmlspecialchars($_POST['status']);
$tipe_pembayaran = htmlspecialchars($_POST['tipe_pembayaran']);



           mysqli_query($koneksi,"UPDATE pangkalan SET nama_pangkalan = '$nama_pangkalan' , type = '$type' , pemilik = '$pemilik', no_hp_pemilik = '$no_hp_pemilik' , no_ktp = '$no_ktp' , alamat = '$alamat' , 
                                                       no_kantor = '$no_kantor' , sp_agen = '$sp_agen' , se_lpg = '$se_lpg' , qty_kontrak = '$qty_kontrak', kode_pos = '$kode_pos' , 
                                                       latitude = '$latitude' , longtitude = '$longtitude' , status = '$status' , tipe_pembayaran = '$tipe_pembayaran' WHERE no_registrasi =  '$no_registrasi'");
           echo "<script>alert('Data Pangkalan Berhasil di Edit'); window.location='../view/VListPangkalan';</script>";exit;
    
      
	
