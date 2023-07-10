//menghitung total
var specialKeys = new Array();
specialKeys.push(8); //Backspace
$(function () {
    $(".input").bind("keypress", function (e) {
        var keyCode = e.which ? e.which : e.keyCode
        var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
        $("label.validate").css("display", ret ? "none" : "inline");
        return ret;
    });
    $(".input").bind("paste", function (e) {
        return false;
    });
    $(".input").bind("drop", function (e) {
        return false;
    });
});


function sum() {
    var harga_per_pcs = document.getElementById('harga_per_pcs').value;
    var jumlah_pembelian = document.getElementById('jumlah_pembelian').value;
    var result = harga_per_pcs * jumlah_pembelian;
    if (!isNaN(result)) {
      
      var bilangan = result;
      var	number_string = bilangan.toString(),
        sisa 	= number_string.length % 3,
        rupiah 	= number_string.substr(0, sisa),
        ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
          
      if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }
      document.getElementById('total_harga').value =  'Rp. '+rupiah;
    }
}