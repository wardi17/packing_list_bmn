USE [bmnpt]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[Insert_ForwarderDetail_History]
    @No_Pls VARCHAR(20)
AS
BEGIN
    IF NOT EXISTS (
        SELECT 1 FROM [dbo].FrowaderDetail_HISTORY WHERE No_Pls = @No_Pls
    )
    BEGIN
        INSERT INTO [dbo].FrowaderDetail_HISTORY (
            No_Pls, msID, rumus, hitungan, amount
        )
        SELECT
            No_Pls, msID, rumus, hitungan, amount
        FROM [dbo].FrowaderDetail
        WHERE No_Pls = @No_Pls;
    END
END
GO