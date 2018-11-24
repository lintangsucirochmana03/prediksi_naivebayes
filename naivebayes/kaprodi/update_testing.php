<!DOCTYPE html>
<html>
<head>
  <title>input data training</title>
<link rel="stylesheet" href="../css/update.css">

</head>
<body>

<?php
    require_once "../koneksi.php";
    include_once 'header.php';
    include_once 'menu.php';
   

	$nim = $_GET["nim"];
	$query = "SELECT * FROM Mahasiswa
				WHERE nim = '$nim'
			 ";
	$result = mysqli_query($connect, $query);
	if(!$result){
		die("Gagal mengambil data!");
	}

	$data = mysqli_fetch_array($result);
?>
 <div id="konten" >
<form id="update" action="update_prosests.php" method="post">

	<h2>Form Update Data Testing</h2>


	<label for="nim">Nim</label>
    <input type="text" id="nim" name="nim" value="<?php echo $data['nim'];?>" readonly/>

    <label for="nama">Nama</label>
    <input type="text" id="nama" name="nama" value="<?php echo $data['nama'];?>"/>

    <label for="th_masuk">Tahun Masuk</label>
    <input type="text" id="th_masuk" name="th_masuk"  value="<?php echo $data['th_masuk'];?>"/>

    <label for="semester">Semester</label>
    <select id="semester" name="semester" value="<?php echo $data['semester'];?>"/>
      <option <?php echo $data['semester'] == "4" ? 'selected="selected"': '';?> value="4">4</option>
      <option <?php echo $data['semester'] == "5" ? 'selected="selected"': '';?> value="5">5</option>
      <option <?php echo $data['semester'] == "6" ? 'selected="selected"': '';?> value="6">6</option>
      <option <?php echo $data['semester'] == "7" ? 'selected="selected"': '';?> value="7">7</option>
    </select>

    <label for="jurusan_asalsekolah">Jurusan Asal Sekolah</label>
    <select id="jurusan_asalsekolah" name="jurusan_asalsekolah" value="<?php echo $data['jurusan_asalsekolah'];?>"/>
      <option <?php echo $data['jurusan_asalsekolah'] == "IPA" ? 'selected="selected"': '';?> value="IPA">IPA</option>
      <option <?php echo $data['jurusan_asalsekolah'] == "IPS" ? 'selected="selected"': '';?> value="IPS">IPS</option>
      <option <?php echo $data['jurusan_asalsekolah'] == "Multimedia" ? 'selected="selected"': '';?> value="Multimedia">Multimedia</option>
      <option <?php echo $data['jurusan_asalsekolah'] == "TKJ" ? 'selected="selected"': '';?> value="TKJ">TKJ</option>
      <option <?php echo $data['jurusan_asalsekolah'] == "Teknik Otomotif" ? 'selected="selected"': '';?> value="Teknik Otomotif">Teknik Otomotif</option>
      <option <?php echo $data['jurusan_asalsekolah'] == "Teknik Mesin" ? 'selected="selected"': '';?> value="Teknik Mesin">Teknik Mesin</option>
      <option <?php echo $data['jurusan_asalsekolah'] == "Teknik Elektro" ? 'selected="selected"': '';?> value="Teknik Elektro">Teknik Elektro</option>
      <option <?php echo $data['jurusan_asalsekolah'] == "Teknik Listrik" ? 'selected="selected"': '';?> value="Teknik Listrik">Teknik Listrik</option>
      <option <?php echo $data['jurusan_asalsekolah'] == "Teknik Gambar Bangunan" ? 'selected="selected"': '';?> value="Teknik Gambar Bangunan">Teknik Gambar Bangunan</option>
      <option <?php echo $data['jurusan_asalsekolah'] == "Akuntansi" ? 'selected="selected"': '';?> value="Akuntansi">Akuntansi</option>
      <option <?php echo $data['jurusan_asalsekolah'] == "Administrasi Perkantoran" ? 'selected="selected"': '';?> value="Administrasi Perkantoran">Administrasi Perkantoran</option>
      <option <?php echo $data['jurusan_asalsekolah'] == "Pariwisata" ? 'selected="selected"': '';?> value="Pariwisata">Perhotelan</option>
      <option <?php echo $data['jurusan_asalsekolah'] == "Perhotelan" ? 'selected="selected"': '';?> value="Perhotelan">Perhotelan</option>
      <option <?php echo $data['jurusan_asalsekolah'] == "Pemasaran" ? 'selected="selected"': '';?> value="Pemasaran">Pemasaran</option>
      <option <?php echo $data['jurusan_asalsekolah'] == "Tata Boga" ? 'selected="selected"': '';?> value="Tata Boga">Tata Boga</option>
      <option <?php echo $data['jurusan_asalsekolah'] == "Lain" ? 'selected="selected"': '';?> value="Lain">Lain</option>
    </select>

    <label for="prodi">Prodi</label>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <select id="prodi" name="prodi" value="<?php echo $data['prodi'];?>"/>
      <option <?php echo $data['prodi'] == "SI" ? 'selected="selected"': '';?> value="SI">Siste Informasi</option>
      <option <?php echo $data['prodi'] == "TI" ? 'selected="selected"': '';?> value="TI">Teknik Informatika</option>
    </select>

    <br/>

    <label for="ips1">IPS1</label>
    <input type="text" id="ips1" name="ips1"  value="<?php echo $data['ips1'];?>"/>

    <label for="ipk">IPK</label>
    <input type="text" id="ipk" name="ipk"  value="<?php echo $data['ipk'];?>"/>

    <label for="tot_sks">Total SKS</label>
    <input type="text" id="tot_sks" name="tot_sks"  value="<?php echo $data['tot_sks'];?>"/>

    <label for="jumD">Jumlah Nilai D</label>
    <input type="text" id="jumD" name="jumD" value="<?php echo $data['jumD'];?>"/>

    <label for="jumE">Jumlah Nilai E</label>
    <input type="text" id="jumE" name="jumE" value="<?php echo $data['jumE'];?>"/>

    <label for="status">Status</label>
    <select id="status" name="status" value="<?php echo $data['status'];?>"/>
      <option <?php echo $data['status'] == "Tepat" ? 'selected="selected"': '';?> value="Tepat">Tepat</option>
      <option <?php echo $data['status'] == "Lambat" ? 'selected="selected"': '';?> value="Lambat">Lambat</option>
      <option <?php echo $data['status'] == "BL" ? 'selected="selected"': '';?> value="BL">BL</option>
    </select>
    &nbsp;

<input type="submit" name="perbaharui" value="Perbarui">
&nbsp; 
<input type="reset" value="Batal">


</div>
</body>
</html>