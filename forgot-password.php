<?php
// Panggil file untuk koneksi ke database
require_once "config/database.php";

class ForgotPassword {
    private $mysqli;
    
    public function __construct() {
      $this->mysqli = new mysqli("localhost", "root", "", "simadang");
      
      if ($this->mysqli->connect_error) {
        die("Koneksi ke database gagal: " . $this->mysqli->connect_error);
      }
    }
    
    public function sendPasswordResetLink($email) {
      // Buat variabel untuk menyimpan pesan kesalahan
      $error = "";
      
      // Buat query untuk mengambil data user berdasarkan email
      $query = "SELECT * FROM is_users WHERE email=?";
        
      // Siapkan statement untuk query
      $stmt = $this->mysqli->prepare($query);
      
      // Bind parameter ke statement
      $stmt->bind_param("s", $email);
      
      // Jalankan statement
      $stmt->execute();
      
      // Ambil hasil query
      $result = $stmt->get_result();
      
      // Jika data user ditemukan, kirim email dengan link reset password
      if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $userId = $data['id_user'];
        
        // Generate password baru
        $newPassword = $_POST['password'];
        
        // Update password user di database
        $updateQuery = "UPDATE is_users SET password=? WHERE id_user=?";
        $updateStmt = $this->mysqli->prepare($updateQuery);
        $updateStmt->bind_param("ss", md5($newPassword), $userId);
        $updateStmt->execute();
        
        // Kirim email dengan password baru
        $emailBody = "Password baru Anda: " . $newPassword;
        
        // Mengirim email menggunakan library email Anda yang sesuai
        // Contoh: menggunakan PHPMailer
        // require_once "vendor/autoload.php";
        // $mail = new PHPMailer\PHPMailer\PHPMailer();
        // ...
        // $mail->send();
        
        // Jika email terkirim, berikan pesan sukses
        $successMessage = "Password baru telah dikirim ke email Anda.";
        return $successMessage;
      }
        
      // Jika data user tidak ditemukan, buat pesan kesalahan
      else {
        $error = "Email tidak terdaftar.";
      }
      
      // Tutup koneksi ke database
      $this->mysqli->close();
      
      // Kembalikan pesan kesalahan
      return $error;
    }

  }

  
    // Membuat objek dari class ForgotPassword
    $forgotPassword = new ForgotPassword();

    // Ambil data email hasil submit dari form
    $email = $_POST['email'];

    // Memanggil fungsi sendPasswordResetLink untuk mengirim email dengan password baru
    $result = $forgotPassword->sendPasswordResetLink($email);

    // Memeriksa apakah pengiriman email berhasil atau tidak
    if (is_string($result)) {
    // Jika berhasil, tampilkan pesan sukses
    header("Location: index.php?alert=3&pesan=" . urlencode($error));

    echo $result;
    } else {
    // Jika terdapat kesalahan, tampilkan pesan error
    echo "Terjadi kesalahan: " . $result;
    }

  
?>