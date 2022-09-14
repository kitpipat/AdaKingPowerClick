<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cPromotionStep3PmtCB extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('document/promotion/mPromotionStep3PmtCB');
        $this->load->model('document/promotion/mPromotion');
    }

    /**
     * Functionality : Get PmtCB in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSxCPromotionGetPmtCBInTmp()
    {
        $tPbyStaBuyCond = $this->input->post('tPbyStaBuyCond');
        $tSearchAll = $this->input->post('tSearchAll');
        $nPage = $this->input->post('nPageCurrent');
        $aAlwEvent = FCNaHCheckAlwFunc('promotion/0/0');
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tBchCodeLogin = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCodeDefault");
        $bIsAlwPmtDisAvg = json_decode($this->input->post('bIsAlwPmtDisAvg'));

        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nPageCurrent');
        }
        $nLangEdit = $this->session->userdata("tLangEdit");

        $aGetPmtCBInTmpParams  = array(
            'FNLngID' => $nLangEdit,
            'nPage' => $nPage,
            'nRow' => 50,
            'tSearchAll' => $tSearchAll,
            'tUserSessionID' => $tUserSessionID
        );
        $aResList = $this->mPromotionStep3PmtCB->FSaMGetPmtCBInTmp($aGetPmtCBInTmpParams);

        $aGenTable = array(
            'tPbyStaBuyCond' => $tPbyStaBuyCond,
            'aAlwEvent' => $aAlwEvent,
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'nOptDecimalShow' => $nOptDecimalShow,
            'bIsAlwPmtDisAvg' => $bIsAlwPmtDisAvg
        );
        $tHtml = $this->load->view('document/promotion/advance_table/wStep3PmtCBTableTmp', $aGenTable, true);
        
        $aResponse = [
            'html' => $tHtml
        ];

        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aResponse));
    }



    /**
     * Functionality : Update PmtCB in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCPromotionUpdatePmtCBInTmp()
    {
        $tStaBuyIsRange = $this->input->post('tStaBuyIsRange'); // 1:is range
        $tPbyStaBuyCond = $this->input->post('tPbyStaBuyCond'); // 1:ครบจำนวน 2:ครบมูลค่า 3:ตามช่วงจำนวน 4:ตามช่วงมูลค่า 5:ตามช่วงเวลา
        $tPbyMinValue = $this->input->post('tPbyMinValue');
        $tPbyMaxValue = ($tPbyStaBuyCond == "5" || $tPbyStaBuyCond == "6")?0:$this->input->post('tPbyMaxValue');
        $tPbyMinSetPri = ($tPbyStaBuyCond == "5" || $tPbyStaBuyCond == "6")?0:$this->input->post('tPbyMinSetPri');
        $tPgtPerAvgDisCB = $this->input->post('tPgtPerAvgDisCB');
        $tPbyMinTime = ($tPbyStaBuyCond == "5" || $tPbyStaBuyCond == "6")?$this->input->post('tPbyMinTime'):'';
        $tPbyPbyMaxTime = ($tPbyStaBuyCond == "5" || $tPbyStaBuyCond == "6")?$this->input->post('tPbyPbyMaxTime'):'';
        $nSeqNo = $this->input->post('nSeqNo');
        $tFieldName = $this->input->post('tFieldName');
        $tFormatType = $this->input->post('tFormatType');
        $tBchCode = $this->input->post('tBchCode');
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLoginCode = $this->session->userdata("tSesUsername");
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        
        $this->db->trans_begin();

        $aGetPmtCBAndPmtCGPgtPerAvgDisInTmpParams = [
            'tUserSessionID' => $tUserSessionID,
            'nSeqNo' => $nSeqNo,
        ];

        if($tStaBuyIsRange == "1"){ // 1:is range
            $tPgtPerAvgDisCB = 0.00;
            // $cPgtPerAvgDis = $this->mPromotionStep3PmtCB->FScMGetPmtCBAndPmtCGPgtPerAvgDisInTmp($aGetPmtCBAndPmtCGPgtPerAvgDisInTmpParams);
        }else{
            $cPgtPerAvgDis = $this->mPromotionStep3PmtCB->FScMGetPmtCBAndPmtCGPgtPerAvgDisOnCBInTmp($aGetPmtCBAndPmtCGPgtPerAvgDisInTmpParams);
            $cPgtPerAvgDisBal = 100.00 - $cPgtPerAvgDis;
        
            if($tPgtPerAvgDisCB > $cPgtPerAvgDisBal) {
                $tPgtPerAvgDisCB = $cPgtPerAvgDisBal;
            }

            if($cPgtPerAvgDisBal <= 0.00){
                $tPgtPerAvgDisCB = 0.00;
            }
        }

        $aUpdatePmtCBInTmpBySeqParams = [
            'tPbyMinValue' => str_replace(",", "", $tPbyMinValue),
            'tPbyMaxValue' => str_replace(",", "", $tPbyMaxValue),
            'tPbyMinSetPri' => str_replace(",", "", $tPbyMinSetPri),
            'tPgtPerAvgDisCB' => str_replace(",", "", $tPgtPerAvgDisCB),
            'tPbyMinTime' => $tPbyMinTime,
            'tPbyPbyMaxTime' => $tPbyPbyMaxTime,
            'tUserLoginCode' => $tUserLoginCode,
            'tUserSessionID' => $tUserSessionID,
            'nSeqNo' => $nSeqNo,
            'tFieldName' => $tFieldName,
            'tFormatType' => $tFormatType,
            'nOptDecimalShow' => $nOptDecimalShow
        ];
        $aUpdateRes = $this->mPromotionStep3PmtCB->FSbUpdatePmtCBInTmpBySeq($aUpdatePmtCBInTmpBySeqParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent' => '900',
                'tStaMessg' => "Unsucess UpdatePmtCBInTmp",
                'tValue' => $aUpdateRes
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent' => '1',
                'tStaMessg' => 'Success UpdatePmtCBInTmp',
                'tValue' => $aUpdateRes
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Insert PmtCB to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaCPromotionInsertPmtCBToTmp()
    {
        // $tStaSpcGrpDisIsDisSomeGroup = $this->input->post('tStaSpcGrpDisIsDisSomeGroup');
        $tGroupNameInBuy = $this->input->post('tGroupNameInBuy');
        $tPbyStaBuyCond = $this->input->post('tPbyStaBuyCond');
        $nLangEdit = $this->session->userdata("tLangEdit");
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserSessionDate = $this->session->userdata("tSesSessionDate");
        $tUserLoginCode = $this->session->userdata("tSesUsername");
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tBchCodeLogin = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCodeDefault");
        $bIsAlwPmtDisAvg = json_decode($this->input->post('bIsAlwPmtDisAvg'));
        
        $this->db->trans_begin();

        $aDeletePmtCBInTmpByGroupNameParams = [
            'tUserSessionID' => $tUserSessionID,
            'tGroupNameInBuy' => $tGroupNameInBuy
        ];
        $this->mPromotionStep3PmtCB->FSbDeletePmtCBInTmpByGroupName($aDeletePmtCBInTmpByGroupNameParams);

        $aPmtCBToTempParams = [
            'tDocNo' => 'PMTDOCTEMP',
            'tGroupNameInBuy' => $tGroupNameInBuy,
            'tPbyStaBuyCond' => $tPbyStaBuyCond, // เงื่อนไขการซื้อ
            'tBchCodeLogin' => $tBchCodeLogin,
            'tUserSessionID' => $tUserSessionID,
            'tUserSessionDate' => $tUserSessionDate,
            'tUserLoginCode' => $tUserLoginCode,
            'nLngID' => $nLangEdit,
            'bIsAlwPmtDisAvg' => $bIsAlwPmtDisAvg
            // 'bStaSpcGrpDisIsDisSomeGroup' => json_decode($tStaSpcGrpDisIsDisSomeGroup)
        ];
        $this->mPromotionStep3PmtCB->FSaMPmtCBToTemp($aPmtCBToTempParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent' => '900',
                'tStaMessg' => "Unsucess InsertPmtCBToTmp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent' => '1',
                'tStaMessg' => 'Success InsertPmtCBToTmp'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Update PmtCB in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCPromotionUpdatePmtCBRangeInTmp()
    {
        $tPbyMinValue = $this->input->post('tPbyMinValue');
        $tPbyMaxValue = $this->input->post('tPbyMaxValue');
        $tPbyMinSetPri = $this->input->post('tPbyMinSetPri');
        $tPgtPerAvgDisCB = $this->input->post('tPgtPerAvgDisCB');
        $nSeqNo = $this->input->post('nSeqNo');
        $tBchCode = $this->input->post('tBchCode');
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLoginCode = $this->session->userdata("tSesUsername");
        
        $this->db->trans_begin();

        $aUpdatePmtCBInTmpBySeqParams = [
            'tPbyMinValue' => $tPbyMinValue,
            'tPbyMaxValue' => $tPbyMaxValue,
            'tPbyMinSetPri' => $tPbyMinSetPri,
            'tPgtPerAvgDisCB' => $tPgtPerAvgDisCB,
            'tUserLoginCode' => $tUserLoginCode,
            'tUserSessionID' => $tUserSessionID,
            'nSeqNo' => $nSeqNo,
        ];
        $this->mPromotionStep3PmtCB->FSbUpdatePmtCBInTmpBySeq($aUpdatePmtCBInTmpBySeqParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent' => '900',
                'tStaMessg' => "Unsucess UpdatePmtCBRangeInTmp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent' => '1',
                'tStaMessg' => 'Success UpdatePmtCBRangeInTmp'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Delete PmtCB in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaCPromotionDeletePmtCBInTmp()
    {
        $tGroupNameInBuy = $this->input->post('tGroupNameInBuy');
        $tPbyStaBuyCond = $this->input->post('tPbyStaBuyCond');
        $nLangEdit = $this->session->userdata("tLangEdit");
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLoginCode = $this->session->userdata("tSesUsername");
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tBchCodeLogin = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCodeDefault");

        $this->db->trans_begin();

        $aDeletePmtCBInTmpByGroupNameParams = [
            'tUserSessionID' => $tUserSessionID,
            'tGroupNameInBuy' => $tGroupNameInBuy
        ];
        $this->mPromotionStep3PmtCB->FSbDeletePmtCBInTmpByGroupName($aDeletePmtCBInTmpByGroupNameParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent' => '900',
                'tStaMessg' => "Unsucess DeletePmtCBInTmp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent' => '1',
                'tStaMessg' => 'Success DeletePmtCBInTmp'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Insert PmtCB and PmtCG to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaCPromotionInsertPmtCBAndPmtCGToTmp()
    {
        $tGroupName = $this->input->post('tGroupName');
        $tPbyStaBuyCond = $this->input->post('tPbyStaBuyCond');
        $tStaGrpPriorityIsPriceGroup = $this->input->post('tStaGrpPriorityIsPriceGroup');
        $tPbyMaxValueLastRow = $this->input->post('tPbyMaxValueLastRow');
        $nLangEdit = $this->session->userdata("tLangEdit");
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserSessionDate = $this->session->userdata("tSesSessionDate");
        $tUserLoginCode = $this->session->userdata("tSesUsername");
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tBchCodeLogin = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCodeDefault");
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        $bIsAlwPmtDisAvg = json_decode($this->input->post('bIsAlwPmtDisAvg'));

        $this->db->trans_begin();

        $aPmtCBWithPmtCGToTempParams = [
            'tDocNo' => 'PMTDOCTEMP',
            'tGroupName' => $tGroupName,
            'tPbyStaBuyCond' => $tPbyStaBuyCond, // เงื่อนไขการซื้อ 
            'bStaGrpPriorityIsPriceGroup' => json_decode($tStaGrpPriorityIsPriceGroup),
            'tPbyMaxValueLastRow' => $tPbyMaxValueLastRow,
            'tBchCodeLogin' => $tBchCodeLogin,
            'tUserSessionID' => $tUserSessionID,
            'tUserSessionDate' => $tUserSessionDate,
            'tUserLoginCode' => $tUserLoginCode,
            'nLngID' => $nLangEdit,
            'nOptDecimalShow' => $nOptDecimalShow,
            'bIsAlwPmtDisAvg' => $bIsAlwPmtDisAvg
        ];
        $this->mPromotionStep3PmtCB->FSaMPmtCBWithPmtCGPmtCBToTemp($aPmtCBWithPmtCGToTempParams);
        $this->mPromotionStep3PmtCB->FSaMPmtCBWithPmtCGPmtCGToTemp($aPmtCBWithPmtCGToTempParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent' => '900',
                'tStaMessg' => "Unsucess InsertPmtCBAndPmtCGToTmp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent' => '1',
                'tStaMessg' => 'Success InsertPmtCBAndPmtCGToTmp'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Delete PmtCB and PmtCG in Temp by Seq
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaCPromotionDeletePmtCBAndPmtCGInTmpBySeq()
    {
        $tCbSeqNo = $this->input->post('tCbSeqNo');
        $tCgSeqNo = $this->input->post('tCgSeqNo');
        $tPbyStaBuyCond = $this->input->post('tPbyStaBuyCond');
        $nLangEdit = $this->session->userdata("tLangEdit");
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLoginCode = $this->session->userdata("tSesUsername");
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tBchCodeLogin = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCodeDefault");

        $this->db->trans_begin();

        $aDeletePmtCBInTmpByGroupNameParams = [
            'tUserSessionID' => $tUserSessionID,
            'tCbSeqNo' => $tCbSeqNo,
            'tCgSeqNo' => $tCgSeqNo
        ];
        $this->mPromotionStep3PmtCB->FSbDeletePmtCBAndCGInTmpBySeq($aDeletePmtCBInTmpByGroupNameParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent' => '900',
                'tStaMessg' => "Unsucess DeletePmtCBAndCGInTmp By Seq"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent' => '1',
                'tStaMessg' => 'Success DeletePmtCBAndCGInTmp By Seq'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Get PmtCB With PmtCG in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSxCPromotionGetPmtCBWithPmtCGInTmp()
    {
        $tPbyStaBuyCond = $this->input->post('tPbyStaBuyCond');
        $tSearchAll = $this->input->post('tSearchAll');
        $nPage = $this->input->post('nPageCurrent');
        $aAlwEvent = FCNaHCheckAlwFunc('promotion/0/0');
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tBchCodeLogin = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCodeDefault");
        $bIsAlwPmtDisAvg = json_decode($this->input->post('bIsAlwPmtDisAvg'));

        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nPageCurrent');
        }
        $nLangEdit = $this->session->userdata("tLangEdit");

        $aGetPmtCBInTmpParams  = array(
            'FNLngID' => $nLangEdit,
            'nPage' => $nPage,
            'nRow' => 50,
            'tSearchAll' => $tSearchAll,
            'tUserSessionID' => $tUserSessionID
        );
        $aResList = $this->mPromotionStep3PmtCB->FSaMGetPmtCBWithPmtCGInTmp($aGetPmtCBInTmpParams);

        $aGenTable = array(
            'tPbyStaBuyCond' => $tPbyStaBuyCond,
            'aAlwEvent' => $aAlwEvent,
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'nOptDecimalShow' => $nOptDecimalShow,
            'bIsAlwPmtDisAvg' => $bIsAlwPmtDisAvg
        );
        $tHtml = $this->load->view('document/promotion/advance_table/wStep3PmtCBWithPmtCGTableTmp', $aGenTable, true);
        
        $aResponse = [
            'html' => $tHtml
        ];

        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aResponse));
    }

    /**
     * Functionality : Get PmtCB With PmtCG PgtPerAvgDis in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FStCPromotionGetPmtCBAndPmtCGPgtPerAvgDisInTmp()
    {
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tBchCodeLogin = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCodeDefault");

        $aGetPmtCBAndPmtCGPgtPerAvgDisInTmpParams  = array(
            'nSeqNo' => "''",
            'tUserSessionID' => $tUserSessionID
        );
        $cPgtPerAvgDis = $this->mPromotionStep3PmtCB->FScMGetPmtCBAndPmtCGPgtPerAvgDisInTmp($aGetPmtCBAndPmtCGPgtPerAvgDisInTmpParams);
        
        $aResponse = [
            'cPgtPerAvgDis' => $cPgtPerAvgDis
        ];

        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aResponse));
    }

    /**
     * Functionality : Update PmtCG(FCPgtPerAvgDis) and PmtCB(FCPbyPerAvgDis) in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCPromotionUpdatePmtCGAndPmtCBPerAvgDisInTmp()
    {
        $tCBPerAvgDis = $this->input->post('tCBPerAvgDis');
        $tCGPerAvgDis = $this->input->post('tCGPerAvgDis');
        $tBchCode = $this->input->post('tBchCode');
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLoginCode = $this->session->userdata("tSesUsername");

        $UpdateCGAndCBPerAvgDisInTmp = [
            'tCBPerAvgDis' => $tCBPerAvgDis,
            'tCGPerAvgDis' => $tCGPerAvgDis,
            'tUserLoginCode' => $tUserLoginCode,
            'tUserSessionID' => $tUserSessionID
        ];
        $this->mPromotionStep3PmtCB->FSbUpdateCGAndCBPerAvgDisInTmp($UpdateCGAndCBPerAvgDisInTmp);
    }
}