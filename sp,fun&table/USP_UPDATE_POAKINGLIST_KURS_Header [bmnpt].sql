USE [bmnpt]
GO

SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

-- Alter Procedure
CREATE PROCEDURE [dbo].[USP_UPDATE_POAKINGLIST_KURS_Header]
    @No_Pls VARCHAR(20),
    @No_Pli VARCHAR(200),
    @suplieid VARCHAR(150),
    @NoPo VARCHAR(20),
    @POTransacid VARCHAR(20),
    @EntryDate DATETIME,
    @Note TEXT,
    @UpdateUserIDAccess VARCHAR(150),
    @Pib FLOAT,
    @Forwarder FLOAT,
    @Total FLOAT,
    @id_bl_awb VARCHAR(50),
    @UpdateDateAccess DATETIME,
    @total_usd FLOAT,
    @total_rp FLOAT,
    @total_amountakhir FLOAT,
    @total_Prosentase FLOAT
AS
BEGIN
    SET NOCOUNT ON;
        -- Update data ke POPAKINGLIST_KURS
        UPDATE [dbo].[POPAKINGLIST_KURS] 
          SET No_Pli =@No_Pli, POTransacid=@POTransacid, EntryDate=@EntryDate, Note=@Note,
            UpdateUserIDAccess=@UpdateUserIDAccess, UpdateDateAccess=@UpdateDateAccess, supid=@suplieid, NoPo=@NoPo, 
            Pib=@Pib, Forwarder=@Forwarder, Total=@Total, id_bl_awb=@id_bl_awb,
             total_usd =@total_usd,total_rp=@total_rp,total_amountakhir=@total_amountakhir,total_Prosentase=@total_Prosentase
        WHERE No_Pls=@No_Pls
        

END
GO



	
EXEC  USP_UPDATE_POAKINGLIST_KURS_Header
            'BMI_PL250616103126',
            '',
            'CHILINK',
            '7721000289',
            'PO210302072753',
            '2025-06-16 11:28:46',
            ' ',
            'wardi',
            '100000',
            '1668319',
            '1768319',
            '',
            '2025-06-16 11:28:46',
            '37350.00',
            '541575000.00',
            '543330450.00',
            '-175545000.00'
/*select * from  POPAKINGLIST_KURS WHERE No_Pls='BMI_PL250611090931'*/ 


