<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cTopupVending extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('company/company/mCompany');
        $this->load->model('document/topupVending/mTopupVending');
        $this->load->model('payment/rate/mRate');
        $this->load->model('company/vatrate/mVatRate');
        $this->load->model('company/branch/mBranch');
        $this->load->model('company/shop/mShop');
        $this->load->model('authen/login/mLogin');
    }

    public function index($nBrowseType, $tBrowseOption)
    {
        $aData['nBrowseType'] = $nBrowseType;
        $aData['tBrowseOption'] = $tBrowseOption;
        $aData['aAlwEvent'] = FCNaHCheckAlwFunc('TWXVD/0/0');
        $aData['vBtnSave'] = FCNaHBtnSaveActiveHTML('TWXVD/0/0');
        $aData['nOptDecimalShow'] = FCNxHGetOptionDecimalShow();
        $aData['nOptDecimalSave'] = FCNxHGetOptionDecimalSave();
        $this->load->view('document/topupVending/wTopupVending', $aData);
    }

    /**
     * Functionality : Main Page List
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : List Page
     * Return Type : View
     */
    public function FSxCTUVTopupVendingList()
    {
        $this->session->userdata("tLangID");
        $nLangEdit  = $this->session->userdata("tLangEdit");
        $aData      = array(
            'FTBchCode'     => $this->session->userdata("tSesUsrBchCode"),
            'FTShpCode'     => '',
            'nPage'         => 1,
            'nRow'          => 20,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => ''
        );

        $aBchData = $this->mBranch->FSnMBCHList($aData);
        $aDataMaster = array(
            'aBchData' => $aBchData
        );
        $this->load->view('document/topupVending/wTopupVendingList', $aDataMaster);
    }

    /**
     * Functionality : Get HD Table List
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : HD Table List
     * Return Type : View
     */
    public function FSxCTUVTopupVendingDataTable()
    {
        $tAdvanceSearchData = $this->input->post('oAdvanceSearch');
        $nPage = $this->input->post('nPageCurrent');
        $aAlwEvent = FCNaHCheckAlwFunc('TWXVD/0/0');
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();



        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nPageCurrent');
        }

        $nLangResort = $this->session->userdata("tLangID");
        $nLangEdit = $this->session->userdata("tLangEdit");
        $aData = array(
            'FNLngID' => $nLangEdit,
            'nPage' => $nPage,
            'nRow' => 10,
            'aAdvanceSearch' => json_decode($tAdvanceSearchData, true)
        );

        $aResList = $this->mTopupVending->FSaMHDList($aData);
        $aGenTable = array(
            'aAlwEvent' => $aAlwEvent,
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'nOptDecimalShow' => $nOptDecimalShow
        );

        $this->load->view('document/topupVending/wTopupVendingDatatable', $aGenTable);
    }

    /**
     * Functionality : Add Page
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Add Page
     * Return Type : View
     */
    public function FSxCTUVTopupVendingAddPage()
    {
        $tUserSessionID = $this->session->userdata('tSesSessionID');

        $aInfoWhere = array(
            "tBchCode" => $this->input->post("tBchCode"),
            "FTXthDocKey" => "TCNTPdtAdjStkHD"
        );
        $this->mTopupVending->FSxMDeleteDoctemForNewEvent($aInfoWhere);

        $aClearPdtLayoutInTmpParams = [
            'tUserSessionID' => $tUserSessionID,
            'tDocKey' => 'TVDTPdtTwxHD'
        ];
        $this->mTopupVending->FSxMClearPdtLayoutInTmp($aClearPdtLayoutInTmpParams);

        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        $nOptDocSave = FCNnHGetOptionDocSave();
        $nOptScanSku = FCNnHGetOptionScanSku();
        // $nLangResort = $this->session->userdata("tLangID");
        $nLangEdit = $this->session->userdata("tLangEdit");

        $aDataWhere  = array(
            'FNLngID' => $nLangEdit
        );

        $tAPIReq = "";
        $tMethodReq = "GET";
        $aResList = $this->mCompany->FSaMCMPList($tAPIReq, $tMethodReq, $aDataWhere);

        if ($aResList['rtCode'] == '1') {
            $tBchCode = $aResList['raItems']['rtCmpBchCode'];
            $tCompCode = $aResList['raItems']['rtCmpCode'];
            $tCmpRteCode = $aResList['raItems']['rtCmpRteCode'];
            $tVatCode = $aResList['raItems']['rtVatCodeUse'];
            $aVatRate = FCNoHCallVatlist($tVatCode);
            if (FCNnHSizeOf($aVatRate) != 0) {
                $cVatRate = $aVatRate['FCVatRate'][0];
            } else {
                $cVatRate = "";
            }
        } else {
            $tBchCode = "";
            $tCompCode = "";
            $tCmpRteCode = "";
            $tVatCode = "";
            $cVatRate = "";
        }

        $tUsrLogin = $this->session->userdata('tSesUsername');
        $tDptCode = FCNnDOCGetDepartmentByUser($tUsrLogin);

        $aDataShp  = array(
            'FNLngID'   => $nLangEdit,
            'tUsrLogin' => $tUsrLogin
        );
        $aDataUserGroup = $this->mTopupVending->FStTFWGetShpCodeForUsrLogin($aDataShp);

        if (isset($aDataUserGroup)) {
            $tBchCode = '';
            $tBchName = '';
            $tMchCode = '';
            $tMchName = '';
            $tShpCodeStart = "";
            $tShpNameStart = "";
            $tShpCodeEnd = "";
            $tShpNameEnd = "";
            $tWahCodeStart = "";
            $tWahNameStart = "";
            $tWahCodeEnd = "";
            $tWahNameEnd = "";
            $tShpTypeStart = "";
        } else {
            $tShpTypeStart = $aDataUserGroup["FTShpType"];
            // เช็ค user ว่ามีการผูกสาขาไว้หรือไม่
            if ($aDataUserGroup["FTBchCode"] == '') {
                // ถ้าว่าง ให้ Get Option Def
                $tBchCode = '';
                $tBchName = '';
            } else {
                $tBchCode = $aDataUserGroup["FTBchCode"];
                $tBchName = $aDataUserGroup["FTBchName"];
            }
            // เช็ค user ว่ามีการผูกสาขาไว้หรือไม่
            $tMchCode = $aDataUserGroup["FTMerCode"];
            $tMchName = $aDataUserGroup["FTMerName"];
            // เช็ค user ว่ามีการผูกร้านค้าไว้หรือไม่
            if ($aDataUserGroup["FTShpCode"] == '') {
                // ถ้าว่าง ให้ Get Option Def
                $tShpCodeStart = "";
                $tShpNameStart = "";
                $tShpCodeEnd = "";
                $tShpNameEnd = "";
                $tWahCodeStart = "";
                $tWahNameStart = "";
                $tWahCodeEnd = "";
                $tWahNameEnd = "";
            } else {
                $tShpCodeStart      = $aDataUserGroup["FTShpCode"];
                $tShpNameStart      = $aDataUserGroup["FTShpName"];
                $tShpCodeEnd        = "";
                $tShpNameEnd        = "";
                $tWahCodeStart      = $aDataUserGroup["FTWahCode"];
                $tWahNameStart      = $aDataUserGroup["FTWahName"];
                $tWahCodeEnd        = "";
                $tWahNameEnd        = "";
            }
        }

        $aDataAdd = array(
            'aResult'           =>  array('rtCode' => '99'),
            'aResultOrdDT'      =>  array('rtCode' => '99'),
            'nOptDecimalShow'   =>  $nOptDecimalShow,
            'nOptScanSku'       =>  $nOptScanSku,
            'nOptDocSave'       =>  $nOptDocSave,
            'tCmpRteCode'       =>  $tCmpRteCode,
            'tVatCode'          =>  $tVatCode,
            'cVatRate'          =>  $cVatRate,
            'tDptCode'          =>  $tDptCode,
            'tMchCode'          =>  $tMchCode,
            'tMchName'          =>  $tMchName,
            'tShpCodeStart'     =>  $tShpCodeStart,
            'tShpNameStart'     =>  $tShpNameStart,
            'tShpTypeStart'     =>  $tShpTypeStart,
            'tShpCodeEnd'       =>  $tShpCodeEnd,
            'tShpNameEnd'       =>  $tShpNameEnd,
            'tWahCodeStart'     =>  $tWahCodeStart,
            'tWahNameStart'     =>  $tWahNameStart,
            'tWahCodeEnd'       =>  $tWahCodeEnd,
            'tWahNameEnd'       =>  $tWahNameEnd,
            'tCompCode'         =>  $tCompCode,
            'tBchCode'          =>  $tBchCode,
            'tBchName'          =>  $tBchName,
            'tBchCompCode'      =>  FCNtGetBchInComp(),
            'tBchCompName'      =>  FCNtGetBchNameInComp()
        );
        $this->load->view('document/topupVending/wTopupVendingPageadd', $aDataAdd);
    }

    /**
     * Functionality : Add Event
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaCTUVTopupVendingAddEvent()
    {
        try {
            $tUserSessionID = $this->session->userdata('tSesSessionID');
            $dXthDocDate = $this->input->post('oetTopUpVendingDocDate') . " " . $this->input->post('oetTopUpVendingDocTime');
            $aDataMaster = array(
                'tIsAutoGenCode'        => $this->input->post('ocbTopUpVendingAutoGenCode'),
                'FTBchCode'             => $this->input->post('oetTopUpVendingBCHCode'),
                'FTXthDocNo'            => $this->input->post('oetTopUpVendingDocNo'),
                'FTXthDocType'          => 1,
                'FDXthDocDate'          => $dXthDocDate,
                'FTXthVATInOrEx'        => '',
                'FTDptCode'             => $this->input->post('ohdTopUpVendingDptCode'),
                'FTXthMerCode'          => $this->input->post('oetTopUpVendingMchCode'),
                'FTXthShopFrm'          => $this->input->post('oetTopUpVendingShpCode'),
                'FTXthShopTo'           => $this->input->post('oetTopUpVendingShpCode'),
                'FTXthPosFrm'           => $this->input->post('oetTopUpVendingPosCode'),
                'FTXthPosTo'            => $this->input->post('oetTopUpVendingPosCode'),
                'FTUsrCode'             => $this->input->post('oetTopUpVendingUsrCode'),
                'FTSpnCode'             => '',
                'FTXthApvCode'           => '',  // สถานะ อนุมัติ เอกสาร ว่าง:ยังไม่ทำ, 1:อนุมัติแล้ว 
                'FTXthRefExt'           => $this->input->post('oetXthRefExt'),
                'FDXthRefExtDate'       => $this->input->post('oetXthRefExtDate') != '' ? $this->input->post('oetXthRefExtDate') : NULL,
                'FTXthRefInt'           => $this->input->post('oetXthRefInt'),
                'FDXthRefIntDate'       => $this->input->post('oetXthRefIntDate') != '' ? $this->input->post('oetXthRefIntDate') : NULL,
                'FNXthDocPrint'         => 0,
                'FCXthTotal'            => 0, // ยอดรวมก่อนลด
                'FCXthVat'              => '',
                'FCXthVatable'          => '',
                'FTXthRmk'              => $this->input->post('otaTopUpVendingRmk'),
                'FTXthStaDoc'           => 1,   // 1 after save
                'FTXthStaApv'           => '',
                'FTXthStaPrcStk'        => '',  // สถานะ ประมวลผลสต๊อก ว่าง หรือ Null:ยังไม่ทำ, 1:ทำแล้ว
                'FTXthStaDelMQ'         => '',
                'FNXthStaDocAct'        => $this->input->post('ocbTopUpVendingXthStaDocAct'), // สถานะ ประมวลผลสต๊อก ว่าง หรือ Null:ยังไม่ทำ, 1:ทำแล้ว
                'FNXthStaRef'           => $this->input->post('ostTopUpVendingXthStaRef'),   // Default 0
                'FDLastUpdOn'           => date('Y-m-d H:i:s'),
                'FDCreateOn'            => date('Y-m-d H:i:s'),
                'FTCreateBy'            => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'           => $this->session->userdata('tSesUsername'),
                'FTRsnCode'             => ''
            );

            $this->db->trans_begin();

            if ($aDataMaster['tIsAutoGenCode'] == '1') {
                $aStoreParam = array(
                    "tTblName"    => 'TVDTPdtTwxHD',                           
                    "tDocType"    => '1',                                          
                    "tBchCode"    => $this->input->post('oetTopUpVendingBCHCode'),                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d H:i:s")       
                );
                $aAutogen                   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataMaster['FTXthDocNo']  = $aAutogen[0]["FTXxhDocNo"];
            }

            // ข้อมูลการขนส่ง
            $aAddUpdateHDRefParams = array(
                'FTBchCode'             => $aDataMaster['FTBchCode'],
                'FTXthDocNo'            => $aDataMaster['FTXthDocNo'],
                'FTXthCtrName'          => $this->input->post('oetTopUpVendingXthCtrName'),
                'FDXthTnfDate'          => $this->input->post('oetTopUpVendingXthTnfDate'),
                'FTXthRefTnfID'         => $this->input->post('oetTopUpVendingXthRefTnfID'),
                'FTXthRefVehID'         => $this->input->post('oetTopUpVendingXthRefVehID'),
                'FTXthQtyAndTypeUnit'   => $this->input->post('oetTopUpVendingXthQtyAndTypeUnit'),
                'FNXthShipAdd'          => $this->input->post('ohdTopUpVendingXthShipAdd'),
                'FTViaCode'             => $this->input->post('oetTopUpVendingViaCode'),
            );

            $this->mTopupVending->FSaMAddUpdateHD($aDataMaster);
            $this->mTopupVending->FSaMAddUpdateHDRef($aAddUpdateHDRefParams);

            $aUpdateDocNoInTmpParams = [
                'FTXthDocNo'        => $aDataMaster['FTXthDocNo'],
                'FTXthDocKey'       => 'TVDTPdtTwxHD',
                'tUserSessionID'    => $tUserSessionID
            ];
            if( $this->input->post('ptOptionDel') == '2' ){ // ลบรายการสินค้า ที่มีจำนวนเติม = 0
                $this->mTopupVending->FSxMTVDDelPdtTopupZero($aUpdateDocNoInTmpParams);
            }
            $this->mTopupVending->FSaMUpdateDocNoInTmp($aUpdateDocNoInTmpParams); // Update DocNo ในตาราง Doctemp

            $tStaShwPdtInStk = $this->input->post('ocbTUVStaShwPdtInStk');
            $aTempToDTParams = [
                'tDocNo'            => $aDataMaster['FTXthDocNo'],
                'tBchCode'          => $aDataMaster['FTBchCode'],
                'tDocKey'           => 'TVDTPdtTwxHD',
                'tUserSessionID'    => $tUserSessionID,
                'tPageControl'      => 'Add',
                'tStaShwPdt'        => $this->input->post('ocmTUVStaShwPdt'),
                'tStaShwPdtInStk'   => isset($tStaShwPdtInStk) ? 'true' : ''
            ];
            $this->mTopupVending->FSaMTempToDT($aTempToDTParams); // คัดลอกข้อมูลจาก Temp to DT

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add"
                );
            } else {
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack' => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn' => $aDataMaster['FTXthDocNo'],
                    'nStaEvent'    => '1',
                    'tStaMessg' => 'Success Add'
                );
            }

            echo json_encode($aReturn);
            // $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    /**
     * Functionality : Edit Page
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Edit Page
     * Return Type : View
     */
    public function FSvCTUVTopupVendingEditPage()
    {
        $tDocNo             = $this->input->post('tDocNo');
        $nLangEdit          = $this->session->userdata("tLangEdit");
        $nLangResort        = $this->session->userdata("tLangID");
        $aLangHave          = FCNaHGetAllLangByTable('TFNMRate_L');
        $tUsrLogin          = $this->session->userdata('tSesUsername');
        $tUserSessionID     = $this->session->userdata("tSesSessionID");
        $tUserSessionDate   = $this->session->userdata("tSesSessionDate");
        $tUserLevel         = $this->session->userdata('tSesUsrLevel');

        $aAlwEvent = FCNaHCheckAlwFunc('TWXVD/0/0'); //Control Event
        // Get Option Show Decimal
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        // Get Option Scan SKU
        $nOptDocSave = FCNnHGetOptionDocSave();
        //Get Option Scan SKU
        $nOptScanSku = FCNnHGetOptionScanSku();

        // Lang ภาษา

        $nLangHave = FCNnHSizeOf($aLangHave);
        if ($nLangHave > 1) {
            if ($nLangEdit != '') {
                $nLangEdit = $nLangEdit;
            } else {
                $nLangEdit = $nLangResort;
            }
        } else {
            if (@$aLangHave[0]->nLangList == '') {
                $nLangEdit = '1';
            } else {
                $nLangEdit = $aLangHave[0]->nLangList;
            }
        }

        // Get Data
        $aGetHDParams = array(
            'tDocNo'    => $tDocNo,
            'nLngID'    => $nLangEdit,
            'tDocKey'   => 'TVDTPdtTwxHD',
        );
        $aResult = $this->mTopupVending->FSaMGetHD($aGetHDParams); // Data TVDTPdtTwxHD

        $aGetHDRefParams = [
            'tDocNo'    => $tDocNo
        ];
        $aDataHDRef = $this->mTopupVending->FSaMGetHDRef($aGetHDRefParams); // Data TVDTPdtTwxHDRef

        $aGetWahInDTParams = [
            'tBchCode'  => isset($aResult['raItems']['FTBchCode']) ? $aResult['raItems']['FTBchCode'] : '',
            'tDocNo'    => $tDocNo
        ];
        $aWahInDT = $this->mTopupVending->FSaMGetWahInDT($aGetWahInDTParams);

        $aDTToTempParams = [
            'tDocNo'            => $tDocNo,
            'tDocKey'           => 'TVDTPdtTwxHD',
            'tBchCode'          => isset($aResult['raItems']['FTBchCode']) ? $aResult['raItems']['FTBchCode'] : '',
            'tUserSessionID'    => $tUserSessionID,
            'tUserSessionDate'  => $tUserSessionDate,
            'nLngID'            => $nLangEdit
        ];
        $this->mTopupVending->FSaMDTToTemp($aDTToTempParams);

        $aWahCodeInDT = [];
        $aWahNameInDT = [];

        foreach ($aWahInDT as $aValue) {
            $aWahCodeInDT[] = $aValue['FTWahCode'];
            $aWahNameInDT[] = $aValue['FTWahName'];
        }

        $aDataEdit = array(
            'nOptDecimalShow'   => $nOptDecimalShow,
            'nOptDocSave'       => $nOptDocSave,
            'nOptScanSku'       => $nOptScanSku,
            'aResult'           => $aResult,
            'aDataHDRef'        => $aDataHDRef,
            'aAlwEvent'         => $aAlwEvent,
            'tUserBchCode'      => '', // $tBchCode,
            'tUserMchCode'      => '', // $tMchCode,
            'tUserShpCode'      => '', // $tShpCode,
            'tCompCode'         => '', // $tCompCode,
            'tBchCompCode'      => FCNtGetBchInComp(),
            'tBchCompName'      => FCNtGetBchNameInComp(),
            'tWahCodeInDT'      => FCNtArrayToString($aWahCodeInDT),
            'tWahNameInDT'      => FCNtArrayToString($aWahNameInDT)
        );
        $this->load->view('document/topupVending/wTopupVendingPageadd', $aDataEdit);
    }

    /**
     * Functionality : Edit Event
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaCTUVTopupVendingEditEvent()
    {
        try {
            $tUserSessionID = $this->session->userdata('tSesSessionID');
            $dXthDocDate = $this->input->post('oetTopUpVendingDocDate') . " " . $this->input->post('oetTopUpVendingDocTime');
            $aDataMaster = array(
                'tIsAutoGenCode'        => $this->input->post('ocbTopUpVendingAutoGenCode'),
                'FTBchCode'             => $this->input->post('oetTopUpVendingBCHCode'),
                'FTXthDocNo'            => $this->input->post('oetTopUpVendingDocNo'),
                'FDXthDocDate'          => $dXthDocDate,
                'FTXthDocType'          => 1,
                'FTXthVATInOrEx'        => '',
                'FTDptCode'             => $this->input->post('ohdTopUpVendingDptCode'),
                'FTXthMerCode'          => $this->input->post('oetTopUpVendingMchCode'),
                'FTXthShopFrm'          => $this->input->post('oetTopUpVendingShpCode'),
                'FTXthShopTo'           => $this->input->post('oetTopUpVendingShpCode'),
                'FTXthPosFrm'           => $this->input->post('oetTopUpVendingPosCode'),
                'FTXthPosTo'            => $this->input->post('oetTopUpVendingPosCode'),
                'FTUsrCode'             => $this->input->post('oetTopUpVendingUsrCode'),
                'FTSpnCode'             => '',
                'FTXthApvCode'           => '',  // สถานะ อนุมัติ เอกสาร ว่าง:ยังไม่ทำ, 1:อนุมัติแล้ว 
                'FTXthRefExt'           => $this->input->post('oetXthRefExt'),
                'FDXthRefExtDate'       => $this->input->post('oetXthRefExtDate') != '' ? $this->input->post('oetXthRefExtDate') : NULL,
                'FTXthRefInt'           => $this->input->post('oetXthRefInt'),
                'FDXthRefIntDate'       => $this->input->post('oetXthRefIntDate') != '' ? $this->input->post('oetXthRefIntDate') : NULL,
                'FNXthDocPrint'         => 0,
                'FCXthTotal'            => 0, // ยอดรวมก่อนลด
                'FCXthVat'              => '',
                'FCXthVatable'          => '',
                'FTXthRmk'              => $this->input->post('otaTopUpVendingRmk'),
                'FTXthStaDoc'           => 1,   // 1 after save
                'FTXthStaApv'           => '',
                'FTXthStaPrcStk'        => '',  // สถานะ ประมวลผลสต๊อก ว่าง หรือ Null:ยังไม่ทำ, 1:ทำแล้ว
                'FTXthStaDelMQ'         => '',
                'FNXthStaDocAct'        => $this->input->post('ocbTopUpVendingXthStaDocAct'), // สถานะ ประมวลผลสต๊อก ว่าง หรือ Null:ยังไม่ทำ, 1:ทำแล้ว
                'FNXthStaRef'           => $this->input->post('ostTopUpVendingXthStaRef'),   // Default 0
                'FTRsnCode'             => "",
                'FDLastUpdOn'           => date('Y-m-d H:i:s'),
                'FDCreateOn'            => date('Y-m-d H:i:s'),
                'FTCreateBy'            => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'           => $this->session->userdata('tSesUsername')
            );

            $this->db->trans_begin();

            // ข้อมูลการขนส่ง
            $aAddUpdateHDRefParams = array(
                'FTBchCode' => $aDataMaster['FTBchCode'],
                'FTXthDocNo' => $aDataMaster['FTXthDocNo'],
                'FTXthCtrName' => $this->input->post('oetTopUpVendingXthCtrName'),
                'FDXthTnfDate' => $this->input->post('oetTopUpVendingXthTnfDate'),
                'FTXthRefTnfID' => $this->input->post('oetTopUpVendingXthRefTnfID'),
                'FTXthRefVehID' => $this->input->post('oetTopUpVendingXthRefVehID'),
                'FTXthQtyAndTypeUnit' => $this->input->post('oetTopUpVendingXthQtyAndTypeUnit'),
                'FNXthShipAdd' => $this->input->post('ohdTopUpVendingXthShipAdd'),
                'FTViaCode' => $this->input->post('oetTopUpVendingViaCode'),
            );

            $this->mTopupVending->FSaMAddUpdateHD($aDataMaster);
            $this->mTopupVending->FSaMAddUpdateHDRef($aAddUpdateHDRefParams);

            

            $aUpdateDocNoInTmpParams = [
                'FTXthDocNo' => $aDataMaster['FTXthDocNo'],
                'FTXthDocKey' => 'TVDTPdtTwxHD',
                'tUserSessionID' => $tUserSessionID
            ];
            
            if( $this->input->post('ptOptionDel') == '2' ){ // ลบรายการสินค้า ที่มีจำนวนเติม = 0
                $this->mTopupVending->FSxMTVDDelPdtTopupZero($aUpdateDocNoInTmpParams);
            }
            $this->mTopupVending->FSaMUpdateDocNoInTmp($aUpdateDocNoInTmpParams); // Update DocNo ในตาราง Doctemp

            $aTempToDTParams = [
                'tDocNo' => $aDataMaster['FTXthDocNo'],
                'tBchCode' => $aDataMaster['FTBchCode'],
                'tDocKey' => 'TVDTPdtTwxHD',
                'tUserSessionID' => $tUserSessionID,
                'tPageControl'  => 'Edit'
            ];
            $this->mTopupVending->FSaMTempToDT($aTempToDTParams); // คัดลอกข้อมูลจาก Temp to DT

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit"
                );
            } else {
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack' => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn' => $aDataMaster['FTXthDocNo'],
                    'nStaEvent'    => '1',
                    'tStaMessg' => 'Success Edit'
                );
            }
            echo json_encode($aReturn);
            // $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    /**
     * Functionality : Insert PDT Layout to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaCTUVTopupVendingInsertPdtLayoutToTmp()
    {
        $tDocNo             = $this->input->post('tDocNo');
        $tBchCode           = $this->input->post('tBchCode');
        $tShpCode           = $this->input->post('tShpCode');
        $tPosCode           = $this->input->post('tPosCode');
        $tWahCodeInShop     = $this->input->post('tWahCodeInShop');
        $nLangEdit          = $this->session->userdata("tLangEdit");
        $tUserSessionID     = $this->session->userdata("tSesSessionID");
        $tUserSessionDate   = $this->session->userdata("tSesSessionDate");
        $tUserLoginCode     = $this->session->userdata("tSesUsername");
        $tUserLevel         = $this->session->userdata('tSesUsrLevel');
        $tBchCodeLogin      = $this->input->post('tBchCode');

        $aPdtlayoutToTempParams = [
            'tDocNo'            => $tDocNo,
            'tDocKey'           => 'TVDTPdtTwxHD',
            'tBchCode'          => $tBchCode,
            'tShpCode'          => $tShpCode,
            'tPosCode'          => $tPosCode,
            'tWahCodeInShop'    => $tWahCodeInShop,
            'tBchCodeLogin'     => $tBchCodeLogin,
            'tUserSessionID'    => $tUserSessionID,
            'tUserSessionDate'  => $tUserSessionDate,
            'tUserLoginCode'    => $tUserLoginCode,
            'nLngID'            => $nLangEdit
        ];
        $this->mTopupVending->FSaMPdtlayoutToTemp($aPdtlayoutToTempParams);
    }

    /**
     * Functionality : Get PDT Layout in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSxCTUVTopupVendingGetPdtLayoutDataTableInTmp()
    {
        $tSearchAll = $this->input->post('tSearchAll');
        $nPage = $this->input->post('nPageCurrent');
        $aAlwEvent = FCNaHCheckAlwFunc('TWXVD/0/0');
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tTypePage = $this->input->post('tTypePage');

        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nPageCurrent');
        }
        $nLangEdit = $this->session->userdata("tLangEdit");

        $aGetPdtLayoutInTmpParams  = array(
            'FNLngID' => $nLangEdit,
            'nPage' => $nPage,
            'nRow' => 9999,
            'tSearchAll' => $tSearchAll,
            'tUserSessionID' => $tUserSessionID,
            'tTypePage' => $tTypePage,
            'tStaShwPdt' => $this->input->post('tStaShwPdt'),
            'tStaShwPdtInStk' => $this->input->post('tStaShwPdtInStk')
        );
        $aResList = $this->mTopupVending->FSaMGetPdtLayoutInTmp($aGetPdtLayoutInTmpParams);

        $aGenTable = array(
            'aAlwEvent' => $aAlwEvent,
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'nOptDecimalShow' => $nOptDecimalShow
        );
        $this->load->view('document/topupVending/advance_table/wTopupVendingPdtDatatable', $aGenTable);
    }

    /**
     * Functionality : Check Doc No. Duplicate
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : String
     */
    public function FStCTopUpVendingUniqueValidate()
    {
        $aStatus = ['bStatus' => false];

        if ($this->input->is_ajax_request()) { // Request check
            $tTopUpVendingDocCode = $this->input->post('tTopUpVendingCode');
            $bIsDocNoDup = $this->mTopupVending->FSbMCheckDuplicate($tTopUpVendingDocCode);

            if ($bIsDocNoDup) { // If have record
                $aStatus['bStatus'] = true;
            }
        } else {
            echo 'Method Not Allowed';
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aStatus));
    }

    /**
     * Functionality : Cancel Document
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : String
     */
    public function FStCTopUpVendingDocCancel()
    {

        $tDocNo = $this->input->post('tDocNo');

        $this->db->trans_begin();

        $aDocCancelParams = array(
            'tDocNo' => $tDocNo,
        );
        $aStaCancel = $this->mTopupVending->FSaMDocCancel($aDocCancelParams);

        if ($aStaCancel['rtCode'] == 1) {
            $this->db->trans_commit();
            $aCancel = array(
                'nSta' => 1,
                'tMsg' => "Cancel Success",
            );
        } else {
            $this->db->trans_rollback();
            $aCancel = array(
                'nSta' => 2,
                'tMsg' => "Cancel Fail",
            );
        }
        echo json_encode($aCancel);
    }

    /**
     * Functionality : Approve Document
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : String
     */
    public function FStCTopUpVendingDocApprove()
    {

        $tDocNo  = $this->input->post('tDocNo');
        // $tStaApv = $this->input->post('tStaApv');
        $tDocType = $this->input->post('tDocType');
        // $tUsrBchCode = FCNtGetBchInComp();
        $tUsrBchCode = $this->input->post('tBchCode');

        $this->db->trans_begin();

        $aDocApproveParams = array(
            'tDocNo' => $tDocNo,
            'tApvCode' => $this->session->userdata('tSesUsername')
        );
        $this->mTopupVending->FSaMDocApprove($aDocApproveParams);

        try {
            $aMQParams = [
                "queueName" => "TNFWAREHOSEVD",
                "params" => [
                    "ptBchCode"     => $tUsrBchCode,
                    "ptDocNo"       => $tDocNo,
                    "ptDocType"     => $tDocType,
                    "ptUser"        => $this->session->userdata('tSesUsername')
                ]
            ];
            FCNxCallRabbitMQ($aMQParams);

            $this->db->trans_commit();
        } catch (\ErrorException $err) {

            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent' => '900',
                'tStaMessg' => language('common/main/main', 'tApproveFail')
            );
            $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aReturn));
        }
    }

    /**
     * Functionality : Delete Document
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : String
     */
    public function FStTopUpVendingDeleteDoc()
    {

        $tDocNo = $this->input->post('tDocNo');

        $this->db->trans_begin();

        $aDelMasterParams = [
            'tDocNo' => trim($tDocNo)
        ];
        $this->mTopupVending->FSaMDelMaster($aDelMasterParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Cannot Delete Item.',
            );
        } else {
            $this->db->trans_commit();
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Delete Complete.',
            );
        }
        return json_encode($aStatus);
    }

    /**
     * Functionality : Delete Multiple Document
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : String
     */
    public function FStTopUpVendingDeleteMultiDoc()
    {
        $aDocNo = $this->input->post('aDocNo');

        $this->db->trans_begin();

        foreach ($aDocNo as $aItem) {
            $aDelMasterParams = [
                'tDocNo' => trim($aItem)
            ];
            $this->mTopupVending->FSaMDelMaster($aDelMasterParams);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Cannot Delete Item.',
            );
        } else {
            $this->db->trans_commit();
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Delete Complete.',
            );
        }
        return json_encode($aStatus);
    }

    /**
     * Functionality : Update PDT Layout in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCTUVTopupVendingUpdatePdtLayoutInTmp()
    {
        $nQty           = $this->input->post('nQty');
        $nSeqNo         = $this->input->post('nSeqNo');
        $tPdtCode       = $this->input->post('tPdtCode');
        $tPosCode       = $this->input->post('tPosCode');
        $tBchCode       = $this->input->post('tBchCode');
        $tWahCode       = $this->input->post('tWahCode');
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLoginCode = $this->session->userdata("tSesUsername");
        $nCheckSTK      = $this->input->post('nCheckSTK'); //สถานะเช็คสต๊อกว่าตัดหรือไม่ตัด

        $aGetWahByShopParams = [
            'tRefCode' => $tPosCode,
            'tBchCode' => $tBchCode
        ];
        $this->mTopupVending->FSaMGetWahByRefCode($aGetWahByShopParams);

        $aGetPdtStkBalWithCheckInTmp = [
            'tBchCode'          => $tBchCode,
            'tWahCode'          => FCNtAddSingleQuote($tWahCode), // คลังสินค้าต้นทาง เพื่อใช้ในการเติมให้กับ คลังตู้สินค้า
            'tPdtCode'          => $tPdtCode,
            'tUserSessionID'    => $tUserSessionID,
            'nNotInSelfSeqNo'   => $nSeqNo
        ];
        $nStkBal = $this->mTopupVending->FSnGetPdtStkBalWithCheckInTmp($aGetPdtStkBalWithCheckInTmp);
        if ($nQty <= $nStkBal) {
            $aUpdateQtyInTmpBySeqParams = [
                'cQtyAll'           => $nStkBal,
                'cQty'              => $nQty,
                'tUserLoginCode'    => $tUserLoginCode,
                'tUserSessionID'    => $tUserSessionID,
                'nSeqNo'            => $nSeqNo,
            ];
            $this->mTopupVending->FSbUpdateQtyInTmpBySeq($aUpdateQtyInTmpBySeqParams);
        } else {
            //ถ้าเช็คว่าไม่ตัดสต๊อก สามารถคีย์เท่่าไหร่ก็ได้
            if( $nCheckSTK == 1){
                $nQTYKey = $nQty;
            }else{
                $nQTYKey = ($nStkBal < 0) ? 0 : $nStkBal;
            }

            $aUpdateQtyInTmpBySeqParams = [
                'cQtyAll'           => $nStkBal,
                'cQty'              => $nQTYKey,
                'tUserLoginCode'    => $tUserLoginCode,
                'tUserSessionID'    => $tUserSessionID,
                'nSeqNo'            => $nSeqNo,
            ];
            $this->mTopupVending->FSbUpdateQtyInTmpBySeq($aUpdateQtyInTmpBySeqParams);
        }
    }

    /**
     * Functionality : Delete PDT Layout in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCTUVTopupVendingDeletePdtLayoutInTmp()
    {
        $nSeqNo = $this->input->post('nSeqNo');
        $tUserSessionID = $this->session->userdata("tSesSessionID");

        $aDeleteInTmpBySeqParams = [
            'tUserSessionID' => $tUserSessionID,
            'nSeqNo' => $nSeqNo,
        ];
        $this->mTopupVending->FSbDeleteInTmpBySeq($aDeleteInTmpBySeqParams);
    }

    /**
     * Functionality : Get Wah by Shp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Wah Data
     * Return Type : String
     */
    public function FStGetWahByShop()
    {
        $tShpCode = $this->input->post('tShpCode');
        $tBchCode = $this->input->post('tBchCode');

        $aGetWahByShopParams = [
            'tRefCode' => $tShpCode,
            'tBchCode' => $tBchCode
        ];
        $aWahByShp = $this->mTopupVending->FSaMGetWahByRefCode($aGetWahByShopParams);
        
        // $aDataDT = $this->mTopupVending->FSaMTFWGetDT($aDataWhere); // Data TVDTPdtTwxDT
        // $aStaIns = $this->mTopupVending->FSaMTFWInsertDTToTemp($aDataDT,$aDataWhere); // Insert Data DocTemp

        $aWahCodeByShp = [];
        $aWahNameByShp = [];

        foreach ($aWahByShp as $aValue) {
            $aWahCodeByShp[] = $aValue['FTWahCode'];
            $aWahNameByShp[] = $aValue['FTWahName'];
        }

        $tWahCodeByShp = FCNtArrayToString($aWahCodeByShp);
        $tWahNameByShp = FCNtArrayToString($aWahNameByShp);

        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode(['tWahCodeByShp' => $tWahCodeByShp, 'tWahNameByShp' => $tWahNameByShp]));
    }


     /**
     * Functionality : Delete Multi
     * Parameters : -
     * Creator : 04/02/2020 Wiitsarut
     * Last Modified : -
     * Return : Wah Data
     * Return Type : String
     */
    public function FSxCTUVTopupVendingDeleteMultiPdtLayoutInTmp(){
        try{

            $this->db->trans_begin();

            $aDataWhere = array(
                'FTXthDocNo'    => $this->input->post('tDocNo'),
                'FNXtdSeqNo'    => $this->input->post('tSeqNo'),
                'FTPdtCode'     => $this->input->post('tPdtCode'),
                'tUserSessionID' => $this->session->userdata("tSesSessionID"),
            );

            $this->mTopupVending->FSbDeleteMultiInTmpBySeq($aDataWhere);
            
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Cannot Delete Item.',
                );
            }else{
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaEvent'         => '1',
                    'tStaMessg'         => 'Success Delete Product'
                );
            }
        }catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    public function FSxCTVDDelPdtValueZero(){
        $aParams = [
            'FTXthDocKey'       => 'TVDTPdtTwxHD',
            'tUserSessionID'    => $this->session->userdata('tSesSessionID')
        ];
        $this->mTopupVending->FSxMTVDDelPdtTopupZero($aParams);
    }



    // Functionality : ลบข้อมูล Table DT Temp
    // Creator : 17/02/2022 Wasin (Yoshi)
    public function FSxCTUVTopupVendingDeleteDelDTTemp(){
        $tSessionID = $this->session->userdata("tSesSessionID");
        $aDataDelDT = array(
            'FTBchCode'     => $this->input->post('tBchCode'),
            'FTXthDocKey'   => 'TVDTPdtTwxHD',
            'FTXthDocNo'    => 'VWDOCTEMP',
            'FTSessionID'   => $tSessionID,
        );
        $aStaDelete = $this->mTopupVending->FSxMTVDDelDataInDT($aDataDelDT);
        echo json_encode($aStaDelete);
    }






}
