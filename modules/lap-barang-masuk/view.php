<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <i class="fa fa-file-text-o icon-title"></i> Laporan Data barang Masuk
        <a class="btn btn-primary btn-social pull-right" href="modules/lap-barang-masuk/cetak.php" target="_blank">
            <i class="fa fa-print"></i> Cetak
        </a>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">

            <?php  
    // fungsi untuk menampilkan pesan
    // jika alert = "" (kosong)
    // tampilkan pesan "" (kosong)
    if (empty($_GET['alert'])) {
      echo "";
    } 
    // jika alert = 1
    // tampilkan pesan Sukses "Data barang keluar berhasil disimpan"
    elseif ($_GET['alert'] == 1) {
      echo "<div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-check-circle'></i> Sukses!</h4>
              Data Purchase berhasil disimpan.
            </div>";
    }
    ?>

            <div class="box box-primary">
                <div class="box-body">
                    <!-- tampilan tabel barang -->
                    <table id="dataTables1" class="table table-bordered table-striped table-hover">
                        <!-- tampilan tabel header -->
                        <thead>
                            <tr>
                                <th class="center">No.</th>
                                <th class="center">Kode Purchase</th>
                                <th class="center">Tanggal</th>
                                <th class="center">Kode Project</th>
                                <th class="center">Penerima</th>
                                <th class="center">Alamat</th>
                                <th class="center">Total Purchase</th>
                                <th class="center">Nama Barang</th>
                            </tr>
                        </thead>
                        <!-- tampilan tabel body -->
                        <tbody>
                            <?php  
            $no = 1;
            // fungsi query untuk menampilkan data dari tabel barang
            $query = mysqli_query($mysqli, "SELECT b.kode_transaksi,b.tanggal_keluar,b.kdproject,b.penerima,b.alamat,b.total_keluar,a.nama_barang
                                            FROM barang_keluar as b INNER JOIN dbarang_keluar as a ON a.kode_transaksi=b.kode_transaksi ")
                                            or die('Ada kesalahan pada query tampil Data Purchase: '.mysqli_error($mysqli));

            // tampilkan data
            while ($data = mysqli_fetch_assoc($query)) { 

              // menampilkan isi tabel dari database ke tabel di aplikasi
              echo "<tr>
                      <td width='10' class='center'>$no</td>
                      <td width='100' class='center'>$data[kode_transaksi]</td>
                      <td width='100' class='center'>$data[tanggal_keluar]</td>
                      <td width='100' class='center'>$data[kdproject]</td>
                      <td width='70' class='center'>$data[penerima]</td>
                      <td width='150' class='center'>$data[alamat]</td>
                      <td width='30' align='center'>$data[total_keluar]</td>
                      <td width='150' align='center'>$data[nama_barang]</td>
                    </tr>";
              $no++;
            }
            ?>
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
        <!--/.col -->
    </div> <!-- /.row -->
</section><!-- /.content