<?php defined ('BASEPATH') or exit ( 'No direct script access allowed' );

$route ['interfaceimport/(:any)/(:any)']  = 'Interface/Interfaceimport/cInterfaceimport/index/$1/$2';
$route ['interfaceimportAction']          = 'Interface/Interfaceimport/cInterfaceimport/FSxCINMCallRabitMQ';

//Interfacehistory ประวัตินำเข้า - นำออก nonpawich 5/3/2020
$route ['interfacehistory/(:any)/(:any)']  = 'interface/interfacehistory/cInterfaceHistory/index/$1/$2';
$route ['interfacehistorylist']            = 'interface/interfacehistory/cInterfaceHistory/FSxCIFHList';
$route ['interfaceihistorydatatable']      = 'interface/interfacehistory/cInterfaceHistory/FSaCIFHGetDataTable';

//InterfaceExport ส่งออก Napat(Jame) 05/03/2020
$route ['interfaceexport/(:any)/(:any)']  = 'interface/interfaceexport/cInterfaceExport/index/$1/$2';
$route ['interfaceexportAction']          = 'Interface/interfaceexport/cInterfaceExport/FSxCIFXCallRabitMQ';
$route ['interfaceexportFilterBill']      = 'Interface/interfaceexport/cInterfaceExport/FSnCIFXFillterBill';

//ตั้งค่า 14/05/2020 Saharat(Golf)
$route ['connectionsetting/(:any)/(:any)']       = 'interface/connectionsetting/cConnectionSetting/index/$1/$2';
$route ['connectionsettingCallPageList']         = 'interface/connectionsetting/cConnectionSetting/FSxCCCSPageWahouse';
$route ['connectionsettingDataTable']            = 'interface/connectionsetting/cConnectionSetting/FSvCCCSDataList';
$route ['connectionsettingCallPageAddWahouse']   = 'interface/connectionsetting/cConnectionSetting/FSxCCCSPageAddWahouse';
$route ['connectionsettingEventAdd']             = 'interface/connectionsetting/cConnectionSetting/FSxCCCSWahouseEventAdd';
$route ['connectionsettingCallPageEdit']         = 'interface/connectionsetting/cConnectionSetting/FSxCCCSWahousePageEdit';
$route ['connectionsettingEventEdit']            = 'interface/connectionsetting/cConnectionSetting/FSxCCCSWahouseEventEdit';
$route ['connectionsettingEventDelete']          = 'interface/connectionsetting/cConnectionSetting/FSaCCCSDeleteEvent';
$route ['connectionsettingEventDeleteMultiple']  = 'interface/connectionsetting/cConnectionSetting/FSaCCCSDelMultipleEvent';


$route ['masCustomersettingCallPageList']        = 'interface/connectionsetting/cConnectionSetting/FSxCCCSPageCustomer';
$route ['masCustomersettingDataTable']           = 'interface/connectionsetting/cConnectionSetting/FSvCCCSCustomerDataList';
// $route ['masCustomersettingDataTableSearch']     = 'interface/connectionsetting/cConnectionSetting/FSvCCCSCustomerDataListSearch';
$route ['masCustomernSettingGanPageAdd']         = 'interface/connectionsetting/cConnectionSetting/FSxCCCSPageAddCustomer';
$route ['CustomernSettingEventAdd']              = 'interface/connectionsetting/cConnectionSetting/FSxCCCSCustomerEventAdd';
$route ['CustomersettingEventDelete']            = 'interface/connectionsetting/cConnectionSetting/FSaCCCSCusDeleteEvent';
$route ['CustomerEventDeleteMultiple']           = 'interface/connectionsetting/cConnectionSetting/FSaCCCSCusDelMultipleEvent';

//ตั้งค่า Tab ทั่วไป 15/05/2020 Witsarut(Bell)
$route ['connectSetGenaral']                    = 'interface/connectionsetting/cConSettingGenaral/FSxSETMainPage';
$route ['connsetGenDataTable']                  = 'interface/connectionsetting/cConSettingGenaral/FSvSETDataList';
$route ['consetgenEventedit']                   = 'interface/connectionsetting/cConSettingGenaral/FSxSETEventAdd';
$route ['ConSettingGanPageEdit']                = 'interface/connectionsetting/cConSettingGenaral/FSvSETPageEdit';
$route ['ConSettingGanPageEditApiAuth']         = 'interface/connectionsetting/cConSettingGenaral/FSvSETPageEditApiAuth';
$route ['ConSettingGanPageAdd']                 = 'interface/connectionsetting/cConSettingGenaral/FSvSETPageAdd';
$route ['ConnSetGenaralEventAuthorEdit']        = 'interface/connectionsetting/cConSettingGenaral/FSvSETEventAuthorEdit';
$route ['ConnSetGenaralEventAuthorAdd']         = 'interface/connectionsetting/cConSettingGenaral/FSvSETEventAuthorAdd';
$route ['ConSettingGenaralEventDelete']         = 'interface/connectionsetting/cConSettingGenaral/FSaSETDeleteEvent';
