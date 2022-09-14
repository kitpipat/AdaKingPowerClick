--############################################################################################
-- สร้าง		  : 05-09-2021 
-- โดย			 : เจมส์
-- เวอร์ชั่น		: 00.00.01
-- เพิ่มตารางเก็บ Transection Tax Address : TPSTTaxHDAddress

IF OBJECT_ID(N'TPSTTaxHDAddress') IS NULL BEGIN
	CREATE TABLE [dbo].[TPSTTaxHDAddress](
		[FTBchCode] [varchar](5) NOT NULL,
		[FTXshDocNo] [varchar](20) NOT NULL,
		[FTAddTaxNo] [varchar](20) NULL,
		[FTAddName] [varchar](200) NULL,
		[FTAddRmk] [varchar](200) NULL,
		[FTAddCountry] [varchar](100) NULL,
		[FTAreCode] [varchar](5) NULL,
		[FTZneCode] [varchar](30) NULL,
		[FTAddVersion] [varchar](1) NULL,
		[FTAddV1No] [varchar](30) NULL,
		[FTAddV1Soi] [varchar](30) NULL,
		[FTAddV1Village] [varchar](70) NULL,
		[FTAddV1Road] [varchar](30) NULL,
		[FTAddV1SubDist] [varchar](30) NULL,
		[FTAddV1DstCode] [varchar](5) NULL,
		[FTAddV1PvnCode] [varchar](5) NULL,
		[FTAddV1PostCode] [varchar](5) NULL,
		[FTAddV2Desc1] [varchar](255) NULL,
		[FTAddV2Desc2] [varchar](255) NULL,
		[FTAddWebsite] [varchar](200) NULL,
		[FTAddLongitude] [varchar](50) NULL,
		[FTAddLatitude] [varchar](50) NULL,
		[FTAddStaBusiness] [varchar](1) NULL,
		[FTAddStaHQ] [varchar](1) NULL,
		[FTAddStaBchCode] [varchar](5) NULL,
		[FTAddTel] [varchar](50) NULL,
		[FTAddFax] [varchar](50) NULL,
		[FTAddRefNo] [varchar](20) NULL,
		[FDLastUpdOn] [datetime] NULL,
		[FTLastUpdBy] [varchar](20) NULL,
		[FDCreateOn] [datetime] NULL,
		[FTCreateBy] [varchar](20) NULL,
	 CONSTRAINT [PK_TPSTTaxHDAddress] PRIMARY KEY CLUSTERED 
	(
		[FTBchCode] ASC,
		[FTXshDocNo] ASC
	)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
	) ON [PRIMARY]
END
GO

--############################################################################################
-- สร้าง		  : 05-09-2021 
-- โดย			 : เจมส์
-- เวอร์ชั่น		: 00.00.01
-- เพิ่มฟิวส์ TLKTLogHis.FTApiCode

IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TLKTLogHis' AND COLUMN_NAME = 'FTApiCode') BEGIN
	ALTER TABLE TLKTLogHis ADD FTApiCode VARCHAR(10)
END
GO

--############################################################################################
-- สร้าง		  : 13-12-2021 
-- โดย			 : เจมส์
-- เวอร์ชั่น		: 00.00.02
-- เพิ่มตารางที่เกี่ยวข้องกับ เอกสารใบขอโอน-สาขา
-- เพิ่มตารางที่เกี่ยวข้องกับ การอัพโหลดไฟล์

IF NOT EXISTS(SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'TCNMFleObj') BEGIN
	/****** Object:  Table [dbo].[TCNMFleObj]    Script Date: 13/12/2564 10:39:58 ******/
	CREATE TABLE [dbo].[TCNMFleObj](
		[FNFleID] [int] IDENTITY(1,1) NOT NULL,
		[FTFleRefTable] [varchar](50) NULL,
		[FTFleRefID1] [varchar](50) NULL,
		[FTFleRefID2] [varchar](50) NULL,
		[FNFleSeq] [bigint] NULL,
		[FTFleType] [varchar](10) NULL,
		[FTFleObj] [varchar](255) NULL,
		[FTFleName] [varchar](255) NULL,
		[FDLastUpdOn] [datetime] NULL,
		[FTLastUpdBy] [varchar](50) NULL,
		[FDCreateOn] [datetime] NULL,
		[FTCreateBy] [varchar](50) NULL,
	PRIMARY KEY CLUSTERED 
	(
		[FNFleID] ASC
	)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
	) ON [PRIMARY]
END
GO

IF NOT EXISTS(SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'TCNMFleObjTmp') BEGIN
	/****** Object:  Table [dbo].[TCNMFleObjTmp]    Script Date: 13/12/2564 10:39:58 ******/
	CREATE TABLE [dbo].[TCNMFleObjTmp](
		[FTFleRefTable] [varchar](50) NULL,
		[FTFleRefID1] [varchar](50) NULL,
		[FTFleRefID2] [varchar](50) NULL,
		[FNFleSeq] [bigint] NULL,
		[FTFleType] [varchar](255) NULL,
		[FTFleObj] [varchar](255) NULL,
		[FDCreateOn] [datetime] NULL,
		[FTSessionID] [varchar](255) NULL,
		[FTFleName] [varchar](100) NULL,
		[FTFleStaUpd] [varchar](1) NULL
	) ON [PRIMARY]
END
GO

IF NOT EXISTS(SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'TCNSNoti') BEGIN
	/****** Object:  Table [dbo].[TCNSNoti]    Script Date: 13/12/2564 14:19:20 ******/
	CREATE TABLE [dbo].[TCNSNoti](
		[FTNotCode] [varchar](5) NOT NULL,
		[FTNotStaResponse] [bigint] NULL,
		[FDLastUpdOn] [datetime] NULL,
		[FTLastUpdBy] [varchar](20) NULL,
		[FDCreateOn] [datetime] NULL,
		[FTCreateBy] [varchar](20) NULL,
	PRIMARY KEY CLUSTERED 
	(
		[FTNotCode] ASC
	)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
	) ON [PRIMARY]
END
GO

IF NOT EXISTS(SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'TCNSNoti_L') BEGIN
	/****** Object:  Table [dbo].[TCNSNoti_L]    Script Date: 13/12/2564 14:19:20 ******/
	CREATE TABLE [dbo].[TCNSNoti_L](
		[FTNotCode] [varchar](5) NOT NULL,
		[FNLngID] [int] NULL,
		[FTNotTypeName] [varchar](100) NULL,
		[FTNotRmk] [varchar](200) NULL,
	PRIMARY KEY CLUSTERED 
	(
		[FTNotCode] ASC
	)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
	) ON [PRIMARY]
END
GO

IF NOT EXISTS(SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'TCNTUsrNoti') BEGIN
	/****** Object:  Table [dbo].[TCNTUsrNoti]    Script Date: 13/12/2564 14:19:20 ******/
	CREATE TABLE [dbo].[TCNTUsrNoti](
		[FTUsrCode] [varchar](20) NOT NULL,
		[FNNotID] [bigint] NOT NULL,
		[FTNotCode] [varchar](5) NULL,
		[FTNotTypeName] [varchar](100) NULL,
		[FNNotUrlType] [bigint] NULL,
		[FTNotUrlRef] [varchar](255) NULL,
		[FTAgnCode] [varchar](10) NULL,
		[FTNotBchRef] [varchar](5) NULL,
		[FTNotDocRef] [varchar](50) NULL,
		[FDNotDate] [datetime] NULL,
		[FTNotDesc1] [varchar](255) NULL,
		[FTNotDesc2] [varchar](255) NULL,
		[FTStaRead] [varchar](1) NULL,
		[FTNotUrlRef2] [varchar](255) NULL,
	CONSTRAINT [PK_TCNTUsrNoti] PRIMARY KEY CLUSTERED 
	(
		[FTUsrCode] ASC,
		[FNNotID] ASC
	)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
	) ON [PRIMARY]
END
GO

IF NOT EXISTS(SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'TCNTUsrNotiAct') BEGIN
	/****** Object:  Table [dbo].[TCNTUsrNotiAct]    Script Date: 13/12/2564 14:19:20 ******/
	CREATE TABLE [dbo].[TCNTUsrNotiAct](
		[FTUsrCode] [varchar](20) NOT NULL,
		[FNNotID] [bigint] NOT NULL,
		[FDNoaDateIns] [datetime] NOT NULL,
		[FTNoaDesc] [varchar](255) NULL,
	CONSTRAINT [PK_TCNTUsrNotiAct] PRIMARY KEY CLUSTERED 
	(
		[FTUsrCode] ASC,
		[FNNotID] ASC,
		[FDNoaDateIns] ASC
	)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
	) ON [PRIMARY]
END
GO

IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TCNSRptSpc' AND COLUMN_NAME = 'FTRolCode') BEGIN
	ALTER TABLE TCNSRptSpc ADD FTRolCode VARCHAR(5)
END
GO

IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TCNMUser' AND COLUMN_NAME = 'FDUsrLastNoti') BEGIN
	ALTER TABLE TCNMUser ADD FDUsrLastNoti datetime
END
GO

IF NOT EXISTS(SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'TCNTDocHDRefTmp') BEGIN
	/****** Object:  Table [dbo].[TCNTDocHDRefTmp]    Script Date: 14/12/2564 17:30:46 ******/
	CREATE TABLE [dbo].[TCNTDocHDRefTmp](
		[FTXthDocNo] [varchar](20) NOT NULL,
		[FTXthRefDocNo] [varchar](20) NOT NULL,
		[FTXthRefType] [varchar](1) NULL,
		[FTXthRefKey] [varchar](10) NULL,
		[FDXthRefDocDate] [datetime] NULL,
		[FTXthDocKey] [varchar](20) NOT NULL,
		[FTSessionID] [varchar](255) NOT NULL,
		[FDCreateOn] [datetime] NULL,
	CONSTRAINT [PK_TCNTDocHDRefTmp] PRIMARY KEY CLUSTERED 
	(
		[FTXthDocNo] ASC,
		[FTXthRefDocNo] ASC,
		[FTXthDocKey] ASC,
		[FTSessionID] ASC
	)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
	) ON [PRIMARY]
END
GO

IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TCNTDocDTTmp' AND COLUMN_NAME = 'FTXtdPdtSetOrSN') BEGIN
	ALTER TABLE TCNTDocDTTmp ADD FTXtdPdtSetOrSN varchar(1)
END
GO

IF NOT EXISTS(SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'TCNTDocDTSNTmp') BEGIN
	/****** Object:  Table [dbo].[TCNTDocDTSNTmp]    Script Date: 27/12/2564 20:50:25 ******/
	CREATE TABLE [dbo].[TCNTDocDTSNTmp](
		[FTAgnCode] [varchar](10) NOT NULL,
		[FTBchCode] [varchar](5) NOT NULL,
		[FTXthDocNo] [varchar](20) NOT NULL,
		[FNXtdSeqNo] [int] NOT NULL,
		[FTPdtSerial] [varchar](20) NOT NULL,
		[FTXtdStaRet] [varchar](1) NULL,
		[FTPdtBatchID] [varchar](20) NULL,
		[FDLastUpdOn] [datetime] NULL,
		[FDCreateOn] [datetime] NULL,
		[FTLastUpdBy] [varchar](20) NULL,
		[FTCreateBy] [varchar](20) NULL,
		[FTXthDocKey] [varchar](50) NOT NULL,
		[FTSessionID] [varchar](255) NOT NULL,
	CONSTRAINT [PK_TCNTDocDTSNTmp] PRIMARY KEY CLUSTERED 
	(
		[FTAgnCode] ASC,
		[FTBchCode] ASC,
		[FTXthDocNo] ASC,
		[FNXtdSeqNo] ASC,
		[FTPdtSerial] ASC,
		[FTSessionID] ASC
	)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
	) ON [PRIMARY]
	
	ALTER TABLE [dbo].[TCNTDocDTSNTmp] ADD  CONSTRAINT [DF_TCNTDocDTSNTmp_FTXthDocKey]  DEFAULT (NULL) FOR [FTXthDocKey]
END
GO

IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TCNTDocDTTmp' AND COLUMN_NAME = 'FCXtdQtyOrd') BEGIN
	ALTER TABLE TCNTDocDTTmp ADD FCXtdQtyOrd numeric(18, 4)
END
GO

IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TCNTPdtTwxHDRef' AND COLUMN_NAME = 'FTCarCode') BEGIN
	ALTER TABLE TCNTPdtTwxHDRef ADD FTCarCode VARCHAR(50)
END
GO

IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TCNTPdtTwoHD' AND COLUMN_NAME = 'FTCstCode') BEGIN
	ALTER TABLE TCNTPdtTwoHD ADD FTCstCode varchar(20);
END
GO

IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TCNTPdtTwiHD' AND COLUMN_NAME = 'FTCstCode') BEGIN
	ALTER TABLE TCNTPdtTwiHD ADD FTCstCode varchar(20);
END
GO

--############################################################################################
-- สร้าง		  : 25-01-2022 
-- โดย			 : เจมส์
-- เวอร์ชั่น		: 00.00.03
-- เพิ่มตาราง Temp เพื่อเก็บข้อมูลระดับลูกค้าในหน้าจอโปรโมชั่น

IF NOT EXISTS(SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'TCNTPdtPmtHDCstLev_Tmp') BEGIN
	CREATE TABLE [dbo].[TCNTPdtPmtHDCstLev_Tmp](
	[FTBchCode] [varchar](5) NOT NULL,
	[FTPmhDocNo] [varchar](20) NOT NULL,
	[FTClvCode] [varchar](20) NOT NULL,
	[FTClvName] [varchar](50) NULL,
	[FTPmhStaType] [varchar](1) NULL,
	[FTSessionID] [varchar](255) NOT NULL,
	[FDCreateOn] [datetime] NULL
	) ON [PRIMARY]
END
GO

IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TRPTSalByPdtSetTmp' AND COLUMN_NAME = 'FDTmpTxnDate') BEGIN ALTER TABLE TRPTSalByPdtSetTmp ADD FDTmpTxnDate DATETIME CONSTRAINT DF_TRPTSalByPdtSetTmp_FDTmpTxnDate DEFAULT(GETDATE()) END
GO
IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TRPTMnyShotOverDailyDTTmp' AND COLUMN_NAME = 'FDTmpTxnDate') BEGIN ALTER TABLE TRPTMnyShotOverDailyDTTmp ADD FDTmpTxnDate DATETIME CONSTRAINT DF_TRPTMnyShotOverDailyDTTmp_FDTmpTxnDate DEFAULT(GETDATE()) END 
GO
IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TRPTMnyShotOverMonthlyTmp' AND COLUMN_NAME = 'FDTmpTxnDate') BEGIN ALTER TABLE TRPTMnyShotOverMonthlyTmp ADD FDTmpTxnDate DATETIME CONSTRAINT DF_TRPTMnyShotOverMonthlyTmp_FDTmpTxnDate DEFAULT(GETDATE()) END 
GO
IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TRPTMnyShotOverTmp' AND COLUMN_NAME = 'FDTmpTxnDate') BEGIN ALTER TABLE TRPTMnyShotOverTmp ADD FDTmpTxnDate DATETIME CONSTRAINT DF_TRPTMnyShotOverTmp_FDTmpTxnDate DEFAULT(GETDATE()) END 
GO
IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TRPTPSTTaxDateFullTmp' AND COLUMN_NAME = 'FDTmpTxnDate') BEGIN ALTER TABLE TRPTPSTTaxDateFullTmp ADD FDTmpTxnDate DATETIME CONSTRAINT DF_TRPTPSTTaxDateFullTmp_FDTmpTxnDate DEFAULT(GETDATE()) END 
GO
IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TRPTSalByCashierAndPosTmp' AND COLUMN_NAME = 'FDTmpTxnDate') BEGIN ALTER TABLE TRPTSalByCashierAndPosTmp ADD FDTmpTxnDate DATETIME CONSTRAINT DF_TRPTSalByCashierAndPosTmp_FDTmpTxnDate DEFAULT(GETDATE()) END 
GO
IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TRPTSalByCstTmp' AND COLUMN_NAME = 'FDTmpTxnDate') BEGIN ALTER TABLE TRPTSalByCstTmp ADD FDTmpTxnDate DATETIME CONSTRAINT DF_TRPTSalByCstTmp_FDTmpTxnDate DEFAULT(GETDATE()) END 
GO
IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TRPTSalDailyTmp' AND COLUMN_NAME = 'FDTmpTxnDate') BEGIN ALTER TABLE TRPTSalDailyTmp ADD FDTmpTxnDate DATETIME CONSTRAINT DF_TRPTSalDailyTmp_FDTmpTxnDate DEFAULT(GETDATE()) END 
GO
IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TRPTSalPdtBillTmp' AND COLUMN_NAME = 'FDTmpTxnDate') BEGIN ALTER TABLE TRPTSalPdtBillTmp ADD FDTmpTxnDate DATETIME CONSTRAINT DF_TRPTSalPdtBillTmp_FDTmpTxnDate DEFAULT(GETDATE()) END 
GO
IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TRPTSalShiftTmp' AND COLUMN_NAME = 'FDTmpTxnDate') BEGIN ALTER TABLE TRPTSalShiftTmp ADD FDTmpTxnDate DATETIME CONSTRAINT DF_TRPTSalShiftTmp_FDTmpTxnDate DEFAULT(GETDATE()) END 
GO
IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TRPTVDPayTmp' AND COLUMN_NAME = 'FDTmpTxnDate') BEGIN ALTER TABLE TRPTVDPayTmp ADD FDTmpTxnDate DATETIME CONSTRAINT DF_TRPTVDPayTmp_FDTmpTxnDate DEFAULT(GETDATE()) END 
GO
IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TRPTVDSumPayByDateTmp' AND COLUMN_NAME = 'FDTmpTxnDate') BEGIN ALTER TABLE TRPTVDSumPayByDateTmp ADD FDTmpTxnDate DATETIME CONSTRAINT DF_TRPTVDSumPayByDateTmp_FDTmpTxnDate DEFAULT(GETDATE()) END 
GO
IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TRPTAdjPriceTmp' AND COLUMN_NAME = 'FDTmpTxnDate') BEGIN ALTER TABLE TRPTAdjPriceTmp ADD FDTmpTxnDate DATETIME CONSTRAINT DF_TRPTAdjPriceTmp_FDTmpTxnDate DEFAULT(GETDATE()) END 
GO
IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TTRPTPSByPeriodTmpAda062' AND COLUMN_NAME = 'FDTmpTxnDate') BEGIN ALTER TABLE TTRPTPSByPeriodTmpAda062 ADD FDTmpTxnDate DATETIME CONSTRAINT DF_TTRPTPSByPeriodTmpAda062_FDTmpTxnDate DEFAULT(GETDATE()) END 
GO
IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TRPTPdtStkCrdSumTmp' AND COLUMN_NAME = 'FDTmpTxnDate') BEGIN ALTER TABLE TRPTPdtStkCrdSumTmp ADD FDTmpTxnDate DATETIME CONSTRAINT DF_TRPTPdtStkCrdSumTmp_FDTmpTxnDate DEFAULT(GETDATE()) END 
GO
IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TRPTPSCompareMTDTmp' AND COLUMN_NAME = 'FDTmpTxnDate') BEGIN ALTER TABLE TRPTPSCompareMTDTmp ADD FDTmpTxnDate DATETIME CONSTRAINT DF_TRPTPSCompareMTDTmp_FDTmpTxnDate DEFAULT(GETDATE()) END 
GO
IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TRPTPSCompareYTDTmp' AND COLUMN_NAME = 'FDTmpTxnDate') BEGIN ALTER TABLE TRPTPSCompareYTDTmp ADD FDTmpTxnDate DATETIME CONSTRAINT DF_TRPTPSCompareYTDTmp_FDTmpTxnDate DEFAULT(GETDATE()) END 
GO
IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TRPTSalByBillPdtTmp' AND COLUMN_NAME = 'FDTmpTxnDate') BEGIN ALTER TABLE TRPTSalByBillPdtTmp ADD FDTmpTxnDate DATETIME CONSTRAINT DF_TRPTSalByBillPdtTmp_FDTmpTxnDate DEFAULT(GETDATE()) END 
GO
IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TRPTPSSDailyBySChnTmp' AND COLUMN_NAME = 'FDTmpTxnDate') BEGIN ALTER TABLE TRPTPSSDailyBySChnTmp ADD FDTmpTxnDate DATETIME CONSTRAINT DF_TRPTPSSDailyBySChnTmp_FDTmpTxnDate DEFAULT(GETDATE()) END 
GO

--############################################################################################
-- สร้าง		  : 26-01-2022 
-- โดย			 : เจมส์
-- เวอร์ชั่น		: 00.00.04
-- เพิ่มฟิวส์ในตาราง TCNTPdtPmtCG_Tmp

IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TCNTPdtPmtCG_Tmp' AND COLUMN_NAME = 'FTSplCode') BEGIN
	ALTER TABLE TCNTPdtPmtCG_Tmp ADD FTSplCode varchar(20)
END
GO

IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TCNTPdtPmtCG_Tmp' AND COLUMN_NAME = 'FDPgtPntStart') BEGIN
	ALTER TABLE TCNTPdtPmtCG_Tmp ADD FDPgtPntStart datetime
END
GO

IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TCNTPdtPmtCG_Tmp' AND COLUMN_NAME = 'FDPgtPntExpired') BEGIN
	ALTER TABLE TCNTPdtPmtCG_Tmp ADD FDPgtPntExpired datetime
END
GO

IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TCNMTxnAPI' AND COLUMN_NAME = 'FTApiStaDisplay') BEGIN
	ALTER TABLE TCNMTxnAPI ADD FTApiStaDisplay VARCHAR(1)
END
GO

--############################################################################################
-- สร้าง		  : 04-02-2022 
-- โดย			 : เจมส์
-- เวอร์ชั่น		: 00.00.05

IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TLKTSalHD' AND COLUMN_NAME = 'FTXshLngCode' AND CHARACTER_OCTET_LENGTH = 2) BEGIN
	ALTER TABLE TLKTSalHD ALTER COLUMN FTXshLngCode VARCHAR(2) /*ปรับจาก Script เดิม เป็น 2 */
END
GO

IF NOT EXISTS(SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'TCNMAdjPdtTmp') BEGIN
	CREATE TABLE [dbo].[TCNMAdjPdtTmp](
		[FNRowID] [bigint] NULL,
		[FTAgnCode] [varchar](10) NULL,
		[FTBchCode] [varchar](5) NULL,
		[FTPdtCode] [varchar](20) NULL,
		[FTPdtName] [varchar](150) NULL,
		[FTPunCode] [varchar](5) NULL,
		[FTPunName] [varchar](100) NULL,
		[FTBarCode] [varchar](25) NULL,
		[FTPgpChain] [varchar](30) NULL,
		[FTPgpName] [varchar](100) NULL,
		[FTPbnCode] [varchar](10) NULL,
		[FTPbnName] [varchar](100) NULL,
		[FTPmoCode] [varchar](10) NULL,
		[FTPmoName] [varchar](100) NULL,
		[FTPtyCode] [varchar](10) NULL,
		[FTPtyName] [varchar](100) NULL,
		[FTStaAlwSet] [varchar](1) NULL,
		[FTSessionID] [varchar](255) NULL,
		[FTBchName] [varchar](100) NULL,
		[FDCreateOn] [datetime] NULL
	) ON [PRIMARY]
	
	ALTER TABLE [dbo].[TCNMAdjPdtTmp] ADD  CONSTRAINT [DF_TCNMAdjPdtTmp_FDCreateOn]  DEFAULT (getdate()) FOR [FDCreateOn]
	
END
GO

--############################################################################################
-- สร้าง		  : 17-02-2022 
-- โดย			 : เจมส์
-- เวอร์ชั่น		: 00.00.06

IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TRPTVDPdtStkBalTmp' AND COLUMN_NAME = 'FTPosName') BEGIN
	ALTER TABLE TRPTVDPdtStkBalTmp ADD FTPosName VARCHAR(100)
END
GO

--############################################################################################
-- สร้าง		  : 18-02-2022 
-- โดย			 : เจมส์
-- เวอร์ชั่น		: 00.00.07

-- ปิดไปเนื่องจากมีเวอชั่นใหม่ ใช้ Drop and Create Table แล้ว
-- IF NOT EXISTS(SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TCNTPrnLabelTmp' AND COLUMN_NAME = 'FTPlbStaImport') BEGIN
-- 	ALTER TABLE TCNTPrnLabelTmp ADD FTPlbStaImport VARCHAR(1)
-- END
-- GO

-- IF NOT EXISTS(SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TCNTPrnLabelTmp' AND COLUMN_NAME = 'FTPlbImpDesc') BEGIN
-- 	ALTER TABLE TCNTPrnLabelTmp ADD FTPlbImpDesc VARCHAR(255)
-- END
-- GO

--############################################################################################
-- สร้าง		  : 02-03-2022 
-- โดย			 : เจมส์
-- เวอร์ชั่น		: 00.00.08
/*============================================================= START Arm 65-03-01 =================================================================*/
IF NOT EXISTS(SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TLKTSalDT' AND COLUMN_NAME = 'FTXsdVatType') BEGIN
	ALTER TABLE TLKTSalDT ADD FTXsdVatType VARCHAR(1) 
END
GO
IF NOT EXISTS(SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TLKTSalDT' AND COLUMN_NAME = 'FCXsdVatRate') BEGIN
	ALTER TABLE TLKTSalDT ADD FCXsdVatRate NUMERIC(18,4)
END
GO
/*============================================================= END Arm 65-03-01 =================================================================*/

IF NOT EXISTS(SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'TVDTRptRcvInfoTrialPdtVDTmp') BEGIN
	CREATE TABLE [dbo].[TVDTRptRcvInfoTrialPdtVDTmp](
		[FTBchCode] [varchar](5) NULL,
		[FTBchName] [varchar](100) NULL,
		[FTShpCode] [varchar](5) NULL,
		[FTShpName] [varchar](100) NULL,
		[FTMerCode] [varchar](10) NULL,
		[FTBkpRef1] [varchar](30) NULL,
		[FDXshDocDate] [datetime] NULL,
		[FTBkpType] [varchar](1) NULL,
		[FTPdtCode] [varchar](20) NULL,
		[FTPdtName] [varchar](100) NULL,
		[FTPosCode] [varchar](5) NULL,
		[FTPosName] [varchar](100) NULL,
		[FTBkpRef2] [varchar](30) NULL,
		[FCBkdQty] [numeric](18, 4) NULL,
		[FCBkdQtyRcv] [numeric](18, 4) NULL,
		[FTBkpStatus] [varchar](1) NULL,
		[FDBkpDate] [datetime] NULL,
		[FDBkpDateExpire] [datetime] NULL,
		[FTSessionID] [varchar](250) NULL
	) ON [PRIMARY]
END
GO

--############################################################################################
-- สร้าง		  : 17-03-2022 
-- โดย			 : เจมส์
-- เวอร์ชั่น		: 00.00.09

IF OBJECT_ID(N'TCNTBookingPrc') IS NULL BEGIN
	CREATE TABLE [dbo].[TCNTBookingPrc](
		[FTAgnCode] [varchar](10) NOT NULL,
		[FTBchCode] [varchar](5) NOT NULL,
		[FTBkpType] [varchar](1) NOT NULL,
		[FTBkpRef1] [varchar](30) NOT NULL,
		[FTBkpRef2] [varchar](30) NOT NULL,
		[FCBkpQty] [numeric](18, 4) NULL,
		[FCBkpQtyRcv] [numeric](18, 4) NULL,
		[FDBkpDate] [datetime] NULL,
		[FTBkpStatus] [varchar](1) NULL,
		[FTPosCode] [varchar](5) NOT NULL,
		[FDLastUpdOn] [datetime] NULL,
		[FTLastUpdBy] [varchar](20) NULL,
		[FDCreateOn] [datetime] NULL,
		[FTCreateBy] [varchar](20) NULL,
	 CONSTRAINT [PK_TCNTBookingPrc] PRIMARY KEY CLUSTERED 
	(
		[FTAgnCode] ASC,
		[FTBchCode] ASC,
		[FTBkpType] ASC,
		[FTBkpRef1] ASC,
		[FTBkpRef2] ASC
	)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
	) ON [PRIMARY]
END
GO

IF OBJECT_ID(N'TCNTBookingPrcDT') IS NULL BEGIN
	CREATE TABLE [dbo].[TCNTBookingPrcDT](
		[FTAgnCode] [varchar](10) NOT NULL,
		[FTBchCode] [varchar](5) NOT NULL,
		[FTBkpType] [varchar](1) NOT NULL,
		[FTBkpRef1] [varchar](30) NOT NULL,
		[FNBkdSeq] [bigint] NOT NULL,
		[FTPdtCode] [varchar](20) NULL,
		[FCBkdQty] [numeric](18, 4) NULL,
		[FCBkdQtyRcv] [numeric](18, 4) NULL,
		[FTPosCode] [varchar](5) NULL,
		[FTBkdDocRef] [varchar](30) NULL,
		[FDLastUpdOn] [datetime] NULL,
		[FTLastUpdBy] [varchar](20) NULL,
		[FDCreateOn] [datetime] NULL,
		[FTCreateBy] [varchar](20) NULL,
	 CONSTRAINT [PK_TCNTBookingPrcDT] PRIMARY KEY CLUSTERED 
	(
		[FTAgnCode] ASC,
		[FTBchCode] ASC,
		[FTBkpType] ASC,
		[FTBkpRef1] ASC,
		[FNBkdSeq] ASC
	)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
	) ON [PRIMARY]
END
GO

IF EXISTS(SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TCNMTxnAPI' AND COLUMN_NAME = 'FTApiToken') BEGIN
	ALTER TABLE TCNMTxnAPI ALTER COLUMN FTApiToken VARCHAR(500)
END
GO

IF NOT EXISTS(SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TVDTRptRcvInfoTrialPdtVDTmp' AND COLUMN_NAME = 'FTBkpStatusReal') BEGIN
	ALTER TABLE TVDTRptRcvInfoTrialPdtVDTmp ADD FTBkpStatusReal VARCHAR(1)
END
GO

IF NOT EXISTS(SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TPSTSalRC' AND COLUMN_NAME = 'FTRsnCode') BEGIN
	ALTER TABLE TPSTSalRC ADD FTRsnCode VARCHAR(5)
END
GO

IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TSysPosHW' AND COLUMN_NAME = 'FTShwStaAlwUSB') BEGIN
	ALTER TABLE TSysPosHW ADD FTShwStaAlwUSB VARCHAR(1)
END
GO

--############################################################################################
-- สร้าง		  : 25-03-2022 
-- โดย			 : เจมส์
-- เวอร์ชั่น		: 00.00.10

IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TPSTSalHD' AND COLUMN_NAME = 'FCXshPayUse') BEGIN
	ALTER TABLE TPSTSalHD ADD FCXshPayUse DECIMAL(18,4)
END
GO

--############################################################################################
-- สร้าง		  : 31-03-2022 
-- โดย			 : เจมส์
-- เวอร์ชั่น		: 00.00.11

IF OBJECT_ID(N'TPSTShiftSKeyRcvApv') IS NULL BEGIN
	CREATE TABLE [dbo].[TPSTShiftSKeyRcvApv](
		[FTBchCode] [varchar](5) NOT NULL,
		[FTPosCode] [varchar](5) NOT NULL,
		[FTShfCode] [varchar](30) NOT NULL,
		[FNSdtSeqNo] [int] NOT NULL,
		[FTRcvCode] [varchar](3) NOT NULL,
		[FTRcvName] [varchar](100) NULL,
		[FTRcvRefType] [varchar](1) NULL,
		[FTRcvRefNo1] [varchar](100) NULL,
		[FTRcvRefNo2] [varchar](100) NULL,
		[FNRcvUseAmt] [int] NULL,
		[FCRcvPayAmt] [numeric](18, 4) NULL,
		[FCRcvUsrKeyAmt] [numeric](18, 4) NULL,
		[FCRcvUsrKeyDiff] [numeric](18, 4) NULL,
		[FCRcvSupKeyAmt] [numeric](18, 4) NULL,
		[FCRcvSupKeyDiff] [numeric](18, 4) NULL,
		[FTRcvRmk] [varchar](200) NULL,
		[FDLastUpdOn] [datetime] NULL,
		[FTLastUpdBy] [varchar](100) NULL,
		[FDCreateOn] [datetime] NULL,
		[FTCreateBy] [varchar](100) NULL,
	CONSTRAINT [PK_Table_DT] PRIMARY KEY CLUSTERED 
	(
		[FTBchCode] ASC,
		[FTPosCode] ASC,
		[FTShfCode] ASC,
		[FNSdtSeqNo] ASC,
		[FTRcvCode] ASC
	)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
	) ON [PRIMARY]
END
GO

IF OBJECT_ID(N'TRPTSalDailyByCashierKPCTmp') IS NULL BEGIN
	CREATE TABLE [dbo].[TRPTSalDailyByCashierKPCTmp](
		[FNRptRowSeq] [bigint] IDENTITY(1,1) NOT NULL,
		[FNRowPartID] [bigint] NULL,
		[FNRcvUseAmtSum] [bigint] NULL,
		[FNRcvUseAmtSumSub] [bigint] NULL,
		[FTUsrSession] [varchar](255) NULL,
		[FTUsrCode] [varchar](20) NULL,
		[FTUsrName] [varchar](255) NULL,
		[FTTnsType] [varchar](1) NULL,
		[FTRcvCode] [varchar](5) NULL,
		[FTRcvName] [varchar](255) NULL,
		[FTBchCode] [varchar](5) NULL,
		[FTPosCode] [varchar](5) NULL,
		[FCXshNet] [numeric](18, 4) NULL,
		[FCXshReturn] [numeric](18, 4) NULL,
		[FCXshRnd] [numeric](18, 4) NULL,
		[FCXshGrand] [numeric](18, 4) NULL,
		[FTComName] [varchar](255) NULL,
		[FTRptCode] [varchar](255) NULL,
		[FDLastUpdOn] [datetime] NULL,
		[FTLastUpdBy] [varchar](20) NULL,
		[FDCreateOn] [datetime] NULL,
		[FTCreateBy] [varchar](20) NULL,
		[FDTmpTxnDate] [datetime] NOT NULL,
		[FTRcvRefNo1] [varchar](50) NULL,
		[FTRcvRefNo2] [varchar](50) NULL,
		[FNRcvUseAmt] [numeric](18, 4) NULL,
		[FTRcvRefType] [int] NULL,
	CONSTRAINT [PK__TRPTSalD__B56E391C81A273C2] PRIMARY KEY CLUSTERED 
	(
		[FNRptRowSeq] ASC
	)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = OFF, ALLOW_PAGE_LOCKS = OFF) ON [PRIMARY]
	) ON [PRIMARY]
	
	ALTER TABLE [dbo].[TRPTSalDailyByCashierKPCTmp] ADD  CONSTRAINT [DF__TRPTSalDa__FDTmp__7CB5008C]  DEFAULT (getdate()) FOR [FDTmpTxnDate]
END
GO

IF OBJECT_ID(N'TRPTSalDailyKPCTmp') IS NULL BEGIN
	CREATE TABLE [dbo].[TRPTSalDailyKPCTmp](
		[FTRptRowSeq] [bigint] IDENTITY(1,1) NOT NULL,
		[FNRowPartID] [bigint] NULL,
		[FNAppType] [int] NULL,
		[FTXihValType] [varchar](1) NULL,
		[FTRcvCode] [varchar](5) NULL,
		[FTRcvName] [varchar](50) NULL,
		[FTRcvRefNo1] [varchar](50) NULL,
		[FTRcvRefNo2] [varchar](50) NULL,
		[FCXshGrand] [numeric](18, 4) NULL,
		[FTXihChkType] [varchar](1) NULL,
		[FTComName] [varchar](50) NULL,
		[FTRptCode] [varchar](50) NULL,
		[FTUsrSession] [varchar](255) NULL,
		[FDTmpTxnDate] [datetime] NOT NULL,
		[FNRcvUseAmt] [numeric](18, 4) NULL,
	CONSTRAINT [PK__TRPTSalD__F671FB6B9154FCDD] PRIMARY KEY CLUSTERED 
	(
		[FTRptRowSeq] ASC
	)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
	) ON [PRIMARY]
	
	ALTER TABLE [dbo].[TRPTSalDailyKPCTmp] ADD  CONSTRAINT [DF__TRPTSalDa__FDTmp__791979D2]  DEFAULT (getdate()) FOR [FDTmpTxnDate]
END
GO

--############################################################################################
-- สร้าง		  : 08-04-2022 
-- โดย			 : เจมส์
-- เวอร์ชั่น		: 00.00.12
-- สคริปโดยพี่เอ็ม

IF (OBJECT_ID(N'TCNTPdtPmtHisAgn') IS NULL) BEGIN
	CREATE TABLE [dbo].[TCNTPdtPmtHisAgn](
		[FTPmhDocNo] [varchar](20) NOT NULL,
		[FTAgnCode] [varchar](10) NOT NULL,
		[FTXshDocNo] [varchar](20) NOT NULL,
		[FDXshDocDate] [datetime] NULL,
		[FCPgtGetQty] [float] NULL,
		[FTPmhStaPrc] [varchar](1) NULL,
		[FDPmhExpired] [datetime] NULL,
	 CONSTRAINT [PK_TCNTPdtPmtHisAgn] PRIMARY KEY CLUSTERED 
	(
		[FTPmhDocNo] ASC,
		[FTAgnCode] ASC,
		[FTXshDocNo] ASC
	)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
	) ON [PRIMARY]
END
GO

IF (OBJECT_ID(N'TCNTPdtPmtHisBch') IS NULL) BEGIN
	CREATE TABLE [dbo].[TCNTPdtPmtHisBch](
		[FTPmhDocNo] [varchar](20) NOT NULL,
		[FTAgnCode] [varchar](10) NOT NULL,
		[FTBchCode] [varchar](5) NOT NULL,
		[FTXshDocNo] [varchar](20) NOT NULL,
		[FDXshDocDate] [datetime] NULL,
		[FCPgtGetQty] [float] NULL,
		[FTPmhStaPrc] [varchar](1) NULL,
		[FDPmhExpired] [datetime] NULL,
	 CONSTRAINT [PK_TCNTPdtPmtHisBch] PRIMARY KEY CLUSTERED 
	(
		[FTPmhDocNo] ASC,
		[FTAgnCode] ASC,
		[FTBchCode] ASC,
		[FTXshDocNo] ASC
	)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
	) ON [PRIMARY]
END
GO

IF (OBJECT_ID(N'TCNTPdtPmtHisCst') IS NULL) BEGIN
	CREATE TABLE [dbo].[TCNTPdtPmtHisCst](
		[FTPmhDocNo] [varchar](20) NOT NULL,
		[FTAgnCode] [varchar](10) NOT NULL,
		[FTCstCode] [varchar](20) NOT NULL,
		[FTXshDocNo] [varchar](20) NOT NULL,
		[FDXshDocDate] [datetime] NULL,
		[FCPgtGetQty] [float] NULL,
		[FTPmhStaPrc] [varchar](1) NULL,
		[FDPmhExpired] [datetime] NULL,
	 CONSTRAINT [PK_TCNTPdtPmtHisCst] PRIMARY KEY CLUSTERED 
	(
		[FTPmhDocNo] ASC,
		[FTAgnCode] ASC,
		[FTCstCode] ASC,
		[FTXshDocNo] ASC
	)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
	) ON [PRIMARY]
END
GO

--############################################################################################
-- สร้าง		  : 27-04-2022 
-- โดย			 : เจมส์
-- เวอร์ชั่น		: 00.00.13
-- สคริปโดยพี่เอ็ม

IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TFNMRcv' AND COLUMN_NAME = 'FTRcvStaShwSum') BEGIN
	ALTER TABLE TFNMRcv ADD FTRcvStaShwSum VARCHAR(1)
END
GO

--############################################################################################
-- สร้าง		  : 04-05-2022 
-- โดย			 : เจมส์
-- เวอร์ชั่น		: 00.00.14

IF NOT EXISTS(SELECT object_id FROM sys.indexes WHERE name = 'IX_TRPTPdtStkBalTmp_1' AND object_id = OBJECT_ID('TRPTPdtStkBalTmp')) BEGIN
	CREATE NONCLUSTERED INDEX IX_TRPTPdtStkBalTmp_1
	ON [dbo].[TRPTPdtStkBalTmp] ([FTPdtCode],[FTComName],[FTRptCode],[FTUsrSession])
END
GO

IF NOT EXISTS(SELECT object_id FROM sys.indexes WHERE name = 'IX_TRPTPdtStkBalTmp_2' AND object_id = OBJECT_ID('TRPTPdtStkBalTmp')) BEGIN
	CREATE NONCLUSTERED INDEX IX_TRPTPdtStkBalTmp_2
	ON [dbo].[TRPTPdtStkBalTmp] ([FTWahCode],[FTComName],[FTRptCode],[FTUsrSession])
	INCLUDE ([FCStkQty])
END
GO

IF NOT EXISTS(SELECT object_id FROM sys.indexes WHERE name = 'IX_TRPTPdtBalByPdtGrpTmp_1' AND object_id = OBJECT_ID('TRPTPdtBalByPdtGrpTmp')) BEGIN
	CREATE NONCLUSTERED INDEX IX_TRPTPdtBalByPdtGrpTmp_1
	ON [dbo].[TRPTPdtBalByPdtGrpTmp] ([FTUsrSession],[FTComName],[FTRptCode],[FTPdtCode])
END
GO

IF NOT EXISTS(SELECT object_id FROM sys.indexes WHERE name = 'IX_TRPTPdtBalByPdtGrpTmp_2' AND object_id = OBJECT_ID('TRPTPdtBalByPdtGrpTmp')) BEGIN
	CREATE NONCLUSTERED INDEX IX_TRPTPdtBalByPdtGrpTmp_2
	ON [dbo].[TRPTPdtBalByPdtGrpTmp] ([FTUsrSession],[FTComName],[FTRptCode])
	INCLUDE ([FTWahCode],[FCStkQty])
END
GO

IF NOT EXISTS(SELECT object_id FROM sys.indexes WHERE name = 'IX_TRPTPdtBalByPdtGrpTmp_3' AND object_id = OBJECT_ID('TRPTPdtBalByPdtGrpTmp')) BEGIN
	CREATE NONCLUSTERED INDEX IX_TRPTPdtBalByPdtGrpTmp_3
	ON [dbo].[TRPTPdtBalByPdtGrpTmp] ([FTUsrSession],[FTComName],[FTRptCode])
	INCLUDE ([FNRowPartID],[FTBchCode],[FTBchName],[FTWahCode],[FTWahName],[FTPgpChain],[FTPgpChainName],[FTPdtCode],[FTPdtName],[FCStkQty],[FCPdtCostEX],[FCPdtCostAmt])
END
GO

IF NOT EXISTS(SELECT object_id FROM sys.indexes WHERE name = 'IX_TRPTPdtBalByBchTmp_1' AND object_id = OBJECT_ID('TRPTPdtBalByBchTmp')) BEGIN
	CREATE NONCLUSTERED INDEX IX_TRPTPdtBalByBchTmp_1
	ON [dbo].[TRPTPdtBalByBchTmp] ([FTUsrSession],[FTComName],[FTRptCode])
	INCLUDE ([FNRowPartID],[FTBchCode],[FTBchName],[FTPdtCode],[FTPdtName],[FCStkQty],[FCStkSetPrice],[FCStkAmount])
END
GO

--Update By : Chaiya 04/05/2022 14:00
--Create table special category for pos
IF OBJECT_ID(N'TCNMPosSpcCat') IS NULL BEGIN
	CREATE TABLE TCNMPosSpcCat
	(
		FTBchCode	VARCHAR(5) NOT NULL,
		FTShpCode	VARCHAR(5) NOT NULL,
		FTPosCode	VARCHAR(5) NOT NULL,
		FNCatSeq	SMALLINT  NOT NULL,
		FTPdtCat1	VARCHAR(10),
		FTPdtCat2	VARCHAR(10),
		FTPdtCat3	VARCHAR(10),
		FTPdtCat4	VARCHAR(10),
		FTPdtCat5	VARCHAR(10),
		FTPgpChain	VARCHAR(30),
		FTPtyCode	VARCHAR(5),
		FTPbnCode	VARCHAR(5),
		FTPmoCode	VARCHAR(5),
		FTTcgCode	VARCHAR(5),
		FDLastUpdOn	DATETIME,
		FTLastUpdBy	VARCHAR(20),
		FDCreateOn	DATETIME,
		FTCreateBy	VARCHAR(20)
		 CONSTRAINT [PK_TCNMPosSpcCat] PRIMARY KEY CLUSTERED 
		(
			FTBchCode ASC,
			FTShpCode ASC,
			FTPosCode ASC,
			FNCatSeq  ASC
		)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [AdaPos5_SKU_Filegroups]
	) ON [AdaPos5_SKU_Filegroups]
END
GO

--############################################################################################
-- สร้าง		  : 18-05-2022 
-- โดย			 : เจมส์
-- เวอร์ชั่น		: 00.00.15

--Create table gen docno TR for interface
IF OBJECT_ID(N'TLKTTRDocNo') IS NULL BEGIN
	CREATE TABLE TLKTTRDocNo
	(
		FTBchCode	VARCHAR(5) NOT NULL,
		FTXthDocNo	VARCHAR(20),
		FDLastUpdOn	DATETIME,
		FTLastUpdBy	VARCHAR(20),
		FDCreateOn	DATETIME,
		FTCreateBy	VARCHAR(20)
		 CONSTRAINT [PK_TLKTTRDocNo] PRIMARY KEY CLUSTERED 
		(
			FTBchCode ASC
		)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
	) ON [PRIMARY]	 
END
GO

--Create table gen docno GI for interface
IF OBJECT_ID(N'TLKTGIDocNo') IS NULL BEGIN
	CREATE TABLE TLKTGIDocNo
	(
		FTBchCode	VARCHAR(5) NOT NULL,
		FTXthDocNo	VARCHAR(20),
		FDLastUpdOn	DATETIME,
		FTLastUpdBy	VARCHAR(20),
		FDCreateOn	DATETIME,
		FTCreateBy	VARCHAR(20)
		 CONSTRAINT [PK_TLKTGIDocNo] PRIMARY KEY CLUSTERED 
		(
			FTBchCode ASC
		)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
	) ON [PRIMARY]	 
END
GO

--Create table gen docno GR for interface
IF OBJECT_ID(N'TLKTGRDocNo') IS NULL BEGIN
	CREATE TABLE TLKTGRDocNo
	(
		FTBchCode	VARCHAR(5) NOT NULL,
		FTXthDocNo	VARCHAR(20),
		FDLastUpdOn	DATETIME,
		FTLastUpdBy	VARCHAR(20),
		FDCreateOn	DATETIME,
		FTCreateBy	VARCHAR(20)
		 CONSTRAINT [PK_TLKTGRDocNo] PRIMARY KEY CLUSTERED 
		(
			FTBchCode ASC
		)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
	) ON [PRIMARY]	 
END
GO

--############################################################################################
-- สร้าง		  : 23-05-2022 
-- โดย			 : เจมส์
-- เวอร์ชั่น		: 00.00.16

IF OBJECT_ID(N'TPSSGrpSlipHD') IS NULL BEGIN
	CREATE TABLE [dbo].[TPSSGrpSlipHD](
		[FTGshCode] [varchar](5) NOT NULL,
		[FTGshName] [varchar](100) NULL,
		[FTGshStaUse] [varchar](1) NULL,
		[FDLastUpdOn] [datetime] NULL,
		[FTLastUpdBy] [varchar](20) NULL,
		[FDCreateOn] [datetime] NULL,
		[FTCreateBy] [varchar](20) NULL,
	 CONSTRAINT [PK_TPSSGrpSlipHD] PRIMARY KEY CLUSTERED 
	(
		[FTGshCode] ASC
	)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [AdaPos5_SYS_Filegroups]
	) ON [AdaPos5_SYS_Filegroups]

	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'รหัสกลุ่มรายการ' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TPSSGrpSlipHD', @level2type=N'COLUMN',@level2name=N'FTGshCode'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'ชื่อกลุ่มรายการ' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TPSSGrpSlipHD', @level2type=N'COLUMN',@level2name=N'FTGshName'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'สถานะใช้งาน 1:ใช้งาน, 2:ไม่ใช้งาน' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TPSSGrpSlipHD', @level2type=N'COLUMN',@level2name=N'FTGshStaUse'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'วันที่ปรับปรุงรายการล่าสุด' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TPSSGrpSlipHD', @level2type=N'COLUMN',@level2name=N'FDLastUpdOn'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'ผู้ปรับปรุงรายการล่าสุด' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TPSSGrpSlipHD', @level2type=N'COLUMN',@level2name=N'FTLastUpdBy'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'วันที่สร้างรายการ' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TPSSGrpSlipHD', @level2type=N'COLUMN',@level2name=N'FDCreateOn'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'ผู้สร้างรายการ' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TPSSGrpSlipHD', @level2type=N'COLUMN',@level2name=N'FTCreateBy'
END
GO
IF OBJECT_ID(N'TPSSGrpSlipDT') IS NULL BEGIN
	CREATE TABLE [dbo].[TPSSGrpSlipDT](
		[FTGshCode] [varchar](5) NOT NULL,
		[FTGsdSubCode] [varchar](20) NOT NULL,
		[FNGsdSeqNo] [bigint] NOT NULL,
		[FTGsdName] [varchar](100) NULL,
		[FTGsdStaUse] [varchar](1) NULL,
		[FDLastUpdOn] [datetime] NULL,
		[FTLastUpdBy] [varchar](20) NULL,
		[FDCreateOn] [datetime] NULL,
		[FTCreateBy] [varchar](20) NULL,
	 CONSTRAINT [PK_TPSSGrpSlipDT] PRIMARY KEY CLUSTERED 
	(
		[FTGshCode] ASC,
		[FTGsdSubCode] ASC,
		[FNGsdSeqNo] ASC
	)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [AdaPos5_SYS_Filegroups]
	) ON [AdaPos5_SYS_Filegroups]

	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'รหัสกลุ่มรายการ' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TPSSGrpSlipDT', @level2type=N'COLUMN',@level2name=N'FTGshCode'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'รหัสกลุ่มย่อยรายการ' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TPSSGrpSlipDT', @level2type=N'COLUMN',@level2name=N'FTGsdSubCode'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'ลำดับรายการ' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TPSSGrpSlipDT', @level2type=N'COLUMN',@level2name=N'FNGsdSeqNo'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'ชื่อกลุ่มย่อยรายการ' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TPSSGrpSlipDT', @level2type=N'COLUMN',@level2name=N'FTGsdName'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'สถานะใช้งาน 1:ใช้งาน, 2:ไม่ใช้งาน' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TPSSGrpSlipDT', @level2type=N'COLUMN',@level2name=N'FTGsdStaUse'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'วันที่ปรับปรุงรายการล่าสุด' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TPSSGrpSlipDT', @level2type=N'COLUMN',@level2name=N'FDLastUpdOn'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'ผู้ปรับปรุงรายการล่าสุด' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TPSSGrpSlipDT', @level2type=N'COLUMN',@level2name=N'FTLastUpdBy'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'วันที่สร้างรายการ' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TPSSGrpSlipDT', @level2type=N'COLUMN',@level2name=N'FDCreateOn'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'ผู้สร้างรายการ' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TPSSGrpSlipDT', @level2type=N'COLUMN',@level2name=N'FTCreateBy'
END
GO
IF OBJECT_ID(N'TPSMUsrSlipHD') IS NULL BEGIN
	CREATE TABLE [dbo].[TPSMUsrSlipHD](
		[FTAgnCode] [varchar](10) NOT NULL,
		[FNUshSeq] [bigint] NOT NULL,
		[FTGshCode] [varchar](5) NULL,
		[FTUshStaShw] [varchar](1) NULL,
		[FDLastUpdOn] [datetime] NULL,
		[FTLastUpdBy] [varchar](20) NULL,
		[FDCreateOn] [datetime] NULL,
		[FTCreateBy] [varchar](20) NULL,
	 CONSTRAINT [PK_TPSMUsrSlipHD] PRIMARY KEY CLUSTERED 
	(
		[FTAgnCode] ASC,
		[FNUshSeq] ASC
	)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [AdaPos5_MAS_Filegroups]
	) ON [AdaPos5_MAS_Filegroups]

	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'รหัสคู้ค้า' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TPSMUsrSlipHD', @level2type=N'COLUMN',@level2name=N'FTAgnCode'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'ลำดับรายการ' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TPSMUsrSlipHD', @level2type=N'COLUMN',@level2name=N'FNUshSeq'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'รหัสรายการ' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TPSMUsrSlipHD', @level2type=N'COLUMN',@level2name=N'FTGshCode'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'สถานะแสดง 1:แสดง, 2:ไม่แสดง' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TPSMUsrSlipHD', @level2type=N'COLUMN',@level2name=N'FTUshStaShw'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'วันที่ปรับปรุงรายการล่าสุด' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TPSMUsrSlipHD', @level2type=N'COLUMN',@level2name=N'FDLastUpdOn'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'ผู้ปรับปรุงรายการล่าสุด' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TPSMUsrSlipHD', @level2type=N'COLUMN',@level2name=N'FTLastUpdBy'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'วันที่สร้างรายการ' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TPSMUsrSlipHD', @level2type=N'COLUMN',@level2name=N'FDCreateOn'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'ผู้สร้างรายการ' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TPSMUsrSlipHD', @level2type=N'COLUMN',@level2name=N'FTCreateBy'
END
GO
IF OBJECT_ID(N'TPSMUsrSlipDT') IS NULL BEGIN
	CREATE TABLE [dbo].[TPSMUsrSlipDT](
		[FTAgnCode] [varchar](10) NOT NULL,
		[FNUshSeq] [bigint] NOT NULL,
		[FTUsdSubCode] [varchar](20) NOT NULL,
		[FTUsdStaShw] [varchar](1) NULL,
		[FNUsdLine] [bigint] NULL,
		[FDLastUpdOn] [datetime] NULL,
		[FTLastUpdBy] [varchar](20) NULL,
		[FDCreateOn] [datetime] NULL,
		[FTCreateBy] [varchar](20) NULL,
	 CONSTRAINT [PK_TPSMUsrSlipDT] PRIMARY KEY CLUSTERED 
	(
		[FTAgnCode] ASC,
		[FNUshSeq] ASC,
		[FTUsdSubCode] ASC
	)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [AdaPos5_MAS_Filegroups]
	) ON [AdaPos5_MAS_Filegroups]

	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'รหัสคู้ค้า' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TPSMUsrSlipDT', @level2type=N'COLUMN',@level2name=N'FTAgnCode'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'ลำดับรายการ' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TPSMUsrSlipDT', @level2type=N'COLUMN',@level2name=N'FNUshSeq'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'รหัสกลุ่มย่อยรายการ' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TPSMUsrSlipDT', @level2type=N'COLUMN',@level2name=N'FTUsdSubCode'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'สถานะแสดง 1:แสดง, 2:ไม่แสดง' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TPSMUsrSlipDT', @level2type=N'COLUMN',@level2name=N'FTUsdStaShw'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'แสดงในบรรทัดที่' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TPSMUsrSlipDT', @level2type=N'COLUMN',@level2name=N'FNUsdLine'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'วันที่ปรับปรุงรายการล่าสุด' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TPSMUsrSlipDT', @level2type=N'COLUMN',@level2name=N'FDLastUpdOn'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'ผู้ปรับปรุงรายการล่าสุด' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TPSMUsrSlipDT', @level2type=N'COLUMN',@level2name=N'FTLastUpdBy'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'วันที่สร้างรายการ' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TPSMUsrSlipDT', @level2type=N'COLUMN',@level2name=N'FDCreateOn'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'ผู้สร้างรายการ' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TPSMUsrSlipDT', @level2type=N'COLUMN',@level2name=N'FTCreateBy'
END
GO

--############################################################################################
-- สร้าง		  : 08-06-2022 
-- โดย			 : เจมส์
-- เวอร์ชั่น		: 00.00.17

IF NOT EXISTS(SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TPSMUsrSlipDT' AND COLUMN_NAME = 'FNUsdSeqNo') BEGIN
	ALTER TABLE TPSMUsrSlipDT ADD FNUsdSeqNo BIGINT
END
GO

IF NOT EXISTS(SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TPSSGrpSlipDT' AND COLUMN_NAME = 'FNGsdLine') BEGIN
	ALTER TABLE TPSSGrpSlipDT ADD FNGsdLine BIGINT
END
GO

--############################################################################################
-- สร้าง		  : 10-06-2022 
-- โดย			 : เจมส์
-- เวอร์ชั่น		: 00.00.18

IF OBJECT_ID(N'TCNMChannelSpcWah') IS NULL 
BEGIN
	CREATE TABLE TCNMChannelSpcWah
	( 
		FTAgnCode VARCHAR(10) ,
		FTBchCode VARCHAR(5)  ,
		FTWahCode VARCHAR(5) ,
		FTChnCode VARCHAR(5) ,
		FTChnStaDoc VARCHAR(1) -- 1=ขาย  2=Do
	CONSTRAINT [PK_TCNMWaHouseChn] PRIMARY KEY CLUSTERED 
	(
		FTChnCode ASC,
		FTBchCode ASC,
		FTWahCode ASC 
	)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
	)ON [PRIMARY];
END
GO

/* สคริปของพี่อาร์ม */

IF EXISTS(SELECT name FROM sys.indexes WHERE name = 'IND_TCNTPdtPrice4PDT_FTPghDocNo') BEGIN
	DROP INDEX IND_TCNTPdtPrice4PDT_FTPghDocNo ON TCNTPdtPrice4PDT
END
GO

ALTER TABLE TCNTPdtPrice4PDT ALTER COLUMN FTPghDocNo VARCHAR(20) NOT NULL
GO
	
IF EXISTS(SELECT name FROM sys.indexes WHERE name = 'IND_TCNTPdtPrice4PDT_FTPghDocType') BEGIN
	DROP INDEX IND_TCNTPdtPrice4PDT_FTPghDocType ON TCNTPdtPrice4PDT
END
GO

ALTER TABLE TCNTPdtPrice4PDT ALTER COLUMN FTPghDocType VARCHAR(1) NOT NULL
GO

IF EXISTS(SELECT name FROM sys.key_constraints WHERE name = 'PK_TCNTPdtPrice4PDT') BEGIN
	ALTER TABLE TCNTPdtPrice4PDT DROP CONSTRAINT PK_TCNTPdtPrice4PDT
END
GO

ALTER TABLE TCNTPdtPrice4PDT
ADD CONSTRAINT PK_TCNTPdtPrice4PDT PRIMARY KEY (FTPdtCode,FTPunCode,FDPghDStart,FTPghTStart,FTPplCode,FTPghDocType,FTPghDocNo);
GO

IF NOT EXISTS(SELECT name FROM sys.indexes WHERE name = 'IND_TCNTPdtPrice4PDT_FTPghDocNo') BEGIN
	CREATE NONCLUSTERED INDEX IND_TCNTPdtPrice4PDT_FTPghDocNo ON TCNTPdtPrice4PDT (FTPghDocNo)  
END
GO

IF NOT EXISTS(SELECT name FROM sys.indexes WHERE name = 'IND_TCNTPdtPrice4PDT_FTPghDocType') BEGIN
	CREATE NONCLUSTERED INDEX IND_TCNTPdtPrice4PDT_FTPghDocType ON TCNTPdtPrice4PDT (FTPghDocType)
END
GO

--############################################################################################
-- สร้าง		  : 23-06-2022 
-- โดย			 : เจมส์
-- เวอร์ชั่น		: 00.00.19

IF OBJECT_ID(N'TLGTFileHis') IS NULL BEGIN
	CREATE TABLE [dbo].[TLGTFileHis](
		[FNLogID] [bigint] IDENTITY(1,1) NOT NULL,
		[FTAgnCode] [varchar](10) NULL,
		[FTBchCode] [varchar](5) NULL,
		[FTPosCode] [varchar](5) NOT NULL,
		[FTLogType] [varchar](1) NULL,
		[FDLogDateReq] [datetime] NULL,
		[FDLogFileDate] [datetime] NULL,
		[FTLogUrlFile] [varchar](255) NULL,
		[FTLogStatus] [varchar](1) NULL,
		[FTLogRmk] [varchar](200) NULL,
		[FDLastUpdOn] [datetime] NULL,
		[FTLastUpdBy] [varchar](20) NULL,
		[FDCreateOn] [datetime] NULL,
		[FTCreateBy] [varchar](20) NULL,
	 CONSTRAINT [PK_TLGTFileHis] PRIMARY KEY CLUSTERED 
	(
		[FNLogID] ASC
	)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
	) ON [PRIMARY]

	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'ลำดับรายการ' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TLGTFileHis', @level2type=N'COLUMN',@level2name=N'FNLogID'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'รหัสคู้ค้า' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TLGTFileHis', @level2type=N'COLUMN',@level2name=N'FTAgnCode'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'สาขา' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TLGTFileHis', @level2type=N'COLUMN',@level2name=N'FTBchCode'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'รหัสเครื่อง POS' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TLGTFileHis', @level2type=N'COLUMN',@level2name=N'FTPosCode'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'ประเภท 1:Log File 2:Database' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TLGTFileHis', @level2type=N'COLUMN',@level2name=N'FTLogType'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'วันที่ขอ' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TLGTFileHis', @level2type=N'COLUMN',@level2name=N'FDLogDateReq'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'วันที่ไฟล์' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TLGTFileHis', @level2type=N'COLUMN',@level2name=N'FDLogFileDate'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'ที่อยู่ของไฟล์' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TLGTFileHis', @level2type=N'COLUMN',@level2name=N'FTLogUrlFile'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'สถานะ Log 1:สำเร็จ 2:ไม่สำเร็จ' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TLGTFileHis', @level2type=N'COLUMN',@level2name=N'FTLogStatus'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'หมายเหตุ' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TLGTFileHis', @level2type=N'COLUMN',@level2name=N'FTLogRmk'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'วันที่ปรับปรุงรายการล่าสุด' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TLGTFileHis', @level2type=N'COLUMN',@level2name=N'FDLastUpdOn'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'ผู้ปรับปรุงรายการล่าสุด' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TLGTFileHis', @level2type=N'COLUMN',@level2name=N'FTLastUpdBy'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'วันที่สร้างรายการ' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TLGTFileHis', @level2type=N'COLUMN',@level2name=N'FDCreateOn'
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'ผู้สร้างรายการ' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TLGTFileHis', @level2type=N'COLUMN',@level2name=N'FTCreateBy'
END
GO

--############################################################################################
-- สร้าง		  : 15-08-2022 
-- โดย			 : เจมส์
-- เวอร์ชั่น		: 00.01.00

IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TCNSLabelFmt' AND COLUMN_NAME = 'FNLblQtyPerPageNml') BEGIN
	ALTER TABLE TCNSLabelFmt ADD FNLblQtyPerPageNml bigint
END
GO
IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TCNSLabelFmt' AND COLUMN_NAME = 'FNLblQtyPerPagePmt') BEGIN
	ALTER TABLE TCNSLabelFmt ADD FNLblQtyPerPagePmt bigint
END
GO
IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TCNSLabelFmt' AND COLUMN_NAME = 'FTLblVerGroup') BEGIN
	ALTER TABLE TCNSLabelFmt ADD FTLblVerGroup varchar(20)
END
GO
IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TCNSLabelFmt' AND COLUMN_NAME = 'FTLblSizeWH') BEGIN
	ALTER TABLE TCNSLabelFmt ADD FTLblSizeWH varchar(30)
END
GO
IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TCNMPrnLabel' AND COLUMN_NAME = 'FTPlbPrnDriver') BEGIN
	ALTER TABLE TCNMPrnLabel ADD FTPlbPrnDriver varchar(100)
END
GO
IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TCNMPrnLabel' AND COLUMN_NAME = 'FTPlbPrnTray') BEGIN
	ALTER TABLE TCNMPrnLabel ADD FTPlbPrnTray varchar(100)
END
GO
IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TCNMPrnLabel' AND COLUMN_NAME = 'FTPlbPrnPmtDriver') BEGIN
	ALTER TABLE TCNMPrnLabel ADD FTPlbPrnPmtDriver varchar(100)
END
GO
IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TCNMPrnLabel' AND COLUMN_NAME = 'FTPlbPrnPmtTray') BEGIN
	ALTER TABLE TCNMPrnLabel ADD FTPlbPrnPmtTray varchar(100)
END
GO
IF OBJECT_ID(N'TCNTPrnLabelTmp') IS NOT NULL BEGIN
	DROP TABLE TCNTPrnLabelTmp
END
GO
IF OBJECT_ID(N'TCNTPrnLabelTmp') IS NULL BEGIN
	CREATE TABLE [dbo].[TCNTPrnLabelTmp](
		[FTComName] [varchar](50) NULL,
		[FTPdtCode] [varchar](20) NULL,
		[FTPdtName] [varchar](100) NULL,
		[FTBarCode] [varchar](25) NULL,
		[FTPlcCode] [varchar](10) NULL,
		[FDPrnDate] [datetime] NULL,
		[FTPdtContentUnit] [varchar](100) NULL,
		[FTPlbCode] [varchar](255) NULL,
		[FNPlbQty] [bigint] NULL,
		[FTPdtTime] [varchar](20) NULL,
		[FTPdtMfg] [varchar](20) NULL,
		[FTPdtImporter] [varchar](100) NULL,
		[FTPdtRefNo] [varchar](30) NULL,
		[FTPdtValue] [varchar](100) NULL,
		[FTPbnDesc] [varchar](100) NULL,
		[FTPdtNameOth] [varchar](100) NULL,
		[FTPlbSubDept] [varchar](100) NULL,
		[FTPlbRepleType] [varchar](2) NULL,
		[FTPlbPriStatus] [varchar](50) NULL,
		[FTPlbSellingUnit] [varchar](100) NULL,
		[FCPdtPrice] [float] NULL,
		[FCPdtOldPrice] [float] NULL,
		[FTPlbPhasing] [varchar](5) NULL,
		[FTPlbPriPerUnit] [varchar](100) NULL,
		[FTPlbCapFree] [varchar](25) NULL,
		[FTPlbPdtChain] [varchar](30) NULL,
		[FTPlbCapNamePmt] [varchar](200) NULL,
		[FTPlbPmtInterval] [varchar](50) NULL,
		[FCPlbPmtGetCond] [float] NULL,
		[FCPlbPmtGetValue] [float] NULL,
		[FDPlbPmtDStart] [datetime] NULL,
		[FDPlbPmtDStop] [datetime] NULL,
		[FTPlbPmtCode] [varchar](20) NULL,
		[FCPlbPmtBuyQty] [float] NULL,
		[FTPlbClrName] [varchar](100) NULL,
		[FTPlbPszName] [varchar](100) NULL,
		[FTPlbPriType] [varchar](1) NULL,
		[FTPlbStaImport] [varchar](1) NULL,
		[FTPlbImpDesc] [varchar](255) NULL,
		[FTPlbUrl] [varchar](255) NULL,
		[FTPlbStaSelect] [varchar](1) NULL
	) ON [AdaPos5_SKU_Filegroups]
END
GO

--############################################################################################
-- สร้าง		  : 23-08-2022 
-- โดย			 : เจมส์
-- เวอร์ชั่น		: 01.01.00

IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TCNMPrnLabel' AND COLUMN_NAME = 'FTAgnCode') BEGIN
	/* TCNMPrnLabel */
	SELECT FTPlbCode,FTLblCode,FTSppCode,FTPlbStaUse,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy,FTPlbPrnDriver,FTPlbPrnTray,FTPlbPrnPmtDriver,FTPlbPrnPmtTray,'' AS FTAgnCode INTO TCNMPrnLabel_Tmp FROM TCNMPrnLabel

	DROP TABLE TCNMPrnLabel

	CREATE TABLE [dbo].[TCNMPrnLabel](
		[FTAgnCode] [varchar](10) NOT NULL,
		[FTPlbCode] [varchar](10) NOT NULL,
		[FTLblCode] [varchar](10) NULL,
		[FTSppCode] [varchar](50) NULL,
		[FTPlbStaUse] [varchar](1) NULL,
		[FDLastUpdOn] [datetime] NULL,
		[FTLastUpdBy] [varchar](20) NULL,
		[FDCreateOn] [datetime] NULL,
		[FTCreateBy] [varchar](20) NULL,
		[FTPlbPrnDriver] [varchar](100) NULL,
		[FTPlbPrnTray] [varchar](100) NULL,
		[FTPlbPrnPmtDriver] [varchar](100) NULL,
		[FTPlbPrnPmtTray] [varchar](100) NULL,
	CONSTRAINT [PK_TCNMPrnLabel] PRIMARY KEY CLUSTERED 
	(
		[FTAgnCode] ASC,
		[FTPlbCode] ASC
	)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
	) ON [PRIMARY]

	INSERT INTO TCNMPrnLabel (FTAgnCode,FTPlbCode,FTLblCode,FTSppCode,FTPlbStaUse,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy,FTPlbPrnDriver,FTPlbPrnTray,FTPlbPrnPmtDriver,FTPlbPrnPmtTray)
	SELECT FTAgnCode,FTPlbCode,FTLblCode,FTSppCode,FTPlbStaUse,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy,FTPlbPrnDriver,FTPlbPrnTray,FTPlbPrnPmtDriver,FTPlbPrnPmtTray FROM TCNMPrnLabel_Tmp
	
	DROP TABLE TCNMPrnLabel_Tmp
	/* TCNMPrnLabel */
END
GO

IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TCNMPrnLabel_L' AND COLUMN_NAME = 'FTAgnCode') BEGIN
	/* TCNMPrnLabel_L */
	SELECT FTPlbCode,FNLngID,FTPblName,FTPblRmk,'' AS FTAgnCode INTO TCNMPrnLabel_L_Tmp FROM TCNMPrnLabel_L

	DROP TABLE TCNMPrnLabel_L

	CREATE TABLE [dbo].[TCNMPrnLabel_L](
		[FTAgnCode] [varchar](10) NOT NULL,
		[FTPlbCode] [varchar](10) NOT NULL,
		[FNLngID] [bigint] NOT NULL,
		[FTPblName] [varchar](200) NULL,
		[FTPblRmk] [varchar](200) NULL,
	CONSTRAINT [PK_TCNMPrnLabel_L] PRIMARY KEY CLUSTERED 
	(
		[FTAgnCode] ASC,
		[FTPlbCode] ASC,
		[FNLngID] ASC
	)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
	) ON [PRIMARY]

	INSERT INTO TCNMPrnLabel_L (FTAgnCode,FTPlbCode,FNLngID,FTPblName,FTPblRmk)
	SELECT FTAgnCode,FTPlbCode,FNLngID,FTPblName,FTPblRmk FROM TCNMPrnLabel_L_Tmp

	DROP TABLE TCNMPrnLabel_L_Tmp
	/* TCNMPrnLabel_L */
END
GO

IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TCNMPrnServer' AND COLUMN_NAME = 'FTAgnCode') BEGIN
	/* TCNMPrnServer */
	SELECT FTSrvCode,FTSrvStaUse,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy,'' AS FTAgnCode INTO TCNMPrnServer_Tmp FROM TCNMPrnServer

	DROP TABLE TCNMPrnServer

	CREATE TABLE [dbo].[TCNMPrnServer](
		[FTAgnCode] [varchar](10) NOT NULL,
		[FTSrvCode] [varchar](10) NOT NULL,
		[FTSrvStaUse] [varchar](1) NULL,
		[FDLastUpdOn] [datetime] NULL,
		[FTLastUpdBy] [varchar](20) NULL,
		[FDCreateOn] [datetime] NULL,
		[FTCreateBy] [varchar](20) NULL,
	CONSTRAINT [PK_TCNMPrnServer] PRIMARY KEY CLUSTERED 
	(
		[FTAgnCode] ASC,
		[FTSrvCode] ASC
	)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
	) ON [PRIMARY]

	INSERT INTO TCNMPrnServer (FTAgnCode,FTSrvCode,FTSrvStaUse,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
	SELECT FTAgnCode,FTSrvCode,FTSrvStaUse,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy FROM TCNMPrnServer_Tmp

	DROP TABLE TCNMPrnServer_Tmp
	/* TCNMPrnServer */
END
GO

IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'TCNMPrnServer_L' AND COLUMN_NAME = 'FTAgnCode') BEGIN
	/* TCNMPrnServer_L */
	SELECT FTSrvCode,FNLngID,FTSrvName,FTSrvRmk,'' AS FTAgnCode INTO TCNMPrnServer_L_Tmp FROM TCNMPrnServer_L

	DROP TABLE TCNMPrnServer_L

	CREATE TABLE [dbo].[TCNMPrnServer_L](
		[FTAgnCode] [varchar](10) NOT NULL,
		[FTSrvCode] [varchar](10) NOT NULL,
		[FNLngID] [bigint] NOT NULL,
		[FTSrvName] [varchar](200) NULL,
		[FTSrvRmk] [varchar](200) NULL,
	CONSTRAINT [PK_TCNMPrnServer_L] PRIMARY KEY CLUSTERED 
	(
		[FTAgnCode] ASC,
		[FTSrvCode] ASC,
		[FNLngID] ASC
	)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
	) ON [PRIMARY]

	INSERT INTO TCNMPrnServer_L (FTAgnCode,FTSrvCode,FNLngID,FTSrvName,FTSrvRmk)
	SELECT FTAgnCode,FTSrvCode,FNLngID,FTSrvName,FTSrvRmk FROM TCNMPrnServer_L_Tmp
	
	DROP TABLE TCNMPrnServer_L_Tmp
	/* TCNMPrnServer_L */
END
GO

--############################################################################################
-- สร้าง		  : 02-09-2022 
-- โดย			 : เจมส์
-- เวอร์ชั่น		: 01.02.00

IF OBJECT_ID(N'TCNTPrnLabelHDTmp') IS NULL BEGIN
	CREATE TABLE [dbo].[TCNTPrnLabelHDTmp](
		[FTComName] [varchar](50) NULL,
		[FTPlbPriType] [varchar](1) NULL,
		[FNPage] [int] NOT NULL,
		[FNSeq] [int] NOT NULL,
		[FTBarCode] [varchar](25) NULL,
		[FTPdtName] [varchar](100) NULL,
		[FTPdtContentUnit] [varchar](100) NULL,
		[FNPlbQty] [bigint] NULL,
		[FTPlbStaSelect] [varchar](1) NULL
	) ON [PRIMARY]
END
GO

--############################################################################################
-- สร้าง		  : 08-09-2022 
-- โดย			 : เจมส์
-- เวอร์ชั่น		: 02.01.00

IF NOT EXISTS(SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME   = 'TCNTDocDTTmp' AND COLUMN_NAME  = 'FTXtdDisChgTxt' AND CHARACTER_MAXIMUM_LENGTH = '255') BEGIN
	ALTER TABLE TCNTDocDTTmp ALTER COLUMN FTXtdDisChgTxt VARCHAR(255)
END

--############################################################################################