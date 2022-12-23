--################## CREATE TABLE FOR SCRIPT ##################
	IF OBJECT_ID(N'TCNTUpgradeHisTmp') IS NULL BEGIN
		CREATE TABLE [dbo].[TCNTUpgradeHisTmp] (
					[FTUphVersion] varchar(10) NOT NULL ,
					[FDCreateOn] datetime NULL ,
					[FTUphRemark] varchar(MAX) NULL ,
					[FTCreateBy] varchar(50) NULL 
			);
			ALTER TABLE [dbo].[TCNTUpgradeHisTmp] ADD PRIMARY KEY ([FTUphVersion]);
		END
	GO
--#############################################################

--Version ไฟล์ กับ Version บรรทัดที่ 15 ต้องเท่ากันเสมอ !! 

IF NOT EXISTS(SELECT FTUphVersion FROM TCNTUpgradeHisTmp WHERE FTUphVersion=  '00.00.01') BEGIN

	INSERT INTO TSysRsnGrp_L (FTRsgCode, FNLngID, FTRsgName, FTRsgRmk) VALUES ('017',1,'ภาษี','')
	INSERT INTO TSysRsnGrp_L (FTRsgCode, FNLngID, FTRsgName, FTRsgRmk) VALUES ('018',1,'ลดหนี้','')

	INSERT INTO TCNMRsn (FTRsnCode, FTAgnCode, FTRsgCode, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy, FTRsnRefID) VALUES ('CD-01','','018','2021-09-21 15:43:12.000','00003','2021-09-21 15:43:12.000','00003','CDNG99')
	INSERT INTO TCNMRsn (FTRsnCode, FTAgnCode, FTRsgCode, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy, FTRsnRefID) VALUES ('CD-02','','018','2021-09-21 15:43:54.000','00003','2021-09-21 15:43:54.000','00003','CDNG99')
	INSERT INTO TCNMRsn (FTRsnCode, FTAgnCode, FTRsgCode, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy, FTRsnRefID) VALUES ('CD-03','','018','2021-09-21 15:44:24.000','00003','2021-09-21 15:44:24.000','00003','CDNG99')
	INSERT INTO TCNMRsn (FTRsnCode, FTAgnCode, FTRsgCode, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy, FTRsnRefID) VALUES ('CT-01','','017','2021-09-21 15:41:05.000','00003','2021-09-21 15:41:05.000','00003','TIVC01')
	INSERT INTO TCNMRsn (FTRsnCode, FTAgnCode, FTRsgCode, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy, FTRsnRefID) VALUES ('CT-02','','017','2021-09-21 15:41:55.000','00003','2021-09-21 15:41:55.000','00003','TIVC02')
	INSERT INTO TCNMRsn (FTRsnCode, FTAgnCode, FTRsgCode, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy, FTRsnRefID) VALUES ('CT-03','','017','2021-09-21 15:42:29.000','00003','2021-09-21 15:42:29.000','00003','TIVC99')

	INSERT INTO TCNMRsn_L (FTRsnCode, FNLngID, FTRsnName, FTRsnRmk) VALUES ('CD-01',1,'ชื่อผิด','')
	INSERT INTO TCNMRsn_L (FTRsnCode, FNLngID, FTRsnName, FTRsnRmk) VALUES ('CD-02',1,'ที่อยู่ผิด','')
	INSERT INTO TCNMRsn_L (FTRsnCode, FNLngID, FTRsnName, FTRsnRmk) VALUES ('CD-03',1,'ชื่อและที่อยู่ผิด','')
	INSERT INTO TCNMRsn_L (FTRsnCode, FNLngID, FTRsnName, FTRsnRmk) VALUES ('CT-01',1,'ชื่อผิด','')
	INSERT INTO TCNMRsn_L (FTRsnCode, FNLngID, FTRsnName, FTRsnRmk) VALUES ('CT-02',1,'ที่อยู่ผิด','')
	INSERT INTO TCNMRsn_L (FTRsnCode, FNLngID, FTRsnName, FTRsnRmk) VALUES ('CT-03',1,'ชื่อและที่อยู่ผิด','')

--ทุกครั้งที่รันสคริปใหม่
INSERT INTO [TCNTUpgradeHisTmp] ([FTUphVersion], [FDCreateOn], [FTUphRemark], [FTCreateBy]) VALUES ( '00.00.01', getdate() , 'เพิ่มรหัส/กลุ่ม เหตุผล Mapping กับ SAP', 'Napat');
END
GO

IF NOT EXISTS(SELECT FTUphVersion FROM TCNTUpgradeHisTmp WHERE FTUphVersion=  '00.00.02') BEGIN

	INSERT INTO TCNMTxnAPI (FTApiCode, FTApiTxnType, FTApiPrcType, FTApiGrpPrc, FNApiGrpSeq, FTApiFmtCode, FTApiURL, FTApiLoginUsr, FTApiLoginPwd, FTApiToken, FDCreateOn, FTCreateBy, FDLastUpdOn, FTLastUpdBy)VALUES ('00018','2','1','EXPT','1','00003','','','','','2021-09-27 10:45:17','','2021-09-27 10:45:17','')
	INSERT INTO TCNMTxnAPI_L (FTApiCode, FNLngID, FTApiName, FTApiRmk) VALUES ('00018','1','ส่งออกรายการขาย (ใบกำกับภาษีเต็มรูป/ใบลดหนี้)','')
	UPDATE TCNMTxnAPI SET FNApiGrpSeq = 3 WHERE FTApiCode = '00013'
	UPDATE TCNMTxnAPI SET FNApiGrpSeq = 2 WHERE FTApiCode = '00014'
	UPDATE TCNMTxnAPI SET FNApiGrpSeq = 0 WHERE FTApiCode = '00012'

INSERT INTO [TCNTUpgradeHisTmp] ([FTUphVersion], [FDCreateOn], [FTUphRemark], [FTCreateBy]) VALUES ( '00.00.02', getdate() , 'เพิ่ม APICode 00018 ส่งออกรายการขาย (ใบกำกับภาษีเต็มรูป/ใบลดหนี้)', 'Napat');
END
GO

IF NOT EXISTS(SELECT FTUphVersion FROM TCNTUpgradeHisTmp WHERE FTUphVersion=  '00.00.03') BEGIN

	--Update By : Napat 28/09/2021
	--เคลียร์/อัพเดท ตาราง API_L
	DELETE FROM TCNMTxnAPI WHERE FTApiCode='00018'
	DELETE FROM TCNMTxnAPI_L WHERE FTApiCode='00018'

	INSERT INTO TCNMTxnAPI (FTApiCode, FTApiTxnType, FTApiPrcType, FTApiGrpPrc, FNApiGrpSeq, FTApiFmtCode, FTApiURL, FTApiLoginUsr, FTApiLoginPwd, FTApiToken, FDCreateOn, FTCreateBy, FDLastUpdOn, FTLastUpdBy)VALUES ('00018','2','1','EXPT','1','00003','','','','','2021-09-27 10:45:17','','2021-09-27 10:45:17','')
	INSERT INTO TCNMTxnAPI_L (FTApiCode, FNLngID, FTApiName, FTApiRmk) VALUES ('00018','1','ส่งออกรายการขาย (ใบกำกับภาษีเต็มรูป/ใบลดหนี้)','')

	UPDATE TCNMTxnAPI_L SET FTApiName='นำเข้าสินค้า & ระดับหมวดหมู่' WHERE FTApiCode = '00001'
	UPDATE TCNMTxnAPI_L SET FTApiName='เอกสารใบปรับราคา' WHERE FTApiCode = '00003'
	UPDATE TCNMTxnAPI_L SET FTApiName='API ขอข้อมูล token เพื่อใช้ส่งใน eTax(iNET)ทุกเส้น' WHERE FTApiCode = '00004'
	UPDATE TCNMTxnAPI_L SET FTApiName='API ส่งข้อมูล ABB/CN-ABB' WHERE FTApiCode = '00005'
	UPDATE TCNMTxnAPI_L SET FTApiName='API Download ABB/CN-ABB' WHERE FTApiCode = '00006'
	UPDATE TCNMTxnAPI_L SET FTApiName='API ส่งข้อมูล FULL Tax/CN-FULL' WHERE FTApiCode = '00007'
	UPDATE TCNMTxnAPI_L SET FTApiName='API Download FULL Tax/CN-FULL' WHERE FTApiCode = '00008'
	UPDATE TCNMTxnAPI_L SET FTApiName='API SAP Arinvoice (ขายOffline)' WHERE FTApiCode = '00009'
	UPDATE TCNMTxnAPI_L SET FTApiName='API SAP (ปิดรอบสิ้นวัน)' WHERE FTApiCode = '00010'
	UPDATE TCNMTxnAPI_L SET FTApiName='API SAP Refund' WHERE FTApiCode = '00011'
	UPDATE TCNMTxnAPI_L SET FTApiName='ส่งออกรายการขาย' WHERE FTApiCode = '00012'
	UPDATE TCNMTxnAPI_L SET FTApiName='ส่งออกรายการคืน' WHERE FTApiCode = '00013'
	UPDATE TCNMTxnAPI_L SET FTApiName='ข้อมูลยอดขายรายวัน (ปิดสิ้นวัน)' WHERE FTApiCode = '00014'
	UPDATE TCNMTxnAPI_L SET FTApiName='API SAP Credit Memo (ใบคืน)' WHERE FTApiCode = '00015'
	UPDATE TCNMTxnAPI_L SET FTApiName='API SAP Ar Reserve (ขายOnline)' WHERE FTApiCode = '00016'
	UPDATE TCNMTxnAPI_L SET FTApiName='API SAP Token' WHERE FTApiCode = '00017'
	UPDATE TCNMTxnAPI_L SET FTApiName='ส่งออกรายการขาย (ใบกำกับภาษีเต็มรูป/ใบลดหนี้)' WHERE FTApiCode = '00018'

	--Update By : Chaiya 28/09/2021 11:00
	--เพิ่มข้อมูล Seller Email
	INSERT INTO TLKMConfig(FTCfgCode,FTCfgApp,FTCfgKey,FTCfgSeq,FTGmnCode,FTCfgStaAlwEdit,FTCfgStaDataType,FNCfgMaxLength,FTCfgStaDefValue,FTCfgStaDefRef,FTCfgStaUsrValue,FTCfgStaUsrRef,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
	VALUES('tLK_MailSeller','LINK','Center','1','POS','1','0','100','etax@firster.com','','','','2021-09-28 03:44:14.000','00003','2020-09-28 00:00:00.000','Chaiya B.')

	INSERT INTO TLKMConfig_L(FTCfgCode,FTCfgApp,FTCfgKey,FTCfgSeq,FNLngID,FTCfgName,FTCfgDesc,FTCfgRmk)
	VALUES('tLK_MailSeller','LINK','Center','1','1','Email สำหรับ seller','','')

INSERT INTO [TCNTUpgradeHisTmp] ([FTUphVersion], [FDCreateOn], [FTUphRemark], [FTCreateBy]) VALUES ( '00.00.03', getdate() , 'เพิ่มข้อมูล Seller Email', 'Chaiya');
END
GO

IF NOT EXISTS(SELECT FTUphVersion FROM TCNTUpgradeHisTmp WHERE FTUphVersion=  '00.00.04') BEGIN
	UPDATE  TLKMConfig_l SET FTCfgName = 'SMTP Server' WHERE FTCfgCode = 'tLK_SMTPUsr'
	UPDATE  TLKMConfig_l SET FTCfgName = 'SMTP User/Sender' WHERE FTCfgCode = 'tLK_MailSender'
	UPDATE  TLKMConfig_l SET FTCfgKey = 'Mail' WHERE FTCfgCode = 'tLK_SMTPPort'
	UPDATE  TLKMConfig_l SET FTCfgKey = 'Mail' WHERE FTCfgCode = 'tLK_SMTPPwd'
	UPDATE  TLKMConfig_l SET FTCfgKey = 'Mail' WHERE FTCfgCode = 'tLK_SMTPUsr'

	UPDATE  TLKMConfig SET FTCfgKey = 'Mail' WHERE FTCfgCode = 'tLK_SMTPPort'
	UPDATE  TLKMConfig SET FTCfgKey = 'Mail' WHERE FTCfgCode = 'tLK_SMTPPwd'
	UPDATE  TLKMConfig SET FTCfgKey = 'Mail' WHERE FTCfgCode = 'tLK_SMTPUsr'

	Delete TLKMConfig Where FTCfgCode = 'tLK_ImportDefPwd'
	Delete TLKMConfig Where FTCfgCode = 'tLK_ImportDefRole'
INSERT INTO [TCNTUpgradeHisTmp] ([FTUphVersion], [FDCreateOn], [FTUphRemark], [FTCreateBy]) VALUES ( '00.00.04', getdate() , 'Update Config Mail', 'Chaiya');
END
GO

IF NOT EXISTS(SELECT FTUphVersion FROM TCNTUpgradeHisTmp WHERE FTUphVersion=  '00.00.05') BEGIN
	UPDATE TSysMenuList SET FNMnuSeq = 2 WHERE FTMnuCode = 'TXO011'
	UPDATE TSysMenuList SET FNMnuSeq = 3 WHERE FTMnuCode = 'TXO007'
	UPDATE TSysMenuList SET FNMnuSeq = 4 WHERE FTMnuCode = 'TXO008'
	UPDATE TSysMenuList SET FNMnuSeq = 5 WHERE FTMnuCode = 'PDM002'
	UPDATE TSysMenuList SET FNMnuSeq = 6 WHERE FTMnuCode = 'TXO009'

	INSERT INTO TSysMenuAlbAct (FTMnuCode, FTAutStaRead, FTAutStaAdd, FTAutStaEdit, FTAutStaDelete, FTAutStaCancel, FTAutStaAppv, FTAutStaPrint, FTAutStaPrintMore)
	VALUES ('TBD001','1','1','1','1','1','1','1','1')

	INSERT INTO TSysMenuList (FTGmnCode, FTMnuParent, FTMnuCode, FTLicPdtCode, FNMnuSeq, FTMnuCtlName, FNMnuLevel, FTMnuStaPosHpm, FTMnuStaPosFhn, FTMnuStaSmartHpm, FTMnuStaSmartFhn, FTMnuStaMoreHpm, FTMnuStaMoreFhn, 
							FTMnuType, FTMnuStaAPIPos, FTMnuStaAPISmart, FTMnuStaUse, FTMnuPath, FTGmnModCode, FTMnuImgPath)
	VALUES ('ICB','ICB','TBD001','SB-TBD001','1','docTRB/0/0','1','Y','Y','Y','Y','Y','Y','1','Y','Y','1','','IC','')

	INSERT INTO TSysMenuList_L (FTMnuCode, FNLngID, FTMnuName, FTMnuRmk)
	VALUES ('TBD001',1,'ใบขอโอน - สาขา','')

	INSERT INTO TCNTUsrMenu (FTRolCode, FTGmnCode, FTMnuParent, FTMnuCode, FTAutStaFull, FTAutStaRead, FTAutStaAdd, FTAutStaEdit, FTAutStaDelete, FTAutStaCancel, FTAutStaAppv, FTAutStaPrint, FTAutStaPrintMore, FTAutStaFavorite, FDLastUpdOn, 
							FTLastUpdBy, FDCreateOn, FTCreateBy)
	VALUES ('00003','ICB','ICB','TBD001','0','1','1','1','1','1','1','1','1','0','2021-11-22 21:41:20.000','Admin','2021-11-22 21:41:20.000','Admin')

	INSERT INTO TSysRsnGrp_L (FTRsgCode, FNLngID, FTRsgName, FTRsgRmk)
	VALUES ('016','1','การโอนสินค้า','NULL')

	INSERT INTO TCNTAuto (FTSatTblName, FTSatFedCode, FTSatStaDocType, FTSatGroup, FTGmnCode, FTSatDocTypeName, FTSatStaAlwChr, FTSatStaAlwBch, FTSatStaAlwPosShp, FTSatStaAlwYear, FTSatStaAlwMonth, FTSatStaAlwDay, FTSatStaAlwSep, 
                         FTSatStaDefUsage, FTSatDefChar, FTSatDefBch, FTSatDefPosShp, FTSatDefYear, FTSatDefMonth, FTSatDefDay, FTSatDefSep, FTSatDefNum, FTSatDefFmtAll, FNSatMaxFedSize, FNSatMinRunning, FTSatUsrChar, FTSatUsrBch, 
                         FTSatUsrPosShp, FTSatUsrYear, FTSatUsrMonth, FTSatUsrDay, FTSatUsrSep, FTSatUsrNum, FTSatUsrFmtAll, FTSatStaReset, FTSatStaRunBch, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
	VALUES ('TCNTPdtReqBchHD','FTXthDocNo','13','2','XPDT','','1','1','0','0','0','0','1','0','TR','1','0','1','0','0','0','000001','TRBCHYY######','20','5','TR','1','0','1','0','0','0','000001','TRBCHYY######','4','0','2020-12-23 00:00:00.000','','2020-12-23 00:00:00.000','')

	INSERT [dbo].[TCNSNoti] ([FTNotCode], [FTNotStaResponse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'00000', 1, CAST(N'2021-10-27T18:28:28.000' AS DateTime), N'Nale', CAST(N'2021-10-27T18:29:44.000' AS DateTime), N'Nale')

	INSERT [dbo].[TCNSNoti] ([FTNotCode], [FTNotStaResponse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'00001', 1, CAST(N'2021-10-27T18:28:28.000' AS DateTime), N'Nale', CAST(N'2021-10-27T18:29:44.000' AS DateTime), N'Nale')

	INSERT [dbo].[TCNSNoti] ([FTNotCode], [FTNotStaResponse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'00002', 1, CAST(N'2021-10-27T18:28:28.000' AS DateTime), N'Nale', CAST(N'2021-10-27T18:29:44.000' AS DateTime), N'Nale')

	INSERT [dbo].[TCNSNoti] ([FTNotCode], [FTNotStaResponse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'00003', 1, CAST(N'2021-10-27T18:28:28.000' AS DateTime), N'Nale', CAST(N'2021-10-27T18:29:44.000' AS DateTime), N'Nale')

	INSERT [dbo].[TCNSNoti] ([FTNotCode], [FTNotStaResponse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'00004', 1, CAST(N'2021-10-27T18:28:28.000' AS DateTime), N'Nale', CAST(N'2021-10-27T18:29:44.000' AS DateTime), N'Nale')

	INSERT [dbo].[TCNSNoti] ([FTNotCode], [FTNotStaResponse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'00005', 1, CAST(N'2021-10-27T18:28:28.000' AS DateTime), N'Nale', CAST(N'2021-10-27T18:29:44.000' AS DateTime), N'Nale')

	INSERT [dbo].[TCNSNoti] ([FTNotCode], [FTNotStaResponse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'00006', 1, CAST(N'2021-10-27T18:28:28.000' AS DateTime), N'Nale', CAST(N'2021-10-27T18:29:44.000' AS DateTime), N'Nale')

	INSERT [dbo].[TCNSNoti] ([FTNotCode], [FTNotStaResponse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'00007', 1, CAST(N'2021-10-27T18:28:28.000' AS DateTime), N'Nale', CAST(N'2021-10-27T18:29:44.000' AS DateTime), N'Nale')

	INSERT [dbo].[TCNSNoti] ([FTNotCode], [FTNotStaResponse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'00008', 1, CAST(N'2021-10-27T18:28:28.000' AS DateTime), N'Nale', CAST(N'2021-10-27T18:29:44.000' AS DateTime), N'Nale')

	INSERT [dbo].[TCNSNoti] ([FTNotCode], [FTNotStaResponse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'00009', 1, CAST(N'2021-10-27T18:28:28.000' AS DateTime), N'Nale', CAST(N'2021-10-27T18:29:44.000' AS DateTime), N'Nale')

	INSERT [dbo].[TCNSNoti] ([FTNotCode], [FTNotStaResponse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'00010', 1, CAST(N'2021-10-27T18:28:28.000' AS DateTime), N'Nale', CAST(N'2021-10-27T18:29:44.000' AS DateTime), N'Nale')

	INSERT [dbo].[TCNSNoti] ([FTNotCode], [FTNotStaResponse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'00011', 1, CAST(N'2021-10-27T18:28:28.000' AS DateTime), N'Nale', CAST(N'2021-10-27T18:29:44.000' AS DateTime), N'Nale')

	INSERT [dbo].[TCNSNoti_L] ([FTNotCode], [FNLngID], [FTNotTypeName], [FTNotRmk]) VALUES (N'00000', 1, N'ข่าวสาร', N'')

	INSERT [dbo].[TCNSNoti_L] ([FTNotCode], [FNLngID], [FTNotTypeName], [FTNotRmk]) VALUES (N'00001', 1, N'ใบสั่งสินค้าจากสาขา', NULL)

	INSERT [dbo].[TCNSNoti_L] ([FTNotCode], [FNLngID], [FTNotTypeName], [FTNotRmk]) VALUES (N'00002', 1, N'ใบขอซื้อผู้จำหน่าย', N'')

	INSERT [dbo].[TCNSNoti_L] ([FTNotCode], [FNLngID], [FTNotTypeName], [FTNotRmk]) VALUES (N'00003', 1, N'ใบสั่งซื้อ', N'')

	INSERT [dbo].[TCNSNoti_L] ([FTNotCode], [FNLngID], [FTNotTypeName], [FTNotRmk]) VALUES (N'00004', 1, N'ใบเคลม', N'')

	INSERT [dbo].[TCNSNoti_L] ([FTNotCode], [FNLngID], [FTNotTypeName], [FTNotRmk]) VALUES (N'00005', 1, N'ตรวจนับยืนยันสินค้าคงคลัง', NULL)

	INSERT [dbo].[TCNSNoti_L] ([FTNotCode], [FNLngID], [FTNotTypeName], [FTNotRmk]) VALUES (N'00006', 1, N'ตรวจนับย่อยสินค้าคงคลัง', N'')

	INSERT [dbo].[TCNSNoti_L] ([FTNotCode], [FNLngID], [FTNotTypeName], [FTNotRmk]) VALUES (N'00007', 1, N'ตรวจนับรวมสินค้าคงคลัง', N'')

	INSERT [dbo].[TCNSNoti_L] ([FTNotCode], [FNLngID], [FTNotTypeName], [FTNotRmk]) VALUES (N'00008', 1, N'ใบจ่ายโอนสาขา', N'')

	INSERT [dbo].[TCNSNoti_L] ([FTNotCode], [FNLngID], [FTNotTypeName], [FTNotRmk]) VALUES (N'00009', 1, N'ใบจ่ายรับโอน', N'')

	INSERT [dbo].[TCNSNoti_L] ([FTNotCode], [FNLngID], [FTNotTypeName], [FTNotRmk]) VALUES (N'00010', 1, N'ใบขอโอน', N'')

	INSERT [dbo].[TCNSNoti_L] ([FTNotCode], [FNLngID], [FTNotTypeName], [FTNotRmk]) VALUES (N'00011', 1, N'ใบรับของ', N'')

	INSERT INTO TSysMenuGrpModule (FTGmnModCode, FNGmnModShwSeq, FTGmnModStaUse, FTGmmModPathIcon, FTGmmModColorBtn)
	VALUES ('NEW','9','1','/application/modules/common/assets/images/iconsmenu/new.png','NULL')
	INSERT INTO TSysMenuGrpModule_L (FTGmnModCode, FTGmnModName, FNLngID) VALUES ('NEW','ตรวจสอบและแจ้งเตือน','1')

	UPDATE TSysConfig SET FTSysStaAlwEdit = '0',FTSysStaDefValue = '0', FTSysStaUsrValue = '0' WHERE FTSysCode = 'bCN_AlwChkPdtSN' AND FTSysApp = 'CN' AND FTSysKey = 'Product'

	INSERT INTO TCNTAuto (FTSatTblName, FTSatFedCode, FTSatStaDocType, FTSatGroup, FTGmnCode, FTSatDocTypeName, FTSatStaAlwChr, FTSatStaAlwBch, FTSatStaAlwPosShp, FTSatStaAlwYear, FTSatStaAlwMonth, FTSatStaAlwDay, FTSatStaAlwSep, 
							FTSatStaDefUsage, FTSatDefChar, FTSatDefBch, FTSatDefPosShp, FTSatDefYear, FTSatDefMonth, FTSatDefDay, FTSatDefSep, FTSatDefNum, FTSatDefFmtAll, FNSatMaxFedSize, FNSatMinRunning, FTSatUsrChar, FTSatUsrBch, 
							FTSatUsrPosShp, FTSatUsrYear, FTSatUsrMonth, FTSatUsrDay, FTSatUsrSep, FTSatUsrNum, FTSatUsrFmtAll, FTSatStaReset, FTSatStaRunBch, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
	VALUES ('TCNMPrnServer','FTSrvCode','0','1','MPDT','','0','0','0','0','0','0','0','0','','0','0','0','0','0','0','00001','#####','10','5','','0','0','0','0','0','0','00001','#####','','0','2021-12-20 00:00:00.000','','2021-12-20 00:00:00.000','')

	INSERT INTO TCNTAuto_L (FTSatTblName, FTSatFedCode, FTSatStaDocType, FNLngID, FTSatTblDesc, FTSatRmk)
	VALUES ('TCNMPrnServer','FTSrvCode','0','1','ปริ้นเตอร์เซิฟเวอร์','')

	INSERT INTO TCNTAuto (FTSatTblName, FTSatFedCode, FTSatStaDocType, FTSatGroup, FTGmnCode, FTSatDocTypeName, FTSatStaAlwChr, FTSatStaAlwBch, FTSatStaAlwPosShp, FTSatStaAlwYear, FTSatStaAlwMonth, FTSatStaAlwDay, FTSatStaAlwSep, 
							FTSatStaDefUsage, FTSatDefChar, FTSatDefBch, FTSatDefPosShp, FTSatDefYear, FTSatDefMonth, FTSatDefDay, FTSatDefSep, FTSatDefNum, FTSatDefFmtAll, FNSatMaxFedSize, FNSatMinRunning, FTSatUsrChar, FTSatUsrBch, 
							FTSatUsrPosShp, FTSatUsrYear, FTSatUsrMonth, FTSatUsrDay, FTSatUsrSep, FTSatUsrNum, FTSatUsrFmtAll, FTSatStaReset, FTSatStaRunBch, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
	VALUES ('TCNMPrnLabel','FTPlbCode','0','1','MPDT','','0','0','0','0','0','0','0','0','','0','0','0','0','0','0','00001','#####','10','5','','0','0','0','0','0','0','00001','#####','','0','2021-12-20 00:00:00.000','','2021-12-20 00:00:00.000','')

	INSERT INTO TCNTAuto_L (FTSatTblName, FTSatFedCode, FTSatStaDocType, FNLngID, FTSatTblDesc, FTSatRmk)
	VALUES ('TCNMPrnLabel','FTPlbCode','0','1','รูปแบบการพิมพ์','')

	/*สินค้าคงคลัง > จัดการ*/
	INSERT INTO TSysMenuGrp (FTGmnCode, FNGmnShwSeq, FTGmnStaUse, FTGmnModCode)
	VALUES ('MAN','6','1','IC')

	INSERT INTO TSysMenuGrp_L (FTGmnCode, FNLngID, FTGmnName, FTGmnSystem)
	VALUES ('MAN','1','จัดการ','IC')

	INSERT INTO TSysMenuList (FTGmnCode, FTMnuParent, FTMnuCode, FTLicPdtCode, FNMnuSeq, FTMnuCtlName, FNMnuLevel, FTMnuStaPosHpm, FTMnuStaPosFhn, FTMnuStaSmartHpm, FTMnuStaSmartFhn, FTMnuStaMoreHpm, FTMnuStaMoreFhn, 
	FTMnuType, FTMnuStaAPIPos, FTMnuStaAPISmart, FTMnuStaUse, FTMnuPath, FTGmnModCode, FTMnuImgPath)
	VALUES ('MAN','MAN','MAN001','SB-ICMAN001','1','docPAM/0/0','1','Y','Y','Y','Y','Y','Y','1','Y','Y','1',' ','IC',' ')

	INSERT INTO TSysMenuList_L (FTMnuCode, FNLngID, FTMnuName, FTMnuRmk)
	VALUES ('MAN001','1','จัดการใบจัดสินค้า','')

	INSERT INTO TCNTUsrMenu (FTRolCode, FTGmnCode, FTMnuParent, FTMnuCode, FTAutStaFull, FTAutStaRead, FTAutStaAdd, FTAutStaEdit, FTAutStaDelete, FTAutStaCancel, FTAutStaAppv, FTAutStaPrint, FTAutStaPrintMore, FTAutStaFavorite, FDLastUpdOn, 
	FTLastUpdBy, FDCreateOn, FTCreateBy)
	VALUES ('00003','MAN','MAN','MAN001','0','1','1','1','1','1','1','1','1','1','2022-01-17 21:15:03.000','00003','2022-01-17 21:15:03.000','00003')

	INSERT INTO TSysMenuAlbAct (FTMnuCode, FTAutStaRead, FTAutStaAdd, FTAutStaEdit, FTAutStaDelete, FTAutStaCancel, FTAutStaAppv, FTAutStaPrint, FTAutStaPrintMore)
	VALUES ('MAN001','1','1','1','1','1','1','1','1')

	/*สินค้าคงคลัง > ตรวจสอบ*/
	INSERT INTO TSysMenuGrp (FTGmnCode, FNGmnShwSeq, FTGmnStaUse, FTGmnModCode)
	VALUES ('CHK','7','1','IC')

	INSERT INTO TSysMenuGrp_L (FTGmnCode, FNLngID, FTGmnName, FTGmnSystem)
	VALUES ('CHK','1','ตรวจสอบ','IC')

	INSERT INTO TSysMenuList (FTGmnCode, FTMnuParent, FTMnuCode, FTLicPdtCode, FNMnuSeq, FTMnuCtlName, FNMnuLevel, FTMnuStaPosHpm, FTMnuStaPosFhn, FTMnuStaSmartHpm, FTMnuStaSmartFhn, FTMnuStaMoreHpm, FTMnuStaMoreFhn, 
	FTMnuType, FTMnuStaAPIPos, FTMnuStaAPISmart, FTMnuStaUse, FTMnuPath, FTGmnModCode, FTMnuImgPath)
	VALUES ('CHK','CHK','CHK001','SB-ICCHK001','1','monSDT/0/0','1','Y','Y','Y','Y','Y','Y','1','Y','Y','1',' ','IC',' ')

	INSERT INTO TSysMenuList_L (FTMnuCode, FNLngID, FTMnuName, FTMnuRmk)
	VALUES ('CHK001','1','ตรวจสอบสถานะเอกสารโอน','')

	INSERT INTO TCNTUsrMenu (FTRolCode, FTGmnCode, FTMnuParent, FTMnuCode, FTAutStaFull, FTAutStaRead, FTAutStaAdd, FTAutStaEdit, FTAutStaDelete, FTAutStaCancel, FTAutStaAppv, FTAutStaPrint, FTAutStaPrintMore, FTAutStaFavorite, FDLastUpdOn, 
	FTLastUpdBy, FDCreateOn, FTCreateBy)
	VALUES ('00003','CHK','CHK','CHK001','0','1','1','1','1','1','1','1','1','1','2022-01-17 21:15:03.000','00003','2022-01-17 21:15:03.000','00003')

	INSERT INTO TSysMenuAlbAct (FTMnuCode, FTAutStaRead, FTAutStaAdd, FTAutStaEdit, FTAutStaDelete, FTAutStaCancel, FTAutStaAppv, FTAutStaPrint, FTAutStaPrintMore)
	VALUES ('CHK001','1','1','1','1','1','1','1','1')

	OPEN SYMMETRIC KEY AdaLicProtectSmtKey 
	DECRYPTION BY CERTIFICATE AdaLicProtectCer
		INSERT INTO TRGSMenuLic (FTLicCode, FTLicStartFinish, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
		VALUES ('SB-TBD001',EncryptByKey(Key_GUID('AdaLicProtectSmtKey'), '89620ad0a461;SB-TBD001;2021-01-01;2023-01-01') ,'2022-10-17 18:39:41.240','AutoLic','2022-10-17 18:39:41.240','AutoLic')

		INSERT INTO TRGSMenuLic (FTLicCode, FTLicStartFinish, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
		VALUES ('SB-ICCHK001',EncryptByKey(Key_GUID('AdaLicProtectSmtKey'), '89620ad0a461;SB-ICCHK001;2021-01-01;2023-01-01') ,'2022-10-17 18:39:41.240','AutoLic','2022-10-17 18:39:41.240','AutoLic')

		INSERT INTO TRGSMenuLic (FTLicCode, FTLicStartFinish, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
		VALUES ('SB-ICMAN001',EncryptByKey(Key_GUID('AdaLicProtectSmtKey'), '89620ad0a461;SB-ICMAN001;2021-01-01;2023-01-01') ,'2022-10-17 18:39:41.240','AutoLic','2022-10-17 18:39:41.240','AutoLic')
	CLOSE SYMMETRIC KEY AdaLicProtectSmtKey

	INSERT INTO TSysPortPrn (FTSppCode,FTSppValue,FTSppRef,FTSppType,FTSppStaUse,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
	VALUES('WSP-R341','0','2','PRN','1','2022-01-12','','2022-01-12','')

	INSERT INTO TSysPortPrn_L (FTSppCode,FNLngID,FTSppName)
	VALUES('WSP-R341',1,'Woosim R341')

	INSERT INTO TSysPortPrn_L (FTSppCode,FNLngID,FTSppName)
	VALUES('WSP-R341',2,'Woosim R341')

	INSERT INTO TSysConfig (FTSysCode,FTSysApp,FTSysKey,FTSysSeq,FTGmnCode,FTSysStaAlwEdit,FTSysStaDataType,FNSysMaxLength,FTSysStaDefValue,FTSysStaDefRef,FTSysStaUsrValue,FTSysStaUsrRef,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
	VALUES ('bCN_CondSplitDoc','CN','TCNTPdtPickHD','0','MPOS','0','4','1','2','','2','','2022-01-10 00:00:00.000','Napat','2022-01-10 00:00:00.000','Napat')

	INSERT INTO TSysConfig (FTSysCode,FTSysApp,FTSysKey,FTSysSeq,FTGmnCode,FTSysStaAlwEdit,FTSysStaDataType,FNSysMaxLength,FTSysStaDefValue,FTSysStaDefRef,FTSysStaUsrValue,FTSysStaUsrRef,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
	VALUES ('bCN_CondSplitDoc','CN','TCNTPdtPickHD','1','MPOS','0','4','1','2','','2','','2022-01-10 00:00:00.000','Napat','2022-01-10 00:00:00.000','Napat')

	INSERT INTO TSysConfig (FTSysCode,FTSysApp,FTSysKey,FTSysSeq,FTGmnCode,FTSysStaAlwEdit,FTSysStaDataType,FNSysMaxLength,FTSysStaDefValue,FTSysStaDefRef,FTSysStaUsrValue,FTSysStaUsrRef,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
	VALUES ('bCN_CondSplitDoc','CN','TCNTPdtPickHD','2','MPOS','0','4','1','2','','2','','2022-01-10 00:00:00.000','Napat','2022-01-10 00:00:00.000','Napat')

	INSERT INTO TSysConfig (FTSysCode,FTSysApp,FTSysKey,FTSysSeq,FTGmnCode,FTSysStaAlwEdit,FTSysStaDataType,FNSysMaxLength,FTSysStaDefValue,FTSysStaDefRef,FTSysStaUsrValue,FTSysStaUsrRef,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
	VALUES ('bCN_CondSplitDoc','CN','TCNTPdtPickHD','3','MPOS','0','4','1','2','','2','','2022-01-10 00:00:00.000','Napat','2022-01-10 00:00:00.000','Napat')

	INSERT INTO TSysConfig (FTSysCode,FTSysApp,FTSysKey,FTSysSeq,FTGmnCode,FTSysStaAlwEdit,FTSysStaDataType,FNSysMaxLength,FTSysStaDefValue,FTSysStaDefRef,FTSysStaUsrValue,FTSysStaUsrRef,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
	VALUES ('bCN_CondSplitDoc','CN','TCNTPdtPickHD','4','MPOS','0','4','1','2','','2','','2022-01-10 00:00:00.000','Napat','2022-01-10 00:00:00.000','Napat')

	INSERT INTO TSysConfig (FTSysCode,FTSysApp,FTSysKey,FTSysSeq,FTGmnCode,FTSysStaAlwEdit,FTSysStaDataType,FNSysMaxLength,FTSysStaDefValue,FTSysStaDefRef,FTSysStaUsrValue,FTSysStaUsrRef,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
	VALUES ('bCN_CondSplitDoc','CN','TCNTPdtPickHD','5','MPOS','0','4','1','2','','2','','2022-01-10 00:00:00.000','Napat','2022-01-10 00:00:00.000','Napat')

	INSERT INTO TSysConfig_L (FTSysCode,FTSysApp,FTSysKey,FTSysSeq,FNLngID,FTSysName,FTSysDesc,FTSysRmk)
	VALUES ('bCN_CondSplitDoc','CN','TCNTPdtPickHD','0','1','สร้างใบจัดตามที่เก็บ','1 : เลือก, 2 : ไม่เลือก','')

	INSERT INTO TSysConfig_L (FTSysCode,FTSysApp,FTSysKey,FTSysSeq,FNLngID,FTSysName,FTSysDesc,FTSysRmk)
	VALUES ('bCN_CondSplitDoc','CN','TCNTPdtPickHD','1','1','สร้างใบจัดตามหมวดสินค้า 1','1 : เลือก, 2 : ไม่เลือก','')

	INSERT INTO TSysConfig_L (FTSysCode,FTSysApp,FTSysKey,FTSysSeq,FNLngID,FTSysName,FTSysDesc,FTSysRmk)
	VALUES ('bCN_CondSplitDoc','CN','TCNTPdtPickHD','2','1','สร้างใบจัดตามหมวดสินค้า 2','1 : เลือก, 2 : ไม่เลือก','')

	INSERT INTO TSysConfig_L (FTSysCode,FTSysApp,FTSysKey,FTSysSeq,FNLngID,FTSysName,FTSysDesc,FTSysRmk)
	VALUES ('bCN_CondSplitDoc','CN','TCNTPdtPickHD','3','1','สร้างใบจัดตามหมวดสินค้า 3','1 : เลือก, 2 : ไม่เลือก','')

	INSERT INTO TSysConfig_L (FTSysCode,FTSysApp,FTSysKey,FTSysSeq,FNLngID,FTSysName,FTSysDesc,FTSysRmk)
	VALUES ('bCN_CondSplitDoc','CN','TCNTPdtPickHD','4','1','สร้างใบจัดตามหมวดสินค้า 4','1 : เลือก, 2 : ไม่เลือก','')

	INSERT INTO TSysConfig_L (FTSysCode,FTSysApp,FTSysKey,FTSysSeq,FNLngID,FTSysName,FTSysDesc,FTSysRmk)
	VALUES ('bCN_CondSplitDoc','CN','TCNTPdtPickHD','5','1','สร้างใบจัดตามหมวดสินค้า 5','1 : เลือก, 2 : ไม่เลือก','')

	UPDATE TCNTUrlObject SET FTUrlAddress = 'https://dev.ada-soft.com:44340/AdaLicense/API2CNAda' 
	WHERE FTUrlKey = 'REG' AND FTUrlTable = 'TCNMComp' AND FTUrlRefID = 'CENTER'

	UPDATE TCNTUrlObject SET FTUrlAddress = 'https://dev.ada-soft.com/AdaPos5StoreBackLicense/SoftwareLicenseAgreement' 
	WHERE FTUrlKey = 'SLA' AND FTUrlTable = 'TCNMComp' AND FTUrlRefID = 'CENTER'

	UPDATE TCNTUrlObject SET FTUrlAddress = 'https://dev.ada-soft.com/AdaPos5StoreBackLicense/SoftwarePrivacyAgreement' 
	WHERE FTUrlKey = 'PAPD' AND FTUrlTable = 'TCNMComp' AND FTUrlRefID = 'CENTER'

	INSERT INTO TCNMTxnAPI (FTApiCode,FTApiTxnType,FTApiPrcType,FTApiGrpPrc,FNApiGrpSeq,FTApiFmtCode,FTApiURL,FTApiLoginUsr,FTApiLoginPwd,FTApiToken,FDCreateOn,FTCreateBy,FDLastUpdOn,FTLastUpdBy)
	VALUES ('00040','2','2','EXPT','11','00004','','','','','2022-01-01 00:00:00.000','CHAIYA BOONTEM','2022-01-01 00:00:00.000','CHAIYA BOONTEM')

	INSERT INTO TCNMTxnAPI (FTApiCode,FTApiTxnType,FTApiPrcType,FTApiGrpPrc,FNApiGrpSeq,FTApiFmtCode,FTApiURL,FTApiLoginUsr,FTApiLoginPwd,FTApiToken,FDCreateOn,FTCreateBy,FDLastUpdOn,FTLastUpdBy)
	VALUES ('00041','2','2','EXPT','12','00004','','','','','2022-01-01 00:00:00.000','CHAIYA BOONTEM','2022-01-01 00:00:00.000','CHAIYA BOONTEM')

	INSERT INTO TCNMTxnAPI_L (FTApiCode,FNLngID,FTApiName,FTApiRmk)
	VALUES ('00040','1','ส่งออก Member - Earn/Burn Point(Sale)','NULL')

	INSERT INTO TCNMTxnAPI_L (FTApiCode,FNLngID,FTApiName,FTApiRmk)
	VALUES ('00041','1','ส่งออก  Earn/Burn Point(Return)','NULL')

INSERT INTO [TCNTUpgradeHisTmp] ([FTUphVersion], [FDCreateOn], [FTUphRemark], [FTCreateBy]) VALUES ( '00.00.05', getdate() , 'KPC เฟส2', 'Napat');
END
GO

IF NOT EXISTS(SELECT FTUphVersion FROM TCNTUpgradeHisTmp WHERE FTUphVersion=  '00.00.06') BEGIN

	UPDATE TSysMenuList SET FNMnuSeq = 8 WHERE FTMnuCode = 'ARS011'
	UPDATE TSysMenuList SET FNMnuSeq = 9 WHERE FTMnuCode = 'ARS003'
	UPDATE TSysMenuList SET FNMnuSeq = 20 WHERE FTMnuCode = 'ARS010'

	UPDATE TSysMenuList SET FNMnuSeq = 30 WHERE FTMnuCode = 'ARS006'
	UPDATE TSysMenuList SET FNMnuSeq = 31 WHERE FTMnuCode = 'ARS007'
	UPDATE TSysMenuList SET FNMnuSeq = 32 WHERE FTMnuCode = 'ARS008'
	UPDATE TSysMenuList SET FNMnuSeq = 33 WHERE FTMnuCode = 'ARS009'

	INSERT INTO TSysMenuList (FTGmnCode,FTMnuParent,FTMnuCode,FTLicPdtCode,FNMnuSeq,FTMnuCtlName,FNMnuLevel,FTMnuStaPosHpm,FTMnuStaPosFhn,FTMnuStaSmartHpm,FTMnuStaSmartFhn,FTMnuStaMoreHpm,FTMnuStaMoreFhn,FTMnuType,FTMnuStaAPIPos,FTMnuStaAPISmart,FTMnuStaUse,FTMnuPath,FTGmnModCode,FTMnuImgPath)
	VALUES ('ARS','ARS','ARS012','SB-ARARS012','21','monDO/0/0','1','Y','Y','Y','Y','Y','Y','1','Y','Y','1','','AR','')

	INSERT INTO TSysMenuList_L (FTMnuCode,FNLngID,FTMnuName,FTMnuRmk)
	VALUES ('ARS012','1','ตรวจสอบสถานะใบส่งของ','NULL')

	INSERT INTO TSysMenuAlbAct (FTMnuCode,FTAutStaRead,FTAutStaAdd,FTAutStaEdit,FTAutStaDelete,FTAutStaCancel,FTAutStaAppv,FTAutStaPrint,FTAutStaPrintMore)
	VALUES ('ARS012','1','1','1','1','1','1','1','1')

	INSERT INTO TCNTUsrMenu (FTRolCode,FTGmnCode,FTMnuParent,FTMnuCode,FTAutStaFull,FTAutStaRead,FTAutStaAdd,FTAutStaEdit,FTAutStaDelete,FTAutStaCancel,FTAutStaAppv,FTAutStaPrint,FTAutStaPrintMore,FTAutStaFavorite,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
	VALUES ('00003','ARS','ARS','ARS012','0','1','1','1','1','1','1','1','1','0','2021-12-21 00:56:33.000','00003','2021-12-21 00:56:33.000','00003')

	OPEN SYMMETRIC KEY AdaLicProtectSmtKey 
	DECRYPTION BY CERTIFICATE AdaLicProtectCer
		INSERT INTO TRGSMenuLic (FTLicCode, FTLicStartFinish, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
		VALUES ('SB-ARARS012',EncryptByKey(Key_GUID('AdaLicProtectSmtKey'), '89620ad0a461;SB-ARARS012;2021-01-01;2023-01-01') ,'2022-10-17 18:39:41.240','AutoLic','2022-10-17 18:39:41.240','AutoLic')
	CLOSE SYMMETRIC KEY AdaLicProtectSmtKey

	
	INSERT INTO TSysMenuList (FTGmnCode,FTMnuParent,FTMnuCode,FTLicPdtCode,FNMnuSeq,FTMnuCtlName,FNMnuLevel,FTMnuStaPosHpm,FTMnuStaPosFhn,FTMnuStaSmartHpm,FTMnuStaSmartFhn,FTMnuStaMoreHpm,FTMnuStaMoreFhn,FTMnuType,FTMnuStaAPIPos,FTMnuStaAPISmart,FTMnuStaUse,FTMnuPath,FTGmnModCode,FTMnuImgPath)
	VALUES ('TOL','TOL','TOL001','SB-ADTOL001','10','ServerPrinter/0/0','1','Y','Y','Y','Y','Y','Y','1','Y','Y','1','','AD','')

	INSERT INTO TSysMenuList_L (FTMnuCode,FNLngID,FTMnuName,FTMnuRmk)
	VALUES ('TOL001','1','ปริ้นเตอร์เซิร์ฟเวอร์','NULL')

	INSERT INTO TSysMenuAlbAct (FTMnuCode,FTAutStaRead,FTAutStaAdd,FTAutStaEdit,FTAutStaDelete,FTAutStaCancel,FTAutStaAppv,FTAutStaPrint,FTAutStaPrintMore)
	VALUES ('TOL001','1','1','1','1','0','0','0','0')

	INSERT INTO TCNTUsrMenu (FTRolCode,FTGmnCode,FTMnuParent,FTMnuCode,FTAutStaFull,FTAutStaRead,FTAutStaAdd,FTAutStaEdit,FTAutStaDelete,FTAutStaCancel,FTAutStaAppv,FTAutStaPrint,FTAutStaPrintMore,FTAutStaFavorite,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
	VALUES ('00003','TOL','TOL','TOL001','0','1','1','1','1','0','0','0','0','0','2021-12-21 00:56:33.000','00003','2021-12-21 00:56:33.000','00003')

	OPEN SYMMETRIC KEY AdaLicProtectSmtKey 
	DECRYPTION BY CERTIFICATE AdaLicProtectCer
		INSERT INTO TRGSMenuLic (FTLicCode, FTLicStartFinish, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
		VALUES ('SB-ADTOL001',EncryptByKey(Key_GUID('AdaLicProtectSmtKey'), '89620ad0a461;SB-ADTOL001;2021-01-01;2023-01-01') ,'2022-10-17 18:39:41.240','AutoLic','2022-10-17 18:39:41.240','AutoLic')
	CLOSE SYMMETRIC KEY AdaLicProtectSmtKey


	INSERT INTO TSysMenuList (FTGmnCode,FTMnuParent,FTMnuCode,FTLicPdtCode,FNMnuSeq,FTMnuCtlName,FNMnuLevel,FTMnuStaPosHpm,FTMnuStaPosFhn,FTMnuStaSmartHpm,FTMnuStaSmartFhn,FTMnuStaMoreHpm,FTMnuStaMoreFhn,FTMnuType,FTMnuStaAPIPos,FTMnuStaAPISmart,FTMnuStaUse,FTMnuPath,FTGmnModCode,FTMnuImgPath)
	VALUES ('TOL','TOL','TOL002','SB-ADTOL002','11','LablePrinter/0/0','1','Y','Y','Y','Y','Y','Y','1','Y','Y','1','','AD','')

	INSERT INTO TSysMenuList_L (FTMnuCode,FNLngID,FTMnuName,FTMnuRmk)
	VALUES ('TOL002','1','รูปแบบการพิมพ์','NULL')

	INSERT INTO TSysMenuAlbAct (FTMnuCode,FTAutStaRead,FTAutStaAdd,FTAutStaEdit,FTAutStaDelete,FTAutStaCancel,FTAutStaAppv,FTAutStaPrint,FTAutStaPrintMore)
	VALUES ('TOL002','1','1','1','1','0','0','0','0')

	INSERT INTO TCNTUsrMenu (FTRolCode,FTGmnCode,FTMnuParent,FTMnuCode,FTAutStaFull,FTAutStaRead,FTAutStaAdd,FTAutStaEdit,FTAutStaDelete,FTAutStaCancel,FTAutStaAppv,FTAutStaPrint,FTAutStaPrintMore,FTAutStaFavorite,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
	VALUES ('00003','TOL','TOL','TOL002','0','1','1','1','1','0','0','0','0','0','2021-12-21 00:56:33.000','00003','2021-12-21 00:56:33.000','00003')

	OPEN SYMMETRIC KEY AdaLicProtectSmtKey 
	DECRYPTION BY CERTIFICATE AdaLicProtectCer
		INSERT INTO TRGSMenuLic (FTLicCode, FTLicStartFinish, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
		VALUES ('SB-ADTOL002',EncryptByKey(Key_GUID('AdaLicProtectSmtKey'), '89620ad0a461;SB-ADTOL002;2021-01-01;2023-01-01') ,'2022-10-17 18:39:41.240','AutoLic','2022-10-17 18:39:41.240','AutoLic')
	CLOSE SYMMETRIC KEY AdaLicProtectSmtKey


	INSERT INTO TSysMenuList (FTGmnCode,FTMnuParent,FTMnuCode,FTLicPdtCode,FNMnuSeq,FTMnuCtlName,FNMnuLevel,FTMnuStaPosHpm,FTMnuStaPosFhn,FTMnuStaSmartHpm,FTMnuStaSmartFhn,FTMnuStaMoreHpm,FTMnuStaMoreFhn,FTMnuType,FTMnuStaAPIPos,FTMnuStaAPISmart,FTMnuStaUse,FTMnuPath,FTGmnModCode,FTMnuImgPath)
	VALUES ('TOL','TOL','TOL003','SB-ADTOL003','12','PrintBarCode/0/0','1','Y','Y','Y','Y','Y','Y','1','Y','Y','1','','AD','')

	INSERT INTO TSysMenuList_L (FTMnuCode,FNLngID,FTMnuName,FTMnuRmk)
	VALUES ('TOL003','1','พิมพ์ป้ายราคา','NULL')

	INSERT INTO TSysMenuAlbAct (FTMnuCode,FTAutStaRead,FTAutStaAdd,FTAutStaEdit,FTAutStaDelete,FTAutStaCancel,FTAutStaAppv,FTAutStaPrint,FTAutStaPrintMore)
	VALUES ('TOL003','1','1','1','1','0','0','0','0')

	INSERT INTO TCNTUsrMenu (FTRolCode,FTGmnCode,FTMnuParent,FTMnuCode,FTAutStaFull,FTAutStaRead,FTAutStaAdd,FTAutStaEdit,FTAutStaDelete,FTAutStaCancel,FTAutStaAppv,FTAutStaPrint,FTAutStaPrintMore,FTAutStaFavorite,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
	VALUES ('00003','TOL','TOL','TOL003','0','1','1','1','1','0','0','0','0','0','2021-12-21 00:56:33.000','00003','2021-12-21 00:56:33.000','00003')

	OPEN SYMMETRIC KEY AdaLicProtectSmtKey 
	DECRYPTION BY CERTIFICATE AdaLicProtectCer
		INSERT INTO TRGSMenuLic (FTLicCode, FTLicStartFinish, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
		VALUES ('SB-ADTOL003',EncryptByKey(Key_GUID('AdaLicProtectSmtKey'), '89620ad0a461;SB-ADTOL003;2021-01-01;2023-01-01') ,'2022-10-17 18:39:41.240','AutoLic','2022-10-17 18:39:41.240','AutoLic')
	CLOSE SYMMETRIC KEY AdaLicProtectSmtKey

	UPDATE TSysMenuList SET FTLicPdtCode='SB-STSET003' WHERE FTMnuCode = 'SET003'

	OPEN SYMMETRIC KEY AdaLicProtectSmtKey 
	DECRYPTION BY CERTIFICATE AdaLicProtectCer
		INSERT INTO TRGSMenuLic (FTLicCode, FTLicStartFinish, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
		VALUES ('SB-STSET003',EncryptByKey(Key_GUID('AdaLicProtectSmtKey'), '89620ad0a461;SB-STSET003;2021-01-01;2023-01-01') ,'2022-10-17 18:39:41.240','AutoLic','2022-10-17 18:39:41.240','AutoLic')
	CLOSE SYMMETRIC KEY AdaLicProtectSmtKey

INSERT INTO [TCNTUpgradeHisTmp] ([FTUphVersion], [FDCreateOn], [FTUphRemark], [FTCreateBy]) VALUES ( '00.00.06', getdate() , 'Deploy SIT #2', 'Napat');
END
GO

IF NOT EXISTS(SELECT FTUphVersion FROM TCNTUpgradeHisTmp WHERE FTUphVersion=  '00.00.07') BEGIN

	INSERT INTO TSysMenuGrp (FTGmnCode,FNGmnShwSeq,FTGmnStaUse,FTGmnModCode)
	VALUES ('TOL','1','1','AD')

	INSERT INTO TSysMenuGrp_L (FTGmnCode,FNLngID,FTGmnName,FTGmnSystem)
	VALUES ('TOL','1','เครื่องมือ','AD')

	INSERT INTO TCNTUsrMenu (FTRolCode,FTGmnCode,FTMnuParent,FTMnuCode,FTAutStaFull,FTAutStaRead,FTAutStaAdd,FTAutStaEdit,FTAutStaDelete,FTAutStaCancel,FTAutStaAppv,FTAutStaPrint,FTAutStaPrintMore,FTAutStaFavorite,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
	VALUES ('00003','SVD','SVD','SVD001','0','1','1','1','1','0','0','0','0','0','2020-12-10 18:28:18.000','00001','2020-12-10 18:28:18.000','00001')

	INSERT INTO TCNTUsrMenu (FTRolCode,FTGmnCode,FTMnuParent,FTMnuCode,FTAutStaFull,FTAutStaRead,FTAutStaAdd,FTAutStaEdit,FTAutStaDelete,FTAutStaCancel,FTAutStaAppv,FTAutStaPrint,FTAutStaPrintMore,FTAutStaFavorite,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
	VALUES ('00003','SVD','SVD','SVD002','0','1','1','1','1','0','0','0','0','0','2020-12-10 18:28:18.000','00001','2020-12-10 18:28:18.000','00001')

	INSERT INTO TCNTUsrMenu (FTRolCode,FTGmnCode,FTMnuParent,FTMnuCode,FTAutStaFull,FTAutStaRead,FTAutStaAdd,FTAutStaEdit,FTAutStaDelete,FTAutStaCancel,FTAutStaAppv,FTAutStaPrint,FTAutStaPrintMore,FTAutStaFavorite,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
 	VALUES ('00003','ICV','ICV','AST002','0','1','1','1','1','1','1','1','1','0','2020-12-10 18:28:18.000','00001','2020-12-10 18:28:18.000','00001')

	INSERT INTO TCNTUsrMenu (FTRolCode,FTGmnCode,FTMnuParent,FTMnuCode,FTAutStaFull,FTAutStaRead,FTAutStaAdd,FTAutStaEdit,FTAutStaDelete,FTAutStaCancel,FTAutStaAppv,FTAutStaPrint,FTAutStaPrintMore,FTAutStaFavorite,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
	VALUES ('00003','ICV','ICV','TXO002','0','1','1','1','1','1','1','1','1','0','2020-12-10 18:28:18.000','00001','2020-12-10 18:28:18.000','00001')

	INSERT INTO TCNTUsrMenu (FTRolCode,FTGmnCode,FTMnuParent,FTMnuCode,FTAutStaFull,FTAutStaRead,FTAutStaAdd,FTAutStaEdit,FTAutStaDelete,FTAutStaCancel,FTAutStaAppv,FTAutStaPrint,FTAutStaPrintMore,FTAutStaFavorite,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
	VALUES ('00003','ICV','ICV','TXO012','0','1','1','1','1','0','0','0','0','0','2020-12-10 18:28:18.000','00001','2020-12-10 18:28:18.000','00001')

	INSERT INTO TCNTUsrMenu (FTRolCode,FTGmnCode,FTMnuParent,FTMnuCode,FTAutStaFull,FTAutStaRead,FTAutStaAdd,FTAutStaEdit,FTAutStaDelete,FTAutStaCancel,FTAutStaAppv,FTAutStaPrint,FTAutStaPrintMore,FTAutStaFavorite,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
	VALUES ('00003','ICV','ICV','TXO013','0','1','1','1','1','0','0','0','0','0','2020-12-10 18:28:18.000','00001','2020-12-10 18:28:18.000','00001')

	INSERT INTO TCNTUsrMenu (FTRolCode,FTGmnCode,FTMnuParent,FTMnuCode,FTAutStaFull,FTAutStaRead,FTAutStaAdd,FTAutStaEdit,FTAutStaDelete,FTAutStaCancel,FTAutStaAppv,FTAutStaPrint,FTAutStaPrintMore,FTAutStaFavorite,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
	VALUES ('00003','ICV','ICV','TXO014','0','1','1','1','1','0','0','0','0','0','2020-12-10 18:28:18.000','00001','2020-12-10 18:28:18.000','00001')

	OPEN SYMMETRIC KEY AdaLicProtectSmtKey 
	DECRYPTION BY CERTIFICATE AdaLicProtectCer
		INSERT INTO TRGSMenuLic (FTLicCode, FTLicStartFinish, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
		VALUES ('SB-ICAST002',EncryptByKey(Key_GUID('AdaLicProtectSmtKey'), '89620ad0a461;SB-ICAST002;2021-01-01;2023-01-01') ,'2022-10-17 18:39:41.240','AutoLic','2022-10-17 18:39:41.240','AutoLic')

		INSERT INTO TRGSMenuLic (FTLicCode, FTLicStartFinish, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
		VALUES ('SB-ICTXO002',EncryptByKey(Key_GUID('AdaLicProtectSmtKey'), '89620ad0a461;SB-ICTXO002;2021-01-01;2023-01-01') ,'2022-10-17 18:39:41.240','AutoLic','2022-10-17 18:39:41.240','AutoLic')

		INSERT INTO TRGSMenuLic (FTLicCode, FTLicStartFinish, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
		VALUES ('SB-ICTXO012',EncryptByKey(Key_GUID('AdaLicProtectSmtKey'), '89620ad0a461;SB-ICTXO012;2021-01-01;2023-01-01') ,'2022-10-17 18:39:41.240','AutoLic','2022-10-17 18:39:41.240','AutoLic')

		INSERT INTO TRGSMenuLic (FTLicCode, FTLicStartFinish, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
		VALUES ('SB-ICTXO013',EncryptByKey(Key_GUID('AdaLicProtectSmtKey'), '89620ad0a461;SB-ICTXO013;2021-01-01;2023-01-01') ,'2022-10-17 18:39:41.240','AutoLic','2022-10-17 18:39:41.240','AutoLic')

		INSERT INTO TRGSMenuLic (FTLicCode, FTLicStartFinish, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
		VALUES ('SB-ICTXO014',EncryptByKey(Key_GUID('AdaLicProtectSmtKey'), '89620ad0a461;SB-ICTXO014;2021-01-01;2023-01-01') ,'2022-10-17 18:39:41.240','AutoLic','2022-10-17 18:39:41.240','AutoLic')

		INSERT INTO TRGSMenuLic (FTLicCode, FTLicStartFinish, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
		VALUES ('SB-MASSVD001',EncryptByKey(Key_GUID('AdaLicProtectSmtKey'), '89620ad0a461;SB-MASSVD001;2021-01-01;2023-01-01') ,'2022-10-17 18:39:41.240','AutoLic','2022-10-17 18:39:41.240','AutoLic')

		INSERT INTO TRGSMenuLic (FTLicCode, FTLicStartFinish, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
		VALUES ('SB-MASSVD002',EncryptByKey(Key_GUID('AdaLicProtectSmtKey'), '89620ad0a461;SB-MASSVD002;2021-01-01;2023-01-01') ,'2022-10-17 18:39:41.240','AutoLic','2022-10-17 18:39:41.240','AutoLic')
	CLOSE SYMMETRIC KEY AdaLicProtectSmtKey

INSERT INTO [TCNTUpgradeHisTmp] ([FTUphVersion], [FDCreateOn], [FTUphRemark], [FTCreateBy]) VALUES ( '00.00.07', getdate() , 'Deploy SIT #3', 'Napat');
END
GO

IF NOT EXISTS(SELECT FTUphVersion FROM TCNTUpgradeHisTmp WHERE FTUphVersion=  '00.00.08') BEGIN

	UPDATE TCNMTxnAPI SET FTApiStaDisplay = '1' WHERE FTApiTxnType = '4'
	UPDATE TCNMTxnAPI SET FTApiStaDisplay = '2' WHERE FTApiCode IN ('00004','00005','00006','00008','00017','00026','00027','00028','00029','00030') /*,'00009'*/

	INSERT INTO TCNMTxnAPI (FTApiCode,FTApiTxnType,FTApiPrcType,FTApiGrpPrc,FNApiGrpSeq,FTApiFmtCode,FTApiURL,FTApiLoginUsr,FTApiLoginPwd,FTApiToken,FDCreateOn,FTCreateBy,FDLastUpdOn,FTLastUpdBy,FTApiStaDisplay)
	VALUES ('00042','2','2','EXPT','13','00003','','','','','2022-01-01 00:00:00.000','CHAIYA BOONTEM','2022-01-01 00:00:00.000','CHAIYA BOONTEM',NULL)

	INSERT INTO TCNMTxnAPI_L (FTApiCode,FNLngID,FTApiName,FTApiRmk)
	VALUES ('00042','1','ส่งออกรายการขาย (ตู้สุ่ม)','NULL')

	INSERT INTO TCNMTxnAPI (FTApiCode,FTApiTxnType,FTApiPrcType,FTApiGrpPrc,FNApiGrpSeq,FTApiFmtCode,FTApiURL,FTApiLoginUsr,FTApiLoginPwd,FTApiToken,FDCreateOn,FTCreateBy,FDLastUpdOn,FTLastUpdBy,FTApiStaDisplay)
	VALUES ('00043','4','2','SALE','5','00003','','','','','2022-01-01 00:00:00.000','CHAIYA BOONTEM','2022-01-27 12:52:29.000','00003','1')

	INSERT INTO TCNMTxnAPI_L (FTApiCode,FNLngID,FTApiName,FTApiRmk)
	VALUES ('00043','1','API รายการขาย (ตู้สุ่ม)','NULL')

	UPDATE TCNMTxnAPI_L SET FTApiName = 'ส่งออกรายการขาย (ใบกำกับภาษีเต็มรูป/ใบลดหนี้)' WHERE FTApiCode = '00007' AND FNLngID = 1
	UPDATE TCNMTxnAPI_L SET FTApiName = 'ส่งออก Status การรับของ (ลูกค้า)' WHERE FTApiCode = '00019' AND FNLngID = 1
	UPDATE TCNMTxnAPI_L SET FTApiName = 'ส่งออก Payin Slip' WHERE FTApiCode = '00020' AND FNLngID = 1
	UPDATE TCNMTxnAPI_L SET FTApiName = 'ส่งออก Status จัดสินค้า' WHERE FTApiCode = '00021' AND FNLngID = 1
	UPDATE TCNMTxnAPI_L SET FTApiName = 'ส่งออก ใบรับโอนสินค้าจาก (TR-Draft)' WHERE FTApiCode = '00022' AND FNLngID = 1
	UPDATE TCNMTxnAPI_L SET FTApiName = 'ส่งออก Goods Issue(ใบเบิกสินค้า)' WHERE FTApiCode = '00023' AND FNLngID = 1
	UPDATE TCNMTxnAPI_L SET FTApiName = 'ส่งออก Goods Receipt(ใบรับสินค้าเข้า)' WHERE FTApiCode = '00024' AND FNLngID = 1
	UPDATE TCNMTxnAPI_L SET FTApiName = 'ส่งออก ใบโอนสินค้าระหว่างคลัง' WHERE FTApiCode = '00025' AND FNLngID = 1
	UPDATE TCNMTxnAPI_L SET FTApiName = 'ส่งออก Member - Earn/Burn Point(Sale)' WHERE FTApiCode = '00031' AND FNLngID = 1
	UPDATE TCNMTxnAPI_L SET FTApiName = 'ส่งออก Earn/Burn Point(Return)' WHERE FTApiCode = '00032' AND FNLngID = 1
	UPDATE TCNMTxnAPI_L SET FTApiName = 'ส่งออกรายการขาย (ตู้สุ่ม)' WHERE FTApiCode = '00043' AND FNLngID = 1

	OPEN SYMMETRIC KEY AdaLicProtectSmtKey 
	DECRYPTION BY CERTIFICATE AdaLicProtectCer
		INSERT INTO TRGSMenuLic (FTLicCode, FTLicStartFinish, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
		VALUES ('SB-GRPRPT002',EncryptByKey(Key_GUID('AdaLicProtectSmtKey'), '89620ad0a461;SB-GRPRPT002;2021-01-01;2023-01-01') ,'2022-10-17 18:39:41.240','AutoLic','2022-10-17 18:39:41.240','AutoLic')
	CLOSE SYMMETRIC KEY AdaLicProtectSmtKey

INSERT INTO [TCNTUpgradeHisTmp] ([FTUphVersion], [FDCreateOn], [FTUphRemark], [FTCreateBy]) VALUES ( '00.00.08', getdate() , 'Deploy SIT #4', 'Napat');
END
GO

IF NOT EXISTS(SELECT FTUphVersion FROM TCNTUpgradeHisTmp WHERE FTUphVersion=  '00.00.09') BEGIN

	INSERT INTO TLKMConfig(FTCfgCode, FTCfgApp, FTCfgKey, FTCfgSeq, FTGmnCode, FTCfgStaAlwEdit, FTCfgStaDataType, FNCfgMaxLength, FTCfgStaDefValue, FTCfgStaDefRef, FTCfgStaUsrValue, FTCfgStaUsrRef, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
	VALUES('tLK_RateUsePoint', 'LINK', 'Center', '1', 'POS', '1', '0', '10', '1:1', '', '', '', '2022-01-27', 'Attaphon N.', '2022-01-27', 'Attaphon N.' )

	INSERT INTO TLKMConfig_L(FTCfgCode, FTCfgApp, FTCfgKey, FTCfgSeq, FNLngID, FTCfgName, FTCfgDesc, FTCfgRmk)
	VALUES('tLK_RateUsePoint', 'LINK', 'Center', '1', '1', 'อัตราการใช้แต้ม ที่ใช้ส่งให้ SAP', '','')
	
	INSERT INTO TLKMConfig_L(FTCfgCode, FTCfgApp, FTCfgKey, FTCfgSeq, FNLngID, FTCfgName, FTCfgDesc, FTCfgRmk)
	VALUES('tLK_RateUsePoint', 'LINK', 'Center', '1', '2', 'Rate use point for send to SAP', '','')

	INSERT INTO TSysMenuGrp (FTGmnCode,FNGmnShwSeq,FTGmnStaUse,FTGmnModCode)
	VALUES ('FNCHK','3','1','FN')

	INSERT INTO TSysMenuGrp_L (FTGmnCode,FNLngID,FTGmnName,FTGmnSystem)
	VALUES ('FNCHK','1','ตรวจสอบ','FN')

	INSERT INTO TSysMenuList (FTGmnCode,FTMnuParent,FTMnuCode,FTLicPdtCode,FNMnuSeq,FTMnuCtlName,FNMnuLevel,FTMnuStaPosHpm,FTMnuStaPosFhn,FTMnuStaSmartHpm,FTMnuStaSmartFhn,FTMnuStaMoreHpm,FTMnuStaMoreFhn,FTMnuType,FTMnuStaAPIPos,FTMnuStaAPISmart,FTMnuStaUse,FTMnuPath,FTGmnModCode,FTMnuImgPath)
	VALUES ('FNCHK','FNCHK','FNCHK001','SB-FNCHK001','1','docManageCoupon/0/0','1','Y','Y','Y','Y','Y','Y','1','Y','Y','1','','FN','')

	INSERT INTO TSysMenuList_L (FTMnuCode,FNLngID,FTMnuName,FTMnuRmk)
	VALUES ('FNCHK001',1,'ตรวจสอบคูปอง/บัตรกำนัล','NULL')

	INSERT INTO TSysMenuAlbAct (FTMnuCode,FTAutStaRead,FTAutStaAdd,FTAutStaEdit,FTAutStaDelete,FTAutStaCancel,FTAutStaAppv,FTAutStaPrint,FTAutStaPrintMore)
	VALUES ('FNCHK001','1','0','1','0','0','0','0','0')

	INSERT INTO TCNTUsrMenu (FTRolCode,FTGmnCode,FTMnuParent,FTMnuCode,FTAutStaFull,FTAutStaRead,FTAutStaAdd,FTAutStaEdit,FTAutStaDelete,FTAutStaCancel,FTAutStaAppv,FTAutStaPrint,FTAutStaPrintMore,FTAutStaFavorite,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
	VALUES ('00003','FNCHK','FNCHK','FNCHK001','0','1','0','1','0','0','0','0','0','0','2022-02-04 18:28:18.000','00001','2022-02-04 18:28:18.000','00001')

	OPEN SYMMETRIC KEY AdaLicProtectSmtKey 
	DECRYPTION BY CERTIFICATE AdaLicProtectCer
		INSERT INTO TRGSMenuLic (FTLicCode, FTLicStartFinish, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
		VALUES ('SB-FNCHK001',EncryptByKey(Key_GUID('AdaLicProtectSmtKey'), '89620ad0a461;SB-FNCHK001;2021-01-01;2023-01-01') ,'2022-10-17 18:39:41.240','AutoLic','2022-10-17 18:39:41.240','AutoLic')
	CLOSE SYMMETRIC KEY AdaLicProtectSmtKey

	INSERT INTO TSysPortPrn (FTSppCode,FTSppValue,FTSppRef,FTSppType,FTSppStaUse,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
	VALUES('WSP-R341','0','2','PRN','1','2022-01-12','','2022-01-12','')	 
	
	INSERT INTO TSysPortPrn_L (FTSppCode,FNLngID,FTSppName)
	VALUES('WSP-R341',1,'Woosim R341')

	INSERT INTO TSysPortPrn_L (FTSppCode,FNLngID,FTSppName)
	VALUES('WSP-R341',2,'Woosim R341')
	

INSERT INTO [TCNTUpgradeHisTmp] ([FTUphVersion], [FDCreateOn], [FTUphRemark], [FTCreateBy]) VALUES ( '00.00.09', getdate() , 'Deploy SIT #4', 'Napat');
END
GO

IF NOT EXISTS(SELECT FTUphVersion FROM TCNTUpgradeHisTmp WHERE FTUphVersion=  '00.00.10') BEGIN

	UPDATE TSysReport SET FTGrpRptModCode = '002', FTGrpRptCode = '002002', FTRptSeqNo = '5' WHERE FTRptCode = '001002006'

INSERT INTO [TCNTUpgradeHisTmp] ([FTUphVersion], [FDCreateOn], [FTUphRemark], [FTCreateBy]) VALUES ( '00.00.10', getdate() , 'Deploy SIT #5', 'Napat');
END
GO

IF NOT EXISTS(SELECT FTUphVersion FROM TCNTUpgradeHisTmp WHERE FTUphVersion=  '00.00.11') BEGIN

	UPDATE TSysReport SET FTRptFilterCol = '1,200,201' WHERE FTRptCode = '002002001'
	UPDATE TSysReport SET FTRptFilterCol = '1,200,201,4,13' WHERE FTRptCode = '002002003'
	UPDATE TSysReport SET FTRptFilterCol = '1,200,201,4,12' WHERE FTRptCode = '002002002'
	UPDATE TSysReport SET FTRptFilterCol = '1,200,201,4,13' WHERE FTRptCode = '002002004'

	INSERT INTO TSysReportFilter (FTRptFltCode,FTRptFltStaFrm,FTRptFltStaTo,FTRptGrpFlt)
	VALUES ('200','1','1','G1')

	INSERT INTO TSysReportFilter_L (FTRptFltCode,FNLngID,FTRptFltName)
	VALUES ('200','1','รูปแบบการจัดสินค้า')

	INSERT INTO TSysReportFilter (FTRptFltCode,FTRptFltStaFrm,FTRptFltStaTo,FTRptGrpFlt)
	VALUES ('201','1','1','G1')

	INSERT INTO TSysReportFilter_L (FTRptFltCode,FNLngID,FTRptFltName)
	VALUES ('201','1','ตู้ขายสินค้า')

	/* พี่เอ็ม - KPC Script upgrade database Backoffice-20220222_1820 */
	TRUNCATE TABLE TCNSLabelFmt
	INSERT [dbo].[TCNSLabelFmt] ([FTLblCode], [FTLblRptNormal], [FTLblRptPmt], [FTLblStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'L001', N'Frm_ALLPdtPriceTag3.8x5.0-KPC.mrt', N'', N'1', CAST(N'2022-02-10T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2021-12-18T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TCNSLabelFmt] ([FTLblCode], [FTLblRptNormal], [FTLblRptPmt], [FTLblStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'L002', N'Frm_ALLPdtPriceTag6.5x10.0-KPC.mrt', N'', N'1', CAST(N'2022-02-10T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2021-12-18T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TCNSLabelFmt] ([FTLblCode], [FTLblRptNormal], [FTLblRptPmt], [FTLblStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'L003', N'Frm_ALLPdtOCPBLabel3.2X2.5-KPC.mrt', N'', N'1', CAST(N'2021-12-18T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2021-12-18T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TCNSLabelFmt] ([FTLblCode], [FTLblRptNormal], [FTLblRptPmt], [FTLblStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'L004', N'Frm_ALLPdtPriceTag4.8x7.2-KPC.mrt', N'', N'1', CAST(N'2022-02-10T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-01-28T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TCNSLabelFmt] ([FTLblCode], [FTLblRptNormal], [FTLblRptPmt], [FTLblStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'L005', N'Frm_ALLPdtPriceTag2.5X3.2-KPC.mrt', N'', N'1', CAST(N'2022-01-28T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-01-28T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TCNSLabelFmt] ([FTLblCode], [FTLblRptNormal], [FTLblRptPmt], [FTLblStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'L006', N'Frm_ALLPdtPriceTag2.5X3.2-KPC.mrt', N'', N'1', CAST(N'2022-01-28T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-01-28T00:00:00.000' AS DateTime), N'Junthon M.')
	
	TRUNCATE TABLE TCNSLabelFmt_L
	INSERT [dbo].[TCNSLabelFmt_L] ([FTLblCode], [FNLngID], [FTLblName], [FTLblRmk]) VALUES (N'L001', 1, N'ป้ายราคาที่ใส่ Shelf Strip', N'')
	INSERT [dbo].[TCNSLabelFmt_L] ([FTLblCode], [FNLngID], [FTLblName], [FTLblRmk]) VALUES (N'L002', 1, N'ป้ายราคาที่ใส่ A7 Signage', N'')
	INSERT [dbo].[TCNSLabelFmt_L] ([FTLblCode], [FNLngID], [FTLblName], [FTLblRmk]) VALUES (N'L003', 1, N'สติ๊กเกอร์ สคบ.', N'')
	INSERT [dbo].[TCNSLabelFmt_L] ([FTLblCode], [FNLngID], [FTLblName], [FTLblRmk]) VALUES (N'L004', 1, N'ป้ายราคา A8 (4.8 X 7.2 CM)', N'')
	INSERT [dbo].[TCNSLabelFmt_L] ([FTLblCode], [FNLngID], [FTLblName], [FTLblRmk]) VALUES (N'L005', 1, N'สติ๊กเกอร์บาร์โค้ด (2.5 X 3.2 CM)', N'')
	INSERT [dbo].[TCNSLabelFmt_L] ([FTLblCode], [FNLngID], [FTLblName], [FTLblRmk]) VALUES (N'L006', 1, N'สติ๊กเกอร์บาร์โค้ด (2.5 X 3.2 CM) NOT FOR SALE/NO REFUND', N'')
	/* พี่เอ็ม - KPC Script upgrade database Backoffice-20220222_1820 */

	INSERT INTO TSysReport (FTRptCode,FTGrpRptModCode,FTGrpRptCode,FTRptRoute,FTRptStaUseFrm,FTRptTblView,FTRptFilterCol,FTRptFileName,FTRptStaShwBch,FTRptStaShwYear,FTRptSeqNo,FTRptStaUse,FTLicPdtCode)
	VALUES ('002001007','002','002001','rptRcvInfoTrialPdtVD','','','1,200,201,4,202,203','','1','1','7','1','SB-RPT002001007')

	INSERT INTO TSysReport_L (FTRptCode,FNLngID,FTRptName,FTRptDes)
	VALUES ('002001007','1','รายงานข้อมูลการรับสินค้าทดลองที่ตู้ Vending','')

    /* บอล ทีม Android */
	INSERT INTO TSysSyncModule (FTAppCode,FNSynSeqNo) VALUES ('VS','112')

	INSERT INTO TSysReportFilter (FTRptFltCode,FTRptFltStaFrm,FTRptFltStaTo,FTRptGrpFlt)
	VALUES ('202','1','1','G6')

	INSERT INTO TSysReportFilter (FTRptFltCode,FTRptFltStaFrm,FTRptFltStaTo,FTRptGrpFlt)
	VALUES ('203','1','1','G6')

	INSERT INTO TSysReportFilter_L (FTRptFltCode,FNLngID,FTRptFltName)
	VALUES ('202','1','ประเภท')

	INSERT INTO TSysReportFilter_L (FTRptFltCode,FNLngID,FTRptFltName)
	VALUES ('203','1','สถานะ')

	INSERT INTO TSysMenuList (FTGmnCode,FTMnuParent,FTMnuCode,FTLicPdtCode,FNMnuSeq,FTMnuCtlName,FNMnuLevel,FTMnuStaPosHpm,FTMnuStaPosFhn,FTMnuStaSmartHpm,FTMnuStaSmartFhn,FTMnuStaMoreHpm,FTMnuStaMoreFhn,FTMnuType,FTMnuStaAPIPos,FTMnuStaAPISmart,FTMnuStaUse,FTMnuPath,FTGmnModCode,FTMnuImgPath)
	VALUES ('SRC','SRC','SRC011','SB-SRC011','11','masInstallmentTerms/0/0','1','Y','Y','Y','Y','Y','Y','1','Y','Y','1',' ','MAS',' ')

	INSERT INTO TSysMenuList_L (FTMnuCode,FNLngID,FTMnuName,FTMnuRmk)
	VALUES ('SRC011','1','เงื่อนไขการผ่อนชำระ','NULL')

	INSERT INTO TCNTAuto (FTSatTblName,FTSatFedCode,FTSatStaDocType,FTSatGroup,FTGmnCode,FTSatDocTypeName,FTSatStaAlwChr,FTSatStaAlwBch,FTSatStaAlwPosShp,FTSatStaAlwYear,FTSatStaAlwMonth,FTSatStaAlwDay,FTSatStaAlwSep,FTSatStaDefUsage,FTSatDefChar,FTSatDefBch,FTSatDefPosShp,FTSatDefYear,FTSatDefMonth,FTSatDefDay,FTSatDefSep,FTSatDefNum,FTSatDefFmtAll,FNSatMaxFedSize,FNSatMinRunning,FTSatUsrChar,FTSatUsrBch,FTSatUsrPosShp,FTSatUsrYear,FTSatUsrMonth,FTSatUsrDay,FTSatUsrSep,FTSatUsrNum,FTSatUsrFmtAll,FTSatStaReset,FTSatStaRunBch,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
	VALUES ('TFNMInstallment','FTStmCode','0','1','MPAY','','0','0','0','0','0','0','0','0','','0','0','0','0','0','0','00001','#####','5','5','','0','0','0','0','0','0','00001','#####','','0','2022-01-23 22:33:31.533','Napat','2021-11-05 00:00:00.000','Napat')

	DELETE TPSMFuncDT WHERE FTGhdCode = '031' AND FTSysCode = 'KB020'
	INSERT INTO TPSMFuncDT (FTGhdCode,FTSysCode,FTLicPdtCode,FNGdtPage,FNGdtDefSeq,FNGdtUsrSeq,FNGdtBtnSizeX,FNGdtBtnSizeY,FTGdtCallByName,FTGdtStaUse,FNGdtFuncLevel,FTGdtSysUse)
	VALUES ('031','KB020','SF-PS031KB020','1','13','13','1','1','C_KBDxInstallment','1','1','1')

INSERT INTO [TCNTUpgradeHisTmp] ([FTUphVersion], [FDCreateOn], [FTUphRemark], [FTCreateBy]) VALUES ( '00.00.11', getdate() , 'Deploy SIT #6', 'Napat');
END
GO

IF NOT EXISTS(SELECT FTUphVersion FROM TCNTUpgradeHisTmp WHERE FTUphVersion=  '00.00.12') BEGIN

	INSERT [dbo].[TSysConfig] ([FTSysCode], [FTSysApp], [FTSysKey], [FTSysSeq], [FTGmnCode], [FTSysStaAlwEdit], [FTSysStaDataType], [FNSysMaxLength], [FTSysStaDefValue], [FTSysStaDefRef], [FTSysStaUsrValue], [FTSysStaUsrRef], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) 
	VALUES (N'nCN_QRTimeout', N'CN', N'QR', N'1', N'MPOS', N'1', N'1', N'1', N'2', N'1', N'2', N'2', CAST(N'2022-03-16T13:37:55.000' AS DateTime), N'00003', CAST(N'2022-01-26T00:00:00.000' AS DateTime), N'Junthon M.')

	INSERT [dbo].[TSysConfig_L] ([FTSysCode], [FTSysApp], [FTSysKey], [FTSysSeq], [FNLngID], [FTSysName], [FTSysDesc], [FTSysRmk]) VALUES (N'nCN_QRTimeout', N'CN', N'QR', N'1', 1, N'ระยะเวลาที่สามารถใช้งานคิวอาร์โค้ดได้', N'กำหนดเอง : 1:ชั่วโมง 2:วัน ,ค่าอ้างอิง:จำนวนอายุของคิวอาร์โค้ด', N'')
	INSERT [dbo].[TSysConfig_L] ([FTSysCode], [FTSysApp], [FTSysKey], [FTSysSeq], [FNLngID], [FTSysName], [FTSysDesc], [FTSysRmk]) VALUES (N'nCN_QRTimeout', N'CN', N'QR', N'1', 2, N'Length of time the QR Code can be used', N'Value : 1:Hour 2:Day ,Ref:The number of age of QR Code', N'')

	TRUNCATE TABLE TSysPosHW
	INSERT [dbo].[TSysPosHW] ([FTShwCode], [FTShwHWKey], [FTShwName], [FTShwNameEng], [FTShwSystem], [FTShwStaAlwPrinter], [FTShwStaAlwCom], [FTShwStaAlwTCP], [FTShwStaAlwBT], [FTShwStaAlwUSB]) VALUES (N'001', N'pPrinter', N'เครื่องพิมพ์', N'Printer', N'AdaPos', N'1', N'1', N'1', N'0', NULL)
	INSERT [dbo].[TSysPosHW] ([FTShwCode], [FTShwHWKey], [FTShwName], [FTShwNameEng], [FTShwSystem], [FTShwStaAlwPrinter], [FTShwStaAlwCom], [FTShwStaAlwTCP], [FTShwStaAlwBT], [FTShwStaAlwUSB]) VALUES (N'002', N'pCstDisp', N'จอภาพ แสดงราคา ลูกค้า', N'Customer display', N'AdaPos', N'1', N'1', N'0', N'0', NULL)
	INSERT [dbo].[TSysPosHW] ([FTShwCode], [FTShwHWKey], [FTShwName], [FTShwNameEng], [FTShwSystem], [FTShwStaAlwPrinter], [FTShwStaAlwCom], [FTShwStaAlwTCP], [FTShwStaAlwBT], [FTShwStaAlwUSB]) VALUES (N'003', N'pDrawer', N'ลิ้นชัก', N'Drawer', N'AdaPos', N'1', N'1', N'0', N'0', NULL)
	INSERT [dbo].[TSysPosHW] ([FTShwCode], [FTShwHWKey], [FTShwName], [FTShwNameEng], [FTShwSystem], [FTShwStaAlwPrinter], [FTShwStaAlwCom], [FTShwStaAlwTCP], [FTShwStaAlwBT], [FTShwStaAlwUSB]) VALUES (N'004', N'pEDC', N'เครื่องอ่านบัตรเครดิด', N'EDC', N'AdaPos', N'0', N'1', N'0', N'0', NULL)
	INSERT [dbo].[TSysPosHW] ([FTShwCode], [FTShwHWKey], [FTShwName], [FTShwNameEng], [FTShwSystem], [FTShwStaAlwPrinter], [FTShwStaAlwCom], [FTShwStaAlwTCP], [FTShwStaAlwBT], [FTShwStaAlwUSB]) VALUES (N'005', N'pMsr', N'เครื่องอ่านแถบแม่เหล็ก', N'Magnetic Reader', N'AdaPos', N'0', N'1', N'0', N'0', NULL)
	INSERT [dbo].[TSysPosHW] ([FTShwCode], [FTShwHWKey], [FTShwName], [FTShwNameEng], [FTShwSystem], [FTShwStaAlwPrinter], [FTShwStaAlwCom], [FTShwStaAlwTCP], [FTShwStaAlwBT], [FTShwStaAlwUSB]) VALUES (N'006', N'pRFID', N'เครื่องอ่าน RFID', N'RFID Reader', N'AdaPos', N'0', N'1', N'0', N'0', NULL)
	INSERT [dbo].[TSysPosHW] ([FTShwCode], [FTShwHWKey], [FTShwName], [FTShwNameEng], [FTShwSystem], [FTShwStaAlwPrinter], [FTShwStaAlwCom], [FTShwStaAlwTCP], [FTShwStaAlwBT], [FTShwStaAlwUSB]) VALUES (N'007', N'pCstAdvert', N'หน้าจอโฆษณา', N'Advertising screen', N'AdaPos', N'0', N'0', N'0', N'0', NULL)
	INSERT [dbo].[TSysPosHW] ([FTShwCode], [FTShwHWKey], [FTShwName], [FTShwNameEng], [FTShwSystem], [FTShwStaAlwPrinter], [FTShwStaAlwCom], [FTShwStaAlwTCP], [FTShwStaAlwBT], [FTShwStaAlwUSB]) VALUES (N'008', N'pAI', N'ปัญญาประดิษฐ์', N'Artificial Intelligence', N'AdaPos', N'0', N'1', N'1', N'1', NULL)
	INSERT [dbo].[TSysPosHW] ([FTShwCode], [FTShwHWKey], [FTShwName], [FTShwNameEng], [FTShwSystem], [FTShwStaAlwPrinter], [FTShwStaAlwCom], [FTShwStaAlwTCP], [FTShwStaAlwBT], [FTShwStaAlwUSB]) VALUES (N'009', N'pVending', N'ตู้ขายสินค้า', N'Vending', N'AdaPos', N'0', N'0', N'1', N'0', NULL)

	INSERT [dbo].[TSysSyncData] ([FNSynSeqNo], [FTSynGroup], [FTSynTable], [FTSynTable_L], [FTSynType], [FDSynLast], [FNSynSchedule], [FTSynStaUse], [FTSynUriDwn], [FTSynUriUld]) 
	VALUES (131, N'FINANCE', N'TFNMInstallment', N'API2PSMaster', N'1','2022-03-14', 0, N'1', N'/Installment/Download?pdDate={pdDate}&ptAgnCode={ptAgnCode}', NULL)
	INSERT [dbo].[TSysSyncData_L] ([FNSynSeqNo], [FNLngID], [FTSynName], [FTSynRmk]) VALUES (131, 1, N'ข้อมูลการผ่อนชำระ', N'')
	INSERT [dbo].[TSysSyncData_L] ([FNSynSeqNo], [FNLngID], [FTSynName], [FTSynRmk]) VALUES (131, 2, N'Installment Data', N'')
	INSERT [dbo].[TSysSyncModule] ([FTAppCode], [FNSynSeqNo]) VALUES (N'PS', 131)
	INSERT [dbo].[TSysSyncModule] ([FTAppCode], [FNSynSeqNo]) VALUES (N'VS', 131)
	UPDATE TSysSyncData WITH(ROWLOCK) SET FTSynUriDwn = '/PdtPrice/Price4Pdt/Download', FDSynLast = '2022-03-15' WHERE FNSynSeqNo = '73'

	UPDATE TSysMenuList SET FTMnuStaUse = '1' WHERE FTMnuCode='SYS006'

    /* พี่เอ็ม */
	TRUNCATE TABLE TSysRsnGrp_L
	INSERT [dbo].[TSysRsnGrp_L] ([FTRsgCode], [FNLngID], [FTRsgName], [FTRsgRmk]) VALUES (N'001', 1, N'การยกเลิกรายการสินค้า', N'')
	INSERT [dbo].[TSysRsnGrp_L] ([FTRsgCode], [FNLngID], [FTRsgName], [FTRsgRmk]) VALUES (N'002', 1, N'การยกเลิกบิลขาย', N'')
	INSERT [dbo].[TSysRsnGrp_L] ([FTRsgCode], [FNLngID], [FTRsgName], [FTRsgRmk]) VALUES (N'003', 1, N'การคืนสินค้า', N'')
	INSERT [dbo].[TSysRsnGrp_L] ([FTRsgCode], [FNLngID], [FTRsgName], [FTRsgRmk]) VALUES (N'004', 1, N'การรับเข้า/เบิกออก', N'')
	INSERT [dbo].[TSysRsnGrp_L] ([FTRsgCode], [FNLngID], [FTRsgName], [FTRsgRmk]) VALUES (N'005', 1, N'การนำเงินเข้า/นำเงินออก', N'')
	INSERT [dbo].[TSysRsnGrp_L] ([FTRsgCode], [FNLngID], [FTRsgName], [FTRsgRmk]) VALUES (N'006', 1, N'การเปิดลิ้นชักแบบไม่ขาย', N'')
	INSERT [dbo].[TSysRsnGrp_L] ([FTRsgCode], [FNLngID], [FTRsgName], [FTRsgRmk]) VALUES (N'008', 1, N'การตรวจนับสต็อกสินค้า', N'')
	INSERT [dbo].[TSysRsnGrp_L] ([FTRsgCode], [FNLngID], [FTRsgName], [FTRsgRmk]) VALUES (N'011', 1, N'เหตุผลส่วนลด/ชาร์จรายสินค้า', N'')
	INSERT [dbo].[TSysRsnGrp_L] ([FTRsgCode], [FNLngID], [FTRsgName], [FTRsgRmk]) VALUES (N'012', 1, N'เหตุผลส่วนลด/ชาร์จท้ายบิล', N'')
	INSERT [dbo].[TSysRsnGrp_L] ([FTRsgCode], [FNLngID], [FTRsgName], [FTRsgRmk]) VALUES (N'013', 1, N'การเติมสินค้า', N' ')
	INSERT [dbo].[TSysRsnGrp_L] ([FTRsgCode], [FNLngID], [FTRsgName], [FTRsgRmk]) VALUES (N'014', 1, N'บัตรการเงิน', N'')
	INSERT [dbo].[TSysRsnGrp_L] ([FTRsgCode], [FNLngID], [FTRsgName], [FTRsgRmk]) VALUES (N'015', 1, N'เหตุผลการชำระ', N'')
	INSERT [dbo].[TSysRsnGrp_L] ([FTRsgCode], [FNLngID], [FTRsgName], [FTRsgRmk]) VALUES (N'016', 1, N'การโอนสินค้า', N'NULL')
	INSERT [dbo].[TSysRsnGrp_L] ([FTRsgCode], [FNLngID], [FTRsgName], [FTRsgRmk]) VALUES (N'017', 1, N'ภาษี', N'')
	INSERT [dbo].[TSysRsnGrp_L] ([FTRsgCode], [FNLngID], [FTRsgName], [FTRsgRmk]) VALUES (N'018', 1, N'ลดหนี้', N'')
	
INSERT INTO [TCNTUpgradeHisTmp] ([FTUphVersion], [FDCreateOn], [FTUphRemark], [FTCreateBy]) VALUES ( '00.00.12', getdate() , 'Deploy SIT #7', 'Napat');
END
GO

IF NOT EXISTS(SELECT FTUphVersion FROM TCNTUpgradeHisTmp WHERE FTUphVersion=  '00.00.13') BEGIN

	/* พี่เอ็ม */
	UPDATE TPSMFuncDT SET FTLicPdtCode = 'SF-PS031KB011',FTGdtStaUse = '1',FTGdtSysUse = '1' WHERE FTGhdCode = '031' AND FTSysCode = 'KB011' AND FTGdtCallByName = 'C_KBDxCreditNote'
	UPDATE TPSMFuncHD SET FDLastUpdOn = GETDATE() WHERE FTGhdCode = '031'

INSERT INTO [TCNTUpgradeHisTmp] ([FTUphVersion], [FDCreateOn], [FTUphRemark], [FTCreateBy]) VALUES ( '00.00.13', getdate() , 'Deploy SIT #8', 'Napat');
END
GO

IF NOT EXISTS(SELECT FTUphVersion FROM TCNTUpgradeHisTmp WHERE FTUphVersion=  '00.00.14') BEGIN

	/* พี่เอ็ม */
	INSERT [dbo].[TSysConfig] ([FTSysCode], [FTSysApp], [FTSysKey], [FTSysSeq], [FTGmnCode], [FTSysStaAlwEdit], [FTSysStaDataType], [FNSysMaxLength], [FTSysStaDefValue], [FTSysStaDefRef], [FTSysStaUsrValue], [FTSysStaUsrRef], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) 
	VALUES (N'bCN_AlwPmtDisAvg', N'CN', N'Promotion', N'1', N'MPOS', N'1', N'4', N'1', N'1', N'', N'0', N'', CAST(N'2021-05-04T12:25:18.000' AS DateTime), N'009', CAST(N'2020-08-27T00:00:00.000' AS DateTime), N'Junthon M.')

	INSERT [dbo].[TSysConfig_L] ([FTSysCode], [FTSysApp], [FTSysKey], [FTSysSeq], [FNLngID], [FTSysName], [FTSysDesc], [FTSysRmk]) VALUES (N'bCN_AlwPmtDisAvg', N'CN', N'Promotion', N'1', 1, N'อนุญาตให้ใช้เปอร์เซนต์เฉลี่ยส่วนลดโปรโมชั่น', N'1 : อนุญาต, 0 : ไม่อนุญาต', N'')
	INSERT [dbo].[TSysConfig_L] ([FTSysCode], [FTSysApp], [FTSysKey], [FTSysSeq], [FNLngID], [FTSysName], [FTSysDesc], [FTSysRmk]) VALUES (N'bCN_AlwPmtDisAvg', N'CN', N'Promotion', N'1', 2, N'Allow to used promotion discount average  percentag ', N'1 : Allow, 0 : Not  Allow', N'')

INSERT INTO [TCNTUpgradeHisTmp] ([FTUphVersion], [FDCreateOn], [FTUphRemark], [FTCreateBy]) VALUES ( '00.00.14', getdate() , 'Deploy SIT #9', 'Napat');
END
GO

IF NOT EXISTS(SELECT FTUphVersion FROM TCNTUpgradeHisTmp WHERE FTUphVersion=  '00.00.15') BEGIN
	TRUNCATE TABLE TCNSRptSpc
	TRUNCATE TABLE TCNSRptSpc_L
	
	INSERT INTO TCNSRptSpc (FTAgnCode,FTBchCode,FTMerCode,FTShpCode,FNRptGrpSeq,FTRptGrpCode,FNRptSeq,FTRptCode,FTRptRoute,FTRptFilterCol,FTRptStaActive,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy,FTRolCode)
	VALUES (NULL,NULL,NULL,NULL,1,'SPC001','1','001001019','rptRptDayEndSalesKPC','1,6,2,3,4,26','1',NULL,NULL,NULL,NULL,NULL)

	INSERT INTO TCNSRptSpc (FTAgnCode,FTBchCode,FTMerCode,FTShpCode,FNRptGrpSeq,FTRptGrpCode,FNRptSeq,FTRptCode,FTRptRoute,FTRptFilterCol,FTRptStaActive,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy,FTRolCode)
	VALUES (NULL,NULL,NULL,NULL,1,'SPC001','2','001001015','rptSalesDailyByCashierKPC','1,2,3,4,45','1',NULL,NULL,NULL,NULL,NULL)

	INSERT INTO TCNSRptSpc_L (FTRptCode,FNLngID,FTRptName,FTRptRmk)
	VALUES ('001001019','1','รายงาน - ยอดขายสิ้นวัน (KPC)',NULL)

	INSERT INTO TCNSRptSpc_L (FTRptCode,FNLngID,FTRptName,FTRptRmk)
	VALUES ('001001015','1','รายงาน - ยอดขายตามแคชเชียร์ (KPC)',NULL)
INSERT INTO [TCNTUpgradeHisTmp] ([FTUphVersion], [FDCreateOn], [FTUphRemark], [FTCreateBy]) VALUES ( '00.00.15', getdate() , 'Deploy SIT #10', 'Napat');
END
GO

IF NOT EXISTS(SELECT FTUphVersion FROM TCNTUpgradeHisTmp WHERE FTUphVersion=  '00.00.16') BEGIN

	DELETE FROM TCNTUsrFuncRpt WHERE FTUfrGrpRef = '085' AND FTUfrRef = 'KB058' AND FTGhdApp = 'PS'
	INSERT INTO TCNTUsrFuncRpt (FTRolCode,FTUfrType,FTUfrGrpRef,FTUfrRef,FTGhdApp,FTUfrStaAlw,FTUfrStaFavorite,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
	SELECT FTRolCode,'1','085','KB058','PS','1','0',GETDATE(),'PHPAUTO',GETDATE(),'PHPAUTO' FROM TCNMUsrRole

	INSERT [dbo].[TCNSLabelFmt] ([FTLblCode], [FTLblRptNormal], [FTLblRptPmt], [FTLblStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) 
	VALUES (N'L007', N'Frm_ALLPdtPriceTag3.5X5.0-KPC.mrt', N'', N'1', CAST(N'2022-04-22T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-04-22T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TCNSLabelFmt_L] ([FTLblCode], [FNLngID], [FTLblName], [FTLblRmk]) VALUES (N'L007', 1, N'ป้ายราคา A9 (3.5 X 5.0 CM)', N'')

INSERT INTO [TCNTUpgradeHisTmp] ([FTUphVersion], [FDCreateOn], [FTUphRemark], [FTCreateBy]) VALUES ( '00.00.16', getdate() , 'Deploy SIT #11', 'Napat');
END
GO

IF NOT EXISTS(SELECT FTUphVersion FROM TCNTUpgradeHisTmp WHERE FTUphVersion='00.00.17') BEGIN

	INSERT [dbo].[TSysShiftEvent_L] ([FTEvnCode], [FNLngID], [FTEvnName], [FTEvnFuncRef], [FTEvnStaUsed]) VALUES (N'007', 1, N'พิมพ์ใบลองบิล', N'fC_PreviewBill', N'1')
	INSERT [dbo].[TSysShiftEvent_L] ([FTEvnCode], [FNLngID], [FTEvnName], [FTEvnFuncRef], [FTEvnStaUsed]) VALUES (N'008', 1, N'พิมพ์ซ้ำใบอย่างย่อ', N'fC_Reprint', N'1')
	INSERT [dbo].[TSysShiftEvent_L] ([FTEvnCode], [FNLngID], [FTEvnName], [FTEvnFuncRef], [FTEvnStaUsed]) VALUES (N'009', 1, N'อนุญาตสิทธิ์', N'fC_Allow', N'1')

INSERT INTO [TCNTUpgradeHisTmp] ([FTUphVersion], [FDCreateOn], [FTUphRemark], [FTCreateBy]) VALUES ( '00.00.17', getdate() , 'Deploy SIT #12', 'Napat');
END
GO

IF NOT EXISTS(SELECT FTUphVersion FROM TCNTUpgradeHisTmp WHERE FTUphVersion='00.00.18') BEGIN

	INSERT [dbo].[TPSSGrpSlipDT] ([FTGshCode], [FTGsdSubCode], [FNGsdSeqNo], [FTGsdName], [FTGsdStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'006', N'BarCode', 2, N'บาร์โค้ดสินค้า', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSSGrpSlipDT] ([FTGshCode], [FTGsdSubCode], [FNGsdSeqNo], [FTGsdName], [FTGsdStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'006', N'PdtCode', 1, N'รหัสสินค้า', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSSGrpSlipDT] ([FTGshCode], [FTGsdSubCode], [FNGsdSeqNo], [FTGsdName], [FTGsdStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'006', N'PdtName', 3, N'ชื่อสินค้า', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSSGrpSlipDT] ([FTGshCode], [FTGsdSubCode], [FNGsdSeqNo], [FTGsdName], [FTGsdStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'006', N'Price', 6, N'ราคาต่อหน่วย', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSSGrpSlipDT] ([FTGshCode], [FTGsdSubCode], [FNGsdSeqNo], [FTGsdName], [FTGsdStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'006', N'Qty', 4, N'จำนวน', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSSGrpSlipDT] ([FTGshCode], [FTGsdSubCode], [FNGsdSeqNo], [FTGsdName], [FTGsdStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'006', N'TotalAmt', 7, N'ราคารวม', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSSGrpSlipDT] ([FTGshCode], [FTGsdSubCode], [FNGsdSeqNo], [FTGsdName], [FTGsdStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'006', N'Unit', 5, N'หน่วย', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSSGrpSlipDT] ([FTGshCode], [FTGsdSubCode], [FNGsdSeqNo], [FTGsdName], [FTGsdStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'006', N'VatType', 8, N'สถานะภาษี', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSSGrpSlipDT] ([FTGshCode], [FTGsdSubCode], [FNGsdSeqNo], [FTGsdName], [FTGsdStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'010', N'Vat', 2, N'มูลค่าภาษี', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSSGrpSlipDT] ([FTGshCode], [FTGsdSubCode], [FNGsdSeqNo], [FTGsdName], [FTGsdStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'010', N'Vatable', 1, N'มูลค่าก่อนภาษี', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSSGrpSlipDT] ([FTGshCode], [FTGsdSubCode], [FNGsdSeqNo], [FTGsdName], [FTGsdStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'012', N'CardCode', 3, N'หมายเลขบัตร', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSSGrpSlipDT] ([FTGshCode], [FTGsdSubCode], [FNGsdSeqNo], [FTGsdName], [FTGsdStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'012', N'ExpireDate', 4, N'วันหมดอายุ', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSSGrpSlipDT] ([FTGshCode], [FTGsdSubCode], [FNGsdSeqNo], [FTGsdName], [FTGsdStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'012', N'MemCode', 1, N'รหัสสมาชิก', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSSGrpSlipDT] ([FTGshCode], [FTGsdSubCode], [FNGsdSeqNo], [FTGsdName], [FTGsdStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'012', N'MemName', 2, N'ชื่อสมาชิก', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSSGrpSlipDT] ([FTGshCode], [FTGsdSubCode], [FNGsdSeqNo], [FTGsdName], [FTGsdStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'012', N'Point', 5, N'แต้ม', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')

	INSERT [dbo].[TPSSGrpSlipHD] ([FTGshCode], [FTGshName], [FTGshStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'001', N'โลโก้', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSSGrpSlipHD] ([FTGshCode], [FTGshName], [FTGshStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'002', N'New Line', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSSGrpSlipHD] ([FTGshCode], [FTGshName], [FTGshStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'003', N'ข้อความหัวใบเสร็จ', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSSGrpSlipHD] ([FTGshCode], [FTGshName], [FTGshStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'004', N'ข้อมูลจุดขาย', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSSGrpSlipHD] ([FTGshCode], [FTGshName], [FTGshStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'005', N'เลขที่บิล', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSSGrpSlipHD] ([FTGshCode], [FTGshName], [FTGshStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'006', N'รายการสินค้า', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSSGrpSlipHD] ([FTGshCode], [FTGshName], [FTGshStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'007', N'ส่วนลดโปรโมชั่น', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSSGrpSlipHD] ([FTGshCode], [FTGshName], [FTGshStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'008', N'ยอดรวม', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSSGrpSlipHD] ([FTGshCode], [FTGshName], [FTGshStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'009', N'ส่วนลดท้ายบิล', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSSGrpSlipHD] ([FTGshCode], [FTGshName], [FTGshStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'010', N'ยอดรวมสุทธิ', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSSGrpSlipHD] ([FTGshCode], [FTGshName], [FTGshStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'011', N'การชำระ', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSSGrpSlipHD] ([FTGshCode], [FTGshName], [FTGshStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'012', N'สมาชิก', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSSGrpSlipHD] ([FTGshCode], [FTGshName], [FTGshStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'013', N'พนักงาน', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSSGrpSlipHD] ([FTGshCode], [FTGshName], [FTGshStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'014', N'อ้างอิง/สำเนา', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSSGrpSlipHD] ([FTGshCode], [FTGshName], [FTGshStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'015', N'ข้อความท้ายใบเสร็จ', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSSGrpSlipHD] ([FTGshCode], [FTGshName], [FTGshStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'016', N'บาร์โค้ดบิลขาย', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSSGrpSlipHD] ([FTGshCode], [FTGshName], [FTGshStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'017', N'โปรโมชั่น/คูปอง', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSSGrpSlipHD] ([FTGshCode], [FTGshName], [FTGshStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'018', N'ข้อความพิเศษ', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')

	INSERT [dbo].[TPSMUsrSlipDT] ([FTAgnCode], [FNUshSeq], [FTUsdSubCode], [FTUsdStaShw], [FNUsdLine], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 6, N'BarCode', N'1', 1, CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSMUsrSlipDT] ([FTAgnCode], [FNUshSeq], [FTUsdSubCode], [FTUsdStaShw], [FNUsdLine], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 6, N'PdtCode', N'2', 0, CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSMUsrSlipDT] ([FTAgnCode], [FNUshSeq], [FTUsdSubCode], [FTUsdStaShw], [FNUsdLine], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 6, N'PdtName', N'1', 1, CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSMUsrSlipDT] ([FTAgnCode], [FNUshSeq], [FTUsdSubCode], [FTUsdStaShw], [FNUsdLine], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 6, N'Price', N'2', 0, CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSMUsrSlipDT] ([FTAgnCode], [FNUshSeq], [FTUsdSubCode], [FTUsdStaShw], [FNUsdLine], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 6, N'Qty', N'1', 2, CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSMUsrSlipDT] ([FTAgnCode], [FNUshSeq], [FTUsdSubCode], [FTUsdStaShw], [FNUsdLine], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 6, N'TotalAmt', N'1', 2, CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSMUsrSlipDT] ([FTAgnCode], [FNUshSeq], [FTUsdSubCode], [FTUsdStaShw], [FNUsdLine], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 6, N'Unit', N'2', 0, CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSMUsrSlipDT] ([FTAgnCode], [FNUshSeq], [FTUsdSubCode], [FTUsdStaShw], [FNUsdLine], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 6, N'VatType', N'1', 2, CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSMUsrSlipDT] ([FTAgnCode], [FNUshSeq], [FTUsdSubCode], [FTUsdStaShw], [FNUsdLine], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 12, N'Vat', N'1', 2, CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSMUsrSlipDT] ([FTAgnCode], [FNUshSeq], [FTUsdSubCode], [FTUsdStaShw], [FNUsdLine], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 12, N'Vatable', N'1', 1, CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSMUsrSlipDT] ([FTAgnCode], [FNUshSeq], [FTUsdSubCode], [FTUsdStaShw], [FNUsdLine], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 14, N'CardCode', N'2', 0, CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSMUsrSlipDT] ([FTAgnCode], [FNUshSeq], [FTUsdSubCode], [FTUsdStaShw], [FNUsdLine], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 14, N'ExpireDate', N'2', 0, CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSMUsrSlipDT] ([FTAgnCode], [FNUshSeq], [FTUsdSubCode], [FTUsdStaShw], [FNUsdLine], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 14, N'MemCode', N'2', 0, CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSMUsrSlipDT] ([FTAgnCode], [FNUshSeq], [FTUsdSubCode], [FTUsdStaShw], [FNUsdLine], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 14, N'MemName', N'1', 1, CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSMUsrSlipDT] ([FTAgnCode], [FNUshSeq], [FTUsdSubCode], [FTUsdStaShw], [FNUsdLine], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 14, N'Point', N'1', 2, CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')

	INSERT [dbo].[TPSMUsrSlipHD] ([FTAgnCode], [FNUshSeq], [FTGshCode], [FTUshStaShw], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 1, N'001', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSMUsrSlipHD] ([FTAgnCode], [FNUshSeq], [FTGshCode], [FTUshStaShw], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 2, N'002', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSMUsrSlipHD] ([FTAgnCode], [FNUshSeq], [FTGshCode], [FTUshStaShw], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 3, N'003', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSMUsrSlipHD] ([FTAgnCode], [FNUshSeq], [FTGshCode], [FTUshStaShw], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 4, N'004', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSMUsrSlipHD] ([FTAgnCode], [FNUshSeq], [FTGshCode], [FTUshStaShw], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 5, N'005', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSMUsrSlipHD] ([FTAgnCode], [FNUshSeq], [FTGshCode], [FTUshStaShw], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 6, N'006', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSMUsrSlipHD] ([FTAgnCode], [FNUshSeq], [FTGshCode], [FTUshStaShw], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 7, N'007', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSMUsrSlipHD] ([FTAgnCode], [FNUshSeq], [FTGshCode], [FTUshStaShw], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 8, N'002', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSMUsrSlipHD] ([FTAgnCode], [FNUshSeq], [FTGshCode], [FTUshStaShw], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 9, N'008', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSMUsrSlipHD] ([FTAgnCode], [FNUshSeq], [FTGshCode], [FTUshStaShw], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 10, N'009', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSMUsrSlipHD] ([FTAgnCode], [FNUshSeq], [FTGshCode], [FTUshStaShw], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 11, N'010', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSMUsrSlipHD] ([FTAgnCode], [FNUshSeq], [FTGshCode], [FTUshStaShw], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 12, N'011', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSMUsrSlipHD] ([FTAgnCode], [FNUshSeq], [FTGshCode], [FTUshStaShw], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 13, N'002', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSMUsrSlipHD] ([FTAgnCode], [FNUshSeq], [FTGshCode], [FTUshStaShw], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 14, N'012', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSMUsrSlipHD] ([FTAgnCode], [FNUshSeq], [FTGshCode], [FTUshStaShw], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 15, N'002', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSMUsrSlipHD] ([FTAgnCode], [FNUshSeq], [FTGshCode], [FTUshStaShw], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 16, N'013', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSMUsrSlipHD] ([FTAgnCode], [FNUshSeq], [FTGshCode], [FTUshStaShw], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 17, N'014', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSMUsrSlipHD] ([FTAgnCode], [FNUshSeq], [FTGshCode], [FTUshStaShw], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 18, N'002', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSMUsrSlipHD] ([FTAgnCode], [FNUshSeq], [FTGshCode], [FTUshStaShw], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 19, N'015', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSMUsrSlipHD] ([FTAgnCode], [FNUshSeq], [FTGshCode], [FTUshStaShw], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 20, N'016', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	INSERT [dbo].[TPSMUsrSlipHD] ([FTAgnCode], [FNUshSeq], [FTGshCode], [FTUshStaShw], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) VALUES (N'', 21, N'017', N'1', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-05-16T00:00:00.000' AS DateTime), N'Junthon M.')
	
INSERT INTO [TCNTUpgradeHisTmp] ([FTUphVersion], [FDCreateOn], [FTUphRemark], [FTCreateBy]) VALUES ( '00.00.18', getdate() , 'Deploy SIT #13', 'Napat');
END
GO

IF NOT EXISTS(SELECT FTUphVersion FROM TCNTUpgradeHisTmp WHERE FTUphVersion='00.00.19') BEGIN

	INSERT INTO TSysMenuList (FTGmnCode,FTMnuParent,FTMnuCode,FTLicPdtCode,FNMnuSeq,FTMnuCtlName,FNMnuLevel,FTMnuStaPosHpm,FTMnuStaPosFhn,FTMnuStaSmartHpm,FTMnuStaSmartFhn,FTMnuStaMoreHpm,FTMnuStaMoreFhn,FTMnuType,FTMnuStaAPIPos,FTMnuStaAPISmart,FTMnuStaUse,FTMnuPath,FTGmnModCode,FTMnuImgPath)
	VALUES ('TOL','TOL','TOL004','SB-ADTOL004','13','toolConfigSlip','1','Y','Y','Y','Y','Y','Y','1','Y','Y','1','','AD','')

	INSERT INTO TSysMenuList_L (FTMnuCode,FNLngID,FTMnuName,FTMnuRmk)
	VALUES ('TOL004','1','ตั้งค่าใบเสร็จ','NULL')

	INSERT INTO TSysMenuAlbAct (FTMnuCode, FTAutStaRead, FTAutStaAdd, FTAutStaEdit, FTAutStaDelete, FTAutStaCancel, FTAutStaAppv, FTAutStaPrint, FTAutStaPrintMore)
	VALUES ('TOL004','1','1','1','1','0','0','0','0')

	UPDATE TPSSGrpSlipHD SET FTGshName = 'เว้นบรรทัด' WHERE FTGshCode = '002'

INSERT INTO [TCNTUpgradeHisTmp] ([FTUphVersion], [FDCreateOn], [FTUphRemark], [FTCreateBy]) VALUES ( '00.00.19', getdate() , 'Deploy SIT #14', 'Napat');
END
GO

IF NOT EXISTS(SELECT FTUphVersion FROM TCNTUpgradeHisTmp WHERE FTUphVersion='00.00.20') BEGIN

	INSERT INTO TSysMenuList (FTGmnCode,FTMnuParent,FTMnuCode,FTLicPdtCode,FNMnuSeq,FTMnuCtlName,FNMnuLevel,FTMnuStaPosHpm,FTMnuStaPosFhn,FTMnuStaSmartHpm,FTMnuStaSmartFhn,FTMnuStaMoreHpm,FTMnuStaMoreFhn,FTMnuType,FTMnuStaAPIPos,FTMnuStaAPISmart,FTMnuStaUse,FTMnuPath,FTGmnModCode,FTMnuImgPath)
	VALUES ('TOL','TOL','TOL005','SB-ADTOL005','14','toolLogHistory','1','Y','Y','Y','Y','Y','Y','1','Y','Y','1','','AD','')

	INSERT INTO TSysMenuList_L (FTMnuCode,FNLngID,FTMnuName,FTMnuRmk)
	VALUES ('TOL005','1','ประวัติการขอไฟล์','NULL')

	INSERT INTO TSysMenuAlbAct (FTMnuCode, FTAutStaRead, FTAutStaAdd, FTAutStaEdit, FTAutStaDelete, FTAutStaCancel, FTAutStaAppv, FTAutStaPrint, FTAutStaPrintMore)
	VALUES ('TOL005','1','1','1','1','0','0','0','0')

	/* สคริปของพี่อาร์ม */
	UPDATE TCNTPdtPrice4PDT WITH(ROWLOCK) SET FTPghDocNo = '' WHERE FTPghDocNo IS NULL
	UPDATE TCNTPdtPrice4PDT WITH(ROWLOCK) SET FTPghDocType = '' WHERE FTPghDocType IS NULL

INSERT INTO [TCNTUpgradeHisTmp] ([FTUphVersion], [FDCreateOn], [FTUphRemark], [FTCreateBy]) VALUES ( '00.00.20', getdate() , 'Deploy SIT #15', 'Napat');
END
GO

IF NOT EXISTS(SELECT FTUphVersion FROM TCNTUpgradeHisTmp WHERE FTUphVersion='00.00.21') BEGIN

	INSERT [dbo].[TSysConfig] ([FTSysCode], [FTSysApp], [FTSysKey], [FTSysSeq], [FTGmnCode], [FTSysStaAlwEdit], [FTSysStaDataType], [FNSysMaxLength], [FTSysStaDefValue], [FTSysStaDefRef], [FTSysStaUsrValue], [FTSysStaUsrRef], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) 
	VALUES (N'nVB_StaPrcReME', N'CN', N'Company', N'1', N'COMP', N'1', N'1', N'1', N'1', N'', N'2', N'', CAST(N'2022-07-19T00:51:02.000' AS DateTime), N'00756', CAST(N'2022-04-11T00:00:00.000' AS DateTime), N'Junthon M.')

	INSERT [dbo].[TSysConfig_L] ([FTSysCode], [FTSysApp], [FTSysKey], [FTSysSeq], [FNLngID], [FTSysName], [FTSysDesc], [FTSysRmk]) 
	VALUES (N'nVB_StaPrcReME', N'CN', N'Company', N'1', 1, N'ประมวลผลยอดยกมาสิ้นเดือนเมื่ออนุมัติเอกสารย้อนหลัง', N'1: หลังปรับสต๊อกเอกสาร,2: รอประมวลสิ้นวัน', N'')

	INSERT [dbo].[TSysConfig_L] ([FTSysCode], [FTSysApp], [FTSysKey], [FTSysSeq], [FNLngID], [FTSysName], [FTSysDesc], [FTSysRmk]) 
	VALUES (N'nVB_StaPrcReME', N'CN', N'Company', N'1', 2, N'Reprocess MonthEnd when approve restrospect document', N'1:After process stock, 2:Wait dayend process', N'')

INSERT INTO [TCNTUpgradeHisTmp] ([FTUphVersion], [FDCreateOn], [FTUphRemark], [FTCreateBy]) VALUES ( '00.00.21', getdate() , 'Deploy SIT #16', 'Napat');
END
GO

IF NOT EXISTS(SELECT FTUphVersion FROM TCNTUpgradeHisTmp WHERE FTUphVersion='00.01.00') BEGIN

	/* พี่เอ็ม/พี่อาร์ม KPC Script upgrade database Backoffice-20220812_1956 */
	INSERT [dbo].[TPSMFuncDT] ([FTGhdCode], [FTSysCode], [FTLicPdtCode], [FNGdtPage], [FNGdtDefSeq], [FNGdtUsrSeq], [FNGdtBtnSizeX], [FNGdtBtnSizeY], [FTGdtCallByName], [FTGdtStaUse], [FNGdtFuncLevel], [FTGdtSysUse]) 
	VALUES (N'086', N'KB105', N'', 1, 0, 0, 0, 0, N'C_KBDxAlwUseStkOffline', N'1', 1, N'1')

	INSERT [dbo].[TPSMFuncDT_L] ([FTGhdCode], [FTSysCode], [FNLngID], [FTGdtName]) VALUES (N'086', N'KB105', 1, N'อนุญาต ทำรายการออฟไลน์')
	INSERT [dbo].[TPSMFuncDT_L] ([FTGhdCode], [FTSysCode], [FNLngID], [FTGdtName]) VALUES (N'086', N'KB105', 2, N'Allow make offline transaction')

	INSERT [dbo].[TPSMFuncHD] ([FTGhdCode], [FTGhdApp], [FTKbdScreen], [FTKbdGrpName], [FNGhdMaxPerPage], [FTGhdLayOut], [FNGhdMaxLayOutX], [FNGhdMaxLayOutY], [FTGhdStaAlwChg], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) 
	VALUES (N'086', N'PS', N'ROLE', N'ROLE', 0, N'ALL', 0, 0, N'1', CAST(N'2022-08-10T17:00:04.403' AS DateTime), N'Supalerk P.', CAST(N'2022-08-10T17:00:04.403' AS DateTime), N'Supalerk P.')

INSERT INTO [TCNTUpgradeHisTmp] ([FTUphVersion], [FDCreateOn], [FTUphRemark], [FTCreateBy]) VALUES ( '00.01.00', getdate() , 'Deploy SIT #16', 'Napat');
END
GO

IF NOT EXISTS(SELECT FTUphVersion FROM TCNTUpgradeHisTmp WHERE FTUphVersion='00.03.00') BEGIN

	DELETE FROM TCNSLabelFmt
	DELETE FROM TCNSLabelFmt_L

	/* พี่เอ็ม KPC Script upgrade database Backoffice-20220816_1142 */
	INSERT [dbo].[TCNSLabelFmt] ([FTLblCode], [FTLblRptNormal], [FTLblRptPmt], [FTLblStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy], [FNLblQtyPerPageNml], [FNLblQtyPerPagePmt], [FTLblVerGroup], [FTLblSizeWH]) 
	VALUES (N'L001', N'Frm_ALLPdtPriceTag3.8x5.0-KPC.mrt', N'', N'2', CAST(N'2022-02-10T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2021-12-18T00:00:00.000' AS DateTime), N'Junthon M.', 0, 0, N'KPC', N'')

	INSERT [dbo].[TCNSLabelFmt] ([FTLblCode], [FTLblRptNormal], [FTLblRptPmt], [FTLblStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy], [FNLblQtyPerPageNml], [FNLblQtyPerPagePmt], [FTLblVerGroup], [FTLblSizeWH]) 
	VALUES (N'L002', N'Frm_ALLPdtPriceTag6.5x10.0-KPC.mrt', N'', N'2', CAST(N'2022-02-10T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2021-12-18T00:00:00.000' AS DateTime), N'Junthon M.', 0, 0, N'KPC', N'')

	INSERT [dbo].[TCNSLabelFmt] ([FTLblCode], [FTLblRptNormal], [FTLblRptPmt], [FTLblStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy], [FNLblQtyPerPageNml], [FNLblQtyPerPagePmt], [FTLblVerGroup], [FTLblSizeWH]) 
	VALUES (N'L003', N'Frm_ALLPdtOCPBLabel3.2X2.5-KPC.mrt', N'', N'1', CAST(N'2021-12-18T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2021-12-18T00:00:00.000' AS DateTime), N'Junthon M.', 9, 0, N'KPC', N'')

	INSERT [dbo].[TCNSLabelFmt] ([FTLblCode], [FTLblRptNormal], [FTLblRptPmt], [FTLblStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy], [FNLblQtyPerPageNml], [FNLblQtyPerPagePmt], [FTLblVerGroup], [FTLblSizeWH]) 
	VALUES (N'L004', N'Frm_ALLPdtPriceTag4.8x7.2-KPC.mrt', N'', N'2', CAST(N'2022-02-10T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-01-28T00:00:00.000' AS DateTime), N'Junthon M.', 0, 0, N'KPC', N'')

	INSERT [dbo].[TCNSLabelFmt] ([FTLblCode], [FTLblRptNormal], [FTLblRptPmt], [FTLblStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy], [FNLblQtyPerPageNml], [FNLblQtyPerPagePmt], [FTLblVerGroup], [FTLblSizeWH]) 
	VALUES (N'L005', N'Frm_ALLPdtPriceTag2.5X3.2-KPC.mrt', N'', N'1', CAST(N'2022-01-28T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-01-28T00:00:00.000' AS DateTime), N'Junthon M.', 20, 20, N'KPC', N'')

	INSERT [dbo].[TCNSLabelFmt] ([FTLblCode], [FTLblRptNormal], [FTLblRptPmt], [FTLblStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy], [FNLblQtyPerPageNml], [FNLblQtyPerPagePmt], [FTLblVerGroup], [FTLblSizeWH]) 
	VALUES (N'L006', N'Frm_ALLPdtPriceTag2.5X3.2-KPC.mrt', N'', N'1', CAST(N'2022-01-28T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-01-28T00:00:00.000' AS DateTime), N'Junthon M.', 20, 20, N'KPC', N'')

	INSERT [dbo].[TCNSLabelFmt] ([FTLblCode], [FTLblRptNormal], [FTLblRptPmt], [FTLblStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy], [FNLblQtyPerPageNml], [FNLblQtyPerPagePmt], [FTLblVerGroup], [FTLblSizeWH]) 
	VALUES (N'L007', N'Frm_ALLPdtPriceTag3.5X5.0-KPC.mrt', N'Frm_ALLPdtPriceTagPmt3.5X5.0-KPC.mrt', N'2', CAST(N'2022-04-22T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-04-22T00:00:00.000' AS DateTime), N'Junthon M.', 12, 32, N'KPC', N'5 x 3.5 cm.')

	INSERT [dbo].[TCNSLabelFmt] ([FTLblCode], [FTLblRptNormal], [FTLblRptPmt], [FTLblStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy], [FNLblQtyPerPageNml], [FNLblQtyPerPagePmt], [FTLblVerGroup], [FTLblSizeWH]) 
	VALUES (N'L008', N'Frm_ALLPdtPriceTag10x3.8cm.mrt', N'Frm_ALLPdtPriceTagPmt10x3.8cm.mrt', N'1', CAST(N'2022-07-28T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-07-28T00:00:00.000' AS DateTime), N'Junthon M.', 12, 12, N'STD', N'10 x 3,8 cm.')

	INSERT [dbo].[TCNSLabelFmt] ([FTLblCode], [FTLblRptNormal], [FTLblRptPmt], [FTLblStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy], [FNLblQtyPerPageNml], [FNLblQtyPerPagePmt], [FTLblVerGroup], [FTLblSizeWH]) 
	VALUES (N'L009', N'Frm_ALLPdtPriceTag5x3.8cm.mrt', N'Frm_ALLPdtPriceTagPmt5x3.8cm.mrt', N'1', CAST(N'2022-07-28T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-07-28T00:00:00.000' AS DateTime), N'Junthon M.', 28, 28, N'STD', N'5 x 3.8 cm.')

	INSERT [dbo].[TCNSLabelFmt] ([FTLblCode], [FTLblRptNormal], [FTLblRptPmt], [FTLblStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy], [FNLblQtyPerPageNml], [FNLblQtyPerPagePmt], [FTLblVerGroup], [FTLblSizeWH]) 
	VALUES (N'L010', N'Frm_ALLPdtPriceTag3.2x2.4.mrt', N'', N'1', CAST(N'2022-07-28T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-07-28T00:00:00.000' AS DateTime), N'Junthon M.', 66, 0, N'STD', N'3.2 x 2.4 cm.')

	INSERT [dbo].[TCNSLabelFmt] ([FTLblCode], [FTLblRptNormal], [FTLblRptPmt], [FTLblStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy], [FNLblQtyPerPageNml], [FNLblQtyPerPagePmt], [FTLblVerGroup], [FTLblSizeWH]) 
	VALUES (N'L011', N'', N'Frm_ALLPdtPriceTagPmt200x285mm.mrt', N'2', CAST(N'2022-07-28T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-07-28T00:00:00.000' AS DateTime), N'Junthon M.', 0, 1, N'STD', N'200 x 95 mm')

	INSERT [dbo].[TCNSLabelFmt] ([FTLblCode], [FTLblRptNormal], [FTLblRptPmt], [FTLblStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy], [FNLblQtyPerPageNml], [FNLblQtyPerPagePmt], [FTLblVerGroup], [FTLblSizeWH]) 
	VALUES (N'L012', N'', N'Frm_ALLPdtPriceTagPmt200x142mm.mrt', N'2', CAST(N'2022-07-28T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-07-28T00:00:00.000' AS DateTime), N'Junthon M.', 0, 2, N'STD', N'200 x 142 mm')

	INSERT [dbo].[TCNSLabelFmt] ([FTLblCode], [FTLblRptNormal], [FTLblRptPmt], [FTLblStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy], [FNLblQtyPerPageNml], [FNLblQtyPerPagePmt], [FTLblVerGroup], [FTLblSizeWH]) 
	VALUES (N'L013', N'', N'Frm_ALLPdtPriceTagPmt100x142mm.mrt', N'2', CAST(N'2022-07-28T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-07-28T00:00:00.000' AS DateTime), N'Junthon M.', 0, 4, N'STD', N'100 x 142 mm')

	INSERT [dbo].[TCNSLabelFmt] ([FTLblCode], [FTLblRptNormal], [FTLblRptPmt], [FTLblStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy], [FNLblQtyPerPageNml], [FNLblQtyPerPagePmt], [FTLblVerGroup], [FTLblSizeWH]) 
	VALUES (N'L014', N'', N'Frm_ALLPdtPriceTagPmt200x95mm.mrt', N'2', CAST(N'2022-07-28T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-07-28T00:00:00.000' AS DateTime), N'Junthon M.', 0, 3, N'STD', N'200 x 142 mm')

	INSERT [dbo].[TCNSLabelFmt] ([FTLblCode], [FTLblRptNormal], [FTLblRptPmt], [FTLblStaUse], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy], [FNLblQtyPerPageNml], [FNLblQtyPerPagePmt], [FTLblVerGroup], [FTLblSizeWH]) 
	VALUES (N'L015', N'Frm_ALLPdtPriceTag5x3.5cm-KPC.mrt', N'Frm_ALLPdtPriceTagPmt5x3.5cm-KPC.mrt', N'1', CAST(N'2022-04-22T00:00:00.000' AS DateTime), N'Junthon M.', CAST(N'2022-04-22T00:00:00.000' AS DateTime), N'Junthon M.', 32, 32, N'KPC', N'5 x 3.5 cm.')

	INSERT [dbo].[TCNSLabelFmt_L] ([FTLblCode], [FNLngID], [FTLblName], [FTLblRmk]) VALUES (N'L001', 1, N'ป้ายราคาที่ใส่ Shelf Strip', N'')

	INSERT [dbo].[TCNSLabelFmt_L] ([FTLblCode], [FNLngID], [FTLblName], [FTLblRmk]) VALUES (N'L002', 1, N'ป้ายราคาที่ใส่ A7 Signage', N'')

	INSERT [dbo].[TCNSLabelFmt_L] ([FTLblCode], [FNLngID], [FTLblName], [FTLblRmk]) VALUES (N'L003', 1, N'สติ๊กเกอร์ สคบ.', N'')

	INSERT [dbo].[TCNSLabelFmt_L] ([FTLblCode], [FNLngID], [FTLblName], [FTLblRmk]) VALUES (N'L004', 1, N'ป้ายราคา A8 (4.8 X 7.2 CM)', N'')

	INSERT [dbo].[TCNSLabelFmt_L] ([FTLblCode], [FNLngID], [FTLblName], [FTLblRmk]) VALUES (N'L005', 1, N'สติ๊กเกอร์บาร์โค้ด (2.5 X 3.2 CM)', N'')

	INSERT [dbo].[TCNSLabelFmt_L] ([FTLblCode], [FNLngID], [FTLblName], [FTLblRmk]) VALUES (N'L006', 1, N'สติ๊กเกอร์บาร์โค้ด (2.5 X 3.2 CM) NOT FOR SALE/NO REFUND', N'')

	INSERT [dbo].[TCNSLabelFmt_L] ([FTLblCode], [FNLngID], [FTLblName], [FTLblRmk]) VALUES (N'L007', 1, N'ป้ายราคา A9 (3.5 X 5.0 CM)', N'')

	INSERT [dbo].[TCNSLabelFmt_L] ([FTLblCode], [FNLngID], [FTLblName], [FTLblRmk]) VALUES (N'L008', 1, N'ป้ายราคา ขนาด 10*3.8 ซม. (ราคาปกติและราคาโปรโมชั่น)', N'')
	INSERT [dbo].[TCNSLabelFmt_L] ([FTLblCode], [FNLngID], [FTLblName], [FTLblRmk]) VALUES (N'L008', 2, N'Price label (Normal & Promotion) 10*3.8 cm.', N'')

	INSERT [dbo].[TCNSLabelFmt_L] ([FTLblCode], [FNLngID], [FTLblName], [FTLblRmk]) VALUES (N'L009', 1, N'ป้ายราคา ขนาด 5*3.8 ซม. (ราคาปกติและราคาโปรโมชั่น)', N'')
	INSERT [dbo].[TCNSLabelFmt_L] ([FTLblCode], [FNLngID], [FTLblName], [FTLblRmk]) VALUES (N'L009', 2, N'Price label (Normal & Promotion) 5*3.8 cm.', N'')

	INSERT [dbo].[TCNSLabelFmt_L] ([FTLblCode], [FNLngID], [FTLblName], [FTLblRmk]) VALUES (N'L010', 1, N'ป้ายราคา ขนาด 3.2*2.4 ซม', N'')
	INSERT [dbo].[TCNSLabelFmt_L] ([FTLblCode], [FNLngID], [FTLblName], [FTLblRmk]) VALUES (N'L010', 2, N'Ticket Price 3.2*2.4 CM', N'')

	INSERT [dbo].[TCNSLabelFmt_L] ([FTLblCode], [FNLngID], [FTLblName], [FTLblRmk]) VALUES (N'L011', 1, N'ป้ายราคา ขนาด A4', N'')
	INSERT [dbo].[TCNSLabelFmt_L] ([FTLblCode], [FNLngID], [FTLblName], [FTLblRmk]) VALUES (N'L011', 2, N'Price Card (A4)', N'')

	INSERT [dbo].[TCNSLabelFmt_L] ([FTLblCode], [FNLngID], [FTLblName], [FTLblRmk]) VALUES (N'L012', 1, N'ป้ายราคา ขนาด A5', N'')
	INSERT [dbo].[TCNSLabelFmt_L] ([FTLblCode], [FNLngID], [FTLblName], [FTLblRmk]) VALUES (N'L012', 2, N'Price Card (A5)', N'')

	INSERT [dbo].[TCNSLabelFmt_L] ([FTLblCode], [FNLngID], [FTLblName], [FTLblRmk]) VALUES (N'L013', 1, N'ป้ายราคา ขนาด A6', N'')
	INSERT [dbo].[TCNSLabelFmt_L] ([FTLblCode], [FNLngID], [FTLblName], [FTLblRmk]) VALUES (N'L013', 2, N'Price Card (A6)', N'')

	INSERT [dbo].[TCNSLabelFmt_L] ([FTLblCode], [FNLngID], [FTLblName], [FTLblRmk]) VALUES (N'L014', 1, N'ป้ายราคา ขนาด 1/3 A4', N'')
	INSERT [dbo].[TCNSLabelFmt_L] ([FTLblCode], [FNLngID], [FTLblName], [FTLblRmk]) VALUES (N'L014', 2, N'Price Card (1/3 A4)', N'')

	INSERT [dbo].[TCNSLabelFmt_L] ([FTLblCode], [FNLngID], [FTLblName], [FTLblRmk]) VALUES (N'L015', 1, N'ป้ายราคา ขนาด 5*3.5 ซม. (ราคาปกติและราคาโปรโมชั่น)', N'')
	INSERT [dbo].[TCNSLabelFmt_L] ([FTLblCode], [FNLngID], [FTLblName], [FTLblRmk]) VALUES (N'L015', 2, N'Price label (Normal & Promotion) 5*3.5 cm.', N'')

INSERT INTO [TCNTUpgradeHisTmp] ([FTUphVersion], [FDCreateOn], [FTUphRemark], [FTCreateBy]) VALUES ( '00.03.00', getdate() , 'Deploy SIT #18', 'Napat');
END
GO

IF NOT EXISTS(SELECT FTUphVersion FROM TCNTUpgradeHisTmp WHERE FTUphVersion='01.01.00') BEGIN
	
	UPDATE TLKMMapping SET FTMapName = 'Online (DC จัดส่ง)' WHERE FTMapCode = 'tChnDelivery' AND FNMapSeqNo = 0
	UPDATE TLKMMapping SET FTMapName = 'Online (รับ Store)' WHERE FTMapCode = 'tChnDelivery' AND FNMapSeqNo = 1
	UPDATE TLKMMapping SET FTMapName = 'Offline' WHERE FTMapCode = 'tChnDelivery' AND FNMapSeqNo = 2
	UPDATE TLKMMapping SET FTMapName = 'Offline (Delivery)' WHERE FTMapCode = 'tChnDelivery' AND FNMapSeqNo = 3

	INSERT INTO TLKMMapping (FTMapCode,FNMapSeqNo,FTMapName,FTMapDesc,FTMapDefValue,FTMapUsrValue,FTMapStaDisplay,FTMapStaUse)
	VALUES ('tChnDelivery',4,'Online (Fast Delivery)','','','','','')

	UPDATE TCNMTxnAPI SET FTApiStaDisplay = '1' WHERE FTApiTxnType = '1'

INSERT INTO [TCNTUpgradeHisTmp] ([FTUphVersion], [FDCreateOn], [FTUphRemark], [FTCreateBy]) VALUES ( '01.01.00', getdate() , 'Deploy SIT #19', 'Napat');
END
GO

IF NOT EXISTS(SELECT FTUphVersion FROM TCNTUpgradeHisTmp WHERE FTUphVersion='02.01.00') BEGIN

	INSERT INTO TSysConfig (FTSysCode,FTSysApp,FTSysKey,FTSysSeq,FTGmnCode,FTSysStaAlwEdit,FTSysStaDataType,FNSysMaxLength,FTSysStaDefValue,FTSysStaDefRef,FTSysStaUsrValue,FTSysStaUsrRef,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy) 
	VALUES ('tCN_PlbUrl','CN','Company','1','COMP','1','0','0','','','https://firster.com/product/?sku={FTPdtCode}&branch={FTBchCode}&bu={FTPgpCode}','',getdate(),'00003','2022-08-04 00:00:00.000','Junthon M.')

INSERT INTO [TCNTUpgradeHisTmp] ([FTUphVersion], [FDCreateOn], [FTUphRemark], [FTCreateBy]) VALUES ( '02.01.00', getdate() , 'Deploy SIT #20', 'Napat');
END
GO

IF NOT EXISTS(SELECT FTUphVersion FROM TCNTUpgradeHisTmp WHERE FTUphVersion='02.02.00') BEGIN

	INSERT INTO TSysConfig_L (FTSysCode,FTSysApp,FTSysKey,FTSysSeq,FNLngID,FTSysName,FTSysDesc,FTSysRmk) 
	VALUES ('tCN_PlbUrl','CN','Company','1','1','ข้อมูล Url สำหรับสร้าง QR พิมพ์ป้ายราคา','ขัอมูล Url','')

	INSERT INTO TSysConfig_L (FTSysCode,FTSysApp,FTSysKey,FTSysSeq,FNLngID,FTSysName,FTSysDesc,FTSysRmk) 
	VALUES ('tCN_PlbUrl','CN','Company','2','2','Url for create QR print price tag','Url Data','')

INSERT INTO [TCNTUpgradeHisTmp] ([FTUphVersion], [FDCreateOn], [FTUphRemark], [FTCreateBy]) VALUES ( '02.02.00', getdate() , 'Deploy SIT #21', 'Napat');
END
GO

IF NOT EXISTS(SELECT FTUphVersion FROM TCNTUpgradeHisTmp WHERE FTUphVersion='03.01.00') BEGIN

	INSERT INTO TSysConfig_L (FTSysCode,FTSysApp,FTSysKey,FTSysSeq,FNLngID,FTSysName,FTSysDesc,FTSysRmk)
	VALUES ('tPS_Channel','CN','Company','5','1','ช่องทางการขาย','ช่องทางการขาย','')
	,('tPS_Channel','CN','Company','5','2','Channel','Channel','')

INSERT INTO [TCNTUpgradeHisTmp] ([FTUphVersion], [FDCreateOn], [FTUphRemark], [FTCreateBy]) VALUES ( '03.01.00', getdate() , 'Deploy SIT #22', 'Napat');
END
GO

IF NOT EXISTS(SELECT FTUphVersion FROM TCNTUpgradeHisTmp WHERE FTUphVersion='04.01.00') BEGIN

	INSERT INTO [TPSMFuncDT]([FTGhdCode], [FTSysCode], [FTLicPdtCode], [FNGdtPage], [FNGdtDefSeq], [FNGdtUsrSeq], [FNGdtBtnSizeX], [FNGdtBtnSizeY], [FTGdtCallByName], [FTGdtStaUse], [FNGdtFuncLevel], [FTGdtSysUse]) VALUES ('058', 'KB014', 'SF-VS058KB014', 1, 1, 1, 1, 1, 'C_KBDxChgAmtBill', '1', 1, '1')
	INSERT INTO [TPSMFuncDT]([FTGhdCode], [FTSysCode], [FTLicPdtCode], [FNGdtPage], [FNGdtDefSeq], [FNGdtUsrSeq], [FNGdtBtnSizeX], [FNGdtBtnSizeY], [FTGdtCallByName], [FTGdtStaUse], [FNGdtFuncLevel], [FTGdtSysUse]) VALUES ('058', 'KB015', 'SF-VS058KB015', 1, 2, 2, 1, 1, 'C_KBDxChgPerBill', '1', 1, '1')
	INSERT INTO [TPSMFuncDT]([FTGhdCode], [FTSysCode], [FTLicPdtCode], [FNGdtPage], [FNGdtDefSeq], [FNGdtUsrSeq], [FNGdtBtnSizeX], [FNGdtBtnSizeY], [FTGdtCallByName], [FTGdtStaUse], [FNGdtFuncLevel], [FTGdtSysUse]) VALUES ('057', 'KB014', 'SF-VS057KB014', 1, 3, 3, 0, 0, 'C_KBDxChgAmt', '1', 1, '1')
	INSERT INTO [TPSMFuncDT]([FTGhdCode], [FTSysCode], [FTLicPdtCode], [FNGdtPage], [FNGdtDefSeq], [FNGdtUsrSeq], [FNGdtBtnSizeX], [FNGdtBtnSizeY], [FTGdtCallByName], [FTGdtStaUse], [FNGdtFuncLevel], [FTGdtSysUse]) VALUES ('057', 'KB015', 'SF-VS057KB015', 1, 4, 4, 0, 0, 'C_KBDxChgPer', '1', 1, '1')

	INSERT INTO [TPSMFuncDT_L]([FTGhdCode], [FTSysCode], [FNLngID], [FTGdtName]) VALUES ('058', 'KB014', 1, 'ชาร์จเป็นจำนวน')
	INSERT INTO [TPSMFuncDT_L]([FTGhdCode], [FTSysCode], [FNLngID], [FTGdtName]) VALUES ('058', 'KB014', 2, 'Charge Amount')
	INSERT INTO [TPSMFuncDT_L]([FTGhdCode], [FTSysCode], [FNLngID], [FTGdtName]) VALUES ('058', 'KB015', 1, 'ชาร์จ %')
	INSERT INTO [TPSMFuncDT_L]([FTGhdCode], [FTSysCode], [FNLngID], [FTGdtName]) VALUES ('058', 'KB015', 2, 'Charge %')
	INSERT INTO [TPSMFuncDT_L]([FTGhdCode], [FTSysCode], [FNLngID], [FTGdtName]) VALUES ('057', 'KB014', 1, 'ชาร์จเป็นจำนวน')
	INSERT INTO [TPSMFuncDT_L]([FTGhdCode], [FTSysCode], [FNLngID], [FTGdtName]) VALUES ('057', 'KB014', 2, 'Charge by amount')
	INSERT INTO [TPSMFuncDT_L]([FTGhdCode], [FTSysCode], [FNLngID], [FTGdtName]) VALUES ('057', 'KB015', 1, 'ชาร์จเป็น %')
	INSERT INTO [TPSMFuncDT_L]([FTGhdCode], [FTSysCode], [FNLngID], [FTGdtName]) VALUES ('057', 'KB015', 2, 'Charge by percentage')

INSERT INTO [TCNTUpgradeHisTmp] ([FTUphVersion], [FDCreateOn], [FTUphRemark], [FTCreateBy]) VALUES ( '04.01.00', getdate() , 'Deploy SIT #23', 'Napat');
END
GO

IF NOT EXISTS(SELECT FTUphVersion FROM TCNTUpgradeHisTmp WHERE FTUphVersion='05.01.00') BEGIN

	-- สคริปพี่เอ็ม KPC Script upgrade database Backoffice-20220921_2112.sql
	UPDATE TSysDisPolicy SET FTDisStaPrice = '2',FDLastUpdOn = GETDATE(),FTLastUpdBy = 'Admin'

INSERT INTO [TCNTUpgradeHisTmp] ([FTUphVersion], [FDCreateOn], [FTUphRemark], [FTCreateBy]) VALUES ( '05.01.00', getdate() , 'Deploy SIT #24', 'Napat');
END
GO

IF NOT EXISTS(SELECT FTUphVersion FROM TCNTUpgradeHisTmp WHERE FTUphVersion='06.01.00') BEGIN

	INSERT INTO TCNMTxnAPI (FTApiCode,FTApiTxnType,FTApiPrcType,FTApiGrpPrc,FNApiGrpSeq,FTApiFmtCode,FTApiURL,FTApiLoginUsr,FTApiLoginPwd,FTApiToken,FDCreateOn,FTCreateBy,FDLastUpdOn,FTLastUpdBy,FTApiStaDisplay)
	VALUES ('00044','2','2','EXPT',14,'00002','','','','',GETDATE(),'NAPAT',GETDATE(),'NAPAT',NULL)

	INSERT INTO TCNMTxnAPI_L (FTApiCode,FNLngID,FTApiName,FTApiRmk)
	VALUES ('00044',1,'ส่งออกรายการขาย (E-Tax)',NULL)

INSERT INTO [TCNTUpgradeHisTmp] ([FTUphVersion], [FDCreateOn], [FTUphRemark], [FTCreateBy]) VALUES ( '06.01.00', getdate() , 'Deploy SIT #25', 'Napat');
END


