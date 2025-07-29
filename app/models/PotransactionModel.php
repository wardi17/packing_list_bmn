<?php
date_default_timezone_set('Asia/Jakarta');
class PotransactionModel extends Models
{
    private $table = "[bmnpt].[dbo].POTRANSACTIONBMN";
    private $table_dtl = "[bmnpt].[dbo].POTRANSACTIONDETAIL";
    private $table_pack = "[bmnpt].[dbo].POPAKINGLIST_KURS";



    public function Tampilpobysup($post)
    {

        $tahun = DATE("Y");
        $suplairid = $this->test_input($post["suplairid"]);
        $file = "A.DOTransacID,A.DONumber";
        $table = $this->table . " AS A ";
        $table .= " WHERE NOT EXISTS (
            SELECT 1
            FROM  $this->table_pack AS B
            WHERE A.DONumber = B.NoPo 
        )";
        $table .= " AND suppid='" . $suplairid . "'";
        //  $table .= " AND  flagpostingInv is NULL AND flagcancelDo is NULL ";
        $table .= $this->orderby("DONumber");
        $query = $this->select($file, $table);
        //$this->consol_war($query);

        $result = $this->db->baca_sql2($query);
        $datas = [];
        while (odbc_fetch_row($result)) {

            $datas[] = [
                "DOTransacID" => rtrim(odbc_result($result, 'DOTransacID')),
                "DONumber" => rtrim(odbc_result($result, 'DONumber')),
            ];
        }

        // $this->consol_war($datas);
        return $datas;
    }

    //note
    public function TampilpobysupEdit($post)
    {


        $suplairid = $this->test_input($post["suplairid"]);
        $nopo      = $this->test_input($post["donumber"]);
        $file = "DOTransacID,DONumber";
        $table = $this->table;
        $table .= " WHERE suppid='" . $suplairid . "' AND DONumber='" . $nopo . "'";
        $table .= $this->orderby("DONumber");
        $query = $this->select($file, $table);


        $result = $this->db->baca_sql2($query);
        $datas = [];
        while (odbc_fetch_row($result)) {

            $datas[] = [
                "DOTransacID" => rtrim(odbc_result($result, 'DOTransacID')),
                "DONumber" => rtrim(odbc_result($result, 'DONumber')),
            ];
        }


        return $datas;
    }



    public function TampilDetailpo($post)
    {

        $DOTransacID = $this->test_input($post["DOTransacID"]);
        $file = "ItemNo,Partid,PartName,quantity,satuan";
        $table = $this->table_dtl;
        $table .= " WHERE DOTransacID='" . $DOTransacID . "'";
        $table .= $this->orderby("ItemNo");
        $query = $this->select($file, $table);
        //die(var_dump($query));
        $result = $this->db->baca_sql2($query);


        $datas = [];
        while (odbc_fetch_row($result)) {

            $datas[] = [
                "ItemNo" => rtrim(odbc_result($result, 'ItemNo')),
                "Partid" => rtrim(odbc_result($result, 'Partid')),
                "PartName" => rtrim(odbc_result($result, 'PartName')),
                "satuan" => rtrim(odbc_result($result, 'satuan')),
                "qty" => number_format(rtrim(odbc_result($result, 'quantity')), 0, ',', ','),
            ];
        }


        //  $this->consol_war($datas);
        return $datas;
    }


    public function Tampilnotepobyid($post)
    {
        $nopo = $this->test_input($post["nopo"]);
        $file = "Note";
        $table = $this->table;
        $table .= " WHERE DOTransacID='" . $nopo . "'";
        $query = $this->select($file, $table);
        //die(var_dump($query));
        $result = $this->db->baca_sql2($query);

        $datas = "";
        while (odbc_fetch_row($result)) {
            $datas =  rtrim(odbc_result($result, 'Note'));
        }

        return $datas;
    }
}
