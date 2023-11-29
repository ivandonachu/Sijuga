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
    $table = mysqli_query($koneksi, "SELECT * FROM kas_kecil WHERE tanggal = '$tanggal_awal'");
    $sql_saldo = mysqli_query($koneksi, "SELECT * FROM list_saldo WHERE nama_saldo = 'Saldo Non PSO'");
    $data_saldo = mysqli_fetch_array($sql_saldo);
    $jumlah_saldo = $data_saldo['jumlah_saldo'];
    $table2 = mysqli_query($koneksi, "SELECT akun_kas, SUM(jumlah) AS total_jumlah FROM kas_kecil  WHERE tanggal = '$tanggal_awal' GROUP BY kas_kecil");
    $table3 = mysqli_query($koneksi, "SELECT no_polisi, SUM(jumlah) AS total_jumlah FROM kas_kecil  WHERE tanggal = '$tanggal_awal' AND akun_kas = 'BBM' GROUP BY no_polisi");
    $table4 = mysqli_query($koneksi, "SELECT akun_kas, SUM(jumlah) AS total_jumlah FROM kas_kecil  WHERE tanggal = '$tanggal_awal' GROUP BY akun_kas");
} else {

    $table = mysqli_query($koneksi, "SELECT * FROM kas_kecil WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    $sql_saldo = mysqli_query($koneksi, "SELECT * FROM list_saldo WHERE nama_saldo = 'Saldo Non PSO'");
    $data_saldo = mysqli_fetch_array($sql_saldo);
    $jumlah_saldo = $data_saldo['jumlah_saldo'];
    $table2 = mysqli_query($koneksi, "SELECT akun_kas, SUM(jumlah) AS total_jumlah FROM kas_kecil  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  GROUP BY akun_kas");
    $table3 = mysqli_query($koneksi, "SELECT no_polisi, SUM(jumlah) AS total_jumlah FROM kas_kecil  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akun_kas = 'BBM' GROUP BY no_polisi");
    $table4 = mysqli_query($koneksi, "SELECT no_polisi, SUM(jumlah) AS total_jumlah FROM kas_kecil  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akun_kas = 'BBM' GROUP BY no_polisi");
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

    <title>Kas Kecil</title>
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
                    <small class="m-0 font-weight-thin text-primary"><a href="DsAdmin">Dashboard</a> <i style="color: grey;" class="fa fa-caret-right" aria-hidden="true"></i> <a style="color: grey;">Kas Kecil</a> </small>
                    <br>
                    <br>

                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h5 style="color: grey;">Kas Kecil</h5>
                        </div>
                        <!-- Card Body -->
                        <div style="height: 2520px;" class="card-body">
                            <div class="chart-area">

                                <!-- Form Tanggal Akses Data -->
                                <?php echo "<form  method='POST' action='VKasKecil' style='margin-bottom: 15px;'>" ?>
                                <div>
                                    <div align="left" style="margin-left: 20px;">
                                        <input type="date" id="tanggal1" style="font-size: 14px" name="tanggal1">
                                        <span>-</span>
                                        <input type="date" id="tanggal2" style="font-size: 14px" name="tanggal2">
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
                                            <button style="font-size: clamp(7px, 3vw, 15px); " type="button" class="btn btn-primary" data-toggle="modal" data-target="#input"> <i class="fas fa-plus-square mr-2"></i>Catat Pengeluaran</button> <br> <br>
                                        </div>
                                        <!-- Form Modal  -->
                                        <div class="modal fade bd-example-modal-lg" id="input" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"> Form Pengeluaran</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <!-- Form Input Data -->
                                                    <div class="modal-body" align="left">
                                                        <?php echo "<form action='../proses/IKasKecil?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir' enctype='multipart/form-data' method='POST'>";  ?>

                                                        <br>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Tanggal</label>
                                                                <input class="form-control " type="date" name="tanggal" required="">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Akun Kas</label>
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
                                                        </div>

                                                        <br>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>No Polisi Kendaraan</label>
                                                                <select id="tokens" class="selectpicker form-control" name="no_polisi" multiple data-live-search="true">
                                                                    <option></option>
                                                                    <?php
                                                                    include 'koneksi.php';

                                                                    $result = mysqli_query($koneksi, "SELECT no_polisi FROM list_kendaraan WHERE status_kendaraan = 'Non PSO' ");

                                                                    while ($data2 = mysqli_fetch_array($result)) {
                                                                        $no_polisi = $data2['no_polisi'];

                                                                        echo "<option> $no_polisi </option> ";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Jumlah</label>
                                                                <input class="form-control form-control-sm" type="text" name="jumlah" required="">
                                                            </div>

                                                        </div>

                                                        <br>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Keterangan</label>
                                                                <textarea class="form-control form-control-sm" name="keterangan"></textarea>
                                                            </div>
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
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Akun Kas</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">No Polisi Kendaraan</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Debit</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Kredit</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Keterangan</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">File</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $no_urut = 0;
                                            $total_pengeluaran = 0;
                                            function formatuang($angka)
                                            {
                                                $uang = "Rp " . number_format($angka, 2, ',', '.');
                                                return $uang;
                                            }

                                            while ($data = mysqli_fetch_array($table)) {
                                                $no_laporan = $data['no_laporan'];
                                                $tanggal = $data['tanggal'];
                                                $akun_kas = $data['akun_kas'];
                                                $no_polisi = $data['no_polisi'];
                                                $jumlah = $data['jumlah'];
                                                $status_saldo = $data['status_saldo'];
                                                $keterangan = $data['keterangan'];
                                                $file_bukti = $data['file_bukti'];

                                                $no_urut++;

                                                echo "<tr>
                                                <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$no_urut</td>
                                                <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$tanggal</td>
                                                <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$akun_kas</td>
                                                <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$no_polisi</td>";
                                                if ($status_saldo == 'Masuk') {
                                                    echo "
                                                        <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>" ?> <?= formatuang($jumlah); ?> <?php echo "</td>";
                                                                                                                    } else {
                                                                                                                        echo "
                                                        <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>" ?> <?php echo "</td>";
                                                                                                                    }

                                                                                                                    if ($status_saldo == 'Keluar') {
                                                                                                                        echo "
                                                        <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>" ?> <?= formatuang($jumlah); ?> <?php echo "</td>";
                                                                                                                    } else {
                                                                                                                        echo "
                                                        <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>" ?> <?php echo "</td>";
                                                                                                                    }
                                                                                            ?>
                                                <?php echo "
                                                <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$keterangan</td>
                                                <td style='font-size: clamp(12px, 1vw, 15px);'>"; ?> <a download="" href="/SijugaNonPSO/AdminNonPSO/file_admin_non_pso/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
                                                "; ?>
                                                    <?php echo "<td style='font-size: clamp(12px, 1vw, 15px);'>"; ?>

                                                    <button style=" font-size: clamp(7px, 1vw, 10px); color:black; " href="#" type="submit" class=" btn bg-warning mr-2 rounded" data-toggle="modal" data-target="#formedit<?php echo $data['no_laporan']; ?>" data-toggle='tooltip' title='Edit Kas Kecil'>
                                                        <i class="fa-regular fa-pen-to-square"></i></button>
                                                    <!-- Form EDIT DATA -->

                                                    <div class="modal fade" id="formedit<?php echo $data['no_laporan']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"> Edit Kas Kecil </h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                                        <span aria-hidden="true"> &times; </span>
                                                                    </button>
                                                                </div>

                                                                <!-- Form Edit Data -->
                                                                <div class="modal-body">
                                                                    <form action="../proses/EKasKecil" enctype="multipart/form-data" method="POST">

                                                                        <input type="hidden" name="no_laporan" value="<?= $no_laporan; ?>">
                                                                        <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
                                                                        <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir; ?>">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <label>Tanggal</label>
                                                                                <input class="form-control " type="date" name="tanggal" value="<?= $tanggal; ?>" required="">
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label>Akun Kas</label>
                                                                                <select name="akun_kas" class="form-control">
                                                                                    <?php $dataSelect = $data['akun_kas']; ?>

                                                                                    <option <?php echo ($dataSelect == 'BBM') ? "selected" : "" ?>>BBM</option>
                                                                                    <option <?php echo ($dataSelect == 'MESIN STEAM') ? "selected" : "" ?>>MESIN STEAM</option>
                                                                                    <option <?php echo ($dataSelect == 'PERAWATAN & SPAREPART') ? "selected" : "" ?>>PERAWATAN & SPAREPART</option>
                                                                                    <option <?php echo ($dataSelect == 'PERAWATAN KANTOR & GUDANG') ? "selected" : "" ?>>PERAWATAN KANTOR & GUDANG</option>
                                                                                    <option <?php echo ($dataSelect == 'ATK') ? "selected" : "" ?>>ATK</option>
                                                                                    <option <?php echo ($dataSelect == 'GAJI') ? "selected" : "" ?>>GAJI</option>
                                                                                    <option <?php echo ($dataSelect == 'PAJAK') ? "selected" : "" ?>>PAJAK</option>
                                                                                    <option <?php echo ($dataSelect == 'PKB KIR & IZIN USAHA') ? "selected" : "" ?>>PKB KIR & IZIN USAHA</option>
                                                                                    <option <?php echo ($dataSelect == 'ASURANSI') ? "selected" : "" ?>>ASURANSI</option>
                                                                                    <option <?php echo ($dataSelect == 'LISTRIK TELEPON & INTERNET') ? "selected" : "" ?>>LISTRIK TELEPON & INTERNET</option>
                                                                                    <option <?php echo ($dataSelect == 'KONSUMSI') ? "selected" : "" ?>>KONSUMSI</option>
                                                                                    <option <?php echo ($dataSelect == 'JAMUAN') ? "selected" : "" ?>>JAMUAN</option>
                                                                                    <option <?php echo ($dataSelect == 'PLASTIK WRAP') ? "selected" : "" ?>>PLASTIK WRAP</option>
                                                                                    <option <?php echo ($dataSelect == 'LAIN LAIN') ? "selected" : "" ?>>LAIN LAIN</option>
                                                                                    <option <?php echo ($dataSelect == 'REFFRESENTATIF') ? "selected" : "" ?>>REFFRESENTATIF</option>
                                                                                    <option <?php echo ($dataSelect == 'PENANGANAN COVID 19') ? "selected" : "" ?>>PENANGANAN COVID 19</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <br>

                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div>
                                                                                    <label>No Polisi Kendaraan</label>
                                                                                </div>
                                                                                <select id="tokens" class="selectpicker form-control" name="no_polisi" multiple data-live-search="true">


                                                                                    <?php
                                                                                    $dataSelect = $data['no_polisi']; ?>
                                                                                    <option <?php echo ($dataSelect == '') ? "selected" : "" ?>></option> <?php
                                                                                                                                                            $result = mysqli_query($koneksi, "SELECT no_polisi FROM list_kendaraan ");
                                                                                                                                                            while ($data2 = mysqli_fetch_array($result)) {
                                                                                                                                                                $no_polisi = $data2['no_polisi'];


                                                                                                                                                                echo "<option" ?> <?php echo ($dataSelect == $no_polisi) ? "selected" : "" ?>> <?php echo $no_polisi; ?> <?php echo "</option>";
                                                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                                                            ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label>Jumlah</label>
                                                                                <input class="form-control form-control-sm" type="text" name="jumlah" value="<?= $jumlah; ?>" required="">
                                                                            </div>

                                                                        </div>

                                                                        <br>

                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <label>Keterangan</label>
                                                                                <textarea class="form-control form-control-sm" name="keterangan"><?= $keterangan; ?></textarea>
                                                                            </div>
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
                                                    <button style=" font-size: clamp(7px, 1vw, 10px); color:black;" href="#" type="submit" class=" btn btn-danger" data-toggle="modal" data-target="#PopUpHapus<?php echo $data['no_laporan']; ?>" data-toggle='tooltip' title='Hapus Kas Kecil'>
                                                        <i style="font-size: clamp(7px, 1vw, 10px); color: black;" class="fa-solid fa-trash"></i></button>
                                                    <div class="modal fade" id="PopUpHapus<?php echo $data['no_laporan']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title"> <b> Hapus Kas Kecil </b> </h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                                        <span aria-hidden="true"> &times; </span>
                                                                    </button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <form action="../proses/DKasKecil" method="POST">
                                                                        <input type="hidden" name="no_laporan" value="<?php echo $no_laporan; ?>">
                                                                        <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
                                                                        <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir; ?>">
                                                                        <div class="form-group">
                                                                            <h6> Yakin Ingin Hapus Pengeluaran ini ? </h6>
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
                                                ?>

                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <!-- Kotak  pengeluaran -->
                                <div class="row">

                                    <!-- Pengeluaran -->
                                    <div class="col-xl-12 col-md-6 mb-4">
                                        <div class="card border-left-danger shadow h-100 py-2">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                            Saldo Kas Non PSO Sekarang</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($jumlah_saldo); ?></div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fa-solid fa-rupiah-sign"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <br>
                                <hr>
                                <br>

                                <h5 align="center" style='font-size: clamp(12px, 1vw, 18px); color: black;'>REKAP PENGELUARAN</h5>
                                <!-- Tabel -->
                                <table class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
                                    <thead>
                                        <tr>
                                            <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Akun Kas</th>
                                            <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total Pengeluaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total_seluruh = 0;
                                        ?>
                                        <?php while ($data = mysqli_fetch_array($table2)) {
                                            $akun_kas = $data['akun_kas'];
                                            $jumlah = $data['total_jumlah'];
                                            if ($akun_kas == 'PENAMBAHAN SALDO') {
                                            } else {
                                                $total_seluruh = $total_seluruh + $jumlah;
                                            }

                                            echo "<tr>
      ";
                                            if ($akun_kas == 'PENAMBAHAN SALDO') {
                                            } else {
                                                echo " <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$akun_kas</td>
                                                <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>" ?> <?= formatuang($jumlah); ?> <?php echo "</td>";
                                                                                                    }


                                                                                                    echo " </tr>";
                                                                                                }
                                                                                                        ?>
                                        <td style='font-size: clamp(12px, 1vw, 12px); color: black;'><strong>TOTAL</strong></td>
                                        <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_seluruh); ?></strong> </td>

                                        </tr>
                                    </tbody>
                                </table>

                                <br>
                                <hr>
                                <br>

                                <h5 align="center" style='font-size: clamp(12px, 1vw, 18px); color: black;'>REKAP BBM</h5>
                                <!-- Tabel -->
                                <table class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
                                    <thead>
                                        <tr>
                                            <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>No Polisi</th>
                                            <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total BBM</th>
                                            <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total_seluruh = 0;
                                        ?>
                                        <?php while ($data = mysqli_fetch_array($table3)) {
                                            $no_polisi = $data['no_polisi'];
                                            $jumlah = $data['total_jumlah'];
                                            $total_seluruh = $total_seluruh + $jumlah;
                                            echo "<tr>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$no_polisi</td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>" ?> <?= formatuang($jumlah); ?> <?php echo "</td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>    <a href='VRBBM?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&no_polisi=$no_polisi'>Rincian</a></td>";
                                                                                                                                            echo " </tr>";
                                                                                                                                        }
                                                                                                                                            ?>
                                        <td style='font-size: clamp(12px, 1vw, 12px); color: black;'><strong>TOTAL</strong></td>
                                        <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_seluruh); ?></strong> </td>
                                        <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>  </td>
                                        
                                     

                                        </tr>
                                    </tbody>
                                </table>

                                <br>
                                <hr>
                                <br>

                                <h5 align="center" style='font-size: clamp(12px, 1vw, 18px); color: black;'>REKAP PERAWATAN & SPAREPART</h5>
                                <!-- Tabel -->
                                <table class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
                                    <thead>
                                        <tr>
                                            <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>No Polisi</th>
                                            <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Total BBM</th>
                                            <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total_seluruh = 0;
                                        ?>
                                        <?php while ($data = mysqli_fetch_array($table4)) {
                                            $no_polisi = $data['no_polisi'];
                                            $jumlah = $data['total_jumlah'];
                                            $total_seluruh = $total_seluruh + $jumlah;
                                            echo "<tr>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$no_polisi</td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>" ?> <?= formatuang($jumlah); ?> <?php echo "</td>
                                             <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>    <a href='VRPerawatan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&no_polisi=$no_polisi'>Rincian</a></td>";
                                                                                                                                            echo " </tr>";
                                                                                                                                        }
                                                                                                                                            ?>
                                        <td style='font-size: clamp(12px, 1vw, 12px); color: black;'><strong>TOTAL</strong></td>
                                        <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_seluruh); ?></strong> </td>
                                        <td style='font-size: clamp(12px, 1vw, 12px); color: black;'>  </td>
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