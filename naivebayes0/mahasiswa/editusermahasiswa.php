<!DOCTYPE html>
<html>
<head>
  <title>input data training</title>
<link rel="stylesheet" href="../css/update.css">

</head>
<body>

<?php
    require_once "../koneksi.php";
    include_once '../kaprodi/header.php';
    include_once 'mahasiswa_menu.php';
   

?>
 <div id="konten" >
<form id="update" action="simpan_pass.php" method="post">

	<h1>Form Ubah Password</h1>


    <label for="p_lama">Password Lama</label>
    <input type="text" id="p_lama" name="p_lama"  />

    <label for="p_baru">Password Baru</label>
    <input type="password" id="p_baru" name="p_baru"  />

    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

    <label for="p_ulang">Ulang Password</label>
    <input type="password" id="p_ulang" name="p_ulang"  />


<input type="submit" name="perbaharui" value="Perbarui">
&nbsp; 
<input type="reset" value="Batal">


</div>
</body>
</html>