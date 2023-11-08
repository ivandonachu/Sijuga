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

if ($tanggal_awal == $tanggal_akhir) {
    $table = mysqli_query($koneksi, "SELECT * FROM penjualan a INNER JOIN pangkalan b ON b.no_registrasi=a.no_registrasi WHERE tanggal = '$tanggal_awal' AND nama_akun = 'Penjualan Refill' ");
} else {

    $table = mysqli_query($koneksi, "SELECT * FROM penjualan a INNER JOIN pangkalan b ON b.no_registrasi=a.no_registrasi WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Penjualan Refill' ");
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

    <title>Rincian Penjualan Refill</title>

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
                <div class="sidebar-brand-text mx-3">PT Non PSO</div>
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
                        <a class="collapse-item" href="VPengeluaran">Pengeluaran</a>
                        <a class="collapse-item" href="VTransportFee">Transport Fee</a>
                        <a class="collapse-item" href="VLaporanInventory">Laporan Inventory</a>

                    </div>
                </div>
            </li>

            <!-- Nav Item - Menu Anggota -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fa-solid fa-people-group"></i>
                    <span>Pangkalan</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="VListPangkalan">List Pangkalan</a>
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
                    <small class="m-0 font-weight-thin text-primary"><a href="DsSijugaNonPSO">Dashboard</a> <i style="color: grey;" class="fa fa-caret-right" aria-hidden="true"></i> <a style="color: grey;">Rincian Penjualan Refill</a> </small>
                    <br>
                    <br>

                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h5 style="color: grey;">Rincian Penjualan Refill</h5>
                        </div>
                        <!-- Card Body -->
                        <div style="height: 980px;" class="card-body">
                            <div class="chart-area">

                                <div align="left">
                                    <?php echo "<a href='../VLabaRugi?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'><button type='button' class='btn btn-primary'>Kembali</button></a>"; ?>
                                </div>

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
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Nama Pangkalan</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Pembayaran</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">QTY 5,5 Kg</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Harga 5,5 Kg</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">QTY 12 Kg</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Harga 12 Kg</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Jumlah</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Keterangan</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">File</th>
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
                                            function formatuang($angka)
                                            {
                                                $uang = "Rp " . number_format($angka, 2, ',', '.');
                                                return $uang;
                                            }

                                            while ($data = mysqli_fetch_array($table)) {
                                                $no_penjualan = $data['no_penjualan'];
                                                $tanggal = $data['tanggal'];
                                                $nama_akun = $data['nama_akun'];
                                                $nama_pangkalan = $data['nama_pangkalan'];
                                                $pembayaran = $data['pembayaran'];
                                                $qty_55kg = $data['qty_55kg'];
                                                $harga_55kg = $data['harga_55kg'];
                                                $jumlah_55kg = $data['jumlah_55kg'];
                                                $qty_12kg = $data['qty_12kg'];
                                                $harga_12kg = $data['harga_12kg'];
                                                $jumlah_12kg = $data['jumlah_12kg'];
                                                $jumlah = $data['jumlah'];
                                                $keterangan = $data['keterangan'];
                                                $file_bukti = $data['file_bukti'];
                                                if ($pembayaran == 'Cash') {
                                                    $total_penjualan_cash = $total_penjualan_cash + $jumlah;
                                                    $total_penjualan_12kg_cash = $total_penjualan_12kg_cash + $jumlah_12kg;
                                                    $total_penjualan_55kg_cash = $total_penjualan_55kg_cash + $jumlah_55kg;
                                                } else {
                                                    $total_penjualan_cashless = $total_penjualan_cashless + $jumlah;
                                                    $total_penjualan_12kg_cashless = $total_penjualan_12kg_cashless + $jumlah_12kg;
                                                    $total_penjualan_55kg_cashless = $total_penjualan_55kg_cashless + $jumlah_55kg;
                                                }

                                                $no_urut++;

                                                echo "<tr>
                                                <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$no_urut</td>
                                                <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$tanggal</td>
                                                <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$nama_akun</td>
                                                <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$nama_pangkalan</td>
                                                <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$pembayaran</td>
                                                <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$qty_55kg</td>
                                                <td style='font-size: clamp(12px, 1vw, 15px); color: black;' >"; ?> <?= formatuang($harga_55kg); ?> <?php echo "</td>
                                                <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$qty_12kg</td>
                                                <td style='font-size: clamp(12px, 1vw, 15px); color: black;' >"; ?> <?= formatuang($harga_12kg); ?> <?php echo "</td>
                                                <td style='font-size: clamp(12px, 1vw, 15px); color: black;' >"; ?> <?= formatuang($jumlah); ?> <?php echo "</td>
                                                <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$keterangan</td>
                                                <td style='font-size: clamp(12px, 1vw, 15px);'>"; ?> <a download="/SijugaNonPSO/Admin/file_admin/<?= $file_bukti ?>" href="/SijugaNonPSO/Admin/file_admin/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
                                                </tr>";
                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                ?>

                                        </tbody>
                                    </table>
                                </div>
                                <br>

                                <!-- Kotak pemasukan pengeluaran -->
                                <div class="row">
                                    <!-- Penjualan CASHLESS -->
                                    <div class="col-xl-4 col-md-6 mb-4">
                                        <div class="card border-left-success shadow h-100 py-2">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                            Penjualan Cashless</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_penjualan_cashless) ?></div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fa-solid fa-rupiah-sign"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Penjualan CASH -->
                                    <div class="col-xl-4 col-md-6 mb-4">
                                        <div class="card border-left-success shadow h-100 py-2">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                            Penjualan Cash</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_penjualan_cash) ?></div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fa-solid fa-rupiah-sign"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Penjualan CASH -->
                                    <div class="col-xl-4 col-md-6 mb-4">
                                        <div class="card border-left-success shadow h-100 py-2">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                            Penjualan Cash + Cashless</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_penjualan_cash + $total_penjualan_cashless) ?></div>
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

                                <!-- Kotak pemasukan pengeluaran -->
                                <div class="row">
                                    <!-- Penjualan CASHLESS 5,5 KG -->
                                    <div class="col-xl-3 col-md-6 mb-4">
                                        <div class="card border-left-success shadow h-100 py-2">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                            Penjualan Cashless 5,5 Kg</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_penjualan_55kg_cashless) ?></div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fa-solid fa-rupiah-sign"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Penjualan CASH 5,5 KG -->
                                    <div class="col-xl-3 col-md-6 mb-4">
                                        <div class="card border-left-success shadow h-100 py-2">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                            Penjualan Cash 5,5 Kg</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_penjualan_55kg_cash) ?></div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fa-solid fa-rupiah-sign"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Penjualan CASHLESS 12 KG -->
                                    <div class="col-xl-3 col-md-6 mb-4">
                                        <div class="card border-left-success shadow h-100 py-2">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                            Penjualan Cashless 12 Kg</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_penjualan_12kg_cashless) ?></div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fa-solid fa-rupiah-sign"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Penjualan CASH 12KG  -->
                                    <div class="col-xl-3 col-md-6 mb-4">
                                        <div class="card border-left-success shadow h-100 py-2">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                            Penjualan Cash 12 Kg</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_penjualan_12kg_cash) ?></div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fa-solid fa-rupiah-sign"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


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