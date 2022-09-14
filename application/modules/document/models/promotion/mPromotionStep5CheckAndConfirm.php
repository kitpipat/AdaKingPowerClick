<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mPromotionStep5CheckAndConfirm extends CI_Model
{
    /**
     * Functionality : Get PmtCB in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Data List PmtCB
     * Return Type : Array
     */
    public function FSaMGetPmtCBInTmp($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];

        $tSQL = "
            SELECT
                TMP.FTBchCode,
                TMP.FTPmhDocNo,
                TMP.FNPbySeq,
                TMP.FTPmdGrpName,
                TMP.FTPbyStaCalSum,
                TMP.FTPbyStaBuyCond,
                TMP.FTPbyStaPdtDT,
                TMP.FCPbyPerAvgDis,
                TMP.FCPbyMinSetPri,
                TMP.FCPbyMinValue,
                TMP.FCPbyMaxValue,
                TMP.FTPbyMinTime,
                TMP.FTPbyMaxTime,
                TMP.FTSessionID
            FROM TCNTPdtPmtCB_Tmp TMP WITH(NOLOCK)
            WHERE TMP.FTSessionID = '$tUserSessionID'
            ORDER BY TMP.FTPmdGrpName ASC, TMP.FNPbySeq ASC
        ";

        $oQuery = $this->db->query($tSQL);

        return $oQuery->result_array();
    }

    /**
     * Functionality : Get PmtCG in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Data List PmtCG
     * Return Type : Array
     */
    public function FSaMGetPmtCGInTmp($paParams = [])
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
                TMP.FTPplName,
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
                TMP.FTSessionID
            FROM TCNTPdtPmtCG_Tmp TMP WITH(NOLOCK)
            WHERE TMP.FTSessionID = '$tUserSessionID'
            AND (TMP.FTPmdGrpName IS NOT NULL OR TMP.FTPmdGrpName <> '')
            ORDER BY TMP.FTPmdGrpName ASC, TMP.FNPgtSeq ASC
        ";

        $oQuery = $this->db->query($tSQL);

        return $oQuery->result_array();
    }

    /**
     * Functionality : Get PmtDT Except in Temp
     * Parameters : -
     * Creator : 09/12/2020 piya
     * Last Modified : -
     * Return : Data List PmtDT Except
     * Return Type : Array
     */
    public function FSaMGetPmtDTExceptInTmp($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];

        $tSQL = "
            SELECT DISTINCT
                TMP.FTPmdGrpName
            FROM TCNTPdtPmtDT_Tmp TMP WITH(NOLOCK)
            WHERE TMP.FTSessionID = '$tUserSessionID'
            AND (TMP.FTPmdGrpName IS NOT NULL OR TMP.FTPmdGrpName <> '')
            AND TMP.FTPmdStaType = '2'
            ORDER BY TMP.FTPmdGrpName ASC
        ";

        $oQuery = $this->db->query($tSQL);

        return $oQuery->result_array();
    }

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
            SELECT TOP 1
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
            AND TMP.FNPgtSeq = -1
            AND (TMP.FTPgtStaCoupon IS NOT NULL OR TMP.FTPgtStaCoupon <> '')
            AND (TMP.FTPmdGrpName IS NULL OR TMP.FTPmdGrpName = '')
        ";

        $oQuery = $this->db->query($tSQL);

        return $oQuery->result_array();
    }

    /**
     * Functionality : Get Point in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Data List Point
     * Return Type : Array
     */
    public function FSaMGetPointInTmp($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];

        $tSQL = "
            SELECT TOP 1
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
                TMP.FTSessionID
            FROM TCNTPdtPmtCG_Tmp TMP WITH(NOLOCK)
            WHERE TMP.FTSessionID = '$tUserSessionID'
            AND TMP.FNPgtSeq = -2
            AND (TMP.FTPgtStaPoint IS NOT NULL OR TMP.FTPgtStaPoint <> '')
            AND (TMP.FTPmdGrpName IS NULL OR TMP.FTPmdGrpName = '')
        ";

        $oQuery = $this->db->query($tSQL);

        return $oQuery->result_array();
    }

    /**
     * Functionality : Update PmtCB StaCalSum Value in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Update
     * Return Type : Boolean
     */
    public function FSbMUpdatePmtCBStaCalSumInTmp($paParams = [])
    {
        $this->db->set('FTPbyStaCalSum', $paParams['tPbyStaCalSum']);
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->update('TCNTPdtPmtCB_Tmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Update PmtCB StaCalSum Value in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Update
     * Return Type : Boolean
     */
    public function FSbMUpdatePmtCGStaGetEffectInTmp($paParams = [])
    {
        $this->db->set('FTPgtStaGetEffect', $paParams['tPgtStaGetEffect']);
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where("(FTPmdGrpName IS NOT NULL OR FTPmdGrpName <> '')");
        $this->db->update('TCNTPdtPmtCG_Tmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Get PdtPmtHDCstPri in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Data List PdtPmtHDCstPri
     * Return Type : Array
     */
    public function FSaMGetPdtPmtHDCstPriInTmp($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];

        $tSQL = "
            SELECT
                TMP.FTBchCode,
                TMP.FTPmhDocNo,
                TMP.FTPplCode,
                TMP.FTPplName,
                TMP.FTPmhStaType,
                TMP.FTSessionID
            FROM TCNTPdtPmtHDCstPri_Tmp TMP WITH(NOLOCK)
            WHERE TMP.FTSessionID = '$tUserSessionID'
            ORDER BY TMP.FTPmhStaType ASC, TMP.FTPplName ASC
        ";

        $oQuery = $this->db->query($tSQL);

        return $oQuery->result_array();
    }

    /**
     * Functionality : Get PdtPmtHDBch in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Data List PdtPmtHDBch
     * Return Type : Array
     */
    public function FSaMGetPdtPmtHDBchInTmp($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];

        $tSQL = "
            SELECT
                TMP.FTBchCode,
                TMP.FTPmhDocNo,
                TMP.FTPmhAgnTo,
                TMP.FTPmhBchTo,
                TMP.FTPmhMerTo,
                TMP.FTPmhShpTo,
                TMP.FTPmhAgnToName,
                TMP.FTPmhBchToName,
                TMP.FTPmhMerToName,
                TMP.FTPmhShpToName,
                TMP.FTPmhStaType,
                TMP.FTSessionID
            FROM TCNTPdtPmtHDBch_Tmp TMP WITH(NOLOCK)
            WHERE TMP.FTSessionID = '$tUserSessionID'
            ORDER BY TMP.FTPmhStaType ASC, TMP.FTPmhBchToName ASC
        ";

        $oQuery = $this->db->query($tSQL);

        return $oQuery->result_array();
    }

    /**
     * Functionality : Get PdtPmtHDChn in Temp
     * Parameters : -
     * Creator : 04/01/2021 Worakorn
     * Last Modified : -
     * Return : Data List PdtPmtHDChn
     * Return Type : Array
     */
    public function FSaMGetPdtPmtHDChnInTmp($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];

        $tSQL = "
            SELECT
                TMP.FTBchCode,
                TMP.FTPmhDocNo,
                TMP.FTChnCode,
                TMP.FTChnName,
                TMP.FTPmhStaType,
                TMP.FTSessionID
            FROM TCNTPdtPmtHDChn_Tmp TMP WITH(NOLOCK)
            WHERE TMP.FTSessionID = '$tUserSessionID'
            ORDER BY TMP.FTPmhStaType ASC, TMP.FTChnName ASC
        ";

        $oQuery = $this->db->query($tSQL);

        return $oQuery->result_array();
    }


    public function FSaMGetPdtPmtHDCstLevInTmp($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];

        $tSQL = "
            SELECT
                TMP.FTBchCode,
                TMP.FTPmhDocNo,
                TMP.FTClvCode,
                TMP.FTClvName,
                TMP.FTPmhStaType,
                TMP.FTSessionID
            FROM TCNTPdtPmtHDCstLev_Tmp TMP WITH(NOLOCK)
            WHERE TMP.FTSessionID = '$tUserSessionID'
            ORDER BY TMP.FTPmhStaType ASC, TMP.FTClvName ASC
        ";


        $oQuery = $this->db->query($tSQL);

        return $oQuery->result_array();
    }
}
