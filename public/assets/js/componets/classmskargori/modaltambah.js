import { Simpandata } from './simpandata.js';
export default class Modaltambah {
  constructor(containerSelector) {
    this.appendCustomStyles();
    this.container = document.querySelector(containerSelector);
    this.renderModal();
    this.attachInputListeners(); // Tambahkan auto-remove error
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
    modal.id = "tambahdata";
    modal.tabIndex = -1;
    modal.setAttribute("data-bs-backdrop", "static");
    modal.setAttribute("data-bs-keyboard", "false");
    modal.setAttribute("aria-labelledby", "tambahdataLabel");
    modal.setAttribute("aria-hidden", "true");

    modal.innerHTML = `
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="tambahdataLabel">Tambah Data</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <form id="formtambah" class="form form-horizontal" enctype="multipart/form-data">
              
              <div class="mb-3 row">
                <label for="kategori" class="col-sm-4 col-form-label">Kategori</label>
                <div class="col-sm-8">
                  <input type="text" id="kategori" class="form-control" />
                  <span id="kategoriError" class="error"></span>
                </div>
              </div>
                <div class="mb-3 row">
                <label for="keterangan" class="col-sm-4 col-form-label">Keterangan</label>
                <div class="col-sm-8">
                  <textarea type="text" id="keterangan" class="form-control"/> </textarea>
                  <span id="keteranganError" class="error"></span>
                </div>
              </div>

            </form>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <button type="button" id="CreateData" class="btn btn-primary">Simpan</button>
          </div>
        </div>
      </div>
    `;

    this.container.appendChild(modal);
  }

  attachInputListeners() {
    document.addEventListener("input", function (e) {
      if (e.target.id === "kategori") {
        $("#kategoriError").text("");
      }
    });

    document.addEventListener("textarea", function (e) {
      if (e.target.id === "keterangan") {
        $("#keteranganError").text("");
      }
    
    });
  }
}

$(document).on("click", "#CreateData", function (event) {
  event.preventDefault();

  const  kategori = $("#kategori").val().trim();
  const keterangan = $("#keterangan").val().trim();


  let isValid = true;

    if (!kategori) {
    $("#kategoriError").text(" kategori tidak boleh kosong.");
    isValid = false;
  }
  if (!keterangan) {
    $("#keteranganError").text("Keterangan tidak boleh kosong.");
    $("#keterangan").focus();
    isValid = false;
  }




  if (!isValid) return;

  const datas = {
    keterangan: keterangan,
    kategori: kategori
  };

  

  Simpandata(datas);

  // TODO: kirim data via AJAX jika diperlukan
});
