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

$table = mysqli_query($koneksi, "SELECT * FROM customer");


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>List Customer</title>

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
                    <small class="m-0 font-weight-thin text-primary"><a href="DsAdmin">Dashboard</a> <i style="color: grey;" class="fa fa-caret-right" aria-hidden="true"></i> <a style="color: grey;">List Customer</a> </small>
                    <br>
                    <br>

                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h5 style="color: grey;">List Customer</h5>
                        </div>
                        <!-- Card Body -->
                        <div style="height: 820px;" class="card-body">
                            <div class="chart-area">

                                <!-- Form Input -->
                                <div class="row">
                                    <div class="col-md-10">

                                    </div>
                                    <div class="col-md-2">
                                        <!-- Button Input Data Bayar -->
                                        <div align="right">
                                            <button style="font-size: clamp(7px, 3vw, 15px); " type="button" class="btn btn-primary" data-toggle="modal" data-target="#input"> <i class="fas fa-plus-square mr-2"></i>Tambah Customer</button> <br> <br>
                                        </div>
                                        <!-- Form Modal  -->
                                        <div class="modal fade bd-example-modal-lg" id="input" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"> Form Tambah Customer</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <!-- Form Input Data -->
                                                    <div class="modal-body" align="left">
                                                        <?php echo "<form action='../proses/ICustomer' enctype='multipart/form-data' method='POST'>";  ?>

                                                        <br>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Agen</label>
                                                                <input class="form-control form-control-sm" type="text" name="agen" required="">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Nama Customer</label>
                                                                <input class="form-control form-control-sm" type="text" name="nama_customer" required="">
                                                            </div>
                                                        </div>

                                                        <br>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Jenis Pembayaran</label>
                                                                <select name="jenis_pembayaran" class="form-control" required="">
                                                                    <option>Cash</option>
                                                                    <option>Cashless</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Region 2</label>
                                                                <input class="form-control form-control-sm" type="text" name="region_2" required="">
                                                            </div>
                                                        </div>

                                                        <br>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Provinsi</label>
                                                                <input class="form-control form-control-sm" type="text" name="provinsi" required="">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Kabupaten</label>
                                                                <input class="form-control form-control-sm" type="text" name="kabupaten" required="">
                                                            </div>
                                                        </div>

                                                        <br>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Harga 3 Kg</label>
                                                                <input class="form-control form-control-sm" type="text" name="harga_3kg" required="">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Harga 5,5 Kg</label>
                                                                <input class="form-control form-control-sm" type="text" name="harga_55kg" required="">
                                                            </div>
                                                        </div>

                                                        <br>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Harga 12 Kg</label>
                                                                <input class="form-control form-control-sm" type="text" name="harga_12kg" required="">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Harga 50 Kg</label>
                                                                <input class="form-control form-control-sm" type="text" name="harga_50kg" required="">
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">TAMBAH</button>
                                                            <button type="reset" class="btn btn-danger"> RESET</button>
                                                        </div>
                                                        </form>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Button Edit Harga -->
                                        <div align="right">
                                            <button style="font-size: clamp(7px, 3vw, 15px); " type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit_harga"> <i class="fa-regular fa-pen-to-square"></i>Ubah Harga</button> <br> <br>
                                        </div>
                                        <!-- Form Modal  -->
                                        <div class="modal fade bd-example-modal-lg" id="edit_harga" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"> Form Ubah Harga</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <!-- Form Input Data -->
                                                    <div class="modal-body" align="left">
                                                        <?php echo "<form action='../proses/EHarga' enctype='multipart/form-data' method='POST'>";  ?>

                                                        <br>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Harga 3 Kg</label>
                                                                <input class="form-control form-control-sm" type="text" name="harga_3kg" required="">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Harga 5,5 Kg</label>
                                                                <input class="form-control form-control-sm" type="text" name="harga_55kg" required="">
                                                            </div>
                                                        </div>

                                                        <br>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Harga 12 Kg</label>
                                                                <input class="form-control form-control-sm" type="text" name="harga_12kg" required="">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Harga 50 Kg</label>
                                                                <input class="form-control form-control-sm" type="text" name="harga_50kg" required="">
                                                            </div>
                                                        </div>

                                                        <br>

                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Ubah Harga</button>
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
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Kode Customer</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Agen</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Nama Customer</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Jenis Pembayaran</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Region 2</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Provinsi</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Kabupaten / Kota</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Status Customer</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Harga 3 Kg</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Harga 5,5 Kg</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Harga 12 Kg</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Harga 50 Kg</th>
                                                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $no_urut = 0;
                                            while ($data = mysqli_fetch_array($table)) {
                                                $kode_customer = $data['kode_customer'];
                                                $nama_customer = $data['nama_customer'];
                                                $agen = $data['agen'];
                                                $jenis_pembayaran = $data['jenis_pembayaran'];
                                                $region_2 = $data['region_2'];
                                                $provinsi = $data['provinsi'];
                                                $kabupaten = $data['kabupaten'];
                                                $status_customer = $data['status_customer'];
                                                $harga_3kg = $data['harga_3kg'];
                                                $harga_55kg = $data['harga_55kg'];
                                                $harga_12kg = $data['harga_12kg'];
                                                $harga_50kg = $data['harga_50kg'];

                                                $no_urut++;

                                                echo "<tr>
                                                <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$no_urut</td>
                                                <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$kode_customer</td>
                                                <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$agen</td>
                                                <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$nama_customer</td>
                                                <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$jenis_pembayaran</td>
                                                <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$region_2</td>
                                                <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$provinsi</td>
                                                <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$kabupaten</td>
                                                <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$status_customer</td>
                                                <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$harga_3kg</td>
                                                <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$harga_55kg</td>
                                                <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$harga_12kg</td>
                                                <td style='font-size: clamp(12px, 1vw, 12px); color: black;' >$harga_50kg</td>
                                                "; ?>
                                                <?php echo "<td style='font-size: clamp(12px, 1vw, 15px);'>"; ?>

                                                <button style=" font-size: clamp(7px, 1vw, 10px); color:black; " href="#" type="submit" class=" btn bg-warning mr-2 rounded" data-toggle="modal" data-target="#formedit<?php echo $data['kode_customer']; ?>" data-toggle='tooltip' title='Edit Data Customer'>
                                                    <i class="fa-regular fa-pen-to-square"></i></button>
                                                <!-- Form EDIT DATA -->

                                                <div class="modal fade" id="formedit<?php echo $data['kode_customer']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"> Edit Data Customer </h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                                    <span aria-hidden="true"> &times; </span>
                                                                </button>
                                                            </div>

                                                            <!-- Form Edit Data -->
                                                            <div class="modal-body">
                                                                <form action="../proses/ECustomer" enctype="multipart/form-data" method="POST">

                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label>Kode Customer</label>
                                                                            <input class="form-control form-control-sm" type="text" name="kode_customer" value="<?= $kode_customer; ?>" required="" disabled>
                                                                            <input type="hidden" name="kode_customer" value="<?= $kode_customer; ?>">
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label>Nama Customer</label>
                                                                            <input class="form-control form-control-sm" type="text" name="nama_customer" value="<?= $nama_customer; ?>">
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label>Agen</label>
                                                                            <input class="form-control form-control-sm" type="text" name="agen" value="<?= $agen; ?>">
                                                                        </div>
                                                                    </div>

                                                                    <br>

                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label>Jenis Pembayaran</label>
                                                                            <select name="jenis_pembayaran" class="form-control">
                                                                                <?php $dataSelect = $data['jenis_pembayaran']; ?>
                                                                                <option <?php echo ($dataSelect == 'Cash') ? "selected" : "" ?>>Cash</option>
                                                                                <option <?php echo ($dataSelect == 'Cashless') ? "selected" : "" ?>>Cashless</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label>Region 2</label>
                                                                            <input class="form-control form-control-sm" type="text" name="region_2" value="<?= $region_2; ?>">
                                                                        </div>
                                                                    </div>

                                                                    <br>

                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label>provinsi</label>
                                                                            <input class="form-control form-control-sm" type="text" name="provinsi" value="<?= $provinsi; ?>">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label>Kabupaten / Kota</label>
                                                                            <input class="form-control form-control-sm" type="text" name="kabupaten" value="<?= $kabupaten; ?>">
                                                                        </div>
                                                                    </div>

                                                                    <br>

                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label>Status Customer</label>
                                                                            <select name="status_customer" class="form-control">
                                                                                <?php $dataSelect = $data['status_customer']; ?>
                                                                                <option <?php echo ($dataSelect == 'Aktif') ? "selected" : "" ?>>Aktif</option>
                                                                                <option <?php echo ($dataSelect == 'Tidak Aktif') ? "selected" : "" ?>>Tidak Aktif</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>


                                                                    <br>

                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label>Harga 3 Kg</label>
                                                                            <input class="form-control form-control-sm" type="text" name="harga_3kg" value="<?= $harga_3kg; ?>">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label>Harga 5,5 Kg</label>
                                                                            <input class="form-control form-control-sm" type="text" name="harga_55kg" value="<?= $harga_55kg; ?>">
                                                                        </div>
                                                                    </div>

                                                                    <br>

                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label>Harga 12 Kg</label>
                                                                            <input class="form-control form-control-sm" type="text" name="harga_12kg" value="<?= $harga_12kg; ?>">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label>Harga 50 Kg</label>
                                                                            <input class="form-control form-control-sm" type="text" name="harga_50kg" value="<?= $harga_50kg; ?>">
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
                                                <button style=" font-size: clamp(7px, 1vw, 10px); color:black;" href="#" type="submit" class=" btn btn-danger" data-toggle="modal" data-target="#PopUpHapus<?php echo $data['kode_customer']; ?>" data-toggle='tooltip' title='Hapus Customer'>
                                                    <i style="font-size: clamp(7px, 1vw, 10px); color: black;" class="fa-solid fa-trash"></i></button>
                                                <div class="modal fade" id="PopUpHapus<?php echo $data['kode_customer']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title"> <b> Hapus Customer </b> </h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                                    <span aria-hidden="true"> &times; </span>
                                                                </button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <form action="../proses/DCustomer" method="POST">
                                                                    <input type="hidden" name="kode_customer" value="<?php echo $kode_customer; ?>">
                                                                    <div class="form-group">
                                                                        <h6> Yakin Ingin Hapus Pangkalan <?php echo $data['nama_customer']; ?> ? </h6>
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