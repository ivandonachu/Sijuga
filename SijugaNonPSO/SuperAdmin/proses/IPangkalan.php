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

    
            $query = mysqli_query($koneksi,"INSERT INTO pangkalan VALUES('$no_registrasi','$nama_pangkalan','$type','$pemilik','$no_hp_pemilik','$no_ktp','$alamat','$no_kantor','$sp_agen',
                                                                         '$se_lpg','$qty_kontrak','$kode_pos','$latitude','$longtitude','$status','$tipe_pembayaran')");
       
              echo "<script>alert('Data Pangkalan Berhasil di input'); window.location='../view/VListPangkalan';</script>";exit;
