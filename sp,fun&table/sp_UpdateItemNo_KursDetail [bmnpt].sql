USE [bmnpt]
GO
/****** Object:  StoredProcedure [dbo].[sp_UpdateItemNo_KursDetail]    Script Date: 05/24/2024 08:10:53 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE sp_UpdateItemNo_KursDetail
    @No_Pls VARCHAR(50)
AS
BEGIN
    -- Update nilai ItemNo di kurs detail
    UPDATE c
    SET c.ItemNo = b.ItemNo
    FROM POPAKINGLIST_KURS AS a
    INNER JOIN POTRANSACTIONBMN AS d
        ON d.DOTransacID = a.POTransacid
    INNER JOIN POTRANSACTIONDETAILBMN AS b
        ON b.DOtransacID = d.DOTransacID
    INNER JOIN POPAKINGLIST_KURSDETAIL AS c
        ON a.No_Pls = c.No_Pls AND b.Partid = c.Partid
    WHERE a.No_Pls = @No_Pls
END

GO
--EXEC sp_UpdateItemNo_KursDetail 'BMI_PL250723133041'

