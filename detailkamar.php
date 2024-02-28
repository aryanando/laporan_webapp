<?php

 session_start();
  require_once('conf/config.php');
 //header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
// header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); 
 //header("Cache-Control: no-store, no-cache, must-revalidate"); 
 //header("Cache-Control: post-check=0, pre-check=0", false);
 //header("Pragma: no-cache"); // HTTP/1.0
 date_default_timezone_set("Asia/Bangkok");
 $tanggal= mktime(date("m"),date("d"),date("Y"));
 $jam=date("H:i");
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="css/default.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="conf/validator.js"></script>
    <meta http-equiv="refresh" content="20"/>
    <title>Informasi Ketersediaan Kamar</title>
    <script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
    <script src="Scripts/AC_ActiveX.js" type="text/javascript"></script>
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
	<style type="text/css">
	<!--
	body {
		background-image: url();
		background-repeat: no-repeat;
		background-color: #FFFFFF;
	}
	-->
	</style>
	
</head>
<body>

<div align="left">
	<script type="text/javascript">
		AC_AX_RunContent( 'width','32','height','32' ); //end AC code
	</script>
	<noscript>
       <object width="32" height="32">
         <embed width="32" height="32"></embed>
       </object>
     </noscript>



	<div class="card bg-gradient-primary">
              <div class="card-header border-0">
                <h3 class="card-title">
                  <i class="fas fa-map-marker-alt mr-1"></i>
                  Info Kamar per 
                    <?php
                      echo "   
                      <font  size='3'  face='Tahoma'>".date("d-M-Y", $tanggal)."  ". $jam."</font>
                       "; 
                    ?>
                </h3>
                <!-- card tools -->
                <div class="card-tools">
                  <button type="button" class="btn btn-primary btn-sm daterange" title="Date range">
                    <i class="far fa-calendar-alt"></i>
                  </button>
                  <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
			  
			<div class="card-body">
              <table class="table" rules="all" rules="none" border="1" style="border-color: #FFFFFF; color:#FFFFFF;">
                <thead>
                  <tr style="border-top: solid 1px; border-bottom: solid 1px;">
                        <td align='left'style="background-color: #008080;" width='15%'><b>Nama Kamar</b></td>
                        <td align='center'style="background-color: #008080;" width='5%'><b>Jumlah Bed</b></td>
                        <td align='center'style="background-color: #008080;" width='60%'><b>Detail Bed</b></td>
                        <td align='center'style="background-color: #008080;"><b>Bed Isi</b></td>
                        <td align='center'style="background-color: #008080;"><b>Bed Kosong</b></td>
                </thead>
	
			</div>
	</div>
	

	<?php  
		$_sql="Select * From bangsal where status='1' and kd_bangsal not like '%ODC%' and kd_bangsal not like '%ISO%' and kd_bangsal in(select kd_bangsal from kamar) order by nm_bangsal" ;  
		$hasil=bukaquery($_sql);
		#echo"<tr><td>asd</td> </tr>";
		while ($data = mysqli_fetch_array ($hasil)){
			echo "<tr >
					<td align='left'><font size='3' face='Tahoma'><b>".$data['nm_bangsal']."</b></font></td>
					<td align='center'>
					     <font size='3' face='Tahoma'>
					      <b>";
					       $data3=mysqli_fetch_array(bukaquery("select count(kd_bangsal) from kamar where kamar.statusdata='1' and kd_bangsal='".$data['kd_bangsal']."'"));
					       #echo $data['nm_bangsal'];
						   echo $data3[0];
					echo "</b>
					      </font>
					</td>
					
					<td >
					     <font size='3'  face='Tahoma'>
					      <b>";
						$data4=mysqli_fetch_array(bukaquery("select count(kd_bangsal) from kamar where kamar.statusdata='1' and kd_bangsal='".$data['kd_bangsal']."' and status='ISI'")); 
						
						$data5=mysqli_fetch_array(bukaquery("select count(kd_bangsal) from kamar where kamar.statusdata='1' and kd_bangsal='".$data['kd_bangsal']."' and status='KOSONG'"));						
						for($i=0;$i<$data4[0];$i++){
							//isi
							echo"
						   <a class='btn btn-dark btn-lg' style='color:#000000'> </a>
						   ";
						}
						for($j=0;$j<$data5[0];$j++){
							//kosong
							echo"
						   <a class='btn btn-default btn-lg' style='color:#000000'> </a>
						   ";
						}
						   
					echo "</b>
					      </font>
					</td>
					<td align='center' >
					      <font size='3'  face='Tahoma'>
					      <b>";
						   
						   echo $data4[0];
					echo "</b>
					     </font>
					</td>
					<td align='center' >
					      <font size='3'  face='Tahoma'>
					      <b>";
						   
						   echo $data5[0];
					echo "</b>
					     </font>
					</td>
				</tr> ";
		}
	?>
	</table>
	<!--<table width='100%' bgcolor='FFFFFF' border='0' align='center' cellpadding='0' cellspacing='0'>
	     <tr class='head5'>
              <td width='100%'><div align='center'></div></td>
         </tr>
    </table>
	<img src="ft-2.jpg" alt="bar-pic" width="100%" height="83">-->
	
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
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script src="dist/js/circles.min.js"></script>
</body>

</html>