<?php
$datapost = $data["datapost"];


$supplier = $data["Supplier"];
$userid =  $data["userid"];
?>

<style>
  input[type="file"] {
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
    filter: url(#custom-shadow);
  }

  .loading-spinner {
    width: 30px;
    height: 30px;
    border: 2px solid indigo;
    border-radius: 50%;
    border-top-color: #0001;
    display: inline-block;
    animation: loadingspinner .7s linear infinite;
  }

  @keyframes loadingspinner {
    0% {
      transform: rotate(0deg)
    }

    100% {
      transform: rotate(360deg)
    }
  }

  .thead {
    background-color: #E7CEA6;
    /* font-size: 8px;
        font-weight: 100 !important; */

  }

  .table-hover tbody tr:hover td,
  .table-hover tbody tr:hover th {
    background-color: #F3FEB8 !important;
  }

  label,
  input,
  textarea,
  span,
  select,
  button,
  .select2-selection,
  .select2-results__option {
    font-size: 12px !important;
  }

  table td,
  table th {
    font-size: 12px;
  }
</style>
<div id="main">
  <header class="mb-3">
    <a href="#" class="burger-btn d-block d-xl-none">
      <i class="bi bi-justify fs-3"></i>
    </a>
  </header>
  <!-- Content Header (Page header) -->
  <div id="formhider" class="col-md-12 col-12">
    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <div class="row col-md-12">
          <div class="col-md-1">
            <button id="kembali" type="button" class="btn btn-lg text-start"><i class="fa-solid fa-chevron-left"></i></button>
          </div>
          <div class="col-md-11">
            <h5 class="text-center">Edit Data</h5>
          </div>
        </div>

      </div>
      <div class="card-body">
        <div class=" row col-md-12">
          <div class="col-md-6">
            <div class="row mb-12 mb-2">
              <label for="transnoHider" style="width: 20%;" class="col-sm-2 col-form-label">Transno</label>
              <div class="col-sm-6">
                <input disabled type="text" value="<?= $datapost["No_Pls"] ?>" id="transnoHider" class="form-control">
              </div>
            </div>
            <div class="row mb-12 mb-2">
              <label for="suplair" style="width:20%;" class="col-sm-2 col-form-label">Supplier</label>
              <div class=" col-sm-9">
                <select disabled class="form-control" id="suplair">
                  <option value="" disabled selected>Please Select</option>
                  <?php foreach ($supplier as $file):
                    $kode = $file['CustomerID'];
                    $nama = $file['CustName'];
                  ?>
                    <option value="<?= $kode ?>"><?= $nama ?></option>
                  <?php endforeach; ?>
                </select>
                <span id="customerError" class="error"></span>
              </div>
            </div>
            <div id="selectpo" class="row mb-12 mb-2">
              <label for="nopo" style="width:20%;" class="col-sm-2 col-form-label">NO PO</label>
              <div class=" col-sm-6">
                <select disabled class="form-control" id="nopo">

                </select>
                <span id="nopoError" class="error"></span>
              </div>
            </div>
            <div class="row mb-12 mb-2">
              <label for="note" style="width:20%;" class="col-sm-3 col-form-label">note</label>
              <div class="col-sm-6">
                <textarea type="text" disabled style="width:150%; height:80px;" id="note" value=" <?= $datapost["Note2"] ?>" class="form-control"> <?= $datapost["Note2"] ?></textarea>
                <span id="noteError" class="error"></span>
              </div>
            </div>

            <div class="row mb-12 mb-2" style="display: none;">
              <label for="idpackinglist" style="width: 20%;" class="col-sm-2 col-form-label">ID PIB</label>
              <div class="col-sm-6">
                <input type="text" value="<?= $datapost["No_Pli"] ?>" id="idpackinglist" class="form-control">
              </div>
            </div>



            <div class="row mb-12 mb-2" style="display: none;">
              <label for="id_bl_awb" style="width: 20%;" class="col-sm-2 col-form-label">BL/AWB</label>
              <div class="col-sm-6">
                <input type="text" id="id_bl_awb" value="<?= $datapost["id_bl_awb"] ?>" class="form-control">
              </div>
            </div>

          </div>
          <div class="col-md-6">
            <div class="row mb-12 mb-2">
              <label for="tanggal" style="width: 20%;" class="col-sm-2 col-form-label">Tanggal</label>
              <div style="width:35%;" class="col-sm-6">
                <input type="date" id="tanggal" class="form-control">
              </div>
            </div>
            <div class="row mb-12 mb-2">
              <label for="keterangan" style="width:20%;" class="col-sm-3 col-form-label">Keterangan</label>
              <div class="col-sm-6">
                <textarea type="text" value="<?= $datapost["Note"] ?>"
                  style="width:150%; height:80px;" id="keterangan" class="form-control"> <?= $datapost["Note"] ?></textarea>
                <span id="keteranganError" class="error"></span>
              </div>
            </div>
            <!-- <div class="row mb-12 mb-2" >
                                        <label for="pib" style="width: 20%;" class="col-sm-2 col-form-label">PIB</label>
                                        <div  style="width:35%;"  class="col-sm-6">
                                          <input value="<?= $datapost["Pib"] ?>" type="text" id="pib" class="form-control text-end">
                                        </div>
                                    </div> -->
            <div class="row mb-12 mb-2">
              <label for="forwarder" style="width: 20%;" class="col-sm-2 col-form-label">Forwarder</label>
              <div style="width:40%;" class="col-sm-6">
                <div class="input-group">
                  <input type="text" disabled id="forwarder" value="<?= $datapost["Forwarder"] ?>" class="form-control text-end">
                  <button class="btn btn-success" id="detailforwader_edit">+</button>
                </div>
                <span id="forwarderError" class="error"></span>
              </div>

            </div>
            <!-- <div class="row mb-12 mb-2">
              <label for="total" style="width: 20%;" class="col-sm-2 col-form-label">Total</label>
              <div style="width:35%;" class="col-sm-6">
                <span type="text" id="total" style="display: flex;justify-content: flex-end"><?= $datapost["Total"] . "&nbsp;&nbsp;&nbsp;" ?></span>
              </div>
            </div> -->

          </div>
        </div>
        <div id="divproses"></div>
        <div id="itemTabel"></div>
      </div>
    </div>
  </div>



</div>
</div>


<!-- /.content-wrapper -->

<script type="module" src="<?= base_url; ?>/assets/js/componets/classkur/index.js"></script>


<script>
  $(document).ready(function() {
    const userid = "<?= trim($userid) ?>";


    setPostdata();
    $('#pib').on('keyup', function() {
      var inputVal = $(this).val(); // Menghapus karakter selain angka dan koma
      var formattedVal = formatRupiah(inputVal);
      $(this).val(formattedVal);
    });
    $('#forwarder').on('keyup', function() {
      let pib = $("#pib").val();
      if (pib !== '') {
        var inputVal = $(this).val(); // Menghapus karakter selain angka dan koma
        var formattedVal = formatRupiah(inputVal);
        $(this).val(formattedVal);
        $("#forwarderError").text("");

      } else {
        $("#forwarderError").text("pbi harus di isi dulu");

      }
    });

    $("#pib").on("change", function() {
      let forward = $("#forwarder").val();
      if (forward !== '') {
        let pib = $(this).val();
        settotal(pib, forward);
        $("#forwarderError").text("");
      }
    })

    $("#forwarder").on("change", function() {
      let pib = $("#pib").val();
      if (pib !== '') {
        let forward = $(this).val();
        settotal(pib, forward);
        $("#forwarderError").text("");
      } else {
        $("#forwarderError").text("pbi harus di isi dulu");
      }
    })
  });
  // and document ready
  function settotal(pib, forward) {

    let c = formatjm(pib) + formatjm(forward);
    let decimal = total.toString().includes('.') ? 2 : 0;
    let d = formatRupiah(c.toFixed(decimal).toString());
    $("#total").html(d + "&nbsp;&nbsp;&nbsp;");
  }

  function formatjm(angka) {
    return parseFloat(angka.replace(/[^0-9.]/g, ''));
  }

  function formatRupiah(angka, prefix) {
    let number_string = angka.replace(/[^0-9.]/g, '').toString();
    let split = number_string.split('.');
    //Batas angka desimal hanya dua digit
    if (split[1]) {
      split[1] = split[1].substring(0, 2);
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

  function setPostdata() {
    let suppid = "<?= $datapost["supid"] ?>";
    let donumber = "<?= $datapost["NoPo"] ?>";
    let tanggal = "<?= $datapost["EntryDate"] ?>";
    $("#suplair").val(suppid);
    const datas = {
      "suplairid": suppid,
      "donumber": donumber
    };

    getTampilPO(datas);
    SetTanggal(tanggal)



  }

  function SetTanggal(tanggal) {
    flatpickr("#tanggal", {
      dateFormat: "d/m/Y", // Format yang diinginkan
      allowInput: true, // Memungkinkan input manual
      defaultDate: new Date(tanggal)
    });

  }




  function getTampilPO(datas) {

    $.ajax({
      url: "<?= base_url ?>/transaksi/tampilpobysupedit",
      method: "POST",
      dataType: "json",
      data: datas,

      success: function(result) {
        $("#nopo").empty();

        $.each(result, function(a, b) {

          const DONumber = b.DONumber;
          const DOTransacID = b.DOTransacID;
          $("#nopo").append('<option value="' + DOTransacID + '">' + DONumber + '</option>');

        })

      }
    });


  }









  function getrupiahdetail(str_idctns, str_idgtns, str_idkgs, str_idcbm) {
    //str_idctns
    let data_idctns = str_idctns.split(",");
    $.each(data_idctns, function(index, value) {
      let id_ctns = "#" + value;
      $(id_ctns).on('keyup', function() {
        let inputid_ctns = $(this).val(); // Menghapus karakter selain angka dan koma
        let formattedVal = formatRupiah(inputid_ctns);
        $(this).val(formattedVal);
      })

    });
    //and
    // data_idgtns
    let data_idgtns = str_idgtns.split(",");
    $.each(data_idgtns, function(index1, value1) {
      let id_idgtns = "#" + value1;
      $(id_idgtns).on('keyup', function() {
        let inputid_idgtns = $(this).val(); // Menghapus karakter selain angka dan koma
        let formattedVal1 = formatRupiah(inputid_idgtns);
        $(this).val(formattedVal1);
      })

    });
    //and
    //and str_idkgs
    let data_idkgs = str_idkgs.split(",");
    $.each(data_idkgs, function(index2, value2) {
      let id_idkgs = "#" + value2;
      $(id_idkgs).on('keyup', function() {
        let inputid_id_idkgs = $(this).val(); // Menghapus karakter selain angka dan koma
        let formattedVal2 = formatRupiah(inputid_id_idkgs);
        $(this).val(formattedVal2);
      })

    });
    //and
    //and str_idcbm
    let data_idcbm = str_idcbm.split(",");
    $.each(data_idcbm, function(index3, value3) {
      let str_split = value3.split("|");

      let id_cbm = "#" + value3;
      $(id_cbm).on('keyup', function() {
        let inputid_cbm = $(this).val(); // Menghapus karakter selain angka dan koma
        let formattedVal3 = formatRupiah(inputid_cbm);
        $(this).val(formattedVal3);

      })

    });
    //and
  }


  setkomposisi = (inputid_cbm, totalcbm) => {
    let total_CBM = totalcbm;
    let hasil = "";
    if (inputid_cbm !== "" && total_CBM !== "") {


      let t_cbm = total_CBM.replace(/\,/g, "");
      let b = parseFloat(t_cbm);

      let input_rep = inputid_cbm.replace(/\,/g, "");
      let a = parseFloat(input_rep)

      let rumus = (a / b) * 100;

      hasil = rumus;

    } else {
      hasil = 0;
    }
    return hasil;

  }

  function calculateTotal(data) {
    let total = 0;
    let id = "." + data;
    $(id).each(function() {
      let di_value = $(this).val();
      total += formatjm(di_value) || 0; // Mengambil nilai input, jika kosong dianggap 0
    });
    let tt = total.toFixed(2).toString();
    let tst = formatRupiah(tt);
    let id_tt = "#total_" + data;
    $(id_tt).text(tst);
  }
</script>