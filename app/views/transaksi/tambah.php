<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#tanggal", {
                dateFormat: "d/m/Y", // Format yang diinginkan
                allowInput: true ,// Memungkinkan input manual
                defaultDate: new Date()
            });
        });
    </script>
</head>
<body>
 
<?php
$supplier =$data["Supplier"];
$userid =  $data["userid"];


?>

<style>
      input[type="file"]{
        display: none;
    }
    .error {
      color: red;
    }

    .ldBar path.mainline {
    stroke-width: 10;
    stroke: #09f;
    stroke-linecap: round;
  }
  .ldBar path.baseline {
    stroke-width: 14;
    stroke: #f1f2f3;
    stroke-linecap: round;
    filter:url(#custom-shadow);
  }

  .loading-spinner{
  width:30px;
  height:30px;
  border:2px solid indigo;
  border-radius:50%;
  border-top-color:#0001;
  display:inline-block;
  animation:loadingspinner .7s linear infinite;
}
@keyframes loadingspinner{
  0%{
    transform:rotate(0deg)
  }
  100%{
    transform:rotate(360deg)
  }
}
.thead{
        background-color:#E7CEA6;
        /* font-size: 8px;
        font-weight: 100 !important; */
     
      }

  .table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
		  background-color: #F5DE14FF !important;
		}

 .table-striped > tbody > tr:nth-child(2n+1) > td, .table-striped > tbody > tr:nth-child(2n+1) > th {
   background-color:#BFECFF !important;
}

  </style>
<div id="main">
       <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
    <!-- Content Header (Page header) -->
      <div id="formhider" class ="col-md-12 col-12">
                <!-- Default box -->
                      <div class="card">
                        <div class="card-header">
                          <div class="row col-md-12">
                            <div class="col-md-1">
                            <button onclick="goBack()" type="button" class="btn btn-lg text-start"><i class="fa-solid fa-chevron-left"></i></button>
                            </div>
                            <div class ="col-md-11">
                            <h5 class="text-center">Tambah Data</h5>
                            </div>
                          </div>
                        
                        </div>
                          <div class="card-body">
                            <div class=" row col-md-12">
                              <div class="col-md-6">
                              <div class="row mb-12 mb-2">
                                        <label for="suplair" style="width:20%;" class="col-sm-2 col-form-label">Supplier</label>
                                                  <div  class=" col-sm-9">
                                                              <select class="form-control" id="suplair">
                                                              <option value="" disabled selected>Please Select</option>
                                                              <?php  foreach($supplier as $file):
                                                                          $kode = $file['CustomerID'];
                                                                          $nama = $file['CustName'];
                                                                      ?>
                                                            <option value="<?= $kode ?>"><?= $nama ?></option>
                                                              <?php endforeach;?> 
                                                            </select>
                                                                  <span id="customerError" class="error"></span>
                                                          </div>
                                    </div>
                                    <div id="selectpo"   class="row mb-12 mb-2">
                                        <label for="nopo" style="width:20%;" class="col-sm-2 col-form-label">NO PO</label>
                                                  <div  class=" col-sm-6">
                                                              <select class="form-control" id="nopo">
                                                  
                                                            </select>
                                                                  <span id="nopoError" class="error"></span>
                                                          </div>
                                    </div>

                                    <div class="row mb-12 mb-2">
                                        <label for="idpackinglist"  style="width: 20%;"class="col-sm-2 col-form-label">ID Packing</label>
                                        <div class="col-sm-6">
                                          <input  type="text" id="idpackinglist"  class="form-control">
                                        </div>
                                    </div>

                                    <div class="row mb-12 mb-2">
                                        <label for="transnoHider"  style="width: 20%;"class="col-sm-2 col-form-label">Transno</label>
                                        <div class="col-sm-6">
                                          <input disabled type="text" id="transnoHider"  class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-12 mb-2">
                                        <label for="id_bl_awb"  style="width: 20%;"class="col-sm-2 col-form-label">BL/AWB</label>
                                        <div class="col-sm-6">
                                          <input  type="text" id="id_bl_awb"  class="form-control">
                                        </div>
                                    </div>
                                   
                                    </div>
                                    <div class="col-md-6">
                                    <div class="row mb-12 mb-2">
                                        <label for="tanggal" style="width: 20%;" class="col-sm-2 col-form-label">Tanggal</label>
                                        <div  style="width:35%;"  class="col-sm-6">
                                          <input  type="date" id="tanggal" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-12 mb-2">
                                        <label for="keterangan" style="width:20%;" class="col-sm-3 col-form-label">Keterangan</label>
                                        <div class="col-sm-6">
                                          <textarea type="text" style="width:150%; height:80px;" id="keterangan" class="form-control"></textarea>
                                          <span id="keteranganError" class="error"></span>
                                        </div>
                                    </div>
                                    <div class="row mb-12 mb-2">
                                        <label for="pib" style="width: 20%;" class="col-sm-2 col-form-label">PIB</label>
                                        <div  style="width:35%;"  class="col-sm-6">
                                          <input  type="text" id="pib" class="form-control text-end">
                                        </div>
                                    </div>
                                    <div class="row mb-12 mb-2">
                                        <label for="forwarder" style="width: 20%;" class="col-sm-2 col-form-label">Forwarder</label>
                                        <div  style="width:35%;"  class="col-sm-6">
                                          <input  type="text" id="forwarder" class="form-control text-end">
                                          <span id="forwarderError" class="error"></span>
                                        </div>
                                    </div>
                                    <div class="row mb-12 mb-2">
                                        <label for="total" style="width: 20%;" class="col-sm-2 col-form-label">Total</label>
                                        <div  style="width:35%;"  class="col-sm-6">
                                          <span  type="text" id="total" style="display: flex;justify-content: flex-end"></span>
                                        </div>
                                    </div>                            
                              </div>
                              </div>
                      
                            </div>
                      </div>
                  </div>

               
                  <div id="itemTabel"></div>                                         
              </div>
          </div>
                                                       

  <!-- /.content-wrapper -->


  
  <script>
  $(document).ready(function(){
     const userid ="<?=trim($userid) ?>";
      // $("#selectpo").hide();


    SetTransno();
    SetTanggal();
 
    $("#suplair").select2({
      theme: "bootstrap-5",
    });

    $('#nopo').select2({
      placeholder: "Please Select",
      theme: "bootstrap-5",
    });
      $('#pib').on('keyup', function() {
                let inputVal = $(this).val();
                let formattedVal = formatRupiah(inputVal);
                $(this).val(formattedVal);
            });

      $('#forwarder').on('keyup', function() {
           let pib  = $("#pib").val(); 
              if(pib !==''){
                    let inputVal = $(this).val(); // Menghapus karakter selain angka dan koma
                    let formattedVal = formatRupiah(inputVal);
                    $(this).val(formattedVal);
                    $("#forwarderError").text("");

              }else{
                $("#forwarderError").text("pbi harus di isi dulu");
            
              }
            });

      $("#suplair").on("change",function(){
         const suplairid = $(this).val();
          const datas ={
            "suplairid":suplairid
          };
          getTampilPO(datas);
      });

      $("#nopo").on("change",function(){
        const  DOTransacID = $(this).val();

        const datas ={
            "DOTransacID":DOTransacID
          };
          getTampilDetailPO(datas);
      })
    

      $("#forwarder").on("change",function(){
        let pib  = $("#pib").val();
        if(pib !==''){
          let forward = $(this).val();
          settotal(pib,forward);
          $("#forwarderError").text("");
        }else{
            $("#forwarderError").text("pbi harus di isi dulu");
        }
      })

      $("#pib").on("change",function(){
        let pib  = $("#forwarder").val();
        if(pib !==''){
          let forward = $(this).val();
          settotal(pib,forward);
          $("#forwarderError").text("");
        }

      })



});
  // and document ready

  function  settotal(pib,forward){
     
      let c = formatjm(pib) + formatjm(forward);
    
     let d = formatRupiah(c.toFixed(2).toString());
      $("#total").html(d+"&nbsp;&nbsp;&nbsp;");
  }

  function formatjm(angka){
    return parseFloat(angka.replace(/[^0-9.]/g, ''));
  }

  function formatRupiah(angka, prefix) {
           
            // Menghapus karakter yang bukan angka dan titik
            let number_string = angka.replace(/[^0-9.]/g, '').toString();
            let split = number_string.split('.');
            //Batas angka desimal hanya dua digit
            if(split[1]){
              split[1] =split[1].substring(0,2);
            }
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            
            if (ribuan) {
              separator = sisa ? ',' : '';
              rupiah += separator + ribuan.join(',');
            }
            
            rupiah = split[1] != undefined ? rupiah + '.' + split[1] : rupiah;

            return prefix == undefined ? rupiah : (rupiah ? prefix + rupiah : '');
        }





          
       


  function SetTanggal(){
    flatpickr("#tanggal", {
                dateFormat: "d/m/Y", // Format yang diinginkan
                allowInput: true ,// Memungkinkan input manual
                defaultDate: new Date()
            });
      
  }

  function TglSekarang(){
    var d = new Date();
      var month = d.getMonth()+1;
      var day = d.getDate();
      let  output =  d.getFullYear() +'-'+
					(month<10 ? '0' : '') + month + '-' +
				 (day<10 ? '0' : '') + day;
      return output;
  }

  function getTampilPO(datas){
  
    $.ajax({
                url:"<?=base_url?>/transaksi/tampilpobysup",
                method:"POST",
                dataType: "json",
                data:datas,
              
                success:function(result){
                
           
                  $("#nopo").empty();
                  $("#nopo").append('<option value="" disabled selected>Please Select</option>');
                  $.each(result,function(a,b){
               
                    const DONumber = b.DONumber;
                    const DOTransacID = b.DOTransacID;
                    $("#nopo").append('<option value="' + DOTransacID + '">' + DONumber + '</option>');

                  })
                 // $('#nopo').trigger('change');
               
                }
    });


  }

  function  getTampilDetailPO(datas){
      $.ajax({
        url:"<?=base_url?>/transaksi/tampildetailpo",
                method:"POST",
                dataType: "json",
                data:datas,
        success:function(result){
          getListItem();
          setData(result);
        }
            
      })
  }

  function getListItem(){
     const item =`<div class="card mt-2">
      <div class="card-body">
      <div id="tabellist"></div>
      <div class="text-center"> 
      <button type="btn"  onclick="Submitdata()"; class="btn btn-primary">Simpan</button>
      <button type="btn" onclick="Bataldata()";  class="btn btn-secondary">Batal</button>
      </div>
      </div>
      
  </div>`;
  $("#itemTabel").empty().html(item);
  }

  function setData(result){
    // $("#CreateAdd").fadeIn();
    // $("#delete").fadeIn();
    // $("#loadingModal").hide(); table-info
    const transno =$("#transnoHider").val();
    let datatabel = ``;

    datatabel +=`
                 <table id="tabel1" class='table table-info table-striped table-hover' style='width:100%'>                    
                                      <thead  id='thead'class='thead'>
                                                <tr>
                                                            <th class="text-center">NO</th>
                                                            <th>PARTID</th>
                                                            <th>DESCRIPTION</th>
                                                            <th>UNIT</th>
                                                            <th  class="text-end">QTY</th>
                                                            <th class="text-end">QTY(CTNS)</th>
                                                            <th class="text-end">NET WEIGHT</th>
                                                            <th class="text-end">GW(KGS)</th>
                                                            <th class="text-end">MEAS(CBM)</th>
                                                         
                                                           
                                                </tr>
                                                
                                                </thead>
                                                <tbody>
                                          
    `;
     let no =1;
     let idno =1;
     let groupidctns =``;
     let groupidgtns =``;
     let groupidkgs =``;
     let groupidcbm =``;
    $.each(result,function(a,b){
 
      let status_document = b.status_document;
      let nama_document = b.nama_document;
      let new_partid = b.New_partid;
  
      
      // $("#stdocument").val(status_document);
      // let status_gambar =0;
      let nomer = idno++;
      let idctns = nomer+'_CTNS';
      let idgtns = nomer+'_GTNS';
      let idkgs = nomer+'_KGS';
      let idcbm = nomer+'_CBM';
     
      let kom_cbm = nomer+'_KOMPCBM';
      groupidctns+=idctns+',';
      groupidgtns+=idgtns+',';
      groupidkgs+=idkgs+',';
      groupidcbm+=idcbm+'|'+kom_cbm+',';

      datatabel +=`
                  <td class="text-center" style="width:5%">${no++}</td>
                  <td>${b.Partid}</td>
                  <td style="width:30%">${b.PartName}</td>
                  <td style="width:10%">${b.satuan}</td>
                  <td class="text-end" style="width:10%">${b.qty}</td>`;
      datatabel +=`<td  style="width:10%;" class="text-end"><input class="CTNS form-control col-md-1 text-end" name="CTNS" type="text" id="${idctns}"></input></td>`;   
      datatabel +=`<td  style="width:10%;"  class="text-end"><input class="GTNS form-control col-md-1 text-end" name="GTNS" type="text" id="${idgtns}"></input></td>`;          
      datatabel +=`<td  style="width:10%;"  class="text-end"><input class="KGS form-control col-md-1 text-end" name="KGS" type="text" id="${idkgs}"></input></td>`;          
      datatabel +=`<td  style="width:10%;" class="text-end"><input class="CBM form-control col-md-1 text-end" name="CBM" type="text" id="${idcbm}"></input></td>`;          
    
      datatabel +=`</tr>`;
    });

    datatabel+=`</tbody><tfoot>
						<tr>
						  <th></th>
              <th></th>
              <th></th>
						  <th>Total :</th>
              <th class="text-end"></th>
              <th class="text-end" id="total_CTNS"></th>
						  <th class="text-end" id="total_GTNS"></th>
						  <th class="text-end" id="total_KGS"></th>
						  <th class="text-end" id="total_CBM"></th>
             
                     `; 
      datatabel +=`</tr></tfoot></table>`;

    $("#tabellist").empty().html(datatabel);
	 let str_idctns = groupidctns.slice(0,-1);
   let str_idgtns = groupidgtns.slice(0,-1);
   let str_idkgs = groupidkgs.slice(0,-1);
   let str_idcbm = groupidcbm.slice(0,-1);

    getrupiahdetail(str_idctns,str_idgtns,str_idkgs,str_idcbm);
  
    setdataTable();
  }

  function getrupiahdetail(str_idctns,str_idgtns,str_idkgs,str_idcbm){
         //str_idctns
          let data_idctns = str_idctns.split(",");
              $.each(data_idctns,function(index,value){
              let id_ctns ="#"+value;
              
              $(id_ctns).on('keyup',function(){
                let inputVal = $(this).val();
                let formattedVal = formatRupiah(inputVal);
                $(this).val(formattedVal);
              })
            // Tambahan untuk cegah huruf saat ketik
        
          
            });

        //and
        // data_idgtns
                 let data_idgtns = str_idgtns.split(",");
              $.each(data_idgtns,function(index1,value1){
              let id_idgtns ="#"+value1;
              $(id_idgtns).on('keyup',function(){
                  let inputid_idgtns= $(this).val(); // Menghapus karakter selain angka dan koma
                    let formattedVal1 = formatRupiah(inputid_idgtns);
                    $(this).val(formattedVal1);
              })
          
            });
        //and
        //and str_idkgs
               let data_idkgs = str_idkgs.split(",");
              $.each(data_idkgs,function(index2,value2){
              let id_idkgs ="#"+value2;
              $(id_idkgs).on('keyup',function(){
                  let inputid_id_idkgs= $(this).val(); // Menghapus karakter selain angka dan koma
                    let formattedVal2 = formatRupiah(inputid_id_idkgs);
                    $(this).val(formattedVal2);
              })
          
            });
        //and
           //and str_idcbm
           let data_idcbm = str_idcbm.split(",");

              $.each(data_idcbm,function(index3,value3){
               let str_split = value3.split("|");
             
              let id_cbm="#"+str_split[0];
              let id_comp = str_split[1];
              $(id_cbm).on('keyup',function(){
                  let inputid_cbm= $(this).val(); // Menghapus karakter selain angka dan koma
                    let formattedVal3 = formatRupiah(inputid_cbm);
                    $(this).val(formattedVal3);

                   // setkomposisi(inputid_cbm,id_comp)
              })
              
                // $(document).on('input',id_cbm,function(){
                //   let inputid_cbm= $(this).val().replace(/[^,\d]/g, '');
                
                // })
            });
        //and
  }
 

  $(document).on('input', '.CTNS', function() {

      let data = "CTNS";
        calculateTotal(data);
    });
    $(document).on('input', '.GTNS', function() {
       let data = "GTNS";
      calculateTotal(data);
   });
   $(document).on('input', '.KGS', function() {
       let data = "KGS";
      calculateTotal(data);
   });
   $(document).on('input', '.CBM', function() {
       let data = "CBM";
      calculateTotal(data);
   });


   setkomposisi=(inputid_cbm,totalcbm)=>{
        let total_CBM  =totalcbm;

        let hasil ="";
        if(inputid_cbm !=="" && total_CBM !==""){

       
        let t_cbm= total_CBM.replace(/\,/g,"");
        let b = parseFloat(t_cbm);

        let input_rep = inputid_cbm.replace(/\,/g,"");
        let a = parseFloat(input_rep)

        let rumus =(a/b)*100;
    
        hasil=rumus;
        
      }else{
        hasil =0;
      }
      return hasil;
   }

  function calculateTotal(data) {

        let total = 0;
        let id ="."+data;
        $(id).each(function() {
          let di_value =$(this).val();
            total += formatjm(di_value) || 0; // Mengambil nilai input, jika kosong dianggap 0
        });
        let tt =total.toFixed(2).toString();
        let tst = formatRupiah(tt);
        let id_tt = "#total_"+data;
        $(id_tt).text(tst);
    }

  function setdataTable(){
    $('#tabel1').DataTable({
		  autoWidth: false,
           responsive: true,
            response:true,
            paging: false,
            // pageLength: 10,
            // lengthMenu: [[10, 20, -1], [10, 20, 'All']],
               "footerCallback": function ( row, data, start, end, display ) {
                              let api = this.api();
                  
                          // Remove the formatting to get integer data for summation
                          let intVal = function (i) {
                              const w = i;
                              return typeof w === 'string'
                                  ? w.replace(/[\$,]/g, '') * 1
                                  : typeof w === 'number'
                                  ? w
                                  : 0;
                          };
                  
                          // Total over all budget
                    total_qty = api
                              .column(4)
                              .data()
                              .reduce((a, b) =>intVal(a) + intVal(b), 0);
                       // Total over all realisasi
					   
						 var total_qty = display.map(el => data[el][4]).reduce((a, b) => intVal(a) + intVal(b), 0 );
                         $(api.column(4).footer()).html(
                          total_qty.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                          );
						  
					    
                },   
      
          });  
  }

  function Submitdata(){

      const total = $("#total").text();
     
      if(total !==""){

        const pib           = $("#pib").val();
        const forwarder     = $("#forwarder").val();
        const transnoHider  = $("#transnoHider").val();
        const suplieid      = $("#suplair").find(":selected").val();
        const nopo          = $("#nopo").find(":selected").val();
        const nodo          = $("#nopo").find(":selected").text();
        const tanggal       = $("#tanggal").val();
        const ket           = $("#keterangan").val();
        const idpackinglist = $("#idpackinglist").val();
        const id_bl_awb     = $("#id_bl_awb").val();
        let userid          = "<?=trim($userid)?>";
      
        let dataheader ={
          "userid"        :userid,
          "transo"        :transnoHider,
          "suplieid"      :suplieid,
          "nodo"          :nodo,
          "nopo"          :nopo,
          "tanggal"       :tanggal,
          "keterangan"    :rep_kutif(ket),
          "idpackinglist" :rep_kutif(idpackinglist),
          "pib"           :pib.replace(/\,/g,""),
          "forwarder"     :forwarder.replace(/\,/g,""),
          "total"         :total.replace(/\,/g,"").trim(),
          "id_bl_awb"     :id_bl_awb
          
        };

       

        let totalcbm = $("#tabel1 tfoot #total_CBM").text();
        
        let dataobject =[];   
            $("#tabel1 >tbody >tr").each(function(){
              let dt=[];
              let data ={
                "partid":$(this).find('td:eq(1)').text(),
                "partname":$(this).find('td:eq(2)').text(),
                "unit":$(this).find('td:eq(3)').text(),
                "qty":$(this).find('td:eq(4)').text().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
                "CTNS":$(this).find('input[name="CTNS"]').val().replace(/\,/g,""),
                "GTNS":$(this).find('input[name="GTNS"]').val().replace(/\,/g,""),
                "KGS":$(this).find('input[name="KGS"]').val().replace(/\,/g,""),
                "CBM":$(this).find('input[name="CBM"]').val().replace(/\,/g,""),
                "Total_CBM":setkomposisi($(this).find('input[name="CBM"]').val(),totalcbm)
              }
              dt = data;
          if(dt.length !== 0) {
           dataobject.push(dt)
           }
        });

    
     
        let datafull ={
          "dataheader":dataheader,
          "datadetail":dataobject 
        };
        

        
    
       $.ajax({
              url:"<?=base_url?>/transaksi/simpandata",
                method:"POST",
                dataType: "json",
                data:datafull,
                // beforeSend: function(){
                //       Swal.fire({
                //         title: 'Loading',
                //         html: 'Please wait...',
                //         allowEscapeKey: false,
                //         allowOutsideClick: false,
                //         didOpen: () => {
                //         Swal.showLoading()
                //     }
                //         });
                //     },
                success:function(result){
          
                  let pesan = result.error
                  let nilai = result.nilai
                 Swal.fire({
                      position: "top-center",
                      icon: "success",
                      title: pesan,
                      showConfirmButton: false,
                      timer: 2000
                    }).then(function(){
                      goBack()
                    })
                       



               
                }
              });
    
    }else{
            Swal.fire({
                      position: "top-center",
                      icon: "info",
                      title: "pib dan forwarder harus di isi",
                      showConfirmButton: false,
                      timer: 2000
                    })
    }
}

function rep_kutif(data){

return data.replace(/'/g, 'kut1;').replace(/"/g, 'kut2;');
}
  function goBack(){
    window.location.replace("<?=base_url?>/transaksi/index");
  }

  function gettombolparid(str_id){
    let data_id = str_id.split(",");
    
     $.each(data_id,function(index,value){
    
      let id_tbl ="#"+value;
  
    });
  }

  function getPartid(partid){
      $("#partname").val("");
      $("#partname").empty();
    $.ajax({
                url:"<?=base_url?>/Inventoriiad/getpartid",
                method:"POST",
                dataType: "json",
                data:{filter:partid},
                success:function(result){
                  if(result !== null){
                    $.each(result,function(key,value){
                      let partname_asli = value.partid;
                        let partname = value.partname;
                        $("#partname").append($('<option/>').val(partname_asli).html(partname));  
                      });
          
                      let partid = $("#partname").val();
                        $("#partid").val(partid);
                  }else{
                    Swal.fire({
                      position: "top-center",
                      icon: "info",
                      title: "partid yang di input tidak ada",
                      showConfirmButton: true,
                      //timer: 1500
                    });
                  }


                }
    });


  }





  
  function SetTransno(){

   
    var currentDate = new Date();
    // Format the date using moment.js
      var formattedDate = moment(currentDate).format("YYYY-MM-DD HH:mm:ss");
    
      let split =formattedDate.split("-");
      let thn = split[0].substr(2,2);
      let bln = split[1];
      let tgl = split[2];
      let rep_tgl = tgl.replace(" ","");
      let rep_tgl2 = rep_tgl.replace(":","");
      let rep_tgl3 = rep_tgl2.replace(":",""); 

      let id_trns ="BMI_PL"+thn+bln+rep_tgl3;


      $("#transnoHider").val(id_trns);
    
  
  }



  function validasiinput(event){
   const keterangan = $("#keterangan").val();
			if (keterangan === "") {
			  $("#keteranganError").text("keterangan harus diisi");
			  event.preventDefault(); // Menghentikan pengiriman formulir jika ada kesalahan
			} else {
			  $("#keteranganError").text("");
			} 


      const transtype = $("#transtype").find(":selected").val();
			if (transtype === "" || transtype === undefined) {
			  $("#transtypeError").text("transtype harus Pilih");
			  event.preventDefault(); // Menghentikan pengiriman formulir jika ada kesalahan
			} else {
			  $("#transtypeError").text("");
			}


   const refNo = $("#refNo").val();
		 /*  	if (refNo === "") {
			  $("#refNoError").text("refNo harus diisi");
			  event.preventDefault(); // Menghentikan pengiriman formulir jika ada kesalahan
			} else {
			  $("#refNoError").text("");
			}
		*/

      const BatchNo = $("#BatchNo").val();
		 /* 	if (BatchNo === "") {
			  $("#BatchNoError").text("BatchNo harus diisi");
			  event.preventDefault(); // Menghentikan pengiriman formulir jika ada kesalahan
			} else {
			  $("#BatchNoError").text("");
			} */


      const warehouse = $("#warehouse").find(":selected").val();
			if (warehouse === "" || warehouse === undefined) {
			  $("#warehouseError").text("warehouse harus Pilih");
			  event.preventDefault(); // Menghentikan pengiriman formulir jika ada kesalahan
			} else {
			  $("#warehouseError").text("");
			}

      const partid = $("#partid").val();
			if (partid === "") {
			  $("#partidError").text("partid harus Pilih");
			  event.preventDefault(); // Menghentikan pengiriman formulir jika ada kesalahan
			} else {
			  $("#partidError").text("");
			}

      const pcs = $("#pcs").val();
			if (pcs === "") {
			  $("#pcsError").text("Qty harus diisi");
			  event.preventDefault(); // Menghentikan pengiriman formulir jika ada kesalahan
			}else if(pcs =="0"){
				$("#pcsError").text("Qty  tidak boleh 0");
			}else {
			  $("#pcsError").text("");
			}
			
			
     const comment = $("#comment").val();
      /* 
			if (comment === ""){
			  $("#commentError").text("comment harus diisi");
			  event.preventDefault(); // Menghentikan pengiriman formulir jika ada kesalahan
			} else {
			  $("#commentError").text("");
			} */


		const partname = $("#partname").find(":selected").val();
		
			if (partname === "" || partname === undefined) {
			  $("#partnameError").text("partname harus ada isi nya");
			  event.preventDefault(); // Menghentikan pengiriman formulir jika ada kesalahan
			} else {
			  $("#partnameError").text("");
			}
      const userid = "<?= trim($userid)?>";


      const tanggal = $("#tanggal").val();
      const transnoHider = $("#transnoHider").val();
      const transno = $("#transno").val();
     

	
		
      if(transtype !=="" && transtype !==undefined && warehouse !== "" && warehouse !== undefined &&
      partid !== "" && pcs !== "" && pcs !=='0' &&  partname !=="" && partname !==undefined &&  keterangan !=="" ){

          const datahead ={
            userid:userid,
            tanggal:tanggal,
            transnohider:transnoHider,
            keterangan:keterangan,

          }
          const datadetail ={
            transno:transnoHider,
            transtype:transtype,
            refno:refNo,
            batchno:BatchNo,
            warehouse:warehouse,
            partid:partname,
            pcs:pcs,
            comment:comment,
         

          }
          let fulldata ={
            datahead:datahead,
            datadetail:datadetail
          }
          
          //const validasitgl = validasitanggal(tanggal);
          //console.log(validasitgl)
         //console.log(fulldata);
          return  fulldata;
      }else{
          return false;
      }
  }



 
  function  GetkodeTransada(userid){
    $("#loadingModal").show();
      $.ajax({
                  url:"<?=base_url?>/Inventoriiad/Tampildata",
                  data:{userid:userid},
                  method:"POST",
                  dataType: "json",
                  success:function(result){
                     const datahead = result.datahider;
                     const datadetail = result.datadetail;
                    
                     if(datahead.length == 0){
                      $("#loadingModal").hide();
                      SetTransno();
                      SetTanggal();
                     }else{
                      getListItem();
                      SetdataHider(datahead);
                      SetdataDetail(datadetail);
                     }
  
                  }
      });

  }



   function SetdataHider(datahead){
                let SoTransacID ="";
                let SOEntryDesc ="";
                let Shipdate="";
              $.each(datahead,function(key,value){
                    SoTransacID = value.SoTransacID;
                    SOEntryDesc = value.SOEntryDesc;
                    Shipdate = value.Shipdate;
                  });


              $("#tanggal").val(Shipdate);
              $("#transnoHider").val(SoTransacID);
              $("#keterangan").val(SOEntryDesc);
   }




function  SetdataDetail(datadetail){
                setData(datadetail);
       
          
} 




 

  function edit_row(transno,itemno,transtype,warehouse,batchno,Refno,PartId,Quantity,keterangan){
        $("#edit_row").fadeOut();
        $("#delete").fadeOut();
        $("#transtype").val(transtype);
        $("#warehouse").val(warehouse);
        $("#refNo").val(Refno);
        $("#BatchNo").val(batchno);
        $("#pcs").val(Quantity);
        $("#comment").val(keterangan);
        getPartid(PartId);


        const data ={
          transno:transno,
          itemno:itemno
        }
        $.ajax({
                      url:"<?=base_url?>/inventoriiad/deletdatarow",
                      method:"POST",
                      dataType: "json",
                      data:data,
                      success:function(result){
                        setData(result);
                      }
          });
  }

function delete_row(transno,itemno){
  $("#delete").fadeOut();
  const data ={
    transno:transno,
    itemno:itemno
  }
  $.ajax({
                url:"<?=base_url?>/inventoriiad/deletdatarow",
                method:"POST",
                dataType: "json",
                data:data,
                success:function(result){
                   setData(result);
                }
    });
  }



  function Bataldata(){
      let userid = "<?=trim($userid)?>";
      const transno =$("#transnoHider").val();

      const datas ={
        "transo":transno
      }
      Swal.fire({
                title: "Apakah Anda Yakin Membatalkan inputan ini",
                text: "Batal Input Data Ini!",
                type: "warning",
                showDenyButton: true,
                confirmButtonColor: "#0000FF",
                denyButtonColor: "#757575",
                confirmButtonText: "Ya",
                denyButtonText: "Tidak",
              }).then((result) =>{
                 if(result.isConfirmed){
                      goBack();
                 }
              });

      }








function risettabel(){
  $("#loadingModal").hide();
  $("#transtype").val();
  $("#warehouse").val();
  // $("#transtype").prepend("<option value='' selected disabled>Please Select</option>");
  // $("#warehouse").prepend("<option value='' selected disabled>Please Select</option>");
                    $("#keterangan").val("");
                      $("#partid").val("");
                      $("#partname").val("");
                      $("#refNo").val("");
                      $("#BatchNo").val("");
                      $("#comment").val("");
                      $("#pcs").val(0);
                      SetTransno();
                      SetTanggal();
}






  function getValidasiData(){
			
      $("#transtype").blur(function() {
       let transtype = $(this).val();
       if (transtype ==="" || transtype === undefined) {
         $("#transtypeError").text("transtype harus diisi");
       } else {
         $("#transtypeError").text("");
       }
       });
   
   
        $("#warehouse").blur(function() {
            let warehouse = $(this).val();
            if (warehouse ==="" || warehouse === undefined){
              $("#warehouseError").text("warehouse harus diisi");
            } else {
              $("#warehouseError").text("");
            }
            });
       
        $("#partid").blur(function() {
            let partid = $(this).val();
            if (partid ===""){
              $("#partidError").text("partid harus diisi");
            } else {
              $("#partidError").text("");
            }
            });
       
      $("#partname").blur(function() {
          let partname = $(this).val();
          if (partname ==="" || partname === undefined){
            $("#partnameError").text("partname harus ada isi nya");
          } else {
            $("#partnameError").text("");
          }
          });
       
      $("#pcs").blur(function() {
          let pcs = $(this).val();
          if (pcs ==="" || pcs === undefined){
            $("#pcsError").text("pcs harus ada isi nya");
          } else {
            $("#pcsError").text("");
          }
          });
		  
		  
		  $("#keterangan").blur(function() {
            let keterangan = $(this).val();
            if (keterangan ===""){
              $("#keteranganError").text("keterangan harus diisi");
            } else {
              $("#keteranganError").text("");
            }
            });
 }

</script>
