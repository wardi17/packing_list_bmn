<?php
class MsKategoriModel extends  Models
{
    private $table_ms = "[bmnpt].[dbo].MasterKategori";
    private $table_fro = "[bmnpt].[dbo].FrowaderDetail";
    private $table_frofinal = "[bmnpt].[dbo].FrowaderDetail_Temporary";
    public function SaveData($post)
    {
        $userid = $_SESSION['login_user'];
        $kategori = $this->test_input($post["kategori"]);
        $keterangan = $this->test_input($post["keterangan"]);

        $query = "INSERT INTO $this->table_ms (kategori, keterangan, user_input) VALUES ('" . $kategori . "', '" . $keterangan . "', '" . $userid . "')";

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
        $query = "SELECT IDKategori, kategori, keterangan,user_input FROM $this->table_ms ORDER BY IDKategori ASC";

        //$this->consol_war($query);
        $result = $this->db->baca_sql2($query);
        $datas = [];
        while (odbc_fetch_row($result)) {
            $datas[] = [
                "IDKategori" => rtrim(odbc_result($result, 'IDKategori')),
                "kategori"   => rtrim(odbc_result($result, 'kategori')),
                "keterangan" => rtrim(odbc_result($result, 'keterangan')),
                "user_input" => rtrim(odbc_result($result, 'user_input')),
            ];
        }

        return $datas;
    }


    public function Updatedata($post)
    {
        $IDKategori = $this->test_input($post["IDKategori"]);
        $kategori = $this->test_input($post["kategori"]);
        $keterangan = $this->test_input($post["keterangan"]);
        $userid = $_SESSION['login_user'];
        $query = "UPDATE $this->table_ms SET kategori = '" . $kategori . "', keterangan = '" . $keterangan . "',
        user_edit = '" . $userid . "'
        ,date_edit = GETDATE()  WHERE IDKategori = '" . $IDKategori . "'";

        $cek = 0;
        $result = $this->db->baca_sql($query);
        if (!$result) {
            $cek++;
        }
        if ($cek === 0) {
            $status = [
                'nilai' => 1,
                'error' => 'Data Berhasil Di Update'
            ];
        } else {
            $status = [
                'nilai' => 0,
                'error' => 'Data Gagal Di Update'
            ];
        }
        return $status;
    }

    public function Deletedata($post)
    {
        $IDKategori = $this->test_input($post["IDKategori"]);

        $query = "DELETE  FROM $this->table_ms WHERE IDKategori = '" . $IDKategori . "' ";

        $cek = 0;
        $result = $this->db->baca_sql($query);
        if (!$result) {
            $cek++;
        }
        if ($cek === 0) {
            $status = [
                'nilai' => 1,
                'error' => 'Data Berhasil Di Delete'
            ];
        } else {
            $status = [
                'nilai' => 0,
                'error' => 'Data Gagal Di Delete'
            ];
        }
        return $status;
    }
    public function TampilSelectKatg()
    {
        $query = "SELECT IDKategori,kategori FROM $this->table_ms  ORDER BY IDKategori ASC ";
        //$this->consol_war($query);
        $datas = [];
        $result = $this->db->baca_sql2($query);
        while (odbc_fetch_row($result)) {
            $IDKategori = rtrim(odbc_result($result, 'IDKategori'));
            $kategori  =   trim(odbc_result($result, 'kategori'));
            $datas[] = [
                "id" => $IDKategori,
                "name"   => $kategori

            ];
        }

        return $datas;
    }

    public function Listkategori()
    {

        $query = "SELECT IDKategori,kategori FROM $this->table_ms  GROUP BY IDKategori,kategori ORDER BY IDKategori ASC";

        //$this->consol_war($query);
        $result = $this->db->baca_sql2($query);
        $datas = [];
        while (odbc_fetch_row($result)) {
            $datas[] = [
                "IDKategori"   => rtrim(odbc_result($result, 'IDKategori')),
                "kategori"   => rtrim(odbc_result($result, 'kategori')),
            ];
        }

        return $datas;
    }


    public function listkategoriByID($post)
    {
        $no_p = $this->test_input($post["transnoHider"]);
        $query = "SELECT 
            MK.kategori,
            FD.IDKategori,
            SUM(FD.amount) AS TotalAmount
        FROM 
           $this->table_fro FD
        JOIN 
            $this->table_ms MK 
            ON FD.IDKategori = MK.IDKategori
        WHERE 
            FD.No_Pls = '{$no_p}'
        GROUP BY 
           FD.IDKategori, MK.kategori
        ORDER BY 
             FD.IDKategori ASC;";
        $result = $this->db->baca_sql2($query);
        $datas = [];
        while (odbc_fetch_row($result)) {
            $datas[] = [
                "kategori"   => rtrim(odbc_result($result, 'kategori')),
                "IDKategori" => rtrim(odbc_result($result, "IDKategori")),
                "TotalAmount"   => number_format(rtrim(odbc_result($result, 'TotalAmount')), 0, '.', ','),
            ];
        }


        return $datas;
    }


    public function listkategoriFinalByID($post)
    {
        $no_p = $this->test_input($post["transnoHider"]);
        $query = "SELECT 
            MK.kategori,
            FD.IDKategori,
            SUM(FD.amount) AS TotalAmount
        FROM 
           $this->table_frofinal FD
        JOIN 
            $this->table_ms MK 
            ON FD.IDKategori = MK.IDKategori
        WHERE 
            FD.No_Pls = '{$no_p}'
        GROUP BY 
            MK.kategori, FD.IDKategori
        ORDER BY 
            FD.IDKategori  ASC;";
        $result = $this->db->baca_sql2($query);
        $datas = [];
        while (odbc_fetch_row($result)) {
            $datas[] = [
                "kategori"   => rtrim(odbc_result($result, 'kategori')),
                "IDKategori" => rtrim(odbc_result($result, "IDKategori")),
                "TotalAmount"   => number_format(rtrim(odbc_result($result, 'TotalAmount')), 0, '.', ','),
            ];
        }


        return $datas;
    }
}
