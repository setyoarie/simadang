<?php
// Panggil file untuk koneksi ke database
require_once "config/database.php";

// Buat class Login
class Login {
  private $mysqli;
  
  // Konstruktor
  public function __construct() {
    $this->mysqli = new mysqli("localhost", "root", "", "simadang");
    
    if ($this->mysqli->connect_error) {
      die("Koneksi ke database gagal: " . $this->mysqli->connect_error);
    }
  }
  
  // Method untuk memproses login
  public function Validate($username, $password) {
    // Buat variabel untuk menyimpan pesan kesalahan
    $error = "";
    
    // Pastikan username dan password adalah berupa huruf atau angka.
    if (!ctype_alnum($username) OR !ctype_alnum($password)) {
      $error = "Username atau password hanya boleh berisi huruf dan angka!";
    }
    else {
      // Buat query untuk mengambil data user dari tabel is_users
      $query = "SELECT * FROM is_users WHERE username=? AND password=? AND status='aktif'";
      
      // Siapkan statement untuk query
      $stmt = $this->mysqli->prepare($query);
      
      // Bind parameter ke statement
      $stmt->bind_param("ss", $username, md5($password));
      
      // Jalankan statement
      $stmt->execute();
      
      // Ambil hasil query
      $result = $stmt->get_result();
      
      // Jika data user ada, jalankan perintah untuk membuat session
      if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        
        session_start();
        $_SESSION['id_user']   = $data['id_user'];
        $_SESSION['username']  = $data['username'];
        $_SESSION['password']  = $data['password'];
        $_SESSION['nama_user'] = $data['nama_user'];
        $_SESSION['hak_akses'] = $data['hak_akses'];
        
        // Lalu alihkan ke halaman user
        header("Location: main.php?module=beranda");
        exit();
      }
      
      // Jika data tidak ada, buat pesan kesalahan
      else {
        $error = "Username atau password salah!";
      }
    }
    
    // Tutup koneksi ke database
    $this->mysqli->close();
    
    // Kembalikan pesan kesalahan
    return $error;
  }
}
// Buat objek dari class Login
$login = new Login();

// Ambil data hasil submit dari form
$username = mysqli_real_escape_string($mysqli, stripslashes(strip_tags(htmlspecialchars(trim($_POST['username'])))));
$password = mysqli_real_escape_string($mysqli, stripslashes(strip_tags(htmlspecialchars(trim($_POST['password'])))));

// Proses login
$error = $login->Validate($username, $password);

// Jika terdapat pesan kesalahan, tampilkan di halaman login
if (!empty($error)) {
  header("Location: index.php?alert=1&pesan=" . urlencode($error));
}
?>