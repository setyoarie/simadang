<?php
class DataBase{
	private $host = "localhost";
	private $user = "root";
	private $pass = "";
	private $db = "simadang";

	public function sambungkan(){
		$mysqli = mysqli_connect($this->host,$this->user,$this->pass);
		mysqli_select_db($mysqli,$this->db);
	}

}
        // CLASS DATA BARANG 
    class Barang{

            public function tampil_barang(){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                $qry = mysqli_query($mysqli,"SELECT * FROM is_barang ORDER BY nama_barang ASC");
                while ($pecah = mysqli_fetch_array($qry)) {
                    $data[] = $pecah;
                }
                return $data;
            }

            public function simpan_barang($kdbarang,$nama,$satuan,$hargaj,$hargab,$stok){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                mysqli_query($mysqli,"INSERT INTO is_barang(kode_barang,nama_barang,satuan,harga_jual,harga_beli,stok) 
                    VALUES('$kdbarang','$nama','$satuan','$hargaj','$hargab','$stok')");
            }

            public function ubah_barang($nama,$satuan,$hargaj,$hargab,$stok,$kd){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                mysqli_query($mysqli,"UPDATE is_barang SET nama_barang='$nama', satuan='$satuan', harga_jual='$hargaj',harga_beli='$hargab',stok='$stok' WHERE kd_barang = '$kd' ");
            }

            public function ambil_barang($id){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                $qry = "SELECT * FROM is_barang WHERE kode_barang = '$id'";
                $result = $mysqli->query($qry);
                $pecah = mysqli_fetch_assoc($result);

                return $pecah;
            }

            public function hapus_barang($kd){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                mysqli_query($mysqli,"DELETE FROM is_barang WHERE kode_barang = '$kd'");
            }

            public function simpan_barang_gudang($kdbarang,$hargaj,$kdbl){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                $dat = $this->ambil_barangpem($kdbl);
                $nama = $dat['nama_barang_beli'];
                $satuan = $dat['satuan'];
                $hargab = $dat['harga_beli'];
                $stok = $dat['item'];
                mysqli_query($mysqli,"INSERT INTO is_barang(kode_barang,nama_barang,satuan,harga_jual,harga_beli,stok) 
                    VALUES('$kdbarang','$nama','$satuan','$hargaj','$hargab','$stok')");
                //update data barang pembelian dengan setatus 1
                mysqli_query($mysqli,"UPDATE barang_keluar SET status='1' WHERE kd_barang_beli ='$kdbl'");
            }

            public function ambil_barangpem($kd){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                $qry = mysqli_query($mysqli,"SELECT * FROM barang_pembelian WHERE kd_barang_beli = '$kd'");
                $pecah = mysqli_fetch_assoc($qry);
                return $pecah;
            }

     }
     //AKHIR CLASS DATA BARANG

    // CLASS SUPPLIER
      class Supplier{
            public function tampil_supplier(){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                $qry = mysqli_query($mysqli,"SELECT * FROM supplier");
                while ($pecah = mysqli_fetch_array($qry)) {
                $data[] = $pecah;
                }
                return $data;
            }
            public function simpan_supplier($nama,$alamat){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                mysqli_query($mysqli,"INSERT INTO supplier(nama_supplier,alamat) VALUES('$nama','$alamat')");
            }
            public function ubah_supplier($nama,$alamat,$id){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                mysqli_query($mysqli,"UPDATE supplier SET nama_supplier='$nama', alamat='$alamat' WHERE kd_supplier = '$id'");
            }
            public function hapus_supplier($id){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                mysqli_query($mysqli,"DELETE FROM supplier WHERE kd_supplier= '$id'");
            }
            public function ambil_supplier($id){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                $qry = mysqli_query($mysqli,"SELECT * FROM supplier WHERE kd_supplier= '$id'");
                $pecah = mysqli_fetch_assoc($qry);
                return $pecah;
            }
        }  

    // AKHIR SUPPLIER

     // CLASS BARANGKELUAR
    class barangkeluar extends Barang {

            public function kode_otomatis(){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                 $query_id = mysqli_query($mysqli, "SELECT RIGHT(kode_transaksi,5) as kode FROM barang_keluar
                                                ORDER BY kode_transaksi DESC LIMIT 1")
                                                or die('Ada kesalahan pada query tampil kode_transaksi : '.mysqli_error($mysqli));

              $count = mysqli_num_rows($query_id);

              if ($count <> 0) {
                  // mengambil data kode transaksi
                  $data_id = mysqli_fetch_assoc($query_id);
                  $koder    = $data_id['kode']+1;
              } else {
                  $koder = 1;
              }

              // buat kode_transaksi
              $tahun          = date("Y");
              $buat_id        = str_pad($koder,5, "0", STR_PAD_LEFT);
              $kode= "TK-$tahun-$buat_id";
            }
        
            public function tampil_barang_keluar(){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                $qry = "SELECT * FROM is_barang WHERE stok > 0 ORDER BY kode_barang ASC";
                $result = $mysqli->query($qry);
                while ($pecah = mysqli_fetch_array($result)) {
                    $data[] = $pecah;
                }
                return $data;
            }

         
            
            public function tampil_keluar(){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                $qry = "SELECT * FROM barang_keluar ORDER BY kode_transaksi DESC";
                $result = $mysqli->query($qry);
                while ($pecah = mysqli_fetch_array($result)) {
                    $data[]=$pecah;
                }
                $hitung = mysqli_num_rows($result);
                    if ($hitung > 0) {
                        return $data;
                    }
                    else{
                        error_reporting(0);
                    }
            }

            public function cek_data_barangp($kode){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                $qry = "SELECT * FROM is_keluar_sementara WHERE kode_transaksi = '$kode'";
                $result = $mysqli->query($qry);
                if($result===false){
                    die(mysqli_error($mysqli));
                }
                $hitung = mysqli_fetch_array($result);
                
                if ($hitung >=1) {
                    return true;
                }
                else{
                    return false;
                
                }
            }

            public function tampil_barang_sementara($kode){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                $qry = mysqli_query($mysqli,"SELECT * FROM is_keluar_sementara WHERE kode_transaksi = '$kode'");
                while ($pecah = mysqli_fetch_array($qry)) {
                    $data[]=$pecah;
                }
                $hitung = mysqli_num_rows($qry);
                if ($hitung > 0) {
                    return $data;
                }
                else{
                    error_reporting(0);
                }
            }

            public function tambah_keluar_sementara($kdpen, $kdbarang, $item){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                $bar = $this->ambil_barang($kdbarang);
                $namabr = $bar['nama_barang'];
                $satuan = $bar['satuan'];

                mysqli_query($mysqli,"INSERT INTO is_keluar_sementara(kode_transaksi, kode_barang, nama_barang, satuan, item) 
                    VALUES('$kdpen', '$kdbarang','$namabr','$satuan','$item')");
                
                // UPDATE STOK BARANG PADA TABEL BARANG
                $kurang = $bar['stok'] - $item;
                mysqli_query($mysqli,"UPDATE is_barang SET stok = '$kurang' WHERE kode_barang = '$kdbarang'");
            }

            public function cek_item($kdbarang,$item){
                $data = $this->ambil_barang($kdbarang);
                $jumitem = $data['stok'];
                if ($item < $jumitem+1) {
                    return true;
                }
                else{
                    echo "<script>bootbox.alert('Item tidak cukup, $jumitem tersisa di gudang!', function(){
                        window.location='module=form_barang_keluar';
                    });</script>";
                }
            }

            public function hitung_total_sementara($kode){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                $qry = "SELECT sum(item) as jumlah FROM is_keluar_sementara WHERE kode_transaksi = '$kode'";
                $result = $mysqli->query($qry);
                if($result===false){
                    die(mysqli_error($mysqli));
                }

                while($pecah = mysqli_fetch_array($result))
                {
                $cek = $this->cek_data_barangp($kode);
                if ($cek === true) {
                    $subtotal = $pecah['jumlah'];
                }
                else{
                    $subtotal = 0;
                }
                return $subtotal;
                }
            } 
            public function hitung_item_keluar($kdbrgkeluar){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                $qry = mysqli_query($mysqli,"SELECT count(*) as jumlah FROM dbarang_keluar WHERE kode_transaksi = '$kdbrgkeluar'");
                $pecah = mysqli_fetch_array($qry);

                return $pecah;  
            }
            public function simpan_brgkeluar($kdbrgkeluar,$tglbrgkeluar,$kdproject,$penerima,$alamat,$subtotal,$created_user){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                //insert keluar
                mysqli_query($mysqli, "INSERT INTO barang_keluar(kode_transaksi,tanggal_keluar,kdproject,penerima,alamat,total_keluar,username) 
                VALUES('$kdbrgkeluar','$tglbrgkeluar','$kdproject','$penerima','$alamat','$subtotal','$created_user')");
                
                //insert dkeluar
                mysqli_query($mysqli, "INSERT INTO dbarang_keluar(kode_transaksi,tanggal_keluar,kode_barang,nama_barang,jumlah) 
                    SELECT kode_transaksi,'$tglbrgkeluar',kode_barang,nama_barang,item FROM is_keluar_sementara WHERE kode_transaksi='$kdbrgkeluar'");

                //hapus semua keluar sementera
                mysqli_query($mysqli, "DELETE FROM is_keluar_sementara WHERE kode_transaksi = '$kdbrgkeluar'");
            }

            public function ambil_kdpen(){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                $qry = mysqli_query($mysqli, "SELECT * FROM barang_keluar ORDER BY kode_transaksi DESC LIMIT 1");
                $pecah = mysqli_fetch_assoc($qry);
                return $pecah;
            }

            public function hapus_keluar_sementara($kd){
                $mysqli = new mysqli("localhost", "root", "", "simadang");

                //update barang, di kembalikan ke setok semula
                $datpen = $this->ambil_keluar_sementara($kd);
                $datbar = $this->ambil_barang($datpen['kode_barang']);
                $stok = $datpen['item']+$datbar['stok'];
                $kdbar = $datpen['kode_barang'];
                mysqli_query($mysqli,"UPDATE is_barang SET stok ='$stok' WHERE kode_barang = '$kdbar'");

                //hapus keluar sementara
                mysqli_query($mysqli,"DELETE FROM is_keluar_sementara WHERE id_keluar_sementara = '$kd'");
            }

            public function ambil_keluar_sementara($kd){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                $qry = mysqli_query($mysqli,"SELECT * FROM is_keluar_sementara WHERE id_keluar_sementara = '$kd'");
                $pecah = mysqli_fetch_assoc($qry);
                return $pecah;
            }
     }
     // AKHIR CLASS BARANGKELUAR

     // CLASS PERMINTAAN
     class permintaan extends Barang {

            public function kode_otomatis(){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                 $query_id = mysqli_query($mysqli, "SELECT RIGHT(kode_transaksi,5) as kode FROM permintaan
                                                ORDER BY kode_transaksi DESC LIMIT 1")
                                                or die('Ada kesalahan pada query tampil kode_transaksi : '.mysqli_error($mysqli));

              $count = mysqli_num_rows($query_id);

              if ($count <> 0) {
                  // mengambil data kode transaksi
                  $data_id = mysqli_fetch_assoc($query_id);
                  $koder    = $data_id['kode']+1;
              } else {
                  $koder = 1;
              }

              // buat kode_transaksi
              $tahun          = date("Y");
              $buat_id        = str_pad($koder,5, "0", STR_PAD_LEFT);
              $kode= "TK-$tahun-$buat_id";
            }
        
            public function tampil_barang_permintaan(){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                $qry = mysqli_query($mysqli,"SELECT * FROM is_barang WHERE stok > 0 ORDER BY nama_barang ASC");
                while ($pecah = mysqli_fetch_array($qry)) {
                    $data[] = $pecah;
                }
                return $data;
            }

         
            
            public function tampil_keluar(){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                $qry = mysqli_query($mysqli,"SELECT * FROM permintaan ORDER BY kode_transaksi DESC");
                while ($pecah = mysqli_fetch_array($qry)) {
                    $data[]=$pecah;
                }
                $hitung = mysqli_num_rows($qry);
                    if ($hitung > 0) {
                        return $data;
                    }
                    else{
                        error_reporting(0);
                    }
            }

            public function cek_data_barangp($kode){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                $qry = mysqli_query($mysqli,"SELECT * FROM is_permintaan_sementara WHERE kode_transaksi = '$kode'");
                if($qry===false){
                    die(mysqli_error($mysqli));
                }
                $hitung = mysqli_fetch_array($qry);
                
                if ($hitung >=1) {
                    return true;
                }
                else{
                    return false;
                
                }
            }

            public function tampil_permintaan_sementara($kode){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                $qry = mysqli_query($mysqli,"SELECT * FROM is_permintaan_sementara WHERE kode_transaksi = '$kode'");
                while ($pecah = mysqli_fetch_array($qry)) {
                    $data[]=$pecah;
                }
                $hitung = mysqli_num_rows($qry);
                if ($hitung > 0) {
                    return $data;
                }
                else{
                    error_reporting(0);
                }
            }

            public function tambah_permintaan_sementara($kdpen, $kdbarang, $item){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                $bar = $this->ambil_barang($kdbarang);
                $namabr = $bar['nama_barang'];
                $satuan = $bar['satuan'];
                $harga = $bar['harga_jual'];
                $total = $harga * $item;

                mysqli_query($mysqli,"INSERT INTO is_permintaan_sementara(kode_transaksi, kode_barang, nama_barang, satuan, harga, item, total) 
                    VALUES('$kdpen', '$kdbarang','$namabr','$satuan','$harga','$item','$total')");
                
                // UPDATE STOK BARANG PADA TABEL BARANG
                $kurang = $bar['stok'] - $item;
                mysqli_query($mysqli,"UPDATE is_barang SET stok = '$kurang' WHERE kode_barang = '$kdbarang'");
            }

            public function cek_item($kdbarang,$item){
                $data = $this->ambil_barang($kdbarang);
                $jumitem = $data['stok'];
                if ($item < $jumitem+1) {
                    return true;
                }
                else{
                    echo "<script>bootbox.alert('Item tidak cukup, $jumitem tersisa di gudang!', function(){
                        window.location='module=form_permintaan';
                    });</script>";
                }
            }

            public function hitung_total_sementara($kode){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                $qry = mysqli_query($mysqli,"SELECT sum(total) as jumlah FROM is_permintaan_sementara WHERE kode_transaksi = '$kode'");
                if($qry===false){
                    die(mysqli_error($mysqli));
                }

                while($pecah = mysqli_fetch_array($qry))
                {
                $cek = $this->cek_data_barangp($kode);
                if ($cek === true) {
                    $subtotal = $pecah['jumlah'];
                }
                else{
                    $subtotal = 0;
                }
                return $subtotal;
                }
            }
            public function hitung_permintaan_keluar($kdpermintaan){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                $qry = mysqli_query($mysqli,"SELECT count(*) as jumlah FROM dpermintaan WHERE kode_transaksi = '$kdpermintaan'");
                $pecah = mysqli_fetch_array($qry);

                return $pecah;  
            }
            public function simpan_permintaan($kdpermintaan,$tglpermintaan,$kdproject,$penerima,$alamat,$subtotal,$created_user){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                //insert keluar
                mysqli_query($mysqli,"INSERT INTO permintaan(kode_transaksi,tanggal_pm,kdproject,penerima,alamat,total_keluar,username) 
                VALUES('$kdpermintaan','$tglpermintaan','$kdproject','$penerima','$alamat','$subtotal','$created_user')");
                
                //insert dkeluar
                mysqli_query($mysqli,"INSERT INTO dpermintaan(kode_transaksi,kode_barang,nama_barang,jumlah) 
                    SELECT kode_transaksi,kode_barang,nama_barang,item FROM is_permintaan_sementara WHERE kode_transaksi='$kdpermintaan'");

                //hapus semua keluar sementera
                mysqli_query($mysqli,"DELETE FROM is_permintaan_sementara WHERE kode_transaksi = '$kdpermintaan'");
            }

            public function ambil_kdpen(){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                $qry = mysqli_query($mysqli,"SELECT * FROM permintaan ORDER BY kode_transaksi DESC LIMIT 1");
                $pecah = mysqli_fetch_assoc($qry);
                return $pecah;
            }

            public function hapus_permintaan_sementara($kd){
                $mysqli = new mysqli("localhost", "root", "", "simadang");

                //update barang, di kembalikan ke setok semula
                $datpen = $this->ambil_permintaan_sementara($kd);
                $datbar = $this->ambil_barang($datpen['kode_barang']);
                $stok = $datbar['stok'] + $datpen['item'];
                $kdbar = $datpen['kode_barang'];
                mysqli_query($mysqli,"UPDATE is_barang SET stok ='$stok' WHERE kode_barang = '$kdbar'");

                //hapus keluar sementara
                mysqli_query($mysqli,"DELETE FROM is_permintaan_sementara WHERE id_permintaan_sementara = '$kd'");
            }

            public function ambil_permintaan_sementara($kd){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                $qry = mysqli_query($mysqli,"SELECT * FROM is_permintaan_sementara WHERE id_keluar_sementara = '$kd'");
                $pecah = mysqli_fetch_assoc($qry);
                return $pecah;
            }
     }
     // AKHIR CLASS permintaaan

      // CLASS PURCHASE 
    class purchase extends Barang {

        public function kode_otomatis(){
            $mysqli = new mysqli("localhost", "root", "", "simadang");
            $qry = mysqli_query($mysqli,"SELECT MAX(kode_purchase) AS kode FROM purchase");
            $pecah = mysqli_fetch_array($qry);
            // insert year (if exists)
            $array_bulan = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
            $bulan = $array_bulan[date('n')];
        
            $kode = substr($pecah['kode'], 1,3);
            $jum = $kode + 1;
            if ($jum < 10) {
                $id = "00".$jum;
            }
            else if($jum >= 10 && $jum < 100){
                $id = "0".$jum;
            }
            
            return $id."/"."PO"."/"."KNZ"."/".$bulan."/".date("Y");
        }
    
        public function tampil_barang_purchase(){
            $mysqli = new mysqli("localhost", "root", "", "simadang");
            $qry = mysqli_query($mysqli,"SELECT * FROM is_barang WHERE stok > 0 ORDER BY nama_barang ASC");
            while ($pecah = mysqli_fetch_array($qry)) {
                $data[] = $pecah;
            }
            return $data;
        }

     
        
        public function tampil_purchase(){
            $mysqli = new mysqli("localhost", "root", "", "simadang");
            $qry = mysqli_query($mysqli, "SELECT * FROM purchase ORDER BY kode_purchase DESC");
            while ($pecah = mysqli_fetch_array($qry)) {
                $data[]=$pecah;
            }
            $hitung = mysqli_num_rows($qry);
                if ($hitung > 0) {
                    return $data;
                }
                else{
                    error_reporting(0);
                }
        }

        public function cek_data_barangp($kode){
            $mysqli = new mysqli("localhost", "root", "", "simadang");
            $qry = mysqli_query($mysqli,"SELECT * FROM barangpo_sementara WHERE kode_purchase = '$kode'");
            if($qry===false){
                die(mysqli_error($mysqli));
            }
            $hitung = mysqli_fetch_array($qry);
            
            if ($hitung >=1) {
                return true;
            }
            else{
                return false;
            
            }
        }

        public function tampil_barang_sementara($kode){
            $mysqli = new mysqli("localhost", "root", "", "simadang");
            $qry = mysqli_query($mysqli,"SELECT * FROM barangpo_sementara WHERE kode_purchase = '$kode'");
            while ($pecah = mysqli_fetch_array($qry)) {
                $data[]=$pecah;
            }
            $hitung = mysqli_num_rows($qry);
            if ($hitung > 0) {
                return $data;
            }
            else{
                error_reporting(0);
            }
        }

        public function tambah_purchase_sementara($kode, $nama,$detail,$satuan,$harga_barangp,$item){
            $mysqli = new mysqli("localhost", "root", "", "simadang");
            $tot = $item * $harga_barangp;

            mysqli_query($mysqli, "INSERT INTO barangpo_sementara(kode_purchase, nama_barangp,detail, satuan, harga_barangp, item,total) 
                VALUES('$kode', '$nama','$detail','$satuan','$harga_barangp','$item','$tot')");
            
            // UPDATE STOK BARANG PADA TABEL BARANG
            
        }

        public function cek_item($kdbarang,$item){
            $data = $this->ambil_barang($kdbarang);
            $jumitem = $data['stok'];
            if ($item < $jumitem+1) {
                return true;
            }
            
        }

        public function hitung_total_sementara($kode){
            $mysqli = new mysqli("localhost", "root", "", "simadang");
            $qry = mysqli_query($mysqli, "SELECT sum(item) as jumlah FROM barangpo_sementara WHERE kode_purchase = '$kode'");
            if($qry===false){
                die(mysqli_error($mysqli));
            }

            while($pecah = mysqli_fetch_array($qry))
            {
            $cek = $this->cek_data_barangp($kode);
            if ($cek === true) {
                $subtotal = $pecah['jumlah'];
            }
            else{
                $subtotal = 0;
            }
            return $subtotal;
            }
        }


       

      
        public function hitung_item_purchase($kdpurchase){
            $mysqli = new mysqli("localhost", "root", "", "simadang");
            $qry = mysqli_query($mysqli, "SELECT count(*) as jumlah FROM dpurchase WHERE kode_purchase = '$kdpurchase'");
            $pecah = mysqli_fetch_array($qry);

            return $pecah;  
        }


        public function simpan_purchase($kdpurchase,$tglpurchase,$kdproject,$supplier,$subtotal,$created_user){
            $mysqli = new mysqli("localhost", "root", "", "simadang");
            
            //insert purchase
            mysqli_query($mysqli, "INSERT INTO purchase(kode_purchase,tanggal_po,kode_project,kode_supplier,total,username) 
            VALUES('$kdpurchase','$tglpurchase','$kdproject','$supplier','$subtotal','$created_user')");
            
            //insert dpurchase
            mysqli_query($mysqli, "INSERT INTO dpurchase(kode_purchase,nama_barang,detail,harga_barangp,satuan,jumlah) 
                SELECT kode_purchase,nama_barangp,detail,harga_barangp,satuan,item FROM barangpo_sementara WHERE kode_purchase='$kdpurchase'");

            //hapus semua keluar sementera
            mysqli_query($mysqli, "DELETE FROM barangpo_sementara WHERE kode_purchase = '$kdpurchase'");
        }

        public function ambil_kdpo(){
            $mysqli = new mysqli("localhost", "root", "", "simadang");
            $qry = mysqli_query($mysqli, "SELECT * FROM purchase ORDER BY kode_purchase DESC LIMIT 1");
            $pecah = mysqli_fetch_assoc($qry);
            return $pecah;
        }

        public function hapus_purchase_sementara($kd){
            $mysqli = new mysqli("localhost", "root", "", "simadang");
            //hapus keluar sementara
            mysqli_query($mysqli, "DELETE FROM barangpo_sementara WHERE id_barangp = '$kd'");
        }

        public function ambil_purchase_sementara($kd){
            $mysqli = new mysqli("localhost", "root", "", "simadang");
            $qry = mysqli_query($mysqli,"SELECT * FROM barangpo_sementara WHERE id_barangp = '$kd'");
            $pecah = mysqli_fetch_assoc($qry);
            return $pecah;
        }
 }
 // AKHIR CLASS BARANGKELUAR


// AWAL PROJECT

 class project extends Barang {

            public function kode_otomatis(){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                $query_id = mysqli_query($mysqli, "SELECT RIGHT(kode_project,5) as kode FROM project
                                                ORDER BY kode_project DESC LIMIT 1")
                                                or die('Ada kesalahan pada query tampil kode_project : '.mysqli_error($mysqli));

                $count = mysqli_num_rows($query_id);

              if ($count <> 0) {
                  // mengambil data kode transaksi
                  $data_id = mysqli_fetch_assoc($query_id);
                  $koder    = $data_id['kode']+1;
              } else {
                  $koder = 1;
              }

              // buat kode_project
              $tahun          = date("Y");
              $buat_id        = str_pad($koder,5, "0", STR_PAD_LEFT);
              $kode= "TK-$tahun-$buat_id";
            }
        
            public function tampil_barang_project(){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                $qry = mysqli_query($mysqli, "SELECT * FROM is_barang WHERE stok > 0 ORDER BY nama_barang ASC");
                while ($pecah = mysqli_fetch_array($qry)) {
                    $data[] = $pecah;
                }
                return $data;
            }

         
            
            public function tampil_project(){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                $qry = mysqli_query($mysqli, "SELECT * FROM project ORDER BY kode_project DESC");
                while ($pecah = mysqli_fetch_array($qry)) {
                    $data[]=$pecah;
                }
                $hitung = mysqli_num_rows($qry);
                    if ($hitung > 0) {
                        return $data;
                    }
                    else{
                        error_reporting(0);
                    }
            }

            public function cek_data_barangp($kode){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                $qry = mysqli_query($mysqli, "SELECT * FROM project_sementara WHERE kode_project = '$kode'");
                if($qry===false){
                    die(mysqli_error($mysqli));
                }
                $hitung = mysqli_fetch_array($qry);
                
                if ($hitung >=1) {
                    return true;
                }
                else{
                    return false;
                
                }
            }

            public function tampil_project_sementara($kode){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                $qry = mysqli_query($mysqli,"SELECT * FROM project_sementara WHERE kode_project = '$kode'");
                while ($pecah = mysqli_fetch_array($qry)) {
                    $data[]=$pecah;
                }
                $hitung = mysqli_num_rows($qry);
                if ($hitung > 0) {
                    return $data;
                }
                else{
                    error_reporting(0);
                }
            }

            public function tambah_project_sementara($kdpen, $kdbarang, $item){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                $bar = $this->ambil_barang($kdbarang);
                $namabr = $bar['nama_barang'];
                $satuan = $bar['satuan'];
                $harga = $bar['harga_jual'];
                $total = $harga * $item;

                mysqli_query($mysqli, "INSERT INTO project_sementara(kode_project, kode_barang, nama_barangp, satuan, harga, item, total) 
                    VALUES('$kdpen','$kdbarang','$namabr','$satuan','$harga','$item','$total')");
                
                // UPDATE STOK BARANG PADA TABEL BARANG
                
            }

            public function cek_item($kdbarang,$item){
                $data = $this->ambil_barang($kdbarang);
                $jumitem = $data['stok'];
                if ($item < $jumitem+1) {
                    return true;
                }
                else{
                    echo "<script>bootbox.alert('Item tidak cukup, $jumitem tersisa di gudang!', function(){
                        window.location='module=form_project';
                    });</script>";
                }
            }

            public function hitung_total_sementara($kode){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                $qry = mysqli_query($mysqli, "SELECT sum(item) as jumlah FROM project_sementara WHERE kode_project = '$kode'");
                if($qry===false){
                    die(mysqli_error($mysqli));
                }

                while($pecah = mysqli_fetch_array($qry))
                {
                $cek = $this->cek_data_barangp($kode);
                if ($cek === true) {
                    $subtotal = $pecah['jumlah'];
                }
                else{
                    $subtotal = 0;
                }
                return $subtotal;
                }
            }
            public function hitung_item_keluar($kdproject){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                $qry = mysqli_query($mysqli, "SELECT count(*) as jumlah FROM dproject WHERE kode_project = '$kdproject'");
                $pecah = mysqli_fetch_array($qry);

                return $pecah;  
            }
            public function simpan_project($kdproject,$tgltransaksi,$nama_project,$kdpurchase,$kdklien,$catatan,$subtotal,$created_user){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                //insert keluar
                mysqli_query($mysqli, "INSERT INTO project(kode_project,tanggal_transaksi,nama_project,kode_purchase,kode_klien,catatan,total_keluar,username) 
                VALUES('$kdproject','$tgltransaksi','$nama_project','$kdpurchase','$kdklien','$catatan','$subtotal','$created_user')");
                
                //insert dkeluar
                mysqli_query($mysqli, "INSERT INTO dproject(kode_project,kode_barang,nama_barang,jumlah) 
                    SELECT kode_project,kode_barang,nama_barangp,item FROM project_sementara WHERE kode_project='$kdproject'");

                //hapus semua keluar sementera
                mysqli_query($mysqli, "DELETE FROM project_sementara WHERE kode_project = '$kdproject'");
            }

            public function ambil_kdpen(){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                $qry = mysqli_query($mysqli, "SELECT * FROM project ORDER BY kode_project DESC LIMIT 1");
                $pecah = mysqli_fetch_assoc($qry);
                return $pecah;
            }

            public function hapus_project_sementara($kd){
                $mysqli = new mysqli("localhost", "root", "", "simadang");

                //update barang, di kembalikan ke setok semula
                $datpen = $this->ambil_project_sementara($kd);
                $datbar = $this->ambil_barang($datpen['kode_project']);
                $stok = $datbar['stok'] + $datpen['item'];
                $kdbar = $datpen['kode_barang'];
               

                //hapus keluar sementara
                mysqli_query($mysqli,"DELETE FROM project_sementara WHERE id_keluar_sementara = '$kd'");
            }

            public function ambil_project_sementara($kd){
                $mysqli = new mysqli("localhost", "root", "", "simadang");
                $qry = mysqli_query($mysqli,"SELECT * FROM project_sementara WHERE id_keluar_sementara = '$kd'");
                $pecah = mysqli_fetch_assoc($qry);
                return $pecah;
            }
     } 
 // AKHIR PROJECT

  



 class Perusahaan{
    public function tampil_perusahaan(){
        $mysqli = new mysqli("localhost", "root", "", "simadang");
        $qry = mysqli_query($mysqli, "SELECT * FROM perusahaan WHERE kd_perusahaan = '1'");
        $pecah = mysqli_fetch_assoc($qry);
        return $pecah;
    }
    public function simpan_perusahaan($nama,$alamat,$pemilik,$kota){
        $mysqli = new mysqli("localhost", "root", "", "simadang");
        mysqli_query($mysqli, "UPDATE perusahaan SET nama_perusahaan='$nama',alamat='$alamat', pemilik='$pemilik', kota='$kota' WHERE kd_perusahaan ='1' ");
    }
}

class Nota{
    public function ambil_nota_barangkeluar($kdbrgkeluar){
        $mysqli = new mysqli("localhost", "root", "", "simadang");
        $qry = mysqli_query($mysqli, "SELECT * FROM barang_keluar pen
            JOIN dbarang_keluar dpen ON pen.kd_transaksi = dpen.kode_transaksi
            JOIN is_barang bar ON dpen.kode_barang = bar.kode_barang
            WHERE pen.kode_transaksi = '$kdbrgkeluar'");
        $pecah = mysqli_fetch_assoc($qry);
        return $pecah;
    }
    
    public function tampil_nota_barangkeluar($kdbrgkeluar){
        $mysqli = new mysqli("localhost", "root", "", "simadang");
        $qry =  mysqli_query($mysqli, "SELECT * FROM barang_keluar pen
        JOIN dbarang_keluar dpen ON pen.kd_transaksi = dpen.kode_transaksi
        JOIN is_barang bar ON dpen.kode_barang = bar.kode_barang
        WHERE pen.kode_transaksi = '$kdbrgkeluar'");
        while ($pecah = mysqli_fetch_array($qry)) {
            $data[]=$pecah;
        }
       return $data;
        }	
    }


$DataBase = new DataBase();
$DataBase->sambungkan();
$barangkeluar = new barangkeluar();
$purchase= new purchase();
$barang = new Barang();
$nota= new nota();
$perusahaan=new perusahaan();
$project=new project();
$permintaan=new permintaan();

?>