<!DOCTYPE html>
<html>
<head>
  <title>input data training</title>
<link rel="stylesheet" href="../css/input.css">

</head>
<body>
  <?php
  require_once "../koneksi.php";
  include_once 'header.php';
  include_once 'menu.php';

?>
<div id="konten" >
 <form id="inputtraining" action="proses_adduserprodi.php" method="post">
  
    <label for="nama">Nama User</label>
    <input type="text" id="nama_user" name="nama_user" placeholder="">

    <label for="username">Username</label>
    <input type="text" id="username" name="username" placeholder="Username">

    <label for="password">Password</label>
    <input type="password" id="password" name="password" placeholder="Password">

    <label for="password">Ulangi Password</label>
    <input type="password" id="password" name="ulangpassword" placeholder="Ulangi Password">
  
    <input type="submit" value="Submit">

</div>
</body>
</html>


