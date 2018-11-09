<?php
	include ("koneksi.php");

	//menghitung jumlah kelas target
    $querymahasiswatepat=mysqli_query($connect,"SELECT nim FROM mahasiswa WHERE status IN('tepat') ORDER BY nim;");
    $totalmahasiswatepat=mysqli_num_rows($querymahasiswatepat);

    $querymahasiswalambat=mysqli_query($connect,"SELECT nim FROM mahasiswa WHERE status IN('lambat') ORDER BY nim;");
    $totalmahasiswalambat=mysqli_num_rows($querymahasiswalambat);

    $querymahasiswalulus=mysqli_query($connect,"SELECT nim FROM mahasiswa WHERE status IN('lambat', 'tepat') ORDER BY nim;");
    $totalmahasiswalulus=mysqli_num_rows($querymahasiswalulus);






    echo "Total Mahasiswa Lulus Tepat : " . $totalmahasiswatepat . "</br>";
    echo "Total Mahasiswa Lulus Lambat : " . $totalmahasiswalambat . "</br>";
    echo "Total Mahasiswa Lulus : " . $totalmahasiswalulus . "</br>";

    echo "</br>";

    //menghitung prior
    $prior_tepat = $totalmahasiswatepat / $totalmahasiswalulus;
    $prior_lambat = $totalmahasiswalambat / $totalmahasiswalulus;

    echo "Total Priot Tepat = " . $prior_tepat. "<br/>"; 
    echo "Total Priot Lambat = " . $prior_lambat. "<br/>"; 

    //Konversi data
    mysqli_query($connect,"CREATE TEMPORARY TABLE MahasiswaSementara(Nim INT (10)
        ,IPS1 varchar(255)
        ,Status_Lulus varchar(255));");


    echo "
    <div class='container'>
	<center><h3 class='page-header'>JARAK TERDEKAT </h3></center>
    <table class='table table-striped table-bordered'>
    <thead class='thead-light'>
      <tr>
      	<th>Nim</th>
        <th>IPS1</th>
        <th>Status_Lulus</th>
      </tr>
    </thead>
    <tbody>";
    $dataarray=array();
          while  ($getnimmahasiswa=mysqli_fetch_assoc($querymahasiswalulus)){
            $dataarray[]=$getnimmahasiswa['nim'];
          }
    $loop=1;

    for ($minout=1;$minout<=$totalmahasiswalulus;$minout++){
    $nimi=mysqli_fetch_assoc(mysqli_query($connect,"SELECT nim FROM Mahasiswa WHERE nim=".$dataarray[$minout-1].";"));
    
    $status_lulus=mysqli_fetch_assoc(mysqli_query($connect,"SELECT status FROM Mahasiswa WHERE nim=".$dataarray[$minout-1].";"));
    $rangking=mysqli_query($connect,"SELECT ips1 FROM mahasiswa WHERE nim=".$dataarray[$minout-1].";") or die(mysqli_errno($connect));
    $data=1;
    while($datarangking=mysqli_fetch_assoc($rangking)){
       if ($datarangking['ips1'] >= 2){
                  echo 'Terpenuhi'; }                   
            
            elseif($datarangking['ips1'] >=0 ){
                  echo 'Kurang'; }
            
        $data+=1;

    };
    $hasil=  $datarangking['ips1'] ; 
    echo $data. $hasil;
    mysqli_query($connect,"INSERT INTO MahasiswaSementara (Nim,IPS1,Status_Lulus)
        VALUES ('".$nimi['nim']."',".$hasil.",'".$status_lulus['status']."'); ");
    $loop+=1;
    };


    $rangking=mysqli_query($connect,"SELECT nim, ips1, status FROM mahasiswa;") or die(mysqli_errno($connect));
    $data=1;
    while($datarangking=mysqli_fetch_assoc($rangking)){
        echo "<tr>";
         echo "<td>".$datarangking['nim']."</td>
         <td>";
            if ($datarangking['ips1'] >= 2){
                  $ipsnew = 'Terpenuhi'; }                   
            
            elseif($datarangking['ips1'] >=0 ){
                  $ipsnew = 'Kurang'; }
        $data+=1;
    
        echo  $ipsnew . "</td>";
        
        echo "<td>" . $datarangking['status']. "</td>";
        echo "</tr>";
        
    };

    echo " </tbody></table>
    </div>";

    

    echo "<div class='container'>
	<center><h3 class='page-header'>KESIMPULAN HASIL PREDIKSI </h3></center>
     <table class='table table-striped table-bordered'>
    <thead class='thead-light'>
      <tr>
        <th>NIM</th>
        <th>NIM</th>
        <th>KESIMPULAN</th>
      </tr>
    </thead>
    <tbody>
    <tr>
    ";

    $coba=mysqli_query($connect,"SELECT Nim,IPS1,Status_Lulus FROM MahasiswaSementara;") or die(mysqli_errno($connect));
	while($cobac=mysqli_fetch_assoc($coba)){
	echo "<tr>";
    echo "<td>".$cobac['Nim']."</td>";
    echo "<td>".$cobac['IPS1']."</td>";
    echo "<td>" . $cobac['Status_Lulus']. "</td>";
        echo "</tr>";
        
    };

    echo " </tbody></table>
    </div>";


?>