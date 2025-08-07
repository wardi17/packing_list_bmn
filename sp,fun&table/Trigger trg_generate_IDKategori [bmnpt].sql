
USE [bmnpt]
GO
ALTER TRIGGER trg_generate_IDKategori
ON MasterKategori
AFTER INSERT
AS
BEGIN
    DECLARE @newId VARCHAR(20);
    DECLARE @newSeq INT;
    -- Ambil nomor urut terakhir dari Id_Trans yang sudah ada, dengan format 'CO.xxx'
    SELECT @newSeq = MAX(CAST(RIGHT(IDKategori, LEN(IDKategori) - 4) AS INT)) + 1
    FROM MasterKategori
    WHERE IDKategori LIKE 'MKT.%';
    -- Jika tidak ada data sebelumnya, mulai dengan angka 1
    IF @newSeq IS NULL
    BEGIN
        SET @newSeq = 1;
    END
    -- Generate Id_Trans dengan format CO.001, CO.002, ...
    SET @newId = 'MKT.' + RIGHT('000' + CAST(@newSeq AS VARCHAR(3)), 3);
    -- Update baris yang baru saja diinsert dengan Id_Trans yang sudah digenerate
    UPDATE MasterKategori
    SET IDKategori = @newId
    WHERE IDKategori IS NULL;
END;