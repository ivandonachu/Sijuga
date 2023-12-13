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
$nama_akun = htmlspecialchars($_POST['nama_akun']);

if(!isset($_POST['nama_customer'])){
    $nama_customer = "";
}else{
 $nama_customer = htmlspecialchars($_POST['nama_customer']);
}


if($nama_customer == ""){
   echo "<script>alert('Nama Customer Tidak Boleh Kosong'); window.location='../view/VPenjualan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";
    exit;

}
$pembayaran = htmlspecialchars($_POST['pembayaran']);

//akses data pangkalan
$sql_customer = mysqli_query($koneksi, "SELECT kode_customer, harga_3kg FROM customer WHERE nama_customer = '$nama_customer'");
$data_customer = mysqli_fetch_array($sql_customer);
$kode_customer = $data_customer['kode_customer'];
$harga_3kg = $data_customer['harga_3kg'];



$qty_3kg = htmlspecialchars($_POST['qty_3kg']);
$jumlah = $qty_3kg * $harga_3kg;

$status_penjualan = htmlspecialchars($_POST['status_penjualan']);
$keterangan = htmlspecialchars($_POST['keterangan']);

$nama_file = $_FILES['file']['name'];

if ($nama_file == "") {
    $file = "";
} else if ($nama_file != "") {

    function upload(){
		$nama_file = $_FILES['file']['name'];
		$ukuran_file = $_FILES['file']['size'];
		$error = $_FILES['file']['error'];
		$tmp_name = $_FILES['file']['tmp_name'];

		$ekstensi_valid = ['jpg','jpeg','pdf','doc','docs','xls','xlsx','docx','txt','png'];
		$ekstensi_file = explode(".", $nama_file);
		$ekstensi_file = strtolower(end($ekstensi_file));


		$nama_file_baru = uniqid();
		$nama_file_baru .= ".";
		$nama_file_baru .= $ekstensi_file;

		move_uploaded_file($tmp_name, '../../../SijugaPSO/AdminPSO/file_admin_pso/' . $nama_file_baru   );

		return $nama_file_baru; 
    }

    $file = upload();
    if (!$file) {
        return false;
    }
}




mysqli_query($koneksi, "INSERT INTO penjualan_pso VALUES('','$tanggal','$kode_customer','$nama_akun','$pembayaran','$qty_3kg','$harga_3kg','$jumlah','$status_penjualan','$keterangan','$file')");

echo "<script>alert('Data Penjualan Berhasil di Input'); window.location='../view/VPenjualan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";
exit;
