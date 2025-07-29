<?php

class FPDF_AutoWrapTable extends FPDF {
      private $data = array();
      private $options = array(
          'filename' => '',
          'destinationfile' => '',
          'paper_size'=>'A4',
          'orientation'=>'P'
      );
		

    function __construct($data = array(), $options = array()) {
    
        parent::__construct();
        $this->data = $data;
        $this->options = $options;
    }

    public function rptDetailData() {
        date_default_timezone_set('Asia/Jakarta');

        $header = $this->data["dataheader"];
        $detail = $this->data["datadetail"];
        // echo "<pre>";
        // print_r($header);
        // echo "</pre>";
        // die();
        $border = 0;
        $this->AddPage();
        $this->SetAutoPageBreak(true,60);
        $this->AliasNbPages();
        $left = 25;

        //header
         
                $ID_Hider     = $header['ID_Hider'];
				$No_Pli     = $header['No_Pli'];

     
				$NoPO       = $header['NoPO'];
				$EntryDate  =date('d-m-y',strtotime($header['EntryDate']));

                
				$Note       = $header['Note'];
				$supid      = $header['supid'];
				$Pib        = $header['Pib'];
                $Forwarder  = $header['Forwarder'];
                $Total      = $header['Total'];
                $CustAddres = $header["CustAddres"];
                $CustTelpNo = $header["CustTelpNo"];
                $CustFaxNo  = $header["CustFaxNo"];
                $CustEmail  = $header["CustEmail"];
                $SupperiName  = $header["SupperiName"];
                $id_bl_awb    = $header["id_bl_awb"];
			
	
			
     
			// setting jenis font yang akan digunakan
			///set font to arial, bold, 14pt
            $this->SetAutoPageBreak(true,30);
            $this->AliasNbPages();
            $this->SetFont('Arial','B',14);
            $this->Cell(180 ,5,$SupperiName,0,1,'C');

			$this->SetFont('Arial','B',8);
            $this->Cell(180 ,5,$CustAddres,0,1,'C');
            $this->Cell(28,5,'',0,0);
            $this->Cell(35 ,5,"Tel:".$CustTelpNo,0,0);
            $this->Cell(10,5,'',0,0);
            $this->Cell(35,5,"FAX:" .$CustFaxNo,0,0);
            $this->Cell(10,5,'',0,0);
            $this->Cell(36,5,"Email:".$CustEmail,0,1);
            $this->SetFont('Arial','B',14);
            $this->Cell(2,5,'',0,0);
            $this->Cell(190,1,"_______________________________________________________________________",0,0,'C');
            $this->Cell(2,5,'',0,1);


            
			//Cell(width , height , text , border , end line , [align] )
     
            $this->SetFont('Arial','BI',14);
			$this->Cell(180 ,10,'PACKING LIST PENAMBAHAN PIB',0,1,'C');//end of line

            $this->SetFont('Arial','B',8);
			$y = $this->GetY();
			$x = $this->GetX();
			$width =21;
			$this->MultiCell($width,5,'THE BUYER :',0, 'L', FALSE);
			$this->SetXY($x + $width, $y);
			$this->MultiCell(2,5, '',0, 'L', FALSE);
			$this->SetXY($x + $width + 2, $y);
			$this->MultiCell(100,5,'PT BEST MEGA INDUSTRI  JL. RAYA BOGOR KM.38. NO.77 SUKAMAJU CILODONG DEPOK, JAWABARAT 16415, INDONESIA', 0,'L',FALSE);
      
            $this->SetXY($x + 125 + 2, $y);
            $this->MultiCell(15,5,'NO PO  TGL PO  NO PL',0,'L',FALSE);
            $this->SetXY($x + 140 + 2, $y);
            $this->MultiCell(3,5,': : :',0,'L',FALSE);
            $this->SetXY($x + 143 + 2, $y);
            $this->MultiCell(25,5,$NoPO ."\n". $EntryDate ."\n".$No_Pli ,0,'L',FALSE);
         
            
    
			$this->Cell(0,2, '', 0, 1,'C');
            $this->MultiCell($width+80,5,'BL/AWB       :        '.$id_bl_awb ,0, 'L', FALSE);
			
          
			//invoice contents
		
	$this->Cell(0,2, '', 0, 1,'C');

          
              $left = 40;
              $left = $this->GetX();
             $h =5;
          $this->SetFillColor(220, 220, 200);
          $this->ln();
            $this->SetFont('Arial','B',7);
            $this->SetX($left +=0); $this->Cell(8,$h,'NO',1, 0,'C');
            $this->SetX($left +=8); $this->Cell(15,$h,'ITEM NO',1, 0,'C');
            $this->SetX($left +=15); $this->Cell(55,$h,'DESCRIPTION',1, 0,'L');
            $this->SetX($left +=55); $this->Cell(18,$h,'BIAYA PIB',1, 0,'R');
            $this->SetX($left +=18); $this->Cell(20,$h,'KOMPOSISI %',1, 0,'R');
            $this->SetX($left +=20); $this->Cell(18,$h,'QTY',1, 0,'R');
            $this->SetX($left +=18); $this->Cell(18,$h,'AMOUNT PIB',1, 1,'R');
 
            $this->SetFont('Arial','',7);
            //$this->SetDrawColor(255,255,255); ini untuk mengilangkan gari di row table
            $this->SetWidths(array(8,15,55,18,20,18,18));
            $this->SetAligns(array('C','C','L','R','R','R','R'));

            $no = 1; $this->SetFillColor(255);

            $total_qty =0;
            $total_biayapib=0;
            $total_amount=0;
            $total_komp=0;
            foreach($detail as $baris){
      
             $this->Row(
                array(
                    $baris['ItemNo'],
                    $baris['Partid'],
                     $baris['PartName'],
                     $baris['Biaya_pib'],
                     $baris['Komposisi'],
                     $baris['Qty'],
                     $baris['Amount'],
                   
                ));
                
                $rep_qty = str_replace(",","",$baris['Qty']);

                $rep_biayapib = str_replace(",","",$baris['Biaya_pib']);
                $rep_Amount = str_replace(",","",$baris['Amount']);
         
              
                $total_qty +=(float)$rep_qty;
                $total_biayapib +=(float)$rep_biayapib;
                $total_amount +=(float)$rep_Amount;
                $total_komp +=(float)$baris['Komposisi_jm'];
            }

            $label = "T O T A L  ";
            $set_qty = $this->getformatnumerqty($total_qty);
            $set_pib = $this->getformatnumerqty($total_biayapib);
            $set_amount = $this->getformatnumerqty($total_amount);

            $set_komp = $this->getformatnumer_kom($total_komp);
            $left = 40;
            $left = $this->GetX();
            $this->SetFont('Arial','B',7);
          
            $this->SetX($left +=0); $this->Cell(78,$h,$label,1, 0,'C');
            $this->SetX($left +=78); $this->Cell(18,$h,$set_pib,1, 0,'R');
            $this->SetX($left +=18); $this->Cell(20,$h,$set_komp,1, 0,'R');
            $this->SetX($left +=20); $this->Cell(18,$h,$set_qty,1,0,'R');
            $this->SetX($left +=18); $this->Cell(18,$h,$set_amount,1, 1,'R');
            $this->Cell(0,0, '', 0, 1,'C');
            $y = $this->GetY();
			$x = $this->GetX();
            $width =40;
            $this->SetFont('Arial','B',7);
            $this->MultiCell($width+50,5,$Note,0, 'L', FALSE);
			$this->SetXY($x + $width, $y);

            $this->Cell(0,10, '', 0, 1,'C');
			$this->SetFont('Arial','B',7);
		
			
			$y = $this->GetY();
			$x = $this->GetX();
			$width =95;
			$this->MultiCell($width, 5,'',0, 'L', FALSE);
			$this->SetXY($x + $width, $y);
			$this->MultiCell($width-10, 5,$SupperiName,0, 'L', FALSE);
            $this->SetXY($x + $width-10, $y);
            $this->Cell(10,2, '', 0, 1,'C');
            

            $left = 40;
            $left = $this->GetX();
            $this->SetFont('Arial','B',7);
            $this->SetX($left +=0); $this->Cell(18,$h,'PIB',0, 0,'L');
            $this->SetX($left +=18); $this->Cell(4,$h,': Rp. ',0, 0,'L');
            $this->SetX($left +=4); $this->Cell(23,$h,$Pib,0, 1,'R');
	
            $left = 40;
            $left = $this->GetX();
            $this->SetX($left +=0); $this->Cell(18,2,'FORWARDER',0, 0,'L');
            $this->SetX($left +=18); $this->Cell(4,2,': Rp. ',0, 0,'L');
            $this->SetX($left +=4); $this->Cell(23,2,$Forwarder,0, 1,'R');

            $left = 40;
            $left = $this->GetX();
            $this->SetX($left +=0); $this->Cell(50,1,'________________________________',0,1,'L');
            $this->SetX($left +=45); $this->Cell(5,1,'+',0, 1,'L');

            $left = 40;
            $left = $this->GetX();
            $this->SetX($left +=0); $this->Cell(18,$h,'TOTAL',0, 0,'L');
            $this->SetX($left +=18); $this->Cell(4,$h,': Rp. ',0, 0,'L');
            $this->SetX($left +=4); $this->Cell(23,$h,$Total,0, 1,'R'); 
            
    }
	protected function getformatnumerqty($data){
		$format =number_format($data,0,",",",");
		return $format;
	}

    protected function getformatnumer($data){
		$format =number_format($data,2,".",",");
		return $format;
	}
    protected function getformatnumer_kom($data){
		$format =number_format($data,2,".",".");
		return $format;
	}

    public function printPDF () {

        if ($this->options['paper_size'] == "F4") {
            $a = 8.3 * 72; //1 inch = 72 pt
            $b = 13.0 * 72;
            //$pdf = new FPDF($this->options['orientation'], "pt", array($a,$b));
             new FPDF($this->options['orientation'], "pt", array($a,$b));
          
        } else {
            $this->FPDF($this->options['orientation'], "pt", $this->options['paper_size']);
        }

        $this->SetAutoPageBreak(false);
        $this->AliasNbPages();
        $this->SetFont("helvetica", "B", 10);
        //$this->AddPage();

        $this->rptDetailData();
        $this->Output($this->options['filename'],$this->options['destinationfile']);
      }

    private $widths;
    private $aligns;

    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths=$w;
    }

    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns=$a;
    }

    function Row($data)
    {
  
        
        //Calculate the height of the row
        $nb=0;
        for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
       
        $h=5*$nb;

        //Issue a page break first if needed
        $this->CheckPageBreak($h);

        //Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();

            //Draw the border
            $this->Rect($x,$y,$w,$h);

            //Print the text
            $this->MultiCell($w,5,$data[$i],1,$a);

            //Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }

        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
    }

    function NbLines($w,$txt)
    {
        
        //Computes the number of lines a MultiCell of width w will take
        $cw=&$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r",'',$txt);
        $nb=strlen($s);
        if($nb>0 and $s[$nb-1]=="\n")
            $nb--;
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;

        while($i<$nb)
        {
            $c=$s[$i];
            if($c=="\n")
            {
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep=$i;
            $l+=$cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i=$sep+1;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }

    private function replace_name($data){
        $replace = str_replace("&amp;","",$data);
        return $replace;
    }
} //end of class


//pilihan
$options = array(
    'filename' => '', //nama file penyimpanan, kosongkan jika output ke browser
    'destinationfile' => '', //I=inline browser (default), F=local file, D=download
    'paper_size'=>'F4',    //paper size: F4, A3, A4, A5, Letter, Legal
    'orientation'=>'P' //orientation: P=portrait, L=landscape
);


$tabel = new FPDF_AutoWrapTable($data, $options);

$tabel->printPDF();
?>