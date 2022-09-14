<?php

    // Company  (บริษัท)
    $route ['company/(:any)/(:any)']        = 'company/company/cCompany/index/$1/$2';
    $route ['companyCheckUserLevel']        = 'company/company/cCompany/FSvCheckUserLevel';
    $route ['companyList']          	    = 'company/company/cCompany/FSoCCMPListPage';
    $route ['companyPageEdit']		        = 'company/company/cCompany/FSoCCMPEditPage';
    $route ['companyEventAdd']              = 'company/company/cCompany/FSoCMPAddEvent';
    $route ['companyEventEdit']		        = 'company/company/cCompany/FSoCMPEditEvent';
    $route ['companyEventAddVat']           = 'company/company/cCompany/FSaCMPAddVat';
    $route ['companyEventCallAddress']      = 'company/company/cCompany/FSoCMPCallAddress';
    $route ['companyEventGetName']          = 'company/company/cCompany/FSvCMPGetName';

    // Branch (สาขา)
    $route ['branch/(:any)/(:any)']         = 'company/branch/cBranch/index/$1/$2';
    $route ['branchList']                   = 'company/branch/cBranch/FSvCBCHListPage';
    $route ['branchDataTable']              = 'company/branch/cBranch/FSvCBCHDataList';
    $route ['branchPageAdd']                = 'company/branch/cBranch/FSvCBCHAddPage';
    $route ['branchEventAdd']               = 'company/branch/cBranch/FSaCBCHAddEvent';
    $route ['branchPageEdit']               = 'company/branch/cBranch/FSvCBCHEditPage';
    $route ['branchEventEdit']              = 'company/branch/cBranch/FSaCBCHEditEvent';
    $route ['branchEventDelete']            = 'company/branch/cBranch/FSaCBCHDeleteEvent';
    $route ['branchCheckUserLevel']         = 'company/branch/cBranch/FSvCBCHCheckUserLevel';
    $route ['branchEventDeleteFolder']      = 'company/branch/cBranch/FSaCBCHDeleteEventFolder';
    $route ['branchBrowseWareHouse']        = 'company/branch/cBranch/FSoCBCHCallWareHouse';
    $route ['branchCallCstProfile']         = 'company/branch/cBranch/FSoCBCHCalCstProfile';

    //  Branch Import
    $route ['branchPageImportDataTable']    = 'company/branch/cBranch/FSaCBCHImportDataTable';
    $route ['branchEventImportDelete']      = 'company/branch/cBranch/FSaCBCHImportDelete';
    $route ['branchEventImportMove2Master'] = 'company/branch/cBranch/FSaCBCHImportMove2Master';
    $route ['branchGetDataImport']          = 'company/branch/cBranch/FSaCBCHGetDataImport';
    $route ['branchGetItemAllImport']       = 'company/branch/cBranch/FSaCBCHImportGetItemAll';


    // Branch Address
    $route ['branchAddressData']            = 'company/branch/cBranchAddress/FSvCBCHAddressData';
    $route ['branchAddressDataTable']       = 'company/branch/cBranchAddress/FSvCBCHAddressDataTable';
    $route ['branchAddressPageAdd']         = 'company/branch/cBranchAddress/FSvCBCHAddressCallPageAdd';
    $route ['branchAddressPageEdit']        = 'company/branch/cBranchAddress/FSvCBCHAddressCallPageEdit';
    $route ['branchAddressAddEvent']        = 'company/branch/cBranchAddress/FSoCBCHAddressAddEvent';
    $route ['branchAddressEditEvent']       = 'company/branch/cBranchAddress/FSoCBCHAddressEditEvent';
    $route ['branchAddressDeleteEvent']     = 'company/branch/cBranchAddress/FSoCBCHAddressDeleteEvent';

    // Shop (ร้านค้า)
    $route ['shop/(:any)/(:any)/(:any)']    = 'company/shop/cShop/index/$1/$2/$3';
    $route ['shopList']                     = 'company/shop/cShop/FSvCSHPListPage';
    $route ['shopDataTable']                = 'company/shop/cShop/FSvCSHPDataList';
    $route ['shopListFromBch']              = 'company/shop/cShop/FSvCSHPListPageFromBch'; /*From Branch*/
    $route ['branchToShopDataTable']        = 'company/shop/cShop/FSvCSHPBranchToShopDataList'; /*From Branch*/
    $route ['shopPageAdd']                  = 'company/shop/cShop/FSvCSHPAddPage';
    $route ['shopEventAdd']                 = 'company/shop/cShop/FSaCSHPAddEvent';
    $route ['shopPageEdit']                 = 'company/shop/cShop/FSvCSHPEditPage';
    $route ['shopEventEdit']                = 'company/shop/cShop/FSaCSHPEditEvent';
    $route ['shopEventDelete']              = 'company/shop/cShop/FSaCSHPDeleteEvent';
    $route ['shopChkTypeGPInDB']            = 'company/shop/cShop/FSaCSHPChkTypeGPInDB';
    $route ['ShptEventAdd']                 = 'company/shop/cShop/FSaCSHPCallLocTypeEvenAdd';
    $route ['ShptEventEdit']                = 'company/shop/cShop/FSaCSHPCallLocTypeEvenEdit';

    // Shop Address
    $route ['shopAddressData']          = 'company/shop/cShopAddress/FSvCSHPAddressData';
    $route ['shopAddressDataTable']     = 'company/shop/cShopAddress/FSvCSHPAddressDataTable';
    $route ['shopAddressPageAdd']       = 'company/shop/cShopAddress/FSvCSHPAddressCallPageAdd';
    $route ['shopAddressPageEdit']      = 'company/shop/cShopAddress/FSvCSHPAddressCallPageEdit';
    $route ['shopAddressAddEvent']      = 'company/shop/cShopAddress/FSoCSHPAddressAddEvent';
    $route ['shopAddressEditEvent']     = 'company/shop/cShopAddress/FSoCSHPAddressEditEvent';
    $route ['shopAddressDeleteEvent']   = 'company/shop/cShopAddress/FSoCSHPAddressDeleteEvent';

    // Vat Rate (ภาษีมูลค่าเพิ่ม)
    $route['VatRate']                       = 'company/vatrate/cVateRate/FCNaCVATList';
    $route['vatrate/(:any)/(:any)']         = 'company/vatrate/cVatrate/index/$1/$2';
    $route['vatrateList']                   = 'company/vatrate/cVatrate/FSvVATListPage';
    $route['vatrateDataTable']              = 'company/vatrate/cVatrate/FSvVATDataList';
    $route['vatratePageAdd']                = 'company/vatrate/cVatrate/FSvVATAddPage';
    $route['vatratePageEdit']               = 'company/vatrate/cVatrate/FSvVATEditPage';
    $route['vatrateEventAdd']               = 'company/vatrate/cVatrate/FSoVATAddEvent';
    $route['vatrateEventEdit']              = 'company/vatrate/cVatrate/FSoVATEditEvent';
    $route['vatrateEventDelete']            = 'company/vatrate/cVatrate/FSoVATDeleteEvent';
    $route['vatrateChkDup']                 = 'company/vatrate/cVatrate/FSoVATChackDup';
    $route['vatrateDeleteMulti']            = 'company/vatrate/cVatrate/FSoVATDeleteMultiVat';
    $route['vatrateDelete']                 = 'company/vatrate/cVatrate/FSoVATDelete';
    $route['vatrateCreateOrUpdate']         = 'company/vatrate/cVatrate/FSxVATCreateOrUpdate';
    $route['vatrateUniqueValidate/(:any)']  = 'company/vatrate/cVatrate/FStVATUniqueValidate/$1';

    //Warehouse (คลังสินค้า)
    $route ['warehouse/(:any)/(:any)']      = 'company/warehouse/cWarehouse/index/$1/$2';
    $route ['warehouseCheckUserLevel']      = 'company/warehouse/cWarehouse/FSvCWAHCheckUserLevel';
    $route ['warehouseList']                = 'company/warehouse/cWarehouse/FSvCWAHListPage';
    $route ['warehouseDataTable']           = 'company/warehouse/cWarehouse/FSvCWAHDataList';
    $route ['warehousePageAdd']             = 'company/warehouse/cWarehouse/FSvCWAHAddPage'; 
    $route ['warehouseEventAdd']            = 'company/warehouse/cWarehouse/FSaCWAHAddEvent';
    $route ['warehousePageEdit']            = 'company/warehouse/cWarehouse/FSvCWAHEditPage';
    $route ['warehouseEventEdit']           = 'company/warehouse/cWarehouse/FSaCWAHEditEvent';
    $route ['warehouseEventDelete']         = 'company/warehouse/cWarehouse/FSaCWAHDeleteEvent';

    // GP By Product
    $route ['CmpShopGpByProductMain']               = 'company/shopgpbypdt/cShopGpByPdt/FSvCShopGpByPdtMainPage';
    $route ['CmpShopGpByProductDataTable']          = 'company/shopgpbypdt/cShopGpByPdt/FSvCShopGpByPdtDataList';
    $route ['CmpShopGpByProductPageAdd']            = 'company/shopgpbypdt/cShopGpByPdt/FSvCShopGpByPdtPageAdd';
    $route ['CmpShopGpByProductPageEdit']           = 'company/shopgpbypdt/cShopGpByPdt/FSvCShopGpByPdtPageEdit';
    $route ['CmpShopGpByProductTableInsertProduct'] = 'company/shopgpbypdt/cShopGpByPdt/FSvCShopGpByPdtTableInsertProduct';
    $route ['CmpShopGpByProductEventInsert']        = 'company/shopgpbypdt/cShopGpByPdt/FSvCShopGpByPdtEventInsertProduct';
    $route ['CmpShopGpByProductTableEditProduct']   = 'company/shopgpbypdt/cShopGpByPdt/FSvCShopGpByPdtTableEditProduct';
    $route ['CmpShopGpByProductEventEdit']          = 'company/shopgpbypdt/cShopGpByPdt/FSvCShopGpByPdtEventEditProduct';
    $route ['CmpShopGpByProductEventDeletelist']    = 'company/shopgpbypdt/cShopGpByPdt/FSvCShopGpByPdtEventDeleteList';
    $route ['CmpShopGpByProductEventInsertGPToTemp']= 'company/shopgpbypdt/cShopGpByPdt/FSvCShopGpByPdtEventInsertGPToTemp';
    $route ['CmpShopGpByProductEventDeleteMutirecord']= 'company/shopgpbypdt/cShopGpByPdt/FSvCShopGpByPdtEventDeleteMutirecord';

    // GP By Shop
    $route ['CmpShopGpByShpMain']                = 'company/shopgpbyshp/cShopGpByShp/FSvCShopGpByShpMainPage';
    $route ['CmpShopGpByShpDataTable']           = 'company/shopgpbyshp/cShopGpByShp/FSvCShopGpByShpDataList';
    $route ['CmpShopGpByShpEventAdd']            = 'company/shopgpbyshp/cShopGpByShp/FSvCShopGpByShpAdd';
    $route ['CmpShopGpByShppageAdd']             = 'company/shopgpbyshp/cShopGpByShp/FSvCShopGpByShpPageAdd';
    $route ['CmpShopGpByShpEventDelete']         = 'company/shopgpbyshp/cShopGpByShp/FSvCShopGpByShpDel';
    $route ['CmpShopGpByShpEditinLinePageShop']  = 'company/shopgpbyshp/cShopGpByShp/FSvCShopGpByEditinLinePageShop';
    $route ['CmpShopGpByShpGPAdd']               = 'company/shopgpbyshp/cShopGpByShp/FSvCShopGpByShpAdd';
    $route ['CmpShopGpByShpPageEdit']            = 'company/shopgpbyshp/cShopGpByShp/FSvCSHPEditPage';
    $route ['CmpShopGpByShpGPEventEdit']         = 'company/shopgpbyshp/cShopGpByShp/FSvCShopGpByShpEdit';
    $route ['CmpShopGpByShopEventcheckData']     = 'company/shopgpbyshp/cShopGpByShp/FSvCShopGpByShpEventCheckData';
    $route ['CmpShopGpByShopEventInsertData']     = 'company/shopgpbyshp/cShopGpByShp/FSvCShopGpByShpEventInsertGP';
    
    //Smart Locker Type
    $route ['LocTypeData']                          = 'company/smartlockerType/cSmartlockerType/FSaCSHPCallLocTypeMainPage';
    $route ['LocTypeDataTable']                     = 'company/smartlockerType/cSmartlockerType/FSaCSHPCallLocTypeDataList';
    $route ['LocTypeDataAddOrEdit']                 = 'company/smartlockerType/cSmartlockerType/FSaCSHPCallLocTypeAddEdit';
    $route ['LocTypeEventAdd']                      = 'company/smartlockerType/cSmartlockerType/FSaCSHPEventInsert';
    $route ['LocTypeEventEdit']                     = 'company/smartlockerType/cSmartlockerType/FSaCSHPEventEdit';
    $route ['LocTypeEventDelete']                   = 'company/smartlockerType/cSmartlockerType/FSaCSHPEventDelete';


    //Smart Locker layout
    $route ['SHPSmartLockerLayoutMain']             = 'company/smartlockerlayout/cSmartlockerlayout/FSvCSMLMainPage';
    $route ['SHPSmartLockerLayoutDataTable']        = 'company/smartlockerlayout/cSmartlockerlayout/FSvCSMLDataList';
    $route ['SHPSmartLockerLayoutInsert']           = 'company/smartlockerlayout/cSmartlockerlayout/FSvCSMLInsert';
    $route ['SHPSmartLockerLayoutDelete']           = 'company/smartlockerlayout/cSmartlockerlayout/FSvCSMLDelete';
    $route ['SHPSmartLockerLayoutDeleteMutirecord'] = 'company/smartlockerlayout/cSmartlockerlayout/FSvCSMLDeleteMutirecord';
    $route ['SHPSmartLockerLayoutEdit']             = 'company/smartlockerlayout/cSmartlockerlayout/FSvCSMLEdit';
    $route ['SHPSmartLockerLayoutGetSearch']        = 'company/smartlockerlayout/cSmartlockerlayout/FSvCSMLGetSearch';
   
    //Rack
    $route ['rack/(:any)/(:any)']       = 'company/rack/cRack/index/$1/$2';
    $route ['rackList']                 = 'company/rack/cRack/FSvCRckListPage';
    $route ['rackDataTable']            = 'company/rack/cRack/FSvCRckDataList';
    $route ['rackEventAdd']             = 'company/rack/cRack/FSaRacAddEvent';
    $route ['rackPageAdd']              = 'company/rack/cRack/FSvRackAddPage';
    $route ['rackPageEdit']             = 'company/rack/cRack/FSvCRackEditPage';
    $route ['rackEventEdit']            = 'company/rack/cRack/FSaCRCKEditEvent';
    $route ['rackEventDelete']          = 'company/rack/cRack/FSaCRCKDeleteEvent';	

    //Tab Rack
    $route ['SHPSmartLockerrack']          = 'company/rack/cRack/FSvCSMSmartlockerRackMainPage';
    $route ['SHPSmartLockerrackList']      = 'company/rack/cRack/FSvCSmartlockerRackListPage';
    $route ['SHPSmartLockerrackPageAdd']   = 'company/rack/cRack/FSvCSMSPageAdd';
    $route ['SHPSmartLockerEventAdd']      = 'company/rack/cRack/FSaRacAddEvent';
    $route ['SHPSmartLockerEventPageEdit'] = 'company/rack/cRack/FSvCTabRackEditPage';
    $route ['SHPSmartLockerEventEdit']     = 'company/rack/cRack/FSaCRCKEditEvent';

        
    //Shop Size
    $route ['SHPSmartLockerSize']                   = 'company/smartlockerSize/cSmartlockerSize/FSvCSMSmartlockerSizeMainPage';
    $route ['SHPSmartLockerSizeDataTable']          = 'company/smartlockerSize/cSmartlockerSize/FSvCMSDataList';
    $route ['SHPSmartLockerSizePageAdd']            = 'company/smartlockerSize/cSmartlockerSize/FSvCSMSPageAdd';
    $route ['SHPSmartLockerSizeEventAdd']           = 'company/smartlockerSize/cSmartlockerSize/FSaCSMSAddEvent';
    $route ['SHPSmartLockerSizePageEdit']           = 'company/smartlockerSize/cSmartlockerSize/FSvCSMSPageEdit';
    $route ['SHPSmartLockerSizeEventEdit']          = 'company/smartlockerSize/cSmartlockerSize/FSaCSMSEditEvent';
    $route ['SHPSmartLockerSizeEventDelete']        = 'company/smartlockerSize/cSmartlockerSize/FSaCSMSDeleteEvent';
    

    //Shop Post
    $route ['PSHSmartLockerShopPosCallPageSetting']        = 'pos/posshop/cPosShop/FSvCPSHCallPageSettingLayout';
    $route ['PSHSmartLockerShopPosDataTable']              = 'pos/posshop/cPosShop/FSvCPSHSettingLayoutDataList';
    $route ['PSHSmartLockerShopPosEventcheckData']         = 'pos/posshop/cPosShop/FSvCPSHSettingLayoutCheckData';
    $route ['PSHSmartLockerShopPosEventinset']             = 'pos/posshop/cPosShop/FSvCPSHSettingLayoutEventAdd';

    //Check status Smart locker
    $route ['PSHSmartLockerCheckStatusMain']               = 'company/smartlockerCheckstatus/cSmartlockerCheckstatus/FSvCPSHCheckStatusMainPage';
    $route ['PSHSmartLockerCheckStatusDataTable']          = 'company/smartlockerCheckstatus/cSmartlockerCheckstatus/FSvCPSHCheckStatusDataTable';
    $route ['PSHSmartLockerCheckStatusInsertLocker']       = 'company/smartlockerCheckstatus/cSmartlockerCheckstatus/FSvCPSHCheckStatusInsertLocker';
    
    // Adjust status Smart locker
    $route ['smartLockerAdjustStatusMainPage'] = 'company/smart_locker_adjust_status/cSmartLockerAdjustStatus/FSvCAdjustStatusMainPage';
    $route ['smartLockerAdjustStatusDataTable'] = 'company/smart_locker_adjust_status/cSmartLockerAdjustStatus/FSvCAdjustStatusDataTable';
    $route ['smartLockerAdjustStatusRackChannelDataTable'] = 'company/smart_locker_adjust_status/cSmartLockerAdjustStatus/FSvCAdjustStatusRackChannelDataTable';
    $route ['smartLockerAdjustStatusRackChannelToTemp'] = 'company/smart_locker_adjust_status/cSmartLockerAdjustStatus/FSvCAdjustStatusRackChannelToTemp';
    $route ['smartLockerAdjustStatusUpdateStaUseInTemp'] = 'company/smart_locker_adjust_status/cSmartLockerAdjustStatus/FSaCAdjustStatusUpdateStaUseInTemp';
    $route ['smartLockerAdjustStatusDeleteRackChannelInTemp'] = 'company/smart_locker_adjust_status/cSmartLockerAdjustStatus/FSvCAdjustStatusDeleteRackChannelInTemp';
    $route ['smartLockerAdjustStatusTempDataTable'] = 'company/smart_locker_adjust_status/cSmartLockerAdjustStatus/FSvCAdjustStatusTempDataTable';
    $route ['smartLockerAdjustStatusClearTemp'] = 'company/smart_locker_adjust_status/cSmartLockerAdjustStatus/FSaCAdjustStatusClearTemp';
    $route ['smartLockerAdjustStatusPageAdd'] = 'company/smart_locker_adjust_status/cSmartLockerAdjustStatus/FSvCAdjustStatusPageAdd';
    $route ['smartLockerAdjustStatusEventAdd'] = 'company/smart_locker_adjust_status/cSmartLockerAdjustStatus/FSaCAdjustStatusAddEvent';
    $route ['smartLockerAdjustStatusPageView'] = 'company/smart_locker_adjust_status/cSmartLockerAdjustStatus/FSvCAdjustStatusPageView';

    // Branch สาขา
    // Create By Witsarut 10/09/2019
    // BranchSetingConnection (ตั้งค่าการเชื่อมต่อ)
    $route ['BchSettingCon']                     = 'company/settingconnection/cSettingConnection/FSvCUolConnectionMainPage';
    $route ['BchSettingConDataTable']            = 'company/settingconnection/cSettingConnection/FSvCUolConnectionDataList';
    $route ['BchSettingConPageAdd']              = 'company/settingconnection/cSettingConnection/FSvCUolConnectionPageAdd';
    $route ['BchSettingConEventAdd']             = 'company/settingconnection/cSettingConnection/FSaCUolConnectionAddEvent';
    $route ['BchSettingConPageEdit']             = 'company/settingconnection/cSettingConnection/FSvCUolConnectionPageEdit';
    $route ['BchSettingConEventEdit']            = 'company/settingconnection/cSettingConnection/FSaCUolConnectionEditEvent';
    $route ['BchSettingConEventDelete']          = 'company/settingconnection/cSettingConnection/FSaCUolConnectionDeleteEvent';
    $route ['BchSettingConEventDeleteMultiple']  = 'company/settingconnection/cSettingConnection/FSoCUolConnectionDelMultipleEvent';

    // Company บริษัท
    // Create By Witsarut 19/09/2019
    // CompanySetingConnection (ตั้งค่าการเชื่อมต่อ)
    $route ['CompSettingCon']                     = 'company/compsettingconnection/cCompSettingConnection/FSvCCompConnectMainPage';
    $route ['CompSettingConDataTable']            = 'company/compsettingconnection/cCompSettingConnection/FSvCCompConnectDataList';
    $route ['CompSettingConPageAdd']              = 'company/compsettingconnection/cCompSettingConnection/FSvCCompConnectPageAdd';
    $route ['CompSettingConEventAdd']             = 'company/compsettingconnection/cCompSettingConnection/FSaCCompConnectAddEvent';
    $route ['CompSettingConPageEdit']             = 'company/compsettingconnection/cCompSettingConnection/FSvCCompConnectPageEdit';
    $route ['CompSettingConEventEdit']            = 'company/compsettingconnection/cCompSettingConnection/FSaCCompConnectEditEvent';
    $route ['CompSettingConEventDelete']          = 'company/compsettingconnection/cCompSettingConnection/FSaCCompConnectDeleteEvent';
    $route ['CompSettingConEventDeleteMultiple']  = 'company/compsettingconnection/cCompSettingConnection/FSoCCompConnectDelMultipleEvent';


    //ShopWah
    $route ['ShpWah']                             = 'company/shpwah/cShpWah/FSvCShpWahMainPage';
    $route ['ShpWahDataTable']                    = 'company/shpwah/cShpWah/FSvCShpWahDataList';
    $route ['ShpWahPageAdd']                      = 'company/shpwah/cShpWah/FSvCShpWahPageAdd';
    $route ['ShpWahEventAdd']                     = 'company/shpwah/cShpWah/FSaCShpWahAddEvent';
    $route ['ShpWahPageEdit']                     = 'company/shpwah/cShpWah/FSvCShpWahPageEdit';
    $route ['ShpWahEventEdit']                    = 'company/shpwah/cShpWah/FSaCShpWahEditEvent';
    $route ['ShpWahEventDelete']                  = 'company/shpwah/cShpWah/FSaCShpWahDeleteEvent';
    $route ['ShpWahEventDeleteMultiple']          = 'company/shpwah/cShpWah/FSoCShpWahDelMultipleEvent';

    








