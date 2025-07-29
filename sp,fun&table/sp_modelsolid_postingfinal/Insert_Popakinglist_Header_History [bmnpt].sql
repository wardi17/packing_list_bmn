USE [bmnpt]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[Insert_Popakinglist_Header_History]
    @No_Pls VARCHAR(20)
AS
BEGIN
    IF NOT EXISTS (
        SELECT 1 FROM [dbo].POPAKINGLIST_KURS_HISTORY WHERE No_Pls = @No_Pls
    )
    BEGIN
        INSERT INTO [dbo].POPAKINGLIST_KURS_HISTORY (
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
        FROM [dbo].POPAKINGLIST_KURS
        WHERE No_Pls = @No_Pls;
    END
END
GO