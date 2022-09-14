<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php');
require_once(APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/IOFactory.php');
require_once(APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php');

class cCardShiftRefund extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('document/cardshiftrefund/mCardShiftRefund');
        $this->load->model('authen/user/mUser');
        $this->load->model('company/company/mCompany');
        $this->load->model('company/vatrate/mVatrate');
        $this->load->library('upload');
        $this->load->helper('file');
    }

    /**
     * Functionality : Main page for Card Shift
     * Parameters : $nCardShiftRefundBrowseType, $tCardShiftRefundBrowseOption
     * Creator : 30/10/2018 piya + 13/08/2020 Supawat
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function index($nCardShiftRefundBrowseType, $tCardShiftRefundBrowseOption)
    {

        $nMsgResp = array('title' => "Card Shift Refund");
        $isXHR = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if (!$isXHR) {
            $this->load->view('common/wHeader', $nMsgResp);
            $this->load->view('common/wTopBar', array('nMsgResp' => $nMsgResp));
            $this->load->view('common/wMenu', array('nMsgResp' => $nMsgResp));
        }
        $vBtnSave = FCNaHBtnSaveActiveHTML('cardShiftRefund/0/0'); // Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aPermission = FCNaHCheckAlwFunc("cardShiftRefund/0/0");
        $this->load->view('document/cardshiftrefund/wCardShiftRefund', array(
            'nMsgResp' => $nMsgResp,
            'vBtnSave' => $vBtnSave,
            'aPermission' => $aPermission,
            'nCardShiftRefundBrowseType' => $nCardShiftRefundBrowseType,
            'tCardShiftRefundBrowseOption' => $tCardShiftRefundBrowseOption
        ));
    }

    /**
     * Functionality : Function Call Card Shift Page List
     * Parameters : Ajax and Function Parameter
     * Creator : 30/10/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCardShiftRefundListPage()
    {
        $aAlwEvent = FCNaHCheckAlwFunc('cardShiftRefund/0/0');
        $aNewData = array('aAlwEvent' => $aAlwEvent);
        $this->load->view('document/cardshiftrefund/wCardShiftRefundList', $aNewData);
    }

    /**
     * Functionality : Function Call DataTables Card Shift
     * Parameters : Ajax and Function Parameter
     * Creator : 30/10/2018 piya + 13/08/2020 Supawat
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCardShiftRefundDataList()
    {
        $nPage = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');
        $tAdvanceSearch = json_decode($this->input->post('tAdvanceSearch'));
        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nPageCurrent');
        }
        if (!$tSearchAll) {
            $tSearchAll = '';
        }

        // Lang ภาษา
        $nLangResort = $this->session->userdata("tLangID");
        $nLangEdit = $this->session->userdata("tLangEdit");

        $aData = array(
            'nPage' => $nPage,
            'nRow' => 10,
            'FNLngID' => $nLangEdit,
            'tSearchAll' => $tSearchAll,
            'tAdvanceSearch' => $tAdvanceSearch,
            'tUserLevel' => $this->session->userdata("tSesUsrLevel")
        );

        $tAPIReq = "";
        $tMethodReq = "GET";
        $aResList = $this->mCardShiftRefund->FSaMCardShiftRefundList($tAPIReq, $tMethodReq, $aData);
        $aAlwEvent = FCNaHCheckAlwFunc('cardShiftRefund/0/0');
        $aGenTable = array(
            'aAlwEvent' => $aAlwEvent,
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'tSearchAll' => $tSearchAll
        );
        $this->load->view('document/cardshiftrefund/wCardShiftRefundDataTable', $aGenTable);
    }

    /**
     * Functionality : Function Call DataTables Card Shift
     * Parameters : Ajax and Function Parameter
     * Creator : 30/10/2018 piya + 13/08/2020 Supawat
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCardShiftRefundDataSourceList()
    {
        $nPage = !empty($this->input->post('nPageCurrent')) ? $this->input->post('nPageCurrent') : 1;
        $tSearchAll = $this->input->post('tSearchAll');
        $tOptionDocNo = $this->input->post('tOptionDocNo');
        $tDocNo = $this->input->post('tDocNo');
        $aCardTypeRange = json_decode($this->input->post('tCardTypeRange'));
        $aCardNumberRange = json_decode($this->input->post('tCardNumberRange'));
        $aCardNumber = json_decode($this->input->post('tCardNumber'));
        $aNotInCardNumber = json_decode($this->input->post('tNotInCardNumber'));
        $tIsGetCardCodeMode = $this->input->post('tIsGetCardCodeMode');
        $tSetEmpty = $this->input->post('tSetEmpty');
        $tStaShift = $this->input->post('tStaShift');
        $tIsTemp = $this->input->post('tIsTemp');
        $tIsDataOnly = $this->input->post('tIsDataOnly');
        $tStaPrcDoc = $this->input->post('tStaPrcDoc');
        $tStaDoc = $this->input->post('tStaDoc');
        $tStaType = $this->input->post('tStaType');
        $tLastIndex = $this->input->post('tLastIndex');

        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nPageCurrent');
        }
        if (!$tSearchAll) {
            $tSearchAll = '';
        }
        // Lang ภาษา
        $nLangResort = $this->session->userdata("tLangID");
        $nLangEdit = $this->session->userdata("tLangEdit");

        if ($tIsGetCardCodeMode == "1") { // Use get card code mode

            $aData  = array(
                'nPage' => $nPage,
                'nRow' => 500,
                'FNLngID' => $nLangEdit,
                'tSearchAll' => $tSearchAll,
                'aCardNumber' => $aCardNumber,
                'aNotInCardNumber' => $aNotInCardNumber,
                'aCardTypeRange' => $aCardTypeRange,
                'aCardNumberRange' => $aCardNumberRange,
                'tSetEmpty' => $tSetEmpty,
                'FTCrdStaShift' => $tStaShift,
                'tStaType' => $tStaType,
                'FTCvhDocNo' => $tDocNo
            );

            if (!empty($tOptionDocNo)) { // Have document number
                // Get card in TopUpDT
                $aResList = $this->mCardShiftRefund->FSaMCardShiftRefundGetDTByDocNo($aData);
            } else { // No have document number
                // Get card in card master
                $aResList = $this->mCardShiftRefund->FSaMCardShiftRefundDataSourceList($aData);
                if ($tSetEmpty == "1") {
                    $aResList["raItems"] = [];
                }
            }

            if ($aResList["rtCode"] == "800") { // Query card fail
                $aResult = [];
                $aResult["rtCode"] = $aResList["rtCode"];
                echo json_encode($aResult);
                return;
            }

            $aResult = [];
            $aCard = [];
            foreach ($aResList["raItems"] as $nKey => $tValue) {
                $aCard[$nKey][0] = $tValue["rtCrdCode"];
                $aCard[$nKey][1] = $tValue["rtCrdHolderID"];
            }
            $aResult["raCard"] = $aCard;
            $aResult["rtCode"] = "1";
            echo json_encode($aResult);
        }

        $paParams['tSessionID'] = $this->session->userdata("tSesSessionID");
        $paParams['tSeqNo'] = "";
        $paParams['bStaCardShift'] = FALSE;
        $paParams['nCrdStaActive'] = 1;

        if ($tStaPrcDoc == "" && $tStaDoc == "") {
            // Validate document temp
            //(5)
            FSnHRefunChkCrdCodeFoundInDB($paParams);
            //(4)
            FSnHRefunChkCrdCodeNotDupTemp($paParams);
            //(8)
            FSnHRefunChkStaShiftInCard($paParams);
            //(9)
            FSnHRefunChkStaActiveInCard($paParams);
            //(12)
            FSnHRefunChkCardExpireDate($paParams);

            FSnHRefunChkCardBal($paParams);
        } else {
            if ($tStaPrcDoc == "" && $tStaDoc == "1") { // Document pending status(approve) or complete status(doc status)
                // Validate document temp
                //(5)
                FSnHRefunChkCrdCodeFoundInDB($paParams);
                //(4)
                FSnHRefunChkCrdCodeNotDupTemp($paParams);
                //(8)
                FSnHRefunChkStaShiftInCard($paParams);
                //(9)
                FSnHRefunChkStaActiveInCard($paParams);
                //(12)
                FSnHRefunChkCardExpireDate($paParams);

                FSnHRefunChkCardBal($paParams);
            }
        }

        // Call data on temp helper
        $aDataTemp  = array(
            'nPage' => $nPage,
            'nRow' => 10,
            'FNLngID' => $nLangEdit,
            'tSearchAll' => $tSearchAll,
            'FTBchCode' => "",
            'ptDocType' => "cardShiftRefund"
        );

        $aCardRefundFromTemp = FSaSelectDataForDocType($aDataTemp);
        $aCardRefundCode = FSaSelectAllBySessionID("cardShiftRefund");

        $aGenTable = array(
            'aDataList' => $aCardRefundFromTemp,
            'tDataListAll' => json_encode($aCardRefundCode),
            'rnAllRow' => !empty($aCardRefundCode['rnAllRow']) ? $aCardRefundCode['rnAllRow'] : null,
            'ptDocType' => "CardTnfRefundCard",
            'tIDElement' => "",
            'tIsTemp' => $tIsTemp,
            'tIsDataOnly' => $tIsDataOnly,
            'nPage' => $nPage,
            'tSearchAll' => $tSearchAll,
            'tStaPrcDoc' => $tStaPrcDoc,
            'tStaDoc' => $tStaDoc,
            'tLastIndex' => $tLastIndex,
            'tOptionDocNo' => $tOptionDocNo
        );

        $this->load->view('document/cardshiftrefund/wCardShiftRefundDataSourceTable', $aGenTable);
    }

    /**
     * Functionality : Insert card data to document temp
     * Parameters : {params}
     * Creator : 07/01/2018 Krit(Copter) + 13/08/2020 Supawat
     * Last Modified : -
     * Return : {return}
     * Return Type : {type}
     */
    public function FSxCardShiftRefundInsertToTemp()
    {
        $tUsrBchCode = $this->input->post('tBCHCode');
        $tUserCode = $this->session->userdata("tSesUsername");
        $tInsertType = $this->input->post('tInsertType');
        $tDocNo = $this->input->post('tDocNo');

        $tDocType = "cardShiftRefund";
        if ($tInsertType == "between") {
            $aRangeCardCode = json_decode($this->input->post('tRangeCardCode'));
            $aRangeCardType = json_decode($this->input->post('tRangeCardType'));
            $aCardCode = json_decode($this->input->post('tCardCode'));
            $tValue = $this->input->post("tValue");
            $tDataSetType = "Between";
            $aDataSet = [
                "tDocNo" => $tDocNo,
                "tBchCode" => $tUsrBchCode,
                "tCtdCrdTP" => intval($tValue),
                "tCreateBy" => $tUserCode,
                "aCardCode" => $aRangeCardCode,
                "aCardType" => $aRangeCardType
            ];
        }

        if ($tInsertType == "choose") {
            $aCardCode = json_decode($this->input->post('tCard'));
            $tValue = $this->input->post("tValue");

            $tDataSetType = "ChooseCard";
            $aDataSet = [
                "tDocNo" => $tDocNo,
                "tBchCode" => $tUsrBchCode,
                "tCtdCrdTP" => intval($tValue),
                "tCreateBy" => $tUserCode,
                "aCardCode" => $aCardCode
            ];
        }

        echo FCNaCARDInsertDataToTemp($tDocType, $tDataSetType, [], $aDataSet);
    }

    /**
     * Functionality : Update card data in document temp by row
     * Parameters : {params}
     * Creator : 07/01/2018 Krit(Copter)
     * Last Modified : -
     * Return : {return}
     * Return Type : {type}
     */
    public function FSxCardShiftRefundUpdateInlineOnTemp()
    {
        $tDocType = "cardShiftRefund";
        $nSeq = $this->input->post('nSeq');
        $tCardCode = $this->input->post('tCardCode');
        $tCardValue = $this->input->post('tCardValue');
        $tRmk = $this->input->post('tRmk');

        $aDataSet = [
            "tCardCode" => $tCardCode,
            "tCardValue" => $tCardValue,
            "tRmk" => $tRmk
        ];

        FSxUpdateTempBySeq($tDocType, $nSeq, $aDataSet);
    }

    /**
     * Functionality : Function Call DataTables Card Shift by file (xls or xlsx)
     * Parameters : Ajax and Function Parameter
     * Creator : 06/11/2018 piya + 13/08/2020 Supawat
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCardShiftRefundDataSourceListByFile()
    {
        $nPage = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');
        $aCardTypeRange = json_decode($this->input->post('tCardTypeRange'));
        $aCardNumberRange = json_decode($this->input->post('tCardNumberRange'));
        $aCardNumber = json_decode($this->input->post('tCardNumber'));
        $aNotInCardNumber = json_decode($this->input->post('tNotInCardNumber'));
        $tSetEmpty = $this->input->post('tSetEmpty');
        $tStaShift = $this->input->post('tStaShift');
        $tIsTemp = $this->input->post('tIsTemp');
        $tIsDataOnly = $this->input->post('tIsDataOnly');
        $tStaPrcDoc = $this->input->post('tStaPrcDoc');
        $tDocNo = $this->input->post('tDocNo');
        $tStaDoc = $this->input->post('tStaDoc');
        $tStaType = $this->input->post('tStaType');
        $tLastIndex = $this->input->post('tLastIndex');
        $tBchCode = $this->input->post('tBchCode');

        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nPageCurrent');
        }
        if (!$tSearchAll) {
            $tSearchAll = '';
        }

        // Lang ภาษา
        $nLangEdit = $this->session->userdata("tLangEdit");

        $aData  = array(
            'nPage' => $nPage,
            'nRow' => 500,
            'FNLngID' => $nLangEdit,
            'tSearchAll' => $tSearchAll,
            'aCardNumber' => $aCardNumber,
            'aNotInCardNumber' => $aNotInCardNumber,
            'aCardTypeRange' => $aCardTypeRange,
            'aCardNumberRange' => $aCardNumberRange,
            'tSetEmpty' => $tSetEmpty,
            'FTCrdStaShift' => $tStaShift,
            'tStaType' => $tStaType,
            'FTXshDocNo' => $tDocNo
        );

        $aCompany = $this->mCompany->FSaMCMPList("", "", $aData);
        $aActiveVatrate = [];
        if ($aCompany["rtCode"] == "1") {
            $aData['FTVatCode'] = $aCompany["raItems"]["rtVatCodeUse"];
            $aVatrate = $this->mVatrate->FSaMVATSearchByID($aData);
            if ($aVatrate['rtCode'] == "1") {
                $aActiveVatrate = FCNaHVATDateActive($aVatrate);
            }
        }
        // $aResList = $this->mCardShiftRefund->FSaMCardShiftRefundDataSourceList($aData);
        // $aCardShiftRefundHD = $this->mCardShiftRefund->FSaMCardShiftRefundSearchByID("", "", $aData);

        if ((FCNnHSizeOf($_FILES) > 0)) {

            //Insert
            $aDataFiles = (isset($_FILES['aFile']) && !empty($_FILES['aFile'])) ? $_FILES['aFile'] : null;
            $ptDocType = 'cardShiftRefund'; //CardTnf
            $ptDataSetType = 'Excel';
            $paDataExcel = array(
                'file' => $aDataFiles,
                'reasonfile' => '',
                'optionfile_newcard' => 0,
                'nDocno' => $this->input->post('tDocNo'),
                'tBCHCode' => $tBchCode
            );
            $paDataSet = array('');
            if (isset($_FILES['aFile'])) {
                $tResult = FCNaCARInsertDataToTempFileCenter($ptDocType, $ptDataSetType, $paDataExcel, $paDataSet);
            }

            // Update Join Value For Refund
            // FCNCardShiftRefundJoinUpdateValue();

            if ($tResult['nStaEvent'] == 1) {
                $aDataReturn = array(
                    'tStaLog' => 'Success',
                    'tDocType' => $ptDocType
                );
                echo json_encode($aDataReturn);
            } else {
                $aDataReturn = array(
                    'tStaLog' => $tResult['tTextError'],
                    'tDocType' => $ptDocType
                );
                echo json_encode($aDataReturn);
            }
        }
    }

    /**
     * Functionality : Function CallPage Card Shift Add
     * Parameters : Ajax and Function Parameter
     * Creator : 30/10/2018 piya + 13/08/2020 Supawat
     * Last Modified : 04/08/2020 Napat(Jame) เบื้องต้นแก้ไขเพื่อให้ใช้งานได้ก่อน
     * Return : String View
     * Return Type : View
     */
    public function FSvCardShiftRefundAddPage()
    {

        $nLangResort = $this->session->userdata("tLangID");
        $nLangEdit = $this->session->userdata("tLangEdit");

        $aData = array(
            'FNLngID' => $nLangEdit,
            'FTUsrCode' => $this->session->userdata("tSesUsername")
        );

        $aUser = $this->mUser->FSaMUSRByID($aData);

        
        $aCompany = $this->mCompany->FSaMCMPList("", "", $aData);
        $aActiveVatrate = [];
        if ($aCompany["rtCode"] == "1") {
            $aData['FTVatCode'] = $aCompany["raItems"]["rtVatCodeUse"];
            $aVatrate = $this->mVatrate->FSaMVATSearchByID($aData);
            if ($aVatrate['rtCode'] == "1") {
                $aActiveVatrate = FCNaHVATDateActive($aVatrate);
            }
        }

        $aDataAdd = array(
            'aResult'      => ['rtCode' => '99'],
            'aUserCreated' => ['rtCode' => '99'],
            'aUserApv'     => ['rtCode' => '99'],
            'nLangEdit'    => $nLangEdit,
            'aUser'        => $aUser,
            'aCardCode'    => [],
            'aActiveVatrate' => $aActiveVatrate
        );

        $this->load->view('document/cardshiftrefund/wCardShiftRefundAdd', $aDataAdd);
    }

    /**
     * Functionality : Function CallPage Card Shift Edit
     * Parameters : Ajax and Function Parameter
     * Creator : 30/10/2018 piya + 13/08/2020 Supawat
     * Last Modified : 04/08/2020 Napat(Jame) เบื้องต้นแก้ไขเพื่อให้ใช้งานได้ก่อน
     * Return : String View
     * Return Type : View
     */
    public function FSvCardShiftRefundEditPage()
    {

        $tCardShiftRefundDocNo  = $this->input->post('tCardShiftRefundDocNo');
        $nLangResort = $this->session->userdata("tLangID");
        $nLangEdit = $this->session->userdata("tLangEdit");
        $aPermission = FCNaHCheckAlwFunc("cardShiftRefund/0/0");

        $aData  = array(
            'FTXshDocNo' => $tCardShiftRefundDocNo,
            'FNLngID' => $nLangEdit,
            'FTUsrCode' => $this->session->userdata("tSesUsername")
        );

        $aCompany = $this->mCompany->FSaMCMPList("", "", $aData);
        $aActiveVatrate = [];
        if ($aCompany["rtCode"] == "1") {
            $aData['FTVatCode'] = $aCompany["raItems"]["rtVatCodeUse"];
            $aVatrate = $this->mVatrate->FSaMVATSearchByID($aData);
            if ($aVatrate['rtCode'] == "1") {
                $aActiveVatrate = FCNaHVATDateActive($aVatrate);
            }
        }

        $aUserApv     = $this->mUser->FSaMUSRByID($aData);
        $aUser        = $this->mUser->FSaMUSRByID($aData);
        $aUserCreated = $this->mUser->FSaMUSRByID($aData);
        


        $tAPIReq = "";
        $tMethodReq = "GET";
        $aCardShiftRefundData = $this->mCardShiftRefund->FSaMCardShiftRefundSearchByID($tAPIReq, $tMethodReq, $aData);

        $aData['FTBchCode'] = $aCardShiftRefundData['raItems']['rtCardShiftRefundBchCode'];
        $aData['FTXshDocNo'] = $aCardShiftRefundData['raItems']['rtCardShiftRefundDocNo'];
        $aCardShiftRefundCardDataInDT = $this->mCardShiftRefund->FSaMCardShiftRefundGetDTByDocNo($aData);

        // Remove in temp
        FCNoCARDataListDeleteOnlyTable("TFNTCrdTopUpTmp");

        // Copy from DT to temp
        FSxDocHelperDTToTemp("cardShiftRefund", $aData['FTXshDocNo']);

        $aDataEdit = array(
            'aResult' => $aCardShiftRefundData,
            'aActiveVatrate' => $aActiveVatrate,
            'aPermission' => $aPermission,
            'nLangEdit' => $nLangEdit,
            'aUserCreated'  => $aUserCreated,
            'aUserApv'  => $aUserApv,
            'aUser'     => $aUser
        );

        $this->load->view('document/cardshiftrefund/wCardShiftRefundAdd', $aDataEdit);
    }

    /**
     * Functionality : Event Add Card Shift
     * Parameters : Ajax and Function Parameter
     * Creator : 30/10/2018 piya + 13/08/2020 Supawat
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaCardShiftRefundAddEvent()
    {
        $aDataMaster = array(
            'tIsAutoGenCode' => $this->input->post('ocbCardShiftRefundAutoGenCode'),
            'FTXshDocNo' => $this->input->post('oetCardShiftRefundCode'),
            'FDXshDocDate' => $this->input->post('oetCardShiftRefundDocDate') . ' ' . date('H:i:s'),
            'FNXshDocType' => "11", // Take refund card
            'FTBchCode' => $this->input->post('ohdCardShiftRefundUsrBchCode'),
            'FTUsrCode' => $this->input->post("ohdCardShiftRefundUserCreatedCode"),
            'FNXshCardQty' => FSnSelectCountResult('TFNTCrdTopUpTmp'),
            'FCXshTotal' => empty($this->input->post('oetCardShiftRefundTotalValue')) ? 0 : $this->input->post('oetCardShiftRefundTotalValue'),
            'aCardCode' => json_decode($this->input->post('aCardCode')),
            'FTXshApvCode' => $this->input->post('ohdCardShiftRefundApvCode'),
            'FTXshStaPrcDoc' => $this->input->post('ohdCardShiftRefundCardStaPrcDoc'),
            'FTXshStaDoc' => empty($this->input->post('hdCardShiftRefundCardStaDoc')) ? "1" : $this->input->post('hdCardShiftRefundCardStaDoc'),
            'FNXshStaDocAct' => empty($this->input->post('hdCardShiftRefundCardStaDoc')) ? 1 : $this->input->post('hdCardShiftRefundCardStaDoc'),
            'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
            'FDLastUpdOn' => date('Y-m-d H:i:s'),
            'FTCreateBy' => $this->session->userdata('tSesUsername'),
            'FDCreateOn' => date('Y-m-d H:i:s'),
            'FNLngID' => $this->session->userdata("tLangEdit")
        );

        // Setup DocNo
        if ($aDataMaster['tIsAutoGenCode'] == '1') { // Check Auto Gen DocNo?
            // Auto Gen DocNo Code
            $aStoreParam = array(
                "tTblName" => 'TFNTCrdTopUpHD',
                "tDocType" => '4',
                "tBchCode" => $aDataMaster['FTBchCode'],
                "tShpCode" => "",
                "tPosCode" => "",
                "dDocDate" => date("Y-m-d")
            );
            $aAutogen = FCNaHAUTGenDocNo($aStoreParam);
            $aDataMaster['FTXshDocNo'] = $aAutogen[0]["FTXxhDocNo"];
        }

        $oCountDup = $this->mCardShiftRefund->FSoMCardShiftRefundCheckDuplicate($aDataMaster['FTXshDocNo']);
        $nStaDup = $oCountDup[0]->counts;

        if ($nStaDup == 0) {
            $this->db->trans_begin();

            $aStaCardShiftRefundHD = $this->mCardShiftRefund->FSaMCardShiftRefundAddUpdateHD($aDataMaster);

            if ($aStaCardShiftRefundHD['rtCode'] == "1") {

                // Update DocNo on Temp
                FCNCallUpdateDocNo($aDataMaster['FTXshDocNo'], 'TFNTCrdTopUpTmp', ["tBchCode" => $aDataMaster['FTBchCode']]);

                // Copy from temp to DT
                FSxDocHelperTempToDT("cardShiftRefund");

                // Remove in temp
                FCNoCARDataListDeleteOnlyTable("TFNTCrdTopUpTmp");
            }

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent' => '900',
                    'tStaMessg' => "Unsucess Add Event"
                );
            } else {
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack' => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn' => $aDataMaster['FTXshDocNo'],
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success Add Event'
                );
            }
        } else {
            $aReturn = array(
                'nStaEvent' => '801',
                'tStaMessg' => "Data Code Duplicate"
            );
        }
        echo json_encode($aReturn);
    }

    /**
     * Functionality : Event Edit Card Shift
     * Parameters : Ajax and Function Parameter
     * Creator : 30/10/2018 piya + 13/08/2020 Supawat
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaCardShiftRefundEditEvent()
    {
        try {
            $aDataMaster = array(
                'FTXshDocNo' => $this->input->post('oetCardShiftRefundCode'),
                'FDXshDocDate' => $this->input->post('oetCardShiftRefundDocDate') . ' ' . date('H:i:s'),
                'FNXshDocType' => "11", // Take refund card
                'FTBchCode' => $this->input->post('ohdCardShiftRefundUsrBchCode'),
                'FCXshTotal' => empty($this->input->post('oetCardShiftRefundTotalValue')) ? 0 : $this->input->post('oetCardShiftRefundTotalValue'),
                'FNXshCardQty' => FSnSelectCountResult('TFNTCrdTopUpTmp'),
                'cRefund' => $this->input->post('oetCardShiftRefundCardValue'),
                'aCardCode' => json_decode($this->input->post('aCardCode')),
                'FTXshApvCode' => $this->input->post('ohdCardShiftRefundApvCode'),
                'FTXshStaPrcDoc' => $this->input->post('ohdCardShiftRefundCardStaPrcDoc'),
                'FTXshStaDoc' => empty($this->input->post('hdCardShiftRefundCardStaDoc')) ? "1" : $this->input->post('hdCardShiftRefundCardStaDoc'),
                'FNXshStaDocAct' => empty($this->input->post('hdCardShiftRefundCardStaDocAct')) ? 1 : $this->input->post('hdCardShiftRefundCardStaDocAct'),
                'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FTCreateBy' => $this->session->userdata('tSesUsername'),
                'FDCreateOn' => date('Y-m-d H:i:s'),
                'FNLngID' => $this->session->userdata("tLangEdit"),
            );

            $this->db->trans_begin();

            $aCardShiftRefundHD = $this->mCardShiftRefund->FSaMCardShiftRefundSearchByID("", "", $aDataMaster);
            if (
                ($aCardShiftRefundHD['rtCode'] == "1") // Query HD success
                && (empty($aCardShiftRefundHD["raItems"]['rtCardShiftRefundStaPrcDoc'])) // On pending approve status 
                && ($aCardShiftRefundHD["raItems"]['rtCardShiftRefundStaDoc'] == "1") // On document complete status
            ) {
                // $nCthTotalTP = $aDataMaster['cRefund'] * $this->input->post('aValue'); // Cale total value
                // $aDataMaster['FCXshTotal'] = $nCthTotalTP;

                $aStaCardShiftRefundHD = $this->mCardShiftRefund->FSaMCardShiftRefundAddUpdateHD($aDataMaster);

                /*=============================================================*/
                if (FCNnHSizeOf($aDataMaster['aCardCode']) <= 0) { // No have card
                    // 2.Remove old DT all
                    $this->mCardShiftTopUp->FSnMCardShiftRefundDelDT($aDataMaster);
                }

                /*=============================================================*/
                if (
                    ($aStaCardShiftRefundHD['rtCode'] == "1") // Update HD success
                ) {
                    $paParams['tDocType'] = "cardShiftRefund";
                    $paParams['tDocNo'] = $aDataMaster['FTXshDocNo'];

                    // Remove on DT
                    FSaDeleteDatainTableDT($paParams);

                    // Update DocNo on Temp
                    FCNCallUpdateDocNo($aDataMaster['FTXshDocNo'], 'TFNTCrdTopUpTmp', ["tBchCode" => $aDataMaster['FTBchCode']]);

                    // Copy from Temp to DT
                    FSxDocHelperTempToDT("cardShiftRefund");

                    // Remove in temp
                    FCNoCARDataListDeleteOnlyTable("TFNTCrdTopUpTmp");
                }

                /*=============================================================*/
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent' => '900',
                    'tStaMessg' => "Unsucess Add Event"
                );
            } else {
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack' => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn' => $aDataMaster['FTXshDocNo'],
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success Add Event'
                );
            }
            echo json_encode($aReturn);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    /**
     * Functionality : Event Edit Card Shift
     * Parameters : Ajax and Function Parameter
     * Creator : 30/10/2018 piya + 13/08/2020 Supawat
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaCardShiftRefundUpdateApvDocAndCancelDocEvent()
    {
        $aDataMaster = array(
            'FTXshDocNo' => $this->input->post('oetCardShiftRefundCode'),
            'FDXshDocDate' => $this->input->post('oetCardShiftRefundDocDate') . ' ' . date('H:i:s'),
            'FNXshDocType' => "11", // Take refund card
            'FTBchCode' => $this->input->post('ohdCardShiftRefundUsrBchCode'),
            'FTUsrCode' => $this->session->userdata("tSesUsername"),
            'FCXshTotal' => $this->input->post('oetCardShiftRefundTotalValue'),
            'FNXshCardQty' => count(json_decode($this->input->post('aCardCode'))),
            'FCXshTotal' => $this->input->post('oetCardShiftRefundCardValue'),
            'aCardCode' => json_decode($this->input->post('aCardCode')),
            'FTXshApvCode' => $this->input->post('ohdCardShiftRefundApvCode'),
            'FTXshStaPrcDoc' => $this->input->post('ohdCardShiftRefundCardStaPrcDoc'),
            'FTXshStaDoc' => empty($this->input->post('hdCardShiftRefundCardStaDoc')) ? "1" : $this->input->post('hdCardShiftRefundCardStaDoc'),
            'FNXshStaDocAct' => empty($this->input->post('hdCardShiftRefundCardStaDocAct')) ? 1 : $this->input->post('hdCardShiftRefundCardStaDocAct'),
            'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
            'FDLastUpdOn' => date('Y-m-d H:i:s'),
            'FTCreateBy' => $this->session->userdata('tSesUsername'),
            'FDCreateOn' => date('Y-m-d H:i:s'),
            'FNLngID' => $this->session->userdata("tLangEdit")
        );

        $this->db->trans_begin();

        $aCardShiftRefundHD = $this->mCardShiftRefund->FSaMCardShiftRefundSearchByID("", "", $aDataMaster);

        if (($aDataMaster['FTXshStaPrcDoc'] == "2") // Update status approve is true
            && ($aCardShiftRefundHD['rtCode'] == "1") // Query HD success
            && (empty($aCardShiftRefundHD["raItems"]['rtCardShiftRefundStaPrcDoc'])) // On pending approve status 
            && ($aCardShiftRefundHD["raItems"]['rtCardShiftRefundStaDoc'] == "1") // On document complete status
        ) {
            $aStaCardShiftRefundHD = $this->mCardShiftRefund->FSaMCardShiftRefundUpdateApvDocAndCancelDocHD($aDataMaster);
            $aGetDTByDocNo = $this->mCardShiftRefund->FSaMCardShiftRefundGetDTByDocNo($aDataMaster);

            /*===== Begin Set Card Item ============================================*/
            $aCardItems = [];
            if ($aGetDTByDocNo['rtCode'] == "1") {
                foreach ($aGetDTByDocNo['raItems'] as $aItem) {
                    $aCardItems['paItem'][] = [
                        "pnLngID"           => $aDataMaster['FNLngID'],
                        "ptBchCode"         => $aDataMaster['FTBchCode'],
                        "ptTxnDocNoRef"     => $aDataMaster['FTXshDocNo'],
                        "ptCrdCode"         => $aItem['rtCardShiftRefundCrdCode'],
                        "ptShpCode"         => "",
                        "ptTxnPosCode"      => "",
                        "pcTxnCrdValue"     => $aItem['rtCardShiftTopUpCrdBal'],
                        "pcTxnValue"        => $aItem['rtCardShiftRefundCrdTP'],
                        "pcTxnPmt"          => $aItem['rtCardShiftTopUpAmtPmt'],
                        "ptUsrCode"         => $aDataMaster['FTUsrCode'],
                        "pcAvailable"       => $aItem['rtCardShiftTopUpValidCrdVal']
                    ];
                }
            }
            /*===== End Set Card Item ==============================================*/

            /*========================== Approved =========================*/
            try {
                /* Params MQ
                {
                "ptFunction":"CardListVoidTopup", < ชื่อ Function
                "ptSource":"", < ต้นทาง
                "ptDest":"MQWallet", < ปลายทาง
                "ptFilter":"", < data fillter
                "ptData": "{"paItem":[
                        {
                        "pnLngID":1,
                        "ptBchCode":"00001",
                        "ptTxnDocNoRef":"CV000012000001",
                        "ptCrdCode":"C0001",
                        "ptShpCode":"",
                        "ptTxnPosCode":"",
                        "pcTxnCrdValue":0.00,
                        "pcTxnValue":0.00,
                        "pcTxnPmt":0.00,
                        "ptUsrCode":"009"
                        },{
                        "pnLngID":1,
                        "ptBchCode":"",
                        "ptTxnDocNoRef":"CV000012000001",
                        "ptCrdCode":"C0002",
                        "ptShpCode":"",
                        "ptTxnPosCode":"",
                        "pcTxnCrdValue":0.00,
                        "pcTxnValue":0.00,
                        "pcTxnPmt":0.00,
                        "ptUsrCode":"009"
                        }]}"
                }
                */
                $aMQParams = [
                    "tVhostType" => "W",
                    "queueName" => "FN_QPosPrc",
                    "bStaUseConnStr" => false,
                    "params" => [
                        "ptFunction" => "CardListCheckOut",
                        "ptSource" => "AdaStoreBack",
                        "ptDest" => "MQWalletPrc",
                        "ptFilter" => "",
                        "ptDocNo" => $aDataMaster['FTXshDocNo'],
                        "ptData" => json_encode($aCardItems)
                    ]
                ];
                FCNxCallRabbitMQ($aMQParams);
            } catch (\ErrorException $err) {
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent' => '900',
                    'tStaMessg' => language('document/card/cardrefund', 'tCardShiftRefundApproveFail')
                );
                echo json_encode($aReturn);
                return;
            }
            /*=============================================================*/
        }

        /*=============================== Cancel ==========================*/
        if (($aDataMaster['FTXshStaDoc'] == "3")) { // Have card and update status document is cancel
            $aStaCardShiftRefundHD = $this->mCardShiftRefund->FSaMCardShiftRefundUpdateApvDocAndCancelDocHD($aDataMaster);
        }
        /*=============================================================*/

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent' => '900',
                'tStaMessg' => "Unsucess Update Event"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaCallBack' => $this->session->userdata('tBtnSaveStaActive'),
                'tCodeReturn' => $aDataMaster['FTXshDocNo'],
                'nStaEvent' => '1',
                'tStaMessg' => 'Success Update Event'
            );
        }
        echo json_encode($aReturn);
    }

    /**
     * Functionality : Event Delete Card Shift
     * Parameters : Ajax and Function Parameter
     * Creator : 30/10/2018 piya
     * Last Modified : -
     * Return : Status Delete Event
     * Return Type : String
     */
    public function FSaCardShiftRefundDeleteEvent()
    {
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTCardShiftRefundCode' => $tIDCode
        );

        $aResDel = $this->mCardShiftRefund->FSnMCardShiftRefundDel($aDataMaster);
        $aReturn = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }

    /**
     * Functionality : Vatrate unique check
     * Parameters : $tSelect "CardShiftRefundcode"
     * Creator : 30/10/2018 piya
     * Last Modified : -
     * Return : Check status true or false
     * Return Type : String
     */
    public function FStCardShiftRefundUniqueValidate($tSelect = '')
    {
        if ($this->input->is_ajax_request()) { // Request check
            if ($tSelect == 'cardShiftRefundCode') {

                $tCardShiftRefundCode = $this->input->post('tCardShiftRefundCode');
                $oCustomerGroup = $this->mCardShiftRefund->FSoMCardShiftRefundCheckDuplicate($tCardShiftRefundCode);

                $tStatus = 'false';
                if ($oCustomerGroup[0]->counts > 0) { // If have record
                    $tStatus = 'true';
                }
                echo $tStatus;
                return;
            }
            echo 'Param not match.';
        } else {
            echo 'Method Not Allowed';
        }
    }

    /**
     * Functionality : Delete vat rate
     * Parameters : -
     * Creator : 30/10/2018 piya
     * Last Modified : -
     * Return : Vat code
     * Return Type : Object
     */
    public function FSoCardShiftRefundDelete()
    {
        $tDocNo = $this->input->post('tDocNo');
        $tBchCode = $this->input->post('tBchCode');

        $aCardShiftRefundDelParams = [
            'tDocNo' => $tDocNo,
            'tDocType' => '11',
            'tBchCode' => $tBchCode
        ];
        $this->mCardShiftRefund->FSnMCardShiftRefundDel($aCardShiftRefundDelParams);

        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($tDocNo));
    }

    /**
     * Functionality : Function Event Multi Delete
     * Parameters : Ajax Function Delete Card Shift
     * Creator : 09/10/2018 piya
     * Last Modified : -
     * Return : Status Event Delete And Status Call Back Event
     * Return Type : object
     */
    public function FSoCardShiftRefundDeleteMulti()
    {
        $tDocData = $this->input->post('aDocData');

        $aDocData = json_decode($tDocData);
        foreach ($aDocData as $oDoc) {
            $aCardShiftRefundDelParams = [
                'tDocNo' => $oDoc->tDocNo,
                'tDocType' => '11',
                'tBchCode' => $oDoc->tBchCode
            ];
            $this->mCardShiftRefund->FSnMCardShiftRefundDel($aCardShiftRefundDelParams);
        }

        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aDocData));
    }

    //ค้นหา แบบยิง Barcode
    public function FSaCardShiftRefundScannerEvent(){
        $aData = array(
            'tAgnCode'        => $this->session->userdata('tSesUsrAgnCode'),
            'tCrdCode'        => $this->input->post('tScannerID'),
            'tLangID'         => $this->session->userdata("tLangID"),
            'nCountNumber'    => $this->input->post('nCountNumber')
        );
        $aResList = $this->mCardShiftRefund->FSaMCardShiftRefundListScanner($aData);
        echo json_encode($aResList);
    }
}
