<?php 
//TH
$lang['tCMDTitle']                  = "นำเข้า - ส่งออก";
$lang['tCMDSearchDetail']           = "ค้นหา";
$lang['tCMDForm']                   = "จาก";
$lang['tCMDTo']                     = "ถึง";
$lang['tCMDLabelPanelHeadCons']     = "เงื่อนไขการนำเข้า - ส่งออก";
$lang['tCMDLabelPanelHeadDetail']   = "รายละเอียด";

//Validate
$lang['tCMDValImpNoBrowsFile']      = "** กรุณาเพิ่มไฟล์ข้อมูล";
$lang['tCMDValExpNoCondition']      = "** กรุณาตรวจสอบเงื่อนไขการส่งออก";
$lang['tCMDValExpNoDataInTable']    = "** กรุณานำข้อมูลเข้าตาราง";

//Status Return Data
$lang['tCMDStatusNotFondDataInFiles']   = "ไม่พบข้อมูลเอกสาร";
$lang['tCMDStatusFileNotFromatType']    = "เอกสารที่ใช้ในการนำเข้าข้อมูลไม่ถูกต้อง";
$lang['tCMDStatusChkFileDataImport']    = "กรุณาตรวจสอบข้อมูลการนำเข้า";
$lang['tCMDStatusChkProcessGone']       = "ข้อมูลชุดนี้ได้ทำการ Import ไปแล้วกรุณาตรวจสอบข้อมูลอีกครั้ง";
$lang['tCMDStatusErrorNotGenDocCode']   = "ไม่สามารถ Gen รหัสเอกสารได้กรุณาติดต่อ Admin";
$lang['tCMDStatusErrorNotInsertDoc']    = "เกิดข้อผิดผลาดไม่สามารถบันทึกเอกสารได้ !!!";
$lang['tCMDStatusErrorNotSendMQ']       = "เกิดข้อผิดผลาดไม่สามารถประมาลผลได้ !!!";

//RowData Status Import / Export
//Status Export
$lang['tCMDStaInProcess']   = "รอประมวลผล";
$lang['tCMDStaSuccess']     = "สำเร็จ";
$lang['tCMDStaUnsuccess']   = "เกิดข้อผิดผลาด";
//Status Import
$lang['tCMDStaCardSuccess']             = "ประมวลผลสำเร็จ";
$lang['tCMDStaCardWaiting']             = "รอการประมวลผล";

$lang['tCMDStaDepartNotValues']         = "ไม่พบข้อมูลหน่วยงานในเอกสารข้อมูล";
$lang['tCMDStaDepartNotFound']          = "ไม่พบข้อมูลหน่วยงานในระบบ";
$lang['tCMDStaDepartFoundSpecialChar']  = "พบอักขระพิเศษในข้อมูลหน่วยงาน";

$lang['tCMDStaCrdCodeNotValues']        = "ไม่พบเลขหลังบัตรในเอกสารข้อมูล";
$lang['tCMDStaCrdCodeNotFound']         = "ไม่พบเลขหลังบัตรในระบบ";
$lang['tCMDStaCrdCodeDup']              = "เลขหลังบัตรมีข้อมูลในระบบแล้ว";
$lang['tCMDStaCrdCodeOverMaxLength']    = "เลขหลังบัตรเกินที่กำหนดไว้";
$lang['tCMDStaCrdCodeFoundSpecialChar'] = "พบอักขระพิเศษในเลขหลังบัตร";

$lang['tCMDStaCtyCodeNotValues']        = "ไม่พบรหัสประเภทบัตรในเอกสารข้อมูล";
$lang['tCMDStaCtyCodeNotFound']         = "ไม่พบรหัสประเภทบัตรในระบบ";
$lang['tCMDStaCtyCodeOverMaxLength']    = "รหัสประเภทบัตรเกินที่กำหนดไว้";
$lang['tCMDStaCtyCodeFoundSpecialChar'] = "พบอักขระพิเศษในรหัสประเภทบัตร";


$lang['tCMDStaMoneyTopUpNotValues']     = "ไม่พบจำนวนยอดเงิน";
$lang['tCMDStaMoneyTopUpNotNumeric']    = "ยอดเงินไม่ตรงตามรูปแบบ";

$lang['tCMDStaOldCrdCodeNotValues']     = "ไม่พบรหัสบัตรเก่าในเอกสารข้อมูล";
$lang['tCMDStaOldCrdCodeNotFound']      = "ไม่พบรหัสบัตรเก่าในระบบ";

$lang['tCMDStaNewCrdCodeNotValues']     = "ไม่พบรหัสบัตรใหม่ในเอกสารข้อมูล";
$lang['tCMDStaNewCrdCodeDup']           = "พบรหัสบัตรใหม่มีในระบบแล้ว";
$lang['tCMDStaNewCrdCodeDupInVoid']     = "พบรหัสบัตรใหม่ในเอกสาร";
$lang['tCMDStaNewCrdCodeOverMaxLength'] = "รหัสบัตรใหม่เกินที่กำหนดไว้";

$lang['tCMDStaCrdHolderIdNotValues']        = "ไม่พบรหัสพนักงานในเอกสารข้อมูล";
$lang['tCMDStaCrdHolderIdOverMaxLength']    = "รหัสพนักงานเกินที่กำหนดไว้";
$lang['tCMDStaCrdHolderIdFoundSpecialChar'] = "พบอักขระพิเศษในรหัสพนักงาน";

$lang['tCMDStaCrdNameOverMaxLength']        = "ชื่อบัตร/สมาชิกเกินที่กำหนดไว้";

//Button
$lang['tCMDBtnProcess']     = "ประมวลผล";
$lang['tCMDBtnImportTbl']   = "นำข้อมูลเข้าตาราง";
$lang['tCMDBtnBrowseFile']  = "เลือกไฟล์";
$lang['tCMDBtnExcelMask']   = "ดาวน์โหลดแม่แบบ";

//From Type Condition
$lang['tCMDFromType']           = "ประเภท";
$lang['tCMDTypeImport']         = "นำเข้าข้อมูล";
$lang['tCMDTypeExport']         = "ส่งออกข้อมูล";
$lang['tCMDDataEntry']          = "รายการข้อมูล";
$lang['tCMDQtyCardSuccess']     = "จำนวนบัตร (สำเร็จ/ทั้งหมด)";
$lang['tCMDCardSuccessUnit']    = "(ใบ)";
$lang['tCMDDataEntryNewCard']   = "บัตรใหม่";
$lang['tCMDDataEntryTopUp']     = "เติมเงิน";
$lang['tCMDDataEntryTransCrd']  = "เปลี่ยนบัตร";
$lang['tCMDDataEntryClearCrd']  = "ล้างบัตร";
$lang['tCMDDataEntryCrdDetail'] = "ข้อมูลบัตร";
$lang['tCMDFileUplode']         = "ไฟล์ข้อมูล";
$lang['tCMDImportCons1']        = "นำเข้าเฉพาะข้อมูลใหม่เท่านั้น";
$lang['tCMDImportCons2']        = "นำเข้าข้อมูลใหม่และปรับปรุงรายละเอียดเดิม";
$lang['tCMDCardType']           = "ประเภทบัตร";
$lang['tCMDCardCode']           = "หมายเลขบัตร";
$lang['tCMDCardName']           = "ชื่อบัตร";
$lang['tCMDCardHolderID']       = "รหัสสมาชิก";


//Table Card Manage Data
$lang['tCMDTBNoData']       = "ไม่พบรายการข้อมูล";
$lang['tCMDTBNo']           = "ลำดับ";
$lang['tCMDTBCardCode']     = "เลขหลังบัตร";
$lang['tCMDTBCtyCode']      = "รหัสประเภทบัตร";
$lang['tCMDTBHolderIDCode'] = "รหัสพนักงาน";
$lang['tCMDTBCode']         = "รหัส";
$lang['tCMDTBName']         = "ชื่อ-สกุล";
$lang['tCMDTBStartDate']    = "วันที่เริ่มใช้บัตร";
$lang['tCMDTBExpireDate']   = "วันที่บัตรหมดอายุ";
$lang['tCMDTBCardType']     = "ประเภท";
$lang['tCMDTBStaType']      = "รูปแบบ";
$lang['tCMDTBStatus']       = "สถานะ";
$lang['tCMDTBTopUpAmount']  = "ยอดเงิน";
$lang['tCMDTBCardCodeOld']  = "เลขหลังบัตรเก่า";
$lang['tCMDTBCardCodeNew']  = "เลขหลังบัตรใหม่";
$lang['tCMDTBOtherName']    = "ชื่ออื่น";
$lang['tCMDTBDepartCode']   = "ชื่อหน่วยงาน";
$lang['tCMDTBOldCardLastValues']    = "มูลค่าเงินคงเหลือบัตรเก่า";


//Remark HD
$lang['tCMDDocHDImpNewCard']    = "เปิดบัตรใหม่โดยการอิมพอร์ตข้อมูล";
$lang['tCMDDocHDImpTopUp']      = "เติมเงินโดยการอิมพอร์ตข้อมูล";
$lang['tCMDDocHDImpTranfCard']  = "เปลี่ยนบัตรโดยการอิมพอร์ตข้อมูล";
$lang['tCMDDocHDImpClaerCard']  = "ล้างบัตรโดยการอิมพอร์ตข้อมูล";

$lang['tCMDTCardImportExportCardStatus']     = "สถานะบัตร";
$lang['tCMDTCardImportExportCardProcess']    = "ประมวลผล";
$lang['tCMDTCardImportExportCardRemark']     = "หมายเหตุ";
$lang['tCMDTCardImportExportCardDelete']     = "ลบ";


$lang['tCMDStaCardTypeNotValues']       = "ไม่พบรหัสประเภทบัตรในเอกสารข้อมูล";
$lang['tCMDStaCardTypeNotFound']        = "ไม่พบรหัสประเภทบัตรในระบบ";
$lang['tCMDStaCardTypeOverMaxLength']   = "รหัสประเภทบัตรเกินที่กำหนดไว้";

$lang['tCMDSuccess']    = 'สมบูรณ์';
$lang['tCMDUnSuccess']  = 'ไม่สมบูรณ์';
$lang['tCMDStaCardNA']  = 'N/A';

//input validate
$lang['tCMDValidImportExport']   = "กรุณาเพิ่มหรือรันเลขที่เอกสาร";
