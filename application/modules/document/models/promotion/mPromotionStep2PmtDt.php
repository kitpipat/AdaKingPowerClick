<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mPromotionStep2PmtDt extends CI_Model
{
    /**
     * Functionality : Get PmtDt Group in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Data List PmtDt Group
     * Return Type : Array
     */
    public function FSaMGetPmtDtGroupInTmp($paParams = [])
    {
        $tGroupType = $paParams['tGroupType'];
        $tUserSessionID = $paParams['tUserSessionID'];
        $aRowLen = FCNaHCallLenData($paParams['nRow'], $paParams['nPage']);
        // $nLngID = $paParams['FNLngID'];

        $tSQL = "
            SELECT c.* FROM(
                SELECT  ROW_NUMBER() OVER(ORDER BY FTPmdGrpName ASC) AS FNRowID,* FROM
                    (SELECT DISTINCT
                        TMP.FTBchCode,
                        TMP.FTPmdStaType,
                        TMP.FTPmdGrpName,
                        TMP.FTPmdStaListType,
                        TMP.FTSessionID
                    FROM TCNTPdtPmtDT_Tmp TMP WITH(NOLOCK)
                    WHERE TMP.FTSessionID = '$tUserSessionID'
                    AND TMP.FTPmdStaType = '$tGroupType'
        ";

        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $nFoundRow = $this->FSnMTFWGetPmtDtGroupInTmpPageAll($paParams);
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
     * Functionality : Count PmtDt Group in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Count PmtDt Group
     * Return Type : Number
     */
    public function FSnMTFWGetPmtDtGroupInTmpPageAll($paParams = [])
    {
        $tGroupType = $paParams['tGroupType'];
        $tUserSessionID = $paParams['tUserSessionID'];
        $nLngID = $paParams['FNLngID'];

        $tSQL = "
            SELECT DISTINCT
                TMP.FTBchCode,
                TMP.FTPmdStaType,
                TMP.FTPmdGrpName,
                TMP.FTPmdStaListType,
                TMP.FTSessionID
            FROM TCNTPdtPmtDT_Tmp TMP WITH(NOLOCK) 
            WHERE TMP.FTSessionID = '$tUserSessionID'
            AND TMP.FTPmdStaType = '$tGroupType'
        ";

        $oQuery = $this->db->query($tSQL);
        return $oQuery->num_rows();
    }

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
            SELECT DISTINCT
                TMP.FTPmdGrpName
            FROM TCNTPdtPmtCB_Tmp TMP WITH(NOLOCK)
            WHERE TMP.FTSessionID = '$tUserSessionID'
            AND (TMP.FTPmdGrpName IS NOT NULL OR TMP.FTPmdGrpName <> '')
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
            SELECT DISTINCT
                TMP.FTPmdGrpName
            FROM TCNTPdtPmtCG_Tmp TMP WITH(NOLOCK)
            WHERE TMP.FTSessionID = '$tUserSessionID'
            AND (TMP.FTPmdGrpName IS NOT NULL OR TMP.FTPmdGrpName <> '')
        ";

        $oQuery = $this->db->query($tSQL);

        return $oQuery->result_array();
    }
}
