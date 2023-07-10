<?php

// membuat kelas untuk mengelola data barang
class Stok_Barang {
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
    $query = $this->mysqli->query("SELECT a.kode_barang,a.nama_barang,a.stok,a.jenis_barang,a.satuan
                                   FROM is_barang as a  ")
                                   or die('Ada kesalahan pada query tampil Data barang Masuk: '.mysqli_error($this->mysqli));
    $result = array(); // variabel untuk menyimpan hasil query
    while ($data = $query->fetch_assoc()) {
      // menyimpan data ke variabel hasil query
      $result[] = array(
        'no' => $no,
        'kode_barang' => $data['kode_barang'],
        'nama_barang' => $data['nama_barang'],
        'stok' => $data['stok'],
        'satuan' => $data['satuan'],
        'jenis_barang' => $data['jenis_barang']
      );
      $no++;
    }
    return $result;
  }

    public function edit_data_barang() {
        if (isset($_POST['kode_barang'])) {
            // ambil data hasil submit dari form
            $kode_barang  = mysqli_real_escape_string($this->mysqli, trim($_POST['kode_barang']));
            $nama_barang  = mysqli_real_escape_string($this->mysqli, trim($_POST['nama_barang']));
            $satuan     = mysqli_real_escape_string($this->mysqli, trim($_POST['satuan']));
            $jenis_barang     = mysqli_real_escape_string($this->mysqli, trim($_POST['jenis_barang']));
            $stok     = mysqli_real_escape_string($this->mysqli, trim($_POST['stok']));
            $keterangan    = mysqli_real_escape_string($this->mysqli, trim($_POST['keterangan']));

            // perintah query untuk mengubah data pada tabel barang
            $query = mysqli_query($this->mysqli, "UPDATE is_barang SET 
                                                                kode_barang       = '$kode_barang',
                                                                nama_barang   = '$nama_barang',
                                                                satuan         = '$satuan',
                                                                jenis_barang      = '$jenis_barang',
                                                                stok          = '$stok'
                                                        WHERE kode_barang      = '$kode_barang'")
                                            or die('Ada kesalahan pada query update : '.mysqli_error($this->mysqli));

            // cek query
            if ($query) {
                // jika berhasil tampilkan pesan berhasil update data
                header("location: ../../main.php?module=barang&alert=2");
            }         
        }
    }

    public function delete_data_barang($kode_barang) {
        // $mysqli = $this->mysqli;
    
        // perintah query untuk menghapus data pada tabel barang
        $query = mysqli_query($this->mysqli, "DELETE FROM is_barang WHERE kode_barang      = '$kode_barang'");
    
        // cek hasil query
        if ($query) {
            // jika berhasil tampilkan pesan berhasil delete data
            header("location: ../../main.php?module=barang&alert=3");
        }
    }

    public function insert_data_barang($kode_barang, $nama_barang, $satuan, $jenis_barang, $stok, $keterangan) {
        // cek apakah kode barang telah digunakan
        $query = mysqli_query($this->mysqli, "SELECT * FROM is_barang WHERE kode_barang='$kode_barang'")
                or die('Ada kesalahan pada query user: '.mysqli_error($this->mysqli));
        $rows  = mysqli_num_rows($query);
    
        // jika data ada, jalankan perintah untuk membuat session
        if ($rows > 0) {
            echo "<script>window.alert('kode barang yang anda masukan sudah ada')
                  window.location='location: ../../main.php?module=form_barang'</script>";
        } else {
            // perintah query untuk menyimpan data ke tabel barang
            $query = mysqli_query($this->mysqli, "INSERT INTO is_barang(
                                                    kode_barang, nama_barang, satuan, jenis_barang, stok, keterangan) 
                                                    VALUES
                                                    ('$kode_barang', '$nama_barang', '$satuan', '$jenis_barang', '$stok', '$keterangan')")
                                                    or die('Ada kesalahan pada query insert : '.mysqli_error($this->mysqli));    
    
            // cek query
            if ($query) {
                // jika berhasil tampilkan pesan berhasil simpan data
                header("location: ../../main.php?module=barang&alert=1");
            } 
        } 
    }
    
    
  
  // fungsi untuk menutup koneksi ke database
  public function close() {
    $this->mysqli->close();
  }
}