<?php

// membuat kelas untuk mengelola data barang
class barang_masuk {
  public $mysqli; // variabel untuk menyimpan objek koneksi ke database
  
  // konstruktor untuk membuat koneksi ke database
  public function __construct($host, $user, $password, $database) {
    $this->mysqli = new mysqli($host, $user, $password, $database);
    if ($this->mysqli->connect_errno) {
      die("Koneksi ke database gagal: " . $this->mysqli->connect_error);
    }
  }
  
  // fungsi untuk mengambil data barang dari database
  public function getBarang() {
    $no = 1;
    $query = $this->mysqli->query("SELECT a.kode_transaksi,a.tanggal_masuk,a.kode_barang,a.jumlah_masuk,b.kode_barang,b.nama_barang,b.satuan
                                            FROM is_barang_masuk as a INNER JOIN is_barang as b ON a.kode_barang=b.kode_barang ORDER BY kode_transaksi ASC")
                                            or die('Ada kesalahan pada query tampil Data barang Masuk: '.mysqli_error($this->mysqli));
    $result = array(); // variabel untuk menyimpan hasil query
    while ($data = $query->fetch_assoc()) {
  
      // menyimpan data ke variabel hasil query
      $result[] = array(
        'no' => $no,
        'kode_transaksi' => $data['kode_transaksi'],
        'tanggal_masuk' => $data['tanggal_masuk'],
        'kode_barang' => $data['kode_barang'],
        'nama_barang' => $data['nama_barang'],
        'jumlah_masuk' => $data['jumlah_masuk'],
        'satuan' => $data['satuan']
      );
      $no++;
    }
    return $result;
  }

    public function insert_barang_masuk($kode_transaksi,$tanggal_masuk, $kode_barang, $jumlah_masuk) {
            // perintah query untuk menyimpan data ke tabel barang
            $query = mysqli_query($this->mysqli, "INSERT INTO is_barang_masuk(
                                                    kode_transaksi, tanggal_masuk, kode_barang, jumlah_masuk) 
                                                    VALUES
                                                    ('$kode_transaksi', '$tanggal_masuk', '$kode_barang', '$jumlah_masuk')")
                                                    or die('Ada kesalahan pada query insert : '.mysqli_error($this->mysqli));  
    
            // cek query
            if ($query) {
                // jika berhasil tampilkan pesan berhasil simpan data
                header("location: ../../main.php?module=barang_masuk&alert=1");
            } 
         
    }
    
    public function update_stok_barang_masuk($total_stok, $kode_barang) {
      // perintah query untuk menyimpan data ke tabel barang
      $query = mysqli_query($this->mysqli, "UPDATE is_barang SET stok        = '$total_stok'
                                              WHERE kode_barang   = '$kode_barang'")
                                              or die('Ada kesalahan pada query update : '.mysqli_error($this->mysqli));  
   
}
  
  // fungsi untuk menutup koneksi ke database
  public function close() {
    $this->mysqli->close();
  }
}