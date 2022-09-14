<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cPromotionStep3Coupon extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('document/promotion/mPromotionStep3Coupon');
        $this->load->model('document/promotion/mPromotion');
    }

    /**
     * Functionality : Get Coupon to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Coupon Detail
     * Return Type : String
     */
    public function FStCPromotionGetCouponInTmp()
    {
        $nLangEdit = $this->session->userdata("tLangEdit");
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLoginCode = $this->session->userdata("tSesUsername");
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tBchCodeLogin = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCodeDefault");

        $aGetCouponInTmpParams = [
            'tUserSessionID' => $tUserSessionID
        ];
        $aCouponInTmp = $this->mPromotionStep3Coupon->FSaMGetCouponInTmp($aGetCouponInTmpParams);

        $this->output->set_content_type('application/json')->set_output(json_encode($aCouponInTmp));
    }

    /**
     * Functionality : Insert Coupon to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaCPromotionInsertOrUpdateCouponToTmp()
    {
        $tCphDocNo = $this->input->post('tCphDocNo');
        $tCphDocName = $this->input->post('tCphDocName');
        $tPgtCpnText = $this->input->post('tPgtCpnText');
        $tPgtStaCoupon = $this->input->post('tPgtStaCoupon');
        $nLangEdit = $this->session->userdata("tLangEdit");
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserSessionDate = $this->session->userdata("tSesSessionDate");
        $tUserLoginCode = $this->session->userdata("tSesUsername");
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tBchCodeLogin = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCodeDefault");

        $this->db->trans_begin();

        $aAddUpdateCouponInTempParams = [
            'tUserSessionID' => $tUserSessionID,
            'tUserSessionDate' => $tUserSessionDate,
            'tCphDocNo' => $tCphDocNo,
            'tCphDocName' => $tCphDocName,
            'tPgtCpnText' => $tPgtCpnText,
            'tPgtStaCoupon' => $tPgtStaCoupon,
            'tBchCodeLogin' => $tBchCodeLogin,
            'tDocNo' => 'PMTDOCTEMP'
        ];
        $this->mPromotionStep3Coupon->FSaMAddUpdateCouponInTemp($aAddUpdateCouponInTempParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess InsertOrUpdateCouponToTmp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg' => 'Success InsertOrUpdateCouponToTmp'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Update Coupon in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    /* public function FSxCPromotionUpdateCouponInTmp()
    {
        $tPgtStaGetType = $this->input->post('tPgtStaGetType');
        $tPgtGetvalue = $this->input->post('tPgtGetvalue');
        $nSeqNo = $this->input->post('nSeqNo');
        $tBchCode = $this->input->post('tBchCode');
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLoginCode = $this->session->userdata("tSesUsername");
        
        $aUpdateCouponInTmpBySeqParams = [
            'tPgtStaGetType' => $tPgtStaGetType,
            'tPgtGetvalue' => $tPgtGetvalue,
            'tUserLoginCode' => $tUserLoginCode,
            'tUserSessionID' => $tUserSessionID,
            'nSeqNo' => $nSeqNo,
        ];
        var_dump($aUpdateCouponInTmpBySeqParams);
        $this->mPromotionStep3Coupon->FSbUpdateCouponInTmp($aUpdateCouponInTmpBySeqParams);
    } */

    /**
     * Functionality : Delete Coupon in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCPromotionDeleteCouponInTmp()
    {
        $tUserSessionID = $this->session->userdata("tSesSessionID");

        $this->db->trans_begin();

        $aDeleteCouponInTmpParams = [
            'tUserSessionID' => $tUserSessionID,
            'tDocNo' => 'PMTDOCTEMP',
        ];
        $this->mPromotionStep3Coupon->FSbDeleteCouponInTmp($aDeleteCouponInTmpParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess DeleteCouponInTmp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg' => 'Success DeleteCouponInTmp'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }
}