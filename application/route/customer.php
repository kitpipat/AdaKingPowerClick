<?php
// Customer
$route ['customer/(:any)/(:any)']           = 'customer/customer/cCustomer/index/$1/$2';
$route ['customerList']                     = 'customer/customer/cCustomer/FSvCSTListPage';
$route ['customerDataTable']                = 'customer/customer/cCustomer/FSvCSTDataList';
$route ['customerContactDataTable']         = 'customer/customer/cCustomer/FSvCSTContactDataList';
$route ['customerPageAdd']                  = 'customer/customer/cCustomer/FSvCSTAddPage';
$route ['customerEventAdd']                 = 'customer/customer/cCustomer/FSaCSTAddEvent';
$route ['customerPageEdit']                 = 'customer/customer/cCustomer/FSvCSTEditPage';
$route ['customerEventEdit']                = 'customer/customer/cCustomer/FSaCSTEditEvent';
// $route ['customerEventAddUpdateAddress']    = 'customer/customer/cCustomer/FSaCSTAddUpdateAddressEvent';
$route ['customerEventAddUpdateContact']    = 'customer/customer/cCustomer/FSaCSTAddUpdateContactEvent';
$route ['customerEventDeleteContact']       = 'customer/customer/cCustomer/FSaCSTDeleteContactEvent';
$route ['customerEventAddUpdateCardInfo']   = 'customer/customer/cCustomer/FSaCSTAddUpdateCardInfoEvent';
$route ['customerEventAddUpdateCredit']     = 'customer/customer/cCustomer/FSaCSTAddUpdateCreditEvent';
$route ['customerEventDataTableRfid']       = 'customer/customer/cCustomer/FSaCSTDataTableRfidEvent';
$route ['customerEventAddUpdateRfid']       = 'customer/customer/cCustomer/FSaCSTAddRfidEvent';
$route ['customerEventUpdateRfid']          = 'customer/customer/cCustomer/FSaCSTUpdateRfidEvent';
$route ['customerEventDeleteRfid']          = 'customer/customer/cCustomer/FSaCSTDeleteRfidEvent';
$route ['customerDeleteMulti']              = 'customer/customer/cCustomer/FSoCSTDeleteMulti';
$route ['customerDelete']                   = 'customer/customer/cCustomer/FSoCSTDelete';
$route ['customerUniqueValidate/(:any)']    = 'customer/customer/cCustomer/FStCSTUniqueValidate/$1';

// Customer Address New Design
$route ['customerAddressData']              = 'customer/customer/cCustomerAddress/FSvCCSTAddressData';
$route ['customerAddressDataTable']         = 'customer/customer/cCustomerAddress/FSvCCSTAddressDataTable';
$route ['customerAddressPageAdd']           = 'customer/customer/cCustomerAddress/FSvCCSTAddressCallPageAdd';
$route ['customerAddressPageEdit']          = 'customer/customer/cCustomerAddress/FSvCCSTAddressCallPageEdit';
$route ['customerAddressAddEvent']          = 'customer/customer/cCustomerAddress/FSoCCSTAddressAddEvent';
$route ['customerAddressEditEvent']         = 'customer/customer/cCustomerAddress/FSoCCSTAddressEditEvent';
$route ['customerAddressDeleteEvent']       = 'customer/customer/cCustomerAddress/FSoCCSTAddressDeleteEvent';

// Customer Group
$route ['customerGroup/(:any)/(:any)']          = 'customer/customerGroup/cCustomerGroup/index/$1/$2';
$route ['customerGroupList']                    = 'customer/customerGroup/cCustomerGroup/FSvCstGrpListPage';
$route ['customerGroupDataTable']               = 'customer/customerGroup/cCustomerGroup/FSvCstGrpDataList';
$route ['customerGroupPageAdd']                 = 'customer/customerGroup/cCustomerGroup/FSvCstGrpAddPage';
$route ['customerGroupEventAdd']                = 'customer/customerGroup/cCustomerGroup/FSaCstGrpAddEvent';
$route ['customerGroupPageEdit']                = 'customer/customerGroup/cCustomerGroup/FSvCstGrpEditPage';
$route ['customerGroupEventEdit']               = 'customer/customerGroup/cCustomerGroup/FSaCstGrpEditEvent';
$route ['customerGroupDeleteMulti']             = 'customer/customerGroup/cCustomerGroup/FSoCstGrpDeleteMulti';
$route ['customerGroupDelete']                  = 'customer/customerGroup/cCustomerGroup/FSoCstGrpDelete';
$route ['customerGroupUniqueValidate/(:any)']   = 'customer/customerGroup/cCustomerGroup/FStCstGrpUniqueValidate/$1';

// Customer Type
$route ['customerType/(:any)/(:any)']           = 'customer/customerType/cCustomerType/index/$1/$2';
$route ['customerTypeList']                     = 'customer/customerType/cCustomerType/FSvCstTypeListPage';
$route ['customerTypeDataTable']                = 'customer/customerType/cCustomerType/FSvCstTypeDataList';
$route ['customerTypePageAdd']                  = 'customer/customerType/cCustomerType/FSvCstTypeAddPage';
$route ['customerTypeEventAdd']                 = 'customer/customerType/cCustomerType/FSaCstTypeAddEvent';
$route ['customerTypePageEdit']                 = 'customer/customerType/cCustomerType/FSvCstTypeEditPage';
$route ['customerTypeEventEdit']                = 'customer/customerType/cCustomerType/FSaCstTypeEditEvent';
$route ['customerTypeDeleteMulti']              = 'customer/customerType/cCustomerType/FSoCstTypeDeleteMulti';
$route ['customerTypeDelete']                   = 'customer/customerType/cCustomerType/FSoCstTypeDelete';
$route ['customerTypeUniqueValidate/(:any)']    = 'customer/customerType/cCustomerType/FStCstTypeUniqueValidate/$1';

// Customer Level
$route ['customerLevel/(:any)/(:any)']          = 'customer/customerLevel/cCustomerLevel/index/$1/$2';
$route ['customerLevelList']                    = 'customer/customerLevel/cCustomerLevel/FSvCstLevListPage';
$route ['customerLevelDataTable']               = 'customer/customerLevel/cCustomerLevel/FSvCstLevDataList';
$route ['customerLevelPageAdd']                 = 'customer/customerLevel/cCustomerLevel/FSvCstLevAddPage';
$route ['customerLevelEventAdd']                = 'customer/customerLevel/cCustomerLevel/FSaCstLevAddEvent';
$route ['customerLevelPageEdit']                = 'customer/customerLevel/cCustomerLevel/FSvCstLevEditPage';
$route ['customerLevelEventEdit']               = 'customer/customerLevel/cCustomerLevel/FSaCstLevEditEvent';
$route ['customerLevelDeleteMulti']             = 'customer/customerLevel/cCustomerLevel/FSoCstLevDeleteMulti';
$route ['customerLevelDelete']                  = 'customer/customerLevel/cCustomerLevel/FSoCstLevDelete';
$route ['customerLevelUniqueValidate/(:any)']   = 'customer/customerLevel/cCustomerLevel/FStCstLevUniqueValidate/$1';

// Customer Occupation
$route ['customerOcp/(:any)/(:any)']            = 'customer/customerOcp/cCustomerOcp/index/$1/$2';
$route ['customerOcpList']                      = 'customer/customerOcp/cCustomerOcp/FSvCstOcpListPage';
$route ['customerOcpDataTable']                 = 'customer/customerOcp/cCustomerOcp/FSvCstOcpDataTable';
$route ['customerOcpPageAdd']                   = 'customer/customerOcp/cCustomerOcp/FSvCstOcpAddPage';
$route ['customerOcpPageEdit']                  = 'customer/customerOcp/cCustomerOcp/FSvCstOcpEditPage';
$route ['customerOcpEventAdd']                  = 'customer/customerOcp/cCustomerOcp/FSaCstOcpAddEvent';
$route ['customerOcpEventEdit']                 = 'customer/customerOcp/cCustomerOcp/FSaCstOcpEditEvent';
$route ['customerOcpEventDelete']               = 'customer/customerOcp/cCustomerOcp/FSaCstOcpDeleteEvent';
$route ['customerOcpUniqueValidate/(:any)']     = 'customer/customerOcp/cCustomerOcp/FStCstOcpUniqueValidate/$1';

//Register Face
$route ['customerRegisFace']                    = 'customer/customerRegisFace/cCustomerRegisFace/FSxCstRGFCallAPIMain';
$route ['customerRegisFaceGetImage']            = 'customer/customerRegisFace/cCustomerRegisFace/FSaCstRGFGetImage';
$route ['customerRegisFaceDeleteImage']         = 'customer/customerRegisFace/cCustomerRegisFace/FSaCstRGFDeleteImage';


// Add Tab Debit Card
// Create By Witsarut 26/10/2016
$route ['DebitCardDataTable']                   = 'customer/customerDebitCard/cCustomerDebitCard/FSvCCstDebitDataList';
$route ['DebitCardPageAdd']                     = 'customer/customerDebitCard/cCustomerDebitCard/FSvCCstDebitPageAdd';
$route ['DebitCardEventAdd']                    = 'customer/customerDebitCard/cCustomerDebitCard/FSaCCstDebitAddEvent';
$route ['DebitCardPageEdit']                    = 'customer/customerDebitCard/cCustomerDebitCard/FSvCCstDebitPageEdit';
$route ['DebitCardEventEdit']                   = 'customer/customerDebitCard/cCustomerDebitCard/FSaCCstDebitEditEvent';
$route ['DebitCardEventDelete']                 = 'customer/customerDebitCard/cCustomerDebitCard/FSaCCstDebitDeleteEvent';


//Customerlogin
$route ['customerlogin']                        = 'customer/customerlogin/cCstlogin/FSvCCSTloginMainPage';
$route ['customerloginDataTable']               = 'customer/customerlogin/cCstlogin/FSvCCSTloginDataList';
$route ['customerloginPageAdd']                 = 'customer/customerlogin/cCstlogin/FSvCCSTlogPageAdd';
$route ['customerloginPageEdit']                = 'customer/customerlogin/cCstlogin/FSvCCSTlogPageEdit';
$route ['customerloginEventAdd']                = 'customer/customerlogin/cCstlogin/FSaCCSTlogAddEvent';
$route ['customerloginEventEdit']               = 'customer/customerlogin/cCstlogin/FSaCCSTlogEditEvent';
$route ['customerloginEventDelete']             = 'customer/customerlogin/cCstlogin/FSaCCSTlogDeleteEvent';
$route ['customerloginEventDeleteMultiple']     = 'customer/customerlogin/cCstlogin/FSoCCSTlogDelMultipleEvent';

//History BuyLicense
$route ['HisBuyLicense']                        = 'customer/HisBuyLicense/cHisBuyLicense/index';
$route ['HisBuyLicenseList']                    = 'customer/HisBuyLicense/cHisBuyLicense/FSvCHISBuyLicenseMainPage';
$route ['HisBuyLicenseDataTable']               = 'customer/HisBuyLicense/cHisBuyLicense/FSvCHISBuyLicenseDataTable';
$route ['HisBuyLicensePagePreview']             = 'customer/HisBuyLicense/cHisBuyLicense/FSvCHISBuyLicensePagePreview';

