import { baseUrl } from "../config.js";
import ModalEdit from "./modaledit.js";
export default class TampilListdata {
  constructor(containerSelector) {
    this.appendCustomStyles();
    this.container = document.querySelector(containerSelector);
    this.renderList();
 
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
         #thead{
            background-color:#E7CEA6 !important;
            /* font-size: 8px;
            font-weight: 100 !important; */
            /*color :#000000 !important;*/
        }
        .table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
            background-color: #F3FEB8;
            }

            /* .table-striped{
            background-color:#E9F391FF !important;
            } */
            .dataTables_filter{
                padding-bottom: 20px !important;
            }

        #frompacking{
                width:100%;
                height: 2% !important;
            margin: 0 auto;
        }
    `;
    document.head.appendChild(style);
  }
  renderList(){
      $.ajax({
        url: `${baseUrl}/router/seturl`,
        method: "GET",
        dataType: "json",
        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
        headers: { 'url': 'mskat/tampildata' },
    
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
        success: function(result) {
          Swal.close(); // ✅ Tutup loading saat sukses
            tablelist(result);
    
        },
        error: function () {
          Swal.fire({
            icon: "error",
            title: "Error!",
            text: "Terjadi kesalahan saat tampildata data."
          });
          // alert("Gagal mengambil data media.");
        }
      });
  }



}


   const tablelist=(result)=>{
    let id = $('#list'); // Menggunakan jQuery untuk mendapatkan elemen dengan ID 'list'
    let datatabel = `
        <table id="tabel1" class="table table-striped table-hover" style="width:100%">
            <thead id="thead" class="thead">
                <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Keterangan</th>
                    <th>UserID</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
    `;

    let no = 1;
    $.each(result, function(key, item) {
        const { IDKategori, keterangan, kategori, user_input } = item;
        datatabel += `
            <tr>
                <td>${no++}</td>
                <td>${kategori}</td>
                <td>${keterangan}</td>
                <td>${user_input}</td>
                <td>
                    <button type="button" class="btn btn-success btn-sm" id="editdata" 
                    data-id='${IDKategori}' data-keterangan='${keterangan}'data-kategori='${kategori}' 
                    >Edit</button>
                </td>
            </tr>
        `;
    });

    datatabel += `
            </tbody>
        </table>
    `;

    id.empty().html(datatabel); // Mengosongkan elemen dan menambahkan tabel
    Tampildatatabel();
}

$(document).on("click","#editdata",function(e){
  e.preventDefault();

  const id = $(this).data('id');
  const keterangan = $(this).data('keterangan');
  const kategori = $(this).data('kategori');
 
  const  datas={
    "id":id,
    "keterangan":keterangan,
    "kategori":kategori
   };

  new ModalEdit(datas);
})
       function  Tampildatatabel(){

          const id = "#tabel1";
          $(id).DataTable({
              order: [[0, 'asc']],
                responsive: true,
                "ordering": true,
                "destroy":true,
                pageLength: 5,
                lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'All']],
                fixedColumns:   {
                     // left: 1,
                      right: 1
                  },
                  
              })
        }