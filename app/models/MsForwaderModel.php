<?php

class MsForwaderModel  extends  Models
{
    private $table_ms = "[bmnpt].[dbo].msForwader";

    public function SaveData($post)
    {

        $userid = $_SESSION['login_user'];
        $keterangan = $this->test_input($post["keterangan"]);
        $rumus      = $this->test_input($post["rumus"]);
        $hitungan   = $this->test_input($post["hitungan"]);

        $query = "INSERT INTO $this->table_ms (keterangan,rumus,hitungan,user_input)VALUES('" . $keterangan . "','" . $rumus . "','" . $hitungan . "','" . $userid . "')";

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
        $query = "SELECT msID,keterangan,rumus,hitungan,status_aktif,user_input FROM $this->table_ms ORDER BY  msID ASC  ";

        //$this->consol_war($query);
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
        $dateedit   = date("Y-m-d H:i:s");
        $query = "UPDATE $this->table_ms SET keterangan='" . $keterangan . "',rumus='" . $rumus . "',hitungan='" . $hitungan . "',status_aktif='" . $aktif . "',user_edit='" . $userid . "',
            date_edit='" . $dateedit . "' WHERE msID='" . $msid . "'
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
        $query = "SELECT msID,keterangan,rumus,hitungan FROM $this->table_ms WHERE status_aktif ='Y' ORDER BY  msID ASC";
        //die(var_dump($query));
        $result = $this->db->baca_sql2($query);
        $datas = [];
        while (odbc_fetch_row($result)) {
            $datas[] = [
                "msID"          => rtrim(odbc_result($result, 'msID')),
                "keterangan"    => rtrim(odbc_result($result, 'keterangan')),
                "rumus"         => rtrim(odbc_result($result, 'rumus')),
                "hitungan"      => rtrim(odbc_result($result, 'hitungan')),

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
            ];
        }

        return $datas;
    }



    public function TampilForwaderEditFinal($post)
    {
        $transnoHider = $this->test_input($post["transnoHider"]);
        $query = "usp_GetForwaderEditFinalByID '" . $transnoHider . "'";
        // die(var_dump($query));
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
            ];
        }

        return $datas;
    }
}
