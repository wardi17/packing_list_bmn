USE [bambi-bmi]
GO

SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

-- Alter Procedure
ALTER PROCEDURE [dbo].[USP_INSERT_POAKINGLIST_KURS_Header]
    @No_Pls VARCHAR(20),
    @No_Pli VARCHAR(200),
    @suplieid VARCHAR(150),
    @NoPo VARCHAR(20),
    @POTransacid VARCHAR(20),
    @EntryDate DATETIME,
    @Note TEXT,
    @LastUserIDAccess VARCHAR(150),
    @Pib FLOAT,
    @Forwarder FLOAT,
    @Total FLOAT,
    @id_bl_awb VARCHAR(50)
AS
BEGIN
    -- Cek jika belum ada data
    IF NOT EXISTS (
        SELECT 1 
        FROM [dbo].[POPAKINGLIST_KURS] 
        WHERE No_Pls = @No_Pls
    )
    BEGIN
        -- Masukkan data ke POPAKINGLIST_KURS
        INSERT INTO [dbo].[POPAKINGLIST_KURS] (
            No_Pls, No_Pli, POTransacid, EntryDate, Note,
            LastUserIDAccess, LastDateAccess, supid, NoPo, 
            Pib, Forwarder, Total, id_bl_awb
        )
        VALUES (
            @No_Pls, @No_Pli, @POTransacid, @EntryDate, @Note,
            @LastUserIDAccess, GETDATE(), @suplieid, @NoPo,
            @Pib, @Forwarder, @Total, @id_bl_awb
        )


    END
END
GO



	
EXEC  USP_INSERT_POAKINGLIST_KURS_Header
        'BMI_PL250610081645',
        '',
        'CHILINK',
        '7721000163',
        'PO210128135422',
        '2025-06-10 03:29:18',
        'test data ''data'' coba dul#$$%%^^',
        'wardi',
        '100000',
        '16688319',
        '16788319',
        ''
 



-- select * from POPAKINGLIST_KURS where No_Pli='BMI_PL25061008164'