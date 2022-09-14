<?php
// Customer
$route ['customerlicense/(:any)/(:any)']           = 'customerlicense/customerlicense/cCustomerLicense/index/$1/$2';
$route ['customerlicenseList']                     = 'customerlicense/customerlicense/cCustomerLicense/FSvCLNListPage';
$route ['customerlicenseDataTable']                = 'customerlicense/customerlicense/cCustomerLicense/FSvCLNDataList';
$route ['customerlicenseContactDataTable']         = 'customerlicense/customerlicense/cCustomerLicense/FSvCLNContactDataList';
$route ['customerlicensePageAdd']                  = 'customerlicense/customerlicense/cCustomerLicense/FSvCLNAddPage';
$route ['customerlicenseEventAdd']                 = 'customerlicense/customerlicense/cCustomerLicense/FSaCLNAddEvent';
$route ['customerlicensePageEdit']                 = 'customerlicense/customerlicense/cCustomerLicense/FSvCLNEditPage';
$route ['customerlicenseEventEdit']                = 'customerlicense/customerlicense/cCustomerLicense/FSaCLNEditEvent';
$route ['customerlicenseEventExportJson']          = 'customerlicense/customerlicense/cCustomerLicense/FSaCLNEditEventExportJson';


$route ['customerlicenseDeleteMulti']              = 'customerlicense/customerlicense/cCustomerLicense/FSoCLNDeleteMulti';
$route ['customerlicenseDelete']                   = 'customerlicense/customerlicense/cCustomerLicense/FSoCLNDelete';
$route ['customerlicenseUniqueValidate/(:any)']    = 'customerlicense/customerlicense/cCustomerLicense/FStCLNUniqueValidate/$1';
// Customer Branch 
$route ['customerbranchList']                      = 'customerlicense/customerlicense/cCustomerBranch/FSvCLBListPage';
$route ['customerbranchDataTable']                 = 'customerlicense/customerlicense/cCustomerBranch/FSvCLBDataList';
$route ['customerbranchPageAdd']                   = 'customerlicense/customerlicense/cCustomerBranch/FSvCLBAddPage';
$route ['customerbranchEventAdd']                  = 'customerlicense/customerlicense/cCustomerBranch/FSaCLBAddEvent';
$route ['customerbranchPageEdit']                  = 'customerlicense/customerlicense/cCustomerBranch/FSvCLBEditPage';
$route ['customerbranchEventEdit']                 = 'customerlicense/customerlicense/cCustomerBranch/FSaCLBEditEvent';
$route ['customerbranchDelete']                    = 'customerlicense/customerlicense/cCustomerBranch/FSoCLBDelete';

// Customer Buy License
$route ['customerBuyLicList']                      = 'customerlicense/customerlicense/cCustomerBuyLic/FSvCBLListPage';
$route ['customerBuyLicDataTable']                 = 'customerlicense/customerlicense/cCustomerBuyLic/FSvCBLDataList';
// $route ['customerBuyLicPageAdd']                   = 'customerlivcense/customerlicense/cCustomerBuyLic/FSvCBLAddPage';
// $route ['customerBuyLicEventAdd']                  = 'customerlicense/customerlicense/cCustomerBuyLic/FSaCBLAddEvent';
$route ['customerBuyLicPageEdit']                  = 'customerlicense/customerlicense/cCustomerBuyLic/FSvCBLEditPage';
$route ['customerBuyLicEventEdit']                 = 'customerlicense/customerlicense/cCustomerBuyLic/FSaCBLEditEvent';
$route ['customerBuyEventExportJson']              = 'customerlicense/customerlicense/cCustomerBuyLic/FSaCBLEventExportJson';
$route ['customerBuyLicActivatePos']               = 'customerlicense/customerlicense/cCustomerBuyLic/FSoCBLEventActivatePos';
$route ['customerBuyLicSyncLicense']               = 'customerlicense/customerlicense/cCustomerBuyLic/FSoCBLEventSyncLicense';


//Branch Address
$route ['BchAddrList']                      = 'customerlicense/customerlicense/cCustomerBranchAddress/FSvCBCHAddressData';
$route ['BchAddrDataTable']                 = 'customerlicense/customerlicense/cCustomerBranchAddress/FSvCBCHAddressDataTable';
$route ['BchAddrPageAdd']                   = 'customerlicense/customerlicense/cCustomerBranchAddress/FSvCBCHAddressCallPageAdd';
$route ['BchAddrEventAdd']                  = 'customerlicense/customerlicense/cCustomerBranchAddress/FSoCBCHAddressAddEvent';
$route ['BchAddrPageEdit']                  = 'customerlicense/customerlicense/cCustomerBranchAddress/FSvCBCHAddressCallPageEdit';
$route ['BchAddrEventEdit']                 = 'customerlicense/customerlicense/cCustomerBranchAddress/FSoCBCHAddressEditEvent';
$route ['BchAddrDelete']                    = 'customerlicense/customerlicense/cCustomerBranchAddress/FSoCBCHAddressDeleteEvent';



// Approve Customer
$route ['ApproveCst']                          = 'customerlicense/ApproveCst/cApproveCst/index';
$route ['ApproveCstList']                      = 'customerlicense/ApproveCst/cApproveCst/FSvCAPCListPage';
$route ['ApproveCstDataTable']                 = 'customerlicense/ApproveCst/cApproveCst/FSvCAPCDataList';
$route ['ApproveCstPageEdit']                  = 'customerlicense/ApproveCst/cApproveCst/FSvCAPCEditPage';
$route ['ApproveCstEventEdit']                 = 'customerlicense/ApproveCst/cApproveCst/FSaCAPCEditEvent';
$route ['ApproveCstOnChecked']                 = 'customerlicense/ApproveCst/cApproveCst/FSaCAPCAproveEvent';
// $route ['ApproveCstExportJson']                 = 'customerlicense/ApproveCst/cApproveCst/FSaCAPCExportEvent';


// Approve License
$route ['ApproveLic']                          = 'customerlicense/ApproveLic/cApproveLic/index';
$route ['ApproveLicList']                      = 'customerlicense/ApproveLic/cApproveLic/FSvCAPLListPage';
$route ['ApproveLicDataTable']                 = 'customerlicense/ApproveLic/cApproveLic/FSvCAPLDataList';
$route ['ApproveLicPageEdit']                  = 'customerlicense/ApproveLic/cApproveLic/FSvCAPLEditPage';
$route ['ApproveLicEventEdit']                 = 'customerlicense/ApproveLic/cApproveLic/FSaCAPLEditEvent';
$route ['ApproveLicOnChecked']                 = 'customerlicense/ApproveLic/cApproveLic/FSaCAPLAproveEvent';

