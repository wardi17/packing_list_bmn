USE [bmnpt]
GO
SET ANSI_NULLS ON
GO

CREATE PROCEDURE [dbo].[USP_InsertForwaderTemp]
    @No_Pls VARCHAR(20)
AS
BEGIN
    SET NOCOUNT ON;

    -- Cek apakah data sudah ada di tabel temporary
    IF NOT EXISTS (
        SELECT 1 
        FROM FrowaderDetail_Temporary 
        WHERE No_Pls = @No_Pls
    )
    BEGIN
        -- Masukkan data dari FrowaderDetail jika belum ada
		INSERT INTO FrowaderDetail_Temporary (No_Pls, msID, rumus,hitungan,amount)
        SELECT No_Pls, msID, rumus,hitungan,amount
        FROM FrowaderDetail
        WHERE No_Pls = @No_Pls; 
    END
    ELSE
    BEGIN
        -- Jika sudah ada, bisa log atau hanya abaikan
        PRINT 'Data dengan No_Pls tersebut sudah ada di FrowaderDetail_Temporary.';
    END
END
GO

-- Contoh eksekusi prosedur
--EXEC [dbo].[USP_InsertForwaderTemp] 'BMI_PL250612081521'


