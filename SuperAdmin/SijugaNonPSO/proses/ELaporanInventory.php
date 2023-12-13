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
$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$no_laporan = $_POST['no_laporan'];
$tanggal = htmlspecialchars($_POST['tanggal']);
$B05K01 = htmlspecialchars($_POST['B05K01']);
$B05K10 = htmlspecialchars($_POST['B05K10']);
$B05K00 = htmlspecialchars($_POST['B05K00']);
$B12K01 = htmlspecialchars($_POST['B12K01']);
$B12K10 = htmlspecialchars($_POST['B12K10']);
$B12K00 = htmlspecialchars($_POST['B12K00']);
$B50K01 = htmlspecialchars($_POST['B50K01']);
$B50K10 = htmlspecialchars($_POST['B50K10']);
$B50K00 = htmlspecialchars($_POST['B50K00']);


            mysqli_query($koneksi,"UPDATE laporan_inventory SET B05K01 = '$B05K01', B05K11 = '$B05K01', B05K10 = '$B05K10', B05K00 = '$B05K00', B12K01 = '$B12K01', B12K11 = '$B12K01', B12K10 = '$B12K10', B12K00 = '$B12K00', B50K01 = '$B50K01', B50K11 = '$B50K11', B50K10 = '$B50K10', B50K00 = '$B50K00' WHERE no_laporan = '$no_laporan' ");

            mysqli_query($koneksi,"UPDATE inventory SET jumlah_tabung = '$B05K01' WHERE kode_tabung = 'B05K01' ");
            mysqli_query($koneksi,"UPDATE inventory SET jumlah_tabung = '$B05K01' WHERE kode_tabung = 'B05K11' ");
            mysqli_query($koneksi,"UPDATE inventory SET jumlah_tabung = '$B05K10' WHERE kode_tabung = 'B05K10' ");
            mysqli_query($koneksi,"UPDATE inventory SET jumlah_tabung = '$B05K00' WHERE kode_tabung = 'B05K00' ");
            mysqli_query($koneksi,"UPDATE inventory SET jumlah_tabung = '$B12K01' WHERE kode_tabung = 'B12K01' ");
            mysqli_query($koneksi,"UPDATE inventory SET jumlah_tabung = '$B12K01' WHERE kode_tabung = 'B12K11' ");
            mysqli_query($koneksi,"UPDATE inventory SET jumlah_tabung = '$B12K10' WHERE kode_tabung = 'B12K10' ");
            mysqli_query($koneksi,"UPDATE inventory SET jumlah_tabung = '$B12K00' WHERE kode_tabung = 'B12K00' ");
            mysqli_query($koneksi,"UPDATE inventory SET jumlah_tabung = '$B50K01' WHERE kode_tabung = 'B50K01' ");
            mysqli_query($koneksi,"UPDATE inventory SET jumlah_tabung = '$B50K01' WHERE kode_tabung = 'B50K11' ");
            mysqli_query($koneksi,"UPDATE inventory SET jumlah_tabung = '$B50K10' WHERE kode_tabung = 'B50K10' ");
            mysqli_query($koneksi,"UPDATE inventory SET jumlah_tabung = '$B50K00' WHERE kode_tabung = 'B50K00' ");

               
            echo "<script>alert('Data Laporan Inventory Berhasil di Input'); window.location='../view/VLaporanInventory?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
     

     
        

       


  ?>