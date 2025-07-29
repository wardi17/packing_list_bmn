USE [bambi-bmi]
GO

SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
DROP TABLE POPAKINGLIST
CREATE TABLE [dbo].[POPAKINGLIST](
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
	[LastDateAccess] [datetime] NULL,
	[UpdateUserIDAccess] [char](10) NULL,
	[UpdateDateAccess] [datetime] NULL,
	[FlagPosting] [char](1) NULL DEFAULT 'N',
	[UserPosting] [char](10) NULL,
	[DatePosting] [datetime] NULL,

	PRIMARY KEY(No_Pls)
)
GO


