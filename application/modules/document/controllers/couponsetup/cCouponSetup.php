<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cCouponSetup extends MX_Controller {

    public function __construct() {
        date_default_timezone_set("Asia/Bangkok");
        $this->load->model('company/company/mCompany');
        $this->load->model('document/couponsetup/mCouponSetup');
        parent::__construct();
    }

    public function index($pnBrowseType,$ptBrowseOption){
        $aDataConfigView    = [
            'nCPHBrowseType'    => $pnBrowseType,
            'tCPHBrowseOption'  => $ptBrowseOption,
            'aAlwEvent'         => FCNaHCheckAlwFunc('dcmCouponSetup/0/0'),
            'vBtnSave'          => FCNaHBtnSaveActiveHTML('dcmCouponSetup/0/0'),
            'nOptDecimalShow'   => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'   => FCNxHGetOptionDecimalSave()
        ];
        $this->load->view('document/couponsetup/wCouponSetup',$aDataConfigView);
    }

    // Functionality : Function Call Page From Search List
    // Parameters : Ajax and Function Parameter
    // Creator : 23/12/2019 Wasin(Yoshi)
    // Return : String View
    // Return Type : View
    public function FSvCCPHFormSearchList(){
        $this->load->view('document/couponsetup/wCouponSetupFormSearchList');
    }

    // Functionality : Function Call Page Data Table
    // Parameters : Ajax and Function Parameter
    // Creator : 23/12/2019 Wasin(Yoshi)
    // Return : Object View Data Table
    // Return Type : object
    public function FSoCCPHGetDataTable() {
        try{
            $aAdvanceSearch     = $this->input->post('oAdvanceSearch');
            $nPage              = $this->input->post('nPageCurrent');
            $aAlwEvent          = FCNaHCheckAlwFunc('dcmCouponSetup/0/0');
            // Get Option Show Decimal
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();
            // Page Current 
            if ($nPage == '' || $nPage == null) {
                $nPage = 1;
            } else {
                $nPage = $this->input->post('nPageCurrent');
            }

            // Lang ภาษา
            $nLangEdit = $this->session->userdata("tLangEdit");

            // Data Conditon Get Data Document
            $aDataCondition = array(
                'FNLngID'   => $nLangEdit,
                'nPage'     => $nPage,
                'nRow'      => 10,
                'aDatSessionUserLogIn'  => $this->session->userdata("tSesUsrInfo"),
                'aAdvanceSearch'        => $aAdvanceSearch
            );
            $aDataList      = $this->mCouponSetup->FSaMCPHGetDataTableList($aDataCondition);
            $aConfigView    = array(
                'nPage'             => $nPage,
                'nOptDecimalShow'   => $nOptDecimalShow,
                'aAlwEvent'         => $aAlwEvent,
                'aDataList'         => $aDataList,
            );
            $tCPHViewDataTableList  = $this->load->view('document/couponsetup/wCouponSetupDataTable',$aConfigView,true);
            $aReturnData = array(
                'tCPHViewDataTableList' => $tCPHViewDataTableList,
                'nStaEvent' => '1',
                'tStaMessg' => 'Success'
            );
        }catch (Exception $Error) {
            $aReturnData    = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        unset($aAdvanceSearch);
        unset($nPage);
        unset($aAlwEvent);
        unset($nOptDecimalShow);
        unset($nPage);
        unset($nLangEdit);
        unset($aDataCondition);
        unset($aDataList);
        unset($aConfigView);
        unset($tCPHViewDataTableList);
        echo json_encode($aReturnData);
    }

    // Functionality : Function Call Page Add
    // Parameters : Ajax and Function Parameter
    // Creator : 23/12/2019 Wasin(Yoshi)
    // Return : Object View Page Add
    // Return Type : object
    public function FSoCCPHCallPageAdd(){
        // Get Option Show Decimal
        $nOptDecimalShow        = FCNxHGetOptionDecimalShow();
        // Get Option Doc Save
        $nOptDocSave            = FCNnHGetOptionDocSave();
        $tBchCodeLogin          = (!empty($this->session->userdata('tSesUsrBchCom')) ? $this->session->userdata('tSesUsrBchCom') : $this->session->userdata('tSesUsrBchCom'));
        $nLngID                 = FCNaHGetLangEdit();
        $tShpCode               =  (!empty($this->session->userdata('tSesUsrShpCode')) ? $this->session->userdata('tSesUsrShpCode') : $this->session->userdata('tSesUsrShpCode'));
        $aCompInfoParams        = [
            'nLngID'   => $nLngID,
            'tBchCode' => $tBchCodeLogin
        ];
        $aResultCompany = FCNaGetCompanyInfo($aCompInfoParams)['raItems'];
        $aDataConfigViewAdd = [
            'nOptDecimalShow'   => $nOptDecimalShow,
            'nOptDocSave'       => $nOptDocSave,
            'tUserBchCode'      => $tBchCodeLogin,
            'tUserShpCode'      => $tShpCode,
            'aDataDocHD'        => array('rtCode' => '800'),
        ];
        $tCPHViewPageAdd    = $this->load->view('document/couponsetup/wCouponSetupPageForm',$aDataConfigViewAdd,true);
        $aReturnData        = [
            'tCPHViewPageAdd'   => $tCPHViewPageAdd,
            'nStaEvent'         => '1',
            'tStaMessg'         => 'Success'
        ];
        unset($nOptDecimalShow);
        unset($nOptDocSave);
        unset($aDataConfigViewAdd);
        unset($tCPHViewPageAdd);
        echo json_encode($aReturnData);
    }

    //Functionality :  call Page Edit Coupon
    //Parameters : Ajax and Function Parameter
    //Creator : 26/12/2019 saharat(Golf)
    //Return : String View
    //Return Type : View
    public function FSoCCPHCallPageEdit(){
        $tCPHDocNo  = $this->input->post('tCPHDocNo');
        $nLangEdit  = $this->session->userdata("tLangEdit");
        $aData  = array(
            'FTCphDocNo' => $tCPHDocNo,
            'FNLngID'    => $nLangEdit
        );
        $aResult    = $this->mCouponSetup->FSaMCCPGetDataByID($aData);
        // print_r($aResult);
        // die();
        $aDataEdit  = [
            'aDataDocHD'    => $aResult,
        ];
        // echo '<pre>';
        // print_r($aResult);
        // echo '</pre>';
        // die();
        $this->load->view('document/couponsetup/wCouponSetupPageForm',$aDataEdit);
    }

    // Functionality : Function Call Page Get Data Detail DT
    // Parameters : Ajax and Function Parameter
    // Creator : 25/12/2019 Wasin(Yoshi)
    // Return : Object View Page Add
    // Return Type : object
    public function FSoCCPHCallPageDetailDT(){
        try{
            $tCPHDocNo          = $this->input->post('ptCPHDocNo');
            $tCPHSearchDataDT   = $this->input->post('ptCPHSearchDataDT');
            $nCPHPageCurrent    = $this->input->post('pnCPHPageCurrent');
            $nCPHPageCurrent    = $this->input->post('pnCPHPageCurrent');
            $tCPHStaDoc         = $this->input->post('ptCPHStaDoc');
            $tCPHStaApv         = $this->input->post('ptCPHStaApv');


            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();
            // Array Where Data Select Detail DT
            $aDataWhere     = [
                'tCPHDocNo'         => $tCPHDocNo,
                'tCPHSearchDataDT'  => $tCPHSearchDataDT,
                'nPage'             => $nCPHPageCurrent,
                'nRow'              => 20,
            ];
            $aDataDetailDT      = $this->mCouponSetup->FSaMCPHGetDataDetailDT($aDataWhere);
            $aDataRenderView    = [
                'tCPHStaDoc'        => $tCPHStaDoc,
                'tCPHStaApv'        => $tCPHStaApv,
                'tCPHDocNo'         => $tCPHDocNo,
                'tCPHSearchDataDT'  => $tCPHSearchDataDT,
                'nCPHPageCurrent'   => $nCPHPageCurrent,
                'nOptDecimalShow'   => $nOptDecimalShow,
                'aAlwEvent'         => FCNaHCheckAlwFunc('dcmCouponSetup/0/0'),
                'aDataDetailDT'     => $aDataDetailDT,
            ];
            $tCPHViewPageDetailDT   = $this->load->view('document/couponsetup/wCouponSetupPageDetailDT',$aDataRenderView,true);
            $aReturnData            = array(
                'tCPHViewPageDetailDT'  => $tCPHViewPageDetailDT,
                'nStaEvent'             => '1',
                'tStaMessg'             => "Fucntion Success Return View."
            );   
        }catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        unset($tCPHDocNo);
        unset($tCPHSearchDataDT);
        unset($nCPHPageCurrent);
        unset($nOptDecimalShow);
        unset($aDataWhere);
        unset($aDataDetailDT);
        unset($aDataRenderView);
        unset($tCPHViewPageDetailDT);
        echo json_encode($aReturnData);
    }

    // Functionality : Function Event Delete Coupon Document
    // Parameters : Ajax and Function Parameter
    // Creator : 26/12/2019 Wasin(Yoshi)
    // Return : Object View Page Add
    // Return Type : object
    public function FSoCCPHEventDelete(){
        try{
            $tDataDocNo     = $this->input->post('ptDataDocNo');
            $aDataMaster    = array(
                'tDataDocNo'    => $tDataDocNo
            );
            $aResDelDoc     = $this->mCouponSetup->FSnMCPHDelDocument($aDataMaster);
            if ($aResDelDoc['rtCode'] == '1') {
                // Delete Image
                $aDeleteImage = array(
                    'tModuleName'   => 'document',
                    'tImgFolder'    => 'couponsetup',
                    'tImgRefID'     => $tDataDocNo,
                    'tTableDel'     => 'TCNMImgObj',
                    'tImgTable'     => 'TFNTCouponHD'
                );
                $nStaDelImgInDB =   FSnHDelectImageInDB($aDeleteImage);
                if($nStaDelImgInDB == 1){
                    FSnHDeleteImageFiles($aDeleteImage);
                }
                $aDataStaReturn = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success'
                );
            } else {
                $aDataStaReturn = array(
                    'nStaEvent' => $aResDelDoc['rtCode'],
                    'tStaMessg' => $aResDelDoc['rtDesc']
                );
            }
        }catch (Exception $Error) {
            $aDataStaReturn = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aDataStaReturn);
    }

    // Functionality : Function Event Create Coupon To DT
    // Parameters : Ajax and Function Parameter
    // Creator : 26/12/2019 Wasin(Yoshi)
    // Return : Object View Page Add
    // Return Type : object 
    public function FSoCCPHCallEventAddCouponToDT(){
        $aDatatFormSerialize    = $this->input->post();
        $tCPHCouponTypeCreate   = @$aDatatFormSerialize['ostCPHModalCouponTypeCreate'];
        // Image Coupon
        $tImgCPHCouponOld       = @$aDatatFormSerialize['oetImgInputCouponOld'];
        $tImgCPHCouponNew       = @$aDatatFormSerialize['oetImgInputCoupon'];
        // Data Input Condition Create
        $tInputBarWidth         = @$aDatatFormSerialize['oetCPHModalInputBarWidth'];
        $tInputBarPrefix        = @$aDatatFormSerialize['oetCPHModalInputBarPrefix'];
        $tInputBarStartCode     = @$aDatatFormSerialize['oetCPHModalInputBarStartCode'];
        $tInputBarQty           = @$aDatatFormSerialize['oetCPHModalInputBarQty'];
        $tInputCouponCode       = @$aDatatFormSerialize['oetCPHModalInputCouponCode'];
        $tInputBarHisQtyUse     = @$aDatatFormSerialize['oetCPHModalInputBarHisQtyUse'];

        if(isset($tCPHCouponTypeCreate) && $tCPHCouponTypeCreate == '2'){
            // สร้างข้อมูลจาก From
            $tCPHCouponCreateMng   = $aDatatFormSerialize['ostCPHModalCouponCreateMng'];
            if(isset($tCPHCouponCreateMng) && $tCPHCouponCreateMng == '1'){
                // สร้างคูปองตามช่วง (auto genarate)
                $tCPHCouponCreateMng1Bar    = $aDatatFormSerialize['ostCPHModalCouponCreateMng1Bar'];
                switch($tCPHCouponCreateMng1Bar){
                    case '1' :
                        // ประเภทบาร์โค้ด ตัวเลข
                        $aDataCouponBar = FCNaHGenCoupon($tInputBarWidth,'',$tInputBarQty,$tInputBarStartCode);
                    break;
                    case '2' :
                        // ประเภทบาร์โค้ด ตัวอักษร + ตัวเลข
                        $aDataCouponBar = FCNaHGenCoupon($tInputBarWidth,$tInputBarPrefix,$tInputBarQty,$tInputBarStartCode);
                    break;  
                    case '3' :
                        // ประเภทบาร์โค้ด ตัวอักษร
                        $aDataCouponBar = FCNaGetRandomENString($tInputBarWidth,$tInputBarQty);
                    break;
                }
            }else if(isset($tCPHCouponCreateMng) && $tCPHCouponCreateMng == '2'){
                // สร้างคูปองแบบกำหนดเอง
                $tCPHCouponCreateMng2Bar    = $aDatatFormSerialize['ostCPHModalCouponCreateMng2Bar'];
                if(isset($tCPHCouponCreateMng2Bar) && $tCPHCouponCreateMng2Bar == '1'){
                    // ประเภทบาร์โค้ด ตัวอักษร
                    $aDataCouponBar = [];
                    array_push($aDataCouponBar,$tInputCouponCode);
                }else if(isset($tCPHCouponCreateMng2Bar) && $tCPHCouponCreateMng2Bar == '2'){
                    //ประเภทบาร์โค้ด ตัวอักษร + ตัวเลข
                    $aDataCouponBar = [];
                    $tTextStringBar = $tInputBarPrefix.$tInputCouponCode;
                    array_push($aDataCouponBar,$tTextStringBar);
                }
            }
            $aDataReturn    = [
                'ptImgCPHCouponOld'     => $tImgCPHCouponOld,
                'ptImgCPHCouponNew'     => $tImgCPHCouponNew,
                'ptInputBarHisQtyUse'   => $tInputBarHisQtyUse,
                'paDataCouponBar'       => $aDataCouponBar
            ];
            echo json_encode($aDataReturn);
        }
    }

    // Functionality : Function Add  Coupon Data
    // Parameters : Ajax and Function Parameter
    // Creator : 26/12/2019 Saharat(Golf)
    // Return : Object 
    // Return Type : object
    public function FSoCCPHEventAdd(){
        try{
            // echo '<pre>';
            //     print_r($_POST);
            // echo '</pre>';
            // die();
            $tDetailItems           = $this->input->post('aDetailItems');
            $aDetailItems           = json_decode($tDetailItems, true);
            $aDataDocument          = $this->input->post();
            $tCPHAutoGenCode        = (isset($aDataDocument['ocbCPHStaAutoGenCode'])) ? 1 : 0;
            $tCPHDocNo              = (isset($aDataDocument['oetCPHDocNo'])) ? $aDataDocument['oetCPHDocNo'] : '';
            $tCCPDocDate            = $aDataDocument['oetCPHDocDate'] . " " . $aDataDocument['oetCPHDocTime'];
            $tCCPStaClosed          = (isset($aDataDocument['oetCPHFrmCphStaClosed'])) ? 2 : 1;
            $tCCPStaChkMember       = (isset($aDataDocument['oetCPHFrmCphStaChkMember'])) ? 1 : 2;

            $tCphLimitUsePerBill       = (empty($aDataDocument['ocbCphLimitUsePerBill'])) ? 0 : 1;
            $tCphStaOnTopPmt           = (empty($aDataDocument['ocbCphStaOnTopPmt'])) ? 2 : 1;

            //เฉพาะสาขา
            $aCouponIncludeAgnCode      = $this->input->post('ohdCPHCouponIncludeAgnCode');
            $aCouponIncludeBchCode      = $this->input->post('ohdCPHCouponIncludeBchCode');
            $aCouponIncludeMerCode      = $this->input->post('ohdCPHCouponIncludeMerCode');
            $aCouponIncludeShpCode      = $this->input->post('ohdCPHCouponIncludeShpCode');
            //ยกเว้นสาขา
            $aCouponExcludeAgnCode      = $this->input->post('ohdCPHCouponExcludeAgnCode');
            $aCouponExcludeBchCode      = $this->input->post('ohdCPHCouponExcludeBchCode');
            $aCouponExcludeMerCode      = $this->input->post('ohdCPHCouponExcludeMerCode');
            $aCouponExcludeShpCode      = $this->input->post('ohdCPHCouponExcludeShpCode');   

            //เฉพาะกลุ่มราคา
            $aCouponIncludeCstPriCode   = $this->input->post('ohdCPHCouponIncludeCstPriCode');
            //ยกกลุ่มราคา
            $aCouponExcludeCstPriCode   = $this->input->post('ohdCPHCouponExcludeCstPriCode');

            //เฉพาะสินค้า
            $aCouponIncludePdtCode      = $this->input->post('ohdCPHCouponIncludePdtCode');
            $aCouponIncludePdtUnitCode  = $this->input->post('ohdCPHCouponIncludePdtUnitCode');
            //ยกเว้นสินค้า
            $aCouponExcludePdtCode      = $this->input->post('ohdCPHCouponExcludePdtCode');
            $aCouponExcludePdtUnitCode  = $this->input->post('ohdCPHCouponExcludePdtUnitCode');

            //เฉพาะยี่ห้อสินค้า
            // $aCouponIncludeBrandCode   = $this->input->post('ohdCPHCouponIncludeBrandCode');
            //ยกเว้นยี่ห้อสินค้า
            // $aCouponExcludeBrandCode   = $this->input->post('ohdCPHCouponExcludeBrandCode');

            //กลุ่มราคา
            $tHDCstPriCode  = $this->input->post('oetCPHHDCstPriCode');

            // Check Auto GenCode Document
            if ($tCPHAutoGenCode == '1') {
                // $aCPHGenCode    = FCNaHGenCodeV5('TFNTCouponHD',0);
                // if ($aCPHGenCode['rtCode'] == '1') {
                //     $tCPHDocNo  = $aCPHGenCode['rtCphDocNo'];
                // }
                // 15/05/2020 Nattakit(Nale)
                $aStoreParam = array(
                    "tTblName"    => 'TFNTCouponHD',                           
                    "tDocType"    => 0,                                          
                    "tBchCode"    => $this->input->post('ohdCPHUsrBchCode'),                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d H:i:s")       
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $tCPHDocNo   = $aAutogen[0]["FTXxhDocNo"];
            } else {
                $tCPHDocNo      = $tCPHDocNo;
            }

            $aDataCouponHD      = [
                'FTBchCode'         => $this->input->post('ohdCPHUsrBchCode'), //
                'FTCphDocNo'        => $tCPHDocNo,//
                'FTCptCode'         => $this->input->post('oetCPHFrmCptCode'), //
                'FDCphDocDate'      => (!empty($tCCPDocDate)) ? $tCCPDocDate : NULL,//
                'FTCphDisType'      => $this->input->post('ostCPHFrmCphDisType'),//
                'FCCphDisValue'     => str_replace(',','',$this->input->post('oetCPHFrmCphDisValue')),//
                'FTPplCode'         => $tHDCstPriCode, //
                'FTCphRefAccCode'   => $this->input->post('oetCphRefAccCode'),
                'FDCphDateStart'    => $this->input->post('oetCPHFrmCphDateStart'),//
                'FDCphDateStop'     => $this->input->post('oetCPHFrmCphDateStop'),//
                'FTCphTimeStart'    => $this->input->post('oetCPHFrmCphTimeStart'),//
                'FTCphTimeStop'     => $this->input->post('oetCPHFrmCphTimeStop'),//
                'FTCphStaClosed'    => $tCCPStaClosed,//
                'FTStaChkMember'    => $tCCPStaChkMember,
                'FTUsrCode'         => $this->session->userdata('tSesUsername'),//
                'FCCphMinValue'     => str_replace(',','',$this->input->post('oetCphMinValue')),
                'FTCphStaOnTopPmt'  => $tCphStaOnTopPmt,
                'FNCphLimitUsePerBill' => str_replace(',','',$this->input->post('oetCphLimitUsePerBill')),//
                /// Status Document
                'FTCphStaDoc'       => $this->input->post('ohdCPHStaDoc'),//
                'FTCphStaApv'       => $this->input->post('ohdCPHStaApv'),//
                'FTCphStaPrcDoc'    => $this->input->post('ohdCPHStaPrcDoc'),//
                'FTCphStaDelMQ'     => $this->input->post('ohdCPHStaDelMQ'),//
            ];

            $aDataCouponHD_L = [
                'FTCpnName'     => $this->input->post('oetCPHFrmCpnName'),//
                'FTBchCode'     => $this->input->post('ohdCPHUsrBchCode'), //
                'FTCphDocNo'    => $tCPHDocNo,//
                'FNLngID'       => $this->session->userdata("tLangEdit"),//
                'FTCpnMsg1'     => $this->input->post('oetCPHFrmCpnMsg1'),//
                'FTCpnMsg2'     => $this->input->post('oetCPHFrmCpnMsg2'),//
                'FTCpnCond'     => $this->input->post('oetCPHFrmCpnCond')//
            ];

            $aDataCouponDT = [
                'FTBchCode'     => $this->input->post('ohdCPHUsrBchCode'),
                'FTCphDocNo'    => $tCPHDocNo,
            ];

            $aDataWhere = [
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
            ];

            $aDataCouponHDCstPri = [
                'aCouponIncludeCstPriCode' => $aCouponIncludeCstPriCode,
                'aCouponExcludeCstPriCode' => $aCouponExcludeCstPriCode
            ];

            // $aDataCouponHDBrand = [
            //     'aCouponIncludeBrandCode' => $aCouponIncludeBrandCode,
            //     'aCouponExcludeBrandCode' => $aCouponExcludeBrandCode
            // ];

            $aDataCouponHDPdt = [
                'aCouponIncludePdtCode'     => $aCouponIncludePdtCode,
                'aCouponIncludePdtUnitCode' => $aCouponIncludePdtUnitCode,
                'aCouponExcludePdtCode'     => $aCouponExcludePdtCode,
                'aCouponExcludePdtUnitCode' => $aCouponExcludePdtUnitCode
            ];

            $aDataCouponHDBch = [
                'aCouponIncludeAgnCode' => $aCouponIncludeAgnCode,
                'aCouponIncludeBchCode' => $aCouponIncludeBchCode,
                'aCouponIncludeMerCode' => $aCouponIncludeMerCode,
                'aCouponIncludeShpCode' => $aCouponIncludeShpCode,
                'aCouponExcludeAgnCode' => $aCouponExcludeAgnCode,
                'aCouponExcludeBchCode' => $aCouponExcludeBchCode,
                'aCouponExcludeMerCode' => $aCouponExcludeMerCode,
                'aCouponExcludeShpCode' => $aCouponExcludeShpCode
            ];

            // print_r($aDetailItems);
            //     exit;

            $this->db->trans_begin();

            $this->mCouponSetup->FSaMCCPAddUpdateCouponHD($aDataCouponHD,$aDataWhere);
            $this->mCouponSetup->FSaMCCPAddUpdateCouponHDL($aDataCouponHD_L);
            $this->mCouponSetup->FSaMCCPAddUpdateCouponDT($aDetailItems,$aDataCouponDT);
            $this->mCouponSetup->FSaMCCPAddUpdateCouponHDCstPri($aDataCouponDT,$aDataCouponHDCstPri);
            $this->mCouponSetup->FSaMCCPAddUpdateCouponHDPdt($aDataCouponDT,$aDataCouponHDPdt);
            $this->mCouponSetup->FSaMCCPAddUpdateCouponHDBch($aDataCouponDT,$aDataCouponHDBch);
            // $this->mCouponSetup->FSxMCCPAddUpdateCouponHDBrand($aDataCouponDT,$aDataCouponHDBrand);

            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                    $aDataStaReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Event"
                    );
            }else{
                $this->db->trans_commit();
                // Loop Delet Insert Image
                // foreach($aDetailItems AS $nKey => $aValue){
                    // Delete Image
                    // $aDeleteImage = array(
                    //     'tModuleName'   => 'document',
                    //     'tImgFolder'    => 'couponsetup',
                    //     'tImgRefID'     => $tCPHDocNo,
                    //     'tTableDel'     => 'TCNMImgObj',
                    //     'tImgTable'     => 'TFNTCouponHD'
                    // );
                    // $nStaDelImgInDB =   FSnHDelectImageInDB($aDeleteImage);
                    // if($nStaDelImgInDB == 1){
                    //     FSnHDeleteImageFiles($aDeleteImage);
                    // }
                if( $aDetailItems[0]['FTImgObjNew'] != $aDetailItems[0]['FTImgObjOld '] ){
                    // Insert Image
                    $aImageUplode   = array(
                        'tModuleName'       => 'document',
                        'tImgFolder'        => 'couponsetup',
                        'tImgRefID'         => $tCPHDocNo,
                        'tImgObj'           => $aDetailItems[0]['FTImgObjNew'],
                        'tImgTable'         => 'TFNTCouponHD',
                        'tTableInsert'      => 'TCNMImgObj',
                        'tImgKey'           => 'coupon',
                        'dDateTimeOn'       => date('Y-m-d H:i:s'),
                        'tWhoBy'            => $this->session->userdata('tSesUsername'),
                        'nStaDelBeforeEdit' => 1
                    );
                    $aImgReturn = FCNnHAddImgObj($aImageUplode);
                }

                $aDataStaReturn = array(
                    'aImgReturn'    => ( isset($aImgReturn) && !empty($aImgReturn) ? $aImgReturn : array("nStaEvent" => '1') ),
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataCouponHD['FTCphDocNo'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Event'
                );
            }
        }catch (Exception $Error) {
            $aDataStaReturn = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aDataStaReturn);
    }

    //Functionality : Event Edit Coupon Document
    //Parameters : Ajax jReason()
    //Creator : 19/12/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCCPHEventEdit(){
        try{
            $tDetailItems       = $this->input->post('aDetailItems');
            $aDetailItems       = json_decode($tDetailItems, true);
            $aDataDocument      = $this->input->post();
            $tCPHAutoGenCode    = (isset($aDataDocument['ocbCPHStaAutoGenCode'])) ? 1 : 0;
            $tCPHDocNo          = (isset($aDataDocument['oetCPHDocNo'])) ? $aDataDocument['oetCPHDocNo'] : '';
            $tCCPDocDate        = $aDataDocument['oetCPHDocDate'] . " " . $aDataDocument['oetCPHDocTime'];
            $tCCPStaClosed      = (isset($aDataDocument['oetCPHFrmCphStaClosed'])) ? 2 : 1;
            $tCCPStaChkMember       = (isset($aDataDocument['oetCPHFrmCphStaChkMember'])) ? 1 : 2;

            $tCphLimitUsePerBill       = (empty($aDataDocument['ocbCphLimitUsePerBill'])) ? 0 : 1;
            $tCphStaOnTopPmt           = (empty($aDataDocument['ocbCphStaOnTopPmt'])) ? 2 : 1;

            //เฉพาะสาขา
            $aCouponIncludeAgnCode      = $this->input->post('ohdCPHCouponIncludeAgnCode');
            $aCouponIncludeBchCode      = $this->input->post('ohdCPHCouponIncludeBchCode');
            $aCouponIncludeMerCode      = $this->input->post('ohdCPHCouponIncludeMerCode');
            $aCouponIncludeShpCode      = $this->input->post('ohdCPHCouponIncludeShpCode');
            //ยกเว้นสาขา
            $aCouponExcludeAgnCode      = $this->input->post('ohdCPHCouponExcludeAgnCode');
            $aCouponExcludeBchCode      = $this->input->post('ohdCPHCouponExcludeBchCode');
            $aCouponExcludeMerCode      = $this->input->post('ohdCPHCouponExcludeMerCode');
            $aCouponExcludeShpCode      = $this->input->post('ohdCPHCouponExcludeShpCode');   

            //เฉพาะกลุ่มราคา
            $aCouponIncludeCstPriCode   = $this->input->post('ohdCPHCouponIncludeCstPriCode');
            //ยกกลุ่มราคา
            $aCouponExcludeCstPriCode   = $this->input->post('ohdCPHCouponExcludeCstPriCode');

            //เฉพาะสินค้า
            $aCouponIncludePdtCode      = $this->input->post('ohdCPHCouponIncludePdtCode');
            $aCouponIncludePdtUnitCode  = $this->input->post('ohdCPHCouponIncludePdtUnitCode');
            //ยกเว้นสินค้า
            $aCouponExcludePdtCode      = $this->input->post('ohdCPHCouponExcludePdtCode');
            $aCouponExcludePdtUnitCode  = $this->input->post('ohdCPHCouponExcludePdtUnitCode');

            //เฉพาะยี่ห้อสินค้า
            // $aCouponIncludeBrandCode   = $this->input->post('ohdCPHCouponIncludeBrandCode');
            //ยกเว้นยี่ห้อสินค้า
            // $aCouponExcludeBrandCode   = $this->input->post('ohdCPHCouponExcludeBrandCode');

            //กลุ่มราคา
            $tHDCstPriCode  = $this->input->post('oetCPHHDCstPriCode');

            $aDataCouponHD      = [
                'FTBchCode'         => $this->input->post('ohdCPHUsrBchCode'), 
                'FTCphDocNo'        => $tCPHDocNo,
                'FTCptCode'         => $this->input->post('oetCPHFrmCptCode'), 
                'FDCphDocDate'      => (!empty($tCCPDocDate)) ? $tCCPDocDate : NULL,
                'FTCphDisType'      => $this->input->post('ostCPHFrmCphDisType'),
                'FCCphDisValue'     => str_replace(',','',$this->input->post('oetCPHFrmCphDisValue')),//
                'FTCphRefAccCode'   => $this->input->post('oetCphRefAccCode'),
                'FTPplCode'        => $tHDCstPriCode,
                'FDCphDateStart'    => $this->input->post('oetCPHFrmCphDateStart'),
                'FDCphDateStop'     => $this->input->post('oetCPHFrmCphDateStop'),
                'FTCphTimeStart'    => $this->input->post('oetCPHFrmCphTimeStart'),
                'FTCphTimeStop'     => $this->input->post('oetCPHFrmCphTimeStop'),
                'FTCphStaClosed'    => $tCCPStaClosed,
                'FTStaChkMember'    => $tCCPStaChkMember,
                'FTUsrCode'         => $this->session->userdata('tSesUsername'),
                'FCCphMinValue'     => str_replace(',','',$this->input->post('oetCphMinValue')),
                'FTCphStaOnTopPmt'  => $tCphStaOnTopPmt,
                'FNCphLimitUsePerBill' => str_replace(',','',$this->input->post('oetCphLimitUsePerBill')),//
            
                /// Status Document
                'FTCphStaDoc'       => $this->input->post('ohdCPHStaDoc'),
                'FTCphStaApv'       => $this->input->post('ohdCPHStaApv'),
                'FTCphStaPrcDoc'    => $this->input->post('ohdCPHStaPrcDoc'),
                'FTCphStaDelMQ'     => $this->input->post('ohdCPHStaDelMQ'),
            ];

            $aDataCouponHD_L = [
                'FTCpnName'     => $this->input->post('oetCPHFrmCpnName'),
                'FTBchCode'     => $this->input->post('ohdCPHUsrBchCode'), //
                'FTCphDocNo'    => $tCPHDocNo,
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTCpnMsg1'     => $this->input->post('oetCPHFrmCpnMsg1'),
                'FTCpnMsg2'     => $this->input->post('oetCPHFrmCpnMsg2'),
                'FTCpnCond'     => $this->input->post('oetCPHFrmCpnCond')
            ];

            $aDataCouponDT = [
                'FTBchCode'     => $this->input->post('ohdCPHUsrBchCode'), 
                'FTCphDocNo'    => $tCPHDocNo,
            ];

            $aDataWhere = [
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
            ];

            $aDataCouponHDCstPri = [
                'aCouponIncludeCstPriCode' => $aCouponIncludeCstPriCode,
                'aCouponExcludeCstPriCode' => $aCouponExcludeCstPriCode
            ];

            // $aDataCouponHDBrand = [
            //     'aCouponIncludeBrandCode' => $aCouponIncludeBrandCode,
            //     'aCouponExcludeBrandCode' => $aCouponExcludeBrandCode
            // ];

            $aDataCouponHDPdt = [
                'aCouponIncludePdtCode'     => $aCouponIncludePdtCode,
                'aCouponIncludePdtUnitCode' => $aCouponIncludePdtUnitCode,
                'aCouponExcludePdtCode'     => $aCouponExcludePdtCode,
                'aCouponExcludePdtUnitCode' => $aCouponExcludePdtUnitCode
            ];

            $aDataCouponHDBch = [
                'aCouponIncludeAgnCode' => $aCouponIncludeAgnCode,
                'aCouponIncludeBchCode' => $aCouponIncludeBchCode,
                'aCouponIncludeMerCode' => $aCouponIncludeMerCode,
                'aCouponIncludeShpCode' => $aCouponIncludeShpCode,
                'aCouponExcludeAgnCode' => $aCouponExcludeAgnCode,
                'aCouponExcludeBchCode' => $aCouponExcludeBchCode,
                'aCouponExcludeMerCode' => $aCouponExcludeMerCode,
                'aCouponExcludeShpCode' => $aCouponExcludeShpCode
            ];

            $this->db->trans_begin();

            $this->mCouponSetup->FSaMCCPAddUpdateCouponHD($aDataCouponHD,$aDataWhere);
            $this->mCouponSetup->FSaMCCPAddUpdateCouponHDL($aDataCouponHD_L);
            $this->mCouponSetup->FSaMCCPAddUpdateCouponDT($aDetailItems,$aDataCouponDT);
            $this->mCouponSetup->FSaMCCPAddUpdateCouponHDCstPri($aDataCouponDT,$aDataCouponHDCstPri);
            $this->mCouponSetup->FSaMCCPAddUpdateCouponHDPdt($aDataCouponDT,$aDataCouponHDPdt);
            $this->mCouponSetup->FSaMCCPAddUpdateCouponHDBch($aDataCouponDT,$aDataCouponHDBch);
            // $this->mCouponSetup->FSxMCCPAddUpdateCouponHDBrand($aDataCouponDT,$aDataCouponHDBrand);
            
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Event"
                    );
            }else{
                $this->db->trans_commit();
                // Loop Delet Insert Image
                // foreach($aDetailItems AS $nKey => $aValue){
                    // Delete Image
                    // $aDeleteImage = array(
                    //     'tModuleName'   => 'document',
                    //     'tImgFolder'    => 'couponsetup',
                    //     'tImgRefID'     => $tCPHDocNo,
                    //     'tTableDel'     => 'TCNMImgObj',
                    //     'tImgTable'     => 'TFNTCouponHD'
                    // );
                    // $nStaDelImgInDB =   FSnHDelectImageInDB($aDeleteImage);
                    // if($nStaDelImgInDB == 1){
                    //     FSnHDeleteImageFiles($aDeleteImage);
                    // }
                if( $aDetailItems[0]['FTImgObjNew'] != $aDetailItems[0]['FTImgObjOld '] ){
                    // Insert Image
                    $aImageUplode   = array(
                        'tModuleName'       => 'document',
                        'tImgFolder'        => 'couponsetup',
                        'tImgRefID'         => $tCPHDocNo,
                        'tImgObj'           => $aDetailItems[0]['FTImgObjNew'],
                        'tImgTable'         => 'TFNTCouponHD',
                        'tTableInsert'      => 'TCNMImgObj',
                        'tImgKey'           => 'coupon',
                        'dDateTimeOn'       => date('Y-m-d H:i:s'),
                        'tWhoBy'            => $this->session->userdata('tSesUsername'),
                        'nStaDelBeforeEdit' => 1
                    );
                    $aImgReturn = FCNnHAddImgObj($aImageUplode);
                }

                $aDataStaReturn = array(
                    'aImgReturn'    => ( isset($aImgReturn) && !empty($aImgReturn) ? $aImgReturn : array("nStaEvent" => '1') ),
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $tCPHDocNo,
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Edit Event'
                );
            }
        }catch(Exception $Error){
            $aDataStaReturn = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aDataStaReturn);
    }

    //Functionality : Event Cancel Document
    //Parameters : Ajax jReason()
    //Creator : 27/12/2019 Supawat (Wat)
    //Return : Status Edit Event
    //Return Type : String
    public function FSaCCPHEventCancel(){
        $tDocumentNumber        = $this->input->post('tDocumentNumber');
        $tBchCode               = $this->input->post('tBchCode');
        $aData              = array(
            'FTBchCode'    => $tBchCode,
            'FTCphDocNo'   => $tDocumentNumber
        );
        $this->mCouponSetup->FSaMCPHCancelStatus($aData);
    }

    //Functionality : Event Appove Document
    //Parameters : Ajax jReason()
    //Creator : 27/12/2019 Wasin (Yoshi)
    //Return : Status Edit Event
    //Return Type : String
    public function FSaCCPHEventAppove(){
        $tDocumentNumber        = $this->input->post('tDocumentNumber');
        $tBchCode               = $this->input->post('tBchCode');
        $tUserAppove            = $this->session->userdata('tSesUsername');
        $aData              = array(
            'FTBchCode'     => $tBchCode,
            'FTCphDocNo'    => $tDocumentNumber,
            'FTCphUsrApv'   => $tUserAppove
        );
        $this->mCouponSetup->FSaMCPHAppoveStatus($aData);
    }

    //Functionality : แก้ไขเอกสารหลังอนุมัติ
    //Parameters : nStaClosed tCPHDocNo
    //Creator : 10/07/2020 Nale
    //Return : status
    //Return Type : json
    public function FSaCCPHChangStatusAfApv(){
        try {
            $nStaClosed      = $this->input->post('nStaClosed');
            $tCPHDocNo       = $this->input->post('tCPHDocNo');
            $tBchCode        = $this->input->post('tBchCode');
            
            $aDataPdtParams = array(
                'tCPHDocNo'     => $tCPHDocNo,
                'tBchCode'      => $tBchCode ,
                'nStaClosed'    => $nStaClosed,
                'tSessionID'    => $this->session->userdata('tSesSessionID'),
            );
            $aResult = $this->mCouponSetup->FSaMCPHChangStatusAfApv($aDataPdtParams);
            if($aResult['rtCode']=="1"){
                $aReturnData = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => "Fucntion Success"
                );
            }else{
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => "Fucntion Error"
                );
            }

        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }
}