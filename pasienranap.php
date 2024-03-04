<?php


require_once('conf/config.php');
//header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
//header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); 
//header("Cache-Control: no-store, no-cache, must-revalidate"); 
//header("Cache-Control: post-check=0, pre-check=0", false);
//header("Pragma: no-cache"); // HTTP/1.0
date_default_timezone_set("Asia/Jakarta");
$tanggal = mktime(date("m"), date("d"), date("Y"));
$jam = date("H:i");
$hariini = date("Y-m-d");
$tgl = date("d-M-Y");
$sebulanlalu = date('Y-m-d', strtotime("-30 day", strtotime(date("Y-m-d"))));
$bulanini = date('m');
$tahunini = date('Y');
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
$user = $_SESSION["user_data"];
?>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pasien Ranap</title>

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
            <h1 class="m-0">Pasien Rawat Inap</h1>
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

    <!-- /.row -->
    <!-- table-->
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data Pasien Hari ini</h3>
          </div>
          <div class="card-body">
            <?php
            if ($user['role'] == 'gizi') {
            ?>
              <button type="button" class="btn btn-secondary" onclick="window.location='https://dev.batubhayangkara.com/kuesioner/data-kepuasan-pasien-gizi/KBLrQhzbcwvgHvEXXFA6QSy37GfViwMYr5qxzdQs25AtpR0UDGYqWlMXpwc7k02i'">Lihat Data Kuesioner Gizi</button>
            <?php
            }
            ?>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No. </th>
                  <th>No Rawat</th>
                  <th>Nama Pasien</th>
                  <th>Nama Kamar</th>
                  <th>Kode Kamar</th>
                  <th>Alamat Pasien</th>
                  <th>Penanggung Jawab</th>
                  <?= $user['role'] == 'gizi' ? '<th>Action</th>' : ''  ?>
                </tr>
              </thead>

              <?php
              $_sql = "select ran.no_rawat as no_rawat, pasien.nm_pasien as nama, 
                         bgl.nm_bangsal as bgsl, bgl.kd_bangsal as kdbgs, pasien.alamat as alamat, reg.p_jawab as pj,
                                kel.nm_kel as kel,kec.nm_kec as kec,kab.nm_kab as kab,prop.nm_prop as prov
                                
                                from kamar_inap as ran
                                	inner join reg_periksa as reg on ran.no_rawat = reg.no_rawat
                                	inner join pasien as pasien on pasien.no_rkm_medis= reg.no_rkm_medis
                                	inner join kamar as kmr on ran.kd_kamar = kmr.kd_kamar
                                	inner join bangsal as bgl on bgl.kd_bangsal = kmr.kd_bangsal
                                	inner join kelurahan as kel on pasien.kd_kel = kel.kd_kel
                                	inner join kecamatan as kec on pasien.kd_kec = kec.kd_kec
                                	inner join kabupaten as kab on pasien.kd_kab = kab.kd_kab
                                	inner join propinsi as prop on pasien.kd_prop = prop.kd_prop
                                
                                where tgl_keluar='0000-00-00'and stts_pulang ='-'
                                order by bgl.nm_bangsal";
              $hasil = (bukaquery($_sql));
              $rows = array();
              while ($row = mysqli_fetch_assoc($hasil)) {
                $rows[] = $row;
              }
              // var_dump($rows);
              $no = 1;
              foreach ($rows as $dataPasien) {
              ?>

                <tr>
                  <td><?= $no ?></td>
                  <td><?= $dataPasien['no_rawat'] ?></td>
                  <td><?= $dataPasien['nama'] ?></td>
                  <td><?= $dataPasien['bgsl'] ?></td>
                  <td><?= $dataPasien['kdbgs'] ?></td>
                  <td><?= $dataPasien['alamat'] . ', ' . $dataPasien['kel'] . ', ' . $dataPasien['kec'] . ', ' . $dataPasien['kab'] . ', ' . $dataPasien['prov'] ?></td>
                  <td><?= $dataPasien['pj'] ?></td>
                  <?= $user['role'] == 'gizi' ? '<td><a href="' . getKuesionerURL() . '/kuesioner/kepuasan-pasien-gizi/' . str_replace("/", "", $dataPasien['no_rawat']) . '?nama=' . $dataPasien['nama'] . '&bgsl=' . $dataPasien['bgsl'] . '" type="button" class="btn btn-primary">Review Makanan</a><td>' : ''  ?>

                </tr>
              <?php
                $no++;
              }


              // var_dump($hasil);
              // die;

              // $juml_row = mysqli_num_rows($hasil);
              // $s = 1;

              // while ($data = mysqli_fetch_assoc($hasil)) {
              //   // $arr1[$s]=$data['norawat'];
              //   $arr2[$s] = $data['nama'];
              //   $arr3[$s] = $data['bgsl'];
              //   $arr4[$s] = $data['kdbgs'];
              //   $arr5[$s] = $data['alamat'];
              //   $arr6[$s] = $data['pj'];
              //   $arr7[$s] = $data['kel'];
              //   $arr8[$s] = $data['kec'];
              //   $arr9[$s] = $data['kab'];
              //   $arr10[$s] = $data['prov'];
              //   $s++;
              // }
              // for ($i = 1; $i < $juml_row + 1; $i++) {
              //   var_dump($data);

              //   // <td>$arr1[$i]</td>
              //   echo "
              //                         <tr>
              //                             <td>$i</td>
              //                             <td>$arr2[$i]</td>
              //                             <td>$arr3[$i]</td>
              //                             <td>$arr4[$i]</td>
              //                             <td>$arr5[$i], $arr7[$i], $arr8[$i], $arr9[$i], $arr10[$i]</td>
              //                             <td>$arr6[$i]</td>
              //                         </tr>";
              // }

              // 
              ?>

              </tbody>



            </table>
            <?php
            if ($user['role'] == 'gizi') {
            ?>
              <button type="button" class="btn btn-secondary" onclick="window.location='https://dev.batubhayangkara.com/kuesioner/data-kepuasan-pasien-gizi/KBLrQhzbcwvgHvEXXFA6QSy37GfViwMYr5qxzdQs25AtpR0UDGYqWlMXpwc7k02i'">Lihat Data Kuesioner Gizi</button>
            <?php
            }
            ?>
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

  <!-- Chart JS -->
  <script src="plugins/chart.js/Chart.min.js"></script>
  <!-- Page specific script -->
  <script>
    $(function() {
      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "paging": false
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