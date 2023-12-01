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
$nama = $data1['nama'];
$foto_profile = $data1['foto_profile'];
$username = $data1['username'];
if ($jabatan_valid == 'Admin Non PSO') {
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

if ($tanggal_awal == $tanggal_akhir) {
    $table = mysqli_query($koneksi, "SELECT * FROM penjualan a INNER JOIN customer b ON b.kode_customer=a.kode_customer WHERE tanggal = '$tanggal_awal'");
} else {

    $table = mysqli_query($koneksi, "SELECT * FROM penjualan a INNER JOIN customer b ON b.kode_customer=a.kode_customer WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");

    //piutang
    $sql_piutang = mysqli_query($koneksi, "SELECT SUM(jumlah_bayar) AS total_bayar_piutang FROM riwayat_piutang WHERE tanggal_bayar BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND pembayaran_piutang = 'Cash' ");
    $data_piutang = mysqli_fetch_array($sql_piutang);
    $total_pembayaran_piutang = $data_piutang['total_bayar_piutang'];

    //pengeluaran
    $sql_pengeluaran = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pengeluaran FROM kas_kecil WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  ");
    $data_pengeluaran = mysqli_fetch_array($sql_pengeluaran);
    $total_pengeluaran = $data_pengeluaran['total_pengeluaran'];

    //setoran total
    $sql_setoran = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_setoran FROM setoran WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  ");
    $data_setoran = mysqli_fetch_array($sql_setoran);
    if (!isset($data_setoran['total_setoran'])) {
        $total_setoran = 0;
    } else {
    
        $total_setoran = $data_setoran['total_setoran'];
    }

    //setoran total cash
    $sql_setoran_cash = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_setoran_cash FROM setoran WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND jenis_setoran = 'Cash'  ");
    $data_setoran_cash = mysqli_fetch_array($sql_setoran_cash);
    if (!isset($data_setoran_cash['total_setoran_cash'])) {
        $total_setoran_cash = 0;
    } else {
    
        $total_setoran_cash = $data_setoran_cash['total_setoran_cash'];
    }

    //setoran total cashles
    $sql_setoran_cashles = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_setoran_cashless FROM setoran WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND jenis_setoran = 'Cashless'  ");
    $data_setoran_cashles = mysqli_fetch_array($sql_setoran_cashles);
    if (!isset($data_setoran_cashles['total_setoran_cashless'])) {
        $total_setoran_cashless = 0;
    } else {
    
        $total_setoran_cashless = $data_setoran_cashles['total_setoran_cashless'];
    }
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

    <title>Penjualan</title>

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
                <div class="sidebar-brand-text mx-3" style="font-size: 14px">PT SURYA KHARISMA HARTIWI</div>
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
                    <small class="m-0 font-weight-thin text-primary"><a href="DsAdmin">Dashboard</a> <i style="color: grey;" class="fa fa-caret-right" aria-hidden="true"></i> <a style="color: grey;">Penjualan</a> </small>
                    <br>
                    <br>

                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h5 style="color: grey;">Penjualan</h5>
                        </div>
                        <!-- Card Body -->
                        <div style="height: 1980px;" class="card-body">
                            <div class="chart-area">

                                <!-- Form Tanggal Akses Data -->
                                <?php echo "<form  method='POST' action='VPenjualan' style='margin-bottom: 15px;'>" ?>
                                <div>
                                    <div align="left" style="margin-left: 20px;">
                                        <input type="date" id="tanggal1" style="font-size: 12px" name="tanggal1">
                                        <span>-</span>
                                        <input type="date" id="tanggal2" style="font-size: 12px" name="tanggal2">
                                        <button type="submit" name="submmit" style="font-size: 12px; margin-left: 10px; margin-bottom: 2px;" class="btn1 btn btn-outline-primary btn-sm">Lihat</button>
                                    </div>
                                </div>
                                </form>

                                <!-- Form Input -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <?php echo " <a style='font-size: 12px'> Data yang tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- Button Input Data Bayar -->
                                        <div align="right">
                                            <button style="font-size: clamp(7px, 3vw, 15px); " type="button" class="btn btn-primary" data-toggle="modal" data-target="#input"> <i class="fas fa-plus-square mr-2"></i>Catat Penjualan</button> <br> <br>
                                        </div>
                                        <!-- Form Modal  -->
                                        <div class="modal fade bd-example-modal-lg" id="input" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"> Form Penjualan</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <!-- Form Input Data -->
                                                    <div class="modal-body" align="left">
                                                        <?php echo "<form action='../proses/IPenjualan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir' enctype='multipart/form-data' method='POST'>";  ?>

                                                        <br>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Tanggal</label>
                                                                <input class="form-control " type="date" name="tanggal" required="">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Nama Akun</label>
                                                                <select name="nama_akun" class="form-control" required="">
                                                                    <option>Penjualan Refill</option>
                                                                    <option>Penjualan Tabung Isi</option>
                                                                    <option>Penjualan Tabung Kosong</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <br>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Nama Customer</label>
                                                                <select id="tokens" class="selectpicker form-control" name="nama_customer" multiple data-live-search="true">
                                                                    <?php
                                                                    include 'koneksi.php';

                                                                    $result = mysqli_query($koneksi, "SELECT nama_customer FROM customer");

                                                                    while ($data2 = mysqli_fetch_array($result)) {
                                                                        $nama_customer = $data2['nama_customer'];

                                                                        echo "<option> $nama_customer </option> ";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Pembayaran</label>
                                                                <select name="pembayaran" class="form-control" required="">
                                                                    <option>Cash</option>
                                                                    <option>Cashless</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <br>

                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label>QTY 5,5 Kg</label>
                                                                <input class="form-control form-control-sm" type="text" name="qty_55kg" value="0" required="">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>QTY 12 Kg</label>
                                                                <input class="form-control form-control-sm" type="text" name="qty_12kg" value="0" required="">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>QTY 50 Kg</label>
                                                                <input class="form-control form-control-sm" type="text" name="qty_50kg" value="0" required="">
                                                            </div>
                                                        </div>

                                                        <br>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Status Penjualan</label>
                                                                <select name="status_penjualan" class="form-control" required="">
                                                                    <option>Lunas</option>
                                                                    <option>Piutang</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Keterangan</label>
                                                                <textarea class="form-control form-control-sm" name="keterangan"></textarea>
                                                            </div>
                                                        </div>

                                                        <br>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Upload File</label>
                                                                <input type="file" name="file">
                                                            </div>
                                                        </div>

                                                        <br>

                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">INPUT</button>
                                                            <button type="reset" class="btn btn-danger"> RESET</button>
                                                        </div>
                                                        </form>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tabel -->
                                <div style="overflow-x: auto" ;>
                                    <table align="center" id="example" class="table-sm table-striped table-bordered  nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">No</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Tanggal</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Nama Akun</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Nama Customer</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Pembayaran</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">QTY 5,5 Kg</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Harga 5,5 Kg</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">jumlah 5,5 Kg</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">QTY 12 Kg</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Harga 12 Kg</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">jumlah 12 Kg</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">QTY 50 Kg</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Harga 50 Kg</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">jumlah 50 Kg</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Jumlah</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Status Penjualan</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Keterangan</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">File</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $no_urut = 0;
                                            $total_penjualan_cashless = 0;
                                            $total_penjualan_cash = 0;
                                            $total_penjualan_55kg_cashless = 0;
                                            $total_penjualan_55kg_cash = 0;
                                            $total_penjualan_12kg_cashless = 0;
                                            $total_penjualan_12kg_cash = 0;
                                            $total_penjualan_50kg_cashless = 0;
                                            $total_penjualan_50kg_cash = 0;
                                            $total_penjualan_lunas = 0;
                                            $total_penjualan_piutang = 0;
                                            $total_penjualan_12kg_piutang = 0;
                                            $total_penjualan_55kg_piutang = 0;
                                            $total_penjualan_50kg_piutang = 0;
                                            $total_seluruh_penjualan = 0;
                                            function formatuang($angka)
                                            {
                                                $uang = "Rp " . number_format($angka, 2, ',', '.');
                                                return $uang;
                                            }

                                            while ($data = mysqli_fetch_array($table)) {
                                                $no_penjualan = $data['no_penjualan'];
                                                $tanggal = $data['tanggal'];
                                                $nama_akun = $data['nama_akun'];
                                                $nama_customer = $data['nama_customer'];
                                                $pembayaran = $data['pembayaran'];
                                                $qty_55kg = $data['qty_55kg'];
                                                $harga_55kg = $data['harga_55kg'];
                                                $jumlah_55kg = $data['jumlah_55kg'];
                                                $qty_12kg = $data['qty_12kg'];
                                                $harga_12kg = $data['harga_12kg'];
                                                $jumlah_12kg = $data['jumlah_12kg'];
                                                $qty_50kg = $data['qty_50kg'];
                                                $harga_50kg = $data['harga_50kg'];
                                                $jumlah_50kg = $data['jumlah_50kg'];
                                                $jumlah = $data['jumlah'];
                                                $status_penjualan = $data['status_penjualan'];
                                                $keterangan = $data['keterangan'];
                                                $file_bukti = $data['file_bukti'];
                                                if ($status_penjualan == 'Lunas') {
                                                    if ($pembayaran == 'Cash') {
                                                        $total_penjualan_cash = $total_penjualan_cash + $jumlah;
                                                        $total_penjualan_12kg_cash = $total_penjualan_12kg_cash + $jumlah_12kg;
                                                        $total_penjualan_55kg_cash = $total_penjualan_55kg_cash + $jumlah_55kg;
                                                        $total_penjualan_50kg_cash = $total_penjualan_50kg_cash + $jumlah_50kg;
                                                    } else {
                                                        $total_penjualan_cashless = $total_penjualan_cashless + $jumlah;
                                                        $total_penjualan_12kg_cashless = $total_penjualan_12kg_cashless + $jumlah_12kg;
                                                        $total_penjualan_55kg_cashless = $total_penjualan_55kg_cashless + $jumlah_55kg;
                                                        $total_penjualan_50kg_cashless = $total_penjualan_50kg_cashless + $jumlah_50kg;
                                                    }
                                                    $total_penjualan_lunas = $total_penjualan_lunas + $jumlah;
                                                } else {
                                                    $total_penjualan_piutang = $total_penjualan_piutang + $jumlah;
                                                    $total_penjualan_12kg_piutang = $total_penjualan_12kg_piutang + $jumlah_12kg;
                                                    $total_penjualan_55kg_piutang = $total_penjualan_55kg_piutang + $jumlah_55kg;
                                                    $total_penjualan_50kg_piutang = $total_penjualan_50kg_piutang + $jumlah_50kg;
                                                }

                                                $total_seluruh_penjualan = $total_seluruh_penjualan + $jumlah;

                                                $no_urut++;

                                                //hutang
                                                if ($status_penjualan == 'Piutang') {
                                                    echo "<tr>
                                                    <td style='font-size: clamp(12px, 1vw, 12px); color: red;' >$no_urut</td>
                                                    <td style='font-size: clamp(12px, 1vw, 12px); color: red;' >$tanggal</td>
                                                    <td style='font-size: clamp(12px, 1vw, 12px); color: red;' >$nama_akun</td>
                                                    <td style='font-size: clamp(12px, 1vw, 12px); color: red;' >$nama_customer</td>
                                                    <td style='font-size: clamp(12px, 1vw, 12px); color: red;' >$pembayaran</td>
                                                    <td style='font-size: clamp(12px, 1vw, 12px); color: red;' >$qty_55kg</td>";
                                                    if ($qty_55kg == 0) {
                                                        echo "<td style='font-size: clamp(12px, 1vw, 12px); color: red;' >"; ?> <?= formatuang(0); ?> <?php echo "</td>";
                                                                                                                                                    } else {
                                                                                                                                                        echo "<td style='font-size: clamp(12px, 1vw, 12px); color: red;' >"; ?> <?= formatuang($harga_55kg); ?> <?php echo "</td>";
                                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                                            echo "
                                                    <td style='font-size: clamp(12px, 1vw, 12px); color: red;' >"; ?> <?= formatuang($jumlah_55kg); ?> <?php echo "</td>
                                                    <td style='font-size: clamp(12px, 1vw, 12px); color: red;' >$qty_12kg</td>";
                                                                                                                                                        if ($qty_12kg == 0) {
                                                                                                                                                            echo "<td style='font-size: clamp(12px, 1vw, 12px); color: red;' >"; ?> <?= formatuang(0); ?> <?php echo "</td>";
                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                            echo "<td style='font-size: clamp(12px, 1vw, 12px); color: red;' >"; ?> <?= formatuang($harga_12kg); ?> <?php echo "</td>";
                                                                                                                                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                                                                                                                echo "
                                                    <td style='font-size: clamp(12px, 1vw, 12px); color: red;' >"; ?> <?= formatuang($jumlah_12kg); ?> <?php echo "</td>
                                                    <td style='font-size: clamp(12px, 1vw, 12px); color: red;' >$qty_50kg</td>";
                                                                                                                                                        if ($qty_50kg == 0) {
                                                                                                                                                            echo "<td style='font-size: clamp(12px, 1vw, 12px); color: red;' >"; ?> <?= formatuang(0); ?> <?php echo "</td>";
                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                            echo "<td style='font-size: clamp(12px, 1vw, 12px); color: red;' >"; ?> <?= formatuang($harga_50kg); ?> <?php echo "</td>";
                                                                                                                                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                                                                                                                echo "
                                                    <td style='font-size: clamp(12px, 1vw, 12px); color: red;' >"; ?> <?= formatuang($jumlah_50kg); ?> <?php echo "</td>
                                                    <td style='font-size: clamp(12px, 1vw, 12px); color: red;' >"; ?> <?= formatuang($jumlah); ?> <?php echo "</td>
                                                    <td style='font-size: clamp(12px, 1vw, 12px); color: red;' >$status_penjualan</td>
                                                    <td style='font-size: clamp(12px, 1vw, 12px); color: red;' >$keterangan</td>
                                                    <td style='font-size: clamp(12px, 1vw, 12px);'>"; ?> <a download="" href="/SijugaNonPSO/AdminNonPSO/file_admin_non_pso/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
                                                    "; ?>
                                                        <?php echo "<td style='font-size: clamp(12px, 1vw, 10px);'>"; ?>

                                                        <button style=" font-size: clamp(7px, 1vw, 10px); color:black; " href="#" type="submit" class=" btn bg-primary mr-2 rounded" data-toggle="modal" data-target="#formpelunasan<?php echo $data['no_penjualan']; ?>" data-toggle='tooltip' title='Pembayaran Piutang'>
                                                            <i class="fa-solid fa-money-bill"></i></button>
                                                        <!-- Form EDIT DATA -->

                                                        <div class="modal fade" id="formpelunasan<?php echo $data['no_penjualan']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Pembayaran Piutang </h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                                            <span aria-hidden="true"> &times; </span>
                                                                        </button>
                                                                    </div>

                                                                    <!-- Form Edit Data -->
                                                                    <div class="modal-body">
                                                                        <form action="../proses/IPembayaranPiutang" enctype="multipart/form-data" method="POST">
                                                                            <input type="hidden" name="tanggal1" value="<?= $tanggal_awal; ?>">
                                                                            <input type="hidden" name="tanggal2" value="<?= $tanggal_akhir; ?>">
                                                                            <input type="hidden" name="no_penjualan" value="<?= $no_penjualan; ?>">
                                                                            <input type="hidden" name="jumlah_bayar" value="<?= $jumlah; ?>">


                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <label>Tanggal Bayar</label>
                                                                                    <input class="form-control " type="date" name="tanggal_bayar" required="">
                                                                                </div>
                                                                            </div>

                                                                            <br>

                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <label>Pembayaran Piutang</label>
                                                                                    <select name="pembayaran_piutang" class="form-control" required="">
                                                                                        <option>Cash</option>
                                                                                        <option>Cashless</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <label>Upload File</label>
                                                                                    <input type="file" name="file">
                                                                                </div>
                                                                            </div>
                                                                            <br>

                                                                            <div class="modal-footer">
                                                                                <button type="submit" class="btn btn-primary">Konfirmasi </button>
                                                                                <button type="reset" class="btn btn-danger"> RESET</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <button style=" font-size: clamp(7px, 1vw, 10px); color:black; " href="#" type="submit" class=" btn bg-warning mr-2 rounded" data-toggle="modal" data-target="#formedit<?php echo $data['no_penjualan']; ?>" data-toggle='tooltip' title='Edit Penjualan'>
                                                            <i class="fa-regular fa-pen-to-square"></i></button>
                                                        <!-- Form EDIT DATA -->

                                                        <div class="modal fade" id="formedit<?php echo $data['no_penjualan']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"> Edit Penjualan </h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                                            <span aria-hidden="true"> &times; </span>
                                                                        </button>
                                                                    </div>

                                                                    <!-- Form Edit Data -->
                                                                    <div class="modal-body">
                                                                        <form action="../proses/EPenjualan" enctype="multipart/form-data" method="POST">

                                                                            <input type="hidden" name="no_penjualan" value="<?= $no_penjualan; ?>">
                                                                            <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
                                                                            <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir; ?>">
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <label>Tanggal</label>
                                                                                    <input class="form-control " type="date" name="tanggal" value="<?= $tanggal; ?>" required="">
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <label>Nama Akun</label>
                                                                                    <select name="nama_akun" class="form-control">
                                                                                        <?php $dataSelect = $data['nama_akun']; ?>
                                                                                        <option <?php echo ($dataSelect == 'Penjualan Refill') ? "selected" : "" ?>>Penjualan Refill</option>
                                                                                        <option <?php echo ($dataSelect == 'Penjualan Tabung Isi') ? "selected" : "" ?>>Penjualan Tabung Isi</option>
                                                                                        <option <?php echo ($dataSelect == 'Penjualan Tabung Kosong') ? "selected" : "" ?>>Penjualan Tabung Kosong</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                            <br>

                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <div>
                                                                                        <label>Nama Customer</label>
                                                                                    </div>
                                                                                    <select id="tokens" class="selectpicker form-control" name="nama_customer" multiple data-live-search="true" required="">


                                                                                        <?php
                                                                                        $dataSelect = $data['nama_customer']; ?>
                                                                                        <option <?php echo ($dataSelect == '') ? "selected" : "" ?>></option> <?php
                                                                                                                                                                $result = mysqli_query($koneksi, "SELECT nama_customer FROM customer ");
                                                                                                                                                                while ($data2 = mysqli_fetch_array($result)) {
                                                                                                                                                                    $nama_customer = $data2['nama_customer'];


                                                                                                                                                                    echo "<option" ?> <?php echo ($dataSelect == $nama_customer) ? "selected" : "" ?>> <?php echo $nama_customer; ?> <?php echo "</option>";
                                                                                                                                                                                                                                                                                    }

                                                                                                                                                                                                                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <label>Pembayaran</label>
                                                                                    <select name="pembayaran" class="form-control">
                                                                                        <?php $dataSelect = $data['pembayaran']; ?>
                                                                                        <option <?php echo ($dataSelect == 'Cashless') ? "selected" : "" ?>>Cashless</option>
                                                                                        <option <?php echo ($dataSelect == 'Cash') ? "selected" : "" ?>>Cash</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                            <br>

                                                                            <div class="row">
                                                                                <div class="col-md-4">
                                                                                    <label>QTY 5,5 Kg</label>
                                                                                    <input class="form-control form-control-sm" type="text" name="qty_55kg" value="<?= $qty_55kg; ?>" required="">
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <label>QTY 12 Kg</label>
                                                                                    <input class="form-control form-control-sm" type="text" name="qty_12kg" value="<?= $qty_12kg; ?>" required="">
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <label>QTY 50 Kg</label>
                                                                                    <input class="form-control form-control-sm" type="text" name="qty_50kg" value="<?= $qty_50kg; ?>" required="">
                                                                                </div>
                                                                            </div>

                                                                            <br>

                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <label>Status Penjualan</label>
                                                                                    <select name="status_penjualan" class="form-control">
                                                                                        <?php $dataSelect = $data['status_penjualan']; ?>
                                                                                        <option <?php echo ($dataSelect == 'Lunas') ? "selected" : "" ?>>Lunas</option>
                                                                                        <option <?php echo ($dataSelect == 'Piutang') ? "selected" : "" ?>>Piutang</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <label>Keterangan</label>
                                                                                    <textarea class="form-control form-control-sm" name="keterangan"><?= $keterangan; ?></textarea>
                                                                                </div>
                                                                            </div>

                                                                            <br>

                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <label>Upload File</label>
                                                                                    <input type="file" name="file">
                                                                                </div>
                                                                            </div>
                                                                            <br>

                                                                            <div class="modal-footer">
                                                                                <button type="submit" class="btn btn-primary"> Ubah </button>
                                                                                <button type="reset" class="btn btn-danger"> RESET</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Button Hapus -->
                                                        <button style=" font-size: clamp(7px, 1vw, 10px); color:black;" href="#" type="submit" class=" btn btn-danger" data-toggle="modal" data-target="#PopUpHapus<?php echo $data['no_penjualan']; ?>" data-toggle='tooltip' title='Hapus Penjualan'>
                                                            <i style="font-size: clamp(7px, 1vw, 10px); color: black;" class="fa-solid fa-trash"></i></button>
                                                        <div class="modal fade" id="PopUpHapus<?php echo $data['no_penjualan']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title"> <b> Hapus Penjualan </b> </h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                                            <span aria-hidden="true"> &times; </span>
                                                                        </button>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <form action="../proses/DPenjualan" method="POST">
                                                                            <input type="hidden" name="no_penjualan" value="<?php echo $no_penjualan; ?>">
                                                                            <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
                                                                            <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir; ?>">
                                                                            <div class="form-group">
                                                                                <h6> Yakin Ingin Hapus Penjualan ini ? </h6>
                                                                            </div>

                                                                            <div class="modal-footer">
                                                                                <button type="submit" class="btn btn-primary"> Hapus </button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <?php echo  " </td> </tr>";
                                                    } else {

                                                        echo "<tr>
                                                    <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$no_urut</td>
                                                    <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$tanggal</td>
                                                    <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$nama_akun</td>
                                                    <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$nama_customer</td>
                                                    <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$pembayaran</td>
                                                    <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$qty_55kg</td>";
                                                        if ($qty_55kg == 0) {
                                                            echo "<td style='font-size: clamp(12px, 1vw, 12px); color: black;' >"; ?> <?= formatuang(0); ?> <?php echo "</td>";
                                                                                                                                                        } else {
                                                                                                                                                            echo "<td style='font-size: clamp(12px, 1vw, 12px); color: black;' >"; ?> <?= formatuang($harga_55kg); ?> <?php echo "</td>";
                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                    echo "
                                                    <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >"; ?> <?= formatuang($jumlah_55kg); ?> <?php echo "</td>
                                                    <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$qty_12kg</td>";
                                                                                                                                                            if ($qty_12kg == 0) {
                                                                                                                                                                echo "<td style='font-size: clamp(12px, 1vw, 12px); color: black;' >"; ?> <?= formatuang(0); ?> <?php echo "</td>";
                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                echo "<td style='font-size: clamp(12px, 1vw, 12px); color: black;' >"; ?> <?= formatuang($harga_12kg); ?> <?php echo "</td>";
                                                                                                                                                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                                                                                                                                                        echo "
                                                    <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >"; ?> <?= formatuang($jumlah_12kg); ?> <?php echo "</td>
                                                    <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$qty_50kg</td>";
                                                                                                                                                            if ($qty_50kg == 0) {
                                                                                                                                                                echo "<td style='font-size: clamp(12px, 1vw, 12px); color: black;' >"; ?> <?= formatuang(0); ?> <?php echo "</td>";
                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                echo "<td style='font-size: clamp(12px, 1vw, 12px); color: black;' >"; ?> <?= formatuang($harga_50kg); ?> <?php echo "</td>";
                                                                                                                                                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                                                                                                                                                        echo "
                                                    <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >"; ?> <?= formatuang($jumlah_50kg); ?> <?php echo "</td>
                                                    <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >"; ?> <?= formatuang($jumlah); ?> <?php echo "</td>
                                                    <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$status_penjualan</td>
                                                    <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$keterangan</td>
                                                    <td style='font-size: clamp(12px, 1vw, 12px);'>"; ?> <a download="" href="/SijugaNonPSO/AdminNonPSO/file_admin_non_pso/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
                                                    "; ?>
                                                            <?php echo "<td style='font-size: clamp(12px, 1vw, 10px);'>"; ?>

                                                            <button style=" font-size: clamp(7px, 1vw, 10px); color:black; " href="#" type="submit" class=" btn bg-warning mr-2 rounded" data-toggle="modal" data-target="#formedit<?php echo $data['no_penjualan']; ?>" data-toggle='tooltip' title='Edit Penjualan'>
                                                                <i class="fa-regular fa-pen-to-square"></i></button>
                                                            <!-- Form EDIT DATA -->

                                                            <div class="modal fade" id="formedit<?php echo $data['no_penjualan']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"> Edit Penjualan </h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                                                <span aria-hidden="true"> &times; </span>
                                                                            </button>
                                                                        </div>

                                                                        <!-- Form Edit Data -->
                                                                        <div class="modal-body">
                                                                            <form action="../proses/EPenjualan" enctype="multipart/form-data" method="POST">

                                                                                <input type="hidden" name="no_penjualan" value="<?= $no_penjualan; ?>">
                                                                                <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
                                                                                <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir; ?>">
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <label>Tanggal</label>
                                                                                        <input class="form-control " type="date" name="tanggal" value="<?= $tanggal; ?>" required="">
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <label>Nama Akun</label>
                                                                                        <select name="nama_akun" class="form-control">
                                                                                            <?php $dataSelect = $data['nama_akun']; ?>
                                                                                            <option <?php echo ($dataSelect == 'Penjualan Refill') ? "selected" : "" ?>>Penjualan Refill</option>
                                                                                            <option <?php echo ($dataSelect == 'Penjualan Tabung Isi') ? "selected" : "" ?>>Penjualan Tabung Isi</option>
                                                                                            <option <?php echo ($dataSelect == 'Penjualan Tabung Kosong') ? "selected" : "" ?>>Penjualan Tabung Kosong</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>

                                                                                <br>

                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div>
                                                                                            <label>Nama Customer</label>
                                                                                        </div>
                                                                                        <select id="tokens" class="selectpicker form-control" name="nama_customer" multiple data-live-search="true" required="">


                                                                                            <?php
                                                                                            $dataSelect = $data['nama_customer']; ?>
                                                                                            <option <?php echo ($dataSelect == '') ? "selected" : "" ?>></option> <?php
                                                                                                                                                                    $result = mysqli_query($koneksi, "SELECT nama_customer FROM customer ");
                                                                                                                                                                    while ($data2 = mysqli_fetch_array($result)) {
                                                                                                                                                                        $nama_customer = $data2['nama_customer'];


                                                                                                                                                                        echo "<option" ?> <?php echo ($dataSelect == $nama_customer) ? "selected" : "" ?>> <?php echo $nama_customer; ?> <?php echo "</option>";
                                                                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                                                                            ?>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <label>Pembayaran</label>
                                                                                        <select name="pembayaran" class="form-control">
                                                                                            <?php $dataSelect = $data['pembayaran']; ?>
                                                                                            <option <?php echo ($dataSelect == 'Cashless') ? "selected" : "" ?>>Cashless</option>
                                                                                            <option <?php echo ($dataSelect == 'Cash') ? "selected" : "" ?>>Cash</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>

                                                                                <br>

                                                                                <div class="row">
                                                                                    <div class="col-md-4">
                                                                                        <label>QTY 5,5 Kg</label>
                                                                                        <input class="form-control form-control-sm" type="text" name="qty_55kg" value="<?= $qty_55kg; ?>" required="">
                                                                                    </div>
                                                                                    <div class="col-md-4">
                                                                                        <label>QTY 12 Kg</label>
                                                                                        <input class="form-control form-control-sm" type="text" name="qty_12kg" value="<?= $qty_12kg; ?>" required="">
                                                                                    </div>
                                                                                    <div class="col-md-4">
                                                                                        <label>QTY 50 Kg</label>
                                                                                        <input class="form-control form-control-sm" type="text" name="qty_50kg" value="<?= $qty_50kg; ?>" required="">
                                                                                    </div>
                                                                                </div>

                                                                                <br>

                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <label>Status Penjualan</label>
                                                                                        <select name="status_penjualan" class="form-control">
                                                                                            <?php $dataSelect = $data['status_penjualan']; ?>
                                                                                            <option <?php echo ($dataSelect == 'Lunas') ? "selected" : "" ?>>Lunas</option>
                                                                                            <option <?php echo ($dataSelect == 'Piutang') ? "selected" : "" ?>>Piutang</option>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <label>Keterangan</label>
                                                                                        <textarea class="form-control form-control-sm" name="keterangan"><?= $keterangan; ?></textarea>
                                                                                    </div>
                                                                                </div>

                                                                                <br>

                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <label>Upload File</label>
                                                                                        <input type="file" name="file">
                                                                                    </div>
                                                                                </div>
                                                                                <br>

                                                                                <div class="modal-footer">
                                                                                    <button type="submit" class="btn btn-primary"> Ubah </button>
                                                                                    <button type="reset" class="btn btn-danger"> RESET</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Button Hapus -->
                                                            <button style=" font-size: clamp(7px, 1vw, 10px); color:black;" href="#" type="submit" class=" btn btn-danger" data-toggle="modal" data-target="#PopUpHapus<?php echo $data['no_penjualan']; ?>" data-toggle='tooltip' title='Hapus Penjualan'>
                                                                <i style="font-size: clamp(7px, 1vw, 10px); color: black;" class="fa-solid fa-trash"></i></button>
                                                            <div class="modal fade" id="PopUpHapus<?php echo $data['no_penjualan']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title"> <b> Hapus Penjualan </b> </h4>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                                                <span aria-hidden="true"> &times; </span>
                                                                            </button>
                                                                        </div>

                                                                        <div class="modal-body">
                                                                            <form action="../proses/DPenjualan" method="POST">
                                                                                <input type="hidden" name="no_penjualan" value="<?php echo $no_penjualan; ?>">
                                                                                <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
                                                                                <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir; ?>">
                                                                                <div class="form-group">
                                                                                    <h6> Yakin Ingin Hapus Penjualan ini ? </h6>
                                                                                </div>

                                                                                <div class="modal-footer">
                                                                                    <button type="submit" class="btn btn-primary"> Hapus </button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                    <?php echo  " </td> </tr>";
                                                    }
                                                }
                                                    ?>

                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <hr>
                                <br>
                                <!-- Kotak pemasukan pengeluaran -->
                                <h5 align="center" style='font-size: clamp(12px, 1vw, 18px); color: black;'>REKAP PENJUALAN</h5>
                                <!-- Tabel -->
                                <table class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
                                    <thead>
                                        <tr>
                                            <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Nama Penjualan Piutang</th>
                                            <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total Pembayaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total Penjualan 5,5 Kg Cash </td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= formatuang($total_penjualan_55kg_cash); ?> </td>
                                        </tr>
                                        <tr>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total Penjualan 12 Kg Cash</td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= formatuang($total_penjualan_12kg_cash); ?> </td>
                                        </tr>
                                        <tr>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total Penjualan 50 Kg Cash</td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= formatuang($total_penjualan_50kg_cash); ?> </td>
                                        </tr>
                                        <tr>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total Penjualan 5,5 Kg Cashless </td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= formatuang($total_penjualan_55kg_cashless); ?> </td>
                                        </tr>
                                        <tr>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total Penjualan 12 Kg Cashles</td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= formatuang($total_penjualan_12kg_cashless); ?> </td>
                                        </tr>
                                        <tr>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total Penjualan 50 Kg Cashless</td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= formatuang($total_penjualan_50kg_cashless); ?> </td>
                                        </tr>
                                        <tr>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total Penjualan Piutang 5,5 Kg </td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= formatuang($total_penjualan_55kg_piutang); ?> </td>
                                        </tr>
                                        <tr>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total Penjualan Piutang 12 Kg </td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= formatuang($total_penjualan_12kg_piutang); ?> </td>
                                        </tr>
                                        <tr>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total Penjualan Piutang 50 Kg </td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= formatuang($total_penjualan_50kg_piutang); ?> </td>
                                        </tr>
                                        <tr>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'><strong>TOTAL SELURUH PENJUALAN CASH</strong></td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_penjualan_cash); ?></strong> </td>
                                        </tr>
                                        <tr>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'><strong>TOTAL SELURUH PENJUALAN CASHLESS</strong></td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_penjualan_cashless); ?></strong> </td>
                                        </tr>
                                        <tr>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'><strong>TOTAL SELURUH PENJUALAN PIUTANG</strong></td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_penjualan_piutang); ?></strong> </td>
                                        </tr>
                                        <tr>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'><strong>TOTAL SELURUH PENJUALAN</strong></td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_penjualan_lunas); ?></strong> </td>
                                        </tr>
                                        <tr>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'><strong>TOTAL SELURUH PENJUALAN + PIUTANG</strong></td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_seluruh_penjualan); ?></strong> </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <br>
                                <hr>
                                <br>
                                <!-- Kotak pemasukan pengeluaran -->
                                <h5 align="center" style='font-size: clamp(12px, 1vw, 18px); color: black;'>REKAP KEUANGAN CASH</h5>
                                <!-- Tabel -->
                                <table class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
                                    <thead>
                                        <tr>
                                            <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Keuangan</th>
                                            <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total Keuangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total Penjualan Cash </td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= formatuang($total_penjualan_cash); ?> </td>
                                        </tr>
                                        <tr>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total Pembayaran Piutang Cash</td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= formatuang($total_pembayaran_piutang); ?> </td>
                                        </tr>

                                        <tr>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'><strong>TOTAL CASH PENJUALAN + PIUTANG</strong></td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_penjualan_cash + $total_pembayaran_piutang); ?></strong> </td>
                                        </tr>
                                        <tr>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'><strong>TOTAL PENGELUARAN</strong></td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_pengeluaran); ?></strong> </td>
                                        </tr>
                                        <tr>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'><strong>TOTAL CASH DIKURANG PENGELUARAN</strong></td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang(($total_penjualan_cash + $total_pembayaran_piutang) - $total_pengeluaran); ?></strong> </td>
                                        </tr>
                                        <tr>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'><strong>TOTAL SETOR CASH</strong></td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_setoran_cash); ?></strong> </td>
                                        </tr>
                                        <tr>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'><strong>TOTAL SETOR CASHLESS</strong></td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_setoran_cashless); ?></strong> </td>
                                        </tr>
                                        <tr>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'><strong>TOTAL SETOR</strong></td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_setoran); ?></strong> </td>
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