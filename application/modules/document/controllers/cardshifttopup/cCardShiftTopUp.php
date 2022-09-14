<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php');
require_once(APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/IOFactory.php');
require_once(APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php');

class cCardShiftTopUp extends MX_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('document/cardshifttopup/mCardShiftTopUp');
        $this->load->model('authen/user/mUser');
        $this->load->model('company/company/mCompany');
        $this->load->model('company/vatrate/mVatrate');
        $this->load->library('upload');
        $this->load->helper('file');
    }

    /**
     * Functionality : Main page for Card Shift
     * Parameters : $nCardShiftTopUpBrowseType, $tCardShiftTopUpBrowseOption
     * Creator : 30/10/2018 piya + 13/08/2020 Supawat
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function index($nCardShiftTopUpBrowseType, $tCardShiftTopUpBrowseOption)
    {
        $nMsgResp = array('title' => "Card Shift TopUp");
        $isXHR = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if (!$isXHR) {
            $this->load->view('common/wHeader', $nMsgResp);
            $this->load->view('common/wTopBar', array('nMsgResp' => $nMsgResp));
            $this->load->view('common/wMenu', array('nMsgResp' => $nMsgResp));
        }
        $vBtnSave = FCNaHBtnSaveActiveHTML('cardShiftTopUp/0/0'); // Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aPermission = FCNaHCheckAlwFunc("cardShiftTopUp/0/0");
        $this->load->view('document/cardshifttopup/wCardShiftTopUp', array(
            'nMsgResp' => $nMsgResp,
            'vBtnSave' => $vBtnSave,
            'aPermission' => $aPermission,
            'nCardShiftTopUpBrowseType' => $nCardShiftTopUpBrowseType,
            'tCardShiftTopUpBrowseOption' => $tCardShiftTopUpBrowseOption
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
    public function FSvCardShiftTopUpListPage()
    {
        $aAlwEvent = FCNaHCheckAlwFunc('cardShiftTopUp/0/0');
        $aNewData = array('aAlwEvent' => $aAlwEvent);
        $this->load->view('document/cardshifttopup/wCardShiftTopUpList', $aNewData);
    }

    /**
     * Functionality : Function Call DataTables Card Shift
     * Parameters : Ajax and Function Parameter
     * Creator : 30/10/2018 piya  + 13/08/2020 Supawat
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCardShiftTopUpDataList()
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
        $aResList = $this->mCardShiftTopUp->FSaMCardShiftTopUpList($tAPIReq, $tMethodReq, $aData);
        $aAlwEvent = FCNaHCheckAlwFunc('cardShiftTopUp/0/0');
        $aGenTable = array(
            'aAlwEvent' => $aAlwEvent,
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'tSearchAll' => $tSearchAll
        );
        $this->load->view('document/cardshifttopup/wCardShiftTopUpDataTable', $aGenTable);
    }

    /**
     * Functionality : Function Call DataTables Card Shift
     * Parameters : Ajax and Function Parameter
     * Creator : 30/10/2018 piya  + 13/08/2020 Supawat
     * Last Modified : 14/1/2019 piya update tDataListAll, rnAllRow in $aGenTable
     * Return : String View
     * Return Type : View
     */
    public function FSvCardShiftTopUpDataSourceList()
    {
        $nPage = !empty($this->input->post('nPageCurrent')) ? $this->input->post('nPageCurrent') : 1;
        $tSearchAll = $this->input->post('tSearchAll');
        $tOptionDocNo = $this->input->post('tOptionDocNo');
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

        $paParams['tSessionID'] = $this->session->userdata("tSesSessionID");
        $paParams['tSeqNo'] = "";
        $paParams['bStaCardShift'] = false;
        $paParams['nCrdStaActive'] = 1;

        if ($tStaPrcDoc == "" and $tStaDoc == "") {
            // Validate document temp
            //(5)
            FSnHTopUpChkCrdCodeFoundInDB($paParams);

            //(4)
            FSnHTopUpChkCrdCodeNotDupTemp($paParams);

            //(8)
            FSnHTopUpChkStaShiftInCard($paParams);

            //(9)
            FSnHTopUpChkStaActiveInCard($paParams);

            //(12)
            FSnHTopUpChkCardExpireDate($paParams);
        } else {
            if ($tStaPrcDoc == "" and $tStaDoc == "1") { // Document pending status(approve) or complete status(doc status)
                // Validate document temp
                //(5)
                FSnHTopUpChkCrdCodeFoundInDB($paParams);

                //(4)
                FSnHTopUpChkCrdCodeNotDupTemp($paParams);

                //(8)
                FSnHTopUpChkStaShiftInCard($paParams);

                //(9)
                FSnHTopUpChkStaActiveInCard($paParams);

                //(12)
                FSnHTopUpChkCardExpireDate($paParams);
            }
        }

        // Call data on temp helper
        $aDataTemp  = array(
            'nPage' => $nPage,
            'nRow' => 10,
            'FNLngID' => $nLangEdit,
            'tSearchAll' => $tSearchAll,
            'FTBchCode' => "",
            'ptDocType' => "TopUp"
        );
        $aCardTopUpFromTemp = FSaSelectDataForDocType($aDataTemp);
        $aCardTopUpCode = FSaSelectAllBySessionID("cardShiftTopUp");

        $aGenTable = array(
            'aDataList' => $aCardTopUpFromTemp,
            'tDataListAll' => json_encode($aCardTopUpCode["raItems"]),
            'rnAllRow' => !empty($aCardTopUpCode['rnAllRow']) ? $aCardTopUpCode['rnAllRow'] : null,
            'ptDocType' => "TopUp",
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


        $this->load->view('document/cardshifttopup/wCardShiftTopUpDataSourceTable', $aGenTable);
    }

    /**
     * Functionality : Function CallPage Card Shift Add
     * Parameters : Ajax and Function Parameter
     * Creator : 30/10/2018 piya  + 13/08/2020 Supawat
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCardShiftTopUpAddPage()
    {

        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");

        $aData  = array(
            'FNLngID'   => $nLangEdit,
            'FTUsrCode' => $this->session->userdata("tSesUsername")
        );

        $aUser      = $this->mUser->FSaMUSRByID($aData);
        $aCompany   = $this->mCompany->FSaMCMPList("", "", $aData);
        $aActiveVatrate = [];
        if ($aCompany["rtCode"] == "1") {
            $aData['FTVatCode'] = $aCompany["raItems"]["rtVatCodeUse"];
            $aVatrate = $this->mVatrate->FSaMVATSearchByID($aData);
            if ($aVatrate['rtCode'] == "1") {
                $aActiveVatrate = FCNaHVATDateActive($aVatrate);
            }
        }

        $aDataAdd = array(
            'aResult'           => ['rtCode' => '99'],
            'aUser'             => $aUser,
            'aUserApv'          => ['rtCode' => '99'],
            'aActiveVatrate'    => $aActiveVatrate,
            'aCardCode'         => [],
            'nLangEdit'         => $nLangEdit,
            'aUserCreated'      => ['rtCode' => '99']
        );

        $this->load->view('document/cardshifttopup/wCardShiftTopUpAdd', $aDataAdd);
    }

    /**
     * Functionality : Function CallPage Card Shift Edit
     * Parameters : Ajax and Function Parameter
     * Creator : 30/10/2018 piya  + 13/08/2020 Supawat
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCardShiftTopUpEditPage()
    {

        $tCardShiftTopUpDocNo = $this->input->post('tCardShiftTopUpDocNo');
        $nLangResort = $this->session->userdata("tLangID");
        $nLangEdit = $this->session->userdata("tLangEdit");

        $aData  = array(
            'FTXshDocNo' => $tCardShiftTopUpDocNo,
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

        $aUser = $this->mUser->FSaMUSRByID($aData);
        $aPermission = FCNaHCheckAlwFunc("cardShiftTopUp/0/0");
        $tAPIReq = "";
        $tMethodReq = "GET";
        $aCardShiftTopUpData = $this->mCardShiftTopUp->FSaMCardShiftTopUpSearchByID($tAPIReq, $tMethodReq, $aData);

        $aData['FTUsrCode'] = $aCardShiftTopUpData['raItems']['rtCardShiftTopUpUsrCode'];
        $aUserCreated = $this->mUser->FSaMUSRByID($aData);

        $aData['FTUsrCode'] = $aCardShiftTopUpData['raItems']['rtCardShiftTopUpApvCode'];
        $aUserApv = $this->mUser->FSaMUSRByID($aData);

        $aData['FTBchCode'] = $aCardShiftTopUpData['raItems']['rtCardShiftTopUpBchCode'];
        $aData['FTXshDocNo'] = $aCardShiftTopUpData['raItems']['rtCardShiftTopUpDocNo'];
        $aCardShiftTopUpCardDataInDT = $this->mCardShiftTopUp->FSaMCardShiftTopUpGetDTByDocNo($aData);

        // Remove in temp
        FCNoCARDataListDeleteOnlyTable("TFNTCrdTopUpTmp");

        // Copy from DT to temp
        FSxDocHelperDTToTemp("cardShiftTopUp", $aData['FTXshDocNo']);

        $aDataEdit = array(
            'aResult' => $aCardShiftTopUpData,
            'aUser' => $aUser,
            'aUserApv' => $aUserApv,
            'aUserCreated' => $aUserCreated,
            'aActiveVatrate' => $aActiveVatrate,
            'nLangEdit' => $nLangEdit,
            'aPermission' => $aPermission,
        );

        $this->load->view('document/cardshifttopup/wCardShiftTopUpAdd', $aDataEdit);
    }

    /**
     * Functionality : Event Add Card Shift
     * Parameters : Ajax and Function Parameter
     * Creator : 30/10/2018 piya  + 13/08/2020 Supawat
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaCardShiftTopUpAddEvent()
    {
        $aDataMaster = array(
            'tIsAutoGenCode' => $this->input->post('ocbCardShiftTopUpAutoGenCode'),
            'FTXshDocNo' => $this->input->post('oetCardShiftTopUpCode'),
            'FDXshDocDate' => $this->input->post('oetCardShiftTopUpDocDate') . ' ' . date('H:i:s'),
            'FNXshDocType' => "3", // Take top up card
            'FTBchCode' => $this->input->post('ohdCardShiftTopUpUsrBchCode'),
            'FTUsrCode' => $this->input->post("ohdCardShiftTopUpUserCreatedCode"),
            'FNXshCardQty' => FSnSelectCountResult('TFNTCrdTopUpTmp'),
            'cTopUp' => empty($this->input->post('oetCardShiftTopUpCardValue')) ? "0" : $this->input->post('oetCardShiftTopUpCardValue'),
            'aCardCode' => json_decode($this->input->post('aCardCode')),
            'FTXshApvCode' => $this->input->post('ohdCardShiftTopUpApvCode'),
            'FTXshStaPrcDoc' => $this->input->post('ohdCardShiftTopUpCardStaPrcDoc'),
            'FTXshStaDoc' => empty($this->input->post('hdCardShiftTopUpCardStaDoc')) ? "1" : $this->input->post('hdCardShiftTopUpCardStaDoc'),
            'FNXshStaDocAct' => empty($this->input->post('hdCardShiftTopUpCardStaDoc')) ? 1 : $this->input->post('hdCardShiftTopUpCardStaDoc'),
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
                "tDocType" => 3,
                "tBchCode" => $aDataMaster['FTBchCode'],
                "tShpCode" => "",
                "tPosCode" => "",
                "dDocDate" => date("Y-m-d")
            );
            $aAutogen = FCNaHAUTGenDocNo($aStoreParam);
            $aDataMaster['FTXshDocNo'] = $aAutogen[0]["FTXxhDocNo"];
        }

        $oCountDup = $this->mCardShiftTopUp->FSoMCardShiftTopUpCheckDuplicate($aDataMaster['FTXshDocNo']);
        $nStaDup = $oCountDup[0]->counts;

        if ($nStaDup == 0) {
            $this->db->trans_begin();

            // $nCount = FSnSelectCountResult('TFNTCrdTopUpTmp');
            // $cTotalTopUp = $aDataMaster['cTopUp'] * $nCount; // Cale total value
            // $aDataMaster['FCXshTotal'] = $cTotalTopUp;
            // $aDataMaster['FCXshTotal'] = 0;

            $aStaCardShiftTopUpHD = $this->mCardShiftTopUp->FSaMCardShiftTopUpAddUpdateHD($aDataMaster);

            if ($aStaCardShiftTopUpHD['rtCode'] == "1") { // Update HD success

                // Update DocNo on Temp
                FCNCallUpdateDocNo($aDataMaster['FTXshDocNo'], 'TFNTCrdTopUpTmp', ["tBchCode" => $aDataMaster['FTBchCode']]);

                // Copy from temp to DT
                FSxDocHelperTempToDT("cardShiftTopUp",$aDataMaster);

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
    public function FSaCardShiftTopUpEditEvent()
    {
        $aDataMaster = array(
            'FTXshDocNo' => $this->input->post('oetCardShiftTopUpCode'),
            'FDXshDocDate' => $this->input->post('oetCardShiftTopUpDocDate') . ' ' . date('H:i:s'),
            'FNXshDocType' => "3", // Take top up card
            'FTBchCode' => $this->input->post('ohdCardShiftTopUpUsrBchCode'),
            'FNXshCardQty' => FSnSelectCountResult('TFNTCrdTopUpTmp'),
            'cTopUp' => empty($this->input->post('oetCardShiftTopUpCardValue')) ? "0" : $this->input->post('oetCardShiftTopUpCardValue'),
            'aCardCode' => json_decode($this->input->post('aCardCode')),
            'FTXshApvCode' => $this->input->post('ohdCardShiftTopUpApvCode'),
            'FTXshStaPrcDoc' => $this->input->post('ohdCardShiftTopUpCardStaPrcDoc'),
            'FTXshStaDoc' => empty($this->input->post('hdCardShiftTopUpCardStaDoc')) ? "1" : $this->input->post('hdCardShiftTopUpCardStaDoc'),
            'FNXshStaDocAct' => empty($this->input->post('hdCardShiftTopUpCardStaDocAct')) ? 1 : $this->input->post('hdCardShiftTopUpCardStaDocAct'),
            'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
            'FDLastUpdOn' => date('Y-m-d H:i:s'),
            'FTCreateBy' => $this->session->userdata('tSesUsername'),
            'FDCreateOn' => date('Y-m-d H:i:s'),
            'FNLngID' => $this->session->userdata("tLangEdit")
        );

        $this->db->trans_begin();

        $aCardShiftTopUpHD = $this->mCardShiftTopUp->FSaMCardShiftTopUpSearchByID("", "", $aDataMaster);
        if (
            ($aCardShiftTopUpHD['rtCode'] == "1") // Query HD success
            && (empty($aCardShiftTopUpHD["raItems"]['rtCardShiftTopUpStaPrcDoc'])) // On pending approve status
            && ($aCardShiftTopUpHD["raItems"]['rtCardShiftTopUpStaDoc'] == "1") // On document complete status
        ) {
            // $nCount = FSnSelectCountResult('TFNTCrdTopUpTmp');
            // $cTotalTopUp = $aDataMaster['cTopUp'] * $nCount; // Cale total value
            // $aDataMaster['FCXshTotal'] = $cTotalTopUp;
            // $aDataMaster['FCXshTotal'] = 0;

            $aStaCardShiftTopUpHD = $this->mCardShiftTopUp->FSaMCardShiftTopUpAddUpdateHD($aDataMaster);

            if (($aStaCardShiftTopUpHD['rtCode'] == "1")) { // Update HD success
                $paParams['tDocType'] = "TopUp";
                $paParams['tDocNo'] = $aDataMaster['FTXshDocNo'];
                // Remove on DT
                FSaDeleteDatainTableDT($paParams);

                // Update DocNo on Temp
                FCNCallUpdateDocNo($aDataMaster['FTXshDocNo'], 'TFNTCrdTopUpTmp', ["tBchCode" => $aDataMaster['FTBchCode']]);

                // Copy from Temp to DT
                FSxDocHelperTempToDT("cardShiftTopUp",$aDataMaster);

                // Remove in temp
                FCNoCARDataListDeleteOnlyTable("TFNTCrdTopUpTmp");
            }
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
    }

    /**
     * Functionality : Event Edit Card Shift
     * Parameters : Ajax and Function Parameter
     * Creator : 30/10/2018 piya + 13/08/2020 Supawat
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaCardShiftTopUpUpdateApvDocAndCancelDocEvent()
    {
        try {
            $aDataMaster = array(
                'FTXshDocNo' => $this->input->post('oetCardShiftTopUpCode'),
                'FDXshDocDate' => $this->input->post('oetCardShiftTopUpDocDate') . ' ' . date('H:i:s'),
                'FNXshDocType' => "3", // Take top up card
                'FTBchCode' => $this->input->post('ohdCardShiftTopUpUsrBchCode'),
                'FTUsrCode' => $this->session->userdata("tSesUsername"),
                'FNXshCardQty' => count(json_decode($this->input->post('aCardCode'))),
                'FCXshTotal' => $this->input->post('oetCardShiftTopUpCardValue'),
                'aCardCode' => json_decode($this->input->post('aCardCode')),
                'FTXshApvCode' => $this->input->post('ohdCardShiftTopUpApvCode'),
                'FTXshStaPrcDoc' => $this->input->post('ohdCardShiftTopUpCardStaPrcDoc'),
                'FTXshStaDoc' => empty($this->input->post('hdCardShiftTopUpCardStaDoc')) ? "1" : $this->input->post('hdCardShiftTopUpCardStaDoc'),
                'FNXshStaDocAct' => empty($this->input->post('hdCardShiftTopUpCardStaDocAct')) ? 1 : $this->input->post('hdCardShiftTopUpCardStaDocAct'),
                'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FTCreateBy' => $this->session->userdata('tSesUsername'),
                'FDCreateOn' => date('Y-m-d H:i:s'),
                'FNLngID' => $this->session->userdata("tLangEdit"),
            );

            $this->db->trans_begin();

            $aCardShiftTopUpHD = $this->mCardShiftTopUp->FSaMCardShiftTopUpSearchByID("", "", $aDataMaster);

            if (($aDataMaster['FTXshStaPrcDoc'] == "2") // Update status approve is true
                && ($aCardShiftTopUpHD['rtCode'] == "1") // Query HD success
                && (empty($aCardShiftTopUpHD["raItems"]['rtCardShiftTopUpStaPrcDoc'])) // On pending approve status
                && ($aCardShiftTopUpHD["raItems"]['rtCardShiftTopUpStaDoc'] == "1") // On document complete status
            ) {
                $aStaCardShiftTopUpHD = $this->mCardShiftTopUp->FSaMCardShiftTopUpUpdateApvDocAndCancelDocHD($aDataMaster);
                $aGetDTByDocNo = $this->mCardShiftTopUp->FSaMCardShiftTopUpGetDTByDocNo($aDataMaster);

                /*===== Begin Set Card Item ============================================*/
                $aCardItems = [];
                if ($aGetDTByDocNo['rtCode'] == "1") {
                    foreach ($aGetDTByDocNo['raItems'] as $aItem) {
                        $aCardItems['paItem'][] = [
                            "pnLngID" => $aDataMaster['FNLngID'],
                            "ptBchCode" => $aDataMaster['FTBchCode'],
                            "ptTxnDocNoRef" => $aDataMaster['FTXshDocNo'],
                            "ptCrdCode" => $aItem['rtCardShiftTopUpCrdCode'],
                            "ptShpCode" => "",
                            "ptTxnPosCode" => "",
                            "pcTxnCrdValue" => $aItem['rtCardShiftTopUpCrdBal'],
                            "pcTxnValue" => $aItem['rtCardShiftTopUpCrdTP'],
                            "pcTxnPmt" => $aItem['rtCardShiftTopUpAmtPmt'],
                            "ptUsrCode" => $aDataMaster['FTUsrCode'],
                            "ptAuto" => ($aItem['rtCardShiftTopUpCtyStaPay'] == "1")?"":"1" // สถานะการชำระ 1:เติมเงินก่อน 2: จ่ายทีหลัง (เงื่อนไขเติมเงินอัตโนมัติ ว่าง:เติมปกติ, 1:เติมอัตโนมัติ)
                        ];
                    }
                }
                /*===== End Set Card Item ==============================================*/

                /*========================== Approved =========================*/
                try {
                    /* Params MQ
                    {
                    "ptFunction":"CardListTopup", < ชื่อ Function
                    "ptSource":"", < ต้นทาง
                    "ptDest":"MQWallet", < ปลายทาง
                    "ptFilter":"", < data fillter
                    "ptData": "{"paItem":[
                        {
                        "pnLngID":1,
                        "ptBchCode":"00001",
                        "ptTxnDocNoRef":"CT000012000001",
                        "ptCrdCode":"C0001",
                        "ptShpCode":"",
                        "ptTxnPosCode":"",
                        "pcTxnCrdValue":0.00,
                        "pcTxnValue":0.00,
                        "pcTxnPmt":0.00,
                        "ptUsrCode":"009",
                        "ptAuto":"1" // 1:Auto
                        },{
                        "pnLngID":1,
                        "ptBchCode":"",
                        "ptTxnDocNoRef":"CT000012000001",
                        "ptCrdCode":"C0002",
                        "ptShpCode":"",
                        "ptTxnPosCode":"",
                        "pcTxnCrdValue":0.00,
                        "pcTxnValue":0.00,
                        "pcTxnPmt":0.00,
                        "ptUsrCode":"009",
                        "ptAuto":"2" // 2:Manual
                        }]}"
                    }
                    */
                    $aMQParams = [
                        "tVhostType" => "W",
                        "queueName" => "FN_QPosPrc",
                        "bStaUseConnStr" => false,
                        "params" => [
                            "ptFunction" => "CardListTopup",
                            "ptSource" => "AdaStoreBack",
                            "ptDest" => "",
                            "ptFilter" => "",
                            "ptData" => json_encode($aCardItems)
                        ]
                    ];
                    FCNxCallRabbitMQ($aMQParams);
                } catch (\ErrorException $err) {
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent' => '900',
                        'tStaMessg' => language('document/card/cardtopup', 'tCardShiftTopUpApproveFail')
                    );
                    echo json_encode($aReturn);
                    return;
                }
                /*=============================================================*/
            }

            /*=============================== Cancel ==========================*/
            if (($aDataMaster['FTXshStaDoc'] == "3")) { // Have card and update status document is cancel
                $aStaCardShiftTopUpHD = $this->mCardShiftTopUp->FSaMCardShiftTopUpUpdateApvDocAndCancelDocHD($aDataMaster);
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
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    /**
     * Functionality : Event Delete Card Shift
     * Parameters : Ajax and Function Parameter
     * Creator : 30/10/2018 piya
     * Last Modified : -
     * Return : Status Delete Event
     * Return Type : String
     */
    public function FSaCardShiftTopUpDeleteEvent()
    {
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTCardShiftTopUpCode' => $tIDCode
        );

        $aResDel = $this->mCardShiftTopUp->FSnMCardShiftTopUpDel($aDataMaster);
        $aReturn = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }

    /**
     * Functionality : Vatrate unique check
     * Parameters : $tSelect "CardShiftTopUpcode"
     * Creator : 30/10/2018 piya
     * Last Modified : -
     * Return : Check status true or false
     * Return Type : String
     */
    public function FStCardShiftTopUpUniqueValidate($tSelect = '')
    {

        if ($this->input->is_ajax_request()) { // Request check
            if ($tSelect == 'cardShiftTopUpCode') {

                $tCardShiftTopUpCode = $this->input->post('tCardShiftTopUpCode');
                $oCustomerGroup = $this->mCardShiftTopUp->FSoMCardShiftTopUpCheckDuplicate($tCardShiftTopUpCode);

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
     * Functionality : Function Event Multi Delete
     * Parameters : Ajax Function Delete Card Shift
     * Creator : 09/10/2018 piya
     * Last Modified : -
     * Return : Status Event Delete And Status Call Back Event
     * Return Type : object
     */
    public function FSoCardShiftTopUpDeleteMulti()
    {
        $tCardShiftTopUpCode = $this->input->post('tCardShiftTopUpCode');

        $aCardShiftTopUpCode = json_decode($tCardShiftTopUpCode);
        foreach ($aCardShiftTopUpCode as $oCardShiftTopUpCode) {
            $aCardShiftTopUp = ['FTCardShiftTopUpCode' => $oCardShiftTopUpCode];
            $this->mCardShiftTopUp->FSnMCardShiftTopUpDel($aCardShiftTopUp);
        }
        echo json_encode($aCardShiftTopUpCode);
    }

    /**
     * Functionality : Delete vat rate
     * Parameters : -
     * Creator : 30/10/2018 piya
     * Last Modified : -
     * Return : Vat code
     * Return Type : Object
     */
    public function FSoCardShiftTopUpDelete()
    {
        $tCardShiftTopUpCode = $this->input->post('tCardShiftTopUpCode');

        $aCardShiftTopUp = ['FTCardShiftTopUpCode' => $tCardShiftTopUpCode];
        $this->mCardShiftTopUp->FSnMCardShiftTopUpDel($aCardShiftTopUp);
        echo json_encode($tCardShiftTopUpCode);
    }

    /**
     * Functionality : Function Call DataTables Card Shift by file (xls or xlsx)
     * Parameters : Ajax and Function Parameter
     * Creator : 02/11/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCardShiftTopUpDataSourceListByFile()
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
        $nLangResort = $this->session->userdata("tLangID");
        $nLangEdit = $this->session->userdata("tLangEdit");

        try {
            $aDataFiles = (isset($_FILES['oefCardShiftTopUpImport']) && !empty($_FILES['oefCardShiftTopUpImport'])) ? $_FILES['oefCardShiftTopUpImport'] : null;

            if (isset($aDataFiles) && !empty($aDataFiles) && is_array($aDataFiles)) {
                // Insert
                $aDataFiles = (isset($_FILES['aFile']) && !empty($_FILES['aFile'])) ? $_FILES['aFile'] : null;
                $ptDocType = 'TopUp';
                $ptDataSetType = 'Excel';
                $paDataExcel = [
                    'file' => $aDataFiles,
                    'reasonfile' => '',
                    'optionfile_newcard' => 0,
                    'nDocno' => $tDocNo,
                    'tBCHCode' => $tBchCode
                ];

                $paDataSet = [];
                if (isset($_FILES['aFile'])) {
                    $tResult = FCNaCARInsertDataToTempFileCenter($ptDocType, $ptDataSetType, $paDataExcel, $paDataSet);
                }

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
        } catch (Exception $Error) {
            echo "Controller Err FSvCardShiftTopUpDataSourceListByFile = " . $Error;
        }
    }

    /**
     * Functionality : Update Edit inline
     * Parameters : -
     * Creator : 27/12/2018 Supawat
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCardShiftTopUpUpdateInlineOnTemp()
    {
        $tDocType = "cardShiftTopUp";
        $nSeq = $this->input->post('nSeq');
        $tCardCode = $this->input->post('tCardCode');
        $nValue = $this->input->post('nValue');
        $tRmk = $this->input->post('tRmk');
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        $aDataSet = [
            "tCardCode" => $tCardCode,
            "nValue" => $nValue,
            "tRmk" => $tRmk
        ];

        $aResult = FSxUpdateTempBySeq($tDocType, $nSeq, $aDataSet);
        if (isset($aResult)) {
            $aReturn = ["cTotalAmt" => number_format($aResult[0]["FCXshTotal"], $nOptDecimalShow)];
        } else {
            $aReturn = ["cTotalAmt" => number_format(0, $nOptDecimalShow)];
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Save To Temp พี่เสือเขียนไว้
     * Parameters : -
     * Creator : 27/12/2018 Supawat
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCardShiftTopUpInsertToTemp()
    {
        $tUsrBchCode = $this->input->post('tBCHCode');
        $tUserCode = $this->session->userdata("tSesUsername");
        $tInsertType = $this->input->post('tInsertType');
        $tDocNo = $this->input->post('tDocNo');

        $tDocType = "cardShiftTopUp";
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

        FCNaCARDInsertDataToTemp($tDocType, $tDataSetType, [], $aDataSet);
    }


    // Create By Witsarut 25-11-2020
    // function Delete Siggle Card TopUp
    public function FSoCardTopUpEventDelete()
    {
        try {
            $tCrdShifTopUpDocNo = $this->input->post('tCrdShifTopUpDocNo');
            $tBchCode = $this->input->post('tBchCode');

            $aDataDelMaster = array(
                'FTXshDocNo'    => $tCrdShifTopUpDocNo,
                'FTBchCode'     => $tBchCode
            );

            $aResultDel = $this->mCardShiftTopUp->FSnMCardShiftTopUpDeldata($aDataDelMaster);

            if ($aResultDel['rtCode'] == 1) {
                $aDataStaReturn  = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success'
                );
            } else {
                $aDataStaReturn  = array(
                    'nStaEvent'  => $aResultDel['rtCode'],
                    'tStaMessg'  => $aResultDel['rtDesc']
                );
            }
        } catch (Exception $Error) {
            $aDataStaReturn = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aDataStaReturn);
    }


    // Create By Witsarut 25-11-2020
    // function Multi Delete
    function FSoCardTopUpEventDeleteMulti()
    {

        $aDocNo  = $this->input->post('aDocNo');

        $this->db->trans_begin();

        foreach ($aDocNo as $aItem) {
            $aDelMasterParams = [
                'tDocNo' => trim($aItem)
            ];
            $this->mCardShiftTopUp->FSaMDelMultiMaster($aDelMasterParams);
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

        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aStatus));
    }

    //ค้นหา แบบยิง Barcode
    public function FSaCardShiftTopUpScannerEvent(){
        $aData = array(
            'tAgnCode'        => $this->session->userdata('tSesUsrAgnCode'),
            'tCrdCode'        => $this->input->post('tScannerID'),
            'tLangID'         => $this->session->userdata("tLangID")
        );
        $aResList = $this->mCardShiftTopUp->FSaMCardShiftTopUpListScanner($aData);
        echo json_encode($aResList);
    }
}
