<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cPromotionStep3Point extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('document/promotion/mPromotionStep3Point');
        $this->load->model('document/promotion/mPromotion');
    }

    /**
     * Functionality : Get Point to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Point Detail
     * Return Type : String
     */
    public function FStCPromotionGetPointInTmp()
    {
        $nLangEdit = $this->session->userdata("tLangEdit");
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLoginCode = $this->session->userdata("tSesUsername");
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tBchCodeLogin = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCodeDefault");

        $aGetPointInTmpParams = [
            'tUserSessionID' => $tUserSessionID
        ];
        $aPointInTmp = $this->mPromotionStep3Point->FSaMGetPointInTmp($aGetPointInTmpParams);
        
        $this->output->set_content_type('application/json')->set_output(json_encode($aPointInTmp));
    }

    /**
     * Functionality : Insert Point to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaCPromotionInsertOrUpdatePointToTmp()
    {
        $tPgtPntBuy = $this->input->post('tPgtPntBuy');
        $tPgtPntGet = $this->input->post('tPgtPntGet');
        $tPgtStaPoint = $this->input->post('tPgtStaPoint');
        $tPgtStaPntCalType = $this->input->post('tPgtStaPntCalType');
        $nLangEdit = $this->session->userdata("tLangEdit");
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserSessionDate = $this->session->userdata("tSesSessionDate");
        $tUserLoginCode = $this->session->userdata("tSesUsername");
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tPgtSplCode = $this->input->post('tPgtSplCode');
        $tPgtDateStart = $this->input->post('tPgtDateStart');
        $tPgtDateEnd = $this->input->post('tPgtDateEnd');
        $tBchCodeLogin = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCodeDefault");

        $this->db->trans_begin();

        $aAddUpdatePointInTempParams = [
            'tUserSessionID' => $tUserSessionID,
            'tUserSessionDate' => $tUserSessionDate,
            'tPgtPntBuy' => empty($tPgtPntBuy)?NULL:$tPgtPntBuy,
            'tPgtPntGet' => empty($tPgtPntGet)?NULL:$tPgtPntGet,
            'tPgtSplCode' => empty($tPgtSplCode)?NULL:$tPgtSplCode,
            'tPgtDateStart' => empty($tPgtDateStart)?NULL:$tPgtDateStart,
            'tPgtDateEnd' => empty($tPgtDateEnd)?NULL:$tPgtDateEnd,
            'tPgtStaPoint' => $tPgtStaPoint,
            'tPgtStaPntCalType' => $tPgtStaPntCalType,
            'tBchCodeLogin' => $tBchCodeLogin,
            'tDocNo' => 'PMTDOCTEMP'
        ];

        $this->mPromotionStep3Point->FSaMAddUpdatePointInTemp($aAddUpdatePointInTempParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess InsertOrUpdatePointToTmp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg' => 'Success InsertOrUpdatePointToTmp'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Delete Point in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCPromotionDeletePointInTmp()
    {
        $tUserSessionID = $this->session->userdata("tSesSessionID");

        $this->db->trans_begin();

        $aDeletePointInTmpParams = [
            'tUserSessionID' => $tUserSessionID,
            'tDocNo' => 'PMTDOCTEMP',
        ];
        $this->mPromotionStep3Point->FSbDeletePointInTmp($aDeletePointInTmpParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess DeletePointInTmp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg' => 'Success DeletePointInTmp'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }
}