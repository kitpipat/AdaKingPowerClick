<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mPromotionStep3Point extends CI_Model
{
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
        $nLangEdit = $this->session->userdata("tLangEdit");

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
                TMP.FTSessionID,
                TMP.FTSplCode,
                SPL.FTSplName,
                CONVERT(CHAR(10),TMP.FDPgtPntStart,120) AS FDPgtPntStart,
                CONVERT(CHAR(10),TMP.FDPgtPntExpired,120) AS FDPgtPntExpired

            FROM TCNTPdtPmtCG_Tmp TMP WITH(NOLOCK)
            LEFT JOIN TCNMSpl_L SPL ON TMP.FTSplCode = SPL.FTSplCode AND SPL.FNLngID = '$nLangEdit'
            WHERE TMP.FTSessionID = '$tUserSessionID'
            AND (TMP.FTPgtStaPoint IS NOT NULL OR TMP.FTPgtStaPoint <> '')
            AND (TMP.FTPmdGrpName IS NULL OR TMP.FTPmdGrpName = '')
            AND TMP.FNPgtSeq = -2
        ";

        $oQuery = $this->db->query($tSQL);

        return $oQuery->row_array();
    }

    /**
     * Functionality : Insert or Update Point to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMAddUpdatePointInTemp($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];
        $tUserSessionDate = $paParams['tUserSessionDate'];
        $tBchCodeLogin = $paParams['tBchCodeLogin'];
        
        // Update Point
        $this->db->set('FTBchCode', $tBchCodeLogin);
        $this->db->set('FTPgtStaPoint', $paParams['tPgtStaPoint']);
        $this->db->set('FTPgtStaPntCalType', $paParams['tPgtStaPntCalType']);
        $this->db->set('FNPgtPntBuy', $paParams['tPgtPntBuy']);
        $this->db->set('FNPgtPntGet', $paParams['tPgtPntGet']);
        $this->db->set('FTSplCode', $paParams['tPgtSplCode']);
        $this->db->set('FDPgtPntStart', $paParams['tPgtDateStart']);
        $this->db->set('FDPgtPntExpired', $paParams['tPgtDateEnd']);
        $this->db->where('FTSessionID', $tUserSessionID);
        $this->db->where('FTPmhDocNo', $paParams['tDocNo']);
        $this->db->where("(FTPmdGrpName IS NULL OR FTPmdGrpName = '')");
        $this->db->where("FTPgtStaPoint IS NOT NULL");
        $this->db->where("FTPgtStaPoint <> ''");
        $this->db->where("FNPgtSeq = -2");
        $this->db->update('TCNTPdtPmtCG_Tmp');
        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update Point Success',
            );
        } else {
            // Add Point
            $this->db->set('FTBchCode', $tBchCodeLogin);
            $this->db->set('FTPmhDocNo', $paParams['tDocNo']);
            $this->db->set('FNPgtSeq', -2);
            $this->db->set('FTPgtStaPoint', $paParams['tPgtStaPoint']);
            $this->db->set('FTPgtStaPntCalType', $paParams['tPgtStaPntCalType']);
            $this->db->set('FTPgtStaGetType', '6');
            $this->db->set('FNPgtPntBuy', $paParams['tPgtPntBuy']);
            $this->db->set('FNPgtPntGet', $paParams['tPgtPntGet']);
            $this->db->set('FTSplCode', $paParams['tPgtSplCode']);
            $this->db->set('FDPgtPntStart', $paParams['tPgtDateStart']);
            $this->db->set('FDPgtPntExpired', $paParams['tPgtDateEnd']);
            $this->db->set('FDCreateOn', $tUserSessionDate);
            $this->db->set('FTSessionID', $tUserSessionID);
            $this->db->insert('TCNTPdtPmtCG_Tmp');
            
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Point Success',
                );
            } else {
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit Point.',
                );
            }
        }
        return $aStatus;
    }

    /**
     * Functionality : Update Point Value in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Update
     * Return Type : Boolean
     */
    /* public function FSbUpdatePointInTmp($paParams = [])
    {
        $this->db->set('FTPmdGrpName', $paParams['tPmtGroupNameTmp']);
        $this->db->where('FTPmdGrpName', $paParams['tPmtGroupNameTmpOld']);
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->update('TCNTPdtPoint_Tmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    } */

    /**
     * Functionality : Delete Point in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Delete
     * Return Type : Boolean
     */
    public function FSbDeletePointInTmp($paParams = [])
    {
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where('FTPmhDocNo', $paParams['tDocNo']);
        $this->db->where("(FTPmdGrpName IS NULL OR FTPmdGrpName = '')");
        $this->db->where("FTPgtStaPoint IS NOT NULL");
        $this->db->where("FTPgtStaPoint <> ''");
        $this->db->where("FNPgtSeq = -2");
        $this->db->delete('TCNTPdtPmtCG_Tmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }
}
