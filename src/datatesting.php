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
    <center><h3>Tabel Data Testing </h3></center>
     <table id='tbl-import'>
    <thead class='thead-light'>
      <tr>
      <th>No</th>
        <th>NIM</th>
        <th>Nama</th>
        <th>JurusanAsal</th>
        <th>PRODI</th>
        <th>Tahun Masuk</th>
        <th>IPS1</th>
        <th>IPK </th>
        <th>Total SKS</th>
        <th>JumD </th>
        <th>JumE </th>
        <th>Status Lulus</th>
      </tr>
    </thead>
    <tbody>
    <tr>
    ";


  $halaman = 10;
  $page = isset($_GET["halaman"]) ? (int)$_GET["halaman"] : 1;
  $mulai = ($page>1) ? ($page * $halaman) - $halaman : 0;
  $result = mysqli_query($connect,"SELECT * FROM Mahasiswa WHERE status IN('BL')");
  $total = mysqli_num_rows($result);
  $pages = ceil($total/$halaman);            
  $tampil = mysqli_query($connect,"select * from Mahasiswa WHERE status IN('BL') LIMIT $mulai, $halaman")or die(mysql_error);
  $no =$mulai+1;


   /* $tampil=mysqli_query($connect,"SELECT Nim,JurusanAsal,Prodi,IPS1,IPK,TotalSKS,JumD,JumE,Status_Lulus,Prediksi FROM MahasiswaHasil") or die(mysqli_errno($connect));*/
    while($tampilkan=mysqli_fetch_assoc($tampil)){
    echo "<tr>";
    echo " <td>". $no++. "</td>";
    echo "<td>".$tampilkan['nim']."</td>";
    echo "<td>".$tampilkan['nama']."</td>";
    echo "<td>".$tampilkan['jurusan_asalsekolah']."</td>";
    echo "<td>".$tampilkan['prodi']."</td>";
    echo "<td>".$tampilkan['th_masuk']."</td>";
    echo "<td>".$tampilkan['ips1']."</td>";
    echo "<td>".$tampilkan['ipk4']."</td>";
    echo "<td>".$tampilkan['tot_sks4']."</td>";
    echo "<td>".$tampilkan['jumD4']."</td>";
    echo "<td>".$tampilkan['jumE4']."</td>";
    echo "<td>" . $tampilkan['status']. "</td>";
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

