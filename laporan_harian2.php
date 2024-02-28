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

            $bayar = $_POST['Cara_Bayar'];
            
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
                     <div class="input-group">
                        <label for="selectedDoctor">Cara Bayar</label>
                        <select class="form-control select2" style="width: 100%;" name="Cara_Bayar">
                            <?php
                
                            $query = "SELECT * FROM penjab 
                                WHERE STATUS='1'
                                AND kd_pj ='BPJ' OR kd_pj ='BPJ' OR kd_pj ='A10' 
                                OR kd_pj='A81' OR kd_pj='A01' OR kd_pj='A11'
                                OR kd_pj='A19' OR kd_pj='A20'";
                            
                            $hasilquery = bukaquery($query);
                            $juml_row = mysqli_num_rows($hasilquery);
                            // Check if there are rows in the result set
                            if ($juml_row > 0) {
                                // Loop through the rows and generate options
                                while ($row = mysqli_fetch_assoc($hasilquery)) {
                                    echo "<option value='" . $row["kd_pj"] . "'>" . $row["png_jawab"] . "</option>";
                                }
                            } else {
                                echo "<option>-</option>";
                            }
                    
                            ?>
                        </select>
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
      <div class='card-header'>";
      
        $qr_cr = "select png_jawab from penjab where status ='1' and kd_pj ='$bayar'";
        $hasil = bukaquery($qr_cr);
        $juml_row = mysqli_num_rows($hasil);
        
        if ($juml_row > 0) {
            $row = mysqli_fetch_assoc($hasil);
            $png_jawab = $row['png_jawab'];
            echo "<h3 class='card-title'>Jumlah dari tanggal : $awal - $akhir , dengan cara bayar : $png_jawab</h3>";
        } else {
            echo "<h3 class='card-title'>Jumlah dari tanggal : $awal - $akhir , dengan cara bayar : -</h3>";
        }
        echo"

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
                    <th>Nama Poli</th>

                    <th>Total Biaya</th>
                </tr>
          </thead>
          <tbody>";
            $caripoli="SELECT reg.kd_poli, poli.nm_poli
                FROM reg_periksa AS reg 
                INNER JOIN poliklinik AS poli ON poli.kd_poli = reg.kd_poli
                WHERE reg.tgl_registrasi between '$awal_new_format' and '$akhir_new_format'
                and poli.status ='1'
                
                GROUP BY reg.kd_poli
            ";
            
            $hasil = bukaquery($caripoli);
            $juml_row = mysqli_num_rows($hasil);
            $s = 1; 
            $allrad =0;
            $alllab    =0;
            $allfarm=0;
            $allopvk=0;
            
            while ($data = mysqli_fetch_assoc($hasil)) {
                $arr1[$s] = $data['kd_poli'];
                $arr2[$s] = $data['nm_poli'];
                
                //Total dr
                $query_dr ="select rawat_jl_dr.no_rawat,reg_periksa.no_rkm_medis,
                	pasien.nm_pasien,rawat_jl_dr.kd_jenis_prw,jns_perawatan.nm_perawatan,
                	rawat_jl_dr.kd_dokter,dokter.nm_dokter,rawat_jl_dr.tgl_perawatan,
                	rawat_jl_dr.jam_rawat,penjab.png_jawab,poliklinik.nm_poli,
                	rawat_jl_dr.material,rawat_jl_dr.bhp,rawat_jl_dr.tarif_tindakandr,
                	rawat_jl_dr.kso,rawat_jl_dr.menejemen,rawat_jl_dr.biaya_rawat
                	from pasien inner join reg_periksa on reg_periksa.no_rkm_medis=pasien.no_rkm_medis
                	inner join rawat_jl_dr on reg_periksa.no_rawat=rawat_jl_dr.no_rawat 
                	inner join dokter on rawat_jl_dr.kd_dokter=dokter.kd_dokter 
                	inner join jns_perawatan on rawat_jl_dr.kd_jenis_prw=jns_perawatan.kd_jenis_prw
                	inner join poliklinik on reg_periksa.kd_poli=poliklinik.kd_poli
                	inner join penjab on reg_periksa.kd_pj=penjab.kd_pj
                	where 
                -- 	concat(rawat_jl_dr.tgl_perawatan,' ',rawat_jl_dr.jam_rawat) 
                	rawat_jl_dr.tgl_perawatan
                	between '$awal_new_format' and '$akhir_new_format'  
                 	and poliklinik.kd_poli='$arr1[$s]'
                 	and reg_periksa.kd_pj='$bayar'
                	order by rawat_jl_dr.no_rawat 
                	desc";
                $hasildr = bukaquery($query_dr);
                $rowdr = mysqli_num_rows($hasildr);
                $a=1;
                $ttldr=0;
                while($dtdr = mysqli_fetch_assoc($hasildr)){
                    $ardr1[$a] = $dtdr['biaya_rawat'];
                    
                    $ttldr +=$ardr1[$a];
                    $a++;
                }
                
                $query_pr ="select rawat_jl_pr.no_rawat,reg_periksa.no_rkm_medis,
                    pasien.nm_pasien,rawat_jl_pr.kd_jenis_prw,jns_perawatan.nm_perawatan,
                    rawat_jl_pr.nip,petugas.nama,rawat_jl_pr.tgl_perawatan,
                    rawat_jl_pr.jam_rawat,penjab.png_jawab,poliklinik.nm_poli, 
                    rawat_jl_pr.material,rawat_jl_pr.bhp,rawat_jl_pr.tarif_tindakanpr,
                    rawat_jl_pr.kso,rawat_jl_pr.menejemen,rawat_jl_pr.biaya_rawat 
                    from pasien inner join reg_periksa on reg_periksa.no_rkm_medis=pasien.no_rkm_medis 
                    inner join rawat_jl_pr on rawat_jl_pr.no_rawat=reg_periksa.no_rawat 
                    inner join jns_perawatan on rawat_jl_pr.kd_jenis_prw=jns_perawatan.kd_jenis_prw 
                    inner join petugas on rawat_jl_pr.nip=petugas.nip 
                    inner join poliklinik on reg_periksa.kd_poli=poliklinik.kd_poli 
                    inner join penjab on reg_periksa.kd_pj=penjab.kd_pj 
                    where 
                    -- concat(rawat_jl_pr.tgl_perawatan,' ',rawat_jl_pr.jam_rawat) 
                	rawat_jl_pr.tgl_perawatan
                	between '$awal_new_format' and '$akhir_new_format' 
                 	and poliklinik.kd_poli='$arr1[$s]'
                 	and reg_periksa.kd_pj='$bayar'
                    order by rawat_jl_pr.no_rawat desc
                    
                ";
                $hasilpr = bukaquery($query_pr);
                $rowpr = mysqli_num_rows($hasilpr);
                $b=1;
                $ttlpr=0;
                while($dtpr = mysqli_fetch_assoc($hasilpr)){
                    $arpr1[$a] = $dtpr['biaya_rawat'];
                    
                    $ttlpr +=$arpr1[$a];
                    $b++;
                }
                
                $query_drpr ="select rawat_jl_drpr.no_rawat,reg_periksa.no_rkm_medis,
                    pasien.nm_pasien,rawat_jl_drpr.kd_jenis_prw,jns_perawatan.nm_perawatan,
                    rawat_jl_drpr.kd_dokter,dokter.nm_dokter,rawat_jl_drpr.nip,petugas.nama,rawat_jl_drpr.tgl_perawatan,
                    rawat_jl_drpr.jam_rawat,penjab.png_jawab,poliklinik.nm_poli, 
                    rawat_jl_drpr.material,rawat_jl_drpr.bhp,rawat_jl_drpr.tarif_tindakandr,rawat_jl_drpr.tarif_tindakanpr,
                    rawat_jl_drpr.kso,rawat_jl_drpr.menejemen,rawat_jl_drpr.biaya_rawat 
                    from pasien inner join reg_periksa on reg_periksa.no_rkm_medis=pasien.no_rkm_medis 
                    inner join rawat_jl_drpr on rawat_jl_drpr.no_rawat=reg_periksa.no_rawat 
                    inner join jns_perawatan on rawat_jl_drpr.kd_jenis_prw=jns_perawatan.kd_jenis_prw 
                    inner join dokter on rawat_jl_drpr.kd_dokter=dokter.kd_dokter 
                    inner join poliklinik on reg_periksa.kd_poli=poliklinik.kd_poli
                    inner join penjab on reg_periksa.kd_pj=penjab.kd_pj 
                    inner join petugas on rawat_jl_drpr.nip=petugas.nip 
                    where 
                    -- concat(rawat_jl_pr.tgl_perawatan,' ',rawat_jl_pr.jam_rawat) 
                    rawat_jl_drpr.tgl_perawatan
                    between '$awal_new_format' and '$akhir_new_format' 
                    and poliklinik.kd_poli='$arr1[$s]'
                    and reg_periksa.kd_pj='$bayar'
                    order by rawat_jl_drpr.no_rawat desc
                ";
                $hasildrpr = bukaquery($query_drpr);
                $rowdrpr = mysqli_num_rows($hasildrpr);
                $c=1;
                $ttldrpr=0;
                while($dtpr = mysqli_fetch_assoc($hasildrpr)){
                    $ardrpr1[$a] = $dtpr['biaya_rawat'];
                    
                    $ttldrpr +=$ardrpr1[$a];
                    $c++;
                }
                
                $query_farmasi ="select detail_pemberian_obat.kode_brng,databarang.nama_brng,sum(detail_pemberian_obat.jml) as jml,
                    (sum(detail_pemberian_obat.total)-sum(detail_pemberian_obat.embalase+detail_pemberian_obat.tuslah)) as biaya,
                    sum(detail_pemberian_obat.embalase) as embalase, sum(detail_pemberian_obat.tuslah) as tuslah,
                    sum(detail_pemberian_obat.total) as total 
                    from detail_pemberian_obat inner join reg_periksa on detail_pemberian_obat.no_rawat=reg_periksa.no_rawat 
                    inner join databarang on detail_pemberian_obat.kode_brng=databarang.kode_brng 
                    
                    where detail_pemberian_obat.status='Ralan' 
                    and reg_periksa.tgl_registrasi 
                    between '$awal_new_format' and '$akhir_new_format' 
                    and reg_periksa.kd_poli='$arr1[$s]'
                    and reg_periksa.kd_pj='$bayar'
                    group by detail_pemberian_obat.kode_brng 
                    order by databarang.nama_brng
                ";
                $hasilfarm = bukaquery($query_farmasi);
                $rowfarm = mysqli_num_rows($hasilfarm);
                $d=1;
                $ttlfarm=0;
                while($dtfarm = mysqli_fetch_assoc($hasilfarm)){
                    $arfarm1[$a] = $dtfarm['total'];
                    $allfarm += $arfarm1[$a];
                    $ttlfarm +=$arfarm1[$a];
                    $d++;
                }
                
                $query_rad ="select periksa_radiologi.no_rawat,reg_periksa.no_rkm_medis,pasien.nm_pasien, 
                    periksa_radiologi.kd_jenis_prw,jns_perawatan_radiologi.nm_perawatan, 
                    periksa_radiologi.kd_dokter,dokter.nm_dokter,periksa_radiologi.nip,
                    petugas.nama,periksa_radiologi.dokter_perujuk,perujuk.nm_dokter as perujuk,
                    periksa_radiologi.tgl_periksa,periksa_radiologi.jam,penjab.png_jawab,
                    periksa_radiologi.bagian_rs,periksa_radiologi.bhp,periksa_radiologi.tarif_perujuk,
                    periksa_radiologi.tarif_tindakan_dokter,periksa_radiologi.tarif_tindakan_petugas,
                    periksa_radiologi.kso,periksa_radiologi.menejemen,periksa_radiologi.biaya,
                    if(periksa_radiologi.status='Ralan',(select nm_poli from poliklinik where poliklinik.kd_poli=reg_periksa.kd_poli),
                    (select bangsal.nm_bangsal from kamar_inap inner join kamar inner join bangsal on kamar_inap.kd_kamar=kamar.kd_kamar 
                    and kamar.kd_bangsal=bangsal.kd_bangsal where kamar_inap.no_rawat=periksa_radiologi.no_rawat limit 1 )) as ruangan 
                    from periksa_radiologi inner join reg_periksa on periksa_radiologi.no_rawat=reg_periksa.no_rawat 
                    inner join pasien on reg_periksa.no_rkm_medis=pasien.no_rkm_medis 
                    inner join dokter on periksa_radiologi.kd_dokter=dokter.kd_dokter 
                    inner join dokter as perujuk on periksa_radiologi.dokter_perujuk=perujuk.kd_dokter
                    inner join petugas on periksa_radiologi.nip=petugas.nip 
                    inner join penjab on reg_periksa.kd_pj=penjab.kd_pj 
                    inner join jns_perawatan_radiologi on periksa_radiologi.kd_jenis_prw=jns_perawatan_radiologi.kd_jenis_prw 
                    where 
                    -- concat(periksa_radiologi.tgl_periksa,' ',periksa_radiologi.jam) 
                    periksa_radiologi.tgl_periksa
                    between '$awal_new_format' and '$akhir_new_format' 
                    and reg_periksa.kd_poli='$arr1[$s]'
                    and periksa_radiologi.status='Ralan'
                    and reg_periksa.kd_pj='$bayar'
                    order by periksa_radiologi.tgl_periksa
                ";
                $hasilrad = bukaquery($query_rad);
                $rowrad = mysqli_num_rows($hasilrad);
                $e=1;
                $ttlrad=0;
                while($dtrad = mysqli_fetch_assoc($hasilrad)){
                    $arrad1[$a] = $dtrad['biaya'];
                    $allrad +=$arrad1[$a];
                    $ttlrad +=$arrad1[$a];
                    $e++;
                }
                // Lab
                $query_lab ="select periksa_lab.no_rawat,reg_periksa.no_rkm_medis,pasien.nm_pasien, 
                    periksa_lab.kd_jenis_prw,jns_perawatan_lab.nm_perawatan, 
                    periksa_lab.kd_dokter,dokter.nm_dokter,periksa_lab.nip,
                    petugas.nama,periksa_lab.dokter_perujuk,perujuk.nm_dokter as perujuk,
                    periksa_lab.tgl_periksa,periksa_lab.jam,penjab.png_jawab,
                    periksa_lab.bagian_rs,periksa_lab.bhp,periksa_lab.tarif_perujuk,
                    periksa_lab.tarif_tindakan_dokter,periksa_lab.tarif_tindakan_petugas,
                    periksa_lab.kso,periksa_lab.menejemen,periksa_lab.biaya,
                    if(periksa_lab.status='Ralan',(select nm_poli from poliklinik where poliklinik.kd_poli=reg_periksa.kd_poli),
                    (select bangsal.nm_bangsal from kamar_inap inner join kamar inner join bangsal on kamar_inap.kd_kamar=kamar.kd_kamar 
                    and kamar.kd_bangsal=bangsal.kd_bangsal where kamar_inap.no_rawat=periksa_lab.no_rawat limit 1 )) as ruangan 
                    from periksa_lab inner join reg_periksa on periksa_lab.no_rawat=reg_periksa.no_rawat 
                    inner join pasien on reg_periksa.no_rkm_medis=pasien.no_rkm_medis 
                    inner join dokter on periksa_lab.kd_dokter=dokter.kd_dokter 
                    inner join dokter as perujuk on periksa_lab.dokter_perujuk=perujuk.kd_dokter 
                    inner join petugas on periksa_lab.nip=petugas.nip 
                    inner join penjab on reg_periksa.kd_pj=penjab.kd_pj 
                    inner join jns_perawatan_lab on periksa_lab.kd_jenis_prw=jns_perawatan_lab.kd_jenis_prw 
                    where 
                    -- concat(periksa_lab.tgl_periksa,' ',periksa_lab.jam)
                    periksa_lab.tgl_periksa 
                    between '$awal_new_format' and '$akhir_new_format' 
                    and reg_periksa.kd_poli='$arr1[$s]'
                    and periksa_lab.status='Ralan'
                    and reg_periksa.kd_pj='$bayar'
                    order by periksa_lab.tgl_periksa
                ";
                $hasillab = bukaquery($query_lab);
                $rowlab = mysqli_num_rows($hasillab);
                $f=1;
                $ttllab=0;
                while($dtlab = mysqli_fetch_assoc($hasillab)){
                    $arrlab[$a] = $dtlab['biaya'];
                    $alllab +=$arrlab[$a];
                    $ttllab +=$arrlab[$a];
                    $f++;
                }
                $ttlsmua = 0;
                $ttlsmua += $ttldr + $ttlpr + $ttldrpr;
                
                
                // 
                $jamawal='00:00:00';
                $jamakhir='23:59:59';
                $tglawalbaru=$awal_new_format.' '.$jamawal;
                $tglakhirbaru=$akhir_new_format.' '.$jamakhir;
                $query_opvk ="select operasi.no_rawat,reg_periksa.no_rkm_medis,pasien.nm_pasien, 
                    operasi.kode_paket,paket_operasi.nm_perawatan,operasi.tgl_operasi, 
                    penjab.png_jawab,if(operasi.status='Ralan',(select nm_poli from poliklinik where poliklinik.kd_poli=reg_periksa.kd_poli),
                    (select bangsal.nm_bangsal from kamar_inap inner join kamar inner join bangsal on kamar_inap.kd_kamar=kamar.kd_kamar 
                    and kamar.kd_bangsal=bangsal.kd_bangsal where kamar_inap.no_rawat=operasi.no_rawat limit 1 )) as ruangan,
                    operator1.nm_dokter as operator1,operasi.biayaoperator1, 
                    operator2.nm_dokter as operator2,operasi.biayaoperator2, 
                    operator3.nm_dokter as operator3,operasi.biayaoperator3,
                    asisten_operator1.nama as asisten_operator1,operasi.biayaasisten_operator1, 
                    asisten_operator2.nama as asisten_operator2,operasi.biayaasisten_operator2, 
                    asisten_operator3.nama as asisten_operator3,operasi.biayaasisten_operator3, 
                    instrumen.nama as instrumen,operasi.biayainstrumen, 
                    dokter_anak.nm_dokter as dokter_anak,operasi.biayadokter_anak, 
                    perawaat_resusitas.nama as perawaat_resusitas,operasi.biayaperawaat_resusitas, 
                    dokter_anestesi.nm_dokter as dokter_anestesi,operasi.biayadokter_anestesi, 
                    asisten_anestesi.nama as asisten_anestesi,operasi.biayaasisten_anestesi, 
                    (select nama from petugas where petugas.nip=operasi.asisten_anestesi2) as asisten_anestesi2,operasi.biayaasisten_anestesi2, 
                    bidan.nama as bidan,operasi.biayabidan, 
                    (select nama from petugas where petugas.nip=operasi.bidan2) as bidan2,operasi.biayabidan2, 
                    (select nama from petugas where petugas.nip=operasi.bidan3) as bidan3,operasi.biayabidan3, 
                    (select nama from petugas where petugas.nip=operasi.perawat_luar) as perawat_luar,operasi.biayaperawat_luar, 
                    (select nama from petugas where petugas.nip=operasi.omloop) as omloop,operasi.biaya_omloop, 
                    (select nama from petugas where petugas.nip=operasi.omloop2) as omloop2,operasi.biaya_omloop2, 
                    (select nama from petugas where petugas.nip=operasi.omloop3) as omloop3,operasi.biaya_omloop3, 
                    (select nama from petugas where petugas.nip=operasi.omloop4) as omloop4,operasi.biaya_omloop4, 
                    (select nama from petugas where petugas.nip=operasi.omloop5) as omloop5,operasi.biaya_omloop5, 
                    (select nm_dokter from dokter where dokter.kd_dokter=operasi.dokter_pjanak) as dokter_pjanak,operasi.biaya_dokter_pjanak,
                    (select nm_dokter from dokter where dokter.kd_dokter=operasi.dokter_umum) as dokter_umum,operasi.biaya_dokter_umum,
                    operasi.biayaalat,operasi.biayasewaok,operasi.akomodasi,operasi.bagian_rs,operasi.biayasarpras
                    from operasi 
                    inner join reg_periksa on operasi.no_rawat=reg_periksa.no_rawat 
                    inner join pasien on reg_periksa.no_rkm_medis=pasien.no_rkm_medis 
                    inner join paket_operasi on operasi.kode_paket=paket_operasi.kode_paket
                    inner join penjab on reg_periksa.kd_pj=penjab.kd_pj 
                    inner join dokter as operator1 on operator1.kd_dokter=operasi.operator1
                    inner join dokter as operator2 on operator2.kd_dokter=operasi.operator2 
                    inner join dokter as operator3 on operator3.kd_dokter=operasi.operator3 
                    inner join dokter as dokter_anak on dokter_anak.kd_dokter=operasi.dokter_anak 
                    inner join dokter as dokter_anestesi on dokter_anestesi.kd_dokter=operasi.dokter_anestesi 
                    inner join petugas as asisten_operator1 on asisten_operator1.nip=operasi.asisten_operator1 
                    inner join petugas as asisten_operator2 on asisten_operator2.nip=operasi.asisten_operator2 
                    inner join petugas as asisten_operator3 on asisten_operator3.nip=operasi.asisten_operator3 
                    inner join petugas as asisten_anestesi on asisten_anestesi.nip=operasi.asisten_anestesi 
                    inner join petugas as bidan on bidan.nip=operasi.bidan 
                    inner join petugas as instrumen on instrumen.nip=operasi.instrumen 
                    inner join petugas as perawaat_resusitas on perawaat_resusitas.nip=operasi.perawaat_resusitas 
                    where 
                    operasi.tgl_operasi BETWEEN '$tglawalbaru' AND '$tglakhirbaru'
                    and reg_periksa.kd_poli ='$arr1[$s]'
                    and reg_periksa.kd_pj='$bayar'
                    order by operasi.no_rawat desc
                ";
                $hasilopvk = bukaquery($query_opvk);
                $rowopvk = mysqli_num_rows($hasilopvk);
                $g=1;
                $ttlopvk=0;
                while($dtopvk = mysqli_fetch_assoc($hasilopvk)){
                    $arropvk[$a] = $dtopvk['biayasewaok'];
                    $allopvk +=$arropvk[$a];
                    $ttlopvk +=$arropvk[$a];
                    $g++;
                }
                
                echo"
                <tr>
                    <td>$s</td>
                    <td>$arr2[$s]</td>

                    <td>" . ($ttlsmua + $ttlfarm + $ttlrad + $ttllab) . "</td>
                </tr>
                ";        




                $s++;    
                
                //Kamar Operasi
                
                
                
                
            }
            
            $qr_loket = "SELECT SUM(biaya_reg) AS total_biaya 
            FROM reg_periksa 
            WHERE tgl_registrasi between '$awal_new_format' and '$akhir_new_format'
            and reg_periksa.kd_pj='$bayar'
            ";
            $Loket = bukaquery($qr_loket);
            $rowloket = mysqli_fetch_assoc($Loket);
            $allok = $rowloket['total_biaya'];
            
            
            echo " 
                <tr>
                    <td>$s</td>  
                    <td>Loket</td>
                    <td>$allok</td>
                </tr>
                <tr>
                    <td>".($s + 1) ."</td>  
                    <td>Lab</td>
                    <td>$alllab</td>
                </tr>
                <tr>
                    <td>".($s + 2) ."</td>   
                    <td>Rad</td>
                    <td>$allrad</td>
                </tr>
                <tr>
                    <td>".($s + 3) ."</td>  
                    <td>K.Operasi</td>
                    <td>$allopvk</td>
                </tr>
                <tr>
                    <td>".($s + 4) ."</td>  
                    <td>Obat + AHP</td>
                    <td>$allfarm</td>
                </tr>
                <tr>
                    <td>".($s + 5) ."</td>  
                    <td>Ambulance</td>
                    <td></td>
                </tr>
                      </tbody>
            
                      <tfoot>
                        <tr>
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
    $("#example1").DataTable({
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        dom: 'Bfrtip', 
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        pageLength: 20,  // Set the number of items per page
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
