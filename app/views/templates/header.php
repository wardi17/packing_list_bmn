<html>

<head id="headerNo">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biaya Import</title>

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="<?= base_url; ?>/assets/fontawesome/css/all.min.css"> <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url; ?>/assets/css/shared/iconly.css"> <!-- Iconly -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="<?= base_url; ?>/assets/css/main/app.css">
    <link rel="stylesheet" href="<?= base_url; ?>/assets/css/grafik.css">
    <link href="<?= base_url; ?>/assets/css/datatables.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url; ?>/assets/css/jquery-ui.css">
    <link rel="stylesheet" href="<?= base_url; ?>/assets/css/pages/summernote.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.bootstrap4.min.css" />

    <!-- JS Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    <script src="<?= base_url; ?>/assets/js/jquery.min.js"></script>
    <script src="<?= base_url; ?>/assets/js/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= base_url; ?>/assets/js/jquery-ui.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.1.4/dist/js/datepicker-full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url; ?>/assets/js/jquery.table2excel.js"></script>
    <script src="<?= base_url; ?>/assets/js/csvExport.js"></script>
    <script src="<?= base_url; ?>/assets/js/jquery.PrintArea.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <style>
        option {
            font-family: Helvetica !important;
            line-height: 1.0 !important;
        }

        .right-aligned-input {
            text-align: right;
        }

        #attach {
            opacity: 0;
        }
    </style>

    <script>
        window.BASE_URL = "<?= base_url ?>";
    </script>

</head>