<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mPromotionStep4BchCondition extends CI_Model
{
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
        $aRowLen = FCNaHCallLenData($paParams['nRow'], $paParams['nPage']);
        // $nLngID = $paParams['FNLngID'];

        $tSQL = "
            SELECT c.* FROM(
                SELECT  ROW_NUMBER() OVER(ORDER BY FTPmhBchTo ASC, FTPmhMerTo ASC, FTPmhShpTo ASC) AS FNRowID,* FROM
                    (SELECT DISTINCT
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
        ";

        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $nFoundRow = $this->FSnMGetPdtPmtHDBchInTmpPageAll($paParams);
            $nPageAll = ceil($nFoundRow / $paParams['nRow']); // หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paParams['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        } else {
            // No Data
            $aResult = array(
                'rnAllRow' => 0,
                'rnCurrentPage' => $paParams['nPage'],
                "rnAllPage" => 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    /**
     * Functionality : Count PdtPmtHDBch in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Count PdtPmtHDBch
     * Return Type : Number
     */
    public function FSnMGetPdtPmtHDBchInTmpPageAll($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];

        $tSQL = "
            SELECT 
                FTSessionID
            FROM TCNTPdtPmtHDBch_Tmp TMP WITH(NOLOCK) 
            WHERE TMP.FTSessionID = '$tUserSessionID'
        ";

        $oQuery = $this->db->query($tSQL);
        return $oQuery->num_rows();
    }

    /**
     * Functionality : Insert PdtPmtHDBch to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMPdtPmtHDBchToTemp($paParams = [])
    {
        $tBchCodeLogin = $paParams['tBchCodeLogin'];
        $tUserSessionID = $paParams['tUserSessionID'];
        $tUserSessionDate = $paParams['tUserSessionDate'];

        $this->db->set('FTBchCode', $tBchCodeLogin);
        $this->db->set('FTPmhDocNo', $paParams['tDocNo']);
        $this->db->set('FTPmhAgnTo', $paParams['tAgnCode']);
        $this->db->set('FTPmhBchTo', $paParams['tBchCode']);
        $this->db->set('FTPmhMerTo', $paParams['tMerCode']);
        $this->db->set('FTPmhShpTo', $paParams['tShpCode']);
        $this->db->set('FTPmhAgnToName', $paParams['tAgnName']);
        $this->db->set('FTPmhBchToName', $paParams['tBchName']);
        $this->db->set('FTPmhMerToName', $paParams['tMerName']);
        $this->db->set('FTPmhShpToName', $paParams['tShpName']);
        $this->db->set('FTPmhStaType', '1'); // ประเภทกลุ่ม 1:กลุ่มร่วมรายการ 2:กลุ่มยกเว้น

        $this->db->set('FDCreateOn', $tUserSessionDate);
        $this->db->set('FTSessionID', $tUserSessionID);
        $this->db->insert('TCNTPdtPmtHDBch_Tmp');

        $aStatus = [
            'rtCode' => '905',
            'rtDesc' => 'Insert TCNTPdtPmtHDBch_Tmp Fail.',
        ];

        if ($this->db->affected_rows() > 0) {
            $aStatus['rtCode'] = '1';
            $aStatus['rtDesc'] = 'Insert TCNTPdtPmtHDBch_Tmp Success';
        }
        return $aStatus;
    }

    /**
     * Functionality : Update PmtCB Value in Temp by Primary Key
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Update
     * Return Type : Boolean
     */
    public function FSbUpdatePdtPmtHDBchInTmpByKey($paParams = [])
    {
        $this->db->set('FTPmhStaType', $paParams['tPmhStaType']);
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where('FTBchCode', $paParams['tBchCode']);
        $this->db->where('FTPmhDocNo', $paParams['tDocNo']);
        $this->db->where('FTPmhBchTo', $paParams['tBchCodeTo']);
        $this->db->where('FTPmhMerTo', $paParams['tMerCodeTo']);
        $this->db->where('FTPmhShpTo', $paParams['tShpCodeTo']);
        $this->db->update('TCNTPdtPmtHDBch_Tmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Delete PdtPmtHDBch in Temp by Primary Key
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Delete
     * Return Type : Boolean
     */
    public function FSbDeletePdtPmtHDBchInTmpByKey($paParams = [])
    {
        $this->db->where('FTBchCode', $paParams['tBchCode']);
        $this->db->where('FTPmhDocNo', $paParams['tDocNo']);
        $this->db->where('FTPmhBchTo', $paParams['tBchCodeTo']);
        $this->db->where('FTPmhMerTo', $paParams['tMerCodeTo']);
        $this->db->where('FTPmhShpTo', $paParams['tShpCodeTo']);
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->delete('TCNTPdtPmtHDBch_Tmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Clear PdtPmtHDBch in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Delete
     * Return Type : Boolean
     */
    public function FSbClearPdtPmtHDBchInTmp($paParams = [])
    {
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->delete('TCNTPdtPmtHDBch_Tmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Get PdtPmtHDBch in Temp By FTPmhBchTo
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : PdtPmtHDBch Data
     * Return Type : array
     */
    public function FSaMGetPdtPmtHDBchInTmpByBch($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];
        $tBchCode = $paParams['tBchCode'];

        $tSQL = "
            SELECT 
                TMP.FTPmhAgnTo,
                TMP.FTPmhBchTo,
                TMP.FTPmhMerTo,
                TMP.FTPmhShpTo
            FROM TCNTPdtPmtHDBch_Tmp TMP WITH(NOLOCK) 
            WHERE TMP.FTSessionID = '$tUserSessionID'
            AND TMP.FTPmhBchTo = '$tBchCode'
            ORDER BY TMP.FTPmhBchTo ASC, TMP.FTPmhMerTo ASC, TMP.FTPmhShpTo ASC 
        ";

        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array();
    }
}
