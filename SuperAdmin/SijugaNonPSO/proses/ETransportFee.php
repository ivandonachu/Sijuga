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
$tanggal_awal = htmlspecialchars($_POST['tanggal1']);
$tanggal_akhir = htmlspecialchars($_POST['tanggal2']);
$no_laporan = htmlspecialchars($_POST['no_laporan']);
$tanggal = htmlspecialchars($_POST['tanggal']);
$jumlah = htmlspecialchars($_POST['jumlah']);
$keterangan = htmlspecialchars($_POST['keterangan']);
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




		move_uploaded_file($tmp_name, '../../../SijugaNonPSO/AdminNonPSO/file_admin_non_pso/' . $nama_file   );

		return $nama_file; 
	}

	$file = upload();
	if (!$file) {
		return false;
	}

}


  if ($file == '') {
    mysqli_query($koneksi,"UPDATE transport_fee SET tanggal = '$tanggal' , jumlah = '$jumlah' , keterangan = '$keterangan' WHERE no_laporan =  '$no_laporan'");
  }
  else{
    mysqli_query($koneksi,"UPDATE transport_fee SET tanggal = '$tanggal' , jumlah = '$jumlah' , keterangan = '$keterangan', file_bukti = '$file' WHERE no_laporan =  '$no_laporan'");
                  
  }

  echo "<script>alert('Data Transport Fee Berhasil di Edit'); window.location='../view/VTransportFee?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;



     
        

       


  ?>