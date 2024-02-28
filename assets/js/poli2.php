<?php
 session_start();
require_once('config.php');
 header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
 header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); 
 header("Cache-Control: no-store, no-cache, must-revalidate"); 
 header("Cache-Control: post-check=0, pre-check=0", false);
 header("Pragma: no-cache"); // HTTP/1.0
 $tanggal= mktime(date("m"),date("d"),date("Y"));
 date_default_timezone_set('Asia/Jakarta');
 $jam=date("H:i");
?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <!--<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">-->
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="css/default.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="conf/validator.js"></script>
    <meta http-equiv="refresh" content="60"/>
    <script src="assets/js/AC_RunActiveContent.js" type="text/javascript"></script>
    <script src="assets/js/AC_ActiveX.js" type="text/javascript"></script>
    <script src='assets/js//responsivevoice.js'></script>

  <title>AdminLTE 3 | Top Navigation</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
      

</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="index3.html" class="navbar-brand">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="index3.html" class="nav-link">Home</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">Contact</a>
          </li>
          
        </ul>

        <!-- SEARCH FORM 
        <form class="form-inline ml-0 ml-md-3">
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </form>-->
      </div>

      <!-- Right navbar links -->
      
    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"> Top Navigation <small>Example 3.0</small></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Layout</a></li>
              <li class="breadcrumb-item active">Top Navigation</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
             <!-- <div class="card-header">
                 <h3 class="card-title">DataTable with minimal features & hover style</h3>
              </div>-->
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-hover">
                  <thead>
				  <!-- HEAD -->
                  <tr>
                    <th>Nama Dokter</th>
                    <th>Poliklinik</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th>Register</th>
                  </tr>
                  </thead>
                  <tbody>
						<?php  
						$hari=getOne("select DAYNAME(current_date())");
						$namahari="";
						if($hari=="Sunday"){
							$namahari="AKHAD";
						}else if($hari=="Monday"){
							$namahari="SENIN";
						}else if($hari=="Tuesday"){
							$namahari="SELASA";
						}else if($hari=="Wednesday"){
							$namahari="RABU";
						}else if($hari=="Thursday"){
							$namahari="KAMIS";
						}else if($hari=="Friday"){
							$namahari="JUMAT";
						}else if($hari=="Saturday"){
							$namahari="SABTU";
						}
						$_sql="Select dokter.nm_dokter,poliklinik.nm_poli,jadwal.jam_mulai,jadwal.jam_selesai,poliklinik.kd_poli, 
							   dokter.kd_dokter from jadwal inner join dokter inner join poliklinik on dokter.kd_dokter=jadwal.kd_dokter 
							   and jadwal.kd_poli=poliklinik.kd_poli where jadwal.hari_kerja='$namahari'" ;  
						$hasil=bukaquery($_sql);

						while ($data = mysqli_fetch_array ($hasil)){
							echo "<tr >
												<td align='left'><font size='5' color='#BB00BB' face='Tahoma'><a href='antrian2.php?iyem=".encrypt_decrypt("{\"kd_poli\":\"".$data['kd_poli']."\",\"kd_dokter\":\"".$data['kd_dokter']."\"}","e")."'>".$data['nm_dokter']."</a></font></td>
												<td align='center'><font size='5' color='gray' face='Tahoma'>".$data['nm_poli']."</font></td>
												<td align='center'><font color='#DDDD00' size='5'  face='Tahoma'>".$data['jam_mulai']."</font></td>
												<td align='center'><font color='gren' size='5'  face='Tahoma'>".$data['jam_selesai']."</font></td>
												<td align='center'><font color='#555555' size='5'  face='Tahoma'>". getOne("select count(*) from reg_periksa where kd_poli='".$data['kd_poli']."' and kd_dokter='".$data['kd_dokter']."' and tgl_registrasi='".date("Y-m-d", $tanggal)."'")."</font></td>
								</tr> ";
						}
					?>
                  </tbody>
                  <tfoot>
                  <!--<tr>
                    <th>Rendering engine</th>
                    <th>Browser</th>
                    <th>Platform(s)</th>
                    <th>Engine version</th>
                    <th>CSS grade</th>
                  </tr>-->
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
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
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2022 </strong> RSB Hasta Brata
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
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
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,"paging": false,
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
	
</body>
</html>
