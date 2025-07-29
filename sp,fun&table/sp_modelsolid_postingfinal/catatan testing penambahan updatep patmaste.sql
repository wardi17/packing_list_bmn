-- ==========================================
-- Catatan: Testing Penambahan UPDATE Partmaster
-- ==========================================

-- Data Referensi (harga_beli berdasarkan Partid)
-- +---------------------+-------------+-----------------------------------------------------+
-- |     harga_beli      |   Partid    | partname                                           |
-- +---------------------+-------------+-----------------------------------------------------+
-- |   82.0763020833333  | 01.008.017  | Rado Slot Nickel Plated                            |
-- |  985.371631907912   | 01.001.056  | Mekanik PD 123-2-20/20                              |
-- | 1031.04932735426    | 01.001.057  | Mekanik PD 123-2-25/20 With Bambi Logo             |
-- | 2522.09539525692    | 01.001.150  | Mekanik LAF Folio Chi Link Blue Cyber              |
-- | 441.585             | 01.005.009  | Slide in plate Chi Link                             |
-- |  77.1708490210843   | 01.008.018  | Finger Ring Nickel Plated                          |
-- | 1015.30003517411    | 01.001.055  | Mekanik PD 123-2-16/20                             |
-- | 2288.71248286634    | 01.001.065  | Mekanik PD 264 - 3 - 25 / 20                       |
-- | 2205.32394520548    | 01.001.105  | Mekanik PD 292 - 4 - 20 / 20                       |
-- | 441.33347826087     | 01.001.151  | Compressor bar Chi Link Blue Cyber                |
-- | 2524.97391304348    | 01.001.155  | Mekanik LAF Small Chi Link Blue Cyber             |
-- | 47957.7407621393    | 01.028.009  | Tin Plate Chi Link                                 |
-- +---------------------+-------------+-----------------------------------------------------+
select * from FrowaderDetail_Temporary where No_Pls='BMI_PL250711093710'
select * from POPAKINGLIST_KURS_Temporary where No_Pls='BMI_PL250711093710'
select * from POPAKINGLIST_KURSDETAIL_Temporary where No_Pls='BMI_PL250711093710'


delete from FrowaderDetail_HISTORY where No_Pls='BMI_PL250711093710'
delete from POPAKINGLIST_KURSDETAIL_HISTORY where No_Pls='BMI_PL250711093710'
delete from POPAKINGLIST_KURS_HISTORY where No_Pls='BMI_PL250711093710'

delete from FrowaderDetail_Temporary where No_Pls='BMI_PL250711093710'
delete from POPAKINGLIST_KURSDETAIL_Temporary where No_Pls='BMI_PL250711093710'
delete from POPAKINGLIST_KURS_Temporary where No_Pls='BMI_PL250711093710'


-- UPDATE harga_beli berdasarkan Partid
UPDATE partmaster
SET harga_beli = CASE Partid
    WHEN '01.008.017' THEN 82.0763020833333
    WHEN '01.001.056' THEN 985.371631907912
    WHEN '01.001.057' THEN 1031.04932735426
    WHEN '01.001.150' THEN 2522.09539525692
    WHEN '01.005.009' THEN 441.585
    WHEN '01.008.018' THEN 77.1708490210843
    WHEN '01.001.055' THEN 1015.30003517411
    WHEN '01.001.065' THEN 2288.71248286634
    WHEN '01.001.105' THEN 2205.32394520548
    WHEN '01.001.151' THEN 441.33347826087
    WHEN '01.001.155' THEN 2524.97391304348
    WHEN '01.028.009' THEN 47957.7407621393
END
WHERE Partid IN (
    '01.008.017', '01.001.056', '01.001.057', '01.001.150', 
    '01.005.009', '01.008.018', '01.001.055', '01.001.065',
    '01.001.105', '01.001.151', '01.001.155', '01.028.009'
);

-- ====================================================
-- Cek hasil update harga_beli terhadap selisih kurs
-- ====================================================
SELECT 
    a.harga_beli,
    b.Partid,
    a.partname,
    b.Selisih_Hpp,
    b.Selisih_Hpp_b,
    (b.Selisih_Hpp - b.Selisih_Hpp_b) AS selisih_baru,
    (a.harga_beli - (b.Selisih_Hpp - b.Selisih_Hpp_b)) AS harga_lama_perkiraan
FROM partmaster AS a
LEFT JOIN POPAKINGLIST_KURSDETAIL AS b ON b.Partid = a.Partid
WHERE b.No_Pls = 'BMI_PL250711093710';
