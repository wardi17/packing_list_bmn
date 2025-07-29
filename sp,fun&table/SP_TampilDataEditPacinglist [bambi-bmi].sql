USE [bambi-bmi]
GO
/****** Object:  StoredProcedure [dbo].[SP_TampilDataEditPacinglist]    Script Date: 11/14/2024 10:42:46 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER PROCEDURE [dbo].[SP_TampilDataEditPacinglist]
@transnoHider VARCHAR(20),
@DOTransacID varchar(100)

AS
BEGIN

	BEGIN
	 SELECT  a.ItemNo,a.Partid,a.PartName,b.satuan,a.quantity,b.CTNS,b.CBM,b.GTNS,b.KGS,b.PODetail,b.No_Pls,b.Komposisi
	 FROM [bambi-bmi].[dbo].POTRANSACTIONDETAIL as a
	 LEFT JOIN  [bambi-bmi].[dbo].POPAKINGLISTDETAIL  as b
	 ON b.Partid = a.Partid
	 WHERE a.DOTransacID=@DOTransacID AND b.No_Pls =@transnoHider ORDER BY a.ItemNo ASC

		
	END

	
END

GO
EXEC SP_TampilDataEditPacinglist 'BMI_PL250521091448','PO231009165537'
