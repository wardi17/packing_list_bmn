USE [bmnpt]
GO

CREATE FUNCTION dbo.FunSumDetailPakingList_KURS_Temporary(
  @No_Pls VARCHAR(20)
)
RETURNS  FLOAT
AS
BEGIN
	DECLARE @total FLOAT;

	SET @total =(SELECT COUNT(*) FROM [bmnpt].[dbo].POPAKINGLIST_KURSDETAIL_Temporary WHERE No_Pls=@No_Pls);

    RETURN @total;
END
GO  

PRINT dbo.FunSumDetailPakingList_KURS_Temporary('BMI_PL241112082834')