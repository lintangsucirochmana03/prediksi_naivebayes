
<?php


//cek apakah user sudah login
if(!isset($_SESSION['username'])){
    
    header("location:index.php");
}
?>
<div id="kiri">
	<div id="user">

    <?php
        
        $nama = $_SESSION['nama_user'];
        echo "<img style='height: 30px; margin-top: -5px;' src='img/add-user.png' class='img-circle'>";
        ?> 
        
        <div class="pull-left">
        <p id="nama_user" style="margin: -25px 40px 10px;">Selamat Datang <i><?php echo $_SESSION['nama_user']; ?></i></p>
        </div>

		<p>USER</p>
		<ul>
        
        <li><a href ="dataTrainig"><img src="img/add-user.png" width="30px" height="35px" />Edit User</a></li>
        <li><a href="../logout.php"><img src="img/out.png" width="25px" height="25px" /> Logout</a></li>
      </ul>
	</div>
     
    </div>