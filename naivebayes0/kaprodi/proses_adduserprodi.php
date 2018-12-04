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

	$nama_user = $_POST["nama_user"];
	$username = $_POST["username"];
	$password = $_POST["password"];
	$level = "1";
	
	
  $sql = "insert into user values(NULL, '$nama_user', '$username', '$password', '$level')";

  $result = mysqli_query($connect, $sql);
	if(!$result){
		die("Gagal menambah data.<br/>");
	}
	header("location:adduser.php");

?>


	


</div>
</body>
</html>