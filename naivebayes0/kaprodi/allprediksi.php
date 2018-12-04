<?php
  	
    require_once "../koneksi.php";
    include_once 'menu.php';
    include 'prediksi_proses.php'
?>
    <div id="konten" >
   <?php 
    //Menampilkan Tabel Hasil Prediksi
    echo "<div class='container'>
    <center><h3>Tabel Hasil Prediksi </h3></center>
     <table id='tbl-import'>
    <thead class='thead-light'>
      <tr>
        <th>No</center></th>
        <th><center>NIM</center></th>
        <th><center>Nama</center></th>
        <th><center>Jurusan Asal Sekolah</center></th>
        <th><center>PRODI</center></th>
        <th><center>Semester</center></th>
        <th><center>IP Semester 1</center></th>
        <th><center>IPK</center></th>
        <th><center>Total SKS</center></th>
        <th><center>Jumlah Nilai D</center></th>
        <th><center>Jumlah Nilai E</center></th>
        <th><center>Status Lulus</center></th>
        <th><center>Prediksi</center></center></th>
        <th><center>Aksi</center></th>
      </tr>
    </thead>
    <tbody>
    <tr>
    ";


  $halaman = 10;
  $page = isset($_GET["halaman"]) ? (int)$_GET["halaman"] : 1;
  $mulai = ($page>1) ? ($page * $halaman) - $halaman : 0;
  $result = mysqli_query($connect,"SELECT * FROM MahasiswaHasil");
  $total = mysqli_num_rows($result);
  $pages = ceil($total/$halaman);            
  $tampil = mysqli_query($connect,"select * from MahasiswaHasil LIMIT $mulai, $halaman")or die(mysql_error);
  $no =$mulai+1;


   /* $tampil=mysqli_query($connect,"SELECT Nim,JurusanAsal,Prodi,IPS1,IPK,TotalSKS,JumD,JumE,Status_Lulus,Prediksi FROM MahasiswaHasil") or die(mysqli_errno($connect));*/
    while($tampilkan=mysqli_fetch_assoc($tampil)){
    echo "<tr>";
    echo " <td>". $no++. "</td>";
    echo "<td>".$tampilkan['Nim']."</td>";
    echo "<td>".$tampilkan['Nama']."</td>";
    echo "<td>".$tampilkan['JurusanAsal']."</td>";
    echo "<td>".$tampilkan['Prodi']."</td>";
    echo "<td>".$tampilkan['Semester']."</td>";
    echo "<td>".$tampilkan['IPS1']."</td>";
    echo "<td>".$tampilkan['IPK']."</td>";
    echo "<td>".$tampilkan['TotalSKS']."</td>";
    echo "<td>".$tampilkan['JumD']."</td>";
    echo "<td>".$tampilkan['JumE']."</td>";
    echo "<td>" . $tampilkan['Status_Lulus']. "</td>";
    echo "<td>" . $tampilkan['Prediksi']. "</td>";
   ?>
   <td><div align="center"><a href="detail.php?Nim=<?php echo $tampilkan['Nim']; ?>"> Detail </a></div></td>  
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
    
