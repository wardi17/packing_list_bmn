
USE [bmnpt]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[Insert_Popakinglist_Header_New]
    @No_Pls VARCHAR(20)
AS
BEGIN
    SET NOCOUNT ON;

    -- Hapus child (FrowaderDetail) dulu
    IF EXISTS (SELECT 1 FROM dbo.FrowaderDetail WHERE No_Pls = @No_Pls)
    BEGIN
        DELETE FROM dbo.FrowaderDetail WHERE No_Pls = @No_Pls;
    END
-- Hapus child (POPAKINGLIST_KURSDETAIL) dulu
    IF EXISTS (SELECT 1 FROM dbo.POPAKINGLIST_KURSDETAIL WHERE No_Pls = @No_Pls)
    BEGIN
        DELETE FROM dbo.POPAKINGLIST_KURSDETAIL WHERE No_Pls = @No_Pls;
    END

    -- Hapus header
    IF EXISTS (SELECT 1 FROM dbo.POPAKINGLIST_KURS WHERE No_Pls = @No_Pls)
    BEGIN
        DELETE FROM dbo.POPAKINGLIST_KURS WHERE No_Pls = @No_Pls;
    END

    INSERT INTO dbo.POPAKINGLIST_KURS (
        No_Pls, No_Pli, NoPo, POTransacid, id_bl_awb,
        EntryDate, Note, supid, Pib, Forwarder, Total,
        LastUserIDAccess, LastDateAccess, UpdateUserIDAccess,
        UpdateDateAccess, FlagPosting, UserPosting, DatePosting,
        total_usd, total_rp, total_amountakhir, total_Prosentase
    )
    SELECT
        No_Pls, No_Pli, NoPo, POTransacid, id_bl_awb,
        EntryDate, Note, supid, Pib, Forwarder, Total,
        LastUserIDAccess, LastDateAccess, UpdateUserIDAccess,
        UpdateDateAccess, FlagPosting, UserPosting, DatePosting,
        total_usd, total_rp, total_amountakhir, total_Prosentase
    FROM dbo.POPAKINGLIST_KURS_Temporary
    WHERE No_Pls = @No_Pls;

    RETURN 0;
END
