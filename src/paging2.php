<title>Paging dengan PHP</title>
    <?php 
    include ("koneksi.php");

    // Menghitung jumlah baris
    $sql = "SELECT count(nim) FROM Mahasiswa";
    $ambildata = mysqli_query($sql);
    $row = mysqli_fetch_array($ambildata);
    $hitung = $row[0];
    $batas = 3;

    // Mengecek eksistensi variabel '?page'

    if(isset($_GET['page']))
    {
       $page = $_GET['page'] + 1;
       $offset = $batas * $page ;
    }
    else
    {
       $page = 0;
       $offset = 0;
    }

    echo "<div class='container'>
    <center><h3>Tabel Data Training </h3></center>
     <table id='tbl-import'>
    <thead class='thead-light'>
      <tr>
      <th>No</th>
        <th>NIM</th>
        <th>Nama</th>
        <th>JurusanAsal</th>
        <th>PRODI</th>
        <th>Tahun Masuk</th>
        <th>IPS 1</th>
        <th>IPK</th>
        <th>TotalSKS</th>
        <th>JumD</th>
        <th>JumE</th>
        <th>Status lulus</th>
      </tr>
    </thead>
    <tbody>
    <tr>
    ";
    // Menampilkan baris tabel
    //$mulai = ($page>1) ? ($page * $halaman) - $halaman : 0;
    //$no =$mulai+1;
    $left_rec = $hitung - ($page * $batas);
    $sqlnew = "SELECT * FROM mahasiswa LIMIT $offset, $batas";
    $ambildatanew = mysqli_query($sqlnew);
    while($tampilkan = mysqli_fetch_array($ambildatanew))
    {

        echo "<tr>";
    //echo " <td>". $no++. "</td>";
    echo "<td>".$tampilkan['nim']."</td>";
    echo "<td>".$tampilkan['nama']."</td>";
    echo "<td>".$tampilkan['jurusan_asalsekolah']."</td>";
    echo "<td>".$tampilkan['prodi']."</td>";
    echo "<td>".$tampilkan['th_masuk']."</td>";
    echo "<td>".$tampilkan['ips1']."</td>";
    echo "<td>".$tampilkan['ipk4']."</td>";
    echo "<td>".$tampilkan['tot_sks4']."</td>";
    echo "<td>".$tampilkan['jumD4']."</td>";
    echo "<td>".$tampilkan['jumE4']."</td>";
    echo "<td>" . $tampilkan['status']. "</td>";
        echo "</tr>";
        

      /*   "<table><tr><td>NAMA:</td><th>{$row['Nama']}</th></tr>".
             "<tr><td>PENDIDIKAN:</td><th>{$row['pendidikanTerakhir']}</th></tr>".
             "<tr><td>JADWAL:</td><th>{$row['jadwalWawancara']}</th></tr></table>".
             "--------------------------------<br>"; */
    }



    // Menampilkan tombol 'Next' dan 'Previous'
    if( $page > 0 )
    {
       $last = $page - 2;
       echo "<a href=\"paging.php?page=$last\">Prev</a> |";
       echo "<a href=\"paging.php?page=$page\">Next</a>";
    }
    else if( $page == 0 )
    {
       echo "<a href=\"paging.php?page=$page\">Next</a>";
    }
    else if( $left_rec < $batas )
    {
       $last = $page - 2;
       echo "<a href=\"paging.php?page=$last\">Prev</a>";
    }
    ?>