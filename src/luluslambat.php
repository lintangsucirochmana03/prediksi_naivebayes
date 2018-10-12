<?php
  include ("koneksi.php");
    include_once 'header.php';
    include_once 'menu.php';
    include 'prediksi_proses.php'
?>
    <div id="konten" >
   <?php 
    //Menampilkan Tabel Hasil Prediksi
    echo "<div class='container'>
    <center><h3>Tabel Hasil Prediksi Mahasiswa Lulus Lambat </h3></center>
     <table id='tbl-import'>
    <thead class='thead-light'>
      <tr>
      <th>No</th>
        <th>NIM</th>
        <th>Nama</th>
        <th>Jurusan Asal Sekolah</th>
        <th>PRODI</th>
        <th>IPS1</th>
        <th>IPK</th>
        <th>TotalSKS</th>
        <th>JumD</th>
        <th>JumE</th>
        <th>Status</th>
        <th>Prediksi</th>
      </tr>
    </thead>
    <tbody>
    <tr>
    ";


  $halaman = 10;
  $page = isset($_GET["halaman"]) ? (int)$_GET["halaman"] : 1;
  $mulai = ($page>1) ? ($page * $halaman) - $halaman : 0;
  $result = mysqli_query($connect,"SELECT * FROM MahasiswaHasil WHERE Prediksi IN('Lambat')");
  $total = mysqli_num_rows($result);
  $pages = ceil($total/$halaman);            
  $tampil = mysqli_query($connect,"select * from MahasiswaHasil WHERE Prediksi IN('Lambat') LIMIT $mulai, $halaman")or die(mysql_error);
  $no =$mulai+1;


   /* $tampil=mysqli_query($connect,"SELECT Nim,JurusanAsal,Prodi,IPS1,IPK,TotalSKS,JumD,JumE,Status_Lulus,Prediksi FROM MahasiswaHasil") or die(mysqli_errno($connect));*/
    while($tampilkan=mysqli_fetch_assoc($tampil)){
    echo "<tr>";
    echo " <td>". $no++. "</td>";
    echo "<td>".$tampilkan['Nim']."</td>";
    echo "<td>".$tampilkan['Nama']."</td>";
    echo "<td>".$tampilkan['JurusanAsal']."</td>";
    echo "<td>".$tampilkan['Prodi']."</td>";
    echo "<td>".$tampilkan['IPS1']."</td>";
    echo "<td>".$tampilkan['IPK']."</td>";
    echo "<td>".$tampilkan['TotalSKS']."</td>";
    echo "<td>".$tampilkan['JumD']."</td>";
    echo "<td>".$tampilkan['JumE']."</td>";
    echo "<td>" . $tampilkan['Status_Lulus']. "</td>";
    echo "<td>" . $tampilkan['Prediksi']. "</td>";
        echo "</tr>";
        
    };

    echo " </tbody></table>
    </div>";

    echo "<br/>";

?>
<div id="tbl-import1">
    <?php for ($i=1; $i<=$pages ; $i++){ ?>
      <a href="?halaman=<?php echo $i; ?>"><?php echo $i; ?></a>

    <?php } ?>

    </div>

