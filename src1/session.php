<?php

include ("koneksi.php");
 
session_start();
// contoh array 
/*$item   = $_POST['nim', 'nama', 'th_masuk', 'semester', 'jurusan_asalsekolah', 'ips1
ipk',' tot_sks', 'jumD', 'jumE', 'status'];*/


    $nim = $_POST["nim"];
    $nama = $_POST["nama"];
    $th_masuk = $_POST["th_masuk"];
    $semester = $_POST["semester"];
    $jurusan_asalsekolah = $_POST["jurusan_asalsekolah"];
    $ips1 = $_POST["ips1"];
    $ipk = $_POST["ipk"];
    $tot_sks = $_POST["tot_sks"];
    $jumD = $_POST["jumD"];
    $jumE = $_POST["jumE"];
    $status = $_POST["status"];
$datatesting = array($nim,$nama,$th_masuk,$semester, $jurusan_asalsekolah, $ips1, $ipk, $tot_sks, $jumD, $jumE, $status);
// selipkan array kedalam session
$_SESSION['datatesting'] = $datatesting;
 
// tampilkan array dengan teknik looping
foreach ($_SESSION['datatesting'] as $testing) {
    echo $testing;
    echo "<br/>";
}
 
?>