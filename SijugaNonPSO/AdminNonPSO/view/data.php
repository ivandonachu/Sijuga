<?php  
include "koneksi.php";

$id = $_POST['id'];

$query = mysqli_query($koneksi,"SELECT * FROM customer WHERE kode_customer = '$id' ");
$data = mysqli_fetch_array($query);

echo json_encode($data);
?>
