<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mPromotionStep3Coupon extends CI_Model
{
    /**
     * Functionality : Get Coupon in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Data List Coupon
     * Return Type : Array
     */
    public function FSaMGetCouponInTmp($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];

        $tSQL = "
            SELECT
                TMP.FTBchCode,
                TMP.FTPmhDocNo,
                TMP.FNPgtSeq,
                TMP.FTPmdGrpName,
                TMP.FTPgtStaGetEffect,
                TMP.FTPgtStaGetType,
                TMP.FTPgtStaGetPdt,
                TMP.FTRolCode,
                TMP.FCPgtGetvalue,
                TMP.FTPplCode,
                TMP.FCPgtGetQty,
                TMP.FCPgtPerAvgDis,
                TMP.FTPgtStaPoint,
                TMP.FTPgtStaPntCalType,
                TMP.FTPgtStaPdtDT,
                TMP.FNPgtPntGet,
                TMP.FNPgtPntBuy,
                TMP.FTPgtStaCoupon,
                TMP.FTPgtCpnText,
                TMP.FTCphDocNo,
                TMP.FTCphDocName,
                TMP.FTSessionID
            FROM TCNTPdtPmtCG_Tmp TMP WITH(NOLOCK)
            WHERE TMP.FTSessionID = '$tUserSessionID'
            AND (TMP.FTPgtStaCoupon IS NOT NULL OR TMP.FTPgtStaCoupon <> '')
            AND (TMP.FTPmdGrpName IS NULL OR TMP.FTPmdGrpName = '')
            AND TMP.FNPgtSeq = -1
        ";

        $oQuery = $this->db->query($tSQL);

        return $oQuery->row_array();
    }

    /**
     * Functionality : Insert or Update Coupon to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMAddUpdateCouponInTemp($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];
        $tUserSessionDate = $paParams['tUserSessionDate'];
        $tBchCodeLogin = $paParams['tBchCodeLogin'];

        // Update Coupon
        $this->db->set('FTBchCode', $tBchCodeLogin);
        $this->db->set('FTPgtStaCoupon', $paParams['tPgtStaCoupon']);

        if($paParams['tPgtStaCoupon'] == "3"){ // การให้สิทธิ์ 1:ไม่กำหนด 2:.ให้สิทธิ์คูปอง 3:ข้อความ
            $this->db->set('FTPgtCpnText', $paParams['tPgtCpnText']);
            $this->db->set('FTCphDocNo', '');
            $this->db->set('FTCphDocName', '');
        }else{
            $this->db->set('FTCphDocNo', $paParams['tCphDocNo']);
            $this->db->set('FTCphDocName', $paParams['tCphDocName']);
            $this->db->set('FTPgtCpnText', '');
        }

        $this->db->where('FTSessionID', $tUserSessionID);
        $this->db->where('FTPmhDocNo', $paParams['tDocNo']);
        $this->db->where("(FTPmdGrpName IS NULL OR FTPmdGrpName = '')");
        $this->db->where("FTPgtStaCoupon IS NOT NULL");
        $this->db->where("FTPgtStaCoupon <> ''");
        $this->db->where("FNPgtSeq = -1");
        $this->db->update('TCNTPdtPmtCG_Tmp');
        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update Coupon Success',
            );
        } else {
            // Add Coupon
            $this->db->set('FTBchCode', $tBchCodeLogin);
            $this->db->set('FTPmhDocNo', $paParams['tDocNo']);
            $this->db->set('FNPgtSeq', -1);
            $this->db->set('FTPgtStaCoupon', $paParams['tPgtStaCoupon']);
            $this->db->set('FTPgtStaGetType', '6');

            if($paParams['tPgtStaCoupon'] == "3"){ // การให้สิทธิ์ 1:ไม่กำหนด 2:.ให้สิทธิ์คูปอง 3:ข้อความ
                $this->db->set('FTPgtCpnText', $paParams['tPgtCpnText']);
                $this->db->set('FTCphDocNo', '');
                $this->db->set('FTCphDocName', '');
            }else{
                $this->db->set('FTCphDocNo', $paParams['tCphDocNo']);
                $this->db->set('FTCphDocName', $paParams['tCphDocName']);
                $this->db->set('FTPgtCpnText', '');
            }

            $this->db->set('FDCreateOn', $tUserSessionDate);
            $this->db->set('FTSessionID', $tUserSessionID);
            $this->db->insert('TCNTPdtPmtCG_Tmp');
            
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Coupon Success',
                );
            } else {
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit Coupon.',
                );
            }
        }
        return $aStatus;
    }

    /**
     * Functionality : Update Coupon Value in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Update
     * Return Type : Boolean
     */
    /* public function FSbUpdateCouponInTmp($paParams = [])
    {
        $this->db->set('FTPmdGrpName', $paParams['tPmtGroupNameTmp']);
        $this->db->where('FTPmdGrpName', $paParams['tPmtGroupNameTmpOld']);
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->update('TCNTPdtCoupon_Tmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    } */

    /**
     * Functionality : Delete Coupon in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Delete
     * Return Type : Boolean
     */
    public function FSbDeleteCouponInTmp($paParams = [])
    {
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where('FTPmhDocNo', $paParams['tDocNo']);
        $this->db->where("(FTPmdGrpName IS NULL OR FTPmdGrpName = '')");
        $this->db->where("FTPgtStaCoupon IS NOT NULL");
        $this->db->where("FTPgtStaCoupon <> ''");
        $this->db->where("FNPgtSeq = -1");
        $this->db->delete('TCNTPdtPmtCG_Tmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }
}
