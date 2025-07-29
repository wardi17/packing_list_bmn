USE [bambi-bmi]
GO

/****** Object:  Table [dbo].[POTRANSACTIONDETAILBMN]    Script Date: 11/8/2024 2:41:19 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[POTRANSACTIONDETAILBMN](
	[DOTransacID] [char](15) NOT NULL,
	[ItemNo] [float] NULL,
	[ItemNoDO] [float] NULL,
	[Partid] [char](10) NOT NULL,
	[PartName] [char](60) NULL,
	[Prodclass] [char](10) NULL,
	[Subprod] [char](10) NULL,
	[ItemNoSO] [float] NULL,
	[WhsSentul] [char](10) NULL,
	[WhsSunter] [char](10) NULL,
	[QtyDelSentul] [float] NULL,
	[QtyDelSunter] [float] NULL,
	[UnitPrice] [float] NULL,
	[discpercen] [float] NULL,
	[currid] [char](10) NULL,
	[kurs] [float] NULL,
	[itemprice] [float] NULL,
	[amount] [float] NULL,
	[amountrp] [float] NULL,
	[quantity] [float] NULL,
	[satuan] [char](10) NULL
) ON [PRIMARY]
GO


