<?php
date_default_timezone_set('Asia/Jakarta');
class TransakiKurModel extends Models
{
    private $tablehead = "[bmnpt].[dbo].POPAKINGLIST_KURS";
    private $table_fro = "[bmnpt].[dbo].FrowaderDetail";
    private $table_dtl = "[bmnpt].[dbo].POPAKINGLIST_KURSDETAIL";

    private $No_Pli;
    private $NoPO;
    private $EntryDate;
    private $Note;
    private $supid;
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
    private $total_qty;
    private $total_Price;
    private $total_USD;
    private $total_Kurs;
    private $total_Rp;
    private $total_KursAkhir;
    private $total_RpAkhir;
    private $total_Prosentase;
    private $currid;
    private $kurslanded;
    private $total_usd_only;
    private $total_idr_only;

    public function ProsesGetkur($post)
    {
        $nopo = $this->test_input($post["nopo"]);
        $totolpib = $this->test_input($post["totolpib"]);
        $query = "USP_TampildataKur '{$nopo}','{$totolpib}'";

        $result = $this->db->baca_sql2($query);
        $datas = [];

        while (odbc_fetch_row($result)) {
            $datas[] = [
                "DOTransacID"     => rtrim(odbc_result($result, 'DOTransacID')),
                "Partid"          => rtrim(odbc_result($result, 'Partid')),
                "PartName"        => rtrim(odbc_result($result, 'PartName')),
                "Unit"            => rtrim(odbc_result($result, 'Unit')),
                "Qty"             => number_format(rtrim(odbc_result($result, 'Qty')), 2, '.', ','),
                "Price"           => number_format(rtrim(odbc_result($result, 'Price')), 4, '.', ','),
                "Amount_USD"      => number_format(rtrim(odbc_result($result, 'Amount_USD')), 2, '.', ','),
                "Kurs"            => number_format(rtrim(odbc_result($result, 'Kurs')), 0),
                "Amount_Rp"       => number_format(rtrim(odbc_result($result, 'Amount_Rp')), 0, '.', ','),
                "kur_akhir"       => rtrim(odbc_result($result, 'kur_akhir')),
                "Amount_RpAkhir"  => number_format(rtrim(odbc_result($result, 'Amount_RpAkhir')), 2, '.', ','),
                "Total_Qty"       => number_format(rtrim(odbc_result($result, 'Total_Qty')), 2, '.', ','),
                "Total_amount_USD" => number_format(rtrim(odbc_result($result, 'Total_amount_USD')), 2, '.', ','),
                "Total_amount_Rp" => number_format(rtrim(odbc_result($result, 'Total_amount_Rp')), 0, '.', ','),
                "Total_amount_Rpakhir" => number_format(rtrim(odbc_result($result, 'Total_amount_Rpakhir')), 0, '.', ','),
                "Prosentase" => number_format(rtrim(odbc_result($result, 'Prosentase')), 2, '.', ','),
                "Hpp_Awal"       => rtrim(odbc_result($result, 'Hpp_Awal')),
                "Hpp_Akhir"      => rtrim(odbc_result($result, 'Hpp_Akhir')),
                "Selisih_Hpp"    => rtrim(odbc_result($result, 'Selisih_Hpp')),
                "Amount_RpAkhirTampil" => number_format(rtrim(odbc_result($result, 'Amount_RpAkhir')), 0, '.', ','),
                "Hpp_AkhirTampil" => number_format(rtrim(odbc_result($result, 'Hpp_Akhir')), 0, '.', ','),
                "Selisih_HppTampil" => number_format(rtrim(odbc_result($result, 'Selisih_Hpp')), 0, '.', ','),
                "kur_akhirtampil" => number_format(rtrim(odbc_result($result, 'kur_akhir')), 0),

            ];
        }

        return $datas;
    }


    private function CekHeadr($transo)
    {
        $query = "SELECT DISTINCT No_Pls FROM {$this->tablehead} WHERE No_Pls = '{$transo}'";
        $result = $this->db->baca_sql2($query);
        $rows = odbc_fetch_array($result);
        return $rows > 0 ? 1 : 0;
    }


    public function SaveData($post)
    {
        $dataheader     = $post["dataheader"];
        $detailforwader = $post["detailforwader"];
        $detailkurdata  = $post["detailkurdata"];
        $transo         = $dataheader["transo"];

        $cekhead = $this->CekHeadr($transo);

        if ($cekhead == 0) {
            if ($this->simpadataHider($dataheader) == 1) {
                if ($this->SimpandetaiForwader($transo, $detailforwader) == 1) {
                    return $this->Simpandetailkurdata($transo, $detailkurdata);
                }

                return ['nilai' => 0, 'error' => 'Gagal Simpan Data di Detail Forwader'];
            }
        }

        return ['nilai' => 0, 'error' => 'Gagal Simpan Data, Header sudah ada'];
    }


    private function Simpandetailkurdata($transo, $detailkurdata)
    {
        $success = true;
        $no = 1;

        foreach ($detailkurdata as $item) {
            $query = "
                INSERT INTO {$this->table_dtl} (
                    No_Pls, ItemNo, Partid, PartName, satuan, Qty, Price,
                    Amount_USD, Kurs, Amount_Rp, Kurs_Akhir, Amount_Akhir,
                    Hpp_Awal,Hpp_Akhir,Selisih_Hpp,Selisih_Hpp_b
                ) VALUES (
                    '{$transo}', '{$no}',
                    '{$this->test_input($item["partid"])}',
                    '{$this->test_input($item["partname"])}',
                    '{$this->test_input($item["unit"])}',
                    '{$this->test_input($item["qty"])}',
                    '{$this->test_input($item["price"])}',
                    '{$this->test_input($item["amount_usd"])}',
                    '{$this->test_input($item["kurs"])}',
                    '{$this->test_input($item["amount_rp"])}',
                    '{$this->test_input($item["kurs_akhir"])}',
                    '{$this->test_input($item["amount_akhir"])}',
                    '{$this->test_input($item["Hpp_Awal"])}',
                    '{$this->test_input($item["Hpp_Akhir"])}',
                    '{$this->test_input($item["Selisih_Hpp"])}',
                    '{$this->test_input($item["Selisih_Hpp"])}'

                )
            ";

            if (!$this->db->baca_sql($query)) {
                $success = false;
            }

            $no++;
        }
        $this->UpdateItemNo_KursDetail($transo);
        return [
            'nilai' => $success ? 1 : 0,
            'error' => $success ? 'Berhasil Simpan Data' : 'Gagal Simpan Data'
        ];
    }

    private function SimpandetaiForwader($transo, $detailforwader)
    {
        $success = true;

        foreach ($detailforwader as $item) {
            $noPls   = $transo;
            $msID    = $this->test_input($item["msID"]);
            $rumus   = $this->test_input($item["rumus"]);
            $hitungan = $this->test_input($item["hitungan"]);
            $amount  = $this->test_input($item["amount"]);
            $IDKategori = $this->test_input($item["IDKategori"]);
            // ✅ Cek apakah data sudah ada berdasarkan No_Pls dan msID
            $cekQuery = "
            SELECT COUNT(*) as jumlah 
            FROM {$this->table_fro} 
            WHERE No_Pls = '{$noPls}' AND msID = '{$msID}'
        ";

            $cekResult = $this->db->baca_sql($cekQuery);
            $row = odbc_fetch_array($cekResult);

            if ($row["jumlah"] == 0) {
                // ✅ Hanya insert jika data belum ada
                $query = "
                INSERT INTO {$this->table_fro} (No_Pls, msID, rumus, hitungan, amount,IDKategori)
                VALUES (
                    '{$noPls}',
                    '{$msID}',
                    '{$rumus}',
                    '{$hitungan}',
                    '{$amount}',
                    '{$IDKategori}'
                )
            ";

                if (!$this->db->baca_sql2($query)) {
                    $success = false;
                }
            }
        }

        return $success ? 1 : 0;
    }



    private function simpadataHider($header)
    {


        $dateTime = DateTime::createFromFormat('d/m/Y', $this->test_input($header["tanggal"]));
        $formattedDate = $dateTime ? $dateTime->format('Y-m-d H:i:s') : '';

        $query = "
            EXEC USP_INSERT_POAKINGLIST_KURS_Header
            '{$this->test_input($header["transo"])}',
            '{$this->test_input($header["idpackinglist"])}',
            '{$this->test_input($header["suplieid"])}',
            '{$this->test_input($header["nodo"])}',
            '{$this->test_input($header["nopo"])}',
            '{$formattedDate}',
            {$this->sql_escape_odbc($header["keterangan"])},
            '{$_SESSION['login_user']}',
            '{$this->test_input($header["pib"])}',
            '{$this->test_input($header["forwarder"])}',
            '{$this->test_input($header["total"])}',
            '{$this->test_input($header["id_bl_awb"])}',
            '{$this->test_input($header["total_usd"])}',
            '{$this->test_input($header["total_rp"])}',
            '{$this->test_input($header["total_amountakhir"])}',
            '{$this->test_input($header["total_Prosentase"])}',
            '{$this->test_input($header["note"])}'
        ";

        //$this->consol_war($query);
        return $this->db->baca_sql2($query) ? 1 : 0;
    }


    private function UpdateItemNo_KursDetail($transo)
    {
        $query = "sp_UpdateItemNo_KursDetail'{$transo}'";
        $result = $this->db->baca_sql2($query);
        $cek = $result ? 0 : 1;

        // Respon status
        if ($cek === 0) {
            $status['nilai'] = 1;
            $status['error'] = "Data Berhasil Update ItemNo";
        } else {
            $status['nilai'] = 0;
            $status['error'] = "Data Gagal Update ItemNo";
        }

        return $status;
    }

    public function ListData($post)
    {
        $userid = $this->test_input($post["userid"]);
        $status = ($userid == "wardi" || $userid == "herman") ? "Y" : "N";
        $tahun = $this->test_input($post["tahun"]);

        $query = "USP_TampilListKurPakingList '{$status}', '{$tahun}', '{$userid}'";
        $result = $this->db->baca_sql2($query);

        $datas = [];
        while (odbc_fetch_row($result)) {
            $datas[] = [
                "No_Pls"      => $this->getOdbcValue($result, 'No_Pls'),
                "No_Pli"      => $this->getOdbcValue($result, 'No_Pli'),
                "NoPo"        => $this->getOdbcValue($result, 'NoPo'),
                "id_bl_awb"   => $this->getOdbcValue($result, 'id_bl_awb'),
                "POTransacid" => $this->getOdbcValue($result, 'POTransacid'),
                "EntryDate"   => $this->getOdbcValue($result, 'EntryDate'),
                "Note"        => $this->getOdbcValue($result, 'Note'),
                "supid"       => $this->getOdbcValue($result, 'supid'),
                "userid"      => $this->getOdbcValue($result, 'userid'),
                "Totaldetail" => (int) $this->getOdbcValue($result, 'Totaldetail'),
                "Pib"         => $this->formatNumberOrEmpty($this->getOdbcValue($result, 'Pib')),
                "Forwarder"   => $this->formatNumberOrEmpty($this->getOdbcValue($result, 'Forwarder')),
                "Total"       => $this->formatNumberOrEmpty($this->getOdbcValue($result, 'Total')),
                "Status"      => $status,
                "Note2"      => $this->getOdbcValue($result, 'Note2'),
            ];
        }

        return $datas;
    }


    public function ProsesGetkurEdit($post)
    {
        $No_Pls = $this->test_input($post["transnoHider"]);
        $query = "SELECT a.Partid, a.PartName, a.satuan AS Unit, a.Qty, a.Price, a.Amount_USD, a.Kurs, a.Amount_Rp,a.Kurs_Akhir, a.Amount_Akhir,
         ISNULL(a.Hpp_Awal,0) AS Hpp_Awal, ISNULL(a.Hpp_Akhir,0) AS Hpp_Akhir, ISNULL(a.Selisih_Hpp,0) AS Selisih_Hpp,
        ISNULL(b.total_usd, 0) AS total_usd,
        ISNULL(b.total_rp, 0) AS total_rp,
        ISNULL(b.total_amountakhir, 0) AS total_amountakhir,
        ISNULL(b.total_Prosentase, 0) AS total_Prosentase
        FROM {$this->table_dtl} as a
        LEFT JOIN {$this->tablehead} as b
        ON b.No_Pls =a.No_Pls
        WHERE a.No_Pls = '{$No_Pls}'";

        //$this->consol_war($query);
        $result = $this->db->baca_sql2($query);

        $datas = [];


        while (odbc_fetch_row($result)) {
            $qty          = rtrim(odbc_result($result, 'Qty'));
            $price        = rtrim(odbc_result($result, 'Price'));
            $amount_usd   = rtrim(odbc_result($result, 'Amount_USD'));
            $amount_rp    = rtrim(odbc_result($result, 'Amount_Rp'));
            $kurs         = rtrim(odbc_result($result, 'Kurs'));
            $kurs_akhir   = rtrim(odbc_result($result, 'Kurs_Akhir'));
            $amount_akhir = rtrim(odbc_result($result, 'Amount_Akhir'));
            $total_usd    = rtrim(odbc_result($result, 'total_usd'));
            $total_rp     = rtrim(odbc_result($result, 'total_rp'));
            $Hpp_Awal     = rtrim(odbc_result($result, 'Hpp_Awal'));
            $Hpp_Akhir    = rtrim(odbc_result($result, 'Hpp_Akhir'));
            $Selisih_Hpp  = rtrim(odbc_result($result, 'Selisih_Hpp'));

            $total_amountakhir     = rtrim(odbc_result($result, 'total_amountakhir'));
            $total_Prosentase     = rtrim(odbc_result($result, 'total_Prosentase'));


            $datas[] = [
                "Partid"         => rtrim(odbc_result($result, 'Partid')),
                "PartName"       => rtrim(odbc_result($result, 'PartName')),
                "Unit"           => rtrim(odbc_result($result, 'Unit')),
                "Qty"            => number_format($qty, 2, '.', ','),
                "Price"          => number_format($price, 4, '.', ','),
                "Amount_USD"     => number_format($amount_usd, 2, '.', ','),
                "Kurs"           => number_format($kurs, 0),
                "Amount_Rp"      => number_format($amount_rp, 0, '.', ','),
                "kur_akhir"      => $kurs_akhir,
                "Amount_RpAkhir" => number_format($amount_akhir, 2, '.', ','),
                "Total_amount_USD" => number_format($total_usd, 2, '.', ','),
                "Total_amount_Rp" => number_format($total_rp, 0, '.', ','),
                "Total_amount_Rpakhir" => number_format($total_amountakhir, 0, '.', ','),
                "Prosentase"           => number_format($total_Prosentase, 2, '.', ','),
                "Hpp_Awal"      => $Hpp_Awal,
                "Hpp_Akhir"     => $Hpp_Akhir,
                "Selisih_Hpp"   => $Selisih_Hpp,
                "Amount_RpAkhirTampil" => number_format($amount_akhir, 0, '.', ','),
                "Hpp_AkhirTampil" => number_format($Hpp_Akhir, 0, '.', ','),
                "Selisih_HppTampil" => number_format($Selisih_Hpp, 0, '.', ','),
                "kur_akhirtampil" => number_format($kurs_akhir, 0, '.', ','),

            ];
        }



        return $datas;
    }


    private function getOdbcValue($result, $field)
    {
        return rtrim(odbc_result($result, $field));
    }

    private function formatNumberOrEmpty($value)
    {
        return (floatval($value) == 0) ? "" : number_format($value, 0, '.', ',');
    }



    public function UpdateData($post)
    {


        $dataheader     = $post["dataheader"];
        $detailforwader = $post["detailforwader"];
        $detailkurdata  = $post["detailkurdata"];
        $transo         = $dataheader["transo"];




        if ($this->updatedataHider($dataheader) == 1) {
            if ($this->UpdatedetaiForwader($transo, $detailforwader) == 1) {
                return $this->Updatedetailkurdata($transo, $detailkurdata);
            }

            return ['nilai' => 0, 'error' => 'Gagal Update Data'];
        }
    }

    private function updatedataHider($header)
    {
        $dateTime = DateTime::createFromFormat('d/m/Y', $this->test_input($header["tanggal"]));
        $formattedDate = $dateTime ? $dateTime->format('Y-m-d H:i:s') : '';
        $dateupdate    = date('Y-m-d H:i:s');
        $query = "
            EXEC USP_UPDATE_POAKINGLIST_KURS_Header
            '{$this->test_input($header["transo"])}',
            '{$this->test_input($header["idpackinglist"])}',
            '{$this->test_input($header["suplieid"])}',
            '{$this->test_input($header["nodo"])}',
            '{$this->test_input($header["nopo"])}',
            '{$formattedDate}',
            {$this->sql_escape_odbc($header["keterangan"])},
            '{$_SESSION['login_user']}',
            '{$this->test_input($header["pib"])}',
            '{$this->test_input($header["forwarder"])}',
            '{$this->test_input($header["total"])}',
            '{$this->test_input($header["id_bl_awb"])}',
            '{$dateupdate}',
            '{$this->test_input($header["total_usd"])}',
            '{$this->test_input($header["total_rp"])}',
            '{$this->test_input($header["total_amountakhir"])}',
            '{$this->test_input($header["total_Prosentase"])}'
        ";


        //$this->consol_war($query);
        return $this->db->baca_sql2($query) ? 1 : 0;
    }

    private function UpdatedetaiForwader($transo, $detailforwader)
    {
        // Jika array detail kosong, tidak ada yang perlu di-update
        if (count($detailforwader) === 0) {
            return 1;
        }


        $success = true;

        // Simpan ulang data berdasarkan detail baru
        foreach ($detailforwader as $item) {
            $query = "
                    UPDATE $this->table_fro SET  rumus ='{$this->test_input($item["rumus"])}', hitungan='{$this->test_input($item["hitungan"])}', 
                    amount='{$this->test_input($item["amount"])}',IDKategori='{$this->test_input($item["IDKategori"])}'
                    WHERE No_Pls ='{$transo}'AND msID='{$this->test_input($item["msID"])}'
                ";

            if (!$this->db->baca_sql2($query)) {
                $success = false;
            }
        }

        return $success ? 1 : 0;
    }




    private function Updatedetailkurdata($transo, $detailkurdata)
    {

        // Cek apakah proses delete berhasil
        $deleteStatus = $this->DeleteDetailKurdata($transo);

        if ($deleteStatus['nilai'] === 0) {
            // Jika delete gagal, langsung hentikan proses
            return [
                'nilai' => 0,
                'error' => 'Gagal Delete Data. Simpan dibatalkan.'
            ];
        }

        $success = true;
        $no = 1;

        foreach ($detailkurdata as $item) {
            $query = "
                INSERT INTO {$this->table_dtl} (
                    No_Pls, ItemNo, Partid, PartName, satuan, Qty, Price,
                    Amount_USD, Kurs, Amount_Rp, Kurs_Akhir, Amount_Akhir,
                    Hpp_Awal,Hpp_Akhir,Selisih_Hpp,Selisih_Hpp_b
                ) VALUES (
                    '{$transo}', '{$no}',
                    '{$this->test_input($item["partid"])}',
                    '{$this->test_input($item["partname"])}',
                    '{$this->test_input($item["unit"])}',
                    '{$this->test_input($item["qty"])}',
                    '{$this->test_input($item["price"])}',
                    '{$this->test_input($item["amount_usd"])}',
                    '{$this->test_input($item["kurs"])}',
                    '{$this->test_input($item["amount_rp"])}',
                    '{$this->test_input($item["kurs_akhir"])}',
                    '{$this->test_input($item["amount_akhir"])}',
                    '{$this->test_input($item["Hpp_Awal"])}',
                    '{$this->test_input($item["Hpp_Akhir"])}',
                    '{$this->test_input($item["Selisih_Hpp"])}',
                    '{$this->test_input($item["Selisih_Hpp"])}'
                )
            ";

            if (!$this->db->baca_sql($query)) {
                $success = false;
            }

            $no++;
        }
        $this->UpdateItemNo_KursDetail($transo);
        return [
            'nilai' => $success ? 1 : 0,
            'error' => $success ? 'Berhasil Update Data' : 'Gagal Update Data'
        ];
    }


    private function DeleteDetailKurdata($transo)
    {
        $query = "DELETE FROM {$this->table_dtl} WHERE No_Pls = '{$transo}'";
        $result = $this->db->baca_sql2($query);
        $cek = $result ? 0 : 1;

        // Respon status
        if ($cek === 0) {
            $status['nilai'] = 1;
            $status['error'] = "Data Berhasil Delete";
        } else {
            $status['nilai'] = 0;
            $status['error'] = "Data Gagal Delete";
        }


        return $status;
    }



    public function DeleteAll($post)
    {
        $transo         = $post["transnoHider"];
        $success = true;

        $query = "DELETE FROM  $this->table_fro WHERE No_Pls='" . $transo . "' ";
        $query .= "DELETE FROM  $this->table_dtl WHERE No_Pls='" . $transo . "' ";
        $query .= "DELETE FROM  $this->tablehead WHERE No_Pls='" . $transo . "' ";



        if (!$this->db->baca_sql($query)) {
            $success = false;
        }

        return [
            'nilai' => $success ? 1 : 0,
            'error' => $success ? 'Berhasil Hapus Data' : 'Gagal Hapus Data'
        ];
    }


    public function PostingData($post)
    {

        $transo = $this->test_input($post["transnoHider"]);
        $dataposting    = date('Y-m-d H:i:s');
        $success = true;

        $query = "UPDATE $this->tablehead SET UserPosting='{$_SESSION['login_user']}',FlagPosting='Y', DatePosting='{$dataposting}'
        WHERE  No_Pls='" . $transo . "'
        ";
        if (!$this->db->baca_sql($query)) {
            $success = false;
        }

        return [
            'nilai' => $success ? 1 : 0,
            'error' => $success ? 'Berhasil Posting Data' : 'Gagal Posting Data'
        ];
    }



    public function cetakprint($post)
    {

        $DOTransacID = $this->test_input($post["POTransacid"]);
        $transnoHider = $this->test_input($post["No_Pls"]);

        $query = "USP_CetakPakingListKurs '{$transnoHider}','{$DOTransacID}'";

        //$this->consol_war($query);
        $datas = [];
        $result = $this->db->baca_sql2($query);
        while (odbc_fetch_row($result)) {
            $this->No_Pli           = rtrim(odbc_result($result, 'No_Pli'));
            $this->NoPO             = rtrim(odbc_result($result, 'NoPO'));
            $this->EntryDate        = rtrim(odbc_result($result, 'EntryDate'));
            $this->Note             = rtrim(odbc_result($result, 'Note'));
            $this->supid            = rtrim(odbc_result($result, 'supid'));
            $this->Pib              = rtrim(odbc_result($result, 'Pib'));
            $this->Forwarder        = rtrim(odbc_result($result, 'Forwarder'));
            $this->Total            = rtrim(odbc_result($result, 'Total'));
            $this->CustAddress      = rtrim(odbc_result($result, 'CustAddress'));
            $this->CustTelpNo       = rtrim(odbc_result($result, 'CustTelpNo'));
            $this->CustFaxNo        = rtrim(odbc_result($result, 'CustFaxNo'));
            $this->CustEmail        = rtrim(odbc_result($result, 'CustEmail'));
            $this->SupperiID        = rtrim(odbc_result($result, 'SupperiID'));
            $this->SupperiName      = rtrim(odbc_result($result, 'SupperiName'));
            $this->id_bl_awb        = rtrim(odbc_result($result, 'id_bl_awb'));
            $this->total_qty        = number_format(rtrim(odbc_result($result, 'total_qty')), 0, ',', ',');
            $this->total_Price      = number_format(rtrim(odbc_result($result, 'total_Price')), 0, ',', ',');
            $this->total_USD        = number_format(rtrim(odbc_result($result, 'total_USD')), 0, ',', ',');
            $this->total_Kurs       = number_format(rtrim(odbc_result($result, 'total_Kurs')), 0, '.', '.');
            $this->total_Rp         = number_format(rtrim(odbc_result($result, 'total_Rp')), 0, ',', ',');
            $this->total_KursAkhir  = number_format(rtrim(odbc_result($result, 'total_KursAkhir')), 0, '.', '.');
            $this->total_RpAkhir    = number_format(rtrim(odbc_result($result, 'total_RpAkhir')), 0, ',', ',');
            $this->total_Prosentase = number_format(rtrim(odbc_result($result, 'total_Prosentase')), 2, '.', '.');
            $this->kurslanded       = number_format(rtrim(odbc_result($result, 'kurslanded')), 0, '.', '.');
            $this->total_usd_only   = number_format(rtrim(odbc_result($result, 'total_usd_only')), 0, '.', ',');
            $this->total_idr_only    = number_format(rtrim(odbc_result($result, 'total_idr_only')), 0, '.', ',');
            $this->currid           = rtrim(odbc_result($result, 'currid'));
            $Hpp_Akhir = round(rtrim(odbc_result($result, 'Hpp_Akhir')), 0);
            $Hpp_Awal = round(rtrim(odbc_result($result, 'Hpp_Awal')), 0);

            $datas[] = [
                "ItemNo"        => (int)rtrim(odbc_result($result, 'ItemNo')),
                "Partid"        => rtrim(odbc_result($result, 'Partid')),
                "PartName"      => rtrim(odbc_result($result, 'PartName')),
                "satuan"        => rtrim(odbc_result($result, 'satuan')),
                "qty"           => number_format(rtrim(odbc_result($result, 'Qty')), 0, ',', ','),
                "Price"         => number_format(rtrim(odbc_result($result, 'Price')), 4, '.', '.'),
                "Amount_USD"    => number_format(rtrim(odbc_result($result, 'Amount_USD')), 0, '.', ','),
                "Amount_Rp"     => number_format(rtrim(odbc_result($result, 'Amount_Rp')), 0, '.', ','),
                "Kurs"          => number_format(rtrim(odbc_result($result, 'Kurs')), 0, '.', '.'),
                "Kurs_Akhir"    => number_format(rtrim(odbc_result($result, 'Kurs_Akhir')), 0, '.', '.'),
                "Amount_Akhir"  => number_format(rtrim(odbc_result($result, 'Amount_Akhir')), 0, ',', ','),
                "Hpp_Awal"      => number_format(rtrim(odbc_result($result, 'Hpp_Awal')), 0, ',', ','),
                "Hpp_Akhir"     => number_format(rtrim(odbc_result($result, 'Hpp_Akhir')), 0, ',', ','),
                "Selisih_Hpp"   => number_format($Hpp_Akhir - $Hpp_Awal, 0, ',', '.'),
            ];
        }

        $dataheader = [
            "ID_Hider"          => $transnoHider,
            "No_Pli"            => $this->No_Pli,
            "NoPO"              => $this->NoPO,
            "EntryDate"         => $this->EntryDate,
            "Note"              => $this->Note,
            "supid"             => $this->supid,
            "Pib"               => number_format($this->Pib, 0, '.', ','),
            "Forwarder"         => number_format($this->Forwarder, 0, '.', ','),
            "Total"             => number_format($this->Total, 0, '.', ','),
            "CustAddres"        => $this->CustAddress,
            "CustTelpNo"        => $this->CustTelpNo,
            "CustFaxNo"         => $this->CustFaxNo,
            "CustEmail"         => $this->CustEmail,
            "SupperiID"         => $this->SupperiID,
            "SupperiName"       => $this->SupperiName,
            "id_bl_awb"         => $this->id_bl_awb,
            "total_qty"         => $this->total_qty,
            "total_Price"       => $this->total_Price,
            "total_USD"         => $this->total_USD,
            "total_Kurs"        => $this->total_Kurs,
            "total_Rp"          => $this->total_Rp,
            "total_KursAkhir"   => $this->total_KursAkhir,
            "total_RpAkhir"     => $this->total_RpAkhir,
            "total_Prosentase"  => $this->total_Prosentase,
            "currid"            => $this->currid,
            "kurslanded"        => $this->kurslanded,
            "total_usd_only"    => $this->total_usd_only,
            "total_idr_only"     => $this->total_idr_only,
        ];

        $fulldata = [
            "dataheader" => $dataheader,
            "datadetail" => $datas
        ];
        //$this->consol_war($fulldata);
        return $fulldata;
    }


    public function ListSudahPosting($post)
    {
        $status = "";

        $userid = $this->test_input($post["userid"]);

        if ($userid == "wardi" || $userid == "herman") {
            $status = "Y";
        } else {
            $status = "N";
        }
        $tahun = $this->test_input($post["tahun"]);

        $query = "USP_List_KursSudahPosting '" . $status . "','" . $tahun . "','" . $userid . "' ";

        // $this->consol_war($query);

        $result = $this->db->baca_sql2($query);
        $datas = [];
        while (odbc_fetch_row($result)) {
            // "No_Pls,No_Pli,NoPo,POTransacid,EntryDate,Note,supid,userid,Totaldetail";
            $datas[] = [
                "No_Pls"     => rtrim(odbc_result($result, 'No_Pls')),
                "No_Pli"     => rtrim(odbc_result($result, 'No_Pli')),
                "NoPo"       => rtrim(odbc_result($result, 'NoPo')),
                "id_bl_awb"  => rtrim(odbc_result($result, 'id_bl_awb')),
                "POTransacid" => rtrim(odbc_result($result, 'POTransacid')),
                "EntryDate"  => rtrim(odbc_result($result, 'EntryDate')),
                "Note"       => rtrim(odbc_result($result, 'Note')),
                "supid"      => rtrim(odbc_result($result, 'supid')),
                "userid"     => rtrim(odbc_result($result, 'userid')),
                "Totaldetail" => (int)rtrim(odbc_result($result, 'Totaldetail')),
                "Pib"        => number_format(rtrim(odbc_result($result, 'Pib')), 2, '.', ','),
                "Forwarder"  => number_format(rtrim(odbc_result($result, 'Forwarder')), 2, '.', ','),
                "Total"      => number_format(rtrim(odbc_result($result, 'Total')), 2, '.', ','),
                "UserPosting"     => rtrim(odbc_result($result, 'UserPosting')),
                "DatePosting"     => rtrim(odbc_result($result, 'DatePosting')),
                "Note2"     => rtrim(odbc_result($result, 'Note2')),
            ];
        }

        //$this->consol_war($datas);
        return $datas;
    }


    public function ListLaporan($post)
    {
        $tgl_from = $post["tgl_from"];
        $date_from = $this->ChangeDate($tgl_from);

        $tgl_to   = $post["tgl_to"];
        $date_to = $this->ChangeDate($tgl_to) . " 23:59:59";

        $file = " No_Pls,No_Pli,NoPo,POTransacid,EntryDate,Note,supid,LastUserIDAccess ";
        $table = $this->tablehead;
        $table .= " WHERE  EntryDate BETWEEN '" . $date_from . "' AND  '" . $date_to . "'  AND FlagPosting='Y'";
        //$table .= $this->orderby("ItemNo");
        $query = $this->select($file, $table);

        $result = $this->db->baca_sql2($query);

        $datas = [];
        while (odbc_fetch_row($result)) {
            $datas[] = [
                "No_Pls" => rtrim(odbc_result($result, 'No_Pls')),
                "No_Pli" => rtrim(odbc_result($result, 'No_Pli')),
                "NoPo" => rtrim(odbc_result($result, 'NoPo')),
                "POTransacid" => rtrim(odbc_result($result, 'POTransacid')),
                "EntryDate" => rtrim(odbc_result($result, 'EntryDate')),
                "Note" => rtrim(odbc_result($result, 'Note')),
                "supid" => rtrim(odbc_result($result, 'supid')),
                "userid" => rtrim(odbc_result($result, 'LastUserIDAccess')),
            ];
        }

        // $this->consol_war($datas);
        return $datas;
    }


    private function ChangeDate($tanggal)
    {
        $dateTime = DateTime::createFromFormat('d/m/Y', $tanggal);
        $formattedDate = $dateTime->format('Y-m-d');
        return $formattedDate;
    }
}
