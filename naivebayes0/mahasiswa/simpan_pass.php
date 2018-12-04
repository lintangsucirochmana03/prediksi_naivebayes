<?php
session_start();
include_once "../koneksi.php";

$username = $_SESSION['username'];

$lama = $_POST['p_lama'];
$baru = $_POST['p_baru'];

$query = mysqli_fetch_array(mysqli_query($connect, "SELECT password FROM user WHERE username = '$username'"));
if($query['password']==$lama){
$sql = mysqli_query($connect, "UPDATE user SET password='$baru' WHERE username = '$username'");
echo "<script>alert('Password sudah diganti ^_^ ')</script>";
	  header('Location:mahasiswa_tampil.php');
}else{
echo "<script>alert('Password lama tidak sesuai!')</script>";
}
?>
