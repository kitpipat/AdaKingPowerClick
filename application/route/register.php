<?php defined ('BASEPATH') or exit ( 'No direct script access allowed' );

//Information Register
$route ['ImformationRegister']                      = 'register/information/cInformationRegister/index';
$route ['ImformationRegisterPageForm']              = 'register/information/cInformationRegister/FSvIMRGetPageForm';
$route ['ImformationRegisterEventImportAccount']    = 'register/information/cInformationRegister/FSvIMREventImportAccount';
$route ['ImformationRegisterEventImportLicense']    = 'register/information/cInformationRegister/FSvIMREventImportLicense';

//BuyLicense + Register
$route ['BuyLicense/(:any)']                        = 'register/BuyLicense/cBuyLicense/index/$1';
$route ['BuyLicenseList']                           = 'register/BuyLicense/cBuyLicense/FSvCBUYCallViewlist';
$route ['BuyLicenseListAddOn']                      = 'register/BuyLicense/cBuyLicense/FSvCBUYCallViewAddOn';
$route ['BuyLicenseRecheckDetail']                  = 'register/BuyLicense/cBuyLicense/FSvCBUYCallViewRecheckDetail';
$route ['BuyLicenseRecheckDetailMore']              = 'register/BuyLicense/cBuyLicense/FSvCBUYCallViewRecheckDetailMore';
$route ['BuyLicenseCallPromptPay']                  = 'register/BuyLicense/cBuyLicense/FSvCBUYCallAPIPromptPay';
$route ['BuyLicenseCallCheckPromptPay']             = 'register/BuyLicense/cBuyLicense/FSvCBUYCallAPICheckPromptPay';
$route ['BuyLicensePayment']                        = 'register/BuyLicense/cBuyLicense/FSvCBUYCallViewPayment';
$route ['BuyLicenseInsert']                         = 'register/BuyLicense/cBuyLicense/FSvCBUYCallAPIInsert';
$route ['BuyLicenseFindCoupon']                     = 'register/BuyLicense/cBuyLicense/FSvCBUYCallAPIFindCoupon';
$route ['BuyLicenseClearCoupon']                    = 'register/BuyLicense/cBuyLicense/FSxCBUYClearCoupon';
$route ['BuyLicenseRecheckDetailExtend']            = 'register/BuyLicense/cBuyLicense/FSxCBuyLicenseRecheckDetailExtend';
$route ['BuyLicenseListAddOnExtend']                = 'register/BuyLicense/cBuyLicense/FSvCBUYCallViewAddOn';
$route ['BuyLicenseCheckCreditRefund']              = 'register/BuyLicense/cBuyLicense/FSxCBuyLicenseCreditRefund';
$route ['BuyLicenseLoadTablePackage']               = 'register/BuyLicense/cBuyLicense/FSwCBuyLoadTablePackage';


//Agreement
$route ['LicenseAgreement']                         = 'register/LicenseAgreement/cLicenseAgreement/index';
$route ['LicenseAgreementPageForm']                 = 'register/LicenseAgreement/cLicenseAgreement/FSvLCGGetPageForm';

//Contact
$route ['AdaSoftContact']                           = 'register/Contact/cAdaSoftContact/index';
$route ['AdaSoftContactPageForm']                   = 'register/Contact/cAdaSoftContact/FSvADCGetPageForm';




//Server
$route ['Server/(:any)/(:any)']                     = 'register/Server/cServer/index/$1/$2';
$route ['ServerList']                               = 'register/Server/cServer/FSvCSrvListPage';
$route ['ServerDataTable']                          = 'register/Server/cServer/FSvCSrvDataList';
$route ['ServerPageAdd']                            = 'register/Server/cServer/FSvCSrvAddPage';
$route ['ServerPageEdit']                           = 'register/Server/cServer/FSvCSrvEditPage';
$route ['ServerEventAdd']                           = 'register/Server/cServer/FSoCSrvAddEvent';
$route ['ServerEventEdit']                          = 'register/Server/cServer/FSoCSrvEditEvent';
$route ['ServerEventDelete']                        = 'register/Server/cServer/FSoCSrvDeleteEvent';
$route ['ServerEventSync']                          = 'register/Server/cServer/FSoCSrvSyncEvent';

//ต่ออายุ
$route ['LicenseRenew']                             = 'register/LicenseRenew/cLicenseRenew/index';
$route ['LicenseRenewPageForm']                     = 'register/LicenseRenew/cLicenseRenew/FSvIMRGetPageForm';
$route ['LicenseRenewCallCheckBill']                = 'register/LicenseRenew/cLicenseRenew/FSvIMRInsertDTToTemp';

//เงื่อนไขการให้บริการ
$route ['SoftwareLicenseAgreement']                 = 'register/LicenseAgreement/cLicenseAgreement/FSvCLCGShowLicense';
//นโยบายความเป็นส่วนตัว
$route ['SoftwarePrivacyAgreement']                 = 'register/LicenseAgreement/cLicenseAgreement/FSvCLCGShowPrivacyAgreement';


//Unsend Email
$route ['UnsendEmail/(:any)']                 = 'register/UnsendEmail/cUnsendEmail/index/$1';
$route ['UnsendEmailSubmit']                 = 'register/UnsendEmail/cUnsendEmail/FSvUEMSubmitUnsendEmail';
