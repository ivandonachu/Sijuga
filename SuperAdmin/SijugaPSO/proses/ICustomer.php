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
$status_customer = 'Aktif';

$no_kode = 1;

        $kode = 'CSR';

        $sql_data = mysqli_query($koneksi, "SELECT * FROM customer ");
        
        if(mysqli_num_rows($sql_data) === 0 ){
       
            $kode_new = $kode.$no_kode;
            $query = mysqli_query($koneksi,"INSERT INTO customer VALUES('$kode_new','$agen','$nama_customer','$jenis_pembayaran','$region_2','$provinsi','$kabupaten','$status_customer','$harga_3kg','$harga_55kg','$harga_12kg','$harga_50kg')");
       
                echo "<script>alert('Data Customer Berhasil di input'); window.location='../view/VListCustomer';</script>";exit;
    
        }
        while($data_customer = mysqli_fetch_array($sql_data)){
            $no_kode = $no_kode + 1;

            $kode_new = $kode.$no_kode;
            $sql_cek = mysqli_query($koneksi, "SELECT * FROM customer WHERE kode_customer = '$kode_new' ");
       
            if(mysqli_num_rows($sql_cek) === 0 ){
              
                $query = mysqli_query($koneksi,"INSERT INTO customer VALUES('$kode_new','$agen','$nama_customer','$jenis_pembayaran','$region_2','$provinsi','$kabupaten','$status_customer','$harga_3kg','$harga_55kg','$harga_12kg','$harga_50kg')");
           
                    echo "<script>alert('Data Customer Berhasil di input'); window.location='../view/VListCustomer';</script>";exit;
        
            }
           

        }
    

    

