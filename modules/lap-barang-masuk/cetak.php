<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "simadang";

$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if(mysqli_connect_errno()){
    echo 'Gagal melakukan koneksi ke Database : '.mysqli_connect_error();
}
?>

<?php
                      
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=barangmasuk.xls");
 
// memanggil query dari database
                             
    $sqlshow = mysqli_query($koneksi,"SELECT b.kode_transaksi,b.tanggal_keluar,b.kdproject,b.penerima,b.alamat,b.total_keluar,a.nama_barang
    FROM barang_keluar as b INNER JOIN dbarang_keluar as a ON a.kode_transaksi=b.kode_transaksi "); 
        
?>

<h3>Barang Masuk</h3>

<table>
    <tr>
        <td width="0px">Tanggal : <?php echo date("d-m-Y") ?></td>
    </tr>
</table>

<table bordered="1">
    <thead bgcolor="eeeeee" align="center">
        <tr bgcolor="eeeeee">
            <th>No.</th>
            <th>Kode Purchase</th>
            <th>Tanggal</th>
            <th>Kode Project</th>
            <th>Penerima</th>
            <th>Alamat</th>
            <th>Total Purchase</th>
            <th>Nama Barang</th>
        </tr>
    </thead>
    <tbody>


    </tbody>

    </div>
    </div>
    </div>
    <?php
        //Menampilkan data dari database
        $no = 0;
        while ($rowshow = mysqli_fetch_row($sqlshow)) {
            $no++;
            echo '<tr>';
            echo '<td>' . $no . '</td>';
            echo '<td>' . $rowshow[0] . '</td>'; // Mengubah bagian ini untuk mencetak nilai kolom berdasarkan indeks numerik
            echo '<td>' . $rowshow[1] . '</td>'; // Mengubah bagian ini untuk mencetak nilai kolom berdasarkan indeks numerik
            echo '<td>' . $rowshow[2] . '</td>'; // Mengubah bagian ini untuk mencetak nilai kolom berdasarkan indeks numerik
            echo '<td>' . $rowshow[3] . '</td>'; // Mengubah bagian ini untuk mencetak nilai kolom berdasarkan indeks numerik
            echo '<td>' . $rowshow[4] . '</td>'; // Mengubah bagian ini untuk mencetak nilai kolom berdasarkan indeks numerik
            echo '<td>' . $rowshow[5] . '</td>'; // Mengubah bagian ini untuk mencetak nilai kolom berdasarkan indeks numerik
            echo '<td>' . $rowshow[6] . '</td>'; // Mengubah bagian ini untuk mencetak nilai kolom berdasarkan indeks numerik
            echo '</tr>';
        }
    ?>

</table>