<?php
	include ("koneksi.php");
    include_once 'header.php';
    include_once 'menu.php';
    include 'prediksi_proses.php';

?>
<div id="konten" >
 <?php
$nim = $_GET['Nim'];

if(array_key_exists('hapus', $_GET))
$hapus = $_GET['hapus'];
else
$hapus = 1;

?>

 <?php

                    //Data mentah yang ditampilkan ke tabel    
					               
                    $sql  ="select mahasiswa.nim,mahasiswa.nama,mahasiswa.th_masuk,mahasiswa.semester,prediksi.Nim,prediksi.Prediksi FROM Mahasiswa NATURAL JOIN Prediksi
								where nim = '$nim'";
                    
					$h = mysqli_query($connect, $sql);
					             while ($r = mysqli_fetch_array($h)) {
                                     
                    ?>
				<table id="tbl-detail" >
                    <tr>
						<th width="30%">NIM</th>
							<td width="40%"> :<?php echo  $r['nim']; ?></td>
						<th width="30%">TAHUN ANGKATAN</th>
							<td width="40%"> :<?php echo  $r['th_masuk']; ?></td>

					</tr>
					<tr>
						<th width="30%">NAMA MAHASISWA</th>
							<td width="40%"> :<?php echo  $r['nama']; ?></td>
						<th width="30%">Semester</th>
							<td width="40%"> :<?php echo  $r['semester']; ?></td>

					</tr>
					<tr>
						<th width="30%">Prediksi</th>
							<td width="40%"> :<?php echo  $r['Prediksi']; ?></td>
					</tr>

					
                    <?php
                    }
                    ?>
				</table>
				
<br/>
              <table id='tbl-import' >
				
				<thead>
				
                    <tr>	  
						      
							  <th width="10%">IPS 1</th>
							  <th width="10%">IPK</th>
							  <th width="10%">Total SKS</th>
							  <th width="10%">JUMD</th>
							  <th width="10%">JUME</th>
				
                    </tr>
                </thead>
                <tbody>
                	<?php 
					$sqldetail2 = "select ips1, ipk, tot_sks, jumD, jumE From Mahasiswa where nim = '$nim' ";

					$tampil2 = mysqli_query($connect, $sqldetail2);
					if(mysqli_num_rows($tampil2) > 0){
					$no = 1;
						while ($tampilkan2 = mysqli_fetch_array($tampil2)) {
                                     
                    ?>

                    <tr>
                        
                        <td><?php echo  $tampilkan2['ips1']; ?></td>
                        <td><?php echo  $tampilkan2['ipk']; ?></td>
                        <td><?php echo  $tampilkan2['tot_sks']; ?></td>
                        <td><?php echo  $tampilkan2['jumD']; ?></td>
                        <td><?php echo  $tampilkan2['jumE']; ?></td>
                    </tr>
                    <?php
                    $no++;
                    }
                    ?>
				<?php
					
					}else{ // if there is no matching rows do following
						echo "hasil tidak ada";
					}
					?>


                    <?php

                    //Data mentah yang ditampilkan ke tabel    
                   
                    $sqldetail1  ="select IPS1BL, IPKBL, TotalSKSBL, JumDBL, JumEBL From MahasiswaSementaraBL where Nim = '$nim' ";
                    
					$tampil = mysqli_query($connect, $sqldetail1);
					if(mysqli_num_rows($tampil) > 0){
					$no = 1;
						while ($tampilkan = mysqli_fetch_array($tampil)) {
                                     
                    ?>

                    <tr>
                        
                        
                        <td><?php echo  $tampilkan['IPS1BL']; ?></td>
                        <td><?php echo  $tampilkan['IPKBL']; ?></td>
                        <td><?php echo  $tampilkan['TotalSKSBL']; ?></td>
                        <td><?php echo  $tampilkan['JumDBL']; ?></td>
                        <td><?php echo  $tampilkan['JumEBL']; ?></td>
                    </tr>
                    <?php
                    $no++;
                    }
                    ?>
				<?php
					
					}else{ // if there is no matching rows do following
						echo "hasil tidak ada";
					}
					?>
<br/>

		<table id="tbl-detaildua" >
					<tr width='100%'>
						<th>Perlu Diperhatikan</th>
					</tr>
					<tr>
						<td width="50%">
							Sistem ini hanya membantu memprediksi kelulusan setiap mahasiswa, namun mahasiswa dapat lulus dengan tepat atau tidak tergantung dari mahasiswa itu sendiri. Nilai yang harus dicapai di semester 8 adalah :
						</td>
					</tr>
		</table>
		<table id="tbl-detailtiga" >
                    <tr>
						<td>IPK</td>
						<td > :Minimal 2.00 </td>
					</tr>
					<tr>
						<td>Total SKS</td>
						<td > :Minimal menempuh 144 SKS </td>
					</tr>
					<tr>
						<td>Jum Nilai D</td>
						<td> :Max 2% dari Total SKS </td>
					</tr>
					<tr>
						<td>Jumlah Nila E</td>
						<td> :0 (tidak ada nilai E) </td>
					</tr>
					<tr>
						<td>Menyelesaikan skripsi</td>
					</tr>
            </table> 

