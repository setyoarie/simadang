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
            require_once "../../class/klien.php";
            $insert_klien = new klien('localhost', 'root', '', 'simadang');
            
            // ambil data hasil submit dari form
            $id_klien  = mysqli_real_escape_string($mysqli, trim($_POST['id_klien']));
            $nama_klien  = mysqli_real_escape_string($mysqli, trim($_POST['nama_klien']));
            $nama_perusahaan     = mysqli_real_escape_string($mysqli, trim($_POST['nama_perusahaan']));
            $alamat     = mysqli_real_escape_string($mysqli, trim($_POST['alamat']));
            $no_telp     = mysqli_real_escape_string($mysqli, trim($_POST['no_telp']));

            $insert_klien->insert_klien($id_klien, $nama_klien, $nama_perusahaan, $alamat, $no_telp);   
        }   
    }
    
    elseif ($_GET['act']=='update') {
        if (isset($_POST['simpan'])) {
            if (isset($_POST['id_klien'])) {
                include '../../class/klien.php';      
                $edit_klien = new klien('localhost', 'root', '', 'simadang');
                $data = $edit_klien->edit_klien();
            }
        }
    }

    elseif ($_GET['act']=='delete') {
        if (isset($_GET['id'])) {
            $id_klien = $_GET['id'];
    
            require_once "../../class/klien.php";
            $delete_klien = new klien('localhost', 'root', '', 'simadang');
            $delete_klien->delete_klien($id_klien);
        }
    }       
}       
?>