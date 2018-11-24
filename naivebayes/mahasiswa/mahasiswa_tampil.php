<?php
    require_once "../koneksi.php";
    include_once '../kaprodi/header.php';
    include_once 'mahasiswa_menu.php';
    include '../kaprodi/prediksi_proses.php';
?>
    <div id="konten" >

      <?php

                    //Data mentah yang ditampilkan ke tabel    
                    
          $username = $_SESSION['username'];
          $sql  ="select 
                  nim, nama, jurusan_asalsekolah, prodi, th_masuk, semester, ips1, ipk, tot_sks, jumD, jumE
                  from mahasiswa
                  where nim = '$username'";
                    
          $tampil = mysqli_query($connect, $sql);
          $no = 1;
                                     
                    ?>

   <?php 
    //Menampilkan Tabel Hasil Prediksi
    echo "<div class='container'>
    <center><h3>Tabel Data Mahasiswa </h3></center>
    <br/>
    <br/>
    <br/>
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
        <th>IPS1</th>
        <th>IPK </th>
        <th>Total SKS</th>
        <th>JumD </th>
        <th>JumE </th>
      </tr>
    </thead>
    <tbody>
    <tr>
    ";




   /* $tampil=mysqli_query($connect,"SELECT Nim,JurusanAsal,Prodi,IPS1,IPK,TotalSKS,JumD,JumE,Status_Lulus,Prediksi FROM MahasiswaHasil") or die(mysqli_errno($connect));*/
    while($tampilkan=mysqli_fetch_array($tampil)){
    echo "<tr>";
    echo " <td>". $no. "</td>";
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

        echo "</tr>";
        
    };

    echo " </tbody></table>
    </div>";

    echo "<br/>";

?>

<div id="prediksi_mahasiswa"><a href='mahasiswa_detail.php'><button type='submit' name='btn-prediksi' id='btn-prediksi'>Prediksi</button></a></div>

