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
$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
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




		move_uploaded_file($tmp_name, '../file_admin_pso/' . $nama_file   );

		return $nama_file; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}


    

            mysqli_query($koneksi,"INSERT INTO transport_fee VALUES('','$tanggal','$jumlah','$keterangan','$file')");
               
            echo "<script>alert('Data Transport Fee Berhasil di Input'); window.location='../view/VTransportFee?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
     

     
        

       


  ?>