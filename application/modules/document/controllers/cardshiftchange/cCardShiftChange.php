<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php');
require_once(APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/IOFactory.php');
require_once(APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php');

class cCardShiftChange extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('document/cardshiftchange/mCardShiftChange');
        $this->load->model('authen/user/mUser');
        $this->load->library('upload');
        $this->load->helper('file');
    }

    /**
     * Functionality : Main page for Card Shift
     * Parameters : $nCardShiftChangeBrowseType, $tCardShiftChangeBrowseOption
     * Creator : 08/10/2018 piya + 17/08/2020 Supawat
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function index($nCardShiftChangeBrowseType, $tCardShiftChangeBrowseOption)
    {

        $nMsgResp = array('title' => "Card Shift Change");
        $isXHR = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if (!$isXHR) {
            $this->load->view('common/wHeader', $nMsgResp);
            $this->load->view('common/wTopBar', array('nMsgResp' => $nMsgResp));
            $this->load->view('common/wMenu', array('nMsgResp' => $nMsgResp));
        }
        $vBtnSave = FCNaHBtnSaveActiveHTML('cardShiftChange/0/0'); // Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aPermission = FCNaHCheckAlwFunc("cardShiftChange/0/0");
        $this->load->view('document/cardshiftchange/wCardShiftChange', array(
            'nMsgResp' => $nMsgResp,
            'vBtnSave' => $vBtnSave,
            'aPermission' => $aPermission,
            'nCardShiftChangeBrowseType' => $nCardShiftChangeBrowseType,
            'tCardShiftChangeBrowseOption' => $tCardShiftChangeBrowseOption
        ));
    }

    /**
     * Functionality : Function Call Card Shift Page List
     * Parameters : Ajax and Function Parameter
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCardShiftChangeListPage()
    {
        $aAlwEvent = FCNaHCheckAlwFunc('cardShiftChange/0/0');
        $aNewData  = array('aAlwEvent' => $aAlwEvent);
        $this->load->view('document/cardshiftchange/wCardShiftChangeList', $aNewData);
    }

    /**
     * Functionality : Function Call DataTables Card Shift
     * Parameters : Ajax and Function Parameter
     * Creator : 08/10/2018 piya + 17/08/2020 Supawat 
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCardShiftChangeDataList()
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
        $aResList = $this->mCardShiftChange->FSaMCardShiftChangeList($tAPIReq, $tMethodReq, $aData);
        $aAlwEvent = FCNaHCheckAlwFunc('cardShiftChange/0/0');
        $aGenTable = array(
            'aAlwEvent' => $aAlwEvent,
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'tSearchAll' => $tSearchAll
        );
        $this->load->view('document/cardshiftchange/wCardShiftChangeDataTable', $aGenTable);
    }

    /**
     * Functionality : Function Call DataTables Card Shift
     * Parameters : Ajax and Function Parameter
     * Creator : 08/10/2018 piya + 17/08/2020 Supawat
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCardShiftChangeDataSourceList()
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
                'FTCvhDocNo' => $tDocNo,
            );

            if (!empty($tOptionDocNo)) { // Have document number
                // Get card in TopUpDT
                $aResList = $this->mCardShiftChange->FSaMCardShiftChangeGetDTByDocNo($aData);
            } else { // No have document number
                // Get card in card master
                $aResList = $this->mCardShiftChange->FSaMCardShiftChangeDataSourceList($aData);
                if ($tSetEmpty == "1") {
                    $aResList["raItems"] = [];
                }
            }

            if ($aResList["rtCode"] == "800") { // Query card fail
                $aResult = [];
                $aResult["rtCode"]  = $aResList["rtCode"];
                echo json_encode($aResult);
                return;
            }

            $aResult = [];
            $aCard = [];
            foreach ($aResList["raItems"] as $nKey => $tValue) {
                $aCard[$nKey][0] = $tValue["rtCrdCode"];
                $aCard[$nKey][1] = $tValue["rtCrdHolderID"];
                $aCard[$nKey][2] = $tValue["rtCtyStaPay"];
            }
            $aResult["raCard"] = $aCard;
            $aResult["rtCode"] = "1";
            echo json_encode($aResult);
            return;
        }

        $paParams['tSessionID'] = $this->session->userdata("tSesSessionID");
        $paParams['tSeqNo'] = "";

        if ($tStaPrcDoc == "" and $tStaDoc == "") {
            // Validate document temp
            
            FSnHCrdTranfChkOldCardFoundInDB($paParams);
            // FSnHCrdTranfChkNewCardFoundInDB($paParams);
            FSnHCrdTranfChkRsnCodeNotEmpty($paParams);
            FSnHCrdTranfChkNewCardNotDupTemp($paParams);
            FSnHCrdTranfChkNewCardCodeNotEmpty($paParams);
            FSnHCrdTranfChkNewCardNotDupInDB($paParams);
            FSnHCrdTranfChkNewCardOverBlc($paParams);
            
            // FSnHCrdTranfChkNewCrdHolderID($paParams);
        } else {
            if ($tStaPrcDoc == "" and $tStaDoc == "1") { // Document pending status(approve) or complete status(doc status)
                // Validate document temp
                
                FSnHCrdTranfChkOldCardFoundInDB($paParams);
                // FSnHCrdTranfChkNewCardFoundInDB($paParams);
                FSnHCrdTranfChkRsnCodeNotEmpty($paParams);
                FSnHCrdTranfChkNewCardNotDupTemp($paParams);
                FSnHCrdTranfChkNewCardCodeNotEmpty($paParams);
                FSnHCrdTranfChkNewCardNotDupInDB($paParams);
                FSnHCrdTranfChkNewCardOverBlc($paParams);
                
                // FSnHCrdTranfChkNewCrdHolderID($paParams);
            }
        }

        // Call data on temp helper
        $aDataTemp  = array(
            'nPage' => $nPage,
            'nRow' => 10,
            'FNLngID' => $nLangEdit,
            'tSearchAll' => $tSearchAll,
            'FTBchCode' => "",
            'ptDocType' => "CardTnfChangeCard"
        );
        $aCardChangeFromTemp = FSaSelectDataForDocType($aDataTemp);
        $aCardChangeCode = FSaSelectAllBySessionID("cardShiftChange");

        $aGenTable = array(
            'aDataList' => $aCardChangeFromTemp,
            'tDataListAll' => json_encode($aCardChangeCode),
            'rnAllRow' => !empty($aCardChangeCode['rnAllRow']) ? $aCardChangeCode['rnAllRow'] : null,
            'ptDocType' => "CardTnfChangeCard",
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

        $this->load->view('document/cardshiftchange/wCardShiftChangeDataSourceTable', $aGenTable);
    }

    /**
     * Functionality : Insert card data to document temp
     * Parameters : {params}
     * Creator : 27/12/2018 piya + 17/08/2020 Supawat
     * Last Modified : -
     * Return : {return}
     * Return Type : {type}
     */
    public function FSxCardShiftChangeInsertToTemp()
    {
        $tUsrBchCode = $this->input->post('tBCHCode');
        $tUserCode = $this->session->userdata("tSesUsername");
        $aCardNumber = json_decode($this->input->post('tCardNumber'));
        $aNewCardNumber = json_decode($this->input->post('tNewCardNumber'));
        $aCardNewAndOld = json_decode($this->input->post('tCardNewAndOld'),true);
        $tReasonCode = $this->input->post('tReasonCode');
        $tDocNo = $this->input->post('tDocNo');

        $tDocType = "cardShiftChange";
        $tDataSetType = "Between";
        $aDataSet = [
            "tDocNo" => $tDocNo,
            "tBchCode" => $tUsrBchCode,
            "tReasonCode" => $tReasonCode,
            "tCreateBy" => $tUserCode,
            "aOldCardCode" => $aCardNumber,
            "aNewCardCode" => $aNewCardNumber,
            "aCardNewAndOld" => $aCardNewAndOld
        ];
        FCNaCARDInsertDataToTemp($tDocType, $tDataSetType, [], $aDataSet);
    }

    /**
     * Functionality : Update card data in document temp by row
     * Parameters : {params}
     * Creator : 27/12/2018 piya
     * Last Modified : -
     * Return : {return}
     * Return Type : {type}
     */
    public function FSxCardShiftChangeUpdateInlineOnTemp()
    {
        $tCardNumber = $this->input->post('tCardNumber');
        $tNewCardNumber = $this->input->post('tNewCardNumber');
        $tReasonCode = $this->input->post('tReasonCode');
        $nSeq = $this->input->post('nSeq');
        $tRmk = $this->input->post('tRmk');
        $tDocType = "cardShiftChange";
        $aDataSet = [
            "tReasonCode" => $tReasonCode,
            "tOldCardCode" => $tCardNumber,
            "tNewCardCode" => $tNewCardNumber,
            'tRmk' => $tRmk
        ];
        FSxUpdateTempBySeq($tDocType, $nSeq, $aDataSet);
    }

    /**
     * Functionality : Function CallPage Card Shift Add
     * Parameters : Ajax and Function Parameter
     * Creator : 08/10/2018 piya + 17/08/2020 Supawat
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCardShiftChangeAddPage()
    {
        $nLangEdit = $this->session->userdata("tLangEdit");
        $aData = array(
            'FNLngID' => $nLangEdit,
            'FTUsrCode' => $this->session->userdata("tSesUsername")
        );
        $aUser = $this->mUser->FSaMUSRByID($aData);

        $aDataAdd = array(
            'aResult' => ['rtCode' => '99'],
            'aUser' => $aUser,
            'aUserApv' => ['rtCode' => '99'],
            'nLangEdit' => $nLangEdit,
            'aCardCode' => [],
            'aUserCreated' => ['rtCode' => '99']
        );

        $this->load->view('document/cardshiftchange/wCardShiftChangeAdd', $aDataAdd);
    }

    /**
     * Functionality : Function CallPage Card Shift Edit
     * Parameters : Ajax and Function Parameter
     * Creator : 08/10/2018 piya + 17/08/2020 Supawat
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCardShiftChangeEditPage()
    {

        $tCardShiftChangeDocNo = $this->input->post('tCardShiftChangeDocNo');
        $nLangResort = $this->session->userdata("tLangID");
        $nLangEdit = $this->session->userdata("tLangEdit");

        $aData = array(
            'FTCvhDocNo' => $tCardShiftChangeDocNo,
            'FNLngID' => $nLangEdit,
            'FTUsrCode' => $this->session->userdata("tSesUsername")
        );

        $aUser = $this->mUser->FSaMUSRByID($aData);
        $aPermission = FCNaHCheckAlwFunc("cardShiftChange/0/0");
        $tAPIReq = "";
        $tMethodReq = "GET";
        $aCardShiftChangeData = $this->mCardShiftChange->FSaMCardShiftChangeSearchByID($tAPIReq, $tMethodReq, $aData);

        $aData['FTUsrCode'] = $aCardShiftChangeData['raItems']['rtCardShiftChangeUsrCode'];
        $aUserCreated = $this->mUser->FSaMUSRByID($aData);

        $aData['FTUsrCode'] = $aCardShiftChangeData['raItems']['rtCardShiftChangeApvCode'];
        $aUserApv = $this->mUser->FSaMUSRByID($aData);

        $aData['FTBchCode'] = $aCardShiftChangeData['raItems']['rtCardShiftChangeBchCode'];
        $aData['FTCvhDocNo'] = $aCardShiftChangeData['raItems']['rtCardShiftChangeDocNo'];

        // Remove in temp
        FCNoCARDataListDeleteOnlyTable("TFNTCrdVoidTmp");

        // Copy from DT to temp
        FSxDocHelperDTToTemp("cardShiftChange", $aData['FTCvhDocNo']);

        $aDataEdit = array(
            'aResult' => $aCardShiftChangeData,
            'aUser' => $aUser,
            'aUserApv' => $aUserApv,
            'nLangEdit' => $nLangEdit,
            'aUserCreated' => $aUserCreated,
            'aPermission' => $aPermission
        );

        $aDataEdit['aCardCode'] = []; // Default value if no have card
        $aDataEdit['aNewCardCode'] = []; // Default value if no have card

        $this->load->view('document/cardshiftchange/wCardShiftChangeAdd', $aDataEdit);
    }

    /**
     * Functionality : Event Add Card Shift
     * Parameters : Ajax and Function Parameter
     * Creator : 08/10/2018 piya + 17/08/2020 Supawat
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaCardShiftChangeAddEvent()
    {
        try {
            $aDataMaster = array(
                'tIsAutoGenCode' => $this->input->post('ocbCardShiftChangeAutoGenCode'),
                'FTCvhDocNo' => $this->input->post('oetCardShiftChangeCode'),
                'FDCvhDocDate' => $this->input->post('oetCardShiftChangeDocDate') . ' ' . date('H:i:s'),
                'FTCvhDocType' => "6", // Change card
                'FTBchCode' => $this->input->post('ohdCardShiftChangeUsrBchCode'),
                'FTUsrCode' => $this->session->userdata("tSesUsername"),
                'FNCvhCardQty' => FSnSelectCountResult('TFNTCrdVoidTmp'),
                'aCard' => json_decode($this->input->post('aCard')),
                'aNewCardCode' => json_decode($this->input->post('aNewCardCode')),
                'FTCvhApvCode' => $this->input->post('ohdCardShiftChangeApvCode'),
                'FTCvhStaPrcDoc' => $this->input->post('ohdCardShiftChangeCardStaPrcDoc'),
                'FTCvhStaDoc' => empty($this->input->post('hdCardShiftChangeCardStaDoc')) ? "1" : $this->input->post('hdCardShiftChangeCardStaDoc'),
                'FNCvhStaDocAct' => empty($this->input->post('hdCardShiftChangeCardStaDoc')) ? 1 : $this->input->post('hdCardShiftChangeCardStaDoc'),
                'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FTCreateBy' => $this->session->userdata('tSesUsername'),
                'FDCreateOn' => date('Y-m-d H:i:s'),
                'FNLngID' => $this->session->userdata("tLangEdit")
            );

            // Setup DocNo
            if ($aDataMaster['tIsAutoGenCode'] == '1') { // Check Auto Gen DocNo?
                // Auto Gen DocNo Code
                // $aGenCode = FCNaHGenCodeV5('TFNTCrdVoidHD', 6);
                // if($aGenCode['rtCode'] == '1'){
                //     $aDataMaster['FTCvhDocNo'] = $aGenCode['rtCvhDocNo'];
                // }

                $aStoreParam = array(
                    "tTblName" => 'TFNTCrdVoidHD',
                    "tDocType" => 6,
                    "tBchCode" => $aDataMaster['FTBchCode'],
                    "tShpCode" => "",
                    "tPosCode" => "",
                    "dDocDate" => date("Y-m-d")
                );
                $aAutogen = FCNaHAUTGenDocNo($aStoreParam);
                $aDataMaster['FTCvhDocNo'] = $aAutogen[0]["FTXxhDocNo"];
            }

            $oCountDup = $this->mCardShiftChange->FSoMCardShiftChangeCheckDuplicate($aDataMaster['FTCvhDocNo']);
            $nStaDup = $oCountDup[0]->counts;

            if ($nStaDup == 0) {
                $this->db->trans_begin();

                $aStaCardShiftChangeHD = $this->mCardShiftChange->FSaMCardShiftChangeAddUpdateHD($aDataMaster);

                if ($aStaCardShiftChangeHD['rtCode'] == "1") {

                    // Update DocNo on Temp
                    FCNCallUpdateDocNo($aDataMaster['FTCvhDocNo'], 'TFNTCrdVoidTmp', ["tBchCode" => $aDataMaster['FTBchCode']]);

                    // Copy from temp to DT
                    FSxDocHelperTempToDT("cardShiftChange");

                    // Remove in temp
                    FCNoCARDataListDeleteOnlyTable("TFNTCrdVoidTmp");
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
                        'tCodeReturn' => $aDataMaster['FTCvhDocNo'],
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
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    /**
     * Functionality : Event Edit Card Shift
     * Parameters : Ajax and Function Parameter
     * Creator : 08/10/2018 piya + 17/08/2020 Supawat
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaCardShiftChangeEditEvent()
    {
        try {
            $aDataMaster = array(
                'FTCvhDocNo' => $this->input->post('oetCardShiftChangeCode'),
                'FDCvhDocDate' => $this->input->post('oetCardShiftChangeDocDate') . ' ' . date('H:i:s'),
                'FTCvhDocType' => "6", // Change card
                'FTBchCode' => $this->input->post('ohdCardShiftChangeUsrBchCode'),
                'FNCvhCardQty' => FSnSelectCountResult('TFNTCrdVoidTmp'),
                'aCard' => json_decode($this->input->post('aCard')),
                'aNewCardCode' => json_decode($this->input->post('aNewCardCode')),
                'FTCvhApvCode' => $this->input->post('ohdCardShiftChangeApvCode'),
                'FTCvhStaPrcDoc' => $this->input->post('ohdCardShiftChangeCardStaPrcDoc'),
                'FTCvhStaDoc' => empty($this->input->post('hdCardShiftChangeCardStaDoc')) ? "1" : $this->input->post('hdCardShiftChangeCardStaDoc'),
                'FNCvhStaDocAct' => empty($this->input->post('hdCardShiftChangeCardStaDocAct')) ? 1 : $this->input->post('hdCardShiftChangeCardStaDocAct'),
                'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FTCreateBy' => $this->session->userdata('tSesUsername'),
                'FDCreateOn' => date('Y-m-d H:i:s'),
                'FNLngID' => $this->session->userdata("tLangEdit"),
            );

            $this->db->trans_begin();

            $aCardShiftChangeHD = $this->mCardShiftChange->FSaMCardShiftChangeSearchByID("", "", $aDataMaster);

            if (
                ($aCardShiftChangeHD['rtCode'] == "1") // Query HD success
                && (empty($aCardShiftChangeHD["raItems"]['rtCardShiftChangeStaPrcDoc'])) // On pending approve status 
                && ($aCardShiftChangeHD["raItems"]['rtCardShiftChangeStaDoc'] == "1") // On document complete status
            ) {
                $aStaCardShiftChangeHD  = $this->mCardShiftChange->FSaMCardShiftChangeAddUpdateHD($aDataMaster);

                /*=============================================================*/
                if (($aStaCardShiftChangeHD['rtCode'] == "1")) { // Update HD success
                    $paParams['tDocType'] = "CardTnfChangeCard";
                    $paParams['tDocNo'] = $aDataMaster['FTCvhDocNo'];
                    // Remove on DT
                    FSaDeleteDatainTableDT($paParams);

                    // Copy from Temp to DT
                    FSxDocHelperTempToDT("cardShiftChange");

                    // Remove in temp
                    FCNoCARDataListDeleteOnlyTable("TFNTCrdVoidTmp");
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
                    'tCodeReturn' => $aDataMaster['FTCvhDocNo'],
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
     * Creator : 08/10/2018 piya  + 17/08/2020 Supawat
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaCardShiftChangeUpdateApvDocAndCancelDocEvent()
    {
        try {
            $aDataMaster = array(
                'FTCvhDocNo' => $this->input->post('oetCardShiftChangeCode'),
                'FDCvhDocDate' => $this->input->post('oetCardShiftChangeDocDate') . ' ' . date('H:i:s'),
                'FTCvhDocType' => "6", // Change card
                'FTBchCode' => $this->input->post('ohdCardShiftChangeUsrBchCode'),
                'FTUsrCode' => $this->session->userdata("tSesUsername"),
                'FNCvhCardQty' => count(json_decode($this->input->post('aCard'))),
                'aCard' => json_decode($this->input->post('aCard')),
                'aNewCardCode' => json_decode($this->input->post('aNewCardCode')),
                'FTCvhApvCode' => $this->input->post('ohdCardShiftChangeApvCode'),
                'FTCvhStaPrcDoc' => $this->input->post('ohdCardShiftChangeCardStaPrcDoc'),
                'FDCvhApvDate' => date('Y-m-d H:i:s'),
                'FTCvhStaDoc' => empty($this->input->post('ohdCardShiftChangeCardStaDoc')) ? "1" : $this->input->post('ohdCardShiftChangeCardStaDoc'),
                'FNCvhStaDocAct' => empty($this->input->post('ohdCardShiftChangeCardStaDocAct')) ? 1 : $this->input->post('ohdCardShiftChangeCardStaDocAct'),
                'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FTCreateBy' => $this->session->userdata('tSesUsername'),
                'FDCreateOn' => date('Y-m-d H:i:s'),
                'FNLngID' => $this->session->userdata("tLangEdit"),
            );

            $this->db->trans_begin();

            $aCardShiftChangeHD = $this->mCardShiftChange->FSaMCardShiftChangeSearchByID("", "", $aDataMaster);

            if (($aDataMaster['FTCvhStaPrcDoc'] == "2") // Update status approve is true
                && ($aCardShiftChangeHD['rtCode'] == "1") // Query HD success
                && (empty($aCardShiftChangeHD["raItems"]['rtCardShiftChangeStaPrcDoc'])) // On pending approve status 
                && ($aCardShiftChangeHD["raItems"]['rtCardShiftChangeStaDoc'] == "1") // On document complete status
            ) {
                $this->mCardShiftChange->FSaMCardShiftChangeUpdateApvDocAndCancelDocHD($aDataMaster);
                $aGetDTByDocNo = $this->mCardShiftChange->FSaMCardShiftChangeGetDTByDocNo($aDataMaster);

                /*===== Begin Set Card Item ============================================*/
                $aCardItems = [];
                if ($aGetDTByDocNo['rtCode'] == "1") {
                    foreach ($aGetDTByDocNo['raItems'] as $aItem) {
                        $aCardItems['paItem'][] = [
                            "pnLngID" => $aDataMaster['FNLngID'],
                            "ptBchCode" => $aDataMaster['FTBchCode'],
                            "ptTxnDocNoRef" => $aDataMaster['FTCvhDocNo'],
                            "ptToCrdCode" => $aItem['rtCardShiftChangeNewCrdCode'],
                            "ptFrmCrdCode" => $aItem['rtCardShiftChangeCrdCode'],
                            "ptUsrCode" => $aDataMaster['FTUsrCode']
                        ];
                    }
                }
                /*===== End Set Card Item ==============================================*/

                /*========================== Approved =========================*/
                try {
                    /* Params MQ
                    {
                    "ptFunction":"CardListTransfer", < ชื่อ Function
                    "ptSource":"", < ต้นทาง
                    "ptDest":"MQWallet", < ปลายทาง
                    "ptFilter":"", < data fillter
                    "ptData": "{"paItem":[
                            {
                            "ptBchCode":"00001",
                            "ptTxnDocNoRef":"CS000012000001",
                            "ptFrmCrdCode":"C0001",
                            "ptToCrdCode":"N0001",
                            "pnLngID":1,
                            "ptUsrCode":"009"
                            },{
                            "ptBchCode":"00001",
                            "ptTxnDocNoRef":"CS000012000001",
                            "ptFrmCrdCode":"C0002",
                            "ptToCrdCode":"N0002",
                            "pnLngID":1,
                            "ptUsrCode":"009"
                            }]}"
                    }
                    */
                    $aMQParams = [
                        "tVhostType" => "W",
                        "queueName" => "FN_QPosPrc",
                        "bStaUseConnStr" => false,
                        "params" => [
                            "ptFunction" => "CardListTransfer",
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
                        'tStaMessg' => language('pos5/cardShiftChange', 'tCardShiftChangeApproveFail')
                    );
                    echo json_encode($aReturn);
                    return;
                }
                /*=============================================================*/
            }

            /*=============================== Cancel ==========================*/
            var_dump($aDataMaster['FTCvhStaDoc']);
            if (($aDataMaster['FTCvhStaDoc'] == "3")) { // Update status document is cancel
                $this->mCardShiftChange->FSaMCardShiftChangeUpdateApvDocAndCancelDocHD($aDataMaster);
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
                    'tCodeReturn' => $aDataMaster['FTCvhDocNo'],
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
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : Status Delete Event
     * Return Type : String
     */
    public function FSaCardShiftChangeDeleteEvent()
    {
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTCardShiftChangeCode' => $tIDCode
        );

        $aResDel = $this->mCardShiftChange->FSnMCardShiftChangeDel($aDataMaster);
        $aReturn = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }

    /**
     * Functionality : VoidHD unique check
     * Parameters : $tSelect "cardShiftChangeCode"
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : Check status true or false
     * Return Type : String
     */
    public function FStCardShiftChangeUniqueValidate($tSelect = '')
    {

        if ($this->input->is_ajax_request()) { // Request check
            if ($tSelect == 'cardShiftChangeCode') {

                $tCardShiftChangeCode = $this->input->post('tCardShiftChangeCode');
                $oCardShiftChangeHD = $this->mCardShiftChange->FSoMCardShiftChangeCheckDuplicate($tCardShiftChangeCode);

                $tStatus = 'false';
                if ($oCardShiftChangeHD[0]->counts > 0) { // If have record
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
     * Functionality : Card unique check
     * Parameters : $tSelect "cardShiftChangeCardCode", "cardShiftChangeCardCodeInDT"
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : Check status true or false
     * Return Type : String
     */
    public function FStCardShiftChangeCardUniqueValidate($tSelect = '')
    {

        if ($this->input->is_ajax_request()) { // Request check

            $tCardShiftChangeCardCode = $this->input->post('tCardShiftChangeCardCode');

            if ($tSelect == 'cardShiftChangeCardCode') {
                $oCardShiftChangeCardCode = $this->mCardShiftChange->FSoMCardShiftChangeCheckCardDuplicate($tCardShiftChangeCardCode);

                $tStatus = 'false';
                if ($oCardShiftChangeCardCode[0]->counts > 0) { // If have record
                    $tStatus = 'true';
                }
                echo $tStatus;

                return;
            }

            if ($tSelect == 'cardShiftChangeCardCodeInDT') {
                $oCardShiftChangeCardCodeInDT = $this->mCardShiftChange->FSoMCardShiftChangeCheckCardDuplicateInDT($tCardShiftChangeCardCode);

                $tStatus = 'false';
                if ($oCardShiftChangeCardCodeInDT[0]->counts > 0) { // If have record
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
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : Vat code
     * Return Type : Object
     */
    public function FSoCardShiftChangeDelete()
    {
        $tDocNo = $this->input->post('tDocNo');
        $tBchCode = $this->input->post('tBchCode');

        $aCardShiftChangeDelParams = [
            'tDocNo' => $tDocNo,
            'tDocType' => '6',
            'tBchCode' => $tBchCode
        ];
        $this->mCardShiftChange->FSnMCardShiftChangeDel($aCardShiftChangeDelParams);

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
    public function FSoCardShiftChangeDeleteMulti()
    {
        $tDocData = $this->input->post('aDocData');

        $aDocData = json_decode($tDocData);
        foreach ($aDocData as $oDoc) {
            $aCardShiftChangeDelParams = [
                'tDocNo' => $oDoc->tDocNo,
                'tDocType' => '6',
                'tBchCode' => $oDoc->tBchCode
            ];
            $this->mCardShiftChange->FSnMCardShiftChangeDel($aCardShiftChangeDelParams);
        }

        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aDocData));
    }

    /**
     * Functionality : Function Call DataTables Card Shift by file (xls or xlsx)
     * Parameters : Ajax and Function Parameter
     * Creator : 02/11/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCardShiftChangeDataSourceListByFile()
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
        $aReason = json_decode($this->input->post('tReason'), true);
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

        /*if((FCNnHSizeOf($_FILES) > 0)){
            
            $aFile = (isset($_FILES['aFile']) && !empty($_FILES['aFile']))? $_FILES['aFile'] : null;
            $paDataExcel = ['file' => $aFile ,
                                'reasonfile'            => $aReason['reasonCode'], 
                                'optionfile_newcard'    => 0,
                                'nDocno'                => $tDocNo
                            ];
            try{
            FCNaCARDInsertDataToTemp("CardTnfChangeCard", "Excel", $paDataExcel, []);
            echo json_encode(
                    [
                        'rtCode'        => '1',
                        'rtDesc'        => 'success',
                    ]
                );
            }catch(ErrorException $err){
                echo json_encode(
                    [
                        'rtCode'        => '800',
                        'rtDesc'        => 'success',
                    ]
                );
            }
        }*/

        try {
            $aDataFiles = (isset($_FILES['oefCardShiftChangeImport']) && !empty($_FILES['oefCardShiftChangeImport'])) ? $_FILES['oefCardShiftChangeImport'] : null;

            if (isset($aDataFiles) && !empty($aDataFiles) && is_array($aDataFiles)) {
                // Insert
                $aDataFiles     = (isset($_FILES['aFile']) && !empty($_FILES['aFile'])) ? $_FILES['aFile'] : null;
                $ptDocType      = 'CardTnfChangeCard';
                $ptDataSetType  = 'Excel';
                $paDataExcel    = [
                    'file' => $aDataFiles,
                    'reasonCode' => $aReason['reasonCode'],
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
                        'tStaLog'   => 'Success',
                        'tDocType'  => $ptDocType
                    );
                    echo json_encode($aDataReturn);
                } else {
                    $aDataReturn = array(
                        'tStaLog'   => $tResult['tTextError'],
                        'tDocType'  => $ptDocType
                    );
                    echo json_encode($aDataReturn);
                }
            }
        } catch (Exception $Error) {
            echo "Controller Err FSvCardShiftOutDataSourceListByFile = " . $Error;
        }
    }
}
