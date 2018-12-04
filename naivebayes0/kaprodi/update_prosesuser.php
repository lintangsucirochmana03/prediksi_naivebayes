<?php
    require_once "../koneksi.php";
	$aksi = $_POST['perbaharui'];
	$id_user = $_POST["id_user"];
	$nama_user = $_POST["nama_user"];
	$username = $_POST["username"];
	$password = $_POST["password"];
	$level = $_POST["level"];

	$query = "UPDATE user SET
				nama_user = '$nama_user',
				username= '$username',
				password='$password',
				level= '$level'
				WHERE id_user = '$id_user'
				 ";

	$result = mysqli_query($connect, $query);
	if(!$result){
		die("Gagal memperbaharui data!<br/>");
	}

	header("location:tampiluser.php");
?>
