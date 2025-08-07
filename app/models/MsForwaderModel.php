<?php

class MsForwaderModel  extends  Models
{
    private $table_ms = "[bmnpt].[dbo].msForwader";
    private $table_ktg = "[bmnpt].[dbo].MasterKategori";
    private $table_fro = "[bmnpt].[dbo].FrowaderDetail";
    private $table_frofinal = "[bmnpt].[dbo].FrowaderDetail_Temporary";
    public function SaveData($post)
    {

        $userid = $_SESSION['login_user'];
        $keterangan = $this->test_input($post["keterangan"]);
        $rumus      = $this->test_input($post["rumus"]);
        $hitungan   = $this->test_input($post["hitungan"]);
        $idkategori = $this->test_input($post["idkategori"]);

        $query = "
            DECLARE @kategori VARCHAR(150);
            SET @kategori = (
                SELECT TOP 1 kategori 
                FROM $this->table_ktg
                WHERE IDKategori = '" . $idkategori . "'
            );
            INSERT INTO $this->table_ms (
                keterangan, rumus, hitungan, user_input, IDKategori, kategori
            ) VALUES (
                '" . $keterangan . "',
                '" . $rumus . "',
                '" . $hitungan . "',
                '" . $userid . "',
                '" . $idkategori . "',
                @kategori
            );
        ";
        //$this->consol_war($query);

        $cek = 0;
        $result = $this->db->baca_sql($query);

        if (!$result) {
            $cek++;
        }

        if ($cek === 0) {
            $status = [
                'nilai' => 1,
                'error' => 'Data Berhasil Di Simpan'
            ];
        } else {
            $status = [
                'nilai' => 0,
                'error' => 'Data Gagal Di Simpan'
            ];
        }

        return $status;
    }


    public function TampilData()
    {
        $query = "SELECT msID,keterangan,rumus,hitungan,status_aktif,user_input,IDKategori,kategori FROM $this->table_ms ORDER BY  IDKategori,msID ASC  ";

        // $this->consol_war($query);
        $result = $this->db->baca_sql2($query);
        $datas = [];

        while (odbc_fetch_row($result)) {
            $datas[] = [
                "msID"          => rtrim(odbc_result($result, 'msID')),
                "keterangan"    => rtrim(odbc_result($result, 'keterangan')),
                "rumus"         => rtrim(odbc_result($result, 'rumus')),
                "hitungan"      => rtrim(odbc_result($result, 'hitungan')),
                "status_aktif"  => rtrim(odbc_result($result, 'status_aktif')),
                "user_input"    => rtrim(odbc_result($result, 'user_input')),
                "IDKategori"    => rtrim(odbc_result($result, 'IDKategori')),
                "kategori"      => rtrim(odbc_result($result, 'kategori')),




            ];
        }

        return $datas;
    }


    public function Updatedata($post)
    {

        $userid = $_SESSION['login_user'];
        $keterangan = $this->test_input($post["keterangan"]);
        $rumus      = $this->test_input($post["rumus"]);
        $hitungan   = $this->test_input($post["hitungan"]);
        $aktif      = $this->test_input($post["aktif"]);
        $msid       = $this->test_input($post["msid"]);
        $idkategori  = $this->test_input($post["idkategori"]);
        $dateedit   = date("Y-m-d H:i:s");
        $query = "
         DECLARE @kategori VARCHAR(150);
            SET @kategori = (
                SELECT TOP 1 kategori 
                FROM $this->table_ktg 
                WHERE IDKategori = '" . $idkategori . "'
            );
        UPDATE $this->table_ms SET keterangan='" . $keterangan . "',rumus='" . $rumus . "',hitungan='" . $hitungan . "',status_aktif='" . $aktif . "',user_edit='" . $userid . "',
            date_edit='" . $dateedit . "',IDKategori='" . $idkategori . "',kategori=@kategori
            WHERE msID='" . $msid . "'
            ";

        // $this->consol_war($query);
        $result = $this->db->baca_sql($query);
        $status = [];

        if ($result) {
            $status['nilai'] = 1;
            $status['error'] = "Data Berhasil DiUpdated";
        } else {
            $status['nilai'] = 0;
            $status['error'] = "Data Gagal DiUpdated";
        }

        return $status;
    }


    public function TampilForwader()
    {
        $query = "SELECT msID,keterangan,rumus,hitungan,IDKategori,kategori FROM $this->table_ms WHERE status_aktif ='Y' ORDER BY  IDKategori,msID ASC";
        $result = $this->db->baca_sql2($query);
        $datas = [];
        while (odbc_fetch_row($result)) {
            $datas[] = [
                "msID"          => rtrim(odbc_result($result, 'msID')),
                "keterangan"    => rtrim(odbc_result($result, 'keterangan')),
                "rumus"         => rtrim(odbc_result($result, 'rumus')),
                "hitungan"      => rtrim(odbc_result($result, 'hitungan')),
                "IDKategori"    => rtrim(odbc_result($result, 'IDKategori')),
                "kategori"       => rtrim(odbc_result($result, 'kategori')),

            ];
        }

        return $datas;
    }

    public function TampilForwaderEdit($post)
    {
        $transnoHider = $this->test_input($post["transnoHider"]);
        $query = "usp_GetForwaderEditByID '" . $transnoHider . "'";

        $result = $this->db->baca_sql2($query);
        $datas = [];
        while (odbc_fetch_row($result)) {
            $datas[] = [
                "msID"          => rtrim(odbc_result($result, 'msID')),
                "keterangan"    => rtrim(odbc_result($result, 'keterangan')),
                "rumus"         => rtrim(odbc_result($result, 'rumus')),
                "hitungan"      => rtrim(odbc_result($result, 'hitungan')),
                //"amount"       =>rtrim(odbc_result($result,'amount')),
                "amount"       => number_format(rtrim(odbc_result($result, 'amount')), 0, '.', ','),
                "total_hitungan"    => number_format(rtrim(odbc_result($result, 'total_hitungan')), 0, '.', ','),
                "total_rumus"       => number_format(rtrim(odbc_result($result, 'total_rumus')), 0, '.', ','),
                "IDKategori"    => rtrim(odbc_result($result, 'IDKategori')),
                "kategori"       => rtrim(odbc_result($result, 'kategori')),

            ];
        }

        $datafull = [
            "header" => $datas,
            "detaildata" => $this->Detaildata($post)
        ];

        return $datafull;
    }



    public function TampilForwaderEditFinal($post)
    {
        $transnoHider = $this->test_input($post["transnoHider"]);
        $query = "usp_GetForwaderEditFinalByID '" . $transnoHider . "'";
        $result = $this->db->baca_sql2($query);
        $datas = [];
        while (odbc_fetch_row($result)) {
            $datas[] = [
                "msID"          => rtrim(odbc_result($result, 'msID')),
                "keterangan"    => rtrim(odbc_result($result, 'keterangan')),
                "rumus"         => rtrim(odbc_result($result, 'rumus')),
                "hitungan"      => rtrim(odbc_result($result, 'hitungan')),
                //"amount"       =>rtrim(odbc_result($result,'amount')),
                "amount"       => number_format(rtrim(odbc_result($result, 'amount')), 0, '.', ','),
                "total_hitungan"    => number_format(rtrim(odbc_result($result, 'total_hitungan')), 0, '.', ','),
                "total_rumus"       => number_format(rtrim(odbc_result($result, 'total_rumus')), 0, '.', ','),
                "IDKategori"    => rtrim(odbc_result($result, 'IDKategori')),
                "kategori"       => rtrim(odbc_result($result, 'kategori')),

            ];
        }

        $datafull = [
            "header" => $datas,
            "detaildata" => $this->DetaildataFinal($post)
        ];

        return $datafull;
    }


    private function Detaildata($post)
    {

        $no_p = $this->test_input($post["transnoHider"]);

        $query = "SELECT 
            MK.kategori,
            FD.IDKategori,
            SUM(FD.amount) AS TotalAmount
        FROM 
           $this->table_fro FD
        JOIN 
            $this->table_ktg MK 
            ON FD.IDKategori = MK.IDKategori
        WHERE 
            FD.No_Pls = '{$no_p}'
        GROUP BY 
            MK.kategori, FD.IDKategori
        ORDER BY 
            MK.kategori ASC;";
        $result = $this->db->baca_sql($query);
        $datas = [];
        while (odbc_fetch_row($result)) {
            $datas[] = [
                "IDKategori"    => rtrim(odbc_result($result, 'IDKategori')),
                "kategori"   => rtrim(odbc_result($result, 'kategori')),
                "TotalAmount"   => number_format(rtrim(odbc_result($result, 'TotalAmount')), 0, '.', ','),
            ];
        }

        return $datas;
    }



    private function DetaildataFinal($post)
    {

        $no_p = $this->test_input($post["transnoHider"]);

        $query = "SELECT 
            MK.kategori,
            FD.IDKategori,
            SUM(FD.amount) AS TotalAmount
        FROM 
           $this->table_frofinal FD
        JOIN 
            $this->table_ktg MK 
            ON FD.IDKategori = MK.IDKategori
        WHERE 
            FD.No_Pls = '{$no_p}'
        GROUP BY 
            MK.kategori, FD.IDKategori
        ORDER BY 
            MK.kategori ASC;";
        $result = $this->db->baca_sql($query);
        $datas = [];
        while (odbc_fetch_row($result)) {
            $datas[] = [
                "IDKategori"    => rtrim(odbc_result($result, 'IDKategori')),
                "kategori"   => rtrim(odbc_result($result, 'kategori')),
                "TotalAmount"   => number_format(rtrim(odbc_result($result, 'TotalAmount')), 0, '.', ','),
            ];
        }

        return $datas;
    }
}
