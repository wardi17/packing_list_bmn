<?php

class FPDF_AutoWrapTable extends FPDF
{
    private $data = array();
    private $status;
    private $options = array();
    public $widths;
    public $aligns;

    function __construct($data = array(), $options = array())
    {
        parent::__construct(
            $options['orientation'],
            'mm',
            $options['paper_size']
        );

        $this->data = $data["datas"];
        $this->status = $data["status"];
        $this->options = $options;
    }

    public function rptDetailData()
    {
        date_default_timezone_set('Asia/Jakarta');

        $header = $this->data["dataheader"];
        $detail = $this->data["datadetail"];
        $this->AddPage();
        $this->SetAutoPageBreak(true, 60);
        $this->AliasNbPages();

        // die(var_dump($header));
        // Extract header information
        $ID_Hider     = $header['ID_Hider'];
        $No_Pli       = $header['No_Pli'];
        $NoPO         = $header['NoPO'];
        $EntryDate    = date('d M y', strtotime($header['EntryDate']));
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
        $total_qty    = $header["total_qty"];
        $total_Price  = $header["total_Price"];
        $total_USD    = $header["total_USD"];
        $total_Kurs   = $header["total_Kurs"];
        $total_Rp     = $header["total_Rp"];
        $total_KursAkhir = $header["total_KursAkhir"];
        $total_RpAkhir   = $header["total_RpAkhir"];
        $total_Prosentase = $header["total_Prosentase"];
        $currid           = $header["currid"];
        $kurslanded       = $header["kurslanded"];
        $total_usd_only   = $header["total_usd_only"];
        $total_idr_only    = $header["total_idr_only"];

        $this->ln(0);
        // Set font for the document
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 5, $SupperiName, 0, 1, 'C');
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(0, 5, $CustAddres, 0, 1, 'C');
        $this->Cell(72, 5, '', 0, 0);
        $this->Cell(35, 5, "Tel: " . $CustTelpNo, 0, 0, 'C');
        $this->Cell(10, 5, '', 0, 0);
        $this->Cell(35, 5, "FAX: " . $CustFaxNo, 0, 0, 'C');
        $this->Cell(10, 5, '', 0, 0);
        $this->Cell(36, 5, "Email: " . $CustEmail, 0, 1, 'C');

        // Separator line
        $this->Cell(0, 1, str_repeat("_", 260), 0, 1, 'C');

        // Packing List Title
        $this->SetFont('Arial', 'BI', 14);
        $this->Cell(0, 10, 'HPP LANDED', 0, 1, 'C');

        // Buyer Information
        $this->SetFont('Arial', 'B', 8);
        $y = $this->GetY();
        $x = $this->GetX();
        $width = 10;
        $this->SetAutoPageBreak(true, 30);
        // Buyer details
        $this->MultiCell($width + 10, 5, 'THE BUYER ', 0, 'L', FALSE);
        $this->SetXY($x + $width + 10, $y);
        $this->MultiCell(3, 5, ':', 0, 'L', FALSE);
        $this->SetXY($x + $width + 13, $y);
        $this->MultiCell(80, 5, 'PT BEST MEGA INDUSTRI Jl. Raya Bogor KM.38 No.77 Sukamaju Cilodong Depok, Jabar 16415, Indonesia', 0, 'L', FALSE);
        $this->SetXY($x + 230, $y);
        $this->MultiCell(15, 5, 'NO PO  TGL PO ', 0, 'L', FALSE);
        $this->SetXY($x + 245, $y);
        $this->MultiCell(3, 5, ': : ', 0, 'L', FALSE);
        $this->SetXY($x + 248, $y);
        $this->MultiCell(25, 5, $NoPO . "\n" . $EntryDate, 0, 'L', FALSE);

        // Adding BL/AWB
        // $this->Cell(0, 2, '', 0, 1, 'C');
        //$this->MultiCell($width + 80, 5, 'BL/AWB: ' . $id_bl_awb, 0, 'L', FALSE);

        // Data table header
        $this->Cell(0, 2, '', 0, 1, 'C');
        $this->SetFillColor(220, 220, 200);
        $this->ln(0);
        $this->SetFont('Arial', 'B', 7);
        $this->SetX(10);
        //untuk headr atas

        $this->Cell(106, 5, $this->status, 0, 0, 'L');
        $this->Cell(36, 5, 'PO (' . $currid . ')', 1, 0, 'C');
        $this->Cell(18, 5, '', 0, 0, 'R');
        $this->Cell(36, 5, 'PO (IDR)', 1, 0, 'C');
        $this->Cell(18, 5, '', 0, 0, 'R');
        $this->Cell(36, 5, 'LANDED (IDR)', 1, 0, 'C');
        $this->Cell(15, 5, '', 0, 1, 'R');
        //and headr atas

        $this->Cell(8, 5, 'No', 1, 0, 'C');
        $this->Cell(15, 5, 'Item no', 1, 0, 'L');
        $this->Cell(55, 5, 'Description', 1, 0, 'L');
        $this->Cell(18, 5, 'Qty', 1, 0, 'R');
        $this->Cell(10, 5, 'Unit', 1, 0, 'C');
        $this->Cell(18, 5, "Price Unit", 1, 0, 'R');
        $this->Cell(18, 5, "Amount", 1, 0, 'R');
        $this->Cell(18, 5, 'Kurs PO', 1, 0, 'R');
        $this->Cell(18, 5, "Price Unit", 1, 0, 'R');
        $this->Cell(18, 5, "Amount", 1, 0, 'R');
        $this->Cell(18, 5, 'Kurs Landed', 1, 0, 'R');
        $this->Cell(18, 5, 'Amount', 1, 0, 'R');
        $this->Cell(18, 5, 'HPP Unit', 1, 0, 'R');
        $this->Cell(15, 5, '+/-', 1, 1, 'R');

        $this->SetFont('Arial', '', 7);
        $this->SetWidths(array(8, 15, 55, 18, 10, 18, 18, 18, 18, 18, 18, 18, 18, 15));
        $this->SetAligns(array('C', 'L', 'L', 'R', 'C', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R'));

        foreach ($detail as $baris) {
            $isExcluded = ($baris['Partid'] === "01.001.163");
            $kurs_akhir     = $isExcluded ? "" : $baris['Kurs_Akhir'];
            $amount_akhir   = $isExcluded ? "" : $baris['Amount_Akhir'];
            $hpp_akhir      = $isExcluded ? "" : $baris['Hpp_Akhir'];
            $selisih_hpp    = $isExcluded ? "" : $baris["Selisih_Hpp"];
            $this->Row(array(
                $baris['ItemNo'],
                $baris['Partid'],
                $baris['PartName'],
                $baris['qty'],
                $baris['satuan'],
                $baris['Price'],
                $baris['Amount_USD'],
                $baris['Kurs'],
                $baris['Hpp_Awal'],
                $baris['Amount_Rp'],
                $kurs_akhir,
                $amount_akhir,
                $hpp_akhir,
                $selisih_hpp
            ));
        }


        // Total row
        $this->SetFont('Arial', 'B', 7);
        $this->SetX(10);
        $this->Cell(78, 5, "T O T A L", 1, 0, 'C');
        $this->Cell(18, 5, $total_qty, 1, 0, 'R');
        $this->Cell(10, 5, "", 1, 0, 'R'); //unit 
        $this->Cell(18, 5, "", 1, 0, 'R'); // price usd
        $this->Cell(18, 5, $total_USD, 1, 0, 'R');
        $this->Cell(18, 5, '', 1, 0, 'R'); //kurs awal
        $this->Cell(18, 5, '', 1, 0, 'R'); // price rp
        $this->Cell(18, 5, $total_Rp, 1, 0, 'R');
        $this->Cell(18, 5, '', 1, 0, 'R');  //kurs akhir
        $this->Cell(18, 5, $total_RpAkhir, 1, 0, 'R');
        $this->Cell(18, 5, '', 1, 0, 'R'); // hpp landed
        $this->Cell(15, 5, '', 1, 1, 'R'); // +/-


        // Note section - MENEMPEL ke TOTAL
        $currentY = $this->GetY(); // AMBIL POSISI SETELAH TOTAL

        $this->SetXY(10, $currentY);
        $this->SetFont('Arial', 'B', 7);
        $this->MultiCell($width + 20, 5, 'Total item Product Only', 0, 'L', FALSE);
        $this->SetXY($width + 30, $currentY);
        $this->MultiCell(3, 5, ':', 0, 'L', FALSE);
        $this->SetXY($width + 33, $currentY);
        $this->MultiCell(15, 5, 'PO (USD)', 0, 'L', false);
        $this->SetXY($width + 48, $currentY);
        $this->MultiCell(3, 5, ':', 0, 'L', FALSE);
        $this->SetXY(58, $currentY);
        $this->MultiCell(25, 5, $total_usd_only, 0, 'R', false);

        $y1 = $this->GetY();
        $this->SetFont('Arial', 'B', 7);
        $this->MultiCell($width + 23, 5, '', 0, 'L', FALSE);

        $this->SetXY($width + 33, $y1);
        $this->MultiCell(15, 5, 'PO (IDR)', 0, 'L', false);
        $this->SetXY($width + 48, $y1);
        $this->MultiCell(3, 5, ':', 0, 'L', FALSE);
        $this->SetXY(58, $y1);
        $this->MultiCell(25, 5, $total_idr_only, 0, 'R', false);

        $y7 = $this->GetY();
        $this->SetXY(10, $y7); // MULAI DARI X=10 & Y=sekarang
        $this->SetFont('Arial', 'B', 7);
        $this->MultiCell($width + 5, 5, 'Catatan ', 0, 'L', FALSE);
        $this->SetXY(25, $y7);
        $this->MultiCell(3, 5, ':', 0, 'L', FALSE);
        $this->SetXY(28, $y7);
        $this->MultiCell(85, 5, $Note, 0, 'L', false);

        //  Cetak PIB
        $x = 155;
        /* $this->SetXY($x, $currentY);
        $this->Cell(55, 5, 'PIB', 0, 0, 'L');
        $this->Cell(7, 5, ': Rp.', 0, 0, 'C');
        $this->Cell(22, 5, $Pib, 0, 0, 'R');
        $this->Cell(5, 5, " - > ", 0, 0, 'L');
        $this->Cell(22, 5, " Tidak Masuk HPP", 0, 1, 'L'); */

        //Cetak forwader

        $y2 = $this->GetY();
        $this->SetXY($x, $currentY);
        $this->Cell(55, 5, 'BIAYA FORWARDER', 0, 0, 'L');
        $this->Cell(7, 5, ': Rp.', 0, 0, 'C');
        $this->Cell(22, 5, $Forwarder, 0, 1, 'R');
        //   $this->Cell(5, 5, " - > ", 0, 0, 'L');
        //  $this->Cell(22, 5, " Masuk HPP", 0, 1, 'L');

        //cetak penjumlahan
        // $y3 = $this->GetY();
        // $this->SetXY($x, $y3);
        // $this->Cell(20, 1, str_repeat("_", 62), 0, 1, 'L');

        // $x4 = 259;
        // $y4 = $this->GetY();
        // $this->SetXY($x4, $y4);
        // $this->Cell(5, 1, '+', 0, 1, 'L');

        // $y5 = $this->GetY();
        // $this->SetXY($x, $y5);
        // $this->Cell(55, 5, 'TOTAL', 0, 0, 'L');
        // $this->Cell(7, 5, ': Rp.', 0, 0, 'C');
        // $this->Cell(22, 5, $Forwarder, 0, 1, 'R');


        //cetak prosentase
        $y6 = $this->GetY();
        $this->SetXY($x, $y6);
        $this->Cell(55, 5, 'PROSENTASE KENAIKAN HARGA LANDED', 0, 0, 'L');
        $this->Cell(2, 5, ':', 0, 0, 'C');
        $this->Cell(40, 5, $total_Prosentase . " %" . " ( 1 " . $currid . " =  Rp. " . $kurslanded . " )", 0, 1, 'L');



        $this->SetY(-100);
    }
    function Footer()
    {
        $this->SetY(-100); // hanya 20 mm dari bawah
    }

    protected function replacedata($data)
    {

        $formatted = number_format((float)$data, 2, ".", ","); // misal: 1,234.56
        return str_replace(array('.', ','), '', $formatted); // hasil: 123456
    }
    protected function getformatnumer($data)
    {
        return number_format($data, 2, ".", ",");
    }

    /**
     * Set the array of column widths for table rows
     */
    public function SetWidths($w)
    {
        $this->widths = $w;
    }

    /**
     * Set the array of column alignments for table rows
     */
    public function SetAligns($a)
    {
        $this->aligns = $a;
    }

    public function printPDF()
    {
        $this->SetAutoPageBreak(true, 30);
        $this->AliasNbPages();
        $this->SetFont("Arial", "B", 10);
        $this->rptDetailData();
        $this->Output($this->options['filename'], $this->options['destinationfile']);
    }

    /**
     * Custom method to handle multi-line row rendering in the table.
     */
    function Row($data)
    {
        // Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++) {
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }
        $h = 5 * $nb;
        $this->CheckPageBreak($h);

        // Draw the cells
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            $x = $this->GetX();
            $y = $this->GetY();
            $this->Rect($x, $y, $w, $h);
            $this->MultiCell($w, 5, $data[$i], 0, $a);
            $this->SetXY($x + $w, $y);
        }
        $this->Ln($h);
    }

    /**
     * Check if a page break is needed and add page if so
     */
    function CheckPageBreak($h)
    {
        if ($this->GetY() + $h > $this->PageBreakTrigger) {
            $this->AddPage($this->CurOrientation);
        }
    }

    /**
     * Compute the number of lines a MultiCell of width w will take
     */
    function NbLines($w, $txt)
    {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }
}

// Options for PDF generation
$options = array(
    'filename' => 'laporan_pakinglist.pdf',
    'destinationfile' => 'I', // I = inline (browser)
    'paper_size' => 'A4',
    'orientation' => 'L'      // L = landscape
);



$tabel = new FPDF_AutoWrapTable($data, $options);
$tabel->printPDF();
