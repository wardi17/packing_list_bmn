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
            <button id="kembalipostidfinal" type="button" class="btn btn-lg text-start"><i class="fa-solid fa-chevron-left"></i></button>
          </div>
          <div class="col-md-11">
            <h5 class="text-center">Detail Data Final</h5>
          </div>
        </div>

      </div>
      <div class="card-body">
        <div class=" row col-md-12">
          <div class="col-md-6">
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

            <div class="row mb-12 mb-2" style="display: none;">
              <label for="idpackinglist" style="width: 20%;" class="col-sm-2 col-form-label">ID PIB</label>
              <div class="col-sm-6">
                <input disabled type="text" value="<?= $datapost["No_Pli"] ?>" id="idpackinglist" class="form-control">
              </div>
            </div>

            <div class="row mb-12 mb-2">
              <label for="transnoHider" style="width: 20%;" class="col-sm-2 col-form-label">Transno</label>
              <div class="col-sm-6">
                <input disabled type="text" value="<?= $datapost["No_Pls"] ?>" id="transnoHider" class="form-control">
              </div>
            </div>

            <div class="row mb-12 mb-2" style="display: none;">
              <label for="id_bl_awb" style="width: 20%;" class="col-sm-2 col-form-label">BL/AWB</label>
              <div class="col-sm-6">
                <input type="text" disabled id="id_bl_awb" value="<?= $datapost["id_bl_awb"] ?>" class="form-control">
              </div>
            </div>

          </div>
          <div class="col-md-6">
            <div class="row mb-12 mb-2">
              <label for="tanggal" style="width: 20%;" class="col-sm-2 col-form-label">Tanggal</label>
              <div style="width:35%;" class="col-sm-6">
                <input disabled type="date" id="tanggal" class="form-control">
              </div>
            </div>
            <div class="row mb-12 mb-2">
              <label for="keterangan" style="width:20%;" class="col-sm-3 col-form-label">Keterangan</label>
              <div class="col-sm-6">
                <textarea disabled type="text" value="<?= $datapost["Note"] ?>"
                  style="width:150%; height:80px;" id="keterangan" class="form-control"> <?= $datapost["Note"] ?></textarea>
                <span id="keteranganError" class="error"></span>
              </div>
            </div>
            <div class="row mb-12 mb-2">
              <label for="pib" style="width: 20%;" class="col-sm-2 col-form-label">PIB</label>
              <div style="width:35%;" class="col-sm-6">
                <input disabled value="<?= $datapost["Pib"] ?>" type="text" id="pib" class="form-control text-end">
              </div>
            </div>
            <div class="row mb-12 mb-2">
              <label for="forwarder" style="width: 20%;" class="col-sm-2 col-form-label">Forwarder</label>
              <div style="width:40%;" class="col-sm-6">
                <div class="input-group">
                  <input type="text" disabled value="<?= $datapost["Forwarder"] ?>" id="forwarder" class="form-control text-end">
                  <button class="btn btn-success" id="detailforwader_posting">+</button>
                </div>
                <span id="forwarderError" class="error"></span>
              </div>
            </div>
            <div class="row mb-12 mb-2">
              <label for="total" style="width: 20%;" class="col-sm-2 col-form-label">Total</label>
              <div style="width:35%;" class="col-sm-6">
                <span disabled type="text" id="total" style="display: flex;justify-content: flex-end"><?= $datapost["Total"] . "&nbsp;&nbsp;&nbsp;" ?></span>
              </div>
            </div>

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


<script type="module" src="<?= base_url; ?>/assets/js/componets/classkurfinal/index.js"></script>

<script>
  $(document).ready(function() {
    const userid = "<?= trim($userid) ?>";

    setPostdata();

  });
  // and document ready
  function settotal(pib, forward) {
    let a = pib.replace(/\./g, "");
    let b = forward.replace(/\./g, "");

    let c = parseFloat(a) + parseFloat(b);
    let d = formatRupiah(c.toString());
    $("#total").html(d + "&nbsp;&nbsp;&nbsp;");
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
    SetTanggal(tanggal);


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

  function formatjm(angka) {
    return parseFloat(angka.replace(/[^0-9.]/g, ''));
  }


  function SetdataHider(datahead) {
    let SoTransacID = "";
    let SOEntryDesc = "";
    let Shipdate = "";
    $.each(datahead, function(key, value) {
      SoTransacID = value.SoTransacID;
      SOEntryDesc = value.SOEntryDesc;
      Shipdate = value.Shipdate;
    });


    $("#tanggal").val(Shipdate);
    $("#transnoHider").val(SoTransacID);
    $("#keterangan").val(SOEntryDesc);
  }




  function SetdataDetail(datadetail) {
    setData(datadetail);


  }
</script>