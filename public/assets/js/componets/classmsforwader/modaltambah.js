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
                <label for="keterangan" class="col-sm-4 col-form-label">Keterangan</label>
                <div class="col-sm-8">
                  <input type="text" id="keterangan" class="form-control" />
                  <span id="keteranganError" class="error"></span>
                </div>
              </div>
                  <div class="mb-3 row">
                <label class="col-sm-4 col-form-label">Hitung</label>
                <div class="col-sm-8">
                  <div class="form-check form-check-inline">
                    <input type="radio" name="Hitung" value="Y" id="HitungYa" class="form-check-input" />
                    <label for="HitungYa" class="form-check-label">Ya</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input type="radio" name="Hitung" value="N" id="HitungTidak" class="form-check-input" />
                    <label for="HitungTidak" class="form-check-label">Tidak</label>
                  </div>
                  <br />
                  <span id="HitungError" class="error"></span>
                </div>
              </div>
              <div class="mb-3 row">
                <label class="col-sm-4 col-form-label">Rumus</label>
                <div class="col-sm-8">
                  <div class="form-check form-check-inline">
                    <input type="radio" name="Rumus" value="Y" id="RumusYa" class="form-check-input" />
                    <label for="RumusYa" class="form-check-label">Ya</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input type="radio" name="Rumus" value="N" id="RumusTidak" class="form-check-input" />
                    <label for="RumusTidak" class="form-check-label">Tidak</label>
                  </div>
                  <br />
                  <span id="RumusError" class="error"></span>
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
      if (e.target.id === "keterangan") {
        $("#keteranganError").text("");
      }
    });

    document.addEventListener("change", function (e) {
      if (e.target.name === "Rumus") {
        $("#RumusError").text("");
      }
      if (e.target.name === "Hitung") {
        $("#HitungError").text("");
      }
    });
  }
}
$(document).on("click", "#CreateData", function (event) {
  event.preventDefault();

  const keterangan = $("#keterangan").val().trim();
  const rumus = document.querySelector('input[name="Rumus"]:checked');
  const hitung = document.querySelector('input[name="Hitung"]:checked');

  let isValid = true;

  if (!keterangan) {
    $("#keteranganError").text("Keterangan tidak boleh kosong.");
    $("#keterangan").focus();
    isValid = false;
  }

  if (!rumus) {
    $("#RumusError").text("Silakan pilih salah satu opsi untuk Rumus.");
    isValid = false;
  }

  if (!hitung) {
    $("#HitungError").text("Silakan pilih salah satu opsi untuk Hitung.");
    isValid = false;
  }

  if (!isValid) return;

  const datas = {
    keterangan: keterangan,
    rumus: rumus.value,
    hitungan: hitung.value,
  };

  Simpandata(datas);

  // TODO: kirim data via AJAX jika diperlukan
});
