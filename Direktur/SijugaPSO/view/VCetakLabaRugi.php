<?php
require_once 'vendor/autoload.php';
include 'koneksi.php';


$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$tahun = date('Y', strtotime($tanggal_awal));
$bulan = date('M', strtotime($tanggal_awal));


?>
<style>
    tr {
        border-bottom: 2pt solid;
    }
</style>

<?php


$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'orientation' => 'P']);
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
$sql_penjualan_refill = mysqli_query($koneksi, "SELECT SUM(jumlah) AS penjualan_refil_3kg FROM penjualan_pso WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Penjualan Refill' ");
$data_penjualan_refill = mysqli_fetch_array($sql_penjualan_refill);

$penjualan_refil_3kg = $data_penjualan_refill['penjualan_refil_3kg'];
if (!isset($data_penjualan_refill['penjualan_refil_3kg'])) {
    $penjualan_refil_3kg = 0;
}

$total_penjualan_refill = $penjualan_refil_3kg;


//sql Penjualan tabung isi
$sql_penjualan_tabung_isi = mysqli_query($koneksi, "SELECT SUM(jumlah) AS penjualan_tabung_isi_3kg FROM penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Penjualan Tabung Isi' ");
$data_penjualan_tabung_isi = mysqli_fetch_array($sql_penjualan_tabung_isi);

$penjualan_tabung_isi_3kg = $data_penjualan_tabung_isi['penjualan_tabung_isi_3kg'];
if (!isset($data_penjualan_tabung_isi['penjualan_tabung_isi_3kg'])) {
    $penjualan_tabung_isi_3kg = 0;
}

$total_penjualan_tabung_isi = $penjualan_tabung_isi_3kg;


//sql Penjualan tabung kosong
$sql_penjualan_tabung_kosong = mysqli_query($koneksi, "SELECT SUM(jumlah) AS penjualan_tabung_kosong_3kg FROM penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Penjualan Tabung Isi' ");
$data_penjualan_tabung_kosong = mysqli_fetch_array($sql_penjualan_tabung_kosong);

$penjualan_tabung_kosong_3kg = $data_penjualan_tabung_kosong['penjualan_tabung_kosong_3kg'];
if (!isset($data_penjualan_tabung_kosong['penjualan_tabung_kosong_3kg'])) {
    $penjualan_tabung_kosong_3kg = 0;
}

$total_penjualan_tabung_kosong = $penjualan_tabung_kosong_3kg;

//sql transport fee
$sql_transport_fee = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_transport_fee FROM transport_fee WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
$data_transport_fee = mysqli_fetch_array($sql_transport_fee);

$total_transport_fee = $data_transport_fee['total_transport_fee'];
if (!isset($data_transport_fee['total_transport_fee'])) {
    $total_transport_fee = 0;
}



//sql pembelian refill
$sql_pembelian_refill = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pembelian_refill FROM pembelian_pso WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Pembelian Refill' ");
$data_pembelian_refill = mysqli_fetch_array($sql_pembelian_refill);


$total_pembelian_refill = $data_pembelian_refill['total_pembelian_refill'];
if (!isset($data_pembelian_refill['total_pembelian_refill'])) {
    $total_pembelian_refill = 0;
}

//sql pembelian tabung isi
$sql_pembelian_tabung_isi = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pembelian_tabung_isi FROM pembelian_pso WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Pembelian Tabung Isi' ");
$data_pembelian_tabung_isi = mysqli_fetch_array($sql_pembelian_tabung_isi);


$total_pembelian_tabung_isi = $data_pembelian_tabung_isi['total_pembelian_tabung_isi'];
if (!isset($data_pembelian_tabung_isi['total_pembelian_tabung_isi'])) {
    $total_pembelian_tabung_isi = 0;
}

//sql pembelian tabung kosong
$sql_pembelian_tabung_kosong = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pembelian_tabung_kosong FROM pembelian_pso WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Pembelian Tabung Kosong' ");
$data_pembelian_tabung_kosong = mysqli_fetch_array($sql_pembelian_tabung_kosong);


$total_pembelian_tabung_kosong = $data_pembelian_tabung_kosong['total_pembelian_tabung_kosong'];
if (!isset($data_pembelian_tabung_kosong['total_pembelian_tabung_kosong'])) {
    $total_pembelian_tabung_kosong = 0;
}


//BIAYA USAHA
//sql BBM
$sql_bbm = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_bbm FROM kas_kecil_pso WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akun_kas = 'BBM' ");
$data_bbm = mysqli_fetch_array($sql_bbm);


$total_bbm = $data_bbm['total_bbm'];
if (!isset($data_bbm['total_bbm'])) {
    $total_bbm = 0;
}

//sql Mesin Steam
$sql_mesin_steam = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_mesin_steam FROM kas_kecil_pso WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akun_kas = 'MESIN STEAM' ");
$data_mesin_steam = mysqli_fetch_array($sql_mesin_steam);


$total_mesin_steam = $data_mesin_steam['total_mesin_steam'];
if (!isset($data_mesin_steam['total_mesin_steam'])) {
    $total_mesin_steam = 0;
}

//sql PERAWATAN & SPAREPART
$sql_perawatan_sparepart = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_perawatan_sparepart FROM kas_kecil_pso WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akun_kas = 'PERAWATAN & SPAREPART' ");
$data_perawatan_sparepart = mysqli_fetch_array($sql_perawatan_sparepart);


$total_perawatan_sparepart = $data_perawatan_sparepart['total_perawatan_sparepart'];
if (!isset($data_perawatan_sparepart['total_perawatan_sparepart'])) {
    $total_perawatan_sparepart = 0;
}

//sql PERAWATAN KANTOR & GUDANG
$sql_perawatan_kantor = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_perawatan_kantor FROM kas_kecil_pso WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akun_kas = 'PERAWATAN KANTOR & GUDANG' ");
$data_perawatan_kantor = mysqli_fetch_array($sql_perawatan_kantor);


$total_perawatan_kantor = $data_perawatan_kantor['total_perawatan_kantor'];
if (!isset($data_perawatan_kantor['total_perawatan_kantor'])) {
    $total_perawatan_kantor = 0;
}

//sql ATK
$sql_atk = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_atk FROM kas_kecil_pso WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akun_kas = 'ATK' ");
$data_atk = mysqli_fetch_array($sql_atk);


$total_atk = $data_atk['total_atk'];
if (!isset($data_atk['total_atk'])) {
    $total_atk = 0;
}

//sql GAJI
$sql_gaji = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_gaji FROM kas_kecil_pso WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akun_kas = 'GAJI' ");
$data_gaji = mysqli_fetch_array($sql_gaji);


$total_gaji = $data_gaji['total_gaji'];
if (!isset($data_gaji['total_gaji'])) {
    $total_gaji = 0;
}

//sql PAJAK
$sql_pajak = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pajak FROM kas_kecil_pso WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akun_kas = 'PAJAK' ");
$data_pajak = mysqli_fetch_array($sql_pajak);


$total_pajak = $data_pajak['total_pajak'];
if (!isset($data_pajak['total_pajak'])) {
    $total_pajak = 0;
}

//sql PKB KIR & IZIN USAHA
$sql_pkb_kir_izin = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pkb_kir_izin FROM kas_kecil_pso WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akun_kas = 'PKB KIR & IZIN USAHA' ");
$data_pkb_kir_izin = mysqli_fetch_array($sql_pkb_kir_izin);


$total_pkb_kir_izin = $data_pkb_kir_izin['total_pkb_kir_izin'];
if (!isset($data_pkb_kir_izin['total_pkb_kir_izin'])) {
    $total_pkb_kir_izin = 0;
}

//sql ASURANSI
$sql_asuransi = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_asuransi FROM kas_kecil_pso WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akun_kas = 'ASURANSI' ");
$data_asuransi = mysqli_fetch_array($sql_asuransi);


$total_asuransi = $data_asuransi['total_asuransi'];
if (!isset($data_asuransi['total_asuransi'])) {
    $total_asuransi = 0;
}

//sql LISTRIK TELEPON & INTERNET
$sql_listrik = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_listrik FROM kas_kecil_pso WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akun_kas = 'LISTRIK TELEPON & INTERNET' ");
$data_listrik = mysqli_fetch_array($sql_listrik);


$total_listrik = $data_listrik['total_listrik'];
if (!isset($data_listrik['total_listrik'])) {
    $total_listrik = 0;
}

//sql KONSUMSI
$sql_konsumsi = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_konsumsi FROM kas_kecil_pso WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akun_kas = 'KONSUMSI' ");
$data_konsumsi = mysqli_fetch_array($sql_konsumsi);


$total_konsumsi = $data_konsumsi['total_konsumsi'];
if (!isset($data_konsumsi['total_konsumsi'])) {
    $total_konsumsi = 0;
}

//sql JAMUAN
$sql_jamuan = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_jamuan FROM kas_kecil_pso WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akun_kas = 'JAMUAN' ");
$data_jamuan = mysqli_fetch_array($sql_jamuan);


$total_jamuan = $data_jamuan['total_jamuan'];
if (!isset($data_jamuan['total_jamuan'])) {
    $total_jamuan = 0;
}

//sql PLASTIK WRAP
$sql_plastik_wrap = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_plastik_wrap FROM kas_kecil_pso WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akun_kas = 'PLASTIK WRAP' ");
$data_plastik_wrap = mysqli_fetch_array($sql_plastik_wrap);


$total_plastik_wrap = $data_plastik_wrap['total_plastik_wrap'];
if (!isset($data_plastik_wrap['total_plastik_wrap'])) {
    $total_plastik_wrap = 0;
}

//sql LAIN LAIN
$sql_lain_lain = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_lain_lain FROM kas_kecil_pso WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akun_kas = 'LAIN LAIN' ");
$data_lain_lain = mysqli_fetch_array($sql_lain_lain);


$total_lain_lain = $data_lain_lain['total_lain_lain'];
if (!isset($data_lain_lain['total_lain_lain'])) {
    $total_lain_lain = 0;
}

//sql REFFRESENTATIF
$sql_reffresentatif = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_reffresentatif FROM kas_kecil_pso WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akun_kas = 'REFFRESENTATIF' ");
$data_reffresentatif = mysqli_fetch_array($sql_reffresentatif);


$total_reffresentatif = $data_reffresentatif['total_reffresentatif'];
if (!isset($data_reffresentatif['total_reffresentatif'])) {
    $total_reffresentatif = 0;
}

//sql PENANGANAN COVID 19
$sql_penanganan_covid = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_penanganan_covid FROM kas_kecil_pso WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akun_kas = 'PENANGANAN COVID 19' ");
$data_penanganan_covid = mysqli_fetch_array($sql_penanganan_covid);


$total_penanganan_covid = $data_penanganan_covid['total_penanganan_covid'];
if (!isset($data_penanganan_covid['total_penanganan_covid'])) {
    $total_penanganan_covid = 0;
}

$total_pendapatan = $total_penjualan_refill + $total_penjualan_tabung_isi + $total_penjualan_tabung_kosong + $total_transport_fee;

$total_harga_pokok_penjualan = $total_pembelian_tabung_kosong + $total_pembelian_tabung_isi + $total_pembelian_refill;

$laba_kotor = $total_pendapatan - $total_harga_pokok_penjualan;

$total_biaya_usaha_final = $total_bbm + $total_mesin_steam + $total_perawatan_sparepart + $total_perawatan_kantor + $total_atk + $total_gaji + $total_pajak + $total_pkb_kir_izin + $total_asuransi + $total_listrik + $total_konsumsi + $total_jamuan
    + $total_plastik_wrap + $total_lain_lain + $total_reffresentatif + $total_penanganan_covid;

$laba_bersih_sebelum_pajak = $laba_kotor - $total_biaya_usaha_final;


$html .= '

        <h3 class="panel-title" align="Center" style = "margin-bottom: 1px; margin-top: 1px;"><img style=" max-height: 70px; width: 100%; text-align:center; " > Logo Sijuga PSO  </h3>
        <hr style = "margin-bottom: 1px; margin-top: 1px;">
        <h2 class="panel-title" align="Center" style = "margin-bottom: 1px; margin-top: 1px;"><u><strong>Laporan Laba Rugi</strong></u></h2>
        <pre class="panel-title" align="center"  style="font-size: 12px; margin-bottom: 10px; margin-top: 1px;">' . $tanggal_awal . ' - ' . $tanggal_akhir . '</pre>

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
                                            <td class="text-left">' . formatuang($total_penjualan_refill) . '</td>
                                            <td class="text-left">' . formatuang(0) . '</td>
                                        </tr>

                                        <tr>
                                            <td>4-120</td>
                                            <td class="text-left">Penjualan Tabung Isi</td>
                                            <td class="text-left">' . formatuang($total_penjualan_tabung_isi) . '</td>
                                            <td class="text-left">' . formatuang(0) . '</td>
                                        </tr>
                                        <tr>
                                            <td>4-130</td>
                                            <td class="text-left">Penjualan Tabung Kosong</td>
                                            <td class="text-left">' . formatuang($total_penjualan_tabung_kosong) . '</td>
                                            <td class="text-left">' . formatuang(0) . '</td>
                                        </tr>
                                        <tr>
                                            <td>4-140</td>
                                            <td class="text-left">Transport Fee</td>
                                            <td class="text-left">' . formatuang($total_transport_fee) . '</td>
                                            <td class="text-left">' . formatuang(0) . '</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Pendapatan</strong></td>
                                            <td class="thick-line"></td>
                                            <td class="text-left"><strong>' . formatuang($total_pendapatan) . '</strong></td>
                                            <td class="text-left"><strong>' . formatuang(0) . '</strong></td>
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
                                            <td class="text-left">' . formatuang(0) . '</td>
                                            <td class="text-left">' . formatuang($total_pembelian_refill) . '</td>
                                        </tr>
                                        <tr>
                                            <td>5-120</td>
                                            <td class="text-left">Pembelian Tabung Isi</td>
                                            <td class="text-left">' . formatuang(0) . '</td>
                                            <td class="text-left">' . formatuang($total_pembelian_tabung_isi) . '</td>
                                        </tr>
                                        <tr>
                                            <td>5-130</td>
                                            <td class="text-left">Pembelian Tabung Kosong</td>
                                            <td class="text-left">' . formatuang(0) . '</td>
                                            <td class="text-left">' . formatuang($total_pembelian_tabung_kosong) . '</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Harga Pokok Penjualan</strong></td>
                                            <td class="thick-line"></td>
                                            <td class="text-left"><strong>' . formatuang(0) . '</strong></td>
                                            <td class="text-left"><strong>' . formatuang($total_harga_pokok_penjualan) . '</strong></td>
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


if ($laba_kotor > 0) {
    $html .= '
                                                <td class="no-line text-left"><strong>' . formatuang($laba_kotor) . ' </strong></td>
                                                <td class="no-line text-left"><strong>' . formatuang(0) . ' </strong></td>.';
} else if ($laba_kotor < 0) {
    $html .= '
                                                <td class="no-line text-left"><strong>' . formatuang(0) . '</strong></td>
                                                <td class="no-line text-left"><strong>' . formatuang($laba_kotor) . '</strong></td>.';
} else if ($laba_kotor == 0) {
    $html .= '
                                                <td class="no-line text-left"><strong>' . formatuang(0) . '</strong></td>
                                                <td class="no-line text-left"><strong>' . formatuang(0) . '</strong></td>.';
}
$html .= '
                                            
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
                                            <td>5-501</td>
                                            <td class="text-left">BBM</td>
                                            <td class="text-left">' . formatuang(0) . '</td>
                                            <td class="text-left">' . formatuang($total_bbm) . '</td>
                                        </tr>
                                        <tr>
                                            <td>5-502</td>
                                            <td class="text-left">MESIN STEAM</td>
                                            <td class="text-left">' . formatuang(0) . '</td>
                                            <td class="text-left">' . formatuang($total_mesin_steam) . '</td>
                                        </tr>
                                        <tr>
                                            <td>5-503</td>
                                            <td class="text-left">PERAWATAN & SPAREPART</td>
                                            <td class="text-left">' . formatuang(0) . '</td>
                                            <td class="text-left">' . formatuang($total_perawatan_sparepart) . '</td>
                                        </tr>
                                        <tr>
                                            <td>5-504</td>
                                            <td class="text-left">PERAWATAN KANTOR & GUDANG</td>
                                            <td class="text-left">' . formatuang(0) . '</td>
                                            <td class="text-left">' . formatuang($total_perawatan_kantor) . '</td>
                                        </tr>
                                        <tr>
                                            <td>5-505</td>
                                            <td class="text-left">ATK</td>
                                            <td class="text-left">' . formatuang(0) . '</td>
                                            <td class="text-left">' . formatuang($total_atk) . '</td>
                                        </tr>
                                        <tr>
                                            <td>5-506</td>
                                            <td class="text-left">GAJI</td>
                                            <td class="text-left">' . formatuang(0) . '</td>
                                            <td class="text-left">' . formatuang($total_gaji) . '</td>
                                        </tr>
                                        <tr>
                                            <td>5-507</td>
                                            <td class="text-left">PAJAK</td>
                                            <td class="text-left">' . formatuang(0) . '</td>
                                            <td class="text-left">' . formatuang($total_pajak) . '</td>
                                        </tr>
                                        <tr>
                                            <td>5-508</td>
                                            <td class="text-left">PKB KIR & IZIN USAHA</td>
                                            <td class="text-left">' . formatuang(0) . '</td>
                                            <td class="text-left">' . formatuang($total_pkb_kir_izin) . '</td>
                                        </tr>
                                        <tr>
                                            <td>5-509</td>
                                            <td class="text-left">ASURANSI</td>
                                            <td class="text-left">' . formatuang(0) . '</td>
                                            <td class="text-left">' . formatuang($total_asuransi) . '</td>
                                        </tr>
                                        <tr>
                                            <td>5-510</td>
                                            <td class="text-left">LISTRIK TELEPON & INTERNET</td>
                                            <td class="text-left">' . formatuang(0) . '</td>
                                            <td class="text-left">' . formatuang($total_listrik) . '</td>
                                        </tr>
                                        <tr>
                                            <td>5-511</td>
                                            <td class="text-left">KONSUMSI</td>
                                            <td class="text-left">' . formatuang(0) . '</td>
                                            <td class="text-left">' . formatuang($total_konsumsi) . '</td>
                                        </tr>
                                        <tr>
                                            <td>5-512</td>
                                            <td class="text-left">JAMUAN</td>
                                            <td class="text-left">' . formatuang(0) . '</td>
                                            <td class="text-left">' . formatuang($total_jamuan) . '</td>
                                        </tr>
                                        <tr>
                                            <td>5-513</td>
                                            <td class="text-left">PLASTIK WRAP</td>
                                            <td class="text-left">' . formatuang(0) . '</td>
                                            <td class="text-left">' . formatuang($total_plastik_wrap) . '</td>
                                        </tr>
                                        <tr>
                                            <td>5-514</td>
                                            <td class="text-left">LAIN LAIN</td>
                                            <td class="text-left">' . formatuang(0) . '</td>
                                            <td class="text-left">' . formatuang($total_lain_lain) . '</td>
                                        </tr>
                                        <tr>
                                            <td>5-515</td>
                                            <td class="text-left">REFFRESENTATIF</td>
                                            <td class="text-left">' . formatuang(0) . '</td>
                                            <td class="text-left">' . formatuang($total_reffresentatif) . '</td>
                                        </tr>
                                        <tr>
                                            <td>5-516</td>
                                            <td class="text-left">PENANGANAN COVID 19</td>
                                            <td class="text-left">' . formatuang(0) . '</td>
                                            <td class="text-left">' . formatuang($total_penanganan_covid) . '</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Biaya Usaha</strong></td>
                                            <td class="thick-line"></td>
                                            <td class="text-left"><strong>' . formatuang(0) . '</strong></td>
                                            <td class="text-left"><strong>' . formatuang($total_biaya_usaha_final) . '</strong></td>
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


if ($laba_bersih_sebelum_pajak > 0) {
    $html .= '
                                                <td class="no-line text-left"><strong>' . formatuang($laba_bersih_sebelum_pajak) . ' </strong></td>
                                                <td class="no-line text-left"><strong>' . formatuang(0) . '</strong> </td>.';
} else if ($laba_bersih_sebelum_pajak < 0) {
    $html .= '
                                                <td class="no-line text-left"><strong>' . formatuang(0) . '</strong></td>
                                                <td class="no-line text-left"><strong>' . formatuang($laba_bersih_sebelum_pajak) . '</strong></td>.';
} else if ($laba_bersih_sebelum_pajak == 0) {
    $html .= '
                                                <td class="no-line text-left"><strong>' . formatuang(0) . '</strong></td>
                                                <td class="no-line text-left"><strong>' . formatuang(0) . '</strong></td>.';
}
$html .= '
                                            
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