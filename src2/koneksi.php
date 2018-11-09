<?php
//KONEKSI.. 
$host='localhost';
$username='root';
$password='';
$database='dbmahasiswa';
$connect = mysqli_connect($host, $username, $password, $database);
if(!$connect){
		die("Gagal koneksi!");
	}

?>