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
$no_penjualan = htmlspecialchars($_POST['no_penjualan']);
$tanggal = htmlspecialchars($_POST['tanggal']);
$nama_akun = htmlspecialchars($_POST['nama_akun']);

if(!isset($_POST['nama_pangkalan'])){
    $nama_pangkalan = "";
}else{
 $nama_pangkalan = htmlspecialchars($_POST['nama_pangkalan']);
}


if($nama_pangkalan == ""){
   echo "<script>alert('Nama Pangkalan Tidak Boleh Kosong'); window.location='../view/VPenjualan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";
    exit;

}
$pembayaran = htmlspecialchars($_POST['pembayaran']);

//akses data pangkalan
$sql_pangkalan = mysqli_query($koneksi, "SELECT no_registrasi FROM pangkalan WHERE nama_pangkalan = '$nama_pangkalan'");
$data_pangkalan = mysqli_fetch_array($sql_pangkalan);
$no_registrasi = $data_pangkalan['no_registrasi'];


$qty_55kg = htmlspecialchars($_POST['qty_55kg']);
$harga_55kg = htmlspecialchars($_POST['harga_55kg']);
$jumlah_55kg = $qty_55kg * $harga_55kg;
$qty_12kg = htmlspecialchars($_POST['qty_12kg']);
$harga_12kg = htmlspecialchars($_POST['harga_12kg']);
$jumlah_12kg = $qty_12kg * $harga_12kg;
$jumlah = $jumlah_55kg + $jumlah_12kg;
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


		$nama_file_baru = uniqid();
		$nama_file_baru .= ".";
		$nama_file_baru .= $ekstensi_file;

		move_uploaded_file($tmp_name, '../file_admin/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}


  if ($file == '') {
    mysqli_query($koneksi,"UPDATE penjualan SET tanggal = '$tanggal' , no_registrasi = '$no_registrasi' , nama_akun = '$nama_akun' , pembayaran = '$pembayaran' , qty_55kg = '$qty_55kg' , harga_55kg = '$harga_55kg', jumlah_55kg = '$jumlah_55kg',
                                                  qty_12kg = '$qty_12kg', harga_12kg = '$harga_12kg', jumlah_12kg = '$jumlah_12kg', jumlah = '$jumlah', keterangan = '$keterangan' WHERE no_penjualan =  '$no_penjualan'");
  }
  else{
    mysqli_query($koneksi,"UPDATE penjualan SET tanggal = '$tanggal' , no_registrasi = '$no_registrasi' , nama_akun = '$nama_akun' , pembayaran = '$pembayaran' , qty_55kg = '$qty_55kg' , harga_55kg = '$harga_55kg', jumlah_55kg = '$jumlah_55kg',
                                                  qty_12kg = '$qty_12kg', harga_12kg = '$harga_12kg', jumlah_12kg = '$jumlah_12kg', jumlah = '$jumlah', keterangan = '$keterangan', file_bukti = '$file' WHERE no_penjualan  =  '$no_penjualan'");
                  
  }

  echo "<script>alert('Data Penjualan Berhasil di Edit'); window.location='../view/VPenjualan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;



     
        

       


  ?>