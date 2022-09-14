<?php
//defined ('BASEPATH') or exit ('No direct script access allowed');

//ตรวจสอบสถานะเอกสารโอน
$route['monSDT/(:any)/(:any)']  = 'monitor/chkstadoctransfer/chkstadoctransfer_controller/index/$1/$2';
$route['monSDTList']            = 'monitor/chkstadoctransfer/chkstadoctransfer_controller/FSvCSDTListPage';
$route['monSDTGetSplBuyList']   = 'monitor/chkstadoctransfer/chkstadoctransfer_controller/FSvCSDTGetSplBuyList';
$route['monSDTExportExcel']     = 'monitor/chkstadoctransfer/chkstadoctransfer_controller/FSvCSDTExportExcel';

//ตรวจสอบใบส่งของ/รับของ
$route['monDO/(:any)/(:any)']   = 'monitor/deliveryorder/deliveryorder_controller/index/$1/$2';
$route['docDOFormSearchList']   = 'monitor/deliveryorder/deliveryorder_controller/FSvCDOFormSearchList';
$route['monDODataTable']        = 'monitor/deliveryorder/deliveryorder_controller/FSvCDODataTable';
$route['monDOApvDocMulti']      = 'monitor/deliveryorder/deliveryorder_controller/FSvCDOApvDocMulti';
$route['monDOExportExcel']                          = 'monitor/deliveryorder/deliveryorder_controller/FSvCDOExportExcel';
$route['monDOPageEdit']                             = 'monitor/deliveryorder/deliveryorder_controller/FSvCDOEditPage';
$route['monDOPdtAdvanceTableLoadData']              = 'monitor/deliveryorder/deliveryorder_controller/FSoCDOPdtAdvTblLoadData';
$route['monDOPageHDDocRefList']                     = 'monitor/deliveryorder/deliveryorder_controller/FSoCDOPageHDDocRefList';

$route['monDOChkHavePdtForDocDTTemp']               = 'monitor/deliveryorder/deliveryorder_controller/FSoCDOChkHavePdtForDocDTTemp';
$route['monDOEventEdit']                            = 'monitor/deliveryorder/deliveryorder_controller/FSoCDOEditEventDoc';
$route['monDOApproveDocument']                      = 'monitor/deliveryorder/deliveryorder_controller/FSoCDOApproveEvent';
$route['monDOCancelDocument']                       = 'monitor/deliveryorder/deliveryorder_controller/FSoCDOCancelDocument';









?>
