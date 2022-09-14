<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cPromotionStep1PmtPdtDt extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('document/promotion/mPromotionStep1PmtPdtDt');
        $this->load->model('document/promotion/mPromotionStep1PmtDt');
        $this->load->model('document/promotion/mPromotion');
    }

    /**
     * Functionality : Get PmtPdtDt in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSxCPromotionGetPmtPdtDtInTmp()
    {
        $tPmtGroupTypeTmp = $this->input->post('tPmtGroupTypeTmp');
        $tPmtGroupListTypeTmp = $this->input->post('tPmtGroupListTypeTmp');
        $tPmtGroupNameTmp = $this->input->post('tPmtGroupNameTmp');
        $tPmtGroupNameTmpOld = $this->input->post('tPmtGroupNameTmpOld');
        $tSearchAll = $this->input->post('tSearchAll');
        $nPage = $this->input->post('nPageCurrent');
        $aAlwEvent = FCNaHCheckAlwFunc('promotion/0/0');
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tBchCodeLogin = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCodeDefault");

        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nPageCurrent');
        }
        $nLangEdit = $this->session->userdata("tLangEdit");

        $aGetPmtPdtDtInTmpParams  = array(
            'tPmtGroupNameTmp' => $tPmtGroupNameTmp,
            'tPmtGroupTypeTmp' => $tPmtGroupTypeTmp,
            'tPmtGroupListTypeTmp' => $tPmtGroupListTypeTmp,
            'FNLngID' => $nLangEdit,
            'nPage' => $nPage,
            'nRow' => 500,
            'tSearchAll' => $tSearchAll,
            'tUserSessionID' => $tUserSessionID
        );
        $aResList = $this->mPromotionStep1PmtPdtDt->FSaMGetPmtPdtDtInTmp($aGetPmtPdtDtInTmpParams);

        $aGetPmtPdtDtInAllTmpParams  = array(
            'FNLngID' => $nLangEdit,
            'tBchCodeLogin' => $tBchCodeLogin,
            'tUserSessionID' => $tUserSessionID,
            'tPmtGroupNameTmpOld' => $tPmtGroupNameTmpOld
        );
        $aGetPmtPdtDtInAllTmp = $this->mPromotionStep1PmtPdtDt->FSaMGetPmtPdtDtInAllTmp($aGetPmtPdtDtInAllTmpParams);
        
        $aNotIn = [];
        foreach($aGetPmtPdtDtInAllTmp as $nIndex => $aGetPmtPdtDtInAllTmpItem){
            $aNotIn[$nIndex][] = $aGetPmtPdtDtInAllTmpItem['FTPmdRefCode'];
            $aNotIn[$nIndex][] = $aGetPmtPdtDtInAllTmpItem['FTPmdBarCode'];
        }

        $aGenTable = array(
            'aAlwEvent' => $aAlwEvent,
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'nOptDecimalShow' => $nOptDecimalShow
        );
        $tHtml = $this->load->view('document/promotion/advance_table/wStep1PmtPdtDtTableTmp', $aGenTable, true);
        
        $aResponse = [
            'html' => $tHtml,
            'notIn' => $aNotIn
        ];

        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aResponse));
    }

    /**
     * Functionality : Insert PmtPdtDt to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaCPromotionInsertPmtPdtDtToTmp()
    {
        $tPmtGroupNameTmp = $this->input->post('tPmtGroupNameTmp');
        $tPmtGroupNameTmpOld = $this->input->post('tPmtGroupNameTmpOld');
        $tPmtGroupTypeTmp = $this->input->post('tPmtGroupTypeTmp');
        $tPmtGroupListTypeTmp = $this->input->post('tPmtGroupListTypeTmp');
        $tPdtList = $this->input->post('tPdtList');
        $nLangEdit = $this->session->userdata("tLangEdit");
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserSessionDate = $this->session->userdata("tSesSessionDate");
        $tUserLoginCode = $this->session->userdata("tSesUsername");
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tBchCodeLogin = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCodeDefault");

        $this->db->trans_begin();

        $aClearPmtDtShopAllInTmpParams = [
            'tUserSessionID' => $tUserSessionID,
            'tPmtGroupNameTmpOld' => $tPmtGroupNameTmpOld
        ];
        $this->mPromotionStep1PmtDt->FSbClearPmtDtShopAllInTmp($aClearPmtDtShopAllInTmpParams);

        $aPdtList = json_decode($tPdtList, JSON_OBJECT_AS_ARRAY);
        
        if (isset($aPdtList) && is_array($aPdtList) && !empty($aPdtList)) {
            foreach ($aPdtList as $aItem) {
                $aPackData = $aItem['packData'];
                $aPmtPdtDtToTempParams = [
                    'tDocNo' => 'PMTDOCTEMP',
                    'tPmtGroupNameTmp' => $tPmtGroupNameTmp,
                    'tPmtGroupNameTmpOld' => $tPmtGroupNameTmpOld,
                    'tPmtGroupTypeTmp' => $tPmtGroupTypeTmp,
                    'tPmtGroupListTypeTmp' => $tPmtGroupListTypeTmp,
                    'tBchCodeLogin' => $tBchCodeLogin,
                    'tUserSessionID' => $tUserSessionID,
                    'tUserSessionDate' => $tUserSessionDate,
                    'tUserLoginCode' => $tUserLoginCode,
                    'tPdtCode' => $aPackData['PDTCode'],
                    'tPdtName' => $aPackData['PDTName'],
                    'tPunCode' => $aPackData['PUNCode'],
                    'tPunName' => $aPackData['PUNName'],
                    'tBarCode' => $aPackData['Barcode'],
                    'nLngID' => $nLangEdit
                ];
                $this->mPromotionStep1PmtPdtDt->FSaMPmtPdtDtToTemp($aPmtPdtDtToTempParams);
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess InsertPmtPdtDtToTmp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg' => 'Success InsertPmtPdtDtToTmp'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Update PmtPdtDt in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCPromotionUpdatePmtPdtDtInTmp()
    {
        $tPmtPdtDtDate = $this->input->post('tPmtPdtDtDate');
        $cPmtPdtDtValue = $this->input->post('cPmtPdtDtValue');
        $nSeqNo = $this->input->post('nSeqNo');
        $tBchCode = $this->input->post('tBchCode');
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLoginCode = $this->session->userdata("tSesUsername");
        
        $this->db->trans_begin();

        $aUpdatePmtPdtDtInTmpBySeqParams = [
            'tPmtPdtDtDate' => $tPmtPdtDtDate,
            'cPmtPdtDtValue' => $cPmtPdtDtValue,
            'tUserLoginCode' => $tUserLoginCode,
            'tUserSessionID' => $tUserSessionID,
            'nSeqNo' => $nSeqNo,
        ];
        $this->mPromotionStep1PmtPdtDt->FSbUpdatePmtPdtDtInTmpBySeq($aUpdatePmtPdtDtInTmpBySeqParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess UpdatePmtPdtDtInTmp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg' => 'Success UpdatePmtPdtDtInTmp'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }
}