<?php

// fungsi untuk membuat kode supplier
$query_id = mysqli_query($mysqli, "SELECT RIGHT(id_klien,4) as kode FROM klien
ORDER BY id_klien DESC LIMIT 1") or die('Ada kesalahan pada query tampil id_klien : '.mysqli_error($mysqli));

$count = mysqli_num_rows($query_id);

if ($count <> 0) {
// mengambil data id supplier
$data_id = mysqli_fetch_assoc($query_id);
$koder    = $data_id['kode']+1;
} else {
$koder = 1;
}

// buat id_supplier
//   $tahun          = date("Y");
$buat_id  = str_pad($koder,4, "0", STR_PAD_LEFT);
$kode     = "KL$buat_id";

// fungsi untuk pengecekan tampilan form
// jika form add data yang dipilih
if ($_GET['form']=='add') { ?>
<!-- tampilan form add data -->
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <i class="fa fa-edit icon-title"></i> Input Klient
    </h1>
    <ol class="breadcrumb">
        <li><a href="?module=beranda"><i class="fa fa-home"></i> Beranda </a></li>
        <li><a href="?module=klien"> Klien </a></li>
        <li class="active"> Tambah </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <!-- form start -->
                <form role="form" class="form-horizontal" action="modules/klien/proses.php?act=insert" method="POST">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">ID Klien</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="id_klien" value="<?php echo $kode; ?>"
                                    required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nama Klien</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="nama_klien" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nama Perusahaan</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="nama_perusahaan" autocomplete="off"
                                    required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Alamat</label>
                            <div class="col-sm-5">
                                <textarea class="form-control" rows="5" name="alamat" id="alamat"
                                    placeholder="Masukan Alamat"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">No Telp</label>
                            <div class="col-sm-5">
                                <input type="number" class="form-control" name="no_telp" value="" autocomplete="off"
                                    required>
                            </div>
                        </div>



                    </div><!-- /.box body -->

                    <div class="box-footer">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" class="btn btn-primary btn-submit" name="simpan" value="Simpan">
                                <a href="?module=klien" class="btn btn-default btn-reset">Batal</a>
                            </div>
                        </div>
                    </div><!-- /.box footer -->
                </form>
            </div><!-- /.box -->
        </div>
        <!--/.col -->
    </div> <!-- /.row -->
</section><!-- /.content -->
<?php
}
// jika form edit data yang dipilih
// isset : cek data ada / tidak
elseif ($_GET['form']=='edit') { 
  if (isset($_GET['id'])) {
      // fungsi query untuk menampilkan data dari tabel klien
      $query = mysqli_query($mysqli, "SELECT id_klien,nama_klien,nama_perusahaan,alamat,no_telp FROM klien WHERE id_klien='$_GET[id]'") 
                                      or die('Ada kesalahan pada query tampil Data klien : '.mysqli_error($mysqli));
      $data  = mysqli_fetch_assoc($query);
    }
?>
<!-- tampilan form edit data -->
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <i class="fa fa-edit icon-title"></i> Ubah Klien
    </h1>
    <ol class="breadcrumb">
        <li><a href="?module=beranda"><i class="fa fa-home"></i> Beranda </a></li>
        <li><a href="?module=klien"> Klien </a></li>
        <li class="active"> Ubah </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <!-- form start -->
                <form role="form" class="form-horizontal" action="modules/klien/proses.php?act=update" method="POST">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">ID Klien</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="id_klien"
                                    value="<?php echo $data['id_klien']; ?>" readonly required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nama Klien</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="nama_klien" autocomplete="off"
                                    value="<?php echo $data['nama_klien']; ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nama Perusahaan</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="nama_perusahaan" autocomplete="off"
                                    value="<?php echo $data['nama_perusahaan']; ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Alamat</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="alamat" autocomplete="off"
                                    value="<?php echo $data['alamat']; ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">No Telp</label>
                            <div class="col-sm-5">
                            <input type="number" class="form-control" name="no_telp" autocomplete="off"
                            value="<?php echo $data['no_telp']; ?>" required>
                            </div>
                        </div>


                    </div><!-- /.box body -->

                    <div class="box-footer">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" class="btn btn-primary btn-submit" name="simpan" value="Simpan">
                                <a href="?module=klien" class="btn btn-default btn-reset">Batal</a>
                            </div>
                        </div>
                    </div><!-- /.box footer -->
                </form>
            </div><!-- /.box -->
        </div>
        <!--/.col -->
    </div> <!-- /.row -->
</section><!-- /.content -->
<?php
}
?>