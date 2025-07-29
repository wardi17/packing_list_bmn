import { baseUrl } from "../config.js";

export default class ProsesdataKurEdit {
  constructor(cek) {
     this.appendCustomStyles();
    if (cek === "nonproses") {
      this.renderDataNonProses();
    } else {
      this.renderDataProses();
    }
  }

   appendCustomStyles() {
    const style = document.createElement("style");
    style.textContent = `
        /* Ukuran font untuk isi tabel */
        table td, table th {
            font-size: 12px;
        }

        /* Posisi teks */
        th, td {
            text-align: center;
            vertical-align: middle;
            white-space: nowrap; /* agar kolom tidak patah ke bawah */
        }

        /* Header warna */
        #thead {
            background-color: #E7CEA6 !important;
        }

        /* Container scroll horizontal */
        #scrollable-table {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            cursor: grab;
            padding-bottom: 5px;
        }

        /* Saat drag aktif */
        #scrollable-table:active {
            cursor: grabbing;
        }

        /* Tambahan untuk membuat table 100% width */
        #scrollable-table table {
            width: 100%; /* Set to 100% to fill the container */
            min-width: 600px; /* Minimum width to prevent collapsing */
            border-collapse: collapse;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            table td, table th {
                font-size: 10px; /* Smaller font size on smaller screens */
            }
        }
    `;
    document.head.appendChild(style);
}

  renderDataNonProses() {
    const transnoHider = $("#transnoHider").val();

    const data = {
      transnoHider: transnoHider,
    };

    $.ajax({
      url: `${baseUrl}/router/seturl`,
      method: "POST",
      dataType: "json",
      data: data,
      contentType: "application/x-www-form-urlencoded; charset=UTF-8",
      headers: { url: "transkur/prosesgetkuredit" },
      success: (result) => {
        $("#divproses").empty();
        this.setTableProsesKur(result);
        this.setTombolSubmit();
      },
      error: () => {
        Swal.fire({
          icon: "error",
          title: "Error!",
          text: "Terjadi kesalahan saat menampilkan data.",
        });
      },
    });
  }

  renderDataProses() {
    const nopo = $("#nopo").val();
    const totalpib = $("#forwarder").val().replace(/,/g, "").trim();

    const data = {
      nopo: nopo,
      totolpib: totalpib,
    };

    $.ajax({
      url: `${baseUrl}/router/seturl`,
      method: "POST",
      dataType: "json",
      data: data,
      contentType: "application/x-www-form-urlencoded; charset=UTF-8",
      headers: { url: "transkur/prosesgetkur" },
      success: (result) => {
        $("#divproses").empty();
        this.setTableProsesKur(result);
        this.setTombolSubmit();
      },
      error: () => {
        Swal.fire({
          icon: "error",
          title: "Error!",
          text: "Terjadi kesalahan saat menampilkan data.",
        });
      },
    });
  }

 setTombolSubmit() {
  // Buat elemen div pembungkus tombol
  const newDiv = document.createElement("div");
  newDiv.className = "col-md-10 text-end mt-3"; // Tambahan margin top agar ada jarak ke atas juga

  // Tombol Batal
  const btnBatal = document.createElement("button");
  btnBatal.className = "btn btn-secondary me-2"; // Jarak kanan
  btnBatal.id = "BatalData";
  btnBatal.textContent = "Batal";

  // Tombol Update
  const btnUpdate = document.createElement("button");
  btnUpdate.className = "btn btn-info me-2"; // Jarak kanan
  btnUpdate.id = "UpdateData";
  btnUpdate.textContent = "Update";

  // Tombol Delete
  const btnDelete = document.createElement("button");
  btnDelete.className = "btn btn-danger";
  btnDelete.id = "DeleteData";
  btnDelete.textContent = "Delete";

  // Tambahkan tombol ke dalam div
  newDiv.appendChild(btnBatal);
  newDiv.appendChild(btnUpdate);
  newDiv.appendChild(btnDelete);

  // Sisipkan div ke dalam elemen target
  document.getElementById("itemTabel").appendChild(newDiv);
}


  setTableProsesKur(result) {
    const divid = $("#itemTabel");
    divid.empty();

   let table = `
    <div id="scrollable-table">
        <table class="table table-striped table-hover table-bordered" id="table_kurdata">
            <thead id="thead">
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Item no</th>
                    <th rowspan="2" class="text-start">Description</th>
                    <th rowspan="2" class="text-end">Qty</th>
                    <th rowspan="2" class="text-center">Unit</th>
                    <th colspan="2">PO (USD)</th>
                    <th rowspan="2" class="text-end">Kurs PO</th>
                    <th colspan="2">PO (IDR)</th>
                    <th rowspan="2" class="text-end">Kurs Landed</th>
                    <th colspan="2">LANDED (IDR)</th>
                    <th rowspan="2" class="text-end">+/-</th>
                </tr>
                <tr>
                    <th class="text-center">Price Unit</th>
                    <th class="text-end">Amount</th>
                    <th class="text-end">Price Unit</th>
                    <th class="text-end">Amount</th>
                    <th class="text-end">Amount</th>
                    <th class="text-end">HPP Unit</th>
                </tr>
            </thead>
            <tbody>
                ${this.generateTableRows(result)}
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end fw-bold">Total:</td>
                    ${this.generateTotalRow(result)}
                </tr>
                <tr>
                    <td colspan="3" class="text-end fw-bold">PROSENTASE KENAIKAN HARGA LANDED :</td>
                    ${this.generateTotalProsentase(result)}
                </tr>
            </tfoot>
        </table>
    </div>`;


    divid.html(table);
  }

  generateTableRows(data) {
    if (!Array.isArray(data)) {
      return `<tr><td colspan="14">Tidak ada data</td></tr>`;
    }

   return data.map((item, index) => `
         <tr>
            <td>${index + 1}</td>
            <td>${item.Partid}</td>
            <td class="text-start">${item.PartName}</td>
            <td class="text-end">${item.Qty}</td>
            <td class="text-center">${item.Unit}</td>
            <td class="text-end">${item.Price}</td>
            <td class="text-end">${item.Amount_USD}</td>
            <td class="text-end" >${item.Kurs}</td>
            <td class="text-end " id="${item.Hpp_Awal}">${parseFloat(item.Hpp_Awal).toFixed(2)}</td>
            <td class="text-end">${item.Amount_Rp}</td>
           <td class="text-end" id="${item.Partid ==="01.001.163" ? 0 :item.kur_akhir}">${item.Partid ==="01.001.163" ?"" : item.kur_akhirtampil}</td>
            <td class="text-end" id="${item.Partid ==="01.001.163" ? 0 :item.Amount_RpAkhir}">${item.Partid ==="01.001.163" ?"" : item.Amount_RpAkhirTampil}</td>
            <td class="text-end" id="${item.Partid ==="01.001.163" ? 0 :item.Hpp_Akhir}">${item.Partid ==="01.001.163" ?"" : item.Hpp_AkhirTampil}</td>
            <td class="text-end" id="${item.Partid ==="01.001.163" ? 0 :item.Selisih_Hpp}">${item.Partid ==="01.001.163" ?"" : item.Selisih_HppTampil}</td>
        </tr>
    `).join('');
  }

   generateTotalRow(result){
    if (!Array.isArray(result)) return `<td colspan="8">Tidak ada data</td>`;
        let total_usd='';
        let total_rp='';
        let total_qty='';
        let total_amountakhir='';
        result.forEach(element => {
             total_usd =element.Total_amount_USD;
             total_rp  =element.Total_amount_Rp;
             total_qty = element.Total_Qty;
             total_amountakhir=element.Total_amount_Rpakhir;
        });
           let newrow =`
            <td class="text-end"></td>
            <td></td>
            <td></td>
            <td class="text-end" id="total_usd">${total_usd}</td>
            <td></td>
            <td></td>
            <td class="text-end" id="total_rp">${total_rp}</td>
            <td></td>
            <td class="text-end" id="total_amountakhir">${total_amountakhir}</td>
            <td></td>
            <td></td>
        `;
        return newrow;
     }

      generateTotalProsentase(result){
            if (!Array.isArray(result)) return `<td colspan="3">Tidak ada data</td>`;
            let total_Prosentase=""
              result.forEach(element => {
             total_Prosentase =element.Prosentase;
              });
                let newrow =`<td colspan="3" id="total_Prosentase" class="text-start">${total_Prosentase}</td>`;
            return  newrow;
     }
}
