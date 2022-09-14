
--############################################################################################
-- สร้าง		  : 07-09-2021 
-- โดย			 : เจมส์
-- เวอร์ชั่น		: 00.00.01
-- เพิ่มเช็คข้อมูลก่อนหาร SUM(FCXsdNetAfHD)/SUM(FCXsdQty)

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[SP_RPTxDailySaleByPdt1001002]') AND type in (N'P', N'PC'))
	DROP PROCEDURE SP_RPTxDailySaleByPdt1001002
GO

SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[SP_RPTxDailySaleByPdt1001002] 
	@pnLngID int , 
	@pnComName Varchar(100),
	@ptRptCode Varchar(100),
	@ptUsrSession Varchar(255),
	@pnFilterType int, --1 BETWEEN 2 IN

	--สาขา
	@ptBchL Varchar(8000), --กรณี Condition IN
	@ptBchF Varchar(5),
	@ptBchT Varchar(5),
	--Merchant
	@ptMerL Varchar(8000), --กรณี Condition IN
	@ptMerF Varchar(10),
	@ptMerT Varchar(10),
	--Shop Code
	@ptShpL Varchar(8000), --กรณี Condition IN
	@ptShpF Varchar(10),
	@ptShpT Varchar(10),
	--เครื่องจุดขาย
	@ptPosL Varchar(8000), --กรณี Condition IN
	@ptPosF Varchar(20),
	@ptPosT Varchar(20),

	@ptPdtCodeF Varchar(20),
	@ptPdtCodeT Varchar(20),
	@ptPdtChanF Varchar(30),
	@ptPdtChanT Varchar(30),
	@ptPdtTypeF Varchar(5),
	@ptPdtTypeT Varchar(5),

	@ptDocDateF Varchar(10),
	@ptDocDateT Varchar(10),
	----ลูกค้า
	--@ptCstF Varchar(20),
	--@ptCstT Varchar(20),
	@FNResult INT OUTPUT 
AS
--------------------------------------
-- Watcharakorn 
-- Create 10/07/2019
-- Temp name  TRPTSalRCTmp
-- @pnLngID ภาษา
-- @ptRptCdoe ชื่อรายงาน
-- @ptUsrSession UsrSession
-- @ptBchF จากรหัสสาขา
-- @ptBchT ถึงรหัสสาขา
-- @ptShpF จากร้านค้า
-- @ptShpT ถึงร้านค้า
-- @ptPdtCodeF จากสินค้า
-- @ptPdtCodeT ถึงสินค้า
-- @ptPdtChanF จากกลุ่มสินค้า
-- @ptPdtChanT ถึงกลุ่มสินค้า
-- @ptPdtTypeF จากประเภทสินค้า
-- @ptPdtTypeT ถึงประเภท

-- @ptDocDateF จากวันที่
-- @ptDocDateT ถึงวันที่
-- @FNResult

-- 07/09/2021 Napat(Jame) เพิ่มเช็คข้อมูลก่อนหาร SUM(FCXsdNetAfHD)/SUM(FCXsdQty)


--------------------------------------
BEGIN TRY

	DECLARE @nLngID int 
	DECLARE @nComName Varchar(100)
	DECLARE @tRptCode Varchar(100)
	DECLARE @tUsrSession Varchar(255)
	DECLARE @tSql VARCHAR(8000)
	DECLARE @tSqlIns VARCHAR(8000)
	DECLARE @tSql1 nVARCHAR(Max)
	DECLARE @tSql2 VARCHAR(8000)

	--Branch Code
	DECLARE @tBchF Varchar(5)
	DECLARE @tBchT Varchar(5)
	--Merchant
	DECLARE @tMerF Varchar(10)
	DECLARE @tMerT Varchar(10)
	--Shop Code
	DECLARE @tShpF Varchar(10)
	DECLARE @tShpT Varchar(10)
	--Pos Code
	DECLARE @tPosF Varchar(20)
	DECLARE @tPosT Varchar(20)

	DECLARE @tPdtCodeF Varchar(20)
	DECLARE @tPdtCodeT Varchar(20)
	DECLARE @tPdtChanF Varchar(30)
	DECLARE @tPdtChanT Varchar(30)
	DECLARE @tPdtTypeF Varchar(5)
	DECLARE @tPdtTypeT Varchar(5)

	DECLARE @tDocDateF Varchar(10)
	DECLARE @tDocDateT Varchar(10)
	--ลูกค้า
	--DECLARE @tCstF Varchar(20)
	--DECLARE @tCstT Varchar(20)


	
	SET @nLngID = @pnLngID
	SET @nComName = @pnComName
	SET @tUsrSession = @ptUsrSession
	SET @tRptCode = @ptRptCode

	--Branch
	SET @tBchF  = @ptBchF
	SET @tBchT  = @ptBchT
	--Merchant
	SET @tMerF  = @ptMerF
	SET @tMerT  = @ptMerT
	--Shop
	SET @tShpF  = @ptShpF
	SET @tShpT  = @ptShpT
	--Pos
	SET @tPosF  = @ptPosF 
	SET @tPosT  = @ptPosT

	SET @tPdtCodeF  = @ptPdtCodeF 
	SET @tPdtCodeT = @ptPdtCodeT
	SET @tPdtChanF = @ptPdtChanF
	SET @tPdtChanT = @ptPdtChanT 
	SET @tPdtTypeF = @ptPdtTypeF
	SET @tPdtTypeT = @ptPdtTypeT

	SET @tDocDateF = @ptDocDateF
	SET @tDocDateT = @ptDocDateT
	SET @FNResult= 0

	SET @tDocDateF = CONVERT(VARCHAR(10),@tDocDateF,121)
	SET @tDocDateT = CONVERT(VARCHAR(10),@tDocDateT,121)

	IF @nLngID = null
	BEGIN
		SET @nLngID = 1
	END	
	--Set ค่าให้ Paraleter กรณี T เป็นค่าว่างหรือ null


	IF @ptBchL = null
	BEGIN
		SET @ptBchL = ''
	END

	IF @tBchF = null
	BEGIN
		SET @tBchF = ''
	END
	IF @tBchT = null OR @tBchT = ''
	BEGIN
		SET @tBchT = @tBchF
	END

	IF @ptMerL =null
	BEGIN
		SET @ptMerL = ''
	END

	IF @tMerF =null
	BEGIN
		SET @tMerF = ''
	END
	IF @tMerT =null OR @tMerT = ''
	BEGIN
		SET @tMerT = @tMerF
	END 

	IF @ptShpL =null
	BEGIN
		SET @ptShpL = ''
	END

	IF @tShpF =null
	BEGIN
		SET @tShpF = ''
	END
	IF @tShpT =null OR @tShpT = ''
	BEGIN
		SET @tShpT = @tShpF
	END

	IF @ptPosL =null
	BEGIN
		SET @ptPosL = ''
	END

	IF @tPosF = null
	BEGIN
		SET @tPosF = ''
	END
	IF @tPosT = null OR @tPosT = ''
	BEGIN
		SET @tPosT = @tPosF
	END

	IF @tPdtCodeF = null
	BEGIN
		SET @tPdtCodeF = ''
	END 
	IF @tPdtCodeT = null OR @tPdtCodeT =''
	BEGIN
		SET @tPdtCodeT = @tPdtCodeF
	END 

	IF @tPdtChanF = null
	BEGIN
		SET @tPdtChanF = ''
	END 
	IF @tPdtChanT = null OR @tPdtChanT =''
	BEGIN
		SET @tPdtChanT = @tPdtChanF
	END 

	IF @tPdtTypeF = null
	BEGIN
		SET @tPdtTypeF = ''
	END 
	IF @tPdtTypeT = null OR @tPdtTypeT =''
	BEGIN
		SET @tPdtTypeT = @tPdtTypeF
	END 

	IF @tDocDateF = null
	BEGIN 
		SET @tDocDateF = ''
	END

	IF @tDocDateT = null OR @tDocDateT =''
	BEGIN 
		SET @tDocDateT = @tDocDateF
	END

	SET @tSql1 =   ' WHERE 1=1 AND FTXshStaDoc = ''1'' AND DT.FTXsdStaPdt <> ''4'''

	IF @pnFilterType = '1'
	BEGIN
		IF (@tBchF <> '' AND @tBchT <> '')
		BEGIN
			SET @tSql1 +=' AND DT.FTBchCode BETWEEN ''' + @tBchF + ''' AND ''' + @tBchT + ''''
		END

		IF (@tMerF <> '' AND @tMerT <> '')
		BEGIN
			SET @tSql1 +=' AND Shp.FTMerCode BETWEEN ''' + @tMerF + ''' AND ''' + @tMerT + ''''
		END

		IF (@tShpF <> '' AND @tShpT <> '')
		BEGIN
			SET @tSql1 +=' AND HD.FTShpCode BETWEEN ''' + @tShpF + ''' AND ''' + @tShpT + ''''
		END

		IF (@tPosF <> '' AND @tPosT <> '')
		BEGIN
			SET @tSql1 += ' AND HD.FTPosCode BETWEEN ''' + @tPosF + ''' AND ''' + @tPosT + ''''
		END		
	END

	IF @pnFilterType = '2'
	BEGIN
		IF (@ptBchL <> '' )
		BEGIN
			SET @tSql1 +=' AND DT.FTBchCode IN (' + @ptBchL + ')'
		END

		IF (@ptMerL <> '' )
		BEGIN
			SET @tSql1 +=' AND Shp.FTMerCode IN (' + @ptMerL + ')'
		END

		IF (@ptShpL <> '')
		BEGIN
			SET @tSql1 +=' AND HD.FTShpCode IN (' + @ptShpL + ')'
		END

		IF (@ptPosL <> '')
		BEGIN
			SET @tSql1 += ' AND HD.FTPosCode IN (' + @ptPosL + ')'
		END		
	END

	IF (@tPdtCodeF <> '' AND @tPdtCodeT <> '')
	BEGIN
		SET @tSql1 +=' AND Pdt.FTPdtCode BETWEEN ''' + @tPdtCodeF + ''' AND ''' + @tPdtCodeT + ''''
	END

	IF (@tPdtChanF <> '' AND @tPdtChanT <> '')
	BEGIN
		SET @tSql1 +=' AND Pdt.FTPgpChain BETWEEN ''' + @tPdtChanF + ''' AND ''' + @tPdtChanT + ''''
	END

	IF (@tPdtTypeF <> '' AND @tPdtTypeT <> '')
	BEGIN
		SET @tSql1 +=' AND Pdt.FTPtyCode BETWEEN ''' + @tPdtTypeF + ''' AND ''' + @tPdtTypeT + ''''
	END

	IF (@tDocDateF <> '' AND @tDocDateT <> '')
	BEGIN
		SET @tSql1 +=' AND CONVERT(VARCHAR(10),FDXshDocDate,121) BETWEEN ''' + @tDocDateF + ''' AND ''' + @tDocDateT + ''''
	END

	DELETE FROM TRPTSalDTTmp WITH (ROWLOCK) WHERE FTComName =  '' + @nComName + ''  AND FTRptCode = '' + @tRptCode + '' AND FTUsrSession = '' + @tUsrSession + ''--ลบข้อมูล Temp ของเครื่องที่จะบันทึกขอมูลลง Temp
 --Sale
  	SET @tSql  = ' INSERT INTO TRPTSalDTTmp '
	SET @tSql +=' (FTComName,FTRptCode,FTUsrSession,'
	SET @tSql +=' FNAppType,FTBchCode,FTBchName,FTPdtCode,FTXsdPdtName,FTPgpChainName,FTPunName,FCXsdQty,FCXsdSetPrice,FCXsdAmtB4DisChg,FCXsdDis,FCXsdVat,FCXsdNet,FCXsdNetAfHD'
	SET @tSql +=' )'
	SET @tSql +=' SELECT '''+ @nComName + ''' AS FTComName,'''+ @tRptCode +''' AS FTRptCode, '''+ @tUsrSession +''' AS FTUsrSession,'
	SET @tSql +=' 1 AS FNAppType,FTBchCode,FTBchName,FTPdtCode,FTPdtName,FTPgpChainName,FTPunName,'
	SET @tSql +=' SUM(FCXsdQty) AS FCXsdQty,'
	--SET @tSql +=' SUM(FCXsdQty*FCXsdSetPrice)/SUM(FCXsdQty) AS FCXsdSetPrice,'
	--SET @tSql +=' AVG(FCXsdSetPrice) AS FCXsdSetPrice,'
	--SET @tSql +=' SUM(FCXsdNetAfHD)/SUM(FCXsdQty) AS FCXsdSetPrice,'
	SET @tSql +=' CASE WHEN ISNULL(SUM(FCXsdQty),0) > 0 THEN SUM(FCXsdNetAfHD)/SUM(FCXsdQty) ELSE 0 END AS FCXsdSetPrice,'
	
	SET @tSql +=' SUM(FCXsdAmtB4DisChg) AS FCXsdAmtB4DisChg,'

	--SET @tSql +=' SUM(FCXsdQty*FCXsdSetPrice) AS FCXsdAmtB4DisChg, '
	SET @tSql +=' SUM(FCXsdDis) AS FCXsdDis ,'
	SET @tSql +=' SUM(FCXsdVat) AS FCXsdVat,'
	SET @tSql +=' SUM(FCXsdNet) AS FCXsdNet,'
	SET @tSql +=' SUM(FCXsdNetAfHD) AS FCXsdNetAfHD'
	SET @tSql +=' FROM'
		SET @tSql +=' (SELECT DT.FTXshDocNo,HD.FDXshDocDate,HD.FTBchCode,Bch_L.FTBchName,DT.FTPdtCode,Pdt_L.FTPdtName,Chan_L.FTPgpChainName,ISNULL(Pun_L.FTPunName,'''') AS FTPunName,'
		SET @tSql +=' CASE WHEN HD.FNXshDocType = 1 THEN  ISNULL(DT.FCXsdQty,0) ELSE ISNULL(DT.FCXsdQty,0)*-1 END FCXsdQty,'
		SET @tSql +=' ISNULL(DT.FCXsdSetPrice,0) AS FCXsdSetPrice,'
		SET @tSql +=' CASE WHEN HD.FNXshDocType = 1 THEN  ISNULL(DT. FCXsdAmtB4DisChg,0) ELSE (ISNULL(DT. FCXsdAmtB4DisChg,0))*-1 END AS FCXsdAmtB4DisChg,'
		SET @tSql +=' CASE WHEN HD.FNXshDocType = 1 THEN  ISNULL(DTDis.FCXddValue, 0) ELSE (ISNULL(DTDis.FCXddValue, 0))*-1 END FCXsdDis,'
		SET @tSql +=' CASE WHEN HD.FNXshDocType = 1 THEN  ISNULL(DT.FCXsdVat,0) ELSE ISNULL(DT.FCXsdVat,0)*-1 END FCXsdVat,'
		SET @tSql +=' CASE WHEN HD.FNXshDocType = 1 THEN  ISNULL(DT.FCXsdNet,0) ELSE ISNULL(DT.FCXsdNet,0)*-1 END FCXsdNet,'
		SET @tSql +=' CASE WHEN HD.FNXshDocType = 1 THEN  ISNULL(DT.FCXsdNetAfHD,0) ELSE ISNULL(DT.FCXsdNetAfHD,0)*-1 END FCXsdNetAfHD'

		SET @tSql +=' FROM TPSTSalDT DT INNER JOIN TPSTSalHD HD ON DT.FTBchCode = HD.FTBchCode AND DT.FTXshDocNo = HD.FTXshDocNo LEFT JOIN'
		SET @tSql +=' ('
			SET @tSql +=' SELECT FTBchCode,FTXshDocNo,FNXsdSeqNo,'
			SET @tSql +=' SUM (CASE WHEN FTXddDisChgType = 3 OR FTXddDisChgType = 4 THEN ISNULL(FCXddValue, 0) ELSE ISNULL(FCXddValue, 0)*-1 END) AS FCXddValue'
			SET @tSql +=' FROM TPSTSalDTDis GROUP BY FTBchCode,FTXshDocNo,FNXsdSeqNo'
		SET @tSql +=' ) AS DTDis ON DT.FTBchCode = DTDis.FTBchCode AND DT.FTXshDocNo = DTDis.FTXshDocNo AND DT.FNXsdSeqNo = DTDis.FNXsdSeqNo LEFT JOIN'
		SET @tSql +=' TCNMPdt Pdt WITH (NOLOCK) ON DT.FTPdtCode = Pdt.FTPdtCode LEFT JOIN'
		SET @tSql +=' TCNMPdt_L Pdt_L WITH (NOLOCK) ON DT.FTPdtCode = Pdt_L.FTPdtCode AND Pdt_L.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + ''' LEFT JOIN'
		SET @tSql +=' TCNMPdtUnit_L Pun_L WITH (NOLOCK) ON DT.FTPunCode = Pun_L.FTPunCode AND  Pun_L.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + ''' LEFT JOIN'
		SET @tSql +=' TCNMPdtGrp_L Chan_L WITH (NOLOCK) ON Pdt.FTPgpChain = Chan_L.FTPgpChain AND Chan_L.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + ''''
		SET @tSql +=' LEFT JOIN TCNMBranch_L Bch_L WITH (NOLOCK) ON  HD.FTBchCode = Bch_L.FTBchCode AND Bch_L.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + ''''
		SET @tSql +=' LEFT JOIN TCNMShop Shp WITH (NOLOCK) ON HD.FTBchCode = Shp.FTBchCode AND HD.FTShpCode = Shp.FTShpCode ' 
		--PRINT @tSql1
		SET @tSql += @tSql1			
		SET @tSql +=' ) SalePdt'
	SET @tSql +=' GROUP BY FTBchCode,FTBchName,FTPdtCode,FTPdtName,FTPgpChainName,FTPunName'
	PRINT @tSql
	EXECUTE(@tSql)

	--INSERT VD
  	SET @tSql  = ' INSERT INTO TRPTSalDTTmp '
	SET @tSql +=' (FTComName,FTRptCode,FTUsrSession,'
	SET @tSql +=' FNAppType,FTBchCode,FTBchName,FTPdtCode,FTXsdPdtName,FTPgpChainName,FTPunName,FCXsdQty,FCXsdSetPrice,FCXsdAmtB4DisChg,FCXsdDis,FCXsdVat,FCXsdNet,FCXsdNetAfHD'
	SET @tSql +=' )'
	SET @tSql +=' SELECT '''+ @nComName + ''' AS FTComName,'''+ @tRptCode +''' AS FTRptCode, '''+ @tUsrSession +''' AS FTUsrSession,'
	SET @tSql +=' 2 AS FNAppType,FTBchCode,FTBchName,FTPdtCode,FTPdtName,FTPgpChainName,FTPunName,'
	SET @tSql +=' SUM(FCXsdQty) AS FCXsdQty,'
	--SET @tSql +=' SUM(FCXsdQty*FCXsdSetPrice)/SUM(FCXsdQty) AS FCXsdSetPrice,'
	--SET @tSql +=' AVG(FCXsdSetPrice) AS FCXsdSetPrice,'
	--SET @tSql +=' SUM(FCXsdNetAfHD)/SUM(FCXsdQty) AS FCXsdSetPrice,'
	SET @tSql +=' CASE WHEN ISNULL(SUM(FCXsdQty),0) > 0 THEN SUM(FCXsdNetAfHD)/SUM(FCXsdQty) ELSE 0 END AS FCXsdSetPrice,'
	SET @tSql +=' SUM(FCXsdAmtB4DisChg) AS FCXsdAmtB4DisChg,'

	--SET @tSql +=' SUM(FCXsdQty*FCXsdSetPrice) AS FCXsdAmtB4DisChg, '
	SET @tSql +=' SUM(FCXsdDis) AS FCXsdDis ,'
	SET @tSql +=' SUM(FCXsdVat) AS FCXsdVat,'
	SET @tSql +=' SUM(FCXsdNet) AS FCXsdNet,'
	SET @tSql +=' SUM(FCXsdNetAfHD) AS FCXsdNetAfHD'
	SET @tSql +=' FROM'
		SET @tSql +=' (SELECT DT.FTXshDocNo,HD.FDXshDocDate,HD.FTBchCode,Bch_L.FTBchName,DT.FTPdtCode,Pdt_L.FTPdtName,Chan_L.FTPgpChainName,ISNULL(Pun_L.FTPunName,'''') AS FTPunName,'
		SET @tSql +=' CASE WHEN HD.FNXshDocType = 1 THEN  ISNULL(DT.FCXsdQty,0) ELSE ISNULL(DT.FCXsdQty,0)*-1 END FCXsdQty,'
		SET @tSql +=' ISNULL(DT.FCXsdSetPrice,0) AS FCXsdSetPrice,'
		SET @tSql +=' CASE WHEN HD.FNXshDocType = 1 THEN  ISNULL(DT. FCXsdAmtB4DisChg,0) ELSE (ISNULL(DT. FCXsdAmtB4DisChg,0))*-1 END AS FCXsdAmtB4DisChg,'
		SET @tSql +=' CASE WHEN HD.FNXshDocType = 1 THEN  ISNULL(DT.FCXsdChg,0)- ISNULL(DT.FCXsdDis,0) ELSE (ISNULL(DT.FCXsdChg,0)- ISNULL(DT.FCXsdDis,0))*-1 END FCXsdDis,'
		SET @tSql +=' CASE WHEN HD.FNXshDocType = 1 THEN  ISNULL(DT.FCXsdVat,0) ELSE ISNULL(DT.FCXsdVat,0)*-1 END FCXsdVat,'
		SET @tSql +=' CASE WHEN HD.FNXshDocType = 1 THEN  ISNULL(DT.FCXsdNet,0) ELSE ISNULL(DT.FCXsdNet,0)*-1 END FCXsdNet,'
		SET @tSql +=' CASE WHEN HD.FNXshDocType = 1 THEN  ISNULL(DT.FCXsdNetAfHD,0) ELSE ISNULL(DT.FCXsdNetAfHD,0)*-1 END FCXsdNetAfHD'
		SET @tSql +=' FROM TVDTSalDT DT INNER JOIN TVDTSalHD HD ON DT.FTBchCode = HD.FTBchCode AND DT.FTXshDocNo = HD.FTXshDocNo LEFT JOIN'
		SET @tSql +=' TCNMPdt Pdt WITH (NOLOCK) ON DT.FTPdtCode = Pdt.FTPdtCode LEFT JOIN'
		SET @tSql +=' TCNMPdt_L Pdt_L WITH (NOLOCK) ON DT.FTPdtCode = Pdt_L.FTPdtCode AND Pdt_L.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + ''' LEFT JOIN'
		SET @tSql +=' TCNMPdtUnit_L Pun_L WITH (NOLOCK) ON DT.FTPunCode = Pun_L.FTPunCode AND  Pun_L.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + ''' LEFT JOIN'
		SET @tSql +=' TCNMPdtGrp_L Chan_L WITH (NOLOCK) ON Pdt.FTPgpChain = Chan_L.FTPgpChain AND Chan_L.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + ''''
		SET @tSql +=' LEFT JOIN TCNMBranch_L Bch_L WITH (NOLOCK) ON  HD.FTBchCode = Bch_L.FTBchCode AND Bch_L.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + ''''
		SET @tSql +=' LEFT JOIN TCNMShop Shp WITH (NOLOCK) ON HD.FTBchCode = Shp.FTBchCode AND HD.FTShpCode = Shp.FTShpCode ' 
		--PRINT @tSql1
		SET @tSql += @tSql1			
		SET @tSql +=' ) SalePdt'
	SET @tSql +=' GROUP BY FTBchCode,FTBchName,FTPdtCode,FTPdtName,FTPgpChainName,FTPunName'
	--PRINT @tSql
	EXECUTE(@tSql)

	RETURN SELECT * FROM TRPTSalDTTmp WHERE FTComName = ''+ @nComName + '' AND FTRptCode = ''+ @tRptCode +'' AND FTUsrSession = '' + @tUsrSession + ''
	
END TRY

BEGIN CATCH 
	SET @FNResult= -1
END CATCH	
GO
--############################################################################################
-- สร้าง		  : 08-02-2022 
-- โดย			 : เจมส์
-- เวอร์ชั่น		: 00.00.02
-- สร้างสโตล STP_DOCxCancelDocPrc (พี่เอ็ม)

IF EXISTS(SELECT name FROM dbo.sysobjects WHERE id = object_id(N'STP_DOCxCancelDocPrc')and OBJECTPROPERTY(id, N'IsProcedure') = 1)
	DROP PROCEDURE STP_DOCxCancelDocPrc
GO

SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].STP_DOCxCancelDocPrc
 @ptBchCode varchar(5)	-- 5. --
,@ptDocNo varchar(30)
,@ptWho varchar(100) ,@FNResult INT OUTPUT AS
DECLARE @tDate varchar(10)
DECLARE @tTime varchar(8)
DECLARE @TTmpPrcStk TABLE 
   ( 
   FTBchCode varchar(5),		-- 5. --
   FTStkDocNo varchar(20), 
   FTStkType varchar(1), 
   FTPdtCode varchar(20), 
   FCStkQty decimal(18,4),
   FTWahCode varchar(5), 
   FDStkDate Datetime ,
   FCXsdSetPrice decimal(18,4),
   FCXsdCostIn decimal(18,4),
   FCXsdCostEx decimal(18,4)
   ) 
DECLARE @tTrans varchar(20)
DECLARE @tStaPrc varchar(1)		-- 4. --
DECLARE @TTmpPrcStkFhn TABLE 
   ( 
   FTBchCode varchar(5),		-- 5. --
   FTStfDocNo varchar(20), 
   FTStfType varchar(1), 
   FTPdtCode varchar(20), 
   FTFhnRefCode varchar(30),
   FCStfQty decimal(18,4), 
   FTWahCode varchar(5), 
   FDStfDate Datetime ,
   FCStfSetPrice decimal(18,4),
   FCStfCostIn decimal(18,4),
   FCStfCostEx decimal(18,4)
   ) 
DECLARE @tStaAlwCostAmt varchar(1)
DECLARE @tDocNoC varchar(30)
/*---------------------------------------------------------------------
Document History
Version		Date			User	Remark
21.05.00	22/02/2019		Em		[KPC] create  
----------------------------------------------------------------------*/
SET @tTrans = 'PrcStk'
BEGIN TRY
	BEGIN TRANSACTION @tTrans
	SET @tDocNoC = @ptDocNo + 'C'

	DELETE TCNTPdtStkCrd WITH(ROWLOCK)
	WHERE FTBchCode = @ptBchCode AND FTStkDocNo = @tDocNoC

	DELETE TFHTPdtStkCrd WITH(ROWLOCK)
	WHERE FTBchCode = @ptBchCode AND FTStfDocNo = @tDocNoC

	--insert data to Temp
	INSERT INTO @TTmpPrcStk (FTBchCode,FTStkDocNo,FTStkType,FTPdtCode,FCStkQty,FTWahCode,FDStkDate,FCXsdSetPrice,FCXsdCostIn,FCXsdCostEx)
	SELECT FTBchCode,@tDocNoC AS FTStkDocNo,FTStkType,FTPdtCode,FCStkQty * (-1) AS FCStkQty,FTWahCode,FDStkDate,FCStkSetPrice,FCStkCostIn,FCStkCostEx
	FROM TCNTPdtStkCrd WITH(NOLOCK)
	WHERE FTBchCode = @ptBchCode AND FTStkDocNo = @ptDocNo

	--update Stk balance
	UPDATE TCNTPdtStkBal with(rowlock)
	SET FCStkQty = ISNULL(STK.FCStkQty,0) + (CASE WHEN TMP.FTStkType = '1' OR TMP.FTStkType = '4' OR TMP.FTStkType = '5' THEN TMP.FCStkQty ELSE TMP.FCStkQty *(-1) END)
	,FDLastUpdOn = GETDATE()
	,FTLastUpdBy = @ptWho
	FROM TCNTPdtStkBal STK
	INNER JOIN @TTmpPrcStk TMP ON STK.FTBchCode = TMP.FTBchCode AND STK.FTWahCode = TMP.FTWahCode AND STK.FTPdtCode = TMP.FTPdtCode		--3.--

	INSERT INTO TCNTPdtStkBal(FTBchCode,FTWahCode,FTPdtCode,FCStkQty,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
	SELECT TMP.FTBchCode,TMP.FTWahCode,TMP.FTPdtCode,(CASE WHEN TMP.FTStkType = '4' THEN TMP.FCStkQty ELSE TMP.FCStkQty *(-1) END) AS FCStkQty,
	GETDATE() AS FDLastUpdOn, @ptWho AS FTLastUpdBy, GETDATE() AS FDCreateOn, @ptWho FTCreateBy
	FROM @TTmpPrcStk TMP
	LEFT JOIN TCNTPdtStkBal BAL WITH(NOLOCK) ON BAL.FTBchCode = TMP.FTBchCode AND BAL.FTWahCode = TMP.FTWahCode AND BAL.FTPdtCode = TMP.FTPdtCode
	WHERE ISNULL(BAL.FTPdtCode,'') = ''

	--insert stk card
	INSERT INTO TCNTPdtStkCrd( FTBchCode, FDStkDate, FTStkDocNo, FTWahCode, FTPdtCode, FTStkType, FCStkQty, FCStkSetPrice, FCStkCostIn, FCStkCostEx, FDCreateOn, FTCreateBy)		--3.--
	SELECT  FTBchCode, FDStkDate, FTStkDocNo, FTWahCode, FTPdtCode, FTStkType, FCStkQty, FCXsdSetPrice, FCXsdCostIn, FCXsdCostEx, GETDATE() AS FDCreateOn,@ptWho AS FTCreateBy		--3.--
	FROM @TTmpPrcStk

	IF EXISTS(SELECT FTPdtCode FROM TFHTPdtStkCrd WHERE FTBchCode = @ptBchCode AND FTStfDocNo = @ptDocNo) BEGIN
		INSERT INTO @TTmpPrcStkFhn (FTBchCode,FTStfDocNo,FTStfType,FTPdtCode,FTFhnRefCode,FCStfQty,FTWahCode,FDStfDate,FCStfSetPrice,FCStfCostIn,FCStfCostEx)		--3.--
		SELECT FTBchCode, @tDocNoC AS FTStfDocNo,FTStfType,FTPdtCode,FTFhnRefCode,FCStfQty*(-1),FTWahCode,FDStfDate,FCStfSetPrice,FCStfCostIn,FCStfCostEx
		FROM TFHTPdtStkCrd WITH(NOLOCK)
		WHERE FTBchCode = @ptBchCode AND FTStfDocNo = @ptDocNo

		IF EXISTS(SELECT FTPdtCode FROM @TTmpPrcStkFhn) BEGIN
			--update Stk balance
			UPDATE TFHTPdtStkBal with(rowlock)
			SET FCStfBal = ISNULL(STK.FCStfBal,0) + (CASE WHEN TMP.FTStfType = '1' OR TMP.FTStfType = '4' OR TMP.FTStfType = '5'  THEN TMP.FCStfQty ELSE TMP.FCStfQty *(-1) END)
			,FDLastUpdOn = GETDATE()
			,FTLastUpdBy = @ptWho
			FROM TFHTPdtStkBal STK
			INNER JOIN @TTmpPrcStkFhn TMP ON STK.FTBchCode = TMP.FTBchCode AND STK.FTWahCode = TMP.FTWahCode AND STK.FTPdtCode = TMP.FTPdtCode AND STK.FTFhnRefCode = TMP.FTFhnRefCode	

			INSERT INTO TFHTPdtStkBal(FTBchCode,FTWahCode,FTPdtCode,FTFhnRefCode,FCStfBal,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
			SELECT TMP.FTBchCode,TMP.FTWahCode,TMP.FTPdtCode,TMP.FTFhnRefCode,(CASE WHEN TMP.FTStfType = '1' OR TMP.FTStfType = '4' OR TMP.FTStfType = '5' THEN TMP.FCStfQty ELSE TMP.FCStfQty *(-1) END) AS FCStkQty,
			GETDATE() AS FDLastUpdOn, @ptWho AS FTLastUpdBy, GETDATE() AS FDCreateOn, @ptWho FTCreateBy
			FROM @TTmpPrcStkFhn TMP
			LEFT JOIN TFHTPdtStkBal BAL WITH(NOLOCK) ON BAL.FTBchCode = TMP.FTBchCode AND BAL.FTWahCode = TMP.FTWahCode AND BAL.FTPdtCode = TMP.FTPdtCode AND BAL.FTFhnRefCode = TMP.FTFhnRefCode
			WHERE ISNULL(BAL.FTFhnRefCode,'') = ''

			--insert stk card
			INSERT INTO TFHTPdtStkCrd( FTBchCode, FDStfDate, FTStfDocNo, FTWahCode, FTPdtCode, FTFhnRefCode, FTStfType, FCStfQty, FCStfSetPrice, FCStfCostIn, FCStfCostEx, FDCreateOn, FTCreateBy)		--3.--
			SELECT  FTBchCode, FDStfDate, FTStfDocNo, FTWahCode, FTPdtCode, FTFhnRefCode, FTStfType, FCStfQty, FCStfSetPrice, FCStfCostIn, FCStfCostEx, GETDATE() AS FDCreateOn,@ptWho AS FTCreateBy		--3.--
			FROM @TTmpPrcStkFhn
		END
	END


	--Cost
	SELECT TOP 1 @tStaAlwCostAmt = ISNULL(WAH.FTWahStaAlwCostAmt,'')
	FROM TCNMWaHouse WAH WITH(NOLOCK)
	INNER JOIN @TTmpPrcStk HD ON HD.FTBchCode = WAH.FTBchCode AND HD.FTWahCode = WAH.FTWahCode
	
	IF @tStaAlwCostAmt = '1'	-- 06.07.00 --
	BEGIN
		UPDATE TCNMPdtCostAvg with(rowlock)
		SET FCPdtCostAmt = ROUND((CASE WHEN (FCPdtQtyBal + TMP.FCStkQty) <= 0 THEN 0 ELSE FCPdtCostEx * (FCPdtQtyBal + TMP.FCStkQty) END),4)	-- 21.06.01 --
		,FCPdtQtyBal = FCPdtQtyBal + TMP.FCStkQty	
		,FDLastUpdOn = GETDATE()
		FROM TCNMPdtCostAvg COST
		INNER JOIN @TTmpPrcStk TMP ON COST.FTPdtCode = TMP.FTPdtCode
		WHERE TMP.FTStkType = '1' OR TMP.FTStkType = '4' OR TMP.FTStkType = '5'

		UPDATE TCNMPdtCostAvg with(rowlock)
		SET FCPdtCostAmt = ROUND((CASE WHEN (FCPdtQtyBal - TMP.FCStkQty) <= 0 THEN 0 ELSE FCPdtCostEx * (FCPdtQtyBal - TMP.FCStkQty) END),4)	-- 21.06.01 --
		,FCPdtQtyBal = FCPdtQtyBal - TMP.FCStkQty	
		,FDLastUpdOn = GETDATE()
		FROM TCNMPdtCostAvg COST
		INNER JOIN @TTmpPrcStk TMP ON COST.FTPdtCode = TMP.FTPdtCode
		WHERE TMP.FTStkType = '2' OR TMP.FTStkType = '3'
	END
	
	COMMIT TRANSACTION @tTrans
	SET @FNResult= 0
END TRY
BEGIN CATCH
	ROLLBACK TRANSACTION @tTrans
	
	INSERT INTO TSysPrcLog(FTComName, FTUsrCode, FTStkDocNo, FDErrDate, FTerrTime, FNErrNo, FNErrSeverity, FNErrState, FTErrFunction, FNErrLine, FTErrMsg)
	VALUES('ISSUE PrcStk', @ptWho, @ptDocNo, CONVERT(VARCHAR(10),GETDATE(),121), CONVERT(VARCHAR(8),GETDATE(),108), 0, 0, 0, 'STP_DOCxCancelDocPrc', 0, ERROR_MESSAGE())

    SET @FNResult= -1
END CATCH
GO

--############################################################################################
-- สร้าง		  : 14-02-2022 
-- โดย			 : เจมส์
-- เวอร์ชั่น		: 00.00.03
-- สร้างสโตล STP_DOCxCancelDocPrc (พี่เอ็ม)

IF EXISTS(SELECT name FROM dbo.sysobjects WHERE id = object_id(N'SP_RPTxVDPdtTwxTmp_StatDose') AND OBJECTPROPERTY(id, N'IsProcedure') = 1)
	DROP PROCEDURE SP_RPTxVDPdtTwxTmp_StatDose
GO

SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[SP_RPTxVDPdtTwxTmp_StatDose]
	@pnLngID int , 
	@pnComName Varchar(100),
	@ptRptCode Varchar(100),
	@ptUsrSession Varchar(255),
	@pnFilterType int, --1 BETWEEN 2 IN
	--สาขา
	@ptBchL Varchar(8000), --กรณี Condition IN
	@ptBchF Varchar(5),
	@ptBchT Varchar(5),
	--Merchant
	@ptMerL Varchar(8000), --กรณี Condition IN
	@ptMerF Varchar(10),
	@ptMerT Varchar(10),
	--Shop Code
	@ptShpL Varchar(8000), --กรณี Condition IN
	@ptShpF Varchar(10),
	@ptShpT Varchar(10),
	--เครื่องจุดขาย
	@ptPosL Varchar(8000), --กรณี Condition IN
	@ptPosF Varchar(20),
	@ptPosT Varchar(20),

	@ptWahINF Varchar(5),
	@ptWahINT Varchar(5),	

	@ptWahOUTF Varchar(5),
	@ptWahOUTT Varchar(5),

	@ptCabinatF Varchar(5),
	@ptCabinatT Varchar(5),

	@ptDocDateF Varchar(10),
	@ptDocDateT Varchar(10),

	@FNResult INT OUTPUT 
AS
--------------------------------------
-- Watcharakorn 
-- Create 10/07/2019
-- Temp name  TRPTVDPdtStkBalTmp
-- @pnLngID ภาษา
-- @ptRptCdoe ชื่อรายงาน
-- @ptUsrSession UsrSession
-- @ptMerF จากเจ้าของกิจการ
-- @ptMerT ถึงจากเจ้าของกิจการ
-- @ptPosF จากตู้ 
-- @ptPosT ถึงตู้
-- @ptWahF จากคลัง
-- @ptWahT ถึงคลัง
-- @ptShpF จากร้านค้า
-- @ptShpT ถึงร้านค้า

-- @ptDocDateF จากวันที่
-- @ptDocDateT ถึงวันที่
-- @FNResult

-- Napat(Jame) Last Update 14/02/2022
-- แก้ไขรายการ Duplicate เนื่องจาก join wahouse ไม่ถูกเงื่อนไข


--------------------------------------
BEGIN TRY	
	DECLARE @nLngID int 
	DECLARE @nComName Varchar(100)
	DECLARE @tRptCode Varchar(100)
	DECLARE @tUsrSession Varchar(255)
	DECLARE @tSql VARCHAR(8000)
	DECLARE @tSqlIns VARCHAR(8000)
	DECLARE @tSql1 nVARCHAR(Max)
	DECLARE @tSql2 VARCHAR(8000)

	--Branch Code
	DECLARE @tBchF Varchar(5)
	DECLARE @tBchT Varchar(5)
	--Merchant
	DECLARE @tMerF Varchar(10)
	DECLARE @tMerT Varchar(10)
	--Shop Code
	DECLARE @tShpF Varchar(10)
	DECLARE @tShpT Varchar(10)
	--Pos Code
	DECLARE @tPosF Varchar(20)
	DECLARE @tPosT Varchar(20)

	--DECLARE @tMerF Varchar(10)
	--DECLARE @tMerT Varchar(10)
	--DECLARE @tPosF Varchar(5)
	--DECLARE @tPosT Varchar(5)
	DECLARE @tWahF Varchar(5)
	DECLARE @tWahT Varchar(5)
	DECLARE @tWahOUTF Varchar(5)
	DECLARE @tWahOUTT Varchar(5)
	
	--DECLARE @tShpF Varchar(30)
	--DECLARE @tShpT Varchar(30)



	DECLARE @tDocDateF Varchar(10)
	DECLARE @tDocDateT Varchar(10)
	--ลูกค้า
	--DECLARE @tCstF Varchar(20)
	--DECLARE @tCstT Varchar(20)


	--SET @nLngID = 1
	--SET @nComName = 'Ada062'
	--SET @tRptCode = 'StockBalance2002001'
	--SET @tUsrSession = '001'
	--SET @tMerF = '00050'
	--SET @tMerT = '002'
	--SET @tPosF = '00001'
	--SET @tPosT = '00011'
	--SET @tWahF = '00001'
	--SET @tWahT = '00019'

	--SET @tShpF = '00001'
	--SET @tShpT = '00027'


	--SET @tDocDateF = ''
	--SET @tDocDateT = ''

	SET @nLngID = @pnLngID
	SET @nComName = @pnComName
	SET @tUsrSession = @ptUsrSession
	SET @tRptCode = @ptRptCode

	--Branch
	SET @tBchF  = @ptBchF
	SET @tBchT  = @ptBchT
	--Merchant
	SET @tMerF  = @ptMerF
	SET @tMerT  = @ptMerT
	--Shop
	SET @tShpF  = @ptShpF
	SET @tShpT  = @ptShpT
	--Pos
	SET @tPosF  = @ptPosF 
	SET @tPosT  = @ptPosT

	SET @tWahF = @ptWahINF
	SET @tWahT = @ptWahINT
	SET @tWahOUTF = @ptWahOUTF
	SET @tWahOUTT = @ptWahOUTT


	
	--SET @tShpF = @ptShpF
	--SET @tShpT = @ptShpT

	SET @tDocDateF = @ptDocDateF
	SET @tDocDateT = @ptDocDateT
	SET @FNResult= 0

	SET @tDocDateF = CONVERT(VARCHAR(10),@tDocDateF,121)
	SET @tDocDateT = CONVERT(VARCHAR(10),@tDocDateT,121)

	IF @nLngID = null
	BEGIN
		SET @nLngID = 1
	END	
	--Set ค่าให้ Paraleter กรณี T เป็นค่าว่างหรือ null

	IF @ptBchL = null
	BEGIN
		SET @ptBchL = ''
	END

	IF @tBchF = null
	BEGIN
		SET @tBchF = ''
	END
	IF @tBchT = null OR @tBchT = ''
	BEGIN
		SET @tBchT = @tBchF
	END

	IF @ptMerL =null
	BEGIN
		SET @ptMerL = ''
	END

	IF @tMerF =null
	BEGIN
		SET @tMerF = ''
	END
	IF @tMerT =null OR @tMerT = ''
	BEGIN
		SET @tMerT = @tMerF
	END 

	IF @ptShpL =null
	BEGIN
		SET @ptShpL = ''
	END

	IF @tShpF =null
	BEGIN
		SET @tShpF = ''
	END
	IF @tShpT =null OR @tShpT = ''
	BEGIN
		SET @tShpT = @tShpF
	END

	IF @tPosF = null
	BEGIN
		SET @tPosF = ''
	END
	IF @tPosT = null OR @tPosT = ''
	BEGIN
		SET @tPosT = @tPosF
	END
	--10/02/2020
    IF @ptCabinatF	= NULL
	BEGIN
		SET @ptCabinatF = 0
	END
	IF @ptCabinatT = null OR @ptCabinatT = 0
	BEGIN
		SET @ptCabinatT =  @ptCabinatF
	END

	IF @tWahF = null
	BEGIN
		SET @tWahF = ''
	END 
	IF @tWahT = null OR @tWahT =''
	BEGIN
		SET @tWahT = @tWahF
	END 

	IF @tWahOUTF = null
	BEGIN
		SET @tWahOUTF = ''
	END 
	IF @tWahOUTT = null OR @tWahOUTT =''
	BEGIN
		SET @tWahOUTT = @tWahOUTF
	END 

	IF @tDocDateF = null
	BEGIN 
		SET @tDocDateF = ''
	END

	IF @tDocDateT = null OR @tDocDateT =''
	BEGIN 
		SET @tDocDateT = @tDocDateF
	END
	
		
	/*SET @tSql1 =   ' WHERE 1=1 '*/
	SET @tSql1 =   ' WHERE DT.FCXtdQty <> ''0'''

	IF @pnFilterType = '1'
	BEGIN
		IF (@tBchF <> '' AND @tBchT <> '')
		BEGIN
			SET @tSql1 +=' AND HD.FTBchCode BETWEEN ''' + @tBchF + ''' AND ''' + @tBchT + ''''
		END

		IF (@tMerF <> '' AND @tMerT <> '')
		BEGIN
			SET @tSql1 +=' AND HD.FTXthMerCode BETWEEN ''' + @tMerF + ''' AND ''' + @tMerT + ''''
		END

		IF (@tShpF <> '' AND @tShpT <> '')
		BEGIN
			SET @tSql1 +=' AND HD.FTXthShopTo BETWEEN ''' + @tShpF + ''' AND ''' + @tShpT + ''''
		END

		IF (@tPosF <> '' AND @tPosT <> '')
		BEGIN
			SET @tSql1 += ' AND HD.FTXthPosTo BETWEEN ''' + @tPosF + ''' AND ''' + @tPosT + ''''
		END		


	END

	IF @pnFilterType = '2'
	BEGIN
		IF (@ptBchL <> '' )
		BEGIN
			SET @tSql1 +=' AND HD.FTBchCode IN (' + @ptBchL + ')'
		END

		IF (@ptMerL <> '' )
		BEGIN
			SET @tSql1 +=' AND HD.FTXthMerCode IN (' + @ptMerL + ')'
		END

		IF (@ptShpL <> '')
		BEGIN
			SET @tSql1 +=' AND HD.FTXthShopTo IN (' + @ptShpL + ')'
		END

		IF (@ptPosL <> '')
		BEGIN
			SET @tSql1 += ' AND HD.FTXthPosTo IN (' + @ptPosL + ')'
		END		
	END

	IF @ptCabinatF <> 0 AND @ptCabinatT <> 0
	BEGIN
		SET @tSql1 +=' AND DT.FNCabSeq BETWEEN ''' + @ptCabinatF + ''' AND ''' + @ptCabinatT + ''''
	END

	IF (@tWahF <> '' AND @tWahT <> '')
	BEGIN
		SET @tSql1 +=' AND DT.FTXthWhTo BETWEEN ''' + @tWahF + ''' AND ''' + @tWahT + ''''
	END

	IF (@tWahOUTF <> '' AND @tWahOUTT <> '')
	BEGIN
		SET @tSql1 +=' AND DT.FTXthWhFrm BETWEEN ''' + @tWahOUTF + ''' AND ''' + @tWahOUTT + ''''
	END

	IF (@tDocDateF <> '' AND @tDocDateT <> '')
	BEGIN
    	SET @tSql1 +=' AND CONVERT(VARCHAR(10),HD.FDLastUpdOn,121) BETWEEN ''' + @tDocDateF + ''' AND ''' + @tDocDateT + ''''
	END


	DELETE FROM TRPTVDPdtTwxTmp_StatDose WITH (ROWLOCK) WHERE FTComName =  '' + @nComName + ''  AND FTRptCode = '' + @tRptCode + '' AND FTUsrSession = '' + @tUsrSession + ''--ลบข้อมูล Temp ของเครื่องที่จะบันทึกขอมูลลง Temp
 

    SET @tSql  = ' INSERT INTO TRPTVDPdtTwxTmp_StatDose '
	SET @tSql +=' (FTComName,FTRptCode,FTUsrSession,'
	SET @tSql +=' FTBchCode,FTXthShopTo ,FTXthWhTo, FTWahNameTO,FTXthDocNo, FDXthDocDate,'
	SET @tSql +=' FNCabSeq,FTCabName,FTXthWhFrm,FTWahNameFrm,FTPdtCode, FTPdtName,FNLayCol,FNLayRow,FCXtdQty,FTBchName,FTShpName,FTUsrName'
	SET @tSql +=' )'
		SET @tSql +=' SELECT '''+ @nComName + ''' AS FTComName,'''+ @tRptCode +''' AS FTRptCode, '''+ @tUsrSession +''' AS FTUsrSession,'
		SET @tSql +=' Add1.FTBchCode,FTXthShopTo ,FTXthWhTo, FTWahNameTO,FTXthDocNo, FDXthDocDate,'
		SET @tSql +=' Add1.FNCabSeq,SCbn_L.FTCabName,FTXthWhFrm,FTWahNameFrm,Add1.FTPdtCode, FTPdtName,Add1.FNLayCol,Add1.FNLayRow,FCXtdQty,FTBchName,FTShpName,FTUsrName'
		SET @tSql +=' FROM('
			 SET @tSql +=' SELECT HD.FTBchCode,HD.FTXthShopTo ,DT.FTXthWhTo,WahL_T.FTWahName AS FTWahNameTO,HD.FTXthDocNo,CONVERT(VARCHAR(10), FDXthDocDate,121) AS FDXthDocDate,'
			 SET @tSql +=' DT.FNCabSeq,DT.FTXthWhFrm,WahL_F.FTWahName AS FTWahNameFrm,DT.FTPdtCode, Pdt_L.FTPdtName,DT.FNLayCol,DT.FNLayRow,DT.FCXtdQty,BCH_L.FTBchName,SHP_L.FTShpName,USR_L.FTUsrName'
			 SET @tSql +=' FROM TVDTPdtTwxHD HD WITH (NOLOCK)'
				 SET @tSql +=' INNER JOIN TVDTPdtTwxDT DT WITH (NOLOCK) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXthDocNo = DT.FTXthDocNo'
				 SET @tSql +=' INNER JOIN TCNMWaHouse_L WahL_T WITH (NOLOCK) ON DT.FTXthWhTo = WahL_T.FTWahCode AND DT.FTBchCode = WahL_T.FTBchCode AND WahL_T.FNLngID =  '''  + CAST(@nLngID  AS VARCHAR(10)) + ''''
				 SET @tSql +=' INNER JOIN TCNMWaHouse_L WahL_F WITH (NOLOCK) ON DT.FTXthWhFrm = WahL_F.FTWahCode AND DT.FTBchCode = WahL_F.FTBchCode AND WahL_F.FNLngID =  '''  + CAST(@nLngID  AS VARCHAR(10)) + ''''
				 SET @tSql +=' INNER JOIN TCNMPdt_L Pdt_L WITH (NOLOCK) ON DT.FTPdtCode = Pdt_L.FTPdtCode AND Pdt_L.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + ''''
				 SET @tSql +=' LEFT JOIN TCNMBranch_L BCH_L WITH (NOLOCK) ON HD.FTBchCode = BCH_L.FTBchCode AND BCH_L.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + ''''
				 SET @tSql +=' LEFT JOIN TCNMShop_L SHP_L WITH (NOLOCK) ON HD.FTXthShopTo = SHP_L.FTShpCode AND HD.FTBchCode = SHP_L.FTBchCode AND SHP_L.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + ''''
				  SET @tSql +=' LEFT JOIN TCNMUser_L USR_L WITH (NOLOCK) ON HD.FTUsrCode = USR_L.FTUsrCode AND USR_L.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + ''''
				--PRINT @tSql1
				 SET @tSql +=@tSql1				 
			SET @tSql +=' ) Add1 INNER JOIN'
			SET @tSql +=' ('
			 SET @tSql +=' SELECT FTBchCode,FTShpCode,FTPdtCode,FNCabSeq,FNLayCol,FNLayRow FROM TVDMPdtLayout'
			SET @tSql +=' ) PdtLayout'
			SET @tSql +=' ON Add1.FTBchCode = PdtLayout.FTBchCode AND Add1.FTXthShopTo = PdtLayout.FTShpCode AND Add1.FTPdtCode = PdtLayout.FTPdtCode AND Add1.FNCabSeq = PdtLayout.FNCabSeq AND'
			SET @tSql +=' Add1.FNLayCol = PdtLayout.FNLayCol AND Add1.FNLayRow = PdtLayout.FNLayRow'
			SET @tSql +=' LEFT JOIN TVDMShopCabinet SCbn WITH (NOLOCK) ON PdtLayout.FTBchCode = SCbn.FTBchCode AND PdtLayout.FTShpCode = SCbn.FTShpCode AND Add1.FNCabSeq = SCbn.FNCabSeq'
			SET @tSql +=' LEFT JOIN TVDMShopCabinet_L SCbn_L WITH (NOLOCK) ON SCbn.FTShpCode = SCbn_L.FTShpCode AND SCbn.FNCabSeq = SCbn_L.FNCabSeq AND SCbn.FTBchCode = SCbn_L.FTBchCode AND  SCbn_L.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + ''''
	--PRINT @tSql
	EXECUTE(@tSql)
	--RETURN SELECT * FROM TRPTVDPdtTwxTmp_StatDose WHERE FTComName = ''+ @nComName + '' AND FTRptCode = ''+ @tRptCode +'' AND FTUsrSession = '' + @tUsrSession + ''
END TRY

BEGIN CATCH 
	SET @FNResult= -1
	--PRINT @tSql
END CATCH	
GO

--############################################################################################
-- สร้าง		  : 17-02-2022 
-- โดย			 : เจมส์
-- เวอร์ชั่น		: 00.00.04
-- สร้างสโตล STP_DOCxCancelDocPrc (พี่เอ็ม)

IF EXISTS(SELECT name FROM dbo.sysobjects WHERE id = object_id(N'SP_RPTxStockBalance2002001') AND OBJECTPROPERTY(id, N'IsProcedure') = 1)
	DROP PROCEDURE SP_RPTxStockBalance2002001
GO

SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SP_RPTxStockBalance2002001]
	@pnLngID int , 
	@pnComName Varchar(100),
	@ptRptCode Varchar(100),
	@ptUsrSession Varchar(255),
	@pnFilterType int, --1 BETWEEN 2 IN
	--สาขา
	@ptBchL Varchar(8000), --กรณี Condition IN
	@ptBchF Varchar(5),
	@ptBchT Varchar(5),
	--Merchant
	@ptMerL Varchar(8000), --กรณี Condition IN
	@ptMerF Varchar(10),
	@ptMerT Varchar(10),
	--Shop Code
	@ptShpL Varchar(8000), --กรณี Condition IN
	@ptShpF Varchar(10),
	@ptShpT Varchar(10),
	--เครื่องจุดขาย
	@ptPosL Varchar(8000), --กรณี Condition IN
	@ptPosF Varchar(20),
	@ptPosT Varchar(20),

	--@ptMerF Varchar(10),
	--@ptMerT Varchar(10),
	--@ptPosF Varchar(5),
	--@ptPosT Varchar(5),
	@ptWahF Varchar(5),
	@ptWahT Varchar(5),	
	--@ptShpF Varchar(30),
	--@ptShpT Varchar(30),

	@ptPdtF Varchar(20),
	@ptPdtT Varchar(20),

	@ptDocDateF Varchar(10),
	@ptDocDateT Varchar(10),
	----ลูกค้า
	--@ptCstF Varchar(20),
	--@ptCstT Varchar(20),
	@FNResult INT OUTPUT 
AS
--------------------------------------
-- Watcharakorn 
-- Create 10/07/2019
-- Temp name  TRPTVDPdtStkBalTmp
-- @pnLngID ภาษา
-- @ptRptCdoe ชื่อรายงาน
-- @ptUsrSession UsrSession
-- @ptMerF จากเจ้าของกิจการ
-- @ptMerT ถึงจากเจ้าของกิจการ
-- @ptPosF จากตู้ 
-- @ptPosT ถึงตู้
-- @ptWahF จากคลัง
-- @ptWahT ถึงคลัง
-- @ptShpF จากร้านค้า
-- @ptShpT ถึงร้านค้า

-- @ptDocDateF จากวันที่
-- @ptDocDateT ถึงวันที่
-- @FNResult


--------------------------------------
BEGIN TRY	
	DECLARE @nLngID int 
	DECLARE @nComName Varchar(100)
	DECLARE @tRptCode Varchar(100)
	DECLARE @tUsrSession Varchar(255)
	DECLARE @tSql VARCHAR(8000)
	DECLARE @tSqlIns VARCHAR(8000)
	DECLARE @tSql1 nVARCHAR(Max)
	DECLARE @tSql2 VARCHAR(8000)

	--Branch Code
	DECLARE @tBchF Varchar(5)
	DECLARE @tBchT Varchar(5)
	--Merchant
	DECLARE @tMerF Varchar(10)
	DECLARE @tMerT Varchar(10)
	--Shop Code
	DECLARE @tShpF Varchar(10)
	DECLARE @tShpT Varchar(10)
	--Pos Code
	DECLARE @tPosF Varchar(20)
	DECLARE @tPosT Varchar(20)

	--DECLARE @tMerF Varchar(10)
	--DECLARE @tMerT Varchar(10)
	--DECLARE @tPosF Varchar(5)
	--DECLARE @tPosT Varchar(5)
	DECLARE @tWahF Varchar(5)
	DECLARE @tWahT Varchar(5)
	
	--DECLARE @tShpF Varchar(30)
	--DECLARE @tShpT Varchar(30)



	DECLARE @tDocDateF Varchar(10)
	DECLARE @tDocDateT Varchar(10)
	--ลูกค้า
	--DECLARE @tCstF Varchar(20)
	--DECLARE @tCstT Varchar(20)


	--SET @nLngID = 1
	--SET @nComName = 'Ada062'
	--SET @tRptCode = 'StockBalance2002001'
	--SET @tUsrSession = '001'
	--SET @tMerF = '00050'
	--SET @tMerT = '002'
	--SET @tPosF = '00001'
	--SET @tPosT = '00011'
	--SET @tWahF = '00001'
	--SET @tWahT = '00019'

	--SET @tShpF = '00001'
	--SET @tShpT = '00027'


	--SET @tDocDateF = ''
	--SET @tDocDateT = ''

	SET @nLngID = @pnLngID
	SET @nComName = @pnComName
	SET @tUsrSession = @ptUsrSession
	SET @tRptCode = @ptRptCode

	--Branch
	SET @tBchF  = @ptBchF
	SET @tBchT  = @ptBchT
	--Merchant
	SET @tMerF  = @ptMerF
	SET @tMerT  = @ptMerT
	--Shop
	SET @tShpF  = @ptShpF
	SET @tShpT  = @ptShpT
	--Pos
	SET @tPosF  = @ptPosF 
	SET @tPosT  = @ptPosT

	--SET @tMerF =@ptMerF
	--SET @tMerT = @ptMerT
	--SET @tPosF = @ptPosF
	--SET @tPosT = @ptPosT
	SET @tWahF = @ptWahF
	SET @tWahT = @ptWahT
	
	--SET @tShpF = @ptShpF
	--SET @tShpT = @ptShpT

	SET @tDocDateF = @ptDocDateF
	SET @tDocDateT = @ptDocDateT
	SET @FNResult= 0

	SET @tDocDateF = CONVERT(VARCHAR(10),@tDocDateF,121)
	SET @tDocDateT = CONVERT(VARCHAR(10),@tDocDateT,121)

	IF @nLngID = null
	BEGIN
		SET @nLngID = 1
	END	
	--Set ค่าให้ Paraleter กรณี T เป็นค่าว่างหรือ null

	IF @ptBchL = null
	BEGIN
		SET @ptBchL = ''
	END

	IF @tBchF = null
	BEGIN
		SET @tBchF = ''
	END
	IF @tBchT = null OR @tBchT = ''
	BEGIN
		SET @tBchT = @tBchF
	END

	IF @ptMerL =null
	BEGIN
		SET @ptMerL = ''
	END

	IF @tMerF =null
	BEGIN
		SET @tMerF = ''
	END
	IF @tMerT =null OR @tMerT = ''
	BEGIN
		SET @tMerT = @tMerF
	END 

	IF @ptShpL =null
	BEGIN
		SET @ptShpL = ''
	END

	IF @tShpF =null
	BEGIN
		SET @tShpF = ''
	END
	IF @tShpT =null OR @tShpT = ''
	BEGIN
		SET @tShpT = @tShpF
	END

	IF @tPosF = null
	BEGIN
		SET @tPosF = ''
	END
	IF @tPosT = null OR @tPosT = ''
	BEGIN
		SET @tPosT = @tPosF
	END

	--IF @tMerF = null
	--BEGIN
	--	SET @tMerF = ''
	--END
	--IF @tMerT = null OR @tMerT = ''
	--BEGIN
	--	SET @tMerT = @tMerF
	--END

	--IF @tShpF = null
	--BEGIN
	--	SET @tShpF = ''
	--END 
	--IF @tShpT = null OR @tShpT =''
	--BEGIN
	--	SET @tShpT = @tShpF
	--END 

	--IF @tPosF = null
	--BEGIN
	--	SET @tPosF = ''
	--END 
	--IF @tPosT = null OR @tPosT =''
	--BEGIN
	--	SET @tPosT = @tPosF
	--END 

  IF @ptPdtF	= NULL
	BEGIN
		SET @ptPdtF = ''
	END
	IF @ptPdtT = null OR @ptPdtT = ''
	BEGIN
		SET @ptPdtT =  @ptPdtF
	END


	IF @tWahF = null
	BEGIN
		SET @tWahF = ''
	END 
	IF @tWahT = null OR @tWahT =''
	BEGIN
		SET @tWahT = @tWahF
	END 

	IF @tDocDateF = null
	BEGIN 
		SET @tDocDateF = ''
	END

	IF @tDocDateT = null OR @tDocDateT =''
	BEGIN 
		SET @tDocDateT = @tDocDateF
	END
	
	--ของเก่า
	--SET @tSql1 =   ' WHERE 1=1 AND ISNULL(Wah.FTWahRefCode,'''') != '''' '

	--ของใหม่  วัฒน์ 17/09/2020
	SET @tSql1 =   ' WHERE ISNULL(PDTLAY.FTPdtCode,'''') <> '''' AND ISNULL(POS.FTPosCode,'''') <> '''' AND ISNULL(Wah.FTWahCode,'''') <> '''' AND PDTLAY.FTPdtCode <> ''IMPORTFAIL'' '

	IF @pnFilterType = '1'
	BEGIN
		IF (@tBchF <> '' AND @tBchT <> '')
		BEGIN
			SET @tSql1 +=' AND PDTLAY.FTBchCode BETWEEN ''' + @tBchF + ''' AND ''' + @tBchT + ''''
		END

		IF (@tMerF <> '' AND @tMerT <> '')
		BEGIN
			SET @tSql1 +=' AND FTMerCode BETWEEN ''' + @tMerF + ''' AND ''' + @tMerT + ''''
		END

		IF (@tShpF <> '' AND @tShpT <> '')
		BEGIN
			SET @tSql1 +=' AND PDTLAY.FTShpCode BETWEEN ''' + @tShpF + ''' AND ''' + @tShpT + ''''
		END

		IF (@tPosF <> '' AND @tPosT <> '')
		BEGIN
			SET @tSql1 += ' AND Wah.FTWahRefCode BETWEEN ''' + @tPosF + ''' AND ''' + @tPosT + ''''
		END		
	END

	IF @pnFilterType = '2'
	BEGIN
		IF (@ptBchL <> '' )
		BEGIN
			SET @tSql1 +=' AND PDTLAY.FTBchCode IN (' + @ptBchL + ')'
		END

		IF (@ptMerL <> '' )
		BEGIN
			SET @tSql1 +=' AND FTMerCode IN (' + @ptMerL + ')'
		END

		IF (@ptShpL <> '')
		BEGIN
			SET @tSql1 +=' AND PDTLAY.FTShpCode IN (' + @ptShpL + ')'
		END

		IF (@ptPosL <> '')
		BEGIN
			SET @tSql1 += ' AND Wah.FTWahRefCode IN (' + @ptPosL + ')'
		END		

		IF (@ptPdtF <> '' AND @ptPdtT <> '')
		BEGIN
			SET @tSql1 +=' AND PDTLAY.FTPdtCode BETWEEN ''' + @ptPdtF + ''' AND ''' + @ptPdtT + ''''
		END

	END

	IF (@tWahF <> '' AND @tWahT <> '')
	BEGIN
		SET @tSql1 +=' AND Wah.FTWahCode BETWEEN ''' + @tWahF + ''' AND ''' + @tWahT + ''''
	END
	
	IF (@tDocDateF <> '' AND @tDocDateT <> '')
	BEGIN
    	SET @tSql1 +=' AND CONVERT(VARCHAR(10),STKBal.FDLastUpdOn,121) BETWEEN ''' + @tDocDateF + ''' AND ''' + @tDocDateT + ''''
	END


	DELETE FROM TRPTVDPdtStkBalTmp WITH (ROWLOCK) WHERE FTComName =  '' + @nComName + ''  AND FTRptCode = '' + @tRptCode + '' AND FTUsrSession = '' + @tUsrSession + ''--ลบข้อมูล Temp ของเครื่องที่จะบันทึกขอมูลลง Temp
 
   	SET @tSql  = ' INSERT INTO TRPTVDPdtStkBalTmp '
	SET @tSql +=' (FTComName,FTRptCode,FTUsrSession,'
	SET @tSql +=' FTBchCode,FDLastUpdOn,FTWahCode, FTPosCode ,FTPdtCode,FTPdtName ,FNLayRow,FNLayCol,FCStkQty,FCPdtCostEX,FNCabSeq,FTCabName,FCLayColQtyMax,FTPosName'
	SET @tSql +=' )'
	SET @tSql +=' SELECT '''+ @nComName + ''' AS FTComName,'''+ @tRptCode +''' AS FTRptCode, '''+ @tUsrSession +''' AS FTUsrSession,'
	SET @tSql +=' FTBchCode, FDLastUpdOn,FTWahCode,FTPosCode ,FTPdtCode,FTPdtName ,FNLayRow,FNLayCol,FCStkQty,FCPdtCostEX,FNCabSeq,FTCabName,FCLayColQtyMax,FTPosName'
	SET @tSql +=' FROM'
		--ของเก่า
		/*SET @tSql +=' (SELECT Stk.FTBchCode,Stk.FDLastUpdOn, Stk.FTWahCode,Wah.FTWahRefCode AS FTPosCode ,Stk.FTPdtCode,Pdt_L.FTPdtName ,FNLayRow,FNLayCol,FCStkQty,AvgCost.FCPdtCostAVGEX AS FCPdtCostEX'
		SET @tSql +=' FROM TVDTPdtStkBal Stk WITH (NOLOCK)  INNER JOIN'		  
				  SET @tSql +=' TCNMPdt Pdt WITH (NOLOCK) ON Stk.FTPdtCode = Pdt.FTPdtCode LEFT JOIN' 
				  SET @tSql +=' VCN_ProductCost AvgCost WITH (NOLOCK) ON Pdt.FTPdtCode = AvgCost.FTPdtCode  LEFT JOIN'
				  SET @tSql +=' TCNMPdt_L Pdt_L WITH (NOLOCK) ON Stk.FTPdtCode = Pdt_L.FTPdtCode AND Pdt_L.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + ''' LEFT JOIN' 
				  SET @tSql +=' TCNMWaHouse Wah WITH (NOLOCK) ON Stk.FTWahCode = Wah.FTWahCode AND Stk.FTBchCode = Wah.FTBchCode LEFT JOIN'
				  SET @tSql +=' TCNMWaHouse_L Wah_L WITH (NOLOCK) ON Stk.FTWahCode = Wah_L.FTWahCode AND Stk.FTBchCode = Wah_L.FTBchCode AND Wah_L.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + '''  LEFT JOIN'
				  SET @tSql +=' ( SELECT SHP.FTBchCode,SHP.FTShpCode,WAH.FTWahCode,SHP.FTMerCode '
	              SET @tSql +=' FROM TCNMShop SHP WITH (NOLOCK) '
	              SET @tSql +=' LEFT JOIN TVDMPosShop PSS ON SHP.FTShpCode = PSS.FTShpCode  AND SHP.FTBchCode = PSS.FTBchCode  '
				  SET @tSql +=' LEFT JOIN TCNMWaHouse WAH ON PSS.FTPosCode = WAH.FTWahRefCode AND PSS.FTBchCode = WAH.FTBchCode  '
				  SET @tSql +=' ) Mer ON Stk.FTBchCode = Mer.FTBchCode AND Stk.FTWahCode = Mer.FTWahCode'
				  PRINT @tSql1
				  SET @tSql +=@tSql1
		SET @tSql +=' ) Stk1'*/

		--ของใหม่  วัฒน์ 17/09/2020
		SET @tSql +=' (SELECT PDTLAY.FTBchCode,
						
						/*
						STKBal.FDLastUpdOn,
						STKBal.FTWahCode,
						Wah.FTWahRefCode AS FTPosCode,
						*/

						PDTLAY.FDLastUpdOn,
						Wah.FTWahCode,
						POS.FTPosCode,
						PDTLAY.FTPdtCode,
						Pdt_L.FTPdtName,
						PDTLay.FNLayRow,
						PDTLay.FNLayCol,
						ISNULL(FCStkQty,0) AS FCStkQty,
						AvgCost.FCPdtCostAVGEX AS FCPdtCostEX,
						PDTLay.FNCabSeq,
						CABL.FTCabName AS FTCabName,
						PDTLAY.FCLayColQtyMax,
						POS_L.FTPosName '
		SET @tSql +=' FROM TVDMPdtLayout PDTLAY WITH (NOLOCK)'		  
		SET @tSql +=' LEFT JOIN VCN_ProductCost AvgCost WITH (NOLOCK) ON PDTLAY.FTPdtCode = AvgCost.FTPdtCode ' 
		SET @tSql +=' INNER JOIN TVDMShopCabinet_L CABL WITH (NOLOCK) ON PDTLAY.FNCabSeq = CABL.FNCabSeq AND PDTLAY.FTBchCode = CABL.FTBchCode AND PDTLAY.FTShpCode = CABL.FTShpCode AND CABL.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + ''' ' 
		SET @tSql +=' LEFT JOIN TVDMPosShop POS 			  WITH (NOLOCK) ON PDTLAY.FTShpCode = POS.FTShpCode AND PDTLAY.FTBchCode = POS.FTBchCode '
		SET @tSql +=' LEFT JOIN TCNMPos_L POS_L WITH(NOLOCK) ON POS.FTPosCode = POS_L.FTPosCode AND PDTLAY.FTBchCode = POS_L.FTBchCode AND POS_L.FNLngID = ''1'' '
		SET @tSql +=' LEFT JOIN TCNMPdt_L Pdt_L 				WITH (NOLOCK) ON PDTLAY.FTPdtCode = Pdt_L.FTPdtCode AND Pdt_L.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + ''' ' 
		SET @tSql +=' LEFT JOIN TCNMWaHouse Wah 				WITH (NOLOCK) ON PDTLAY.FTBchCode = Wah.FTBchCode 
																										AND Wah.FTWahStaType = ''6''
																										AND Wah.FTWahRefCode = POS.FTPosCode '
		SET @tSql +=' LEFT JOIN TCNMWaHouse_L Wah_L 		WITH (NOLOCK) ON Wah.FTWahCode = Wah_L.FTWahCode AND PDTLAY.FTBchCode = Wah_L.FTBchCode AND Wah_L.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + ''' '
		SET @tSql +=' LEFT JOIN TVDTPdtStkBal STKBal		WITH (NOLOCK)	ON PDTLAY.FTBchCode = STKBal.FTBchCode 
																										AND PDTLAY.FNCabSeq = STKBal.FNCabSeq 
																										AND PDTLAY.FNLayCol = STKBal.FNLayCol 
																										AND PDTLAY.FNLayRow = STKBal.FNLayRow 
																										AND STKBal.FTWahCode = Wah.FTWahCode
																										AND STKBal.FTPdtCode = PDTLAY.FTPdtCode '
		SET @tSql += @tSql1
		SET @tSql +=' ) Stk1 ORDER BY Stk1.FTBchCode , Stk1.FTPosCode , Stk1.FNLayRow , Stk1.FNLayCol ASC'
		--PRINT @tSql;
	EXECUTE(@tSql)

	RETURN SELECT * FROM TRPTVDPdtStkBalTmp WHERE FTComName = ''+ @nComName + '' AND FTRptCode = ''+ @tRptCode +'' AND FTUsrSession = '' + @tUsrSession + ''
	
END TRY

BEGIN CATCH 
	SET @FNResult= -1
END CATCH
GO

--############################################################################################
-- สร้าง		  : 11-03-2022 
-- โดย			 : เจมส์
-- เวอร์ชั่น		: 00.00.05, 00.00.06
-- 00.00.05 เพิ่ม Store SP_RPTxRcvInfoTrialPdtVD รายงานข้อมูลการรับสินค้าทดลองที่ตู้ Vending
-- 00.00.06 Update 17/03/2022 ถ้า Option หมดอายุคิวอาร์ ตั้งค่าเป็น วันที่ ต้อง Convert ให้แสดงเฉพาะวันที่

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[SP_RPTxRcvInfoTrialPdtVD]') AND type in (N'P', N'PC'))
	DROP PROCEDURE SP_RPTxRcvInfoTrialPdtVD
GO

SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE SP_RPTxRcvInfoTrialPdtVD
	@pnLngID int, 
	@ptUsrSession Varchar(255),
	@ptBchL Varchar(8000), --สาขา Condition IN
	@ptMerL Varchar(8000), --กลุ่มร้านค้า Condition IN
	@ptShpL Varchar(8000), --รูปแบบการจัดสินค้า Condition IN
	@ptPosL Varchar(8000), --ตู้ขายสินค้า Condition IN
	@ptDocDateF Varchar(10),
	@ptDocDateT Varchar(10),
	@ptStatus Varchar(1),
	@ptType Varchar(1),
	@FNResult INT OUTPUT 
AS
--------------------------------------
-- Napat
-- Create 08/03/2022
-- Update 17/03/2022 ถ้า Option หมดอายุคิวอาร์ ตั้งค่าเป็น วันที่ ต้อง Convert ให้แสดงเฉพาะวันที่
--------------------------------------
BEGIN TRY
	DECLARE @nLngID int 
	DECLARE @tSql VARCHAR(8000)
	DECLARE @tSQLCond VARCHAR(8000)
	DECLARE @tDocDateF Varchar(10)
	DECLARE @tDocDateT Varchar(10)

	SET @nLngID = @pnLngID
	SET @tDocDateF = @ptDocDateF
	SET @tDocDateT = @ptDocDateT
	SET @FNResult= 0
	SET @tDocDateF = CONVERT(VARCHAR(10),@tDocDateF,121)
	SET @tDocDateT = CONVERT(VARCHAR(10),@tDocDateT,121)

	IF @nLngID = null
	BEGIN
		SET @nLngID = 1
	END	

	IF @tDocDateF = null
	BEGIN 
		SET @tDocDateF = ''
	END

	IF @tDocDateT = null OR @tDocDateT =''
	BEGIN 
		SET @tDocDateT = @tDocDateF
	END

	DELETE FROM TVDTRptRcvInfoTrialPdtVDTmp WITH (ROWLOCK) WHERE FTSessionID =  '' + @ptUsrSession + ''
	
	SET @tSQL =  ' INSERT INTO TVDTRptRcvInfoTrialPdtVDTmp ' 
	SET @tSQL += ' (FTBchCode,FTBchName,FTShpCode,FTShpName,FTMerCode,FTBkpRef1,FDXshDocDate,FTBkpType,FTPdtCode,FTPdtName,FTPosCode,FTPosName,FTBkpRef2,FCBkdQty,FCBkdQtyRcv,FTBkpStatus,FDBkpDate,FDBkpDateExpire,FTSessionID,FTBkpStatusReal) '
	
	SET @tSQL += ' SELECT A.FTBchCode,A.FTBchName,A.FTShpCode,A.FTShpName,A.FTMerCode,A.FTBkpRef1,A.FDXshDocDate,A.FTBkpType,A.FTPdtCode,A.FTPdtName,A.FTPosCode,A.FTPosName,A.FTBkdDocRef,A.FCBkdQty,A.FCBkdQtyRcv,A.FTBkpStatus, '
	SET @tSQL += '   CASE WHEN A.FTSysStaUsrValue = ''1'' THEN CONVERT(VARCHAR,A.FDBkpDate, 120) ELSE CONVERT(VARCHAR(10),A.FDBkpDate, 121) END AS FDBkpDate, '
    SET @tSQL += '   CASE WHEN A.FTSysStaUsrValue = ''1'' THEN CONVERT(VARCHAR,A.FDBkpDateExp, 120) ELSE CONVERT(VARCHAR(10),A.FDBkpDateExp, 121) END AS FDBkpDate, '
	SET @tSQL += '   A.FTSessionID, '
	SET @tSQL += '	 CASE WHEN A.FTSysStaUsrValue = ''1'' THEN '
	SET @tSQL += '	 	CASE '
	SET @tSQL += '	 		WHEN (A.FTBkpStatus = ''1'' AND GETDATE() <= A.FDBkpDateExp) THEN ''1'' ' /* จอง */
	SET @tSQL += '	 		WHEN (A.FTBkpStatus = ''2'' AND GETDATE() > A.FDBkpDateExp) THEN ''5'' ' /* รับบางส่วน แต่หมดอายุ */
	SET @tSQL += '	 		WHEN (A.FTBkpStatus = ''1'' AND GETDATE() > A.FDBkpDateExp) THEN ''5'' ' /* จอง แต่หมดอายุ */
	SET @tSQL += '	 		ELSE A.FTBkpStatus '
	SET @tSQL += '	 	END '
	SET @tSQL += '	 ELSE '
	SET @tSQL += '	 	CASE '
	SET @tSQL += '	 		WHEN (A.FTBkpStatus = ''1'' AND CONVERT(DATE,GETDATE(), 121) <= CONVERT(DATE,A.FDBkpDateExp, 121)) THEN ''1'' ' /* จอง */
	SET @tSQL += '	 		WHEN (A.FTBkpStatus = ''2'' AND CONVERT(DATE,GETDATE(), 121) > CONVERT(DATE,A.FDBkpDateExp, 121)) THEN ''5'' ' /* รับบางส่วน แต่หมดอายุ */
	SET @tSQL += '	 		WHEN (A.FTBkpStatus = ''1'' AND CONVERT(DATE,GETDATE(), 121) > CONVERT(DATE,A.FDBkpDateExp, 121)) THEN ''5'' ' /* จอง แต่หมดอายุ */
	SET @tSQL += '	 		ELSE A.FTBkpStatus '
	SET @tSQL += '	 	END '
	SET @tSQL += '	 END AS FTBkpStatusReal '
	SET @tSQL += ' FROM ( '
	SET @tSQL += ' SELECT '
	SET @tSQL += '	 BKP.FTBchCode,BCHL.FTBchName,SHP.FTShpCode,SHPL.FTShpName,SHP.FTMerCode,BKP.FTBkpRef1,SAL.FDXshDocDate,BKP.FTBkpType, '
	SET @tSQL += '	 BKPDT.FTPdtCode,PDTL.FTPdtName,BKPDT.FTPosCode,POSL.FTPosName,BKPDT.FTBkdDocRef,BKPDT.FCBkdQty,BKPDT.FCBkdQtyRcv,BKP.FTBkpStatus,BKP.FDBkpDate '
	SET @tSQL += '	 ,CASE '
	SET @tSQL += '		 WHEN OPT.FTSysStaUsrValue = ''1'' '
	SET @tSQL += '		 THEN DATEADD(HOUR, OPT.FNValueExpire,BKP.FDBkpDate) '
	SET @tSQL += '		 ELSE DATEADD(DAY, OPT.FNValueExpire,BKP.FDBkpDate) '
	SET @tSQL += '	  END AS FDBkpDateExp '
	SET @tSQL += '   ,''' + @ptUsrSession + ''' AS FTSessionID, OPT.FTSysStaUsrValue '
	SET @tSQL += ' FROM TCNTBookingPrc			 BKP   WITH(NOLOCK) '
	SET @tSQL += ' INNER JOIN TCNTBookingPrcDT   BKPDT WITH(NOLOCK) ON BKP.FTBkpRef1 = BKPDT.FTBkpRef1 AND BKP.FTBkpType = BKPDT.FTBkpType '
	SET @tSQL += ' LEFT JOIN TCNMPdt_L		     PDTL  WITH(NOLOCK) ON BKPDT.FTPdtCode = PDTL.FTPdtCode AND PDTL.FNLngID = ''' + CAST(@nLngID  AS VARCHAR(10)) + ''' '
	SET @tSQL += ' LEFT JOIN TCNMPos_L		     POSL  WITH(NOLOCK) ON BKPDT.FTBchCode = POSL.FTBchCode AND BKPDT.FTPosCode = POSL.FTPosCode AND POSL.FNLngID = ''' + CAST(@nLngID  AS VARCHAR(10)) + ''' '
	SET @tSQL += ' LEFT JOIN TCNMBranch_L		 BCHL  WITH(NOLOCK) ON BKP.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = ''' + CAST(@nLngID  AS VARCHAR(10)) + ''' '
	SET @tSQL += ' INNER JOIN TPSTSalHD		     SAL   WITH(NOLOCK) ON BKP.FTBkpRef1 = SAL.FTXshDocNo '
	SET @tSQL += ' INNER JOIN TVDMPosShop        VSP   WITH(NOLOCK) ON BKP.FTBchCode = VSP.FTBchCode AND BKPDT.FTPosCode = VSP.FTPosCode '
	SET @tSQL += ' INNER JOIN TCNMShop           SHP   WITH(NOLOCK) ON VSP.FTBchCode = SHP.FTBchCode AND VSP.FTShpCode = SHP.FTShpCode '
	SET @tSQL += ' LEFT JOIN TCNMShop_L          SHPL  WITH(NOLOCK) ON SHP.FTBchCode = SHPL.FTBchCode AND SHP.FTShpCode = SHPL.FTShpCode AND SHPL.FNLngID = ''' + CAST(@nLngID  AS VARCHAR(10)) + ''' '
	SET @tSQL += ' LEFT JOIN ( '
	SET @tSQL += '	 SELECT '
	SET @tSQL += '		 FTSysCode,FTSysApp,FTSysKey,FTSysSeq,FTSysStaUsrValue, '
	SET @tSQL += '		 CASE WHEN FTSysStaUsrValue = ''1'' THEN FTSysStaUsrRef ELSE (FTSysStaUsrRef - 1) END AS FNValueExpire '
	SET @tSQL += '	 FROM TSysConfig WITH(NOLOCK) '
	SET @tSQL += '	 WHERE FTSysCode = ''nCN_QRTimeout'' '
	SET @tSQL += ' ) OPT ON OPT.FTSysApp  = ''CN'' AND OPT.FTSysKey = ''QR'' AND OPT.FTSysSeq  = ''1'' '
	SET @tSQL += ' WHERE 1=1 '

	IF (@tDocDateF <> '' AND @tDocDateT <> '')
	BEGIN
		SET @tSQL += ' AND CONVERT(VARCHAR(10),SAL.FDXshDocDate, 121) BETWEEN ''' + @tDocDateF + ''' AND ''' + @tDocDateT + ''' '
	END
	IF (@ptBchL <> '' )
	BEGIN
		SET @tSQL += ' AND BKP.FTBchCode IN (' + @ptBchL + ') '
	END

	IF (@ptMerL <> '')
	BEGIN
		SET @tSQL += ' AND SHP.FTMerCode IN (' + @ptMerL + ') '
	END	

	IF (@ptShpL <> '')
	BEGIN
		SET @tSQL += ' AND SHP.FTShpCode IN (' + @ptShpL + ') '
	END	

	IF (@ptPosL <> '')
	BEGIN
		SET @tSQL += ' AND BKPDT.FTPosCode IN (' + @ptPosL + ')'
	END	

	IF (@ptType <> '')
	BEGIN
		SET @tSQL += ' AND BKP.FTBkpType = ''' + @ptType + ''' '
	END		

	SET @tSQL += ' ) A '
	SET @tSQL += ' WHERE 1=1 '

	IF (@ptStatus <> '' AND @ptStatus = '1')
	BEGIN
		SET @tSQL += ' AND (A.FTBkpStatus = ''1'' AND CASE WHEN A.FTSysStaUsrValue = ''1'' THEN GETDATE() ELSE CONVERT(DATE,GETDATE(),121) END <= CASE WHEN A.FTSysStaUsrValue = ''1'' THEN A.FDBkpDateExp ELSE CONVERT(DATE,A.FDBkpDateExp,121) END) '
	END

	IF (@ptStatus <> '' AND @ptStatus = '2')
	BEGIN
		SET @tSQL += ' AND (A.FTBkpStatus = ''2'' AND CASE WHEN A.FTSysStaUsrValue = ''1'' THEN GETDATE() ELSE CONVERT(DATE,GETDATE(),121) END <= CASE WHEN A.FTSysStaUsrValue = ''1'' THEN A.FDBkpDateExp ELSE CONVERT(DATE,A.FDBkpDateExp,121) END) '
	END

	IF (@ptStatus <> '' AND @ptStatus = '3')
	BEGIN
		SET @tSQL += ' AND A.FTBkpStatus = ''3'' '
	END

	IF (@ptStatus <> '' AND @ptStatus = '4')
	BEGIN
		SET @tSQL += ' AND A.FTBkpStatus = ''4'' '
	END

	IF (@ptStatus <> '' AND @ptStatus = '5')
	BEGIN
		SET @tSQL += ' AND (A.FTBkpStatus IN (''1'',''2'') AND CASE WHEN A.FTSysStaUsrValue = ''1'' THEN GETDATE() ELSE CONVERT(DATE,GETDATE(),121) END > CASE WHEN A.FTSysStaUsrValue = ''1'' THEN A.FDBkpDateExp ELSE CONVERT(DATE,A.FDBkpDateExp,121) END) '
	END
	
	--PRINT @tSQL
	EXECUTE(@tSQL)
	
	--RETURN SELECT * FROM TVDTRptRcvInfoTrialPdtVDTmp WHERE FTSessionID =  '' + @ptUsrSession + ''
	
END TRY

BEGIN CATCH 
	SET @FNResult= -1
END CATCH
GO

--############################################################################################
-- สร้าง		  : 04-04-2022 
-- โดย			 : เจมส์
-- เวอร์ชั่น		: 00.00.07
-- รายงาน - ยอดขายตามแคชเชียร์ (KPC) , รายงาน - ยอดขายสิ้นวัน (KPC)
-- เวอร์ชั่น		: 00.00.08 (08/04/2022)
-- รายงาน - ยอดขายตามแคชเชียร์ (KPC) 
-- แก้ Store เปลี่ยนการดึงชื่อธนารคารเป็น ชื่อบัตรเครดิต
-- เพิ่มเคสดึงข้อมูลบัตรเครดิต กรณีประเภทชำระ เป็นผ่อนชำระ
--รายงาน - ยอดขายสิ้นวัน (KPC)
-- แก้ Store เปลี่ยนการดึงชื่อธนารคารเป็น ชื่อบัตรเครดิต
-- เพิ่มเคสดึงข้อมูลบัตรเครดิต กรณีประเภทชำระ เป็นผ่อนชำระ

IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[SP_RPTxSalDailyKPC]') AND type in (N'P', N'PC'))
	DROP PROCEDURE SP_RPTxSalDailyKPC
GO

SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[SP_RPTxSalDailyKPC]
	@pnLngID int , 
	@pnComName Varchar(100),
	@ptRptCode Varchar(100),
	@ptUsrSession Varchar(255),
	@pnFilterType int, --1 BETWEEN 2 IN
	@ptAppType Varchar(5), -- 
	--สาขา
	@ptBchL Varchar(8000), --กรณี Condition IN
	@ptBchF Varchar(5),
	@ptBchT Varchar(5),
	--Merchant
	@ptMerL Varchar(8000), --กรณี Condition IN
	@ptMerF Varchar(10),
	@ptMerT Varchar(10),
	--Shop Code
	@ptShpL Varchar(8000), --กรณี Condition IN
	@ptShpF Varchar(10),
	@ptShpT Varchar(10),
	--เครื่องจุดขาย
	@ptPosL Varchar(8000), --กรณี Condition IN
	@ptPosF Varchar(20),
	@ptPosT Varchar(20),

	@ptDocDateF Varchar(10),
	@ptDocDateT Varchar(10),

	@FNResult INT OUTPUT 
AS
--------------------------------------
-- Watcharakorn รายงาน - ยอดขายสิ้นวัน
-- Create 28/04/2020
-- Temp name  TRPTSalRCTmp
-- @pnLngID ภาษา
-- @ptRptCdoe ชื่อรายงาน
-- @ptUsrSession UsrSession
-- @ptRcvF จากการชำระเงิน
-- @ptRcvT ถึงการชำระเงิน
-- @ptBchF จากรหัสสาขา
-- @ptBchT ถึงรหัสสาขา
-- @ptShpF จากร้านค้า
-- @ptShpT ถึงร้านค้า
-- @ptDocDateF จากวันที่
-- @ptDocDateT ถึงวันที่
-- @FNResult


--------------------------------------
BEGIN TRY

	DECLARE @nLngID int 
	DECLARE @nComName Varchar(100)
	DECLARE @tRptCode Varchar(100)
	DECLARE @tUsrSession Varchar(255)
	DECLARE @tSql nVARCHAR(Max)
	DECLARE @tSqlIns VARCHAR(8000)
	DECLARE @tSql1 nVARCHAR(Max)
	DECLARE @tSql2 VARCHAR(8000)

	DECLARE @tRcvF Varchar(5)
	DECLARE @tRcvT Varchar(5)

	--Branch Code
	DECLARE @tBchF Varchar(5)
	DECLARE @tBchT Varchar(5)
	--Merchant
	DECLARE @tMerF Varchar(10)
	DECLARE @tMerT Varchar(10)
	--Shop Code
	DECLARE @tShpF Varchar(10)
	DECLARE @tShpT Varchar(10)
	--Pos Code
	DECLARE @tPosF Varchar(20)
	DECLARE @tPosT Varchar(20)


	DECLARE @tDocDateF Varchar(10)
	DECLARE @tDocDateT Varchar(10)
	--ลูกค้า
	--DECLARE @tCstF Varchar(20)
	--DECLARE @tCstT Varchar(20)


	SET @nLngID = @pnLngID
	SET @nComName = @pnComName
	SET @tUsrSession = @ptUsrSession
	SET @tRptCode = @ptRptCode

	--SET @tRcvF = @ptRcvF
	--SET @tRcvT = @ptRcvT

	--Branch
	SET @tBchF  = @ptBchF
	SET @tBchT  = @ptBchT
	--Merchant
	SET @tMerF  = @ptMerF
	SET @tMerT  = @ptMerT
	--Shop
	SET @tShpF  = @ptShpF
	SET @tShpT  = @ptShpT
	--Pos
	SET @tPosF  = @ptPosF 
	SET @tPosT  = @ptPosT

	--SET @tBchF = @ptBchF
	--SET @tBchT = @ptBchT
	--SET @tShpF = @ptShpF
	--SET @tShpT = @ptShpT
	SET @tDocDateF = @ptDocDateF
	SET @tDocDateT = @ptDocDateT
	SET @FNResult= 0

	SET @tDocDateF = CONVERT(VARCHAR(10),@tDocDateF,121)
	SET @tDocDateT = CONVERT(VARCHAR(10),@tDocDateT,121)

	IF @nLngID = null
	BEGIN
		SET @nLngID = 1
	END	
	--Set ค่าให้ Paraleter กรณี T เป็นค่าว่างหรือ null
	IF @tRcvF = null
	BEGIN
		SET @tRcvF = ''
	END
	IF @tRcvT = null OR @tRcvT = ''
	BEGIN
		SET @tRcvT = @tRcvF
	END

	IF @ptBchL = null
	BEGIN
		SET @ptBchL = ''
	END

	IF @tBchF = null
	BEGIN
		SET @tBchF = ''
	END
	IF @tBchT = null OR @tBchT = ''
	BEGIN
		SET @tBchT = @tBchF
	END

	IF @ptMerL =null
	BEGIN
		SET @ptMerL = ''
	END

	IF @tMerF =null
	BEGIN
		SET @tMerF = ''
	END
	IF @tMerT =null OR @tMerT = ''
	BEGIN
		SET @tMerT = @tMerF
	END 

	IF @ptShpL =null
	BEGIN
		SET @ptShpL = ''
	END

	IF @tShpF =null
	BEGIN
		SET @tShpF = ''
	END
	IF @tShpT =null OR @tShpT = ''
	BEGIN
		SET @tShpT = @tShpF
	END

	IF @ptPosL =null
	BEGIN
		SET @ptPosL = ''
	END

	IF @tPosF = null
	BEGIN
		SET @tPosF = ''
	END
	IF @tPosT = null OR @tPosT = ''
	BEGIN
		SET @tPosT = @tPosF
	END

	IF @tDocDateF = null
	BEGIN 
		SET @tDocDateF = ''
	END

	IF @tDocDateT = null OR @tDocDateT =''
	BEGIN 
		SET @tDocDateT = @tDocDateF
	END

	SET @tSql1 =   ' WHERE 1=1 AND HD.FTXshStaDoc = ''1'''

	IF @pnFilterType = '1'
	BEGIN
		IF (@tBchF <> '' AND @tBchT <> '')
		BEGIN
			SET @tSql1 +=' AND HD.FTBchCode BETWEEN ''' + @tBchF + ''' AND ''' + @tBchT + ''''
		END

		IF (@tMerF <> '' AND @tMerT <> '')
		BEGIN
			SET @tSql1 +=' AND Shp.FTMerCode BETWEEN ''' + @tMerF + ''' AND ''' + @tMerT + ''''
		END

		IF (@tShpF <> '' AND @tShpT <> '')
		BEGIN
			SET @tSql1 +=' AND HD.FTShpCode BETWEEN ''' + @tShpF + ''' AND ''' + @tShpT + ''''
		END

		IF (@tPosF <> '' AND @tPosT <> '')
		BEGIN
			SET @tSql1 += ' AND HD.FTPosCode BETWEEN ''' + @tPosF + ''' AND ''' + @tPosT + ''''
		END		
	END

	IF @pnFilterType = '2'
	BEGIN
		IF (@ptBchL <> '' )
		BEGIN
			SET @tSql1 +=' AND HD.FTBchCode IN (' + @ptBchL + ')'
		END

		IF (@ptMerL <> '' )
		BEGIN
			SET @tSql1 +=' AND Shp.FTMerCode IN (' + @ptMerL + ')'
		END

		IF (@ptShpL <> '')
		BEGIN
			SET @tSql1 +=' AND HD.FTShpCode IN (' + @ptShpL + ')'
		END

		IF (@ptPosL <> '')
		BEGIN
			SET @tSql1 += ' AND HD.FTPosCode IN (' + @ptPosL + ')'
		END		
	END

	IF @tRcvF <> '' AND @tRcvT <> ''
	BEGIN 
		SET @tSql1 += ' AND RC.FTRcvCode BETWEEN '''+ @tRcvF + ''' AND '''+ @tRcvT + ''''		
	END



	IF (@tDocDateF <> '' AND @tDocDateT <> '')
	BEGIN
		SET @tSql1 +=' AND CONVERT(VARCHAR(10),FDXshDocDate,121) BETWEEN ''' + @tDocDateF + ''' AND ''' + @tDocDateT + ''''
	END

	DELETE FROM TRPTSalDailyKPCTmp WITH (ROWLOCK) WHERE FTComName =  '' + @nComName + ''  AND FTRptCode = '' + @tRptCode + '' AND FTUsrSession = '' + @tUsrSession + ''--ลบข้อมูล Temp ของเครื่องที่จะบันทึกขอมูลลง Temp
 


	--Sale FNAppType = 1 
	SET @tSql  = ' INSERT INTO TRPTSalDailyKPCTmp '
	SET @tSql +=' ('
	SET @tSql +='  FTComName,FTRptCode,FTUsrSession,'
	SET @tSql +='  FNAppType,FTXihValType,FTRcvName,FCXshGrand,FTRcvCode,FTRcvRefNo1,FTRcvRefNo2,FNRcvUseAmt'
	SET @tSql +=' )'
	SET @tSql +=' SELECT '''+@nComName +''' AS FTComName, ''' + @tRptCode +''' AS FTRptCode,'''+ @tUsrSession+''' AS FTUsrSession,'
	SET @tSql +=' FNAppType,FTXihValType,FTRcvName,FCXshGrand,FTRcvCode,FTRcvRefNo1,FTRcvRefNo2,FNRcvUseAmt'
	SET @tSql +=' FROM('
	SET @tSql +=' SELECT 1 AS FNAppType, ''ยอดขาย'' AS FTRcvName,'
	SET @tSql +=' ''1'' AS FTXihValType,' --1: ยอดขาย ,2: ส่วนลด 3: ปักเศษ 4: ยอดขายรวม 5: ชำระเงิน 6: ยอดขายไม่รวมภาษี 7: ภาษี
	SET @tSql +=' SUM(CASE WHEN  HD.FNXshDocType = ''9'' THEN ISNULL(FCXshTotal,0)*-1 ELSE ISNULL(FCXshTotal,0) END) AS FCXshGrand,'
	SET @tSql +=' '''' AS FTRcvCode, '''' AS FTRcvRefNo1,'''' AS FTRcvRefNo2, COUNT(FTXshDocNo) AS FNRcvUseAmt '
	SET @tSql +=' FROM TPSTSalHD HD'
	SET @tSql +=' LEFT JOIN TCNMShop Shp WITH (NOLOCK) ON HD.FTBchCode = Shp.FTBchCode AND HD.FTShpCode = Shp.FTShpCode'
	SET @tSql += @tSql1	

	SET @tSql +=' UNION ALL'
	SET @tSql +=' SELECT  1 AS FNAppType, ''ส่วนลด'' AS FTRcvName,'
	SET @tSql +=' ''2'' AS FTXihValType,' --1: ยอดขาย ,2: ส่วนลด 3: ปักเศษ 4: ยอดขายรวม 5: ชำระเงิน 6: ยอดขายไม่รวมภาษี 7: ภาษี
	SET @tSql +=' SUM(CASE WHEN  HD.FNXshDocType = ''9'' THEN (ISNULL(FCXshChg,0)-ISNULL(FCXshDis,0)) *-1 ELSE (ISNULL(FCXshChg,0)-ISNULL(FCXshDis,0)) END) AS FCXshGrand,'
	SET @tSql +=' '''' AS FTRcvCode, '''' AS FTRcvRefNo1,'''' AS FTRcvRefNo2, 0 AS FNRcvUseAmt '
	SET @tSql +=' FROM TPSTSalHD HD'
	SET @tSql +=' LEFT JOIN TCNMShop Shp WITH (NOLOCK) ON HD.FTBchCode = Shp.FTBchCode AND HD.FTShpCode = Shp.FTShpCode'
	SET @tSql += @tSql1	

	SET @tSql +=' UNION ALL'
	SET @tSql +=' SELECT  1 AS FNAppType, ''ปักเศษ'' AS FTRcvName,'
	SET @tSql +=' ''3'' AS FTXihValType,' --1: ยอดขาย ,2: ส่วนลด 3: ปักเศษ 4: ยอดขายรวม 5: ชำระเงิน 6: ยอดขายไม่รวมภาษี 7: ภาษี
	SET @tSql +=' SUM(CASE WHEN  HD.FNXshDocType = ''9'' THEN (ISNULL(FCXshRnd,0)) *-1 ELSE (ISNULL(FCXshRnd,0)) END) AS FCXshGrand,'
	SET @tSql +=' '''' AS FTRcvCode, '''' AS FTRcvRefNo1,'''' AS FTRcvRefNo2, 0 AS FNRcvUseAmt '
	SET @tSql +=' FROM TPSTSalHD HD'
	SET @tSql +=' LEFT JOIN TCNMShop Shp WITH (NOLOCK) ON HD.FTBchCode = Shp.FTBchCode AND HD.FTShpCode = Shp.FTShpCode'
	SET @tSql += @tSql1	

	SET @tSql +=' UNION ALL'
	SET @tSql +=' SELECT  1 AS FNAppType, ''ยอดขายรวม'' AS FTRcvName,'
	SET @tSql +=' ''4'' AS FTXihValType,' --1: ยอดขาย ,2: ส่วนลด 3: ปักเศษ 4: ยอดขายรวม 5: ชำระเงิน 6: ยอดขายไม่รวมภาษี 7: ภาษี
	SET @tSql +=' SUM(CASE WHEN  HD.FNXshDocType = ''9'' THEN ISNULL(FCXshGrand,0)*-1 ELSE ISNULL(FCXshGrand,0) END) AS FCXshGrand,'
	SET @tSql +=' '''' AS FTRcvCode, '''' AS FTRcvRefNo1,'''' AS FTRcvRefNo2, 0 AS FNRcvUseAmt '
	SET @tSql +=' FROM TPSTSalHD HD'
	SET @tSql +=' LEFT JOIN TCNMShop Shp WITH (NOLOCK) ON HD.FTBchCode = Shp.FTBchCode AND HD.FTShpCode = Shp.FTShpCode'
	SET @tSql += @tSql1	

	--GROUP BY FTXihValType
	SET @tSql +=' UNION ALL' --1: ยอดขาย ,2: ส่วนลด 3: ปักเศษ 4: ยอดขายรวม 5: ชำระเงิน 6: ยอดขายไม่รวมภาษี 7: ภาษี
	SET @tSql +=' SELECT 1 AS FNAppType, ISNULL(Rcv_L.FTRcvName, RC.FTRcvName) AS FTRcvName,''5'' AS FTXihValType,'
	SET @tSql +=' SUM(CASE WHEN  HD.FNXshDocType = ''9'' THEN RC.FCXrcNet*-1 ELSE RC.FCXrcNet END) AS FCXshGrand,'
	SET @tSql +=' '''' AS FTRcvCode, '''' AS FTRcvRefNo1,'''' AS FTRcvRefNo2, COUNT(RC.FTRcvCode) AS FNRcvUseAmt '
	SET @tSql +=' FROM (TPSTSalHD HD INNER JOIN TPSTSalRC RC ON HD.FTXshDocNo = RC.FTXshDocNo) '
	SET @tSql +=' LEFT OUTER JOIN TFNMRcv Rcv WITH(NOLOCK) ON RC.FTRcvCode = Rcv.FTRcvCode '
	SET @tSql +=' LEFT JOIN TFNMRcv_L Rcv_L WITH(NOLOCK) ON Rcv.FTRcvCode = Rcv_L.FTRcvCode AND Rcv_L.FNLngID = ''' + CAST(@nLngID  AS VARCHAR(10)) + '''' 
	--SET @tSql +=' LEFT JOIN TFNMCreditCard CRD WITH(NOLOCK) ON CRD.FTBnkCode = RC.FTBnkCode '
	--SET @tSql +=' LEFT JOIN TFNMCreditCard_L CRDL WITH(NOLOCK) ON CRDL.FTCrdCode = CRD.FTCrdCode AND CRDL.FNLngID = ''' + CAST(@nLngID  AS VARCHAR(10)) + '''' 
	--SET @tSql +=' LEFT JOIN TFNMBank_L Bnk_L WITH(NOLOCK) ON RC.FTBnkCode = Bnk_L.FTBnkCode AND Bnk_L.FNLngID = ''' + CAST(@nLngID  AS VARCHAR(10)) + '''' 
	SET @tSql +=' LEFT JOIN TCNMCst Cst WITH(NOLOCK) ON HD.FTCstCode = Cst.FTCstCode'
	SET @tSql +=' LEFT JOIN TCNMShop Shp  WITH (NOLOCK) ON HD.FTBchCode = Shp.FTBchCode AND HD.FTShpCode = Shp.FTShpCode'
	SET @tSql += @tSql1	
	SET @tSql += ' GROUP BY ISNULL(Rcv_L.FTRcvName, RC.FTRcvName)'


	SET @tSql +=' UNION ALL'
	SET @tSql +=' SELECT  1 AS FNAppType, ''ยอดขายไม่รวมภาษี'' AS FTRcvName,'
	SET @tSql +=' ''6'' AS FTXihValType,' --1: ยอดขาย ,2: ส่วนลด 3: ปักเศษ 4: ยอดขายรวม 5: ชำระเงิน 6: ยอดขายไม่รวมภาษี 7: ภาษี
	SET @tSql +=' SUM(CASE WHEN  HD.FNXshDocType = ''9'' THEN (ISNULL(FCXshVatable,0)) *-1 ELSE (ISNULL(FCXshVatable,0)) END) AS FCXshVatable,'
	SET @tSql +=' '''' AS FTRcvCode, '''' AS FTRcvRefNo1,'''' AS FTRcvRefNo2, 0 AS FNRcvUseAmt '
	SET @tSql +=' FROM TPSTSalHD HD'
	SET @tSql +=' LEFT JOIN TCNMShop Shp WITH (NOLOCK) ON HD.FTBchCode = Shp.FTBchCode AND HD.FTShpCode = Shp.FTShpCode'
	SET @tSql += @tSql1	

	SET @tSql +=' UNION ALL'
	SET @tSql +=' SELECT  1 AS FNAppType, ''ภาษี'' AS FTRcvName,'
	SET @tSql +=' ''7'' AS FTXihValType,' --1: ยอดขาย ,2: ส่วนลด 3: ปักเศษ 4: ยอดขายรวม 5: ชำระเงิน 6: ยอดขายไม่รวมภาษี 7: ภาษี
	SET @tSql +=' SUM(CASE WHEN  HD.FNXshDocType = ''9'' THEN ISNULL(FCXshVat,0)*-1 ELSE ISNULL(FCXshVat,0) END) AS FCXshVat,'
	SET @tSql +=' '''' AS FTRcvCode, '''' AS FTRcvRefNo1,'''' AS FTRcvRefNo2, 0 AS FNRcvUseAmt '
	SET @tSql +=' FROM TPSTSalHD HD'
	SET @tSql +=' LEFT JOIN TCNMShop Shp WITH (NOLOCK) ON HD.FTBchCode = Shp.FTBchCode AND HD.FTShpCode = Shp.FTShpCode'
	SET @tSql += @tSql1	

	--FTXihValType Type 5 หาตัวลูกของ บัตรเครดิต
	SET @tSql +=' UNION ALL'
	SET @tSql +=' SELECT  1 AS FNAppType, ISNULL(Rcv_L.FTRcvName, RC.FTRcvName) AS FTRcvName,'
	SET @tSql +=' ''5'' AS FTXihValType,' 
	SET @tSql +='  SUM(FCXrcNet) AS FCXshGrand,ISNULL(Rcv_L.FTRcvCode, RC.FTRcvCode) AS FTRcvCode, ISNULL(CRD.FTCrdCode,''N/A'') AS FTRcvRefNo1,ISNULL(CRDL.FTCrdName,''N/A'') AS FTRcvRefNo2,COUNT(RC.FTBnkCode) AS FNRcvUseAmt'
	SET @tSql +=' FROM TPSTSalRC RC WITH(NOLOCK) '
	SET @tSql +=' INNER JOIN TPSTSalHD HD WITH(NOLOCK) ON HD.FTXshDocNo = RC.FTXshDocNo '
	SET @tSql +='  LEFT OUTER JOIN TFNMRcv Rcv WITH(NOLOCK) ON RC.FTRcvCode = Rcv.FTRcvCode '
	SET @tSql +=' LEFT JOIN TFNMRcv_L Rcv_L WITH(NOLOCK) ON Rcv.FTRcvCode = Rcv_L.FTRcvCode AND Rcv_L.FNLngID = ''' + CAST(@nLngID  AS VARCHAR(10)) + '''' 
	--SET @tSql +=' LEFT JOIN TFNMBank_L Bnk_L ON RC.FTBnkCode = Bnk_L.FTBnkCode AND Bnk_L.FNLngID = 1 '
	SET @tSql +=' LEFT JOIN TFNMCreditCard CRD WITH(NOLOCK) ON CRD.FTBnkCode = RC.FTBnkCode '
	SET @tSql +=' LEFT JOIN TFNMCreditCard_L CRDL WITH(NOLOCK) ON CRDL.FTCrdCode = CRD.FTCrdCode AND CRDL.FNLngID = ''' + CAST(@nLngID  AS VARCHAR(10)) + '''' 
	SET @tSql += @tSql1	
	SET @tSql +=' AND RCV.FTFmtCode IN (''002'',''009'') AND ISNULL(RC.FTBnkCode,'''') != '''' '
	--SET @tSql +=' AND CONVERT(VARCHAR(10),FDXrcRefDate,121) BETWEEN ''' + @tDocDateF + ''' AND ''' + @tDocDateT + ''''
	SET @tSql +=' GROUP BY  ISNULL(Rcv_L.FTRcvName, RC.FTRcvName),ISNULL(Rcv_L.FTRcvCode, RC.FTRcvCode),CRD.FTCrdCode,CRDL.FTCrdName '

	SET @tSql += ' ) Sale'
	
	SELECT @tSql
	EXECUTE(@tSql)
	  
	SET @tSql2  = ' INSERT INTO TRPTSalDailyKPCTmp '
	SET @tSql2 +=' ('
	SET @tSql2 +='  FTComName,FTRptCode,FTUsrSession,'
	SET @tSql2 +='  FTXihChkType,FNAppType,FTXihValType,FTRcvName,FCXshGrand,FTRcvCode,FTRcvRefNo1,FTRcvRefNo2,FNRcvUseAmt'
	SET @tSql2 +=' )'
	SET @tSql2 +=' SELECT '''+@nComName +''' AS FTComName, ''' + @tRptCode +''' AS FTRptCode,'''+ @tUsrSession+''' AS FTUsrSession,'
	SET @tSql2 +=' ''1'' AS FTXihChkType,'''+ @ptAppType + ''' AS FNAppType,FTXihValType,FTRcvName,'
	
	SET @tSql2 +=' SUM(FCXshGrand) AS FCXshGrand,FTRcvCode,FTRcvRefNo1,FTRcvRefNo2,COUNT(FNRcvUseAmt) AS FNRcvUseAmt'  
	SET @tSql2 +=' FROM TRPTSalDailyKPCTmp' --WHERE FNAppType
	SET @tSql2 +=' WHERE 1=1'
	IF @ptAppType <> '0'
	BEGIN
		SET @tSql2 +=' AND FNAppType = ''' + @ptAppType + ''''
	END
	SET @tSql2 +=' AND FTComName =  ''' + @nComName + '''  AND FTRptCode = ''' + @tRptCode + ''' AND FTUsrSession = ''' + @tUsrSession + ''' AND ISNULL(FTXihChkType,'''') = '''''
	SET @tSql2 +=' GROUP BY FTXihValType,FTRcvName'
	
	--PRINT @tSql2
	EXECUTE(@tSql2)
	--SET @tSql +=' ORDER BY FTXihValType
	

	DELETE TRPTSalDailyKPCTmp WHERE FTComName =  '' + @nComName + ''  AND FTRptCode = '' + @tRptCode + '' AND FTUsrSession = '' + @tUsrSession + '' AND ISNULL(FTXihChkType,'') = ''

	RETURN SELECT * FROM TRPTSalDailyKPCTmp WHERE FTComName = ''+ @nComName + '' AND FTRptCode = ''+ @tRptCode +'' AND FTUsrSession = '' + @tUsrSession + '' ORDER BY FNAppType
	
END TRY

BEGIN CATCH 
 SET @FNResult= -1
END CATCH
GO

IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[SP_RPTxSalDailyByCashierKPC]') AND type in (N'P', N'PC'))
	DROP PROCEDURE SP_RPTxSalDailyByCashierKPC
GO

SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[SP_RPTxSalDailyByCashierKPC]
	@pnLngID int , 
	@pnComName Varchar(100),
	@ptRptCode Varchar(100),
	@ptUsrSession Varchar(255),
	@pnFilterType int, --1 BETWEEN 2 IN
--สาขา
	@ptBchL Varchar(8000), --สาขา Condition IN
	@ptBchF Varchar(5),
	@ptBchT Varchar(5),

--Shop
	@ptShpL Varchar(8000), --ร้สนค้า Condition IN
	@ptShpF Varchar(5),
	@ptShpT Varchar(5),

--Pos
	@ptPosL Varchar(8000), --เครื่องขาย Condition IN
	@ptPosF Varchar(10),
	@ptPosT Varchar(10),
	  
--Cashier
	@ptUsrL Varchar(8000), --Cashier Condition IN
	@ptUsrF Varchar(10),
	@ptUsrT Varchar(10),

	@ptDocDateF Varchar(10),
	@ptDocDateT Varchar(10),

	@FNResult INT OUTPUT 
AS
--------------------------------------
-- Watcharakorn 
-- Create 11/03/2020
--รายงานยอดขาย - ตามแคชเชียร์
-- Temp name  TRPTMnyShotOverTmp_Moshi

--------------------------------------
BEGIN TRY	
	DECLARE @nLngID int 
	DECLARE @nComName Varchar(100)
	DECLARE @tRptCode Varchar(100)
	DECLARE @tUsrSession Varchar(255)
	DECLARE @tSql VARCHAR(Max)
	DECLARE @tSql1 VARCHAR(Max)
	DECLARE @tSqlHD VARCHAR(Max)

	--Branch Code
	DECLARE @tBchF Varchar(5)
	DECLARE @tBchT Varchar(5)
	--Cashier
	DECLARE @tUsrF Varchar(10)
	DECLARE @tUsrT Varchar(10)
	--Pos Code
	DECLARE @tPosF Varchar(20)
	DECLARE @tPosT Varchar(20)

	DECLARE @tDocDateF Varchar(10)
	DECLARE @tDocDateT Varchar(10)

	SET @nLngID = @pnLngID
	SET @nComName = @pnComName
	SET @tUsrSession = @ptUsrSession
	SET @tRptCode = @ptRptCode

	--Branch
	SET @tBchF  = @ptBchF
	SET @tBchT  = @ptBchT
	--Pos
	SET @tPosF  = @ptPosF
	SET @tPosT  = @ptPosT
	--Cashier
	SET @tUsrF  = @ptUsrF
	SET @tUsrT  = @ptUsrT

	SET @tDocDateF = @ptDocDateF
	SET @tDocDateT = @ptDocDateT
	SET @FNResult= 0

	SET @tDocDateF = CONVERT(VARCHAR(10),@tDocDateF,121)
	SET @tDocDateT = CONVERT(VARCHAR(10),@tDocDateT,121)

	IF @nLngID = null
	BEGIN
		SET @nLngID = 1
	END	

	IF @ptBchL = null
	BEGIN
		SET @ptBchL = ''
	END

	IF @tBchF = null
	BEGIN
		SET @tBchF = ''
	END
	IF @tBchT = null OR @tBchT = ''
	BEGIN
		SET @tBchT = @tBchF
	END

	IF @ptShpL = null
	BEGIN
		SET @ptShpL = ''
	END

	IF @ptShpF = null
	BEGIN
		SET @ptShpF = ''
	END
	IF @ptShpT = null OR @ptShpT = ''
	BEGIN
		SET @ptShpT = @ptShpF
	END


	IF @ptPosL =null
	BEGIN
		SET @ptPosL = ''
	END

	IF @tPosF =null
	BEGIN
		SET @tPosF = ''
	END
	IF @tPosT =null OR @tPosT = ''
	BEGIN
		SET @tPosT = @tPosF
	END 

	IF @ptUsrL =null
	BEGIN
		SET @ptUsrL = ''
	END

	IF @tUsrF =null
	BEGIN
		SET @tUsrF = ''
	END
	IF @tUsrT =null OR @tUsrT = ''
	BEGIN
		SET @tUsrT = @tUsrF
	END

	IF @tDocDateF = null
	BEGIN 
		SET @tDocDateF = ''
	END

	IF @tDocDateT = null OR @tDocDateT =''
	BEGIN 
		SET @tDocDateT = @tDocDateF
	END
	
		
	SET @tSql1 =   ' WHERE 1=1 '
	SET @tSqlHD =   ' WHERE 1=1 '

	IF @pnFilterType = '1'
	BEGIN
		IF (@tBchF <> '' AND @tBchT <> '')
		BEGIN
			SET @tSql1 +=' AND FTBchCode BETWEEN ''' + @tBchF + ''' AND ''' + @tBchT + ''''
			SET @tSqlHD +=' AND HD.FTBchCode BETWEEN ''' + @tBchF + ''' AND ''' + @tBchT + ''''
		END

		IF (@ptShpF <> '' AND @ptShpT <> '')
		BEGIN
			SET @tSql1 +=' AND FTShpCode BETWEEN ''' + @ptShpF + ''' AND ''' + @ptShpT + ''''
			SET @tSqlHD +=' AND HD.FTShpCode BETWEEN ''' + @ptShpF + ''' AND ''' + @ptShpT + ''''
		END


		IF (@tPosF <> '' AND @tPosT <> '')
		BEGIN
			SET @tSql1 +=' AND FTPosCode BETWEEN ''' + @tPosF + ''' AND ''' + @tPosT + ''''
			SET @tSqlHD +=' AND HD.FTPosCode BETWEEN ''' + @tPosF + ''' AND ''' + @tPosT + ''''
		END

		IF (@tUsrF <> '' AND @tUsrT <> '')
		BEGIN
			SET @tSql1 +=' AND FTUsrCode BETWEEN ''' + @tUsrF + ''' AND ''' + @tUsrT + ''''
			SET @tSqlHD +=' AND HD.FTUsrCode BETWEEN ''' + @tUsrF + ''' AND ''' + @tUsrT + ''''
		END

		--IF (@tPosF <> '' AND @tPosT <> '')
		--BEGIN
		--	SET @tSql1 += ' AND HD.FTUsrCode BETWEEN ''' + @tPosF + ''' AND ''' + @tPosT + ''''
		--END		


	END

	IF @pnFilterType = '2'
	BEGIN
		IF (@ptBchL <> '' )
		BEGIN
			SET @tSql1 +=' AND FTBchCode IN (' + @ptBchL + ')'
			SET @tSqlHD +=' AND HD.FTBchCode IN (' + @ptBchL + ')'
		END

		IF (@ptShpL <> '' )
		BEGIN
			SET @tSql1 +=' AND FTShpCode IN (' + @ptShpL + ')'
			SET @tSqlHD +=' AND HD.FTShpCode IN (' + @ptShpL + ')'
		END

		IF (@ptPosL <> '' )
		BEGIN
			SET @tSql1 +=' AND FTPosCode IN (' + @ptPosL + ')'
			SET @tSqlHD +=' AND HD.FTPosCode IN (' + @ptPosL + ')'
		END

		IF (@tUsrF <> '' AND @tUsrT <> '')
		BEGIN
			SET @tSql1 +=' AND FTUsrCode BETWEEN ''' + @tUsrF + ''' AND ''' + @tUsrT + ''''
			SET @tSqlHD +=' AND HD.FTUsrCode BETWEEN ''' + @tUsrF + ''' AND ''' + @tUsrT + ''''
		END

		--IF (@ptPosL <> '')
		--BEGIN
		--	SET @tSql1 += ' AND HD.FTUsrCode IN (' + @ptPosL + ')'
		--END		
	END

	IF (@tDocDateF <> '' AND @tDocDateT <> '')
	BEGIN
    	SET @tSql1 +=' AND CONVERT(VARCHAR(10),FDXshDocDate,121) BETWEEN ''' + @tDocDateF + ''' AND ''' + @tDocDateT + ''''
		SET @tSqlHD +=' AND CONVERT(VARCHAR(10),HD.FDXshDocDate,121) BETWEEN ''' + @tDocDateF + ''' AND ''' + @tDocDateT + ''''
	END
	--PRINT '99999'
	DELETE FROM TRPTSalDailyByCashierKPCTmp  WHERE FTComName =  '' + @nComName + ''  AND FTRptCode = '' + @tRptCode + '' AND FTUsrSession = '' + @tUsrSession + ''--Åº¢éÍÁÙÅ Temp ¢Í§à¤Ã×èÍ§·Õè¨ÐºÑ¹·Ö¡¢ÍÁÙÅÅ§ Temp

	SET @tSql = 'INSERT INTO TRPTSalDailyByCashierKPCTmp'
	--PRINT @tSql
	SET @tSql +=' (FTComName,FTRptCode,FTUsrSession'
	 SET @tSql +=' ,FTTnsType,FTRcvCode,FTRcvName,FTBchCode,FTUsrCode,FTUsrName,FCXshNet,FCXshReturn,FCXshRnd,FCXshGrand,FTRcvRefType,FNRcvUseAmt,FTRcvRefNo1,FTRcvRefNo2'
	SET @tSql +=' )'
	--PRINT @tSql
	SET @tSql +=' SELECT '''+ @nComName + ''' AS FTComName,'''+ @tRptCode +''' AS FTRptCode, '''+ @tUsrSession +''' AS FTUsrSession,'
	SET @tSql +=' ''1'' AS FTTnsType  ,'''' AS FTRcvCode,'''' AS FTRcvName, '''' AS  FTBchCode,HD.FTUsrCode,UsrL.FTUsrName,'
	SET @tSql +=' SUM(CASE WHEN FNXshDocType = 1 THEN (ISNULL(FCXshGrand,0) - ISNULL(FCXshRnd,0)) ELSE 0 END) AS FCXshNet,'
	SET @tSql +=' SUM(CASE WHEN FNXshDocType = 9 THEN (ISNULL(FCXshGrand,0) - ISNULL(FCXshRnd,0)) ELSE 0 END) AS FCXshReturn,'
	SET @tSql +=' SUM(CASE WHEN FNXshDocType = 1 THEN ISNULL(FCXshRnd,0) ELSE ISNULL(FCXshRnd,0) *-1 END) AS FCXshRnd,'
	SET @tSql +=' SUM(CASE WHEN FNXshDocType = 1 THEN ISNULL(FCXshGrand,0) ELSE ISNULL(FCXshGrand,0) *-1 END) AS FCXshGrand,'
	 	SET @tSql +=' '''' AS FTRcvRefType,
			  COUNT(HD.FTXshDocNo) AS FNRcvUseAmt,
			 '''' AS FTRcvRefNo1,
			   '''' AS FTRcvRefNo2'
	SET @tSql +=' FROM TPSTSalHD HD WITH(NOLOCK)'
	SET @tSql +=' LEFT JOIN TCNMUser_L UsrL WITH(NOLOCK) ON HD.FTUsrCode = UsrL.FTUsrCode AND UsrL.FNLngID = ''' + CAST(@nLngID  AS VARCHAR(10)) + ''''  
	SET @tSql += @tSqlHD
	SET @tSql +=' GROUP BY HD.FTUsrCode,UsrL.FTUsrName'
	--PRINT @tSql
	SET @tSql +=' UNION' 
	SET @tSql +=' SELECT '''+ @nComName + ''' AS FTComName,'''+ @tRptCode +''' AS FTRptCode, '''+ @tUsrSession +''' AS FTUsrSession,'
	SET @tSql +=' ISNULL(FTTnsType,''2'') AS FTTnsType , Rcv.FTRcvCode,RcvFL.FTRcvName AS FTRcvName,'''' AS FTBchCode,SaleMst.FTUsrCode,SaleMst.FTUsrName,'
	SET @tSql +=' SUM(ISNULL(FCXshNet,0)) AS FCXshNet,'
	SET @tSql +=' SUM(ISNULL(FCXshReturn,0)) AS FCXshReturn,'
	SET @tSql +=' SUM(ISNULL(FCXshRnd,0)) AS FCXshRnd,'
	SET @tSql +=' SUM(ISNULL(FCXshGrand,0)) AS FCXshGrand,'
		SET @tSql +=' '''' AS FTRcvRefType,
			   Sale.FNRcvUseAmt,  
			 '''' AS FTRcvRefNo1,
			   '''' AS FTRcvRefNo2'
	SET @tSql +=' FROM TFNMRcv Rcv  WITH(NOLOCK)'
	SET @tSql +=' LEFT JOIN TFNMRcv_L RcvFL WITH(NOLOCK) ON Rcv.FTRcvCode = RcvFL.FTRcvCode AND RcvFL.FNLngID = ''' + CAST(@nLngID  AS VARCHAR(10)) + ''''
	SET @tSql +=' INNER JOIN' --05-03-2021
	SET @tSql +=' (SELECT DISTINCT HD.FTBchCode,HD.FTUsrCode,FTUsrName'
	SET @tSql +=' FROM TPSTSalHD HD WITH(NOLOCK)'
	SET @tSql +=' INNER JOIN TPSTSalRC RC WITH(NOLOCK) ON HD.FTBchCode = RC.FTBchCode AND HD.FTXshDocNo = RC.FTXshDocNo'
	SET @tSql +=' LEFT JOIN TCNMUser_L UsrL WITH(NOLOCK) ON HD.FTUsrCode = UsrL.FTUsrCode AND UsrL.FNLngID = ''' + CAST(@nLngID  AS VARCHAR(10)) + ''''
	SET @tSql += @tSqlHD
	--1 Where
	SET @tSql +=' ) SaleMst' 
	SET @tSql +=' CROSS JOIN'
		SET @tSql +=' (SELECT ''2'' AS FTTnsType  ,RC.FTRcvCode,RcvFL.FTRcvName AS FTRcvName, HD.FTBchCode,HD.FTUsrCode,UsrL.FTUsrName'
			SET @tSql +=' ,SUM(CASE WHEN FNXshDocType = 1 THEN (ISNULL(FCXrcNet,0)) ELSE 0 END) AS FCXshNet'
			SET @tSql +=' ,SUM(CASE WHEN FNXshDocType = 9 THEN (ISNULL(FCXrcNet,0)) ELSE 0 END) AS FCXshReturn'
			SET @tSql +=' ,SUM(0) AS FCXshRnd'
			SET @tSql +=' ,SUM(CASE WHEN FNXshDocType = 1 THEN ISNULL(FCXrcNet,0) ELSE ISNULL(FCXrcNet,0) *-1 END) AS FCXshGrand, SALRC.FNRcvUseAmt'
			SET @tSql +=' FROM TPSTSalHD HD WITH(NOLOCK)'
			SET @tSql +=' INNER JOIN TPSTSalRC RC WITH(NOLOCK) ON HD.FTBchCode = RC.FTBchCode AND HD.FTXshDocNo = RC.FTXshDocNo'
			SET @tSql +=' LEFT JOIN TFNMRcv Rcv WITH(NOLOCK) ON RC.FTRcvCode = Rcv.FTRcvCode'
			SET @tSql +=' LEFT JOIN TFNMRcv_L RcvFL WITH(NOLOCK) ON Rcv.FTRcvCode = RcvFL.FTRcvCode AND RcvFL.FNLngID = ''' + CAST(@nLngID  AS VARCHAR(10)) + ''''
			SET @tSql +=' LEFT JOIN TCNMUser_L UsrL WITH(NOLOCK) ON HD.FTUsrCode = UsrL.FTUsrCode AND UsrL.FNLngID = ''' + CAST(@nLngID  AS VARCHAR(10)) + '''' 
			SET @tSql +=' LEFT JOIN'
					  SET @tSql +=' (SELECT FTBchCode,FTXshDocNo, CASE WHEN FNXshDocType = 1 THEN ISNULL(FCXshRnd,0) ELSE ISNULL(FCXshRnd,0) *-1 END AS FCXshRnd'
					   SET @tSql +=' FROM TPSTSalHD  WITH(NOLOCK)' 
					   SET @tSql += @tSql1
					   --GROUP BY FTBchCode,FTXshDocNo  
					   --2 Where
					  SET @tSql +=' ) HDRnd ON RC.FTBchCode = HDRnd.FTBchCode AND RC.FTXshDocNo = HDRnd.FTXshDocNo'
					  SET @tSql +=' LEFT JOIN ( SELECT RC.FTRcvCode,COUNT(RC.FTRcvCode) AS FNRcvUseAmt,HD.FTUsrCode  FROM TPSTSalHD HD WITH(NOLOCK)
                                    INNER JOIN TPSTSalRC RC WITH(NOLOCK) ON HD.FTXshDocNo = RC.FTXshDocNo AND HD.FTBchCode = RC.FTBchCode'
                       SET @tSql += @tSql1
                     SET @tSql += ' GROUP BY RC.FTRcvCode,HD.FTUsrCode ) SALRC ON RC.FTRcvCode = SALRC.FTRcvCode AND HD.FTUsrCode = SALRC.FTUsrCode '
			SET @tSql += @tSqlHD
			--3 Where
			SET @tSql +=' GROUP BY RC.FTRcvCode,RcvFL.FTRcvName , HD.FTBchCode,HD.FTUsrCode,UsrL.FTUsrName,SALRC.FNRcvUseAmt'
		SET @tSql +=' ) Sale ON Rcv.FTRcvCode = Sale.FTRcvCode AND SaleMst.FTBchCode = Sale.FTBchCode AND SaleMst.FTUsrCode = Sale.FTUsrCode'
		SET @tSql +=' GROUP BY  ISNULL(FTTnsType, ''2''), Rcv.FTRcvCode, RcvFL.FTRcvName,SaleMst.FTUsrCode, SaleMst.FTUsrName,Sale.FNRcvUseAmt' 





		SET @tSql +=' UNION'
			SET @tSql +=' SELECT '''+ @nComName + ''' AS FTComName,'''+ @tRptCode +''' AS FTRptCode, '''+ @tUsrSession +''' AS FTUsrSession,'
	SET @tSql +=' ISNULL(FTTnsType,''2'') AS FTTnsType , Rcv.FTRcvCode,RcvFL.FTRcvName AS FTRcvName,'''' AS FTBchCode,SaleMst.FTUsrCode,SaleMst.FTUsrName,'
	SET @tSql +=' SUM(ISNULL(FCXshNet,0)) AS FCXshNet,'
	SET @tSql +=' SUM(ISNULL(FCXshReturn,0)) AS FCXshReturn,'
	SET @tSql +=' SUM(ISNULL(FCXshRnd,0)) AS FCXshRnd,'
	SET @tSql +=' SUM(ISNULL(FCXshGrand,0)) AS FCXshGrand,'
	  SET @tSql +='CASE 
			  WHEN Rcv.FTFmtCode IN (''002'',''009'') THEN ''1''
			  WHEN Rcv.FTFmtCode = ''004'' THEN ''2''
			  END AS FTRcvRefType,
			  Sale.FNRcvUseAmt,
			  Sale.FTRcvRefNo1,
			   Sale.FTRcvRefNo2'
	SET @tSql +=' FROM TFNMRcv Rcv  WITH(NOLOCK)'
	SET @tSql +=' LEFT JOIN TFNMRcv_L RcvFL WITH(NOLOCK) ON Rcv.FTRcvCode = RcvFL.FTRcvCode AND RcvFL.FNLngID = ''' + CAST(@nLngID  AS VARCHAR(10)) + ''''
	SET @tSql +=' INNER JOIN' --05-03-2021
	SET @tSql +=' (SELECT DISTINCT HD.FTBchCode,HD.FTUsrCode,FTUsrName'
	SET @tSql +=' FROM TPSTSalHD HD WITH(NOLOCK)'
	SET @tSql +=' INNER JOIN TPSTSalRC RC WITH(NOLOCK) ON HD.FTBchCode = RC.FTBchCode AND HD.FTXshDocNo = RC.FTXshDocNo'
	SET @tSql +=' LEFT JOIN TFNMRcv Rcv WITH(NOLOCK) ON RC.FTRcvCode = Rcv.FTRcvCode'
	SET @tSql +=' LEFT JOIN TCNMUser_L UsrL WITH(NOLOCK) ON HD.FTUsrCode = UsrL.FTUsrCode AND UsrL.FNLngID = ''' + CAST(@nLngID  AS VARCHAR(10)) + ''''
	SET @tSql += @tSqlHD
	SET @tSql += ' AND ((Rcv.FTFmtCode IN (''002'',''009'')  AND ISNULL(RC.FTBnkCode,'''') != '''') OR (Rcv.FTFmtCode = ''004''))'
	--1 Where
	SET @tSql +=' ) SaleMst' 
	SET @tSql +=' CROSS JOIN'
		SET @tSql +=' (SELECT ''2'' AS FTTnsType  ,RC.FTRcvCode,RcvFL.FTRcvName AS FTRcvName, HD.FTBchCode,HD.FTUsrCode,UsrL.FTUsrName'
			SET @tSql +=' ,SUM(CASE WHEN FNXshDocType = 1 THEN (ISNULL(FCXrcNet,0)) ELSE 0 END) AS FCXshNet'
			SET @tSql +=' ,SUM(CASE WHEN FNXshDocType = 9 THEN (ISNULL(FCXrcNet,0)) ELSE 0 END) AS FCXshReturn'
			SET @tSql +=' ,SUM(0) AS FCXshRnd'
			SET @tSql +=' ,SUM(CASE WHEN FNXshDocType = 1 THEN ISNULL(FCXrcNet,0) ELSE ISNULL(FCXrcNet,0) *-1 END) AS FCXshGrand,'
			  SET @tSql +=' SALRC.FNRcvUseAmt,
					  CASE 
					  WHEN Rcv.FTFmtCode IN (''002'',''009'') THEN ISNULL(CRD.FTCrdCode,''N/A'') 
					  WHEN  Rcv.FTFmtCode = ''004'' THEN RC.FTXrcRefNo1
					  END AS FTRcvRefNo1,
                      CASE 
					  WHEN Rcv.FTFmtCode IN (''002'',''009'') THEN ISNULL(CRDL.FTCrdName,''N/A'')  
					  WHEN Rcv.FTFmtCode = ''004'' THEN RC.FTXrcRefDesc 
					  END AS FTRcvRefNo2'
			SET @tSql +=' FROM TPSTSalHD HD WITH(NOLOCK)'
			SET @tSql +=' INNER JOIN TPSTSalRC RC WITH(NOLOCK) ON HD.FTBchCode = RC.FTBchCode AND HD.FTXshDocNo = RC.FTXshDocNo'
			SET @tSql +=' LEFT JOIN TFNMRcv Rcv WITH(NOLOCK) ON RC.FTRcvCode = Rcv.FTRcvCode'
			SET @tSql +=' LEFT JOIN TFNMRcv_L RcvFL WITH(NOLOCK) ON Rcv.FTRcvCode = RcvFL.FTRcvCode AND RcvFL.FNLngID = ''' + CAST(@nLngID  AS VARCHAR(10)) + ''''
			SET @tSql +=' LEFT JOIN TCNMUser_L UsrL WITH(NOLOCK) ON HD.FTUsrCode = UsrL.FTUsrCode AND UsrL.FNLngID = ''' + CAST(@nLngID  AS VARCHAR(10)) + '''' 
			SET @tSql +=' LEFT JOIN TFNMCreditCard CRD WITH(NOLOCK) ON CRD.FTBnkCode = RC.FTBnkCode '
			SET @tSql +=' LEFT JOIN TFNMCreditCard_L CRDL WITH(NOLOCK) ON CRDL.FTCrdCode = CRD.FTCrdCode AND CRDL.FNLngID = ''' + CAST(@nLngID  AS VARCHAR(10)) + '''' 
			SET @tSql +=' LEFT JOIN'
				SET @tSql +=' ( SELECT FTBchCode,FTXshDocNo, CASE WHEN FNXshDocType = 1 THEN ISNULL(FCXshRnd,0) ELSE ISNULL(FCXshRnd,0) *-1 END AS FCXshRnd'
				SET @tSql +=' FROM TPSTSalHD  WITH(NOLOCK)' 
				SET @tSql += @tSql1
				--GROUP BY FTBchCode,FTXshDocNo  
				--2 Where
				SET @tSql +=' ) HDRnd ON RC.FTBchCode = HDRnd.FTBchCode AND RC.FTXshDocNo = HDRnd.FTXshDocNo'
				SET @tSql +=' LEFT JOIN ( SELECT HD.FTUsrCode,RC.FTRcvCode,RC.FTBnkCode,RC.FTXrcRefDesc,COUNT(FTRcvCode) AS FNRcvUseAmt' 
				SET @tSql +=' FROM TPSTSalHD HD WITH(NOLOCK) INNER JOIN TPSTSalRC RC ON HD.FTXshDocNo = RC.FTXshDocNo'
				SET @tSql += @tSql1
				SET @tSql +=' GROUP BY HD.FTUsrCode,RC.FTRcvCode,RC.FTBnkCode,RC.FTXrcRefDesc ) SALRC ON RC.FTRcvCode = SALRC.FTRcvCode AND SALRC.FTUsrCode = HD.FTUsrCode AND ISNULL(RC.FTBnkCode,'''') = ISNULL(SALRC.FTBnkCode,'''') AND ISNULL(RC.FTXrcRefDesc,'''') = ISNULL(SALRC.FTXrcRefDesc,'''') '
			SET @tSql += @tSqlHD
			SET @tSql +=' AND ((RCV.FTFmtCode IN (''002'',''009'')  AND ISNULL(RC.FTBnkCode,'''') != '''') OR (RCV.FTFmtCode = ''004''))'
			--3 Where
			SET @tSql +=' GROUP BY RC.FTRcvCode,RcvFL.FTRcvName , HD.FTBchCode,HD.FTUsrCode,UsrL.FTUsrName,Rcv.FTFmtCode,CRD.FTCrdCode,RC.FTXrcRefNo1,CRDL.FTCrdName,RC.FTXrcRefDesc,SALRC.FNRcvUseAmt '
		SET @tSql +=' ) Sale ON Rcv.FTRcvCode = Sale.FTRcvCode AND SaleMst.FTBchCode = Sale.FTBchCode AND SaleMst.FTUsrCode = Sale.FTUsrCode'
		SET @tSql +=' WHERE RCV.FTFmtCode IN (''002'',''009'',''004'')'
		SET @tSql +=' GROUP BY  ISNULL(FTTnsType, ''2''), Rcv.FTRcvCode, RcvFL.FTRcvName,SaleMst.FTUsrCode, SaleMst.FTUsrName,Rcv.FTFmtCode,Sale.FNRcvUseAmt,Sale.FTRcvRefNo1,Sale.FTRcvRefNo2' 


	--PRINT @tSql
	EXECUTE(@tSql)
	RETURN SELECT * FROM TRPTSalDailyByCashierKPCTmp WHERE FTComName = ''+ @nComName + '' AND FTRptCode = ''+ @tRptCode +'' AND FTUsrSession = '' + @tUsrSession + ''
END TRY

BEGIN CATCH 
	SET @FNResult= -1
	--PRINT @tSql
END CATCH
GO

--############################################################################################
-- สร้าง		  : 18-05-2022 
-- โดย			 : เจมส์
-- เวอร์ชั่น		: 00.00.09

IF EXISTS (SELECT 1 FROM sys.views WHERE name='VCN_Price4PdtActive' AND type='V')
	DROP VIEW VCN_Price4PdtActive
GO

CREATE VIEW VCN_Price4PdtActive AS
SELECT P.*
FROM (
	SELECT 
		ROW_NUMBER() OVER (PARTITION BY FTPdtCode, FTPunCode ORDER BY FTPdtCode ASC, FTPghDocType DESC, FDPghDStart DESC) AS FNRowPart, 
		FTPdtCode, 
		FTPunCode, 
		CONVERT(VARCHAR(16), FDPghDStart, 121) AS FDPghDStart,
		0 AS FCPgdPriceNet, 
		FCPgdPriceRet, 
        0 AS FCPgdPriceWhs
	FROM TCNTPdtPrice4PDT WITH(NOLOCK)
	WHERE CONVERT(VARCHAR,FDPghDStart,23) <= CONVERT(VARCHAR,GETDATE(),23) 
	  AND CONVERT(VARCHAR,FDPghDStop,23) >= CONVERT(VARCHAR,GETDATE(),23)
	  AND CONVERT(VARCHAR(5),FTPghTStart,8) <= CONVERT(VARCHAR(5),GETDATE(),8) 
	  AND CONVERT(VARCHAR(5),FTPghTStop,8) >= CONVERT(VARCHAR(5),GETDATE(),8)
) P
WHERE P.FNRowPart = 1
GO

--############################################################################################
-- สร้าง		  : 23-06-2022 
-- โดย			 : เจมส์
-- เวอร์ชั่น		: 00.00.10
-- สโตลพี่อาร์ม

--############################################################################################

IF EXISTS (SELECT * FROM dbo.sysobjects WHERE id = object_id(N'STP_DOCxPricePrc')and OBJECTPROPERTY(id, N'IsProcedure') = 1)
	DROP PROCEDURE [dbo].STP_DOCxPricePrc
GO

CREATE PROCEDURE [dbo].STP_DOCxPricePrc
 @ptBchCode varchar(5)
,@ptDocNo varchar(30)
,@ptWho varchar(100) ,@FNResult INT OUTPUT AS
DECLARE @tHQCode varchar(5)
DECLARE @tBchTo varchar(5)	--2.--
DECLARE @tZneTo varchar(30)	--2.--
DECLARE @tAggCode  varchar(5)	--2.--
DECLARE @tPplCode  varchar(5)	--2.--
DECLARE @TTmpPrcPri TABLE 
   ( 
   --FTAggCode  varchar(5), /*Arm 63-06-08 Comment Code */
   --FTPghZneTo varchar(30), /*Arm 63-06-08 Comment Code */
   --FTPghBchTo varchar(5), /*Arm 63-06-08 Comment Code */
   FTPghDocNo varchar(20), 
   FTPplCode varchar(20), 
   FTPdtCode varchar(20),
   FTPunCode varchar(5),
   FDPghDStart datetime,
   FTPghTStart varchar(10),
   FDPghDStop datetime,
   FTPghTStop varchar(10),
   FTPghDocType varchar(1),
   FTPghStaAdj varchar(1),
   FCPgdPriceRet numeric(18, 4),
   --FCPgdPriceWhs numeric(18, 4), /*Arm 63-06-08 Comment Code */
   --FCPgdPriceNet numeric(18, 4), /*Arm 63-06-08 Comment Code */
   FTPdtBchCode varchar(5)
   ) 
DECLARE @tStaPrc varchar(1)		-- 6. --
/*---------------------------------------------------------------------
Document History
version		Date			User	Remark
02.01.00	23/03/2020		Em		create  
02.02.00	08/06/2020		Arm     แก้ไข ยกเลิกฟิวด์
04.01.00	08/10/2020		Em		แก้ไขกรณีข้อมูลซ้ำกัน
05.01.00	11/05/2021		Em		แก้ไขเรื่อง Group ตาม PplCode ด้วย
21.07.01	08/10/2021		Em		ปรับ PK Price4PDT
21.07.02	11/04/2022		Zen		ปรับ DELETE ออก
----------------------------------------------------------------------*/
BEGIN TRY
	--SET @tHQCode = ISNULL((SELECT TOP 1 FTBchCode FROM TCNMBranch with(nolock) WHERE ISNULL(FTBchStaHQ,'') = '1' ),'')

	/*Arm 63-06-08 Comment Code */
	--SELECT TOP 1 @tAggCode = ISNULL(FTAggCode,'') ,@tZneTo = ISNULL(FTXphZneTo,''),@tBchTo = ISNULL(FTXphBchTo,'') 
	--,@tPplCode = ISNULL(FTPplCode,'') 
	--,@tStaPrc = ISNULL(FTXphStaPrcDoc,'')	-- 6. --
	--FROM TCNTPdtAdjPriHD with(nolock) WHERE FTXphDocNo = @ptDocNo	--4.--
	
	/*Arm 63-06-08 Edit Code */
	SELECT TOP 1 @tPplCode = ISNULL(FTPplCode,'') 
	,@tStaPrc = ISNULL(FTXphStaPrcDoc,'')	-- 6. --
	FROM TCNTPdtAdjPriHD with(nolock) WHERE FTXphDocNo = @ptDocNo	--4.--
	/*Arm 63-06-08 End Edit Code */
	 
	 --select 4/0

	IF @tStaPrc <> '1'	-- 6. --
	BEGIN
		--INSERT INTO @TTmpPrcPri(FTAggCode, FTPghZneTo, FTPghBchTo, FTPplCode, FTPdtCode, FTPunCode, FDPghDStart, FTPghTStart, /*Arm 63-06-08 Comment Code */
		--FDPghDStop, FTPghTStop, FTPghDocNo, FTPghDocType, FTPghStaAdj, FCPgdPriceRet, FCPgdPriceWhs, FCPgdPriceNet, FTPdtBchCode) /*Arm 63-06-08 Comment Code */
		INSERT INTO @TTmpPrcPri(FTPplCode, FTPdtCode, FTPunCode, FDPghDStart, FTPghTStart,
		FDPghDStop, FTPghTStop, FTPghDocNo, FTPghDocType, FTPghStaAdj, FCPgdPriceRet, FTPdtBchCode)
		-- SELECT DISTINCT ISNULL(HD.FTAggCode,'') AS FTAggCode, ISNULL(HD.FTXphZneTo,'') AS FTPghZneTo, ISNULL(HD.FTXphBchTo,'') AS FTPghBchTo, ISNULL(HD.FTPplCode,'') AS FTPplCode, /*Arm 63-06-08 Comment Code */
		SELECT DISTINCT ISNULL(HD.FTPplCode,'') AS FTPplCode, 
				DT.FTPdtCode, DT.FTPunCode, HD.FDXphDStart, HD.FTXphTStart,
				HD.FDXphDStop, HD.FTXphTStop , HD.FTXphDocNo, HD.FTXphDocType, HD.FTXphStaAdj, 
				--DT.FCXpdPriceRet, DT.FCXpdPriceWhs, DT.FCXpdPriceNet, DT.FTXpdBchTo		--2.-- /*Arm 63-06-08 Comment Code */
				DT.FCXpdPriceRet, DT.FTXpdBchTo		--2.--
		FROM TCNTPdtAdjPriDT DT with(nolock)		--4.--
		INNER JOIN TCNTPdtAdjPriHD HD with(nolock) ON DT.FTBchCode = HD.FTBchCode AND DT.FTXphDocNo = HD.FTXphDocNo	--4.--
		WHERE HD.FTXphDocNo = @ptDocNo	-- 7. --

		-- 04.01.00 --
		-- 21.07.02 --
		--DELETE TMP
		--FROM @TTmpPrcPri TMP
		--INNER JOIN TCNTPdtPrice4PDT PDT with(nolock) ON TMP.FTPdtCode = PDT.FTPdtCode AND TMP.FTPunCode = PDT.FTPunCode
		--		AND TMP.FDPghDStart = PDT.FDPghDStart AND TMP.FTPghTStart = PDT.FTPghTStart
		--		AND TMP.FTPplCode = PDT.FTPplCode	-- 05.01.00 --
		--		AND TMP.FTPghDocType = PDT.FTPghDocType	-- 21.07.01 --
		--		AND TMP.FTPghDocNo <= PDT.FTPghDocNo

		--DELETE PDT
		--FROM TCNTPdtPrice4PDT PDT
		--INNER JOIN @TTmpPrcPri TMP ON TMP.FTPdtCode = PDT.FTPdtCode AND TMP.FTPunCode = PDT.FTPunCode
		--		AND TMP.FDPghDStart = PDT.FDPghDStart AND TMP.FTPghTStart = PDT.FTPghTStart
		--		AND TMP.FTPplCode = PDT.FTPplCode	-- 05.01.00 --
		--		AND TMP.FTPghDocType = PDT.FTPghDocType	-- 21.07.01 --
		--		AND TMP.FTPghDocNo >= PDT.FTPghDocNo
		-- 21.07.02 --
		-- 04.01.00 --

		INSERT INTO TCNTPdtPrice4PDT
			(FTPdtCode, FTPunCode, FDPghDStart, FTPghTStart,FDPghDStop, FTPghTStop, 
			FTPghDocNo, FTPghDocType, FTPghStaAdj, FCPgdPriceRet, --FCPgdPriceWhs, FCPgdPriceNet, /*Arm 63-06-08 Comment Code */
			FTPplCode,
			FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)	-- 5.--
		SELECT FTPdtCode, FTPunCode, FDPghDStart, FTPghTStart,FDPghDStop, FTPghTStop, 
			FTPghDocNo, FTPghDocType, FTPghStaAdj, FCPgdPriceRet, --FCPgdPriceWhs, FCPgdPriceNet,
			FTPplCode,
			GETDATE(),@ptWho,GETDATE(),@ptWho	-- 5. --
		FROM @TTmpPrcPri

	END	-- 6. --
	SET @FNResult= 0
END TRY
BEGIN CATCH
    --EXEC STP_MSGxWriteTSysPrcLog @ptComName,@ptWho,@ptDocNo ,@tDate ,@tTime
    SET @FNResult= -1
	select ERROR_MESSAGE()
END CATCH