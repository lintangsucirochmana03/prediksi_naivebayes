<?php
	include ("koneksi.php");

	//menghitung jumlah kelas target
    $querymahasiswatepat=mysqli_query($connect,"SELECT nim FROM mahasiswa WHERE status IN('tepat') ORDER BY nim;");
    $totalmahasiswatepat=mysqli_num_rows($querymahasiswatepat);

    $querymahasiswalambat=mysqli_query($connect,"SELECT nim FROM mahasiswa WHERE status IN('lambat') ORDER BY nim;");
    $totalmahasiswalambat=mysqli_num_rows($querymahasiswalambat);

    $querymahasiswalulus=mysqli_query($connect,"SELECT nim FROM mahasiswa WHERE status IN('lambat', 'tepat') ORDER BY nim;");
    $totalmahasiswalulus=mysqli_num_rows($querymahasiswalulus);


    //menghitung prior
    $prior_tepat = $totalmahasiswatepat / $totalmahasiswalulus;
    $prior_lambat = $totalmahasiswalambat / $totalmahasiswalulus;

    
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

    $ipknew=mysqli_fetch_assoc(mysqli_query($connect,"SELECT ipk, IF(ipk>='2', 'Terpenuhi', 'Kurang') As IPK FROM mahasiswa WHERE nim=".$dataarray[$minout-1].";") );

    $tot_sksnew=mysqli_fetch_assoc(mysqli_query($connect,"SELECT tot_sks, IF(tot_sks>=semester*18, 'Terpenuhi','Kurang') As Tot_sks FROM Mahasiswa WHERE nim=".$dataarray[$minout-1].";"));

    $jumDnew=mysqli_fetch_assoc(mysqli_query($connect,"SELECT jumD, IF(jumD<=tot_sks*0.2, 'Terpenuhi', 'Banyak') AS Dbaru FROM Mahasiswa WHERE nim=".$dataarray[$minout-1].";"));

    $jumEnew=mysqli_fetch_assoc(mysqli_query($connect,"SELECT jumE, IF(jumE<'1', 'Terpenuhi', 'Banyak') AS Ebaru FROM Mahasiswa WHERE nim=".$dataarray[$minout-1].";"));

    $status_lulus=mysqli_fetch_assoc(mysqli_query($connect,"SELECT status FROM Mahasiswa WHERE nim=".$dataarray[$minout-1].";"));
    


    mysqli_query($connect,"INSERT INTO MahasiswaSementara (Nim,Prodi,JurusanAsal,IPS1,IPK,TotalSKS,JumD,JumE,Status_Lulus)
        VALUES ('".$nimi['nim']."','".$prodinew['prodi']."','".$jurusan_asal['jurusan']."','".$ipsnew['IPS1']."','".$ipknew['IPK']."','".$tot_sksnew['Tot_sks']."','".$jumDnew['Dbaru']."','".$jumEnew['Ebaru']."','".$status_lulus['status']."'); ");
    $loop+=1;
    };
    

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

    $ipkBL=mysqli_fetch_assoc(mysqli_query($connect,"SELECT ipk, IF(ipk>='2', 'Terpenuhi', 'Kurang') As IPK FROM mahasiswa WHERE nim=".$testingarray[$minout-1].";") );

    $tot_sksBL=mysqli_fetch_assoc(mysqli_query($connect,"SELECT tot_sks, IF(tot_sks>=semester*18, 'Terpenuhi','Kurang') As Tot_sks FROM Mahasiswa WHERE nim=".$testingarray[$minout-1].";"));

    $jumDBL=mysqli_fetch_assoc(mysqli_query($connect,"SELECT jumD, IF(jumD<=tot_sks*0.2, 'Terpenuhi', 'Banyak') AS jumD FROM Mahasiswa WHERE nim=".$testingarray[$minout-1].";"));

    $jumEBL=mysqli_fetch_assoc(mysqli_query($connect,"SELECT jumE, IF(jumE<'1', 'Terpenuhi', 'Banyak') AS jumE FROM Mahasiswa WHERE nim=".$testingarray[$minout-1].";"));

    
    $status_lulusBL=mysqli_fetch_assoc(mysqli_query($connect,"SELECT status FROM Mahasiswa WHERE nim=".$testingarray[$minout-1].";"));
    

    mysqli_query($connect,"INSERT INTO MahasiswaSementaraBL (Nim, JurusanAsalBL ,IPS1BL, IPKBL, TotalSKSBL, JumDBL, JumEBL, Status_Lulus)
        VALUES ('".$nimBL['nim']."','".$jur_asalBL['Jurusan']."','".$ipsBL['IPS1']."','".$ipkBL['IPK']."','".$tot_sksBL['Tot_sks']."','".$jumDBL['jumD']."','".$jumEBL['jumE']."','".$status_lulusBL['status']."'); ");
    $loop+=1;
    };

 
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


    //Perklian Likelihoad dengan Prior
    mysqli_query($connect,"CREATE TEMPORARY TABLE MahasiswaLP(Nim INT (10)
        ,LPTepat float(7)
        ,LPLambat float(7)
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

    $LPTepat=mysqli_fetch_assoc(mysqli_query($connect,"SELECT LikelihoadTepat * $prior_tepat As LPT FROM MahasiswaLikelihoad WHERE nim=".$likelihoadarray[$minout-1].";") );
    $LPLambat=mysqli_fetch_assoc(mysqli_query($connect,"SELECT LikelihoadLambat * $prior_lambat As LPL FROM MahasiswaLikelihoad WHERE nim=".$likelihoadarray[$minout-1].";") );

    $status_lulusprediksi=mysqli_fetch_assoc(mysqli_query($connect,"SELECT status FROM Mahasiswa WHERE nim=".$testingarray[$minout-1].";"));

    mysqli_query($connect,"INSERT INTO MahasiswaLP (Nim, LPTepat, LPLambat, Status_Lulus)
        VALUES ('".$nimprediski['nim']."','".$LPTepat['LPT']."','".$LPLambat['LPL']."','".$status_lulusprediksi['status']."'); ");
    $loop+=1;
    };


    //Menghitung Probabilitas Posterior
    mysqli_query($connect,"CREATE TEMPORARY TABLE MahasiswaPosterior(Nim INT (10)
        ,PosteriorTepat float(7)
        ,PosteriorLambat float(7)
        ,Status_Lulus varchar(255));");

    $querymahasiswaBL=mysqli_query($connect,"SELECT nim FROM mahasiswa WHERE status IN('BL') ORDER BY nim;");
    $totalmahasiswaBL=mysqli_num_rows($querymahasiswaBL);

    $posteriorarray=array();
          while  ($getnimmahasiswaBL=mysqli_fetch_assoc($querymahasiswaBL)){
            $posteriorarray[]=$getnimmahasiswaBL['nim'];
    }
    $loop=1;

    for ($minout=1;$minout<=$totalmahasiswaBL;$minout++){
    $nimprediski=mysqli_fetch_assoc(mysqli_query($connect,"SELECT nim FROM Mahasiswa WHERE nim=".$posteriorarray[$minout-1].";"));

    $PosteriorTepat=mysqli_fetch_assoc(mysqli_query($connect,"SELECT LPTepat / (LPTepat+LPLambat) As PosteriorT FROM MahasiswaLP WHERE nim=".$likelihoadarray[$minout-1].";") );
    $PosteriorLambat=mysqli_fetch_assoc(mysqli_query($connect,"SELECT LPLambat / (LPTepat+LPLambat) As PosteriorL FROM MahasiswaLP WHERE nim=".$likelihoadarray[$minout-1].";") );

    $status_lulusprediksi=mysqli_fetch_assoc(mysqli_query($connect,"SELECT status FROM Mahasiswa WHERE nim=".$testingarray[$minout-1].";"));

    mysqli_query($connect,"INSERT INTO MahasiswaPosterior (Nim, PosteriorTepat, PosteriorLambat, Status_Lulus)
        VALUES ('".$nimprediski['nim']."','".$PosteriorTepat['PosteriorT']."','".$PosteriorLambat['PosteriorL']."','".$status_lulusprediksi['status']."'); ");
    $loop+=1;
    };


    //Menentukan Prediksi
    mysqli_query($connect,"CREATE TEMPORARY TABLE Prediksi(Nim INT (10)
        ,Prediksi varchar(7)
        ,Status_Lulus varchar(255));");

    $querymahasiswaBL=mysqli_query($connect,"SELECT nim FROM mahasiswa WHERE status IN('BL') ORDER BY nim;");
    $totalmahasiswaBL=mysqli_num_rows($querymahasiswaBL);

    $prediksirarray=array();
          while  ($getnimmahasiswaBL=mysqli_fetch_assoc($querymahasiswaBL)){
            $prediksirarray[]=$getnimmahasiswaBL['nim'];
    }
    $loop=1;

    for ($minout=1;$minout<=$totalmahasiswaBL;$minout++){
    $nimprediski=mysqli_fetch_assoc(mysqli_query($connect,"SELECT nim FROM Mahasiswa WHERE nim=".$prediksirarray[$minout-1].";"));

    $Prediksi=mysqli_fetch_assoc(mysqli_query($connect,"SELECT PosteriorTepat, PosteriorLambat, IF(PosteriorTepat>PosteriorLambat, 'Tepat', 'Lambat') As Prediksi FROM MahasiswaPosterior WHERE nim=".$prediksirarray[$minout-1].";") );

    $status_lulusprediksi=mysqli_fetch_assoc(mysqli_query($connect,"SELECT status FROM Mahasiswa WHERE nim=".$prediksirarray[$minout-1].";"));

    mysqli_query($connect,"INSERT INTO Prediksi (Nim, Prediksi, Status_Lulus)
        VALUES ('".$nimprediski['nim']."','".$Prediksi['Prediksi']."','".$status_lulusprediksi['status']."'); ");
    $loop+=1;
    };


    //Menampilkan Hasil Prediksi
    mysqli_query($connect,"CREATE TEMPORARY TABLE MahasiswaHasil(Nim INT (10)
        ,Nama varchar(30)
        ,JurusanAsal varchar(10)
        ,Prodi varchar(2)
        ,Semester INT(2)
        ,IPS1 float(10)
        ,IPK float(10)
        ,TotalSKS float(10)
        ,JumD float(10)
        ,JumE float(10)
        ,Status_Lulus varchar(255)
        ,Prediksi varchar(255));");

    $querymahasiswaHasil=mysqli_query($connect,"SELECT nim FROM mahasiswa WHERE status IN('BL') ORDER BY nim;");
    $totalmahasiswaHasil=mysqli_num_rows($querymahasiswaHasil);

    $hasilarray=array();
          while  ($getnimmahasiswaBL=mysqli_fetch_assoc($querymahasiswaHasil)){
            $hasilarray[]=$getnimmahasiswaBL['nim'];
          }
    $loop=1;

    for ($minout=1;$minout<=$totalmahasiswaHasil;$minout++){
    $nimi=mysqli_fetch_assoc(mysqli_query($connect,"SELECT nim FROM Mahasiswa WHERE nim=".$hasilarray[$minout-1].";"));

    $nama=mysqli_fetch_assoc(mysqli_query($connect,"SELECT nama FROM Mahasiswa WHERE nim=".$hasilarray[$minout-1].";"));
    
    $jurusan_asal=mysqli_fetch_assoc(mysqli_query($connect,"SELECT jurusan_asalsekolah FROM mahasiswa WHERE nim=".$hasilarray[$minout-1].";") );

    $prodinew=mysqli_fetch_assoc(mysqli_query($connect,"SELECT prodi FROM Mahasiswa WHERE nim=".$hasilarray[$minout-1].";"));

    $semesternew=mysqli_fetch_assoc(mysqli_query($connect,"SELECT semester FROM Mahasiswa WHERE nim=".$hasilarray[$minout-1].";"));

    $ipsnew=mysqli_fetch_assoc(mysqli_query($connect,"SELECT ips1 FROM mahasiswa WHERE nim=".$hasilarray[$minout-1].";") );

    $ipknew=mysqli_fetch_assoc(mysqli_query($connect,"SELECT ipk FROM mahasiswa WHERE nim=".$hasilarray[$minout-1].";") );

    $tot_sksnew=mysqli_fetch_assoc(mysqli_query($connect,"SELECT tot_sks FROM Mahasiswa WHERE nim=".$hasilarray[$minout-1].";"));

    $jumD4new=mysqli_fetch_assoc(mysqli_query($connect,"SELECT jumD FROM Mahasiswa WHERE nim=".$hasilarray[$minout-1].";"));

    $jumE4new=mysqli_fetch_assoc(mysqli_query($connect,"SELECT jumE FROM Mahasiswa WHERE nim=".$hasilarray[$minout-1].";"));

    $status_lulus=mysqli_fetch_assoc(mysqli_query($connect,"SELECT status FROM Mahasiswa WHERE nim=".$hasilarray[$minout-1].";"));

    $prediksi=mysqli_fetch_assoc(mysqli_query($connect,"SELECT Prediksi FROM Prediksi WHERE nim=".$hasilarray[$minout-1].";"));
    

    mysqli_query($connect,"INSERT INTO MahasiswaHasil (Nim,Nama,JurusanAsal,Prodi,Semester,IPS1,IPK,TotalSKS,JumD,JumE,Status_Lulus,Prediksi)
        VALUES ('".$nimi['nim']."','".$nama['nama']."','".$jurusan_asal['jurusan_asalsekolah']."','".$prodinew['prodi']."','".$semesternew['semester']."','".$ipsnew['ips1']."','".$ipknew['ipk']."','".$tot_sksnew['tot_sks']."','".$jumD4new['jumD']."','".$jumE4new['jumE']."','".$status_lulus['status']."','".$prediksi['Prediksi']."'); ");
    $loop+=1;
    };
    


