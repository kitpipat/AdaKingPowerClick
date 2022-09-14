<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cPromotionStep3PmtCG extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('document/promotion/mPromotionStep3PmtCG');
        $this->load->model('document/promotion/mPromotionStep3PmtCB');
        $this->load->model('document/promotion/mPromotion');
    }

    /**
     * Functionality : Get PmtCG in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSxCPromotionGetPmtCGInTmp()
    {
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

        $aGetPmtCGInTmpParams  = array(
            'FNLngID' => $nLangEdit,
            'nPage' => $nPage,
            'nRow' => 50,
            'tSearchAll' => $tSearchAll,
            'tUserSessionID' => $tUserSessionID
        );
        $aResList = $this->mPromotionStep3PmtCG->FSaMGetPmtCGInTmp($aGetPmtCGInTmpParams);

        $aGenTable = array(
            'aAlwEvent' => $aAlwEvent,
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'nOptDecimalShow' => $nOptDecimalShow,
            'bIsAlwPmtDisAvg' => $bIsAlwPmtDisAvg,
            'tStaBuyCond' => $this->input->post('tStaBuyCond')
        );
        $tHtml = $this->load->view('document/promotion/advance_table/wStep3PmtCGTableTmp', $aGenTable, true);
        
        $aResponse = [
            'html' => $tHtml
        ];

        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aResponse));
    }

    /**
     * Functionality : Insert PmtCG to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaCPromotionInsertPmtCGToTmp()
    {
        $tConditionBuyIsRange = $this->input->post('tConditionBuyIsRange');
        $tStaGrpPriorityIsPriceGroup = $this->input->post('tStaGrpPriorityIsPriceGroup');
        // $tStaSpcGrpDisIsDisSomeGroup = $this->input->post('tStaSpcGrpDisIsDisSomeGroup');
        $tGroupNameInGet = $this->input->post('tGroupNameInGet');
        $tPbyStaBuyCond = $this->input->post('tPbyStaBuyCond');
        $nLangEdit = $this->session->userdata("tLangEdit");
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserSessionDate = $this->session->userdata("tSesSessionDate");
        $tUserLoginCode = $this->session->userdata("tSesUsername");
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tBchCodeLogin = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCodeDefault");
        $bIsAlwPmtDisAvg = json_decode($this->input->post('bIsAlwPmtDisAvg'));

        $this->db->trans_begin();

        $aDeletePmtCGInTmpByGroupNameParams = [
            'tUserSessionID' => $tUserSessionID,
            'tGroupNameInGet' => $tGroupNameInGet,
        ];
        $this->mPromotionStep3PmtCG->FSbDeletePmtCGInTmpByGroupName($aDeletePmtCGInTmpByGroupNameParams);

        $aPmtCGToTempParams = [
            'tDocNo' => 'PMTDOCTEMP',
            'tGroupNameInGet' => $tGroupNameInGet,
            'tPbyStaBuyCond' => $tPbyStaBuyCond, // เงื่อนไขการซื้อ
            'tBchCodeLogin' => $tBchCodeLogin,
            'tUserSessionID' => $tUserSessionID,
            'tUserSessionDate' => $tUserSessionDate,
            'tUserLoginCode' => $tUserLoginCode,
            'nLngID' => $nLangEdit,
            'bConditionBuyIsRange' => json_decode($tConditionBuyIsRange),
            'bStaGrpPriorityIsPriceGroup' => json_decode($tStaGrpPriorityIsPriceGroup),
            'bIsAlwPmtDisAvg' => $bIsAlwPmtDisAvg
            // 'bStaSpcGrpDisIsDisSomeGroup' => json_decode($tStaSpcGrpDisIsDisSomeGroup)
        ];
        $this->mPromotionStep3PmtCG->FSaMPmtCGToTemp($aPmtCGToTempParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent' => '900',
                'tStaMessg' => "Unsucess InsertPmtCGToTmp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent' => '1',
                'tStaMessg' => 'Success InsertPmtCGToTmp'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Update PmtCG in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCPromotionUpdatePmtCGInTmp()
    {
        $tStaBuyIsRange = $this->input->post('tStaBuyIsRange'); // 1:is range
        $tPgtStaGetType = $this->input->post('tPgtStaGetType'); // 1:ลดบาท 2:ลด% 3:ปรับราคา 4:.ใช้กลุ่มราคา 5:แถม(Free) 6:ไม่กำหนด
        $tPgtGetvalue = ($tPgtStaGetType == "4")?"0": (empty($this->input->post('tPgtGetvalue'))?"0":$this->input->post('tPgtGetvalue'));
        $tPgtPerAvgDisCG = $this->input->post('tPgtPerAvgDisCG');
        $tPgtGetQty = $this->input->post('tPgtGetQty');

        if( ($tPgtGetQty == "" || $tPgtGetQty == "0") && $tPgtStaGetType == "5"){ // เป็นของแถม Default 1
            $tPgtGetQty = 1;
        }

        if($tPgtGetQty == "" && $tPgtStaGetType != "5"){ // ไม่ใช่ของแถม Default 0
            $tPgtGetQty = 0;
        }

        $tPriceGroupCode = ($tPgtStaGetType == "4")?$this->input->post('tPriceGroupCode'):"";
        $tPriceGroupName = ($tPgtStaGetType == "4")?$this->input->post('tPriceGroupName'):"";
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
            // $cPgtPerAvgDis = $this->mPromotionStep3PmtCB->FScMGetPmtCBAndPmtCGPgtPerAvgDisInTmp($aGetPmtCBAndPmtCGPgtPerAvgDisInTmpParams);
        }else{
            $cPgtPerAvgDis = $this->mPromotionStep3PmtCG->FScMGetPmtCBAndPmtCGPgtPerAvgDisOnCGInTmp($aGetPmtCBAndPmtCGPgtPerAvgDisInTmpParams);
            $cPgtPerAvgDisBal = 100.00 - $cPgtPerAvgDis;
        
            if($tPgtPerAvgDisCG > $cPgtPerAvgDisBal) {
                $tPgtPerAvgDisCG = $cPgtPerAvgDisBal;
            }

            if($cPgtPerAvgDisBal <= 0.00){
                $tPgtPerAvgDisCG = 0.00;
            }
        }

        $aUpdatePmtCGInTmpBySeqParams = [
            'tPgtStaGetType' => $tPgtStaGetType,
            'tPgtGetvalue' => str_replace(",", "", $tPgtGetvalue),
            'tPgtPerAvgDisCG' => str_replace(",", "", $tPgtPerAvgDisCG),
            'tPgtGetQty' => str_replace(",", "", $tPgtGetQty),
            'tPriceGroupCode' => $tPriceGroupCode,
            'tPriceGroupName' => $tPriceGroupName,
            'tUserLoginCode' => $tUserLoginCode,
            'tUserSessionID' => $tUserSessionID,
            'nSeqNo' => $nSeqNo,
            'tFieldName' => $tFieldName,
            'tFormatType' => $tFormatType,
            'nOptDecimalShow' => $nOptDecimalShow
        ];
        $aUpdateRes = $this->mPromotionStep3PmtCG->FSbUpdatePmtCGInTmpBySeq($aUpdatePmtCGInTmpBySeqParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent' => '900',
                'tStaMessg' => "Unsucess UpdatePmtCGInTmp",
                'tValue' => $aUpdateRes
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent' => '1',
                'tStaMessg' => 'Success UpdatePmtCGInTmp',
                'tPgtStaGetType' => $tPgtStaGetType,
                'tPgtGetQty' => $tPgtGetQty,
                'tValue' => $aUpdateRes
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Update PmtCG PgtStaGetType in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCPromotionUpdatePmtCGPgtStaGetTypeInTmp(){
        $tPgtStaGetType = $this->input->post('tPgtStaGetType'); // 1:ลดบาท 2:ลด% 3:ปรับราคา 4:.ใช้กลุ่มราคา 5:แถม(Free) 6:ไม่กำหนด
        $tBchCode = $this->input->post('tBchCode');
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLoginCode = $this->session->userdata("tSesUsername");

        $aUpdatePmtCGInTmpBySeqParams = [
            'tPgtStaGetType' => $tPgtStaGetType,
            'tUserLoginCode' => $tUserLoginCode,
            'tUserSessionID' => $tUserSessionID
        ];
        $this->mPromotionStep3PmtCG->FSbUpdatePmtCGPgtStaGetTypeInTmp($aUpdatePmtCGInTmpBySeqParams);
    }

    /**
     * Functionality : Delete PmtCG in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaCPromotionDeletePmtCGInTmp()
    {
        $tGroupNameInGet = $this->input->post('tGroupNameInGet');
        $tPbyStaBuyCond = $this->input->post('tPbyStaBuyCond');
        $nLangEdit = $this->session->userdata("tLangEdit");
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLoginCode = $this->session->userdata("tSesUsername");
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tBchCodeLogin = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCodeDefault");

        $this->db->trans_begin();

        $aDeletePmtCGInTmpByGroupNameParams = [
            'tUserSessionID' => $tUserSessionID,
            'tGroupNameInGet' => $tGroupNameInGet
        ];
        $this->mPromotionStep3PmtCG->FSbDeletePmtCGInTmpByGroupName($aDeletePmtCGInTmpByGroupNameParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent' => '900',
                'tStaMessg' => "Unsucess DeletePmtCGInTmp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent' => '1',
                'tStaMessg' => 'Success DeletePmtCGInTmp'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Clear PmtCG in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCPromotionClearPmtCGInTmp()
    {
        $tSeqNo = $this->input->post('tSeqNo');
        $tUserSessionID = $this->session->userdata("tSesSessionID");

        $this->db->trans_begin();

        $aClearPmtCGInTmpParams = [
            'tUserSessionID' => $tUserSessionID
        ];
        $this->mPromotionStep3PmtCG->FSbClearPmtCGInTmp($aClearPmtCGInTmpParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent' => '900',
                'tStaMessg' => "Unsucess ClearPmtCGInTmp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent' => '1',
                'tStaMessg' => 'Success ClearPmtCGInTmp'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }
}