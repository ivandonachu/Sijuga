<?php
require_once 'vendor/autoload.php';
include 'koneksi.php';


    $tanggal_awal = $_GET['tanggal1'];
    $tanggal_akhir = $_GET['tanggal2'];
    $tahun = date('Y', strtotime($tanggal_awal));
    $bulan = date('M', strtotime($tanggal_awal)); 


?>
  <style>
   tr{
    border-bottom: 2pt solid;
   }
  </style>

<?php


$mpdf = new \Mpdf\Mpdf([ 'mode' => 'utf-8', 'format' => 'A4', 'orientation' => 'P']);
$mpdf->AddPageByArray([
    'margin-left' => 5,
    'margin-right' => 5,
    'margin-top' => 5,
    'margin-bottom' => 5,
]);

$html = '
<html>

<head>


</head>

<body>
<br>
<br>

        

';

function formatuang($angka)
{
    $uang = "Rp " . number_format($angka, 2, ',', '.');
    return $uang;
}
//sql penjualan refill
$sql_penjualan_refill = mysqli_query($koneksi, "SELECT SUM(jumlah_55kg) AS penjualan_refil_55kg, SUM(jumlah_12kg) AS penjualan_refil_12kg FROM penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Penjualan Refill' ");
$data_penjualan_refill = mysqli_fetch_array($sql_penjualan_refill);


$penjualan_refil_55kg = $data_penjualan_refill['penjualan_refil_55kg'];
if (!isset($data_penjualan_refill['penjualan_refil_55kg'])) {
    $penjualan_refil_55kg = 0;
}

$penjualan_refil_12kg = $data_penjualan_refill['penjualan_refil_12kg'];
if (!isset($data_penjualan_refill['penjualan_refil_12kg'])) {
    $penjualan_refil_12kg = 0;
}

$total_penjualan_refill = $penjualan_refil_12kg + $penjualan_refil_55kg;


//sql Penjualan tabung isi
$sql_penjualan_tabung_isi = mysqli_query($koneksi, "SELECT SUM(jumlah_55kg) AS penjualan_tabung_isi_55kg, SUM(jumlah_12kg) AS penjualan_tabung_isi_12kg FROM penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Penjualan Tabung Isi' ");
$data_penjualan_tabung_isi = mysqli_fetch_array($sql_penjualan_tabung_isi);

$penjualan_tabung_isi_55kg = $data_penjualan_tabung_isi['penjualan_tabung_isi_55kg'];
if (!isset($data_penjualan_tabung_isi['penjualan_tabung_isi_55kg'])) {
    $penjualan_tabung_isi_55kg = 0;
}

$penjualan_tabung_isi_12kg = $data_penjualan_tabung_isi['penjualan_tabung_isi_12kg'];
if (!isset($data_penjualan_tabung_isi['penjualan_tabung_isi_12kg'])) {
    $penjualan_tabung_isi_12kg = 0;
}

$total_penjualan_tabung_isi = $penjualan_tabung_isi_12kg + $penjualan_tabung_isi_55kg;


//sql Penjualan tabung kosong
$sql_penjualan_tabung_kosong = mysqli_query($koneksi, "SELECT SUM(jumlah_55kg) AS penjualan_tabung_kosong_55kg, SUM(jumlah_12kg) AS penjualan_tabung_kosong_12kg FROM penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Penjualan Tabung Isi' ");
$data_penjualan_tabung_kosong = mysqli_fetch_array($sql_penjualan_tabung_kosong);

$penjualan_tabung_kosong_55kg = $data_penjualan_tabung_kosong['penjualan_tabung_kosong_55kg'];
if (!isset($data_penjualan_tabung_kosong['penjualan_tabung_kosong_55kg'])) {
    $penjualan_tabung_kosong_55kg = 0;
}

$penjualan_tabung_kosong_12kg = $data_penjualan_tabung_kosong['penjualan_tabung_kosong_12kg'];
if (!isset($data_penjualan_tabung_kosong['penjualan_tabung_kosong_12kg'])) {
    $penjualan_tabung_kosong_12kg = 0;
}

$total_penjualan_tabung_kosong = $penjualan_tabung_kosong_12kg + $penjualan_tabung_kosong_55kg;

//sql transport fee
$sql_transport_fee = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_transport_fee FROM transport_fee WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
$data_transport_fee = mysqli_fetch_array($sql_transport_fee);

$total_transport_fee = $data_transport_fee['total_transport_fee'];
if (!isset($data_transport_fee['total_transport_fee'])) {
    $total_transport_fee = 0;
}



//sql pembelian refill
$sql_pembelian_refill = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pembelian_refill FROM pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Pembelian Refill' ");
$data_pembelian_refill = mysqli_fetch_array($sql_pembelian_refill);


$total_pembelian_refill = $data_pembelian_refill['total_pembelian_refill'];
if (!isset($data_pembelian_refill['total_pembelian_refill'])) {
    $total_pembelian_refill = 0;
}

//sql pembelian tabung isi
$sql_pembelian_tabung_isi = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pembelian_tabung_isi FROM pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Pembelian Tabung Isi' ");
$data_pembelian_tabung_isi = mysqli_fetch_array($sql_pembelian_tabung_isi);


$total_pembelian_tabung_isi = $data_pembelian_tabung_isi['total_pembelian_tabung_isi'];
if (!isset($data_pembelian_tabung_isi['total_pembelian_tabung_isi'])) {
    $total_pembelian_tabung_isi = 0;
}

//sql pembelian tabung kosong
$sql_pembelian_tabung_kosong = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pembelian_tabung_kosong FROM pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Pembelian Tabung Kosong' ");
$data_pembelian_tabung_kosong = mysqli_fetch_array($sql_pembelian_tabung_kosong);


$total_pembelian_tabung_kosong = $data_pembelian_tabung_kosong['total_pembelian_tabung_kosong'];
if (!isset($data_pembelian_tabung_kosong['total_pembelian_tabung_kosong'])) {
    $total_pembelian_tabung_kosong = 0;
}


//BIAYA USAHA
//sql Gaji Karyawan
$sql_gaji_karyawan = mysqli_query($koneksi, "SELECT SUM(jumlah_pengeluaran) AS total_gaji_karyawan FROM pengeluaran WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Gaji Karyawan' ");
$data_gaji_karyawan = mysqli_fetch_array($sql_gaji_karyawan);


$total_gaji_karyawan = $data_gaji_karyawan['total_gaji_karyawan'];
if (!isset($data_gaji_karyawan['total_gaji_karyawan'])) {
    $total_gaji_karyawan = 0;
}

//sql Gaji driver
$sql_gaji_driver = mysqli_query($koneksi, "SELECT SUM(jumlah_pengeluaran) AS total_gaji_driver FROM pengeluaran WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Gaji Driver' ");
$data_gaji_driver = mysqli_fetch_array($sql_gaji_driver);


$total_gaji_driver = $data_gaji_driver['total_gaji_driver'];
if (!isset($data_gaji_driver['total_gaji_driver'])) {
    $total_gaji_driver = 0;
}

//sql ATK
$sql_atk = mysqli_query($koneksi, "SELECT SUM(jumlah_pengeluaran) AS total_atk FROM pengeluaran WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Alat Tulis Kantor' ");
$data_atk = mysqli_fetch_array($sql_atk);


$total_atk = $data_atk['total_atk'];
if (!isset($data_atk['total_atk'])) {
    $total_atk = 0;
}

//sql biaya administrasi
$sql_biaya_administrasi = mysqli_query($koneksi, "SELECT SUM(jumlah_pengeluaran) AS total_biaya_administrasi FROM pengeluaran WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Administrasi' ");
$data_biaya_administrasi = mysqli_fetch_array($sql_biaya_administrasi);


$total_biaya_administrasi = $data_biaya_administrasi['total_biaya_administrasi'];
if (!isset($data_biaya_administrasi['total_biaya_administrasi'])) {
    $total_biaya_administrasi = 0;
}

//sql biaya Kantor
$sql_biaya_kantor = mysqli_query($koneksi, "SELECT SUM(jumlah_pengeluaran) AS total_biaya_kantor FROM pengeluaran WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Kantor' ");
$data_biaya_kantor = mysqli_fetch_array($sql_biaya_kantor);


$total_biaya_kantor = $data_biaya_kantor['total_biaya_kantor'];
if (!isset($data_biaya_kantor['total_biaya_kantor'])) {
    $total_biaya_kantor = 0;
}

//sql biaya Konsumsi
$sql_biaya_konsumsi = mysqli_query($koneksi, "SELECT SUM(jumlah_pengeluaran) AS total_biaya_konsumsi FROM pengeluaran WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Konsumsi' ");
$data_biaya_konsumsi = mysqli_fetch_array($sql_biaya_konsumsi);


$total_biaya_konsumsi = $data_biaya_konsumsi['total_biaya_konsumsi'];
if (!isset($data_biaya_konsumsi['total_biaya_konsumsi'])) {
    $total_biaya_konsumsi = 0;
}

//sql Biaya Penjualan & Pemasaran
$sql_biaya_pemasaran = mysqli_query($koneksi, "SELECT SUM(jumlah_pengeluaran) AS total_biaya_pemasaran FROM pengeluaran WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Penjualan & Pemasaran' ");
$data_biaya_pemasaran = mysqli_fetch_array($sql_biaya_pemasaran);


$total_biaya_pemasaran = $data_biaya_pemasaran['total_biaya_pemasaran'];
if (!isset($data_biaya_pemasaran['total_biaya_pemasaran'])) {
    $total_biaya_pemasaran = 0;
}

//sql Biaya Perbaikan Kendaraan
$sql_biaya_perbaikan = mysqli_query($koneksi, "SELECT SUM(jumlah_pengeluaran) AS total_biaya_perbaikan FROM pengeluaran WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Perbaikan Kendaraan' ");
$data_biaya_perbaikan = mysqli_fetch_array($sql_biaya_perbaikan);


$total_biaya_perbaikan = $data_biaya_perbaikan['total_biaya_perbaikan'];
if (!isset($data_biaya_perbaikan['total_biaya_perbaikan'])) {
    $total_biaya_perbaikan = 0;
}

//sql Listrik & Telepon
$sql_listrik = mysqli_query($koneksi, "SELECT SUM(jumlah_pengeluaran) AS total_listrik FROM pengeluaran WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Listrik & Telepon' ");
$data_listrik = mysqli_fetch_array($sql_listrik);


$total_listrik = $data_listrik['total_listrik'];
if (!isset($data_listrik['total_listrik'])) {
    $total_listrik = 0;
}

//sql Transport / Perjalanan Dinas
$sql_transport = mysqli_query($koneksi, "SELECT SUM(jumlah_pengeluaran) AS total_transport FROM pengeluaran WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Transport / Perjalanan Dinas' ");
$data_transport = mysqli_fetch_array($sql_transport);


$total_transport = $data_transport['total_transport'];
if (!isset($data_transport['total_transport'])) {
    $total_transport = 0;
}

$total_pendapatan = $total_penjualan_refill + $total_penjualan_tabung_isi + $total_penjualan_tabung_kosong + $total_transport_fee;

$total_harga_pokok_penjualan = $total_pembelian_tabung_kosong + $total_pembelian_tabung_isi + $total_pembelian_refill;

$laba_kotor = $total_pendapatan - $total_harga_pokok_penjualan;

$total_biaya_usaha_final = $total_gaji_karyawan + $total_gaji_karyawan + $total_atk + $total_biaya_administrasi + $total_biaya_kantor + $total_biaya_konsumsi + $total_biaya_pemasaran + $total_biaya_perbaikan +
                     $total_listrik + $total_transport;

$laba_bersih_sebelum_pajak = $laba_kotor - $total_biaya_usaha_final;
    

        $html .= '

        <h3 class="panel-title" align="Center" style = "margin-bottom: 1px; margin-top: 1px;"><img style=" max-height: 70px; width: 100%; text-align:center; " > Logo Sijuga NON PSO  </h3>
        <hr style = "margin-bottom: 1px; margin-top: 1px;">
        <h2 class="panel-title" align="Center" style = "margin-bottom: 1px; margin-top: 1px;"><u><strong>Laporan Laba Rugi</strong></u></h2>
        <pre class="panel-title" align="center"  style="font-size: 12px; margin-bottom: 10px; margin-top: 1px;">'. $tanggal_awal .' - '. $tanggal_akhir .'</pre>

        <br>
        <table align = "center" class="table table-condensed" style="color : black;">
                                    <thead>
                                        <tr>
                                            <td><strong>Akun</strong></td>
                                            <td class="text-left"><strong>Nama Akun</strong></td>
                                            <td class="text-left"><strong>Debit</strong></td>
                                            <td class="text-left"><strong>Kredit</strong></td>
                                        </tr>
                                        
                                    </thead>
                                    <tbody>
                                        <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                        <tr>
                                        <td></td>
                                        <td class="thick-line"></td>
                                        <td class="no-line text-left"></td>
                                        <td class="no-line text-left"></td>
                                        </tr>
                                        <tr>
                                            <td><strong>4-000</strong></td>
                                            <td class="text-left"><strong>PENDAPATAN</strong></td>
                                            <td class="text-left"></td>
                                            <td class="text-left"></td>
                                        </tr>
                                        <tr>
                                            <td>4-110</td>
                                            <td class="text-left">Penjualan Refill</td>
                                            <td class="text-left">' .formatuang($total_penjualan_refill). '</td>
                                            <td class="text-left">' .formatuang(0). '</td>
                                        </tr>

                                        <tr>
                                            <td>4-120</td>
                                            <td class="text-left">Penjualan Tabung Isi</td>
                                            <td class="text-left">' .formatuang($total_penjualan_tabung_isi). '</td>
                                            <td class="text-left">' .formatuang(0). '</td>
                                        </tr>
                                        <tr>
                                            <td>4-130</td>
                                            <td class="text-left">Penjualan Tabung Kosong</td>
                                            <td class="text-left">' .formatuang($total_penjualan_tabung_kosong). '</td>
                                            <td class="text-left">' .formatuang(0). '</td>
                                        </tr>
                                        <tr>
                                            <td>4-140</td>
                                            <td class="text-left">Transport Fee</td>
                                            <td class="text-left">' .formatuang($total_transport_fee). '</td>
                                            <td class="text-left">' .formatuang(0). '</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Pendapatan</strong></td>
                                            <td class="thick-line"></td>
                                            <td class="text-left"><strong>' .formatuang($total_pendapatan). '</strong></td>
                                            <td class="text-left"><strong>' .formatuang(0). '</strong></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td class="thick-line"></td>
                                            <td class="no-line text-left"></td>
                                            <td class="no-line text-left"></td>
                                        </tr>
                                        <tr>
                                            <td><strong>5-000</strong></td>
                                            <td class="text-left"><strong>HARGA POKOK PENJUALAN</strong></td>
                                            <td class="text-left"></td>
                                            <td class="text-left"></td>
                                        </tr>
                                        <tr>
                                            <td>5-110</td>
                                            <td class="text-left">Pembelian Refill</td>
                                            <td class="text-left">' .formatuang(0). '</td>
                                            <td class="text-left">' .formatuang($total_pembelian_refill). '</td>
                                        </tr>
                                        <tr>
                                            <td>5-120</td>
                                            <td class="text-left">Pembelian Tabung Isi</td>
                                            <td class="text-left">' .formatuang(0). '</td>
                                            <td class="text-left">' .formatuang($total_pembelian_tabung_isi). '</td>
                                        </tr>
                                        <tr>
                                            <td>5-130</td>
                                            <td class="text-left">Pembelian Tabung Kosong</td>
                                            <td class="text-left">' .formatuang(0). '</td>
                                            <td class="text-left">' .formatuang($total_pembelian_tabung_kosong). '</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Harga Pokok Penjualan</strong></td>
                                            <td class="thick-line"></td>
                                            <td class="text-left"><strong>' .formatuang(0). '</strong></td>
                                            <td class="text-left"><strong>' .formatuang($total_harga_pokok_penjualan). '</strong></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td class="thick-line"></td>
                                            <td class="no-line text-left"></td>
                                            <td class="no-line text-left"></td>
                                        </tr>
                                        <tr>
                                            <td><strong>LABA KOTOR</strong></td>
                                            <td class="thick-line"></td>';
                                     

                                            if ( $laba_kotor > 0) {   
                                                $html .= '
                                                <td class="no-line text-left"><strong>'.formatuang($laba_kotor) .' </strong></td>
                                                <td class="no-line text-left"><strong>'. formatuang(0) .' </strong></td>.';
                                                
                                            } else if ($laba_kotor < 0) {
                                                $html .= '
                                                <td class="no-line text-left"><strong>'. formatuang(0).'</strong></td>
                                                <td class="no-line text-left"><strong>'. formatuang($laba_kotor).'</strong></td>.';
                                             } else if ($laba_kotor == 0) { 
                                                $html .= '
                                                <td class="no-line text-left"><strong>'. formatuang(0).'</strong></td>
                                                <td class="no-line text-left"><strong>'. formatuang(0).'</strong></td>.';
                                            }  $html .= '
                                            
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td class="thick-line"></td>
                                            <td class="no-line text-left"></td>
                                            <td class="no-line text-left"></td>
                                        </tr>
                                        <tr>
                                            <td><strong>5-500</strong></td>
                                            <td class="text-left"><strong>BIAYA USAHA</strong></td>
                                            <td class="text-left"></td>
                                            <td class="text-left"></td>
                                        </tr>
                                        <tr>
                                            <td>5-510</td>
                                            <td class="text-left">Gaji Karyawan</td>
                                            <td class="text-left">'.formatuang(0).'</td>
                                            <td class="text-left">'. formatuang($total_gaji_karyawan).'</td>
                                        </tr>
                                        <tr>
                                            <td>5-511</td>
                                            <td class="text-left">Gaji Driver</td>
                                            <td class="text-left">'.formatuang(0).'</td>
                                            <td class="text-left">'. formatuang($total_gaji_driver).'</td>
                                        </tr>
                                        <tr>
                                            <td>5-520</td>
                                            <td class="text-left">Alat Tulis Kantor</td>
                                            <td class="text-left">'.formatuang(0).'</td>
                                            <td class="text-left">'. formatuang($total_atk).'</td>
                                        </tr>
                                        <tr>
                                            <td>5-530</td>
                                            <td class="text-left">Biaya Administrasi</td>
                                            <td class="text-left">'.formatuang(0).'</td>
                                            <td class="text-left">'. formatuang($total_biaya_administrasi).'</td>
                                        </tr>
                                        <tr>
                                            <td>5-540</td>
                                            <td class="text-left">Biaya Kantor</td>
                                            <td class="text-left">'.formatuang(0).'</td>
                                            <td class="text-left">'. formatuang($total_biaya_kantor).'</td>
                                        </tr>
                                        <tr>
                                            <td>5-550</td>
                                            <td class="text-left">Biaya Konsumsi</td>
                                            <td class="text-left">'.formatuang(0).'</td>
                                            <td class="text-left">'. formatuang($total_biaya_konsumsi).'</td>
                                        </tr>
                                        <tr>
                                            <td>5-560</td>
                                            <td class="text-left">Biaya Penjualan & Pemasaran</td>
                                            <td class="text-left">'.formatuang(0).'</td>
                                            <td class="text-left">'. formatuang($total_biaya_pemasaran).'</td>
                                        </tr>
                                        <tr>
                                            <td>5-570</td>
                                            <td class="text-left">Biaya Perbaikan Kendaraan</td>
                                            <td class="text-left">'.formatuang(0).'</td>
                                            <td class="text-left">'. formatuang($total_biaya_perbaikan).'</td>
                                        </tr>
                                        <tr>
                                            <td>5-580</td>
                                            <td class="text-left">Listrik & Telepon</td>
                                            <td class="text-left">'.formatuang(0).'</td>
                                            <td class="text-left">'. formatuang($total_listrik).'</td>
                                        </tr>
                                        <tr>
                                            <td>5-590</td>
                                            <td class="text-left">Transport / Perjalanan Dinas</td>
                                            <td class="text-left">'.formatuang(0).'</td>
                                            <td class="text-left">'. formatuang($total_transport).'</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Biaya Usaha</strong></td>
                                            <td class="thick-line"></td>
                                            <td class="text-left"><strong>'.formatuang(0).'</strong></td>
                                            <td class="text-left"><strong>'. formatuang($total_biaya_usaha_final).'</strong></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td class="thick-line"></td>
                                            <td class="no-line text-left"></td>
                                            <td class="no-line text-left"></td>
                                        </tr>
                                        <tr style="background-color:    #F0F8FF; ">
                                            <td><strong>LABA BERSIH SEBELUM PAJAK</strong></td>
                                            <td class="thick-line"></td>';
                                     

                                            if ( $laba_bersih_sebelum_pajak > 0) {   
                                                $html .= '
                                                <td class="no-line text-left"><strong>'.formatuang($laba_bersih_sebelum_pajak) .' </strong></td>
                                                <td class="no-line text-left"><strong>'. formatuang(0) .'</strong> </td>.';
                                                
                                            } else if ($laba_bersih_sebelum_pajak < 0) {
                                                $html .= '
                                                <td class="no-line text-left"><strong>'. formatuang(0).'</strong></td>
                                                <td class="no-line text-left"><strong>'. formatuang($laba_bersih_sebelum_pajak).'</strong></td>.';
                                             } else if ($laba_bersih_sebelum_pajak == 0) { 
                                                $html .= '
                                                <td class="no-line text-left"><strong>'. formatuang(0).'</strong></td>
                                                <td class="no-line text-left"><strong>'. formatuang(0).'</strong></td>.';
                                            }  $html .= '
                                            
                                        </tr>
                                    </tbody>
                                </table>';
        
        

    



    $html .= '';

    





 $html .= '</body>

</html>';

$mpdf->setAutoTopMargin = 'stretch';
$mpdf->setAutoBottomMargin = 'stretch';
$mpdf->WriteHTML($html);
$mpdf->Output();
?>