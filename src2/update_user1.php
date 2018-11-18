<!DOCTYPE html>
<html>
<head>
  <title>input data training</title>
<link rel="stylesheet" href="update.css">

</head>
<body>

<?php
	include("koneksi.php");
	include ("koneksi.php");
    include_once 'header.php';
    include_once 'menu.php';
    include ("user.php")
   

	$id_user = $_GET["id_user"];
	$query = "SELECT * FROM user
				WHERE id_user = '$id_user'
			 ";
	$result = mysqli_query($connect, $query);
	if(!$result){
		die("Gagal mengambil data!");
	}

	$data = mysqli_fetch_array($result);
?>
 <div id="konten" >
<form id="update" action="update_prosesuser.php" method="post">

	<h1>Form Update Data Training</h1>


	<label for="id_user">Id_User</label>
    <input type="text" id="id_user" name="id_user" value="<?php echo $data['id_user'];?>"/>

    <label for="nama_user">Nama User</label>
    <input type="text" id="nama" name="nama" value="<?php echo $data['nama'];?>"/>

    <label for="username">Username</label>
    <input type="text" id="username" name="username"  value="<?php echo $data['username'];?>"/>

    <label for="password">Password</label>
    <input type="password" id="password" name="password"  value="<?php echo $data['password'];?>"/>

    <label for="level">Level</label>
    <select id="level" name="level" value="<?php echo $data['level'];?>"/>
      <option <?php echo $data['level'] == "1" ? 'selected="selected"': '';?> value="1">Kaprodi</option>
      <option <?php echo $data['level'] == "2" ? 'selected="selected"': '';?> value="2">Mahasiswa</option>
    </select>

<input type="submit" name="perbaharui" value="Perbarui">
&nbsp; 
<input type="reset" value="Batal">


</div>
</body>
</html>