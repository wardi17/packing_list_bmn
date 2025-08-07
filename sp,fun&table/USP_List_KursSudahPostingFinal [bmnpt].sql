USE [bmnpt]
GO
/****** Object:  StoredProcedure [dbo].[USP_List_KursSudahPostingFinal]    Script Date: 05/24/2024 08:10:53 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[USP_List_KursSudahPostingFinal]
@status VARCHAR(1),
@tahun  int,
@userid VARCHAR(100)

AS

	IF EXISTS(SELECT [Table_name] FROM tempdb.information_schema.tables WHERE [Table_name] like '#temptess') 
    BEGIN
      DROP TABLE #temptess;
    END;

	CREATE TABLE  #temptess(
		No_Pls VARCHAR(20),
		No_Pli  char(20),
		NoPo char(30),
		POTransacid char(30),
		EntryDate DATETIME,
		Note VARCHAR(8000),
		supid char(30),
		userid char(30),
		Totaldetail float,
		Pib float,
		Forwarder float,
		Total float,
		UserPosting CHAR(10),
		DatePosting DATETIME,
		id_bl_awb char(50),
		Note2 VARCHAR(8000)
	);
BEGIN

	IF(@status ='Y') 
		BEGIN
			INSERT INTO #temptess
			SELECT No_Pls,No_Pli,NoPo,POTransacid,EntryDate,Note,supid,LastUserIDAccess,[bmnpt].[dbo].FunSumDetailPakingList_KURS_Temporary(No_Pls) as Totaldetail,
			Pib,Forwarder,Total,UserPosting,DatePosting,id_bl_awb,Note2
			FROM  [bmnpt].[dbo].POPAKINGLIST_KURS_Temporary  WHERE YEAR(EntryDate) =@tahun AND FlagPosting='Y'   ORDER BY EntryDate DESC  ;
		END
	 ELSE
		BEGIN
			INSERT INTO #temptess
			SELECT No_Pls,No_Pli,NoPo,POTransacid,EntryDate,Note,supid,LastUserIDAccess,[bmnpt].[dbo].FunSumDetailPakingList_KURS_Temporary(No_Pls) as Totaldetail,
			Pib,Forwarder,Total,UserPosting,DatePosting,id_bl_awb,Note2
			FROM  [bmnpt].[dbo].POPAKINGLIST_KURS_Temporary  WHERE YEAR(EntryDate) =@tahun AND LastUserIDAccess=@userid AND FlagPosting='Y'  ORDER BY EntryDate DESC  ;
		END

	SELECT 	No_Pls,No_Pli,NoPo,POTransacid,EntryDate,Note,supid,userid,Totaldetail,Pib,Forwarder,Total,UserPosting,DatePosting,id_bl_awb,Note2 FROM #temptess ORDER BY No_Pls ASC
END


GO
EXEC USP_List_KursSudahPostingFinal 'Y','2025','wardi'



