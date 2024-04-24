
    <?php
    require_once('../conf/config.php');
    date_default_timezone_set("Asia/Jakarta");
    header('Content-Type: application/json; charset=utf-8');

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
    $data = array(
        "success" => true,
        "data" => $rows
    );
    echo json_encode($data);
    ?>