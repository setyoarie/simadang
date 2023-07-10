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
header("Content-Disposition: attachment; filename=barangkeluar.xls");
 
// memanggil query dari database
                             
    $sqlshow = mysqli_query($koneksi,"SELECT a.kode_transaksi,a.tanggal_keluar,a.penerima,a.username,b.kode_transaksi,b.kode_barang,b.jumlah
    FROM barang_keluar as a INNER JOIN dbarang_keluar as b ON a.kode_transaksi=b.kode_transaksi "); 
        
?>

<h3>Barang Keluar</h3>

<table>
    <tr>
        <td width="0px">Tanggal : <?php echo date("d-m-Y") ?></td>
    </tr>
</table>

<table bordered="1">
    <thead bgcolor="eeeeee" align="center">
        <tr bgcolor="eeeeee">
            <th>No.</th>
            <th>Kode Transaksi</th>
            <th>Tanggal</th>
            <th>Kode barang</th>
            <th>Nama Penerima</th>
            <th>Jumlah barang</th>
            <th>Pembuat</th>
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
            echo '<td>' . $rowshow[4] . '</td>'; // Mengubah bagian ini untuk mencetak nilai kolom berdasarkan indeks numerik
            echo '<td>' . $rowshow[1] . '</td>'; // Mengubah bagian ini untuk mencetak nilai kolom berdasarkan indeks numerik
            echo '<td>' . $rowshow[5] . '</td>'; // Mengubah bagian ini untuk mencetak nilai kolom berdasarkan indeks numerik
            echo '<td>' . $rowshow[2] . '</td>'; // Mengubah bagian ini untuk mencetak nilai kolom berdasarkan indeks numerik
            echo '<td>' . $rowshow[6] . '</td>'; // Mengubah bagian ini untuk mencetak nilai kolom berdasarkan indeks numerik
            echo '<td>' . $rowshow[3] . '</td>'; // Mengubah bagian ini untuk mencetak nilai kolom berdasarkan indeks numerik
            echo '</tr>';
        }
    ?>

</table>