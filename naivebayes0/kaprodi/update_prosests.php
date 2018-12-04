<?php
  	require_once "../koneksi.php";
	$aksi = $_POST['perbaharui'];
	$nim = $_POST["nim"];
	$nama = $_POST["nama"];
	$th_masuk = $_POST["th_masuk"];
	$semester = $_POST["semester"];
	$jurusan_asalsekolah = $_POST["jurusan_asalsekolah"];
	$prodi = $_POST["prodi"];
	$ips1 = $_POST["ips1"];
	$ipk = $_POST["ipk"];
	$tot_sks = $_POST["tot_sks"];
	$jumD = $_POST["jumD"];
	$jumE = $_POST["jumE"];
	$status = $_POST["status"];

	$query = "UPDATE Mahasiswa SET
				nama = '$nama',
				th_masuk= '$th_masuk',
				semester='$semester',
				jurusan_asalsekolah= '$jurusan_asalsekolah',
				prodi = '$prodi',
				ips1 = '$ips1',
				ipk = '$ipk',
				tot_sks = '$tot_sks',
				jumD = '$jumD',
				jumE = '$jumE',
				status = '$status'
				WHERE nim = '$nim'
				 ";

	$result = mysqli_query($connect, $query);
	if(!$result){
		die("Gagal memperbaharui data!<br/>");
	}

	header("location:datatesting.php");
?>
