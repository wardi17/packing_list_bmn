USE [bmnpt]
GO

SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

-- Alter Procedure
CREATE PROCEDURE [dbo].[USP_INSERT_POAKINGLIST_KURS_Header]
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
    @id_bl_awb VARCHAR(50),
    @total_usd FLOAT,
    @total_rp FLOAT,
    @total_amountakhir FLOAT,
    @total_Prosentase FLOAT,
    @Note2 TEXT

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
            Pib, Forwarder, Total, id_bl_awb,
            total_usd,total_rp,total_amountakhir,total_Prosentase,
            Note2
        )
        VALUES (
            @No_Pls, @No_Pli, @POTransacid, @EntryDate, @Note,
            @LastUserIDAccess, GETDATE(), @suplieid, @NoPo,
            @Pib, @Forwarder, @Total, @id_bl_awb,
            @total_usd,@total_rp,@total_amountakhir,@total_Prosentase,@Note2
        )


    END
END
GO



	
/*       EXEC USP_INSERT_POAKINGLIST_KURS_Header
            'BMI_PL250616103126',
            '',
            'CHILINK',
            '7721000289',
            'PO210302072753',
            '2025-06-16 10:34:41',
            '',
            'wardi',
            '100000',
            '1668319',
            '1768319',
            '',
            '37350.00',
            '541575000.00',
            '543330450.00',
            '-175545000.00'
select * from  POPAKINGLIST_KURS WHERE No_Pls='BMI_PL241115150743'*/ 


