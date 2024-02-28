<?php
 
 
 require_once('../conf/conf.php');
 //header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
 //header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); 
 //header("Cache-Control: no-store, no-cache, must-revalidate"); 
 //header("Cache-Control: post-check=0, pre-check=0", false);
 //header("Pragma: no-cache"); // HTTP/1.0
 date_default_timezone_set("Asia/Jakarta");
 $tanggal= mktime(date("m"),date("d"),date("Y"));
 $jam=date("H:i");
 $hariini= date("Y-m-d");
 $tgl = date("d-M-Y");
 $sebulanlalu= date('Y-m-d', strtotime("-30 day", strtotime(date("Y-m-d"))));
 $bulanini =date('m');
 $tahunini =date('Y');
?>
<?php 
   header("Refresh:600"); //merefresh halaman setiap 0 detik
?>
<!DOCTYPE html>
<?php
session_start();

// Check if the user is not logged in, redirect them to the login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php"); // Replace with the actual login page URL
    exit();
}
    // Check for inactivity timeout (e.g., 30 minutes)
    $inactiveTimeout = 1800; // 30 minutes in seconds
    if (isset($_SESSION["last_activity"]) && (time() - $_SESSION["last_activity"] > $inactiveTimeout)) {
        // Destroy the session and redirect to the login page
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }
    
    // Update the last activity timestamp
    $_SESSION["last_activity"] = time();
?>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Harian Poli</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

  <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
</head>
<body class="hold-transition layout-top-nav">
<!--<div class="wrapper">-->

  <!-- Navbar -->
  <!--<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">-->
  <!--  <div class="container">-->
  <!--    <a href="index3.html" class="navbar-brand">-->
  <!--      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">-->
  <!--      <span class="brand-text font-weight-light">RSB Hasta Brata</span>-->
  <!--    </a>-->

  <!--    <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">-->
  <!--      <span class="navbar-toggler-icon"></span>-->
  <!--    </button>-->

  <!--    <div class="collapse navbar-collapse order-3" id="navbarCollapse">-->
  <!--       Left navbar links -->
  <!--      <ul class="navbar-nav">-->
  <!--        <li class="nav-item">-->
  <!--          <a href="#" class="nav-link">Home</a>-->
  <!--        </li>-->
  <!--        <li class="nav-item">-->
  <!--          <a href="#" class="nav-link">Contact</a>-->
  <!--        </li>-->
  <!--      </ul>-->

  <!--       SEARCH FORM -->
  <!--       <form class="form-inline ml-0 ml-md-3">-->
  <!--        <div class="input-group input-group-sm">-->
  <!--          <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">-->
  <!--          <div class="input-group-append">-->
  <!--            <button class="btn btn-navbar" type="submit">-->
  <!--              <i class="fas fa-search"></i>-->
  <!--            </button>-->
  <!--          </div>-->
  <!--        </div>-->
  <!--      </form>-->
  <!--    </div> -->

  <!--     Right navbar links -->
      
  <!--  </div>-->
  <!--</nav>-->
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
             <h1 class="m-0">Kunjungan Poliklinik Tanggal : <?php echo $tgl; ?></h1> 
          </div><!-- /.col -->
          <div class="col-sm-6">
            <!-- <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Layout</a></li>
              <li class="breadcrumb-item active">Top Navigation</li>
            </ol> -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <!--<div class="content">-->
    <!--  <div class="container">-->
        <div class="row">
            <?php  
            // $_sql="SELECT   poliklinik.nm_poli,count(reg_periksa.no_rawat) as kunjung   ,
            // COUNT(CASE WHEN reg_periksa.kd_pj IN ('BPJ', 'A79') THEN 1 ELSE NULL END) AS BPJS,
            // COUNT(CASE WHEN reg_periksa.kd_pj IN ('A01') THEN 1 ELSE NULL END) AS UMUM                                    
            // FROM  poliklinik INNER JOIN reg_periksa
            // ON poliklinik.kd_poli = reg_periksa.kd_poli
            // where reg_periksa.tgl_registrasi= '$hariini' 
            // and reg_periksa.status_lanjut ='Ralan' and poliklinik.kd_poli not in ('IGDK')
            // GROUP BY poliklinik.kd_poli" ; 
            $_sql ="SELECT
                        poliklinik.nm_poli,
                        COUNT(reg_periksa.no_rawat) AS kunjung,
                        SUM(CASE WHEN reg_periksa.kd_pj IN ('BPJ', 'A79') THEN 1 ELSE 0 END) AS BPJS,
                        SUM(CASE WHEN reg_periksa.kd_pj = 'A01' THEN 1 ELSE 0 END) AS UMUM,
						SUM(CASE WHEN reg_periksa.kd_pj = 'A06' THEN 1 ELSE 0 END) AS POLRI,
						SUM(CASE WHEN reg_periksa.kd_pj = 'A85' THEN 1 ELSE 0 END) AS KELUARGA_POLRI,
						SUM(CASE WHEN reg_periksa.kd_pj = 'A84' THEN 1 ELSE 0 END) AS PNS_POLRI,
						SUM(CASE WHEN reg_periksa.kd_pj = 'A86' THEN 1 ELSE 0 END) AS KELUARGA_PNS_POLRI,
						SUM(CASE WHEN reg_periksa.kd_pj = 'A07' THEN 1 ELSE 0 END) AS BPJS_POLRI,
						SUM(CASE WHEN reg_periksa.kd_pj = 'A89' THEN 1 ELSE 0 END) AS TNI,
						SUM(CASE WHEN reg_periksa.kd_pj = 'A10' THEN 1 ELSE 0 END) AS JR,
						SUM(CASE WHEN reg_periksa.kd_pj = 'A81' THEN 1 ELSE 0 END) AS YANKESTU,
						SUM(CASE WHEN reg_periksa.kd_pj = 'A12' THEN 1 ELSE 0 END) AS KARYAWAN_BLU,
						SUM(CASE WHEN reg_periksa.kd_pj = 'A19' THEN 1 ELSE 0 END) AS VISUM_RM,
                        dokter.nm_dokter
                    FROM poliklinik
                    INNER JOIN reg_periksa ON poliklinik.kd_poli = reg_periksa.kd_poli
                    INNER JOIN dokter ON dokter.kd_dokter = reg_periksa.kd_dokter
                    WHERE reg_periksa.tgl_registrasi = '$hariini'
                    AND reg_periksa.status_lanjut = 'Ralan'
                    AND poliklinik.kd_poli NOT IN ('IGDK')
                    GROUP BY poliklinik.kd_poli, reg_periksa.kd_dokter";
            $hasil=bukaquery($_sql);
            $juml_row=mysqli_num_rows($hasil);
            $s=1;
            //U0039 RAD ,U0052 LAB
                while ($data = mysqli_fetch_assoc($hasil)) {
                $arr1[$s]=$data['nm_poli'];
                $arr2[$s]=$data['kunjung'];
                $arr3[$s]=$data['BPJS'];
                $arr4[$s]=$data['UMUM'];
                $arr5[$s]=$data['nm_dokter'];
                $arr6[$s]=$data['POLRI'];
                $arr7[$s]=$data['KELUARGA_POLRI'];
                $arr8[$s]=$data['PNS_POLRI'];
                $arr9[$s]=$data['KELUARGA_PNS_POLRI'];
                $arr10[$s]=$data['BPJS_POLRI'];
                $arr11[$s]=$data['TNI'];
                $arr12[$s]=$data['JR'];
                $arr13[$s]=$data['YANKESTU'];
                $arr14[$s]=$data['KARYAWAN_BLU'];
                $arr15[$s]=$data['VISUM_RM'];
                $s++;                                
                }  
                    for($i=1; $i<$juml_row+1; $i++){
                        // echo "<div class='col-sm-6'>
                        //         <div class='input-group'>
                        //         <span class='input-group-text' style='width: 200px'>".$arr1[$i]."</span>
                        //         <span class='form-control'>".$arr2[$i]."</span></div>
                        //     </div>";
                        echo "
                        <div class='col-sm-2'>
                        <!-- small box -->
                        
                                <div class='card card-primary'>
                                  <div class='card-header'>
                                    <h5 align='center'>".$arr1[$i]."<br> </h5></div>
                                  <div class='card-body'>
                                   <p> Jumlah Pasien : ".$arr2[$i]."<br>    
                                  BPJS :".$arr3[$i]." <br>
                                   Umum :".$arr4[$i]." <br>
                                   POLRI : ".$arr6[$i]." <br>
                                   PNS POLRI: ".$arr8[$i]." <br>
                                   Jasa Raharja : ".$arr12[$i]." <br>
                                   BLU : ".$arr14[$i]." <br>
                                   BPJS POLRI : ".$arr10[$i]."<br>
                                   TNI : ".$arr11[$i]."<br>
                                   VISUM (RM) : ".$arr15[$i]."<br>
                                   </p>
                                  </div>
                                  <div class='card-footer' align='center'>".strtoupper($arr5[$i])."</div>
                                </div>
                              
                       </div>";
                        }
            ?>
        </div>


        <div class="row">
                    <?php
                         $_sql="select poliklinik.nm_poli,count(reg_periksa.no_rawat) as kunjung   ,
                                    COUNT(CASE WHEN reg_periksa.kd_pj IN ('BPJ', 'A79') THEN 1 ELSE NULL END) AS BPJS_A79
                                    FROM  poliklinik INNER JOIN reg_periksa
                                    ON poliklinik.kd_poli = reg_periksa.kd_poli
                                    where reg_periksa.tgl_registrasi= '$hariini' and reg_periksa.status_lanjut ='Ranap' and poliklinik.kd_poli not in ('IGDK')
                                    GROUP BY poliklinik.kd_poli
																		
																		"; 
                                $hasil=bukaquery($_sql);
                                $juml_row=mysqli_num_rows($hasil);
                                $s=1;
                                    while ($data = mysqli_fetch_assoc($hasil)) {
                                    $arr1[$s]=$data['nm_poli'];
                                    $arr2[$s]=$data['kunjung'];
                                    $arr3[$s]=$data['BPJS'];
                                    $arr4[$s]=$data['UMUM'];
                                    $s++;                                
                                    } 
                                    

                                    echo "<div class='col-lg-2'>
                                           <div class='card card-secondary'>
                                                <div class='card-header'><h4>Pasien Ranap dari Rajal</h4></div>
                                               <div class='card-body'>
                                               <p class='card-text'>";
                                    for($i=1; $i<$juml_row+1; $i++){
                                                        echo" ".$arr1[$i]."
                                                       Jumlah Pasien : ".$arr2[$i]."<br>";
                                    }
                                    echo "            
                                               </div>
                                           </div>
                                       </div>";
                    //echo $my_prj;
                    ?>

            <div class="col-lg-2">
                <div class="card card-secondary">
                  <div class="card-header"><h4>Jumlah Pasien Rajal</h4></div>
                  <div class="card-body">
                      <?php $hitung_prj="select reg_periksa.no_rawat
                        from reg_periksa inner join dokter on reg_periksa.kd_dokter=dokter.kd_dokter inner join pasien on reg_periksa.no_rkm_medis=pasien.no_rkm_medis 
                        inner join poliklinik on reg_periksa.kd_poli=poliklinik.kd_poli inner join penjab on reg_periksa.kd_pj=penjab.kd_pj where  
                        reg_periksa.tgl_registrasi= '$hariini' and reg_periksa.status_lanjut='Ralan' and poliklinik.kd_poli not in ('IGDK','7','13','1') order by pasien.nm_pasien";
                    $result = bukaquery($hitung_prj);
                    $asd = mysqli_num_rows($result);
                    //echo $my_prj;
                    ?>
                    <!--<h5 class="card-title">Light card title</h5>-->
                    <p class="card-text">Jumlah : <?php echo $asd; ?> </p>
                  </div>
                </div>
            </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
        <!-- table-->
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Pasien Hari ini</h3>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No. </th>
                    <th>No RM</th>
                    <th>Nama Pasien</th>
                    <th>Jam Datang</th>
                    <th>Alamat</th>
                    <th>JK</th>
                    <th>Umur</th>
                    <th>Bayar</th>
                    <th>Status</th>
                    <th>Poli</th>
                    <th>Nama Dokter</th>
                    <th>Diagnosa</th>
                  </tr>
                  </thead>
                  <tbody>
                       <?php
                         $_sql="select reg.no_rawat, reg.no_rkm_medis as NO_RM,reg.jam_reg as jam, pasien.nm_pasien as nama, pasien.alamat, pasien.jk, reg.umurdaftar as umur, byr.png_jawab as status, ralan.penilaian as diagnosa,
                                reg.status_poli, poli.nm_poli as poli, dok.nm_dokter as nama_dokter
                                
                                from reg_periksa as reg 
                                inner join pasien as pasien on pasien.no_rkm_medis = reg.no_rkm_medis
                                inner join dokter as dok on reg.kd_dokter = dok.kd_dokter
                                inner join poliklinik as poli on poli.kd_poli = reg.kd_poli
                                inner join penjab as byr on byr.kd_pj = reg.kd_pj
                                inner join pemeriksaan_ralan as ralan on reg.no_rawat = ralan.no_rawat
                                where 
                                reg.tgl_registrasi ='$hariini' AND reg.kd_poli NOT IN ('IGDK') order by reg.kd_poli"; 
                        $hasil=bukaquery($_sql);
                                $juml_row=mysqli_num_rows($hasil);
                                $s=1; 

                                    while ($data = mysqli_fetch_assoc($hasil)) {
                                    $arr1[$s]=$data['NO_RM'];
                                    $arr2[$s]=$data['nama'];
                                    $arr3[$s]=$data['alamat'];
                                    $arr4[$s]=$data['jk'];
                                    $arr5[$s]=$data['umur'];
                                    $arr6[$s]=$data['status'];
                                    $arr7[$s]=$data['status_poli'];
                                    $arr8[$s]=$data['poli'];
                                    $arr9[$s]=$data['nama_dokter'];
                                    $arr10[$s]=$data['diagnosa'];
                                    $arr11[$s]=$data['jam'];
                                    $s++;                                
                                    }
                                    for($i=1; $i<$juml_row+1; $i++){
                                        echo "
                                        <tr>
                                            <td>$i</td>
                                            <td>$arr1[$i]</td>
                                            <td>$arr2[$i]</td>
                                            <td>$arr11[$i]</td>
                                            <td>$arr3[$i]</td>
                                            <td>$arr4[$i]</td>
                                            <td>$arr5[$i]</td>
                                            <td>$arr6[$i]</td>
                                            <td>$arr7[$i]</td>
                                            <td>$arr8[$i]</td>
                                            <td>$arr9[$i]</td>
                                            <td>$arr10[$i]</td>
                                        </tr>";
                                    }
                                
                                    ?>
                      
                  </tbody>
                   


                </table>
              </div>
            </div>
           </div>
         </div> 
         <!-- row-->
        
      </div><!-- /.container-fluid -->
      
  <!--  </div>-->
  <!--   /.content -->
  <!--</div>-->
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      <!--Anything you want-->
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2023 RSB Hasta Brata.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->


<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard3.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "excel"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>
