USE [bmnpt]

GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

ALTER PROCEDURE [dbo].[USP_TampildataKur]
    @nopo VARCHAR(20),
    @totolpib FLOAT
AS
BEGIN
    SET NOCOUNT ON;

    -- ============================
    -- Drop Temporary Tables Jika Ada
    -- ============================
  IF EXISTS(SELECT [Table_name] FROM tempdb.information_schema.tables WHERE [Table_name] like '#temptess') 
    BEGIN
      DROP TABLE #temptess;
    END;

 IF EXISTS(SELECT [Table_name] FROM tempdb.information_schema.tables WHERE [Table_name] like '#temptess') 
    BEGIN
      DROP TABLE #temptess2;
    END;

    -- ============================
    -- Create Temporary Tables
    -- ============================
    CREATE TABLE #temptess (
        DOTransacID CHAR(15),
        Partid CHAR(10),
        PartName CHAR(60),
        Qty FLOAT,
        Unit CHAR(10),
        Price FLOAT,
        Amount_USD FLOAT,
        Kurs FLOAT,
        Amount_Rp FLOAT
    );

    CREATE TABLE #temptess2 (
        DOTransacID CHAR(15),
        Partid CHAR(10),
        PartName CHAR(60),
        Qty FLOAT,
        Unit CHAR(10),
        Price FLOAT,
        Amount_USD FLOAT,
		Kurs FLOAT,
		Hpp_Awal FLOAT,
        Amount_Rp FLOAT,
        kur_akhir FLOAT,
        Amount_RpAkhir FLOAT,
		Hpp_Akhir FLOAT,
        Total_Qty FLOAT,
        Total_amount_USD FLOAT,
        Total_amount_Rp FLOAT
    );

    -- ============================
    -- Insert Data ke #temptess
    -- ============================
    INSERT INTO #temptess
    SELECT 
        a.DOTransacID,
        a.Partid,
        a.PartName,
        a.quantity AS Qty,
        a.satuan AS Unit,
        a.itemprice AS Price,
        a.quantity * a.itemprice AS Amount_USD,
        a.kurs AS Kurs,
        a.quantity * a.itemprice * a.kurs AS Amount_Rp
    FROM 
        [bmnpt].[dbo].[POTRANSACTIONDETAILBMN] AS a
    WHERE 
        a.DOTransacID = @nopo;

    -- ============================
    -- Hitung Total dan Kurs Akhir
    -- ============================
    DECLARE 
        @total_amount_USD FLOAT,
        @total_amount_rp FLOAT,
        @total_qty FLOAT,
        @kurs_akhir FLOAT,
        @total_amount_akhir FLOAT,
        @prosentase FLOAT;

	 
    SELECT 
        @total_amount_USD = ISNULL(SUM(Amount_USD), 0),
        @total_amount_rp = ISNULL(SUM(Amount_Rp), 0),
        @total_qty = ISNULL(SUM(Qty), 0)
    FROM 
        #temptess
    WHERE 
        DOTransacID = @nopo  AND Partid<>'01.001.163' ;


    IF @total_amount_USD = 0
        SET @kurs_akhir = 0;
    ELSE
        SET @kurs_akhir = (@total_amount_rp + @totolpib) / @total_amount_USD;

    -- ============================
    -- Insert Data ke #temptess2
    -- ============================
    INSERT INTO #temptess2
    SELECT 
        DOTransacID,
        Partid,
        PartName,
        Qty,
        Unit,
        Price,
        Amount_USD,
        Kurs,
		Price * Kurs AS Hpp_Awal,
        Amount_Rp,
        @kurs_akhir AS kur_akhir,
        Amount_USD * @kurs_akhir AS Amount_RpAkhir,
		Price * @kurs_akhir AS Hpp_Akhir,
        @total_qty,
        @total_amount_USD,
        @total_amount_rp
    FROM 
        #temptess;

    -- ============================
    -- Hitung Total Amount Akhir dan Prosentase Selisih
    -- ============================
    SELECT 
        @total_amount_akhir = ISNULL(SUM(Amount_RpAkhir), 0)
    FROM 
        #temptess2
    WHERE 
        DOTransacID = @nopo AND Partid<>'01.001.163';

    IF @total_amount_rp <> 0
        SET @prosentase = (((@total_amount_akhir - @total_amount_rp)/@total_amount_rp) * 100);
    ELSE
        SET @prosentase = 0;

    -- ============================
    -- Output
    -- ============================
    
    SELECT 
        *,
		 Hpp_Akhir - Hpp_Awal AS Selisih_Hpp,
        @total_amount_akhir AS Total_amount_Rpakhir,
		 @prosentase AS Prosentase
    FROM 
        #temptess2;
END
GO

-- Eksekusi contoh
 EXEC USP_TampildataKur 'PO250205094039','6900000'

