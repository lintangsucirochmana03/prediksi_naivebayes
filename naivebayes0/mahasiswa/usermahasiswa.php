<!DOCTYPE html>
<html>
<head>
  <title>input data training</title>
<link rel="stylesheet" href="../css/style.css">


</head>
<body>
  <?php
  require_once "../koneksi.php";
  
?>
 <form id="form" action="proses_buatusermahasiswa.php" method="post">
   <div id="wrap"> 
    <label for="nama">Nama Mahasiswa</label>
    <input type="text" id="nama_user" name="nama_user" placeholder="Nama Mahasiswa">

    <label for="username">Username (Masukkan NIM)</label>
    <input type="text" id="username" name="username" placeholder="165610001">

    <label for="password">Password</label>
    <input type="password" id="password" name="password" placeholder="Password">

    <label for="password">Ulangi Password</label>
    <input type="password" id="password" name="ulangpassword" placeholder="Ulangi Password">
  
    <input type="submit" value="Daftar">
  </div>

</body>
</html>


