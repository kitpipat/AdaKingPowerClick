<?php

//Vending Shop Layout , (รูปแบบตู้สินค้า)
$route ['VendingShopLayout/(:any)/(:any)']     = 'vending/vendingshoplayout/cVendingshoplayout/index/$1/$2';
$route ['VendingShopLayoutList']               = 'vending/vendingshoplayout/cVendingshoplayout/FSvVSLListPage';
$route ['VendingShopLayoutDataTable']          = 'vending/vendingshoplayout/cVendingshoplayout/FSvVSLDataList';
$route ['VendingShopLayoutPageAdd']            = 'vending/vendingshoplayout/cVendingshoplayout/FSvVSLAddPage';
$route ['VendingShopLayoutEventAdd']           = 'vending/vendingshoplayout/cVendingshoplayout/FSaVSLAddEvent';
$route ['VendingShopLayoutPageEdit']           = 'vending/vendingshoplayout/cVendingshoplayout/FSvVSLEditPage';
$route ['VendingShopLayoutEventEdit']          = 'vending/vendingshoplayout/cVendingshoplayout/FSaVSLEditEvent';
$route ['VendingShopLayoutEventDelete']        = 'vending/vendingshoplayout/cVendingshoplayout/FSaVSLDeleteEvent';	
$route ['VendingShopLayoutEventDeleteColandUpdate'] = 'vending/vendingshoplayout/cVendingshoplayout/FSaVSLEditEventandDeleteCol';


//manage product
$route ['VendingmanagePageAdd']             = 'vending/vendingshoplayout/cVendingmanage/FSaVSLManagePageADD';	
$route ['VendingmanageEventAdd']            = 'vending/vendingshoplayout/cVendingmanage/FSaVSLManageEventADD';	

//Vending Shop Layout , (รูปแบบตู้สินค้า) NewUI 9 ตุลา 2019
$route ['VendingLayout']                        = 'vending/vendinglayout/cVendinglayout/index';
$route ['VendingLayoutList']                    = 'vending/vendinglayout/cVendinglayout/FSvVEDListPage';
$route ['VendingLayoutInsertSetting']           = 'vending/vendinglayout/cVendinglayout/FSvVEDInsertSetting';
$route ['VendingLayoutSelectSetting']           = 'vending/vendinglayout/cVendinglayout/FSvVEDSelectSetting';
$route ['VendingLayoutInsertDiagram']           = 'vending/vendinglayout/cVendinglayout/FSxVEDInsertDiagram';
$route ['VendingLayoutExport']                  = 'vending/vendinglayout/cVendinglayout/FSxVEDExportDiagram';
$route ['VendingLayoutImport']                  = 'vending/vendinglayout/cVendinglayout/FSxVEDImportDiagram';
$route ['VendingLayoutImportCheckPDT']          = 'vending/vendinglayout/cVendinglayout/FSxVEDImportCheckPDT';
$route ['VendingLayoutCheckDocumentWhenNotApv'] = 'vending/vendinglayout/cVendinglayout/FSxVEDCheckDocumentWhenNotApv';

////////////////////////////////////////////////////////////// แก้ไข้ใหม่ STAT DOSE 17/01/2020

//ชั้นตู้ Cabinet 
$route ['VendingCabinet']                   = 'vending/Cabinet/cCabinet/FSvCVDCMain';
$route ['VendingCabinetPageAdd']            = 'vending/Cabinet/cCabinet/FSvCVDCPageAdd';
$route ['VendingCabinetList']               = 'vending/Cabinet/cCabinet/FSvCVDCListPage';
$route ['VendingCabinetDataTable']          = 'vending/Cabinet/cCabinet/FSvVSTDataList';
$route ['VendingCabinetEventAdd']           = 'vending/Cabinet/cCabinet/FSaVSTAddEvent';
$route ['VendingCabinetPageEdit']           = 'vending/Cabinet/cCabinet/FSvVSTEditPage';
$route ['VendingCabinetEventEdit']          = 'vending/Cabinet/cCabinet/FSaVSTEditEvent';
$route ['VendingCabinetEventDelete']        = 'vending/Cabinet/cCabinet/FSaVSTDeleteEvent';	


//Vending Shop Type , (ประเภทตู้สินค้า)
$route ['VendingShopType/(:any)/(:any)']     = 'vending/vendingshoptype/cVendingshoptype/index/$1/$2';
$route ['VendingShopTypeList']               = 'vending/vendingshoptype/cVendingshoptype/FSvVSTListPage';
$route ['VendingShopTypeDataTable']          = 'vending/vendingshoptype/cVendingshoptype/FSvVSTDataList';
$route ['VendingShopTypePageAdd']            = 'vending/vendingshoptype/cVendingshoptype/FSvVSTAddPage';
$route ['VendingShopTypeEventAdd']           = 'vending/vendingshoptype/cVendingshoptype/FSaVSTAddEvent';
$route ['VendingShopTypePageEdit']           = 'vending/vendingshoptype/cVendingshoptype/FSvVSTEditPage';
$route ['VendingShopTypeEventEdit']          = 'vending/vendingshoptype/cVendingshoptype/FSaVSTEditEvent';
$route ['VendingShopTypeEventDelete']        = 'vending/vendingshoptype/cVendingshoptype/FSaVSTDeleteEvent';	


//Shop Layout
$route ['VendingGetDTShopLayout']            = 'vending/vendinglayout/cVendinglayout/FSxVEDGetPDTShopLayout';
$route ['VendingDeleteDiagram']              = 'vending/vendinglayout/cVendinglayout/FSxVEDDeleteDiagram';


/* Create By Witsarut 26/02/2020
    Master ประเภทตู้สินค้า
*/
$route ['CabinetType/(:any)/(:any)']     = 'vending/cabinettype/CcabinetType/index/$1/$2';
$route ['CabinetTypeList']               = 'vending/cabinettype/CcabinetType/FSvCCBNListPage';
$route ['CabinetTypeDataTable']          = 'vending/cabinettype/CcabinetType/FSvCCBNDataList';
$route ['CabinetTypePageAdd']            = 'vending/cabinettype/CcabinetType/FSvCCBNAddPage';
$route ['CabinetTypePageEdit']           = 'vending/cabinettype/CcabinetType/FSvCCBNEditPage';
$route ['CabinetTypeEventAdd']           = 'vending/cabinettype/CcabinetType/FSoCCBNAddEvent';
$route ['CabinetTypeEventEdit']          = 'vending/cabinettype/CcabinetType/FSoCCBNEditEvent';
$route ['CabinetTypeEventDelete']        = 'vending/cabinettype/CcabinetType/FSoCCBNDeleteEvent';
$route ['CabinetTypeEventDeleteMultiple']  = 'vending/cabinettype/CcabinetType/FSoCCBNDelMultipleEvent';

