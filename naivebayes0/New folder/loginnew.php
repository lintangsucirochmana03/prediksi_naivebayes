<?php
require_once('../koneksi.php');
session_start(); //memulai session
	$koneksi = connect();//mengambil isian username dan password dari form
	$username = $_POST['username'];
	$password = $_POST['password'];

//query untuk mengambil data user dari database sesuai dengan username inputan form
	$q = "SELECT * FROM user WHERE username = '$username' AND password = '$password' ";
	$result = mysqli_query($koneksi, $q);
	$data = mysqli_fetch_array($result);
	$nm_user = $data['nm_user'];
	$level = $data['level'];

//cek kesesuaian password masukan dengan database
if ($password == $data['password']) {

//menyimpan username dalam session
$_SESSION['level'] = $data['level'];
	if($data['level'] == 1){
	header('location:formImport.php.php');
	}
	else if{
	if($data['level'] == 2){
		header('location:mahasiswa_tampil.php');
	} }
}

//jika password tidak sesuai
	else {
	$message = "Username / Password Salah";
	echo $message;
	}
?>
