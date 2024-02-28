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
  $tgl = date("d-M-Y");
 $hariini= date("Y-m-d");
 $sebulanlalu= date('Y-m-d', strtotime("-30 day", strtotime(date("Y-m-d"))));
 $bulanini =date('m');
 $tahunini =date('Y');
?>
<?php 
   header("Refresh:600"); //merefresh halaman setiap 0 detik
?>
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
  <!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard | RS Bhayangkara Hasta Brata Batu</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-top-nav"></body>
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="50" width="60">
  </div>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard RSB Hasta Brata Batu</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Laporan Harian Poli</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

  <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          
          
           
         
          <!-- ./col -->
          <!-- ./col -->
          
          <!-- ./col -->
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-12 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">
                  <!--<i class="fas fa-chart-pie mr-1"></i>-->
                  Kunjungan Poliklinik Tanggal : <?php echo $tgl; ?>
                </h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                  <!-- Morris chart - Sales -->
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                              <ol class="carousel-indicators">
                              </ol>
                              <div class="carousel-inner">
                                <div class="carousel-item active">

                               <div class='row'>
                              <?php  
                                    $_sql="SELECT poliklinik.nm_poli,
                                                    COUNT(reg_periksa.no_rawat) AS kunjung,
                                                    SUM(CASE WHEN reg_periksa.kd_pj IN ('BPJ', 'A79') THEN 1 ELSE 0 END) AS BPJS,
                                                    SUM(CASE WHEN reg_periksa.kd_pj = 'A01' THEN 1 ELSE 0 END) AS UMUM,
                                                    dokter.nm_dokter
                                                FROM poliklinik
                                                INNER JOIN reg_periksa ON poliklinik.kd_poli = reg_periksa.kd_poli
                                                INNER JOIN dokter ON dokter.kd_dokter = reg_periksa.kd_dokter
                                                WHERE reg_periksa.tgl_registrasi = '$hariini'
                                                AND reg_periksa.status_lanjut = 'Ralan'
                                                AND poliklinik.kd_poli NOT IN ('IGDK')
                                                GROUP BY poliklinik.kd_poli, reg_periksa.kd_dokter" ; 
                               
                                    $hasil=bukaquery($_sql);
                                    
                                    $juml_row=mysqli_num_rows($hasil);
                                  $s=1;
                                    while ($data = mysqli_fetch_assoc($hasil)) {
                                        $arr1[$s]=$data['nm_poli'];
                                        $arr2[$s]=$data['kunjung'];
                                        $arr3[$s]=$data['BPJS'];
                                        $arr4[$s]=$data['UMUM'];
                                        $arr5[$s]=$data['nm_dokter'];
                                        $s++;                                 
                                  }  
                                    for($i=1; $i<$juml_row+1; $i++){
                                       echo "<div class='col-sm-6'>
                                        <div class='input-group'>
                                       <span class='input-group-text' style='width: 200px'>".$arr1[$i]."</span>
                                       <span class='form-control'>".$arr2[$i]." , BPJS : ".$arr3[$i]." , UMUM : ".$arr4[$i]."</span>
                                       <span class='form-control'>".$arr5[$i]."</span>
                                       </div></div>";
                                       }
                                ?>
                                </div>
                                </div>
                  </div>
                </div>
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- /.card -->


          </section>
          
          <?php
                         $_sql="select poliklinik.nm_poli,count(reg_periksa.no_rawat) as kunjung   ,
                                    COUNT(CASE WHEN reg_periksa.kd_pj IN ('BPJ', 'A79') THEN 1 ELSE NULL END) AS BPJS_A79
                                    
                                    FROM  poliklinik INNER JOIN reg_periksa
                                    ON poliklinik.kd_poli = reg_periksa.kd_poli
                                    where reg_periksa.tgl_registrasi= '$hariini' and reg_periksa.status_lanjut ='Ranap' and poliklinik.kd_poli not in ('IGDK')
                                    GROUP BY poliklinik.kd_poli"; 
                                $hasil=bukaquery($_sql);
                                $juml_row=mysqli_num_rows($hasil);
                                $s=1;
                                    while ($data = mysqli_fetch_assoc($hasil)) {
                                    $arr1[$s]=$data['nm_poli'];
                                    $arr2[$s]=$data['kunjung'];
                                    $arr3[$s]=$data['BPJS_A79'];
                                    // $arr4[$s]=$data['UMUM'];
                                    $s++;                                
                                    } 
                                    

                                    echo "<div class='col-lg-4'>
                                           <div class='card card-success'>
                                                <div class='card-header'><h4>Pasien Ranap dari Rajal</h4></div>
                                               <div class='card-body'>
                                               <p class='card-text'>";
                                    for($i=1; $i<$juml_row+1; $i++){
                                                        echo" ".$arr1[$i]."
                                                       Jumlah Pasien : ".$arr2[$i]."<br>";
                                    }
                                                //   ".$arr1[$i]."
                                                //       </p> ";
                                    // for($i=1; $i<$juml_row+1; $i++){
                                    //     // echo "<div class='col-sm-6'>
                                    //     //         <div class='input-group'>
                                    //     //         <span class='input-group-text' style='width: 200px'>".$arr1[$i]."</span>
                                    //     //         <span class='form-control'>".$arr2[$i]."</span></div>
                                    //     //     </div>";

                                    //     echo "
                                        
                                    //               <p class='card-text'>
                                    //               ".$arr1[$i]."
                                    //                   Jumlah Pasien : ".$arr2[$i]."<br>    
                                    //                   Cara Bayar BPJS :".$arr3[$i]." <br>
                                    //                   Cara Bayar Umum :".$arr4[$i]."
                                    //                   </p> 
                                    //   ";
                                    // }
                                    echo "            
                                               </div>
                                           </div>
                                       </div>";
                    //echo $my_prj;
                    ?>
          
        
          <!-- ./col -->
          <div class="col-lg-2 col-4">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>
                <?php $hitung_prj="select reg_periksa.no_rawat
                      from reg_periksa inner join dokter on reg_periksa.kd_dokter=dokter.kd_dokter inner join pasien on reg_periksa.no_rkm_medis=pasien.no_rkm_medis 
                      inner join poliklinik on reg_periksa.kd_poli=poliklinik.kd_poli inner join penjab on reg_periksa.kd_pj=penjab.kd_pj where  
                      reg_periksa.tgl_registrasi= '$hariini' and reg_periksa.status_lanjut='Ralan' and poliklinik.kd_poli not in ('IGDK','7','13','1') order by pasien.nm_pasien";
                  $result = bukaquery($hitung_prj);
                  echo mysqli_num_rows($result);
                  //echo $my_prj;
                ?>
                </h3>

                <p>Rawat Jalan</p>
              </div>
              <div class="icon">
                <i class="fab fa-accessible-icon"></i>
              </div>
              <a class="small-box-footer" href="detailkamar.php">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          
           
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          



  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<script>
  $(function () {

  

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = {
      labels: [
          'Chrome',
          'IE',
          'FireFox',
          'Safari',
          'Opera',
          'Navigator',
      ],
      datasets: [
        {
          data: [700,500,400,600,300,100],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    })

    
  })
</script>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE for demo purposes -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- Page specific script -->
<script src="dist/js/circles.min.js"></script>



<script>
$(function () {

$('#reservationdate').datetimepicker({
        format: 'L'
    });

  })
</script>
</body>
</html>
