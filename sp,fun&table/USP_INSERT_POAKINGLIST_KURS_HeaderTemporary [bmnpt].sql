USE [bmnpt]
GO

SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

-- Alter Procedure
CREATE PROCEDURE [dbo].[USP_INSERT_POAKINGLIST_KURS_HeaderTemporary]
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
        FROM [dbo].[POPAKINGLIST_KURS_Temporary] 
        WHERE No_Pls = @No_Pls
    )
    BEGIN
        -- Masukkan data ke POPAKINGLIST_KURS_Temporary
        INSERT INTO [dbo].[POPAKINGLIST_KURS_Temporary] (
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
            @total_usd,@total_rp,@total_amountakhir,@total_Prosentase,
			@Note2
        )


    END
END
GO


 /* EXEC USP_INSERT_POAKINGLIST_KURS_HeaderTemporary
            'BMI_PL250612081521',
            'PC',
            'CHILINK',
            '7721000044',
            'PO210111124649',
            '2025-06-12 03:57:02',
            '      keterangan ini '' dibuat berdasarkan '' coba',
            'wardi',
            '500000',
            '71688319',
            '72188319',
            'BL',
            '0.00',
            '0',
            '0',
            '0.00',
			''*/
			


