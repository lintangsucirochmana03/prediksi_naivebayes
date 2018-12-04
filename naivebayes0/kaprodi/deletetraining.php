<?php  
  
    require_once "../koneksi.php";
      
      
      
	$nim=$_GET['nim'];  
      
	$delete="Delete from Mahasiswa Where nim='$nim'";  
      
    
	mysqli_query($connect, $delete) or die ("Error tu");  
      
      
      
	echo "<center><h3>Data berhasil di hapus</h3></center>";  

	header("location:datatraining.php");

      
      
?> 