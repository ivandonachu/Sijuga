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
$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$tanggal = htmlspecialchars($_POST['tanggal']);
$L03K01 = htmlspecialchars($_POST['L03K01']);
$L03K10 = htmlspecialchars($_POST['L03K10']);
$L03K00 = htmlspecialchars($_POST['L03K00']);


            mysqli_query($koneksi,"INSERT INTO laporan_inventory_pso VALUES('','$tanggal','$L03K01','$L03K01','$L03K10','$L03K00')");

            mysqli_query($koneksi,"UPDATE inventory SET jumlah_tabung = '$L03K01' WHERE kode_tabung = 'L03K01' ");
            mysqli_query($koneksi,"UPDATE inventory SET jumlah_tabung = '$L03K01' WHERE kode_tabung = 'L03K11' ");
            mysqli_query($koneksi,"UPDATE inventory SET jumlah_tabung = '$L03K10' WHERE kode_tabung = 'L03K10' ");
            mysqli_query($koneksi,"UPDATE inventory SET jumlah_tabung = '$L03K00' WHERE kode_tabung = 'L03K00' ");

               
            echo "<script>alert('Data Laporan Inventory Berhasil di Input'); window.location='../view/VLaporanInventory?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
     

     
        

       


  ?>