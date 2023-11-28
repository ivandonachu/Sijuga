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
$tanggal_awal = htmlspecialchars($_POST['tanggal1']);
$tanggal_akhir = htmlspecialchars($_POST['tanggal2']);
$no_laporan = htmlspecialchars($_POST['no_laporan']);
$pembayaran_piutang = htmlspecialchars($_POST['pembayaran_piutang']);
$tanggal_bayar = htmlspecialchars($_POST['tanggal_bayar']);






$nama_file = $_FILES['file']['name'];

if ($nama_file == "") {
	$file = "";
}

else if ( $nama_file != "" ) {

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

		move_uploaded_file($tmp_name, '../file_admin_non_pso/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}

if ($file == '') {
    mysqli_query($koneksi,"UPDATE riwayat_piutang SET tanggal_bayar = '$tanggal_bayar' , pembayaran_piutang = '$pembayaran_piutang'  WHERE no_laporan =  '$no_laporan'");
  }
  else{
    mysqli_query($koneksi,"UPDATE riwayat_piutang SET tanggal_bayar = '$tanggal_bayar' , pembayaran_piutang = '$pembayaran_piutang' , file_bukti = '$file' WHERE no_laporan  =  '$no_laporan'");
                  
  }
  echo "<script>alert('Data Riwayat Piutang Berhasil Diubah'); window.location='../view/VRiwayatPiutang?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;



     
        

       


  ?>