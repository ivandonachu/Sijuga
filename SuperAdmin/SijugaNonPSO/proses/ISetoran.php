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
$jenis_setoran = htmlspecialchars($_POST['jenis_setoran']);
$jumlah = htmlspecialchars($_POST['jumlah']);
$keterangan = htmlspecialchars($_POST['keterangan']);

$nama_file = $_FILES['file']['name'];

if ($nama_file == "") {
    $file = "";
} else if ($nama_file != "") {

    function upload()
    {
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

		move_uploaded_file($tmp_name, '../../../SijugaNonPSO/AdminNonPSO/file_admin_non_pso/' . $nama_file_baru   );

		return $nama_file_baru; 
    }

    $file = upload();
    if (!$file) {
        return false;
    }
}




mysqli_query($koneksi, "INSERT INTO setoran VALUES('','$tanggal','$jenis_setoran','$jumlah','$keterangan','$file')");

echo "<script>alert('Data Setoran Berhasil di Input'); window.location='../view/VLaporanSetoran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";
exit;
