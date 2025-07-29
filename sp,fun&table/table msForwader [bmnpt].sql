USE [bmnpt]
GO

CREATE TABLE msForwader(
    msID VARCHAR(20),
    keterangan VARCHAR(1500) NOT NULL,
    rumus CHAR(1) DEFAULT 'N',
    hitungan CHAR(1) DEFAULT 'N',
    status_aktif CHAR(1) DEFAULT 'Y',
    user_input VARCHAR(100) NOT NULL,
    date_input DATETIME  DEFAULT GETDATE(),
    user_edit VARCHAR(100)  NULL,
    date_edit DATETIME 
)


INSERT INTO msForwader (keterangan,rumus,hitungan,status_aktif,user_input)
VALUES ('Biaya Freight Charge (Ongkos Kirim)', 'Y', 'Y', 'Y', 'admin');
INSERT INTO msForwader (keterangan,rumus,hitungan,status_aktif,user_input)
VALUES ('Biaya Trucking / Inland Transportation', 'Y', 'Y', 'Y', 'admin');
INSERT INTO msForwader (keterangan,rumus,hitungan,status_aktif,user_input)
VALUES ('Biaya Handling Charges', 'Y', 'N', 'Y', 'admin');


