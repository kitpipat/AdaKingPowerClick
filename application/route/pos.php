<?php
    // Sale Person  (พนักงานขาย)
    $route ['saleperson/(:any)/(:any)']         = 'pos/saleperson/cSalePerson/index/$1/$2';
    $route ['salepersonList']                   = 'pos/saleperson/cSalePerson/FSvSPNListPage';
    $route ['salepersonDataTable']              = 'pos/saleperson/cSalePerson/FSvSPNDataList';
    $route ['salepersonPageAdd']                = 'pos/saleperson/cSalePerson/FSvSPNAddPage';
    $route ['salepersonPageEdit']               = 'pos/saleperson/cSalePerson/FSvSPNEditPage';
    $route ['salepersonEventAdd']               = 'pos/saleperson/cSalePerson/FSaSPNAddEvent';
    $route ['salepersonEventEdit']              = 'pos/saleperson/cSalePerson/FSaSPNEditEvent';
    $route ['salepersonDelete']                 = 'pos/saleperson/cSalePerson/FSoSPNDelete';
    // $route ['salepersonDeleteMulti']            = 'pos/saleperson/cSalePerson/FSoSPNDeleteMulti';

    // Slip Message (ข้อความหัวท้ายใบเสร็จ)
    $route ['slipMessage/(:any)/(:any)']        = 'pos/slipmessage/cSlipMessage/index/$1/$2';
    $route ['slipMessageList']                  = 'pos/slipmessage/cSlipMessage/FSvSMGListPage';
    $route ['slipMessageDataTable']             = 'pos/slipmessage/cSlipMessage/FSvSMGDataList';
    $route ['slipMessagePageAdd']               = 'pos/slipmessage/cSlipMessage/FSvSMGAddPage';
    $route ['slipMessageEventAdd']              = 'pos/slipmessage/cSlipMessage/FSaSMGAddEvent';
    $route ['slipMessagePageEdit']              = 'pos/slipmessage/cSlipMessage/FSvSMGEditPage';
    $route ['slipMessageEventEdit']             = 'pos/slipmessage/cSlipMessage/FSaSMGEditEvent';
    $route ['slipMessageDeleteMulti']           = 'pos/slipmessage/cSlipMessage/FSoSMGDeleteMulti';
    $route ['slipMessageDelete']                = 'pos/slipmessage/cSlipMessage/FSoSMGDelete';
    $route ['slipMessageUniqueValidate/(:any)'] = 'pos/slipmessage/cSlipMessage/FStSMGUniqueValidate/$1';

     // Set Printer  (g)
     $route ['setprinter/(:any)/(:any)']         = 'pos/setprinter/cSetprinter/index/$1/$2';
     $route ['setprinterList']                   = 'pos/setprinter/cSetprinter/FSvCSPRListPage';
     $route ['setprinterDataTable']              = 'pos/setprinter/cSetprinter/FSvCSPRDataList';
     $route ['setprinterPageAdd']                = 'pos/setprinter/cSetprinter/FSvCSPRAddPage';
     $route ['setprinterPageEdit']               = 'pos/setprinter/cSetprinter/FSvCSPREditPage';
     $route ['setprinterEventAdd']               = 'pos/setprinter/cSetprinter/FSaCSPRAddEvent';
     $route ['setprinterEventEdit']              = 'pos/setprinter/cSetprinter/FSaCSPREditEvent';
     $route ['setprinterDelete']                 = 'pos/setprinter/cSetprinter/FSoCSPRDelete';
     $route ['setprinterDeleteMulti']            = 'pos/setprinter/cSetprinter/FSoCSPRDeleteMulti';

    //Sale Machine (เครื่องจุดขาย)
    $route ['salemachine/(:any)/(:any)']        = 'pos/salemachine/cSaleMachine/index/$1/$2';
    $route ['salemachineList']                  = 'pos/salemachine/cSaleMachine/FSvCPOSListPage';
    $route ['salemachineDataTable']             = 'pos/salemachine/cSaleMachine/FSvCPOSDataList';
    $route ['salemachinePageAdd']               = 'pos/salemachine/cSaleMachine/FSvCPOSAddPage';
    $route ['salemachinePageEdit']              = 'pos/salemachine/cSaleMachine/FSvCPOSEditPage';
    $route ['salemachineEventAdd']              = 'pos/salemachine/cSaleMachine/FSoCPOSAddEvent';
    $route ['salemachineEventEdit']             = 'pos/salemachine/cSaleMachine/FSoCPOSEditEvent';
    $route ['salemachineEventDelete']           = 'pos/salemachine/cSaleMachine/FSoCPOSDeleteEvent';
    $route ['salemachineImportGetDataInTemp']       = 'pos/salemachine/cSaleMachine/FStCImportGetDataInTmp';
    $route ['salemachineImportGetDataJsonInTemp']   = 'pos/salemachine/cSaleMachine/FSoCImportGetDataJsonInTmp';
    $route ['salemachineImportDeleteInTempBySeq']   = 'pos/salemachine/cSaleMachine/FSoCImportDeleteInTempBySeqNo';
    $route ['salemachineImportTempToMaster']        = 'pos/salemachine/cSaleMachine/FSoCImportTempToMaster';
    $route ['salemachineImportClearInTemp']         = 'pos/salemachine/cSaleMachine/FSoCImportClearInTemp';
    $route ['salemachineImportGetStaInTemp']        = 'pos/salemachine/cSaleMachine/FSoCSALImportGetStaInTemp';

    // Sale Machine Address (ที่อยู่เครื่องจุดขาย)
    $route ['salemachineAddressData']           = 'pos/salemachine/cSalemachineAddress/FSvCPOSAddressData';
    $route ['salemachineAddressDataTable']      = 'pos/salemachine/cSalemachineAddress/FSvCPOSAddressDataTable';
    $route ['salemachineAddressPageAdd']        = 'pos/salemachine/cSalemachineAddress/FSvCPOSAddressCallPageAdd';
    $route ['salemachineAddressPageEdit']       = 'pos/salemachine/cSalemachineAddress/FSvCPOSAddressCallPageEdit';
    $route ['salemachineAddressAddEvent']       = 'pos/salemachine/cSalemachineAddress/FSoCPOSAddressAddEvent';
    $route ['salemachineAddressEditEvent']      = 'pos/salemachine/cSalemachineAddress/FSoCPOSAddressEditEvent';
    $route ['salemachineAddressDeleteEvent']    = 'pos/salemachine/cSalemachineAddress/FSoCPOSAddressDeleteEvent';

    //Sale MachineDevice (เครื่องจุดขายอุปกรณ์)
    $route ['salemachinedevice/(:any)/(:any)']  = 'pos/salemachinedevice/cSaleMachineDevice/index/$1/$2';
    $route ['salemachinedeviceList']            = 'pos/salemachinedevice/cSaleMachineDevice/FSvCPHWListPage';
    $route ['salemachinedeviceDataTable']       = 'pos/salemachinedevice/cSaleMachineDevice/FSvCPHWDataList';
    $route ['salemachinedevicePageAdd']         = 'pos/salemachinedevice/cSaleMachineDevice/FSvCPHWAddPage';
    $route ['salemachinedevicePageEdit']        = 'pos/salemachinedevice/cSaleMachineDevice/FSvCPHWEditPage';
    $route ['salemachinedeviceEventAdd']        = 'pos/salemachinedevice/cSaleMachineDevice/FSoCPHWAddEvent';
    $route ['salemachinedeviceEventEdit']       = 'pos/salemachinedevice/cSaleMachineDevice/FSoCPHWEditEvent';
    $route ['salemachinedeviceEventDelete']     = 'pos/salemachinedevice/cSaleMachineDevice/FSoCPHWDeleteEvent';
    $route ['salemachineCheckInputGenCode']     = 'pos/salemachinedevice/cSaleMachineDevice/FSoCPHWCheckInputGenCode';

    // Pos Spc Cat
    $route ['masPOSSpcCatPageList']             = 'pos/salemachine/Posspccat_controller/FSvCPSCPageList';
    $route ['masPOSSpcCatPageDataTable']        = 'pos/salemachine/Posspccat_controller/FSvCPSCPageDataTable';
    $route ['masPOSSpcCatPageAdd']              = 'pos/salemachine/Posspccat_controller/FSvCPSCPageAdd';
    $route ['masPOSSpcCatEventAdd']             = 'pos/salemachine/Posspccat_controller/FSvCPSCEventAdd';
    $route ['masPOSSpcCatPageEdit']             = 'pos/salemachine/Posspccat_controller/FSvCPSCPageEdit';
    $route ['masPOSSpcCatEventEdit']            = 'pos/salemachine/Posspccat_controller/FSvCPSCEventEdit';
    $route ['masPOSSpcCatEventDelete']          = 'pos/salemachine/Posspccat_controller/FSvCPSCEventDelete';
    

    // Ad Message (จัดการสื่อ/ข้อความ/หน้าจอลูกค้า)
    $route ['adMessage/(:any)/(:any)']                  = 'pos/admessage/cAdMessage/index/$1/$2';
    $route ['adMessageList']                            = 'pos/admessage/cAdMessage/FSvADVListPage';
    $route ['adMessageDataTable']                       = 'pos/admessage/cAdMessage/FSvADVDataList';
    $route ['adMessagePageAdd']                         = 'pos/admessage/cAdMessage/FSvADVAddPage';
    $route ['adMessageEventAdd']                        = 'pos/admessage/cAdMessage/FSaADVAddEvent';
    $route ['adMessagePageEdit']                        = 'pos/admessage/cAdMessage/FSvADVEditPage';
    $route ['adMessageEventEdit']                       = 'pos/admessage/cAdMessage/FSaADVEditEvent';
    $route ['adMessageDeleteMulti']                     = 'pos/admessage/cAdMessage/FSoADVDeleteMulti';
    $route ['adMessageDelete']                          = 'pos/admessage/cAdMessage/FSoADVDelete';
    $route ['adMessageUniqueValidate/(:any)']           = 'pos/admessage/cAdMessage/FStADVUniqueValidate/$1';
    $route ['adMessageUniqueFileNameValidate/(:any)']   = 'pos/admessage/cAdMessage/FStADVUniqueFileNameValidate/$1';


    //TCNMPosAds (กำหนดโฆษณาเครื่องจุดขาย/ตู้ Vending)
    $route ['posAds/(:any)/(:any)']         = 'pos/posAds/cPosAds/index/$1/$2';
    $route ['posAdsList']                   = 'pos/posAds/cPosAds/FSvCADSListPage';
    $route ['posAdsDataTable']              = 'pos/posAds/cPosAds/FSvCADSDataList';
    $route ['posAdsPageAdd']                = 'pos/posAds/cPosAds/FSvCADSAddPage';
    $route ['posAdsPageEdit']               = 'pos/posAds/cPosAds/FSvCADSEditPage';
    $route ['posAdsEventAdd']               = 'pos/posAds/cPosAds/FSoCADSAddEvent';
    $route ['posAdsEventEdit']              = 'pos/posAds/cPosAds/FSoCADSEditEvent';
    $route ['posAdsEventDelete']            = 'pos/posAds/cPosAds/FSoCADSDeleteEvent';
    $route ['posAdsEventDeleteMultiple']    = 'pos/posAds/cPosAds/FSoCADSDeleteMultipleEvent';
    $route ['posAdsViewMedia']              = 'pos/posAds/cPosAds/FSoCADSViewMedia';
    $route ['posAdsViewPosition']           = 'pos/posAds/cPosAds/FSoCADSViewPosition';


    //TVDMPosShop (กำหนดเครื่องจุดขาย)
    $route ['posshop/(:any)/(:any)']         = 'pos/posshop/cPosShop/index/$1/$2';
    $route ['posshopList']                   = 'pos/posshop/cPosShop/FSvCPSHListPage';
    $route ['posshoppageadd']                = 'pos/posshop/cPosShop/FSvCPSHCallPageAdd';
    $route ['posshopDataTable']              = 'pos/posshop/cPosShop/FSvCPSHDataList';
    $route ['posshopPageEdit']               = 'pos/posshop/cPosShop/FSvCPSHEditPage';
    $route ['posshopEventAdd']               = 'pos/posshop/cPosShop/FSoCPSHAddEvent';
    $route ['posshopEventDelete']            = 'pos/posshop/cPosShop/FSoCPSHDeleteEvent';
    $route ['posshopEventpageedit']          = 'pos/posshop/cPosShop/FSvCPSHCallPageEdit';
    $route ['posshopEventEdit']              = 'pos/posshop/cPosShop/FSoCPSHEditEvent';

    //Edit in line in page : shop
    $route ['posshopEditinLinePageShop']     = 'pos/posshop/cPosShop/FSvCPSHEditInLinePageShop';

    // EDC เครื่องอ่านบัตรเครดิต
    $route['posEdc/(:any)/(:any)']          = 'pos/posedc/cPosEdc/index/$1/$2';
    $route['posEdcList']                    = 'pos/posedc/cPosEdc/FSvCPosEdcListPage';
    $route['posEdcDataTable']               = 'pos/posedc/cPosEdc/FSoCPosEdcDataTable';
    $route['posEdcPageAdd']                 = 'pos/posedc/cPosEdc/FSoCPosEdcCallPageAdd';
    $route['posEdcPageEdit']                = 'pos/posedc/cPosEdc/FSoCPosEdcCallPageEdit';
    $route['posEdcEventAdd']                = 'pos/posedc/cPosEdc/FSoCPosEdcAddEvent';
    $route['posEdcEventEdit']               = 'pos/posedc/cPosEdc/FSoCPosEdcEditEvent';
    $route['posEdcEventDelete']             = 'pos/posedc/cPosEdc/FSoCPosEdcDeleteEvent';

    //ลงทะเบียนจุดขาย
    //Create By Witsarut 14/07/2020
    $route['posreg/(:any)/(:any)']         = 'pos/posregister/cPosRegister/index/$1/$2';
    $route['posregList']                   = 'pos/posregister/cPosRegister/FSvPRGPageList';
    $route['posregLoadTable']              = 'pos/posregister/cPosRegister/FSvPRGGetTable';
    $route['posregSaveData']               = 'pos/posregister/cPosRegister/FSvPRGSaveData';
    $route['posregCancelData']             = "pos/posregister/cPosRegister/FSvPRGCancelData";

    //ช่องทองขาย
    //Create By Worakorn 28/12/2020
    $route['chanel/(:any)/(:any)']         = 'pos/chanel/cPosChanel/index/$1/$2';
    $route['chanelList']                   = 'pos/chanel/cPosChanel/FSvCCHNListPage';
    $route['chanelDataTable']              = 'pos/chanel/cPosChanel/FSvCCHNDataList';
    $route ['chanelPageAdd']               = 'pos/chanel/cPosChanel/FSvCHNAddPage';
    $route ['chanelEventAdd']              = 'pos/chanel/cPosChanel/FSaCHNAddEvent';
    $route ['chanelPageEdit']              = 'pos/chanel/cPosChanel/FSvCHNEditPage';
    $route ['chanelEventEdit']             = 'pos/chanel/cPosChanel/FSaCHNEditEvent';
    $route ['chanelDeleteMulti']           = 'pos/chanel/cPosChanel/FSoCHNDeleteMulti';
    $route ['chanelDelete']                = 'pos/chanel/cPosChanel/FSoCHNDelete';
    $route ['chanelUniqueValidate/(:any)'] = 'pos/chanel/cPosChanel/FStCHNUniqueValidate/$1';
    $route ['chanelEventChkSpcWah']        = 'pos/chanel/cPosChanel/FSaCHNEventChkSpcWah';
    $route ['chanelEventClearSpcWah']      = 'pos/chanel/cPosChanel/FSaCHNEventClearSpcWah';
    

    // Channel Spc Wah
    // Create By : Napat(Jame) 13/06/2022
    $route['chanelPageSpcWah']             = 'pos/chanel/cPosChanel/FSvCCHNPageSpcWah';
    $route['chanelPageSpcWahAdd']          = 'pos/chanel/cPosChanel/FSvCCHNPageSpcWahAdd';
    $route['chanelEventSpcWahAdd']         = 'pos/chanel/cPosChanel/FSaCCHNEventSpcWahAdd';
    $route['chanelPageSpcWahEdit']         = 'pos/chanel/cPosChanel/FSvCCHNPageSpcWahEdit';
    $route['chanelEventSpcWahEdit']        = 'pos/chanel/cPosChanel/FSaCCHNEventSpcWahEdit';
    $route['chanelEventSpcWahDel']         = 'pos/chanel/cPosChanel/FSaCCHNEventSpcWahDel';
    