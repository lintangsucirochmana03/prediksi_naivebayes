<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php
	include ("koneksi.php");
  include_once 'header.php';
  include_once 'menu.php';
?>
<div id="konten" >
  <?php
    if (isset($_POST['submit'])) {//Script akan berjalan jika di tekan tombol submit..

    //Script Upload File..
      if (is_uploaded_file($_FILES['filename']['tmp_name'])) 
      {
    	echo "<h3>" . "File ". $_FILES['filename']['name'] ." Berhasil di Upload" . "</h3>";
      }

    //Import uploaded file to Database, Letakan dibawah sini..
    $handle = fopen($_FILES['filename']['tmp_name'], "r"); //Membuka file dan membacanya
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        $import="INSERT into mahasiswa (nim,nama,prodi,th_masuk,jurusan_asalsekolah,ips1,ipk4,tot_sks4,jumD4,jumE4,status) values('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]','$data[7]','$data[8]','$data[9]','$data[10]')"; //data array sesuaikan dengan jumlah kolom pada CSV anda mulai dari “0” bukan “1”
       	mysqli_query($connect, $import);

    }
    fclose($handle); //Menutup CSV file

  }else {
	
  echo "Gagal menambah data!<br/>";
  }



 ?>

 <h1 align="center">Data Mahasiswa</h1>
 <center>
<div id="btn"><a href='prediksi_proses.php'><button type='submit' class='btn btn-skin' name='tampil' id='tampil'>Prediksi</button></a></div>
</center>
<table id="tbl-import" > 
  <tr bgcolor="#CCFFFF"> 
    <th><div align="center"><strong>NIM</strong></div></th> 
    <th><div align="center"><strong>Nama</strong></div></th> 
    <th><div align="center"><strong>Prodi</strong></div></th>
    <th><div align="center"><strong>Tahun Masuk</strong></div></th>
    <th><div align="center"><strong>Jurusan Asal Sekolah</strong></div></th> 
    <th><div align="center"><strong>IPS 1</strong></div></th> 
    <th><div align="center"><strong>IPK 4</strong></div></th>  
    <th><div align="center"><strong>Total SKS 4</strong></div></th> 
    <th><div align="center"><strong>Jumlah Nilai D Sem4</strong></div></th>
    <th><div align="center"><strong>Jumlah Nilai E Sem4</strong></div></th>  
    <th><div align="center"><strong>Status</strong></div></th> 
    
  </tr> 
  <?php 

      mysql_connect('localhost','root',''); 
      mysql_select_db('dbmahasiswa'); 
    
      $tampil="select * from mahasiswa"; 
      $qryTampil=mysql_query($tampil); 
      while ($dataTampil=mysql_fetch_array($qryTampil)) { 
     ?> 
  
   <tr bgcolor="#FFFFFF">  
    <td><?php echo $dataTampil['nim']; ?></td> 
    <td><?php echo $dataTampil['nama']; ?></td> 
    <td><?php echo $dataTampil['prodi']; ?></td> 
    <td><?php echo $dataTampil['th_masuk']; ?></td>
    <td><?php echo $dataTampil['jurusan_asalsekolah']; ?></td>
    <td><?php echo $dataTampil['ips1']; ?></td>
    <td><?php echo $dataTampil['ipk4']; ?></td>
    <td><?php echo $dataTampil['tot_sks4']; ?></td>
    <td><?php echo $dataTampil['jumD4']; ?></td>
    <td><?php echo $dataTampil['jumE4']; ?></td>
    <td><?php echo $dataTampil['status']; ?></td>
    

  </tr> 
    <?php } ?> 
</table>
</div>
</body>
</html>


