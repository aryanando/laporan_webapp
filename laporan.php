<?php
 
 
 require_once('config.php');
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

            // Perform a query to get your data
            // $query = "SELECT label_column, data_column FROM your_table";
            // $result = mysqli_query($your_db_connection, $query);
            
            // // Fetch the data into an associative array
            // $data = array();
            // while ($row = mysqli_fetch_assoc($result)) {
            //     $data[] = $row;
            // }
            
            // // Convert the PHP array to a JSON string for JavaScript
            // $data_json = json_encode($data);
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
                <div class="form-group">
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
                    </div>
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
                <h3 class='card-title'>Jumlah Pasien dari tanggal : $awal - $akhir</h3>

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
                    <th>Poli</th>
                    <th>Jumlah</th>
                  </tr>
                  </thead>
                  <tbody>";
                    $_sql="select  poli.nm_poli poli, count(reg.no_rawat) as kunjungan from reg_periksa as reg 
                            inner join poliklinik as poli on reg.kd_poli = poli.kd_poli
                            where 
                            reg.tgl_registrasi between '$awal_new_format' and '$akhir_new_format'
                            group by poli.nm_poli"; 
                        $hasil=bukaquery($_sql);
                                $juml_row=mysqli_num_rows($hasil);
                                $s=1; 
                                $totalKunjungan = 0;
                                    while ($data = mysqli_fetch_assoc($hasil)) {
                                    $arr1[$s]=$data['poli'];
                                    $arr2[$s]=$data['kunjungan'];
                                    $totalKunjungan += $arr2[$s]; // Move this line here
                                    $s++;                   

                                    }
                                    for($i=1; $i<$juml_row+1; $i++){
                                        echo "
                                        <tr>
                                            <td>$i</td>
                                            <td>$arr1[$i]</td>
                                            <td>$arr2[$i]</td>
                                        </tr>";
                                    }
                
                
                  
                  echo "
                  </tbody>
                   

                  <tfoot>
                  <tr>
                    <th colspan='2'>Total Kunjungan : </th>
                    <th>$totalKunjungan</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
         </div>
        ";
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
  })
  
</script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,"paging" :false
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
<script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

    var areaChartData = {
      labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [
        {
          label               : 'Digital Goods',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [28, 48, 40, 19, 86, 27, 90]
        },
        {
          label               : 'Electronics',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [65, 59, 80, 81, 56, 55, 40]
        },
      ]
    }

    var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }

    // This will get the first returned node in the jQuery collection.
    new Chart(areaChartCanvas, {
      type: 'line',
      data: areaChartData,
      options: areaChartOptions
    })

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
    var lineChartOptions = $.extend(true, {}, areaChartOptions)
    var lineChartData = $.extend(true, {}, areaChartData)
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartOptions.datasetFill = false

    var lineChart = new Chart(lineChartCanvas, {
      type: 'line',
      data: lineChartData,
      options: lineChartOptions
    })

    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
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
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    })

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = donutData;
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

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })

    //---------------------
    //- STACKED BAR CHART -
    //---------------------
    var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
    var stackedBarChartData = $.extend(true, {}, barChartData)

    var stackedBarChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      scales: {
        xAxes: [{
          stacked: true,
        }],
        yAxes: [{
          stacked: true
        }]
      }
    }

    new Chart(stackedBarChartCanvas, {
      type: 'bar',
      data: stackedBarChartData,
      options: stackedBarChartOptions
    })
  })
</script>
</body>
</html>
