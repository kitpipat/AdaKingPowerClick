<?php defined ('BASEPATH') or exit ( 'No direct script access allowed' );

// Area (ภูมิภาค)
$route ['area/(:any)/(:any)']           = 'address/area/cArea/index/$1/$2';
$route ['areaList']                     = 'address/area/cArea/FSvCAREListPage';
$route ['areaDataTable']                = 'address/area/cArea/FSvCAREDataList';
$route ['areaPageAdd']                  = 'address/area/cArea/FSvCAREAddPage';
$route ['areaPageEdit']                 = 'address/area/cArea/FSvCAREEditPage';
$route ['areaEventAdd']                 = 'address/area/cArea/FSoCAREAddEvent';
$route ['areaEventEdit']                = 'address/area/cArea/FSoCAREEditEvent';
$route ['areaEventDelete']              = 'address/area/cArea/FSoCAREDeleteEvent';

// Zone (โซน)
$route ['zone/(:any)/(:any)']           = 'address/zone/cZone/index/$1/$2';
$route ['zoneCheckUserLevel']           = 'address/zone/cZone/FSvCZNECheckUserLevel';
$route ['zoneList']                     = 'address/zone/cZone/FSvCZNEListPage';
$route ['zoneDataTable']                = 'address/zone/cZone/FSvCZNEDataList';
$route ['zonePageAdd']                  = 'address/zone/cZone/FSvCZNEAddPage';
$route ['zoneEventAdd']                 = 'address/zone/cZone/FSaCZNEAddEvent';
$route ['zonePageEdit']                 = 'address/zone/cZone/FSvCZNEEditPage';
$route ['zoneEventEdit']                = 'address/zone/cZone/FSaCZNEEditEvent';
$route ['zoneEventDelete']              = 'address/zone/cZone/FSaCZNEDeleteEvent';
//Refer
$route ['zoneEvenAddRefer']             = 'address/zone/cZone/FSvCZNEAddRefer';
$route ['zoneReferTable']               = 'address/zone/cZone/FSvCZNEObjDataList';
$route ['zoneReferEventDelete']         = 'address/zone/cZone/FSaCAGNDeleteEvent';
$route ['zoneReferEventEdit']           = 'address/zone/cZone/FSvCZNEEditRefer';





// Province
$route ['province/(:any)/(:any)']       = 'address/province/cProvince/index/$1/$2';
$route ['provinceList']                 = 'address/province/cProvince/FSvPVNListPage';
$route ['provinceDataTable']            = 'address/province/cProvince/FSvPVNDataList';
$route ['provincePageAdd']              = 'address/province/cProvince/FSvPVNAddPage';
$route ['provinceEventAdd']             = 'address/province/cProvince/FSaPVNAddEvent';
$route ['provincePageEdit']             = 'address/province/cProvince/FSvPVNEditPage';
$route ['provinceEventEdit']            = 'address/province/cProvince/FSaPVNEditEvent';
$route ['provinceEventDelete']          = 'address/province/cProvince/FSaPVNDeleteEvent';

// District
$route ['district/(:any)/(:any)']       = 'address/district/cDistrict/index/$1/$2';
$route ['districtList']             	= 'address/district/cDistrict/FSvDSTListPage';
$route ['districtDataTable']            = 'address/district/cDistrict/FSvDSTDataList';
$route ['districtPageAdd']          	= 'address/district/cDistrict/FSvDSTAddPage';
$route ['districtEventAdd']         	= 'address/district/cDistrict/FSaDSTAddEvent';
$route ['districtPageEdit']         	= 'address/district/cDistrict/FSvDSTEditPage';
$route ['districtEventEdit']        	= 'address/district/cDistrict/FSaDSTEditEvent';
$route ['districtEventDelete']      	= 'address/district/cDistrict/FSaDSTDeleteEvent';
$route ['districtGetPostCode']      	= 'address/district/cDistrict/FSnCDSTGetPostCode';
$route ['districtBrowseProvince']   	= 'address/district/cDistrict/FSoDSTCallProvince';
$route ['BrowsedistrictWhereProvince']  = 'address/district/cDistrict/FSoCPVNCallBrowseDistrictWhereProvince';

// Sub District
$route ['subdistrict/(:any)/(:any)']    = 'address/subdistrict/cSubdistrict/index/$1/$2';
$route ['subdistrictList']              = 'address/subdistrict/cSubdistrict/FSvSDTListPage';
$route ['subdistrictDataTable']         = 'address/subdistrict/cSubdistrict/FSvSDTDataList';
$route ['subdistrictPageAdd']           = 'address/subdistrict/cSubdistrict/FSvSDTAddPage';
$route ['subdistrictPageEdit']          = 'address/subdistrict/cSubdistrict/FSvSDTEditPage';
$route ['subdistrictEventAdd']          = 'address/subdistrict/cSubdistrict/FSoSDTAddEvent';
$route ['subdistrictEventEdit']         = 'address/subdistrict/cSubdistrict/FSoSDTEditEvent';
$route ['subdistrictEventDelete']       = 'address/subdistrict/cSubdistrict/FSoSDTDeleteEvent';


//referencezone (อ้างอิงโซน)
$route ['referencezone/(:any)/(:any)']  = 'pos/referencezone/cReferencezone/index/$1/$2';
$route ['referencezoneList']            = 'pos/referencezone/cReferencezone/FSvCZneReferListPage';
$route ['referencezoneDataTable']       = 'pos/referencezone/cReferencezone/FSvCZneReferDataList';
$route ['referencezonePageAdd']         = 'pos/referencezone/cReferencezone/FSvCZneReferAddPage';
$route ['referencezonePageEdit']        = 'pos/referencezone/cReferencezone/FSvCZneReferEditPage';
$route ['referencezoneEventAdd']        = 'pos/referencezone/cReferencezone/FSoCZneReferAddEvent';
$route ['referencezoneEventEdit']       = 'pos/referencezone/cReferencezone/FSoCZneReferEditEvent';
$route ['referencezoneEventDelete']     = 'pos/referencezone/cReferencezone/FSoCZneReferDeleteEvent';

