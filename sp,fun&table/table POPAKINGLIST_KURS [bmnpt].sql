USE [bmnpt]
GO

SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[POPAKINGLIST_KURS](
	[No_Pls] [char](20) NOT NULL,
    [No_Pli] [char](20)  NULL,
    [NoPo] [char](30) NULL,
    [POTransacid] [char](30) NULL,
	[id_bl_awb] [char](50) NULL,
	[EntryDate] [datetime] NULL,
	[Note] [text] NULL,
    [supid] [char](30) NULL,
	[Pib][float] NULL DEFAULT 0,
	[Forwarder][float] NULL DEFAULT 0,
	[Total][float] NULL DEFAULT 0,
	[LastUserIDAccess] [char](10) NULL,
	[LastDateAccess] [datetime]  DEFAULT GETDATE(),
	[UpdateUserIDAccess] [char](10) NULL,
	[UpdateDateAccess] [datetime] NULL,
	[FlagPosting] [char](1) NULL DEFAULT 'N',
	[UserPosting] [char](10) NULL,
	[DatePosting] [datetime] NULL,
	total_usd FLOAT DEFAULT 0,
	total_rp FLOAT DEFAULT 0, 
	total_amountakhir FLOAT DEFAULT 0,
	total_Prosentase FLOAT DEFAULT 0,
	[Note2] [text] NULL
	PRIMARY KEY(No_Pls)
)
/*

ALTER TABLE [dbo].[POPAKINGLIST_KURS]
ADD [Note2] [text] NULL;


ALTER  TABLE POPAKINGLIST_KURS
ADD total_usd FLOAT DEFAULT 0,
 total_rp FLOAT DEFAULT 0, 
 total_amountakhir FLOAT DEFAULT 0,
 total_Prosentase FLOAT DEFAULT 0


ALTER  TABLE POPAKINGLIST_KURS
ADD  CONSTRAINT total_usd  DEFAULT 0 FOR  total_usd,
 CONSTRAINT total_rp  DEFAULT 0 FOR total_rp, 
 CONSTRAINT total_amountakhir  DEFAULT 0 FOR total_amountakhir,
CONSTRAINT  total_Prosentase  DEFAULT 0 FOR total_Prosentase
*/


GO

CREATE TABLE FrowaderDetail(
	trsID int IDENTITY(1,1) PRIMARY KEY,
	No_Pls char(20),
	msID VARCHAR(20),
	rumus CHAR(1) DEFAULT 'N',
    hitungan CHAR(1) DEFAULT 'N',
	amount FLOAT,
	FOREIGN KEY (No_Pls) REFERENCES POPAKINGLIST_KURS(No_Pls),
	
);

 CREATE TABLE POPAKINGLIST_KURSDETAIL(
	[No_Pls] [char](20) NOT NULL,
	[ItemNo] [float] NULL,
	[Partid] [char](10) NOT NULL,
	[PartName] [char](60) NULL,
	[satuan] [char](10) NULL,
	[Qty] [float] NULL  DEFAULT 0,
    [Price] [float] NULL  DEFAULT 0,
	[Amount_USD] [float] NULL  DEFAULT 0,
	[Kurs] [float] NULL  DEFAULT 0,
	[Amount_Rp] [float] NULL  DEFAULT 0,
	[Kurs_Akhir] [float] NULL  DEFAULT 0,
	[Amount_Akhir] [float] NULL  DEFAULT 0,
	Hpp_Awal FLOAT DEFAULT 0,
	Hpp_Akhir FLOAT DEFAULT 0,
	Selisih_Hpp FLOAT DEFAULT 0,
	Selisih_Hpp_b FLOAT DEFAULT 0
	FOREIGN KEY (No_Pls) REFERENCES POPAKINGLIST_KURS(No_Pls)
 )


