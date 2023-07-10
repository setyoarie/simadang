<script type="text/javascript">
function tampil_barang(input) {
    var num = input.value;

    $.post("modules/barang/barang.php", {
        dataidbarang: num,
    }, function(response) {
        $('#stok').html(response)

        document.getElementById('stokakhir').focus();
    });
}

function cek_jumlah_masuk(input) {
    jml = document.barang.stokakhir.value;
    var jumlah = eval(jml);
    if (jumlah < 1) {
        alert('Jumlah barangTidak Boleh Nol !!');
        input.value = input.value.substring(0, input.value.length - 1);
    }
}

function hitung_total_stok() {
    bil1 = document.barang.stokawal.value;
    bil2 = document.barang.stokakhir.value;

    if (bil2 == "") {
        var hasil = "";
    } else {
        var hasil = eval(bil2);
    }

    document.barang.stok.value = (hasil);

}
</script>

<?php

    // fungsi untuk membuat kode transaksi
    $query_id = mysqli_query($mysqli, "SELECT RIGHT(kode_barang,4) as kode FROM is_barang
    ORDER BY kode_barang DESC LIMIT 1")
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
    //   $tahun          = date("Y");
    $buat_id  = str_pad($koder,4, "0", STR_PAD_LEFT);
    $kode     = "KB$buat_id";
    
// fungsi untuk pengecekan tampilan form
// jika form add data yang dipilih
if ($_GET['form']=='add') { ?>
<!-- tampilan form add data -->
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <i class="fa fa-edit icon-title"></i> Input Barang
    </h1>
    <ol class="breadcrumb">
        <li><a href="?module=beranda"><i class="fa fa-home"></i> Beranda </a></li>
        <li><a href="?module=barang"> Barang </a></li>
        <li class="active"> Tambah </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <!-- form start -->
                <form role="form" class="form-horizontal" action="modules/barang/proses.php?act=insert" method="POST">
                    <div class="box-body">


                        <div class="form-group">
                            <label class="col-sm-2 control-label">Kode Barang</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="kode_barang" maxlength="10"
                                    value="<?php echo $kode; ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nama Barang</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="nama_barang" autocomplete="off"
                                    maxlength="50" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Satuan</label>
                            <div class="col-sm-5">
                                <select class="chosen-select" name="satuan" data-placeholder="-- Pilih --"
                                    autocomplete="off" required>
                                    <option value=""></option>
                                    <option value="PCS">PCS</option>
                                    <option value="Lusin">Lusin</option>
                                    <option value="Ball">Ball</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Jenis Barang</label>
                            <div class="col-sm-5">
                                <select class="chosen-select" name="jenis_barang" data-placeholder="-- Pilih Jenis --"
                                    autocomplete="off" required>
                                    <option value="Kaos">Kaos</option>
                                    <option value="Kemeja">Kemeja</option>
                                    <option value="Jaket">Jaket</option>

                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label">Stok</label>
                            <div class="col-sm-5">
                                <div class="input-group">

                                    <input type="text" class="form-control" id="stok" name="stok" autocomplete="off"
                                        required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Keterangan</label>
                            <div class="col-sm-5">
                                <textarea class="form-control" rows="3" name="keterangan" id="keterangan"
                                    placeholder="Keterangan" maxlength="80"></textarea>
                            </div>
                        </div>


                    </div><!-- /.box body -->

                    <div class="box-footer">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" class="btn btn-primary btn-submit" name="simpan" value="Simpan">
                                <a href="?module=barang" class="btn btn-default btn-reset">Batal</a>
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
      // fungsi query untuk menampilkan data dari tabel barang
      $query = mysqli_query($mysqli, "SELECT kode_barang,nama_barang,satuan,stok,keterangan,jenis_barang FROM is_barang WHERE kode_barang='$_GET[id]'") 
                                      or die('Ada kesalahan pada query tampil Data barang : '.mysqli_error($mysqli));
      $data  = mysqli_fetch_assoc($query);
    }
?>
<!-- tampilan form edit data -->
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <i class="fa fa-edit icon-title"></i> Ubah Barang
    </h1>
    <ol class="breadcrumb">
        <li><a href="?module=beranda"><i class="fa fa-home"></i> Beranda </a></li>
        <li><a href="?module=barang"> Barang </a></li>
        <li class="active"> Ubah </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <!-- form start -->
                <form role="form" class="form-horizontal" action="modules/barang/proses.php?act=update" method="POST">
                    <div class="box-body">

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Kode barang</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="kode_barang"
                                    value="<?php echo $data['kode_barang']; ?>" maxlength="8" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nama barang</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="nama_barang" autocomplete="off"
                                    value="<?php echo $data['nama_barang']; ?>" maxlength="50" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Satuan</label>
                            <div class="col-sm-5">
                                <select class="chosen-select" name="satuan" data-placeholder="-- Pilih --"
                                    autocomplete="off" required>
                                    <option value="<?php echo $data['satuan']; ?>"><?php echo $data['satuan']; ?>
                                    </option>
                                    <option value="Pcs">Pcs</option>
                                    <option value="Lusin">Lusin</option>
                                    <option value="Ball">Ball</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Jenis Barang</label>
                            <div class="col-sm-5">
                                <select class="chosen-select" name="jenis_barang" data-placeholder="-- Pilih Jenis --"
                                    autocomplete="off" required>
                                    <option value="<?php echo $data['jenis_barang']; ?>">
                                        <?php echo $data['jenis_barang']; ?>
                                    </option>
                                    <option value="Kaos">Kaos</option>
                                    <option value="Kemeja">Kemeja</option>
                                    <option value="Jaket">Jaket</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label">Stok</label>
                            <div class="col-sm-5">
                                <div class="input-group">

                                    <input type="text" class="form-control" id="stok" name="stok"
                                        value="<?php echo $data['stok']; ?>" autocomplete="off"
                                        onKeyPress="return goodchars(event,'0123456789',this)" required>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label">Keterangan</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="keterangan" autocomplete="off"
                                    value="<?php echo $data['keterangan']; ?>" maxlength="50" required>
                            </div>
                        </div>

                    </div><!-- /.box body -->

                    <div class="box-footer">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" class="btn btn-primary btn-submit" name="simpan" value="Simpan">
                                <a href="?module=barang" class="btn btn-default btn-reset">Batal</a>
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