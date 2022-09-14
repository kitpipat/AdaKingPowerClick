<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cPromotionStep4BchCondition extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('document/promotion/mPromotionStep4BchCondition');
        $this->load->model('document/promotion/mPromotion');
    }

    /**
     * Functionality : Get PdtPmtHDBch in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSxCPromotionGetBchConditionInTmp()
    {
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

        $aGetPdtPmtHDBchInTmpParams  = array(
            'FNLngID' => $nLangEdit,
            'nPage' => $nPage,
            'nRow' => 50,
            'tSearchAll' => $tSearchAll,
            'tUserSessionID' => $tUserSessionID
        );
        $aResList = $this->mPromotionStep4BchCondition->FSaMGetPdtPmtHDBchInTmp($aGetPdtPmtHDBchInTmpParams);

        $aGenTable = array(
            'aAlwEvent' => $aAlwEvent,
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'nOptDecimalShow' => $nOptDecimalShow,
            'tUserLevel' => $tUserLevel,
            'bIsShpEnabled' => FCNbGetIsShpEnabled()
        );
        $tHtml = $this->load->view('document/promotion/advance_table/wStep4BchConditionTableTmp', $aGenTable, true);
        
        $aResponse = [
            'html' => $tHtml
        ];

        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aResponse));
    }

    /**
     * Functionality : Insert PdtPmtHDBch to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaCPromotionInsertBchConditionToTmp()
    {
        $tAgnCode = $this->input->post('tAgnCode');
        $tAgnName = $this->input->post('tAgnName');
        $tBchCode = $this->input->post('tBchCode');
        $tBchName = $this->input->post('tBchName');
        $tMerCode = empty($this->input->post('tMerCode'))?"N/A":$this->input->post('tMerCode');
        $tMerName = $this->input->post('tMerName');
        $tShpCode = empty($this->input->post('tShpCode'))?"N/A":$this->input->post('tShpCode');
        $tShpName = $this->input->post('tShpName');
        $nLangEdit = $this->session->userdata("tLangEdit");
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserSessionDate = $this->session->userdata("tSesSessionDate");
        $tUserLoginCode = $this->session->userdata("tSesUsername");
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tBchCodeLogin = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCodeDefault");

        if(!FCNbUsrIsAgnLevel()){
            $tValibleChkValidate = $tBchCode;
        }else{
            $tValibleChkValidate = $tAgnCode;
        }

        if(!empty($tValibleChkValidate)){
            $this->db->trans_begin();
            
            $bHDBchIsDuplicate = false;
            $tHDBchIsDuplicateMsg = "";
            /*===== Begin Data Validate ================================================*/
            $aGetPdtPmtHDBchInTmpByBchParams = [
                'tBchCode' => $tBchCode,
                'tUserSessionID' => $tUserSessionID
            ];
            $aHDBch = $this->mPromotionStep4BchCondition->FSaMGetPdtPmtHDBchInTmpByBch($aGetPdtPmtHDBchInTmpByBchParams);
            if(!empty($aHDBch)){
                foreach($aHDBch as $nIndex => $aValue){
                    if($aValue['FTPmhAgnTo'] == $tAgnCode && $aValue['FTPmhBchTo'] == $tBchCode && $aValue['FTPmhMerTo'] == $tMerCode && $aValue['FTPmhShpTo'] == $tShpCode){
                        $bHDBchIsDuplicate = true;
                        $tHDBchIsDuplicateMsg = "AGN:$tAgnCode,BCH:$tBchCode,MER:$tMerCode,SHP:$tShpCode";
                        break;
                    }
                }
            }
       
            if($bHDBchIsDuplicate){
                $aReturn = array(
                    'nStaEvent' => '007',
                    'tStaMessg' => "Duplicate in Temp: " . $tHDBchIsDuplicateMsg
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
                return;    
            }
            /*===== End Data Validate ==================================================*/

            $aPdtPmtHDBchToTempParams = [
                'tDocNo' => 'PMTDOCTEMP',
                'tAgnCode' => $tAgnCode,
                'tAgnName' => $tAgnName,
                'tBchCode' => $tBchCode,
                'tBchName' => $tBchName,
                'tMerCode' => $tMerCode,
                'tMerName' => $tMerName,
                'tShpCode' => $tShpCode,
                'tShpName' => $tShpName,
                'tBchCodeLogin' => $tBchCodeLogin,
                'tUserSessionID' => $tUserSessionID,
                'tUserSessionDate' => $tUserSessionDate,
                'tUserLoginCode' => $tUserLoginCode,
                'nLngID' => $nLangEdit
            ];
            $this->mPromotionStep4BchCondition->FSaMPdtPmtHDBchToTemp($aPdtPmtHDBchToTempParams);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent' => '900',
                    'tStaMessg' => "Unsucess InsertBchConditionToTmp"
                );
            } else {
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success InsertBchConditionToTmp'
                );
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
        }else{
            $aReturn = array(
                'nStaEvent' => '900',
                'tStaMessg' => "Bch Code Empty"
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
        }
        
    }

    /**
     * Functionality : Update PdtPmtHDBch in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCPromotionUpdateBchConditionInTmp()
    {
        $tDocNo = $this->input->post('tDocNo');
        $tBchCodeTo = $this->input->post('tBchCodeTo');
        $tMerCodeTo = $this->input->post('tMerCodeTo');
        $tShpCodeTo = $this->input->post('tShpCodeTo');
        $tBchCode = $this->input->post('tBchCode');
        $tPmhStaType = $this->input->post('tPmhStaType');
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLoginCode = $this->session->userdata("tSesUsername");
        
        $this->db->trans_begin();

        $aUpdatePdtPmtHDBchInTmpParams = [
            'tDocNo' => $tDocNo,
            'tBchCodeTo' => $tBchCodeTo,
            'tMerCodeTo' => $tMerCodeTo,
            'tShpCodeTo' => $tShpCodeTo,
            'tBchCode' => $tBchCode,
            'tPmhStaType' => $tPmhStaType,
            'tUserLoginCode' => $tUserLoginCode,
            'tUserSessionID' => $tUserSessionID
        ];
        $this->mPromotionStep4BchCondition->FSbUpdatePdtPmtHDBchInTmpByKey($aUpdatePdtPmtHDBchInTmpParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent' => '900',
                'tStaMessg' => "Unsucess UpdateBchConditionInTmp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent' => '1',
                'tStaMessg' => 'Success UpdateBchConditionInTmp'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Delete PdtPmtHDBch by Primary Key in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCPromotionDeleteBchConditionInTmp()
    {
        $tBchCode = $this->input->post('tBchCode');
        $tDocNo = $this->input->post('tDocNo');
        $tBchCodeTo = $this->input->post('tBchCodeTo');
        $tMerCodeTo = $this->input->post('tMerCodeTo');
        $tShpCodeTo = $this->input->post('tShpCodeTo');
        $tUserSessionID = $this->session->userdata("tSesSessionID");

        $this->db->trans_begin();

        $aDeleteInTmpByKeyParams = [
            'tUserSessionID' => $tUserSessionID,
            'tBchCode' => $tBchCode,
            'tDocNo' => $tDocNo,
            'tBchCodeTo' => $tBchCodeTo,
            'tMerCodeTo' => $tMerCodeTo,
            'tShpCodeTo' => $tShpCodeTo
        ];
        $this->mPromotionStep4BchCondition->FSbDeletePdtPmtHDBchInTmpByKey($aDeleteInTmpByKeyParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent' => '900',
                'tStaMessg' => "Unsucess DeleteBchConditionInTmp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent' => '1',
                'tStaMessg' => 'Success DeleteBchConditionInTmp'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }
}