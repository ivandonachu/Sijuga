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

$no_polisi = htmlspecialchars($_POST['no_polisi']);
$status_kendaraan = htmlspecialchars($_POST['status_kendaraan']);

$no_kode = 1;

        $kode = 'KDN';

        $sql_data = mysqli_query($koneksi, "SELECT * FROM list_kendaraan ");
        
        if(mysqli_num_rows($sql_data) === 0 ){
       
            $kode_new = $kode.$no_kode;
            $query = mysqli_query($koneksi,"INSERT INTO list_kendaraan VALUES('$kode_new','$no_polisi','$status_kendaraan')");
       
             echo "<script>alert('Data Kendaraan Berhasil di input'); window.location='../view/VListKendaraan';</script>";exit;
    
        }
        while($data_kendaraan = mysqli_fetch_array($sql_data)){
            $no_kode = $no_kode + 1;

            $kode_new = $kode.$no_kode;
            $sql_cek = mysqli_query($koneksi, "SELECT * FROM list_kendaraan WHERE kode_kendaraan = '$kode_new' ");
       
            if(mysqli_num_rows($sql_cek) === 0 ){
              
                $query = mysqli_query($koneksi,"INSERT INTO list_kendaraan VALUES('$kode_new','$no_polisi','$status_kendaraan')");
           
                  echo "<script>alert('Data Kendaraan Berhasil di input'); window.location='../view/VListKendaraan';</script>";exit;
        
            }
           

        }
    

    

