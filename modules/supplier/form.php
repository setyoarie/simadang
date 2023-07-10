<?php

// fungsi untuk membuat kode supplier
$query_id = mysqli_query($mysqli, "SELECT RIGHT(id_supplier,4) as kode FROM supplier
ORDER BY id_supplier DESC LIMIT 1") or die('Ada kesalahan pada query tampil id_supplier : '.mysqli_error($mysqli));

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
$kode     = "SP$buat_id";

// fungsi untuk pengecekan tampilan form
// jika form add data yang dipilih
if ($_GET['form']=='add') { ?>
<!-- tampilan form add data -->
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <i class="fa fa-edit icon-title"></i> Input Supplier
    </h1>
    <ol class="breadcrumb">
        <li><a href="?module=beranda"><i class="fa fa-home"></i> Beranda </a></li>
        <li><a href="?module=supplier"> Supplier </a></li>
        <li class="active"> Tambah </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <!-- form start -->
                <form role="form" class="form-horizontal" action="modules/supplier/proses.php?act=insert" method="POST">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Kode Supplier</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="id_supplier" value="<?php echo $kode; ?>"
                                    required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nama Supplier</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="nama_supplier" autocomplete="off" value=""
                                    required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Alamat</label>
                            <div class="col-sm-5">
                                <textarea class="form-control" rows="5" name="alamat" id="alamat"
                                    placeholder="Masukan Alamat" value=""></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">No. Telp</label>
                            <div class="col-sm-5">
                            <input type="number" class="form-control" name="telp" value="" autocomplete="off"
                                    required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Rekening</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="norek" value="" autocomplete="off"
                                    required>
                            </div>
                        </div>


                    </div><!-- /.box body -->

                    <div class="box-footer">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" class="btn btn-primary btn-submit" name="simpan" value="Simpan">
                                <a href="?module=supplier" class="btn btn-default btn-reset">Batal</a>
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
      $query = mysqli_query($mysqli, "SELECT id_supplier,nama_supplier,alamat,telp,norek FROM supplier WHERE id_supplier='$_GET[id]'") 
                                      or die('Ada kesalahan pada query tampil Data klien : '.mysqli_error($mysqli));
      $data  = mysqli_fetch_assoc($query);
    }
?>
<!-- tampilan form edit data -->
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <i class="fa fa-edit icon-title"></i> Ubah Supplier
    </h1>
    <ol class="breadcrumb">
        <li><a href="?module=beranda"><i class="fa fa-home"></i> Beranda </a></li>
        <li><a href="?module=supplier"> Supplier </a></li>
        <li class="active"> Ubah </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <!-- form start -->
                <form role="form" class="form-horizontal" action="modules/supplier/proses.php?act=update" method="POST">
                    <div class="box-body">

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Kode Supplier</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="id_supplier"
                                    value="<?php echo $data['id_supplier']; ?>" readonly required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nama Supplier</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="nama_supplier" autocomplete="off"
                                    value="<?php echo $data['nama_supplier']; ?>" required>
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
                            <input type="number" class="form-control" name="telp" autocomplete="off"
                                    value="<?php echo $data['telp']; ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">No Rekening</label>
                            <div class="col-sm-5">
                                <input type="number" class="form-control" name="norek" autocomplete="off"
                                    value="<?php echo $data['norek']; ?>" required>
                            </div>
                        </div>


                    </div><!-- /.box body -->

                    <div class="box-footer">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" class="btn btn-primary btn-submit" name="simpan" value="simpan">
                                <a href="?module=supplier" class="btn btn-default btn-reset">Batal</a>
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