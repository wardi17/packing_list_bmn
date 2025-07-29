USE [bmnpt]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[Update_Popakinglist_Detail_New]
    @No_Pls VARCHAR(20)
AS
BEGIN
    SET NOCOUNT ON;

    IF EXISTS (SELECT 1 FROM dbo.POPAKINGLIST_KURSDETAIL WHERE No_Pls = @No_Pls)
    BEGIN
         -- Update Selisih_Hpp_b berdasarkan No_Pls dan Partid
        UPDATE B
        SET B.Selisih_Hpp_b = A.Selisih_Hpp
        FROM dbo.POPAKINGLIST_KURSDETAIL_HISTORY A
        INNER JOIN dbo.POPAKINGLIST_KURSDETAIL B
            ON A.No_Pls = B.No_Pls
            AND A.Partid = B.Partid
        WHERE A.No_Pls = @No_Pls;


    END

  
    RETURN 0;
END
go 
--EXEC  Update_Popakinglist_Detail_New 'BMI_PL250704085637'

