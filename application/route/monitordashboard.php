<?php defined ('BASEPATH') or exit ( 'No direct script access allowed' );

// Pos 
$route ['posSaleInforDashboard']            = 'monitordashboard/pos/cPosSaleInfor/index';
$route ['posSaleInforChart']                = 'monitordashboard/pos/cPosSaleInfor/FSxCDisplaySaleChartInfor';
$route ['posSaleInforGetInfor']             = 'monitordashboard/pos/cPosSaleInfor/FSxCGetInforDashBoard';
$route ['posSaleInforAddInforByMQ']         = 'monitordashboard/pos/cPosSaleInfor/FSxCAddInforByMQ';
$route ['posSaleInforLoadPdtBestSale']      = 'monitordashboard/pos/cPosSaleInfor/FSxCLoadPdtBestSale';

// Vd
$route ['VdSaleInforDashboard']             = 'monitordashboard/vending/cVdSaleInfor/index';
$route ['VdSaleInforChart']                 = 'monitordashboard/vending/cVdSaleInfor/FSxCDisplaySaleChartInfor';
$route ['VdSaleInforGetInfor']              = 'monitordashboard/vending/cVdSaleInfor/FSxCGetInforDashBoard';
$route ['VdSaleInforAddInforByMQ']          = 'monitordashboard/vending/cVdSaleInfor/FSxCAddInforByMQ';
$route ['VdSaleInforLoadPdtBestSale']       = 'monitordashboard/vending/cVdSaleInfor/FSxCLoadPdtBestSale';
$route ['VdSaleInforLoadHistoryPosSale']    = 'monitordashboard/vending/cVdSaleInfor/FSxCLoadHistoryPosSale';
$route ['VdSaleInforGetMerChant']           = 'monitordashboard/vending/cVdSaleInfor/FSxCGetMerChantInfor';
$route ['VdSaleInforGetShop']               = 'monitordashboard/vending/cVdSaleInfor/FSxCGetShopInfor';
$route ['VdSaleInforVDDetail']              = 'monitordashboard/vending/cVdSaleInfor/FSxCVDDetail';
$route ['VdSaleInforGetHistoryPosSale']     = 'monitordashboard/vending/cVdSaleInfor/FSxCGetHistoryPosSale';

// Locker
$route ['lockerInforDashboard']             = 'monitordashboard/locker/cLockerInfor/index';
$route ['lockerInforGetDataLockerStatus']   = 'monitordashboard/locker/cLockerInfor/FSoCDLKDataLockerStatus';