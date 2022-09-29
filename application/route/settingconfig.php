<?php

// ตั้งค่าระบบ
$route['SettingConfig/(:any)/(:any)']      = 'settingconfig/settingconfig/cSettingconfig/index/$1/$2';
$route['SettingConfigGetList']             = 'settingconfig/settingconfig/cSettingconfig/FSvSETGetPageList';

//Content ในตั้งค่าระบบ
$route['SettingConfigLoadViewSearch']      = 'settingconfig/settingconfig/cSettingconfig/FSvSETGetPageListSearch';
$route['SettingConfigLoadTable']           = 'settingconfig/settingconfig/cSettingconfig/FSvSETSettingGetTable';
$route['SettingConfigSave']                = 'settingconfig/settingconfig/cSettingconfig/FSxSETSettingEventSave';
$route['SettingConfigUseDefaultValue']     = 'settingconfig/settingconfig/cSettingconfig/FSxSETSettingUseDefaultValue';

//Content รหัสอัตโนมัติ
$route['SettingAutonumberLoadViewSearch']  = 'settingconfig/settingconfig/cSettingconfig/FSvSETAutonumberGetPageListSearch';
$route['SettingAutonumberLoadTable']       = 'settingconfig/settingconfig/cSettingconfig/FSvSETAutonumberSettingGetTable';
$route['SettingAutonumberLoadPageEdit']    = 'settingconfig/settingconfig/cSettingconfig/FSvSETAutonumberPageEdit';
$route['SettingAutonumberSave']            = 'settingconfig/settingconfig/cSettingconfig/FSvSETAutonumberEventSave';

//กำหนดเงื่อนไขส่วนลด
$route['discountpolicy/(:any)/(:any)']       = 'settingconfig/discountpolicy/cDiscountpolicy/index/$1/$2';
$route['discountpolicyList']                 = 'settingconfig/discountpolicy/cDiscountpolicy/FSvDPCDisPageList';
$route['discountpolicyLoadTable']            = 'settingconfig/discountpolicy/cDiscountpolicy/FSvDPCDisGetdataTable';
$route['discountpolicySaveData']             = 'settingconfig/discountpolicy/cDiscountpolicy/FSvDPCDisSaveData';

//CompanySetingConnection (ตั้งค่าการเชื่อมต่อ API)
$route['CompSettingCon/(:any)/(:any)']      = 'settingconfig/compsetting/cCompSetting/index/$1/$2';
$route['CompSettingConfigGetList']          = 'settingconfig/compsetting/cCompSetting/FSvSETCompGetPageList';
$route['CompSettingConfigLoadViewSearch']   = 'settingconfig/compsetting/cCompSetting/FSvSETCompGetPageListSearch';
$route['CompSettingDataTable']              = 'company/compsettingconnection/cCompSettingConnection/FSvCCompConnectDataList';

//ตั้งค่าเมนู
$route['settingmenu/(:any)/(:any)']          = 'settingconfig/settingmenu/cSettingmenu/index/$1/$2';
$route['SettingMenuGetPage']                 = 'settingconfig/settingmenu/cSettingmenu/FSxCSMUGetPageSettingmenu';

//Module
$route['SettingMenuAddEditModule']           = 'settingconfig/settingmenu/cSettingmenu/FSxCSMUAddEditModule';
$route['CallModalModulEdit']                 = 'settingconfig/settingmenu/cSettingmenu/FSxCSMUCallModalEditModule';
$route['SettingMenuDelModule']               = 'settingconfig/settingmenu/cSettingmenu/FSxCSMUDelModule';
$route['CheckDupSeq']                        = 'settingconfig/settingmenu/cSettingmenu/FSxCSMUCheckDupSeq';

//MenuGrp
$route['SettingMenuAddEditMenuGrp']          = 'settingconfig/settingmenu/cSettingmenu/FSxCSMUAddEditMenuGrp';
$route['CallModalMenuGrpEdit']               = 'settingconfig/settingmenu/cSettingmenu/FSxCSMUCallModalEditMenuGrp';
$route['SettingMenuDelMenuGrp']              = 'settingconfig/settingmenu/cSettingmenu/FSxCSMUDelMenuGrp';


//MenuList
$route['SettingMenuAddEditMenuList']          = 'settingconfig/settingmenu/cSettingmenu/FSxCSMUAddEditMenuList';
$route['CallModalMenuListEdit']               = 'settingconfig/settingmenu/cSettingmenu/FSxCSMUCallModalEditMenuList';
$route['SettingMenuDelMenuList']              = 'settingconfig/settingmenu/cSettingmenu/FSxCSMUDelMenuList';

//StaUse
$route['UpdateStaUse']                        = 'settingconfig/settingmenu/cSettingmenu/FSxCSMUUpdateStaUse';
$route['CallMaxValueSequence']                = 'settingconfig/settingmenu/cSettingmenu/FSxCSMUCallMaxSequence';

//Report
$route['SettingReportGetPage']                = 'settingconfig/settingmenu/cSettingreport/FSxCSRTGetPageSettingreport';
$route['CallMaxValueSequenceRpt']             = 'settingconfig/settingmenu/cSettingreport/FSxCSRTCallMaxSequence';
$route['GenCodeRpt']                          = 'settingconfig/settingmenu/cSettingreport/FSxCSRTGencode';
$route['CallMaxValueSequenceAndRptCode']      = 'settingconfig/settingmenu/cSettingreport/FSxCSRTCallMaxSequence';

//Module Rpt
$route['SettingReportAddUpdateModule']       = 'settingconfig/settingmenu/cSettingreport/FSxCSRTReportAddUpdateModule';
$route['SettingReportCallEditModuleRpt']     = 'settingconfig/settingmenu/cSettingreport/FSxCSRTReportCallMoalEditModulRpt';
$route['SettingReportDelModule']             = 'settingconfig/settingmenu/cSettingreport/FSxCSRTDelModuleReport';

//ReportGrp
$route['SettingReportAddEditRptGrp']           = 'settingconfig/settingmenu/cSettingreport/FSxCSRTAddEditRptGrp';
$route['CallModalReportGrpEdit']               = 'settingconfig/settingmenu/cSettingreport/FSxCSRTCallModalEditRptGrp';
$route['SettingReportDelRptGrp']               = 'settingconfig/settingmenu/cSettingreport/FSxCSRTDelReportGrp';

//ReportMenu
$route['SettingReportAddEditRptMenu']           = 'settingconfig/settingmenu/cSettingreport/FSxCSRTReportAddUpdateMenu';
$route['CallModalReportMenuEdit']               = 'settingconfig/settingmenu/cSettingreport/FSxCSRTCallModalEditRptMenu';
$route['SettingReportDelMenu']                  = 'settingconfig/settingmenu/cSettingreport/FSxCSRTDelMenuReport';

// กำหนดเงื่อนไขช่วงการตรวจสอบ
$route['settingconperiod/(:any)/(:any)']       = 'settingconfig/settingconperiod/cSettingconperiod/index/$1/$2';
$route['settingconperiodList']                 = 'settingconfig/settingconperiod/cSettingconperiod/FSvCLIMListPage';
$route['settingconperiodDataTable']            = 'settingconfig/settingconperiod/cSettingconperiod/FSvCLIMDataList';
$route['settingconperiodPageAdd']              = 'settingconfig/settingconperiod/cSettingconperiod/FSvCLIMAddPage';
$route['settingconperiodDataCheckRolCode']     = 'settingconfig/settingconperiod/cSettingconperiod/FSvCLIMChkRole';
$route['settingconperiodPageEdit']             = 'settingconfig/settingconperiod/cSettingconperiod/FSvCLIMEditPage';
$route['settingconperiodEventDelete']          = 'settingconfig/settingconperiod/cSettingconperiod/FSaCLIMDeleteEvent';
$route['settingconperiodEventDeleteMultiple']  = 'settingconfig/settingconperiod/cSettingconperiod/FSaCLIMDeleteMultiEvent';
$route['settingconperiodEventAdd']             = 'settingconfig/settingconperiod/cSettingconperiod/FSaCLIMAddEvent';
$route['settingconperiodEventEdit']            = 'settingconfig/settingconperiod/cSettingconperiod/FSaCLIMEditEvent';

//Export Data Settingconfig
$route['configExportData']                     = 'settingconfig/settingconfig/cSettingconfig/FSxSETSettingConfigExport';
$route['configInsertData']                     = 'settingconfig/settingconfig/cSettingconfig/FSxSETConfigInsertData';



//Server Printer
$route['ServerPrinter/(:any)/(:any)']          = 'settingconfig/settingprint/Serverprinter_Controller/index/$1/$2';
$route['ServerPrinterList']                    = 'settingconfig/settingprint/Serverprinter_Controller/FSvSrvPriListPage';
$route['ServerPrinterDataTable']               = 'settingconfig/settingprint/Serverprinter_Controller/FSvSrvPriDataList';
$route['ServerPrinterPageAdd']                 = 'settingconfig/settingprint/Serverprinter_Controller/FSvSrvPriAddPage';
$route['ServerPrinterEventAdd']                = 'settingconfig/settingprint/Serverprinter_Controller/FSaSrvPriAddEvent';
$route['ServerPrinterPageEdit']                = 'settingconfig/settingprint/Serverprinter_Controller/FSvSrvPriEditPage';
$route['ServerPrinterEventEdit']               = 'settingconfig/settingprint/Serverprinter_Controller/FSaSrvPriEditEvent';
$route['ServerPrinterDeleteMulti']             = 'settingconfig/settingprint/Serverprinter_Controller/FSoSrvPriDeleteMulti';
$route['ServerPrinterDelete']                  = 'settingconfig/settingprint/Serverprinter_Controller/FSoSrvPriDelete';
$route['ServerPrinterUniqueValidate/(:any)']   = 'settingconfig/settingprint/Serverprinter_Controller/FStSrvPriUniqueValidate/$1';
$route['ServerPrinterSpcDataTable']            = 'settingconfig/settingprint/Serverprinter_Controller/FSvSrvPriSpcDataList';
$route['ServerPrinterSpcAddData']              = 'settingconfig/settingprint/Serverprinter_Controller/FSaSrvPriSpcAddData';
$route['ServerPrinterSpcDelData']              = 'settingconfig/settingprint/Serverprinter_Controller/FSaSrvPriSpcDelData';
$route['ServerPrinterSpcExportJson']           = 'settingconfig/settingprint/Serverprinter_Controller/FSaSrvPriSpcExportJson';

//Server Lable
$route['LablePrinter/(:any)/(:any)']          = 'settingconfig/settingprint/Lableprinter_Controller/index/$1/$2';
$route['LablePrinterList']                    = 'settingconfig/settingprint/Lableprinter_Controller/FSvlabPriListPage';
$route['LablePrinterDataTable']               = 'settingconfig/settingprint/Lableprinter_Controller/FSvlabPriDataList';
$route['LablePrinterPageAdd']                 = 'settingconfig/settingprint/Lableprinter_Controller/FSvlabPriAddPage';
$route['LablePrinterEventAdd']                = 'settingconfig/settingprint/Lableprinter_Controller/FSalabPriAddEvent';
$route['LablePrinterPageEdit']                = 'settingconfig/settingprint/Lableprinter_Controller/FSvlabPriEditPage';
$route['LablePrinterEventEdit']               = 'settingconfig/settingprint/Lableprinter_Controller/FSalabPriEditEvent';
$route['LablePrinterDeleteMulti']             = 'settingconfig/settingprint/Lableprinter_Controller/FSolabPriDeleteMulti';
$route['LablePrinterDelete']                  = 'settingconfig/settingprint/Lableprinter_Controller/FSolabPriDelete';
$route['LablePrinterUniqueValidate/(:any)']   = 'settingconfig/settingprint/Lableprinter_Controller/FStlabPriUniqueValidate/$1';
$route['LablePrinterEventExportJson']                  = 'settingconfig/settingprint/Lableprinter_Controller/FSaLabPriEventExportJson';


//Print Barcode
$route['PrintBarCode/(:any)/(:any)']          = 'settingconfig/settingprint/Printbarcode_Controller/index/$1/$2';
$route['PrintBarCodeMoveDataIntoTable']       = 'settingconfig/settingprint/Printbarcode_Controller/FSxPriBarMoveDataIntoTable';
$route['PrintBarCodeUpdateEditInLine']        = 'settingconfig/settingprint/Printbarcode_Controller/FSvPriBarUpdateEditInLine';
$route['PrintBarCodeUpdateCheckedAll']        = 'settingconfig/settingprint/Printbarcode_Controller/FSvPriBarUpdateCheckedAll';
$route['PrintBarCodeUpdateChecked']           = 'settingconfig/settingprint/Printbarcode_Controller/FSvPriBarUpdateChecked';
$route['PrintBarCodeMQProcess']               = 'settingconfig/settingprint/Printbarcode_Controller/FSvPriBarMQProcess';
$route['PrintBarCodeDataTableSearch']         = 'settingconfig/settingprint/Printbarcode_Controller/FSvPriDataTableSearch';
$route['PrintBarCodeEventGenHD']              = 'settingconfig/settingprint/Printbarcode_Controller/FSoPRNEventGenHD';
$route['PrintBarCodePagePreviewList']         = 'settingconfig/settingprint/Printbarcode_Controller/FSvPriPagePreviewList';
$route['PrintBarCodeUpdStaSelHDTmp']          = 'settingconfig/settingprint/Printbarcode_Controller/FSoPRNUpdStaSelHDTmp';


  //  Print Barcode Import
  $route ['PrintBarCodePageImportDataTable']    = 'settingconfig/settingprint/Printbarcode_Controller/FSaCPRIImportDataTable';
  $route ['PrintBarCodeEventImportDelete']      = 'settingconfig/settingprint/Printbarcode_Controller/FSaCPRIImportDelete';
  $route ['PrintBarCodeEventImportMove2Master'] = 'settingconfig/settingprint/Printbarcode_Controller/FSaCPRIImportMove2Master';
  $route ['PrintBarCodeGetDataImport']          = 'settingconfig/settingprint/Printbarcode_Controller/FSaCPRIGetDataImport';
  $route ['PrintBarCodeGetItemAllImport']       = 'settingconfig/settingprint/Printbarcode_Controller/FSaCPRIImportGetItemAll';