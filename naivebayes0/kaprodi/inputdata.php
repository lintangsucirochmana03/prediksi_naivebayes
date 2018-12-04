<!DOCTYPE html>
<html>
<head>
  <title>input data training</title>
<link rel="stylesheet" href="input.css">

</head>
<body>
  <?php
  include ("koneksi.php");
  include_once 'header.php';
  include_once 'menu.php';

?>
<div id="konten" >
 <form id="inputtraining" action="proses_inputdatatraining.php" method="post">
    <label for="nim">Nim</label>
    <input type="text" id="nim" name="nim" placeholder="Nim">

    <label for="nama">Nama</label>
    <input type="text" id="nama" name="nama" placeholder="Nama">

    <label for="th_masuk">Tahun Masuk</label>
    <input type="text" id="th_masuk" name="th_masuk" placeholder="Tahun Masuk">

    <label for="semester">Semester</label>
    <select id="semester" name="semester">
      <option value="4">4</option>
      <option value="5">5</option>
      <option value="6">6</option>
      <option value="7">7</option>
    </select>

    <label for="jurusan_asalsekolah">Jurusan Asal Sekolah</label>
    <select id="jurusan_asalsekolah" name="jurusan_asalsekolah">
      <option value="IPA">IPA</option>
      <option value="IPS">IPS</option>
      <option value="Multimedia">Multimedia</option>
      <option value="TKJ">TKJ</option>
      <option value="Pemasaran">Teknik Otomotif</option>
      <option value="Pemasaran">Teknik Mesin</option>
      <option value="Pemasaran">Teknik Elektro</option>
      <option value="Pemasaran">Teknik Listrik</option>
      <option value="Pemasaran">Teknik Gambar bangunan</option>
      <option value="Pemasaran">Akuntansi</option>
      <option value="Pemasaran">Administrasi Perkantoran</option>
      <option value="Pemasaran">Pariwisata</option>
      <option value="Perhotelan">Perhotelan</option>
      <option value="Pemasaran">Pemasaran</option>
      <option value="Pemasaran">Tata Boga</option>
      <option value="Lain">Lain</option>
    </select>

    <label for="ips1">IPS1</label>
    <input type="text" id="ips1" name="ips1" placeholder="3.00">

    <label for="ipk">IPK</label>
    <input type="text" id="ipk" name="ipk" placeholder="IPK">

    <label for="tot_sks">Total SKS</label>
    <input type="text" id="tot_sks" name="tot_sks" placeholder="Total SKS">

    <label for="jumD">Jumlah Nilai D</label>
    <input type="text" id="jumD" name="jumD" placeholder="Jumlah Nilai D">

    <label for="jumE">Jumlah Nilai E</label>
    <input type="text" id="jumE" name="jumE" placeholder="Jumlah Nilai E">

    <label for="status">Status</label>
    <select id="status" name="status">
      <option value="Tepat">Tepat</option>
      <option value="Lambat">Lambat</option>
      <option value="BL">BL</option>
    </select>



  
    <input type="submit" value="Submit">

</div>
</body>
</html>


