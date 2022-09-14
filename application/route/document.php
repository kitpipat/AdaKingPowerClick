<?php

date_default_timezone_set('Asia/Bangkok');

// Modal Browse Product Document
$route['BrowseGetPdtList']         = 'document/browseproduct/cBrowseProduct/FMvCBWSPDTGetPdtList';
$route['BrowseGetPdtDetailList']   = 'document/browseproduct/cBrowseProduct/FMvCBWSPDTGetPdtDetailList';

// Document Image Product
$route['DOCGetPdtImg']             = 'document/document/cDocument/FMvCDOCGetPdtImg';

// ใบลดหนี้, ใบรับของ-ใบซื้อสินค้า/บริการ Center
$route['DOCEndOfBillCalVat']        = 'document/document/cDocEndOfBill/FStCDOCEndOfBillCalVat';
$route['DOCEndOfBillCal']           = 'document/document/cDocEndOfBill/FStCDOCEndOfBillCal';
// PO (เอกสารสั่งซื้อ)
// $route['po/(:any)/(:any)']         = 'document/purchaseorder/cPurchaseorder/index/$1/$2';
// $route['POFormSearchList']         = 'document/purchaseorder/cPurchaseorder/FSxCPOFormSearchList';
// $route['POPageAdd']                = 'document/purchaseorder/cPurchaseorder/FSxCPOAddPage';
// $route['POPageEdit']               = 'document/purchaseorder/cPurchaseorder/FSvCPOEditPage';
// $route['POEventAdd']               = 'document/purchaseorder/cPurchaseorder/FSaCPOAddEvent';
// $route['POEventEdit']              = 'document/purchaseorder/cPurchaseorder/FSaCPOEditEvent';
// $route['POEventDelete']            = 'document/purchaseorder/cPurchaseorder/FSaCPODeleteEvent';
// $route['PODataTable']              = 'document/purchaseorder/cPurchaseorder/FSxCPODataTable';
// $route['POGetShpByBch']            = 'document/purchaseorder/cPurchaseorder/FSvCPOGetShpByBch';
// $route['POAddPdtIntoTableDT']      = 'document/purchaseorder/cPurchaseorder/FSvCPOAddPdtIntoTableDT';
// $route['POEditPdtIntoTableDT']     = 'document/purchaseorder/cPurchaseorder/FSvCPOEditPdtIntoTableDT';
// $route['PORemovePdtInFile']        = 'document/purchaseorder/cPurchaseorder/FSvCPORemovePdtInFile';
// $route['PORemoveAllPdtInFile']     = 'document/purchaseorder/cPurchaseorder/FSvCPORemoveAllPdtInFile';
// $route['POAdvanceTableShowColList'] = 'document/purchaseorder/cPurchaseorder/FSvCPOAdvTblShowColList';
// $route['POAdvanceTableShowColSave'] = 'document/purchaseorder/cPurchaseorder/FSvCPOShowColSave';
// $route['POGetDTDisTableData']      = 'document/purchaseorder/cPurchaseorder/FSvCPOGetDTDisTableData';
// $route['POAddDTDisIntoTable']      = 'document/purchaseorder/cPurchaseorder/FSvCPOAddDTDisIntoTable';
// $route['PORemoveDTDisInFile']      = 'document/purchaseorder/cPurchaseorder/FSvCPORemoveDTDisInFile';
// $route['POGetHDDisTableData']      = 'document/purchaseorder/cPurchaseorder/FSvCPOGetHDDisTableData';
// $route['POAddHDDisIntoTable']      = 'document/purchaseorder/cPurchaseorder/FSvCPOAddHDDisIntoTable';
// $route['PORemoveHDDisInFile']      = 'document/purchaseorder/cPurchaseorder/FSvCPORemoveHDDisInFile';
// $route['POEditDTDis']              = 'document/purchaseorder/cPurchaseorder/FSvCPOEditDTDis';
// $route['POSetSessionVATInOrEx']    = 'document/purchaseorder/cPurchaseorder/FSvCPOSetSessionVATInOrEx';
// $route['POEditHDDis']              = 'document/purchaseorder/cPurchaseorder/FSvCPOEditHDDis';
// $route['POGetAddress']             = 'document/purchaseorder/cPurchaseorder/FSvCPOGetShipAdd';
// $route['POGetPdtBarCode']          = 'document/purchaseorder/cPurchaseorder/FSvCPOGetPdtBarCode';
// $route['POPdtAdvanceTableLoadData'] = 'document/purchaseorder/cPurchaseorder/FSvCPOPdtAdvTblLoadData';
// $route['POApprove']                = 'document/purchaseorder/cPurchaseorder/FSvCPOApprove';
// $route['POCancel']                 = 'document/purchaseorder/cPurchaseorder/FSvCPOCancel';

// TFW (ใบโอนสินค้าระหว่างคลัง)
$route['TFW/(:any)/(:any)']             = 'document/producttransferwahouse/cProducttransferwahouse/index/$1/$2';
$route['TFWFormSearchList']             = 'document/producttransferwahouse/cProducttransferwahouse/FSxCTFWFormSearchList';
$route['TFWPageAdd']                    = 'document/producttransferwahouse/cProducttransferwahouse/FSxCTFWAddPage';
$route['TFWPageEdit']                   = 'document/producttransferwahouse/cProducttransferwahouse/FSvCTFWEditPage';
$route['TFWEventAdd']                   = 'document/producttransferwahouse/cProducttransferwahouse/FSaCTFWAddEvent';
$route['TFWCheckPdtTmpForTransfer']     = 'document/producttransferwahouse/cProducttransferwahouse/FSbCheckHaveProductForTransfer';
$route['TFWCheckHaveProductInDT']       = 'document/producttransferwahouse/cProducttransferwahouse/FSbCheckHaveProductInDT';
$route['TFWEventEdit']                  = 'document/producttransferwahouse/cProducttransferwahouse/FSaCTFWEditEvent';
$route['TFWEventDelete']                = 'document/producttransferwahouse/cProducttransferwahouse/FSaCTFWDeleteEvent';
$route['TFWDataTable']                  = 'document/producttransferwahouse/cProducttransferwahouse/FSxCTFWDataTable';
$route['TFWGetShpByBch']                = 'document/producttransferwahouse/cProducttransferwahouse/FSvCTFWGetShpByBch';
$route['TFWAddPdtIntoTableDT']          = 'document/producttransferwahouse/cProducttransferwahouse/FSvCTFWAddPdtIntoTableDT';
$route['TFWEditPdtIntoTableDT']         = 'document/producttransferwahouse/cProducttransferwahouse/FSvCTFWEditPdtIntoTableDT';
$route['TFWRemovePdtInDTTmp']           = 'document/producttransferwahouse/cProducttransferwahouse/FSvCTFWRemovePdtInDTTmp';
$route['TFWRemovePdtInFile']            = 'document/producttransferwahouse/cProducttransferwahouse/FSvCTFWRemovePdtInFile';
$route['TFWRemoveAllPdtInFile']         = 'document/producttransferwahouse/cProducttransferwahouse/FSvCTFWRemoveAllPdtInFile';
$route['TFWAdvanceTableShowColList']    = 'document/producttransferwahouse/cProducttransferwahouse/FSvCTFWAdvTblShowColList';
$route['TFWAdvanceTableShowColSave']    = 'document/producttransferwahouse/cProducttransferwahouse/FSvCTFWShowColSave';
$route['TFWGetDTDisTableData']          = 'document/producttransferwahouse/cProducttransferwahouse/FSvCTFWGetDTDisTableData';
$route['TFWAddDTDisIntoTable']          = 'document/producttransferwahouse/cProducttransferwahouse/FSvCTFWAddDTDisIntoTable';
$route['TFWRemoveDTDisInFile']          = 'document/producttransferwahouse/cProducttransferwahouse/FSvCTFWRemoveDTDisInFile';
$route['TFWGetHDDisTableData']          = 'document/producttransferwahouse/cProducttransferwahouse/FSvCTFWGetHDDisTableData';
$route['TFWAddHDDisIntoTable']          = 'document/producttransferwahouse/cProducttransferwahouse/FSvCTFWAddHDDisIntoTable';
$route['TFWRemoveHDDisInFile']          = 'document/producttransferwahouse/cProducttransferwahouse/FSvCTFWRemoveHDDisInFile';
$route['TFWEditDTDis']                  = 'document/producttransferwahouse/cProducttransferwahouse/FSvCTFWEditDTDis';
$route['TFWEditHDDis']                  = 'document/producttransferwahouse/cProducttransferwahouse/FSvCTFWEditHDDis';
$route['TFWGetAddress']                 = 'document/producttransferwahouse/cProducttransferwahouse/FSvCTFWGetShipAdd';
$route['TFWGetPdtBarCode']              = 'document/producttransferwahouse/cProducttransferwahouse/FSvCTFWGetPdtBarCode';
$route['TFWPdtAdvanceTableLoadData']    = 'document/producttransferwahouse/cProducttransferwahouse/FSvCTFWPdtAdvTblLoadData';
$route['TFWVatTableLoadData']           = 'document/producttransferwahouse/cProducttransferwahouse/FSvCTFWVatLoadData';
$route['TFWCalculateLastBill']          = 'document/producttransferwahouse/cProducttransferwahouse/FSvCTFWCalculateLastBill';
$route['TFWPdtMultiDeleteEvent']        = 'document/producttransferwahouse/cProducttransferwahouse/FSvCTFWPdtMultiDeleteEvent';
$route['TFWApprove']                    = 'document/producttransferwahouse/cProducttransferwahouse/FSvCTFWApprove';
$route['TFWCancel']                     = 'document/producttransferwahouse/cProducttransferwahouse/FSvCTFWCancel';
$route['TFWClearDocTemForChngCdt']      = 'document/producttransferwahouse/cProducttransferwahouse/FSxCTFXClearDocTemForChngCdt';
$route['TFWCheckViaCodeForApv']         = 'document/producttransferwahouse/cProducttransferwahouse/FSxCTWXCheckViaCodeForApv';
$route['docTFWEventAddPdtIntoDTFhnTemp'] = 'document/producttransferwahouse/cProducttransferwahouse/FSoCTFWEventAddPdtIntoDTFhnTemp';


// TFW (ใบโอนสินค้าระหว่างคลัง ตู้ VD) -
// $route['TWXVD/(:any)/(:any)']         = 'document/producttransferwahousevd/cProducttransferwahousevd/index/$1/$2';
$route['TWXVDFormSearchList']          = 'document/producttransferwahousevd/cProducttransferwahousevd/FSxCTFWFormSearchList';
$route['TWXVDPageAdd']                 = 'document/producttransferwahousevd/cProducttransferwahousevd/FSxCTFWAddPage';
$route['TWXVDPageEdit']                = 'document/producttransferwahousevd/cProducttransferwahousevd/FSvCTFWEditPage';
$route['TWXVDEventAdd']                = 'document/producttransferwahousevd/cProducttransferwahousevd/FSaCTFWAddEvent';
$route['TWXVDCheckPdtTmpForTransfer']  = 'document/producttransferwahousevd/cProducttransferwahousevd/FSbCheckHaveProductForTransfer';
$route['TWXVDCheckHaveProductInDT']    = 'document/producttransferwahousevd/cProducttransferwahousevd/FSbCheckHaveProductInDT';
$route['TWXVDEventEdit']              = 'document/producttransferwahousevd/cProducttransferwahousevd/FSaCTFWEditEvent';
$route['TWXVDEventDelete']            = 'document/producttransferwahousevd/cProducttransferwahousevd/FSaCTFWDeleteEvent';
$route['TWXVDDataTable']              = 'document/producttransferwahousevd/cProducttransferwahousevd/FSxCTFWDataTable';
$route['TWXVDGetShpByBch']            = 'document/producttransferwahousevd/cProducttransferwahousevd/FSvCTFWGetShpByBch';
$route['TWXVDAddPdtIntoTableDT']      = 'document/producttransferwahousevd/cProducttransferwahousevd/FSvCTFWAddPdtIntoTableDT';
$route['TWXVDEditPdtIntoTableDT']     = 'document/producttransferwahousevd/cProducttransferwahousevd/FSvCTFWEditPdtIntoTableDT';
$route['TWXVDRemovePdtInDTTmp']       = 'document/producttransferwahousevd/cProducttransferwahousevd/FSvCTFWRemovePdtInDTTmp';
$route['TWXVDRemovePdtInFile']        = 'document/producttransferwahousevd/cProducttransferwahousevd/FSvCTFWRemovePdtInFile';
$route['TWXVDRemoveAllPdtInFile']     = 'document/producttransferwahousevd/cProducttransferwahousevd/FSvCTFWRemoveAllPdtInFile';
$route['TWXVDAdvanceTableShowColList'] = 'document/producttransferwahousevd/cProducttransferwahousevd/FSvCTFWAdvTblShowColList';
$route['TWXVDAdvanceTableShowColSave'] = 'document/producttransferwahousevd/cProducttransferwahousevd/FSvCTFWShowColSave';
$route['TWXVDGetDTDisTableData']      = 'document/producttransferwahousevd/cProducttransferwahousevd/FSvCTFWGetDTDisTableData';
$route['TWXVDAddDTDisIntoTable']      = 'document/producttransferwahousevd/cProducttransferwahousevd/FSvCTFWAddDTDisIntoTable';
$route['TWXVDRemoveDTDisInFile']      = 'document/producttransferwahousevd/cProducttransferwahousevd/FSvCTFWRemoveDTDisInFile';
$route['TWXVDGetHDDisTableData']      = 'document/producttransferwahousevd/cProducttransferwahousevd/FSvCTFWGetHDDisTableData';
$route['TWXVDAddHDDisIntoTable']      = 'document/producttransferwahousevd/cProducttransferwahousevd/FSvCTFWAddHDDisIntoTable';
$route['TWXVDRemoveHDDisInFile']      = 'document/producttransferwahousevd/cProducttransferwahousevd/FSvCTFWRemoveHDDisInFile';
$route['TWXVDEditDTDis']              = 'document/producttransferwahousevd/cProducttransferwahousevd/FSvCTFWEditDTDis';
$route['TWXVDEditHDDis']              = 'document/producttransferwahousevd/cProducttransferwahousevd/FSvCTFWEditHDDis';
$route['TWXVDGetAddress']             = 'document/producttransferwahousevd/cProducttransferwahousevd/FSvCTFWGetShipAdd';
$route['TWXVDGetPdtBarCode']          = 'document/producttransferwahousevd/cProducttransferwahousevd/FSvCTFWGetPdtBarCode';
$route['TWXVDPdtAdvanceTableLoadData'] = 'document/producttransferwahousevd/cProducttransferwahousevd/FSvCTFWPdtAdvTblLoadData';
$route['TWXVDVatTableLoadData']       = 'document/producttransferwahousevd/cProducttransferwahousevd/FSvCTFWVatLoadData';
$route['TWXVDCalculateLastBill']      = 'document/producttransferwahousevd/cProducttransferwahousevd/FSvCTFWCalculateLastBill';
$route['TWXVDPdtMultiDeleteEvent']    = 'document/producttransferwahousevd/cProducttransferwahousevd/FSvCTFWPdtMultiDeleteEvent';
$route['TWXVDApprove']                = 'document/producttransferwahousevd/cProducttransferwahousevd/FSvCTFWApprove';
$route['TWXVDCancel']                 = 'document/producttransferwahousevd/cProducttransferwahousevd/FSvCTFWCancel';
$route['TWXVDClearDocTemForChngCdt']  = 'document/producttransferwahousevd/cProducttransferwahousevd/FSxCTFXClearDocTemForChngCdt';
$route['TWXVDCheckViaCodeForApv']     = 'document/producttransferwahousevd/cProducttransferwahousevd/FSxCTWXCheckViaCodeForApv';
$route['TWXVDPdtDtLoadToTem']         = 'document/producttransferwahousevd/cProducttransferwahousevd/FSxCTWXVDPdtDtLoadToTem';
$route['TWXVDPdtUpdateTem']           = 'document/producttransferwahousevd/cProducttransferwahousevd/FSxCTWXVDPdtUpdateTem';

//ADJVD - ใบปรับสต็อก ตู้ VD / Supawat 26-08-2020
$route['ADJSTKVD/(:any)/(:any)']         = 'document/adjuststockvd/cAdjstockvd/index/$1/$2';
$route['ADJSTKVDFormSearchList']         = 'document/adjuststockvd/cAdjstockvd/FSxCADJVDFormSearchList';
$route['ADJSTKVDPageAdd']                = 'document/adjuststockvd/cAdjstockvd/FSxCADJVDAddPage';
$route['ADJSTKVDPageEdit']               = 'document/adjuststockvd/cAdjstockvd/FSvCADJVDEditPage';
$route['ADJSTKVDPdtDtLoadToTem']         = 'document/adjuststockvd/cAdjstockvd/FSxCADJVDPdtDtLoadToTem';
$route['ADJSTKVDPdtAdvanceTableLoadData'] = 'document/adjuststockvd/cAdjstockvd/FSvCADJVDPdtAdvTblLoadData';
$route['ADJSTKVDEventAdd']               = 'document/adjuststockvd/cAdjstockvd/FSaCADJVDAddEvent';
$route['ADJSTKVDEditPdtIntoTableDT']     = 'document/adjuststockvd/cAdjstockvd/FSvCADJVDEditPdtIntoTableDT';
$route['ADJSTKVDCheckPdtInTmp']          = 'document/adjuststockvd/cAdjstockvd/FSbCADJVDheckHaveProductInTemp';
$route['ADJSTKVDEventEdit']              = 'document/adjuststockvd/cAdjstockvd/FSaCADJVDEditEvent';
$route['ADJSTKVDCancel']                 = 'document/adjuststockvd/cAdjstockvd/FSvCADJVDCancel';
$route['ADJSTKVDEventDelete']            = 'document/adjuststockvd/cAdjstockvd/FSaCADJVDDeleteEvent';
$route['ADJSTKVDApprove']                = 'document/adjuststockvd/cAdjstockvd/FSvCADJVDApprove';
$route['ADJSTKVDCheckHaveProductInDT']   = 'document/adjuststockvd/cAdjstockvd/FSbCADJVDCheckHaveProductInDT';
$route['ADJSTKVDDeletePDTInTemp']        = 'document/adjuststockvd/cAdjstockvd/FSxCADJVDDeletePDTInTemp';
$route['ADJSTKVDDataTable']              = 'document/adjuststockvd/cAdjstockvd/FSxCADJVDDataTable';
$route['ADJSTKVDRemoveMultiPdtInDTTmp']  = 'document/adjuststockvd/cAdjstockvd/FSxCADJVDDeleteMultiPDTInTemp';
$route['ADJSTKVDRemoveItemAllInTemp']    = 'document/adjuststockvd/cAdjstockvd/FSxCADJVDDeleteItemAllInTemp';


// ADJPL (ใบปรับราคาสินค้า ตู้ locker)
$route['ADJPL/(:any)/(:any)']          = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/index/$1/$2';
$route['ADJPLFormSearchList']          = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSxCTFWFormSearchList';
$route['ADJPLPageAdd']                 = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSxCTFWAddPage';
$route['ADJPLPageEdit']                = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSvCTFWEditPage';
$route['ADJPLEventAdd']                = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSaCTFWAddEvent';
$route['ADJPLCheckPdtTmpForTransfer']  = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSbCheckHaveProductForTransfer';
$route['ADJPLCheckHaveProductInDT']    = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSbCheckHaveProductInDT';
$route['ADJPLEventEdit']               = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSaCTFWEditEvent';
$route['ADJPLEventDelete']             = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSaCTFWDeleteEvent';
$route['ADJPLDataTable']               = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSxCTFWDataTable';
$route['ADJPLGetShpByBch']             = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSvCTFWGetShpByBch';
$route['ADJPLAddPdtIntoTableDT']       = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSvCTFWAddPdtIntoTableDT';
$route['ADJPLEditPdtIntoTableDT']      = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSvCTFWEditPdtIntoTableDT';
$route['ADJPLRemovePdtInDTTmp']        = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSvCTFWRemovePdtInDTTmp';
$route['ADJPLRemovePdtInFile']         = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSvCTFWRemovePdtInFile';
$route['ADJPLRemoveAllPdtInFile']      = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSvCTFWRemoveAllPdtInFile';
$route['ADJPLAdvanceTableShowColList'] = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSvCTFWAdvTblShowColList';
$route['ADJPLAdvanceTableShowColSave'] = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSvCTFWShowColSave';
$route['ADJPLGetDTDisTableData']       = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSvCTFWGetDTDisTableData';
$route['ADJPLAddDTDisIntoTable']       = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSvCTFWAddDTDisIntoTable';
$route['ADJPLRemoveDTDisInFile']       = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSvCTFWRemoveDTDisInFile';
$route['ADJPLGetHDDisTableData']       = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSvCTFWGetHDDisTableData';
$route['ADJPLAddHDDisIntoTable']       = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSvCTFWAddHDDisIntoTable';
$route['ADJPLRemoveHDDisInFile']       = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSvCTFWRemoveHDDisInFile';
$route['ADJPLEditDTDis']               = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSvCTFWEditDTDis';
$route['ADJPLEditHDDis']               = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSvCTFWEditHDDis';
$route['ADJPLGetAddress']              = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSvCTFWGetShipAdd';
$route['ADJPLGetPdtBarCode']           = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSvCTFWGetPdtBarCode';
$route['ADJPLPdtAdvanceTableLoadData'] = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSvCTFWPdtAdvTblLoadData';
$route['ADJPLVatTableLoadData']        = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSvCTFWVatLoadData';
$route['ADJPLCalculateLastBill']       = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSvCTFWCalculateLastBill';
$route['ADJPLPdtMultiDeleteEvent']     = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSvCTFWPdtMultiDeleteEvent';
$route['ADJPLApprove']                 = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSvCTFWApprove';
$route['ADJPLCancel']                  = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSvCTFWCancel';
$route['ADJPLClearDocTemForChngCdt']   = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSxCTFXClearDocTemForChngCdt';
$route['ADJPLCheckViaCodeForApv']      = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSxCTWXCheckViaCodeForApv';
$route['ADJPLPdtDtLoadToTem']          = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSxCTWXVDPdtDtLoadToTem';
$route['ADJPLPdtUpdateTem']            = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSxCTWXVDPdtUpdateTem';
$route['ADJPLPdtGetRateInfor']         = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSxCADJPLPdtGetRateInfor';
$route['ADJPLPdtGetRateDTInfor']       = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSxCADJPLPdtGetRateDTInfor';
$route['ADJPLPdtSaveRateDTInTmp']      = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSxCADJPLPdtSaveRateDTInTmp';
$route['ADJPLCheckDateTime']           = 'document/rentalproductpriceadjustmentlocker/cRentalproductpriceadjustmentlocker/FSxCADJPLCheckDateTime';

// TBX (ใบโอนสินค้าระหว่างสาขา)
$route['TBX/(:any)/(:any)']         = 'document/producttransferbranch/cProducttransferbranch/index/$1/$2';
$route['TBXFormSearchList']         = 'document/producttransferbranch/cProducttransferbranch/FSxCTBXFormSearchList';
$route['TBXPageAdd']                = 'document/producttransferbranch/cProducttransferbranch/FSxCTBXAddPage';
$route['TBXPageEdit']               = 'document/producttransferbranch/cProducttransferbranch/FSvCTBXEditPage';
$route['TBXEventAdd']               = 'document/producttransferbranch/cProducttransferbranch/FSaCTBXAddEvent';
$route['TBXCheckPdtTmpForTransfer'] = 'document/producttransferbranch/cProducttransferbranch/FSbCheckHaveProductForTransfer';
$route['TBXCheckHaveProductInDT']   = 'document/producttransferbranch/cProducttransferbranch/FSbCheckHaveProductInDT';
$route['TBXEventEdit']              = 'document/producttransferbranch/cProducttransferbranch/FSaCTBXEditEvent';
$route['TBXEventDelete']            = 'document/producttransferbranch/cProducttransferbranch/FSaCTBXDeleteEvent';
$route['TBXDataTable']              = 'document/producttransferbranch/cProducttransferbranch/FSxCTBXDataTable';
$route['TBXAddPdtIntoTableDT']      = 'document/producttransferbranch/cProducttransferbranch/FSvCTBXAddPdtIntoTableDT';
$route['TBXEditPdtIntoTableDT']     = 'document/producttransferbranch/cProducttransferbranch/FSvCTBXEditPdtIntoTableDT';
$route['TBXRemovePdtInDTTmp']       = 'document/producttransferbranch/cProducttransferbranch/FSvCTBXRemovePdtInDTTmp';
$route['TBXRemovePdtInFile']        = 'document/producttransferbranch/cProducttransferbranch/FSvCTBXRemovePdtInFile';
$route['TBXRemoveAllPdtInFile']     = 'document/producttransferbranch/cProducttransferbranch/FSvCTBXRemoveAllPdtInFile';
$route['TBXAdvanceTableShowColList'] = 'document/producttransferbranch/cProducttransferbranch/FSvCTBXAdvTblShowColList';
$route['TBXAdvanceTableShowColSave'] = 'document/producttransferbranch/cProducttransferbranch/FSvCTBXShowColSave';
$route['TBXGetDTDisTableData']      = 'document/producttransferbranch/cProducttransferbranch/FSvCTBXGetDTDisTableData';
$route['TBXAddDTDisIntoTable']      = 'document/producttransferbranch/cProducttransferbranch/FSvCTBXAddDTDisIntoTable';
$route['TBXRemoveDTDisInFile']      = 'document/producttransferbranch/cProducttransferbranch/FSvCTBXRemoveDTDisInFile';
$route['TBXGetHDDisTableData']      = 'document/producttransferbranch/cProducttransferbranch/FSvCTBXGetHDDisTableData';
$route['TBXAddHDDisIntoTable']      = 'document/producttransferbranch/cProducttransferbranch/FSvCTBXAddHDDisIntoTable';
$route['TBXRemoveHDDisInFile']      = 'document/producttransferbranch/cProducttransferbranch/FSvCTBXRemoveHDDisInFile';
$route['TBXEditDTDis']              = 'document/producttransferbranch/cProducttransferbranch/FSvCTBXEditDTDis';
$route['TBXEditHDDis']              = 'document/producttransferbranch/cProducttransferbranch/FSvCTBXEditHDDis';
$route['TBXGetAddress']             = 'document/producttransferbranch/cProducttransferbranch/FSvCTBXGetShipAdd';
$route['TBXGetPdtBarCode']          = 'document/producttransferbranch/cProducttransferbranch/FSvCTBXGetPdtBarCode';
$route['TBXPdtAdvanceTableLoadData'] = 'document/producttransferbranch/cProducttransferbranch/FSvCTBXPdtAdvTblLoadData';
$route['TBXVatTableLoadData']       = 'document/producttransferbranch/cProducttransferbranch/FSvCTBXVatLoadData';
$route['TBXCalculateLastBill']      = 'document/producttransferbranch/cProducttransferbranch/FSvCTBXCalculateLastBill';
$route['TBXPdtMultiDeleteEvent']    = 'document/producttransferbranch/cProducttransferbranch/FSvCTBXPdtMultiDeleteEvent';
$route['TBXApprove']                = 'document/producttransferbranch/cProducttransferbranch/FSvCTBXApprove';
$route['TBXCancel']                 = 'document/producttransferbranch/cProducttransferbranch/FSvCTBXCancel';
$route['TBXClearDocTemForChngCdt']  = 'document/producttransferbranch/cProducttransferbranch/FSxCTFXClearDocTemForChngCdt';
$route['TBXCheckViaCodeForApv']     = 'document/producttransferbranch/cProducttransferbranch/FSxCTBXCheckViaCodeForApv';
$route['docTBXEventAddPdtIntoDTFhnTemp'] = 'document/producttransferbranch/cProducttransferbranch/FSoCTBXEventAddPdtIntoDTFhnTemp';

// SalePriceAdj ใบปรับราคาขาย
$route['dcmSPA/(:any)/(:any)']             = 'document/salepriceadj/cSalePriceAdj/index/$1/$2';
$route['dcmSPAMain']                       = 'document/salepriceadj/cSalePriceAdj/FSvCSPAMainPage';
$route['dcmSPADataTable']                  = 'document/salepriceadj/cSalePriceAdj/FSvCSPADataList';
$route['dcmSPAPageAdd']                    = 'document/salepriceadj/cSalePriceAdj/FSvCSPAAddPage';
$route['dcmSPAPageEdit']                   = 'document/salepriceadj/cSalePriceAdj/FSvCSPAEditPage';
$route['dcmSPAEventEdit']                  = 'document/salepriceadj/cSalePriceAdj/FSoCSPAEditEvent';
$route['dcmSPAEventAdd']                   = 'document/salepriceadj/cSalePriceAdj/FSoCSPAAddEvent';
$route['dcmSPAEventDelete']                = 'document/salepriceadj/cSalePriceAdj/FSoCSPADeleteEvent';
$route['dcmSPAPdtPriDataTable']            = 'document/salepriceadj/cSalePriceAdj/FSvCSPAPdtPriDataList'; // Get Pdt List
$route['dcmSPAPdtPriEventAddTmp']          = 'document/salepriceadj/cSalePriceAdj/FSvCSPAPdtPriAddTmpEvent';
$route['dcmSPAPdtPriEventAddDT']           = 'document/salepriceadj/cSalePriceAdj/FSvCSPAPdtPriAddDTEvent';
$route['dcmSPAPdtPriEventDelete']          = 'document/salepriceadj/cSalePriceAdj/FSoCSPAPdtPriDeleteEvent';
$route['dcmSPAPdtPriEventDelAll']          = 'document/salepriceadj/cSalePriceAdj/FSoCSPAProductDeleteAllEvent';
$route['dcmSPAPdtPriEventUpdPriTmp']       = 'document/salepriceadj/cSalePriceAdj/FSoCSPAUpdatePriceTemp';
$route['dcmSPAGetBchComp']                 = 'document/salepriceadj/cSalePriceAdj/FSoCSPAGetBchComp';
$route['dcmSPAAdvanceTableShowColList']    = 'document/salepriceadj/cSalePriceAdj/FSvCSPAAdvTblShowColList';
$route['dcmSPAAdvanceTableShowColSave']    = 'document/salepriceadj/cSalePriceAdj/FSvCSPAShowColSave';
$route['dcmSPAOriginalPrice']              = 'document/salepriceadj/cSalePriceAdj/FSoCSPAOriginalPrice';
$route['dcmSPAPdtPriAdjust']               = 'document/salepriceadj/cSalePriceAdj/FSoCSPAPdtPriAdjustEvent';
$route['dcmSPAEventApprove']               = 'document/salepriceadj/cSalePriceAdj/FSoCSPAApproveEvent';
$route['dcmSPAUpdateStaDocCancel']         = 'document/salepriceadj/cSalePriceAdj/FSoCSPAUpdateStaDocCancel';

// จ่ายโอนสินค้า
// $route['TWO/(:any)/(:any)']            = 'document/transferwarehouseout/cTransferwarehouseout/index/$1/$2';
// $route['TWOFormSearchList']         = 'document/transferwarehouseout/cTransferwarehouseout/FSxCTWOFormSearchList';
// $route['TWOPageAdd']                = 'document/transferwarehouseout/cTransferwarehouseout/FSxCTWOAddPage';
// $route['TWOPageEdit']               = 'document/transferwarehouseout/cTransferwarehouseout/FSvCTWOEditPage';
// $route['TWOEventAdd']               = 'document/transferwarehouseout/cTransferwarehouseout/FSaCTWOAddEvent';
// $route['TWOEventEdit']              = 'document/transferwarehouseout/cTransferwarehouseout/FSaCTWOEditEvent';
// $route['TWOEventDelete']            = 'document/transferwarehouseout/cTransferwarehouseout/FSaCTWODeleteEvent';
// $route['TWODataTable']              = 'document/transferwarehouseout/cTransferwarehouseout/FSxCTWODataTable';
// $route['TWOGetShpByBch']            = 'document/transferwarehouseout/cTransferwarehouseout/FSvCTWOGetShpByBch';
// $route['TWOAddPdtIntoTableDT']      = 'document/transferwarehouseout/cTransferwarehouseout/FSvCTWOAddPdtIntoTableDT';
// $route['TWOEditPdtIntoTableDT']     = 'document/transferwarehouseout/cTransferwarehouseout/FSvCTWOEditPdtIntoTableDT';
// $route['TWORemovePdtInDTTmp']       = 'document/transferwarehouseout/cTransferwarehouseout/FSvCTWORemovePdtInDTTmp';
// $route['TWORemoveAllPdtInFile']     = 'document/transferwarehouseout/cTransferwarehouseout/FSvCTWORemoveAllPdtInFile';
// $route['TWOAdvanceTableShowColList'] = 'document/transferwarehouseout/cTransferwarehouseout/FSvCTWOAdvTblShowColList';
// $route['TWOAdvanceTableShowColSave'] = 'document/transferwarehouseout/cTransferwarehouseout/FSvCTWOShowColSave';
// $route['TWOGetAddress']             = 'document/transferwarehouseout/cTransferwarehouseout/TFSvCTWOGetShipAdd';
// $route['TWOGetPdtBarCode']          = 'document/transferwarehouseout/cTransferwarehouseout/FSvCTWOGetPdtBarCode';
// $route['TWOPdtAdvanceTableLoadData'] = 'document/transferwarehouseout/cTransferwarehouseout/FSvCTWOPdtAdvTblLoadData';
// $route['TWOVatTableLoadData']       = 'document/transferwarehouseout/cTransferwarehouseout/FSvCTWOVatLoadData';
// $route['TWOCalculateLastBill']      = 'document/transferwarehouseout/cTransferwarehouseout/FSvCTWOCalculateLastBill';
// $route['TWOPdtMultiDeleteEvent']    = 'document/transferwarehouseout/cTransferwarehouseout/FSvCTWOPdtMultiDeleteEvent';
// $route['TWOApprove']                = 'document/transferwarehouseout/cTransferwarehouseout/FSvCTWOApprove';
// $route['TWOCancel']                 = 'document/transferwarehouseout/cTransferwarehouseout/FSvCTWOCancel';

// Card Import - Export (นำเข้า-ส่งออก ข้อมูลบัตร)
$route['cardmngdata/(:any)/(:any)']            = 'document/cardmngdata/cCardMngData/index/$1/$2';
$route['cardmngdataFromList']                  = 'document/cardmngdata/cCardMngData/FSvCCMDFromList';
$route['cardmngdataImpFileDataList']           = 'document/cardmngdata/cCardMngData/FSvCCMDImpFileDataList';
$route['cardmngdataExpFileDataList']           = 'document/cardmngdata/cCardMngData/FSvCCMDExpFileDataList';
$route['cardmngdataTopUpUpdateInlineOnTemp']   = 'document/cardmngdata/cCardMngData/FSxCTopUpUpdateInlineOnTemp';
$route['cardmngdataNewCardUpdateInlineOnTemp'] = 'document/cardmngdata/cCardMngData/FSxCNewCardUpdateInlineOnTemp';
$route['cardmngdataClearUpdateInlineOnTemp']   = 'document/cardmngdata/cCardMngData/FSxCClearUpdateInlineOnTemp';
$route['cardmngdataProcessImport']             = 'document/cardmngdata/cCardMngData/FSoCCMDProcessImport';
$route['cardmngdataProcessExport']             = 'document/cardmngdata/cCardMngData/FSoCCMDProcessExport';

// Call Table Temp
$route['CallTableTemp']                         = 'document/cardmngdata/cCardMngData/FSaSelectDataTableRight';
$route['CallDeleteTemp']                        = 'document/cardmngdata/cCardMngData/FSaDeleteDataTableRight';
$route['CallClearTempByTable']                  = 'document/cardmngdata/cCardMngData/FSaClearTempByTable';
$route['CallUpdateDocNoinTempByTable']          = 'document/cardmngdata/cCardMngData/FSaUpdateDocnoinTempByTable';

// Card Shift New Card(สร้างบัตรใหม่)
$route['cardShiftNewCard/(:any)/(:any)']                   = 'document/cardshiftnewcard/cCardShiftNewCard/index/$1/$2';
$route['cardShiftNewCardList']                             = 'document/cardshiftnewcard/cCardShiftNewCard/FSvCardShiftNewCardListPage';
$route['cardShiftNewCardDataTable']                        = 'document/cardshiftnewcard/cCardShiftNewCard/FSvCardShiftNewCardDataList';
$route['cardShiftNewCardDataSourceTable']                  = 'document/cardshiftnewcard/cCardShiftNewCard/FSvCardShiftNewCardDataSourceList';
$route['cardShiftNewCardDataSourceTableByFile']            = 'document/cardshiftnewcard/cCardShiftNewCard/FSvCardShiftNewCardDataSourceListByFile';
$route['cardShiftNewCardPageAdd']                          = 'document/cardshiftnewcard/cCardShiftNewCard/FSvCardShiftNewCardAddPage';
$route['cardShiftNewCardEventAdd']                         = 'document/cardshiftnewcard/cCardShiftNewCard/FSaCardShiftNewCardAddEvent';
$route['cardShiftNewCardPageEdit']                         = 'document/cardshiftnewcard/cCardShiftNewCard/FSvCardShiftNewCardEditPage';
$route['cardShiftNewCardEventEdit']                        = 'document/cardshiftnewcard/cCardShiftNewCard/FSaCardShiftNewCardEditEvent';
$route['cardShiftNewCardEventUpdateApvDocAndCancelDoc']    = 'document/cardshiftnewcard/cCardShiftNewCard/FSaCardShiftNewCardUpdateApvDocAndCancelDocEvent';
$route['cardShiftNewCardUpdateInlineOnTemp']               = 'document/cardshiftnewcard/cCardShiftNewCard/FSxCardShiftNewCardUpdateInlineOnTemp';
$route['cardShiftNewCardInsertToTemp']                     = 'document/cardshiftnewcard/cCardShiftNewCard/FSxCardShiftNewCardInsertToTemp';
$route['cardShiftNewCardUniqueValidate/(:any)']            = 'document/cardshiftnewcard/cCardShiftNewCard/FStCardShiftNewCardUniqueValidate/$1';
$route['cardShiftNewCardChkCardCodeDup']                   = 'document/cardshiftnewcard/cCardShiftNewCard/FSnCardShiftNewCardChkCardCodeDup';
$route['generateCode_Card']                                = 'document/cardshiftnewcard/cCardShiftNewCard/FCNaGenCodeCard';
$route['dcmCardShifNewCardEventDelete']                    = 'document/cardshiftnewcard/cCardShiftNewCard/FSoCardShiftNewCardEventDelete';
$route['dcmCardShifNewCardEventDeleteMulti']               = 'document/cardshiftnewcard/cCardShiftNewCard/FSoCardShiftNewCardEventDeleteMulti';

// Card Shift Out
$route['cardShiftOut/(:any)/(:any)']                       = 'document/cardshiftout/cCardShiftOut/index/$1/$2';
$route['cardShiftOutList']                                 = 'document/cardshiftout/cCardShiftOut/FSvCardShiftOutListPage';
$route['cardShiftOutDataTable']                            = 'document/cardshiftout/cCardShiftOut/FSvCardShiftOutDataList';
$route['cardShiftOutDataSourceTable']                      = 'document/cardshiftout/cCardShiftOut/FSvCardShiftOutDataSourceList';
$route['cardShiftOutDataSourceTableByFile']                = 'document/cardshiftout/cCardShiftOut/FSvCardShiftOutDataSourceListByFile';
$route['cardShiftOutPageAdd']                              = 'document/cardshiftout/cCardShiftOut/FSvCardShiftOutAddPage';
$route['cardShiftOutEventAdd']                             = 'document/cardshiftout/cCardShiftOut/FSaCardShiftOutAddEvent';
$route['cardShiftOutPageEdit']                             = 'document/cardshiftout/cCardShiftOut/FSvCardShiftOutEditPage';
$route['cardShiftOutEventEdit']                            = 'document/cardshiftout/cCardShiftOut/FSaCardShiftOutEditEvent';
$route['cardShiftOutEventUpdateApvDocAndCancelDoc']        = 'document/cardshiftout/cCardShiftOut/FSaCardShiftOutUpdateApvDocAndCancelDocEvent';
$route['cardShiftOutEventScanner']                         = 'document/cardshiftout/cCardShiftOut/FSaCardShiftOutScannerEvent';
$route['cardShiftOutUpdateInlineOnTemp']                   = 'document/cardshiftout/cCardShiftOut/FSxCardShiftOutUpdateInlineOnTemp';
$route['cardShiftOutInsertToTemp']                         = 'document/cardshiftout/cCardShiftOut/FSxCardShiftOutInsertToTemp';
$route['cardShiftOutUniqueValidate/(:any)']                = 'document/cardshiftout/cCardShiftOut/FStCardShiftOutUniqueValidate/$1';
$route['cardShifOutDelDoc']                                = 'document/cardshiftout/cCardShiftOut/FSoCardShiftOutDelete';
$route['cardShiftOutDelDocMulti']                          = 'document/cardshiftout/cCardShiftOut/FSoCardShiftOutDeleteMulti';

// Card Shift Return
$route['cardShiftReturn/(:any)/(:any)']                    = 'document/cardshiftreturn/cCardShiftReturn/index/$1/$2';
$route['cardShiftReturnList']                              = 'document/cardshiftreturn/cCardShiftReturn/FSvCardShiftReturnListPage';
$route['cardShiftReturnDataTable']                         = 'document/cardshiftreturn/cCardShiftReturn/FSvCardShiftReturnDataList';
$route['cardShiftReturnDataSourceTable']                   = 'document/cardshiftreturn/cCardShiftReturn/FSvCardShiftReturnDataSourceList';
$route['cardShiftReturnDataSourceTableByFile']             = 'document/cardshiftreturn/cCardShiftReturn/FSvCardShiftReturnDataSourceListByFile';
$route['cardShiftReturnPageAdd']                           = 'document/cardshiftreturn/cCardShiftReturn/FSvCardShiftReturnAddPage';
$route['cardShiftReturnEventAdd']                          = 'document/cardshiftreturn/cCardShiftReturn/FSaCardShiftReturnAddEvent';
$route['cardShiftReturnPageEdit']                          = 'document/cardshiftreturn/cCardShiftReturn/FSvCardShiftReturnEditPage';
$route['cardShiftReturnEventEdit']                         = 'document/cardshiftreturn/cCardShiftReturn/FSaCardShiftReturnEditEvent';
$route['cardShiftReturnEventUpdateApvDocAndCancelDoc']     = 'document/cardshiftreturn/cCardShiftReturn/FSaCardShiftReturnUpdateApvDocAndCancelDocEvent';
$route['cardShiftReturnGetCardOnHD']                       = 'document/cardshiftreturn/cCardShiftReturn/FSaCardShiftReturnGetCardOnHD';
$route['cardShiftReturnUniqueValidate/(:any)']             = 'document/cardshiftreturn/cCardShiftReturn/FStCardShiftReturnUniqueValidate/$1';
$route['cardShiftReturnUpdateInlineOnTemp']                = 'document/cardshiftreturn/cCardShiftReturn/FSxCardShiftReturnUpdateInlineOnTemp';
$route['cardShiftReturnInsertToTemp']                      = 'document/cardshiftreturn/cCardShiftReturn/FSxCardShiftReturnInsertToTemp';
$route['cardShifReturnEventDelete']                        = 'document/cardshiftreturn/cCardShiftReturn/FSoCardShiftReturnEventDelete';
$route['cardShifReturnEventDeleteMulti']                   = 'document/cardshiftreturn/cCardShiftReturn/FSoCardShiftReturnEventDeleteMulti';
$route['cardShiftReturnEventScanner']                      = 'document/cardshiftreturn/cCardShiftReturn/FSaCardShiftReturnScannerEvent';

// Card Shift TopUp
$route['cardShiftTopUp/(:any)/(:any)']                 = 'document/cardshifttopup/cCardShiftTopUp/index/$1/$2';
$route['cardShiftTopUpList']                           = 'document/cardshifttopup/cCardShiftTopUp/FSvCardShiftTopUpListPage';
$route['cardShiftTopUpDataTable']                      = 'document/cardshifttopup/cCardShiftTopUp/FSvCardShiftTopUpDataList';
$route['cardShiftTopUpDataSourceTable']                = 'document/cardshifttopup/cCardShiftTopUp/FSvCardShiftTopUpDataSourceList';
$route['cardShiftTopUpDataSourceTableByFile']          = 'document/cardshifttopup/cCardShiftTopUp/FSvCardShiftTopUpDataSourceListByFile';
$route['cardShiftTopUpPageAdd']                        = 'document/cardshifttopup/cCardShiftTopUp/FSvCardShiftTopUpAddPage';
$route['cardShiftTopUpEventAdd']                       = 'document/cardshifttopup/cCardShiftTopUp/FSaCardShiftTopUpAddEvent';
$route['cardShiftTopUpPageEdit']                       = 'document/cardshifttopup/cCardShiftTopUp/FSvCardShiftTopUpEditPage';
$route['cardShiftTopUpEventEdit']                      = 'document/cardshifttopup/cCardShiftTopUp/FSaCardShiftTopUpEditEvent';
$route['cardShiftTopUpEventUpdateApvDocAndCancelDoc']  = 'document/cardshifttopup/cCardShiftTopUp/FSaCardShiftTopUpUpdateApvDocAndCancelDocEvent';
$route['cardShiftTopUpUniqueValidate/(:any)']          = 'document/cardshifttopup/cCardShiftTopUp/FStCardShiftTopUpUniqueValidate/$1';
$route['cardShiftTopUpUpdateInlineOnTemp']             = 'document/cardshifttopup/cCardShiftTopUp/FSxCardShiftTopUpUpdateInlineOnTemp';
$route['cardShiftTopUpInsertToTemp']                   = 'document/cardshifttopup/cCardShiftTopUp/FSxCardShiftTopUpInsertToTemp';
$route['cardTopupEventDelete']                         = 'document/cardshifttopup/cCardShiftTopUp/FSoCardTopUpEventDelete';
$route['cardTopupEventDeleteMulti']                    = 'document/cardshifttopup/cCardShiftTopUp/FSoCardTopUpEventDeleteMulti';
$route['cardShiftTopUpEventScanner']                   = 'document/cardshifttopup/cCardShiftTopUp/FSaCardShiftTopUpScannerEvent';

// Card Shift Refund
$route['cardShiftRefund/(:any)/(:any)']                = 'document/cardshiftrefund/cCardShiftRefund/index/$1/$2';
$route['cardShiftRefundList']                          = 'document/cardshiftrefund/cCardShiftRefund/FSvCardShiftRefundListPage';
$route['cardShiftRefundDataTable']                     = 'document/cardshiftrefund/cCardShiftRefund/FSvCardShiftRefundDataList';
$route['cardShiftRefundDataSourceTable']               = 'document/cardshiftrefund/cCardShiftRefund/FSvCardShiftRefundDataSourceList';
$route['cardShiftRefundDataSourceTableByFile']         = 'document/cardshiftrefund/cCardShiftRefund/FSvCardShiftRefundDataSourceListByFile';
$route['cardShiftRefundPageAdd']                       = 'document/cardshiftrefund/cCardShiftRefund/FSvCardShiftRefundAddPage';
$route['cardShiftRefundEventAdd']                      = 'document/cardshiftrefund/cCardShiftRefund/FSaCardShiftRefundAddEvent';
$route['cardShiftRefundPageEdit']                      = 'document/cardshiftrefund/cCardShiftRefund/FSvCardShiftRefundEditPage';
$route['cardShiftRefundEventEdit']                     = 'document/cardshiftrefund/cCardShiftRefund/FSaCardShiftRefundEditEvent';
$route['cardShiftRefundEventUpdateApvDocAndCancelDoc'] = 'document/cardshiftrefund/cCardShiftRefund/FSaCardShiftRefundUpdateApvDocAndCancelDocEvent';
$route['cardShiftRefundUpdateInlineOnTemp']            = 'document/cardshiftrefund/cCardShiftRefund/FSxCardShiftRefundUpdateInlineOnTemp';
$route['cardShiftRefundInsertToTemp']                  = 'document/cardshiftrefund/cCardShiftRefund/FSxCardShiftRefundInsertToTemp';
$route['cardShiftRefundUniqueValidate/(:any)']         = 'document/cardshiftrefund/cCardShiftRefund/FStCardShiftRefundUniqueValidate/$1';
$route['cardShifRefundDelDoc']                         = 'document/cardshiftrefund/cCardShiftRefund/FSoCardShiftRefundDelete';
$route['cardShiftRefundDelDocMulti']                   = 'document/cardshiftrefund/cCardShiftRefund/FSoCardShiftRefundDeleteMulti';
$route['cardShiftRefundEventScanner']                  = 'document/cardshiftrefund/cCardShiftRefund/FSaCardShiftRefundScannerEvent';

//Card Shift Status
$route['cardShiftStatus/(:any)/(:any)']                 = 'document/cardshiftstatus/cCardShiftStatus/index/$1/$2';
$route['cardShiftStatusList']                           = 'document/cardshiftstatus/cCardShiftStatus/FSvCardShiftStatusListPage';
$route['cardShiftStatusDataTable']                      = 'document/cardshiftstatus/cCardShiftStatus/FSvCardShiftStatusDataList';
$route['cardShiftStatusDataSourceTable']                = 'document/cardshiftstatus/cCardShiftStatus/FSvCardShiftStatusDataSourceList';
$route['cardShiftStatusDataSourceTableByFile']          = 'document/cardshiftstatus/cCardShiftStatus/FSvCardShiftStatusDataSourceListByFile';
$route['cardShiftStatusPageAdd']                        = 'document/cardshiftstatus/cCardShiftStatus/FSvCardShiftStatusAddPage';
$route['cardShiftStatusEventAdd']                       = 'document/cardshiftstatus/cCardShiftStatus/FSaCardShiftStatusAddEvent';
$route['cardShiftStatusPageEdit']                       = 'document/cardshiftstatus/cCardShiftStatus/FSvCardShiftStatusEditPage';
$route['cardShiftStatusEventEdit']                      = 'document/cardshiftstatus/cCardShiftStatus/FSaCardShiftStatusEditEvent';
$route['cardShiftStatusEventUpdateApvDocAndCancelDoc']  = 'document/cardshiftstatus/cCardShiftStatus/FSaCardShiftStatusUpdateApvDocAndCancelDocEvent';
$route['cardShiftStatusUpdateInlineOnTemp']             = 'document/cardshiftstatus/cCardShiftStatus/FSxCardShiftStatusUpdateInlineOnTemp';
$route['cardShiftStatusInsertToTemp']                   = 'document/cardshiftstatus/cCardShiftStatus/FSxCardShiftStatusInsertToTemp';
$route['cardShiftStatusUniqueValidate/(:any)']          = 'document/cardshiftstatus/cCardShiftStatus/FStCardShiftStatusUniqueValidate/$1';
$route['cardShifStatusDelDoc']                          = 'document/cardshiftstatus/cCardShiftStatus/FSoCardShiftStatusDelete';
$route['cardShiftStatusDelDocMulti']                    = 'document/cardshiftstatus/cCardShiftStatus/FSoCardShiftStatusDeleteMulti';
$route['cardShiftStatusEventScanner']                   = 'document/cardshiftstatus/cCardShiftStatus/FSaCardShiftStatusScannerEvent';

//Card Shift Change
$route['cardShiftChange/(:any)/(:any)']                 = 'document/cardshiftchange/cCardShiftChange/index/$1/$2';
$route['cardShiftChangeList']                           = 'document/cardshiftchange/cCardShiftChange/FSvCardShiftChangeListPage';
$route['cardShiftChangeDataTable']                      = 'document/cardshiftchange/cCardShiftChange/FSvCardShiftChangeDataList';
$route['cardShiftChangeDataSourceTable']                = 'document/cardshiftchange/cCardShiftChange/FSvCardShiftChangeDataSourceList';
$route['cardShiftChangeDataSourceTableByFile']          = 'document/cardshiftchange/cCardShiftChange/FSvCardShiftChangeDataSourceListByFile';
$route['cardShiftChangePageAdd']                        = 'document/cardshiftchange/cCardShiftChange/FSvCardShiftChangeAddPage';
$route['cardShiftChangeEventAdd']                       = 'document/cardshiftchange/cCardShiftChange/FSaCardShiftChangeAddEvent';
$route['cardShiftChangePageEdit']                       = 'document/cardshiftchange/cCardShiftChange/FSvCardShiftChangeEditPage';
$route['cardShiftChangeEventEdit']                      = 'document/cardshiftchange/cCardShiftChange/FSaCardShiftChangeEditEvent';
$route['cardShiftChangeEventUpdateApvDocAndCancelDoc']  = 'document/cardshiftchange/cCardShiftChange/FSaCardShiftChangeUpdateApvDocAndCancelDocEvent';
$route['cardShiftChangeUpdateInlineOnTemp']             = 'document/cardshiftchange/cCardShiftChange/FSxCardShiftChangeUpdateInlineOnTemp';
$route['cardShiftChangeInsertToTemp']                   = 'document/cardshiftchange/cCardShiftChange/FSxCardShiftChangeInsertToTemp';
$route['cardShiftChangeUniqueValidate/(:any)']          = 'document/cardshiftchange/cCardShiftChange/FStCardShiftChangeUniqueValidate/$1';
$route['cardShiftChangeCardUniqueValidate/(:any)']      = 'document/cardshiftchange/cCardShiftChange/FStCardShiftChangeCardUniqueValidate/$1';
$route['cardShifChangeDelDoc']                          = 'document/cardshiftchange/cCardShiftChange/FSoCardShiftChangeDelete';
$route['cardShiftChangeDelDocMulti']                    = 'document/cardshiftchange/cCardShiftChange/FSoCardShiftChangeDeleteMulti';

//dcmTXII (ใบรับโอนสินค้า)
$route['dcmTXI/(:any)/(:any)/(:any)']  = 'document/transferreceipt/cTransferreceipt/index/$1/$2/$3';
$route['dcmTXIFormSearchList']         = 'document/transferreceipt/cTransferreceipt/FSxCTXIFormSearchList';
$route['dcmTXIPageAdd']                = 'document/transferreceipt/cTransferreceipt/FSxCTXIAddPage';
$route['dcmTXIPageEdit']               = 'document/transferreceipt/cTransferreceipt/FSvCTXIEditPage';
$route['dcmTXIEventAdd']               = 'document/transferreceipt/cTransferreceipt/FSaCTXIAddEvent';
$route['dcmTXIEventEdit']              = 'document/transferreceipt/cTransferreceipt/FSaCTXIEditEvent';
$route['dcmTXIEventDelete']            = 'document/transferreceipt/cTransferreceipt/FSaCTXIDeleteEvent';
$route['dcmTXIPdtMultiDeleteEvent']    = 'document/transferreceipt/cTransferreceipt/FSvCTXIPdtMultiDeleteEvent';
$route['dcmTXIDataTable']              = 'document/transferreceipt/cTransferreceipt/FSxCTXIDataTable';
$route['dcmTXIGetShpByBch']            = 'document/transferreceipt/cTransferreceipt/FSvCTXIGetShpByBch';
$route['dcmTXIAddPdtIntoTableDT']      = 'document/transferreceipt/cTransferreceipt/FSvCTXIAddPdtIntoTableDT';
$route['dcmTXIEditPdtIntoTableDT']     = 'document/transferreceipt/cTransferreceipt/FSvCTXIEditPdtIntoTableDT';
$route['dcmTXIRemovePdtInTemp']        = 'document/transferreceipt/cTransferreceipt/FSvCTXIRemovePdtInTemp';
$route['dcmTXIRemoveAllPdtInFile']     = 'document/transferreceipt/cTransferreceipt/FSvCTXIRemoveAllPdtInFile';
$route['dcmTXIAdvanceTableShowColList'] = 'document/transferreceipt/cTransferreceipt/FSvCTXIAdvTblShowColList';
$route['dcmTXIAdvanceTableShowColSave'] = 'document/transferreceipt/cTransferreceipt/FSvCTXIShowColSave';
$route['dcmTXIGetAddress']             = 'document/transferreceipt/cTransferreceipt/FSvCTXIGetShipAdd';
$route['dcmTXIGetPdtBarCode']          = 'document/transferreceipt/cTransferreceipt/FSvCTXIGetPdtBarCode';
$route['dcmTXIPdtAdvanceTableLoadData'] = 'document/transferreceipt/cTransferreceipt/FSvCTXIPdtAdvTblLoadData';
$route['dcmTXIVatTableLoadData']       = 'document/transferreceipt/cTransferreceipt/FSvCTXIVatLoadData';
$route['dcmTXIApprove']                = 'document/transferreceipt/cTransferreceipt/FSvCTXIApprove';
$route['dcmTXICancel']                 = 'document/transferreceipt/cTransferreceipt/FSvCTXICancel';
$route['dcmTXICalculateLastBill']      = 'document/transferreceipt/cTransferreceipt/FSvCTXICalculateLastBill';
$route['dcmTXIGetDataRefInt']          = 'document/transferreceipt/cTransferreceipt/FSvCTXIGetDataRefInt';
$route['dcmTXIClearDTTemp']            = 'document/transferreceipt/cTransferreceipt/FSvCTXIClearDTTemp';
$route['dcmTXIBrowseDataPDT']          = 'document/transferreceipt/cTransferreceipt/FSvCTXIBrowseDataPDT';
$route['dcmTXIBrowseDataPDTTable']      = 'document/transferreceipt/cTransferreceipt/FSvCTXIBrowseDataTXIPDTTable';

//Adjust Stock (ใบปรับสต๊อก)
$route['adjStkSub/(:any)/(:any)']         = 'document/adjuststocksub/cAdjustStockSub/index/$1/$2';
$route['adjStkSubFormSearchList']         = 'document/adjuststocksub/cAdjustStockSub/FSxCAdjStkSubFormSearchList';
$route['adjStkSubDataTable']              = 'document/adjuststocksub/cAdjustStockSub/FSxCAdjStkSubDataTable';
$route['adjStkSubPageAdd']                = 'document/adjuststocksub/cAdjustStockSub/FSxCAdjStkSubAddPage';
$route['adjStkSubPageEdit']               = 'document/adjuststocksub/cAdjustStockSub/FSvCAdjStkSubEditPage';
$route['adjStkSubEventAdd']               = 'document/adjuststocksub/cAdjustStockSub/FSaCAdjStkSubAddEvent';
$route['adjStkSubEventEdit']              = 'document/adjuststocksub/cAdjustStockSub/FSaCAdjStkSubEditEvent';
$route['adjStkSubEventDelete']            = 'document/adjuststocksub/cAdjustStockSub/FSaCASTDeleteEvent';
$route['adjStkSubApproved']               = 'document/adjuststocksub/cAdjustStockSub/FSaCASTApprove';
$route['adjStkSubCancel']                 = 'document/adjuststocksub/cAdjustStockSub/FSvCAdjStkSubCancel';
$route['adjStkSubRemovePdtInDTTmp']       = 'document/adjuststocksub/cAdjustStockSub/FSvCAdjStkSubRemovePdtInDTTmp';
$route['adjStkSubPdtAdvanceTableLoadData'] = 'document/adjuststocksub/cAdjustStockSub/FSvCAdjStkSubPdtAdvTblLoadData';
$route['adjStkSubPdtMultiDeleteEvent']    = 'document/adjuststocksub/cAdjustStockSub/FSvCAdjStkSubPdtMultiDeleteEvent';
$route['docASTEventAddProducts']           = 'document/adjuststocksub/cAdjustStockSub/FSaCASTEventAddProducts';
$route['docASTEventEditInLine']            = 'document/adjuststocksub/cAdjustStockSub/FSxCASTEditInLine';
$route['docASTEventUpdateDateTime']        = 'document/adjuststocksub/cAdjustStockSub/FSaCASTUpdateDateTime';
$route['docASTEventAddProductsFashion']    = 'document/adjuststocksub/cAdjustStockSub/FSaCASTEventAddProductsFashion';
$route['docASTEventEditProductsFashion']   = 'document/adjuststocksub/cAdjustStockSub/FSaCASTEventEditProductsFashion';

//Credit Note (ใบลดหนี้)
$route['creditNote/(:any)/(:any)']         = 'document/creditnote/cCreditNote/index/$1/$2';
$route['creditNoteFormSearchList']         = 'document/creditnote/cCreditNote/FSxCCreditNoteFormSearchList';
$route['creditNotePageAdd']                = 'document/creditnote/cCreditNote/FSxCCreditNoteAddPage';
$route['creditNotePageEdit']               = 'document/creditnote/cCreditNote/FSvCCreditNoteEditPage';
$route['creditNoteEventAdd']               = 'document/creditnote/cCreditNote/FSaCCreditNoteAddEvent';
$route['creditNoteCheckHaveProductInDT']   = 'document/creditnote/cCreditNote/FSbCheckHaveProductInDT';
$route['creditNoteEventDeleteMultiDoc']    = 'document/creditnote/cCreditNote/FSoCreditNoteDeleteMultiDoc';
$route['creditNoteEventDeleteDoc']         = 'document/creditnote/cCreditNote/FSoCreditNoteDeleteDoc';
$route['creditNoteUniqueValidate/(:any)']  = 'document/creditnote/cCreditNote/FStCCreditNoteUniqueValidate/$1';
$route['creditNoteEventEdit']              = 'document/creditnote/cCreditNote/FSaCCreditNoteEditEvent';
$route['creditNoteDataTable']              = 'document/creditnote/cCreditNote/FSxCCreditNoteDataTable';
$route['creditNoteGetShpByBch']            = 'document/creditnote/cCreditNote/FSvCCreditNoteGetShpByBch';
$route['creditNoteAddPdtIntoTableDT']      = 'document/creditnote/cCreditNote/FSvCCreditNoteAddPdtIntoTableDT';
$route['creditNoteEditPdtIntoTableDT']     = 'document/creditnote/cCreditNote/FSvCCreditNoteEditPdtIntoTableDT';
$route['creditNoteRemovePdtInDTTmp']       = 'document/creditnote/cCreditNote/FSvCCreditNoteRemovePdtInDTTmp';
$route['creditNoteRemovePdtInFile'] = 'document/creditnote/cCreditNote/FSvCCreditNoteRemovePdtInFile';
$route['creditNoteRemoveAllPdtInFile'] = 'document/creditnote/cCreditNote/FSvCCreditNoteRemoveAllPdtInFile';
$route['creditNoteAdvanceTableShowColList'] = 'document/creditnote/cCreditNote/FSvCCreditNoteAdvTblShowColList';
$route['creditNoteAdvanceTableShowColSave'] = 'document/creditnote/cCreditNote/FSvCCreditNoteShowColSave';
$route['creditNoteClearTemp']              = 'document/creditnote/cCreditNote/FSaCreditNoteClearTemp';
$route['creditNoteGetDTDisTableData']      = 'document/creditnote/cCreditNoteDisChgModal/FSvCCreditNoteGetDTDisTableData';
$route['creditNoteAddDTDisIntoTable']      = 'document/creditnote/cCreditNoteDisChgModal/FSvCCreditNoteAddDTDisIntoTable';
$route['creditNoteGetHDDisTableData']      = 'document/creditnote/cCreditNoteDisChgModal/FSvCCreditNoteGetHDDisTableData';
$route['creditNoteAddHDDisIntoTable']      = 'document/creditnote/cCreditNoteDisChgModal/FSvCCreditNoteAddHDDisIntoTable';
$route['creditNoteAddEditDTDis']           = 'document/creditnote/cCreditNoteDisChgModal/FSvCCreditNoteAddEditDTDis';
$route['creditNoteAddEditHDDis']           = 'document/creditnote/cCreditNoteDisChgModal/FSvCCreditNoteAddEditHDDis';
$route['creditNoteGetPdtBarCode']          = 'document/creditnote/cCreditNote/FSvCCreditNoteGetPdtBarCode';
$route['creditNotePdtAdvanceTableLoadData'] = 'document/creditnote/cCreditNote/FSvCCreditNotePdtAdvTblLoadData';
$route['creditNoteNonePdtAdvanceTableLoadData'] = 'document/creditnote/cCreditNote/FSvCCreditNoteNonePdtAdvTblLoadData';
$route['creditNoteCalculateLastBill']      = 'document/creditnote/cCreditNote/FSvCCreditNoteCalculateLastBill';
$route['creditNotePdtMultiDeleteEvent']    = 'document/creditnote/cCreditNote/FSvCCreditNotePdtMultiDeleteEvent';
$route['creditNoteApprove']                = 'document/creditnote/cCreditNote/FSvCCreditNoteApprove';
$route['creditNoteCancel']                 = 'document/creditnote/cCreditNote/FSvCCreditNoteCancel';
$route['creditNoteClearDocTemForChngCdt']  = 'document/creditnote/cCreditNote/FSxCTFXClearDocTemForChngCdt';
$route['creditNoteRefPIHDList']            = 'document/creditnote/cCreditNoteRefPIModal/FSoCreditNoteRefPIHDList';
$route['creditNoteRefPIDTList']            = 'document/creditnote/cCreditNoteRefPIModal/FSoCreditNoteRefPIDTList';
$route['creditNoteDisChgHDList']           = 'document/creditnote/cCreditNoteDisChgModal/FSoCreditNoteDisChgHDList';
$route['creditNoteDisChgDTList']           = 'document/creditnote/cCreditNoteDisChgModal/FSoCreditNoteDisChgDTList';
$route['creditNoteCalEndOfBillNonePdt']    = 'document/creditnote/cCreditNote/FSoCreditNoteCalEndOfBillNonePdt';
$route['creditNoteChangeSPLAffectNewVAT']  = 'document/creditnote/cCreditNote/FSoCCreditNoteChangeSPLAffectNewVAT';


//ใบจ่ายโอนระหว่างคลัง - ใบจ่ายโอนระหว่างสาขา - ใบเบิกออก
$route['dcmTXO/(:any)/(:any)/(:any)']       = 'document/transferout/cTransferout/index/$1/$2/$3';
$route['dcmTXOFormSearchList']              = 'document/transferout/cTransferout/FSvCTXOFormSearchList';
$route['dcmTXODataTable']                   = 'document/transferout/cTransferout/FSxCTXODataTable';
$route['dcmTXOPageAdd']                     = 'document/transferout/cTransferout/FSoCTXOAddPage';
$route['dcmTXOPageEdit']                    = 'document/transferout/cTransferout/FSoCTXOEditPage';
$route['dcmTXOPdtAdvanceTableLoadData']     = 'document/transferout/cTransferout/FSoCTXOPdtAdvTblLoadData';
$route['dcmTXOVatTableLoadData']            = 'document/transferout/cTransferout/FSoCTXOVatLoadData';
$route['dcmTXOCalculateLastBill']           = 'document/transferout/cTransferout/FSoCTXOCalculateLastBill';
$route['dcmTXOAdvanceTableShowColList']     = 'document/transferout/cTransferout/FSoCTXOAdvTblShowColList';
$route['dcmTXOAdvanceTableShowColSave']     = 'document/transferout/cTransferout/FSoCTXOShowColSave';
$route['dcmTXOAddPdtIntoTableDTTmp']        = 'document/transferout/cTransferout/FSoCTXOAddPdtIntoTableDTTmp';
$route['dcmTXOEditPdtIntoTableDTTmp']       = 'document/transferout/cTransferout/FSoCTXOEditPdtIntoTableDTTmp';
$route['dcmTXORemovePdtInDTTmp']            = 'document/transferout/cTransferout/FSoCTXORemovePdtInDTTmp';
$route['dcmTXORemoveMultiPdtInDTTmp']       = 'document/transferout/cTransferout/FSoCTXORemovePdtMultiInDTTmp';
$route['dcmTXOChkHavePdtForTnf']            = 'document/transferout/cTransferout/FSoCTXOChkHavePdtForTnf';
$route['dcmTXOEventAdd']                    = 'document/transferout/cTransferout/FSoCTXOAddEventDoc';
$route['dcmTXOEventEdit']                   = 'document/transferout/cTransferout/FSoCTXOEditEventDoc';
$route['dcmTXOEventDelete']                 = 'document/transferout/cTransferout/FSoCTXODeleteEventDoc';
$route['dcmTXOApproveDoc']                  = 'document/transferout/cTransferout/FSoCTXOApproveDocument';
$route['dcmTXOCancelDoc']                   = 'document/transferout/cTransferout/FSoCTXOCancelDoc';
$route['dcmTXOPrintDoc']                    = 'document/transferout/cTransferout/FSoCTXOPrintDoc';
$route['dcmTXOClearDataDocTemp']            = 'document/transferout/cTransferout/FSoCTXOClearDataDocTemp';
$route['dcmTXOCheckViaCodeForApv']          = 'document/transferout/cTransferout/FSoCTXOCheckViaCodeForApv';

//ใบตรวจนับสินค้า
$route['dcmAST/(:any)/(:any)']          = 'document/adjuststock/cAdjustStock/index/$1/$2';
$route['dcmASTFormSearchList']          = 'document/adjuststock/cAdjustStock/FSvCASTFormSearchList';
$route['dcmASTDataTable']               = 'document/adjuststock/cAdjustStock/FSoCASTDataTable';
$route['dcmASTEventDelete']             = 'document/adjuststock/cAdjustStock/FSoCASTDeleteEventDoc';
$route['dcmASTPageAdd']                 = 'document/adjuststock/cAdjustStock/FSoCASTAddPage';
$route['dcmASTPageEdit']                = 'document/adjuststock/cAdjustStock/FSoCASTEditPage';
$route['dcmASTPdtAdvanceTableLoadData'] = 'document/adjuststock/cAdjustStock/FSoCASTPdtAdvTblLoadData';
$route['dcmASTAdvanceTableShowColList'] = 'document/adjuststock/cAdjustStock/FSoCASTAdvTblShowColList';
$route['dcmASTAdvanceTableShowColSave'] = 'document/adjuststock/cAdjustStock/FSoCASTShowColSave';
$route['dcmASTCheckPdtTmpForTransfer']  = 'document/adjuststock/cAdjustStock/FSbCheckHaveProductForTransfer';
$route['dcmASTAddPdtIntoTableDT']       = 'document/adjuststock/cAdjustStock/FSvCASTAddPdtIntoTableDT';
$route['dcmASTEventAdd']                = 'document/adjuststock/cAdjustStock/FSaCASTAddEvent';
$route['dcmASTEventEdit']               = 'document/adjuststock/cAdjustStock/FSaCASTEditEvent';
$route['dcmASTEditPdtIntoTableDT']      = 'document/adjuststock/cAdjustStock/FSvCASTEditPdtIntoTableDT';
$route['dcmASTRemovePdtInDTTmp']        = 'document/adjuststock/cAdjustStock/FSvCASTRemovePdtInDTTmp';
$route['dcmASTPdtMultiDeleteEvent']     = 'document/adjuststock/cAdjustStock/FSvCASTPdtMultiDeleteEvent';
$route['dcmASTUpdateInline']            = 'document/adjuststock/cAdjustStock/FSoCASTUpdateDataInline';
$route['dcmASTCancel']                  = 'document/adjuststock/cAdjustStock/FSvCASTCancel';
$route['dcmASTApprove']                 = 'document/adjuststock/cAdjustStock/FSvCASTApprove';
$route['dcmASTGetPdtBarCode']           = 'document/adjuststock/cAdjustStock/FSvCASTGetPdtBarCode';
$route['docAdjStkEventAddProducts']     = 'document/adjuststock/cAdjustStock/FSvCAdjStkEventAddProducts';

//ใบรับของ-ใบซื้อสินค้า/บริการ
$route['dcmPI/(:any)/(:any)']           = 'document/purchaseinvoice/cPurchaseInvoice/index/$1/$2';
$route['dcmPIFormSearchList']           = 'document/purchaseinvoice/cPurchaseInvoice/FSvCPIFormSearchList';
$route['dcmPIDataTable']                = 'document/purchaseinvoice/cPurchaseInvoice/FSoCPIDataTable';
$route['dcmPIPageAdd']                  = 'document/purchaseinvoice/cPurchaseInvoice/FSoCPIAddPage';
$route['dcmPIPageEdit']                 = 'document/purchaseinvoice/cPurchaseInvoice/FSoCPIEditPage';
$route['dcmPIPdtAdvanceTableLoadData']  = 'document/purchaseinvoice/cPurchaseInvoice/FSoCPIPdtAdvTblLoadData';
$route['dcmPIVatTableLoadData']         = 'document/purchaseinvoice/cPurchaseInvoice/FSoCPIVatLoadData';
$route['dcmPICalculateLastBill']        = 'document/purchaseinvoice/cPurchaseInvoice/FSoCPICalculateLastBill';
$route['dcmPIEventDelete']              = 'document/purchaseinvoice/cPurchaseInvoice/FSoCPIDeleteEventDoc';
$route['dcmPIAdvanceTableShowColList']  = 'document/purchaseinvoice/cPurchaseInvoice/FSoCPIAdvTblShowColList';
$route['dcmPIAdvanceTableShowColSave']  = 'document/purchaseinvoice/cPurchaseInvoice/FSoCPIAdvTalShowColSave';
$route['dcmPIAddPdtIntoDTDocTemp']      = 'document/purchaseinvoice/cPurchaseInvoice/FSoCPIAddPdtIntoDocDTTemp';
$route['dcmPIEditPdtIntoDTDocTemp']     = 'document/purchaseinvoice/cPurchaseInvoice/FSoCPIEditPdtIntoDocDTTemp';
$route['dcmPIChkHavePdtForDocDTTemp']   = 'document/purchaseinvoice/cPurchaseInvoice/FSoCPIChkHavePdtForDocDTTemp';
$route['dcmPIEventAdd']                 = 'document/purchaseinvoice/cPurchaseInvoice/FSoCPIAddEventDoc';
$route['dcmPIEventEdit']                = 'document/purchaseinvoice/cPurchaseInvoice/FSoCPIEditEventDoc';
$route['dcmPIRemovePdtInDTTmp']         = 'document/purchaseinvoice/cPurchaseInvoice/FSvCPIRemovePdtInDTTmp';
$route['dcmPIRemovePdtInDTTmpMulti']    = 'document/purchaseinvoice/cPurchaseInvoice/FSvCPIRemovePdtInDTTmpMulti';
$route['dcmPICancelDocument']           = 'document/purchaseinvoice/cPurchaseInvoice/FSvCPICancelDocument';
$route['dcmPIApproveDocument']          = 'document/purchaseinvoice/cPurchaseInvoice/FSvCPIApproveDocument';
$route['dcmPISerachAndAddPdtIntoTbl']   = 'document/purchaseinvoice/cPurchaseInvoice/FSoCPISearchAndAddPdtIntoTbl';
$route['dcmPIClearDataDocTemp']         = 'document/purchaseinvoice/cPurchaseInvoice/FSoCPIClearDataInDocTemp';
$route['dcmPIDisChgHDList']             = 'document/purchaseinvoice/cPurchaseInvoiceDisChgModal/FSoCPIDisChgHDList';
$route['dcmPIDisChgDTList']             = 'document/purchaseinvoice/cPurchaseInvoiceDisChgModal/FSoCPIDisChgDTList';
$route['dcmPIAddEditDTDis']             = 'document/purchaseinvoice/cPurchaseInvoiceDisChgModal/FSoCPIAddEditDTDis';
$route['dcmPIAddEditHDDis']             = 'document/purchaseinvoice/cPurchaseInvoiceDisChgModal/FSoCPIAddEditHDDis';
$route['docPIEventCallEndOfBill']       = 'document/purchaseinvoice/cPurchaseInvoice/FSaPICallEndOfBillOnChaheVat';
$route['dcmPIChangeSPLAffectNewVAT']    = 'document/purchaseinvoice/cPurchaseInvoice/FSoCPIChangeSPLAffectNewVAT';
$route['dcmPIMovePODTToDocTmp']         = 'document/purchaseinvoice/cPurchaseInvoice/FSoCPIMovePODTToDocTmp';
$route['dcmPIEventAddPdtIntoDTFhnTemp']  = 'document/purchaseinvoice/cPurchaseInvoice/FSoCPIEventAddPdtIntoDTFhnTemp';

//การกำหนดอัตราค่าเช่า (Locker)
$route['dcmPriRentLocker/(:any)/(:any)']    = 'document/pricerentlocker/cPriceRentLocker/index/$1/$2';
$route['dcmPriRntLkFormSearchList']         = 'document/pricerentlocker/cPriceRentLocker/FSvCPriRntLkFormSearchList';
$route['dcmPriRntLkDataTable']              = 'document/pricerentlocker/cPriceRentLocker/FSoCPriRntLkDataTable';
$route['dcmPriRntLkPageAdd']                = 'document/pricerentlocker/cPriceRentLocker/FSoCPriRntLkAddPage';
$route['dcmPriRntLkPageEdit']               = 'document/pricerentlocker/cPriceRentLocker/FSoCPriRntLkEditPage';
$route['dcmPriRntLkLoadDataDT']             = 'document/pricerentlocker/cPriceRentLocker/FSoCPriRntLkLoadDataDT';
$route['dcmPriRntLkEventAdd']               = 'document/pricerentlocker/cPriceRentLocker/FSoCPriRntLkEventAdd';
$route['dcmPriRntLkEventEdit']              = 'document/pricerentlocker/cPriceRentLocker/FSoCPriRntLkEventEdit';
$route['dcmPriRntLkEvemtDeleteSingle']      = 'document/pricerentlocker/cPriceRentLocker/FSoCPriRntLkEventDelSingle';
$route['dcmPriRntLkEvemtDeleteMulti']       = 'document/pricerentlocker/cPriceRentLocker/FSoCPriRntLkEventDelMultiple';

//การกำหนดคูปอง
$route['dcmCouponSetup/(:any)/(:any)']      = 'document/couponsetup/cCouponSetup/index/$1/$2';
$route['dcmCouponSetupFormSearchList']      = 'document/couponsetup/cCouponSetup/FSvCCPHFormSearchList';
$route['dcmCouponSetupGetDataTable']        = 'document/couponsetup/cCouponSetup/FSoCCPHGetDataTable';
$route['dcmCouponSetupPageAdd']             = 'document/couponsetup/cCouponSetup/FSoCCPHCallPageAdd';
$route['dcmCouponSetupPageEdit']            = 'document/couponsetup/cCouponSetup/FSoCCPHCallPageEdit';
$route['dcmCouponSetupPageDetailDT']        = 'document/couponsetup/cCouponSetup/FSoCCPHCallPageDetailDT';
$route['dcmCouponSetupPageDetailDT']        = 'document/couponsetup/cCouponSetup/FSoCCPHCallPageDetailDT';
$route['dcmCouponSetupEventAddCouponToDT']  = 'document/couponsetup/cCouponSetup/FSoCCPHCallEventAddCouponToDT';
$route['dcmCouponSetupEventAdd']            = 'document/couponsetup/cCouponSetup/FSoCCPHEventAdd';
$route['dcmCouponSetupEventEdit']           = 'document/couponsetup/cCouponSetup/FSoCCPHEventEdit';
$route['dcmCouponSetupEventDelete']         = 'document/couponsetup/cCouponSetup/FSoCCPHEventDelete';
$route['dcmCouponSetupEvenApprove']         = 'document/couponsetup/cCouponSetup/FSaCCPHEventAppove';
$route['dcmCouponSetupEvenCancel']          = 'document/couponsetup/cCouponSetup/FSaCCPHEventCancel';
$route['dcmCouponSetupChangStatusAfApv']    = 'document/couponsetup/cCouponSetup/FSaCCPHChangStatusAfApv';

// Import การกำหนดคูปอง
$route['dcmCPHPageImportDataTable']         = 'document/couponsetup/cCouponSetupImport/FSaCCPHImportDataTable';
$route['dcmCPHEventGetDataImport']          = 'document/couponsetup/cCouponSetupImport/FSaCCPHGetDataImport';
$route['dcmCPHEventGetItemAllImport']       = 'document/couponsetup/cCouponSetupImport/FSaCCPHImportGetItemAll';
$route['dcmCPHEventImportDelete']           = 'document/couponsetup/cCouponSetupImport/FSaCCPHImportDelete';
$route['dcmCPHEventImportMove2Master']      = 'document/couponsetup/cCouponSetupImport/FSaCCPHImportMove2Master';

//ใบเติมสินค้า
$route['TWXVD/(:any)/(:any)']                       = 'document/topupVending/cTopupVending/index/$1/$2';
$route['TopupVendingList']                          = 'document/topupVending/cTopupVending/FSxCTUVTopupVendingList';
$route['TopupVendingDataTable']                     = 'document/topupVending/cTopupVending/FSxCTUVTopupVendingDataTable';
$route['TopupVendingCallPageAdd']                   = 'document/topupVending/cTopupVending/FSxCTUVTopupVendingAddPage';
$route['TopupVendingEventAdd']                      = 'document/topupVending/cTopupVending/FSaCTUVTopupVendingAddEvent';
$route['TopupVendingCallPageEdit']                  = 'document/topupVending/cTopupVending/FSvCTUVTopupVendingEditPage';
$route['TopupVendingEventEdit']                     = 'document/topupVending/cTopupVending/FSaCTUVTopupVendingEditEvent';
$route['TopupVendingDocApprove']                    = 'document/topupVending/cTopupVending/FStCTopUpVendingDocApprove';
$route['TopupVendingDocCancel']                     = 'document/topupVending/cTopupVending/FStCTopUpVendingDocCancel';
$route['TopupVendingDelDoc']                        = 'document/topupVending/cTopupVending/FStTopUpVendingDeleteDoc';
$route['TopupVendingDelDocMulti']                   = 'document/topupVending/cTopupVending/FStTopUpVendingDeleteMultiDoc';
$route['TopupVendingGetWahByShop']                  = 'document/topupVending/cTopupVending/FStGetWahByShop';
$route['TopupVendingUniqueValidate']                = 'document/topupVending/cTopupVending/FStCTopUpVendingUniqueValidate/$1';
$route['TopupVendingInsertPdtLayoutToTmp']          = 'document/topupVending/cTopupVending/FSaCTUVTopupVendingInsertPdtLayoutToTmp';
$route['TopupVendingGetPdtLayoutDataTableInTmp']    = 'document/topupVending/cTopupVending/FSxCTUVTopupVendingGetPdtLayoutDataTableInTmp';
$route['TopupVendingUpdatePdtLayoutInTmp']          = 'document/topupVending/cTopupVending/FSxCTUVTopupVendingUpdatePdtLayoutInTmp';
$route['TopupVendingDeletePdtLayoutInTmp']          = 'document/topupVending/cTopupVending/FSxCTUVTopupVendingDeletePdtLayoutInTmp';
$route['TopupVendingDeleteMultiPdtLayoutInTmp']     = 'document/topupVending/cTopupVending/FSxCTUVTopupVendingDeleteMultiPdtLayoutInTmp';
$route['dcmTVDEventDelPdtValueZero']                = 'document/topupVending/cTopupVending/FSxCTVDDelPdtValueZero';
$route['TopupVendingDeleteDataDTTemp']              = 'document/topupVending/cTopupVending/FSxCTUVTopupVendingDeleteDelDTTemp';

//ใบนำฝาก
$route['deposit/(:any)/(:any)']            = 'document/deposit/cDeposit/index/$1/$2';
$route['depositList']                      = 'document/deposit/cDeposit/FSxCDepositList';
$route['depositDataTable']                 = 'document/deposit/cDeposit/FSxCDepositDataTable';
$route['depositCallPageAdd']               = 'document/deposit/cDeposit/FSxCDepositAddPage';
$route['depositEventAdd']                  = 'document/deposit/cDeposit/FSaCDepositAddEvent';
$route['depositCallPageEdit']              = 'document/deposit/cDeposit/FSvCDepositEditPage';
$route['depositEventEdit']                 = 'document/deposit/cDeposit/FSaCDepositEditEvent';
$route['depositUniqueValidate']            = 'document/deposit/cDeposit/FStCDepositUniqueValidate/$1';
$route['depositDocApprove']                = 'document/deposit/cDeposit/FStCDepositDocApprove';
$route['depositDocCancel']                 = 'document/deposit/cDeposit/FStCDepositDocCancel';
$route['depositDelDoc']                    = 'document/deposit/cDeposit/FStDepositDeleteDoc';
$route['depositDelDocMulti']               = 'document/deposit/cDeposit/FStDepositDeleteMultiDoc';
$route['depositInsertCashToTmp']           = 'document/deposit/cDepositCash/FSaCDepositInsertCashToTmp';
$route['depositGetCashInTmp']              = 'document/deposit/cDepositCash/FSxCDepositGetCashInTmp';
$route['depositUpdateCashInTmp']           = 'document/deposit/cDepositCash/FSxCDepositUpdateCashInTmp';
$route['depositDeleteCashInTmp']           = 'document/deposit/cDepositCash/FSxCDepositDeleteCashInTmp';
$route['depositClearCashInTmp']            = 'document/deposit/cDepositCash/FSxCDepositClearCashInTmp';
$route['depositInsertChequeToTmp']         = 'document/deposit/cDepositCheque/FSaCDepositInsertChequeToTmp';
$route['depositGetChequeInTmp']            = 'document/deposit/cDepositCheque/FSxCDepositGetChequeInTmp';
$route['depositUpdateChequeInTmp']         = 'document/deposit/cDepositCheque/FSxCDepositUpdateChequeInTmp';
$route['depositDeleteChequeInTmp']         = 'document/deposit/cDepositCheque/FSxCDepositDeleteChequeInTmp';
$route['depositClearChequeInTmp']          = 'document/deposit/cDepositCheque/FSxCDepositClearChequeInTmp';

//เงื่อนไขการแลกแต้ม
$route['dcmRDH/(:any)/(:any)']             = 'document/conditionredeem/cConditionRedeem/index/$1/$2';
$route['dcmRDHFormSearchList']             = 'document/conditionredeem/cConditionRedeem/FSvCRDHFormSearchList';
$route['dcmRDHGetDataTable']               = 'document/conditionredeem/cConditionRedeem/FSoCRDHGetDataTable';
$route['dcmRDHPageAdd']                    = 'document/conditionredeem/cConditionRedeem/FSoCRDHCallPageAdd';
$route['dcmRDHPageEdit']                   = 'document/conditionredeem/cConditionRedeem/FSoCRDHCallPageEdit';
$route['dcmRDHPageDetailDT']               = 'document/conditionredeem/cConditionRedeem/FSoCRDHCallPageDetailDT';
$route['dcmRDHEventAddCouponToDT']         = 'document/conditionredeem/cConditionRedeem/FSoCRDHCallEventAddCouponToDT';
$route['dcmRDHEventAdd']                   = 'document/conditionredeem/cConditionRedeem/FSoCRDHEventAdd';
$route['dcmRDHEventEdit']                  = 'document/conditionredeem/cConditionRedeem/FSoCRDHEventEdit';
$route['dcmRDHEventDelete']                = 'document/conditionredeem/cConditionRedeem/FSoCRDHEventDelete';
$route['dcmRDHEvenApprove']                = 'document/conditionredeem/cConditionRedeem/FSaCRDHEventAppove';
$route['dcmRDHEvenCancel']                 = 'document/conditionredeem/cConditionRedeem/FSaCRDHEventCancel';
$route['dcmRDHAddPdtIntoDTDocTemp']        = 'document/conditionredeem/cConditionRedeem/FSaCRDHEventAddPdtTemp';
$route['dcmRDHPdtAdvanceTableLoadData']    = 'document/conditionredeem/cConditionRedeem/FSaCRDHECallEventPdtTemp';
$route['dcmRDHPdtAdvanceTableDeleteSingle'] = 'document/conditionredeem/cConditionRedeem/FSaCRDHPdtAdvanceTableDeleteSingle';
$route['dcmRDHPdtClearConditionRedeemTmp']  = 'document/conditionredeem/cConditionRedeem/FSxCRDHClearConditionRedeemTmp';
$route['dcmRDHSaveGrpNameDTTemp']           = 'document/conditionredeem/cConditionRedeem/FSaCRDHInsertGrpNamePDTToTemp';
$route['dcmRDHGetGrpDTTemp']                = 'document/conditionredeem/cConditionRedeem/FSaCRDHGetGrpNamePDTToTemp';
$route['dcmRDHSetPdtGrpDTTemp']             = 'document/conditionredeem/cConditionRedeem/FSaCRDHSetPdtGrpDTTemp';
$route['dcmRDHDelGroupInDTTemp']            = 'document/conditionredeem/cConditionRedeem/FSaCRDHDelGroupInDTTemp';
$route['dcmRDHChangStatusAfApv']            = 'document/conditionredeem/cConditionRedeem/FSaCRDHChangStatusAfApv';

/*===== Begin โปรโมชั่น ==================================================================*/
// Master
$route['promotion/(:any)/(:any)']           = 'document/promotion/cPromotion/index/$1/$2';
$route['promotionList']                     = 'document/promotion/cPromotion/FSxCPromotionList';
$route['promotionDataTable']                = 'document/promotion/cPromotion/FSxCPromotionDataTable';
$route['promotionCallPageAdd']              = 'document/promotion/cPromotion/FSxCPromotionAddPage';
$route['promotionEventAdd']                 = 'document/promotion/cPromotion/FSaCPromotionAddEvent';
$route['promotionCallPageEdit']             = 'document/promotion/cPromotion/FSvCPromotionEditPage';
$route['promotionEventEdit']                = 'document/promotion/cPromotion/FSaCPromotionEditEvent';
$route['promotionUniqueValidate']           = 'document/promotion/cPromotion/FStCPromotionUniqueValidate/$1';
$route['promotionDocApprove']               = 'document/promotion/cPromotion/FStCPromotionDocApprove';
$route['promotionDocCancel']                = 'document/promotion/cPromotion/FStCPromotionDocCancel';
$route['promotionDelDoc']                   = 'document/promotion/cPromotion/FStPromotionDeleteDoc';
$route['promotionDelDocMulti']              = 'document/promotion/cPromotion/FStPromotionDeleteMultiDoc';
$route['promotionEvenCopy']                 = 'document/promotion/cPromotion/FStPromotionCopyDoc';

// Step1 PMTDT Tmp
$route['promotionStep1ConfirmPmtDtInTmp']               = 'document/promotion/cPromotionStep1PmtDt/FSxCPromotionConfirmPmtDtInTmp';
$route['promotionStep1CancelPmtDtInTmp']                = 'document/promotion/cPromotionStep1PmtDt/FSxCPromotionCancelPmtDtInTmp';
$route['promotionStep1PmtDtInTmpToBin']                 = 'document/promotion/cPromotionStep1PmtDt/FSxCPromotionPmtDtInTmpToBin';
$route['promotionStep1DeletePmtDtInTmp']                = 'document/promotion/cPromotionStep1PmtDt/FSxCPromotionDeletePmtDtInTmp';
$route['promotionStep1DeleteMorePmtDtInTmp']            = 'document/promotion/cPromotionStep1PmtDt/FSxCPromotionDeleteMorePmtDtInTmp';
$route['promotionStep1ClearPmtDtInTmp']                 = 'document/promotion/cPromotionStep1PmtDt/FSxCPromotionClearPmtDtInTmp';
// Step1 Group Name
$route['promotionStep1GetPmtDtGroupNameInTmp']          = 'document/promotion/cPromotionStep1PmtDt/FSxCPromotionGetPmtDtGroupNameInTmp';
$route['promotionStep1DeletePmtDtGroupNameInTmp']       = 'document/promotion/cPromotionStep1PmtDt/FSxCPromotionDeletePmtDtGroupNameInTmp';
$route['promotionStep1UniqueValidateGroupName']         = 'document/promotion/cPromotionStep1PmtDt/FStCPromotionPmtDtUniqueValidate';
// Step1 PDT Tmp
$route['promotionStep1InsertPmtPdtDtToTmp']             = 'document/promotion/cPromotionStep1PmtPdtDt/FSaCPromotionInsertPmtPdtDtToTmp';
$route['promotionStep1GetPmtPdtDtInTmp']                = 'document/promotion/cPromotionStep1PmtPdtDt/FSxCPromotionGetPmtPdtDtInTmp';
$route['promotionStep1UpdatePmtPdtDtInTmp']             = 'document/promotion/cPromotionStep1PmtPdtDt/FSxCPromotionUpdatePmtPdtDtInTmp';
// Step1 Brand Tmp
$route['promotionStep1InsertPmtBrandDtToTmp']           = 'document/promotion/cPromotionStep1PmtBrandDt/FSaCPromotionInsertPmtBrandDtToTmp';
$route['promotionStep1GetPmtBrandDtInTmp']              = 'document/promotion/cPromotionStep1PmtBrandDt/FSxCPromotionGetPmtBrandDtInTmp';
$route['promotionStep1UpdatePmtBrandDtInTmp']           = 'document/promotion/cPromotionStep1PmtBrandDt/FSxCPromotionUpdatePmtBrandDtInTmp';
// Step1 Import PmtDt from Excel
$route['promotionStep1ImportExcelPmtDtToTmp']           = 'document/promotion/cPromotionStep1ImportPmtExcel/FStPromotionImportFromExcel';
// Step2 Group Name
$route['promotionStep2GetPmtDtGroupNameInTmp']          = 'document/promotion/cPromotionStep2PmtDt/FSxCPromotionGetPmtDtGroupNameInTmp';
$route['promotionStep2GetPmtCBInTmp']                   = 'document/promotion/cPromotionStep2PmtDt/FStCPromotionGetPmtCBInTmp';
$route['promotionStep2GetPmtCGInTmp']                   = 'document/promotion/cPromotionStep2PmtDt/FStCPromotionGetPmtCGInTmp';
// Step3 PmtCB
$route['promotionStep3GetPmtCBInTmp']                   = 'document/promotion/cPromotionStep3PmtCB/FSxCPromotionGetPmtCBInTmp';
$route['promotionStep3InsertPmtCBToTmp']                = 'document/promotion/cPromotionStep3PmtCB/FSaCPromotionInsertPmtCBToTmp';
$route['promotionStep3UpdatePmtCBInTmp']                = 'document/promotion/cPromotionStep3PmtCB/FSxCPromotionUpdatePmtCBInTmp';
$route['promotionStep3DeletePmtCBInTmp']                = 'document/promotion/cPromotionStep3PmtCB/FSaCPromotionDeletePmtCBInTmp';
$route['promotionStep3UpdatePmtCGAndPmtCBPerAvgDisInTmp'] = 'document/promotion/cPromotionStep3PmtCB/FSxCPromotionUpdatePmtCGAndPmtCBPerAvgDisInTmp';
// Step3 PmtCG
$route['promotionStep3GetPmtCGInTmp']                   = 'document/promotion/cPromotionStep3PmtCG/FSxCPromotionGetPmtCGInTmp';
$route['promotionStep3InsertPmtCGToTmp']                = 'document/promotion/cPromotionStep3PmtCG/FSaCPromotionInsertPmtCGToTmp';
$route['promotionStep3UpdatePmtCGInTmp']                = 'document/promotion/cPromotionStep3PmtCG/FSxCPromotionUpdatePmtCGInTmp';
$route['promotionStep3UpdatePmtCGPgtStaGetTypeInTmp']   = 'document/promotion/cPromotionStep3PmtCG/FSxCPromotionUpdatePmtCGPgtStaGetTypeInTmp';
$route['promotionStep3DeletePmtCGInTmp']                = 'document/promotion/cPromotionStep3PmtCG/FSaCPromotionDeletePmtCGInTmp';
$route['promotionStep3ClearPmtCGInTmp']                 = 'document/promotion/cPromotionStep3PmtCG/FSxCPromotionClearPmtCGInTmp';
// Step3 PmtCB With PmtCG
$route['promotionStep3GetPmtCBWithPmtCGInTmp']          = 'document/promotion/cPromotionStep3PmtCB/FSxCPromotionGetPmtCBWithPmtCGInTmp';
$route['promotionStep3InsertPmtCBAndPmtCGToTmp']        = 'document/promotion/cPromotionStep3PmtCB/FSaCPromotionInsertPmtCBAndPmtCGToTmp';
$route['promotionStep3DeletePmtCBAndPmtCGInTmpBySeq']   = 'document/promotion/cPromotionStep3PmtCB/FSaCPromotionDeletePmtCBAndPmtCGInTmpBySeq';
$route['promotionStep3GetPmtCBAndPmtCGPgtPerAvgDisInTmp'] = 'document/promotion/cPromotionStep3PmtCB/FStCPromotionGetPmtCBAndPmtCGPgtPerAvgDisInTmp';
// Step3 Coupon
$route['promotionStep3InsertOrUpdateCouponToTmp']       = 'document/promotion/cPromotionStep3Coupon/FSaCPromotionInsertOrUpdateCouponToTmp';
$route['promotionStep3GetCouponInTmp']                  = 'document/promotion/cPromotionStep3Coupon/FStCPromotionGetCouponInTmp';
$route['promotionStep3DeleteCouponInTmp']               = 'document/promotion/cPromotionStep3Coupon/FSxCPromotionDeleteCouponInTmp';
// Step3 Point
$route['promotionStep3InsertOrUpdatePointToTmp']        = 'document/promotion/cPromotionStep3Point/FSaCPromotionInsertOrUpdatePointToTmp';
$route['promotionStep3GetPointInTmp']                   = 'document/promotion/cPromotionStep3Point/FStCPromotionGetPointInTmp';
$route['promotionStep3DeletePointInTmp']                = 'document/promotion/cPromotionStep3Point/FSxCPromotionDeletePointInTmp';
// Step4 PriceGroup Condition
$route['promotionStep4GetPriceGroupConditionInTmp']     = 'document/promotion/cPromotionStep4PriceGroupCondition/FSxCPromotionGetPdtPmtHDCstPriInTmp';
$route['promotionStep4InsertPriceGroupConditionToTmp']  = 'document/promotion/cPromotionStep4PriceGroupCondition/FSaCPromotionInsertPriceGroupToTmp';
$route['promotionStepeUpdatePriceGroupConditionInTmp']  = 'document/promotion/cPromotionStep4PriceGroupCondition/FSxCPromotionUpdatePriceGroupInTmp';
$route['promotionStep4DeletePriceGroupConditionInTmp']  = 'document/promotion/cPromotionStep4PriceGroupCondition/FSxCPromotionDeletePriceGroupInTmp';
// Step4 Branch Condition
$route['promotionStep4GetBchConditionInTmp']            = 'document/promotion/cPromotionStep4BchCondition/FSxCPromotionGetBchConditionInTmp';
$route['promotionStep4InsertBchConditionToTmp']         = 'document/promotion/cPromotionStep4BchCondition/FSaCPromotionInsertBchConditionToTmp';
$route['promotionStepeUpdateBchConditionInTmp']         = 'document/promotion/cPromotionStep4BchCondition/FSxCPromotionUpdateBchConditionInTmp';
$route['promotionStep4DeleteBchConditionInTmp']         = 'document/promotion/cPromotionStep4BchCondition/FSxCPromotionDeleteBchConditionInTmp';
// Step4 Channel Condition
$route['promotionStep4GetChnConditionInTmp'] = 'document/promotion/cPromotionStep4ChnCondition/FSxCPromotionGetHDChnInTmp';
$route['promotionStep4InsertChnConditionToTmp'] = 'document/promotion/cPromotionStep4ChnCondition/FSaCPromotionInsertChnToTmp';
$route['promotionStepeUpdateChnConditionInTmp'] = 'document/promotion/cPromotionStep4ChnCondition/FSxCPromotionUpdateChnInTmp';
$route['promotionStep4DeleteChnConditionInTmp'] = 'document/promotion/cPromotionStep4ChnCondition/FSxCPromotionDeleteChnInTmp';
// Step4 Customer Level Condition
$route ['promotionStep4GetCstLevConditionInTmp'] = 'document/promotion/cPromotionStep4CstLevCondition/FSxCPromotionGetPdtPmtHDCstLevInTmp';
$route ['promotionStep4InsertCstLevConditionToTmp'] = 'document/promotion/cPromotionStep4CstLevCondition/FSaCPromotionInsertCstLevToTmp';
$route ['promotionStepeUpdateCstLevConditionInTmp'] = 'document/promotion/cPromotionStep4CstLevCondition/FSxCPromotionUpdateCstLevInTmp';
$route ['promotionStep4DeleteCstLevConditionInTmp'] = 'document/promotion/cPromotionStep4CstLevCondition/FSxCPromotionDeleteCstLevInTmp';

// Step5 Check and Confirm
$route['promotionStep5GetCheckAndConfirmPage']          = 'document/promotion/cPromotionStep5CheckAndConfirm/FSxCPromotionGetCheckAndConfirmPage';
$route['promotionStep5UpdatePmtCBStaCalSumInTmp']       = 'document/promotion/cPromotionStep5CheckAndConfirm/FSxCPromotionUpdatePmtCBStaCalSumInTmp';
$route['promotionStep5UpdatePmtCGStaGetEffectInTmp']    = 'document/promotion/cPromotionStep5CheckAndConfirm/FSxCPromotionUpdatePmtCGStaGetEffectInTmp';
// Create Promotion By Import
$route['promotionImportExcelToTmp']                     = 'document/promotion/cPromotionStep1ImportPmtExcel/FStPromotionImportExcelToTmp';
$route['promotionGetImportExcelMainPage']               = 'document/promotion/cPromotionStep1ImportPmtExcel/FStPromotionGetImportExcelMainPage';
$route['promotionImportExcelTempToMaster']              = 'document/promotion/cPromotionStep1ImportPmtExcel/FSoCImportTempToMaster';
$route['promotionClearImportExcelInTmp']                = 'document/promotion/cPromotionStep1ImportPmtExcel/FSoCImportClearInTemp';
// Summary HD
// Product Group
$route['promotionGetImportExcelPdtGroupInTmp']          = 'document/promotion/cPromotionStep1ImportPmtExcel/FSoCImportGetPdtGroupInTmp';
$route['promotionGetImportExcelPdtGroupDataJsonInTmp']  = 'document/promotion/cPromotionStep1ImportPmtExcel/FSoCImportGetPdtGroupDataJsonInTmp';
$route['promotionDeleteImportExcelPdtGroupInTempBySeq'] = 'document/promotion/cPromotionStep1ImportPmtExcel/FSoCImportDeletePdtGroupInTempBySeqNo';
$route['promotionGetImportExcelPdtGroupStaInTmp']       = 'document/promotion/cPromotionStep1ImportPmtExcel/FSoCImportGetStaPdtGroupInTemp';
// Condition-กลุ่มซื้อ
$route['promotionGetImportExcelCBInTmp']                = 'document/promotion/cPromotionStep1ImportPmtExcel/FSoCImportGetCBInTmp';
$route['promotionGetImportExcelCBDataJsonInTmp']        = 'document/promotion/cPromotionStep1ImportPmtExcel/FSoCImportGetCBDataJsonInTmp';
$route['promotionDeleteImportExcelCBInTempBySeq']       = 'document/promotion/cPromotionStep1ImportPmtExcel/FSoCImportDeleteCBInTempBySeqNo';
$route['promotionGetImportExcelCBStaInTmp']             = 'document/promotion/cPromotionStep1ImportPmtExcel/FSoCImportGetStaCBInTemp';
// Option1-กลุ่มรับ(กรณีส่วนลด)
$route['promotionGetImportExcelCGInTmp']                = 'document/promotion/cPromotionStep1ImportPmtExcel/FSoCImportGetCGInTmp';
$route['promotionGetImportExcelCGDataJsonInTmp']        = 'document/promotion/cPromotionStep1ImportPmtExcel/FSoCImportGetCGDataJsonInTmp';
$route['promotionDeleteImportExcelCGInTempBySeq']       = 'document/promotion/cPromotionStep1ImportPmtExcel/FSoCImportDeleteCGInTempBySeqNo';
$route['promotionGetImportExcelCGStaInTmp']             = 'document/promotion/cPromotionStep1ImportPmtExcel/FSoCImportGetStaCGInTemp';
// Option2-กลุ่มรับ(กรณีcoupon)
// Option3-กลุ่มรับ(กรณีแต้ม)
/*===== End โปรโมชั่น ====================================================================*/

//ใบจ่ายโอน - เนลว์ 06/03/2020
$route['TWO/(:any)/(:any)/(:any)']                          = 'document/transferwarehouseout/cTransferwarehouseout/index/$1/$2/$3';
$route['TWOTransferwarehouseoutList']                       = 'document/transferwarehouseout/cTransferwarehouseout/FSxCTWOTransferwarehouseoutList';
$route['TWOTransferwarehouseoutDataTable']                  = 'document/transferwarehouseout/cTransferwarehouseout/FSxCTWOTransferwarehouseoutDataTable';
$route['TWOTransferwarehouseoutPageAdd']                    = 'document/transferwarehouseout/cTransferwarehouseout/FSvCTWOTransferwarehouseoutPageAdd';
$route['TWOTransferwarehouseoutPageEdit']                   = 'document/transferwarehouseout/cTransferwarehouseout/FSvCTWOTransferwarehouseoutPageEdit';
$route['TWOTransferwarehouseoutPdtAdvanceTableLoadData']    = 'document/transferwarehouseout/cTransferwarehouseout/FSoCTWOPdtAdvTblLoadData';
$route['TWOTransferAdvanceTableShowColList']                = 'document/transferwarehouseout/cTransferwarehouseout/FSoCTWOAdvTblShowColList';
$route['TWOTransferAdvanceTableShowColSave']                = 'document/transferwarehouseout/cTransferwarehouseout/FSoCTWOAdvTalShowColSave';
$route['TWOTransferwarehouseoutAddPdtIntoDTDocTemp']        = 'document/transferwarehouseout/cTransferwarehouseout/FSoCTWOAddPdtIntoDocDTTemp';
$route['TWOTransferwarehouseoutRemovePdtInDTTmp']           = 'document/transferwarehouseout/cTransferwarehouseout/FSvCTWORemovePdtInDTTmp';
$route['TWOTransferwarehouseoutRemovePdtInDTTmpMulti']      = 'document/transferwarehouseout/cTransferwarehouseout/FSvCTWORemovePdtInDTTmpMulti';
$route['dcmTWOEventEdit']                                   = 'document/transferwarehouseout/cTransferwarehouseout/FSoCTWOEditEventDoc';
$route['dcmTWOEventAdd']                                    = 'document/transferwarehouseout/cTransferwarehouseout/FSoCTWOAddEventDoc';
$route['TWOTransferwarehouseoutEventDelete']                = 'document/transferwarehouseout/cTransferwarehouseout/FSoCTWODeleteEventDoc';
$route['TWOTransferwarehouseoutEventCencel']                = 'document/transferwarehouseout/cTransferwarehouseout/FSoCTWOEventCancel';
$route['TWOTransferwarehouseoutEventEditInline']            = 'document/transferwarehouseout/cTransferwarehouseout/FSoCTWOEditPdtIntoDocDTTemp';
$route['TWOTransferwarehouseoutEventApproved']              = 'document/transferwarehouseout/cTransferwarehouseout/FSoCTWOApproved';
$route['TWOTransferwarehouseoutEventAddPdtIntoDTFhnTemp']   = 'document/transferwarehouseout/cTransferwarehouseout/FSoCTWOEventAddPdtIntoDTFhnTemp';
// $route['docTFWEventAddPdtIntoDTFhnTemp']                    = 'document/producttransferwahouse/cProducttransferwahouse/FSoCTFWEventAddPdtIntoDTFhnTemp';

$route['docTransferwarehouseoutRefIntDoc']                        = 'document/transferwarehouseout/cTransferwarehouseout/FSoCTransferBchOutRefIntDoc';
$route['docTransferwarehouseoutRefIntDocDataTable']               = 'document/transferwarehouseout/cTransferwarehouseout/FSoCTransferBchOutCallRefIntDocDataTable';
$route['docTransferwarehouseoutRefIntDocDetailDataTable']         = 'document/transferwarehouseout/cTransferwarehouseout/FSoCTransferBchOutCallRefIntDocDetailDataTable';
$route['docTransferwarehouseoutRefIntDocInsertDTToTemp']          = 'document/transferwarehouseout/cTransferwarehouseout/FSoCTransferBchOutCallRefIntDocInsertDTToTemp';


$route['docTWOPageHDDocRefN']                                = 'document/transferwarehouseout/cTransferwarehouseout/FSaCTWOPageHDDocRef';
$route['docTWOEventAddEditHDDocRefN']                        = 'document/transferwarehouseout/cTransferwarehouseout/FSaCTWOEventAddEditHDDocRef';
$route['docTWOEventDelHDDocRefN']                            = 'document/transferwarehouseout/cTransferwarehouseout/FSoCTWOEventDelHDDocRef';
$route['docTWOEventGenDocPacking']                          = 'document/transferwarehouseout/cTransferwarehouseout/FSxCTWOEventGenDocPacking';
$route['docTWOEventChkPdtB4Apv']                            = 'document/transferwarehouseout/cTransferwarehouseout/FSaCTWOEventChkPdtB4Apv';
$route['docTWOEventGetConfigGenDocPack']                    = 'document/transferwarehouseout/cTransferwarehouseout/FSoCTWOEventGetConfigGenDocPack';
$route['docTWOEventSaveConfigGenDocPack']                   = 'document/transferwarehouseout/cTransferwarehouseout/FSoCTWOEventSaveConfigGenDocPack';

//ใบจ่ายโอน - สาขา
$route['docTransferBchOut/(:any)/(:any)']                   = 'document/transfer_branch_out/cTransferBchOut/index/$1/$2';
$route['docTransferBchOutList']                             = 'document/transfer_branch_out/cTransferBchOut/FSxCTransferBchOutList';
$route['docTransferBchOutDataTable']                        = 'document/transfer_branch_out/cTransferBchOut/FSxCTransferBchOutDataTable';
$route['docTransferBchOutCallPageAdd']                      = 'document/transfer_branch_out/cTransferBchOut/FSxCTransferBchOutAddPage';
$route['docTransferBchOutEventAdd']                         = 'document/transfer_branch_out/cTransferBchOut/FSaCTransferBchOutAddEvent';
$route['docTransferBchOutCallPageEdit']                     = 'document/transfer_branch_out/cTransferBchOut/FSvCTransferBchOutEditPage';
$route['docTransferBchOutEventEdit']                        = 'document/transfer_branch_out/cTransferBchOut/FSaCTransferBchOutEditEvent';
$route['docTransferBchOutUniqueValidate']                   = 'document/transfer_branch_out/cTransferBchOut/FStCTransferBchOutUniqueValidate/$1';
$route['docTransferBchOutDocApprove']                       = 'document/transfer_branch_out/cTransferBchOut/FStCTransferBchOutDocApprove';
$route['docTransferBchOutDocCancel']                        = 'document/transfer_branch_out/cTransferBchOut/FStCTransferBchOutDocCancel';
$route['docTransferBchOutDelDoc']                           = 'document/transfer_branch_out/cTransferBchOut/FStTransferBchOutDeleteDoc';
$route['docTransferBchOutDelDocMulti']                      = 'document/transfer_branch_out/cTransferBchOut/FStTransferBchOutDeleteMultiDoc';
$route['docTransferBchOutInsertPdtToTmp']                   = 'document/transfer_branch_out/cTransferBchOutPdt/FSaCTransferBchOutInsertPdtToTmp';
$route['docTransferBchOutGetPdtInTmp']                      = 'document/transfer_branch_out/cTransferBchOutPdt/FSxCTransferBchOutGetPdtInTmp';
$route['docTransferBchOutUpdatePdtInTmp']                   = 'document/transfer_branch_out/cTransferBchOutPdt/FSxCTransferBchOutUpdatePdtInTmp';
$route['docTransferBchOutDeletePdtInTmp']                   = 'document/transfer_branch_out/cTransferBchOutPdt/FSxCTransferBchOutDeletePdtInTmp';
$route['docTransferBchOutDeleteMorePdtInTmp']               = 'document/transfer_branch_out/cTransferBchOutPdt/FSxCTransferBchOutDeleteMorePdtInTmp';
$route['docTransferBchOutClearPdtInTmp']                    = 'document/transfer_branch_out/cTransferBchOutPdt/FSxCTransferBchOutClearPdtInTmp';
$route['docTransferBchOutGetPdtColumnList']                 = 'document/transfer_branch_out/cTransferBchOutPdt/FStCTransferBchOutGetPdtColumnList';
$route['docTransferBchOutUpdatePdtColumn']                  = 'document/transfer_branch_out/cTransferBchOutPdt/FStCTransferBchOutUpdatePdtColumn';

$route['docTransferBchOutRefIntDoc']                        = 'document/transfer_branch_out/cTransferBchOutPdt/FSoCTransferBchOutRefIntDoc';
$route['docTransferBchOutRefIntDocDataTable']               = 'document/transfer_branch_out/cTransferBchOutPdt/FSoCTransferBchOutCallRefIntDocDataTable';
$route['docTransferBchOutRefIntDocDetailDataTable']         = 'document/transfer_branch_out/cTransferBchOutPdt/FSoCTransferBchOutCallRefIntDocDetailDataTable';
$route['docTransferBchOutRefIntDocInsertDTToTemp']          = 'document/transfer_branch_out/cTransferBchOutPdt/FSoCTransferBchOutCallRefIntDocInsertDTToTemp';

$route['docTBOPageHDDocRef']                                = 'document/transfer_branch_out/cTransferBchOut/FSaCTBOPageHDDocRef';
$route['docTBOEventAddEditHDDocRef']                        = 'document/transfer_branch_out/cTransferBchOut/FSaCTBOEventAddEditHDDocRef';
$route['docTBOEventDelHDDocRef']                            = 'document/transfer_branch_out/cTransferBchOut/FSoCTBOEventDelHDDocRef';
$route['docTBOEventGenDocPacking']                          = 'document/transfer_branch_out/cTransferBchOut/FSxCTBOEventGenDocPacking';
$route['docTBOEventChkPdtB4Apv']                            = 'document/transfer_branch_out/cTransferBchOut/FSaCTBOEventChkPdtB4Apv';
$route['docTBOEventGetConfigGenDocPack']                    = 'document/transfer_branch_out/cTransferBchOut/FSoCTBOEventGetConfigGenDocPack';
$route['docTBOEventSaveConfigGenDocPack']                   = 'document/transfer_branch_out/cTransferBchOut/FSoCTBOEventSaveConfigGenDocPack';

$route['docTBOCancelOnApv']                                 = 'document/transfer_branch_out/cTransferBchOut/FSoCTBOEventCancelOnApv';



//ใบรับโอน - สาขา เนลว์ 20/03/2020
$route['docTBI/(:any)/(:any)/(:any)']          = 'document/transferreceiptbranch/cTransferreceiptbranch/index/$1/$2/$3';
$route['docTBIPageList']                       = 'document/transferreceiptbranch/cTransferreceiptbranch/FSxCTBIPageList';
$route['docTBIPageDataTable']                  = 'document/transferreceiptbranch/cTransferreceiptbranch/FSxCTBIPageDataTable';
$route['docTBIPageAdd']                        = 'document/transferreceiptbranch/cTransferreceiptbranch/FSvCTBIPageAdd';
$route['docTBIPageEdit']                       = 'document/transferreceiptbranch/cTransferreceiptbranch/FSvCTBIPageEdit';
$route['docTBIPagePdtAdvanceTableLoadData']    = 'document/transferreceiptbranch/cTransferreceiptbranch/FSoCTBIPagePdtAdvTblLoadData';
$route['docTBIPageTableShowColList']           = 'document/transferreceiptbranch/cTransferreceiptbranch/FSoCTBIPageAdvTblShowColList';
$route['docTBIEventTableShowColSave']          = 'document/transferreceiptbranch/cTransferreceiptbranch/FSoCTBIEventAdvTalShowColSave';
$route['docTBIEventAddPdtIntoDTDocTemp']       = 'document/transferreceiptbranch/cTransferreceiptbranch/FSoCTBIEventAddPdtIntoDocDTTemp';
$route['docTBIEventRemovePdtInDTTmp']          = 'document/transferreceiptbranch/cTransferreceiptbranch/FSvCTBIEventRemovePdtInDTTmp';
$route['docTBIEventRemovePdtInDTTmpMulti']     = 'document/transferreceiptbranch/cTransferreceiptbranch/FSvCTBIEventRemovePdtInDTTmpMulti';
$route['docTBIEventEdit']                      = 'document/transferreceiptbranch/cTransferreceiptbranch/FSoCTBIEventEdit';
$route['docTBIEventAdd']                       = 'document/transferreceiptbranch/cTransferreceiptbranch/FSoCTBIEventAdd';
$route['docTBIEventDelete']                    = 'document/transferreceiptbranch/cTransferreceiptbranch/FSoCTBIEventDelete';
$route['docTBIEventCencel']                    = 'document/transferreceiptbranch/cTransferreceiptbranch/FSoCTBIEventCancel';
$route['docTBIEventEditInline']                = 'document/transferreceiptbranch/cTransferreceiptbranch/FSoCTBIEventEditPdtIntoDocDTTemp';
$route['docTBIPageSelectPDTInCN']              = 'document/transferreceiptbranch/cTransferreceiptbranch/FSoCTBIPageSelectPDTInCN';
$route['docTBIEventApproved']                  = 'document/transferreceiptbranch/cTransferreceiptbranch/FSoCTBIEventApproved';
$route['docTBIEventClearTemp']                 = 'document/transferreceiptbranch/cTransferreceiptbranch/FSxCTBIEventClearTemp';
$route['docTBIEventGetPdtIntDTBch']            = 'document/transferreceiptbranch/cTransferreceiptbranch/FSoCTBIEventGetPdtIntDTBch';
$route['docTBITransferBchOutGetPdtInTmp']      = 'document/transferreceiptbranch/cTransferreceiptbranch/FSxCTBIBchOutGetPdtInTmp';
$route['docTBIPageHDDocRef']                   = 'document/transferreceiptbranch/cTransferreceiptbranch/FSaCTBIPageHDDocRef';
$route['docTBIEventAddEditHDDocRef']           = 'document/transferreceiptbranch/cTransferreceiptbranch/FSaCTBIEventAddEditHDDocRef';
$route['docTBIEventDelHDDocRef']               = 'document/transferreceiptbranch/cTransferreceiptbranch/FSoCTBIEventDelHDDocRef';
$route['docTBITransferBchOutRefIntDocDataTable']  = 'document/transferreceiptbranch/cTransferreceiptbranch/FSoCTransferBchOutCallRefIntDocDataTable';

//$route['docTBITransferBchOutRefIntDocDataTable']            = 'document/cTransferreceiptbranch/cTransferBchOutPdt/FSoCTransferBchOutCallRefIntDocDataTable';



$route['docTBITransferBchOutRefIntDocDetailDataTable']         = 'document/transferreceiptbranch/cTransferreceiptbranch/FSoCTransferBchOutCallRefIntDocDetailDataTable';
$route['docTBITransferBchOutDeleteMorePdtInTmp']               = 'document/transferreceiptbranch/cTransferreceiptbranch/FSxCTransferBchOutDeleteMorePdtInTmp';
$route['docTBITransferBchOutDeletePdtInTmp']                   = 'document/transferreceiptbranch/cTransferreceiptbranch/FSxCTransferBchOutDeletePdtInTmp';
$route['docTBITransferBchOutUpdatePdtInTmp']                   = 'document/transferreceiptbranch/cTransferreceiptbranch/FSxCTransferBchOutUpdatePdtInTmp';
$route['docTBITransferBchOutRefIntDoc']                        = 'document/transferreceiptbranch/cTransferreceiptbranch/FSoCTBIBchOutRefIntDoc';
//$route['docTBITransferBchOutRefIntDocDataTable']               = 'document/transferreceiptbranch/cTransferreceiptbranch/FSoCTBIBchOutCallRefIntDocDataTable';
//$route['docTBITransferBchOutRefIntDocDetailDataTable']         = 'document/transferreceiptbranch/cTransferreceiptbranch/FSoCTBIBchOutCallRefIntDocDetailDataTable';
$route['docTBITransferBchOutRefIntDocInsertDTToTemp']          = 'document/transferreceiptbranch/cTransferreceiptbranch/FSoCTBIBchOutCallRefIntDocInsertDTToTemp';
//ใบรับโอน - คลังสินค้า - วัฒน์ 20/02/2020
$route['TWI/(:any)/(:any)']                         = 'document/transferreceiptNew/cTransferreceiptNew/index/$1/$2';
$route['TWITransferReceiptList']                    = 'document/transferreceiptNew/cTransferreceiptNew/FSxCTWITransferReceiptList';
$route['TWITransferReceiptDataTable']               = 'document/transferreceiptNew/cTransferreceiptNew/FSxCTWITransferReceiptDataTable';
$route['TWITransferReceiptPageAdd']                 = 'document/transferreceiptNew/cTransferreceiptNew/FSvCTWITransferReceiptPageAdd';
$route['TWITransferReceiptPageEdit']                = 'document/transferreceiptNew/cTransferreceiptNew/FSvCTWITransferReceiptPageEdit';
$route['TWITransferReceiptPdtAdvanceTableLoadData'] = 'document/transferreceiptNew/cTransferreceiptNew/FSoCTWIPdtAdvTblLoadData';
$route['TWITransferAdvanceTableShowColList']        = 'document/transferreceiptNew/cTransferreceiptNew/FSoCTWIAdvTblShowColList';
$route['TWITransferAdvanceTableShowColSave']        = 'document/transferreceiptNew/cTransferreceiptNew/FSoCTWIAdvTalShowColSave';
$route['TWITransferReceiptAddPdtIntoDTDocTemp']     = 'document/transferreceiptNew/cTransferreceiptNew/FSoCTWIAddPdtIntoDocDTTemp';
$route['TWITransferReceiptRemovePdtInDTTmp']        = 'document/transferreceiptNew/cTransferreceiptNew/FSvCTWIRemovePdtInDTTmp';
$route['TWITransferReceiptRemovePdtInDTTmpMulti']   = 'document/transferreceiptNew/cTransferreceiptNew/FSvCTWIRemovePdtInDTTmpMulti';
$route['dcmTWIEventEdit']                           = 'document/transferreceiptNew/cTransferreceiptNew/FSoCTWIEditEventDoc';
$route['dcmTWIEventAdd']                            = 'document/transferreceiptNew/cTransferreceiptNew/FSoCTWIAddEventDoc';
$route['TWITransferReceiptEventDelete']             = 'document/transferreceiptNew/cTransferreceiptNew/FSoCTWIDeleteEventDoc';
$route['TWITransferReceiptEventCencel']             = 'document/transferreceiptNew/cTransferreceiptNew/FSoCTWIEventCancel';
$route['TWITransferReceiptEventEditInline']         = 'document/transferreceiptNew/cTransferreceiptNew/FSoCTWIEditPdtIntoDocDTTemp';
$route['TWITransferReceiptSelectPDTInCN']           = 'document/transferreceiptNew/cTransferreceiptNew/FSoCTWISelectPDTInCN';
$route['TWITransferReceiptEventApproved']           = 'document/transferreceiptNew/cTransferreceiptNew/FSoCTWIApproved';
$route['TWITransferReceiptRefDoc']                  = 'document/transferreceiptNew/cTransferreceiptNew/FSaCTWIRefDoc';
$route['TWITransferReceiptRefGetWah']               = 'document/transferreceiptNew/cTransferreceiptNew/FSaCTWIGetWahRefDoc';

//ใบรับเข้า - คลังสินค้า - วัฒน์ 20/02/2020
$route['TXOOut/(:any)/(:any)']                         = 'document/transferreceiptOut/cTransferreceiptOut/index/$1/$2';
$route['TXOOutTransferReceiptList']                    = 'document/transferreceiptOut/cTransferreceiptOut/FSxCTWOTransferReceiptList';
$route['TXOOutTransferReceiptDataTable']               = 'document/transferreceiptOut/cTransferreceiptOut/FSxCTWOTransferReceiptDataTable';
$route['TXOOutTransferReceiptPageAdd']                 = 'document/transferreceiptOut/cTransferreceiptOut/FSvCTWOTransferReceiptPageAdd';
$route['TXOOutTransferReceiptPageEdit']                = 'document/transferreceiptOut/cTransferreceiptOut/FSvCTWOTransferReceiptPageEdit';
$route['TXOOutTransferReceiptPdtAdvanceTableLoadData'] = 'document/transferreceiptOut/cTransferreceiptOut/FSoCTWOPdtAdvTblLoadData';
$route['TXOOutTransferAdvanceTableShowColList']        = 'document/transferreceiptOut/cTransferreceiptOut/FSoCTWOAdvTblShowColList';
$route['TXOOutTransferAdvanceTableShowColSave']        = 'document/transferreceiptOut/cTransferreceiptOut/FSoCTWOAdvTalShowColSave';
$route['TXOOutTransferReceiptAddPdtIntoDTDocTemp']     = 'document/transferreceiptOut/cTransferreceiptOut/FSoCTWOAddPdtIntoDocDTTemp';
$route['TXOOutTransferReceiptAddPdtIntoDTFhnTemp']     = 'document/transferreceiptOut/cTransferreceiptOut/FSoCTWOAddPdtIntoDocDTFhnTemp';
$route['TXOOutTransferReceiptRemovePdtInDTTmp']        = 'document/transferreceiptOut/cTransferreceiptOut/FSvCTWORemovePdtInDTTmp';
$route['TXOOutTransferReceiptRemovePdtInDTTmpMulti']   = 'document/transferreceiptOut/cTransferreceiptOut/FSvCTWORemovePdtInDTTmpMulti';
$route['dcmTXOOutEventEdit']                           = 'document/transferreceiptOut/cTransferreceiptOut/FSoCTWOEditEventDoc';
$route['dcmTXOOutEventAdd']                            = 'document/transferreceiptOut/cTransferreceiptOut/FSoCTWOAddEventDoc';
$route['TXOOutTransferReceiptEventDelete']             = 'document/transferreceiptOut/cTransferreceiptOut/FSoCTWODeleteEventDoc';
$route['TXOOutTransferReceiptEventCencel']             = 'document/transferreceiptOut/cTransferreceiptOut/FSoCTWOEventCancel';
$route['TXOOutTransferReceiptEventEditInline']         = 'document/transferreceiptOut/cTransferreceiptOut/FSoCTWOEditPdtIntoDocDTTemp';
$route['TXOOutTransferReceiptSelectPDTInCN']           = 'document/transferreceiptOut/cTransferreceiptOut/FSoCTWOSelectPDTInCN';
$route['TXOOutTransferReceiptEventApproved']           = 'document/transferreceiptOut/cTransferreceiptOut/FSoCTWOApproved';
// เอกสารอ้างอิง
$route['docTWOEventAddEditHDDocRef']                   = 'document/transferreceiptOut/cTransferreceiptOut/FSaCTWOEventAddEditHDDocRef';
$route['docTWOPageHDDocRef']                           = 'document/transferreceiptOut/cTransferreceiptOut/FSaCTWOPageHDDocRef';
$route['docTWOEventDelHDDocRef']                       = 'document/transferreceiptOut/cTransferreceiptOut/FSoCTWIOEventDelHDDocRef';
//หาราคาที่มีส่วนลด
$route['GetPriceAlwDiscount']                          = 'document/creditnote/cCreditNoteDisChgModal/FSaCCENGetPriceAlwDiscount';

//เอกสารใบตรวจนับ - รวม สินค้าคงคลัง
$route['docSM/(:any)/(:any)']                           = 'document/adjuststocksum/cAdjustStockSum/index/$1/$2';
$route['docSMFormSearchList']                           = 'document/adjuststocksum/cAdjustStockSum/FSvCSMFormSearchList';
$route['docSMDataTable']                                = 'document/adjuststocksum/cAdjustStockSum/FSoCSMGetDataTable';
$route['docSMPageAdd']                                  = 'document/adjuststocksum/cAdjustStockSum/FSoCSMCallPageAdd';
$route['docSMPageEdit']                                 = 'document/adjuststocksum/cAdjustStockSum/FSoCSMCallPageEdit';
$route['docSMEventCallPdtStkSum']                       = 'document/adjuststocksum/cAdjustStockSum/FSoCSMEventCallPdtStkSum';
$route['docSMTableLoadData']                            = 'document/adjuststocksum/cAdjustStockSum/FSoCSMCallTableLoadData';
$route['docSMEventEditInLine']                          = 'document/adjuststocksum/cAdjustStockSum/FSoCSMEventEditInLine';
$route['docSMEventRemovePdtInDTTmp']                    = 'document/adjuststocksum/cAdjustStockSum/FSvCEventRemovePdtInDTTmp';
$route['docSMEventRemoveMultiPdtInDTTmp']               = 'document/adjuststocksum/cAdjustStockSum/FSvCEventRemoveMultiPdtInDTTmp';
$route['docSMEventClearTemp']                           = 'document/adjuststocksum/cAdjustStockSum/FSxCSMEventClearTemp';
$route['docSMEventDelete']                              = 'document/adjuststocksum/cAdjustStockSum/FSaCSMEventDelete';
$route['docSMEventAdd']                                 = 'document/adjuststocksum/cAdjustStockSum/FSoCSMEventAdd';
$route['docSMEventEdit']                                = 'document/adjuststocksum/cAdjustStockSum/FSoCSMEventEdit';
$route['docSMEventApprove']                             = 'document/adjuststocksum/cAdjustStockSum/FSaCSMEventAppove';
$route['docSMEventCancel']                              = 'document/adjuststocksum/cAdjustStockSum/FSaCSMEventCancel';
$route['docSMEEventEditProductsFashion']                = 'document/adjuststocksum/cAdjustStockSum/FSaCSMEventEditProductsFashion';

//ใบคืนสินค้า - ตู้สินค้า : Napat(Jame) 03/09/2020
$route['docTVO/(:any)/(:any)']                          = 'document/TransferVendingOut/cTransferVendingOut/index/$1/$2';
$route['docTVOPageList']                                = 'document/TransferVendingOut/cTransferVendingOut/FSvCTVOPageList';
$route['docTVOPageDataTable']                           = 'document/TransferVendingOut/cTransferVendingOut/FSvCTVOPageDataTable';
$route['docTVOPageAdd']                                 = 'document/TransferVendingOut/cTransferVendingOut/FSvCTVOPageAdd';
$route['docTVOPageEdit']                                = 'document/TransferVendingOut/cTransferVendingOut/FSvCTVOPageEdit';
$route['docTVOEventAdd']                                = 'document/TransferVendingOut/cTransferVendingOut/FSaCTVOEventAdd';
$route['docTVOEventEdit']                               = 'document/TransferVendingOut/cTransferVendingOut/FSaCTVOEventEdit';
$route['docTVOEventMoveDTFromRefInt']                   = 'document/TransferVendingOut/cTransferVendingOut/FSaCTVOEventMoveDTFromRefInt';
$route['docTVOEventInsertPdtLayoutToTmp']               = 'document/TransferVendingOut/cTransferVendingOut/FSaCTVOEventInsertPdtLayoutToTmp';
$route['dcmTVOEventEditInline']                         = 'document/TransferVendingOut/cTransferVendingOut/FSvCTVOEventEditInline';
$route['docTVOEventApprove']                            = 'document/TransferVendingOut/cTransferVendingOut/FSaCTVOEventApprove';
$route['docTVOPageDataTablePdtLayout']                  = 'document/TransferVendingOut/cTransferVendingOut/FSaCTVOPageDataTablePdtLayout';
$route['docTVOEventDeletePdtLayoutInTmp']               = 'document/TransferVendingOut/cTransferVendingOut/FSxCTVOEventDeletePdtLayoutInTmp';
$route['docTVOEventCancleDoc']                          = 'document/TransferVendingOut/cTransferVendingOut/FStCTVOEventDocCancel';
$route['docTVOEventDelDTTempAll']                       = 'document/TransferVendingOut/cTransferVendingOut/FSaCTVOEventDelDTTempAll';

/* ยังไม่ได้ตรวจสอบ อาจเป็น route ขยะ Napat(Jame) */
$route['TopupVendingDelDoc']                           = 'document/topupVending/cTopupVending/FStTopUpVendingDeleteDoc';
$route['TopupVendingDelDocMulti']                      = 'document/topupVending/cTopupVending/FStTopUpVendingDeleteMultiDoc';
$route['TopupVendingGetWahByShop']                     = 'document/topupVending/cTopupVending/FStGetWahByShop';
$route['TopupVendingUniqueValidate']                   = 'document/topupVending/cTopupVending/FStCTopUpVendingUniqueValidate/$1';



//ใบกับกำภาษีอย่างย่อ
$route['dcmTXIN/(:any)/(:any)']                         = 'document/taxinvoice/cTaxinvoice/index/$1/$2';
$route['dcmTXINLoadList']                               = 'document/taxinvoice/cTaxinvoice/FSvCTAXLoadList';
$route['dcmTXINLoadListDataTable']                      = 'document/taxinvoice/cTaxinvoice/FSvCTAXLoadListDatatable';
$route['dcmTXINLoadPageAdd']                            = 'document/taxinvoice/cTaxinvoice/FSvCTAXLoadPageAdd';
$route['dcmTXINLoadDatatable']                          = 'document/taxinvoice/cTaxinvoice/FSvCTAXLoadDatatable';
$route['dcmTXINLoadDatatableABB']                       = 'document/taxinvoice/cTaxinvoice/FSvCTAXLoadDatatableABB';
$route['dcmTXINCheckABB']                               = 'document/taxinvoice/cTaxinvoice/FSaCTAXCheckABBNumber';
$route['dcmTXINLoadAddress']                            = 'document/taxinvoice/cTaxinvoice/FSaCTAXLoadAddress';
$route['dcmTXINCheckTaxNO']                             = 'document/taxinvoice/cTaxinvoice/FSaCTAXCheckTaxno';
$route['dcmTXINLoadDatatableTaxNO']                     = 'document/taxinvoice/cTaxinvoice/FSvCTAXLoadDatatableTaxno';
$route['dcmTXINLoadDatatableCustomerAddress']           = 'document/taxinvoice/cTaxinvoice/FSvCTAXLoadDatatableCustomerAddress';
$route['dcmTXINCustomerAddress']                        = 'document/taxinvoice/cTaxinvoice/FSaCTAXLoadCustomerAddress';
$route['dcmTXINApprove']                                = 'document/taxinvoice/cTaxinvoice/FSaCTAXApprove';
$route['dcmTXINLoadDatatableTax']                       = 'document/taxinvoice/cTaxinvoice/FSvCTAXLoadDatatableTax';
$route['dcmTXINLoadDatatableDTTax']                     = 'document/taxinvoice/cTaxinvoice/FSvCTAXLoadDatatableDTTax';
$route['dcmTXINUpdateWhenApprove']                      = 'document/taxinvoice/cTaxinvoice/FSxCTAXUpdateWhenApprove';
$route['dcmTXINCallTaxNoLastDoc']                       = 'document/taxinvoice/cTaxinvoice/FSxCTAXCallTaxNoLastDoc';
$route['dcmTXINCheckBranchInComp']                      = 'document/taxinvoice/cTaxinvoice/FSxCTAXCheckBranchInComp';
$route['docTAXEventApvETax']                            = 'document/taxinvoice/cTaxinvoice/FSaCTAXEventApvETax';

//ใบกับกำภาษีอย่างย่อ (FC)
$route['dcmTXFC/(:any)/(:any)']                         = 'document/taxinvoicefc/cTaxinvoicefc/index/$1/$2';
$route['dcmTXFCLoadList']                               = 'document/taxinvoicefc/cTaxinvoicefc/FSvCTXFLoadList';
$route['dcmTXFCLoadListDataTable']                      = 'document/taxinvoicefc/cTaxinvoicefc/FSvCTXFLoadListDatatable';
$route['dcmTXFCLoadPageAdd']                            = 'document/taxinvoicefc/cTaxinvoicefc/FSvCTXFLoadPageAdd';
$route['dcmTXFCLoadDatatable']                          = 'document/taxinvoicefc/cTaxinvoicefc/FSvCTXFLoadDatatable';
$route['dcmTXFCLoadDatatableABB']                       = 'document/taxinvoicefc/cTaxinvoicefc/FSvCTXFLoadDatatableABB';
$route['dcmTXFCCheckABB']                               = 'document/taxinvoicefc/cTaxinvoicefc/FSaCTXFCheckABBNumber';
$route['dcmTXFCLoadAddress']                            = 'document/taxinvoicefc/cTaxinvoicefc/FSaCTXFLoadAddress';
$route['dcmTXFCCheckTaxNO']                             = 'document/taxinvoicefc/cTaxinvoicefc/FSaCTXFCheckTaxno';
$route['dcmTXFCLoadDatatableTaxNO']                     = 'document/taxinvoicefc/cTaxinvoicefc/FSvCTXFLoadDatatableTaxno';
$route['dcmTXFCLoadDatatableCustomerAddress']           = 'document/taxinvoicefc/cTaxinvoicefc/FSvCTXFLoadDatatableCustomerAddress';
$route['dcmTXFCCustomerAddress']                        = 'document/taxinvoicefc/cTaxinvoicefc/FSaCTXFLoadCustomerAddress';
$route['dcmTXFCApprove']                                = 'document/taxinvoicefc/cTaxinvoicefc/FSaCTXFApprove';
$route['dcmTXFCLoadDatatableTax']                       = 'document/taxinvoicefc/cTaxinvoicefc/FSvCTXFLoadDatatableTax';
$route['dcmTXFCLoadDatatableDTTax']                     = 'document/taxinvoicefc/cTaxinvoicefc/FSvCTXFLoadDatatableDTTax';
$route['dcmTXFCUpdateWhenApprove']                      = 'document/taxinvoicefc/cTaxinvoicefc/FSxCTXFUpdateWhenApprove';
$route['dcmTXFCFindABB']                                = 'document/taxinvoicefc/cTaxinvoicefc/FSxCTXFFindABB';
$route['CallTaxInvoice/(:any)/(:any)']                  = 'document/taxinvoicefc/cTaxinvoicefc/FSvCTXFCallTaxInvoice/$1/$2';
$route['dcmTXFCCheckBranchInComp']                      = 'document/taxinvoicefc/cTaxinvoicefc/FSxCTAXCheckBranchInComp';

// ========================================= ใบสั้งขาย - STD =========================================== //
$route['dcmSO/(:any)/(:any)']                       = 'document/saleorder/cSaleOrder/index/$1/$2';
$route['dcmSOFormSearchList']                       = 'document/saleorder/cSaleOrder/FSvCSOFormSearchList';
$route['dcmSODataTable']                            = 'document/saleorder/cSaleOrder/FSoCSODataTable';
$route['dcmSOPageAdd']                              = 'document/saleorder/cSaleOrder/FSoCSOAddPage';
$route['dcmSOPageEdit']                             = 'document/saleorder/cSaleOrder/FSoCSOEditPage';
$route['dcmSOPdtAdvanceTableLoadData']              = 'document/saleorder/cSaleOrder/FSoCSOPdtAdvTblLoadData';
$route['dcmSOVatTableLoadData']                     = 'document/saleorder/cSaleOrder/FSoCSOVatLoadData';
$route['dcmSOCalculateLastBill']                    = 'document/saleorder/cSaleOrder/FSoCSOCalculateLastBill';
$route['dcmSOEventDelete']                          = 'document/saleorder/cSaleOrder/FSoCSODeleteEventDoc';
$route['dcmSOAdvanceTableShowColList']              = 'document/saleorder/cSaleOrder/FSoCSOAdvTblShowColList';
$route['dcmSOAdvanceTableShowColSave']              = 'document/saleorder/cSaleOrder/FSoCSOAdvTalShowColSave';
$route['dcmSOAddPdtIntoDTDocTemp']                  = 'document/saleorder/cSaleOrder/FSoCSOAddPdtIntoDocDTTemp';
$route['dcmSOEditPdtIntoDTDocTemp']                 = 'document/saleorder/cSaleOrder/FSoCSOEditPdtIntoDocDTTemp';
$route['dcmSOChkHavePdtForDocDTTemp']               = 'document/saleorder/cSaleOrder/FSoCSOChkHavePdtForDocDTTemp';
$route['dcmSOEventAdd']                             = 'document/saleorder/cSaleOrder/FSoCSOAddEventDoc';
$route['dcmSOEventEdit']                            = 'document/saleorder/cSaleOrder/FSoCSOEditEventDoc';
$route['dcmSORemovePdtInDTTmp']                     = 'document/saleorder/cSaleOrder/FSvCSORemovePdtInDTTmp';
$route['dcmSORemovePdtInDTTmpMulti']                = 'document/saleorder/cSaleOrder/FSvCSORemovePdtInDTTmpMulti';
$route['dcmSOCancelDocument']                       = 'document/saleorder/cSaleOrder/FSvCSOCancelDocument';
$route['dcmSOApproveDocument']                      = 'document/saleorder/cSaleOrder/FSvCSOApproveDocument';
$route['dcmSOSerachAndAddPdtIntoTbl']               = 'document/saleorder/cSaleOrder/FSoCSOSearchAndAddPdtIntoTbl';
$route['dcmSOClearDataDocTemp']                     = 'document/saleorder/cSaleOrder/FSoCSOClearDataInDocTemp';
$route['dcmSODisChgHDList']                         = 'document/saleorder/cSaleOrderDisChgModal/FSoCSODisChgHDList';
$route['dcmSODisChgDTList']                         = 'document/saleorder/cSaleOrderDisChgModal/FSoCSODisChgDTList';
$route['dcmSOAddEditDTDis']                         = 'document/saleorder/cSaleOrderDisChgModal/FSoCSOAddEditDTDis';
$route['dcmSOAddEditHDDis']                         = 'document/saleorder/cSaleOrderDisChgModal/FSoCSOAddEditHDDis';
$route['dcmSOPocessAddDisTmpCst']                   = 'document/saleorder/cSaleOrderDisChgModal/FSoCSOPocessAddDisTmpCst';
$route['dcmSOPageEditMonitor']                      = 'document/saleorder/cSaleOrder/FSoCSOEditPageMonitor';
$route['dcmSOPdtAdvanceTableLoadDataMonitor']       = 'document/saleorder/cSaleOrder/FSoCSOPdtAdvTblLoadDataMonitor';
$route['dcmSORejectDocument']                       = 'document/saleorder/cSaleOrder/FSvCSORejectDocument';
$route['dcmCheckSO/(:any)/(:any)']                  = 'document/checksaleorderapprove/cChkSaleOrderApprove/index/$1/$2';
$route['dcmCheckSoPageMain']                        = 'document/checksaleorderapprove/cChkSaleOrderApprove/FSvCCHKSoCallPageMain';

// ========================================= ใบสั้งขาย - STATDOSE =========================================== //
$route['dcmSOSTD/(:any)/(:any)']                           = 'document/saleorder_statdose/cSaleOrder/index/$1/$2';
$route['dcmSOFormSearchList_STD']                       = 'document/saleorder_statdose/cSaleOrder/FSvCSOFormSearchList';
$route['dcmSODataTable_STD']                            = 'document/saleorder_statdose/cSaleOrder/FSoCSODataTable';
$route['dcmSOPageAdd_STD']                              = 'document/saleorder_statdose/cSaleOrder/FSoCSOAddPage';
$route['dcmSOPageEdit_STD']                             = 'document/saleorder_statdose/cSaleOrder/FSoCSOEditPage';
$route['dcmSOPdtAdvanceTableLoadData_STD']              = 'document/saleorder_statdose/cSaleOrder/FSoCSOPdtAdvTblLoadData';
$route['dcmSOEventDelete_STD']                          = 'document/saleorder_statdose/cSaleOrder/FSoCSODeleteEventDoc';
$route['dcmSOAdvanceTableShowColList_STD']              = 'document/saleorder_statdose/cSaleOrder/FSoCSOAdvTblShowColList';
$route['dcmSOAdvanceTableShowColSave_STD']              = 'document/saleorder_statdose/cSaleOrder/FSoCSOAdvTalShowColSave';
$route['dcmSOAddPdtIntoDTDocTemp_STD']                  = 'document/saleorder_statdose/cSaleOrder/FSoCSOAddPdtIntoDocDTTemp';
$route['dcmSOEditPdtIntoDTDocTemp_STD']                  = 'document/saleorder_statdose/cSaleOrder/FSoCSOEditPdtIntoDocDTTemp';
$route['dcmSOChkHavePdtForDocDTTemp_STD']               = 'document/saleorder_statdose/cSaleOrder/FSoCSOChkHavePdtForDocDTTemp';
$route['dcmSOEventAdd_STD']                             = 'document/saleorder_statdose/cSaleOrder/FSoCSOAddEventDoc';
$route['dcmSOEventEdit_STD']                            = 'document/saleorder_statdose/cSaleOrder/FSoCSOEditEventDoc';
$route['dcmSORemovePdtInDTTmp_STD']                     = 'document/saleorder_statdose/cSaleOrder/FSvCSORemovePdtInDTTmp';
$route['dcmSORemovePdtInDTTmpMulti_STD']                = 'document/saleorder_statdose/cSaleOrder/FSvCSORemovePdtInDTTmpMulti';
$route['dcmSOCancelDocument_STD']                       = 'document/saleorder_statdose/cSaleOrder/FSvCSOCancelDocument';
$route['dcmSOApproveDocument_STD']                      = 'document/saleorder_statdose/cSaleOrder/FSvCSOApproveDocument';
$route['dcmSOUpdateReasoninDT_STD']                     = 'document/saleorder_statdose/cSaleOrder/FSoCSOUpdateReasonInDT';
$route['dcmSOGetReasoninDT_STD']                        = 'document/saleorder_statdose/cSaleOrder/FSxCSOGetReasonInDT';
$route['dcmSOInsertDTAndCN_STD']                        = 'document/saleorder_statdose/cSaleOrder/FSoCSOInsertDTAndCN';
$route['dcmSOPdtLoadTablePDT_STD']                      = 'document/saleorder_statdose/cSaleOrder/FSoCSOLoadTablePDT';
$route['dcmSOSerachAndAddPdtIntoTbl_STD']               = 'document/saleorder_statdose/cSaleOrder/FSoCSOSearchAndAddPdtIntoTbl';
$route['dcmSOClearDataDocTemp_STD']                     = 'document/saleorder_statdose/cSaleOrder/FSoCSOClearDataInDocTemp';
$route['dcmSODisChgHDList_STD']                         = 'document/saleorder_statdose/cSaleOrderDisChgModal/FSoCSODisChgHDList';
$route['dcmSODisChgDTList_STD']                         = 'document/saleorder_statdose/cSaleOrderDisChgModal/FSoCSODisChgDTList';
$route['dcmSOAddEditDTDis_STD']                         = 'document/saleorder_statdose/cSaleOrderDisChgModal/FSoCSOAddEditDTDis';
$route['dcmSOAddEditHDDis_STD']                         = 'document/saleorder_statdose/cSaleOrderDisChgModal/FSoCSOAddEditHDDis';
$route['dcmSOPageEditMonitor_STD']                      = 'document/saleorder_statdose/cSaleOrder/FSoCSOEditPageMonitor';
$route['dcmSOPdtAdvanceTableLoadDataMonitor_STD']       = 'document/saleorder_statdose/cSaleOrder/FSoCSOPdtAdvTblLoadDataMonitor';
$route['dcmSORejectDocument_STD']                       = 'document/saleorder_statdose/cSaleOrder/FSvCSORejectDocument';
$route['dcmCheckSO_STD/(:any)/(:any)']                  = 'document/checksaleorderapprove/cChkSaleOrderApprove/index/$1/$2';
$route['dcmCheckSOPageMain_STD']                        = 'document/checksaleorderapprove/cChkSaleOrderApprove/FSvCCHKSoCallPageMain';
$route['dcmSOMonitorGetMassge']                         = 'document/checksaleorderapprove/cChkSaleOrderApprove/FSvCCHKSoGetMassage';

//ใบเติมสินค้าชุด - ตู้สินค้า : Supawat(Wat) 19/10/2020
$route['docRVDRefillPDTVD/(:any)/(:any)']              = 'document/RefillProductVD/cRefillProductVD/index/$1/$2';
$route['docRVDRefillPDTVDPageList']                    = 'document/RefillProductVD/cRefillProductVD/FSvCRVDPageList';
$route['docRVDRefillPDTVDDataTable']                   = 'document/RefillProductVD/cRefillProductVD/FSvCRVDDatatable';
$route['docRVDRefillPDTVDDeleteDocument']              = 'document/RefillProductVD/cRefillProductVD/FSaCRVDDeleteDocument';
$route['docRVDRefillPDTVDPageAdd']                     = 'document/RefillProductVD/cRefillProductVD/FSvCRVDPageAdd';
$route['docRVDRefillPDTVDPageEdit']                    = 'document/RefillProductVD/cRefillProductVD/FSvCRVDPageEdit';
$route['docRVDRefillPDTVDEventAdd']                    = 'document/RefillProductVD/cRefillProductVD/FSxCRVDEventSave';
$route['docRVDRefillPDTVDEventEdit']                   = 'document/RefillProductVD/cRefillProductVD/FSxCRVDEventEdit';
$route['docRVDRefillPDTVDLoadTableStep1']              = 'document/RefillProductVD/cRefillProductVD/FSvCRVDLoadTableStep1';
$route['docRVDRefillPDTVDInsStep1']                    = 'document/RefillProductVD/cRefillProductVD/FSvCRVDInsStep1';
$route['docRVDRefillPDTVDDeleteStep1']                 = 'document/RefillProductVD/cRefillProductVD/FSxCRVDDeleteStep1';
$route['docRVDRefillPDTVDLoadTableStep2']              = 'document/RefillProductVD/cRefillProductVD/FSvCRVDLoadTableStep2';
$route['docRVDRefillPDTVDDeleteStep2']                 = 'document/RefillProductVD/cRefillProductVD/FSxCRVDDeleteStep2';
$route['docRVDRefillPDTVDShowProrate']                 = 'document/RefillProductVD/cRefillProductVD/FSxCRVDProrateStep2';
$route['docRVDRefillPDTVDStep2SaveInTemp']             = 'document/RefillProductVD/cRefillProductVD/FSxCRVDProrateSaveStep2InTemp';
$route['docRVDRefillPDTVDDeleteMultiStep2']            = 'document/RefillProductVD/cRefillProductVD/FSxCRVDDeleteMultiStep2';
$route['docRVDRefillPDTVDUpdateStep2']                 = 'document/RefillProductVD/cRefillProductVD/FSxCRVDUpdateStep2';
$route['docRVDRefillPDTVDLoadTableStep3']              = 'document/RefillProductVD/cRefillProductVD/FSvCRVDLoadTableStep3';
$route['docRVDRefillPDTVDLoadTableStep4']              = 'document/RefillProductVD/cRefillProductVD/FSvCRVDLoadTableStep4';
$route['docRVDRefillPDTCancelDocument']                = 'document/RefillProductVD/cRefillProductVD/FSxCRVDCancelDocument';
$route['docRVDRefillPDTApprovedDocument']              = 'document/RefillProductVD/cRefillProductVD/FSxCRVDApprovedDocument';
$route['docRVDRefillPDTCheckStockWhenApv']             = 'document/RefillProductVD/cRefillProductVD/FSxCRVDCheckStockWhenApv';

// ========================================= ใบคืนสินค้า (ตู้สินค้า) =========================================== //
$route['dcmRS/(:any)/(:any)']                       = 'document/returnsale/cReturnSale/index/$1/$2';
$route['dcmRSFormSearchList']                       = 'document/returnsale/cReturnSale/FSvCRSFormSearchList';
$route['dcmRSDataTable']                            = 'document/returnsale/cReturnSale/FSoCRSDataTable';
$route['dcmRSPageAdd']                              = 'document/returnsale/cReturnSale/FSoCRSAddPage';
$route['dcmRSPageEdit']                             = 'document/returnsale/cReturnSale/FSoCRSEditPage';
$route['dcmRSPdtAdvanceTableLoadData']              = 'document/returnsale/cReturnSale/FSoCRSPdtAdvTblLoadData';
$route['dcmRSVatTableLoadData']                     = 'document/returnsale/cReturnSale/FSoCRSVatLoadData';
$route['dcmRSCalculateLastBill']                    = 'document/returnsale/cReturnSale/FSoCRSCalculateLastBill';
$route['dcmRSEventDelete']                          = 'document/returnsale/cReturnSale/FSoCRSDeleteEventDoc';
$route['dcmRSAddPdtIntoDTDocTemp']                  = 'document/returnsale/cReturnSale/FSoCRSAddPdtIntoDocDTTemp';
$route['dcmRSEditPdtIntoDTDocTemp']                 = 'document/returnsale/cReturnSale/FSoCRSEditPdtIntoDocDTTemp';
$route['dcmRSChkHavePdtForDocDTTemp']               = 'document/returnsale/cReturnSale/FSoCRSChkHavePdtForDocDTTemp';
$route['dcmRSEventAdd']                             = 'document/returnsale/cReturnSale/FSoCRSAddEventDoc';
$route['dcmRSEventEdit']                            = 'document/returnsale/cReturnSale/FSoCRSEditEventDoc';
$route['dcmRSRemovePdtInDTTmp']                     = 'document/returnsale/cReturnSale/FSvCRSRemovePdtInDTTmp';
$route['dcmRSRemovePdtInDTTmpMulti']                = 'document/returnsale/cReturnSale/FSvCRSRemovePdtInDTTmpMulti';
$route['dcmRSCancelDocument']                       = 'document/returnsale/cReturnSale/FSvCRSCancelDocument';
$route['dcmRSApproveDocument']                      = 'document/returnsale/cReturnSale/FSvCRSApproveDocument';
$route['dcmRSSerachAndAddPdtIntoTbl']               = 'document/returnsale/cReturnSale/FSoCRSSearchAndAddPdtIntoTbl';
$route['dcmRSClearDataDocTemp']                     = 'document/returnsale/cReturnSale/FSoCRSClearDataInDocTemp';
$route['dcmRSFindBillSaleVDDocNo']                  = 'document/returnsale/cReturnSale/FSvCRSFindBillSaleVDDocNo';
$route['dcmRSFindBillSaleVDDetail']                 = 'document/returnsale/cReturnSale/FSvCRSFindBillSaleVDDetail';
$route['dcmRSDisChgHDList']                         = 'document/returnsale/cReturnSaleDisChgModal/FSoCRSDisChgHDList';
$route['dcmRSDisChgDTList']                         = 'document/returnsale/cReturnSaleDisChgModal/FSoCRSDisChgDTList';
$route['dcmRSAddEditDTDis']                         = 'document/returnsale/cReturnSaleDisChgModal/FSoCRSAddEditDTDis';
$route['dcmRSAddEditHDDis']                         = 'document/returnsale/cReturnSaleDisChgModal/FSoCRSAddEditHDDis';
$route['dcmRSPocessAddDisTmpCst']                   = 'document/returnsale/cReturnSaleDisChgModal/FSoCRSPocessAddDisTmpCst';
$route['dcmRSInsertBillToTemp']                     = 'document/returnsale/cReturnSale/FSoCRSInsertBillToTemp';
$route['dcmRSFindWahouseDefaultByShop']             = 'document/returnsale/cReturnSale/FSoCRSFindWahouseDefaultByShop';
$route['dcmRSQtyLimitRetunItem']                    = 'document/returnsale/cReturnSale/FSaCRSQtyLimitRetunItem';

// ========================================= ใบสั้งซื้อ 2021 - STD =========================================== //
$route['docPO/(:any)/(:any)']                       = 'document/purchaseorder/cPurchaseOrder/index/$1/$2';
$route['docPOFormSearchList']                       = 'document/purchaseorder/cPurchaseOrder/FSvCPOFormSearchList';
$route['docPODataTable']                            = 'document/purchaseorder/cPurchaseOrder/FSoCPODataTable';
$route['docPOPageAdd']                              = 'document/purchaseorder/cPurchaseOrder/FSoCPOAddPage';
$route['docPOPageEdit']                             = 'document/purchaseorder/cPurchaseOrder/FSoCPOEditPage';
$route['docPOPdtAdvanceTableLoadData']              = 'document/purchaseorder/cPurchaseOrder/FSoCPOPdtAdvTblLoadData';
$route['docPOVatTableLoadData']                     = 'document/purchaseorder/cPurchaseOrder/FSoCPOVatLoadData';
$route['docPOCalculateLastBill']                    = 'document/purchaseorder/cPurchaseOrder/FSoCPOCalculateLastBill';
$route['docPOEventDelete']                          = 'document/purchaseorder/cPurchaseOrder/FSoCPODeleteEventDoc';
$route['docPOAdvanceTableShowColList']              = 'document/purchaseorder/cPurchaseOrder/FSoCPOAdvTblShowColList';
$route['docPOAdvanceTableShowColSave']              = 'document/purchaseorder/cPurchaseOrder/FSoCPOAdvTalShowColSave';
$route['docPOAddPdtIntoDTDocTemp']                  = 'document/purchaseorder/cPurchaseOrder/FSoCPOAddPdtIntoDocDTTemp';
$route['docPOEditPdtIntoDTDocTemp']                 = 'document/purchaseorder/cPurchaseOrder/FSoCPOEditPdtIntoDocDTTemp';
$route['docPOChkHavePdtForDocDTTemp']               = 'document/purchaseorder/cPurchaseOrder/FSoCPOChkHavePdtForDocDTTemp';
$route['docPOEventAdd']                             = 'document/purchaseorder/cPurchaseOrder/FSoCPOAddEventDoc';
$route['docPOEventEdit']                            = 'document/purchaseorder/cPurchaseOrder/FSoCPOEditEventDoc';
$route['docPORemovePdtInDTTmp']                     = 'document/purchaseorder/cPurchaseOrder/FSvCPORemovePdtInDTTmp';
$route['docPORemovePdtInDTTmpMulti']                = 'document/purchaseorder/cPurchaseOrder/FSvCPORemovePdtInDTTmpMulti';
$route['docPOCancelDocument']                       = 'document/purchaseorder/cPurchaseOrder/FSvCPOCancelDocument';
$route['docPOApproveDocument']                      = 'document/purchaseorder/cPurchaseOrder/FSvCPOApproveDocument';
$route['docPOSerachAndAddPdtIntoTbl']               = 'document/purchaseorder/cPurchaseOrder/FSoCPOSearchAndAddPdtIntoTbl';
$route['docPOClearDataDocTemp']                     = 'document/purchaseorder/cPurchaseOrder/FSoCPOClearDataInDocTemp';
$route['docPODisChgHDList']                         = 'document/purchaseorder/cPurchaseOrderDisChgModal/FSoCPODisChgHDList';
$route['docPODisChgDTList']                         = 'document/purchaseorder/cPurchaseOrderDisChgModal/FSoCPODisChgDTList';
$route['docPOAddEditDTDis']                         = 'document/purchaseorder/cPurchaseOrderDisChgModal/FSoCPOAddEditDTDis';
$route['docPOAddEditHDDis']                         = 'document/purchaseorder/cPurchaseOrderDisChgModal/FSoCPOAddEditHDDis';
$route['docPOPocessAddDisTmpCst']                   = 'document/purchaseorder/cPurchaseOrderDisChgModal/FSoCPOPocessAddDisTmpCst';

// ========================================= ใบปรับราคาทุน =========================================== //
$route['docADCCost/(:any)/(:any)']                  = 'document/adjustmentcost/cAdjustmentcost/index/$1/$2';
$route['docADCDataTable']                           = 'document/adjustmentcost/cAdjustmentcost/FSoCASTDataTable';
$route['docADCFormSearchList']                      = 'document/adjustmentcost/cAdjustmentcost/FSvCADCFormSearchList';
$route['docADCPageAdd']                             = 'document/adjustmentcost/cAdjustmentcost/FSvCADCAddPage';
$route['docADCPageEdit']                            = 'document/adjustmentcost/cAdjustmentcost/FSvCADCEditPage';
$route['docADCGetPdtFromDoc']                       = 'document/adjustmentcost/cAdjustmentcost/FSoCADCGetPdtFromDoc';
$route['docADCGetPdtFromFilter']                    = 'document/adjustmentcost/cAdjustmentcost/FSoCADCGetPdtFromFilter';
$route['docADCGetPdtFromImportExcel']               = 'document/adjustmentcost/cAdjustmentcost/FSoCADCGetPdtFromImportExcel';
$route['docADCGetPdtFromDT']                        = 'document/adjustmentcost/cAdjustmentcost/FSoCADCGetPdtFromDT';
$route['docADCEventAdd']                            = 'document/adjustmentcost/cAdjustmentcost/FSoCADCEventAdd';
$route['docADCEventEdit']                           = 'document/adjustmentcost/cAdjustmentcost/FSoCADCEventEdit';
$route['docADCCancel']                              = 'document/adjustmentcost/cAdjustmentcost/FSoCADCCancel';
$route['docADCApproveDocument']                     = 'document/adjustmentcost/cAdjustmentcost/FSvCADCApproveDocument';
$route['docADCEventDelete']                         = 'document/adjustmentcost/cAdjustmentcost/FSoCADCDeleteEventDoc';
$route['docPOEventCallEndOfBill']                   = 'document/purchaseorder/cPurchaseOrder/FSaPOCallEndOfBillOnChaheVat';
$route['dcmPOChangeSPLAffectNewVAT']                = 'document/purchaseorder/cPurchaseOrder/FSoCPOChangeSPLAffectNewVAT';

// หน้าจอตรวจสอบสถานะใบขาย - Napat(Jame) 02/07/2021
// Check Status Sale (CSS)
$route['docCSS/(:any)/(:any)']                          = 'document/checkstatussale/Checkstatussale_controller/index/$1/$2';
$route['docCSSPageList']                                = 'document/checkstatussale/Checkstatussale_controller/FSvCCSSPageList';
$route['docCSSPageDataTable']                           = 'document/checkstatussale/Checkstatussale_controller/FSvCCSSPageDataTable';
$route['docCSSPageEdit']                                = 'document/checkstatussale/Checkstatussale_controller/FSvCCSSPageEdit';
$route['docCSSPagePdtDataTable']                        = 'document/checkstatussale/Checkstatussale_controller/FSvCCSSPageProductDataTable';
$route['docCSSEventGetDataPdtSN']                       = 'document/checkstatussale/Checkstatussale_controller/FSaCCSSEventGetDataPdtSN';
$route['docCSSEventUpdatePdtSNTmp']                     = 'document/checkstatussale/Checkstatussale_controller/FSaCCSSEventUpdatePdtSNTmp';
$route['docCSSEventMoveTmpToDT']                        = 'document/checkstatussale/Checkstatussale_controller/FSaCCSSEventMoveTmpToDT';
$route['docCSSEventApproved']                           = 'document/checkstatussale/Checkstatussale_controller/FSaCCSSEventApproved';
$route['docCSSPagePdtSN']                               = 'document/checkstatussale/Checkstatussale_controller/FSaCCSSPagePdtSN';
$route['docCSSEventGetConfigGenDocPack']                = 'document/checkstatussale/Checkstatussale_controller/FSoCCSSEventGetConfigGenDocPack';
$route['docCSSEventSaveConfigGenDocPack']               = 'document/checkstatussale/Checkstatussale_controller/FSoCCSSEventSaveConfigGenDocPack';
$route['docCSSEventGenDocPacking']                      = 'document/checkstatussale/Checkstatussale_controller/FSoCCSSEventGenDocPacking';
$route['docCSSEventGenDocDelivery']                     = 'document/checkstatussale/Checkstatussale_controller/FSoCCSSEventGenDocDelivery';




// ใบกำกับภาษีอย่างย่อ(ใบขาย/ใบคืน) - Napat(Jame) 13/07/2021
// Abbreviated Tax Invoice (Sales/Refund)
$route['docABB/(:any)/(:any)']                          = 'document/abbsalerefund/Abbsalerefund_controller/index/$1/$2';
$route['docABBPageList']                                = 'document/abbsalerefund/Abbsalerefund_controller/FSvCABBPageList';
$route['docABBPageDataTable']                           = 'document/abbsalerefund/Abbsalerefund_controller/FSvCABBPageDataTable';
$route['docABBPageEdit']                                = 'document/abbsalerefund/Abbsalerefund_controller/FSvCABBPageEdit';
$route['docABBPagePdtDataTable']                        = 'document/abbsalerefund/Abbsalerefund_controller/FSvCABBPageProductDataTable';
$route['docABBEventGetDataPdtSN']                       = 'document/abbsalerefund/Abbsalerefund_controller/FSaCABBEventGetDataPdtSN';
$route['docABBEventUpdatePdtSNTmp']                     = 'document/abbsalerefund/Abbsalerefund_controller/FSaCABBEventUpdatePdtSNTmp';
$route['docABBEventMoveTmpToDT']                        = 'document/abbsalerefund/Abbsalerefund_controller/FSaCABBEventMoveTmpToDT';
$route['docABBEventApproved']                           = 'document/abbsalerefund/Abbsalerefund_controller/FSaCABBEventApproved';
$route['docABBPagePdtSN']                               = 'document/abbsalerefund/Abbsalerefund_controller/FSaCABBPagePdtSN';

//========================================== ใบขอโอนสาขา (Transfer Request Branch) ======================================//
$route['docTRB/(:any)/(:any)']                      = 'document/transferrequestbranch/Transferrequestbranch_controller/index/$1/$2';
$route['docTRBFormSearchList']                      = 'document/transferrequestbranch/Transferrequestbranch_controller/FSvCTRBFormSearchList';
$route['docTRBDataTable']                           = 'document/transferrequestbranch/Transferrequestbranch_controller/FSoCTRBDataTable';
$route['docTRBPageAdd']                             = 'document/transferrequestbranch/Transferrequestbranch_controller/FSoCTRBPageAdd';
$route['docTRBPdtAdvanceTableLoadData']             = 'document/transferrequestbranch/Transferrequestbranch_controller/FSoCTRBPdtAdvTblLoadData';
$route['docTRBAddPdtIntoDTDocTemp']                 = 'document/transferrequestbranch/Transferrequestbranch_controller/FSoCTRBAddPdtIntoDocDTTemp';
$route['docTRBRemovePdtInDTTmp']                    = 'document/transferrequestbranch/Transferrequestbranch_controller/FSvCTRBRemovePdtInDTTmp';
$route['docTRBRemovePdtInDTTmpMulti']               = 'document/transferrequestbranch/Transferrequestbranch_controller/FSvCTRBRemovePdtInDTTmpMulti';
$route['docTRBEditPdtInDTDocTemp']                  = 'document/transferrequestbranch/Transferrequestbranch_controller/FSoCTRBEditPdtIntoDocDTTemp';
$route['docTRBChkHavePdtForDocDTTemp']              = 'document/transferrequestbranch/Transferrequestbranch_controller/FSoCTRBChkHavePdtForDocDTTemp';
$route['docTRBEventAdd']                            = 'document/transferrequestbranch/Transferrequestbranch_controller/FSoCTRBAddEventDoc';
$route['docTRBEventEdit']                           = 'document/transferrequestbranch/Transferrequestbranch_controller/FSoCTRBEditEventDoc';
$route['docTRBPageEdit']                            = 'document/transferrequestbranch/Transferrequestbranch_controller/FSvCTRBEditPage';
$route['docTRBCallRefIntDoc']                       = 'document/transferrequestbranch/Transferrequestbranch_controller/FSoCTRBCallRefIntDoc';
$route['docTRBCallRefIntDocDataTable']              = 'document/transferrequestbranch/Transferrequestbranch_controller/FSoCTRBCallRefIntDocDataTable';
$route['docTRBCallRefIntDocDetailDataTable']        = 'document/transferrequestbranch/Transferrequestbranch_controller/FSoCTRBCallRefIntDocDetailDataTable';
$route['docTRBCallRefIntDocInsertDTToTemp']         = 'document/transferrequestbranch/Transferrequestbranch_controller/FSoCTRBCallRefIntDocInsertDTToTemp';
$route['docTRBEventDelete']                         = 'document/transferrequestbranch/Transferrequestbranch_controller/FSoCTRBDeleteEventDoc';
$route['docTRBCancelDocument']                      = 'document/transferrequestbranch/Transferrequestbranch_controller/FSvCTRBCancelDocument';
$route['docTRBApproveDocument']                     = 'document/transferrequestbranch/Transferrequestbranch_controller/FSoCTRBApproveEvent';
$route['docTRBPageHDDocRef']                        = 'document/transferrequestbranch/Transferrequestbranch_controller/FSoCTRBPageHDDocRef';


// ใบจัด
$route['docPAM/(:any)/(:any)']                       = 'document/productarrangement/productarrangement_controller/index/$1/$2';
$route['docPAMFormSearchList']                       = 'document/productarrangement/productarrangement_controller/FSvCPAMFormSearchList';
$route['docPAMDataTable']                            = 'document/productarrangement/productarrangement_controller/FSoCPAMDataTable';
$route['docPAMPageAdd']                              = 'document/productarrangement/productarrangement_controller/FSoCPAMPageAdd';
$route['docPAMPdtAdvanceTableLoadData']              = 'document/productarrangement/productarrangement_controller/FSoCPAMPdtAdvTblLoadData';
$route['docPAMAddPdtIntoDTDocTemp']                  = 'document/productarrangement/productarrangement_controller/FSoCPAMAddPdtIntoDocDTTemp';
$route['docPAMRemovePdtInDTTmp']                     = 'document/productarrangement/productarrangement_controller/FSvCPAMRemovePdtInDTTmp';
$route['docPAMRemovePdtInDTTmpMulti']                = 'document/productarrangement/productarrangement_controller/FSvCPAMRemovePdtInDTTmpMulti';
$route['docPAMEditPdtInDTDocTemp']                   = 'document/productarrangement/productarrangement_controller/FSoCPAMEditPdtIntoDocDTTemp';
$route['docPAMChkHavePdtForDocDTTemp']               = 'document/productarrangement/productarrangement_controller/FSoCPAMChkHavePdtForDocDTTemp';
$route['docPAMEventAdd']                             = 'document/productarrangement/productarrangement_controller/FSoCPAMAddEventDoc';
$route['docPAMEventEdit']                            = 'document/productarrangement/productarrangement_controller/FSoCPAMEditEventDoc';
$route['docPAMPageEdit']                             = 'document/productarrangement/productarrangement_controller/FSvCPAMEditPage';
$route['docPAMEventDelete']                          = 'document/productarrangement/productarrangement_controller/FSoCPAMDeleteEventDoc';
$route['docPAMCancelDocument']                       = 'document/productarrangement/productarrangement_controller/FSvCPAMCancelDocument';
$route['docPAMApproveDocument']                      = 'document/productarrangement/productarrangement_controller/FSoCPAMApproveEvent';
$route['docPAMPagePdtSN']                            = 'document/productarrangement/productarrangement_controller/FSvCPAMPagePdtSN';
$route['docPAMEventAddPdtSN']                        = 'document/productarrangement/productarrangement_controller/FSoCPAMEventAddPdtSN';
$route['docPAMEventDeletePdtSN']                     = 'document/productarrangement/productarrangement_controller/FSoCPAMEventDeletePdtSN';
$route['docPAMCallRefIntDoc']                        = 'document/productarrangement/productarrangement_controller/FSoCPAMCallRefIntDoc';
$route['docPAMCallRefIntDocDataTable']               = 'document/productarrangement/productarrangement_controller/FSoCPAMCallRefIntDocDataTable';
$route['docPAMCallRefIntDocDetailDataTable']         = 'document/productarrangement/productarrangement_controller/FSoCPAMCallRefIntDocDetailDataTable';
$route['docPAMCallRefIntDocInsertDTToTemp']          = 'document/productarrangement/productarrangement_controller/FSoCPAMCallRefIntDocInsertDTToTemp';
$route['docPAMPageHDDocRefList']                     = 'document/productarrangement/productarrangement_controller/FSoCPAMPageHDDocRefList';
$route['docPAMEventUpdateDoc']                       = 'document/productarrangement/productarrangement_controller/FSoCPAMEventUpdateDoc';

// ตรวจสอบคูปอง/บัตรกำนัล
$route['docManageCoupon/(:any)/(:any)']              = 'document/managecoupon/managecoupon_controller/index/$1/$2';
$route['docManageCouponFormSearchList']              = 'document/managecoupon/managecoupon_controller/FSvCMCPFormSearchList';
$route['docManageCouponPageDataTable']               = 'document/managecoupon/managecoupon_controller/FSoCMCPPageDataTable';
$route['docManageCouponPageViewDetails']             = 'document/managecoupon/managecoupon_controller/FSoCMCPPageViewDetails';
$route['docManageCouponAdjustStatus']                = 'document/managecoupon/managecoupon_controller/FSoCMCPEventAdjustStatus';
