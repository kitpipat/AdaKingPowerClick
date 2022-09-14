
--Clear Tranactions
--DECLARE @tAgnCode VARCHAR(5)
DECLARE @tBchCode VARCHAR(5)
DECLARE @tPosCode VARCHAR(5)
DECLARE @tStaDoc VARCHAR(1)
DECLARE @tStaTxn VARCHAR(1)

--SET @tAgnCode = ''
--SET @tBchCode = ''	
--SET @tPosCode = ''	
SET @tStaDoc = '1'	
SET @tStaTxn = '1'	

IF @tStaDoc = '1' BEGIN
	--Redeem
	DELETE DT
	FROM TARTRedeemCD DT with(nolock)
	INNER JOIN TARTRedeemHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTRdhDocNo = DT.FTRdhDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TARTRedeemDT DT with(nolock)
	INNER JOIN TARTRedeemHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTRdhDocNo = DT.FTRdhDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TARTRedeemHD_L DT with(nolock)
	INNER JOIN TARTRedeemHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTRdhDocNo = DT.FTRdhDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TARTRedeemHDBch DT with(nolock)
	INNER JOIN TARTRedeemHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTRdhDocNo = DT.FTRdhDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TARTRedeemHDCstPri DT with(nolock)
	INNER JOIN TARTRedeemHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTRdhDocNo = DT.FTRdhDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE HD
	FROM  TARTRedeemHD HD with(nolock)
	--WHERE HD.FTBchCode = @tBchCode
	--================================================================================================
	--
	DELETE DT
	FROM TCNTPdtAdjCostDT DT with(nolock)
	INNER JOIN TCNTPdtAdjCostHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXchDocNo = DT.FTXchDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE HD
	FROM  TCNTPdtAdjCostHD HD with(nolock)
	--WHERE HD.FTBchCode = @tBchCode
	--================================================================================================
	----Adjust Price
	DELETE DT
	FROM TCNTPdtPrice4PDT DT with(nolock)
	-- INNER JOIN TCNTPdtAdjPriHD HD with(nolock) ON HD.FTXphDocNo = DT.FTPghDocNo 
	-- WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TCNTPdtAdjPriDT DT with(nolock)
	-- INNER JOIN TCNTPdtAdjPriHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXphDocNo = DT.FTXphDocNo 
	-- WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TCNTPdtAdjPriRT DT with(nolock)
	-- INNER JOIN TCNTPdtAdjPriHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXphDocNo = DT.FTXphDocNo 
	-- WHERE HD.FTBchCode = @tBchCode

	DELETE HD
	FROM  TCNTPdtAdjPriHD HD with(nolock)
	-- WHERE HD.FTBchCode = @tBchCode
	--================================================================================================
	--Promotion
	DELETE DT
	FROM TCNTPdtPmtCB DT with(nolock)
	INNER JOIN TCNTPdtPmtHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTPmhDocNo = DT.FTPmhDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TCNTPdtPmtCG DT with(nolock)
	INNER JOIN TCNTPdtPmtHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTPmhDocNo = DT.FTPmhDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TCNTPdtPmtDT DT with(nolock)
	INNER JOIN TCNTPdtPmtHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTPmhDocNo = DT.FTPmhDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TCNTPdtPmtHD_L DT with(nolock)
	INNER JOIN TCNTPdtPmtHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTPmhDocNo = DT.FTPmhDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TCNTPdtPmtHDBch DT with(nolock)
	INNER JOIN TCNTPdtPmtHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTPmhDocNo = DT.FTPmhDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	--DELETE DT
	--FROM TCNTPdtPmtHDChn DT with(nolock)
	--INNER JOIN TCNTPdtPmtHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTPmhDocNo = DT.FTPmhDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TCNTPdtPmtHDCst DT with(nolock)
	INNER JOIN TCNTPdtPmtHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTPmhDocNo = DT.FTPmhDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TCNTPdtPmtHDCstPri DT with(nolock)
	INNER JOIN TCNTPdtPmtHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTPmhDocNo = DT.FTPmhDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE HD
	FROM  TCNTPdtPmtHD HD with(nolock)
	--WHERE HD.FTBchCode = @tBchCode
	--================================================================================================
	-- Coupon
	DELETE DT
	FROM TFNTCouponDT DT with(nolock)
	INNER JOIN TFNTCouponHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTCphDocNo = DT.FTCphDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TFNTCouponDTCst DT with(nolock)
	INNER JOIN TFNTCouponHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTCphDocNo = DT.FTCphDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TFNTCouponDTHis DT with(nolock)
	INNER JOIN TFNTCouponHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTCphDocNo = DT.FTCphDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TFNTCouponHD_L DT with(nolock)
	INNER JOIN TFNTCouponHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTCphDocNo = DT.FTCphDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TFNTCouponHDBch DT with(nolock)
	INNER JOIN TFNTCouponHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTCphDocNo = DT.FTCphDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TFNTCouponHDCstPri DT with(nolock)
	INNER JOIN TFNTCouponHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTCphDocNo = DT.FTCphDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TFNTCouponHDPdt DT with(nolock)
	INNER JOIN TFNTCouponHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTCphDocNo = DT.FTCphDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE HD
	FROM  TFNTCouponHD HD with(nolock)
	--WHERE HD.FTBchCode = @tBchCode
	--================================================================================================
	--
	DELETE DT
	FROM TFNTCrdImpDT DT with(nolock)
	INNER JOIN TFNTCrdImpHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTCihDocNo = DT.FTCihDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE HD
	FROM  TFNTCrdImpHD HD with(nolock)
	--WHERE HD.FTBchCode = @tBchCode
	--================================================================================================
	--Promotion Card
	DELETE DT
	FROM TFNTCrdPmtCD DT with(nolock)
	INNER JOIN TFNTCrdPmtHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTPmhDocNo = DT.FTPmhDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TFNTCrdPmtDT DT with(nolock)
	INNER JOIN TFNTCrdPmtHD HD with(nolock)ON HD.FTBchCode = DT.FTBchCode AND HD.FTPmhDocNo = DT.FTPmhDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TFNTCrdPmtHD_L DT with(nolock)
	INNER JOIN TFNTCrdPmtHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTPmhDocNo = DT.FTPmhDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TFNTCrdPmtHDBch DT with(nolock)
	INNER JOIN TFNTCrdPmtHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTPmhDocNo = DT.FTPmhDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE HD
	FROM  TFNTCrdPmtHD HD with(nolock)
	--WHERE HD.FTBchCode = @tBchCode
END
--++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
IF @tStaTxn = '1' BEGIN
	--PC
	DELETE DT
	FROM TAPTPcDT DT with(nolock)
	INNER JOIN TAPTPcHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXphDocNo = DT.FTXphDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TAPTPcDTDis DT with(nolock)
	INNER JOIN TAPTPcHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXphDocNo = DT.FTXphDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TAPTPcHDDis DT with(nolock)
	INNER JOIN TAPTPcHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXphDocNo = DT.FTXphDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TAPTPcHDSpl DT with(nolock)
	INNER JOIN TAPTPcHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXphDocNo = DT.FTXphDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE HD
	FROM  TAPTPcHD HD with(nolock)
	--WHERE HD.FTBchCode = @tBchCode
	--================================================================================================
	--PI
	DELETE DT
	FROM TAPTPiDT DT with(nolock)
	INNER JOIN TAPTPiHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXphDocNo = DT.FTXphDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TAPTPiDTDis DT with(nolock)
	INNER JOIN TAPTPiHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXphDocNo = DT.FTXphDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TAPTPiHDDis DT with(nolock)
	INNER JOIN TAPTPiHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXphDocNo = DT.FTXphDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TAPTPiHDSpl DT with(nolock)
	INNER JOIN TAPTPiHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXphDocNo = DT.FTXphDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE HD
	FROM  TAPTPiHD HD with(nolock)
	--WHERE HD.FTBchCode = @tBchCode
	--================================================================================================
	--PO
	--DELETE DT
	--FROM TAPTPoDT DT with(nolock)
	--INNER JOIN TAPTPoHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXphDocNo = DT.FTXphDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	--DELETE DT
	--FROM TAPTPoDTDis DT with(nolock)
	--INNER JOIN TAPTPoHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXphDocNo = DT.FTXphDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	--DELETE DT
	--FROM TAPTPoHDDis DT with(nolock)
	--INNER JOIN TAPTPoHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXphDocNo = DT.FTXphDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	--DELETE DT
	--FROM TAPTPoHDSpl DT with(nolock)
	--INNER JOIN TAPTPoHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXphDocNo = DT.FTXphDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	--DELETE HD
	--FROM  TAPTPoHD HD with(nolock)
	--WHERE HD.FTBchCode = @tBchCode
	--================================================================================================
	--
	DELETE DT
	FROM TCNTPdtAdjStkDT DT with(nolock)
	INNER JOIN TCNTPdtAdjStkHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTAjhDocNo = DT.FTAjhDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE HD
	FROM  TCNTPdtAdjStkHD HD with(nolock)
	--WHERE HD.FTBchCode = @tBchCode
	--================================================================================================
	--
	DELETE DT
	FROM TCNTPdtReqTnfDT DT with(nolock)
	INNER JOIN TCNTPdtReqTnfHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXthDocNo = DT.FTXthDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE HD
	FROM  TCNTPdtReqTnfHD HD with(nolock)
	--WHERE HD.FTBchCode = @tBchCode
	--================================================================================================
	--Pdt Transfer in
	DELETE DT
	FROM TCNTPdtTbiDT DT with(nolock)
	INNER JOIN TCNTPdtTbiHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXthDocNo = DT.FTXthDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TCNTPdtTbiHDRef DT with(nolock)
	INNER JOIN TCNTPdtTbiHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXthDocNo = DT.FTXthDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE HD
	FROM  TCNTPdtTbiHD HD with(nolock)
	--WHERE HD.FTBchCode = @tBchCode

	--================================================================================================
	--Pdt Transfer out
	DELETE DT
	FROM TCNTPdtTboDT DT with(nolock)
	INNER JOIN TCNTPdtTboHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXthDocNo = DT.FTXthDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TCNTPdtTboHDRef DT with(nolock)
	INNER JOIN TCNTPdtTboHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXthDocNo = DT.FTXthDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE HD
	FROM  TCNTPdtTboHD HD with(nolock)
	--WHERE HD.FTBchCode = @tBchCode
	--================================================================================================
	--Pdt Transfer Branch
	DELETE DT
	FROM TCNTPdtTbxDT DT with(nolock)
	INNER JOIN TCNTPdtTbxHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXthDocNo = DT.FTXthDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TCNTPdtTbxHDRef DT with(nolock)
	INNER JOIN TCNTPdtTbxHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXthDocNo = DT.FTXthDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE HD
	FROM  TCNTPdtTbxHD HD with(nolock)
	--WHERE HD.FTBchCode = @tBchCode
	--================================================================================================
	--
	DELETE DT
	FROM TCNTPdtTwiDT DT with(nolock)
	INNER JOIN TCNTPdtTwiHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXthDocNo = DT.FTXthDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TCNTPdtTwiDTVD DT with(nolock)
	INNER JOIN TCNTPdtTwiHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXthDocNo = DT.FTXthDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TCNTPdtTwiHDRef DT with(nolock)
	INNER JOIN TCNTPdtTwiHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXthDocNo = DT.FTXthDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE HD
	FROM  TCNTPdtTwiHD HD with(nolock)
	--WHERE HD.FTBchCode = @tBchCode
	--================================================================================================
	--
	DELETE DT
	FROM TCNTPdtTwoDT DT with(nolock)
	INNER JOIN TCNTPdtTwoHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXthDocNo = DT.FTXthDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TCNTPdtTwoDTVD DT with(nolock)
	INNER JOIN TCNTPdtTwoHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXthDocNo = DT.FTXthDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TCNTPdtTwoHDRef DT with(nolock)
	INNER JOIN TCNTPdtTwoHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXthDocNo = DT.FTXthDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE HD
	FROM  TCNTPdtTwoHD HD with(nolock)
	--WHERE HD.FTBchCode = @tBchCode
	--================================================================================================
	--
	DELETE DT
	FROM TCNTPdtTwxDT DT with(nolock)
	INNER JOIN TCNTPdtTwxHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXthDocNo = DT.FTXthDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TCNTPdtTwxHDRef DT with(nolock)
	INNER JOIN TCNTPdtTwxHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXthDocNo = DT.FTXthDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE HD
	FROM  TCNTPdtTwxHD HD with(nolock)
	--WHERE HD.FTBchCode = @tBchCode
	--================================================================================================
	--
	DELETE DT
	FROM TFNTBnkDplDT DT with(nolock)
	INNER JOIN TFNTBnkDplHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTBdhDocNo = DT.FTBdhDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE HD
	FROM  TFNTBnkDplHD HD with(nolock)
	--WHERE HD.FTBchCode = @tBchCode
	--================================================================================================
	--
	DELETE DT
	FROM TFNTCrdShiftDT DT with(nolock)
	INNER JOIN TFNTCrdShiftHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE HD
	FROM  TFNTCrdShiftHD HD with(nolock)
	--WHERE HD.FTBchCode = @tBchCode
	--================================================================================================
	--
	DELETE DT
	FROM TFNTCrdTopUpDT DT with(nolock)
	INNER JOIN TFNTCrdTopUpPD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TFNTCrdTopUpRC DT with(nolock)
	INNER JOIN TFNTCrdTopUpPD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE DT
	FROM TFNTCrdTopUpRC DT with(nolock)
	INNER JOIN TFNTCrdTopUpHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE HD
	FROM  TFNTCrdTopUpHD HD with(nolock)
	--WHERE HD.FTBchCode = @tBchCode
	--================================================================================================
	--
	DELETE DT
	FROM TFNTCrdVoidDT DT with(nolock)
	INNER JOIN TFNTCrdVoidHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTCvhDocNo = DT.FTCvhDocNo 
	--WHERE HD.FTBchCode = @tBchCode

	DELETE HD
	FROM  TFNTCrdVoidHD HD with(nolock)
	--WHERE HD.FTBchCode = @tBchCode
	--================================================================================================
	--Hold
	DELETE DT
	FROM TPSTHoldDT DT with(nolock)
	INNER JOIN TPSTHoldHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo 
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode


	DELETE DT
	FROM TPSTHoldDTDis DT with(nolock)
	INNER JOIN TPSTHoldHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXihDocNo 
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE DT
	FROM TPSTHoldHDCst DT with(nolock)
	INNER JOIN TPSTHoldHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo 
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE HD
	FROM  TPSTHoldHD HD with(nolock)
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode
	--================================================================================================
	--Sale
	DELETE DT
	FROM TCNTMemTxnRedeem DT with(nolock)
	INNER JOIN TPSTSalHD HD with(nolock) ON (HD.FTXshDocNo = DT.FTRedRefDoc OR HD.FTXshDocNo = DT.FTRedRefInt)
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE DT
	FROM TCNTMemTxnSale DT with(nolock)
	INNER JOIN TPSTSalHD HD with(nolock) ON (HD.FTXshDocNo = DT.FTTxnRefDoc OR HD.FTXshDocNo = DT.FTTxnRefInt)
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE DT
	FROM TPSTSalDT DT with(nolock)
	INNER JOIN TPSTSalHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo 
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE DT
	FROM TPSTSalDTDis DT with(nolock)
	INNER JOIN TPSTSalHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo 
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE DT
	FROM TPSTSalDTSet DT with(nolock)
	INNER JOIN TPSTSalHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo 
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE DT
	FROM TPSTSalHDCst DT with(nolock)
	INNER JOIN TPSTSalHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo 
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE DT
	FROM TPSTSalHDDis DT with(nolock)
	INNER JOIN TPSTSalHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo 
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE DT
	FROM TPSTSalPD DT with(nolock)
	INNER JOIN TPSTSalHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo 
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE DT
	FROM TPSTSalRC DT with(nolock)
	INNER JOIN TPSTSalHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo 
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE DT
	FROM TPSTSalRD DT with(nolock)
	INNER JOIN TPSTSalHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo 
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE DT
	FROM TPSTSlipEJ DT with(nolock)
	INNER JOIN TPSTSalHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo 
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE HD
	FROM  TPSTSalHD HD with(nolock)
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode
	--================================================================================================
	--Shift
	DELETE DT
	FROM TPSTShiftDT DT with(nolock)
	INNER JOIN TPSTShiftHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTShfCode = DT.FTShfCode 
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE DT
	FROM TPSTShiftEvent DT with(nolock)
	INNER JOIN TPSTShiftHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTShfCode = DT.FTShfCode 
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE DT
	FROM TPSTShiftSKeyBN DT with(nolock)
	INNER JOIN TPSTShiftHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTShfCode = DT.FTShfCode 
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE DT
	FROM TPSTShiftSKeyRcv DT with(nolock)
	INNER JOIN TPSTShiftHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTShfCode = DT.FTShfCode 
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE DT
	FROM TPSTShiftSLastDoc DT with(nolock)
	INNER JOIN TPSTShiftHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTShfCode = DT.FTShfCode 
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE DT
	FROM TPSTShiftSRatePdt DT with(nolock)
	INNER JOIN TPSTShiftHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTShfCode = DT.FTShfCode 
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE DT
	FROM TPSTShiftSSumRcv DT with(nolock)
	INNER JOIN TPSTShiftHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTShfCode = DT.FTShfCode 
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE HD
	FROM  TPSTShiftHD HD with(nolock)
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode
	--================================================================================================
	--Tax
	DELETE DT
	FROM TPSTTaxDT DT with(nolock)
	INNER JOIN TPSTTaxHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo 
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE DT
	FROM TPSTTaxDTDis DT with(nolock)
	INNER JOIN TPSTTaxHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo 
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE DT
	FROM TPSTTaxHDCst DT with(nolock)
	INNER JOIN TPSTTaxHD HD ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo 
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE DT
	FROM TPSTTaxHDDis DT with(nolock)
	INNER JOIN TPSTTaxHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo 
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE DT
	FROM TPSTTaxNo DT with(nolock)
	INNER JOIN TPSTTaxHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo 
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE DT
	FROM TPSTTaxPD DT with(nolock)
	INNER JOIN TPSTTaxHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo 
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE DT
	FROM TPSTTaxRC DT with(nolock)
	INNER JOIN TPSTTaxHD HD ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo 
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE DT
	FROM TPSTTaxRD DT with(nolock)
	INNER JOIN TPSTTaxHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo 
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE HD
	FROM  TPSTTaxHD HD with(nolock)
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode
	--================================================================================================
	--Void
	DELETE DT
	FROM TPSTVoidDTDis DT with(nolock)
	INNER JOIN TPSTVoidDT HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FNVidNo = DT.FNVidNo 
	--WHERE HD.FTBchCode = @tBchCode AND SUBSTRING(HD.FTXihDocNo,9,5) = @tPosCode

	DELETE HD
	FROM  TPSTVoidDT HD with(nolock)
	--WHERE HD.FTBchCode = @tBchCode AND SUBSTRING(HD.FTXihDocNo,9,5) = @tPosCode
	--================================================================================================
	--
	DELETE DT
	FROM TVDTPdtTwiDT DT with(nolock)
	INNER JOIN TVDTPdtTwiHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXthDocNo = DT.FTXthDocNo 
	--WHERE HD.FTBchCode = @tBchCode 

	DELETE DT
	FROM TVDTPdtTwiHDRef DT with(nolock)
	INNER JOIN TVDTPdtTwiHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXthDocNo = DT.FTXthDocNo 
	--WHERE HD.FTBchCode = @tBchCode 

	DELETE HD
	FROM  TVDTPdtTwiHD HD with(nolock)
	--WHERE HD.FTBchCode = @tBchCode
	--================================================================================================
	--
	DELETE DT
	FROM TVDTPdtTwoDT DT with(nolock)
	INNER JOIN TVDTPdtTwoHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXthDocNo = DT.FTXthDocNo 
	--WHERE HD.FTBchCode = @tBchCode 

	DELETE DT
	FROM TVDTPdtTwoHDRef DT with(nolock)
	INNER JOIN TVDTPdtTwoHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXthDocNo = DT.FTXthDocNo 
	--WHERE HD.FTBchCode = @tBchCode 

	DELETE HD
	FROM  TVDTPdtTwoHD HD with(nolock)
	--WHERE HD.FTBchCode = @tBchCode
	--================================================================================================
	--
	DELETE DT
	FROM TVDTPdtTwxDT DT with(nolock)
	INNER JOIN TVDTPdtTwxHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXthDocNo = DT.FTXthDocNo 
	--WHERE HD.FTBchCode = @tBchCode 

	DELETE DT
	FROM TVDTPdtTwxHDRef DT with(nolock)
	INNER JOIN TVDTPdtTwxHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXthDocNo = DT.FTXthDocNo 
	--WHERE HD.FTBchCode = @tBchCode 

	DELETE HD
	FROM  TVDTPdtTwxHD HD with(nolock)
	--WHERE HD.FTBchCode = @tBchCode
	--================================================================================================
	--Sale Vending
	DELETE DT
	FROM TVDTSalDT DT with(nolock)
	INNER JOIN TVDTSalHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo 
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE DT
	FROM TVDTSalDTDis DT with(nolock)
	INNER JOIN TVDTSalHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo 
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE DT
	FROM TVDTSalDTVD DT with(nolock)
	INNER JOIN TVDTSalHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo 
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE DT
	FROM TVDTSalHDCst DT with(nolock)
	INNER JOIN TVDTSalHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo 
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE DT
	FROM TVDTSalHDDis DT with(nolock)
	INNER JOIN TVDTSalHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo 
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE DT
	FROM TVDTSalHDPatient DT with(nolock)
	INNER JOIN TVDTSalHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo 
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE DT
	FROM TVDTSalRC DT with(nolock)
	INNER JOIN TVDTSalHD HD with(nolock) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo 
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode

	DELETE HD
	FROM  TVDTSalHD HD with(nolock)
	--WHERE HD.FTBchCode = @tBchCode AND HD.FTPosCode = @tPosCode
	--================================================================================================
	DELETE TCNTPdtIntDT --WHERE FTBchCode = @tBchCode
	DELETE TCNTPdtIntDTBch --WHERE FTBchCode = @tBchCode
	DELETE TCNTPdtStkBal --WHERE FTBchCode = @tBchCode
	DELETE TCNTPdtStkBalBch --WHERE FTBchCode = @tBchCode
	DELETE TCNTPdtStkCrd --WHERE FTBchCode = @tBchCode
	DELETE TCNTPdtStkCrdBch --WHERE FTBchCode = @tBchCode
	DELETE TCNTPdtStkCrdME --WHERE FTBchCode = @tBchCode
	DELETE TCNTPdtStkCrdMEBch --WHERE FTBchCode = @tBchCode
	DELETE TCNTStkFiFoIn --WHERE FTBchCode = @tBchCode
	DELETE TCNTStkFiFoOut --WHERE FTBchCode = @tBchCode

	DELETE TFNTCrdHis --WHERE FTBchCode = @tBchCode
	DELETE TFNTCrdHisBch --WHERE FTBchCode = @tBchCode
	DELETE TFNTCrdHisME --WHERE FTBchCode = @tBchCode
	DELETE TFNTCrdSale --WHERE FTBchCode = @tBchCode
	DELETE TFNTCrdTopUp --WHERE FTBchCode = @tBchCode
	--DELETE TFNTCrdTopUpFifo WHERE FTBchCode = @tBchCode
	DELETE TVDTPdtHotSale --WHERE FTBchCode = @tBchCode
	DELETE TVDTPdtStkBal --WHERE FTBchCode = @tBchCode

	UPDATE TSysSetting SET FTSysStaUsrValue = '0' WHERE FTSysCode IN ('tPS_LastBillS','tPS_LastBillR')
END


----------------------------------------------------------------------------------------------------------

--clear master

--center
TRUNCATE TABLE TCNMAddress_L;
TRUNCATE TABLE TCNMAdMsg;
TRUNCATE TABLE TCNMAdMsg_L;
---------------------------------------------------
TRUNCATE TABLE TCNMAgency;
TRUNCATE TABLE TCNMAgency_L;
TRUNCATE TABLE TCNMAgencyGrp;
TRUNCATE TABLE TCNMAgencyGrp_L;
TRUNCATE TABLE TCNMAgencySpc;
TRUNCATE TABLE TCNMAgencyType;
TRUNCATE TABLE TCNMAgencyType_L;

---------------------------------------------------
TRUNCATE TABLE TCNMArea;
TRUNCATE TABLE TCNMArea_L;
---------------------------------------------------
TRUNCATE TABLE TCNMBranch;
TRUNCATE TABLE TCNMBranch_L;
---------------------------------------------------
TRUNCATE TABLE TCNMChannel;
TRUNCATE TABLE TCNMChannel_L;
TRUNCATE TABLE TCNMChannelSpc;
---------------------------------------------------
TRUNCATE TABLE TCNMCourieLogin;
TRUNCATE TABLE TCNMCourieMan;
TRUNCATE TABLE TCNMCourieMan_L;
TRUNCATE TABLE TCNMCourier;
TRUNCATE TABLE TCNMCourier_L;
TRUNCATE TABLE TCNMCourierGrp;
TRUNCATE TABLE TCNMCourierGrp_L;
TRUNCATE TABLE TCNMCourierType;
TRUNCATE TABLE TCNMCourierType_L;
---------------------------------------------------
TRUNCATE TABLE TCNMCrdLogin;
TRUNCATE TABLE TCNMCst;
TRUNCATE TABLE TCNMCst_L;
TRUNCATE TABLE TCNMCstAddress_L;
TRUNCATE TABLE TCNMCstCard;
TRUNCATE TABLE TCNMCstContact_L;
TRUNCATE TABLE TCNMCstCredit;
TRUNCATE TABLE TCNMCstGrp;
TRUNCATE TABLE TCNMCstGrp_L;
TRUNCATE TABLE TCNMCstLev;
TRUNCATE TABLE TCNMCstLev_L;
TRUNCATE TABLE TCNMCstLogin;
TRUNCATE TABLE TCNMCstOcp;
TRUNCATE TABLE TCNMCstOcp_L;
TRUNCATE TABLE TCNMCstRFID_L;
TRUNCATE TABLE TCNMCstType;
TRUNCATE TABLE TCNMCstType_L;
----------------------------------------------------
TRUNCATE TABLE TCNMDocApvRole;

---Mark--
TRUNCATE TABLE TCNMEventDT;
TRUNCATE TABLE TCNMEventDT_L;
TRUNCATE TABLE TCNMEventHD;
TRUNCATE TABLE TCNMEventHD_L;
---Mark--

--File + Image + Medai--
------------------------------------------------------
TRUNCATE TABLE TCNMImgObj;
TRUNCATE TABLE TCNMImgPdt;
TRUNCATE TABLE TCNMImgPerson;
TRUNCATE TABLE TCNMMediaObj;
-------------------------------------------------------
TRUNCATE TABLE TCNMLimitRole;
-------------------------------------------------------
TRUNCATE TABLE TCNMMerchant;
TRUNCATE TABLE TCNMMerchant_L;
TRUNCATE TABLE TCNMMerPdtGrp;
TRUNCATE TABLE TCNMMerPdtGrp_L;
-------------------------------------------------------
--Product--
TRUNCATE TABLE TCNMPdt;
TRUNCATE TABLE TCNMPdt_L;
TRUNCATE TABLE TCNMPdtAge;
TRUNCATE TABLE TCNMPdtBar;
TRUNCATE TABLE TCNMPdtBrand;
TRUNCATE TABLE TCNMPdtBrand_L;
TRUNCATE TABLE TCNMPdtColor;
TRUNCATE TABLE TCNMPdtColor_L;
TRUNCATE TABLE TCNMPdtCostAvg;
TRUNCATE TABLE TCNMPdtCostAvg4AGG;
TRUNCATE TABLE TCNMPdtCostAvg4BCH;
TRUNCATE TABLE TCNMPdtCostAvg4ZNE;
TRUNCATE TABLE TCNMPdtCostFIFO;
TRUNCATE TABLE TCNMPdtDrug;
TRUNCATE TABLE TCNMPdtF0DCS;
TRUNCATE TABLE TCNMPdtF0DCS_L;
TRUNCATE TABLE TCNMPdtF1Depart;
TRUNCATE TABLE TCNMPdtF1Depart_L;
TRUNCATE TABLE TCNMPdtF2Class;
TRUNCATE TABLE TCNMPdtF2Class_L;
TRUNCATE TABLE TCNMPdtF3SubClass;
TRUNCATE TABLE TCNMPdtF3SubClass_L;
TRUNCATE TABLE TCNMPdtFCostAvg;
TRUNCATE TABLE TCNMPdtFhn;
-- TRUNCATE TABLE TCNMPdtFSeason;
-- TRUNCATE TABLE TCNMPdtFSeason_L;
TRUNCATE TABLE TCNMPdtGrp;
TRUNCATE TABLE TCNMPdtGrp_L;
TRUNCATE TABLE TCNMPdtLoc;
TRUNCATE TABLE TCNMPdtLoc_L;
TRUNCATE TABLE TCNMPdtLocPickGrp;
TRUNCATE TABLE TCNMPdtLocPickGrp_L;
TRUNCATE TABLE TCNMPdtLocZone;
TRUNCATE TABLE TCNMPdtLocZone_L;
TRUNCATE TABLE TCNMPdtModel;
TRUNCATE TABLE TCNMPdtModel_L;
TRUNCATE TABLE TCNMPdtPackSize;
TRUNCATE TABLE TCNMPdtPmtGrp;
TRUNCATE TABLE TCNMPdtPmtGrp_L;
TRUNCATE TABLE TCNMPdtPriList;
TRUNCATE TABLE TCNMPdtPriList_L;
TRUNCATE TABLE TCNMPdtSize;
TRUNCATE TABLE TCNMPdtSize_L;
TRUNCATE TABLE TCNMPdtSpcBch;
TRUNCATE TABLE TCNMPdtSpcWah;
TRUNCATE TABLE TCNMPdtSpl;
TRUNCATE TABLE TCNMPdtTouchGrp;
TRUNCATE TABLE TCNMPdtTouchGrp_L;
TRUNCATE TABLE TCNMPdtType;
TRUNCATE TABLE TCNMPdtType_L;
TRUNCATE TABLE TCNMPdtUnit;
TRUNCATE TABLE TCNMPdtUnit_L;
--------------------------------------------------
--Pos---
TRUNCATE TABLE TCNMPos;
TRUNCATE TABLE TCNMPos_L;
TRUNCATE TABLE TCNMPosAds;
TRUNCATE TABLE TCNMPosHW;
TRUNCATE TABLE TCNMPosLastNo;
--------------------------------------------------
--Printer--
TRUNCATE TABLE TCNMPrinter;
TRUNCATE TABLE TCNMPrinter_L;
--------------------------------------------------
TRUNCATE TABLE TCNMRsn;
TRUNCATE TABLE TCNMRsn_L;
TRUNCATE TABLE TCNMScale;
TRUNCATE TABLE TCNMShipVia;
TRUNCATE TABLE TCNMShipVia_L;
---------------------------------------------------
--Shop--
TRUNCATE TABLE TCNMShop;
TRUNCATE TABLE TCNMShop_L;
TRUNCATE TABLE TCNMShopGP;
TRUNCATE TABLE TCNMShpWah;
----------------------------------------------------
TRUNCATE TABLE TCNMSlipMsgDT_L;
TRUNCATE TABLE TCNMSlipMsgHD_L;
-----------------------------------------------------
TRUNCATE TABLE TCNMSpl;
TRUNCATE TABLE TCNMSpl_L;
TRUNCATE TABLE TCNMSplAddress_L;
TRUNCATE TABLE TCNMSplCard;
TRUNCATE TABLE TCNMSplContact_L;
TRUNCATE TABLE TCNMSplCredit;
TRUNCATE TABLE TCNMSplGrp;
TRUNCATE TABLE TCNMSplGrp_L;
TRUNCATE TABLE TCNMSplLev;
TRUNCATE TABLE TCNMSplLev_L;
TRUNCATE TABLE TCNMSplType;
TRUNCATE TABLE TCNMSplType_L;
TRUNCATE TABLE TCNMSpn;
TRUNCATE TABLE TCNMSpn_L;
------------------------------------------------------
TRUNCATE TABLE TCNMTaxAddress_L;
-------------------------------------------------------
--Mark--
TRUNCATE TABLE TCNMTxnAPI;
TRUNCATE TABLE TCNMTxnAPI_L;
TRUNCATE TABLE TCNMTxnSpcAPI;
--Mark--
------------------------------------------------------
TRUNCATE TABLE TCNMUrlObj;
------------------------------------------------------
TRUNCATE TABLE TCNMUsrRoleSpc;
TRUNCATE TABLE TCNMUsrDepart;
TRUNCATE TABLE TCNMUsrDepart_L;
TRUNCATE TABLE TCNMWaHouse;
TRUNCATE TABLE TCNMWaHouse_L;
TRUNCATE TABLE TCNMZone;
TRUNCATE TABLE TCNMZone_L;
TRUNCATE TABLE TCNMZoneObj;
-------------------------------------------------------
--finance
TRUNCATE TABLE TFNMBank;
TRUNCATE TABLE TFNMBank_L;
TRUNCATE TABLE TFNMBankNote;
TRUNCATE TABLE TFNMBankNote_L;

TRUNCATE TABLE TFNMBnkDepType;
TRUNCATE TABLE TFNMBnkDepType_L;

TRUNCATE TABLE TFNMBookBank;
TRUNCATE TABLE TFNMBookBank_L;
TRUNCATE TABLE TFNMBookCheque;
TRUNCATE TABLE TFNMBookCheque_L;
--------------------------------------------------------
--Card--
TRUNCATE TABLE TFNMCard;
TRUNCATE TABLE TFNMCard_L;
TRUNCATE TABLE TFNMCardBal;
TRUNCATE TABLE TFNMCardMan;
TRUNCATE TABLE TFNMCardType;
TRUNCATE TABLE TFNMCardType_L;
TRUNCATE TABLE TFNMCouponType;
TRUNCATE TABLE TFNMCouponType_L;
TRUNCATE TABLE TFNMCrdCpnList;
TRUNCATE TABLE TFNMCrdCpnList_L;
TRUNCATE TABLE TFNMCrdLogin;
TRUNCATE TABLE TFNMCreditCard;
TRUNCATE TABLE TFNMCreditCard_L;
TRUNCATE TABLE TFNMCreditCardBIN;
--Card--
----------------------------------------------------------
TRUNCATE TABLE TFNMEdc;
TRUNCATE TABLE TFNMEdc_L;
TRUNCATE TABLE TFNMRcv;
TRUNCATE TABLE TFNMRcv_L;
TRUNCATE TABLE TFNMRcvSpc;
TRUNCATE TABLE TFNMRcvSpcConfig;
TRUNCATE TABLE TFNMVoucher;
TRUNCATE TABLE TFNMVoucher_L;
TRUNCATE TABLE TFNMVoucherType;
TRUNCATE TABLE TFNMVoucherType_L;
----------------------------------------------------------
--register 
TRUNCATE TABLE TRGMCstBch;
TRUNCATE TABLE TRGMCstRegis;
TRUNCATE TABLE TRGMPdtTmp;
TRUNCATE TABLE TRGMPosSrv;
TRUNCATE TABLE TRGMPosSrv_L;
TRUNCATE TABLE TRGSFuncDTLic;
TRUNCATE TABLE TRGSMenuLic;
TRUNCATE TABLE TRGSMenuLic_Tmp;
TRUNCATE TABLE TRGTAutoNumber;
TRUNCATE TABLE TRGTCstBchLic;
TRUNCATE TABLE TRGTCstKey;
TRUNCATE TABLE TRGTLicKey;
TRUNCATE TABLE TRGTSalDTDisTmp;
TRUNCATE TABLE TRGTSalDTSetTmp;
TRUNCATE TABLE TRGTSalDTTmp;
TRUNCATE TABLE TRGTSalHDDisTmp;
TRUNCATE TABLE TRGTSalHDTmp;
TRUNCATE TABLE TRGTSalRCTmp;

---Lic--
TRUNCATE TABLE _LIC_Feature;
TRUNCATE TABLE _LIC_Package;
TRUNCATE TABLE _LIC_RPTMenu;
TRUNCATE TABLE _LIC_SBMenu;
TRUNCATE TABLE _LIC_SFFunction;
TRUNCATE TABLE _LIC_TCNMPdt;
TRUNCATE TABLE _LIC_TCNMPdt_L;
TRUNCATE TABLE _LIC_TCNMPdtBar;
TRUNCATE TABLE _LIC_TCNMPdtPackSize;
TRUNCATE TABLE _LIC_TCNMPdtUnit;
TRUNCATE TABLE _LIC_TCNMPdtUnit_L;
TRUNCATE TABLE _LIC_TCNTPdtSet;
TRUNCATE TABLE _LIC_TSysMenuList;




---Fashoin--
TRUNCATE TABLE TFHMPdtColorSize;
TRUNCATE TABLE TFHMPdtF1Depart;
TRUNCATE TABLE TFHMPdtF1Depart_L;
TRUNCATE TABLE TFHMPdtF2Class;
TRUNCATE TABLE TFHMPdtF2Class_L;
TRUNCATE TABLE TFHMPdtF3SubClass;
TRUNCATE TABLE TFHMPdtF3SubClass_L;
TRUNCATE TABLE TFHMPdtF4Group;
TRUNCATE TABLE TFHMPdtF4Group_L;
TRUNCATE TABLE TFHMPdtF5ComLines;
TRUNCATE TABLE TFHMPdtF5ComLines_L;
TRUNCATE TABLE TFHMPdtFabric;
TRUNCATE TABLE TFHMPdtFabric_L;
TRUNCATE TABLE TFHMPdtFhn;
TRUNCATE TABLE TFHMPdtSeason;
TRUNCATE TABLE TFHMPdtSeason_L;

TRUNCATE TABLE TFHTPdtStkBal;
TRUNCATE TABLE TFHTPdtStkCrd;
TRUNCATE TABLE TFHTPdtStkCrdBch;
TRUNCATE TABLE TFHTPdtStkCrdME;
TRUNCATE TABLE TFHTPdtStkCrdMEBch;


--TCNTConfigSpc
TRUNCATE TABLE TCNTConfigSpc;

TRUNCATE TABLE TCNTUrlObjectLogin;
DELETE TCNTUrlObject WHERE FTUrlKey NOT IN('REG','SLA','PAPD','BACKOFFICE');
UPDATE TCNTUrlObject SET FNUrlSeq = 1 WHERE FTUrlKey = 'REG';
UPDATE TCNTUrlObject SET FNUrlSeq = 2 WHERE FTUrlKey = 'SLA';
UPDATE TCNTUrlObject SET FNUrlSeq = 3 WHERE FTUrlKey = 'PAPD';

--User loin for register (Def User)
DELETE TCNMUser WHERE FTUsrCode != '00001';
DELETE TCNMUser_L WHERE FTUsrCode != '00001';
DELETE TCNMUsrActRole WHERE FTUsrCode != '00001';
DELETE TCNMUsrLogin WHERE FTUsrCode != '00001';
DELETE TCNMUsrRole WHERE FTRolCode != '00001';
DELETE TCNMUsrRole_L WHERE FTRolCode != '00001';
DELETE TCNMUsrRoleChain WHERE FTRolCode != '00001';
DELETE TCNMVatRate WHERE FTVatCode != '00001';
DELETE TCNTUsrFuncRpt WHERE FTRolCode != '00001';
DELETE TCNTUsrGroup WHERE FTUsrCode != '00001';
DELETE TCNTUsrMenu WHERE FTRolCode != '00001';
--req--
DELETE TFNMRate WHERE FTRteCode !='THB';
DELETE TFNMRate_L WHERE FTRteCode !='THB';
DELETE TFNMRateUnit WHERE FTRteCode !='THB';

--------------------------------------------------------------------------




