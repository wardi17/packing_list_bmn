// index.js

import TransakiForwoderFinal from './tampiltransforwaderfinal.js';
import ProsesdataKurFinalAdd from'./ProsesdataKurFinalAdd.js';

import { SimpandataKurFinal } from './simpandataFinal.js';
import { baseUrl } from '../config.js';
import TransakiForwoderFinal_Edit from './tampiltransforwaderfinaledit.js';
import ProsesdataKurFinalEdit from './Prosesgetkurfinaledit.js';
import { UpdatedataKurFinal } from './updatedataFinal.js';
import TransakiForwoderFinal_Posting from './tampiltransforwaderfinalposting.js';
import ProsesdataKurFinalPosting from './Prosesgetkurfinalposting.js';
import { PostingdataKurFinal } from './postingdatafinal.js';
import ProsesgetKurFinalDetail from './Prosesgetkurfinaldetail.js';



$(document).ready(function () {
    const pageMode = getPageMode();

  
  

    bindCommonEvents();
    // Pakai kondisi berdasarkan nilai mode
    if (pageMode === "edit") {
        initializeEditMode();
    } else if (pageMode === "posting") {
        initializePostingMode();
    }else if (pageMode === "details") {
        initializeDetailsMode();
    } else {
        initializeCreateMode();
    }
});


// === Helper untuk mengecek mode ===
function getPageMode() {
    const pathSegments = window.location.pathname.split("/").filter(Boolean);

   const lastSegment = pathSegments.pop();
   
    if (lastSegment === "edit") {
        return "edit";
    } else if (lastSegment === "posting") {
        return "posting";
    }  else if (lastSegment === "details") {
        return "details";
    } else {
        return "tambah"; // default
    }
}

// === Mode Buat Baru ===
function initializeCreateMode() {
    $(document).on("click", "#SubmitData", handleSubmitDataFinal);
    $("#detailforwader_tambah").on("click", () => new TransakiForwoderFinal('#app'));
    $(document).on("click", "#tambahforwader", handleTambahForwader);
    $(document).on("click", "#SubmitProsesdata", handleSubmitProsesData);
    let cek ="nonproses";
    new ProsesdataKurFinalAdd(cek);
}

function handleSubmitDataFinal(e) {
    e.preventDefault();
    SimpandataKurFinal();
}

function handleTambahForwader(e) {
    e.preventDefault();
    let forward = $("#totalAmountrumus").text().trim();
     forward = forward === "" ? "0" : forward;
    $("#forwarder").val(forward);
    $("#modaltransforwader").modal("hide");

    // const pib = $("#pib").val();
    // settotal(pib, forward);
    tampilkanTombolProses("#SubmitProsesdata", "Proses");
}

function handleSubmitProsesData(e) {
    e.preventDefault();
    const nopo = $("#nopo").val();

    if (!nopo) {
        $("#nopoError").text("No PO harus dipilih dulu");
    } else {
        $("#nopoError").text("");
        new ProsesdataKurFinalAdd();
    }
}

// == mode Delete ===
function handleDeleteData(e){
     e.preventDefault();
     DeletedataKur();
}
function DeletedataKur(){
      const transnoHider = $("#transnoHider").val();
        Swal.fire({
                title: "Apakah Anda Yakin?",
                text: "Hapus Data Ini!",
                type: "warning",
                showDenyButton: true,
                confirmButtonColor: "#DD6B55",
                denyButtonColor: "#757575",
                confirmButtonText: "Ya, Hapus!",
                denyButtonText: "Tidak, Batal!",
              }).then((result) =>{
                if (result.isConfirmed) {
                  $.ajax({
                            url: `${baseUrl}/router/seturl`,
                            type:'POST',
                            dataType:'json',
                            contentType: "application/x-www-form-urlencoded; charset=UTF-8", // 
                            headers: {
                                'url':'transkurfinal/deletedata'
                            },
                            data :{"transnoHider":transnoHider},
                            beforeSend: function(){
                                Swal.fire({
                                  title: 'Loading',
                                  html: 'Please wait...',
                                  allowEscapeKey: false,
                                  allowOutsideClick: false,
                                  didOpen: () => {
                                  Swal.showLoading()
                              }
                                  });
                              },
                            success:function(result){
                              let status = result.error;
                              Swal.fire({
                                position: 'center',
                              icon: 'success',
                              title: status,
                              showConfirmButton: false,
                              timer: 1000
                              }).then(function(){
                                goBackDetail();
                              })
                            },
                             error: function () {
                                    Swal.fire({
                                    icon: "error",
                                    title: "Error!",
                                    text: "Terjadi kesalahan saat Delete data."
                                });
                             }
                          });
                    }
              })
}

//and model Delete
// === Mode Edit ===


function handleUpdateData(e) {
    e.preventDefault();
    UpdatedataKurFinal();
}


function initializeEditMode() {

    $(document).on("click", "#UpdateData", handleUpdateData);
    $("#detailforwader_edit").on("click", () => new TransakiForwoderFinal_Edit('#app'));
    $(document).on("click", "#tambahforwader_edit", handleTambahForwaderEdit);
    $(document).on("click", "#SubmitProsesdataEdit", handleSubmitProsesDataEdit);
    $(document).on("click", "#DeleteData", handleDeleteData);
    let cek ="nonproses";
    new ProsesdataKurFinalEdit(cek);
}

function handleTambahForwaderEdit(e) {
    e.preventDefault();
    let forward = $("#totalAmountrumus").text().trim();
    forward = forward === "" ? "0" : forward;
    $("#forwarder").val(forward);
    $("#modaltransforwaderedit").modal("hide");

    // const pib = $("#pib").val();
    // settotal(pib, forward);
    tampilkanTombolProses("#SubmitProsesdataEdit", "Proses edit");
}

function handleSubmitProsesDataEdit(e) {
    e.preventDefault();
    const nopo = $("#nopo").val();
    $("#itemTabel").empty();

    if (!nopo) {
        $("#nopoError").text("No PO harus dipilih dulu");
    } else {
        $("#nopoError").text("");
        let cek ="proses";
        new ProsesdataKurFinalEdit(cek);
    }
}


// and mode edit===
//=== Mode Posting ===

function initializePostingMode(){
       $("#detailforwader_posting").on("click", () => new TransakiForwoderFinal_Posting('#app'));
       $(document).on("click", "#PostingData", handlePostingData);
    new ProsesdataKurFinalPosting();
}

function handlePostingData(e){
    e.preventDefault();
      PostingdataKurFinal();
}
// == and Mode Posting ===

//=== Mode Details ===

function initializeDetailsMode(){
       $("#detailforwader_posting").on("click", () => new TransakiForwoderFinal_Posting('#app'));
    new ProsesgetKurFinalDetail();
}

// ==and mode Details =====
// === Fungsi Umum ===
function tampilkanTombolProses(buttonId, buttonText) {
    const item = `
        <div class="text-end col-md-10">
            <button type="btn" id="${buttonId.replace("#", "")}" class="btn btn-primary">${buttonText}</button>
        </div>`;
    $("#divproses").empty().html(item);
}

function bindCommonEvents() {
    // Input amount → hitung total
    $(document).on('input', '.amount', () => calculateTotalfor('amount'));

    // Tombol kembali
    $(document).on("click", "#kembali ,#BatalData", (e) => {
        e.preventDefault();
        goBack();
    });

       // Tombol kembalidetails
    $(document).on("click", "#kembalipostidfinal, #BatalDetailDatafinal", (e) => {
        e.preventDefault();
                // console.log("kembali detail"); return;
        goBackDetail();

    });

    //tombol kembali list
       // Tombol kembali
    $(document).on("click", "#kembalilist ,#BatalDatalist", (e) => {
        e.preventDefault();
        goBackList();
    });
}

function calculateTotalfor(data) {
    let total_hitung = 0;
    let total_rumus = 0;
    const selector = `.${data}`;
  
    $(selector).each(function () {
          let $row = $(this).closest('tr');
         let hitungan = $row.find('.hitungan').text().trim();
         let rumus = $row.find('.rumus').text().trim();

   
        if(hitungan ==="Y"){
            total_hitung += formatjm($(this).val()) || 0;
        }

        if(rumus ==="Y"){
            total_rumus += formatjm($(this).val()) || 0;
        }
       
    });
   
   
    const decimal_h = total_hitung.toString().includes('.') ? 2 : 0;
    const formatted_h = total_hitung.toFixed(decimal_h);
    const tampil_h = formatRupiah(formatted_h);

    const decimal_r = total_rumus.toString().includes('.') ? 2 : 0;
    const formatted_r = total_rumus.toFixed(decimal_r);
    const tampil_r = formatRupiah(formatted_r);
    $("#totalAmounthitungan").text(tampil_h);
    $("#totalAmountrumus").text(tampil_r);
}

export function goBack() {
    window.location.replace(`${baseUrl}/transaksifinalkurs`);
}

export function goBackDetail() {
    window.location.replace(`${baseUrl}/transaksifinalkurs/postlist`);
}

export function goBackList() {
    window.location.replace(`${baseUrl}/transaksifinalkurs/listfinal`);
}

// export function goBackListfinal() {
//     window.location.replace(`${baseUrl}/transaksifinalkurs/postlist`);
// }