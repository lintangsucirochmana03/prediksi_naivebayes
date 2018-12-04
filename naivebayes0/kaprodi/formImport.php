<?php
include_once 'header.php';
include_once 'menu.php';

?>
<form action="import.php" enctype='multipart/form-data' action='' method='post'>
<div id="konten" >
	<div id="import-form" >
		<h3> <img src="../img/import.png" width="50px" height="60px" /> Silahkan Masukkan File CSV </h3>
		<input type='file' name='filename'>
   		<input type='submit' name='submit' value='Import'>
   	</div>
</div>
</form>