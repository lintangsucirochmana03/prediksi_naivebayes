<?php
session_start();



include('proses_loginmahasiswa.php'); 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>
<link rel="stylesheet" href="../css/style.css">
</head>

<body>
<form id="form" name="form" method="post" action="">
  <div id="text">
     
      <p><b> Masukkan Username dan Password Mahasiswa</b> </p>
    </div>
  <div id="wrap">
    <div id="group">
      <label for="username">Username (Masukkan NIM Mahasiswa)</label>
      <input type="text" name="username" id="username" placeholder="Masukkan NIM"/>
    </div>
    <div id="group">
      <label for="password">Password</label>
      <input type="password" name="password" id="password" placeholder="Password"/>
    </div>
    <div class="checkbox">
      <label>
        <input type="checkbox" > Remember Me
      </label>
    </div>

     <input type="submit" name="login" value="LOGIN">

    



     <?php echo $error; ?>

  </div>
</form>
</body>
</html>
