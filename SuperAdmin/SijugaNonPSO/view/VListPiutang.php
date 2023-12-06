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
if ($jabatan_valid == 'Super Admin') {
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
    $table = mysqli_query($koneksi, "SELECT * FROM penjualan a INNER JOIN customer b ON b.kode_customer=a.kode_customer WHERE tanggal = '$tanggal_awal' AND status_penjualan = 'Piutang'");
} else {

    $table = mysqli_query($koneksi, "SELECT * FROM penjualan a INNER JOIN customer b ON b.kode_customer=a.kode_customer WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_penjualan = 'Piutang' ");
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

    <title>Penjualan (Piutang)</title>

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
                        <a class="collapse-item" href="/SuperAdmin/SijugaNonPSO/view/DsSijugaNonPSO">SijugaNonPSO</a>
                        <a class="collapse-item" href="/SuperAdmin/SijugaPSO/view/DsSijugaPSO">SijugaPSO</a>
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

            <!-- Nav Item - Menu Anggota -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fa-solid fa-people-group"></i>
                    <span>Aset</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="VListKendaraan">List Kendaraan</a>
                        <a class="collapse-item" href="VListSaldo">List Saldo</a>
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
                    <small class="m-0 font-weight-thin text-primary"><a href="DsSijugaNonPSO">Dashboard</a> <i style="color: grey;" class="fa fa-caret-right" aria-hidden="true"></i> <a style="color: grey;">List Piutang</a> </small>
                    <br>
                    <br>

                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h5 style="color: grey;">List Piutang</h5>
                        </div>
                        <!-- Card Body -->
                        <div style="height: 980px;" class="card-body">
                            <div class="chart-area">

                                <!-- Form Tanggal Akses Data -->
                                <?php echo "<form  method='POST' action='VListPiutang' style='margin-bottom: 15px;'>" ?>
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
                                            $total_penjualan_piutang = 0;
                                            $total_penjualan_12kg_piutang = 0;
                                            $total_penjualan_55kg_piutang = 0;
                                            $total_penjualan_50kg_piutang = 0;
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

                                                $total_penjualan_piutang = $total_penjualan_piutang + $jumlah;
                                                $total_penjualan_12kg_piutang = $total_penjualan_12kg_piutang + $jumlah_12kg;
                                                $total_penjualan_55kg_piutang = $total_penjualan_55kg_piutang + $jumlah_55kg;
                                                $total_penjualan_50kg_piutang = $total_penjualan_50kg_piutang + $jumlah_50kg;



                                                $no_urut++;


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
                                                    <td style='font-size: clamp(12px, 1vw, 15px);'>"; ?> <a download="" href="/SijugaNonPSO/AdminNonPSO/file_admin_non_pso/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
                                                    "; ?>
                                                    <?php echo "<td style='font-size: clamp(12px, 1vw, 15px);'>"; ?>

                                                    <button style=" font-size: clamp(7px, 1vw, 10px); color:black; " href="#" type="submit" class=" btn bg-primary mr-2 rounded" data-toggle="modal" data-target="#formpelunasan<?php echo $data['no_penjualan']; ?>" data-toggle='tooltip' title='Pembayaran Hutang'>
                                                        <i class="fa-solid fa-money-bill"></i></button>
                                                    <!-- Form EDIT DATA -->

                                                    <div class="modal fade" id="formpelunasan<?php echo $data['no_penjualan']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Pembayaran Hutang </h5>
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



                                                <?php echo  " </td> </tr>";
                                            }
                                                ?>

                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <!-- Tabel penjualan piutang -->
                                <br>
                                <hr>
                                <br>

                                <h5 align="center" style='font-size: clamp(12px, 1vw, 18px); color: black;'>REKAP PENJUALAN PIUTANG</h5>
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
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'><strong>TOTAL SELURUH PENJUALAN PIUTANG</strong></td>
                                            <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <strong> <?= formatuang($total_penjualan_piutang); ?></strong> </td>
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