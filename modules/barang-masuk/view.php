<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <i class="fa fa-sign-in icon-title"></i> Data Barang Masuk

        <a class="btn btn-primary btn-social pull-right" href="?module=form_barang_masuk&form=add" title="Tambah Data"
            data-toggle="tooltip">
            <i class="fa fa-plus"></i> Tambah
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
    // tampilkan pesan Sukses "Data barang Masuk berhasil disimpan"
    elseif ($_GET['alert'] == 1) {
      echo "<div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-check-circle'></i> Sukses!</h4>
              Data barang Masuk berhasil disimpan.
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
                                <th class="center">Kode Transaksi</th>
                                <th class="center">Tanggal Masuk</th>
                                <th class="center">Kode Barang</th>
                                <th class="center">Nama Barang</th>
                                <th class="center">Jumlah Masuk</th>
                                <th class="center">Satuan</th>
                            </tr>
                        </thead>
                        <!-- tampilan tabel body -->
                        <tbody>
                            <?php  
           include 'class/barang_masuk.php';
           // contoh penggunaan kelas barang_masuk
           $manager = new barang_masuk('localhost', 'root', '', 'simadang');
           $data = $manager->getBarang();
           foreach ($data as $row) {
              // menampilkan isi tabel dari database ke tabel di aplikasi
              echo "<tr>
                      <td width='30' class='center'>" . $row['no'] . "</td>
                      <td width='100' class='center'>" . $row['kode_transaksi'] . "</td>
                      <td width='80' class='center'>" . $row['tanggal_masuk'] . "</td>
                      <td width='80' class='center'>" . $row['kode_barang'] . "</td>
                      <td width='200' class='left'>" . $row['nama_barang'] . "</td>
                      <td width='100' class='center'>" . $row['jumlah_masuk'] . "</td>
                      <td width='80' class='center'>" . $row['satuan'] . "</td>
                      </tr>";
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