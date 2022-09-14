<?php

date_default_timezone_set('Asia/Bangkok');

// ** Center Route
$route['rptReport/(:any)/(:any)/(:any)']    = 'report/report/cReport/index/$1/$2/$3';
$route['rptReportMain']                     = 'report/report/cReport/FCNoCRPTViewPageMain';
$route['rptReportCondition']                = 'report/report/cReport/FCNoCRPTViewCondition';
$route['rptReportChkDataInTSysHisExport']   = 'report/report/cReport/FCNoCRPTChkDataInTSysHisExport';
$route['rptReportConfirmDownloadFile']      = 'report/report/cReport/FCNoCRPTConfirmDownloadFile';
$route['rptReportCancelDownloadFile']       = 'report/report/cReport/FCNoCRPTCancelDownloadFile';
$route['rptReportGetBchByAgenCode']       = 'report/report/cReport/FCNtGetBchByAgenCode';

// รายงานยอดขายตามการชำระเงิน
$route['rptRptSaleToPayment'] = 'report/reportsale/cRptSalePayment/index';
$route['rptRptSaleToPaymentClickPage']  = 'report/reportsale/cRptSalePayment/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptSaleToPaymentCallExportFile'] = "report/reportsale/cRptSalePayment/FSvCCallRptExportFile";
/** ===== รายงานการขาย =============================================================================================== */
// รายงานยอดขายตามบิล (Pos)
$route['rptRptSaleByBill'] = "report/reportsale/cRptSaleByBill/index";
$route['rptRptSaleByBillClickPage'] = "report/reportsale/cRptSaleByBill/FSvCCallRptViewBeforePrintClickPage";
$route['rptRptSaleByBillCallExportFile'] = "report/reportsale/cRptSaleByBill/FSvCCallRptExportFile";

// รายงานยอดขายตามสินค้า
$route['rptRptSaleByProduct'] = "report/reportsale/cRptSaleByProduct/index";
$route['rptRptSaleByProductClickPage'] = "report/reportsale/cRptSaleByProduct/FSvCCallRptViewBeforePrintClickPage";
$route['rptRptSaleByProductCallExportFile'] = "report/reportsale/cRptSaleByProduct/FSvCCallRptExportFile";

// รายงานภาษีขาย (POS)
$route['rptRptTaxSalePos'] = "report/reportsale/cRptTaxSalePos/index";
$route['rptRptTaxSalePosClickPage'] = "report/reportsale/cRptTaxSalePos/FSvCCallRptViewBeforePrintClickPage";
$route['rptRptTaxSalePosCallExportFile'] = "report/reportsale/cRptTaxSalePos/FSvCCallRptExportFile";

// รายงานภาษีขายตามวันที่ (POS)
$route['rptRptTaxSalePosByDate'] = "report/reportsale/cRptTaxSalePosByDate/index";
$route['rptRptTaxSalePosByDateClickPage'] = "report/reportsale/cRptTaxSalePosByDate/FSvCCallRptViewBeforePrintClickPage";
$route['rptRptTaxSalePosByDateCallExportFile'] = "report/reportsale/cRptTaxSalePosByDate/FSvCCallRptExportFile";

//รายงานความเคลื่อนไหวสินค้า Pos+VD
$route['rtpMovePosVD'] = 'report/reportMovePosVD/cRptMovePosVD/index';
$route['rtpMovePosVDClickPage'] = 'report/reportMovePosVD/cRptMovePosVD/FSvCCallRptViewBeforePrintClickPage';
$route['rtpMovePosVDCallExportFile'] = "report/reportMovePosVD/cRptMovePosVD/FSvCCallRptExportFile";

/** ===== รายงานสินค้าคงคลัง (Pos) ===================================================================================== */
$route['rptRptInventoryPos'] = 'report/reportInventoryPos/cRptInventoryPos/index';
$route['rptRptInventoryPosClickPage'] = 'report/reportInventoryPos/cRptInventoryPos/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptInventoryPosCallExportFile'] = 'report/reportInventoryPos/cRptInventoryPos/FSvCCallRptExportFile';

/** ===== รายงานตู้สินค้า (Vending) ===================================================================================== */
/** ===== รายงานการขาย ================================================================= */
// รายงานยอดขายตามการชำระเงินแบบสรุป  (Vending)
$route['rptSalePaymentSummary'] = 'report/reportsalepaymentsummary/cRptSalePaymentSummary/index';
$route['rptRptSalePaymentSummaryClickPage'] = 'report/reportsalepaymentsummary/cRptSalePaymentSummary/FSvCCallRptViewBeforePrintClickPage';
$route['rptSalePaymentSummaryCallExportFile'] = "report/reportsalepaymentsummary/cRptSalePaymentSummary/FSvCCallRptExportFile";

/** ===== รายงานสินค้าคงคลัง ============================================================= */
// รายงานการตรวจนับสต็อก (Vending)
$route['rptRptAdjStockVending'] = 'report/reportstkvd/cRptAdjStockVending/index';
$route['rptRptAdjStockVendingClickPage'] = 'report/reportstkvd/cRptAdjStockVending/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptAdjStockVendingCallExportFile'] = "report/reportstkvd/cRptAdjStockVending/FSvCCallRptExportFile";

/** ===================== รายงานสินค้าขายดี (Vending) ======================================== */
$route['rptRptBestSaleVending'] = 'report/reportbestsalevd/cRptBestSaleVending/index';
$route['rptRptBestSaleVendingClickPage'] = 'report/reportbestsalevd/cRptBestSaleVending/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptBestSaleVendingCallExportFile'] = "report/reportbestsalevd/cRptBestSaleVending/FSvCCallRptExportFile";

/** ===================== รายงานยอดขายตามการชำระเงินแบบละเอียด (Vending) ===================== */
$route['rptRptSalePayDetailVending'] = 'report/reportsalerecivevd/cRptSaleReciveVD/index';
$route['rptRptSalePayDetailVendingClickPage'] = 'report/reportsalerecivevd/cRptSaleReciveVD/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptSalePayDetailVendingCallExportFile'] = "report/reportsalerecivevd/cRptSaleReciveVD/FSvCCallRptExportFile";

/** ===================================================================================================================================================================================== */

/** =============================================================================== รายงานตู้สินค้า (Vending) =============================================================================== */

/** ===================================================================================================================================================================================== */

/** =============================================================================== รายงานตู้ฝากของ (Locker) =============================================================================== */

// =============================================================================== รายงานตู้ฝากของ ===============================================================================
// รายงานเปลี่ยนสถานะช่องฝากขาย
$route['rptRptChangeStaSale'] = 'report/reportlocker/cRptChangeStaSale/index';
$route['rptRptChangeStaSaleClickPage'] = 'report/reportlocker/cRptChangeStaSale/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptChangeStaSaleCallExportFile'] = "report/reportlocker/cRptChangeStaSale/FSvCCallRptExportFile";

// รายงานการเปิดตู้โดยผู้ดูแลระบบ
$route['rptRptOpenSysAdmin'] = 'report/reportlocker/cRptOpenSysAdmin/index';
$route['rptRptOpenSysAdminClickPage'] = 'report/reportlocker/cRptOpenSysAdmin/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptOpenSysAdminCallExportFile'] = "report/reportlocker/cRptOpenSysAdmin/FSvCCallRptExportFile";

// รายงานภาษีขาย (Locker)
$route['rptRptTaxSaleLocker'] = 'report/reportlocker/cRptTaxSaleLocker/index';
$route['rptRptTaxSaleLockerClickPage'] = 'report/reportlocker/cRptTaxSaleLocker/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptTaxSaleLockerCallExportFile'] = "report/reportlocker/cRptTaxSaleLocker/FSvCCallRptExportFile";

// รายงานยอดขายตามการชำระเงินแบบละเอียด (Locker)
$route['rptRptSaleByPaymentDetail'] = 'report/reportlocker/cRptSaleByPaymentDetail/index';
$route['rptRptSaleByPaymentDetailClickPage'] = 'report/reportlocker/cRptSaleByPaymentDetail/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptSaleByPaymentDetailCallExportFile'] = "report/reportlocker/cRptSaleByPaymentDetail/FSvCCallRptExportFile";
// Create By Witsarut 6/12/2019
// รายงานการฝากตามขนาดช่อง
$route['rptDepositAccSlotSize'] = 'report/reportdepositaccslotsize/cRptDepositAccSlotSize/index';
$route['rptDepositAccSlotSizeClickPage'] = 'report/reportdepositaccslotsize/cRptDepositAccSlotSize/FSvCCallRptViewBeforePrintClickPage';
$route['rptDepositAccSlotSizeCallExportFile'] = "report/reportdepositaccslotsize/cRptDepositAccSlotSize/FSvCCallRptExportFile";

// รายงานยอดฝากตามบริษัทขนส่ง (Locker)
$route['rptRentAmountFollowCourier'] = 'report/reportlocker/cRptRentAmountFolloweCourier/index';
$route['rptRentAmountFollowCourierClickPage'] = 'report/reportlocker/cRptRentAmountFolloweCourier/FSvCCallRptViewBeforePrintClickPage';
$route['rptRentAmountFollowCourierCallExportFile'] = "report/reportlocker/cRptRentAmountFolloweCourier/FSvCCallRptExportFile";

// รายงานยอดฝากแบบละเอียด (Locker)
$route['rptRentAmountDetail'] = 'report/reportlocker/cRptRentAmountDetail/index';
$route['rptRentAmountDetailClickPage'] = 'report/reportlocker/cRptRentAmountDetail/FSvCCallRptViewBeforePrintClickPage';
$route['rptRentAmountDetailCallExportFile'] = "report/reportlocker/cRptRentAmountDetail/FSvCCallRptExportFile";

// Create By Witsarut 03122019
// รายงานการฝากตามช่วงเวลา (Locker)
$route['rptTimeDeposit'] = 'report/reportlocker/cRptTimeDeposit/index';
$route['rptTimeDepositClickPage'] = 'report/reportlocker/cRptTimeDeposit/FSvCCallRptViewBeforePrintClickPage';
$route['rptTimeDepositCallExportFile'] = "report/reportlocker/cRptTimeDeposit/FSvCCallRptExportFile";

// รายงานการฝากตามช่วงเวลา แบบละเอียด (Locker)
$route['rptRptLockerDropByDate'] = 'report/reportlocker/cRptDropByDate/index';
$route['rptRptLockerDropByDateClickPage'] = 'report/reportlocker/cRptDropByDate/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptLockerDropByDateCallExportFile'] = "report/reportlocker/cRptDropByDate/FSvCCallRptExportFile";

// รายงานการรับตามช่วงเวลา แบบละเอียด (Locker)
$route['rptRptLockerPickByDate'] = 'report/reportlocker/cRptPickByDate/index';
$route['rptRptLockerPickByDateClickPage'] = 'report/reportlocker/cRptPickByDate/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptLockerPickByDateCallExportFile'] = "report/reportlocker/cRptPickByDate/FSvCCallRptExportFile";

// รายงาน - การจองช่องฝากของ
$route['rptRptBookingLocker']               = 'report/reportlocker/cRptBookingLocker/index';
$route['rptRptBookingLockerClickPage']      = 'report/reportlocker/cRptBookingLocker/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptBookingLockerCallExportFile'] = "report/reportlocker/cRptBookingLocker/FSvCCallRptExportFile";

// รายงาน - ยอดฝากแบบละเอียด
$route['rptLockerDetailDepositAmount'] = 'report/reportlocker/cRptDetailDepositAmount/index';
$route['rptLockerDetailDepositAmountClickPage'] = 'report/reportlocker/cRptDetailDepositAmount/FSvCCallRptViewBeforePrintClickPage';
$route['rptLockerDetailDepositAmountCallExportFile'] = "report/reportlocker/cRptDetailDepositAmount/FSvCCallRptExportFile";

// รายงาน - การชำระเงิน ตามบิล
$route['rptLockerPaymentByBill'] = 'report/reportlocker/cRptPaymentByBill/index';
$route['rptLockerPaymentByBillClickPage'] = 'report/reportlocker/cRptPaymentByBill/FSvCCallRptViewBeforePrintClickPage';
$route['rptLockerPaymentByBillCallExportFile'] = "report/reportlocker/cRptPaymentByBill/FSvCCallRptExportFile";

// รายงาน - การชำระเงิน (New Create By Wasin 09-12-2019)
$route['rptLockerPayment']                  = 'report/reportlocker/cRptLockerPayment/index';
$route['rptLockerPaymentClickPage']         = 'report/reportlocker/cRptLockerPayment/FSvCCallRptViewBeforePrintClickPage';
$route['rptLockerPaymentCallExportFile']    = "report/reportlocker/cRptLockerPayment/FSvCCallRptExportFile";

/** ============================================================================================================================================= */

/** ======================================== รายงานการโอนสินค้า (ตู้ Vending) ============================================================================ */
$route['rptRptProductTransfer'] = 'report/reportproducttransfer/cRptProductTransfer/index';
$route['rptRptProductTransferClickPage'] = 'report/reportproducttransfer/cRptProductTransfer/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptProductTransferCallExportFile'] = 'report/reportproducttransfer/cRptProductTransfer/FSvCCallRptExportFile';

/** ================================================================================================================================================== */

/** ======================================== รายงานยอดขายตามการชำระเงินแบบละเอียด (Pos) ================================================================= */
$route['rptRptSaleRecive'] = 'report/reportsale/cRptSaleRecive/index';
$route['rptRptSaleReciveClickPage'] = 'report/reportsale/cRptSaleRecive/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptSaleReciveCallExportFile'] = 'report/reportsale/cRptSaleRecive/FSvCCallRptExportFile';
/** ================================================================================================================================================== */

/** ========================================= รายงานสินค้าคงคลัง (Vending) =============================================================================== */
$route['rptRptInventory'] = 'report/reportInventory/cRptInventory/index';
$route['rptRptInventoryClickPage'] = 'report/reportInventory/cRptInventory/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptInventoryCallExportFile'] = 'report/reportInventory/cRptInventory/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ========================================= รายงานภาษีขายตามกลุ่มร้านค้า (Vending) ======================================================================== */
$route['rptRptSaleShopGroup'] = 'report/reportsaleshopgroup/cRptsaleshopgroup/index';
$route['rptRptSaleShopGroupClickPage'] = 'report/reportsaleshopgroup/cRptsaleshopgroup/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptSaleShopGroupCallExportFile'] = 'report/reportsaleshopgroup/cRptsaleshopgroup/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ========================================= รายงานข้อมูลการรับสินค้าทดลองที่ตู้ Vending ======================================================================== */
$route['rptRcvInfoTrialPdtVD']                   = 'report/reportvending/rptrcvinfotrialpdtvd_controller/index';
$route['rptRcvInfoTrialPdtVDClickPage']          = 'report/reportvending/rptrcvinfotrialpdtvd_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRcvInfoTrialPdtVDCallExportFile']     = 'report/reportvending/rptrcvinfotrialpdtvd_controller/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ========================================= รายงานยอดขายตามบิล (Vending) ======================================================================== */
$route['rptRptSalesbyBill'] = 'report/reportSalesbybill/cRptSalesbybill/index';
$route['rptRptSalesbyBillClickPage'] = 'report/reportSalesbybill/cRptSalesbybill/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptSalesbyBillCallExportFile'] = 'report/reportSalesbybill/cRptSalesbybill/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ========================================= รายงานยอดขายตามสินค้า (Vending) ======================================================================== */
$route['rptRptSaleByProductVD'] = 'report/reportSaleByProductVD/cRptSaleByProductVD/index';
$route['rptRptSaleByProductVDClickPage'] = 'report/reportSaleByProductVD/cRptSaleByProductVD/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptSaleByProductVDCallExportFile'] = 'report/reportSaleByProductVD/cRptSaleByProductVD/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ========================================= รายงานวิเคราะห์กำไรขาดทุนตามสินค้า (Vending) ======================================================================== */
$route['rptRptAnalysisProfitLossProductVending'] = 'report/reportAnalysisProfitLossProductVending/cRptAnalysisProfitLossProductVending/index';
$route['rptRptAnalysisProfitLossProductVendingClickPage'] = 'report/reportAnalysisProfitLossProductVending/cRptAnalysisProfitLossProductVending/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptAnalysisProfitLossProductVendingCallExportFile'] = 'report/reportAnalysisProfitLossProductVending/cRptAnalysisProfitLossProductVending/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ========================================= รายงานวิเคราะห์กำไรขาดทุนตามสินค้า (Pos) ======================================================================== */
$route['rptRptAnalysisProfitLossProductPos'] = 'report/reportAnalysisProfitLossProductPos/cRptAnalysisProfitLossProductPos/index';
$route['rptRptAnalysisProfitLossProductPosClickPage'] = 'report/reportAnalysisProfitLossProductPos/cRptAnalysisProfitLossProductPos/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptAnalysisProfitLossProductPosCallExportFile'] = 'report/reportAnalysisProfitLossProductPos/cRptAnalysisProfitLossProductPos/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

// รายงานยอดขายตามการชำระเงิน Locker
$route['rptRptLocToPayment'] = 'report/reportlocker/cRptLocPayment/index';
$route['rptRptLocToPaymentCallExportFile'] = 'report/reportlocker/cRptLocPayment/FSvCCallRptExportFile';
// $route ['rptRptSaleShopByDateClickPage']    = 'report/reportsale/cRptSaleShopByDate/FSvCCallRptViewBeforePrintClickPage';

// รายงาน - สินค้าขายดีตามจำนวน
$route['rptBestSell'] = 'report/rptbestsell/cRptBestSell/index';
$route['rptBestSellClickPage'] = 'report/rptbestsell/cRptBestSell/FSvCCallRptViewBeforePrintClickPage';
$route['rptBestSellCallExportFile'] = 'report/rptbestsell/cRptBestSell/FSvCCallRptExportFile';

// รายงาน - สินค้าขายดีตามมูลค่า
$route['rptBestSellByValue'] = 'report/rptbestsellbyvalue/cRptBestSellByValue/index';
$route['rptBestSellByValueClickPage'] = 'report/rptbestsellbyvalue/cRptBestSellByValue/FSvCCallRptViewBeforePrintClickPage';
$route['rptBestSellByValueCallExportFile'] = 'report/rptbestsellbyvalue/cRptBestSellByValue/FSvCCallRptExportFile';

/*===== Begin Card Report ==============================================================*/
// 1. รายงานข้อมูลการใช้บัตร 004001001 rptCrdUseCard1
$route['rptCrdUseCard1'] = 'report/reportcard/cRptUseCard1/index';
$route['rptCrdUseCard1ClickPage'] = 'report/reportcard/cRptUseCard1/FSvCCallRptViewBeforePrintClickPage';
$route['rptCrdUseCard1CallExportFile'] = 'report/reportcard/cRptUseCard1/FSvCCallRptExportFile';

// 2. รายงานตรวจสอบสถานะบัตร 004001002 rptCrdCheckStatusCard
$route['rptCrdCheckStatusCard'] = 'report/reportcard/cRptCheckStatusCard/index';
$route['rptCrdCheckStatusCardClickPage'] = 'report/reportcard/cRptCheckStatusCard/FSvCCallRptViewBeforePrintClickPage';
$route['rptCrdCheckStatusCardCallExportFile'] = 'report/reportcard/cRptCheckStatusCard/FSvCCallRptExportFile';

// 3. รายงานโอนข้อมูลบัตร 004001003 rptCrdTransferCardInfo
$route['rptCrdTransferCardInfo'] = 'report/reportcard/cRptTransferCardInfo/index';
$route['rptCrdTransferCardInfoClickPage'] = 'report/reportcard/cRptTransferCardInfo/FSvCCallRptViewBeforePrintClickPage';
$route['rptCrdTransferCardInfoCallExportFile'] = 'report/reportcard/cRptTransferCardInfo/FSvCCallRptExportFile';

// 4. รายงานการปรับมูลค่าเงินสดในบัตร 004001004 rptCrdAdjustCashInCard
$route['rptCrdAdjustCashInCard'] = 'report/reportcard/cRptAdjustCashInCard/index';
$route['rptCrdAdjustCashInCardClickPage'] = 'report/reportcard/cRptAdjustCashInCard/FSvCCallRptViewBeforePrintClickPage';
$route['rptCrdAdjustCashInCardCallExportFile'] = 'report/reportcard/cRptAdjustCashInCard/FSvCCallRptExportFile';

// 5. รายงานการล้างมูลค่าบัตรเพื่อกลับมาใช้งานใหม่ 004001005 rptCrdClearCardValueForReuse
$route['rptCrdClearCardValueForReuse'] = 'report/reportcard/cRptClearCardValueForReuse/index';
$route['rptCrdClearCardValueForReuseClickPage'] = 'report/reportcard/cRptClearCardValueForReuse/FSvCCallRptViewBeforePrintClickPage';
$route['rptCrdClearCardValueForReuseCallExportFile'] = 'report/reportcard/cRptClearCardValueForReuse/FSvCCallRptExportFile';

// 6. รายงานการลบข้อมูลบัตรที่ไม่ใช้งาน 004001006 rptCrdCardNoActive
$route['rptCrdCardNoActive'] = 'report/reportcard/cRptCardNoActive/index';
$route['rptCrdCardNoActiveClickPage'] = 'report/reportcard/cRptCardNoActive/FSvCCallRptViewBeforePrintClickPage';
$route['rptCrdCardNoActiveCallExportFile'] = 'report/reportcard/cRptCardNoActive/FSvCCallRptExportFile';

// 7. รายงานจำนวนรอบการใช้บัตร 004001007 rptCrdCardTimesUsed
$route['rptCrdCardTimesUsed'] = 'report/reportcard/cRptCardTimesUsed/index';
$route['rptCrdCardTimesUsedClickPage'] = 'report/reportcard/cRptCardTimesUsed/FSvCCallRptViewBeforePrintClickPage';
$route['rptCrdCardTimesUsedCallExportFile'] = 'report/reportcard/cRptCardTimesUsed/FSvCCallRptExportFile';

// 8. รายงานบัตรคงเหลือ 004001008 rptCrdCardBalance
$route['rptCrdCardBalance'] = 'report/reportcard/cRptCardBalance/index';
$route['rptCrdCardBalanceClickPage'] = 'report/reportcard/cRptCardBalance/FSvCCallRptViewBeforePrintClickPage';
$route['rptCrdCardBalanceCallExportFile'] = 'report/reportcard/cRptCardBalance/FSvCCallRptExportFile';

// 9. รายงานยอดสะสมบัตรหมดอายุ 004001009 rptCrdCollectExpireCard
$route['rptCrdCollectExpireCard'] = 'report/reportcard/cRptCollectExpireCard/index';
$route['rptCrdCollectExpireCardClickPage'] = 'report/reportcard/cRptCollectExpireCard/FSvCCallRptViewBeforePrintClickPage';
$route['rptCrdCollectExpireCardCallExportFile'] = 'report/reportcard/cRptCollectExpireCard/FSvCCallRptExportFile';

// 10. รายงานรายการต้นงวดบัตรและเงินสด 004001010 rptCrdPrinciple
$route['rptCrdCardPrinciple'] = 'report/reportcard/cRptCardPrinciple/index';
$route['rptCrdCardPrincipleClickPage'] = 'report/reportcard/cRptCardPrinciple/FSvCCallRptViewBeforePrintClickPage';
$route['rptCrdCardPrincipleCallExportFile'] = 'report/reportcard/cRptCardPrinciple/FSvCCallRptExportFile';

// 11. รายงานข้อมูลบัตร 004001011 rptCrdCardDetail
$route['rptCrdCardDetail'] = 'report/reportcard/cRptCardDetail/index';
$route['rptCrdCardDetailClickPage'] = 'report/reportcard/cRptCardDetail/FSvCCallRptViewBeforePrintClickPage';
$route['rptCrdCardDetailCallExportFile'] = 'report/reportcard/cRptCardDetail/FSvCCallRptExportFile';

// 12. รายงานตรวจสอบการเติมเงิน 004001012 rptCrdCheckPrepaid
$route['rptCrdCheckPrepaid'] = 'report/reportcard/cRptCheckPrepaid/index';
$route['rptCrdCheckPrepaidClickPage'] = 'report/reportcard/cRptCheckPrepaid/FSvCCallRptViewBeforePrintClickPage';
$route['rptCrdCheckPrepaidCallExportFile'] = 'report/reportcard/cRptCheckPrepaid/FSvCCallRptExportFile';

// 13. รายงานตรวจสอบข้อมูลการใช้บัตร 004001013 rptCrdCheckCardUseInfo
$route['rptCrdCheckCardUseInfo'] = 'report/reportcard/cRptCheckCardUseInfo/index';
$route['rptCrdCheckCardUseInfoClickPage'] = 'report/reportcard/cRptCheckCardUseInfo/FSvCCallRptViewBeforePrintClickPage';
$route['rptCrdCheckCardUseInfoCallExportFile'] = 'report/reportcard/cRptCheckCardUseInfo/FSvCCallRptExportFile';

// 14. รายงานการเติมเงิน 004001014 rptCrdTopUp
$route['rptCrdTopUp'] = 'report/reportcard/cRptTopUp/index';
$route['rptCrdTopUpClickPage'] = 'report/reportcard/cRptTopUp/FSvCCallRptViewBeforePrintClickPage';
$route['rptCrdTopUpCallExportFile'] = 'report/reportcard/cRptTopUp/FSvCCallRptExportFile';

// 15. รายงานข้อมูลการใช้บัตร 004001015 (แบบละเอียด) rptCrdUseCard2
$route['rptCrdUseCard2'] = 'report/reportcard/cRptUseCard2/index';
$route['rptCrdUseCard2ClickPage'] = 'report/reportcard/cRptUseCard2/FSvCCallRptViewBeforePrintClickPage';
$route['rptCrdUseCard2CallExportFile'] = 'report/reportcard/cRptUseCard2/FSvCCallRptExportFile';
/*===== End Card Report ================================================================*/


/*===== Begin Analysis Report ==========================================================*/
// 1. รายงานยอดขายร้านค้า-ตามวันที่ 005001001 rptSaleShopByDate
$route['rptSaleShopByDate'] = 'report/reportanalysis/cRptSaleShopByDate/index';
$route['rptSaleShopByDateClickPage'] = 'report/reportanalysis/cRptSaleShopByDate/FSvCCallRptViewBeforePrintClickPage';
$route['rptSaleShopByDateCallExportFile'] = 'report/reportanalysis/cRptSaleShopByDate/FSvCCallRptExportFile';

// 2. รายงานยอดขายร้านค้า-ตามร้านค้า 005001002 rptSaleShopByShop
$route['rptSaleShopByShop'] = 'report/reportanalysis/cRptSaleShopByShop/index';
$route['rptSaleShopByShopClickPage'] = 'report/reportanalysis/cRptSaleShopByShop/FSvCCallRptViewBeforePrintClickPage';
$route['rptSaleShopByShopCallExportFile'] = 'report/reportanalysis/cRptSaleShopByShop/FSvCCallRptExportFile';

// 3. รายงานการเคลื่อนไหวบัตร-แบบสรุป 005001003 rptCrdCardActiveSummary
// 4. รายงานการเคลื่อนไหวบัตร-แบบละเอียด 005001004 rptCrdCardActiveDetail
// 5. รายงานสรุปยอดเงินคงเหลือบัตรไม่ได้แลกคืน 005001005 rptCrdUnExchangeBalance
/*===== End Analysis Report ============================================================*/

/** ========================================= รายงาน - การฝากที่ยังไม่มารับ (Locker) ======================================================================== */
$route['rptRptDepositsNotPicked']               = 'report/reportlocker/cRptDepositsNotPicked/index';
$route['rptRptDepositsNotPickedClickPage']      = 'report/reportlocker/cRptDepositsNotPicked/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptDepositsNotPickedCallExportFile'] = 'report/reportlocker/cRptDepositsNotPicked/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ========================================= รายงาน - การรับตามช่วงเวลา (Locker) ======================================================================== */
$route['rptRptRecePtionByTime']               = 'report/reportlocker/cRptRecePtionByTime/index';
$route['rptRptRecePtionByTimeClickPage']      = 'report/reportlocker/cRptRecePtionByTime/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptRecePtionByTimeCallExportFile'] = 'report/reportlocker/cRptRecePtionByTime/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ========================================= รายงาน - การรับ-ฝากแบบละเอียด (Locker) ======================================================================== */
$route['rptRptDetailReceiveDeposit']               = 'report/reportlocker/cRptDetailReceiveDeposit/index';
$route['rptRptDetailReceiveDepositClickPage']      = 'report/reportlocker/cRptDetailReceiveDeposit/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptDetailReceiveDepositCallExportFile'] = 'report/reportlocker/cRptDetailReceiveDeposit/FSvCCallRptExportFile';
/** =================================================================================================================================================== */


// Create By Witsarut  18/12/2019
/** ===================== กลุ่มรายงาน พิเศษ ===================== */
$route['rptCRSaleTaxByWeekly']               = 'report/reportsalespecial/cRptCRSaleTaxByWeekly/index';
$route['rptCRSaleTaxByWeeklyClickPage']      = 'report/reportsalespecial/cRptCRSaleTaxByWeekly/FSvCCallRptViewBeforePrintClickPage';
$route['rptCRSaleTaxByWeeklyCallExportFile'] = 'report/reportsalespecial/cRptCRSaleTaxByWeekly/FSvCCallRptExportFile';


/** ======================================== รายงานยอดขาย (Pos Service) ================================================================= */
$route['rptRptCrSale'] = 'report/reportsalespecial/cRptCrSale/index';
$route['rptRptCrSaleClickPage'] = 'report/reportsalespecial/cRptCrSale/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptCrSaleCallExportFile'] = 'report/reportsalespecial/cRptCrSale/FSvCCallRptExportFile';
/** ================================================================================================================================================== */

/** ========================================= รายงาน - ยอดขาย (POS+VD) ======================================================================== */
$route['rptRptSalePosVD']                        = 'report/reportsalespecial/cRptSalePosVD/index';
$route['rptRptSalePosVDClickPage']               = 'report/reportsalespecial/cRptSalePosVD/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptSalePosVDCallExportFile']          = 'report/reportsalespecial/cRptSalePosVD/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ========================================= รายงาน - รายงานยอดขายผลิตภัณฑ์ของวัน (POS Vending) ========================================================== */
$route['rptRptCrSaleProductByDay']                          = 'report/reportsalespecial/cRptSaleProductByDay/index';
$route['rptRptCrSaleProductByDayClickPage']                 = 'report/reportsalespecial/cRptSaleProductByDay/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptCrSaleProductByDayCallExportFile']            = 'report/reportsalespecial/cRptSaleProductByDay/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ========================================= รายงาน - รายงานยอดขายผลิตภัณฑ์ของเดือน (POS Vending) ========================================================== */
$route['rptRptCrSaleProductByMonth']                        = 'report/reportsalespecial/cRptSaleProductByMonth/index';
$route['rptRptCrSaleProductByMonthClickPage']               = 'report/reportsalespecial/cRptSaleProductByMonth/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptCrSaleProductByMonthCallExportFile']          = 'report/reportsalespecial/cRptSaleProductByMonth/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ======================================================= รายงานภาษีขาย (วัน) ==================================================================== */
$route['rptDailySalesTax']                  = 'report/reportsalespecial/cRptDailySalesTax/index';
$route['rptDailySalesTaxClickPage']        = 'report/reportsalespecial/cRptDailySalesTax/FSvCCallRptViewBeforePrintClickPage';
$route['rptDailySalesTaxCallExportFile']   = 'report/reportsalespecial/cRptDailySalesTax/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ======================================================= รายงานภาษีขาย (รายเดือน) ==================================================================== */
$route['rptRptSpecialSaleTaxByMonthly']                 = 'report/reportsalespecial/cRptSaleTaxByMonthly/index';
$route['rptRptSpecialSaleTaxByMonthlyClickPage']        = 'report/reportsalespecial/cRptSaleTaxByMonthly/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptSpecialSaleTaxByMonthlyCallExportFile']   = 'report/reportsalespecial/cRptSaleTaxByMonthly/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

// รายงานยอดขายผลิตภัณฑ์ของสัปดาห์ (POS Vending) 001003012 rptProductSaleOfWeek
$route['rptProductSaleOfWeek'] = "report/reportProductSaleOfWeek/cRptProductSaleOfWeek/index";
$route['rptProductSaleOfWeekClickPage'] = "report/reportProductSaleOfWeek/cRptProductSaleOfWeek/FSvCCallRptViewBeforePrintClickPage";
$route['rptProductSaleOfWeekCallExportFile'] = "report/reportProductSaleOfWeek/cRptProductSaleOfWeek/FSvCCallRptExportFile";

/** ======================================================= (CR) รายงานยอดขายรายวัน (POS Service) ==================================================================== */
$route['rptRptDailySalesPosSv']                         = 'report/reportsalespecial/cRptDailySalesPosSv/index';
$route['rptRptDailySalesPosSvClickPage']                = 'report/reportsalespecial/cRptDailySalesPosSv/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptDailySalesPosSvCallExportFile']           = 'report/reportsalespecial/cRptDailySalesPosSv/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ======================================================= (CR) รายงานยอดขายรายสัปดาห์ (POS Service) ==================================================================== */
$route['rptRptWeeklySale']                         = 'report/reportsalespecial/cRptWeeklySale/index';
$route['rptRptWeeklySaleClickPage']                = 'report/reportsalespecial/cRptWeeklySale/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptWeeklySaleCallExportFile']           = 'report/reportsalespecial/cRptWeeklySale/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ======================================== รายงานยอดขายรายเดือน (Pos Service) ================================================================= */
$route['rptRptCrSaleMonth'] = 'report/reportsalespecial/cRptCrSaleMonth/index';
$route['rptRptCrSaleMonthClickPage'] = 'report/reportsalespecial/cRptCrSaleMonth/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptCrSaleMonthCallExportFile'] = 'report/reportsalespecial/cRptCrSaleMonth/FSvCCallRptExportFile';
/** ================================================================================================================================================== */

/** ======================================================= (CR) รายงานยอดขายผลิตภัณฑ์ (POS Vending) (แบบรายละเอียดรายวัน) ==================================================================== */
$route['rptProductSalesPosVD']                         = 'report/reportsalespecial/cRptProductSalesPosVD/index';
$route['rptProductSalesPosVDClickPage']                = 'report/reportsalespecial/cRptProductSalesPosVD/FSvCCallRptViewBeforePrintClickPage';
$route['rptProductSalesPosVDCallExportFile']           = 'report/reportsalespecial/cRptProductSalesPosVD/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ======================================================= รายงานการนำฝากแบบละเอียด สาขา ==================================================================== */
$route['rptBankDepositBch']                         = 'report/reportlocker/cRptBankDepositBch/index';
$route['rptBankDepositBchClickPage']                = 'report/reportlocker/cRptBankDepositBch/FSvCCallRptViewBeforePrintClickPage';
$route['rptBankDepositBchCallExportFile']           = 'report/reportlocker/cRptBankDepositBch/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ======================================================= รายงาน ยอดเงินขาด/เงินเกิน ของแคชเชียร์ (ประจำวัน) ==================================================================== */
$route['rptMnyShotOver']                         = 'report/reportsale/cRptMnyShotOver/index';
$route['rptMnyShotOverClickPage']                = 'report/reportsale/cRptMnyShotOver/FSvCCallRptViewBeforePrintClickPage';
$route['rptMnyShotOverCallExportFile']           = 'report/reportsale/cRptMnyShotOver/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ======================================================= รายงาน ยอดเงินขาด/เงินเกิน ของแคชเชียร์ ประจำวัน(ละเอียด) ==================================================================== */
$route['rptMnyShotOverDairy']                         = 'report/reportsale/cRptMnyShotOverDaily/index';
$route['rptMnyShotOverDairyClickPage']                = 'report/reportsale/cRptMnyShotOverDaily/FSvCCallRptViewBeforePrintClickPage';
$route['rptMnyShotOverDairyCallExportFile']           = 'report/reportsale/cRptMnyShotOverDaily/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ======================================================= รายงาน ยอดเงินขาด/เงินเกิน ของแคชเชียร์ รายเดือน(ละเอียด) ==================================================================== */
$route['rptMnyShotOverMonthly']                         = 'report/reportsale/cRptMnyShotOverMonthly/index';
$route['rptMnyShotOverMonthlyClickPage']                = 'report/reportsale/cRptMnyShotOverMonthly/FSvCCallRptViewBeforePrintClickPage';
$route['rptMnyShotOverMonthlyCallExportFile']           = 'report/reportsale/cRptMnyShotOverMonthly/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ======================================================= รายงานยอดขาย - ตามจุดขาย ==================================================================== */
$route['rptsaledailybypos']                         = 'report/rptsaledailybypos/cRptSaleDailyByPos/index';
$route['rptsaledailybyposClickPage']                = 'report/rptsaledailybypos/cRptSaleDailyByPos/FSvCCallRptViewBeforePrintClickPage';
$route['rptsaledailybyposCallExportFile']           = 'report/rptsaledailybypos/cRptSaleDailyByPos/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ======================================================= รายงานยอดขาย - ตามแคชเชียร์ ==================================================================== */
$route['rptSalesDailyByCashier']                         = 'report/reportsale/cRptSalesDailyByCashier/index';
$route['rptSalesDailyByCashierClickPage']                = 'report/reportsale/cRptSalesDailyByCashier/FSvCCallRptViewBeforePrintClickPage';
$route['rptSalesDailyByCashierCallExportFile']           = 'report/reportsale/cRptSalesDailyByCashier/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ======================================================= รายงาน - จำนวนขายประจำเดือน - ตามสินค้า ==================================================================== */
$route['rptSMP']                         = 'report/reportsale/cRptSalesMonthProduct/index';
$route['rptSMPClickPage']                = 'report/reportsale/cRptSalesMonthProduct/FSvCCallRptViewBeforePrintClickPage';
$route['rptSMPCallExportFile']           = 'report/reportsale/cRptSalesMonthProduct/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ======================================================= รายงาน - การคืนสินค้าตามวันที่ ==================================================================== */
$route['rptRPD']                         = 'report/reportsale/cRptReturnProductByDate/index';
$route['rptRPDClickPage']                = 'report/reportsale/cRptReturnProductByDate/FSvCCallRptViewBeforePrintClickPage';
$route['rptRPDCallExportFile']           = 'report/reportsale/cRptReturnProductByDate/FSvCCallRptExportFile';
/** =================================================================================================================================================== */


// Report For AdaStatDose
// Create By Witsarut 12/02/2020

/** ======================================================= รายางานการเติมสินค้า ==================================================================== */
$route['rptProductRefill']                  = 'report/reportproductrefill/cRptProductRefill/index';
$route['rptProductRefillClickPage']         = 'report/reportproductrefill/cRptProductRefill/FSvCCallRptViewBeforePrintClickPage';
$route['rptProductRefillCallExportFile']    = 'report/reportproductrefill/cRptProductRefill/FSvCCallRptExportFile';

/** ======================================== รายงานสินค้าคงคลังตามสินค้าตามตู้  ================================================================= */
$route['rptProductByCabinet']               = 'report/reportproductbycabinet/cRptPdtByCabinet/index';
$route['rptProductByCabinetClickPage']      = 'report/reportproductbycabinet/cRptPdtByCabinet/FSvCCallRptViewBeforePrintClickPage';
$route['rptProductByCabinetCallExportFile'] = 'report/reportproductbycabinet/cRptPdtByCabinet/FSvCCallRptExportFile';

/** ======================================== รายงานการสั่งขาย  ================================================================= */
$route['rptSaleOrder']                      = 'report/reportsale/cRptSaleOrder/index';
$route['rptSaleOrderClickPage']             = 'report/reportsale/cRptSaleOrder/FSvCCallRptViewBeforePrintClickPage';
$route['rptSaleOrderCallExportFile']        = 'report/reportsale/cRptSaleOrder/FSvCCallRptExportFile';

//report Create by nonpawich 17/2/2020

/** ======================================== รายงานสินค้าไม่ผ่านอนุมัติ  ================================================================= */
$route['rptSaleSoNotPass']                      = 'report/reportsalesonotpass/cRptSaleSoNotPass/index';
$route['rptSaleSoNotPassClickPage']             = 'report/reportsalesonotpass/cRptSaleSoNotPass/FSvCCallRptViewBeforePrintClickPage';
$route['rptSaleSoNotPassCallExportFile']        = 'report/reportsalesonotpass/cRptSaleSoNotPass/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** =================================================================================================================================================== */
// Create By Witsarut 29/04/2020
// รายงานยอดขายสิ้นวัน
$route['rptRptDayEndSales']               = 'report/reportsale/cRptDayEndSales/index';
$route['rptRptDayEndSalesClickPage']      = 'report/reportsale/cRptDayEndSales/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptDayEndSalesCallExportFile'] = "report/reportsale/cRptDayEndSales/FSvCCallRptExportFile";
/** =================================================================================================================================================== */

// Create By Witsarut 29/04/2020
// รายงาน- ภาษีขาย (เต็มรูป)
$route['rptRptTaxSaleFull']                 = "report/reportsale/cRptTaxSaleFull/index";
$route['rptRptTaxSaleFullClickPage']        = "report/reportsale/cRptTaxSaleFull/FSvCCallRptViewBeforePrintClickPage";
$route['rptRptTaxSaleFullCallExportFile']   = "report/reportsale/cRptTaxSaleFull/FSvCCallRptExportFile";

// Create By Saharat 04/05/2020
// รายงาน- ภาษีขายตามวันที่ (เต็มรูป)
$route['rptRptTaxSalePosByDateFull']                 = "report/reportsale/cRptTaxSalePosByDateFull/index";
$route['rptRptTaxSalePosByDateFullClickPage']        = "report/reportsale/cRptTaxSalePosByDateFull/FSvCCallRptViewBeforePrintClickPage";
$route['rptRptTaxSalePosByDateFullCallExportFile']   = "report/reportsale/cRptTaxSalePosByDateFull/FSvCCallRptExportFile";

// รายงาน ยอดขายตามแคชเชียร์ - ตามเครื่องจุดขาย
$route['rptSaleByCashierAndPos'] = "report/reportsale/cRptSaleByCashierAndPos/index";
$route['rptSaleByCashierAndPosClickPage'] = "report/reportsale/cRptSaleByCashierAndPos/FSvCCallRptViewBeforePrintClickPage";
$route['rptSaleByCashierAndPosCallExportFile'] = "report/reportsale/cRptSaleByCashierAndPos/FSvCCallRptExportFile";

// Create By Nattakit 09/07/2020
// รายงาน - ยกเลิกบิลตามวันที่
$route['rptCancelBillByDate'] = "report/reportsale/cRptCancelBillByDate/index";
$route['rptCancelBillByDateClickPage'] = "report/reportsale/cRptCancelBillByDate/FSvCCallRptViewBeforePrintClickPage";
$route['rptCancelBillByDateCallExportFile'] = "report/reportsale/cRptCancelBillByDate/FSvCCallRptExportFile";

// Create By Nattakit 09/07/2020
// รายงาน - ยกเลิกรายการตามวันที่
$route['rptCancelPdtDetailByDate'] = "report/reportsale/cRptCancelPdtDetailByDate/index";
$route['rptCancelPdtDetailByDateClickPage'] = "report/reportsale/cRptCancelPdtDetailByDate/FSvCCallRptViewBeforePrintClickPage";
$route['rptCancelPdtDetailByDateCallExportFile'] = "report/reportsale/cRptCancelPdtDetailByDate/FSvCCallRptExportFile";

//Create By Witsarut 21/07/2020
//รายงาน - ยอดขายตามสมาชิก
$route['rptSaleMember']                 = "report/reportsale/cRptSaleMember/index";
$route['rptSaleMemberClickPage']        = "report/reportsale/cRptSaleMember/FSvCCallRptViewBeforePrintClickPage";
$route['rptSaleMemberCallExportFile']   = "report/reportsale/cRptSaleMember/FSvCCallRptExportFile";

//Create By Witsarut 21/07/2020
//รายงาน - แต้มแบบสรุป (Point By Customer)
$route['rptPointByCst']                 = "report/reportsale/cRptPointByCst/index";
$route['rptPointByCstClickPage']        = "report/reportsale/cRptPointByCst/FSvCCallRptViewBeforePrintClickPage";
$route['rptPointByCstCallExportFile']   = "report/reportsale/cRptPointByCst/FSvCCallRptExportFile";

// Create By Witsarut 24/08/2020
// รายงาน - ภาษีตามสินค้า
$route['rptTaxByProduct']               = "report/reportsale/cRptTaxByProduct/index";
$route['rptTaxByProductClickPage']      = "report/reportsale/cRptTaxByProduct/FSvCCallRptViewBeforePrintClickPage";
$route['rptTaxByProductCallExportFile'] = "report/reportsale/cRptTaxByProduct/FSvCCallRptExportFile";

// New Report AdaPos5FC
// Create BY Witsarut 18-09-2020
// รายงาน - การแลก/คืน บัตรเงินสด
$route['rptRedeemReturnCard']                  = 'report/reportcard/cRptRedeemReturnCard/index';
$route['rptRedeemReturnCardClickPage']         = 'report/reportcard/cRptRedeemReturnCard/FSvCCallRptViewBeforePrintClickPage';
$route['rptRedeemReturnCardCallExportFile']    = 'report/reportcard/cRptRedeemReturnCard/FSvCCallRptExportFile';

// Create BY Witsarut 24-09-2020
// รายงาน - รายได้เนื่องจากการไม่คืนบัตร
// Report -IncomeNotReturnCard
$route['rptIncomeNotReturnCard']                  = 'report/reportcard/cRptIncomeNotReturnCard/index';
$route['rptIncomeNotReturnCardClickPage']         = 'report/reportcard/cRptIncomeNotReturnCard/FSvCCallRptViewBeforePrintClickPage';
$route['rptIncomeNotReturnCardCallExportFile']    = 'report/reportcard/cRptIncomeNotReturnCard/FSvCCallRptExportFile';

// Create By Worakorn 02/10/2020
// รายงาน - ยอดขายตามบิลตามวันที่ตามการชำระเงิน (ละเอียด)
$route['rptSaleBillPaymentDate']               = "report/reportsale/cRptSaleBillPaymentDate/index";
$route['rptSaleBillPaymentDateClickPage']      = "report/reportsale/cRptSaleBillPaymentDate/FSvCCallRptViewBeforePrintClickPage";
$route['rptSaleBillPaymentDateCallExportFile'] = "report/reportsale/cRptSaleBillPaymentDate/FSvCCallRptExportFile";

/** ===== Begin ข้อมูลหลัก (Master) =================================================================================== */
/** ===== Begin รายงานข้อมูลหลัก ========================================================= */
// รายงาน การปรับราคาสินค้า
$route['rptADJPrice'] = 'report/reportmaster/cRptAdjPrice/index';
$route['rptADJPriceClickPage'] = 'report/reportmaster/cRptAdjPrice/FSvCCallRptViewBeforePrintClickPage';
$route['rptADJPriceCallExportFile'] = 'report/reportmaster/cRptAdjPrice/FSvCCallRptExportFile';

// รายงานการปรับราคาสินค้าตามกลุ่มราคา
$route['rptADJPriceByGroup']                  = 'report/reportproductpricebygroup/cRptProductADJPriceByGroup/index';
$route['rptADJPriceByGroupClickPage']         = 'report/reportproductpricebygroup/cRptProductADJPriceByGroup/FSvCCallRptViewBeforePrintClickPage';
$route['rptADJPriceByGroupCallExportFile']    = 'report/reportproductpricebygroup/cRptProductADJPriceByGroup/FSvCCallRptExportFile';
/** ===== End รายงานข้อมูลหลัก =========================================================== */
/** ===== End ข้อมูลหลัก (Master) ===================================================================================== */

// Create By Witsarut 02/10/2020
// รายงาน - ยอดขายตามวันที่ตามการชำระเงิน (สรุป)
$route['rptSalesByDatePayment']               = "report/reportsale/cRptSalesByDatePayment/index";
$route['rptSalesByDatePaymentClickPage']      = "report/reportsale/cRptSalesByDatePayment/FSvCCallRptViewBeforePrintClickPage";
$route['rptSalesByDatePaymentCallExportFile'] = "report/reportsale/cRptSalesByDatePayment/FSvCCallRptExportFile";

//Create By Sooksanti 05/10/2020
//รายงาน - ยอดขายตามบิลตามสินค้า
$route['rptSalByBillPdt']               = "report/reportsalespecial/cRptSalByBillPdt/index";
$route['rptSalByBillPdtClickPage']      = "report/reportsalespecial/cRptSalByBillPdt/FSvCCallRptViewBeforePrintClickPage";
$route['rptSalByBillPdtCallExportFile'] = "report/reportsalespecial/cRptSalByBillPdt/FSvCCallRptExportFile";

//Create By Sooksanti 16/10/2020
//รายงาน - ยอดขายตามสาขาตามวันที่
$route['rptSalBchByDate']               = "report/reportsale/cRptSalBchByDate/index";
$route['rptSalBchByDateClickPage']      = "report/reportsale/cRptSalBchByDate/FSvCCallRptViewBeforePrintClickPage";
$route['rptSalBchByDateCallExportFile'] = "report/reportsale/cRptSalBchByDate/FSvCCallRptExportFile";

//Create By Sooksanti 21/10/2020
//รายงาน - ยอดขายตามช่วงเวลา
$route['rptSalTimePrdTmp']               = "report/reportsale/cRptSalTimePrdTmp/index";
$route['rptSalTimePrdTmpClickPage']      = "report/reportsale/cRptSalTimePrdTmp/FSvCCallRptViewBeforePrintClickPage";
$route['rptSalTimePrdTmpCallExportFile'] = "report/reportsale/cRptSalTimePrdTmp/FSvCCallRptExportFile";

//Create By Nattakit 02/11/2020
//รายงาน - ยอดขายตามสาขาตามสินค้า - สินค้าชุด
$route['rptSalByPdtSet']                 = "report/reportsale/cRptSalByPdtSet/index";
$route['rptSalByPdtSetClickPage']        = "report/reportsale/cRptSalByPdtSet/FSvCCallRptViewBeforePrintClickPage";
$route['rptSalByPdtSetCallExportFile']   = "report/reportsale/cRptSalByPdtSet/FSvCCallRptExportFile";

// Create By Witsarut 19-11-2020
// รายงาน - สินค้าถึงจุดสั่งซื้อตามคลัง
$route['rptPdtPointWah']             = "report/reportPointWah/cPdtPointWah/index";
$route['rptPdtPointWahClickPage']    = "report/reportPointWah/cPdtPointWah/FSvCCallRptViewBeforePrintClickPage";
$route['rptPdtPointWahExportFile']   = "report/reportPointWah/cPdtPointWah/FSvCCallRptExportFile";

// Create By Nattakit 20-11-2020
// รายงาน - รับเข้าสินค้าตามวันที่
$route['rptDocPdtTwi']             = "report/reportdocpdttwi/cRptDocPdtTwi/index";
$route['rptDocPdtTwiClickPage']    = "report/reportdocpdttwi/cRptDocPdtTwi/FSvCCallRptViewBeforePrintClickPage";
$route['rptDocPdtTwiExportFile']   = "report/reportdocpdttwi/cRptDocPdtTwi/FSvCCallRptExportFile";

// Create By Nattakit 23-11-2020
// รายงาน - การคืนสืนค้าตามวันที่
$route['rptRetPdtVd']                         = 'report/reportRetPdtVdByDate/cRptRetPdtVdByDate/index';
$route['rptRetPdtVdClickPage']                = 'report/reportRetPdtVdByDate/cRptRetPdtVdByDate/FSvCCallRptViewBeforePrintClickPage';
$route['rptRetPdtVdCallExportFile']           = 'report/reportRetPdtVdByDate/cRptRetPdtVdByDate/FSvCCallRptExportFile';

// Create By Sooksanti 28/12/2020
// รายงาน - การนำสินค้าออกจากตู้
$route['rptTransferVendingOut']               = 'report/rptTransferVendingOut/cRptTransferVendingOut/index';
$route['rptTransferVendingOutClickPage']      = 'report/rptTransferVendingOut/cRptTransferVendingOut/FSvCCallRptViewBeforePrintClickPage';
$route['rptTransferVendingOutCallExportFile'] = 'report/rptTransferVendingOut/cRptTransferVendingOut/FSvCCallRptExportFile';

// Create By Supawat 29/12/2020
// รายงาน - การเบิกออกสินค้าตามวันที่
$route['rptRequisitionProductByDate']               = 'report/rptRequisitionProductByDate/cRptRequisitionProductByDate/index';
$route['rptRequisitionProductByDateClickPage']      = 'report/rptRequisitionProductByDate/cRptRequisitionProductByDate/FSvCCallRptViewBeforePrintClickPage';
$route['rptRequisitionProductByDateCallExportFile'] = 'report/rptRequisitionProductByDate/cRptRequisitionProductByDate/FSvCCallRptExportFile';


// Create By Witsarut 19/01/2021
// รายงาน - การขายสินค้าโปรโมชัน
$route['rptPdtSalePromotion']               = 'report/reportsale/cRptPdtSalePromotion/index';
$route['rptPdtSalePromotionClickPage']      = 'report/reportsale/cRptPdtSalePromotion/FSvCCallRptViewBeforePrintClickPage';
$route['rptPdtSalePromotionCallExportFile'] = 'report/reportsale/cRptPdtSalePromotion/FSvCCallRptExportFile';


// Create By Witsarut 19/01/2021
// รายงาน - การขายสินค้าโปรโมชันตามเอกสาร
$route['rptPdtSalePromotionPerDoc']               = 'report/reportsale/cRptPdtSalePromotionPerDoc/index';
$route['rptPdtSalePromotionPerDocClickPage']      = 'report/reportsale/cRptPdtSalePromotionPerDoc/FSvCCallRptViewBeforePrintClickPage';
$route['rptPdtSalePromotionPerDocCallExportFile'] = 'report/reportsale/cRptPdtSalePromotionPerDoc/FSvCCallRptExportFile';


// Create By Witsarut 19/01/2021
// รายงาน - การขายสินค้าโปรโมชันตามเอกสาร
$route['rptPdtSalePromotionPerDoc']               = 'report/reportsale/cRptPdtSalePromotionPerDoc/index';
$route['rptPdtSalePromotionPerDocClickPage']      = 'report/reportsale/cRptPdtSalePromotionPerDoc/FSvCCallRptViewBeforePrintClickPage';
$route['rptPdtSalePromotionPerDocCallExportFile'] = 'report/reportsale/cRptPdtSalePromotionPerDoc/FSvCCallRptExportFile';

// Create BY Witsarut 21/01/2021
// รายงาน - เปลียบเทียบยอดขายตามสินค้า (MTD)
$route['rptCompareSaleByPdt']                   = 'report/reportsale/cRptCompareSaleByPdt/index';
$route['rptCompareSaleByPdtClickPage']          = 'report/reportsale/cRptCompareSaleByPdt/FSvCCallRptViewBeforePrintClickPage';
$route['rptCompareSaleByPdtCallExportFile']     = 'report/reportsale/cRptCompareSaleByPdt/FSvCCallRptExportFile';

$route['dashboardsaleMainReportPage/(:any)']           = 'report/reportsale/cRptCompareSaleByPdt/FSvCDSHSALMainPageReport/$1';
$route['dashboardsaleMainReportPageQty/(:any)']        = 'report/reportsale/cRptCompareSaleByPdt/FSvCDSHSALMainPageReportQty/$1';

$route['dashboardsaleRptCompareSaleByPdt']      = 'report/reportsale/cRptCompareSaleByPdt/FSvCDSHSALViewRptCompareSaleByPdt';
$route['dashboardsaleRptCompareSaleByPdtQty']   = 'report/reportsale/cRptCompareSaleByPdt/FSvCDSHSALViewRptCompareSaleByPdtQty';



// Create By Witsarut 25/01/2021
// รายงาน - เปรียบเทียบยอดขายตามประเภทสินค้า
$route['rptCompareSaleByPdtType']                   = 'report/reportsale/cRptCompareSaleByPdtType/index';
$route['rptCompareSaleByPdtTypeClickPage']          = 'report/reportsale/cRptCompareSaleByPdtType/FSvCCallRptViewBeforePrintClickPage';
$route['rptCompareSaleByPdtTypeCallExportFile']     = 'report/reportsale/cRptCompareSaleByPdtType/FSvCCallRptExportFile';
$route['dashboardsaleReportCompareSaleByPdtTypeQTY/(:any)']  = 'report/reportsale/cRptCompareSaleByPdtType/FSvCDSHSALViewReportCompareSaleByPdtTypeQTY/$1';
$route['dashboardsaleReportCompareSaleByPdtType/(:any)']  = 'report/reportsale/cRptCompareSaleByPdtType/FSvCDSHSALViewReportCompareSaleByPdtType/$1';



// Create By Worakorn 25/01/2021
// รายงาน - ประวัติการเบิกออกสินค้า
$route['rptPickingHistory']                   = 'report/reporthistory/cRptPickingHistory/index';
$route['rptPickingHistoryClickPage']          = 'report/reporthistory/cRptPickingHistory/FSvCCallRptViewBeforePrintClickPage';
$route['rptPickingHistoryCallExportFile']     = 'report/reporthistory/cRptPickingHistory/FSvCCallRptExportFile';


// Create By Worakorn 26/01/2021
// รายงาน - ประวัติการโอนสินค้าระหว่างสาขา
$route['rptTransferHistoryBch']                   = 'report/reporthistory/cRptTransferHistoryBch/index';
$route['rptTransferHistoryBchClickPage']          = 'report/reporthistory/cRptTransferHistoryBch/FSvCCallRptViewBeforePrintClickPage';
$route['rptTransferHistoryBchCallExportFile']     = 'report/reporthistory/cRptTransferHistoryBch/FSvCCallRptExportFile';



// Create By Worakorn 26/01/2021
//  รายงาน - สินค้าสินค้าคงเหลือ - ตามสาขา
$route['rptRptInventoriesByBch']                   = 'report/reportinventoriesbybch/cRptInventoriesByBch/index';
$route['rptRptInventoriesByBchClickPage']          = 'report/reportinventoriesbybch/cRptInventoriesByBch/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptInventoriesByBchCallExportFile']     = 'report/reportinventoriesbybch/cRptInventoriesByBch/FSvCCallRptExportFile';


// Create By Witsarut 26012021
/** ===== รายงาน - สินค้าคงเหลือ - กลุ่มสินค้า  ===================================================================================== */
$route['rptRptInventoryPdtGrp']                = 'report/reportInventoryPdtGrp/cRptInventoryPdtGrp/index';
$route['rptRptInventoryPdtGrpClickPage']       = 'report/reportInventoryPdtGrp/cRptInventoryPdtGrp/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptInventoryPdtGrpCallExportFile']  = 'report/reportInventoryPdtGrp/cRptInventoryPdtGrp/FSvCCallRptExportFile';

// Create By Witsarut 27012021
// รายงาน - สินค้าถึงจุดสั่งซื้อตามสินค้า
$route['rptReorderPointPerPdt']             = "report/reportReorderPointPerPdt/cReorderPointPerPdt/index";
$route['rptReorderPointPerPdtClickPage']    = "report/reportReorderPointPerPdt/cReorderPointPerPdt/FSvCCallRptViewBeforePrintClickPage";
$route['rptReorderPointPerPdtExportFile']   = "report/reportReorderPointPerPdt/cReorderPointPerPdt/FSvCCallRptExportFile";

// Create By Witsarut 30012021
// รายงาน - ประวัติการรับเข้าสินค้า
$route['rptPdtHisTnfIN']             = "report/reportProductTnfIN/cPdtHisTnfIN/index";
$route['rptPdtHisTnfINClickPage']    = "report/reportProductTnfIN/cPdtHisTnfIN/FSvCCallRptViewBeforePrintClickPage";
$route['rptPdtHisTnfINExportFile']   = "report/reportProductTnfIN/cPdtHisTnfIN/FSvCCallRptExportFile";

// Create By Witsarut 01022021
$route['rptPdtHisTnfBch']             = "report/reportrptPdtHisTnfBch/cPdtHisTnfBch/index";
$route['rptPdtHisTnfBchClickPage']    = "report/reportrptPdtHisTnfBch/cPdtHisTnfBch/FSvCCallRptViewBeforePrintClickPage";
$route['rptPdtHisTnfBchExportFile']   = "report/reportrptPdtHisTnfBch/cPdtHisTnfBch/FSvCCallRptExportFile";


// Create By Worakorn 01022021
$route['rptPdtStock']             = "report/reportpdtstock/cRptPdtStock/index";
$route['rptPdtStockClickPage']    = "report/reportpdtstock/cRptPdtStock/FSvCCallRptViewBeforePrintClickPage";
$route['rptPdtStockExportFile']   = "report/reportpdtstock/cRptPdtStock/FSvCCallRptExportFile";

// Create By Sooksanti 16/02/2021
$route['rptLicClosetExpir']             = "report/rptLicClosetExpir/cRptLicClosetExpir/index";
$route['rptLicClosetExpirClickPage']    = "report/rptLicClosetExpir/cRptLicClosetExpir/FSvCCallRptViewBeforePrintClickPage";
$route['rptLicClosetExpirExportFile']   = "report/rptLicClosetExpir/cRptLicClosetExpir/FSvCCallRptExportFile";


// Create By Witsarut 15/02/2021
// รายงาน - การขายรอการชำระเงิน
$route['rptSalePending']               = 'report/reportsale/cRptSalePending/index';
$route['rptSalePendingClickPage']      = 'report/reportsale/cRptSalePending/FSvCCallRptViewBeforePrintClickPage';
$route['rptSalePendingExportFile']     = 'report/reportsale/cRptSalePending/FSvCCallRptExportFile';

// รายงาน สินค้า
$route['rptEntryProduct'] = 'report/reportentryproduct/Rptentryproduct_controller/index';
$route['rptEntryProductClickPage']  = 'report/reportentryproduct/Rptentryproduct_controller/FSvCCallRptViewBeforePrintClickPage';
// รายงาน หน่วยสินค้า
$route['rptEntryProductUnit'] = 'report/reportentryproduct/Rptentryproductunit_controller/index';
$route['rptEntryProductUnitClickPage']  = 'report/reportentryproduct/Rptentryproductunit_controller/FSvCCallRptViewBeforePrintClickPage';
// รายงาน เซลล์ทู
$route['rptRptSellThrough'] = 'report/reporsellto/Rptsellto_controller/index';
$route['rptRptSellThroughClickPage']  = 'report/reporsellto/Rptsellto_controller/FSvCCallRptViewBeforePrintClickPage';

//Create By mos 14/07/2021
//รายงาน - ยอดขายตามช่องทางการขาย
$route['rptPSSDailyBySChn']                 = "report/reportsale/Rptpssdailybyschn_controller/index";
$route['rptPSSDailyBySChnClickPage']        = "report/reportsale/Rptpssdailybyschn_controller/FSvCCallRptViewBeforePrintClickPage";
$route['rptPSSDailyBySChnCallExportFile']   = "report/reportsale/Rptpssdailybyschn_controller/FSvCCallRptExportFile";

//Create By doz 29/03/2022
//รายงาน - ยอดขายสิ้นวัน (KPC)
$route['rptRptDayEndSalesKPC']                 = "report/reportsale/RptDayEndSalesKPC_controller/index";
$route['rptRptDayEndSalesKPCClickPage']        = "report/reportsale/RptDayEndSalesKPC_controller/FSvCCallRptViewBeforePrintClickPage";
$route['rptRptDayEndSalesKPCCallExportFile']   = "report/reportsale/RptDayEndSalesKPC_controller/FSvCCallRptExportFile";

//Create By doz 30/03/2022
//รายงาน - ยอดขายตามแคชเชียร์ (KPC)
$route['rptSalesDailyByCashierKPC']                         = 'report/reportsale/RptSalesDailyByCashierKPC_controller/index';
$route['rptSalesDailyByCashierKPCClickPage']                = 'report/reportsale/RptSalesDailyByCashierKPC_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptSalesDailyByCashierKPCCallExportFile']           = 'report/reportsale/RptSalesDailyByCashierKPC_controller/FSvCCallRptExportFile';





