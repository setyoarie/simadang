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
            require_once "../../class/supplier.php";
            $insert_supplier = new supplier('localhost', 'root', '', 'simadang');
            
            // ambil data hasil submit dari form
            $id_supplier  = mysqli_real_escape_string($mysqli, trim($_POST['id_supplier']));
            $nama_supplier  = mysqli_real_escape_string($mysqli, trim($_POST['nama_supplier']));
            $alamat     = mysqli_real_escape_string($mysqli, trim($_POST['alamat']));
            $telp     = mysqli_real_escape_string($mysqli, trim($_POST['telp']));
            $norek     = mysqli_real_escape_string($mysqli, trim($_POST['norek']));

            $insert_supplier->insert_supplier($id_supplier, $nama_supplier, $alamat, $telp, $norek);
        } 
    }
    
    elseif ($_GET['act']=='update') {
        if (isset($_POST['simpan'])) {
            if (isset($_POST['id_supplier'])) {
                include '../../class/supplier.php';      
                $edit_supplier = new supplier('localhost', 'root', '', 'simadang');
                $data = $edit_supplier->edit_supplier();
            }
        }
    }

    elseif ($_GET['act']=='delete') {
        if (isset($_GET['id'])) {
            $id_supplier = $_GET['id'];
    
            require_once "../../class/supplier.php";
            $delete_supplier = new supplier('localhost', 'root', '', 'simadang');
            $delete_supplier->delete_supplier($id_supplier);
        }
    }       
}       
?>