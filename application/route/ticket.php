<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );


$route ['EticketBranchNew']                 = 'ticket/branch/cBranchNew/index';
$route ['EticketBranchAjaxNew']             = 'ticket/branch/cBranchNew/FSxCPRKList';
$route ['EticketBranchAjaxSearchNew']       = 'ticket/branch/cBranchNew/FStCPRKAjaxSearch';
// FS Location
$route ['EticketLocationNew/(.*)']          = 'ticket/location/cLocationNew/FSxCLocLocation/$1';
$route ['EticketLocAjaxSearchNew']          = 'ticket/location/cLocationNew/FStCLOCAjaxSearch';
$route ['EticketLocAjaxListNew']            = 'ticket/location/cLocationNew/FSxCLOCList';
$route ['EticketAddLocNew/(.*)']            = 'ticket/location/cLocationNew/FSxCLOCAdd/$1';
$route ['EticketEditLocNew/(.*)/(.*)']      = 'ticket/location/cLocationNew/FSxCLOCEdit/$1/$2';
$route ['EticketAddLocAjaxNew']             = 'ticket/location/cLocationNew/FSxCLocAddAjax';
$route ['EticketSaveLocation']              = 'ticket/location/cLocationNew/FSxCLocSaveLocation';
$route ['EticketDeleteLocation']            = 'ticket/location/cLocationNew/FSxCLocDeleteLocation';
$route ['EticketLoadArea']                  = 'ticket/location/cLocationNew/FSxCLocLoadArea';
$route ['EticketDelAre']                    = 'ticket/location/cLocationNew/FSxCLOCDelAre';
$route ['EticketLocCheck']                  = 'ticket/location/cLocationNew/FSxCLOCCheck';
// FS Level
$route ['EticketLevelListNew']              = 'ticket/level/cLevelNew/FSxCLVLList';
$route ['EticketLevelNew/(.*)']             = 'ticket/level/cLevelNew/FSxCLVL/$1';
$route ['EticketAddLevelNew/(.*)']          = 'ticket/level/cLevelNew/FSxCLVLAdd/$1';
$route ['EticketEditLevelNew/(.*)/(.*)']    = 'ticket/level/cLevelNew/FSxCLVLEdit/$1/$2';
$route ['EticketAddLevelAjax']              = 'ticket/level/cLevelNew/FSxCLVLAddAjax';
$route ['EticketEditLevelAjax']             = 'ticket/level/cLevelNew/FSxCLVLEditAjax';
$route ['EticketDelLevel']                  = 'ticket/level/cLevelNew/FSxCLVLDel';
$route ['EticketLvlCount']                  = 'ticket/level/cLevelNew/FStCLVLCount';
$route ['EticketLvlCheck']                  = 'ticket/level/cLevelNew/FStCLVLCheck';
// FS Zone
$route ['EticketZoneNew/(.*)']              = 'ticket/zone/cZoneNew/FSxCZNE/$1';
$route ['EticketZoneListNew']               = 'ticket/zone/cZoneNew/FSxCZNEList';
$route ['EticketAddZoneNew/(.*)']           = 'ticket/zone/cZoneNew/FSxCZNEAdd/$1';
$route ['EticketEditZoneNew/(.*)']          = 'ticket/zone/cZoneNew/FSxCZNEEdit/$1';
$route ['EticketZneCount']                  = 'ticket/zone/cZoneNew/FStCZNECount';
$route ['EticketAddZoneAjax']               = 'ticket/zone/cZoneNew/FSxCZNEAddAjax';
$route ['EticketEditZoneAjax']              = 'ticket/zone/cZoneNew/FSxCZNEEditAjax';
$route ['EticketZoneDel']                   = 'ticket/zone/cZoneNew/FSxCZNEDel';
$route ['EticketDelImgZne']                 = 'ticket/zone/cZoneNew/FSxCZNEDelImg';

// FS Gate
$route ['EticketGateNew/(.*)']              = 'ticket/gate/cGateNew/FSxCGTE/$1';
$route ['EticketAddGateNew/(.*)']           = 'ticket/gate/cGateNew/FSxCGTEAdd/$1';
$route ['EticketDelGateNew']                = 'ticket/gate/cGateNew/FSxCGTEDel';
$route ['EticketGateListNew']               = 'ticket/gate/cGateNew/FSxCGTEList';
$route ['EticketEditGateNew/(.*)/(.*)']     = 'ticket/gate/cGateNew/FSxCGTEEdit/$1/$2';
$route ['EticketGateCheck']                 = 'ticket/gate/cGateNew/FStCGTECheck';
$route ['EticketGateCount']                 = 'ticket/gate/cGateNew/FSxCGTECount';
$route ['EticketAddGateAjax']               = 'ticket/gate/cGateNew/FSxCGTEAddAjax';
$route ['EticketEditGateAjax']              = 'ticket/gate/cGateNew/FSxCGTEEditAjax';
// Layout
$route ['EticketLayoutNew/(.*)']            = 'ticket/layout/cLayoutNew/FSxCLOT/$1';
$route ['EticketLayoutAddNew/(.*)']         = 'ticket/layout/cLayoutNew/FSxCLOTAdd/$1';
$route ['EticketLayoutDelImg']              = 'ticket/layout/cLayoutNew/FSxCLOTDelImg';
// สถานที่จัดการวันหยุด
$route ['EticketLocDayOffNew/(.*)']         = 'ticket/dayoff/cDayoffNew/FSxCDOF/$1';
$route ['EticketLocDayOffAddNew/(.*)']      = 'ticket/dayoff/cDayoffNew/FSxCDOFAdd/$1';
$route ['EticketLocDayOffEditNew/(.*)/(.*)']= 'ticket/dayoff/cDayoffNew/FSxCDOFEdit/$1/$2';
$route ['EticketLocDayOff/(.*)']            = 'ticket/dayoff/cDayoffNew/FSxCDOF/$1';
$route ['EticketLocDayOffList']             = 'ticket/dayoff/cDayoffNew/FSxCDOFList';
$route ['EticketLocDayOffCount']            = 'ticket/dayoff/cDayoffNew/FStCDOFCount';
$route ['EticketLocDayOffAdd/(.*)']         = 'ticket/dayoff/cDayoffNew/FSxCDOFAdd/$1';
$route ['EticketLocDayOffAjax']             = 'ticket/dayoff/cDayoffNew/FSxCDOFAjax';
$route ['EticketLocDayOffEdit/(.*)/(.*)']   = 'ticket/dayoff/cDayoffNew/FSxCDOFEdit/$1/$2';
$route ['EticketLocDayOffEditAjax']         = 'ticket/dayoff/cDayoffNew/FSxCDOFEditAjax';
$route ['EticketLocDayOffDel']              = 'ticket/dayoff/cDayoffNew/FSxCDOFDel';
// Room
$route ['EticketRoomNew/(.*)/(.*)']         = 'ticket/room/cRoomNew/FSxCROM/$1/$2';
$route ['EticketRoomListNew']               = 'ticket/room/cRoomNew/FSxCROMList';
// Seat
$route ['EticketSeatNew/(.*)/(.*)/(.*)']    = 'ticket/seat/cSeatNew/FSxCSETSeat/$1/$2/$3';
$route ['EticketSeatListNew']               = 'ticket/seat/cSeatNew/FSxCSETSeatList';
$route ['EticketCreateSeatNew']             = 'ticket/seat/cSeatNew/FSxCSETCreateSeat';

// Branch
$route ['EticketBranch']                    = 'ticket/branch/cBranchNew/index';
$route ['EticketBranchAjax']                = 'ticket/branch/cBranchNew/FSxCPRKList';
$route ['EticketBranchAjaxSearch']          = 'ticket/branch/cBranchNew/FStCPRKAjaxSearch';
$route ['EticketSaveBranch']                = 'ticket/branch/cBranchNew/FSxCPRKSave';
$route ['EticketDeleteBranch']              = 'ticket/branch/cBranchNew/FSxCPRKDelete';
$route ['EticketBranchDetail']              = 'ticket/branch/cBranchNew/FSxCPRKDetail';
$route ['EticketBranchCheck']               = 'ticket/branch/cBranchNew/FSxCPRKCheck';
$route ['EticketDistrict']                  = 'ticket/branch/cBranchNew/FSxCPRKDistrict';
$route ['EticketProvince']                  = 'ticket/branch/cBranchNew/FSxCPRKProvince';
$route ['EticketAddBranch']                 = 'ticket/branch/cBranchNew/FSxCPRKAdd';
$route ['EticketAddBranchAjax']             = 'ticket/branch/cBranchNew/FSxCPRKAddAjax';
$route ['EticketEditBranch/(.*)']           = 'ticket/branch/cBranchNew/FSxCPRKEdit/$1';
$route ['EticketEditBranchAjax']            = 'ticket/branch/cBranchNew/FSxCPRKEditAjax';
$route ['EticketDelImgBranch']              = 'ticket/branch/cBranchNew/FSxCPRKDelImgPrk';
$route ['branchPageAdd']                    = 'company/branch/cBranch/FSvCBCHAddPage';
$route ['branchCallPageEdit']               = 'ticket/branch/cBranchNew/FSvCBCHCallPageEdit';

// FS Location
$route ['EticketLocation/(.*)']             = 'ticket/location/cLocationNew/FSxCLocLocation/$1';
$route ['EticketSaveLocation']              = 'ticket/location/cLocationNew/FSxCLocSaveLocation';
$route ['EticketLocAjaxList']               = 'ticket/location/cLocationNew/FSxCLOCList';
$route ['EticketLocAjaxSearch']             = 'ticket/location/cLocationNew/FStCLOCAjaxSearch';
$route ['EticketDeleteLocation']            = 'ticket/location/cLocationNew/FSxCLocDeleteLocation';
$route ['EticketLoadArea']                  = 'ticket/location/cLocationNew/FSxCLocLoadArea';
$route ['EticketDelAre']                    = 'ticket/location/cLocationNew/FSxCLOCDelAre';
$route ['EticketLocCheck']                  = 'ticket/location/cLocationNew/FSxCLOCCheck';
$route ['EticketAddLoc/(.*)']               = 'ticket/location/cLocationNew/FSxCLOCAdd/$1';
$route ['EticketAddLocAjax']                = 'ticket/location/cLocationNew/FSxCLocAddAjax';
$route ['EticketEditLoc/(.*)/(.*)']         = 'ticket/location/cLocationNew/FSxCLOCEdit/$1/$2';
$route ['EticketEditLocAjax']               = 'ticket/location/cLocationNew/FSxCLOCEditAjax';
$route ['EticketDelImgLoc']                 = 'ticket/location/cLocationNew/FSxCLOCDelImg';

// Agency
$route ['agency/(:any)/(:any)']             = 'ticket/agency/cAgency/index/$1/$2';
$route ['agencyList']                       = 'ticket/agency/cAgency/FStCAGNList';
$route ['agencyDataTable']                  = 'ticket/agency/cAgency/FSxCANGDataTable';
$route ['agencyPageAdd']                    = 'ticket/agency/cAgency/FSxCAGNAddPage';
$route ['agencyPageEdit']                   = 'ticket/agency/cAgency/FSvCAGNEditPage';
$route ['agencyEventAdd']                   = 'ticket/agency/cAgency/FSaCAGNAddEvent';
$route ['agencyEventEdit']                  = 'ticket/agency/cAgency/FSaCAGNEditEvent';
$route ['agencyEventDelete']                = 'ticket/agency/cAgency/FSaCAGNDeleteEvent';



//group Agency 
$route ['EticketAgency/group']              = 'ticket/agency/cAgency/FSxCAGEGroup';
$route ['EticketAgency/groupAjaxList']      = 'ticket/agency/cAgency/FSxCAGEGroupAjaxList';
$route ['EticketAgency/groupCount']         = 'ticket/agency/cAgency/FSxCAGEGroupCount';
$route ['EticketAgency/deleteGroup']        = 'ticket/agency/cAgency/FSxCAGEGroupDelete';
$route ['EticketAgency/EditGroup/(.*)']     = 'ticket/agency/cAgency/FSxCAGEGroupEdit/$1';
$route ['EticketAgency/EditGroupAjax']      = 'ticket/agency/cAgency/FSxCAGEGroupEditAjax';
$route ['EticketAgency/AddGroup']           = 'ticket/agency/cAgency/FSxCAGEGroupAdd';
$route ['EticketAgency/AddGroupAjax']       = 'ticket/agency/cAgency/FSxCAGEGroupAddAjax';

//group Type
$route ['EticketAgency/Type']               = 'ticket/agency/cAgency/FSxCAGEType';
$route ['EticketAgency/TypeAjaxList']       = 'ticket/agency/cAgency/FSxCAGETypeAjaxList';
$route ['EticketAgency/TypeCount']          = 'ticket/agency/cAgency/FSxCAGETypeCount';
$route ['EticketAgency/deleteType']         = 'ticket/agency/cAgency/FSxCAGETypeDelete';
$route ['EticketAgency/EditType/(.*)']      = 'ticket/agency/cAgency/FSxCAGETypeEdit/$1';
$route ['EticketAgency/EditTypeAjax']       = 'ticket/agency/cAgency/FSxCAGETypeEditAjax';
$route ['EticketAgency/AddType']            = 'ticket/agency/cAgency/FSxCAGETypeAdd';
$route ['EticketAgency/AddTypeAjax']        = 'ticket/agency/cAgency/FSxCAGETypeAddAjax';

//Promotion
$route ['EticketPromotion']                 = 'ticket/promotion/cPromotion/FSxCPMT';
$route ['EticketPromotionList']             = 'ticket/promotion/cPromotion/FSxCPMTList';
$route ['EticketPromotionCount']            = 'ticket/promotion/cPromotion/FSxCPMTCount';
$route ['EticketPromotionDel']              = 'ticket/promotion/cPromotion/FSxCPMTDel';
$route ['EticketPromotionAdd']              = 'ticket/promotion/cPromotion/FSxCPMTAdd';
$route ['EticketPromotionAddAjax']          = 'ticket/promotion/cPromotion/FSxCPMTAddAjax';
$route ['EticketPromotionEdit/(.*)']        = 'ticket/promotion/cPromotion/FSxCPMTEdit/$1';
$route ['EticketPromotionEditAjax']         = 'ticket/promotion/cPromotion/FSxCPMTEditAjax';
$route ['EticketPromotionPkgList']          = 'ticket/promotion/cPromotion/FSxCPMTPkgList';
$route ['EticketPromotionPkgCount']         = 'ticket/promotion/cPromotion/FSxCPMTPkgCount';
$route ['EticketPromotionBchList']          = 'ticket/promotion/cPromotion/FSxCPMTBchList';
$route ['EticketPromotionBchCount']         = 'ticket/promotion/cPromotion/FSxCPMTBchCount';
$route ['EticketPromotionAgnList']          = 'ticket/promotion/cPromotion/FSxCPMTAgnList';
$route ['EticketPromotionAgnCount']         = 'ticket/promotion/cPromotion/FSxCPMTAgnCount';
$route ['EticketPromotionCstList']          = 'ticket/promotion/cPromotion/FSxCPMTCstList';
$route ['EticketPromotionCstCount']         = 'ticket/promotion/cPromotion/FSxCPMTCstCount';
$route ['EticketPromotionGenKey']           = 'ticket/promotion/cPromotion/FSxCPMTGenKey';
$route ['EticketPromotionDelPkg']           = 'ticket/promotion/cPromotion/FSxCPMTDelPkg';
$route ['EticketPromotionDelBch']           = 'ticket/promotion/cPromotion/FSxCPMTDelBch';
$route ['EticketPromotionDelGrp']           = 'ticket/promotion/cPromotion/FSxCPMTDelGrp';
$route ['EticketPromotionApv']              = 'ticket/promotion/cPromotion/FSxCPMTApv';
$route ['EticketPromotionChkCode']          = 'ticket/promotion/cPromotion/FSxCPMTChkCode';

// Customer
$route ['EticketCustomer']                  = 'ticket/customer/cCustomer/FSxCCST';
$route ['EticketCustomer/count']            = 'ticket/customer/cCustomer/FStCCSTCount';
$route ['EticketCustomer/ajaxList']         = 'ticket/customer/cCustomer/FSxCCSTAjaxList';
$route ['EticketCustomer/add']              = 'ticket/customer/cCustomer/FSxCCSTAdd';
$route ['EticketCustomer/addAjax']          = 'ticket/customer/cCustomer/FSxCCSTAddAjax';
$route ['EticketCustomer/edit/(.*)']        = 'ticket/customer/cCustomer/FSxCCSTEdit/$1';
$route ['EticketCustomer/editAjax']         = 'ticket/customer/cCustomer/FSxCCSTEditAjax';
$route ['EticketCustomer/delete']           = 'ticket/customer/cCustomer/FSxCCSTDelete';
$route ['EticketCustomer/view/(.*)']        = 'ticket/customer/cCustomer/FSxCCSTView/$1';
$route ['EticketCustomer/checkemail']       = 'ticket/customer/cCustomer/FSxCCSTCheckEmail';
$route ['EticketCustomer/DelImg']           = 'ticket/customer/cCustomer/FSxCCSTDelImg';

// category customer
$route ['EticketCustomer/category']             = 'ticket/customer/cCustomer/FSxCCSTCategory';
$route ['EticketCustomer/categoryAjaxList']     = 'ticket/customer/cCustomer/FSxCCSTCategoryAjaxList';
$route ['EticketCustomer/categoryCount']        = 'ticket/customer/cCustomer/FSxCCSTCategoryCount';
$route ['EticketCustomer/deleteCategory']       = 'ticket/customer/cCustomer/FSxCCSTCategoryDelete';
$route ['EticketCustomer/EditCategory/(.*)']    = 'ticket/customer/cCustomer/FSxCCSTCategoryEdit/$1';
$route ['EticketCustomer/EditCategoryAjax']     = 'ticket/customer/cCustomer/FSxCCSTCategoryEditAjax';
$route ['EticketCustomer/AddCategory']          = 'ticket/customer/cCustomer/FSxCCSTCategoryAdd';
$route ['EticketCustomer/AddCategoryAjax']      = 'ticket/customer/cCustomer/FSxCCSTCategoryAddAjax';

// group customer **
$route ['EticketCustomer/group']                = 'ticket/customer/cCustomer/FSxCCSTGroup';
$route ['EticketCustomer/groupAjaxList']        = 'ticket/customer/cCustomer/FSxCCSTGroupAjaxList';
$route ['EticketCustomer/groupCount']           = 'ticket/customer/cCustomer/FSxCCSTGroupCount';
$route ['EticketCustomer/deleteGroup']          = 'ticket/customer/cCustomer/FSxCCSTGroupDelete';
$route ['EticketCustomer/EditGroup/(.*)']       = 'ticket/customer/cCustomer/FSxCCSTGroupEdit/$1';
$route ['EticketCustomer/EditGroupAjax']        = 'ticket/customer/cCustomer/FSxCCSTGroupEditAjax';
$route ['EticketCustomer/AddGroup']             = 'ticket/customer/cCustomer/FSxCCSTGroupAdd';
$route ['EticketCustomer/AddGroupAjax']         = 'ticket/customer/cCustomer/FSxCCSTGroupAddAjax';


// Package
$route ['EticketPackage']                                       = 'ticket/package/cPackage/index';
$route ['EticketPackageCount']                                  = 'ticket/package/cPackage/FStCPKGCount';
$route ['EticketPackageList']                                   = 'ticket/package/cPackage/FSxCPKGList';
$route ['EticketDeletePackage']                                 = 'ticket/package/cPackage/FSxCPKGDelete';
$route ['EticketPackage_PdtSearch']                             = 'ticket/package/cPackage/FSxCPKGPdtListSearch';
$route ['EticketPackage_PdtSelectedList']                       = 'ticket/package/cPackage/FSxCPKGPdtSelectedList';
$route ['EticketPCK_AddPackage']                                = 'ticket/package/cPackage/FSxCPKGAddPackage';
$route ['EticketPck_Call_Page_AddPackage']                      = 'ticket/package/cPackage/FSxCPKGCallPageAddPackage';
$route ['EticketPackage_CountCheckPkgNoPdt']                    = 'ticket/package/cPackage/FSxCPKGCountCheckPkgNoPdt';
$route ['EticketPackage_GETPageDialogPkgNoPdt']                 = 'ticket/package/cPackage/FSxCPKGGETPageDialogPkgNoPdt';
$route ['EticketPackage_DelPkgNoPdt']                           = 'ticket/package/cPackage/FSxCPKGDelPkgNoPdt';
$route ['EticketPackage_CallPageEditPkg']                       = 'ticket/package/cPackage/FSxCPKGCallPageEditPkg';
$route ['EticketPackage_CallPageAddPkg']                        = 'ticket/package/cPackage/FSxCPKGCallPageAddPkg';
$route ['EticketPackage_EditPackage']                           = 'ticket/package/cPackage/FSxCPKGEditPkg';
$route ['EticketPackage_CallPagePkgDetail']                     = 'ticket/package/cPackage/FSxCPKGCallPagePkgDetail';
$route ['EticketPackage_CallPagePkgModel']                      = 'ticket/package/cPackage/FSxCPKGCallPagePkgModel';
$route ['EticketPackage_AddPkgModel']                           = 'ticket/package/cPackage/FSxCPKGAddPkgModel';
$route ['EticketPackage_DelPkgModelAdmin']                      = 'ticket/package/cPackage/FSxCPKGDelPkgModelAdmin';
$route ['EticketPackage_CallPageModalModelCustomer']            = 'ticket/package/cPackage/FSxCPKGCallPageModalModelCustomer';
$route ['EticketPackage_CallPagePkgModalCstZone']               = 'ticket/package/cPackage/FSxCPKGCallPagePkgModalCstZone';
$route ['EticketPackage_AddPkgModelZone']                       = 'ticket/package/cPackage/FSxCPKGAddPkgModelZone';
$route ['EticketPackage_CheckPkgModelZoneMore2']                = 'ticket/package/cPackage/FSxCPKGCheckPkgModelZoneMore2';
$route ['EticketPackage_AddPkgModelZoneStep2']                  = 'ticket/package/cPackage/FSnCPKGAddPkgModelZoneStep2';
$route ['EticketPackage_DelPkgModelCustomer']                   = 'ticket/package/cPackage/FSxCPKGDelPkgModelCustomer';
$route ['EticketPackage_CallPagePkgProduct']                    = 'ticket/package/cPackage/FSxCPKGCallPagePkgProduct';
$route ['EticketPackage_GetSelectPdtHTML']                      = 'ticket/package/cPackage/FSxCPKGGetSelectPdtHTML';
$route ['EticketPackage_AddPkgModelProduct']                    = 'ticket/package/cPackage/FSxCPKGAddPkgModelProduct';
$route ['EticketPackage_DelPkgProduct']                         = 'ticket/package/cPackage/FSxCPKGDelPkgProduct';
$route ['EticketPackage_EditPkgProduct']                        = 'ticket/package/cPackage/FSxCPKGEditPkgProduct';
$route ['EticketPackage_CallPageModelAndPdtPanal']              = 'ticket/package/cPackage/FSxCPKGCallPageModelAndPdtPanal';
$route ['EticketPackage_CallPagePdtPriSpcPri']                  = 'ticket/package/cPackage/FSxCPKGCallPagePdtPriSpcPri';
$route ['EticketPackage_CallPagePdtPriSpcPriByDOWPanal']        = 'ticket/package/cPackage/FSxCPKGCallPagePdtPriSpcPriByDOWPanal';
$route ['EticketPackage_CallPagePdtPriSpcPriByHLDPanal']        = 'ticket/package/cPackage/FSxCPKGCallPagePdtPriSpcPriByHLDPanal';
$route ['EticketPackage_CallPagePdtSpcPriByWeekPanal']          = 'ticket/package/cPackage/FSxCPKGCallPagePdtSpcPriByWeekPanal';
$route ['EticketPackage_CallPagePdtPriSpcPriByBKGPanal']        = 'ticket/package/cPackage/FSxCPKGCallPagePdtPriSpcPriByBKGPanal';
$route ['EticketPackage_AddPkgPdtPriBKG']                       = 'ticket/package/cPackage/FSnCPKGAddPkgPdtPriBKG';
$route ['EticketPackage_EditPkgPdtPriBKG']                      = 'ticket/package/cPackage/FSxCPKGEditPkgPdtPriBKG';
$route ['EticketPackage_DelPkgPdtPriBKG']                       = 'ticket/package/cPackage/FSxCPKGDelPdtGrpPriBKG';
$route ['EticketPackage_DelImgPkg']                             = 'ticket/package/cPackage/FSxCPKGDelImg';
$route ['EticketPackage_GetSelectModelHTML']                    = 'ticket/package/cPackage/FSxCPKGGetSelectModelHTML';
$route ['EticketPackage_AddPackage']                            = 'ticket/package/cPackage/FSxCPKGAddPkg';
$route ['EticketPackage_ApprovePkg']                            = 'ticket/package/cPackage/FSxCPKGApprovePkg';
$route ['EticketPackage_CallPagePkgSpcPriByGrp']                = 'ticket/package/cPackage/FSxCPKGCallPagePkgSpcPriByGrp';
$route ['EticketPackage_GetSelectPkgGrpPriHTML']                = 'ticket/package/cPackage/FStCPKGGetSelectPkgGrpPriHTML';
$route ['EticketPackage_AddPkgGrpPri']                          = 'ticket/package/cPackage/FSnCPKGAddSpcPkgGrpPri';
$route ['EticketPackage_EditPkgSpcGrpPri']                      = 'ticket/package/cPackage/FSnCPKGEditPkgSpcGrpPri';
$route ['EticketPackage_DelPkgSpcGrpPri']                       = 'ticket/package/cPackage/FSxCPKGDelPkgSpcGrpPri';
$route ['EticketPackage_CallPagePdtGrpPri']                     = 'ticket/package/cPackage/FSxCPKGCallPagePdtGrpPri';
$route ['EticketPackage_AddPkgPdtGrpPri']                       = 'ticket/package/cPackage/FSnCPKGAddPkgPdtGrpPri';
$route ['EticketPackage_DelPkgPdtGrpPri']                       = 'ticket/package/cPackage/FSxCPKGDelPkgPdtGrpPri';
$route ['EticketPackage_CallPagePkgGrpPriSpcPri']               = 'ticket/package/cPackage/FSxCPKGCallPagePkgGrpPriSpcPri';
$route ['EticketPackage_CallPagePkgGrpPriSpcPriByDOWPanal']     = 'ticket/package/cPackage/FSxCPKGCallPagePkgGrpPriSpcPriByDOWPanal';
$route ['EticketPackage_EditGrpPriSpcPriByDOW']                 = 'ticket/package/cPackage/FSnCPKGEditGrpPriSpcPriByDOW';
$route ['EticketPackage_CallPagePkgGrpPriSpcPriByHLDPanal']     = 'ticket/package/cPackage/FSxCPKGCallPagePkgGrpPriSpcPriByHLDPanal';
$route ['EticketPackage_EditPdtPriSpcPriByDOW']                 = 'ticket/package/cPackage/FSnCPKGEditPdtPriSpcPriByDOW';
$route ['EticketPackage_CallPagePkgGrpPriSpcPriByBKGPanal']     = 'ticket/package/cPackage/FSxCPKGCallPagePkgGrpPriSpcPriByBKGPanal';
$route ['EticketPackage_AddPkgGrpPriBKG']                       = 'ticket/package/cPackage/FSnCPKGAddPkgGrpPriBKG';
$route ['EticketPackage_EditPkgGrpPriBKG']                      = 'ticket/package/cPackage/FSxCPKGEditPkgGrpPriBKG';
$route ['EticketPackage_DelPkgGrpPriBKG']                       = 'ticket/package/cPackage/FSxCPKGDelPkgGrpPriBKG';
$route ['EticketPackage_GetSelectTchGrpByPmoHTML']              = 'ticket/package/cPackage/FSxCPKGGetSelectTchGrpByPmoHTML';
$route ['EticketPackage_CallPagePkgModalCstShowTime']           = 'ticket/package/cPackage/FSxCPKGCallPagePkgModalCstShowTime';
$route ['EticketPackage_CallPageViewDetailLocShowTime']         = 'ticket/package/cPackage/FSxCPKGCallPageViewDetailLocShowTime';
$route ['EticketPackage_CallPageTimeTableHDPanal']              = 'ticket/package/cPackage/FSxCPKGCallPageTimeTableHDPanal';
$route ['EticketPackage_AddLocShowTime']                        = 'ticket/package/cPackage/FSnCPKGAddLocShowTime';
$route ['EticketPackage_CallPageLocShowTimePanal']              = 'ticket/package/cPackage/FSnCPKGCallPageLocShowTimePanal';
$route ['EticketPackage_DelPkgLocShowTimePanal']                = 'ticket/package/cPackage/FSxCPKGDelPkgLocShowTimePanal';
$route ['EticketPackage_CheckLocHaveShowTime']                  = 'ticket/package/cPackage/FSxCPKGCheckLocHaveShowTime';
$route ['EticketPackage_CallPagePpkPriSpcPri']                  = 'ticket/package/cPackage/FSxCPKGCallPagePpkPriSpcPri';
$route ['EticketPackage_CallPagePkgPriByDOWPanal']              = 'ticket/package/cPackage/FSxCPKGCallPagePkgPriByDOWPanal';
$route ['EticketPackage_EditPkgPriSpcPriByDOW']                 = 'ticket/package/cPackage/FSnCPKGEditPkgPriSpcPriByDOW';
$route ['EticketPackage_CallPagePkgPriByBKGPanal']              = 'ticket/package/cPackage/FSxCPKGCallPagePkgPriByBKGPanal';
$route ['EticketPackage_CallPagePkgPriByHLDPanal']              = 'ticket/package/cPackage/FSxCPKGCallPagePkgPriByHLDPanal';
$route ['EticketPackage_AddPkgPriBKG']                          = 'ticket/package/cPackage/FSnCPKGAddPkgPriBKG';
$route ['EticketPackage_EditPkgPriBKG']                         = 'ticket/package/cPackage/FSxCPKGEditPkgPriBKG';
$route ['EticketPackage_DelPkgPriBKG']                          = 'ticket/package/cPackage/FSxCPKGDelPkgPriBKG';
$route ['EticketPackage_GetPdtFullCalendar']                    = 'ticket/package/cPackage/FSoCPKGGetPdtFullCalendar';
$route ['EticketPackage_GetPdtFullCalendarList']                = 'ticket/package/cPackage/FSoCPKGGetPdtFullCalendarList';
$route ['EticketPackage_AddPdtSpcPriHLD']                       = 'ticket/package/cPackage/FSnCPKGAddPdtSpcPriHLD';
$route ['EticketPackage_DelPdtSpcPriHLD']                       = 'ticket/package/cPackage/FSnCPKGDelPdtSpcPriHLD';
$route ['EticketPackage_GetGrpFullCalendar']                    = 'ticket/package/cPackage/FSoCPKGGetGrpFullCalendar';
$route ['EticketPackage_GetGrpFullCalendarList']                = 'ticket/package/cPackage/FSoCPKGGetGrpFullCalendarList';
$route ['EticketPackage_AddGrpSpcPriHLD']                       = 'ticket/package/cPackage/FSnCPKGAddGrpSpcPriHLD';
$route ['EticketPackage_DelGrpSpcPriHLD']                       = 'ticket/package/cPackage/FSnCPKGDelGrpSpcPriHLD';
$route ['EticketPackage_GetPkgFullCalendar']                    = 'ticket/package/cPackage/FSoCPKGGetPkgFullCalendar';
$route ['EticketPackage_GetPkgFullCalendarList']                = 'ticket/package/cPackage/FSoCPKGGetPkgFullCalendarList';
$route ['EticketPackage_AddPkgSpcPriHLD']                       = 'ticket/package/cPackage/FSnCPKGAddPkgSpcPriHLD';
$route ['EticketPackage_DelPkgSpcPriHLD']                       = 'ticket/package/cPackage/FSnCPKGDelPkgSpcPriHLD';
$route ['EticketPackage_CheckMaxPark']                          = 'ticket/package/cPackage/FSxCPKGCheckMaxPark';
$route ['EticketPackage_CheckPkgZone']                          = 'ticket/package/cPackage/FSxCPKGCheckPkgZone';

// ShowTime
$route ['EticketShowTime/(.*)']                                 = 'ticket/showtime/cShowTime/FSxCSHT/$1';
$route ['EticketAddShowTime/(.*)']                              = 'ticket/showtime/cShowTime/FSxCSHTAdd/$1';
$route ['EticketAddShowTimeAjax']                               = 'ticket/showtime/cShowTime/FSxCSHTAddAjax';
$route ['EticketShowTimeLocList']                               = 'ticket/showtime/cShowTime/FSxCSHTLocList';
$route ['EticketShowTimeAddLoc']                                = 'ticket/showtime/cShowTime/FSxCSHTAddLoc';
$route ['EticketDelShowTime']                                   = 'ticket/showtime/cShowTime/FSxCSHTDelShowTime';
$route ['EticketShowTimeLocCount']                              = 'ticket/showtime/cShowTime/FSxCSHTLocCount';
$route ['EticketShowTimeLocLoadList']                           = 'ticket/showtime/cShowTime/FSxCSHTLocLoadList';
// ShowTime Package
$route ['EticketShowTimePackageList/(.*)/(.*)']                 = 'ticket/showtime/cShowTime/FSxCSHTShowTimePackageList/$1/$2';
$route ['EticketShowTimeAddPackage/(.*)/(.*)']                  = 'ticket/showtime/cShowTime/FSxCSHTShowTimeAddPackage/$1/$2';
$route ['EticketShowTimeAddPackageAjax']                        = 'ticket/showtime/cShowTime/FSxCSHTShowTimeAddPackageAjax';
$route ['EticketShowTimeDelPackage']                            = 'ticket/showtime/cShowTime/FSxCSHTShowTimeDelPackage';


// Verification
$route ['EticketVerification']                                  = 'ticket/verification/cVerification/FSxCVFN';
$route ['EticketVerificationAjaxList']                          = 'ticket/verification/cVerification/FSxCVFNAjaxList';
$route ['EticketVerificationCount']                             = 'ticket/verification/cVerification/FSxCVFNCount';
$route ['EticketVerificationApprove']                           = 'ticket/verification/cVerification/FSxCVFNApprove';
$route ['EticketTicketCancellation_Count']                      = 'ticket/verification/cVerification/FSxCVFNCancellationCount';
$route ['EticketTicketCancellation']                            = 'ticket/verification/cVerification/FSxCVFNTicketCancellation';
$route ['EticketTicketCancellationAjax']                        = 'ticket/verification/cVerification/FSxCVFNTicketCancellationAjax';
$route ['EticketCancelTicket']                                  = 'ticket/verification/cVerification/FSxCVFNCancelTicket';


// Natt Set Route Time Table List 14/11/60 12:40 PM
$route ['EticketTimeTable/TimeTableList/(.*)/(.*)']             = 'ticket/timelist/cTimeList/FSxCTLTHD/$1/$2';
$route ['EticketTimeTable/TimeTablePickList']                   = 'ticket/timelist/cTimeList/FSxCTLTPickList';
$route ['EticketTimeTable/TimeDOWAddList']                      = 'ticket/timelist/cTimeList/FSxCTLTTimeDOWAddList';
$route ['EticketTimeTable/DelTimeDOW']                          = 'ticket/timelist/cTimeList/FSxCTLTDelTimeDOW';
$route ['EticketTimeTable/TimeHolidayAddList']                  = 'ticket/timelist/cTimeList/FSxCTLTTimeHolidayAddList';
$route ['EticketTimeTable/DelTimeHoliday']                      = 'ticket/timelist/cTimeList/FSxCTLTDelTimeHoliday';
$route ['EticketTimeTable/FullCalendarEvent']                   = 'ticket/timelist/cTimeList/FSxCTLTFullCalendarEvent';
$route ['EticketTimeTable/FullCalendarEventList']               = 'ticket/timelist/cTimeList/FSxCTLTFullCalendarEventList';
$route ['EticketTimeTable/TimeTableSTAjaxList']                 = 'ticket/timelist/cTimeList/FSxCTLTTimeTableSTAjaxList';
$route ['EticketTimeTable/TimeTableSTCount']                    = 'ticket/timelist/cTimeList/FStCTLTTimeTableSTCount';
$route ['EticketTimeTable/AddTimeTableST/(.*)/(.*)']            = 'ticket/timelist/cTimeList/FSxCTLTTimeTableSTAdd/$1/$2';
$route ['EticketTimeTable/AddTimeTableSTAjax']                  = 'ticket/timelist/cTimeList/FSxCTLTTimeTableSTAddAjax';
$route ['EticketTimeTable/EditTimeTableST/(.*)/(.*)/(.*)']      = 'ticket/timelist/cTimeList/FSxCTLTTimeTableSTEdit/$1/$2/$3';
$route ['EticketTimeTable/EditTimeTableSTAjax']                 = 'ticket/timelist/cTimeList/FSxCTLTTimeTableSTEditAjax';
$route ['EticketTimeTable/DeleteTimeTableST']                   = 'ticket/timelist/cTimeList/FSxCTLTTimeTableSTDel';
$route ['EticketTimeTable/TimeTableSTPickList']                 = 'ticket/timelist/cTimeList/FSxCTLTSTPickList';
// Time Table รอบการแสดง
$route ['EticketTimeTable']                             = 'ticket/timetable/cTimeTable/FSxCTTB';
$route ['EticketTimeTable/TimeTableAjaxList']           = 'ticket/timetable/cTimeTable/FSxCTTBAjaxList';
$route ['EticketTimeTable/TimeTableCount']              = 'ticket/timetable/cTimeTable/FStCTTBCount';
$route ['EticketTimeTable/AddTimeTable']                = 'ticket/timetable/cTimeTable/FSxCTTBAdd';
$route ['EticketTimeTable/AddTimeTableAjax']            = 'ticket/timetable/cTimeTable/FSxCTTBAddAjax';
$route ['EticketTimeTable/EditTimeTable/(.*)']          = 'ticket/timetable/cTimeTable/FSxCTTBEdit/$1';
$route ['EticketTimeTable/EditTimeTableAjax']           = 'ticket/timetable/cTimeTable/FSxCTTBEditAjax';
$route ['EticketTimeTable/DeleteTimeTable']             = 'ticket/timetable/cTimeTable/FSxCTTBDelete';
// รอบการแสดง
$route ['EticketTimeTableDT/(.*)']                      = 'ticket/timetable/cTimeTable/FSxCTTBDt/$1';
$route ['EticketTimeTable/TimeTableDTAjaxList']         = 'ticket/timetable/cTimeTable/FSxCTTBDtAjaxList';
$route ['EticketTimeTable/TimeTableDTCount']            = 'ticket/timetable/cTimeTable/FStCTTBDtCount';
$route ['EticketTimeTable/AddTimeTableDT/(.*)']         = 'ticket/timetable/cTimeTable/FSxCTTBDtAdd/$1';
$route ['EticketTimeTable/AddTimeTableDTAjax']          = 'ticket/timetable/cTimeTable/FSxCTTBDtAddAjax';
$route ['EticketTimeTable/EditTimeTableDT/(.*)/(.*)']   = 'ticket/timetable/cTimeTable/FSxCTTBDtEdit/$1/$2';
$route ['EticketTimeTable/EditTimeTableDTAjax']         = 'ticket/timetable/cTimeTable/FSxCTTBDtEditAjax';
$route ['EticketTimeTable/DeleteTimeTableDT']           = 'ticket/timetable/cTimeTable/FSxCTTBDtDelete';
// Event
$route ['EticketEvent']                                 = 'ticket/event/cEvent/FSxCEVT';
$route ['EticketEventList']                             = 'ticket/event/cEvent/FSxCEVTList';
$route ['EticketEventCount']                            = 'ticket/event/cEvent/FSxCEVTCount';
$route ['EticketAddEvent']                              = 'ticket/event/cEvent/FSxCEVTAdd';
$route ['EticketAddEventAjax']                          = 'ticket/event/cEvent/FSxCEVTAddAjax';
$route ['EticketEditEvent/(.*)']                        = 'ticket/event/cEvent/FSxCEVTEdit/$1';
$route ['EticketEditEventAjax']                         = 'ticket/event/cEvent/FSxCEVTEditAjax';
$route ['EticketDelEvent']                              = 'ticket/event/cEvent/FSxCEVTDel';
$route ['EticketEventApv']                              = 'ticket/event/cEvent/FSxCEVTApv';
$route ['EticketEventDelImg']                           = 'ticket/event/cEvent/FSxCEVTDelImg';

// Bank Info
$route ['EticketBankInfo']                              = 'ticket/bankinfo/cBankInfo/FSxCBIFMaster';
$route ['EticketBankInfoAdd']                           = 'ticket/bankinfo/cBankInfo/FSxCBIFAdd';
$route ['EticketBankInfoAddAjax']                       = 'ticket/bankinfo/cBankInfo/FSxCBIFAddAjax';
$route ['EticketBankInfoEdit/(.*)']                     = 'ticket/bankinfo/cBankInfo/FSxCBIFEdit/$1';
$route ['EticketBankInfoEditAjax']                      = 'ticket/bankinfo/cBankInfo/FSxCBIFEditAjax';
$route ['EticketBankInfoDel']                           = 'ticket/bankinfo/cBankInfo/FSxCBIFDel';
$route ['EticketBankInfoList']                          = 'ticket/bankinfo/cBankInfo/FSxCBIFList';
$route ['EticketBankInfoCount']                         = 'ticket/bankinfo/cBankInfo/FSxCBIFCount';
$route ['EticketBankInfoDelImg']                        = 'ticket/bankinfo/cBankInfo/FSxCBIFDelImg';
$route ['EticketBankInfoDelCheckBox']                   = 'ticket/bankinfo/cBankInfo/FSxCBIFDelCheckBox';

