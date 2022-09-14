<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cDepositCash extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('document/deposit/mDepositCash');
        $this->load->model('document/deposit/mDeposit');
    }

    /**
     * Functionality : Get Cash in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSxCDepositGetCashInTmp()
    {
        $tSearchAll = $this->input->post('tSearchAll');
        $nPage = $this->input->post('nPageCurrent');
        $aAlwEvent = FCNaHCheckAlwFunc('deposit/0/0');
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        $tUserSessionID = $this->session->userdata("tSesSessionID");

        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nPageCurrent');
        }
        $nLangEdit = $this->session->userdata("tLangEdit");

        $aGetCashInTmpParams  = array(
            'FNLngID' => $nLangEdit,
            'nPage' => $nPage,
            'nRow' => 20,
            'tSearchAll' => $tSearchAll,
            'tUserSessionID' => $tUserSessionID
        );
        $aResList = $this->mDepositCash->FSaMGetCashInTmp($aGetCashInTmpParams);

        $aCalInTmpParams = [
            'tUserSessionID' => $tUserSessionID,
            'tDocKey' => 'TFNTBnkDplHD'    
        ];
        $aCalInTmp = $this->mDeposit->FSxMCalInTmp($aCalInTmpParams);
        
        $aCalInTmp['FTBddRefAmtCashTotalText'] = FCNtNumberToTextBaht(number_format($aCalInTmp['FCBddRefAmtCashTotal'], $nOptDecimalShow));
        $aCalInTmp['FCBddRefAmtCashTotal'] = number_format($aCalInTmp['FCBddRefAmtCashTotal'], $nOptDecimalShow);
        $aCalInTmp['FTBddRefAmtTotalText'] = FCNtNumberToTextBaht(number_format($aCalInTmp['FCBddRefAmtTotal'], $nOptDecimalShow));
        $aCalInTmp['FCBddRefAmtTotal'] = number_format($aCalInTmp['FCBddRefAmtTotal'], $nOptDecimalShow);

        $aGenTable = array(
            'aAlwEvent' => $aAlwEvent,
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'nOptDecimalShow' => $nOptDecimalShow,
            'aCalInTmp' => $aCalInTmp
        );
        $tHtml = $this->load->view('document/deposit/advance_table/wDepositCashDatatable', $aGenTable, true);
        
        $aResponse = [
            'calInTmp' => $aCalInTmp,
            'html' => $tHtml
        ];

        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aResponse));
    }

    /**
     * Functionality : Insert Cash to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaCDepositInsertCashToTmp()
    {
        $tBchCode = $this->input->post('tBchCode');
        $tCashDate = empty($this->input->post('tCashDate'))?date('Y-m-d'):$this->input->post('tCashDate');
        $cCashValue = str_replace(",","",empty($this->input->post('cCashValue'))?"0.00":$this->input->post('cCashValue'));
        $nLangEdit = $this->session->userdata("tLangEdit");
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLoginCode = $this->session->userdata("tSesUsername");
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tBchCodeLogin = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCode");

        $aPdtlayoutToTempParams = [
            'tDocNo' => 'DPLDOCTEMP',
            'tDocKey' => 'TFNTBnkDplHD',
            'tBchCode' => $tBchCode,
            'tCashDate' => $tCashDate,
            'cCashValue' => $cCashValue,
            'tBchCodeLogin' => $tBchCodeLogin,
            'tUserSessionID' => $tUserSessionID,
            'tUserLoginCode' => $tUserLoginCode,
            'nLngID' => $nLangEdit
        ];
        $this->mDepositCash->FSaMCashToTemp($aPdtlayoutToTempParams);
    }

    /**
     * Functionality : Update Cash in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCDepositUpdateCashInTmp()
    {
        $tCashDate = $this->input->post('tCashDate');
        $cCashValue = str_replace(",","",empty($this->input->post('cCashValue'))?"0.00":$this->input->post('cCashValue'));
        $nSeqNo = $this->input->post('nSeqNo');
        $tBchCode = $this->input->post('tBchCode');
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLoginCode = $this->session->userdata("tSesUsername");
        
        $aUpdateCashInTmpBySeqParams = [
            'tCashDate' => $tCashDate,
            'cCashValue' => $cCashValue,
            'tUserLoginCode' => $tUserLoginCode,
            'tUserSessionID' => $tUserSessionID,
            'nSeqNo' => $nSeqNo,
        ];
        $this->mDepositCash->FSbUpdateCashInTmpBySeq($aUpdateCashInTmpBySeqParams);
    }

    /**
     * Functionality : Delete Cash in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCDepositDeleteCashInTmp()
    {
        $nSeqNo = $this->input->post('nSeqNo');
        $tUserSessionID = $this->session->userdata("tSesSessionID");

        $aDeleteInTmpBySeqParams = [
            'tUserSessionID' => $tUserSessionID,
            'nSeqNo' => $nSeqNo,
        ];
        $this->mDepositCash->FSbDeleteCashInTmpBySeq($aDeleteInTmpBySeqParams);
    }

    /**
     * Functionality : Clear Cash in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCDepositClearCashInTmp()
    {
        $tUserSessionID = $this->session->userdata("tSesSessionID");

        $aClearCashInTmpParams = [
            'tUserSessionID' => $tUserSessionID
        ];
        $this->mDepositCash->FSbClearCashInTmp($aClearCashInTmpParams);
    }

}