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
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header('Content-Disposition: attachment;filename="stokbarang.xls"');
 
// memanggil query dari database
                             
    $sqlshow = mysqli_query($koneksi,"SELECT * FROM is_barang"); 
        
?>

<h3>Data Barang</h3>

<table>
    <tr>
        <td width="0px">Tanggal : <?php echo date("d-m-Y") ?></td>
    </tr>
</table>

<table bordered="1">
    <thead bgcolor="eeeeee" align="center">
        <tr bgcolor="eeeeee">
            <th>No</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Stok</th>
            <th>Satuan</th>
            <th>Jenis Barang</th>
        </tr>
    </thead>
    <tbody>


    </tbody>

    </div>
    </div>
    </div>
    <?php
    //Menampilkan data dari database
    $nomor = 0;
    while ($rowshow = mysqli_fetch_row($sqlshow)) {
        $nomor++;
        echo '<tr>';
        echo '<td>' . $nomor . '</td>';
        echo '<td>' . $rowshow[1] . '</td>'; // Mengubah bagian ini untuk mencetak nilai kolom berdasarkan indeks numerik
        echo '<td>' . $rowshow[2] . '</td>'; // Mengubah bagian ini untuk mencetak nilai kolom berdasarkan indeks numerik
        echo '<td>' . $rowshow[5] . '</td>'; // Mengubah bagian ini untuk mencetak nilai kolom berdasarkan indeks numerik
        echo '<td>' . $rowshow[3] . '</td>'; // Mengubah bagian ini untuk mencetak nilai kolom berdasarkan indeks numerik
        echo '<td>' . $rowshow[4] . '</td>'; // Mengubah bagian ini untuk mencetak nilai kolom berdasarkan indeks numerik
        echo '</tr>';
    }
    ?>

</table>