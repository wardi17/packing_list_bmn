
USE [bmnpt]
GO
CREATE TRIGGER trg_generate_msid
ON msForwader
AFTER INSERT
AS
BEGIN
    DECLARE @newId VARCHAR(20);
    DECLARE @newSeq INT;
    -- Ambil nomor urut terakhir dari Id_Trans yang sudah ada, dengan format 'CO.xxx'
    SELECT @newSeq = MAX(CAST(SUBSTRING(msID, 4, LEN(msID)) AS INT)) + 1
    FROM msForwader
    WHERE msID LIKE 'MF.%';
    -- Jika tidak ada data sebelumnya, mulai dengan angka 1
    IF @newSeq IS NULL
    BEGIN
        SET @newSeq = 1;
    END
    -- Generate Id_Trans dengan format CO.001, CO.002, ...
    SET @newId = 'MF.' + RIGHT('000' + CAST(@newSeq AS VARCHAR(3)), 3);
    -- Update baris yang baru saja diinsert dengan Id_Trans yang sudah digenerate
    UPDATE msForwader
    SET msID = @newId
    WHERE msID IS NULL;
END;