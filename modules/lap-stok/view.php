<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <i class="fa fa-file-text-o icon-title"></i> Laporan Stok barang

        <a class="btn btn-primary btn-social pull-right" href="modules/lap-stok/cetak.php" target="_blank">
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
    // tampilkan pesan Sukses "Data barang baru berhasil disimpan"
    elseif ($_GET['alert'] == 1) {
      echo "<div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-check-circle'></i> Sukses!</h4>
              Data barang baru berhasil disimpan.
            </div>";
    }
    // jika alert = 2
    // tampilkan pesan Sukses "Data barang berhasil diubah"
    elseif ($_GET['alert'] == 2) {
      echo "<div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-check-circle'></i> Sukses!</h4>
              Data barang berhasil diubah.
            </div>";
    }
    // jika alert = 3
    // tampilkan pesan Sukses "Data barang berhasil dihapus"
    elseif ($_GET['alert'] == 3) {
      echo "<div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-check-circle'></i> Sukses!</h4>
              Data barang berhasil dihapus.
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
                                <th class="center">Kode Barang</th>
                                <th class="center">Nama Barang</th>
                                <th class="center">Stok</th>
                                <th class="center">Satuan</th>
                                <th class="center">Jenis Barang</th>
                            </tr>
                        </thead>
                        <!-- tampilan tabel body -->
                        <tbody>
                            <?php  
              include 'class/Stok_Barang.php';
              // contoh penggunaan kelas Stok_Barang
              $manager = new Stok_Barang('localhost', 'root', '', 'simadang');
              $data = $manager->getBarang();
              foreach ($data as $row) {
                    echo "<tr>
                        <td width='30' class='center'>" . $row['no'] . "</td>
                        <td width='80' class='center'>" . $row['kode_barang'] . "</td>
                        <td width='180'>" . $row['nama_barang'] . "</td>
                        <td width='60' align='center'>" . $row['stok'] . "</td>
                        <td width='60' class='center'>" . $row['satuan'] . "</td>
                        <td width='60' class='center'>" . $row['jenis_barang'] . "</td>
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