<?php
$userlog = (isset($_SESSION['login_user'])) ?  $_SESSION['login_user'] : '';
?>
<style>
  #thead {
    background-color: #E7CEA6 !important;
  }

  .table-hover tbody tr:hover td,
  .table-hover tbody tr:hover th {
    background-color: #F3FEB8;
  }

  .dataTables_filter {
    padding-bottom: 20px !important;
  }

  #frompacking {
    width: 100%;
    height: 2% !important;
    margin: 0 auto;
  }
</style>

<div id="main">
  <header class="mb-3">
    <input type="hidden" id="usernama" class="form-control" value="<?= $userlog ?>">
    <a href="#" class="burger-btn d-block d-xl-none">
      <i class="bi bi-justify fs-3"></i>
    </a>
  </header>

  <div class="col-md-12 col-12">
    <div class="card">
      <div class="card-header">
        <h5 class="text-center">POSTED FINAL</h5>
      </div>
      <div class="card-body">
        <div class="row col-md-12 col-12">
          <div class="col-md-8">
            <form id="form_filter">
              <div class="row col-md-8">
                <div style="width:25%;" class="col-md-2">
                  <select class="form-control" id="filter_tahun"></select>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div id="tabellist" class="table-responsive"></div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    const dateya = new Date();
    let tahundefault = dateya.getFullYear();
    const userid = "<?= trim($userlog) ?>";

    get_tahun();
    $("#filter_tahun").val(tahundefault);

    const datas = {
      "userid": userid,
      "tahun": tahundefault
    };
    get_Data(datas);

    $(document).on("change", "#filter_tahun", function() {
      const tahun = $(this).val();
      const useridx = $("#usernama").val();
      const datas = {
        "userid": useridx,
        "tahun": tahun
      };
      get_Data(datas);
    });
  });

  function get_tahun() {
    let startyear = 2020;
    let date = new Date().getFullYear();
    let endyear = date + 2;

    for (let i = startyear; i <= endyear; i++) {
      let selected = (i === date) ? 'selected' : '';
      $("#filter_tahun").append($(`<option />`).val(i).html(i).prop('selected', selected));
    }
  }

  function get_Data(datas) {
    $.ajax({
      url: "<?= base_url ?>/transaksifinalkurs/listsudahposting",
      data: datas,
      method: "POST",
      dataType: "json",
      success: function(result) {
        Set_Tabel(result);
      }
    });
  }

  function Set_Tabel(result) {
    let datatabel = `
      <table id="tabel1" class='table table-striped table-hover' style='width:100%'>
        <thead id='thead' class='thead'>
          <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Supplier</th>
            <th>NoPo</th>
            <th>Ket</th>
            <th class="text-end">Amount</th>
            <th>User Input</th>
            <th>User Post</th>
            <th>Tgl Post</th>
            <th>View</th>
          </tr>
        </thead>
        <tbody>`;

    let no = 1;
    $.each(result, function(a, b) {
      let ket = rep_kutif(b.Note);
      let EntryDate = moment(b.EntryDate).format("YYYY-MM-DD");
      let tanggal = tgl_set(b.EntryDate);

      datatabel += `
        <tr>
          <td>${no++}</td>
          <td style="width:10%">${tanggal}<sup class='text-info'>${b.Totaldetail}</sup></td>
          <td>${b.supid}</td>
          <td>${b.NoPo}</td>
          <td>${ket}</td>
          <td class="text-end">${b.Total}</td>
          <td>${b.userid}</td>
          <td>${b.UserPosting}</td>
          <td>${tgl_set(b.DatePosting)}</td>
          <td>
            <form id="frompacking" action="<?= base_url; ?>/transaksifinalkurs/details" method="POST">
              <input type="hidden" name="NoPo" value="${b.NoPo}">
              <input type="hidden" name="id_bl_awb" value="${b.id_bl_awb}">
              <input type="hidden" name="supid" value="${b.supid}">
              <input type="hidden" name="No_Pli" value="${b.No_Pli}">
              <input type="hidden" name="No_Pls" value="${b.No_Pls}">
              <input type="hidden" name="EntryDate" value="${EntryDate}">
              <input type="hidden" name="Note" value="${b.Note}">
              <input type="hidden" name="POTransacid" value="${b.POTransacid}">
              <input type="hidden" name="Pib" value="${b.Pib}">
              <input type="hidden" name="Forwarder" value="${b.Forwarder}">
              <input type="hidden" name="Total" value="${b.Total}">
              <button type="submit" class="btn btn-info" title="Details"><i class="fa-solid fa-eye"></i></button>
            </form>
          </td>
        </tr>`;
    });

    datatabel += `</tbody></table>`;
    $("#tabellist").html(datatabel);
    Tampildatatabel();
  }

  function tgl_set(settanggal) {
    let formatTanggal = moment(settanggal).format("DD-MM-YYYY");
    let waktu = moment(settanggal).format("HH:mm:ss");
    let split = formatTanggal.split("-");
    let tgl = split[0],
      bln = split[1],
      thn = split[2],
      th = thn.substr(2, 2);
    return `${tgl}-${bln}-${th} ${waktu}`;
  }

  function rep_kutif(data) {
    return data.replace(/&amp;apos;/g, "'").replace(/&amp;quot;/g, '"');
  }

  function Tampildatatabel() {
    $("#tabel1").DataTable({
      order: [
        [0, 'asc']
      ],
      responsive: true,
      ordering: true,
      destroy: true,
      pageLength: 5,
      lengthMenu: [
        [5, 10, 20, -1],
        [5, 10, 20, 'All']
      ],
      fixedColumns: {
        right: 1
      },
    });
  }
</script>