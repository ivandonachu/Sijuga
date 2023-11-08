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


$mpdf = new \Mpdf\Mpdf([ 'mode' => 'utf-8', 'format' => 'A4-L', 'orientation' => 'L']);
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
if ($tanggal_awal == $tanggal_akhir) {
    $table = mysqli_query($koneksi, "SELECT nama_pangkalan , SUM(qty_55kg) AS total_alokasi_55kg , SUM(qty_12kg) AS total_alokasi_12kg FROM penjualan a INNER JOIN pangkalan b ON b.no_registrasi=a.no_registrasi WHERE tanggal = '$tanggal_awal' GROUP BY b.nama_pangkalan");
} else {

    $table = mysqli_query($koneksi, "SELECT nama_pangkalan , SUM(qty_55kg) AS total_alokasi_55kg , SUM(qty_12kg) AS total_alokasi_12kg  FROM penjualan a INNER JOIN pangkalan b ON b.no_registrasi=a.no_registrasi WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY b.nama_pangkalan");
}
    

        $html .= '

        <h3 class="panel-title" align="Center" style = "margin-bottom: 1px; margin-top: 1px;"><img style=" max-height: 70px; width: 100%; text-align:center; " > Logo Sijuga Non PSO  </h3>
        <hr style = "margin-bottom: 1px; margin-top: 1px;">
        <h2 class="panel-title" align="Center" style = "margin-bottom: 1px; margin-top: 1px;"><u><strong>Laporan Alokasi Non PSO</strong></u></h2>
        <pre class="panel-title" align="center"  style="font-size: 12px; margin-bottom: 10px; margin-top: 1px;">'. $tanggal_awal .' - '. $tanggal_akhir .'</pre>
        
        <table align="center"  style="width:100%"   border="1" cellspacing="0">
        <thead>
            <tr>
                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">No</th>
                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Nama Pangkalan</th>
                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Total Alokasi 5,5 Kg</th>
                <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Total Alokasi 12 Kg</th>
            </tr>
        </thead>
        <tbody>';

    

        $no_urut = 0;
        $total_alokasi_55kg_global = 0;
        $total_alokasi_12kg_global = 0;
        function formatuang($angka)
        {
            $uang = "Rp " . number_format($angka, 2, ',', '.');
            return $uang;
        }

        while ($data = mysqli_fetch_array($table)) {
            $nama_pangkalan = $data['nama_pangkalan'];
            $total_alokasi_55kg = $data['total_alokasi_55kg'];
            $total_alokasi_12kg = $data['total_alokasi_12kg'];

            $total_alokasi_55kg_global = $total_alokasi_55kg_global + $total_alokasi_55kg;
            $total_alokasi_12kg_global = $total_alokasi_12kg_global + $total_alokasi_12kg;
            $no_urut++;

                $html .= ' <tr>
                <td style="font-size: clamp(12px, 1vw, 12px); color: black;" align="center" >'. $no_urut .'</td>
                <td style="font-size: clamp(12px, 1vw, 12px); color: black;" >'. $nama_pangkalan .'</td>
                <td style="font-size: clamp(12px, 1vw, 12px); color: black;" >'. $total_alokasi_55kg .'</td>
                <td style="font-size: clamp(12px, 1vw, 12px); color: black;" >'. $total_alokasi_12kg .'</td>
                 </tr>';
            }
              
 $html .= '
        </tbody>

    </table>';

    $html .= '
    <br>
    <table align="center"  style="width:100%"   border="1" cellspacing="0">
    <thead>
        <tr>
            <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Total Seluruh Alokasi 5,5 Kg</th>
            <th style="font-size: clamp(12px, 1vw, 12px); color: black;">Total Seluruh Alokasi 12 Kg</th>
        </tr>
    </thead>
    <tbody>';




            $html .= ' <tr>
            <td style="font-size: clamp(12px, 1vw, 12px); color: black;" >'. $total_alokasi_55kg_global .'</td>
            <td style="font-size: clamp(12px, 1vw, 12px); color: black;" >'. $total_alokasi_12kg_global .'</td>
             </tr>';
    
          
$html .= '
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