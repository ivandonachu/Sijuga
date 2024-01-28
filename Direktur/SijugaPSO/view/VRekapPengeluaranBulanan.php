<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION["login"])) {
    header("Location: logout.php");
    exit;
}
$username = $_COOKIE['username'];
$result1 = mysqli_query($koneksi, "SELECT * FROM super_account WHERE username = '$username'");
$data1 = mysqli_fetch_array($result1);
$jabatan_valid = $data1['jabatan'];
$nama = $data1['nama'];
$foto_profile = $data1['foto_profile'];

if ($jabatan_valid == 'Direktur') {
} else {
    header("Location: logout.php");
    exit;
}


if (isset($_POST['tanggal1'])) {
    $tanggal_awal = $_POST['tanggal1'];

    $akun_kas = $_POST['akun_kas'];

    $januari_awal = date('Y-1-1', strtotime($tanggal_awal));
    $januari_akhir = date('Y-1-31', strtotime($tanggal_awal));

    $februari_awal = date('Y-2-1', strtotime($tanggal_awal));
    $februari_akhir = date('Y-2-31', strtotime($tanggal_awal));

    $maret_awal = date('Y-3-1', strtotime($tanggal_awal));
    $maret_akhir = date('Y-3-31', strtotime($tanggal_awal));

    $april_awal = date('Y-4-1', strtotime($tanggal_awal));
    $april_akhir = date('Y-4-31', strtotime($tanggal_awal));

    $mei_awal = date('Y-5-1', strtotime($tanggal_awal));
    $mei_akhir = date('Y-5-31', strtotime($tanggal_awal));

    $juni_awal = date('Y-6-1', strtotime($tanggal_awal));
    $juni_akhir = date('Y-6-31', strtotime($tanggal_awal));

    $juli_awal = date('Y-7-1', strtotime($tanggal_awal));
    $juli_akhir = date('Y-7-31', strtotime($tanggal_awal));

    $agustus_awal = date('Y-8-1', strtotime($tanggal_awal));
    $agustus_akhir = date('Y-8-31', strtotime($tanggal_awal));

    $september_awal = date('Y-9-1', strtotime($tanggal_awal));
    $september_akhir = date('Y-9-31', strtotime($tanggal_awal));

    $oktober_awal = date('Y-10-1', strtotime($tanggal_awal));
    $oktober_akhir = date('Y-10-31', strtotime($tanggal_awal));

    $november_awal = date('Y-11-1', strtotime($tanggal_awal));
    $november_akhir = date('Y-11-31', strtotime($tanggal_awal));

    $desember_awal = date('Y-12-1', strtotime($tanggal_awal));
    $desember_akhir = date('Y-12-31', strtotime($tanggal_awal));
} else {

    $akun_kas = 'BBM';

    $januari_awal = date('Y-1-1');
    $januari_akhir = date('Y-1-31');

    $februari_awal = date('Y-2-1');
    $februari_akhir = date('Y-2-31');

    $maret_awal = date('Y-3-1');
    $maret_akhir = date('Y-3-31');

    $april_awal = date('Y-4-1');
    $april_akhir = date('Y-4-31');

    $mei_awal = date('Y-5-1');
    $mei_akhir = date('Y-5-31');

    $juni_awal = date('Y-6-1');
    $juni_akhir = date('Y-6-31');

    $juli_awal = date('Y-7-1');
    $juli_akhir = date('Y-7-31');

    $agustus_awal = date('Y-8-1');
    $agustus_akhir = date('Y-8-31');

    $september_awal = date('Y-9-1');
    $september_akhir = date('Y-9-31');

    $oktober_awal = date('Y-10-1');
    $oktober_akhir = date('Y-10-31');

    $november_awal = date('Y-11-1');
    $november_akhir = date('Y-11-31');

    $desember_awal = date('Y-12-1');
    $desember_akhir = date('Y-12-31');
}




$table = mysqli_query($koneksi, "SELECT * FROM list_kendaraan WHERE status_kendaraan = 'PSO' ");





function formatuang($angka)
{
    $uang = "Rp " . number_format($angka, 2, ',', '.');
    return $uang;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Rekap Pengeluaran Bulanan PSO</title>
    <!-- Custom fonts for this template-->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/bootstrap-select/dist/css/bootstrap-select.css">
    <link rel="stylesheet" href="/css/dataTables.bootstrap4.min.css">




</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
                <div class="sidebar-brand-icon rotate-n-15">

                </div>
                <div class="sidebar-brand-text mx-3">PT DWI KHARISMA ABADI</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="DsAdmin">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span style="font-size: 17px;">Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Menu List Pt -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwox" aria-expanded="true" aria-controls="collapseTwox">
                    <i class="fa-solid fa-cash-register"></i>
                    <span>List PT</span>
                </a>
                <div id="collapseTwox" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="/Direktur/SijugaNonPSO/view/DsSijugaNonPSO">SijugaNonPSO</a>
                        <a class="collapse-item" href="/Direktur/SijugaPSO/view/DsSijugaPSO">SijugaPSO</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Menu Laporan Perusahaan -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwoz" aria-expanded="true" aria-controls="collapseTwoz">
                    <i class="fa-solid fa-file-lines"></i>
                    <span>Laporan</span>
                </a>
                <div id="collapseTwoz" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="VLabaRugi">Laba Rugi</a>
                        <a class="collapse-item" href="VLaporanAlokasi">Laporan Alokasi</a>
                        <a class="collapse-item" href="VRekapPengeluaranBulanan">Rek Pengeluaran Bulanan</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Menu Keuangan -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fa-solid fa-cash-register"></i>
                    <span>Transaksi</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="VPenjualan">Penjualan</a>
                        <a class="collapse-item" href="VPembelian">Pembelian</a>
                        <a class="collapse-item" href="VTransportFee">Transport Fee</a>
                        <a class="collapse-item" href="VLaporanInventory">Laporan Inventory</a>
                        <a class="collapse-item" href="VPerencanaanAgen">Perencanaan Agen</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Menu Pengeeluaran -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilitiesx" aria-expanded="true" aria-controls="collapseUtilitiesx">
                    <i class="fa-solid fa-wallet"></i>
                    <span>Pengeluaran</span>
                </a>
                <div id="collapseUtilitiesx" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="VKasKecil">Kas Kecil</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Menu Anggota -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities2" aria-expanded="true" aria-controls="collapseUtilities2">
                    <i class="fa-solid fa-people-group"></i>
                    <span>Customer</span>
                </a>
                <div id="collapseUtilities2" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="VListCustomer">List Customer</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Menu Anggota -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fa-solid fa-people-group"></i>
                    <span>Aset</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="VListKendaraan">List Kendaraan</a>
                    </div>
                </div>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>


        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - Informasi Akun -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo "$nama"; ?></span><!-- link nama profile -->
                                <img class="img-profile rounded-circle" src="/img/foto_profile/<?= $foto_profile; ?>"><!-- link foto profile -->
                            </a>
                            <!-- Dropdown - Informasi Akun -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="VProfile">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">



                    <!-- Tabel List Akun -->



                    <!-- Posisi Halaman -->
                    <small class="m-0 font-weight-thin text-primary"><a href="DsAdmin">Dashboard</a> <i style="color: grey;" class="fa fa-caret-right" aria-hidden="true"></i> <a style="color: grey;">Rekap Pengeluaran Bulanan PSO</a> </small>
                    <br>
                    <br>

                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h5 style="color: grey;">Rekap Pengeluaran Bulanan PSO</h5>
                        </div>
                        <!-- Card Body -->
                        <div style="height: 1500px;" class="card-body">
                            <div class="chart-area">

                                <!-- Form Tanggal Akses Data -->
                                <?php echo "<form  method='POST' action='VRekapPengeluaranBulanan' style='margin-bottom: 15px;'>" ?>
                                <div>
                                    <div class="row" align="left" style="margin-left: 20px;">
                                        <div class="col-md-2">
                                            <input type="date" id="tanggal1" class="form-control style=" font-size: 14px" name="tanggal1">
                                        </div>
                                        <div class="col-md-2">

                                            <select name="akun_kas" class="form-control" required="">

                                                <option>BBM</option>
                                                <option>MESIN STEAM</option>
                                                <option>PERAWATAN & SPAREPART</option>
                                                <option>PERAWATAN KANTOR & GUDANG</option>
                                                <option>ATK</option>
                                                <option>GAJI</option>
                                                <option>PAJAK</option>
                                                <option>PKB KIR & IZIN USAHA</option>
                                                <option>ASURANSI</option>
                                                <option>LISTRIK TELEPON & INTERNET</option>
                                                <option>KONSUMSI</option>
                                                <option>JAMUAN</option>
                                                <option>PLASTIK WRAP</option>
                                                <option>LAIN LAIN</option>
                                                <option>REFFRESENTATIF</option>
                                                <option>PENANGANAN COVID 19</option>
                                            </select>

                                        </div>

                                        <button type="submit" name="submmit" style="font-size: 12px; margin-left: 10px; margin-bottom: 2px;" class="btn1 btn btn-outline-primary btn-sm">Lihat</button>
                                    </div>
                                </div>
                                </form>

                                <div class="row">
                                    <div class="col-md-6">
                                        <?php echo " <a style='font-size: 12px'> Data yang tampil  $januari_awal  sampai  $desember_akhir </a>" ?>
                                    </div>
                                </div>


                                <br>
                                <hr>
                                <br>

                                <?php

                                if ($akun_kas == 'BBM' || $akun_kas == 'PERAWATAN & SPAREPART') { ?>

                                    <h5 align="center" style='font-size: clamp(12px, 1vw, 18px); color: black;'>REKAP Pengeluaran <?= $akun_kas ?> PSO</h5>
                                    <!-- Tabel -->
                                    <table id="example" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
                                        <thead>
                                            <tr>
                                                <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>No Polisi</th>
                                                <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total Januari </th>
                                                <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total Februari </th>
                                                <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total Maret </th>
                                                <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total April </th>
                                                <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total Mei </th>
                                                <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total Juni </th>
                                                <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total Juli </th>
                                                <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total Agustus </th>
                                                <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total September </th>
                                                <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total Oktober </th>
                                                <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total November </th>
                                                <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total Desember </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $total_seluruh_januari = 0;
                                            $total_seluruh_februari = 0;
                                            $total_seluruh_maret = 0;
                                            $total_seluruh_april = 0;
                                            $total_seluruh_mei = 0;
                                            $total_seluruh_juni = 0;
                                            $total_seluruh_juli = 0;
                                            $total_seluruh_agustus = 0;
                                            $total_seluruh_september = 0;
                                            $total_seluruh_oktober = 0;
                                            $total_seluruh_november = 0;
                                            $total_seluruh_desember = 0;
                                            ?>
                                            <?php while ($data = mysqli_fetch_array($table)) {
                                                $no_polisi = $data['no_polisi'];

                                                //januari
                                                $sql_januari = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_jumlah_januari FROM kas_kecil WHERE tanggal BETWEEN '$januari_awal' AND '$januari_akhir' AND akun_kas = '$akun_kas' AND no_polisi = '$no_polisi'");
                                                $data_januari = mysqli_fetch_array($sql_januari);
                                                if (!isset($data_januari['total_jumlah_januari'])) {
                                                    $total_jumlah_januari = 0;
                                                } else {

                                                    $total_jumlah_januari = $data_januari['total_jumlah_januari'];
                                                    $total_seluruh_januari = $total_seluruh_januari + $total_jumlah_januari;
                                                }

                                                //februari
                                                $sql_februari = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_jumlah_februari FROM kas_kecil WHERE tanggal BETWEEN '$februari_awal' AND '$februari_akhir' AND akun_kas = '$akun_kas' AND no_polisi = '$no_polisi'");
                                                $data_februari = mysqli_fetch_array($sql_februari);
                                                if (!isset($data_februari['total_jumlah_februari'])) {
                                                    $total_jumlah_februari = 0;
                                                } else {

                                                    $total_jumlah_februari = $data_februari['total_jumlah_februari'];
                                                    $total_seluruh_februari = $total_seluruh_februari + $total_jumlah_februari;
                                                }

                                                //maret
                                                $sql_maret = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_jumlah_maret FROM kas_kecil WHERE tanggal BETWEEN '$maret_awal' AND '$maret_akhir' AND akun_kas = '$akun_kas' AND no_polisi = '$no_polisi'");
                                                $data_maret = mysqli_fetch_array($sql_maret);
                                                if (!isset($data_maret['total_jumlah_maret'])) {
                                                    $total_jumlah_maret = 0;
                                                } else {

                                                    $total_jumlah_maret = $data_maret['total_jumlah_maret'];
                                                    $total_seluruh_maret = $total_seluruh_maret + $total_jumlah_maret;
                                                }

                                                //april
                                                $sql_april = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_jumlah_april FROM kas_kecil WHERE tanggal BETWEEN '$april_awal' AND '$april_akhir' AND akun_kas = '$akun_kas' AND no_polisi = '$no_polisi'");
                                                $data_april = mysqli_fetch_array($sql_april);
                                                if (!isset($data_april['total_jumlah_april'])) {
                                                    $total_jumlah_april = 0;
                                                } else {

                                                    $total_jumlah_april = $data_april['total_jumlah_april'];
                                                    $total_seluruh_april = $total_seluruh_april + $total_jumlah_april;
                                                }

                                                //mei
                                                $sql_mei = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_jumlah_mei FROM kas_kecil WHERE tanggal BETWEEN '$mei_awal' AND '$mei_akhir' AND akun_kas = '$akun_kas' AND no_polisi = '$no_polisi'");
                                                $data_mei = mysqli_fetch_array($sql_mei);
                                                if (!isset($data_mei['total_jumlah_mei'])) {
                                                    $total_jumlah_mei = 0;
                                                } else {

                                                    $total_jumlah_mei = $data_mei['total_jumlah_mei'];
                                                    $total_seluruh_mei = $total_seluruh_mei + $total_jumlah_mei;
                                                }

                                                //juni
                                                $sql_juni = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_jumlah_juni FROM kas_kecil WHERE tanggal BETWEEN '$juni_awal' AND '$juni_akhir' AND akun_kas = '$akun_kas' AND no_polisi = '$no_polisi'");
                                                $data_juni = mysqli_fetch_array($sql_juni);
                                                if (!isset($data_juni['total_jumlah_juni'])) {
                                                    $total_jumlah_juni = 0;
                                                } else {

                                                    $total_jumlah_juni = $data_juni['total_jumlah_juni'];
                                                    $total_seluruh_juni = $total_seluruh_juni + $total_jumlah_juni;
                                                }

                                                //juni
                                                $sql_juli = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_jumlah_juli FROM kas_kecil WHERE tanggal BETWEEN '$juli_awal' AND '$juli_akhir' AND akun_kas = '$akun_kas' AND no_polisi = '$no_polisi'");
                                                $data_juli = mysqli_fetch_array($sql_juli);
                                                if (!isset($data_juli['total_jumlah_juli'])) {
                                                    $total_jumlah_juli = 0;
                                                } else {

                                                    $total_jumlah_juli = $data_juli['total_jumlah_juli'];
                                                    $total_seluruh_juli = $total_seluruh_juli + $total_jumlah_juli;
                                                }

                                                //agustus
                                                $sql_agustus = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_jumlah_agustus FROM kas_kecil WHERE tanggal BETWEEN '$agustus_awal' AND '$agustus_akhir' AND akun_kas = '$akun_kas' AND no_polisi = '$no_polisi'");
                                                $data_agustus = mysqli_fetch_array($sql_agustus);
                                                if (!isset($data_agustus['total_jumlah_agustus'])) {
                                                    $total_jumlah_agustus = 0;
                                                } else {

                                                    $total_jumlah_agustus = $data_agustus['total_jumlah_agustus'];
                                                    $total_seluruh_agustus = $total_seluruh_agustus + $total_jumlah_agustus;
                                                }

                                                //september
                                                $sql_september = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_jumlah_september FROM kas_kecil WHERE tanggal BETWEEN '$september_awal' AND '$september_akhir' AND akun_kas = '$akun_kas' AND no_polisi = '$no_polisi'");
                                                $data_september = mysqli_fetch_array($sql_september);
                                                if (!isset($data_september['total_jumlah_september'])) {
                                                    $total_jumlah_september = 0;
                                                } else {

                                                    $total_jumlah_september = $data_september['total_jumlah_september'];
                                                    $total_seluruh_september = $total_seluruh_september + $total_jumlah_september;
                                                }

                                                //oktober
                                                $sql_oktober = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_jumlah_oktober FROM kas_kecil WHERE tanggal BETWEEN '$oktober_awal' AND '$oktober_akhir' AND akun_kas = '$akun_kas' AND no_polisi = '$no_polisi'");
                                                $data_oktober = mysqli_fetch_array($sql_oktober);
                                                if (!isset($data_oktober['total_jumlah_oktober'])) {
                                                    $total_jumlah_oktober = 0;
                                                } else {

                                                    $total_jumlah_oktober = $data_oktober['total_jumlah_oktober'];
                                                    $total_seluruh_oktober = $total_seluruh_oktober + $total_jumlah_oktober;
                                                }

                                                //november
                                                $sql_november = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_jumlah_november FROM kas_kecil WHERE tanggal BETWEEN '$november_awal' AND '$november_akhir' AND akun_kas = '$akun_kas'AND no_polisi = '$no_polisi' ");
                                                $data_november = mysqli_fetch_array($sql_november);
                                                if (!isset($data_november['total_jumlah_november'])) {
                                                    $total_jumlah_november = 0;
                                                } else {

                                                    $total_jumlah_november = $data_november['total_jumlah_november'];
                                                    $total_seluruh_november = $total_seluruh_november + $total_jumlah_november;
                                                }

                                                //desember
                                                $sql_desember = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_jumlah_desember FROM kas_kecil WHERE tanggal BETWEEN '$desember_awal' AND '$desember_akhir' AND akun_kas = '$akun_kas' AND no_polisi = '$no_polisi'");
                                                $data_desember = mysqli_fetch_array($sql_desember);
                                                if (!isset($data_desember['total_jumlah_desember'])) {
                                                    $total_jumlah_desember = 0;
                                                } else {

                                                    $total_jumlah_desember = $data_desember['total_jumlah_desember'];
                                                    $total_seluruh_desember = $total_seluruh_desember + $total_jumlah_desember;
                                                }

                                                echo "<tr>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$no_polisi</td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>" ?> <?= formatuang($total_jumlah_januari); ?> <?php echo "</td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>" ?> <?= formatuang($total_jumlah_februari); ?> <?php echo "</td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>" ?> <?= formatuang($total_jumlah_maret); ?> <?php echo "</td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>" ?> <?= formatuang($total_jumlah_april); ?> <?php echo "</td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>" ?> <?= formatuang($total_jumlah_mei); ?> <?php echo "</td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>" ?> <?= formatuang($total_jumlah_juni); ?> <?php echo "</td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>" ?> <?= formatuang($total_jumlah_juli); ?> <?php echo "</td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>" ?> <?= formatuang($total_jumlah_agustus); ?> <?php echo "</td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>" ?> <?= formatuang($total_jumlah_september); ?> <?php echo "</td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>" ?> <?= formatuang($total_jumlah_oktober); ?> <?php echo "</td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>" ?> <?= formatuang($total_jumlah_november); ?> <?php echo "</td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>" ?> <?= formatuang($total_jumlah_desember); ?> <?php echo "</td>
                                            
                                             </tr>";
                                                                                                                                                        }
                                                                                                                                                            ?>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'><strong>TOTAL</strong></td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_seluruh_januari); ?></strong> </td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_seluruh_februari); ?></strong> </td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_seluruh_maret); ?></strong> </td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_seluruh_april); ?></strong> </td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_seluruh_mei); ?></strong> </td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_seluruh_juni); ?></strong> </td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_seluruh_juli); ?></strong> </td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_seluruh_agustus); ?></strong> </td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_seluruh_september); ?></strong> </td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_seluruh_oktober); ?></strong> </td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_seluruh_november); ?></strong> </td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_seluruh_desember); ?></strong> </td>



                                            </tr>
                                        </tbody>
                                    </table>

                                <?php } else { ?>

                                    <h5 align="center" style='font-size: clamp(12px, 1vw, 18px); color: black;'>REKAP Pengeluaran <?= $akun_kas ?> Non PSO</h5>
                                    <!-- Tabel -->
                                    <table class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
                                        <thead>
                                            <tr>
                                                <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Akun</th>
                                                <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total Januari </th>
                                                <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total Februari </th>
                                                <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total Maret </th>
                                                <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total April </th>
                                                <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total Mei </th>
                                                <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total Juni </th>
                                                <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total Juli </th>
                                                <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total Agustus </th>
                                                <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total September </th>
                                                <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total Oktober </th>
                                                <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total November </th>
                                                <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total Desember </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $total_seluruh_januari = 0;
                                            $total_seluruh_februari = 0;
                                            $total_seluruh_maret = 0;
                                            $total_seluruh_april = 0;
                                            $total_seluruh_mei = 0;
                                            $total_seluruh_juni = 0;
                                            $total_seluruh_juli = 0;
                                            $total_seluruh_agustus = 0;
                                            $total_seluruh_september = 0;
                                            $total_seluruh_oktober = 0;
                                            $total_seluruh_november = 0;
                                            $total_seluruh_desember = 0;
                                            ?>
                                            <?php


                                            //januari
                                            $sql_januari = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_jumlah_januari FROM kas_kecil WHERE tanggal BETWEEN '$januari_awal' AND '$januari_akhir' AND akun_kas = '$akun_kas' ");
                                            $data_januari = mysqli_fetch_array($sql_januari);
                                            if (!isset($data_januari['total_jumlah_januari'])) {
                                                $total_jumlah_januari = 0;
                                            } else {

                                                $total_jumlah_januari = $data_januari['total_jumlah_januari'];
                                                $total_seluruh_januari = $total_seluruh_januari + $total_jumlah_januari;
                                            }

                                            //februari
                                            $sql_februari = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_jumlah_februari FROM kas_kecil WHERE tanggal BETWEEN '$februari_awal' AND '$februari_akhir' AND akun_kas = '$akun_kas' ");
                                            $data_februari = mysqli_fetch_array($sql_februari);
                                            if (!isset($data_februari['total_jumlah_februari'])) {
                                                $total_jumlah_februari = 0;
                                            } else {

                                                $total_jumlah_februari = $data_februari['total_jumlah_februari'];
                                                $total_seluruh_februari = $total_seluruh_februari + $total_jumlah_februari;
                                            }

                                            //maret
                                            $sql_maret = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_jumlah_maret FROM kas_kecil WHERE tanggal BETWEEN '$maret_awal' AND '$maret_akhir' AND akun_kas = '$akun_kas' ");
                                            $data_maret = mysqli_fetch_array($sql_maret);
                                            if (!isset($data_maret['total_jumlah_maret'])) {
                                                $total_jumlah_maret = 0;
                                            } else {

                                                $total_jumlah_maret = $data_maret['total_jumlah_maret'];
                                                $total_seluruh_maret = $total_seluruh_maret + $total_jumlah_maret;
                                            }

                                            //april
                                            $sql_april = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_jumlah_april FROM kas_kecil WHERE tanggal BETWEEN '$april_awal' AND '$april_akhir' AND akun_kas = '$akun_kas' ");
                                            $data_april = mysqli_fetch_array($sql_april);
                                            if (!isset($data_april['total_jumlah_april'])) {
                                                $total_jumlah_april = 0;
                                            } else {

                                                $total_jumlah_april = $data_april['total_jumlah_april'];
                                                $total_seluruh_april = $total_seluruh_april + $total_jumlah_april;
                                            }

                                            //mei
                                            $sql_mei = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_jumlah_mei FROM kas_kecil WHERE tanggal BETWEEN '$mei_awal' AND '$mei_akhir' AND akun_kas = '$akun_kas' ");
                                            $data_mei = mysqli_fetch_array($sql_mei);
                                            if (!isset($data_mei['total_jumlah_mei'])) {
                                                $total_jumlah_mei = 0;
                                            } else {

                                                $total_jumlah_mei = $data_mei['total_jumlah_mei'];
                                                $total_seluruh_mei = $total_seluruh_mei + $total_jumlah_mei;
                                            }

                                            //juni
                                            $sql_juni = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_jumlah_juni FROM kas_kecil WHERE tanggal BETWEEN '$juni_awal' AND '$juni_akhir' AND akun_kas = '$akun_kas' ");
                                            $data_juni = mysqli_fetch_array($sql_juni);
                                            if (!isset($data_juni['total_jumlah_juni'])) {
                                                $total_jumlah_juni = 0;
                                            } else {

                                                $total_jumlah_juni = $data_juni['total_jumlah_juni'];
                                                $total_seluruh_juni = $total_seluruh_juni + $total_jumlah_juni;
                                            }

                                            //juni
                                            $sql_juli = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_jumlah_juli FROM kas_kecil WHERE tanggal BETWEEN '$juli_awal' AND '$juli_akhir' AND akun_kas = '$akun_kas' ");
                                            $data_juli = mysqli_fetch_array($sql_juli);
                                            if (!isset($data_juli['total_jumlah_juli'])) {
                                                $total_jumlah_juli = 0;
                                            } else {

                                                $total_jumlah_juli = $data_juli['total_jumlah_juli'];
                                                $total_seluruh_juli = $total_seluruh_juli + $total_jumlah_juli;
                                            }

                                            //agustus
                                            $sql_agustus = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_jumlah_agustus FROM kas_kecil WHERE tanggal BETWEEN '$agustus_awal' AND '$agustus_akhir' AND akun_kas = '$akun_kas' ");
                                            $data_agustus = mysqli_fetch_array($sql_agustus);
                                            if (!isset($data_agustus['total_jumlah_agustus'])) {
                                                $total_jumlah_agustus = 0;
                                            } else {

                                                $total_jumlah_agustus = $data_agustus['total_jumlah_agustus'];
                                                $total_seluruh_agustus = $total_seluruh_agustus + $total_jumlah_agustus;
                                            }

                                            //september
                                            $sql_september = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_jumlah_september FROM kas_kecil WHERE tanggal BETWEEN '$september_awal' AND '$september_akhir' AND akun_kas = '$akun_kas' ");
                                            $data_september = mysqli_fetch_array($sql_september);
                                            if (!isset($data_september['total_jumlah_september'])) {
                                                $total_jumlah_september = 0;
                                            } else {

                                                $total_jumlah_september = $data_september['total_jumlah_september'];
                                                $total_seluruh_september = $total_seluruh_september + $total_jumlah_september;
                                            }

                                            //oktober
                                            $sql_oktober = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_jumlah_oktober FROM kas_kecil WHERE tanggal BETWEEN '$oktober_awal' AND '$oktober_akhir' AND akun_kas = '$akun_kas' ");
                                            $data_oktober = mysqli_fetch_array($sql_oktober);
                                            if (!isset($data_oktober['total_jumlah_oktober'])) {
                                                $total_jumlah_oktober = 0;
                                            } else {

                                                $total_jumlah_oktober = $data_oktober['total_jumlah_oktober'];
                                                $total_seluruh_oktober = $total_seluruh_oktober + $total_jumlah_oktober;
                                            }

                                            //november
                                            $sql_november = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_jumlah_november FROM kas_kecil WHERE tanggal BETWEEN '$november_awal' AND '$november_akhir' AND akun_kas = '$akun_kas' ");
                                            $data_november = mysqli_fetch_array($sql_november);
                                            if (!isset($data_november['total_jumlah_november'])) {
                                                $total_jumlah_november = 0;
                                            } else {

                                                $total_jumlah_november = $data_november['total_jumlah_november'];
                                                $total_seluruh_november = $total_seluruh_november + $total_jumlah_november;
                                            }

                                            //desember
                                            $sql_desember = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_jumlah_desember FROM kas_kecil WHERE tanggal BETWEEN '$desember_awal' AND '$desember_akhir' AND akun_kas = '$akun_kas' ");
                                            $data_desember = mysqli_fetch_array($sql_desember);
                                            if (!isset($data_desember['total_jumlah_desember'])) {
                                                $total_jumlah_desember = 0;
                                            } else {

                                                $total_jumlah_desember = $data_desember['total_jumlah_desember'];
                                                $total_seluruh_desember = $total_seluruh_desember + $total_jumlah_desember;
                                            }

                                            echo "<tr>
                                                <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>" ?> <?= $akun_kas ?> <?php echo "</td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>" ?> <?= formatuang($total_jumlah_januari); ?> <?php echo "</td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>" ?> <?= formatuang($total_jumlah_februari); ?> <?php echo "</td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>" ?> <?= formatuang($total_jumlah_maret); ?> <?php echo "</td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>" ?> <?= formatuang($total_jumlah_april); ?> <?php echo "</td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>" ?> <?= formatuang($total_jumlah_mei); ?> <?php echo "</td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>" ?> <?= formatuang($total_jumlah_juni); ?> <?php echo "</td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>" ?> <?= formatuang($total_jumlah_juli); ?> <?php echo "</td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>" ?> <?= formatuang($total_jumlah_agustus); ?> <?php echo "</td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>" ?> <?= formatuang($total_jumlah_september); ?> <?php echo "</td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>" ?> <?= formatuang($total_jumlah_oktober); ?> <?php echo "</td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>" ?> <?= formatuang($total_jumlah_november); ?> <?php echo "</td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>" ?> <?= formatuang($total_jumlah_desember); ?> <?php echo "</td>
                                            
                                             </tr>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'><strong>TOTAL</strong></td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_seluruh_januari); ?></strong> </td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_seluruh_februari); ?></strong> </td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_seluruh_maret); ?></strong> </td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_seluruh_april); ?></strong> </td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_seluruh_mei); ?></strong> </td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_seluruh_juni); ?></strong> </td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_seluruh_juli); ?></strong> </td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_seluruh_agustus); ?></strong> </td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_seluruh_september); ?></strong> </td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_seluruh_oktober); ?></strong> </td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_seluruh_november); ?></strong> </td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_seluruh_desember); ?></strong> </td>
 
 
 
                                             </tr>";
                                                                                                                                                        }
                                                                                                                                                            ?>




                                        </tr>
                                        </tbody>
                                    </table>


                                    <?php


                                    ?>



                                    <br>
                                    <hr>
                                    <br>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>


            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Balcom Solution 2023</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Mau Keluar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Klik Ya jika ingin keluar.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Tidak</button>
                    <a class="btn btn-primary" href="/index">Ya</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="/vendor_sb/jquery/jquery.min.js"></script>
    <script src="/vendor_sb/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/vendor_sb/bootstrap/js/bootstrap.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="/vendor_sb/jquery-easing/jquery.easing.min.js"></script>
    <script src="/bootstrap-select/dist/js/bootstrap-select.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="/js/sb-admin-2.min.js"></script>
    <script src="/js/jquery.dataTables.min.js"></script>
    <script src="/js/dataTables.bootstrap4.min.js"></script>
    <script src="/js/dataTables.buttons.min.js"></script>
    <script src="/js/buttons.bootstrap4.min.js"></script>
    <script src="/js/jszip.min.js"></script>
    <script src="/js/buttons.html5.min.js"></script>
    <!-- Fontawasome-->
    <script src="/js/6bcb3870ca.js" crossorigin="anonymous"></script>




    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable({
                lengthChange: false,
                buttons: ['excel']
            });

            table.buttons().container()
                .appendTo('#example_wrapper .col-md-6:eq(0)');
        });
    </script>

    <script>
        function createOptions(number) {
            var options = [],
                _options;

            for (var i = 0; i < number; i++) {
                var option = '<option value="' + i + '">Option ' + i + '</option>';
                options.push(option);
            }

            _options = options.join('');

            $('#number')[0].innerHTML = _options;
            $('#number-multiple')[0].innerHTML = _options;

            $('#number2')[0].innerHTML = _options;
            $('#number2-multiple')[0].innerHTML = _options;
        }

        var mySelect = $('#first-disabled2');

        createOptions(4000);

        $('#special').on('click', function() {
            mySelect.find('option:selected').prop('disabled', true);
            mySelect.selectpicker('refresh');
        });

        $('#special2').on('click', function() {
            mySelect.find('option:disabled').prop('disabled', false);
            mySelect.selectpicker('refresh');
        });

        $('#basic2').selectpicker({
            liveSearch: true,
            maxOptions: 1
        });
    </script>


</body>

</html>