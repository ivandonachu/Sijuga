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

$nama_saldo = htmlspecialchars($_POST['nama_saldo']);
$jumlah_saldo = htmlspecialchars($_POST['jumlah_saldo']);

$no_kode = 1;

        $kode = 'SLD';

        $sql_data = mysqli_query($koneksi, "SELECT * FROM list_saldo ");
        
        if(mysqli_num_rows($sql_data) === 0 ){
       
            $kode_new = $kode.$no_kode;
            $query = mysqli_query($koneksi,"INSERT INTO list_saldo VALUES('$kode_new','$nama_saldo','$jumlah_saldo')");
       
             echo "<script>alert('Data Saldo Berhasil di input'); window.location='../view/VListSaldo';</script>";exit;
    
        }
        while($data_saldo = mysqli_fetch_array($sql_data)){
            $no_kode = $no_kode + 1;

            $kode_new = $kode.$no_kode;
            $sql_cek = mysqli_query($koneksi, "SELECT * FROM list_saldo WHERE kode_saldo = '$kode_new' ");
       
            if(mysqli_num_rows($sql_cek) === 0 ){
              
                $query = mysqli_query($koneksi,"INSERT INTO list_saldo VALUES('$kode_new','$nama_saldo','$jumlah_saldo')");
           
                  echo "<script>alert('Data Saldo Berhasil di input'); window.location='../view/VListSaldo';</script>";exit;
        
            }
           

        }
    

    

