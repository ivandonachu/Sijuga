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
$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$no_laporan = $_POST['no_laporan'];
$tanggal = htmlspecialchars($_POST['tanggal']);
$L03K01 = htmlspecialchars($_POST['L03K01']);
$L03K10 = htmlspecialchars($_POST['L03K10']);
$L03K00 = htmlspecialchars($_POST['L03K00']);


            mysqli_query($koneksi,"UPDATE laporan_inventory_pso SET L03K01 = '$L03K01', L03K11 = '$L03K01', L03K10 = '$L03K10', L03K00 = '$L03K00' WHERE no_laporan = '$no_laporan' ");

            mysqli_query($koneksi,"UPDATE inventory SET jumlah_tabung = '$L03K01' WHERE kode_tabung = 'L03K01' ");
            mysqli_query($koneksi,"UPDATE inventory SET jumlah_tabung = '$L03K01' WHERE kode_tabung = 'L03K11' ");
            mysqli_query($koneksi,"UPDATE inventory SET jumlah_tabung = '$L03K10' WHERE kode_tabung = 'L03K10' ");
            mysqli_query($koneksi,"UPDATE inventory SET jumlah_tabung = '$L03K00' WHERE kode_tabung = 'L03K00' ");

               
            echo "<script>alert('Data Laporan Inventory Berhasil di Input'); window.location='../view/VLaporanInventory?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
     

     
        

       


  ?>