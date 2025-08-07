USE [bmnpt]
GO

SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[USP_CetakPakingListKurs]
    @transnoHider VARCHAR(20),
    @DOTransacID  VARCHAR(100)
AS
BEGIN
    -- Drop temporary table if it exists
    IF OBJECT_ID('tempdb..#temptess') IS NOT NULL
    BEGIN
        DROP TABLE #temptess
    END



		
    -- Create temporary table
    CREATE TABLE #temptess (
        ItemNo         FLOAT,
        Partid         CHAR(10),
        PartName       CHAR(60),
        Qty            FLOAT,
        satuan         CHAR(10),
        Price          FLOAT,
        Amount_USD     FLOAT,
        Amount_Rp      FLOAT,
        Kurs           FLOAT,
        Kurs_Akhir     FLOAT,
        Amount_Akhir   FLOAT,
        Hpp_Awal       FLOAT,
        Hpp_Akhir      FLOAT,
        Selisih_Hpp    FLOAT,
        No_Pli         CHAR(20),
        NoPo           CHAR(30),
        EntryDate      DATETIME,
        Note           VARCHAR(2000),
        supid          CHAR(30),
        Pib            FLOAT,
        Forwarder      FLOAT,
        Total          FLOAT,
        CustAddress    VARCHAR(1000), -- VARCHAR(5000) not available in SQL 2000
        CustTelpNo     CHAR(30),
        CustFaxNo      CHAR(30),
        CustEMail      VARCHAR(40),
        SupperiID      CHAR(10),
        SupperiName    VARCHAR(100),
        id_bl_awb      CHAR(50),
        total_Prosentase FLOAT
    )

		 -- Declare total variables
    DECLARE
        @total_qty       FLOAT,
        @total_Price     FLOAT,
        @total_USD       FLOAT,
        @total_Kurs      FLOAT,
        @total_Rp        FLOAT,
        @total_KursAkhir FLOAT,
        @total_RpAkhir   FLOAT,
        @currid          VARCHAR(50),
		@kurslanded		FLOAT,
		@usd_only FLOAT,
		@idr_only FLOAT,
		@pib FLOAT 

	SET @pib = (select ISNULL(SUM(amount), 0)  from FrowaderDetail where No_Pls =@transnoHider AND hitungan='Y');
    -- Populate temporary table
    INSERT INTO #temptess
    SELECT
        a.ItemNo,
        a.Partid,
        a.PartName,
        a.Qty,
        a.satuan,
        a.Price,
        a.Amount_USD,
        a.Amount_Rp,
        a.Kurs,
        a.Kurs_Akhir,
        a.Amount_Akhir,
        ISNULL(a.Hpp_Awal, 0) AS Hpp_Awal,
        ISNULL(a.Hpp_Akhir, 0) AS Hpp_Akhir,
        ISNULL(a.Selisih_Hpp, 0) AS Selisih_Hpp,
        c.No_Pli,
        c.NoPo,
        c.EntryDate,
        c.Note,
        c.supid,
        @pib,
        c.Forwarder,
        c.Total,
        d.CustAddress,
        d.CustTelpNo,
        d.CustFaxNo,
        d.CustEMail,
        d.CustomerID,
        d.CustName, 
        c.id_bl_awb,
        ISNULL(c.total_Prosentase, 0) AS total_Prosentase
    FROM dbo.POPAKINGLIST_KURSDETAIL a
    LEFT JOIN dbo.POPAKINGLIST_KURS c ON c.No_Pls = a.No_Pls
    LEFT JOIN dbo.supplier d ON d.CustomerID = c.supid
    WHERE a.No_Pls = @transnoHider
    ORDER BY a.ItemNo ASC

   
	

    -- Calculate totals
    SELECT 
        @total_qty        = ISNULL(SUM(Qty), 0),
        @total_Price      = ISNULL(SUM(Price), 0),
        @total_USD        = ISNULL(SUM(Amount_USD), 0),
        @total_Kurs       = ISNULL(SUM(Kurs), 0),
        @total_Rp         = ISNULL(SUM(Amount_Rp), 0),
        @total_KursAkhir  = ISNULL(SUM(Kurs_Akhir), 0),
        @total_RpAkhir    = ISNULL(SUM(Amount_Akhir), 0)
    FROM #temptess
	-- Ambil nilai Kurs_Akhir terkecil (TOP 1 ASC)
	SELECT TOP 1 @kurslanded = Kurs_Akhir
	FROM #temptess
	WHERE  PartName NOT LIKE '%POB%' 
	ORDER BY ItemNo ASC;



	--get total amount partid  '01.001.163'
	SELECT 
	@usd_only = ISNULL(SUM(Amount_USD), 0),
	@idr_only = ISNULL(SUM(Amount_Rp), 0)
	FROM #temptess
	WHERE  PartName  LIKE '%POB%' 



    -- Get currency ID
    SET @currid = (SELECT TOP 1 currid FROM POTRANSACTIONDETAILBMN WHERE DOTransacID = @DOTransacID)

    -- Return results
    SELECT 
        *,
        @total_qty        AS total_qty,
        @total_Price      AS total_Price,
        @total_USD        AS total_USD,
        @total_Kurs       AS total_Kurs,
        @total_Rp         AS total_Rp,
        @total_KursAkhir  AS total_KursAkhir,
        @total_RpAkhir    AS total_RpAkhir,
        @currid           AS currid,
		@kurslanded		  AS kurslanded,
		(@total_USD - @usd_only ) AS total_usd_only,
	    (@total_Rp - @idr_only) AS total_idr_only
    FROM #temptess
    ORDER BY ItemNo ASC
END
GO

-- Example execution
EXEC USP_CetakPakingListKurs 'BMI_PL250722164155', 'PO250721130521'




