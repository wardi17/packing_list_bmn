<?php

class FPDF_AutoWrapTable extends FPDF {
    private $data = array();
    private $options = array();

    function __construct($data = array(), $options = array()) {
        parent::__construct(
            $options['orientation'], 
            'mm', 
            $options['paper_size']
        );

        $this->data = $data;
        $this->options = $options;
    }

    public function rptDetailData() {
        date_default_timezone_set('Asia/Jakarta');

        $header = $this->data["dataheader"];
        $detail = $this->data["datadetail"];
        $border = 0;
        $this->AddPage();
        $this->SetAutoPageBreak(true, 60);
        $this->AliasNbPages();
        $left = 25;

        // Header
        $ID_Hider     = $header['ID_Hider'];
        $No_Pli       = $header['No_Pli'];
        $NoPO         = $header['NoPO'];
        $EntryDate    = date('d-m-y', strtotime($header['EntryDate']));
        $Note         = $header['Note'];
        $supid        = $header['supid'];
        $Pib          = $header['Pib'];
        $Forwarder    = $header['Forwarder'];
        $Total        = $header['Total'];
        $CustAddres   = $header["CustAddres"];
        $CustTelpNo   = $header["CustTelpNo"];
        $CustFaxNo    = $header["CustFaxNo"];
        $CustEmail     = $header["CustEmail"];
        $SupperiName  = $header["SupperiName"];
        $id_bl_awb    = $header["id_bl_awb"];

        // Setting font
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(180, 5, $SupperiName, 0, 1, 'C');
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(180, 5, $CustAddres, 0, 1, 'C');
        $this->Cell(28, 5, '', 0, 0);
        $this->Cell(35, 5, "Tel:" . $CustTelpNo, 0, 0);
        $this->Cell(10, 5, '', 0, 0);
        $this->Cell(35, 5, "FAX:" . $CustFaxNo, 0, 0);
        $this->Cell(10, 5, '', 0, 0);
        $this->Cell(36, 5, "Email:" . $CustEmail, 0, 1);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(2, 5, '', 0, 0);
        $this->Cell(190, 1, "_______________________________________________________________________", 0, 0, 'C');
        $this->Cell(2, 5, '', 0, 1);

        // Packing List Title
        $this->SetFont('Arial', 'BI', 14);
        $this->Cell(180, 10, 'PACKING LIST', 0, 1, 'C');

        // Buyer Information
        $this->SetFont('Arial', 'B', 8);
        $y = $this->GetY();
        $x = $this->GetX();
        $width = 21;
        $this->MultiCell($width, 5, 'THE BUYER :', 0, 'L', FALSE);
        $this->SetXY($x + $width, $y);
        $this->MultiCell(2, 5, '', 0, 'L', FALSE);
        $this->SetXY($x + $width + 2, $y);
        $this->MultiCell(100, 5, 'PT BEST MEGA INDUSTRI  JL. RAYA BOGOR KM.38. NO.77 SUKAMAJU CILODONG DEPOK, JAWABARAT 16415, INDONESIA', 0, 'L', FALSE);
        $this->SetXY($x + 125 + 2, $y);
        $this->MultiCell(15, 5, 'NO PO  TGL PO  NO PL', 0, 'L', FALSE);
        $this->SetXY($x + 140 + 2, $y);
        $this->MultiCell(3, 5, ': : :', 0, 'L', FALSE);
        $this->SetXY($x + 143 + 2, $y);
        $this->MultiCell(25, 5, $NoPO . "\n" . $EntryDate . "\n" . $No_Pli, 0, 'L', FALSE);
        
        $this->Cell(0, 2, '', 0, 1, 'C');
        $this->MultiCell($width + 80, 5, 'BL/AWB       :        ' . $id_bl_awb, 0, 'L', FALSE);
        
        // Additional content can be added here...
    }

    protected function getformatnumerqty($data) {
        return number_format($data, 0, ",", ",");
    }

    protected function getformatnumer($data) {
        return number_format($data, 2, ".", ",");
    }

    protected function getformatnumer_kom($data) {
        return number_format($data, 2, ".", ".");
    }

    public function printPDF() {
        // Call the parent constructor with the correct parameters
        parent::__construct($this->options['orientation'], 'mm', $this->options['paper_size']);

        $this->SetAutoPageBreak(true, 30);
        $this->AliasNbPages();
        $this->SetFont("Arial", "B", 10);

        $this->rptDetailData();
        $this->Output($this->options['filename'], $this->options['destinationfile']);
    }

    // Other methods remain unchanged...
}


// Options for PDF generation
$options = array(
    'filename' => 'laporan_pakinglist.pdf',
    'destinationfile' => 'I', // I = inline (browser)
    'paper_size' => 'A4',
    'orientation' => 'L'      // L = landscape
);

// Sample data (replace with actual data)
$data = array(
    "dataheader" => array(
        "ID_Hider" => "1",
        "No_Pli" => "12345",
        "NoPO" => "PO123",
        "EntryDate" => "2023-10-01",
        "Note" => "Sample Note",
        "supid" => "Supplier ID",
        "Pib" => "100000",
        "Forwarder" => "Forwarder Name",
        "Total" => "200000",
        "CustAddres" => "Customer Address",
        "CustTelpNo" => "123456789",
        "CustFaxNo" => "987654321",
        "CustEmail" => "customer@example.com",
        "SupperiName" => "Supplier Name",
        "id_bl_awb" => "AWB123"
    ),
    "datadetail" => array() // Add detail data here
);

$tabel = new FPDF_AutoWrapTable($data, $options);
$tabel->printPDF();
?>
