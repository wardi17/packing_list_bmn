USE [bmnpt];
GO

SET ANSI_NULLS ON;
GO

SET QUOTED_IDENTIFIER ON;
GO

CREATE PROCEDURE [dbo].[Update_Partmaster_HargaBeli]
    @No_Pls VARCHAR(20)
AS
BEGIN
    SET NOCOUNT ON;

    -- Cek apakah data dengan No_Pls tersebut ada di POPAKINGLIST_KURSDETAIL
    IF EXISTS (
        SELECT 1
        FROM dbo.POPAKINGLIST_KURSDETAIL
        WHERE No_Pls = @No_Pls
    )
    BEGIN
        /*
        -- Contoh data yang dapat dicek:
        SELECT 
            a.harga_beli,
            b.Partid,
            a.partname,
            b.Selisih_Hpp,
            b.Selisih_Hpp_b,
            (b.Selisih_Hpp - b.Selisih_Hpp_b) AS Selisih_Total
        FROM partmaster AS a
        LEFT JOIN POPAKINGLIST_KURSDETAIL AS b ON b.Partid = a.Partid
        WHERE b.No_Pls = @No_Pls
        */

        -- Update kolom harga_beli pada tabel partmaster berdasarkan Partid
        UPDATE B
        SET B.harga_beli = ((A.Selisih_Hpp - A.Selisih_Hpp_b) + B.harga_beli)
        FROM dbo.POPAKINGLIST_KURSDETAIL AS A
        INNER JOIN dbo.partmaster AS B ON A.Partid = B.Partid
        WHERE A.No_Pls = @No_Pls;
    END

    RETURN 0;
END;
GO

-- Contoh eksekusi:
-- EXEC Update_Partmaster_HargaBeli 'BMI_PL250711093710';
