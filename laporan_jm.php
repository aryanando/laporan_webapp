<?php
 
 
  require_once('conf/config.php');
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
<html lang="en">
    <html lang="en">
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

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laporan</title>

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
  <!-- daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
      <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <ul class="navbar-nav">
          <!--<li class="nav-item">-->
          <!--  <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>-->
          <!--</li>-->
          <li class="nav-item d-none d-sm-inline-block">
            <a href="logout.php" class="nav-link">Logout</a>
          </li>
        </ul>
      </li>
  </nav>
  <!-- /.navbar -->
        <?php
        // Initialize the result variable
        $result = "";
        
        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve the date range from the form
            // $dateRange = $_POST['date_range'];
        
            // Perform any processing or validation with $dateRange
            // ...
        
            // Assign the result to the variable
            // $result =$dateRange;
            $awal =$_POST['tgl_awal'];
            $akhir =$_POST['tgl_akhir'];
            
            $awal_new_format = date('Y-m-d', strtotime($awal));
            $akhir_new_format = date('Y-m-d', strtotime($akhir));

            $selectedDoctor = $_POST['selectedDoctor'];
            
            $formSubmitted = true;
        }else {
            // Set a default value for $awal and $akhir if the form is not submitted
            $awal = '';
            $akhir = '';
            // Set the flag to false if the form is not submitted
            $formSubmitted = false;
        }
        
        ?>
  <!-- Main Sidebar Container -->
<?php include('menu.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">

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
          <div class="col-lg-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Date picker</h3>
              </div>
              <div class="card-body ">            
                <!-- Date range -->
                <div class="form-group col-md-6">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="input-group" >
                            <div class="input-group date" id="tglawal" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#tglawal" placeholder="Tanggal Awal" name="tgl_awal">
                                <div class="input-group-append" data-target="#tglawal" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>        
                        <div class="input-group">
                            <div class="input-group date" id="tglakhir" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#tglakhir" placeholder="Tanggal Akhir" name="tgl_akhir" >
                                <div class="input-group-append" data-target="#tglakhir" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <!-- /.input group -->
                <!-- HTML part with PHP to generate dynamic options -->
                <div class="input-group">
                    <label>Select Doctor</label>
                    <select class="form-control select2" style="width: 100%;" name="selectedDoctor">
                        <?php
            
                        $query = "SELECT * FROM dokter AS a WHERE a.`status`='1'";
                        
                        $hasilquery = bukaquery($query);
                        $juml_row = mysqli_num_rows($hasilquery);
                        // Check if there are rows in the result set
                        if ($juml_row > 0) {
                            // Loop through the rows and generate options
                            while ($row = mysqli_fetch_assoc($hasilquery)) {
                                echo "<option value='" . $row["kd_dokter"] . "'>" . $row["nm_dokter"] . "</option>";
                            }
                        } else {
                            echo "<option>No doctors found</option>";
                        }
                
                        ?>
                    </select>
                </div>
        
                        
                <!--<div class="form-group clearfix">-->
                <!--      <div class="icheck-primary d-inline">-->
                <!--        <input type="checkbox" id="CheckRalan" name="CheckRalan">-->
                <!--        <label for="CheckRalan">-->
                <!--            Rawat Jalan-->
                <!--        </label>-->
                <!--      </div>-->
                <!--      <div class="icheck-primary d-inline">-->
                <!--        <input type="checkbox" id="CheckRanap" name="CheckRanap">-->
                <!--        <label for="CheckRanap">-->
                <!--            Rawat Inap-->
                <!--        </label>-->
                <!--      </div>-->
                <!--      <div class="icheck-primary d-inline">-->
                <!--        <input type="checkbox" id="CheckOperasi" name="CheckOperasi">-->
                <!--        <label for="CheckOperasi">-->
                <!--             Operasi-->
                <!--        </label>-->
                <!--      </div>-->
                <!--    </div>-->
                <!--</div>-->
                    </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-default float-right">Submit</button>
                        </div>
                    </form>
        <!-- Display the result -->
      </div><!-- /.container-fluid -->
     


            
 <?php
    if ($formSubmitted) {
    echo "
    <div class='row'>
      <div class='col-lg-12'>
        <div class='card card-primary'>
          <div class='card-header'>
            <h3 class='card-title'>JM Dokter Ralan : $awal - $akhir</h3>
    
            <div class='card-tools'>
              <button type='button' class='btn btn-tool' data-card-widget='collapse'>
                <i class='fas fa-minus'></i>
              </button>
              <button type='button' class='btn btn-tool' data-card-widget='remove'>
                <i class='fas fa-times'></i>
              </button>
            </div>
          </div>
          <div class='card-body'>
            <table id='example1' class='table table-bordered table-striped'>
              <thead>
                    <tr>
                        <th>No. </th>
                        <th>Tgl Registrasi</th>
                        <th>Nama Pasien</th>
                        <th>Jenis Bayar</th>
                        <th>Ruang</th>
                        <th>Nama Tindakan</th>
                        <th>Tarif</th>
                        <th>JM Dokter</th>
                    </tr>
              </thead>
              <tbody>";
    
                $query_ralan = "SELECT 
                                tgl_registrasi,
                                nm_pasien,
                                png_jawab,
                                nm_poli,
                                nm_perawatan,
                                kd_jenis_prw,
                                SUM(jml) as jml,
                                SUM(bhp) as bhp,
                                SUM(material) as material,
                                SUM(total_byrdr) as total_byrdr,
                                SUM(tarif_tindakandr) as tarif_tindakandr,
                                SUM(total) as total
                            FROM (
                                SELECT 
                                    reg.tgl_registrasi,
                                    pasien.nm_pasien,
                                    pj.png_jawab,
                                    poli.nm_poli,
                                    jns.nm_perawatan,
                                    drprrj.kd_jenis_prw,
                                    COUNT(drprrj.kd_jenis_prw) as jml,
                                    SUM(drprrj.bhp) as bhp,
                                    SUM(drprrj.material) as material,
                                    drprrj.biaya_rawat as total_byrdr,
                                    SUM(drprrj.tarif_tindakandr) as tarif_tindakandr,
                            		sum(drprrj.biaya_rawat) as total
                                FROM 
                                    rawat_jl_drpr as drprrj
                                    INNER JOIN jns_perawatan as jns ON jns.kd_jenis_prw = drprrj.kd_jenis_prw 
                                    INNER JOIN reg_periksa as reg ON drprrj.no_rawat = reg.no_rawat 
                                    INNER JOIN pasien as pasien ON pasien.no_rkm_medis = reg.no_rkm_medis
                                    INNER JOIN penjab as pj ON pj.kd_pj = reg.kd_pj
                                    INNER JOIN poliklinik as poli ON poli.kd_poli = reg.kd_poli
                                WHERE 
                                    drprrj.tarif_tindakandr > 0 
                                    AND drprrj.kd_dokter = '$selectedDoctor'
                                    AND reg.tgl_registrasi BETWEEN '$awal_new_format' AND '$akhir_new_format' 
                                GROUP BY 
                                    reg.tgl_registrasi,
                                    pasien.nm_pasien,
                                    pj.png_jawab,
                                    poli.nm_poli,
                                    jns.nm_perawatan,
                                    drprrj.kd_jenis_prw
                            
                                UNION ALL
                            
                                SELECT 
                                    reg.tgl_registrasi,
                                    pasien.nm_pasien,
                                    pj.png_jawab,
                                    poli.nm_poli,
                                    jns.nm_perawatan,
                                    rawat_jl_dr.kd_jenis_prw,
                                    COUNT(rawat_jl_dr.kd_jenis_prw) as jml,
                                    SUM(rawat_jl_dr.bhp) as bhp,
                                    SUM(rawat_jl_dr.material) as material,
                                    rawat_jl_dr.biaya_rawat as total_byrdr,
                                    SUM(rawat_jl_dr.tarif_tindakandr) as tarif_tindakandr,
                                   SUM(rawat_jl_dr.biaya_rawat) as total 
                                FROM 
                                    rawat_jl_dr
                                    INNER JOIN jns_perawatan as jns ON jns.kd_jenis_prw = rawat_jl_dr.kd_jenis_prw 
                                    INNER JOIN reg_periksa as reg ON rawat_jl_dr.no_rawat = reg.no_rawat 
                                    INNER JOIN pasien as pasien ON pasien.no_rkm_medis = reg.no_rkm_medis
                                    INNER JOIN penjab as pj ON pj.kd_pj = reg.kd_pj
                                    INNER JOIN poliklinik as poli ON poli.kd_poli = reg.kd_poli
                                WHERE 
                                    rawat_jl_dr.tarif_tindakandr > 0 
                                    AND rawat_jl_dr.kd_dokter = '$selectedDoctor'
                                    AND reg.tgl_registrasi BETWEEN '$awal_new_format' AND '$akhir_new_format' 
                                GROUP BY 
                                    reg.tgl_registrasi,
                                    pasien.nm_pasien,
                                    pj.png_jawab,
                                    poli.nm_poli,
                                    jns.nm_perawatan,
                                    rawat_jl_dr.kd_jenis_prw 
                            ) AS combined_results
                            GROUP BY 
                                tgl_registrasi,
                                nm_pasien,
                                png_jawab,
                                nm_poli,
                                nm_perawatan,
                                kd_jenis_prw
                            ORDER BY 
                                tgl_registrasi;


                ";
                
                $hasil = bukaquery($query_ralan);
                $juml_row = mysqli_num_rows($hasil);
                $s = 1; 
                $totaltarif =0;
                $totaljm    =0;
                while ($data = mysqli_fetch_assoc($hasil)) {
                    $arr1[$s] = $data['tgl_registrasi'];
                    $arr2[$s] = $data['nm_pasien'];
                    $arr3[$s] = $data['png_jawab'];
                    $arr4[$s] = $data['nm_poli'];
                    $arr5[$s] = $data['nm_perawatan'];
                    $arr6[$s] = $data['tarif_tindakandr'];
                    $arr7[$s] = $data['bhp'];
                    $arr8[$s] = $data['total_byrdr'];
                    $arr9[$s] = $data['total'];
                    
                    // $totaltarif += $arr6[$s];
                    $totaljm += $arr6[$s];
                    $s++;                   
                }
                
                for ($i = 1; $i < $juml_row + 1; $i++) {
                    echo "
                        <tr>
                            <td>$i</td>
                            <td>$arr1[$i]</td>
                            <td>$arr2[$i]</td>
                            <td>$arr3[$i]</td>
                            <td>$arr4[$i]</td>
                            <td>$arr5[$i]</td>
                            <td>$arr9[$i]</td>
                            <td>$arr6[$i]</td>
                            
                        </tr>";
                }
                
                echo "
                          </tbody>
                
                          <tfoot>
                            <tr>
                                <th colspan='7'>Total : </th>
                                <th id='totalJm'>Rp " . number_format($totaljm, 0, ',', '.') . "</th>
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>";
    
    
    echo "
    <div class='row'>
      <div class='col-lg-12'>
        <div class='card card-primary'>
          <div class='card-header'>
            <h3 class='card-title'>JM Dokter Ranap : $awal - $akhir</h3>
    
            <div class='card-tools'>
              <button type='button' class='btn btn-tool' data-card-widget='collapse'>
                <i class='fas fa-minus'></i>
              </button>
              <button type='button' class='btn btn-tool' data-card-widget='remove'>
                <i class='fas fa-times'></i>
              </button>
            </div>
          </div>
          <div class='card-body'>
            <table id='example2' class='table table-bordered table-striped'>
              <thead>
                    <tr>
                        <th>No. </th>
                        <th>Tgl Registrasi</th>
                        <th>Nama Pasien</th>
                        <th>Jenis Bayar</th>
                        <th>Nama Tindakan</th>
                        <th>Jumlah</th>
                        <th>Tarif</th>
                        <th>JM Dokter</th>
                    </tr>
              </thead>
              <tbody>";
    
                $query_ranap = "SELECT 
                                    reg.tgl_registrasi,
                                    pasien.nm_pasien,
                                    pj.png_jawab,
                                    jnsranap.nm_perawatan,
                                    ranapdr.kd_jenis_prw,
                                    COUNT(ranapdr.kd_jenis_prw) as jml,
                                    SUM(ranapdr.bhp) as bhp,
                                    SUM(ranapdr.material) as material,
                                    ranapdr.biaya_rawat as total_byrdr,
                                    SUM(ranapdr.tarif_tindakandr) as tarif_tindakandr,
                                    SUM(ranapdr.biaya_rawat) as total
                                FROM 
                                    rawat_inap_dr as ranapdr
                                    INNER JOIN jns_perawatan_inap as jnsranap ON jnsranap.kd_jenis_prw = ranapdr.kd_jenis_prw 
                                    INNER JOIN reg_periksa as reg ON reg.no_rawat = ranapdr.no_rawat
                                    INNER JOIN pasien as pasien ON pasien.no_rkm_medis = reg.no_rkm_medis
                                    INNER JOIN penjab as pj ON pj.kd_pj = reg.kd_pj
                                WHERE 
                                    ranapdr.tarif_tindakandr > 0 
                                    AND ranapdr.kd_dokter = '$selectedDoctor'
                                    AND ranapdr.tgl_perawatan BETWEEN '$awal_new_format' AND '$akhir_new_format'
                                GROUP BY 
                                    pasien.nm_pasien,
                                    ranapdr.kd_jenis_prw 
                                
                                UNION ALL
                                
                                SELECT 
                                    reg.tgl_registrasi,
                                    pasien.nm_pasien,
                                    pj.png_jawab,
                                    jnsrnp.nm_perawatan,
                                    ranapdrpr.kd_jenis_prw,
                                    COUNT(ranapdrpr.kd_jenis_prw) as jml,
                                    SUM(ranapdrpr.bhp) as bhp,
                                    SUM(ranapdrpr.material) as material,
                                    ranapdrpr.biaya_rawat as total_byrdr,
                                    SUM(ranapdrpr.tarif_tindakandr) as tarif_tindakandr,
                                    SUM(ranapdrpr.biaya_rawat) as total
                                FROM 
                                    rawat_inap_drpr as ranapdrpr
                                    INNER JOIN jns_perawatan_inap as jnsrnp ON jnsrnp.kd_jenis_prw = ranapdrpr.kd_jenis_prw
                                    INNER JOIN reg_periksa as reg ON reg.no_rawat = ranapdrpr.no_rawat
                                    INNER JOIN pasien as pasien ON pasien.no_rkm_medis = reg.no_rkm_medis
                                    INNER JOIN penjab as pj ON pj.kd_pj = reg.kd_pj 
                                WHERE 
                                    ranapdrpr.tarif_tindakandr > 0 
                                    AND ranapdrpr.kd_dokter = '$selectedDoctor'
                                    AND ranapdrpr.tgl_perawatan BETWEEN '$awal_new_format' AND '$akhir_new_format'
                                GROUP BY 
                                    pasien.nm_pasien,
                                    ranapdrpr.kd_jenis_prw 
                                ORDER BY 
                                    tgl_registrasi,
                                    nm_perawatan;



                ";
                
                $hasil = bukaquery($query_ranap);
                $juml_row = mysqli_num_rows($hasil);
                $s = 1; 
                $totaltarif =0;
                $totaljml    =0;
                
                while ($data = mysqli_fetch_assoc($hasil)) {
                    $arr1[$s] = $data['tgl_registrasi'];
                    $arr2[$s] = $data['nm_pasien'];
                    $arr3[$s] = $data['png_jawab'];
                    $arr4[$s] = $data['jml'];
                    $arr5[$s] = $data['nm_perawatan'];
                    $arr6[$s] = $data['tarif_tindakandr'];
                    $arr7[$s] = $data['bhp'];
                    $arr8[$s] = $data['total_byrdr'];
                    $arr9[$s] = $data['total'];
                    $totaltarif += $arr6[$s];
                    $totaljml += $arr4[$s];
                    $s++;                   
                }
                
                for ($i = 1; $i < $juml_row + 1; $i++) {
                    echo "
                        <tr>
                            <td>$i</td>
                            <td>$arr1[$i]</td>
                            <td>$arr2[$i]</td>
                            <td>$arr3[$i]</td>
                            <td>$arr5[$i]</td>
                            <td>$arr4[$i]</td>
                            <td>$arr9[$i]</td>
                            <td>$arr6[$i]</td>
                            
                        </tr>";
                }
                
                echo "
                          </tbody>
                
                          <tfoot>
                            <tr>
                                <th colspan='5'>Total : </th>
                                <th>$totaljml</th>
                                <th></th>
                                <th id='totalJm'>Rp " . number_format($totaltarif, 0, ',', '.') . "</th>
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>";
    
         }
        ?>  
    </section>

    <!-- /.content -->
  </div>
  
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2022-2023 RSB Hasta Brata</strong>
    All rights reserved.
    <!--<div class="float-right d-none d-sm-inline-block">-->
    <!--  <b>Version</b> 3.2.0-->
    <!--</div>-->
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>

<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<!--<script src="plugins/jqvmap/jquery.vmap.min.js"></script>-->
<!--<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>-->
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
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<!--<script src="dist/js/demo.js"></script>-->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- date-range-picker -->
<script src="plugins/daterangepicker/daterangepicker.js"></script>
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
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    //Date picker
    $('#tglawal').datetimepicker({
        // format: 'YYYY-MM-DD'
        format: 'DD-MM-YYYY'
    });

    $('#tglakhir').datetimepicker({
        // format: 'YYYY-MM-DD'
        format: 'DD-MM-YYYY'
    });


    //Date and time picker
    $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
        //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  })
  
</script>
<!-- Page specific script -->
<script>

$(function () {
    // DataTable for #example1
    $("#example1").DataTable({
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        dom: 'Bfrtip', 
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        pageLength: 20,
        columns: [
            { width: "5%", targets: 0 },  // No.
            { width: "10%", targets: 1 }, // Tgl Registrasi
            { width: "15%", targets: 2 }, // Nama Pasien
            { width: "10%", targets: 3 }, // Jenis Bayar
            { width: "10%", targets: 4 }, // Ruang
            { width: "20%", targets: 5 }, // Nama Tindakan
            { width: "10%", targets: 6 }, // Tarif
            { width: "10%", targets: 7 }  // JM Dokter
        ]
    });
    
    // DataTable for #example2
    $("#example2").DataTable({
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        dom: 'Bfrtip', 
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        pageLength: 20,
        columns: [
            { width: "5%", targets: 0 },  // No.
            { width: "10%", targets: 1 }, // Tgl Registrasi
            { width: "15%", targets: 2 }, // Nama Pasien
            { width: "10%", targets: 3 }, // Jenis Bayar
            { width: "25%", targets: 4 }, // Ruang
            { width: "5%", targets: 5 }, // Nama Tindakan
            { width: "10%", targets: 6 }, // Tarif
            { width: "10%", targets: 7 }  // JM Dokter
        ]
    });
});

</script>

</html>
