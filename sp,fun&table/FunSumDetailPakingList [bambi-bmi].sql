USE [bambi-bmi]
GO

CREATE FUNCTION dbo.FunSumDetailPakingList(
  @No_Pls VARCHAR(20)
)
RETURNS  FLOAT
AS
BEGIN
	DECLARE @total FLOAT;

	SET @total =(SELECT COUNT(*) FROM [bambi-bmi].[dbo].POPAKINGLISTDETAIL WHERE No_Pls=@No_Pls);

    RETURN @total;
END
GO  

PRINT dbo.FunSumDetailPakingList('BMI_PL241112082834')