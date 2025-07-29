USE [bmnpt]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[Insert_ForwarderDetail_New]
    @No_Pls VARCHAR(20)
AS
BEGIN
    SET NOCOUNT ON;

    IF EXISTS (SELECT 1 FROM dbo.FrowaderDetail WHERE No_Pls = @No_Pls)
    BEGIN
        DELETE FROM dbo.FrowaderDetail WHERE No_Pls = @No_Pls;
    END

    INSERT INTO dbo.FrowaderDetail (No_Pls, msID, rumus, hitungan, amount)
    SELECT No_Pls, msID, rumus, hitungan, amount
    FROM dbo.FrowaderDetail_Temporary
    WHERE No_Pls = @No_Pls;

    RETURN 0;
END
