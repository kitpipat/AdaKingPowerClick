<?php

//Supplier ผู้จำหน่าย
$route ['supplier/(:any)/(:any)']       = 'supplier/supplier/cSupplier/index/$1/$2';
$route ['supplierList']                 = 'supplier/supplier/cSupplier/FSvCSPLListPage';
$route ['supplierDataTable']            = 'supplier/supplier/cSupplier/FSvCSPLDataList';
$route ['supplierPageAdd']              = 'supplier/supplier/cSupplier/FSvCSPLAddPage';
$route ['supplierPageEdit']             = 'supplier/supplier/cSupplier/FSvCSPLEditPage';
$route ['supplierEventAdd']             = 'supplier/supplier/cSupplier/FSoCSPLAddEvent';
$route ['supplierEventEdit']            = 'supplier/supplier/cSupplier/FSoCSPLEditEvent';
$route ['supplierEventDelete']          = 'supplier/supplier/cSupplier/FSoCSPLDeleteEvent';
$route ['supplierPageAddAddress']       = 'supplier/supplier/cSupplier/FSvCSPLAddAddressPage';
$route ['supplierPageAddContact']       = 'supplier/supplier/cSupplier/FSvCSPLAddContactPage';
$route ['supplierEventAddAddress']      = 'supplier/supplier/cSupplier/FSoCSPLAddressAddEvent';
$route ['supplierEventAddContact']      = 'supplier/supplier/cSupplier/FSoCSPLContactAddEvent';
$route ['supplierAddressDataTable']     = 'supplier/supplier/cSupplier/FSoCSPLAddressDataTable';
$route ['supplierContactDataTable']     = 'supplier/supplier/cSupplier/FSoCSPLContactDataTable';
$route ['supplierAddressPageEdit']      = 'supplier/supplier/cSupplier/FSvCSPLEAddressEditPage';
$route ['supplierContactPageEdit']      = 'supplier/supplier/cSupplier/FSvCSPLEContactEditPage';
$route ['supplierEventEditAddress']     = 'supplier/supplier/cSupplier/FSoCSPLAddressEditEvent';
$route ['supplierEventEditContact']     = 'supplier/supplier/cSupplier/FSoCSPLContactEditEvent';
$route ['supplierAddressEventDelete']   = 'supplier/supplier/cSupplier/FSoCSPLAddressDeleteEvent';
$route ['supplierContactEventDelete']   = 'supplier/supplier/cSupplier/FSoCSPLContactDeleteEvent';
//Supplier Level (ระดับ ผู้จำหน่าย)
$route ['supplierlev/(:any)/(:any)']    = 'supplier/supplierlev/cSupplierLev/index/$1/$2';
$route ['supplierlevList']              = 'supplier/supplierlev/cSupplierLev/FSvCSLVListPage';
$route ['supplierlevDataTable']         = 'supplier/supplierlev/cSupplierLev/FSvCSLVDataList';
$route ['supplierlevPageAdd']           = 'supplier/supplierlev/cSupplierLev/FSvCSLVAddPage';
$route ['supplierlevPageEdit']          = 'supplier/supplierlev/cSupplierLev/FSvCSLVEditPage';
$route ['supplierlevEventAdd']          = 'supplier/supplierlev/cSupplierLev/FSoCSLVAddEvent';
$route ['supplierlevEventEdit']         = 'supplier/supplierlev/cSupplierLev/FSoCSLVEditEvent';
$route ['supplierlevEventDelete']       = 'supplier/supplierlev/cSupplierLev/FSoCSLVDeleteEvent';

//SupplierType (ประเภทจำหน่าย)
$route ['suppliertype/(:any)/(:any)']   = 'supplier/suppliertype/cSupplierType/index/$1/$2';
$route ['suppliertypeList']             = 'supplier/suppliertype/cSupplierType/FSvCSTYListPage';
$route ['suppliertypeDataTable']        = 'supplier/suppliertype/cSupplierType/FSvCSTYDataList';
$route ['suppliertypePageAdd']          = 'supplier/suppliertype/cSupplierType/FSvCSTYAddPage';
$route ['suppliertypePageEdit']         = 'supplier/suppliertype/cSupplierType/FSvCSTYEditPage';
$route ['suppliertypeEventAdd']         = 'supplier/suppliertype/cSupplierType/FSoCSTYAddEvent';
$route ['suppliertypeEventEdit']        = 'supplier/suppliertype/cSupplierType/FSoCSTYEditEvent';
$route ['suppliertypeEventDelete']      = 'supplier/suppliertype/cSupplierType/FSoCSTYDeleteEvent';

//Group Suppliers (กลุ่ม ผู้จำหน่าย)
$route ['groupsupplier/(:any)/(:any)']  = 'supplier/groupsupplier/cGroupSupplier/index/$1/$2';
$route ['groupsupplierList']            = 'supplier/groupsupplier/cGroupSupplier/FSvCSGPListPage';
$route ['groupsupplierDataTable']       = 'supplier/groupsupplier/cGroupSupplier/FSvCSGPDataList';
$route ['groupsupplierPageAdd']         = 'supplier/groupsupplier/cGroupSupplier/FSvCSGPAddPage';
$route ['groupsupplierPageEdit']        = 'supplier/groupsupplier/cGroupSupplier/FSvCSGPEditPage';
$route ['groupsupplierEventAdd']        = 'supplier/groupsupplier/cGroupSupplier/FSoCSGPAddEvent';
$route ['groupsupplierEventEdit']       = 'supplier/groupsupplier/cGroupSupplier/FSoCSGPEditEvent';
$route ['groupsupplierEventDelete']     = 'supplier/groupsupplier/cGroupSupplier/FSoCSGPDeleteEvent';

//ShipVia (ขนส่งโดย)
$route ['shipvia/(:any)/(:any)']      = 'shipvia/shipvia/cShipVia/index/$1/$2';
$route ['shipviaList']                = 'shipvia/shipvia/cShipVia/FSvCVIAListPage';
$route ['shipviaDataTable']           = 'shipvia/shipvia/cShipVia/FSvCVIADataList';
$route ['shipviaPageAdd']             = 'shipvia/shipvia/cShipVia/FSvCVIAAddPage';
$route ['shipviaPageEdit']            = 'shipvia/shipvia/cShipVia/FSvCVIAEditPage';
$route ['shipviaEventAdd']            = 'shipvia/shipvia/cShipVia/FSoCVIAAddEvent';
$route ['shipviaEventEdit']           = 'shipvia/shipvia/cShipVia/FSoCVIAEditEvent';
$route ['shipviaEventDelete']         = 'shipvia/shipvia/cShipVia/FSoCVIADeleteEvent';

