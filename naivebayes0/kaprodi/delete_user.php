<?php  
  
    require_once "../koneksi.php";
      
      
      
	$id_user=$_GET['id_user'];  
      
	$delete="Delete from user Where id_user='$id_user'";  
      
    
	mysqli_query($connect, $delete) or die ("Error tu");  
      
      
      
	echo "<center><h3>Data berhasil di hapus</h3></center>";  

	header("location:tampiluser.php");

      
      
?> 