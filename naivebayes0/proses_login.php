<?php
$error=''; 

require_once "koneksi.php";

if(isset($_POST['login']))
{               
    $username   = $_POST['username'];
	$nama_user    = $_POST['nama_user'];
    $password   = $_POST['password'];
              
    $query = mysqli_query($connect, "SELECT * FROM user WHERE username='$username' AND password='$password'");
    if(mysqli_num_rows($query) == 0)
    {
        $error = "Username or Password is invalid";
    }
    else
    {
        $row = mysqli_fetch_assoc($query);
        $_SESSION['username']=$row['username'];
		$_SESSION['nama_user']=$row['nama_user'];
        $_SESSION['level'] = $row['level'];
        
        if($row['level'] == "1")
        {  
            header("Location:kaprodi/formImport.php");
        }
        else if($row['level'] =="2" )
        {
            header("Location:mahasiswa/mahasiswa_tampil.php");
        }
        else
        {
            $error = "Gagal Login";
        }
    }
}           
?>