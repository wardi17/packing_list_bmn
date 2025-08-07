USE [bmnpt]
GO

SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO	
	
	
ALTER PROCEDURE usp_GetForwaderEditByID
	    @No_Pls VARCHAR(20)
	AS
	BEGIN
	  SET NOCOUNT ON;
	  DECLARE @total_hitungan FLOAT;
	  DECLARE @total_rumus FLOAT;

	  SET @total_hitungan =(SELECT  COALESCE(SUM(amount),0) FROM [bmnpt].[dbo].FrowaderDetail WHERE No_Pls=@No_Pls AND hitungan='Y')
	   SET @total_rumus =(SELECT  COALESCE(SUM(amount),0) FROM [bmnpt].[dbo].FrowaderDetail WHERE No_Pls=@No_Pls AND rumus='Y')

	SELECT a.msID,a.keterangan,b.rumus,b.hitungan,b.amount,@total_hitungan as total_hitungan,@total_rumus as total_rumus,a.IDKategori,a.kategori from [bmnpt].[dbo].msForwader as a
	LEFT JOIN [bmnpt].[dbo].FrowaderDetail as b
	ON b.msID =a.msID 
	WHERE b.No_Pls=@No_Pls ORDER BY a.IDKategori,a.msID ASC
END;

GO
EXEC usp_GetForwaderEditByID 'BMI_PL250610090711'