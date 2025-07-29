USE [bmnpt]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[Insert_Popakinglist_Detail_History]
    @No_Pls VARCHAR(20)
AS
BEGIN
    IF NOT EXISTS (
        SELECT 1 FROM [dbo].POPAKINGLIST_KURSDETAIL_HISTORY WHERE No_Pls = @No_Pls
    )
    BEGIN
        INSERT INTO [dbo].POPAKINGLIST_KURSDETAIL_HISTORY (
            No_Pls, ItemNo, Partid, PartName, satuan, Qty, Price,
            Amount_USD, Kurs, Amount_Rp, Kurs_Akhir, Amount_Akhir,
            Hpp_Awal, Hpp_Akhir, Selisih_Hpp
        )
        SELECT
            No_Pls, ItemNo, Partid, PartName, satuan, Qty, Price,
            Amount_USD, Kurs, Amount_Rp, Kurs_Akhir, Amount_Akhir,
            Hpp_Awal, Hpp_Akhir, Selisih_Hpp
        FROM [dbo].POPAKINGLIST_KURSDETAIL
        WHERE No_Pls = @No_Pls;
    END
END
GO