<?php
session_start();

require_once "../../config/database.php";

class UserController {

	public function handleRequest(){
    // Cek parameter 'act' dalam $_GET
    if (isset($_GET['act'])) {
        $action = $_GET['act'];
        
        // Pemrosesan tindakan berdasarkan nilai 'act'
        switch ($action) {
            case 'insert':
                $this->insertUser();
                break;
            case 'update':
                $this->updateUser();
                break;
            case 'on':
                $this->changeStatus('aktif');
                break;
            case 'off':
                $this->changeStatus('blokir');
                break;
            default:
                // Tindakan tidak valid
                header("location: ../../main.php?module=user&alert=0");
                break;
        }
    } else {
        // Parameter 'act' tidak ditemukan
        header("location: ../../main.php?module=user&alert=0");
    }
}

private function insertUser()
{
    if (isset($_POST['simpan'])) {
		$server   = "localhost";
		$username = "root";
		$password = "";
		$database = "simadang";
	
		// koneksi database
		$mysqli = new mysqli($server, $username, $password, $database);
	
		// cek koneksi
		if ($mysqli->connect_error) {
			die('Koneksi Database Gagal : '.$mysqli->connect_error);
		}

        // Ambil data hasil submit dari form
        $username = mysqli_real_escape_string($mysqli, trim($_POST['username']));
        $password = md5(mysqli_real_escape_string($mysqli, trim($_POST['password'])));
        $nama_user = mysqli_real_escape_string($mysqli, trim($_POST['nama_user']));
        $hak_akses = mysqli_real_escape_string($mysqli, trim($_POST['hak_akses']));
		$nama_file          = $_FILES['foto']['name'];
		$ukuran_file        = $_FILES['foto']['size'];
		$tipe_file          = $_FILES['foto']['type'];
		$tmp_file           = $_FILES['foto']['tmp_name'];
		// tentuka extension yang diperbolehkan
		$allowed_extensions = array('jpg','jpeg','png');
				
		// Set path folder tempat menyimpan gambarnya
		$path_file          = "../../images/user/".$nama_file;
		
		// check extension
		$file               = explode(".", $nama_file);
		$extension          = array_pop($file);


        // Perintah query untuk menyimpan data ke tabel users
        $query = mysqli_query($mysqli, "INSERT INTO is_users(username, password, nama_user, hak_akses, foto)
            VALUES('$username','$password','$nama_user','$hak_akses','$nama_file')");

        // Cek query
        if ($query) {
            // Jika berhasil, tampilkan pesan berhasil simpan data
            header("location: ../../main.php?module=user&alert=1");
        } else {
            // Jika query gagal, tampilkan pesan error
            die('Ada kesalahan pada query insert: ' . mysqli_error($mysqli));
        }
    }
}

private function updateUser()
{
	$server   = "localhost";
	$username = "root";
	$password = "";
	$database = "simadang";

	// koneksi database
	$mysqli = new mysqli($server, $username, $password, $database);

	// cek koneksi
	if ($mysqli->connect_error) {
		die('Koneksi Database Gagal : '.$mysqli->connect_error);
	}
    if (isset($_POST['simpan']) && isset($_POST['id_user'])) {
        // Ambil data hasil submit dari form
        $id_user = mysqli_real_escape_string($mysqli, trim($_POST['id_user']));
        $username = mysqli_real_escape_string($mysqli, trim($_POST['username']));
        $password = md5(mysqli_real_escape_string($mysqli, trim($_POST['password'])));
        $nama_user = mysqli_real_escape_string($mysqli, trim($_POST['nama_user']));
        $hak_akses = mysqli_real_escape_string($mysqli, trim($_POST['hak_akses']));

		$nama_file          = $_FILES['foto']['name'];
		$ukuran_file        = $_FILES['foto']['size'];
		$tipe_file          = $_FILES['foto']['type'];
		$tmp_file           = $_FILES['foto']['tmp_name'];
		// tentuka extension yang diperbolehkan
		$allowed_extensions = array('jpg','jpeg','png');
				
		// Set path folder tempat menyimpan gambarnya
		$path_file          = "../../images/user/".$nama_file;
		
		// check extension
		$file               = explode(".", $nama_file);
		$extension          = array_pop($file);

				// jika password tidak diubah dan foto tidak diubah
				if (empty($_POST['password']) && empty($_FILES['foto']['name'])) {
					// perintah query untuk mengubah data pada tabel users
                    $query = mysqli_query($mysqli, "UPDATE is_users SET username 	= '$username',
                    													nama_user 	= '$nama_user',
                    													hak_akses   = '$hak_akses'
                                                                  WHERE id_user 	= '$id_user'")
                                                    or die('Ada kesalahan pada query update : '.mysqli_error($mysqli));

                    // cek query
                    if ($query) {
                        // jika berhasil tampilkan pesan berhasil update data
                        header("location: ../../main.php?module=user&alert=2");
                    }
				}
				// jika password diubah dan foto tidak diubah
				elseif (!empty($_POST['password']) && empty($_FILES['foto']['name'])) {
					// perintah query untuk mengubah data pada tabel users
                    $query = mysqli_query($mysqli, "UPDATE is_users SET username 	= '$username',
                    													nama_user 	= '$nama_user',
                    													password 	= '$password',
                    													hak_akses   = '$hak_akses'
                                                                  WHERE id_user 	= '$id_user'")
                                                    or die('Ada kesalahan pada query update : '.mysqli_error($mysqli));

                    // cek query
                    if ($query) {
                        // jika berhasil tampilkan pesan berhasil update data
                        header("location: ../../main.php?module=user&alert=2");
                    }
				}
				// jika password tidak diubah dan foto diubah
				elseif (empty($_POST['password']) && !empty($_FILES['foto']['name'])) {
					// Cek apakah tipe file yang diupload sesuai dengan allowed_extensions
					if (in_array($extension, $allowed_extensions)) {
	                    // Jika tipe file yang diupload sesuai dengan allowed_extensions, lakukan :
	                    if($ukuran_file <= 1000000) { // Cek apakah ukuran file yang diupload kurang dari sama dengan 1MB
	                        // Jika ukuran file kurang dari sama dengan 1MB, lakukan :
	                        // Proses upload
	                        if(move_uploaded_file($tmp_file, $path_file)) { // Cek apakah gambar berhasil diupload atau tidak
                        		// Jika gambar berhasil diupload, Lakukan : 
                        		// perintah query untuk mengubah data pada tabel users
			                    $query = mysqli_query($mysqli, "UPDATE is_users SET username 	= '$username',
			                    													nama_user 	= '$nama_user',
			                    													foto 		= '$nama_file',
			                    													hak_akses   = '$hak_akses'
			                                                                  WHERE id_user 	= '$id_user'")
			                                                    or die('Ada kesalahan pada query update : '.mysqli_error($mysqli));

			                    // cek query
			                    if ($query) {
			                        // jika berhasil tampilkan pesan berhasil update data
			                        header("location: ../../main.php?module=user&alert=2");
			                    }
                        	} else {
	                            // Jika gambar gagal diupload, tampilkan pesan gagal upload
	                            header("location: ../../main.php?module=user&alert=5");
	                        }
	                    } else {
	                        // Jika ukuran file lebih dari 1MB, tampilkan pesan gagal upload
	                        header("location: ../../main.php?module=user&alert=6");
	                    }
	                } else {
	                    // Jika tipe file yang diupload bukan jpg, jpeg, png, tampilkan pesan gagal upload
	                    header("location: ../../main.php?module=user&alert=7");
	                } 
				}
				// jika password diubah dan foto diubah
				else {
					// Cek apakah tipe file yang diupload sesuai dengan allowed_extensions
					if (in_array($extension, $allowed_extensions)) {
	                    // Jika tipe file yang diupload sesuai dengan allowed_extensions, lakukan :
	                    if($ukuran_file <= 1000000) { // Cek apakah ukuran file yang diupload kurang dari sama dengan 1MB
	                        // Jika ukuran file kurang dari sama dengan 1MB, lakukan :
	                        // Proses upload
	                        if(move_uploaded_file($tmp_file, $path_file)) { // Cek apakah gambar berhasil diupload atau tidak
                        		// Jika gambar berhasil diupload, Lakukan : 
                        		// perintah query untuk mengubah data pada tabel users
			                    $query = mysqli_query($mysqli, "UPDATE is_users SET username 	= '$username',
			                    													nama_user 	= '$nama_user',
			                    													password    = '$password',
			                    													foto 		= '$nama_file',
			                    													hak_akses   = '$hak_akses'
			                                                                  WHERE id_user 	= '$id_user'")
			                                                    or die('Ada kesalahan pada query update : '.mysqli_error($mysqli));

			                    // cek query
			                    if ($query) {
			                        // jika berhasil tampilkan pesan berhasil update data
			                        header("location: ../../main.php?module=user&alert=2");
			                    }
                        	} else {
	                            // Jika gambar gagal diupload, tampilkan pesan gagal upload
	                            header("location: ../../main.php?module=user&alert=5");
	                        }
	                    } else {
	                        // Jika ukuran file lebih dari 1MB, tampilkan pesan gagal upload
	                        header("location: ../../main.php?module=user&alert=6");
	                    }
	                } else {
	                    // Jika tipe file yang diupload bukan jpg, jpeg, png, tampilkan pesan gagal upload
	                    header("location: ../../main.php?module=user&alert=7");
	                } 
				}
    }
}

private function changeStatus($status)
{
	$server   = "localhost";
	$username = "root";
	$password = "";
	$database = "simadang";

	// koneksi database
	$mysqli = new mysqli($server, $username, $password, $database);

	// cek koneksi
	if ($mysqli->connect_error) {
		die('Koneksi Database Gagal : '.$mysqli->connect_error);
	}
    if (isset($_GET['id_user'])) {
        $id_user = $_GET['id_user'];

        // Perintah query untuk mengubah status pengguna
        $query = mysqli_query($mysqli, "UPDATE is_users SET status='$status' WHERE id_user='$id_user'");

        // Cek query
        if ($query) {
            // Jika berhasil, tampilkan pesan berhasil ubah status
            header("location: ../../main.php?module=user&alert=3");
        } else {
            // Jika query gagal, tampilkan pesan error
            die('Ada kesalahan pada query changeStatus: ' . mysqli_error($mysqlimysqli));
        }
    }
}

}

$userController = new UserController();
$userController->handleRequest();
?>
