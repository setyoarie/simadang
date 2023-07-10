<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <i class="fa fa-folder-o icon-title"></i> Data Klien

        <a class="btn btn-primary btn-social pull-right" href="?module=form_klien&form=add" title="Tambah Data"
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
    // tampilkan pesan Sukses "Data klien baru berhasil disimpan"
    elseif ($_GET['alert'] == 1) {
      echo "<div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-check-circle'></i> Sukses!</h4>
              Data klien baru berhasil disimpan.
            </div>";
    }
    // jika alert = 2
    // tampilkan pesan Sukses "Data klien berhasil diubah"
    elseif ($_GET['alert'] == 2) {
      echo "<div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-check-circle'></i> Sukses!</h4>
              Data klien berhasil diubah.
            </div>";
    }
    // jika alert = 3
    // tampilkan pesan Sukses "Data klien berhasil dihapus"
    elseif ($_GET['alert'] == 3) {
      echo "<div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-check-circle'></i> Sukses!</h4>
              Data klien berhasil dihapus.
            </div>";
    }
    ?>

            <div class="box box-primary">
                <div class="box-body">
                    <!-- tampilan tabel klien -->
                    <table id="dataTables1" class="table table-bordered table-striped table-hover">
                        <!-- tampilan tabel header -->
                        <thead>
                            <tr>
                                <th class="center">No.</th>
                                <th class="center">ID Klien</th>
                                <th class="center">Nama Klien</th>
                                <th class="center">Nama Perusahaan</th>
                                <th class="center">Alamat</th>
                                <th class="center">No. Telp</th>
                                <th class="center">Aksi</th>
                            </tr>
                        </thead>
                        <!-- tampilan tabel body -->
                        <tbody>
                            <?php  
              include 'class/klien.php';
              // contoh penggunaan kelas Stok_Barang
              $manager = new klien('localhost', 'root', '', 'simadang');
              $data = $manager->getKlien();
              foreach ($data as $row) { 
             
              // menampilkan isi tabel dari database ke tabel di aplikasi
              echo "<tr>
                      <td width='30' class='center'>" . $row['no'] . "</td>
                      <td width='80' class='center'>" . $row['id_klien'] . "</td>
                      <td width='100' class='center'>" . $row['nama_klien'] . "</td>
                      <td width='180'  class='center'>" . $row['nama_perusahaan'] . "</td>
                      <td width='100' align='center'>" . $row['alamat'] . "</td>
                      <td width='100' class='center'>" . $row['no_telp'] . "</td>
                      
                      <td class='center' width='80'>
                      <div>
                      <a data-toggle='tooltip' data-placement='top' title='Ubah' style='margin-right:5px' class='btn btn-primary btn-sm' href='?module=form_klien&form=edit&id=" . $row['id_klien'] . "'>
                        <i style='color:#fff' class='glyphicon glyphicon-edit'></i>
                      </a>
                      <a data-toggle='tooltip' data-placement='top' title='Hapus' class='btn btn-danger btn-sm' href='modules/klien/proses.php?act=delete&id=" . $row['id_klien'] . "'>
                        <i style='color:#fff' class='glyphicon glyphicon-trash'></i>
                      </a>
                      "
                      ?>
                            <?php
                    "</div>
                  </td>
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