import { Updatedata } from './updatedata.js';
import { baseUrl } from '../config.js';
import TampilListdata from'./tampildata.js';
export default class ModalEdit {
  constructor(datas) {
    this.datas = datas;
    this.container = document.querySelector("#app");

    this.appendCustomStyles();
    this.renderModal();
  }

  appendCustomStyles() {
    const style = document.createElement("style");
    style.textContent = `
      input[type=number]::-webkit-outer-spin-button,
      input[type=number]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
      }
      input[type=number] {
        -moz-appearance: textfield;
      }
      .error {
        color: red;
        font-size: 0.875rem;
      }
    `;
    document.head.appendChild(style);
  }

  renderModal() {
    const modal = document.createElement("div");
    modal.className = "modal fade";
    modal.id = "modaleditdata";
    modal.tabIndex = -1;
    modal.setAttribute("data-bs-backdrop", "static");
    modal.setAttribute("data-bs-keyboard", "false");
    modal.setAttribute("aria-labelledby", "modaleditdataLabel");
    modal.setAttribute("aria-hidden", "true");

    modal.innerHTML = `
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="modaleditdataLabel">Edit Data</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="formedit" class="form form-horizontal" enctype="multipart/form-data">
              <input type="hidden" id="IDKategori" />
              ${this.createInputGroup("kategori_edit", "Kategori","text", "kategoriError")}
              ${this.createTextareaGroup("keterangan_edit", "Keterangan", "text", "keteranganError")}
            
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <button type="button" id="UpdateData" class="btn btn-info">Update</button>
            <button type="button" id="DeleteData" class="btn btn-danger">Delete</button>
          </div>
        </div>
      </div>
    `;

    this.container.appendChild(modal);

    const modalInstance = new bootstrap.Modal(document.getElementById('modaleditdata'));
    modalInstance.show();

    this.populateForm();
  }

  createInputGroup(id, label, type = "text", errorId = "") {
    return `
      <div class="mb-3 row">
        <label for="${id}" class="col-sm-4 col-form-label">${label}</label>
        <div class="col-sm-8">
          <input type="${type}" id="${id}" class="form-control" />
          <span id="${errorId}" class="error"></span>
        </div>
      </div>
    `;
  }

  createTextareaGroup(id, label, type = "text", errorId = "") {
    return `
      <div class="mb-3 row">
        <label for="${id}" class="col-sm-4 col-form-label">${label}</label>
        <div class="col-sm-8">
          <textarea type="${type}" id="${id}" class="form-control" /></textarea>
          <span id="${errorId}" class="error"></span>
        </div>
      </div>
    `;
  }


  populateForm() {

    const { id, keterangan, kategori } = this.datas;
    $("#IDKategori").val(id);
    $("#kategori_edit").val(kategori || '');
    $("#keterangan_edit").val(keterangan || '');
 
  }
}

// Submit event
$(document).on("click", "#UpdateData", function (event) {
  event.preventDefault();

  const IDKategori       = $("#IDKategori").val();
  const keterangan = $("#keterangan_edit").val().trim();
  const  kategori = $("#kategori_edit").val().trim();


  let isValid = true;

  if (!kategori) {
    $("#kategoriError").text(" kategori tidak boleh kosong.");
    isValid = false;
  }
  if (!keterangan) {
    $("#keteranganError").text("Keterangan tidak boleh kosong.");
    $("#keterangan_edit").focus();
    isValid = false;
  }



  if (!isValid) return;

   const datas = {
    IDKategori: IDKategori,
    keterangan: keterangan,
    kategori: kategori
  };



  Updatedata(datas);
});


$(document).on("click","#DeleteData",function(event){
   event.preventDefault();

  const IDKategori       = $("#IDKategori").val();


  DeleteData(IDKategori)
})

export   function DeleteData(IDKategori){


  $.ajax({
    url: `${baseUrl}/router/seturl`,
    method: "POST",
    dataType: "json",
    data: {IDKategori:IDKategori},
    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
    headers: { 'url': 'mskat/deletedata' },

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
        text: "Terjadi kesalahan saat Delete data."
      });
      // alert("Gagal mengambil data media.");
    }
  });

}


const goback=()=>{
   //$("#tambahdata").modal("show");
    $("#modaleditdata").modal("hide");
     document.getElementById("formedit").reset();
     new TampilListdata();
}