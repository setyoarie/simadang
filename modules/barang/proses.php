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
            require_once "../../class/Stok_Barang.php";
            $insert_data_barang = new Stok_Barang('localhost', 'root', '', 'simadang');
            
            // ambil data hasil submit dari form
            $kode_barang  = mysqli_real_escape_string($mysqli, trim($_POST['kode_barang']));
            $nama_barang  = mysqli_real_escape_string($mysqli, trim($_POST['nama_barang']));
            $satuan     = mysqli_real_escape_string($mysqli, trim($_POST['satuan']));
            $jenis_barang     = mysqli_real_escape_string($mysqli, trim($_POST['jenis_barang']));
            $stok     = mysqli_real_escape_string($mysqli, trim($_POST['stok']));
            $keterangan    = mysqli_real_escape_string($mysqli, trim($_POST['keterangan']));

            $insert_data_barang->insert_data_barang($kode_barang, $nama_barang, $satuan, $jenis_barang, $stok, $keterangan);        
        }   
    }
    
    elseif ($_GET['act']=='update') {
        if (isset($_POST['simpan'])) {
            if (isset($_POST['kode_barang'])) {
                include '../../class/Stok_Barang.php';      
                $edit_barang = new Stok_Barang('localhost', 'root', '', 'simadang');
                $data = $edit_barang->edit_data_barang();
            }
        }
    }

    elseif ($_GET['act']=='delete') {
        if (isset($_GET['id'])) {
            $kode_barang = $_GET['id'];
    
            require_once "../../class/Stok_Barang.php";
            $delete_barang = new Stok_Barang('localhost', 'root', '', 'simadang');
            $delete_barang->delete_data_barang($kode_barang);
        }

    }       
}       
?>