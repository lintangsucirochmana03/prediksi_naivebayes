<!DOCTYPE html>
<html>
<head>
  <title>input data training</title>
<link rel="stylesheet" href="input.css">

</head>
<body>
  <?php
  require_once "../koneksi.php";
  include_once 'header.php';
  include_once 'menu.php';


?>
<div id="konten" >
	<?php
	include("koneksi.php");

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


	//Validasi Data
	$valid = "Y";
	if(trim(strlen($nim)) == 0){
		echo "Nim belum diisi!<br/>";
		$valid = "N";
	}
	if(trim(strlen($nama)) == 0){
		echo "Nama Mahasiswa belum diisi!<br/>";
		$valid = "N";
	}
	if(trim(strlen($th_masuk)) == 0){
		echo "Tahun Masuk belum diisi!<br/>";
		$valid = "N";
	}
	if(trim(strlen($semester)) == 0){
		echo "Semester belum diisi!<br/>";
		$valid = "N";
	}
	if(trim(strlen($jurusan_asalsekolah)) == 0){
		echo "Jurusan Asal Sekolag belum diisi!<br/>";
		$valid = "N";
	}
	if(trim(strlen($ips1)) == 0){
		echo "IPS 1 belum diisi!<br/>";
		$valid = "N";
	}
	if(trim(strlen($ipk)) == 0){
		echo "IPK belum diisi!<br/>";
		$valid = "N";
	}
	if(trim(strlen($tot_sks)) == 0){
		echo "Total SKS belum diisi!<br/>";
		$valid = "N";
	}
	if(trim(strlen($jumD)) == 0){
		echo "Jumlah Nilai D belum diisi!<br/>";
		$valid = "N";
	}
	if(trim(strlen($jumE)) == 0){
		echo "Jumlah Nilai E belum diisi!<br/>";
		$valid = "N";
	}
	if(trim(strlen($status)) == 0){
		echo "Tahun Masuk belum diisi!<br/>";
		$valid = "N";
	}

	if($valid == "N"){
		echo "Data belum benar! Silakan perbaiki.<br/>";
	}

	$query = "INSERT INTO Mahasiswa SET
				nim = '$nim',
				nama = '$nama',
				th_masuk= '$th_masuk',
				semester='$semester',
				jurusan_asalsekolah= '$jurusan_asalsekolah',
				prodi='$prodi',
				ips1 = '$ips1',
				ipk = '$ipk',
				tot_sks = '$tot_sks',
				jumD = '$jumD',
				jumE = '$jumE',
				status = '$status'
				";
	$result = mysqli_query($connect, $query);
	if(!$result){
		die("Gagal menambah data.<br/>");
	}

	header("location:inputdatatesting.php");
?>

	


</div>
</body>
</html>