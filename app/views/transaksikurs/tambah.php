<body>
  <?php
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
              <h5 class="text-center">Tambah Data</h5>
            </div>
          </div>

        </div>
        <div class="card-body">
          <!-- <button class="btn btn-primary" id="testtable">testtable</button> -->
          <div class=" row col-md-12">
            <div class="col-md-6">
              <div class="row mb-12 mb-2">
                <label for="transnoHider" style="width: 20%;" class="col-sm-2 col-form-label">Transno</label>
                <div class="col-sm-6">
                  <input disabled type="text" id="transnoHider" class="form-control">
                </div>
              </div>
              <div class="row mb-12 mb-2">
                <label for="suplair" style="width:20%;" class="col-sm-2 col-form-label">Supplier</label>
                <div class=" col-sm-9">
                  <select class="form-control" id="suplair">
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
                  <select class="form-control" id="nopo">

                  </select>
                  <span id="nopoError" class="error"></span>
                </div>
              </div>

              <div class="row mb-12 mb-2">
                <label for="note" style="width:20%;" class="col-sm-3 col-form-label">note</label>
                <div class="col-sm-6">
                  <textarea type="text" disabled style="width:150%; height:80px;" id="note" class="form-control"></textarea>
                  <span id="noteError" class="error"></span>
                </div>
              </div>
              <div class="row mb-12 mb-2" style="display: none;">
                <label for="idpackinglist" style="width: 20%;" class="col-sm-2 col-form-label">ID PIB</label>
                <div class="col-sm-6">
                  <input type="text" id="idpackinglist" class="form-control">
                </div>
              </div>

              <div class="row mb-12 mb-2" style="display: none;">
                <label for="id_bl_awb" style="width: 20%;" class="col-sm-2 col-form-label">BL/AWB</label>
                <div class="col-sm-6">
                  <input type="text" id="id_bl_awb" class="form-control">
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
                  <textarea type="text" style="width:150%; height:80px;" id="keterangan" class="form-control"></textarea>
                  <span id="keteranganError" class="error"></span>
                </div>
              </div>
              <!-- <div class="row mb-12 mb-2">
                                        <label for="pib" style="width: 20%;" class="col-sm-2 col-form-label">PIB</label>
                                        <div  style="width:35%;"  class="col-sm-6">
                                          <input  type="text" id="pib" value="0" class="form-control text-end">
                                        </div>
                                    </div> -->

              <div class="row mb-12 mb-2">
                <label for="forwarder" style="width: 20%;" class="col-sm-2 col-form-label">Forwarder</label>
                <div style="width:40%;" class="col-sm-6">
                  <div class="input-group">
                    <input type="text" disabled id="forwarder" class="form-control text-end">
                    <button class="btn btn-success" id="detailforwader">+</button>
                  </div>
                  <span id="forwarderError" class="error"></span>
                </div>

              </div>
              <div id="listkategori"></div>
              <!-- <div class=" row mb-12 mb-2">
                <label for="total" style="width: 20%;" class="col-sm-2 col-form-label">Total</label>
                <div style="width:35%;" class="col-sm-6">
                  <span type="text" id="total" style="display: flex;justify-content: flex-end"></span>
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
        let pib = $("#pib").val();
        if (pib !== '') {
          let inputVal = $(this).val(); // Menghapus karakter selain angka dan koma
          let formattedVal = formatRupiah(inputVal);
          $(this).val(formattedVal);
          $("#forwarderError").text("");

        } else {
          $("#forwarderError").text("pbi harus di isi dulu");

        }
      });

      $("#suplair").on("change", function() {
        const suplairid = $(this).val();
        const datas = {
          "suplairid": suplairid
        };
        getTampilPO(datas);
      });

      $("#nopo").on("change", function(event) {
        event.preventDefault();
        const nopo = $(this).val();
        getTampilNote(nopo)

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

      $("#pib").on("change", function() {
        let pib = $("#forwarder").val();
        if (pib !== '') {
          let forward = $(this).val();
          settotal(pib, forward);
          $("#forwarderError").text("");
        }

      })



    });
    // and document ready


    function getTampilNote(nopo) {
      const datas = {
        "nopo": nopo
      };
      $.ajax({
        url: "<?= base_url ?>/transaksi/tampilnotepobyid",
        method: "POST",
        dataType: "json",
        data: datas,

        success: function(result) {

          $("#note").val(result);
        }

      })
    }

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

      // Menghapus karakter yang bukan angka dan titik
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









    function SetTanggal() {
      flatpickr("#tanggal", {
        dateFormat: "d/m/Y", // Format yang diinginkan
        allowInput: true, // Memungkinkan input manual
        defaultDate: new Date()
      });

    }

    function TglSekarang() {
      var d = new Date();
      var month = d.getMonth() + 1;
      var day = d.getDate();
      let output = d.getFullYear() + '-' +
        (month < 10 ? '0' : '') + month + '-' +
        (day < 10 ? '0' : '') + day;
      return output;
    }

    function getTampilPO(datas) {

      $.ajax({
        url: "<?= base_url ?>/transaksi/tampilpobysup",
        method: "POST",
        dataType: "json",
        data: datas,

        success: function(result) {
          $("#nopo").empty();
          $("#nopo").append('<option value="" disabled selected>Please Select</option>');
          $.each(result, function(a, b) {
            const DONumber = b.DONumber;
            const DOTransacID = b.DOTransacID;
            $("#nopo").append('<option value="' + DOTransacID + '">' + DONumber + '</option>');

          })

        }
      });


    }

    function getTampilDetailPO(datas) {
      $.ajax({
        url: "<?= base_url ?>/transaksi/tampildetailpo",
        method: "POST",
        dataType: "json",
        data: datas,
        success: function(result) {
          getListItem();
          setData(result);
        }

      })
    }







    function rep_kutif(data) {

      return data.replace(/'/g, 'kut1;').replace(/"/g, 'kut2;');
    }




    function SetTransno() {

      var currentDate = new Date();
      // Format the date using moment.js
      var formattedDate = moment(currentDate).format("YYYY-MM-DD HH:mm:ss");

      let split = formattedDate.split("-");
      let thn = split[0].substr(2, 2);
      let bln = split[1];
      let tgl = split[2];
      let rep_tgl = tgl.replace(" ", "");
      let rep_tgl2 = rep_tgl.replace(":", "");
      let rep_tgl3 = rep_tgl2.replace(":", "");

      let id_trns = "BMI_PL" + thn + bln + rep_tgl3;


      $("#transnoHider").val(id_trns);


    }
  </script>