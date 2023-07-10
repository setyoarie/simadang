<?php 

class supplier{
  public $mysqli; // variabel untuk menyimpan objek koneksi ke database
  
  // konstruktor untuk membuat koneksi ke database
  public function __construct($host, $user, $password, $database) {
    $this->mysqli = new mysqli($host, $user, $password, $database);
    if ($this->mysqli->connect_errno) {
      die("Koneksi ke database gagal: " . $this->mysqli->connect_error);
    }
  }

  public function getSupplier(){
    $no = 1;
    $query = $this->mysqli->query("SELECT a.id_supplier,a.nama_supplier,a.alamat,a.telp,a.norek
                                   FROM supplier as a  ")
                                   or die('Ada kesalahan pada query tampil Data Supplier: '.mysqli_error($this->mysqli));
    $result = array(); // variabel untuk menyimpan hasil query
    while ($data = $query->fetch_assoc()) {
      // menyimpan data ke variabel hasil query
      $result[] = array(
        'no' => $no,
        'id_supplier' => $data['id_supplier'],
        'nama_supplier' => $data['nama_supplier'],
        'alamat' => $data['alamat'],
        'telp' => $data['telp'],
        'norek' => $data['norek']
      );
      $no++;
    }
    return $result;
  }

  public function edit_supplier(){
    if (isset($_POST['id_supplier'])) {
        // ambil data hasil submit dari form
        $id_supplier  = mysqli_real_escape_string($this->mysqli, trim($_POST['id_supplier']));
        $nama_supplier  = mysqli_real_escape_string($this->mysqli, trim($_POST['nama_supplier']));
        $alamat     = mysqli_real_escape_string($this->mysqli, trim($_POST['alamat']));
        $telp     = mysqli_real_escape_string($this->mysqli, trim($_POST['telp']));
        $norek     = mysqli_real_escape_string($this->mysqli, trim($_POST['norek']));

        // perintah query untuk mengubah data pada tabel barang
        $query = mysqli_query($this->mysqli, "UPDATE supplier SET 
                                                            id_supplier       = '$id_supplier',
                                                            nama_supplier   = '$nama_supplier',
                                                            alamat         = '$alamat',
                                                            telp      = '$telp',
                                                            norek          = '$norek'
                                                    WHERE id_supplier      = '$id_supplier'")
                                        or die('Ada kesalahan pada query update : '.mysqli_error($this->mysqli));

        // cek query
        if ($query) {
            // jika berhasil tampilkan pesan berhasil update data
            header("location: ../../main.php?module=supplier&alert=2");
        }         
    }
  }

  public function delete_supplier($id_supplier){
    // perintah query untuk menghapus data pada tabel barang
    $query = mysqli_query($this->mysqli, "DELETE FROM supplier WHERE id_supplier = '$id_supplier'");
    
    // cek hasil query
    if ($query) {
        // jika berhasil tampilkan pesan berhasil delete data
        header("location: ../../main.php?module=supplier&alert=3");
    }
  }

  public function insert_supplier($id_supplier, $nama_supplier, $alamat, $telp, $norek){
    // cek apakah kode barang telah digunakan
    $query = mysqli_query($this->mysqli, "SELECT * FROM supplier WHERE id_supplier='$id_supplier'")
    or die('Ada kesalahan pada query user: '.mysqli_error($this->mysqli));
    $rows  = mysqli_num_rows($query);

    // jika data ada, jalankan perintah untuk membuat session
    if ($rows > 0) {
    echo "<script>window.alert('kode supplier yang anda masukan sudah ada')
          window.location='location: ../../main.php?module=form_supplier'</script>";
    } else {
      // perintah query untuk menyimpan data ke tabel barang
      $query = mysqli_query($this->mysqli, "INSERT INTO supplier(
                                              id_supplier, nama_supplier, alamat, telp, norek) 
                                              VALUES
                                              ('$id_supplier', '$nama_supplier', '$alamat', '$telp', '$norek')")
                                              or die('Ada kesalahan pada query insert : '.mysqli_error($this->mysqli));    

      // cek query
      if ($query) {
          // jika berhasil tampilkan pesan berhasil simpan data
          header("location: ../../main.php?module=supplier&alert=1");
      } 
    }
  }
}

?>