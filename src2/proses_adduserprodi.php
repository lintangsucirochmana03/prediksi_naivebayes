<!DOCTYPE html>
<html>
<head>
  <title>input data training</title>
<link rel="stylesheet" href="input.css">

</head>
<body>
  <?php
  include ("koneksi.php");
  include_once 'header.php';
  include_once 'menu.php';


?>
<div id="konten" >
	<?php
	include("koneksi.php");

/*	function bacaUser($sql){
include ("koneksi.php")
  $data = array();
  $hasil = mysqli_query($connect, $sql);
  // jika tidak ada record, hasil berupa null
  if (mysqli_num_rows($hasil) == 0) {
	mysqli_close($connect);
	return null;  
  }
  $i=0;
  while($baris = mysqli_fetch_assoc($hasil)){
	$data[$i]['id_user']= $baris['id_user'];
	$data[$i]['nama_user']= $baris['nama_user'];
	$data[$i]['username'] = $baris['username'];
	$data[$i]['password'] = $baris['password'];
	$data[$i]['level'] = 1;


	$i++;
  }
  mysqli_close($connect);
  return $data;
}
*/
	
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