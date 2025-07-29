<?php

class PackingListModel extends  Models{
    private $tablehead ="[bambi-bmi].[dbo].POPAKINGLIST";
    private $tabledetail ="[bambi-bmi].[dbo].POPAKINGLISTDETAIL";

    private $No_Pli;
    private $NoPO;
    private $EntryDate;
    private $Note;
    private $supid ;
    private $Pib;
    private $Forwarder;
    private $Total;
    private $CustAddress;
    private $CustTelpNo;
    private $CustFaxNo;
    private $CustEmail;
    private $SupperiID;
    private  $SupperiName;
    private $id_bl_awb;


    public function SaveData($post){
   

        $dataheader = $post["dataheader"];
        $datadetail = $post["datadetail"];

        $transo =$dataheader["transo"];
        $cekhead =  $this->CekHeadr($transo);
        if($cekhead == 0){
            $this->simpandataDetail($dataheader,$datadetail);
            return $this->simpadataHider($dataheader);

        }
    }

     private function simpadataHider($header){

     
        $dateString =$this->test_input($header["tanggal"]);
        $dateTime = DateTime::createFromFormat('d/m/Y', $dateString);
        $formattedDate = $dateTime->format('Y-m-d H:i:s');
       
        $No_Pls =$this->test_input($header["transo"]);
        $No_Pli =$this->test_input($header["idpackinglist"]);
        $suplieid =$this->test_input($header["suplieid"]);
        $NoPo =$this->test_input($header["nodo"]);
        $POTransacid =$this->test_input($header["nopo"]);
        $EntryDate =$formattedDate;
        $Note =$this->test_input($header["keterangan"]);
        $LastUserIDAccess =$this->test_input($header["userid"]);
        $Pib =$this->test_input($header["pib"]);
        $Forwarder =$this->test_input($header["forwarder"]);
        $Total =$this->test_input($header["total"]);
        $id_bl_awb =$this->test_input($header["id_bl_awb"]);

        $query ="SP_INSERT_POAKINGLIST_Header '".$No_Pls."','".$No_Pli."','".$suplieid."','".$NoPo."','".$POTransacid."','".$EntryDate."',
        '".$Note."','".$LastUserIDAccess."','".$Pib."','".$Forwarder."','".$Total."','".$id_bl_awb."'";
        //$this->consol_war($query);
       
        $result= $this->db->baca_sql2($query);
        $cek = 0;
        if(!$result){
            $cek = $cek+1;
        }
        if ($cek==0){
            $status['nilai']=1; //bernilai benar
            $status['error']="Data Berhasil Tambah";
        }else{
            $status['nilai']=0; //bernilai benar
            $status['error']="Data Gagal Tambah";
        }

        
         return $status;

     }

    private function CekHeadr($transo){
        $query = "SELECT DISTINCT  No_Pls FROM $this->tablehead where No_Pls ='".$transo."' ";
		$result= $this->db->baca_sql2($query);
		$rows= odbc_fetch_array($result); 
     
		$valid=0;
		if($rows > 0){
			$valid=1;
		}

		return $valid;
    }


    private function simpandataDetail($head,$detail){

          
    
        $POTranso = $this->test_input($head["transo"]);
       
       
        foreach ($detail as $value) {

        $partid     = $this->test_input($value["partid"]);
        $partname   = $this->test_input($value["partname"]);
        $qty1       = $this->test_input($value["qty"]);

        $qty        = str_replace(",","",$qty1); 
        $CTNS       = $this->test_input($value["CTNS"]);
        $GTNS       = $this->test_input($value["GTNS"]);
        $KGS        = $this->test_input($value["KGS"]);
        $CBM        = $this->test_input($value["CBM"]);
        $satuan     = $this->test_input($value["unit"]);
        $komposisi  = $this->test_input($value["Total_CBM"]);
        $PODetail   = $this->gitIddetail($partid);

        
        $query="SP_SimpanPakingListDetail '".$POTranso."','".$PODetail."', '".$partid."', '".$partname."',
         '".$qty."','".$CTNS."', '".$GTNS."', '".$KGS."', '".$CBM."','".$satuan."','".$komposisi."'";
      

    
         $this->db->baca_sql2($query);
        // return $this->detaildata($result2);
        }    
      
    }


    private function gitIddetail($partid){
        $id = $this->generateUUID();
        $id_d =md5($id.$partid);
        $id_short = substr($id_d, 0, 10);
       return $id_short;
    }


    private function generateUUID() {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }




    public function ListData($post){
        $status ="";

        $userid = $this->test_input($post["userid"]);

        if($userid == "wardi" || $userid =="herman"){
            $status ="Y";
        }else{
            $status ="N";
        }
        $tahun = $this->test_input($post["tahun"]);

        $query ="SP_TampilPOPakingList '".$status."','".$tahun."','".$userid."' ";

        $result = $this->db->baca_sql2($query);
        $datas = [];
        while(odbc_fetch_row($result)){
        // "No_Pls,No_Pli,NoPo,POTransacid,EntryDate,Note,supid,userid,Totaldetail";
            $datas[] =[
                "No_Pls"     =>rtrim(odbc_result($result,'No_Pls')),
                "No_Pli"     =>rtrim(odbc_result($result,'No_Pli')),
                "NoPo"       =>rtrim(odbc_result($result,'NoPo')),
                "id_bl_awb"  =>rtrim(odbc_result($result,'id_bl_awb')),
                "POTransacid"=>rtrim(odbc_result($result,'POTransacid')),
                "EntryDate"  =>rtrim(odbc_result($result,'EntryDate')),
                "Note"       =>rtrim(odbc_result($result,'Note')),
                "supid"      =>rtrim(odbc_result($result,'supid')),
                "userid"     =>rtrim(odbc_result($result,'userid')),
                "Totaldetail"=>(int)rtrim(odbc_result($result,'Totaldetail')),
                "Pib"        =>number_format(rtrim(odbc_result($result,'Pib')), 2, '.', ','),
                "Forwarder"  =>number_format(rtrim(odbc_result($result,'Forwarder')), 2, '.', ','),
                "Total"      => number_format(rtrim(odbc_result($result,'Total')), 2, '.', ','),
                "Status"     =>$status
            ];
            }

           //$this->consol_war($datas);
          return $datas;
        }


        // private function  replacekutuf($data){

        //     return str_replace()
        // }

       public function TampilEditDetailpo($post){
        $DOTransacID = $this->test_input($post["DOTransacID"]);
        $transnoHider = $this->test_input($post["transnoHider"]);

        $query="SP_TampilDataEditPacinglist '".$transnoHider."','".$DOTransacID."'";
    
      
        $result = $this->db->baca_sql2($query);
        $datas = [];
        while(odbc_fetch_row($result)){
        // "No_Pls,No_Pli,NoPo,POTransacid,EntryDate,Note,supid,userid,Totaldetail";
            $datas[] =[
                "ItemNo"=>rtrim(odbc_result($result,'ItemNo')),
                "Partid"=>rtrim(odbc_result($result,'Partid')),
                "PartName"=>rtrim(odbc_result($result,'PartName')),
                "satuan"=>rtrim(odbc_result($result,'satuan')),
                "qty"=>number_format(rtrim(odbc_result($result,'quantity')),0, ',', ','),
                "CTNS"=>rtrim(odbc_result($result,'CTNS')) == 0 ? "": number_format(rtrim(odbc_result($result,'CTNS')), 2, '.', ','),
                "CBM"=>rtrim(odbc_result($result,'CBM')) == 0 ? "": number_format(rtrim(odbc_result($result,'CBM')), 2, '.', ','),
                "GTNS"=>rtrim(odbc_result($result,'GTNS'))== 0 ? "": number_format(rtrim(odbc_result($result,'GTNS')), 2, '.', ','),
                "KGS"=>rtrim(odbc_result($result,'KGS')) == 0 ? "": number_format(rtrim(odbc_result($result,'KGS')), 2, '.', ','),
                "Komposisi"=>rtrim(odbc_result($result,'Komposisi')) == 0 ? "": number_format(rtrim(odbc_result($result,'Komposisi')), 2, '.', ','),
                "PODetail"=>rtrim(odbc_result($result,'PODetail')),
                "No_Pls"=>rtrim(odbc_result($result,'No_Pls')),
            ];
            }

        //$this->consol_war($datas);
          return $datas;

       } 



       public function DeletePacking($post){
        $transnoHider = $this->test_input($post["transnoHider"]);

        $query ="DELETE  FROM $this->tablehead WHERE  No_Pls ='".$transnoHider."'";
        $query .="DELETE  FROM $this->tabledetail WHERE  No_Pls ='".$transnoHider."'";
        $result =$this->db->baca_sql2($query);

        $cek = 0;
        if(!$result){
            $cek = $cek+1;
        }
        if ($cek==0){
            $status['nilai']=1; //bernilai benar
            $status['error']="Data Berhasil di Delete";
        }else{
            $status['nilai']=0; //bernilai benar
            $status['error']="Data Gagal Delete";
        }
        return $status;
       }





       public function UpdateData($post){
        $dataheader = $post["dataheader"];
        $datadetail = $post["datadetail"];

            $this->UpdateDataDetail($datadetail);
            return $this->UpdateDataHider($dataheader);

       }
       
       private function UpdateDataHider($header){

        $dateString =$this->test_input($header["tanggal"]);
        $dateTime = DateTime::createFromFormat('d/m/Y', $dateString);
        $formattedDate = $dateTime->format('Y-m-d H:i:s');

        $No_Pls             = $this->test_input($header["transo"]);
        $No_Pli             = $this->test_input($header["idpackinglist"]);
        $EntryDate          = $formattedDate;
        $Note               = $this->test_input($header["keterangan"]);
        $UpdateUserIDAccess = $this->test_input($header["userid"]);
        $UpdateDateAccess   = date("Y-m-d H:i:s");
        $Pib                = $this->test_input($header["pib"]);
        $Forwarder          = $this->test_input($header["forwarder"]);
        $Total              = $this->test_input($header["total"]);
        $id_bl_awb          = $this->test_input($header["id_bl_awb"]);

        $query ="UPDATE  $this->tablehead SET No_Pli='".$No_Pli."',EntryDate='".$EntryDate."',Note='".$Note."',
        UpdateUserIDAccess='".$UpdateUserIDAccess."',UpdateDateAccess='".$UpdateDateAccess."', 
        Pib ='".$Pib."',Forwarder='".$Forwarder."', Total='".$Total."',id_bl_awb='".$id_bl_awb."'
        WHERE No_Pls ='".$No_Pls."' ";
     
        
        $query .="
        UPDATE $this->tablehead
		SET No_Pli = REPLACE(CAST(No_Pli AS VARCHAR(2000)), 'kut1;', '''')
		WHERE No_Pls ='".$No_Pls."'   AND No_Pli like '%kut1;%'
        ";

        $query.=" UPDATE $this->tablehead
		SET No_Pli = REPLACE(CAST(No_Pli AS VARCHAR(2000)), 'kut2;', '\"')
		WHERE No_Pls ='".$No_Pls."'  AND No_Pli like '%kut2;%'";

        $query.="UPDATE $this->tablehead
		SET Note = REPLACE(CAST(Note AS VARCHAR(2000)), 'kut1;', '''')
		WHERE No_Pls ='".$No_Pls."'  AND Note like '%kut1;%'";

        $query.="UPDATE $this->tablehead
		SET Note = REPLACE(CAST(Note AS VARCHAR(2000)), 'kut2;', '\"')
		WHERE No_Pls ='".$No_Pls."'  AND Note like '%kut2;%'";
         $this->db->baca_sql2($query);
       
        
       return $this->Sp_updatedata($No_Pls);


       }
       private function Sp_updatedata($No_Pls){
            $query ="USP_SetPibPopakinglistdetail '".$No_Pls."'";

        $result= $this->db->baca_sql2($query);
               $cek = 0;
            if(!$result){
                $cek = $cek+1;
            }
            if ($cek==0){
                $status['nilai']=1; //bernilai benar
                $status['error']="Data Berhasil di Update";
            }else{
                $status['nilai']=0; //bernilai benar
                $status['error']="Data Gagal Update";
            }
            return $status;
       }

       private function UpdateDataDetail($detail){
  
           
            foreach ($detail as $value) {
              
                $unit       = $this->test_input($value["unit"]);
                $komposisi       = $value["Total_CBM"] ="" ? 0 : $this->test_input($value["Total_CBM"]);
                $CTNS       = $this->test_input($value["CTNS"]);
                $GTNS       = $this->test_input($value["GTNS"]);
                $KGS        = $this->test_input($value["KGS"]);
                $CBM        = $this->test_input($value["CBM"]);
                $PODetail   = $this->test_input($value["PODetail"]);
                $qty        = str_replace(",", "",$this->test_input($value["qty"]));

                $query ="UPDATE  $this->tabledetail SET CTNS ='".$CTNS."',CBM ='".$CBM."', GTNS ='".$GTNS."' , 
                KGS ='".$KGS."',komposisi='".$komposisi."', satuan ='".$unit."',Qty='".$qty."'  WHERE PODetail ='".$PODetail."' ";
         
                $this->db->baca_sql2($query);
            }
       }



       public function ListLaporan($post){
        $tgl_from = $post["tgl_from"];
        $date_from = $this->ChangeDate($tgl_from);
     
        $tgl_to   = $post["tgl_to"];
        $date_to = $this->ChangeDate($tgl_to)." 23:59:59";

        $file =" No_Pls,No_Pli,NoPo,POTransacid,EntryDate,Note,supid,LastUserIDAccess ";
        $table = $this->tablehead;
        $table .=" WHERE  EntryDate BETWEEN '".$date_from."' AND  '".$date_to."'";
        //$table .= $this->orderby("ItemNo");
        $query = $this->select($file,$table);

        $result = $this->db->baca_sql2($query);

        $datas = [];
        while(odbc_fetch_row($result)){
            $datas[] =[
                "No_Pls"=>rtrim(odbc_result($result,'No_Pls')),
                "No_Pli"=>rtrim(odbc_result($result,'No_Pli')),
                "NoPo"=>rtrim(odbc_result($result,'NoPo')),
                "POTransacid"=>rtrim(odbc_result($result,'POTransacid')),
                "EntryDate"=>rtrim(odbc_result($result,'EntryDate')),
                "Note"=>rtrim(odbc_result($result,'Note')),
                "supid"=>rtrim(odbc_result($result,'supid')),
                "userid"=>rtrim(odbc_result($result,'LastUserIDAccess')),
            ];
            }

        // $this->consol_war($datas);
          return $datas;
       }


       private function ChangeDate($tanggal){
        $dateTime = DateTime::createFromFormat('d/m/Y', $tanggal);
        $formattedDate = $dateTime->format('Y-m-d');
        return $formattedDate;
     }





       public function cetakprint($post){
       
        $DOTransacID = $this->test_input($post["POTransacid"]);
        $transnoHider = $this->test_input($post["No_Pls"]);

        $query="SP_CetakPakingList '".$transnoHider."','".$DOTransacID."'";
       //$this->consol_war($query);
        $result = $this->db->baca_sql2($query);
        $datas = [];
        while(odbc_fetch_row($result)){
            $this->No_Pli = rtrim(odbc_result($result,'No_Pli'));
            $this->NoPO = rtrim(odbc_result($result,'NoPO'));
            $this->EntryDate = rtrim(odbc_result($result,'EntryDate'));
            $this->Note = rtrim(odbc_result($result,'Note'));
            $this->supid = rtrim(odbc_result($result,'supid'));
            $this->Pib = rtrim(odbc_result($result,'Pib'));
            $this->Forwarder = rtrim(odbc_result($result,'Forwarder'));
            $this->Total = rtrim(odbc_result($result,'Total'));
            $this->CustAddress = rtrim(odbc_result($result,'CustAddress'));
            $this->CustTelpNo = rtrim(odbc_result($result,'CustTelpNo'));
            $this->CustFaxNo = rtrim(odbc_result($result,'CustFaxNo'));
            $this->CustEmail = rtrim(odbc_result($result,'CustEmail'));
            $this->SupperiID = rtrim(odbc_result($result,'SupperiID'));
            $this->SupperiName = rtrim(odbc_result($result,'SupperiName'));
            $this->id_bl_awb = rtrim(odbc_result($result,'id_bl_awb'));
            $datas[] =[
                "ItemNo"=>(int)rtrim(odbc_result($result,'ItemNo')),
                "Partid"=>rtrim(odbc_result($result,'Partid')),
                "PartName"=>rtrim(odbc_result($result,'PartName')),
                "satuan"=>rtrim(odbc_result($result,'satuan')),
                "qty"=>number_format(rtrim(odbc_result($result,'QtyDelSunter')),0, ',', ','),
                "CTNS"=>number_format(rtrim(odbc_result($result,'CTNS')),0, ',', ','),
                "CBM"=> number_format(rtrim(odbc_result($result,'CBM')), 2, '.', ','),
                "GTNS"=>number_format(rtrim(odbc_result($result,'GTNS')),0, '.', ','),
                "KGS"=> number_format(rtrim(odbc_result($result,'KGS')),0, '.', ','),
                "Komposisi"=>number_format(rtrim(odbc_result($result,'Komposisi')), 2, '.', '.'),
                "Komposisi_jm"=>rtrim(odbc_result($result,'Komposisi'))
             ];
            }
	
            $dataheader=[
                "ID_Hider"=>$transnoHider,
                "No_Pli"=>$this->No_Pli,
                "NoPO"=>$this->NoPO,
                "EntryDate"=>$this->EntryDate,
                "Note"=>$this->Note,
                "supid"=>$this->supid,
                "Pib"=>number_format($this->Pib, 2, '.', ','),
                "Forwarder"=>number_format($this->Forwarder, 2, '.', ','),
                "Total"=>number_format($this->Total, 2, '.', ','),
                "CustAddres"=>$this->CustAddress,
                "CustTelpNo"=>$this->CustTelpNo,
                "CustFaxNo"=>$this->CustFaxNo,
                "CustEmail"=>$this->CustEmail,
                "SupperiID"=>$this->SupperiID,
                "SupperiName"=>$this->SupperiName,
                "id_bl_awb"=>$this->id_bl_awb
            ];

            $fulldata =[
                "dataheader"=>$dataheader,
                "datadetail" => $datas
            ];
        //$this->consol_war($fulldata);
          return $fulldata;

       } 



       public function PostingData($post){
   
            $head =$post["dataheader"];
            $UserPosting = $this->test_input($head["userid"]);
            $No_Pls = $this->test_input($head["transo"]);
            $DatePosting = date("Y-m-d H:i:s");
            $FlagPosting = "Y";


            $query ="UPDATE $this->tablehead SET UserPosting ='".$UserPosting."', DatePosting='".$DatePosting."' , FlagPosting='".$FlagPosting."'
            WHERE No_Pls ='".$No_Pls."'";

           // $this->consol_war($query);
            $result =$this->db->baca_sql2($query);

            $cek = 0;
            if(!$result){
                $cek = $cek+1;
            }
            if ($cek==0){
                $status['nilai']=1; //bernilai benar
                $status['error']="Data Berhasil di Posting";
            }else{
                $status['nilai']=0; //bernilai benar
                $status['error']="Data Gagal Posting";
            }
            return $status;
       }


       public function ListSudahPosting($post){
        $status ="";

        $userid = $this->test_input($post["userid"]);

        if($userid == "wardi" || $userid =="herman"){
            $status ="Y";
        }else{
            $status ="N";
        }
        $tahun = $this->test_input($post["tahun"]);

        $query ="SP_TampilPOPakingListSudahPosting '".$status."','".$tahun."','".$userid."' ";

        
        $result = $this->db->baca_sql2($query);
        $datas = [];
        while(odbc_fetch_row($result)){
        // "No_Pls,No_Pli,NoPo,POTransacid,EntryDate,Note,supid,userid,Totaldetail";
            $datas[] =[
                "No_Pls"     =>rtrim(odbc_result($result,'No_Pls')),
                "No_Pli"     =>rtrim(odbc_result($result,'No_Pli')),
                "NoPo"       =>rtrim(odbc_result($result,'NoPo')),
                "id_bl_awb"  =>rtrim(odbc_result($result,'id_bl_awb')),
                "POTransacid"=>rtrim(odbc_result($result,'POTransacid')),
                "EntryDate"  =>rtrim(odbc_result($result,'EntryDate')),
                "Note"       =>rtrim(odbc_result($result,'Note')),
                "supid"      =>rtrim(odbc_result($result,'supid')),
                "userid"     =>rtrim(odbc_result($result,'userid')),
                "Totaldetail"=>(int)rtrim(odbc_result($result,'Totaldetail')),
                "Pib"        =>number_format(rtrim(odbc_result($result,'Pib')), 2, '.', ','),
                "Forwarder"  =>number_format(rtrim(odbc_result($result,'Forwarder')), 2, '.', ','),
                "Total"      => number_format(rtrim(odbc_result($result,'Total')), 2, '.', ','),
                "UserPosting"     =>rtrim(odbc_result($result,'UserPosting')),
                "DatePosting"     =>rtrim(odbc_result($result,'DatePosting')),
            ];
            }

            //$this->consol_war($datas);
          return $datas;
        
       }



       public function TampilDetailPosting($post){
        $DOTransacID = $this->test_input($post["DOTransacID"]);
        $transnoHider = $this->test_input($post["transnoHider"]);

        $query="SP_TampilDataPostingPacinglist '".$transnoHider."','".$DOTransacID."'";

        $result = $this->db->baca_sql2($query);
        $datas = [];
        $tota_komp =0;
        while(odbc_fetch_row($result)){
            $tota_komp +=rtrim(odbc_result($result,'Komposisi'));
        // "No_Pls,No_Pli,NoPo,POTransacid,EntryDate,Note,supid,userid,Totaldetail";
            $datas[] =[
                "ItemNo"=>rtrim(odbc_result($result,'ItemNo')),
                "Partid"=>rtrim(odbc_result($result,'Partid')),
                "PartName"=>rtrim(odbc_result($result,'PartName')),
                "satuan"=>rtrim(odbc_result($result,'satuan')),
                "qty"=>number_format(rtrim(odbc_result($result,'QtyDelSunter')),0, ',', ','),
                "CTNS"=>rtrim(odbc_result($result,'CTNS')) == 0 ? "": number_format(rtrim(odbc_result($result,'CTNS')), 2, '.', ','),
                "CBM"=>rtrim(odbc_result($result,'CBM')) == 0 ? "": number_format(rtrim(odbc_result($result,'CBM')), 2, '.', ','),
                "GTNS"=>rtrim(odbc_result($result,'GTNS'))== 0 ? "": number_format(rtrim(odbc_result($result,'GTNS')),2, '.', ','),
                "KGS"=>rtrim(odbc_result($result,'KGS')) == 0 ? "": number_format(rtrim(odbc_result($result,'KGS')),2, '.', ','),
                "Komposisi"=>number_format(rtrim(odbc_result($result,'Komposisi')),2, '.', '.'),
                "TotalKomp"=>number_format($tota_komp,2, '.', '.'),
                "PODetail"=>rtrim(odbc_result($result,'PODetail')),
                "No_Pls"=>rtrim(odbc_result($result,'No_Pls')),
            ];
            }

       

         $datafull =[
            "TotalKomp"=>number_format($tota_komp,2, '.', '.'),
            "Detail"=>$datas
         ];
        // $this->consol_war($datafull);
          return $datafull;
       }



       //baru laporan pib update kode th 2025 by wardi
    public function ListLaporanPIB($post){
        $tgl_from = $post["tgl_from"];
        $date_from = $this->ChangeDate($tgl_from);
     
        $tgl_to   = $post["tgl_to"];
        $date_to = $this->ChangeDate($tgl_to)." 23:59:59";

        $file =" No_Pls,No_Pli,NoPo,POTransacid,EntryDate,Note,supid,LastUserIDAccess ";
        $table = $this->tablehead;
        $table .=" WHERE  EntryDate BETWEEN '".$date_from."' AND  '".$date_to."'";
        //$table .= $this->orderby("ItemNo");
        $query = $this->select($file,$table);

        $result = $this->db->baca_sql2($query);

        $datas = [];
        while(odbc_fetch_row($result)){
            $datas[] =[
                "No_Pls"=>rtrim(odbc_result($result,'No_Pls')),
                "No_Pli"=>rtrim(odbc_result($result,'No_Pli')),
                "NoPo"=>rtrim(odbc_result($result,'NoPo')),
                "POTransacid"=>rtrim(odbc_result($result,'POTransacid')),
                "EntryDate"=>rtrim(odbc_result($result,'EntryDate')),
                "Note"=>rtrim(odbc_result($result,'Note')),
                "supid"=>rtrim(odbc_result($result,'supid')),
                "userid"=>rtrim(odbc_result($result,'LastUserIDAccess')),
            ];
            }

        // $this->consol_war($datas);
          return $datas;
       }



       public function cetakprintpib($post){
                $DOTransacID = $this->test_input($post["POTransacid"]);
                $transnoHider = $this->test_input($post["No_Pls"]);

            $query="USP_CetakPakingListPIB'".$transnoHider."','".$DOTransacID."'";

             $result = $this->db->baca_sql2($query);
        $datas = [];
        while(odbc_fetch_row($result)){
            $this->No_Pli = rtrim(odbc_result($result,'No_Pli'));
            $this->NoPO = rtrim(odbc_result($result,'NoPO'));
            $this->EntryDate = rtrim(odbc_result($result,'EntryDate'));
            $this->Note = rtrim(odbc_result($result,'Note'));
            $this->supid = rtrim(odbc_result($result,'supid'));
            $this->Pib = rtrim(odbc_result($result,'Pib'));
            $this->Forwarder = rtrim(odbc_result($result,'Forwarder'));
            $this->Total = rtrim(odbc_result($result,'Total'));
            $this->CustAddress = rtrim(odbc_result($result,'CustAddress'));
            $this->CustTelpNo = rtrim(odbc_result($result,'CustTelpNo'));
            $this->CustFaxNo = rtrim(odbc_result($result,'CustFaxNo'));
            $this->CustEmail = rtrim(odbc_result($result,'CustEmail'));
            $this->SupperiID = rtrim(odbc_result($result,'SupperiID'));
            $this->SupperiName = rtrim(odbc_result($result,'SupperiName'));
            $this->id_bl_awb = rtrim(odbc_result($result,'id_bl_awb'));
            $datas[] =[
                "ItemNo"=>(int)rtrim(odbc_result($result,'ItemNo')),
                "Partid"=>rtrim(odbc_result($result,'Partid')),
                "PartName"=>rtrim(odbc_result($result,'PartName')),
                "Biaya_pib"=>number_format(rtrim(odbc_result($result,'Biaya_pib')),0, ',', ','),
                "Qty"=>number_format(rtrim(odbc_result($result,'Qty')),0, ',', ','),
                "Amount"=> number_format(rtrim(odbc_result($result,'Amount')), 0, '.', ','),
                "Komposisi"=>number_format(rtrim(odbc_result($result,'Komposisi')), 2, '.', '.'),
                "Komposisi_jm"=>rtrim(odbc_result($result,'Komposisi'))
             ];
            }
	
            $dataheader=[
                "ID_Hider"=>$transnoHider,
                "No_Pli"=>$this->No_Pli,
                "NoPO"=>$this->NoPO,
                "EntryDate"=>$this->EntryDate,
                "Note"=>$this->Note,
                "supid"=>$this->supid,
                "Pib"=>number_format($this->Pib, 2, '.', ','),
                "Forwarder"=>number_format($this->Forwarder, 2, '.', ','),
                "Total"=>number_format($this->Total, 2, '.', ','),
                "CustAddres"=>$this->CustAddress,
                "CustTelpNo"=>$this->CustTelpNo,
                "CustFaxNo"=>$this->CustFaxNo,
                "CustEmail"=>$this->CustEmail,
                "SupperiID"=>$this->SupperiID,
                "SupperiName"=>$this->SupperiName,
                "id_bl_awb"=>$this->id_bl_awb
            ];

            $fulldata =[
                "dataheader"=>$dataheader,
                "datadetail" => $datas
            ];
        // $this->consol_war($fulldata);
          return $fulldata;
       }

       //and pib


       //hasil pib 250522 by wardi
       
       public function CetakPrintHasilpib($post){
                $DOTransacID = $this->test_input($post["POTransacid"]);
                $transnoHider = $this->test_input($post["No_Pls"]);

            $query="USP_CetakPakingListHasilPIB'".$transnoHider."','".$DOTransacID."'";

             $result = $this->db->baca_sql2($query);
        $datas = [];
        while(odbc_fetch_row($result)){
            $this->No_Pli = rtrim(odbc_result($result,'No_Pli'));
            $this->NoPO = rtrim(odbc_result($result,'NoPO'));
            $this->EntryDate = rtrim(odbc_result($result,'EntryDate'));
            $this->Note = rtrim(odbc_result($result,'Note'));
            $this->supid = rtrim(odbc_result($result,'supid'));
            $this->Pib = rtrim(odbc_result($result,'Pib'));
            $this->Forwarder = rtrim(odbc_result($result,'Forwarder'));
            $this->Total = rtrim(odbc_result($result,'Total'));
            $this->CustAddress = rtrim(odbc_result($result,'CustAddress'));
            $this->CustTelpNo = rtrim(odbc_result($result,'CustTelpNo'));
            $this->CustFaxNo = rtrim(odbc_result($result,'CustFaxNo'));
            $this->CustEmail = rtrim(odbc_result($result,'CustEmail'));
            $this->SupperiID = rtrim(odbc_result($result,'SupperiID'));
            $this->SupperiName = rtrim(odbc_result($result,'SupperiName'));
            $this->id_bl_awb = rtrim(odbc_result($result,'id_bl_awb'));
            $datas[] =[
                "ItemNo"=>(int)rtrim(odbc_result($result,'ItemNo')),
                "Partid"=>rtrim(odbc_result($result,'Partid')),
                "PartName"=>rtrim(odbc_result($result,'PartName')),
                "Biaya_pib"=>number_format(rtrim(odbc_result($result,'Biaya_pib')),0, ',', ','),
                "hpp_awal"=>number_format(rtrim(odbc_result($result,'hpp_awal')),0, ',', ','),
                "hpp_akhir"=>number_format(rtrim(odbc_result($result,'hpp_akhir')),0, ',', ','),
                "Qty"=>number_format(rtrim(odbc_result($result,'Qty')),0, ',', ','),
                "Amount"=> number_format(rtrim(odbc_result($result,'Amount')), 0, '.', ','),
                "Komposisi"=>number_format(rtrim(odbc_result($result,'Komposisi')), 2, '.', '.'),
                "Komposisi_jm"=>rtrim(odbc_result($result,'Komposisi'))
             ];
            }
	
            $dataheader=[
                "ID_Hider"=>$transnoHider,
                "No_Pli"=>$this->No_Pli,
                "NoPO"=>$this->NoPO,
                "EntryDate"=>$this->EntryDate,
                "Note"=>$this->Note,
                "supid"=>$this->supid,
                "Pib"=>number_format($this->Pib, 2, '.', ','),
                "Forwarder"=>number_format($this->Forwarder, 2, '.', ','),
                "Total"=>number_format($this->Total, 2, '.', ','),
                "CustAddres"=>$this->CustAddress,
                "CustTelpNo"=>$this->CustTelpNo,
                "CustFaxNo"=>$this->CustFaxNo,
                "CustEmail"=>$this->CustEmail,
                "SupperiID"=>$this->SupperiID,
                "SupperiName"=>$this->SupperiName,
                "id_bl_awb"=>$this->id_bl_awb
            ];

            $fulldata =[
                "dataheader"=>$dataheader,
                "datadetail" => $datas
            ];
        // $this->consol_war($fulldata);
          return $fulldata;
       } 
       //and hasil pib 250522
}