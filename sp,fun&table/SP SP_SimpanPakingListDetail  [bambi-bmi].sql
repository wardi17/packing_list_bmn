USE [bambi-bmi]
GO
/****** Object:  StoredProcedure [dbo].[SP_SimpanPakingListDetail]    Script Date: 05/24/2024 08:10:53 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER PROCEDURE [dbo].[SP_SimpanPakingListDetail]
@POTranso VARCHAR(20),
@PODetail varchar(100),
@partid char(10),
@partname char(60),
@qty float,
@CTNS float,
@GTNS float,
@KGS float,
@CBM float,
@satuan VARCHAR(10),
@komposisi FLOAT
AS
BEGIN


	IF NOT EXISTS(SELECT PODetail FROM [bambi-bmi].[dbo].POPAKINGLISTDETAIL WHERE PODetail =@PODetail)
	BEGIN
	
		DECLARE @Itemno float;
		SET @Itemno =(SELECT COALESCE((SELECT top 1 ItemNo from  [bambi-bmi].[dbo].POPAKINGLISTDETAIL where PODetail=@PODetail ORDER BY ItemNo DESC), 0));
		INSERT INTO [bambi-bmi].[dbo].POPAKINGLISTDETAIL(No_Pls,PODetail,ItemNo,Partid,PartName,Qty,CTNS,CBM,GTNS,KGS,satuan,Komposisi)
		VALUES(@POTranso,@PODetail,(@Itemno + 1),@Partid,@partname,@qty,@CTNS,@CBM,@GTNS,@KGS,@satuan,@komposisi);

	END

	
	SELECT * FROM  [bambi-bmi].[dbo].POPAKINGLISTDETAIL WHERE PODetail=@PODetail ORDER BY Itemno ASC 
END


GO
EXEC SP_SimpanPakingListDetail 'BMI_PL250113113016','49c7784cb2', '01.001.055', 'Mekanik PD 123-2-16/20',
         '2400','555', '555', '555', '55','pcs','100'


