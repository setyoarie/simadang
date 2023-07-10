<?php 

class klien{
    public $mysqli; // variabel untuk menyimpan objek koneksi ke database
  
  // konstruktor untuk membuat koneksi ke database
  public function __construct($host, $user, $password, $database) {
    $this->mysqli = new mysqli($host, $user, $password, $database);
    if ($this->mysqli->connect_errno) {
      die("Koneksi ke database gagal: " . $this->mysqli->connect_error);
    }
  }

  public function getKlien(){
    $no = 1;
    $query = $this->mysqli->query("SELECT a.id_klien,a.nama_klien,a.nama_perusahaan,a.alamat,a.no_telp
                                   FROM klien as a  ")
                                   or die('Ada kesalahan pada query tampil Data Klien: '.mysqli_error($this->mysqli));
    $result = array(); // variabel untuk menyimpan hasil query
    while ($data = $query->fetch_assoc()) {
      // menyimpan data ke variabel hasil query
      $result[] = array(
        'no' => $no,
        'id_klien' => $data['id_klien'],
        'nama_klien' => $data['nama_klien'],
        'nama_perusahaan' => $data['nama_perusahaan'],
        'alamat' => $data['alamat'],
        'no_telp' => $data['no_telp']
      );
      $no++;
    }
    return $result;
  }

  public function edit_klien(){
    if (isset($_POST['id_klien'])) {
        // ambil data hasil submit dari form
        $id_klien  = mysqli_real_escape_string($this->mysqli, trim($_POST['id_klien']));
        $nama_klien  = mysqli_real_escape_string($this->mysqli, trim($_POST['nama_klien']));
        $nama_perusahaan  = mysqli_real_escape_string($this->mysqli, trim($_POST['nama_perusahaan']));
        $alamat     = mysqli_real_escape_string($this->mysqli, trim($_POST['alamat']));
        $no_telp     = mysqli_real_escape_string($this->mysqli, trim($_POST['no_telp']));

        // perintah query untuk mengubah data pada tabel barang
        $query = mysqli_query($this->mysqli, "UPDATE klien SET 
                                                            id_klien        = '$id_klien',
                                                            nama_klien      = '$nama_klien',
                                                            nama_perusahaan = '$nama_perusahaan',
                                                            alamat          = '$alamat',
                                                            no_telp         = '$no_telp'
                                                    WHERE id_klien          = '$id_klien'")
                                        or die('Ada kesalahan pada query update : '.mysqli_error($this->mysqli));

            // cek query
            if ($query) {
                // jika berhasil tampilkan pesan berhasil update data
                header("location: ../../main.php?module=klien&alert=2");
            }         
        }
    }

    public function delete_klien($id_klien){
        // perintah query untuk menghapus data pada tabel barang
        $query = mysqli_query($this->mysqli, "DELETE FROM klien WHERE id_klien = '$id_klien'");
        
        // cek hasil query
        if ($query) {
            // jika berhasil tampilkan pesan berhasil delete data
            header("location: ../../main.php?module=klien&alert=3");
        }
    }

    public function insert_klien($id_klien,$nama_klien,$nama_perusahaan,$alamat,$no_telp){
        // cek apakah kode barang telah digunakan
        $query = mysqli_query($this->mysqli, "SELECT * FROM klien WHERE id_klien='$id_klien'")
        or die('Ada kesalahan pada query user: '.mysqli_error($this->mysqli));
        $rows  = mysqli_num_rows($query);

        // jika data ada, jalankan perintah untuk membuat session
        if ($rows > 0) {
        echo "<script>window.alert('kode klien yang anda masukan sudah ada')
            window.location='location: ../../main.php?module=form_klien'</script>";
        } else {
        // perintah query untuk menyimpan data ke tabel barang
        $query = mysqli_query($this->mysqli, "INSERT INTO klien(
                                                id_klien, nama_klien, nama_perusahaan, alamat, no_telp) 
                                                VALUES
                                                ('$id_klien', '$nama_klien', '$nama_perusahaan', '$alamat', '$no_telp')")
                                                or die('Ada kesalahan pada query insert : '.mysqli_error($this->mysqli));    

        // cek query
        if ($query) {
            // jika berhasil tampilkan pesan berhasil simpan data
            header("location: ../../main.php?module=klien&alert=1");
        } 
        }
    }
}

?>