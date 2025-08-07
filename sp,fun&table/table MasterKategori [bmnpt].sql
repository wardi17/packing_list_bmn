USE [bmnpt]
GO

CREATE TABLE MasterKategori(
    IDKategori VARCHAR(25),
    kategori VARCHAR(100) NOT NULL,
    keterangan text NULL,
    user_input VARCHAR(100) NOT NULL,
    date_input DATETIME  DEFAULT GETDATE(),
    user_edit VARCHAR(100)  NULL,
    date_edit DATETIME 
)
