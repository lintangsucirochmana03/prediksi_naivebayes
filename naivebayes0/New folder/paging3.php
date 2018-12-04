<title>Paging dengan PHP</title>
    <?php 
 
    // Deklarasi variabel
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';

    // Menghubungkan ke basis data
    mysql_connect($dbhost, $dbuser, $dbpass) or die('Gagal Koneksi: ' . mysql_error());
    mysql_select_db('dbmahasiswa');

    // Menghitung jumlah baris
    $sqlawal = "SELECT count(nim) FROM mahasiswa";
    $ambildataawal = mysql_query($sqlawal);
    $row = mysqli_fetch_array($ambildataawal);
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

    // Menampilkan baris tabel
    $left_rec = $hitung - ($page * $batas);
    $sql = "SELECT nim, nama, status ".
           "FROM mahasiswa ".
           "LIMIT $offset, $batas";
    $ambildata = mysql_query($sql);
    while($rowakhir = mysqli_fetch_array($ambildata))
    {
        echo "<table><tr><td>Nim:</td><th>{$rowakhir['nim']}</th></tr>".
             "<tr><td>Nama:</td><th>{$rowakhir['nama']}</th></tr>".
             "<tr><td>status:</td><th>{$rowakhir['status']}</th></tr></table>".
             "--------------------------------<br>";
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