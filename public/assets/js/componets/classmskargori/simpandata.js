
import { baseUrl } from '../config.js';
import TampilListdata from './tampildata.js';
export  function Simpandata(datas) {


  $.ajax({
    url: `${baseUrl}/router/seturl`,
    method: "POST",
    dataType: "json",
    data: datas,
    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
    headers: { 'url': 'mskat/savedata' },

    beforeSend: function () {
      Swal.fire({
        title: 'Loading',
        html: 'Please wait...',
        allowEscapeKey: false,
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });

    },
    success: function (result) {
      let pesan = result.error;
      Swal.fire({
        position: 'center',
        icon: 'success',
        showConfirmButton: false,
        timer: 1000,
        text: pesan,
      }).then(function () {
        goback();
      });


    },
    error: function () {
      Swal.fire({
        icon: "error",
        title: "Error!",
        text: "Terjadi kesalahan saat Simpan data."
      });
      // alert("Gagal mengambil data media.");
    }
  });


}

const goback=()=>{
   //$("#tambahdata").modal("show");
    $("#tambahdata").modal("hide");
     document.getElementById("formtambah").reset();
     new TampilListdata();
}