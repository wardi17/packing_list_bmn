USE [bambi-bmi]
GO

/****** Object:  Table [dbo].[POTRANSACTIONDETAIL]    Script Date: 11/8/2024 2:41:19 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO
DROP TABLE POPAKINGLISTDETAIL
CREATE TABLE [dbo].[POPAKINGLISTDETAIL](
	[No_Pls] [char](20) NOT NULL,
	[PODetail] [char](20) NOT NULL,
	[ItemNo] [float] NULL,
	[Partid] [char](10) NOT NULL,
	[PartName] [char](60) NULL,
	[satuan] [char](10) NULL,
	[Qty] [float] NULL  DEFAULT 0,
    [CTNS] [float] NULL  DEFAULT 0,
	[CBM] [float] NULL  DEFAULT 0,
	[GTNS] [float] NULL  DEFAULT 0,
	[KGS] [float] NULL  DEFAULT 0,
	[Komposisi] [float] NULL  DEFAULT 0,
	PRIMARY KEY(PODetail)
) 


ALTER TABLE POPAKINGLISTDETAIL
ADD hpp_awal float DEFAULT 0,
pib float DEFAULT 0,
hpp_akhir float  DEFAULT 0
GO

--untuk alert nama kolom
EXEC sp_rename 'POPAKINGLISTDETAIL.hpp', 'hpp_akhir', 'COLUMN';