<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <i class="fa fa-folder-o icon-title"></i> Data Supplier

        <a class="btn btn-primary btn-social pull-right" href="?module=form_supplier&form=add" title="Tambah Data"
            data-toggle="tooltip">
            <i class="fa fa-plus"></i>Tambah
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
    // tampilkan pesan Sukses "Data supplier baru berhasil disimpan"
    elseif ($_GET['alert'] == 1) {
      echo "<div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-check-circle'></i> Sukses!</h4>
              Data Supplier baru berhasil disimpan.
            </div>";
    }
    // jika alert = 2
    // tampilkan pesan Sukses "Data Supplier berhasil diubah"
    elseif ($_GET['alert'] == 2) {
      echo "<div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-check-circle'></i> Sukses!</h4>
              Data Supplier berhasil diubah.
            </div>";
    }
    // jika alert = 3
    // tampilkan pesan Sukses "Data supplier berhasil dihapus"
    elseif ($_GET['alert'] == 3) {
      echo "<div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-check-circle'></i> Sukses!</h4>
              Data supplier berhasil dihapus.
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
                                <th class="center">ID Supplier</th>
                                <th class="center">Nama Supplier</th>
                                <th class="center">Alamat</th>
                                <th class="center">No. Telp</th>
                                <th class="center">No. Rek</th>
                                <th class="center">Aksi</th>

                            </tr>
                        </thead>
                        <!-- tampilan tabel body -->
                        <tbody>
                            <?php  
              include 'class/supplier.php';
              // contoh penggunaan kelas Stok_Barang
              $manager = new supplier('localhost', 'root', '', 'simadang');
              $data = $manager->getSupplier();
              foreach ($data as $row) { 
              
              // menampilkan isi tabel dari database ke tabel di aplikasi
              echo "<tr>
                <td width='30' class='center'>" . $row['no'] . "</td>
                <td width='80' class='center'>" . $row['id_supplier'] . "</td>
                <td width='150' class='center'>" . $row['nama_supplier'] . "</td>
                <td width='75' align='center'>" . $row['alamat'] . "</td>
                <td width='75' class='center'>" . $row['telp'] . "</td>
                <td width='60' class='center'>" . $row['norek'] . "</td>
                <td class='center' width='80'>
                      <div>
                        <a data-toggle='tooltip' data-placement='top' title='Ubah' style='margin-right:5px' class='btn btn-primary btn-sm' href='?module=form_supplier&form=edit&id=" . $row['id_supplier'] . "'>
                          <i style='color:#fff' class='glyphicon glyphicon-edit'></i>
                        </a>
                        <a data-toggle='tooltip' data-placement='top' title='Hapus' class='btn btn-danger btn-sm' href='modules/supplier/proses.php?act=delete&id=" . $row['id_supplier'] . "'>
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