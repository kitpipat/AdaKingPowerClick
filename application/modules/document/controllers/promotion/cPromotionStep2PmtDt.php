<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cPromotionStep2PmtDt extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('document/promotion/mPromotionStep2PmtDt');
        $this->load->model('document/promotion/mPromotion');
    }

    /**
     * Functionality : Get PmtDt Group Name in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSxCPromotionGetPmtDtGroupNameInTmp()
    {
        $tGroupType = $this->input->post('tGroupType');
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

        $aGetPmtDtInTmpParams  = array(
            'tGroupType' => $tGroupType,
            'FNLngID' => $nLangEdit,
            'nPage' => $nPage,
            'nRow' => 50,
            'tSearchAll' => $tSearchAll,
            'tUserSessionID' => $tUserSessionID
        );
        $aResList = $this->mPromotionStep2PmtDt->FSaMGetPmtDtGroupInTmp($aGetPmtDtInTmpParams);

        $aGenTable = array(
            'tGroupType' => $tGroupType,
            'aAlwEvent' => $aAlwEvent,
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'nOptDecimalShow' => $nOptDecimalShow
        );
        $tHtml = $this->load->view('document/promotion/advance_page/wStep2GroupNameItemTmp', $aGenTable, true);
        
        $aResponse = [
            'html' => $tHtml
        ];

        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aResponse));
    }

    /**
     * Functionality : Get PmtCB to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : PmtCB Detail
     * Return Type : String
     */
    public function FStCPromotionGetPmtCBInTmp()
    {
        $nLangEdit = $this->session->userdata("tLangEdit");
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLoginCode = $this->session->userdata("tSesUsername");
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tBchCodeLogin = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCodeDefault");

        $aGetPmtCBInTmpParams = [
            'tUserSessionID' => $tUserSessionID
        ];
        $aPmtCBInTmp = $this->mPromotionStep2PmtDt->FSaMGetPmtCBInTmp($aGetPmtCBInTmpParams);

        $aGenTable = array(
            'aDataList' => $aPmtCBInTmp,
        );
        $tHtml = $this->load->view('document/promotion/advance_page/wStep2GroupNameItemCBTmp', $aGenTable, true);
        
        $aResponse = [
            'html' => $tHtml
        ];

        $this->output->set_content_type('application/json')->set_output(json_encode($aResponse));
    }

    /**
     * Functionality : Get PmtCG to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : PmtCG Detail
     * Return Type : String
     */
    public function FStCPromotionGetPmtCGInTmp()
    {
        $nLangEdit = $this->session->userdata("tLangEdit");
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLoginCode = $this->session->userdata("tSesUsername");
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tBchCodeLogin = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCodeDefault");

        $aGetPmtCGInTmpParams = [
            'tUserSessionID' => $tUserSessionID
        ];
        $aPmtCGInTmp = $this->mPromotionStep2PmtDt->FSaMGetPmtCGInTmp($aGetPmtCGInTmpParams);

        $aGenTable = array(
            'aDataList' => $aPmtCGInTmp,
        );
        $tHtml = $this->load->view('document/promotion/advance_page/wStep2GroupNameItemCGTmp', $aGenTable, true);
        
        $aResponse = [
            'html' => $tHtml
        ];

        $this->output->set_content_type('application/json')->set_output(json_encode($aResponse));
    }
}