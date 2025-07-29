
<?php
$datapost = $data["datapost"];
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
		  background-color: #F3FEB8 !important;
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
                            <h5 class="text-center">Detail Data</h5>
                            </div>
                          </div>
                        
                        </div>
                          <div class="card-body">
                            <div class=" row col-md-12">
                              <div class="col-md-6">
                              <div class="row mb-12 mb-2">
                                        <label for="suplair" style="width:20%;" class="col-sm-2 col-form-label">Supplier</label>
                                                  <div  class=" col-sm-9">
                                                              <select  disabled class="form-control" id="suplair">
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
                                                              <select disabled class="form-control" id="nopo">
                                                  
                                                            </select>
                                                                  <span id="nopoError" class="error"></span>
                                                          </div>
                                    </div>

                                    <div class="row mb-12 mb-2">
                                        <label for="idpackinglist"  style="width: 20%;"class="col-sm-2 col-form-label">ID Packing</label>
                                        <div class="col-sm-6">
                                          <input  disabled type="text" value="<?=$datapost["No_Pli"]?>" id="idpackinglist"  class="form-control">
                                        </div>
                                    </div>

                                    <div class="row mb-12 mb-2">
                                        <label for="transnoHider"  style="width: 20%;"class="col-sm-2 col-form-label">Transno</label>
                                        <div class="col-sm-6">
                                          <input disabled type="text" value="<?=$datapost["No_Pls"]?>" id="transnoHider"  class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-12 mb-2">
                                        <label for="id_bl_awb"  style="width: 20%;"class="col-sm-2 col-form-label">BL/AWB</label>
                                        <div class="col-sm-6">
                                          <input disabled type="text" id="id_bl_awb" value="<?=$datapost["id_bl_awb"]?>"  class="form-control">
                                        </div>
                                    </div>
                                   
                                    </div>
                                    <div class="col-md-6">
                                    <div  class="row mb-12 mb-2">
                                        <label for="tanggal" style="width: 20%;" class="col-sm-2 col-form-label">Tanggal</label>
                                        <div  style="width:35%;"  class="col-sm-6">
                                          <input disabled  type="date" id="tanggal" value="<?=$datapost["EntryDate"]?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-12 mb-2">
                                        <label for="keterangan" style="width:20%;" class="col-sm-3 col-form-label">Keterangan</label>
                                        <div class="col-sm-6">
                                          <textarea disabled type="text" value="<?=$datapost["Note"] ?>"
                                          style="width:150%; height:80px;" id="keterangan" class="form-control"> <?=$datapost["Note"]?></textarea>
                                          <span id="keteranganError" class="error"></span>
                                        </div>
                                    </div>
                                    <div class="row mb-12 mb-2">
                                        <label for="pib" style="width: 20%;" class="col-sm-2 col-form-label">PIB</label>
                                        <div  style="width:35%;"  class="col-sm-6">
                                          <input disabled value="<?=$datapost["Pib"]?>" type="text" id="pib" class="form-control text-end">
                                        </div>
                                    </div>
                                    <div class="row mb-12 mb-2">
                                        <label for="forwarder" style="width: 20%;" class="col-sm-2 col-form-label">Forwarder</label>
                                        <div  style="width:35%;"  class="col-sm-6">
                                          <input disabled value="<?=$datapost["Forwarder"]?>" type="text" id="forwarder" class="form-control text-end">
                                          <span id="forwarderError" class="error"></span>
                                        </div>
                                    </div>
                                    <div class="row mb-12 mb-2">
                                        <label for="total" style="width: 20%;" class="col-sm-2 col-form-label">Total</label>
                                        <div  style="width:35%;"  class="col-sm-6">
                                          <span disabled type="text" id="total" style="display: flex;justify-content: flex-end"><?=$datapost["Total"]."&nbsp;&nbsp;&nbsp;"?></span>
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


    setPostdata();
    $('#pib').on('keyup', function() {
                var inputVal = $(this).val().replace(/[^,\d]/g, ''); // Menghapus karakter selain angka dan koma
                var formattedVal = formatRupiah(inputVal);
                $(this).val(formattedVal);
            });
      $('#forwarder').on('keyup', function() {
           let pib  = $("#pib").val();
              if(pib !==''){
                    var inputVal = $(this).val().replace(/[^,\d]/g, ''); // Menghapus karakter selain angka dan koma
                    var formattedVal = formatRupiah(inputVal);
                    $(this).val(formattedVal);
                    $("#forwarderError").text("");

              }else{
                $("#forwarderError").text("pbi harus di isi dulu");
            
              }
            });

    $("#pib").on("change",function(){
        let forward  = $("#forwarder").val();
        if(forward !==''){
          let pib = $(this).val();
          settotal(pib,forward);
          $("#forwarderError").text("");
        }else{
            $("#forwarderError").text("forwarder harus di isi dulu");
        }
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

  function setPostdata(){
      let suppid ="<?=$datapost["supid"]?>";
      
      $("#suplair").val(suppid);
      const datas ={
            "suplairid":suppid
          };
      getTampilPO(datas);
     
   

  }
  function setNoPO(){
    let POTransacid ="<?=$datapost["POTransacid"]?>";
    let transnoHider =$("#transnoHider").val();
    $("#nopo").val(POTransacid);

    const datas ={
            "DOTransacID":POTransacid,
            "transnoHider":transnoHider
          };
    
          getTampilDetailPO(datas);
    
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
                url:"<?=base_url?>/transaksi/tampilpobysupedit",
                method:"POST",
                dataType: "json",
                data:datas,
          
                success:function(result){
                  $("#nopo").empty();
                  
                  $.each(result,function(a,b){
               
                    const DONumber = b.DONumber;
                    const DOTransacID = b.DOTransacID;
                    $("#nopo").append('<option value="'+ DOTransacID +'">' + DONumber + '</option>');

                  })
                 
                }
    });
    setNoPO();

  }

  function  getTampilDetailPO(datas){
      $.ajax({
        url:"<?=base_url?>/transaksi/tampileditdetailpo",
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
      <button type="btn"  onclick="goBack()"; class="btn btn-info">Kembali</button>

      </div>
      </div>
      
  </div>`;
  $("#itemTabel").empty().html(item);
  }

  function setData(result){
    // $("#CreateAdd").fadeIn();
    // $("#delete").fadeIn();
    // $("#loadingModal").hide();
    const transno =$("#transnoHider").val();
    let datatabel = ``;

    datatabel +=`
                 <table id="tabel1" class='table table-info table-striped table-bordered  table-hover' style='width:100%'>                    
                                      <thead  id='thead'class ='thead'>
                                                <tr>
                                                            <th class="text-center">NO</th>
                                                            <th>PARTID</th>
                                                            <th>DESCRIPTION</th>
                                                            <th  class="text-end">QTY</th>
                                                            <th  class="text-end">QTY(CTNS)</th>
                                                            <th  class="text-end">GW(GTNS)</th>
                                                            <th  class="text-end">GW(KGS)</th>
                                                            <th  class="text-end">MFAS(CBM)</th>
                                                           
                                                </tr>
                                                
                                                </thead>
                                                <tbody>
                                          
    `;
     let no =1;
     let idno =1;
     let idpartbaru =``;
    $.each(result,function(a,b){
 
      let status_document = b.status_document;
      let nama_document = b.nama_document;
      let new_partid = b.New_partid;
  
      // $("#stdocument").val(status_document);
      // let status_gambar =0;
      let nomer = idno++;
      let idwherehouse ="NewWherehouse_"+nomer;
      let idpartnew ="NewPartid_"+nomer;
      let idnewqty="newqty"+nomer;
      idpartbaru+=idpartnew+',';
      datatabel +=`
                  <td class="text-center" style="width:5%" id="${b.PODetail}">${no++}</td>
                  <td>${b.Partid}</td>
                  <td style="width:30%">${b.PartName}</td>
                  <td class="text-end"style="width:10%">${b.qty}</td>`;
      datatabel +=`<td  style="width:10%" class="text-end"><input disabled value="${b.CTNS}"class="CTNS form-control col-md-1 text-end" name="CTNS" type="text" id="CTNS"></input></td>`;   
      datatabel +=`<td  style="width:10%"  class="text-end"><input disabled value="${b.GTNS}" class="GTNS form-control col-md-1 text-end" name="GTNS" type="text" id="GTNS"></input></td>`;          
      datatabel +=`<td  style="width:10%"  class="text-end"><input disabled value="${b.KGS}" class="KGS form-control col-md-1 text-end" name="KGS" type="text" id="KGS"></input></td>`;          
      datatabel +=`<td  style="width:10%" class="text-end"><input disabled  value="${b.CBM}" class="CBM form-control col-md-1 text-end" name="CBM" type="text" id="CBM"></input></td>`;          
     

                  datatabel +=`</tr>`;
    });

    datatabel+=`</tbody><tfoot>
						<tr>
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
	 // let str_id = idpartbaru.slice(0,-1);

    //gettombolparid(str_id);
  
    setdataTable();
    setjumlah();
  }
  function setjumlah(){
    let data =["CTNS","GTNS","KGS","CBM"];

    for(let i=0; i < data.length; i++){
      calculateTotal(data[i]);
    }
    
  }
  $(document).on('input', '.CTNS', function() {

      let data = "CTNS";
        calculateTotal(data);
    });
    $(document).on('input', '.GTNS', function() {
       let data = "GTNS";
      calculateTotal(data);
   });
   $(document).on('input', '#KGS', function() {
       let data = "KGS";
      calculateTotal(data);
   });
   $(document).on('input', '.CBM', function() {
       let data = "CBM";
      calculateTotal(data);
   });
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
                              .column(3)
                              .data()
                              .reduce((a, b) =>intVal(a) + intVal(b), 0);
                       // Total over all realisasi
					   
						 var total_qty = display.map(el => data[el][3]).reduce((a, b) => intVal(a) + intVal(b), 0 );
                         $(api.column(3).footer()).html(
                          total_qty.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                          );
						  
					    
                },   
      
          });  
  }

function rep_kutif(data){

return data.replace(/'/g, '&apos;').replace(/"/g, '&quot;');
}


  function goBack(){
    window.location.replace("<?=base_url?>/transaksi/postlist");
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



function validasitanggal(tanggal){
  const tgl_sekarang = TglSekarang();
  split_tgls = tgl_sekarang.split('-');

  console.log(split_tgls)
  
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