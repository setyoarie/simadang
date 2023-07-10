<?php
session_start();

// Panggil koneksi database.php untuk koneksi database
require_once "../../config/database.php";

// fungsi untuk pengecekan status login user 
// jika user belum login, alihkan ke halaman login dan tampilkan pesan = 1
if (empty($_SESSION['username']) && empty($_SESSION['password'])){
    echo "<meta http-equiv='refresh' content='0; url=index.php?alert=1'>";
}
// jika user sudah login, maka jalankan perintah untuk insert, update, dan delete
else {
    if ($_GET['act']=='insert') {
        if (isset($_POST['simpan'])) {
            require_once "../../class/barang_masuk.php";
            $insert_data_barang = new barang_masuk('localhost', 'root', '', 'simadang');
            
            // ambil data hasil submit dari form
            $kode_transaksi  = mysqli_real_escape_string($mysqli, trim($_POST['kode_transaksi']));
            $tanggal  = mysqli_real_escape_string($mysqli, trim($_POST['tanggal_masuk']));;
            $kode_barang     = mysqli_real_escape_string($mysqli, trim($_POST['kode_barang']));
            $jumlah_masuk    = mysqli_real_escape_string($mysqli, trim($_POST['jumlah_masuk']));
            $total_stok    = mysqli_real_escape_string($mysqli, trim($_POST['total_stok']));
            

            $insert_data_barang->insert_barang_masuk($kode_transaksi, $tanggal, $kode_barang, $jumlah_masuk);        
            $insert_data_barang->update_stok_barang_masuk($total_stok, $kode_barang);

            // cek query
            if ($query) {        
                // cek query
                if ($query1) {                       
                    // jika berhasil tampilkan pesan berhasil simpan data
                    header("location: ../../main.php?module=barang_masuk&alert=1");
                }
            }   
        }   
    }
}       
?>