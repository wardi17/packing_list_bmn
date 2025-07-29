USE [bambi-bmi]
GO
/****** Object:  StoredProcedure [dbo].[USP_CetakPakingListHasilPIB]    Script Date: 05/24/2024 08:10:53 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER PROCEDURE [dbo].[USP_CetakPakingListHasilPIB]
@transnoHider VARCHAR(20),
@DOTransacID varchar(100)

AS
	IF EXISTS(SELECT [Table_name] FROM tempdb.information_schema.tables WHERE [Table_name] like '#temptess') 
    BEGIN
      DROP TABLE #temptess;
    END;

	CREATE TABLE #temptess(
	ItemNo FLOAT,
	Partid char(10),
	PartName char(60),
	Biaya_pib  FLOAT,
	Komposisi FLOAT,
	hpp_awal FLOAT,
	hpp_akhir FLOAT,
	Qty FlOAT,
	Amount FLOAT,
	No_Pli char(20),
	NoPo char(30),
	EntryDate datetime,
	Note VARCHAR(2000),
	supid char(30),
	Pib FLOAT,
	Forwarder FLOAT,
	Total FLOAT,
	CustAddress VARCHAR(5000),
	CustTelpNo char(30),
	CustFaxNo char(30),
	CustEMail varchar(40),
	SupperiID char(10),
	SupperiName char(100),
	id_bl_awb	char(50)
	);

BEGIN


	
	BEGIN
	 INSERT INTO #temptess
	 SELECT  a.ItemNo,a.Partid,a.PartName,c.Total as biaya_pib,b.Komposisi,COALESCE(b.hpp_awal,0),COALESCE(b.hpp_akhir,0),b.Qty,COALESCE(b.pib, 0),
	  c.No_Pli,c.NoPo,c.EntryDate,c.Note,c.supid,c.Pib,c.Forwarder,c.Total,
	  d.CustAddress,d.CustTelpNo,d.CustFaxNo,d.CustEMail,d.CustomerID,d.CustName,c.id_bl_awb
	 FROM [bambi-bmi].[dbo].POTRANSACTIONDETAIL as a
	 LEFT JOIN  [bambi-bmi].[dbo].POPAKINGLISTDETAIL  as b
	  ON b.Partid = a.Partid
	 LEFT JOIN [bambi-bmi].[dbo].POPAKINGLIST  as c
	 ON c.No_Pls = b.No_Pls
	 LEFT JOIN [bambi-bmi].[dbo].supplier as d
	 ON d.CustomerID =c.supid
	 WHERE a.DOTransacID=@DOTransacID AND b.No_Pls =@transnoHider ORDER BY a.ItemNo ASC

		
	END

	SELECT * FROM #temptess ORDER BY ItemNo ASC
	
END


GO
EXEC USP_CetakPakingListHasilPIB'BMI_PL250508163625','PO210603091924'



