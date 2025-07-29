USE [bambi-bmi]
GO

SET QUOTED_IDENTIFIER ON
GO

-- Buat prosedur tersimpan
ALTER PROCEDURE USP_SetPibPopakinglistdetail
    @no_pls VARCHAR(100)
AS
BEGIN
    -- Periksa dan hapus temp table jika sudah ada
  	IF EXISTS(SELECT [Table_name] FROM tempdb.information_schema.tables WHERE [Table_name] like '#tempt') 
    BEGIN
      DROP TABLE #tempt;
    END;

    -- Buat temp table
    CREATE TABLE #tempt (
        PODetail   CHAR(1000),
        hpp_awal   FLOAT NULL,
        pib        FLOAT NULL,
        hpp_akhir  FLOAT NULL
    )

    -- Deklarasi variabel
    DECLARE @presen FLOAT

    -- Ambil total dari POPAKINGLIST
    SELECT @presen = Total 
    FROM POPAKINGLIST 
    WHERE no_pls = @no_pls

    -- Isi temp table dengan perhitungan HPP dan PIB
    INSERT INTO #tempt (PODetail, hpp_awal, pib, hpp_akhir)
    SELECT 
        a.PODetail,
        b.harga_beli AS hpp_awal,
        --ROUND(((@presen * a.komposisi) / 100.0) / a.qty, 0) AS pib,
        ((@presen * a.komposisi) / 100) / a.qty AS pib,
        ((@presen * a.komposisi) / 100) / a.qty + b.harga_beli AS hpp_akhir
    FROM POPAKINGLISTdetail a
    INNER JOIN partmaster b ON a.partid = b.Partid
    WHERE a.no_pls = @no_pls

    -- Update data akhir ke tabel detail
    UPDATE a
    SET 
        a.hpp_awal = b.hpp_awal,
        a.pib = b.pib,
        a.hpp_akhir = b.hpp_akhir
    FROM POPAKINGLISTdetail a
    INNER JOIN #tempt b ON a.PODetail = b.PODetail
    WHERE a.no_pls = @no_pls
END
GO

-- Contoh eksekusi prosedur
EXEC USP_SetPibPopakinglistdetail 'BMI_PL250521091448'
