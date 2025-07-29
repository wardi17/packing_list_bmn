USE [bmnpt]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

ALTER PROCEDURE [dbo].[USP_PostingDataKurFinal]
    @No_Pls VARCHAR(20),
    @userid VARCHAR(100),
    @dateposting DATETIME
AS
BEGIN
    SET NOCOUNT ON;

    DECLARE @return_code INT;

    BEGIN TRANSACTION;

    -----------------------------------
    -- 1. Simpan History Header
    -----------------------------------
    EXEC @return_code = [dbo].[Insert_Popakinglist_Header_History] @No_Pls;
    IF @return_code IS NULL OR @return_code <> 0
    BEGIN
        ROLLBACK TRANSACTION;
        RETURN -1;
    END

    -----------------------------------
    -- 2. Simpan History Forwarder Detail
    -----------------------------------
    EXEC @return_code = [dbo].[Insert_ForwarderDetail_History] @No_Pls;
    IF @return_code IS NULL OR @return_code <> 0
    BEGIN
        ROLLBACK TRANSACTION;
        RETURN -2;
    END

    -----------------------------------
    -- 3. Simpan History Detail
    -----------------------------------
    EXEC @return_code = [dbo].[Insert_Popakinglist_Detail_History] @No_Pls;
    IF @return_code IS NULL OR @return_code <> 0
    BEGIN
        ROLLBACK TRANSACTION;
        RETURN -3;
    END

    -----------------------------------
    -- 4. Replace Header Baru
    -----------------------------------
    EXEC @return_code = [dbo].[Insert_Popakinglist_Header_New] @No_Pls;
    IF @return_code IS NULL OR @return_code <> 0
    BEGIN
        ROLLBACK TRANSACTION;
        RETURN -4;
    END

    -----------------------------------
    -- 5. Replace Forwarder Baru
    -----------------------------------
    EXEC @return_code = [dbo].[Insert_ForwarderDetail_New] @No_Pls;
    IF @return_code IS NULL OR @return_code <> 0
    BEGIN
        ROLLBACK TRANSACTION;
        RETURN -5;
    END

    -----------------------------------
    -- 6. Replace Detail Baru
    -----------------------------------
    EXEC @return_code = [dbo].[Insert_Popakinglist_Detail_New] @No_Pls;
    IF @return_code IS NULL OR @return_code <> 0
    BEGIN
        ROLLBACK TRANSACTION;
        RETURN -6;
    END

    -----------------------------------

    -- 7. Upate Detail Baru file selisih

    -- 6. Upate Detail Baru file selisih

    -----------------------------------
    EXEC @return_code = [dbo].[Update_Popakinglist_Detail_New] @No_Pls;
    IF @return_code IS NULL OR @return_code <> 0
    BEGIN
        ROLLBACK TRANSACTION;
        RETURN -7;
    END


    -----------------------------------
    -- 8. Update Status Posting
    -----------------------------------
    UPDATE [dbo].POPAKINGLIST_KURS_Temporary
    SET FlagPosting = 'Y',
        DatePosting = @dateposting,
        UserPosting = @userid
    WHERE No_Pls = @No_Pls;

    UPDATE [dbo].POPAKINGLIST_KURS
    SET FlagPosting = 'Y',
        DatePosting = @dateposting,
        UserPosting = @userid
    WHERE No_Pls = @No_Pls;




    
   -----------------------------------
    -- 9. Upate Detail Baru file selisih
    -----------------------------------
    EXEC @return_code = [dbo].[Update_Partmaster_HargaBeli] @No_Pls;
    IF @return_code IS NULL OR @return_code <> 0
    BEGIN
        ROLLBACK TRANSACTION;
        RETURN -9;
    END

    -----------------------------------
    -- 10. Commit Transaksi

    -----------------------------------
    COMMIT TRANSACTION;
    RETURN 0;
END
GO

/*EXEC USP_PostingDataKurFinal 
    'BMI_PL250612081521', 
    'wardiman', 
    '2025-07-02 11:26:51';*/
