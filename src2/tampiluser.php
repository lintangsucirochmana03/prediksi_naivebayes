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
        <th>NO</th>
        <th>ID user</th>
        <th>Nama User</th>
        <th>Username</th>
        <th>Password</th>
        <th>Level</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
    <tr>
    ";

          
  $tampil = mysqli_query($connect,"select * from user ")or die(mysql_error);
  $no =1;


   /* $tampil=mysqli_query($connect,"SELECT Nim,JurusanAsal,Prodi,IPS1,IPK,TotalSKS,JumD,JumE,Status_Lulus,Prediksi FROM MahasiswaHasil") or die(mysqli_errno($connect));*/
    while($tampilkan=mysqli_fetch_assoc($tampil)){
    echo "<tr>";
    echo " <td>". $no++. "</td>";
    echo "<td>".$tampilkan['id_user']."</td>";
    echo "<td>".$tampilkan['nama_user']."</td>";
    echo "<td>".$tampilkan['username']."</td>";
    echo "<td>".$tampilkan['password']."</td>";
    echo "<td>".$tampilkan['level']."</td>";
    ?>
   <td>
    <div align="center"><a href="update_user.php?id_user=<?php echo $tampilkan['id_user']; ?>"> Update </a></div>
    <div align="center"><a href="delete_user.php?id_user=<?php echo $tampilkan['id_user']; ?>"> Delete </a></div>

   </td>  
   <?php 
        echo "</tr>";

        
    };

    echo " </tbody></table>
    </div>";

    echo "<br/>";

?>
