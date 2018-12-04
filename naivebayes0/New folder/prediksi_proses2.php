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

    echo "Total Prior Tepat = " . $prior_tepat. "<br/>"; 
    echo "Total Prior Lambat = " . $prior_lambat. "<br/>"; 

    //Konversi data
    mysqli_query($connect,"CREATE TEMPORARY TABLE MahasiswaSementara(Nim INT (10)
        ,Prodi varchar(2)
        ,JurusanAsal varchar(10)
        ,IPS1 varchar(10)
        ,IPK varchar(10)
        ,TotalSKS varchar(10)
        ,JumD varchar(10)
        ,JumE varchar(10)
        ,Status_Lulus varchar(255));");

    $dataarray=array();
          while  ($getnimmahasiswa=mysqli_fetch_assoc($querymahasiswalulus)){
            $dataarray[]=$getnimmahasiswa['nim'];
          }
    $loop=1;

    for ($minout=1;$minout<=$totalmahasiswalulus;$minout++){
    $nimi=mysqli_fetch_assoc(mysqli_query($connect,"SELECT nim FROM Mahasiswa WHERE nim=".$dataarray[$minout-1].";"));
    
    $prodinew=mysqli_fetch_assoc(mysqli_query($connect,"SELECT prodi FROM Mahasiswa WHERE nim=".$dataarray[$minout-1].";"));

    $jurusan_asal=mysqli_fetch_assoc(mysqli_query($connect,"SELECT jurusan_asalsekolah, IF(jurusan_asalsekolah='Multimedia', 'Multimedia', IF(jurusan_asalsekolah='TKJ', 'TKJ', IF(jurusan_asalsekolah='IPA', 'IPA', IF(jurusan_asalsekolah='IPS', 'IPS', 'Lain')))) As jurusan FROM mahasiswa WHERE nim=".$dataarray[$minout-1].";") );

    $ipsnew=mysqli_fetch_assoc(mysqli_query($connect,"SELECT ips1, IF(ips1>='2', 'Terpenuhi', 'Kurang') As IPS1 FROM mahasiswa WHERE nim=".$dataarray[$minout-1].";") );

    $ipknew=mysqli_fetch_assoc(mysqli_query($connect,"SELECT ipk4, IF(ipk4>='2', 'Terpenuhi', 'Kurang') As IPK FROM mahasiswa WHERE nim=".$dataarray[$minout-1].";") );

    $tot_sksnew=mysqli_fetch_assoc(mysqli_query($connect,"SELECT tot_sks4, IF(tot_sks4>='82', 'Terpenuhi','Kurang') As Tot_sks4 FROM Mahasiswa WHERE nim=".$dataarray[$minout-1].";"));

    $jumD4new=mysqli_fetch_assoc(mysqli_query($connect,"SELECT jumD4, IF(jumD4<=tot_sks4*0.2, 'Terpenuhi', 'Banyak') AS Dbaru FROM Mahasiswa WHERE nim=".$dataarray[$minout-1].";"));

    $jumE4new=mysqli_fetch_assoc(mysqli_query($connect,"SELECT jumE4, IF(jumE4<'1', 'Terpenuhi', 'Banyak') AS Ebaru FROM Mahasiswa WHERE nim=".$dataarray[$minout-1].";"));

    $status_lulus=mysqli_fetch_assoc(mysqli_query($connect,"SELECT status FROM Mahasiswa WHERE nim=".$dataarray[$minout-1].";"));
    


    mysqli_query($connect,"INSERT INTO MahasiswaSementara (Nim,Prodi,JurusanAsal,IPS1,IPK,TotalSKS,JumD,JumE,Status_Lulus)
        VALUES ('".$nimi['nim']."','".$prodinew['prodi']."','".$jurusan_asal['jurusan']."','".$ipsnew['IPS1']."','".$ipknew['IPK']."','".$tot_sksnew['Tot_sks4']."','".$jumD4new['Dbaru']."','".$jumE4new['Ebaru']."','".$status_lulus['status']."'); ");
    $loop+=1;
    };
    
    //Menampilkan Tabel Mahasiswa Sementara
    echo "<div class='container'>
	<center><h3 class='page-header'>Tampilan Tabel Mahasiswa Sementara </h3></center>
     <table class='table table-striped table-bordered'>
    <thead class='thead-light'>
      <tr>
        <th>NIM</th>
        <th>PRODI</th>
        <th>JurusanAsal</th>
        <th>IPS1</th>
        <th>IPK4</th>
        <th>TotalSKS</th>
        <th>JumD4</th>
        <th>JumE4</th>
        <th>STATUS</th>
      </tr>
    </thead>
    <tbody>
    <tr>
    ";

    $tampil=mysqli_query($connect,"SELECT Nim,Prodi,JurusanAsal,IPS1,IPK,TotalSKS,JumD,JumE,Status_Lulus FROM MahasiswaSementara;") or die(mysqli_errno($connect));
	while($tampilkan=mysqli_fetch_assoc($tampil)){
	echo "<tr>";
    echo "<td>".$tampilkan['Nim']."</td>";
    echo "<td>".$tampilkan['Prodi']."</td>";
    echo "<td>".$tampilkan['JurusanAsal']."</td>";
    echo "<td>".$tampilkan['IPS1']."</td>";
    echo "<td>".$tampilkan['IPK']."</td>";
    echo "<td>".$tampilkan['TotalSKS']."</td>";
    echo "<td>".$tampilkan['JumD']."</td>";
    echo "<td>".$tampilkan['JumE']."</td>";
    echo "<td>" . $tampilkan['Status_Lulus']. "</td>";
        echo "</tr>";
        
    };

    echo " </tbody></table>
    </div>";

    echo "<br/>";



    //Menghitung Probabiltas Data Training
    $queryjur_asalMMT=mysqli_query($connect,"SELECT nim FROM MahasiswaSementara WHERE JurusanAsal IN('Multimedia') AND Status_Lulus IN('Tepat') ORDER BY nim;");
    $totaljur_asalMMT=mysqli_num_rows($queryjur_asalMMT);

    $queryjur_asalMML=mysqli_query($connect,"SELECT nim FROM MahasiswaSementara WHERE JurusanAsal IN('Multimedia') AND Status_Lulus IN('Lambat') ORDER BY nim;");
    $totaljur_asalMML=mysqli_num_rows($queryjur_asalMML);

    $queryjur_asalTKJT=mysqli_query($connect,"SELECT nim FROM MahasiswaSementara WHERE JurusanAsal IN('TKJ') AND Status_Lulus IN('Tepat') ORDER BY nim;");
    $totaljur_asalTKJT=mysqli_num_rows($queryjur_asalTKJT);

    $queryjur_asalTKJL=mysqli_query($connect,"SELECT nim FROM MahasiswaSementara WHERE JurusanAsal IN('TKJ') AND Status_Lulus IN('Lambat') ORDER BY nim;");
    $totaljur_asalTKJL=mysqli_num_rows($queryjur_asalTKJL);

    $queryjur_asalIPAT=mysqli_query($connect,"SELECT nim FROM MahasiswaSementara WHERE JurusanAsal IN('IPA') AND Status_Lulus IN('Tepat') ORDER BY nim;");
    $totaljur_asalIPAT=mysqli_num_rows($queryjur_asalIPAT);

    $queryjur_asalIPAL=mysqli_query($connect,"SELECT nim FROM MahasiswaSementara WHERE JurusanAsal IN('IPA') AND Status_Lulus IN('Lambat') ORDER BY nim;");
    $totaljur_asalIPAL=mysqli_num_rows($queryjur_asalIPAL);

    $queryjur_asalIPST=mysqli_query($connect,"SELECT nim FROM MahasiswaSementara WHERE JurusanAsal IN('IPS') AND Status_Lulus IN('Tepat') ORDER BY nim;");
    $totaljur_asalIPST=mysqli_num_rows($queryjur_asalIPST);

    $queryjur_asalIPSL=mysqli_query($connect,"SELECT nim FROM MahasiswaSementara WHERE  JurusanAsal IN('IPS') AND Status_Lulus IN('Lambat') ORDER BY nim;");
    $totaljur_asalIPSL=mysqli_num_rows($queryjur_asalIPSL);

    $queryjur_asalLainT=mysqli_query($connect,"SELECT nim FROM MahasiswaSementara WHERE JurusanAsal IN('Lain') AND Status_Lulus IN('Tepat') ORDER BY nim;");
    $totaljur_asalLainT=mysqli_num_rows($queryjur_asalLainT);

    $queryjur_asalLainL=mysqli_query($connect,"SELECT nim FROM MahasiswaSementara WHERE JurusanAsal IN('Lain') AND Status_Lulus IN('Lambat') ORDER BY nim;");
    $totaljur_asalLainL=mysqli_num_rows($queryjur_asalLainL);


    $queryips1TT=mysqli_query($connect,"SELECT nim FROM MahasiswaSementara WHERE IPS1 IN('Terpenuhi') AND Status_Lulus IN('Tepat') ORDER BY nim;");
    $totalips1TT=mysqli_num_rows($queryips1TT);

    $queryips1TL=mysqli_query($connect,"SELECT nim FROM MahasiswaSementara WHERE IPS1 IN('Terpenuhi') AND Status_Lulus IN('Lambat') ORDER BY nim;");
    $totalips1TL=mysqli_num_rows($queryips1TL);

    $queryips1KT=mysqli_query($connect,"SELECT nim FROM MahasiswaSementara WHERE IPS1 IN('Kurang') AND Status_Lulus IN('Tepat') ORDER BY nim;");
    $totalips1KT=mysqli_num_rows($queryips1KT);

    $queryips1KL=mysqli_query($connect,"SELECT nim FROM MahasiswaSementara WHERE IPS1 IN('Kurang') AND Status_Lulus IN('Lambat') ORDER BY nim;");
    $totalips1KL=mysqli_num_rows($queryips1KL);


    $queryipkTT=mysqli_query($connect,"SELECT nim FROM MahasiswaSementara WHERE IPK IN('Terpenuhi') AND Status_Lulus IN('Tepat') ORDER BY nim;");
    $totalipkTT=mysqli_num_rows($queryipkTT);

    $queryipkTL=mysqli_query($connect,"SELECT nim FROM MahasiswaSementara WHERE IPK IN('Terpenuhi') AND Status_Lulus IN('Lambat') ORDER BY nim;");
    $totalipkTL=mysqli_num_rows($queryipkTL);

    $queryipkKT=mysqli_query($connect,"SELECT nim FROM MahasiswaSementara WHERE IPK IN('Kurang') AND Status_Lulus IN('Tepat') ORDER BY nim;");
    $totalipkKT=mysqli_num_rows($queryipkKT);

    $queryipkKL=mysqli_query($connect,"SELECT nim FROM MahasiswaSementara WHERE IPK IN('Kurang') AND Status_Lulus IN('Lambat') ORDER BY nim;");
    $totalipkKL=mysqli_num_rows($queryipkKL);


    $querytot_sksTT=mysqli_query($connect,"SELECT nim FROM MahasiswaSementara WHERE TotalSKS IN('Terpenuhi') AND Status_Lulus IN('Tepat') ORDER BY nim;");
    $totaltot_sksTT=mysqli_num_rows($querytot_sksTT);

    $querytot_sksTL=mysqli_query($connect,"SELECT nim FROM MahasiswaSementara WHERE TotalSKS IN('Terpenuhi') AND Status_Lulus IN('Lambat') ORDER BY nim;");
    $totaltot_sksTL=mysqli_num_rows($querytot_sksTL);

    $querytot_sksKT=mysqli_query($connect,"SELECT nim FROM MahasiswaSementara WHERE TotalSKS IN('Kurang') AND Status_Lulus IN('Tepat') ORDER BY nim;");
    $totaltot_sksKT=mysqli_num_rows($querytot_sksKT);

    $querytot_sksKL=mysqli_query($connect,"SELECT nim FROM MahasiswaSementara WHERE TotalSKS IN('Kurang') AND Status_Lulus IN('Lambat') ORDER BY nim;");
    $totaltot_sksKL=mysqli_num_rows($querytot_sksKL);


    $querytot_jumDTT=mysqli_query($connect,"SELECT nim FROM MahasiswaSementara WHERE JumD IN('Terpenuhi') AND Status_Lulus IN('Tepat') ORDER BY nim;");
    $totaltot_jumDTT=mysqli_num_rows($querytot_jumDTT);

    $querytot_jumDTL=mysqli_query($connect,"SELECT nim FROM MahasiswaSementara WHERE JumD IN('Terpenuhi') AND Status_Lulus IN('Lambat') ORDER BY nim;");
    $totaltot_jumDTL=mysqli_num_rows($querytot_jumDTL);

    $querytot_jumDBT=mysqli_query($connect,"SELECT nim FROM MahasiswaSementara WHERE JumD IN('Banyak') AND Status_Lulus IN('Tepat') ORDER BY nim;");
    $totaltot_jumDBT=mysqli_num_rows($querytot_jumDBT);

    $querytot_jumDBL=mysqli_query($connect,"SELECT nim FROM MahasiswaSementara WHERE JumD IN('Banyak ') AND Status_Lulus IN('Lambat') ORDER BY nim;");
    $totaltot_jumDBL=mysqli_num_rows($querytot_jumDBL);


    $querytot_jumETT=mysqli_query($connect,"SELECT nim FROM MahasiswaSementara WHERE JumE IN('Terpenuhi') AND Status_Lulus IN('Tepat') ORDER BY nim;");
    $totaltot_jumETT=mysqli_num_rows($querytot_jumETT);

    $querytot_jumETL=mysqli_query($connect,"SELECT nim FROM MahasiswaSementara WHERE JumE IN('Terpenuhi') AND Status_Lulus IN('Lambat') ORDER BY nim;");
    $totaltot_jumETL=mysqli_num_rows($querytot_jumETL);

    $querytot_jumEBT=mysqli_query($connect,"SELECT nim FROM MahasiswaSementara WHERE JumE IN('Banyak') AND Status_Lulus IN('Tepat') ORDER BY nim;");
    $totaltot_jumEBT=mysqli_num_rows($querytot_jumEBT);

    $querytot_jumEBL=mysqli_query($connect,"SELECT nim FROM MahasiswaSementara WHERE JumE IN('Banyak ') AND Status_Lulus IN('Lambat') ORDER BY nim;");
    $totaltot_jumEBL=mysqli_num_rows($querytot_jumEBL);


    echo "Total IPS1 Terpenuhi Tepat: " . $totalips1TT . "</br>";
    echo "Total IPS1 Terpenuhi Lambat: " . $totalips1TL . "</br>";
    echo "Total IPS1 Kurang Tepat: " . $totalips1KT . "</br>";
    echo "Total IPS1 Kurang Lambat: " . $totalips1KL . "</br>";

    echo "</br>";
    echo "Total IPK Terpenuhi Tepat: " . $totalipkTT . "</br>";
    echo "Total IPK Terpenuhi Lambat: " . $totalipkTL . "</br>";
    echo "Total IPK Kurang Tepat: " . $totalipkKT . "</br>";
    echo "Total IPK Kurang Lambat: " . $totalipkKL . "</br>";

    echo "</br>";
    echo "Total SKS Terpenuhi Tepat: " . $totaltot_sksTT . "</br>";
    echo "Total SKS Terpenuhi Lambat: " . $totaltot_sksTL . "</br>";
    echo "Total SKS Kurang Tepat: " . $totaltot_sksKT . "</br>";
    echo "Total SKS Kurang Lambat: " . $totaltot_sksKL . "</br>";

    echo "</br>";
    echo "Total JumD Terpenuhi Tepat: " . $totaltot_jumDTT . "</br>";
    echo "Total JumD Terpenuhi Lambat: " . $totaltot_jumDTL . "</br>";
    echo "Total JumD Banyak Tepat: " . $totaltot_jumDBT . "</br>";
    echo "Total JumD Banyak Lambat: " . $totaltot_jumDBL . "</br>";

    echo "</br>";
    echo "Total JumE Terpenuhi Tepat: " . $totaltot_jumETT . "</br>";
    echo "Total JumE Terpenuhi Lambat: " . $totaltot_jumETL . "</br>";
    echo "Total JumE Banyak Tepat: " . $totaltot_jumEBT . "</br>";
    echo "Total JumE Banyak Lambat: " . $totaltot_jumEBL . "</br>";

    echo "</br>";
    echo "Total Jurusan Asal MM Tepat: " . $totaljur_asalMMT . "</br>";
    echo "Total Jurusan Asal MM Lambat: " . $totaljur_asalMML . "</br>";
    echo "Total Jurusan Asal TKJ Tepat: " . $totaljur_asalTKJT . "</br>";
    echo "Total Jurusan Asal TKJ Lambat: " . $totaljur_asalTKJL . "</br>";
    echo "Total Jurusan Asal IPA Tepat: " . $totaljur_asalIPAT . "</br>";
    echo "Total Jurusan Asal IPA Lambat: " . $totaljur_asalIPAL . "</br>";
    echo "Total Jurusan Asal IPS Tepat: " . $totaljur_asalIPST . "</br>";
    echo "Total Jurusan Asal IPS Lambat: " . $totaljur_asalIPSL . "</br>";
    echo "Total Jurusan Asal Lain Tepat: " . $totaljur_asalLainT . "</br>";
    echo "Total Jurusan Asal Lain Lambat: " . $totaljur_asalLainL . "</br>";


    $probabilitasips1TT=$totalips1TT/$totalmahasiswatepat;
    $probabilitasips1TL=$totalips1TL/$totalmahasiswalambat;
    $probabilitasips1KT=$totalips1KT/$totalmahasiswatepat;
    $probabilitasips1KL=$totalips1KL/$totalmahasiswalambat;  

    $probabilitasipkTT=$totalipkTT/$totalmahasiswatepat;
    $probabilitasipkTL=$totalipkTL/$totalmahasiswalambat;
    $probabilitasipkKT=$totalipkKT/$totalmahasiswatepat;
    $probabilitasipkKL=$totalipkKL/$totalmahasiswalambat;

    $probabilitastot_sksTT=$totaltot_sksTT/$totalmahasiswatepat;
    $probabilitastot_sksTL=$totaltot_sksTL/$totalmahasiswalambat;
    $probabilitastot_sksKT=$totaltot_sksKT/$totalmahasiswatepat;
    $probabilitastot_sksKL=$totaltot_sksKL/$totalmahasiswalambat;  

    $probabilitastot_jumDTT=$totaltot_jumDTT/$totalmahasiswatepat;
    $probabilitastot_jumDTL=$totaltot_jumDTL/$totalmahasiswalambat;
    $probabilitastot_jumDBT=$totaltot_jumDBT/$totalmahasiswatepat;
    $probabilitastot_jumDBL=$totaltot_jumDBL/$totalmahasiswalambat;    

    $probabilitastot_jumETT=$totaltot_jumETT/$totalmahasiswatepat;
    $probabilitastot_jumETL=$totaltot_jumETL/$totalmahasiswalambat;
    $probabilitastot_jumEBT=$totaltot_jumEBT/$totalmahasiswatepat;
    $probabilitastot_jumEBL=$totaltot_jumEBL/$totalmahasiswalambat;    

    $probabilitastot_jur_asalMMT=$totaljur_asalMMT/$totalmahasiswatepat;
    $probabilitastot_jur_asalMML=$totaljur_asalMML/$totalmahasiswalambat;
    $probabilitastot_jur_asalTKJT=$totaljur_asalTKJT/$totalmahasiswatepat;
    $probabilitastot_jur_asalTKJL=$totaljur_asalTKJL/$totalmahasiswalambat;    
    $probabilitastot_jur_asalIPAT=$totaljur_asalIPAT/$totalmahasiswatepat;
    $probabilitastot_jur_asalIPAL=$totaljur_asalIPAL/$totalmahasiswalambat;
    $probabilitastot_jur_asalIPST=$totaljur_asalIPST/$totalmahasiswatepat;
    $probabilitastot_jur_asalIPSL=$totaljur_asalIPSL/$totalmahasiswalambat;    
    $probabilitastot_jur_asalLainT=$totaljur_asalLainT/$totalmahasiswatepat;
    $probabilitastot_jur_asalLainL=$totaljur_asalLainL/$totalmahasiswalambat;    


    echo "</br>";
    echo "Probabiltas MM Tepat  = " . $probabilitastot_jur_asalMMT . "<br/>";
    echo "Probabiltas MM Lambat  = " . $probabilitastot_jur_asalMML . "<br/>";
    echo "Probabiltas TKJ Tepat  = " . $probabilitastot_jur_asalTKJT . "<br/>";
    echo "Probabiltas TKJ Lambat  = " . $probabilitastot_jur_asalTKJL . "<br/>";
    echo "Probabiltas IPA Tepat  = " . $probabilitastot_jur_asalIPAT. "<br/>";
    echo "Probabiltas IPA Lambat  = " . $probabilitastot_jur_asalIPAL . "<br/>";
    echo "Probabiltas IPS Tepat  = " . $probabilitastot_jur_asalIPST . "<br/>";
    echo "Probabiltas IPS Lambat  = " . $probabilitastot_jur_asalIPSL . "<br/>";
    echo "Probabiltas LAIN Tepat  = " . $probabilitastot_jur_asalLainT . "<br/>";
    echo "Probabiltas LAIN Lambat  = " . $probabilitastot_jur_asalLainL . "<br/>";

    echo "</br>";
    echo "Probabiltas IPS1 Terpenuhi Tepat  = " . $probabilitasips1TT . "<br/>";
    echo "Probabiltas IPS1 Terpenuhi Lambat  = " . $probabilitasips1TL . "<br/>";
    echo "Probabiltas IPS1 Kurang Tepat  = " . $probabilitasips1KT . "<br/>";
    echo "Probabiltas IPS1 Kurang Lambat  = " . $probabilitasips1KL . "<br/>";

    echo "<br/>";
    echo "Probabiltas IPK Terpenuhi Tepat  = " . $probabilitasipkTT . "<br/>";
    echo "Probabiltas IPK Terpenuhi Lambat  = " . $probabilitasipkTL . "<br/>";
    echo "Probabiltas IPK Kurang Tepat  = " . $probabilitasipkKT . "<br/>";
    echo "Probabiltas IPK Kurang Lambat  = " . $probabilitasipkKL . "<br/>";

    echo "<br/>";
    echo "Probabiltas Total SKS Terpenuhi Tepat  = " . $probabilitastot_sksTT . "<br/>";
    echo "Probabiltas Total SKS Terpenuhi Lambat  = " . $probabilitastot_sksTL . "<br/>";
    echo "Probabiltas Total SKS Kurang Tepat  = " . $probabilitastot_sksKT . "<br/>";
    echo "Probabiltas Total SKS Kurang Lambat  = " . $probabilitastot_sksKL . "<br/>";

    echo "<br/>";
    echo "Probabiltas Total Nilai D Terpenuhi Tepat  = " . $probabilitastot_jumDTT . "<br/>";
    echo "Probabiltas Total Nilai D Terpenuhi Lambat  = " . $probabilitastot_jumDTL . "<br/>";
    echo "Probabiltas Total NIlai D Banyak Tepat  = " . $probabilitastot_jumDBT . "<br/>";
    echo "Probabiltas Total Nilai D Banyak Lambat  = " . $probabilitastot_jumDBL . "<br/>";

    echo "<br/>";
    echo "Probabiltas Total Nilai E Terpenuhi Tepat  = " . $probabilitastot_jumETT . "<br/>";
    echo "Probabiltas Total Nilai E Terpenuhi Lambat  = " . $probabilitastot_jumETL . "<br/>";
    echo "Probabiltas Total NIlai E Banyak Tepat  = " . $probabilitastot_jumEBT . "<br/>";
    echo "Probabiltas Total Nilai E Banyak Lambat  = " . $probabilitastot_jumEBL . "<br/>";


    //Data Testing
    mysqli_query($connect,"CREATE TEMPORARY TABLE MahasiswaSementaraBL(Nim INT (10)
        ,JurusanAsalBL varchar(10)
        ,IPS1BL varchar(10)
        ,IPKBL varchar(10)
        ,TotalSKSBL varchar(10)
        ,JumDBL varchar(10)
        ,JumEBL varchar(10)
        ,Status_Lulus varchar(255));");
    $querymahasiswaBL=mysqli_query($connect,"SELECT nim FROM mahasiswa WHERE status IN('BL') ORDER BY nim;");
    $totalmahasiswaBL=mysqli_num_rows($querymahasiswaBL);

    $testingarray=array();
          while  ($getnimmahasiswaBL=mysqli_fetch_assoc($querymahasiswaBL)){
            $testingarray[]=$getnimmahasiswaBL['nim'];
    }
    $loop=1;

    for ($minout=1;$minout<=$totalmahasiswaBL;$minout++){
    $nimBL=mysqli_fetch_assoc(mysqli_query($connect,"SELECT nim FROM Mahasiswa WHERE nim=".$testingarray[$minout-1].";"));

    $jur_asalBL=mysqli_fetch_assoc(mysqli_query($connect,"SELECT jurusan_asalsekolah, IF(jurusan_asalsekolah='Multimedia', 'Multimedia', IF(jurusan_asalsekolah='TKJ', 'TKJ', IF(jurusan_asalsekolah='IPA', 'IPA', IF(jurusan_asalsekolah='IPS', 'IPS', 'Lain')))) As Jurusan FROM mahasiswa WHERE nim=".$testingarray[$minout-1].";") );

    $ipsBL=mysqli_fetch_assoc(mysqli_query($connect,"SELECT ips1, IF(ips1>='2', 'Terpenuhi', 'Kurang') As IPS1 FROM mahasiswa WHERE nim=".$testingarray[$minout-1].";") );

    $ipkBL=mysqli_fetch_assoc(mysqli_query($connect,"SELECT ipk4, IF(ipk4>='2', 'Terpenuhi', 'Kurang') As IPK FROM mahasiswa WHERE nim=".$testingarray[$minout-1].";") );

    $tot_sksBL=mysqli_fetch_assoc(mysqli_query($connect,"SELECT tot_sks4, IF(tot_sks4>='82', 'Terpenuhi','Kurang') As Tot_sks FROM Mahasiswa WHERE nim=".$testingarray[$minout-1].";"));

    $jumDBL=mysqli_fetch_assoc(mysqli_query($connect,"SELECT jumD4, IF(jumD4<=tot_sks4*0.2, 'Terpenuhi', 'Banyak') AS jumD FROM Mahasiswa WHERE nim=".$testingarray[$minout-1].";"));

    $jumEBL=mysqli_fetch_assoc(mysqli_query($connect,"SELECT jumE4, IF(jumE4<'1', 'Terpenuhi', 'Banyak') AS jumE FROM Mahasiswa WHERE nim=".$testingarray[$minout-1].";"));

    
    $status_lulusBL=mysqli_fetch_assoc(mysqli_query($connect,"SELECT status FROM Mahasiswa WHERE nim=".$testingarray[$minout-1].";"));
    

    mysqli_query($connect,"INSERT INTO MahasiswaSementaraBL (Nim, JurusanAsalBL ,IPS1BL, IPKBL, TotalSKSBL, JumDBL, JumEBL, Status_Lulus)
        VALUES ('".$nimBL['nim']."','".$jur_asalBL['Jurusan']."','".$ipsBL['IPS1']."','".$ipkBL['IPK']."','".$tot_sksBL['Tot_sks']."','".$jumDBL['jumD']."','".$jumEBL['jumE']."','".$status_lulusBL['status']."'); ");
    $loop+=1;
    };

     //Menampilkan Tabel Mahasiswa Sementara
    echo "<div class='container'>
    <center><h3 class='page-header'>Tampilan Tabel Mahasiswa Sementara Belum Lulus </h3></center>
     <table class='table table-striped table-bordered'>
    <thead class='thead-light'>
      <tr>
        <th>NIM</th>
        <th>Jurusan Asal</th>
        <th>IPS1</th>
        <th>IPK</th>
        <th>Total SKS</th>
        <th>Jumlah D</th>
        <th>Jumlah E</th>
        <th>STATUS</th>
      </tr>
    </thead>
    <tbody>
    <tr>
    ";

    $tampilBL=mysqli_query($connect,"SELECT Nim, JurusanAsalBL ,IPS1BL, IPKBL, TotalSKSBL, JumDBL, JumEBL, Status_Lulus FROM MahasiswaSementaraBL;") or die(mysqli_errno($connect));
    while($tampilkanBL=mysqli_fetch_assoc($tampilBL)){
    echo "<tr>";
    echo "<td>".$tampilkanBL['Nim']."</td>";
    echo "<td>".$tampilkanBL['JurusanAsalBL']."</td>";
    echo "<td>".$tampilkanBL['IPS1BL']."</td>";
    echo "<td>".$tampilkanBL['IPKBL']."</td>";
    echo "<td>".$tampilkanBL['TotalSKSBL']."</td>";
    echo "<td>".$tampilkanBL['JumDBL']."</td>";
    echo "<td>".$tampilkanBL['JumEBL']."</td>";
    echo "<td>" . $tampilkanBL['Status_Lulus']. "</td>";
        echo "</tr>";
        
    };

    echo " </tbody></table>
    </div>";

    echo "<br/>";


    //Probabilitas Data Testing
    mysqli_query($connect,"CREATE TEMPORARY TABLE MahasiswaPrediksi(Nim INT (10)
        ,JurusanAsalTepat float(7)
        ,JurusanAsalLambat float(7)
        ,IPS1Tepat float(7)
        ,IPS1Lambat float(7)
        ,IPKT float(7)
        ,IPKL float(7)
        ,TotalSKST float(7)
        ,TotalSKSL float(7)
        ,JumDT float(7)
        ,JumDL float(7)
        ,JumET float(7)
        ,JumEL float(7)
        ,Status_Lulus varchar(255));");

    $querymahasiswaBL=mysqli_query($connect,"SELECT nim FROM mahasiswa WHERE status IN('BL') ORDER BY nim;");
    $totalmahasiswaBL=mysqli_num_rows($querymahasiswaBL);

    $prediksiarray=array();
          while  ($getnimmahasiswaBL=mysqli_fetch_assoc($querymahasiswaBL)){
            $prediksiarray[]=$getnimmahasiswaBL['nim'];
    }
    $loop=1;

    for ($minout=1;$minout<=$totalmahasiswaBL;$minout++){
    $nimprediski=mysqli_fetch_assoc(mysqli_query($connect,"SELECT nim FROM Mahasiswa WHERE nim=".$prediksiarray[$minout-1].";"));


    $jur_asalTepat=mysqli_fetch_assoc(mysqli_query($connect,"SELECT JurusanAsalBL, IF(JurusanAsalBL='Multimedia', $probabilitastot_jur_asalMMT, IF(JurusanAsalBL='TKJ', $probabilitastot_jur_asalTKJT, IF(JurusanAsalBL='IPA', $probabilitastot_jur_asalIPAT, IF(JurusanAsalBL='IPS', $probabilitastot_jur_asalIPST, $probabilitastot_jur_asalLainT))))  As JurusanAsalT FROM MahasiswaSementaraBL WHERE nim=".$prediksiarray[$minout-1].";") );
    $jur_asalLambat=mysqli_fetch_assoc(mysqli_query($connect,"SELECT JurusanAsalBL, IF(JurusanAsalBL='Multimedia', $probabilitastot_jur_asalMML, IF(JurusanAsalBL='TKJ', $probabilitastot_jur_asalTKJL, IF(JurusanAsalBL='IPA', $probabilitastot_jur_asalIPAL, IF(JurusanAsalBL='IPS', $probabilitastot_jur_asalIPSL, $probabilitastot_jur_asalLainL))))  As JurusanAsalL FROM MahasiswaSementaraBL WHERE nim=".$prediksiarray[$minout-1].";") );

    $ips1Tepat=mysqli_fetch_assoc(mysqli_query($connect,"SELECT IPS1BL, IF(IPS1BL='Terpenuhi', $probabilitasips1TT, $probabilitasips1KT) As IPS1T FROM MahasiswaSementaraBL WHERE nim=".$prediksiarray[$minout-1].";") );
    $ips1Lambat=mysqli_fetch_assoc(mysqli_query($connect,"SELECT IPS1BL, IF(IPS1BL='Terpenuhi', $probabilitasips1TL, 
        $probabilitasips1KL ) As IPS1L FROM MahasiswaSementaraBL WHERE nim=".$prediksiarray[$minout-1].";") );

    $ipkTepat=mysqli_fetch_assoc(mysqli_query($connect,"SELECT IPKBL, IF(IPKBL='Terpenuhi', $probabilitasipkTT, $probabilitasipkKT) As IPKT FROM MahasiswaSementaraBL WHERE nim=".$prediksiarray[$minout-1].";") );
    $ipkLambat=mysqli_fetch_assoc(mysqli_query($connect,"SELECT IPKBL, IF(IPKBL='Terpenuhi', $probabilitasipkTL, 
        $probabilitasipkKL ) As IPKL FROM MahasiswaSementaraBL WHERE nim=".$prediksiarray[$minout-1].";") );

    $tot_sksTepat=mysqli_fetch_assoc(mysqli_query($connect,"SELECT TotalSKSBL, IF(TotalSKSBL='Terpenuhi', $probabilitastot_sksTT, $probabilitastot_sksKT) As TotalSKST FROM MahasiswaSementaraBL WHERE nim=".$prediksiarray[$minout-1].";") );
    $tot_sksLambat=mysqli_fetch_assoc(mysqli_query($connect,"SELECT TotalSKSBL, IF(TotalSKSBL='Terpenuhi', $probabilitastot_sksTL, $probabilitastot_sksKL ) As TotalSKSL FROM MahasiswaSementaraBL WHERE nim=".$prediksiarray[$minout-1].";") );

    $jumDTepat=mysqli_fetch_assoc(mysqli_query($connect,"SELECT JumDBL, IF(JumDBL='Terpenuhi', $probabilitastot_jumDTT, $probabilitastot_jumDBT) As JumD FROM MahasiswaSementaraBL WHERE nim=".$prediksiarray[$minout-1].";") );
    $jumDLambat=mysqli_fetch_assoc(mysqli_query($connect,"SELECT JumDBL, IF(JumDBL='Terpenuhi', $probabilitastot_jumDTL, $probabilitastot_jumDBL ) As JumD FROM MahasiswaSementaraBL WHERE nim=".$prediksiarray[$minout-1].";") );

    $jumETepat=mysqli_fetch_assoc(mysqli_query($connect,"SELECT JumEBL, IF(JumEBL='Terpenuhi', $probabilitastot_jumETT, $probabilitastot_jumEBT) As JumE FROM MahasiswaSementaraBL WHERE nim=".$prediksiarray[$minout-1].";") );
    $jumELambat=mysqli_fetch_assoc(mysqli_query($connect,"SELECT JumEBL, IF(JumEBL='Terpenuhi', $probabilitastot_jumETL, $probabilitastot_jumEBL ) As JumE FROM MahasiswaSementaraBL WHERE nim=".$prediksiarray[$minout-1].";") );
        
    $status_lulusprediksi=mysqli_fetch_assoc(mysqli_query($connect,"SELECT status FROM Mahasiswa WHERE nim=".$testingarray[$minout-1].";"));
    

    mysqli_query($connect,"INSERT INTO MahasiswaPrediksi (Nim, JurusanAsalTepat, JurusanAsalLambat, IPS1Tepat, IPS1Lambat, IPKT, IPKL, TotalSKST, TotalSKSL, JumDT, JumDL, JumET, JumEL, Status_Lulus)
        VALUES ('".$nimprediski['nim']."','".$jur_asalTepat['JurusanAsalT']."','".$jur_asalLambat['JurusanAsalL']."','".$ips1Tepat['IPS1T']."','".$ips1Lambat['IPS1L']."','".$ipkTepat['IPKT']."','".$ipkLambat['IPKL']."','".$tot_sksTepat['TotalSKST']."','".$tot_sksLambat['TotalSKSL']."','".$jumDTepat['JumD']."','".$jumDLambat['JumD']."','".$jumETepat['JumE']."','".$jumELambat['JumE']."','".$status_lulusprediksi['status']."'); ");
    $loop+=1;
    };

    

     //Menampilkan Tabel Mahasiswa Sementara
    echo "<div class='container'>
    <center><h3 class='page-header'>Tampilan Tabel Mahasiswa Probabiltas Predikssi </h3></center>
     <table class='table table-striped table-bordered'>
    <thead class='thead-light'>
      <tr>
        <th>NIM</th>
        <th>Jurusan T</th>
        <th>Jurusan L</th>
        <th>IPS1T</th>
        <th>IPS1L</th>
        <th>IPKT</th>
        <th>IPKL</th>
        <th>TotalSKST</th>
        <th>TotalSKSL</th>
        <th>JumDT</th>
        <th>JumDL</th>
        <th>JumET</th>
        <th>JumEL</th>
       <th>STATUS</th>
      </tr>
    </thead>
    <tbody>
    <tr>
    ";

    $tampilBL=mysqli_query($connect,"SELECT Nim, JurusanAsalTepat, JurusanAsalLambat, IPS1Tepat, IPS1Lambat, IPKT, IPKL, TotalSKST, TotalSKSL, JumDT, JumDL, JumET, JumEL, Status_Lulus FROM MahasiswaPrediksi;") or die(mysqli_errno($connect));
    while($tampilkanBL=mysqli_fetch_assoc($tampilBL)){
    echo "<tr>";
    echo "<td>".$tampilkanBL['Nim']."</td>";
    echo "<td>".$tampilkanBL['JurusanAsalTepat']."</td>";
    echo "<td>".$tampilkanBL['JurusanAsalLambat']."</td>";
    echo "<td>".$tampilkanBL['IPS1Tepat']."</td>";
    echo "<td>".$tampilkanBL['IPS1Lambat']."</td>";
    echo "<td>".$tampilkanBL['IPKT']."</td>";
    echo "<td>".$tampilkanBL['IPKL']."</td>";
    echo "<td>".$tampilkanBL['TotalSKST']."</td>";
    echo "<td>".$tampilkanBL['TotalSKSL']."</td>";    
    echo "<td>".$tampilkanBL['JumDT']."</td>";
    echo "<td>".$tampilkanBL['JumDL']."</td>";    
    echo "<td>".$tampilkanBL['JumET']."</td>";
    echo "<td>".$tampilkanBL['JumEL']."</td>";    
    echo "<td>" . $tampilkanBL['Status_Lulus']. "</td>";
        echo "</tr>";
        
    };

    echo " </tbody></table>
    </div>";

    echo "<br/>";


    //Likelihoad
    mysqli_query($connect,"CREATE TEMPORARY TABLE MahasiswaLikelihoad(Nim INT (10)
        ,LikelihoadTepat float(7)
        ,LikelihoadLambat float(7)
        ,Status_Lulus varchar(255));");

    $querymahasiswaBL=mysqli_query($connect,"SELECT nim FROM mahasiswa WHERE status IN('BL') ORDER BY nim;");
    $totalmahasiswaBL=mysqli_num_rows($querymahasiswaBL);

    $likelihoadarray=array();
          while  ($getnimmahasiswaBL=mysqli_fetch_assoc($querymahasiswaBL)){
            $likelihoadarray[]=$getnimmahasiswaBL['nim'];
    }
    $loop=1;

    for ($minout=1;$minout<=$totalmahasiswaBL;$minout++){
    $nimprediski=mysqli_fetch_assoc(mysqli_query($connect,"SELECT nim FROM Mahasiswa WHERE nim=".$likelihoadarray[$minout-1].";"));

    $likelihoadTepat=mysqli_fetch_assoc(mysqli_query($connect,"SELECT JurusanAsalTepat*IPS1Tepat*IPKT*TotalSKST*JumDT*JumET As likelihoadT FROM MahasiswaPrediksi WHERE nim=".$likelihoadarray[$minout-1].";") );
    $likelihoadLambat=mysqli_fetch_assoc(mysqli_query($connect,"SELECT JurusanAsalLambat*IPS1Lambat*IPKL*TotalSKSL*JumDL*JumEL As likelihoadL FROM MahasiswaPrediksi WHERE nim=".$likelihoadarray[$minout-1].";") );

    $status_lulusprediksi=mysqli_fetch_assoc(mysqli_query($connect,"SELECT status FROM Mahasiswa WHERE nim=".$testingarray[$minout-1].";"));

    mysqli_query($connect,"INSERT INTO MahasiswaLikelihoad (Nim, LikelihoadTepat, LikelihoadLambat, Status_Lulus)
        VALUES ('".$nimprediski['nim']."','".$likelihoadTepat['likelihoadT']."','".$likelihoadLambat['likelihoadL']."','".$status_lulusprediksi['status']."'); ");
    $loop+=1;
    };

     //Menampilkan Tabel Mahasiswa Sementara
    echo "<div class='container'>
    <center><h3 class='page-header'>Tampilan Tabel Mahasiswa Probabiltas Predikssi </h3></center>
     <table class='table table-striped table-bordered'>
    <thead class='thead-light'>
      <tr>
        <th>NIM</th>
        <th>Jurusan T</th>
        <th>Jurusan L</th>
       <th>STATUS</th>
      </tr>
    </thead>
    <tbody>
    <tr>
    ";

    $tampilBL=mysqli_query($connect,"SELECT Nim, LikelihoadTepat, LikelihoadLambat, Status_Lulus FROM MahasiswaLikelihoad;") or die(mysqli_errno($connect));
    while($tampilkanBL=mysqli_fetch_assoc($tampilBL)){
    echo "<tr>";
    echo "<td>".$tampilkanBL['Nim']."</td>";
    echo "<td>".$tampilkanBL['LikelihoadTepat']."</td>";
    echo "<td>".$tampilkanBL['LikelihoadLambat']."</td>";    
    echo "<td>" . $tampilkanBL['Status_Lulus']. "</td>";
        echo "</tr>";
        
    };

    echo " </tbody></table>
    </div>";

    echo "<br/>";
?>