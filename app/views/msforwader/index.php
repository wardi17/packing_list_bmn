
<?php

$userlog = (isset( $_SESSION['login_user']))?  $_SESSION['login_user'] : '';
?>

<style>
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
</style>
<div id="main">
       <header class="mb-3">
       <input type="hidden" id="usernama" class="form-control" value="<?=$userlog?>">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
    <!-- Content Header (Page header) -->
    <div class ="col-md-12 col-12">
            <!-- Default box -->
            <div class="card" style="width:50%;">
              <div class="card-header">
              <h5 class="text-center">Master Forwader </h5>
              </div>
              <div class="card-body" >
                   <!-- Button trigger modal -->
                 <div class="col-md-12 text-end mb-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahdata">
                    Tambah
                    </button>
                 </div>
                 <div id="list"></div>
              </div>
              </div>
              </div>
              <!-- /.card-body -->
                
             
            </div>
      </div>

    <script type="module" src="<?= base_url; ?>/assets/js/componets/classmsforwader/index.js"></script>