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
    <center><h3>Tabel Data Training </h3></center>
     <table id='tbl-import'>
    <thead class='thead-light'>
      <tr>
      <th>No</th>
        <th>NIM</th>
        <th>Nama</th>
        <th>JurusanAsal</th>
        <th>PRODI</th>
        <th>Tahun Masuk</th>
        <th>Semester</th>
        <th>IPS 1</th>
        <th>IPK</th>
        <th>TotalSKS</th>
        <th>JumD</th>
        <th>JumE</th>
        <th>Status lulus</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
    <tr>
    ";


  $halaman = 10;
  $page = isset($_GET["halaman"]) ? (int)$_GET["halaman"] : 1;
  $mulai = ($page>1) ? ($page * $halaman) - $halaman : 0;
  $result = mysqli_query($connect,"SELECT * FROM Mahasiswa WHERE status IN('lambat', 'tepat')");
  $total = mysqli_num_rows($result);
  $pages = ceil($total/$halaman);            
  $tampil = mysqli_query($connect,"select * from Mahasiswa WHERE status IN('lambat', 'tepat') Order By nim LIMIT $mulai, $halaman")or die(mysql_error);
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
    echo "<td>".$tampilkan['semester']."</td>";
    echo "<td>".$tampilkan['ips1']."</td>";
    echo "<td>".$tampilkan['ipk']."</td>";
    echo "<td>".$tampilkan['tot_sks']."</td>";
    echo "<td>".$tampilkan['jumD']."</td>";
    echo "<td>".$tampilkan['jumE']."</td>";
    echo "<td>" . $tampilkan['status']. "</td>";
    ?>
   <td>
    <div align="center"><a href="update_training.php?nim=<?php echo $tampilkan['nim']; ?>"> Update </a></div>
    <div align="center"><a href="delete.php?nim=<?php echo $tampilkan['nim']; ?>"> Delete </a></div>

   </td>  
   <?php 
        echo "</tr>";

        
    };

    echo " </tbody></table>
    </div>";

    echo "<br/>";

?>
<div id="tbl-paging">
  <?php
     if ($page > 1) {?>

              <a href="?halaman=<?php echo ($page-1);?>">Previous</a>
      <?php      } 
 
          else
            {
            }
            ?>

    <?php 
    for ($i=1; $i<=$pages ; $i++){ ?>
      <a href="?halaman=<?php echo $i; ?>"><?php echo $i; ?></a>
    <?php } ?>
    <?php
     if ($page < $pages) {?>

              <a href="?halaman=<?php echo ($page+1);?>">Next</a>
              <a href="?halaman=<?php echo $pages;?>">Last</a>
      <?php      } 
 
          else
            {
            }
            ?>

</div> 
    
