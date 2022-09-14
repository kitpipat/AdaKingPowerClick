<?php

//Merchant ผู้ประกอบการ
$route ['merchant/(:any)/(:any)']    = 'merchant/merchant/cMerchant/index/$1/$2';
$route ['merchantList']              = 'merchant/merchant/cMerchant/FSvCMerchantListPage';
$route ['merchantDataTable']         = 'merchant/merchant/cMerchant/FSvCMerchantDataList';
$route ['merchantPageAdd']           = 'merchant/merchant/cMerchant/FSvCMerchantAddPage';
$route ['merchantPageEdit']          = 'merchant/merchant/cMerchant/FSvMCNEditPage';
$route ['merchantEventAdd']          = 'merchant/merchant/cMerchant/FSaMCNAddEvent';
$route ['merchantEventEdit']         = 'merchant/merchant/cMerchant/FSaMCNEditEvent';
$route ['merchantEventDelete']       = 'merchant/merchant/cMerchant/FSaMCNDeleteEvent';

$route ['merchantAddressDataTable']     = 'merchant/merchant/cMerchant/FSvCMerchantAddressDataTable';
$route ['merchantPageAddAddress']       = 'merchant/merchant/cMerchant/FSvCMerchantAddressCallPageAdd';
$route ['merchantAddressPageEdit']      = 'merchant/merchant/cMerchant/FSvCMerchantAddressCallPageEdit';
$route ['merchantEventAddAddress']      = 'merchant/merchant/cMerchant/FSaCMerchantAddressAddEvent';
$route ['merchantEventEditAddress']     = 'merchant/merchant/cMerchant/FSaCMerchantAddressEditEvent';
$route ['merchantAddressEventDelete']   = 'merchant/merchant/cMerchant/FSoCMerchantAddressDeleteEvent';