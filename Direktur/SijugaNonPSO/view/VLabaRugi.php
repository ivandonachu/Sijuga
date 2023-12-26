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
if (isset($_GET['tanggal1'])) {
    $tanggal_awal = $_GET['tanggal1'];
    $tanggal_akhir = $_GET['tanggal2'];
} elseif (isset($_POST['tanggal1'])) {
    $tanggal_awal = $_POST['tanggal1'];
    $tanggal_akhir = $_POST['tanggal2'];
} else {
    $tanggal_awal = date('Y-m-1');
    $tanggal_akhir = date('Y-m-31');
}

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


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Laba Rugi Non PSO</title>

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
                <div class="sidebar-brand-text mx-3">PT SURYA KHARISMA HARTIWI</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="DsSijugaNonPSO">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span style="font-size: 17px;">Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Menu List Pt -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwox" aria-expanded="true" aria-controls="collapseTwox">
                    <i class="fa-solid fa-building"></i>
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
                        <a class="collapse-item" href="VListPiutang">List Piutang</a>
                        <a class="collapse-item" href="VRiwayatPiutang">Riwayat Piutang</a>
                        <a class="collapse-item" href="VLaporanSetoran">Laporan Setoran</a>
                        <a class="collapse-item" href="VLaporanInventory">Laporan Inventory</a>
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

            <!-- Divider -->
            <hr class="sidebar-divider">


            <!-- Nav Item - Menu Pengaturan Akun -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Pengaturan Akun</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="VListAkun">List Akun</a>
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
                    <small class="m-0 font-weight-thin text-primary"><a href="DsSijugaNonPSO">Dashboard</a> <i style="color: grey;" class="fa fa-caret-right" aria-hidden="true"></i> <a style="color: grey;">Laba Rugi Non PSO</a> </small>
                    <br>
                    <br>

                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h5 style="color: grey;">Laba Rugi Non PSO</h5>
                        </div>
                        <!-- Card Body -->
                        <div style="height: 1550px;" class="card-body">
                            <div class="chart-area">

                                <!-- Form Tanggal Akses Data -->
                                <?php echo "<form  method='POST' action='VLabaRugi' style='margin-bottom: 15px;'>" ?>
                                <div>
                                    <div align="left" style="margin-left: 20px;">
                                        <input type="date" id="tanggal1" style="font-size: 14px" name="tanggal1">
                                        <span>-</span>
                                        <input type="date" id="tanggal2" style="font-size: 14px" name="tanggal2">
                                        <button type="submit" name="submmit" style="font-size: 12px; margin-left: 10px; margin-bottom: 2px;" class="btn1 btn btn-outline-primary btn-sm">Lihat</button>
                                    </div>
                                </div>
                                </form>

                                <div class="row">
                                    <div class="col-md-6">
                                        <?php echo " <a style='font-size: 12px'> Data yang tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
                                    </div>
                                    <div class="col-md-6">
                                        <div align="right">

                                            <?php echo "<a href='VCetakLabaRugi?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir' target='_blank'><button style='color:white;
                                          '  type='submit' class=' btn btn-secondary' >  <i class='fa-solid fa-print'></i> Cetak Laba Rugi</button></a>"; ?>
                                        </div>
                                    </div>


                                </div>
                                <br>


                                <table class="table table-condensed" style="color : black;">
                                    <thead>
                                        <tr>
                                            <td><strong>Akun</strong></td>
                                            <td class="text-left"><strong>Nama Akun</strong></td>
                                            <td class="text-left"><strong>Debit</strong></td>
                                            <td class="text-left"><strong>Kredit</strong></td>
                                            <td class="text-right"><strong>Aksi</strong></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                        <tr>
                                            <td><strong>4-000</strong></td>
                                            <td class="text-left"><strong>PENDAPATAN</strong></td>
                                            <td class="text-left"></td>
                                            <td class="text-left"></td>
                                            <?php echo "<td class='text-right'></td>"; ?>
                                        </tr>
                                        <tr>
                                            <td>4-110</td>
                                            <td class="text-left">Penjualan Refill</td>
                                            <td class="text-left"><?= formatuang($total_penjualan_refill); ?></td>
                                            <td class="text-left"><?= formatuang(0); ?></td>
                                            <?php echo "<td class='text-right'><a href='VRincianLR/VRPenjualanRefill?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                        </tr>

                                        <tr>
                                            <td>4-120</td>
                                            <td class="text-left">Penjualan Tabung Isi</td>
                                            <td class="text-left"><?= formatuang($total_penjualan_tabung_isi); ?></td>
                                            <td class="text-left"><?= formatuang(0); ?></td>
                                            <?php echo "<td class='text-right'><a href='VRincianLR/VRPenjualanTabungISi?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                        </tr>
                                        <tr>
                                            <td>4-130</td>
                                            <td class="text-left">Penjualan Tabung Kosong</td>
                                            <td class="text-left"><?= formatuang($total_penjualan_tabung_kosong); ?></td>
                                            <td class="text-left"><?= formatuang(0); ?></td>
                                            <?php echo "<td class='text-right'><a href='VRincianLR/VRPenjualanTabungKosong?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                        </tr>
                                        <tr>
                                            <td>4-140</td>
                                            <td class="text-left">Transport Fee</td>
                                            <td class="text-left"><?= formatuang($total_transport_fee); ?></td>
                                            <td class="text-left"><?= formatuang(0); ?></td>
                                            <?php echo "<td class='text-right'><a href='VRincianLR/VRTransportFee?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                        </tr>
                                        <tr style="background-color:     #F0F8FF; ">
                                            <td><strong>Total Pendapatan</strong></td>
                                            <td class="thick-line"></td>
                                            <td class="no-line text-left"><?= formatuang($total_pendapatan); ?></td>
                                            <td class="no-line text-left"><?= formatuang(0); ?></td>
                                            <td class="thick-line"></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td class="thick-line"></td>
                                            <td class="no-line text-left"></td>
                                            <td class="no-line text-left"></td>
                                            <td class="thick-line"></td>
                                        </tr>
                                        <tr>
                                            <td><strong>5-000</strong></td>
                                            <td class="text-left"><strong>HARGA POKOK PENJUALAN</strong></td>
                                            <td class="text-left"></td>
                                            <td class="text-left"></td>
                                            <?php echo "<td class='text-right'></td>"; ?>
                                        </tr>
                                        <tr>
                                            <td>5-110</td>
                                            <td class="text-left">Pembelian Refill</td>
                                            <td class="text-left"><?= formatuang(0); ?></td>
                                            <td class="text-left"><?= formatuang($total_pembelian_refill); ?></td>
                                            <?php echo "<td class='text-right'><a href='VRincianLR/VRPembelianRefill?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                        </tr>
                                        <tr>
                                            <td>5-120</td>
                                            <td class="text-left">Pembelian Tabung Isi</td>
                                            <td class="text-left"><?= formatuang(0); ?></td>
                                            <td class="text-left"><?= formatuang($total_pembelian_tabung_isi); ?></td>
                                            <?php echo "<td class='text-right'><a href='VRincianLR/VRPembelianTabungIsi?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                        </tr>
                                        <tr>
                                            <td>5-130</td>
                                            <td class="text-left">Pembelian Tabung Kosong</td>
                                            <td class="text-left"><?= formatuang(0); ?></td>
                                            <td class="text-left"><?= formatuang($total_pembelian_tabung_kosong); ?></td>
                                            <?php echo "<td class='text-right'><a href='VRincianLR/VRPembelianTabungKosong?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                        </tr>
                                        <tr style="background-color:    #F0F8FF;  ">
                                            <td><strong>Total Harga Pokok Penjualan</strong></td>
                                            <td class="thick-line"></td>
                                            <td class="text-left"><?= formatuang(0); ?></td>
                                            <td class="text-left"><?= formatuang($total_harga_pokok_penjualan); ?></td>
                                            <td class="thick-line"></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td class="thick-line"></td>
                                            <td class="no-line text-left"></td>
                                            <td class="no-line text-left"></td>
                                            <td class="thick-line"></td>
                                        </tr>
                                        <tr style="background-color: navy;  color:white;">
                                            <td><strong>LABA KOTOR</strong></td>
                                            <td class="thick-line"></td>
                                            <?php

                                            if ($laba_kotor > 0) { ?>

                                                <td class="no-line text-left"><?= formatuang($laba_kotor); ?> </td>
                                                <td class="no-line text-left"><?= formatuang(0); ?> </td>
                                            <?php } else if ($laba_kotor < 0) { ?>

                                                <td class="no-line text-left"><?= formatuang(0); ?></td>
                                                <td class="no-line text-left"><?= formatuang($laba_kotor); ?></td>
                                            <?php } else if ($laba_kotor == 0) { ?>

                                                <td class="no-line text-left"><?= formatuang(0); ?></td>
                                                <td class="no-line text-left"><?= formatuang(0); ?></td>
                                            <?php }
                                            ?>


                                            <td class="thick-line"></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td class="thick-line"></td>
                                            <td class="no-line text-left"></td>
                                            <td class="no-line text-left"></td>
                                            <td class="thick-line"></td>
                                        </tr>
                                        <tr>
                                            <td><strong>5-500</strong></td>
                                            <td class="text-left"><strong>BIAYA USAHA</strong></td>
                                            <td class="text-left"></td>
                                            <td class="text-left"></td>
                                            <?php echo "<td class='text-right'></td>"; ?>
                                        </tr>
                                        <tr>
                                            <td>5-510</td>
                                            <td class="text-left">Gaji Karyawan</td>
                                            <td class="text-left"><?= formatuang(0); ?></td>
                                            <td class="text-left"><?= formatuang($total_gaji_karyawan); ?></td>
                                            <?php echo "<td class='text-right'><a href='VRincianLR/VRGajiKaryawan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                        </tr>
                                        <tr>
                                            <td>5-511</td>
                                            <td class="text-left">Gaji Driver</td>
                                            <td class="text-left"><?= formatuang(0); ?></td>
                                            <td class="text-left"><?= formatuang($total_gaji_driver); ?></td>
                                            <?php echo "<td class='text-right'><a href='VRincianLR/VRGajiDriver?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                        </tr>
                                        <tr>
                                            <td>5-520</td>
                                            <td class="text-left">Alat Tulis Kantor</td>
                                            <td class="text-left"><?= formatuang(0); ?></td>
                                            <td class="text-left"><?= formatuang($total_atk); ?></td>
                                            <?php echo "<td class='text-right'><a href='VRincianLR/VRATK?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                        </tr>
                                        <tr>
                                            <td>5-530</td>
                                            <td class="text-left">Biaya Administrasi</td>
                                            <td class="text-left"><?= formatuang(0); ?></td>
                                            <td class="text-left"><?= formatuang($total_biaya_administrasi); ?></td>
                                            <?php echo "<td class='text-right'><a href='VRincianLR/VRBiayaAdministrasi?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                        </tr>
                                        <tr>
                                            <td>5-540</td>
                                            <td class="text-left">Biaya Kantor</td>
                                            <td class="text-left"><?= formatuang(0); ?></td>
                                            <td class="text-left"><?= formatuang($total_biaya_kantor); ?></td>
                                            <?php echo "<td class='text-right'><a href='VRincianLR/VRBiayaKantor?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                        </tr>
                                        <tr>
                                            <td>5-550</td>
                                            <td class="text-left">Biaya Konsumsi</td>
                                            <td class="text-left"><?= formatuang(0); ?></td>
                                            <td class="text-left"><?= formatuang($total_biaya_konsumsi); ?></td>
                                            <?php echo "<td class='text-right'><a href='VRincianLR/VRBiayaKonsumsi?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                        </tr>
                                        <tr>
                                            <td>5-560</td>
                                            <td class="text-left">Biaya Penjualan & Pemasaran</td>
                                            <td class="text-left"><?= formatuang(0); ?></td>
                                            <td class="text-left"><?= formatuang($total_biaya_pemasaran); ?></td>
                                            <?php echo "<td class='text-right'><a href='VRincianLR/VRBiayaPemasaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                        </tr>
                                        <tr>
                                            <td>5-570</td>
                                            <td class="text-left">Biaya Perbaikan Kendaraan</td>
                                            <td class="text-left"><?= formatuang(0); ?></td>
                                            <td class="text-left"><?= formatuang($total_biaya_perbaikan); ?></td>
                                            <?php echo "<td class='text-right'><a href='VRincianLR/VRBiayaPerbaikan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                        </tr>
                                        <tr>
                                            <td>5-580</td>
                                            <td class="text-left">Listrik & Telepon</td>
                                            <td class="text-left"><?= formatuang(0); ?></td>
                                            <td class="text-left"><?= formatuang($total_listrik); ?></td>
                                            <?php echo "<td class='text-right'><a href='VRincianLR/VRListrik?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                        </tr>
                                        <tr>
                                            <td>5-590</td>
                                            <td class="text-left">Transport / Perjalanan Dinas</td>
                                            <td class="text-left"><?= formatuang(0); ?></td>
                                            <td class="text-left"><?= formatuang($total_transport); ?></td>
                                            <?php echo "<td class='text-right'><a href='VRincianLR/VRTransport?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                        </tr>
                                        <tr style="background-color:    #F0F8FF; ">
                                            <td><strong>Total Biaya Usaha</strong></td>
                                            <td class="thick-line"></td>
                                            <td class="text-left"><?= formatuang(0); ?></td>
                                            <td class="text-left"><?= formatuang($total_biaya_usaha_final); ?></td>
                                            <td class="thick-line"></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td class="thick-line"></td>
                                            <td class="no-line text-left"></td>
                                            <td class="no-line text-left"></td>
                                            <td class="thick-line"></td>
                                        </tr>
                                        <tr style="background-color: navy;  color:white;">
                                            <td><strong>LABA BERSIH SEBELUM PAJAK</strong></td>
                                            <td class="thick-line"></td>
                                            <?php

                                            if ($laba_bersih_sebelum_pajak > 0) { ?>

                                                <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak); ?> </td>
                                                <td class="no-line text-left"><?= formatuang(0); ?> </td>
                                            <?php } else if ($laba_bersih_sebelum_pajak < 0) { ?>

                                                <td class="no-line text-left"><?= formatuang(0); ?></td>
                                                <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak); ?></td>

                                            <?php } else if ($laba_bersih_sebelum_pajak == 0) { ?>

                                                <td class="no-line text-left"><?= formatuang(0); ?></td>
                                                <td class="no-line text-left"><?= formatuang(0); ?></td>
                                            <?php }
                                            ?>
                                            <td class="thick-line"></td>
                                        </tr>
                                    </tbody>
                                </table>
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