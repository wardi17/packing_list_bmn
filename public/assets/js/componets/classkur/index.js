// index.js

import TransakiForwoder from './tampiltransforwader.js';
import ProsesdataKur from './Prosesgetkur.js';
import { SimpandataKur } from './simpandata.js';
import { baseUrl } from '../config.js';
import TransakiForwoder_Edit from './tampiltransforwaderedit.js';
import ProsesdataKurEdit from './Prosesgetkuredit.js';
import { UpdatedataKur } from './updatedata.js';
import TransakiForwoder_Posting from './tampiltransforwaderposting.js';
import ProsesdataKurPosting from './Prosesgetkurposting.js';
import { PostingdataKur } from './postingdata.js';
import ProsesdataKurDetail from './Prosesgetkurdetail.js';


$(document).ready(function () {
    const pageMode = getPageMode();

   
    // $("#testtable").on("click",function(e){
    //     e.preventDefault();
    //     new ProsesdataKur();
    // })


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
    $(document).on("click", "#SubmitData", handleSubmitData);
    $("#detailforwader").on("click", () => new TransakiForwoder('#app'));
    $(document).on("click", "#tambahforwader", handleTambahForwader);
    $(document).on("click", "#SubmitProsesdata", handleSubmitProsesData);
}

function handleSubmitData(e) {
    e.preventDefault();
    SimpandataKur();
}

function handleTambahForwader(e) {
    e.preventDefault();
    let forward = $("#totalAmountrumus").length ? $("#totalAmountrumus").text().trim() : "";
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
        new ProsesdataKur();
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
                                'url':'transkur/deletedata'
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
                                goBack();
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
    UpdatedataKur();
}


function initializeEditMode() {
    $(document).on("click", "#UpdateData", handleUpdateData);
    $("#detailforwader_edit").on("click", () => new TransakiForwoder_Edit('#app'));
    $(document).on("click", "#tambahforwader_edit", handleTambahForwaderEdit);
    $(document).on("click", "#SubmitProsesdataEdit", handleSubmitProsesDataEdit);
    $(document).on("click", "#DeleteData", handleDeleteData);
    let cek ="nonproses";
    new ProsesdataKurEdit(cek);
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
        new ProsesdataKurEdit(cek);
    }
}


// and mode edit===
//=== Mode Posting ===

function initializePostingMode(){
       $("#detailforwader_posting").on("click", () => new TransakiForwoder_Posting('#app'));
       $(document).on("click", "#PostingData", handlePostingData);
    new ProsesdataKurPosting();
}

function handlePostingData(e){
    e.preventDefault();
      PostingdataKur();
}
// == and Mode Posting ===

//=== Mode Details ===

function initializeDetailsMode(){
       $("#detailforwader_posting").on("click", () => new TransakiForwoder_Posting('#app'));
    new ProsesdataKurDetail();
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
    $(document).on("click", "#kembalipostid, #BatalDetailData", (e) => {
        e.preventDefault();
        goBackDetail();
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
    window.location.replace(`${baseUrl}/transaksikurs`);
}

export function goBackDetail() {
    window.location.replace(`${baseUrl}/transaksikurs/postlist`);
}