<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php');
require_once(APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/IOFactory.php');
require_once(APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php');

class cCardShiftNewCard extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('document/cardshiftnewcard/mCardShiftNewCard');
        $this->load->model('authen/user/mUser');
        $this->load->model('authen/department/mDepartment');
        $this->load->model('payment/cardtype/mCardType');

        $this->load->library('upload');
        $this->load->helper('file');
    }

    /**
     * Functionality : Main page for Card Shift
     * Parameters : $nCardShiftNewCardBrowseType, $tCardShiftNewCardBrowseOption
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function index($nCardShiftNewCardBrowseType, $tCardShiftNewCardBrowseOption)
    {
        $nMsgResp = array('title' => "Province");
        $isXHR = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if (!$isXHR) {
            $this->load->view('common/wHeader', $nMsgResp);
            $this->load->view('common/wTopBar', array('nMsgResp' => $nMsgResp));
            $this->load->view('common/wMenu', array('nMsgResp' => $nMsgResp));
        }
        $vBtnSave = FCNaHBtnSaveActiveHTML('cardShiftNewCard/0/0'); // Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aPermission = FCNaHCheckAlwFunc("cardShiftNewCard/0/0");
        $this->load->view('document/cardshiftnewcard/wCardShiftNewCard', array(
            'nMsgResp' => $nMsgResp,
            'vBtnSave' => $vBtnSave,
            'aPermission' => $aPermission,
            'nCardShiftNewCardBrowseType' => $nCardShiftNewCardBrowseType,
            'tCardShiftNewCardBrowseOption' => $tCardShiftNewCardBrowseOption
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
    public function FSvCardShiftNewCardListPage()
    {
        $aAlwEvent = FCNaHCheckAlwFunc('cardShiftNewCard/0/0');
        $aNewData = array('aAlwEvent' => $aAlwEvent);
        $this->load->view('document/cardshiftnewcard/wCardShiftNewCardList', $aNewData);
    }

    /**
     * Functionality : Function Call DataTables Card Shift
     * Parameters : Ajax and Function Parameter
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCardShiftNewCardDataList()
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
        $aResList = $this->mCardShiftNewCard->FSaMCardShiftNewCardList($tAPIReq, $tMethodReq, $aData);
        $aAlwEvent = FCNaHCheckAlwFunc('cardShiftNewCard/0/0');
        $aGenTable = array(
            'aAlwEvent' => $aAlwEvent,
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'tSearchAll' => $tSearchAll
        );

        $this->load->view('document/cardshiftnewcard/wCardShiftNewCardDataTable', $aGenTable);
    }

    /**
     * Functionality : Function Call DataTables Card Shift
     * Parameters : Ajax and Function Parameter
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCardShiftNewCardDataSourceList()
    {
        $nPage = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');
        $tIsTemp = $this->input->post('tIsTemp');
        $tIsDataOnly = $this->input->post('tIsDataOnly');
        $tStaPrcDoc = $this->input->post('tStaPrcDoc');
        $tStaDoc = $this->input->post('tStaDoc');
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

        if ($tStaPrcDoc == "" && $tStaDoc == "") {
            // Validate document temp
            FSnHNewCrdChkCrdCodeNotDupTemp($paParams);
            FSnHNewCrdChkCrdCodeDup($paParams);
            // FSnHNewCrdChkCrdNameNotEmpty($paParams);
            FSnHNewCrdChkCardTypeInDB($paParams);
            // FSnHNewCrdChkDepartInDB($paParams);
        } else {
            if ($tStaPrcDoc == "" && $tStaDoc == "1") { // Document pending status(approve) or complete status(doc status)
                // Validate document temp
                FSnHNewCrdChkCrdCodeNotDupTemp($paParams);
                FSnHNewCrdChkCrdCodeDup($paParams);
                // FSnHNewCrdChkCrdNameNotEmpty($paParams);
                FSnHNewCrdChkCardTypeInDB($paParams);
                // FSnHNewCrdChkDepartInDB($paParams);
            }
        }


        // $this->mCardShiftNewCard->FSaMCardShiftNewCardUpdateStatusAll();


        // Call data on temp helper
        $aDataTemp  = array(
            'nPage' => $nPage,
            'nRow' => 10,
            'FNLngID' => $nLangEdit,
            'tSearchAll' => $tSearchAll,
            'FTBchCode' => "",
            'ptDocType' => "NewCard"
        );
        $aNewCardFromTemp = FSaSelectDataForDocType($aDataTemp);
        $aNewCard = FSaSelectAllBySessionID("cardShiftNewCard");

        $aGenTable = array(
            'aDataList' => $aNewCardFromTemp,
            'tDataListAll' => json_encode($aNewCard),
            'rnAllRow' => !empty($aNewCard['rnAllRow']) ? $aNewCard['rnAllRow'] : null,
            'ptDocType' => "NewCard",
            'tIDElement' => "",
            'tIsTemp' => $tIsTemp,
            'tIsDataOnly' => $tIsDataOnly,
            'nPage' => $nPage,
            'tSearchAll' => $tSearchAll,
            'tStaPrcDoc' => $tStaPrcDoc,
            'tStaDoc' => $tStaDoc,
            'tLastIndex' => $tLastIndex
        );

        $this->load->view('document/cardshiftnewcard/wCardShiftNewCardDataSourceTable', $aGenTable);
    }

    /**
     * Functionality : Insert card data to document temp
     * Parameters : {params}
     * Creator : 27/12/2018 piya
     * Last Modified : -
     * Return : {return}
     * Return Type : {type}
     */
    public function FSxCardShiftNewCardInsertToTemp()
    {
        $tUsrBchCode = $this->input->post('tBCHCode');
        $tUserCode = $this->session->userdata("tSesUsername");
        $oDataSet = json_decode($this->input->post('tDataSet'));
        $tDocNo = $this->input->post('tDocNo');

        if (isset($oDataSet->tCardStaSelectTabRange)) {
            $tNewCardStaSelect = $oDataSet->tCardStaSelectTabRange;
            $aDataSet = [
                "tDocNo" => $tDocNo,
                "tBchCode"  => $tUsrBchCode,
                "tCreateBy" => $tUserCode
            ];

            if ($tNewCardStaSelect == "1") { // 1: Auto gen insert code
                echo 'IN1';

                $tDataSetType = "CreateCard";
                $aDataSet['tNewCardCode'] = $oDataSet->tSingleAddCardCode;
                $aDataSet["tCardTypeCode"] = $oDataSet->tCardShiftNewCardCtyCode;
                $aDataSet['tDptCode'] = $oDataSet->tCardShiftNewCardDptCode;
                $aDataSet['tDptName'] = $oDataSet->tCardShiftNewCardDptName;
            }

            if ($tNewCardStaSelect == "2") { // 2: Manual insert code
                echo 'IN2';

                $tDataSetType = "CreateCardBetween";
                $aDataSet["tBeginCode"] = $oDataSet->tRangeDataAddNumberCode;
                $aDataSet["nCardLoop"] = $oDataSet->tRangeDataQtyCard;
                $aDataSet["tPrefixCode"] = $oDataSet->tRangeDataAddPreFix;
                $aDataSet["tCardTypeCode"] = $oDataSet->tCardShiftNewCardCtyCode;
                $aDataSet['tDptCode'] = $oDataSet->tCardShiftNewCardDptCode;
                $aDataSet['tDptName'] = $oDataSet->tCardShiftNewCardDptName;
            }

            FCNaCARDInsertDataToTemp("", $tDataSetType, [], $aDataSet);
        }
    }

    /**
     * Functionality : Update card data in document temp by row
     * Parameters : {params}
     * Creator : 27/12/2018 piya
     * Last Modified : -
     * Return : {return}
     * Return Type : {type}
     */
    public function FSxCardShiftNewCardUpdateInlineOnTemp()
    {
        $oNewCard = json_decode($this->input->post('tNewCard'));
        $nSeq = $this->input->post('nSeq');
        $tDocNo = $this->input->post('tDocNo');
        $tDocType = "cardShiftNewCard";
        $aDataSet = [
            'tNewCardCode' => $oNewCard->tCrdShiftNewCardCode,
            'tNewCardName' => $oNewCard->tCrdShiftNewCardName,
            'tCardTypeCode' => $oNewCard->tCrdShiftNewCtyCode,
            'tDptCode' => $oNewCard->tCrdShiftNewDptCode,
            'tDptName' => $oNewCard->tCrdShiftNewDptName,
            'tHolderID' => $oNewCard->tCrdShiftNewCardHolderID,
            'tDocNo' => $tDocNo,
            'tCrdShiftNewRmk' => $oNewCard->tCrdShiftNewRmk,
        ];
        FSxUpdateTempBySeq($tDocType, $nSeq, $aDataSet);
    }

    /**
     * Functionality : Function CallPage Card Shift Add
     * Parameters : Ajax and Function Parameter
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCardShiftNewCardAddPage()
    {
        $nLangResort = $this->session->userdata("tLangID");
        $nLangEdit = $this->session->userdata("tLangEdit");

        $aData  = array(
            'FNLngID' => $nLangEdit,
            'FTUsrCode' => $this->session->userdata("tSesUsername")
        );
        $aUser = $this->mUser->FSaMUSRByID($aData);

        $aDataAdd = array(
            'aResult' => ['rtCode' => '99'],
            'aUser' => $aUser,
            'aUserApv' => ['rtCode' => '99'],
            'tDocNo' => "",
            'aUserCreated' => ['rtCode' => '99'],
            'nLangEdit' => $nLangEdit,
        );

        $this->load->view('document/cardshiftnewcard/wCardShiftNewCardAdd', $aDataAdd);
    }

    /**
     * Functionality : Function CallPage Card Shift Edit
     * Parameters : Ajax and Function Parameter
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCardShiftNewCardEditPage()
    {
        $tCardShiftNewCardDocNo = $this->input->post('tCardShiftNewCardDocNo');
        $nLangEdit = $this->session->userdata("tLangEdit");

        $aData  = array(
            'FTCihDocNo' => $tCardShiftNewCardDocNo,
            'FNLngID' => $nLangEdit,
            'FTUsrCode' => $this->session->userdata("tSesUsername")
        );

        $aUser = $this->mUser->FSaMUSRByID($aData);
        $aPermission = FCNaHCheckAlwFunc("cardShiftNewCard/0/0");
        $tAPIReq = "";
        $tMethodReq = "GET";
        $aCardShiftNewCardData = $this->mCardShiftNewCard->FSaMCardShiftNewCardSearchByID($tAPIReq, $tMethodReq, $aData);

        $aData['FTUsrCode'] = $aCardShiftNewCardData['raItems']['rtCardShiftNewCardUsrCode'];
        $aUserCreated = $this->mUser->FSaMUSRByID($aData);

        $aData['FTUsrCode'] = $aCardShiftNewCardData['raItems']['rtCardShiftNewCardApvCode'];
        $aUserApv = $this->mUser->FSaMUSRByID($aData);

        $aData['FTBchCode'] = $aCardShiftNewCardData['raItems']['rtCardShiftNewCardBchCode'];
        $aData['FTCihDocNo'] = $aCardShiftNewCardData['raItems']['rtCardShiftNewCardDocNo'];

        // Remove in temp
        FCNoCARDataListDeleteOnlyTable("TFNTCrdImpTmp");

        // Copy from DT to temp
        FSxDocHelperDTToTemp("cardShiftNewCard", $aData['FTCihDocNo']);

        // $aCardShiftNewCardCardDataInDT = $this->mCardShiftNewCard->FSaMCardShiftNewCardGetDTByDocNo($aData);

        $aDataEdit = array(
            'aResult' => $aCardShiftNewCardData,
            'aUser' => $aUser,
            'tDocNo' => $tCardShiftNewCardDocNo,
            'aUserApv' => $aUserApv,
            'aUserCreated' => $aUserCreated,
            'aPermission' => $aPermission,
            'nLangEdit' => $nLangEdit
        );

        $this->load->view('document/cardshiftnewcard/wCardShiftNewCardAdd', $aDataEdit);
    }

    /**
     * Functionality : Event Add Card Shift
     * Parameters : Ajax and Function Parameter
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaCardShiftNewCardAddEvent()
    {
        $aDataMaster = array(
            'tIsAutoGenCode' => $this->input->post('ocbCardShiftNewCardAutoGenCode'),
            'FTCihDocNo' => $this->input->post('oetCardShiftNewCardCode'),
            'FDCihDocDate' => $this->input->post('oetCardShiftNewCardDocDate') . ' ' . date('H:i:s'),
            'FTCihDocType' => "7", // Take new card
            'FNCihStaDocAct' => 1, // Doc moment status(1:active)
            'FTBchCode' => $this->input->post('ohdCardShiftNewCardUsrBchCode'),
            'FTUsrCode' => $this->session->userdata("tSesUsername"),
            'FNCshCardQty' => FSnSelectCountResult('TFNTCrdImpTmp'),
            'aNewCard' => json_decode($this->input->post('aNewCard')),
            'FTCihApvCode' => $this->input->post('ohdCardShiftNewCardApvCode'),
            'FTCihStaPrcDoc' => $this->input->post('ohdCardShiftNewCardCardStaPrcDoc'),
            'FTCihStaDoc' => empty($this->input->post('hdCardShiftNewCardCardStaDoc')) ? "1" : $this->input->post('hdCardShiftNewCardCardStaDoc'),
            'FNCihStaDocAct' => empty($this->input->post('hdCardShiftNewCardCardStaDoc')) ? 1 : $this->input->post('hdCardShiftNewCardCardStaDoc'),
            'FTCreateBy' => $this->session->userdata('tSesUsername'),
            'FDCreateOn' => date('Y-m-d H:i:s'),
            'FNLngID' => $this->session->userdata("tLangEdit"),
        );

        // Setup DocNo
        if ($aDataMaster['tIsAutoGenCode'] == '1') { // Check Auto Gen DocNo?
            // Auto Gen DocNo Code
            // $aGenCode = FCNaHGenCodeV5('TFNTCrdImpHD', 7);
            // if($aGenCode['rtCode'] == '1'){
            //     $aDataMaster['FTCihDocNo'] = $aGenCode['rtCihDocNo'];
            // }
            $aStoreParam = array(
                "tTblName" => 'TFNTCrdImpHD',
                "tDocType" => '7',
                "tBchCode" => $aDataMaster['FTBchCode'],
                "tShpCode" => "",
                "tPosCode" => "",
                "dDocDate" => date("Y-m-d")
            );
            $aAutogen = FCNaHAUTGenDocNo($aStoreParam);
            $aDataMaster['FTCihDocNo'] = $aAutogen[0]["FTXxhDocNo"];
        }

        $oCountDup = $this->mCardShiftNewCard->FSoMCardShiftNewCardCheckDuplicate($aDataMaster['FTCihDocNo']);
        $nStaDup = $oCountDup[0]->counts;

        if ($nStaDup == 0) {
            $this->db->trans_begin();

            $aStaCardShiftNewCardHD = $this->mCardShiftNewCard->FSaMCardShiftNewCardAddUpdateHD($aDataMaster);

            if ($aStaCardShiftNewCardHD['rtCode'] == "1") { // Update HD success

                // Update DocNo on Temp
                FCNCallUpdateDocNo($aDataMaster['FTCihDocNo'], 'TFNTCrdImpTmp', ["tBchCode" => $aDataMaster['FTBchCode']]);

                // Copy from temp to DT
                FSxDocHelperTempToDT("cardShiftNewCard",$aDataMaster);

                // Remove in temp
                FCNoCARDataListDeleteOnlyTable("TFNTCrdImpTmp");
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
                    'tCodeReturn' => $aDataMaster['FTCihDocNo'],
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
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaCardShiftNewCardEditEvent()
    {
        try {
            $aDataMaster = array(
                'FTCihDocNo' => $this->input->post('oetCardShiftNewCardCode'),
                'FDCihDocDate' => $this->input->post('oetCardShiftNewCardDocDate') . ' ' . date('H:i:s'),
                'FTCihDocType' => "7", // Take new card
                'FNCihStaDocAct' => 1, // Doc moment status(1:active)
                'FTBchCode' => $this->input->post('ohdCardShiftNewCardUsrBchCode'),
                'FNCshCardQty' => FSnSelectCountResult('TFNTCrdImpTmp'),
                'aNewCard' => json_decode($this->input->post('aNewCard')),
                'FTCihApvCode' => $this->input->post('ohdCardShiftNewCardApvCode'),
                'FTCihStaPrcDoc' => $this->input->post('ohdCardShiftNewCardCardStaPrcDoc'),
                'FTCihStaDoc' => empty($this->input->post('hdCardShiftNewCardCardStaDoc')) ? "1" : $this->input->post('hdCardShiftNewCardCardStaDoc'),
                'FNCihStaDocAct' => empty($this->input->post('hdCardShiftNewCardCardStaDocAct')) ? 1 : $this->input->post('hdCardShiftNewCardCardStaDocAct'),
                'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FTCreateBy' => $this->session->userdata('tSesUsername'),
                'FDCreateOn' => date('Y-m-d H:i:s'),
                'FNLngID' => $this->session->userdata("tLangEdit"),
            );

            $this->db->trans_begin();

            $aCardShiftNewCardHD = $this->mCardShiftNewCard->FSaMCardShiftNewCardSearchByID("", "", $aDataMaster);
            if (
                ($aCardShiftNewCardHD['rtCode'] == "1") // Query HD success
                && (empty($aCardShiftNewCardHD["raItems"]['rtCardShiftNewCardStaPrcDoc'])) // On pending approve status 
                && ($aCardShiftNewCardHD["raItems"]['rtCardShiftNewCardStaDoc'] == "1") // On document complete status
            ) {
                $aStaCardShiftNewCardHD  = $this->mCardShiftNewCard->FSaMCardShiftNewCardAddUpdateHD($aDataMaster);

                if (($aStaCardShiftNewCardHD['rtCode'] == "1")) { // Update HD success

                    $paParams['tDocType'] = "NewCard";
                    $paParams['tDocNo'] = $aDataMaster['FTCihDocNo'];
                    // Remove on DT
                    FSaDeleteDatainTableDT($paParams);

                    // Copy from Temp to DT
                    FSxDocHelperTempToDT("cardShiftNewCard",$aDataMaster);

                    // Remove in temp
                    FCNoCARDataListDeleteOnlyTable("TFNTCrdImpTmp");
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
                    'tCodeReturn' => $aDataMaster['FTCihDocNo'],
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
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaCardShiftNewCardUpdateApvDocAndCancelDocEvent()
    {
        try {
            $aDataMaster = array(
                'FTCihDocNo' => $this->input->post('oetCardShiftNewCardCode'),
                'FDCihDocDate' => $this->input->post('oetCardShiftNewCardDocDate') . ' ' . date('H:i:s'),
                'FTCihDocType' => "7", // Take new card
                'FNCihStaDocAct' => 1, // Doc moment status(1:active)
                'FTBchCode' => $this->input->post('ohdCardShiftNewCardUsrBchCode'),
                'FTUsrCode' => $this->session->userdata("tSesUsername"),
                'FNCshCardQty' => count(json_decode($this->input->post('aNewCard'))),
                'aNewCard' => json_decode($this->input->post('aNewCard')),
                'FTCihApvCode' => $this->input->post('ohdCardShiftNewCardApvCode'),
                'FTCihStaPrcDoc' => $this->input->post('ohdCardShiftNewCardCardStaPrcDoc'),
                'FDCihApvDate' => date('Y-m-d H:i:s'),
                'FTCihStaDoc' => empty($this->input->post('hdCardShiftNewCardCardStaDoc')) ? "1" : $this->input->post('hdCardShiftNewCardCardStaDoc'),
                'FNCihStaDocAct' => empty($this->input->post('hdCardShiftNewCardCardStaDocAct')) ? 1 : $this->input->post('hdCardShiftNewCardCardStaDocAct'),
                'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FTCreateBy' => $this->session->userdata('tSesUsername'),
                'FDCreateOn' => date('Y-m-d H:i:s'),
                'FNLngID' => $this->session->userdata("tLangEdit")
            );
            
            $this->db->trans_begin();

            $aCardShiftNewCardHD = $this->mCardShiftNewCard->FSaMCardShiftNewCardSearchByID("", "", $aDataMaster);

            if (($aDataMaster['FTCihStaPrcDoc'] == "2") // Update status approve is true
                && ($aCardShiftNewCardHD['rtCode'] == "1") // Query HD success
                && (empty($aCardShiftNewCardHD["raItems"]['rtCardShiftNewCardStaPrcDoc'])) // On pending approve status 
                && ($aCardShiftNewCardHD["raItems"]['rtCardShiftNewCardStaDoc'] == "1") // On document complete status
            ) {
                $this->mCardShiftNewCard->FSaMCardShiftNewCardUpdateApvDocAndCancelDocHD($aDataMaster);
                $aGetDTByDocNo = $this->mCardShiftNewCard->FSaMCardShiftNewCardGetDTByDocNo($aDataMaster);
                  $tBchCode = $aDataMaster['FTBchCode'];
                  $tCardAgnCode = $this->mCardShiftNewCard->FSaMCardShiftFindAgencyByBranch($tBchCode);

                /*===== Begin Set Card Item ============================================*/
                $aCardItems = [];
                if ($aGetDTByDocNo['rtCode'] == "1") {
                    foreach ($aGetDTByDocNo['raItems'] as $aItem) {
                        $aCardItems['paItem'][] = [
                        "pnLngID" => $aDataMaster['FNLngID'],
                        "ptBchCode" => $aDataMaster['FTBchCode'],
                        "ptCrdCode" => $aItem['rtCardShiftNewCardCrdCode'],
                        "ptCtyCode" => $aItem['rtCardShiftNewCardCtyCode'],
                        "ptCrdHolderID" => $aItem['rtCardShiftNewCardCrdHolderID'],
                        "ptCrdName" => $aItem['rtCardShiftNewCardCrdName'],
                        "ptDptCode" => "",
                        "ptTxnDocNoRef" => $aDataMaster['FTCihDocNo'],
                        "ptUsrCode" => $aDataMaster['FTUsrCode'],
                        "ptAgnCode" => $tCardAgnCode
                    ];
                    }
                }
                /*===== End Set Card Item ==============================================*/

                /*========================== Approved =========================*/
                try {
                    /* Params MQ
                    {
                    "ptFunction":"CardListCreate", < ชื่อ Function
                    "ptSource":"", < ต้นทาง
                    "ptDest":"MQWallet", < ปลายทาง
                    "ptFilter":"", < data fillter
                    "ptData": "{"paItem":[
                            {
                            "pnLngID":"1",
                            "ptBchCode":"00001",
                            "ptCrdCode":"00001",
                            "ptCtyCode":"00002",
                            "ptCrdHolderID":"2828049",
                            "ptCrdName":"Holiday FeelGood",
                            "ptDptCode":"",
                            "ptTxnDocNoRef":"CT2000001000001",
                            "ptUsrCode":"009"
                            },{
                            "pnLngID":"1",
                            "ptBchCode":"00001",
                            "ptCrdCode":"00002",
                            "ptCtyCode":"00002",
                            "ptCrdHolderID":"212131",
                            "ptCrdName":"John Smith",
                            "ptDptCode":"",
                            "ptTxnDocNoRef":"CT2000001000001",
                            "ptUsrCode":"009"
                            }]}"
                    }
                    */
                    $aMQParams = [
                        "tVhostType" => "W",
                        "queueName" => "FN_QPosPrc",
                        "params" => [
                            "ptFunction" => "CardListCreate",
                            "ptSource" => "AdaStoreBack",
                            "ptDest" => "",
                            "ptFilter" => "",
                            "ptDocNo" => $aDataMaster['FTCihDocNo'],
                            "ptData" => json_encode($aCardItems)
                        ]
                    ];
                    FCNxCallRabbitMQ($aMQParams);
                } catch (\ErrorException $err) {
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent' => '900',
                        'tStaMessg' => language('document/card/newcard', 'tCardShiftNewCardApproveFail')
                    );
                    echo json_encode($aReturn);
                    return;
                }
                /*=============================================================*/
            }

            /*=============================== Cancel ==========================*/
            if (($aDataMaster['FTCihStaDoc'] == "3")) { // Have card and update status document is cancel
                $this->mCardShiftNewCard->FSaMCardShiftNewCardUpdateApvDocAndCancelDocHD($aDataMaster);
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
                    'tCodeReturn' => $aDataMaster['FTCihDocNo'],
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
    public function FSaCardShiftNewCardDeleteEvent()
    {
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTCardShiftNewCardCode' => $tIDCode
        );

        $aResDel = $this->mCardShiftNewCard->FSnMCardShiftNewCardDel($aDataMaster);
        $aReturn = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }

    /**
     * Functionality : Vatrate unique check
     * Parameters : $tSelect "CardShiftNewCardcode"
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : Check status true or false
     * Return Type : String
     */
    public function FStCardShiftNewCardUniqueValidate($tSelect = '')
    {

        if ($this->input->is_ajax_request()) { // Request check
            if ($tSelect == 'cardShiftNewCardCode') {

                $tCardShiftNewCardCode = $this->input->post('tCardShiftNewCardCode');
                $oCustomerGroup = $this->mCardShiftNewCard->FSoMCardShiftNewCardCheckDuplicate($tCardShiftNewCardCode);

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
    public function FSoCardShiftNewCardDeleteMulti()
    {
        $tCardShiftNewCardCode = $this->input->post('tCardShiftNewCardCode');

        $aCardShiftNewCardCode = json_decode($tCardShiftNewCardCode);
        foreach ($aCardShiftNewCardCode as $oCardShiftNewCardCode) {
            $aCardShiftNewCard = ['FTCardShiftNewCardCode' => $oCardShiftNewCardCode];
            $this->mCardShiftNewCard->FSnMCardShiftNewCardDel($aCardShiftNewCard);
        }
        echo json_encode($aCardShiftNewCardCode);
    }

    /**
     * Functionality : Delete vat rate
     * Parameters : -
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : Vat code
     * Return Type : Object
     */
    public function FSoCardShiftNewCardDelete()
    {
        $tCardShiftNewCardCode = $this->input->post('tCardShiftNewCardCode');

        $aCardShiftNewCard = ['FTCardShiftNewCardCode' => $tCardShiftNewCardCode];
        $this->mCardShiftNewCard->FSnMCardShiftNewCardDel($aCardShiftNewCard);
        echo json_encode($tCardShiftNewCardCode);
    }

    /**
     * Functionality : Function Call DataTables Card Shift by file (xls or xlsx)
     * Parameters : Ajax and Function Parameter
     * Creator : 02/11/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCardShiftNewCardDataSourceListByFile()
    {
        try {
            $aDataFiles = (isset($_FILES['oefCardShiftNewCardImport']) && !empty($_FILES['oefCardShiftNewCardImport'])) ? $_FILES['oefCardShiftNewCardImport'] : null;

            if (isset($aDataFiles) && !empty($aDataFiles) && is_array($aDataFiles)) {
                // Insert
                $aDataFiles = (isset($_FILES['aFile']) && !empty($_FILES['aFile'])) ? $_FILES['aFile'] : null;
                $ptDocType = 'NewCard'; // CardTnf
                $ptDataSetType = 'Excel';
                $paDataExcel = [
                    'file' => $aDataFiles,
                    'reasonfile' => '',
                    'optionfile_newcard' => 0,
                    'nDocno' => $this->input->post('tDocNo'),
                    'tBCHCode' =>  $this->input->post('tBchCode')
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
            echo "Controller Err FSvCardShiftNewCardDataSourceListByFile = " . $Error;
        }
    }

    /**
     * Functionality : Function Check Card Code Duplicate In DB
     * Parameters : Ajax and Function Parameter
     * Creator : 10/12/2018 Wasin(Yoshi)
     * Last Modified : -
     * Return : object Status Duplicate
     * Return Type : Object
     */
    public function FSnCardShiftNewCardChkCardCodeDup()
    {
        try {
            $tCardCodeChkDup = $this->input->post('tCardCodeChkDup');
            $aDataChkDup = $this->mCardShiftNewCard->FSaMCheckDataCardInDB($tCardCodeChkDup);
            echo $aDataChkDup['counts'];
        } catch (Exception $Error) {
            echo 'Error FSoCardShiftNewCardChkCardCodeDup ' . $Error;
        }
    }

    //Gen Code
    public function FCNaGenCodeCard()
    {
        $tTableName = $this->input->post('tTableName');
        $aStoreParam = array(
            "tTblName" => $tTableName,
            "tDocType" => 0,
            "tBchCode" => '',
            "tShpCode" => "",
            "tPosCode" => "",
            "dDocDate" => date("Y-m-d")
        );

        $aAutogen = FCNaHAUTGenDocNo($aStoreParam);
        $aReturn = array(
            'rtCode' => 1,
            'rtCrdCode' => $aAutogen[0]['FTXxhDocNo']
        );
        echo json_encode($aReturn);
    }

    // Functionality : Function Event Delete Coupon Document
    // Parameters : Ajax and Function Parameter
    // Creator : 26/12/2019 Wasin(Yoshi)
    // Return : Object View Page Add
    // Return Type : object
    public function FSoCardShiftNewCardEventDelete(){
        try{
            $tDataNewCardNo  = $this->input->post('tCrdShifNewCardDocNo');
            $tBchCode       = $this->input->post('tBchCode');

            $aDataDel = array(
                'FTCihDocNo'      => $tDataNewCardNo,
                'FTBchCode'       => $tBchCode
            );

        $aResDelCNewCardNo  = $this->mCardShiftNewCard->FSnMCardShifNewCardDelDocument($aDataDel);

        if($aResDelCNewCardNo['rtCode'] == 1){
            $aDataStaReturn = array(
                'nStaEvent' => '1',
                'tStaMessg' => 'Success'
            ); 
        }else{
            $aDataStaReturn = array(
                'nStaEvent' => $aResDelCNewCardNo['rtCode'],
                'tStaMessg' => $aResDelCNewCardNo['rtDesc']
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


    // Functionality : Function Event Delete Multi
    // Parameters : Ajax and Function Parameter
    // Creator : 26/12/2019 Wasin(Yoshi)
    // Return : Object View Page Add
    // Return Type : object
    public function FSoCardShiftNewCardEventDeleteMulti(){

        $aDocNo  = $this->input->post('aDocNo');
        
        $this->db->trans_begin();

        foreach($aDocNo AS $aItem){
            $aDelMasterParams = [
                'tDocNo' => trim($aItem)
            ];
            $this->mCardShiftNewCard->FSaMDelMultiMaster($aDelMasterParams);
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
}
